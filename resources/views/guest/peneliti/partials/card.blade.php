@php
    $fotoUrl = $peneliti->foto_path ? Storage::url($peneliti->foto_path) : null;
    
    // Warna badge berdasarkan posisi
    $badgeColor = match($peneliti->posisi) {
        'Internal' => 'bg-blue-100 text-blue-800 border-blue-200',
        'Eksternal' => 'bg-green-100 text-green-800 border-green-200',
        'Kolaborator' => 'bg-purple-100 text-purple-800 border-purple-200',
        default => 'bg-gray-100 text-gray-800 border-gray-200'
    };
    
    // Konversi bidang keahlian ke array jika string
    if (is_string($peneliti->bidang_keahlian)) {
        $bidangKeahlian = array_filter(
            array_map('trim', explode(',', $peneliti->bidang_keahlian))
        );
    } else {
        $bidangKeahlian = $peneliti->bidang_keahlian ?? [];
    }
@endphp

<div class="group h-full flex flex-col bg-white border border-gray-200 rounded-xl shadow-sm hover:shadow-md transition-all duration-300 overflow-hidden">
    
    {{-- Header dengan Foto --}}
    <div class="p-6 flex flex-col items-center">
        
        {{-- Foto Profil --}}
        <div class="mb-4">
            <div class="relative">
                @if($fotoUrl)
                    <div class="w-32 h-32 mx-auto rounded-full bg-gray-100 border-4 border-white shadow-lg overflow-hidden">
                        <img src="{{ $fotoUrl }}" 
                             alt="Foto {{ trim($peneliti->gelar_depan . ' ' . $peneliti->nama . ' ' . $peneliti->gelar_belakang) }}"
                             class="w-full h-full object-cover hover:scale-105 transition-transform duration-300">
                    </div>
                @else
                    <div class="w-32 h-32 mx-auto rounded-full bg-gradient-to-br from-blue-50 to-blue-100 border-4 border-white shadow-lg flex items-center justify-center">
                        <svg class="w-12 h-12 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>
                @endif
            </div>
        </div>

        {{-- Badge Posisi --}}
        @if($peneliti->posisi)
        <div class="mb-3">
            <span class="inline-block px-3 py-1 {{ $badgeColor }} text-xs font-medium rounded-full border">
                {{ $peneliti->posisi }}
            </span>
        </div>
        @endif

        {{-- Nama Lengkap --}}
        <h3 class="font-semibold text-gray-900 text-center mb-1 line-clamp-2">
            <a href="{{ route('guest.peneliti.show', $peneliti->slug) }}" 
               class="hover:text-blue-600 transition-colors group-hover:text-blue-600">
                {{ trim($peneliti->gelar_depan . ' ' . $peneliti->nama . ' ' . $peneliti->gelar_belakang) }}
            </a>
        </h3>

        {{-- Jabatan --}}
        @if($peneliti->jabatan)
        <p class="text-gray-600 text-sm text-center mb-3 line-clamp-2">
            {{ $peneliti->jabatan }}
        </p>
        @endif

    </div>

    {{-- Bidang Keahlian --}}
    @if(count($bidangKeahlian) > 0)
    <div class="px-6 pb-4 flex-grow">
        <div class="flex flex-wrap justify-center gap-1.5">
            @foreach(array_slice($bidangKeahlian, 0, 3) as $bidang)
                <span class="inline-block px-2.5 py-1 bg-gray-50 text-gray-700 text-xs font-medium rounded-full border border-gray-200">
                    {{ trim($bidang) }}
                </span>
            @endforeach
            @if(count($bidangKeahlian) > 3)
                <span class="inline-flex items-center px-2.5 py-1 bg-gray-50 text-gray-500 text-xs font-medium rounded-full border border-gray-200">
                    +{{ count($bidangKeahlian) - 3 }}
                </span>
            @endif
        </div>
    </div>
    @endif

    {{-- Footer dengan Tombol --}}
    {{-- <div class="px-6 pb-6 pt-4 mt-auto border-t border-gray-100">
        <a href="{{ route('guest.peneliti.show', $peneliti->slug) }}" 
           class="block w-full text-center px-4 py-2.5 bg-white border border-gray-300 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-50 hover:border-gray-400 transition-all duration-200 group-hover:border-blue-300 group-hover:text-blue-700">
            <span class="flex items-center justify-center">
                Lihat Profil Lengkap
                <svg class="w-4 h-4 ml-2 opacity-0 group-hover:opacity-100 transition-opacity duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                </svg>
            </span>
        </a>
    </div> --}}

</div>