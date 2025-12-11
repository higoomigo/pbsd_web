@extends('layout-web.app')

@section('title', 'Galeri Video — Pusat Studi Pelestarian Bahasa Dan Sastra Daerah')
@section('judul_halaman', 'Galeri Video')

@section('content')
<div class="mb-20">
    <div class="mt-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- Header --}}
            <div class="text-center mb-12">
                <div class="w-20 h-20 mx-auto mb-4 bg-blue-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-video text-blue-600 text-2xl"></i>
                </div>
                <h1 class="text-3xl font-bold text-gray-900 mb-4">Galeri Video</h1>
                <p class="text-lg text-gray-600 max-w-3xl mx-auto">
                    Kumpulan video dokumentasi proses penelitian, wawancara, tutorial, 
                    dan kegiatan pelestarian bahasa daerah.
                </p>
            </div>

            {{-- Video Grid --}}
            @if($videos->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                    @foreach($videos as $video)
                        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden hover:shadow-lg transition-all duration-300">
                            {{-- Video Thumbnail --}}
                            <div class="relative aspect-video bg-gray-900 overflow-hidden">
                                @if($video->thumbnail_path)
                                    <img 
                                        src="{{ asset('storage/' . $video->thumbnail_path) }}" 
                                        alt="{{ $video->judul }}"
                                        class="w-full h-full object-cover"
                                        loading="lazy"
                                    >
                                @else
                                    <div class="w-full h-full bg-gradient-to-br from-blue-50 to-purple-50 flex items-center justify-center">
                                        <i class="fas fa-video text-gray-400 text-4xl"></i>
                                    </div>
                                @endif
                                
                                {{-- Play Button --}}
                                <div class="absolute inset-0 bg-black bg-opacity-30 flex items-center justify-center cursor-pointer" 
                                     onclick="playVideo('{{ $video->id }}')">
                                    <div class="w-16 h-16 bg-white bg-opacity-90 rounded-full flex items-center justify-center hover:bg-white transition-colors">
                                        <i class="fas fa-play text-blue-600 text-xl ml-1"></i>
                                    </div>
                                </div>

                                {{-- Album Badge --}}
                                <div class="absolute top-3 left-3 bg-black bg-opacity-60 text-white px-2 py-1 rounded text-xs">
                                    {{ Str::limit($video->album->judul, 20) }}
                                </div>

                                {{-- Duration Badge --}}
                                <div class="absolute bottom-3 right-3 bg-black bg-opacity-60 text-white px-2 py-1 rounded text-xs">
                                    <i class="fas fa-clock mr-1"></i>Video
                                </div>
                            </div>

                            {{-- Video Info --}}
                            <div class="p-4">
                                <h3 class="font-semibold text-gray-900 mb-2 line-clamp-2">
                                    {{ $video->judul }}
                                </h3>
                                
                                @if($video->keterangan)
                                    <p class="text-gray-600 text-sm mb-3 line-clamp-2">
                                        {{ $video->keterangan }}
                                    </p>
                                @endif

                                <div class="flex items-center justify-between text-sm text-gray-500">
                                    <div class="flex items-center space-x-4">
                                        @if($video->taken_at)
                                            <span class="flex items-center">
                                                <i class="fas fa-calendar mr-1"></i>
                                                {{ $video->taken_at->format('d M Y') }}
                                            </span>
                                        @endif
                                        
                                        @if($video->is_utama)
                                            <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded text-xs">
                                                <i class="fas fa-star mr-1"></i>Utama
                                            </span>
                                        @endif
                                    </div>

                                    <div class="flex items-center space-x-2">
                                        <button class="text-blue-600 hover:text-blue-800 transition-colors" 
                                                onclick="playVideo('{{ $video->id }}')">
                                            <i class="fas fa-play mr-1"></i>Putar
                                        </button>
                                        <a href="{{ asset('storage/' . $video->file_path) }}" 
                                           download 
                                           class="text-gray-600 hover:text-gray-800 transition-colors">
                                            <i class="fas fa-download"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Pagination --}}
                <div class="mt-8">
                    {{ $videos->links() }}
                </div>
            @else
                {{-- Empty State --}}
                <div class="bg-white rounded-xl border border-gray-200 p-12 text-center">
                    <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-blue-100 flex items-center justify-center">
                        <i class="fas fa-video text-blue-400 text-xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Belum ada video</h3>
                    <p class="text-gray-600 mb-4">
                        Saat ini belum ada video yang tersedia dalam galeri.
                    </p>
                    <a href="{{ route('galeri.media.index') }}" class="bg-blue-500 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-blue-600 transition-colors">
                        Lihat Semua Media
                    </a>
                </div>
            @endif

            {{-- Video Modal --}}
            <div id="videoModal" class="fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center z-50 hidden">
                <div class="bg-white rounded-lg w-full max-w-4xl mx-4">
                    <div class="flex justify-between items-center p-4 border-b">
                        <h3 id="modalTitle" class="text-lg font-semibold"></h3>
                        <button onclick="closeVideo()" class="text-gray-500 hover:text-gray-700">
                            <i class="fas fa-times text-xl"></i>
                        </button>
                    </div>
                    <div class="p-4">
                        <video id="videoPlayer" controls class="w-full rounded" style="max-height: 70vh;">
                            Your browser does not support the video tag.
                        </video>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function playVideo(videoId) {
    // In real implementation, you would fetch video URL from API
    const video = document.getElementById('videoPlayer');
    const modal = document.getElementById('videoModal');
    const title = document.getElementById('modalTitle');
    
    // For demo, we'll use a placeholder
    title.textContent = 'Memuat video...';
    modal.classList.remove('hidden');
    
    // In real app: fetch video URL and set video source
    // video.src = '/api/galeri/video/' + videoId + '/stream';
}

function closeVideo() {
    const video = document.getElementById('videoPlayer');
    const modal = document.getElementById('videoModal');
    
    video.pause();
    video.src = '';
    modal.classList.add('hidden');
}

// Close modal when clicking outside
document.getElementById('videoModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeVideo();
    }
});
</script>
@endsection