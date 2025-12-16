@extends('technician.layout.app')

@section('content')
<div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm space-y-6">

    {{-- Header --}}
    <div class="flex flex-col gap-4 border-b border-gray-200 pb-5 md:flex-row md:items-center md:justify-between">
        <div class="space-y-1">
            <h1 class="text-lg md:text-xl font-semibold text-gray-900">
                Techne Fixer Computer and Laptop Repair Services
            </h1>
            <div class="text-sm text-gray-600">
                <p>007 Manga Street, Toril Davao City</p>
                <p>Contact No: 09662406825 | TIN 618-863-736-000000</p>
            </div>
        </div>
        <img src="{{ asset('images/logo.png') }}" class="h-14 w-14 object-contain" alt="Company Logo">
    </div>

    {{-- Alerts --}}
    @if(session('success'))
        <div class="rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800">
            <div class="flex items-start gap-2">
                <i class="fas fa-check-circle mt-0.5"></i>
                <span>{{ session('success') }}</span>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800">
            <div class="flex items-start gap-2">
                <i class="fas fa-exclamation-circle mt-0.5"></i>
                <span>{{ session('error') }}</span>
            </div>
        </div>
    @endif

    {{-- Title + Filters --}}
    <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
        <div>
            <h2 class="text-lg font-semibold text-gray-900">Quotation Management</h2>
            <p class="text-sm text-gray-500">View and manage all quotations</p>
        </div>

        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-end">
            <form method="GET" action="{{ route('technician.quotation') }}" class="flex flex-wrap items-center gap-3">
                {{-- Search --}}
                <div class="relative">
                    <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                        <i class="fas fa-search text-sm"></i>
                    </span>
                    <input
                        type="text"
                        name="search"
                        placeholder="Search quotations..."
                        value="{{ request('search') }}"
                        class="w-56 rounded-lg border border-gray-300 bg-white py-2.5 pl-10 pr-3 text-sm
                               outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                    />
                </div>

                {{-- Status --}}
                <select
                    name="status"
                    onchange="this.form.submit()"
                    class="w-40 rounded-lg border border-gray-300 bg-white px-3 py-2.5 text-sm
                           outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                >
                    <option value="">All Status</option>
                    <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Approved</option>
                    <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rejected</option>
                </select>

                {{-- Sort --}}
                <select
                    name="sort"
                    onchange="this.form.submit()"
                    class="w-40 rounded-lg border border-gray-300 bg-white px-3 py-2.5 text-sm
                           outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                >
                    <option value="recent" {{ request('sort') === 'recent' ? 'selected' : '' }}>Recent First</option>
                    <option value="oldest" {{ request('sort') === 'oldest' ? 'selected' : '' }}>Oldest First</option>
                    <option value="amount_high" {{ request('sort') === 'amount_high' ? 'selected' : '' }}>Amount (High)</option>
                    <option value="amount_low" {{ request('sort') === 'amount_low' ? 'selected' : '' }}>Amount (Low)</option>
                </select>
            </form>

            <a href="{{ route('quotation.new') }}"
               class="inline-flex items-center justify-center gap-2 rounded-lg bg-blue-600 px-4 py-2.5
                      text-sm font-medium text-white transition hover:bg-blue-700 whitespace-nowrap"
            >
                <i class="fas fa-plus text-xs"></i>
                New Quotation
            </a>
        </div>
    </div>

    {{-- Stats --}}
    <div class="grid grid-cols-2 gap-4 md:grid-cols-4">
        <div class="rounded-xl border border-gray-200 bg-gray-50 p-4">
            <div class="text-2xl font-semibold text-gray-900">{{ $quotations->total() }}</div>
            <div class="text-sm text-gray-600">Total Quotations</div>
        </div>

        <div class="rounded-xl border border-gray-200 bg-gray-50 p-4">
            <div class="text-2xl font-semibold text-gray-900">
                ₱{{ number_format($quotations->sum('grand_total'), 0) }}
            </div>
            <div class="text-sm text-gray-600">Total Value</div>
        </div>

        <div class="rounded-xl border border-gray-200 bg-gray-50 p-4">
            <div class="text-2xl font-semibold text-blue-700">
                {{ $quotations->where('status', 'pending')->count() }}
            </div>
            <div class="text-sm text-gray-600">Pending</div>
        </div>

        <div class="rounded-xl border border-gray-200 bg-gray-50 p-4">
            <div class="text-2xl font-semibold text-green-700">
                {{ $quotations->where('status', 'approved')->count() }}
            </div>
            <div class="text-sm text-gray-600">Approved</div>
        </div>
    </div>
{{-- Table --}}
<div class="rounded-xl border border-gray-200 bg-white">
    <table class="w-full">
        <thead class="bg-gray-50">
            <tr class="border-b border-gray-200 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                <th class="px-6 py-4">Quote #</th>
                <th class="px-6 py-4">Client</th>
                <th class="px-6 py-4">Project</th>
                <th class="px-6 py-4 text-right">Amount</th>
                <th class="px-6 py-4">Status</th>
                <th class="px-6 py-4 text-right">Date</th>
                <th class="px-6 py-4 text-right w-32">Actions</th>
            </tr>
        </thead>

        <tbody class="divide-y divide-gray-100">
        @forelse($quotations as $quotation)
            @php
                $badge = match($quotation->status) {
                    'draft'    => 'bg-gray-100 text-gray-700 border-gray-200',
                    'pending'  => 'bg-blue-50 text-blue-700 border-blue-200',
                    'approved' => 'bg-green-50 text-green-700 border-green-200',
                    'rejected' => 'bg-red-50 text-red-700 border-red-200',
                    default    => 'bg-gray-100 text-gray-700 border-gray-200',
                };
            @endphp

            <tr class="hover:bg-gray-50 transition">
                <td class="px-6 py-4 text-sm font-semibold text-gray-900">
                    QTN-{{ str_pad($quotation->id, 5, '0', STR_PAD_LEFT) }}
                </td>

                <td class="px-6 py-4 text-sm font-medium text-gray-900">
                    {{ Str::limit($quotation->client_name, 28) }}
                </td>

                <td class="px-6 py-4 text-sm text-gray-900">
                    {{ Str::limit($quotation->project_title, 38) }}
                </td>

                <td class="px-6 py-4 text-right text-sm font-semibold text-gray-900">
                    ₱{{ number_format($quotation->grand_total, 2) }}
                </td>

                <td class="px-6 py-4">
                    <span class="inline-flex items-center rounded-full border px-2.5 py-1 text-xs font-semibold capitalize {{ $badge }}">
                        {{ $quotation->status }}
                    </span>
                </td>

                <td class="px-6 py-4 text-right text-sm text-gray-900">
                    {{ \Carbon\Carbon::parse($quotation->date_issued)->format('M d, Y') }}
                </td>

                <td class="px-6 py-4 text-right">
                    <div class="flex justify-end gap-2">
                        <a href="{{ route('quotation.show', $quotation->id) }}"
                           class="inline-flex items-center gap-1.5 rounded-lg border border-blue-200 bg-blue-50 px-3 py-1.5
                                  text-xs font-semibold text-blue-700 hover:bg-blue-100 transition">
                            <i class="fas fa-eye text-xs"></i>
                            View
                        </a>

                        {{-- Dropdown --}}
                        <div class="relative" data-dd>
                            <button type="button"
                                    class="flex h-8 w-8 items-center justify-center rounded-lg text-gray-500 hover:bg-gray-100 hover:text-gray-700"
                                    data-dd-btn>
                                <i class="fas fa-ellipsis-h"></i>
                            </button>

                            <div class="invisible absolute right-0 z-10 mt-2 w-44 rounded-lg border border-gray-200 bg-white shadow-lg
                                        opacity-0 scale-95 transition-all"
                                 data-dd-menu>
                                <a href="{{ route('quotation.pdf', $quotation->id) }}" target="_blank"
                                   class="flex items-center gap-2 px-4 py-2 text-sm hover:bg-gray-50">
                                    <i class="fas fa-file-pdf text-red-500"></i>
                                    Download PDF
                                </a>

                                @if($quotation->status === 'draft')
                                    <a href="{{ route('quotation.edit', $quotation->id) }}"
                                       class="flex items-center gap-2 px-4 py-2 text-sm hover:bg-gray-50">
                                        <i class="fas fa-pen text-green-600"></i>
                                        Edit
                                    </a>
                                @endif

                                <div class="border-t border-gray-100"></div>

                                <form action="{{ route('quotation.destroy', $quotation->id) }}"
                                      method="POST"
                                      onsubmit="return confirm('Delete quotation QTN-{{ $quotation->id }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="flex w-full items-center gap-2 px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                                        <i class="fas fa-trash"></i>
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="7" class="px-6 py-14 text-center text-sm text-gray-500">
                    No quotations found
                </td>
            </tr>
        @endforelse
        </tbody>
    </table>

    {{-- Pagination (optional) --}}
    @if(method_exists($quotations, 'links'))
        <div class="border-t border-gray-200 px-6 py-4">
            {{ $quotations->withQueryString()->links() }}
        </div>
    @endif
</div>

        </div>

        {{-- Footer / Pagination --}}
        @if($quotations->hasPages())
            <div class="flex flex-col gap-3 border-t border-gray-200 px-6 py-4 sm:flex-row sm:items-center sm:justify-between">
                <div class="text-sm text-gray-600">
                    Showing {{ $quotations->firstItem() ?? 0 }} to {{ $quotations->lastItem() ?? 0 }}
                    of {{ $quotations->total() }} quotations
                </div>

                {{-- Uses Laravel's built-in pagination view --}}
                <div>
                    {{ $quotations->withQueryString()->links() }}
                </div>
            </div>
        @endif
    </div>
</div>

{{-- Dropdown JS (single, reusable) --}}
<script>
    (function () {
        const closeAll = () => {
            document.querySelectorAll('[data-dd-menu]').forEach(m => {
                m.classList.add('invisible', 'opacity-0', 'scale-95');
            });
            document.querySelectorAll('[data-dd-btn]').forEach(b => b.setAttribute('aria-expanded', 'false'));
        };

        document.addEventListener('click', (e) => {
            const wrapper = e.target.closest('[data-dd]');
            if (!wrapper) return closeAll();

            const btn = e.target.closest('[data-dd-btn]');
            if (!btn) return;

            const menu = wrapper.querySelector('[data-dd-menu]');
            const isOpen = !menu.classList.contains('invisible');

            closeAll();

            if (!isOpen) {
                btn.setAttribute('aria-expanded', 'true');
                menu.classList.remove('invisible', 'opacity-0', 'scale-95');
                menu.classList.add('opacity-100', 'scale-100');
            }
        });

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') closeAll();
        });
    })();
</script>
@endsection
