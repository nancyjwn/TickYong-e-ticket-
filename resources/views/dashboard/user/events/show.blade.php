@extends('layouts.master')

@section('content')
    <div class="container mx-auto px-4 py-8 max-w-7xl">
        <!-- Success Message with Modern Styling -->
        @if (session('success'))
            <div class="bg-emerald-50 border-l-4 border-emerald-500 text-emerald-800 p-4 mb-6 rounded-r-lg shadow-md">
                <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-3 text-emerald-500" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <p class="font-semibold">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        <!-- Event Hero Section with Modern Gradient and Image -->
        <div class="container mx-auto px-4 py-8 max-w-6xl">
            <div class="relative group">
                <!-- Back Button (di luar gambar, sejajar di sebelah kiri) -->
                <button onclick="history.back()"
                    class="absolute top-8 -left-16 transform -translate-y-1/2 z-10 w-14 h-14 text-black 
                         flex items-center justify-center transition-all duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>

                <!-- Event Image Container -->
                <div class="relative rounded-3xl overflow-hidden shadow-2xl">
                    <!-- Event Image with Gradient Overlay -->
                    <div class="relative">
                        <img src="{{ asset('storage/' . $event->image) }}" alt="{{ $event->name }}"
                            class="w-full h-[600px] object-cover transition-transform duration-700 
                                    group-hover:scale-105 group-hover:brightness-90">

                        <!-- Gradient Overlay -->
                        <div
                            class="absolute inset-0 bg-gradient-to-b from-transparent via-transparent to-black/70 
                                    opacity-80 pointer-events-none">
                        </div>
                    </div>
                </div>

                <!-- Event Details Card with Glassmorphism -->
                <div class="relative -mt-24 z-20 max-w-4xl mx-auto mb-16">
                    <div
                        class="backdrop-filter backdrop-blur-lg bg-red-950/60 text-orange-100 p-8 rounded-3xl shadow-2xl ring-1 ring-orange-100 space-y-6 transform transition-all duration-500 
        hover:shadow-3xl hover:-translate-y-2">

                        <!-- Event Title -->
                        <h1 class="text-center text-4xl md:text-5xl font-extrabold mb-8 leading-tight tracking-tight">
                            {{ $event->name }}
                        </h1>

                        <!-- Event Details Grid -->
                        <div class="grid md:grid-cols-3 gap-8">
                            <!-- Start Time -->
                            <div class="bg-orange-200/30 backdrop-blur-md p-6 rounded-2xl flex items-center space-x-4">
                                <div class="bg-red-950 text-orange-100 p-4 rounded-full">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-base text-orange-100 font-serif font-semibold">Start</p>
                                    <p class="font-semibold text-base text-orange-100 font-serif">
                                        {{ date('l, d F Y', strtotime($event->date_time)) }}
                                        <br>
                                        {{ date('h:i A', strtotime($event->date_time)) }}
                                    </p>
                                </div>
                            </div>

                            <!-- End Time -->
                            <div class="bg-orange-200/30 backdrop-blur-md p-6 rounded-2xl flex items-center space-x-4">
                                <div class="bg-red-950 text-orange-100 p-4 rounded-full">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 8V3m0 0h5m-5 0H3m12 8a4 4 0 00-8 0v3h8v-3z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-base text-orange-100 font-serif font-semibold">End</p>
                                    <p class="font-semibold text-base text-orange-100 font-serif">
                                        {{ date('l, d F Y', strtotime($event->end_event_time)) }}
                                        <br>
                                        {{ date('h:i A', strtotime($event->end_event_time)) }}
                                    </p>
                                </div>
                            </div>

                            <!-- Location -->
                            <div class="bg-orange-200/30 backdrop-blur-md p-6 rounded-2xl flex items-center space-x-4">
                                <div class="bg-red-950 text-orange-100 p-4 rounded-full">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 11a3 3 0 11-6 0 3 3 0z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-base text-orange-100 font-serif font-semibold">Location</p>
                                    <p class="font-semibold text-base text-orange-100 font-serif">
                                        {{ $event->location }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Actions Section -->
                        <div
                            class="flex flex-col md:flex-row justify-between items-center space-y-6 md:space-y-0 md:space-x-6 pt-8">
                            <!-- Favorite Button -->
                            <form action="{{ route('favorites.store') }}" method="POST" class="w-full md:w-auto">
                                @csrf
                                <input type="hidden" name="event_id" value="{{ $event->id }}">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <button type="submit"
                                    class="w-full md:w-auto flex items-center justify-center space-x-3 bg-orange-100 text-red-950 px-8 py-4 rounded-full hover:bg-red-950 hover:text-orange-100 
                                    transition-all duration-300 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-100">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                    </svg>
                                    <span class="text-base font-serif font-semibold">Add to Favorites</span>
                                </button>
                            </form>

                            <!-- Pricing -->
                            <div class="w-full md:w-auto text-center md:text-right">
                                <span class="text-xl font-semibold text-orange-100 px-6 py-3 rounded-full font-serif ">
                                    Starting from Rp.{{ number_format($event->tickets->min('price'), 2) }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- Enhanced Event Description Section -->
                <div
                    class="bg-gradient-to-br from-orange-50 to-orange-100 border-2 border-red-900/10 rounded-3xl p-10 mb-16 shadow-xl transition-all hover:shadow-2xl">
                    <h2 class="text-3xl font-extrabold text-red-950 mb-6 pb-3 border-b-2 border-red-900/20">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 inline-block mr-4 text-red-900"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        About the Event
                    </h2>
                    <p class="text-red-950 leading-relaxed text-lg tracking-wide">
                        {{ $event->description }}
                    </p>
                </div>

                <!-- Reimagined Ticket Options Section -->
                <div class="mb-16">
                    <h2 class="text-4xl font-extrabold text-red-950 mb-12 text-center relative">
                        <span class="absolute -left-12 top-1/2 transform -translate-y-1/2 text-red-200">✦</span>
                        Ticket Options
                        <span class="absolute -right-12 top-1/2 transform -translate-y-1/2 text-red-200">✦</span>
                    </h2>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        @foreach (['vvip', 'vip', 'regular'] as $type)
                            @php
                                $ticket = $event->tickets->where('type', $type)->first();
                            @endphp

                            <div
                                class="group border-2 border-red-950 rounded-3xl p-7 transform transition-all duration-300 hover:scale-105 hover:shadow-lg relative overflow-hidden">

                                <!-- Ticket Header with Border -->
                                <div class="text-center mb-6 relative">
                                    <h3
                                        class="text-2xl font-semibold capitalize text-red-950 relative z-10 px-2 uppercase">
                                        {{ $type }} Ticket
                                    </h3>
                                    <div class="absolute bottom-0 left-0 right-0 border-b-2 border-red-950"></div>
                                </div>

                                <!-- Ticket Details -->
                                <div class="space-y-4">
                                    <div class="flex justify-between items-center">
                                        <span class="font-semibold text-red-950">Price:</span>
                                        <span class="text-xl font-bold text-red-950">
                                            Rp.{{ number_format($ticket->price, 2) }}
                                        </span>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <span class="font-semibold text-red-950">Available:</span>
                                        <span class="text-xl font-bold text-red-950">
                                            {{ $ticket->quota }} tickets
                                        </span>
                                    </div>
                                </div>

                                <!-- Book Ticket Button -->
                                <a href="{{ route('user.book', ['event_id' => $event->id, 'ticket_type' => $type]) }}"
                                    class="mt-8 block w-full text-center bg-red-950 text-orange-200 py-3 rounded-xl font-bold tracking-wider transition duration-300 hover:bg-red-800 hover:shadow-lg transform hover:-translate-y-1">
                                    Book {{ ucfirst($type) }} Ticket
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Reviews Section -->
                <div class="bg-orange-100 rounded-2xl p-8 shadow-md mb-16">
                    <div class="flex justify-between items-center mb-8">
                        <h2 class="text-2xl font-bold text-red-950">Event Reviews</h2>
                        <div class="flex items-center space-x-1">
                            @php
                                $averageRating = $event->reviews->avg('rating');
                                $totalReviews = $event->reviews->count();
                            @endphp
                            @for ($i = 1; $i <= 5; $i++)
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="h-5 w-5 {{ $i <= $averageRating ? 'text-yellow-500' : 'text-red-950/20' }}"
                                    viewBox="0 0 20 20" fill="currentColor">
                                    <path
                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.462a1 1 0 00.95-.69l1.07-3.292z" />
                                </svg>
                            @endfor
                            <span class="text-sm text-red-950 ml-2">({{ $totalReviews }} reviews)</span>
                        </div>
                    </div>

                    <!-- Review Form -->
                    @if ($canReview)
                        <div class="bg-white p-6 rounded-2xl mb-8">
                            <form action="{{ route('user.events.submitReview', $event->id) }}" method="POST">
                                @csrf
                                <div class="space-y-6">
                                    <div>
                                        <label class="block text-sm font-medium text-red-950 mb-2">Your Rating</label>
                                        <div class="flex space-x-2">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <label class="cursor-pointer">
                                                    <input type="radio" name="rating" value="{{ $i }}"
                                                        class="hidden peer" required
                                                        @if (old('rating', isset($review) ? $review->rating : null) == $i) checked @endif>
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        class="h-8 w-8 text-red-950/20 peer-checked:text-yellow-500 transition-all"
                                                        viewBox="0 0 20 20" fill="currentColor">
                                                        <path
                                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.462a1 1 0 00.95-.69l1.07-3.292z" />
                                                    </svg>
                                                </label>
                                            @endfor
                                        </div>
                                    </div>
                                    <div>
                                        <label for="review" class="block text-sm font-medium text-red-950 mb-2">Your
                                            Review</label>
                                        <textarea name="review" id="review" rows="4"
                                            class="w-full border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-orange-100 transition"
                                            placeholder="Share your thoughts about this event..." required></textarea>
                                    </div>
                                    <button type="submit"
                                        class="w-full bg-red-950 text-orange-100 py-2 rounded-lg hover:bg-orange-100 hover:text-red-950 transition">
                                        Submit Review
                                    </button>
                                </div>
                            </form>
                        </div>
                    @else
                        <div class="bg-white p-4 rounded-lg border border-red-950">
                            <p class="text-red-950 text-sm">You can review this event after attending it.</p>
                        </div>
                    @endif

                    <!-- Reviews Display -->
                    <div class="mt-10">
                        <h3 class="text-2xl font-bold text-red-950 mb-6">What Others Say</h3>
                        @forelse ($event->reviews as $review)
                            <div class="bg-white p-6 rounded-2xl mb-4 shadow-sm border border-orange-100">
                                <div class="flex justify-between items-start mb-4">
                                    <div class="flex items-center space-x-4">
                                        <div
                                            class="bg-red-950 text-orange-100 w-10 h-10 rounded-full flex items-center justify-center font-bold">
                                            {{ strtoupper(substr($review->user->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <span
                                                class="font-semibold text-red-950 block">{{ $review->user->name }}</span>
                                            <span
                                                class="text-sm text-gray-600">{{ $review->created_at->diffForHumans() }}</span>
                                        </div>
                                    </div>
                                    <div class="flex items-center space-x-1 text-yellow-500">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="h-5 w-5 {{ $i <= $review->rating ? 'text-yellow-500' : 'text-red-950/20' }}"
                                                viewBox="0 0 20 20" fill="currentColor">
                                                <path
                                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.462a1 1 0 00.95-.69l1.07-3.292z" />
                                            </svg>
                                        @endfor
                                    </div>
                                </div>
                                <p class="text-red-950">{{ $review->review }}</p>
                            </div>
                        @empty
                            <div class="text-center bg-white p-8 rounded-2xl border border-orange-100">
                                <p class="text-red-950 text-lg">No reviews yet. Be the first to share your experience!</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
