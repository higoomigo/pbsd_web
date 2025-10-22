@extends('layout-web.app')
@section('title', 'Pusat Studi Pelestarian Bahasa Dan Sastra Daerah')
@section('content')


<div class="w-full">
    {{-- sm:text-6xl text-5xl --}}
    <div class="font-title  pb-20 md:pb-48 pt-30 md:pt-48 lg:px-40 px-4 md:px-20 md:text-center text-start">
        <p class="text-cyan-950  text-3xl sm:text-6xl text-center md:text-start md:mb-2"> Pusat Studi </p>
        <p class="text-slate-900 font-normal text-4xl text-center md:text-start sm:text-5xl md:text-7xl"> Pelestarian Bahasa dan Sastra Daerah </p> 
    </div>
</div>
<div class=" w-full h-[500px]  mb-6 opacity-0 translate-y-8 transition-all duration-700 ease-out mt-20" id="hero-image">
    <img class="w-full h-full object-cover" src="https://www.researchgate.net/publication/371827625/figure/fig3/AS:11431281179849279@1691415873069/The-Harbour-Office-area-in-Gorontalo-circa-1926-Source-Digital-Collection-Leiden.png" alt="">
</div>

<!-- Main content -->
<div class="container mx-auto  sm:px-6 lg:px-36 mt-6">
    {{-- Profil --}}
    <div class="mb-20">
        <div class="grid lg:grid-cols-3 md:grid-cols-1 sm:grid-cols-1 gap-6 mb-6 pt-24 md:pt-40 md:pb-12 ">
            <div class="col-span-1 px-6 pb-1 w-full md:mb-6">
                <p class="lg:text-[50px] text-5xl font-title md:pl-5 text-start text-zinc-700">Profil</p>
            </div>
            <div class="col-span-2 px-6 pb-6">
                <p class="mb-10 text-zinc-700 font-body text-lg leading-6 md:pl-20">
                    <span class="text-xl"><b>Pusat Studi Pelestarian Bahasa dan Sastra Daerah</b> Universitas Negeri Gorontalo hadir sebagai komitmen akademik dalam menjaga eksistensi bahasa dan sastra daerah, khususnya Bahasa Gorontalo.</span>
                    <br class="md:mb-10 mb-5">
                    Pusat studi ini fokus pada kegiatan penelitian, dokumentasi, pengembangan, dan diseminasi pengetahuan bahasa serta sastra daerah sebagai upaya pelestarian warisan budaya yang tak ternilai.
                    <br class="md:mb-10 mb-5">
                    Melalui kolaborasi lintas disiplin, PSPBSD menjadi wadah strategis yang menghubungkan akademisi, budayawan, dan masyarakat dalam memperkuat identitas lokal di tengah tantangan global.
                </p>
                <div class=" w-full text-end mt-8 ">
                    <a href="#" class="btn hover:bg-white border-2 bg-black text-white text-md hover:text-zinc-900 relative leading-4
                  bg-gradient-to-r from-current to-current bg-[length:0%_2px] bg-left-bottom bg-no-repeat
                  transition-[background-size] duration-500 ease-in-out
                  group-hover:bg-[length:100%_1px] ">Baca Selengkapnya</a>
                </div>
            </div>
        </div>
    </div>

    <div class="mb-12">
        {{-- <div class="grid lg:grid-cols-3 md:grid-cols-1 sm:grid-cols-1 gap-6 mb-6 pt-24 md:pt-20 md:pb-12 ">
            <div class="col-span-1 px-6 pb-1 w-full md:mb-6">
                <p class="lg:text-[50px] text-5xl font-title md:pl-5 text-center text-zinc-700">Fokus Penelitian</p>
            </div>
        </div> --}}
        <p class="lg:text-[50px] text-5xl font-title md:pl-12 text-start text-zinc-700">Fokus Penelitian</p>
        <div class="grid lg:grid-cols-3 md:grid-cols-1 sm:grid-cols-1 gap-6 mb-6 pt-24 md:pt-20 md:pb-12">
            <div class="col-span-1 px-6 pb-1 w-full md:mb-6">
            </div>
        </div>
    </div>

    {{-- ----------- Berita --------- --}}
    <div class="mb-16 px-6">
        {{-- <a href="{{ route('berita') }}"></a> --}}
        <div class=" pb-1 w-full">
            <p class=" text-5xl font-title md:pl-5 text-start text-zinc-700 ">Berita Terbaru</p>
        </div>

        {{-- CARD BERITA BOS --}}
        <div class="container mx-auto">
            <div class="grid md:grid-cols-3 gap-14 ">
                <div class="col-span-1 group w-96 duration-300 ease-in-out card-compact mx-auto md:mx-0 mt-7
                            outline outline-0 hover:outline-2 hover:outline-zinc-800 hover:outline-offset-4 p-4">
                    <figure>
                        <a href="{{ route('berita') }}">
                        <img
                        class="h-cover ease-in-out"
                        src="https://img.daisyui.com/images/stock/photo-1606107557195-0e29a4b5b4aa.webp"
                        alt="Shoes" />
                        </a>
                    </figure>
                    <div class="mt-4">
                        <div class="w-fit mb-1">
                            <a href="{{ route('berita') }}" 
                                class=" text-xl text-zinc-800 font-title relative leading-4
                  bg-gradient-to-r from-current to-current bg-[length:0%_2px] bg-left-bottom bg-no-repeat
                  transition-[background-size] duration-500 ease-in-out
                  group-hover:bg-[length:100%_1px] hover:text-cyan-700">
                                Makan Spatu Nike memang enak dan sangat bermandfaat
                            </a>
                        </div>
                        <p class="text-zinc-500 text-sm">A card component has a figure, a body part, and inside body there are title and actions parts</p>
                    </div>
                </div>

                <div class="col-span-1 group w-96 duration-300 ease-in-out card-compact mx-auto md:mx-0 mt-7
                            outline outline-0 hover:outline-2 hover:outline-zinc-800 hover:outline-offset-4 p-4">
                    <figure>
                        <a href="{{ route('berita') }}">
                        <img
                        class="h-cover ease-in-out"
                        src="https://img.daisyui.com/images/stock/photo-1606107557195-0e29a4b5b4aa.webp"
                        alt="Shoes" />
                        </a>
                    </figure>
                    <div class="mt-4">
                        <div class="w-fit mb-1">
                            <a href="{{ route('berita') }}" 
                                class=" text-xl text-zinc-800 font-title relative leading-4
                  bg-gradient-to-r from-current to-current bg-[length:0%_2px] bg-left-bottom bg-no-repeat
                  transition-[background-size] duration-500 ease-in-out
                  group-hover:bg-[length:100%_1px] hover:text-cyan-700">
                                Makan Spatu Nike memang enak dan sangat bermandfaat
                            </a>
                        </div>
                        <p class="text-zinc-500 text-sm">A card component has a figure, a body part, and inside body there are title and actions parts</p>
                    </div>
                </div>

                <div class="col-span-1 group w-96 duration-300 ease-in-out card-compact mx-auto md:mx-0 mt-7
                            outline outline-0 hover:outline-2 hover:outline-zinc-800 hover:outline-offset-4 p-4">
                    <figure>
                        <a href="{{ route('berita') }}">
                        <img
                        class="h-cover ease-in-out"
                        src="https://img.daisyui.com/images/stock/photo-1606107557195-0e29a4b5b4aa.webp"
                        alt="Shoes" />
                        </a>
                    </figure>
                    <div class="mt-4">
                        <div class="w-fit mb-1">
                            <a href="{{ route('berita') }}" 
                                class=" text-xl text-zinc-800 font-title relative leading-4
                  bg-gradient-to-r from-current to-current bg-[length:0%_2px] bg-left-bottom bg-no-repeat
                  transition-[background-size] duration-500 ease-in-out
                  group-hover:bg-[length:100%_1px] hover:text-cyan-700">
                                Makan Spatu Nike memang enak dan sangat bermandfaat
                            </a>
                        </div>
                        <p class="text-zinc-500 text-sm">A card component has a figure, a body part, and inside body there are title and actions parts</p>
                    </div>
                </div>
            </div>
            <div class=" w-full text-end mt-8 ">
                <a href="{{ route('berita') }}" class="btn hover:bg-white border-2 bg-black text-white text-md hover:text-zinc-900 relative leading-4
                bg-gradient-to-r from-current to-current bg-[length:0%_2px] bg-left-bottom bg-no-repeat
                transition-[background-size] duration-500 ease-in-out
                group-hover:bg-[length:100%_1px] ">Lihat Semua Berita</a>
            </div>
        </div>

        
    </div>

</div>
{{-- ----------- Gallery --------- --}}
<div class="mb-12 sm:px-6 lg:px-36 mt-6 bg-zinc-900">
    <div class="grid lg:grid-cols-3 md:grid-cols-1 sm:grid-cols-1 gap-6 mb-6 pt-24 md:pt-20 md:pb-12 ">
        <div class="col-span-1 px-6 pb-1 w-full md:mb-6">
            <p class="lg:text-[50px] text-5xl font-title md:pl-5 text-start text-zinc-400">Arsip <br> & Galeri</p>
        </div>
    </div>
    {{-- <p class="lg:text-[50px] text-5xl font-title md:pl-12 text-start text-zinc-700">Arsip dan Galeri</p>
    <div class="grid lg:grid-cols-3 md:grid-cols-1 sm:grid-cols-1 gap-6 mb-6 pt-24 md:pt-20 md:pb-12">
        <div class="col-span-1 px-6 pb-1 w-full md:mb-6">
        </div>
    </div> --}}
</div>

{{-- Kontak Kami --}}
<div class="container mx-auto sm:px-6 lg:px-36 mt-6 mb-20">
    <div class=" gap-10 items-start">
        {{-- Form --}}
        <div class="bg-white p-8 rounded-lg shadow-sm outline outline-0 hover:outline-2 hover:outline-zinc-100 transition-all">
            <p class="text-5xl font-title text-zinc-800 mb-4">Kontak Kami</p>
            <p class="text-zinc-500 mb-6">Isi form untuk kolaborasi.</p>

            <form action="" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label for="name" class="block text-sm text-zinc-700 mb-1">Nama</label>
                    <input id="name" name="name" type="text" required
                        class="w-full px-4 py-3 border border-zinc-200 rounded-md focus:outline-none focus:ring-2 focus:ring-cyan-200"
                        placeholder="Nama lengkap" />
                </div>

                <div>
                    <label for="email" class="block text-sm text-zinc-700 mb-1">Email</label>
                    <input id="email" name="email" type="email" required
                        class="w-full px-4 py-3 border border-zinc-200 rounded-md focus:outline-none focus:ring-2 focus:ring-cyan-200"
                        placeholder="email@domain.com" />
                </div>

                <div>
                    <label for="subject" class="block text-sm text-zinc-700 mb-1">Subjek</label>
                    <input id="subject" name="subject" type="text"
                        class="w-full px-4 py-3 border border-zinc-200 rounded-md focus:outline-none focus:ring-2 focus:ring-cyan-200"
                        placeholder="Nama kegiatan / topik singkat" />
                </div>

                <div>
                    <label for="message" class="block text-sm text-zinc-700 mb-1">Pesan</label>
                    <textarea id="message" name="message" rows="5" required
                        class="w-full px-4 py-3 border border-zinc-200 rounded-md focus:outline-none focus:ring-2 focus:ring-cyan-200"
                        placeholder="Tulis pesan Anda di sini..."></textarea>
                </div>

                <div class="text-right">
                    <button type="submit"
                        class="btn inline-flex items-center justify-center px-6 py-3 bg-black text-white border-2 border-black rounded-md hover:bg-white hover:text-zinc-900 transition-colors duration-300">
                        Kirim Pesan
                    </button>
                </div>
            </form>
        </div>

        {{-- Kontak, Alamat & Sosial --}}
        {{-- <div class="bg-zinc-50 p-8 rounded-lg">
            <p class="text-2xl font-title text-zinc-800 mb-4">Informasi</p>

            <div class="text-zinc-700 mb-6 space-y-3">
                <div>
                    <p class="font-semibold">Alamat</p>
                    <p class="text-sm">Universitas Negeri Gorontalo, Gorontalo, Indonesia</p>
                </div>
                <div>
                    <p class="font-semibold">Email</p>
                    <a href="mailto:info@example.com" class="text-sm text-cyan-800 hover:underline">info@unigo.ac.id</a>
                </div>
                <div>
                    <p class="font-semibold">Telepon</p>
                    <a href="tel:+628123456789" class="text-sm text-cyan-800 hover:underline">+62 812 3456 789</a>
                </div>
            </div>

            <div class="border-t border-zinc-200 pt-6">
                <p class="text-sm text-zinc-600 mb-3">Ikuti kami</p>
                <div class="flex items-center gap-4">
                    <a href="#" aria-label="Facebook" class="text-zinc-700 hover:text-cyan-700 transition-colors">
                        <svg class="w-6 h-6" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                            <path d="M22 12.07C22 6.48 17.52 2 11.93 2S2 6.48 2 12.07c0 4.99 3.66 9.12 8.44 9.96v-7.05H8.08v-2.91h2.36V9.14c0-2.33 1.38-3.61 3.5-3.61.99 0 2.02.18 2.02.18v2.22h-1.14c-1.12 0-1.47.7-1.47 1.42v1.69h2.5l-.4 2.91h-2.1v7.05C18.34 21.19 22 17.06 22 12.07z"/>
                        </svg>
                    </a>

                    <a href="#" aria-label="Instagram" class="text-zinc-700 hover:text-cyan-700 transition-colors">
                        <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <rect x="3" y="3" width="18" height="18" rx="5"></rect>
                            <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path>
                            <line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line>
                        </svg>
                    </a>

                    <a href="#" aria-label="Twitter" class="text-zinc-700 hover:text-cyan-700 transition-colors">
                        <svg class="w-6 h-6" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                            <path d="M22 5.92c-.64.29-1.32.49-2.04.58.73-.44 1.29-1.14 1.55-1.97-.68.4-1.44.69-2.25.85C18.95 4.6 18 4 17 4c-1.66 0-3 1.34-3 3 0 .24.03.47.08.69C10.69 7.53 7.13 5.5 4.98 2.61c-.26.44-.41.95-.41 1.5 0 1.03.52 1.94 1.31 2.47-.48-.02-.93-.15-1.33-.36v.04c0 1.45 1.03 2.66 2.4 2.93-.25.07-.51.1-.78.1-.19 0-.38-.02-.56-.06.38 1.18 1.48 2.04 2.79 2.06C6.1 16.4 4.57 16.97 2.94 16.97c-.19 0-.37-.01-.55-.03C2.94 18.8 4.71 20 6.8 20c7.69 0 11.9-6.37 11.9-11.9v-.54c.82-.59 1.53-1.33 2.09-2.17-.75.33-1.56.55-2.41.65z"/>
                        </svg>
                    </a>

                    <a href="#" aria-label="YouTube" class="text-zinc-700 hover:text-cyan-700 transition-colors">
                        <svg class="w-6 h-6" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                            <path d="M10 15l5.2-3L10 9v6z"></path>
                            <path d="M23.5 6.2s-.2-1.6-.8-2.3c-.8-1-1.7-1-2.1-1.1C16.6 2.5 12 2.5 12 2.5h0s-4.6 0-8.6.3c-.4.1-1.3.1-2.1 1.1-.6.7-.8 2.3-.8 2.3S0 8 0 9.9v2.3C0 14 0.2 15.6.2 15.6s.2 1.6.8 2.3c.8 1 1.9 1 2.4 1.1 1.8.1 7.6.3 7.6.3s4.6 0 8.6-.3c.4-.1 1.3-.1 2.1-1.1.6-.7.8-2.3.8-2.3s.2-1.6.2-3.4V9.9c0-1.9-.2-3.7-.2-3.7z"></path>
                        </svg>
                    </a>
                </div>
            </div>
        </div> --}}
    </div>
</div>
    {{-- <div class="container mx-auto  sm:px-6 lg:px-36 mt-6 mb-15">
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
        {{-- </div> --}}
    {{-- </div> --}} 
        

    {{-- Berita --}}
    
    
    {{-- Gallery --}}
    {{-- <div class="mb-15">
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
    </div> --}}
{{-- </div> --}}

@endsection




