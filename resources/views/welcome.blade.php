<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  @include('partials.head', ['title' => 'Repair Service'])
</head>
<body class="min-h-screen bg-black text-gray-200">

@include('partials.header')


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
        <a href="#services" class="px-6 py-3 bg-white text-blue-700 rounded font-semibold uppercase">Explore Services</a>
        <a href="{{ route('login') }}" class="px-6 py-3 border border-white text-white rounded font-semibold uppercase">Inquire</a>
      </div>
    </div>
  </div>
</section>
 
@include('partials.services')

 

 

<section id="contact" class="bg-black py-12">
  <div class="max-w-7xl mx-auto px-6">
    <h3 class="services-title">Contact Us</h3>
    <div class="mt-6 grid sm:grid-cols-3 gap-6">
      <a href="tel:09662406825" class="group flex items-center gap-4 rounded-lg p-5 bg-gray-900/80 hover:bg-gray-800 transition-colors">
        <span class="w-10 h-10 rounded-full flex items-center justify-center bg-blue-500/15">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="size-5 text-blue-400"><path d="M22 16l-4 4a16 16 0 0 1-12-12l4-4" stroke-linecap="round" stroke-linejoin="round"/></svg>
        </span>
        <div>
          <div class="text-white font-semibold">Phone</div>
          <div class="text-sm text-gray-300">0966 240 6825</div>
        </div>
      </a>
      <a href="mailto:petemobilefixer2015@gmail.com" class="group flex items-center gap-4 rounded-lg p-5 bg-gray-900/80 hover:bg-gray-800 transition-colors">
        <span class="w-10 h-10 rounded-full flex items-center justify-center bg-emerald-500/15">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="size-5 text-emerald-400"><rect x="3" y="5" width="18" height="14" rx="2"/><path d="M3 7l9 6 9-6"/></svg>
        </span>
        <div>
          <div class="text-white font-semibold">Email</div>
          <div class="text-sm text-gray-300">petemobilefixer2015@gmail.com</div>
        </div>
      </a>
      <a href="https://www.facebook.com/profile.php?id=61577111409420" class="group flex items-center gap-4 rounded-lg p-5 bg-gray-900/80 hover:bg-gray-800 transition-colors">
        <span class="w-10 h-10 rounded-full flex items-center justify-center bg-blue-500/15">
          <svg viewBox="0 0 24 24" class="size-5 text-blue-500"><path d="M18 2h-3a4 4 0 0 0-4 4v3H8v4h3v9h4v-9h3l1-4h-4V6a1 1 0 0 1 1-1h3z" fill="currentColor"/></svg>
        </span>
        <div>
          <div class="text-white font-semibold">Facebook</div>
          <div class="text-sm text-gray-300">Visit our page</div>
        </div>
      </a>
    </div>
  </div>
</section>

  
  @include('partials.footer')


</body>
</html>
