<x-layouts.app :title="__('Sales')">
    <div class="flex h-full w-full flex-1 flex-col gap-6 rounded-xl">

        {{-- Header + primary actions --}} 
        <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
            <div>
                <h1 class="text-xl font-semibold tracking-tight text-neutral-900 dark:text-neutral-50">
                    {{ __('Sales') }}
                </h1>
                <p class="text-sm text-neutral-500 dark:text-neutral-400">
                    {{ __('Monitor quotation wins, collections, and payment health for your service business.') }}
                </p>
            </div>

            <div class="flex flex-wrap items-center gap-2">
                <button
                    type="button"
                    class="inline-flex items-center rounded-lg border border-neutral-200 bg-white px-3 py-2 text-xs font-medium text-neutral-700 shadow-sm hover:bg-neutral-50 dark:border-neutral-700 dark:bg-neutral-900 dark:text-neutral-100 dark:hover:bg-neutral-800"
                >
                    <x-flux::icon name="funnel" class="mr-2 h-4 w-4" />
                    {{ __('Filter') }}
                </button>

                <button
                    type="button"
                    class="inline-flex items-center rounded-lg bg-emerald-600 px-4 py-2 text-xs font-semibold text-white shadow-sm hover:bg-emerald-500 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-emerald-500 focus-visible:ring-offset-2 focus-visible:ring-offset-neutral-900"
                >
                    <x-flux::icon name="plus" class="mr-2 h-4 w-4" />
                    {{ __('New Sale') }}
                </button>
            </div>
        </div>

        {{-- Monthly overview cards --}}
        <div class="grid gap-4 md:grid-cols-3">
            <div class="rounded-xl border border-neutral-200 bg-white p-4 dark:border-neutral-700 dark:bg-neutral-900">
                <p class="text-xs font-medium text-neutral-500 dark:text-neutral-400">{{ __('Revenue (This Month)') }}</p>
                <p class="mt-2 text-2xl font-semibold tracking-tight text-neutral-900 dark:text-neutral-50">
                    {{ $stats['monthly']['total_revenue'] ?? '₱ 0.00' }}
                </p>
                <p class="mt-1 text-xs text-neutral-500 dark:text-neutral-400">
                    {{ __('Total collected from approved quotations and payments.') }}
                </p>
            </div>

            <div class="rounded-xl border border-neutral-200 bg-white p-4 dark:border-neutral-700 dark:bg-neutral-900">
                <p class="text-xs font-medium text-neutral-500 dark:text-neutral-400">{{ __('Average Ticket Size') }}</p>
                <p class="mt-2 text-2xl font-semibold tracking-tight text-neutral-900 dark:text-neutral-50">
                    {{ $stats['monthly']['avg_ticket'] ?? '₱ 0.00' }}
                </p>
                <p class="mt-1 text-xs text-neutral-500 dark:text-neutral-400">
                    {{ __('Average revenue per closed deal this month.') }}
                </p>
            </div>

            <div class="rounded-xl border border-neutral-200 bg-white p-4 dark:border-neutral-700 dark:bg-neutral-900">
                <p class="text-xs font-medium text-neutral-500 dark:text-neutral-400">{{ __('Win Rate') }}</p>
                <p class="mt-2 text-2xl font-semibold tracking-tight text-emerald-500">
                    {{ $stats['monthly']['conversion_rate'] ?? '0%' }}
                </p>
                <p class="mt-1 text-xs text-neutral-500 dark:text-neutral-400">
                    {{ __('Approved quotations versus total sent this month.') }}
                </p>
            </div>
        </div>

        {{-- Pipeline summary --}}
        <div class="grid gap-4 md:grid-cols-2">
            <div class="rounded-xl border border-neutral-200 bg-white p-4 dark:border-neutral-700 dark:bg-neutral-900">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-medium text-neutral-500 dark:text-neutral-400">{{ __('Open Quotations') }}</p>
                        <p class="mt-2 text-3xl font-semibold tracking-tight text-neutral-900 dark:text-neutral-50">
                            {{ $stats['pipeline']['open_quotes'] ?? 0 }}
                        </p>
                        <p class="mt-1 text-xs text-neutral-500 dark:text-neutral-400">
                            {{ __('Awaiting approval or payment from customers.') }}
                        </p>
                    </div>
                    <div class="flex h-12 w-12 items-center justify-center rounded-full bg-blue-50 text-blue-600 dark:bg-blue-900/40">
                        <i class="fas fa-file-invoice-dollar"></i>
                    </div>
                </div>
            </div>

            <div class="rounded-xl border border-neutral-200 bg-white p-4 dark:border-neutral-700 dark:bg-neutral-900">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-medium text-neutral-500 dark:text-neutral-400">{{ __('Closed / Won') }}</p>
                        <p class="mt-2 text-3xl font-semibold tracking-tight text-neutral-900 dark:text-neutral-50">
                            {{ $stats['pipeline']['won_quotes'] ?? 0 }}
                        </p>
                        <p class="mt-1 text-xs text-neutral-500 dark:text-neutral-400">
                            {{ __('Completed deals with confirmed payment or downpayment.') }}
                        </p>
                    </div>
                    <div class="flex h-12 w-12 items-center justify-center rounded-full bg-emerald-50 text-emerald-600 dark:bg-emerald-900/40">
                        <i class="fas fa-circle-check"></i>
                    </div>
                </div>
            </div>
        </div>

        {{-- Recent transactions table --}}
        <div class="relative overflow-hidden rounded-xl border border-neutral-200 bg-white dark:border-neutral-700 dark:bg-neutral-900">
            <div class="flex items-center justify-between border-b border-neutral-100 px-4 py-3 dark:border-neutral-800">
                <div>
                    <p class="text-sm font-semibold text-neutral-900 dark:text-neutral-100">{{ __('Recent Transactions') }}</p>
                    <p class="text-xs text-neutral-500 dark:text-neutral-400">{{ __('Track downpayments, balance collections, and refunds.') }}</p>
                </div>
                <button class="rounded-lg border border-neutral-200 bg-white px-3 py-2 text-xs font-medium text-neutral-700 shadow-sm hover:bg-neutral-50 dark:border-neutral-700 dark:bg-neutral-900 dark:text-neutral-100 dark:hover:bg-neutral-800">
                    <x-flux::icon name="arrow-path" class="mr-2 h-4 w-4" />
                    {{ __('Refresh') }}
                </button>
            </div>

            @if(empty($recentTransactions))
                <div class="flex flex-col items-center justify-center gap-2 px-6 py-10 text-center">
                    <div class="flex h-12 w-12 items-center justify-center rounded-full bg-neutral-100 text-neutral-500 dark:bg-neutral-800 dark:text-neutral-300">
                        <i class="fas fa-receipt"></i>
                    </div>
                    <p class="text-sm font-semibold text-neutral-800 dark:text-neutral-200">{{ __('No sales recorded yet') }}</p>
                    <p class="text-xs text-neutral-500 dark:text-neutral-400">{{ __('Sales will appear here once quotations are approved and payments are logged.') }}</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full border-separate border-spacing-0 text-left text-sm">
                        <thead>
                            <tr class="border-b border-neutral-100 bg-neutral-50 text-neutral-700 dark:border-neutral-800 dark:bg-neutral-900/60 dark:text-neutral-400">
                                <th class="px-4 py-3 font-medium">{{ __('Reference') }}</th>
                                <th class="px-4 py-3 font-medium">{{ __('Customer') }}</th>
                                <th class="px-4 py-3 font-medium text-right">{{ __('Amount') }}</th>
                                <th class="px-4 py-3 font-medium">{{ __('Status') }}</th>
                                <th class="px-4 py-3 font-medium">{{ __('Date') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentTransactions as $transaction)
                                <tr class="border-b border-neutral-100 text-neutral-700 dark:border-neutral-800 dark:text-neutral-100">
                                    <td class="px-4 py-3 align-middle font-medium">{{ $transaction['reference'] }}</td>
                                    <td class="px-4 py-3 align-middle">{{ $transaction['customer'] }}</td>
                                    <td class="px-4 py-3 align-middle text-right">{{ $transaction['amount'] }}</td>
                                    <td class="px-4 py-3 align-middle">
                                        <span class="inline-flex items-center gap-2 rounded-full bg-emerald-50 px-2 py-1 text-xs font-medium text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-300">
                                            <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
                                            {{ $transaction['status'] }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 align-middle text-neutral-500 dark:text-neutral-300">{{ $transaction['date'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</x-layouts.app>