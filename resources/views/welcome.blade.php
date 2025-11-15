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
    <nav class="mx-auto max-w-7xl flex items-center justify-between px-6 lg:px-2 py-2">
      <a href="{{ url('/') }}" class="flex items-center gap-4">
    <img src="{{ asset('images/logo.png') }}" 
         alt="Logo" 
         class="h-20 w-auto object-contain" />

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
      @if (Route::has('login'))
          @auth
              <a href="{{ url('/dashboard') }}" 
                 class="px-4 py-2 bg-white text-black font-semibold rounded-lg hover:bg-gray-200 transition">
                 Dashboard
              </a>
          @else
              <a href="{{ route('login') }}" 
                 class="px-4 py-2 text-white border border-white/30 rounded-lg hover:bg-white hover:text-black transition">
                 Log in
              </a>

              <a href="{{ route('register') }}" 
                 class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition">
                 Register
              </a>
          @endauth
      @endif
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
        <a href="#services" class="px-6 py-3 bg-white text-[var(--hero-blue-a)] rounded font-semibold uppercase">Explore Services</a>
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

    <div class="grid sm:grid-cols-2 lg:grid-cols-3 items-stretch gap-6">
      <!-- Card: Computer & Laptop Repair -->
      <a
        href="#contact"
        class="group flex size-full rounded-lg p-5 bg-gray-900/80 hover:bg-gray-800 focus:outline-hidden focus:bg-gray-800 transition-colors"
      >
        <svg
          class="shrink-0 size-8 text-blue-400 mt-0.5 me-6"
          xmlns="http://www.w3.org/2000/svg"
          width="24" height="24" viewBox="0 0 24 24"
          fill="none" stroke="currentColor" stroke-width="2"
          stroke-linecap="round" stroke-linejoin="round"
        >
          <rect x="3" y="4" width="18" height="12" rx="2" ry="2" />
          <path d="M8 20h8" />
          <path d="M12 16v4" />
        </svg>

        <div>
          <div>
            <h3 class="block font-bold text-gray-100">
              Computer &amp; Laptop Repair
            </h3>
            <p class="text-gray-400 text-sm">
              Diagnostics, OS issues, virus removal, and hardware replacement
              for desktops and laptops.
            </p>
          </div>

          <p class="mt-3 inline-flex items-center gap-x-1 text-sm font-semibold text-blue-300">
            Book a repair
            <svg
              class="shrink-0 size-4 transition-transform ease-in-out group-hover:translate-x-1 group-focus:translate-x-1"
              xmlns="http://www.w3.org/2000/svg"
              width="24" height="24" viewBox="0 0 24 24"
              fill="none" stroke="currentColor" stroke-width="2"
              stroke-linecap="round" stroke-linejoin="round"
            >
              <path d="m9 18 6-6-6-6" />
            </svg>
          </p>
        </div>
      </a>
      <!-- End Card -->

      <!-- Card: Phone & Gadget Support -->
      <a
        href="#contact"
        class="group flex size-full rounded-lg p-5 bg-gray-900/80 hover:bg-gray-800 focus:outline-hidden focus:bg-gray-800 transition-colors"
      >
        <svg
          class="shrink-0 size-8 text-emerald-400 mt-0.5 me-6"
          xmlns="http://www.w3.org/2000/svg"
          width="24" height="24" viewBox="0 0 24 24"
          fill="none" stroke="currentColor" stroke-width="2"
          stroke-linecap="round" stroke-linejoin="round"
        >
          <rect x="7" y="2" width="10" height="20" rx="2" ry="2" />
          <line x1="12" y1="18" x2="12.01" y2="18" />
        </svg>

        <div>
          <div>
            <h3 class="block font-bold text-gray-100">
              Phone &amp; Gadget Support
            </h3>
            <p class="text-gray-400 text-sm">
              Screen and battery replacement, setup, and troubleshooting
              for phones, tablets, and small gadgets.
            </p>
          </div>

          <p class="mt-3 inline-flex items-center gap-x-1 text-sm font-semibold text-emerald-300">
            Talk to a technician
            <svg
              class="shrink-0 size-4 transition-transform ease-in-out group-hover:translate-x-1 group-focus:translate-x-1"
              xmlns="http://www.w3.org/2000/svg"
              width="24" height="24" viewBox="0 0 24 24"
              fill="none" stroke="currentColor" stroke-width="2"
              stroke-linecap="round" stroke-linejoin="round"
            >
              <path d="m9 18 6-6-6-6" />
            </svg>
          </p>
        </div>
      </a>
      <!-- End Card -->

      <!-- Card: Appliances & AC Service -->
      <a
        href="#contact"
        class="group flex size-full rounded-lg p-5 bg-gray-900/80 hover:bg-gray-800 focus:outline-hidden focus:bg-gray-800 transition-colors"
      >
        <svg
          class="shrink-0 size-8 text-orange-400 mt-0.5 me-6"
          xmlns="http://www.w3.org/2000/svg"
          width="24" height="24" viewBox="0 0 24 24"
          fill="none" stroke="currentColor" stroke-width="2"
          stroke-linecap="round" stroke-linejoin="round"
        >
          <rect x="3" y="5" width="18" height="10" rx="2" ry="2" />
          <line x1="7" y1="9" x2="7.01" y2="9" />
          <line x1="11" y1="9" x2="11.01" y2="9" />
          <line x1="15" y1="9" x2="15.01" y2="9" />
          <path d="M5 19h14" />
        </svg>

        <div>
          <div>
            <h3 class="block font-bold text-gray-100">
              AC, Printer &amp; Appliance Service
            </h3>
            <p class="text-gray-400 text-sm">
              Installation, cleaning, and repair for air-conditioning units,
              printers, and washing machines.
            </p>
          </div>

          <p class="mt-3 inline-flex items-center gap-x-1 text-sm font-semibold text-orange-300">
            Schedule a visit
            <svg
              class="shrink-0 size-4 transition-transform ease-in-out group-hover:translate-x-1 group-focus:translate-x-1"
              xmlns="http://www.w3.org/2000/svg"
              width="24" height="24" viewBox="0 0 24 24"
              fill="none" stroke="currentColor" stroke-width="2"
              stroke-linecap="round" stroke-linejoin="round"
            >
              <path d="m9 18 6-6-6-6" />
            </svg>
          </p>
        </div>
      </a>
      <!-- End Card -->
    </div>
  </div>
</section>

</div>

@if (class_exists(\Livewire\Livewire::class))
  @livewireScripts
  @livewireStyles
@endif



  <!-- ✅ FOOTER ADDED HERE -->
  <footer class="w-full bg-black text-gray-300 mt-20">
  <div class="max-site px-6 py-16 grid grid-cols-1 md:grid-cols-4 gap-10">

    <div>
      <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-10 w-auto mb-4">
      <p class="text-sm leading-6">
        Techne-Fixer Computer and Technologies<br>
        007 Manga Street 8000<br>
        Toril<br>
        Davao Del Sur, Davao City<br>
        Philippines
      </p>

      <div class="mt-6 text-sm">
        <p class="text-gray-400">Phone number</p>
        <p class="font-medium">0966 240 6825</p>

        <p class="mt-4 text-gray-400">Email</p>
        <p class="font-medium">petemobilefixer2015@gmail.com</p>
      </div>
    </div>

    <div>
      <h3 class="text-white font-semibold mb-4">Social</h3>
      <ul class="space-y-2 text-sm">
        <li><a href="https://www.facebook.com/profile.php?id=61577111409420" class="hover:text-white">Facebook</a></li>

      </ul>
    </div>

    <div>
      <h3 class="text-white font-semibold mb-4">Legal</h3>
      <ul class="space-y-2 text-sm">
        <li><a href="#" class="hover:text-white">Terms of service</a></li>
        <li><a href="#" class="hover:text-white">Privacy policy</a></li>
        <li><a href="#" class="hover:text-white">Cookie policy</a></li>
      </ul>
    </div>

  </div>

  <div class="border-t border-white/10 py-6 text-center text-sm text-gray-400">
    © 2025 TechneFixer. All rights reserved.
  </div>
</footer>




</body>
</html>
