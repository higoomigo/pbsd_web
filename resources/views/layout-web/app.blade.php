<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light"> 
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>@yield('title')</title>

        <!-- Fonts -->
        {{-- <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@100..900&display=swap" rel="stylesheet"> --}}
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Arimo:ital,wght@0,400..700;1,400..700&family=Lora:ital,wght@0,400..700;1,400..700&display=swap" rel="stylesheet">

        

        <style>
        // <weight>: Use a value from 400 to 900
        // <uniquifier>: Use a unique and descriptive class name
        /* .font-playfair {
            font-family: "Playfair Display", serif;
            font-optical-sizing: auto;
            font-weight: 700;
            /* font-style: normal; */
        
        </style>


            @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <style>
            .dropdown[open] {
                display: block;
            }

            .fade-in {
                animation: fadeIn 0.8s both;
                /* animation-timeline: view(); */
            }
            
            @keyframes fadeIn {
                from { opacity: 0; transform: translateY(0); }
                to { opacity: 1; transform: translateY(20px); }
            }
        </style>

        {{-- <script>
            document.addEventListener('DOMContentLoaded', () => {
                // Oh look, your precious carousel. Let's make it actually move.
                const carousel = document.querySelector('.carousel');
                const items = document.querySelectorAll('.carousel-item');
                let currentIndex = 0;
                let autoPlayInterval = null;

                // Function to scroll to a specific slide, because DaisyUI won't do it for you
                const goToSlide = (index) => {
                    if (index < 0) index = items.length - 1;
                    if (index >= items.length) index = 0;
                    const offset = index * carousel.clientWidth;
                    carousel.scrollTo({ left: offset, behavior: 'smooth' });
                    currentIndex = index;
                    // Update URL hash to match DaisyUI's href links, because consistency is *so* important
                    
                };

                // Handle those fancy arrow clicks you thought would work out of the box
                document.querySelectorAll('.carousel a.btn-circle').forEach(button => {
                    button.addEventListener('click', (e) => {
                        e.preventDefault(); // Stop the browser from jumping around like it owns the place
                        const href = button.getAttribute('href').substring(1); // Get the slide ID
                        const targetIndex = Array.from(items).findIndex(item => item.id === href);
                        if (targetIndex !== -1) {
                            goToSlide(targetIndex);
                            // Reset auto-play because you touched it, you impatient user
                            if (autoPlayInterval) {
                                clearInterval(autoPlayInterval);
                                startAutoPlay();
                            }
                        }
                    });
                });

                // Auto-play, because manually clicking arrows is *so* 2005
                const startAutoPlay = () => {
                    autoPlayInterval = setInterval(() => {
                        goToSlide(currentIndex + 1);
                    }, 5000); // Change slide every 5 seconds, or tweak it if you're feeling extra
                };

                // Stop auto-play when the user hovers, because they’re probably judging your images
                carousel.addEventListener('mouseenter', () => {
                    if (autoPlayInterval) clearInterval(autoPlayInterval);
                });

                // Resume auto-play when they leave, because we can’t let them get too comfortable
                carousel.addEventListener('mouseleave', () => {
                    startAutoPlay();
                });

                // Start the auto-play party, because why make the user do all the work?
                startAutoPlay();

                // Handle initial hash if someone’s trying to be fancy with URLs
                const initialHash = window.location.hash.substring(1);
                if (initialHash) {
                    const initialIndex = Array.from(items).findIndex(item => item.id === initialHash);
                    if (initialIndex !== -1) goToSlide(initialIndex);
                }
            });
        </script> --}}

    </head>
    <body>
        <!-- Navbar -->
        @include('layouts.navbar')

        {{-- <div class="carousel w-full h-[650px]">
            <div id="slide1" class="carousel-item relative w-full">
                <img src="https://images.pexels.com/photos/1391495/pexels-photo-1391498.jpeg?auto=compress&cs=tinysrgb&w=1920" class="w-full object-cover object-top" />
                <div class="absolute left-5 right-5 top-1/2 flex -translate-y-1/2 transform justify-between">
                    <a href="#slide4" class="btn btn-circle">❮</a>
                    <a href="#slide2" class="btn btn-circle">❯</a>
                </div>
            </div>
            <div id="slide2" class="carousel-item relative w-full">
                <img src="https://images.pexels.com/photos/159866/books-book-pages-read-literature-159866.jpeg?auto=compress&cs=tinysrgb&w=1920" class="w-full object-cover object-top" />
                <div class="absolute left-5 right-5 top-1/2 flex -translate-y-1/2 transform justify-between">
                    <a href="#slide1" class="btn btn-circle">❮</a>
                    <a href="#slide3" class="btn btn-circle">❯</a>
                </div>
            </div>
            <div id="slide3" class="carousel-item relative w-full">
                <img src="https://cdn.pixabay.com/photo/2018/03/10/12/00/paper-3213924_1280.jpg" class="w-full object-cover object-top" />
                <div class="absolute left-5 right-5 top-1/2 flex -translate-y-1/2 transform justify-between">
                    <a href="#slide2" class="btn btn-circle">❮</a>
                    <a href="#slide4" class="btn btn-circle">❯</a>
                </div>
            </div>
            <div id="slide4" class="carousel-item relative w-full">
                <img src="https://images.unsplash.com/photo-1528184039930-bd03972f2bc6?auto=format&fit=crop&w=1920&q=80" class="w-full object-cover object-top" />
                <div class="absolute left-5 right-5 top-1/2 flex -translate-y-1/2 transform justify-between">
                    <a href="#slide3" class="btn btn-circle">❮</a>
                    <a href="#slide1" class="btn btn-circle">❯</a>
                </div>
            </div>
        </div> --}}
        
            
            <div class="container mx-auto  sm:px-6 lg:px-36 mt-6">
                @yield('content')
            </div>
        {{-- <script>
            // JavaScript to handle dropdown hover behavior
            document.addEventListener('DOMContentLoaded', () => {
                const detailsElements = document.querySelectorAll('.navbar-center details.dropdown');
                detailsElements.forEach(details => {
                    let timeoutId;
                    details.addEventListener('mouseenter', () => {
                        clearTimeout(timeoutId); // Clear any pending close
                        details.setAttribute('open', '');
                    });
                    details.addEventListener('mouseleave', () => {
                        timeoutId = setTimeout(() => {
                            details.removeAttribute('open');
                        }, 10); // 200ms delay to allow moving to submenu
                    });
                    // Keep dropdown open when hovering over submenu
                    const submenu = details.querySelector('ul');
                    submenu.addEventListener('mouseenter', () => {
                        clearTimeout(timeoutId); // Prevent closing while in submenu
                    });
                    submenu.addEventListener('mouseleave', () => {
                        timeoutId = setTimeout(() => {
                            details.removeAttribute('open');
                        }, 200);
                    });
                });
            });

            // Carousel slide
            
        </script> --}}

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


        

    </body>
</html>
