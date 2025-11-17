<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Repair Service</title>

  {{-- Tailwind / Vite --}}
  @if (file_exists(public_path('mix-manifest.json')))
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
  @else
    @vite(['resources/css/app.css', 'resources/js/app.js'])
  @endif

  <style>
    :root {
      --header-bg: #232628;
      --hero-blue-a: #1672b7;
      --hero-blue-b: #2aa1e8;
      --panel-dark: #111315;
      --accent: #ef2b2b;
      --muted: #9a9a9a;
    }

    .services-title {
      font-weight: 800;
      text-transform: uppercase;
      letter-spacing: 0.12em;
      text-align: center;
      font-size: 2.4rem;
      background: linear-gradient(90deg, var(--hero-blue-a), var(--hero-blue-b));
      -webkit-background-clip: text;
      background-clip: text;
      color: transparent;
      text-shadow: 0 4px 18px rgba(0, 0, 0, 0.6);
    }
 

  </style>
</head>
<body id="top" class="min-h-screen page-bg text-gray-200">
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


<!-- Hero Section -->
<section id="home" style="background-color: rgb(64,64,64);" class="py-5">
  <div class="mx-auto max-w-7xl flex flex-col lg:flex-row items-center gap-8 px-6 py-22">
    <!-- Hero Image -->
    <div class="flex-1">
      @if (file_exists(public_path('images/rbg.png')))
        <img src="{{ asset('images/rbg.png') }}" alt="Devices" class="w-full h-auto object-contain" />
      @else
      @endif
    </div>
    <!-- Hero Text -->
    <div class="flex-1 text-center lg:text-left">
      <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-white uppercase leading-tight">
        Computer Repair &amp; Support
      </h1>
      <p class="mt-4 text-gray-300 text-base max-w-md mx-auto lg:mx-0">
        We provide professional and reliable services for computers, laptops, gadgets, air-conditioning units, printers, and more. From troubleshooting to full installation, we ensure your devices run at their best.
      </p>
      <div class="mt-8 flex flex-wrap justify-center lg:justify-start gap-4">
        <a href="#services" class="px-6 py-3 bg-white text-[var(--hero-blue-a)] rounded font-semibold uppercase">Inquire</a>
        <a href="#contact" class="px-6 py-3 border border-white text-white rounded font-semibold uppercase">Contact Us</a>
      </div>
    </div>
  </div>
</section>
<!-- Services / Icon Blocks -->
<section id="services" class="bg-black py-16">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="mb-10 text-center">
      <h3 class="services-title">Our Services</h3>
    </div>

    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-8 items-stretch">
      {{-- Card 1: Computer & Laptop Repair --}}
      <div class="group bg-black rounded-2xl p-6 h-full flex flex-col items-center text-center hover:bg-gray-900 transition-colors">
        <div class="flex items-center justify-center w-16 h-16 rounded-full bg-gray-900 border border-gray-700 mb-4">
          <svg class="w-8 h-8 text-blue-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
               stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <rect x="3" y="4" width="18" height="12" rx="2" ry="2" />
            <path d="M8 20h8" />
            <path d="M12 16v4" />
          </svg>
        </div>

        <h3 class="font-bold text-gray-100 text-lg">Computer &amp; Laptop Repair</h3>
        <p class="mt-2 text-gray-400 text-sm">
          Full diagnostics, performance tuning, OS issues, virus removal, and hardware replacement.
        </p>

        <div class="mt-4 flex items-center justify-center">
          <svg class="w-4 h-4 text-blue-300 transition-transform group-hover:translate-x-1"
               xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
               stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="m9 18 6-6-6-6" />
          </svg>
        </div>
      </div>

      {{-- Card 2: Phone & Gadget Support --}}
      <div class="group bg-black rounded-2xl p-6 h-full flex flex-col items-center text-center hover:bg-gray-900 transition-colors">
        <div class="flex items-center justify-center w-16 h-16 rounded-full bg-gray-900 border border-gray-700 mb-4">
          <svg class="w-8 h-8 text-emerald-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
               stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <rect x="7" y="2" width="10" height="20" rx="2" ry="2" />
            <line x1="12" y1="18" x2="12.01" y2="18" />
          </svg>
        </div>

        <h3 class="font-bold text-gray-100 text-lg">Phone &amp; Gadget Support</h3>
        <p class="mt-2 text-gray-400 text-sm">
          Screen and battery replacement, setup, data transfer, and troubleshooting for phones and tablets.
        </p>

        <div class="mt-4 flex items-center justify-center">
          <svg class="w-4 h-4 text-emerald-300 transition-transform group-hover:translate-x-1"
               xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
               stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="m9 18 6-6-6-6" />
          </svg>
        </div>
      </div>

      {{-- Card 3: Aircon Service --}}
      <div class="group bg-black rounded-2xl p-6 h-full flex flex-col items-center text-center hover:bg-gray-900 transition-colors">
        <div class="flex items-center justify-center w-16 h-16 rounded-full bg-gray-900 border border-gray-700 mb-4">
          <svg class="w-8 h-8 text-cyan-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
               stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <rect x="3" y="5" width="18" height="10" rx="2" ry="2" />
            <path d="M5 19h14" />
            <path d="M8 9h.01M12 9h.01M16 9h.01" />
          </svg>
        </div>

        <h3 class="font-bold text-gray-100 text-lg">Aircon Cleaning &amp; Repair</h3>
        <p class="mt-2 text-gray-400 text-sm">
          Installation, deep cleaning, freon check, and repair for window and split-type air conditioners.
        </p>

        <div class="mt-4 flex items-center justify-center">
          <svg class="w-4 h-4 text-cyan-300 transition-transform group-hover:translate-x-1"
               xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
               stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="m9 18 6-6-6-6" />
          </svg>
        </div>
      </div>

      {{-- Card 4: Printer Services --}}
      <div class="group bg-black rounded-2xl p-6 h-full flex flex-col items-center text-center hover:bg-gray-900 transition-colors">
        <div class="flex items-center justify-center w-16 h-16 rounded-full bg-gray-900 border border-gray-700 mb-4">
          <svg class="w-8 h-8 text-purple-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
               stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M6 9V2h12v7" />
            <rect x="6" y="13" width="12" height="8" rx="2" />
            <path d="M6 13h12" />
            <path d="M8 17h4" />
          </svg>
        </div>

        <h3 class="font-bold text-gray-100 text-lg">Printer Setup &amp; Repair</h3>
        <p class="mt-2 text-gray-400 text-sm">
          Printer installation, paper feed issues, ink system problems, and network printing setup.
        </p>

        <div class="mt-4 flex items-center justify-center">
          <svg class="w-4 h-4 text-purple-300 transition-transform group-hover:translate-x-1"
               xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
               stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="m9 18 6-6-6-6" />
          </svg>
        </div>
      </div>

      {{-- Card 5: Washing Machine Repair --}}
      <div class="group bg-black rounded-2xl p-6 h-full flex flex-col items-center text-center hover:bg-gray-900 transition-colors">
        <div class="flex items-center justify-center w-16 h-16 rounded-full bg-gray-900 border border-gray-700 mb-4">
          <svg class="w-8 h-8 text-pink-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
               stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <rect x="4" y="3" width="16" height="18" rx="2" />
            <circle cx="12" cy="13" r="4" />
            <path d="M8 7h.01M11 7h.01" />
          </svg>
        </div>

        <h3 class="font-bold text-gray-100 text-lg">Washing Machine Repair</h3>
        <p class="mt-2 text-gray-400 text-sm">
          Drum, motor, water flow, and control panel issues for automatic and semi-auto washers.
        </p>

        <div class="mt-4 flex items-center justify-center">
          <svg class="w-4 h-4 text-pink-300 transition-transform group-hover:translate-x-1"
               xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
               stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="m9 18 6-6-6-6" />
          </svg>
        </div>
      </div>

      {{-- Card 6: Network & On-site Support --}}
      <div class="group bg-black rounded-2xl p-6 h-full flex flex-col items-center text-center hover:bg-gray-900 transition-colors">
        <div class="flex items-center justify-center w-16 h-16 rounded-full bg-gray-900 border border-gray-700 mb-4">
          <svg class="w-8 h-8 text-amber-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
               stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="12" cy="12" r="3" />
            <path d="M2.05 12a10 10 0 0 1 19.9 0" />
            <path d="M4.5 19a10 10 0 0 1 15 0" />
          </svg>
        </div>

        <h3 class="font-bold text-gray-100 text-lg">Network &amp; On-site Support</h3>
        <p class="mt-2 text-gray-400 text-sm">
          Home and small office network setup, Wi-Fi issues, and on-site technical assistance.
        </p>

        <div class="mt-4 flex items-center justify-center">
          <svg class="w-4 h-4 text-amber-300 transition-transform group-hover:translate-x-1"
               xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
               stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="m9 18 6-6-6-6" />
          </svg>
        </div>
      </div>
    </div>
    </div>
  </div>
</section>



</div>

@if (class_exists(\Livewire\Livewire::class))
  @livewireScripts
  @livewireStyles
@endif



  <!-- ✅ REVISED FOOTER: LOGO ON LEFT -->
<footer class="w-full bg-black text-gray-300 mt-20">
  <div class="max-w-7xl mx-auto px-6 py-10 flex flex-col md:flex-row md:justify-between md:items-start">

    <div class="flex items-center gap-4 text-left">
      <!-- Logo -->
      <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-16 w-16 object-contain">

      <!-- Company Name + Address -->
      <div>
        <h3 class="text-white font-semibold mb-1">Techne-Fixer Computer & Technologies</h3>
        <p class="text-sm leading-5 text-gray-300">
          007 Manga Street 8000, Toril<br>
          Davao City, Davao Del Sur<br>
          Philippines
        </p>
      </div>
    </div>

    <!-- Right side: Info groups -->
    <div class="grid grid-cols-2 md:grid-cols-3 gap-8 w-full md:w-auto">

      <!-- Contact -->
      <div>
        <h3 class="text-white font-semibold mb-2">Contact Us</h3>
        <div class="text-sm space-y-1">
          <p><span class="text-gray-400 mr-1">📞</span>0966 240 6825</p>
          <p><span class="text-gray-400 mr-1">✉️</span>petemobilefixer2015@gmail.com</p>
        </div>
      </div>

      <!-- Social -->
      <div>
        <h3 class="text-white font-semibold mb-2">Social</h3>
        <ul class="space-y-1 text-sm">
          <li>
            <a href="https://www.facebook.com/profile.php?id=61577111409420" class="hover:text-white">Facebook</a>
          </li>
        </ul>
      </div>

      <!-- Legal -->
      <div>
        <h3 class="text-white font-semibold mb-2">Legal</h3>
        <ul class="space-y-1 text-sm">
          <li><a href="#" class="hover:text-white">Terms of Service</a></li>
          <li><a href="#" class="hover:text-white">Privacy Policy</a></li>
          <li><a href="#" class="hover:text-white">Cookie Policy</a></li>
        </ul>
      </div>

    </div>
  </div>

  <!-- Bottom copyright -->
  <div class="border-t border-white/10 py-4 text-center text-xs text-gray-400">
    © 2025 TechneFixer. All rights reserved.
  </div>
</footer>





</body>
</html>
