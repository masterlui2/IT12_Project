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
                    <h2 class="text-xl font-bold">Admin Panel</h2>
                    <p class="text-gray-500 text-sm">Business Operations</p>
                </div>
            </div>
        </div>
        <div class="border-b border-gray-300"></div>
        <!-- Menu Items -->
        <nav class="flex-1 px-6 py-4">
            <ul class="space-y-8">
                <li class="flex items-center gap-4 px-4 py-3 rounded-lg hover:bg-blue-50 cursor-pointer">
                    <span class="text-xl font-medium"><i class="fas fa-gauge"></i> Dashboard</span>
                </li>
                <li class="flex items-center gap-4 px-4 py-3 rounded-lg hover:bg-blue-50 cursor-pointer">
                    <span class="text-xl font-medium"><i class="fas fa-user"></i>Employee</span>
                </li>
                <li class="flex items-center gap-4 px-4 py-3 rounded-lg hover:bg-blue-50 cursor-pointer">
                    <span class="text-xl font-medium"><i class="fas fa-book"></i>Logs</span>
                </li>
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
