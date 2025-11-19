@extends('layout-web.app')
@section('title', ($berita->judul ?? 'Berita').' — Pusat Studi')
{{-- @section('judul_halaman', 'Berita') --}}
@section('content')



@php
  $thumb      = $berita->thumbnail_path ? Storage::url($berita->thumbnail_path) : null;
  $tgl        = optional($berita->published_at)->translatedFormat('d M Y');
  $authorName = optional($berita->author)->name ?? ($berita->penulis ?? null);
  $tags       = collect(explode(',', (string)$berita->tag))
                ->map(fn($t)=>trim($t))->filter();
@endphp

<div class="mb-20 px-44 pt-12">
  {{-- Header judul + meta --}}
  <header class="max-w-3xl">
    <h1 class="text-2xl sm:text-3xl md:text-4xl font-title text-zinc-900 leading-tight">
      {{ $berita->judul }}
    </h1>

    <div class="mt-3 flex flex-wrap items-center gap-x-3 gap-y-1 text-sm text-zinc-500">
      <span class="uppercase font-semibold text-zinc-700">{{ $berita->kategori ?? 'Kegiatan' }}</span>
      <span aria-hidden="true">•</span>
      <time datetime="{{ optional($berita->published_at)?->format('Y-m-d') }}">
        {{ $tgl ?: '—' }}
      </time>
      @if($authorName)
        <span aria-hidden="true">•</span>
        <span>{{ $authorName }}</span>
      @endif
    </div>

    @if($tags->isNotEmpty())
      <div class="mt-3 flex flex-wrap gap-2">
        @foreach($tags as $t)
          <span class="inline-flex items-center px-2 py-0.5 rounded bg-zinc-100 text-zinc-700 text-xs">#{{ $t }}</span>
        @endforeach
      </div>
    @endif
  </header>

  {{-- Thumbnail utama (opsional) --}}
  @if($thumb)
    <figure class="mt-6">
      <img
        src="{{ $thumb }}"
        alt="{{ $berita->judul }}"
        class="w-full max-h-[520px] object-cover rounded-md border border-zinc-200">
    </figure>
  @endif

  {{-- Ringkasan (jika ada) --}}
  @if(!empty($berita->ringkasan))
    <p class="mt-6 text-lg text-zinc-700">
      {{ $berita->ringkasan }}
    </p>
  @endif

  {{-- Konten --}}
  <article class="prose prose-zinc max-w-none mt-6">
    {!! $berita->konten !!}
  </article>

  {{-- Navigasi kembali + aksi kecil --}}
  <div class="mt-10 flex items-center justify-between">
    <a href="{{ route('guest.berita.index') }}"
       class="inline-flex items-center gap-2 px-3 py-2 rounded-md border text-zinc-700 bg-white hover:bg-zinc-50">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <path d="M15 18l-6-6 6-6" stroke-linecap="round" stroke-linejoin="round"/>
      </svg>
      Kembali ke daftar
    </a>

    {{-- (Opsional) tombol share sederhana --}}
    <div class="flex items-center gap-2 text-sm">
      <span class="text-zinc-500 mr-1">Bagikan:</span>
      <a class="px-2 py-1 rounded border hover:bg-zinc-50"
         href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->fullUrl()) }}"
         target="_blank" rel="noopener">Facebook</a>
      <a class="px-2 py-1 rounded border hover:bg-zinc-50"
         href="https://twitter.com/intent/tweet?url={{ urlencode(request()->fullUrl()) }}&text={{ urlencode($berita->judul) }}"
         target="_blank" rel="noopener">X</a>
      <button class="px-2 py-1 rounded border hover:bg-zinc-50"
              onclick="navigator.clipboard.writeText('{{ request()->fullUrl() }}')">Salin Link</button>
    </div>
  </div>

  {{-- (Opsional) Related / terbaru lainnya --}}
  @if(isset($terkait) && $terkait->isNotEmpty())
    <section class="mt-12">
      <h2 class="text-lg font-semibold text-zinc-800 mb-3">Berita lain</h2>
      <ul class="divide-y divide-zinc-200 border border-zinc-200 rounded-md bg-white overflow-hidden">
        @foreach($terkait as $b)
          @php
            $tThumb = $b->thumbnail_path ? Storage::url($b->thumbnail_path) : asset('images/placeholder-4x3.png');
            $tDate  = optional($b->published_at)->translatedFormat('d M Y');
          @endphp
          <li class="hover:bg-zinc-50 transition">
            <a href="{{ route('guest.berita.show', $b->slug) }}"
               class="group grid grid-cols-[96px,1fr] gap-3 p-3 items-start">
              <div class="relative w-24 h-16 overflow-hidden rounded border border-zinc-200 bg-zinc-100">
                <img src="{{ $tThumb }}" alt="{{ $b->judul }}"
                     class="absolute inset-0 w-full h-full object-cover transition-transform duration-300 group-hover:scale-[1.02]"
                     loading="lazy">
              </div>
              <div class="min-w-0">
                <p class="text-[13px] font-semibold text-zinc-800 leading-snug line-clamp-2
                           bg-gradient-to-r from-current to-current bg-no-repeat bg-left-bottom
                           bg-[length:0%_1px] transition-[background-size] duration-300
                           group-hover:bg-[length:100%_1px]">
                  {{ $b->judul }}
                </p>
                <p class="mt-0.5 text-[11px] text-zinc-500">
                  <span class="uppercase font-semibold">{{ $b->kategori ?? 'Kegiatan' }}</span>
                  — <time datetime="{{ optional($b->published_at)?->format('Y-m-d') }}">{{ $tDate ?: '—' }}</time>
                </p>
              </div>
            </a>
          </li>
        @endforeach
      </ul>
    </section>
  @endif
</div>

@endsection
