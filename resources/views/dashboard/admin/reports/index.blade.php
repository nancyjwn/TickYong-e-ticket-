@extends('layouts.master')

@section('content')
    <div class="container mx-auto px-4 py-8 space-y-12">

        <!-- Back Button -->
        <div class="flex items-center space-x-4 mb-4">
            <a href="javascript:history.back()"
                class="flex items-center space-x-2 text-gray-600 hover:text-red-950 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                    stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                </svg>
                <span class="font-medium text-base"></span>
            </a>
        </div>

        <!-- Page Title -->
        <div class="text-center">
            <h1 class="text-4xl font-extrabold text-gray-800 tracking-tight">Analytics Dashboard</h1>
        </div>

        <!-- General Statistics -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Total Users -->
            <div class="bg-white shadow-md rounded-lg p-6 text-center border border-gray-200">
                <h3 class="text-xl font-semibold text-gray-600">Total Users</h3>
                <p class="text-3xl font-bold text-gray-800">{{ $totalUsers }}</p>
            </div>

            <!-- Total Organizers -->
            <div class="bg-white shadow-md rounded-lg p-6 text-center border border-gray-200">
                <h3 class="text-xl font-semibold text-gray-600">Total Organizers</h3>
                <p class="text-3xl font-bold text-gray-800">{{ $totalOrganizers }}</p>
            </div>

            <!-- Total Bookings -->
            <div class="bg-white shadow-md rounded-lg p-6 text-center border border-gray-200">
                <h3 class="text-xl font-semibold text-gray-600">Total Bookings</h3>
                <p class="text-3xl font-bold text-gray-800">{{ $totalBookings }}</p>
            </div>
        </div>

        <!-- Sales and Tickets Graphs -->
        <div class="bg-white shadow-md rounded-lg p-6 border border-gray-200">
            <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">Ticket Sales and Event Performance</h2>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Revenue Chart -->
                <div>
                    <canvas id="revenueChart"></canvas>
                </div>
                <!-- Tickets Sold Chart -->
                <div>
                    <canvas id="ticketsChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Booking Status Summary -->
        <div class="bg-white shadow-md rounded-lg p-6 border border-gray-200">
            <h3 class="text-2xl font-bold text-gray-800 mb-6 text-center">Booking Status Summary</h3>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-8 text-center">
                <!-- Approved -->
                <div class="bg-gray-50 shadow-sm rounded-lg p-6">
                    <h3 class="text-4xl font-extrabold text-green-600">{{ $statusStats['approved'] ?? 0 }}</h3>
                    <p class="text-lg text-gray-600 mt-2">Approved</p>
                </div>

                <!-- Pending -->
                <div class="bg-gray-50 shadow-sm rounded-lg p-6">
                    <h3 class="text-4xl font-extrabold text-yellow-500">{{ $statusStats['pending'] ?? 0 }}</h3>
                    <p class="text-lg text-gray-600 mt-2">Pending</p>
                </div>

                <!-- Canceled -->
                <div class="bg-gray-50 shadow-sm rounded-lg p-6">
                    <h3 class="text-4xl font-extrabold text-red-600">{{ $statusStats['canceled'] ?? 0 }}</h3>
                    <p class="text-lg text-gray-600 mt-2">Canceled</p>
                </div>
            </div>
        </div>

    </div>

    <!-- Chart.js Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Revenue Chart
        var revenueChart = new Chart(document.getElementById("revenueChart"), {
            type: 'line',
            data: {
                labels: @json($eventNames),
                datasets: [{
                    label: 'Total Revenue (Rp)',
                    data: @json($totalRevenuePerEvent),
                    borderColor: 'rgba(75, 192, 192, 1)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderWidth: 2,
                    tension: 0.4,
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                        labels: {
                            color: '#333'
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            color: '#555'
                        }
                    },
                    x: {
                        ticks: {
                            color: '#555'
                        }
                    }
                }
            }
        });

        // Tickets Sold Chart
        var ticketsChart = new Chart(document.getElementById("ticketsChart"), {
            type: 'bar',
            data: {
                labels: @json($eventNames),
                datasets: [{
                    label: 'Tickets Sold',
                    data: @json($totalTicketsPerEvent),
                    backgroundColor: 'rgba(54, 162, 235, 0.6)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                        labels: {
                            color: '#333'
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            color: '#555'
                        }
                    },
                    x: {
                        ticks: {
                            color: '#555'
                        }
                    }
                }
            }
        });
    </script>
@endsection
