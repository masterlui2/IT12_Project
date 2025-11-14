@extends('admin.layout.app')

@section('content')

<!-- Top Bar -->
<nav class="w-full bg-white border-b border-gray-100 shadow-sm px-6 py-4 flex justify-between items-center mb-6">
  <div class="flex items-center space-x-2">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M12 4v16m8-8H4" />
    </svg>
    <h2 class="text-xl font-semibold text-gray-800">Developer Documentation</h2>
  </div>

  <div class="flex items-center gap-3">
    <input type="text" placeholder="Search topics..." 
           class="px-3 py-2 border rounded-md text-sm focus:ring-blue-500 focus:border-blue-500 w-64"/>
    <button class="bg-blue-600 text-white px-4 py-2 rounded-md text-sm hover:bg-blue-700">
      + New Doc Entry
    </button>
  </div>
</nav>


<!-- Main Documentation Page -->
<div class="p-6 space-y-8">

  <!-- Overview -->
  <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
    <h3 class="font-semibold text-gray-800 mb-1">Welcome to CSMS Developer Docs</h3>
    <p class="text-sm text-gray-600 leading-relaxed">
      Access technical integration details, API references, configuration steps and platform architecture documentation.  
      Use this space to guide developers and maintain system consistency across environments.
    </p>
  </div>

  <!-- Documentation Grid -->
  <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">

    <!-- API Documentation -->
    <div class="bg-white rounded-lg border shadow-sm p-4 flex flex-col justify-between cursor-pointer hover:shadow-md transition">
      <div class="flex items-center justify-between mb-3">
        <h4 class="font-semibold text-gray-800">API Reference</h4>
        <i class="fas fa-plug text-blue-500"></i>
      </div>
      <p class="text-sm text-gray-600 mb-4">Endpoints, authentication methods, and data payload formats.</p>
      <a href="#" class="text-sm text-blue-600 hover:underline">View API Docs →</a>
    </div>

    <!-- Installation & Setup -->
    <div class="bg-white rounded-lg border shadow-sm p-4 flex flex-col justify-between cursor-pointer hover:shadow-md transition">
      <div class="flex items-center justify-between mb-3">
        <h4 class="font-semibold text-gray-800">System Setup</h4>
        <i class="fas fa-cogs text-indigo-500"></i>
      </div>
      <p class="text-sm text-gray-600 mb-4">Local/server installation, environment variables (.env) and dependencies.</p>
      <a href="#" class="text-sm text-blue-600 hover:underline">Read Setup Guide →</a>
    </div>

    <!-- Database Schema -->
    <div class="bg-white rounded-lg border shadow-sm p-4 flex flex-col justify-between cursor-pointer hover:shadow-md transition">
      <div class="flex items-center justify-between mb-3">
        <h4 class="font-semibold text-gray-800">Database Schema</h4>
        <i class="fas fa-database text-green-600"></i>
      </div>
      <p class="text-sm text-gray-600 mb-4">CSMS DB diagram, tables relations and migration models.</p>
      <a href="#" class="text-sm text-blue-600 hover:underline">View Schema →</a>
    </div>

    <!-- Integration Guides -->
    <div class="bg-white rounded-lg border shadow-sm p-4 flex flex-col justify-between cursor-pointer hover:shadow-md transition">
      <div class="flex items-center justify-between mb-3">
        <h4 class="font-semibold text-gray-800">Integration Guides</h4>
        <i class="fas fa-link text-purple-500"></i>
      </div>
      <p class="text-sm text-gray-600 mb-4">Connecting CSMS with external EVSE, IoT, and billing systems.</p>
      <a href="#" class="text-sm text-blue-600 hover:underline">Open Guide →</a>
    </div>

    <!-- Version Control -->
    <div class="bg-white rounded-lg border shadow-sm p-4 flex flex-col justify-between cursor-pointer hover:shadow-md transition">
      <div class="flex items-center justify-between mb-3">
        <h4 class="font-semibold text-gray-800">Version Control</h4>
        <i class="fas fa-code-branch text-teal-500"></i>
      </div>
      <p class="text-sm text-gray-600 mb-4">Deployment workflow and branch structure for developers.</p>
      <a href="#" class="text-sm text-blue-600 hover:underline">View Workflow →</a>
    </div>

    <!-- Release Notes -->
    <div class="bg-white rounded-lg border shadow-sm p-4 flex flex-col justify-between cursor-pointer hover:shadow-md transition">
      <div class="flex items-center justify-between mb-3">
        <h4 class="font-semibold text-gray-800">Release Notes</h4>
        <i class="fas fa-scroll text-yellow-500"></i>
      </div>
      <p class="text-sm text-gray-600 mb-4">Changelog of new features, bug fixes and security updates.</p>
      <a href="#" class="text-sm text-blue-600 hover:underline">See All Releases →</a>
    </div>
  </div>


  <!-- Example Content Viewer / Markdown Section -->
  <div class="bg-white border rounded-lg shadow-sm p-6">
    <h3 class="font-semibold text-gray-800 mb-3">Viewing: API Reference</h3>
    <pre class="bg-gray-50 border rounded-md p-4 text-xs font-mono text-gray-700 overflow-x-auto">
# Example: Retrieve Charging Station Info
GET /api/stations/{station_id}

Headers:
Authorization: Bearer {token}

Response:
{
  "station_id": 112,
  "status": "active",
  "connected_devices": 7,
  "last_checked": "2025-11-14T14:00:51Z"
}
    </pre>
  </div>

</div>

@endsection
