<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Flowbite -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    @vite('resources/css/app.css')
    <style>
        html {
            scroll-behavior: smooth;
        }
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f9fafb;
            color: #374151;
        }
    </style>
</head>

<body class="min-h-screen flex flex-col">
    <!-- Navbar -->
    @include('components.navbar')


    <!-- Main Content -->
    <main class="flex-1 container mx-auto px-4 py-6">
        @yield('content')
    </main>

    <!-- Footer -->
    @include('components.footer')


    <script>
        // Mobile menu toggle
        document.getElementById('menu-toggle').addEventListener('click', () => {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        });

        document.addEventListener('DOMContentLoaded', function() {
            const items = document.querySelectorAll('#top-events-carousel [data-carousel-item]');
            const options = {
                interval: 3000, // Interval dalam milidetik
                autoplay: true,
            };
            const carousel = new Carousel(items, options);
            carousel.cycle();
        });
    </script>
</body>

</html>
