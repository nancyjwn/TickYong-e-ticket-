@extends('layouts.master')

@section('content')
    <div class="container mx-auto px-4 py-10">
        <!-- Header Section -->
        <div class="mb-8 text-center">
            <h1 class="text-4xl font-extrabold text-gray-800">Edit Event</h1>
            <p class="text-lg text-gray-600 mt-2">Perbarui informasi acara di bawah ini agar lebih menarik dan terorganisir.
            </p>
        </div>

        <!-- Form Section -->
        <div class="bg-gradient-to-r from-red-50 to-orange-50 shadow-lg rounded-lg p-8">
            <form action="{{ route('admin.events.update', $event->id) }}" method="POST" enctype="multipart/form-data"
                class="space-y-8">
                @csrf
                @method('PUT')

                <!-- Event Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Event Name</label>
                    <input type="text" id="name" name="name" value="{{ old('name', $event->name) }}"
                        class="mt-2 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow focus:ring-red-950 focus:border-red-950"
                        required>
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea id="description" name="description" rows="4"
                        class="mt-2 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow focus:ring-red-950 focus:border-red-950"
                        required>{{ old('description', $event->description) }}</textarea>
                </div>

                <!-- Event Dates -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Start Date -->
                    <div>
                        <label for="date_time" class="block text-sm font-medium text-gray-700">Start Date</label>
                        <input type="datetime-local" id="date_time" name="date_time"
                            value="{{ old('date_time', $event->date_time ? date('Y-m-d\TH:i', strtotime($event->date_time)) : '') }}"
                            class="mt-2 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow focus:ring-red-950 focus:border-red-950"
                            required>
                    </div>
                    <!-- End Date -->
                    <div>
                        <label for="end_event_date" class="block text-sm font-medium text-gray-700">End Date</label>
                        <input type="datetime-local" id="end_event_date" name="end_event_date"
                            value="{{ old('end_event_date', $event->end_event_date ? date('Y-m-d\TH:i', strtotime($event->end_event_date)) : '') }}"
                            class="mt-2 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow focus:ring-red-950 focus:border-red-950">
                    </div>
                </div>

                <!-- Location -->
                <div>
                    <label for="location" class="block text-sm font-medium text-gray-700">Location</label>
                    <input type="text" id="location" name="location" value="{{ old('location', $event->location) }}"
                        class="mt-2 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow focus:ring-red-950 focus:border-red-950"
                        required>
                </div>

                <!-- Ticket Types -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Ticket Types</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        @foreach (['vvip', 'vip', 'regular'] as $type)
                            <div
                                class="bg-white p-6 border border-gray-300 rounded-lg shadow-lg hover:shadow-xl transition">
                                <h4 class="text-md font-bold text-red-950 mb-4">{{ strtoupper($type) }} Ticket</h4>
                                <!-- Ticket Price -->
                                <label for="ticket_prices[{{ $type }}]"
                                    class="block text-sm font-medium text-gray-700">Price</label>
                                <input type="number" id="ticket_prices[{{ $type }}]"
                                    name="ticket_prices[{{ $type }}]"
                                    value="{{ old('ticket_prices.' . $type, $event->tickets->where('type', $type)->first()->price ?? 0) }}"
                                    class="mt-2 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow focus:ring-red-950 focus:border-red-950"
                                    placeholder="Enter ticket price" required>

                                <!-- Ticket Quota -->
                                <label for="ticket_quotas[{{ $type }}]"
                                    class="block text-sm font-medium text-gray-700 mt-4">Quota</label>
                                <input type="number" id="ticket_quotas[{{ $type }}]"
                                    name="ticket_quotas[{{ $type }}]"
                                    value="{{ old('ticket_quotas.' . $type, $event->tickets->where('type', $type)->first()->quota ?? 0) }}"
                                    class="mt-2 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow focus:ring-red-950 focus:border-red-950"
                                    placeholder="Enter ticket quota" required>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Category Dropdown -->
                <div>
                    <label for="category_id" class="block text-sm font-medium text-gray-700">Category</label>
                    <select id="category_id" name="category_id"
                        class="mt-2 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow focus:ring-red-950 focus:border-red-950"
                        required>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ old('category_id', $event->category_id) == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Event Image -->
                <div>
                    <label for="image" class="block text-sm font-medium text-gray-700">Event Image</label>
                    <input type="file" id="image" name="image"
                        class="mt-2 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow focus:ring-red-950 focus:border-red-950">
                    @if ($event->image)
                        <div class="mt-4">
                            <p class="text-sm text-gray-700">Current Image:</p>
                            <img src="{{ asset('storage/' . $event->image) }}" alt="Event Image"
                                class="w-64 h-48 object-cover rounded-md border border-gray-300 shadow">
                        </div>
                    @endif
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end space-x-4">
                    <a href="{{ route('admin.events.index') }}"
                        class="bg-gray-700 text-white px-6 py-2 rounded-lg shadow hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-400">
                        Cancel
                    </a>
                    <button type="submit"
                        class="bg-red-900 text-white px-6 py-2 rounded-lg shadow hover:bg-red-950 focus:outline-none focus:ring-2 focus:ring-blue-400">
                        Update Event
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
