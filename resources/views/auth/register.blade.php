<x-guest-layout>
    <div>
        <div class="w-full sm:max-w-md mt-6 px-6 py-8 bg-white shadow-md overflow-hidden sm:rounded-lg">
            <div class="mb-6 text-center">
                <h1 class="text-3xl font-bold text-gray-800">{{ __('Create an Account') }}</h1>
                <p class="text-gray-600 mt-2">{{ __('Join our community and explore exciting opportunities') }}</p>
            </div>

            <form method="POST" action="{{ route('register') }}" class="space-y-6">
                @csrf

                <!-- Name -->
                <div>
                    <x-input-label for="name" :value="__('Full Name')" />
                    <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')"
                        required autofocus autocomplete="name" placeholder="{{ __('Enter your full name') }}" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <!-- Email Address -->
                <div>
                    <x-input-label for="email" :value="__('Email Address')" />
                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email"
                        :value="old('email')" required autocomplete="username" placeholder="{{ __('Enter your email') }}" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div>
                    <x-input-label for="password" :value="__('Password')" />
                    <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                        autocomplete="new-password" placeholder="{{ __('Create a strong password') }}" />
                    <div class="mt-1 text-xs text-gray-500">
                        {{ __('Password must be at least 8 characters long') }}
                    </div>
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Confirm Password -->
                <div>
                    <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                    <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password"
                        name="password_confirmation" required autocomplete="new-password"
                        placeholder="{{ __('Repeat your password') }}" />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>

                <!-- Role -->
                <div>
                    <x-input-label for="role" :value="__('Select Your Role')" />
                    <div class="grid grid-cols-2 gap-4 mt-2">
                        <label
                            class="p-4 rounded-lg border transition duration-200
            {{ old('role', 'user') == 'user' ? 'border-blue-500 bg-blue-50' : 'border-gray-200' }} 
            cursor-pointer">
                            <div class="flex items-center justify-between">
                                <span class="font-medium text-gray-700">{{ __('User') }}</span>
                                <input type="radio" name="role" value="user"
                                    class="form-radio text-blue-600 focus:ring-blue-500"
                                    {{ old('role', 'user') == 'user' ? 'checked' : '' }}>
                            </div>
                            <p class="text-xs text-gray-500 mt-1">{{ __('Browse and participate in events') }}</p>
                        </label>
                        <label
                            class="p-4 rounded-lg border transition duration-200
            {{ old('role') == 'event_organizer' ? 'border-blue-500 bg-blue-50' : 'border-gray-200' }} 
            cursor-pointer">
                            <div class="flex items-center justify-between">
                                <span class="font-medium text-gray-700">{{ __('Event Organizer') }}</span>
                                <input type="radio" name="role" value="event_organizer"
                                    class="form-radio text-blue-600 focus:ring-blue-500"
                                    {{ old('role') == 'event_organizer' ? 'checked' : '' }}>
                            </div>
                            <p class="text-xs text-gray-500 mt-1">{{ __('Create and manage events') }}</p>
                        </label>
                    </div>
                    <x-input-error :messages="$errors->get('role')" class="mt-2" />
                </div>


                <div class="flex items-center justify-between mt-6">
                    <a href="{{ route('login') }}" class="text-sm text-gray-600 hover:text-gray-900 hover:underline">
                        {{ __('Already registered?') }}
                    </a>

                    <x-primary-button class="w-150 flex justify-center py-2 px-4 bg-red-900 hover:bg-red-950">
                        {{ __('Create Account') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
