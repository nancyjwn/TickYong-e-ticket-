@extends('layouts.master')

@section('content')
    <div class="container mx-auto px-4 py-8 space-y-12">
        <!-- Back Button -->
        <div class="mb-6">
            <a href="{{ route('organizer.dashboard') }}"
                class="inline-flex items-center bg-orange-100 text-red-950 px-3 py-1 rounded-full shadow hover:bg-red-950 hover:text-white transition duration-300 text-sm">
                <i class="fas fa-arrow-left mr-1"></i> Back
            </a>
        </div>

        <!-- Booking Status Summary -->
        <div class="relative bg-orange-100 shadow-lg rounded-3xl p-10 overflow-hidden">
            <div class="absolute inset-0 bg-white/30 backdrop-blur-lg rounded-3xl"></div>
            <div class="relative">
                <h2 class="text-3xl font-bold text-red-950 text-center mb-8">Booking Status Summary</h2>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-8 text-center">
                    <!-- Approved -->
                    <div
                        class="relative bg-white shadow-md rounded-lg p-6 hover:shadow-xl transform transition hover:scale-105">
                        <span
                            class="block w-20 h-20 bg-green-100 text-green-700 text-2xl font-bold rounded-full mx-auto flex items-center justify-center shadow-lg">
                            {{ $statusStats['approved'] ?? 0 }}
                        </span>
                        <p class="text-lg font-semibold mt-4 text-red-950">Approved</p>
                    </div>
                    <!-- Pending -->
                    <div
                        class="relative bg-white shadow-md rounded-lg p-6 hover:shadow-xl transform transition hover:scale-105">
                        <span
                            class="block w-20 h-20 bg-orange-100 text-orange-700 text-2xl font-bold rounded-full mx-auto flex items-center justify-center shadow-lg">
                            {{ $statusStats['pending'] ?? 0 }}
                        </span>
                        <p class="text-lg font-semibold mt-4 text-red-950">Pending</p>
                    </div>
                    <!-- Canceled -->
                    <div
                        class="relative bg-white shadow-md rounded-lg p-6 hover:shadow-xl transform transition hover:scale-105">
                        <span
                            class="block w-20 h-20 bg-red-100 text-red-700 text-2xl font-bold rounded-full mx-auto flex items-center justify-center shadow-lg">
                            {{ $statusStats['canceled'] ?? 0 }}
                        </span>
                        <p class="text-lg font-semibold mt-4 text-red-950">Canceled</p>
                    </div>
                </div>
            </div>
        </div>

        @include('components.notif-admin-booking')

        <!-- Accordion for Events -->
        <div>
            @if ($events->isEmpty())
                <div class="text-center py-6">
                    <p class="text-gray-600">No events or bookings found.</p>
                </div>
            @else
                @foreach ($events as $event)
                    <div class="shadow-lg rounded-lg mb-6 border border-gray-300">
                        <button
                            class="w-full px-6 py-4 text-lg font-bold text-gray-800 hover:text-gray-900 border-b border-gray-300 transition"
                            type="button" data-collapse-toggle="collapse-{{ $event->id }}" aria-expanded="false"
                            aria-controls="collapse-{{ $event->id }}">
                            <div class="flex items-center justify-between text-red-950">
                                <span>{{ $event->name }}</span>
                                <i class="fas fa-chevron-down"></i>
                            </div>
                        </button>
                        <div id="collapse-{{ $event->id }}" class="hidden transition">
                            <div class="p-6">
                                @if ($event->bookings->isEmpty())
                                    <p class="text-gray-600">No bookings for this event yet.</p>
                                @else
                                    <div class="overflow-x-auto">
                                        <table class="w-full table-auto border-collapse">
                                            <thead>
                                                <tr>
                                                    <th class="border px-4 py-2 text-left text-gray-600">User Name</th>
                                                    <th class="border px-4 py-2 text-left text-gray-600">Quantity</th>
                                                    <th class="border px-4 py-2 text-left text-gray-600">Total Price</th>
                                                    <th class="border px-4 py-2 text-left text-gray-600">Status</th>
                                                    <th class="border px-4 py-2 text-left text-gray-600">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($event->bookings as $booking)
                                                    <tr class="hover:bg-gray-50">
                                                        <td class="border px-4 py-2">{{ $booking->user->name }}</td>
                                                        <td class="border px-4 py-2">{{ $booking->quantity }}</td>
                                                        <td class="border px-4 py-2 text-green-600">
                                                            Rp.{{ number_format($booking->total_price, 2) }}
                                                        </td>
                                                        <td class="border px-4 py-2 capitalize">{{ $booking->status }}</td>
                                                        <td class="border px-4 py-2">
                                                            @if ($booking->status === 'pending')
                                                                <form
                                                                    action="{{ route('organizer.bookings.update', $booking->id) }}"
                                                                    method="POST" class="inline-block">
                                                                    @csrf
                                                                    @method('PATCH')
                                                                    <input type="hidden" name="status" value="approved">
                                                                    <button type="submit"
                                                                        class="text-sm bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600 transition">
                                                                        Approve
                                                                    </button>
                                                                </form>
                                                                <form
                                                                    action="{{ route('organizer.bookings.update', $booking->id) }}"
                                                                    method="POST" class="inline-block">
                                                                    @csrf
                                                                    @method('PATCH')
                                                                    <input type="hidden" name="status" value="canceled">
                                                                    <button type="submit"
                                                                        class="text-sm bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 transition">
                                                                        Cancel
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
