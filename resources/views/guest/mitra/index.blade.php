@extends('layout-web.app')

@section('title', 'Mitra Kerja Sama — Pusat Studi Pelestarian Bahasa Dan Sastra Daerah')
@section('judul_halaman', 'Mitra Kerja Sama')

@section('content')
<div class="mb-20">
    <div class="">
        <div class="pt-6 md:pb-12 bg-base-100">

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="space-y-6">

                    {{-- Deskripsi / Pengantar --}}
                    <div class="text-center mb-8">
                        <div class="prose prose-lg max-w-3xl mx-auto text-zinc-700">
                            <p class="text-lg">
                                Jaringan mitra kerja sama Pusat Studi Pelestarian Bahasa dan Sastra Daerah 
                                yang terdiri dari berbagai institusi pemerintah, perguruan tinggi, 
                                dan organisasi terkait dalam upaya pelestarian bahasa dan sastra daerah.
                            </p>
                        </div>
                    </div>

                    {{-- Filter dan Pencarian --}}
                    <div class="bg-white rounded-lg border border-zinc-200 p-6 mb-8">
                        <form id="mitra-filter" class="space-y-4 sm:space-y-0 sm:flex sm:items-center sm:gap-4" onsubmit="return false">
                            <div class="flex-1 space-y-4 sm:space-y-0 sm:flex sm:gap-4">
                                <div class="flex-1">
                                    <input
                                        id="q" type="text" value="{{ $q ?? '' }}"
                                        placeholder="Cari nama mitra..."
                                        class="w-full border border-zinc-300 rounded-lg px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                                    />
                                </div>
                                
                                <div class="sm:w-48">
                                    <select
                                        id="jenis"
                                        class="w-full border border-zinc-300 rounded-lg px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                                    >
                                        <option value="">Semua Jenis</option>
                                        @foreach($jenisList ?? [] as $opt)
                                            <option value="{{ $opt }}" @selected(($jenis ?? '')===$opt)>{{ $opt }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="sm:w-48">
                                    <select
                                        id="status"
                                        class="w-full border border-zinc-300 rounded-lg px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                                    >
                                        <option value="">Semua Status</option>
                                        <option value="Aktif" @selected(($status ?? '')==='Aktif')>Aktif</option>
                                        <option value="Tidak Aktif" @selected(($status ?? '')==='Tidak Aktif')>Tidak Aktif</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="sm:w-auto">
                                <button id="resetFilter" type="button"
                                        class="w-full sm:w-auto inline-flex items-center justify-center px-4 py-3 border border-zinc-300 rounded-lg text-sm font-medium text-zinc-700 bg-white hover:bg-zinc-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-colors">
                                    Reset Filter
                                </button>
                            </div>
                        </form>

                        {{-- Info Hasil --}}
                        <p id="result-info" class="mt-4 text-sm text-zinc-600"></p>
                    </div>

                    {{-- Daftar Mitra dalam Grid 3 Kolom SIMPLE --}}
                    @if(count($mitras) > 0)
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($mitras as $mitra)
                            @php
                                $logoUrl = $mitra->logo_path ? Storage::url($mitra->logo_path) : null;
                                $statusColor = $mitra->status === 'Aktif' ? 
                                    'bg-green-100 text-green-800' : 
                                    'bg-red-100 text-red-800';
                            @endphp

                            <div class="mitra-item bg-white p-6 hover:shadow-lg transition-all duration-300 h-full flex flex-col items-center justify-center text-center"
                                 data-nama="{{ Str::lower($mitra->nama) }}"
                                 data-deskripsi="{{ Str::lower($mitra->deskripsi) }}"
                                 data-jenis="{{ Str::lower($mitra->jenis) }}"
                                 data-status="{{ Str::lower($mitra->status) }}">

                                {{-- Logo Mitra --}}
                                <div class="mb-4">
                                    @if($logoUrl)
                                        <div class="w-24 h-24 mx-auto rounded-lg overflow-hidden">
                                            <img src="{{ $logoUrl }}" 
                                                 alt="Logo {{ $mitra->nama }}"
                                                 class="w-full h-full object-contain hover:scale-105 transition-transform duration-300">
                                        </div>
                                    @else
                                        <div class="w-24 h-24 mx-auto bg-zinc-100 rounded-lg flex items-center justify-center">
                                            <svg class="w-12 h-12 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                            </svg>
                                        </div>
                                    @endif
                                </div>

                                {{-- Nama Mitra --}}
                                <h3 class="font-bold text-zinc-900 text-lg mb-2 line-clamp-2">
                                    {{ $mitra->nama }}
                                </h3>

                                {{-- Jenis Mitra --}}
                                <p class="text-sm text-zinc-500 mb-3">
                                    {{ $mitra->jenis }}
                                </p>

                                {{-- Status Badge --}}
                                <span class="inline-block px-3 py-1 text-xs font-medium rounded-full {{ $statusColor }}">
                                    {{ $mitra->status }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                    @else
                        {{-- Empty State --}}
                        <div class="bg-white border border-zinc-200 rounded-xl p-12 text-center">
                            <svg class="w-16 h-16 text-zinc-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                            <h3 class="text-lg font-semibold text-zinc-900 mb-2">Belum ada mitra kerja sama</h3>
                            <p class="text-zinc-600">Daftar mitra akan ditampilkan di sini setelah tersedia.</p>
                        </div>
                    @endif

                    {{-- Pagination --}}
                    @if(method_exists($mitras,'links') && $mitras->hasPages())
                        <div class="pt-8 border-t border-zinc-200">
                            <div class="flex justify-center">
                                {{ $mitras->onEachSide(1)->links() }}
                            </div>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
/* Custom styles untuk grid yang lebih baik */
.grid > * {
    display: flex;
    flex-direction: column;
}

.mitra-item {
    transition: all 0.3s ease;
    border-radius: 12px;
}

.mitra-item:hover {
    transform: translateY(-4px);
    box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
}

/* Responsive grid adjustments */
@media (max-width: 640px) {
    .grid {
        grid-template-columns: 1fr;
        gap: 1.5rem;
    }
}

@media (min-width: 641px) and (max-width: 1024px) {
    .grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 1.5rem;
    }
}

@media (min-width: 1025px) {
    .grid {
        grid-template-columns: repeat(3, 1fr);
        gap: 2rem;
    }
}

/* Style untuk line-clamp */
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

/* Animasi logo */
img {
    transition: transform 0.3s ease;
}
</style>
@endpush

@push('scripts')
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
(function($){
    const $q       = $('#q');
    const $jenis   = $('#jenis');
    const $status  = $('#status');
    const $items   = $('.mitra-item');
    const $info    = $('#result-info');
    const $reset   = $('#resetFilter');

    let t = null;
    function debounce(fn, delay=200){
        return function(){
            clearTimeout(t);
            t = setTimeout(()=>fn.apply(this, arguments), delay);
        }
    }

    function norm(s){
        return (s || '').toString().toLowerCase().trim();
    }

    function applyFilter(){
        const q       = norm($q.val());
        const jenis   = norm($jenis.val());
        const status  = norm($status.val());

        let shown = 0;
        $items.each(function(){
            const $li       = $(this);
            const nama      = ($li.data('nama') || '').toString();
            const deskripsi = ($li.data('deskripsi') || '').toString();
            const j         = ($li.data('jenis') || '').toString();
            const s         = ($li.data('status') || '').toString();

            const matchQ      = !q || nama.includes(q) || deskripsi.includes(q);
            const matchJenis  = !jenis || j === jenis;
            const matchStatus = !status || s === status;

            const visible = matchQ && matchJenis && matchStatus;
            $li.toggle(visible);
            if (visible) shown++;
        });

        const total    = $items.length;
        const jenisLabel = $jenis.find('option:selected').text() || 'Semua Jenis';
        const statusLabel = $status.find('option:selected').text() || 'Semua Status';
        const qText    = $q.val().trim();

        let info = `Menampilkan ${shown} dari ${total} mitra`;
        if (jenis)   info += ` • Jenis: ${jenisLabel}`;
        if (status)  info += ` • Status: ${statusLabel}`;
        if (qText)   info += ` • Pencarian: "${qText}"`;

        $info.text(info);
    }

    const run = debounce(applyFilter, 120);
    $q.on('input', run);
    $jenis.on('change', run);
    $status.on('change', run);

    $reset.on('click', function(){
        $q.val('');
        $jenis.val('');
        $status.val('');
        applyFilter();
        if (history.replaceState) history.replaceState({}, '', location.pathname);
    });

    // Tulis query ke URL
    function writeQueryToURL(){
        const params = new URLSearchParams();
        const qVal   = $q.val().trim();
        const jVal   = $jenis.val();
        const sVal   = $status.val();

        if (qVal) params.set('q', qVal);
        if (jVal) params.set('jenis', jVal);
        if (sVal) params.set('status', sVal);

        const qs = params.toString();
        if (history.replaceState) {
            history.replaceState({}, '', qs ? (`?${qs}`) : location.pathname);
        }
    }

    $q.on('input', debounce(writeQueryToURL, 300));
    $jenis.on('change', writeQueryToURL);
    $status.on('change', writeQueryToURL);

    // inisialisasi
    applyFilter();

})(jQuery);
</script>
@endpush
@endsection