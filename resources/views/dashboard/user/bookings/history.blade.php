@extends('layouts.master')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="flex items-center space-x-4 mb-6">
            <a href="{{ route('user.dashboard') }}" class="text-gray-600 hover:text-gray-800 transition duration-300">
                <!-- Icon -->
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                    stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
            <h1 class="text-3xl font-bold text-gray-800">Booking History</h1>
        </div>

        @if ($bookings->isEmpty())
            <div class="bg-yellow-100 text-yellow-800 px-4 py-3 rounded-lg shadow-md">
                <p class="text-center">You have no bookings yet.</p>
            </div>
        @else
            <div class="overflow-x-auto shadow-md rounded-lg">
                <table class="w-full text-sm text-left text-gray-600 bg-white border border-gray-200">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-100">
                        <tr>
                            <th scope="col" class="py-3 px-6">Event</th>
                            <th scope="col" class="py-3 px-6">Ticket Type</th>
                            <th scope="col" class="py-3 px-6">Quantity</th>
                            <th scope="col" class="py-3 px-6">Total Price</th>
                            <th scope="col" class="py-3 px-6">Status</th>
                            <th scope="col" class="py-3 px-6 text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($bookings as $booking)
                            <tr class="hover:bg-gray-50 border-b">
                                <td class="py-4 px-6">
                                    <div class="flex items-center space-x-4">
                                        <img src="{{ asset('storage/' . $booking->event->image) }}"
                                            alt="{{ $booking->event->name }}" class="w-12 h-12 rounded-full object-cover">
                                        <div>
                                            <p class="font-medium">{{ $booking->event->name }}</p>
                                            <p class="text-sm text-gray-500">
                                                📍 {{ $booking->event->location }}
                                            </p>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4 px-6 uppercase font-semibold">
                                    {{ $booking->type }}
                                </td>
                                <td class="py-4 px-6">{{ $booking->quantity }}</td>
                                <td class="py-4 px-6">${{ number_format($booking->total_price, 2) }}</td>
                                <td class="py-4 px-6">
                                    <span
                                        class="px-3 py-1 rounded-full text-xs font-semibold 
                                    {{ $booking->status === 'canceled' ? 'bg-red-100 text-red-700' : 'bg-green-100 text-green-700' }}">
                                        {{ ucfirst($booking->status) }}
                                    </span>
                                </td>
                                <td class="py-4 px-6 text-right">
                                    @if (in_array($booking->status, ['pending', 'confirmed']))
                                        <form action="{{ route('user.bookings.cancel', $booking->id) }}" method="POST"
                                            onsubmit="return confirm('Are you sure you want to cancel this booking?');">
                                            @csrf
                                            @method('POST')
                                            <button type="submit"
                                                class="px-4 py-2 text-white bg-red-600 hover:bg-red-700 rounded-lg shadow">
                                                Cancel
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-gray-400 italic">No actions</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
@endsection
