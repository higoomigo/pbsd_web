@extends('layout-web.app')

@section('title', $artikel->judul . ' — Pusat Studi')

@section('content')
<div class="py-8">
  <div class="w-full lg:px-10 xl:px-56">

    {{-- Breadcrumb --}}
    <nav class="mb-6">
      <ol class="flex items-center space-x-2 text-sm text-zinc-500">
        <li>
          <a href="{{ route('guest.artikel.index') }}" class="hover:text-zinc-700 transition-colors">
            Artikel
          </a>
        </li>
        <li>
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
          </svg>
        </li>
        <li class="text-zinc-400 line-clamp-1">{{ Str::limit($artikel->judul, 50) }}</li>
      </ol>
    </nav>

    {{-- Header Artikel --}}
    <article class="bg-white">
        <p class="w-full font-title text-4xl align-middle my-6">{{ $artikel->judul }}</p>
      
      {{-- Meta Info --}}
      <div class="mb-6">
        <div class="flex flex-wrap items-center gap-4 text-sm text-zinc-500 mb-3">
          {{-- Kategori --}}
          @if($artikel->kategori)
          <span class="inline-flex items-center px-3 py-1 bg-zinc-100 text-zinc-700 rounded-full text-xs font-medium">
            {{ $artikel->kategori }}
          </span>
          @endif

          {{-- Tanggal Publikasi --}}
          @if($artikel->published_at)
          <time datetime="{{ $artikel->published_at->format('Y-m-d') }}" class="flex items-center">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            {{ $artikel->published_at->translatedFormat('d F Y') }}
          </time>
          @endif

          {{-- Penulis --}}
          @if($artikel->penulis || optional($artikel->author)->name)
          <span class="flex items-center">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
            </svg>
            {{ $artikel->penulis ?: optional($artikel->author)->name }}
          </span>
          @endif

          {{-- Jumlah Komentar --}}
          <span class="flex items-center">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
            </svg>
            {{ $artikel->jumlah_komentar }} Komentar
          </span>
        </div>

        {{-- Tags --}}
        @if($artikel->tag)
          @php
            $tags = collect(explode(',', $artikel->tag))
                      ->map(fn($t) => trim($t))
                      ->filter()
                      ->take(10);
          @endphp
          @if($tags->isNotEmpty())
            <div class="flex flex-wrap gap-2">
              @foreach($tags as $tag)
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs bg-zinc-100 text-zinc-700">
                  #{{ $tag }}
                </span>
              @endforeach
            </div>
          @endif
        @endif
      </div>

      {{-- Thumbnail --}}
      @if($artikel->thumbnail_path)
        <div class="mb-8">
          <img 
            src="{{ Storage::url($artikel->thumbnail_path) }}" 
            alt="{{ $artikel->judul }}"
            class="w-full h-auto max-h-96 object-cover rounded-lg shadow-sm"
            loading="lazy"
          >
        </div>
      @endif

      {{-- Ringkasan --}}
      @if($artikel->ringkasan)
        <div class="mb-8 p-4 bg-blue-50 border-l-4 border-blue-500 rounded">
          <p class="text-blue-800 text-sm leading-relaxed">
            {{ $artikel->ringkasan }}
          </p>
        </div>
      @endif

      {{-- Konten Artikel --}}
      <div class="prose prose-zinc max-w-none">
        @if($artikel->konten)
          {!! $artikel->konten !!}
        @else
          <div class="text-center py-12 text-zinc-500">
            <svg class="w-16 h-16 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            <p>Konten artikel sedang dalam proses penyusunan.</p>
          </div>
        @endif
      </div>

      <div class="mt-12 pt-8 border-t border-zinc-200">
  <div class="flex items-center justify-between">
    <div class="text-sm text-zinc-500">
      Bagikan artikel ini:
    </div>
    <div class="flex items-center space-x-3">
      {{-- Facebook --}}
      <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" 
         target="_blank"
         class="p-2 text-blue-600 hover:bg-blue-50 rounded-full transition-colors"
         title="Share ke Facebook">
        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
          <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
        </svg>
      </a>

      {{-- Twitter/X --}}
      <a href="https://twitter.com/intent/tweet?text={{ urlencode($artikel->judul) }}&url={{ urlencode(url()->current()) }}" 
         target="_blank"
         class="p-2 text-black hover:bg-gray-100 rounded-full transition-colors"
         title="Share ke Twitter/X">
        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
          <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
        </svg>
      </a>

      {{-- LinkedIn --}}
      <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(url()->current()) }}" 
         target="_blank"
         class="p-2 text-blue-700 hover:bg-blue-50 rounded-full transition-colors"
         title="Share ke LinkedIn">
        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
          <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
        </svg>
      </a>

      {{-- WhatsApp --}}
      <a href="https://api.whatsapp.com/send?text={{ urlencode($artikel->judul . ' ' . url()->current()) }}" 
         target="_blank"
         class="p-2 text-green-600 hover:bg-green-50 rounded-full transition-colors"
         title="Share ke WhatsApp">
        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
          <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.76.982.998-3.677-.236-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.9 6.994c-.004 5.45-4.438 9.88-9.888 9.88m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.333.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.333 11.893-11.893 0-3.18-1.24-6.162-3.495-8.411"/>
        </svg>
      </a>

      {{-- Telegram --}}
      <a href="https://t.me/share/url?url={{ urlencode(url()->current()) }}&text={{ urlencode($artikel->judul) }}" 
         target="_blank"
         class="p-2 text-blue-500 hover:bg-blue-50 rounded-full transition-colors"
         title="Share ke Telegram">
        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
          <path d="M11.944 0A12 12 0 0 0 0 12a12 12 0 0 0 12 12 12 12 0 0 0 12-12A12 12 0 0 0 12 0a12 12 0 0 0-.056 0zm4.962 7.224c.1-.002.321.023.465.14a.506.506 0 0 1 .171.325c.016.093.036.306.02.472-.18 1.898-.962 6.502-1.36 8.627-.168.9-.499 1.201-.82 1.23-.696.065-1.225-.46-1.9-.902-1.056-.693-1.653-1.124-2.678-1.8-1.185-.78-.417-1.21.258-1.91.177-.184 3.247-2.977 3.307-3.23.007-.032.014-.15-.056-.212s-.174-.041-.249-.024c-.106.024-1.793 1.14-5.061 3.345-.48.33-.913.49-1.302.48-.428-.008-1.252-.241-1.865-.44-.752-.245-1.349-.374-1.297-.789.027-.216.325-.437.893-.663 3.498-1.524 5.83-2.529 6.998-3.014 3.332-1.386 4.025-1.627 4.476-1.635z"/>
        </svg>
      </a>

      {{-- Copy Link --}}
      <button onclick="copyArticleLink()"
              class="p-2 text-zinc-600 hover:bg-zinc-100 rounded-full transition-colors"
              title="Salin link">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
        </svg>
      </button>
    </div>
  </div>
</div>
    </article>

    

    {{-- BAGIAN KOMENTAR --}}
    <div class="mt-12 pt-8 border-t border-zinc-200">
      <h3 class="text-xl font-title text-zinc-800 mb-6">
        Komentar ({{ $artikel->jumlah_komentar }})
      </h3>
      
      {{-- Daftar Komentar --}}
      @include('artikel.partials.komentar-list')
      
      {{-- Form Komentar --}}
      @include('artikel.partials.komentar-form')
    </div>

    {{-- Navigasi Artikel --}}
    @if($previousArticle || $nextArticle)
      <div class="mt-12 pt-8 border-t border-zinc-200">
        <div class="grid md:grid-cols-2 gap-6">
          {{-- Artikel Sebelumnya --}}
          @if($previousArticle)
            <a href="{{ route('guest.artikel.show', $previousArticle->slug) }}" 
               class="group p-4 border border-zinc-200 rounded-lg hover:border-zinc-300 transition-colors">
              <div class="flex items-center mb-2">
                <svg class="w-4 h-4 mr-2 text-zinc-400 group-hover:text-zinc-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                <span class="text-sm text-zinc-500 group-hover:text-zinc-700">Artikel Sebelumnya</span>
              </div>
              <h3 class="text-zinc-800 font-medium line-clamp-2 group-hover:text-zinc-900">
                {{ $previousArticle->judul }}
              </h3>
            </a>
          @else
            <div></div>
          @endif

          {{-- Artikel Selanjutnya --}}
          @if($nextArticle)
            <a href="{{ route('guest.artikel.show', $nextArticle->slug) }}" 
               class="group p-4 border border-zinc-200 rounded-lg hover:border-zinc-300 transition-colors text-right">
              <div class="flex items-center justify-end mb-2">
                <span class="text-sm text-zinc-500 group-hover:text-zinc-700">Artikel Selanjutnya</span>
                <svg class="w-4 h-4 ml-2 text-zinc-400 group-hover:text-zinc-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
              </div>
              <h3 class="text-zinc-800 font-medium line-clamp-2 group-hover:text-zinc-900">
                {{ $nextArticle->judul }}
              </h3>
            </a>
          @endif
        </div>
      </div>
    @endif
  </div>
</div>
@endsection

@push('scripts')
<script>
function copyArticleLink() {
  const url = window.location.href;
  
  navigator.clipboard.writeText(url).then(function() {
    const button = event.target.closest('button');
    const originalHTML = button.innerHTML;
    
    button.innerHTML = `
      <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
      </svg>
    `;
    
    setTimeout(() => {
      button.innerHTML = originalHTML;
    }, 2000);
  }).catch(function(err) {
    alert('Gagal menyalin link: ' + err);
  });
}

// Reading progress indicator
document.addEventListener('DOMContentLoaded', function() {
  const progressBar = document.createElement('div');
  progressBar.className = 'fixed top-0 left-0 w-0 h-1 bg-blue-500 z-50 transition-all duration-100';
  document.body.appendChild(progressBar);

  window.addEventListener('scroll', function() {
    const winHeight = window.innerHeight;
    const docHeight = document.documentElement.scrollHeight;
    const scrollTop = window.pageYOffset;
    const progress = (scrollTop / (docHeight - winHeight)) * 100;
    
    progressBar.style.width = progress + '%';
  });
});

// Reply form toggle
function showReplyForm(komentarId) {
  const form = document.getElementById('reply-form-' + komentarId);
  if (form) {
    form.classList.remove('hidden');
    const textarea = form.querySelector('textarea');
    if (textarea) textarea.focus();
  }
}

function hideReplyForm(komentarId) {
  const form = document.getElementById('reply-form-' + komentarId);
  if (form) form.classList.add('hidden');
}

function copyArticleLink() {
  const url = window.location.href;
  
  navigator.clipboard.writeText(url).then(function() {
      // Show success feedback
      const button = event.target.closest('button');
      const originalHTML = button.innerHTML;
      
      button.innerHTML = `
        <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
        </svg>
      `;
      
      setTimeout(() => {
        button.innerHTML = originalHTML;
      }, 2000);
    }).catch(function(err) {
      alert('Gagal menyalin link: ' + err);
    });
  }
</script>
@endpush

@php
// Helper function untuk menghitung waktu baca
if (!function_exists('calculateReadingTime')) {
    function calculateReadingTime($content, $wordsPerMinute = 200) {
        $wordCount = str_word_count(strip_tags($content));
        return max(1, ceil($wordCount / $wordsPerMinute));
    }
}


@endphp