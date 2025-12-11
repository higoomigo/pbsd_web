@extends('layout-web.app')

@section('title', 'Artikel — Pusat Studi')
@section('judul_halaman', 'Artikel Terbitan Pusat Studi')

@section('content')
<div class="py-8">
  {{-- karena layout sudah kasih container, di sini cukup w-full + padding tambahan di desktop --}}
  <div class="w-full lg:px-10 xl:px-36">

    {{-- Hero kecil di atas list (opsional, bisa kamu edit teksnya) --}}
    <div class="mb-4">
      <p class="text-sm text-zinc-600 max-w-2xl">
        Kumpulan artikel terbitan Pusat Studi Pelestarian Bahasa dan Sastra Daerah yang mendokumentasikan
        kegiatan, kajian, dan pemikiran kritis terkait pelestarian bahasa dan sastra daerah.
      </p>
    </div>

    {{-- Header + Filter --}}
    <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-1 mb-3">
      <div></div>
      <form id="article-filter"
            class="w-full md:w-auto flex flex-col sm:flex-row gap-2"
            onsubmit="return false">
        <input
          id="q" type="text" value="{{ $q }}"
          placeholder="Cari judul, ringkasan, tag…"
          class="w-full sm:w-64 border border-zinc-400  px-2.5 py-1.5 text-sm
                 focus:outline-none focus:ring-2 focus:ring-indigo-500"
        />
        <select
          id="kategori"
          class="w-full sm:w-48 border border-zinc-400  px-2.5 py-1.5 text-sm
                 focus:outline-none focus:ring-2 focus:ring-indigo-500"
        >
          <option value="">Semua Kategori</option>
          @foreach($kategoriList as $opt)
            <option value="{{ $opt }}" @selected($kategori===$opt)>{{ $opt }}</option>
          @endforeach
        </select>
        <button id="resetFilter" type="button"
                class="inline-flex items-center justify-center px-3 py-1.5 
                       bg-zinc-100 text-zinc-700 text-sm hover:bg-zinc-200">
          Reset
        </button>
      </form>
    </div>

    {{-- Info jumlah hasil --}}
    <p id="result-info" class="text-xs text-zinc-500 mb-2"></p>

    {{-- LIST ARTIKEL --}}
    <ul id="article-list"
        class="bg-base-100 mt-3 border-b border-zinc-400 divide-y divide-zinc-200"
        role="list">

      @forelse($artikel as $idx => $a)
        @php
          // nomor global (kalau paginate)
          $no = str_pad(
            (method_exists($artikel, 'firstItem') ? $artikel->firstItem() + $idx : $idx + 1),
            2, '0', STR_PAD_LEFT
          );
          $tglIso  = optional($a->published_at)?->format('Y-m-d');
          $tglDisp = optional($a->published_at)->translatedFormat('d M Y');
          $penulis = $a->penulis ?: optional($a->author)->name;
          $href    = route('guest.artikel.show', $a->slug);
          $kat     = $a->kategori ?: 'Artikel';
          $tagsStr = trim((string) $a->tag);
        @endphp

        <li
          class="article-item"
          data-title="{{ Str::lower($a->judul) }}"
          data-tags="{{ Str::lower($tagsStr) }}"
          data-kategori="{{ Str::lower($kat) }}"
          data-date="{{ $tglIso }}"
        >
          <a href="{{ $href }}"
             class="flex items-start gap-4 py-5 px-4 sm:px-6 hover:bg-zinc-200
                    focus:bg-zinc-300 focus:outline-none focus-visible:ring-2
                    focus-visible:ring-indigo-500 transition">

            {{-- Nomor --}}
            <div class="text-3xl sm:text-4xl font-thin text-zinc-800/40 tabular-nums min-w-12 text-center">
              {{ sprintf('%02d', $loop->iteration) }}
            </div>

            {{-- Konten utama --}}
            <div class="flex-1 min-w-0">
              <h2 class="title text-zinc-800 text-[15px] sm:text-[16px] leading-snug font-semibold line-clamp-2">
                {{ $a->judul }}
              </h2>

              <p class="meta mt-1 text-[11px] sm:text-xs text-zinc-500">
                <span class="uppercase font-semibold kategori">{{ $kat }}</span>
                — <time class="tanggal" datetime="{{ $tglIso }}">{{ $tglDisp ?: '—' }}</time>
                @if($penulis) · <span class="author">{{ $penulis }}</span> @endif
              </p>

              @if(!empty($a->ringkasan))
                <p class="excerpt mt-1.5 text-[13px] text-zinc-600 line-clamp-2 sm:line-clamp-3">
                  {{ $a->ringkasan }}
                </p>
              @endif

              @if(!empty($tagsStr))
                @php
                  $tags = collect(explode(',', $tagsStr))
                            ->map(fn($t)=>trim($t))
                            ->filter()
                            ->take(5);
                @endphp
                @if($tags->isNotEmpty())
                  <div class="tags mt-2 flex flex-wrap gap-1.5">
                    @foreach($tags as $t)
                      <span class="inline-flex items-center px-2 py-0.5  bg-zinc-100
                                   text-zinc-700 text-[11px]">#{{ $t }}</span>
                    @endforeach
                  </div>
                @endif
              @endif
            </div>

            <svg class="mt-1 hidden sm:block size-4 text-zinc-400"
                 viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M9 18l6-6-6-6" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
          </a>
        </li>
      @empty
        <li class="p-5 text-sm text-zinc-600">
          Belum ada artikel terbit.
        </li>
      @endforelse
    </ul>

    {{-- Pagination --}}
    @if(method_exists($artikel,'links'))
      <div class="mt-6 flex justify-center text-sm">
        {{ $artikel->onEachSide(1)->links() }}
      </div>
    @endif

  </div>
</div>

{{-- jQuery CDN kalau belum di-include di layout --}}
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script>
(function($){
  const $q     = $('#q');
  const $kat   = $('#kategori');
  const $items = $('#article-list .article-item');
  const $info  = $('#result-info');
  const $reset = $('#resetFilter');

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
    const q   = norm($q.val());
    const kat = norm($kat.val());

    let shown = 0;
    $items.each(function(){
      const $li   = $(this);
      const title = ($li.data('title') || '').toString();
      const tags  = ($li.data('tags') || '').toString();
      const k     = ($li.data('kategori') || '').toString();

      const matchQ   = !q || title.includes(q) || tags.includes(q);
      const matchKat = !kat || k === kat;

      const visible = matchQ && matchKat;
      $li.toggle(visible);
      if (visible) shown++;
    });

    const total    = $items.length;
    const katLabel = $kat.find('option:selected').text() || 'Semua Kategori';
    const qText    = $q.val().trim();

    let info = `${shown} dari ${total} artikel`;
    if (kat)   info += ` • ${katLabel}`;
    if (qText) info += ` • “${qText}”`;

    $info.text(info);
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

  // inisialisasi
  applyFilter();

  // Tulis query ke URL biar bisa di-share/refresh
  function writeQueryToURL(){
    const params = new URLSearchParams();
    const qVal   = $q.val().trim();
    const kVal   = $kat.val();

    if (qVal) params.set('q', qVal);
    if (kVal) params.set('kategori', kVal);

    const qs = params.toString();
    if (history.replaceState) {
      history.replaceState({}, '', qs ? (`?${qs}`) : location.pathname);
    }
  }

  $q.on('input', debounce(writeQueryToURL, 300));
  $kat.on('change', writeQueryToURL);

})(jQuery);
</script>
@endsection
