{{-- resources/views/inquiries/create.blade.php --}}
@extends('layouts.guest')

@section('content')
<section class="min-h-screen bg-gray-900 text-white py-16">
    <div class="max-w-5xl mx-auto px-6">
        <!-- Landscape card -->
        <div class="bg-black/40 backdrop-blur-lg border border-gray-800 rounded-2xl shadow-2xl overflow-hidden">
            <div class="grid md:grid-cols-2">
                
                {{-- Left side: logo + intro --}}
                <div class="relative p-8 md:p-10 flex flex-col justify-between border-b md:border-b-0 md:border-r border-gray-800">
                    <div>
                        <div class="flex items-center gap-3 mb-6">
                            <img src="{{ asset('images/logo.png') }}" 
                                 alt="Logo"
                                 class="h-14 w-14 object-contain">
                            <div>
                                <h1 class="text-xl font-bold tracking-tight">
                                    Techne Fixer
                                </h1>
                                <p class="text-xs text-gray-400">
                                    Computer • Gadgets • Aircon • CCTV • More
                                </p>
                            </div>
                        </div>

                        <h2 class="text-2xl font-bold mb-3">
                            {{ __('Need help? Submit an Inquiry') }}
                        </h2>
                     
                    </div>

                    <div class="mt-8 text-xs text-gray-500">
                        <p>✔ {{ __('Fast response from our team') }}</p>
                        <p>✔ {{ __('Trusted and professional service') }}</p>
                        <p>✔ {{ __('For home and business customers') }}</p>
                    </div>
                </div>

                {{-- Right side: form --}}
                <div class="p-8 md:p-10 bg-gray-900/70">
                    @if(    session('success'))
                        <div class="mb-4 rounded-lg border border-emerald-500 bg-emerald-500/10 px-4 py-2 text-sm text-emerald-300">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('inquiry.store') }}" enctype="multipart/form-data" id="inquiryForm">
                        @csrf

                        {{-- Progress Indicator --}}
                        <div class="mb-6">
                            <div class="flex items-center justify-between mb-2">
                                <button type="button" onclick="goToStep(1)" class="text-xs font-medium step-label cursor-pointer hover:text-emerald-300 transition-colors" data-step="1">
                                    Contact Info
                                </button>
                                <button type="button" onclick="goToStep(2)" class="text-xs font-medium step-label cursor-pointer hover:text-emerald-300 transition-colors" data-step="2">
                                    Service Details
                                </button>
                                <button type="button" onclick="goToStep(3)" class="text-xs font-medium step-label cursor-pointer hover:text-emerald-300 transition-colors" data-step="3">
                                    Additional Info
                                </button>
                            </div>
                            <div class="w-full bg-gray-700 rounded-full h-1.5">
                                <div class="bg-emerald-500 h-1.5 rounded-full transition-all duration-300" id="progressBar" style="width: 33%"></div>
                            </div>
                        </div>

                        {{-- Step 1: Contact Information --}}
                        <div class="form-step space-y-4" id="step1">
                            {{-- Full Name --}}
                            <div>
                                <label class="block text-xs font-medium text-gray-300 mb-1">
                                    {{ __('Full Name') }} <span class="text-red-400">*</span>
                                </label>
                                <input type="text" 
                                       name="name"
                                       class="w-full bg-gray-800 border border-gray-700 rounded-lg px-3 py-2 text-sm text-gray-100 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                                       value="{{ old('name', (Auth::check() ? Auth::user()->firstname . ' ' . Auth::user()->lastname : '')) }}"
                                       required>
                                @error('name')
                                    <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Contact Number --}}
                            <div>
                                <label class="block text-xs font-medium text-gray-300 mb-1">
                                    {{ __('Contact Number') }} <span class="text-red-400">*</span>
                                </label>
                                <input type="tel" 
                                       name="contact_number"
                                       placeholder="09XX XXX XXXX"
                                       pattern="[0-9]{11}"
                                       class="w-full bg-gray-800 border border-gray-700 rounded-lg px-3 py-2 text-sm text-gray-100 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                                       value="{{ old('contact_number') }}"
                                       required>
                                @error('contact_number')
                                    <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Email Address --}}
                            <div>
                                <label class="block text-xs font-medium text-gray-300 mb-1">
                                    {{ __('Email Address') }} <span class="text-red-400">*</span>
                                </label>
                                <input type="email" 
                                       name="email"
                                       placeholder="you@example.com"
                                       class="w-full bg-gray-800 border border-gray-700 rounded-lg px-3 py-2 text-sm text-gray-100 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                                       value="{{ old('email', (Auth::check() ? Auth::user()->email : '')) }}"
                                       required>
                                @error('email')
                                    <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Service Location --}}
                            <div>
                                <label class="block text-xs font-medium text-gray-300 mb-1">
                                    {{ __('Service Location / Address') }} <span class="text-red-400">*</span>
                                </label>
                                <textarea name="service_location"
                                          rows="2"
                                          class="w-full bg-gray-800 border border-gray-700 rounded-lg px-3 py-2 text-sm text-gray-100 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                                          placeholder="Street, Barangay, City"
                                          required>{{ old('service_location') }}</textarea>
                                @error('service_location')
                                    <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <button type="button"
                                    onclick="nextStep()"
                                    class="w-full mt-2 bg-emerald-600 hover:bg-emerald-500 transition-colors px-4 py-2.5 rounded-lg text-sm font-semibold text-white text-center">
                                {{ __('Next') }} →
                            </button>
                        </div>

                        {{-- Step 2: Service Details --}}
                        <div class="form-step space-y-4 hidden" id="step2">
                            {{-- Category of Service --}}
                            <div>
                                <label class="block text-xs font-medium text-gray-300 mb-1">
                                    {{ __('Category of Service') }} <span class="text-red-400">*</span>
                                </label>
                                <select name="category"
                                        id="category"
                                        class="w-full bg-gray-800 border border-gray-700 rounded-lg px-3 py-2 text-sm text-gray-100 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                                        required>
                                    <option value="">{{ __('Select Category') }}</option>
                                    <option value="Computer / Laptop Repair" {{ old('category') == 'Computer / Laptop Repair' ? 'selected' : '' }}>Computer / Laptop Repair</option>
                                    <option value="Networking" {{ old('category') == 'Networking' ? 'selected' : '' }}>Networking</option>
                                    <option value="Printer Repair" {{ old('category') == 'Printer Repair' ? 'selected' : '' }}>Printer Repair</option>
                                    <option value="CCTV Installation / Repair" {{ old('category') == 'CCTV Installation / Repair' ? 'selected' : '' }}>CCTV Installation / Repair</option>
                                    <option value="Aircon Cleaning / Repair" {{ old('category') == 'Aircon Cleaning / Repair' ? 'selected' : '' }}>Aircon Cleaning / Repair</option>
                                    <option value="Other" {{ old('category') == 'Other' ? 'selected' : '' }}>Other</option>
                                </select>
                                @error('category')
                                    <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Device/Equipment Details --}}
                            <div>
                                <label class="block text-xs font-medium text-gray-300 mb-1">
                                    {{ __('Device Brand & Model') }} <span class="text-gray-500">({{ __('if known') }})</span>
                                </label>
                                <input type="text" 
                                       name="device_details"
                                       placeholder="e.g., HP Laptop 15s, Samsung Split-Type 1.5HP"
                                       class="w-full bg-gray-800 border border-gray-700 rounded-lg px-3 py-2 text-sm text-gray-100 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                                       value="{{ old('device_details') }}">
                                @error('device_details')
                                    <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Issue Description --}}
                            <div>
                                <label class="block text-xs font-medium text-gray-300 mb-1">
                                    {{ __('Issue Description') }} <span class="text-red-400">*</span>
                                </label>
                                <textarea name="issue_description"
                                          rows="4"
                                          class="w-full bg-gray-800 border border-gray-700 rounded-lg px-3 py-2 text-sm text-gray-100 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                                          placeholder="Describe the issue in detail…"
                                          required>{{ old('issue_description') }}</textarea>
                                @error('issue_description')
                                    <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Urgency Level --}}
                            <div>
                                <label class="block text-xs font-medium text-gray-300 mb-1">
                                    {{ __('Urgency Level') }} <span class="text-red-400">*</span>
                                </label>
                                <select name="urgency"
                                        class="w-full bg-gray-800 border border-gray-700 rounded-lg px-3 py-2 text-sm text-gray-100 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                                        required>
                                    <option value="Normal" {{ old('urgency', 'Normal') == 'Normal' ? 'selected' : '' }}>{{ __('Normal (1-3 days)') }}</option>
                                    <option value="Urgent" {{ old('urgency') == 'Urgent' ? 'selected' : '' }}>{{ __('Urgent (same/next day)') }}</option>
                                    <option value="Flexible" {{ old('urgency') == 'Flexible' ? 'selected' : '' }}>{{ __('Flexible (anytime)') }}</option>
                                </select>
                                @error('urgency')
                                    <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="flex gap-3 mt-2">
                                <button type="button"
                                        onclick="prevStep()"
                                        class="flex-1 bg-gray-700 hover:bg-gray-600 transition-colors px-4 py-2.5 rounded-lg text-sm font-semibold text-white text-center">
                                    ← {{ __('Back') }}
                                </button>
                                <button type="button"
                                        onclick="nextStep()"
                                        class="flex-1 bg-emerald-600 hover:bg-emerald-500 transition-colors px-4 py-2.5 rounded-lg text-sm font-semibold text-white text-center">
                                    {{ __('Next') }} →
                                </button>
                            </div>
                        </div>

                        {{-- Step 3: Additional Information --}}
                        <div class="form-step space-y-4 hidden" id="step3">
                            {{-- Preferred Schedule --}}
                            <div>
                                <label class="block text-xs font-medium text-gray-300 mb-1">
                                    {{ __('Preferred Date & Time') }} <span class="text-gray-500">({{ __('optional') }})</span>
                                </label>
                                <input type="datetime-local"
                                       name="preferred_schedule"
                                       class="w-full bg-gray-800 border border-gray-700 rounded-lg px-3 py-2 text-sm text-gray-100 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                                       value="{{ old('preferred_schedule') }}">
                                @error('preferred_schedule')
                                    <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Photo Upload --}}
                            <div>
                                <label class="block text-xs font-medium text-gray-300 mb-1">
                                    {{ __('Upload Photo') }} <span class="text-gray-500">({{ __('optional') }})</span>
                                </label>
                                <input type="file" 
                                       name="photo"
                                       accept="image/*"
                                       class="w-full bg-gray-800 border border-gray-700 rounded-lg px-3 py-2 text-sm text-gray-100 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 file:mr-4 file:py-1 file:px-3 file:rounded file:border-0 file:text-xs file:bg-emerald-600 file:text-white hover:file:bg-emerald-500">
                                <p class="text-xs text-gray-500 mt-1">{{ __('Upload a photo of the issue or equipment (Max: 5MB)') }}</p>
                                @error('photo')
                                    <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- How Did You Hear About Us --}}
                            <div>
                                <label class="block text-xs font-medium text-gray-300 mb-1">
                                    {{ __('How did you hear about us?') }} <span class="text-gray-500">({{ __('optional') }})</span>
                                </label>
                                <select name="referral_source"
                                        class="w-full bg-gray-800 border border-gray-700 rounded-lg px-3 py-2 text-sm text-gray-100 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                                    <option value="">{{ __('Select one') }}</option>
                                    <option value="Facebook" {{ old('referral_source') == 'Facebook' ? 'selected' : '' }}>Facebook</option>
                                    <option value="Google Search" {{ old('referral_source') == 'Google Search' ? 'selected' : '' }}>Google Search</option>
                                    <option value="Friend/Family Referral" {{ old('referral_source') == 'Friend/Family Referral' ? 'selected' : '' }}>Friend/Family Referral</option>
                                    <option value="Walk-in" {{ old('referral_source') == 'Walk-in' ? 'selected' : '' }}>Walk-in</option>
                                    <option value="Other" {{ old('referral_source') == 'Other' ? 'selected' : '' }}>Other</option>
                                </select>
                                @error('referral_source')
                                    <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="flex gap-3 mt-2">
                                <button type="button"
                                        onclick="prevStep()"
                                        class="flex-1 bg-gray-700 hover:bg-gray-600 transition-colors px-4 py-2.5 rounded-lg text-sm font-semibold text-white text-center">
                                    ← {{ __('Back') }}
                                </button>
                                <button type="submit"
                                        class="flex-1 bg-emerald-600 hover:bg-emerald-500 transition-colors px-4 py-2.5 rounded-lg text-sm font-semibold text-white text-center">
                                    {{ __('Submit Inquiry') }} ✓
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</section>

<script>
    let currentStep = 1;
    const totalSteps = 3;

    function showStep(step) {
        // Validate we don't go beyond bounds
        if (step < 1 || step > totalSteps) return;

        // Hide all steps
        document.querySelectorAll('.form-step').forEach(el => {
            el.classList.add('hidden');
        });

        // Show current step
        document.getElementById('step' + step).classList.remove('hidden');

        // Update progress bar
        const progress = (step / totalSteps) * 100;
        document.getElementById('progressBar').style.width = progress + '%';

        // Update step labels styling
        document.querySelectorAll('.step-label').forEach(label => {
            const labelStep = parseInt(label.getAttribute('data-step'));
            
            // Reset all classes first
            label.classList.remove('text-emerald-400', 'text-gray-500', 'font-semibold');
            label.classList.add('text-gray-400');
            
            if (labelStep === step) {
                // Current step - highlight
                label.classList.remove('text-gray-400');
                label.classList.add('text-emerald-400', 'font-semibold');
            } else if (labelStep < step) {
                // Completed steps
                label.classList.remove('text-gray-400');
                label.classList.add('text-gray-500');
            }
        });

        currentStep = step;

        // Scroll form into view smoothly
        document.getElementById('inquiryForm').scrollIntoView({ 
            behavior: 'smooth', 
            block: 'nearest' 
        });
    }

    function validateStep(step) {
        const stepEl = document.getElementById('step' + step);
        const requiredFields = stepEl.querySelectorAll('[required]');
        let isValid = true;

        requiredFields.forEach(field => {
            if (!field.value || field.value.trim() === '') {
                field.classList.add('border-red-500');
                isValid = false;
            } else {
                field.classList.remove('border-red-500');
            }
        });

        return isValid;
    }

    function nextStep() {
        if (validateStep(currentStep)) {
            if (currentStep < totalSteps) {
                showStep(currentStep + 1);
            }
        } else {
            // Focus first invalid field
            const stepEl = document.getElementById('step' + currentStep);
            const firstInvalid = stepEl.querySelector('[required].border-red-500');
            if (firstInvalid) {
                firstInvalid.focus();
            }
        }
    }

    function prevStep() {
        if (currentStep > 1) {
            showStep(currentStep - 1);
        }
    }

    function goToStep(step) {
        // Allow going to previous steps without validation
        if (step < currentStep) {
            showStep(step);
        } else {
            // Validate all steps between current and target
            let canProceed = true;
            for (let i = currentStep; i < step; i++) {
                if (!validateStep(i)) {
                    canProceed = false;
                    break;
                }
            }
            if (canProceed) {
                showStep(step);
            }
        }
    }

    // Initialize form on page load
    document.addEventListener('DOMContentLoaded', function() {
        showStep(1);
    });
</script>
@endsection