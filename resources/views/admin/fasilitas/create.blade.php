<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      {{ __('Menu Fasilitas - Tambah Fasilitas Baru') }}
    </h2>
  </x-slot>

  <div class="py-12" data-theme="light">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white shadow-sm sm:rounded-lg p-6">

        <div class="mb-6">
          <a href="{{ route('admin.fasilitas.index') }}" 
             class="inline-flex items-center text-sm text-indigo-600 hover:text-indigo-900 mb-4">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali ke Daftar Fasilitas
          </a>
          <h1 class="text-2xl font-bold text-gray-900">Tambah Fasilitas Baru</h1>
          <p class="text-gray-600 mt-2">Isi form berikut untuk menambahkan fasilitas baru</p>
        </div>

        <form action="{{ route('admin.fasilitas.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
          @csrf

          {{-- Nama Fasilitas --}}
          <div>
            <label for="nama_fasilitas" class="block text-sm font-medium text-gray-700 mb-2">
              Nama Fasilitas <span class="text-red-500">*</span>
            </label>
            <input type="text" 
                   name="nama_fasilitas" 
                   id="nama_fasilitas"
                   value="{{ old('nama_fasilitas') }}"
                   required
                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('nama_fasilitas') border-red-500 @enderror"
                   placeholder="Masukkan nama fasilitas">
            @error('nama_fasilitas')
              <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
          </div>

          {{-- Deskripsi --}}
          <div>
            <label for="deskripsi" class="block text-sm font-medium text-gray-700 mb-2">
              Deskripsi <span class="text-red-500">*</span>
            </label>
            <textarea name="deskripsi" 
                      id="deskripsi" 
                      rows="4"
                      required
                      class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('deskripsi') border-red-500 @enderror"
                      placeholder="Masukkan deskripsi fasilitas">{{ old('deskripsi') }}</textarea>
            @error('deskripsi')
              <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
          </div>

          {{-- Upload Gambar --}}
          <div>
            <label for="gambar" class="block text-sm font-medium text-gray-700 mb-2">
              Gambar Fasilitas <span class="text-red-500">*</span>
            </label>
            <div class="flex items-center justify-center w-full">
              <label for="gambar" class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 @error('gambar') border-red-500 @enderror">
                <div class="flex flex-col items-center justify-center pt-5 pb-6" id="upload-placeholder">
                  <svg class="w-8 h-8 mb-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                  </svg>
                  <p class="mb-2 text-sm text-gray-500"><span class="font-semibold">Klik untuk upload</span> atau drag and drop</p>
                  <p class="text-xs text-gray-500">PNG, JPG, JPEG, GIF (Max. 2MB)</p>
                </div>
                <input id="gambar" name="gambar" type="file" class="hidden" accept="image/*" required />
                <div id="image-preview" class="hidden w-full h-full p-4">
                  <img id="preview-image" class="w-full h-full object-contain rounded-lg" src="" alt="Preview gambar">
                </div>
              </label>
            </div>
            @error('gambar')
              <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
          </div>

          {{-- Alt Text --}}
          <div>
            <label for="alt_text" class="block text-sm font-medium text-gray-700 mb-2">
              Alt Text (Opsional)
            </label>
            <input type="text" 
                   name="alt_text" 
                   id="alt_text"
                   value="{{ old('alt_text') }}"
                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                   placeholder="Teks alternatif untuk aksesibilitas">
            <p class="mt-1 text-sm text-gray-500">Deskripsi singkat gambar untuk aksesibilitas</p>
          </div>

          {{-- Pengaturan Tampilan --}}
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            {{-- Tampil di Beranda --}}
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">
                Pengaturan Tampilan
              </label>
              <div class="flex items-center space-x-3">
                <div class="flex items-center">
                  <input type="checkbox" 
                         name="tampil_beranda" 
                         id="tampil_beranda"
                         value="1"
                         {{ old('tampil_beranda') ? 'checked' : '' }}
                         class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                  <label for="tampil_beranda" class="ml-2 text-sm text-gray-700">
                    Tampilkan di Beranda
                  </label>
                </div>
              </div>
              <p class="mt-1 text-sm text-gray-500">Centang untuk menampilkan fasilitas ini di halaman beranda</p>
            </div>

            {{-- Urutan Tampil --}}
            <div>
              <label for="urutan_tampil" class="block text-sm font-medium text-gray-700 mb-2">
                Urutan Tampil
              </label>
              <input type="number" 
                     name="urutan_tampil" 
                     id="urutan_tampil"
                     value="{{ old('urutan_tampil', 0) }}"
                     min="0"
                     class="w-32 px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
              <p class="mt-1 text-sm text-gray-500">Angka lebih kecil akan ditampilkan lebih awal</p>
            </div>
          </div>

          {{-- Tombol Aksi --}}
          <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
            <a href="{{ route('admin.fasilitas.index') }}" 
               class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
              Batal
            </a>
            <button type="submit" 
                    class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
              Simpan Fasilitas
            </button>
          </div>
        </form>

      </div>
    </div>
  </div>

  @push('scripts')
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const fileInput = document.getElementById('gambar');
      const uploadPlaceholder = document.getElementById('upload-placeholder');
      const imagePreview = document.getElementById('image-preview');
      const previewImage = document.getElementById('preview-image');

      fileInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
          const reader = new FileReader();
          
          reader.onload = function(e) {
            previewImage.src = e.target.result;
            uploadPlaceholder.classList.add('hidden');
            imagePreview.classList.remove('hidden');
          }
          
          reader.readAsDataURL(file);
        } else {
          uploadPlaceholder.classList.remove('hidden');
          imagePreview.classList.add('hidden');
        }
      });

      // Drag and drop functionality
      const dropArea = document.querySelector('label[for="gambar"]');
      
      ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        dropArea.addEventListener(eventName, preventDefaults, false);
      });

      function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
      }

      ['dragenter', 'dragover'].forEach(eventName => {
        dropArea.addEventListener(eventName, highlight, false);
      });

      ['dragleave', 'drop'].forEach(eventName => {
        dropArea.addEventListener(eventName, unhighlight, false);
      });

      function highlight() {
        dropArea.classList.add('border-indigo-500', 'bg-indigo-50');
      }

      function unhighlight() {
        dropArea.classList.remove('border-indigo-500', 'bg-indigo-50');
      }

      dropArea.addEventListener('drop', handleDrop, false);

      function handleDrop(e) {
        const dt = e.dataTransfer;
        const files = dt.files;
        fileInput.files = files;
        
        // Trigger change event
        const event = new Event('change');
        fileInput.dispatchEvent(event);
      }
    });
  </script>
  @endpush

  <style>
    .border-dashed {
      border-style: dashed;
    }
    #upload-placeholder, #image-preview {
      transition: all 0.3s ease;
    }
  </style>
</x-app-layout>