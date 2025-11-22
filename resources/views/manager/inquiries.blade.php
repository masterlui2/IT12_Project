<x-layouts.app :title="__('Inquiries')">
    <div class="flex h-full w-full flex-1 flex-col gap-6 rounded-xl">

        {{-- Header + primary actions --}}
        <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
            <div>
                <h1 class="text-xl font-semibold tracking-tight text-neutral-900 dark:text-neutral-50">
                    {{ __('Inquiries Management') }}
                </h1>
                <p class="text-sm text-neutral-500 dark:text-neutral-400">
                    Review customer inquiries and assign technicians for assessment.
                </p>
            </div>

            <div class="flex flex-wrap items-center gap-2">
                <div class="relative flex-1 text-xs md:w-64">
                    <span class="pointer-events-none absolute inset-y-0 left-2 flex items-center text-neutral-400">
                        <x-flux::icon name="magnifying-glass" class="h-4 w-4" />
                    </span>
                    <input
                        type="text"
                        placeholder="Search inquiries..."
                        class="w-full rounded-lg border border-neutral-200 bg-white py-2 pl-8 pr-3 text-xs text-neutral-800 placeholder:text-neutral-400 focus:border-neutral-300 focus:outline-none focus:ring-1 focus:ring-neutral-300 dark:border-neutral-700 dark:bg-neutral-900 dark:text-neutral-100"
                    >
                </div>

                <button
                    type="button"
                    class="inline-flex items-center rounded-lg border border-neutral-200 bg-white px-3 py-2 text-xs font-medium text-neutral-700 shadow-sm hover:bg-neutral-50 dark:border-neutral-700 dark:bg-neutral-900 dark:text-neutral-100 dark:hover:bg-neutral-800"
                >
                    <x-flux::icon name="funnel" class="mr-2 h-4 w-4" />
                    {{ __('Filter') }}
                </button>
            </div>
        </div>

        {{-- Manager-focused Stat cards --}}
        <div class="grid gap-4 md:grid-cols-4">
            <div class="rounded-xl border border-neutral-200 bg-white p-4 dark:border-neutral-700 dark:bg-neutral-900">
                <p class="text-xs font-medium text-neutral-500 dark:text-neutral-400">{{ __('Unassigned') }}</p>
                <p class="mt-2 text-2xl font-semibold tracking-tight text-amber-500">
                    {{ $stats['inquiries']['unassigned'] ?? 0 }}
                </p>
                <p class="mt-1 text-xs text-neutral-500 dark:text-neutral-400">
                    {{ __('Need technician assignment') }}
                </p>
            </div>

            <div class="rounded-xl border border-neutral-200 bg-white p-4 dark:border-neutral-700 dark:bg-neutral-900">
                <p class="text-xs font-medium text-neutral-500 dark:text-neutral-400">{{ __('Assigned') }}</p>
                <p class="mt-2 text-2xl font-semibold tracking-tight text-blue-500">
                    {{ $stats['inquiries']['assigned'] ?? 0 }}
                </p>
                <p class="mt-1 text-xs text-neutral-500 dark:text-neutral-400">
                    {{ __('Under assessment') }}
                </p>
            </div>

            <div class="rounded-xl border border-neutral-200 bg-white p-4 dark:border-neutral-700 dark:bg-neutral-900">
                <p class="text-xs font-medium text-neutral-500 dark:text-neutral-400">{{ __('Scheduled') }}</p>
                <p class="mt-2 text-2xl font-semibold tracking-tight text-neutral-900 dark:text-neutral-50">
                    {{ $stats['inquiries']['scheduled'] ?? 0 }}
                </p>
                <p class="mt-1 text-xs text-neutral-500 dark:text-neutral-400">
                    {{ __('For onsite visit') }}
                </p>
            </div>

            <div class="rounded-xl border border-neutral-200 bg-white p-4 dark:border-neutral-700 dark:bg-neutral-900">
                <p class="text-xs font-medium text-neutral-500 dark:text-neutral-400">{{ __('Converted') }}</p>
                <p class="mt-2 text-2xl font-semibold tracking-tight text-emerald-500">
                    {{ $stats['inquiries']['converted'] ?? 0 }}
                </p>
                <p class="mt-1 text-xs text-neutral-500 dark:text-neutral-400">
                    {{ __('Turned into quotations') }}
                </p>
            </div>
        </div>

        {{-- Quick Actions --}}
        <div class="rounded-xl border border-neutral-200 bg-white p-4 dark:border-neutral-700 dark:bg-neutral-900">
            <div class="flex items-center justify-between">
                <h3 class="text-sm font-medium text-neutral-700 dark:text-neutral-300">Quick Filters</h3>
                <span class="text-xs text-neutral-500">Priority</span>
            </div>
            <div class="mt-3 flex flex-wrap gap-2">
                <button class="inline-flex items-center rounded-lg bg-amber-100 px-3 py-1.5 text-xs font-medium text-amber-800 hover:bg-amber-200 dark:bg-amber-900/40 dark:text-amber-200">
                    High Priority (3)
                </button>
                <button class="inline-flex items-center rounded-lg bg-blue-100 px-3 py-1.5 text-xs font-medium text-blue-800 hover:bg-blue-200 dark:bg-blue-900/40 dark:text-blue-200">
                    Unassigned (8)
                </button>
                <button class="inline-flex items-center rounded-lg bg-neutral-100 px-3 py-1.5 text-xs font-medium text-neutral-700 hover:bg-neutral-200 dark:bg-neutral-800 dark:text-neutral-200">
                    All Inquiries
                </button>
            </div>
        </div>

        {{-- Inquiries table with minimalist actions --}}
        <div class="relative flex-1 overflow-hidden rounded-xl border border-neutral-200 bg-white dark:border-neutral-700 dark:bg-neutral-900">
            <div class="overflow-x-auto">
                <table class="min-w-full border-separate border-spacing-0 text-left text-sm">
                    <thead>
                        <tr class="border-b border-neutral-100 bg-neutral-50 text-neutral-700 dark:border-neutral-800 dark:bg-neutral-900/60 dark:text-neutral-400">
                            <th class="px-4 py-3 font-medium text-center">{{ __('Inquiry #') }}</th>
                            <th class="px-4 py-3 font-medium text-left">{{ __('Customer & Device') }}</th>
                            <th class="px-4 py-3 font-medium text-center">{{ __('Issue Description') }}</th>
                            <th class="px-4 py-3 font-medium text-left">{{ __('Assigned To') }}</th>
                            <th class="px-4 py-3 font-medium text-left">{{ __('Priority') }}</th>
                            <th class="px-4 py-3 font-medium text-center">{{ __('Created') }}</th>
                            <th class="px-4 py-3 font-medium text-center w-40">{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- Unassigned Inquiry --}}
                        <tr class="border-b border-neutral-100 text-neutral-700 dark:border-neutral-800 dark:text-neutral-100">
                            <td class="px-4 py-3 align-middle">
                                <div class="flex items-center gap-2">
                                    <span class="font-medium">INQ-2025-0012</span>
                                    <i class="fas fa-circle-exclamation text-red-500"></i>
                                </div>
                            </td>
                            <td class="px-4 py-3 align-middle">
                                <div class="font-medium">Maria Santos</div>
                                <div class="text-xs text-neutral-500">Desktop Computer</div>
                            </td>
                            <td class="px-4 py-3 align-middle text-center">
                                <div>No display output, powers on but no signal</div>
                                <div class="mt-1 text-xs text-neutral-500">0917 123 4567</div>
                            </td>
                            <td class="px-4 py-3 align-middle">
                            <span class="inline-flex items-center rounded-full bg-amber-100 px-2 py-0.5 text-xs font-medium text-amber-800 dark:bg-amber-900/40 dark:text-amber-200">
                                    Unassigned
                                </span>
                            </td>
                            <td class="px-4 py-3 align-middle">
                            <span class="inline-flex items-center rounded-full bg-red-100 px-2 py-0.5 text-xs font-medium text-red-800 dark:bg-red-900/40 dark:text-red-200">
                                    High
                                </span>
                            </td>
                            <td class="px-4 py-3 align-middle text-right">
                                <div>2 hours ago</div>
                            </td>
                            <td class="px-4 py-3 align-middle text-center">
                                <div class="inline-flex items-center justify-center gap-2">
                                    <a href="#" class="inline-flex w-8 h-8 items-center justify-center text-blue-600 hover:text-blue-800" title="View"><i class="fas fa-eye"></i><span class="sr-only">View</span></a>
                                    <a href="#" class="inline-flex w-8 h-8 items-center justify-center text-indigo-600 hover:text-indigo-700" title="Assign"><i class="fas fa-user-check"></i><span class="sr-only">Assign</span></a>
                                </div>
                            </td>
                        </tr>

                        {{-- Assigned Inquiry --}}
                        <tr class="border-b border-neutral-100 text-neutral-700 dark:border-neutral-800 dark:text-neutral-100">
                            <td class="px-4 py-3 align-middle font-medium">INQ-2025-0011</td>
                            <td class="px-4 py-3 align-middle">
                                <div class="font-medium">John Lim</div>
                                <div class="text-xs text-neutral-500">MacBook Pro 16"</div>
                            </td>
                            <td class="px-4 py-3 align-middle text-center">
                                <div>Liquid damage, keyboard not working</div>
                                <div class="mt-1 text-xs text-neutral-500">0918 765 4321</div>
                            </td>
                            <td class="px-4 py-3 align-middle">
                                <div class="font-medium">Tech Rodriguez</div>
                                <div class="text-xs text-neutral-500">Today</div>
                            </td>
                            <td class="px-4 py-3 align-middle">
                            <span class="inline-flex items-center rounded-full bg-amber-100 px-2 py-0.5 text-xs font-medium text-amber-800 dark:bg-amber-900/40 dark:text-amber-200">
                                    Medium
                                </span>
                            </td>
                            <td class="px-4 py-3 align-middle text-right">
                                <div>1 day ago</div>
                            </td>
                            <td class="px-4 py-3 align-middle text-center">
                                <div class="inline-flex items-center justify-center gap-2">
                                    <a href="#" class="inline-flex w-8 h-8 items-center justify-center text-blue-600 hover:text-blue-800" title="View"><i class="fas fa-eye"></i><span class="sr-only">View</span></a>
                                    <a href="#" class="inline-flex w-8 h-8 items-center justify-center text-indigo-600 hover:text-indigo-700" title="Assign"><i class="fas fa-user-check"></i><span class="sr-only">Assign</span></a>
                                </div>
                            </td>
                        </tr>

                        {{-- Scheduled Inquiry --}}
                        <tr class="border-b border-neutral-100 text-neutral-700 dark:border-neutral-800 dark:text-neutral-100">
                            <td class="px-4 py-3 align-middle font-medium">INQ-2025-0010</td>
                            <td class="px-4 py-3 align-middle">
                                <div class="font-medium">Robert Chen</div>
                                <div class="text-xs text-neutral-500">iPhone 15 Pro</div>
                            </td>
                            <td class="px-4 py-3 align-middle text-center">
                                <div>Cracked screen, touch functionality affected</div>
                                <div class="mt-1 text-xs text-neutral-500">0919 555 8888</div>
                            </td>
                            <td class="px-4 py-3 align-middle">
                                <div class="font-medium">Tech Garcia</div>
                                <div class="text-xs text-neutral-500">Nov 18</div>
                            </td>
                            <td class="px-4 py-3 align-middle">
                                <span class="inline-flex items-center rounded-full bg-blue-100 px-2 py-0.5 text-xs font-medium text-blue-800 dark:bg-blue-900/40 dark:text-blue-200">
                                    Low
                                </span>
                            </td>
                            <td class="px-4 py-3 align-middle text-right">
                                <div>2 days ago</div>
                            </td>
                            <td class="px-4 py-3 align-middle text-center">
                                <div class="inline-flex items-center justify-center gap-2">
                                    <a href="#" class="inline-flex w-8 h-8 items-center justify-center text-blue-600 hover:text-blue-800" title="View"><i class="fas fa-eye"></i><span class="sr-only">View</span></a>
                                    <a href="#" class="inline-flex w-8 h-8 items-center justify-center text-indigo-600 hover:text-indigo-700" title="Assign"><i class="fas fa-user-check"></i><span class="sr-only">Assign</span></a>
                                </div>
                            </td>
                        </tr>

                        {{-- Empty state --}}
                        {{-- 
                        @forelse ($inquiries as $inquiry)
                            ...
                        @empty
                        --}}
                        <tr>
                            <td colspan="7" class="px-4 py-10 text-center text-xs text-neutral-500 dark:text-neutral-400">
                                <div class="flex flex-col items-center gap-2">
                                    <x-flux::icon name="inbox" class="h-8 w-8 text-neutral-400" />
                                    <div>
                                        <div class="font-medium text-neutral-700 dark:text-neutral-300">No inquiries to manage</div>
                                        <div class="mt-1">All current inquiries have been assigned and processed</div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        {{-- @endforelse --}}
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</x-layouts.app>