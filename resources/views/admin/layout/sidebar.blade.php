<div class="flex h-screen bg-gray-100">

    <!-- Sidebar -->
    <aside class="w-64 bg-white shadow-lg flex flex-col justify-between">
        
        <!-- Top Section: Logo -->
        <div class="p-4">
            <div class="flex items-center gap-4">
                <!-- Image on the left -->
                <img src="{{ asset('images/logo.png') }}" alt="Admin" class="w-14 h-14 rounded-xl">

                <!-- Text on the right -->
                <div class="flex flex-col">
                    <h2 class="text-xl font-bold">Administrator Panel</h2>
                    <p class="text-gray-500 text-sm">Business Operations</p>
                </div>
            </div>
        </div>
        <div class="border-b border-gray-300"></div>
        <!-- Menu Items -->
        <nav class="flex-1 px-6 py-4">
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
                <!-- User Info with Glowing Circle -->
        <div class="px-6 py-4 border-t border-gray-200 mt-auto flex items-center gap-4">
            <!-- Glowing Circle with A -->
            <div class="w-12 h-12 flex items-center justify-center rounded-full text-[#155DFC] font-bold text-lg bg-[#DBEAFE] bg-opacity-50">
                A
            </div>

            <!-- User Info -->
            <div class="flex flex-col">
                <h2 class="font-semibold">Administrator</h2>
                <p class="text-gray-500 text-sm">Administrator</p>
            </div>
        </div>

        <!-- Sign Out Section -->
        <div class="px-6 py-2 flex text-left">
            <a href="" class="block">
                <button class="text-gray-600 px-4 mb-4 rounded hover:bg-red-600 transition"><i class="fas fa-right-from-bracket text-gray-500"></i> Sign out</button>
            </a>
        </div>

    </aside>
</div>
