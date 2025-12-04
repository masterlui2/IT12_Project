<x-layouts.app :title="__('Inquiries')">
    <div class="flex h-full w-full flex-1 flex-col gap-6 rounded-xl">

        {{-- Header --}}
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

        {{-- Stat cards - now dynamic --}}
        <div class="grid gap-4 md:grid-cols-4">
            @foreach ($stats['inquiries'] as $key => $count)
                @php
                    $colors = [
                        'unassigned' => 'amber',
                        'assigned' => 'blue',
                        'ongoing' => 'violet',
                        'completed' => 'emerald',
                        'cancelled' => 'rose',
                        'scheduled' => 'neutral',
                        'converted' => 'green',
                    ];

                    $color = $colors[$key] ?? 'neutral';
                    $label = ucfirst($key);
                    $subtitle = [
                        'unassigned' => 'Need technician assignment',
                        'assigned' => 'Under assessment',
                        'ongoing' => 'Technician working',
                        'completed' => 'Work finished',
                        'cancelled' => 'Inquiry closed',
                        'scheduled' => 'For onsite visit',
                        'converted' => 'Turned into quotations',
                    ][$key] ?? '';
                @endphp

                <div class="rounded-xl border border-neutral-200 bg-white p-4 dark:border-neutral-700 dark:bg-neutral-900">
                    <p class="text-xs font-medium text-neutral-500 dark:text-neutral-400">{{ __($label) }}</p>
                    <p class="mt-2 text-2xl font-semibold tracking-tight text-{{ $color }}-500">
                        {{ $count }}
                    </p>
                    <p class="mt-1 text-xs text-neutral-500 dark:text-neutral-400">{{ __($subtitle) }}</p>
                </div>
            @endforeach
        </div>

        {{-- Quick Filters --}}
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
                    Unassigned ({{ $stats['inquiries']['unassigned'] ?? 0 }})
                </button>
                <button class="inline-flex items-center rounded-lg bg-neutral-100 px-3 py-1.5 text-xs font-medium text-neutral-700 hover:bg-neutral-200 dark:bg-neutral-800 dark:text-neutral-200">
                    All Inquiries
                </button>
            </div>
        </div>

        {{-- 48-hour warning --}}
        @if ($unanswered > 0)
            <div class="rounded-lg bg-amber-100 border border-amber-300 text-amber-800 p-3 text-sm">
                ⚠️ {{ $unanswered }} inquiries have been unattended for more than 48 hours — consider assigning a technician.
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
                            {{-- ... your inquiry rows --}}
                        @empty
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
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-layouts.app>
