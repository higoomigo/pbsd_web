@extends('layout-web.app')
@section('title', 'Pusat Studi Pelestarian Bahasa Dan Sastra Daerah')
@section('content')
@section('judul_halaman', 'Profil Pusat Studi')

<div class="mb-20 px-44">
    <div class="grid lg:grid-cols-3 md:grid-cols-1 sm:grid-cols-1 gap-6 mb-6 pt-12 md:pb-12 bg-base-100">
        <div class="col-span-3 pb-6 ">
            <p class="mb-10 text-zinc-700 font-body text-lg leading-6">
                <span class="text-xl"><b>Pusat Studi Pelestarian Bahasa dan Sastra Daerah</b> Universitas Negeri Gorontalo hadir sebagai komitmen akademik dalam menjaga eksistensi bahasa dan sastra daerah, khususnya Bahasa Gorontalo.</span>
                <br class="md:mb-10 mb-5">
                Pusat studi ini fokus pada kegiatan penelitian, dokumentasi, pengembangan, dan diseminasi pengetahuan bahasa serta sastra daerah sebagai upaya pelestarian warisan budaya yang tak ternilai.
                <br class="md:mb-10 mb-5">
                Melalui kolaborasi lintas disiplin, PSPBSD menjadi wadah strategis yang menghubungkan akademisi, budayawan, dan masyarakat dalam memperkuat identitas lokal di tengah tantangan global.
            </p>
            {{-- <div class=" w-full text-end mt-8 ">
                <a href="#" class="btn hover:bg-white border-2 bg-black text-white text-md hover:text-zinc-900 relative leading-4
                bg-gradient-to-r from-current to-current bg-[length:0%_2px] bg-left-bottom bg-no-repeat
                transition-[background-size] duration-500 ease-in-out
                group-hover:bg-[length:100%_1px] ">Baca Selengkapnya</a>
            </div> --}}
        </div>
    </div>
</div>



@endsection