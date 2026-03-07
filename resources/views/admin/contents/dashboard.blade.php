@extends('admin.layout.app')

@section('content')

<div class="space-y-6">
    <div class="bg-white border border-gray-200 shadow-sm rounded-xl px-6 py-5">
        <h2 class="text-2xl font-semibold text-gray-800">Administrator Dashboard</h2>
        <p class="text-sm text-gray-500 mt-1">Monitor platform activity, user distribution, and system health from one place.</p>
    </div>

  
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4">
        <div class="bg-white border rounded-xl shadow-sm p-5">
            <h4 class="text-sm text-gray-500">Active Technicians</h4>
            <p class="text-3xl font-semibold text-gray-800 mt-2">{{ $userStats['technicians'] }}</p>
        </div>
        <div class="bg-white border rounded-xl shadow-sm p-5">
            <h4 class="text-sm text-gray-500">Pending Inquiries</h4>
            <p class="text-3xl font-semibold text-gray-800 mt-2">{{ $systemStats['pending_inquiries'] }}</p>
        </div>
        <div class="bg-white border rounded-xl shadow-sm p-5">
            <h4 class="text-sm text-gray-500">Open Quotations</h4>
            <p class="text-3xl font-semibold text-gray-800 mt-2">{{ $systemStats['open_quotations'] }}</p>
        </div>
        <div class="bg-white border rounded-xl shadow-sm p-5">
            <h4 class="text-sm text-gray-500">Total Revenue</h4>
            <p class="text-3xl font-semibold text-gray-800 mt-2">₱{{ number_format((float) $systemStats['total_revenue'], 2) }}</p>
        </div>
    </div>
  

    <div class="grid lg:grid-cols-2 gap-6">
        <div class="bg-white border rounded-xl shadow-sm p-5">
            <h3 class="font-semibold text-gray-700 mb-4">Live System Metrics</h3>
            <div class="space-y-3 text-sm">
                <div class="flex justify-between"><span class="text-gray-600">Audit events (24h)</span><span class="font-semibold">{{ $systemStats['activity_events_24h'] }}</span></div>
                <div class="flex justify-between"><span class="text-gray-600">Failed login attempts (24h)</span><span class="font-semibold text-amber-700">{{ $systemStats['failed_logins_24h'] }}</span></div>
                <div class="flex justify-between"><span class="text-gray-600">Failed queued jobs</span><span class="font-semibold text-red-700">{{ $systemStats['failed_jobs'] }}</span></div>
                <div class="flex justify-between"><span class="text-gray-600">Administrators</span><span class="font-semibold">{{ $userStats['administrators'] }}</span></div>
            </div>
        </div>

        <div class="bg-white border rounded-xl shadow-sm p-5">
            <h3 class="font-semibold text-gray-700 mb-4">7-Day Activity Trend</h3>
            <div class="space-y-2">
                @forelse($activitySeries as $point)
                    @php
                        $rawDay = is_object($point) ? ($point->day ?? null) : (is_array($point) ? ($point['day'] ?? null) : null);
                        $rawTotal = is_object($point) ? ($point->total ?? null) : (is_array($point) ? ($point['total'] ?? null) : $point);
                        $displayDay = filled($rawDay) ? \Carbon\Carbon::parse($rawDay)->format('M d') : 'Day '.($loop->iteration);
                        $displayTotal = is_numeric($rawTotal) ? (int) $rawTotal : 0;
                    @endphp
                    <div class="flex items-center justify-between text-sm bg-gray-50 rounded-lg px-3 py-2">
                        <span class="text-gray-600">{{ $displayDay }}</span>
                        <span class="font-semibold text-gray-800">{{ $displayTotal }} events</span>
                    </div>
                @empty
                    <p class="text-sm text-gray-500">No recent activity available.</p>
                @endforelse
            </div>
        </div>
    </div>

 
    <div class="bg-white border rounded-xl shadow-sm">
        <div class="p-4 border-b flex items-center justify-between">
            <h3 class="font-semibold text-gray-700">Recent System Activity</h3>
            <a href="{{ route('admin.activity') }}" class="text-blue-600 hover:underline text-sm">View Audit Logs</a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-gray-100 text-gray-700">
                    <tr>
                        <th class="px-6 py-3">Time</th>
                        <th class="px-6 py-3">Event</th>
                        <th class="px-6 py-3">User</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @forelse($recentLogs as $log)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-3">{{ $log->created_at?->format('Y-m-d H:i') }}</td>
                            <td class="px-6 py-3">{{ $log->action }}</td>
                            <td class="px-6 py-3">{{ optional($log->user)->email ?? 'System' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-6 py-6 text-center text-gray-500">No recent logs.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection