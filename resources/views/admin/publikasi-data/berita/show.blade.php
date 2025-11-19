{{-- resources/views/admin/berita/show.blade.php --}}
<x-app-layout>
  <x-slot name="header">
    <div class="flex items-center justify-between gap-4">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Menu Berita') }} — Lihat Berita
      </h2>

      {{-- Kembali --}}
      <button type="button"
              class="inline-flex items-center gap-2 px-3 py-2 rounded-md border text-zinc-700 bg-zinc-50 hover:bg-white"
              onclick="(document.referrer ? history.back() : (window.location='{{ route('admin.publikasi-data.berita.index') }}'))">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M15 18l-6-6 6-6"/></svg>
        Kembali
      </button>
    </div>
  </x-slot>

  <div class="py-10">
    <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white shadow-sm sm:rounded-lg p-6 space-y-6">

        {{-- Judul + Meta --}}
        <div>
          <h1 class="text-2xl md:text-3xl font-bold text-zinc-900">{{ $berita->judul }}</h1>

          @php
            $tgl = optional($berita->published_at)->format('d M Y');
            $statusVal = $berita->status ?? ($berita->published_at ? 'Terbit' : 'Draft');
            $statusCls = $statusVal === 'Terbit' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-700';
            $authorName = optional($berita->author)->name ?? ($berita->penulis ?? '-');
          @endphp

          <div class="mt-2 flex flex-col md:flex-row md:items-center gap-2 text-sm text-zinc-600">
            <div class="flex items-center gap-2">
              <span class="inline-flex items-center px-2 py-0.5 rounded bg-zinc-100 text-zinc-700">
                {{ $berita->kategori ?? '—' }}
              </span>
              <span class="inline-flex items-center px-2 py-0.5 rounded {{ $statusCls }}">
                {{ $statusVal }}
              </span>
            </div>
            <div class="md:ml-3">Terbit: <span class="font-medium">{{ $tgl ?: '—' }}</span></div>
            <div class="md:ml-3">Penulis: <span class="font-medium">{{ $authorName }}</span></div>
          </div>
        </div>

        {{-- Thumbnail --}}
        <div class="border rounded-md overflow-hidden">
          <div class="aspect-[16/9] bg-zinc-100 flex items-center justify-center">
            @if($berita->thumbnail_path)
              <img src="{{ Storage::url($berita->thumbnail_path) }}"
                   alt="{{ $berita->judul }}" class="w-full h-full object-cover">
            @else
              <div class="text-xs text-zinc-500">Tidak ada gambar</div>
            @endif
          </div>
        </div>

        {{-- Ringkasan (opsional) --}}
        @if(!empty($berita->ringkasan))
          <div class="p-4 rounded-md bg-zinc-50 border text-zinc-700">
            <p class="text-sm leading-relaxed">{{ $berita->ringkasan }}</p>
          </div>
        @endif

        {{-- Konten --}}
        <article class="prose max-w-none prose-zinc text-zinc-800">
          {!! $berita->konten !!}
        </article>

        {{-- Tag --}}
        @php $tags = $berita->tags_array ?? []; @endphp
        @if(count($tags))
          <div class="pt-2">
            <div class="text-sm text-zinc-500 mb-2">Tag:</div>
            <div class="flex flex-wrap gap-2">
              @foreach($tags as $t)
                <span class="inline-flex items-center px-2 py-0.5 rounded-full bg-indigo-50 text-indigo-700 text-xs">
                  # {{ $t }}
                </span>
              @endforeach
            </div>
          </div>
        @endif

        {{-- Aksi --}}
        <div class="pt-4 flex items-center justify-between">
          <div class="text-xs text-zinc-400">
            Dibuat: {{ optional($berita->created_at)->format('d M Y H:i') }} —
            Diperbarui: {{ optional($berita->updated_at)->format('d M Y H:i') }}
          </div>
          <div class="flex items-center gap-2">
            <a href="{{ route('admin.publikasi-data.berita.edit', $berita->id) }}"
               class="px-3 py-2 rounded-md border text-zinc-700 hover:bg-gray-50">Edit</a>

            <form action="{{ route('admin.publikasi-data.berita.destroy', $berita->id) }}"
                  method="POST" onsubmit="return confirm('Hapus berita ini?');">
              @csrf @method('DELETE')
              <button type="submit" class="px-3 py-2 rounded-md border text-red-700 hover:bg-red-50">Hapus</button>
            </form>
          </div>
        </div>

      </div>
    </div>
  </div>

  @push('head')
    {{-- Optional: gaya untuk konten HTML --}}
    <style>
      .prose img{border-radius:.5rem;}
      .prose h2,.prose h3{scroll-margin-top:6rem;}
      .prose a{ text-decoration: underline; }
    </style>
  @endpush
</x-app-layout>
