<x-layouts.app :title="__('Reports')">
    <div class="flex h-full w-full flex-1 flex-col gap-6 rounded-xl">

        {{-- Header + actions --}}
        <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
            <div>
                <h1 class="text-xl font-semibold tracking-tight text-neutral-900 dark:text-neutral-50">
                    {{ __('Reports') }}
                </h1>
                <p class="text-sm text-neutral-500 dark:text-neutral-400">
                    Track job orders, diagnostic fees, and revenue performance with live data.
                </p>
            </div>

            <div x-data="{ exportOpen:false, generateOpen:false }" class="flex flex-wrap items-center gap-2">
                {{-- Export --}}
                <button
                    @click="exportOpen = true"
                    type="button"
                    class="inline-flex items-center rounded-lg border border-neutral-200 bg-white px-3 py-2 text-xs font-medium text-neutral-700 shadow-sm hover:bg-neutral-50 dark:border-neutral-700 dark:bg-neutral-900 dark:text-neutral-100 dark:hover:bg-neutral-800"
                >
                    <x-flux::icon name="arrow-down-tray" class="mr-2 h-4 w-4" />
                    Export
                </button>

                {{-- Generate --}}
                <button
                    @click="generateOpen = true"
                    type="button"
                    class="inline-flex items-center rounded-lg bg-emerald-600 px-4 py-2 text-xs font-semibold text-white shadow-sm hover:bg-emerald-500"
                >
                    <x-flux::icon name="document-text" class="mr-2 h-4 w-4" />
                    Generate Report
                </button>

                {{-- Modals (keeping existing) --}}
                <div x-show="exportOpen" x-cloak class="fixed inset-0 z-50 flex items-center justify-center">
                    <div class="absolute inset-0 bg-black/50" @click="exportOpen=false"></div>
                    <div class="relative w-full max-w-md rounded-xl bg-white p-6 shadow-xl dark:bg-neutral-900">
                        <h3 class="text-sm font-semibold text-neutral-900 dark:text-neutral-50">Export Reports</h3>
                        <p class="mt-1 text-xs text-neutral-500 dark:text-neutral-400">Choose a format to export your report data.</p>
                        <div class="mt-4 space-y-2 text-xs">
                            <button class="w-full rounded-lg border px-4 py-2 hover:bg-neutral-50 dark:border-neutral-700 dark:hover:bg-neutral-800">Export as PDF</button>
                            <button class="w-full rounded-lg border px-4 py-2 hover:bg-neutral-50 dark:border-neutral-700 dark:hover:bg-neutral-800">Export as Excel</button>
                            <button class="w-full rounded-lg border px-4 py-2 hover:bg-neutral-50 dark:border-neutral-700 dark:hover:bg-neutral-800">Export as CSV</button>
                        </div>
                        <div class="mt-5 flex justify-end">
                            <button @click="exportOpen=false" class="rounded-lg px-4 py-2 text-xs text-neutral-600 hover:bg-neutral-100 dark:text-neutral-300 dark:hover:bg-neutral-800">Close</button>
                        </div>
                    </div>
                </div>

                <div x-show="generateOpen" x-cloak class="fixed inset-0 z-50 flex items-center justify-center">
                    <div class="absolute inset-0 bg-black/50" @click="generateOpen=false"></div>
                    <div class="relative w-full max-w-md rounded-xl bg-white p-6 shadow-xl dark:bg-neutral-900">
                        <h3 class="text-sm font-semibold text-neutral-900 dark:text-neutral-50">Generate Report</h3>
                        <p class="mt-1 text-xs text-neutral-500 dark:text-neutral-400">Select what data you want to include.</p>
                        <div class="mt-4 space-y-3 text-xs">
                            <label class="flex items-center gap-2"><input type="checkbox" class="rounded border-neutral-300" checked> Job order revenue</label>
                            <label class="flex items-center gap-2"><input type="checkbox" class="rounded border-neutral-300" checked> Diagnostic fees</label>
                            <label class="flex items-center gap-2"><input type="checkbox" class="rounded border-neutral-300"> Quotations pending conversion</label>
                        </div>
                        <div class="mt-5 flex justify-end gap-2">
                            <button @click="generateOpen=false" class="rounded-lg border px-4 py-2 text-xs hover:bg-neutral-50 dark:border-neutral-700 dark:hover:bg-neutral-800">Cancel</button>
                            <button class="rounded-lg bg-emerald-600 px-4 py-2 text-xs font-semibold text-white hover:bg-emerald-500">Generate</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Stat cards --}}
        <div class="grid gap-4 md:grid-cols-4">
            <div class="rounded-xl border border-neutral-200 bg-white p-4 dark:border-neutral-700 dark:bg-neutral-900">
                <p class="text-xs font-medium text-neutral-500 dark:text-neutral-400">
                    {{ __('Completed Job Revenue') }}
                </p>
                <p class="mt-2 text-2xl font-semibold tracking-tight text-neutral-900 dark:text-neutral-50">
                    ₱{{ number_format($stats['reports']['completed_jobs_revenue'] ?? 0, 2) }}
                </p>
                <p class="mt-1 text-xs text-neutral-500 dark:text-neutral-400">
                    {{ __('Total revenue from completed jobs.') }}
                </p>
            </div>

            <div class="rounded-xl border border-neutral-200 bg-white p-4 dark:border-neutral-700 dark:bg-neutral-900">
                <p class="text-xs font-medium text-neutral-500 dark:text-neutral-400">
                    {{ __('Downpayments Collected') }}
                </p>
                <p class="mt-2 text-2xl font-semibold tracking-tight text-emerald-600">
                    ₱{{ number_format($stats['reports']['downpayments_received'] ?? 0, 2) }}
                </p>
                <p class="mt-1 text-xs text-neutral-500 dark:text-neutral-400">
                    {{ __('50% collected from completed jobs.') }}
                </p>
            </div>

            <div class="rounded-xl border border-neutral-200 bg-white p-4 dark:border-neutral-700 dark:bg-neutral-900">
                <p class="text-xs font-medium text-neutral-500 dark:text-neutral-400">
                    {{ __('Diagnostic Fees Collected') }}
                </p>
                <p class="mt-2 text-2xl font-semibold tracking-tight text-amber-600">
                    ₱{{ number_format($stats['reports']['diagnostic_fees'] ?? 0, 2) }}
                </p>
                <p class="mt-1 text-xs text-neutral-500 dark:text-neutral-400">
                    {{ __('Upfront fees from all quotations.') }}
                </p>
            </div>

            <div class="rounded-xl border border-neutral-200 bg-white p-4 dark:border-neutral-700 dark:bg-neutral-900">
                <p class="text-xs font-medium text-neutral-500 dark:text-neutral-400">
                    {{ __('Total Revenue') }}
                </p>
                <p class="mt-2 text-2xl font-semibold tracking-tight text-blue-600">
                    ₱{{ number_format($stats['reports']['total_revenue'] ?? 0, 2) }}
                </p>
                <p class="mt-1 text-xs text-neutral-500 dark:text-neutral-400">
                    {{ __('Jobs + diagnostic fees collected.') }}
                </p>
            </div>
        </div>

        {{-- Filters (keeping existing) --}}
        <div class="flex flex-col gap-3 rounded-xl border border-neutral-200 bg-white p-4 dark:border-neutral-700 dark:bg-neutral-900 md:flex-row md:items-center md:justify-between">
            <div class="flex flex-wrap items-center gap-2 text-xs">
                <span class="text-neutral-500 dark:text-neutral-400">{{ __('Period:') }}</span>
                <button class="rounded-full bg-neutral-900 px-3 py-1 text-xs font-medium text-white dark:bg-neutral-100 dark:text-neutral-900">{{ __('This week') }}</button>
                <button class="rounded-full bg-neutral-100 px-3 py-1 text-xs font-medium text-neutral-700 hover:bg-neutral-200 dark:bg-neutral-800 dark:text-neutral-100 dark:hover:bg-neutral-700">{{ __('This month') }}</button>
                <button class="rounded-full bg-neutral-100 px-3 py-1 text-xs font-medium text-neutral-700 hover:bg-neutral-200 dark:bg-neutral-800 dark:text-neutral-100 dark:hover:bg-neutral-700">{{ __('Last month') }}</button>
                <button class="rounded-full bg-neutral-100 px-3 py-1 text-xs font-medium text-neutral-700 hover:bg-neutral-200 dark:bg-neutral-800 dark:text-neutral-100 dark:hover:bg-neutral-700">{{ __('This year') }}</button>
            </div>

            <div class="flex w-full flex-col gap-2 md:w-auto md:flex-row md:items-center">
                <div class="flex items-center gap-2 text-xs">
                    <span class="text-neutral-500 dark:text-neutral-400">{{ __('Custom range:') }}</span>
                    <input type="date" class="rounded-lg border border-neutral-200 bg-neutral-50 px-2 py-2 text-xs text-neutral-800 focus:border-emerald-500 focus:outline-none focus:ring-1 focus:ring-emerald-500 dark:border-neutral-700 dark:bg-neutral-900 dark:text-neutral-100">
                    <span class="text-neutral-400">–</span>
                    <input type="date" class="rounded-lg border border-neutral-200 bg-neutral-50 px-2 py-2 text-xs text-neutral-800 focus:border-emerald-500 focus:outline-none focus:ring-1 focus:ring-emerald-500 dark:border-neutral-700 dark:bg-neutral-900 dark:text-neutral-100">
                </div>
            </div>
        </div>

        {{-- Content layout --}}
        <div class="grid gap-6 md:grid-cols-3">
            {{-- Left sidebar --}}
            <div class="space-y-4 md:col-span-1">
                <div class="rounded-xl border border-neutral-200 bg-white p-4 dark:border-neutral-700 dark:bg-neutral-900">
                    <div class="flex items-start justify-between gap-3">
                        <p class="text-xs font-medium text-neutral-500 dark:text-neutral-400">
                            {{ __('Revenue Breakdown') }}
                        </p>
                        <span class="text-[11px] text-neutral-400">{{ __('Actual collections') }}</span>
                    </div>

                    <div class="mt-3 space-y-2 text-[11px] text-neutral-600 dark:text-neutral-300">
                        <div class="flex items-center justify-between">
                            <span>{{ __('Completed job orders') }}</span>
                            <span class="font-medium">₱{{ number_format($stats['reports']['completed_jobs_revenue'] ?? 0, 2) }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span>{{ __('Downpayments (50%)') }}</span>
                            <span class="font-medium">₱{{ number_format($stats['reports']['downpayments_received'] ?? 0, 2) }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span>{{ __('Remaining balance (50%)') }}</span>
                            <span class="font-medium">₱{{ number_format($stats['reports']['remaining_balance'] ?? 0, 2) }}</span>
                        </div>
                        <div class="flex items-center justify-between border-t pt-2 dark:border-neutral-700">
                            <span>{{ __('Diagnostic fees') }}</span>
                            <span class="font-medium">₱{{ number_format($stats['reports']['diagnostic_fees'] ?? 0, 2) }}</span>
                        </div>
                        <div class="flex items-center justify-between border-t pt-2 font-semibold dark:border-neutral-700">
                            <span>{{ __('Total revenue') }}</span>
                            <span class="text-emerald-600">₱{{ number_format($stats['reports']['total_revenue'] ?? 0, 2) }}</span>
                        </div>
                    </div>
                </div>

                <div class="rounded-xl border border-neutral-200 bg-white p-4 dark:border-neutral-700 dark:bg-neutral-900">
                    <div class="flex items-start justify-between gap-3">
                        <p class="text-xs font-medium text-neutral-500 dark:text-neutral-400">
                            {{ __('Job Order Statistics') }}
                        </p>
                    </div>

                    <div class="mt-3 space-y-2 text-[11px] text-neutral-600 dark:text-neutral-300">
                        <div class="flex items-center justify-between">
                            <span>{{ __('Total jobs') }}</span>
                            <span class="font-medium">{{ $stats['counts']['total_jobs'] ?? 0 }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span>{{ __('Active jobs') }}</span>
                            <span class="font-medium text-amber-600">{{ $stats['counts']['active_jobs'] ?? 0 }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span>{{ __('Completed jobs') }}</span>
                            <span class="font-medium text-emerald-600">{{ $stats['counts']['completed_jobs'] ?? 0 }}</span>
                        </div>
                        <div class="flex items-center justify-between border-t pt-2 dark:border-neutral-700">
                            <span>{{ __('Quotation approval rate') }}</span>
                            <span class="font-medium">{{ $stats['reports']['approval_rate'] ?? 0 }}%</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Right table --}}
            @include('manager.partials.quotation-table')
        </div>

    </div>
</x-layouts.app>
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>