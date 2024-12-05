<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\OrganizerDashboardController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

Route::get('/dashboard', function () {
    if (Auth::user()->role === 'admin') {
        return redirect()->route('admin.dashboard');
    } elseif (Auth::user()->role === 'event_organizer') {
        return redirect()->route('organizer.dashboard');
    } else {
        return redirect()->route('user.dashboard');
    }
})->name('dashboard');

Route::post('/favorites', [FavoriteController::class, 'store'])->name('favorites.store');

Route::middleware('admin')->group(function () {
    // Route untuk mengelola users
    Route::get('/admin/users', [AdminController::class, 'manageUsers'])->name('admin.users');
    Route::get('/admin/users/create', [AdminController::class, 'createUser'])->name('admin.users.create');
    Route::post('/admin/users', [AdminController::class, 'storeUser'])->name('admin.users.store');
    Route::get('/admin/users/{id}/edit', [AdminController::class, 'editUser'])->name('admin.users.edit');
    Route::put('/admin/users/{id}', [AdminController::class, 'updateUser'])->name('admin.users.update');
    Route::delete('/admin/users/{id}', [AdminController::class, 'deleteUser'])->name('admin.users.delete');
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    // Route untuk mengelola events
    Route::get('/admin/events', [AdminController::class, 'manageEvents'])->name('admin.events.index');
    Route::get('/admin/events/create', [AdminController::class, 'createEvent'])->name('admin.events.create');
    Route::post('/admin/events', [AdminController::class, 'storeEvent'])->name('admin.events.store');
    Route::get('/admin/events/{id}/edit', [AdminController::class, 'editEvent'])->name('admin.events.edit');
    Route::get('/admin/events/{id}', [AdminController::class, 'showEvent'])->name('admin.events.show');
    Route::put('/admin/events/{id}', [AdminController::class, 'updateEvent'])->name('admin.events.update');
    Route::delete('/admin/events/{id}', [AdminController::class, 'deleteEvent'])->name('admin.events.destroy');

    // Route untuk kelola bookings
    Route::get('/admin/bookings', [AdminController::class, 'viewBookings'])->name('admin.bookings.index');
    Route::post('/admin/bookings/{id}/approve', [AdminController::class, 'approveBooking'])->name('admin.bookings.approve');
    Route::post('/admin/bookings/{id}/cancel', [AdminController::class, 'cancelBooking'])->name('admin.bookings.cancel');
    Route::get('/admin/reports', [AdminController::class, 'reportsData'])->name('admin.reports.index');
    Route::patch('admin/bookings/{id}', [AdminController::class, 'updateBookingStatus'])->name('admin.bookings.update');

    Route::get('admin/categories/search', [AdminController::class, 'searchCategories'])->name('admin.events.search');
});

Route::middleware('event_organizer')->group(function () {
    // Dashboard Organizer
    Route::get('/event_organizer/dashboard', [OrganizerDashboardController::class, 'index'])->name('event_organizer.dashboard');

    // Rute untuk Manage Events oleh Organizer
    Route::get('/organizer/events', [OrganizerDashboardController::class, 'manageEvents'])->name('organizer.events.index');
    Route::get('/organizer/events/create', [OrganizerDashboardController::class, 'createEvent'])->name('organizer.events.create');
    Route::post('/organizer/events/store', [OrganizerDashboardController::class, 'storeEvent'])->name('organizer.events.store');
    Route::get('/organizer/events/{id}/edit', [OrganizerDashboardController::class, 'editEvent'])->name('organizer.events.edit');
    Route::get('/organizer/events/{id}', [OrganizerDashboardController::class, 'showEvent'])->name('organizer.events.show');
    Route::put('/organizer/events/{id}', [OrganizerDashboardController::class, 'updateEvent'])->name('organizer.events.update');
    Route::delete('/organizer/events/{id}', [OrganizerDashboardController::class, 'deleteEvent'])->name('organizer.events.destroy');

    Route::get('organizer/categories/search', [OrganizerDashboardController::class, 'searchCategories'])->name('organizer.events.search');

    // Rute untuk melihat daftar pemesanan oleh organizer
    Route::get('/organizer/bookings', [OrganizerDashboardController::class, 'viewBookings'])->name('organizer.bookings.index');
    Route::get('organizer/bookings/{event_id?}', [OrganizerDashboardController::class, 'viewBookings'])->name('organizer.bookings');
    Route::get('organizer/bookings', [OrganizerDashboardController::class, 'viewBookings'])->name('organizer.bookings.all');
    Route::get('organizer/bookings/{event_id}', [OrganizerDashboardController::class, 'viewBookings'])->name('organizer.bookings.event');
    Route::patch('/organizer/bookings/{id}/satatus', [OrganizerDashboardController::class, 'updateBookingStatus'])->name('organizer.bookings.update');
});

// Route untuk User Dashboard
    // Dashboard User
    Route::get('/user/dashboard', [UserDashboardController::class, 'index'])->name('user.dashboard');
    Route::get('/user/search', [UserDashboardController::class, 'search'])->name('user.search');
    Route::post('user/events/favorites', [FavoriteController::class, 'store'])->name('favorites.store');
    Route::get('user/events/favorites', [UserDashboardController::class, 'viewFavorites'])->name('user.events.favorite');
    Route::delete('/user/events/favorites/{event}', [UserDashboardController::class, 'removeFavorite'])->name('user.events.remove_favorite');
    Route::get('/user/events/{id}', [UserDashboardController::class, 'show'])->name('events.show');
    Route::get('/user/events', [UserDashboardController::class, 'events'])->name('user.events.index');
    Route::get('/user/events/{event}', [UserDashboardController::class, 'show'])->name('dashboard.user.events.show');
    Route::post('user/events/{event}/reviews', [UserDashboardController::class, 'submitReview'])->name('user.events.submitReview');
    Route::get('/user/search', [UserDashboardController::class, 'search'])->name('user.search');

    Route::middleware('auth')->group(function () {
    // booking tiket oleh user
    Route::get('user/bookings/history', [UserDashboardController::class, 'bookingHistory'])->name('user.bookings.history');
    Route::post('/user/bookings/{booking_id}/cancel', [UserDashboardController::class, 'cancelBooking'])->name('user.bookings.cancel');
    Route::get('user/bookings/{event_id}/{ticket_type?}', [UserDashboardController::class, 'viewBookingForm'])->name('user.book');
    Route::post('user/bookings/{event_id}/{ticket_type}', [UserDashboardController::class, 'bookTicket'])->name('user.book.ticket'); // Proses pemesanan tiket
});

Route::get('/organizer/dashboard', [OrganizerDashboardController::class, 'index'])->name('organizer.dashboard');

// Route umum
Route::get('/', [UserDashboardController::class, 'index']);
Route::get('/event', [UserDashboardController::class, 'events'])->name('events.index');
Route::get('/events/{id}', [UserDashboardController::class, 'show'])->name('dashboard.user.events.show'); // Detail event
Route::get('/dashboard/user/events', [UserDashboardController::class, 'events'])->name('dashboard.user.events.index');  // <-- Added this route
Route::get('/dashboard/events/search', [UserDashboardController::class, 'search'])->name('dashboard.events.search');
Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');


// Tambahkan rute profil di sini
Route::middleware('auth')->group(function () {
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
});

require __DIR__ . '/auth.php';
