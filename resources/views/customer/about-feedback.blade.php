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
{{-- LOCATION MAP SECTION --}}
<section id="location" class="bg-gray-950 py-16 border-t border-gray-800">
    <div class="max-w-7xl mx-auto px-6 lg:px-8 space-y-8">
        <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-6">
            <div>
                <span
                    class="inline-block px-4 py-1 mb-3 bg-blue-900/30 text-blue-300 rounded-full text-xs font-semibold border border-blue-800/60">
                    Find Us
                </span>
                <h2 class="text-3xl md:text-4xl font-extrabold text-white">
                    Visit Our Service Center
                </h2>
                <p class="text-gray-400 mt-2 max-w-3xl">
                    Drop by our location for consultations, walk-in diagnostics, or to pick up completed repairs.
                    We keep the space comfortable and ready to serve you.
                </p>
            </div>
            <div class="bg-gray-900 border border-gray-800 rounded-xl p-4 shadow-md text-sm text-gray-300 space-y-1">
                <p class="font-semibold text-white">Hours</p>
                <p>Mon - Sat: 9:00 AM – 6:00 PM</p>
                <p class="text-blue-200">Need help finding us? Tap the map for directions.</p>
            </div>
        </div>

        <div class="bg-gray-900 border border-gray-800 rounded-2xl overflow-hidden shadow-xl">
            <div class="relative w-full h-[420px]">
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d4078.4335142038844!2d125.49317867510116!3d7.027566117100341!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x32f90d345435ca29%3A0x956b6d7472a90432!2sTechne%20Fixer%20Computer%20and%20Laptop%20Repair%20Services%2F%20CCTV%20INSTALLATION!5e1!3m2!1sen!2sph!4v1764341286198!5m2!1sen!2sph"
                    class="absolute inset-0 w-full h-full border-0" style="border:0;" allowfullscreen="" loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"></iframe>
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

            <a href="{{ route('feedback.create') }}" class="inline-flex items-center text-sm font-semibold text-emerald-300 hover:text-emerald-200">
               <button id="openFeedbackModal" type="button"
                class="inline-flex items-center text-sm font-semibold text-emerald-300 hover:text-emerald-200">
                  <i class="fas fa-comment-dots mr-2"></i>
                Leave your feedback
            </button>
            </a>
        </div>

        {{-- Testimonials Grid --}}
        <div class="grid md:grid-cols-3 gap-8">
            {{-- Card 1 --}}
            <div class="bg-gray-900 border border-gray-800 rounded-2xl p-6 shadow-md flex flex-col">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <p class="text-white font-semibold text-sm">kristel villame.</p>
                        <p class="text-gray-400 text-xs">Dental Chair and CCTVs Installation</p>
                    </div>
                    <div class="flex items-center text-yellow-400 text-xs">
                        <i class="fas fa-star mr-1"></i> 5.0
                    </div>
                </div>
                <p class="text-gray-300 text-sm leading-relaxed flex-grow">
                 "I had a great experience here, especially with Sir Pete, the owner. 
    He’s very reliable and did an excellent job fixing my tech gadgets. He also installs dental chairs, CCTVs, and repairs all kinds of electronic devices. Everything is now working perfectly! Highly recommended!"
                </p>
            </div>

            {{-- Card 2 --}}
            <div class="bg-gray-900 border border-gray-800 rounded-2xl p-6 shadow-md flex flex-col">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <p class="text-white font-semibold text-sm">Arnel Pajota.</p>
                        <p class="text-gray-400 text-xs">Device Repair</p>
                    </div>
                    <div class="flex items-center text-yellow-400 text-xs">
                        <i class="fas fa-star mr-1"></i> 4.0
                    </div>
                </div>
                <p class="text-gray-300 text-sm leading-relaxed flex-grow">
                    “Absolutely Outstanding Service!
I had a great experience at this shop! The staff were friendly, knowledgeable, and honest with their recommendations. They fixed my device quickly and even explained the problem clearly. Prices are fair, and the quality of work is top-notch. Highly recommended if you're looking for reliable electronics repair in Toril Davao City. 
I’ll definitely be coming back!”
                </p>
            </div>

            {{-- Card 3 --}}
            <div class="bg-gray-900 border border-gray-800 rounded-2xl p-6 shadow-md flex flex-col">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <p class="text-white font-semibold text-sm">XCL 88.</p>
                        <p class="text-gray-400 text-xs">Computers Repair</p>
                    </div>
                    <div class="flex items-center text-yellow-400 text-xs">
                        <i class="fas fa-star mr-1"></i> 5.0
                    </div>
                </div>
                <p class="text-gray-300 text-sm leading-relaxed flex-grow">
                    “Explains where the problem occurred. Provides options available for resolution.”
                </p>
            </div>
        </div>
    </div>
</section>

</div>
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
     // Feedback Modal
    const feedbackModal = document.getElementById("feedbackModal");
    const openFeedbackModal = document.getElementById("openFeedbackModal");
    const closeFeedbackModal = document.getElementById("closeFeedbackModal");
    const cancelFeedbackModal = document.getElementById("cancelFeedbackModal");

    const toggleModal = (open) => {
        feedbackModal.classList.toggle("hidden", !open);
        document.body.classList.toggle("overflow-hidden", open);
    };

    openFeedbackModal.addEventListener("click", () => toggleModal(true));
    closeFeedbackModal.addEventListener("click", () => toggleModal(false));
    cancelFeedbackModal.addEventListener("click", () => toggleModal(false));
    feedbackModal.addEventListener("click", (event) => {
        if (event.target === feedbackModal) toggleModal(false);
    });

    document.addEventListener("keydown", (event) => {
        if (event.key === "Escape" && !feedbackModal.classList.contains("hidden")) {
            toggleModal(false);
        }
    });
});
</script>