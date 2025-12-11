@extends('layout-web.app')

@section('title', 'Struktur Organisasi — Pusat Studi Pelestarian Bahasa Dan Sastra Daerah')
@section('judul_halaman', 'Struktur Organisasi')

@section('content')
<div class="mb-20">
    <div class="">
        <div class="grid lg:grid-cols-3 md:grid-cols-1 gap-6 mb-6  md:pb-12 bg-base-100 ">

            @if($struktur)
                <div class="col-span-3 px-4 sm:px-6 pb-8">
                    <div class="space-y-6">

                        {{-- Deskripsi / keterangan struktur (DI ATAS) --}}
                        <div>
                            @if($struktur->deskripsi)
                                <div class="prose prose-sm sm:prose-base max-w-none text-zinc-700">
                                    {!! nl2br(e($struktur->deskripsi)) !!}
                                    {{-- 
                                      Kalau nanti deskripsi disimpan dalam bentuk HTML penuh dari editor WYSIWYG,
                                      ganti jadi: {!! $struktur->deskripsi !!}
                                    --}}
                                </div>
                            @else
                                <p class="text-sm text-zinc-600">
                                    Belum ada deskripsi tertulis mengenai struktur organisasi yang tersedia.
                                </p>
                            @endif

                            <div class="mt-4 text-xs text-zinc-500">
                                <p>
                                    Informasi struktur ini disusun dan dikelola oleh pengelola Pusat Studi.
                                    Perubahan susunan organisasi dapat terjadi sesuai dengan kebijakan terbaru.
                                </p>
                            </div>
                        </div>

                        {{-- Gambar struktur (DI BAWAH TEKS) --}}
                        <div>
                            @if($struktur->gambar_path)
                                @php
                                    $src = Storage::url($struktur->gambar_path);
                                @endphp
                                <figure class="w-full bg-white  overflow-hidden shadow-sm">
                                    <img
                                        src="{{ $src }}"
                                        alt="{{ $struktur->alt_text ?: 'Struktur Organisasi Pusat Studi' }}"
                                    class="w-full h-auto object-contain"
                                        loading="lazy"
                                    >
                                    @if($struktur->alt_text)
                                        <figcaption class="px-4 py-2 text-xs text-zinc-500 border-t border-zinc-200 bg-zinc-50">
                                            {{ $struktur->alt_text }}
                                        </figcaption>
                                    @endif
                                </figure>
                            @else
                                <div class="w-full border border-dashed border-zinc-300 p-6 text-center text-sm text-zinc-500 bg-white">
                                    Struktur organisasi belum memiliki gambar yang diunggah.
                                </div>
                            @endif
                        </div>

                    </div>
                </div>
            @else
                {{-- Kalau belum ada entri Struktur sama sekali --}}
                <div class="col-span-3 px-4 sm:px-6 pb-8">
                    <div class="border border-dashed border-zinc-300 rounded-lg p-6 bg-white text-center">
                        <p class="text-sm text-zinc-600">
                            Struktur organisasi Pusat Studi belum tersedia untuk ditampilkan.
                        </p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
