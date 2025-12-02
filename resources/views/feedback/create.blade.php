<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('partials.head', ['title' => 'Leave Feedback'])
</head>
<body class="min-h-screen bg-black text-gray-100">
    @include('partials.header')

    <main class="max-w-5xl mx-auto px-6 py-12">
        {{-- Page header --}}
        <div class="flex items-center justify-between mb-8">
            <div>
                <p class="text-sm text-blue-300 font-semibold">We appreciate your thoughts</p>
                <h1 class="text-3xl font-bold text-white mt-2">Leave a Feedback</h1>
                <p class="text-gray-400 mt-2">Tell us about your experience so we can keep improving.</p>
            </div>

            {{-- Button to open modal --}}
            <button
                type="button"
                id="openFeedbackModal"
                class="inline-flex items-center gap-2 rounded-lg border border-blue-500/70 bg-blue-600/20 px-4 py-2 text-blue-100 font-semibold shadow hover:bg-blue-600/30 transition"
            >
                <i class="fas fa-comment-dots"></i>
                Leave a Feedback
            </button>
        </div>

        
          {{-- Dynamic reviews from database --}}
<div class="mt-3 space-y-4">
    @forelse ($feedbacks as $feedback)
   <article class="rounded-xl border border-gray-800 bg-gray-900/70 p-4 shadow-lg">
    <div class="flex items-start justify-between gap-3">
        {{-- Avatar + name + date + category --}}
        <div class="flex items-start gap-3">
            <div class="h-9 w-9 rounded-full bg-blue-700/40 flex items-center justify-center text-xs font-semibold text-blue-100 uppercase">
                {{ strtoupper(mb_substr($feedback->customer_name, 0, 1)) }}
            </div>
            <div>
                <p class="text-sm font-semibold text-white">
                    {{ $feedback->customer_name }}
                </p>
             <p class="text-[11px] text-gray-400">
    {{ ($feedback->Date_Submitted ?? $feedback->created_at)?->format('M d, Y · h:i A') }}
</p>
<p class="text-[11px] text-gray-400">
    Service: {{ $feedback->category }}
</p>
            </div>
        </div>

     {{-- Rating (stars) --}}
@if(!is_null($feedback->rating))
    <div class="flex flex-col items-end gap-1">
        <div class="flex items-center gap-1 text-amber-400 text-xs">
            @for ($i = 1; $i <= 5; $i++)
                @if ($i <= (int) $feedback->rating)
                    <i class="fas fa-star"></i>
                @else
                    <i class="far fa-star text-gray-600"></i>
                @endif
            @endfor
        </div>
        <span class="text-[11px] text-gray-400">
            {{ number_format($feedback->rating, 1) }}/5
        </span>
    </div>
@endif

    </div>

    {{-- Message --}}
    <p class="mt-3 text-sm text-gray-300 leading-relaxed">
        {{ $feedback->message }}
    </p>
</article>

    @empty
    @endforelse
</div>
            {{-- Reviews list (vertical, Shopee-style) --}}
        <section class="mb-12 space-y-4">
            <div class="flex items-center gap-3">
                <span class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-blue-900/50 text-blue-200">
                    <i class="fas fa-users"></i>
                </span>
                <div>
                    <p class="text-sm text-blue-200 font-semibold">Community insights</p>
                    <h2 class="text-xl font-bold text-white">Recent feedback from users</h2>
                </div>
            </div>

            {{-- Static Testimonials (Hardcoded) --}}
            <div class="mt-8 border-t border-gray-800 pt-5">
                <p class="text-xs font-semibold tracking-wide text-gray-400 uppercase mb-3">
                    Highlighted customer reviews
                    </p>

                <div class="space-y-4">
                    {{-- Card 1 --}}
                    <article class="bg-gray-900 border border-gray-800 rounded-xl p-4 shadow-md">
                        <div class="flex items-start justify-between gap-3">
                            <div class="flex items-start gap-3">
                                <div class="h-9 w-9 rounded-full bg-emerald-700/30 flex items-center justify-center text-xs font-semibold text-emerald-100">
                                    K
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-white">Kristel Villame</p>
                                    <p class="text-[11px] text-gray-400">Service: Dental chair & CCTVs installation</p>
                                </div>
                            </div>
                            <div class="flex flex-col items-end gap-1">
                                <div class="flex items-center gap-1 text-yellow-400 text-xs">
                                    @for ($i = 0; $i < 5; $i++)
                                        <i class="fas fa-star"></i>
                                    @endfor
                                </div>
                                <span class="text-[11px] text-gray-400">5.0/5</span>
                            </div>
                        </div>
                        <p class="mt-3 text-sm text-gray-300 leading-relaxed">
                            "I had a great experience here, especially with Sir Pete, the owner.
                            He’s very reliable and did an excellent job fixing my tech gadgets. He also installs dental chairs,
                            CCTVs, and repairs all kinds of electronic devices. Everything is now working perfectly!
                            Highly recommended!"
                        </p>
                    </article>

                    {{-- Card 2 --}}
                    <article class="bg-gray-900 border border-gray-800 rounded-xl p-4 shadow-md">
                        <div class="flex items-start justify-between gap-3">
                            <div class="flex items-start gap-3">
                                <div class="h-9 w-9 rounded-full bg-emerald-700/30 flex items-center justify-center text-xs font-semibold text-emerald-100">
                                    A
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-white">Arnel Pajota</p>
                                    <p class="text-[11px] text-gray-400">Service: Device repair</p>
                                </div>
                            </div>
                            <div class="flex flex-col items-end gap-1">
                                <div class="flex items-center gap-1 text-yellow-400 text-xs">
                                    @for ($i = 0; $i < 4; $i++)
                                        <i class="fas fa-star"></i>
                                    @endfor
                                </div>
                                <span class="text-[11px] text-gray-400">4.0/5</span>
                            </div>
                        </div>
                        <p class="mt-3 text-sm text-gray-300 leading-relaxed">
                            “Absolutely outstanding service! I had a great experience at this shop! The staff were friendly,
                            knowledgeable, and honest with their recommendations. They fixed my device quickly and even explained
                            the problem clearly. Prices are fair, and the quality of work is top-notch. Highly recommended if
                            you're looking for reliable electronics repair in Toril, Davao City. I’ll definitely be coming back!”
                        </p>
                    </article>

                    {{-- Card 3 --}}
                    <article class="bg-gray-900 border border-gray-800 rounded-xl p-4 shadow-md">
                        <div class="flex items-start justify-between gap-3">
                            <div class="flex items-start gap-3">
                                <div class="h-9 w-9 rounded-full bg-emerald-700/30 flex items-center justify-center text-xs font-semibold text-emerald-100">
                                    X
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-white">XCL 88</p>
                                    <p class="text-[11px] text-gray-400">Service: Computer repair</p>
                                </div>
                            </div>
                            <div class="flex flex-col items-end gap-1">
                                <div class="flex items-center gap-1 text-yellow-400 text-xs">
                                    @for ($i = 0; $i < 5; $i++)
                                        <i class="fas fa-star"></i>
                                    @endfor
                                </div>
                                <span class="text-[11px] text-gray-400">5.0/5</span>
                            </div>
                        </div>
                        <p class="mt-3 text-sm text-gray-300 leading-relaxed">
                            “Explains where the problem occurred. Provides options available for resolution.”
                        </p>
                    </article>
                </div>
            </div>
        </section>
      @include('customer.FeedbackModal')
   
        </div>
    </div>

    {{-- Simple modal toggle script --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const modal = document.getElementById('feedbackModal');
            const openBtn = document.getElementById('openFeedbackModal');
            const closeBtn = document.getElementById('closeFeedbackModal');
            const cancelBtn = document.getElementById('cancelFeedbackModal');

            const openModal = () => {
                modal.classList.remove('hidden');
                modal.classList.add('flex');
            };

            const closeModal = () => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            };

            if (openBtn) openBtn.addEventListener('click', openModal);
            if (closeBtn) closeBtn.addEventListener('click', closeModal);
            if (cancelBtn) cancelBtn.addEventListener('click', closeModal);

            // Close when clicking outside content
            modal.addEventListener('click', (e) => {
                if (e.target === modal) {
                    closeModal();
                }
            });
        });
        // rating highlight
const ratingInputs  = document.querySelectorAll('.rating-input');
const ratingLabels  = document.querySelectorAll('.rating-label');

function updateRatingHighlight(value) {
    ratingLabels.forEach(label => {
        const labelValue = label.getAttribute('data-rating-label');
        if (labelValue === value) {
            label.classList.add('border-amber-400', 'bg-amber-500/10');
        } else {
            label.classList.remove('border-amber-400', 'bg-amber-500/10');
        }
    });
}

ratingInputs.forEach(input => {
    if (input.checked) {
        updateRatingHighlight(input.value);
    }

    input.addEventListener('change', () => {
        updateRatingHighlight(input.value);
    });
});

    </script>
</body>
</html>
