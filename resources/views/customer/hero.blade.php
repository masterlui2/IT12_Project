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
                    <span class="gradient-text">Expert</span> Hardware Repair & Support
                </h1>
                
                <p class="text-lg md:text-xl text-gray-300 max-w-lg mx-auto lg:mx-0 leading-relaxed mb-8">
                    Professional repair services for computers, laptops, gadgets, and home appliances. 
                    Fast, reliable, and affordable solutions to keep your devices running smoothly.
                </p>
                
                <div class="flex flex-col sm:flex-row justify-center lg:justify-start gap-4 mb-10">
                    <a href="{{ route('inquiry.create') }}" class="btn-primary px-8 py-4 text-white rounded-lg font-semibold text-lg shadow-lg">
                        <i class="fas fa-calendar-check mr-2"></i> {{ __('Inquire') }}
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

            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-8 items-stretch">
                <!-- (service cards here) -->
                <!-- Card 1: Computer & Laptop Repair -->
                <div class="group bg-gray-800 border border-gray-700 rounded-2xl p-6 h-60 flex flex-col items-center text-center hover:bg-gray-750 transition-all duration-300 hover:-translate-y-2 hover:shadow-xl">
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
                <div class="group bg-gray-800 border border-gray-700 rounded-2xl p-6 h-60 flex flex-col items-center text-center hover:bg-gray-750 transition-all duration-300 hover:-translate-y-2 hover:shadow-xl">
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
                <div class="group bg-gray-800 border border-gray-700 rounded-2xl p-6 h-60 flex flex-col items-center text-center hover:bg-gray-750 transition-all duration-300 hover:-translate-y-2 hover:shadow-xl">
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
                <div class="group bg-gray-800 border border-gray-700 rounded-2xl p-6 h-60 flex flex-col items-center text-center hover:bg-gray-750 transition-all duration-300 hover:-translate-y-2 hover:shadow-xl">
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
                <div class="group bg-gray-800 border border-gray-700 rounded-2xl p-6 h-60 flex flex-col items-center text-center hover:bg-gray-750 transition-all duration-300 hover:-translate-y-2 hover:shadow-xl">
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
                <div class="group bg-gray-800 border border-gray-700 rounded-2xl p-6 h-60 flex flex-col items-center text-center hover:bg-gray-750 transition-all duration-300 hover:-translate-y-2 hover:shadow-xl">
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
    </section>

    <!-- ABOUT US SECTION (ADDED) -->
    <section id="about-us" class="bg-black py-16 text-center">
      <div class="max-w-4xl mx-auto px-6">
        <h3 class="text-white text-3xl font-bold mb-4">About Us</h3>
        <hr class="border-gray-700 w-20 mx-auto mb-6">

        <p class="text-gray-300 leading-relaxed font-medium mb-4">
          Techne-Fixer Computer and Technologies is a Filipino-owned repair and maintenance service business 
          founded in 2023 in Toril, Davao City. Built from years of hands-on technical experience, the business 
          provides reliable repair, installation, diagnostics, and maintenance for computers, laptops, mobile 
          phones, air-conditioning units, printers, CCTV systems, and washing machines.
        </p>

        <p class="text-gray-300 leading-relaxed font-medium mb-4">
          With a dedicated team composed of the owner, an apprentice, a regular technician, and a freelance 
          bookkeeper, Techne-Fixer serves both walk-in clients and online inquiries daily. The shop operates 
          seven days a week to ensure availability, quick assistance, and dependable service for all customers.
        </p>

        <p class="text-gray-300 leading-relaxed font-medium">
          Our mission is to deliver trusted, efficient, and transparent repair solutions—combining technical expertise, 
          modern tools, and customer-centered service. Techne-Fixer continues to grow through community trust, 
          strong online presence, and consistent customer referrals.
        </p>
      </div>
    </section>

    <!-- FEEDBACK / TESTIMONIALS SECTION -->
    <section id="feedback" class="bg-black py-16">
      <div class="max-w-7xl mx-auto px-6">
        <h3 class="text-white text-3xl font-bold text-center mb-2">
          Read what our customers say
        </h3>
        <p class="text-center text-gray-400 mb-10 text-sm">
          Real experiences from our satisfied clients.
        </p>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
          <!-- Card 1 -->
          <div class="flex items-start gap-5 bg-gray-800 rounded-2xl p-6 h-full">
            <div class="flex-shrink-0">
              <div class="w-20 h-20 rounded-full border-4 border-blue-400 overflow-hidden">
                <img src="{{ asset('what customer say/letterk.png') }}" alt="Kristel Villame" class="w-full h-full object-cover">
              </div>
            </div>
            <div class="flex flex-col h-full w-full">
              <p class="text-sm text-gray-300 mb-3 flex-grow">
                “I had a great experience here, especially with Sir Pete, the owner. He’s very reliable and did an excellent job fixing my tech gadgets. 
                He also installs dental chairs, CCTVs, and repairs all kinds of electronic devices. 
                Everything is now working perfectly! Highly recommended!”
              </p>
              <div class="w-full">
                <div class="flex justify-between items-center">
                    <p class="font-semibold text-white">Kristel Villame</p>
                    <span>⭐⭐⭐⭐⭐</span>
                </div>
                <p class="text-xs text-gray-400">Customer</p>
              </div>
            </div>
          </div>

          <!-- Card 2 -->
          <div class="flex items-start gap-5 bg-gray-800 rounded-2xl p-6 h-full">
            <div class="flex-shrink-0">
              <div class="w-20 h-20 rounded-full border-4 border-blue-400 overflow-hidden">
                <img src="{{ asset('what customer say/arnelpajota.png') }}" alt="Arnel Pajota" class="w-full h-full object-cover">
              </div>
            </div>
            <div class="flex flex-col h-full w-full">
              <p class="text-sm text-gray-300 mb-3 flex-grow">
                “Absolutely Outstanding Service!
                I had a great experience at this shop! The staff were friendly, knowledgeable, and honest with their recommendations. 
                They fixed my device quickly and even explained the problem clearly. 
                Prices are fair, and the quality of work is top-notch. 
                Highly recommended if you're looking for reliable electronics repair in Toril Davao City. I’ll definitely be coming back!.”
              </p>
              <div class="w-full">
                <div class="flex justify-between items-center">
                    <p class="font-semibold text-white">Arnel Pajota</p>
                    <span>⭐⭐⭐⭐⭐</span>
                </div>
                <p class="text-xs text-gray-400">Customer</p>
              </div>
            </div>
          </div>

          <!-- Card 3 -->
          <div class="flex items-start gap-5 bg-gray-800 rounded-2xl p-6 h-full">
            <div class="flex-shrink-0">
              <div class="w-20 h-20 rounded-full border-4 border-blue-400 overflow-hidden">
                <img src="{{ asset('what customer say/letterx.jpg') }}" alt="XCL 88" class="w-full h-full object-cover">
              </div>
            </div>
            <div class="flex flex-col h-full w-full">
              <p class="text-sm text-gray-300 mb-3 flex-grow">
                “Explains where the problem occurred. Provides options available for resolution.”
              </p>
              <div class="w-full">
                <div class="flex justify-between items-center">
                    <p class="font-semibold text-white">XCL 88</p>
                    <span>⭐⭐⭐⭐⭐</span>
                </div>
                <p class="text-xs text-gray-400">Customer</p>
              </div>
            </div>
          </div>

          <!-- Card 4 -->
          <div class="flex items-start gap-5 bg-gray-800 rounded-2xl p-6 h-full">
            <div class="flex-shrink-0">
              <div class="w-20 h-20 rounded-full border-4 border-blue-400 overflow-hidden">
                <img src="{{ asset('what customer say/letterc.png') }}" alt="Christian Vincent Pacleb" class="w-full h-full object-cover">
              </div>
            </div>
            <div class="flex flex-col h-full w-full">
              <p class="text-sm text-gray-300 mb-3 flex-grow">
                “Reliable technicians and honest pricing. I always call Techne-Fixer for home appliance issues.”
              </p>
              <div class="w-full">
                <div class="flex justify-between items-center">
                    <p class="font-semibold text-white">Christian Vincent Pacleb</p>
                    <span>⭐⭐⭐⭐⭐</span>
                </div>
                <p class="text-xs text-gray-400">Customer</p>
              </div>
            </div>
          </div>

        </div>
      </div>
    </section>
      
</body>
</html>
