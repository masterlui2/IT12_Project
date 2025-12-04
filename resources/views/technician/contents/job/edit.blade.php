@extends('technician.layout.app')

@section('content')

<form action="{{ route('technician.job.update', $job->id) }}" method="POST" id="jobOrderForm">
    @csrf
    @method('PATCH')

    <div class="bg-white rounded-xl shadow-sm border p-8 space-y-8">

        <!-- Validation Messages -->
        @if ($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg">
                <strong>Please fix the following errors:</strong>
                <ul class="mt-2 list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg">
                {{ session('error') }}
            </div>
        @endif

        <!-- Header -->
        <div class="flex justify-between items-center border-b pb-3">
            <div>
                <h1 class="text-xl font-bold text-gray-800">Techne Fixer Computer and Laptop Repair Services</h1>
                <p class="text-sm text-gray-500">007 Manga Street Crossing Bayabas, Davao City</p>
                <p class="text-sm text-gray-500">Contact No: 09662406825  TIN 618‑863‑736‑000000</p>
            </div>
            <img src="{{ asset('images/logo.png') }}" class="w-20 h-20 object-contain" alt="Company Logo">
        </div>

        <!-- Basic Information -->
        <div class="bg-gray-50 border rounded-md p-4 grid sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm text-gray-600">Job Order #</label>
                <p class="mt-1 text-sm font-semibold text-gray-800">JO‑{{ str_pad($job->id, 5, '0', STR_PAD_LEFT) }}</p>
            </div>

            <div>
                <label class="block text-sm text-gray-600">Client Name</label>
                <input type="text" name="customer_name"
                       value="{{ old('customer_name', $job->customer_name) }}"
                       class="w-full border mt-1 rounded-md px-3 py-2 text-sm focus:ring-blue-500 focus:border-blue-500">
            </div>

            <div>
                <label class="block text-sm text-gray-600">Contact Number</label>
                <input type="text" name="contact_number"
                       value="{{ old('contact_number', $job->contact_number) }}"
                       class="w-full border mt-1 rounded-md px-3 py-2 text-sm focus:ring-blue-500 focus:border-blue-500">
            </div>

            <div>
                <label class="block text-sm text-gray-600">Device Type</label>
                <input type="text" name="device_type"
                       value="{{ old('device_type', $job->device_type) }}"
                       class="w-full border mt-1 rounded-md px-3 py-2 text-sm focus:ring-blue-500 focus:border-blue-500">
            </div>
        </div>

        <!-- Issue Description -->
        <div>
            <label class="block text-sm font-semibold mb-2 text-gray-700">Issue Description</label>
            <textarea rows="3" name="issue_description"
                      class="w-full border rounded-md px-3 py-2 text-sm focus:ring-blue-500 focus:border-blue-500">{{ old('issue_description', $job->issue_description) }}</textarea>
        </div>

        <!-- Cost Breakdown -->
        <div class="grid sm:grid-cols-3 gap-4 bg-gray-50 border rounded-md p-4">
            <div>
                <label class="block text-sm text-gray-600 mb-1">Diagnostic Fee (₱)</label>
                <input type="number" name="diagnostic_fee" step="0.01"
                       value="{{ old('diagnostic_fee', $job->diagnostic_fee) }}"
                       class="w-full border rounded-md px-3 py-2 text-sm focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div>
                <label class="block text-sm text-gray-600 mb-1">Materials Cost (₱)</label>
                <input type="number" name="materials_cost" step="0.01"
                       value="{{ old('materials_cost', $job->materials_cost) }}"
                       class="w-full border rounded-md px-3 py-2 text-sm focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div>
                <label class="block text-sm text-gray-600 mb-1">Professional Fee (₱)</label>
                <input type="number" name="professional_fee" step="0.01"
                       value="{{ old('professional_fee', $job->professional_fee) }}"
                       class="w-full border rounded-md px-3 py-2 text-sm focus:ring-blue-500 focus:border-blue-500">
            </div>
        </div>

        <!-- Timeline / Status -->
        <div class="grid sm:grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-sm text-gray-600 mb-1">Expected Finish Date</label>
                <input type="date" name="expected_finish_date"
                       value="{{ old('expected_finish_date', $job->expected_finish_date?->format('Y‑m‑d')) }}"
                       class="border rounded-md w-full px-3 py-2 text-sm focus:ring-blue-500 focus:border-blue-500" />
            </div>

            <div>
                <label class="block text-sm text-gray-600 mb-1">Status</label>
                <select name="status"
                        class="border rounded-md w-full px-3 py-2 text-sm focus:ring-blue-500 focus:border-blue-500">
                    @foreach(['scheduled','in_progress','completed','cancelled'] as $status)
                        <option value="{{ $status }}" @selected(old('status', $job->status) === $status)>
                            {{ ucfirst(str_replace('_', ' ', $status)) }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- Technician Notes -->
        <div>
            <label class="block text-sm font-semibold mb-2 text-gray-700">Technician Notes / Progress</label>
            <textarea rows="4" name="technician_notes"
                      class="w-full border rounded-md px-3 py-2 text-sm focus:ring-blue-500 focus:border-blue-500">{{ old('technician_notes', $job->technician_notes) }}</textarea>
        </div>

        <!-- Remarks -->
        <div>
            <label class="block text-sm font-semibold mb-2 text-gray-700">Remarks / Completion Summary</label>
            <textarea rows="3" name="remarks"
                      class="w-full border rounded-md px-3 py-2 text-sm focus:ring-blue-500 focus:border-blue-500">{{ old('remarks', $job->remarks) }}</textarea>
        </div>

        <!-- Action buttons -->
        <div class="flex justify-end space-x-3 border-t pt-4">
            <a href="{{ route('technician.job.index') }}">
                <button type="button"
                        class="px-4 py-2 border rounded-md text-gray-600 text-sm hover:bg-gray-100 shadow-sm">
                    Cancel
                </button>
            </a>
            <button type="submit"
                    class="px-4 py-2 bg-green-600 text-white rounded-md text-sm hover:bg-green-700">
                Update Job Order
            </button>
        </div>

        <p class="text-center text-[11px] text-gray-500 mt-8 border-t pt-2">
            Techne Fixer Computer and Laptop Repair Services | Job Order Update
        </p>
    </div>
</form>

@endsection
