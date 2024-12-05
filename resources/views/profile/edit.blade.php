@extends('layouts.master')

@section('content')
    <div class="max-w-4xl mx-auto py-10">
        <div class="bg-white rounded-lg shadow-lg p-6">
            <h2 class="text-3xl font-extrabold text-gray-900 mb-6 text-center">Edit Profile</h2>

            <!-- Success Message -->
            @if (session('success'))
                <div class="mb-4 flex items-center bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    <svg class="w-6 h-6 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414 0L9 12l-1.293-1.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4a1 1 0 000-1.414z"
                            clip-rule="evenodd"></path>
                    </svg>
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            <!-- Profile Form -->
            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Name -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                        <input type="text" id="name" name="name" value="{{ old('name', auth()->user()->name) }}"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        @error('name')
                            <span class="text-sm text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" id="email" name="email"
                            value="{{ old('email', auth()->user()->email) }}"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        @error('email')
                            <span class="text-sm text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Phone Number -->
                    <div>
                        <label for="phone_number" class="block text-sm font-medium text-gray-700">Phone Number</label>
                        <input type="text" id="phone_number" name="phone_number"
                            value="{{ old('phone_number', auth()->user()->phone_number) }}"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        @error('phone_number')
                            <span class="text-sm text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Birth Date -->
                    <div>
                        <label for="birth_date" class="block text-sm font-medium text-gray-700">Birth Date</label>
                        <input type="date" id="birth_date" name="birth_date"
                            value="{{ old('birth_date', auth()->user()->birth_date) }}"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        @error('birth_date')
                            <span class="text-sm text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Gender -->
                    <div>
                        <label for="gender" class="block text-sm font-medium text-gray-700">Gender</label>
                        <select id="gender" name="gender"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            <option value="" {{ old('gender', auth()->user()->gender) == '' ? 'selected' : '' }}>
                                Select Gender</option>
                            <option value="male" {{ old('gender', auth()->user()->gender) == 'male' ? 'selected' : '' }}>
                                Male</option>
                            <option value="female"
                                {{ old('gender', auth()->user()->gender) == 'female' ? 'selected' : '' }}>Female</option>
                            <option value="other"
                                {{ old('gender', auth()->user()->gender) == 'other' ? 'selected' : '' }}>Other</option>
                        </select>
                        @error('gender')
                            <span class="text-sm text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Address -->
                <div class="mt-6">
                    <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
                    <textarea id="address" name="address"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">{{ old('address', auth()->user()->address) }}</textarea>
                    @error('address')
                        <span class="text-sm text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Profile Photo -->
                <div class="mt-6">
                    <label for="profile_photo" class="block text-sm font-medium text-gray-700">Profile Photo</label>
                    <input type="file" id="profile_photo" name="profile_photo" accept="image/*"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    @if (auth()->user()->profile_photo)
                        <div class="mt-4 flex items-center space-x-4">
                            <img src="{{ asset('storage/profile_photos/' . auth()->user()->profile_photo) }}"
                                alt="Profile photo" class="w-16 h-16 rounded-full">
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="remove_photo" value="1" class="ml-2">
                                Remove photo
                            </label>
                        </div>
                    @endif
                    @error('profile_photo')
                        <span class="text-sm text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Submit Button -->
                <div class="mt-6">
                    <button type="submit"
                        class="w-full py-2 px-4 bg-blue-600 text-white rounded-lg shadow-md hover:bg-blue-700">
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
