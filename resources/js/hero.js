// resources/js/customer/hero.js

// Simple animation on scroll
document.addEventListener("DOMContentLoaded", function () {
    const fadeElements = document.querySelectorAll(".fade-in");

    const fadeInOnScroll = function () {
        fadeElements.forEach((element) => {
            const elementTop = element.getBoundingClientRect().top;
            const elementVisible = 150;

            if (elementTop < window.innerHeight - elementVisible) {
                element.classList.add("fade-in");
            }
        });
    };

    // Initial check
    fadeInOnScroll();

    // Check on scroll
    window.addEventListener("scroll", fadeInOnScroll);
});

// Smooth scrolling for anchor links
document.addEventListener("DOMContentLoaded", function () {
    const anchorLinks = document.querySelectorAll('a[href^="#"]');

    anchorLinks.forEach((link) => {
        link.addEventListener("click", function (e) {
            e.preventDefault();

            const targetId = this.getAttribute("href");
            if (targetId === "#") return;

            const targetElement = document.querySelector(targetId);
            if (targetElement) {
                targetElement.scrollIntoView({
                    behavior: "smooth",
                    block: "start",
                });
            }
        });
    });
});
