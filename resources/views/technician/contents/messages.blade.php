@extends('technician.layout.app')

@section('content')

<!-- Top Bar -->
<nav class="w-full bg-white shadow-sm border-b border-gray-100 px-6 py-3 flex justify-between items-center mb-4">
  <h2 class="text-xl font-semibold text-gray-800">Messages</h2>
  <span class="text-sm text-gray-500">Connected to customers</span>
</nav>

<div class="flex h-[calc(100vh-180px)] bg-white rounded-lg shadow-sm overflow-hidden">

  @if($customerThreads->isNotEmpty())

    <!-- Left Panel (Inbox List) -->
    <aside class="w-1/3 border-r border-gray-100 flex flex-col">
      <!-- Search -->
      <div class="p-4 border-b">
        <input 
          type="text" 
          placeholder="Search messages..." 
          class="w-full px-3 py-2 border rounded-md text-sm focus:ring-blue-500 focus:border-blue-500"
        />
      </div>

      <!-- Thread List -->
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
              <p class="text-gray-600 text-sm truncate">
                {{ Str::limit($thread->latest_message->body ?? 'No messages yet.', 60) }}
              </p>
            </a>
          </li>
        @endforeach
      </ul>
    </aside>

    <!-- Right Panel (Chat / Message View) -->
    <section class="flex-1 flex flex-col">

      <!-- Conversation Header -->
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

      <!-- Messages Area -->
      @if(isset($messages) && $messages->isNotEmpty())
        <div class="flex-1 overflow-y-auto p-4 space-y-4 bg-gray-50">

          {{-- Inquiry card as a "message" from the customer --}}
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
                  <p>
                    <span class="text-gray-500">Name:</span>
                    {{ $activeInquiry->name ?? ($activeCustomer?->name ?? 'Customer') }}
                  </p>
                  <p>
                    <span class="text-gray-500">Contact:</span>
                    {{ $activeInquiry->contact_number ?? '—' }}
                  </p>
                  <p>
                    <span class="text-gray-500">Email:</span>
                    {{ $activeInquiry->email ?? '—' }}
                  </p>
                  <p>
                    <span class="text-gray-500">Location:</span>
                    {{ $activeInquiry->service_location ?? '—' }}
                  </p>
                  <p>
                    <span class="text-gray-500">Category:</span>
                    {{ $activeInquiry->category ?? 'General' }}
                  </p>

                  @if(!empty($activeInquiry->preferred_schedule))
                    <p>
                      <span class="text-gray-500">Preferred:</span>
                      {{ \Illuminate\Support\Carbon::parse($activeInquiry->preferred_schedule)->format('M d, Y') }}
                    </p>
                  @endif
                </div>

                <div class="mt-2">
                  <p class="text-[10px] uppercase tracking-wide text-gray-500 mb-1">Issue Description</p>
                  <p class="text-xs text-gray-800 leading-relaxed">
                    {{ $activeInquiry->issue_description ?? 'No description provided.' }}
                  </p>
                </div>
              </div>
            </div>
          @endif

          {{-- Normal messages --}}
          @foreach($messages as $message)
            @php $isMine = $message->user_id === auth()->id(); @endphp

            <div class="flex items-start space-x-3 {{ $isMine ? 'justify-end text-right' : 'justify-start' }}">
              @unless($isMine)
                <div class="w-9 h-9 rounded-full bg-blue-600 text-white flex items-center justify-center text-xs font-semibold">
                  {{ strtoupper(mb_substr(optional($message->user)->name ?? 'C', 0, 1)) }}
                </div>
              @endunless

              <div class="bg-white rounded-lg shadow px-3 py-2 max-w-2xl {{ $isMine ? 'ml-auto border border-blue-100' : '' }}">
                <div class="flex items-center justify-between gap-3 mb-1">
                  <p class="text-xs font-semibold text-gray-800">
                    {{ $message->user->name 
                        ?? trim(($message->user->firstname ?? '') . ' ' . ($message->user->lastname ?? '')) 
                        ?: 'User' }}
                  </p>
                  <span class="text-[10px] text-gray-500">
                    {{ optional($message->created_at)->diffForHumans() }}
                  </span>
                </div>
                <p class="text-sm text-gray-700 whitespace-pre-line">
                  {{ $message->body }}
                </p>
                <p class="text-[10px] text-gray-500 mt-1">
                  {{ ucfirst($message->user->role ?? 'customer') }}
                </p>
              </div>

              @if($isMine)
                <div class="w-9 h-9 rounded-full bg-gray-200 text-gray-700 flex items-center justify-center text-xs font-semibold">
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

      <!-- Composer -->
      @if($activeCustomerId)
        <form action="{{ route('messages.store') }}" method="POST" class="p-4 border-t bg-white space-y-2">
          @csrf
          <input type="hidden" name="customer_id" value="{{ $activeCustomerId }}">

          <label for="body" class="text-sm text-gray-600">Send a message to the customer</label>
          <textarea
            id="body"
            name="body"
            rows="3"
            class="w-full px-3 py-2 border rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500"
            placeholder="Type your update or question..."
            required
          >{{ old('body') }}</textarea>

          @error('body')
            <p class="text-xs text-red-500">{{ $message }}</p>
          @enderror

          <div class="flex justify-end">
            <button 
              type="submit" 
              class="bg-blue-600 text-white px-4 py-2 rounded-md text-sm hover:bg-blue-700 inline-flex items-center gap-2"
            >
              <i class="fas fa-paper-plane"></i>
              Send Message
            </button>
          </div>
        </form>
      @endif

    </section>

  @else
    <!-- No threads at all -->
    <div class="flex-1 flex items-center justify-center text-gray-500 p-6 bg-gray-50">
      No feedback messages yet.
    </div>
  @endif

</div>

@endsection
