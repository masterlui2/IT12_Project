<x-layouts.auth>
    <div class="w-full max-w-2xl mx-auto">
        <!-- Main Card -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <!-- Header with gradient background -->
            <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-5">
                <div class="flex items-center gap-3">
                    <div class="bg-white/20 rounded-full p-1.5">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-white">{{ __('Password Assistance') }}</h1>
                        <p class="text-blue-100 text-xs mt-0.5">{{ __('Submit your account details for admin identity verification') }}</p>
                    </div>
                </div>
            </div>

            <!-- Content -->
            <div class="p-6">
                @if (session('status'))
                    <div class="mb-4 rounded-lg border border-green-200 bg-green-50 px-3 py-2">
                        <div class="flex items-center gap-2 text-green-800">
                            <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span class="text-xs font-medium">{{ session('status') }}</span>
                        </div>
                    </div>
                @endif

                <!-- Verification Notice -->
                <div class="mb-4 rounded-lg border border-amber-200 bg-amber-50 p-3">
                    <div class="flex gap-2">
                        <div class="flex-shrink-0">
                            <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="font-medium text-amber-800 text-xs">
                                {{ __('Identity verification required') }}
                            </p>
                            <p class="mt-0.5 text-xs text-amber-700">
                                {{ __('Provide the details you used during registration. If details do not match, include other valid proof of identity to continue.') }}
                            </p>
                        </div>
                    </div>
                </div>

              <!-- Form -->
<form method="POST" action="{{ route('password.manual-request.store') }}" class="space-y-4">
    @csrf

    <!-- Email -->
    <div>
        <label class="block text-xs font-medium text-gray-700 mb-1">
            {{ __('Email address') }} <span class="text-red-500">*</span>
        </label>
        <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="h-4 w-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12H8m8 4H6m10-8H6m12 8a4 4 0 01-8 0 4 4 0 018 0z"></path>
                </svg>
            </div>
            <input type="email" 
                   name="email" 
                   value="{{ old('email') }}" 
                   required 
                   class="block w-full pl-9 pr-3 py-2 border border-gray-400 rounded-lg text-sm text-gray-900 placeholder-gray-600 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('email') border-red-400 bg-red-50 @enderror"
                   placeholder="you@example.com">
        </div>
        @error('email')
            <p class="mt-1 text-xs text-red-600 flex items-center gap-1">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                {{ $message }}
            </p>
        @enderror
    </div>

    <!-- Name Fields -->
    <div class="grid grid-cols-2 gap-3">
        <div>
            <label class="block text-xs font-medium text-gray-700 mb-1">
                {{ __('First name') }} <span class="text-red-500">*</span>
            </label>
            <input type="text" 
                   name="firstname" 
                   value="{{ old('firstname') }}" 
                   required 
                   class="block w-full px-3 py-2 border border-gray-400 rounded-lg text-sm text-gray-900 placeholder-gray-600 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('firstname') border-red-400 bg-red-50 @enderror"
                   placeholder="John">
            @error('firstname')
                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
            @enderror
        </div>
        <div>
            <label class="block text-xs font-medium text-gray-700 mb-1">
                {{ __('Last name') }} <span class="text-red-500">*</span>
            </label>
            <input type="text" 
                   name="lastname" 
                   value="{{ old('lastname') }}" 
                   required 
                   class="block w-full px-3 py-2 border border-gray-400 rounded-lg text-sm text-gray-900 placeholder-gray-600 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('lastname') border-red-400 bg-red-50 @enderror"
                   placeholder="Doe">
            @error('lastname')
                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <!-- Birthday -->
    <div>
        <label class="block text-xs font-medium text-gray-700 mb-1">
            {{ __('Birthday') }} <span class="text-red-500">*</span>
        </label>
        <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="h-4 w-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
            </div>
            <input type="date" 
                   name="birthday" 
                   value="{{ old('birthday') }}" 
                   required 
                   class="block w-full pl-9 pr-3 py-2 border border-gray-400 rounded-lg text-sm text-gray-900 placeholder-gray-600 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('birthday') border-red-400 bg-red-50 @enderror">
        </div>
        @error('birthday')
            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <!-- Alternative Proof -->
    <div>
        <label class="block text-xs font-medium text-gray-700 mb-1">
            {{ __('Alternative proof of identity') }}
            <span class="text-gray-600 font-normal ml-1">{{ __('(if details do not match)') }}</span>
        </label>
        <textarea name="proof_details" 
                  rows="3" 
                  class="block w-full px-3 py-2 border border-gray-400 rounded-lg text-sm text-gray-900 placeholder-gray-600 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('proof_details') border-red-400 bg-red-50 @enderror"
                  placeholder="Example: recent transaction details, registered contact number, security answers, or other verifiable information.">{{ old('proof_details') }}</textarea>
        @error('proof_details')
            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
        @enderror
        <p class="mt-1 text-xs text-gray-600">
            {{ __('Providing alternative proof helps us verify your identity faster.') }}
        </p>
    </div>

    

                    <!-- Submit Button -->
                    <div class="pt-2">
                        <button type="submit" 
                                class="w-full px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg shadow-sm hover:shadow transition-all duration-200 flex items-center justify-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            {{ __('Submit Request') }}
                        </button>
                    </div>
                </form>

                <!-- Footer Link -->
                <div class="mt-6 pt-4 border-t border-gray-200">
                    <div class="text-center">
                        <span class="text-xs text-gray-600">{{ __('Return to') }}</span>
                        <flux:link :href="route('login')" 
                                   wire:navigate 
                                   class="ml-1 text-xs text-blue-600 hover:text-blue-800 font-medium hover:underline transition-colors">
                            {{ __('log in') }}
                        </flux:link>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.auth>