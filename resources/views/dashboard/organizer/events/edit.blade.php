@extends('layouts.master')

@section('content')
    <!-- Header Section -->
    <div class="container mx-auto px-4 py-8">
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Edit Event</h1>
            <p class="text-gray-600">Perbarui informasi acara di bawah ini.</p>
        </div>

        <!-- Form Section -->
        <div class="bg-white shadow-lg rounded-lg p-6">
            <form action="{{ route('organizer.events.update', ['id' => $event->id, 'category' => $event->category_id]) }}"
                method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')
                <input type="hidden" name="previous_url" value="{{ url()->previous() }}">

                <!-- Event Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Event Name</label>
                    <input type="text" id="name" name="name" value="{{ old('name', $event->name) }}"
                        class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                        required>
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea id="description" name="description" rows="4"
                        class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                        required>{{ old('description', $event->description) }}</textarea>
                </div>

                <!-- Event Date -->
                <div>
                    <label for="date_time" class="block text-sm font-medium text-gray-700">Event Start Date</label>
                    <input type="datetime-local" id="date_time" name="date_time"
                        value="{{ old('date_time', $event->date_time ? date('Y-m-d\TH:i', strtotime($event->date_time)) : '') }}"
                        class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                        required>
                </div>

                <!-- End Event Date -->
                <div>
                    <label for="end_event_date" class="block text-sm font-medium text-gray-700">Event End Date</label>
                    <input type="datetime-local" id="end_event_date" name="end_event_date"
                        value="{{ old('end_event_date', $event->end_event_date ? date('Y-m-d\TH:i', strtotime($event->end_event_date)) : '') }}"
                        class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                </div>

                <!-- Location -->
                <div>
                    <label for="location" class="block text-sm font-medium text-gray-700">Location</label>
                    <input type="text" id="location" name="location" value="{{ old('location', $event->location) }}"
                        class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                        required>
                </div>

                <!-- Ticket Types -->
                <div class="space-y-6">
                    <h3 class="text-lg font-semibold text-gray-800">Ticket Types</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        @foreach (['vvip', 'vip', 'regular'] as $type)
                            <div class="bg-gray-50 p-6 border border-gray-300 rounded-lg shadow-sm">
                                <h4 class="text-md font-bold text-gray-700 mb-4">{{ strtoupper($type) }} Ticket</h4>

                                <!-- Ticket Price -->
                                <label for="ticket_prices[{{ $type }}]"
                                    class="block text-sm font-medium text-gray-700">Price</label>
                                <input type="number" id="ticket_prices[{{ $type }}]"
                                    name="ticket_prices[{{ $type }}]"
                                    value="{{ old('ticket_prices.' . $type, $event->tickets->where('type', $type)->first()->price ?? 0) }}"
                                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                    placeholder="Enter ticket price" required>

                                <!-- Ticket Quota -->
                                <label for="ticket_quotas[{{ $type }}]"
                                    class="block text-sm font-medium text-gray-700 mt-4">Quota</label>
                                <input type="number" id="ticket_quotas[{{ $type }}]"
                                    name="ticket_quotas[{{ $type }}]"
                                    value="{{ old('ticket_quotas.' . $type, $event->tickets->where('type', $type)->first()->quota ?? 0) }}"
                                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                    placeholder="Enter ticket quota" required>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Category -->
                <div>
                    <label for="category_id" class="block text-sm font-medium text-gray-700">Category</label>
                    <select id="category_id" name="category_id"
                        class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                        required>
                        <option value="">Select Category</option>
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
                        class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">

                    <!-- Pratinjau Gambar Saat Ini -->
                    @if ($event->image)
                        <div class="mt-4">
                            <p class="text-sm text-gray-600">Current Image:</p>
                            <img src="{{ asset('storage/' . $event->image) }}" alt="Event Image"
                                class="w-64 h-48 object-cover rounded-md">
                        </div>
                    @endif
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end space-x-4">
                    <a href="{{ route('organizer.events.index') }}"
                        class="bg-gray-600 text-white px-6 py-2 rounded-lg shadow hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500">
                        Cancel
                    </a>
                    <button type="submit"
                        class="bg-blue-600 text-white px-6 py-2 rounded-lg shadow hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        onclick="this.disabled=true; this.form.submit();">
                        Create Event
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
