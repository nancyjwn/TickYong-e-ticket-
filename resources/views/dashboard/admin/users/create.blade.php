@extends('layouts.master')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <!-- Header Section -->
        <div class="mb-6">
            <h1 class="text-3xl font-extrabold text-red-950">Create User</h1>
            <p class="text-gray-700">Fill in the form below to add a new user.</p>
        </div>

        <!-- Form Section -->
        <div class="bg-gradient-to-r from-orange-100 to-red-100 shadow-lg rounded-lg p-6">
            <form action="{{ route('admin.users.store') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-red-950">Name</label>
                    <input type="text" name="name" id="name"
                        class="mt-1 block w-full px-4 py-2 border border-red-200 rounded-lg shadow-sm focus:ring-red-950 focus:border-red-950"
                        required>
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-red-950">Email</label>
                    <input type="email" name="email" id="email"
                        class="mt-1 block w-full px-4 py-2 border border-red-200 rounded-lg shadow-sm focus:ring-red-950 focus:border-red-950"
                        required>
                </div>

                <!-- Role -->
                <div>
                    <label for="role" class="block text-sm font-medium text-red-950">Role</label>
                    <select name="role" id="role"
                        class="mt-1 block w-full px-4 py-2 border border-red-200 rounded-lg shadow-sm focus:ring-red-950 focus:border-red-950"
                        required>
                        <option value="admin">Admin</option>
                        <option value="event_organizer">Event Organizer</option>
                        <option value="user">User</option>
                    </select>
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-medium text-red-950">Password</label>
                    <input type="password" name="password" id="password"
                        class="mt-1 block w-full px-4 py-2 border border-red-200 rounded-lg shadow-sm focus:ring-red-950 focus:border-red-950"
                        required>
                </div>

                <!-- Buttons -->
                <div class="flex justify-end space-x-4">
                    <a href="{{ url()->previous() }}"
                        class="bg-gray-600 text-white px-6 py-2 rounded-lg shadow hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500">
                        Cancel
                    </a>
                    <button type="submit"
                        class="bg-red-950 text-white px-6 py-2 rounded-lg shadow hover:bg-red-800 focus:outline-none focus:ring-2 focus:ring-red-950 transition duration-300">
                        Create User
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
