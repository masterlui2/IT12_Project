@extends('technician.layout.app')

@section('content')

<div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 space-y-8">

  <!-- Header Section -->
  <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pb-4 border-b border-gray-200">
    <div class="space-y-2">
      <h1 class="text-xl font-semibold text-gray-900">Techne Fixer Computer and Laptop Repair Services</h1>
      <div class="text-sm text-gray-600 space-y-0.5">
        <p>007 Manga Street, Toril Davao City</p>
        <p>Contact No: 09662406825 | TIN 618‑863‑736‑000000</p>
      </div>
    </div>
    <img src="{{ asset('images/logo.png') }}" class="w-16 h-16 object-contain" alt="Company Logo">
  </div>

  <!-- Success/Error Messages -->
  @if(session('success'))
    <div class="bg-green-50 border-l-4 border-green-500 text-green-700 px-4 py-3 rounded-r">
      <div class="flex items-center">
        <i class="fas fa-check-circle mr-3"></i>
        <span>{{ session('success') }}</span>
      </div>
    </div>
  @endif

  @if(session('error'))
    <div class="bg-red-50 border-l-4 border-red-500 text-red-700 px-4 py-3 rounded-r">
      <div class="flex items-center">
        <i class="fas fa-exclamation-circle mr-3"></i>
        <span>{{ session('error') }}</span>
      </div>
    </div>
  @endif

  <!-- Quotation Management Section -->
  <div class="space-y-6">
    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
      <div>
        <h2 class="text-lg font-semibold text-gray-900">Quotation Management</h2>
        <p class="text-sm text-gray-500 mt-1">View and manage all quotations</p>
      </div>

      <div class="flex items-center gap-3">
        <form method="GET" action="{{ route('technician.quotation') }}" class="flex flex-wrap gap-3">
          <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
              <i class="fas fa-search text-gray-400"></i>
            </div>
            <input 
              type="text" 
              name="search" 
              placeholder="Search quotations..." 
              value="{{ request('search') }}"
              class="pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-100 focus:border-blue-500 outline-none transition w-48"
            />
          </div>

          <select name="status" 
                  onchange="this.form.submit()"
                  class="px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-100 focus:border-blue-500 outline-none transition w-40">
            <option value="">All Status</option>
            <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
            <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
          </select>

          <select name="sort" 
                  onchange="this.form.submit()"
                  class="px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-100 focus:border-blue-500 outline-none transition w-40">
            <option value="recent" {{ request('sort') == 'recent' ? 'selected' : '' }}>Recent First</option>
            <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Oldest First</option>
            <option value="amount_high" {{ request('sort') == 'amount_high' ? 'selected' : '' }}>Amount (High)</option>
            <option value="amount_low" {{ request('sort') == 'amount_low' ? 'selected' : '' }}>Amount (Low)</option>
          </select>
        </form>

        <a href="{{ route('quotation.new') }}"
          class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2.5 rounded-lg text-sm font-medium transition-colors whitespace-nowrap">
          <i class="fas fa-plus text-xs"></i>
          New Quotation
        </a>
      </div>
    </div>

    <!-- Stats Summary -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
      <div class="bg-gray-50 rounded-xl p-4">
        <div class="text-2xl font-bold text-gray-900">{{ $quotations->total() }}</div>
        <div class="text-sm text-gray-600">Total Quotations</div>
      </div>
      <div class="bg-gray-50 rounded-xl p-4">
        <div class="text-2xl font-bold text-gray-900">
          ₱{{ number_format($quotations->sum('grand_total'), 0) }}
        </div>
        <div class="text-sm text-gray-600">Total Value</div>
      </div>
      <div class="bg-gray-50 rounded-xl p-4">
        <div class="text-2xl font-bold text-blue-600">
          {{ $quotations->where('status', 'pending')->count() }}
        </div>
        <div class="text-sm text-gray-600">Pending</div>
      </div>
      <div class="bg-gray-50 rounded-xl p-4">
        <div class="text-2xl font-bold text-green-600">
          {{ $quotations->where('status', 'approved')->count() }}
        </div>
        <div class="text-sm text-gray-600">Approved</div>
      </div>
    </div>

    <!-- Table Display -->
    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
      <div class="overflow-x-auto">
        <table class="w-full">
          <thead class="bg-gray-50">
            <tr class="text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b border-gray-200">
              <th class="px-6 py-4 font-medium">Quote #</th>
              <th class="px-6 py-4 font-medium">Client</th>
              <th class="px-6 py-4 font-medium">Project</th>
              <th class="px-6 py-4 font-medium text-right">Amount</th>
              <th class="px-6 py-4 font-medium">Status</th>
              <th class="px-6 py-4 font-medium text-right">Date</th>
              <th class="px-6 py-4 font-medium text-right w-28">Actions</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-100">
            @forelse($quotations as $quotation)
            <tr class="hover:bg-gray-50 transition-colors">
              <!-- Quote Number -->
              <td class="px-6 py-4">
                <div class="font-medium text-gray-900 text-sm">
                  QTN-{{ str_pad($quotation->id, 5, '0', STR_PAD_LEFT) }}
                </div>
              </td>

              <!-- Client -->
              <td class="px-6 py-4">
                <div class="font-medium text-gray-900 text-sm">
                  {{ Str::limit($quotation->client_name, 30) }}
                </div>
              </td>

              <!-- Project Title -->
              <td class="px-6 py-4">
                <div class="text-gray-900 text-sm">
                  {{ Str::limit($quotation->project_title, 40) }}
                </div>
              </td>

              <!-- Amount -->
              <td class="px-6 py-4 text-right">
                <div class="font-medium text-gray-900">
                  ₱{{ number_format($quotation->grand_total, 2) }}
                </div>
              </td>

              <!-- Status -->
              <td class="px-6 py-4">
                @php
                  $statusColors = [
                    'draft' => 'bg-gray-100 text-gray-700 border border-gray-200',
                    'pending' => 'bg-blue-100 text-blue-700 border border-blue-200',
                    'approved' => 'bg-green-100 text-green-700 border border-green-200',
                    'rejected' => 'bg-red-100 text-red-700 border border-red-200',
                  ];
                  $color = $statusColors[$quotation->status] ?? 'bg-gray-100 text-gray-700';
                @endphp
                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium capitalize {{ $color }}">
                  {{ $quotation->status }}
                </span>
              </td>

              <!-- Date -->
              <td class="px-6 py-4 text-right">
                <div class="text-sm text-gray-900">
                  {{ \Carbon\Carbon::parse($quotation->date_issued)->format('M d, Y') }}
                </div>
              </td>

              <!-- Simplified Actions -->
              <td class="px-6 py-4 text-right">
                <div class="flex items-center justify-end gap-1.5">
                  <!-- View Button -->
                  <a href="{{ route('quotation.show', $quotation->id) }}" 
                     class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-blue-50 hover:bg-blue-100 text-blue-700 hover:text-blue-800 rounded-lg text-xs font-medium border border-blue-200 transition-colors">
                    <i class="fas fa-eye text-xs"></i>
                    View
                  </a>

                  <!-- Actions Dropdown -->
                  <div class="relative inline-block text-left">
                    <button type="button" 
                            class="w-8 h-8 flex items-center justify-center rounded-lg text-gray-400 hover:text-gray-600 hover:bg-gray-100 transition-colors"
                            onclick="toggleDropdown('dropdown-{{ $quotation->id }}')">
                      <i class="fas fa-ellipsis-h"></i>
                    </button>
                    
                    <div id="dropdown-{{ $quotation->id }}" 
                         class="hidden absolute right-0 mt-1 w-40 bg-white rounded-lg shadow-lg border border-gray-200 py-1 z-10">
                      <!-- PDF -->
                      <a href="{{ route('quotation.pdf', $quotation->id) }}" 
                         target="_blank"
                         class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                        <i class="fas fa-file-pdf mr-2 text-red-500"></i>
                        Download PDF
                      </a>
                      
                      <!-- Edit -->
                      @if($quotation->status === 'draft')
                      <a href="{{ route('quotation.edit', $quotation->id) }}" 
                         class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                        <i class="fas fa-pen mr-2 text-green-500"></i>
                        Edit
                      </a>
                      @endif
                      
                      <!-- Delete -->
                      <form action="{{ route('quotation.destroy', $quotation->id) }}" 
                            method="POST" 
                            onsubmit="return confirm('Delete quotation QTN-{{ $quotation->id }}?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                          <i class="fas fa-trash mr-2"></i>
                          Delete
                        </button>
                      </form>
                    </div>
                  </div>
                </div>
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="7" class="px-6 py-16 text-center">
                <div class="text-gray-400 mb-3">
                  <i class="fas fa-file-invoice-dollar text-4xl"></i>
                </div>
                <p class="text-gray-500 text-sm">No quotations found</p>
                <p class="text-gray-400 text-xs mt-1">Create your first quotation to get started</p>
              </td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>

      <!-- Pagination -->
      @if($quotations->hasPages())
      <div class="border-t border-gray-200 px-6 py-4">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between text-sm text-gray-600">
          <div class="mb-3 sm:mb-0">
            Showing {{ $quotations->firstItem() ?? 0 }} to {{ $quotations->lastItem() ?? 0 }} of {{ $quotations->total() }} quotations
          </div>
          
          <div class="flex items-center gap-1">
            @if($quotations->onFirstPage())
              <button class="px-3 py-2 border border-gray-300 rounded-lg text-gray-400 cursor-not-allowed" disabled>
                <i class="fas fa-chevron-left"></i>
              </button>
            @else
              <a href="{{ $quotations->previousPageUrl() }}" 
                 class="px-3 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                <i class="fas fa-chevron-left"></i>
              </a>
            @endif

            @foreach($quotations->getUrlRange(1, $quotations->lastPage()) as $page => $url)
              @if($page == $quotations->currentPage())
                <button class="px-3 py-2 border border-blue-500 bg-blue-50 text-blue-600 rounded-lg">
                  {{ $page }}
                </button>
              @else
                <a href="{{ $url }}" 
                   class="px-3 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                  {{ $page }}
                </a>
              @endif
            @endforeach

            @if($quotations->hasMorePages())
              <a href="{{ $quotations->nextPageUrl() }}" 
                 class="px-3 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                <i class="fas fa-chevron-right"></i>
              </a>
            @else
              <button class="px-3 py-2 border border-gray-300 rounded-lg text-gray-400 cursor-not-allowed" disabled>
                <i class="fas fa-chevron-right"></i>
              </button>
            @endif
          </div>
        </div>
      </div>
      @endif
    </div>
  </div>
</div>

<style>
  /* Dropdown animation */
  [id^="dropdown-"] {
    animation: fadeIn 0.1s ease-out;
  }
  
  @keyframes fadeIn {
    from { opacity: 0; transform: translateY(-5px); }
    to { opacity: 1; transform: translateY(0); }
  }
</style>

<script>
  function toggleDropdown(id) {
    const dropdown = document.getElementById(id);
    dropdown.classList.toggle('hidden');
    
    // Close other dropdowns
    document.querySelectorAll('[id^="dropdown-"]').forEach(other => {
      if (other.id !== id && !other.classList.contains('hidden')) {
        other.classList.add('hidden');
      }
    });
  }
  
  // Close dropdown when clicking outside
  document.addEventListener('click', function(event) {
    if (!event.target.closest('.relative.text-left')) {
      document.querySelectorAll('[id^="dropdown-"]').forEach(dropdown => {
        dropdown.classList.add('hidden');
      });
    }
  });
</script>

@endsection