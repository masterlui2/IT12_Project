<!-- Sidebar: fixed / scrollable -->
  <aside class="fixed top-0 left-0 h-screen w-64 bg-white shadow-lg flex flex-col justify-between z-20">

    <!-- Top Section: Logo -->
    <div class="p-4">
      <div class="flex items-center gap-4">
        <img src="{{ asset('images/logo.png') }}" alt="Admin" class="w-14 h-14 rounded-xl">
        <div class="flex flex-col">
          <h2 class="text-xl font-bold">Administrator Panel</h2>
          <p class="text-gray-500 text-sm">Business Operations</p>
        </div>
      </div>
    </div>

    <div class="border-b border-gray-300"></div>

    <!-- Menu Items (scrollable if long) -->
    <nav class="flex-1 overflow-y-auto px-6 py-4">
      <ul class="space-y-2 text-gray-700">

        <li><a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-blue-50">
          <i class="fas fa-gauge text-blue-500"></i> <span>Dashboard</span></a></li>

        <li><a href="{{ route('admin.systemManagement') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-blue-50">
          <i class="fas fa-cogs text-blue-500"></i> <span>System&nbsp;Management</span></a></li>

        <li><a href="{{ route('admin.userAccess') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-blue-50">
          <i class="fas fa-users text-blue-500"></i> <span>User&nbsp;&amp;&nbsp;Access</span></a></li>

        <li><a href="{{ route('admin.activity') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-blue-50">
          <i class="fas fa-clipboard-list text-blue-500"></i> <span>Activity&nbsp;Logs</span></a></li>

        <li><a href="{{ route('admin.analytics') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-blue-50">
          <i class="fas fa-chart-bar text-blue-500"></i> <span>Analytics</span></a></li>

        <li><a href="{{ route('admin.developerTools') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-blue-50">
          <i class="fas fa-terminal text-blue-500"></i> <span>Developer&nbsp;Tools</span></a></li>

        <li><a href="{{ route('admin.documentation') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-blue-50">
          <i class="fas fa-book text-blue-500"></i> <span>Documentation</span></a></li>

      </ul>
    </nav>

    <!-- Bottom Section: User Info -->
    <div class="border-t border-gray-200 px-6 py-4 flex items-center gap-4">
      <div class="w-12 h-12 flex items-center justify-center rounded-full text-[#155DFC] font-bold text-lg bg-[#DBEAFE] bg-opacity-50">A</div>
      <div class="flex flex-col">
        <h2 class="font-semibold">Administrator</h2>
        <p class="text-gray-500 text-sm">Administrator</p>
      </div>
    </div>

    <!-- Sign Out -->
    <div class="px-6 py-2">
      <a href="#">
        <button class="text-gray-600 px-4 py-2 rounded-lg hover:bg-red-600 hover:text-white transition w-full flex items-center gap-2 text-left">
          <i class="fas fa-right-from-bracket"></i> Sign out
        </button>
      </a>
    </div>

  </aside>