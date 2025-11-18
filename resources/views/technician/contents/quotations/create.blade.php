@extends('technician.layout.app')

@section('content')

<div class="bg-white rounded-xl shadow-sm border p-8 space-y-8">

  <!-- Header Section -->
  <div class="flex justify-between items-center border-b pb-3">
    <div>
      <h1 class="text-xl font-bold text-gray-800">Techne Fixer Computer and Laptop Repair Services</h1>
      <p class="text-sm text-gray-500">007 Manga Street Crossing Bayabas Davao City</p>
      <p class="text-sm text-gray-500">Contact No: 09662406825   TIN 618‑863‑736‑000000</p>
    </div>
    <img src="{{ asset('images/logo.png') }}" class="w-20 h-20 object-contain" alt="Company Logo">
  </div>

  <!-- Project Information -->
  <div class="bg-gray-50 border rounded-md p-4 grid sm:grid-cols-2 gap-4">
    <div>
      <label class="block text-sm text-gray-600">Project Title</label>
      <input type="text"
             class="w-full border mt-1 rounded-md px-3 py-2 text-sm focus:ring-blue-500 focus:border-blue-500">
    </div>
    <div>
      <label class="block text-sm text-gray-600">Date Issued</label>
      <input type="date" class="w-full border mt-1 rounded-md px-3 py-2 text-sm focus:ring-blue-500 focus:border-blue-500">
    </div>
    <div>
      <label class="block text-sm text-gray-600">Client Company Name</label>
      <input type="text"
             class="w-full border mt-1 rounded-md px-3 py-2 text-sm focus:ring-blue-500 focus:border-blue-500">
    </div>
    <div>
      <label class="block text-sm text-gray-600">Client Address</label>
      <input type="text"
             class="w-full border mt-1 rounded-md px-3 py-2 text-sm focus:ring-blue-500 focus:border-blue-500">
    </div>
  </div>

  <!-- Objective -->
  <div>
    <label class="block text-sm text-gray-700 font-semibold mb-2">Objective</label>
    <textarea rows="3"
              class="w-full border rounded-md px-3 py-2 text-sm focus:ring-blue-500 focus:border-blue-500"></textarea>
  </div>

  <!-- Itemization Table -->
  <div>
    <h3 class="text-lg font-semibold text-gray-700 mb-3">Items and Services</h3>

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

        <tbody id="itemRows" class="divide-y">
        </tbody>
      </table>
    </div>

    <div class="flex justify-end mt-3">
      <button id="addItemBtn" class="text-blue-600 hover:underline text-sm">+ Add Item</button>
    </div>
  </div>

  <!-- Totals Section -->
  <div class="flex justify-end">
    <div class="bg-gray-50 border rounded-lg p-4 w-80">
      <div class="flex justify-between text-sm py-1">
        <span>Subtotal</span>
        <span>₱17,600.00</span>
      </div>
      <div class="flex justify-between text-sm py-1">
        <span>Tax (10%)</span>
        <span>₱1,760.00</span>
      </div>
      <div class="flex justify-between text-sm font-semibold border-t mt-2 pt-2">
        <span>Total Amount</span>
        <span>₱19,360.00</span>
      </div>
    </div>
  </div>

  <!-- Scope of Work: Nested Table Structure -->
<div>
    <h3 class="block text-sm text-gray-700 font-semibold mb-2">Scope of Work</h3>

    <div class="overflow-x-auto border rounded-lg bg-gray-50">
        <table class="w-full text-sm text-left border-collapse">
            <thead class="bg-gray-100 text-gray-700 border-b">
                <tr>
                    <th class="px-4 py-2 w-1/4">Task Scenario</th>
                    <th class="px-4 py-2 w-1/4">Task Case</th>
                    <th class="px-4 py-2 w-2/4">Task Description</th>
                    <th class="px-4 py-2 text-right">–</th>
                </tr>
            </thead>
            <tbody id="scopeScenarioRows" class="divide-y">
                <!-- Dynamic rows will appear here -->
            </tbody>
        </table>
    </div>

    <div class="flex justify-end mt-3">
        <button id="addScenarioBtn" class="text-blue-600 hover:underline text-sm">+ Add Scenario</button>
    </div>
</div>

  <!-- Scope of Waiver -->
  <div>
      <h3 class="block text-sm text-gray-700 font-semibold mb-2">Scope of Waiver</h3>

      <div class="overflow-x-auto border rounded-lg bg-gray-50">
          <table class="w-full text-sm text-left border-collapse">
              <thead class="bg-gray-100 text-gray-700 border-b">
                  <tr>
                      <th class="px-4 py-2 w-1/4">Waiver Scenario</th>
                      <th class="px-4 py-2 w-1/4">Waiver Case</th>
                      <th class="px-4 py-2 w-2/4">Description / Exclusion Detail</th>
                      <th class="px-4 py-2 text-right">–</th>
                  </tr>
              </thead>
              <tbody id="waiverScenarioRows" class="divide-y">
                  <!-- dynamic scenarios will appear here -->
              </tbody>
          </table>
      </div>

      <div class="flex justify-end mt-3">
          <button id="addWaiverScenarioBtn" class="text-blue-600 hover:underline text-sm">+ Add Scenario</button>
      </div>
  </div>

  <!-- Expected Deliverables -->
  <div>
      <h3 class="block text-sm text-gray-700 font-semibold mb-2">Expected Deliverables</h3>

      <div class="overflow-x-auto bg-gray-50 border rounded-lg">
          <table class="w-full text-sm text-left border-collapse">
              <thead class="bg-gray-100 text-gray-700 border-b">
                  <tr>
                      <th class="px-4 py-2">#</th>
                      <th class="px-4 py-2">Deliverable Detail</th>
                      <th class="px-4 py-2 text-right">–</th>
                  </tr>
              </thead>
              <tbody id="deliverableRows" class="divide-y"></tbody>
          </table>
      </div>

      <div class="flex justify-end mt-3">
          <button id="addDeliverableBtn" class="text-blue-600 hover:underline text-sm">+ Add Deliverable</button>
      </div>
  </div>

  <!-- Timeline -->
  <!-- Timeline / Completion Schedule -->
<div>
    <label class="block text-sm text-gray-700 font-semibold mb-2">Timeline / Completion Schedule</label>

    <div class="flex items-center gap-2">
        <input id="minDays"
               type="number"
               min="1"
               placeholder="Min"
               class="w-24 border rounded-md px-3 py-2 text-sm focus:ring-blue-500 focus:border-blue-500">

        <span class="text-gray-500">to</span>

        <input id="maxDays"
               type="number"
               min="1"
               placeholder="Max"
               class="w-24 border rounded-md px-3 py-2 text-sm focus:ring-blue-500 focus:border-blue-500">

        <span class="text-gray-700 text-sm">days</span>
    </div>

    <p id="timelinePreview" class="text-xs text-gray-500 mt-2 italic"></p>
</div>

  <!-- Terms and Conditions -->
  <div>
    <label class="block text-sm text-gray-700 font-semibold mb-2">Terms and Conditions</label>
    <textarea rows="5"
              placeholder="Detail payment terms, warranty statements, confidentiality clauses, etc."
              class="w-full border rounded-md px-3 py-2 text-sm focus:ring-blue-500 focus:border-blue-500"></textarea>
  </div>

  <!-- Transfer this to Manager -->
  <!-- Acceptance Section -->
  <div class="border-t pt-4">
    <h3 class="text-lg font-semibold text-gray-700 mb-3">Acceptance of Terms</h3>
    <p class="text-sm text-gray-600 mb-4">By signing below, the Customer acknowledges and agrees to the terms of this quotation and service agreement.</p>

    <div class="grid md:grid-cols-2 gap-6">
      <div>
        <label class="block text-sm text-gray-700 font-medium mb-1">Customer Name</label>
        <input type="text" placeholder="Client / Authorized Representative"
               class="w-full border rounded-md px-3 py-2 text-sm mb-2 focus:ring-blue-500 focus:border-blue-500">
        <div class="flex justify-between text-sm">
          <input type="text" placeholder="Signature / eSign" class="border-b flex-1 mr-4">
          <input type="date" class="border rounded-md px-2 py-1 w-36 text-sm">
        </div>
      </div>

      <div>
        <label class="block text-sm text-gray-700 font-medium mb-1">Service Provider Representative</label>
        <input type="text" placeholder="Techne Fixer Representative"
               class="w-full border rounded-md px-3 py-2 text-sm mb-2 focus:ring-blue-500 focus:border-blue-500">
        <div class="flex justify-between text-sm">
          <input type="text" placeholder="Signature / eSign" class="border-b flex-1 mr-4">
          <input type="date" class="border rounded-md px-2 py-1 w-36 text-sm">
        </div>
      </div>
    </div>
  </div>

  <!-- Action Buttons -->
  <div class="flex justify-end space-x-3 border-t pt-4">
    <a href="{{ route('technician.quotation') }}"><button class="px-4 py-2 border rounded-md text-gray-600 text-sm hover:bg-gray-100 active:scale-95 active:bg-blue-800 transition-transform duration-100 shadow-sm hover:shadow-md">Cancel</button></a>
    <button class="px-4 py-2 bg-green-600 text-white rounded-md text-sm hover:bg-green-700">Save Draft</button>
    <a href="{{ route('quotation.pdf') }}" target="_blank">
      <button type="button"
              class="px-4 py-2 bg-blue-600 text-white rounded-md text-sm hover:bg-blue-700">
          Generate PDF
      </button>
    </a>
  </div>

</div>

<script>
  document.getElementById('addItemBtn').addEventListener('click', function(e) {
    e.preventDefault();
    const tbody = document.getElementById('itemRows');
    const rowCount = tbody.rows.length + 1;

    // Build a new row string
    const newRow = document.createElement('tr');
    newRow.innerHTML = `
      <td class="px-4 py-3 font-medium text-gray-700">
        <input type="text" placeholder="Item ${rowCount}" class="w-full border rounded-md px-2 py-1 text-sm">
      </td>
      <td class="px-4 py-3">
        <textarea rows="3" placeholder="Description ${rowCount}" class="w-full border rounded-md px-2 py-1 text-sm"></textarea>
      </td>
      <td class="px-4 py-3 w-20">
        <input type="number" value="1" class="border rounded-md px-2 py-1 w-full text-center text-sm">
      </td>
      <td class="px-4 py-3 w-24">
        <input type="number" value="0" class="border rounded-md px-2 py-1 w-full text-center text-sm">
      </td>
      <td class="px-4 py-3 text-gray-700">₱0</td>
      <td class="px-4 py-3 text-right">
        <button class="remove-row text-red-500 hover:text-red-700 text-sm">Remove</button>
      </td>
    `;
    tbody.appendChild(newRow);
  });

  // remove item rows
  document.getElementById('itemRows').addEventListener('click', function(e) {
    if (e.target.classList.contains('remove-row')) {
      e.preventDefault();
      e.target.closest('tr').remove();
    }
  });
</script>

<script>
document.getElementById('addScenarioBtn').addEventListener('click', function(e) {
    e.preventDefault();
    const tbody = document.getElementById('scopeScenarioRows');
    const scenarioCount = tbody.querySelectorAll('tr.scenario-row').length + 1;

    const scenarioRow = document.createElement('tr');
    scenarioRow.classList.add('scenario-row');
    scenarioRow.innerHTML = `
        <td class="px-4 py-3 font-semibold text-gray-800">
            <input type="text" placeholder="Scenario ${scenarioCount}" class="w-full border rounded-md px-2 py-1 text-sm">
        </td>
        <td colspan="2" class="px-4 py-3">
            <table class="w-full text-sm border bg-white rounded-md case-table mb-2">
                <tbody id="cases-${scenarioCount}">
                </tbody>
            </table>
            <button class="add-case text-blue-600 hover:underline text-xs" data-scenario="${scenarioCount}">+ Add Case</button>
        </td>
        <td class="px-4 py-3 text-right">
            <button class="remove-scenario text-red-500 hover:text-red-700 text-sm">Remove</button>
        </td>
    `;
    tbody.appendChild(scenarioRow);
});

// Dynamic case row addition
document.getElementById('scopeScenarioRows').addEventListener('click', function(e) {
    if (e.target.classList.contains('add-case')) {
        e.preventDefault();
        const scenarioIndex = e.target.dataset.scenario;
        const caseTable = document.getElementById(`cases-${scenarioIndex}`);
        const caseCount = caseTable.querySelectorAll('tr').length + 1;

        const caseRow = document.createElement('tr');
        caseRow.innerHTML = `
            <td class="px-4 py-2 w-1/4">
                <input type="text" placeholder="Case ${caseCount}" class="w-full border rounded-md px-2 py-1 text-sm">
            </td>
            <td class="px-4 py-2">
                <textarea rows="2" placeholder="Description ${caseCount}" class="w-full border rounded-md px-2 py-1 text-sm"></textarea>
            </td>
        `;
        caseTable.appendChild(caseRow);
    }

    if (e.target.classList.contains('remove-scenario')) {
        e.preventDefault();
        e.target.closest('tr').remove();
    }
});
</script>


<script>
document.getElementById('addWaiverScenarioBtn').addEventListener('click', function(e) {
    e.preventDefault();
    const tbody = document.getElementById('waiverScenarioRows');
    const scenarioCount = tbody.querySelectorAll('tr.waiver-scenario-row').length + 1;

    const scenarioRow = document.createElement('tr');
    scenarioRow.classList.add('waiver-scenario-row');
    scenarioRow.innerHTML = `
        <td class="px-4 py-3 font-semibold text-gray-800">
            <input type="text" placeholder="Scenario ${scenarioCount}" class="w-full border rounded-md px-2 py-1 text-sm">
        </td>
        <td colspan="2" class="px-4 py-3">
            <table class="w-full text-sm border bg-white rounded-md waiver-case-table mb-2">
                <tbody id="waiver-cases-${scenarioCount}">
                </tbody>
            </table>
            <button class="add-waiver-case text-blue-600 hover:underline text-xs" data-scenario="${scenarioCount}">+ Add Case</button>
        </td>
        <td class="px-4 py-3 text-right">
            <button class="remove-waiver-scenario text-red-500 hover:text-red-700 text-sm">Remove</button>
        </td>
    `;
    tbody.appendChild(scenarioRow);
});

// Dynamic case rows
document.getElementById('waiverScenarioRows').addEventListener('click', function(e) {
    if (e.target.classList.contains('add-waiver-case')) {
        e.preventDefault();
        const scenarioIndex = e.target.dataset.scenario;
        const caseTable = document.getElementById(`waiver-cases-${scenarioIndex}`);
        const caseCount = caseTable.querySelectorAll('tr').length + 1;

        const caseRow = document.createElement('tr');
        caseRow.innerHTML = `
            <td class="px-4 py-2 w-1/4">
                <input type="text" placeholder="Case ${caseCount}" class="w-full border rounded-md px-2 py-1 text-sm">
            </td>
            <td class="px-4 py-2">
                <textarea rows="2" placeholder="Description ${caseCount}" class="w-full border rounded-md px-2 py-1 text-sm"></textarea>
            </td>
        `;
        caseTable.appendChild(caseRow);
    }

    if (e.target.classList.contains('remove-waiver-scenario')) {
        e.preventDefault();
        e.target.closest('tr').remove();
    }
});
</script>

<script>
const minDays = document.getElementById('minDays');
const maxDays = document.getElementById('maxDays');
const preview  = document.getElementById('timelinePreview');

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
</script>

<script>
document.getElementById('addDeliverableBtn').addEventListener('click', function(e) {
    e.preventDefault();
    const tbody = document.getElementById('deliverableRows');
    const rowCount = tbody.rows.length + 1;

    const newRow = document.createElement('tr');
    newRow.innerHTML = `
        <td class="px-4 py-3 text-gray-600">${rowCount}</td>
        <td class="px-4 py-3">
            <input type="text" placeholder="Detail ${rowCount}" class="w-full border rounded-md px-2 py-1 text-sm">
        </td>
        <td class="px-4 py-3 text-right">
            <button class="remove-deliverable text-red-500 hover:text-red-700 text-sm">Remove</button>
        </td>
    `;
    tbody.appendChild(newRow);
});

document.getElementById('deliverableRows').addEventListener('click', function(e) {
    if (e.target.classList.contains('remove-deliverable')) {
        e.preventDefault();
        e.target.closest('tr').remove();
    }
});
</script>

@endsection
