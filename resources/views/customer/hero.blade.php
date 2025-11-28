<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modern Computer Repair Services</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --hero-blue: #3b82f6;
            --hero-blue-dark: #1d4ed8;
        }
        
        .services-title {
            font-size: 2.5rem;
            font-weight: 800;
            color: white;
            position: relative;
            display: inline-block;
            margin-bottom: 1rem;
        }
        
        .services-title::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 4px;
            background: linear-gradient(to right, var(--hero-blue), var(--hero-blue-dark));
            border-radius: 2px;
        }
        
        .gradient-text {
            background: linear-gradient(to right, #ffffff, #e0e7ff);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .hero-bg {
            background: linear-gradient(135deg, #1f2937 0%, #374151 100%);
        }
        
        .btn-primary {
            background: linear-gradient(to right, var(--hero-blue), var(--hero-blue-dark));
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(59, 130, 246, 0.3);
        }
        
        .btn-secondary {
            transition: all 0.3s ease;
            border: 2px solid white;
        }
        
        .btn-secondary:hover {
            background-color: white;
            color: #1f2937;
            transform: translateY(-2px);
        }
        
        .floating-animation {
            animation: float 6s ease-in-out infinite;
        }
        
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-15px); }
            100% { transform: translateY(0px); }
        }
        
        .fade-in {
            animation: fadeIn 1s ease-out forwards;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body class="bg-gray-900">
    <!-- Hero Section -->
    <section id="home" class="hero-bg py-16 md:py-24 overflow-hidden">
        <div class="mx-auto max-w-7xl flex flex-col lg:flex-row items-center gap-12 px-6">
            <!-- Hero Text -->
            <div class="flex-1 text-center lg:text-left fade-in">
                <div class="mb-2">
                    <span class="inline-block px-4 py-1 bg-blue-900/30 text-blue-300 rounded-full text-sm font-medium border border-blue-800/50">
                        <i class="fas fa-tools mr-1"></i> Trusted Tech Solutions
                    </span>
                </div>
                
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white leading-tight mb-6">
                    <span class="gradient-text">Expert</span> Device Repair & Support
                </h1>
                
                <p class="text-lg md:text-xl text-gray-300 max-w-lg mx-auto lg:mx-0 leading-relaxed mb-8">
                    Professional repair services for computers, laptops, gadgets, and home appliances. 
                    Fast, reliable, and affordable solutions to keep your devices running smoothly.
                </p>
                
                <div class="flex flex-col sm:flex-row justify-center lg:justify-start gap-4 mb-10">
                    <a href="{{ route('inquiry.create') }}"  class="btn-primary px-8 py-4 text-white rounded-lg font-semibold text-lg shadow-lg">
                        <i class="fas fa-calendar-check mr-2"></i> Inquire Now
                    </a>
                    <a href="#contact" class="btn-secondary px-8 py-4 text-white rounded-lg font-semibold text-lg">
                        <i class="fas fa-phone-alt mr-2"></i> Contact Us
                    </a>
                </div>
      
                <div class="flex flex-wrap justify-center lg:justify-start gap-6 text-gray-400 text-sm">
                    <div class="flex items-center">
                        <i class="fas fa-clock text-blue-400 mr-2"></i>
                        <span>Same Day Service</span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-shield-alt text-blue-400 mr-2"></i>
                        <span>90-Day Warranty</span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-home text-blue-400 mr-2"></i>
                        <span>On-Site Support</span>
                    </div>
                </div>
            </div>
            
            <!-- Hero Image -->
            <div class="flex-1 relative">
                <div class="floating-animation">
                    <div class="relative bg-gradient-to-br from-blue-500/10 to-purple-600/10 rounded-2xl p-8 border border-gray-700/50 backdrop-blur-sm">
                        <div class="bg-gray-800 rounded-xl p-6 shadow-2xl">
                            <div class="flex space-x-2 mb-4">
                                <div class="w-3 h-3 rounded-full bg-red-500"></div>
                                <div class="w-3 h-3 rounded-full bg-yellow-500"></div>
                                <div class="w-3 h-3 rounded-full bg-green-500"></div>
                            </div>
                            <div class="bg-gray-900 rounded-lg p-4 text-center">
                                <i class="fas fa-laptop-code text-5xl text-blue-400 mb-4"></i>
                                <h3 class="text-white font-semibold text-lg mb-2">Diagnostics Complete</h3>
                                <p class="text-gray-400 text-sm">Your device is ready for repair</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Floating elements -->
                <div class="absolute -top-4 -left-4 w-20 h-20 bg-blue-500/20 rounded-full blur-xl"></div>
                <div class="absolute -bottom-4 -right-4 w-24 h-24 bg-purple-500/20 rounded-full blur-xl"></div>
            </div>
        </div>
    </section>

  <!-- Services / Icon Blocks -->
<section id="services" class="bg-gray-900 py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-16 text-center">
            <h2 class="services-title">Our Services</h2>
            <p class="text-gray-400 max-w-2xl mx-auto text-lg">
                Comprehensive repair and maintenance services for all your devices and appliances
            </p>
        </div>

        <div class="relative">
            <!-- Left Arrow -->
            <button
                id="servicesPrev"
                type="button"
                class="hidden md:flex items-center justify-center absolute -left-14 top-1/2 -translate-y-1/2 w-10 h-10 rounded-full bg-gray-800 border border-gray-700 text-gray-300 hover:bg-gray-700 hover:text-white shadow-lg z-10"
            >
                <i class="fas fa-chevron-left text-sm"></i>
            </button>

            <!-- Right Arrow -->
            <button
                id="servicesNext"
                type="button"
                class="hidden md:flex items-center justify-center absolute -right-14 top-1/2 -translate-y-1/2 w-10 h-10 rounded-full bg-gray-800 border border-gray-700 text-gray-300 hover:bg-gray-700 hover:text-white shadow-lg z-10"
            >
                <i class="fas fa-chevron-right text-sm"></i>
            </button>

            <!-- Cards container -->
            <div
                id="servicesSlider"
                class="grid grid-cols-1 md:grid-cols-3 gap-8 items-stretch"
            >
                <!-- Card 1: Computer & Laptop Repair -->
                <div class="service-card group bg-gray-800 border border-gray-700 rounded-2xl p-6 h-60 flex flex-col items-center text-center hover:bg-gray-750 transition-all duration-300 hover:-translate-y-2 hover:shadow-xl">
                    <div class="flex items-center justify-center w-16 h-16 rounded-full bg-blue-900/30 border border-blue-700/30 mb-4 group-hover:bg-blue-900/50 transition-colors">
                        <i class="fas fa-laptop-code text-blue-400 text-2xl"></i>
                    </div>

                    <h3 class="font-bold text-gray-100 text-lg mb-2">Computer & Laptop Repair</h3>
                    <p class="text-gray-400 text-sm flex-grow">
                        Full diagnostics, performance tuning, OS issues, virus removal, and hardware replacement.
                    </p>

                    <div class="mt-4 flex items-center justify-center text-blue-400 group-hover:text-blue-300 transition-colors">
                        <span class="text-sm font-medium mr-2">Learn more</span>
                        <i class="fas fa-arrow-right text-xs transition-transform group-hover:translate-x-1"></i>
                    </div>
                </div>

                <!-- Card 2: Phone & Gadget Support -->
                <div class="service-card group bg-gray-800 border border-gray-700 rounded-2xl p-6 h-60 flex flex-col items-center text-center hover:bg-gray-750 transition-all duration-300 hover:-translate-y-2 hover:shadow-xl">
                    <div class="flex items-center justify-center w-16 h-16 rounded-full bg-emerald-900/30 border border-emerald-700/30 mb-4 group-hover:bg-emerald-900/50 transition-colors">
                        <i class="fas fa-mobile-alt text-emerald-400 text-2xl"></i>
                    </div>

                    <h3 class="font-bold text-gray-100 text-lg mb-2">Phone & Gadget Support</h3>
                    <p class="text-gray-400 text-sm flex-grow">
                        Screen and battery replacement, setup, data transfer, and troubleshooting for phones and tablets.
                    </p>

                    <div class="mt-4 flex items-center justify-center text-emerald-400 group-hover:text-emerald-300 transition-colors">
                        <span class="text-sm font-medium mr-2">Learn more</span>
                        <i class="fas fa-arrow-right text-xs transition-transform group-hover:translate-x-1"></i>
                    </div>
                </div>

                <!-- Card 3: Aircon Service -->
                <div class="service-card group bg-gray-800 border border-gray-700 rounded-2xl p-6 h-60 flex flex-col items-center text-center hover:bg-gray-750 transition-all duration-300 hover:-translate-y-2 hover:shadow-xl">
                    <div class="flex items-center justify-center w-16 h-16 rounded-full bg-cyan-900/30 border border-cyan-700/30 mb-4 group-hover:bg-cyan-900/50 transition-colors">
                        <i class="fas fa-wind text-cyan-400 text-2xl"></i>
                    </div>

                    <h3 class="font-bold text-gray-100 text-lg mb-2">Aircon Cleaning & Repair</h3>
                    <p class="text-gray-400 text-sm flex-grow">
                        Installation, deep cleaning, freon check, and repair for window and split-type air conditioners.
                    </p>

                    <div class="mt-4 flex items-center justify-center text-cyan-400 group-hover:text-cyan-300 transition-colors">
                        <span class="text-sm font-medium mr-2">Learn more</span>
                        <i class="fas fa-arrow-right text-xs transition-transform group-hover:translate-x-1"></i>
                    </div>
                </div>

                <!-- Card 4: Printer Services -->
                <div class="service-card group bg-gray-800 border border-gray-700 rounded-2xl p-6 h-60 flex flex-col items-center text-center hover:bg-gray-750 transition-all duration-300 hover:-translate-y-2 hover:shadow-xl">
                    <div class="flex items-center justify-center w-16 h-16 rounded-full bg-purple-900/30 border border-purple-700/30 mb-4 group-hover:bg-purple-900/50 transition-colors">
                        <i class="fas fa-print text-purple-400 text-2xl"></i>
                    </div>

                    <h3 class="font-bold text-gray-100 text-lg mb-2">Printer Setup & Repair</h3>
                    <p class="text-gray-400 text-sm flex-grow">
                        Printer installation, paper feed issues, ink system problems, and network printing setup.
                    </p>

                    <div class="mt-4 flex items-center justify-center text-purple-400 group-hover:text-purple-300 transition-colors">
                        <span class="text-sm font-medium mr-2">Learn more</span>
                        <i class="fas fa-arrow-right text-xs transition-transform group-hover:translate-x-1"></i>
                    </div>
                </div>

                <!-- Card 5: Washing Machine Repair -->
                <div class="service-card group bg-gray-800 border border-gray-700 rounded-2xl p-6 h-60 flex flex-col items-center text-center hover:bg-gray-750 transition-all duration-300 hover:-translate-y-2 hover:shadow-xl">
                    <div class="flex items-center justify-center w-16 h-16 rounded-full bg-pink-900/30 border border-pink-700/30 mb-4 group-hover:bg-pink-900/50 transition-colors">
                        <i class="fas fa-soap text-pink-400 text-2xl"></i>
                    </div>

                    <h3 class="font-bold text-gray-100 text-lg mb-2">Washing Machine Repair</h3>
                    <p class="text-gray-400 text-sm flex-grow">
                        Drum, motor, water flow, and control panel issues for automatic and semi-auto washers.
                    </p>

                    <div class="mt-4 flex items-center justify-center text-pink-400 group-hover:text-pink-300 transition-colors">
                        <span class="text-sm font-medium mr-2">Learn more</span>
                        <i class="fas fa-arrow-right text-xs transition-transform group-hover:translate-x-1"></i>
                    </div>
                </div>

                <!-- Card 6: Network & On-site Support -->
                <div class="service-card group bg-gray-800 border border-gray-700 rounded-2xl p-6 h-60 flex flex-col items-center text-center hover:bg-gray-750 transition-all duration-300 hover:-translate-y-2 hover:shadow-xl">
                    <div class="flex items-center justify-center w-16 h-16 rounded-full bg-amber-900/30 border border-amber-700/30 mb-4 group-hover:bg-amber-900/50 transition-colors">
                        <i class="fas fa-wifi text-amber-400 text-2xl"></i>
                    </div>

                    <h3 class="font-bold text-gray-100 text-lg mb-2">Network & On-site Support</h3>
                    <p class="text-gray-400 text-sm flex-grow">
                        Home and small office network setup, Wi-Fi issues, and on-site technical assistance.
                    </p>

                    <div class="mt-4 flex items-center justify-center text-amber-400 group-hover:text-amber-300 transition-colors">
                        <span class="text-sm font-medium mr-2">Learn more</span>
                        <i class="fas fa-arrow-right text-xs transition-transform group-hover:translate-x-1"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </section>
@include('customer.about-feedback')
        
<script>
        // Simple animation on scroll
        document.addEventListener('DOMContentLoaded', function() {
            const fadeElements = document.querySelectorAll('.fade-in');
            
            const fadeInOnScroll = function() {
                fadeElements.forEach(element => {
                    const elementTop = element.getBoundingClientRect().top;
                    const elementVisible = 150;
                    
                    if (elementTop < window.innerHeight - elementVisible) {
                        element.classList.add('fade-in');
                    }
                });
            };
            
            // Initial check
            fadeInOnScroll();
            
            // Check on scroll
            window.addEventListener('scroll', fadeInOnScroll);
        });
          document.addEventListener('DOMContentLoaded', function () {
            const visibleCount = 3; // max cards to show at once
            const cards = Array.from(document.querySelectorAll('#servicesSlider .service-card'));
            const prevBtn = document.getElementById('servicesPrev');
            const nextBtn = document.getElementById('servicesNext');

            if (!cards.length) return;

            let startIndex = 0;

            function renderServicesSlider() {
                // hide all
                cards.forEach(card => card.classList.add('hidden'));

                // show only the current 3
                for (let i = startIndex; i < startIndex + visibleCount && i < cards.length; i++) {
                    cards[i].classList.remove('hidden');
                }

                // update arrow state
                if (startIndex <= 0) {
                    prevBtn.classList.add('opacity-40', 'pointer-events-none');
                } else {
                    prevBtn.classList.remove('opacity-40', 'pointer-events-none');
                }

                if (startIndex + visibleCount >= cards.length) {
                    nextBtn.classList.add('opacity-40', 'pointer-events-none');
                } else {
                    nextBtn.classList.remove('opacity-40', 'pointer-events-none');
                }
            }

            // Show arrows only if needed
            if (cards.length > visibleCount) {
                prevBtn.classList.remove('hidden');
                nextBtn.classList.remove('hidden');
            }

            prevBtn?.addEventListener('click', function () {
                if (startIndex > 0) {
                    startIndex -= visibleCount;
                    if (startIndex < 0) startIndex = 0;
                    renderServicesSlider();
                }
            });

            nextBtn?.addEventListener('click', function () {
                if (startIndex + visibleCount < cards.length) {
                    startIndex += visibleCount;
                    renderServicesSlider();
                }
            });

            // initial render
            renderServicesSlider();
        });
    </script>
</body>
</html>