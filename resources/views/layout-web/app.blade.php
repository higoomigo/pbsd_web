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
                <div class="h-24 px-36 w-full flex items-center">
                    <div class="container">
                        <div class="border-b border-zinc-500 pl-10 py-10">
                            <p class="text-4xl font-title text-zinc-800">@yield('judul_halaman')</p>
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

        $containerClass = $showAside
            ? 'container mx-auto px-4 sm:px-6 lg:px-36'
            : 'container mx-auto px-4 sm:px-6';
        @endphp

        @if($forceFullWidth)
        {{-- Full-width: tidak pakai container parent & tidak pakai sidebar --}}
        @yield('content')
        @else
            <div class="{{ $containerClass }}">
                @if($showAside)
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
                    <main class="lg:col-span-8">
                    @yield('content')
                    </main>
                    <aside class="lg:col-span-4">
                    <x-sidebar-berita :items="$sidebarItems" />
                    </aside>
                </div>
                @else
                <div class="w-full">
                    @yield('content')
                </div>
                @endif
            </div>
        @endif
            {{-- Kalau beberapa halaman butuh 
                full width tanpa aside, 
                kamu juga bisa tambahkan 
                di halaman itu: --}}  {{-- @section('no_aside', true) --}}
           

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


            const options = {
                root: null,
                threshold: 0.15,                // muncul saat ~15% elemen terlihat
                rootMargin: `-${NAVBAR_OFFSET}px 0px 0px 0px`, // kompensasi navbar fixed
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
                // (opsional) performa lebih halus
                el.style.willChange = 'opacity, transform';
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
        </script>


        
        </div>
    </body>
</html>
