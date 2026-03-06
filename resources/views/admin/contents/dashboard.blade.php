@extends('admin.layout.app')

@section('content')
<nav class="w-full bg-white border-b border-gray-100 shadow-sm px-6 py-4 flex justify-between items-center mb-6">
  <div class="flex items-center space-x-2">
    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L4.75 12m0 0l5-5M4.75 12h14.5M9.75 17l-2.5 2.5M9.75 17v-2.5" />
    </svg>
    <h2 class="text-xl font-semibold text-gray-800">Administrator Dashboard</h2>
  </div>
 <div class="bg-white border rounded-lg shadow-sm p-4"><h4 class="text-sm text-gray-600">Active Technicians</h4><p class="text-2xl font-semibold mt-2">{{ $userStats['technicians'] }}</p></div>
    <div class="bg-white border rounded-lg shadow-sm p-4"><h4 class="text-sm text-gray-600">Pending Inquiries</h4><p class="text-2xl font-semibold mt-2">{{ $systemStats['pending_inquiries'] }}</p></div>
    <div class="bg-white border rounded-lg shadow-sm p-4"><h4 class="text-sm text-gray-600">Open Quotations</h4><p class="text-2xl font-semibold mt-2">{{ $systemStats['open_quotations'] }}</p></div>
    <div class="bg-white border rounded-lg shadow-sm p-4"><h4 class="text-sm text-gray-600">Total Revenue</h4><p class="text-2xl font-semibold mt-2">₱{{ number_format((float) $systemStats['total_revenue'], 2) }}</p></div>
  </div>


  <!-- System Health and Charts -->
  <div class="grid lg:grid-cols-2 gap-6">
    <!-- System Health -->
    <div class="bg-white border rounded-lg shadow-sm p-4">
     <h3 class="font-semibold text-gray-700 mb-4">Live System Metrics</h3>
      <div class="space-y-3 text-sm">
        <div class="flex justify-between"><span>Audit events (24h)</span><span class="font-semibold">{{ $systemStats['activity_events_24h'] }}</span></div>
        <div class="flex justify-between"><span>Failed login attempts (24h)</span><span class="font-semibold text-amber-700">{{ $systemStats['failed_logins_24h'] }}</span></div>
        <div class="flex justify-between"><span>Failed queued jobs</span><span class="font-semibold text-red-700">{{ $systemStats['failed_jobs'] }}</span></div>
        <div class="flex justify-between"><span>Administrators</span><span class="font-semibold">{{ $userStats['administrators'] }}</span></div>
      </div>
    </div>

    <!-- Performance Chart Placeholder -->
    <div class="bg-white border rounded-lg shadow-sm p-4">
    <h3 class="font-semibold text-gray-700 mb-4">7-Day Activity Trend</h3>
      <div class="space-y-2">
         @forelse($activitySeries as $index => $point)
          @php
            $rawDay = is_object($point) ? ($point->day ?? null) : (is_array($point) ? ($point['day'] ?? null) : null);
            $rawTotal = is_object($point) ? ($point->total ?? null) : (is_array($point) ? ($point['total'] ?? null) : $point);
            $displayDay = filled($rawDay) ? \Carbon\Carbon::parse($rawDay)->format('M d') : 'Day '.($loop->iteration);
            $displayTotal = is_numeric($rawTotal) ? (int) $rawTotal : 0;
          @endphp
          <div class="flex items-center justify-between text-sm">
       <span class="text-gray-600">{{ $displayDay }}</span>
            <span class="font-semibold">{{ $displayTotal }} events</span>
          </div>
        @empty
          <p class="text-sm text-gray-500">No recent activity available.</p>
        @endforelse
      </div>
    </div>
  </div>


  <!-- Latest Logs Table -->
  <div class="bg-white border rounded-lg shadow-sm">
    <div class="p-4 border-b flex justify-between items-center">
      <h3 class="font-semibold text-gray-700">Recent System Activity</h3>
 <a href="{{ route('admin.activity') }}" class="text-blue-600 hover:underline text-sm">View Audit Logs</a>
    </div>

    <div class="overflow-x-auto">
      <table class="w-full text-left text-sm">
       <thead class="bg-gray-100 text-gray-700"><tr><th class="px-6 py-3">Time</th><th class="px-6 py-3">Event</th><th class="px-6 py-3">User</th></tr></thead>
        <tbody class="divide-y">
    @forelse($recentLogs as $log)
            <tr>
              <td class="px-6 py-3">{{ $log->created_at?->format('Y-m-d H:i') }}</td>
              <td class="px-6 py-3">{{ $log->action }}</td>
              <td class="px-6 py-3">{{ optional($log->user)->email ?? 'System' }}</td>
            </tr>
          @empty
            <tr><td colspan="3" class="px-6 py-6 text-center text-gray-500">No recent logs.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

</div>

@endsection
