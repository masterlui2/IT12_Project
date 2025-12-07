@extends('layouts.guest')

@section('content')
<section class="min-h-screen bg-slate-950 text-slate-50 py-10">
    <div class="max-w-4xl mx-auto px-4">

        {{-- Page header --}}
        <div class="flex items-center gap-3 mb-2">

            {{-- LOGO --}}
            <div class="h-11 w-11 flex items-center justify-center">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-full w-full object-contain">
            </div>

            <div>
                <h1 class="text-2xl font-semibold">Messages</h1>
                <p class="text-sm text-slate-400">
                    View your inquiry and chat with our team in one place.
                </p>
            </div>

        </div>

        {{-- Return Home button --}}
        <div class="mb-4 flex justify-end">
            <a href="{{ url('/') }}"
               class="inline-flex items-center gap-2 rounded-lg border border-gray-700 px-4 py-2 text-sm font-medium text-gray-200 hover:border-emerald-500 hover:text-emerald-300 transition-colors">
                ← {{ __('Return Home') }}
            </a>
        </div>

    
        @if (session('success'))
            <div class="mb-4 rounded-xl border border-emerald-500/40 bg-emerald-500/10 text-emerald-100 px-4 py-3 flex items-start gap-3">
                <i class="fas fa-check-circle mt-0.5 text-sm"></i>
                <div>
                    <p class="font-medium text-sm">{{ session('success') }}</p>
                    <p class="text-xs text-emerald-100/80">
                        Your inquiry has been logged. You’ll see updates in the chat below.
                    </p>
                </div>
            </div>
        @endif

        @php
            $inquiryData = session('inquiry_summary') ?? ($latestInquiry ? $latestInquiry->toArray() : null);
        @endphp

        {{-- Messenger style card --}}
        <div class="bg-slate-900 border border-slate-800 rounded-2xl shadow-xl flex flex-col h-[70vh]">
            {{-- Chat header --}}
            <div class="px-5 py-3 border-b border-slate-800 flex items-center justify-between">
                <div>
                    <p class="text-xs uppercase tracking-wide text-slate-400">Support chat</p>
                    <p class="text-sm font-semibold">Customer & Technician Conversation</p>
                </div>
                <div class="flex items-center gap-2 text-xs">
                    <span class="inline-flex h-2 w-2 rounded-full bg-emerald-400"></span>
                    <span class="text-emerald-200">Online</span>
                </div>
            </div>

            {{-- Single scrollable conversation area --}}
            <div class="flex-1 overflow-y-auto px-4 sm:px-5 py-4 space-y-4">

                {{-- If no inquiry yet, show empty state --}}
                @if (!$inquiryData)
                    <div class="flex justify-center items-center h-full">
                        <div class="text-center max-w-sm">
                            <div class="h-11 w-11 rounded-full bg-slate-800 mx-auto flex items-center justify-center mb-3">
                                <i class="fas fa-inbox text-slate-400 text-lg"></i>
                            </div>
                            <p class="font-medium text-sm mb-1">No messages yet</p>
                            <p class="text-xs text-slate-400 mb-3">
                                Submit an inquiry to start a conversation with our team. We’ll keep everything in this chat.
                            </p>
                            <a href="{{ route('inquiry.create') }}"
                               class="inline-flex items-center gap-2 rounded-full bg-blue-600 hover:bg-blue-500 px-4 py-2 text-xs font-semibold text-white transition">
                                <i class="fas fa-pen text-[11px]"></i>
                                Start an inquiry
                            </a>
                        </div>
                    </div>
                @else
                    {{-- Inquiry card: CUSTOMER message (right side) --}}
                    <div class="flex justify-end">
                        <div class="flex items-start gap-2 max-w-xl">
                            {{-- Inquiry bubble --}}
                            <div class="rounded-2xl bg-blue-600/20 border border-blue-500/40 px-4 py-3 w-full shadow">
                                <div class="flex items-center justify-between mb-2">
                                    <p class="text-xs font-semibold text-slate-50">Your inquiry</p>
                                    <span class="text-[10px] text-slate-200/80">
                                        Status: {{ $inquiryData['status'] ?? 'Pending' }}
                                    </span>
                                </div>

                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-4 gap-y-1 text-[11px] text-slate-50">
                                    <p>
                                        <span class="text-slate-300">Name:</span>
                                        {{ $inquiryData['name'] ?? 'Not provided' }}
                                    </p>
                                    <p>
                                        <span class="text-slate-300">Contact:</span>
                                        {{ $inquiryData['email'] ?? '—' }} · {{ $inquiryData['contact_number'] ?? '—' }}
                                    </p>
                                    <p>
                                        <span class="text-slate-300">Location:</span>
                                        {{ $inquiryData['service_location'] ?? '—' }}
                                    </p>
                                    <p>
                                        <span class="text-slate-300">Category:</span>
                                        {{ $inquiryData['category'] ?? '—' }}
                                    </p>
                                    @if (!empty($inquiryData['device_details']))
                                        <p class="sm:col-span-2">
                                            <span class="text-slate-300">Device:</span>
                                            {{ $inquiryData['device_details'] }}
                                        </p>
                                    @endif
                                </div>

                                <div class="mt-3 rounded-xl bg-slate-950/40 border border-blue-500/30 px-3 py-2.5">
                                    <p class="text-[10px] uppercase tracking-wide text-slate-300 mb-1">
                                        Issue description
                                    </p>
                                    <p class="text-[11px] leading-relaxed text-slate-50">
                                        {{ $inquiryData['issue_description'] ?? 'No description provided.' }}
                                    </p>
                                </div>

                                <div class="mt-3 flex flex-wrap gap-2 text-[10px]">
                                    <span class="rounded-full bg-blue-500/20 border border-blue-400/60 text-blue-100 px-3 py-1">
                                        Urgency: {{ $inquiryData['urgency'] ?? 'Normal' }}
                                    </span>
                                    @if (!empty($inquiryData['preferred_schedule']))
                                        <span class="rounded-full bg-purple-500/20 border border-purple-400/60 text-purple-100 px-3 py-1">
                                            Preferred:
                                            {{ \Illuminate\Support\Carbon::parse($inquiryData['preferred_schedule'])->format('M d, Y') }}
                                        </span>
                                    @endif
                                </div>
                            </div>

                            {{-- Customer avatar on the right --}}
                            <div class="h-8 w-8 rounded-full bg-blue-600 flex items-center justify-center">
                                <span class="text-[11px] text-white font-semibold">
                                    {{ strtoupper(mb_substr($inquiryData['name'] ?? 'C', 0, 1)) }}
                                </span>
                            </div>
                        </div>
                    </div>

                    {{-- Auto-support message: TECHNICIAN on the left --}}
                    <div class="flex justify-start">
                        <div class="flex items-start gap-2 max-w-xl">
                            <div class="h-8 w-8 rounded-full bg-blue-500/20 flex items-center justify-center">
                                <i class="fas fa-headset text-[13px] text-blue-200"></i>
                            </div>
                            <div class="rounded-2xl bg-slate-800 border border-slate-700 px-4 py-2.5">
                                <p class="text-xs font-semibold text-slate-100 mb-0.5">Technician</p>
                                <p class="text-xs text-slate-200 leading-relaxed">
                                    Thanks for submitting your inquiry. We’ve logged your details and will update you here
                                    once a technician is assigned. You can also send more information or photos anytime.
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- Conversation messages --}}
                    @forelse($messages as $message)
                        @php
                            $isMine = $message->user_id === auth()->id();
                            $displayName = $isMine
                                ? ($message->user->name ?? 'You')
                                : ($message->user->name ?? 'Technician');

                            $roleLabel = $message->user->role
                                ?? ($isMine ? 'customer' : 'technician');
                        @endphp

                        <div class="flex {{ $isMine ? 'justify-end' : 'justify-start' }}">
                            <div class="max-w-xl rounded-2xl px-4 py-3 shadow
                                {{ $isMine ? 'bg-blue-600/30 border border-blue-500/40' : 'bg-slate-800/80 border border-slate-700' }}">
                                <div class="flex items-center justify-between gap-3 mb-1">
                                    <p class="text-sm font-semibold text-white">
                                        {{ $displayName }}
                                    </p>
                                    <span class="text-[11px] text-slate-400">
                                        {{ $message->created_at->diffForHumans() }}
                                    </span>
                                </div>
                                <p class="text-sm text-slate-100 leading-relaxed">
                                    {{ $message->body }}
                                </p>
                                <p class="text-[10px] text-slate-400 mt-1">
                                    {{ ucfirst($roleLabel === 'customer' ? 'Customer' : 'Technician') }}
                                </p>
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-slate-400">
                            No messages yet. Start the conversation below.
                        </p>
                    @endforelse
                @endif
            </div>

            {{-- Composer (only if an inquiry exists) --}}
            @if ($inquiryData)
                <form
                    action="{{ route('messages.store') }}"
                    method="POST"
                    class="border-t border-slate-800 px-4 sm:px-5 py-3 space-y-2 bg-slate-900/95"
                >
                    @csrf
                    <label for="body" class="text-xs text-slate-300">Send a message</label>
                    <textarea
                        id="body"
                        name="body"
                        rows="3"
                        class="w-full rounded-xl border border-slate-700 bg-slate-950/70 text-slate-50 text-sm px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                        placeholder="Share updates, add details, or ask a question..."
                        required
                    >{{ old('body') }}</textarea>

                    @error('body')
                        <p class="text-xs text-red-400">{{ $message }}</p>
                    @enderror

                    <div class="flex justify-end">
                        <button
                            type="submit"
                            class="inline-flex items-center gap-2 rounded-lg bg-blue-600 hover:bg-blue-500 px-4 py-2 text-sm font-semibold text-white transition"
                        >
                            <i class="fas fa-paper-plane text-xs"></i>
                            Send
                        </button>
                    </div>
                </form>
            @endif
        </div>
    </div>
</section>
@endsection
