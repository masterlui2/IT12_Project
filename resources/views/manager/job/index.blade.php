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
                <form method="GET" action="#" class="flex gap-3">
                    <input type="text" name="search" placeholder="Search by client or JO ID"
                           class="px-3 py-2 border rounded-md text-sm focus:ring-blue-500 focus:border-blue-500 w-52" />

                    <select name="status"
                            class="px-3 py-2 border rounded-md text-sm focus:ring-blue-500 focus:border-blue-500">
                        <option value="">All Status</option>
                        <option value="scheduled">Scheduled</option>
                        <option value="in_progress">In Progress</option>
                        <option value="completed">Completed</option>
                        <option value="cancelled">Cancelled</option>
                    </select>
                </form>
            </div>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto border rounded-lg">
            <table class="w-full text-left text-sm">
                <thead class="bg-neutral-50 text-neutral-700">
                    <tr class="border-b border-neutral-200">
                        <th class="px-4 py-3 font-medium">Job #</th>
                        <th class="px-4 py-3 font-medium">Client</th>
                        <th class="px-4 py-3 font-medium">Project Title</th>
                        <th class="px-4 py-3 font-medium text-right">Start Date</th>
                        <th class="px-4 py-3 font-medium text-right">Target Completion</th>
                        <th class="px-4 py-3 font-medium">Status</th>
                        <th class="px-4 py-3 font-medium text-center w-40">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @forelse ($jobOrders as $job)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-4 py-3 font-medium text-neutral-900">JO-{{ str_pad($job->id, 5, '0', STR_PAD_LEFT) }}</td>
                        <td class="px-4 py-3">{{ $job->quotation->client_name }}</td>
                        <td class="px-4 py-3 text-neutral-800">{{ optional($job->quotation)->project_title ?? 'N/A' }}</td>
                        <td class="px-4 py-3 text-right text-neutral-700">{{ $job->created_at->format('M d, Y') }}</td>
                        <td class="px-4 py-3 text-right text-neutral-700">
                            {{ optional($job->expected_finish_date)->format('M d, Y') ?? 'N/A' }}
                        </td>
                        <td class="px-4 py-3">
                            @php
                                $statusColors = [
                                    'scheduled' => 'bg-blue-100 text-blue-700',
                                    'in_progress' => 'bg-yellow-100 text-yellow-800',
                                    'completed' => 'bg-green-100 text-green-700',
                                    'cancelled' => 'bg-red-100 text-red-700',
                                ];
                            @endphp
                            <span class="{{ $statusColors[$job->status] ?? 'bg-gray-100 text-gray-700' }} text-xs px-2 py-1 rounded capitalize">
                                {{ $job->status }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-center">
                            <div class="inline-flex gap-2 justify-center">
                                <form action="{{ route('manager.job.markComplete', $job->id) }}" method="POST" class="text-green-600 hover:text-green-800" title="Start">
                                    @csrf 
                                    @method('PATCH')
                                    <button type="submit" name="button" action="in_progress"><i class="fas fa-check"></i></button>
                                </form>
                                <a href="{{ route('manager.job.show', $job->id) }}" class="text-blue-600 hover:text-blue-800" title="View"><i class="fas fa-eye"></i></a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-4 text-gray-500">No job orders found.</td>
                    </tr>
                    @endforelse
                </tbody>

            </table>
        </div>

        <!-- Summary -->
        <div class="flex justify-between items-center mt-4 border-t pt-3 text-sm text-gray-700">
            <div>Total Job Orders:
                <span class="text-blue-600 font-semibold">3</span>
            </div>
            <div>Currently Active:
                <span class="text-yellow-600 font-semibold">1</span>
            </div>
        </div>

        <!-- Pagination -->
        <div class="border-t mt-4 pt-2 flex justify-between items-center text-sm text-gray-500">
            <p>Showing 1–3 of 3 job orders</p>
            <div class="space-x-1">
                <button class="px-2 py-1 border rounded bg-gray-100 text-gray-400 cursor-not-allowed" disabled>Prev</button>
                <button class="px-2 py-1 border rounded bg-blue-600 text-white">1</button>
                <button class="px-2 py-1 border rounded bg-gray-100 text-gray-400 cursor-not-allowed" disabled>Next</button>
            </div>
        </div>
    </div>
</div>
</x-layouts.app>
