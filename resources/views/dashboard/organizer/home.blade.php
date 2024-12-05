@extends('layouts.master')

@section('content')
    <div class="min-h-screen bg-gray-50 py-10 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <!-- Dashboard Header -->
            <header class="mb-10">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-4xl font-extrabold text-gray-900">Organizer Dashboard</h1>
                        <p class="mt-2 text-lg text-gray-600">Manage your events and track your performance</p>
                    </div>
                    <div>
                        <span class="text-sm text-gray-500">{{ now()->format('F d, Y') }}</span>
                    </div>
                </div>
            </header>

            <!-- Quick Action Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-12">
                <a href="{{ route('organizer.events.index') }}" class="block transform transition hover:scale-105">
                    <div class="bg-white shadow-xl rounded-2xl overflow-hidden">
                        <div class="p-6 bg-gradient-to-r from-red-950 to-red-900 text-orange-200">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h2 class="text-2xl font-bold">Event Management</h2>
                                    <p class="text-orange-300 mt-2">Create, edit, and manage your events</p>
                                </div>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </a>

                <a href="{{ route('organizer.bookings') }}" class="block transform transition hover:scale-105">
                    <div class="bg-white shadow-xl rounded-2xl overflow-hidden">
                        <div class="p-6 bg-gradient-to-r from-red-950 to-red-900 text-orange-200">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h2 class="text-2xl font-bold">Booking Overview</h2>
                                    <p class="text-orange-300 mt-2">Track and manage all event bookings</p>
                                </div>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Performance Stats -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Total Events Card -->
                <div class="bg-white border-4 border-orange-300 p-6 rounded-2xl shadow-lg text-center">
                    <div class="mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-blue-500" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800">{{ $totalEvents ?? 0 }}</h3>
                    <p class="text-gray-500 mt-2">Total Events</p>
                </div>

                <!-- Total Bookings Card -->
                <div class="bg-white border-4 border-orange-300 p-6 rounded-2xl shadow-lg text-center">
                    <div class="mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-green-500" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800">{{ $totalBookings ?? 0 }}</h3>
                    <p class="text-gray-500 mt-2">Total Bookings</p>
                </div>

                <!-- Total Revenue Card -->
                <div class="bg-white border-4 border-orange-300 p-6 rounded-2xl shadow-lg text-center">
                    <div class="mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-yellow-500" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800">${{ number_format($totalRevenue ?? 0, 2) }}</h3>
                    <p class="text-gray-500 mt-2">Total Revenue</p>
                </div>
            </div>
        </div>
    </div>
@endsection
