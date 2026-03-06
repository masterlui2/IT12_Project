<x-layouts.auth>
    <div class="w-full max-w-md mx-auto bg-white rounded-lg shadow-lg p-8">
        <div class="flex flex-col gap-6">
              <x-auth-header
                :title="__('Password Assistance')"
                :description="__('Password resets are handled manually by an Administrator for account security.')"
            />

            <div class="rounded-lg border border-amber-200 bg-amber-50 px-4 py-3 text-sm text-amber-900">
                <p class="font-semibold flex items-center gap-2">
                    <i class="fas fa-triangle-exclamation text-amber-600"></i>
                    {{ __('Identity verification required') }}
                </p>
                <p class="mt-1">
                    {{ __('To change your password, contact an Administrator. They will verify your identity using security questions and key account details before approving a reset.') }}
                </p>
            </div>

           <div class="rounded-lg border border-gray-200 bg-gray-50 px-4 py-3 text-sm text-gray-700">
                <p class="font-semibold">{{ __('What to prepare before contacting Admin:') }}</p>
                <ul class="mt-2 list-disc space-y-1 pl-5">
                    <li>{{ __('Registered email address and full name') }}</li>
                    <li>{{ __('Recent account activity or account creation details') }}</li>
                    <li>{{ __('Answers to security verification questions') }}</li>
                </ul>
            </div>

  <div class="space-y-2 text-sm text-zinc-600">
                <p>{{ __('Need immediate help? Reach out to the Admin team through your assigned manager or official support channel.') }}</p>
            </div>
            <div class="space-x-1 rtl:space-x-reverse text-center text-sm text-zinc-600">
                <span>{{ __('Return to') }}</span>                <flux:link :href="route('login')" wire:navigate class="text-blue-600 hover:text-blue-700">
                    {{ __('log in') }}
                </flux:link>
            </div>
        </div>
    </div>
</x-layouts.auth>