<x-layouts.app :title="__('Reports')">

    <div class="flex h-full w-full flex-1 flex-col gap-6">

        {{-- Header --}}
        <nav class="w-full bg-white border-b border-gray-100 px-6 py-4 flex flex-col gap-3 md:flex-row md:items-center md:justify-between rounded-lg shadow-sm dark:bg-neutral-900 dark:border-neutral-700">
            <div class="flex items-center gap-3">
                <div class="h-10 w-10 rounded-lg bg-emerald-50 flex items-center justify-center dark:bg-emerald-900/20">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-emerald-600 dark:text-emerald-400">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6a7.5 7.5 0 107.5 7.5h-7.5V6z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 10.5H21A7.5 7.5 0 0013.5 3v7.5z" />
                    </svg>
                </div>
                <div>
                    <h1 class="text-lg md:text-xl font-semibold text-gray-900 dark:text-neutral-50">Reports</h1>
                    <p class="text-xs text-gray-500 dark:text-neutral-400">Track revenue, job orders, and business performance</p>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <form action="{{ route('manager.reports.export') }}" method="POST" class="inline-flex">
                    @csrf
                    <input type="hidden" name="date_from" id="export_date_from" value="{{ request('date_from') }}">
                    <input type="hidden" name="date_to" id="export_date_to" value="{{ request('date_to') }}">
                    <input type="hidden" name="period" id="export_period" value="{{ request('period', 'all_time') }}">
                    <button type="submit" class="inline-flex items-center justify-center rounded-lg border border-gray-200 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 transition dark:border-neutral-700 dark:bg-neutral-900 dark:text-neutral-100 dark:hover:bg-neutral-800">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                        </svg>
                        Export CSV
                    </button>
                </form>
            </div>
        </nav>

        {{-- Date Filters --}}
        <div class="bg-white border border-gray-100 rounded-xl shadow-sm p-4 dark:bg-neutral-900 dark:border-neutral-700">
            <form method="GET" action="{{ route('manager.reports.index') }}" id="filterForm">
                <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                    <div class="flex flex-wrap items-center gap-2">
                        <span class="text-sm text-gray-500 dark:text-neutral-400">Period:</span>
                        <button type="button" onclick="setPeriod('all_time')" class="period-btn rounded-full px-4 py-1.5 text-xs font-medium transition {{ request('period', 'all_time') === 'all_time' ? 'bg-emerald-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200 dark:bg-neutral-800 dark:text-neutral-100 dark:hover:bg-neutral-700' }}">
                            All Time
                        </button>
                        <button type="button" onclick="setPeriod('this_week')" class="period-btn rounded-full px-4 py-1.5 text-xs font-medium transition {{ request('period') === 'this_week' ? 'bg-emerald-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200 dark:bg-neutral-800 dark:text-neutral-100 dark:hover:bg-neutral-700' }}">
                            This Week
                        </button>
                        <button type="button" onclick="setPeriod('this_month')" class="period-btn rounded-full px-4 py-1.5 text-xs font-medium transition {{ request('period') === 'this_month' ? 'bg-emerald-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200 dark:bg-neutral-800 dark:text-neutral-100 dark:hover:bg-neutral-700' }}">
                            This Month
                        </button>
                        <button type="button" onclick="setPeriod('last_month')" class="period-btn rounded-full px-4 py-1.5 text-xs font-medium transition {{ request('period') === 'last_month' ? 'bg-emerald-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200 dark:bg-neutral-800 dark:text-neutral-100 dark:hover:bg-neutral-700' }}">
                            Last Month
                        </button>
                        <button type="button" onclick="setPeriod('this_year')" class="period-btn rounded-full px-4 py-1.5 text-xs font-medium transition {{ request('period') === 'this_year' ? 'bg-emerald-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200 dark:bg-neutral-800 dark:text-neutral-100 dark:hover:bg-neutral-700' }}">
                            This Year
                        </button>
                    </div>

                    <div class="flex items-center gap-2">
                        <span class="text-sm text-gray-500 dark:text-neutral-400">Custom:</span>
                        <input type="date" name="date_from" id="date_from" value="{{ request('date_from') }}" onchange="setPeriod('custom')" class="rounded-lg border border-gray-200 bg-gray-50 px-3 py-1.5 text-xs text-gray-800 focus:border-emerald-500 focus:outline-none focus:ring-1 focus:ring-emerald-500 dark:border-neutral-700 dark:bg-neutral-900 dark:text-neutral-100">
                        <span class="text-gray-400">–</span>
                        <input type="date" name="date_to" id="date_to" value="{{ request('date_to') }}" onchange="setPeriod('custom')" class="rounded-lg border border-gray-200 bg-gray-50 px-3 py-1.5 text-xs text-gray-800 focus:border-emerald-500 focus:outline-none focus:ring-1 focus:ring-emerald-500 dark:border-neutral-700 dark:bg-neutral-900 dark:text-neutral-100">
                        <button type="submit" class="ml-2 rounded-lg bg-emerald-600 px-4 py-1.5 text-xs font-semibold text-white hover:bg-emerald-500 transition">
                            Apply
                        </button>
                    </div>
                </div>
                <input type="hidden" name="period" id="period" value="{{ request('period', 'all_time') }}">
            </form>
        </div>

        {{-- Summary Cards --}}
        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
            <div class="bg-white border border-gray-100 rounded-xl shadow-sm p-5 dark:bg-neutral-900 dark:border-neutral-700">
                <p class="text-xs font-medium text-gray-500 dark:text-neutral-400">Total Revenue</p>
                <p class="text-2xl font-semibold text-gray-900 mt-1 dark:text-neutral-50 text-right">
                    ₱{{ number_format($stats['reports']['total_revenue'] ?? 0, 2) }}
                </p>
                <p class="text-xs text-blue-600 mt-2 dark:text-blue-400 text-right">Jobs + diagnostic fees</p>
            </div>

            <div class="bg-white border border-gray-100 rounded-xl shadow-sm p-5 dark:bg-neutral-900 dark:border-neutral-700">
                <p class="text-xs font-medium text-gray-500 dark:text-neutral-400">Completed Job Revenue</p>
                <p class="text-2xl font-semibold text-gray-900 mt-1 dark:text-neutral-50 text-right">
                    ₱{{ number_format($stats['reports']['completed_jobs_revenue'] ?? 0, 2) }}
                </p>
                <p class="text-xs text-emerald-600 mt-2 dark:text-emerald-400 text-right">From completed jobs</p>
            </div>

            <div class="bg-white border border-gray-100 rounded-xl shadow-sm p-5 dark:bg-neutral-900 dark:border-neutral-700">
                <p class="text-xs font-medium text-gray-500 dark:text-neutral-400">Downpayments Collected</p>
                <p class="text-2xl font-semibold text-gray-900 mt-1 dark:text-neutral-50 text-right">
                    ₱{{ number_format($stats['reports']['downpayments_received'] ?? 0, 2) }}
                </p>
                <p class="text-xs text-amber-600 mt-2 dark:text-amber-400 text-right">50% of completed jobs</p>
            </div>

            <div class="bg-white border border-gray-100 rounded-xl shadow-sm p-5 dark:bg-neutral-900 dark:border-neutral-700">
                <p class="text-xs font-medium text-gray-500 dark:text-neutral-400">Diagnostic Fees</p>
                <p class="text-2xl font-semibold text-gray-900 mt-1 dark:text-neutral-50 text-right">
                    ₱{{ number_format($stats['reports']['diagnostic_fees'] ?? 0, 2) }}
                </p>
                <p class="text-xs text-purple-600 mt-2 dark:text-purple-400 text-right">Upfront fees collected</p>
            </div>
        </div>

        {{-- Revenue Chart --}}
        <div class="bg-white border border-gray-100 rounded-xl shadow-sm p-5 dark:bg-neutral-900 dark:border-neutral-700">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h3 class="font-semibold text-gray-900 dark:text-neutral-50">Revenue Overview</h3>
                    <p class="text-xs text-gray-500 dark:text-neutral-400 text-right">Daily revenue breakdown for selected period</p>
                </div>
            </div>
            <div class="h-64">
                <canvas id="revenueChart"></canvas>
            </div>
        </div>

        {{-- Insights Section --}}
        <div class="grid gap-4 md:grid-cols-2">
            {{-- Revenue Breakdown --}}
            <div class="bg-white border border-gray-100 rounded-xl shadow-sm p-5 dark:bg-neutral-900 dark:border-neutral-700">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-semibold text-gray-900 dark:text-neutral-50">Revenue Breakdown</h3>
                    <span class="text-xs text-gray-400 dark:text-neutral-500">Actual collections</span>
                </div>

                <div class="space-y-3 text-sm">
                    <div class="flex items-center justify-between">
                        <span class="text-gray-700 dark:text-neutral-300">Completed job orders</span>
                        <span class="font-semibold text-gray-900 dark:text-neutral-50">₱{{ number_format($stats['reports']['completed_jobs_revenue'] ?? 0, 2) }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-gray-700 dark:text-neutral-300">Downpayments (50%)</span>
                        <span class="font-semibold text-gray-900 dark:text-neutral-50">₱{{ number_format($stats['reports']['downpayments_received'] ?? 0, 2) }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-gray-700 dark:text-neutral-300">Remaining balance (50%)</span>
                        <span class="font-semibold text-gray-900 dark:text-neutral-50">₱{{ number_format($stats['reports']['remaining_balance'] ?? 0, 2) }}</span>
                    </div>
                    <div class="flex items-center justify-between border-t pt-3 dark:border-neutral-700">
                        <span class="text-gray-700 dark:text-neutral-300">Diagnostic fees</span>
                        <span class="font-semibold text-gray-900 dark:text-neutral-50">₱{{ number_format($stats['reports']['diagnostic_fees'] ?? 0, 2) }}</span>
                    </div>
                    <div class="flex items-center justify-between border-t pt-3 dark:border-neutral-700">
                        <span class="text-gray-600 font-medium dark:text-neutral-300">Total revenue</span>
                        <span class="font-semibold text-emerald-600 dark:text-emerald-400">₱{{ number_format($stats['reports']['total_revenue'] ?? 0, 2) }}</span>
                    </div>
                </div>
            </div>

            {{-- Job Order Statistics --}}
            <div class="bg-white border border-gray-100 rounded-xl shadow-sm p-5 dark:bg-neutral-900 dark:border-neutral-700">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-semibold text-gray-900 dark:text-neutral-50">Job Order Statistics</h3>
                </div>

                <div class="space-y-3 text-sm">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2 text-gray-700 dark:text-neutral-300">
                            <span class="w-2.5 h-2.5 rounded-full bg-gray-500"></span>
                            <span>Total jobs</span>
                        </div>
                        <span class="font-semibold text-gray-900 dark:text-neutral-50">{{ $stats['counts']['total_jobs'] ?? 0 }}</span>
                    </div>

                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2 text-gray-700 dark:text-neutral-300">
                            <span class="w-2.5 h-2.5 rounded-full bg-amber-400"></span>
                            <span>Active jobs</span>
                        </div>
                        <span class="font-semibold text-amber-600 dark:text-amber-400">{{ $stats['counts']['active_jobs'] ?? 0 }}</span>
                    </div>

                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2 text-gray-700 dark:text-neutral-300">
                            <span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span>
                            <span>Completed jobs</span>
                        </div>
                        <span class="font-semibold text-emerald-600 dark:text-emerald-400">{{ $stats['counts']['completed_jobs'] ?? 0 }}</span>
                    </div>

                    <div class="flex items-center justify-between border-t pt-3 dark:border-neutral-700">
                        <span class="text-gray-700 dark:text-neutral-300">Quotation approval rate</span>
                        <span class="font-semibold text-gray-900 dark:text-neutral-50">{{ $stats['reports']['approval_rate'] ?? 0 }}%</span>
                    </div>

                    <div class="flex items-center justify-between">
                        <span class="text-gray-700 dark:text-neutral-300">Avg. job value</span>
                        <span class="font-semibold text-gray-900 dark:text-neutral-50">₱{{ number_format($stats['reports']['avg_job_value'] ?? 0, 2) }}</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tables Section --}}
        <div class="grid gap-4 lg:grid-cols-2">
            {{-- Recent Job Orders --}}
            <div class="bg-white border border-gray-100 rounded-xl shadow-sm overflow-hidden lg:col-span-2 dark:bg-neutral-900 dark:border-neutral-700">
                <div class="p-5 border-b border-gray-100 flex items-center justify-between dark:border-neutral-700">
                    <div>
                        <h3 class="font-semibold text-gray-900 dark:text-neutral-50">Recent Job Orders</h3>
                        <p class="text-xs text-gray-500 dark:text-neutral-400">Latest completed jobs across all technicians</p>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left table-fixed">
                        <thead class="bg-gray-50 text-gray-700 dark:bg-neutral-800 dark:text-neutral-300">
                            <tr class="border-b border-gray-100 dark:border-neutral-700">
                                <!-- INCREASED PADDING to px-6 py-4 & ADJUSTED WIDTHS -->
                                <th class="px-6 py-4 font-medium w-[12%]">Job #</th>
                                <th class="px-6 py-4 font-medium w-[30%]">Customer</th>
                                <th class="px-6 py-4 font-medium w-[25%]">Technician</th>
                                <th class="px-6 py-4 font-medium text-center w-[13%]">Status</th>
                                <th class="px-6 py-4 font-medium text-right w-[20%]">Amount</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-neutral-700">
                            @forelse($recentJobs ?? [] as $job)
                                @php
                                    $statusClass = match($job->status) {
                                        'completed'   => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/20 dark:text-emerald-400',
                                        'in_progress' => 'bg-amber-100 text-amber-700 dark:bg-amber-900/20 dark:text-amber-400',
                                        'scheduled'   => 'bg-blue-100 text-blue-700 dark:bg-blue-900/20 dark:text-blue-400',
                                        'cancelled'   => 'bg-rose-100 text-rose-700 dark:bg-rose-900/20 dark:text-rose-400',
                                        default       => 'bg-gray-100 text-gray-700 dark:bg-neutral-800 dark:text-neutral-300'
                                    };
                                @endphp
                                <tr class="hover:bg-gray-50 dark:hover:bg-neutral-800/50">
                                    <!-- INCREASED PADDING to px-6 py-4 & ADDED TRUNCATE/WRAPPING -->
                                    <td class="px-6 py-4 font-semibold text-gray-900 dark:text-neutral-50 truncate">
                                        JOB-{{ str_pad($job->id, 4, '0', STR_PAD_LEFT) }}
                                    </td>
                                    <td class="px-6 py-4 text-gray-800 dark:text-neutral-200 whitespace-normal break-words">
                                        {{ $job->quotation?->client_name ?? $job->customer_name ?? '—' }}
                                    </td>
                                    <td class="px-6 py-4 text-gray-800 dark:text-neutral-200 whitespace-normal break-words">
                                        {{ $job->technician?->name ?? '—' }}
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="inline-flex items-center rounded-full px-2.5 py-1 text-xs font-medium {{ $statusClass }} truncate">
                                            {{ ucfirst(str_replace('_', ' ', $job->status ?? 'pending')) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-right font-semibold text-gray-900 dark:text-neutral-50 truncate">
                                        ₱{{ number_format($job->subtotal ?? 0, 2) }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-8 text-center text-gray-500 dark:text-neutral-400">
                                        No job orders found for this period.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Top Revenue Jobs --}}
            <div class="bg-white border border-gray-100 rounded-xl shadow-sm overflow-hidden dark:bg-neutral-900 dark:border-neutral-700">
                <div class="p-5 border-b border-gray-100 flex items-center justify-between dark:border-neutral-700">
                    <div>
                        <h3 class="font-semibold text-gray-900 dark:text-neutral-50">Top Revenue Jobs</h3>
                        <p class="text-xs text-gray-500 dark:text-neutral-400">Highest earning jobs</p>
                    </div>
                </div>

                <div class="divide-y divide-gray-100 dark:divide-neutral-700">
                    @forelse($topRevenueJobs ?? [] as $job)
                        <!-- INCREASED PADDING to px-6 py-5 -->
                        <div class="px-6 py-5">
                            <div class="flex items-start justify-between gap-3">
                                <div class="flex-1 min-w-0">
                                    <p class="font-semibold text-gray-900 dark:text-neutral-50 line-clamp-2">
                                        {{ $job->quotation?->project_title ?? 'Job Order' }}
                                    </p>
                                    <p class="text-xs text-gray-500 mt-1 dark:text-neutral-400 truncate">
                                        JOB-{{ str_pad($job->id, 4, '0', STR_PAD_LEFT) }}
                                    </p>
                                </div>

                                <span class="inline-flex items-center rounded-full px-2.5 py-1 text-xs font-medium bg-emerald-100 text-emerald-700 dark:bg-emerald-900/20 dark:text-emerald-400 shrink-0">
                                    Completed
                                </span>
                            </div>

                            <div class="mt-3 flex items-center justify-between text-sm text-gray-700 dark:text-neutral-300">
                                <span class="flex-1 truncate">
                                    {{ $job->quotation?->client_name ?? 'Customer' }}
                                </span>
                                <span class="font-semibold text-gray-900 dark:text-neutral-50 shrink-0">
                                    ₱{{ number_format($job->calculated_subtotal ?? $job->subtotal ?? $job->quotation?->subtotal ?? 0, 2) }}
                                </span>
                            </div>
                        </div>
                    @empty
                        <p class="px-6 py-10 text-center text-gray-500 text-sm dark:text-neutral-400">
                            No completed jobs yet.
                        </p>
                    @endforelse
                </div>
            </div>
            </div>
            {{-- Technician Performance --}}
            <div class="bg-white border border-gray-100 rounded-xl shadow-sm overflow-hidden dark:bg-neutral-900 dark:border-neutral-700">
                <div class="p-5 border-b border-gray-100 flex items-center justify-between dark:border-neutral-700">
                    <div>
                        <h3 class="font-semibold text-gray-900 dark:text-neutral-50">Technician Performance</h3>
                        <p class="text-xs text-gray-500 dark:text-neutral-400">Revenue and job completion by technician</p>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left table-fixed">
                        <thead class="bg-gray-50 text-gray-700 dark:bg-neutral-800 dark:text-neutral-300">
                            <tr class="border-b border-gray-100 dark:border-neutral-700">
                                <!-- INCREASED PADDING to px-6 py-4 & ADJUSTED WIDTHS -->
                                <th class="px-6 py-4 font-medium w-[30%]">Technician</th>
                                <th class="px-6 py-4 font-medium text-center w-[12%]">Total Jobs</th>
                                <th class="px-6 py-4 font-medium text-center w-[12%]">Completed</th>
                                <th class="px-6 py-4 font-medium text-center w-[12%]">Active</th>
                                <th class="px-6 py-4 font-medium text-right w-[18%]">Total Revenue</th>
                                <th class="px-6 py-4 font-medium text-right w-[16%]">Avg. Job Value</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-neutral-700">
                            @forelse($technicianPerformance ?? [] as $tech)
                                <tr class="hover:bg-gray-50 dark:hover:bg-neutral-800/50">
                                    <!-- INCREASED PADDING to px-6 py-4 & ADDED TRUNCATE/WRAPPING -->
                                    <td class="px-6 py-4 font-semibold text-gray-900 dark:text-neutral-50 whitespace-normal break-words">
                                        {{ $tech->name }}
                                    </td>
                                    <td class="px-6 py-4 text-center text-gray-800 dark:text-neutral-200 truncate">
                                        {{ $tech->total_jobs ?? 0 }}
                                    </td>
                                    <td class="px-6 py-4 text-center text-emerald-600 font-semibold dark:text-emerald-400 truncate">
                                        {{ $tech->completed_jobs ?? 0 }}
                                    </td>
                                    <td class="px-6 py-4 text-center text-amber-600 font-semibold dark:text-amber-400 truncate">
                                        {{ $tech->active_jobs ?? 0 }}
                                    </td>
                                    <td class="px-6 py-4 text-right font-semibold text-gray-900 dark:text-neutral-50 truncate">
                                        ₱{{ number_format($tech->total_revenue ?? 0, 2) }}
                                    </td>
                                    <td class="px-6 py-4 text-right text-gray-800 dark:text-neutral-200 truncate">
                                        ₱{{ number_format($tech->avg_job_value ?? 0, 2) }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-8 text-center text-gray-500 dark:text-neutral-400">
                                        No technician data available.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
    </div>

    {{-- Chart.js Script --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Filter functionality
        function setPeriod(period) {
            document.getElementById('period').value = period;

            // Update export form hidden fields
            document.getElementById('export_period').value = period;
            document.getElementById('export_date_from').value = document.getElementById('date_from').value;
            document.getElementById('export_date_to').value = document.getElementById('date_to').value;

            if (period !== 'custom') {
                document.getElementById('filterForm').submit();
            }
        }

        // Revenue Chart
        const ctx = document.getElementById('revenueChart');
        if (ctx) {
            const isDark = document.documentElement.classList.contains('dark');
            const textColor = isDark ? '#d4d4d8' : '#374151';
            const gridColor = isDark ? '#374151' : '#e5e7eb';

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: @json($chartData['labels'] ?? []),
                    datasets: [{
                        label: 'Total Revenue',
                        data: @json($chartData['revenue'] ?? []),
                        borderColor: '#10b981',
                        backgroundColor: 'rgba(16, 185, 129, 0.1)',
                        tension: 0.4,
                        fill: true
                    }, {
                        label: 'Completed Jobs Revenue',
                        data: @json($chartData['completed_revenue'] ?? []),
                        borderColor: '#3b82f6',
                        backgroundColor: 'rgba(59, 130, 246, 0.1)',
                        tension: 0.4,
                        fill: true
                    }, {
                        label: 'Diagnostic Fees',
                        data: @json($chartData['diagnostic_fees'] ?? []),
                        borderColor: '#a855f7',
                        backgroundColor: 'rgba(168, 85, 247, 0.1)',
                        tension: 0.4,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                color: textColor,
                                usePointStyle: true,
                                padding: 15
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return context.dataset.label + ': ₱' + context.parsed.y.toLocaleString('en-PH', {minimumFractionDigits: 2});
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                color: textColor,
                                callback: function(value) {
                                    return '₱' + value.toLocaleString('en-PH');
                                }
                            },
                            grid: {
                                color: gridColor
                            }
                        },
                        x: {
                            ticks: {
                                color: textColor
                            },
                            grid: {
                                color: gridColor
                            }
                        }
                    }
                }
            });
        }
    </script>
</x-layouts.app>
