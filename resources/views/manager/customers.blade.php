<x-layouts.app :title="__('Customers')">
    <div class="flex h-full w-full flex-1 flex-col gap-6 rounded-xl">

        {{-- Header + primary actions --}}
        <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
            <div>
                <h1 class="text-xl font-semibold tracking-tight text-neutral-900 dark:text-neutral-50">
                    {{ __('Customers') }}
                </h1>
                <p class="text-sm text-neutral-500 dark:text-neutral-400">
                    View and manage your customers, their contact details, and their service history.
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
                    <x-flux::icon name="user-plus" class="mr-2 h-4 w-4" />
                    {{ __('Add Customer') }}
                </button>
            </div>
        </div>

        {{-- Stat cards --}}
        <div class="grid gap-4 md:grid-cols-4">
            <div class="rounded-xl border border-neutral-200 bg-white p-4 dark:border-neutral-700 dark:bg-neutral-900">
                <p class="text-xs font-medium text-neutral-500 dark:text-neutral-400">{{ __('Total Customers') }}</p>
                <p class="mt-2 text-2xl font-semibold tracking-tight text-neutral-900 dark:text-neutral-50">
                    {{ $stats['customers']['total'] ?? 0 }}
                </p>
                <p class="mt-1 text-xs text-neutral-500 dark:text-neutral-400">
                    {{ __('All customers in the system') }}
                </p>
            </div>

            <div class="rounded-xl border border-neutral-200 bg-white p-4 dark:border-neutral-700 dark:bg-neutral-900">
                <p class="text-xs font-medium text-neutral-500 dark:text-neutral-400">{{ __('Active') }}</p>
                <p class="mt-2 text-2xl font-semibold tracking-tight text-emerald-500">
                    {{ $stats['customers']['active'] ?? 0 }}
                </p>
                <p class="mt-1 text-xs text-neutral-500 dark:text-neutral-400">
                    {{ __('With recent jobs or inquiries') }}
                </p>
            </div>

            <div class="rounded-xl border border-neutral-200 bg-white p-4 dark:border-neutral-700 dark:bg-neutral-900">
                <p class="text-xs font-medium text-neutral-500 dark:text-neutral-400">{{ __('With Pending Jobs') }}</p>
                <p class="mt-2 text-2xl font-semibold tracking-tight text-amber-500">
                    {{ $stats['customers']['pending_jobs'] ?? 0 }}
                </p>
                <p class="mt-1 text-xs text-neutral-500 dark:text-neutral-400">
                    {{ __('Have ongoing service requests') }}
                </p>
            </div>

            <div class="rounded-xl border border-neutral-200 bg-white p-4 dark:border-neutral-700 dark:bg-neutral-900">
                <p class="text-xs font-medium text-neutral-500 dark:text-neutral-400">{{ __('New This Month') }}</p>
                <p class="mt-2 text-2xl font-semibold tracking-tight text-neutral-900 dark:text-neutral-50">
                    {{ $stats['customers']['new_month'] ?? 0 }}
                </p>
                <p class="mt-1 text-xs text-neutral-500 dark:text-neutral-400">
                    {{ __('Customers added this month') }}
                </p>
            </div>
        </div>

        {{-- Filters + search --}}
        <div
            class="flex flex-col gap-3 rounded-xl border border-neutral-200 bg-white p-4 dark:border-neutral-700 dark:bg-neutral-900 md:flex-row md:items-center md:justify-between"
        >
            <div class="flex flex-wrap items-center gap-2 text-xs">
                <span class="text-neutral-500 dark:text-neutral-400">{{ __('Type:') }}</span>

                <button class="rounded-full bg-neutral-900 px-3 py-1 text-xs font-medium text-white dark:bg-neutral-100 dark:text-neutral-900">
                    {{ __('All') }}
                </button>
                <button class="rounded-full bg-neutral-100 px-3 py-1 text-xs font-medium text-neutral-700 hover:bg-neutral-200 dark:bg-neutral-800 dark:text-neutral-100 dark:hover:bg-neutral-700">
                    {{ __('Walk-in') }}
                </button>
                <button class="rounded-full bg-neutral-100 px-3 py-1 text-xs font-medium text-neutral-700 hover:bg-neutral-200 dark:bg-neutral-800 dark:text-neutral-100 dark:hover:bg-neutral-700">
                    {{ __('Online') }}
                </button>
                <button class="rounded-full bg-neutral-100 px-3 py-1 text-xs font-medium text-neutral-700 hover:bg-neutral-200 dark:bg-neutral-800 dark:text-neutral-100 dark:hover:bg-neutral-700">
                    {{ __('Repeat') }}
                </button>
            </div>

            <div class="flex w-full items-center gap-2 md:w-auto">
                <div class="relative flex-1 text-xs">
                    <span class="pointer-events-none absolute inset-y-0 left-2 flex items-center text-neutral-400">
                        <x-flux::icon name="magnifying-glass" class="h-4 w-4" />
                    </span>
                    <input
                        type="text"
                        placeholder="{{ __('Search by name, email, phone…') }}"
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

        {{-- Customers table --}}
        <div class="relative flex-1 overflow-hidden rounded-xl border border-neutral-200 bg-white dark:border-neutral-700 dark:bg-neutral-900">
            <div class="overflow-x-auto">
                <table class="min-w-full border-separate border-spacing-0 text-left text-sm">
                    <thead>
                        <tr class="border-b border-neutral-100 bg-neutral-50 text-neutral-700 dark:border-neutral-800 dark:bg-neutral-900/60 dark:text-neutral-400">
                            <th class="px-4 py-3 font-medium text-left">{{ __('Customer') }}</th>
                            <th class="px-4 py-3 font-medium text-left">{{ __('Contact') }}</th>
                            <th class="px-4 py-3 font-medium text-center">{{ __('Total Jobs') }}</th>
                            <th class="px-4 py-3 font-medium text-center">{{ __('Last Activity') }}</th>
                            <th class="px-4 py-3 font-medium text-center">{{ __('Status') }}</th>
                            <th class="px-4 py-3 font-medium text-center w-40">{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- Example static row – replace with @foreach($customers as $customer) --}}
                        <tr class="border-b border-neutral-100 text-neutral-700 dark:border-neutral-800 dark:text-neutral-100">
                            <td class="px-4 py-3 align-middle">
                                <div class="flex flex-col">
                                    <span class="text-xs font-medium">Juan Dela Cruz</span>
                                    <span class="text-xs text-neutral-500 dark:text-neutral-400">
                                        {{ __('Online customer') }}
                                    </span>
                                </div>
                            </td>
                            <td class="px-4 py-3 align-middle">
                                <div class="flex flex-col">
                                    <span class="text-xs">0917 123 4567</span>
                                    <span class="text-xs text-neutral-500">juan@example.com</span>
                                </div>
                            </td>
                            <td class="px-4 py-3 align-middle text-center">
                                5
                            </td>
                            <td class="px-4 py-3 align-middle text-center">
                                {{ __('Nov 15, 2025 · Quotation approved') }}
                            </td>
                            <td class="px-4 py-3 align-middle text-center">
                                <span class="inline-flex items-center rounded-full bg-emerald-100 px-2 py-0.5 text-xs font-medium text-emerald-800 dark:bg-emerald-900/40 dark:text-emerald-200">
                                    {{ __('Active') }}
                                </span>
                            </td>
                            <td class="px-4 py-3 align-middle text-center">
                                <div class="inline-flex items-center justify-center gap-2">
                                    <a href="#" class="inline-flex w-8 h-8 items-center justify-center text-blue-600 hover:text-blue-800" title="View"><i class="fas fa-eye"></i><span class="sr-only">View</span></a>
                                    <a href="#" class="inline-flex w-8 h-8 items-center justify-center text-amber-600 hover:text-amber-700" title="Edit"><i class="fas fa-pen-to-square"></i><span class="sr-only">Edit</span></a>
                                    <a href="#" class="inline-flex w-8 h-8 items-center justify-center text-slate-600 hover:text-slate-700" title="History"><i class="fas fa-clock-rotate-left"></i><span class="sr-only">History</span></a>
                                </div>
                            </td>
                        </tr>

                        {{-- Empty state --}}
                        {{-- 
                        @forelse ($customers as $customer)
                            ...
                        @empty
                        --}}
                        <tr>
                            <td colspan="6" class="px-4 py-10 text-center text-xs text-neutral-500 dark:text-neutral-400">
                                {{ __('No customers found yet. Add a customer or convert an inquiry/quotation to see them here.') }}
                            </td>
                        </tr>
                        {{-- @endforelse --}}
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</x-layouts.app>
