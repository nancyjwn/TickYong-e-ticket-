@extends('layouts.master')

@section('content')
    <div class="min-h-screen bg-white p-4 md:p-8">
        <div class="container mx-auto">
            <!-- Welcome Section -->
            <div class="mb-8">
                <div class="bg-orange-100 shadow-md rounded-lg overflow-hidden">
                    <div class="p-6 bg-gradient-to-r from-red-950 to-red-900">
                        <h1 class="text-3xl font-extrabold text-orange-100 mb-2">Admin Dashboard</h1>
                        <p class="text-orange-100 opacity-80">Selamat datang di pusat kendali administrator.</p>
                    </div>
                    <div class="p-6">
                        <p class="text-red-950">Anda dapat mengelola acara, pengguna, dan berbagai aspek sistem dari sini.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Dashboard Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Manage Events Card -->
                <div class="group">
                    <a href="{{ route('admin.events.index') }}" class="block">
                        <div
                            class="bg-orange-200 border border-red-900 rounded-lg shadow-md hover:shadow-lg transition-all duration-300 transform hover:-translate-y-2 overflow-hidden">
                            <div class="p-6 bg-gradient-to-r from-red-950 to-red-900">
                                <div class="flex justify-between items-center mb-4">
                                    <h2 class="text-xl font-bold text-orange-200">Manage Events</h2>
                                    <i class="fas fa-calendar-alt h-8 w-8 text-red-700"></i>
                                </div>
                                <p class="text-sm text-orange-100 opacity-80">Kelola semua acara yang ada di sistem.</p>
                            </div>
                            <div class="p-4 bg-red-50 group-hover:bg-red-100 transition-colors">
                                <div class="flex items-center justify-between">
                                    <span class="text-sm font-medium text-red-950">Lihat Semua Acara</span>
                                    <i class="fas fa-arrow-right text-red-800"></i>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Manage Users Card -->
                <div class="group">
                    <a href="{{ route('admin.users') }}" class="block">
                        <div
                            class="bg-orange-200 border border-red-900 rounded-lg shadow-md hover:shadow-lg transition-all duration-300 transform hover:-translate-y-2 overflow-hidden">
                            <div class="p-6 bg-gradient-to-r from-red-950 to-red-900">
                                <div class="flex justify-between items-center mb-4">
                                    <h2 class="text-xl font-bold text-orange-200">Manage Users</h2>
                                    <i class="fas fa-users h-8 w-8 text-red-700"></i>
                                </div>
                                <p class="text-sm text-orange-100 opacity-80">Lihat dan kelola data pengguna.</p>
                            </div>
                            <div class="p-4 bg-red-50 group-hover:bg-red-100 transition-colors">
                                <div class="flex items-center justify-between">
                                    <span class="text-sm font-medium text-red-950">Kelola Pengguna</span>
                                    <i class="fas fa-arrow-right text-red-800"></i>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- View Bookings Card -->
                <div class="group">
                    <a href="{{ route('admin.bookings.index') }}" class="block">
                        <div
                            class="bg-orange-200 border border-red-900 rounded-lg shadow-md hover:shadow-lg transition-all duration-300 transform hover:-translate-y-2 overflow-hidden">
                            <div class="p-6 bg-gradient-to-r from-red-950 to-red-900">
                                <div class="flex justify-between items-center mb-4">
                                    <h2 class="text-xl font-bold text-orange-200">Manage Bookings</h2>
                                    <i class="fas fa-ticket-alt h-8 w-8 text-red-700"></i>
                                </div>
                                <p class="text-sm text-orange-100 opacity-80">Lihat dan kelola semua pemesanan.</p>
                            </div>
                            <div class="p-4 bg-red-50 group-hover:bg-red-100 transition-colors">
                                <div class="flex items-center justify-between">
                                    <span class="text-sm font-medium text-red-950">Laporan Pemesanan</span>
                                    <i class="fas fa-arrow-right text-red-800"></i>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Manage Reports Card -->
                <div class="group">
                    <a href="{{ route('admin.reports.index') }}" class="block">
                        <div
                            class="bg-orange-200 border border-red-900 rounded-lg shadow-md hover:shadow-lg transition-all duration-300 transform hover:-translate-y-2 overflow-hidden">
                            <div class="p-6 bg-gradient-to-r from-red-950 to-red-900">
                                <div class="flex justify-between items-center mb-4">
                                    <h2 class="text-xl font-bold text-orange-200">Manage Reports</h2>
                                    <i class="fas fa-chart-bar h-8 w-8 text-red-700"></i>
                                </div>
                                <p class="text-sm text-orange-100 opacity-80">Lihat laporan penjualan tiket dan statistik.
                                </p>
                            </div>
                            <div class="p-4 bg-red-50 group-hover:bg-red-100 transition-colors">
                                <div class="flex items-center justify-between">
                                    <span class="text-sm font-medium text-red-950">Lihat Laporan</span>
                                    <i class="fas fa-arrow-right text-red-800"></i>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
