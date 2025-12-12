@extends('technician.layout.app')

@section('content')

<!-- Top Bar -->
<nav class="w-full bg-white shadow-sm border-b border-gray-100 px-6 py-3 flex justify-between items-center mb-4">
  <h2 class="text-xl font-semibold text-gray-800">Messages</h2>
  <span class="text-sm text-gray-500">Connected to customers</span>
</nav>

<div class="flex h-[calc(100vh-150px)] bg-white rounded-lg shadow-sm overflow-hidden">

  @if($customerThreads->isNotEmpty())

    <!-- Left Panel -->
    <aside class="w-1/3 border-r border-gray-100 flex flex-col">

      <!-- Search -->
      <div class="p-4 border-b">
        <input 
          type="text" 
          placeholder="Search messages..." 
          class="w-full px-3 py-2 border rounded-md text-sm focus:ring-blue-500 focus:border-blue-500"
        />
      </div>

      <!-- Threads -->
      <ul class="flex-1 overflow-y-auto divide-y">
        @foreach($customerThreads as $customerId => $thread)
          <li>
            <a 
              href="{{ route('technician.messages', ['customer_id' => $customerId]) }}"
              class="block p-4 cursor-pointer transition {{ $customerId === $activeCustomerId ? 'bg-blue-50 border-l-4 border-blue-600' : 'hover:bg-blue-50' }}"
            >
              <div class="flex justify-between items-center mb-1">
                <h4 class="font-semibold text-gray-800 text-sm">
                  {{ $thread->user->name ?? trim(($thread->user->firstname ?? '') . ' ' . ($thread->user->lastname ?? '')) ?: 'Customer' }}
                </h4>

                @if($thread->latest_message?->created_at)
                  <span class="text-xs text-gray-400">
                    {{ $thread->latest_message->created_at->diffForHumans() }}
                  </span>
                @endif
              </div>

                      @php
            $latestMessage = $thread->latest_message;
            $preview = $latestMessage?->body 
              ?: ($latestMessage?->attachment_name ? 'Sent an attachment' : 'No messages yet.');
          @endphp


              <p class="text-gray-600 text-sm truncate">
                {{ Str::limit($preview, 60) }}
              </p>
            </a>
          </li>
        @endforeach
      </ul>
    </aside>

    <!-- Right Panel -->
    <section class="flex-1 flex flex-col">

      <!-- Header -->
      <div class="flex items-center justify-between p-4 border-b bg-gray-50">
        <div>
          <h3 class="font-semibold text-gray-800 text-sm">
            {{ $activeCustomer?->name 
                ?? trim(($activeCustomer->firstname ?? '') . ' ' . ($activeCustomer->lastname ?? '')) 
                ?: 'Customer conversation' }}
          </h3>

          <p class="text-xs text-gray-400">
            @if(isset($messages) && $messages->last())
              {{ optional($messages->last()->created_at)->toDayDateTimeString() }} ·
              {{ $messages->last()->user?->name ?? 'Latest activity' }}
            @else
              No messages yet
            @endif
          </p>
        </div>

        @if($activeCustomerId)
          <span class="text-xs bg-blue-100 text-blue-700 px-2 py-1 rounded-full">
            Active thread
          </span>
        @endif
      </div>

      <!-- Messages -->
      @if(isset($messages) && $messages->isNotEmpty())
      <div id="messages-container" class="flex-1 overflow-y-auto p-4 space-y-4 bg-gray-50">

        {{-- INQUIRY CARD --}}
        @if($activeInquiry)
          <div class="flex items-start space-x-3 justify-start">
            <div class="w-9 h-9 rounded-full bg-blue-600 text-white flex items-center justify-center text-xs font-semibold">
              {{ strtoupper(mb_substr($activeInquiry->name ?? ($activeCustomer?->name ?? 'C'), 0, 1)) }}
            </div>

            <div class="bg-white rounded-lg shadow px-3 py-3 max-w-2xl">
              <div class="flex items-center justify-between mb-2">
                <div>
                  <p class="text-[11px] uppercase tracking-wide text-gray-500">Inquiry</p>
                  <p class="text-xs font-semibold text-gray-800">
                    INQ-{{ str_pad($activeInquiry->id, 5, '0', STR_PAD_LEFT) }}
                  </p>
                </div>
                <span class="text-[10px] bg-emerald-100 text-emerald-700 px-2 py-1 rounded-full">
                  {{ $activeInquiry->status ?? 'Pending' }}
                </span>
              </div>

              <div class="grid gap-1 text-[11px] text-gray-700 md:grid-cols-2">
                <p><span class="text-gray-500">Name:</span> {{ $activeInquiry->name }}</p>
                <p><span class="text-gray-500">Contact:</span> {{ $activeInquiry->contact_number }}</p>
                <p><span class="text-gray-500">Email:</span> {{ $activeInquiry->email }}</p>
                <p><span class="text-gray-500">Location:</span> {{ $activeInquiry->service_location }}</p>
                <p><span class="text-gray-500">Category:</span> {{ $activeInquiry->category }}</p>

                @if($activeInquiry->preferred_schedule)
                  <p>
                    <span class="text-gray-500">Preferred:</span>
                    {{ \Carbon\Carbon::parse($activeInquiry->preferred_schedule)->format('M d, Y') }}
                  </p>
                @endif
              </div>

              <div class="mt-2">
                <p class="text-[10px] uppercase tracking-wide text-gray-500 mb-1">Issue Description</p>
                <p class="text-xs text-gray-800 leading-relaxed">
                  {{ $activeInquiry->issue_description }}
                </p>
              </div>
            </div>
          </div>
        @endif

        {{-- CHAT MESSAGES --}}
        @foreach($messages as $message)
          @php $isMine = $message->user_id === auth()->id(); @endphp

          <div class="flex mb-3 {{ $isMine ? 'justify-end' : 'justify-start' }}">

            {{-- Customer Avatar --}}
            @unless($isMine)
              <div class="mr-2 flex-shrink-0 w-8 h-8 rounded-full bg-blue-600 text-white flex items-center justify-center text-xs font-semibold">
                {{ strtoupper(mb_substr(optional($message->user)->name ?? 'C', 0, 1)) }}
              </div>
            @endunless

            <div class="max-w-md">

              {{-- Bubble --}}
              <div class="
                rounded-2xl px-3 py-2 shadow-sm
                {{ $isMine 
                    ? 'bg-blue-600 text-white rounded-br-sm ml-auto' 
                    : 'bg-white text-gray-900 rounded-bl-sm' 
                }}
              ">
                <div class="flex items-center justify-between mb-1">
                  <p class="text-xs font-semibold {{ $isMine ? 'text-blue-50' : 'text-gray-800' }}">
                    {{ $message->user->name 
                        ?? trim(($message->user->firstname ?? '') . ' ' . ($message->user->lastname ?? ''))
                        ?: 'User' }}
                  </p>

                  <span class="text-[10px] {{ $isMine ? 'text-blue-100' : 'text-gray-500' }}">
                    {{ $message->created_at->diffForHumans() }}
                  </span>
                </div>

                @if($message->body)
                  <p class="text-sm whitespace-pre-line {{ $isMine ? 'text-white' : 'text-gray-800' }}">
                    {{ $message->body }}
                  </p>
                @endif

                {{-- Image Attachment --}}
            {{-- Attachment (image or file) --}}
@if($message->attachment_path)
  @php
    $attachmentUrl = Storage::url($message->attachment_path);
    $attachmentName = $message->attachment_name ?? basename($message->attachment_path);
    $isImage = \Illuminate\Support\Str::of(strtolower($attachmentName))
        ->endsWith(['.jpg', '.jpeg', '.png', '.gif', '.webp', '.bmp']);
  @endphp

  <div class="mt-2 rounded-lg overflow-hidden border {{ $isMine ? 'border-white/20 bg-white/10' : 'border-gray-200 bg-gray-50' }}">
    @if($isImage)
      {{-- Image preview --}}
      <a href="{{ $attachmentUrl }}" target="_blank" class="block">
        <img 
          src="{{ $attachmentUrl }}"
          alt="{{ $attachmentName }}"
          class="max-h-72 w-full object-cover"
        >
      </a>
      @if($attachmentName)
        <p class="text-[11px] px-3 py-2 border-t {{ $isMine ? 'bg-white/10 text-white' : 'bg-white text-gray-700' }} truncate">
          {{ $attachmentName }}
        </p>
      @endif
    @else
      {{-- Generic file attachment --}}
      <a href="{{ $attachmentUrl }}" target="_blank" class="flex items-center gap-3 px-3 py-2 text-sm {{ $isMine ? 'text-white' : 'text-gray-800' }}">
        <div class="flex h-8 w-8 items-center justify-center rounded-md {{ $isMine ? 'bg-white/20' : 'bg-gray-200' }}">
          <i class="fas fa-file text-xs"></i>
        </div>
        <div class="flex-1">
          <p class="truncate font-medium text-xs">{{ $attachmentName }}</p>
          <p class="text-[11px] opacity-70">Download attachment</p>
        </div>
      </a>
    @endif
  </div>
@endif

              </div>

              <p class="text-[10px] mt-1 {{ $isMine ? 'text-right text-gray-300' : 'text-gray-400' }}">
                {{ ucfirst($message->user->role ?? 'customer') }}
              </p>

            </div>

            {{-- Technician Avatar --}}
            @if($isMine)
              <div class="ml-2 flex-shrink-0 w-8 h-8 rounded-full bg-gray-200 text-gray-700 flex items-center justify-center text-xs font-semibold">
                {{ strtoupper(mb_substr(optional($message->user)->name ?? 'T', 0, 1)) }}
              </div>
            @endif

          </div>
        @endforeach
      </div>

      @else
        <div class="flex-1 flex items-center justify-center text-gray-500 p-6 bg-gray-50">
          {{ $activeCustomerId ? 'No messages in this conversation yet.' : 'Select a conversation from the left to start messaging.' }}
        </div>
      @endif

    {{-- Composer --}}
@if($activeCustomerId)
<form 
  action="{{ route('messages.store') }}" 
  method="POST" 
  enctype="multipart/form-data" 
  class="sticky bottom-0 z-10 border-t bg-white px-4 md:px-6 py-4 space-y-4"
>
  @csrf
  <input type="hidden" name="customer_id" value="{{ $activeCustomerId }}">

  {{-- Message + send button row --}}
  <div class="flex flex-col md:flex-row md:items-end gap-3">
    <div class="flex-1">
      <label class="text-sm text-gray-600 block mb-1">
        Send a message to the customer
      </label>
      <textarea
        name="body"
        rows="3"
        class="w-full px-3 py-2 border rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500 resize-y"
        placeholder="Type your update or question..."
      >{{ old('body') }}</textarea>

      @error('body')
        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
      @enderror
    </div>

    {{-- Floating-ish send button --}}
    <button 
      type="submit" 
      class="shrink-0 bg-blue-600 text-white px-4 py-2 rounded-md text-sm hover:bg-blue-700 inline-flex items-center gap-2 shadow-sm md:mb-1"
    >
      <i class="fas fa-paper-plane text-xs"></i>
      <span>Send Message</span>
    </button>
  </div>

 {{-- Minimalist attachment row --}}
<div class="flex flex-wrap items-center justify-between gap-3">
  <div class="flex items-center gap-2">
    <label 
      for="attachment" 
      class="inline-flex items-center gap-2 rounded-full border border-gray-300 px-3 py-1.5 text-xs text-gray-700 cursor-pointer hover:bg-gray-50"
    >
      <i class="fas fa-paperclip text-sm"></i>
      <span>Attach file</span>
    </label>
    <input
      id="attachment"
      name="attachment"
      type="file"
      class="hidden"
    >
    @error('attachment')
      <p class="text-xs text-red-500">{{ $message }}</p>
    @enderror
  </div>

  <p class="text-[11px] text-gray-400">
    Optional · files up to 5MB
  </p>
</div>

</form>
@endif


    </section>

  @else
    <!-- No threads -->
    <div class="flex-1 flex items-center justify-center text-gray-500 p-6 bg-gray-50">
      No feedback messages yet.
    </div>
  @endif

</div>

{{-- Auto-scroll to bottom of messages --}}
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const container = document.getElementById('messages-container');
    if (container) {
      container.scrollTop = container.scrollHeight;
    }
  });
</script>

@endsection
