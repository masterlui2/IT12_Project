@extends('technician.layout.app')

@section('content')

<div class="max-w-4xl mx-auto bg-white p-8 text-[13px] text-gray-800 font-[DejaVu Sans] shadow-sm">

    <!-- Company Header -->
    <div class="border mb-4 flex">
        <div class="w-1/3 bg-gray-50 flex items-center justify-center p-4">
            <img src="{{ asset('images/logo.png') }}" alt="Company Logo" class="max-h-[90%] object-contain">
        </div>
        <div class="w-2/3 p-4 space-y-1 border-l border-gray-300">
            <h1 class="text-base font-bold">Techne Fixer Computer and Laptop Repair Services</h1>
            <p>Contact No: 09662406825</p>
            <p>007 Manga Street Crossing Bayabas, Davao City</p>
            <div class="border-t border-gray-200 pt-1 text-[12px]">
                <p><strong>Business ID:</strong> 2024‑18343‑92</p>
                <p><strong>Permit No:</strong> B‑1894606‑6</p>
                <p><strong>TIN No:</strong> 618‑863‑736‑000000</p>
            </div>
        </div>
    </div>

    <!-- Job Summary -->
    <div class="space-y-2 mb-3 text-[12px]">
        <p><strong>Job Order #:</strong> JO‑{{ str_pad($job->id, 5, '0', STR_PAD_LEFT) }}</p>
        <p><strong>Client Name:</strong> {{ $job->customer_name }}</p>
        <p><strong>Project Title:</strong> {{ optional($job->quotation)->project_title ?? 'N/A' }}</p>
        <p><strong>Status:</strong> <span class="capitalize">{{ $job->status }}</span></p>
        <p><strong>Assigned Technician:</strong> {{ optional($job->technician)->name ?? 'Unassigned' }}</p>
        <p><strong>Start Date:</strong> {{ $job->created_at->format('F j, Y') }}</p>
        <p><strong>Expected Finish Date:</strong> {{ optional($job->expected_finish_date)->format('F j, Y') ?? 'TBD' }}</p>
        @if($job->completed_at)
            <p><strong>Actual Completion:</strong> {{ $job->completed_at->format('F j, Y g:i A') }}</p>
        @endif
    </div>

    <!-- Link Back -->
    <div class="mb-4">
        <a href="{{ route('technician.job.index') }}" class="text-blue-600 text-sm hover:underline">← Back to Job Orders</a>
    </div>

    <!-- Quotation Reference -->
    @if($job->quotation)
    <div class="border-t pt-3 mb-3">
        <h3 class="font-semibold text-sm mb-1">Reference Quotation</h3>
        <p><strong>Quotation ID:</strong> Q-{{ str_pad($job->quotation->id, 5, '0', STR_PAD_LEFT) }}</p>
        <p><strong>Estimated Total:</strong> ₱{{ number_format($job->quotation->grand_total, 2) }}</p>
    </div>
    @endif

    <!-- Actual Work Items -->
    @if(!empty($job->work_items) && is_iterable($job->work_items))
    <h3 class="font-semibold text-sm mb-2">Work Performed / Replacement Parts</h3>
    <table class="w-full border-collapse text-[12px] mb-4">
        <thead class="bg-gray-100">
            <tr>
                <th class="border p-1 text-left">Item/Task</th>
                <th class="border p-1 text-left">Description</th>
                <th class="border p-1 text-center">Qty</th>
                <th class="border p-1 text-right">Unit Cost (₱)</th>
                <th class="border p-1 text-right">Total (₱)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($job->work_items as $item)
                <tr>
                    <td class="border p-1">{{ $item['name'] }}</td>
                    <td class="border p-1">{{ $item['desc'] }}</td>
                    <td class="border p-1 text-center">{{ $item['qty'] }}</td>
                    <td class="border p-1 text-right">₱{{ number_format($item['unit_cost'], 2) }}</td>
                    <td class="border p-1 text-right">₱{{ number_format($item['total_cost'], 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    @endif

    <!-- Technician Notes -->
    <div class="border-t pt-3 mb-3">
        <h3 class="font-semibold text-sm mb-1">Technician Notes / Findings</h3>
        <p class="whitespace-pre-line text-gray-700">{{ $job->technician_notes ?? 'No notes recorded.' }}</p>
    </div>

    <!-- Completion Summary -->
    @if($job->status === 'completed')
    <div class="border-t pt-3 mb-3">
        <h3 class="font-semibold text-sm mb-1">Completion Summary</h3>
        <p>Job successfully completed on {{ $job->completed_at?->format('F j, Y g:i A') ?? 'Unknown date' }}.</p>
        <p><strong>Final Cost:</strong> ₱{{ number_format($job->final_total ?? $job->quotation->grand_total, 2) }}</p>
        <p><strong>Client Acknowledgment:</strong> {{ $job->client_acknowledged ? 'Received / Confirmed' : 'Pending' }}</p>
    </div>
    @endif

    <!-- Signature Block -->
    <div class="border-t pt-4 text-center text-[11px] text-gray-500 mt-6">
        Techne Fixer Computer and Laptop Repair Services | Job Order
    </div>
</div>

@endsection
