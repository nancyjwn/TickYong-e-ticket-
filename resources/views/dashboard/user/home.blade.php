@extends('layouts.master')

@section('content')
    <!-- Top Events Section with Flowbite Carousel -->
    <section class="bg-red-950 text-white py-16 px-10 rounded-2xl shadow-lg mb-16">
        <h2 class="text-4xl font-bold mb-12 text-center">Top Events!</h2>
        @if ($popularEvents->isEmpty())
            <p class="text-center text-white">No popular events to display.</p>
        @else
            <div id="top-events-carousel" class="relative w-full" data-carousel="slide" data-carousel-autoplay
                data-carousel-interval="5000">
                <!-- Carousel wrapper -->
                <div class="relative h-[500px] overflow-hidden rounded-lg">
                    @foreach ($popularEvents as $event)
                        <div class="duration-700 ease-in-out" data-carousel-item>
                            <!-- Carousel Item -->
                            <a href="{{ route('events.show', $event->id) }}">
                                <img src="{{ asset($event->image ? 'storage/' . $event->image : 'default-image.jpg') }}"
                                    alt="{{ $event->name }}"
                                    class="absolute block w-full h-[500px] object-cover rounded-lg">
                            </a>
                            <div
                                class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black to-transparent p-6 text-white">
                                <h3 class="text-2xl font-bold">{{ $event->name }}</h3>
                                <p class="text-sm mt-2">📍 {{ $event->location }}</p>
                                <p class="text-sm">🗓️ {{ date('F d, Y', strtotime($event->date_time)) }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Slider controls -->
                <button type="button"
                    class="absolute top-0 left-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none"
                    data-carousel-prev>
                    <span
                        class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-black/50 group-hover:bg-black/70 focus:ring-4 focus:ring-black/30">
                        <!-- Previous Icon -->
                        <svg aria-hidden="true" class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                            stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                        </svg>
                        <span class="sr-only">Previous</span>
                    </span>
                </button>
                <button type="button"
                    class="absolute top-0 right-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none"
                    data-carousel-next>
                    <span
                        class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-black/50 group-hover:bg-black/70 focus:ring-4 focus:ring-black/30">
                        <!-- Next Icon -->
                        <svg aria-hidden="true" class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                            stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                        </svg>
                        <span class="sr-only">Next</span>
                    </span>
                </button>
            </div>
        @endif
    </section>

    <!-- Filter and Actions Section -->
    <div class="bg-gradient-to-br from-red-950/10 to-red-900/10 rounded-3xl p-8 shadow-xl mb-16 border border-red-900/20">
        <div class="flex flex-col md:flex-row justify-between items-center gap-6">
            <!-- Category Filter -->
            <div class="w-full">
                <div class="flex space-x-4 overflow-x-auto pb-2 w-full">
                    <a href="{{ route('user.dashboard') }}"
                        class="px-5 py-2.5 bg-red-900/90 text-orange-200 rounded-full hover:bg-red-950 transition duration-300 ease-in-out transform hover:scale-105 shadow-md">
                        All Events
                    </a>
                    @foreach ($categories as $category)
                        <a href="{{ route('user.dashboard', ['category' => $category->id]) }}"
                            class="px-5 py-2.5 bg-red-900/90 text-orange-200 rounded-full hover:bg-red-950 transition duration-300 ease-in-out transform hover:scale-105 shadow-md">
                            {{ $category->name }}
                        </a>
                    @endforeach
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-wrap gap-4 ml-auto">
                <a href="{{ route('user.bookings.history') }}"
                    class="px-5 py-2.5 bg-orange-200 text-red-950 rounded-full hover:bg-orange-300 transition duration-300 ease-in-out transform hover:scale-105 flex items-center space-x-2 shadow-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z" />
                        <path fill-rule="evenodd"
                            d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3z"
                            clip-rule="evenodd" />
                    </svg>
                    <span class="font-medium">Booking History</span>
                </a>
                <a href="{{ route('user.events.favorite') }}"
                    class="px-5 py-2.5 bg-red-900 text-orange-200 rounded-full hover:bg-red-700 transition duration-300 ease-in-out transform hover:scale-105 flex items-center space-x-2 shadow-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z"
                            clip-rule="evenodd" />
                    </svg>
                    <span class="font-medium">Favorite Events</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Latest Events Section -->
    <section class="py-12">
        <h2 class="text-4xl font-bold text-center text-red-950 mb-10">Latest Events</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-12">
            @foreach ($latestEvents as $event)
                <div
                    class="relative bg-white rounded-2xl shadow-xl overflow-hidden transform transition-all duration-300 hover:scale-105 hover:shadow-2xl group">
                    <!-- Image -->
                    <a href="{{ route('events.show', $event->id) }}" class="block">
                        <img src="{{ asset('storage/' . $event->image) }}" alt="{{ $event->name }}"
                            class="w-full h-64 object-cover">
                    </a>
                    <!-- Gradient Overlay -->
                    <div class="absolute inset-0 bg-gradient-to-t from-black via-transparent to-transparent opacity-50">
                    </div>
                    <!-- Content -->
                    <div class="p-6 relative z-10">
                        <h3 class="text-2xl font-bold text-red-950 truncate">{{ $event->name }}</h3>
                        <p class="text-sm text-orange-900 mt-2 flex items-center space-x-2">
                            <!-- Location Icon - Map Pin -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-orange-900" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                <circle cx="12" cy="10" r="3"></circle>
                            </svg>
                            <span>{{ $event->location }}</span>
                        </p>
                        <p class="text-sm text-orange-900 flex items-center space-x-2 mt-1">
                            <!-- Date Icon - Calendar -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-orange-900" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                <line x1="16" y1="2" x2="16" y2="6"></line>
                                <line x1="8" y1="2" x2="8" y2="6"></line>
                                <line x1="3" y1="10" x2="21" y2="10"></line>
                            </svg>
                            <span>{{ date('F d, Y', strtotime($event->date_time)) }}</span>
                        </p>
                        <a href="{{ route('events.show', $event->id) }}"
                            class="inline-block mt-4 text-orange-950 font-semibold hover:underline">
                            View Details →
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <!-- Tutorial for Purchasing Tickets Section -->
    <section id='home-details' class="bg-gradient-to-br from-gray-100 to-gray-200 py-16 px-6 md:px-10 rounded-2xl shadow-lg mb-16">
        <h2 class="text-4xl font-bold text-center text-red-950 mb-8">How to Purchase Tickets</h2>
        <div class="max-w-4xl mx-auto space-y-10">
            <h3 class="text-2xl font-semibold text-orange-900 text-center">Follow these simple steps to purchase your
                tickets:</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Step 1 -->
                <div class="flex items-start space-x-4">
                    <div
                        class="flex-shrink-0 w-12 h-12 bg-orange-100 text-orange-600 rounded-full flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v14M5 12h14" />
                        </svg>
                    </div>
                    <div class="flex-1">
                        <strong class="text-lg font-semibold">Step 1: Browse Events</strong>
                        <p class="mt-2">Go to the event listing page and browse through the upcoming events. You can
                            filter by categories to find the event that suits you best.</p>
                    </div>
                </div>

                <!-- Step 2 -->
                <div class="flex items-start space-x-4">
                    <div
                        class="flex-shrink-0 w-12 h-12 bg-orange-100 text-orange-600 rounded-full flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12l5 5L20 7" />
                        </svg>
                    </div>
                    <div class="flex-1">
                        <strong class="text-lg font-semibold">Step 2: Choose Your Event</strong>
                        <p class="mt-2">Click on the event you’re interested in to view more details about it, including
                            the event’s date, location, and available tickets.</p>
                    </div>
                </div>

                <!-- Step 3 -->
                <div class="flex items-start space-x-4">
                    <div
                        class="flex-shrink-0 w-12 h-12 bg-orange-100 text-orange-600 rounded-full flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2 2 4-4m5 5l2 2 4-4" />
                        </svg>
                    </div>
                    <div class="flex-1">
                        <strong class="text-lg font-semibold">Step 3: Select Your Tickets</strong>
                        <p class="mt-2">Once you're on the event page, select the number of tickets you’d like to
                            purchase. You’ll also be able to choose the ticket type (e.g., General Admission, VIP, etc.).
                        </p>
                    </div>
                </div>

                <!-- Step 4 -->
                <div class="flex items-start space-x-4">
                    <div
                        class="flex-shrink-0 w-12 h-12 bg-orange-100 text-orange-600 rounded-full flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3M4 4h16" />
                        </svg>
                    </div>
                    <div class="flex-1">
                        <strong class="text-lg font-semibold">Step 4: Enter Your Details</strong>
                        <p class="mt-2">Provide your contact details and any other necessary information to complete the
                            booking process. This could include your name, email, and the names of other ticket holders (if
                            applicable).</p>
                    </div>
                </div>

                <!-- Step 5 -->
                <div class="flex items-start space-x-4">
                    <div
                        class="flex-shrink-0 w-12 h-12 bg-orange-100 text-orange-600 rounded-full flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7 7 7-7" />
                        </svg>
                    </div>
                    <div class="flex-1">
                        <strong class="text-lg font-semibold">Step 5: Review Your Order</strong>
                        <p class="mt-2">Review your order to make sure everything is correct. You can check the event
                            date, ticket quantity, and total cost.</p>
                    </div>
                </div>

                <!-- Step 6 -->
                <div class="flex items-start space-x-4">
                    <div
                        class="flex-shrink-0 w-12 h-12 bg-orange-100 text-orange-600 rounded-full flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4h16v16H4z" />
                        </svg>
                    </div>
                    <div class="flex-1">
                        <strong class="text-lg font-semibold">Step 6: Complete Payment</strong>
                        <p class="mt-2">Choose your preferred payment method and complete the purchase. You will receive
                            a confirmation email with your tickets and payment receipt.</p>
                    </div>
                </div>

                <!-- Step 7 -->
                <div class="flex items-start space-x-4">
                    <div
                        class="flex-shrink-0 w-12 h-12 bg-orange-100 text-orange-600 rounded-full flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4h16v16H4z" />
                        </svg>
                    </div>
                    <div class="flex-1">
                        <strong class="text-lg font-semibold">Step 7: Attend the Event</strong>
                        <p class="mt-2">On the event day, bring your ticket (either digital or printed) to the venue.
                            Enjoy the event!</p>
                    </div>
                </div>
            </div>
        </div>
    </section>


    @include('components.notif-user-home')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.4/flowbite.min.js"></script>
@endsection
