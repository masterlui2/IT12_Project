@extends('technician.layout.app')

@section('content')
@php
    $formatCurrency = fn ($value) => '₱ ' . number_format($value ?? 0, 2);
@endphp
    
{{-- Top Navigation Bar --}}
<nav class="w-full bg-white border-b border-gray-100 px-6 py-4 flex flex-col gap-3 md:flex-row md:items-center md:justify-between mb-6 rounded-lg shadow-sm">
    <div class="flex items-center gap-3">
        <div class="h-10 w-10 rounded-lg bg-blue-50 flex items-center justify-center">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                 class="w-6 h-6 text-blue-600">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M3 3v1m0 0a2 2 0 002 2h12a2 2 0 002-2V4m-2 16H5a2 2 0 01-2-2V4M3 4h18" />
            </svg>
        </div>
        <div>
            <h2 class="text-lg md:text-xl font-semibold text-gray-900">Reporting Dashboard</h2>
            <p class="text-xs text-gray-500">Real-time job order performance</p>
        </div>
    </div>

    <div class="flex items-center gap-3">
        <a href="{{ route('technician.job.index') }}"
           class="inline-flex items-center justify-center rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-700 transition">
            View jobs
        </a>
    </div>
</nav>

<div class="flex flex-col space-y-6">

    {{-- Summary Cards --}}
    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
        <div class="bg-white border border-gray-100 rounded-xl shadow-sm p-5">
            <p class="text-xs font-medium text-gray-500">Total Job Orders</p>
            <p class="text-2xl font-semibold text-gray-900 mt-1">
                {{ $stats['totals']['job_orders'] ?? 0 }}
            </p>
            <p class="text-xs text-gray-500 mt-2">All job orders you've handled.</p>
        </div>

        <div class="bg-white border border-gray-100 rounded-xl shadow-sm p-5">
            <p class="text-xs font-medium text-gray-500">Active Jobs</p>
            <p class="text-2xl font-semibold text-gray-900 mt-1">
                {{ $stats['jobs']['active'] ?? 0 }}
            </p>
            <p class="text-xs text-blue-600 mt-2">
                In progress & scheduled
            </p>
        </div>

        <div class="bg-white border border-gray-100 rounded-xl shadow-sm p-5">
            <p class="text-xs font-medium text-gray-500">Completed Jobs</p>
            <p class="text-2xl font-semibold text-gray-900 mt-1">
                {{ $stats['jobs']['completed'] ?? 0 }}
            </p>
            <p class="text-xs text-emerald-600 mt-2">Successfully finished jobs.</p>
        </div>

        <div class="bg-white border border-gray-100 rounded-xl shadow-sm p-5">
            <p class="text-xs font-medium text-gray-500">Total Revenue</p>
            <p class="text-2xl font-semibold text-gray-900 mt-1">
                {{ $formatCurrency($stats['revenue']['total'] ?? 0) }}
            </p>
            <p class="text-xs text-gray-500 mt-2">From completed job orders</p>
        </div>
    </div>

    {{-- Insights --}}
    <div class="grid gap-4 md:grid-cols-2">
        {{-- Job Status --}}
        <div class="bg-white border border-gray-100 rounded-xl shadow-sm p-5">
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-semibold text-gray-900">Job Order Status</h3>
            </div>

            <div class="space-y-3 text-sm">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2 text-gray-700">
                        <span class="w-2.5 h-2.5 rounded-full bg-blue-500"></span>
                        <span>Scheduled</span>
                    </div>
                    <span class="font-semibold text-gray-900">{{ $stats['jobs']['scheduled'] ?? 0 }}</span>
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2 text-gray-700">
                        <span class="w-2.5 h-2.5 rounded-full bg-amber-400"></span>
                        <span>In Progress</span>
                    </div>
                    <span class="font-semibold text-gray-900">{{ $stats['jobs']['in_progress'] ?? 0 }}</span>
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2 text-gray-700">
                        <span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span>
                        <span>Completed</span>
                    </div>
                    <span class="font-semibold text-gray-900">{{ $stats['jobs']['completed'] ?? 0 }}</span>
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2 text-gray-700">
                        <span class="w-2.5 h-2.5 rounded-full bg-rose-500"></span>
                        <span>Cancelled</span>
                    </div>
                    <span class="font-semibold text-gray-900">{{ $stats['jobs']['cancelled'] ?? 0 }}</span>
                </div>
            </div>
        </div>

        {{-- Revenue Breakdown --}}
        <div class="bg-white border border-gray-100 rounded-xl shadow-sm p-5">
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-semibold text-gray-900">Revenue Breakdown</h3>
            </div>

            <div class="space-y-3 text-sm text-gray-700">
                <div class="flex items-center justify-between">
                    <span>Completed jobs (Subtotal)</span>
                    <span class="font-semibold text-gray-900">{{ $formatCurrency($stats['revenue']['completed_subtotal'] ?? 0) }}</span>
                </div>

                <div class="flex items-center justify-between">
                    <span>Downpayments received (50%)</span>
                    <span class="font-semibold text-gray-900">{{ $formatCurrency($stats['revenue']['downpayments'] ?? 0) }}</span>
                </div>

                <div class="flex items-center justify-between">
                    <span>Remaining balance due</span>
                    <span class="font-semibold text-gray-900">{{ $formatCurrency($stats['revenue']['remaining_balance'] ?? 0) }}</span>
                </div>

                <div class="flex items-center justify-between border-t pt-3">
                    <span class="text-gray-600">Total revenue earned</span>
                    <span class="font-semibold text-emerald-600">{{ $formatCurrency($stats['revenue']['total'] ?? 0) }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Tables --}}
    <div class="grid gap-4 lg:grid-cols-3">

        {{-- Recent Job Orders --}}
        <div class="bg-white border border-gray-100 rounded-xl shadow-sm overflow-hidden lg:col-span-2">
            <div class="p-5 border-b border-gray-100 flex items-center justify-between">
                <div>
                    <h3 class="font-semibold text-gray-900">Recent Job Orders</h3>
                    <p class="text-xs text-gray-500">Latest items assigned to you</p>
                </div>
                <a href="{{ route('technician.job.index') }}" class="text-sm text-blue-600 hover:underline">
                    View all
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="bg-gray-50 text-gray-700">
                        <tr class="border-b border-gray-100">
                            <th class="px-5 py-3 font-medium">Job #</th>
                            <th class="px-5 py-3 font-medium">Customer</th>
                            <th class="px-5 py-3 font-medium">Project</th>
                            <th class="px-5 py-3 font-medium text-center">Status</th>
                            <th class="px-5 py-3 font-medium text-right">Total</th>
                            <th class="px-5 py-3 font-medium text-center w-28">Action</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100">
                        @forelse($recentJobs as $job)
                            @php
                                $statusClass = match($job->status) {
                                    'completed'   => 'bg-emerald-100 text-emerald-700',
                                    'in_progress' => 'bg-amber-100 text-amber-700',
                                    'scheduled'   => 'bg-blue-100 text-blue-700',
                                    'cancelled'   => 'bg-rose-100 text-rose-700',
                                    default       => 'bg-gray-100 text-gray-700'
                                };
                            @endphp

                            <tr class="hover:bg-gray-50">
                                <td class="px-5 py-3 font-semibold text-gray-900">
                                    JOB-{{ str_pad($job->id, 4, '0', STR_PAD_LEFT) }}
                                </td>
                                <td class="px-5 py-3 text-gray-800">
                                    {{ $job->quotation?->client_name ?? $job->customer_name ?? '—' }}
                                </td>
                                <td class="px-5 py-3 text-gray-800">
                                    {{ $job->quotation?->project_title ?? '—' }}
                                </td>
                                <td class="px-5 py-3 text-center">
                                    <span class="inline-flex items-center rounded-full px-2.5 py-1 text-xs font-medium {{ $statusClass }}">
                                        {{ ucfirst(str_replace('_', ' ', $job->status ?? 'pending')) }}
                                    </span>
                                </td>
                                <td class="px-5 py-3 text-right font-semibold text-gray-900">
                                    {{ $formatCurrency($job->subtotal ?? 0) }}
                                </td>
                                <td class="px-5 py-3 text-center">
                                    <a href="{{ route('technician.job.show', $job->id) }}"
                                       class="text-blue-600 hover:underline text-sm">
                                        View
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-5 py-8 text-center text-gray-500">
                                    No job orders assigned yet.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Top Completed Jobs by Revenue --}}
        <div class="bg-white border border-gray-100 rounded-xl shadow-sm overflow-hidden">
            <div class="p-5 border-b border-gray-100 flex items-center justify-between">
                <div>
                    <h3 class="font-semibold text-gray-900">Top Completed Jobs</h3>
                    <p class="text-xs text-gray-500">Highest revenue jobs</p>
                </div>
            </div>

            <div class="divide-y divide-gray-100">
                @forelse($topCompletedJobs ?? [] as $job)
                    <div class="px-5 py-4">
                        <div class="flex items-start justify-between gap-3">
                            <div>
                                <p class="font-semibold text-gray-900">
                                    {{ $job->quotation?->project_title ?? 'Job Order' }}
                                </p>
                                <p class="text-xs text-gray-500 mt-1">
                                    JOB-{{ str_pad($job->id, 4, '0', STR_PAD_LEFT) }}
                                </p>
                            </div>

                            <span class="inline-flex items-center rounded-full px-2.5 py-1 text-xs font-medium bg-emerald-100 text-emerald-700">
                                Completed
                            </span>
                        </div>

                        <div class="mt-3 flex items-center justify-between text-sm text-gray-700">
                            <span>{{ $job->quotation?->client_name ?? 'Customer' }}</span>
                            <div class="flex flex-col items-end gap-1">
                                <span class="font-semibold text-gray-900">{{ $formatCurrency($job->subtotal ?? 0) }}</span>
                                <span class="text-xs text-gray-500">Balance: {{ $formatCurrency($job->total_amount ?? 0) }}</span>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="px-5 py-10 text-center text-gray-500 text-sm">
                        No completed jobs yet.
                    </p>
                @endforelse
            </div>
        </div>

    </div>
</div>
@endsection