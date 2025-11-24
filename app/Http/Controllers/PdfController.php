<?php

namespace App\Http\Controllers;

use App\Models\Quotation;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class PdfController extends Controller
{
    /**
     * Generate PDF from quotation ID
     */
    public function quotationPreview($id = null)
    {
        // If ID is provided, load the quotation from database
        if ($id) {
            $quotation = Quotation::with([
                'customer',
                'technician',
                'details',
                'scopes.cases',
                'waivers.cases',
                'deliverables',
                'signature'
            ])->findOrFail($id);

            // Prepare data from the quotation
            $data = $this->prepareQuotationData($quotation);
        } else {
            // Use dummy data for preview/testing
            $data = $this->getDummyData();
        }

        // Add company logo and images
        $data = array_merge($data, $this->prepareImages($data));

        // Generate PDF
        $pdf = Pdf::loadView('technician.contents.quotations.pdf.pdf', $data);
        $pdf->setPaper('A4', 'portrait');
        return $pdf->stream('quotation_' . ($id ?? 'preview') . '.pdf');
    }

    /**
     * Download PDF instead of streaming
     */
    public function quotationDownload($id)
    {
        $quotation = Quotation::with([
            'customer',
            'technician',
            'details',
            'scopes.cases',
            'waivers.cases',
            'deliverables',
            'signature'
        ])->findOrFail($id);

        $data = $this->prepareQuotationData($quotation);
        $data = array_merge($data, $this->prepareImages($data));

        $pdf = Pdf::loadView('technician.contents.quotations.pdf.pdf', $data);
        $pdf->setPaper('A4', 'portrait');
        return $pdf->download('quotation_' . $quotation->id . '.pdf');
    }

    /**
     * Prepare quotation data for PDF
     */
    private function prepareQuotationData($quotation)
    {
        // Prepare items
        $items = [];
        foreach ($quotation->details as $detail) {
            $items[] = [
                'name' => $detail->item_name,
                'desc' => $detail->description ?? 'N/A',
                'qty' => $detail->quantity,
                'price' => $detail->unit_price,
                'total' => $detail->total,
            ];
        }

        // Prepare scope
        $scope = [];
        foreach ($quotation->scopes as $scopeItem) {
            $cases = [];
            foreach ($scopeItem->cases as $case) {
                $cases[] = [
                    'case' => $case->case_title,
                    'desc' => $case->case_description ?? 'N/A',
                ];
            }
            $scope[] = [
                'scenario' => $scopeItem->scenario_name,
                'cases' => $cases,
            ];
        }

        // Prepare waivers (for liability section)
        $waivers = [];
        foreach ($quotation->waivers as $waiver) {
            $waiverCases = [];
            foreach ($waiver->cases as $case) {
                $waiverCases[] = [
                    'case' => $case->case_title,
                    'desc' => $case->description ?? 'N/A',
                ];
            }
            $waivers[] = [
                'scenario' => $waiver->waiver_title,
                'cases' => $waiverCases,
            ];
        }

        // Prepare deliverables
        $deliverables = [];
        foreach ($quotation->deliverables as $deliverable) {
            $deliverables[] = $deliverable->deliverable_detail;
        }

        // Calculate timeline
        $timeline = '';
        if ($quotation->timeline_min_days && $quotation->timeline_max_days) {
            $timeline = $quotation->timeline_min_days . '-' . $quotation->timeline_max_days . ' days';
        } elseif ($quotation->timeline_min_days) {
            $timeline = $quotation->timeline_min_days . ' days';
        } else {
            $timeline = 'To be determined';
        }

        return [
            'project_title' => $quotation->project_title,
            'objective' => $quotation->objective ?? 'Not specified',
            'client_name' => $quotation->client_name,
            'client_address' => $quotation->client_address ?? 'N/A',
            'date_issued' => \Carbon\Carbon::parse($quotation->date_issued)->format('F d, Y'),
            'items' => $items,
            'subtotal' => $quotation->labor_estimate,
            'tax' => $quotation->diagnostic_fee,
            'total' => $quotation->grand_total,
            'scope' => $scope,
            'waivers' => $waivers,
            'deliverables' => $deliverables,
            'timeline' => $timeline,
            'terms_conditions' => $quotation->terms_conditions,
            'client_logo_path' => $quotation->client_logo,
        ];
    }

    /**
     * Prepare images as base64
     */
    private function prepareImages($data)
    {
        // Company logo
        $logoPath = public_path('images/logo.png');
        $logoBase64 = '';
        if (file_exists($logoPath)) {
            $imageData = base64_encode(file_get_contents($logoPath));
            $logoBase64 = 'data:image/png;base64,' . $imageData;
        } else {
            Log::warning("Logo not found at: {$logoPath}");
        }

        // Repair service image
        $repairServicePath = public_path('images/repair service.jpg');
        $repairServiceBase64 = '';
        if (file_exists($repairServicePath)) {
            $imageData = base64_encode(file_get_contents($repairServicePath));
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mimeType = finfo_file($finfo, $repairServicePath);
            finfo_close($finfo);
            $repairServiceBase64 = 'data:' . $mimeType . ';base64,' . $imageData;
        } else {
            Log::warning("Repair service image not found at: {$repairServicePath}");
        }

        // Client logo (if uploaded)
        $clientLogoBase64 = '';
        if (isset($data['client_logo_path']) && $data['client_logo_path']) {
            $clientLogoPath = storage_path('app/public/' . $data['client_logo_path']);
            if (file_exists($clientLogoPath)) {
                $imageData = base64_encode(file_get_contents($clientLogoPath));
                $finfo = finfo_open(FILEINFO_MIME_TYPE);
                $mimeType = finfo_file($finfo, $clientLogoPath);
                finfo_close($finfo);
                $clientLogoBase64 = 'data:' . $mimeType . ';base64,' . $imageData;
            }
        }

        return [
            'logo' => $logoBase64,
            'repair_service_image' => $repairServiceBase64,
            'client_logo' => $clientLogoBase64,
        ];
    }

    /**
     * Get dummy data for testing
     */
    private function getDummyData()
    {
        return [
            'project_title' => 'Laptop Repair and Maintenance Service',
            'objective' => 'Complete system diagnostics and repair',
            'client_name' => 'Juan Dela Cruz',
            'client_address' => 'Manga Street, Davao City',
            'date_issued' => \Carbon\Carbon::now()->format('F d, Y'),
            'items' => [
                [
                    'name' => 'Laptop Replacement', 
                    'desc' => 'New motherboard installed', 
                    'qty' => 1, 
                    'price' => 12500, 
                    'total' => 12500
                ],
                [
                    'name' => 'Diagnostic Fee', 
                    'desc' => 'Initial system testing', 
                    'qty' => 1, 
                    'price' => 500, 
                    'total' => 500
                ],
            ],
            'subtotal' => 13000,
            'tax' => 1300,
            'total' => 14300,
            'scope' => [
                [
                    'scenario' => 'Hardware check', 
                    'cases' => [
                        [
                            'case' => 'Motherboard check', 
                            'desc' => 'Visual and multimeter testing'
                        ]
                    ]
                ]
            ],
            'waivers' => [],
            'deliverables' => [
                'Repaired motherboard', 
                'Cleaned system', 
                'Diagnostic report'
            ],
            'timeline' => '5-7 days',
            'terms_conditions' => 'Standard terms and conditions apply.',
            'client_logo_path' => null,
        ];
    }
}