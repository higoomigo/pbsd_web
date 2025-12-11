@extends('layout-web.app')

@section('title', 'Profil Peneliti — Pusat Studi Pelestarian Bahasa Dan Sastra Daerah')
@section('judul_halaman', 'Profil Peneliti')

@section('content')
<div class="mb-20">
    <div class="mt-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            {{-- Header --}}
            <div class="text-center mb-12">
                <p class="text-lg text-gray-600 max-w-3xl mx-auto">
                    Tim peneliti dan ahli bahasa yang berdedikasi dalam upaya pelestarian 
                    bahasa dan sastra daerah melalui penelitian, dokumentasi, dan pengembangan program.
                </p>
            </div>

            {{-- Filter Kategori (Opsional) --}}
            {{-- <div class="mb-8">
                <div class="flex flex-wrap justify-center gap-2">
                    <a href="#internal" class="px-4 py-2 bg-blue-100 text-blue-800 text-sm font-medium rounded-full hover:bg-blue-200 transition-colors">
                        Internal ({{ count($penelitiInternal) }})
                    </a>
                    <a href="#eksternal" class="px-4 py-2 bg-green-100 text-green-800 text-sm font-medium rounded-full hover:bg-green-200 transition-colors">
                        Eksternal ({{ count($penelitiEksternal) }})
                    </a>
                    <a href="#kolaborator" class="px-4 py-2 bg-purple-100 text-purple-800 text-sm font-medium rounded-full hover:bg-purple-200 transition-colors">
                        Kolaborator ({{ count($penelitiKolaborator) }})
                    </a>
                    @if(count($penelitiLainnya) > 0)
                    <a href="#lainnya" class="px-4 py-2 bg-gray-100 text-gray-800 text-sm font-medium rounded-full hover:bg-gray-200 transition-colors">
                        Lainnya ({{ count($penelitiLainnya) }})
                    </a>
                    @endif
                </div>
            </div> --}}

            {{-- Section: Peneliti Internal --}}
            @if(count($penelitiInternal) > 0)
            <section id="internal" class="mb-16 scroll-mt-8">
                <div class="mb-8">
                    <h2 class="font-title text-2xl md:text-3xl text-gray-900 mb-2">Peneliti Internal</h2>
                    <p class="text-gray-600">Tim peneliti utama dari Pusat Studi Pelestarian Bahasa dan Sastra Daerah</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    @foreach($penelitiInternal as $peneliti)
                        @include('guest.peneliti.partials.card', ['peneliti' => $peneliti])
                    @endforeach
                </div>
            </section>
            @endif

            {{-- Section: Peneliti Eksternal --}}
            @if(count($penelitiEksternal) > 0)
            <section id="eksternal" class="mb-16 scroll-mt-8">
                <div class="mb-8">
                    <h2 class="font-title text-2xl md:text-3xl text-gray-900 mb-2">Peneliti Eksternal</h2>
                    <p class="text-gray-600">Peneliti dari institusi mitra yang berkolaborasi dengan Pusat Studi</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    @foreach($penelitiEksternal as $peneliti)
                        @include('guest.peneliti.partials.card', ['peneliti' => $peneliti])
                    @endforeach
                </div>
            </section>
            @endif

            {{-- Section: Kolaborator --}}
            @if(count($penelitiKolaborator) > 0)
            <section id="kolaborator" class="mb-16 scroll-mt-8">
                <div class="mb-8">
                    <h2 class="font-title text-2xl md:text-3xl text-gray-900 mb-2">Kolaborator</h2>
                    <p class="text-gray-600">Ahli dan praktisi yang berkontribusi dalam program penelitian</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    @foreach($penelitiKolaborator as $peneliti)
                        @include('guest.peneliti.partials.card', ['peneliti' => $peneliti])
                    @endforeach
                </div>
            </section>
            @endif

            {{-- Section: Lainnya --}}
            @if(count($penelitiLainnya) > 0)
            <section id="lainnya" class="mb-16 scroll-mt-8">
                <div class="mb-8">
                    <h2 class="font-title text-2xl md:text-3xl text-gray-900 mb-2">Peneliti Lainnya</h2>
                    <p class="text-gray-600">Tim peneliti dengan peran khusus lainnya</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    @foreach($penelitiLainnya as $peneliti)
                        @include('guest.peneliti.partials.card', ['peneliti' => $peneliti])
                    @endforeach
                </div>
            </section>
            @endif

            {{-- Empty State --}}
            @if(count($penelitiInternal) == 0 && count($penelitiEksternal) == 0 && count($penelitiKolaborator) == 0 && count($penelitiLainnya) == 0)
            <div class="bg-white rounded-xl border border-gray-200 p-12 text-center">
                <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-gray-100 flex items-center justify-center">
                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Belum ada peneliti</h3>
                <p class="text-gray-600">
                    Saat ini belum ada profil peneliti yang tersedia.
                </p>
            </div>
            @endif

        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
/* Pastikan semua card memiliki tinggi yang sama */
.grid > * {
    display: flex;
    flex-direction: column;
}

/* Animasi smooth scroll */
html {
    scroll-behavior: smooth;
}

/* Responsive grid adjustments */
@media (max-width: 640px) {
    .grid {
        grid-template-columns: 1fr;
        gap: 1rem;
    }
}

@media (min-width: 641px) and (max-width: 768px) {
    .grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 1rem;
    }
}

@media (min-width: 769px) and (max-width: 1024px) {
    .grid {
        grid-template-columns: repeat(3, 1fr);
        gap: 1.25rem;
    }
}

@media (min-width: 1025px) {
    .grid {
        grid-template-columns: repeat(4, 1fr);
        gap: 1.5rem;
    }
}
</style>
@endpush