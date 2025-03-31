document.addEventListener('DOMContentLoaded', function() {
    let currentIndex = 0;
    const totalItems = document.querySelectorAll('.carousel-item').length;
    const dots = document.querySelectorAll('.carousel-dot');
    const items = document.querySelectorAll('.carousel-item');
    let carouselInterval;

    function updateDots() {
        dots.forEach((dot, index) => {
            if (index === currentIndex) {
                dot.classList.add('active');
            } else {
                dot.classList.remove('active');
            }
        });
    }

    function updateItems() {
        items.forEach((item, index) => {
            if (index === currentIndex) {
                item.classList.add('active');
            } else {
                item.classList.remove('active');
            }
        });
    }

    function moveSlide(direction) {
        currentIndex += direction;

        if (currentIndex < 0) {
            currentIndex = totalItems - 1;
        } else if (currentIndex >= totalItems) {
            currentIndex = 0;
        }

        updateCarousel();
    }

    function goToSlide(index) {
        currentIndex = index;
        updateCarousel();
    }

    function updateCarousel() {
        const carouselInner = document.querySelector('.carousel-inner');
        const offset = -currentIndex * 100;
        carouselInner.style.transform = `translateX(${offset}%)`;
        updateDots();
        updateItems();
    }

    function startCarousel() {
        carouselInterval = setInterval(() => {
            moveSlide(1);
        }, 5000);
    }

    const carouselWrapper = document.querySelector('.carousel-wrapper');
    if (carouselWrapper) {
        carouselWrapper.addEventListener('mouseenter', () => {
            clearInterval(carouselInterval);
        });

        carouselWrapper.addEventListener('mouseleave', () => {
            startCarousel();
        });
    }

    // Iniciar el carrusel
    startCarousel();

    // Hacer las funciones disponibles globalmente para los botones HTML
    window.moveSlide = moveSlide;
    window.goToSlide = goToSlide;
});