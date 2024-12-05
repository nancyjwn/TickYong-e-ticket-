<x-guest-layout>
    <div class="shadow-lg">
        <div class="w-full sm:max-w-md mt-6 px-6 py-8 bg-white shadow-md overflow-hidden sm:rounded-lg">
            <div class="mb-6 text-center">
                <h1 class="text-3xl font-bold text-gray-800">{{ __('Welcome Back') }}</h1>
                <p class="text-gray-600 mt-2">{{ __('Log in to continue to your account') }}</p>
            </div>

            <!-- Session Status -->
            <x-auth-session-status
                class="mb-4 text-center rounded-md p-3 
                {{ session('status') ? 'bg-green-100 text-green-800' : '' }}"
                :status="session('status')" />

            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf

                <!-- Email Address -->
                <div>
                    <x-input-label for="email" :value="__('Email Address')" />
                    <x-text-input id="email"
                        class="block mt-1 w-full border-0 ring-1 ring-gray-300 focus:ring-indigo-500 focus:ring-2 rounded-md"
                        type="email" name="email" :value="old('email')" required autofocus autocomplete="username"
                        placeholder="{{ __('Enter your email') }}" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div>
                    <x-input-label for="password" :value="__('Password')" />
                    <x-text-input id="password"
                        class="block mt-1 w-full border-0 ring-1 ring-gray-300 focus:ring-indigo-500 focus:ring-2 rounded-md"
                        type="password" name="password" required autocomplete="current-password"
                        placeholder="{{ __('Enter your password') }}" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Remember Me and Forgot Password -->
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input id="remember_me" type="checkbox" name="remember"
                            class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                        <label for="remember_me" class="ms-2 block text-sm text-gray-900">
                            {{ __('Remember me') }}
                        </label>
                    </div>

                    @if (Route::has('password.request'))
                        <div class="text-sm">
                            <a href="{{ route('password.request') }}"
                                class="font-medium text-indigo-600 hover:text-indigo-500">
                                {{ __('Forgot password?') }}
                            </a>
                        </div>
                    @endif
                </div>

                <div>
                    <x-primary-button class="w-full flex justify-center py-2 px-4 bg-red-900 hover:bg-red-950">
                        {{ __('Log in') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
