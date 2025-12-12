<div class="min-h-screen flex bg-gray-50">
  <aside class="fixed top-0 left-0 h-screen w-64 bg-white border-r border-gray-100 flex flex-col justify-between z-20 transition-all duration-200">
    
    <!-- Logo and Title -->
    <div class="p-5 border-b border-gray-100">
      <div class="flex items-center gap-3">
        <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-blue-50 to-blue-100 flex items-center justify-center border border-blue-100">
          <img src="{{ asset('images/logo.png') }}" alt="Manager" class="w-10 h-10">
        </div>
        <div>
          <h2 class="text-lg font-semibold text-gray-900">Manager Panel</h2>
          <p class="text-gray-400 text-xs font-medium tracking-wide">Business Operations</p>
        </div>
      </div>
    </div>

    <!-- Navigation -->
    <nav class="flex-1 overflow-y-auto px-4 py-6">
      <ul class="space-y-1">
        <!-- Dashboard -->
        <li>
          <a href="{{ route('dashboard') }}"
             class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group
             {{ Route::is('dashboard') ? 'bg-blue-50 text-blue-700 border-l-4 border-blue-500' : 'hover:bg-gray-50 text-gray-700' }}">
             <div class="w-8 h-8 flex items-center justify-center rounded-lg
               {{ Route::is('dashboard') ? 'bg-blue-100 text-blue-700' : 'bg-gray-100 text-gray-500 group-hover:bg-blue-50 group-hover:text-blue-600' }}">
               <i class="fas fa-gauge text-sm"></i>
             </div>
             <span class="text-sm font-medium">Dashboard</span>
          </a>
        </li>

        <!-- Quotation -->
        <li>
          <a href="{{ route('quotation') }}"
             class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group
             {{ Route::is('quotation*') ? 'bg-blue-50 text-blue-700 border-l-4 border-blue-500' : 'hover:bg-gray-50 text-gray-700' }}">
             <div class="w-8 h-8 flex items-center justify-center rounded-lg
               {{ Route::is('quotation*') ? 'bg-blue-100 text-blue-700' : 'bg-gray-100 text-gray-500 group-hover:bg-blue-50 group-hover:text-blue-600' }}">
               <i class="fas fa-file-invoice text-sm"></i>
             </div>
             <span class="text-sm font-medium">Quotation</span>
          </a>
        </li>

        <!-- Inquiries -->
        <li>
          <a href="{{ route('inquiries') }}"
             class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group relative
             {{ Route::is('inquiries*') ? 'bg-blue-50 text-blue-700 border-l-4 border-blue-500' : 'hover:bg-gray-50 text-gray-700' }}">
             <div class="relative">
               <div class="w-8 h-8 flex items-center justify-center rounded-lg
                 {{ Route::is('inquiries*') ? 'bg-blue-100 text-blue-700' : 'bg-gray-100 text-gray-500 group-hover:bg-blue-50 group-hover:text-blue-600' }}">
                 <i class="fas fa-question-circle text-sm"></i>
               </div>
               @php
                 $hasNew = isset($inquiries_new_count) && $inquiries_new_count > 0;
                 $hasPending = isset($inquiries_pending_count) && $inquiries_pending_count > 0;
               @endphp
               @if($hasNew)
                 <span class="absolute -top-1 -right-1 w-2.5 h-2.5 rounded-full bg-red-500 border-2 border-white"></span>
               @elseif($hasPending)
                 <span class="absolute -top-1 -right-1 w-2.5 h-2.5 rounded-full bg-amber-500 border-2 border-white"></span>
               @endif
             </div>
             <span class="text-sm font-medium">Inquiries</span>
          </a>
        </li>

       

        <!-- Technicians -->
        <li>
          <a href="{{ route('technicians') }}"
             class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group
             {{ Route::is('technicians*') ? 'bg-blue-50 text-blue-700 border-l-4 border-blue-500' : 'hover:bg-gray-50 text-gray-700' }}">
             <div class="w-8 h-8 flex items-center justify-center rounded-lg
               {{ Route::is('technicians*') ? 'bg-blue-100 text-blue-700' : 'bg-gray-100 text-gray-500 group-hover:bg-blue-50 group-hover:text-blue-600' }}">
               <i class="fas fa-user-gear text-sm"></i>
             </div>
             <span class="text-sm font-medium">Technicians</span>
          </a>
        </li>

     
        <!-- Reports -->
        <li>
          <a href="{{ route('reports') }}"
             class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group
             {{ Route::is('reports*') ? 'bg-blue-50 text-blue-700 border-l-4 border-blue-500' : 'hover:bg-gray-50 text-gray-700' }}">
             <div class="w-8 h-8 flex items-center justify-center rounded-lg
               {{ Route::is('reports*') ? 'bg-blue-100 text-blue-700' : 'bg-gray-100 text-gray-500 group-hover:bg-blue-50 group-hover:text-blue-600' }}">
               <i class="fas fa-chart-line text-sm"></i>
             </div>
             <span class="text-sm font-medium">Reports</span>
          </a>
        </li>
      </ul>
    </nav>

    <!-- User Info -->
    <div class="border-t border-gray-100 px-5 py-4">
      <div class="flex items-center gap-3">
        <div class="w-10 h-10 flex items-center justify-center rounded-full text-blue-700 font-semibold text-sm bg-blue-50 border border-blue-100">
          {{ strtoupper(substr(auth()->user()->name ?? 'M', 0, 1)) }}
        </div>
        <div class="flex flex-col overflow-hidden">
          <span class="font-medium text-gray-900 text-sm truncate">{{ auth()->user()->name }}</span>
          <span class="text-gray-400 text-xs truncate">{{ auth()->user()->email }}</span>
        </div>
      </div>
    </div>

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

  <!-- Main Content -->
  <main class="flex-1 ml-64 p-6 overflow-y-auto">
    {{ $slot }}
  </main>
</div>