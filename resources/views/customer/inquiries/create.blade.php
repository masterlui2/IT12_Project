{{-- resources/views/inquiries/create.blade.php --}}
@extends('layouts.guest')

@section('content')
<section class="min-h-screen bg-gray-950 text-white">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 py-8">

        <div class="rounded-2xl border border-gray-800 bg-gray-900/40 shadow-2xl overflow-hidden">

            {{-- Header --}}
            <div class="sticky top-0 z-10 border-b border-gray-800 bg-gray-950/70 backdrop-blur">
                <div class="p-5 sm:p-6">
                    <div class="flex items-start justify-between gap-4">
                        <div class="flex items-center gap-3">
                            <img src="{{ asset('images/logo.png') }}"
                                 alt="Techne Fixer Logo"
                                 class="h-12 w-12 object-contain">
                            <div class="leading-tight">
                                <h1 class="text-lg sm:text-xl font-semibold tracking-tight">Techne Fixer</h1>
                                <p class="text-xs text-gray-400">Tech Repair Services</p>
                            </div>
                        </div>

                        <a href="{{ url('/') }}"
                           class="text-xs text-gray-300 hover:text-blue-300 transition whitespace-nowrap">
                            ← {{ __('Home') }}
                        </a>
                    </div>

                    <div class="mt-4 flex flex-wrap items-center justify-between gap-3">
                        <div class="flex flex-wrap items-center gap-2 text-xs text-gray-400">
                            <span class="inline-flex items-center gap-2 rounded-full border border-gray-800 bg-gray-900/40 px-3 py-1">
                                <span class="text-blue-400">✓</span> {{ __('Fast response') }}
                            </span>
                            <span class="inline-flex items-center gap-2 rounded-full border border-gray-800 bg-gray-900/40 px-3 py-1">
                                <span class="text-blue-400">✓</span> {{ __('Professional') }}
                            </span>
                            <span class="inline-flex items-center gap-2 rounded-full border border-gray-800 bg-gray-900/40 px-3 py-1">
                                <span class="text-blue-400">✓</span> {{ __('Trusted') }}
                            </span>
                        </div>

                        <div class="text-sm font-semibold text-blue-300">
                            {{ __('Service Request') }}
                        </div>
                    </div>
                </div>
            </div>

            {{-- Body --}}
            <div class="p-5 sm:p-6">

                @if(session('success'))
                    <div class="mb-5 rounded-xl border border-blue-500/40 bg-blue-500/10 px-4 py-3 text-sm text-blue-200">
                        {{ session('success') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('customer.inquiry.store') }}" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    {{-- Section 1 --}}
                    <div class="rounded-xl border border-gray-800 bg-gray-950/30 p-4 sm:p-5">
                        <div class="flex items-center justify-between gap-3">
                            <h3 class="text-sm font-semibold text-white flex items-center gap-2">
                                <span class="flex h-7 w-7 items-center justify-center rounded-full bg-blue-500/15 text-blue-300 text-xs font-semibold">1</span>
                                {{ __('Contact Information') }}
                            </h3>
                            <p class="text-xs text-gray-400">Fields marked <span class="text-red-400">*</span> are required</p>
                        </div>

                        <div class="mt-4 grid sm:grid-cols-2 gap-4">
                            {{-- Full Name --}}
                            <div>
                                <label class="block text-sm text-gray-200 mb-1">
                                    {{ __('Full Name') }} <span class="text-red-400">*</span>
                                </label>
                                <input type="text"
                                       name="name"
                                       value="{{ old('name', (Auth::check() ? Auth::user()->firstname . ' ' . Auth::user()->lastname : '')) }}"
                                       required
                                       class="w-full rounded-lg bg-gray-900 border border-gray-800 px-4 py-3 text-sm text-gray-100 placeholder-gray-500
                                              focus:outline-none focus:ring-2 focus:ring-blue-500/70 focus:border-blue-500/70 transition">
                                @error('name')
                                    <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Contact Number --}}
                            <div>
                                <label class="block text-sm text-gray-200 mb-1">
                                    {{ __('Contact Number') }} <span class="text-red-400">*</span>
                                </label>
                                <input type="tel"
                                       name="contact_number"
                                       placeholder="09XX XXX XXXX"
                                       pattern="[0-9]{11}"
                                       inputmode="numeric"
                                       value="{{ old('contact_number') }}"
                                       required
                                       class="w-full rounded-lg bg-gray-900 border border-gray-800 px-4 py-3 text-sm text-gray-100 placeholder-gray-500
                                              focus:outline-none focus:ring-2 focus:ring-blue-500/70 focus:border-blue-500/70 transition">
                                <p class="mt-1 text-xs text-gray-500">11 digits (e.g., 09XXXXXXXXX)</p>
                                @error('contact_number')
                                    <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Email --}}
                            <div>
                                <label class="block text-sm text-gray-200 mb-1">
                                    {{ __('Email Address') }} <span class="text-red-400">*</span>
                                </label>
                                <input type="email"
                                       name="email"
                                       placeholder="you@example.com"
                                       value="{{ old('email', (Auth::check() ? Auth::user()->email : '')) }}"
                                       required
                                       class="w-full rounded-lg bg-gray-900 border border-gray-800 px-4 py-3 text-sm text-gray-100 placeholder-gray-500
                                              focus:outline-none focus:ring-2 focus:ring-blue-500/70 focus:border-blue-500/70 transition">
                                @error('email')
                                    <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Location --}}
                            <div>
                                <label class="block text-sm text-gray-200 mb-1">
                                    {{ __('Service Location') }} <span class="text-red-400">*</span>
                                </label>
                                <input type="text"
                                       name="service_location"
                                       placeholder="Street, Barangay, City"
                                       value="{{ old('service_location') }}"
                                       required
                                       class="w-full rounded-lg bg-gray-900 border border-gray-800 px-4 py-3 text-sm text-gray-100 placeholder-gray-500
                                              focus:outline-none focus:ring-2 focus:ring-blue-500/70 focus:border-blue-500/70 transition">
                                @error('service_location')
                                    <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Section 2 --}}
                    <div class="rounded-xl border border-gray-800 bg-gray-950/30 p-4 sm:p-5">
                        <h3 class="text-sm font-semibold text-white flex items-center gap-2">
                            <span class="flex h-7 w-7 items-center justify-center rounded-full bg-blue-500/15 text-blue-300 text-xs font-semibold">2</span>
                            {{ __('Service Details') }}
                        </h3>

                        <div class="mt-4 grid sm:grid-cols-3 gap-4">
                            {{-- Category --}}
                            <div>
                                <label class="block text-sm text-gray-200 mb-1">
                                    {{ __('Category') }} <span class="text-red-400">*</span>
                                </label>
                                <select name="category"
                                        required
                                        class="w-full rounded-lg bg-gray-900 border border-gray-800 px-4 py-3 text-sm text-gray-100
                                               focus:outline-none focus:ring-2 focus:ring-blue-500/70 focus:border-blue-500/70 transition">
                                    <option value="">{{ __('Select') }}</option>
                                    <option value="Computer / Laptop Repair" {{ old('category') == 'Computer / Laptop Repair' ? 'selected' : '' }}>Computer / Laptop</option>
                                    <option value="Networking" {{ old('category') == 'Networking' ? 'selected' : '' }}>Networking</option>
                                    <option value="Printer Repair" {{ old('category') == 'Printer Repair' ? 'selected' : '' }}>Printer</option>
                                    <option value="CCTV Installation / Repair" {{ old('category') == 'CCTV Installation / Repair' ? 'selected' : '' }}>CCTV</option>
                                    <option value="Aircon Cleaning / Repair" {{ old('category') == 'Aircon Cleaning / Repair' ? 'selected' : '' }}>Aircon</option>
                                    <option value="Other" {{ old('category') == 'Other' ? 'selected' : '' }}>Other</option>
                                </select>
                                @error('category')
                                    <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Urgency --}}
                            <div>
                                <label class="block text-sm text-gray-200 mb-1">
                                    {{ __('Urgency') }} <span class="text-red-400">*</span>
                                </label>
                                <select name="urgency"
                                        required
                                        class="w-full rounded-lg bg-gray-900 border border-gray-800 px-4 py-3 text-sm text-gray-100
                                               focus:outline-none focus:ring-2 focus:ring-blue-500/70 focus:border-blue-500/70 transition">
                                    <option value="Normal" {{ old('urgency', 'Normal') == 'Normal' ? 'selected' : '' }}>{{ __('Normal (1–3 days)') }}</option>
                                    <option value="Urgent" {{ old('urgency') == 'Urgent' ? 'selected' : '' }}>{{ __('Urgent (same/next day)') }}</option>
                                    <option value="Flexible" {{ old('urgency') == 'Flexible' ? 'selected' : '' }}>{{ __('Flexible') }}</option>
                                </select>
                                @error('urgency')
                                    <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Device --}}
                            <div>
                                <label class="block text-sm text-gray-200 mb-1">
                                    {{ __('Device/Brand') }}
                                    <span class="text-gray-500 text-xs font-normal">(optional)</span>
                                </label>
                                <input type="text"
                                       name="device_details"
                                       placeholder="e.g., HP Laptop 15s"
                                       value="{{ old('device_details') }}"
                                       class="w-full rounded-lg bg-gray-900 border border-gray-800 px-4 py-3 text-sm text-gray-100 placeholder-gray-500
                                              focus:outline-none focus:ring-2 focus:ring-blue-500/70 focus:border-blue-500/70 transition">
                                @error('device_details')
                                    <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        {{-- Issue --}}
                        <div class="mt-4">
                            <label class="block text-sm text-gray-200 mb-1">
                                {{ __('Issue Description') }} <span class="text-red-400">*</span>
                            </label>
                            <textarea name="issue_description"
                                      rows="4"
                                      required
                                      placeholder="Tell us what’s happening (symptoms, error messages, when it started, etc.)"
                                      class="w-full rounded-lg bg-gray-900 border border-gray-800 px-4 py-3 text-sm text-gray-100 placeholder-gray-500
                                             focus:outline-none focus:ring-2 focus:ring-blue-500/70 focus:border-blue-500/70 transition resize-none">{{ old('issue_description') }}</textarea>
                            @error('issue_description')
                                <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- Section 3 --}}
                    <div class="rounded-xl border border-gray-800 bg-gray-950/30 p-4 sm:p-5">
                        <h3 class="text-sm font-semibold text-white flex items-center gap-2">
                            <span class="flex h-7 w-7 items-center justify-center rounded-full bg-gray-700/50 text-gray-200 text-xs font-semibold">3</span>
                            {{ __('Additional') }}
                            <span class="text-xs text-gray-400 font-normal">(optional)</span>
                        </h3>

                        <div class="mt-4 grid sm:grid-cols-3 gap-4">
                            {{-- Schedule --}}
                            <div>
                                <label class="block text-sm text-gray-200 mb-1">{{ __('Preferred Date/Time') }}</label>
                                <input type="datetime-local"
                                       name="preferred_schedule"
                                       value="{{ old('preferred_schedule') }}"
                                       class="w-full rounded-lg bg-gray-900 border border-gray-800 px-4 py-3 text-sm text-gray-100
                                              focus:outline-none focus:ring-2 focus:ring-blue-500/70 focus:border-blue-500/70 transition">
                                @error('preferred_schedule')
                                    <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Referral --}}
                            <div>
                                <label class="block text-sm text-gray-200 mb-1">{{ __('How did you hear?') }}</label>
                                <select name="referral_source"
                                        class="w-full rounded-lg bg-gray-900 border border-gray-800 px-4 py-3 text-sm text-gray-100
                                               focus:outline-none focus:ring-2 focus:ring-blue-500/70 focus:border-blue-500/70 transition">
                                    <option value="">{{ __('Select') }}</option>
                                    <option value="Facebook" {{ old('referral_source') == 'Facebook' ? 'selected' : '' }}>Facebook</option>
                                    <option value="Google Search" {{ old('referral_source') == 'Google Search' ? 'selected' : '' }}>Google</option>
                                    <option value="Friend/Family Referral" {{ old('referral_source') == 'Friend/Family Referral' ? 'selected' : '' }}>Referral</option>
                                    <option value="Walk-in" {{ old('referral_source') == 'Walk-in' ? 'selected' : '' }}>Walk-in</option>
                                    <option value="Other" {{ old('referral_source') == 'Other' ? 'selected' : '' }}>Other</option>
                                </select>
                                @error('referral_source')
                                    <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Photo --}}
                            <div>
                                <label class="block text-sm text-gray-200 mb-1">{{ __('Upload Photo') }}</label>
                                <input type="file"
                                       name="photo"
                                       accept="image/*"
                                       class="w-full rounded-lg bg-gray-900 border border-gray-800 px-4 py-3 text-sm text-gray-100
                                              focus:outline-none focus:ring-2 focus:ring-blue-500/70 focus:border-blue-500/70 transition
                                              file:mr-3 file:py-1.5 file:px-3 file:rounded-md file:border-0 file:text-xs file:bg-blue-600 file:text-white hover:file:bg-blue-500">
                                <p class="mt-1 text-xs text-gray-500">Optional: add a clear photo to speed up troubleshooting.</p>
                                @error('photo')
                                    <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Sticky submit --}}
                    <div class="sticky bottom-0 -mx-5 sm:-mx-6 px-5 sm:px-6 py-4 border-t border-gray-800 bg-gray-950/80 backdrop-blur">
                        <button type="submit"
                                class="w-full rounded-xl bg-blue-600 hover:bg-blue-500 active:bg-blue-700 transition
                                       px-4 py-3 text-sm font-semibold text-white shadow-lg shadow-blue-900/40">
                            {{ __('Submit Inquiry') }}
                        </button>
                        <p class="mt-2 text-center text-xs text-gray-400">
                            We’ll review your request and contact you as soon as possible.
                        </p>
                    </div>

                </form>
            </div>
        </div>
    </div>
</section>
@endsection
