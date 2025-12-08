{{-- resources/views/inquiries/create.blade.php --}}
@extends('layouts.guest')

@section('content')
<section class="min-h-screen bg-gray-900 text-white py-4">
    <div class="max-w-6xl mx-auto px-6 w-full">
        <!-- Card -->
        <div class="bg-black/40 backdrop-blur-lg border border-gray-800 rounded-2xl shadow-2xl overflow-hidden">
            
            {{-- Top: Header --}}
            <div class="relative p-6 border-b border-gray-800 bg-gradient-to-r from-gray-900 to-gray-800">
                {{-- Top row: Logo + Brand Name, Home Button --}}
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center gap-3">
                        <img src="{{ asset('images/logo.png') }}" 
                             alt="Logo"
                             class="h-14 w-14 object-contain">
                        <div>
                            <h1 class="text-xl font-bold tracking-tight">
                                Techne Fixer
                            </h1>
                            <p class="text-xs text-gray-400">
                                Tech Repair Services
                            </p>
                        </div>
                    </div>
                    <a href="{{ url('/') }}" class="text-xs text-gray-400 hover:text-emerald-300 transition-colors whitespace-nowrap">
                        ← {{ __('Home') }}
                    </a>
                </div>

                {{-- Bottom row: Benefits, Form Title --}}
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-4 text-xs text-gray-500">
                        <span class="flex items-center gap-1.5">
                            <span class="text-emerald-400">✓</span>
                            {{ __('Fast response') }}
                        </span>
                        <span class="flex items-center gap-1.5">
                            <span class="text-emerald-400">✓</span>
                            {{ __('Professional') }}
                        </span>
                        <span class="flex items-center gap-1.5">
                            <span class="text-emerald-400">✓</span>
                            {{ __('Trusted') }}
                        </span>
                    </div>
                    <h2 class="text-sm font-bold text-emerald-400 whitespace-nowrap">
                        {{ __('Service Request') }}
                    </h2>
                </div>
            </div>

            {{-- Bottom: Form --}}
            <div class="p-6 bg-gray-900/70 max-h-[70vh] overflow-y-auto">
                    @if(session('success'))
                        <div class="mb-4 rounded-lg border border-emerald-500 bg-emerald-500/10 px-3 py-2 text-xs text-emerald-300">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('customer.inquiry.store') }}" enctype="multipart/form-data" class="space-y-5">
                        @csrf

                        {{-- Section 1: Contact Information --}}
                        <div class="space-y-3">
                            <h3 class="text-sm font-semibold text-emerald-400 uppercase tracking-wide flex items-center gap-2">
                                <span class="flex h-6 w-6 items-center justify-center rounded-full bg-emerald-500/20 text-emerald-400 text-xs">1</span>
                                {{ __('Contact Information') }}
                            </h3>
                            
                            <div class="grid sm:grid-cols-2 gap-3">
                                {{-- Full Name --}}
                                <div>
                                    <label class="block text-sm font-medium text-gray-300 mb-1.5">
                                        {{ __('Full Name') }} <span class="text-red-400">*</span>
                                    </label>
                                    <input type="text" 
                                           name="name"
                                           class="w-full bg-gray-800 border border-gray-700 rounded-lg px-4 py-3 text-sm text-gray-100 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors"
                                           value="{{ old('name', (Auth::check() ? Auth::user()->firstname . ' ' . Auth::user()->lastname : '')) }}"
                                           required>
                                    @error('name')
                                        <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- Contact Number --}}
                                <div>
                                    <label class="block text-sm font-medium text-gray-300 mb-1.5">
                                        {{ __('Contact Number') }} <span class="text-red-400">*</span>
                                    </label>
                                    <input type="tel" 
                                           name="contact_number"
                                           placeholder="09XX XXX XXXX"
                                           pattern="[0-9]{11}"
                                           class="w-full bg-gray-800 border border-gray-700 rounded-lg px-4 py-3 text-sm text-gray-100 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors"
                                           value="{{ old('contact_number') }}"
                                           required>
                                    @error('contact_number')
                                        <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- Email Address --}}
                                <div>
                                    <label class="block text-sm font-medium text-gray-300 mb-1.5">
                                        {{ __('Email Address') }} <span class="text-red-400">*</span>
                                    </label>
                                    <input type="email" 
                                           name="email"
                                           placeholder="you@example.com"
                                           class="w-full bg-gray-800 border border-gray-700 rounded-lg px-4 py-3 text-sm text-gray-100 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors"
                                           value="{{ old('email', (Auth::check() ? Auth::user()->email : '')) }}"
                                           required>
                                    @error('email')
                                        <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- Service Location --}}
                                <div>
                                    <label class="block text-sm font-medium text-gray-300 mb-1.5">
                                        {{ __('Service Location') }} <span class="text-red-400">*</span>
                                    </label>
                                    <input type="text"
                                           name="service_location"
                                           class="w-full bg-gray-800 border border-gray-700 rounded-lg px-4 py-3 text-sm text-gray-100 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors"
                                           placeholder="Street, Barangay, City"
                                           value="{{ old('service_location') }}"
                                           required>
                                    @error('service_location')
                                        <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- Divider --}}
                        <div class="border-t border-gray-800"></div>

                        {{-- Section 2: Service Details --}}
                        <div class="space-y-3">
                            <h3 class="text-sm font-semibold text-emerald-400 uppercase tracking-wide flex items-center gap-2">
                                <span class="flex h-6 w-6 items-center justify-center rounded-full bg-emerald-500/20 text-emerald-400 text-xs">2</span>
                                {{ __('Service Details') }}
                            </h3>

                            <div class="grid sm:grid-cols-3 gap-3">
                                {{-- Category of Service --}}
                                <div>
                                    <label class="block text-sm font-medium text-gray-300 mb-1.5">
                                        {{ __('Category') }} <span class="text-red-400">*</span>
                                    </label>
                                    <select name="category"
                                            class="w-full bg-gray-800 border border-gray-700 rounded-lg px-4 py-3 text-sm text-gray-100 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors"
                                            required>
                                        <option value="">{{ __('Select') }}</option>
                                        <option value="Computer / Laptop Repair" {{ old('category') == 'Computer / Laptop Repair' ? 'selected' : '' }}>Computer / Laptop</option>
                                        <option value="Networking" {{ old('category') == 'Networking' ? 'selected' : '' }}>Networking</option>
                                        <option value="Printer Repair" {{ old('category') == 'Printer Repair' ? 'selected' : '' }}>Printer</option>
                                        <option value="CCTV Installation / Repair" {{ old('category') == 'CCTV Installation / Repair' ? 'selected' : '' }}>CCTV</option>
                                        <option value="Aircon Cleaning / Repair" {{ old('category') == 'Aircon Cleaning / Repair' ? 'selected' : '' }}>Aircon</option>
                                        <option value="Other" {{ old('category') == 'Other' ? 'selected' : '' }}>Other</option>
                                    </select>
                                    @error('category')
                                        <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- Urgency Level --}}
                                <div>
                                    <label class="block text-sm font-medium text-gray-300 mb-1.5">
                                        {{ __('Urgency') }} <span class="text-red-400">*</span>
                                    </label>
                                    <select name="urgency"
                                            class="w-full bg-gray-800 border border-gray-700 rounded-lg px-4 py-3 text-sm text-gray-100 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors"
                                            required>
                                        <option value="Normal" {{ old('urgency', 'Normal') == 'Normal' ? 'selected' : '' }}>{{ __('Normal (1-3d)') }}</option>
                                        <option value="Urgent" {{ old('urgency') == 'Urgent' ? 'selected' : '' }}>{{ __('Urgent (same/next)') }}</option>
                                        <option value="Flexible" {{ old('urgency') == 'Flexible' ? 'selected' : '' }}>{{ __('Flexible') }}</option>
                                    </select>
                                    @error('urgency')
                                        <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- Device Details --}}
                                <div>
                                    <label class="block text-sm font-medium text-gray-300 mb-1.5">
                                        {{ __('Device/Brand') }} <span class="text-gray-500 font-normal text-xs">(opt)</span>
                                    </label>
                                    <input type="text" 
                                           name="device_details"
                                           placeholder="e.g., HP Laptop 15s"
                                           class="w-full bg-gray-800 border border-gray-700 rounded-lg px-4 py-3 text-sm text-gray-100 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors"
                                           value="{{ old('device_details') }}">
                                    @error('device_details')
                                        <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            {{-- Issue Description --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-300 mb-1.5">
                                    {{ __('Issue Description') }} <span class="text-red-400">*</span>
                                </label>
                                <textarea name="issue_description"
                                          rows="3"
                                          class="w-full bg-gray-800 border border-gray-700 rounded-lg px-4 py-3 text-sm text-gray-100 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors resize-none"
                                          placeholder="Describe the issue in detail…"
                                          required>{{ old('issue_description') }}</textarea>
                                @error('issue_description')
                                    <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        {{-- Divider --}}
                        <div class="border-t border-gray-800"></div>

                        {{-- Section 3: Additional (Optional) --}}
                        <div class="space-y-3">
                            <h3 class="text-sm font-semibold text-gray-400 uppercase tracking-wide flex items-center gap-2">
                                <span class="flex h-6 w-6 items-center justify-center rounded-full bg-gray-700/50 text-gray-400 text-xs">3</span>
                                {{ __('Additional') }}
                                <span class="text-xs font-normal lowercase">(optional)</span>
                            </h3>

                            <div class="grid sm:grid-cols-3 gap-3">
                                {{-- Preferred Schedule --}}
                                <div>
                                    <label class="block text-sm font-medium text-gray-300 mb-1.5">
                                        {{ __('Preferred Date/Time') }}
                                    </label>
                                    <input type="datetime-local"
                                           name="preferred_schedule"
                                           class="w-full bg-gray-800 border border-gray-700 rounded-lg px-4 py-3 text-sm text-gray-100 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors"
                                           value="{{ old('preferred_schedule') }}">
                                    @error('preferred_schedule')
                                        <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- Referral Source --}}
                                <div>
                                    <label class="block text-sm font-medium text-gray-300 mb-1.5">
                                        {{ __('How did you hear?') }}
                                    </label>
                                    <select name="referral_source"
                                            class="w-full bg-gray-800 border border-gray-700 rounded-lg px-4 py-3 text-sm text-gray-100 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors">
                                        <option value="">{{ __('Select') }}</option>
                                        <option value="Facebook" {{ old('referral_source') == 'Facebook' ? 'selected' : '' }}>Facebook</option>
                                        <option value="Google Search" {{ old('referral_source') == 'Google Search' ? 'selected' : '' }}>Google</option>
                                        <option value="Friend/Family Referral" {{ old('referral_source') == 'Friend/Family Referral' ? 'selected' : '' }}>Referral</option>
                                        <option value="Walk-in" {{ old('referral_source') == 'Walk-in' ? 'selected' : '' }}>Walk-in</option>
                                        <option value="Other" {{ old('referral_source') == 'Other' ? 'selected' : '' }}>Other</option>
                                    </select>
                                    @error('referral_source')
                                        <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- Photo Upload --}}
                                <div>
                                    <label class="block text-sm font-medium text-gray-300 mb-1.5">
                                        {{ __('Upload Photo') }}
                                    </label>
                                    <input type="file" 
                                           name="photo"
                                           accept="image/*"
                                           class="w-full bg-gray-800 border border-gray-700 rounded-lg px-4 py-3 text-sm text-gray-100 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors file:mr-3 file:py-1 file:px-3 file:rounded file:border-0 file:text-xs file:bg-emerald-600 file:text-white hover:file:bg-emerald-500 file:transition-colors">
                                    @error('photo')
                                        <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- Submit Button --}}
                        <div class="pt-2">
                            <button type="submit"
                                    class="w-full bg-emerald-600 hover:bg-emerald-500 active:bg-emerald-700 transition-colors px-4 py-2.5 rounded-lg text-sm font-semibold text-white shadow-lg shadow-emerald-900/50 hover:shadow-emerald-900/70">
                                {{ __('Submit Inquiry') }} ✓
                            </button>
                        </div>
                    </form>
                </div>

        </div>
    </div>
</section>
@endsection