<x-layouts.app :title="__('Quotation Review')">

    <div class="flex flex-col gap-6 rounded-xl">

        {{-- Page Header --}}
        <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
            <div>
                <h1 class="text-xl font-semibold tracking-tight text-neutral-900 dark:text-neutral-50">
                    {{ __('Quotation Review') }}
                </h1>
                <p class="text-sm text-neutral-500 dark:text-neutral-400">
                    Review and approve technician quotations
                </p>
            </div>

            <div class="flex flex-wrap items-center gap-2">
                {{-- Search --}}
                <form action="{{ route('quotation') }}" method="GET" class="flex items-center gap-2">
                    <div class="relative text-xs md:w-64">
                        <span class="pointer-events-none absolute inset-y-0 left-2 flex items-center text-neutral-400">
                            <x-flux::icon name="magnifying-glass" class="h-4 w-4" />
                        </span>
                        <input
                            type="text"
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="Search quotations..."
                            class="w-full rounded-lg border border-neutral-200 bg-white py-2 pl-8 pr-3 text-xs text-neutral-800
                                   placeholder:text-neutral-400 focus:border-neutral-300 focus:outline-none focus:ring-1
                                   focus:ring-neutral-300 dark:border-neutral-700 dark:bg-neutral-900 dark:text-neutral-100"
                        >
                    </div>
                    <button
                        type="submit"
                        class="inline-flex items-center rounded-lg border border-neutral-200 bg-white px-3 py-2 text-xs font-medium
                               text-neutral-700 shadow-sm hover:bg-neutral-50 dark:border-neutral-700 dark:bg-neutral-900
                               dark:text-neutral-100 dark:hover:bg-neutral-800">
                        <x-flux::icon name="funnel" class="mr-2 h-4 w-4" />
                        {{ __('Filter') }}
                    </button>
                </form>
            </div>
        </div>

        {{-- Dashboard Stats --}}
        <div class="grid gap-4 md:grid-cols-3">
            <div class="rounded-lg border border-neutral-200 bg-white p-4 dark:border-neutral-700 dark:bg-neutral-900">
                <p class="text-sm font-medium text-neutral-600 dark:text-neutral-400">Pending Review</p>
                <p class="mt-1 text-2xl font-semibold text-neutral-900 dark:text-neutral-100">{{ $pendingCount }}</p>
                <p class="mt-2 text-xs text-neutral-500">Waiting for your approval</p>
            </div>

            <div class="rounded-lg border border-neutral-200 bg-white p-4 dark:border-neutral-700 dark:bg-neutral-900">
                <p class="text-sm font-medium text-neutral-600 dark:text-neutral-400">Approved This Week</p>
                <p class="mt-1 text-2xl font-semibold text-neutral-900 dark:text-neutral-100">{{ $approvedThisWeek }}</p>
                <p class="mt-2 text-xs text-neutral-500">Ready for processing</p>
            </div>

            <div class="rounded-lg border border-neutral-200 bg-white p-4 dark:border-neutral-700 dark:bg-neutral-900">
                <p class="text-sm font-medium text-neutral-600 dark:text-neutral-400">Pending Value</p>
                <p class="mt-1 text-2xl font-semibold text-neutral-900 dark:text-neutral-100">
                    ₱{{ number_format($pendingValue, 2) }}
                </p>
                <p class="mt-2 text-xs text-neutral-500">Total awaiting approval</p>
            </div>
        </div>

        {{-- Quotations Table --}}
        <div class="overflow-hidden rounded-lg border border-neutral-200 bg-white dark:border-neutral-700 dark:bg-neutral-900">
            <div class="overflow-x-auto">
                <table class="min-w-full border-separate border-spacing-0 text-left text-sm">
                    <thead>
                        <tr class="border-b border-neutral-200 bg-neutral-50 text-neutral-700
                                   dark:border-neutral-700 dark:bg-neutral-800 dark:text-neutral-400">
                            <th class="px-6 py-4 font-medium text-left">Quote #</th>
                            <th class="px-6 py-4 font-medium text-left">Customer &amp; Project</th>
                            <th class="px-6 py-4 font-medium text-left">Technician</th>
                            <th class="px-6 py-4 font-medium text-right">Amount</th>
                            <th class="px-6 py-4 font-medium text-right">Submitted</th>
                            <th class="px-6 py-4 font-medium text-center">Status</th>
                        </tr>
                    </thead>

                    <tbody class="text-neutral-700 dark:text-neutral-300">
                        @forelse ($quotations as $quote)
                            <tr class="border-b border-neutral-100 hover:bg-neutral-50 dark:border-neutral-800 dark:hover:bg-neutral-800/50">
                                <td class="px-6 py-4 font-medium">
                                    Q-{{ str_pad($quote->id, 5, '0', STR_PAD_LEFT) }}
                                </td>
                                <td class="px-6 py-4">
                                    <div class="font-medium">{{ $quote->client_name }}</div>
                                    <div class="text-xs text-neutral-500">{{ $quote->project_title }}</div>
                                </td>
                                <td class="px-6 py-4 text-neutral-600 dark:text-neutral-400">
                                    {{ $quote->technician->name ?? '—' }}
                                </td>
                                <td class="px-6 py-4 font-medium text-right whitespace-nowrap">
                                    ₱{{ number_format($quote->grand_total, 2) }}
                                </td>
                                <td class="px-6 py-4 text-right">
                                    {{ optional($quote->date_issued)->diffForHumans() }}
                                </td>

                                {{-- Status Badge --}}
                                <td class="px-6 py-4 text-center">
                                    @php
                                        $color = match($quote->status) {
                                            'pending' => 'bg-blue-100 text-blue-700',
                                            'approved' => 'bg-green-100 text-green-700',
                                            'rejected' => 'bg-red-100 text-red-700',
                                            default => 'bg-gray-100 text-gray-700'
                                        };
                                    @endphp
                                    <span class="inline-flex rounded-full {{ $color }} px-3 py-1 text-xs font-semibold capitalize">
                                        {{ $quote->status }}
                                    </span>
                                </td>

                                {{-- Actions --}}
                                <td class="px-6 py-5 text-center align-middle">
                                    <div class="inline-flex items-center justify-center gap-4">
                                        
                                        @if ($quote->status === 'pending')
                                            <form action="{{ route('manager.quotation.approve', $quote->id) }}"
                                                  method="POST" class="inline">
                                                @csrf
                                                <button type="submit"
                                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-emerald-50 hover:bg-emerald-100 text-emerald-700 hover:text-emerald-900 rounded-lg text-xs font-medium border border-emerald-200 transition-colors"
                                                        title="Approve">
                                                    <i class="fas fa-check mr-2"></i>
                                                    Downpayment paid
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center text-neutral-500">
                                    No quotations to review
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="border-t bg-white px-6 py-3 text-sm text-neutral-500 dark:bg-neutral-900 dark:border-neutral-700">
                {{ $quotations->links() }}
            </div>
        </div>
    </div>

</x-layouts.app>
