<aside class="fixed top-0 left-0 h-screen w-64 bg-white shadow-lg flex flex-col justify-between z-20">

    <!-- Logo and Title -->
    <div class="p-4 border-b border-gray-200">
        <div class="flex items-center gap-4">
            <img src="{{ asset('images/logo.png') }}" alt="Admin" class="w-14 h-14 rounded-xl">
            <div>
                <h2 class="text-xl font-bold">Technician Panel</h2>
                <p class="text-gray-500 text-sm">Business Operations</p>
            </div>
        </div>
    </div>

    <!-- Navigation -->
    <nav class="flex-1 overflow-y-auto px-6 py-4">
        <ul class="space-y-2 text-gray-700">

            <li>
                <a href="{{ route('technician.dashboard') }}" 
                    class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-blue-50 transition">
                    <i class="fas fa-gauge text-blue-500"></i>
                    <span class="text-md font-medium">Dashboard</span>
                </a>
            </li>

            <li>
                <a href="{{ route('technician.messages') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-blue-50 transition">
                    <i class="fas fa-envelope text-blue-500"></i>
                    <span class="text-md font-medium">Messages</span>
                </a>
            </li>

            <li>
                <a href="{{ route('technician.inquire') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-blue-50 transition">
                    <i class="fas fa-question-circle text-blue-500"></i>
                    <span class="text-md font-medium">Inquiries</span>
                </a>
            </li>

            <li>
                <a href="{{ route('technician.quotation') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-blue-50 transition">
                    <i class="fas fa-file-invoice text-blue-500"></i>
                    <span class="text-md font-medium">Quotation</span>
                </a>
            </li>

            <li>
                <a href="{{ route('technician.reporting') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-blue-50 transition">
                    <i class="fas fa-chart-line text-blue-500"></i>
                    <span class="text-md font-medium">Reporting</span>
                </a>
            </li>

            <li>
                <a href="{{ route('technician.history') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-blue-50 transition">
                    <i class="fas fa-clock-rotate-left text-blue-500"></i>
                    <span class="text-md font-medium">History</span>
                </a>
            </li>

        </ul>
    </nav>

    <!-- User Info -->
    <div class="border-t border-gray-200 px-6 py-4 flex items-center gap-4">
        <div class="w-12 h-12 flex items-center justify-center rounded-full text-[#155DFC] font-bold text-lg bg-[#DBEAFE] bg-opacity-50">
            A
        </div>
        <div class="flex flex-col">
            <span class="font-semibold">Administrator</span>
            <span class="text-gray-500 text-sm">Administrator</span>
        </div>
    </div>

    <!-- Sign Out Button -->
    <div class="px-6 py-2">
        <a href="#">
            <button class="w-full text-gray-600 px-4 py-2 rounded-lg hover:bg-red-600 hover:text-white transition flex items-center gap-2">
                <i class="fas fa-right-from-bracket"></i> Sign out
            </button>
        </a>
    </div>

</aside>
