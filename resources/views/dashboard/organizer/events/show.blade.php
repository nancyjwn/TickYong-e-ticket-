@extends('layouts.master')

@section('content')
    <div class="container mx-auto px-4 py-8 space-y-12">
        <!-- Back Button -->
        <div class="flex items-center space-x-4 mb-8">
            <a href="{{ route('organizer.events.index') }}"
                class="flex items-center bg-gradient-to-r text-black px-4 py-2 rounded-full shadow-lg hover:scale-105 transition duration-300">
                <i class="fas fa-arrow-left mr-2"></i>
            </a>
        </div>

        <!-- Event Details -->
        <div class="bg-gradient-to-br from-white via-gray-50 to-gray-100 shadow-2xl rounded-3xl overflow-hidden">
            <!-- Event Image -->
            @if ($event->image)
                <div class="relative group">
                    <img src="{{ asset('storage/' . $event->image) }}" alt="{{ $event->name }}"
                        class="w-full h-[400px] object-cover transform group-hover:scale-105 transition duration-500">
                    <div
                        class="absolute inset-0 bg-gradient-to-b from-transparent to-black/60 flex items-end p-6 text-white">
                        <h1 class="text-5xl font-extrabold tracking-tight drop-shadow-lg">{{ $event->name }}</h1>
                    </div>
                </div>
            @else
                <div
                    class="bg-gradient-to-br from-gray-200 to-gray-400 w-full h-[400px] flex items-center justify-center text-gray-600">
                    <i class="fas fa-image text-6xl"></i>
                </div>
            @endif

            <!-- Event Content -->
            <div class="p-10 space-y-8">
                <!-- Details Section -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-white shadow-lg rounded-xl p-6 hover:shadow-2xl transition">
                        <p class="text-lg text-gray-600 font-semibold"><i class="fas fa-calendar-alt mr-2"></i>Date</p>
                        <p class="text-2xl font-bold text-gray-800">{{ $event->date_time }}</p>
                    </div>
                    <div class="bg-white shadow-lg rounded-xl p-6 hover:shadow-2xl transition">
                        <p class="text-lg text-gray-600 font-semibold"><i class="fas fa-map-marker-alt mr-2"></i>Location
                        </p>
                        <p class="text-2xl font-bold text-gray-800">{{ $event->location }}</p>
                    </div>
                    <div class="bg-white shadow-lg rounded-xl p-6 hover:shadow-2xl transition">
                        <p class="text-lg text-gray-600 font-semibold"><i class="fas fa-tag mr-2"></i>Category</p>
                        <p class="text-2xl font-bold text-gray-800">{{ $event->category->name ?? 'No Category' }}</p>
                    </div>
                </div>

                <!-- Description Section -->
                <div>
                    <h2 class="text-3xl font-bold text-red-950 mb-4">Description</h2>
                    <p class="text-gray-700 leading-relaxed text-lg">{{ $event->description }}</p>
                </div>
            </div>
        </div>

        <!-- Tickets Information -->
        <div class="mt-12">
            <h2 class="text-4xl font-extrabold text-center text-red-950 mb-8">Ticket Options</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach ($event->tickets as $ticket)
                    <div
                        class="bg-gradient-to-br from-white via-gray-50 to-gray-100 border border-gray-200 rounded-3xl p-6 shadow-xl hover:shadow-2xl transform transition-transform hover:scale-105">
                        <h3 class="text-2xl font-bold text-gray-800 capitalize mb-4">
                            {{ ucfirst($ticket->type) }} Ticket
                        </h3>
                        <p class="text-lg text-gray-600"><strong>Price:</strong> Rp.{{ number_format($ticket->price, 2) }}
                        </p>
                        <p class="text-lg text-gray-600"><strong>Quota:</strong> {{ $ticket->quota }} tickets</p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
