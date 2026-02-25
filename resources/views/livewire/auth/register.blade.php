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
                    <!-- First Name -->
                    <flux:input
                        name="first_name"
                        :label="__('First name')"
                        type="text"
                        required
                        autocomplete="given-name"
                        placeholder="John"
                    />
                    <!-- Last Name -->
                    <flux:input
                        name="last_name"
                        :label="__('Last name')"
                        type="text"
                        required
                        autocomplete="family-name"
                        placeholder="Doe"
                    />
                </div>

                <!-- Birthday -->
                <flux:input
                    name="birthday"
                    :label="__('Birthday')"
                    type="date"
                    required
                    :max="now()->toDateString()"
                    />


                <!-- Email -->
                <flux:input
                    name="email"
                    :label="__('Email address')"
                    type="email"
                    required
                    autocomplete="email"
                    placeholder="email@example.com"
                />

                <!-- Password -->
                 <div>
                <flux:input
                    name="password"
                    :label="__('Password')"
                    type="password"
                    required
                    autocomplete="new-password"
                    placeholder="Password"
                    viewable
                />
                  <!-- Password Requirements -->
                <p class="mt-2 text-sm text-zinc-500 dark:text-zinc-400">
                    Password must be at least 
                    <span class="font-semibold">12 characters</span> 
                    and include at least 
                    <span class="font-semibold">one special symbol</span> 
                    (e.g. ! @ # $ % & *).
                </p>
                </div>          <!-- Confirm Password -->
                <flux:input
                    name="password_confirmation"
                    :label="__('Confirm password')"
                    type="password"
                    required
                    autocomplete="new-password"
                    placeholder="Confirm password"
                    viewable
                />
             <!-- Human verification -->
                @if ($recaptchaEnabled)
                    <div class="space-y-2">
                        <div class="g-recaptcha" data-sitekey="{{ config('services.recaptcha.site_key') }}"></div>
                        @error('g-recaptcha-response')
                            <p class="text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                @else
                    <div class="space-y-2 rounded-lg border border-zinc-300 p-4 dark:border-zinc-700">
                        <p class="text-sm text-zinc-600 dark:text-zinc-300">
                            {{ __('Human check: solve this puzzle') }}
                        </p>
                        <flux:input
                            name="human_challenge_answer"
                            :label="__('What is :challenge?', ['challenge' => $humanChallenge])"
                            type="text"
                            required
                            inputmode="numeric"
                            placeholder="Enter your answer"
                        />
                        @error('human_challenge_answer')
                            <p class="text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                @endif

                <!-- Submit Button -->
                <flux:button 
                    type="submit" 
                    variant="primary" 
                    class="w-full py-3 text-base font-semibold" 
                    data-test="register-user-button"
                >
                    {{ __('Create account') }}
                </flux:button>
            </form>

            <!-- Divider -->
            <div class="flex items-center justify-center">
                <hr class="flex-grow border-zinc-300 dark:border-zinc-600">
                <span class="mx-2 text-sm text-zinc-500">{{ __('or') }}</span>
                <hr class="flex-grow border-zinc-300 dark:border-zinc-600">
            </div>

            <!-- Existing User Link -->
            <div class="space-x-1 text-sm text-center text-zinc-600 dark:text-zinc-400 mt-2">
                <span>{{ __('Already have an account?') }}</span>
                <flux:link :href="route('login')" wire:navigate>
                    {{ __('Log in') }}
                </flux:link>
            </div>
        </div>
    </div>
 @if ($recaptchaEnabled)
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    @endif
</x-layouts.auth>
