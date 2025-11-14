@extends('technician.layout.app')

@section('content')

<!-- Top Navigation Bar -->
<nav class="w-full bg-white shadow-sm border-b border-gray-100 px-6 py-3 flex flex-wrap items-center justify-between mb-4">
  <div class="flex items-center space-x-2">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
            d="M13 16h-1v-4h-1m1-4h.01M12 8v4m0 4v4m8-12H4m16 0v12H4V8h16z"/>
    </svg>
    <h2 class="text-xl font-semibold text-gray-800">Quotation Management</h2>
  </div>

  <div class="flex flex-wrap items-center gap-3">
    <input type="text" placeholder="Search by client or ID" 
           class="px-3 py-2 border rounded-md text-sm focus:ring-blue-500 focus:border-blue-500 w-52"/>

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

    <button class="bg-blue-600 text-white px-4 py-2 rounded-md text-sm hover:bg-blue-700">
      + New Quotation
    </button>
  </div>
</nav>


<!-- Scrollable table container -->
<div class="flex flex-col h-[calc(100vh-200px)] bg-white rounded-lg shadow-sm overflow-hidden">
  <div class="overflow-y-auto flex-1">
    <table class="w-full text-left text-sm">
      <thead class="sticky top-0 bg-gray-100 text-gray-700 z-10">
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
          <td class="px-6 py-4">${{ 3000 + ($i * 125) }}</td>
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

  <div class="mt-4 bg-white border-t shadow-sm rounded-b-lg px-6 py-4 flex justify-between items-center text-sm">

  <div class="font-medium text-gray-700">
    Total Quotations: <span class="text-blue-600 font-semibold">50</span>
  </div>

  <div class="font-medium text-gray-700">
    Overall Value: <span class="text-green-600 font-semibold">$164,375.00</span>
  </div>

</div>

  <!-- Pagination (fixed above footer) -->
  <div class="border-t bg-white px-6 py-3 flex justify-between items-center text-sm text-gray-500">
    <p>Showing 1–10 of 50 quotations</p>
    <div class="space-x-1">
      <button class="px-2 py-1 border rounded hover:bg-gray-100">Prev</button>
      <button class="px-2 py-1 border rounded bg-blue-600 text-white">1</button>
      <button class="px-2 py-1 border rounded hover:bg-gray-100">2</button>
      <button class="px-2 py-1 border rounded hover:bg-gray-100">Next</button>
    </div>
  </div>
</div>


@endsection
