<section id="services" class="bg-black py-16">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="mb-10 text-center">
      <h3 class="services-title">Our Services</h3>
    </div>
    <div class="grid sm:grid-cols-2 lg:grid-cols-3 items-stretch gap-6">
      <a href="{{ route('login') }}" class="group flex rounded-lg p-5 bg-gray-900/80 hover:bg-gray-800 transition-colors">
        <img src="{{ asset('images/diagnostic.jpg') }}" alt="Computer & Laptop" class="w-16 h-16 rounded-md object-cover me-4">
        <div>
          <h3 class="font-bold text-gray-100">Computer &amp; Laptop Repair</h3>
          <p class="text-gray-400 text-sm">Diagnostics, OS fixes, virus removal, hardware replacement.</p>
          <span class="mt-3 inline-flex items-center gap-1 text-sm font-semibold text-blue-300">Book a repair<svg class="size-4 transition-transform group-hover:translate-x-1" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m9 18 6-6-6-6"/></svg></span>
        </div>
      </a>
      <a href="{{ route('login') }}" class="group flex rounded-lg p-5 bg-gray-900/80 hover:bg-gray-800 transition-colors">
        <img src="{{ asset('images/upgrades-speed.jpg') }}" alt="Phone & Gadget" class="w-16 h-16 rounded-md object-cover me-4">
        <div>
          <h3 class="font-bold text-gray-100">Phone &amp; Gadget Support</h3>
          <p class="text-gray-400 text-sm">Screens, batteries, setup and troubleshooting.</p>
          <span class="mt-3 inline-flex items-center gap-1 text-sm font-semibold text-emerald-300">Talk to a technician<svg class="size-4 transition-transform group-hover:translate-x-1" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m9 18 6-6-6-6"/></svg></span>
        </div>
      </a>
      <a href="{{ route('login') }}" class="group flex rounded-lg p-5 bg-gray-900/80 hover:bg-gray-800 transition-colors">
        <img src="{{ asset('images/printer-swap.jpg') }}" alt="AC, Printer & Appliance" class="w-16 h-16 rounded-md object-cover me-4">
        <div>
          <h3 class="font-bold text-gray-100">AC, Printer &amp; Appliance Service</h3>
          <p class="text-gray-400 text-sm">Installation, cleaning, and repair.</p>
          <span class="mt-3 inline-flex items-center gap-1 text-sm font-semibold text-orange-300">Schedule a visit<svg class="size-4 transition-transform group-hover:translate-x-1" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m9 18 6-6-6-6"/></svg></span>
        </div>
      </a>
    </div>
  </div>
</section>