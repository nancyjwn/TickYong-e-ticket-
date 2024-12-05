@extends('layouts.master')

@section('content')
    <div class="container mx-auto px-4 py-12">
        <!-- Header Section -->
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-4xl font-bold text-gray-900">Manage Users</h1>
            <div class="flex space-x-4">
                <a href="{{ route('admin.dashboard') }}"
                    class="flex items-center px-4 py-2 bg-gray-700 text-white font-medium rounded-md shadow-md hover:bg-gray-800 transition duration-300">
                    <i class="fas fa-arrow-left mr-2"></i> Back
                </a>
                @if (Auth::check() && Auth::user()->role === 'admin')
                    <a href="{{ route('admin.users.create') }}"
                        class="flex items-center px-4 py-2 bg-red-950 text-white font-medium rounded-md shadow-md hover:bg-blue-700 transition duration-300">
                        <i class="fas fa-user-plus mr-2"></i> Add New User
                    </a>
                @endif
            </div>
        </div>

        <!-- Success Message -->
        @if (session('success'))
            <div class="p-4 text-sm text-green-800 bg-green-100 border-l-4 border-green-500 rounded-md shadow-md"
                role="alert">
                <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
            </div>
        @endif

        <!-- Users Table -->
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-300 rounded-lg shadow-md">
                <thead class="bg-orange-100">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-800 uppercase tracking-wider">#</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-800 uppercase tracking-wider">Name</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-800 uppercase tracking-wider">Email
                        </th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-800 uppercase tracking-wider">Role</th>
                        <th class="px-6 py-3 text-center text-sm font-medium text-gray-800 uppercase tracking-wider">Actions
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $index => $user)
                        <tr
                            class="border-b {{ $loop->even ? 'bg-gray-50' : '' }} hover:bg-orange-50 hover:shadow transition">
                            <td class="px-6 py-4 text-sm font-medium text-gray-800">{{ $index + 1 }}</td>
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $user->name }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $user->email }}</td>
                            <td class="px-6 py-4 text-sm font-semibold text-red-950 capitalize">{{ $user->role }}</td>
                            <td class="px-6 py-4 text-center flex justify-center space-x-2">
                                <a href="{{ route('admin.users.edit', $user->id) }}"
                                    class="px-3 py-2 bg-blue-600 text-white rounded-md shadow-md hover:bg-blue-700 transition">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.users.delete', $user->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="px-3 py-2 bg-red-600 text-white rounded-md shadow-md hover:bg-red-700 transition"
                                        onclick="return confirm('Are you sure you want to delete this user?')">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
