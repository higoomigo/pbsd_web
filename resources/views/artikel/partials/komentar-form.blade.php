{{-- Form Komentar --}}
<div class="bg-white p-6 mb-6">
    <h4 class="text-lg font-title text-zinc-800 mb-4">
        Tambah Komentar
        @guest
        <span class="text-sm font-normal text-zinc-500">(Data Anda akan dijaga kerahasiaannya)</span>
        @endguest
    </h4>
    
    @if(session('success'))
        <div class="mb-4 p-4 bg-green-50 border border-green-200">
            <div class="flex items-center">
                <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span class="text-green-700">{{ session('success') }}</span>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="mb-4 p-4 bg-red-50 border border-red-200">
            <div class="flex items-center">
                <svg class="w-5 h-5 text-red-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span class="text-red-700">{{ session('error') }}</span>
            </div>
        </div>
    @endif

    <form action="{{ route('komentar.store', $artikel->slug) }}" method="POST">
        @csrf
        
        @guest
        <div class="grid md:grid-cols-2 gap-4 mb-4">
            <div>
                <label for="nama" class="block text-sm font-medium text-zinc-700 mb-1">
                    Nama <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       id="nama" 
                       name="nama" 
                       value="{{ old('nama') }}"
                       required
                       class="w-full px-3 py-2  border-zinc-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('nama') border-red-500 @enderror">
                @error('nama')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            <div>
                <label for="email" class="block text-sm font-medium text-zinc-700 mb-1">
                    Email <span class="text-red-500">*</span>
                </label>
                <input type="email" 
                       id="email" 
                       name="email" 
                       value="{{ old('email') }}"
                       required
                       class="w-full px-3 py-2 border-zinc-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('email') border-red-500 @enderror">
                @error('email')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>
        @endguest

        <div class="mb-4">
            {{-- <label for="konten" class="block text-sm font-medium text-zinc-700 mb-1">
                Komentar <span class="text-red-500">*</span>
            </label> --}}
            <textarea id="konten" 
                      name="konten" 
                      rows="4" 
                      required
                      placeholder="Tulis komentar Anda di sini..."
                      class="w-full px-3 py-2  border-zinc-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('konten') border- border-red-500 @enderror">{{ old('konten') }}</textarea>
            @error('konten')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
            <p class="mt-1 text-sm text-zinc-500">
                Komentar maksimal 1000 karakter. 
                @guest
                Komentar dari tamu akan ditampilkan setelah disetujui admin.
                @endguest
            </p>
        </div>

        <div class="flex justify-end">
            <button type="submit" 
                    class="px-6 py-2 bg-blue-600 text-white font-medium hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors">
                <div class="flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                    </svg>
                    Kirim Komentar
                </div>
            </button>
        </div>
    </form>
</div>