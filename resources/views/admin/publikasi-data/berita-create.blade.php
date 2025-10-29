<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Menu Publikasi dan Data  ') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if(session('success'))
                        <div class="mb-4 text-green-600">{{ session('success') }}</div>
                    @endif

                    <h3 class="text-lg text-zinc-700 font-semibold mb-4">Tambah Berita</h3>

                    <form id="beritaForm" action="{{ route('berita.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                        @csrf

                        <div>
                            <label for="judul" class="block text-sm font-medium text-gray-700">Judul</label>
                            <input id="judul" name="judul" value="{{ old('judul') }}" required
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" />
                            @error('judul') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="author" class="block text-sm font-medium text-gray-700">Penulis</label>
                            <input id="author" name="author" value="{{ old('author') }}"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" />
                            @error('author') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="tanggal" class="block text-sm font-medium text-gray-700">Tanggal</label>
                            <input id="tanggal" name="tanggal" type="date" value="{{ old('tanggal') ?? now()->format('Y-m-d') }}"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" />
                            @error('tanggal') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="gambar" class="block text-sm font-medium text-gray-700">Gambar (opsional)</label>
                            <input id="gambar" name="gambar" type="file" accept="image/*"
                                class="mt-1 block w-full text-sm text-gray-600" />
                            @error('gambar') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="konten" class="block text-sm font-medium text-gray-700">Konten</label>
                            <textarea id="konten" name="konten" rows="8" required
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">{{ old('konten') }}</textarea>
                            @error('konten') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="flex items-center gap-4">
                            <input type="hidden" name="is_published" value="0" />
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="is_published" value="1" {{ old('is_published') ? 'checked' : '' }}
                                    class="form-checkbox h-4 w-4 text-indigo-600" />
                                <span class="ml-2 text-sm text-gray-700">Publikasikan sekarang</span>
                            </label>
                        </div>

                        <div class="flex items-center gap-2">
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded flex items-center gap-2">
                                <!-- Save icon -->
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                Simpan
                            </button>

                            {{-- Back / Cancel with UX: visible icon, route fallback, and unsaved-changes confirmation --}}
                            @if(Route::has('admin.publikasi-data.index'))
                                <a id="backButton" href="{{ route('admin.publikasi-data.index') }}" aria-label="Kembali"
                                   class="px-4 py-2 bg-gray-100 text-gray-800 rounded flex items-center gap-2 hover:bg-gray-200">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                                    </svg>
                                    Kembali
                                </a>
                            @else
                                <button id="backButton" type="button" onclick="history.back()" aria-label="Kembali"
                                    class="px-4 py-2 bg-gray-100 text-gray-800 rounded flex items-center gap-2 hover:bg-gray-200">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                                    </svg>
                                    Kembali
                                </button>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Unsaved changes guard: warn user if form is dirty before navigating away --}}
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('beritaForm');
        if (!form) return;

        let isDirty = false;
        const inputs = form.querySelectorAll('input, textarea, select');
        inputs.forEach(i => i.addEventListener('input', () => isDirty = true));

        // Warn on page unload
        window.addEventListener('beforeunload', function (e) {
            if (!isDirty) return;
            e.preventDefault();
            e.returnValue = '';
        });

        // Intercept back button clicks to confirm if dirty
        const backBtn = document.getElementById('backButton');
        if (backBtn) {
            backBtn.addEventListener('click', function (e) {
                if (!isDirty) return;
                const confirmed = confirm('Anda memiliki perubahan yang belum disimpan. Yakin ingin kembali?');
                if (!confirmed) e.preventDefault();
            });
        }
    });
    </script>
</x-app-layout>
