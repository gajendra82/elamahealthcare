import './bootstrap';

import Alpine from 'alpinejs';
import AOS from 'aos';
import Swiper from 'swiper';
import { Navigation, Pagination, Autoplay, EffectFade } from 'swiper/modules';
import { CountUp } from 'countup.js';
import Typed from 'typed.js';
import lightGallery from 'lightgallery';
import lgThumbnail from 'lightgallery/plugins/thumbnail';
import lgZoom from 'lightgallery/plugins/zoom';
import { createIcons, icons } from 'lucide';

window.Alpine = Alpine;

Alpine.data('mobileMenu', () => ({
    open: false,
    activeDropdown: null,
    toggle() {
        this.open = !this.open;
        if (!this.open) this.activeDropdown = null;
    },
    toggleDropdown(name) {
        this.activeDropdown = this.activeDropdown === name ? null : name;
    },
    close() {
        this.open = false;
        this.activeDropdown = null;
    },
}));

Alpine.data('headerScroll', () => ({
    scrolled: false,
    init() {
        this.scrolled = window.scrollY > 50;
        window.addEventListener('scroll', () => {
            this.scrolled = window.scrollY > 50;
        });
    },
}));

Alpine.data('worldMap', () => ({
    activeCountry: null,
    countries: {
        MM: 'Myanmar',
        KH: 'Cambodia',
        VN: 'Vietnam',
        PH: 'Philippines',
        NP: 'Nepal',
        KE: 'Kenya',
        AF: 'Afghanistan',
        SD: 'Sudan',
        AO: 'Angola',
        MZ: 'Mozambique',
        CM: 'Cameroon',
        CI: 'Ivory Coast',
        GN: 'Guinea',
        CG: 'Congo',
    },
    select(code) {
        this.activeCountry = this.activeCountry === code ? null : code;
    },
    getCountryName(code) {
        return this.countries[code] || code;
    },
}));

Alpine.data('flashToast', () => ({
    show: false,
    message: '',
    type: 'success',
    init() {
        const el = this.$el;
        if (el.dataset.message) {
            this.message = el.dataset.message;
            this.type = el.dataset.type || 'success';
            this.show = true;
            setTimeout(() => { this.show = false; }, 5000);
        }
    },
}));

Alpine.data('productFilter', () => ({
    search: '',
    category: 'all',
    letter: 'all',
    categories: ['Tablets', 'Capsules', 'Injectables', 'Oncology', 'Ophthalmic', 'Liquids'],
    letters: 'ABCDEFGHIJKLMNOPQRSTUVWXYZ'.split(''),
    products: [],
    init() {
        const data = this.$el.dataset.products;
        if (data) {
            try {
                this.products = JSON.parse(data);
            } catch (e) {
                this.products = [];
            }
        }
    },
    get filtered() {
        return this.products.filter(p => {
            const matchSearch = !this.search ||
                p.name.toLowerCase().includes(this.search.toLowerCase()) ||
                p.category.toLowerCase().includes(this.search.toLowerCase());
            const matchCategory = this.category === 'all' || p.category === this.category;
            const matchLetter = this.letter === 'all' || p.name.charAt(0).toUpperCase() === this.letter;
            return matchSearch && matchCategory && matchLetter;
        });
    },
}));

document.addEventListener('DOMContentLoaded', () => {
    AOS.init({
        duration: 800,
        easing: 'ease-out-cubic',
        once: true,
        offset: 60,
    });

    createIcons({ icons });

    const heroSwiperEl = document.querySelector('.hero-swiper');
    if (heroSwiperEl) {
        new Swiper('.hero-swiper', {
            modules: [Navigation, Pagination, Autoplay, EffectFade],
            effect: 'fade',
            fadeEffect: { crossFade: true },
            loop: true,
            autoplay: { delay: 6000, disableOnInteraction: false },
            pagination: { el: '.hero-swiper .swiper-pagination', clickable: true },
            navigation: {
                nextEl: '.hero-swiper .swiper-button-next',
                prevEl: '.hero-swiper .swiper-button-prev',
            },
        });
    }

    const testimonialSwiperEl = document.querySelector('.testimonial-swiper');
    if (testimonialSwiperEl) {
        new Swiper('.testimonial-swiper', {
            modules: [Navigation, Pagination, Autoplay],
            slidesPerView: 1,
            spaceBetween: 24,
            loop: true,
            autoplay: { delay: 5000 },
            pagination: { el: '.testimonial-swiper .swiper-pagination', clickable: true },
            navigation: {
                nextEl: '.testimonial-swiper .swiper-button-next',
                prevEl: '.testimonial-swiper .swiper-button-prev',
            },
            breakpoints: {
                768: { slidesPerView: 2 },
                1024: { slidesPerView: 3 },
            },
        });
    }

    const typedEl = document.getElementById('typed-headline');
    if (typedEl) {
        new Typed('#typed-headline', {
            strings: [
                'Quality Pharmaceuticals',
                'Global Healthcare Solutions',
                'Affordable Medicines Worldwide',
                'Innovation Since 1986',
            ],
            typeSpeed: 50,
            backSpeed: 30,
            backDelay: 2000,
            loop: true,
        });
    }

    const counterObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting && !entry.target.dataset.counted) {
                const el = entry.target;
                const target = parseFloat(el.dataset.count || '0');
                const suffix = el.dataset.suffix || '';
                const prefix = el.dataset.prefix || '';
                const decimal = el.dataset.decimal ? parseInt(el.dataset.decimal) : 0;

                const countUp = new CountUp(el, target, {
                    duration: 2.5,
                    suffix,
                    prefix,
                    decimalPlaces: decimal,
                    separator: ',',
                });

                if (!countUp.error) {
                    countUp.start();
                    el.dataset.counted = 'true';
                }
            }
        });
    }, { threshold: 0.5 });

    document.querySelectorAll('[data-count]').forEach(el => counterObserver.observe(el));

    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', (e) => {
            const href = anchor.getAttribute('href');
            if (href === '#') return;
            const target = document.querySelector(href);
            if (target) {
                e.preventDefault();
                target.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        });
    });

    const galleryEl = document.getElementById('csr-gallery');
    if (galleryEl) {
        lightGallery(galleryEl, {
            plugins: [lgThumbnail, lgZoom],
            speed: 400,
            download: false,
            selector: '.gallery-item',
        });
    }
});

Alpine.start();
