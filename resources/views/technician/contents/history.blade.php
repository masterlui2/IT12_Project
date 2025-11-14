@extends('technician.layout.app')

@section('content')

<!-- Top Navigation Bar -->
<nav class="w-full bg-white shadow-sm border-b border-gray-100 px-6 py-3 flex justify-between items-center mb-6">
  <div class="flex items-center space-x-2">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M12 8v4l3 3m6 0a9 9 0 11-18 0 9 9 0 0118 0z" />
    </svg>
    <h2 class="text-xl font-semibold text-gray-800">My Work History</h2>
  </div>

  <div class="flex items-center gap-3">
    <select class="px-3 py-2 border rounded-md text-sm focus:ring-blue-500 focus:border-blue-500">
      <option>All Activities</option>
      <option>Installations</option>
      <option>Repairs</option>
      <option>Quotations</option>
      <option>Maintenance</option>
    </select>

    <select class="px-3 py-2 border rounded-md text-sm focus:ring-blue-500 focus:border-blue-500">
      <option>Recent First</option>
      <option>Oldest First</option>
    </select>
  </div>
</nav>

<!-- Technician History List -->
<div class="bg-white rounded-lg shadow-sm border p-6">
  <div class="space-y-6">

    <!-- Activity Card -->
    <div class="border-l-4 border-blue-600 pl-4">
      <div class="flex justify-between items-center mb-1">
        <h4 class="font-semibold text-gray-800 text-sm">
          Installed CSMS Unit at Station #12 – Metro City
        </h4>
        <span class="text-xs text-gray-500">Today • 2:35 PM</span>
      </div>
      <p class="text-xs text-gray-600">
        Completed installation and configuration of charging unit. Uploaded report #INS‑2031.
      </p>
      <p class="mt-1 text-xs text-green-600 font-medium">Status: Completed</p>
    </div>

    <div class="border-l-4 border-yellow-500 pl-4">
      <div class="flex justify-between items-center mb-1">
        <h4 class="font-semibold text-gray-800 text-sm">
          Responded to Inquiry – RapidEV Solutions
        </h4>
        <span class="text-xs text-gray-500">Yesterday • 4:10 PM</span>
      </div>
      <p class="text-xs text-gray-600">
        Sent quotation draft for expansion project #QTN‑2025‑009.
      </p>
      <p class="mt-1 text-xs text-yellow-600 font-medium">Status: In Progress</p>
    </div>

    <div class="border-l-4 border-green-600 pl-4">
      <div class="flex justify-between items-center mb-1">
        <h4 class="font-semibold text-gray-800 text-sm">
          Maintenance Check – Bay 3, RapidEV Hub
        </h4>
        <span class="text-xs text-gray-500">2025‑11‑10 • 9:25 AM</span>
      </div>
      <p class="text-xs text-gray-600">
        Completed routine inspection. Replaced communication module and tested connectivity.
      </p>
      <p class="mt-1 text-xs text-green-600 font-medium">Status: Verified</p>
    </div>

    <div class="border-l-4 border-gray-400 pl-4">
      <div class="flex justify-between items-center mb-1">
        <h4 class="font-semibold text-gray-800 text-sm">
          Shift Log Submitted – Daily Activity Report
        </h4>
        <span class="text-xs text-gray-500">2025‑11‑08 • 5:45 PM</span>
      </div>
      <p class="text-xs text-gray-600">
        Submitted daily task summary and hours worked.
      </p>
      <p class="mt-1 text-xs text-gray-500 font-medium">Status: Logged</p>
    </div>

  </div>
</div>

<!-- Summary Bar -->
<div class="mt-4 bg-white border-t shadow-sm rounded-b-lg px-6 py-4 flex justify-between items-center text-sm font-medium text-gray-700">
  <span>Total Tasks Completed : <span class="text-green-600 font-semibold">42</span></span>
  <span>Active Assignments : <span class="text-yellow-600 font-semibold">3</span></span>
</div>

@endsection
