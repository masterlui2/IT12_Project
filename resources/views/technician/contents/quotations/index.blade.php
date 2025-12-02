@extends('technician.layout.app')

@section('content')

<div class="bg-white rounded-xl shadow-sm border p-8 space-y-8">

  <!-- Header Section -->
  <div class="flex justify-between items-center border-b pb-3">
    <div>
      <h1 class="text-xl font-bold text-gray-800">Techne Fixer Computer and Laptop Repair Services</h1>
      <p class="text-sm text-gray-500">007 Manga Street, Toril Davao City</p>
      <p class="text-sm text-gray-500">Contact No: 09662406825   TIN 618‑863‑736‑000000</p>
    </div>
    <img src="{{ asset('images/logo.png') }}" class="w-20 h-20 object-contain" alt="Company Logo">
  </div>

  <!-- Success/Error Messages -->
  @if(session('success'))
    <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg">
      {{ session('success') }}
    </div>
  @endif

  @if(session('error'))
    <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg">
      {{ session('error') }}
    </div>
  @endif

  <!-- Quotation Management Section -->
  <div>
    <div class="flex justify-between items-center mb-6">
      <h2 class="text-lg font-semibold text-gray-800">Quotation Management</h2>

      <div class="flex flex-wrap items-center gap-3">
        <form method="GET" action="{{ route('technician.quotation') }}" class="flex gap-3">
          <input type="text" name="search" placeholder="Search by client or ID" 
                value="{{ request('search') }}"
                class="px-3 py-2 border rounded-md text-sm focus:ring-blue-500 focus:border-blue-500 w-52" />

          <select name="status" class="px-3 py-2 border rounded-md text-sm focus:ring-blue-500 focus:border-blue-500"
                  onchange="this.form.submit()">
            <option value="">All Status</option>
            <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
            <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
          </select>

          <select name="sort" class="px-3 py-2 border rounded-md text-sm focus:ring-blue-500 focus:border-blue-500"
                  onchange="this.form.submit()">
            <option value="recent" {{ request('sort') == 'recent' ? 'selected' : '' }}>Sort: Recent</option>
            <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Oldest</option>
            <option value="amount_high" {{ request('sort') == 'amount_high' ? 'selected' : '' }}>Amount (High)</option>
            <option value="amount_low" {{ request('sort') == 'amount_low' ? 'selected' : '' }}>Amount (Low)</option>
          </select>
        </form>

        <a href="{{ route('quotation.new') }}"
          class="bg-blue-600 text-white px-4 py-2 rounded-md text-sm 
                hover:bg-blue-700 active:scale-95 active:bg-blue-800 
                transition-transform duration-100 shadow-sm hover:shadow-md">
          + New Quotation
        </a>
      </div>
    </div>

    <!-- Table Display -->
    <div class="overflow-x-auto border rounded-lg">
      <table class="w-full text-left text-sm">
        <thead class="bg-neutral-50 text-neutral-700">
          <tr class="border-b border-neutral-200">
            <th class="px-4 py-3 font-medium">Quote #</th>
            <th class="px-4 py-3 font-medium">Client</th>
            <th class="px-4 py-3 font-medium">Project Title</th>
            <th class="px-4 py-3 font-medium text-right">Amount</th>
            <th class="px-4 py-3 font-medium">Status</th>
            <th class="px-4 py-3 font-medium text-right">Issue Date</th>
            <th class="px-4 py-3 font-medium text-center w-40">Actions</th>
          </tr>
        </thead>
        <tbody class="divide-y">
          @forelse($quotations as $quotation)
          <tr class="hover:bg-gray-50 transition">
            <td class="px-4 py-3 font-medium text-neutral-900">
              QTN-{{ str_pad($quotation->id, 5, '0', STR_PAD_LEFT) }}
            </td>
            <td class="px-4 py-3">
              <div class="max-w-[180px] truncate text-neutral-900">{{ $quotation->client_name }}</div>
            </td>
            <td class="px-4 py-3">
              <div class="max-w-[240px] truncate text-neutral-800">{{ Str::limit($quotation->project_title, 60) }}</div>
            </td>
            <td class="px-4 py-3 text-right text-neutral-900">₱{{ number_format($quotation->grand_total, 2) }}</td>
            <td class="px-6 py-4">
              @php
                $statusColors = [
                  'draft' => 'bg-gray-100 text-gray-700',
                  'pending' => 'bg-blue-100 text-blue-700',
                  'approved' => 'bg-green-100 text-green-700',
                  'rejected' => 'bg-red-100 text-red-700',
                ];
                $color = $statusColors[$quotation->status] ?? 'bg-gray-100 text-gray-700';
              @endphp
              <span class="{{ $color }} text-xs px-2 py-1 rounded capitalize">
                {{ $quotation->status }}
              </span>
            </td>
            <td class="px-4 py-3 text-right text-neutral-700">{{ \Carbon\Carbon::parse($quotation->date_issued)->format('M d, Y') }}</td>
            <td class="px-4 py-3 text-center">
              <div class="inline-flex items-center justify-center gap-2">
                <a href="{{ route('quotation.show', $quotation->id) }}" 
                   class="inline-flex items-center justify-center w-8 h-8 text-blue-600 hover:text-blue-800"
                   title="View">
                  <i class="fas fa-eye"></i>
                  <span class="sr-only">View</span>
                </a>

                <a href="{{ route('quotation.pdf', $quotation->id) }}" 
                   target="_blank"
                   class="inline-flex items-center justify-center w-8 h-8 text-purple-600 hover:text-purple-800"
                   title="PDF">
                  <i class="fas fa-file-pdf"></i>
                  <span class="sr-only">PDF</span>
                </a>

                @if($quotation->status === 'draft')
                  <a href="{{ route('quotation.edit', $quotation->id) }}" 
                     class="inline-flex items-center justify-center w-8 h-8 text-green-600 hover:text-green-800"
                     title="Edit">
                    <i class="fas fa-pen"></i>
                    <span class="sr-only">Edit</span>
                  </a>
                @endif

                <form action="{{ route('quotation.destroy', $quotation->id) }}" 
                      method="POST" 
                      class="inline"
                      onsubmit="return confirm('Are you sure you want to delete this quotation?')">
                  @csrf
                  @method('DELETE')
                  <button type="submit" 
                          class="inline-flex items-center justify-center w-8 h-8 text-red-600 hover:text-red-700"
                          title="Delete">
                    <i class="fas fa-trash"></i>
                    <span class="sr-only">Delete</span>
                  </button>
                </form>
              </div>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="7" class="px-6 py-8 text-center text-gray-500">
              No quotations found. 
              <a href="{{ route('quotation.new') }}" class="text-blue-600 hover:underline">Create your first quotation</a>
            </td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    <!-- Summary -->
    <div class="flex justify-between items-center mt-4 border-t pt-3 text-sm text-gray-700">
      <div>Total Quotations: <span class="text-blue-600 font-semibold">{{ $quotations->total() }}</span></div>
      <div>Overall Value: 
        <span class="text-green-600 font-semibold">
          ₱{{ number_format($quotations->sum('grand_total'), 2) }}
        </span>
      </div>
    </div>

    <!-- Pagination -->
    <div class="border-t mt-4 pt-2 flex justify-between items-center text-sm text-gray-500">
      <p>Showing {{ $quotations->firstItem() ?? 0 }}–{{ $quotations->lastItem() ?? 0 }} of {{ $quotations->total() }} quotations</p>
      
      <div class="space-x-1">
        @if($quotations->onFirstPage())
          <button class="px-2 py-1 border rounded bg-gray-100 text-gray-400 cursor-not-allowed" disabled>Prev</button>
        @else
          <a href="{{ $quotations->previousPageUrl() }}" 
             class="px-2 py-1 border rounded hover:bg-gray-100">Prev</a>
        @endif

        @foreach($quotations->getUrlRange(1, $quotations->lastPage()) as $page => $url)
          @if($page == $quotations->currentPage())
            <button class="px-2 py-1 border rounded bg-blue-600 text-white">{{ $page }}</button>
          @else
            <a href="{{ $url }}" class="px-2 py-1 border rounded hover:bg-gray-100">{{ $page }}</a>
          @endif
        @endforeach

        @if($quotations->hasMorePages())
          <a href="{{ $quotations->nextPageUrl() }}" 
             class="px-2 py-1 border rounded hover:bg-gray-100">Next</a>
        @else
          <button class="px-2 py-1 border rounded bg-gray-100 text-gray-400 cursor-not-allowed" disabled>Next</button>
        @endif
      </div>
    </div>
  </div>
</div>

@endsection