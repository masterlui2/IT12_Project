@extends('layouts.guest')

@section('content')
<section class="min-h-screen bg-gray-900 text-white py-16">
    <div class="max-w-3xl mx-auto px-6">
      <div class="flex items-center gap-3 mb-6">
            <div class="h-12 w-12 rounded-xl bg-blue-500/20 border border-blue-400/30 flex items-center justify-center">
                <i class="fas fa-comments text-blue-300 text-xl"></i>
            </div>
            <div>
                <h1 class="text-3xl font-bold">Messages</h1>
                <p class="text-gray-300">Keep track of your inquiries and chat with the team.</p>
            </div>
        </div>

        @if (session('success'))
            <div class="mb-4 rounded-lg border border-green-500/40 bg-green-500/10 text-green-100 p-4 flex items-start gap-3">
                <i class="fas fa-check-circle mt-0.5"></i>
                <div>
                    <p class="font-semibold">{{ session('success') }}</p>
                    <p class="text-sm text-green-100/80">We've added your inquiry details to the chat below.</p>
                </div>
            </div>
        @endif

        @php
            $inquiryData = session('inquiry_summary') ?? ($latestInquiry ? $latestInquiry->toArray() : null);
        @endphp

        <div class="rounded-2xl border border-gray-800 bg-gradient-to-b from-gray-900/80 to-black/60 shadow-2xl">
            <div class="border-b border-gray-800/80 px-6 py-4 flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-400">Support chat</p>
                    <p class="text-lg font-semibold">Customer Messages</p>
                </div>
                <span class="rounded-full bg-emerald-500/20 text-emerald-200 text-xs px-3 py-1 border border-emerald-400/30">Online</span>
            </div>

            <div class="px-6 py-6 space-y-6">
                @if ($inquiryData)
                    <div class="space-y-4">
                        <div class="flex gap-3">
                            <div class="h-10 w-10 rounded-full bg-blue-500/20 border border-blue-400/40 flex items-center justify-center">
                                <i class="fas fa-user text-blue-200"></i>
                            </div>
                            <div class="max-w-xl">
                                <div class="rounded-2xl bg-gray-800/80 border border-gray-700 px-5 py-4 shadow-lg">
                                    <div class="flex items-center justify-between mb-2">
                                        <p class="font-semibold">You</p>
                                        <span class="text-xs text-gray-400">Inquiry sent</span>
                                    </div>
                                    <div class="space-y-2 text-sm text-gray-200">
                                        <p><span class="text-gray-400">Name:</span> {{ $inquiryData['name'] ?? 'Not provided' }}</p>
                                        <p><span class="text-gray-400">Contact:</span> {{ $inquiryData['email'] ?? '—' }} · {{ $inquiryData['contact_number'] ?? '—' }}</p>
                                        <p><span class="text-gray-400">Location:</span> {{ $inquiryData['service_location'] ?? '—' }}</p>
                                        <p><span class="text-gray-400">Category:</span> {{ $inquiryData['category'] ?? '—' }}</p>
                                        @if (!empty($inquiryData['device_details']))
                                            <p><span class="text-gray-400">Device:</span> {{ $inquiryData['device_details'] }}</p>
                                        @endif
                                        <div class="rounded-xl bg-black/30 border border-gray-700 px-4 py-3">
                                            <p class="text-gray-400 text-xs mb-1">Issue description</p>
                                            <p class="leading-relaxed">{{ $inquiryData['issue_description'] ?? 'No description provided.' }}</p>
                                        </div>
                                        <div class="flex flex-wrap gap-2 text-xs">
                                            <span class="rounded-full bg-blue-500/20 border border-blue-400/30 text-blue-100 px-3 py-1">Urgency: {{ $inquiryData['urgency'] ?? 'Normal' }}</span>
                                            @if (!empty($inquiryData['preferred_schedule']))
                                                <span class="rounded-full bg-purple-500/15 border border-purple-400/30 text-purple-100 px-3 py-1">Preferred: {{ \Illuminate\Support\Carbon::parse($inquiryData['preferred_schedule'])->format('M d, Y') }}</span>
                                            @endif
                                            <span class="rounded-full bg-amber-500/15 border border-amber-400/30 text-amber-100 px-3 py-1">Status: {{ $inquiryData['status'] ?? 'Pending' }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                 <div class="flex gap-3 justify-end">
                            <div class="max-w-xl">
                                <div class="rounded-2xl bg-blue-600/20 border border-blue-500/30 px-5 py-4 shadow-lg">
                                    <div class="flex items-center gap-2 mb-2">
                                        <div class="h-8 w-8 rounded-full bg-blue-500/40 border border-blue-300/40 flex items-center justify-center">
                                            <i class="fas fa-headset text-white"></i>
                                        </div>
                                        <p class="font-semibold">Support team</p>
                                    </div>
                                    <p class="text-sm text-gray-100 leading-relaxed">
                                        Thanks for submitting your inquiry. We've logged all the details above and will
                                        respond here once a technician is assigned. Keep this chat open for updates and feel
                                        free to share more information or photos.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="rounded-xl border border-gray-800 bg-black/30 px-5 py-6 text-center text-gray-400">
                        <i class="fas fa-inbox mb-3 text-2xl text-gray-500"></i>
                        <p class="font-semibold text-white">No messages yet</p>
                        <p class="text-sm text-gray-400">Complete an inquiry and we'll post the summary here for quick reference.</p>
                        <a href="{{ route('inquiry.create') }}" class="inline-flex mt-4 items-center gap-2 rounded-lg bg-blue-600 hover:bg-blue-500 transition px-4 py-2 text-sm font-semibold text-white">
                            <i class="fas fa-pen"></i> Start an inquiry
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection
