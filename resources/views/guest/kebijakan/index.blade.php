@extends('layout-web.app')

@section('title', 'Kebijakan Organisasi — Pusat Studi Pelestarian Bahasa Dan Sastra Daerah')
@section('judul_halaman', 'Kebijakan Organisasi')

@section('content')
<div class="mb-20">
    <div class="mt-8">
        <div class="grid lg:grid-cols-3 md:grid-cols-1 gap-6 mb-6 md:pb-12 bg-base-100">

            <div class="col-span-3 px-4 sm:px-6 pb-8">
                <div class="space-y-6">

                    {{-- Deskripsi / Pengantar --}}
                    <div>
                        <div class="prose prose-sm sm:prose-base max-w-none text-zinc-700">
                            <p>
                                Dokumen kebijakan resmi Pusat Studi Pelestarian Bahasa dan Sastra Daerah 
                                yang mengatur tata kelola, prosedur operasional, dan standar pelaksanaan 
                                kegiatan organisasi.
                            </p>
                        </div>

                        <div class="mt-4 text-xs text-zinc-500">
                            <p>
                                Semua dokumen kebijakan telah disahkan oleh otoritas yang berwenang dan 
                                berlaku sesuai periode yang ditentukan. Perubahan dapat dilakukan melalui 
                proses revisi resmi.
                            </p>
                        </div>
                    </div>

                    {{-- Filter dan Pencarian --}}
                    <div class="bg-white p-4">
                        <form id="kebijakan-filter" class="space-y-4 sm:space-y-0 sm:flex sm:items-end sm:gap-4" onsubmit="return false">
                            <div class="flex-1 space-y-4 sm:space-y-0 sm:flex sm:gap-4">
                                <div class="flex-1">
                                    <label for="q" class="block text-sm font-medium text-zinc-700 mb-1">Pencarian</label>
                                    <input
                                        id="q" type="text" value="{{ $q ?? '' }}"
                                        placeholder="Cari judul, nomor dokumen, ringkasan…"
                                        class="w-full border border-zinc-800  px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                    />
                                </div>
                                
                                <div class="sm:w-48">
                                    <label for="kategori" class="block text-sm font-medium text-zinc-700 mb-1">Kategori</label>
                                    <select
                                        id="kategori"
                                        class="w-full border border-zinc-800  px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                    >
                                        <option value="">Semua Kategori</option>
                                        @foreach($kategoriList ?? [] as $opt)
                                            <option value="{{ $opt }}" @selected(($kategori ?? '')===$opt)>{{ $opt }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="sm:w-40">
                                    <label for="status" class="block text-sm font-medium text-zinc-700 mb-1">Status</label>
                                    <select
                                        id="status"
                                        class="w-full border border-zinc-800  px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                    >
                                        <option value="">Semua Status</option>
                                        <option value="Aktif" @selected(($status ?? '')==='Aktif')>Aktif</option>
                                        <option value="Revisi" @selected(($status ?? '')==='Revisi')>Revisi</option>
                                        <option value="Tidak Berlaku" @selected(($status ?? '')==='Tidak Berlaku')>Tidak Berlaku</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="sm:w-auto">
                                <button id="resetFilter" type="button"
                                        class="w-full sm:w-auto inline-flex items-center justify-center px-4 py-2 border border-zinc-800  text-sm font-medium text-zinc-700 bg-white hover:bg-zinc-50 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                    Reset Filter
                                </button>
                            </div>
                        </form>

                        {{-- Info Hasil --}}
                        <p id="result-info" class="mt-3 text-xs text-zinc-500"></p>
                    </div>

                    {{-- Daftar Kebijakan --}}
                    <div class="space-y-4">
                        @forelse($kebijakan as $k)
                            @php
                                $tglBerlaku = optional($k->tanggal_berlaku)->format('d M Y');
                                $tglTinjau = optional($k->tanggal_tinjau_berikutnya)->format('d M Y');
                                $href = route('guest.kebijakan.show', $k->id);
                                $tagsStr = trim((string) $k->tags);
                                $statusColor = match($k->status) {
                                    'Aktif' => 'bg-green-100 text-green-800 border-green-200',
                                    'Revisi' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
                                    'Tidak Berlaku' => 'bg-red-100 text-red-800 border-red-200',
                                    default => 'bg-gray-100 text-gray-800 border-gray-200'
                                };
                            @endphp

                            <div class="kebijakan-item bg-white border-b border-zinc-800  p-6  transition-shadow"
                                 data-title="{{ Str::lower($k->judul) }}"
                                 data-tags="{{ Str::lower($tagsStr) }}"
                                 data-kategori="{{ Str::lower($k->kategori) }}"
                                 data-status="{{ Str::lower($k->status) }}"
                                 data-nomor="{{ Str::lower($k->nomor_dokumen) }}">
                                
                                <div class="flex items-start justify-between gap-4 mb-3">
                                    <h3 class="text-lg font-semibold text-zinc-800 flex-1">
                                        <a href="{{ $href }}" class="hover:text-indigo-600 transition-colors">
                                            {{ $k->judul }}
                                        </a>
                                    </h3>
                                    <span class="status-badge px-3 py-1 rounded-full text-xs font-medium border {{ $statusColor }} whitespace-nowrap">
                                        {{ $k->status }}
                                    </span>
                                </div>

                                <div class="space-y-3">
                                    {{-- Meta Information --}}
                                    <div class="flex flex-wrap items-center gap-4 text-sm text-zinc-600">
                                        <span class="flex items-center gap-1">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                            </svg>
                                            {{ $k->kategori }}
                                        </span>
                                        
                                        @if($k->nomor_dokumen)
                                            <span class="flex items-center gap-1">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                                </svg>
                                                {{ $k->nomor_dokumen }}
                                            </span>
                                        @endif

                                        @if($k->versi)
                                            <span class="flex items-center gap-1">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4a1 1 0 011-1h4M4 8v8a2 2 0 002 2h8a2 2 0 002-2V8m-6 6h2m-6 0h2m4-6V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v4"/>
                                                </svg>
                                                Versi {{ $k->versi }}
                                            </span>
                                        @endif
                                    </div>

                                    {{-- Ringkasan --}}
                                    @if(!empty($k->ringkasan))
                                        <p class="text-zinc-600 leading-relaxed">
                                            {{ $k->ringkasan }}
                                        </p>
                                    @endif

                                    {{-- Detail Informasi --}}
                                    <div class="flex flex-wrap gap-4 text-sm text-zinc-500">
                                        @if($k->otoritas_pengesah)
                                            <span class="flex items-center gap-1">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                                </svg>
                                                {{ $k->otoritas_pengesah }}
                                            </span>
                                        @endif
                                        
                                        @if($tglBerlaku)
                                            <span class="flex items-center gap-1">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                </svg>
                                                Berlaku: {{ $tglBerlaku }}
                                            </span>
                                        @endif

                                        @if($tglTinjau)
                                            <span class="flex items-center gap-1">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                </svg>
                                                Tinjau: {{ $tglTinjau }}
                                            </span>
                                        @endif
                                    </div>

                                    {{-- Tags --}}
                                    @if(!empty($tagsStr))
                                        @php
                                            $tags = collect(explode(',', $tagsStr))
                                                        ->map(fn($t)=>trim($t))
                                                        ->filter()
                                                        ->take(5);
                                        @endphp
                                        @if($tags->isNotEmpty())
                                            <div class="flex flex-wrap gap-2 pt-2">
                                                @foreach($tags as $t)
                                                    <span class="inline-flex items-center px-2 py-1 rounded bg-zinc-100 text-zinc-700 text-xs">
                                                        #{{ $t }}
                                                    </span>
                                                @endforeach
                                            </div>
                                        @endif
                                    @endif

                                    {{-- Action Button --}}
                                    <div class="pt-3 border-t border-zinc-100">
                                        <a href="{{ $href }}" 
                                           class="inline-flex items-center gap-2 px-4 py-2 bg-zinc-700 text-white text-sm font-medium  hover:bg-zinc-900 transition-colors">
                                            Lihat Detail Dokumen
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="bg-white border border-zinc-800 rounded-lg p-8 text-center">
                                <svg class="w-12 h-12 text-zinc-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                <p class="text-zinc-600">Belum ada dokumen kebijakan yang tersedia.</p>
                                <p class="text-sm text-zinc-500 mt-1">Dokumen kebijakan akan ditampilkan di sini setelah tersedia.</p>
                            </div>
                        @endforelse
                    </div>

                    {{-- Pagination --}}
                    @if(method_exists($kebijakan,'links') && $kebijakan->hasPages())
                        <div class="pt-6 border-t border-zinc-800">
                            <div class="flex justify-center">
                                {{ $kebijakan->onEachSide(1)->links() }}
                            </div>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>

{{-- jQuery CDN --}}
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script>
(function($){
    const $q       = $('#q');
    const $kat     = $('#kategori');
    const $status  = $('#status');
    const $items   = $('.kebijakan-item');
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
        const kat     = norm($kat.val());
        const status  = norm($status.val());

        let shown = 0;
        $items.each(function(){
            const $li     = $(this);
            const title   = ($li.data('title') || '').toString();
            const tags    = ($li.data('tags') || '').toString();
            const k       = ($li.data('kategori') || '').toString();
            const s       = ($li.data('status') || '').toString();
            const nomor   = ($li.data('nomor') || '').toString();

            const matchQ      = !q || title.includes(q) || tags.includes(q) || nomor.includes(q);
            const matchKat    = !kat || k === kat;
            const matchStatus = !status || s === status;

            const visible = matchQ && matchKat && matchStatus;
            $li.toggle(visible);
            if (visible) shown++;
        });

        const total    = $items.length;
        const katLabel = $kat.find('option:selected').text() || 'Semua Kategori';
        const statusLabel = $status.find('option:selected').text() || 'Semua Status';
        const qText    = $q.val().trim();

        let info = `Menampilkan ${shown} dari ${total} dokumen`;
        if (kat)     info += ` • Kategori: ${katLabel}`;
        if (status)  info += ` • Status: ${statusLabel}`;
        if (qText)   info += ` • Pencarian: "${qText}"`;

        $info.text(info);
    }

    const run = debounce(applyFilter, 120);
    $q.on('input', run);
    $kat.on('change', run);
    $status.on('change', run);

    $reset.on('click', function(){
        $q.val('');
        $kat.val('');
        $status.val('');
        applyFilter();
        if (history.replaceState) history.replaceState({}, '', location.pathname);
    });

    // Tulis query ke URL
    function writeQueryToURL(){
        const params = new URLSearchParams();
        const qVal   = $q.val().trim();
        const kVal   = $kat.val();
        const sVal   = $status.val();

        if (qVal) params.set('q', qVal);
        if (kVal) params.set('kategori', kVal);
        if (sVal) params.set('status', sVal);

        const qs = params.toString();
        if (history.replaceState) {
            history.replaceState({}, '', qs ? (`?${qs}`) : location.pathname);
        }
    }

    $q.on('input', debounce(writeQueryToURL, 300));
    $kat.on('change', writeQueryToURL);
    $status.on('change', writeQueryToURL);

    // inisialisasi
    applyFilter();

})(jQuery);
</script>
@endsection