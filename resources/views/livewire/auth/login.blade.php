<x-layouts.auth>
    <div class="flex items-center justify-center bg-neutral-950">
        
        <!-- Desktop Login Card -->
        <div class="w-[650px] min-w-[650px] bg-white dark:bg-neutral-900 rounded-xl shadow-xl p-8 space-y-4">

            <!-- Logo + Header -->
            <div class="text-center space-y-3">
                <x-app-logo-icon class="h-18 w-18 mx-auto fill-current text-black dark:text-white" />
                <x-auth-header 
                    :title="__('Log in to your account')" 
                    :description="__('Enter your email and password below to log in')" 
                />
            </div>

            <!-- Session Status -->
            <x-auth-session-status class="text-center" :status="session('status')" />

            <!-- Login Form -->
            <form method="POST" action="{{ route('login.store') }}" class="flex flex-col gap-6 text-left mx-auto w-full max-w-lg">
                @csrf

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email address</label>
                    <input id="email" name="email" type="email" required autofocus autocomplete="email" placeholder="email@example.com"
                           class="mt-1 p-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm placeholder-gray-300">
                </div>

                <!-- Password + Forgot Link -->
                <div class="relative">
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <input id="password" name="password" type="password" required autocomplete="current-password" placeholder="Password"
                           class="mt-1 p-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm placeholder-gray-300 mb-2">

                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-sm text-indigo-600 hover:underline">
                            {{ __('Forgot your password?') }}
                        </a>
                    @endif
                </div>

                <!-- Remember Me -->
                <div class="flex items-center">
                    <input id="remember" name="remember" type="checkbox" {{ old('remember') ? 'checked' : '' }}
                           class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                    <label for="remember" class="ml-2 block text-sm text-gray-700">
                        {{ __('Remember me') }}
                    </label>
                </div>

                <!-- Login Button -->
                <button type="submit"
                        class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded-md">
                    {{ __('Log in') }}
                </button>
            </form>

            <!-- Divider -->
            <div class="flex items-center justify-center mt-6">
                <hr class="flex-grow border-zinc-300 dark:border-zinc-600">
                <span class="mx-2 text-sm text-zinc-500">{{ __('or') }}</span>
                <hr class="flex-grow border-zinc-300 dark:border-zinc-600">
            </div>

            <!-- Social Logins -->
            <div class="flex justify-center gap-6 mt-4">
                <a href="{{ route('auth.google.redirect') }}"
                   class="flex items-center justify-center gap-2 w-[240px] px-4 py-3 text-sm font-medium text-gray-700 bg-white border-[2px] border-gray-300 rounded-md hover:bg-blue-50 dark:bg-neutral-800 dark:border-neutral-600 dark:text-white dark:hover:bg-neutral-700 transition">
                    <img src="/images/google.svg" alt="Google" class="w-5 h-5 bg-white rounded p-0.5">
                    {{ __('Continue with Google') }}
                </a>

                <a href="{{ route('auth.facebook.redirect') }}"
                   class="flex items-center justify-center gap-2 w-[240px] px-4 py-3 text-sm font-medium text-gray-700 bg-white border-[2px] border-gray-300 rounded-md hover:bg-blue-50 transition">
                    <img src="/images/facebook.svg" alt="Facebook" class="w-5 h-5">
                    {{ __('Continue with Facebook') }}
                </a>
            </div>

            <!-- Register -->
            @if (Route::has('register'))
                <div class="space-x-1 text-sm text-center text-zinc-600 dark:text-zinc-400 mt-2">
                    <span>{{ __('Don\'t have an account?') }}</span>
                    <a href="{{ route('register') }}" class="text-indigo-600 hover:underline">
                        {{ __('Sign up') }}
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-layouts.auth>
