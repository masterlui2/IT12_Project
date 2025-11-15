<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="…" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <title>Repair Service</title>

  {{-- If you use Vite (Breeze), it will include your compiled Tailwind CSS --}}
  @if (file_exists(public_path('mix-manifest.json')))
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
  @else
    @vite(['resources/css/app.css', 'resources/js/app.js'])
  @endif

  <style>
    :root{
      --header-bg: #232628;
      --hero-blue-a: #1672b7;
      --hero-blue-b: #2aa1e8;
      --panel-dark: #111315;
      --accent: #ef2b2b;
      --muted: #9a9a9a;
    }

    html,body { height:100%; }

    .page-bg {
      background-image: url('{{ asset("images/background.jpg") }}');
      background-size: cover;
      background-position: center;
      background-repeat: no-repeat;
    }

    .hero-blue {
      background: linear-gradient(90deg, var(--hero-blue-a), var(--hero-blue-b));
    }

    .svc-circle {
      width: 180px;
      height: 180px;
      border-radius: 9999px;
      box-shadow: 0 6px 18px rgba(0,0,0,0.4);
      border: 8px solid rgba(255,255,255,0.12);
      display:flex; align-items:center; justify-content:center;
      background: rgba(255,255,255,0.03);
      overflow:hidden;
    }

    .max-site {
      max-width: 1800px;
      margin-left: auto;
      margin-right: auto;
    }

    .svc-arrow {
      width:44px; height:44px; border-radius:8px;
      display:inline-flex; align-items:center; justify-content:center;
      background: rgba(255,255,255,0.08); color:white;
      border:1px solid rgba(255,255,255,0.06);
      backdrop-filter: blur(3px);
    }

    .main-band {
      background: linear-gradient(180deg, rgba(0,0,0,0.85), rgba(16,16,16,0.95));
    }

    .hero-content { color: white; text-shadow: 0 6px 18px rgba(0,0,0,0.6); }

    .services-title {
      font-weight: 800;
      text-transform: uppercase;
      letter-spacing: 0.08em;
      text-align:center;
      color: #ffffff;
      font-size: 2.25rem;
      text-shadow: 0 4px 18px rgba(0,0,0,0.6);
    }
  </style>
</head>
<body class="min-h-screen page-bg text-gray-200">

  {{-- Header --}}
  <header class="w-full bg-[var(--header-bg)] text-white">
    <div class="max-site w-full flex items-center justify-between px-6 py-4">
      <a href="{{ url('/') }}" class="flex items-center gap-3">
        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-14 w-auto object-contain">
        <div class="hidden md:block">
          <div class="text-lg font-semibold">REPAIR</div>
          <div class="text-xs text-gray-400">Computer, Laptop & Gadget Repair</div>
        </div>
      </a>

      <div class="flex items-center gap-6">
        <nav class="hidden lg:flex items-center gap-6 text-sm text-gray-300">
          <a href="#" class="hover:text-white">Home</a>
          <a href="#" class="hover:text-white">About Us</a>
          <a href="#services" class="hover:text-white">Services</a>
          <a href="#" class="hover:text-white">Prices</a>
          <a href="#" class="hover:text-white">Contacts</a>
        </nav>

        @if (Route::has('login'))
          <div class="flex items-center gap-3 text-sm">
            @auth
              <a href="{{ url('/dashboard') }}" class="px-4 py-2 bg-white text-[var(--header-bg)] rounded">Dashboard</a>
            @else
              <a href="{{ route('login') }}" class="px-4 py-2 rounded border border-transparent bg-white/10 hover:bg-white/20">Log in</a>
              @if (Route::has('register'))
                <a href="{{ route('register') }}" class="px-4 py-2 rounded border border-white/10 hover:bg-white/10">Register</a>
              @endif
            @endauth
          </div>
        @endif
      </div>
    </div>
  </header>

  {{-- HERO --}}
  <section class="w-full hero-blue relative">
    <div class="max-site flex flex-col lg:flex-row items-center gap-8 px-6 py-10 lg:py-20">
      <div class="lg:flex-1 hero-content">
        <h3 class="uppercase tracking-widest text-sm mb-3">Tablets & Phones</h3>
        <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold leading-tight mb-4">REPAIR SERVICE</h1>
        <p class="max-w-xl text-gray-100/85 mb-6">Anytime anywhere — professional repairs for mobile devices, laptops, printers and more.</p>

        <div class="flex items-center gap-4">
          <a href="#services" class="px-6 py-3 bg-white text-[var(--hero-blue-a)] rounded font-semibold">Inquire now</a>
          <a href="#" class="px-6 py-3 border border-white/30 text-white rounded">Learn more</a>
        </div>
      </div>

      <div class="w-full lg:w-[560px] shrink-0">
        @if (file_exists(public_path('images/hero-banner.png')))
          <img src="{{ asset('images/hero-banner.png') }}" alt="Hero" class="w-full h-full object-contain">
        @else
          <div class="w-full h-56 lg:h-72 bg-black/10 rounded shadow-inner border border-white/5"></div>
        @endif
      </div>
    </div>

    <div class="w-full main-band mt-6 py-14">
      <div class="max-site text-center px-6">
        <h2 class="text-2xl md:text-3xl font-bold text-white">PROFESSIONAL COMPUTER REPAIR SERVICE</h2>
        <p class="mt-3 text-gray-300">call for immediate assistance <span class="font-bold" style="color:var(--accent)">Kuya pete's num</span></p>
      </div>
    </div>
  </section>

  {{-- SERVICES --}}
  
  <section id="services" class="w-full py-12">
    <div class="max-site px-6">
      <div class="mb-10">
        <h3 class="services-title">Our Services</h3>
      </div>

      <div class="relative">
        <button id="svc-prev" class="absolute left-2 -translate-y-1/2 top-1/2 svc-arrow z-20" aria-label="Previous">
          <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none"><path d="M15 18l-6-6 6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
        </button>

        <button id="svc-next" class="absolute right-2 -translate-y-1/2 top-1/2 svc-arrow z-20" aria-label="Next">
          <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none"><path d="M9 6l6 6-6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
        </button>

        <div class="overflow-hidden">
          <div class="flex transition-transform duration-500 ease-in-out services-track items-start justify-center gap-6">
      @php
        $services = [
          ['title'=>'Performance Optimization','img'=>'images/upgrades-speed.png','subtitle'=>'Upgrades & Speed Improvement'],
          ['title'=>'Setup & Repair','img'=>'images/mobile-ac-cctv.png','subtitle'=>'Mobile, AC, CCTV & Appliance Repair'],
          ['title'=>'Diagnostic','img'=>'images/diagnostic.png','subtitle'=>'Fault Finding & Troubleshooting'],
          ['title'=>'Parts Replacement','img'=>'images/printer-swap.png','subtitle'=>'Printer Cartridges & Component Swap'],
          ['title'=>'Restoration','img'=>'images/data-recovery.png','subtitle'=>'Data Recovery & Hard Disk Restoration'],
        ];
      @endphp



            @foreach($services as $svc)
              <div class="flex-shrink-0 px-3 py-6 w-full sm:w-1/2 md:w-1/3 lg:w-1/4 xl:w-1/5">
                <div class="flex flex-col items-center text-center">
                  <div class="svc-circle">
                    @if (file_exists(public_path($svc['img'])))
                      <img src="{{ asset($svc['img']) }}" alt="{{ $svc['title'] }}" class="w-36 h-36 object-contain">
                    @else
                      <div class="w-36 h-36 rounded-full bg-gray-200/30 flex items-center justify-center text-white text-2xl">{{ strtoupper(substr($svc['title'],0,1)) }}</div>
                    @endif
                  </div>

                  <h4 class="mt-5 text-xl font-semibold text-white">{{ $svc['title'] }}</h4>
                  <p class="text-sm text-gray-400 mt-1">{{ $svc['subtitle'] }}</p>

                  <a href="#" class="mt-6 px-4 py-2 bg-gray-800 text-white rounded text-sm">more</a>
                </div>
              </div>
            @endforeach

          </div>
        </div>

        <div id="svc-dots" class="mt-6 flex justify-center gap-2"></div>
      </div>
    </div>
  </section>
  

  {{-- Carousel JS --}}
  <script>
    (function() {
      const track = document.querySelector('.services-track');
      const prev = document.getElementById('svc-prev');
      const next = document.getElementById('svc-next');
      const dotsEl = document.getElementById('svc-dots');
      if (!track) return;

      const items = Array.from(track.children);

      let perView = 1;
      let page = 0;
      let pages = 1;

      function calcPerView(){
        const w = window.innerWidth;
        if (w >= 1280) return 5;
        if (w >= 1024) return 4;
        if (w >= 768)  return 3;
        if (w >= 640)  return 2;
        return 1;
      }

      function layout(){
        perView = calcPerView();
        const container = document.querySelector('.max-site') || document.body;
        const viewportWidth = (container.clientWidth || document.body.clientWidth) - 96;
        items.forEach(it => it.style.width = (viewportWidth / perView) + 'px');
        pages = Math.max(1, Math.ceil(items.length / perView));
        if (page >= pages) page = pages - 1;
        moveTrack();
        renderDots();
        updateButtons();
      }

      function moveTrack(){
        const container = document.querySelector('.max-site') || document.body;
        const distance = page * ((container.clientWidth || document.body.clientWidth) - 96);
        track.style.transform = `translateX(-${distance}px)`;
      }

      function renderDots(){
        if (!dotsEl) return;
        dotsEl.innerHTML = '';
        for (let i=0;i<pages;i++){
          const d = document.createElement('button');
          d.className = (i===page ? 'w-2 h-2 rounded-full bg-white' : 'w-2 h-2 rounded-full bg-gray-600');
          d.style.border = 'none';
          d.setAttribute('aria-label', 'page ' + (i+1));
          d.addEventListener('click', ()=>{ page = i; moveTrack(); renderDots(); updateButtons(); });
          dotsEl.appendChild(d);
        }
      }

      function updateButtons(){
        if (prev) prev.disabled = page === 0;
        if (next) next.disabled = page === pages - 1;
        if (prev) prev.style.opacity = prev.disabled ? '0.4' : '1';
        if (next) next.style.opacity = next.disabled ? '0.4' : '1';
      }

      if (prev) prev.addEventListener('click', ()=>{ if (page>0) { page--; moveTrack(); renderDots(); updateButtons(); }});
      if (next) next.addEventListener('click', ()=>{ if (page<pages-1){ page++; moveTrack(); renderDots(); updateButtons(); }});

      let t=null;
      window.addEventListener('resize', ()=>{ clearTimeout(t); t=setTimeout(layout,120);});
      window.addEventListener('load', ()=>{ layout(); });
    })();
  </script>

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
