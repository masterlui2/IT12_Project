@extends('admin.layout.app')

@section('content')

<!-- Top Navigation Header -->
<nav class="w-full bg-white border-b border-gray-100 shadow-sm px-6 py-4 flex justify-between items-center mb-6">
  <div class="flex items-center space-x-2">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
        d="M9 12h6m2 0a9 9 0 11-18 0 9 9 0 0118 0z" />
    </svg>
    <h2 class="text-xl font-semibold text-gray-800">Activity Logs</h2>
  </div>

  <div class="flex items-center gap-3">
    <input type="text" placeholder="Search logs by event or user"
           class="px-3 py-2 border rounded-md text-sm focus:ring-blue-500 focus:border-blue-500 w-60"/>
    <select class="px-3 py-2 border rounded-md text-sm focus:ring-blue-500 focus:border-blue-500">
      <option>All Levels</option>
      <option>Info</option>
      <option>Warning</option>
      <option>Error</option>
    </select>
    <button class="bg-blue-600 text-white px-4 py-2 rounded-md text-sm hover:bg-blue-700">
      Export Logs
    </button>
  </div>
</nav>


<!-- Activity Logs Table -->
<div class="p-6 bg-white border rounded-lg shadow-sm">
  <div class="overflow-x-auto">
    <table class="w-full text-left text-sm">
      <thead class="bg-gray-100 text-gray-700">
        <tr>
          <th class="px-6 py-3">Timestamp</th>
          <th class="px-6 py-3">User</th>
          <th class="px-6 py-3">Role</th>
          <th class="px-6 py-3">Action</th>
          <th class="px-6 py-3">Origin IP</th>
          <th class="px-6 py-3">Severity</th>
        </tr>
      </thead>
      <tbody class="divide-y">

        <tr class="hover:bg-gray-50 transition">
          <td class="px-6 py-3 text-gray-500">2025‑11‑14 14:34</td>
          <td class="px-6 py-3 font-semibold text-gray-800">Alex Reyes</td>
          <td class="px-6 py-3 text-gray-600">Technician</td>
          <td class="px-6 py-3 text-gray-700">Generated quotation QTN‑2025‑011.</td>
          <td class="px-6 py-3 text-gray-500">192.168.1.45</td>
          <td class="px-6 py-3"><span class="bg-green-100 text-green-700 px-2 py-1 rounded text-xs">Info</span></td>
        </tr>

        <tr class="hover:bg-gray-50 transition">
          <td class="px-6 py-3 text-gray-500">2025‑11‑14 14:15</td>
          <td class="px-6 py-3 font-semibold text-gray-800">System</td>
          <td class="px-6 py-3 text-gray-600">Automation</td>
          <td class="px-6 py-3 text-gray-700">Queue cleanup job completed successfully.</td>
          <td class="px-6 py-3 text-gray-500">127.0.0.1</td>
          <td class="px-6 py-3"><span class="bg-blue-100 text-blue-700 px-2 py-1 rounded text-xs">System</span></td>
        </tr>

        <tr class="hover:bg-gray-50 transition">
          <td class="px-6 py-3 text-gray-500">2025‑11‑14 13:47</td>
          <td class="px-6 py-3 font-semibold text-gray-800">Jamie Tanaka</td>
          <td class="px-6 py-3 text-gray-600">Manager</td>
          <td class="px-6 py-3 text-gray-700">Updated user access: Charles Grey → Suspended.</td>
          <td class="px-6 py-3 text-gray-500">10.0.5.21</td>
          <td class="px-6 py-3"><span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded text-xs">Warning</span></td>
        </tr>

        <tr class="hover:bg-gray-50 transition">
          <td class="px-6 py-3 text-gray-500">2025‑11‑14 13:20</td>
          <td class="px-6 py-3 font-semibold text-gray-800">System</td>
          <td class="px-6 py-3 text-gray-600">Maintenance</td>
          <td class="px-6 py-3 text-gray-700">Error logging module temporarily unavailable.</td>
          <td class="px-6 py-3 text-gray-500">127.0.0.1</td>
          <td class="px-6 py-3"><span class="bg-red-100 text-red-700 px-2 py-1 rounded text-xs">Error</span></td>
        </tr>

      </tbody>
    </table>
  </div>

  <!-- Pagination -->
  <div class="border-t bg-white px-6 py-3 flex justify-between items-center text-sm text-gray-500">
    <p>Showing 1–4 of 200 logs</p>
    <div class="space-x-1">
      <button class="px-2 py-1 border rounded hover:bg-gray-100">Prev</button>
      <button class="px-2 py-1 border rounded bg-blue-600 text-white">1</button>
      <button class="px-2 py-1 border rounded hover:bg-gray-100">2</button>
      <button class="px-2 py-1 border rounded hover:bg-gray-100">Next</button>
    </div>
  </div>
</div>


<!-- Log Summary / Filters Section -->
<div class="mt-4 bg-white border rounded-lg shadow-sm p-6">
  <h3 class="font-semibold text-gray-700 mb-4">Log Summary</h3>

  <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
    <div class="p-4 rounded-lg border border-green-200 bg-green-50 flex justify-between items-center">
      <span class="font-medium text-gray-700 text-sm">Info Logs</span>
      <span class="font-bold text-green-700 text-lg">156</span>
    </div>
    <div class="p-4 rounded-lg border border-yellow-200 bg-yellow-50 flex justify-between items-center">
      <span class="font-medium text-gray-700 text-sm">Warnings</span>
      <span class="font-bold text-yellow-700 text-lg">32</span>
    </div>
    <div class="p-4 rounded-lg border border-red-200 bg-red-50 flex justify-between items-center">
      <span class="font-medium text-gray-700 text-sm">Errors</span>
      <span class="font-bold text-red-700 text-lg">12</span>
    </div>
    <div class="p-4 rounded-lg border border-blue-200 bg-blue-50 flex justify-between items-center">
      <span class="font-medium text-gray-700 text-sm">System Messages</span>
      <span class="font-bold text-blue-700 text-lg">46</span>
    </div>
  </div>
</div>

@endsection
