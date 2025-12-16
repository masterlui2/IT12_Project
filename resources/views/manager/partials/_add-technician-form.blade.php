<div x-data="{ open:false }" class="relative">

    {{-- Button --}}
    <button
        type="button"
        @click="open = true"
        class="inline-flex items-center gap-2 rounded-lg bg-neutral-900 px-3 py-2 text-xs font-semibold text-white shadow-sm hover:bg-neutral-800 dark:bg-white dark:text-neutral-900 dark:hover:bg-neutral-200"
    >
        <i class="fas fa-plus text-[11px]"></i>
        Add Technician
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
            class="relative w-full max-w-2xl overflow-hidden rounded-2xl bg-white shadow-lg dark:bg-neutral-900"
            @click.stop
        >
            {{-- Header --}}
            <div class="flex items-start justify-between gap-4 border-b border-neutral-200 px-5 py-4 dark:border-neutral-800">
                <div>
                    <h2 class="text-sm font-semibold text-neutral-900 dark:text-neutral-50">
                        Add Technician
                    </h2>
                    <p class="text-[11px] text-neutral-500 dark:text-neutral-400">
                        Create a technician account and basic profile details.
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

            {{-- Form --}}
            <form action="{{ route('manager.technicians.store') }}" method="POST" class="px-5 py-4">
                @csrf

                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">

                    {{-- Firstname --}}
                    <div>
                        <label class="mb-1 block text-[11px] text-neutral-500 dark:text-neutral-400">
                            First name
                        </label>
                        <input
                            name="firstname"
                            value="{{ old('firstname') }}"
                            required
                            class="w-full rounded-lg border border-neutral-200 bg-neutral-50 px-3 py-2 text-sm text-neutral-900 placeholder:text-neutral-400 focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 dark:border-neutral-700 dark:bg-neutral-950 dark:text-neutral-50"
                            placeholder="Juan"
                        />
                        @error('firstname')
                            <p class="mt-1 text-[11px] text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Lastname --}}
                    <div>
                        <label class="mb-1 block text-[11px] text-neutral-500 dark:text-neutral-400">
                            Last name
                        </label>
                        <input
                            name="lastname"
                            value="{{ old('lastname') }}"
                            required
                            class="w-full rounded-lg border border-neutral-200 bg-neutral-50 px-3 py-2 text-sm text-neutral-900 placeholder:text-neutral-400 focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 dark:border-neutral-700 dark:bg-neutral-950 dark:text-neutral-50"
                            placeholder="Dela Cruz"
                        />
                        @error('lastname')
                            <p class="mt-1 text-[11px] text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Email --}}
                    <div class="md:col-span-2">
                        <label class="mb-1 block text-[11px] text-neutral-500 dark:text-neutral-400">
                            Email
                        </label>
                        <input
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            required
                            class="w-full rounded-lg border border-neutral-200 bg-neutral-50 px-3 py-2 text-sm text-neutral-900 placeholder:text-neutral-400 focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 dark:border-neutral-700 dark:bg-neutral-950 dark:text-neutral-50"
                            placeholder="tech@example.com"
                        />
                        @error('email')
                            <p class="mt-1 text-[11px] text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Birthday --}}
                    <div>
                        <label class="mb-1 block text-[11px] text-neutral-500 dark:text-neutral-400">
                            Birthday
                        </label>
                        <input
                            type="date"
                            name="birthday"
                            value="{{ old('birthday') }}"
                            required
                            class="w-full rounded-lg border border-neutral-200 bg-neutral-50 px-3 py-2 text-sm text-neutral-900 focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 dark:border-neutral-700 dark:bg-neutral-950 dark:text-neutral-50"
                        />
                        @error('birthday')
                            <p class="mt-1 text-[11px] text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Password (optional) --}}
                    <div>
                        <label class="mb-1 block text-[11px] text-neutral-500 dark:text-neutral-400">
                            Password <span class="text-neutral-400">(optional)</span>
                        </label>
                        <input
                            type="password"
                            name="password"
                            class="w-full rounded-lg border border-neutral-200 bg-neutral-50 px-3 py-2 text-sm text-neutral-900 placeholder:text-neutral-400 focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 dark:border-neutral-700 dark:bg-neutral-950 dark:text-neutral-50"
                            placeholder="Leave blank to auto-generate"
                        />
                        @error('password')
                            <p class="mt-1 text-[11px] text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Specialization --}}
                    <div class="md:col-span-1">
                    <label class="mb-1 block text-[11px] text-neutral-500 dark:text-neutral-400">
                            Specialization
                        </label>
                        <input
                            name="specialization"
                            value="{{ old('specialization') }}"
                            class="w-full rounded-lg border border-neutral-200 bg-neutral-50 px-3 py-2 text-sm text-neutral-900 placeholder:text-neutral-400 focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 dark:border-neutral-700 dark:bg-neutral-950 dark:text-neutral-50"
                            placeholder="Networking, hardware, etc."
                        />
                        @error('specialization')
                            <p class="mt-1 text-[11px] text-red-500">{{ $message }}</p>
                        @enderror
                       
                    </div>

                    {{-- Certifications --}}
                    <div class="md:col-span-1">
                       <label class="mb-1 block text-[11px] text-neutral-500 dark:text-neutral-400">
                            Certifications
                        </label>
                        <input
                            name="certifications"
                            value="{{ old('certifications') }}"
                            class="w-full rounded-lg border border-neutral-200 bg-neutral-50 px-3 py-2 text-sm text-neutral-900 placeholder:text-neutral-400 focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 dark:border-neutral-700 dark:bg-neutral-950 dark:text-neutral-50"
                            placeholder="CompTIA A+, etc."
                        />
                        @error('certifications')
                            <p class="mt-1 text-[11px] text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                </div>

                {{-- Footer --}}
                <div class="mt-6 flex items-center justify-end gap-2 border-t border-neutral-200 pt-4 dark:border-neutral-800">
                    <button
                        type="button"
                        @click="open = false"
                        class="rounded-lg border border-neutral-200 px-4 py-2 text-xs font-semibold text-neutral-700 hover:bg-neutral-50 dark:border-neutral-700 dark:text-neutral-200 dark:hover:bg-neutral-800"
                    >
                        Cancel
                    </button>

                    <button
                        type="submit"
                        class="rounded-lg bg-emerald-600 px-4 py-2 text-xs font-semibold text-white hover:bg-emerald-500"
                    >
                        Save Technician
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
