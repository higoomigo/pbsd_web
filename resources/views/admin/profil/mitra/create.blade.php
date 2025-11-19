<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      {{ __('Menu Profil') }} — Konten Mitra
    </h2>
  </x-slot>

  <div class="py-8">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="overflow-hidden group shadow-sm sm:rounded-lg hover:shadow-md transition-shadow bg-white p-6">
        <div class="flex items-center justify-between mb-4">
          <p class="font-semibold text-zinc-900 text-lg">Form Konten Mitra</p>
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

        {{-- $mitra diasumsikan dikirim dari controller --}}
        <form action="{{ route('admin.profil.mitra.store') }}"
            method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('POST')

            {{-- Identitas Mitra --}}
            <div class="grid md:grid-cols-2 gap-6">
                <div>
                    <label for="nama" class="form-label">Nama Mitra</label>
                    <input id="nama" name="nama" type="text"
                        class="form-control"
                        value="{{ old('nama', $mitra->nama ?? '') }}"
                        placeholder="Contoh: Balai Bahasa Provinsi Gorontalo">
                    @error('nama') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="jenis" class="form-label">Jenis Mitra</label>
                    @php $jenisOld = old('jenis', $mitra->jenis ?? 'Pemerintah'); @endphp
                    <select id="jenis" name="jenis" class="form-control">
                    @foreach (['Pemerintah','Perguruan Tinggi','Lembaga Riset','Komunitas','Industri'] as $opt)
                        <option value="{{ $opt }}" @selected($jenisOld === $opt)>{{ $opt }}</option>
                    @endforeach
                    </select>
                    @error('jenis') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
                </div>

                {{-- Deskripsi --}}
                <div>
                <label for="deskripsi" class="form-label">Deskripsi Singkat</label>
                <textarea id="deskripsi" name="deskripsi" rows="4" class="form-control"
                            placeholder="Ringkas lingkup kolaborasi, fokus program, atau capaian.">{{ old('deskripsi', $mitra->deskripsi ?? '') }}</textarea>
                @error('deskripsi') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                {{-- Logo --}}
                <div x-data="{ preview: null }">
                <label for="logo" class="form-label">Logo Mitra</label>
                @if(!empty($mitra?->logo_path))
                    <div class="mt-2">
                    <p class="text-xs text-zinc-500 mb-1">Logo saat ini:</p>
                    <img src="{{ Storage::url($mitra->logo_path) }}" alt="{{ $mitra->nama ?? 'Logo Mitra' }}"
                        class="max-h-20 rounded border border-zinc-200 bg-white p-2">
                    </div>
                @endif
                <input id="logo" name="logo" type="file" accept="image/*" class="form-file mt-3"
                        @change="
                        const [file] = $event.target.files;
                        if (file) { const r = new FileReader(); r.onload = e => preview = e.target.result; r.readAsDataURL(file); }
                        else { preview = null; }
                        ">
                @error('logo') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror

                <template x-if="preview">
                    <div class="mt-3">
                    <p class="text-xs text-zinc-500 mb-1">Preview logo baru:</p>
                    <img :src="preview" alt="Preview Logo" class="max-h-20 rounded border border-zinc-200 bg-white p-2">
                    </div>
                </template>
                </div>

                {{-- Periode & Status --}}
                <div class="grid md:grid-cols-3 gap-6">
                <div>
                    <label for="mulai" class="form-label">Mulai Kerja Sama</label>
                    <input id="mulai" name="mulai" type="date" class="form-control"
                        value="{{ old('mulai', optional($mitra->mulai ?? null)->format('Y-m-d')) }}">
                    @error('mulai') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="berakhir" class="form-label">Berakhir (opsional)</label>
                    <input id="berakhir" name="berakhir" type="date" class="form-control"
                        value="{{ old('berakhir', optional($mitra->berakhir ?? null)->format('Y-m-d')) }}">
                    @error('berakhir') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="status" class="form-label">Status</label>
                    @php $statusOld = old('status', $mitra->status ?? 'Aktif'); @endphp
                    <select id="status" name="status" class="form-control">
                    @foreach (['Aktif','Tidak Aktif'] as $opt)
                        <option value="{{ $opt }}" @selected($statusOld === $opt)>{{ $opt }}</option>
                    @endforeach
                    </select>
                    @error('status') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
                </div>

                {{-- Urutan & Highlight --}}
                <div class="grid md:grid-cols-3 gap-6">
                <div>
                    <label for="urutan" class="form-label">Urutan Tampil</label>
                    <input id="urutan" name="urutan" type="number" min="0" step="1" class="form-control"
                        value="{{ old('urutan', $mitra->urutan ?? 0) }}">
                    @error('urutan') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
                <div class="md:col-span-2 flex items-center gap-3 mt-7">
                    <input id="tampil_beranda" name="tampil_beranda" type="checkbox" value="1"
                        class="h-4 w-4 text-indigo-600 border-zinc-300 rounded"
                        @checked(old('tampil_beranda', $mitra->tampil_beranda ?? false))>
                    <label for="tampil_beranda" class="text-sm text-zinc-700">Tampilkan di Beranda (highlight)</label>
                </div>
                </div>

                {{-- MoU --}}
                <div>
                <label for="dokumen_mou" class="form-label">Dokumen MoU (PDF, opsional)</label>
                @if(!empty($mitra?->dokumen_mou_path))
                    <p class="mt-1 text-sm">
                    MoU saat ini:
                    <a class="text-indigo-600 hover:underline" target="_blank" href="{{ Storage::url($mitra->dokumen_mou_path) }}">Lihat / Unduh</a>
                    </p>
                @endif
                <input id="dokumen_mou" name="dokumen_mou" type="file" accept="application/pdf" class="form-file mt-2">
                @error('dokumen_mou') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

            <div class="flex items-center justify-end gap-2">
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
  <script src="//unpkg.com/alpinejs" defer></script>
  @endpush
</x-app-layout>
