<div class="group duration-300 ease-in-out card-compact mx-auto md:mx-0
            outline outline-0 hover:outline-1 hover:outline-zinc-800 hover:outline-offset-2 p-4 bg-white">
    {{-- Cover Image --}}
    <div class="relative overflow-hidden bg-gray-100">
        @if($album->cover_path)
            <a href="{{ route('galeri.albums.show', ['slug' => $album->slug]) }}">
                <img 
                    src="{{ asset('storage/' . $album->cover_path) }}" 
                    alt="{{ $album->judul }}"
                    class="w-full h-48 object-cover transition-transform duration-300 group-hover:scale-[1.02]"
                    loading="lazy"
                >
            </a>
        @else
            <div class="w-full h-48 bg-gradient-to-br from-blue-50 to-purple-50 flex items-center justify-center">
                <i class="fas fa-images text-gray-400 text-4xl"></i>
            </div>
        @endif
        
        {{-- Media Count Badge --}}
        <div class="absolute top-3 right-3 bg-black bg-opacity-60 text-white px-2 py-1 rounded-full text-xs">
            <i class="fas fa-camera mr-1"></i>{{ $album->media_count }} Media
        </div>
    </div>

    {{-- Content --}}
    <div class="mt-4">
        <div class="w-fit mb-1">
            <a href="{{ route('galeri.albums.show', ['slug' => $album->slug]) }}" 
               class="text-lg font-semibold text-zinc-800 font-title relative leading-6
                      bg-gradient-to-r from-current to-current bg-[length:0%_2px] bg-left-bottom bg-no-repeat
                      transition-[background-size] duration-500 ease-in-out
                      group-hover:bg-[length:100%_1px] hover:text-zinc-600">
                {{ $album->judul }}
            </a>
        </div>

        @if($album->deskripsi_singkat)
            <p class="text-zinc-600 text-sm mt-2 line-clamp-2">
                {{ $album->deskripsi_singkat }}
            </p>
        @endif

        {{-- Metadata --}}
        <div class="mt-3 pt-3 border-t border-gray-100">
            <div class="flex items-center justify-between text-sm text-gray-500 mb-2">
                @if($album->kategori)
                    <span class="bg-gray-100 px-2 py-1 rounded text-xs uppercase font-semibold">
                        {{ $album->kategori }}
                    </span>
                @endif
                @if($album->tahun)
                    <span class="text-zinc-500 text-[12px]">
                        {{ $album->tahun }}
                    </span>
                @endif
            </div>

            {{-- Date & Location --}}
            <div class="text-[12px] text-zinc-500 space-y-1">
                @if($album->tanggal_mulai)
                    <div class="flex items-center">
                        <i class="fas fa-calendar mr-2 text-xs"></i>
                        <time datetime="{{ $album->tanggal_mulai->format('Y-m-d') }}">
                            {{ $album->tanggal_mulai->format('d M Y') }}
                            @if($album->tanggal_selesai && $album->tanggal_selesai != $album->tanggal_mulai)
                                - {{ $album->tanggal_selesai->format('d M Y') }}
                            @endif
                        </time>
                    </div>
                @endif
                
                @if($album->lokasi)
                    <div class="flex items-center">
                        <i class="fas fa-map-marker-alt mr-2 text-xs"></i>
                        <span class="truncate">{{ $album->lokasi }}</span>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>