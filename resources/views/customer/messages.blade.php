@extends('layouts.guest')

@section('content')
<section class="min-h-screen bg-gray-900 text-white py-16">
    <div class="max-w-3xl mx-auto px-6">
        <h1 class="text-3xl font-bold mb-4">Messages</h1>
        <p class="text-gray-300 mb-6">
            This is where you and your technician/manager will be able to communicate about your repairs.
        </p>

        <div class="rounded-xl border border-gray-700 bg-black/40 p-6">
            <p class="text-sm text-gray-400">
                No messages yet. Once a conversation is started, it will show up here.
            </p>
        </div>
    </div>
</section>
@endsection
