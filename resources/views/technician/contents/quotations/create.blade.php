@extends('technician.layout.app')

@section('content')

<form action="{{ route('quotation.store') }}" method="POST" enctype="multipart/form-data" id="quotationForm">
  @csrf

  @if(isset($inquiry) && $inquiry)
    <input type="hidden" name="inquiry_id" value="{{ $inquiry->id }}">
  @endif

  <div class="bg-white rounded-xl shadow-sm border p-8 space-y-8">
    @if(isset($inquiry) && $inquiry)
      <div class="bg-blue-50 border border-blue-200 text-blue-800 px-4 py-3 rounded-lg">
        <div class="flex items-center gap-2">
          <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
          </svg>
          <div>
            <strong>Converting Inquiry:</strong> 
            INQ-{{ str_pad($inquiry->id, 5, '0', STR_PAD_LEFT) }} - {{ $inquiry->category }}
            @if($inquiry->contact_number)
              <span class="text-sm ml-2">| Contact: {{ $inquiry->contact_number }}</span>
            @endif
          </div>
        </div>
      </div>
    @endif

  <div class="bg-white rounded-xl shadow-sm border p-8 space-y-8">

    <!-- Display Validation Errors -->
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

    <!-- Header Section -->
    <div class="flex justify-between items-center border-b pb-3">
      <div>
        <h1 class="text-xl font-bold text-gray-800">Techne Fixer Computer and Laptop Repair Services</h1>
        <p class="text-sm text-gray-500">007 Manga Street Crossing Bayabas Davao City</p>
        <p class="text-sm text-gray-500">Contact No: 09662406825   TIN 618‑863‑736‑000000</p>
      </div>
      <img src="{{ asset('images/logo.png') }}" class="w-20 h-20 object-contain" alt="Company Logo">
    </div>

    <div>
      <label class="block text-sm text-gray-700 font-semibold mb-2">Client Logo / Face</label>

      <!-- Current preview -->
      <div id="clientLogoPreview" class="w-32 h-32 bg-gray-100 flex items-center justify-center text-gray-400 mb-4 rounded-full border overflow-hidden">
        <span>Preview</span>
      </div>

      <!-- File input -->
      <input type="file" name="client_logo" id="clientLogoInput" class="hidden" accept="image/*">

      <!-- Trigger button -->
      <button type="button"
              onclick="document.getElementById('clientLogoInput').click()"
              class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 focus:ring-2 ring-offset-1 ring-blue-200 transition-all text-sm">
        Add Photo
      </button>

      <p class="text-xs text-gray-500 mt-2">Upload client's brand logo or face photo (PNG, JPG).</p>
    </div>

    <!-- Project Information -->
    <div class="bg-gray-50 border rounded-md p-4 grid sm:grid-cols-2 gap-4">
      <div>
        <label class="block text-sm text-gray-600">Project Title *</label>
        <input type="text" name="project_title" 
              value="{{ old('project_title', isset($inquiry) ? $inquiry->device_details : '') }}" 
              required
              class="w-full border mt-1 rounded-md px-3 py-2 text-sm focus:ring-blue-500 focus:border-blue-500">
      </div>
      <div>
        <label class="block text-sm text-gray-600">Date Issued *</label>
        <input type="date" name="date_issued" 
              value="{{ old('date_issued', now()->format('Y-m-d')) }}" 
              required
              class="w-full border mt-1 rounded-md px-3 py-2 text-sm focus:ring-blue-500 focus:border-blue-500">
      </div>
      <div>
        <label class="block text-sm text-gray-600">Client Company Name *</label>
        <input type="text" name="client_name" 
              value="{{ old('client_name', isset($inquiry) ? $inquiry->name : '') }}" 
              required
              class="w-full border mt-1 rounded-md px-3 py-2 text-sm focus:ring-blue-500 focus:border-blue-500">
      </div>
      <div>
        <label class="block text-sm text-gray-600">Client Address</label>
        <input type="text" name="client_address" 
              value="{{ old('client_address', isset($inquiry) ? $inquiry->service_location : '') }}"
              class="w-full border mt-1 rounded-md px-3 py-2 text-sm focus:ring-blue-500 focus:border-blue-500">
      </div>
    </div>

    <!-- Objective -->
    <div>
      <label class="block text-sm text-gray-700 font-semibold mb-2">Objective</label>
      <textarea rows="3" name="objective"
                class="w-full border rounded-md px-3 py-2 text-sm focus:ring-blue-500 focus:border-blue-500">{{ old('objective', isset($inquiry) ? $inquiry->issue_description : '') }}</textarea>
    </div>


    <!-- Itemization Table -->
    <div>
      <h3 class="text-lg font-semibold text-gray-700 mb-3">Items and Services *</h3>

      <div class="overflow-x-auto">
        <table class="w-full text-left text-sm border rounded-lg">
          <thead class="bg-gray-100 text-gray-700">
            <tr>
              <th class="px-4 py-2">Item Name</th>
              <th class="px-4 py-2">Description</th>
              <th class="px-4 py-2">Qty</th>
              <th class="px-4 py-2">Unit Price (₱)</th>
              <th class="px-4 py-2">Total (₱)</th>
              <th class="px-4 py-2 text-right">–</th>
            </tr>
          </thead>

          <tbody id="itemRows" class="divide-y">
          </tbody>
        </table>
      </div>

      <div class="flex justify-end mt-3">
        <button type="button" id="addItemBtn" class="text-blue-600 hover:underline text-sm">+ Add Item</button>
      </div>
    </div>

    <!-- Totals Section -->
    <div class="flex justify-end">
      <div class="bg-gray-50 border rounded-lg p-4 w-80">
        <div class="flex justify-between text-sm py-1">
          <span>Subtotal (Labor)</span>
          <span id="subtotal">₱0.00</span>
        </div>
        <div class="flex justify-between text-sm py-1">
          <span>Tax (10%)</span>
          <span id="tax">₱0.00</span>
        </div>
        <div class="flex justify-between text-sm font-semibold border-t mt-2 pt-2">
          <span>Grand Total</span>
          <span id="totalAmount">₱0.00</span>
        </div>
      </div>
    </div>

    <div class="mt-8">
      <label class="block text-sm text-gray-700 font-semibold mb-2">
        Load Template *
      </label>

      <select id="templateSelect"
              name="template_id"
              class="border rounded-md px-3 py-2 w-full text-sm focus:ring-blue-500 focus:border-blue-500">
          <option value="">— Select Service Template —</option>
          @foreach($templates as $template)
              <option value="{{ $template->id }}">{{ $template->name }} ({{ $template->category }})</option>
          @endforeach
      </select>

      <p class="text-xs text-gray-500 mt-1">Selecting a template will auto-fill scopes, waivers, and deliverables.</p>
    </div>


    <!-- Scope of Work -->
    <div>
      <h3 class="block text-sm text-gray-700 font-semibold mb-2">Scope of Work</h3>

      <div class="overflow-x-auto border rounded-lg bg-gray-50">
        <table class="w-full text-sm text-left border-collapse">
          <thead class="bg-gray-100 text-gray-700 border-b">
            <tr>
              <th class="px-4 py-2 w-1/4">Task Scenario</th>
              <th class="px-4 py-2 w-1/4">Task Case</th>
              <th class="px-4 py-2 w-2/4">Task Description</th>
              <th class="px-4 py-2 text-right">–</th>
            </tr>
          </thead>
          <tbody id="scopeScenarioRows" class="divide-y">
          </tbody>
        </table>
      </div>

      <div class="flex justify-end mt-3">
        <button type="button" id="addScenarioBtn" class="text-blue-600 hover:underline text-sm">+ Add Scenario</button>
      </div>
    </div>

    <!-- Scope of Waiver -->
    <div>
      <h3 class="block text-sm text-gray-700 font-semibold mb-2">Scope of Waiver</h3>

      <div class="overflow-x-auto border rounded-lg bg-gray-50">
        <table class="w-full text-sm text-left border-collapse">
          <thead class="bg-gray-100 text-gray-700 border-b">
            <tr>
              <th class="px-4 py-2 w-1/4">Waiver Scenario</th>
              <th class="px-4 py-2 w-1/4">Waiver Case</th>
              <th class="px-4 py-2 w-2/4">Description / Exclusion Detail</th>
              <th class="px-4 py-2 text-right">–</th>
            </tr>
          </thead>
          <tbody id="waiverScenarioRows" class="divide-y">
          </tbody>
        </table>
      </div>

      <div class="flex justify-end mt-3">
        <button type="button" id="addWaiverScenarioBtn" class="text-blue-600 hover:underline text-sm">+ Add Scenario</button>
      </div>
    </div>

    <!-- Expected Deliverables -->
    <div>
      <h3 class="block text-sm text-gray-700 font-semibold mb-2">Expected Deliverables</h3>

      <div class="overflow-x-auto bg-gray-50 border rounded-lg">
        <table class="w-full text-sm text-left border-collapse">
          <thead class="bg-gray-100 text-gray-700 border-b">
            <tr>
              <th class="px-4 py-2">#</th>
              <th class="px-4 py-2">Deliverable Detail</th>
              <th class="px-4 py-2 text-right">–</th>
            </tr>
          </thead>
          <tbody id="deliverableRows" class="divide-y"></tbody>
        </table>
      </div>

      <div class="flex justify-end mt-3">
        <button type="button" id="addDeliverableBtn" class="text-blue-600 hover:underline text-sm">+ Add Deliverable</button>
      </div>
    </div>

    <!-- Timeline -->
    <div>
      <label class="block text-sm text-gray-700 font-semibold mb-2">Timeline / Completion Schedule</label>

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

    <!-- Terms and Conditions -->
    <div>
      <label class="block text-sm text-gray-700 font-semibold mb-2">Terms and Conditions</label>
      <textarea rows="5" name="terms_conditions"
                placeholder="Detail payment terms, warranty statements, confidentiality clauses, etc."
                class="w-full border rounded-md px-3 py-2 text-sm focus:ring-blue-500 focus:border-blue-500">{{ old('terms_conditions') }}</textarea>
    </div>

    <!-- Acceptance Section -->
    <div class="border-t pt-4">
      <h3 class="text-lg font-semibold text-gray-700 mb-3">Acceptance of Terms</h3>
      <p class="text-sm text-gray-600 mb-4">By signing below, the Customer acknowledges and agrees to the terms of this quotation and service agreement.</p>

      <div class="grid md:grid-cols-2 gap-6">
        <div>
          <label class="block text-sm text-gray-700 font-medium mb-1">Customer Name</label>
          <input type="text" name="customer_name" 
                placeholder="Client / Authorized Representative" 
                value="{{ old('customer_name', isset($inquiry) ? $inquiry->name : '') }}"
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
          <label class="block text-sm text-gray-700 font-medium mb-1">Service Provider Representative</label>
          <input type="text" name="provider_name" 
                placeholder="Techne Fixer Representative" 
                value="{{ old('provider_name') }}"
                class="w-full border rounded-md px-3 py-2 text-sm mb-2 focus:ring-blue-500 focus:border-blue-500">
          <div class="flex justify-between text-sm gap-4">
            <input type="text" name="provider_signature" 
                  placeholder="Signature / eSign" 
                  value="{{ old('provider_signature') }}" 
                  class="border-b flex-1">
            <input type="date" name="provider_date" 
                  value="{{ old('provider_date', now()->format('Y-m-d')) }}" 
                  class="border rounded-md px-2 py-1 w-36 text-sm">
          </div>
        </div>
      </div>
    </div>

    <!-- Action Buttons -->
    <div class="flex justify-end space-x-3 border-t pt-4">
      <a href="{{ route('technician.quotation') }}">
        <button type="button" class="px-4 py-2 border rounded-md text-gray-600 text-sm hover:bg-gray-100 active:scale-95 transition-transform duration-100 shadow-sm hover:shadow-md">
          Cancel
        </button>
      </a>
      <button type="submit" name="action" value="draft" class="px-4 py-2 bg-green-600 text-white rounded-md text-sm hover:bg-green-700">
        Save Draft
      </button>
      <button type="submit" name="action" value="submit_manager" class="px-4 py-2 bg-blue-600 text-white rounded-md text-sm hover:bg-blue-700">
        Send To Manager
      </button>
    </div>

  </div>
</form>

<script>
// ============================================
// UTILITY FUNCTIONS
// ============================================

function formatCurrency(amount) {
  return '₱' + parseFloat(amount).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
}

function reindexItems() {
  const rows = document.querySelectorAll('#itemRows tr');
  rows.forEach((row, index) => {
    row.querySelectorAll('input, textarea').forEach(field => {
      const name = field.getAttribute('name');
      if (name) {
        field.setAttribute('name', name.replace(/\[\d+\]/, `[${index}]`));
      }
    });
  });
}

function reindexScopes() {
  const scenarios = document.querySelectorAll('#scopeScenarioRows tr.scenario-row');
  scenarios.forEach((scenario, sIndex) => {
    scenario.querySelector('input[name*="[scenario]"]')?.setAttribute('name', `scope[${sIndex}][scenario]`);
    
    const cases = scenario.querySelectorAll('.case-table tbody tr');
    cases.forEach((caseRow, cIndex) => {
      caseRow.querySelectorAll('input, textarea').forEach(field => {
        const name = field.getAttribute('name');
        if (name) {
          if (name.includes('[name]')) {
            field.setAttribute('name', `scope[${sIndex}][cases][${cIndex}][name]`);
          } else if (name.includes('[description]')) {
            field.setAttribute('name', `scope[${sIndex}][cases][${cIndex}][description]`);
          }
        }
      });
    });
    
    scenario.querySelector('.add-case')?.setAttribute('data-scenario', sIndex);
  });
}

function reindexWaivers() {
  const scenarios = document.querySelectorAll('#waiverScenarioRows tr.waiver-scenario-row');
  scenarios.forEach((scenario, sIndex) => {
    scenario.querySelector('input[name*="[scenario]"]')?.setAttribute('name', `waiver[${sIndex}][scenario]`);
    
    const cases = scenario.querySelectorAll('.waiver-case-table tbody tr');
    cases.forEach((caseRow, cIndex) => {
      caseRow.querySelectorAll('input, textarea').forEach(field => {
        const name = field.getAttribute('name');
        if (name) {
          if (name.includes('[name]')) {
            field.setAttribute('name', `waiver[${sIndex}][cases][${cIndex}][name]`);
          } else if (name.includes('[description]')) {
            field.setAttribute('name', `waiver[${sIndex}][cases][${cIndex}][description]`);
          }
        }
      });
    });
    
    scenario.querySelector('.add-waiver-case')?.setAttribute('data-scenario', sIndex);
  });
}

function reindexDeliverables() {
  const rows = document.querySelectorAll('#deliverableRows tr');
  rows.forEach((row, index) => {
    row.querySelector('td:first-child').textContent = index + 1;
    row.querySelector('input')?.setAttribute('name', `deliverables[${index}][detail]`);
  });
}

// ============================================
// CALCULATE TOTALS
// ============================================

function calculateTotals() {
  let subtotal = 0;
  
  document.querySelectorAll('#itemRows tr').forEach(row => {
    const qty = parseFloat(row.querySelector('input[name*="[quantity]"]')?.value || 0);
    const price = parseFloat(row.querySelector('input[name*="[unit_price]"]')?.value || 0);
    const total = qty * price;
    
    const totalCell = row.querySelector('.item-total');
    if (totalCell) {
      totalCell.textContent = formatCurrency(total);
    }
    
    subtotal += total;
  });
  
  const tax = subtotal * 0.10;
  const totalAmount = subtotal + tax;
  
  document.getElementById('subtotal').textContent = formatCurrency(subtotal);
  document.getElementById('tax').textContent = formatCurrency(tax);
  document.getElementById('totalAmount').textContent = formatCurrency(totalAmount);
}

// ============================================
// ITEMS SECTION
// ============================================

document.getElementById('addItemBtn').addEventListener('click', function(e) {
  e.preventDefault();
  const tbody = document.getElementById('itemRows');
  const rowCount = tbody.rows.length;

  const newRow = document.createElement('tr');
  newRow.innerHTML = `
    <td class="px-4 py-3 font-medium text-gray-700">
      <input type="text" name="items[${rowCount}][name]" placeholder="Item ${rowCount + 1}" required
             class="w-full border rounded-md px-2 py-1 text-sm">
    </td>
    <td class="px-4 py-3">
      <textarea rows="2" name="items[${rowCount}][description]" placeholder="Description"
                class="w-full border rounded-md px-2 py-1 text-sm"></textarea>
    </td>
    <td class="px-4 py-3 w-20">
      <input type="number" name="items[${rowCount}][quantity]" value="1" min="1" step="1" required
             class="item-qty border rounded-md px-2 py-1 w-full text-center text-sm">
    </td>
    <td class="px-4 py-3 w-24">
      <input type="number" name="items[${rowCount}][unit_price]" value="0" min="0" step="0.01" required
             class="item-price border rounded-md px-2 py-1 w-full text-center text-sm">
    </td>
    <td class="px-4 py-3 text-gray-700 item-total">₱0.00</td>
    <td class="px-4 py-3 text-right">
      <button type="button" class="remove-row text-red-500 hover:text-red-700 text-sm">Remove</button>
    </td>
  `;
  tbody.appendChild(newRow);
  
  // Add event listeners for calculation
  newRow.querySelector('.item-qty').addEventListener('input', calculateTotals);
  newRow.querySelector('.item-price').addEventListener('input', calculateTotals);
  
  calculateTotals();
});

document.getElementById('itemRows').addEventListener('click', function(e) {
  if (e.target.classList.contains('remove-row')) {
    e.preventDefault();
    e.target.closest('tr').remove();
    reindexItems();
    calculateTotals();
  }
});

// ============================================
// SCOPE OF WORK SECTION
// ============================================

document.getElementById('addScenarioBtn').addEventListener('click', function(e) {
  e.preventDefault();
  const tbody = document.getElementById('scopeScenarioRows');
  const scenarioCount = tbody.querySelectorAll('tr.scenario-row').length;

  const scenarioRow = document.createElement('tr');
  scenarioRow.classList.add('scenario-row');
  scenarioRow.innerHTML = `
    <td class="px-4 py-3 font-semibold text-gray-800">
      <input type="text" name="scope[${scenarioCount}][scenario]" placeholder="Scenario ${scenarioCount + 1}"
             class="w-full border rounded-md px-2 py-1 text-sm">
    </td>
    <td colspan="2" class="px-4 py-3">
      <table class="w-full text-sm border bg-white rounded-md case-table mb-2">
        <tbody></tbody>
      </table>
      <button type="button" class="add-case text-blue-600 hover:underline text-xs" data-scenario="${scenarioCount}">+ Add Case</button>
    </td>
    <td class="px-4 py-3 text-right">
      <button type="button" class="remove-scenario text-red-500 hover:text-red-700 text-sm">Remove</button>
    </td>
  `;
  tbody.appendChild(scenarioRow);
});

document.getElementById('scopeScenarioRows').addEventListener('click', function(e) {
  if (e.target.classList.contains('add-case')) {
    e.preventDefault();
    const scenarioIndex = e.target.dataset.scenario;
    const caseTable = e.target.previousElementSibling.querySelector('tbody');
    const caseCount = caseTable.querySelectorAll('tr').length;

    const caseRow = document.createElement('tr');
    caseRow.classList.add('case-row');
    caseRow.innerHTML = `
      <td class="px-4 py-2 w-1/4">
        <input type="text" name="scope[${scenarioIndex}][cases][${caseCount}][name]" placeholder="Case ${caseCount + 1}"
              class="w-full border rounded-md px-2 py-1 text-sm">
      </td>
      <td class="px-4 py-2">
        <textarea rows="2" name="scope[${scenarioIndex}][cases][${caseCount}][description]" placeholder="Description"
                  class="w-full border rounded-md px-2 py-1 text-sm"></textarea>
      </td>
      <td class="px-4 py-2 text-right">
        <button type="button" class="remove-case text-red-500 hover:text-red-700 text-xs">Remove</button>
      </td>
    `;
    caseTable.appendChild(caseRow);
  }

  if (e.target.classList.contains('remove-scenario')) {
    e.preventDefault();
    e.target.closest('tr').remove();
    reindexScopes();
  }

  if (e.target.classList.contains('remove-case')) {
    e.preventDefault();
    const caseRow = e.target.closest('tr');
    caseRow.remove();
    reindexScopes();
  }
});

// ============================================
// SCOPE OF WAIVER SECTION
// ============================================

document.getElementById('addWaiverScenarioBtn').addEventListener('click', function(e) {
  e.preventDefault();
  const tbody = document.getElementById('waiverScenarioRows');
  const scenarioCount = tbody.querySelectorAll('tr.waiver-scenario-row').length;

  const scenarioRow = document.createElement('tr');
  scenarioRow.classList.add('waiver-scenario-row');
  scenarioRow.innerHTML = `
    <td class="px-4 py-3 font-semibold text-gray-800">
      <input type="text" name="waiver[${scenarioCount}][scenario]" placeholder="Scenario ${scenarioCount + 1}"
             class="w-full border rounded-md px-2 py-1 text-sm">
    </td>
    <td colspan="2" class="px-4 py-3">
      <table class="w-full text-sm border bg-white rounded-md waiver-case-table mb-2">
        <tbody></tbody>
      </table>
      <button type="button" class="add-waiver-case text-blue-600 hover:underline text-xs" data-scenario="${scenarioCount}">+ Add Case</button>
    </td>
    <td class="px-4 py-3 text-right">
      <button type="button" class="remove-waiver-scenario text-red-500 hover:text-red-700 text-sm">Remove</button>
    </td>
  `;
  tbody.appendChild(scenarioRow);
});

document.getElementById('waiverScenarioRows').addEventListener('click', function(e) {
  if (e.target.classList.contains('add-waiver-case')) {
    e.preventDefault();
    const scenarioIndex = e.target.dataset.scenario;
    const caseTable = e.target.previousElementSibling.querySelector('tbody');
    const caseCount = caseTable.querySelectorAll('tr').length;

    const caseRow = document.createElement('tr');
    caseRow.classList.add('waiver-case-row');
    caseRow.innerHTML = `
      <td class="px-4 py-2 w-1/4">
        <input type="text" name="waiver[${scenarioIndex}][cases][${caseCount}][name]" placeholder="Case ${caseCount + 1}"
              class="w-full border rounded-md px-2 py-1 text-sm">
      </td>
      <td class="px-4 py-2">
        <textarea rows="2" name="waiver[${scenarioIndex}][cases][${caseCount}][description]" placeholder="Description"
                  class="w-full border rounded-md px-2 py-1 text-sm"></textarea>
      </td>
      <td class="px-4 py-2 text-right">
        <button type="button" class="remove-waiver-case text-red-500 hover:text-red-700 text-xs">Remove</button>
      </td>
    `;

    caseTable.appendChild(caseRow);
  }

  if (e.target.classList.contains('remove-waiver-scenario')) {
    e.preventDefault();
    e.target.closest('tr').remove();
    reindexWaivers();
  }

  if (e.target.classList.contains('remove-waiver-case')) {
    e.preventDefault();
    e.target.closest('tr').remove();
    reindexWaivers();
  }
});

// ============================================
// DELIVERABLES SECTION
// ============================================

document.getElementById('addDeliverableBtn').addEventListener('click', function(e) {
  e.preventDefault();
  const tbody = document.getElementById('deliverableRows');
  const rowCount = tbody.rows.length;

  const newRow = document.createElement('tr');
  newRow.innerHTML = `
    <td class="px-4 py-3 text-gray-600">${rowCount + 1}</td>
    <td class="px-4 py-3">
      <input type="text" name="deliverables[${rowCount}][detail]" placeholder="Deliverable detail"
             class="w-full border rounded-md px-2 py-1 text-sm">
    </td>
    <td class="px-4 py-3 text-right">
      <button type="button" class="remove-deliverable text-red-500 hover:text-red-700 text-sm">Remove</button>
    </td>
  `;
  tbody.appendChild(newRow);
});

document.getElementById('deliverableRows').addEventListener('click', function(e) {
  if (e.target.classList.contains('remove-deliverable')) {
    e.preventDefault();
    e.target.closest('tr').remove();
    reindexDeliverables();
  }
});

// ============================================
// TIMELINE PREVIEW
// ============================================

const minDays = document.getElementById('minDays');
const maxDays = document.getElementById('maxDays');
const preview = document.getElementById('timelinePreview');

function updatePreview() {
  const min = minDays.value;
  const max = maxDays.value;
  if (min && max) {
    preview.textContent = `Estimated completion: ${min}-${max} days`;
  } else if (min) {
    preview.textContent = `Estimated completion: ${min} days`;
  } else {
    preview.textContent = '';
  }
}

minDays.addEventListener('input', updatePreview);
maxDays.addEventListener('input', updatePreview);

// ============================================
// CLIENT LOGO PREVIEW
// ============================================

document.getElementById('clientLogoInput').addEventListener('change', function(e) {
  const file = e.target.files[0];
  if (file) {
    const reader = new FileReader();
    reader.onload = function(event) {
      const preview = document.getElementById('clientLogoPreview');
      preview.innerHTML = `<img src="${event.target.result}" alt="Preview" class="w-full h-full object-cover">`;
    };
    reader.readAsDataURL(file);
  }
});

// ============================================
// FORM VALIDATION & SUBMISSION
// ============================================

document.getElementById('quotationForm').addEventListener('submit', function(e) {
  const itemRows = document.querySelectorAll('#itemRows tr');
  
  if (itemRows.length === 0) {
    e.preventDefault();
    alert('Please add at least one item to the quotation.');
    return false;
  }
});

// ============================================
// INITIALIZE FORM WITH ONE ITEM ROW
// ============================================

document.addEventListener('DOMContentLoaded', function() {
  // Add one default item row
  document.getElementById('addItemBtn').click();
  
  // Set default date to today
  const today = new Date().toISOString().split('T')[0];
  const dateInput = document.querySelector('input[name="date_issued"]');
  if (!dateInput.value) {
    dateInput.value = today;
  }
});

document.getElementById('templateSelect').addEventListener('change', async function() {
  const templateId = this.value;
  if (!templateId) return;

  try {
    const response = await fetch(`/technician/quotation/template/${templateId}`);
    const template = await response.json();

    // Clear previous table rows
    document.getElementById('scopeScenarioRows').innerHTML = '';
    document.getElementById('waiverScenarioRows').innerHTML = '';
    document.getElementById('deliverableRows').innerHTML = '';

    // ✅ Populate Scopes
    template.scopes.forEach((scope, sIndex) => {
      const scenarioRow = document.createElement('tr');
      scenarioRow.classList.add('scenario-row');
      scenarioRow.innerHTML = `
        <td class="px-4 py-3 font-semibold text-gray-800">
          <input type="text" name="scope[${sIndex}][scenario]" value="${scope.scenario_name}" class="w-full border rounded-md px-2 py-1 text-sm">
        </td>
        <td colspan="2" class="px-4 py-3">
          <table class="w-full text-sm border bg-white rounded-md case-table mb-2">
              <tbody></tbody>
          </table>
          <button type="button" class="add-case text-blue-600 hover:underline text-xs" data-scenario="${sIndex}">+ Add Case</button>
        </td>
        <td class="px-4 py-3 text-right"><button type="button" class="remove-scenario text-red-500 hover:text-red-700 text-sm">Remove</button></td>
      `;
      document.getElementById('scopeScenarioRows').appendChild(scenarioRow);

      const caseTableBody = scenarioRow.querySelector('tbody');
      scope.cases.forEach((caseItem, cIndex) => {
        const tr = document.createElement('tr');
        tr.classList.add('case-row');
        tr.innerHTML = `
          <td class="px-4 py-2 w-1/4">
            <input type="text" name="scope[${sIndex}][cases][${cIndex}][name]" 
                  value="${caseItem.case_title}" class="w-full border rounded-md px-2 py-1 text-sm">
          </td>
          <td class="px-4 py-2">
            <textarea rows="2" name="scope[${sIndex}][cases][${cIndex}][description]" 
                      class="w-full border rounded-md px-2 py-1 text-sm">${caseItem.case_description}</textarea>
          </td>
          <td class="px-4 py-2 text-right">
            <button type="button" class="remove-case text-red-500 hover:text-red-700 text-xs">Remove</button>
          </td>
        `;
        caseTableBody.appendChild(tr);
      });
    });

    // ✅ Populate Waivers
    template.waivers.forEach((waiver, wIndex) => {
      const waiverRow = document.createElement('tr');
      waiverRow.classList.add('waiver-scenario-row');
      waiverRow.innerHTML = `
        <td class="px-4 py-3 font-semibold text-gray-800">
          <input type="text" name="waiver[${wIndex}][scenario]" value="${waiver.waiver_title}" class="w-full border rounded-md px-2 py-1 text-sm">
        </td>
        <td colspan="2" class="px-4 py-3">
          <table class="w-full text-sm border bg-white rounded-md waiver-case-table mb-2">
              <tbody></tbody>
          </table>
          <button type="button" class="add-waiver-case text-blue-600 hover:underline text-xs" data-scenario="${wIndex}">+ Add Case</button>
        </td>
        <td class="px-4 py-3 text-right"><button type="button" class="remove-waiver-scenario text-red-500 hover:text-red-700 text-sm">Remove</button></td>
      `;
      document.getElementById('waiverScenarioRows').appendChild(waiverRow);

      const waiverBody = waiverRow.querySelector('tbody');
      waiver.cases.forEach((caseItem, cIndex) => {
        const tr = document.createElement('tr');
        tr.classList.add('waiver-case-row');
        tr.innerHTML = `
          <td class="px-4 py-2 w-1/4">
            <input type="text" name="waiver[${wIndex}][cases][${cIndex}][name]" 
                  value="${caseItem.case_title}" class="w-full border rounded-md px-2 py-1 text-sm">
          </td>
          <td class="px-4 py-2">
            <textarea rows="2" name="waiver[${wIndex}][cases][${cIndex}][description]" 
                      class="w-full border rounded-md px-2 py-1 text-sm">${caseItem.description}</textarea>
          </td>
          <td class="px-4 py-2 text-right">
            <button type="button" class="remove-waiver-case text-red-500 hover:text-red-700 text-xs">Remove</button>
          </td>
        `;
        waiverBody.appendChild(tr);
      });

    });

    // ✅ Populate Deliverables
    template.deliverables.forEach((del, dIndex) => {
      const deliverableRow = document.createElement('tr');
      deliverableRow.innerHTML = `
        <td class="px-4 py-3 text-gray-600">${dIndex + 1}</td>
        <td class="px-4 py-3">
          <input type="text" name="deliverables[${dIndex}][detail]" value="${del.deliverable_detail}" class="w-full border rounded-md px-2 py-1 text-sm">
        </td>
        <td class="px-4 py-3 text-right">
          <button type="button" class="remove-deliverable text-red-500 hover:text-red-700 text-sm">Remove</button>
        </td>
      `;
      document.getElementById('deliverableRows').appendChild(deliverableRow);
    });

  } catch (error) {
    console.error(error);
    alert('Error loading template.');
  }
});

</script>

@endsection