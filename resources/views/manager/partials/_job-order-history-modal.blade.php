<div x-data="{ open:false }" class="relative">

    {{-- Orange History Button --}}
    <button
        type="button"
        @click="open = true"
        class="inline-flex items-center gap-2 rounded-lg bg-orange-500 px-3 py-2 text-xs font-semibold text-white shadow-sm hover:bg-orange-400 dark:bg-orange-600 dark:hover:bg-orange-500"
    >
        <i class="fas fa-clock text-xs"></i>
        History
    </button>

    {{-- Modal --}}
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
            class="relative w-full max-w-5xl overflow-hidden rounded-xl bg-white shadow-lg dark:bg-neutral-900"
            @click.stop
        >
            {{-- Header --}}
            <div class="flex items-start justify-between gap-4 border-b border-neutral-200 px-5 py-4 dark:border-neutral-800">
                <div>
                    <h2 class="text-sm font-semibold text-neutral-900 dark:text-neutral-50">
                        Job Order History
                    </h2>
                    <p class="text-[11px] text-neutral-500 dark:text-neutral-400">
                        Quick view of recent job orders. Open full history for complete list.
                    </p>
                </div>

                <button
                    type="button"
                    @click="open = false"
                    class="rounded-lg p-2 text-neutral-500 hover:bg-neutral-100 dark:hover:bg-neutral-800"
                    aria-label="Close"
                >
                    ✕
                </button>
            </div>

            {{-- Body (UI preview only) --}}
            <div class="px-5 py-4">
                <div class="overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-800">
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-left text-sm">
                            <thead>
                                <tr class="bg-neutral-50 text-[11px] uppercase tracking-wide text-neutral-600 dark:bg-neutral-900/60 dark:text-neutral-400">
                                    <th class="px-4 py-3">JO #</th>
                                    <th class="px-4 py-3">Technician</th>
                                    <th class="px-4 py-3">Customer</th>
                                    <th class="px-4 py-3">Issue</th>
                                    <th class="px-4 py-3">Status</th>
                                    <th class="px-4 py-3">Date</th>
                                </tr>
                            </thead>

                            <tbody>
                                {{-- Sample rows (replace later with real loop if you want) --}}
                                <tr class="border-t text-xs text-neutral-700 dark:border-neutral-800 dark:text-neutral-100">
                                    <td class="px-4 py-3 font-medium">JO-00012</td>
                                    <td class="px-4 py-3">Red Xavier</td>
                                    <td class="px-4 py-3">Luigi Ednilan</td>    
                                    <td class="px-4 py-3 text-neutral-500 dark:text-neutral-400">
                                        Network repair & configuration
                                    </td>
                                    <td class="px-4 py-3">
                                        <span class="inline-flex rounded-full bg-green-100 px-2 py-0.5 text-[11px] font-medium text-green-700 dark:bg-green-900/40 dark:text-green-200">
                                            Completed
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-neutral-500 dark:text-neutral-400">Dec 11, 2025</td>
                                </tr>

                                <tr>
                                    <td colspan="6" class="px-4 py-10 text-center text-xs text-neutral-400">
                                        (Preview) Hook your job orders here if you want.
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- Footer --}}
            <div class="flex items-center justify-between gap-3 border-t border-neutral-200 px-5 py-4 dark:border-neutral-800">
                <p class="text-[11px] text-neutral-500 dark:text-neutral-400">
                    Tip: Use full history to search and filter.
                </p>

                <div class="flex items-center gap-2">
                    <button
                        type="button"
                        @click="open = false"
                        class="rounded-lg border border-neutral-200 px-4 py-2 text-xs font-semibold text-neutral-700 hover:bg-neutral-50 dark:border-neutral-700 dark:text-neutral-200 dark:hover:bg-neutral-800"
                    >
                        Close
                    </button>

                    {{-- Uses your existing route --}}
                    <a
                        href="{{ route('technicians') }}"
                        class="rounded-lg bg-orange-500 px-4 py-2 text-xs font-semibold text-white hover:bg-orange-400 dark:bg-orange-600 dark:hover:bg-orange-500"
                    >
                        Open Full History
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
