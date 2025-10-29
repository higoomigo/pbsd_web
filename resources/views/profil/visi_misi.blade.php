@extends('layout-web.app')
@section('title', 'Visi Misi')
@section('content')
@section('judul_halaman', 'Visi Misi')
<div class="mb-20 px-20">
    {{-- Visi --}}
    <div class="mb-2 mt-8">
        <div class="grid lg:grid-cols-3 md:grid-cols-1 sm:grid-cols-1 gap-6 mb-6 md:pt-12">
            <div class="col-span-1 px-6 pb-1 w-full md:mb-6 font-">
                <p class="lg:text-4xl text-5xl font-title  text-start pl-20 text-gray-900">Visi</p>
            </div>
            <div class="col-span-2 px-6 pb-6">
                <p class="mb-1 text-lg text-gray-900 font-body leading-5 text-justify">
                    Menjadi pusat unggulan dalam pelestarian, pengembangan, dan pemanfaatan bahasa dan sastra daerah sebagai warisan budaya yang mendukung identitas lokal dan kemajuan ilmu pengetahuan.
                </p>
                {{-- <a href="#" class="text-blue-500 hover:underline">Baca Selengkapnya</a> --}}
            </div>
        </div>

        {{-- MISI MISI MISI MISI MISI --}}
        <div class="grid lg:grid-cols-3 md:grid-cols-1 sm:grid-cols-1 gap-6 mb-6 md:pt-2">
            <div class="col-span-1 px-6 pb-1 w-full md:mb-6">
                <p class="lg:text-4xl text-5xl font-title text-start pl-20 text-gray-900">Misi</p>
            </div>
            <div class="col-span-2 px-6 pb-6">
                <ul class="list-disc mb-6 text-lg font-body text-gray-900 ">
                    <li class="mb-3 leading-5">
                        Mengembangkan dan melestarikan bahasa serta sastra daerah melalui penelitian, pengkajian, dan penerbitan karya ilmiah yang berkualitas.
                    </li>

                    <li class="mb-3 leading-5 ">
                        Mendorong penggunaan bahasa dan sastra daerah dalam berbagai aspek kehidupan masyarakat, termasuk pendidikan, seni, dan media.
                    </li>
                    <li class="mb-3 leading-5">
                        Melaksanakan penelitian dan pengkajian tentang bahasa dan sastra daerah di Gorontalo dan wilayah Nusantara untuk mendukung pelestarian dan pengembangan kebudayaan lokal.
                    </li>
                    <li class="mb-3 leading-5">
                        Mendokumentasikan dan mengarsipkan bahasa serta karya sastra daerah melalui media cetak dan digital guna menjamin keberlanjutan pengetahuan lintas generasi.
                    </li>
                    <li class="mb-3 leading-5">
                        Melakukan diseminasi dan edukasi publik melalui pelatihan, seminar, lokakarya, dan penerbitan yang mendorong pemanfaatan bahasa dan sastra daerah dalam kehidupan sehari-hari.
                    </li>
                    <li class="mb-3 leading-5">
                        Bersinergi dengan lembaga pemerintah, adat, dan komunitas lokal dalam program pelestarian dan revitalisasi bahasa serta sastra daerah.
                    </li>
                    <li class="mb-3 leading-5">
                        Mendukung kurikulum pendidikan lokal dengan menyediakan bahan ajar dan sumber literasi yang berbasis bahasa dan sastra daerah.
                    </li>
                </ul>
            </div>
        </div>
    {{-- <div class="grid md:grid-cols-3 mt-6 gap-6 mb-6">
        <div class="col-span-1 text-xl font-custom-title font-bold text-start px-6 pb-6 w-full mb-6">
            Visi
        </div>
        <div class="col-span-2 px-6 pb-6"></div>
    </div> --}}
    </div>
</div>



@endsection