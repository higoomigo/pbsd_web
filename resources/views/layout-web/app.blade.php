<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light"> 
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
        <meta name="theme-color" content="#ffffff">

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
            /* Base responsive styles */
            * {
                -webkit-tap-highlight-color: transparent;
            }
            
            html {
                scroll-behavior: smooth;
                -webkit-font-smoothing: antialiased;
                -moz-osx-font-smoothing: grayscale;
            }
            
            body {
                overflow-x: hidden;
                text-rendering: optimizeLegibility;
            }

            /* Scrollbar styling */
            ::-webkit-scrollbar {
                width: 8px;
                height: 8px;
            }
            
            ::-webkit-scrollbar-track {
                background: #f1f1f1;
            }
            
            ::-webkit-scrollbar-thumb {
                background: #888;
                border-radius: 4px;
            }
            
            ::-webkit-scrollbar-thumb:hover {
                background: #555;
            }

            /* Animation classes */
            .fade-in {
                animation: fadeIn 0.8s both;
                animation-timeline: view();
            }
            
            @keyframes fadeIn {
                from { opacity: 0; transform: translateY(20px); }
                to { opacity: 1; transform: translateY(0); }
            }

            /* Responsive utilities */
            @media (max-width: 640px) {
                .hero-responsive {
                    padding-left: 1rem !important;
                    padding-right: 1rem !important;
                }
                
                .text-responsive {
                    font-size: 1.875rem !important;
                }
                
                .mobile-stack {
                    flex-direction: column !important;
                }
                
                .mobile-full-width {
                    width: 100% !important;
                    max-width: 100% !important;
                }
            }
            
            @media (max-width: 768px) {
                .tablet-padding {
                    padding-left: 1.5rem !important;
                    padding-right: 1.5rem !important;
                }
            }
            
            /* Touch device optimizations */
            @media (hover: none) and (pointer: coarse) {
                .touch-device *:focus {
                    outline: 2px solid #3b82f6 !important;
                    outline-offset: 2px;
                }
                
                .touch-device button,
                .touch-device a {
                    min-height: 44px;
                    min-width: 44px;
                }
            }
            
            /* Print styles */
            @media print {
                .no-print {
                    display: none !important;
                }
                
                body {
                    font-size: 12pt !important;
                    line-height: 1.5 !important;
                    color: #000 !important;
                    background: #fff !important;
                }
                
                a {
                    text-decoration: underline !important;
                    color: #000 !important;
                }
            }
        </style>
    </head>
    
    <body x-data="{ loading: false, isMobile: window.innerWidth < 768 }"
          x-init="
            window.addEventListener('beforeunload', () => loading = true);
            window.addEventListener('pageshow', () => loading = false);
            window.addEventListener('load', () => {
              loading = false;
              // Initialize after load
              setTimeout(() => {
                if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
                  document.querySelectorAll('.fade-in').forEach(el => {
                    el.style.animation = 'none';
                    el.classList.remove('opacity-0', 'translate-y-8');
                    el.classList.add('opacity-100', 'translate-y-0');
                  });
                }
              }, 100);
            });
            window.addEventListener('resize', () => {
              isMobile = window.innerWidth < 768;
            });
          "
          :class="{ 'touch-device': 'ontouchstart' in window || navigator.maxTouchPoints > 0 }"
          class="relative min-h-screen flex flex-col bg-white">
        
        <!-- Loading overlay -->
        <div x-show="loading"
             x-transition.opacity
             class="fixed inset-0 z-50 flex items-center justify-center bg-white/80 backdrop-blur-sm"
             style="display: none;">
            <div class="w-10 h-10 sm:w-12 sm:h-12 border-3 sm:border-4 border-zinc-500 border-t-transparent rounded-full animate-spin"></div>
        </div>
        
        <!-- Navbar -->
        @include('layouts.navbar')
        
        <!-- Main Content -->
        <main class="flex-grow">
            @hasSection('judul_halaman')
                <div class="pt-6 sm:pt-8 lg:pt-12 px-4 sm:px-6 lg:px-8 xl:px-8">
                    <div class="max-w-7xl mx-auto border-b border-zinc-300 pb-4 sm:pb-6 md:pb-8">
                        <h1 class="text-2xl sm:text-3xl md:text-4xl font-title text-zinc-800 text-center sm:text-left px-2 sm:px-4 md:px-0">
                            @yield('judul_halaman')
                        </h1>
                    </div>
                </div>
            @endif

            @php
                // Halaman yang ingin full-width
                $forceFullWidth = View::hasSection('fullwidth') || request()->routeIs('welcome') || request()->is('/');
                
                // Sidebar logic
                $isBerita  = request()->routeIs('guest.berita.*');
                $isWelcome = request()->routeIs('welcome') || request()->is('/');
                $sidebarItems = ($sidebarBerita ?? collect());
                $showAside = !$forceFullWidth && !$isBerita && !$isWelcome && $sidebarItems->isNotEmpty();
            @endphp

            @if($forceFullWidth)
                {{-- Full-width content --}}
                @yield('content')
            @else
                <div class="px-4 sm:px-6 lg:px-8 py-6 sm:py-8">
                    @if($showAside)
                        <div class="max-w-7xl mx-auto">
                            <div class="flex flex-col lg:flex-row gap-6 lg:gap-8">
                                {{-- Main content --}}
                                <div class="lg:w-8/12 lg:pr-6">
                                    @yield('content')
                                </div>
                                
                                {{-- Sidebar --}}
                                <div class="lg:w-4/12 hidden md:block">
                                    <div class="sticky top-24">
                                        <x-sidebar-berita :items="$sidebarItems" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="w-full mx-auto">
                            @yield('content')
                        </div>
                    @endif
                </div>
            @endif
        </main>

        {{-- Footer --}}
        @include('layouts.footer')

        <script>
            // Intersection Observer untuk animasi
            const createObserver = () => {
                const options = {
                    root: null,
                    threshold: 0.15,
                    rootMargin: '-80px 0px 0px 0px'
                };

                return new IntersectionObserver((entries) => {
                    entries.forEach((entry) => {
                        if (entry.isIntersecting) {
                            entry.target.classList.remove('opacity-0', 'translate-y-8');
                            entry.target.classList.add('opacity-100', 'translate-y-0');
                            observer.unobserve(entry.target);
                        }
                    });
                }, options);
            };

            // Initialize observer
            const observer = createObserver();
            
            // Observe elements setelah DOM siap
            document.addEventListener('DOMContentLoaded', () => {
                document.querySelectorAll('.fade-in').forEach((el) => {
                    // Skip jika prefers reduced motion
                    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
                        el.classList.remove('opacity-0', 'translate-y-8');
                        el.classList.add('opacity-100', 'translate-y-0');
                        return;
                    }
                    
                    // Optimasi performa
                    if ('willChange' in el.style) {
                        el.style.willChange = 'opacity, transform';
                    }
                    
                    observer.observe(el);
                });
            });

            // Responsive resize handler
            let resizeTimeout;
            window.addEventListener('resize', () => {
                clearTimeout(resizeTimeout);
                resizeTimeout = setTimeout(() => {
                    // Update observer jika diperlukan
                    // Misalnya update threshold untuk mobile
                    const isMobile = window.innerWidth < 768;
                    observer.disconnect();
                    
                    const newOptions = {
                        root: null,
                        threshold: isMobile ? 0.05 : 0.15,
                        rootMargin: isMobile ? '-60px 0px 0px 0px' : '-80px 0px 0px 0px'
                    };
                    
                    // Recreate observer dengan options baru
                    // Note: Untuk implementasi lengkap, perlu re-observe semua elemen
                }, 250);
            });

            // Touch device optimizations
            if ('ontouchstart' in window || navigator.maxTouchPoints > 0) {
                // Add touch-specific classes
                document.body.classList.add('touch-device');
                
                // Improve touch targets
                const touchElements = document.querySelectorAll('button, a, [role="button"]');
                touchElements.forEach(el => {
                    if (el.offsetHeight < 44 || el.offsetWidth < 44) {
                        el.classList.add('touch-target');
                    }
                });
            }

            // Mobile menu toggle (jika diperlukan)
            function toggleMobileMenu() {
                const menu = document.getElementById('mobile-menu');
                if (menu) {
                    menu.classList.toggle('hidden');
                }
            }

            // Close dropdowns when clicking outside
            document.addEventListener('click', (e) => {
                if (!e.target.closest('[data-dropdown]')) {
                    document.querySelectorAll('[data-dropdown-content]').forEach(dropdown => {
                        dropdown.classList.add('hidden');
                    });
                }
            });

            // YouTube ID extraction (jika diperlukan)
            window.extractYouTubeId = function(url) {
                if (!url) return '';
                
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
            };

            const hero = document.getElementById('hero-image');
            let heroShown = false;

            window.addEventListener('scroll', () => {
                if (window.scrollY > 10 && !heroShown) {
                    hero.classList.remove('opacity-0', 'translate-y-8');
                    hero.classList.add('opacity-100', 'translate-y-0');
                    heroShown = true;
                }
            });
        </script>

        <style>
            /* Additional responsive tweaks */
            @media (max-width: 1024px) {
                .sidebar-container {
                    margin-left: 0 !important;
                    padding-right: 0 !important;
                }
            }
            
            @media (max-width: 768px) {
                .mobile-no-sidebar {
                    display: none !important;
                }
                
                .mobile-content-full {
                    width: 100% !important;
                    padding-left: 0 !important;
                    padding-right: 0 !important;
                }
            }
            
            /* Improve image loading */
            img {
                content-visibility: auto;
            }
            
            /* Better focus styles for accessibility */
            :focus-visible {
                outline: 2px solid #3b82f6;
                outline-offset: 2px;
            }
            
            /* Print optimization */
            @media print {
                main {
                    padding: 0 !important;
                }
                
                .sidebar-container {
                    display: none !important;
                }
                
                .max-w-4xl, .max-w-7xl {
                    max-width: 100% !important;
                }
            }
        </style>
    </body>
</html>