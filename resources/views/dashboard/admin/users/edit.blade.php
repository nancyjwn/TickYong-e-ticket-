@extends('layouts.master')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <!-- Header Section -->
        <div class="mb-6">
            <h1 class="text-3xl font-extrabold text-red-950">Edit User</h1>
            <p class="text-gray-700">Update the user information below.</p>
        </div>

        <!-- Error Messages -->
        @if ($errors->any())
            <div class="bg-red-100 text-red-800 px-4 py-2 rounded shadow mb-6">
                <h2 class="font-bold mb-2">Validation Errors:</h2>
                <ul class="list-disc pl-5 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Form Section -->
        <div class="bg-gradient-to-r from-orange-100 to-red-100 shadow-lg rounded-lg p-6">
            <form action="{{ route('admin.users.update', $user->id) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-red-950">Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}"
                        class="mt-1 block w-full px-4 py-2 border border-red-200 rounded-lg shadow-sm focus:ring-red-950 focus:border-red-950"
                        required>
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-red-950">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}"
                        class="mt-1 block w-full px-4 py-2 border border-red-200 rounded-lg shadow-sm focus:ring-red-950 focus:border-red-950"
                        required>
                </div>

                <!-- Role -->
                <div>
                    <label for="role" class="block text-sm font-medium text-red-950">Role</label>
                    <select name="role" id="role"
                        class="mt-1 block w-full px-4 py-2 border border-red-200 rounded-lg shadow-sm focus:ring-red-950 focus:border-red-950"
                        required>
                        <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="event_organizer"
                            {{ old('role', $user->role) == 'event_organizer' ? 'selected' : '' }}>Event Organizer
                        </option>
                        <option value="user" {{ old('role', $user->role) == 'user' ? 'selected' : '' }}>User</option>
                    </select>
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-medium text-red-950">Password</label>
                    <input type="password" name="password" id="password"
                        class="mt-1 block w-full px-4 py-2 border border-red-200 rounded-lg shadow-sm focus:ring-red-950 focus:border-red-950">
                    <p class="text-sm text-gray-600 mt-1">Leave blank if you don't want to change the password.</p>
                </div>

                <!-- Buttons -->
                <div class="flex justify-end space-x-4">
                    <a href="{{ url()->previous() }}"
                        class="bg-gray-950 text-white px-6 py-2 rounded-lg shadow hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-400 transition duration-200">
                        Cancel
                    </a>
                    <button type="submit"
                        class="bg-red-950 text-white px-6 py-2 rounded-lg shadow hover:bg-red-800 focus:outline-none focus:ring-2 focus:ring-red-950 transition duration-200">
                        Update User
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
