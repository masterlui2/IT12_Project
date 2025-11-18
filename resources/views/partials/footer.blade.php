<!-- ✅ REVISED FOOTER: LOGO ON LEFT -->
<footer class="w-full bg-black text-gray-300 mt-20 border-t border-white/10">
  <div class="max-w-7xl mx-auto px-6 py-10 flex flex-col md:flex-row md:justify-between md:items-start">

    <!-- Right side: Info groups -->
    <div class="grid grid-cols-2 md:grid-cols-3 gap-8 w-full md:w-auto">

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
      <!-- Social -->
      <div>
        <h3 class="text-white font-semibold mb-2">Social</h3>
        <ul class="space-y-1 text-sm">
          <li>
            <a href="https://www.facebook.com/profile.php?id=61577111409420"
               target="_blank"
               rel="noopener noreferrer"
               class="hover:text-white">
                    Facebook
            </a>
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