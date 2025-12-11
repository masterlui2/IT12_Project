@extends('technician.layout.app')

@section('content')

<div class="bg-white rounded-xl shadow-sm border p-8 space-y-8 w-full">

    {{-- Header --}}
    <div class="flex justify-between items-center border-b pb-3">
        <div>
            <h1 class="text-xl font-bold text-gray-800">Inquiry Details</h1>
            <p class="text-sm text-gray-500">Techne Fixer Service Management</p>
        </div>
        <img src="{{ asset('images/logo.png') }}" class="w-16 h-16 object-contain" alt="Company Logo">
    </div>

    {{-- Inquiry summary --}}
    <div class="bg-blue-50 border border-blue-200 text-blue-700 rounded-md p-4">
        <p class="text-sm">
            <strong>Inquiry ID:</strong> INQ‑{{ str_pad($inquiry->id, 5, '0', STR_PAD_LEFT) }} <br>
            <strong>Customer:</strong> {{ $inquiry->name ?? $inquiry->customer->name }}<br>
            <strong>Contact:</strong> {{ $inquiry->contact_number ?? 'N/A' }}<br>
            <strong>Email:</strong> {{ $inquiry->email ?? 'N/A' }}<br>
            <strong>Service Location:</strong> {{ $inquiry->service_location ?? 'N/A' }}
        </p>
    </div>

    {{-- Category & Details --}}
    <div class="grid sm:grid-cols-2 gap-6 bg-gray-50 border rounded-md p-4">
        <div>
            <label class="block text-sm text-gray-600">Category</label>
            <p class="mt-1 text-gray-900 font-medium">{{ $inquiry->category ?? '—' }}</p>
        </div>

        <div>
            <label class="block text-sm text-gray-600">Device Details</label>
            <p class="mt-1 text-gray-900">{{ $inquiry->device_details ?? 'Not provided' }}</p>
        </div>

        <div>
            <label class="block text-sm text-gray-600">Urgency Level</label>
            <span class="inline-flex px-3 py-1 rounded text-xs font-medium
                @if($inquiry->urgency == 'Urgent') bg-red-100 text-red-700
                @elseif($inquiry->urgency == 'Flexible') bg-blue-100 text-blue-700
                @else bg-amber-100 text-amber-700 @endif">
                {{ $inquiry->urgency ?? 'Normal' }}
            </span>
        </div>

        <div>
            <label class="block text-sm text-gray-600">Preferred Schedule</label>
            <p class="mt-1 text-gray-900 font-medium">
                {{ $inquiry->preferred_schedule ?? 'No preferred date provided' }}
            </p>
        </div>
    </div>

    {{-- Issue Description --}}
    <div>
        <h3 class="text-sm text-gray-700 font-semibold mb-2">Problem / Issue Description</h3>
        <p class="text-gray-800 whitespace-pre-line border rounded-md bg-gray-50 p-4">
            {{ $inquiry->issue_description ?? 'No issue description provided.' }}
        </p>
    </div>

    {{-- Attached Photo --}}
    @if($inquiry->photo_path)
        <div>
            <h3 class="text-sm text-gray-700 font-semibold mb-2">Attached Photo</h3>
            <img src="{{ asset('storage/'.$inquiry->photo_path) }}"
                 class="w-48 h-auto border rounded-lg shadow-sm" alt="Issue Photo">
        </div>
    @endif

    {{-- Assignment / Status --}}
    <div class="grid sm:grid-cols-2 gap-6 bg-gray-50 border rounded-md p-4">
        <div>
            <label class="block text-sm text-gray-600">Status</label>
            <span class="inline-block mt-1 px-3 py-1 rounded text-xs font-medium
                @if($inquiry->status === 'Pending') bg-yellow-100 text-yellow-700
                @elseif($inquiry->status === 'Acknowledged') bg-blue-100 text-blue-700
                @elseif($inquiry->status === 'In Progress') bg-indigo-100 text-indigo-700
                @elseif($inquiry->status === 'Completed') bg-green-100 text-green-700
                @elseif($inquiry->status === 'Cancelled') bg-gray-100 text-gray-600
                @endif">
                {{ $inquiry->status ?? 'Pending' }}
            </span>
        </div>

        <div>
            <label class="block text-sm text-gray-600">Assigned Technician</label>
            @if($inquiry->assignedTechnician)
                <p class="mt-1 text-gray-900 font-medium">{{ $inquiry->assignedTechnician->firstname }}</p>
            @else
                <p class="mt-1 text-gray-500 italic">No technician assigned yet.</p>
            @endif
        </div>
    </div>

    {{-- Admin / Technician Notes (if any) --}}
    @if($inquiry->admin_notes)
        <div>
            <label class="block text-sm text-gray-700 font-semibold mb-2">Admin / Technician Notes</label>
            <p class="text-gray-800 bg-gray-50 border rounded-md p-3 whitespace-pre-line">
                {{ $inquiry->admin_notes }}
            </p>
        </div>
    @endif

    {{-- Actions --}}
    <div class="flex justify-end space-x-3 border-t pt-4">
        <a href="{{ route('technician.inquire.index') }}">
            <button type="button" class="px-4 py-2 border rounded-md text-sm text-gray-600 hover:bg-gray-100 transition">
                Back to List
            </button>
        </a>
        @if(!$inquiry->assignedTechnician)
            <form action="{{ route('technician.inquire.claim', $inquiry->id) }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md text-sm hover:bg-blue-700">
                    Claim Inquiry
                </button>
            </form>
        @endif
    </div>
</div>

@endsection
