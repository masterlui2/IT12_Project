<x-layouts.app :title="__('Inquiries')">
    <div class="flex h-full w-full flex-1 flex-col gap-6 rounded-xl">

        {{-- Header + Filters --}}
        <div class="flex flex-col gap-4 md:flex-row md:items-start md:justify-between">
            <div>
                <h1 class="text-xl font-semibold tracking-tight text-neutral-900 dark:text-neutral-50">
                    {{ __('Inquiries Management') }}
                </h1>
                <p class="text-sm text-neutral-500 dark:text-neutral-400">
                    Review customer inquiries and assign technicians for assessment.
                </p>
            </div>

            {{-- Filters --}}
            <form method="GET" action="{{ route('inquiries') }}" class="flex w-full flex-col gap-2 md:w-auto md:flex-row md:items-center">
                {{-- Search --}}
                <div class="relative w-full md:w-72">
                    <span class="pointer-events-none absolute inset-y-0 left-2 flex items-center text-neutral-400">
                        <x-flux::icon name="magnifying-glass" class="h-4 w-4" />
                    </span>
                    <input
                        name="search"
                        value="{{ $filters['search'] ?? '' }}"
                        type="text"
                        placeholder="Search customer, email, INQ-#, or description..."
                        class="w-full rounded-lg border border-neutral-200 bg-white py-2 pl-8 pr-3 text-xs text-neutral-800 placeholder:text-neutral-400 focus:border-neutral-300 focus:outline-none focus:ring-1 focus:ring-neutral-300 dark:border-neutral-700 dark:bg-neutral-900 dark:text-neutral-100"
                    >
                </div>

                {{-- Status --}}
                <select
                    name="status"
                    class="w-full rounded-lg border border-neutral-200 bg-white px-3 py-2 text-xs text-neutral-700 focus:border-neutral-300 focus:outline-none focus:ring-1 focus:ring-neutral-300 dark:border-neutral-700 dark:bg-neutral-900 dark:text-neutral-100 md:w-44"
                >
                    <option value="">All Statuses</option>
                    @foreach (['Pending', 'Acknowledged', 'In Progress', 'Scheduled', 'Completed', 'Cancelled', 'Converted'] as $status)
                        <option value="{{ $status }}" @selected(($filters['status'] ?? '') === $status)>{{ $status }}</option>
                    @endforeach
                </select>

                {{-- Technician --}}
                <select
                    name="technician"
                    class="w-full rounded-lg border border-neutral-200 bg-white px-3 py-2 text-xs text-neutral-700 focus:border-neutral-300 focus:outline-none focus:ring-1 focus:ring-neutral-300 dark:border-neutral-700 dark:bg-neutral-900 dark:text-neutral-100 md:w-48"
                >
                    <option value="">All Technicians</option>
                    @foreach ($technicians as $technician)
                        <option value="{{ $technician->id }}" @selected(($filters['technician'] ?? '') == $technician->id)>
                            {{ $technician->user?->firstname }} {{ $technician->user?->lastname }}
                        </option>
                    @endforeach
                </select>

                <button
                    type="submit"
                    class="inline-flex items-center justify-center rounded-lg border border-neutral-200 bg-white px-3 py-2 text-xs font-medium text-neutral-700 shadow-sm hover:bg-neutral-50 dark:border-neutral-700 dark:bg-neutral-900 dark:text-neutral-100 dark:hover:bg-neutral-800"
                >
                    <x-flux::icon name="funnel" class="mr-2 h-4 w-4" />
                    {{ __('Filter') }}
                </button>
            </form>
        </div>

        {{-- Flash message --}}
        @if(session('status'))
            <div class="rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800 dark:border-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-100">
                {{ session('status') }}
            </div>
        @endif

        {{-- Stat cards --}}
        <div class="grid gap-4 md:grid-cols-4">
            @foreach ($stats['inquiries'] as $key => $count)
                @php
                    $colors = [
                        'unassigned' => 'amber',
                        'pending'    => 'indigo',
                        'assigned'   => 'blue',
                        'ongoing'    => 'violet',
                        'completed'  => 'emerald',
                        'cancelled'  => 'rose',
                        'scheduled'  => 'neutral',
                        'converted'  => 'green',
                    ];
                    $color = $colors[$key] ?? 'neutral';

                    $label = ucfirst($key);
                    $subtitle = [
                        'unassigned' => 'Need technician assignment',
                        'pending'    => 'Awaiting review',
                        'assigned'   => 'Under assessment',
                        'ongoing'    => 'Technician working',
                        'completed'  => 'Work finished',
                        'cancelled'  => 'Inquiry closed',
                        'scheduled'  => 'For onsite visit',
                        'converted'  => 'Turned into quotations',
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

        {{-- 48-hour warning --}}
        @if ($unanswered > 0)
            <div class="rounded-lg border border-amber-200 bg-amber-50 px-4 py-3 text-sm text-amber-800 dark:border-amber-700 dark:bg-amber-900/30 dark:text-amber-100">
                ⚠️ {{ $unanswered }} inquiries have been unattended for more than 48 hours — consider assigning a technician.
            </div>
        @endif

        {{-- Table --}}
        <div class="relative flex-1 overflow-hidden rounded-xl border border-neutral-200 bg-white dark:border-neutral-700 dark:bg-neutral-900">
            <div class="overflow-x-auto">
                <table class="min-w-full border-separate border-spacing-0 text-left text-sm">
                    <thead>
                        <tr class="border-b border-neutral-100 bg-neutral-50 text-[11px] uppercase tracking-wide text-neutral-700 dark:border-neutral-800 dark:bg-neutral-900/60 dark:text-neutral-400">
                            <th class="px-4 py-3 text-center font-medium">{{ __('Inquiry #') }}</th>
                            <th class="px-4 py-3 font-medium">{{ __('Customer') }}</th>
                            <th class="px-4 py-3 font-medium">{{ __('Issue') }}</th>
                            <th class="px-4 py-3 text-center font-medium">{{ __('Technician') }}</th>
                            <th class="px-4 py-3 text-center font-medium">{{ __('Status') }}</th>
                            <th class="px-4 py-3 text-center font-medium">{{ __('Created') }}</th>
                            <th class="px-4 py-3 text-center font-medium w-56">{{ __('Actions') }}</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($inquiries as $inquiry)
                            <tr class="border-b border-neutral-100 last:border-0 hover:bg-neutral-50/60 dark:border-neutral-800 dark:hover:bg-neutral-800/30">
                                {{-- Inquiry ID --}}
                                <td class="px-4 py-4 text-center font-semibold text-neutral-800 dark:text-neutral-100">
                                    INQ-{{ str_pad($inquiry->id, 5, '0', STR_PAD_LEFT) }}
                                </td>

                                {{-- Customer --}}
                                <td class="px-4 py-4">
                                    @php
                                        $customerName = trim(($inquiry->customer?->firstname ?? '') . ' ' . ($inquiry->customer?->lastname ?? ''));
                                    @endphp
                                    <div class="text-xs font-semibold text-neutral-900 dark:text-neutral-100">
                                        {{ $inquiry->name ?? ($customerName ?: 'Customer') }}
                                    </div>
                                    <div class="text-[11px] text-neutral-500 dark:text-neutral-400">{{ $inquiry->email }}</div>
                                    <div class="text-[11px] text-neutral-500 dark:text-neutral-400">{{ $inquiry->contact_number }}</div>
                                </td>

                                {{-- Issue --}}
                                <td class="px-4 py-4 max-w-md">
                                    <div class="text-[10px] font-medium uppercase tracking-wide text-neutral-500 dark:text-neutral-400">
                                        {{ $inquiry->category }}
                                    </div>
                                    <p class="mt-1 text-xs leading-snug text-neutral-800 dark:text-neutral-200 line-clamp-2">
                                        {{ $inquiry->issue_description }}
                                    </p>
                                </td>

                                {{-- Assigned Technician --}}
                                <td class="px-4 py-4 text-center">
                                    @if ($inquiry->technician)
                                        <span class="inline-flex items-center gap-2 rounded-full bg-blue-50 px-3 py-1 text-xs font-medium text-blue-700 dark:bg-blue-900/40 dark:text-blue-200">
                                            <x-flux::icon name="user" class="h-4 w-4" />
                                            {{ $inquiry->technician->user?->firstname }} {{ $inquiry->technician->user?->lastname }}
                                        </span>
                                    @else
                                        <span class="text-xs text-neutral-500 dark:text-neutral-400">Unassigned</span>
                                    @endif
                                </td>

                                {{-- Status --}}
                                <td class="px-4 py-4 text-center">
                                    @php
                                        $statusColors = [
                                            'Pending'      => 'bg-amber-100 text-amber-800 ring-1 ring-amber-200',
                                            'Acknowledged' => 'bg-blue-100 text-blue-800 ring-1 ring-blue-200',
                                            'In Progress'  => 'bg-violet-100 text-violet-800 ring-1 ring-violet-200',
                                            'Scheduled'    => 'bg-neutral-100 text-neutral-800 ring-1 ring-neutral-200',
                                            'Completed'    => 'bg-emerald-100 text-emerald-800 ring-1 ring-emerald-200',
                                            'Cancelled'    => 'bg-rose-100 text-rose-800 ring-1 ring-rose-200',
                                            'Converted'    => 'bg-green-100 text-green-800 ring-1 ring-green-200',
                                        ];
                                        $badge = $statusColors[$inquiry->status] ?? 'bg-neutral-100 text-neutral-700 ring-1 ring-neutral-200';
                                    @endphp
                                    <span class="inline-flex rounded-full px-3 py-1 text-xs font-medium {{ $badge }}">
                                        {{ $inquiry->status ?? 'Pending' }}
                                    </span>
                                </td>

                                {{-- Created --}}
                                <td class="px-4 py-4 text-center">
                                    <div class="text-xs text-neutral-800 dark:text-neutral-200">
                                        {{ $inquiry->created_at?->format('M d, Y') }}
                                    </div>
                                    <div class="text-[11px] text-neutral-500 dark:text-neutral-400">
                                        {{ $inquiry->created_at?->format('h:i A') }}
                                    </div>
                                </td>

                                {{-- Actions --}}
                                <td class="px-4 py-4">
                                    <div class="flex items-center justify-center gap-2">
                                        <form action="{{ route('manager.inquiries.assign', $inquiry->id) }}" method="POST" class="flex items-center gap-2">
                                            @csrf
                                            <select
                                                name="technician_id"
                                                class="w-36 rounded-lg border border-neutral-200 bg-white px-2 py-1 text-xs text-neutral-700 focus:border-neutral-300 focus:outline-none focus:ring-1 focus:ring-neutral-300 dark:border-neutral-700 dark:bg-neutral-900 dark:text-neutral-100"
                                            >
                                                <option value="">Assign…</option>
                                                @foreach ($technicians as $technician)
                                                    <option value="{{ $technician->id }}" @selected($technician->id == $inquiry->assigned_technician_id)>
                                                        {{ $technician->user?->firstname }} {{ $technician->user?->lastname }}
                                                    </option>
                                                @endforeach
                                            </select>

                                            <button
                                                type="submit"
                                                class="inline-flex items-center rounded-lg bg-neutral-900 px-3 py-1.5 text-xs font-medium text-white shadow-sm hover:bg-neutral-800 dark:bg-neutral-700 dark:hover:bg-neutral-600"
                                            >
                                                {{ __('Assign') }}
                                            </button>
                                        </form>

                                      
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-4 py-10 text-center text-xs text-neutral-500 dark:text-neutral-400">
                                    <div class="flex flex-col items-center gap-2">
                                        <x-flux::icon name="inbox" class="h-8 w-8 text-neutral-400" />
                                        <div>
                                            <div class="font-medium text-neutral-700 dark:text-neutral-300">No inquiries to manage</div>
                                            <div class="mt-1">All current inquiries have been assigned and processed.</div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($inquiries->hasPages())
                <div class="flex justify-end border-t border-neutral-100 bg-neutral-50 px-4 py-3 dark:border-neutral-800 dark:bg-neutral-900/60">
                    {{ $inquiries->links() }}
                </div>
            @endif
        </div>
    </div>
</x-layouts.app>
