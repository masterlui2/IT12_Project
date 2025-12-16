@props([
    'tech',
    'approvedQuotations' => collect(),
])

<div x-data="{ open: false }" class="inline-flex">

    {{-- ACTION BUTTON --}}
    <button
        type="button"
        @click.stop="open = true"
        class="inline-flex h-8 w-8 items-center justify-center rounded-lg text-indigo-600 hover:bg-indigo-50 hover:text-indigo-700 dark:hover:bg-neutral-800"
        title="{{ __('Assign Job Order') }}"
    >
        <i class="fas fa-user-check"></i>
        <span class="sr-only">{{ __('Assign Job Order') }}</span>
    </button>

    {{-- MODAL --}}
    <div
        x-show="open"
        x-cloak
        @keydown.escape.window="open = false"
        class="fixed inset-0 z-50 flex items-center justify-center p-4"
        role="dialog"
        aria-modal="true"
    >
        {{-- Backdrop --}}
        <div class="absolute inset-0 bg-black/50" @click="open = false"></div>

        {{-- Panel --}}
        <div
            class="relative w-full max-w-4xl rounded-xl bg-white p-6 shadow-lg dark:bg-neutral-900"
            @click.stop
        >
            {{-- Header --}}
            <div class="mb-4 flex items-start justify-between gap-4">
                <div>
                    <h2 class="text-base font-semibold text-neutral-900 dark:text-neutral-50">
                        {{ __('Assign Job Order') }}
                    </h2>
                    <p class="text-xs text-neutral-500 dark:text-neutral-400">
                        {{ __('Assign a job order to') }}
                        <span class="font-medium">
                            {{ $tech->name ?? $tech->user?->firstname ?? __('Technician') }}
                        </span>
                    </p>
                </div>

                <button
                    type="button"
                    class="rounded-lg p-2 text-neutral-500 hover:bg-neutral-100 dark:hover:bg-neutral-800"
                    @click="open = false"
                    aria-label="Close"
                >
                    ✕
                </button>
            </div>

           <form action="{{ route('manager.job-orders.store') }}" method="POST">
    @csrf
    <input type="hidden" name="technician_id" value="{{ $tech->id }}">

    <div class="grid grid-cols-1 gap-4 text-sm">
      {{-- Start Date --}}
        <div>
            <label class="mb-1 block text-neutral-500">Start Date</label>
            <input
                type="date"
                name="start_date"
                value="{{ now()->toDateString() }}"
                class="w-full rounded-lg border border-neutral-200 bg-neutral-50 px-3 py-2 focus:border-emerald-500 focus:ring-1 dark:border-neutral-700 dark:bg-neutral-900"
            />
        </div>
        {{-- Select Quotation --}}
        <div>
            <label class="mb-1 block text-neutral-500">Approved Quotation</label>
            <select
                name="quotation_id"
                required
                class="w-full rounded-lg border border-neutral-200 bg-neutral-50 px-3 py-2 focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 dark:border-neutral-700 dark:bg-neutral-900"
            >
                <option value="">Select approved quotation</option>
                @forelse($approvedQuotations as $quotation)
                    <option value="{{ $quotation->id }}">
                        {{ $quotation->project_title ?? ('Quotation #' . $quotation->id) }}
                    </option>
                @empty
                    <option value="" disabled>No approved quotations available</option>
                @endforelse
            </select>
        </div>

        {{-- Expected Date --}}
        <div>
            <label class="mb-1 block text-neutral-500">Target Completion Date</label>
            <input
                type="date"
                name="expected_finish_date"
                class="w-full rounded-lg border border-neutral-200 bg-neutral-50 px-3 py-2 focus:border-emerald-500 focus:ring-1 dark:border-neutral-700 dark:bg-neutral-900"
            />
        </div>

        {{-- Manager Notes --}}
        <div>
            <label class="mb-1 block text-neutral-500">Instructions / Notes (Optional)</label>
            <textarea
                name="technician_notes"
                rows="3"
                class="w-full rounded-lg border border-neutral-200 bg-neutral-50 px-3 py-2 focus:border-emerald-500 focus:ring-1 dark:border-neutral-700 dark:bg-neutral-900"
                placeholder="Any instructions for the technician..."
            ></textarea>
        </div>

    </div>

    {{-- Footer --}}
    <div class="mt-5 flex justify-end gap-2">
        <button
            type="button"
            @click="open = false"
            class="rounded-lg border border-neutral-200 px-4 py-2 text-xs font-semibold text-neutral-700 hover:bg-neutral-50 dark:border-neutral-700 dark:text-neutral-200 dark:hover:bg-neutral-800"
        >
            Cancel
        </button>

        <button
            type="submit"
            class="rounded-lg bg-neutral-900 px-4 py-2 text-xs font-semibold text-white shadow-sm hover:bg-neutral-800"
        >
            Assign Job Order
        </button>
    </div>
</form>

        </div>
    </div>
</div>
