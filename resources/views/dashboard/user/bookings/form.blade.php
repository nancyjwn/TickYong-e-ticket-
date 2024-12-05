@extends('layouts.master')

@section('content')
    <div class="container mx-auto px-4 py-12 space-y-12">
        <!-- Back Button Outside the Image (Fixed Position) -->
        <div class="relative">
            <a href="{{ url()->previous() }}"
                class="absolute top-16 -left-14 transform -translate-y-1/2 z-10 w-20 h-20 text-black 
                       flex items-center justify-center transition-all duration-30">
                <!-- Adjust the icon size here -->
                <i class="fas fa-arrow-left text-xl"></i> <!-- 'text-3xl' increases the icon size -->
            </a>
        </div>


        <!-- Header Section -->
        <div
            class="relative bg-gradient-to-r from-purple-600 via-indigo-600 to-blue-500 text-white rounded-lg shadow-lg overflow-hidden">
            <div class="relative">
                <!-- Event Image -->
                <img src="{{ asset('storage/' . $event->image) }}" alt="{{ $event->name }} Event Image"
                    class="w-full h-96 object-cover opacity-75">
                <div class="absolute inset-0 bg-black bg-opacity-40"></div>
                <div class="absolute bottom-6 left-8 z-10">
                    <h1 class="text-5xl font-extrabold">{{ $event->name }}</h1>
                    <p class="mt-2 text-lg"><i
                            class="fas fa-calendar-alt mr-2"></i>{{ date('F d, Y', strtotime($event->date_time)) }}</p>
                    <p class="mt-1 text-lg"><i class="fas fa-map-marker-alt mr-2"></i>{{ $event->location }}</p>
                </div>
            </div>
        </div>

        <!-- Selected Ticket -->
        <div class="bg-white shadow-lg rounded-lg p-6">
            <h2 class="text-2xl font-bold mb-4">Your Selected Ticket</h2>
            <p class="text-lg"><strong>Event:</strong> {{ $event->name }}</p>
            <p class="text-lg"><strong>Ticket Type:</strong> <span
                    class="text-indigo-600 font-bold">{{ strtoupper($ticket_type) }}</span></p>
            <p class="text-lg"><strong>Date:</strong> {{ date('F d, Y', strtotime($event->date_time)) }}</p>
            <p class="text-lg"><strong>Location:</strong> {{ $event->location }}</p>
            <p class="text-lg"><strong>Price per Ticket:</strong> Rp.{{ number_format($ticket->price, 2) }}</p>
        </div>

        <!-- Booking Form -->
        <div class="bg-white shadow-lg rounded-lg p-6">
            <h2 class="text-2xl font-bold mb-4">Book Your Ticket</h2>
            <p class="text-gray-500 mb-6">
                Fill in the form below to book your <span
                    class="text-indigo-600 font-semibold">{{ strtoupper($ticket_type) }}</span>
                ticket for <strong>{{ $event->name }}</strong>.
            </p>
            <form action="{{ route('user.book.ticket', ['event_id' => $event->id, 'ticket_type' => $ticket_type]) }}"
                method="POST">
                @csrf
                <!-- Account Name -->
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700">Your Name</label>
                    <input type="text" id="name" name="name" value="{{ auth()->user()->name }}" readonly
                        class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                </div>
                <!-- Account Email -->
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700">Your Email</label>
                    <input type="email" id="email" name="email" value="{{ auth()->user()->email }}" readonly
                        class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                </div>
                <!-- Ticket Quantity -->
                <div class="mb-4">
                    <label for="quantity" class="block text-sm font-medium text-gray-700">Number of Tickets</label>
                    <input type="number" id="quantity" name="quantity" min="1" max="{{ $ticket->quota }}" required
                        class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                        oninput="calculateTotal()">
                    <p class="text-sm text-gray-500 mt-1">You can book up to <strong>{{ $ticket->quota }}</strong> tickets.
                    </p>
                    @error('quantity')
                        <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <!-- Total Price -->
                <div class="mb-4">
                    <label for="total_price" class="block text-sm font-medium text-gray-700">Total Price</label>
                    <input type="text" id="total_price" readonly
                        class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm bg-gray-50 text-gray-700">
                </div>
                <!-- Submit Button -->
                <button type="submit"
                    class="w-full bg-gradient-to-r from-purple-500 to-indigo-600 text-white px-4 py-2 rounded-lg shadow-md hover:from-purple-600 hover:to-indigo-700 transition-all transform hover:scale-105">
                    Confirm Booking
                </button>
            </form>
        </div>
    </div>

    <!-- JavaScript for Calculating Total -->
    <script>
        const ticketPrice = {{ $ticket->price }};
        const totalPriceInput = document.getElementById('total_price');
        const quantityInput = document.getElementById('quantity');

        function calculateTotal() {
            const quantity = parseInt(quantityInput.value) || 0;
            const total = quantity * ticketPrice;
            totalPriceInput.value = `Rp.${total.toFixed(2)}`;
        }
    </script>
@endsection
