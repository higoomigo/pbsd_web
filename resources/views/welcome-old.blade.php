<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>@yield('title')</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

            @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <style>
            .dropdown[open] {
                display: block;
            }
        </style>

        <script>
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
        </script>

    </head>
    <body>
        <!-- Navbar -->
        @include('layouts.navbar')

        <div class="carousel w-full h-[650px]">
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
        </div>
        
        <!-- Main content -->
        <div class="container mx-auto px-20 sm:px-6 lg:px-40 mt-6">
            {{-- Profil --}}
            <div class="mb-15">
                <div class="px-6 py-1 bg-blue-200 border border-4 border-blue-200 w-full mb-6">
                    <p class="text-4xl font-bold text-start">Profil</p>
                </div>
                <div class="grid lg:grid-cols-3 md:grid-cols-1 sm:grid-cols-1 mt-6 gap-6 mb-6">
                    <div class="col-span-1 md:text-center sm:text-center">
                        <img class="" src="https://cdn.pixabay.com/photo/2018/03/10/12/00/paper-3213924_1280.jpg" alt="profile image">
                    </div>
                    <div class="col-span-2 bg-white px-6 pb-6">
                        <p class="mb-4">
                            <b>Pusat Studi Pelestarian Bahasa dan Sastra Daerah (PSPBSD)</b> Universitas Negeri Gorontalo hadir sebagai komitmen akademik dalam menjaga eksistensi bahasa dan sastra daerah, khususnya Bahasa Gorontalo. Pusat studi ini fokus pada kegiatan penelitian, dokumentasi, pengembangan, dan diseminasi pengetahuan bahasa serta sastra daerah sebagai upaya pelestarian warisan budaya yang tak ternilai.
                            <br>
                            Melalui kolaborasi lintas disiplin, PSPBSD menjadi wadah strategis yang menghubungkan akademisi, budayawan, dan masyarakat dalam memperkuat identitas lokal di tengah tantangan global.
                        </p>
                        <a href="#" class="text-blue-500 hover:underline">Baca Selengkapnya</a>
                    </div>
                </div>
            </div>
            
            {{-- Visi & Misi --}}
           
            <div class="mb-15">
                <div class="w-full flex justify-end">
                    <div class="px-6 py-1 border border-4 border-blue-200 bg-blue-200 w-full mb-4 ">
                        <p class="text-4xl font-bold text-end">Visi & Misi</p>
                    </div>
                </div>
                <p class="text-3xl font-bold mb-2">Visi</p>
                <p class="mb-6">
                    Menjadi pusat unggulan dalam pelestarian, pengembangan, dan pemanfaatan bahasa dan sastra daerah sebagai warisan budaya yang mendukung identitas lokal dan kemajuan ilmu pengetahuan.
                </p>
                <p class="text-3xl font-bold mb-2">Misi</p>
                <ul class="list-disc mb-6 ">
                    <li class="mb-2">
                        Mengembangkan dan melestarikan bahasa serta sastra daerah melalui penelitian, pengkajian, dan penerbitan karya ilmiah yang berkualitas.
                    </li>

                    <li class="mb-2">
                        Mendorong penggunaan bahasa dan sastra daerah dalam berbagai aspek kehidupan masyarakat, termasuk pendidikan, seni, dan media.
                    </li>
                    <li class="mb-2">
                        Melaksanakan penelitian dan pengkajian tentang bahasa dan sastra daerah di Gorontalo dan wilayah Nusantara untuk mendukung pelestarian dan pengembangan kebudayaan lokal.
                    </li>
                    <li class="mb-2">
                        Mendokumentasikan dan mengarsipkan bahasa serta karya sastra daerah melalui media cetak dan digital guna menjamin keberlanjutan pengetahuan lintas generasi.
                    </li>
                    <li class="mb-2">
                        Melakukan diseminasi dan edukasi publik melalui pelatihan, seminar, lokakarya, dan penerbitan yang mendorong pemanfaatan bahasa dan sastra daerah dalam kehidupan sehari-hari.
                    </li>
                    <li class="mb-2">
                        Bersinergi dengan lembaga pemerintah, adat, dan komunitas lokal dalam program pelestarian dan revitalisasi bahasa serta sastra daerah.
                    </li>
                    <li class="mb-2">
                        Mendukung kurikulum pendidikan lokal dengan menyediakan bahan ajar dan sumber literasi yang berbasis bahasa dan sastra daerah.
                    </li>
                </ul>
            </div>

            {{-- Berita --}}
            <div class="mb-15">
                <div class="px-6 py-2 border-blue-200 w-fit mb-4 hover:bg-blue-200 transition-colors duration-200 cursor-pointer">
                    <p class="text-4xl font-bold text-start">Berita Terbaru</p>
                </div>
                <p class="text-gray-500 text-center">Belum ada berita</p>
                {{-- <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div class="bg-white p-4">
                        <img src="https://images.pexels.com/photos/1391495/pexels-photo-1391498.jpeg?auto=compress&cs=tinysrgb&w=1920" alt="News Image 1" class="w-full h-48 object-cover rounded-t-lg">
                        <h3 class="mt-2 text-xl font-semibold">Judul Berita 1</h3>
                        <p class="mt-1">Deskripsi singkat berita 1.</p>
                    </div>
                    <div class="bg-white p-4">
                        <img src="https://images.pexels.com/photos/159866/books-book-pages-read-literature-159866.jpeg?auto=compress&cs=tinysrgb&w=1920" alt="News Image 2" class="w-full h-48 object-cover rounded-t-lg">
                        <h3 class="mt-2 text-xl font-semibold">Judul Berita 2</h3>
                        <p class="mt-1">Deskripsi singkat berita 2.</p>
                    </div>
                    <div class="bg-white p-4">
                        <img src="https://cdn.pixabay.com/photo/2018/03/10/12/00/paper-3213924_1280.jpg" alt="News Image 3" class="w-full h-48 object-cover rounded-t-lg">
                        <h3 class="mt-2 text-xl font-semibold">Judul Berita 3</h3>
                        <p class="mt-1">Deskripsi singkat berita 3.</p>
                    </div>
                </div> --}}
            </div>
            
            {{-- Gallery --}}
            <div class="mb-15">
                <div class="px-6 py-2 border border-4 border-blue-200 w-full mb-4">
                    <p class="text-4xl font-bold text-center">Galeri</p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div class="bg-white p-4 rounded-lg shadow">
                        <img src="https://images.pexels.com/photos/1391495/pexels-photo-1391498.jpeg?auto=compress&cs=tinysrgb&w=1920" alt="Gallery Image 1" class="w-full h-48 object-cover rounded-t-lg">
                        <p class="mt-2 text-center">Foto Kegiatan 1</p>
                    </div>
                    <div class="bg-white p-4 rounded-lg shadow">
                        <img src="https://images.pexels.com/photos/159866/books-book-pages-read-literature-159866.jpeg?auto=compress&cs=tinysrgb&w=1920" alt="Gallery Image 2" class="w-full h-48 object-cover rounded-t-lg">
                        <p class="mt-2 text-center">Foto Kegiatan 2</p>
                    </div>
                    <div class="bg-white p-4 rounded-lg shadow">
                        <img src="https://cdn.pixabay.com/photo/2018/03/10/12/00/paper-3213924_1280.jpg" alt="Gallery Image 3" class="w-full h-48 object-cover rounded-t-lg">
                        <p class="mt-2 text-center">Foto Kegiatan 3</p>
                    </div>
                </div>
            </div>
        </div>
        
        

        <script>
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
            
        </script>

    </body>
</html>
