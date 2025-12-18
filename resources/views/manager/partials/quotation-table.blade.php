{{-- Job Order & Revenue Records Table --}}
<div class="rounded-2xl border border-neutral-200 bg-white shadow-sm dark:border-neutral-800 dark:bg-neutral-900 md:col-span-2">

    {{-- Header --}}
    <div class="flex items-start justify-between gap-4 border-b border-neutral-200 bg-neutral-50 px-4 py-3 dark:border-neutral-800 dark:bg-neutral-900/60">
        <div>
            <h2 class="text-sm font-semibold text-neutral-900 dark:text-neutral-50">
                {{ __('Job Order & Revenue Records') }}
            </h2>
            <p class="mt-0.5 text-[11px] text-neutral-500 dark:text-neutral-400">
                {{ __('Completed job orders with actual revenue') }}
            </p>
        </div>

        @if(isset($recentJobOrders) && method_exists($recentJobOrders, 'total'))
            <div class="text-right text-[11px] text-neutral-500 dark:text-neutral-400">
                <div>
                    {{ __('Total Jobs:') }}
                    <span class="font-semibold text-neutral-800 dark:text-neutral-200">{{ $recentJobOrders->total() }}</span>
                </div>
                <div class="mt-0.5">
                    {{ __('Total Revenue:') }}
                    <span class="font-semibold text-emerald-600">
                        ₱{{ number_format($stats['reports']['completed_jobs_revenue'] ?? 0, 2) }}
                    </span>
                </div>
                @if(method_exists($recentJobOrders, 'firstItem') && $recentJobOrders->firstItem())
                    <div class="mt-0.5">
                        {{ __('Showing') }}
                        <span class="font-semibold text-neutral-800 dark:text-neutral-200">{{ $recentJobOrders->firstItem() }}</span>
                        –
                        <span class="font-semibold text-neutral-800 dark:text-neutral-200">{{ $recentJobOrders->lastItem() }}</span>
                    </div>
                @endif
            </div>
        @elseif(isset($recentJobOrders))
            <div class="text-right text-[11px] text-neutral-500 dark:text-neutral-400">
                <div>
                    {{ __('Total Jobs:') }}
                    <span class="font-semibold text-neutral-800 dark:text-neutral-200">{{ $recentJobOrders->count() }}</span>
                </div>
                <div class="mt-0.5">
                    {{ __('Total Revenue:') }}
                    <span class="font-semibold text-emerald-600">
                        ₱{{ number_format($stats['reports']['completed_jobs_revenue'] ?? 0, 2) }}
                    </span>
                </div>
            </div>
        @endif
    </div>

    {{-- Table (no horizontal scroll) --}}
    <div class="w-full">
        <table class="w-full table-fixed text-left text-sm">
            <thead class="sticky top-0 z-10 bg-white dark:bg-neutral-900">
                <tr class="border-b border-neutral-200 text-[11px] uppercase tracking-wide text-neutral-600 dark:border-neutral-800 dark:text-neutral-400">
                    <th class="w-[110px] px-4 py-3 text-center font-semibold">{{ __('Date') }}</th>
                    <th class="w-[120px] px-4 py-3 font-semibold">{{ __('Job Order #') }}</th>

                    {{-- Customer grows, but truncates --}}
                    <th class="px-4 py-3 font-semibold">{{ __('Customer / Project') }}</th>

                    {{-- Status --}}
                    <th class="w-[120px] px-4 py-3 font-semibold">{{ __('Status') }}</th>

                    {{-- Totals: hide on very small screens to avoid scroll --}}
                    <th class="hidden w-[140px] px-4 py-3 text-right font-semibold sm:table-cell">
                        {{ __('Subtotal') }}
                    </th>
                    <th class="hidden w-[140px] px-4 py-3 text-right font-semibold sm:table-cell">
                        {{ __('Balance Due') }}
                    </th>
                </tr>
            </thead>

            <tbody class="divide-y divide-neutral-100 dark:divide-neutral-800">
                @forelse ($recentJobOrders ?? [] as $job)
                    @php
                        $status = $job->status ?? 'scheduled';

                        $statusBadge = match ($status) {
                            'completed'   => 'bg-emerald-50 text-emerald-700 ring-1 ring-emerald-200 dark:bg-emerald-900/20 dark:text-emerald-200 dark:ring-emerald-900/40',
                            'in_progress' => 'bg-amber-50 text-amber-700 ring-1 ring-amber-200 dark:bg-amber-900/20 dark:text-amber-200 dark:ring-amber-900/40',
                            'scheduled'   => 'bg-blue-50 text-blue-700 ring-1 ring-blue-200 dark:bg-blue-900/20 dark:text-blue-200 dark:ring-blue-900/40',
                            'cancelled'   => 'bg-rose-50 text-rose-700 ring-1 ring-rose-200 dark:bg-rose-900/20 dark:text-rose-200 dark:ring-rose-900/40',
                            default       => 'bg-neutral-50 text-neutral-700 ring-1 ring-neutral-200 dark:bg-neutral-800/40 dark:text-neutral-200 dark:ring-neutral-700',
                        };

                        $customerName = $job->quotation?->client_name 
                            ?? $job->quotation?->customer?->name
                            ?? __('Walk-in customer');
                        
                        $projectTitle = $job->quotation?->project_title ?? '—';
                    @endphp

                    <tr class="group odd:bg-neutral-50/50 hover:bg-neutral-100/60 dark:odd:bg-neutral-800/20 dark:hover:bg-neutral-800/40">
                        <td class="px-4 py-3 text-center text-xs text-neutral-700 dark:text-neutral-100 whitespace-nowrap">
                            {{ $job->created_at?->format('M d, Y') ?? '—' }}
                        </td>

                        <td class="px-4 py-3 text-xs font-semibold text-neutral-900 dark:text-neutral-50 whitespace-nowrap">
                            JOB-{{ str_pad($job->id, 4, '0', STR_PAD_LEFT) }}
                        </td>

                        <td class="px-4 py-3 text-xs text-neutral-700 dark:text-neutral-100">
                            <div class="truncate font-semibold text-neutral-900 dark:text-neutral-50" title="{{ $customerName }}">
                                {{ $customerName }}
                            </div>
                            <div class="truncate text-[11px] text-neutral-500 dark:text-neutral-400" title="{{ $projectTitle }}">
                                {{ $projectTitle }}
                            </div>

                            {{-- On mobile, show totals under customer to avoid horizontal scroll --}}
                            <div class="mt-1 space-y-1 text-[11px] text-neutral-500 dark:text-neutral-400 sm:hidden">
                                <div class="flex items-center justify-between">
                                    <span>{{ __('Subtotal') }}</span>
                                    <span class="font-semibold text-neutral-800 dark:text-neutral-200">
                                        ₱{{ number_format($job->subtotal ?? 0, 2) }}
                                    </span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span>{{ __('Balance Due') }}</span>
                                    <span class="font-semibold text-blue-600 dark:text-blue-400">
                                        ₱{{ number_format($job->total_amount ?? 0, 2) }}
                                    </span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span>{{ __('Downpayment') }}</span>
                                    <span class="font-semibold text-emerald-600">
                                        ₱{{ number_format($job->downpayment ?? 0, 2) }}
                                    </span>
                                </div>
                            </div>
                        </td>

                        <td class="px-4 py-3 text-xs whitespace-nowrap">
                            <span class="inline-flex items-center rounded-full px-2 py-1 text-[10px] font-semibold uppercase tracking-wide {{ $statusBadge }}">
                                {{ str_replace('_', ' ', $status) }}
                            </span>
                        </td>

                        <td class="hidden px-4 py-3 text-right text-xs font-semibold text-neutral-900 dark:text-neutral-50 whitespace-nowrap sm:table-cell">
                            ₱{{ number_format($job->subtotal ?? 0, 2) }}
                            <div class="text-[10px] font-normal text-emerald-600">
                                ↓ ₱{{ number_format($job->downpayment ?? 0, 2) }}
                            </div>
                        </td>

                        <td class="hidden px-4 py-3 text-right text-xs font-semibold text-blue-600 dark:text-blue-400 whitespace-nowrap sm:table-cell">
                            ₱{{ number_format($job->total_amount ?? 0, 2) }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12">
                            <div class="rounded-xl border border-dashed border-neutral-200 p-8 text-center dark:border-neutral-800">
                                <p class="text-sm font-semibold text-neutral-900 dark:text-neutral-50">
                                    {{ __('No job orders yet.') }}
                                </p>
                                <p class="mt-1 text-xs text-neutral-500 dark:text-neutral-400">
                                    {{ __('Job orders will appear here once quotations are converted and work begins.') }}
                                </p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    @if(isset($recentJobOrders) && method_exists($recentJobOrders, 'hasPages') && $recentJobOrders->hasPages())
        <div class="flex flex-col gap-2 border-t border-neutral-200 bg-neutral-50 px-4 py-3 dark:border-neutral-800 dark:bg-neutral-900/60 sm:flex-row sm:items-center sm:justify-between">
            <p class="text-[11px] text-neutral-500 dark:text-neutral-400">
                {{ __('Page') }}
                <span class="font-semibold text-neutral-800 dark:text-neutral-200">{{ $recentJobOrders->currentPage() }}</span>
                {{ __('of') }}
                <span class="font-semibold text-neutral-800 dark:text-neutral-200">{{ $recentJobOrders->lastPage() }}</span>
            </p>

            {{ $recentJobOrders->onEachSide(1)->links('pagination::tailwind') }}
        </div>
    @endif
</div>