<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Review;
use App\Models\Booking;
use App\Models\Category;
use App\Models\Favorite;
use Illuminate\Support\Facades\Auth;

class UserDashboardController extends Controller
{
    public function index(Request $request)
    {
        // Ambil kategori dari query string jika ada
        $categoryId = $request->query('category');

        // Ambil 6 acara terbaru, dengan filter kategori jika ada
        $latestEvents = Event::query()
            ->when($categoryId, function ($query) use ($categoryId) {
                $query->where('category_id', $categoryId);
            })
            ->with('tickets') // Eager load tickets
            ->latest()
            ->take(6)
            ->get();

        // Ambil 5 acara populer berdasarkan jumlah review terbanyak
        $popularEvents = Event::query()
            ->withCount('reviews') // Menghitung jumlah komentar/review
            ->orderBy('reviews_count', 'desc') // Urutkan berdasarkan jumlah review terbanyak
            ->take(5) // Batasi hanya 5 event
            ->get();

        // Ambil semua kategori untuk filter
        $categories = Category::all();

        // Ambil nama kategori yang dipilih untuk ditampilkan
        $categoryName = $categoryId ? Category::find($categoryId)?->name : null;

        // Ambil riwayat pemesanan pengguna
        $bookings = Booking::with('event')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        // Melempar data ke view
        return view('dashboard.user.home', compact(
            'latestEvents',
            'popularEvents',
            'categories',
            'categoryName',
            'bookings'
        ));
    }

    public function show($event_id)
    {
        // Ambil detail event beserta relasi tickets dan reviews.user
        $event = Event::with(['tickets', 'reviews.user'])->findOrFail($event_id);

        // Cek apakah user yang login dapat memberikan review
        $canReview = false;
        if (Auth::check()) {
            $canReview = Booking::where('event_id', $event_id)
                ->where('user_id', Auth::id())
                ->where('status', 'approved')
                ->exists();
        }

        return view('dashboard.user.events.show', compact('event', 'canReview'));
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $categoryId = $request->input('category');

        // Cari event berdasarkan nama, lokasi, deskripsi, dan kategori
        $events = Event::when($query, function ($queryBuilder) use ($query) {
            return $queryBuilder->where('name', 'LIKE', "%$query%")
                ->orWhere('location', 'LIKE', "%$query%")
                ->orWhere('description', 'LIKE', "%$query%");
        })
            ->when($categoryId, function ($queryBuilder) use ($categoryId) {
                return $queryBuilder->where('category_id', $categoryId);
            })
            ->get();

        // Ambil semua kategori untuk dropdown
        $categories = Category::all();

        // Jika request AJAX, return hanya bagian hasil pencarian
        if ($request->ajax()) {
            return view('dashboard.user.events', compact('events'));  // Pastikan view hanya menampilkan grid events
        }

        return view('dashboard.user.search', compact('events', 'categories'));
    }

    public function events(Request $request)
    {
        // Fetch all categories
        $categories = Category::all();

        // Filter events based on search query and category
        $events = Event::query()
            ->when($request->input('query'), function ($query) use ($request) {
                return $query->where('name', 'like', '%' . $request->input('query') . '%');
            })
            ->when($request->input('category'), function ($query) use ($request) {
                return $query->where('category_id', $request->input('category'));
            })
            ->get();

        return view('dashboard.user.events.index', compact('events', 'categories'));
    }

    public function showBookingForm($event_id, $ticket_type)
    {
        // Fetch event and related tickets
        $event = Event::with('tickets')->findOrFail($event_id);

        // Find the ticket based on type
        $ticket = $event->tickets->where('type', $ticket_type)->first();

        // Return 404 if ticket type is not found
        if (!$ticket) {
            abort(404, 'Ticket type not found.');
        }

        // Pass data to the view
        return view('dashboard.user.bookings.index', [
            'event' => $event,
            'ticket' => $ticket,
            'ticketType' => $ticket_type,
        ]);
    }

    public function bookTicket(Request $request, $event_id, $ticket_type)
    {
        // Ambil event dan tiket
        $event = Event::with('tickets')->findOrFail($event_id);
        $ticket = $event->tickets->where('type', $ticket_type)->first();

        if (!$ticket) {
            abort(404, 'Ticket type not found.');
        }

        // Validasi input
        $validated = $request->validate([
            'quantity' => 'required|integer|min:1|max:' . $ticket->quota,
        ]);

        // Kurangi quota tiket
        $ticket->decrement('quota', $validated['quantity']);

        // Hitung total harga
        $total_price = $ticket->price * $validated['quantity'];

        // Simpan booking ke database
        Booking::create([
            'user_id' => Auth::id(),
            'event_id' => $event->id,
            'type' => $ticket_type,
            'quantity' => $validated['quantity'],
            'total_price' => $total_price,
            'status' => 'pending',
        ]);

        // Redirect ke halaman event dengan pesan sukses
        return redirect()->route('dashboard.user.events.show', ['id' => $event->id])
            ->with('success', 'Booking successful! You have successfully booked ' . $validated['quantity'] . ' ' . strtoupper($ticket_type) . ' ticket(s).');
    }

    public function viewBookingForm(Request $request, $event_id, $ticket_type = null)
    {
        // Get the event
        $event = Event::with('tickets')->findOrFail($event_id);

        // If a ticket type is provided, fetch the specific ticket for the booking form
        if ($ticket_type) {
            $ticket = $event->tickets->where('type', $ticket_type)->first();

            if (!$ticket) {
                abort(404, 'Ticket type not found.');
            }

            // Render the booking form
            return view('dashboard.user.bookings.form', compact('event', 'ticket', 'ticket_type'));
        }

        // If no ticket type, fetch all bookings for this event
        $bookings = Booking::where('user_id', Auth::id())->where('event_id', $event_id)->get();

        // Render the bookings list view
        return view('dashboard.user.bookings.index', compact('event', 'bookings'));
    }

    public function cancelBooking($booking_id)
    {
        // Ambil booking dengan data event
        $booking = Booking::with('event')->findOrFail($booking_id);

        // Verifikasi bahwa hanya user pemilik yang dapat membatalkan
        if ($booking->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Pastikan hanya booking dengan status 'pending' atau 'confirmed' yang dapat dibatalkan
        if (!in_array($booking->status, ['pending', 'confirmed'])) {
            return redirect()->route('user.bookings.history')
                ->with('error', 'Booking cannot be canceled.');
        }

        // Restore ticket quota (menambahkan kembali kuota tiket)
        $ticket = $booking->event->tickets->where('type', $booking->type)->first();
        if ($ticket) {
            $ticket->increment('quota', $booking->quantity);
        }

        // Update status booking menjadi 'canceled'
        $booking->update(['status' => 'canceled']);

        return redirect()->route('user.bookings.history')->with('success', 'Your booking has been successfully canceled.');
    }

    // View Booking History
    public function bookingHistory()
    {
        // Ambil semua bookings milik user yang sedang login
        $bookings = Booking::with('event')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        // Lempar data bookings ke view
        return view('dashboard.user.bookings.history', compact('bookings'));
    }

    public function viewFavorites()
    {
        // Check if the user is authenticated
        if (Auth::check()) {
            // If authenticated, fetch the user's favorites with the event relationship
            $favorites = Auth::user()->favorites()->with('event')->get();
            return view('dashboard.user.events.favorite', compact('favorites'));
        } else {
            // If not authenticated, you can redirect the user to login page or show an appropriate message
            return redirect()->route('login')->with('error', 'You must be logged in to view your favorites.');
        }
    }

    public function removeFavorite($eventId)
    {
        // Cari favorit berdasarkan user_id dan event_id
        $favorite = Favorite::where('user_id', Auth::id())
            ->where('event_id', $eventId)
            ->first();

        if ($favorite) {
            $favorite->delete(); // Hapus favorit
            return redirect()->route('user.events.favorite')->with('success', 'Event removed from favorites.');
        }

        return redirect()->route('user.events.favorite')->with('error', 'Event not found in your favorites.');
    }

    public function submitReview(Request $request, $eventId)
    {
        $request->validate([
            'review' => 'required|max:500',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        // Pastikan hanya user dengan role 'user' yang dapat memberikan ulasan
        if (Auth::user()->role !== 'user') {
            return redirect()->back()->with('error', 'Only regular users can leave a review.');
        }

        // Cek apakah user sudah memiliki booking untuk event ini
        $userBooking = Auth::user()->bookings()->where('event_id', $eventId)->first();
        if (!$userBooking) {
            return redirect()->back()->with('error', 'You can only review events you have attended.');
        }

        // Cek apakah user sudah memberikan ulasan untuk event ini
        $existingReview = Review::where('event_id', $eventId)
            ->where('user_id', Auth::id())
            ->first();
        if ($existingReview) {
            return redirect()->back()->with('error', 'You have already reviewed this event.');
        }

        // Simpan ulasan
        Review::create([
            'event_id' => $eventId,
            'user_id' => Auth::id(),
            'review' => $request->input('review'),
            'rating' => $request->input('rating'),
        ]);

        return redirect()->back()->with('success', 'Thank you for your review!');
    }
}
