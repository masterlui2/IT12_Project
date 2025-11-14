@extends('technician.layout.app')

@section('content')

<!-- Top Bar -->
<nav class="w-full bg-white shadow-sm border-b border-gray-100 px-6 py-3 flex justify-between items-center mb-4">
  <h2 class="text-xl font-semibold text-gray-800">Messages</h2>
  <button class="bg-blue-600 text-white px-4 py-2 rounded-md text-sm hover:bg-blue-700">
    + New Message
  </button>
</nav>

<div class="flex h-[calc(100vh-180px)] bg-white rounded-lg shadow-sm overflow-hidden">

  <!-- Left Panel (Inbox List) -->
  <aside class="w-1/3 border-r border-gray-100 flex flex-col">
    <!-- Search -->
    <div class="p-4 border-b">
      <input 
        type="text" 
        placeholder="Search messages..." 
        class="w-full px-3 py-2 border rounded-md text-sm focus:ring-blue-500 focus:border-blue-500"
      />
    </div>
    <!-- Message List -->
    <ul class="flex-1 overflow-y-auto divide-y">
      <li class="p-4 hover:bg-blue-50 cursor-pointer transition">
        <div class="flex justify-between items-center mb-1">
          <h4 class="font-semibold text-gray-800 text-sm">EV Station #21</h4>
          <span class="text-xs text-gray-400">2 m ago</span>
        </div>
        <p class="text-gray-600 text-sm truncate">Technician, we’re having network issues near bay 3...</p>
      </li>

      <li class="p-4 bg-blue-50 border-l-4 border-blue-600 cursor-pointer">
        <div class="flex justify-between items-center mb-1">
          <h4 class="font-semibold text-gray-800 text-sm">Admin - Support Team</h4>
          <span class="text-xs text-gray-400">15 m ago</span>
        </div>
        <p class="text-gray-600 text-sm truncate">Your quotation for RapidEV has been approved.</p>
      </li>

      <li class="p-4 hover:bg-blue-50 cursor-pointer transition">
        <div class="flex justify-between items-center mb-1">
          <h4 class="font-semibold text-gray-800 text-sm">Client - Tesla Energy</h4>
          <span class="text-xs text-gray-400">1 day ago</span>
        </div>
        <p class="text-gray-600 text-sm truncate">Thanks for sending the quotation. Awaiting final...</p>
      </li>
    </ul>
  </aside>

  <!-- Right Panel (Chat / Message View) -->
  <section class="flex-1 flex flex-col">
    <!-- Conversation Header -->
    <div class="flex items-center justify-between p-4 border-b">
      <div>
        <h3 class="font-semibold text-gray-800 text-sm">Admin – Support Team</h3>
        <p class="text-xs text-gray-400">Last message: 15 minutes ago</p>
      </div>
      <button class="text-gray-500 hover:text-red-600">
        <i class="fas fa-trash-alt"></i>
      </button>
    </div>

    <!-- Message Area -->
    <div class="flex-1 overflow-y-auto p-6 space-y-4 bg-gray-50">
      <!-- Received -->
      <div class="flex items-start space-x-3">
        <div class="w-8 h-8 rounded-full bg-gray-300 flex items-center justify-center text-gray-700 font-semibold">A</div>
        <div class="bg-white rounded-lg shadow px-4 py-2 max-w-md">
          <p class="text-sm text-gray-700">Hello Genshirog, please update the quotation report for Metro CSMS.</p>
        </div>
      </div>

      <!-- Sent -->
      <div class="flex items-start justify-end space-x-3">
        <div class="bg-blue-600 text-white rounded-lg shadow px-4 py-2 max-w-md">
          <p class="text-sm">Copy that! I’ll send the report update within the hour.</p>
        </div>
      </div>

      <!-- Received -->
      <div class="flex items-start space-x-3">
        <div class="w-8 h-8 rounded-full bg-gray-300 flex items-center justify-center text-gray-700 font-semibold">A</div>
        <div class="bg-white rounded-lg shadow px-4 py-2 max-w-md">
          <p class="text-sm text-gray-700">Perfect, thanks! You can use the latest numbers from RapidEV.</p>
        </div>
      </div>
    </div>

    <!-- Input Bar -->
    <div class="p-4 border-t flex items-center space-x-3">
      <input 
        type="text" 
        placeholder="Type your message..." 
        class="flex-1 px-4 py-2 border rounded-full text-sm focus:ring-blue-500 focus:border-blue-500"
      />
      <button class="bg-blue-600 text-white px-4 py-2 rounded-full hover:bg-blue-700">
        <i class="fas fa-paper-plane"></i>
      </button>
    </div>
  </section>

</div>

@endsection
