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
</div>




    <!-- Mobile Menu Button -->
    <button class="lg:hidden text-gray-300 p-2 rounded-md hover:bg-white/10 transition">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" class="w-7 h-7">
        <path d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" stroke-linecap="round" />
      </svg>
    </button>

  </nav>
</header>