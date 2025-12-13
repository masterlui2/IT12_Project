@extends('technician.layout.app')

@section('content')

<div class="space-y-8">

  {{-- Header --}}
  <div class="flex flex-col gap-2">
    <p class="text-sm text-gray-500">Dashboard</p>

    <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
      <h1 class="text-2xl font-semibold text-gray-900">
        Welcome back, {{ auth()->user()->firstname ?? 'Technician' }}
      </h1>

      <span class="inline-flex items-center gap-2 text-xs font-medium text-gray-500 bg-gray-100 px-3 py-1 rounded-full">
        <i class="fas fa-clock text-[11px]"></i>
        Updated {{ now()->format('M d, Y') }}
      </span>
    </div>

    <p class="text-sm text-gray-600">
      A concise view of the work that needs your attention right now.
    </p>
  </div>

  {{-- Metrics --}}
  <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">

    <div class="bg-white border rounded-xl p-4 shadow-sm">
      <div class="flex items-center justify-between">
        <p class="text-sm text-gray-500">Active job orders</p>
        <span class="h-8 w-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center">
          <i class="fas fa-briefcase text-sm"></i>
        </span>
      </div>
      <p class="text-3xl font-semibold text-gray-900 mt-2">{{ $metrics['active_jobs'] }}</p>
      <p class="text-xs text-gray-500 mt-1">Scheduled or currently in progress</p>
    </div>

    <div class="bg-white border rounded-xl p-4 shadow-sm">
      <div class="flex items-center justify-between">
        <p class="text-sm text-gray-500">Completed jobs</p>
        <span class="h-8 w-8 rounded-lg bg-green-50 text-green-600 flex items-center justify-center">
          <i class="fas fa-check-circle text-sm"></i>
        </span>
      </div>
      <p class="text-3xl font-semibold text-gray-900 mt-2">{{ $metrics['completed_jobs'] }}</p>
      <p class="text-xs text-gray-500 mt-1">Marked as completed</p>
    </div>

    <div class="bg-white border rounded-xl p-4 shadow-sm">
      <div class="flex items-center justify-between">
        <p class="text-sm text-gray-500">Open inquiries</p>
        <span class="h-8 w-8 rounded-lg bg-yellow-50 text-yellow-700 flex items-center justify-center">
          <i class="fas fa-inbox text-sm"></i>
        </span>
      </div>
      <p class="text-3xl font-semibold text-gray-900 mt-2">{{ $metrics['open_inquiries'] }}</p>
      <p class="text-xs text-gray-500 mt-1">Assigned to you and not closed</p>
    </div>

    <div class="bg-white border rounded-xl p-4 shadow-sm">
      <div class="flex items-center justify-between">
        <p class="text-sm text-gray-500">Quotations created</p>
        <span class="h-8 w-8 rounded-lg bg-purple-50 text-purple-700 flex items-center justify-center">
          <i class="fas fa-file-invoice text-sm"></i>
        </span>
      </div>
      <p class="text-3xl font-semibold text-gray-900 mt-2">{{ $metrics['quotations'] }}</p>
      <p class="text-xs text-gray-500 mt-1">Drafted or sent to managers</p>
    </div>

  </div>

  {{-- Two-column section --}}
  <div class="grid lg:grid-cols-2 gap-6">

    {{-- Job Order Focus --}}
    <div class="bg-white border rounded-xl shadow-sm overflow-hidden">
      <div class="flex items-center justify-between px-5 py-4 border-b bg-gray-50">
        <div>
          <h2 class="font-semibold text-gray-800">Job order focus</h2>
          <p class="text-sm text-gray-500">Most recent assignments</p>
        </div>
        <a href="{{ route('technician.job.index') }}" class="text-sm font-medium text-blue-600 hover:text-blue-700">
          View all
        </a>
      </div>

      <div class="divide-y">
        @forelse ($recentJobOrders as $job)
          @php
            $statusColors = [
                'scheduled' => 'bg-blue-100 text-blue-700',
                'in_progress' => 'bg-yellow-100 text-yellow-800',
                'completed' => 'bg-green-100 text-green-700',
                'cancelled' => 'bg-red-100 text-red-700',
            ];
            $statusText = $job->status ?? 'pending';
            $statusColor = $statusColors[$statusText] ?? 'bg-gray-100 text-gray-700';
          @endphp

          <div class="px-5 py-4 flex items-start justify-between gap-4">
            <div class="min-w-0 space-y-1">
              <p class="text-sm font-semibold text-gray-900">
                JO-{{ str_pad($job->id, 5, '0', STR_PAD_LEFT) }}
              </p>
              <p class="text-sm text-gray-600 truncate">
                {{ optional($job->quotation)->project_title ?? 'No project title' }}
              </p>
              <p class="text-xs text-gray-500">
                Target: {{ optional($job->expected_finish_date)->format('M d, Y') ?? 'Not set' }}
              </p>
            </div>

            <div class="flex flex-col items-end gap-2 shrink-0">
              <span class="px-2 py-1 text-xs rounded-full {{ $statusColor }} capitalize">
                {{ str_replace('_',' ', $statusText) }}
              </span>
              <a href="{{ route('technician.job.show', $job->id) }}" class="text-xs font-medium text-blue-600 hover:text-blue-700">
                View details
              </a>
            </div>
          </div>
        @empty
          <div class="px-5 py-10 text-center">
            <div class="mx-auto mb-2 h-10 w-10 rounded-full bg-gray-100 text-gray-500 flex items-center justify-center">
              <i class="fas fa-briefcase"></i>
            </div>
            <p class="text-sm text-gray-600 font-medium">No job orders yet</p>
            <p class="text-xs text-gray-500 mt-1">Assigned job orders will show up here.</p>
          </div>
        @endforelse
      </div>
    </div>

    {{-- Customer Inquiries --}}
    <div class="bg-white border rounded-xl shadow-sm overflow-hidden">
      <div class="flex items-center justify-between px-5 py-4 border-b bg-gray-50">
        <div>
          <h2 class="font-semibold text-gray-800">Customer inquiries</h2>
          <p class="text-sm text-gray-500">Latest items assigned to you</p>
        </div>
        <a href="{{ route('technician.inquire.index') }}" class="text-sm font-medium text-blue-600 hover:text-blue-700">
          Manage
        </a>
      </div>

      <div class="divide-y">
        @forelse ($recentInquiries as $inquiry)
          @php
            $status = $inquiry->status ?? 'new';
            $statusColors = [
                'new' => 'bg-blue-100 text-blue-700 border border-blue-200',
                'open' => 'bg-yellow-100 text-yellow-700 border border-yellow-200',
                'responded' => 'bg-green-100 text-green-700 border border-green-200',
                'closed' => 'bg-gray-100 text-gray-700 border border-gray-200',
            ];
            $badge = $statusColors[$status] ?? 'bg-gray-100 text-gray-700 border border-gray-200';
          @endphp

          <div class="px-5 py-4 flex items-start justify-between gap-4">
            <div class="min-w-0 space-y-1">
              <p class="text-sm font-semibold text-gray-900">
                INQ-{{ str_pad($inquiry->id, 5, '0', STR_PAD_LEFT) }}
              </p>
              <p class="text-sm text-gray-600 truncate">
                {{ $inquiry->name ?? 'Customer '.$inquiry->customer_id }}
              </p>
              <p class="text-xs text-gray-500">
                {{ $inquiry->category ?? 'General' }} • {{ $inquiry->created_at?->format('M d, Y') }}
              </p>
            </div>

            <div class="flex flex-col items-end gap-2 shrink-0">
              <span class="px-2 py-1 text-xs rounded-full capitalize {{ $badge }}">
                {{ $status }}
              </span>
              <a href="{{ route('technician.inquire.show', $inquiry->id) }}" class="text-xs font-medium text-blue-600 hover:text-blue-700">
                Open
              </a>
            </div>
          </div>
        @empty
          <div class="px-5 py-10 text-center">
            <div class="mx-auto mb-2 h-10 w-10 rounded-full bg-gray-100 text-gray-500 flex items-center justify-center">
              <i class="fas fa-inbox"></i>
            </div>
            <p class="text-sm text-gray-600 font-medium">No inquiries assigned</p>
            <p class="text-xs text-gray-500 mt-1">New assignments will appear here.</p>
          </div>
        @endforelse
      </div>
    </div>

  </div>

  {{-- Recent Quotations --}}
  <div class="bg-white border rounded-xl shadow-sm overflow-hidden">
    <div class="flex items-center justify-between px-5 py-4 border-b bg-gray-50">
      <div>
        <h2 class="font-semibold text-gray-800">Recent quotations</h2>
        <p class="text-sm text-gray-500">Quick glance at your latest submissions</p>
      </div>
      <a href="{{ route('technician.quotation') }}" class="text-sm font-medium text-blue-600 hover:text-blue-700">
        Go to quotations
      </a>
    </div>

    <div class="divide-y">
      @forelse ($recentQuotations as $quote)
        <div class="px-5 py-4 flex items-start justify-between gap-4">
          <div class="min-w-0 space-y-1">
            <p class="text-sm font-semibold text-gray-900">
              QT-{{ str_pad($quote->id, 5, '0', STR_PAD_LEFT) }}
            </p>
            <p class="text-sm text-gray-600 truncate">
              {{ $quote->project_title ?? 'Untitled project' }}
            </p>
            <p class="text-xs text-gray-500">
              Issued {{ optional($quote->date_issued)->format('M d, Y') ?? 'Not dated' }}
            </p>
          </div>

          <div class="flex flex-col items-end gap-2 shrink-0">
           @php
  $status = strtolower($quote->status ?? 'draft');

  $statusBadge = match ($status) {
    'approved' => 'bg-emerald-100 text-emerald-700 ring-1 ring-emerald-200',
    'pending'  => 'bg-amber-100 text-amber-800 ring-1 ring-amber-200',
    'rejected' => 'bg-rose-100 text-rose-700 ring-1 ring-rose-200',
    default    => 'bg-gray-100 text-gray-700 ring-1 ring-gray-200',
  };
@endphp

<span class="px-2.5 py-1 text-xs rounded-full capitalize {{ $statusBadge }}">
  {{ $status }}
</span>

            <a href="{{ route('quotation.show', $quote->id) }}" class="text-xs font-medium text-blue-600 hover:text-blue-700">
              Review
            </a>
          </div>
        </div>
      @empty
        <div class="px-5 py-10 text-center">
          <div class="mx-auto mb-2 h-10 w-10 rounded-full bg-gray-100 text-gray-500 flex items-center justify-center">
            <i class="fas fa-file-invoice"></i>
          </div>
          <p class="text-sm text-gray-600 font-medium">No quotations yet</p>
          <p class="text-xs text-gray-500 mt-1">Your created quotations will appear here.</p>
        </div>
      @endforelse
    </div>
  </div>

</div>

@endsection
