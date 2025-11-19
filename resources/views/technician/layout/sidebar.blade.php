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
                class="flex items-center gap-3 px-4 py-3 rounded-lg transition
                    {{ Route::is('technician.dashboard') ? 'bg-blue-100 text-blue-700 font-semibold' : 'hover:bg-blue-50 text-gray-700' }}">
                    <i class="fas fa-gauge {{ Route::is('technician.dashboard') ? 'text-blue-700' : 'text-blue-500' }}"></i>
                <span class="text-md font-medium">Dashboard</span>
            </a>
          </li>

          <li>
            <a href="{{ route('technician.messages') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-lg transition
                    {{ Route::is('technician.messages') ? 'bg-blue-100 text-blue-700 font-semibold' : 'hover:bg-blue-50 text-gray-700' }}">
                    <i class="fas fa-envelope {{ Route::is('technician.messages') ? 'text-blue-700' : 'text-blue-500' }}"></i>
                <span class="text-md font-medium">Messages</span>
            </a>
        </li>

            <li>
                <a href="{{ route('technician.inquire') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-lg transition
                    {{ Route::is('technician.inquire') ? 'bg-blue-100 text-blue-700 font-semibold' : 'hover:bg-blue-50 text-gray-700' }}">
                    <i class="fas fa-question-circle {{ Route::is('technician.inquire') ? 'text-blue-700' : 'text-blue-500' }}"></i>
                    <span class="text-md font-medium">Inquiries</span>
                </a>
            </li>

            <li>
                <a href="{{ route('technician.quotation') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-lg transition relative
                    {{ Route::is('technician.quotation*') || Route::is('quotation.*') ? 'bg-blue-100 text-blue-700 font-semibold' : 'hover:bg-blue-50 text-gray-700' }}">
                    @if(Route::is('technician.quotation*') || Route::is('quotation.*'))
                    @endif
                    <i class="fas fa-file-invoice {{ Route::is('technician.quotation*') || Route::is('quotation.*') ? 'text-blue-700' : 'text-blue-500' }}"></i>
                    <span class="text-md font-medium ml-2">Quotation</span>
                </a>
            </li>

            <li>
                <a href="{{ route('technician.reporting') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-lg transition
                    {{ Route::is('technician.reporting') ? 'bg-blue-100 text-blue-700 font-semibold' : 'hover:bg-blue-50 text-gray-700' }}">
                    <i class="fas fa-chart-line {{ Route::is('technician.reporting') ? 'text-blue-700' : 'text-blue-500' }}"></i>
                    <span class="text-md font-medium">Reporting</span>
                </a>
            </li>

            <li>
                <a href="{{ route('technician.history') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-lg transition
                    {{ Route::is('technician.history') ? 'bg-blue-100 text-blue-700 font-semibold' : 'hover:bg-blue-50 text-gray-700' }}">
                    <i class="fas fa-clock-rotate-left {{ Route::is('technician.history') ? 'text-blue-700' : 'text-blue-500' }}"></i>
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
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button class="w-full text-gray-600 px-4 py-2 rounded-lg hover:bg-red-600 hover:text-white transition flex items-center gap-2">
                <i class="fas fa-right-from-bracket"></i> Sign out
            </button>
        </form>
    </div>

</aside>
