@extends('technician.layout.app')

@section('content')

<div class="bg-white rounded-xl shadow-sm border p-8 space-y-8">

    <!-- Header Section -->
    <div class="flex justify-between items-center border-b pb-3">
        <div>
            <h1 class="text-xl font-bold text-gray-800">Techne Fixer Computer and Laptop Repair Services</h1>
            <p class="text-sm text-gray-500">007 Manga Street, Toril Davao City</p>
            <p class="text-sm text-gray-500">Contact No: 09662406825 TIN 618-863-736-000000</p>
        </div>
        <img src="{{ asset('images/logo.png') }}" class="w-20 h-20 object-contain" alt="Company Logo">
    </div>

    <!-- Messages -->
    @if (session('success'))
        <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg">
            {{ session('error') }}
        </div>
    @endif

    <!-- Job Order Section -->
    <div>
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-lg font-semibold text-gray-800">Job Order Management</h2>

            <div class="flex flex-wrap items-center gap-3">
                <form method="GET" action="{{ route('technician.job.index') }}" class="flex gap-3">
                    <input
                        type="text"
                        name="search"
                        placeholder="Search by client or JO ID"
                        value="{{ request('search') }}"
                        class="px-3 py-2 border rounded-md text-sm focus:ring-blue-500 focus:border-blue-500 w-52"
                    />

                    <select
                        name="status"
                        class="px-3 py-2 border rounded-md text-sm focus:ring-blue-500 focus:border-blue-500"
                    >
                        <option value="">All Status</option>
                        <option value="scheduled" @selected(request('status') === 'scheduled')>Scheduled</option>
                        <option value="in_progress" @selected(request('status') === 'in_progress')>In Progress</option>
                        <option value="completed" @selected(request('status') === 'completed')>Completed</option>
                        <option value="cancelled" @selected(request('status') === 'cancelled')>Cancelled</option>
                    </select>

                    <button
                        type="submit"
                        class="px-4 py-2 rounded-md bg-blue-600 text-white text-sm hover:bg-blue-500"
                    >
                        Filter
                    </button>
                </form>
            </div>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto border rounded-lg">
            <table class="w-full text-left text-sm">
                <thead class="bg-neutral-50 text-neutral-700">
                    <tr class="border-b border-neutral-200">
                        <th class="px-4 py-3 font-medium">Job #</th>
                        <th class="px-4 py-3 font-medium">Client</th>
                        <th class="px-4 py-3 font-medium">Project Title</th>
                        <th class="px-4 py-3 font-medium text-right">Start Date</th>
                        <th class="px-4 py-3 font-medium text-right">Target Completion</th>
                        <th class="px-4 py-3 font-medium">Status</th>
                        <th class="px-4 py-3 font-medium text-center w-40">Actions</th>
                    </tr>
                </thead>

                <tbody class="divide-y">
                    @forelse ($jobOrders as $job)
                        @php
                            // Relationships (safe)
                            $quotation = $job->quotation;
                            $customer  = $quotation?->customer;
                            $inquiry   = $quotation?->inquiry;

                            // Client name (safe)
                            $clientName = $customer
                                ? trim(($customer->firstname ?? '') . ' ' . ($customer->lastname ?? ''))
                                : null;

                            // Project title / device / issue fallback (safe)
                            $projectTitle =
                                $inquiry?->device_type
                                ?? $inquiry?->issue_description
                                ?? $quotation?->project_title
                                ?? 'N/A';

                            // Dates (safe)
                            $startDate = $job->start_date ?? $job->created_at;
                            $targetDate = $job->expected_finish_date;
                        @endphp

                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-4 py-3 font-medium text-neutral-900">
                                JO-{{ str_pad($job->id, 5, '0', STR_PAD_LEFT) }}
                            </td>

                            <td class="px-4 py-3">
                                {{ $clientName ?: '—' }}
                            </td>

                            <td class="px-4 py-3 text-neutral-800">
                                {{ $projectTitle }}
                            </td>

                            <td class="px-4 py-3 text-right text-neutral-700">
                                {{ optional($startDate)->format('M d, Y') ?? 'N/A' }}
                            </td>

                            <td class="px-4 py-3 text-right text-neutral-700">
                                {{ optional($targetDate)->format('M d, Y') ?? 'N/A' }}
                            </td>

                            <td class="px-4 py-3">
                                @php
                                    $statusColors = [
                                        'scheduled'   => 'bg-blue-100 text-blue-700',
                                        'in_progress' => 'bg-yellow-100 text-yellow-800',
                                        'completed'   => 'bg-green-100 text-green-700',
                                        'cancelled'   => 'bg-red-100 text-red-700',
                                    ];
                                    $badge = $statusColors[$job->status] ?? 'bg-gray-100 text-gray-700';
                                @endphp

                                <span class="{{ $badge }} text-xs px-2 py-1 rounded capitalize">
                                    {{ str_replace('_', ' ', $job->status ?? '—') }}
                                </span>
                            </td>

                            <td class="px-4 py-3 text-center">
                                <div class="inline-flex gap-2 justify-center">
                                    <form
                                        action="{{ route('technician.job.in_progress', $job->id) }}"
                                        method="POST"
                                        class="text-green-600 hover:text-green-800"
                                        title="Start"
                                    >
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit">
                                            <i class="fas fa-wrench"></i>
                                        </button>
                                    </form>

                                    <a
                                        href="{{ route('technician.job.show', $job->id) }}"
                                        class="text-blue-600 hover:text-blue-800"
                                        title="View"
                                    >
                                        <i class="fas fa-eye"></i>
                                    </a>

                                    <a
                                        href="{{ route('technician.job.edit', $job->id) }}"
                                        class="text-yellow-600 hover:text-yellow-700"
                                        title="Update"
                                    >
                                        <i class="fas fa-pen-to-square"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-gray-500">
                                No job orders found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Summary -->
        <div class="flex justify-between items-center mt-4 border-t pt-3 text-sm text-gray-700">
            <div>
                Total Job Orders:
                <span class="text-blue-600 font-semibold">{{ $stats['total'] ?? 0 }}</span>
            </div>
            <div>
                Currently Active:
                <span class="text-yellow-600 font-semibold">{{ $stats['active'] ?? 0 }}</span>
            </div>
        </div>

        <!-- Pagination -->
        <div class="border-t mt-4 pt-2 flex justify-between items-center text-sm text-gray-500">
            <p>
                @if($jobOrders->total() > 0)
                    Showing {{ $jobOrders->firstItem() }}–{{ $jobOrders->lastItem() }} of {{ $jobOrders->total() }} job orders
                @else
                    Showing 0 of 0 job orders
                @endif
            </p>

            {{ $jobOrders->withQueryString()->links() }}
        </div>
    </div>
</div>

@endsection
