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

            <!-- Session status -->
            <x-auth-session-status class="text-center" :status="session('status')" />

            <!-- Login form -->
            <form method="POST" action="{{ route('login.store') }}" class="flex flex-col gap-6 text-left mx-auto w-full max-w-lg">
                @csrf

                <flux:input
                    name="email"
                    :label="__('Email address')"
                    type="email"
                    required
                    autofocus
                    autocomplete="email"
                    placeholder="email@example.com"
                />

                <div class="relative">
                    <flux:input
                        name="password"
                        :label="__('Password')"
                        type="password"
                        required
                        autocomplete="current-password"
                        :placeholder="__('Password')"
                        viewable
                    />

                    @if (Route::has('password.request'))
                        <flux:link class="absolute top-0 text-sm end-0" :href="route('password.request')" wire:navigate>
                            {{ __('Forgot your password?') }}
                        </flux:link>
                    @endif
                </div>

                <flux:checkbox name="remember" :label="__('Remember me')" :checked="old('remember')" />

                <flux:button variant="primary" type="submit" class="w-full py-3 text-base font-semibold" data-test="login-button">
                    {{ __('Log in') }}
                </flux:button>
            </form>

            <!-- Divider -->
            <div class="flex items-center justify-center">
                <hr class="flex-grow border-zinc-300 dark:border-zinc-600">
                <span class="mx-2 text-sm text-zinc-500">{{ __('or') }}</span>
                <hr class="flex-grow border-zinc-300 dark:border-zinc-600">
            </div>

            <!-- Social Logins -->
            <div class="flex justify-center gap-6">
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
                    <flux:link :href="route('register')" wire:navigate>
                        {{ __('Sign up') }}
                    </flux:link>
                </div>
            @endif
        </div>
    </div>
</x-layouts.auth>
