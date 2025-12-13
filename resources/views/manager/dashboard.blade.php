<x-layouts.app :title="__('Dashboard')">
    @php
        $rangeLabels = [
            'today'   => 'Today',
            'week'    => 'This week',
            'month'   => 'This month',
            'quarter' => 'This quarter',
            'year'    => 'This year',
        ];

        $rangeLabel = $rangeLabels[$range] ?? 'Custom';
    @endphp

    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">

        {{-- Filter --}}
        <div class="flex items-center justify-end">
            <form method="GET" class="flex items-center gap-2">
                <span class="text-xs font-medium text-neutral-500 dark:text-neutral-400">
                    {{ __('Filter period:') }}
                </span>

                <select
                    name="range"
                    class="rounded-lg border border-neutral-200 bg-white px-3 py-2 text-xs
                           focus:outline-none focus:ring-2 focus:ring-neutral-200
                           dark:border-neutral-700 dark:bg-neutral-900 dark:focus:ring-neutral-700"
                    onchange="this.form.submit()"
                >
                    <option value="today"   @selected($range === 'today')>{{ __('Today') }}</option>
                    <option value="week"    @selected($range === 'week')>{{ __('This week') }}</option>
                    <option value="month"   @selected($range === 'month')>{{ __('This month') }}</option>
                    <option value="quarter" @selected($range === 'quarter')>{{ __('This quarter') }}</option>
                    <option value="year"    @selected($range === 'year')>{{ __('This year') }}</option>
                </select>
            </form>
        </div>

        {{-- Core KPIs --}}
        <div class="grid gap-4 md:grid-cols-4">
            {{-- Inquiries --}}
            <div class="rounded-xl border border-neutral-200 bg-white p-5 dark:border-neutral-700 dark:bg-neutral-900">
                <div class="flex items-start justify-between gap-3">
                    <p class="text-sm text-neutral-500 dark:text-neutral-400">{{ __('New inquiries') }}</p>
                    <span class="text-xs text-neutral-500 dark:text-neutral-400">{{ $rangeLabel }}</span>
                </div>

                <p class="mt-2 text-3xl font-semibold tracking-tight text-neutral-900 dark:text-neutral-50">
                    {{ number_format($stats['inquiries']['total'] ?? 0) }}
                </p>

                <p class="mt-1 text-xs text-neutral-500 dark:text-neutral-400">
                    {{ __('Converted') }} {{ number_format($stats['inquiries']['converted'] ?? 0) }}
                </p>
            </div>

            {{-- Quotations --}}
            <div class="rounded-xl border border-neutral-200 bg-white p-5 dark:border-neutral-700 dark:bg-neutral-900">
                <div class="flex items-start justify-between gap-3">
                    <p class="text-sm text-neutral-500 dark:text-neutral-400">{{ __('Quotations approved') }}</p>
                    <span class="text-xs text-neutral-500 dark:text-neutral-400">{{ $rangeLabel }}</span>
                </div>

                <p class="mt-2 text-3xl font-semibold tracking-tight text-neutral-900 dark:text-neutral-50">
                    {{ number_format($stats['quotations']['approved'] ?? 0) }}
                </p>

                <p class="mt-1 text-xs text-neutral-500 dark:text-neutral-400">
                    {{ __('Sent') }} {{ number_format($stats['quotations']['sent'] ?? 0) }}
                    • {{ __('Approval rate') }}
                    {{ $stats['quotations']['approval_rate'] !== null ? $stats['quotations']['approval_rate'] . '%' : '—' }}
                </p>
            </div>

            {{-- Active Jobs --}}
            <div class="rounded-xl border border-neutral-200 bg-white p-5 dark:border-neutral-700 dark:bg-neutral-900">
                <div class="flex items-start justify-between gap-3">
                    <p class="text-sm text-neutral-500 dark:text-neutral-400">{{ __('Active job orders') }}</p>
                    <span class="text-xs text-neutral-500 dark:text-neutral-400">{{ $rangeLabel }}</span>
                </div>

                <p class="mt-2 text-3xl font-semibold tracking-tight text-neutral-900 dark:text-neutral-50">
                    {{ number_format($stats['jobs']['active'] ?? 0) }}
                </p>

                <p class="mt-1 text-xs text-neutral-500 dark:text-neutral-400">
                    {{ __('Includes ongoing + pending jobs') }}
                </p>
            </div>

            {{-- Revenue --}}
            <div class="rounded-xl border border-neutral-200 bg-white p-5 dark:border-neutral-700 dark:bg-neutral-900">
                <div class="flex items-start justify-between gap-3">
                    <p class="text-sm text-neutral-500 dark:text-neutral-400">{{ __('Approved revenue') }}</p>
                    <span class="text-xs text-neutral-500 dark:text-neutral-400">{{ $rangeLabel }}</span>
                </div>

                <p class="mt-2 text-3xl font-semibold tracking-tight text-neutral-900 dark:text-neutral-50">
                    ₱{{ number_format($stats['revenue']['approved_total'] ?? 0, 2) }}
                </p>

                <p class="mt-1 text-xs text-neutral-500 dark:text-neutral-400">
                    {{ __('From approved quotations') }}
                </p>
            </div>
        </div>

        {{-- Job Status Cards --}}
        <div class="grid gap-4 md:grid-cols-3">
            {{-- Ongoing --}}
            <div class="rounded-xl border border-neutral-200 bg-white p-4 dark:border-neutral-700 dark:bg-neutral-900">
                <div class="flex items-center justify-between">
                    <h3 class="text-sm font-medium text-neutral-900 dark:text-neutral-100">{{ __('Ongoing jobs') }}</h3>
                    <x-flux::icon name="wrench" class="h-5 w-5 text-blue-500" />
                </div>
                <p class="mt-2 text-2xl font-semibold text-blue-600">
                    {{ number_format($stats['jobs']['ongoing'] ?? 0) }}
                </p>
                <p class="mt-1 text-xs text-neutral-500 dark:text-neutral-400">
                    {{ __('Technicians currently assigned') }}
                </p>
            </div>

            {{-- Completed --}}
            <div class="rounded-xl border border-neutral-200 bg-white p-4 dark:border-neutral-700 dark:bg-neutral-900">
                <div class="flex items-center justify-between">
                    <h3 class="text-sm font-medium text-neutral-900 dark:text-neutral-100">{{ __('Completed jobs') }}</h3>
                    <x-flux::icon name="check-circle" class="h-5 w-5 text-emerald-500" />
                </div>
                <p class="mt-2 text-2xl font-semibold text-emerald-600">
                    {{ number_format($stats['jobs']['completed'] ?? 0) }}
                </p>
                <p class="mt-1 text-xs text-neutral-500 dark:text-neutral-400">
                    {{ __('Finished successfully') }}
                </p>
            </div>

            {{-- Pending --}}
            <div class="rounded-xl border border-neutral-200 bg-white p-4 dark:border-neutral-700 dark:bg-neutral-900">
                <div class="flex items-center justify-between">
                    <h3 class="text-sm font-medium text-neutral-900 dark:text-neutral-100">{{ __('Pending jobs') }}</h3>
                    <x-flux::icon name="clock" class="h-5 w-5 text-amber-500" />
                </div>
                <p class="mt-2 text-2xl font-semibold text-amber-600">
                    {{ number_format($stats['jobs']['pending'] ?? 0) }}
                </p>
                <p class="mt-1 text-xs text-neutral-500 dark:text-neutral-400">
                    {{ __('Queued and waiting to start') }}
                </p>
            </div>
        </div>

        {{-- Recent Job Orders --}}
        <div class="overflow-hidden rounded-xl border border-neutral-200 bg-white dark:border-neutral-700 dark:bg-neutral-900">
            <div class="flex items-center justify-between border-b border-neutral-200 p-4 dark:border-neutral-700">
                <div>
                    <h3 class="text-sm font-medium text-neutral-900 dark:text-neutral-100">
                        {{ __('Recent Job Orders') }}
                    </h3>
                    <span class="text-xs text-neutral-500 dark:text-neutral-400">{{ $rangeLabel }}</span>
                </div>

                <span class="text-xs text-neutral-400">{{ __('Latest activity') }}</span>
            </div>

            <div class="p-4">
                <div class="overflow-x-auto">
                    <table class="min-w-full text-left text-sm">
                        <thead class="text-xs text-neutral-500 dark:text-neutral-400">
                            <tr class="border-b border-neutral-200 dark:border-neutral-800">
                                <th class="py-2 pr-4">{{ __('Job #') }}</th>
                                <th class="py-2 pr-4">{{ __('Customer') }}</th>
                                <th class="py-2 pr-4">{{ __('Device/Issue') }}</th>
                                <th class="py-2 pr-4">{{ __('Technician') }}</th>
                                <th class="py-2 pr-4">{{ __('Status') }}</th>
                                <th class="py-2 pr-0 text-right">{{ __('Quote') }}</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-neutral-200 dark:divide-neutral-800">
                            @forelse(($stats['recent_jobs'] ?? []) as $job)
                                @php($status = strtolower($job['status'] ?? 'pending'))

                                <tr class="hover:bg-neutral-50 dark:hover:bg-neutral-800/40">
                                    <td class="py-3 pr-4 font-medium text-neutral-900 dark:text-neutral-50">
                                        {{ $job['id'] }}
                                    </td>
                                    <td class="py-3 pr-4 text-neutral-700 dark:text-neutral-100">
                                        {{ $job['customer'] ?? '—' }}
                                    </td>
                                    <td class="py-3 pr-4 text-neutral-700 dark:text-neutral-100">
                                        {{ $job['device'] ?? '—' }}
                                    </td>
                                    <td class="py-3 pr-4 text-neutral-700 dark:text-neutral-100">
                                        {{ $job['technician'] ?? '—' }}
                                    </td>
                                    <td class="py-3 pr-4">
                                        <span
                                            @class([
                                                'inline-flex items-center rounded-full px-2 py-0.5 text-xs font-medium',
                                                'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/40 dark:text-yellow-300' => $status === 'pending',
                                                'bg-blue-100 text-blue-700 dark:bg-blue-900/40 dark:text-blue-300' => $status === 'in_progress',
                                                'bg-green-100 text-green-700 dark:bg-green-900/40 dark:text-green-300' => $status === 'completed',
                                                'bg-neutral-100 text-neutral-700 dark:bg-neutral-800 dark:text-neutral-300' => !in_array($status, ['pending','in_progress','completed']),
                                            ])>
                                            {{ ucfirst(str_replace('_', ' ', $status)) }}
                                        </span>
                                    </td>
                                    <td class="py-3 pr-0 text-right font-semibold text-neutral-900 dark:text-neutral-50">
                                        ₱{{ number_format($job['quote'] ?? 0, 2) }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="py-8 text-center text-sm text-neutral-500 dark:text-neutral-400">
                                        {{ __('No recent jobs yet.') }}
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</x-layouts.app>
