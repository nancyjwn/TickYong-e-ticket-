<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Booking;
use App\Models\Ticket;
use App\Models\Event;
use App\Models\User;

class AdminController extends Controller
{
    // Fungsi untuk menampilkan dashboard
    public function dashboard()
    {
        $events = Event::with('category')->get(); // Eager load category
        return view('dashboard.admin.home', compact('events')); // Pass $events to the view
    }

    public function showEvent($id)
    {
        // Fetch the event along with its related data (e.g., category, tickets)
        $event = Event::with('category', 'tickets')->findOrFail($id);

        // Return a view to show event details
        return view('dashboard.admin.events.show', compact('event'));
    }

    // Fungsi untuk menampilkan form tambah event
    public function createEvent()
    {
        // Ambil semua kategori dari database
        $categories = Category::all();
        // Kirim data kategori ke view
        return view('dashboard.admin.events.create', compact('categories'));
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

        return redirect()->route('admin.events.index')->with('success', 'Event created successfully.');
    }

    // Fungsi untuk mengelola acara
    public function manageEvents(Request $request)
    {
        // Pastikan hanya admin yang bisa mengakses halaman ini
        if (Auth::user()->role !== 'admin') {
            abort(403); // Tampilkan halaman forbidden jika bukan admin
        }

        $categories = Category::all();
        $query = Event::with('category');

        if ($request->has('category') && $request->category != '') {
            $query->where('category_id', $request->category);
        }

        $events = $query->get();

        // Kirim data $events ke view
        return view('dashboard.admin.events.index', compact('events', 'categories'));
    }

    // Fungsi untuk menampilkan form edit acara
    public function editEvent($id)
    {
        $event = Event::with('tickets')->findOrFail($id);
        $categories = Category::all();
        return view('dashboard.admin.events.edit', compact('event', 'categories'));
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

        return redirect()->route('admin.events.index')->with('success', 'Event updated successfully.');
    }

    // Fungsi untuk menghapus acara
    public function deleteEvent($id)
    {
        $event = Event::findOrFail($id); // Ambil data event berdasarkan ID
        $event->delete(); // Hapus data event

        return redirect()->route('admin.events.index')->with('success', 'Event deleted successfully.');
    }

    // Fungsi untuk menampilkan daftar pengguna
    public function manageUsers()
    {
        $users = User::all(); // Mengambil semua pengguna
        return view('dashboard.admin.users.index', compact('users'));
    }

    // Fungsi untuk menampilkan form edit pengguna
    public function editUser($id)
    {
        $user = User::findOrFail($id);
        // dd($user); <-- Hapus ini jika debugging selesai.
        return view('dashboard.admin.users.edit', compact('user'));
    }

    // Fungsi untuk memperbarui data pengguna
    public function updateUser(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'required|in:admin,event_organizer,user',
        ]);

        $user = User::findOrFail($id);
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->role = $validated['role'];

        if ($request->filled('password')) {
            $user->password = bcrypt($validated['password']);
        }

        $user->save();

        return redirect()->route('admin.users')->with('success', 'User updated successfully.');
    }

    public function deleteUser($id)
    {
        $user = User::find($id);

        if (!$user) {
            dd("User with ID $id not found");
        }

        $user->delete();
        return redirect()->route('admin.users')->with('success', 'User deleted successfully.');
    }

    public function createUser()
    {
        return view('dashboard.admin.users.create'); // Arahkan ke view form Create User
    }
    public function storeUser(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'required|in:admin,event_organizer,user',
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
            'role' => $validated['role'],
        ]);

        return redirect()->route('admin.users')->with('success', 'User created successfully.');
    }

    public function viewBookings($event_id = null)
    {
        // Jika ada event_id, tampilkan bookings untuk event tertentu
        if ($event_id) {
            $event = Event::with('bookings.user')->find($event_id);

            if (!$event) {
                abort(404, 'Event not found.');
            }

            return view('dashboard.admin.bookings.index', compact('event'));
        }

        // Jika tidak ada event_id, tampilkan semua events dengan bookings
        $events = Event::with('bookings.user')->get();

        // Generate Sales Report
        $salesReport = Booking::selectRaw('event_id, COUNT(*) as total_bookings, SUM(quantity) as total_tickets, SUM(total_price) as total_revenue')
            ->with('event') // Sertakan informasi event
            ->groupBy('event_id')
            ->get();

        // Generate Status Statistics
        $statusStats = Booking::selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status');

        return view('dashboard.admin.bookings.all', compact('events', 'salesReport', 'statusStats'));
    }

    public function updateBookingStatus(Request $request, $id)
    {
        // Validasi input status
        $request->validate([
            'status' => 'required|in:approved,canceled',
        ]);

        // Cari booking berdasarkan ID
        $booking = Booking::findOrFail($id);

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
        return view('dashboard.admin.events.index', compact('events', 'searchTerm'));
    }

    public function reportsData()
    {
        // Fetch events with related bookings
        $events = Event::with('bookings.user')->get();

        // Sales report: Total bookings, tickets sold, and revenue per event
        $salesReport = Booking::selectRaw('event_id, COUNT(*) as total_bookings, SUM(quantity) as total_tickets, SUM(total_price) as total_revenue')
            ->groupBy('event_id')
            ->get();

        // Event names and total revenue and tickets for charts
        $eventNames = $events->pluck('name');
        $totalRevenuePerEvent = $salesReport->pluck('total_revenue');
        $totalTicketsPerEvent = $salesReport->pluck('total_tickets');

        // Booking status statistics: approved, pending, canceled
        $statusStats = Booking::selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status');

        // General statistics
        $totalUsers = User::count(); // Total users
        $totalOrganizers = User::where('role', 'organizer')->count(); // Total organizers
        $totalBookings = Booking::count(); // Total bookings

        return view('dashboard.admin.reports.index', compact('eventNames', 'totalRevenuePerEvent', 'totalTicketsPerEvent', 'statusStats', 'totalUsers', 'totalOrganizers', 'totalBookings'));
    }
}
