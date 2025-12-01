@extends('technician.layout.app')

@section('content')

<form action="{{ route('quotation.store') }}" method="POST" enctype="multipart/form-data" id="quotationForm">
    @csrf

    <div class="bg-white rounded-xl shadow-sm border p-8 space-y-8">

        {{-- Alert Messages --}}
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

        @if(session('error'))
            <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg">
                {{ session('error') }}
            </div>
        @endif

        @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        {{-- Header Section --}}
        <div class="flex justify-between items-center border-b pb-3">
            <div>
                <h1 class="text-xl font-bold text-gray-800">Techne Fixer Quotation Form</h1>
                <p class="text-sm text-gray-500">007 Manga Street Crossing Bayabas Davao City</p>
                <p class="text-sm text-gray-500">Contact No: 09662406825  TIN 618‑863‑736‑000000</p>
            </div>
            <img src="{{ asset('images/logo.png') }}" class="w-20 h-20 object-contain" alt="Company Logo">
        </div>

        {{-- Inquiry Prefill --}}
        @if(isset($inquiry))
            <input type="hidden" name="inquiry_id" value="{{ $inquiry->id }}">
            <div class="bg-blue-50 border border-blue-200 text-blue-700 rounded-md p-4">
                <p class="text-sm">
                    <strong>Converting Inquiry:</strong>
                    INQ‑{{ str_pad($inquiry->id, 5, '0', STR_PAD_LEFT) }}<br>
                    {{ $inquiry->name ?? $inquiry->customer->name }}<br>
                    <span class="text-gray-700">Issue:</span> {{ $inquiry->issue_description }}
                </p>
            </div>
        @endif

        {{-- Client Photo --}}
        <div>
            <label class="block text-sm text-gray-700 font-semibold mb-2">Client Logo / Photo</label>
            <div id="clientLogoPreview" class="w-32 h-32 bg-gray-100 flex items-center justify-center text-gray-400 mb-4 rounded-full border overflow-hidden">
                <span>Preview</span>
            </div>
            <input type="file" name="client_logo" id="clientLogoInput" class="hidden" accept="image/*">
            <button type="button"
                    onclick="document.getElementById('clientLogoInput').click()"
                    class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 focus:ring-2 ring-offset-1 ring-blue-200 transition-all text-sm">
                Add Photo
            </button>
            <p class="text-xs text-gray-500 mt-2">Upload client’s logo or photo (PNG/JPG).</p>
        </div>

        {{-- Project Information --}}
        <div class="bg-gray-50 border rounded-md p-4 grid sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm text-gray-600">Project Title *</label>
                <input type="text" name="project_title"
                value="{{ old('project_title', isset($inquiry) ? 'Quotation for '.$inquiry->category.' – INQ‑'.str_pad($inquiry->id,5,'0',STR_PAD_LEFT) : '') }}"
                required
                class="w-full border mt-1 rounded-md px-3 py-2 text-sm focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div>
                <label class="block text-sm text-gray-600">Date Issued *</label>
                <input type="date" name="date_issued" value="{{ old('date_issued') }}" required
                       class="w-full border mt-1 rounded-md px-3 py-2 text-sm focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div>
                <label class="block text-sm text-gray-600">Client Name *</label>
                <input type="text" name="client_name"
                       value="{{ old('client_name', $inquiry->name ?? $inquiry->customer->name ?? '') }}" required
                       class="w-full border mt-1 rounded-md px-3 py-2 text-sm focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div>
                <label class="block text-sm text-gray-600">Client Address</label>
                <input type="text" name="client_address"
                       value="{{ old('client_address', $inquiry->service_location ?? '') }}"
                       class="w-full border mt-1 rounded-md px-3 py-2 text-sm focus:ring-blue-500 focus:border-blue-500">
            </div>
        </div>

        {{-- Objective --}}
        <div>
            <label class="block text-sm text-gray-700 font-semibold mb-2">Objective</label>
            <textarea rows="3" name="objective"
                      class="w-full border rounded-md px-3 py-2 text-sm focus:ring-blue-500 focus:border-blue-500">{{ old('objective') }}</textarea>
        </div>

        {{-- Itemization Table --}}
        <div>
            <h3 class="text-lg font-semibold text-gray-700 mb-3">Items and Services *</h3>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm border rounded-lg">
                    <thead class="bg-gray-100 text-gray-700">
                        <tr>
                            <th class="px-4 py-2">Item Name</th>
                            <th class="px-4 py-2">Description</th>
                            <th class="px-4 py-2">Qty</th>
                            <th class="px-4 py-2">Unit Price (₱)</th>
                            <th class="px-4 py-2">Total (₱)</th>
                            <th class="px-4 py-2 text-right">–</th>
                        </tr>
                    </thead>
                    <tbody id="itemRows" class="divide-y"></tbody>
                </table>
            </div>
            <div class="flex justify-end mt-3">
                <button type="button" id="addItemBtn" class="text-blue-600 hover:underline text-sm">+ Add Item</button>
            </div>
        </div>

        {{-- Totals --}}
        <div class="flex justify-end">
            <div class="bg-gray-50 border rounded-lg p-4 w-80">
                <div class="flex justify-between text-sm py-1">
                    <span>Subtotal</span><span id="subtotal">₱0.00</span>
                </div>
                <div class="flex justify-between text-sm py-1">
                    <span>Diagnostic Fee (10%)</span><span id="tax">₱0.00</span>
                </div>
                <div class="flex justify-between text-sm font-semibold border-t mt-2 pt-2">
                    <span>Grand Total</span><span id="totalAmount">₱0.00</span>
                </div>
            </div>
        </div>

        {{-- Scope of Work --}}
        <div>
            <h3 class="block text-sm text-gray-700 font-semibold mb-2">Scope of Work</h3>
            <div class="overflow-x-auto border rounded-lg bg-gray-50">
                <table class="w-full text-sm text-left border-collapse">
                    <thead class="bg-gray-100 text-gray-700 border-b">
                        <tr>
                            <th class="px-4 py-2 w-1/4">Scenario</th>
                            <th class="px-4 py-2 w-3/4">Cases / Description</th>
                            <th class="px-4 py-2 text-right">–</th>
                        </tr>
                    </thead>
                    <tbody id="scopeScenarioRows" class="divide-y"></tbody>
                </table>
            </div>
            <div class="flex justify-end mt-3">
                <button type="button" id="addScenarioBtn" class="text-blue-600 hover:underline text-sm">+ Add Scenario</button>
            </div>
        </div>

        {{-- Scope of Waiver --}}
        <div>
            <h3 class="block text-sm text-gray-700 font-semibold mb-2">Scope of Waiver</h3>
            <div class="overflow-x-auto border rounded-lg bg-gray-50">
                <table class="w-full text-sm text-left border-collapse">
                    <thead class="bg-gray-100 text-gray-700 border-b">
                        <tr>
                            <th class="px-4 py-2 w-1/4">Scenario</th>
                            <th class="px-4 py-2 w-3/4">Exclusion Detail</th>
                            <th class="px-4 py-2 text-right">–</th>
                        </tr>
                    </thead>
                    <tbody id="waiverScenarioRows" class="divide-y"></tbody>
                </table>
            </div>
            <div class="flex justify-end mt-3">
                <button type="button" id="addWaiverScenarioBtn" class="text-blue-600 hover:underline text-sm">+ Add Scenario</button>
            </div>
        </div>

        {{-- Deliverables --}}
        <div>
            <h3 class="block text-sm text-gray-700 font-semibold mb-2">Expected Deliverables</h3>
            <div class="overflow-x-auto bg-gray-50 border rounded-lg">
                <table class="w-full text-sm text-left border-collapse">
                    <thead class="bg-gray-100 text-gray-700 border-b">
                        <tr>
                            <th class="px-4 py-2">#</th>
                            <th class="px-4 py-2">Detail</th>
                            <th class="px-4 py-2 text-right">–</th>
                        </tr>
                    </thead>
                    <tbody id="deliverableRows" class="divide-y"></tbody>
                </table>
            </div>
            <div class="flex justify-end mt-3">
                <button type="button" id="addDeliverableBtn" class="text-blue-600 hover:underline text-sm">+ Add Deliverable</button>
            </div>
        </div>

        {{-- Timeline --}}
        <div>
            <label class="block text-sm text-gray-700 font-semibold mb-2">Timeline / Completion Schedule</label>
            <div class="flex items-center gap-2">
                <input id="minDays" name="timeline_min_days" type="number" min="1" placeholder="Min" value="{{ old('timeline_min_days') }}"
                       class="w-24 border rounded-md px-3 py-2 text-sm focus:ring-blue-500 focus:border-blue-500">
                <span class="text-gray-500">to</span>
                <input id="maxDays" name="timeline_max_days" type="number" min="1" placeholder="Max" value="{{ old('timeline_max_days') }}"
                       class="w-24 border rounded-md px-3 py-2 text-sm focus:ring-blue-500 focus:border-blue-500">
                <span class="text-gray-700 text-sm">days</span>
            </div>
            <p id="timelinePreview" class="text-xs text-gray-500 mt-2 italic"></p>
        </div>

        {{-- Terms and Conditions --}}
        <div>
            <label class="block text-sm text-gray-700 font-semibold mb-2">Terms and Conditions</label>
            <textarea rows="5" name="terms_conditions" placeholder="Payment terms, warranty, confidentiality clauses" class="w-full border rounded-md px-3 py-2 text-sm focus:ring-blue-500 focus:border-blue-500">{{ old('terms_conditions') }}</textarea>
        </div>

        {{-- Acceptance --}}
        <div class="border-t pt-4">
            <h3 class="text-lg font-semibold text-gray-700 mb-3">Acceptance of Terms</h3>
            <p class="text-sm text-gray-600 mb-4">Customer acknowledges agreement by signing below.</p>

            <div class="grid md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm text-gray-700 mb-1">Customer Name</label>
                    <input type="text" name="customer_name" placeholder="Authorized Representative" value="{{ old('customer_name') }}"
                           class="w-full border rounded-md px-3 py-2 text-sm mb-2 focus:ring-blue-500 focus:border-blue-500">
                    <div class="flex justify-between text-sm gap-4">
                        <input type="text" name="customer_signature" placeholder="Signature / eSign" value="{{ old('customer_signature') }}" class="border-b flex-1">
                        <input type="date" name="customer_date" value="{{ old('customer_date') }}" class="border rounded-md px-2 py-1 w-36 text-sm">
                    </div>
                </div>
                <div>
                    <label class="block text-sm text-gray-700 mb-1">Service Provider Representative</label>
                    <input type="text" name="provider_name" placeholder="Techne Fixer Rep" value="{{ old('provider_name') }}"
                           class="w-full border rounded-md px-3 py-2 text-sm mb-2 focus:ring-blue-500 focus:border-blue-500">
                    <div class="flex justify-between text-sm gap-4">
                        <input type="text" name="provider_signature" placeholder="Signature / eSign" value="{{ old('provider_signature') }}" class="border-b flex-1">
                        <input type="date" name="provider_date" value="{{ old('provider_date') }}" class="border rounded-md px-2 py-1 w-36 text-sm">
                    </div>
                </div>
            </div>
        </div>

        {{-- Actions --}}
        <div class="flex justify-end space-x-3 border-t pt-4">
            <a href="{{ route('technician.quotation') }}">
                <button type="button" class="px-4 py-2 border rounded-md text-gray-600 text-sm hover:bg-gray-100 active:scale-95 transition-transform duration-100 shadow-sm hover:shadow-md">
                    Cancel
                </button>
            </a>
            <button type="submit" name="action" value="draft" class="px-4 py-2 bg-green-600 text-white rounded-md text-sm hover:bg-green-700">
                Save Draft
            </button>
            <button type="submit" name="action" value="generate_pdf" class="px-4 py-2 bg-blue-600 text-white rounded-md text-sm hover:bg-blue-700">
                Generate PDF
            </button>
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
