<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Quotation Preview</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color: #333; }
        h1, h2, h3 { margin: 0; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #ccc; padding: 5px; text-align: left; }
        .text-right { text-align: right; }
    </style>
</head>
<body>
    <!-- Company Info Card -->
    <div style="display: table; width: 100%; border: 1px solid #ccc; margin-bottom: 10px;">
        <div style="display: table-cell; width: 35%; background: #f7f7f7; text-align: center; vertical-align: middle; padding: 10px;">
            @if(!empty($logo))
                <img src="{{ $logo }}" alt="Company Logo" style="width: 100%; height: auto;">
            @else
                <p style="color: #999;">Logo not found</p>
            @endif
        </div>

        <div style="display: table-cell; width: 65%; padding: 10px; vertical-align: top;">
            <div style="border:1px solid #ddd; margin-bottom:8px; padding:8px;">
                <h1 style="font-size:14px; font-weight:bold;">Techne Fixer Computer and Laptop Repair Services</h1>
                <p style="font-size:11px;">Contact No: 09662406825</p>
                <p style="font-size:11px;">007 Manga Street Crossing Bayabas Davao City</p>
            </div>

            <div style="border:1px solid #ddd; padding:8px;">
                <p style="font-size:11px;"><strong>Business ID:</strong> 2024‑18343‑92</p>
                <p style="font-size:11px;"><strong>Permit No:</strong> B‑1894606‑6</p>
                <p style="font-size:11px;"><strong>TIN No:</strong> 618‑863‑736‑000000</p>
            </div>
        </div>
    </div>

    <p><strong>Project Title:</strong> {{ $project_title }}</p>
    <p><strong>Objective:</strong> {{ $objective }}</p>

    <!-- Client Details Card -->
    <div style="display: table; width: 100%; border: 1px solid #ccc; margin-bottom: 10px;">
        <div style="display: table-cell; width: 35%; background: #f7f7f7;">
            <div style="text-align:center;">
                @if(!empty($client_logo))
                    <img src="{{ $client_logo }}" alt="Client Logo"
                        style="width:100%; height:auto; object-fit:cover; display:inline-block;">
                @elseif(!empty($repair_service_image))
                    <img src="{{ $repair_service_image }}" alt="Repair Service"
                        style="width:100%; height:auto; object-fit:cover; display:inline-block;">
                @else
                    <p style="color:#999; padding:10px;">Image not found</p>
                @endif
            </div>
        </div>

        <div style="display: table-cell; width: 65%; padding: 10px; vertical-align: top;">
            <h3 style="font-size:13px; font-weight:bold; border-bottom:1px solid #ccc; margin-bottom:6px;">Client Details</h3>
            <table style="width:100%; font-size:11px; border: none;">
                <tr style="border: none;">
                    <td style="border: none;"><strong>Client:</strong></td>
                    <td style="border: none;">{{ $client_name }}</td>
                </tr>
                <tr style="border: none;">
                    <td style="border: none;"><strong>Date Issued:</strong></td>
                    <td style="border: none;">{{ $date_issued }}</td>
                </tr>
                <tr style="border: none;">
                    <td style="border: none;"><strong>Address:</strong></td>
                    <td style="border: none;">{{ $client_address }}</td>
                </tr>
            </table>
        </div>
    </div>

    <h3>Items and Services</h3>
    <table>
        <thead>
            <tr>
                <th>Item Name</th>
                <th>Description</th>
                <th>Qty</th>
                <th>Unit Price (₱)</th>
                <th>Total (₱)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($items as $item)
                <tr>
                    <td>{{ $item['name'] }}</td>
                    <td>{{ $item['desc'] }}</td>
                    <td>{{ $item['qty'] }}</td>
                    <td class="text-right">₱{{ number_format($item['price'], 2) }}</td>
                    <td class="text-right">₱{{ number_format($item['total'], 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <table style="margin-top:10px; width: 40%; float:right;">
        <tr><td>Subtotal:</td><td class="text-right">₱{{ number_format($subtotal, 2) }}</td></tr>
        <tr><td>Tax (10%):</td><td class="text-right">₱{{ number_format($tax, 2) }}</td></tr>
        <tr><td><strong>Total:</strong></td><td class="text-right"><strong>₱{{ number_format($total, 2) }}</strong></td></tr>
    </table>

    <div style="clear:both; margin-top:40px;">
        <hr>
        <h3>Scope of Work</h3>
        @if(count($scope) > 0)
            @foreach($scope as $scenario)
                <p><strong>{{ $scenario['scenario'] }}</strong></p>
                @if(count($scenario['cases']) > 0)
                    <ul>
                        @foreach($scenario['cases'] as $case)
                            <li><strong>{{ $case['case'] }}</strong>: {{ $case['desc'] }}</li>
                        @endforeach
                    </ul>
                @endif
            @endforeach
        @else
            <p>No scope defined.</p>
        @endif
    </div>

    <hr>

    <div>
        <h3>Waiver of Liability</h3>
        <p>
            This Waiver of Liability is executed on 
            <strong>{{ $date_issued }}</strong>
            by <strong>{{ $client_name }}</strong>
            (hereinafter referred to as the "Customer")
            in favor of Techne Fixer Computer and Laptop Repair Services
            (hereinafter referred to as the "Service Provider").
        </p>
    </div>

    @if(isset($waivers) && count($waivers) > 0)
        <div style="clear:both; margin-top:20px;">
            <h3>Scope of Liability</h3>
            @foreach($waivers as $waiver)
                <p><strong>{{ $waiver['scenario'] }}</strong></p>
                @if(count($waiver['cases']) > 0)
                    <ul>
                        @foreach($waiver['cases'] as $case)
                            <li><strong>{{ $case['case'] }}</strong>: {{ $case['desc'] }}</li>
                        @endforeach
                    </ul>
                @endif
            @endforeach
        </div>
    @endif

    <div>
        <h3>Indemnification</h3>
        <p>The Customer agrees to indemnify and hold harmless the Service Provider from any claims, damages, or expenses resulting from misuse or negligence of the repaired equipment.</p>
    </div>

    @if(count($deliverables) > 0)
        <div>
            <h3>Expected Deliverables</h3>
            <ul>
                @foreach($deliverables as $detail)
                    <li>{{ $detail }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <p><strong>Timeline:</strong> Estimate project completion <strong>{{ $timeline }}</strong> (depending on the availability of replacement parts and completion of the issue)</p>

    @if(isset($terms_conditions) && !empty($terms_conditions))
        <hr>
        <div>
            <h3>Terms and Conditions</h3>
            <p>{{ $terms_conditions }}</p>
        </div>
    @endif

    <hr>
    <p style="text-align:center; font-size:11px; margin-top:30px;">
        Techne Fixer Computer and Laptop Repair Services | Quotation
    </p>
</body>
</html>