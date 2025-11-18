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
     <a href="{{ route('inquiry.create') }}"
           class="px-6 py-3 bg-white text-[var(--hero-blue-a)] rounded font-semibold uppercase">
           {{ __('Inquire') }}
        </a>        <a href="#contact" class="px-6 py-3 border border-white text-white rounded font-semibold uppercase">Contact Us</a>
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
      <div class="group bg-black border border-white rounded-2xl p-6 h-60 flex flex-col items-center text-center hover:bg-gray-900 transition-colors">
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
      <div class="group bg-black border border-white rounded-2xl p-6 h-60 flex flex-col items-center text-center hover:bg-gray-900 transition-colors">
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
      <div class="group bg-black border border-white rounded-2xl p-6 h-60 flex flex-col items-center text-center hover:bg-gray-900 transition-colors">
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
      <div class="group bg-black border border-white rounded-2xl p-6 h-60 flex flex-col items-center text-center hover:bg-gray-900 transition-colors">
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
      <div class="group bg-black border border-white rounded-2xl p-6 h-60 flex flex-col items-center text-center hover:bg-gray-900 transition-colors">
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
      <div class="group bg-black border border-white rounded-2xl p-6 h-60 flex flex-col items-center text-center hover:bg-gray-900 transition-colors">
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