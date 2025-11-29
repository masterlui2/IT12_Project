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
            <div class="hidden sm:flex items-center gap-3 text-sm text-gray-300">
                <i class="fas fa-lock text-emerald-400"></i>
                <span>Only logged-in customers can submit feedback</span>
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

        <form method="POST" action="{{ route('feedback.store') }}" class="bg-gray-900/70 border border-gray-800 rounded-2xl p-8 shadow-xl space-y-6">
            @csrf

            <div class="grid gap-6 sm:grid-cols-2">
                <div class="space-y-2">
                    <label for="subject" class="block text-sm font-semibold text-gray-200">Subject</label>
                    <input
                        id="subject"
                        name="subject"
                        type="text"
                        value="{{ old('subject') }}"
                        placeholder="e.g., Great service on my laptop repair"
                        class="w-full rounded-lg bg-gray-800 border border-gray-700 px-4 py-3 text-gray-100 focus:border-blue-500 focus:ring-blue-500"
                    />
                </div>

                <div class="space-y-2">
                    <label for="rating" class="block text-sm font-semibold text-gray-200">Rating (optional)</label>
                    <select
                        id="rating"
                        name="rating"
                        class="w-full rounded-lg bg-gray-800 border border-gray-700 px-4 py-3 text-gray-100 focus:border-blue-500 focus:ring-blue-500"
                    >
                        <option value="">Select a rating</option>
                        @for ($i = 5; $i >= 1; $i--)
                            <option value="{{ $i }}" {{ old('rating') == $i ? 'selected' : '' }}>{{ $i }} Star{{ $i > 1 ? 's' : '' }}</option>
                        @endfor
                    </select>
                </div>
            </div>

            <div class="space-y-2">
                <label for="message" class="block text-sm font-semibold text-gray-200">Your Feedback</label>
                <textarea
                    id="message"
                    name="message"
                    rows="5"
                    required
                    placeholder="Share what went well and where we can improve."
                    class="w-full rounded-lg bg-gray-800 border border-gray-700 px-4 py-3 text-gray-100 focus:border-blue-500 focus:ring-blue-500"
                >{{ old('message') }}</textarea>
            </div>

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
</body>
</html>