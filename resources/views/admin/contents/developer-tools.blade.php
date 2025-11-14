@extends('admin.layout.app')

@section('content')

<!-- Top Header -->
<nav class="w-full bg-white border-b border-gray-100 shadow-sm px-6 py-4 flex justify-between items-center mb-6">
  <div class="flex items-center space-x-2">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 17l4 4 4-4m0-10l-4-4-4 4M4 12h16" />
    </svg>
    <h2 class="text-xl font-semibold text-gray-800">Developer Tools</h2>
  </div>

  <button class="bg-blue-600 text-white px-4 py-2 rounded-md text-sm hover:bg-blue-700">
    Run Diagnostics
  </button>
</nav>


<!-- Developer Tools Content -->
<div class="p-6 space-y-8">

  <!-- Environment Overview -->
  <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
    <div class="bg-white border shadow-sm rounded-lg p-4">
      <div class="flex items-center justify-between mb-2">
        <h4 class="text-gray-700 font-semibold">Environment Mode</h4>
        <i class="fas fa-code-branch text-blue-500"></i>
      </div>
      <p class="text-sm text-gray-600">Application is currently running in:</p>
      <p class="text-md font-bold text-green-600 mt-1">Production Mode</p>
    </div>

    <div class="bg-white border shadow-sm rounded-lg p-4">
      <div class="flex items-center justify-between mb-2">
        <h4 class="text-gray-700 font-semibold">Laravel Version</h4>
        <i class="fab fa-laravel text-red-500"></i>
      </div>
      <p class="text-sm text-gray-600">Backend Framework</p>
      <p class="text-md font-semibold text-gray-800 mt-1">v10.32.1</p>
    </div>

    <div class="bg-white border shadow-sm rounded-lg p-4">
      <div class="flex items-center justify-between mb-2">
        <h4 class="text-gray-700 font-semibold">Server OS</h4>
        <i class="fas fa-server text-green-500"></i>
      </div>
      <p class="text-sm text-gray-600">Operating System</p>
      <p class="text-md font-semibold text-gray-800 mt-1">Ubuntu 22.04 LTS</p>
    </div>
  </div>


  <!-- Dev Sections -->
  <div class="grid lg:grid-cols-2 gap-6">

    <!-- API Testing Console -->
    <div class="bg-white border rounded-lg shadow-sm p-4 flex flex-col">
      <h3 class="font-semibold text-gray-700 mb-3 flex items-center gap-2">
        <i class="fas fa-terminal text-blue-500"></i> API Testing Console
      </h3>
      <p class="text-sm text-gray-500 mb-3">Send requests to test endpoints and inspect API responses directly here.</p>

      <form class="flex flex-col space-y-3">
        <div class="flex space-x-2">
          <select class="border px-3 py-2 text-sm rounded-md focus:ring-blue-500 focus:border-blue-500">
            <option>GET</option>
            <option>POST</option>
            <option>PUT</option>
            <option>DELETE</option>
          </select>
          <input type="text" class="flex-1 border px-3 py-2 rounded-md text-sm focus:ring-blue-500 focus:border-blue-500"
                 placeholder="Enter API endpoint (e.g. /api/technicians)" />
        </div>
        <textarea class="border rounded-md px-3 py-2 text-sm focus:ring-blue-500 focus:border-blue-500" 
                  rows="4" placeholder="Request body (JSON)"></textarea>
        <button type="submit" class="bg-blue-600 text-white text-sm rounded-md px-4 py-2 w-fit hover:bg-blue-700">
          Run Request
        </button>
      </form>

      <div class="mt-4 bg-gray-50 border rounded-md p-3 h-40 overflow-auto text-xs font-mono text-gray-700">
        {"response":"API output will display here"}
      </div>
    </div>

    <!-- Error Log Viewer -->
    <div class="bg-white border rounded-lg shadow-sm p-4">
      <h3 class="font-semibold text-gray-700 mb-3 flex items-center gap-2">
        <i class="fas fa-bug text-red-500"></i> Error & Exception Log
      </h3>
      <p class="text-sm text-gray-500 mb-3">Review recent application errors and exceptions for debugging purposes.</p>
      <div class="bg-gray-50 border rounded-md p-3 h-64 overflow-y-auto space-y-2 text-xs font-mono text-gray-700">
        <div>[2025-11-14 14:16:32] local.ERROR Queue timeout on SyncStationJob (#154)</div>
        <div>[2025-11-14 13:47:18] production.WARNING High CPU usage on server03</div>
        <div>[2025-11-14 13:12:00] production.INFO System cache cleared successfully</div>
      </div>
      <div class="mt-3 flex justify-end">
        <button class="text-sm text-blue-600 hover:underline">Download Logs</button>
      </div>
    </div>

  </div>


  <!-- Utilities / Maintenance Tools -->
  <div class="bg-white border rounded-lg shadow-sm p-6">
    <h3 class="font-semibold text-gray-700 mb-4 flex items-center gap-2">
      <i class="fas fa-tools text-indigo-600"></i> Maintenance Utilities
    </h3>

    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
      <button class="flex items-center justify-center gap-2 px-4 py-3 border rounded-lg hover:bg-blue-50">
        <i class="fas fa-trash text-blue-500"></i>
        <span class="font-medium text-gray-700 text-sm">Clear Cache</span>
      </button>

      <button class="flex items-center justify-center gap-2 px-4 py-3 border rounded-lg hover:bg-blue-50">
        <i class="fas fa-sync text-green-600"></i>
        <span class="font-medium text-gray-700 text-sm">Restart Queue Jobs</span>
      </button>

      <button class="flex items-center justify-center gap-2 px-4 py-3 border rounded-lg hover:bg-blue-50">
        <i class="fas fa-database text-yellow-500"></i>
        <span class="font-medium text-gray-700 text-sm">Run DB Migration</span>
      </button>

      <button class="flex items-center justify-center gap-2 px-4 py-3 border rounded-lg hover:bg-blue-50">
        <i class="fas fa-shield-alt text-red-500"></i>
        <span class="font-medium text-gray-700 text-sm">Purge Error Logs</span>
      </button>

      <button class="flex items-center justify-center gap-2 px-4 py-3 border rounded-lg hover:bg-blue-50">
        <i class="fas fa-key text-indigo-600"></i>
        <span class="font-medium text-gray-700 text-sm">Regenerate API Key</span>
      </button>

      <button class="flex items-center justify-center gap-2 px-4 py-3 border rounded-lg hover:bg-blue-50">
        <i class="fas fa-cog text-gray-500"></i>
        <span class="font-medium text-gray-700 text-sm">System Optimization</span>
      </button>
    </div>
  </div>

</div>

@endsection
