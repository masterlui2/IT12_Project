<script src="//unpkg.com/alpinejs" defer></script>
<header class="bg-black">
  <nav class="mx-auto max-w-7xl flex items-center justify-between px-6 lg:px-4 py-5">
    <a href="{{ url('/') }}" class="flex items-center gap-4">
      <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-20 w-auto object-contain">
      <span class="text-white font-extrabold uppercase tracking-wide text-2xl leading-none">TECHNE FIXER</span>
    </a>
<<<<<<< HEAD
    <div class="hidden lg:flex items-center gap-8">
      <a href="#home" class="text-gray-300 hover:text-white">About Us</a>
      <a href="#services" class="text-gray-300 hover:text-white">Services</a>
      <a href="#contact" class="text-gray-300 hover:text-white">Contact Us</a>
=======

    <!-- Center: Nav Links -->
    <div class="hidden lg:flex items-center gap-6">
      <a href="#home" class="text-sm font-medium text-gray-300 hover:text-white transition-colors">
        About Us
      </a>
      <a href="{{ route('feedback.create') }}" class="text-sm font-medium text-gray-300 hover:text-white transition-colors">

        Feedbacks
      </a>
      <a href="#services" class="text-sm font-medium text-gray-300 hover:text-white transition-colors">
        Services
      </a>
      <a href="#contact" class="text-sm font-medium text-gray-300 hover:text-white transition-colors">
        Contact Us
      </a>

      @auth
        <span class="h-5 w-px bg-white/10"></span>
       
        <a href="{{ route('customer.messages') }}" class="text-sm font-medium text-gray-300 hover:text-white transition-colors">
          Messages
        </a>
      @endauth
>>>>>>> e64a7d42cf285e1828b26c2bb2ce29435ee09de9
    </div>
    <div class="hidden lg:flex items-center gap-4">
  @if (Route::has('login'))
    @auth
        <!-- Modern Dropdown -->
        <div class="relative" x-data="{ open: false }">
            <!-- Dropdown Trigger -->
            <button 
                @click="open = !open"
                class="flex items-center gap-2 px-3 py-2 transition-all duration-200 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 group"
            >
                <!-- User Avatar (optional) -->
                <div class="flex items-center justify-center w-8 h-8 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full">
                    <span class="text-sm font-medium text-white">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </span>
                </div>
                
                <!-- User Name -->
                <span class="text-sm font-medium text-gray-700 dark:text-gray-200">
                    {{ Auth::user()->name }}
                </span>
                
                <!-- Animated Chevron -->
                <svg 
                    class="w-4 h-4 text-gray-500 transition-transform duration-200" 
                    :class="{ 'rotate-180': open }"
                    fill="none" 
                    viewBox="0 0 24 24" 
                    stroke="currentColor"
                >
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </button>

            <!-- Dropdown Menu -->
            <div 
                x-show="open"
                @click.away="open = false"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-75"
                x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95"
                class="absolute right-0 z-50 w-48 mt-2 origin-top-right bg-white dark:bg-gray-800 rounded-xl shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
                style="display: none;"
            >
                <div class="p-2">
                    <!-- Profile Link -->
                    <a 
                        href="{{ route('profile.edit') }}"
                        class="flex items-center px-3 py-2 text-sm text-gray-700 transition-colors duration-150 rounded-lg hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-700 group"
                    >
                        <svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        Account
                    </a>

                    <!-- Logout Form -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button 
                            type="submit"
                            class="flex items-center w-full px-3 py-2 text-sm text-red-600 transition-colors duration-150 rounded-lg hover:bg-red-50 dark:text-red-400 dark:hover:bg-red-900/20 group"
                        >
                            <svg class="w-5 h-5 mr-3 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                            Log Out
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @else
        <!-- Modern Login/Register Links -->
        <div class="flex items-center gap-3">
            <a 
                href="{{ route('login') }}"
                class="text-sm font-medium text-gray-700 transition-colors duration-200 hover:text-gray-900 dark:text-gray-300 dark:hover:text-white"
            >
                Log in
            </a>
            
            @if (Route::has('register'))
                <a 
                    href="{{ route('register') }}"
                    class="text-sm font-medium text-white bg-gradient-to-r from-blue-500 to-purple-600 px-4 py-2 rounded-lg transition-all duration-200 hover:shadow-lg hover:from-blue-600 hover:to-purple-700"
                >
                    Register
                </a>
            @endif
        </div>
    @endauth
@endif
    </div>
  </nav>
</header>