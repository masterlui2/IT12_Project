{{-- Quotation & Payment Records Table --}}
<div class="rounded-2xl border border-neutral-200 bg-white shadow-sm dark:border-neutral-800 dark:bg-neutral-900 md:col-span-2">

    {{-- Header --}}
    <div class="flex items-start justify-between gap-4 border-b border-neutral-200 bg-neutral-50 px-4 py-3 dark:border-neutral-800 dark:bg-neutral-900/60">
        <div>
            <h2 class="text-sm font-semibold text-neutral-900 dark:text-neutral-50">
                {{ __('Quotation & Payment Records') }}
            </h2>
            <p class="mt-0.5 text-[11px] text-neutral-500 dark:text-neutral-400">
                {{ __('Live rows from quotations') }}
            </p>
        </div>

        @if(method_exists($reportRows,'total'))
            <div class="text-right text-[11px] text-neutral-500 dark:text-neutral-400">
                <div>
                    {{ __('Total:') }}
                    <span class="font-semibold text-neutral-800 dark:text-neutral-200">{{ $reportRows->total() }}</span>
                </div>
                @if(method_exists($reportRows,'firstItem') && $reportRows->firstItem())
                    <div class="mt-0.5">
                        {{ __('Showing') }}
                        <span class="font-semibold text-neutral-800 dark:text-neutral-200">{{ $reportRows->firstItem() }}</span>
                        –
                        <span class="font-semibold text-neutral-800 dark:text-neutral-200">{{ $reportRows->lastItem() }}</span>
                    </div>
                @endif
            </div>
        @endif
    </div>

    {{-- Table (no horizontal scroll) --}}
    <div class="w-full">
        <table class="w-full table-fixed text-left text-sm">
            <thead class="sticky top-0 z-10 bg-white dark:bg-neutral-900">
                <tr class="border-b border-neutral-200 text-[11px] uppercase tracking-wide text-neutral-600 dark:border-neutral-800 dark:text-neutral-400">
                    <th class="w-[110px] px-4 py-3 text-center font-semibold">{{ __('Date') }}</th>
                    <th class="w-[120px] px-4 py-3 font-semibold">{{ __('Quotation #') }}</th>

                    {{-- Customer grows, but truncates --}}
                    <th class="px-4 py-3 font-semibold">{{ __('Customer') }}</th>

                    {{-- Status --}}
                    <th class="w-[120px] px-4 py-3 font-semibold">{{ __('Status') }}</th>

                    {{-- Totals: hide on very small screens to avoid scroll --}}
                    <th class="hidden w-[150px] px-4 py-3 text-right font-semibold sm:table-cell">
                        {{ __('Quotation Total') }}
                    </th>
                    <th class="hidden w-[150px] px-4 py-3 text-right font-semibold sm:table-cell">
                        {{ __('Diagnostic Fee') }}
                    </th>
                </tr>
            </thead>

            <tbody class="divide-y divide-neutral-100 dark:divide-neutral-800">
                @forelse ($reportRows as $row)
                    @php
                        $status = $row->status ?? 'pending';

                        $statusBadge = match ($status) {
                            'approved' => 'bg-emerald-50 text-emerald-700 ring-1 ring-emerald-200 dark:bg-emerald-900/20 dark:text-emerald-200 dark:ring-emerald-900/40',
                            'pending'  => 'bg-amber-50 text-amber-700 ring-1 ring-amber-200 dark:bg-amber-900/20 dark:text-amber-200 dark:ring-amber-900/40',
                            'rejected' => 'bg-rose-50 text-rose-700 ring-1 ring-rose-200 dark:bg-rose-900/20 dark:text-rose-200 dark:ring-rose-900/40',
                            default    => 'bg-neutral-50 text-neutral-700 ring-1 ring-neutral-200 dark:bg-neutral-800/40 dark:text-neutral-200 dark:ring-neutral-700',
                        };

                        $customerName =
                            $row->customer?->firstname
                                ? trim($row->customer->firstname . ' ' . $row->customer->lastname)
                                : ($row->inquiry?->customer_name ?? __('Walk-in customer'));
                    @endphp

                    <tr class="group odd:bg-neutral-50/50 hover:bg-neutral-100/60 dark:odd:bg-neutral-800/20 dark:hover:bg-neutral-800/40">
                        <td class="px-4 py-3 text-center text-xs text-neutral-700 dark:text-neutral-100 whitespace-nowrap">
                            {{ optional($row->date_issued)->format('M d, Y') ?? '—' }}
                        </td>

                        <td class="px-4 py-3 text-xs font-semibold text-neutral-900 dark:text-neutral-50 whitespace-nowrap">
                            Q-{{ str_pad($row->id, 6, '0', STR_PAD_LEFT) }}
                        </td>

                        <td class="px-4 py-3 text-xs text-neutral-700 dark:text-neutral-100">
                            <div class="truncate" title="{{ $customerName }}">
                                {{ $customerName }}
                            </div>

                            {{-- On mobile, show totals under customer to avoid horizontal scroll --}}
                            <div class="mt-1 space-y-1 text-[11px] text-neutral-500 dark:text-neutral-400 sm:hidden">
                                <div class="flex items-center justify-between">
                                    <span>{{ __('Quotation Total') }}</span>
                                    <span class="font-semibold text-neutral-800 dark:text-neutral-200">
                                        ₱{{ number_format($row->grand_total ?? 0, 2) }}
                                    </span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span>{{ __('Diagnostic Fee') }}</span>
                                    <span class="font-semibold text-neutral-800 dark:text-neutral-200">
                                        ₱{{ number_format($row->diagnostic_fee ?? 0, 2) }}
                                    </span>
                                </div>
                            </div>
                        </td>

                        <td class="px-4 py-3 text-xs whitespace-nowrap">
                            <span class="inline-flex items-center rounded-full px-2 py-1 text-[10px] font-semibold uppercase tracking-wide {{ $statusBadge }}">
                                {{ $status }}
                            </span>
                        </td>

                        <td class="hidden px-4 py-3 text-right text-xs font-semibold text-neutral-900 dark:text-neutral-50 whitespace-nowrap sm:table-cell">
                            ₱{{ number_format($row->grand_total ?? 0, 2) }}
                        </td>

                        <td class="hidden px-4 py-3 text-right text-xs font-semibold text-neutral-900 dark:text-neutral-50 whitespace-nowrap sm:table-cell">
                            ₱{{ number_format($row->diagnostic_fee ?? 0, 2) }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12">
                            <div class="rounded-xl border border-dashed border-neutral-200 p-8 text-center dark:border-neutral-800">
                                <p class="text-sm font-semibold text-neutral-900 dark:text-neutral-50">
                                    {{ __('No payment data yet.') }}
                                </p>
                                <p class="mt-1 text-xs text-neutral-500 dark:text-neutral-400">
                                    {{ __('Adjust the date range or generate a new report to see details here.') }}
                                </p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    @if(method_exists($reportRows, 'hasPages') && $reportRows->hasPages())
        <div class="flex flex-col gap-2 border-t border-neutral-200 bg-neutral-50 px-4 py-3 dark:border-neutral-800 dark:bg-neutral-900/60 sm:flex-row sm:items-center sm:justify-between">
            <p class="text-[11px] text-neutral-500 dark:text-neutral-400">
                {{ __('Page') }}
                <span class="font-semibold text-neutral-800 dark:text-neutral-200">{{ $reportRows->currentPage() }}</span>
                {{ __('of') }}
                <span class="font-semibold text-neutral-800 dark:text-neutral-200">{{ $reportRows->lastPage() }}</span>
            </p>

{{ $reportRows->onEachSide(1)->links('pagination::tailwind') }}
        </div>
    @endif
</div>
