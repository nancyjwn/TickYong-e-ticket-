@extends('layouts.master')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <!-- Header Section -->
        <div class="mb-6 text-center">
            <h1 class="text-4xl font-extrabold text-gray-800">Create Event</h1>
            <p class="text-gray-600">Isi formulir di bawah untuk membuat acara baru.</p>
        </div>

        <!-- Form Section -->
        <div class="bg-gradient-to-r from-red-50 to-orange-50 shadow-lg rounded-lg p-6">
            <form action="{{ route('admin.events.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <!-- Event Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-800">Event Name</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}"
                        class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-red-950 focus:border-red-950"
                        required>
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-800">Description</label>
                    <textarea id="description" name="description" rows="4"
                        class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-red-950 focus:border-red-950"
                        required>{{ old('description') }}</textarea>
                </div>

                <!-- Event Date -->
                <div>
                    <label for="date_time" class="block text-sm font-medium text-gray-800">Event Date</label>
                    <input type="datetime-local" id="date_time" name="date_time" value="{{ old('date_time') }}"
                        class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-red-950 focus:border-red-950"
                        required>
                </div>

                <!-- End Event Date -->
                <div>
                    <label for="end_event_date" class="block text-sm font-medium text-gray-800">Event End Date</label>
                    <input type="datetime-local" id="end_event_date" name="end_event_date"
                        value="{{ old('end_event_date') }}"
                        class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-red-950 focus:border-red-950"
                        required>
                </div>

                <!-- Location -->
                <div>
                    <label for="location" class="block text-sm font-medium text-gray-800">Location</label>
                    <input type="text" id="location" name="location" value="{{ old('location') }}"
                        class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-red-950 focus:border-red-950"
                        required>
                </div>

                <!-- Ticket Types -->
                <div class="space-y-6">
                    <h3 class="text-lg font-semibold text-gray-800">Ticket Types</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        @foreach (['vvip', 'vip', 'regular'] as $type)
                            <div
                                class="bg-white p-4 border border-gray-300 rounded-lg shadow-sm hover:shadow-md transition">
                                <h4 class="text-md font-bold text-red-950 mb-4">{{ strtoupper($type) }} Ticket</h4>
                                <label for="ticket_prices[{{ $type }}]"
                                    class="block text-sm font-medium text-gray-800">Price</label>
                                <input type="number" id="ticket_prices[{{ $type }}]"
                                    name="ticket_prices[{{ $type }}]" value="{{ old('ticket_prices.' . $type) }}"
                                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-red-950 focus:border-red-950"
                                    required>
                                <label for="ticket_quotas[{{ $type }}]"
                                    class="block text-sm font-medium text-gray-800 mt-4">Quota</label>
                                <input type="number" id="ticket_quotas[{{ $type }}]"
                                    name="ticket_quotas[{{ $type }}]" value="{{ old('ticket_quotas.' . $type) }}"
                                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-red-950 focus:border-red-950"
                                    required>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Category Dropdown -->
                <div>
                    <label for="category_id" class="block text-sm font-medium text-gray-800">Category</label>
                    <select id="category_id" name="category_id"
                        class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-red-950 focus:border-red-950"
                        required>
                        <option value="">Select Category</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Event Image -->
                <div>
                    <label for="image" class="block text-sm font-medium text-gray-800">Event Image</label>
                    <input type="file" id="image" name="image"
                        class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-red-950 focus:border-red-950">
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end space-x-4">
                    <a href="{{ route('admin.events.index') }}"
                        class="bg-gray-700 text-white px-6 py-2 rounded-lg shadow hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-400">
                        Cancel
                    </a>
                    <button type="submit"
                        class="bg-red-900 text-white px-6 py-2 rounded-lg shadow hover:bg-red-950 focus:outline-none focus:ring-2 focus:ring-red-950"
                        onclick="this.disabled=true; this.form.submit();">
                        Create Event
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
