@extends('admin.layout.app')

@section('content')


<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div class="flex items-center space-x-3">
            <div class="bg-blue-100 p-2 rounded-lg">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4m12 10H4a2 2 0 01-2-2V11h16v8a2 2 0 01-2 2z" />
                </svg>
            </div>
            <div>
                <h2 class="text-xl font-semibold text-gray-800">User & Access Management</h2>
                <p class="text-sm text-gray-500">Manage user roles and verify password recovery requests.</p>
            </div>
        </div>
    </div>

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


       <div class="bg-white rounded-xl shadow-sm border overflow-hidden">
        <div class="px-6 py-4 border-b">
            <h3 class="font-semibold text-gray-700">Password Reset Requests</h3>
            <p class="text-sm text-gray-500 mt-1">
                Review user identity details carefully before processing account recovery.
            </p>
        </div>
         <div class="px-6 py-3 bg-slate-50/70 border-b text-xs text-slate-600">
            Pending requests require review before a reset email update is sent to the requester.
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
               <thead class="bg-gray-50 text-gray-600 uppercase tracking-wide text-xs">
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
                                                <tr class="hover:bg-slate-50/70 align-top">
                            <td class="px-6 py-4 align-top text-gray-600">
                                  <p class="font-medium text-gray-700">{{ $requestItem->created_at?->format('M d, Y') }}</p>
                                <p class="text-xs text-gray-500">{{ $requestItem->created_at?->format('h:i A') }}</p>
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

                         <td class="px-6 py-4 text-gray-700 align-top max-w-xs">
                                @if($requestItem->proof_details)
                                    <p class="text-sm leading-relaxed text-gray-700">{{ $requestItem->proof_details }}</p>
                                @else
                                    <span class="inline-flex items-center rounded-full bg-gray-100 px-2.5 py-1 text-xs text-gray-600">No additional proof submitted</span>
                                @endif
                            </td>

                            <td class="px-6 py-4 align-top">
                                <span class="px-3 py-1 text-xs rounded-full font-medium
                                    {{ $requestItem->status === 'pending' ? 'bg-amber-50 text-amber-700' : '' }}
                                    {{ $requestItem->status === 'approved' ? 'bg-green-50 text-green-700' : '' }}
                                    {{ $requestItem->status === 'rejected' ? 'bg-rose-50 text-rose-700' : '' }}">
                                    {{ ucfirst(str_replace('_',' ',$requestItem->status)) }}
                                </span>
                            </td>

                            <td class="px-6 py-4 align-top min-w-[160px]">
                                @if($requestItem->status === 'pending')
                                    <div class="flex items-center gap-2">
                                        <button type="button"
                                            class="inline-flex h-9 w-9 items-center justify-center rounded-lg bg-green-50 text-green-700 hover:bg-green-100"
                                            title="Reset Password"
                                            data-modal-open="password-request-modal"
                                            data-modal-action="reset"
                                            data-reset-url="{{ route('admin.password-reset-requests.reset', $requestItem) }}"
                                            data-user="{{ $requestItem->firstname }} {{ $requestItem->lastname }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 10-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                            </svg>
                                        </button>

                                        <button type="button"
                                            class="inline-flex h-9 w-9 items-center justify-center rounded-lg bg-red-50 text-red-700 hover:bg-red-100"
                                            title="Reject Request"
                                            data-modal-open="password-request-modal"
                                            data-modal-action="reject"
                                            data-reject-url="{{ route('admin.password-reset-requests.reject', $requestItem) }}"
                                            data-user="{{ $requestItem->firstname }} {{ $requestItem->lastname }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm-2.293-9.707a1 1 0 011.414 0L10 9.172l.879-.879a1 1 0 111.414 1.414L11.414 10l.879.879a1 1 0 11-1.414 1.414L10 10.828l-.879.879a1 1 0 01-1.414-1.414L8.586 10l-.879-.879a1 1 0 010-1.414z" clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    </div>
                                @else
                                    <div class="text-xs text-gray-600">
                                        Reviewed by: {{ optional($requestItem->reviewer)->email ?? 'N/A' }}
                                    </div>

                                    <div class="text-xs text-gray-600 mt-1">
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


<div id="password-request-modal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50 p-4">
 <div class="bg-white w-full max-w-lg rounded-xl shadow-xl overflow-hidden">
        <div class="px-5 py-4 border-b flex items-center justify-between">
            <h4 id="modal-title" class="font-semibold text-gray-800">Process Request</h4>
            <button type="button" class="text-gray-400 hover:text-gray-600" data-modal-close="password-request-modal">✕</button>
        </div>


                <form id="password-request-form" method="POST" class="p-5 space-y-4">
            @csrf
            <p id="modal-description" class="text-sm text-gray-600"></p>
            <div class="rounded-lg border border-blue-100 bg-blue-50 px-3 py-2 text-xs text-blue-700">
                Make sure notes clearly explain the verification decision for audit and user support follow-up.
            </div>


            <div id="password-fields" class="space-y-3 hidden">
                  <div>
                    <label for="modal-password" class="mb-1 block text-xs font-medium text-gray-700">New Password</label>
                    <input type="password" name="password" id="modal-password" placeholder="Minimum 8 characters" class="w-full rounded-lg border-gray-300 text-sm focus:border-blue-500 focus:ring-blue-500" minlength="8">
                </div>
                <div>
                    <label for="modal-password-confirmation" class="mb-1 block text-xs font-medium text-gray-700">Confirm Password</label>
                    <input type="password" name="password_confirmation" id="modal-password-confirmation" placeholder="Re-enter the password" class="w-full rounded-lg border-gray-300 text-sm focus:border-blue-500 focus:ring-blue-500" minlength="8">
                </div>
            </div>


          <div>
                <label for="modal-notes" class="mb-1 block text-xs font-medium text-gray-700">Admin Notes</label>
                <textarea name="admin_notes" id="modal-notes" rows="3" placeholder="Admin notes" class="w-full rounded-lg border-gray-300 text-sm focus:border-blue-500 focus:ring-blue-500"></textarea>
            </div>

            <div class="flex items-center justify-end gap-2 pt-1">
                <button type="button" class="rounded-lg border border-gray-300 px-3 py-2 text-xs font-medium text-gray-700 hover:bg-gray-50" data-modal-close="password-request-modal">
                    Cancel
                </button>
                <button id="modal-submit" type="submit" class="rounded-lg bg-blue-600 px-4 py-2 text-xs font-semibold text-white hover:bg-blue-700">
                    Submit
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    (function () {
        const modal = document.getElementById('password-request-modal');
        const form = document.getElementById('password-request-form');
        const title = document.getElementById('modal-title');
        const description = document.getElementById('modal-description');
        const submitButton = document.getElementById('modal-submit');
        const passwordFields = document.getElementById('password-fields');
        const password = document.getElementById('modal-password');
        const passwordConfirmation = document.getElementById('modal-password-confirmation');
        const notes = document.getElementById('modal-notes');

        document.querySelectorAll('[data-modal-open="password-request-modal"]').forEach((button) => {
            button.addEventListener('click', () => {
                const action = button.dataset.modalAction;
                const user = button.dataset.user;

                if (action === 'reset') {
                    form.action = button.dataset.resetUrl;
                    title.textContent = 'Reset Password';
                    description.textContent = `Set a new password for ${user} and include verification notes.`;
                    submitButton.textContent = 'Verify & Reset';
                     submitButton.className = 'w-full text-white text-sm py-2 rounded bg-green-600 hover:bg-green-700';
                    passwordFields.classList.remove('hidden');
                    password.required = true;
                    passwordConfirmation.required = true;
                    notes.placeholder = 'Admin verification notes';
                } else {
                    form.action = button.dataset.rejectUrl;
                    title.textContent = 'Reject Request';
                    description.textContent = `Provide a reason for rejecting ${user}'s request.`;
                    submitButton.textContent = 'Reject Request';
                 submitButton.className = 'rounded-lg bg-red-600 px-4 py-2 text-xs font-semibold text-white hover:bg-red-700';
                    passwordFields.classList.add('hidden');
                    password.required = false;
                    passwordConfirmation.required = false;
                    notes.placeholder = 'Reason for rejection';
                }

                modal.classList.remove('hidden');
                modal.classList.add('flex');
            });
        });

        document.querySelectorAll('[data-modal-close="password-request-modal"]').forEach((button) => {
            button.addEventListener('click', () => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
                form.reset();
            });
        });

        modal.addEventListener('click', (event) => {
            if (event.target === modal) {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
                form.reset();
            }
        });
document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape' && !modal.classList.contains('hidden')) {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
                form.reset();
            }
        });
    })();
</script>
@endsection