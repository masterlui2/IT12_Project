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
            <p>Contact No: 09662406825</p>
            <p>007 Manga Street Crossing Bayabas, Davao City</p>
            <div class="border-t border-gray-200 pt-1 text-[12px]">
                <p><strong>Business ID:</strong> 2024‑18343‑92</p>
                <p><strong>Permit No:</strong> B‑1894606‑6</p>
                <p><strong>TIN No:</strong> 618‑863‑736‑000000</p>
            </div>
        </div>
    </div>

    <!-- Job Summary -->
    <div class="space-y-1 mb-3 text-[12px]">
        <p><strong>Job Order #:</strong> JO‑{{ str_pad($job->id, 5, '0', STR_PAD_LEFT) }}</p>
        <p><strong>Project Title:</strong> {{ optional($job->quotation)->project_title ?? 'Not specified' }}</p>
        <p><strong>Client:</strong> {{ $job->customer_name }}</p>
        <p><strong>Status:</strong> {{ ucfirst($job->status) }}</p>
        <p><strong>Assigned Technician:</strong> {{ optional($job->technician)->name ?? 'Unassigned' }}</p>
        <p><strong>Start Date:</strong> {{ $job->created_at->format('F j, Y') }}</p>
        <p><strong>Expected Finish Date:</strong> {{ optional($job->expected_finish_date)->format('F j, Y') ?? 'TBD' }}</p>
        @if($job->completed_at)
            <p><strong>Actual Completion:</strong> {{ $job->completed_at->format('F j, Y g:i A') }}</p>
        @endif
    </div>

    <!-- Client Details -->
    <div class="border mb-4 flex">
        <div class="w-1/3 bg-gray-50 flex items-center justify-center">
            @if(!empty(optional($job->quotation)->client_logo))
                <img src="{{ asset('storage/' . $job->quotation->client_logo) }}" alt="Client Logo" class="max-h-[90%] object-contain">
            @else
                <p class="text-xs text-gray-400">Image not available</p>
            @endif
        </div>
        <div class="w-2/3 p-4 space-y-1 border-l border-gray-300">
            <h3 class="text-sm font-semibold border-b border-gray-300 pb-1">Client Information</h3>
            <p><strong>Client:</strong> {{ $job->customer_name }}</p>
            <p><strong>Address:</strong> {{ optional($job->quotation)->client_address ?? 'N/A' }}</p>
            <p><strong>Contact Number:</strong> {{ $job->contact_number ?? 'N/A' }}</p>
        </div>
    </div>

    <!-- Work Items -->
    @if(!empty($job->work_items))
    <h3 class="font-semibold text-sm mb-2">Actual Work Performed / Parts Used</h3>
    <table class="w-full border-collapse text-[12px] mb-4">
        <thead class="bg-gray-100">
            <tr>
                <th class="border p-1 text-left">Item / Task</th>
                <th class="border p-1 text-left">Description</th>
                <th class="border p-1 text-center">Qty</th>
                <th class="border p-1 text-right">Unit Cost (₱)</th>
                <th class="border p-1 text-right">Total (₱)</th>
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

    <!-- Cost Summary -->
    <div class="w-1/2 ml-auto mb-4 text-sm space-y-0.5">
        <div class="flex justify-between">
            <span>Subtotal (Labor / Parts):</span>
            <span>₱{{ number_format($job->subtotal ?? 0, 2) }}</span>
        </div>
        <div class="flex justify-between">
            <span>Diagnostic Fee (10%):</span>
            <span>₱{{ number_format($job->diagnostic_fee ?? 0, 2) }}</span>
        </div>
        <div class="flex justify-between font-semibold">
            <span>Grand Total:</span>
            <span>₱{{ number_format($job->final_total ?? 0, 2) }}</span>
        </div>
    </div>

    <!-- Scope of Work (from quotation) -->
    <div class="border-t pt-3 mb-4">
        <h3 class="font-semibold text-sm mb-1">Scope of Work</h3>
        @if(optional($job->quotation)->scopes && $job->quotation->scopes->count())
            @foreach($job->quotation->scopes as $scope)
                <p class="font-bold">{{ $loop->iteration }}. {{ $scope->scenario_name }}</p>
                @foreach($scope->cases as $case)
                    <ul class="list-disc pl-5 text-[12px] text-gray-700">
                        <li><strong>{{ $case->case_title }}</strong>: {{ $case->case_description }}</li>
                    </ul>
                @endforeach
            @endforeach
        @else
            <p class="text-gray-500 text-sm">No scope data found.</p>
        @endif
    </div>

    <!-- Waiver -->
    <div class="border-t pt-3 mb-4">
        <h3 class="font-semibold text-sm mb-1">Waiver of Liability (Reference)</h3>
        @if(optional($job->quotation)->waivers && $job->quotation->waivers->count())
            @foreach($job->quotation->waivers as $waiver)
                <p class="font-bold mt-1">{{ $waiver->waiver_title }}</p>
                @foreach($waiver->cases as $case)
                    <ul class="list-disc pl-5 text-[12px]">
                        <li><strong>{{ $case->case_title }}</strong>: {{ $case->description }}</li>
                    </ul>
                @endforeach
            @endforeach
        @else
            <p class="text-gray-500 text-sm">No waiver definitions available.</p>
        @endif
    </div>

    <!-- Deliverables -->
    @if(optional($job->quotation)->deliverables && $job->quotation->deliverables->count())
    <div class="border-t pt-3 mb-4">
        <h3 class="font-semibold text-sm mb-1">Deliverables Verified</h3>
        <ul class="list-disc pl-5 text-[12px]">
            @foreach($job->quotation->deliverables as $deliverable)
                <li>{{ $deliverable->deliverable_detail }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <!-- Technician Notes -->
    <div class="border-t pt-3 mb-4">
        <h3 class="font-semibold text-sm mb-1">Technician Notes / Findings</h3>
        <p class="whitespace-pre-line text-gray-700">{{ $job->technician_notes ?? 'No notes recorded.' }}</p>
    </div>

    <!-- Completion -->
    @if($job->status === 'completed')
    <div class="border-t pt-3 mb-4">
        <h3 class="font-semibold text-sm mb-1">Completion Summary</h3>
        <p>Job completed on {{ $job->completed_at?->format('F j, Y g:i A') ?? 'Unknown date' }}.</p>
        <p><strong>Final Cost:</strong> ₱{{ number_format($job->final_total ?? 0, 2) }}</p>
        <p><strong>Client Acknowledgment:</strong> {{ $job->client_acknowledged ? 'Confirmed' : 'Pending' }}</p>
    </div>
    @endif

    <!-- Timeline -->
    <div class="border-t pt-3 mb-2">
        <p><strong>Timeline:</strong> Estimated duration was {{ optional($job->quotation)->timeline_min_days }}–{{ optional($job->quotation)->timeline_max_days }} days;
           actual completion {{ $job->completed_at ? 'met' : 'pending' }}.</p>
    </div>

    <!-- Terms -->
    @if(!empty(optional($job->quotation)->terms_conditions))
    <div class="border-t pt-3">
        <h3 class="font-semibold text-sm mb-1">Terms and Conditions (from Quotation)</h3>
        <p class="whitespace-pre-line">{{ $job->quotation->terms_conditions }}</p>
    </div>
    @endif

    <p class="text-center text-[11px] text-gray-500 mt-8 border-t pt-2">
        Techne Fixer Computer and Laptop Repair Services | Job Order
    </p>
</div>
@endsection
