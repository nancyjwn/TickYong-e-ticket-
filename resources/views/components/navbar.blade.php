<nav class="bg-red-950 border-red-950 sticky top-0 z-50">
    <div class="max-w-screen-xl flex items-center justify-between mx-auto p-4">
        <!-- Logo -->
        <div class="flex justify-start">
            <a href="#" class="flex items-center space-x-3 rtl:space-x-reverse">
                <span class="self-center text-2xl font-semibold whitespace-nowrap text-orange-100">-TICKYONG-</span>
            </a>
        </div>

        <!-- Navbar Items (Center) -->
        <div class="flex-1 flex justify-center space-x-8 font-bold">
            @if (!Auth::check() || (Auth::check() && Auth::user()->role === 'user'))
                <a href="/" class="block py-2 px-3 text-orange-100 hover:text-orange-200 transition">Home</a>
            @endif

            @if (!Auth::check() || (Auth::check() && Auth::user()->role === 'user'))
                <a href="{{ route('dashboard.user.events.index') }}"
                    class="block py-2 px-3 text-orange-100 hover:text-orange-200 transition">Event</a>
            @endif

            @if (!Auth::check() || (Auth::check() && Auth::user()->role === 'user'))
                <a href="#home-details"
                    class="block py-2 px-3 text-orange-100 hover:text-orange-200 transition">Details</a>
            @endif

            @if (Auth::check() && Auth::user()->role === 'organizer')
                <a href="{{ route('organizer.dashboard') }}"
                    class="block py-2 px-3 text-orange-100 hover:text-orange-200 transition">Organizer Dashboard</a>
            @endif

            @if (Auth::check() && Auth::user()->role === 'admin')
                <a href="{{ route('admin.dashboard') }}"
                    class="block py-2 px-3 text-orange-100 hover:text-orange-200 transition">Admin Dashboard</a>
            @endif
        </div>

        <!-- User Actions -->
        <div class="flex items-center font-bold">
            @if (Auth::check())
                <button type="button"
                    class="flex text-sm bg-orange-100 text-red-950 rounded-full focus:ring-4 focus:ring-orange-200 px-4 py-2"
                    id="user-menu-button" data-dropdown-toggle="user-dropdown">
                    <span>{{ Auth::user()->name }}</span>
                </button>
                <!-- Dropdown menu for Authenticated Users -->
                <div id="user-dropdown"
                    class="hidden z-50 text-base list-none bg-white divide-y divide-gray-100 rounded-lg shadow">
                    <div class="px-4 py-3">
                        <span class="block text-sm text-red-950">{{ Auth::user()->name }}</span>
                        <span class="block text-sm text-rose-950 truncate">{{ Auth::user()->email }}</span>
                    </div>
                    <ul class="py-2">
                        <li>
                            <a href="{{ route('profile.edit') }}"
                                class="block px-4 py-2 text-sm text-red-950 hover:bg-orange-100">Profile</a>
                        </li>
                        <li>
                            <button class="block w-full text-left px-4 py-2 text-sm text-red-950 hover:bg-orange-100"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                Sign out
                            </button>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </div>
            @else
                <button type="button"
                    class="flex text-sm bg-orange-100 text-red-950 rounded-full focus:ring-4 focus:ring-gray-300 px-4 py-2"
                    id="guest-menu-button" data-dropdown-toggle="guest-dropdown">
                    <span>Guest</span>
                </button>

                <!-- Dropdown menu for Guests -->
                <div id="guest-dropdown"
                    class="hidden z-50 text-base list-none bg-white divide-y divide-gray-100 rounded-lg shadow">
                    <ul class="py-2">
                        <li><a href="{{ route('login') }}"
                                class="block px-4 py-2 text-sm text-red-950 hover:bg-orange-100">Login</a></li>
                        <li><a href="{{ route('register') }}"
                                class="block px-4 py-2 text-sm text-red-950 hover:bg-orange-100">Register</a>
                        </li>
                    </ul>
                </div>
            @endif
        </div>
    </div>
</nav>
