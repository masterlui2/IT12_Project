@extends('technician.layout.app')

@section('content')

<form action="{{ route('quotation.update', $quotation->id) }}" method="POST" enctype="multipart/form-data" id="quotationForm">
    @csrf
    @method('PUT')

    <div class="bg-white rounded-xl shadow-sm border p-8 space-y-8">

        <!-- Validation messages -->
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

        <!-- Header -->
        <div class="flex justify-between items-center border-b pb-3">
            <div>
                <h1 class="text-xl font-bold text-gray-800">Techne Fixer Computer and Laptop Repair Services</h1>
                <p class="text-sm text-gray-500">007 Manga Street Crossing, Bayabas, Davao City</p>
                <p class="text-sm text-gray-500">Contact No: 09662406825 &nbsp; TIN 618‑863‑736‑000000</p>
            </div>
            <img src="{{ asset('images/logo.png') }}" class="w-20 h-20 object-contain" alt="Company Logo">
        </div>

        <!-- Client Logo -->
        <div>
            <label class="block text-sm font-semibold mb-2 text-gray-700">Client Logo / Face</label>
            <div id="clientLogoPreview"
                 class="w-32 h-32 bg-gray-100 flex items-center justify-center mb-4 rounded-full border overflow-hidden">
                @if(!empty($quotation->client_logo))
                    <img src="{{ asset('storage/'.$quotation->client_logo) }}" alt="Client Logo"
                         class="w-full h-full object-cover">
                @else
                    <span class="text-gray-400 text-xs">No Logo</span>
                @endif
            </div>

            <input type="file" name="client_logo" id="clientLogoInput" class="hidden" accept="image/*">
            <button type="button"
                    onclick="document.getElementById('clientLogoInput').click()"
                    class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 focus:ring-2 ring-offset-1 ring-blue-200 text-sm">
                Change Photo
            </button>
            <p class="text-xs text-gray-500 mt-2">Upload new image if replacing current logo.</p>
        </div>

        <!-- Project Info -->
        <div class="bg-gray-50 border rounded-md p-4 grid sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm text-gray-600">Project Title *</label>
                <input type="text" name="project_title" value="{{ old('project_title', $quotation->project_title) }}" required
                       class="w-full border mt-1 rounded-md px-3 py-2 text-sm focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div>
                <label class="block text-sm text-gray-600">Date Issued *</label>
                <input type="date" name="date_issued"
                       value="{{ old('date_issued', \Carbon\Carbon::parse($quotation->date_issued)->format('Y-m-d')) }}" required
                       class="w-full border mt-1 rounded-md px-3 py-2 text-sm focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div>
                <label class="block text-sm text-gray-600">Client Company Name *</label>
                <input type="text" name="client_name" value="{{ old('client_name', $quotation->client_name) }}" required
                       class="w-full border mt-1 rounded-md px-3 py-2 text-sm focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div>
                <label class="block text-sm text-gray-600">Client Address</label>
                <input type="text" name="client_address" value="{{ old('client_address', $quotation->client_address) }}"
                       class="w-full border mt-1 rounded-md px-3 py-2 text-sm focus:ring-blue-500 focus:border-blue-500">
            </div>
        </div>

        <!-- Objective -->
        <div>
            <label class="block text-sm font-semibold mb-2 text-gray-700">Objective</label>
            <textarea rows="3" name="objective"
                      class="w-full border rounded-md px-3 py-2 text-sm focus:ring-blue-500 focus:border-blue-500">{{ old('objective', $quotation->objective) }}</textarea>
        </div>

        <!-- Items edit table -->
        <div>
            <h3 class="text-lg font-semibold mb-3 text-gray-700">Items and Services *</h3>
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
                        @foreach($quotation->details as $i => $detail)
                            <tr>
                                <td class="px-4 py-3">
                                    <input type="text" name="items[{{ $i }}][name]" value="{{ $detail->name }}"
                                           class="w-full border rounded-md px-2 py-1 text-sm">
                                </td>
                                <td class="px-4 py-3">
                                    <textarea rows="2" name="items[{{ $i }}][description]"
                                              class="w-full border rounded-md px-2 py-1 text-sm">{{ $detail->description }}</textarea>
                                </td>
                                <td class="px-4 py-3 w-20">
                                    <input type="number" name="items[{{ $i }}][quantity]" value="{{ $detail->quantity }}"
                                           class="border rounded-md px-2 py-1 w-full text-center text-sm item-qty">
                                </td>
                                <td class="px-4 py-3 w-24">
                                    <input type="number" name="items[{{ $i }}][unit_price]" value="{{ $detail->price }}"
                                           class="border rounded-md px-2 py-1 w-full text-center text-sm item-price">
                                </td>
                                <td class="px-4 py-3 text-right text-gray-700 item-total">₱{{ number_format($detail->total,2) }}</td>
                                <td class="px-4 py-3 text-right">
                                    <button type="button" class="remove-row text-red-500 hover:text-red-700 text-sm">Remove</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="flex justify-end mt-3">
                <button type="button" id="addItemBtn" class="text-blue-600 hover:underline text-sm">+ Add Item</button>
            </div>
        </div>

        <!-- Totals -->
        <div class="flex justify-end">
            <div class="bg-gray-50 border rounded-lg p-4 w-80">
                <div class="flex justify-between text-sm py-1">
                    <span>Subtotal (Labor)</span>
                    <span id="subtotal">₱{{ number_format($quotation->labor_estimate,2) }}</span>
                </div>
                <div class="flex justify-between text-sm py-1">
                    <span>Diagnostic Fee (10%)</span>
                    <span id="tax">₱{{ number_format($quotation->diagnostic_fee,2) }}</span>
                </div>
                <div class="flex justify-between text-sm font-semibold border-t mt-2 pt-2">
                    <span>Grand Total</span>
                    <span id="totalAmount">₱{{ number_format($quotation->grand_total,2) }}</span>
                </div>
            </div>
        </div>

        <!-- Timeline -->
        <div>
            <label class="block text-sm font-semibold mb-2 text-gray-700">Timeline / Completion Schedule</label>
            <div class="flex items-center gap-2">
                <input id="minDays" name="timeline_min_days" type="number" min="1"
                       value="{{ old('timeline_min_days', $quotation->timeline_min_days) }}"
                       class="w-24 border rounded-md px-3 py-2 text-sm focus:ring-blue-500 focus:border-blue-500">
                <span class="text-gray-500">to</span>
                <input id="maxDays" name="timeline_max_days" type="number" min="1"
                       value="{{ old('timeline_max_days', $quotation->timeline_max_days) }}"
                       class="w-24 border rounded-md px-3 py-2 text-sm focus:ring-blue-500 focus:border-blue-500">
                <span class="text-gray-700 text-sm">days</span>
            </div>
            <p id="timelinePreview" class="text-xs text-gray-500 mt-2 italic">
                Estimated completion: {{ $quotation->timeline_min_days }}‑{{ $quotation->timeline_max_days }} days
            </p>
        </div>

        <!-- Terms -->
        <div>
            <label class="block text-sm font-semibold mb-2 text-gray-700">Terms and Conditions</label>
            <textarea rows="5" name="terms_conditions"
                      class="w-full border rounded-md px-3 py-2 text-sm focus:ring-blue-500 focus:border-blue-500">{{ old('terms_conditions', $quotation->terms_conditions) }}</textarea>
        </div>

        <!-- Action buttons -->
        <div class="flex justify-end space-x-3 border-t pt-4">
            <a href="{{ route('technician.quotation') }}">
                <button type="button"
                        class="px-4 py-2 border rounded-md text-gray-600 text-sm hover:bg-gray-100 shadow-sm">
                    Cancel
                </button>
            </a>
            <button type="submit" name="action" value="save"
                    class="px-4 py-2 bg-green-600 text-white rounded-md text-sm hover:bg-green-700">
                Update Quotation
            </button>
        </div>
    </div>
</form>

<script>
    // Keep your same utility + dynamic logic from create.js here (addItem, removeRow, calculateTotals, etc.)
    // You can copy the whole <script> section from your .create view;
    // It will still work since naming conventions are the same.
</script>

@endsection
