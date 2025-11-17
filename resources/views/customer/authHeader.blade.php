<header class="bg-black shadow-md">
    <nav class="mx-auto max-w-7xl flex items-center justify-between px-4 lg:px-2 py-2">
      <a href="{{ url('/') }}" class="flex items-center gap-1">
    <img src="{{ asset('images/logo.png') }}" 
         alt="Logo" 
         class="h-25 w-auto object-contain mt-7"
 />

    <span class="text-white font-extrabold uppercase tracking-wide text-2xl leading-none">
        TECHNE FIXER
    </span>
</a>


        <!-- Desktop Navigation -->
        <div class="hidden lg:flex items-center gap-8">
        <a href="#home" class="nav-link">Home</a>
        <a href="#about" class="nav-link">About Us</a>
        <a href="#track" class="nav-link">Track Repair</a>
        <a href="#feedback" class="nav-link">Feedback</a>
        <a href="#contact" class="nav-link">Contact</a>
        </div>

<!-- Authentication -->
<div class="hidden lg:flex items-center gap-4">
    {{-- Guests: show Login / Register --}}
    @guest
        <a href="{{ route('login') }}"
           class="px-4 py-2 text-white border border-white/30 rounded-lg hover:bg-white hover:text-black transition">
            Log in
        </a>

        @if (Route::has('register'))
            <a href="{{ route('register') }}"
               class="px-4 py-2 text-white border border-white/30 rounded-lg hover:bg-white hover:text-black transition">
                Register
            </a>
        @endif
    @endguest

    {{-- Authenticated users: avatar + name + dropdown --}}
    @auth
        <div x-data="{ open: false }" class="relative">
            <button @click="open = !open"
                    class="flex items-center gap-2 px-3 py-2 rounded-full bg-white/10 hover:bg-white/20 border border-white/20 text-white text-sm font-medium">
                <div class="flex items-center justify-center w-8 h-8 rounded-full bg-white/20">
                    {{-- simple user icon circle --}}
                    <span class="text-xs font-semibold uppercase">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </span>
                </div>

                <span class="max-w-[140px] truncate">
                    {{ auth()->user()->name }}
                </span>

                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4"
                     fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                          d="M19 9l-7 7-7-7"/>
                </svg>
            </button>

            <!-- Dropdown -->
            <div x-cloak
                 x-show="open"
                 @click.outside="open = false"
                 x-transition
                 class="absolute right-0 mt-2 w-40 rounded-xl bg-white text-sm text-gray-900 shadow-lg border border-gray-200">
                @if (Route::has('profile.edit'))
                    <a href="{{ route('profile.edit') }}"
                       class="block px-4 py-2 hover:bg-gray-100 rounded-t-xl">
                        Account
                    </a>
                @endif

                {{-- Manager shortcut (optional) --}}
                @if (auth()->user()->role === 'manager')
                    <a href="{{ route('dashboard') }}"
                       class="block px-4 py-2 hover:bg-gray-100">
                        Manager Panel
                    </a>
                @endif

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                            class="w-full text-left px-4 py-2 hover:bg-gray-100 rounded-b-xl">
                        Log out
                    </button>
                </form>
            </div>
        </div>
    @endauth
</div>




    <!-- Mobile Menu Button -->
    <button class="lg:hidden text-gray-300 p-2 rounded-md hover:bg-white/10 transition">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" class="w-7 h-7">
        <path d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" stroke-linecap="round" />
      </svg>
    </button>

  </nav>
</header>