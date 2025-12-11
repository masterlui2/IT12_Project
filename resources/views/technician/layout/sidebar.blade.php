<aside class="fixed top-0 left-0 h-screen w-64 bg-white border-r border-gray-100 flex flex-col justify-between z-20 transition-all duration-200">

    <!-- Logo and Title -->
    <div class="p-5 border-b border-gray-100">
        <div class="flex items-center gap-3">
            <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-blue-50 to-blue-100 flex items-center justify-center border border-blue-100">
                <img src="{{ asset('images/logo.png') }}" alt="Admin" class="w-10 h-10">
            </div>
            <div>
                <h2 class="text-lg font-semibold text-gray-900">Technician Panel</h2>
                <p class="text-gray-400 text-xs font-medium tracking-wide">Business Operations</p>
            </div>
        </div>
    </div>

    <!-- Navigation -->
    <nav class="flex-1 overflow-y-auto px-4 py-6">
        <ul class="space-y-1">
            <li>
                <a href="{{ route('technician.dashboard') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group
                    {{ Route::is('technician.dashboard') ? 'bg-blue-50 text-blue-700 border-l-4 border-blue-500' : 'hover:bg-gray-50 text-gray-700' }}">
                    <div class="w-8 h-8 flex items-center justify-center rounded-lg
                        {{ Route::is('technician.dashboard') ? 'bg-blue-100 text-blue-700' : 'bg-gray-100 text-gray-500 group-hover:bg-blue-50 group-hover:text-blue-600' }}">
                        <i class="fas fa-gauge text-sm"></i>
                    </div>
                    <span class="text-sm font-medium">Dashboard</span>
                </a>
            </li>

            <li>
                <a href="{{ route('technician.messages') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group
                    {{ Route::is('technician.messages') ? 'bg-blue-50 text-blue-700 border-l-4 border-blue-500' : 'hover:bg-gray-50 text-gray-700' }}">
                    <div class="w-8 h-8 flex items-center justify-center rounded-lg
                        {{ Route::is('technician.messages') ? 'bg-blue-100 text-blue-700' : 'bg-gray-100 text-gray-500 group-hover:bg-blue-50 group-hover:text-blue-600' }}">
                        <i class="fas fa-envelope text-sm"></i>
                    </div>
                    <span class="text-sm font-medium">Messages</span>
                </a>
            </li>

            <li>
                <a href="{{ route('technician.inquire.index') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group relative
                    {{ Route::is('technician.inquire*') ? 'bg-blue-50 text-blue-700 border-l-4 border-blue-500' : 'hover:bg-gray-50 text-gray-700' }}">
                    <div class="relative">
                        <div class="w-8 h-8 flex items-center justify-center rounded-lg
                            {{ Route::is('technician.inquire*') ? 'bg-blue-100 text-blue-700' : 'bg-gray-100 text-gray-500 group-hover:bg-blue-50 group-hover:text-blue-600' }}">
                            <i class="fas fa-question-circle text-sm"></i>
                        </div>
                        @php
                            $hasNewTech = isset($tech_inquiries_new_count) && $tech_inquiries_new_count > 0;
                            $hasPendingTech = isset($tech_inquiries_pending_count) && $tech_inquiries_pending_count > 0;
                        @endphp
                        @if($hasNewTech)
                            <span class="absolute -top-1 -right-1 w-2.5 h-2.5 rounded-full bg-red-500 border-2 border-white"></span>
                        @elseif($hasPendingTech)
                            <span class="absolute -top-1 -right-1 w-2.5 h-2.5 rounded-full bg-amber-500 border-2 border-white"></span>
                        @endif
                    </div>
                    <span class="text-sm font-medium">Inquiries</span>
                </a>
            </li>

            <li>
                <a href="{{ route('technician.quotation') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group
                    {{ Route::is('technician.quotation*') || Route::is('quotation.*') ? 'bg-blue-50 text-blue-700 border-l-4 border-blue-500' : 'hover:bg-gray-50 text-gray-700' }}">
                    <div class="w-8 h-8 flex items-center justify-center rounded-lg
                        {{ Route::is('technician.quotation*') || Route::is('quotation.*') ? 'bg-blue-100 text-blue-700' : 'bg-gray-100 text-gray-500 group-hover:bg-blue-50 group-hover:text-blue-600' }}">
                        <i class="fas fa-file-invoice text-sm"></i>
                    </div>
                    <span class="text-sm font-medium">Quotation</span>
                </a>
            </li>
            
            <li>
                <a href="{{ route('technician.job.index') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group
                    {{ Route::is('technician.job*') || Route::is('job.*') ? 'bg-blue-50 text-blue-700 border-l-4 border-blue-500' : 'hover:bg-gray-50 text-gray-700' }}">
                    <div class="w-8 h-8 flex items-center justify-center rounded-lg
                        {{ Route::is('technician.job*') || Route::is('job.*') ? 'bg-blue-100 text-blue-700' : 'bg-gray-100 text-gray-500 group-hover:bg-blue-50 group-hover:text-blue-600' }}">
                        <i class="fas fa-briefcase text-sm"></i>
                    </div>
                    <span class="text-sm font-medium">Job Order</span>
                </a>
            </li>

            <li>
                <a href="{{ route('technician.reporting') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group
                    {{ Route::is('technician.reporting') ? 'bg-blue-50 text-blue-700 border-l-4 border-blue-500' : 'hover:bg-gray-50 text-gray-700' }}">
                    <div class="w-8 h-8 flex items-center justify-center rounded-lg
                        {{ Route::is('technician.reporting') ? 'bg-blue-100 text-blue-700' : 'bg-gray-100 text-gray-500 group-hover:bg-blue-50 group-hover:text-blue-600' }}">
                        <i class="fas fa-chart-line text-sm"></i>
                    </div>
                    <span class="text-sm font-medium">Reporting</span>
                </a>
            </li>
        </ul>
    </nav>

   
    <!-- Sign Out Button -->
    <div class="px-5 py-4 border-t border-gray-100">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" 
                class="w-full flex items-center gap-3 px-4 py-3 rounded-xl text-gray-600 hover:bg-gray-50 hover:text-gray-900 transition-all duration-200 group">
                <div class="w-8 h-8 flex items-center justify-center rounded-lg bg-gray-100 text-gray-500 group-hover:bg-gray-200 group-hover:text-gray-700">
                    <i class="fas fa-right-from-bracket text-sm"></i>
                </div>
                <span class="text-sm font-medium">Sign out</span>
            </button>
        </form>
    </div>

</aside>