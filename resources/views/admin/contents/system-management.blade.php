@extends('admin.layout.app')

@section('content')

<!-- Top Navigation Header -->
<nav class="w-full bg-white border-b border-gray-100 shadow-sm px-6 py-4 flex justify-between items-center mb-6">
  <div class="flex items-center space-x-2">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
        d="M3 13a4 4 0 018 0m0 0a4 4 0 008 0m-8 0v8m0-8V5" />
    </svg>
    <h2 class="text-xl font-semibold text-gray-800">System Management</h2>
  </div>

  <button class="bg-blue-600 text-white px-4 py-2 rounded-md text-sm hover:bg-blue-700">
    Check System Health
  </button>
</nav>


<!-- Main System Management Content -->
<div class="p-6 space-y-6">

  <!-- System Control Cards -->
  <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
    <!-- Server -->
    <div class="bg-white border rounded-lg shadow-sm p-4 flex flex-col justify-between">
      <div class="flex items-center justify-between mb-3">
        <h4 class="text-gray-700 font-semibold">Server Status</h4>
        <i class="fas fa-server text-blue-500"></i>
      </div>
      <p class="text-sm text-gray-600 mb-4">Current uptime, CPU and memory utilization.</p>
      <div class="flex justify-between items-center">
        <span class="text-green-600 font-semibold text-sm">Online • 99.9%</span>
        <button class="text-blue-600 text-sm hover:underline">View Details</button>
      </div>
    </div>

    <!-- Database -->
    <div class="bg-white border rounded-lg shadow-sm p-4 flex flex-col justify-between">
      <div class="flex items-center justify-between mb-3">
        <h4 class="text-gray-700 font-semibold">Database Sync</h4>
        <i class="fas fa-database text-green-500"></i>
      </div>
      <p class="text-sm text-gray-600 mb-4">Monitor connection and replication status.</p>
      <div class="flex justify-between items-center">
        <span class="text-green-600 font-semibold text-sm">Synchronized</span>
        <button class="text-blue-600 text-sm hover:underline">Run Sync Now</button>
      </div>
    </div>

    <!-- Queue -->
    <div class="bg-white border rounded-lg shadow-sm p-4 flex flex-col justify-between">
      <div class="flex items-center justify-between mb-3">
        <h4 class="text-gray-700 font-semibold">Queue Jobs</h4>
        <i class="fas fa-tasks text-yellow-500"></i>
      </div>
      <p class="text-sm text-gray-600 mb-4">Queued tasks, failed jobs and retry cycles.</p>
      <div class="flex justify-between items-center">
        <span class="text-yellow-600 font-semibold text-sm">3 Failed Jobs</span>
        <button class="text-blue-600 text-sm hover:underline">Retry All</button>
      </div>
    </div>

    <!-- Backups -->
    <div class="bg-white border rounded-lg shadow-sm p-4 flex flex-col justify-between">
      <div class="flex items-center justify-between mb-3">
        <h4 class="text-gray-700 font-semibold">Backups and Recovery</h4>
        <i class="fas fa-archive text-indigo-500"></i>
      </div>
      <p class="text-sm text-gray-600 mb-4">Manual and automatic system backups with timestamps.</p>
      <div class="flex justify-between items-center">
        <span class="text-green-600 font-semibold text-sm">Last Backup: 2 hrs ago</span>
        <button class="text-blue-600 text-sm hover:underline">Create Backup</button>
      </div>
    </div>

    <!-- Configuration -->
    <div class="bg-white border rounded-lg shadow-sm p-4 flex flex-col justify-between">
      <div class="flex items-center justify-between mb-3">
        <h4 class="text-gray-700 font-semibold">System Configuration</h4>
        <i class="fas fa-cogs text-teal-500"></i>
      </div>
      <p class="text-sm text-gray-600 mb-4">Edit .env variables, API keys, and service configs.</p>
      <div class="flex justify-between items-center">
        <span class="text-blue-600 font-semibold text-sm">25 parameters</span>
        <button class="text-blue-600 text-sm hover:underline">Modify</button>
      </div>
    </div>

    <!-- Integrations -->
    <div class="bg-white border rounded-lg shadow-sm p-4 flex flex-col justify-between">
      <div class="flex items-center justify-between mb-3">
        <h4 class="text-gray-700 font-semibold">Integrations Health</h4>
        <i class="fas fa-link text-purple-500"></i>
      </div>
      <p class="text-sm text-gray-600 mb-4">External APIs and services status monitoring.</p>
      <div class="flex justify-between items-center">
        <span class="text-green-600 font-semibold text-sm">All APIs Operational</span>
        <button class="text-blue-600 text-sm hover:underline">Refresh</button>
      </div>
    </div>
  </div>


  <!-- System Logs Section -->
  <div class="bg-white border rounded-lg shadow-sm">
    <div class="p-4 border-b flex justify-between items-center">
      <h3 class="font-semibold text-gray-700">Recent System Logs</h3>
      <button class="text-blue-600 hover:underline text-sm">View All</button>
    </div>

    <div class="overflow-x-auto">
      <table class="w-full text-left text-sm">
        <thead class="bg-gray-100 text-gray-700">
          <tr>
            <th class="px-6 py-3">Timestamp</th>
            <th class="px-6 py-3">Module</th>
            <th class="px-6 py-3">Message</th>
            <th class="px-6 py-3">Level</th>
          </tr>
        </thead>
        <tbody class="divide-y">
          <tr class="hover:bg-gray-50">
            <td class="px-6 py-3 text-gray-500">2025‑11‑14 13:22</td>
            <td class="px-6 py-3 text-gray-800">Database</td>
            <td class="px-6 py-3 text-gray-600">Replication check completed.</td>
            <td class="px-6 py-3"><span class="bg-green-100 text-green-700 px-2 py-1 rounded text-xs">Info</span></td>
          </tr>
          <tr class="hover:bg-gray-50">
            <td class="px-6 py-3 text-gray-500">2025‑11‑14 13:05</td>
            <td class="px-6 py-3 text-gray-800">Queue</td>
            <td class="px-6 py-3 text-gray-600">Job #152 failed – timeout error.</td>
            <td class="px-6 py-3"><span class="bg-red-100 text-red-700 px-2 py-1 rounded text-xs">Error</span></td>
          </tr>
          <tr class="hover:bg-gray-50">
            <td class="px-6 py-3 text-gray-500">2025‑11‑14 12:48</td>
            <td class="px-6 py-3 text-gray-800">System Config</td>
            <td class="px-6 py-3 text-gray-600">Environment variables updated by Admin #02.</td>
            <td class="px-6 py-3"><span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded text-xs">Warning</span></td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>

</div>

@endsection
