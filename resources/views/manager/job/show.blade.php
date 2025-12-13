<x-layouts.app :title="__('Job Order')">

<div class="max-w-4xl mx-auto bg-white p-8 text-[13px] text-gray-800 font-[DejaVu Sans] shadow-sm">

    <!-- Company Header -->
    <div class="border mb-4 flex">
        <div class="w-1/3 bg-gray-50 flex items-center justify-center p-4">
            <img src="{{ asset('images/logo.png') }}" alt="Company Logo" class="max-h-[90%] object-contain">
        </div>
        <div class="w-2/3 p-4 space-y-1 border-l border-gray-300">
            <h1 class="text-base font-bold">Techne Fixer Computer and Laptop Repair Services</h1>
            <p>Contact No: 09662406825</p>
            <p>007 Manga Street Crossing Bayabas, Davao City</p>
            <div class="border-t border-gray-200 pt-1 text-[12px]">
                <p><strong>Business ID:</strong> 2024‑18343‑92</p>
                <p><strong>Permit No:</strong> B‑1894606‑6</p>
                <p><strong>TIN No:</strong> 618‑863‑736‑000000</p>
            </div>
        </div>
    </div>

    <!-- Job Information -->
    <div class="space-y-1 mb-3 text-[12px]">
        <p><strong>Job Order #:</strong> JO‑{{ str_pad($job->id, 5, '0', STR_PAD_LEFT) }}</p>
        <p><strong>Project Title:</strong> {{ optional($job->quotation)->project_title ?? 'Not specified' }}</p>
        <p><strong>Client:</strong> {{ optional($job->quotation)->client_name ?? 'N/A' }}</p>
        <p><strong>Status:</strong> {{ ucfirst($job->status) }}</p>
        <p><strong>Technician Assigned:</strong> {{ optional($job->technician)->name ?? 'Unassigned' }}</p>
        <p><strong>Date Started:</strong> {{ optional($job->start_date)->format('F j, Y') ?? 'Not Started' }}</p>
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
                <p class="text-xs text-gray-400">Image not found</p>
            @endif
        </div>
        <div class="w-2/3 p-4 space-y-1 border-l border-gray-300">
            <h3 class="text-sm font-semibold border-b border-gray-300 pb-1">Client Details</h3>
            <p><strong>Client:</strong> {{ optional($job->quotation)->client_name ?? 'N/A' }}</p>
            <p><strong>Address:</strong> {{ optional($job->quotation)->client_address ?? 'N/A' }}</p>
            <p><strong>Contact No:</strong> {{ optional($job->quotation->inquiry)->contact_number ?? 'N/A' }}</p>
            <p><strong>Email:</strong> {{ optional($job->quotation->inquiry)->email ?? 'N/A' }}</p>
        </div>
    </div>

    <!-- Item Table (Quotation + Technician Added Items) -->
    <h3 class="font-semibold text-sm mb-2">Items and Services Used</h3>
    <table class="w-full border-collapse text-[12px] mb-4">
        <thead class="bg-gray-100">
            <tr>
                <th class="border p-1 text-left">Item / Part</th>
                <th class="border p-1 text-left">Description</th>
                <th class="border p-1 text-center">Qty</th>
                <th class="border p-1 text-right">Unit Price (₱)</th>
                <th class="border p-1 text-right">Total (₱)</th>
                <th class="border p-1 text-center">Source</th>
            </tr>
        </thead>
        <tbody>
            <!-- Fixed quotation items -->
            @if(optional($job->quotation)->details && $job->quotation->details->count())
                @foreach($job->quotation->details as $detail)
                    <tr class="bg-gray-50">
                        <td class="border p-1">{{ $detail->item_name }}</td>
                        <td class="border p-1">{{ $detail->description }}</td>
                        <td class="border p-1 text-center">{{ $detail->quantity }}</td>
                        <td class="border p-1 text-right">₱{{ number_format($detail->unit_price, 2) }}</td>
                        <td class="border p-1 text-right">₱{{ number_format($detail->total, 2) }}</td>
                        <td class="border p-1 text-center text-xs text-gray-500 italic">Quotation</td>
                    </tr>
                @endforeach
            @endif
            <!-- Technician added items -->
            @forelse($job->items as $item)
                <tr class="bg-white">
                    <td class="border p-1">{{ $item->name }}</td>
                    <td class="border p-1">{{ $item->description }}</td>
                    <td class="border p-1 text-center">{{ $item->quantity }}</td>
                    <td class="border p-1 text-right">₱{{ number_format($item->unit_price, 2) }}</td>
                    <td class="border p-1 text-right">₱{{ number_format($item->total, 2) }}</td>
                    <td class="border p-1 text-center text-xs text-gray-500 italic">Technician</td>
                </tr>
            @empty
                <tr><td colspan="6" class="border p-2 text-center text-gray-500">No additional items added.</td></tr>
            @endforelse
        </tbody>
    </table>

    <!-- Cost Summary -->
    @php
        $quotationSubtotal = optional($job->quotation)->details->sum('total') ?? 0;
        $techSubtotal       = $job->items->sum('total') ?? 0;
        $subtotal           = $quotationSubtotal + $techSubtotal;
        $diagnostic         = $subtotal * 0.10;
        $grandTotal         = $subtotal + $diagnostic;
    @endphp
    <div class="w-1/2 ml-auto mb-4 text-sm space-y-0.5">
        <div class="flex justify-between"><span>Subtotal:</span><span>₱{{ number_format($subtotal, 2) }}</span></div>
        <div class="flex justify-between"><span>Diagnostic Fee (10%):</span><span>₱{{ number_format($diagnostic, 2) }}</span></div>
        <div class="flex justify-between font-semibold"><span>Grand Total:</span><span>₱{{ number_format($grandTotal, 2) }}</span></div>
    </div>

    <!-- Scope of Work -->
    <div class="border-t pt-3 mb-4">
        <h3 class="font-semibold text-sm mb-1">Scope of Work (Reference)</h3>
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
            <p class="text-gray-500 text-sm">No scope defined.</p>
        @endif
    </div>

    <!-- Waiver -->
    <div class="border-t pt-3 mb-4">
        <h3 class="font-semibold text-sm mb-1">Scope of Waiver (Reference)</h3>
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
            <p class="text-gray-500 text-sm">No waiver information available.</p>
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

    <!-- Timeline -->
    <div class="border-t pt-3 mb-2">
        <p><strong>Timeline:</strong> Estimated {{ $job->timeline_min_days ?? 'N/A' }}–{{ $job->timeline_max_days ?? 'N/A' }} days | Expected completion: {{ optional($job->expected_finish_date)->format('F j, Y') ?? 'TBD' }}.</p>
    </div>

    <!-- Notes -->
    <div class="border-t pt-3 mb-4">
        <h3 class="font-semibold text-sm mb-1">Technician Notes / Findings</h3>
        <p class="whitespace-pre-line text-gray-700">{{ $job->technician_notes ?? 'No notes recorded.' }}</p>
    </div>

    <!-- Footer -->
    <p class="text-center text-[11px] text-gray-500 mt-8 border-t pt-2">
        Techne Fixer Computer and Laptop Repair Services | Job Order
    </p>
</div>

</x-layouts.app>