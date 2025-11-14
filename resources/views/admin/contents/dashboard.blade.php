@extends('admin.layout.app')

@section('content')

<!-- Top Header -->
<nav class="w-full bg-white shadow-sm border-b border-gray-100 px-6 py-4 flex justify-between items-center mb-6">
  <div class="flex items-center space-x-2">
    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
        d="M9.75 17L4.75 12m0 0l5-5M4.75 12h14.5M9.75 17l-2.5 2.5M9.75 17v-2.5" />
    </svg>
    <h2 class="text-xl font-semibold text-gray-800">Administrator Dashboard</h2>
  </div>

  <button 
    class="bg-blue-600 text-white px-4 py-2 rounded-md text-sm hover:bg-blue-700">
    Refresh Data
  </button>
</nav>


<!-- Dashboard Main Content -->
<div class="p-6 space-y-6">

  <!-- Overview Cards -->
  <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
    <div class="bg-white border rounded-lg shadow-sm p-4 flex flex-col">
      <div class="flex items-center justify-between mb-2">
        <h4 class="text-sm text-gray-600 font-medium">Active Technicians</h4>
        <i class="fas fa-users text-blue-500 text-lg"></i>
      </div>
      <p class="text-2xl font-semibold text-gray-800">32</p>
      <span class="text-xs text-green-600 mt-1 flex items-center">
        <i class="fas fa-arrow-up mr-1"></i> +8% vs last week
      </span>
    </div>

    <div class="bg-white border rounded-lg shadow-sm p-4 flex flex-col">
      <div class="flex items-center justify-between mb-2">
        <h4 class="text-sm text-gray-600 font-medium">Pending Inquiries</h4>
        <i class="fas fa-envelope-open text-yellow-500 text-lg"></i>
      </div>
      <p class="text-2xl font-semibold text-gray-800">14</p>
      <span class="text-xs text-yellow-600 mt-1">5 new today</span>
    </div>

    <div class="bg-white border rounded-lg shadow-sm p-4 flex flex-col">
      <div class="flex items-center justify-between mb-2">
        <h4 class="text-sm text-gray-600 font-medium">Open Quotations</h4>
        <i class="fas fa-file-invoice text-indigo-500 text-lg"></i>
      </div>
      <p class="text-2xl font-semibold text-gray-800">45</p>
      <span class="text-xs text-green-600 mt-1">3 approved today</span>
    </div>

    <div class="bg-white border rounded-lg shadow-sm p-4 flex flex-col">
      <div class="flex items-center justify-between mb-2">
        <h4 class="text-sm text-gray-600 font-medium">Total Revenue</h4>
        <i class="fas fa-dollar-sign text-green-600 text-lg"></i>
      </div>
      <p class="text-2xl font-semibold text-gray-800">$118,400</p>
      <span class="text-xs text-green-600 mt-1">+11% from last month</span>
    </div>
  </div>


  <!-- System Health and Charts -->
  <div class="grid lg:grid-cols-2 gap-6">
    <!-- System Health -->
    <div class="bg-white border rounded-lg shadow-sm p-4">
      <h3 class="font-semibold text-gray-700 mb-4">System Health Metrics</h3>

      <div class="space-y-4">
        <div class="flex justify-between text-sm">
          <span class="text-gray-600">Server Uptime</span> 
          <span class="text-green-600 font-semibold">99.9%</span>
        </div>
        <div class="flex justify-between text-sm">
          <span class="text-gray-600">Active API Connections</span> 
          <span class="text-blue-600 font-semibold">342</span>
        </div>
        <div class="flex justify-between text-sm">
          <span class="text-gray-600">Database Sync Status</span> 
          <span class="text-green-600 font-semibold">OK</span>
        </div>
        <div class="flex justify-between text-sm">
          <span class="text-gray-600">Failed Jobs</span> 
          <span class="text-red-600 font-semibold">3</span>
        </div>
      </div>
    </div>

    <!-- Performance Chart Placeholder -->
    <div class="bg-white border rounded-lg shadow-sm p-4">
      <h3 class="font-semibold text-gray-700 mb-4">Platform Activity Overview</h3>
      <div class="flex items-center justify-center h-64 bg-gray-50 text-gray-400 rounded-md">
        [Chart Placeholder: System Loads or API Requests Graph]
      </div>
    </div>
  </div>


  <!-- Latest Logs Table -->
  <div class="bg-white border rounded-lg shadow-sm">
    <div class="p-4 border-b flex justify-between items-center">
      <h3 class="font-semibold text-gray-700">Recent System Activity</h3>
      <button class="text-blue-600 hover:underline text-sm">View Logs</button>
    </div>

    <div class="overflow-x-auto">
      <table class="w-full text-left text-sm">
        <thead class="bg-gray-100 text-gray-700">
          <tr>
            <th class="px-6 py-3">Time</th>
            <th class="px-6 py-3">Event</th>
            <th class="px-6 py-3">User</th>
            <th class="px-6 py-3">Severity</th>
          </tr>
        </thead>
        <tbody class="divide-y">
          <tr class="hover:bg-gray-50 transition">
            <td class="px-6 py-3 text-gray-600">2025‑11‑14 14:02</td>
            <td class="px-6 py-3 text-gray-800">Technician record updated</td>
            <td class="px-6 py-3 text-gray-600">Admin</td>
            <td class="px-6 py-3">
              <span class="bg-green-100 text-green-700 px-2 py-1 rounded text-xs">Info</span>
            </td>
          </tr>

          <tr class="hover:bg-gray-50 transition">
            <td class="px-6 py-3 text-gray-600">2025‑11‑14 13:45</td>
            <td class="px-6 py-3 text-gray-800">Failed cron task – syncLogs()</td>
            <td class="px-6 py-3 text-gray-600">System</td>
            <td class="px-6 py-3">
              <span class="bg-red-100 text-red-700 px-2 py-1 rounded text-xs">Error</span>
            </td>
          </tr>

          <tr class="hover:bg-gray-50 transition">
            <td class="px-6 py-3 text-gray-600">2025‑11‑14 12:20</td>
            <td class="px-6 py-3 text-gray-800">API key regenerated – Admin</td>
            <td class="px-6 py-3 text-gray-600">Developer</td>
            <td class="px-6 py-3">
              <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded text-xs">Warning</span>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>

</div>

@endsection
