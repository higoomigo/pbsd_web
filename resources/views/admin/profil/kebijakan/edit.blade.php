<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      {{ __('Menu Profil') }} — Kebijakan & Tata Kelola
    </h2>
  </x-slot>

  <div class="py-8" data-theme="light">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="overflow-hidden group shadow-sm sm:rounded-lg hover:shadow-md transition-shadow bg-white p-6">
        <div class="flex items-center justify-between mb-4">
          <p class="font-semibold text-zinc-900 text-lg">Edit Kebijakan & Tata Kelola</p>

          <a href="{{ route('admin.profil.kebijakan.index') }}"
             class="inline-flex items-center gap-2 px-3 py-1.5 rounded-md border text-zinc-700 bg-zinc-50 hover:bg-white text-xs">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M15 18l-6-6 6-6"/>
            </svg>
            Kembali
          </a>
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

        {{-- $kebijakan diasumsikan dikirim dari controller --}}
        <form
          action="{{ route('admin.profil.kebijakan.update', $kebijakan->id) }}"
          method="POST"
          enctype="multipart/form-data"
          class="space-y-6"
        >
          @csrf
          @method('PUT')

          {{-- Identitas Dokumen --}}
          <div class="grid md:grid-cols-2 gap-6">
            <div>
              <label for="judul" class="block text-sm font-medium text-gray-700">Judul Dokumen</label>
              <input id="judul" name="judul" type="text"
                     class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                     value="{{ old('judul', $kebijakan->judul) }}"
                     placeholder="Contoh: Kebijakan Pengelolaan Arsip Digital"/>
              @error('judul') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
              <label for="kategori" class="block text-sm font-medium text-gray-700">Kategori</label>
              @php
                $kategoriOld = old('kategori', $kebijakan->kategori ?? 'Kebijakan');
              @endphp
              <select id="kategori" name="kategori"
                      class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                @foreach (['Kebijakan','SOP','Pedoman','Peraturan','SK','Tata Kelola'] as $opt)
                  <option value="{{ $opt }}" @selected($kategoriOld === $opt)>{{ $opt }}</option>
                @endforeach
              </select>
              @error('kategori') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
              <label for="nomor_dokumen" class="block text-sm font-medium text-gray-700">Nomor Dokumen</label>
              <input id="nomor_dokumen" name="nomor_dokumen" type="text"
                     class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                     value="{{ old('nomor_dokumen', $kebijakan->nomor_dokumen) }}"
                     placeholder="Contoh: 001/Kebijakan/PSBSD/2025"/>
              @error('nomor_dokumen') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
              <label for="versi" class="block text-sm font-medium text-gray-700">Versi</label>
              <input id="versi" name="versi" type="text"
                     class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                     value="{{ old('versi', $kebijakan->versi ?? '1.0') }}"
                     placeholder="1.0"/>
              @error('versi') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
          </div>

          {{-- Ringkasan & Isi --}}
          <div>
            <label for="ringkasan" class="block text-sm font-medium text-gray-700">
              Ringkasan (maks. 2–3 paragraf)
            </label>
            <textarea id="ringkasan" name="ringkasan" rows="4"
                      class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                      placeholder="Ringkas tujuan, ruang lingkup, dan poin inti kebijakan.">{{ old('ringkasan', $kebijakan->ringkasan) }}</textarea>
            @error('ringkasan') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
          </div>

          <div>
            <label for="isi" class="block text-sm font-medium text-gray-700">Isi Kebijakan (detail)</label>
            <textarea id="isi" name="isi" rows="10"
                      class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                      placeholder="Tulis pasal/ketentuan/penjelasan detail.">{{ old('isi', $kebijakan->isi) }}</textarea>
            @error('isi') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
          </div>

          {{-- Penanggung Jawab & Otoritas --}}
          <div class="grid md:grid-cols-3 gap-6">
            <div>
              <label for="otoritas_pengesah" class="block text-sm font-medium text-gray-700">Otoritas Pengesah</label>
              <input id="otoritas_pengesah" name="otoritas_pengesah" type="text"
                     class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                     value="{{ old('otoritas_pengesah', $kebijakan->otoritas_pengesah) }}"
                     placeholder="Kepala Pusat / Dekan / Rektor"/>
              @error('otoritas_pengesah') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
              <label for="penanggung_jawab" class="block text-sm font-medium text-gray-700">Penanggung Jawab</label>
              <input id="penanggung_jawab" name="penanggung_jawab" type="text"
                     class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                     value="{{ old('penanggung_jawab', $kebijakan->penanggung_jawab) }}"
                     placeholder="Sekretaris / Koordinator Tata Kelola"/>
              @error('penanggung_jawab') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
              <label for="unit_terkait" class="block text-sm font-medium text-gray-700">Unit Terkait</label>
              <input id="unit_terkait" name="unit_terkait" type="text"
                     class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                     value="{{ old('unit_terkait', $kebijakan->unit_terkait) }}"
                     placeholder="Dokumentasi & Arsip; Program; Keuangan"/>
              @error('unit_terkait') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
          </div>

          {{-- Tanggal & Siklus Tinjau --}}
          <div class="grid md:grid-cols-3 gap-6">
            <div>
              <label for="tanggal_berlaku" class="block text-sm font-medium text-gray-700">Tanggal Berlaku</label>
              <input id="tanggal_berlaku" name="tanggal_berlaku" type="date"
                     class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                     value="{{ old('tanggal_berlaku', optional($kebijakan->tanggal_berlaku)->format('Y-m-d')) }}">
              @error('tanggal_berlaku') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
              <label for="tanggal_tinjau_berikutnya" class="block text-sm font-medium text-gray-700">Tinjau Berikutnya</label>
              <input id="tanggal_tinjau_berikutnya" name="tanggal_tinjau_berikutnya" type="date"
                     class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                     value="{{ old('tanggal_tinjau_berikutnya', optional($kebijakan->tanggal_tinjau_berikutnya)->format('Y-m-d')) }}">
              @error('tanggal_tinjau_berikutnya') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
              <label for="siklus_tinjau" class="block text-sm font-medium text-gray-700">Siklus Tinjau</label>
              @php
                $siklusOld = old('siklus_tinjau', $kebijakan->siklus_tinjau ?? 'Tahunan');
              @endphp
              <select id="siklus_tinjau" name="siklus_tinjau"
                      class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                @foreach (['Tahunan','Semester','Triwulan','Ad hoc'] as $opt)
                  <option value="{{ $opt }}" @selected($siklusOld === $opt)>{{ $opt }}</option>
                @endforeach
              </select>
              @error('siklus_tinjau') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
          </div>

          {{-- Unggah Dokumen Utama (PDF) --}}
          <div x-data="{ filename: null }">
            <label for="dokumen" class="block text-sm font-medium text-gray-700">
              Unggah Dokumen (PDF)
              <span class="text-xs text-gray-500">(maks 10MB)</span>
            </label>

            @if(!empty($kebijakan->dokumen_path))
              <p class="mt-1 text-sm">
                Dokumen saat ini:
                <a class="text-indigo-600 hover:underline" target="_blank"
                   href="{{ \Illuminate\Support\Facades\Storage::url($kebijakan->dokumen_path) }}">
                  Lihat / Unduh
                </a>
              </p>
            @endif

            <input id="dokumen" name="dokumen" type="file" accept="application/pdf"
                   class="mt-2 block w-full text-sm text-gray-700 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100"
                   @change="filename = $event.target.files[0]?.name || null;">
            <template x-if="filename">
              <p class="mt-1 text-xs text-gray-500">Dipilih: <span x-text="filename"></span></p>
            </template>
            @error('dokumen') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
          </div>

          {{-- Lampiran (opsional, multi-file) --}}
          <div>
            <label for="lampiran" class="block text-sm font-medium text-gray-700">Lampiran (opsional, multi-file)</label>
            <input id="lampiran" name="lampiran[]" type="file" multiple
                   class="mt-1 block w-full text-sm text-gray-700 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
            @error('lampiran.*') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
          </div>

          {{-- Status & Tag --}}
          <div class="grid md:grid-cols-2 gap-6">
            <div>
              <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
              @php
                $statusOld = old('status', $kebijakan->status ?? 'Draft');
              @endphp
              <select id="status" name="status"
                      class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                @foreach (['Draft','Publik'] as $opt)
                  <option value="{{ $opt }}" @selected($statusOld === $opt)>{{ $opt }}</option>
                @endforeach
              </select>
              @error('status') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
              <label for="tags" class="block text-sm font-medium text-gray-700">Tags (pisahkan dengan koma)</label>
              <input id="tags" name="tags" type="text"
                     class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                     value="{{ old('tags', $kebijakan->tags) }}"
                     placeholder="kebijakan, tata kelola, arsip, SOP"/>
              @error('tags') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
          </div>

          <div class="flex items-center justify-end gap-2">
            <a href="{{ route('admin.profil.kebijakan.index') }}"
               class="px-4 py-2 border rounded-md text-zinc-700 hover:bg-zinc-50">
              Batal
            </a>
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
