@extends('layouts.master')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <!-- Header Section -->
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Create Event</h1>
            <p class="text-gray-600">Fill out the form below to create a new event.</p>
        </div>

        <!-- Form Section -->
        <div class="bg-white shadow-lg rounded-lg p-6">
            <form action="{{ route('organizer.events.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <!-- Event Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Event Name</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}"
                        class="mt-1 block w-full px-4 py-2 border @error('name') border-red-500 @else border-gray-300 @enderror rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Enter event name" required>
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea id="description" name="description" rows="4"
                        class="mt-1 block w-full px-4 py-2 border @error('description') border-red-500 @else border-gray-300 @enderror rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Provide a detailed description of the event" required>{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Event Date -->
                <div>
                    <label for="date_time" class="block text-sm font-medium text-gray-700">Event Start Date</label>
                    <input type="datetime-local" id="date_time" name="date_time" value="{{ old('date_time') }}"
                        class="mt-1 block w-full px-4 py-2 border @error('date_time') border-red-500 @else border-gray-300 @enderror rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Select event start date and time" required>
                    @error('date_time')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- End Event Date -->
                <div>
                    <label for="end_event_date" class="block text-sm font-medium text-gray-700">Event End Date</label>
                    <input type="datetime-local" id="end_event_date" name="end_event_date"
                        value="{{ old('end_event_date') }}"
                        class="mt-1 block w-full px-4 py-2 border @error('end_event_date') border-red-500 @else border-gray-300 @enderror rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Select event end date and time">
                    @error('end_event_date')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Location -->
                <div>
                    <label for="location" class="block text-sm font-medium text-gray-700">Location</label>
                    <input type="text" id="location" name="location" value="{{ old('location') }}"
                        class="mt-1 block w-full px-4 py-2 border @error('location') border-red-500 @else border-gray-300 @enderror rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Enter the event location" required>
                    @error('location')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Ticket Types -->
                <div class="space-y-6">
                    <h3 class="text-lg font-semibold text-gray-800">Ticket Types</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        @foreach (['vvip', 'vip', 'regular'] as $type)
                            <div class="bg-gray-50 p-4 border border-gray-300 rounded-lg shadow-sm">
                                <h4 class="text-md font-bold text-gray-700 mb-4">{{ strtoupper($type) }} Ticket</h4>
                                <label for="ticket_prices[{{ $type }}]"
                                    class="block text-sm font-medium text-gray-700">Price</label>
                                <input type="number" id="ticket_prices[{{ $type }}]"
                                    name="ticket_prices[{{ $type }}]" value="{{ old("ticket_prices.$type") }}"
                                    class="mt-1 block w-full px-4 py-2 border @error("ticket_prices.$type") border-red-500 @else border-gray-300 @enderror rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                    placeholder="Enter ticket price" required>
                                @error("ticket_prices.$type")
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror

                                <label for="ticket_quotas[{{ $type }}]"
                                    class="block text-sm font-medium text-gray-700 mt-4">Quota</label>
                                <input type="number" id="ticket_quotas[{{ $type }}]"
                                    name="ticket_quotas[{{ $type }}]" value="{{ old("ticket_quotas.$type") }}"
                                    class="mt-1 block w-full px-4 py-2 border @error("ticket_quotas.$type") border-red-500 @else border-gray-300 @enderror rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                    placeholder="Enter ticket quota" required>
                                @error("ticket_quotas.$type")
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Category Dropdown -->
                <div>
                    <label for="category_id" class="block text-sm font-medium text-gray-700">Category</label>
                    <select id="category_id" name="category_id"
                        class="mt-1 block w-full px-4 py-2 border @error('category_id') border-red-500 @else border-gray-300 @enderror rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                        required>
                        <option value="">Select Category</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Event Image -->
                <div>
                    <label for="image" class="block text-sm font-medium text-gray-700">Event Image</label>
                    <input type="file" id="image" name="image"
                        class="mt-1 block w-full px-4 py-2 border @error('image') border-red-500 @else border-gray-300 @enderror rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    @error('image')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit and Cancel Buttons -->
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
