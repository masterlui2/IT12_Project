<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Repair Service</title>

  {{-- If you use Vite (Breeze), it will include your compiled Tailwind CSS --}}
  @if (file_exists(public_path('mix-manifest.json')))
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
  @else
    @vite(['resources/css/app.css', 'resources/js/app.js'])
  @endif

  <style>
    /* Theme colors modeled after your reference */
    :root{
      --header-bg: #232628;
      --hero-blue-a: #1672b7;
      --hero-blue-b: #2aa1e8;
      --panel-dark: #111315;
      --accent: #ef2b2b;
      --muted: #9a9a9a;
    }

    html,body { height:100%; }

    /* full background that you can replace by public/images/background.jpg */
    .page-bg {
      background-image: url('{{ asset("images/background.jpg") }}');
      background-size: cover;
      background-position: center;
      background-repeat: no-repeat;
    }

    /* hero banner area (blue) fallback if hero-banner.png not present */
    .hero-blue {
      background: linear-gradient(90deg, var(--hero-blue-a), var(--hero-blue-b));
    }

    /* larger service circle to match screenshot */
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

    /* maximize container width (very wide screens) */
    .max-site {
      max-width: 1800px; /* increase for "maximize" feel */
      margin-left: auto;
      margin-right: auto;
    }

    /* small arrow button */
    .svc-arrow {
      width:44px; height:44px; border-radius:8px;
      display:inline-flex; align-items:center; justify-content:center;
      background: rgba(255,255,255,0.08); color:white;
      border:1px solid rgba(255,255,255,0.06);
      backdrop-filter: blur(3px);
    }

    /* subtle inner glow for main band */
    .main-band {
      background: linear-gradient(180deg, rgba(0,0,0,0.85), rgba(16,16,16,0.95));
    }

    /* keep the hero content readable */
    .hero-content { color: white; text-shadow: 0 6px 18px rgba(0,0,0,0.6); }

    /* services title like screenshot */
    .services-title {
      font-weight: 800;
      text-transform: uppercase;
      letter-spacing: 0.08em;
      text-align:center;
      color: #ffffff;
      font-size: 2.25rem; /* ~36px */
      text-shadow: 0 4px 18px rgba(0,0,0,0.6);
    }
  </style>
</head>
<body class="min-h-screen page-bg text-gray-200">

  {{-- Header: full-width dark bar --}}
  <header class="w-full bg-[var(--header-bg)] text-white">
    <div class="max-site w-full flex items-center justify-between px-6 py-4">
      <a href="{{ url('/') }}" class="flex items-center gap-3">
        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-14 w-auto object-contain">
        <div class="hidden md:block">
          <div class="text-lg font-semibold">REPAIR</div>
          <div class="text-xs text-gray-400">Computer, Laptop & Gadget Repair</div>
        </div>
      </a>

      {{-- nav + auth --}}
      <div class="flex items-center gap-6">
        <nav class="hidden lg:flex items-center gap-6 text-sm text-gray-300">
          <a href="#" class="hover:text-white">Home</a>
          <a href="#" class="hover:text-white">About Us</a>
          <a href="#services" class="hover:text-white">Services</a>
          <a href="#" class="hover:text-white">Prices</a>
          <a href="#" class="hover:text-white">Contacts</a>
        </nav>

        {{-- auth (Breeze-friendly) --}}
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

  {{-- HERO: big blue banner (full width). You can replace hero image with hero-banner.png --}}
  <section class="w-full hero-blue relative">
    <div class="max-site flex flex-col lg:flex-row items-center gap-8 px-6 py-10 lg:py-20">
      {{-- left text block --}}
      <div class="lg:flex-1 hero-content">
        <h3 class="uppercase tracking-widest text-sm mb-3">Tablets & Phones</h3>
        <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold leading-tight mb-4">REPAIR SERVICE</h1>
        <p class="max-w-xl text-gray-100/85 mb-6">Anytime anywhere — professional repairs for mobile devices, laptops, printers and more.</p>

        <div class="flex items-center gap-4">
          <a href="#services" class="px-6 py-3 bg-white text-[var(--hero-blue-a)] rounded font-semibold">Inquire now</a>
          <a href="#" class="px-6 py-3 border border-white/30 text-white rounded">Learn more</a>
        </div>
      </div>

      {{-- right hero visual --}}
      <div class="w-full lg:w-[560px] shrink-0">
        @if (file_exists(public_path('images/hero-banner.png')))
          <img src="{{ asset('images/hero-banner.png') }}" alt="Hero" class="w-full h-full object-contain">
        @else
          <div class="w-full h-56 lg:h-72 bg-black/10 rounded shadow-inner border border-white/5"></div>
        @endif
      </div>
    </div>

    {{-- curved dark plane under hero (main band) --}}
    <div class="w-full main-band mt-6 py-14">
      <div class="max-site text-center px-6">
        <h2 class="text-2xl md:text-3xl font-bold text-white">PROFESSIONAL COMPUTER REPAIR SERVICE</h2>
        <p class="mt-3 text-gray-300">call for immediate assistance <span class="font-bold" style="color:var(--accent)">Kuya pete's num</span></p>
      </div>
    </div>
  </section>

  {{-- SERVICES section: centered title and grouped/centered cards --}}
  <section id="services" class="w-full py-12">
    <div class="max-site px-6">
      {{-- Title centered like screenshot --}}
      <div class="mb-10">
        <h3 class="services-title">Our Services</h3>
      </div>

      {{-- Services viewport (relative for arrows) --}}
      <div class="relative">
        {{-- left arrow (vertically centered) --}}
        <button id="svc-prev" class="absolute left-2 -translate-y-1/2 top-1/2 svc-arrow z-20" aria-label="Previous">
          <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none"><path d="M15 18l-6-6 6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
        </button>

        {{-- right arrow --}}
        <button id="svc-next" class="absolute right-2 -translate-y-1/2 top-1/2 svc-arrow z-20" aria-label="Next">
          <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none"><path d="M9 6l6 6-6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
        </button>

        {{-- viewport and sliding track: center the items and add small gaps --}}
        <div class="overflow-hidden">
          <div class="flex transition-transform duration-500 ease-in-out services-track items-start justify-center gap-6">
            @php
              $services = [
                ['title'=>'Notebook','img'=>'images/svc-notebook.png','subtitle'=>'increase speed'],
                ['title'=>'Macbook Pro','img'=>'images/svc-macbook.png','subtitle'=>'setup & repair'],
                ['title'=>'Laptop','img'=>'images/svc-laptop.png','subtitle'=>'diagnostic'],
                ['title'=>'Cartridge','img'=>'images/svc-printer.png','subtitle'=>'replacement'],
                ['title'=>'Hard Disk','img'=>'images/svc-hdd.png','subtitle'=>'restoration'],
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

                  <p class="text-xs text-gray-400 mt-4 hidden lg:block">Donec purus velit, vehicula in consectetur id, sagittis id velit.</p>

                  <a href="#" class="mt-6 px-4 py-2 bg-gray-800 text-white rounded text-sm">more</a>
                </div>
              </div>
            @endforeach

          </div>
        </div>

        {{-- dots (kept for visual paging) --}}
        <div id="svc-dots" class="mt-6 flex justify-center gap-2"></div>
      </div>
    </div>
  </section>

  {{-- Carousel JS: responsive paging with prev/next and dots --}}
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
        if (w >= 1280) return 5; // xl
        if (w >= 1024) return 4; // lg
        if (w >= 768)  return 3; // md
        if (w >= 640)  return 2; // sm
        return 1;                 // xs
      }

      function layout(){
        perView = calcPerView();
        const container = document.querySelector('.max-site') || document.body;
        // viewport width inside container minus some padding
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

  {{-- Livewire assets if available --}}
  @if (class_exists(\Livewire\Livewire::class))
    @livewireScripts
    @livewireStyles
  @endif

</body>
</html>
