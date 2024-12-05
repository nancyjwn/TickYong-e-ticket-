@extends('layouts.master')

@section('content')
    <div class="container mx-auto p-8">
        <h1 class="text-6xl font-extrabold text-center mb-12 text-gray-900 tracking-tight leading-tight">
            Explore the Best Events
        </h1>

        <!-- Form Pencarian -->
        <form method="GET" action="{{ route('dashboard.events.search') }}" class="mb-8">
            <div class="flex items-center space-x-6">
                <!-- Search by Event Name -->
                <input type="text" name="query"
                    class="w-full p-4 text-xl text-gray-900 border border-gray-300 rounded-xl focus:ring-4 focus:ring-red-500 transition shadow-lg"
                    placeholder="Search events..." value="{{ request('query') }}" />

                <!-- Search Button -->
                <button type="submit"
                    class="bg-red-950 text-white px-8 py-3 rounded-xl hover:bg-red-700 transition duration-300 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-red-700">
                    Search
                </button>
            </div>
        </form>

        <!-- Hasil Pencarian -->
        @if ($events->isEmpty())
            <p class="text-center text-gray-500 text-xl">No events found based on your search criteria.</p>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach ($events as $event)
                    <div
                        class="relative bg-white shadow-xl rounded-3xl overflow-hidden transform transition duration-500 hover:scale-105 hover:shadow-2xl hover:translate-y-4 group">
                        <!-- Event Image with Hover Effects -->
                        <div class="relative">
                            <img src="{{ asset('storage/' . $event->image) }}" alt="{{ $event->name }}"
                                class="w-full h-56 object-cover rounded-t-3xl transform transition duration-300 group-hover:scale-110">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-50"></div>
                        </div>

                        <div class="p-6 space-y-4">
                            <!-- Event Title -->
                            <h2
                                class="text-3xl font-semibold text-gray-900 mb-2 hover:text-red-950 transition duration-300 group-hover:scale-105">
                                {{ $event->name }}
                            </h2>

                            <!-- Event Date -->
                            <p class="text-sm text-gray-600">
                                {{ $event->date ? $event->date->format('d M Y') : 'Date not available' }}
                            </p>

                            <!-- Event Description -->
                            <p class="mt-4 text-lg text-gray-700">{{ Str::limit($event->description, 150) }}</p>

                            <!-- Button Section -->
                            <div class="mt-6 flex justify-center items-center space-x-6">
                                <a href="{{ route('events.show', $event->id) }}"
                                    class="bg-gradient-to-r from-red-950 to-red-600 text-white px-8 py-3 rounded-full w-full text-center hover:bg-red-800 transition duration-300 transform hover:translate-x-2">
                                    View Event
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection
