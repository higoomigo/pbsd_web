@props([
  // koleksi berita: id, judul, slug, thumbnail_path, published_at, kategori
  'items' => collect(),
  // offset sticky biar sejajar header kamu
  'stickyTop' => 'top-24',
  // judul blok
  'heading' => 'Berita Terbaru',
])

<aside class="w-full pt-20 ml-16 pr-16">
  <div class="sticky {{ $stickyTop }}">

    {{-- Heading kecil & rapat --}}
    <h3 class="text-[16px] font-semibold uppercase tracking-wide text-zinc-600 mb-2">
      {{ $heading }}
    </h3>

    @if($items->isEmpty())
      <div class="text-sm text-zinc-500">Belum ada berita terbit.</div>
    @else
      {{-- List compact, rata kiri, tanpa padding berlebih --}}
      <ul class="divide-y divide-zinc-200 border border-zinc-200 bg-white overflow-hidden">
  @foreach($items as $b)
    @php
      $thumb = $b->thumbnail_path ? Storage::url($b->thumbnail_path) : asset('images/placeholder-4x3.png');
      $tgl   = optional($b->published_at)->translatedFormat('d M Y');
      $href  = route('guest.berita.show', $b->slug);
    @endphp

    {{-- Set li sebagai group + wadah outline --}}
    <li class="relative group transition
               outline outline-0 hover:outline-1 hover:outline-black hover:outline-offset-2
                mx-1 my-1"> 
      <a href="{{ $href }}"
         class="grid grid-cols-[96px,1fr] gap-3 p-3 sm:p-3.5 items-start ">
        {{-- Thumb konsisten (96x64) --}}
        <div class="relative w-24 h-16 overflow-hidden rounded  bg-zinc-100">
          <img src="{{ $thumb }}" alt="{{ $b->judul }}"
               class="absolute inset-0 w-full h-full object-cover transition-transform duration-300 group-hover:scale-[1.02]"
               loading="lazy">
        </div>

        {{-- Teks compact --}}
        <div class="min-w-0">
          <p class="text-[13px] font-semibold text-zinc-800 leading-snug line-clamp-2
                     bg-gradient-to-r from-current to-current bg-no-repeat bg-left-bottom
                     bg-[length:0%_1px] transition-[background-size] duration-300
                     group-hover:bg-[length:100%_1px]">
            {{ $b->judul }}
          </p>
          <p class="mt-0.5 text-[11px] text-zinc-500">
            <span class="uppercase font-semibold">{{ $b->kategori ?? 'Kegiatan' }}</span>
            — <time datetime="{{ optional($b->published_at)?->format('Y-m-d') }}">{{ $tgl ?: '—' }}</time>
          </p>
        </div>
      </a>
    </li>
  @endforeach
</ul>

    @endif
  </div>
</aside>