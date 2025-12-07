@extends('technician.layout.app')

@section('content')

<form action="{{-- route('technician.job.store') --}}" method="POST" enctype="multipart/form-data" id="jobOrderForm">
  @csrf

  @if(isset($quotation) && $quotation)
    <input type="hidden" name="quotation_id" value="{{ $quotation->id }}">
  @endif

  <div class="bg-white rounded-xl shadow-sm border p-8 space-y-8">

    {{-- HEADER --}}
    <div class="flex justify-between items-center border-b pb-3">
      <div>
        <h1 class="text-xl font-bold text-gray-800">Techne Fixer Computer and Laptop Repair Services</h1>
        <p class="text-sm text-gray-500">007 Manga Street Crossing Bayabas, Davao City</p>
        <p class="text-sm text-gray-500">Contact No: 09662406825  TIN 618‑863‑736‑000000</p>
      </div>
      <img src="{{ asset('images/logo.png') }}" class="w-20 h-20 object-contain" alt="Company Logo">
    </div>

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

    {{-- JOB ORDER INFO --}}
    <div class="bg-gray-50 border rounded-md p-4 grid sm:grid-cols-2 gap-4">
      <div>
        <label class="block text-sm text-gray-600">Job Order Title *</label>
        <input type="text" name="job_title"
               value="{{ old('job_title', isset($quotation) ? $quotation->project_title : '') }}"
               required
               class="w-full border mt-1 rounded-md px-3 py-2 text-sm focus:ring-blue-500 focus:border-blue-500">
      </div>
      <div>
        <label class="block text-sm text-gray-600">Date Started *</label>
        <input type="date" name="start_date"
               value="{{ old('start_date', now()->format('Y-m-d')) }}"
               required
               class="w-full border mt-1 rounded-md px-3 py-2 text-sm focus:ring-blue-500 focus:border-blue-500">
      </div>
      <div>
        <label class="block text-sm text-gray-600">Client *</label>
        <input type="text" name="client_name"
               value="{{ old('client_name', $quotation->client_name ?? '') }}"
               required
               class="w-full border mt-1 rounded-md px-3 py-2 text-sm focus:ring-blue-500 focus:border-blue-500">
      </div>
      <div>
        <label class="block text-sm text-gray-600">Service Location</label>
        <input type="text" name="service_location"
               value="{{ old('service_location', $quotation->client_address ?? '') }}"
               class="w-full border mt-1 rounded-md px-3 py-2 text-sm focus:ring-blue-500 focus:border-blue-500">
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
              <th class="px-4 py-2 text-right">–</th>
            </tr>
          </thead>
          <tbody id="itemRows" class="divide-y"></tbody>
        </table>
      </div>
      <div class="flex justify-end mt-3">
        <button type="button" id="addItemBtn" class="text-blue-600 hover:underline text-sm">+ Add Item</button>
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
          <span>Diagnostic Fee (10%)</span>
          <span id="tax">₱0.00</span>
        </div>
        <div class="flex justify-between text-sm font-semibold border-t mt-2 pt-2">
          <span>Grand Total</span>
          <span id="totalAmount">₱0.00</span>
        </div>
      </div>
    </div>

    <!-- Scope of Work (Reference Only) -->
    @if(isset($quotation->scope) && count($quotation->scope))
    <div class="mt-8">
        <h3 class="text-sm font-semibold text-gray-700 mb-2">Scope of Work (Reference)</h3>
        <div class="overflow-x-auto bg-gray-50 border rounded-md">
        <table class="w-full text-sm text-left">
            <thead class="bg-gray-100 text-gray-700 border-b">
            <tr>
                <th class="px-4 py-2 w-1/4">Scenario</th>
                <th class="px-4 py-2 w-1/4">Case</th>
                <th class="px-4 py-2 w-2/4">Description</th>
                <th class="px-4 py-2 w-1/6 text-center">Status / Remarks</th>
            </tr>
            </thead>
            <tbody>
            @foreach($quotation->scope as $scenario)
                @foreach($scenario['cases'] ?? [] as $case)
                <tr class="border-b">
                    <td class="px-4 py-2">{{ $scenario['scenario'] ?? '–' }}</td>
                    <td class="px-4 py-2">{{ $case['name'] ?? '–' }}</td>
                    <td class="px-4 py-2">{{ $case['description'] ?? '' }}</td>
                    <td class="px-4 py-2">
                    <input type="text" name="scope_status[]" placeholder="e.g. Done / Pending"
                            class="w-full border rounded-md px-2 py-1 text-xs text-center">
                    </td>
                </tr>
                @endforeach
            @endforeach
            </tbody>
        </table>
        </div>
    </div>
    @endif

    <!-- Scope of Waiver (Reference Only) -->
    @if(isset($quotation->waiver) && count($quotation->waiver))
    <div class="mt-8">
        <h3 class="text-sm font-semibold text-gray-700 mb-2">Scope of Waiver (Reference)</h3>
        <div class="bg-gray-50 border rounded-md p-4 text-sm text-gray-700 space-y-1">
        @foreach($quotation->waiver as $waiver)
            <p class="border-b pb-1"><strong>{{ $waiver['scenario'] ?? '' }}</strong> — {{ $waiver['cases'][0]['description'] ?? '' }}</p>
        @endforeach
        </div>
    </div>
    @endif


    {{-- TECHNICIAN NOTES --}}
    <div>
      <label class="block text-sm text-gray-700 font-semibold mb-2">Technician Notes / Progress</label>
      <textarea rows="4" name="technician_notes"
                placeholder="Record observations, parts replaced, diagnostics, etc."
                class="w-full border rounded-md px-3 py-2 text-sm focus:ring-blue-500 focus:border-blue-500">{{ old('technician_notes') }}</textarea>
    </div>

    {{-- TIMELINE --}}
    <div>
      <label class="block text-sm text-gray-700 font-semibold mb-2">Actual Timeline / Completion</label>
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

    {{-- ACCEPTANCE / COMPLETION --}}
    <div class="border-t pt-4">
      <h3 class="text-lg font-semibold text-gray-700 mb-3">Completion Confirmation</h3>
      <p class="text-sm text-gray-600 mb-4">By signing below, both client and technician confirm that all listed services/items were rendered as agreed.</p>

      <div class="grid md:grid-cols-2 gap-6">
        <div>
          <label class="block text-sm text-gray-700 font-medium mb-1">Customer Name</label>
          <input type="text" name="customer_name" 
                 value="{{ old('customer_name', $quotation->client_name ?? '') }}"
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
      <button type="submit" name="action" value="complete"
              class="px-4 py-2 bg-blue-600 text-white rounded-md text-sm hover:bg-blue-700">
        Mark as Completed
      </button>
    </div>

  </div>
</form>

<script>
// This script section reuses your existing item and total handling logic
// (no need to modify unless you want different tax or quantity behavior).
// Everything else remains identical to your quotation script block.

function formatCurrency(amount) {
  return '₱' + parseFloat(amount).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
}

function calculateTotals() {
  let subtotal = 0;
  document.querySelectorAll('#itemRows tr').forEach(row => {
    const qty = parseFloat(row.querySelector('input[name*="[quantity]"]')?.value || 0);
    const price = parseFloat(row.querySelector('input[name*="[unit_price]"]')?.value || 0);
    const total = qty * price;
    const totalCell = row.querySelector('.item-total');
    if (totalCell) totalCell.textContent = formatCurrency(total);
    subtotal += total;
  });
  const tax = subtotal * 0.10;
  document.getElementById('subtotal').textContent = formatCurrency(subtotal);
  document.getElementById('tax').textContent = formatCurrency(tax);
  document.getElementById('totalAmount').textContent = formatCurrency(subtotal + tax);
}

// initial add row
document.addEventListener('DOMContentLoaded', () => document.getElementById('addItemBtn').click());

document.getElementById('addItemBtn').addEventListener('click', e => {
  e.preventDefault();
  const tbody = document.getElementById('itemRows');
  const rowCount = tbody.rows.length;
  const row = document.createElement('tr');
  row.innerHTML = `
    <td class="px-4 py-3 font-medium text-gray-700">
      <input type="text" name="items[${rowCount}][name]" placeholder="Item ${rowCount + 1}" required class="w-full border rounded-md px-2 py-1 text-sm">
    </td>
    <td class="px-4 py-3">
      <textarea rows="2" name="items[${rowCount}][description]" placeholder="Description" class="w-full border rounded-md px-2 py-1 text-sm"></textarea>
    </td>
    <td class="px-4 py-3 w-20">
      <input type="number" name="items[${rowCount}][quantity]" value="1" min="1" step="1" required class="item-qty border rounded-md px-2 py-1 w-full text-center text-sm">
    </td>
    <td class="px-4 py-3 w-24">
      <input type="number" name="items[${rowCount}][unit_price]" value="0" min="0" step="0.01" required class="item-price border rounded-md px-2 py-1 w-full text-center text-sm">
    </td>
    <td class="px-4 py-3 text-gray-700 item-total">₱0.00</td>
    <td class="px-4 py-3 text-right">
      <button type="button" class="remove-row text-red-500 hover:text-red-700 text-sm">Remove</button>
    </td>`;
  tbody.appendChild(row);
  row.querySelector('.item-qty').addEventListener('input', calculateTotals);
  row.querySelector('.item-price').addEventListener('input', calculateTotals);
  calculateTotals();
});

document.getElementById('itemRows').addEventListener('click', e => {
  if (e.target.classList.contains('remove-row')) {
    e.preventDefault();
    e.target.closest('tr').remove();
    calculateTotals();
  }
});
</script>

@endsection
