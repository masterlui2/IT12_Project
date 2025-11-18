<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;

class PdfController extends Controller
{
    public function quotationPreview(Request $request)
    {
        // Prepare images as base64
        $logoPath = public_path('images/logo.png');
        $repairServicePath = public_path('images/repair service.jpg');
        
        // Check if files exist and encode them
        $logoBase64 = '';
        if (file_exists($logoPath)) {
            $imageData = base64_encode(file_get_contents($logoPath));
            $logoBase64 = 'data:image/png;base64,' . $imageData;
        } else {
            Log::warning("Logo not found at: {$logoPath}");
        }
        
        $repairServiceBase64 = '';
        if (file_exists($repairServicePath)) {
            $imageData = base64_encode(file_get_contents($repairServicePath));
            // Detect actual image type
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mimeType = finfo_file($finfo, $repairServicePath);
            finfo_close($finfo);
            $repairServiceBase64 = 'data:' . $mimeType . ';base64,' . $imageData;
        } else {
            Log::warning("Repair service image not found at: {$repairServicePath}");
        }
        
        // Dummy data
        $data = [
            'project_title' => 'Laptop Repair and Maintenance Service',
            'client_name' => 'Juan Dela Cruz',
            'client_address' => 'Manga Street, Davao City',
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
            'deliverables' => [
                'Repaired motherboard', 
                'Cleaned system', 
                'Diagnostic report'
            ],
            'timeline' => '5-7 days',
            
            // Add base64 images to data
            'logo' => $logoBase64,
            'repair_service_image' => $repairServiceBase64,
        ];

        // Configure DomPDF to handle images properly
        $pdf = Pdf::loadView('technician.contents.quotations.pdf.pdf', $data);
        
        // Set paper size and orientation
        $pdf->setPaper('A4', 'portrait');
        
        return $pdf->stream('quotation_preview.pdf');
    }
}