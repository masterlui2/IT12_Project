@extends('admin.layout.app')

@section('content')
@php
  $levelStyles = [
    'info' => 'bg-emerald-100 text-emerald-800 border border-emerald-200',
      'warning' => 'bg-amber-100 text-amber-800 border border-amber-200',
      'error' => 'bg-rose-100 text-rose-800 border border-rose-200',
      'critical' => 'bg-red-100 text-red-800 border border-red-200',
      'system' => 'bg-blue-100 text-blue-800 border border-blue-200',
  ];
@endphp

<!-- Top Navigation Header -->
<nav class="w-full bg-white border-b border-gray-100 shadow-sm px-6 py-4 flex flex-col lg:flex-row justify-between gap-4 items-start lg:items-center mb-6">
  <div class="flex items-center space-x-2">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
        d="M9 12h6m2 0a9 9 0 11-18 0 9 9 0 0118 0z" />
    </svg>
    <h2 class="text-xl font-semibold text-gray-800">Activity Logs</h2>
  </div>

  <form method="GET" action="{{ route('admin.activity') }}" class="flex flex-wrap items-center gap-3">
    <input
      type="text"
      name="search"
      value="{{ $filters['search'] }}"
      placeholder="Search logs by event or user"
      class="px-3 py-2 border rounded-md text-sm focus:ring-blue-500 focus:border-blue-500 w-60"
    />

    <select name="level" class="px-3 py-2 border rounded-md text-sm focus:ring-blue-500 focus:border-blue-500">
      <option value="">All Levels</option>
      <option value="info" @selected($filters['level'] === 'info')>Info</option>
      <option value="warning" @selected($filters['level'] === 'warning')>Warning</option>
      <option value="error" @selected($filters['level'] === 'error')>Error</option>
      <option value="system" @selected($filters['level'] === 'system')>System</option>
    </select>

    <input
      type="date"
      name="date_from"
      value="{{ $filters['date_from'] }}"
      class="px-3 py-2 border rounded-md text-sm focus:ring-blue-500 focus:border-blue-500"
    />

    <input
      type="date"
      name="date_to"
      value="{{ $filters['date_to'] }}"
      class="px-3 py-2 border rounded-md text-sm focus:ring-blue-500 focus:border-blue-500"
    />

    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md text-sm hover:bg-blue-700">
      Filter
    </button>
    <a href="{{ route('admin.activity') }}" class="px-4 py-2 border rounded-md text-sm hover:bg-gray-100">Reset</a>
  </form>
</nav>


<!-- Activity Logs Table -->
<div class="p-6 bg-white border rounded-lg shadow-sm">
  <div class="overflow-x-auto">
    <table class="w-full text-left text-sm">
      <thead class="bg-gray-100 text-gray-700">
        <tr>
          <th class="px-6 py-3">Timestamp</th>
          <th class="px-6 py-3">User</th>
          <th class="px-6 py-3">Role</th>
          <th class="px-6 py-3">Action</th>
          <th class="px-6 py-3">Origin IP</th>
          <th class="px-6 py-3">Severity</th>
        </tr>
      </thead>
      <tbody class="divide-y">
        @forelse($logs as $log)
          @php
            $action = strtolower($log->action ?? '');
            $metaText = strtolower(is_array($log->meta) ? json_encode($log->meta) : (string) $log->meta);
           $isCriticalEvent = str_contains($action, 'failed')
              || str_contains($action, 'denied')
              || str_contains($action, 'locked')
              || str_contains($action, 'error')
              || str_contains($metaText, 'failed')
              || str_contains($metaText, 'error');

            $derivedLevel = $isCriticalEvent
              ? 'critical'
              : (str_contains($action, 'warn') || str_contains($metaText, 'warn')
                ? 'warning'
                : ($log->user_id ? 'info' : 'system'));

            $level = strtolower($log->level ?? $derivedLevel);
 if ($isCriticalEvent && !in_array($level, ['critical', 'error'], true)) {
              $level = 'critical';
            }

            $levelClass = $levelStyles[$level] ?? 'bg-gray-100 text-gray-700 border border-gray-200';
            $displayAction = str_replace(['.', '_'], ' ', $log->action);          @endphp
          <tr class="hover:bg-gray-50 transition align-top {{ $isCriticalEvent ? 'bg-red-50/30' : '' }}">
            <td class="px-6 py-3 text-gray-500 whitespace-nowrap">{{ optional($log->created_at)->format('Y-m-d H:i') ?? 'N/A' }}</td>
            <td class="px-6 py-3 font-semibold text-gray-800 whitespace-nowrap">
              {{ trim(($log->user->firstname ?? '') . ' ' . ($log->user->lastname ?? '')) ?: 'System' }}
            </td>
          <td class="px-6 py-3 text-gray-600 capitalize">{{ $log->user->role ?? 'System' }}</td>
            <td class="px-6 py-3 text-gray-700">
              <div class="flex items-start gap-2">
                @if($isCriticalEvent)
                  <i class="fas fa-triangle-exclamation text-red-600 mt-0.5" title="Critical event"></i>
                @elseif($level === 'warning')
                  <i class="fas fa-circle-exclamation text-amber-600 mt-0.5" title="Warning event"></i>
                @else
                  <i class="fas fa-circle-info text-blue-500 mt-0.5" title="Information event"></i>
                @endif
                <span class="break-words">{{ ucfirst($displayAction) }}</span>
              </div>
            </td>
            <td class="px-6 py-3 text-gray-500 whitespace-nowrap">{{ $log->ip_address ?? 'N/A' }}</td>
            <td class="px-6 py-3">
<span class="px-2.5 py-1 rounded-full text-xs font-semibold {{ $levelClass }}">{{ ucfirst($level) }}</span>            </td>
          </tr>
        @empty
          <tr>
            <td colspan="6" class="px-6 py-8 text-center text-gray-500">No activity logs found for the selected filters.</td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  <!-- Pagination -->
  <div class="border-t bg-white px-6 py-3 flex justify-between items-center text-sm text-gray-500">
    <p>
      Showing {{ $logs->firstItem() ?? 0 }}-{{ $logs->lastItem() ?? 0 }} of {{ $logs->total() }} logs
    </p>
    <div>
      {{ $logs->links() }}
    </div>
  </div>
</div>

@endsection