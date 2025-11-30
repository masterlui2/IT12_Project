<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('partials.head', ['title' => 'Leave Feedback'])
</head>
<body class="min-h-screen bg-black text-gray-100">
    @include('partials.header')

    <main class="max-w-5xl mx-auto px-6 py-12">
        <div class="flex items-center justify-between mb-8">
            <div>
                <p class="text-sm text-blue-300 font-semibold">We appreciate your thoughts</p>
                <h1 class="text-3xl font-bold text-white mt-2">Leave a Feedback</h1>
                <p class="text-gray-400 mt-2">Tell us about your experience so we can keep improving.</p>
            </div>
        </div>

        @if (session('status'))
            <div class="mb-6 rounded-lg border border-emerald-500/40 bg-emerald-500/10 p-4 text-emerald-200">
                {{ session('status') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-6 rounded-lg border border-red-500/40 bg-red-500/10 p-4 text-red-200">
                <p class="font-semibold mb-2">Please fix the following issues:</p>
                <ul class="list-disc list-inside space-y-1 text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @guest
            <div class="mb-8 rounded-2xl border border-blue-600/40 bg-blue-900/20 p-6 shadow-lg">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div>
                        <p class="text-sm text-blue-200 font-semibold">Login required</p>
                        <p class="text-gray-200">
                            Please log in to submit your feedback so we can link it to your account.
                        </p>
                    </div>
                    <div class="flex gap-3">
                        <a
                            href="{{ route('login') }}"
                            class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-4 py-2 text-white font-semibold shadow hover:bg-blue-500 transition"
                        >
                            <i class="fas fa-sign-in-alt"></i>
                            Log in
                        </a>
                        @if (Route::has('register'))
                            <a
                                href="{{ route('register') }}"
                                class="inline-flex items-center gap-2 rounded-lg border border-blue-500/60 px-4 py-2 text-blue-200 font-semibold hover:border-blue-400 hover:text-blue-100 transition"
                            >
                                <i class="fas fa-user-plus"></i>
                                Register
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        @endguest

        <form
            method="POST"
            action="{{ route('feedback.store') }}"
            class="relative bg-gray-900/70 border border-gray-800 rounded-2xl p-8 shadow-xl space-y-8"
        >
            @csrf

            @guest
                <div class="absolute inset-0 z-10 rounded-2xl bg-black/70 backdrop-blur-sm flex items-center justify-center text-center px-6">
                    <div class="space-y-3 text-gray-200 max-w-lg">
                        <i class="fas fa-lock text-2xl text-blue-300"></i>
                        <p class="font-semibold">You need to log in to submit feedback.</p>
                        <p class="text-sm text-gray-400">
                            Please sign in so we can tie your message to your account and keep you updated.
                        </p>
                    </div>
                </div>
            @endguest

            {{-- Subject + Rating --}}
            <div class="grid gap-6 sm:grid-cols-2">
                <div class="space-y-2">
                    <label for="subject" class="block text-sm font-semibold text-gray-200">
                        Subject
                    </label>
                    <input
                        id="subject"
                        name="subject"
                        type="text"
                        value="{{ old('subject') }}"
                        placeholder="e.g., Great service on my laptop repair"
                        class="w-full rounded-lg bg-gray-800 border border-gray-700 px-4 py-3 text-gray-100 focus:border-blue-500 focus:ring-blue-500"
                        required
                    />
                </div>

                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-gray-200">
                        Rating
                    </label>
                    <div class="flex items-center gap-2">
                        @for ($i = 1; $i <= 5; $i++)
                            <button
                                type="button"
                                class="rating-star text-2xl transition-transform transform hover:scale-110"
                                data-value="{{ $i }}"
                                aria-label="Rate {{ $i }} star{{ $i > 1 ? 's' : '' }}"
                            >
                                <i class="fas fa-star"></i>
                            </button>
                        @endfor
                    </div>
                    <p class="text-xs text-gray-500" id="rating-label">
                        Click a star to select your rating.
                    </p>
                    <input type="hidden" id="rating" name="rating" value="{{ old('rating') }}">

                    @error('rating')
                        <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Feedback message --}}
            <div class="space-y-2">
                <label for="message" class="block text-sm font-semibold text-gray-200">
                    Your Feedback
                </label>
                <textarea
                    id="message"
                    name="message"
                    rows="5"
                    required
                    placeholder="Share what went well and where we can improve."
                    class="w-full rounded-lg bg-gray-800 border border-gray-700 px-4 py-3 text-gray-100 focus:border-blue-500 focus:ring-blue-500"
                >{{ old('message') }}</textarea>
            </div>

            {{-- Footer --}}
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <p class="text-sm text-gray-400 flex items-center gap-2">
                    <i class="fas fa-shield-alt text-emerald-400"></i>
                    Your feedback is securely tied to your account.
                </p>

                <button
                    type="submit"
                    class="inline-flex items-center justify-center gap-2 rounded-lg bg-blue-600 px-6 py-3 text-white font-semibold shadow-lg hover:bg-blue-500 transition-colors"
                >
                    <i class="fas fa-paper-plane"></i>
                    Submit Feedback
                </button>
            </div>
        </form>
    </main>

    @include('partials.footer')

    {{-- Star rating script --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const stars = document.querySelectorAll('.rating-star');
            const ratingInput = document.getElementById('rating');
            const ratingLabel = document.getElementById('rating-label');

            const labels = {
                1: 'Very bad',
                2: 'Bad',
                3: 'Okay',
                4: 'Good',
                5: 'Excellent'
            };

            function updateStars(value) {
                const ratingValue = parseInt(value || 0, 10);

                stars.forEach(star => {
                    const starValue = parseInt(star.dataset.value, 10);
                    const icon = star.querySelector('i');

                    if (starValue <= ratingValue) {
                        icon.classList.add('text-yellow-400');
                        icon.classList.remove('text-gray-600');
                    } else {
                        icon.classList.remove('text-yellow-400');
                        icon.classList.add('text-gray-600');
                    }
                });

                if (ratingValue > 0) {
                    ratingLabel.textContent = `${ratingValue} star${ratingValue > 1 ? 's' : ''} – ${labels[ratingValue]}`;
                } else {
                    ratingLabel.textContent = 'Click a star to select your rating.';
                }
            }

            stars.forEach(star => {
                star.addEventListener('click', () => {
                    const value = star.dataset.value;
                    ratingInput.value = value;
                    updateStars(value);
                });

                star.addEventListener('mouseenter', () => {
                    updateStars(star.dataset.value);
                });
            });

            // Reset to actual value when leaving the stars area
            const starContainer = stars[0]?.parentElement;
            if (starContainer) {
                starContainer.addEventListener('mouseleave', () => {
                    updateStars(ratingInput.value);
                });
            }

            // Initialize from old value (validation error or edit)
            if (ratingInput.value) {
                updateStars(ratingInput.value);
            } else {
                // ensure default gray color
                stars.forEach(star => {
                    star.querySelector('i').classList.add('text-gray-600');
                });
            }
        });
    </script>
</body>
</html>

<script>       
document.addEventListener('DOMContentLoaded', function() {
    const stars = document.querySelectorAll('.star');
    const ratingText = document.getElementById('rating-text');
    const ratingInput = document.getElementById('rating');
    let currentRating = parseInt(ratingInput.value) || 0;
    
    const ratingLabels = [
        "Select a rating",
        "Poor - We're sorry to hear that",
        "Fair - We appreciate your feedback",
        "Good - Glad we met your expectations",
        "Very Good - Happy to exceed expectations",
        "Excellent - Thrilled to delight you!"
    ];
    
    // Initialize stars if there's a previous rating
    if (currentRating > 0) {
        stars.forEach((s, index) => {
            if (index < currentRating) {
                s.classList.add('active');
            }
        });
        ratingText.textContent = ratingLabels[currentRating];
    }
    
    stars.forEach(star => {
        star.addEventListener('click', function() {
            const rating = parseInt(this.getAttribute('data-rating'));
            currentRating = rating;
            ratingInput.value = rating;
            
            // Update star appearance
            stars.forEach((s, index) => {
                if (index < rating) {
                    s.classList.add('active');
                } else {
                    s.classList.remove('active');
                }
            });
            
            // Update label text
            ratingText.textContent = ratingLabels[rating];
        });
        
        star.addEventListener('mouseover', function() {
            const rating = parseInt(this.getAttribute('data-rating'));
            
            // Preview hover effect
            stars.forEach((s, index) => {
                if (index < rating) {
                    s.style.color = '#fbbf24';
                } else {
                    s.style.color = '#4b5563';
                }
            });
        });
        
        star.addEventListener('mouseout', function() {
            // Restore based on current selection
            stars.forEach((s, index) => {
                if (index < currentRating) {
                    s.style.color = '#fbbf24';
                } else {
                    s.style.color = '#4b5563';
                }
            });
        });
    });
});
</script>