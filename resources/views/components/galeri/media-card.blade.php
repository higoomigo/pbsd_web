@php
    // Pastikan relationship album diload
    $media->loadMissing('album');
    
    $isFoto = $media->tipe === 'foto';
    $isVideo = $media->tipe === 'video';
    $isYoutube = $media->tipe === 'youtube';
@endphp

<div class="group relative bg-white rounded-lg border border-gray-200 overflow-hidden hover:shadow-lg transition-all duration-300">
    {{-- Media Thumbnail --}}
    <div class="relative aspect-square bg-gray-100 overflow-hidden">
        {{-- Di view, test component --}}
<div class="bg-purple-100 p-4 rounded mb-4">
    <h3 class="font-bold">Testing Component:</h3>
    @if($fotos->count() > 0)
        @include('components.galeri.media-card', ['media' => $fotos->first()])
    @else
        <p class="text-red-500">Cannot test - no fotos available</p>
    @endif
</div>
        @if($isFoto)
            {{-- Foto Thumbnail --}}
            @if($media->file_path || $media->thumbnail_path)
                <img 
                    src="{{ $media->thumbnail_path ? asset('storage/' . $media->thumbnail_path) : asset('storage/' . $media->file_path) }}" 
                    alt="{{ $media->judul }}"
                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                    loading="lazy"
                    onerror="this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAwIiBoZWlnaHQ9IjIwMCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48cmVjdCB3aWR0aD0iMTAwJSIgaGVpZ2h0PSIxMDAlIiBmaWxsPSIjZjNmNGY2Ii8+PHRleHQgeD0iNTAlIiB5PSI1MCUiIGZvbnQtZmFtaWx5PSJBcmlhbCwgc2Fucy1zZXJpZiIgZm9udC1zaXplPSIxNCIgZmlsbD0iIzljYTZhZiIgdGV4dC1hbmNob3I9Im1pZGRsZSIgZHk9Ii4zZW0iPkdhbWJhciB0aWRhayBkYXBhdCBkaXRlbXBpa2FuPC90ZXh0Pjwvc3ZnPg=='"
                >
            @else
                <div class="w-full h-full bg-gradient-to-br from-green-50 to-green-100 flex items-center justify-center">
                    <i class="fas fa-camera text-green-400 text-3xl"></i>
                </div>
            @endif
            <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-10 transition-all duration-300 flex items-center justify-center">
                <div class="opacity-0 group-hover:opacity-100 transform translate-y-2 group-hover:translate-y-0 transition-all duration-300">
                    <i class="fas fa-search-plus text-white text-xl"></i>
                </div>
            </div>
            
        @elseif($isVideo)
            {{-- Video Thumbnail --}}
            @if($media->thumbnail_path)
                <img 
                    src="{{ asset('storage/' . $media->thumbnail_path) }}" 
                    alt="{{ $media->judul }}"
                    class="w-full h-full object-cover"
                    loading="lazy"
                    onerror="this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAwIiBoZWlnaHQ9IjIwMCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48cmVjdCB3aWR0aD0iMTAwJSIgaGVpZ2h0PSIxMDAlIiBmaWxsPSIjZGJlMmZmIi8+PHRleHQgeD0iNTAlIiB5PSI1MCUiIGZvbnQtZmFtaWx5PSJBcmlhbCwgc2Fucy1zZXJpZiIgZm9udC1zaXplPSIxNCIgZmlsbD0iIzM3NjFlYSIgdGV4dC1hbmNob3I9Im1pZGRsZSIgZHk9Ii4zZW0iPlZpZGVvPC90ZXh0Pjwvc3ZnPg=='"
                >
            @else
                <div class="w-full h-full bg-gradient-to-br from-blue-50 to-purple-50 flex items-center justify-center">
                    <i class="fas fa-video text-blue-400 text-3xl"></i>
                </div>
            @endif
            <div class="absolute inset-0 bg-black bg-opacity-30 flex items-center justify-center">
                <div class="w-12 h-12 bg-white bg-opacity-90 rounded-full flex items-center justify-center group-hover:scale-110 transition-transform">
                    <i class="fas fa-play text-blue-600 ml-1"></i>
                </div>
            </div>
            
        @elseif($isYoutube)
            {{-- YouTube Thumbnail --}}
            <div class="w-full h-full bg-gradient-to-br from-red-50 to-red-100 flex items-center justify-center">
                <i class="fab fa-youtube text-red-500 text-4xl"></i>
            </div>
            <div class="absolute inset-0 bg-black bg-opacity-30 flex items-center justify-center">
                <div class="w-12 h-12 bg-red-600 rounded-full flex items-center justify-center group-hover:scale-110 transition-transform">
                    <i class="fas fa-play text-white ml-1"></i>
                </div>
            </div>
        @endif

        {{-- Media Type Badge --}}
        <div class="absolute top-2 left-2">
            @if($isFoto)
                <span class="bg-green-500 text-white px-2 py-1 rounded text-xs font-medium">
                    <i class="fas fa-camera mr-1"></i>Foto
                </span>
            @elseif($isVideo)
                <span class="bg-blue-500 text-white px-2 py-1 rounded text-xs font-medium">
                    <i class="fas fa-video mr-1"></i>Video
                </span>
            @elseif($isYoutube)
                <span class="bg-red-500 text-white px-2 py-1 rounded text-xs font-medium">
                    <i class="fab fa-youtube mr-1"></i>YouTube
                </span>
            @endif
        </div>

        {{-- Utama Badge --}}
        @if($media->is_utama)
            <div class="absolute top-2 right-2 bg-yellow-500 text-white px-2 py-1 rounded text-xs font-medium">
                <i class="fas fa-star mr-1"></i>Utama
            </div>
        @endif

        {{-- Album Name --}}
        @if($media->album && $media->album->judul)
            <div class="absolute bottom-2 left-2 right-2">
                <span class="bg-black bg-opacity-60 text-white px-2 py-1 rounded text-xs truncate block">
                    {{ $media->album->judul }}
                </span>
            </div>
        @endif
    </div>

    {{-- Media Info --}}
    <div class="p-3">
        <h3 class="font-medium text-gray-900 text-sm mb-1 line-clamp-2 group-hover:text-blue-600 transition-colors">
            {{ $media->judul ?? 'Judul tidak tersedia' }}
        </h3>
        
        @if($media->keterangan)
            <p class="text-gray-600 text-xs line-clamp-2 mb-2">
                {{ $media->keterangan }}
            </p>
        @endif

        {{-- Album Info --}}
        @if($media->album && $media->album->judul)
            <div class="mb-2">
                <p class="text-xs text-gray-500 flex items-center">
                    <i class="fas fa-folder mr-1"></i>
                    <span class="truncate">{{ $media->album->judul }}</span>
                </p>
            </div>
        @endif

        {{-- Media Actions --}}
        <div class="flex items-center justify-between text-xs text-gray-500">
            <div>
                @if($media->taken_at)
                    <span class="flex items-center">
                        <i class="fas fa-calendar mr-1"></i>
                        {{ $media->taken_at->format('d M Y') }}
                    </span>
                @else
                    <span>&nbsp;</span>
                @endif
            </div>
            
            <div class="flex items-center space-x-2">
                @if($isFoto)
                    <a href="{{ route('galeri.media.show', $media) }}" 
                       class="text-blue-600 hover:text-blue-800 transition-colors"
                       title="Lihat detail">
                        <i class="fas fa-eye"></i>
                    </a>
                    <a href="{{ route('galeri.media.download', $media) }}" 
                       class="text-green-600 hover:text-green-800 transition-colors"
                       title="Download">
                        <i class="fas fa-download"></i>
                    </a>
                @elseif($isVideo)
                    <a href="{{ route('galeri.media.show', $media) }}" 
                       class="text-blue-600 hover:text-blue-800 transition-colors"
                       title="Putar video">
                        <i class="fas fa-play"></i>
                    </a>
                @elseif($isYoutube)
                    <a href="{{ route('galeri.media.show', $media) }}" 
                       class="text-red-600 hover:text-red-800 transition-colors"
                       title="Tonton di YouTube">
                        <i class="fab fa-youtube"></i>
                    </a>
                @endif
            </div>
        </div>
    </div>
</div>