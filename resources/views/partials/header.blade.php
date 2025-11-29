<script src="//unpkg.com/alpinejs" defer></script>

<header class="bg-black text-white border-b border-white/5">
  <nav class="mx-auto max-w-7xl flex items-center justify-between gap-6 px-4 lg:px-6 py-4">

    <!-- Left: Logo + Title -->
    <a href="{{ url('/') }}" class="flex items-center gap-3">
      <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-14 w-auto object-contain">
      <div class="flex flex-col leading-tight">
        <span class="text-xs font-semibold tracking-[0.25em] text-gray-400">
          TECH & REPAIR
        </span>
        <span class="text-xl md:text-2xl font-extrabold uppercase tracking-wide">
          TECHNE FIXER
        </span>
      </div>
    </a>

    <!-- Center: Nav Links -->
    <div class="hidden lg:flex items-center gap-6">
      <a href="#home" class="text-sm font-medium text-gray-300 hover:text-white transition-colors">
        About Us
      </a>
      <a href="{{ route('feedback.create') }}" class="text-sm font-medium text-gray-300 hover:text-white transition-colors">

        Feedbacks
      </a>
      <a href="#services" class="text-sm font-medium text-gray-300 hover:text-white transition-colors">
        Services
      </a>
      <a href="#contact" class="text-sm font-medium text-gray-300 hover:text-white transition-colors">
        Contact Us
      </a>

      @auth
        <span class="h-5 w-px bg-white/10"></span>
        <a href="{{ route('customer.track') }}" class="text-sm font-medium text-gray-300 hover:text-white transition-colors">
          Track Repair
        </a>
        <a href="{{ route('customer.messages') }}" class="text-sm font-medium text-gray-300 hover:text-white transition-colors">
          Messages
        </a>
      @endauth
    </div>

    <!-- Right: Auth / User Menu -->
    <div class="hidden lg:flex items-center gap-4">
      @if (Route::has('login'))
        @auth
          <!-- User Dropdown -->
          <div class="relative" x-data="{ open: false }">
            <button
              @click="open = !open"
              class="flex items-center gap-2 px-3 py-2 rounded-full bg-white/5 hover:bg-white/10 transition-all"
            >
              <div class="flex items-center justify-center w-8 h-8 rounded-full bg-gradient-to-r from-blue-500 to-purple-600">
                <span class="text-sm font-semibold">
                  {{ substr(Auth::user()->name, 0, 1) }}
                </span>
              </div>
              <span class="text-sm font-medium text-gray-100">
                {{ Auth::user()->name }}
              </span>
              <svg
                class="w-4 h-4 text-gray-300 transition-transform duration-200"
                :class="{ 'rotate-180': open }"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
              >
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
              </svg>
            </button>

            <div
              x-show="open"
              @click.away="open = false"
              x-transition:enter="transition ease-out duration-150"
              x-transition:enter-start="opacity-0 scale-95"
              x-transition:enter-end="opacity-100 scale-100"
              x-transition:leave="transition ease-in duration-100"
              x-transition:leave-start="opacity-100 scale-100"
              x-transition:leave-end="opacity-0 scale-95"
              class="absolute right-0 mt-2 w-48 origin-top-right rounded-xl bg-white text-gray-800 shadow-lg ring-1 ring-black/5 z-50"
            >
              <div class="p-2">
                <a
                  href="{{ route('profile.edit') }}"
                  class="flex items-center px-3 py-2 text-sm rounded-lg hover:bg-gray-100"
                >
                  <svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                  </svg>
                  Account
                </a>

                <form method="POST" action="{{ route('logout') }}">
                  @csrf
                  <button
                    type="submit"
                    class="flex items-center w-full px-3 py-2 text-sm text-red-600 rounded-lg hover:bg-red-50"
                  >
                    <svg class="w-5 h-5 mr-3 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                    Log Out
                  </button>
                </form>
              </div>
            </div>
          </div>
        @else
          <div class="flex items-center gap-3">
            <a href="{{ route('login') }}"
               class="px-5 py-2.5 text-sm font-medium rounded-full border border-white/20 bg-white/5 hover:bg-white/10 transition-all">
              Log in
            </a>

            @if (Route::has('register'))
              <a href="{{ route('register') }}"
                 class="px-5 py-2.5 text-sm font-medium rounded-full bg-blue-600 hover:bg-blue-500 transition-all">
                Register
              </a>
            @endif
          </div>
        @endauth
      @endif
    </div>

  </nav>
</header>
