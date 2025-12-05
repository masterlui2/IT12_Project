<div class="min-h-screen flex bg-gray-100">
  <aside class="fixed top-0 left-0 h-screen w-64 bg-white shadow-lg flex flex-col justify-between z-20">
    <div class="p-4 border-b border-gray-200">
      <div class="flex items-center gap-4">
        <img src="{{ asset('images/logo.png') }}" alt="Manager" class="w-14 h-14 rounded-xl">
        <div>
          <h2 class="text-xl font-bold">Manager Panel</h2>
          <p class="text-gray-500 text-sm">Business Operations</p>
        </div>
      </div>
    </div>

    <nav class="flex-1 overflow-y-auto px-6 py-4">
      <ul class="space-y-2 text-gray-700">
        <li>
          <a href="{{ route('dashboard') }}"
             class="flex items-center gap-3 px-4 py-3 rounded-lg transition {{ Route::is('dashboard') ? 'bg-blue-100 text-blue-700 font-semibold' : 'hover:bg-blue-50 text-gray-700' }}">
             <i class="fas fa-gauge {{ Route::is('dashboard') ? 'text-blue-700' : 'text-blue-500' }}"></i>
             <span class="text-md font-medium">Dashboard</span>
          </a>
        </li>

        <li>
          <a href="{{ route('quotation') }}"
             class="flex items-center gap-3 px-4 py-3 rounded-lg transition {{ Route::is('quotation') ? 'bg-blue-100 text-blue-700 font-semibold' : 'hover:bg-blue-50 text-gray-700' }}">
             <i class="fas fa-file-invoice {{ Route::is('quotation') ? 'text-blue-700' : 'text-blue-500' }}"></i>
             <span class="text-md font-medium">Quotation</span>
          </a>
        </li>

        <li>
          <a href="{{ route('inquiries') }}"
             class="flex items-center gap-3 px-4 py-3 rounded-lg transition {{ Route::is('inquiries') ? 'bg-blue-100 text-blue-700 font-semibold' : 'hover:bg-blue-50 text-gray-700' }}">
             <i class="fas fa-question-circle {{ Route::is('inquiries') ? 'text-blue-700' : 'text-blue-500' }}"></i>
             <span class="text-md font-medium">Inquiries</span>
             @php
               $hasNew = isset($inquiries_new_count) && $inquiries_new_count > 0;
               $hasPending = isset($inquiries_pending_count) && $inquiries_pending_count > 0;
             @endphp
             @if($hasNew)
               <span class="ml-2 inline-block w-2.5 h-2.5 rounded-full bg-red-500" title="New inquiries"></span>
             @elseif($hasPending)
               <span class="ml-2 inline-block w-2.5 h-2.5 rounded-full bg-amber-500" title="Pending / Unassigned"></span>
             @endif
          </a>
        </li>

        <li>
          <a href="{{ route('customers') }}"
             class="flex items-center gap-3 px-4 py-3 rounded-lg transition {{ Route::is('customers') ? 'bg-blue-100 text-blue-700 font-semibold' : 'hover:bg-blue-50 text-gray-700' }}">
             <i class="fas fa-users {{ Route::is('customers') ? 'text-blue-700' : 'text-blue-500' }}"></i>
             <span class="text-md font-medium">Customers</span>
          </a>
        </li>

        <li>
          <a href="{{ route('technicians') }}"
             class="flex items-center gap-3 px-4 py-3 rounded-lg transition {{ Route::is('technicians') ? 'bg-blue-100 text-blue-700 font-semibold' : 'hover:bg-blue-50 text-gray-700' }}">
             <i class="fas fa-user-gear {{ Route::is('technicians') ? 'text-blue-700' : 'text-blue-500' }}"></i>
             <span class="text-md font-medium">Technicians</span>
          </a>
        </li>
          <li>
          <a href="{{ route('sales') }}"
             class="flex items-center gap-3 px-4 py-3 rounded-lg transition {{ Route::is('sales') ? 'bg-blue-100 text-blue-700 font-semibold' : 'hover:bg-blue-50 text-gray-700' }}">
             <i class="fas fa-hand-holding-dollar {{ Route::is('sales') ? 'text-blue-700' : 'text-blue-500' }}"></i>
             <span class="text-md font-medium">Sales</span>
          </a>
        </li>
        

        <li>
          <a href="{{ route('reports') }}"
             class="flex items-center gap-3 px-4 py-3 rounded-lg transition {{ Route::is('reports') ? 'bg-blue-100 text-blue-700 font-semibold' : 'hover:bg-blue-50 text-gray-700' }}">
             <i class="fas fa-chart-line {{ Route::is('reports') ? 'text-blue-700' : 'text-blue-500' }}"></i>
             <span class="text-md font-medium">Reports</span>
          </a>
        </li>
      </ul>
    </nav>

    <div class="border-t border-gray-200 px-6 py-4 flex items-center gap-4">
      <div class="w-12 h-12 flex items-center justify-center rounded-full text-[#155DFC] font-bold text-lg bg-[#DBEAFE] bg-opacity-50">
        {{ strtoupper(substr(auth()->user()->name ?? 'M',0,1)) }}
      </div>
      <div class="flex flex-col">
        <span class="font-semibold">{{ auth()->user()->name }}</span>
        <span class="text-gray-500 text-sm">{{ auth()->user()->email }}</span>
      </div>
    </div>

    <div class="px-6 py-2">
      <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button class="w-full text-gray-600 px-4 py-2 rounded-lg hover:bg-red-600 hover:text-white transition flex items-center gap-2">
          <i class="fas fa-right-from-bracket"></i> Sign out
        </button>
      </form>
    </div>
  </aside>

  <main class="flex-1 ml-64 p-6 overflow-y-auto">
    {{ $slot }}
  </main>
</div>
