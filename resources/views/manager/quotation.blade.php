<x-layouts.app :title="__('Quotation Review')">
    <div class="flex h-full w-full flex-1 flex-col gap-6 rounded-xl">

        {{-- Manager Header --}}
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
                <div class="relative flex-1 text-xs md:w-64">
                    <span class="pointer-events-none absolute inset-y-0 left-2 flex items-center text-neutral-400">
                        <x-flux::icon name="magnifying-glass" class="h-4 w-4" />
                    </span>
                    <input
                        type="text"
                        placeholder="Search quotations..."
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

        {{-- Clean Stats --}}
        <div class="grid gap-4 md:grid-cols-3">
            <div class="rounded-lg border border-neutral-200 bg-white p-4 dark:border-neutral-700 dark:bg-neutral-900">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-neutral-600 dark:text-neutral-400">Pending Review</p>
                        <p class="mt-1 text-2xl font-semibold text-neutral-900 dark:text-neutral-100">8</p>
                    </div>
                    <x-flux::icon name="clock" class="h-8 w-8 text-neutral-400" />
                </div>
                <p class="mt-2 text-xs text-neutral-500">Waiting for your approval</p>
            </div>

            <div class="rounded-lg border border-neutral-200 bg-white p-4 dark:border-neutral-700 dark:bg-neutral-900">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-neutral-600 dark:text-neutral-400">Approved This Week</p>
                        <p class="mt-1 text-2xl font-semibold text-neutral-900 dark:text-neutral-100">12</p>
                    </div>
                    <x-flux::icon name="check-circle" class="h-8 w-8 text-neutral-400" />
                </div>
                <p class="mt-2 text-xs text-neutral-500">Ready for processing</p>
            </div>

            <div class="rounded-lg border border-neutral-200 bg-white p-4 dark:border-neutral-700 dark:bg-neutral-900">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-neutral-600 dark:text-neutral-400">Pending Value</p>
                        <p class="mt-1 text-2xl font-semibold text-neutral-900 dark:text-neutral-100">₱45,200</p>
                    </div>
                    <x-flux::icon name="currency-dollar" class="h-8 w-8 text-neutral-400" />
                </div>
                <p class="mt-2 text-xs text-neutral-500">Total awaiting approval</p>
            </div>
        </div>

        {{-- Quick Filters --}}
        <div class="flex flex-wrap items-center gap-2">
            <span class="text-sm text-neutral-600 dark:text-neutral-400">Show:</span>
            <button class="rounded-lg border border-neutral-300 bg-white px-3 py-1.5 text-xs font-medium text-neutral-700 hover:bg-neutral-50 dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-200">
                All Quotations
            </button>
            <button class="rounded-lg bg-neutral-100 px-3 py-1.5 text-xs font-medium text-neutral-700 hover:bg-neutral-200 dark:bg-neutral-700 dark:text-neutral-200">
                Pending Review
            </button>
            <button class="rounded-lg bg-neutral-100 px-3 py-1.5 text-xs font-medium text-neutral-700 hover:bg-neutral-200 dark:bg-neutral-700 dark:text-neutral-200">
                High Priority
            </button>
            <button class="rounded-lg bg-neutral-100 px-3 py-1.5 text-xs font-medium text-neutral-700 hover:bg-neutral-200 dark:bg-neutral-700 dark:text-neutral-200">
                Overdue
            </button>
        </div>

        {{-- Quotations Table --}}
        <div class="flex-1 overflow-hidden rounded-lg border border-neutral-200 bg-white dark:border-neutral-700 dark:bg-neutral-900">
            <div class="overflow-x-auto">
                <table class="min-w-full border-separate border-spacing-0 text-left text-sm">
                    <thead>
                        <tr class="border-b border-neutral-200 bg-neutral-50 text-neutral-700 dark:border-neutral-700 dark:bg-neutral-800 dark:text-neutral-400">
                            <th class="px-6 py-4 font-medium text-left">Quote #</th>
                            <th class="px-6 py-4 font-medium text-left">Customer & Device</th>
                            <th class="px-6 py-4 font-medium text-left">Technician</th>
                            <th class="px-6 py-4 font-medium text-right">Amount</th>
                            <th class="px-6 py-4 font-medium text-right">Submitted</th>
                            <th class="px-6 py-4 font-medium text-center">Status</th>
                            <th class="px-6 py-4 font-medium text-center w-40">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="text-neutral-700 dark:text-neutral-300">
                        {{-- High Priority --}}
                        <tr class="border-b border-neutral-100 hover:bg-neutral-50 dark:border-neutral-800 dark:hover:bg-neutral-800/50">
                            <td class="px-6 py-4 align-middle">
                                <div class="flex items-center gap-2">
                                    <span class="font-medium">Q-2025-0042</span>
                                    <x-flux::icon name="exclamation-circle" class="h-4 w-4 text-red-500" />
                                </div>
                            </td>
                            <td class="px-6 py-4 align-middle">
                                <div class="font-medium">Maria Santos</div>
                                <div class="text-xs text-neutral-500">MacBook Pro 16" - Liquid damage</div>
                            </td>
                            <td class="px-6 py-4 align-middle text-neutral-600 dark:text-neutral-400">
                                Tech Rodriguez
                            </td>
                            <td class="px-6 py-4 align-middle font-medium text-right whitespace-nowrap">₱ 15,800.00</td>
                            <td class="px-6 py-4 align-middle text-right">
                                <div>2 hours ago</div>
                                <div class="text-xs text-neutral-500">Urgent</div>
                            </td>
                            <td class="px-6 py-4 align-middle text-center">
                                <span class="inline-flex items-center gap-1 rounded-full bg-red-100 px-2.5 py-1 text-xs font-medium text-red-800 dark:bg-red-900/40 dark:text-red-200">
                                    <i class="fas fa-circle-exclamation"></i>
                                    High Priority
                                </span>
                            </td>
                            <td class="px-6 py-4 align-middle text-center">
                                <div class="inline-flex items-center justify-center gap-2">
                                    <a href="#" class="inline-flex w-8 h-8 items-center justify-center text-blue-600 hover:text-blue-800" title="View"><i class="fas fa-eye"></i><span class="sr-only">View</span></a>
                                    <a href="#" class="inline-flex w-8 h-8 items-center justify-center text-amber-600 hover:text-amber-700" title="Update"><i class="fas fa-pen-to-square"></i><span class="sr-only">Update</span></a>
                                    <a href="#" class="inline-flex w-8 h-8 items-center justify-center text-emerald-600 hover:text-emerald-700" title="Approve"><i class="fas fa-check"></i><span class="sr-only">Approve</span></a>
                                </div>
                            </td>
                        </tr>

                        {{-- Standard Priority --}}
                        <tr class="border-b border-neutral-100 hover:bg-neutral-50 dark:border-neutral-800 dark:hover:bg-neutral-800/50">
                            <td class="px-6 py-4 align-middle font-medium">Q-2025-0041</td>
                            <td class="px-6 py-4 align-middle">
                                <div class="font-medium">John Lim</div>
                                <div class="text-xs text-neutral-500">Samsung Galaxy S24 - Screen replacement</div>
                            </td>
                            <td class="px-6 py-4 align-middle text-neutral-600 dark:text-neutral-400">
                                Tech Garcia
                            </td>
                            <td class="px-6 py-4 align-middle font-medium text-right whitespace-nowrap">₱ 4,200.00</td>
                            <td class="px-6 py-4 align-middle text-right">
                                <div>1 day ago</div>
                                <div class="text-xs text-neutral-500">Standard</div>
                            </td>
                            <td class="px-6 py-4 align-middle text-center">
                                <span class="inline-flex items-center gap-1 rounded-full bg-blue-100 px-2.5 py-1 text-xs font-medium text-blue-800 dark:bg-blue-900/40 dark:text-blue-200">
                                    <i class="fas fa-circle-check"></i>
                                    Pending Review
                                </span>
                            </td>
                            <td class="px-6 py-4 align-middle text-center">
                                <div class="inline-flex items-center justify-center gap-2">
                                    <a href="#" class="inline-flex w-8 h-8 items-center justify-center text-blue-600 hover:text-blue-800" title="View"><i class="fas fa-eye"></i><span class="sr-only">View</span></a>
                                    <a href="#" class="inline-flex w-8 h-8 items-center justify-center text-amber-600 hover:text-amber-700" title="Update"><i class="fas fa-pen-to-square"></i><span class="sr-only">Update</span></a>
                                    <a href="#" class="inline-flex w-8 h-8 items-center justify-center text-emerald-600 hover:text-emerald-700" title="Approve"><i class="fas fa-check"></i><span class="sr-only">Approve</span></a>
                                </div>
                            </td>
                        </tr>

                        {{-- Quote with Notes --}}
                        <tr class="border-b border-neutral-100 hover:bg-neutral-50 dark:border-neutral-800 dark:hover:bg-neutral-800/50">
                            <td class="px-6 py-4 align-middle">
                                <div class="flex items-center gap-2">
                                    <span class="font-medium">Q-2025-0040</span>
                                    <x-flux::icon name="chat-bubble-left" class="h-4 w-4 text-neutral-400" />
                                </div>
                            </td>
                            <td class="px-6 py-4 align-middle">
                                <div class="font-medium">Robert Chen</div>
                                <div class="text-xs text-neutral-500">Dell XPS 15 - Motherboard repair</div>
                            </td>
                            <td class="px-6 py-4 align-middle text-neutral-600 dark:text-neutral-400">
                                Tech Martinez
                            </td>
                            <td class="px-6 py-4 align-middle font-medium text-right whitespace-nowrap">₱ 8,500.00</td>
                            <td class="px-6 py-4 align-middle text-right">
                                <div>2 days ago</div>
                                <div class="text-xs text-amber-500">Needs review</div>
                            </td>
                            <td class="px-6 py-4 align-middle text-center">
                                <span class="inline-flex items-center gap-1 rounded-full bg-neutral-100 px-2.5 py-1 text-xs font-medium text-neutral-700 dark:bg-neutral-800/40 dark:text-neutral-300">
                                    <i class="fas fa-circle-check"></i>
                                    Waiting
                                </span>
                            </td>
                            <td class="px-6 py-4 align-middle text-center">
                                <div class="inline-flex items-center justify-center gap-2">
                                    <a href="#" class="inline-flex w-8 h-8 items-center justify-center text-blue-600 hover:text-blue-800" title="View"><i class="fas fa-eye"></i><span class="sr-only">View</span></a>
                                    <a href="#" class="inline-flex w-8 h-8 items-center justify-center text-amber-600 hover:text-amber-700" title="Update"><i class="fas fa-pen-to-square"></i><span class="sr-only">Update</span></a>
                                    <a href="#" class="inline-flex w-8 h-8 items-center justify-center text-emerald-600 hover:text-emerald-700" title="Approve"><i class="fas fa-check"></i><span class="sr-only">Approve</span></a>
                                </div>
                            </td>
                        </tr>

                        {{-- Empty State --}}
                        {{-- 
                        @forelse ($quotations as $quote)
                            ...
                        @empty
                        --}}
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center gap-3">
                                    <x-flux::icon name="document-magnifying-glass" class="h-12 w-12 text-neutral-400" />
                                    <div>
                                        <div class="font-medium text-neutral-700 dark:text-neutral-300">No quotations to review</div>
                                        <div class="mt-1 text-sm text-neutral-500">All pending quotations have been processed</div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        {{-- @endforelse --}}
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Recently Processed --}}
        <div class="rounded-lg border border-neutral-200 bg-white dark:border-neutral-700 dark:bg-neutral-900">
            <div class="border-b border-neutral-200 px-6 py-4 dark:border-neutral-700">
                <h3 class="text-sm font-medium text-neutral-700 dark:text-neutral-300">Recently Approved</h3>
            </div>
            <div class="p-6">
                <div class="space-y-4 text-sm">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-4">
                            <x-flux::icon name="check-circle" class="h-5 w-5 text-neutral-400" />
                            <div>
                                <span class="font-medium text-neutral-700 dark:text-neutral-300">Q-2025-0039</span>
                                <span class="ml-2 text-neutral-500">iPad Pro - Battery replacement</span>
                            </div>
                        </div>
                        <div class="flex items-center gap-4 text-neutral-500">
                            <span>Tech Rodriguez</span>
                            <span class="font-medium text-neutral-700 dark:text-neutral-300">₱ 3,800.00</span>
                            <span class="text-xs">2 hours ago</span>
                        </div>
                    </div>
                    
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-4">
                            <x-flux::icon name="check-circle" class="h-5 w-5 text-neutral-400" />
                            <div>
                                <span class="font-medium text-neutral-700 dark:text-neutral-300">Q-2025-0038</span>
                                <span class="ml-2 text-neutral-500">HP Laptop - RAM upgrade</span>
                            </div>
                        </div>
                        <div class="flex items-center gap-4 text-neutral-500">
                            <span>Tech Garcia</span>
                            <span class="font-medium text-neutral-700 dark:text-neutral-300">₱ 2,200.00</span>
                            <span class="text-xs">5 hours ago</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</x-layouts.app>