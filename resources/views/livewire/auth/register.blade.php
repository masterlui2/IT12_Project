<x-layouts.auth>
    <div class="flex items-center justify-center bg-neutral-950">
        <div class="w-[650px] min-w-[650px] bg-white dark:bg-neutral-900 rounded-xl shadow-xl p-8 space-y-4">
            <div class="text-center space-y-3">
                <x-app-logo-icon class="h-18 w-18 mx-auto fill-current text-black dark:text-white" />
                <x-auth-header
                    :title="__('Create an account')"
                    :description="__('Enter your details below to sign up')"
                />
            </div>

            <form method="POST" action="{{ route('register.store') }}" class="flex flex-col gap-6 text-left mx-auto w-full max-w-lg">
                @csrf

                <div class="grid grid-cols-2 gap-4">
                    <flux:input
                        name="first_name"
                        :label="__('First name')"
                        type="text"
                        required
                        autofocus
                        autocomplete="given-name"
                        placeholder="John"
                    />

                    <flux:input
                        name="last_name"
                        :label="__('Last name')"
                        type="text"
                        required
                        autocomplete="family-name"
                        placeholder="Doe"
                    />
                </div>

                <flux:input
                    name="birthday"
                    :label="__('Birthday')"
                    type="date"
                    required
                    autocomplete="bday"
                />

                <flux:input
                    name="email"
                    :label="__('Email address')"
                    type="email"
                    required
                    autocomplete="email"
                    placeholder="email@example.com"
                />

                <flux:input
                    name="password"
                    :label="__('Password')"
                    type="password"
                    required
                    autocomplete="new-password"
                    :placeholder="__('Password')"
                    viewable
                />

                <p class="-mt-4 text-xs text-zinc-600 dark:text-zinc-400">
                    {{ __('Password must be at least 12 characters and include uppercase, lowercase, number, and special character.') }}
                </p>

                <flux:input
                    name="password_confirmation"
                    :label="__('Confirm password')"
                    type="password"
                    required
                    autocomplete="new-password"
                    :placeholder="__('Confirm password')"
                    viewable
                />

              {{-- Real Google reCAPTCHA --}}
<div>
    <div class="g-recaptcha" data-sitekey="{{ $siteKey }}"></div>

    @error('g-recaptcha-response')
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>

{{-- reCAPTCHA script before closing tag --}}
@push('scripts')
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
@endpush
                <flux:button variant="primary" type="submit" class="w-full py-3 text-base font-semibold">
                    {{ __('Create account') }}
                </flux:button>
            </form>

            <div class="space-x-1 text-sm text-center text-zinc-600 dark:text-zinc-400 mt-2">
                <span>{{ __('Already have an account?') }}</span>
                <flux:link :href="route('login')" wire:navigate>
                    {{ __('Log in') }}
                </flux:link>
            </div>
        </div>
    </div>
</x-layouts.auth>