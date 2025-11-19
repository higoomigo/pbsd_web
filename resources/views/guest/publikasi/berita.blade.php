@extends('layout-web.app')
@section('title', 'Berita — Pusat Studi')
@section('content')
@section('judul_halaman', 'Berita & Kegiatan Terbaru')

<div class="py-8">
  <div class="container mx-auto px-4 sm:px-6 lg:px-36">

    {{-- Header + Filter (kept compact) --}}
    <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-3 mb-4">
  <div></div>
  <form id="news-filter" class="w-full md:w-auto flex flex-col sm:flex-row gap-2" onsubmit="return false">
    <input
      id="q" type="text" value="{{ $q }}"
      placeholder="Cari judul, tag…"
      class="w-full sm:w-64 border border-zinc-300 rounded-md px-2.5 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
    />
    <select
      id="kategori"
      class="w-full sm:w-48 border border-zinc-300 rounded-md px-2.5 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
    >
      <option value="">Semua Kategori</option>
      @foreach($kategoriList as $opt)
        <option value="{{ $opt }}" @selected($kategori===$opt)>{{ $opt }}</option>
      @endforeach
    </select>
    <button id="resetFilter" class="inline-flex items-center justify-center px-3 py-1.5 rounded-md bg-zinc-100 text-zinc-700 text-sm hover:bg-zinc-200" type="button">
      Reset
    </button>
  </form>
</div>

{{-- Info jumlah hasil --}}
<p id="result-info" class="text-xs text-zinc-500 mb-2"></p>


    {{-- Media List --}}
    {{-- Media List --}}
<ul id="news-list" class="divide-y divide-zinc-200 bg-white border border-zinc-200 rounded-lg">
  @forelse($berita as $b)
    @php
      $thumb   = $b->thumbnail_path ? Storage::url($b->thumbnail_path) : asset('images/placeholder-4x3.png');
      $tglIso  = optional($b->published_at)?->format('Y-m-d');
      $tglDisp = optional($b->published_at)->translatedFormat('d M Y');
      $ringkas = $b->ringkasan ?: '—';
      $tagsStr = trim((string)$b->tag);
      $author  = optional($b->author)->name;
      $href    = route('guest.berita.show', $b->slug);
      $kat     = $b->kategori ?? 'Kegiatan';
    @endphp

    <li
      class="news-item"
      data-title="{{ Str::lower($b->judul) }}"
      data-tags="{{ Str::lower($tagsStr) }}"
      data-kategori="{{ Str::lower($kat) }}"
      data-date="{{ $tglIso }}"
    >
      <a href="{{ $href }}"
         class="group flex gap-3 sm:gap-4 items-start p-3 sm:p-4 hover:bg-zinc-50 focus:bg-zinc-50 focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500 transition">
        <div class="relative flex-shrink-0 w-28 h-20 sm:w-36 sm:h-24 overflow-hidden rounded-md border border-zinc-200 bg-zinc-100">
          <img src="{{ $thumb }}" alt="{{ $b->judul }}" class="absolute inset-0 w-full h-full object-cover transition-transform duration-300 group-hover:scale-[1.02]" loading="lazy">
        </div>

        <div class="min-w-0 flex-1">
          <h2 class="title text-zinc-800 text-[15px] sm:text-[16px] leading-snug font-semibold line-clamp-2 group-hover:text-cyan-700">
            {{ $b->judul }}
          </h2>
          <p class="meta mt-1 text-[11px] sm:text-xs text-zinc-500">
            <span class="uppercase font-semibold kategori">{{ $kat }}</span>
            — <time class="tanggal" datetime="{{ $tglIso }}">{{ $tglDisp ?: '—' }}</time>
            @if($author) · <span class="author">{{ $author }}</span> @endif
          </p>
          @if($ringkas)
            <p class="excerpt mt-1.5 text-[13px] text-zinc-600 line-clamp-2">{{ $ringkas }}</p>
          @endif
          @if(!empty($tagsStr))
            @php
              $tags = collect(explode(',', $tagsStr))->map(fn($t)=>trim($t))->filter()->take(4);
            @endphp
            @if($tags->isNotEmpty())
              <div class="tags mt-2 flex flex-wrap gap-1.5">
                @foreach($tags as $t)
                  <span class="inline-flex items-center px-2 py-0.5 rounded bg-zinc-100 text-zinc-700 text-[11px]">#{{ $t }}</span>
                @endforeach
              </div>
            @endif
          @endif
        </div>

        <svg class="mt-1 hidden sm:block size-4 text-zinc-400 group-hover:text-zinc-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 18l6-6-6-6" stroke-linecap="round" stroke-linejoin="round"/></svg>
      </a>
    </li>
  @empty
    <li class="p-5 text-sm text-zinc-600">Belum ada berita terbit.</li>
  @endforelse
</ul>


    {{-- Pagination (compact) --}}
    @if(method_exists($berita,'links'))
      <div class="mt-6 flex justify-center text-sm">
        {{ $berita->onEachSide(1)->links() }}
      </div>
    @endif
  </div>
</div>

{{-- jQuery CDN jika belum tersedia di layout --}}
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script>
(function($){
  const $q         = $('#q');
  const $kat       = $('#kategori');
  const $items     = $('#news-list .news-item');
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
    const katLabel = $kat.find('option:selected').text() || 'Semua Kategori';
    $info.text(`${shown} dari ${total} berita${kat ? ' • ' + katLabel : ''}${q ? ' • “' + $q.val() + '”' : ''}`);
  }

  const run = debounce(applyFilter, 120);
  $q.on('input', run);
  $kat.on('change', run);
  $reset.on('click', function(){
    $q.val('');
    $kat.val('');
    applyFilter();
    // opsional: bersihkan query di URL
    if (history.replaceState) history.replaceState({}, '', location.pathname);
  });

  // Inisialisasi: kalau ada query dari URL, tetap dipakai untuk state awal
  applyFilter();

  // Opsional: tulis query ke URL saat filter berubah
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

@endsection
