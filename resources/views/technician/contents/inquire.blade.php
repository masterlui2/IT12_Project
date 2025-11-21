@extends('technician.layout.app')

@section('content')

<!-- Top Navigation Bar -->
<nav class="w-full bg-white shadow-sm border-b border-gray-100 px-6 py-3 flex flex-wrap justify-between items-center mb-6">
  <!-- Left side: Title -->
  <div class="flex items-center space-x-2">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M8 10h.01M12 14h.01M16 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
    </svg>
    <h2 class="text-xl font-semibold text-gray-800">Inquiries</h2>
  </div>

  <!-- Right side: Actions -->
  <div class="flex items-center gap-3">
    <input 
      type="text" 
      placeholder="Search inquiries by client or topic"
      class="px-3 py-2 border rounded-md text-sm focus:ring-blue-500 focus:border-blue-500 w-60"
    />

    <select class="px-3 py-2 border rounded-md text-sm focus:ring-blue-500 focus:border-blue-500">
      <option>All Status</option>
      <option>Pending</option>
      <option>Responded</option>
      <option>Closed</option>
    </select>

    <a href="{{ route('inquiry.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-md text-sm hover:bg-blue-700">+ New Inquiry</a>
  </div>
</nav>


<!-- Inquiries Table -->
<div class="bg-white rounded-lg shadow-sm overflow-hidden flex flex-col">
  <table class="w-full text-left text-sm">
    <thead class="bg-neutral-50 text-neutral-700">
      <tr class="border-b border-neutral-200">
        <th class="px-4 py-3 font-medium">Inquiry #</th>
        <th class="px-4 py-3 font-medium">Client</th>
        <th class="px-4 py-3 font-medium">Subject</th>
        <th class="px-4 py-3 font-medium">Status</th>
        <th class="px-4 py-3 font-medium text-right">Date Submitted</th>
        <th class="px-4 py-3 font-medium text-center w-48">Actions</th>
      </tr>
    </thead>

    <tbody class="divide-y">
      @forelse($inquiries as $inq)
      <tr class="hover:bg-gray-50 transition">
        <td class="px-4 py-3 font-medium text-neutral-900">INQ-{{ str_pad($inq->id, 5, '0', STR_PAD_LEFT) }}</td>
        <td class="px-4 py-3"><div class="max-w-[180px] truncate text-neutral-900">{{ $inq->name ?? ('Customer #'.$inq->user_id) }}</div></td>
        <td class="px-4 py-3"><div class="max-w-[260px] truncate text-neutral-800">{{ $inq->issue_description ?? '—' }}</div></td>
        <td class="px-4 py-3">
          @php
            $status = $inq->status ?? 'new';
            $statusColors = [
              'new' => 'bg-blue-100 text-blue-700',
              'open' => 'bg-yellow-100 text-yellow-800',
              'responded' => 'bg-green-100 text-green-700',
              'closed' => 'bg-gray-100 text-gray-700',
            ];
            $color = $statusColors[$status] ?? 'bg-gray-100 text-gray-700';
          @endphp
          <span class="{{ $color }} text-xs px-2 py-1 rounded capitalize">{{ $status }}</span>
        </td>
        <td class="px-4 py-3 text-right">{{ $inq->created_at?->format('M d, Y') }}</td>
        <td class="px-4 py-3 text-center align-middle">
          <div class="inline-flex items-center justify-center gap-2">
            <a href="{{ route('technician.inquire.show', $inq->id) }}" class="inline-flex w-8 h-8 items-center justify-center text-blue-600 hover:text-blue-800" title="View"><i class="fas fa-eye"></i><span class="sr-only">View</span></a>
            <a href="{{ route('quotation.new', ['inquiry' => $inq->id]) }}" class="text-emerald-600 hover:text-emerald-700 text-sm whitespace-nowrap">Convert to Quote</a>
            <form action="{{ route('technician.inquire.destroy', $inq->id) }}" method="POST" class="inline" onsubmit="return confirm('Delete inquiry INQ-{{ $inq->id }}?')">
              @csrf
              @method('DELETE')
              <button type="submit" class="inline-flex w-8 h-8 items-center justify-center text-red-600 hover:text-red-700" title="Delete"><i class="fas fa-trash"></i><span class="sr-only">Delete</span></button>
            </form>
          </div>
        </td>
      </tr>
      @empty
      <tr>
        <td colspan="6" class="px-4 py-10 text-center text-sm text-gray-500">No inquiries found.</td>
      </tr>
      @endforelse
    </tbody>
  </table>

  <!-- Pagination -->
  <div class="border-t bg-white px-6 py-3 flex justify-between items-center text-sm text-gray-500">
    <p>Showing {{ $inquiries->firstItem() ?? 0 }}–{{ $inquiries->lastItem() ?? 0 }} of {{ $inquiries->total() }} inquiries</p>
    <div class="space-x-1">{{ $inquiries->links() }}</div>
  </div>
</div>


<!-- Inquiries Summary -->
<div class="mt-4 bg-white border-t shadow-sm rounded-b-lg px-6 py-4 flex justify-between items-center text-sm">
  <div class="font-medium text-gray-700">
    Total Inquiries: <span class="text-blue-600 font-semibold">20</span>
  </div>
  <div class="font-medium text-gray-700">
    Pending Responses: <span class="text-yellow-600 font-semibold">5</span>
  </div>
</div>

@endsection
