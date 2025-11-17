<x-layouts.app :title="__('Quotations')">
    <div class="flex h-full w-full flex-1 flex-col gap-6 rounded-xl">

        {{-- Header + primary actions --}}
        <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
            <div>
                <h1 class="text-xl font-semibold tracking-tight text-neutral-900 dark:text-neutral-50">
                    {{ __('Quotations') }}
                </h1>
                <p class="text-sm text-neutral-500 dark:text-neutral-400">
                    Manage quotations from new inquiries up to approved jobs.
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
                    {{ __('New Quotation') }}
                </button>
            </div>
        </div>

        {{-- Stat cards --}}
        <div class="grid gap-4 md:grid-cols-4">
            <div class="rounded-xl border border-neutral-200 bg-white p-4 dark:border-neutral-700 dark:bg-neutral-900">
                <p class="text-xs font-medium text-neutral-500 dark:text-neutral-400">{{ __('Drafts') }}</p>
                <p class="mt-2 text-2xl font-semibold tracking-tight text-neutral-900 dark:text-neutral-50">
                    {{ $stats['quotations']['draft'] ?? 0 }}
                </p>
                <p class="mt-1 text-xs text-neutral-500 dark:text-neutral-400">
                    {{ __('Waiting for review') }}
                </p>
            </div>

            <div class="rounded-xl border border-neutral-200 bg-white p-4 dark:border-neutral-700 dark:bg-neutral-900">
                <p class="text-xs font-medium text-neutral-500 dark:text-neutral-400">{{ __('Sent') }}</p>
                <p class="mt-2 text-2xl font-semibold tracking-tight text-neutral-900 dark:text-neutral-50">
                    {{ $stats['quotations']['sent'] ?? 0 }}
                </p>
                <p class="mt-1 text-xs text-neutral-500 dark:text-neutral-400">
                    {{ __('Sent to customers') }}
                </p>
            </div>

            <div class="rounded-xl border border-neutral-200 bg-white p-4 dark:border-neutral-700 dark:bg-neutral-900">
                <p class="text-xs font-medium text-neutral-500 dark:text-neutral-400">{{ __('Approved') }}</p>
                <p class="mt-2 text-2xl font-semibold tracking-tight text-emerald-500">
                    {{ $stats['quotations']['approved'] ?? 0 }}
                </p>
                <p class="mt-1 text-xs text-neutral-500 dark:text-neutral-400">
                    {{ __('Converted to jobs') }}
                </p>
            </div>

            <div class="rounded-xl border border-neutral-200 bg-white p-4 dark:border-neutral-700 dark:bg-neutral-900">
                <p class="text-xs font-medium text-neutral-500 dark:text-neutral-400">{{ __('Rejected / Expired') }}</p>
                <p class="mt-2 text-2xl font-semibold tracking-tight text-red-500">
                    {{ $stats['quotations']['rejected'] ?? 0 }}
                </p>
                <p class="mt-1 text-xs text-neutral-500 dark:text-neutral-400">
                    {{ __('Need follow-up or closure') }}
                </p>
            </div>
        </div>

        {{-- Filters + search --}}
        <div
            class="flex flex-col gap-3 rounded-xl border border-neutral-200 bg-white p-4 dark:border-neutral-700 dark:bg-neutral-900 md:flex-row md:items-center md:justify-between"
        >
            <div class="flex flex-wrap items-center gap-2 text-xs">
                <span class="text-neutral-500 dark:text-neutral-400">{{ __('Status:') }}</span>

                <button class="rounded-full bg-neutral-900 px-3 py-1 text-xs font-medium text-white dark:bg-neutral-100 dark:text-neutral-900">
                    {{ __('All') }}
                </button>
                <button class="rounded-full bg-neutral-100 px-3 py-1 text-xs font-medium text-neutral-700 hover:bg-neutral-200 dark:bg-neutral-800 dark:text-neutral-100 dark:hover:bg-neutral-700">
                    {{ __('Draft') }}
                </button>
                <button class="rounded-full bg-neutral-100 px-3 py-1 text-xs font-medium text-neutral-700 hover:bg-neutral-200 dark:bg-neutral-800 dark:text-neutral-100 dark:hover:bg-neutral-700">
                    {{ __('Sent') }}
                </button>
                <button class="rounded-full bg-neutral-100 px-3 py-1 text-xs font-medium text-neutral-700 hover:bg-neutral-200 dark:bg-neutral-800 dark:text-neutral-100 dark:hover:bg-neutral-700">
                    {{ __('Approved') }}
                </button>
                <button class="rounded-full bg-neutral-100 px-3 py-1 text-xs font-medium text-neutral-700 hover:bg-neutral-200 dark:bg-neutral-800 dark:text-neutral-100 dark:hover:bg-neutral-700">
                    {{ __('Rejected') }}
                </button>
            </div>

            <div class="flex w-full items-center gap-2 md:w-auto">
                <div class="relative flex-1 text-xs">
                    <span class="pointer-events-none absolute inset-y-0 left-2 flex items-center text-neutral-400">
                        <x-flux::icon name="magnifying-glass" class="h-4 w-4" />
                    </span>
                    <input
                        type="text"
                        placeholder="{{ __('Search quotation #, customer, device…') }}"
                        class="w-full rounded-lg border border-neutral-200 bg-neutral-50 py-2 pl-8 pr-3 text-xs text-neutral-800 placeholder:text-neutral-400 focus:border-emerald-500 focus:outline-none focus:ring-1 focus:ring-emerald-500 dark:border-neutral-700 dark:bg-neutral-900 dark:text-neutral-100"
                    >
                </div>

                <button
                    type="button"
                    class="hidden items-center rounded-lg border border-neutral-200 bg-white px-3 py-2 text-xs font-medium text-neutral-700 hover:bg-neutral-50 dark:border-neutral-700 dark:bg-neutral-900 dark:text-neutral-100 dark:hover:bg-neutral-800 md:inline-flex"
                >
                    <x-flux::icon name="adjustments-horizontal" class="mr-1.5 h-3.5 w-3.5" />
                    {{ __('Advanced') }}
                </button>
            </div>
        </div>

        {{-- Quotations table --}}
        <div class="relative flex-1 overflow-hidden rounded-xl border border-neutral-200 bg-white dark:border-neutral-700 dark:bg-neutral-900">
            <div class="overflow-x-auto">
                <table class="min-w-full border-separate border-spacing-0 text-left text-xs">
                    <thead>
                        <tr class="border-b border-neutral-100 bg-neutral-50 text-neutral-500 dark:border-neutral-800 dark:bg-neutral-900/60 dark:text-neutral-400">
                            <th class="px-4 py-3 font-medium">{{ __('Quote #') }}</th>
                            <th class="px-4 py-3 font-medium">{{ __('Customer') }}</th>
                            <th class="px-4 py-3 font-medium">{{ __('Device / Issue') }}</th>
                            <th class="px-4 py-3 font-medium">{{ __('Status') }}</th>
                            <th class="px-4 py-3 font-medium">{{ __('Total') }}</th>
                            <th class="px-4 py-3 font-medium">{{ __('Created') }}</th>
                            <th class="px-4 py-3 font-medium text-right">{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- Example static row – replace later with @foreach($quotations as $quote) --}}
                        <tr class="border-b border-neutral-100 text-neutral-700 dark:border-neutral-800 dark:text-neutral-100">
                            <td class="px-4 py-3 align-middle font-medium">Q-2025-0001</td>
                            <td class="px-4 py-3 align-middle">Juan Dela Cruz</td>
                            <td class="px-4 py-3 align-middle">Laptop – No power</td>
                            <td class="px-4 py-3 align-middle">
                                <span class="inline-flex items-center rounded-full bg-amber-100 px-2 py-0.5 text-[11px] font-medium text-amber-800 dark:bg-amber-900/40 dark:text-amber-200">
                                    {{ __('Pending Approval') }}
                                </span>
                            </td>
                            <td class="px-4 py-3 align-middle">₱ 3,500.00</td>
                            <td class="px-4 py-3 align-middle">Nov 16, 2025</td>
                            <td class="px-4 py-3 align-middle text-right">
                                <button class="text-xs font-medium text-emerald-600 hover:underline">
                                    {{ __('View') }}
                                </button>
                                <span class="mx-1 text-neutral-400">•</span>
                                <button class="text-xs font-medium text-neutral-500 hover:underline">
                                    {{ __('Edit') }}
                                </button>
                            </td>
                        </tr>

                        {{-- Empty state --}}
                        {{-- 
                        @forelse ($quotations as $quote)
                            ...
                        @empty
                        --}}
                        <tr>
                            <td colspan="7" class="px-4 py-10 text-center text-xs text-neutral-500 dark:text-neutral-400">
                                {{ __('No quotations yet. Create a new quotation from a customer inquiry to see it here.') }}
                            </td>
                        </tr>
                        {{-- @endforelse --}}
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</x-layouts.app>
