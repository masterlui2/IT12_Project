@extends('technician.layout.app')

@section('content')

<!-- Header -->
<div class="mb-8">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-semibold text-gray-900">Inquiries</h1>
            <p class="text-gray-500 text-sm mt-1">Manage and respond to customer inquiries</p>
        </div>
        
        <a href="{{ route('technician.inquire.create') }}" 
           class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2.5 rounded-lg text-sm font-medium transition-colors">
            <i class="fas fa-plus text-xs"></i>
            New Inquiry
        </a>
    </div>
</div>

<!-- Search and Filter Bar -->
<div class="mb-6 bg-white rounded-xl border border-gray-200 p-4">
    <div class="flex flex-col md:flex-row md:items-center gap-4">
        <div class="relative flex-1">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <i class="fas fa-search text-gray-400"></i>
            </div>
            <input 
                type="text" 
                placeholder="Search inquiries by client, topic, or ID..."
                class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-100 focus:border-blue-500 outline-none transition"
            />
        </div>
        
        <div class="flex items-center gap-3">
            <select class="px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-100 focus:border-blue-500 outline-none transition w-40">
                <option value="">All Status</option>
                <option value="new">New</option>
                <option value="open">Open</option>
                <option value="responded">Responded</option>
                <option value="closed">Closed</option>
            </select>
            
            <select class="px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-100 focus:border-blue-500 outline-none transition w-40">
                <option value="">All Urgency</option>
                <option value="Normal">Normal</option>
                <option value="Urgent">Urgent</option>
                <option value="Flexible">Flexible</option>
            </select>
        </div>
    </div>
</div>

<!-- Inquiries Table -->
<div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
    <!-- Table Header -->
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr class="text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b border-gray-200">
                    <th class="px-6 py-4">Inquiry</th>
                    <th class="px-6 py-4">Client</th>
                    <th class="px-6 py-4">Category</th>
                    <th class="px-6 py-4">Technician</th>
                    <th class="px-6 py-4">Status</th>
                    <th class="px-6 py-4 text-right">Date</th>
                    <th class="px-6 py-4 text-right w-40">Actions</th>
                </tr>
            </thead>
            
            <tbody class="divide-y divide-gray-100">
                @forelse($inquiries as $inq)
                <tr class="hover:bg-gray-50 transition-colors group">
                    <!-- Inquiry Details -->
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            </div>
                            <div>
                                <div class="font-medium text-gray-900 text-sm">
                                    INQ-{{ str_pad($inq->id, 5, '0', STR_PAD_LEFT) }}
                                </div>
                                @if($inq->subject)
                                <div class="text-xs text-gray-500 truncate max-w-[200px] mt-0.5">
                                    {{ Str::limit($inq->subject, 40) }}
                                </div>
                                @endif
                            </div>
                        </div>
                    </td>

                    <!-- Client Info -->
                    <td class="px-6 py-4">
                        <div class="font-medium text-gray-900 text-sm">
                            {{ $inq->name ?? 'Customer #'.$inq->user_id }}
                        </div>
                        @if($inq->contact_number)
                        <div class="text-xs text-gray-500 flex items-center gap-1 mt-0.5">
                            <i class="fas fa-phone text-xs opacity-60"></i>
                            <span>{{ $inq->contact_number }}</span>
                        </div>
                        @endif
                    </td>

                    <!-- Category -->
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                            {{ $inq->category ?? '—' }}
                        </span>
                    </td>

                    <!-- Technician -->
                    <td class="px-6 py-4">
                        @if ($inq->technician)
                            @if($inq->technician->user_id === auth()->id())
                            <div class="flex items-center gap-2">
                                <div class="w-6 h-6 bg-green-100 rounded-full flex items-center justify-center text-green-700 text-xs font-medium">
                                    <i class="fas fa-user text-xs"></i>
                                </div>
                                <span class="text-sm text-green-700 font-medium">You</span>
                            </div>
                            @else
                            <div class="flex items-center gap-2">
                                <div class="w-6 h-6 bg-blue-100 rounded-full flex items-center justify-center text-blue-700 text-xs font-medium">
                                    {{ substr($inq->technician->name, 0, 1) }}
                                </div>
                                <span class="text-sm text-gray-700">{{ $inq->technician->name }}</span>
                            </div>
                            @endif
                        @else
                        <span class="text-sm text-gray-500">Unassigned</span>
                        @endif
                    </td>

                    <!-- Status & Urgency -->
                    <td class="px-6 py-4">
                        <div class="space-y-1.5">
                            @php
                                $status = $inq->status ?? 'new';
                                $statusColors = [
                                    'new' => 'bg-blue-100 text-blue-700 border border-blue-200',
                                    'open' => 'bg-yellow-100 text-yellow-700 border border-yellow-200',
                                    'responded' => 'bg-green-100 text-green-700 border border-green-200',
                                    'closed' => 'bg-gray-100 text-gray-700 border border-gray-200',
                                ];
                                $statusColor = $statusColors[$status] ?? 'bg-gray-100 text-gray-700';
                            @endphp
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium capitalize {{ $statusColor }}">
                                {{ $status }}
                            </span>
                        </div>
                    </td>

                    <!-- Date -->
                    <td class="px-6 py-4 text-right">
                        <div class="text-sm text-gray-900">{{ $inq->created_at?->format('M d, Y') }}</div>
                        <div class="text-xs text-gray-500">{{ $inq->created_at?->format('h:i A') }}</div>
                    </td>

                    <!-- Simplified Actions -->
                    <td class="px-6 py-4 text-right">
                        <div class="flex items-center justify-end gap-1.5">
                            <!-- Primary Action Button -->
                            @if(!$inq->technician)
                            <form action="{{ route('technician.inquire.claim', $inq->id) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" 
                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-amber-50 hover:bg-amber-100 text-amber-700 hover:text-amber-800 rounded-lg text-xs font-medium border border-amber-200 transition-colors">
                                    <i class="fas fa-hand-paper text-xs"></i>
                                    Claim
                                </button>
                            </form>
                            @elseif($inq->technician && $inq->technician->user_id === auth()->id())
                            <div class="flex items-center gap-1.5">
                                <a href="{{ route('quotation.new', ['inquiry' => $inq->id]) }}" 
                                   class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-emerald-50 hover:bg-emerald-100 text-emerald-700 hover:text-emerald-800 rounded-lg text-xs font-medium border border-emerald-200 transition-colors">
                                    <i class="fas fa-file-invoice-dollar text-xs"></i>
                                    Quote
                                </a>
                            </div>
                            @endif

                            <!-- View Button (Always Visible) -->
                            <a href="{{ route('technician.inquire.show', $inq->id) }}" 
                               class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-gray-50 hover:bg-gray-100 text-gray-700 hover:text-gray-900 rounded-lg text-xs font-medium border border-gray-200 transition-colors">
                                <i class="fas fa-eye text-xs"></i>
                                View
                            </a>

                            <!-- Actions Dropdown (for less important actions) -->
                            <div class="relative inline-block text-left">
                                <button type="button" 
                                        class="w-8 h-8 flex items-center justify-center rounded-lg text-gray-400 hover:text-gray-600 hover:bg-gray-100 transition-colors"
                                        onclick="toggleDropdown('dropdown-{{ $inq->id }}')">
                                    <i class="fas fa-ellipsis-h"></i>
                                </button>
                                
                                <div id="dropdown-{{ $inq->id }}" 
                                     class="hidden absolute right-0 mt-1 w-40 bg-white rounded-lg shadow-lg border border-gray-200 py-1 z-10">
                                    @if($inq->technician && $inq->technician->user_id === auth()->id())
                                   
                                    @endif
                                    
                                    
                                    
                                    <form action="{{ route('technician.inquire.destroy', $inq->id) }}" method="POST" 
                                          onsubmit="return confirm('Delete inquiry INQ-{{ $inq->id }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                                            <i class="fas fa-trash mr-2"></i> Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-16 text-center">
                        <div class="text-gray-400 mb-3">
                            <i class="fas fa-inbox text-4xl"></i>
                        </div>
                        <p class="text-gray-500 text-sm">No inquiries found</p>
                        <p class="text-gray-400 text-xs mt-1">Create your first inquiry to get started</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Footer -->
    <div class="border-t border-gray-200">
        <div class="px-6 py-4 flex flex-col sm:flex-row sm:items-center sm:justify-between text-sm text-gray-600">
            <div class="mb-3 sm:mb-0">
                <span class="font-medium text-gray-700">{{ $inquiries->total() }}</span> inquiries total
                <span class="mx-2">•</span>
                <span class="text-amber-600 font-medium">
                    {{ $inquiries->whereIn('status', ['new', 'open'])->count() }}
                </span> pending
            </div>
            
            @if($inquiries->hasPages())
            <div>
                {{ $inquiries->links() }}
            </div>
            @endif
        </div>
    </div>
</div>

<style>
    /* Dropdown animation */
    [id^="dropdown-"] {
        animation: fadeIn 0.1s ease-out;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-5px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>

<script>
    function toggleDropdown(id) {
        const dropdown = document.getElementById(id);
        dropdown.classList.toggle('hidden');
        
        // Close other dropdowns
        document.querySelectorAll('[id^="dropdown-"]').forEach(other => {
            if (other.id !== id && !other.classList.contains('hidden')) {
                other.classList.add('hidden');
            }
        });
    }
    
    // Close dropdown when clicking outside
    document.addEventListener('click', function(event) {
        if (!event.target.closest('.relative.text-left')) {
            document.querySelectorAll('[id^="dropdown-"]').forEach(dropdown => {
                dropdown.classList.add('hidden');
            });
        }
    });
</script>

@endsection