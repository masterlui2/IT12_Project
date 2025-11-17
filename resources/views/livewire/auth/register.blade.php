<x-layouts.auth>
    <div class="flex items-center justify-center bg-neutral-950">
        
        <!-- Registration Card -->
        <div class="w-[650px] min-w-[650px] bg-white dark:bg-neutral-900 rounded-xl shadow-xl p-8 space-y-4">

            <!-- Header -->
            <div class="text-center space-y-3">
                <x-app-logo-icon class="h-18 w-18 mx-auto fill-current text-black dark:text-white" />
                <x-auth-header 
                    :title="__('Create an account')" 
                    :description="__('Enter your details below to create your account')" 
                />
            </div>

            <!-- Session Status -->
            <x-auth-session-status class="text-center" :status="session('status')" />

            <!-- Register Form -->
            <form method="POST" action="{{ route('register.store') }}" class="flex flex-col gap-6 text-left mx-auto w-full max-w-lg">
                @csrf

                <!-- Name Section (Two Columns) -->
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="first_name" class="block text-sm font-medium text-gray-700">First Name</label>
                        <input id="first_name" name="first_name" type="text" required autocomplete="given-name" placeholder="John"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    </div>

                    <div>
                        <label for="last_name" class="block text-sm font-medium text-gray-700">Last Name</label>
                        <input id="last_name" name="last_name" type="text" required autocomplete="family-name" placeholder="Doe"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    </div>
                </div>

                <!-- Birthday -->
                <div>
                    <label for="birthday" class="block text-sm font-medium text-gray-700">Birthday</label>
                    <input id="birthday" name="birthday" type="date" required
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input id="email" name="email" type="email" required autocomplete="email" placeholder="email@example.com"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <input id="password" name="password" type="password" required autocomplete="new-password" placeholder="Password"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                </div>

                <!-- Confirm Password -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password</label>
                    <input id="password_confirmation" name="password_confirmation" type="password" required autocomplete="new-password" placeholder="Confirm Password"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                </div>

                <!-- Role Selector (Customer / Technician) -->
                <div>
                    <label for="role" class="block text-sm font-medium text-gray-700">Select Role</label>
                    <select id="role" name="role" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        <option value="Customer">Customer</option>
                        <option value="Technician">Technician</option>
                    </select>
                </div>

                <!-- Submit Button -->
                <button type="submit"
                        class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded-md">
                    {{ __('Create account') }}
                </button>
            </form>

            <!-- Divider -->
            <div class="flex items-center justify-center mt-6">
                <hr class="flex-grow border-zinc-300 dark:border-zinc-600">
                <span class="mx-2 text-sm text-zinc-500">{{ __('or') }}</span>
                <hr class="flex-grow border-zinc-300 dark:border-zinc-600">
            </div>

            <!-- Existing User Link -->
            <div class="space-x-1 text-sm text-center text-zinc-600 dark:text-zinc-400 mt-2">
                <span>{{ __('Already have an account?') }}</span>
                <a href="{{ route('login') }}" class="text-indigo-600 hover:underline">
                    {{ __('Log in') }}
                </a>
            </div>

        </div>
    </div>
</x-layouts.auth>
