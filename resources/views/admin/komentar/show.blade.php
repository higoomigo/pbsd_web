<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      {{ __('Detail Komentar') }}
    </h2>
  </x-slot>

  <div class="py-12" data-theme="light">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden">
        
        {{-- Header --}}
        <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
          <div class="flex items-center justify-between">
            <h3 class="text-lg font-medium text-gray-900">
              Detail Komentar
            </h3>
            <div class="flex items-center space-x-2">
              <a href="{{ route('admin.publikasi-data.komentar.index') }}" 
                 class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Kembali
              </a>
              
              @if(!$komentar->is_approved)
              <form action="{{ route('admin.publikasi-data.komentar.approve', $komentar) }}" 
                    method="POST">
                @csrf
                <button type="submit" 
                        class="inline-flex items-center px-3 py-2 border border-transparent shadow-sm text-sm leading-4 font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500"
                        onclick="return confirm('Setujui komentar ini?')">
                  <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                  </svg>
                  Setujui
                </button>
              </form>
              @endif
              
              <form action="{{ route('admin.publikasi-data.komentar.reject', $komentar) }}" 
                    method="POST">
                @csrf
                <button type="submit" 
                        class="inline-flex items-center px-3 py-2 border border-transparent shadow-sm text-sm leading-4 font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"
                        onclick="return confirm('Tolak dan hapus komentar ini?')">
                  <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                  </svg>
                  Tolak
                </button>
              </form>
            </div>
          </div>
        </div>
        
        {{-- Content --}}
        <div class="px-6 py-8">
          {{-- Status Badge --}}
          <div class="mb-6">
            @if($komentar->is_approved)
              <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                Telah Disetujui
              </span>
            @else
              <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Menunggu Persetujuan
              </span>
            @endif
            
            @if($komentar->parent_id)
              <span class="ml-2 inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/>
                </svg>
                Balasan
              </span>
            @endif
          </div>
          
          {{-- Informasi Penulis --}}
          <div class="mb-8">
            <h4 class="text-sm font-medium text-gray-500 mb-2">INFORMASI PENULIS</h4>
            <div class="bg-gray-50 rounded-lg p-4">
              <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                  <p class="text-sm text-gray-500">Nama</p>
                  <p class="font-medium text-gray-900">{{ $komentar->nama_komentar }}</p>
                </div>
                
                @if($komentar->email_komentar)
                <div>
                  <p class="text-sm text-gray-500">Email</p>
                  <p class="font-medium text-gray-900">{{ $komentar->email_komentar }}</p>
                </div>
                @endif
                
                @if($komentar->user)
                <div>
                  <p class="text-sm text-gray-500">Status</p>
                  <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                    User Terdaftar
                  </span>
                </div>
                @else
                <div>
                  <p class="text-sm text-gray-500">Status</p>
                  <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                    Tamu
                  </span>
                </div>
                @endif
                
                <div>
                  <p class="text-sm text-gray-500">Tanggal Kirim</p>
                  <p class="font-medium text-gray-900">{{ $komentar->tanggal_lengkap }}</p>
                </div>
              </div>
            </div>
          </div>
          
          {{-- Isi Komentar --}}
          <div class="mb-8">
            <h4 class="text-sm font-medium text-gray-500 mb-2">ISI KOMENTAR</h4>
            <div class="bg-white border border-gray-200 rounded-lg p-6">
              <div class="prose prose-sm max-w-none">
                {{ nl2br(e($komentar->konten)) }}
              </div>
            </div>
          </div>
          
          {{-- Informasi Artikel --}}
          <div class="mb-8">
            <h4 class="text-sm font-medium text-gray-500 mb-2">ARTIKEL TERKAIT</h4>
            <div class="bg-gray-50 rounded-lg p-4">
              <div class="flex items-start">
                <div class="flex-shrink-0 h-12 w-12 bg-gray-200 rounded overflow-hidden mr-4">
                  @if($komentar->artikel->thumbnail_path)
                    <img src="{{ Storage::url($komentar->artikel->thumbnail_path) }}" 
                         alt="{{ $komentar->artikel->judul }}" 
                         class="h-full w-full object-cover">
                  @else
                    <div class="h-full w-full flex items-center justify-center bg-gray-300">
                      <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                      </svg>
                    </div>
                  @endif
                </div>
                <div>
                  <h5 class="font-medium text-gray-900">
                    <a href="{{ route('guest.artikel.show', $komentar->artikel->slug) }}" 
                       target="_blank"
                       class="hover:text-indigo-600 hover:underline">
                      {{ $komentar->artikel->judul }}
                    </a>
                  </h5>
                  <p class="text-sm text-gray-500 mt-1">
                    Diterbitkan: {{ $komentar->artikel->published_at ? $komentar->artikel->published_at->translatedFormat('d F Y') : 'Belum diterbitkan' }}
                  </p>
                  <p class="text-sm text-gray-500">
                    Kategori: {{ $komentar->artikel->kategori ?? 'Tidak ada kategori' }}
                  </p>
                </div>
              </div>
            </div>
          </div>
          
          {{-- Informasi Parent Komentar (jika ada) --}}
          @if($komentar->parent)
          <div class="mb-8">
            <h4 class="text-sm font-medium text-gray-500 mb-2">BALASAN UNTUK</h4>
            <div class="bg-blue-50 border border-blue-100 rounded-lg p-4">
              <div class="flex">
                <div class="flex-shrink-0 mr-4">
                  <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center">
                    <span class="text-blue-600 font-medium">
                      {{ strtoupper(substr($komentar->parent->nama_komentar, 0, 1)) }}
                    </span>
                  </div>
                </div>
                <div class="flex-grow">
                  <div class="flex justify-between items-start mb-2">
                    <div>
                      <h5 class="font-medium text-gray-900">
                        {{ $komentar->parent->nama_komentar }}
                        @if($komentar->parent->user)
                          <span class="ml-2 text-xs text-blue-600">(Member)</span>
                        @endif
                      </h5>
                      <p class="text-xs text-gray-500">
                        {{ $komentar->parent->created_at->format('d/m/Y H:i') }}
                      </p>
                    </div>
                    <span class="text-xs font-medium text-blue-600 bg-blue-100 px-2 py-1 rounded">
                      Komentar Utama
                    </span>
                  </div>
                  <div class="text-sm text-gray-700 bg-white p-3 rounded border">
                    {{ Str::limit($komentar->parent->konten, 200) }}
                  </div>
                </div>
              </div>
            </div>
          </div>
          @endif
          
          {{-- Informasi Replies (jika ada) --}}
          @if($komentar->approvedReplies->count() > 0)
          <div class="mb-8">
            <h4 class="text-sm font-medium text-gray-500 mb-2">
              BALASAN ({{ $komentar->approvedReplies->count() }})
            </h4>
            <div class="space-y-4">
              @foreach($komentar->approvedReplies as $reply)
              <div class="bg-gray-50 rounded-lg p-4 border border-gray-100">
                <div class="flex">
                  <div class="flex-shrink-0 mr-4">
                    <div class="h-8 w-8 rounded-full bg-gray-200 flex items-center justify-center text-xs">
                      {{ strtoupper(substr($reply->nama_komentar, 0, 1)) }}
                    </div>
                  </div>
                  <div class="flex-grow">
                    <div class="flex justify-between items-start mb-1">
                      <h6 class="text-sm font-medium text-gray-900">
                        {{ $reply->nama_komentar }}
                      </h6>
                      <span class="text-xs text-gray-500">
                        {{ $reply->created_at->format('d/m/Y H:i') }}
                      </span>
                    </div>
                    <p class="text-sm text-gray-600">
                      {{ Str::limit($reply->konten, 150) }}
                    </p>
                  </div>
                </div>
              </div>
              @endforeach
            </div>
          </div>
          @endif
          
        </div>
        
      </div>
    </div>
  </div>
</x-app-layout>