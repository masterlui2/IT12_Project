<x-layouts.app :title="__('Technicians')">
    <div class="flex h-full w-full flex-1 flex-col gap-6 rounded-xl">

        {{-- Header + summary --}}
        <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
            <div>
                <h1 class="text-xl font-semibold tracking-tight text-neutral-900 dark:text-neutral-50">
                    {{ __('Technicians') }}
                </h1>
                <p class="text-sm text-neutral-500 dark:text-neutral-400">
                    Assign jobs and keep track of each technician’s workload.
                </p>
            </div>

            <div class="flex flex-wrap items-center gap-2">
                {{-- Summary pills --}}
                <span class="inline-flex items-center gap-2 rounded-full bg-emerald-50 px-3 py-1 text-xs font-medium text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-300">
                    <x-flux::icon name="user-circle" class="h-4 w-4" />
                    {{ $technicians->count() }} {{ __('technicians') }}
                </span>

                <span class="inline-flex items-center gap-2 rounded-full bg-blue-50 px-3 py-1 text-xs font-medium text-blue-700 dark:bg-blue-900/30 dark:text-blue-300">
                    <x-flux::icon name="briefcase" class="h-4 w-4" />
                    {{ $technicians->sum('job_orders_count') }} {{ __('active job orders') }}
                </span>

                {{-- Add Technician button / modal --}}
<div class="flex flex-wrap items-center gap-2">
    {{-- Job Order History modal button (orange) --}}
       @include('manager.partials._job-order-history-modal', ['jobOrderHistory' => $jobOrderHistory])

    {{-- Add Technician modal button --}}
    @include('manager.partials._add-technician-form')
</div>
            </div>
        </div>

        {{-- Flash message --}}
        @if(session('status'))
            <div class="rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800 dark:border-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-100">
                {{ session('status') }}
            </div>
        @endif

        {{-- Legend / helper --}}
        <div class="rounded-xl border border-neutral-200 bg-white px-4 py-3 text-xs text-neutral-600 dark:border-neutral-700 dark:bg-neutral-900 dark:text-neutral-300">
            <div class="flex flex-col gap-2 md:flex-row md:items-center md:justify-between">
                <div class="flex flex-wrap items-center gap-2">
                    <span class="text-neutral-500 dark:text-neutral-400">
                        {{ __('Status:') }}
                    </span>
                    <span class="rounded-full bg-neutral-900 px-3 py-1 text-[11px] font-medium text-white">
                        {{ __('Available') }}
                    </span>
                    
                    <span class="rounded-full bg-yellow-100 px-3 py-1 text-[11px] font-medium text-yellow-700 dark:bg-yellow-900/40 dark:text-yellow-200">
                        {{ __('In progress') }}
                    </span>
                    <span class="rounded-full bg-green-100 px-3 py-1 text-[11px] font-medium text-green-700 dark:bg-green-900/40 dark:text-green-200">
                        {{ __('Completed') }}
                    </span>
                </div>

                <p class="text-[11px] text-neutral-500 dark:text-neutral-400">
                    {{ __('Use “Add Technician” to create profiles, then assign job orders from the table.') }}
                </p>
            </div>
        </div>

        {{-- Technicians table --}}
        <div class="relative flex-1 overflow-hidden rounded-xl border border-neutral-200 bg-white dark:border-neutral-700 dark:bg-neutral-900">
            <div class="overflow-x-auto">
                <table class="min-w-full border-separate border-spacing-0 text-left text-sm">
                    <thead>
                        <tr class="border-b border-neutral-100 bg-neutral-50 text-[11px] uppercase tracking-wide text-neutral-700 dark:border-neutral-800 dark:bg-neutral-900/60 dark:text-neutral-400">
                            <th class="px-4 py-3 font-medium">{{ __('Technician') }}</th>
                            <th class="px-4 py-3 font-medium">{{ __('Contact') }}</th>
                            <th class="px-4 py-3 font-medium">{{ __('Current Job') }}</th>
                            <th class="px-4 py-3 text-center font-medium">{{ __('Status') }}</th>
                            <th class="px-4 py-3 text-center font-medium w-40">{{ __('Actions') }}</th>
                        </tr>
                    </thead>

                  <tbody>
@forelse ($technicians as $tech)
    @php
        $latestJob = $tech->jobOrders->first(); // now guaranteed latest because of take(1)
        $status = $latestJob?->status ?? 'available';

        $badgeClasses = match ($status) {
            'in_progress'          => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/40 dark:text-yellow-200',
            'completed'            => 'bg-green-100 text-green-700 dark:bg-green-900/40 dark:text-green-200',
            'scheduled', 'on-site' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/40 dark:text-blue-200',
            'review'               => 'bg-neutral-900 text-white',
            'cancelled'            => 'bg-rose-100 text-rose-700 dark:bg-rose-900/40 dark:text-rose-200',
            default                => 'bg-neutral-900 text-white',
        };

        $firstInitial = substr($tech->user?->firstname ?? 'T', 0, 1);
        $lastInitial  = substr($tech->user?->lastname ?? '', 0, 1);
        $initials     = strtoupper($firstInitial . $lastInitial);

        $modalId = 'reviewModal_'.$tech->id.'_'.($latestJob?->id ?? 'none'); // ✅ unique
    @endphp

    <tr class="border-b border-neutral-100 text-xs text-neutral-700 dark:border-neutral-800 dark:text-neutral-100">
        {{-- Technician --}}
        <td class="px-4 py-3 align-top">
            <div class="flex items-center gap-2">
                <div class="flex h-8 w-8 items-center justify-center rounded-full bg-emerald-100 text-[11px] font-semibold text-emerald-800 dark:bg-emerald-900/40 dark:text-emerald-200">
                    {{ $initials }}
                </div>
                <div class="flex flex-col">
                    <span class="text-xs font-medium">
                        {{ trim(($tech->user?->firstname ?? '').' '.($tech->user?->lastname ?? '')) ?: __('Technician') }}
                    </span>
                    <span class="text-[11px] text-neutral-500 dark:text-neutral-400">
                        {{ $tech->certifications ?? __('General technician') }}
                    </span>
                </div>
            </div>
        </td>

        {{-- Contact --}}
        <td class="px-4 py-3 align-top">
            <div class="flex flex-col gap-0.5">
                <span class="text-xs">{{ $tech->user?->phone ?? '—' }}</span>
                <span class="text-[11px] text-neutral-500 dark:text-neutral-400">{{ $tech->user?->email ?? '—' }}</span>
            </div>
        </td>

        {{-- Current Job --}}
        <td class="px-4 py-3 align-top">
            @if($latestJob)
                <p class="text-xs font-medium">
                    JO-{{ str_pad($latestJob->id, 5, '0', STR_PAD_LEFT) }}
                </p>
                <p class="text-[11px] text-neutral-500 dark:text-neutral-400 line-clamp-2">
                    {{ $latestJob->quotation?->inquiry?->issue_description ?? 'No description' }}
                </p>
            @else
                <span class="text-[11px] text-neutral-400 dark:text-neutral-500">
                    {{ __('No current assignment') }}
                </span>
            @endif
        </td>

        {{-- Status --}}
        <td class="px-4 py-3 text-center align-top">
            <span class="inline-flex items-center rounded-full px-2 py-0.5 text-[11px] font-medium {{ $badgeClasses }}">
                {{ $latestJob ? ucfirst(str_replace('_', ' ', $status)) : __('Available') }}
            </span>
        </td>

        {{-- Actions (ONLY ONCE ✅) --}}
        <td class="px-4 py-3 text-center align-top">
            <div class="inline-flex items-center justify-center gap-2">

                {{-- Review button + modal --}}
                @if($latestJob)
                    <div x-data="{ open:false }" class="relative">
                        <button type="button"
                            @click="open=true"
                            class="inline-flex items-center rounded-full px-3 py-1 text-[11px] font-semibold bg-neutral-900 text-white hover:bg-neutral-800">
                            Review
                        </button>

                        <div x-show="open" x-cloak @keydown.escape.window="open=false"
                            class="fixed inset-0 z-50 flex items-center justify-center p-4"
                            id="{{ $modalId }}"
                            role="dialog"
                            aria-modal="true">
                            <div class="absolute inset-0 bg-black/50" @click="open=false"></div>

                            <div class="relative w-full max-w-3xl overflow-hidden rounded-xl bg-white shadow-lg dark:bg-neutral-900" @click.stop>
                                <div class="flex items-start justify-between gap-4 border-b border-neutral-200 px-5 py-4 dark:border-neutral-800">
                                    <div>
                                        <h2 class="text-sm font-semibold text-neutral-900 dark:text-neutral-50">
                                            Job Review — JO-{{ str_pad($latestJob->id, 5, '0', STR_PAD_LEFT) }}
                                        </h2>
                                        <p class="text-[11px] text-neutral-500 dark:text-neutral-400">
                                            Update notes or status.
                                        </p>
                                    </div>

                                    <button type="button" @click="open=false"
                                        class="rounded-lg p-2 text-neutral-500 hover:bg-neutral-100 dark:hover:bg-neutral-800">
                                        ✕
                                    </button>
                                </div>

                                <div class="px-5 py-4 space-y-4">
                                    <div class="rounded-xl border border-neutral-200 p-4 dark:border-neutral-800">
                                        <p class="text-[11px] text-neutral-500 dark:text-neutral-400">Client</p>
                                        <p class="text-sm font-semibold text-neutral-900 dark:text-neutral-50">
                                            {{
                                                $latestJob->quotation?->customer
                                                ? trim($latestJob->quotation->customer->firstname.' '.$latestJob->quotation->customer->lastname)
                                                : ($latestJob->quotation?->client_name ?? '—')
                                            }}
                                        </p>
                                    </div>

                                    <form method="POST" action="{{ route('manager.job.update', $latestJob->id) }}" class="space-y-3">
                                        @csrf
                                        @method('PATCH')

                                        <div>
                                            <label class="block text-[11px] font-medium text-neutral-600 dark:text-neutral-300 mb-1">
                                                Technician Notes
                                            </label>
                                            <textarea name="technician_notes" rows="3"
                                                class="w-full rounded-xl border border-neutral-200 bg-white px-3 py-2 text-sm text-neutral-800
                                                focus:outline-none focus:ring-2 focus:ring-orange-400 dark:border-neutral-700 dark:bg-neutral-950 dark:text-neutral-100">{{ old('technician_notes', $latestJob->technician_notes) }}</textarea>
                                        </div>

                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                            <div>
                                                <label class="block text-[11px] font-medium text-neutral-600 dark:text-neutral-300 mb-1">
                                                    Status
                                                </label>
                                                <select name="status"
                                                    class="w-full rounded-xl border border-neutral-200 bg-white px-3 py-2 text-sm text-neutral-800
                                                    focus:outline-none focus:ring-2 focus:ring-orange-400 dark:border-neutral-700 dark:bg-neutral-950 dark:text-neutral-100">
                                                    @foreach(['scheduled','in_progress','review','completed','cancelled'] as $s)
                                                        <option value="{{ $s }}" @selected(($latestJob->status ?? 'scheduled') === $s)>
                                                            {{ ucfirst(str_replace('_',' ', $s)) }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="flex items-end gap-2">
                                                <button type="submit"
                                                    class="w-full rounded-xl bg-orange-500 px-4 py-2 text-xs font-semibold text-white hover:bg-orange-400">
                                                    Save changes
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                                <div class="flex items-center justify-between gap-3 border-t border-neutral-200 px-5 py-4 dark:border-neutral-800">
                                    <button type="button" @click="open=false"
                                        class="rounded-xl border border-neutral-200 px-4 py-2 text-xs font-semibold text-neutral-700 hover:bg-neutral-50">
                                        Close
                                    </button>

                                    @if(($latestJob->status ?? '') !== 'completed')
                                        <form method="POST" action="{{ route('manager.job.markComplete', $latestJob->id) }}">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit"
                                                class="rounded-xl bg-emerald-600 px-4 py-2 text-xs font-semibold text-white hover:bg-emerald-500">
                                                Mark Completed
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Assign Job Order --}}
                @include('manager.partials._assign-job-order-modal', [
                    'tech' => $tech,
                    'approvedQuotations' => $approvedQuotations
                ])

                {{-- More actions --}}
                <div x-data="{ open:false }" class="relative">
                    <button type="button" @click="open=!open" @keydown.escape.window="open=false"
                        class="inline-flex h-8 w-8 items-center justify-center rounded-lg text-neutral-600 hover:bg-neutral-100 dark:text-neutral-300 dark:hover:bg-neutral-800">
                        <i class="fas fa-ellipsis-v text-sm"></i>
                    </button>

                    <div x-show="open" x-cloak @click.away="open=false"
                        class="absolute right-0 mt-2 w-44 overflow-hidden rounded-xl border border-neutral-200 bg-white shadow-lg dark:border-neutral-700 dark:bg-neutral-900 z-50">
                        <a href="{{ route('manager.technicians.edit', $tech->id) }}"
                            class="flex items-center gap-2 px-3 py-2 text-xs text-neutral-700 hover:bg-neutral-50 dark:text-neutral-200 dark:hover:bg-neutral-800">
                            <i class="fas fa-edit text-xs text-blue-600"></i>
                            <span>Edit technician</span>
                        </a>

                        <form action="{{ route('manager.technicians.destroy', $tech->id) }}" method="POST"
                            onsubmit="return confirm('Delete this technician? This cannot be undone.');">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="w-full text-left flex items-center gap-2 px-3 py-2 text-xs text-red-600 hover:bg-red-50 dark:hover:bg-neutral-800">
                                <i class="fas fa-trash text-xs"></i>
                                <span>Delete technician</span>
                            </button>
                        </form>
                    </div>
                </div>

                {{-- workload --}}
                <span class="text-[11px] text-neutral-400 dark:text-neutral-500">
                    {{ trans_choice(':count job|:count jobs', $tech->job_orders_count, ['count' => $tech->job_orders_count]) }}
                </span>
            </div>
        </td>
    </tr>
@empty
    <tr>
        <td colspan="5" class="px-4 py-10 text-center text-xs text-neutral-500 dark:text-neutral-400">
            {{ __('No technicians recorded yet. Use “Add Technician” to create one.') }}
        </td>
    </tr>
@endforelse
</tbody>

                </table>
            </div>
        </div>

    </div>
</x-layouts.app>

<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
<style>[x-cloak]{display:none!important;}</style>
