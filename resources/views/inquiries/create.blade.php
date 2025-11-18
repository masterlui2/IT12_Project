{{-- resources/views/inquiries/create.blade.php --}}
@extends('layouts.guest')

@section('content')
<section class="min-h-screen bg-gray-900 text-white py-16">
    <div class="max-w-5xl mx-auto px-6">
        <!-- Landscape card -->
        <div class="bg-black/40 backdrop-blur-lg border border-gray-800 rounded-2xl shadow-2xl overflow-hidden">
            <div class="grid md:grid-cols-2">
                
                {{-- Left side: logo + intro --}}
                <div class="relative p-8 md:p-10 flex flex-col justify-between border-b md:border-b-0 md:border-r border-gray-800">
                    <div>
                        <div class="flex items-center gap-3 mb-6">
                            <img src="{{ asset('images/logo.png') }}" 
                                 alt="Logo"
                                 class="h-14 w-14 object-contain">
                            <div>
                                <h1 class="text-xl font-bold tracking-tight">
                                    Techne Fixer
                                </h1>
                                <p class="text-xs text-gray-400">
                                    Computer • Gadgets • Aircon • CCTV • More
                                </p>
                            </div>
                        </div>

                        <h2 class="text-2xl font-bold mb-3">
                            {{ __('Need help? Submit an Inquiry') }}
                        </h2>
                     
                    </div>

                    <div class="mt-8 text-xs text-gray-500">
                        <p>✔ {{ __('Fast response from our team') }}</p>
                        <p>✔ {{ __('Trusted and professional service') }}</p>
                        <p>✔ {{ __('For home and business customers') }}</p>
                    </div>
                </div>

                {{-- Right side: form --}}
                <div class="p-8 md:p-10 bg-gray-900/70">
                    @if(session('success'))
                        <div class="mb-4 rounded-lg border border-emerald-500 bg-emerald-500/10 px-4 py-2 text-sm text-emerald-300">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('inquiry.store') }}" class="space-y-4">
                        @csrf

                        {{-- Full Name --}}
                        <div>
                            <label class="block text-xs font-medium text-gray-300 mb-1">
                                {{ __('Full Name') }}
                            </label>
                            <input type="text" 
                                   name="name"
                                   class="w-full bg-gray-800 border border-gray-700 rounded-lg px-3 py-2 text-sm text-gray-100 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                                   value="{{ old('name', auth()->user()->name ?? '') }}"
                                   required>
                        </div>

                        {{-- Contact Number --}}
                        <div>
                            <label class="block text-xs font-medium text-gray-300 mb-1">
                                {{ __('Contact Number') }}
                            </label>
                            <input type="text" 
                                   name="contact_number"
                                   placeholder="0917 123 4567"
                                   class="w-full bg-gray-800 border border-gray-700 rounded-lg px-3 py-2 text-sm text-gray-100 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                                   required>
                        </div>

                        {{-- Category of Service --}}
                        <div>
                            <label class="block text-xs font-medium text-gray-300 mb-1">
                                {{ __('Category of Service') }}
                            </label>
                            <select name="category"
                                    class="w-full bg-gray-800 border border-gray-700 rounded-lg px-3 py-2 text-sm text-gray-100 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                                    required>
                                <option value="">{{ __('Select Category') }}</option>
                                <option value="Computer / Laptop Repair">Computer / Laptop Repair</option>
                                <option value="Networking">Networking</option>
                                <option value="Printer Repair">Printer Repair</option>
                                <option value="CCTV Installation / Repair">CCTV Installation / Repair</option>
                                <option value="Aircon Cleaning / Repair">Aircon Cleaning / Repair</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>

                        {{-- Issue Description --}}
                        <div>
                            <label class="block text-xs font-medium text-gray-300 mb-1">
                                {{ __('Issue Description') }}
                            </label>
                            <textarea name="issue_description"
                                      rows="4"
                                      class="w-full bg-gray-800 border border-gray-700 rounded-lg px-3 py-2 text-sm text-gray-100 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                                      placeholder="Describe the issue in detail…"
                                      required>{{ old('issue_description') }}</textarea>
                        </div>

                        {{-- Preferred Schedule --}}
                        <div>
                            <label class="block text-xs font-medium text-gray-300 mb-1">
                                {{ __('Preferred Date / Time (optional)') }}
                            </label>
                            <input type="datetime-local"
                                   name="preferred_schedule"
                                   class="w-full bg-gray-800 border border-gray-700 rounded-lg px-3 py-2 text-sm text-gray-100 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                        </div>

                        <button type="submit"
                                class="w-full mt-2 bg-emerald-600 hover:bg-emerald-500 transition-colors px-4 py-2.5 rounded-lg text-sm font-semibold text-white text-center">
                            {{ __('Send Inquiry') }}
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </div>
</section>
@endsection
