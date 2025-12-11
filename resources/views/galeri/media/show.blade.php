@extends('layout-web.app')

@section('title', $media->judul . ' — Galeri Media — Pusat Studi Pelestarian Bahasa Dan Sastra Daerah')
@section('judul_halaman', $media->judul)

@section('content')
<div class="mb-20 ">
    <div class="mt-8">
        <div class="max-w-7xl mx-auto px-20 sm:px-6 lg:px-20">
            {{-- Breadcrumb --}}
            <nav class="flex mb-6" aria-label="Breadcrumb">
                <ol class="flex items-center space-x-2 text-sm text-gray-600">
                    <li>
                        <a href="{{ route('galeri.albums.beranda') }}" class="hover:text-blue-600">Galeri</a>
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-chevron-right mx-2 text-gray-400"></i>
                        <a href="{{ route('galeri.albums.show', $media->album->slug) }}" class="hover:text-blue-600">
                            {{ Str::limit($media->album->judul, 20) }}
                        </a>
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-chevron-right mx-2 text-gray-400"></i>
                        <span class="text-gray-900">{{ Str::limit($media->judul, 30) }}</span>
                    </li>
                </ol>
            </nav>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                {{-- Media Content --}}
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-xl border border-gray-200 p-6">
                        @if($media->tipe === 'foto')
                            {{-- Foto Display --}}
                            <div class="text-center">
                                <img 
                                    src="{{ asset('storage/' . $media->file_path) }}" 
                                    alt="{{ $media->judul }}"
                                    class="max-w-full h-auto max-h-96 mx-auto rounded-lg shadow-md cursor-zoom-in"
                                    id="mediaImage"
                                    onclick="openLightbox(this.src, '{{ $media->judul }}')"
                                >
                                <p class="text-sm text-gray-500 mt-2">Klik gambar untuk memperbesar</p>
                            </div>
                            
                        @elseif($media->tipe === 'video')
                            {{-- Video Display --}}
                            <div class="bg-gray-900 rounded-lg overflow-hidden">
                                <video 
                                    controls 
                                    class="w-full h-auto max-h-96 mx-auto"
                                    poster="{{ $media->thumbnail_path ? asset('storage/' . $media->thumbnail_path) : '' }}"
                                    id="mediaVideo"
                                >
                                    <source src="{{ asset('storage/' . $media->file_path) }}" type="video/mp4">
                                    <source src="{{ asset('storage/' . $media->file_path) }}" type="video/avi">
                                    <source src="{{ asset('storage/' . $media->file_path) }}" type="video/mov">
                                    Browser Anda tidak mendukung pemutar video.
                                </video>
                            </div>
                            
                        @elseif($media->tipe === 'youtube')
                            {{-- YouTube Display --}}
                            <div class="bg-gray-900 rounded-lg overflow-hidden">
                                <div class="aspect-w-16 aspect-h-9">
                                    <iframe 
                                        src="https://www.youtube.com/embed/{{ $media->youtube_url ? extractYouTubeId($media->youtube_url) : '' }}?autoplay=0&rel=0" 
                                        frameborder="0" 
                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                        allowfullscreen
                                        class="w-full h-96"
                                        id="youtubePlayer"
                                    ></iframe>
                                </div>
                            </div>
                        @endif

                        {{-- Media Actions --}}
                        <div class="flex flex-wrap justify-center mt-6 gap-4">
                            @if($media->tipe === 'foto')
                                <a href="{{ route('galeri.media.download', $media) }}" 
                                   class="bg-blue-500 text-white px-6 py-3 rounded-lg hover:bg-blue-600 transition-colors flex items-center">
                                    <i class="fas fa-download mr-2"></i>Download Foto
                                </a>
                                <button onclick="shareMedia()" 
                                        class="bg-green-500 text-white px-6 py-3 rounded-lg hover:bg-green-600 transition-colors flex items-center">
                                    <i class="fas fa-share-alt mr-2"></i>Bagikan
                                </button>
                                <button onclick="openLightbox('{{ asset('storage/' . $media->file_path) }}', '{{ $media->judul }}')" 
                                        class="bg-purple-500 text-white px-6 py-3 rounded-lg hover:bg-purple-600 transition-colors flex items-center">
                                    <i class="fas fa-expand mr-2"></i>Fullscreen
                                </button>
                                
                            @elseif($media->tipe === 'video')
                                <a href="{{ route('galeri.media.download', $media) }}" 
                                   class="bg-blue-500 text-white px-6 py-3 rounded-lg hover:bg-blue-600 transition-colors flex items-center">
                                    <i class="fas fa-download mr-2"></i>Download Video
                                </a>
                                <button onclick="shareMedia()" 
                                        class="bg-green-500 text-white px-6 py-3 rounded-lg hover:bg-green-600 transition-colors flex items-center">
                                    <i class="fas fa-share-alt mr-2"></i>Bagikan
                                </button>
                                
                            @elseif($media->tipe === 'youtube')
                                <a href="{{ $media->youtube_url }}" 
                                   target="_blank"
                                   class="bg-red-500 text-white px-6 py-3 rounded-lg hover:bg-red-600 transition-colors flex items-center">
                                    <i class="fab fa-youtube mr-2"></i>Tonton di YouTube
                                </a>
                                <button onclick="shareMedia()" 
                                        class="bg-green-500 text-white px-6 py-3 rounded-lg hover:bg-green-600 transition-colors flex items-center">
                                    <i class="fas fa-share-alt mr-2"></i>Bagikan
                                </button>
                            @endif
                        </div>
                    </div>

                    {{-- Media Description --}}
                    @if($media->keterangan)
                    <div class="bg-white rounded-xl border border-gray-200 p-6 mt-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-3">Deskripsi</h3>
                        <p class="text-gray-700 leading-relaxed">{{ $media->keterangan }}</p>
                    </div>
                    @endif
                </div>

                {{-- Media Info Sidebar --}}
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-xl border border-gray-200 p-6 sticky top-6">
                        <h2 class="text-xl font-bold text-gray-900 mb-4">Informasi Media</h2>
                        
                        {{-- Basic Info --}}
                        <div class="space-y-4">
                            <div>
                                <label class="text-sm font-medium text-gray-500 block mb-1">Judul</label>
                                <p class="text-gray-900 font-medium">{{ $media->judul }}</p>
                            </div>

                            <div>
                                <label class="text-sm font-medium text-gray-500 block mb-1">Album</label>
                                <a href="{{ route('galeri.albums.show', $media->album->slug) }}" 
                                   class="text-blue-600 hover:text-blue-800 font-medium flex items-center">
                                    <i class="fas fa-folder mr-2"></i>
                                    {{ $media->album->judul }}
                                </a>
                            </div>

                            <div>
                                <label class="text-sm font-medium text-gray-500 block mb-1">Tipe Media</label>
                                <div class="flex items-center">
                                    @if($media->tipe === 'foto')
                                        <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-medium">
                                            <i class="fas fa-camera mr-1"></i>Foto
                                        </span>
                                    @elseif($media->tipe === 'video')
                                        <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-medium">
                                            <i class="fas fa-video mr-1"></i>Video
                                        </span>
                                    @elseif($media->tipe === 'youtube')
                                        <span class="bg-red-100 text-red-800 px-3 py-1 rounded-full text-sm font-medium">
                                            <i class="fab fa-youtube mr-1"></i>YouTube
                                        </span>
                                    @endif
                                    
                                    @if($media->is_utama)
                                        <span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-sm font-medium ml-2">
                                            <i class="fas fa-star mr-1"></i>Utama
                                        </span>
                                    @endif
                                </div>
                            </div>

                            @if($media->album->kategori)
                            <div>
                                <label class="text-sm font-medium text-gray-500 block mb-1">Kategori</label>
                                <span class="bg-gray-100 text-gray-800 px-3 py-1 rounded-full text-sm">
                                    {{ $media->album->kategori }}
                                </span>
                            </div>
                            @endif

                            @if($media->taken_at)
                            <div>
                                <label class="text-sm font-medium text-gray-500 block mb-1">Tanggal Pengambilan</label>
                                <p class="text-gray-700">
                                    <i class="fas fa-calendar mr-2 text-gray-400"></i>
                                    {{ $media->taken_at->format('d F Y') }}
                                </p>
                            </div>
                            @endif

                            <div>
                                <label class="text-sm font-medium text-gray-500 block mb-1">Diunggah</label>
                                <p class="text-gray-700">
                                    <i class="fas fa-clock mr-2 text-gray-400"></i>
                                    {{ $media->created_at->format('d F Y') }}
                                </p>
                            </div>

                            @if($media->album->lokasi)
                            <div>
                                <label class="text-sm font-medium text-gray-500 block mb-1">Lokasi</label>
                                <p class="text-gray-700">
                                    <i class="fas fa-map-marker-alt mr-2 text-gray-400"></i>
                                    {{ $media->album->lokasi }}
                                </p>
                            </div>
                            @endif
                        </div>

                        {{-- Share Options --}}
                        <div class="mt-6 pt-6 border-t border-gray-200">
                            <h3 class="text-lg font-medium text-gray-900 mb-3">Bagikan Media</h3>
                            <div class="flex space-x-3 justify-center">
                                <button onclick="shareToFacebook()" 
                                        class="w-10 h-10 bg-blue-600 text-white rounded-full flex items-center justify-center hover:bg-blue-700 transition-colors"
                                        title="Share to Facebook">
                                    <i class="fab fa-facebook-f"></i>
                                </button>
                                <button onclick="shareToTwitter()" 
                                        class="w-10 h-10 bg-blue-400 text-white rounded-full flex items-center justify-center hover:bg-blue-500 transition-colors"
                                        title="Share to Twitter">
                                    <i class="fab fa-twitter"></i>
                                </button>
                                <button onclick="shareToWhatsApp()" 
                                        class="w-10 h-10 bg-green-500 text-white rounded-full flex items-center justify-center hover:bg-green-600 transition-colors"
                                        title="Share to WhatsApp">
                                    <i class="fab fa-whatsapp"></i>
                                </button>
                                <button onclick="copyLink()" 
                                        class="w-10 h-10 bg-gray-600 text-white rounded-full flex items-center justify-center hover:bg-gray-700 transition-colors"
                                        title="Copy Link">
                                    <i class="fas fa-link"></i>
                                </button>
                            </div>
                        </div>

                        {{-- Quick Stats --}}
                        <div class="mt-6 pt-6 border-t border-gray-200">
                            <h3 class="text-lg font-medium text-gray-900 mb-3">Album Info</h3>
                            <div class="grid grid-cols-2 gap-4 text-center">
                                <div class="bg-gray-50 rounded-lg p-3">
                                    <div class="text-lg font-bold text-blue-600">{{ $media->album->media_count }}</div>
                                    <div class="text-xs text-gray-600">Total Media</div>
                                </div>
                                <div class="bg-gray-50 rounded-lg p-3">
                                    <div class="text-lg font-bold text-green-600">
                                        {{ $media->album->media->where('tipe', 'foto')->count() }}
                                    </div>
                                    <div class="text-xs text-gray-600">Foto</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Related Media --}}
            @if($mediaTerkait->count() > 0)
                <section class="mt-12">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-2xl font-bold text-gray-900">Media Lainnya di Album Ini</h2>
                        <a href="{{ route('galeri.albums.show', $media->album->slug) }}" 
                           class="text-blue-600 hover:text-blue-800 font-medium flex items-center">
                            Lihat Semua Media
                            <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                    </div>
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-6 gap-4">
                        @foreach($mediaTerkait as $relatedMedia)
                            <a href="{{ route('galeri.media.show', $relatedMedia) }}" 
                               class="block bg-white rounded-lg border border-gray-200 overflow-hidden hover:shadow-lg transition-all duration-300 group">
                                @if($relatedMedia->tipe === 'foto')
                                    <img 
                                        src="{{ $relatedMedia->thumbnail_path ? asset('storage/' . $relatedMedia->thumbnail_path) : asset('storage/' . $relatedMedia->file_path) }}" 
                                        alt="{{ $relatedMedia->judul }}"
                                        class="w-full h-24 object-cover group-hover:scale-105 transition-transform duration-300"
                                        loading="lazy"
                                    >
                                @elseif($relatedMedia->tipe === 'video')
                                    <div class="w-full h-24 bg-blue-50 flex items-center justify-center relative">
                                        <i class="fas fa-video text-blue-500 text-xl"></i>
                                        <div class="absolute bottom-2 right-2 bg-black bg-opacity-60 text-white px-1 py-0.5 rounded text-xs">
                                            <i class="fas fa-play mr-1"></i>Video
                                        </div>
                                    </div>
                                @elseif($relatedMedia->tipe === 'youtube')
                                    <div class="w-full h-24 bg-red-50 flex items-center justify-center relative">
                                        <i class="fab fa-youtube text-red-500 text-xl"></i>
                                        <div class="absolute bottom-2 right-2 bg-black bg-opacity-60 text-white px-1 py-0.5 rounded text-xs">
                                            <i class="fab fa-youtube mr-1"></i>YT
                                        </div>
                                    </div>
                                @endif
                                <div class="p-2">
                                    <p class="text-xs text-gray-700 line-clamp-2 font-medium">{{ $relatedMedia->judul }}</p>
                                    <p class="text-xs text-gray-500 mt-1">
                                        @if($relatedMedia->tipe === 'foto')
                                            <i class="fas fa-camera mr-1"></i>Foto
                                        @elseif($relatedMedia->tipe === 'video')
                                            <i class="fas fa-video mr-1"></i>Video
                                        @else
                                            <i class="fab fa-youtube mr-1"></i>YouTube
                                        @endif
                                    </p>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </section>
            @endif
        </div>
    </div>
</div>

{{-- Lightbox Modal --}}
<div id="lightboxModal" class="fixed inset-0 bg-black bg-opacity-90 flex items-center justify-center z-50 hidden">
    <div class="relative max-w-7xl max-h-full mx-4">
        <button onclick="closeLightbox()" 
                class="absolute -top-12 right-0 text-white hover:text-gray-300 text-2xl z-10">
            <i class="fas fa-times"></i>
        </button>
        <img id="lightboxImage" src="" alt="" class="max-w-full max-h-screen object-contain">
        <div class="absolute bottom-4 left-0 right-0 text-center text-white">
            <h3 id="lightboxTitle" class="text-lg font-semibold"></h3>
        </div>
    </div>
</div>

<script>
// Extract YouTube ID from URL
function extractYouTubeId(url) {
    if (!url) return null;
    const regExp = /^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#&?]*).*/;
    const match = url.match(regExp);
    return (match && match[7].length === 11) ? match[7] : null;
}

// Lightbox functionality
function openLightbox(imageSrc, title) {
    const lightbox = document.getElementById('lightboxModal');
    const lightboxImage = document.getElementById('lightboxImage');
    const lightboxTitle = document.getElementById('lightboxTitle');
    
    lightboxImage.src = imageSrc;
    lightboxTitle.textContent = title;
    lightbox.classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeLightbox() {
    const lightbox = document.getElementById('lightboxModal');
    lightbox.classList.add('hidden');
    document.body.style.overflow = 'auto';
}

// Share functionality
function shareMedia() {
    const url = window.location.href;
    const title = '{{ $media->judul }}';
    const text = 'Lihat media ini: ' + title;

    if (navigator.share) {
        navigator.share({
            title: title,
            text: text,
            url: url,
        });
    } else {
        copyLink();
    }
}

function shareToFacebook() {
    const url = encodeURIComponent(window.location.href);
    window.open(`https://www.facebook.com/sharer/sharer.php?u=${url}`, '_blank', 'width=600,height=400');
}

function shareToTwitter() {
    const text = encodeURIComponent('{{ $media->judul }}');
    const url = encodeURIComponent(window.location.href);
    window.open(`https://twitter.com/intent/tweet?text=${text}&url=${url}`, '_blank', 'width=600,height=400');
}

function shareToWhatsApp() {
    const text = encodeURIComponent('Lihat "{{ $media->judul }}" di: ' + window.location.href);
    window.open(`https://wa.me/?text=${text}`, '_blank');
}

function copyLink() {
    const url = window.location.href;
    navigator.clipboard.writeText(url).then(() => {
        // Show notification
        const notification = document.createElement('div');
        notification.className = 'fixed top-4 right-4 bg-green-500 text-white px-4 py-2 rounded-lg shadow-lg z-50';
        notification.textContent = 'Link berhasil disalin!';
        document.body.appendChild(notification);
        
        setTimeout(() => {
            notification.remove();
        }, 3000);
    });
}

// Keyboard navigation
document.addEventListener('keydown', function(e) {
    const lightbox = document.getElementById('lightboxModal');
    if (!lightbox.classList.contains('hidden')) {
        if (e.key === 'Escape') {
            closeLightbox();
        }
    }
});

// Close lightbox when clicking on background
document.getElementById('lightboxModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeLightbox();
    }
});
</script>

<style>
.aspect-w-16 {
    position: relative;
}
.aspect-w-16::before {
    content: '';
    display: block;
    padding-bottom: 56.25%; /* 16:9 aspect ratio */
}
.aspect-w-16 > * {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
}

.cursor-zoom-in {
    cursor: zoom-in;
}

.sticky {
    position: sticky;
}
</style>
@endsection