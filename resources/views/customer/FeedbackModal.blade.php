 {{-- Feedback Modal (UI only) --}}
    <div
        id="feedbackModal"
        class="fixed inset-0 z-40 {{ $errors->any() ? 'flex' : 'hidden' }} items-center justify-center bg-black/60 backdrop-blur-sm"
    >
        <div class="w-full max-w-lg mx-4 rounded-2xl bg-gray-900 border border-gray-800 shadow-2xl relative">
            {{-- Close button --}}
            <button
                type="button"
                id="closeFeedbackModal"
                class="absolute right-3 top-3 inline-flex h-8 w-8 items-center justify-center rounded-full bg-gray-800 text-gray-400 hover:text-white hover:bg-gray-700 text-xs"
            >
                <i class="fas fa-times"></i>
            </button>

            <div class="px-6 pt-6 pb-3 border-b border-gray-800">
                <p class="text-xs font-semibold text-blue-300 uppercase tracking-wide">Leave a review</p>
                <h3 class="text-lg font-bold text-white mt-1">Share your experience</h3>
                
            </div>

            <form
                method="POST"
                action="{{ route('feedback.store') }}"
                class="px-6 pb-6 pt-4 space-y-6"
            >
                @csrf

                {{-- If you still want to block guests later, we can add @guest logic here --}}

                {{-- Rating (Shopee-style) --}}
                <div class="space-y-3">
                    <label class="block text-sm font-semibold text-gray-200">
                        Overall rating
                    </label>
                    <p class="text-xs text-gray-400">How was your experience?</p>

                  <div class="flex flex-wrap gap-2">
    @for ($i = 5; $i >= 1; $i--)
        <label
            class="rating-label inline-flex items-center gap-2 rounded-full border border-gray-700 px-3 py-1 text-xs text-gray-200 cursor-pointer hover:border-amber-400"
            data-rating-label="{{ $i }}"
        >
            <input
                type="radio"
                name="rating"
                value="{{ $i }}"
                class="hidden rating-input"
                {{ (string) old('rating', 5) === (string) $i ? 'checked' : '' }}
            >
            <span class="flex items-center gap-1 text-amber-400">
                @for ($s = 0; $s < $i; $s++)
                    <i class="fas fa-star text-[10px]"></i>
                @endfor
            </span>
            <span>{{ $i }}</span>
        </label>
    @endfor
</div>

                </div>
             <div>
             <div>
            <div>
                   {{-- Category --}}
<div class="space-y-2">
    <label class="block text-xs font-medium text-gray-300 mb-1">
        {{ __('Category of Service') }}
    </label>
    <select name="category"
            class="w-full bg-gray-800 border border-gray-700 rounded-lg px-3 py-2 text-sm text-gray-100 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
            required>
        <option value="">{{ __('Select Category') }}</option>
        <option value="Computer / Laptop Repair" {{ old('category') == 'Computer / Laptop Repair' ? 'selected' : '' }}>Computer / Laptop Repair</option>
        <option value="Networking" {{ old('category') == 'Networking' ? 'selected' : '' }}>Networking</option>
        <option value="Printer Repair" {{ old('category') == 'Printer Repair' ? 'selected' : '' }}>Printer Repair</option>
        <option value="CCTV Installation / Repair" {{ old('category') == 'CCTV Installation / Repair' ? 'selected' : '' }}>CCTV Installation / Repair</option>
        <option value="Aircon Cleaning / Repair" {{ old('category') == 'Aircon Cleaning / Repair' ? 'selected' : '' }}>Aircon Cleaning / Repair</option>
        <option value="Other" {{ old('category') == 'Other' ? 'selected' : '' }}>Other</option>
    </select>
</div>

{{-- Message --}}
<div class="space-y-2 mt-5">
    <label for="message" class="block text-sm font-semibold text-gray-200">
        Your feedback
    </label>
    <textarea
        id="message"
        name="message"
        rows="4"
        class="w-full rounded-xl border border-gray-700 bg-black/40 px-3 py-2 text-sm text-gray-100 placeholder-gray-500 focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
        placeholder="Share details about the service, quality, and your overall experience..."
    >{{ old('message') }}</textarea>
</div>


                <div class="flex justify-end gap-2 pt-2">
                    <button
                        type="button"
                        id="cancelFeedbackModal"
                        class="inline-flex items-center gap-2 rounded-lg border border-gray-700 px-4 py-2 text-xs font-semibold text-gray-300 hover:bg-gray-800 transition"
                    >
                        Cancel
                    </button>
                    <button
                        type="submit"
                        class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-5 py-2 text-xs font-semibold text-white shadow hover:bg-blue-500 transition"
                    >
                        <i class="fas fa-paper-plane text-[11px]"></i>
                        Submit feedback
                    </button>
                </div>
            </form>