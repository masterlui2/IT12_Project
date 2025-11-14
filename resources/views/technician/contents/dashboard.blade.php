@extends('technician.layout.app')

@section('content')

<!-- Top Navigation -->
<nav class="w-full bg-white shadow-sm border-b border-gray-100 px-6 py-3 flex justify-between items-center mb-6">
  <div class="flex items-center space-x-2">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M3 12l2-2m0 0l7-7 7 7M13 5l7 7-7 7-7-7" />
    </svg>
    <h2 class="text-xl font-semibold text-gray-800">Technician Dashboard</h2>
  </div>

  <div class="flex items-center gap-3">
    <select class="px-3 py-2 border rounded-md text-sm focus:ring-blue-500 focus:border-blue-500">
      <option>Today</option>
      <option>This Week</option>
      <option>This Month</option>
    </select>
    <button class="bg-blue-600 text-white px-4 py-2 rounded-md text-sm hover:bg-blue-700">
      Refresh
    </button>
  </div>
</nav>


<!-- Dashboard Overview -->
<div class="flex flex-col space-y-6">

  <!-- Stat Cards -->
  <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
    <!-- Quotations -->
    <div class="bg-white rounded-lg border shadow-sm p-4 flex flex-col">
      <div class="flex items-center justify-between">
        <h4 class="text-sm text-gray-600 font-medium">Total Quotations</h4>
        <i class="fas fa-file-invoice text-blue-500 text-lg"></i>
      </div>
      <p class="text-2xl font-semibold text-gray-800 mt-1">124</p>
      <span class="text-xs text-green-600 mt-1 flex items-center"><i class="fas fa-arrow-up mr-1"></i>+6% this month</span>
    </div>

    <!-- Inquiries -->
    <div class="bg-white rounded-lg border shadow-sm p-4 flex flex-col">
      <div class="flex items-center justify-between">
        <h4 class="text-sm text-gray-600 font-medium">New Inquiries</h4>
        <i class="fas fa-question-circle text-yellow-500 text-lg"></i>
      </div>
      <p class="text-2xl font-semibold text-gray-800 mt-1">34</p>
      <span class="text-xs text-blue-600 mt-1">5 awaiting response</span>
    </div>

    <!-- Completed Tasks -->
    <div class="bg-white rounded-lg border shadow-sm p-4 flex flex-col">
      <div class="flex items-center justify-between">
        <h4 class="text-sm text-gray-600 font-medium">Tasks Completed</h4>
        <i class="fas fa-check-circle text-green-500 text-lg"></i>
      </div>
      <p class="text-2xl font-semibold text-gray-800 mt-1">18</p>
      <span class="text-xs text-green-600 mt-1">2 more than yesterday</span>
    </div>

    <!-- Active Stations -->
    <div class="bg-white rounded-lg border shadow-sm p-4 flex flex-col">
      <div class="flex items-center justify-between">
        <h4 class="text-sm text-gray-600 font-medium">Online Stations</h4>
        <i class="fas fa-charging-station text-indigo-500 text-lg"></i>
      </div>
      <p class="text-2xl font-semibold text-gray-800 mt-1">27</p>
      <span class="text-xs text-green-600 mt-1">+2 since last check</span>
    </div>
  </div>

  <!-- Charts Section -->
  <div class="grid lg:grid-cols-2 gap-6">
    <!-- Daily Tasks -->
    <div class="bg-white rounded-lg border shadow-sm p-4">
      <h3 class="font-semibold text-gray-700 mb-3">Daily Activity Overview</h3>
      <div class="flex items-center justify-center h-64 bg-gray-50 text-gray-400 rounded-md">
        [Chart Placeholder – Tasks per Day]
      </div>
    </div>

    <!-- Performance Summary -->
    <div class="bg-white rounded-lg border shadow-sm p-4">
      <h3 class="font-semibold text-gray-700 mb-3">Performance Summary</h3>
      <div class="flex items-center justify-center h-64 bg-gray-50 text-gray-400 rounded-md">
        [Chart Placeholder – Performance Rate Pie]
      </div>
    </div>
  </div>

  <!-- Recent Activity Log -->
  <div class="bg-white rounded-lg border shadow-sm">
    <div class="p-4 border-b flex justify-between items-center">
      <h3 class="font-semibold text-gray-700">Recent Technician Activity</h3>
      <button class="text-blue-600 hover:underline text-sm">View All</button>
    </div>
    <div class="divide-y text-sm">
      <div class="flex justify-between px-6 py-3 hover:bg-gray-50">
        <p class="text-gray-700 flex items-center gap-2"><i class="fas fa-tools text-blue-500"></i> Completed maintenance at Station # 15</p>
        <span class="text-xs text-gray-500">Today • 1 PM</span>
      </div>
      <div class="flex justify-between px-6 py-3 hover:bg-gray-50">
        <p class="text-gray-700 flex items-center gap-2"><i class="fas fa-file-invoice text-green-500"></i> Quotation approved – RapidEV</p>
        <span class="text-xs text-gray-500">Today • 10 AM</span>
      </div>
      <div class="flex justify-between px-6 py-3 hover:bg-gray-50">
        <p class="text-gray-700 flex items-center gap-2"><i class="fas fa-bell text-yellow-500"></i> Inquiry received from Tesla Energy</p>
        <span class="text-xs text-gray-500">Yesterday • 3 PM</span>
      </div>
    </div>
  </div>

</div>

@endsection
