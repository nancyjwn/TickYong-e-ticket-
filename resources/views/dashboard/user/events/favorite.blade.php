@extends('layouts.master')
@section('content')
    <div class="container mx-auto px-4 py-8">
        <!-- Display Success/Error Message -->
        @if (session('success'))
            <div class="bg-green-100 text-green-800 p-4 rounded-md mb-6">
                {{ session('success') }}
            </div>
        @elseif (session('error'))
            <div class="bg-red-100 text-red-800 p-4 rounded-md mb-6">
                {{ session('error') }}
            </div>
        @endif
        
        <!-- Refined Header with Modern Design -->
        <div class="flex items-center justify-between mb-12 border-b pb-4 border-gray-200">
            <div class="flex items-center space-x-6">
                <a href="{{ route('user.dashboard') }}" class="group transition duration-300">
                    <!-- Enhanced Back Icon with Hover Effect -->
                    <div class="p-3 bg-gray-100 group-hover:bg-gray-200 rounded-full transition duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-700 group-hover:text-gray-900"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                    </div>
                </a>
                <h1 class="text-4xl font-extrabold text-gray-900 tracking-tight">Your Favorite Events</h1>
            </div>
        </div>

        <!-- Favorites Section with Enhanced Styling -->
        @if ($favorites->isEmpty())
            <div class="max-w-xl mx-auto bg-white border border-gray-100 rounded-3xl p-10 text-center shadow-2xl space-y-6">
                <div class="bg-blue-50 inline-block p-5 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-20 w-20 text-red-950 mx-auto" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <p class="text-2xl font-bold text-gray-800 mb-4">No Favorite Events Yet</p>
                    <p class="text-gray-600 mb-6 text-lg">Explore and add events you love to your favorites!</p>
                </div>
            </div>
        @else
            <!-- Events Grid Layout -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach ($favorites as $favorite)
                    <div class="relative group">
                        <div
                            class="bg-white rounded-2xl shadow-lg overflow-hidden transform transition-all duration-500 
                            hover:-translate-y-2 hover:shadow-2xl will-change-transform">

                            <!-- Event Image with Hover Effect -->
                            <div class="relative overflow-hidden">
                                @if ($favorite->event && $favorite->event->image)
                                    <img src="{{ asset('storage/' . $favorite->event->image) }}"
                                        alt="{{ $favorite->event->name }}"
                                        class="w-full h-64 object-cover transition-transform duration-500 group-hover:scale-110">
                                @else
                                    <img src="{{ asset('images/default-event-image.jpg') }}" alt="Default Event Image"
                                        class="w-full h-64 object-cover transition-transform duration-500 group-hover:scale-110">
                                @endif
                                <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                            </div>

                            <!-- Remove Favorite Button with Refined Interaction -->
                            <form action="{{ route('user.events.remove_favorite', $favorite->event->id) }}" method="POST"
                                class="absolute top-4 right-4">
                                @csrf
                                @method('DELETE')
                                <button type="submit" title="Remove Favorite"
                                    class="bg-white/80 rounded-full p-3 hover:bg-white hover:shadow-lg transition duration-300 
                                    opacity-0 group-hover:opacity-100 transform hover:scale-110">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-600" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </form>
                        </div>

                        <!-- Event Details Section -->
                        <div class="p-6 space-y-3">
                            <h3 class="text-2xl font-bold text-gray-900 mb-2 truncate leading-tight">
                                {{ $favorite->event->name }}
                            </h3>

                            <div class="flex items-center text-gray-600 space-x-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-950" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <span class="text-base">{{ $favorite->event->location }}</span>
                            </div>

                            <div class="flex items-center text-gray-600 space-x-3 mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-950" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <span class="text-base">
                                    {{ date('F d, Y', strtotime($favorite->event->date_time)) }}
                                </span>
                            </div>

                            <a href="{{ route('events.show', $favorite->event->id) }}"
                                class="inline-block bg-red-900 text-white px-5 py-2.5 rounded-lg 
                                hover:bg-red-950 transition duration-300 
                                transform hover:translate-x-1 hover:shadow-md">
                                View Details →</a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection
