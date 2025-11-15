@extends('technician.layout.app')

@section('content')

<div class="bg-white rounded-xl shadow-sm border p-8 space-y-8">

  <!-- Header Section -->
  <div class="flex justify-between items-center border-b pb-3">
    <div>
      <h1 class="text-xl font-bold text-gray-800">Techne Fixer Computer and Laptop Repair Services</h1>
      <p class="text-sm text-gray-500">007 Manga Street Crossing Bayabas Davao City</p>
      <p class="text-sm text-gray-500">Contact No: 09662406825   TIN 618‑863‑736‑000000</p>
    </div>
    <img src="{{ asset('images/logo.png') }}" class="w-20 h-20 object-contain" alt="Company Logo">
  </div>

  <!-- Quotation Management Section -->
  <div>
    <div class="flex justify-between items-center mb-6">
      <h2 class="text-lg font-semibold text-gray-800">Quotation Management</h2>

      <div class="flex flex-wrap items-center gap-3">
        <input type="text" placeholder="Search by client or ID" 
              class="px-3 py-2 border rounded-md text-sm focus:ring-blue-500 focus:border-blue-500 w-52" />

        <select class="px-3 py-2 border rounded-md text-sm focus:ring-blue-500 focus:border-blue-500">
          <option>All Status</option>
          <option>Draft</option>
          <option>Sent</option>
          <option>Approved</option>
        </select>

        <select class="px-3 py-2 border rounded-md text-sm focus:ring-blue-500 focus:border-blue-500">
          <option>Sort: Recent</option>
          <option>Oldest</option>
          <option>Amount</option>
        </select>

        <form action="{{ route('quotation.new') }}">
          <button
            class="bg-blue-600 text-white px-4 py-2 rounded-md text-sm 
                  hover:bg-blue-700 active:scale-95 active:bg-blue-800 
                  transition-transform duration-100 shadow-sm hover:shadow-md">
            + New Quotation
          </button>
        </form>
      </div>
    </div>

    <!-- Table Display -->
    <div class="overflow-x-auto border rounded-lg">
      <table class="w-full text-left text-sm">
        <thead class="bg-gray-100 text-gray-700">
          <tr>
            <th class="px-6 py-3">Quote #</th>
            <th class="px-6 py-3">Client</th>
            <th class="px-6 py-3">Amount</th>
            <th class="px-6 py-3">Status</th>
            <th class="px-6 py-3">Issue Date</th>
            <th class="px-6 py-3">Valid Until</th>
            <th class="px-6 py-3 text-right">Actions</th>
          </tr>
        </thead>
        <tbody class="divide-y">
          @for($i = 1; $i <= 10; $i++)
          <tr class="hover:bg-gray-50 transition">
            <td class="px-6 py-4 font-medium text-gray-800">QTN-2025-00{{ $i }}</td>
            <td class="px-6 py-4">Client {{ $i }}</td>
            <td class="px-6 py-4">₱{{ 3000 + ($i * 125) }}</td>
            <td class="px-6 py-4">
              <span class="bg-blue-100 text-blue-700 text-xs px-2 py-1 rounded">Sent</span>
            </td>
            <td class="px-6 py-4">2025-11-{{ 10+$i }}</td>
            <td class="px-6 py-4">2025-11-{{ 25+$i }}</td>
            <td class="px-6 py-4 text-right space-x-2">
              <button class="text-blue-600 hover:underline text-sm">View</button>
              <button class="text-gray-500 hover:text-red-600 text-sm">Delete</button>
            </td>
          </tr>
          @endfor
        </tbody>
      </table>
    </div>

    <!-- Summary -->
    <div class="flex justify-between items-center mt-4 border-t pt-3 text-sm text-gray-700">
      <div>Total Quotations: <span class="text-blue-600 font-semibold">50</span></div>
      <div>Overall Value: <span class="text-green-600 font-semibold">₱164,375.00</span></div>
    </div>

    <!-- Pagination -->
    <div class="border-t mt-4 pt-2 flex justify-between items-center text-sm text-gray-500">
      <p>Showing 1–10 of 50 quotations</p>
      <div class="space-x-1">
        <button class="px-2 py-1 border rounded hover:bg-gray-100">Prev</button>
        <button class="px-2 py-1 border rounded bg-blue-600 text-white">1</button>
        <button class="px-2 py-1 border rounded hover:bg-gray-100">2</button>
        <button class="px-2 py-1 border rounded hover:bg-gray-100">Next</button>
      </div>
    </div>
  </div>
</div>

@endsection
