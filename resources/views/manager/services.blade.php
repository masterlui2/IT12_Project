<x-layouts.app :title="__('Services')">
    <div class="flex h-full w-full flex-1 flex-col gap-6 rounded-xl">

        {{-- Header + primary actions --}}
        <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
            <div>
                <h1 class="text-xl font-semibold tracking-tight text-neutral-900 dark:text-neutral-50">
                    {{ __('Services') }}
                </h1>
                <p class="text-sm text-neutral-500 dark:text-neutral-400">
                    Manage your service catalog – pricing, categories, and estimated completion time.
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
                    {{ __('Add Service') }}
                </button>
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
                    {{ __('Active') }}
                </button>
                <button class="rounded-full bg-neutral-100 px-3 py-1 text-xs font-medium text-neutral-700 hover:bg-neutral-200 dark:bg-neutral-800 dark:text-neutral-100 dark:hover:bg-neutral-700">
                    {{ __('Hidden') }}
                </button>

                <span class="ml-3 text-neutral-500 dark:text-neutral-400">{{ __('Pricing:') }}</span>
                <button class="rounded-full bg-neutral-100 px-3 py-1 text-xs font-medium text-neutral-700 hover:bg-neutral-200 dark:bg-neutral-800 dark:text-neutral-100 dark:hover:bg-neutral-700">
                    {{ __('Flat rate') }}
                </button>
                <button class="rounded-full bg-neutral-100 px-3 py-1 text-xs font-medium text-neutral-700 hover:bg-neutral-200 dark:bg-neutral-800 dark:text-neutral-100 dark:hover:bg-neutral-700">
                    {{ __('Per hour') }}
                </button>
            </div>

            <div class="flex w-full flex-col gap-2 md:w-auto md:flex-row md:items-center">
                <div class="relative flex-1 text-xs">
                    <span class="pointer-events-none absolute inset-y-0 left-2 flex items-center text-neutral-400">
                        <x-flux::icon name="magnifying-glass" class="h-4 w-4" />
                    </span>
                    <input
                        type="text"
                        placeholder="{{ __('Search by service name, category…') }}"
                        class="w-full rounded-lg border border-neutral-200 bg-neutral-50 py-2 pl-8 pr-3 text-xs text-neutral-800 placeholder:text-neutral-400 focus:border-emerald-500 focus:outline-none focus:ring-1 focus:ring-emerald-500 dark:border-neutral-700 dark:bg-neutral-900 dark:text-neutral-100"
                    >
                </div>

                <div class="flex items-center gap-2 text-xs">
                    <span class="text-neutral-500 dark:text-neutral-400">{{ __('Category:') }}</span>
                    <select
                        class="rounded-lg border border-neutral-200 bg-neutral-50 px-2 py-2 text-xs text-neutral-800 focus:border-emerald-500 focus:outline-none focus:ring-1 focus:ring-emerald-500 dark:border-neutral-700 dark:bg-neutral-900 dark:text-neutral-100"
                    >
                        <option>{{ __('All categories') }}</option>
                        <option>{{ __('Laptop / Desktop') }}</option>
                        <option>{{ __('Networking') }}</option>
                        <option>{{ __('Printer') }}</option>
                        <option>{{ __('CCTV / Security') }}</option>
                    </select>
                </div>
            </div>
        </div>

        {{-- Services table --}}
        <div class="relative flex-1 overflow-hidden rounded-xl border border-neutral-200 bg-white dark:border-neutral-700 dark:bg-neutral-900">
            <div class="overflow-x-auto">
                <table class="min-w-full border-separate border-spacing-0 text-left text-sm">
                    <thead>
                        <tr class="border-b border-neutral-100 bg-neutral-50 text-neutral-700 dark:border-neutral-800 dark:bg-neutral-900/60 dark:text-neutral-400">
                            <th class="px-4 py-3 font-medium text-left">{{ __('Service') }}</th>
                            <th class="px-4 py-3 font-medium text-left">{{ __('Category') }}</th>
                            <th class="px-4 py-3 font-medium text-right">{{ __('Pricing') }}</th>
                            <th class="px-4 py-3 font-medium text-left">{{ __('Estimated Time') }}</th>
                            <th class="px-4 py-3 font-medium text-center">{{ __('Status') }}</th>
                            <th class="px-4 py-3 font-medium text-center w-40">{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- Example static row – replace later with @foreach($services as $service) --}}
                        <tr class="border-b border-neutral-100 text-neutral-700 dark:border-neutral-800 dark:text-neutral-100">
                            <td class="px-4 py-3 align-middle">
                                <div class="flex flex-col">
                                    <span class="text-xs font-medium">
                                        {{ __('Laptop Full Diagnostics & Cleaning') }}
                                    </span>
                                    <span class="text-xs text-neutral-500 dark:text-neutral-400">
                                        {{ __('Includes dust cleaning, thermal paste, and basic tune-up.') }}
                                    </span>
                                </div>
                            </td>
                            <td class="px-4 py-3 align-middle">
                                {{ __('Laptop / Desktop') }}
                            </td>
                            <td class="px-4 py-3 align-middle text-right">
                                <span class="text-xs">
                                    {{ __('Flat rate') }}
                                </span>
                                <span class="ml-1 text-xs font-semibold">
                                    ₱ 1,500.00
                                </span>
                            </td>
                            <td class="px-4 py-3 align-middle">
                                {{ __('1.5 – 2 hours') }}
                            </td>
                            <td class="px-4 py-3 align-middle text-center">
                                <span class="inline-flex items-center rounded-full bg-emerald-100 px-2 py-0.5 text-xs font-medium text-emerald-800 dark:bg-emerald-900/40 dark:text-emerald-200">
                                    {{ __('Active') }}
                                </span>
                            </td>
                            <td class="px-4 py-3 align-middle text-center">
                                <div class="inline-flex items-center justify-center gap-2">
                                    <a href="#" class="inline-flex w-8 h-8 items-center justify-center text-emerald-600 hover:text-emerald-700" title="Use"><i class="fas fa-file-invoice"></i><span class="sr-only">Use in quotation</span></a>
                                    <a href="#" class="inline-flex w-8 h-8 items-center justify-center text-amber-600 hover:text-amber-700" title="Edit"><i class="fas fa-pen-to-square"></i><span class="sr-only">Edit</span></a>
                                    <a href="#" class="inline-flex w-8 h-8 items-center justify-center text-slate-600 hover:text-slate-700" title="Hide"><i class="fas fa-eye-slash"></i><span class="sr-only">Hide</span></a>
                                </div>
                            </td>
                        </tr>

                        {{-- Empty state --}}
                        {{-- 
                        @forelse ($services as $service)
                            ...
                        @empty
                        --}}
                        <tr>
                            <td colspan="6" class="px-4 py-10 text-center text-xs text-neutral-500 dark:text-neutral-400">
                                {{ __('No services configured yet. Add your first service to start building quotations faster.') }}
                            </td>
                        </tr>
                        {{-- @endforelse --}}
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</x-layouts.app>
