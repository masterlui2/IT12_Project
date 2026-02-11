<x-layouts.app :title="__('Job Order')">

<div class="bg-white rounded-xl shadow-sm border p-8 space-y-8">

    <!-- Header Section -->
    <div class="flex justify-between items-center border-b pb-3">
        <div>
            <h1 class="text-xl font-bold text-gray-800">Techne Fixer Computer and Laptop Repair Services</h1>
            <p class="text-sm text-gray-500">007 Manga Street, Toril Davao City</p>
            <p class="text-sm text-gray-500">Contact No: 09662406825 TIN 618‑863‑736‑000000</p>
        </div>
        <img src="{{ asset('images/logo.png') }}" class="w-20 h-20 object-contain" alt="Company Logo">
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

    <!-- Job Order Section -->
    <div>
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-lg font-semibold text-gray-800">Job Order Management</h2>

            <div class="flex flex-wrap items-center gap-3">
                                <form method="GET" action="{{ route('manager.job.index') }}" class="flex gap-3">
                    <input type="text" name="search" placeholder="Search by client or JO ID"
                                               value="{{ $filters['search'] ?? '' }}"
                           class="px-3 py-2 border rounded-md text-sm focus:ring-blue-500 focus:border-blue-500 w-52" />

                    <select name="status"
                            class="px-3 py-2 border rounded-md text-sm focus:ring-blue-500 focus:border-blue-500">
                        <option value="">All Status</option>
                          <option value="scheduled" @selected(($filters['status'] ?? '') === 'scheduled')>Scheduled</option>
                        <option value="in_progress" @selected(($filters['status'] ?? '') === 'in_progress')>In Progress</option>
                        <option value="completed" @selected(($filters['status'] ?? '') === 'completed')>Completed</option>
                        <option value="cancelled" @selected(($filters['status'] ?? '') === 'cancelled')>Cancelled</option>
                    </select>
                </form>
            </div>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto border rounded-lg">
            <table class="w-full text-left text-sm">
                <thead class="bg-neutral-50 text-neutral-700">
                    <tr class="border-b border-neutral-200">
                        <th class="px-4 py-3 font-medium text-center">Job #</th>
                        <th class="px-4 py-3 font-medium">Client</th>
                        <th class="px-4 py-3 font-medium">Project Title</th>
                        <th class="px-4 py-3 font-medium text-center">Technician</th>
                        <th class="px-4 py-3 font-medium text-center">Start Date</th>
                        <th class="px-4 py-3 font-medium text-center">Target Completion</th>
                        <th class="px-4 py-3 font-medium text-center">Status</th>
                        <th class="px-4 py-3 font-medium text-center w-56">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @forelse ($jobOrders as $job)
                    <tr class="hover:bg-gray-50 transition">
                        <!-- Job Order ID -->
                        <td class="px-4 py-3 text-center font-semibold text-neutral-900">
                            JO-{{ str_pad($job->id, 5, '0', STR_PAD_LEFT) }}
                        </td>

                        <!-- Client -->
                        <td class="px-4 py-3">
                            <div class="font-medium text-neutral-900">{{ $job->quotation->client_name ?? 'N/A' }}</div>
                        </td>

                        <!-- Project Title -->
                        <td class="px-4 py-3 text-neutral-800">
                            {{ optional($job->quotation)->project_title ?? 'N/A' }}
                        </td>

                        <!-- Assigned Technician -->
                        <td class="px-4 py-3 text-center">
                            @if ($job->technician)
                                <span class="inline-flex items-center gap-1 bg-blue-50 px-2 py-1 rounded-full text-xs font-medium text-blue-700">
                                    <i class="fas fa-user"></i>
                                    {{ $job->technician->user?->firstname }} {{ $job->technician->user?->lastname }}
                                </span>
                            @else
                                <span class="text-xs text-neutral-500">Unassigned</span>
                            @endif
                        </td>

                        <!-- Start Date -->
                        <td class="px-4 py-3 text-center text-neutral-700">
                            <div>{{ $job->created_at->format('M d, Y') }}</div>
                            <div class="text-xs text-neutral-500">{{ $job->created_at->format('h:i A') }}</div>
                        </td>

                        <!-- Target Completion -->
                        <td class="px-4 py-3 text-center text-neutral-700">
                            @if($job->expected_finish_date)
                                <div>{{ $job->expected_finish_date->format('M d, Y') }}</div>
                                <div class="text-xs text-neutral-500">{{ $job->expected_finish_date->format('h:i A') }}</div>
                            @else
                                <span class="text-neutral-500">Not set</span>
                            @endif
                        </td>

                        <!-- Status -->
                        <td class="px-4 py-3 text-center">
                            @php
                                $statusColors = [
                                    'scheduled' => 'bg-blue-100 text-blue-700',
                                    'in_progress' => 'bg-yellow-100 text-yellow-800',
                                    'completed' => 'bg-green-100 text-green-700',
                                    'cancelled' => 'bg-red-100 text-red-700',
                                ];
                            @endphp
                            <span class="{{ $statusColors[$job->status] ?? 'bg-gray-100 text-gray-700' }} text-xs px-3 py-1 rounded-full capitalize font-medium">
                                {{ str_replace('_', ' ', $job->status) }}
                            </span>
                        </td>

                        <!-- Actions -->
                        <td class="px-4 py-3">
                            <div class="flex items-center justify-center gap-2">
                                <!-- Assign Technician Form -->
                                <form action="{{ route('manager.job.assign', $job->id) }}" method="POST" class="flex items-center gap-2">
                                    @csrf
                                    <select
                                        name="technician_id"
                                        class="w-36 rounded-lg border border-neutral-200 bg-white px-2 py-1 text-xs text-neutral-700 focus:border-neutral-300 focus:outline-none focus:ring-1 focus:ring-neutral-300"
                                    >
                                        <option value="">Assign…</option>
                                        @foreach ($technicians as $technician)
                                            <option value="{{ $technician->id }}" @selected($technician->id == $job->technician_id)>
                                                {{ $technician->user?->firstname }} {{ $technician->user?->lastname }}
                                            </option>
                                        @endforeach
                                    </select>

                                    <button
                                        type="submit"
                                        class="bg-neutral-900 text-white px-3 py-1 rounded-lg text-xs font-medium hover:bg-neutral-800"
                                    >
                                        Assign
                                    </button>
                                </form>

                                <!-- View Button -->
                                <a href="{{ route('manager.job.show', $job->id) }}" class="text-blue-600 hover:text-blue-800 px-2" title="View">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-8 text-gray-500">
                            <i class="fas fa-inbox text-3xl mb-2 text-gray-400"></i>
                            <div class="font-medium">No job orders found</div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Summary -->
        <div class="flex justify-between items-center mt-4 border-t pt-3 text-sm text-gray-700">
            <div>Total Job Orders:
                <span class="text-blue-600 font-semibold">{{ $stats['total'] }}</span>            </div>
            <div>Currently Active:
                                <span class="text-yellow-600 font-semibold">{{ $stats['active'] }}</span>
            </div>
        </div>

        <!-- Pagination -->
        <div class="border-t mt-4 pt-2 flex justify-between items-center text-sm text-gray-500">
            <p>Showing {{ $jobOrders->firstItem() }}–{{ $jobOrders->lastItem() }} of {{ $jobOrders->total() }} job orders</p>
            {{ $jobOrders->withQueryString()->links() }}
        </div>
    </div>
</div>
</x-layouts.app>
