<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      {{ __('Profil - Kelola Peneliti') }} — Tambah Peneliti
    </h2>
  </x-slot>

  <div class="py-6" data-theme="light">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

      {{-- Tombol Kembali di atas form --}}
      <div class="mb-4 flex items-center justify-between">
        <button type="button"
                class="inline-flex items-center gap-2 px-3 py-2 rounded-md border text-zinc-700 bg-zinc-50 hover:bg-white"
                onclick="(document.referrer ? history.back() : (window.location='{{ route('admin.profil.peneliti.index') }}'))">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M15 18l-6-6 6-6"/></svg>
          Kembali
        </button>
        <span class="text-xs text-zinc-500">Form tambah peneliti</span>
      </div>

      <div class="bg-white shadow-sm sm:rounded-lg p-6">
        <form action="{{ route('admin.profil.peneliti.store') }}"
              method="POST" enctype="multipart/form-data" class="space-y-8">
          @csrf

          {{-- Informasi Dasar --}}
          <div class="grid md:grid-cols-3 gap-6">
            <div>
              <label for="nama" class="form-label">Nama Lengkap *</label>
              <input id="nama" name="nama" type="text" class="form-control"
                     value="{{ old('nama') }}" placeholder="Contoh: Dr. Ahmad Wijaya, M.Kom." required/>
              @error('nama') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
              
              {{-- Hidden slug (diisi otomatis oleh JS) --}}
              <input id="slug" name="slug" type="hidden" value="{{ old('slug') }}">
              <p id="slugPreview" class="mt-1 text-xs text-zinc-500">
                Slug: <span class="font-mono opacity-80">—</span>
              </p>
            </div>

            <div>
              <label for="gelar_depan" class="form-label">Gelar Depan</label>
              <input id="gelar_depan" name="gelar_depan" type="text" class="form-control"
                     value="{{ old('gelar_depan') }}" placeholder="Contoh: Dr., Prof."/>
              @error('gelar_depan') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
              <label for="gelar_belakang" class="form-label">Gelar Belakang</label>
              <input id="gelar_belakang" name="gelar_belakang" type="text" class="form-control"
                     value="{{ old('gelar_belakang') }}" placeholder="Contoh: M.Kom., S.T., Ph.D."/>
              @error('gelar_belakang') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>
          </div>

          {{-- Posisi & Jabatan --}}
          <div class="grid md:grid-cols-2 gap-6">
            <div>
              <label for="posisi" class="form-label">Posisi *</label>
              <select id="posisi" name="posisi" class="form-control" required>
                <option value="">Pilih Posisi</option>
                @foreach($positions as $position)
                  <option value="{{ $position }}" @selected(old('posisi')==$position)>{{ $position }}</option>
                @endforeach
              </select>
              @error('posisi') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
              <label for="jabatan" class="form-label">Jabatan</label>
              <input id="jabatan" name="jabatan" type="text" class="form-control"
                     value="{{ old('jabatan') }}" placeholder="Contoh: Kepala Lab, Koordinator Riset"/>
              @error('jabatan') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>
          </div>

          {{-- Status & Tipe --}}
          <div class="grid md:grid-cols-2 gap-6">
            <div>
              <label for="status" class="form-label">Status *</label>
              <select id="status" name="status" class="form-control" required>
                <option value="">Pilih Status</option>
                @foreach($statuses as $status)
                  <option value="{{ $status }}" @selected(old('status')==$status)>{{ $status }}</option>
                @endforeach
              </select>
              @error('status') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
              <label for="tipe" class="form-label">Tipe *</label>
              <select id="tipe" name="tipe" class="form-control" required>
                <option value="">Pilih Tipe</option>
                @foreach($types as $type)
                  <option value="{{ $type }}" @selected(old('tipe')==$type)>{{ $type }}</option>
                @endforeach
              </select>
              @error('tipe') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>
          </div>

          {{-- Bidang Keahlian --}}
          <div x-data="{ bidangKeahlian: {{ json_encode(old('bidang_keahlian', [])) }}, newBidang: '' }">
            <label class="form-label">Bidang Keahlian</label>
            <div class="space-y-3">
              {{-- Input untuk tambah bidang baru --}}
              <div class="flex gap-2">
                <input x-model="newBidang" type="text" class="form-control flex-1" 
                       placeholder="Tambahkan bidang keahlian (contoh: Artificial Intelligence)">
                <button type="button" 
                        @click="if(newBidang.trim() && !bidangKeahlian.includes(newBidang.trim())) { bidangKeahlian.push(newBidang.trim()); newBidang = ''; }"
                        class="px-4 py-2 bg-gray-600 text-white rounded text-sm hover:bg-gray-700">
                  Tambah
                </button>
              </div>
              
              {{-- Daftar bidang yang sudah ditambahkan --}}
              <template x-if="bidangKeahlian.length > 0">
                <div class="border border-gray-200 rounded-lg p-4 bg-gray-50">
                  <p class="text-sm text-gray-600 mb-2">Bidang keahlian yang dipilih:</p>
                  <div class="flex flex-wrap gap-2">
                    <template x-for="(bidang, index) in bidangKeahlian" :key="index">
                      <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-blue-100 text-blue-800 text-sm">
                        <span x-text="bidang"></span>
                        <button type="button" 
                                @click="bidangKeahlian.splice(index, 1)"
                                class="text-blue-600 hover:text-blue-800">
                          <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                          </svg>
                        </button>
                      </span>
                    </template>
                  </div>
                </div>
              </template>
              
              {{-- Hidden input untuk form submission --}}
              <template x-for="(bidang, index) in bidangKeahlian" :key="index">
                <input type="hidden" name="bidang_keahlian[]" :value="bidang">
              </template>
            </div>
            @error('bidang_keahlian') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
          </div>

          {{-- Foto Profil --}}
          <div x-data="{ preview: null }">
            <label for="foto" class="form-label">Foto Profil</label>
            <input id="foto" name="foto" type="file" accept="image/*" class="form-file"
                   @change="
                     const [f] = $event.target.files;
                     if (!f) { preview = null; return; }
                     const r = new FileReader(); r.onload = e => preview = e.target.result; r.readAsDataURL(f);
                   ">
            @error('foto') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror

            <template x-if="preview">
              <div class="mt-3">
                <p class="text-xs text-zinc-500 mb-1">Preview:</p>
                <div class="flex items-center gap-4">
                  <img :src="preview" alt="Preview Foto" class="h-32 w-32 rounded-full object-cover border-2 border-zinc-200 bg-white p-1">
                  <div class="text-sm text-zinc-600">
                    <p>Foto akan ditampilkan dalam bentuk lingkaran</p>
                    <p class="text-xs">Rekomendasi: foto persegi (1:1) untuk hasil terbaik</p>
                  </div>
                </div>
              </div>
            </template>
          </div>

          {{-- Kontak & Informasi --}}
          <div class="grid md:grid-cols-2 gap-6">
            <div>
              <label for="email" class="form-label">Email</label>
              <input id="email" name="email" type="email" class="form-control"
                     value="{{ old('email') }}" placeholder="contoh@email.com"/>
              @error('email') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
              <label for="phone" class="form-label">Telepon</label>
              <input id="phone" name="phone" type="text" class="form-control"
                     value="{{ old('phone') }}" placeholder="+62 812-3456-7890"/>
              @error('phone') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>
          </div>

          <div class="grid md:grid-cols-3 gap-6">
            <div>
              <label for="website" class="form-label">Website</label>
              <input id="website" name="website" type="url" class="form-control"
                     value="{{ old('website') }}" placeholder="https://example.com"/>
              @error('website') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
              <label for="linkedin" class="form-label">LinkedIn</label>
              <input id="linkedin" name="linkedin" type="url" class="form-control"
                     value="{{ old('linkedin') }}" placeholder="https://linkedin.com/in/username"/>
              @error('linkedin') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
              <label for="google_scholar" class="form-label">Google Scholar</label>
              <input id="google_scholar" name="google_scholar" type="url" class="form-control"
                     value="{{ old('google_scholar') }}" placeholder="https://scholar.google.com/citations?user=ID"/>
              @error('google_scholar') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>
          </div>

          <div>
            <label for="researchgate" class="form-label">ResearchGate</label>
            <input id="researchgate" name="researchgate" type="url" class="form-control"
                   value="{{ old('researchgate') }}" placeholder="https://researchgate.net/profile/username"/>
            @error('researchgate') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
          </div>

          {{-- Deskripsi & Biografi --}}
          <div>
            <label for="deskripsi_singkat" class="form-label">Deskripsi Singkat</label>
            <textarea id="deskripsi_singkat" name="deskripsi_singkat" rows="3" class="form-control"
                      placeholder="Deskripsi singkat untuk tampilan card/list (maksimal 500 karakter)">{{ old('deskripsi_singkat') }}</textarea>
            @error('deskripsi_singkat') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
          </div>

          <div>
            <label for="biografi" class="form-label">Biografi Lengkap</label>
            <textarea id="biografi" name="biografi" rows="8" class="form-control"
                      placeholder="Tulis biografi lengkap peneliti di sini...">{{ old('biografi') }}</textarea>
            @error('biografi') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
          </div>

          {{-- Riwayat Pendidikan & Pencapaian --}}
          <div class="grid md:grid-cols-2 gap-6">
            <div>
              <label for="riwayat_pendidikan" class="form-label">Riwayat Pendidikan</label>
              <textarea id="riwayat_pendidikan" name="riwayat_pendidikan" rows="5" class="form-control"
                        placeholder="Contoh:&#10;• S3 Computer Science - Stanford University (2015-2018)&#10;• S2 Artificial Intelligence - MIT (2012-2014)&#10;• S1 Teknik Informatika - ITB (2008-2012)">{{ old('riwayat_pendidikan') }}</textarea>
              @error('riwayat_pendidikan') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
              <label for="pencapaian" class="form-label">Pencapaian & Penghargaan</label>
              <textarea id="pencapaian" name="pencapaian" rows="5" class="form-control"
                        placeholder="Contoh:&#10;• Best Researcher Award 2022&#10;• Research Grant $50,000&#10;• 50+ Publications in International Journals">{{ old('pencapaian') }}</textarea>
              @error('pencapaian') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>
          </div>

          {{-- Publikasi & Penelitian Unggulan --}}
          <div class="grid md:grid-cols-2 gap-6">
            <div x-data="{ publikasi: {{ json_encode(old('publikasi_terpilih', [])) }}, newPublikasi: '' }">
              <label class="form-label">Publikasi Terpilih</label>
              <div class="space-y-3">
                <div class="flex gap-2">
                  <input x-model="newPublikasi" type="text" class="form-control flex-1" 
                         placeholder="Judul publikasi penting">
                  <button type="button" 
                          @click="if(newPublikasi.trim() && !publikasi.includes(newPublikasi.trim())) { publikasi.push(newPublikasi.trim()); newPublikasi = ''; }"
                          class="px-3 py-2 bg-gray-600 text-white rounded text-sm hover:bg-gray-700">
                    +
                  </button>
                </div>
                
                <template x-if="publikasi.length > 0">
                  <div class="border border-gray-200 rounded-lg p-3 bg-gray-50">
                    <div class="space-y-2">
                      <template x-for="(item, index) in publikasi" :key="index">
                        <div class="flex items-center justify-between bg-white p-2 rounded border">
                          <span x-text="item" class="text-sm flex-1"></span>
                          <button type="button" 
                                  @click="publikasi.splice(index, 1)"
                                  class="text-red-500 hover:text-red-700 ml-2">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                          </button>
                        </div>
                      </template>
                    </div>
                  </div>
                </template>
                
                <template x-for="(item, index) in publikasi" :key="index">
                  <input type="hidden" name="publikasi_terpilih[]" :value="item">
                </template>
              </div>
            </div>

            <div x-data="{ penelitian: {{ json_encode(old('penelitian_unggulan', [])) }}, newPenelitian: '' }">
              <label class="form-label">Penelitian Unggulan</label>
              <div class="space-y-3">
                <div class="flex gap-2">
                  <input x.model="newPenelitian" type="text" class="form-control flex-1" 
                         placeholder="Judul penelitian unggulan">
                  <button type="button" 
                          @click="if(newPenelitian.trim() && !penelitian.includes(newPenelitian.trim())) { penelitian.push(newPenelitian.trim()); newPenelitian = ''; }"
                          
                          class="px-3 py-2 bg-gray-600 text-white rounded text-sm hover:bg-gray-700">
                    +
                  </button>
                </div>
                
                <template x-if="penelitian.length > 0">
                  <div class="border border-gray-200 rounded-lg p-3 bg-gray-50">
                    <div class="space-y-2">
                      <template x-for="(item, index) in penelitian" :key="index">
                        <div class="flex items-center justify-between bg-white p-2 rounded border">
                          <span x-text="item" class="text-sm flex-1"></span>
                          <button type="button" 
                                  @click="penelitian.splice(index, 1)"
                                  class="text-red-500 hover:text-red-700 ml-2">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                          </button>
                        </div>
                      </template>
                    </div>
                  </div>
                </template>
                
                <template x-for="(item, index) in penelitian" :key="index">
                  <input type="hidden" name="penelitian_unggulan[]" :value="item">
                </template>
              </div>
            </div>
          </div>

          {{-- Pengaturan Tambahan --}}
          <div class="grid md:grid-cols-3 gap-6 border-t pt-6">
            <div>
              <label for="urutan" class="form-label">Urutan Tampil</label>
              <input id="urutan" name="urutan" type="number" class="form-control"
                     value="{{ old('urutan', 0) }}" min="0" placeholder="0"/>
              <p class="text-xs text-zinc-500 mt-1">Angka lebih kecil = tampil lebih awal</p>
              @error('urutan') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="flex items-center">
              <input type="hidden" name="tampil_beranda" value="0">
              <div class="flex items-center h-5">
                <input id="tampil_beranda" name="tampil_beranda" type="checkbox" value="1"
                       class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"/>
              </div>
              <label for="tampil_beranda" class="ml-2 text-sm text-gray-700">
                Tampilkan di Beranda
              </label>
              @error('tampil_beranda') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="flex items-center">
              <input type="hidden" name="is_published" value="0">
              <div class="flex items-center h-5">
                <input id="is_published" name="is_published" type="checkbox" value="1"
                       class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"/>
              </div>
              <label for="is_published" class="ml-2 text-sm text-gray-700">
                Publikasikan Sekarang
              </label>
              @error('is_published') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>
          </div>

          <div class="flex items-center justify-end gap-2 pt-6 border-t">
            <button type="reset" 
                    class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 bg-white hover:bg-gray-50">
              Reset
            </button>
            <button type="submit"
                    class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
              Simpan Peneliti
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>

  @push('scripts')
    <script src="//unpkg.com/alpinejs" defer></script>
    <script>
      // Debounce helper
      function debounce(fn, wait=250){
        let t; return (...args)=>{ clearTimeout(t); t=setTimeout(()=>fn.apply(null,args), wait); };
      }

      // Slugify function
      function slugify(text) {
        return text
          .normalize('NFKD')
          .replace(/[\u0300-\u036f]/g, '')
          .replace(/[^a-zA-Z0-9\s-]/g, '')
          .trim()
          .toLowerCase()
          .replace(/[\s_-]+/g, '-')
          .replace(/^-+|-+$/g, '');
      }

      (function(){
        const nama = document.getElementById('nama');
        const slug = document.getElementById('slug');
        const prev = document.querySelector('#slugPreview span');

        if(!nama || !slug) return;

        const update = debounce(() => {
          const s = slugify(nama.value || '');
          slug.value = s;
          if (prev) prev.textContent = s || '—';
        }, 150);

        // init dari old value
        update();

        // listen ke input, paste, change
        ['input','change','paste'].forEach(evt => {
          nama.addEventListener(evt, update);
        });
      })();
    </script>
  @endpush
</x-app-layout>