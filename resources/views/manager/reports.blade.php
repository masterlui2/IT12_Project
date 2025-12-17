<x-layouts.app :title="__('Reports')">
    <div class="flex h-full w-full flex-1 flex-col gap-6 rounded-xl">

        {{-- Header + actions --}}
        <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
            <div>
                <h1 class="text-xl font-semibold tracking-tight text-neutral-900 dark:text-neutral-50">
                    {{ __('Reports') }}
                </h1>
                <p class="text-sm text-neutral-500 dark:text-neutral-400">
                    Track quotations, diagnostic fees, and approval performance with live data.
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

    {{-- EXPORT MODAL --}}
    <div x-show="exportOpen" x-cloak class="fixed inset-0 z-50 flex items-center justify-center">
        <div class="absolute inset-0 bg-black/50" @click="exportOpen=false"></div>

        <div class="relative w-full max-w-md rounded-xl bg-white p-6 shadow-xl dark:bg-neutral-900">
            <h3 class="text-sm font-semibold text-neutral-900 dark:text-neutral-50">
                Export Reports
            </h3>
            <p class="mt-1 text-xs text-neutral-500 dark:text-neutral-400">
                Choose a format to export your report data.
            </p>

            <div class="mt-4 space-y-2 text-xs">
                <button class="w-full rounded-lg border px-4 py-2 hover:bg-neutral-50 dark:border-neutral-700 dark:hover:bg-neutral-800">
                    Export as PDF
                </button>
                <button class="w-full rounded-lg border px-4 py-2 hover:bg-neutral-50 dark:border-neutral-700 dark:hover:bg-neutral-800">
                    Export as Excel
                </button>
                <button class="w-full rounded-lg border px-4 py-2 hover:bg-neutral-50 dark:border-neutral-700 dark:hover:bg-neutral-800">
                    Export as CSV
                </button>
            </div>

            <div class="mt-5 flex justify-end">
                <button
                    @click="exportOpen=false"
                    class="rounded-lg px-4 py-2 text-xs text-neutral-600 hover:bg-neutral-100 dark:text-neutral-300 dark:hover:bg-neutral-800"
                >
                    Close
                </button>
            </div>
        </div>
    </div>

    {{-- GENERATE MODAL --}}
    <div x-show="generateOpen" x-cloak class="fixed inset-0 z-50 flex items-center justify-center">
        <div class="absolute inset-0 bg-black/50" @click="generateOpen=false"></div>

        <div class="relative w-full max-w-md rounded-xl bg-white p-6 shadow-xl dark:bg-neutral-900">
            <h3 class="text-sm font-semibold text-neutral-900 dark:text-neutral-50">
                Generate Report
            </h3>
            <p class="mt-1 text-xs text-neutral-500 dark:text-neutral-400">
                Select what data you want to include.
            </p>

            <div class="mt-4 space-y-3 text-xs">
                <label class="flex items-center gap-2">
                    <input type="checkbox" class="rounded border-neutral-300">
                    Quotations & approvals
                </label>
                <label class="flex items-center gap-2">
                    <input type="checkbox" class="rounded border-neutral-300">
                    Diagnostic fees
                </label>
                <label class="flex items-center gap-2">
                    <input type="checkbox" class="rounded border-neutral-300">
                    Job order totals
                </label>
            </div>

            <div class="mt-5 flex justify-end gap-2">
                <button
                    @click="generateOpen=false"
                    class="rounded-lg border px-4 py-2 text-xs hover:bg-neutral-50 dark:border-neutral-700 dark:hover:bg-neutral-800"
                >
                    Cancel
                </button>
                <button
                    class="rounded-lg bg-emerald-600 px-4 py-2 text-xs font-semibold text-white hover:bg-emerald-500"
                >
                    Generate
                </button>
            </div>
        </div>
    </div>

</div>

        </div>

        {{-- Stat cards --}}
        <div class="grid gap-4 md:grid-cols-4">
            <div class="rounded-xl border border-neutral-200 bg-white p-4 dark:border-neutral-700 dark:bg-neutral-900">
                <p class="text-xs font-medium text-neutral-500 dark:text-neutral-400">
                    {{ __('Approved Sales (This Month)') }}
                </p>
                <p class="mt-2 text-2xl font-semibold tracking-tight text-neutral-900 dark:text-neutral-50">
                    ₱{{ number_format($stats['reports']['quotation_sales_month'] ?? 0, 2) }}
                </p>
                <p class="mt-1 text-xs text-neutral-500 dark:text-neutral-400">
                    {{ __('Sum of approved quotations for this month.') }}
                </p>
            </div>

            <div class="rounded-xl border border-neutral-200 bg-white p-4 dark:border-neutral-700 dark:bg-neutral-900">
                <p class="text-xs font-medium text-neutral-500 dark:text-neutral-400">
                    {{ __('Expected 50% Downpayments') }}
                </p>
                <p class="mt-2 text-2xl font-semibold tracking-tight text-emerald-600">
                    ₱{{ number_format($stats['reports']['expected_downpayments'] ?? ($stats['reports']['average_quotation'] ?? 0), 2) }}
                </p>
                <p class="mt-1 text-xs text-neutral-500 dark:text-neutral-400">
                    {{ __('Estimated from approved quotations.') }}
                </p>
            </div>

            <div class="rounded-xl border border-neutral-200 bg-white p-4 dark:border-neutral-700 dark:bg-neutral-900">
                <p class="text-xs font-medium text-neutral-500 dark:text-neutral-400">
                    {{ __('Diagnostic Fees Recorded') }}
                </p>
                <p class="mt-2 text-2xl font-semibold tracking-tight text-amber-600">
                    ₱{{ number_format($stats['reports']['diagnostic_fees'] ?? 0, 2) }}
                </p>
                <p class="mt-1 text-xs text-neutral-500 dark:text-neutral-400">
                    {{ __('Collected from all quotations.') }}
                </p>
            </div>

            <div class="rounded-xl border border-neutral-200 bg-white p-4 dark:border-neutral-700 dark:bg-neutral-900">
                <p class="text-xs font-medium text-neutral-500 dark:text-neutral-400">
                    {{ __('Approval Rate') }}
                </p>
                <p class="mt-2 text-2xl font-semibold tracking-tight text-blue-600">
                    {{ $stats['reports']['approval_rate'] ?? 0 }}%
                </p>
                <p class="mt-1 text-xs text-neutral-500 dark:text-neutral-400">
                    {{ __('Approved vs total quotations.') }}
                </p>
            </div>
        </div>

        {{-- Filters --}}
        <div class="flex flex-col gap-3 rounded-xl border border-neutral-200 bg-white p-4 dark:border-neutral-700 dark:bg-neutral-900 md:flex-row md:items-center md:justify-between">
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

        {{-- Content layout --}}
        <div class="grid gap-6 md:grid-cols-3">
            {{-- Left --}}
            <div class="space-y-4 md:col-span-1">
                <div class="rounded-xl border border-neutral-200 bg-white p-4 dark:border-neutral-700 dark:bg-neutral-900">
                    <div class="flex items-start justify-between gap-3">
                        <p class="text-xs font-medium text-neutral-500 dark:text-neutral-400">
                            {{ __('Quotations → Downpayment → Completed Jobs') }}
                        </p>
                        <span class="text-[11px] text-neutral-400">{{ __('Payment funnel') }}</span>
                    </div>
                    <div class="mt-4 h-32 rounded-lg bg-neutral-50 dark:bg-neutral-900/60">
                        <div class="flex h-full items-center justify-center text-[11px] text-neutral-400 dark:text-neutral-500">
                            {{ __('Chart placeholder') }}
                        </div>
                    </div>
                </div>

                <div class="rounded-xl border border-neutral-200 bg-white p-4 dark:border-neutral-700 dark:bg-neutral-900">
                    <div class="flex items-start justify-between gap-3">
                        <p class="text-xs font-medium text-neutral-500 dark:text-neutral-400">
                            {{ __('Top Revenue Sources') }}
                        </p>
                        <span class="text-[11px] text-neutral-400">{{ __('Quotations / diagnostics') }}</span>
                    </div>

                    <div class="mt-3 space-y-2 text-[11px] text-neutral-600 dark:text-neutral-300">
                        <div class="flex items-center justify-between">
                            <span>{{ __('Approved quotations') }}</span>
                            <span class="font-medium">₱{{ number_format($stats['reports']['quotation_sales_month'] ?? 0, 2) }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span>{{ __('Expected downpayments') }}</span>
                            <span class="font-medium">₱{{ number_format($stats['reports']['expected_downpayments'] ?? ($stats['reports']['average_quotation'] ?? 0), 2) }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span>{{ __('Diagnostic fees') }}</span>
                            <span class="font-medium">₱{{ number_format($stats['reports']['diagnostic_fees'] ?? 0, 2) }}</span>
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
