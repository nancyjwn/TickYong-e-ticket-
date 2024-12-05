<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Ticket;
use App\Models\Booking;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


class OrganizerDashboardController extends Controller
{
    public function index()
    {
        $totalEvents = Event::where('created_by', Auth::id())->count();
        $totalBookings = Booking::whereHas('event', function ($query) {
            $query->where('created_by', Auth::id());
        })->count();
        $totalRevenue = Booking::whereHas('event', function ($query) {
            $query->where('created_by', Auth::id());
        })->sum('total_price');

        // Fetch all events for the organizer
        $events = Event::where('created_by', Auth::id())->get();

        return view('dashboard.organizer.home', compact('totalEvents', 'totalBookings', 'totalRevenue', 'events'));
    }

    public function showEvent($id)
    {
        // Fetch the event along with its related data (e.g., category, tickets)
        $event = Event::with('category', 'tickets')->findOrFail($id);

        // Return a view to show event details
        return view('dashboard.organizer.events.show', compact('event'));
    }

    // Fungsi untuk menampilkan form tambah event
    public function createEvent()
    {
        // Ambil semua kategori dari database
        $categories = Category::all();
        return view('dashboard.organizer.events.create', compact('categories'));
    }

    // Fungsi untuk menyimpan event baru
    public function storeEvent(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'date_time' => 'required|date',
            'end_event_date' => 'nullable|date|after:date_time',
            'location' => 'required|string|max:255',
            'ticket_prices' => 'required|array',
            'ticket_prices.vvip' => 'required|numeric|min:0',
            'ticket_prices.vip' => 'required|numeric|min:0',
            'ticket_prices.regular' => 'required|numeric|min:0',
            'ticket_quotas' => 'required|array',
            'ticket_quotas.vvip' => 'required|integer|min:0',
            'ticket_quotas.vip' => 'required|integer|min:0',
            'ticket_quotas.regular' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('events', 'public');
            $validated['image'] = $imagePath;
        }

        $validated['created_by'] = Auth::id();
        $validated['organizer_id'] = Auth::id();

        $event = Event::create([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'date_time' => $validated['date_time'],
            'end_event_date' => $validated['end_event_date'],
            'location' => $validated['location'],
            'category_id' => $validated['category_id'],
            'image' => $validated['image'] ?? null,
            'created_by' => Auth::id(),
            'organizer_id' => Auth::id(),
        ]);

        foreach (['vvip', 'vip', 'regular'] as $type) {
            Ticket::create([
                'event_id' => $event->id,
                'type' => $type,
                'price' => $validated['ticket_prices'][$type],
                'quota' => $validated['ticket_quotas'][$type],
                'status' => 'pending',
            ]);
        }

        return redirect()->route('organizer.events.index')->with('success', 'Event created successfully.');
    }

    // Fungsi untuk mengelola acara
    public function manageEvents(Request $request)
    {
        // Pastikan hanya organizer yang bisa mengakses halaman ini
        if (Auth::user()->role !== 'event_organizer') {
            abort(403); // Tampilkan halaman forbidden jika bukan organizer
        }

        $categories = Category::all();
        $query = Event::where('created_by', Auth::id()) // Only fetch events created by the logged-in organizer
            ->with('category');

        if ($request->has('category') && $request->category != '') {
            $query->where('category_id', $request->category);
        }

        $events = $query->get();

        // Kirim data $events ke view
        return view('dashboard.organizer.events.index', compact('events', 'categories'));
    }

    // Fungsi untuk menampilkan form edit acara
    public function editEvent($id)
    {
        $event = Event::with('tickets')->findOrFail($id);
        // Check if the authenticated user is the creator of the event
        if ($event->created_by !== Auth::id()) {
            abort(403, 'You are not authorized to edit this event.');
        }
        $categories = Category::all();
        return view('dashboard.organizer.events.edit', compact('event', 'categories'));
    }

    // Fungsi untuk memperbarui acara
    public function updateEvent(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'date_time' => 'required|date', // Pastikan selalu diisi
            'end_event_date' => 'nullable|date|after:date_time', // Optional, tapi tetap validasi jika ada
            'location' => 'required|string|max:255',
            'ticket_prices' => 'required|array',
            'ticket_prices.vvip' => 'required|numeric|min:0',
            'ticket_prices.vip' => 'required|numeric|min:0',
            'ticket_prices.regular' => 'required|numeric|min:0',
            'ticket_quotas' => 'required|array',
            'ticket_quotas.vvip' => 'required|integer|min:0',
            'ticket_quotas.vip' => 'required|integer|min:0',
            'ticket_quotas.regular' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        $event = Event::findOrFail($id);

        // Check if the authenticated user is the creator of the event
        if ($event->created_by !== Auth::id()) {
            return redirect()->route('organizer.events.index')->with('error', 'You are not authorized to update this event.');
        }

        // Update fields
        $event->update([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'date_time' => $validated['date_time'], // Pastikan field ini tidak null
            'end_event_date' => $validated['end_event_date'] ?? $event->end_event_date, // Gunakan nilai lama jika tidak diisi
            'location' => $validated['location'],
            'category_id' => $validated['category_id'],
        ]);

        // Update image if uploaded
        if ($request->hasFile('image')) {
            if ($event->image) {
                Storage::disk('public')->delete($event->image);
            }
            $event->image = $request->file('image')->store('events', 'public');
            $event->save();
        }

        // Update ticket prices and quotas
        foreach (['vvip', 'vip', 'regular'] as $type) {
            $ticket = $event->tickets->where('type', $type)->first();
            if ($ticket) {
                $ticket->update([
                    'price' => $validated['ticket_prices'][$type],
                    'quota' => $validated['ticket_quotas'][$type],
                ]);
            }
        }

        return redirect()->route('organizer.events.index')->with('success', 'Event updated successfully.');
    }

    // Fungsi untuk menghapus acara
    public function deleteEvent($id)
    {
        $event = Event::findOrFail($id); // Temukan event berdasarkan ID
        // Check if the authenticated user is the creator of the event
        if ($event->created_by !== Auth::id()) {
            return redirect()->route('organizer.events.index')->with('error', 'You are not authorized to delete this event.');
        }
        $event->delete(); // Hapus event dari database

        // Redirect ke halaman daftar event dengan pesan sukses
        return redirect()->route('organizer.events.index')->with('success', 'Event deleted successfully.');
    }

    public function viewBookings($event_id = null)
    {
        // Jika ada event_id, tampilkan bookings untuk event tersebut
        if ($event_id) {
            $event = Event::where('created_by', Auth::id()) // Filter event yang dibuat oleh organizer yang login
                ->with('bookings.user') // Termasuk data booking
                ->find($event_id);

            if (!$event) {
                abort(403, 'You are not authorized to view bookings for this event.');
            }

            return view('dashboard.organizer.bookings.index', compact('event'));
        }

        // Tampilkan semua booking yang terkait dengan event yang dimiliki oleh organizer
        $events = Event::where('created_by', Auth::id())->with('bookings.user')->get();

        // Generate Sales Report
        $salesReport = Booking::selectRaw('event_id, COUNT(*) as total_bookings, SUM(quantity) as total_tickets, SUM(total_price) as total_revenue')
            ->with('event') // Sertakan informasi event
            ->groupBy('event_id')
            ->get();

        // Generate Status Statistics
        $statusStats = Booking::selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status');

        return view('dashboard.organizer.bookings.all', compact('events', 'salesReport', 'statusStats'));
    }

    public function updateBookingStatus(Request $request, $id)
    {
        // Validasi input status
        $request->validate([
            'status' => 'required|in:approved,canceled',
        ]);

        // Cari booking berdasarkan ID
        $booking = Booking::findOrFail($id);

        // Ensure the booking's associated event was created by the authenticated organizer
        $event = $booking->event;
        if ($event->created_by !== Auth::id()) {
            return redirect()->back()->with('error', 'You are not authorized to update the status of this booking.');
        }

        // Cek apakah status booking sudah canceled
        if ($booking->status === 'canceled') {
            return redirect()->back()->with('error', 'This booking has already been canceled and cannot be updated.');
        }

        // Update status booking
        $booking->status = $request->status;
        $booking->save();

        // Redirect kembali dengan pesan sukses
        return redirect()->back()->with('success', 'Booking status updated successfully.');
    }

    // Fungsi untuk mencari kategori
    public function searchCategories(Request $request)
    {
        $searchTerm = $request->input('search'); // Ambil query pencarian
        $query = Event::with('category'); // Mulai query dengan relasi category

        // Jika ada kata kunci pencarian, tambahkan filter kategori
        if ($searchTerm) {
            $query->whereHas('category', function ($q) use ($searchTerm) {
                $q->where('name', 'LIKE', "%{$searchTerm}%");
            });
        }

        // Ambil semua event berdasarkan filter
        $events = $query->get();

        // Kirim data ke view
        return view('dashboard.organizer.events.index', compact('events', 'searchTerm'));
    }
}
