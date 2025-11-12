<x-layouts.app :title="__('Dashboard')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <!-- KPIs tailored to Techne-Fixer MIS (Inquiry → Quotation → Job → Payment) -->
        <div class="grid gap-4 md:grid-cols-4">
            <!-- Inquiries -->
            <div class="rounded-xl border border-neutral-200 bg-white p-5 dark:border-neutral-700 dark:bg-neutral-900">
                <div class="flex items-start justify-between">
                    <p class="text-sm text-neutral-500 dark:text-neutral-400">New Inquiries</p>
                    <span class="text-xs text-neutral-500 dark:text-neutral-400">Today</span>
                </div>
                <p class="mt-2 text-2xl font-semibold tracking-tight">{{ number_format($stats['inquiries']['today'] ?? 0) }}</p>
                <p class="mt-1 text-xs text-neutral-500 dark:text-neutral-400">{{ number_format($stats['inquiries']['week'] ?? 0) }} this week • Conv. {{ $stats['inquiries']['conversion_rate'] ?? '—' }}</p>

                <!-- progress -->
                <div class="mt-4 progress h-2 w-full overflow-hidden rounded-full bg-neutral-100 dark:bg-neutral-800">
                    <div class="progress__bar h-full bg-neutral-900 dark:bg-neutral-100"
                         style="--progress: {{ $stats['inquiries']['progress'] ?? 0 }};">
                    </div>
                </div>
            </div>

            <!-- Quotations -->
            <div class="rounded-xl border border-neutral-200 bg-white p-5 dark:border-neutral-700 dark:bg-neutral-900">
                <div class="flex items-start justify-between">
                    <p class="text-sm text-neutral-500 dark:text-neutral-400">Quotations Sent</p>
                    <span class="text-xs text-neutral-500 dark:text-neutral-400">Approval {{ $stats['quotations']['approval_rate'] ?? '—' }}</span>
                </div>
                <p class="mt-2 text-2xl font-semibold tracking-tight">{{ number_format($stats['quotations']['sent'] ?? 0) }}</p>
                <p class="mt-1 text-xs text-neutral-500 dark:text-neutral-400">Accepted {{ number_format($stats['quotations']['accepted'] ?? 0) }} • Rejected {{ number_format($stats['quotations']['rejected'] ?? 0) }}</p>

                <!-- progress -->
                <div class="mt-4 progress h-2 w-full overflow-hidden rounded-full bg-neutral-100 dark:bg-neutral-800">
                    <div class="progress__bar h-full bg-neutral-900 dark:bg-neutral-100"
                         style="--progress: {{ $stats['quotations']['approval_progress'] ?? 0 }};">
                    </div>
                </div>
            </div>

            <!-- Active Jobs -->
            <div class="rounded-xl border border-neutral-200 bg-white p-5 dark:border-neutral-700 dark:bg-neutral-900">
                <div class="flex items-start justify-between">
                    <p class="text-sm text-neutral-500 dark:text-neutral-400">Active Jobs</p>
                    <span class="text-xs text-neutral-500 dark:text-neutral-400">Avg TAT {{ $stats['jobs']['avg_turnaround'] ?? '—' }}</span>
                </div>
                <p class="mt-2 text-2xl font-semibold tracking-tight">{{ number_format($stats['jobs']['active'] ?? 0) }}</p>
                <p class="mt-1 text-xs text-neutral-500 dark:text-neutral-400">
                    Pending {{ number_format($stats['jobs']['pending'] ?? 0) }} •
                    In-Progress {{ number_format($stats['jobs']['in_progress'] ?? 0) }} •
                    For Pickup {{ number_format($stats['jobs']['for_pickup'] ?? 0) }}
                </p>

                <!-- progress -->
                <div class="mt-4 progress h-2 w-full overflow-hidden rounded-full bg-neutral-100 dark:bg-neutral-800">
                    <div class="progress__bar h-full bg-neutral-900 dark:bg-neutral-100"
                         style="--progress: {{ $stats['jobs']['completion_progress'] ?? 0 }};">
                    </div>
                </div>
            </div>

            <!-- Payments (Downpayment & Receivables) -->
            <div class="rounded-xl border border-neutral-200 bg-white p-5 dark:border-neutral-700 dark:bg-neutral-900">
                <div class="flex items-start justify-between">
                    <p class="text-sm text-neutral-500 dark:text-neutral-400">Collections</p>
                    <span class="text-xs text-neutral-500 dark:text-neutral-400">This month</span>
                </div>
                <p class="mt-2 text-2xl font-semibold tracking-tight">₱{{ number_format($stats['payments']['downpayments_month'] ?? 0, 2) }}</p>
                <p class="mt-1 text-xs text-neutral-500 dark:text-neutral-400">Receivables ₱{{ number_format($stats['payments']['receivables'] ?? 0, 2) }}</p>

                <!-- progress -->
                <div class="mt-4 progress h-2 w-full overflow-hidden rounded-full bg-neutral-100 dark:bg-neutral-800">
                    <div class="progress__bar h-full bg-neutral-900 dark:bg-neutral-100"
                         style="--progress: {{ $stats['payments']['collection_progress'] ?? 0 }};">
                    </div>
                </div>
            </div>
        </div>

        <!-- Secondary: Attendance/Payroll & Pipeline & Expense Summary -->
        <div class="grid auto-rows-min gap-4 md:grid-cols-3">
            <!-- Attendance & Payroll -->
            <div class="rounded-xl border border-neutral-200 bg-white p-5 dark:border-neutral-700 dark:bg-neutral-900">
                <div class="flex items-center justify-between">
                    <h3 class="text-sm font-medium text-neutral-900 dark:text-neutral-100">Attendance & Payroll</h3>
                    <span class="text-xs text-neutral-500 dark:text-neutral-400">This cutoff</span>
                </div>
                <dl class="mt-4 space-y-3">
                    <div class="flex items-center justify-between">
                        <dt class="text-sm text-neutral-600 dark:text-neutral-300">Compliance</dt>
                        <dd class="text-sm font-semibold">{{ $stats['attendance']['compliance_rate'] ?? '—' }}</dd>
                    </div>
                    <div class="flex items-center justify-between">
                        <dt class="text-sm text-neutral-600 dark:text-neutral-300">Late/Absences</dt>
                        <dd class="text-sm font-semibold">{{ number_format($stats['attendance']['late'] ?? 0) }}/{{ number_format($stats['attendance']['absent'] ?? 0) }}</dd>
                    </div>
                    <div class="flex items-center justify-between">
                        <dt class="text-sm text-neutral-600 dark:text-neutral-300">Payroll Due</dt>
                        <dd class="text-sm font-semibold">₱{{ number_format($stats['payroll']['due'] ?? 0, 2) }}</dd>
                    </div>
                </dl>
            </div>

            <!-- Funnel: Inquiry → Quotation → Job → Paid -->
            <div class="rounded-xl border border-neutral-200 bg-white p-5 dark:border-neutral-700 dark:bg-neutral-900">
                <div class="flex items-center justify-between">
                    <h3 class="text-sm font-medium text-neutral-900 dark:text-neutral-100">Service Pipeline</h3>
                    <span class="text-xs text-neutral-500 dark:text-neutral-400">This month</span>
                </div>
                <ul class="mt-4 space-y-3">
                    <li class="flex items-center justify-between"><span class="text-sm text-neutral-600 dark:text-neutral-300">Inquiries</span><span class="text-sm font-semibold">{{ number_format($stats['pipeline']['inquiries'] ?? 0) }}</span></li>
                    <li class="flex items-center justify-between"><span class="text-sm text-neutral-600 dark:text-neutral-300">Quotations</span><span class="text-sm font-semibold">{{ number_format($stats['pipeline']['quotations'] ?? 0) }}</span></li>
                    <li class="flex items-center justify-between"><span class="text-sm text-neutral-600 dark:text-neutral-300">Jobs Created</span><span class="text-sm font-semibold">{{ number_format($stats['pipeline']['jobs'] ?? 0) }}</span></li>
                    <li class="flex items-center justify-between"><span class="text-sm text-neutral-600 dark:text-neutral-300">Paid</span><span class="text-sm font-semibold">{{ number_format($stats['pipeline']['paid'] ?? 0) }}</span></li>
                </ul>
            </div>

            <!-- Expenses Snapshot (taxes, materials, utilities) -->
            <div class="rounded-xl border border-neutral-200 bg-white p-5 dark:border-neutral-700 dark:bg-neutral-900">
                <div class="flex items-center justify-between">
                    <h3 class="text-sm font-medium text-neutral-900 dark:text-neutral-100">Expenses Snapshot</h3>
                    <span class="text-xs text-neutral-500 dark:text-neutral-400">This month</span>
                </div>
                <dl class="mt-4 space-y-3">
                    <div class="flex items-center justify-between"><dt class="text-sm text-neutral-600 dark:text-neutral-300">Materials</dt><dd class="text-sm font-semibold">₱{{ number_format($stats['expenses']['materials'] ?? 0, 2) }}</dd></div>
                    <div class="flex items-center justify-between"><dt class="text-sm text-neutral-600 dark:text-neutral-300">Utilities & Rent</dt><dd class="text-sm font-semibold">₱{{ number_format($stats['expenses']['overhead'] ?? 0, 2) }}</dd></div>
                    <div class="flex items-center justify-between"><dt class="text-sm text-neutral-600 dark:text-neutral-300">Taxes (Quarterly est.)</dt><dd class="text-sm font-semibold">₱{{ number_format($stats['expenses']['tax_est'] ?? 0, 2) }}</dd></div>
                </dl>
            </div>
        </div>

        <!-- Main: Recent Job Orders (aligned with ERD fields) -->
        <div class="relative h-full flex-1 overflow-hidden rounded-xl border border-neutral-200 bg-white dark:border-neutral-700 dark:bg-neutral-900">
            <div class="flex items-center justify-between border-b border-neutral-200 p-4 dark:border-neutral-700">
                <h3 class="text-sm font-medium text-neutral-900 dark:text-neutral-100">Recent Job Orders</h3>
                <button type="button" class="text-xs text-neutral-500 underline-offset-2 hover:underline dark:text-neutral-400 cursor-default" aria-disabled="true">View all</button>
            </div>
            <div class="overflow-x-auto p-4">
                <table class="min-w-full text-left text-sm">
                    <thead class="text-xs text-neutral-500 dark:text-neutral-400">
                        <tr>
                            <th class="py-2 pr-4">Job #</th>
                            <th class="py-2 pr-4">Customer</th>
                            <th class="py-2 pr-4">Device/Issue</th>
                            <th class="py-2 pr-4">Technician</th>
                            <th class="py-2 pr-4">Status</th>
                            <th class="py-2 pr-4 text-right">Quoted</th>
                            <th class="py-2 pr-4 text-right">Downpayment</th>
                            <th class="py-2 pr-0 text-right">Balance</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-neutral-200 dark:divide-neutral-800">
                        @foreach(($stats['recent_jobs'] ?? []) as $job)
                            <tr>
                                <td class="py-3 pr-4 font-medium">{{ $job['id'] }}</td>
                                <td class="py-3 pr-4">{{ $job['customer'] }}</td>
                                <td class="py-3 pr-4">{{ $job['device'] ?? $job['issue'] ?? '—' }}</td>
                                <td class="py-3 pr-4">{{ $job['technician'] ?? '—' }}</td>
                                <td class="py-3 pr-4">
                                    @php($status = strtolower($job['status'] ?? ''))
                                    <span @class([
                                        'inline-flex items-center rounded-full px-2 py-0.5 text-xs font-medium',
                                        'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/40 dark:text-yellow-300' => $status === 'pending',
                                        'bg-blue-100 text-blue-700 dark:bg-blue-900/40 dark:text-blue-300' => $status === 'in-progress',
                                        'bg-green-100 text-green-700 dark:bg-green-900/40 dark:text-green-300' => $status === 'completed',
                                        'bg-purple-100 text-purple-700 dark:bg-purple-900/40 dark:text-purple-300' => $status === 'for pickup',
                                        'bg-neutral-100 text-neutral-700 dark:bg-neutral-800 dark:text-neutral-300' => !in_array($status, ['pending','in-progress','completed','for pickup']),
                                    ])>
                                        {{ ucfirst($status) ?: '—' }}
                                    </span>
                                </td>
                                <td class="py-3 pr-4 text-right">₱{{ number_format($job['quoted'] ?? 0, 2) }}</td>
                                <td class="py-3 pr-4 text-right">₱{{ number_format($job['downpayment'] ?? 0, 2) }}</td>
                                <td class="py-3 pr-0 text-right font-semibold">₱{{ number_format(($job['quoted'] ?? 0) - ($job['downpayment'] ?? 0) - ($job['paid'] ?? 0), 2) }}</td>
                            </tr>
                        @endforeach
                        @if(empty($stats['recent_jobs']))
                            <tr>
                                <td colspan="8" class="py-6 text-center text-neutral-500 dark:text-neutral-400">No recent jobs yet.</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-layouts.app>
