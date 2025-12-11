{{-- resources/views/admin/artikel/create.blade.php --}}
<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      {{ __('Menu Artikel') }} — Tambah Artikel
    </h2>
  </x-slot>

  <div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 ">

      <div class="mb-4 flex items-center justify-between">
        <button type="button"
                class="inline-flex items-center gap-2 px-3 py-2 rounded-md border text-zinc-700 bg-zinc-50 hover:bg-white"
                onclick="(document.referrer ? history.back() : (window.location='{{ route('admin.publikasi-data.artikel.index') }}'))">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M15 18l-6-6 6-6"/></svg>
          Kembali
        </button>
        <span class="text-xs text-zinc-500">Form tambah artikel</span>
      </div>

      <div class="bg-white shadow-sm sm:rounded-lg p-6">
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

        {{-- ✅ Tambahkan id="form-artikel" --}}
        <form id="form-artikel"
              action="{{ route('admin.publikasi-data.artikel.store') }}"
              method="POST" enctype="multipart/form-data" class="space-y-8" data-theme="light">
          @csrf

          {{-- Judul + slug --}}
          <div class="grid md:grid-cols-3 gap-6">
            <div class="md:col-span-3">
              <label for="judul" class="form-label">Judul</label>
              <input id="judul" name="judul" type="text" class="form-control"
                     value="{{ old('judul') }}" placeholder="Judul artikel"/>
              @error('judul') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror

              <input id="slug" name="slug" type="hidden" value="{{ old('slug') }}">
              <div class="mt-2 flex items-center gap-3">
                <p id="slugPreview" class="text-xs text-zinc-500">
                  Slug: <span class="font-mono opacity-80">{{ old('slug') ?: '—' }}</span>
                </p>
                <label class="inline-flex items-center gap-2 text-xs text-zinc-600">
                  <input id="syncSlug" type="checkbox" class="checkbox" checked title="Perbarui slug saat judul diubah">
                  <span>Perbarui slug otomatis saat judul berubah</span>
                </label>
              </div>
            </div>
          </div>

          {{-- Kategori & Tag --}}
          <div class="grid md:grid-cols-3 gap-6">
            <div>
              <label for="kategori" class="form-label">Kategori</label>
              @php $kategoriOld = old('kategori', 'Publikasi'); @endphp
              <select id="kategori" name="kategori" class="form-control">
                @foreach (['Opini','Esai','Analisis','Publikasi'] as $opt)
                  <option value="{{ $opt }}" @selected($kategoriOld===$opt)>{{ $opt }}</option>
                @endforeach
              </select>
              @error('kategori') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>
            <div class="md:col-span-2">
              <label for="tag" class="form-label">Tag (pisahkan dengan koma)</label>
              <input id="tag" name="tag" type="text" class="form-control"
                     value="{{ old('tag') }}" placeholder="bahasa gorontalo, arsip, penelitian"/>
              @error('tag') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>
          </div>

          {{-- Penulis (manual, multi penulis dipisahkan koma) --}}
          <div>
            <label for="penulis" class="block text-sm font-medium text-zinc-700">
              Penulis <span class="text-xs text-zinc-500">(pisahkan dengan koma)</span>
            </label>
            <input id="penulis" name="penulis" type="text"
                   class="mt-1 w-full border rounded-md px-3 py-2"
                   value="{{ old('penulis') }}"
                   placeholder="Contoh: S. Rahim, A. Nur, M. Latu">
            @error('penulis')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
          </div>

          {{-- Ringkasan --}}
          <div>
            <label for="ringkasan" class="form-label">Ringkasan (excerpt)</label>
            <textarea id="ringkasan" name="ringkasan" rows="3" class="form-control"
              placeholder="Ringkas isi artikel dalam 1–2 kalimat.">{{ old('ringkasan') }}</textarea>
            @error('ringkasan') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
          </div>

          {{-- Konten: Quill --}}
          <div>
            <label class="form-label">Konten</label>
            <input type="hidden" id="konten" name="konten" value="{{ old('konten') }}">
            <div id="editor" class="bg-white"></div>
            @error('konten') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
          </div>

          {{-- Thumbnail --}}
          <div x-data="{ preview: null }">
            <label for="thumbnail" class="form-label">Gambar Utama (thumbnail)</label>
            <input id="thumbnail" name="thumbnail" type="file" accept="image/*" class="form-file"
                   @change="
                     const [f] = $event.target.files;
                     if (!f) { preview = null; return; }
                     const r = new FileReader(); r.onload = e => preview = e.target.result; r.readAsDataURL(f);
                   ">
            @error('thumbnail') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror

            <template x-if="preview">
              <div class="mt-3">
                <p class="text-xs text-zinc-500 mb-1">Preview:</p>
                <img :src="preview" alt="Preview Thumbnail" class="max-h-56 rounded border border-zinc-200 bg-white p-1">
              </div>
            </template>
          </div>

          {{-- Tanggal Terbit --}}
          <div class="grid md:grid-cols-3 gap-6">
            <div>
              <label for="published_at" class="form-label">Tanggal Terbit (opsional)</label>
              <input id="published_at" name="published_at" type="datetime-local" class="form-control"
                     value="{{ old('published_at') }}">
              @error('published_at') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>
          </div>

          <div class="flex items-center justify-end gap-2 pt-2">
            <a href="{{ route('admin.publikasi-data.artikel.index') }}"
               class="px-4 py-2 border rounded-md text-zinc-700 hover:bg-zinc-50">Batal</a>

            <button type="submit"
                    class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
              Simpan
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>

  {{-- ✅ Muat CSS Quill di HEAD --}}
  @push('head')
    <link href="https://cdn.jsdelivr.net/npm/quill@1.3.7/dist/quill.snow.css" rel="stylesheet">
  @endpush

  @push('scripts')
    {{-- Jika Alpine sudah via Vite, abaikan CDN Alpine --}}
    {{-- <script src="//unpkg.com/alpinejs" defer></script> --}}

    <script src="https://cdn.jsdelivr.net/npm/quill@1.3.7/dist/quill.min.js"></script>
    <script>
      // debounce + slugify (opsional, sama seperti sebelumnya)
      function debounce(fn, wait=250){ let t; return (...a)=>{ clearTimeout(t); t=setTimeout(()=>fn(...a), wait); }; }
      function slugify(text){
        return (text||'')
          .normalize('NFKD').replace(/[\u0300-\u036f]/g, '')
          .replace(/[^a-zA-Z0-9\s-]/g, '').trim().toLowerCase()
          .replace(/[\s_-]+/g,'-').replace(/^-+|-+$/g,'');
      }
      (function(){
        const judul=document.getElementById('judul');
        const slug=document.getElementById('slug');
        const prev=document.querySelector('#slugPreview span');
        const sync=document.getElementById('syncSlug');
        if(!judul||!slug) return;
        prev.textContent = slug.value || '—';
        const update = debounce(()=>{
          if(!sync?.checked) return;
          const s=slugify(judul.value||''); slug.value=s; prev.textContent=s||'—';
        },150);
        ['input','change','paste'].forEach(e=>judul.addEventListener(e,update));
      })();

      // Inisialisasi Quill
      const toolbar = [
        [{ header: [1, 2, 3, false] }],
        ['bold', 'italic', 'underline'],
        [{ 'list': 'ordered'}, { 'list': 'bullet' }],
        ['link', 'image', 'blockquote', 'code-block'],
        [{ 'align': [] }],
        ['clean']
      ];
      const quill = new Quill('#editor', {
        theme: 'snow',
        placeholder: 'Tulis isi artikel di sini...',
        modules: { toolbar: { container: toolbar, handlers: { image: imageHandler } } }
      });

      // Prefill old('konten')
      (function prefill(){
        const html = document.getElementById('konten').value || '';
        if (html.trim()) quill.clipboard.dangerouslyPasteHTML(html);
      })();

      // ✅ Submit ke hidden input
      document.getElementById('form-artikel').addEventListener('submit', () => {
        document.getElementById('konten').value = quill.root.innerHTML;
      });

      // Upload gambar inline
      async function imageHandler() {
        const input = document.createElement('input');
        input.type='file'; input.accept='image/*'; input.click();
        input.onchange = async () => {
          const file = input.files?.[0]; if (!file) return;
          try {
            const formData = new FormData();
            formData.append('file', file);
            const res = await fetch('{{ route("admin.upload.inline") }}', {
              method: 'POST',
              headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
              body: formData
            });
            if (!res.ok) throw new Error('Upload gagal');
            const { location } = await res.json();
            const range = quill.getSelection(true) || { index: quill.getLength() };
            quill.insertEmbed(range.index, 'image', location, Quill.sources.USER);
            quill.setSelection(range.index + 1);
          } catch(e) {
            alert('Gagal mengunggah gambar.');
            console.error(e);
          }
        };
      }
    </script>
    <style>
      #editor .ql-editor{ min-height:320px; font-size:14px; }
      .ql-toolbar.ql-snow, .ql-container.ql-snow{ border-color:#e5e7eb; }
    </style>
  @endpush
</x-app-layout>
