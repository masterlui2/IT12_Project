<x-layouts.app :title="__('Reports')">
    <div class="flex h-full w-full flex-1 flex-col gap-6 rounded-xl">

        {{-- Header + primary actions --}}
        <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
            <div>
                <h1 class="text-xl font-semibold tracking-tight text-neutral-900 dark:text-neutral-50">
                    {{ __('Reports') }}
                </h1>
                <p class="text-sm text-neutral-500 dark:text-neutral-400">
                    Track quotations, downpayments, diagnostic fees, and overall sales performance.
                </p>
            </div>

            <div class="flex flex-wrap items-center gap-2">
                <button
                    type="button"
                    class="inline-flex items-center rounded-lg border border-neutral-200 bg-white px-3 py-2 text-xs font-medium text-neutral-700 shadow-sm hover:bg-neutral-50 dark:border-neutral-700 dark:bg-neutral-900 dark:text-neutral-100 dark:hover:bg-neutral-800"
                >
                    <x-flux::icon name="arrow-down-tray" class="mr-2 h-4 w-4" />
                    {{ __('Export') }}
                </button>

                <button
                    type="button"
                    class="inline-flex items-center rounded-lg bg-emerald-600 px-4 py-2 text-xs font-semibold text-white shadow-sm hover:bg-emerald-500 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-emerald-500 focus-visible:ring-offset-2 focus-visible:ring-offset-neutral-900"
                >
                    <x-flux::icon name="document-text" class="mr-2 h-4 w-4" />
                    {{ __('Generate Report') }}
                </button>
            </div>
        </div>

        {{-- Sales / payment stat cards --}}
        <div class="grid gap-4 md:grid-cols-4">
            {{-- Total quotation sales (approved quotations total) --}}
            <div class="rounded-xl border border-neutral-200 bg-white p-4 dark:border-neutral-700 dark:bg-neutral-900">
                <p class="text-xs font-medium text-neutral-500 dark:text-neutral-400">
                    {{ __('Total Quotation Sales (This Month)') }}
                </p>
                <p class="mt-2 text-2xl font-semibold tracking-tight text-neutral-900 dark:text-neutral-50">
                    {{ $stats['reports']['quotation_sales_month'] ?? '₱ 0.00' }}
                </p>
                <p class="mt-1 text-xs text-neutral-500 dark:text-neutral-400">
                    {{ __('Sum of approved quotations for this month.') }}
                </p>
            </div>

            {{-- Expected 50% downpayments --}}
            <div class="rounded-xl border border-neutral-200 bg-white p-4 dark:border-neutral-700 dark:bg-neutral-900">
                <p class="text-xs font-medium text-neutral-500 dark:text-neutral-400">
                    {{ __('Expected 50% Downpayments') }}
                </p>
                <p class="mt-2 text-2xl font-semibold tracking-tight text-emerald-500">
                    {{ $stats['reports']['expected_downpayments'] ?? '₱ 0.00' }}
                </p>
                <p class="mt-1 text-xs text-neutral-500 dark:text-neutral-400">
                    {{ __('50% of all approved quotation totals.') }}
                </p>
            </div>

            {{-- Downpayments actually collected --}}
            <div class="rounded-xl border border-neutral-200 bg-white p-4 dark:border-neutral-700 dark:bg-neutral-900">
                <p class="text-xs font-medium text-neutral-500 dark:text-neutral-400">
                    {{ __('Downpayments Collected') }}
                </p>
                <p class="mt-2 text-2xl font-semibold tracking-tight text-neutral-900 dark:text-neutral-50">
                    {{ $stats['reports']['downpayments_collected'] ?? '₱ 0.00' }}
                </p>
                <p class="mt-1 text-xs text-neutral-500 dark:text-neutral-400">
                    {{ __('Actual 50% payments received from customers.') }}
                </p>
            </div>

            {{-- Diagnostic fees (when no 50% downpayment is made) --}}
            <div class="rounded-xl border border-neutral-200 bg-white p-4 dark:border-neutral-700 dark:bg-neutral-900">
                <p class="text-xs font-medium text-neutral-500 dark:text-neutral-400">
                    {{ __('Diagnostic Fees Collected') }}
                </p>
                <p class="mt-2 text-2xl font-semibold tracking-tight text-amber-500">
                    {{ $stats['reports']['diagnostic_fees'] ?? '₱ 1,500.00' }}
                </p>
                <p class="mt-1 text-xs text-neutral-500 dark:text-neutral-400">
                    {{ __('For jobs where 50% downpayment was not made.') }}
                </p>
            </div>
        </div>

        {{-- Filters + date range --}}
        <div
            class="flex flex-col gap-3 rounded-xl border border-neutral-200 bg-white p-4 dark:border-neutral-700 dark:bg-neutral-900 md:flex-row md:items-center md:justify-between"
        >
            <div class="flex flex-wrap items-center gap-2 text-xs">
                <span class="text-neutral-500 dark:text-neutral-400">{{ __('Period:') }}</span>

                <button class="rounded-full bg-neutral-900 px-3 py-1 text-xs font-medium text-white dark:bg-neutral-100 dark:text-neutral-900">
                    {{ __('This week') }}
                </button>
                <button class="rounded-full bg-neutral-100 px-3 py-1 text-xs font-medium text-neutral-700 hover:bg-neutral-200 dark:bg-neutral-800 dark:text-neutral-100 dark:hover:bg-neutral-700">
                    {{ __('This month') }}
                </button>
                <button class="rounded-full bg-neutral-100 px-3 py-1 text-xs font-medium text-neutral-700 hover:bg-neutral-200 dark:bg-neutral-800 dark:text-neutral-100 dark:hover:bg-neutral-700">
                    {{ __('Last month') }}
                </button>
                <button class="rounded-full bg-neutral-100 px-3 py-1 text-xs font-medium text-neutral-700 hover:bg-neutral-200 dark:bg-neutral-800 dark:text-neutral-100 dark:hover:bg-neutral-700">
                    {{ __('This year') }}
                </button>
            </div>

            <div class="flex w-full flex-col gap-2 md:w-auto md:flex-row md:items-center">
                <div class="flex items-center gap-2 text-xs">
                    <span class="text-neutral-500 dark:text-neutral-400">{{ __('Custom range:') }}</span>
                    <input
                        type="date"
                        class="rounded-lg border border-neutral-200 bg-neutral-50 px-2 py-2 text-xs text-neutral-800 focus:border-emerald-500 focus:outline-none focus:ring-1 focus:ring-emerald-500 dark:border-neutral-700 dark:bg-neutral-900 dark:text-neutral-100"
                    >
                    <span class="text-neutral-400">–</span>
                    <input
                        type="date"
                        class="rounded-lg border border-neutral-200 bg-neutral-50 px-2 py-2 text-xs text-neutral-800 focus:border-emerald-500 focus:outline-none focus:ring-1 focus:ring-emerald-500 dark:border-neutral-700 dark:bg-neutral-900 dark:text-neutral-100"
                    >
                </div>

                <div class="flex items-center gap-2 text-xs">
                    <span class="text-neutral-500 dark:text-neutral-400">{{ __('View:') }}</span>
                    <select
                        class="rounded-lg border border-neutral-200 bg-neutral-50 px-2 py-2 text-xs text-neutral-800 focus:border-emerald-500 focus:outline-none focus:ring-1 focus:ring-emerald-500 dark:border-neutral-700 dark:bg-neutral-900 dark:text-neutral-100"
                    >
                        <option>{{ __('Summary (default)') }}</option>
                        <option>{{ __('Sales & Downpayments') }}</option>
                        <option>{{ __('Diagnostic Fee Report') }}</option>
                        <option>{{ __('Inquiries vs. Quotations') }}</option>
                        <option>{{ __('Technician performance') }}</option>
                    </select>
                </div>
            </div>
        </div>

        {{-- Layout: left mini charts (placeholder), right detailed table --}}
        <div class="grid gap-6 md:grid-cols-3">
            {{-- Left: visual placeholders (you can later replace with charts) --}}
            <div class="space-y-4 md:col-span-1">
                <div class="relative overflow-hidden rounded-xl border border-neutral-200 bg-white p-4 dark:border-neutral-700 dark:bg-neutral-900">
                    <div class="flex items-center justify-between">
                        <p class="text-xs font-medium text-neutral-500 dark:text-neutral-400">
                            {{ __('Quotations → Downpayment → Completed Jobs') }}
                        </p>
                        <span class="text-[11px] text-neutral-400">
                            {{ __('Payment funnel') }}
                        </span>
                    </div>
                    <div class="mt-4 h-32 rounded-lg bg-neutral-50 dark:bg-neutral-900/60">
                        <div class="flex h-full items-center justify-center text-[11px] text-neutral-400 dark:text-neutral-500">
                            {{ __('Chart placeholder') }}
                        </div>
                    </div>
                </div>

                <div class="relative overflow-hidden rounded-xl border border-neutral-200 bg-white p-4 dark:border-neutral-700 dark:bg-neutral-900">
                    <div class="flex items-center justify-between">
                        <p class="text-xs font-medium text-neutral-500 dark:text-neutral-400">
                            {{ __('Top Revenue Sources') }}
                        </p>
                        <span class="text-[11px] text-neutral-400">
                            {{ __('By quotations / diagnostics') }}
                        </span>
                    </div>

                    <div class="mt-3 space-y-2 text-[11px] text-neutral-600 dark:text-neutral-300">
                        <div class="flex items-center justify-between">
                            <span>{{ __('Approved quotations') }}</span>
                            <span class="font-medium">{{ $stats['reports']['quotation_sales_month'] ?? '₱ 0.00' }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span>{{ __('Downpayments collected') }}</span>
                            <span class="font-medium">{{ $stats['reports']['downpayments_collected'] ?? '₱ 0.00' }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span>{{ __('Diagnostic fees') }}</span>
                            <span class="font-medium">{{ $stats['reports']['diagnostic_fees'] ?? '₱ 0.00' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Right: detailed payment table --}}
            <div class="relative flex-1 overflow-hidden rounded-xl border border-neutral-200 bg-white dark:border-neutral-700 dark:bg-neutral-900 md:col-span-2">
                <div class="overflow-x-auto">
                    <table class="min-w-full border-separate border-spacing-0 text-left text-xs">
                        <thead>
                            <tr class="border-b border-neutral-100 bg-neutral-50 text-neutral-500 dark:border-neutral-800 dark:bg-neutral-900/60 dark:text-neutral-400">
                                <th class="px-4 py-3 font-medium">{{ __('Date') }}</th>
                                <th class="px-4 py-3 font-medium">{{ __('Quotation #') }}</th>
                                <th class="px-4 py-3 font-medium">{{ __('Customer') }}</th>
                                <th class="px-4 py-3 font-medium">{{ __('Quotation Total') }}</th>
                                <th class="px-4 py-3 font-medium">{{ __('Expected 50%') }}</th>
                                <th class="px-4 py-3 font-medium">{{ __('Downpayment Paid') }}</th>
                                <th class="px-4 py-3 font-medium">{{ __('Diagnostic Fee') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- Example static rows – replace with @foreach($reportRows as $row) --}}
                            <tr class="border-b border-neutral-100 text-neutral-700 dark:border-neutral-800 dark:text-neutral-100">
                                <td class="px-4 py-3 align-middle">Nov 15, 2025</td>
                                <td class="px-4 py-3 align-middle">Q-2025-0001</td>
                                <td class="px-4 py-3 align-middle">Juan Dela Cruz</td>
                                <td class="px-4 py-3 align-middle">₱ 10,000.00</td>
                                <td class="px-4 py-3 align-middle">₱ 5,000.00</td>
                                <td class="px-4 py-3 align-middle">₱ 5,000.00</td>
                                <td class="px-4 py-3 align-middle">₱ 1,500.00</td>
                            </tr>
                            <tr class="border-b border-neutral-100 text-neutral-700 dark:border-neutral-800 dark:text-neutral-100">
                                <td class="px-4 py-3 align-middle">Nov 14, 2025</td>
                                <td class="px-4 py-3 align-middle">Q-2025-0002</td>
                                <td class="px-4 py-3 align-middle">Maria Santos</td>
                                <td class="px-4 py-3 align-middle">₱ 3,000.00</td>
                                <td class="px-4 py-3 align-middle">₱ 1,500.00</td>
                                <td class="px-4 py-3 align-middle">₱ 0.00</td>
                                <td class="px-4 py-3 align-middle">₱ 1,500.00</td>
                            </tr>

                            {{-- Empty state --}}
                            {{-- 
                            @forelse ($reportRows as $row)
                                ...
                            @empty
                            --}}
                            <tr>
                                <td colspan="7" class="px-4 py-10 text-center text-xs text-neutral-500 dark:text-neutral-400">
                                    {{ __('No payment data yet. Adjust the date range or generate a new report to see details here.') }}
                                </td>
                            </tr>
                            {{-- @endforelse --}}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</x-layouts.app>
