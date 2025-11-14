@extends('admin.layout.app')

@section('content')

<!-- Top Bar -->
<nav class="w-full bg-white border-b border-gray-100 shadow-sm px-6 py-4 flex justify-between items-center mb-6">
  <div class="flex items-center space-x-2">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M16 11V7a4 4 0 00-8 0v4m12 10H4a2 2 0 01-2-2V11h16v8a2 2 0 01-2 2z" />
    </svg>
    <h2 class="text-xl font-semibold text-gray-800">User & Access Management</h2>
  </div>

  <button class="bg-blue-600 text-white px-4 py-2 rounded-md text-sm hover:bg-blue-700">
    + Add User
  </button>
</nav>

<!-- Main Management Content -->
<div class="p-6 space-y-6">

  <!-- Roles Summary Cards -->
  <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
    <div class="bg-white border shadow-sm rounded-lg p-4 flex flex-col justify-between">
      <h4 class="text-gray-600 text-sm font-medium mb-2">Administrators</h4>
      <p class="text-2xl font-bold text-gray-800">5</p>
      <span class="text-xs text-green-600 flex items-center mt-1"><i class="fas fa-arrow-up mr-1"></i> +1 this month</span>
    </div>
    <div class="bg-white border shadow-sm rounded-lg p-4 flex flex-col justify-between">
      <h4 class="text-gray-600 text-sm font-medium mb-2">Technicians</h4>
      <p class="text-2xl font-bold text-gray-800">32</p>
      <span class="text-xs text-blue-600 mt-1">Active Technicians</span>
    </div>
    <div class="bg-white border shadow-sm rounded-lg p-4 flex flex-col justify-between">
      <h4 class="text-gray-600 text-sm font-medium mb-2">Managers</h4>
      <p class="text-2xl font-bold text-gray-800">7</p>
      <span class="text-xs text-yellow-600 mt-1">1 newly added</span>
    </div>
    <div class="bg-white border shadow-sm rounded-lg p-4 flex flex-col justify-between">
      <h4 class="text-gray-600 text-sm font-medium mb-2">Clients</h4>
      <p class="text-2xl font-bold text-gray-800">120</p>
      <span class="text-xs text-green-600 mt-1">Steady this week</span>
    </div>
  </div>

  <!-- Users Table -->
  <div class="bg-white border rounded-lg shadow-sm">
    <div class="p-4 border-b flex justify-between items-center">
      <h3 class="font-semibold text-gray-700">Registered Users</h3>
      <input type="text" placeholder="Search user by name or email" 
        class="px-3 py-2 border rounded-md text-sm focus:ring-blue-500 focus:border-blue-500 w-64"/>
    </div>

    <div class="overflow-x-auto">
      <table class="w-full text-left text-sm">
        <thead class="bg-gray-100 text-gray-700">
          <tr>
            <th class="px-6 py-3">User ID</th>
            <th class="px-6 py-3">Name</th>
            <th class="px-6 py-3">Email</th>
            <th class="px-6 py-3">Role</th>
            <th class="px-6 py-3">Status</th>
            <th class="px-6 py-3 text-right">Actions</th>
          </tr>
        </thead>
        <tbody class="divide-y">
          <tr class="hover:bg-gray-50">
            <td class="px-6 py-4 text-gray-700 font-medium">USR‑0001</td>
            <td class="px-6 py-4">Alex Reyes</td>
            <td class="px-6 py-4 text-gray-600">alex@csms.com</td>
            <td class="px-6 py-4"><span class="bg-blue-100 text-blue-700 px-2 py-1 rounded text-xs">Technician</span></td>
            <td class="px-6 py-4"><span class="bg-green-100 text-green-700 px-2 py-1 rounded text-xs">Active</span></td>
            <td class="px-6 py-4 text-right space-x-2">
              <button class="text-blue-600 hover:underline text-sm">Edit</button>
              <button class="text-red-500 hover:underline text-sm">Delete</button>
            </td>
          </tr>

          <tr class="hover:bg-gray-50">
            <td class="px-6 py-4 text-gray-700 font-medium">USR‑0002</td>
            <td class="px-6 py-4">Jamie Tanaka</td>
            <td class="px-6 py-4 text-gray-600">jamie@csms.com</td>
            <td class="px-6 py-4"><span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded text-xs">Manager</span></td>
            <td class="px-6 py-4"><span class="bg-green-100 text-green-700 px-2 py-1 rounded text-xs">Active</span></td>
            <td class="px-6 py-4 text-right space-x-2">
              <button class="text-blue-600 hover:underline text-sm">Edit</button>
              <button class="text-red-500 hover:underline text-sm">Delete</button>
            </td>
          </tr>

          <tr class="hover:bg-gray-50">
            <td class="px-6 py-4 text-gray-700 font-medium">USR‑0003</td>
            <td class="px-6 py-4">Charles Grey</td>
            <td class="px-6 py-4 text-gray-600">c.grey@csms.com</td>
            <td class="px-6 py-4"><span class="bg-green-100 text-green-700 px-2 py-1 rounded text-xs">Administrator</span></td>
            <td class="px-6 py-4"><span class="bg-red-100 text-red-700 px-2 py-1 rounded text-xs">Suspended</span></td>
            <td class="px-6 py-4 text-right space-x-2">
              <button class="text-blue-600 hover:underline text-sm">Edit</button>
              <button class="text-red-500 hover:underline text-sm">Delete</button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- Pagination -->
    <div class="border-t bg-white px-6 py-3 flex justify-between items-center text-sm text-gray-500">
      <p>Showing 1–3 of 120 users</p>
      <div class="space-x-1">
        <button class="px-2 py-1 border rounded hover:bg-gray-100">Prev</button>
        <button class="px-2 py-1 border rounded bg-blue-600 text-white">1</button>
        <button class="px-2 py-1 border rounded hover:bg-gray-100">2</button>
        <button class="px-2 py-1 border rounded hover:bg-gray-100">Next</button>
      </div>
    </div>
  </div>

  <!-- Role Permissions Overview -->
  <div class="bg-white border rounded-lg shadow-sm p-6">
    <h3 class="font-semibold text-gray-700 mb-4">Role Permissions Matrix</h3>
    
    <div class="overflow-x-auto">
      <table class="w-full text-left text-sm">
        <thead class="bg-gray-100 text-gray-700">
          <tr>
            <th class="px-6 py-3">Feature</th>
            <th class="px-6 py-3 text-center">Administrator</th>
            <th class="px-6 py-3 text-center">Manager</th>
            <th class="px-6 py-3 text-center">Technician</th>
            <th class="px-6 py-3 text-center">Client</th>
          </tr>
        </thead>
        <tbody class="divide-y">
          <tr>
            <td class="px-6 py-3">Create Quotation</td>
            <td class="text-center">✅</td><td class="text-center">✅</td><td class="text-center">✅</td><td class="text-center">❌</td>
          </tr>
          <tr>
            <td class="px-6 py-3">View Reports</td>
            <td class="text-center">✅</td><td class="text-center">✅</td><td class="text-center">❌</td><td class="text-center">❌</td>
          </tr>
          <tr>
            <td class="px-6 py-3">Configure System</td>
            <td class="text-center">✅</td><td class="text-center">❌</td><td class="text-center">❌</td><td class="text-center">❌</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>

</div>

@endsection
