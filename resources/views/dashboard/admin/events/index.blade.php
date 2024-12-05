@extends('layouts.master')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <!-- Header Section -->
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-4xl font-bold text-red-950 transition-transform hover:scale-105">Manage Events</h1>
            <div class="flex space-x-4">
                <!-- Button Back -->
                <a href="{{ route('admin.dashboard') }}"
                    class="flex items-center bg-orange-100 text-red-950 px-4 py-2 rounded shadow hover:bg-red-950 hover:text-white transition duration-300">
                    <i class="fas fa-arrow-left mr-2"></i> Back
                </a>
                <!-- Button Create Event -->
                @if (Auth::check() && Auth::user()->role === 'admin')
                    <a href="{{ route('admin.events.create') }}"
                        class="flex items-center bg-orange-100 text-red-950 px-4 py-2 rounded shadow hover:bg-red-950 hover:text-white transition duration-300">
                        <i class="fas fa-plus mr-2"></i> Create Event
                    </a>
                @endif
                <!-- Open Filter Modal -->
                <button onclick="openModal()"
                    class="flex items-center bg-orange-100 text-red-950 px-4 py-2 rounded shadow hover:bg-red-950 hover:text-white transition duration-300">
                    <i class="fas fa-filter mr-2"></i> Filter by Category
                </button>
            </div>
        </div>

        <!-- Success Message -->
        @if (session('success'))
            <div class="bg-orange-100 text-red-950 px-4 py-2 rounded shadow mb-6 transition-transform hover:scale-105">
                {{ session('success') }}
            </div>
        @endif

        <!-- Events Card -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse ($events as $event)
                <div
                    class="bg-white border border-gray-300 rounded-3xl shadow-2xl hover:shadow-xl transition p-4 flex flex-col justify-between h-full">
                    <!-- Event Image -->
                    @if ($event->image)
                        <img class="rounded-2xl w-full h-48 object-cover mb-4" src="{{ asset('storage/' . $event->image) }}"
                            alt="{{ $event->name }}">
                    @else
                        <div class="rounded-t-lg w-full h-48 bg-gray-200 flex items-center justify-center text-gray-500">
                            <i class="fas fa-image text-4xl"></i>
                        </div>
                    @endif

                    <!-- Event Content -->
                    <div class="p-5 flex-grow">
                        <h5 class="mb-2 text-2xl font-bold tracking-tight text-red-950">
                            <i class="fas fa-calendar-alt mr-2"></i>{{ $event->name }}
                        </h5>

                        <!-- Description -->
                        <div class="mb-5">
                            <!-- Short description -->
                            <p class="mb-3 font-normal text-gray-700 text-justify truncate"
                                id="short-description-{{ $event->id }}">
                                {{ \Illuminate\Support\Str::limit($event->description, 100) }}
                            </p>

                            <!-- Full description (hidden by default) -->
                            <p class="mb-3 font-normal text-gray-700 text-justify hidden"
                                id="full-description-{{ $event->id }}">
                                {!! nl2br(e($event->description)) !!}
                            </p>

                            <!-- Toggle button -->
                            <button onclick="toggleDescription({{ $event->id }})"
                                class="text-red-950 hover:underline focus:outline-none transition">
                                <i class="fas fa-angle-down mr-1"></i><span id="toggle-button-{{ $event->id }}">Read
                                    More</span>
                            </button>
                        </div>

                        <!-- Other Event Details -->
                        <ul class="mb-4 text-sm text-gray-600 space-y-2 pl-3">
                            <li><i class="fas fa-clock mr-2"></i><strong>Date:</strong> {{ $event->date_time }}</li>
                            <li><i class="fas fa-map-marker-alt mr-2"></i><strong>Location:</strong> {{ $event->location }}
                            </li>
                            <li><i class="fas fa-tag mr-2"></i><strong>Category:</strong>
                                {{ $event->category ? $event->category->name : 'No Category' }}
                            </li>
                        </ul>
                    </div>

                    <!-- Buttons Section -->
                    <div class="flex justify-between p-5 mt-auto">
                        <a href="{{ route('admin.events.show', $event->id) }}"
                            class="text-white bg-red-950 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center flex items-center">
                            <i class="fas fa-info-circle mr-2"></i>Details
                        </a>
                        <a href="{{ route('admin.events.edit', $event->id) }}"
                            class="text-white bg-red-950 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center flex items-center">
                            <i class="fas fa-edit mr-2"></i>Edit
                        </a>
                        <form action="{{ route('admin.events.destroy', $event->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="text-white bg-red-950 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center flex items-center"
                                onclick="return confirm('Are you sure you want to delete this event?')">
                                <i class="fas fa-trash-alt mr-2"></i>Delete
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <p class="text-gray-600">No events found for the selected category.</p>
            @endforelse
        </div>

    </div>

    <!-- Modal -->
    <div id="filterModal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
        <div class="bg-orange-100 rounded-lg shadow-lg p-6 w-96">
            <h2 class="text-xl font-bold mb-4 text-red-950">Filter by Category</h2>
            <form method="GET" action="{{ route('admin.events.index') }}">
                <div class="mb-4">
                    <label for="category" class="block text-sm font-medium text-red-950">Select Category</label>
                    <select name="category" id="category"
                        class="w-full px-4 py-2 border border-red-950 rounded shadow focus:ring-red-950 focus:border-red-950">
                        <option value="">All Categories</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ request('category') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="flex justify-end space-x-4">
                    <button type="button" onclick="closeModal()"
                        class="bg-gray-500 text-white px-4 py-2 rounded shadow hover:bg-gray-600">Cancel</button>
                    <button type="submit"
                        class="bg-red-950 text-white px-4 py-2 rounded shadow hover:bg-red-800 transition">
                        Apply
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function toggleDescription(eventId) {
            const shortDescription = document.getElementById(`short-description-${eventId}`);
            const fullDescription = document.getElementById(`full-description-${eventId}`);
            const toggleButton = document.getElementById(`toggle-button-${eventId}`);

            if (fullDescription.classList.contains('hidden')) {
                shortDescription.classList.add('hidden');
                fullDescription.classList.remove('hidden');
                toggleButton.textContent = 'Read Less';
            } else {
                shortDescription.classList.remove('hidden');
                fullDescription.classList.add('hidden');
                toggleButton.textContent = 'Read More';
            }
        }

        function openModal() {
            document.getElementById('filterModal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('filterModal').classList.add('hidden');
        }
    </script>
@endsection
