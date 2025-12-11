{{-- resources/views/admin/publikasi-data/dokumen/edit.blade.php --}}
<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      {{ __('Edit Dokumen:') }} <span class="text-indigo-600">{{ $dokumen->judul }}</span>
    </h2>
  </x-slot>

  <div class="py-6" data-theme="light">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 ">

      {{-- Breadcrumb --}}
      <div class="mb-6">
        <nav class="flex" aria-label="Breadcrumb">
          <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
              <a href="{{ route('admin.publikasi-data.index') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-indigo-600">
                Dashboard
              </a>
            </li>
            <li>
              <div class="flex items-center">
                <svg class="w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                </svg>
                <a href="{{ route('admin.publikasi-data.dokumen.index') }}" class="ml-1 text-sm font-medium text-gray-700 hover:text-indigo-600">
                  Dokumen
                </a>
              </div>
            </li>
            @if($dokumen->koleksi)
              <li>
                <div class="flex items-center">
                  <svg class="w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                  </svg>
                  <a href="{{ route('admin.publikasi-data.dokumen.index', ['koleksi' => $dokumen->koleksi_dokumen_id]) }}" class="ml-1 text-sm font-medium text-gray-700 hover:text-indigo-600">
                    {{ Str::limit($dokumen->koleksi->judul, 20) }}
                  </a>
                </div>
              </li>
            @endif
            <li aria-current="page">
              <div class="flex items-center">
                <svg class="w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                </svg>
                <span class="ml-1 text-sm font-medium text-gray-500">Edit</span>
              </div>
            </li>
          </ol>
        </nav>
      </div>

      <div class="bg-white shadow-sm sm:rounded-lg p-6">
        @if(session('success'))
          <div class="mb-4 p-3 bg-green-100 text-green-800 rounded text-sm">
            {{ session('success') }}
          </div>
        @endif

        @if ($errors->any())
          <div class="mb-4 p-3 bg-red-100 text-red-800 rounded text-sm">
            <ul class="list-disc pl-5">
              @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif

        <form id="form-edit-dokumen"
              action="{{ route('admin.publikasi-data.dokumen.update', $dokumen->id) }}"
              method="POST"
              enctype="multipart/form-data"
              class="space-y-8">
          @csrf
          @method('PUT')

          {{-- Info Dokumen --}}
          <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 mb-6">
            <div class="flex items-center justify-between">
              <div class="flex items-center">
                @if($dokumen->thumbnail_url)
                  <div class="flex-shrink-0 mr-3">
                    <img src="{{ $dokumen->thumbnail_url }}" 
                         alt="Thumbnail {{ $dokumen->judul }}"
                         class="h-12 w-12 object-cover rounded-md">
                  </div>
                @endif
                <div>
                  <h4 class="text-sm font-semibold text-gray-900">Mengedit Dokumen</h4>
                  <p class="text-sm text-gray-700">{{ $dokumen->judul }}</p>
                  <div class="flex items-center gap-2 mt-1">
                    @if($dokumen->kode)
                      <span class="text-xs font-mono bg-white px-2 py-1 rounded border">{{ $dokumen->kode }}</span>
                    @endif
                    <span class="text-xs text-gray-500">
                      ID: {{ $dokumen->id }} • 
                      Dibuat: {{ $dokumen->created_at->format('d/m/Y') }}
                    </span>
                  </div>
                </div>
              </div>
              <a href="{{ route('admin.publikasi-data.dokumen.show', $dokumen->id) }}"
                 class="text-xs text-indigo-600 hover:text-indigo-800">
                Lihat detail →
              </a>
            </div>
          </div>

          <div class="grid md:grid-cols-2 gap-8">
            {{-- Kolom kiri: Informasi Dasar --}}
            <div class="space-y-6">
              <h3 class="text-lg font-medium text-gray-900 border-b pb-2">Informasi Dasar</h3>
              
              {{-- Koleksi Dokumen --}}
              <div>
                <label for="koleksi_dokumen_id" class="form-label">Koleksi Dokumen</label>
                <select id="koleksi_dokumen_id" name="koleksi_dokumen_id" class="form-control">
                  <option value="">Tanpa Koleksi</option>
                  @foreach($koleksi as $k)
                    <option value="{{ $k->id }}" 
                      {{ old('koleksi_dokumen_id', $dokumen->koleksi_dokumen_id) == $k->id ? 'selected' : '' }}>
                      {{ $k->judul }}
                      @if($k->tahun_mulai || $k->tahun_selesai)
                        ({{ $k->tahun_mulai ? $k->tahun_mulai : '' }}{{ $k->tahun_selesai ? ' - ' . $k->tahun_selesai : '' }})
                      @endif
                    </option>
                  @endforeach
                </select>
                <p class="mt-1 text-xs text-zinc-500">
                  Pilih koleksi untuk mengelompokkan dokumen terkait.
                </p>
                @error('koleksi_dokumen_id') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
              </div>

              {{-- Kode dan Judul --}}
              <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                  <label for="kode" class="form-label">Kode / ID Katalog</label>
                  <input id="kode" name="kode" type="text" class="form-control"
                         value="{{ old('kode', $dokumen->kode) }}" placeholder="DOC-0001 / BG-QUR-01">
                  <p class="mt-1 text-xs text-zinc-500">
                    Jika dikosongkan, sistem akan generate otomatis
                  </p>
                  @error('kode') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                  <label for="slug" class="form-label">Slug (URL)</label>
                  <input id="slug" name="slug" type="text" class="form-control"
                         value="{{ old('slug', $dokumen->slug) }}" placeholder="quran-terjemahan-gorontalo">
                  @error('slug') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>
              </div>

              <div>
                <label for="judul" class="form-label">Judul Dokumen <span class="text-red-500">*</span></label>
                <input id="judul" name="judul" type="text" class="form-control"
                       value="{{ old('judul', $dokumen->judul) }}" placeholder="Contoh: Qur'an Terjemahan Bahasa Gorontalo" required>
                @error('judul') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
              </div>

              {{-- Kategori dan Sub Kategori --}}
              <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                  <label for="kategori" class="form-label">Kategori</label>
                  @php
                    $kategoriOld = old('kategori', $dokumen->kategori);
                  @endphp
                  <select id="kategori" name="kategori" class="form-control">
                    <option value="">Pilih Kategori</option>
                    @foreach (['Keagamaan', 'Sastra', 'Naskah Kuno', 'Arsip Sejarah', 'Penelitian', 'Wawancara', 'Dokumen Pemerintah', 'Lainnya'] as $opt)
                      <option value="{{ $opt }}" @selected($kategoriOld === $opt)>{{ $opt }}</option>
                    @endforeach
                  </select>
                  @error('kategori') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                  <label for="sub_kategori" class="form-label">Sub Kategori (Opsional)</label>
                  <input id="sub_kategori" name="sub_kategori" type="text" class="form-control"
                         value="{{ old('sub_kategori', $dokumen->sub_kategori) }}" placeholder="Contoh: Terjemahan, Transkrip, Foto">
                  @error('sub_kategori') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>
              </div>

              {{-- Deskripsi Singkat --}}
              <div>
                <label for="deskripsi_singkat" class="form-label">Deskripsi Singkat</label>
                <textarea id="deskripsi_singkat" name="deskripsi_singkat" rows="3" class="form-control"
                  placeholder="Ringkasan singkat isi dokumen (akan ditampilkan di list)">{{ old('deskripsi_singkat', $dokumen->deskripsi_singkat) }}</textarea>
                <p class="mt-1 text-xs text-zinc-500">Maks. 200 karakter</p>
                @error('deskripsi_singkat') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
              </div>

              {{-- Ringkasan Lengkap --}}
              <div>
                <label for="ringkasan" class="form-label">Ringkasan Lengkap / Abstrak</label>
                <textarea id="ringkasan" name="ringkasan" rows="4" class="form-control"
                  placeholder="Deskripsi lengkap isi dokumen, konteks, dan nilai pelestariannya.">{{ old('ringkasan', $dokumen->ringkasan) }}</textarea>
                @error('ringkasan') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
              </div>

              {{-- Bahasa dan Tahun --}}
              <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                  <label for="bahasa" class="form-label">Bahasa</label>
                  <input id="bahasa" name="bahasa" type="text" class="form-control"
                         value="{{ old('bahasa', $dokumen->bahasa) }}" placeholder="Contoh: Gorontalo, Indonesia, Belanda">
                  @error('bahasa') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                  <label for="tahun_terbit" class="form-label">Tahun Terbit</label>
                  <input id="tahun_terbit" name="tahun_terbit" type="number" min="1800" max="{{ date('Y') }}"
                         class="form-control"
                         value="{{ old('tahun_terbit', $dokumen->tahun_terbit) }}" placeholder="Contoh: 2015">
                  @error('tahun_terbit') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>
              </div>

              {{-- Penulis dan Penerbit --}}
              <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                  <label for="penulis" class="form-label">Penulis / Pengarang</label>
                  <input id="penulis" name="penulis" type="text" class="form-control"
                         value="{{ old('penulis', $dokumen->penulis) }}" placeholder="Nama penulis atau pengarang">
                  @error('penulis') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                  <label for="penerbit" class="form-label">Penerbit / Lembaga</label>
                  <input id="penerbit" name="penerbit" type="text" class="form-control"
                         value="{{ old('penerbit', $dokumen->penerbit) }}" placeholder="Instansi penerbit">
                  @error('penerbit') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>
              </div>

              {{-- Halaman dan Format Asli --}}
              <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                  <label for="halaman" class="form-label">Jumlah Halaman</label>
                  <input id="halaman" name="halaman" type="number" min="0"
                         class="form-control"
                         value="{{ old('halaman', $dokumen->halaman) }}" placeholder="Contoh: 120">
                  @error('halaman') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                  <label for="format_asli" class="form-label">Format Asli</label>
                  <input id="format_asli" name="format_asli" type="text" class="form-control"
                         value="{{ old('format_asli', $dokumen->format_asli) }}" placeholder="Contoh: Buku Cetak, Manuskrip, Foto">
                  @error('format_asli') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>
              </div>
            </div>

            {{-- Kolom kanan: File, Status, dan Lainnya --}}
            <div class="space-y-6">
              <h3 class="text-lg font-medium text-gray-900 border-b pb-2">File & Status</h3>
              
              {{-- Format Digital dan Ukuran --}}
              <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                  <label for="format_digital" class="form-label">Format Digital</label>
                  <select id="format_digital" name="format_digital" class="form-control">
                    <option value="">Pilih Format</option>
                    @foreach (['PDF', 'DOC', 'DOCX', 'JPG', 'JPEG', 'PNG', 'TXT', 'MP3', 'MP4', 'ZIP'] as $format)
                      <option value="{{ $format }}" @selected(old('format_digital', $dokumen->format_digital) === $format)>{{ $format }}</option>
                    @endforeach
                  </select>
                  @error('format_digital') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                  <label for="ukuran_file" class="form-label">Ukuran File (bytes)</label>
                  <input id="ukuran_file" name="ukuran_file" type="number" min="0"
                         class="form-control"
                         value="{{ old('ukuran_file', $dokumen->ukuran_file) }}" placeholder="Contoh: 2048000">
                  <p class="mt-1 text-xs text-zinc-500">1 MB = 1,048,576 bytes</p>
                  @error('ukuran_file') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>
              </div>

              {{-- Google Drive Integration --}}
              <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                <h4 class="text-sm font-semibold text-blue-900 mb-3">Google Drive</h4>
                
                <div class="space-y-3">
                  <div>
                    <label for="google_drive_id" class="form-label text-sm">Google Drive File ID</label>
                    <input id="google_drive_id" name="google_drive_id" type="text" class="form-control text-sm"
                           value="{{ old('google_drive_id', $dokumen->google_drive_id) }}" 
                           placeholder="Contoh: 1aB2c3d4e5f6g7h8i9j0">
                    <p class="mt-1 text-xs text-blue-600">
                      Dapatkan dari link: https://drive.google.com/file/d/<strong>FILE_ID</strong>/view
                    </p>
                    @error('google_drive_id') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                  </div>

                  <div>
                    <label for="google_drive_link" class="form-label text-sm">Atau Link Langsung</label>
                    <input id="google_drive_link" name="google_drive_link" type="url" class="form-control text-sm"
                           value="{{ old('google_drive_link', $dokumen->google_drive_link) }}" 
                           placeholder="https://drive.google.com/file/d/.../view">
                    @error('google_drive_link') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                  </div>

                  <div>
                    <label for="google_drive_thumbnail" class="form-label text-sm">Link Thumbnail (Opsional)</label>
                    <input id="google_drive_thumbnail" name="google_drive_thumbnail" type="url" class="form-control text-sm"
                           value="{{ old('google_drive_thumbnail', $dokumen->google_drive_thumbnail) }}" 
                           placeholder="https://drive.google.com/thumbnail?id=...">
                    @error('google_drive_thumbnail') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                  </div>
                </div>
              </div>

              {{-- File Digital Saat Ini --}}
              <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                <h4 class="text-sm font-semibold text-gray-900 mb-3">File Digital Saat Ini</h4>
                
                <div class="space-y-2">
                  @if($dokumen->menggunakan_google_drive)
                    <div class="flex items-center justify-between">
                      <span class="text-sm text-gray-700">Google Drive:</span>
                      <div class="flex items-center gap-2">
                        <a href="{{ $dokumen->link_google_drive }}" target="_blank" 
                           class="text-xs text-blue-600 hover:text-blue-800">
                          Buka di Google Drive
                        </a>
                        @if($dokumen->google_drive_id)
                          <span class="text-xs text-gray-500 font-mono">{{ $dokumen->google_drive_id }}</span>
                        @endif
                      </div>
                    </div>
                  @elseif($dokumen->file_digital_path)
                    <div class="flex items-center justify-between">
                      <span class="text-sm text-gray-700">File Lokal:</span>
                      <div class="flex items-center gap-2">
                        <a href="{{ Storage::url($dokumen->file_digital_path) }}" 
                           class="text-xs text-blue-600 hover:text-blue-800">
                          {{ basename($dokumen->file_digital_path) }}
                        </a>
                        <span class="text-xs text-gray-500">
                          ({{ $dokumen->ukuran_file_formatted }})
                        </span>
                      </div>
                    </div>
                    <div class="flex items-center mt-2">
                      <input id="hapus_file_digital" name="hapus_file_digital" type="checkbox" 
                             class="h-4 w-4 text-red-600 border-gray-300 rounded"
                             value="1">
                      <label for="hapus_file_digital" class="ml-2 text-sm text-gray-700">
                        Hapus file saat ini
                      </label>
                    </div>
                  @else
                    <p class="text-sm text-gray-500 italic">Tidak ada file digital</p>
                  @endif
                </div>
              </div>

              {{-- Upload File Baru --}}
              <div x-data="{ filename: null }">
                <label for="file_digital" class="form-label">
                  Upload File Baru (Opsional)
                  <span class="text-xs text-zinc-500">(Maks 20MB)</span>
                </label>
                <input id="file_digital" name="file_digital" type="file"
                       class="mt-1 block w-full text-sm text-gray-700 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100"
                       x-on:change="filename = $event.target.files[0]?.name || null;">
                <template x-if="filename">
                  <p class="mt-1 text-xs text-gray-500">
                    File baru: <span x-text="filename"></span>
                  </p>
                </template>
                <p class="mt-1 text-xs text-zinc-500">
                  Kosongkan jika tidak ingin mengubah file.
                </p>
                @error('file_digital') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
              </div>

              {{-- Thumbnail --}}
              <div x-data="{ filename: null, previewUrl: '{{ $dokumen->thumbnail_url }}' }">
                <label for="thumbnail" class="form-label">
                  Thumbnail (Gambar)
                  <span class="text-xs text-zinc-500">(JPG/PNG/WebP, maks 2MB)</span>
                </label>
                <div class="mt-2 flex items-center gap-4">
                  <div class="shrink-0">
                    <template x-if="previewUrl">
                      <img :src="previewUrl" 
                           class="h-24 w-24 object-cover rounded-md border shadow-sm">
                    </template>
                    <template x-if="!previewUrl">
                      <div class="h-24 w-24 bg-gray-100 border-2 border-dashed border-gray-300 rounded-md flex items-center justify-center">
                        <svg class="h-8 w-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                      </div>
                    </template>
                  </div>
                  <div class="flex-1 space-y-2">
                    <div>
                      <input id="thumbnail" name="thumbnail" type="file"
                             class="block w-full text-sm text-gray-700 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100"
                             accept="image/*"
                             x-on:change="
                               filename = $event.target.files[0]?.name || null;
                               if ($event.target.files[0]) {
                                 previewUrl = URL.createObjectURL($event.target.files[0]);
                               }
                             ">
                      <template x-if="filename">
                        <p class="mt-1 text-xs text-gray-500">
                          File baru: <span x-text="filename"></span>
                        </p>
                      </template>
                    </div>
                    
                    @if($dokumen->thumbnail_path)
                      <div class="flex items-center">
                        <input id="hapus_thumbnail" name="hapus_thumbnail" type="checkbox" 
                               class="h-4 w-4 text-red-600 border-gray-300 rounded"
                               value="1">
                        <label for="hapus_thumbnail" class="ml-2 text-sm text-gray-700">
                          Hapus thumbnail saat ini
                        </label>
                      </div>
                    @endif
                  </div>
                </div>
                @error('thumbnail') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
              </div>

              {{-- Informasi Sumber --}}
              <div class="space-y-4">
                <h4 class="text-sm font-semibold text-gray-900">Informasi Sumber</h4>
                
                <div>
                  <label for="sumber" class="form-label text-sm">Sumber / Lembaga Pemilik</label>
                  <input id="sumber" name="sumber" type="text" class="form-control text-sm"
                         value="{{ old('sumber', $dokumen->sumber) }}" placeholder="Contoh: Kementerian Agama Prov. Gorontalo">
                  @error('sumber') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                  <label for="lembaga" class="form-label text-sm">Lembaga Terkait (Opsional)</label>
                  <input id="lembaga" name="lembaga" type="text" class="form-control text-sm"
                         value="{{ old('lembaga', $dokumen->lembaga) }}" placeholder="Contoh: Pusat Studi, MUI">
                  @error('lembaga') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                  <label for="lokasi_fisik" class="form-label text-sm">Lokasi Fisik</label>
                  <input id="lokasi_fisik" name="lokasi_fisik" type="text" class="form-control text-sm"
                         value="{{ old('lokasi_fisik', $dokumen->lokasi_fisik) }}" placeholder="Contoh: Ruang Arsip PSBSD, Lemari A Rak 2">
                  @error('lokasi_fisik') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>
              </div>

              {{-- Pengaturan Publikasi --}}
              <div class="border-t pt-4 mt-4">
                <h4 class="text-sm font-semibold text-gray-900 mb-3">Pengaturan Publikasi</h4>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                  <div>
                    <label for="prioritas" class="form-label text-sm">Prioritas</label>
                    <input id="prioritas" name="prioritas" type="number" min="0" max="10"
                           class="form-control text-sm"
                           value="{{ old('prioritas', $dokumen->prioritas) }}" placeholder="0">
                    <p class="mt-1 text-xs text-zinc-500">0-10, 0 = normal</p>
                  </div>

                  <div>
                    <label for="urutan" class="form-label text-sm">Urutan Tampil</label>
                    <input id="urutan" name="urutan" type="number" min="0"
                           class="form-control text-sm"
                           value="{{ old('urutan', $dokumen->urutan) }}" placeholder="0">
                  </div>
                </div>

                <div class="space-y-3 mt-4">
                  <div class="flex items-center">
                    <input id="is_published" name="is_published" type="checkbox" 
                           class="h-4 w-4 text-indigo-600 border-gray-300 rounded"
                           value="1" {{ old('is_published', $dokumen->is_published) ? 'checked' : '' }}>
                    <label for="is_published" class="ml-2 block text-sm text-gray-900">
                      Publikasikan dokumen
                    </label>
                  </div>
                  
                  <div class="flex items-center">
                    <input id="is_utama" name="is_utama" type="checkbox" 
                           class="h-4 w-4 text-indigo-600 border-gray-300 rounded"
                           value="1" {{ old('is_utama', $dokumen->is_utama) ? 'checked' : '' }}>
                    <label for="is_utama" class="ml-2 block text-sm text-gray-900">
                      Tandai sebagai dokumen utama
                    </label>
                  </div>
                </div>

                <div class="mt-3">
                  <label for="published_at" class="form-label text-sm">Tanggal Publikasi (Opsional)</label>
                  <input id="published_at" name="published_at" type="date" class="form-control text-sm"
                         value="{{ old('published_at', $dokumen->published_at ? $dokumen->published_at->format('Y-m-d') : '') }}">
                  <p class="mt-1 text-xs text-zinc-500">Kosongkan untuk publikasi langsung</p>
                </div>
              </div>

              {{-- Catatan --}}
              <div>
                <label for="catatan" class="form-label">Catatan Tambahan</label>
                <textarea id="catatan" name="catatan" rows="3" class="form-control text-sm"
                          placeholder="Catatan internal, proses digitalisasi, dll.">{{ old('catatan', $dokumen->catatan) }}</textarea>
                @error('catatan') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
              </div>
            </div>
          </div>

          <div class="flex items-center justify-between pt-6 border-t">
            <div>
              <a href="{{ $dokumen->koleksi_dokumen_id ? route('admin.publikasi-data.dokumen.index', ['koleksi' => $dokumen->koleksi_dokumen_id]) : route('admin.publikasi-data.dokumen.index') }}"
                 class="px-4 py-2 border rounded-md text-zinc-700 hover:bg-zinc-50 text-sm">
                Kembali ke Daftar
              </a>
            </div>
            
            <div class="flex items-center gap-3">
              <button type="button" onclick="history.back()"
                      class="px-4 py-2 border rounded-md text-zinc-700 hover:bg-zinc-50 text-sm">
                Batal
              </button>

              <button type="submit"
                      class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                Update Dokumen
              </button>
            </div>
          </div>

        </form>
      </div>

      {{-- Info Panel --}}
      <div class="mt-6 p-4 bg-blue-50 border border-blue-200 rounded-md">
        <div class="flex items-start">
          <svg class="h-5 w-5 text-blue-500 mt-0.5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
          </svg>
          <div class="text-sm text-blue-700">
            <strong class="font-semibold">Statistik Dokumen:</strong>
            <ul class="list-disc ml-4 mt-1 space-y-1">
              <li>Dilihat: {{ $dokumen->view_count }} kali</li>
              <li>Diunduh: {{ $dokumen->download_count }} kali</li>
              <li>Terakhir diupdate: {{ $dokumen->updated_at->format('d/m/Y H:i') }}</li>
              @if($dokumen->menggunakan_google_drive)
                <li>File disimpan di Google Drive</li>
              @elseif($dokumen->file_digital_path)
                <li>File disimpan lokal ({{ $dokumen->ukuran_file_formatted }})</li>
              @endif
            </ul>
          </div>
        </div>
      </div>

    </div>
  </div>

  @push('scripts')
    <script>
      document.addEventListener('DOMContentLoaded', function() {
        // Auto-generate slug from judul (if empty)
        const judulInput = document.getElementById('judul');
        const slugInput = document.getElementById('slug');
        
        if (judulInput && slugInput) {
          // Set manual flag if slug already has value
          if (slugInput.value !== '') {
            slugInput.dataset.manual = 'true';
          }
          
          judulInput.addEventListener('input', function() {
            if (!slugInput.dataset.manual && slugInput.value === '') {
              const slug = this.value
                .toLowerCase()
                .replace(/[^\w\s-]/g, '')
                .replace(/\s+/g, '-')
                .replace(/-+/g, '-')
                .trim();
              slugInput.value = slug;
            }
          });
          
          slugInput.addEventListener('input', function() {
            this.dataset.manual = 'true';
          });
        }
        
        // Auto-detect file format when uploading new file
        const fileInput = document.getElementById('file_digital');
        const formatSelect = document.getElementById('format_digital');
        const ukuranInput = document.getElementById('ukuran_file');
        
        if (fileInput && formatSelect && ukuranInput) {
          fileInput.addEventListener('change', function() {
            if (this.files && this.files[0]) {
              const fileName = this.files[0].name;
              const extension = fileName.split('.').pop().toUpperCase();
              
              // Update file size
              ukuranInput.value = this.files[0].size;
              
              // Update format if not already set
              if (formatSelect.value === '' && ['PDF', 'DOC', 'DOCX', 'JPG', 'JPEG', 'PNG', 'TXT', 'MP3', 'MP4', 'ZIP'].includes(extension)) {
                formatSelect.value = extension;
              }
            }
          });
        }
        
        // Toggle hapus file checkbox
        const hapusFileCheckbox = document.getElementById('hapus_file_digital');
        const hapusThumbnailCheckbox = document.getElementById('hapus_thumbnail');
        
        if (hapusFileCheckbox) {
          hapusFileCheckbox.addEventListener('change', function() {
            if (this.checked) {
              if (confirm('File akan dihapus permanen. Lanjutkan?')) {
                // Optional: disable file input
                if (fileInput) fileInput.disabled = true;
              } else {
                this.checked = false;
              }
            } else {
              if (fileInput) fileInput.disabled = false;
            }
          });
        }
        
        if (hapusThumbnailCheckbox) {
          hapusThumbnailCheckbox.addEventListener('change', function() {
            if (this.checked) {
              if (confirm('Thumbnail akan dihapus. Lanjutkan?')) {
                // Optional: disable thumbnail input
                const thumbnailInput = document.getElementById('thumbnail');
                if (thumbnailInput) thumbnailInput.disabled = true;
              } else {
                this.checked = false;
              }
            } else {
              const thumbnailInput = document.getElementById('thumbnail');
              if (thumbnailInput) thumbnailInput.disabled = false;
            }
          });
        }
      });
    </script>
  @endpush
</x-app-layout>