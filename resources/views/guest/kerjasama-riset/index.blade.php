@extends('layout-web.app')

@section('title', 'Kerjasama Riset — Pusat Studi Pelestarian Bahasa Dan Sastra Daerah')
@section('judul_halaman', 'Kerjasama Riset')

@section('content')
<div class="py-8">
    <div class="container mx-auto px-4 sm:px-6 lg:px-36">

        {{-- Header + Deskripsi --}}
        <div class="mb-8">
            <div class="mx-auto text-left mb-6">
                <p class="text-zinc-600 leading-relaxed">
                    Pusat Studi Pelestarian Bahasa Dan Sastra Daerah aktif menjalin kerjasama riset 
                    dengan berbagai institusi, universitas, dan lembaga penelitian untuk mengembangkan 
                    ilmu pengetahuan dan melestarikan warisan budaya daerah. Temukan informasi tentang 
                    kolaborasi penelitian, MoU, dan partnership yang telah kami lakukan.
                </p>
            </div>

            {{-- Filter Section --}}
            <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-3 mb-4">
                <div class="text-sm text-zinc-600">
                    <p>Filter berdasarkan kategori dan kata kunci:</p>
                </div>
                <form id="kerjasama-filter" class="w-full md:w-auto flex flex-col sm:flex-row gap-2" onsubmit="return false">
                    <input
                        id="q" type="text" value="{{ $q }}"
                        placeholder="Cari judul, institusi mitra…"
                        class="w-full sm:w-64 border border-zinc-300 px-2.5 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 rounded"
                    />
                    <select
                        id="kategori"
                        class="w-full sm:w-48 border border-zinc-300 px-2.5 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 rounded"
                    >
                        <option value="">Semua Jenis Kerjasama</option>
                        @foreach($kategoriList as $opt)
                            <option value="{{ $opt }}" @selected($kategori===$opt)>{{ $opt }}</option>
                        @endforeach
                    </select>
                    <button id="resetFilter" class="inline-flex items-center justify-center px-3 py-1.5 bg-zinc-100 text-zinc-700 text-sm hover:bg-zinc-200 rounded" type="button">
                        Reset
                    </button>
                </form>
            </div>

            {{-- Info jumlah hasil --}}
            <p id="result-info" class="text-xs text-zinc-500 mb-2"></p>
        </div>

        {{-- Highlight Partnerships --}}
        <div class="bg-gradient-to-r from-indigo-50 to-blue-50 border border-indigo-100 rounded-xl p-6 mb-8">
            <div class="flex flex-col md:flex-row items-center justify-between">
                <div class="mb-4 md:mb-0">
                    <h3 class="text-lg font-semibold text-indigo-900 mb-2">Ingin Bermitra dengan Kami?</h3>
                    <p class="text-indigo-800 text-sm">
                        Pusat Studi terbuka untuk berbagai bentuk kerjasama riset dan kolaborasi akademik.
                    </p>
                </div>
                <a href="{{ route('welcome') . '#kontak' }}" 
                   class="inline-flex items-center px-5 py-2.5 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 transition-colors">
                    Ajukan Proposal Kerjasama
                </a>
            </div>
        </div>

        {{-- Kerjasama Riset List --}}
        @if($berita->count() > 0)
            <ul id="kerjasama-list" class="space-y-4">
                @foreach($berita as $b)
                    @php
                        $thumb   = $b->thumbnail_path ? Storage::url($b->thumbnail_path) : asset('images/placeholder-4x3.png');
                        $tglIso  = optional($b->published_at)?->format('Y-m-d');
                        $tglDisp = optional($b->published_at)->translatedFormat('d M Y');
                        $ringkas = $b->ringkasan ?: '—';
                        $tagsStr = trim((string)$b->tag);
                        $author  = optional($b->author)->name;
                        $href    = route('guest.kerjasama-riset.show', $b->slug);
                        $kat     = $b->kategori ?? 'Kerjasama Riset';
                        
                        // Warna berdasarkan kategori
                        $colorClasses = [
                            'Kerjasama Riset' => 'bg-blue-100 text-blue-800',
                            'Kolaborasi Penelitian' => 'bg-indigo-100 text-indigo-800',
                            'MoU Riset' => 'bg-purple-100 text-purple-800',
                            'Partnership' => 'bg-cyan-100 text-cyan-800',
                            'Proyek Bersama' => 'bg-teal-100 text-teal-800',
                            'Jaringan Riset' => 'bg-green-100 text-green-800',
                        ];
                        $badgeColor = $colorClasses[$kat] ?? 'bg-gray-100 text-gray-800';
                        
                        // Extract partner institutions from tags
                        $partners = [];
                        if ($tagsStr) {
                            $tags = collect(explode(',', $tagsStr))->map(fn($t) => trim($t));
                            // Look for university/institution names
                            $institutionKeywords = ['universitas', 'university', 'institut', 'institute', 'lembaga', 'pusat studi', 'kampus'];
                            $partners = $tags->filter(function($tag) use ($institutionKeywords) {
                                foreach ($institutionKeywords as $keyword) {
                                    if (stripos($tag, $keyword) !== false) {
                                        return true;
                                    }
                                }
                                return false;
                            })->take(2);
                        }
                    @endphp

                    <li
                        class="kerjasama-item bg-white rounded-lg shadow-sm border border-zinc-200 overflow-hidden hover:shadow-md transition-shadow"
                        data-title="{{ Str::lower($b->judul) }}"
                        data-tags="{{ Str::lower($tagsStr) }}"
                        data-kategori="{{ Str::lower($kat) }}"
                        data-date="{{ $tglIso }}"
                    >
                        <a href="{{ $href }}"
                           class="group flex flex-col md:flex-row gap-4 items-start p-4 hover:bg-zinc-50 focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500 transition">
                            
                            {{-- Gambar --}}
                            <div class="w-full md:w-48 flex-shrink-0">
                                <div class="relative w-full h-40 md:h-full overflow-hidden rounded-lg border border-zinc-200 bg-zinc-100">
                                    <img src="{{ $thumb }}" alt="{{ $b->judul }}" 
                                         class="absolute inset-0 w-full h-full object-cover transition-transform duration-300 group-hover:scale-[1.02]" 
                                         loading="lazy">
                                    <div class="absolute top-2 left-2">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium {{ $badgeColor }}">
                                            {{ $kat }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            {{-- Konten --}}
                            <div class="flex-1 min-w-0">
                                <div class="flex flex-col h-full">
                                    {{-- Header --}}
                                    <div class="mb-2">
                                        <h2 class="text-xl font-semibold text-zinc-900 group-hover:text-indigo-700 line-clamp-2">
                                            {{ $b->judul }}
                                        </h2>
                                        <div class="flex flex-wrap items-center gap-2 mt-2 text-sm text-zinc-500">
                                            <div class="flex items-center">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                </svg>
                                                <time datetime="{{ $tglIso }}">{{ $tglDisp ?: '—' }}</time>
                                            </div>
                                            @if($author)
                                                <div class="flex items-center">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                                    </svg>
                                                    <span>{{ $author }}</span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    {{-- Partner Institutions --}}
                                    @if($partners->isNotEmpty())
                                        <div class="mb-3">
                                            <div class="flex items-center text-sm text-zinc-600 mb-1">
                                                <svg class="w-4 h-4 mr-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                                </svg>
                                                <span class="font-medium">Mitra Kerjasama:</span>
                                            </div>
                                            <div class="flex flex-wrap gap-2">
                                                @foreach($partners as $partner)
                                                    <span class="inline-flex items-center px-2 py-1 rounded bg-blue-50 text-blue-700 text-xs">
                                                        {{ $partner }}
                                                    </span>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif

                                    {{-- Ringkasan --}}
                                    @if($ringkas)
                                        <div class="mb-4 flex-grow">
                                            <p class="text-zinc-600 leading-relaxed line-clamp-3">{{ $ringkas }}</p>
                                        </div>
                                    @endif

                                    {{-- Tags --}}
                                    @if(!empty($tagsStr))
                                        @php
                                            $tags = collect(explode(',', $tagsStr))->map(fn($t)=>trim($t))->filter()->take(4);
                                        @endphp
                                        @if($tags->isNotEmpty())
                                            <div class="flex flex-wrap gap-1.5">
                                                @foreach($tags as $t)
                                                    <span class="inline-flex items-center px-2 py-0.5 rounded bg-zinc-100 text-zinc-700 text-xs">
                                                        #{{ $t }}
                                                    </span>
                                                @endforeach
                                            </div>
                                        @endif
                                    @endif

                                    {{-- Read More --}}
                                    <div class="mt-4 pt-4 border-t border-zinc-100">
                                        <span class="inline-flex items-center text-sm font-medium text-indigo-600 group-hover:text-indigo-800">
                                            Lihat Detail Kerjasama
                                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                                            </svg>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </li>
                @endforeach
            </ul>
        @else
            {{-- Empty State --}}
            <div class="text-center py-12">
                <svg class="w-16 h-16 text-zinc-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
                <h3 class="text-lg font-medium text-zinc-900 mb-2">Belum Ada Kerjasama Riset</h3>
                <p class="text-zinc-600 max-w-md mx-auto">
                    Saat ini belum ada informasi kerjasama riset yang tersedia.
                    Hubungi kami jika Anda tertarik untuk bermitra dalam penelitian.
                </p>
            </div>
        @endif

        {{-- Pagination --}}
        @if($berita->hasPages())
            <div class="mt-8 pt-6 border-t border-zinc-200">
                <div class="flex justify-center">
                    {{ $berita->onEachSide(1)->links() }}
                </div>
            </div>
        @endif

        {{-- CTA Section --}}
        <div class="mt-12 bg-gradient-to-r from-green-50 to-emerald-50 border border-green-100 rounded-xl p-8">
            <div class="max-w-3xl mx-auto text-center">
                <h3 class="text-2xl font-bold text-zinc-900 mb-4">Tertarik Bermitra?</h3>
                <p class="text-zinc-600 mb-4">
                    Kami terbuka untuk berbagai bentuk kerjasama riset dengan institusi pendidikan, 
                    lembaga penelitian, pemerintah, dan sektor swasta.
                </p>
                <div class="grid md:grid-cols-2 gap-4 mb-6">
                    <div class="text-left">
                        <h4 class="font-medium text-green-800 mb-2">Bentuk Kerjasama:</h4>
                        <ul class="text-sm text-zinc-700 space-y-1">
                            <li class="flex items-center">
                                <svg class="w-4 h-4 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Penelitian Bersama
                            </li>
                            <li class="flex items-center">
                                <svg class="w-4 h-4 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Pertukaran Peneliti
                            </li>
                            <li class="flex items-center">
                                <svg class="w-4 h-4 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Publikasi Bersama
                            </li>
                        </ul>
                    </div>
                    <div class="text-left">
                        <h4 class="font-medium text-green-800 mb-2">Bidang Kerjasama:</h4>
                        <ul class="text-sm text-zinc-700 space-y-1">
                            <li class="flex items-center">
                                <svg class="w-4 h-4 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Linguistik Daerah
                            </li>
                            <li class="flex items-center">
                                <svg class="w-4 h-4 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Sastra Daerah
                            </li>
                            <li class="flex items-center">
                                <svg class="w-4 h-4 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Revitalisasi Bahasa
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('welcome') . '#kontak' }}" 
                       class="inline-flex items-center justify-center px-6 py-3 bg-green-600 text-white font-medium rounded-lg hover:bg-green-700 transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        Ajukan Kerjasama
                    </a>
                    <a href="{{ route('guest.kegiatan-penelitian.index') }}" 
                       class="inline-flex items-center justify-center px-6 py-3 border border-green-600 text-green-600 font-medium rounded-lg hover:bg-green-50 transition-colors">
                        Lihat Kegiatan Penelitian
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
(function($){
    const $q         = $('#q');
    const $kat       = $('#kategori');
    const $items     = $('#kerjasama-list .kerjasama-item');
    const $info      = $('#result-info');
    const $reset     = $('#resetFilter');

    // Debounce sederhana
    let t = null;
    function debounce(fn, delay=200){
        return function(){ clearTimeout(t); t = setTimeout(()=>fn.apply(this, arguments), delay); }
    }

    function norm(s){ return (s || '').toString().toLowerCase().trim(); }

    function applyFilter(){
        const q   = norm($q.val());
        const kat = norm($kat.val());

        let shown = 0;
        $items.each(function(){
            const $li   = $(this);
            const title = $li.data('title') || '';
            const tags  = $li.data('tags') || '';
            const k     = $li.data('kategori') || '';

            const matchQ   = !q || title.includes(q) || tags.includes(q);
            const matchKat = !kat || k === kat;

            const visible = matchQ && matchKat;
            $li.toggle(visible);
            if (visible) shown++;
        });

        // update info
        const total = $items.length;
        const katLabel = $kat.find('option:selected').text() || 'Semua Jenis Kerjasama';
        $info.text(`${shown} dari ${total} kerjasama riset${kat ? ' • ' + katLabel : ''}${q ? ' • "' + $q.val() + '"' : ''}`);
    }

    const run = debounce(applyFilter, 120);
    $q.on('input', run);
    $kat.on('change', run);
    $reset.on('click', function(){
        $q.val('');
        $kat.val('');
        applyFilter();
        if (history.replaceState) history.replaceState({}, '', location.pathname);
    });

    // Inisialisasi
    applyFilter();

    // Update URL dengan query string
    function writeQueryToURL(){
        const params = new URLSearchParams();
        if ($q.val().trim()) params.set('q', $q.val().trim());
        if ($kat.val())      params.set('kategori', $kat.val());
        const qs = params.toString();
        if (history.replaceState) history.replaceState({}, '', qs ? (`?${qs}`) : location.pathname);
    }
    $q.on('input', debounce(writeQueryToURL, 300));
    $kat.on('change', writeQueryToURL);

})(jQuery);
</script>
@endpush

<style>
.line-clamp-2 {
    overflow: hidden;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
}

.line-clamp-3 {
    overflow: hidden;
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
}
</style>
@endsection