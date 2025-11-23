@extends('technician.layout.app')

@section('content')
<div class="max-w-4xl mx-auto bg-white p-8 text-[13px] text-gray-800 font-[DejaVu Sans] shadow-sm">
    <!-- Company Header -->
    <div class="border mb-4 flex">
        <div class="w-1/3 bg-gray-50 flex items-center justify-center p-4">
                <img src="{{ asset('images/logo.png') }}" alt="Company Logo" class="max-h-[90%] object-contain">
        </div>
        <div class="w-2/3 p-4 space-y-1 border-l border-gray-300">
            <h1 class="text-base font-bold">Techne Fixer Computer and Laptop Repair Services</h1>
            <p>Contact No: 09662406825</p>
            <p>007 Manga Street Crossing Bayabas, Davao City</p>
            <div class="border-t border-gray-200 pt-1 text-[12px]">
                <p><strong>Business ID:</strong> 2024‑18343‑92</p>
                <p><strong>Permit No:</strong> B‑1894606‑6</p>
                <p><strong>TIN No:</strong> 618‑863‑736‑000000</p>
            </div>
        </div>
    </div>

    <!-- Project Info -->
    <div class="space-y-1 mb-3 text-[12px]">
        <p><strong>Project Title:</strong> {{ $quotation->project_title }}</p>
        <p><strong>Objective:</strong> {{ $quotation->objective ?? 'No objective defined' }}</p>
    </div>

    <!-- Client Details -->
    <div class="border mb-4 flex">
        <div class="w-1/3 bg-gray-50 flex items-center justify-center">
            @if(!empty($quotation->client_logo))
                <img src="{{ asset('storage/' . $quotation->client_logo) }}" alt="Client Logo" class="max-h-[90%] object-contain">
            @else
                <p class="text-xs text-gray-400">Image not found</p>
            @endif
        </div>
        <div class="w-2/3 p-4 space-y-1 border-l border-gray-300">
            <h3 class="text-sm font-semibold border-b border-gray-300 pb-1">Client Details</h3>
            <p><strong>Client:</strong> {{ $quotation->client_name }}</p>
            <p><strong>Date Issued:</strong> {{ \Carbon\Carbon::parse($quotation->date_issued)->format('F j, Y') }}</p>
            <p><strong>Address:</strong> {{ $quotation->client_address ?? 'N/A' }}</p>
        </div>
    </div>

    <!-- Items Table -->
    @if($quotation->details && $quotation->details->count() > 0)
    <h3 class="font-semibold text-sm mb-2">Items and Services</h3>
    <table class="w-full border-collapse text-[12px] mb-4">
        <thead class="bg-gray-100">
            <tr>
                <th class="border p-1 text-left">Item</th>
                <th class="border p-1 text-left">Description</th>
                <th class="border p-1 text-center">Qty</th>
                <th class="border p-1 text-right">Unit Price (₱)</th>
                <th class="border p-1 text-right">Total (₱)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($quotation->details as $detail)
                <tr>
                    <td class="border p-1">{{ $detail->item_name }}</td>
                    <td class="border p-1">{{ $detail->description }}</td>
                    <td class="border p-1 text-center">{{ $detail->quantity }}</td>
                    <td class="border p-1 text-right">₱{{ number_format($detail->unit_price, 2) }}</td>
                    <td class="border p-1 text-right">₱{{ number_format($detail->total, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="w-1/2 ml-auto mb-4 text-sm space-y-0.5">
        <div class="flex justify-between"><span>Subtotal:</span><span>₱{{ number_format($quotation->labor_estimate, 2) }}</span></div>
        <div class="flex justify-between"><span>Tax / Diagnostic Fee:</span><span>₱{{ number_format($quotation->diagnostic_fee, 2) }}</span></div>
        <div class="flex justify-between font-semibold"><span>Total:</span><span>₱{{ number_format($quotation->grand_total, 2) }}</span></div>
    </div>
    @endif

    <!-- Scope -->
    <div class="border-t pt-3 mb-4">
        <h3 class="font-semibold text-sm mb-1">Scope of Work</h3>

        @if($quotation->scopes && $quotation->scopes->count())
            @foreach($quotation->scopes as $scope)
                <p class="font-bold">{{ $loop->iteration }}. {{ $scope->scenario_name }}</p>

                @foreach($scope->cases as $case)
                    <ul class="list-disc pl-5 text-[12px] text-gray-700">
                        <li><strong>{{ $case->case_title }}</strong>: {{ $case->case_description }}</li>
                    </ul>
                @endforeach
            @endforeach
        @else
            <p class="text-gray-500 text-sm">No scope defined.</p>
        @endif
    </div>

    <!-- Waiver -->
    <div class="border-t pt-3 mb-4">
        <h3 class="font-semibold text-sm mb-1">Waiver of Liability</h3>
        <p>This waiver is executed on <strong>{{ \Carbon\Carbon::parse($quotation->date_issued)->format('F j, Y') }}</strong>
           by <strong>{{ $quotation->client_name }}</strong>, releasing Techne Fixer Computer and Laptop Repair Services from liability related to service activities.</p>

        @if($quotation->waivers && $quotation->waivers->count())
            <h4 class="font-semibold mt-2">Scope of Liability</h4>
            @foreach($quotation->waivers as $waiver)
                <p class="font-bold mt-1">{{ $waiver->waiver_title }}</p>
                @foreach($waiver->cases as $case)
                    <ul class="list-disc pl-5 text-[12px]">
                        <li><strong>{{ $case->case_title }}</strong>: {{ $case->description }}</li>
                    </ul>
                @endforeach
            @endforeach
        @endif
    </div>

    <!-- Deliverables -->
    @if($quotation->deliverables && $quotation->deliverables->count())
    <div class="border-t pt-3 mb-4">
        <h3 class="font-semibold text-sm mb-1">Expected Deliverables</h3>
        <ul class="list-disc pl-5 text-[12px]">
            @foreach($quotation->deliverables as $deliverable)
                <li>{{ $deliverable->deliverable_detail }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <!-- Timeline -->
    <div class="border-t pt-3 mb-2">
        <p><strong>Timeline:</strong> Estimated completion in <strong>{{ $quotation->timeline_min_days }}–{{ $quotation->timeline_max_days }} days</strong>
            (depending on availability of replacement parts and issue complexity).</p>
    </div>

    <!-- Terms -->
    @if(!empty($quotation->terms_conditions))
    <div class="border-t pt-3">
        <h3 class="font-semibold text-sm mb-1">Terms and Conditions</h3>
        <p class="whitespace-pre-line">{{ $quotation->terms_conditions }}</p>
    </div>
    @endif

    <p class="text-center text-[11px] text-gray-500 mt-8 border-t pt-2">
        Techne Fixer Computer and Laptop Repair Services | Quotation
    </p>
</div>
@endsection