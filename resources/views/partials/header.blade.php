<header class="bg-black">
  <nav class="mx-auto max-w-7xl flex items-center justify-between px-6 lg:px-2 py-2">
    <a href="{{ url('/') }}" class="flex items-center gap-4">
      <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-20 w-auto object-contain">
      <span class="text-white font-extrabold uppercase tracking-wide text-2xl leading-none">TECHNE FIXER</span>
    </a>
    <div class="hidden lg:flex items-center gap-8">
      <a href="#home" class="text-gray-300 hover:text-white">About Us</a>
      <a href="#services" class="text-gray-300 hover:text-white">Services</a>
      <a href="#contact" class="text-gray-300 hover:text-white">Contact Us</a>
    </div>
    <div class="hidden lg:flex items-center gap-4">
      @if (Route::has('login'))
        @auth
          <a href="{{ url('/dashboard') }}" class="px-4 py-2 bg-white text-black font-semibold rounded-lg hover:bg-gray-200">Dashboard</a>
        @else
          <a href="{{ route('login') }}" class="px-4 py-2 text-white border border-white/30 rounded-lg hover:bg-white hover:text-black">Log in</a>
        @endauth
      @endif
    </div>
  </nav>
</header>