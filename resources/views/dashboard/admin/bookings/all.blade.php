@extends('layouts.master')

@section('content')
    <div class="container mx-auto px-4 py-8 space-y-8">
        <!-- Page Title with Back Button -->
        <div class="flex items-center space-x-4">
            <a href="{{ route('admin.dashboard') }}"
                class="flex items-center justify-center w-12 h-12 bg-orange-200 text-red-950 rounded-full shadow-md">
                <i class="fas fa-arrow-left text-lg"></i>
            </a>
            <h1 class="text-4xl font-extrabold text-red-950">Bookings for All Events</h1>
        </div>

        <!-- Notification Component -->
        @include('components.notif-admin-booking')

        <!-- Booking Status Summary -->
        <div class="bg-gradient-to-r from-red-200 to-orange-200 text-white shadow-lg rounded-lg p-8">
            <h2 class="text-3xl font-bold mb-6 text-center">Booking Status Summary</h2>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 text-center">
                <!-- Approved -->
                <div class="bg-white text-green-600 rounded-lg shadow-lg p-6 hover:shadow-xl transition">
                    <h3 class="text-4xl font-extrabold">{{ $statusStats['approved'] ?? 0 }}</h3>
                    <p class="text-xl mt-2">Approved</p>
                </div>

                <!-- Pending -->
                <div class="bg-white text-yellow-500 rounded-lg shadow-lg p-6 hover:shadow-xl transition">
                    <h3 class="text-4xl font-extrabold">{{ $statusStats['pending'] ?? 0 }}</h3>
                    <p class="text-xl mt-2">Pending</p>
                </div>

                <!-- Canceled -->
                <div class="bg-white text-red-600 rounded-lg shadow-lg p-6 hover:shadow-xl transition">
                    <h3 class="text-4xl font-extrabold">{{ $statusStats['canceled'] ?? 0 }}</h3>
                    <p class="text-xl mt-2">Canceled</p>
                </div>
            </div>
        </div>

        <!-- Accordion for Events -->
        <div>
            @if ($events->isEmpty())
                <div class="text-center py-8">
                    <p class="text-gray-600">No events or bookings found.</p>
                </div>
            @else
                @foreach ($events as $event)
                    <div class="bg-white shadow-lg rounded-lg mb-4">
                        <button
                            class="w-full text-left px-6 py-4 text-red-950 font-bold text-xl flex justify-between items-center hover:bg-orange-50 transition"
                            type="button" data-collapse-toggle="collapse-{{ $event->id }}" aria-expanded="false"
                            aria-controls="collapse-{{ $event->id }}">
                            <span>{{ $event->name }}</span>
                            <i class="fas fa-chevron-down transform transition-transform duration-300"></i>
                        </button>

                        <div id="collapse-{{ $event->id }}" class="hidden transition">
                            <div class="p-6">
                                <p class="text-gray-600 mb-4">Date: {{ $event->event_date }}</p>

                                @if ($event->bookings->isEmpty())
                                    <p class="text-gray-600">No bookings for this event yet.</p>
                                @else
                                    <div class="overflow-x-auto">
                                        <table class="w-full table-auto border-collapse border border-gray-200 rounded-lg">
                                            <thead class="bg-gray-50">
                                                <tr>
                                                    <th
                                                        class="px-4 py-2 border border-gray-200 text-left text-sm font-bold">
                                                        Booking ID</th>
                                                    <th
                                                        class="px-4 py-2 border border-gray-200 text-left text-sm font-bold">
                                                        User</th>
                                                    <th
                                                        class="px-4 py-2 border border-gray-200 text-left text-sm font-bold">
                                                        Quantity</th>
                                                    <th
                                                        class="px-4 py-2 border border-gray-200 text-left text-sm font-bold">
                                                        Total Price</th>
                                                    <th
                                                        class="px-4 py-2 border border-gray-200 text-left text-sm font-bold">
                                                        Status</th>
                                                    <th
                                                        class="px-4 py-2 border border-gray-200 text-left text-sm font-bold">
                                                        Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($event->bookings as $booking)
                                                    <tr class="hover:bg-gray-50 transition">
                                                        <td class="px-4 py-2 border border-gray-200">{{ $booking->id }}
                                                        </td>
                                                        <td class="px-4 py-2 border border-gray-200">
                                                            {{ $booking->user->name }}</td>
                                                        <td class="px-4 py-2 border border-gray-200">
                                                            {{ $booking->quantity }}</td>
                                                        <td class="px-4 py-2 border border-gray-200 text-green-600">
                                                            Rp.{{ number_format($booking->total_price, 2) }}
                                                        </td>
                                                        <td class="px-4 py-2 border border-gray-200 capitalize">
                                                            {{ $booking->status }}</td>
                                                        <td class="px-4 py-2 border border-gray-200 space-x-2">
                                                            @if ($booking->status === 'pending')
                                                                <form
                                                                    action="{{ route('admin.bookings.update', $booking->id) }}"
                                                                    method="POST" class="inline-block">
                                                                    @csrf
                                                                    @method('PATCH')
                                                                    <input type="hidden" name="status" value="approved">
                                                                    <button type="submit"
                                                                        class="relative flex items-center justify-center px-5 py-2.5 font-semibold text-white group rounded-full overflow-hidden bg-gradient-to-r from-green-400 to-green-500 shadow-md hover:from-green-600 hover:to-green-500 hover:shadow-lg transition duration-300">
                                                                        <span
                                                                            class="absolute inset-0 w-full h-full bg-gradient-to-r from-green-200 via-green-300 to-green-400 opacity-0 group-hover:opacity-100 transition duration-300 transform scale-125"></span>
                                                                        <i
                                                                            class="fas fa-check-circle text-lg mr-2 relative z-10"></i>
                                                                        <span class="relative z-10">Approve</span>
                                                                    </button>
                                                                </form>
                                                                <form
                                                                    action="{{ route('admin.bookings.update', $booking->id) }}"
                                                                    method="POST" class="inline-block">
                                                                    @csrf
                                                                    @method('PATCH')
                                                                    <input type="hidden" name="status" value="canceled">
                                                                    <button type="submit"
                                                                        class="relative flex items-center justify-center px-5 py-2.5 font-semibold text-white group rounded-full overflow-hidden bg-gradient-to-r from-red-400 to-red-500 shadow-md hover:from-red-600 hover:to-red-500 hover:shadow-lg transition duration-300">
                                                                        <span
                                                                            class="absolute inset-0 w-full h-full bg-gradient-to-r from-red-500 via-red-400 to-red-500 opacity-0 group-hover:opacity-100 transition duration-300 transform scale-125"></span>
                                                                        <i
                                                                            class="fas fa-times-circle text-lg mr-2 relative z-10"></i>
                                                                        <span class="relative z-10">Cancel</span>
                                                                    </button>
                                                                </form>
                                                            @else
                                                                <span class="text-gray-400 italic">No actions
                                                                    available</span>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
@endsection
