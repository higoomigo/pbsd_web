{{-- resources/views/admin/struktur/edit.blade.php --}}
<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      {{ __('Menu Profil — Edit Struktur Organisasi') }}
    </h2>
  </x-slot>

  <div class="py-8">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 " data-theme="light">
      <div class="overflow-hidden group shadow-sm sm:rounded-lg hover:shadow-md transition-shadow bg-white p-6">
        <div class="flex items-center justify-between mb-4">
          <p class="font-semibold text-zinc-900 text-lg">Edit Struktur Organisasi</p>
        </div>

        @if(session('success'))
          <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
            {{ session('success') }}
          </div>
        @endif

        @if ($errors->any())
          <div class="mb-4 p-3 bg-red-100 text-red-800 rounded">
            <ul class="list-disc pl-5">
              @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif

        {{-- $struktur diasumsikan dikirim dari controller --}}
        <form action="{{ route('admin.profil.struktur.update', $struktur->id) }}"
              method="POST"
              enctype="multipart/form-data"
              class="space-y-6">
          @csrf
          @method('PUT')

          {{-- Teks Penjelasan --}}
          <div>
            <label for="deskripsi" class="block text-sm font-medium text-gray-700">
              Teks Penjelasan
              <span class="text-xs text-gray-500">(opsional, jelaskan ringkas struktur & unit)</span>
            </label>
            <textarea id="deskripsi" name="deskripsi" rows="6"
              class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-gray-700"
              placeholder="Contoh: Struktur organisasi terdiri dari Kepala Pusat, Sekretaris, Koordinator Program (Penelitian, Pengabdian, Publikasi), serta Divisi Dokumentasi & Arsip.">{{ old('deskripsi', $struktur->deskripsi) }}</textarea>
            @error('deskripsi') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
          </div>

          {{-- Upload Gambar Struktur --}}
          <div x-data="{ preview: null }">
            <label for="gambar" class="block text-sm font-medium text-gray-700">
              Gambar Struktur Organisasi
              <span class="text-xs text-gray-500">(format: JPG/PNG/SVG, maks 2–3MB)</span>
            </label>

            @if(!empty($struktur?->gambar_path))
              <div class="mt-2">
                <p class="text-xs text-gray-500 mb-1">Gambar saat ini:</p>
                <img src="{{ \Illuminate\Support\Facades\Storage::url($struktur->gambar_path) }}"
                     alt="{{ $struktur->alt_text ?: 'Struktur Organisasi' }}"
                     class="max-h-64 rounded border border-gray-200">
              </div>
            @endif

            <div class="mt-3">
              <input id="gambar" name="gambar" type="file" accept="image/*"
                class="block w-full text-sm text-gray-700 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100"
                @change="
                  const [file] = $event.target.files;
                  if (file) {
                    const r = new FileReader();
                    r.onload = e => preview = e.target.result;
                    r.readAsDataURL(file);
                  } else { preview = null; }
                ">
              @error('gambar') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <template x-if="preview">
              <div class="mt-3">
                <p class="text-xs text-gray-500 mb-1">Preview gambar baru:</p>
                <img :src="preview" alt="Preview Struktur" class="max-h-64 rounded border border-gray-200">
              </div>
            </template>
          </div>

          {{-- Alt text (opsional) --}}
          <div>
            <label for="alt_text" class="block text-sm font-medium text-gray-700">Alt Text Gambar (opsional)</label>
            <input id="alt_text" name="alt_text" type="text"
              class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-gray-700"
              placeholder="Contoh: Struktur Organisasi Pusat Studi Pelestarian Bahasa dan Sastra Daerah"
              value="{{ old('alt_text', $struktur->alt_text ?? '') }}">
            @error('alt_text') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
          </div>

          <div class="flex items-center justify-end gap-2">
            <a href="{{ route('admin.profil.index') }}" class="px-4 py-2 border rounded-md text-gray-700 hover:bg-gray-50">Batal</a>
            <button type="submit"
              class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
              Simpan Perubahan
            </button>
          </div>
        </form>

      </div>
    </div>
  </div>

  @push('scripts')
    {{-- Hapus jika Alpine sudah dibundle di app.js --}}
    <script src="//unpkg.com/alpinejs" defer></script>
  @endpush
</x-app-layout>
