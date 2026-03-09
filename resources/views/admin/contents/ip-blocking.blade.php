@extends('admin.layout.app')

@section('content')
<div class="space-y-6 bg-white text-gray-900">
  <div class="flex items-center justify-between">
    <div>
      <h1 class="text-3xl font-bold text-gray-900">IP Blocklist</h1>
      <p class="text-sm text-gray-600 mt-1">Manage blocked IP addresses</p>
      <p class="text-xs text-gray-500 mt-2">Your current IP: <span class="font-semibold text-gray-700">{{ $requestIp ?: 'Unknown' }}</span></p>
    </div>
  </div>

  @if (session('status'))
    <div class="rounded-lg border border-green-300 bg-green-50 px-4 py-3 text-sm text-green-700">
      {{ session('status') }}
    </div>
  @endif

  @if ($errors->any())
    <div class="rounded-lg border border-red-300 bg-red-50 px-4 py-3 text-sm text-red-700">
      <ul class="list-disc list-inside space-y-1">
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <div class="grid grid-cols-1 xl:grid-cols-3 gap-5">
    <!-- Left column: table & pagination -->
    <div class="xl:col-span-2 rounded-xl border border-gray-200 bg-white overflow-hidden">
      <div class="overflow-x-auto">
        <table class="w-full text-sm">
          <thead class="border-b border-gray-200 bg-gray-50 text-gray-600 text-xs uppercase tracking-wider">
            <tr>
              <th class="px-5 py-4 text-left">IP Address</th>
              <th class="px-5 py-4 text-left">Blocked At</th>
              <th class="px-5 py-4 text-left">Expires At</th>
              <th class="px-5 py-4 text-left">Reason</th>
              <th class="px-5 py-4 text-left">Actions</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-200">
            @forelse ($blockedIps as $blockedIp)
              <tr class="hover:bg-gray-50">
                <td class="px-5 py-4 font-medium text-gray-900">
                  {{ $blockedIp->ip_address }}
                  @if ($requestIp !== '' && $blockedIp->ip_address === $requestIp)
                    <span class="ml-2 inline-flex items-center rounded-full bg-yellow-100 px-2 py-0.5 text-[10px] font-semibold text-yellow-800">Your IP</span>
                  @endif
                </td>
                <td class="px-5 py-4 text-gray-700">{{ $blockedIp->blocked_at?->format('Y-m-d H:i') }}</td>
                <td class="px-5 py-4 text-red-600">
                  <div>{{ $blockedIp->expires_at?->format('Y-m-d H:i') ?? 'Never' }}</div>
                  @if ($blockedIp->expires_at)
                    <div class="text-[11px] text-gray-500">({{ now()->diffForHumans($blockedIp->expires_at, ['syntax' => \Carbon\CarbonInterface::DIFF_RELATIVE_TO_NOW]) }})</div>
                  @endif
                </td>
                <td class="px-5 py-4 text-gray-700">{{ $blockedIp->reason ?: '—' }}</td>
                <td class="px-5 py-4">
                  <form action="{{ route('admin.ipBlocking.destroy', $blockedIp) }}" method="POST" onsubmit="return confirm('Unblock this IP address?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="inline-flex items-center rounded-md border border-gray-300 bg-white px-3 py-1.5 text-xs font-semibold text-gray-700 hover:bg-gray-50 transition">
                      Unblock
                    </button>
                  </form>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="5" class="px-5 py-10 text-center text-gray-500">No active blocked IP addresses.</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>

      <div class="border-t border-gray-200 p-4">
        {{ $blockedIps->links() }}
      </div>
    </div>

    <!-- Right column: block form -->
    <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">
      <h2 class="text-xl font-semibold text-gray-900 mb-4">Block IP Address</h2>

      <form action="{{ route('admin.ipBlocking.store') }}" method="POST" class="space-y-4">
        @csrf
        <div>
          <label for="ip_address" class="block text-xs uppercase tracking-wider text-gray-500 mb-1.5">IP Address</label>
          <input
            type="text"
            id="ip_address"
            name="ip_address"
            value="{{ old('ip_address') }}"
            placeholder="e.g. 192.168.1.100"
            class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm text-gray-900 placeholder:text-gray-400 focus:border-gray-400 focus:outline-none"
            required
          >
        </div>

        <div>
          <label for="duration_minutes" class="block text-xs uppercase tracking-wider text-gray-500 mb-1.5">Duration</label>
          <select
            id="duration_minutes"
            name="duration_minutes"
            class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm text-gray-900 focus:border-gray-400 focus:outline-none"
            required
          >
            @foreach ($durationOptions as $minutes => $label)
              <option value="{{ $minutes }}" @selected((int) old('duration_minutes', 1440) === $minutes)>{{ $label }}</option>
            @endforeach
          </select>
        </div>

        <div>
          <label for="reason" class="block text-xs uppercase tracking-wider text-gray-500 mb-1.5">Reason</label>
          <textarea
            id="reason"
            name="reason"
            rows="3"
            placeholder="Reason for blocking this IP"
            class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm text-gray-900 placeholder:text-gray-400 focus:border-gray-400 focus:outline-none"
          >{{ old('reason') }}</textarea>
        </div>

        <button type="submit" class="w-full rounded-lg bg-gray-800 px-4 py-2.5 text-sm font-semibold text-white hover:bg-gray-700 transition">
          Block IP Address
        </button>
      </form>
    </div>
  </div>
</div>
@endsection