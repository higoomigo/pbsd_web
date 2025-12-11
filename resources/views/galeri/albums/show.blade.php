@extends('layout-web.app')

@section('title', 'Galeri Album')
@section('judul_halaman', $album->judul)

@section('content')

<div class="w-full px-4 sm:px-6 lg:px-28">
    {{-- Header --}}
    <nav class="flex items-center py-4 text-sm text-gray-600">
        <a href="{{ route('galeri.albums.beranda') }}" 
           class="hover:text-blue-600 transition-colors inline-flex items-center">
            <i class="fas fa-chevron-left mr-2"></i>
            Galeri
        </a>
        <span class="mx-2">/</span>
        <span class="font-medium text-gray-900">{{ $album->judul }}</span>
    </nav>

    {{-- Album Info --}}
    <div class="mb-8">
        <div class="flex flex-wrap items-center gap-2 mb-2">
            <span class="px-3 py-1 bg-blue-100 text-blue-800 text-sm">
                {{ $album->kategori }}
            </span>
            @if($album->tahun)
            <span class="px-3 py-1 bg-gray-100 text-gray-700 text-sm">
                {{ $album->tahun }}
            </span>
            @endif
        </div>
        
        @if($album->deskripsi)
        <p class="text-gray-600">{{ $album->deskripsi }}</p>
        @endif
    </div>

    {{-- Tab Navigation --}}
    <div class="border-b border-gray-200 mb-8">
        <div class="flex overflow-x-auto">
            {{-- Foto Tab --}}
            <a href="{{ route('galeri.albums.show', ['slug' => $album->slug, 'tab' => 'foto']  ) }}"
               class="flex-shrink-0 px-6 py-3 border-b-2 font-medium text-sm transition-colors
                      {{ $activeTab === 'foto' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700' }}">
                <i class="fas fa-camera mr-2"></i>
                Foto 
                <span class="ml-1 px-1.5 py-0.5 text-xs bg-gray-100 rounded">
                    {{ $fotos->count() }}
                </span>
            </a>

            {{-- Video Tab --}}
            <a href="{{ route('galeri.albums.show', ['slug' => $album->slug, 'tab' => 'video']) }}"
               class="flex-shrink-0 px-6 py-3 border-b-2 font-medium text-sm transition-colors
                      {{ $activeTab === 'video' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700' }}">
                <i class="fas fa-video mr-2"></i>
                Video 
                <span class="ml-1 px-1.5 py-0.5 text-xs bg-gray-100 rounded">
                    {{ $videos->count() }}
                </span>
            </a>

            {{-- YouTube Tab --}}
            <a href="{{ route('galeri.albums.show', ['slug' => $album->slug, 'tab' => 'youtube']) }}"
               class="flex-shrink-0 px-6 py-3 border-b-2 font-medium text-sm transition-colors
                      {{ $activeTab === 'youtube' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700' }}">
                <i class="fab fa-youtube mr-2"></i>
                YouTube 
                <span class="ml-1 px-1.5 py-0.5 text-xs bg-gray-100 rounded">
                    {{ $youtubes->count() }}
                </span>
            </a>
        </div>
    </div>

    {{-- Tab Content --}}
    <div>
        {{-- FOTO TAB CONTENT --}}
        @if($activeTab === 'foto' && $fotos->count() > 0)
        <section id="foto-tab">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center">
                    <h2 class="text-xl font-bold text-gray-900">Foto</h2>
                    <span class="ml-3 px-2 py-1 bg-gray-100 text-gray-700 text-sm">
                        {{ $fotos->count() }} foto
                    </span>
                </div>
                <div class="flex items-center gap-2">
                    <button onclick="prevPhoto()" 
                            class="p-2 hover:bg-gray-100 transition-colors"
                            title="Foto sebelumnya">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <span id="photo-counter" class="text-sm text-gray-600 min-w-[60px] text-center">
                        1 / {{ $fotos->count() }}
                    </span>
                    <button onclick="nextPhoto()" 
                            class="p-2 hover:bg-gray-100 transition-colors"
                            title="Foto berikutnya">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
            </div>

            {{-- Carousel Container --}}
            <div class="relative">
                {{-- Carousel Wrapper --}}
                <div class="overflow-hidden">
                    <div id="photo-carousel" class="flex transition-transform duration-300 ease-in-out">
                        @foreach($fotos as $index => $media)
                        <div class="w-full flex-shrink-0">
                            <div class="px-0 py-0">
                                {{-- Image Container Fixed Size --}}
                                <div class="flex items-center justify-center" 
                                     style="height: 500px;">
                                    @if($media->file_path)
                                    <img 
                                        src="{{ asset('storage/' . $media->file_path) }}" 
                                        alt="{{ $media->judul }}"
                                        class="max-w-full max-h-[480px] object-contain mx-auto"
                                        id="photo-{{ $index }}"
                                    >
                                    @else
                                    <div class="w-full h-full flex items-center justify-center">
                                        <i class="fas fa-camera text-gray-400 text-5xl"></i>
                                    </div>
                                    @endif
                                </div>
                                
                                {{-- Photo Info --}}
                                <div class="p-4 border-t border-gray-200 bg-white">
                                    <h3 class="font-semibold text-lg text-gray-900 mb-2">
                                        {{ $media->judul }}
                                    </h3>
                                    @if($media->keterangan)
                                    <p class="text-gray-600 mb-3">{{ $media->keterangan }}</p>
                                    @endif
                                    <div class="flex items-center justify-between text-sm text-gray-500">
                                        <div>
                                            @if($media->created_at)
                                            <span>{{ $media->created_at->format('d F Y') }}</span>
                                            @endif
                                        </div>
                                        <div class="flex items-center gap-3">
                                            @if($media->file_path)
                                            <a href="{{ asset('storage/' . $media->file_path) }}" 
                                               download
                                               class="inline-flex items-center text-blue-600 hover:text-blue-800">
                                                <i class="fas fa-download mr-1"></i>
                                                Download
                                            </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Photo Thumbnails --}}
            @if($fotos->count() > 1)
            <div class="mt-4">
                <div class="flex overflow-x-auto gap-2 pb-2">
                    @foreach($fotos as $index => $media)
                    <button onclick="goToPhoto({{ $index }})"
                            class="thumbnail-btn flex-shrink-0 {{ $index === 0 ? 'border-2 border-blue-500' : 'border border-gray-300' }}"
                            data-index="{{ $index }}">
                        <div class="w-16 h-16 overflow-hidden bg-gray-200">
                            @if($media->file_path)
                            <img 
                                src="{{ asset('storage/' . $media->file_path) }}" 
                                alt="{{ $media->judul }}"
                                class="w-full h-full object-cover"
                            >
                            @else
                            <div class="w-full h-full flex items-center justify-center">
                                <i class="fas fa-camera text-gray-400"></i>
                            </div>
                            @endif
                        </div>
                    </button>
                    @endforeach
                </div>
            </div>
            @endif
        </section>

        {{-- Empty State for Foto --}}
        @elseif($activeTab === 'foto' && $fotos->count() == 0)
        <div class="text-center py-12 bg-gray-50">
            <div class="w-16 h-16 mx-auto mb-4 bg-gray-100 flex items-center justify-center">
                <i class="fas fa-camera text-gray-400 text-2xl"></i>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 mb-2">Belum ada foto</h3>
            <p class="text-gray-600">Album ini belum memiliki koleksi foto</p>
        </div>
        @endif

        {{-- VIDEO TAB CONTENT --}}
        @if($activeTab === 'video' && $videos->count() > 0)
        <section id="video-tab">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center">
                    <h2 class="text-xl font-bold text-gray-900">Video</h2>
                    <span class="ml-3 px-2 py-1 bg-gray-100 text-gray-700 text-sm">
                        {{ $videos->count() }} video
                    </span>
                </div>
                <div class="flex items-center gap-2">
                    <button onclick="prevVideo()" 
                            class="p-2 hover:bg-gray-100 transition-colors"
                            title="Video sebelumnya">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <span id="video-counter" class="text-sm text-gray-600 min-w-[60px] text-center">
                        1 / {{ $videos->count() }}
                    </span>
                    <button onclick="nextVideo()" 
                            class="p-2 hover:bg-gray-100 transition-colors"
                            title="Video berikutnya">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
            </div>

            {{-- Video Carousel Container --}}
            <div class="relative">
                {{-- Carousel Wrapper --}}
                <div class="overflow-hidden">
                    <div id="video-carousel" class="flex transition-transform duration-300 ease-in-out">
                        @foreach($videos as $index => $media)
                        <div class="w-full flex-shrink-0">
                            <div class="px-0 py-0">
                                {{-- Video Player --}}
                                <div class="bg-black" style="height: 500px;">
                                    <video 
                                        id="video-{{ $media->id }}"
                                        class="w-full h-full"
                                        poster="{{ $media->thumbnail_path ? asset('storage/' . $media->thumbnail_path) : '' }}"
                                    >
                                        <source src="{{ asset('storage/' . $media->file_path) }}" type="video/mp4">
                                        Browser Anda tidak mendukung pemutar video.
                                    </video>
                                    
                                    {{-- Simple Controls Overlay --}}
                                    <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/80 to-transparent 
                                                opacity-0 hover:opacity-100 transition-opacity duration-300">
                                        <div class="p-3 flex items-center justify-between">
                                            <div class="flex items-center gap-2">
                                                <button onclick="togglePlayPause('{{ $media->id }}')" 
                                                        class="w-8 h-8 bg-white/20 hover:bg-white/30 flex items-center 
                                                               justify-center text-white">
                                                    <i class="fas fa-play text-xs"></i>
                                                </button>
                                                <span class="text-white text-xs" id="time-{{ $media->id }}">
                                                    0:00 / 0:00
                                                </span>
                                            </div>
                                            
                                            <div class="flex items-center gap-2">
                                                <button onclick="toggleVideoFullscreen('{{ $media->id }}')"
                                                        class="w-8 h-8 bg-white/20 hover:bg-white/30 flex items-center 
                                                               justify-center text-white">
                                                    <i class="fas fa-expand text-xs"></i>
                                                </button>
                                            </div>
                                        </div>
                                        
                                        {{-- Progress Bar --}}
                                        <div class="px-3 pb-2">
                                            <input type="range" 
                                                   oninput="seekVideo('{{ $media->id }}', this.value)"
                                                   class="w-full h-1 bg-white/30 appearance-none cursor-pointer 
                                                          [&::-webkit-slider-thumb]:appearance-none [&::-webkit-slider-thumb]:h-3 
                                                          [&::-webkit-slider-thumb]:w-3 [&::-webkit-slider-thumb]:rounded-full 
                                                          [&::-webkit-slider-thumb]:bg-white"
                                                   min="0" max="100" value="0">
                                        </div>
                                    </div>
                                </div>
                                
                                {{-- Video Info --}}
                                <div class="p-4 border-t border-gray-200 bg-white">
                                    <h3 class="font-semibold text-lg text-gray-900 mb-2">
                                        {{ $media->judul }}
                                    </h3>
                                    @if($media->keterangan)
                                    <p class="text-gray-600 mb-3">{{ $media->keterangan }}</p>
                                    @endif
                                    <div class="flex items-center justify-between text-sm text-gray-500">
                                        <div>
                                            @if($media->created_at)
                                            <span>{{ $media->created_at->format('d F Y') }}</span>
                                            @endif
                                            <span class="ml-4" id="duration-{{ $media->id }}">--:--</span>
                                        </div>
                                        <div class="flex items-center gap-3">
                                            <a href="{{ asset('storage/' . $media->file_path) }}" 
                                               download
                                               class="inline-flex items-center text-blue-600 hover:text-blue-800">
                                                <i class="fas fa-download mr-1"></i>
                                                Download
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Video Thumbnails --}}
            @if($videos->count() > 1)
            <div class="mt-4">
                <div class="flex overflow-x-auto gap-2 pb-2">
                    @foreach($videos as $index => $media)
                    <button onclick="goToVideo({{ $index }})"
                            class="video-thumbnail flex-shrink-0 {{ $index === 0 ? 'border-2 border-blue-500' : 'border border-gray-300' }}"
                            data-index="{{ $index }}">
                        <div class="w-24 h-16 overflow-hidden bg-black relative">
                            @if($media->thumbnail_path)
                            <img 
                                src="{{ asset('storage/' . $media->thumbnail_path) }}" 
                                alt="{{ $media->judul }}"
                                class="w-full h-full object-cover"
                            >
                            @else
                            <div class="w-full h-full flex items-center justify-center">
                                <i class="fas fa-video text-gray-400"></i>
                            </div>
                            @endif
                            <div class="absolute inset-0 bg-black/40 flex items-center justify-center">
                                <i class="fas fa-play text-white text-xs"></i>
                            </div>
                        </div>
                    </button>
                    @endforeach
                </div>
            </div>
            @endif
        </section>

        {{-- Empty State for Video --}}
        @elseif($activeTab === 'video' && $videos->count() == 0)
        <div class="text-center py-12 bg-gray-50">
            <div class="w-16 h-16 mx-auto mb-4 bg-gray-100 flex items-center justify-center">
                <i class="fas fa-video text-gray-400 text-2xl"></i>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 mb-2">Belum ada video</h3>
            <p class="text-gray-600">Album ini belum memiliki koleksi video</p>
        </div>
        @endif

        {{-- YOUTUBE TAB CONTENT --}}
        @if($activeTab === 'youtube' && $youtubes->count() > 0)
        <section id="youtube-tab">
            <div class="mb-4">
                <h2 class="text-xl font-bold text-gray-900 mb-2">YouTube</h2>
                <div class="flex items-center">
                    <span class="px-2 py-1 bg-gray-100 text-gray-700 text-sm">
                        {{ $youtubes->count() }} video
                    </span>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @foreach($youtubes as $media)
                <div class="bg-white overflow-hidden">
                    <div class="aspect-video bg-gray-900">
                        <iframe 
                            src="https://www.youtube.com/embed/{{ $media->youtube_id }}" 
                            title="{{ $media->judul }}"
                            frameborder="0" 
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                            allowfullscreen
                            class="w-full h-full"
                        ></iframe>
                    </div>
                    
                    <div class="p-4">
                        <h3 class="font-medium text-gray-900 mb-2">{{ $media->judul }}</h3>
                        
                        <div class="flex items-center justify-between mt-4">
                            <a href="{{ $media->youtube_url }}" 
                               target="_blank"
                               class="inline-flex items-center px-3 py-1.5 bg-red-50 text-red-700 
                                     hover:bg-red-100 transition-colors text-sm">
                                <i class="fab fa-youtube mr-1.5"></i>
                                Tonton di YouTube
                            </a>
                            
                            @if($media->created_at)
                            <span class="text-sm text-gray-500">{{ $media->created_at->format('d M Y') }}</span>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </section>

        {{-- Empty State for YouTube --}}
        @elseif($activeTab === 'youtube' && $youtubes->count() == 0)
        <div class="text-center py-12 bg-gray-50">
            <div class="w-16 h-16 mx-auto mb-4 bg-gray-100 flex items-center justify-center">
                <i class="fab fa-youtube text-gray-400 text-2xl"></i>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 mb-2">Belum ada konten YouTube</h3>
            <p class="text-gray-600">Album ini belum memiliki koleksi YouTube</p>
        </div>
        @endif

        {{-- Global Empty State (jika semua tab kosong) --}}
        @if($fotos->count() == 0 && $videos->count() == 0 && $youtubes->count() == 0)
        <div class="text-center py-12 bg-gray-50">
            <div class="w-16 h-16 mx-auto mb-4 bg-gray-100 flex items-center justify-center">
                <i class="fas fa-images text-gray-400 text-2xl"></i>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 mb-2">Belum ada media</h3>
            <p class="text-gray-600">Album ini belum memiliki konten</p>
        </div>
        @endif
    </div>
</div>

{{-- Styles --}}
<style>
    .aspect-video {
        aspect-ratio: 16 / 9;
    }
    
    .overflow-x-auto {
        scrollbar-width: none;
        -ms-overflow-style: none;
    }
    
    .overflow-x-auto::-webkit-scrollbar {
        display: none;
    }
    
    .transition-transform {
        transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
    }
</style>

{{-- JavaScript --}}
<script>
// ========== FOTO CAROUSEL ==========
let currentPhotoIndex = 0;
const totalPhotos = {{ $fotos->count() }};
const photoCarousel = document.getElementById('photo-carousel');
const photoCounter = document.getElementById('photo-counter');

function updatePhotoCarousel() {
    if (photoCarousel) {
        photoCarousel.style.transform = `translateX(-${currentPhotoIndex * 100}%)`;
        photoCounter.textContent = `${currentPhotoIndex + 1} / ${totalPhotos}`;
        
        // Update thumbnail active state
        document.querySelectorAll('.thumbnail-btn').forEach((btn, index) => {
            if (index === currentPhotoIndex) {
                btn.classList.add('border-2', 'border-blue-500');
                btn.classList.remove('border', 'border-gray-300');
            } else {
                btn.classList.remove('border-2', 'border-blue-500');
                btn.classList.add('border', 'border-gray-300');
            }
        });
        
        // Scroll thumbnail into view
        const activeThumbnail = document.querySelector(`.thumbnail-btn[data-index="${currentPhotoIndex}"]`);
        if (activeThumbnail) {
            activeThumbnail.scrollIntoView({
                behavior: 'smooth',
                block: 'nearest',
                inline: 'center'
            });
        }
    }
}

function nextPhoto() {
    if (currentPhotoIndex < totalPhotos - 1) {
        currentPhotoIndex++;
        updatePhotoCarousel();
    }
}

function prevPhoto() {
    if (currentPhotoIndex > 0) {
        currentPhotoIndex--;
        updatePhotoCarousel();
    }
}

function goToPhoto(index) {
    currentPhotoIndex = index;
    updatePhotoCarousel();
}

// ========== VIDEO CAROUSEL ==========
let currentVideoIndex = 0;
const totalVideos = {{ $videos->count() }};
const videoCarousel = document.getElementById('video-carousel');
const videoCounter = document.getElementById('video-counter');

// Pause all other videos when switching
function pauseAllVideos() {
    @foreach($videos as $media)
    const video = document.getElementById('video-{{ $media->id }}');
    if (video) {
        video.pause();
        updatePlayButton('{{ $media->id }}');
    }
    @endforeach
}

// Video Carousel Navigation
function updateVideoCarousel() {
    if (videoCarousel) {
        videoCarousel.style.transform = `translateX(-${currentVideoIndex * 100}%)`;
        videoCounter.textContent = `${currentVideoIndex + 1} / ${totalVideos}`;
        
        // Update thumbnail active state
        document.querySelectorAll('.video-thumbnail').forEach((btn, index) => {
            if (index === currentVideoIndex) {
                btn.classList.add('border-2', 'border-blue-500');
                btn.classList.remove('border', 'border-gray-300');
            } else {
                btn.classList.remove('border-2', 'border-blue-500');
                btn.classList.add('border', 'border-gray-300');
            }
        });
        
        // Scroll thumbnail into view
        const activeThumbnail = document.querySelector(`.video-thumbnail[data-index="${currentVideoIndex}"]`);
        if (activeThumbnail) {
            activeThumbnail.scrollIntoView({
                behavior: 'smooth',
                block: 'nearest',
                inline: 'center'
            });
        }
    }
}

function nextVideo() {
    if (currentVideoIndex < totalVideos - 1) {
        pauseAllVideos();
        currentVideoIndex++;
        updateVideoCarousel();
    }
}

function prevVideo() {
    if (currentVideoIndex > 0) {
        pauseAllVideos();
        currentVideoIndex--;
        updateVideoCarousel();
    }
}

function goToVideo(index) {
    pauseAllVideos();
    currentVideoIndex = index;
    updateVideoCarousel();
}

// Video Player Functions
function initializeVideoPlayer(videoId) {
    const video = document.getElementById(`video-${videoId}`);
    if (!video) return;
    
    video.addEventListener('loadedmetadata', function() {
        const duration = video.duration;
        if (duration) {
            const minutes = Math.floor(duration / 60);
            const seconds = Math.floor(duration % 60);
            document.getElementById(`duration-${videoId}`).textContent = 
                `${minutes}:${seconds.toString().padStart(2, '0')}`;
        }
    });
    
    video.addEventListener('timeupdate', function() {
        updateVideoTime(videoId);
    });
    
    video.addEventListener('ended', function() {
        updatePlayButton(videoId);
    });
}

function togglePlayPause(videoId) {
    const video = document.getElementById(`video-${videoId}`);
    if (!video) return;
    
    if (video.paused) {
        video.play();
    } else {
        video.pause();
    }
    
    updatePlayButton(videoId);
}

function updatePlayButton(videoId) {
    const video = document.getElementById(`video-${videoId}`);
    if (!video) return;
    
    const playButton = document.querySelector(`[onclick="togglePlayPause('${videoId}')"]`);
    if (playButton) {
        const icon = playButton.querySelector('i');
        if (icon) {
            icon.className = video.paused ? 'fas fa-play text-xs' : 'fas fa-pause text-xs';
        }
    }
}

function updateVideoTime(videoId) {
    const video = document.getElementById(`video-${videoId}`);
    if (!video) return;
    
    const current = video.currentTime;
    const duration = video.duration || 0;
    
    const formatTime = (time) => {
        const minutes = Math.floor(time / 60);
        const seconds = Math.floor(time % 60);
        return `${minutes}:${seconds.toString().padStart(2, '0')}`;
    };
    
    const timeDisplay = document.getElementById(`time-${videoId}`);
    if (timeDisplay) {
        timeDisplay.textContent = `${formatTime(current)} / ${formatTime(duration)}`;
    }
    
    const progressBar = document.querySelector(`[oninput="seekVideo('${videoId}', this.value)"]`);
    if (progressBar && duration > 0) {
        const progress = (current / duration) * 100;
        progressBar.value = progress;
    }
}

function seekVideo(videoId, value) {
    const video = document.getElementById(`video-${videoId}`);
    if (!video || !video.duration) return;
    
    const seekTime = (value / 100) * video.duration;
    video.currentTime = seekTime;
}

function toggleVideoFullscreen(videoId) {
    const video = document.getElementById(`video-${videoId}`);
    if (!video) return;
    
    if (!document.fullscreenElement) {
        if (video.requestFullscreen) {
            video.requestFullscreen();
        } else if (video.webkitRequestFullscreen) {
            video.webkitRequestFullscreen();
        } else if (video.msRequestFullscreen) {
            video.msRequestFullscreen();
        }
    } else {
        if (document.exitFullscreen) {
            document.exitFullscreen();
        } else if (document.webkitExitFullscreen) {
            document.webkitExitFullscreen();
        } else if (document.msExitFullscreen) {
            document.msExitFullscreen();
        }
    }
}

// ========== KEYBOARD NAVIGATION ==========
document.addEventListener('keydown', (e) => {
    // Check which tab is active
    const activeTab = '{{ $activeTab }}';
    
    if (activeTab === 'foto' && totalPhotos > 0) {
        if (e.key === 'ArrowLeft') {
            e.preventDefault();
            prevPhoto();
        } else if (e.key === 'ArrowRight') {
            e.preventDefault();
            nextPhoto();
        }
    } else if (activeTab === 'video' && totalVideos > 0) {
        if (e.key === 'ArrowLeft' && e.target.tagName !== 'VIDEO') {
            e.preventDefault();
            prevVideo();
        } else if (e.key === 'ArrowRight' && e.target.tagName !== 'VIDEO') {
            e.preventDefault();
            nextVideo();
        }
    }
});

// ========== SWIPE FUNCTIONALITY ==========
// Photo swipe
let photoTouchStartX = 0;
let photoTouchEndX = 0;

photoCarousel?.addEventListener('touchstart', (e) => {
    photoTouchStartX = e.changedTouches[0].screenX;
});

photoCarousel?.addEventListener('touchend', (e) => {
    photoTouchEndX = e.changedTouches[0].screenX;
    handlePhotoSwipe();
});

function handlePhotoSwipe() {
    const swipeThreshold = 50;
    const diff = photoTouchStartX - photoTouchEndX;

    if (Math.abs(diff) > swipeThreshold) {
        if (diff > 0) {
            nextPhoto();
        } else {
            prevPhoto();
        }
    }
}

// Video swipe
let videoTouchStartX = 0;
let videoTouchEndX = 0;

videoCarousel?.addEventListener('touchstart', (e) => {
    videoTouchStartX = e.changedTouches[0].screenX;
});

videoCarousel?.addEventListener('touchend', (e) => {
    videoTouchEndX = e.changedTouches[0].screenX;
    handleVideoSwipe();
});

function handleVideoSwipe() {
    const swipeThreshold = 50;
    const diff = videoTouchStartX - videoTouchEndX;

    if (Math.abs(diff) > swipeThreshold) {
        if (diff > 0) {
            nextVideo();
        } else {
            prevVideo();
        }
    }
}

// ========== INITIALIZE ==========
document.addEventListener('DOMContentLoaded', () => {
    // Initialize photo carousel
    if (totalPhotos > 0) {
        updatePhotoCarousel();
    }
    
    // Initialize video carousel and players
    if (totalVideos > 0) {
        updateVideoCarousel();
        
        @foreach($videos as $media)
        initializeVideoPlayer('{{ $media->id }}');
        @endforeach
    }
    
    // Scroll to active tab on page load
    const activeTab = '{{ $activeTab }}';
    if (activeTab) {
        const tabElement = document.getElementById(`${activeTab}-tab`);
        if (tabElement) {
            setTimeout(() => {
                tabElement.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }, 300);
        }
    }
});
</script>

@endsection