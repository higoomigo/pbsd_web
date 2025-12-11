@php
    $isEdit = isset($seminar);
    $route = $isEdit ? route('admin.penelitian.seminar.update', $seminar->id) : route('admin.penelitian.seminar.store');
    $method = $isEdit ? 'PUT' : 'POST';
@endphp

<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      {{ __('Menu Penelitian - Seminar') }} — {{ $isEdit ? 'Edit Seminar' : 'Tambah Seminar' }}
    </h2>
  </x-slot>

  <div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 ">

      {{-- Tombol Kembali --}}
      <div class="mb-4 flex items-center justify-between">
        <a href="{{ route('admin.penelitian.seminar.index') }}"
           class="inline-flex items-center gap-2 px-3 py-2 rounded-md border text-zinc-700 bg-zinc-50 hover:bg-white">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M15 18l-6-6 6-6"/>
          </svg>
          Kembali ke Daftar
        </a>
        <span class="text-xs text-zinc-500">
          {{ $isEdit ? 'Form edit seminar' : 'Form tambah seminar' }}
        </span>
      </div>

      <div class="bg-white shadow-sm sm:rounded-lg p-6">
        <form action="{{ $route }}" method="POST" enctype="multipart/form-data" class="space-y-8">
          @csrf
          @method($method)

          {{-- Judul dan Slug --}}
          <div class="grid md:grid-cols-2 gap-6">
            <div>
              <label for="judul" class="form-label">Judul Seminar <span class="text-red-500">*</span></label>
              <input id="judul" name="judul" type="text" class="form-control"
                     value="{{ old('judul', $seminar->judul ?? '') }}" 
                     placeholder="Contoh: Seminar Nasional Bahasa Daerah" required>
              @error('judul') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
              <label for="slug" class="form-label">Slug (URL)</label>
              <input id="slug" name="slug" type="text" class="form-control"
                     value="{{ old('slug', $seminar->slug ?? '') }}" 
                     placeholder="seminar-nasional-bahasa-daerah">
              <p class="text-xs text-gray-500 mt-1">Jika kosong, akan digenerate otomatis dari judul</p>
              @error('slug') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>
          </div>

          {{-- Deskripsi dan Ringkasan --}}
          <div>
            <label for="deskripsi" class="form-label">Deskripsi Lengkap <span class="text-red-500">*</span></label>
            <textarea id="deskripsi" name="deskripsi" rows="5" class="form-control"
                      placeholder="Tulis deskripsi lengkap seminar di sini..." required>{{ old('deskripsi', $seminar->deskripsi ?? '') }}</textarea>
            @error('deskripsi') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
          </div>

          <div>
            <label for="ringkasan" class="form-label">Ringkasan (untuk preview)</label>
            <textarea id="ringkasan" name="ringkasan" rows="3" class="form-control"
                      placeholder="Ringkasan singkat untuk ditampilkan di halaman daftar...">{{ old('ringkasan', $seminar->ringkasan ?? '') }}</textarea>
            @error('ringkasan') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
          </div>

          {{-- Waktu dan Tempat --}}
          <div class="grid md:grid-cols-4 gap-6">
            <div>
              <label for="tanggal" class="form-label">Tanggal <span class="text-red-500">*</span></label>
              <input id="tanggal" name="tanggal" type="date" class="form-control"
                     value="{{ old('tanggal', isset($seminar) ? $seminar->tanggal->format('Y-m-d') : date('Y-m-d')) }}" required>
              @error('tanggal') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
              <label for="waktu_mulai" class="form-label">Waktu Mulai <span class="text-red-500">*</span></label>
              <input id="waktu_mulai" name="waktu_mulai" type="time" class="form-control"
                     value="{{ old('waktu_mulai', isset($seminar) ? $seminar->waktu_mulai->format('H:i') : '09:00') }}" required>
              @error('waktu_mulai') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
              <label for="waktu_selesai" class="form-label">Waktu Selesai</label>
              <input id="waktu_selesai" name="waktu_selesai" type="time" class="form-control"
                     value="{{ old('waktu_selesai', isset($seminar) ? optional($seminar->waktu_selesai)->format('H:i') : '') }}">
              @error('waktu_selesai') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
              <label for="tempat" class="form-label">Tempat <span class="text-red-500">*</span></label>
              <input id="tempat" name="tempat" type="text" class="form-control"
                     value="{{ old('tempat', $seminar->tempat ?? '') }}" 
                     placeholder="Contoh: Auditorium Utama" required>
              @error('tempat') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>
          </div>

          {{-- Alamat dan Link Virtual --}}
          <div class="grid md:grid-cols-2 gap-6">
            <div>
              <label for="alamat_lengkap" class="form-label">Alamat Lengkap</label>
              <textarea id="alamat_lengkap" name="alamat_lengkap" rows="3" class="form-control"
                        placeholder="Alamat lengkap tempat seminar...">{{ old('alamat_lengkap', $seminar->alamat_lengkap ?? '') }}</textarea>
              @error('alamat_lengkap') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
              <label for="link_virtual" class="form-label">Link Virtual (untuk online/hybrid)</label>
              <input id="link_virtual" name="link_virtual" type="url" class="form-control"
                     value="{{ old('link_virtual', $seminar->link_virtual ?? '') }}" 
                     placeholder="https://meet.google.com/xxx-yyyy-zzz">
              @error('link_virtual') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>
          </div>

          {{-- Informasi Pembicara --}}
          <div class="border-t pt-8">
            <h3 class="text-lg font-semibold text-zinc-900 mb-4">Informasi Pembicara</h3>
            
            <div class="grid md:grid-cols-3 gap-6">
              <div>
                <label for="pembicara" class="form-label">Nama Pembicara <span class="text-red-500">*</span></label>
                <input id="pembicara" name="pembicara" type="text" class="form-control"
                       value="{{ old('pembicara', $seminar->pembicara ?? '') }}" 
                       placeholder="Contoh: Prof. Dr. John Doe" required>
                @error('pembicara') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
              </div>

              <div>
                <label for="institusi_pembicara" class="form-label">Institusi Pembicara</label>
                <input id="institusi_pembicara" name="institusi_pembicara" type="text" class="form-control"
                       value="{{ old('institusi_pembicara', $seminar->institusi_pembicara ?? '') }}" 
                       placeholder="Contoh: Universitas Indonesia">
                @error('institusi_pembicara') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
              </div>

              <div x-data="{ preview: null }">
                <label for="foto_pembicara" class="form-label">Foto Pembicara</label>
                <input id="foto_pembicara" name="foto_pembicara" type="file" 
                       accept="image/*" class="form-file"
                       @change="
                         const [f] = $event.target.files;
                         if (!f) { preview = null; return; }
                         const r = new FileReader(); r.onload = e => preview = e.target.result; r.readAsDataURL(f);
                       ">
                
                @if($isEdit && $seminar->foto_pembicara)
                  <div class="mt-2">
                    <p class="text-sm text-gray-600 mb-1">Foto saat ini:</p>
                    <img src="{{ Storage::url($seminar->foto_pembicara) }}" 
                         alt="Foto {{ $seminar->pembicara }}" 
                         class="h-20 w-20 rounded-full object-cover border">
                  </div>
                @endif
                
                <template x-if="preview">
                  <div class="mt-2">
                    <p class="text-sm text-gray-600 mb-1">Preview foto baru:</p>
                    <img :src="preview" alt="Preview foto pembicara" 
                         class="h-20 w-20 rounded-full object-cover border">
                  </div>
                </template>
                
                @error('foto_pembicara') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
              </div>
            </div>

            <div class="mt-4">
              <label for="bio_pembicara" class="form-label">Biografi Pembicara</label>
              <textarea id="bio_pembicara" name="bio_pembicara" rows="4" class="form-control"
                        placeholder="Biografi singkat pembicara...">{{ old('bio_pembicara', $seminar->bio_pembicara ?? '') }}</textarea>
              @error('bio_pembicara') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>
          </div>

          {{-- Kategori dan Topik --}}
          <div class="grid md:grid-cols-4 gap-6">
            <div>
              <label for="tipe" class="form-label">Tipe Seminar <span class="text-red-500">*</span></label>
              <select id="tipe" name="tipe" class="form-control" required>
                <option value="">Pilih Tipe</option>
                @foreach($tipeOptions as $key => $label)
                  <option value="{{ $key }}" {{ old('tipe', $seminar->tipe ?? '') == $key ? 'selected' : '' }}>
                    {{ $label }}
                  </option>
                @endforeach
              </select>
              @error('tipe') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
              <label for="format" class="form-label">Format <span class="text-red-500">*</span></label>
              <select id="format" name="format" class="form-control" required>
                <option value="">Pilih Format</option>
                @foreach($formatOptions as $key => $label)
                  <option value="{{ $key }}" {{ old('format', $seminar->format ?? '') == $key ? 'selected' : '' }}>
                    {{ $label }}
                  </option>
                @endforeach
              </select>
              @error('format') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
              <label for="topik" class="form-label">Topik</label>
              <input id="topik" name="topik" type="text" class="form-control"
                     value="{{ old('topik', $seminar->topik ?? '') }}" 
                     placeholder="Contoh: Linguistik, Sastra Daerah">
              @error('topik') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
              <label for="bidang_ilmu" class="form-label">Bidang Ilmu</label>
              <input id="bidang_ilmu" name="bidang_ilmu" type="text" class="form-control"
                     value="{{ old('bidang_ilmu', $seminar->bidang_ilmu ?? '') }}" 
                     placeholder="Contoh: Linguistik, Antropologi">
              @error('bidang_ilmu') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>
          </div>

          {{-- Informasi Pendaftaran --}}
          <div class="border-t pt-8">
            <h3 class="text-lg font-semibold text-zinc-900 mb-4">Informasi Pendaftaran</h3>
            
            <div class="grid md:grid-cols-4 gap-6">
              <div class="flex items-center">
                <div class="flex items-center h-5">
                  <input type="checkbox" name="gratis" value="1" 
                         class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                         {{ old('gratis', $seminar->gratis ?? true) ? 'checked' : '' }}>
                </div>
                <div class="ml-2 text-sm">
                  <label class="font-medium text-gray-700">Gratis</label>
                </div>
              </div>

              <div>
                <label for="biaya" class="form-label">Biaya (jika berbayar)</label>
                <input id="biaya" name="biaya" type="number" min="0" step="1000" class="form-control"
                       value="{{ old('biaya', $seminar->biaya ?? '') }}" 
                       placeholder="Contoh: 100000">
                @error('biaya') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
              </div>

              <div>
                <label for="link_pendaftaran" class="form-label">Link Pendaftaran</label>
                <input id="link_pendaftaran" name="link_pendaftaran" type="url" class="form-control"
                       value="{{ old('link_pendaftaran', $seminar->link_pendaftaran ?? '') }}" 
                       placeholder="https://forms.google.com/xxx">
                @error('link_pendaftaran') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
              </div>

              <div>
                <label for="batas_pendaftaran" class="form-label">Batas Pendaftaran</label>
                <input id="batas_pendaftaran" name="batas_pendaftaran" type="date" class="form-control"
                       value="{{ old('batas_pendaftaran', isset($seminar) ? optional($seminar->batas_pendaftaran)->format('Y-m-d') : '') }}">
                @error('batas_pendaftaran') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
              </div>
            </div>

            <div class="grid md:grid-cols-2 gap-6 mt-4">
              <div>
                <label for="kuota_peserta" class="form-label">Kuota Peserta</label>
                <input id="kuota_peserta" name="kuota_peserta" type="number" min="1" class="form-control"
                       value="{{ old('kuota_peserta', $seminar->kuota_peserta ?? '') }}" 
                       placeholder="Contoh: 100 (kosongkan untuk tidak terbatas)">
                @error('kuota_peserta') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
              </div>

              <div>
                <label for="peserta_terdaftar" class="form-label">Peserta Terdaftar</label>
                <input id="peserta_terdaftar" name="peserta_terdaftar" type="number" min="0" class="form-control"
                       value="{{ old('peserta_terdaftar', $seminar->peserta_terdaftar ?? 0) }}" 
                       readonly>
                <p class="text-xs text-gray-500 mt-1">Diisi otomatis saat pendaftaran</p>
              </div>
            </div>
          </div>

          {{-- File dan Media --}}
          <div class="grid md:grid-cols-3 gap-6">
            <div x-data="{ preview: null }">
              <label for="poster" class="form-label">Poster Seminar</label>
              <input id="poster" name="poster" type="file" 
                     accept="image/*" class="form-file"
                     @change="
                       const [f] = $event.target.files;
                       if (!f) { preview = null; return; }
                       const r = new FileReader(); r.onload = e => preview = e.target.result; r.readAsDataURL(f);
                     ">
              
              @if($isEdit && $seminar->poster)
                <div class="mt-2">
                  <p class="text-sm text-gray-600 mb-1">Poster saat ini:</p>
                  <img src="{{ Storage::url($seminar->poster) }}" 
                       alt="Poster {{ $seminar->judul }}" 
                       class="h-32 w-full object-contain border rounded">
                </div>
              @endif
              
              <template x-if="preview">
                <div class="mt-2">
                  <p class="text-sm text-gray-600 mb-1">Preview poster baru:</p>
                  <img :src="preview" alt="Preview poster" 
                       class="h-32 w-full object-contain border rounded">
                </div>
              </template>
              
              @error('poster') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
              <label for="dokumen_materi" class="form-label">Dokumen Materi</label>
              <input id="dokumen_materi" name="dokumen_materi" type="file" 
                     accept=".pdf,.doc,.docx,.ppt,.pptx" class="form-file">
              @if($isEdit && $seminar->dokumen_materi)
                <div class="mt-2">
                  <p class="text-sm text-gray-600 mb-1">Dokumen saat ini:</p>
                  <a href="{{ Storage::url($seminar->dokumen_materi) }}" 
                     target="_blank"
                     class="text-blue-600 hover:text-blue-800 text-sm">
                    Lihat Dokumen
                  </a>
                </div>
              @endif
              @error('dokumen_materi') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
              <label for="video_rekaman" class="form-label">Link Video Rekaman</label>
              <input id="video_rekaman" name="video_rekaman" type="url" class="form-control"
                     value="{{ old('video_rekaman', $seminar->video_rekaman ?? '') }}" 
                     placeholder="https://youtube.com/watch?v=xxx">
              @error('video_rekaman') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>
          </div>

          {{-- Status --}}
          <div class="border-t pt-8">
            <h3 class="text-lg font-semibold text-zinc-900 mb-4">Status & Publikasi</h3>
            
            <div class="grid md:grid-cols-3 gap-6">
              <div class="flex items-center">
                <div class="flex items-center h-5">
                  <input id="is_published" name="is_published" type="checkbox" value="1" 
                         class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                         {{ old('is_published', $seminar->is_published ?? false) ? 'checked' : '' }}>
                </div>
                <div class="ml-3 text-sm">
                  <label for="is_published" class="font-medium text-gray-700">Publish</label>
                  <p class="text-gray-500">Tampilkan di halaman publik</p>
                </div>
              </div>

              <div class="flex items-center">
                <div class="flex items-center h-5">
                  <input id="is_featured" name="is_featured" type="checkbox" value="1" 
                         class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                         {{ old('is_featured', $seminar->is_featured ?? false) ? 'checked' : '' }}>
                </div>
                <div class="ml-3 text-sm">
                  <label for="is_featured" class="font-medium text-gray-700">Featured</label>
                  <p class="text-gray-500">Tandai sebagai seminar unggulan</p>
                </div>
              </div>

              <div class="flex items-center">
                <div class="flex items-center h-5">
                  <input id="is_cancelled" name="is_cancelled" type="checkbox" value="1" 
                         class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                         {{ old('is_cancelled', $seminar->is_cancelled ?? false) ? 'checked' : '' }}>
                </div>
                <div class="ml-3 text-sm">
                  <label for="is_cancelled" class="font-medium text-gray-700">Dibatalkan</label>
                  <p class="text-gray-500">Tandai seminar sebagai dibatalkan</p>
                </div>
              </div>
            </div>
          </div>

          <div class="flex items-center justify-end gap-4 pt-6 border-t">
            <a href="{{ route('admin.penelitian.seminar.index') }}"
               class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
              Batal
            </a>
            <button type="submit"
                    class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
              {{ $isEdit ? 'Perbarui Seminar' : 'Simpan Seminar' }}
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>

  @push('scripts')
    <script src="//unpkg.com/alpinejs" defer></script>
    <script>
      document.addEventListener('DOMContentLoaded', function() {
        // Auto-generate slug from title
        const judulInput = document.getElementById('judul');
        const slugInput = document.getElementById('slug');
        
        if (judulInput && slugInput) {
          judulInput.addEventListener('blur', function() {
            if (!slugInput.value) {
              const slug = judulInput.value
                .toLowerCase()
                .replace(/[^\w\s]/gi, '')
                .replace(/\s+/g, '-')
                .replace(/--+/g, '-')
                .trim();
              slugInput.value = slug;
            }
          });
        }

        // Toggle biaya input based on gratis checkbox
        const gratisCheckbox = document.querySelector('input[name="gratis"]');
        const biayaInput = document.getElementById('biaya');
        
        if (gratisCheckbox && biayaInput) {
          function toggleBiayaInput() {
            if (gratisCheckbox.checked) {
              biayaInput.value = '';
              biayaInput.disabled = true;
              biayaInput.placeholder = 'Seminar gratis';
            } else {
              biayaInput.disabled = false;
              biayaInput.placeholder = 'Contoh: 100000';
            }
          }
          
          gratisCheckbox.addEventListener('change', toggleBiayaInput);
          toggleBiayaInput(); // Initial state
        }

        // Set min date for tanggal and batas_pendaftaran
        const today = new Date().toISOString().split('T')[0];
        const tanggalInput = document.getElementById('tanggal');
        const batasPendaftaranInput = document.getElementById('batas_pendaftaran');
        
        if (tanggalInput) {
          tanggalInput.min = today;
        }
        
        if (batasPendaftaranInput) {
          batasPendaftaranInput.min = today;
        }
      });
    </script>
  @endpush
</x-app-layout>