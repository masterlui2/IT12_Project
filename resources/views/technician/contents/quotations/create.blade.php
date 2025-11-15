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
      <input type="text" placeholder="Scanner Error 13 – HP Color LaserJet Managed MFP M280nw"
             class="w-full border mt-1 rounded-md px-3 py-2 text-sm focus:ring-blue-500 focus:border-blue-500">
    </div>
    <div>
      <label class="block text-sm text-gray-600">Date Issued</label>
      <input type="date" class="w-full border mt-1 rounded-md px-3 py-2 text-sm focus:ring-blue-500 focus:border-blue-500">
    </div>
    <div>
      <label class="block text-sm text-gray-600">Client Company Name</label>
      <input type="text" placeholder="China Road and Bridge Corp."
             class="w-full border mt-1 rounded-md px-3 py-2 text-sm focus:ring-blue-500 focus:border-blue-500">
    </div>
    <div>
      <label class="block text-sm text-gray-600">Client Address</label>
      <input type="text" placeholder="Unit 508/512 BF Condominium, A. Soriano Ave. Intramuros, Manila"
             class="w-full border mt-1 rounded-md px-3 py-2 text-sm focus:ring-blue-500 focus:border-blue-500">
    </div>
  </div>

  <!-- Objective -->
  <div>
    <label class="block text-sm text-gray-700 font-semibold mb-2">Objective</label>
    <textarea rows="3" placeholder="To ensure optimal functioning of HP Color LaserJet by addressing scanner motor issues, performing PMS and upgrading software."
              class="w-full border rounded-md px-3 py-2 text-sm focus:ring-blue-500 focus:border-blue-500"></textarea>
  </div>

  <!-- Itemization Table -->
  <div>
    <h3 class="text-lg font-semibold text-gray-700 mb-3">Items and Services</h3>
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
          <tr>
            <td class="px-4 py-3 font-medium text-gray-700">
              <input type="text" value="HP Color LaserJet Managed MFP M280nw"
                     class="w-full border rounded-md px-2 py-1 text-sm">
            </td>
            <td class="px-4 py-3">
              <textarea rows="3" class="w-full border rounded-md px-2 py-1 text-sm">Conducted Preliminary Assessment such as inspection, troubleshooting, maintenance and PMS.</textarea>
            </td>
            <td class="px-4 py-3 w-20">
              <input type="number" value="1" class="border rounded-md px-2 py-1 w-full text-center text-sm">
            </td>
            <td class="px-4 py-3 w-24">
              <input type="number" value="6000" class="border rounded-md px-2 py-1 w-full text-center text-sm">
            </td>
            <td class="px-4 py-3 text-gray-700">₱6,000</td>
            <td class="px-4 py-3 text-right">
              <button class="text-red-500 hover:text-red-700 text-sm">Remove</button>
            </td>
          </tr>

          <tr>
            <td class="px-4 py-3 font-medium text-gray-700">
              <input type="text" value="Replace Scanner Motor" class="w-full border rounded-md px-2 py-1 text-sm">
            </td>
            <td class="px-4 py-3">
              <textarea rows="3" class="w-full border rounded-md px-2 py-1 text-sm">Replace defective motor with new unit and run testing for smooth operation.</textarea>
            </td>
            <td class="px-4 py-3 w-20"><input type="number" value="1" class="border rounded-md w-full px-2 py-1 text-center text-sm"></td>
            <td class="px-4 py-3 w-24"><input type="number" value="11600" class="border rounded-md w-full px-2 py-1 text-center text-sm"></td>
            <td class="px-4 py-3 text-gray-700">₱11,600</td>
            <td class="px-4 py-3 text-right">
              <button class="text-red-500 hover:text-red-700 text-sm">Remove</button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <div class="flex justify-end mt-3">
      <button class="text-blue-600 hover:underline text-sm">+ Add Item</button>
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
    <button class="px-4 py-2 bg-blue-600 text-white rounded-md text-sm hover:bg-blue-700">Generate PDF Quotation</button>
  </div>

</div>

@endsection
