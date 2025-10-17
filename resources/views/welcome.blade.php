@include('layout-web.app')
@section('title', 'Pusat Studi Pelestarian Bahasa Dan Sastra Daerah')
@section('content')

<!-- GAMBAR DISINI -->
<div class="w-full">
    {{-- sm:text-6xl text-5xl --}}
    <div class="font-title  pb-20 md:pb-48 pt-30 md:pt-36 lg:px-28 px-4 md:px-20 md:text-center text-start">
        <p class="text-cyan-900 md:mb-4  text-3xl sm:text-6xl text-center md:text-start md:mb-2"> Pusat Studi </p>
        <p class="text-cyan-950 font-normal text-4xl text-center md:text-start sm:text-5xl md:text-7xl"> Pelestarian Bahasa dan Sastra Daerah </p> 
    </div>
</div>
<div class=" w-full h-[500px]  mb-6 opacity-0 translate-y-8 transition-all duration-700 ease-out mt-20" id="hero-image">
    <img class="w-full h-full object-cover" src="https://www.researchgate.net/publication/371827625/figure/fig3/AS:11431281179849279@1691415873069/The-Harbour-Office-area-in-Gorontalo-circa-1926-Source-Digital-Collection-Leiden.png" alt="">
</div>

<!-- Main content -->
<div class="container mx-auto  sm:px-6 lg:px-36 mt-6">
    {{-- Profil --}}
    <div class="mb-20">
        <div class="grid lg:grid-cols-3 md:grid-cols-1 sm:grid-cols-1 md:mt-6 gap-6 mb-6 pt-12 md:pt-40 md:pb-12 ">
            <div class="col-span-1 px-6 pb-1 w-full md:mb-6">
                <p class="lg:text-5xl text-5xl font-title md:pl-5 text-start text-zinc-700">Profil</p>
            </div>
            <div class="col-span-2 px-6 pb-6">
                <p class="mb-4 text-zinc-700 font-body text-lg leading-6 md:pl-12">
                    <b>Pusat Studi Pelestarian Bahasa dan Sastra Daerah</b> Universitas Negeri Gorontalo hadir sebagai komitmen akademik dalam menjaga eksistensi bahasa dan sastra daerah, khususnya Bahasa Gorontalo. 
                    <br class="md:mb-10 mb-5">
                    Pusat studi ini fokus pada kegiatan penelitian, dokumentasi, pengembangan, dan diseminasi pengetahuan bahasa serta sastra daerah sebagai upaya pelestarian warisan budaya yang tak ternilai.
                    <br class="md:mb-10 mb-5">
                    Melalui kolaborasi lintas disiplin, PSPBSD menjadi wadah strategis yang menghubungkan akademisi, budayawan, dan masyarakat dalam memperkuat identitas lokal di tengah tantangan global.
                </p>
                <div class="w-full text-end">
                    <a href="#" class="text-blue-500 hover:underline font-body pr-6 text-md">Baca Selengkapnya</a>
                </div>
            </div>
        </div>
    </div>
</div>

    {{------------------- CONTAINER VISI MISI ----------}}
    
    <div class="container mx-auto  sm:px-6 lg:px-36 mt-6 mb-15">
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
    </div>
        

    {{-- Berita --}}
    
    
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
</script>