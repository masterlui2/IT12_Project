@extends('technician.layout.app')

@section('content')

<form action="{{ route('technician.job.update', $job->id) }}" method="POST" enctype="multipart/form-data" id="jobOrderForm">
    @csrf
    @method('PATCH')

  @if(isset($quotation) && $quotation)
    <input type="hidden" name="quotation_id" value="{{ $quotation->id }}">
  @endif

  {{-- Hidden fields for calculated totals --}}
    <input type="hidden" name="subtotal" id="hiddenSubtotal" value="0">
    <input type="hidden" name="downpayment" id="hiddenDownpayment" value="0">
    <input type="hidden" name="total_amount" id="hiddenTotalAmount" value="0">


  <div class="bg-white rounded-xl shadow-sm border p-8 space-y-8">

    {{-- HEADER --}}
    <div class="flex justify-between items-center border-b pb-3">
      <div>
        <h1 class="text-xl font-bold text-gray-800">Techne Fixer Computer and Laptop Repair Services</h1>
        <p class="text-sm text-gray-500">007 Manga Street Crossing Bayabas, Davao City</p>
        <p class="text-sm text-gray-500">Contact No: 09662406825  TIN 618‑863‑736‑000000</p>
      </div>
      <img src="{{ asset('images/logo.png') }}" class="w-20 h-20 object-contain" alt="Company Logo">
    </div>


    {{-- Display Validation Errors --}}
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

    {{-- Display Session Error --}}
    @if(session('error'))
      <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg">
        {{ session('error') }}
      </div>
    @endif

    {{-- Display Success Message --}}
    @if(session('success'))
      <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg">
        {{ session('success') }}
      </div>
    @endif


    @if(isset($quotation))
      <div class="bg-blue-50 border border-blue-200 text-blue-800 px-4 py-3 rounded-lg">
        <div class="flex items-center gap-2">
          <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
          </svg>
          <div>
            <strong>Derived from Quotation:</strong>
            QTN‑{{ str_pad($quotation->id, 5, '0', STR_PAD_LEFT) }} - {{ $quotation->project_title }}
            @if($quotation->client_name)
              <span class="text-sm ml-2">| Client: {{ $quotation->client_name }}</span>
            @endif
          </div>
        </div>
      </div>
    @endif

    <div class="bg-gray-50 border rounded-md p-4 grid sm:grid-cols-2 gap-4">
      <div>
        <label class="block text-sm text-gray-600">Job Order Title *</label>
        <input type="text" name="job_title"
              value="{{ old('job_title', $job->quotation->project_title ?? '') }}"
              readonly
              class="w-full border mt-1 rounded-md px-3 py-2 text-sm bg-gray-100 text-gray-700">
      </div>

      <div>
          <label class="block text-sm text-gray-600">Date Started *</label>
            <input type="date"
                name="start_date"
                value="{{ old('start_date', $job->start_date ? $job->start_date->format('Y-m-d') : '') }}"
                placeholder="{{ now()->format('Y-m-d') }}"
                required
                @if($job->start_date) readonly class="w-full border mt-1 rounded-md px-3 py-2 text-sm bg-gray-100 text-gray-700 cursor-not-allowed"
                @else class="w-full border mt-1 rounded-md px-3 py-2 text-sm focus:ring-blue-500 focus:border-blue-500"
                @endif>
      </div>

      <div>
        <label class="block text-sm text-gray-600">Client *</label>
        <input type="text" name="client_name"
              value="{{ old('client_name', $job->quotation->client_name ?? '') }}"
              readonly
              class="w-full border mt-1 rounded-md px-3 py-2 text-sm bg-gray-100 text-gray-700">
      </div>

      <div>
        <label class="block text-sm text-gray-600">Service Location</label>
        <input type="text" name="service_location"
              value="{{ old('service_location', $job->quotation->client_address ?? '') }}"
              readonly
              class="w-full border mt-1 rounded-md px-3 py-2 text-sm bg-gray-100 text-gray-700">
      </div>
    </div>

    {{-- ITEMS (Same as Quotation) --}}
<div>
  <h3 class="text-lg font-semibold text-gray-700 mb-3">Items / Services Used *</h3>
  <div class="overflow-x-auto">
    <table class="w-full text-left text-sm border rounded-lg">
      <thead class="bg-gray-100 text-gray-700">
        <tr>
          <th class="px-4 py-2">Item / Part</th>
          <th class="px-4 py-2">Description</th>
          <th class="px-4 py-2">Qty Used</th>
          <th class="px-4 py-2">Actual Unit Price (₱)</th>
          <th class="px-4 py-2">Total (₱)</th>
        </tr>
      </thead>
      <tbody id="itemRows" class="divide-y">
        {{-- Quotation items (name & description readonly, qty & price editable) --}}
        @if(isset($job->quotation->details) && count($job->quotation->details))
            @foreach($job->quotation->details as $i => $detail)
                <tr class="bg-gray-50 quotation-row">
                    <td class="px-4 py-3 font-medium text-gray-700">
                        <input type="text"
                              name="items[{{ $i }}][name]"
                              value="{{ $detail->item_name }}"
                              readonly
                              class="w-full border rounded-md px-2 py-1 text-sm bg-gray-100 text-gray-700 cursor-not-allowed">
                    </td>
                    <td class="px-4 py-3">
                        <textarea rows="2"
                                  name="items[{{ $i }}][description]"
                                  readonly
                                  class="w-full border rounded-md px-2 py-1 text-sm bg-gray-100 text-gray-700 cursor-not-allowed">{{ $detail->description }}</textarea>
                    </td>
                    <td class="px-4 py-3 w-20">
                        <input type="number"
                              name="items[{{ $i }}][quantity]"
                              value="{{ $detail->quantity }}"
                              min="1" step="1"
                              class="item-qty border rounded-md px-2 py-1 w-full text-center text-sm focus:ring-blue-500 focus:border-blue-500">
                    </td>
                    <td class="px-4 py-3 w-24">
                        <input type="number"
                              name="items[{{ $i }}][unit_price]"
                              value="{{ $detail->unit_price }}"
                              min="0" step="0.01"
                              class="item-price border rounded-md px-2 py-1 w-full text-center text-sm focus:ring-blue-500 focus:border-blue-500">
                    </td>
                    <td class="px-4 py-3 text-gray-700 item-total">
                        ₱{{ number_format($detail->total, 2) }}
                    </td>
                </tr>
            @endforeach
        @endif
    </tbody>
    </table>
  </div>
</div>
    {{-- TOTALS --}}
    <div class="flex justify-end mt-4">
      <div class="bg-gray-50 border rounded-lg p-4 w-80">
        <div class="flex justify-between text-sm py-1">
          <span>Subtotal</span>
          <span id="subtotal">₱0.00</span>
        </div>
        <div class="flex justify-between text-sm py-1">
          <span>Downpayment (50%)</span>
          <span id="tax">₱0.00</span>
        </div>
        <div class="flex justify-between text-sm font-semibold border-t mt-2 pt-2">
          <span>Grand Total</span>
          <span id="totalAmount">₱0.00</span>
        </div>
      </div>
    </div>

    <!-- Scope of Work (Reference Only) -->
    @if(isset($job->quotation->scopes) && $job->quotation->scopes->count())
      <div class="mt-8">
          <h3 class="text-sm font-semibold text-gray-700 mb-2">Scope of Work (Reference)</h3>
          <div class="overflow-x-auto bg-gray-50 border rounded-md">
              <table class="w-full text-sm text-left border-collapse">
                  <thead class="bg-gray-100 text-gray-700 border-b">
                      <tr>
                          <th class="px-4 py-2 w-1/4">Scenario</th>
                          <th class="px-4 py-2 w-1/4">Case</th>
                          <th class="px-4 py-2 w-2/4">Description</th>
                      </tr>
                  </thead>
                  <tbody>
                      @foreach($job->quotation->scopes as $scope)
                          @php
                              $caseCount = $scope->cases->count();
                          @endphp
                          @foreach($scope->cases as $caseIndex => $case)
                              <tr class="border-b">
                                  {{-- Only print scenario name once, merged across its row span --}}
                                  @if($caseIndex === 0)
                                      <td rowspan="{{ $caseCount }}"
                                          class="px-4 py-2 font-semibold text-gray-800 align-top">
                                          {{ $scope->scenario_name ?? '–' }}
                                      </td>
                                  @endif

                                  <td class="px-4 py-2 text-gray-700">{{ $case->case_title ?? '–' }}</td>
                                  <td class="px-4 py-2 text-gray-700">{{ $case->case_description ?? '–' }}</td>
                              </tr>
                          @endforeach
                      @endforeach
                  </tbody>
              </table>
          </div>
      </div>
    @endif

    <!-- Scope of Waiver (Reference Only) -->
    @if(isset($job->quotation->waivers) && $job->quotation->waivers->count())
      <div class="mt-8">
          <h3 class="text-sm font-semibold text-gray-700 mb-2">Scope of Waiver (Reference)</h3>
          <div class="overflow-x-auto bg-gray-50 border rounded-md">
              <table class="w-full text-sm text-left border-collapse">
                  <thead class="bg-gray-100 text-gray-700 border-b">
                      <tr>
                          <th class="px-4 py-2 w-1/4">Waiver Scenario</th>
                          <th class="px-4 py-2 w-1/4">Case</th>
                          <th class="px-4 py-2 w-2/4">Description</th>
                      </tr>
                  </thead>
                  <tbody>
                      @foreach($job->quotation->waivers as $waiver)
                          @php $wCaseCount = $waiver->cases->count(); @endphp
                          @foreach($waiver->cases as $wIndex => $wCase)
                              <tr class="border-b">
                                  @if($wIndex === 0)
                                      <td rowspan="{{ $wCaseCount }}" class="px-4 py-2 font-semibold text-gray-800 align-top">
                                          {{ $waiver->waiver_title ?? '–' }}
                                      </td>
                                  @endif
                                  <td class="px-4 py-2 text-gray-700">{{ $wCase->case_title ?? '–' }}</td>
                                  <td class="px-4 py-2 text-gray-700">{{ $wCase->description ?? '–' }}</td>
                              </tr>
                          @endforeach
                      @endforeach
                  </tbody>
              </table>
          </div>
      </div>
    @endif

    {{-- TECHNICIAN NOTES --}}
    <div>
      <label class="block text-sm text-gray-700 font-semibold mb-2">Technician Notes / Progress</label>
      <textarea rows="4" name="technician_notes"
                placeholder="Record observations, parts replaced, diagnostics, etc."
                class="w-full border rounded-md px-3 py-2 text-sm focus:ring-blue-500 focus:border-blue-500">{{ old('technician_notes', $job->technician_notes) }}</textarea>
    </div>

    {{-- ACCEPTANCE / COMPLETION --}}
    <div class="border-t pt-4">
      <h3 class="text-lg font-semibold text-gray-700 mb-3">Completion Confirmation</h3>
      <p class="text-sm text-gray-600 mb-4">By signing below, both client and technician confirm that all listed services/items were rendered as agreed.</p>

      <div class="grid md:grid-cols-2 gap-6">
        <div>
          <label class="block text-sm text-gray-700 font-medium mb-1">Customer Name</label>
          <input type="text" name="customer_name" 
                 value="{{ old('customer_name', $job->quotation->client_name ?? '') }}"
                 class="w-full border rounded-md px-3 py-2 text-sm mb-2 focus:ring-blue-500 focus:border-blue-500">
          <div class="flex justify-between text-sm gap-4">
            <input type="text" name="customer_signature" 
                   placeholder="Signature / eSign"
                   value="{{ old('customer_signature') }}"
                   class="border-b flex-1">
            <input type="date" name="customer_date" 
                   value="{{ old('customer_date', now()->format('Y-m-d')) }}"
                   class="border rounded-md px-2 py-1 w-36 text-sm">
          </div>
        </div>

        <div>
          <label class="block text-sm text-gray-700 font-medium mb-1">Technician</label>
          <input type="text" name="technician_name" 
                 placeholder="Assigned Technician"
                 value="{{ old('technician_name') }}"
                 class="w-full border rounded-md px-3 py-2 text-sm mb-2 focus:ring-blue-500 focus:border-blue-500">
          <div class="flex justify-between text-sm gap-4">
            <input type="text" name="technician_signature" 
                   placeholder="Signature / eSign"
                   value="{{ old('technician_signature') }}" 
                   class="border-b flex-1">
            <input type="date" name="technician_date" 
                   value="{{ old('technician_date', now()->format('Y-m-d')) }}" 
                   class="border rounded-md px-2 py-1 w-36 text-sm">
          </div>
        </div>
      </div>
    </div>

    {{-- ACTION BUTTONS --}}
    <div class="flex justify-end space-x-3 border-t pt-4">
      <a href="{{ route('technician.job.index') }}">
        <button type="button" class="px-4 py-2 border rounded-md text-gray-600 text-sm hover:bg-gray-100 shadow-sm">
          Cancel
        </button>
      </a>
      <button type="submit" name="action" value="save"
              class="px-4 py-2 bg-green-600 text-white rounded-md text-sm hover:bg-green-700">
        Save Job Order
      </button>
      <button type="submit" name="action" value="completed"
              class="px-4 py-2 bg-blue-600 text-white rounded-md text-sm hover:bg-blue-700">
        Mark as Completed
      </button>
    </div>

  </div>
</form>

<script>
// Utility functions
function formatCurrency(amount) {
  return '₱' + parseFloat(amount).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
}

function calculateTotals() {
  let subtotal = 0;
  
  // Calculate subtotal from all rows
  document.querySelectorAll('#itemRows tr').forEach(row => {
    const qtyInput = row.querySelector('input[name*="[quantity]"]');
    const priceInput = row.querySelector('input[name*="[unit_price]"]');
    const totalCell = row.querySelector('.item-total');
    
    if (qtyInput && priceInput && totalCell) {
      const qty = parseFloat(qtyInput.value || 0);
      const price = parseFloat(priceInput.value || 0);
      const total = qty * price;
      
      totalCell.textContent = formatCurrency(total);
      subtotal += total;
    }
  });
  
  // Calculate downpayment (50%) and remaining balance
  const downpayment = subtotal * 0.50;
  const totalAmount = subtotal - downpayment; // Remaining balance
  
  // Update display
  document.getElementById('subtotal').textContent = formatCurrency(subtotal);
  document.getElementById('tax').textContent = formatCurrency(downpayment);
  document.getElementById('totalAmount').textContent = formatCurrency(totalAmount);
  
  // Update hidden fields for form submission
  document.getElementById('hiddenSubtotal').value = subtotal.toFixed(2);
  document.getElementById('hiddenDownpayment').value = downpayment.toFixed(2);
  document.getElementById('hiddenTotalAmount').value = totalAmount.toFixed(2);
}

// Calculate totals on page load
document.addEventListener('DOMContentLoaded', () => {
  calculateTotals();
  
  // Add event listeners to all quantity and price inputs
  document.querySelectorAll('#itemRows .item-qty, #itemRows .item-price').forEach(input => {
    input.addEventListener('input', calculateTotals);
  });
});

// Handle remove functionality for editable rows only
document.getElementById('itemRows').addEventListener('click', e => {
  if (e.target.classList.contains('remove-row')) {
    const row = e.target.closest('tr');
    if (row.classList.contains('editable-row')) {
      e.preventDefault();
      row.remove();
      calculateTotals();
    } else {
      alert('Quoted items cannot be removed.');
    }
  }
});
</script>

@endsection