@extends('layout-web.app')

@section('title', 'Galeri — Pusat Studi Pelestarian Bahasa Dan Sastra Daerah')
@section('judul_halaman', 'Galeri Pusat Studi')

@section('content')
<div class="mb-20">
    <div class="mt-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- Hero Section --}}
            <div class="text-center mb-12">
                {{-- <h1 class="text-4xl font-bold text-gray-900 mb-6">Galeri Dokumentasi</h1> --}}
                <p class="text-md text-gray-600 max-w-3xl mx-auto leading-relaxed text-left">
                    
                </p>
            </div>

            {{-- Quick Stats --}}
            {{-- <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-12">
                <a href="{{ route('galeri.albums.index') }}" 
                   class="bg-white rounded-xl border border-gray-200 p-6 text-center hover:shadow-lg transition-all duration-300 hover:border-blue-500">
                    <div class="w-12 h-12 mx-auto mb-3 bg-blue-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-images text-blue-600 text-xl"></i>
                    </div>
                    <div class="text-2xl font-bold text-gray-900">{{ $totalAlbums }}</div>
                    <div class="text-sm text-gray-600">Album Galeri</div>
                </a>

                <a href="{{ route('galeri.media.foto') }}" 
                   class="bg-white rounded-xl border border-gray-200 p-6 text-center hover:shadow-lg transition-all duration-300 hover:border-green-500">
                    <div class="w-12 h-12 mx-auto mb-3 bg-green-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-camera text-green-600 text-xl"></i>
                    </div>
                    <div class="text-2xl font-bold text-gray-900">{{ $totalFotos }}</div>
                    <div class="text-sm text-gray-600">Foto</div>
                </a>

                <a href="{{ route('galeri.media.video') }}" 
                   class="bg-white rounded-xl border border-gray-200 p-6 text-center hover:shadow-lg transition-all duration-300 hover:border-blue-500">
                    <div class="w-12 h-12 mx-auto mb-3 bg-blue-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-video text-blue-600 text-xl"></i>
                    </div>
                    <div class="text-2xl font-bold text-gray-900">{{ $totalVideos }}</div>
                    <div class="text-sm text-gray-600">Video</div>
                </a>

                <a href="{{ route('galeri.media.youtube') }}" 
                   class="bg-white rounded-xl border border-gray-200 p-6 text-center hover:shadow-lg transition-all duration-300 hover:border-red-500">
                    <div class="w-12 h-12 mx-auto mb-3 bg-red-100 rounded-full flex items-center justify-center">
                        <i class="fab fa-youtube text-red-600 text-xl"></i>
                    </div>
                    <div class="text-2xl font-bold text-gray-900">{{ $totalYoutubes }}</div>
                    <div class="text-sm text-gray-600">YouTube</div>
                </a>
            </div> --}}

            {{-- Featured Albums --}}
            <section class="mb-16">
                <div class="flex items-center justify-between mb-8">
                    <div>
                        <h2 class="text-2xl font-title text-gray-900 ">Album Pusat Studi</h2>
                        <p class="text-gray-600 mt-2">Jelajahi koleksi visual kegiatan penelitian, pelestarian bahasa, 
                    dan sastra daerah yang telah dilakukan oleh tim Pusat Studi.</p>
                    </div>
                    <a href="{{ route('galeri.albums.index') }}" class="text-blue-600 hover:text-blue-800 font-medium flex items-center">
                        Lihat Semua Album
                        <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>

                @if($albums->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($albums as $album)
                            <div class="bg-white overflow-hidden transition-all duration-300 group">
                                {{-- Cover Image --}}
                                <div class="relative h-48 overflow-hidden">
                                    @if($album->cover_path)
                                        <img 
                                            src="{{ asset('storage/' . $album->cover_path) }}" 
                                            alt="{{ $album->judul }}"
                                            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                                        >
                                    @else
                                        <div class="w-full h-full bg-gradient-to-br from-blue-50 to-purple-50 flex items-center justify-center">
                                            <i class="fas fa-images text-gray-400 text-4xl"></i>
                                        </div>
                                    @endif
                                    
                                    {{-- Overlay --}}
                                    <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 transition-all duration-300"></div>
                                    
                                    {{-- Featured Badge --}}
                                    {{-- <div class="absolute top-4 left-4 bg-yellow-500 text-white px-3 py-1 rounded-full text-sm font-medium">
                                        <i class="fas fa-star mr-1"></i>Unggulan
                                    </div> --}}

                                    {{-- Media Count --}}
                                    {{-- <div class="absolute top-4 right-4 bg-black bg-opacity-60 text-white px-2 py-1 rounded-full text-sm">
                                        <i class="fas fa-camera mr-1"></i>{{ $album->media_count }}
                                    </div> --}}
                                </div>

                                {{-- Content --}}
                                <div class="p-2">
                                    <h3 class="font-bold text-md text-gray-900 mb-3 group-hover:text-blue-600 transition-colors">
                                        <a href="{{ route('galeri.albums.show', $album->slug) }}" class="hover:no-underline">
                                            {{ $album->judul }}
                                        </a>
                                    </h3>

                                    {{-- @if($album->deskripsi_singkat)
                                        <p class="text-gray-600 mb-4 line-clamp-2">
                                            {{ $album->deskripsi_singkat }}
                                        </p>
                                    @endif --}}

                                    {{-- Metadata --}}
                                    <div class="flex items-center justify-between text-sm text-gray-500">
                                        <div class="flex items-center space-x-4">
                                            @if($album->kategori)
                                                <span class="bg-gray-100 px-3 py-1 rounded-full">{{ $album->kategori }}</span>
                                            @endif
                                            @if($album->tahun)
                                                <span>{{ $album->tahun }}</span>
                                            @endif
                                        </div>
                                        
                                        {{-- <span class="text-blue-600 font-medium hover:text-blue-800 transition-colors">
                                            Jelajahi <i class="fas fa-arrow-right ml-1"></i>
                                        </span> --}}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="bg-white rounded-xl border border-gray-200 p-12 text-center">
                        <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-gray-100 flex items-center justify-center">
                            <i class="fas fa-star text-gray-400 text-xl"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Belum ada album unggulan</h3>
                        <p class="text-gray-600">
                            Album yang ditandai sebagai "tampil di beranda" akan muncul di sini.
                        </p>
                    </div>
                @endif
            </section>

            {{-- Quick Access Sections --}}
            {{-- <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-16"> --}}
                {{-- Foto Section --}}
                {{-- <a href="{{ route('galeri.media.foto') }}" 
                   class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl p-8 text-white hover:shadow-xl transition-all duration-300 group">
                    <div class="w-16 h-16 mb-4 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                        <i class="fas fa-camera text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-2">Galeri Foto</h3>
                    <p class="text-green-100 mb-4">Jelajahi koleksi foto dokumentasi kegiatan</p>
                    <div class="flex items-center text-green-100 group-hover:text-white">
                        <span>Lihat {{ $totalFotos }} foto</span>
                        <i class="fas fa-arrow-right ml-2 transform group-hover:translate-x-1 transition-transform"></i>
                    </div>
                </a> --}}

                {{-- Video Section --}}
                {{-- <a href="{{ route('galeri.media.video') }}" 
                   class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl p-8 text-white hover:shadow-xl transition-all duration-300 group">
                    <div class="w-16 h-16 mb-4 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                        <i class="fas fa-video text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-2">Galeri Video</h3>
                    <p class="text-blue-100 mb-4">Tonton video dokumentasi dan tutorial</p>
                    <div class="flex items-center text-blue-100 group-hover:text-white">
                        <span>Lihat {{ $totalVideos }} video</span>
                        <i class="fas fa-arrow-right ml-2 transform group-hover:translate-x-1 transition-transform"></i>
                    </div>
                </a> --}}

                {{-- YouTube Section --}}
                {{-- <a href="{{ route('galeri.media.youtube') }}" 
                   class="bg-gradient-to-br from-red-500 to-red-600 rounded-xl p-8 text-white hover:shadow-xl transition-all duration-300 group">
                    <div class="w-16 h-16 mb-4 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                        <i class="fab fa-youtube text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-2">YouTube</h3>
                    <p class="text-red-100 mb-4">Konten video di platform YouTube</p>
                    <div class="flex items-center text-red-100 group-hover:text-white">
                        <span>Lihat {{ $totalYoutubes }} video</span>
                        <i class="fas fa-arrow-right ml-2 transform group-hover:translate-x-1 transition-transform"></i>
                    </div>
                </a> --}}
            {{-- </div> --}}

            {{-- Recent Activity --}}
            {{-- <section class="bg-gray-50 rounded-xl p-8"> --}}
                {{-- <h2 class="text-2xl font-bold text-gray-900 mb-6">Aktivitas Terbaru</h2> --}}
                {{-- <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6"> --}}
                    {{-- Latest Album --}}
                    {{-- <div class="bg-white rounded-lg p-6 border border-gray-200">
                        <div class="flex items-center mb-3">
                            <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                                <i class="fas fa-plus text-blue-600"></i>
                            </div>
                            <div>
                                <div class="text-sm text-gray-500">Album Terbaru</div>
                                <div class="font-medium text-gray-900">
                                    @if($latestAlbum)
                                        {{ Str::limit($latestAlbum->judul, 20) }}
                                    @else
                                        -
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="text-xs text-gray-500">
                            @if($latestAlbum)
                                {{ $latestAlbum->published_at->diffForHumans() }}
                            @endif
                        </div>
                    </div> --}}

                    {{-- Total Media --}}
                    {{-- <div class="bg-white rounded-lg p-6 border border-gray-200">
                        <div class="flex items-center mb-3">
                            <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center mr-3">
                                <i class="fas fa-database text-green-600"></i>
                            </div>
                            <div>
                                <div class="text-sm text-gray-500">Total Media</div>
                                <div class="font-medium text-gray-900">{{ $totalAllMedia }}</div>
                            </div>
                        </div>
                        <div class="text-xs text-gray-500">Semua jenis konten</div>
                    </div> --}}

                    {{-- Active Years --}}
                    {{-- <div class="bg-white rounded-lg p-6 border border-gray-200">
                        <div class="flex items-center mb-3">
                            <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center mr-3">
                                <i class="fas fa-calendar text-purple-600"></i>
                            </div>
                            <div>
                                <div class="text-sm text-gray-500">Tahun Aktif</div>
                                <div class="font-medium text-gray-900">{{ $activeYears }}</div>
                            </div>
                        </div>
                        <div class="text-xs text-gray-500">Rentang dokumentasi</div>
                    </div> --}}

                    {{-- Latest Update --}}
                    {{-- <div class="bg-white rounded-lg p-6 border border-gray-200">
                        <div class="flex items-center mb-3">
                            <div class="w-10 h-10 bg-yellow-100 rounded-full flex items-center justify-center mr-3">
                                <i class="fas fa-sync text-yellow-600"></i>
                            </div>
                            <div>
                                <div class="text-sm text-gray-500">Update Terakhir</div>
                                <div class="font-medium text-gray-900">
                                    @if($lastUpdate)
                                        {{ $lastUpdate->diffForHumans() }}
                                    @else
                                        -
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="text-xs text-gray-500">Konten terbaru</div>
                    </div> --}}
                {{-- </div> --}}
            {{-- </section> --}}
        </div>
    </div>
</div>
@endsection