{{-- resources/views/inquiries/create.blade.php --}}
@extends('layouts.guest')

@section('content')
<section class="min-h-screen bg-gray-900 text-white py-6">
    <div class="mx-auto w-full max-w-5xl px-4 sm:px-6">

        {{-- Card --}}
        <div class="overflow-hidden rounded-2xl border border-gray-800 bg-black/40 shadow-2xl backdrop-blur-lg">

            {{-- Header --}}
            <div class="border-b border-gray-800 bg-gradient-to-r from-gray-900 to-gray-800 p-6">
                <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

                    {{-- Brand --}}
                    <div class="flex items-center gap-3">
                        <img src="{{ asset('images/logo.png') }}"
                             alt="Techne Fixer Logo"
                             class="h-12 w-12 object-contain sm:h-14 sm:w-14">

                        <div class="leading-tight">
                            <h1 class="text-lg font-bold tracking-tight sm:text-xl">
                                Techne Fixer
                            </h1>
                            <p class="text-xs text-gray-400">
                                Tech Repair Services
                            </p>
                        </div>
                    </div>

                    {{-- Home --}}
                    <a href="{{ url('/') }}"
                       class="inline-flex items-center justify-center rounded-lg border border-gray-700 bg-gray-900/40 px-3 py-2 text-xs text-gray-300 transition hover:border-emerald-500/50 hover:text-emerald-300">
                        ← {{ __('Home') }}
                    </a>
                </div>

                {{-- Benefits + Title --}}
                <div class="mt-5 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                    <div class="flex flex-wrap items-center gap-x-4 gap-y-2 text-xs text-gray-400">
                        <span class="inline-flex items-center gap-1.5">
                            <span class="text-emerald-400">✓</span> {{ __('Fast response') }}
                        </span>
                        <span class="inline-flex items-center gap-1.5">
                            <span class="text-emerald-400">✓</span> {{ __('Professional') }}
                        </span>
                        <span class="inline-flex items-center gap-1.5">
                            <span class="text-emerald-400">✓</span> {{ __('Trusted') }}
                        </span>
                    </div>

                    <div class="inline-flex items-center gap-2 rounded-full bg-emerald-500/10 px-4 py-2 text-xs font-semibold text-emerald-300">
                        {{ __('Service Request') }}
                    </div>
                </div>
            </div>

            {{-- Body --}}
            <div class="bg-gray-900/70 p-6">
                @if(session('success'))
                    <div class="mb-5 rounded-xl border border-emerald-500/40 bg-emerald-500/10 px-4 py-3 text-sm text-emerald-200">
                        {{ session('success') }}
                    </div>
                @endif

                {{-- Form --}}
                <form method="POST"
                      action="{{ route('customer.inquiry.store') }}"
                      enctype="multipart/form-data"
                      class="space-y-8">
                    @csrf

                    {{-- Section: Contact --}}
                    <div class="space-y-4">
                        <div class="flex items-center justify-between gap-3">
                            <h3 class="flex items-center gap-2 text-sm font-semibold uppercase tracking-wide text-emerald-300">
                                <span class="flex h-7 w-7 items-center justify-center rounded-full bg-emerald-500/20 text-xs font-bold text-emerald-300">1</span>
                                {{ __('Contact Information') }}
                            </h3>
                            <p class="text-xs text-gray-400">
                                <span class="text-red-400">*</span> {{ __('Required') }}
                            </p>
                        </div>

                        <div class="grid gap-4 sm:grid-cols-2">
                            {{-- Full Name --}}
                            <div>
                                <label class="mb-1.5 block text-sm font-medium text-gray-200">
                                    {{ __('Full Name') }} <span class="text-red-400">*</span>
                                </label>
                                <input type="text"
                                       name="name"
                                       value="{{ old('name', (Auth::check() ? Auth::user()->firstname . ' ' . Auth::user()->lastname : '')) }}"
                                       required
                                       class="w-full rounded-xl border border-gray-700 bg-gray-800 px-4 py-3 text-sm text-gray-100 placeholder-gray-500 outline-none transition
                                              focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/30">
                                @error('name')
                                    <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Contact Number --}}
                            <div>
                                <label class="mb-1.5 block text-sm font-medium text-gray-200">
                                    {{ __('Contact Number') }} <span class="text-red-400">*</span>
                                </label>
                                <input type="tel"
                                       name="contact_number"
                                       placeholder="09XXXXXXXXX"
                                       pattern="[0-9]{11}"
                                       value="{{ old('contact_number') }}"
                                       required
                                       class="w-full rounded-xl border border-gray-700 bg-gray-800 px-4 py-3 text-sm text-gray-100 placeholder-gray-500 outline-none transition
                                              focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/30">
                                <p class="mt-1 text-xs text-gray-500">Format: 11 digits (e.g., 09XXXXXXXXX)</p>
                                @error('contact_number')
                                    <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Email --}}
                            <div>
                                <label class="mb-1.5 block text-sm font-medium text-gray-200">
                                    {{ __('Email Address') }} <span class="text-red-400">*</span>
                                </label>
                                <input type="email"
                                       name="email"
                                       placeholder="you@example.com"
                                       value="{{ old('email', (Auth::check() ? Auth::user()->email : '')) }}"
                                       required
                                       class="w-full rounded-xl border border-gray-700 bg-gray-800 px-4 py-3 text-sm text-gray-100 placeholder-gray-500 outline-none transition
                                              focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/30">
                                @error('email')
                                    <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Location --}}
                            <div>
                                <label class="mb-1.5 block text-sm font-medium text-gray-200">
                                    {{ __('Service Location') }} <span class="text-red-400">*</span>
                                </label>
                                <input type="text"
                                       name="service_location"
                                       placeholder="Street, Barangay, City"
                                       value="{{ old('service_location') }}"
                                       required
                                       class="w-full rounded-xl border border-gray-700 bg-gray-800 px-4 py-3 text-sm text-gray-100 placeholder-gray-500 outline-none transition
                                              focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/30">
                                @error('service_location')
                                    <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="border-t border-gray-800"></div>

                    {{-- Section: Service Details --}}
                    <div class="space-y-4">
                        <h3 class="flex items-center gap-2 text-sm font-semibold uppercase tracking-wide text-emerald-300">
                            <span class="flex h-7 w-7 items-center justify-center rounded-full bg-emerald-500/20 text-xs font-bold text-emerald-300">2</span>
                            {{ __('Service Details') }}
                        </h3>

                        <div class="grid gap-4 sm:grid-cols-3">
                            {{-- Category --}}
                            <div>
                                <label class="mb-1.5 block text-sm font-medium text-gray-200">
                                    {{ __('Category') }} <span class="text-red-400">*</span>
                                </label>
                                <select name="category"
                                        required
                                        class="w-full rounded-xl border border-gray-700 bg-gray-800 px-4 py-3 text-sm text-gray-100 outline-none transition
                                               focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/30">
                                    <option value="">{{ __('Select') }}</option>
                                    <option value="Computer / Laptop Repair" @selected(old('category') == 'Computer / Laptop Repair')>Computer / Laptop</option>
                                    <option value="Networking" @selected(old('category') == 'Networking')>Networking</option>
                                    <option value="Printer Repair" @selected(old('category') == 'Printer Repair')>Printer</option>
                                    <option value="CCTV Installation / Repair" @selected(old('category') == 'CCTV Installation / Repair')>CCTV</option>
                                    <option value="Aircon Cleaning / Repair" @selected(old('category') == 'Aircon Cleaning / Repair')>Aircon</option>
                                    <option value="Other" @selected(old('category') == 'Other')>Other</option>
                                </select>
                                @error('category')
                                    <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Urgency --}}
                            <div>
                                <label class="mb-1.5 block text-sm font-medium text-gray-200">
                                    {{ __('Urgency') }} <span class="text-red-400">*</span>
                                </label>
                                <select name="urgency"
                                        required
                                        class="w-full rounded-xl border border-gray-700 bg-gray-800 px-4 py-3 text-sm text-gray-100 outline-none transition
                                               focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/30">
                                    <option value="Normal" @selected(old('urgency', 'Normal') == 'Normal')>{{ __('Normal (1–3 days)') }}</option>
                                    <option value="Urgent" @selected(old('urgency') == 'Urgent')>{{ __('Urgent (same/next day)') }}</option>
                                    <option value="Flexible" @selected(old('urgency') == 'Flexible')>{{ __('Flexible') }}</option>
                                </select>
                                @error('urgency')
                                    <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Device --}}
                            <div>
                                <label class="mb-1.5 block text-sm font-medium text-gray-200">
                                    {{ __('Device/Brand') }} <span class="text-xs font-normal text-gray-400">(optional)</span>
                                </label>
                                <input type="text"
                                       name="device_details"
                                       placeholder="e.g., HP Laptop 15s"
                                       value="{{ old('device_details') }}"
                                       class="w-full rounded-xl border border-gray-700 bg-gray-800 px-4 py-3 text-sm text-gray-100 placeholder-gray-500 outline-none transition
                                              focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/30">
                                @error('device_details')
                                    <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        {{-- Issue --}}
                        <div>
                            <label class="mb-1.5 block text-sm font-medium text-gray-200">
                                {{ __('Issue Description') }} <span class="text-red-400">*</span>
                            </label>
                            <textarea name="issue_description"
                                      rows="4"
                                      required
                                      placeholder="Describe the issue in detail…"
                                      class="w-full resize-none rounded-xl border border-gray-700 bg-gray-800 px-4 py-3 text-sm text-gray-100 placeholder-gray-500 outline-none transition
                                             focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/30">{{ old('issue_description') }}</textarea>
                            @error('issue_description')
                                <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="border-t border-gray-800"></div>

                    {{-- Section: Additional --}}
                    <div class="space-y-4">
                        <div class="flex items-center gap-2">
                            <span class="flex h-7 w-7 items-center justify-center rounded-full bg-gray-700/50 text-xs font-bold text-gray-300">3</span>
                            <h3 class="text-sm font-semibold uppercase tracking-wide text-gray-300">
                                {{ __('Additional') }}
                                <span class="text-xs font-normal lowercase text-gray-400">(optional)</span>
                            </h3>
                        </div>

                        <div class="grid gap-4 sm:grid-cols-3">
                            {{-- Preferred Schedule --}}
                            <div>
                                <label class="mb-1.5 block text-sm font-medium text-gray-200">
                                    {{ __('Preferred Date/Time') }}
                                </label>
                                <input type="datetime-local"
                                       name="preferred_schedule"
                                       value="{{ old('preferred_schedule') }}"
                                       class="w-full rounded-xl border border-gray-700 bg-gray-800 px-4 py-3 text-sm text-gray-100 outline-none transition
                                              focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/30">
                                @error('preferred_schedule')
                                    <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Referral --}}
                            <div>
                                <label class="mb-1.5 block text-sm font-medium text-gray-200">
                                    {{ __('How did you hear?') }}
                                </label>
                                <select name="referral_source"
                                        class="w-full rounded-xl border border-gray-700 bg-gray-800 px-4 py-3 text-sm text-gray-100 outline-none transition
                                               focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/30">
                                    <option value="">{{ __('Select') }}</option>
                                    <option value="Facebook" @selected(old('referral_source') == 'Facebook')>Facebook</option>
                                    <option value="Google Search" @selected(old('referral_source') == 'Google Search')>Google</option>
                                    <option value="Friend/Family Referral" @selected(old('referral_source') == 'Friend/Family Referral')>Referral</option>
                                    <option value="Walk-in" @selected(old('referral_source') == 'Walk-in')>Walk-in</option>
                                    <option value="Other" @selected(old('referral_source') == 'Other')>Other</option>
                                </select>
                                @error('referral_source')
                                    <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Photo --}}
                            <div>
                                <label class="mb-1.5 block text-sm font-medium text-gray-200">
                                    {{ __('Upload Photo') }}
                                </label>
                                <input type="file"
                                       name="photo"
                                       accept="image/*"
                                       class="w-full rounded-xl border border-gray-700 bg-gray-800 px-4 py-2.5 text-sm text-gray-100 outline-none transition
                                              focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/30
                                              file:mr-3 file:rounded-lg file:border-0 file:bg-emerald-600 file:px-3 file:py-2 file:text-xs file:font-semibold file:text-white
                                              hover:file:bg-emerald-500">
                                <p class="mt-1 text-xs text-gray-500">Optional. Add a photo to help us diagnose faster.</p>
                                @error('photo')
                                    <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Sticky Submit --}}
                    <div class="sticky bottom-0 -mx-6 border-t border-gray-800 bg-gray-900/95 px-6 py-4 backdrop-blur">
                        <button type="submit"
                                class="w-full rounded-xl bg-emerald-600 px-4 py-3 text-sm font-semibold text-white shadow-lg shadow-emerald-900/40 transition
                                       hover:bg-emerald-500 hover:shadow-emerald-900/60 active:bg-emerald-700">
                            {{ __('Submit Inquiry') }}
                        </button>
                        <p class="mt-2 text-center text-xs text-gray-400">
                            By submitting, we’ll review your request and contact you using the details above.
                        </p>
                    </div>

                </form>
            </div>
        </div>
    </div>
</section>
@endsection
