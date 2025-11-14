@extends('admin.layout.app')

@section('content')

<!-- Top Header -->
<nav class="w-full bg-white border-b border-gray-100 shadow-sm px-6 py-4 flex justify-between items-center mb-6">
  <div class="flex items-center space-x-2">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M11 3v9h9M21 21H3V3" />
    </svg>
    <h2 class="text-xl font-semibold text-gray-800">Analytics Dashboard</h2>
  </div>

  <div class="flex items-center gap-3">
    <select class="px-3 py-2 border rounded-md text-sm focus:ring-blue-500 focus:border-blue-500">
      <option>Last 7 days</option>
      <option>Last 30 days</option>
      <option>Quarter</option>
      <option>This Year</option>
    </select>
    <button class="bg-blue-600 text-white px-4 py-2 rounded-md text-sm hover:bg-blue-700">
      Export Report
    </button>
  </div>
</nav>

<!-- Analytics Body -->
<div class="p-6 space-y-8">

  <!-- KPIs Summary Row -->
  <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">

    <div class="bg-white border shadow-sm rounded-lg p-4">
      <h4 class="text-sm text-gray-600 mb-1">Total Revenue</h4>
      <p class="text-2xl font-bold text-gray-800">$186,920</p>
      <span class="text-xs text-green-600 flex items-center mt-1">
        <i class="fas fa-arrow-up mr-1"></i> +12% month over month
      </span>
    </div>

    <div class="bg-white border shadow-sm rounded-lg p-4">
      <h4 class="text-sm text-gray-600 mb-1">Quotations Approved</h4>
      <p class="text-2xl font-bold text-gray-800">74</p>
      <span class="text-xs text-green-600 flex items-center mt-1">
        <i class="fas fa-arrow-up mr-1"></i> +5 since last week
      </span>
    </div>

    <div class="bg-white border shadow-sm rounded-lg p-4">
      <h4 class="text-sm text-gray-600 mb-1">Inquiries Received</h4>
      <p class="text-2xl font-bold text-gray-800">192</p>
      <span class="text-xs text-yellow-600 flex items-center mt-1">
        <i class="fas fa-arrow-down mr-1"></i> –3% vs previous period
      </span>
    </div>

    <div class="bg-white border shadow-sm rounded-lg p-4">
      <h4 class="text-sm text-gray-600 mb-1">Average Response Time</h4>
      <p class="text-2xl font-bold text-gray-800">2.1 hrs</p>
      <span class="text-xs text-green-600 flex items-center mt-1">
        <i class="fas fa-clock mr-1"></i> +0.3 faster
      </span>
    </div>
  </div>

  <!-- Charts Section -->
  <div class="grid lg:grid-cols-2 gap-6">

    <!-- Revenue Chart -->
    <div class="bg-white border rounded-lg shadow-sm p-4">
      <h3 class="font-semibold text-gray-700 mb-4">Revenue Trend (Last 6 Months)</h3>
      <div class="flex items-center justify-center h-64 bg-gray-50 text-gray-400 rounded-md">
        [Chart Placeholder – Line Graph Revenue]
      </div>
    </div>

    <!-- Conversion Chart -->
    <div class="bg-white border rounded-lg shadow-sm p-4">
      <h3 class="font-semibold text-gray-700 mb-4">Inquiry → Quotation Conversion Rate</h3>
      <div class="flex items-center justify-center h-64 bg-gray-50 text-gray-400 rounded-md">
        [Chart Placeholder – Doughnut Chart]
      </div>
    </div>

  </div>

  <!-- Technician Activity Analytics -->
  <div class="bg-white border rounded-lg shadow-sm p-4">
    <h3 class="font-semibold text-gray-700 mb-4">Technician Productivity Report</h3>
    <div class="overflow-x-auto">
      <table class="w-full text-left text-sm">
        <thead class="bg-gray-100 text-gray-700">
          <tr>
            <th class="px-6 py-3">Technician</th>
            <th class="px-6 py-3">Tasks Completed</th>
            <th class="px-6 py-3">Average Response</th>
            <th class="px-6 py-3">Errors</th>
            <th class="px-6 py-3">Rating</th>
          </tr>
        </thead>
        <tbody class="divide-y">
          <tr class="hover:bg-gray-50">
            <td class="px-6 py-3 font-semibold text-gray-800">Alex Reyes</td>
            <td class="px-6 py-3 text-gray-700">47</td>
            <td class="px-6 py-3 text-gray-700">1.8 hrs</td>
            <td class="px-6 py-3 text-gray-700">0</td>
            <td class="px-6 py-3 text-green-600 font-semibold">4.9★</td>
          </tr>
          <tr class="hover:bg-gray-50">
            <td class="px-6 py-3 font-semibold text-gray-800">Miko Shimizutani</td>
            <td class="px-6 py-3 text-gray-700">40</td>
            <td class="px-6 py-3 text-gray-700">2.3 hrs</td>
            <td class="px-6 py-3 text-gray-700">1</td>
            <td class="px-6 py-3 text-green-600 font-semibold">4.7★</td>
          </tr>
          <tr class="hover:bg-gray-50">
            <td class="px-6 py-3 font-semibold text-gray-800">Il Shin Jeon</td>
            <td class="px-6 py-3 text-gray-700">52</td>
            <td class="px-6 py-3 text-gray-700">1.6 hrs</td>
            <td class="px-6 py-3 text-gray-700">0</td>
            <td class="px-6 py-3 text-green-600 font-semibold">5.0★</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>

  <!-- Summary Cards -->
  <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
      <h4 class="font-semibold text-gray-700 text-sm mb-1">API Usage Requests</h4>
      <p class="text-xl font-bold text-blue-600">34,256</p>
      <span class="text-xs text-gray-500">+10% from previous period</span>
    </div>

    <div class="bg-green-50 border border-green-200 rounded-lg p-4">
      <h4 class="font-semibold text-gray-700 text-sm mb-1">Active Clients</h4>
      <p class="text-xl font-bold text-green-600">764</p>
      <span class="text-xs text-gray-500">Maintaining uptime across network</span>
    </div>

    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
      <h4 class="font-semibold text-gray-700 text-sm mb-1">Average System Load</h4>
      <p class="text-xl font-bold text-yellow-600">63%</p>
      <span class="text-xs text-gray-500">Within optimal parameters</span>
    </div>
  </div>

</div>

@endsection
