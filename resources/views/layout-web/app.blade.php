<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light"> 
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>@yield('title')</title>

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

        <link
            rel="stylesheet"
            href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"
        />
        <link href="https://fonts.googleapis.com/css2?family=Arimo:ital,wght@0,400..700;1,400..700&family=Lora:ital,wght@0,400..700;1,400..700&display=swap" rel="stylesheet">

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <style>
            element {
                scrollbar-width: none; /* Hides the scrollbar */
            }
            .dropdown[open] {
                display: block;
            }

            .fade-in {
                animation: fadeIn 0.8s both;
                animation-timeline: view();
            }
            
            @keyframes fadeIn {
                from { opacity: 0; transform: translateY(0); }
                to { opacity: 1; transform: translateY(20px); }
            }

            /* Responsive adjustments */
            @media (max-width: 640px) {
                .hero-responsive {
                    padding-left: 1rem !important;
                    padding-right: 1rem !important;
                }
                .text-responsive {
                    font-size: 1.875rem !important; /* text-3xl */
                }
            }
        </style>
        
    </head>
    <body   x-data="{ loading: false }"
            x-on:beforeunload.window="loading = true"
            class="relative">
        
        <div x-show="loading"
            x-transition.opacity
            class="fixed inset-0 z-50 flex items-center justify-center bg-white/80 backdrop-blur">
            <div class="w-12 h-12 border-4 border-zinc-500 border-t-transparent rounded-full animate-spin"></div>
        </div>
        
        <div x-init="
                window.addEventListener('pageshow', () => loading = false);
                window.addEventListener('load', () => loading = false);
            ">

        <!-- Navbar -->
        @include('layouts.navbar')
        
        @hasSection('judul_halaman')
            <!-- Responsive header section -->
            <div class="pt-6 sm:py-2 lg:pt-12 mb-0 px-4 sm:px-6 lg:px-8 xl:px-36 w-full flex items-start">
                <div class="w-full">
                    <div class="border-b border-zinc-500 pb-4 sm:pb-6 md:pb-8">
                        <p class="text-2xl sm:text-3xl md:text-4xl font-title text-zinc-800 text-start sm:text-left px-2 sm:px-4 md:px-6 lg:px-10 md:pb-6">
                            @yield('judul_halaman')
                        </p>
                    </div>
                </div>
            </div>
        @endif

        @php
            // Halaman yang ingin full-width (tanpa pengaruh container & sidebar)
            $forceFullWidth = View::hasSection('fullwidth') || request()->routeIs('welcome') || request()->is('/');

            // Sidebar logic lama (tetap dipakai kalau tidak full-width)
            $isBerita  = request()->routeIs('guest.berita.*');
            $isWelcome = request()->routeIs('welcome') || request()->is('/');
            $sidebarItems = ($sidebarBerita ?? collect());
            $showAside = !$forceFullWidth && !$isBerita && !$isWelcome && $sidebarItems->isNotEmpty();

            // Responsive container classes
            $containerClass = 'mx-auto px-4 sm:px-6 lg:px-8';
            if ($showAside) {
                $containerClass .= ' max-w-7xl'; // Untuk layout dengan sidebar
            } else {
                $containerClass .= ' w-full'; // Untuk layout tanpa sidebar
            }
        @endphp

        @if($forceFullWidth)
            {{-- Full-width: tidak pakai container parent & tidak pakai sidebar --}}
            @yield('content')
        @else
            <div class="{{ $containerClass }}">
                @if($showAside)
                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-4 sm:gap-6 lg:gap-8">
                        <main class="lg:col-span-8">
                            @yield('content')
                        </main>
                        <aside class="lg:col-span-4 mt-2 lg:mt-0">
                            <x-sidebar-berita :items="$sidebarItems" />
                        </aside>
                    </div>
                @else
                    <div class="w-full  px-4 sm:px-6 lg:px-4">
                        @yield('content')
                    </div>
                @endif
            </div>
        @endif

        {{-- Footer --}}
        @include('layouts.footer')

        <script>
            // Saat mulai scroll, munculkan div hero-image
            const hero = document.getElementById('hero-image');
            let heroShown = false;

            window.addEventListener('scroll', () => {
                if (window.scrollY > 10 && !heroShown) {
                    hero.classList.remove('opacity-0', 'translate-y-8');
                    hero.classList.add('opacity-100', 'translate-y-0');
                    heroShown = true;
                }
            });

            // Responsive intersection observer
            const NAVBAR_OFFSET = 80; // Sesuaikan dengan tinggi navbar mobile/desktop

            const options = {
                root: null,
                threshold: 0.15,
                rootMargin: `-${NAVBAR_OFFSET}px 0px 0px 0px`,
            };

            const observer = new IntersectionObserver((entries) => {
                entries.forEach((entry) => {
                    if (!entry.isIntersecting) return;

                    // Trigger fade-in
                    entry.target.classList.remove('opacity-0', 'translate-y-8');
                    entry.target.classList.add('opacity-100', 'translate-y-0');

                    // Observe sekali saja
                    observer.unobserve(entry.target);
                });
            }, options);

            // Daftarkan semua elemen fade-in
            document.querySelectorAll('.fade-in').forEach((el) => {
                // Optimasi untuk performa mobile
                if ('willChange' in el.style) {
                    el.style.willChange = 'opacity, transform';
                }
                observer.observe(el);
            });

            // Hormati preferensi reduced motion
            const media = window.matchMedia('(prefers-reduced-motion: reduce)');
            if (media.matches) {
                document.querySelectorAll('.fade-in').forEach((el) => {
                    el.classList.remove('opacity-0', 'translate-y-8');
                    el.classList.add('opacity-100', 'translate-y-0');
                });
            }

            // Responsive window resize handler
            let resizeTimer;
            window.addEventListener('resize', () => {
                // Clear the timer on resize
                clearTimeout(resizeTimer);
                // Set a new timer
                resizeTimer = setTimeout(() => {
                    // Update NAVBAR_OFFSET berdasarkan ukuran layar
                    const newNavbarOffset = window.innerWidth < 1024 ? 60 : 80;
                    if (newNavbarOffset !== NAVBAR_OFFSET) {
                        // Update options for observer jika diperlukan
                        options.rootMargin = `-${newNavbarOffset}px 0px 0px 0px`;
                    }
                }, 250);
            });
        </script>

        <script>
            // Fungsi untuk toggle dropdown
            function toggleDropdown(id) {
                const dropdown = document.getElementById(id);
                const isOpen = !dropdown.classList.contains('hidden');

                // Tutup semua dropdown lain
                document.querySelectorAll('ul[id$="Dropdown"]').forEach(menu => {
                    menu.classList.add('hidden');
                });

                // Toggle dropdown yang diklik
                if (!isOpen) {
                    dropdown.classList.remove('hidden');
                }
            }

            // Tutup dropdown ketika klik di luar area menu
            window.addEventListener('click', function(e) {
                if (!e.target.closest('li.relative')) {
                    document.querySelectorAll('ul[id$="Dropdown"]').forEach(menu => {
                        menu.classList.add('hidden');
                    });
                }
            });

            function extractYouTubeId(url) {
                if (!url) return '';
                
                // Pattern untuk extract YouTube ID dari berbagai format URL
                const patterns = [
                    /(?:youtube\.com\/watch\?v=|youtu\.be\/|youtube\.com\/embed\/)([^&?#]+)/,
                    /youtube\.com\/watch\?.*v=([^&?#]+)/,
                    /youtu\.be\/([^&?#]+)/
                ];
                
                for (const pattern of patterns) {
                    const match = url.match(pattern);
                    if (match && match[1]) {
                        return match[1];
                    }
                }
                
                return '';
            }
        </script>

        <script>
            // Mobile detection and enhancement
            (function() {
                const isMobile = /iPhone|iPad|iPod|Android/i.test(navigator.userAgent);
                
                if (isMobile) {
                    // Optimasi untuk perangkat mobile
                    document.documentElement.classList.add('mobile-device');
                    
                    // Prevent zoom on input focus (optional)
                    const inputs = document.querySelectorAll('input, textarea, select');
                    inputs.forEach(input => {
                        input.addEventListener('focus', () => {
                            // Tambahkan class untuk mencegah zoom
                            document.body.classList.add('prevent-zoom');
                        });
                        input.addEventListener('blur', () => {
                            document.body.classList.remove('prevent-zoom');
                        });
                    });
                }

                // Touch device detection
                const isTouchDevice = 'ontouchstart' in window || navigator.maxTouchPoints > 0;
                if (isTouchDevice) {
                    document.documentElement.classList.add('touch-device');
                    
                    // Improve tap targets on mobile
                    const interactiveElements = document.querySelectorAll('a, button, [role="button"]');
                    interactiveElements.forEach(el => {
                        if (el.offsetHeight < 44 || el.offsetWidth < 44) {
                            el.classList.add('min-tap-target');
                        }
                    });
                }
            })();
        </script>

        <style>
            /* Additional responsive styles */
            @media (max-width: 768px) {
                .min-tap-target {
                    min-height: 44px !important;
                    min-width: 44px !important;
                    display: flex !important;
                    align-items: center !important;
                    justify-content: center !important;
                }
                
                .prevent-zoom {
                    font-size: 16px !important;
                }
                
                /* Improve readability on mobile */
                p, li, span:not(.icon) {
                    line-height: 1.6 !important;
                }
                
                /* Adjust spacing for mobile */
                .section-spacing {
                    padding-top: 2rem !important;
                    padding-bottom: 2rem !important;
                }
            }
            
            @media (max-width: 640px) {
                /* Reduce padding and margins on very small screens */
                .container-padding {
                    padding-left: 1rem !important;
                    padding-right: 1rem !important;
                }
                
                /* Stack elements vertically */
                .stack-mobile {
                    flex-direction: column !important;
                    gap: 1rem !important;
                }
                
                /* Full width on mobile */
                .full-width-mobile {
                    width: 100% !important;
                    max-width: 100% !important;
                }
            }
            
            @media (min-width: 641px) and (max-width: 1024px) {
                /* Tablet optimizations */
                .tablet-optimize {
                    padding-left: 2rem !important;
                    padding-right: 2rem !important;
                }
            }
            
            /* Print styles */
            @media print {
                .no-print {
                    display: none !important;
                }
                
                .print-only {
                    display: block !important;
                }
                
                body {
                    font-size: 12pt !important;
                    line-height: 1.5 !important;
                }
                
                a[href]::after {
                    content: " (" attr(href) ")";
                }
            }
        </style>
        
        </div>
    </body>
</html>