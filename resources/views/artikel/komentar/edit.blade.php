@extends('layout-web.app')

@section('title', 'Edit Komentar — Pusat Studi')

@section('content')
<div class="py-8">
  <div class="w-full lg:px-10 xl:px-56">
    
    {{-- Breadcrumb --}}
    <nav class="mb-6">
      <ol class="flex items-center space-x-2 text-sm text-zinc-500">
        <li>
          <a href="{{ route('guest.artikel.show', $artikel->slug) }}" class="hover:text-zinc-700 transition-colors">
            {{ Str::limit($artikel->judul, 40) }}
          </a>
        </li>
        <li>
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
          </svg>
        </li>
        <li class="text-zinc-400">Edit Komentar</li>
      </ol>
    </nav>

    <div class="bg-white rounded-lg border border-zinc-200 p-6">
      <h1 class="text-xl font-semibold text-zinc-800 mb-6">Edit Komentar</h1>
      
      <form action="{{ route('komentar.update', ['artikel' => $artikel->slug, 'komentar' => $komentar]) }}" 
            method="POST">
        @csrf
        @method('PUT')
        
        <div class="mb-4">
          <label for="konten" class="block text-sm font-medium text-zinc-700 mb-2">
            Komentar Anda
          </label>
          <textarea id="konten" 
                    name="konten" 
                    rows="6" 
                    required
                    class="w-full px-3 py-2 border border-zinc-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('konten') border-red-500 @enderror">{{ old('konten', $komentar->konten) }}</textarea>
          @error('konten')
              <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
          @enderror
          <p class="mt-2 text-sm text-zinc-500">
            Anda hanya dapat mengedit komentar dalam 30 menit setelah dibuat.
          </p>
        </div>
        
        <div class="flex justify-end space-x-3">
          <a href="{{ route('guest.artikel.show', $artikel->slug) }}" 
             class="px-4 py-2 border border-zinc-300 text-zinc-700 rounded-md hover:bg-zinc-50 transition-colors">
            Batal
          </a>
          <button type="submit" 
                  class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors">
            Simpan Perubahan
          </button>
        </div>
      </form>
    </div>
    
  </div>
</div>
@endsection