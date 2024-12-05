@extends('layouts.master')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold mb-8">My Bookings for {{ $event->name }}</h1>

        @if ($bookings->isEmpty())
            <p>You have no bookings for this event.</p>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach ($bookings as $booking)
                    <div class="bg-white shadow-md rounded-lg p-6">
                        <p><strong>Ticket Type:</strong> {{ strtoupper($booking->type) }}</p>
                        <p><strong>Quantity:</strong> {{ $booking->quantity }}</p>
                        <p><strong>Total Price:</strong> ${{ number_format($booking->total_price, 2) }}</p>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection
