<?php

namespace App\Http\Controllers\Technician\Quotation;

use App\Models\Quotation;
use App\Models\QuotationDetail;
use App\Models\QuotationScope;
use App\Models\QuotationCase;
use App\Models\QuotationWaiver;
use App\Models\WaiverCase;
use App\Models\QuotationDeliverable;
use App\Models\User;
use App\Models\QuotationSignature;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Technician;
use Illuminate\Support\Facades\Auth;

class QuotationController extends Controller
{
    /**
     * Display a listing of quotations
     */
    public function index(Request $request)
    {
        $query = Quotation::with(['customer', 'technician']);

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('client_name', 'like', "%{$search}%")
                  ->orWhere('project_title', 'like', "%{$search}%")
                  ->orWhere('id', 'like', "%{$search}%");
            });
        }

        // Status filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Sorting
        switch ($request->get('sort', 'recent')) {
            case 'oldest':
                $query->oldest();
                break;
            case 'amount_high':
                $query->orderBy('grand_total', 'desc');
                break;
            case 'amount_low':
                $query->orderBy('grand_total', 'asc');
                break;
            default: // recent
                $query->latest();
                break;
        }

        $quotations = $query->paginate(15)->withQueryString();

        return view('technician.contents.quotations.index', compact('quotations'));
    }

    /**
     * Show the form for creating a new quotation
     */
    public function newQuotation()
    {
        return view('technician.contents.quotations.create');
    }

    /**
     * Store a newly created quotation
     */
    public function store(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'project_title' => 'required|string|max:255',
            'client_name' => 'required|string|max:255',
            'date_issued' => 'required|date',
            'client_address' => 'nullable|string|max:500',
            'objective' => 'nullable|string',
            'client_logo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            
            // Items validation
            'items' => 'required|array|min:1',
            'items.*.name' => 'required|string|max:255',
            'items.*.description' => 'nullable|string',
            'items.*.quantity' => 'required|numeric|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
            
            // Timeline
            'timeline_min_days' => 'nullable|integer|min:1',
            'timeline_max_days' => 'nullable|integer|min:1',
            
            // Terms
            'terms_conditions' => 'nullable|string',
            
            // Signature fields
            'customer_name' => 'nullable|string|max:255',
            'customer_signature' => 'nullable|string|max:255',
            'customer_date' => 'nullable|date',
            'provider_name' => 'nullable|string|max:255',
            'provider_signature' => 'nullable|string|max:255',
            'provider_date' => 'nullable|date',
        ]);

        try {
            DB::beginTransaction();

            // Determine status based on action
            $status = $request->action === 'draft' ? 'draft' : 'pending';

            // Calculate totals
            $subtotal = 0;
            foreach ($request->items as $item) {
                $subtotal += $item['quantity'] * $item['unit_price'];
            }
            $tax = $subtotal * 0.10;
            $total = $subtotal + $tax;

            $customer = Customer::first();
            $technician = Technician::first();
            // Create the main quotation
            $quotation = Quotation::create([
                'customer_id' => $customer->id,
                'technician_id' => $technician->id,
                'project_title' => $validated['project_title'],
                'date_issued' => $validated['date_issued'],
                'client_name' => $validated['client_name'],
                'client_address' => $validated['client_address'] ?? null,
                'objective' => $validated['objective'] ?? null,
                'timeline_min_days' => $request->timeline_min_days,
                'timeline_max_days' => $request->timeline_max_days,
                'terms_conditions' => $request->terms_conditions,
                'labor_estimate' => $subtotal,
                'diagnostic_fee' => $tax,
                'grand_total' => $total,
                'status' => $status,
            ]);

            // Handle client logo upload
            if ($request->hasFile('client_logo')) {
                $path = $request->file('client_logo')->store('logos', 'public');
                $quotation->update(['client_logo' => $path]);
            }

            // Create quotation items
            foreach ($request->items as $item) {
                $itemTotal = $item['quantity'] * $item['unit_price'];
                
                QuotationDetail::create([
                    'quotation_id' => $quotation->id,
                    'item_name' => $item['name'],
                    'description' => $item['description'] ?? null,
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unit_price'],
                    'total' => $itemTotal,
                ]);
            }

            // Create scope scenarios and their cases
            if ($request->has('scope')) {
                foreach ($request->scope as $scopeData) {
                    if (!empty($scopeData['scenario'])) {
                        $scope = QuotationScope::create([
                            'quotation_id' => $quotation->id,
                            'scenario_name' => $scopeData['scenario'],
                            'description' => null,
                        ]);

                        // Create cases for this scenario
                        if (isset($scopeData['cases']) && is_array($scopeData['cases'])) {
                            foreach ($scopeData['cases'] as $caseData) {
                                if (!empty($caseData['name'])) {
                                    QuotationCase::create([
                                        'scope_id' => $scope->id,
                                        'case_title' => $caseData['name'],
                                        'case_description' => $caseData['description'] ?? null,
                                    ]);
                                }
                            }
                        }
                    }
                }
            }

            // Create waiver scenarios and their cases
            if ($request->has('waiver')) {
                foreach ($request->waiver as $waiverData) {
                    if (!empty($waiverData['scenario'])) {
                        $waiver = QuotationWaiver::create([
                            'quotation_id' => $quotation->id,
                            'waiver_title' => $waiverData['scenario'],
                            'waiver_description' => null,
                        ]);

                        // Create cases for this waiver
                        if (isset($waiverData['cases']) && is_array($waiverData['cases'])) {
                            foreach ($waiverData['cases'] as $caseData) {
                                if (!empty($caseData['name'])) {
                                    WaiverCase::create([
                                        'waiver_id' => $waiver->id,
                                        'case_title' => $caseData['name'],
                                        'description' => $caseData['description'] ?? null,
                                    ]);
                                }
                            }
                        }
                    }
                }
            }

            // Create deliverables
            if ($request->has('deliverables')) {
                foreach ($request->deliverables as $deliverable) {
                    if (!empty($deliverable['detail'])) {
                        QuotationDeliverable::create([
                            'quotation_id' => $quotation->id,
                            'deliverable_detail' => $deliverable['detail'],
                        ]);
                    }
                }
            }

            // Create signature record
            if ($request->filled(['customer_name', 'provider_name'])) {
                QuotationSignature::create([
                    'quotation_id' => $quotation->id,
                    'customer_name' => $request->customer_name,
                    'customer_signature' => $request->customer_signature,
                    'customer_date' => $request->customer_date,
                    'provider_name' => $request->provider_name,
                    'provider_signature' => $request->provider_signature,
                    'provider_date' => $request->provider_date,
                ]);
            }

            DB::commit();

            // Redirect based on action
            if ($request->action === 'generate_pdf') {
                return redirect()->route('quotation.pdf', $quotation->id)
                    ->with('success', 'Quotation created successfully!');
            }

            return redirect()->route('quotation.show', $quotation->id)
                ->with('success', 'Quotation saved as draft successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            
            return back()
                ->withInput()
                ->with('error', 'Failed to create quotation: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified quotation
     */
    public function show($id)
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

        return view('technician.contents.quotations.show', compact('quotation'));
    }

    /**
     * Show the form for editing the specified quotation
     */
    public function edit($id)
    {
        $quotation = Quotation::with([
            'details',
            'scopes.cases',
            'waivers.cases',
            'deliverables',
            'signature'
        ])->findOrFail($id);

        // Only allow editing drafts
        if ($quotation->status !== 'draft') {
            return redirect()->route('quotation.show', $id)
                ->with('error', 'Only draft quotations can be edited.');
        }

        return view('technician.contents.quotations.edit', compact('quotation'));
    }

    /**
     * Update the specified quotation
     */
    public function update(Request $request, $id)
    {
        $quotation = Quotation::findOrFail($id);

        // Only allow updating drafts
        if ($quotation->status !== 'draft') {
            return redirect()->route('quotation.show', $id)
                ->with('error', 'Only draft quotations can be updated.');
        }

        // Validation (same as store)
        $validated = $request->validate([
            'project_title' => 'required|string|max:255',
            'client_name' => 'required|string|max:255',
            'date_issued' => 'required|date',
            'client_address' => 'nullable|string|max:500',
            'objective' => 'nullable|string',
            'client_logo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'items' => 'required|array|min:1',
            'items.*.name' => 'required|string|max:255',
            'items.*.description' => 'nullable|string',
            'items.*.quantity' => 'required|numeric|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
        ]);

        try {
            DB::beginTransaction();

            // Update quotation
            $status = $request->action === 'draft' ? 'draft' : 'pending';
            
            // Recalculate totals
            $subtotal = 0;
            foreach ($request->items as $item) {
                $subtotal += $item['quantity'] * $item['unit_price'];
            }
            $tax = $subtotal * 0.10;
            $total = $subtotal + $tax;

            $quotation->update([
                'project_title' => $validated['project_title'],
                'date_issued' => $validated['date_issued'],
                'client_name' => $validated['client_name'],
                'client_address' => $request->client_address,
                'objective' => $request->objective,
                'timeline_min_days' => $request->timeline_min_days,
                'timeline_max_days' => $request->timeline_max_days,
                'terms_conditions' => $request->terms_conditions,
                'labor_estimate' => $subtotal,
                'diagnostic_fee' => $tax,
                'grand_total' => $total,
                'status' => $status,
            ]);

            // Handle logo update
            if ($request->hasFile('client_logo')) {
                // Delete old logo
                if ($quotation->client_logo) {
                    Storage::disk('public')->delete($quotation->client_logo);
                }
                $path = $request->file('client_logo')->store('logos', 'public');
                $quotation->update(['client_logo' => $path]);
            }

            // Delete and recreate all related records
            $quotation->details()->delete();
            $quotation->scopes()->delete();
            $quotation->waivers()->delete();
            $quotation->deliverables()->delete();

            // Recreate items
            foreach ($request->items as $item) {
                $itemTotal = $item['quantity'] * $item['unit_price'];
                QuotationDetail::create([
                    'quotation_id' => $quotation->id,
                    'item_name' => $item['name'],
                    'description' => $item['description'] ?? null,
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unit_price'],
                    'total' => $itemTotal,
                ]);
            }

            // Recreate scopes
            if ($request->has('scope')) {
                foreach ($request->scope as $scopeData) {
                    if (!empty($scopeData['scenario'])) {
                        $scope = QuotationScope::create([
                            'quotation_id' => $quotation->id,
                            'scenario_name' => $scopeData['scenario'],
                        ]);

                        if (isset($scopeData['cases'])) {
                            foreach ($scopeData['cases'] as $caseData) {
                                if (!empty($caseData['name'])) {
                                    QuotationCase::create([
                                        'scope_id' => $scope->id,
                                        'case_title' => $caseData['name'],
                                        'case_description' => $caseData['description'] ?? null,
                                    ]);
                                }
                            }
                        }
                    }
                }
            }

            // Recreate waivers
            if ($request->has('waiver')) {
                foreach ($request->waiver as $waiverData) {
                    if (!empty($waiverData['scenario'])) {
                        $waiver = QuotationWaiver::create([
                            'quotation_id' => $quotation->id,
                            'waiver_title' => $waiverData['scenario'],
                        ]);

                        if (isset($waiverData['cases'])) {
                            foreach ($waiverData['cases'] as $caseData) {
                                if (!empty($caseData['name'])) {
                                    WaiverCase::create([
                                        'waiver_id' => $waiver->id,
                                        'case_title' => $caseData['name'],
                                        'description' => $caseData['description'] ?? null,
                                    ]);
                                }
                            }
                        }
                    }
                }
            }

            // Recreate deliverables
            if ($request->has('deliverables')) {
                foreach ($request->deliverables as $deliverable) {
                    if (!empty($deliverable['detail'])) {
                        QuotationDeliverable::create([
                            'quotation_id' => $quotation->id,
                            'deliverable_detail' => $deliverable['detail'],
                        ]);
                    }
                }
            }

            DB::commit();

            if ($request->action === 'generate_pdf') {
                return redirect()->route('quotation.pdf', $quotation->id);
            }

            return redirect()->route('quotation.show', $quotation->id)
                ->with('success', 'Quotation updated successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Failed to update: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified quotation
     */
    public function destroy($id)
    {
        try {
            $quotation = Quotation::findOrFail($id);
            
            // Delete logo if exists
            if ($quotation->client_logo) {
                Storage::disk('public')->delete($quotation->client_logo);
            }
            
            $quotation->delete();

            return redirect()->route('technician.quotation')
                ->with('success', 'Quotation deleted successfully!');
                
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to delete quotation: ' . $e->getMessage());
        }
    }

    /**
     * Upload or update client logo
     */
    public function uploadLogo(Request $request)
    {
        $request->validate([
            'logo' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'quotation_id' => 'nullable|exists:quotations,id'
        ]);

        try {
            $path = $request->file('logo')->store('logos', 'public');

            if ($request->quotation_id) {
                $quotation = Quotation::findOrFail($request->quotation_id);
                
                // Delete old logo
                if ($quotation->client_logo) {
                    Storage::disk('public')->delete($quotation->client_logo);
                }
                
                $quotation->update(['client_logo' => $path]);
            }

            return response()->json([
                'success' => true,
                'path' => $path,
                'url' => Storage::url($path)
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to upload logo: ' . $e->getMessage()
            ], 500);
        }
    }
}