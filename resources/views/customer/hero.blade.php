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
