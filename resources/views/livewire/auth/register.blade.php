<x-layouts.auth>
    <div class="w-full max-w-2xl mx-auto">
        <!-- Main Card -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <!-- Header with gradient background -->
            <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-8 py-6">
                <div class="flex items-center gap-3">
                    <div class="bg-white/20 rounded-full p-2">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-white">{{ __('Password Assistance') }}</h1>
                        <p class="text-blue-100 text-sm mt-1">{{ __('Submit your account details for admin identity verification') }}</p>
                    </div>
                </div>
            </div>

            <!-- Content -->
            <div class="p-8">
                @if (session('status'))
                    <div class="mb-6 rounded-xl border border-green-200 bg-green-50 px-4 py-3">
                        <div class="flex items-center gap-2 text-green-800">
                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span class="text-sm font-medium">{{ session('status') }}</span>
                        </div>
                    </div>
                @endif

                <!-- Verification Notice -->
                <div class="mb-6 rounded-xl border border-amber-200 bg-amber-50 p-4">
                    <div class="flex gap-3">
                        <div class="flex-shrink-0">
                            <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="font-semibold text-amber-800 text-sm">
                                {{ __('Identity verification required') }}
                            </p>
                            <p class="mt-1 text-sm text-amber-700">
                                {{ __('Provide the details you used during registration. If details do not match, include other valid proof of identity to continue.') }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Form -->
                <form method="POST" action="{{ route('password.manual-request.store') }}" class="space-y-5">
                    @csrf

                    <!-- Email -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            {{ __('Email address') }} <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12H8m8 4H6m10-8H6m12 8a4 4 0 01-8 0 4 4 0 018 0z"></path>
                                </svg>
                            </div>
                            <input type="email" 
                                   name="email" 
                                   value="{{ old('email') }}" 
                                   required 
                                   class="block w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('email') border-red-300 bg-red-50 @enderror"
                                   placeholder="you@example.com">
                        </div>
                        @error('email')
                            <p class="mt-1 text-sm text-red-600 flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Name Fields -->
                    <div class="grid sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                {{ __('First name') }} <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   name="firstname" 
                                   value="{{ old('firstname') }}" 
                                   required 
                                   class="block w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('firstname') border-red-300 bg-red-50 @enderror"
                                   placeholder="John">
                            @error('firstname')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                {{ __('Last name') }} <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   name="lastname" 
                                   value="{{ old('lastname') }}" 
                                   required 
                                   class="block w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('lastname') border-red-300 bg-red-50 @enderror"
                                   placeholder="Doe">
                            @error('lastname')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Birthday -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            {{ __('Birthday') }} <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <input type="date" 
                                   name="birthday" 
                                   value="{{ old('birthday') }}" 
                                   required 
                                   class="block w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('birthday') border-red-300 bg-red-50 @enderror">
                        </div>
                        @error('birthday')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Alternative Proof -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            {{ __('Alternative proof of identity') }}
                            <span class="text-xs text-gray-500 ml-1">{{ __('(if details do not match)') }}</span>
                        </label>
                        <textarea name="proof_details" 
                                  rows="4" 
                                  class="block w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('proof_details') border-red-300 bg-red-50 @enderror"
                                  placeholder="Example: recent transaction details, registered contact number, security answers, or other verifiable information.">{{ old('proof_details') }}</textarea>
                        @error('proof_details')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500">
                            {{ __('Providing alternative proof helps us verify your identity faster.') }}
                        </p>
                    </div>

                    
                </form>

                <!-- Footer Link -->
                <div class="mt-8 pt-6 border-t border-gray-200">
                    <div class="text-center text-sm">
                        <span class="text-gray-600">{{ __('Return to') }}</span>
                        <flux:link :href="route('login')" 
                                   wire:navigate 
                                   class="ml-1 text-blue-600 hover:text-blue-800 font-medium hover:underline transition-colors">
                            {{ __('log in') }}
                        </flux:link>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.auth>