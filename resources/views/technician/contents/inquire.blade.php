@extends('technician.layout.app')

@section('content')

<!-- Top Navigation Bar -->
<nav class="w-full bg-white shadow-sm border-b border-gray-100 px-6 py-3 flex flex-wrap justify-between items-center mb-6">
  <!-- Left side: Title -->
  <div class="flex items-center space-x-2">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M8 10h.01M12 14h.01M16 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
    </svg>
    <h2 class="text-xl font-semibold text-gray-800">Inquiries</h2>
  </div>

  <!-- Right side: Actions -->
  <div class="flex items-center gap-3">
    <input 
      type="text" 
      placeholder="Search inquiries by client or topic"
      class="px-3 py-2 border rounded-md text-sm focus:ring-blue-500 focus:border-blue-500 w-60"
    />

    <select class="px-3 py-2 border rounded-md text-sm focus:ring-blue-500 focus:border-blue-500">
      <option>All Status</option>
      <option>Pending</option>
      <option>Responded</option>
      <option>Closed</option>
    </select>

    <button class="bg-blue-600 text-white px-4 py-2 rounded-md text-sm hover:bg-blue-700">
      + New Inquiry
    </button>
  </div>
</nav>


<!-- Inquiries Table -->
<div class="bg-white rounded-lg shadow-sm overflow-hidden flex flex-col">
  <table class="w-full text-left text-sm">
    <thead class="bg-gray-100 text-gray-700">
      <tr>
        <th class="px-6 py-3">Inquiry #</th>
        <th class="px-6 py-3">Client</th>
        <th class="px-6 py-3">Subject</th>
        <th class="px-6 py-3">Status</th>
        <th class="px-6 py-3">Date Submitted</th>
        <th class="px-6 py-3 text-right">Actions</th>
      </tr>
    </thead>

    <tbody class="divide-y">
      <tr class="hover:bg-gray-50 transition">
        <td class="px-6 py-4 font-medium text-gray-800">INQ-2025-001</td>
        <td class="px-6 py-4">Tesla Energy</td>
        <td class="px-6 py-4">Request for New Charging Site</td>
        <td class="px-6 py-4"><span class="bg-yellow-100 text-yellow-800 text-xs px-2 py-1 rounded">Pending</span></td>
        <td class="px-6 py-4">2025-11-12</td>
        <td class="px-6 py-4 text-right space-x-3">
          <button class="text-blue-600 hover:underline text-sm">View</button>
          <button class="text-green-600 hover:text-green-700 text-sm">Convert to Quote</button>
        </td>
      </tr>

      <tr class="hover:bg-gray-50 transition">
        <td class="px-6 py-4 font-medium text-gray-800">INQ-2025-002</td>
        <td class="px-6 py-4">RapidEV Solutions</td>
        <td class="px-6 py-4">System Integration Follow-up</td>
        <td class="px-6 py-4"><span class="bg-green-100 text-green-700 text-xs px-2 py-1 rounded">Responded</span></td>
        <td class="px-6 py-4">2025-11-10</td>
        <td class="px-6 py-4 text-right space-x-3">
          <button class="text-blue-600 hover:underline text-sm">View</button>
          <button class="text-gray-500 hover:text-red-600 text-sm">Delete</button>
        </td>
      </tr>

      <tr class="hover:bg-gray-50 transition">
        <td class="px-6 py-4 font-medium text-gray-800">INQ-2025-003</td>
        <td class="px-6 py-4">GreenCharge Pvt Ltd</td>
        <td class="px-6 py-4">Software Support and Updates</td>
        <td class="px-6 py-4"><span class="bg-gray-100 text-gray-700 text-xs px-2 py-1 rounded">Closed</span></td>
        <td class="px-6 py-4">2025-10-28</td>
        <td class="px-6 py-4 text-right space-x-3">
          <button class="text-blue-600 hover:underline text-sm">View</button>
          <button class="text-gray-500 hover:text-red-600 text-sm">Delete</button>
        </td>
      </tr>
    </tbody>
  </table>

  <!-- Pagination -->
  <div class="border-t bg-white px-6 py-3 flex justify-between items-center text-sm text-gray-500">
    <p>Showing 1–3 of 20 inquiries</p>
    <div class="space-x-1">
      <button class="px-2 py-1 border rounded hover:bg-gray-100">Prev</button>
      <button class="px-2 py-1 border rounded bg-blue-600 text-white">1</button>
      <button class="px-2 py-1 border rounded hover:bg-gray-100">2</button>
      <button class="px-2 py-1 border rounded hover:bg-gray-100">Next</button>
    </div>
  </div>
</div>


<!-- Inquiries Summary -->
<div class="mt-4 bg-white border-t shadow-sm rounded-b-lg px-6 py-4 flex justify-between items-center text-sm">
  <div class="font-medium text-gray-700">
    Total Inquiries: <span class="text-blue-600 font-semibold">20</span>
  </div>
  <div class="font-medium text-gray-700">
    Pending Responses: <span class="text-yellow-600 font-semibold">5</span>
  </div>
</div>

@endsection
