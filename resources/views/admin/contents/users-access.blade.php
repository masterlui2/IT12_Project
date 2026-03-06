@extends('admin.layout.app')

@section('content')

<!-- Header -->
<div class="flex items-center justify-between mb-6">
    <div class="flex items-center space-x-3">
        <div class="bg-blue-100 p-2 rounded-lg">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4m12 10H4a2 2 0 01-2-2V11h16v8a2 2 0 01-2 2z" />
            </svg>
        </div>
        <h2 class="text-xl font-semibold text-gray-800">User & Access Management</h2>
    </div>
</div>

<div class="space-y-6">

@if (session('status'))
<div class="border border-green-200 bg-green-50 text-green-700 px-4 py-3 rounded-lg text-sm">
    {{ session('status') }}
</div>
@endif

@error('password_reset')
<div class="border border-red-200 bg-red-50 text-red-700 px-4 py-3 rounded-lg text-sm">
    {{ $message }}
</div>
@enderror


<!-- Role Summary -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

<div class="bg-white rounded-xl shadow-sm border p-5">
    <p class="text-sm text-gray-500">Administrators</p>
    <p class="text-3xl font-bold text-gray-800 mt-1">{{ $roleCounts['admin'] ?? 0 }}</p>
</div>

<div class="bg-white rounded-xl shadow-sm border p-5">
    <p class="text-sm text-gray-500">Technicians</p>
    <p class="text-3xl font-bold text-gray-800 mt-1">{{ $roleCounts['technician'] ?? 0 }}</p>
</div>

<div class="bg-white rounded-xl shadow-sm border p-5">
    <p class="text-sm text-gray-500">Managers</p>
    <p class="text-3xl font-bold text-gray-800 mt-1">{{ $roleCounts['manager'] ?? 0 }}</p>
</div>

<div class="bg-white rounded-xl shadow-sm border p-5">
    <p class="text-sm text-gray-500">Clients</p>
    <p class="text-3xl font-bold text-gray-800 mt-1">{{ $roleCounts['customer'] ?? 0 }}</p>
</div>

</div>


<!-- Registered Users -->
<div class="bg-white rounded-xl shadow-sm border">

<div class="px-6 py-4 border-b">
    <h3 class="font-semibold text-gray-700">Registered Users</h3>
</div>

<div class="overflow-x-auto">
<table class="w-full text-sm">

<thead class="bg-gray-50 text-gray-600">
<tr>
<th class="px-6 py-3 text-left">ID</th>
<th class="px-6 py-3 text-left">Name</th>
<th class="px-6 py-3 text-left">Email</th>
<th class="px-6 py-3 text-left">Role</th>
<th class="px-6 py-3 text-left">Joined</th>
</tr>
</thead>

<tbody class="divide-y">

@forelse($users as $user)
<tr class="hover:bg-gray-50">

<td class="px-6 py-4 font-medium text-gray-700">
USR-{{ str_pad((string) $user->id, 4, '0', STR_PAD_LEFT) }}
</td>

<td class="px-6 py-4">
{{ $user->firstname }} {{ $user->lastname }}
</td>

<td class="px-6 py-4 text-gray-600">
{{ $user->email }}
</td>

<td class="px-6 py-4">
<span class="px-3 py-1 text-xs rounded-full bg-gray-100 text-gray-700">
{{ ucfirst($user->role) }}
</span>
</td>

<td class="px-6 py-4 text-gray-500">
{{ optional($user->created_at)->format('Y-m-d') }}
</td>

</tr>

@empty
<tr>
<td colspan="5" class="px-6 py-6 text-center text-gray-500">
No users found.
</td>
</tr>
@endforelse

</tbody>
</table>
</div>

<div class="p-4 border-t">
{{ $users->links() }}
</div>

</div>



<!-- Password Reset Requests -->
<div class="bg-white rounded-xl shadow-sm border">

<div class="px-6 py-4 border-b">
<h3 class="font-semibold text-gray-700">Password Reset Requests</h3>
<p class="text-sm text-gray-500 mt-1">
Review the user identity details carefully before resetting passwords.
</p>
</div>

<div class="overflow-x-auto">

<table class="w-full text-sm">

<thead class="bg-gray-50 text-gray-600">
<tr>
<th class="px-6 py-3 text-left">Submitted</th>
<th class="px-6 py-3 text-left">User Details</th>
<th class="px-6 py-3 text-left">Identity Proof</th>
<th class="px-6 py-3 text-left">Status</th>
<th class="px-6 py-3 text-left">Actions</th>
</tr>
</thead>

<tbody class="divide-y">

@forelse($passwordResetRequests as $requestItem)

<tr class="hover:bg-gray-50">

<td class="px-6 py-4 align-top text-gray-600">
{{ $requestItem->created_at?->format('Y-m-d H:i') }}
</td>

<td class="px-6 py-4 align-top">
<div class="font-medium text-gray-800">
{{ $requestItem->firstname }} {{ $requestItem->lastname }}
</div>

<div class="text-gray-600 text-sm">
{{ $requestItem->email }}
</div>

<div class="text-xs text-gray-500">
Birthday: {{ $requestItem->birthday?->format('Y-m-d') }}
</div>
</td>

<td class="px-6 py-4 text-gray-700 align-top">
{{ $requestItem->proof_details ?: '—' }}
</td>

<td class="px-6 py-4 align-top">
<span class="px-3 py-1 text-xs rounded-full bg-blue-50 text-blue-700">
{{ ucfirst(str_replace('_',' ',$requestItem->status)) }}
</span>
</td>

<td class="px-6 py-4 align-top space-y-3 min-w-[320px]">

@if($requestItem->status === 'pending')

<form method="POST" action="{{ route('admin.password-reset-requests.reset', $requestItem) }}" class="space-y-2 border rounded-lg p-3 bg-gray-50">
@csrf

<input type="password" name="password" placeholder="New password"
class="w-full border-gray-300 rounded text-sm" required>

<input type="password" name="password_confirmation" placeholder="Confirm password"
class="w-full border-gray-300 rounded text-sm" required>

<textarea name="admin_notes" rows="2"
placeholder="Admin verification notes"
class="w-full border-gray-300 rounded text-sm"></textarea>

<button class="w-full bg-green-600 text-white text-xs py-2 rounded hover:bg-green-700">
Verify & Reset
</button>

</form>


<form method="POST" action="{{ route('admin.password-reset-requests.reject', $requestItem) }}" class="space-y-2 border rounded-lg p-3 bg-gray-50">
@csrf

<textarea name="admin_notes" rows="2"
placeholder="Reason for rejection"
class="w-full border-gray-300 rounded text-sm"
required></textarea>

<button class="w-full bg-red-600 text-white text-xs py-2 rounded hover:bg-red-700">
Reject Request
</button>

</form>

@else

<div class="text-xs text-gray-600">
Reviewed by: {{ optional($requestItem->reviewer)->email ?? 'N/A' }}
</div>

<div class="text-xs text-gray-600">
Notes: {{ $requestItem->admin_notes ?: '—' }}
</div>

@endif

</td>

</tr>

@empty

<tr>
<td colspan="5" class="px-6 py-8 text-center text-gray-500">
No password reset requests found.
</td>
</tr>

@endforelse

</tbody>
</table>

</div>

<div class="p-4 border-t">
{{ $passwordResetRequests->links() }}
</div>

</div>

</div>

@endsection