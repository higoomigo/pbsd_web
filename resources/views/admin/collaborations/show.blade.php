<x-app-layout>
  <x-slot name="header">
    <div class="flex items-center justify-between">
      <div>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          {{ __('Detail Proposal Kolaborasi') }}
        </h2>
        <p class="text-sm text-gray-600 mt-1">ID: #{{ $collaboration->id }}</p>
      </div>
      <div class="flex gap-2">
        <a href="{{ route('admin.kontak.index') }}"
           class="px-4 py-2 rounded-md bg-gray-600 text-white hover:bg-gray-700 text-sm flex items-center gap-2">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
          </svg>
          Kembali
        </a>
      </div>
    </div>
  </x-slot>

  <div class="py-12" data-theme="light">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden">
        
        {{-- Header Card --}}
        <div class="bg-gradient-to-r from-indigo-500 to-purple-600 p-6 text-white">
          <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
              <div class="h-16 w-16 rounded-full bg-white/20 flex items-center justify-center text-white text-2xl font-bold">
                {{ strtoupper(substr($collaboration->name, 0, 1)) }}
              </div>
              <div>
                <h1 class="text-2xl font-bold">{{ $collaboration->name }}</h1>
                <p class="text-indigo-100">{{ $collaboration->institution }}</p>
              </div>
            </div>
            
            @php
              $collab_type_color = [
                'Penelitian Bersama' => 'bg-blue-500',
                'Konsultasi Akademik' => 'bg-purple-500',
                'Kemitraan Industri' => 'bg-green-500',
                'Program Magang' => 'bg-amber-500',
                'Lainnya' => 'bg-gray-500',
              ][$collaboration->collaboration_type] ?? 'bg-gray-500';
            @endphp
            <span class="px-4 py-2 rounded-full text-sm font-medium {{ $collab_type_color }} text-white">
              {{ $collaboration->collaboration_type }}
            </span>
          </div>
        </div>
        
        {{-- Content --}}
        <div class="p-6">
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            {{-- Kolom Kiri --}}
            <div class="space-y-4">
              <div class="bg-gray-50 rounded-lg p-4">
                <h3 class="text-sm font-medium text-gray-500 mb-1">Informasi Kontak</h3>
                <div class="space-y-2">
                  <div class="flex items-center gap-2">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    <a href="mailto:{{ $collaboration->email }}" class="text-blue-600 hover:underline">
                      {{ $collaboration->email }}
                    </a>
                  </div>
                  
                  <div class="flex items-center gap-2">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span class="text-gray-700">
                      Dikirim: {{ $collaboration->created_at->format('d F Y, H:i') }}
                    </span>
                  </div>
                  
                  <div class="flex items-center gap-2">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span class="text-gray-700">
                      {{ $collaboration->created_at->diffForHumans() }}
                    </span>
                  </div>
                </div>
              </div>
              
              <div class="bg-gray-50 rounded-lg p-4">
                <h3 class="text-sm font-medium text-gray-500 mb-1">Institusi</h3>
                <p class="text-gray-800 font-medium">{{ $collaboration->institution }}</p>
              </div>
            </div>
            
            {{-- Kolom Kanan --}}
            <div class="space-y-4">
              <div class="bg-gray-50 rounded-lg p-4">
                <h3 class="text-sm font-medium text-gray-500 mb-1">Jenis Kolaborasi</h3>
                <p class="text-gray-800 font-medium">{{ $collaboration->collaboration_type }}</p>
              </div>
              
              <div class="bg-gray-50 rounded-lg p-4">
                <h3 class="text-sm font-medium text-gray-500 mb-1">Status</h3>
                <div class="flex items-center gap-2">
                  <div class="h-3 w-3 rounded-full bg-green-500"></div>
                  <span class="text-gray-800 font-medium">Baru Diterima</span>
                </div>
              </div>
            </div>
          </div>
          
          {{-- Pesan --}}
          <div class="border-t pt-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Pesan Proposal</h3>
            <div class="bg-gray-50 rounded-lg p-6">
              <div class="prose max-w-none">
                {!! nl2br(e($collaboration->message)) !!}
              </div>
            </div>
          </div>
          
          {{-- Action Buttons --}}
          <div class="border-t pt-6 mt-6 flex flex-wrap gap-3">
            {{-- <a href="https://wa.me/62{{ substr($collaboration->phone ?? '81234567890', 1) }}?text=Halo%20{{ urlencode($collaboration->name) }},%20kami%20menerima%20proposal%20kolaborasi%20Anda.%0A%0ADari:%20{{ urlencode($collaboration->institution) }}%0AEmail:%20{{ urlencode($collaboration->email) }}%0A%0ATerima%20kasih%20atas%20minat%20Anda%20untuk%20berkolaborasi."
               target="_blank"
               class="inline-flex items-center gap-2 px-5 py-2.5 rounded-md bg-green-600 text-white hover:bg-green-700 text-sm font-medium">
              <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.76.982.998-3.675-.236-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.9 6.994c-.004 5.45-4.437 9.88-9.885 9.88m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.333.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.333 11.893-11.893 0-3.18-1.24-6.162-3.495-8.411"/>
              </svg>
              Balas via WhatsApp
            </a> --}}
            
            <a href="mailto:{{ $collaboration->email }}?subject=Balasan%20Proposal%20Kolaborasi&body=Halo%20{{ urlencode($collaboration->name) }},%0A%0ATerima%20kasih%20atas%20proposal%20kolaborasi%20yang%20telah%20Anda%20kirimkan.%0A%0ADari:%20{{ urlencode($collaboration->institution) }}%0AEmail:%20{{ $collaboration->email }}%0A%0AKami%20akan%20meninjau%20proposal%20Anda%20dan%20menghubungi%20Anda%20kembali%20dalam%20waktu%20dekat.%0A%0ASalam%20hangat,"
               class="inline-flex items-center gap-2 px-5 py-2.5 rounded-md bg-blue-600 text-white hover:bg-blue-700 text-sm font-medium">
              <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
              </svg>
              Balas via Email
            </a>
            
            <form action="{{ route('admin.kontak.destroy', $collaboration->id) }}" 
                  method="POST" class="inline" onsubmit="return confirm('Hapus data ini?');">
              @csrf @method('DELETE')
              <button type="submit"
                      class="inline-flex items-center gap-2 px-5 py-2.5 rounded-md bg-red-600 text-white hover:bg-red-700 text-sm font-medium">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
                Hapus Data
              </button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</x-app-layout>