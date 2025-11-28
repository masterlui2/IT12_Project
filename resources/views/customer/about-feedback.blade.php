{{-- resources/views/customer/about-feedback.blade.php --}}

{{-- ABOUT US SECTION --}}
<section id="about" class="bg-gray-900 py-16 border-t border-gray-800">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">
        <div class="grid lg:grid-cols-2 gap-12 items-center">
            {{-- Text --}}
            <div>
                <span class="inline-block px-10 py-1 mb-4 bg-blue-900/30 text-blue-300 rounded-full text-xl font-semibold border border-blue-800/60">
                    About Us
                </span>

                <h2 class="text-3xl md:text-4xl font-extrabold text-white mb-4">
                    Reliable Tech & Home Appliance Services You Can Trust
                </h2>

                <p class="text-gray-300 leading-relaxed mb-4">
                    We provide professional repair and maintenance services for computers, laptops, gadgets,
                    air conditioners, washing machines, and more. Our goal is simple: to keep your devices
                    running at their best so you can focus on what matters most.
                </p>

                <p class="text-gray-400 leading-relaxed mb-6">
                    With experienced technicians, fair pricing, and customer-first service, we’ve helped
                    homeowners and small businesses solve their tech and appliance problems quickly and
                    efficiently.
                </p>

                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div class="flex items-start space-x-3">
                        <div class="mt-1">
                            <i class="fas fa-check-circle text-blue-400"></i>
                        </div>
                        <div>
                            <p class="text-gray-200 font-semibold">Experienced Technicians</p>
                            <p class="text-gray-400">Years of hands-on repair experience.</p>
                        </div>
                    </div>

                    <div class="flex items-start space-x-3">
                        <div class="mt-1">
                            <i class="fas fa-check-circle text-blue-400"></i>
                        </div>
                        <div>
                            <p class="text-gray-200 font-semibold">Transparent Pricing</p>
                            <p class="text-gray-400">No hidden charges, honest assessment.</p>
                        </div>
                    </div>

                    <div class="flex items-start space-x-3">
                        <div class="mt-1">
                            <i class="fas fa-check-circle text-blue-400"></i>
                        </div>
                        <div>
                            <p class="text-gray-200 font-semibold">Fast Turnaround</p>
                            <p class="text-gray-400">Same-day or next-day service options.</p>
                        </div>
                    </div>

                    <div class="flex items-start space-x-3">
                        <div class="mt-1">
                            <i class="fas fa-check-circle text-blue-400"></i>
                        </div>
                        <div>
                            <p class="text-gray-200 font-semibold">Warranty Provided</p>
                            <p class="text-gray-400">Service warranty for your peace of mind.</p>
                        </div>
                    </div>
                </div>
            </div>
{{-- Side Card / Image Slider --}}
<div class="bg-gray-900/80 border h-150 border-gray-700 rounded-2xl p-6 shadow-xl">

    <div class="relative overflow-hidden rounded-xl" id="aboutSlider">
        <div class="flex transition-transform duration-700" id="aboutSlides">
            {{-- Slide 1 --}}
            <img src="{{ asset('images/about/tech.png') }}" class="w-full h-[540px] object-cover flex-shrink-0 rounded-xl">
            
            {{-- Slide 2 --}}
            <img src="{{ asset('images/about/s2.jpg') }}" class="w-full h-[540px] object-cover flex-shrink-0 rounded-xl">

            {{-- Slide 3 --}}
            <img src="{{ asset('images/about/s3.jpg') }}" class="w-full h-[540px] object-cover flex-shrink-0 rounded-xl">
        </div>

        {{-- Arrows --}}
        <button id="aboutPrev"
            class="absolute left-3 top-1/2 -translate-y-1/2 bg-gray-900/60 hover:bg-gray-900 text-white p-2 rounded-full">
            <i class="fas fa-chevron-left text-sm"></i>
        </button>

        <button id="aboutNext"
            class="absolute right-3 top-1/2 -translate-y-1/2 bg-gray-900/60 hover:bg-gray-900 text-white p-2 rounded-full">
            <i class="fas fa-chevron-right text-sm"></i>
        </button>

        {{-- Dots --}}
        <div class="absolute bottom-3 left-1/2 -translate-x-1/2 flex space-x-2" id="aboutDots">
            <div class="w-3 h-3 rounded-full bg-gray-400 cursor-pointer"></div>
            <div class="w-3 h-3 rounded-full bg-gray-600 cursor-pointer"></div>
            <div class="w-3 h-3 rounded-full bg-gray-600 cursor-pointer"></div>
        </div>
    </div>
</div>

        </div>
    </div>
</section>

{{-- CUSTOMER FEEDBACK / TESTIMONIALS --}}
<section id="feedback" class="bg-gray-950 py-16 border-t border-gray-800">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">
        <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-4 mb-10">
            <div>
                <span class="inline-block px-4 py-1 mb-3 bg-emerald-900/30 text-emerald-300 rounded-full text-xs font-semibold border border-emerald-800/60">
                    Customer Feedback
                </span>
                <h2 class="text-3xl md:text-4xl font-extrabold text-white">
                    What Our Customers Say
                </h2>
                <p class="text-gray-400 mt-2">
                    Real experiences from people who trusted us with their devices and appliances.
                </p>
            </div>

            <a href="#contact" class="inline-flex items-center text-sm font-semibold text-emerald-300 hover:text-emerald-200">
                <i class="fas fa-comment-dots mr-2"></i>
                Leave your feedback
            </a>
        </div>

        {{-- Testimonials Grid --}}
        <div class="grid md:grid-cols-3 gap-8">
            {{-- Card 1 --}}
            <div class="bg-gray-900 border border-gray-800 rounded-2xl p-6 shadow-md flex flex-col">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <p class="text-white font-semibold text-sm">Mark R.</p>
                        <p class="text-gray-400 text-xs">Laptop Repair</p>
                    </div>
                    <div class="flex items-center text-yellow-400 text-xs">
                        <i class="fas fa-star mr-1"></i> 5.0
                    </div>
                </div>
                <p class="text-gray-300 text-sm leading-relaxed flex-grow">
                    “They fixed my laptop in just one day. Clear explanation of the problem,
                    fair pricing, and it runs much faster now. Highly recommended!”
                </p>
            </div>

            {{-- Card 2 --}}
            <div class="bg-gray-900 border border-gray-800 rounded-2xl p-6 shadow-md flex flex-col">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <p class="text-white font-semibold text-sm">Jen A.</p>
                        <p class="text-gray-400 text-xs">Aircon Cleaning</p>
                    </div>
                    <div class="flex items-center text-yellow-400 text-xs">
                        <i class="fas fa-star mr-1"></i> 4.9
                    </div>
                </div>
                <p class="text-gray-300 text-sm leading-relaxed flex-grow">
                    “Very professional and on time. Our aircon is now cooling properly and
                    they left the area clean after the service.”
                </p>
            </div>

            {{-- Card 3 --}}
            <div class="bg-gray-900 border border-gray-800 rounded-2xl p-6 shadow-md flex flex-col">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <p class="text-white font-semibold text-sm">Carlos D.</p>
                        <p class="text-gray-400 text-xs">Washing Machine Repair</p>
                    </div>
                    <div class="flex items-center text-yellow-400 text-xs">
                        <i class="fas fa-star mr-1"></i> 5.0
                    </div>
                </div>
                <p class="text-gray-300 text-sm leading-relaxed flex-grow">
                    “Our washing machine stopped mid-cycle and they were able to diagnose
                    and fix it on the same day. Great service!”
                </p>
            </div>
        </div>
    </div>
</section>
<script>
document.addEventListener("DOMContentLoaded", () => {
    const slidesContainer = document.getElementById("aboutSlides");
    const dots = document.querySelectorAll("#aboutDots div");
    const totalSlides = slidesContainer.children.length;

    let currentIndex = 0;
    const slideWidth = slidesContainer.children[0].clientWidth;
    let autoSlide;

    function goToSlide(index) {
        currentIndex = index;
        slidesContainer.style.transform = `translateX(-${slideWidth * currentIndex}px)`;

        dots.forEach((dot, i) => {
            dot.classList.toggle("bg-gray-400", i === currentIndex);
            dot.classList.toggle("bg-gray-600", i !== currentIndex);
        });
    }

    function nextSlide() {
        currentIndex = (currentIndex + 1) % totalSlides;
        goToSlide(currentIndex);
    }

    function prevSlide() {
        currentIndex = (currentIndex - 1 + totalSlides) % totalSlides;
        goToSlide(currentIndex);
    }

    // Arrow Events
    document.getElementById("aboutNext").addEventListener("click", nextSlide);
    document.getElementById("aboutPrev").addEventListener("click", prevSlide);

    // Dot Events
    dots.forEach((dot, index) => {
        dot.addEventListener("click", () => goToSlide(index));
    });

    // Auto-slide every 4 seconds
    function startAutoSlide() {
        autoSlide = setInterval(nextSlide, 4000);
    }
    
    function stopAutoSlide() {
        clearInterval(autoSlide);
    }

    // Pause on hover
    document.getElementById("aboutSlider").addEventListener("mouseenter", stopAutoSlide);
    document.getElementById("aboutSlider").addEventListener("mouseleave", startAutoSlide);

    goToSlide(0);
    startAutoSlide();
});
</script>