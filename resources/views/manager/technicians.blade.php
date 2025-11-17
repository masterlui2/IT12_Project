<x-layouts.app :title="__('Technicians')">
    <div class="flex h-full w-full flex-1 flex-col gap-6 rounded-xl">

        {{-- Header + primary actions --}}
        <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
            <div>
                <h1 class="text-xl font-semibold tracking-tight text-neutral-900 dark:text-neutral-50">
                    {{ __('Technicians') }}
                </h1>
                <p class="text-sm text-neutral-500 dark:text-neutral-400">
                    Manage technician profiles, skills, and their current assignments.
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
                    {{ __('Add Technician') }}
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
                    {{ __('Available') }}
                </button>
                <button class="rounded-full bg-neutral-100 px-3 py-1 text-xs font-medium text-neutral-700 hover:bg-neutral-200 dark:bg-neutral-800 dark:text-neutral-100 dark:hover:bg-neutral-700">
                    {{ __('Assigned') }}
                </button>
                <button class="rounded-full bg-neutral-100 px-3 py-1 text-xs font-medium text-neutral-700 hover:bg-neutral-200 dark:bg-neutral-800 dark:text-neutral-100 dark:hover:bg-neutral-700">
                    {{ __('On-site') }}
                </button>
                <button class="rounded-full bg-neutral-100 px-3 py-1 text-xs font-medium text-neutral-700 hover:bg-neutral-200 dark:bg-neutral-800 dark:text-neutral-100 dark:hover:bg-neutral-700">
                    {{ __('On leave') }}
                </button>
            </div>

            <div class="flex w-full flex-col gap-2 md:w-auto md:flex-row md:items-center">
                <div class="relative flex-1 text-xs">
                    <span class="pointer-events-none absolute inset-y-0 left-2 flex items-center text-neutral-400">
                        <x-flux::icon name="magnifying-glass" class="h-4 w-4" />
                    </span>
                    <input
                        type="text"
                        placeholder="{{ __('Search by name, skill, contact…') }}"
                        class="w-full rounded-lg border border-neutral-200 bg-neutral-50 py-2 pl-8 pr-3 text-xs text-neutral-800 placeholder:text-neutral-400 focus:border-emerald-500 focus:outline-none focus:ring-1 focus:ring-emerald-500 dark:border-neutral-700 dark:bg-neutral-900 dark:text-neutral-100"
                    >
                </div>

                <div class="flex items-center gap-2 text-xs">
                    <span class="text-neutral-500 dark:text-neutral-400">{{ __('Specialization:') }}</span>
                    <select
                        class="rounded-lg border border-neutral-200 bg-neutral-50 px-2 py-2 text-xs text-neutral-800 focus:border-emerald-500 focus:outline-none focus:ring-1 focus:ring-emerald-500 dark:border-neutral-700 dark:bg-neutral-900 dark:text-neutral-100"
                    >
                        <option>{{ __('All') }}</option>
                        <option>{{ __('Laptop / Desktop') }}</option>
                        <option>{{ __('Networking') }}</option>
                        <option>{{ __('Printer') }}</option>
                        <option>{{ __('CCTV / Security') }}</option>
                    </select>
                </div>
            </div>
        </div>

        {{-- Technicians table --}}
        <div class="relative flex-1 overflow-hidden rounded-xl border border-neutral-200 bg-white dark:border-neutral-700 dark:bg-neutral-900">
            <div class="overflow-x-auto">
                <table class="min-w-full border-separate border-spacing-0 text-left text-xs">
                    <thead>
                        <tr class="border-b border-neutral-100 bg-neutral-50 text-neutral-500 dark:border-neutral-800 dark:bg-neutral-900/60 dark:text-neutral-400">
                            <th class="px-4 py-3 font-medium">{{ __('Technician') }}</th>
                            <th class="px-4 py-3 font-medium">{{ __('Contact') }}</th>
                            <th class="px-4 py-3 font-medium">{{ __('Specialization') }}</th>
                            <th class="px-4 py-3 font-medium">{{ __('Current Assignment') }}</th>
                            <th class="px-4 py-3 font-medium">{{ __('Status') }}</th>
                            <th class="px-4 py-3 font-medium text-right">{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- Example static row – replace later with @foreach($technicians as $tech) --}}
                        <tr class="border-b border-neutral-100 text-neutral-700 dark:border-neutral-800 dark:text-neutral-100">
                            <td class="px-4 py-3 align-middle">
                                <div class="flex items-center gap-2">
                                    <div class="flex h-7 w-7 items-center justify-center rounded-full bg-emerald-100 text-[11px] font-semibold text-emerald-800 dark:bg-emerald-900/40 dark:text-emerald-200">
                                        JD
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="text-xs font-medium">John Doe</span>
                                        <span class="text-[11px] text-neutral-500 dark:text-neutral-400">
                                            {{ __('Senior Technician') }}
                                        </span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3 align-middle">
                                <div class="flex flex-col">
                                    <span class="text-[11px]">0917 987 6543</span>
                                    <span class="text-[11px] text-neutral-500">john.doe@example.com</span>
                                </div>
                            </td>
                            <td class="px-4 py-3 align-middle">
                                {{ __('Laptop / Desktop') }}
                            </td>
                            <td class="px-4 py-3 align-middle">
                                {{ __('Job #JOB-2025-010 · On-site – Makati') }}
                            </td>
                            <td class="px-4 py-3 align-middle">
                                <span class="inline-flex items-center rounded-full bg-blue-100 px-2 py-0.5 text-[11px] font-medium text-blue-800 dark:bg-blue-900/40 dark:text-blue-200">
                                    {{ __('On-site') }}
                                </span>
                            </td>
                            <td class="px-4 py-3 align-middle text-right">
                                <button class="text-xs font-medium text-emerald-600 hover:underline">
                                    {{ __('View schedule') }}
                                </button>
                                <span class="mx-1 text-neutral-400">•</span>
                                <button class="text-xs font-medium text-neutral-500 hover:underline">
                                    {{ __('Assign job') }}
                                </button>
                                <span class="mx-1 text-neutral-400">•</span>
                                <button class="text-xs font-medium text-neutral-500 hover:underline">
                                    {{ __('Edit') }}
                                </button>
                            </td>
                        </tr>

                        {{-- Empty state --}}
                        {{-- 
                        @forelse ($technicians as $tech)
                            ...
                        @empty
                        --}}
                        <tr>
                            <td colspan="6" class="px-4 py-10 text-center text-xs text-neutral-500 dark:text-neutral-400">
                                {{ __('No technicians recorded yet. Add your first technician to start assigning jobs.') }}
                            </td>
                        </tr>
                        {{-- @endforelse --}}
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</x-layouts.app>
