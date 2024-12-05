@extends('layouts.master')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold mb-6">All Bookings</h1>

        @foreach ($events as $event)
            <h2 class="text-xl font-semibold mt-4">{{ $event->name }}</h2>
            <p class="text-sm text-gray-600">Date: {{ $event->event_date }}</p>

            @if ($event->bookings->isEmpty())
                <p>No bookings for this event yet.</p>
            @else
                <table class="table-auto w-full border-collapse border border-gray-300 mt-4">
                    <thead>
                        <tr class="bg-gray-200">
                            <th class="border border-gray-300 px-4 py-2">Booking ID</th>
                            <th class="border border-gray-300 px-4 py-2">User</th>
                            <th class="border border-gray-300 px-4 py-2">Quantity</th>
                            <th class="border border-gray-300 px-4 py-2">Total Price</th>
                            <th class="border border-gray-300 px-4 py-2">Status</th>
                            <th class="border border-gray-300 px-4 py-2">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($bookings as $booking)
                            <tr>
                                <td class="border border-gray-300 px-4 py-2">{{ $booking->id }}</td>
                                <td class="border border-gray-300 px-4 py-2">{{ $booking->user->name }}</td>
                                <td class="border border-gray-300 px-4 py-2">{{ $booking->quantity }}</td>
                                <td class="border border-gray-300 px-4 py-2">${{ number_format($booking->total_price, 2) }}
                                </td>
                                <td class="border border-gray-300 px-4 py-2">{{ ucfirst($booking->status) }}</td>
                                <td class="border border-gray-300 px-4 py-2">
                                    <!-- Approve Button -->
                                    <form action="{{ route('organizer.bookings.update', $booking->id) }}" method="POST"
                                        class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="approved">
                                        <button type="submit"
                                            class="bg-green-500 hover:bg-green-700 text-white font-bold py-1 px-3 rounded">
                                            Approve
                                        </button>
                                    </form>

                                    <!-- Cancel Button -->
                                    <form action="{{ route('organizer.bookings.update', $booking->id) }}" method="POST"
                                        class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="canceled">
                                        <button type="submit"
                                            class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-3 rounded">
                                            Cancel
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        @endforeach
    </div>
@endsection
