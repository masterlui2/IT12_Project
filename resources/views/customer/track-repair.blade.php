@extends('layouts.guest')

@section('content')
<section class="min-h-screen bg-gray-900 text-white py-16">
    <div class="max-w-3xl mx-auto px-6">
        <h1 class="text-3xl font-bold mb-4">Track Your Repair</h1>
        <p class="text-gray-300 mb-6">
            Here you’ll be able to see the status of your ongoing repairs and quotations.
        </p>

        <div class="rounded-xl border border-gray-700 bg-black/40 p-6">
            <p class="text-sm text-gray-400">
                No tracking data yet. Once you have an active job, it will appear here.
            </p>
        </div>
    </div>
</section>
@endsection
