@extends('technician.layout.app')

@section('content')

<form action="{{ route('technician.inquire.store') }}" method="POST" enctype="multipart/form-data" id="inquiryForm">
  @csrf

  <div class="bg-white rounded-xl shadow-sm border p-8 space-y-8">

    {{-- Success Message --}}
    @if(session('success'))
      <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg">
        {{ session('success') }}
      </div>
    @endif

    {{-- Error Display --}}
    @if ($errors->any())
      <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg">
        <strong>Please fix the following errors:</strong>
        <ul class="mt-2 list-disc list-inside">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <!-- Header Section -->
    <div class="flex justify-between items-center border-b pb-3">
      <div>
        <h1 class="text-xl font-bold text-gray-800">Techne Fixer Inquiry Form</h1>
        <p class="text-sm text-gray-500">Need technical help? Submit your inquiry and we'll respond promptly.</p>
      </div>
      <img src="{{ asset('images/logo.png') }}" class="w-20 h-20 object-contain" alt="Company Logo">
    </div>


    <!-- Progress Indicator -->
    <div class="mb-6">
      <div class="flex items-center justify-between mb-2 text-xs font-medium">
        <button type="button" onclick="goToStep(1)" class="step-label cursor-pointer hover:text-blue-600" data-step="1">Contact Info</button>
        <button type="button" onclick="goToStep(2)" class="step-label cursor-pointer hover:text-blue-600" data-step="2">Service Details</button>
        <button type="button" onclick="goToStep(3)" class="step-label cursor-pointer hover:text-blue-600" data-step="3">Additional Info</button>
      </div>
      <div class="w-full bg-gray-200 rounded-full h-1.5">
        <div class="bg-blue-600 h-1.5 rounded-full transition-all duration-300" id="progressBar" style="width:33%"></div>
      </div>
    </div>


    <!-- Step 1: Contact Information -->
    <div class="form-step space-y-4" id="step1">
      <h3 class="text-lg font-semibold text-gray-700 mb-3">Contact Information</h3>

      <div class="grid md:grid-cols-2 gap-4">
        <div>
          <label class="block text-sm text-gray-600 font-medium mb-1">Full Name *</label>
          <input type="text" name="name"
                 value="{{ old('name', (Auth::check() ? Auth::user()->firstname . ' ' . Auth::user()->lastname : '')) }}"
                 class="w-full border rounded-md px-3 py-2 text-sm focus:ring-blue-500 focus:border-blue-500"
                 required>
        </div>

        <div>
          <label class="block text-sm text-gray-600 font-medium mb-1">Contact Number *</label>
          <input type="tel" name="contact_number" pattern="[0-9]{11}" placeholder="09XX XXX XXXX"
                 value="{{ old('contact_number') }}"
                 class="w-full border rounded-md px-3 py-2 text-sm focus:ring-blue-500 focus:border-blue-500"
                 required>
        </div>

        <div>
          <label class="block text-sm text-gray-600 font-medium mb-1">Email Address *</label>
          <input type="email" name="email"
                 value="{{ old('email', (Auth::check() ? Auth::user()->email : '')) }}"
                 class="w-full border rounded-md px-3 py-2 text-sm focus:ring-blue-500 focus:border-blue-500"
                 required>
        </div>

        <div>
          <label class="block text-sm text-gray-600 font-medium mb-1">Service Location *</label>
          <textarea name="service_location" rows="2" placeholder="Street, Barangay, City"
                    class="w-full border rounded-md px-3 py-2 text-sm focus:ring-blue-500 focus:border-blue-500"
                    required>{{ old('service_location') }}</textarea>
        </div>
      </div>

      <div class="flex justify-end mt-4">
        <button type="button" onclick="nextStep()" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 text-sm">Next →</button>
      </div>
    </div>


    <!-- Step 2: Service Details -->
    <div class="form-step space-y-4 hidden" id="step2">
      <h3 class="text-lg font-semibold text-gray-700 mb-3">Service Details</h3>

      <div class="grid md:grid-cols-2 gap-4">
        <div>
          <label class="block text-sm text-gray-600 font-medium mb-1">Category of Service *</label>
          <select name="category" class="w-full border rounded-md px-3 py-2 text-sm focus:ring-blue-500 focus:border-blue-500" required>
            <option value="">Select Category</option>
            <option value="Computer / Laptop Repair">Computer / Laptop Repair</option>
            <option value="Networking">Networking</option>
            <option value="Printer Repair">Printer Repair</option>
            <option value="CCTV Installation / Repair">CCTV Installation / Repair</option>
            <option value="Aircon Cleaning / Repair">Aircon Cleaning / Repair</option>
            <option value="Other">Other</option>
          </select>
        </div>

        <div>
          <label class="block text-sm text-gray-600 font-medium mb-1">Device Brand & Model</label>
          <input type="text" name="device_details" placeholder="e.g. HP Laptop 15s, Samsung Split-Type"
                 value="{{ old('device_details') }}"
                 class="w-full border rounded-md px-3 py-2 text-sm focus:ring-blue-500 focus:border-blue-500">
        </div>
      </div>

      <div>
        <label class="block text-sm text-gray-600 font-medium mb-1">Issue Description *</label>
        <textarea name="issue_description" rows="4"
                  class="w-full border rounded-md px-3 py-2 text-sm focus:ring-blue-500 focus:border-blue-500"
                  placeholder="Describe the issue in detail..." required>{{ old('issue_description') }}</textarea>
      </div>

      <div>
        <label class="block text-sm text-gray-600 font-medium mb-1">Urgency Level *</label>
        <select name="urgency" class="w-full border rounded-md px-3 py-2 text-sm focus:ring-blue-500 focus:border-blue-500" required>
          <option value="Normal" {{ old('urgency', 'Normal') == 'Normal' ? 'selected' : '' }}>Normal (1‑3 days)</option>
          <option value="Urgent" {{ old('urgency') == 'Urgent' ? 'selected' : '' }}>Urgent (same/next day)</option>
          <option value="Flexible" {{ old('urgency') == 'Flexible' ? 'selected' : '' }}>Flexible (anytime)</option>
        </select>
      </div>

      <div class="flex justify-between mt-4">
        <button type="button" onclick="prevStep()" class="px-4 py-2 border rounded-md text-gray-600 text-sm hover:bg-gray-100">← Back</button>
        <button type="button" onclick="nextStep()" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 text-sm">Next →</button>
      </div>
    </div>


    <!-- Step 3: Additional Information -->
    <div class="form-step space-y-4 hidden" id="step3">
      <h3 class="text-lg font-semibold text-gray-700 mb-3">Additional Information</h3>

      <div>
        <label class="block text-sm text-gray-600 font-medium mb-1">Preferred Date & Time (optional)</label>
        <input type="datetime-local" name="preferred_schedule"
               class="w-full border rounded-md px-3 py-2 text-sm focus:ring-blue-500 focus:border-blue-500"
               value="{{ old('preferred_schedule') }}">
      </div>

      <div>
        <label class="block text-sm text-gray-600 font-medium mb-1">Upload Photo (optional)</label>
        <input type="file" name="photo" accept="image/*"
               class="w-full border rounded-md px-3 py-2 text-sm focus:ring-blue-500 focus:border-blue-500 file:bg-blue-600 file:text-white file:px-3 file:py-1 file:border-none file:rounded hover:file:bg-blue-700">
        <p class="text-xs text-gray-500 mt-1">Upload a photo of the issue or equipment (Max: 5MB)</p>
      </div>

      <div>
        <label class="block text-sm text-gray-600 font-medium mb-1">How Did You Hear About Us? (optional)</label>
        <select name="referral_source" class="w-full border rounded-md px-3 py-2 text-sm focus:ring-blue-500 focus:border-blue-500">
          <option value="">Select one</option>
          <option value="Facebook">Facebook</option>
          <option value="Google Search">Google Search</option>
          <option value="Friend/Family Referral">Friend/Family Referral</option>
          <option value="Walk-in">Walk-in</option>
          <option value="Other">Other</option>
        </select>
      </div>

      <div class="flex justify-between mt-4 border-t pt-4">
        <button type="button" onclick="prevStep()" class="px-4 py-2 border rounded-md text-gray-600 text-sm hover:bg-gray-100">← Back</button>
        <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-md text-sm hover:bg-green-700">Submit Inquiry ✓</button>
      </div>
    </div>

  </div>
</form>

<script>
  let currentStep = 1;
  const totalSteps = 3;

  function showStep(step) {
    document.querySelectorAll('.form-step').forEach(s => s.classList.add('hidden'));
    document.getElementById('step' + step).classList.remove('hidden');
    currentStep = step;

    // update progress bar
    const progress = (step / totalSteps) * 100;
    document.getElementById('progressBar').style.width = progress + '%';

    // highlight step labels
    document.querySelectorAll('.step-label').forEach(label => {
      const labelStep = parseInt(label.getAttribute('data-step'));
      label.classList.remove('text-blue-600', 'font-semibold');
      if (labelStep === step) label.classList.add('text-blue-600', 'font-semibold');
    });
  }

  function nextStep() {
    if (validateStep(currentStep) && currentStep < totalSteps) {
      showStep(currentStep + 1);
    }
  }

  function prevStep() {
    if (currentStep > 1) showStep(currentStep - 1);
  }

  function goToStep(step) {
    if (step < currentStep) {
      showStep(step);
    } else {
      let canProceed = true;
      for (let i = currentStep; i < step; i++) {
        if (!validateStep(i)) {
          canProceed = false;
          break;
        }
      }
      if (canProceed) showStep(step);
    }
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

  document.addEventListener('DOMContentLoaded', () => showStep(1));
</script>

@endsection