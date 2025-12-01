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

        {{-- Notification for unanswered inquiries --}}
        @if ($unanswered > 0)
            <div class="rounded-lg bg-amber-100 border border-amber-300 text-amber-800 p-3 text-sm">
                ⚠️ {{ $unanswered }} inquiries have been unattended for more than 48 hours —
                consider assigning a technician.
            </div>
        @endif

        {{-- Table --}}
        <div class="relative flex-1 overflow-hidden rounded-xl border border-neutral-200 bg-white dark:border-neutral-700 dark:bg-neutral-900">
            <div class="overflow-x-auto">
                <table class="min-w-full border-separate border-spacing-0 text-left text-sm">
                    <thead>
                        <tr class="border-b border-neutral-100 bg-neutral-50 text-neutral-700 dark:border-neutral-800 dark:bg-neutral-900/60 dark:text-neutral-400">
                            <th class="px-4 py-3 font-medium text-center">{{ __('Inquiry #') }}</th>
                            <th class="px-4 py-3 font-medium text-center">{{ __('Customer') }}</th>
                            <th class="px-4 py-3 font-medium text-center">{{ __('Issue Description') }}</th>
                            <th class="px-4 py-3 font-medium text-center">{{ __('Assigned Technician') }}</th>
                            <th class="px-4 py-3 font-medium text-center">{{ __('Status') }}</th>
                            <th class="px-4 py-3 font-medium text-center">{{ __('Created') }}</th>
                            <th class="px-4 py-3 font-medium text-center w-40">{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($inquiries as $inquiry)
                            <tr class="border-b border-neutral-200 dark:border-neutral-800">
                                <td class="px-4 py-3 text-center align-middle">
                                    INQ-{{ str_pad($inquiry->id, 8, '0', STR_PAD_LEFT) }}
                                </td>
                                <td class="px-4 py-3 text-left align-middle">
                                    {{ $inquiry->name ?? $inquiry->customer->name }}
                                </td>
                                <td class="px-4 py-3 text-center align-middle">
                                    {{ $inquiry->issue_description }}
                                </td>

                                {{-- Technician column --}}
                                <td class="px-4 py-3 text-left align-middle">
                                    @if ($inquiry->assignedTechnician)
                                        <span class="font-medium">{{ $inquiry->assignedTechnician->firstname }}</span>
                                    @else
                                        <form action="{{ route('manager.inquiries.assign', $inquiry->id) }}" method="POST" class="flex items-center gap-2">
                                            @csrf
                                            <select name="technician_id" class="rounded-md border border-neutral-300 bg-white text-xs px-2 py-1 dark:bg-neutral-800 dark:border-neutral-600 dark:text-neutral-100">
                                                <option value="">Assign...</option>
                                                @foreach ($technicians as $tech)
                                                    <option value="{{ $tech->id }}">{{ $tech->firstname }}</option>
                                                @endforeach
                                            </select>
                                            <button type="submit" class="text-xs text-blue-600 hover:underline">Save</button>
                                        </form>
                                    @endif
                                </td>

                                {{-- ✅ Urgency --}}
                                <td class="px-4 py-3 text-center">
                                    <span class="
                                        @if ($inquiry->urgency === 'Urgent')
                                            bg-red-100 text-red-700 dark:bg-red-900/40 dark:text-red-300
                                        @elseif ($inquiry->urgency === 'Flexible')
                                            bg-blue-100 text-blue-700 dark:bg-blue-900/40 dark:text-blue-300
                                        @else
                                            bg-amber-100 text-amber-700 dark:bg-amber-900/40 dark:text-amber-300
                                        @endif
                                        px-2 py-1 rounded-md text-xs font-medium
                                    ">
                                        {{ $inquiry->urgency }}
                                    </span>
                                </td>

                                <td class="px-4 py-3 text-left align-middle">
                                    {{ ucfirst($inquiry->status) ?? 'New' }}
                                </td>
                                <td class="px-4 py-3 text-center align-middle">
                                    {{ $inquiry->created_at->format('M d, Y') }}
                                </td>
                                <td class="px-4 py-3 text-center align-middle">
                                    <a href="{{ route('inquiries.show', $inquiry) }}"
                                    class="text-sm text-emerald-600 hover:underline">View</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-4 py-10 text-center text-sm text-neutral-500 dark:text-neutral-400">
                                    No inquiries have been submitted yet.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>


    </div>
</x-layouts.app>
