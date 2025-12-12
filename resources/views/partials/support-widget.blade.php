<div class="fixed bottom-6 right-6 z-50">
    @php
        use Illuminate\Support\Facades\Auth;
        use App\Models\Inquiry;
        use App\Models\Message;
        use Illuminate\Support\Facades\Storage;
        $supportUser = Auth::user();
        $latestInquiry = null;
        $recentMessages = collect();

        if ($supportUser) {
            $latestInquiry = Inquiry::where('customer_id', $supportUser->id)
                ->latest()
                ->first();

            $recentMessages = Message::with('user')
                ->latest()
                ->take(20)
                ->get()
                ->sortBy('created_at');
        }
    @endphp

    <div class="relative">
        <button
            id="support-widget-toggle"
            type="button"
            class="group relative flex items-center justify-center w-14 h-14 rounded-full bg-blue-600 text-white shadow-xl shadow-blue-500/30 transition-transform duration-200 hover:-translate-y-1 focus-visible:outline-none focus-visible:ring-4 focus-visible:ring-blue-200 focus-visible:ring-offset-2 focus-visible:ring-offset-transparent"
            aria-expanded="false"
            aria-controls="support-widget-panel"
            aria-label="Open customer support messages"
        >
            <span class="sr-only">Customer support</span>
            <i class="fas fa-headset text-2xl"></i>
            <span class="absolute right-full mr-3 px-3 py-1 rounded-full bg-gray-900/90 text-white text-xs font-medium opacity-0 scale-95 group-hover:opacity-100 group-hover:scale-100 transition duration-150 hidden sm:inline-block">
                Customer support
            </span>
        </button>

        <div
            id="support-widget-panel"
            class="hidden absolute bottom-16 right-0 w-[24rem] rounded-2xl bg-gray-900/95 text-white shadow-2xl shadow-black/50 backdrop-blur-lg border border-white/10"
            role="dialog"
            aria-label="Customer and technician messages"
        >
            <div class="flex items-center justify-between px-4 py-3 border-b border-white/10">
                <div>
                    <p class="text-sm uppercase tracking-wide text-blue-200">Support chat</p>
                    <p class="text-xs text-gray-300">Messages between the customer and technician</p>
                </div>
                <button
                    type="button"
                    id="support-widget-close"
                    class="p-2 rounded-full text-gray-300 hover:text-white hover:bg-white/5 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-300"
                    aria-label="Close support chat"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="size-4"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" /></svg>
                </button>
            </div>

            <div class="max-h-80 overflow-y-auto px-4 py-3 space-y-3 text-sm bg-gradient-to-b from-white/5 to-transparent">
                @guest
                    <div class="text-center text-gray-200 space-y-2">
                        <p class="font-semibold">Sign in to chat with our technicians.</p>
                        <a href="{{ route('login') }}" class="inline-flex items-center gap-2 rounded-full bg-blue-600 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-500 transition">
                            <i class="fas fa-sign-in-alt text-xs"></i>
                            Login
                        </a>
                    </div>
                @else
                    @if (! $latestInquiry)
                        <div class="text-center text-gray-200 space-y-2">
                            <p class="font-semibold">Start an inquiry to begin chatting.</p>
                            <a href="{{ route('inquiry.create') }}" class="inline-flex items-center gap-2 rounded-full bg-blue-600 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-500 transition">
                                <i class="fas fa-pen text-xs"></i>
                                Start inquiry
                            </a>
                        </div>
                    @else
                        <div class="flex items-center gap-2 text-xs text-gray-300">
                            <span class="inline-flex h-2 w-2 rounded-full bg-emerald-400"></span>
                            <span>Online</span>
                            <span class="text-gray-500">•</span>
                            <span>Status: {{ $latestInquiry->status ?? 'Pending' }}</span>
                        </div>

                        <div class="mt-2 space-y-3">
                            <div class="flex justify-end">
                                <div class="flex items-start gap-2 max-w-xs md:max-w-sm">
                                    <div class="rounded-2xl bg-white/10 px-3 py-2 shadow border border-white/10 w-full">
                                        <p class="text-[11px] uppercase tracking-wide text-gray-300">Your inquiry</p>
                                        <p class="text-xs text-white leading-relaxed">{{ $latestInquiry->issue_description ?? 'No description provided.' }}</p>
                                    </div>
                                      <div class="h-8 w-8 rounded-full bg-blue-600 flex items-center justify-center text-xs font-semibold">
                                        {{ strtoupper(mb_substr($latestInquiry->name ?? $supportUser->name ?? 'C', 0, 1)) }}
                                    </div>
                                </div>
                            </div>

                            @forelse ($recentMessages as $message)
                                @php
                                    $isMine = $message->user_id === optional(Auth::user())->id;
                                    $displayName = $isMine ? ($message->user->name ?? 'You') : ($message->user->name ?? 'Technician');
                                    $roleLabel = $message->user->role ?? ($isMine ? 'customer' : 'technician');
                                @endphp
                                <div class="flex {{ $isMine ? 'justify-end' : 'justify-start' }}">
                                      <div class="max-w-xs md:max-w-sm rounded-2xl px-3 py-2 shadow text-sm space-y-2 {{ $isMine ? 'bg-blue-500/20 border border-blue-400/50' : 'bg-white/5 border border-white/10' }}">                                        <div class="flex items-center justify-between gap-2 mb-1">
                                            <p class="font-semibold text-white text-sm">{{ $displayName }}</p>
                                            <span class="text-[11px] text-gray-400">{{ $message->created_at->diffForHumans() }}</span>
                                        </div>
  @if($message->body)
                                            <p class="text-gray-100 leading-relaxed">{{ $message->body }}</p>
                                        @endif
                                        @if($message->attachment_path)
                                            <div class="rounded-xl overflow-hidden border border-white/10 bg-black/20">
                                                <img
                                                    src="{{ Storage::url($message->attachment_path) }}"
                                                    alt="{{ $message->attachment_name ?? 'Message attachment' }}"
                                                    class="max-h-52 w-full object-cover"
                                                >
                                                @if($message->attachment_name)
                                                    <p class="text-[11px] text-gray-300 px-3 py-2 bg-black/30 border-t border-white/5">
                                                        {{ $message->attachment_name }}
                                                    </p>
                                                @endif
                                            </div>
                                        @endif
                              <p class="text-[10px] text-gray-400 mt-1">{{ ucfirst($roleLabel === 'customer' ? 'Customer' : 'Technician') }}</p>
                                    </div>
                                </div>
                            @empty
                                <p class="text-sm text-gray-300">No messages yet. Say hi to start the conversation.</p>
                            @endforelse
                        </div>
                    @endif
                @endguest
            </div>

            @auth
                @if ($latestInquiry)
 <form action="{{ route('messages.store') }}" method="POST" enctype="multipart/form-data" class="border-t border-white/10 px-4 py-3 space-y-3 bg-white/5">                        @csrf
                        <label for="widget-message" class="text-xs text-gray-300">Send a message</label>
                        <textarea
                            id="widget-message"
                            name="body"
                            rows="2"
                              class="w-full rounded-xl border border-white/15 bg-gray-950/70 text-white text-sm px-3 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none"
                            placeholder="Share updates, add details, or ask a question..."
                        ></textarea>
                          @error('body')
                            <p class="text-xs text-red-400">{{ $message }}</p>
                        @enderror
                        <div class="space-y-1">
                            <label for="widget-attachment" class="text-xs text-gray-300">Attach an image (optional)</label>
                            <input
                                id="widget-attachment"
                                name="attachment"
                                type="file"
                                accept="image/*"
                                class="block w-full text-sm text-gray-200 file:mr-3 file:rounded-md file:border-0 file:bg-blue-600 file:px-3 file:py-2 file:text-sm file:font-semibold hover:file:bg-blue-500"
                            >
                            @error('attachment')
                                <p class="text-xs text-red-400">{{ $message }}</p>
                            @enderror
                            <p class="text-[11px] text-gray-400">Upload a photo or screenshot to give more context.</p>
                        </div>
                        <div class="flex justify-end">
                              <button type="submit" class="inline-flex items-center gap-2 rounded-lg bg-blue-600 hover:bg-blue-500 px-4 py-2 text-sm font-semibold text-white transition">
                                <i class="fas fa-paper-plane text-xs"></i>
                                Send
                            </button>
                        </div>
                    </form>
                @endif
            @endauth

            @guest
                <div class="px-4 py-3 border-t border-white/10 bg-white/5 text-center text-sm text-gray-200">
                      <a href="{{ route('login') }}" class="inline-flex items-center gap-2 font-semibold text-blue-200 hover:text-white">
                        <i class="fas fa-sign-in-alt text-xs"></i>
                        Login to start chatting
                    </a>
                </div>
            @endguest
        </div>
    </div>
</div>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const toggle = document.getElementById('support-widget-toggle');
            const panel = document.getElementById('support-widget-panel');
            const close = document.getElementById('support-widget-close');

            if (!toggle || !panel) return;

            const hidePanel = () => {
                panel.classList.add('hidden');
                toggle.setAttribute('aria-expanded', 'false');
            };

            const showPanel = () => {
                panel.classList.remove('hidden');
                toggle.setAttribute('aria-expanded', 'true');
            };

            toggle.addEventListener('click', () => {
                const isOpen = toggle.getAttribute('aria-expanded') === 'true';
                if (isOpen) {
                    hidePanel();
                } else {
                    showPanel();
                }
            });

            close?.addEventListener('click', hidePanel);
        });
    </script>
@endpush