{{-- resources/views/admin/artikel/edit.blade.php --}}
<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      {{ __('Menu Artikel') }} — Edit Artikel
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
        <span class="text-xs text-zinc-500">Form edit artikel</span>
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

        @php
          $kategoriOld = old('kategori', $artikel->kategori ?? 'Publikasi');
          $slugOld     = old('slug', $artikel->slug ?? '');
          $kontenOld   = old('konten', $artikel->konten ?? '');
          $publishedOld = old(
            'published_at',
            optional($artikel->published_at)->format('Y-m-d\TH:i')
          );
        @endphp

        {{-- ✅ id="form-artikel" tetap sama untuk JS --}}
        <form id="form-artikel"
              action="{{ route('admin.publikasi-data.artikel.update', $artikel->id) }}"
              method="POST" enctype="multipart/form-data" class="space-y-8" data-theme="light">
          @csrf
          @method('PUT')

          {{-- Judul + slug --}}
          <div class="grid md:grid-cols-3 gap-6">
            <div class="md:col-span-3">
              <label for="judul" class="form-label">Judul</label>
              <input id="judul" name="judul" type="text" class="form-control"
                     value="{{ old('judul', $artikel->judul) }}" placeholder="Judul artikel"/>
              @error('judul') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror

              <input id="slug" name="slug" type="hidden" value="{{ $slugOld }}">
              <div class="mt-2 flex items-center gap-3">
                <p id="slugPreview" class="text-xs text-zinc-500">
                  Slug: <span class="font-mono opacity-80">{{ $slugOld ?: '—' }}</span>
                </p>
                <label class="inline-flex items-center gap-2 text-xs text-zinc-600">
                  {{-- Di edit, bisa kamu set default: unchecked, biar slug tidak auto berubah --}}
                  <input id="syncSlug" type="checkbox" class="checkbox" title="Perbarui slug saat judul diubah">
                  <span>Perbarui slug otomatis saat judul berubah</span>
                </label>
              </div>
            </div>
          </div>

          {{-- Kategori & Tag --}}
          <div class="grid md:grid-cols-3 gap-6">
            <div>
              <label for="kategori" class="form-label">Kategori</label>
              <select id="kategori" name="kategori" class="form-control">
                @foreach (['Kegiatan','Pengumuman','Rilis','Opini','Publikasi'] as $opt)
                  <option value="{{ $opt }}" @selected($kategoriOld===$opt)>{{ $opt }}</option>
                @endforeach
              </select>
              @error('kategori') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>
            <div class="md:col-span-2">
              <label for="tag" class="form-label">Tag (pisahkan dengan koma)</label>
              <input id="tag" name="tag" type="text" class="form-control"
                     value="{{ old('tag', $artikel->tag) }}" placeholder="bahasa gorontalo, arsip, penelitian"/>
              @error('tag') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>
          </div>

          {{-- Penulis --}}
          <div>
            <label for="penulis" class="block text-sm font-medium text-zinc-700">
              Penulis <span class="text-xs text-zinc-500">(pisahkan dengan koma)</span>
            </label>
            <input id="penulis" name="penulis" type="text"
                   class="mt-1 w-full border rounded-md px-3 py-2"
                   value="{{ old('penulis', $artikel->penulis) }}"
                   placeholder="Contoh: S. Rahim, A. Nur, M. Latu">
            @error('penulis')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
          </div>

          {{-- Ringkasan --}}
          <div>
            <label for="ringkasan" class="form-label">Ringkasan (excerpt)</label>
            <textarea id="ringkasan" name="ringkasan" rows="3" class="form-control"
              placeholder="Ringkas isi artikel dalam 1–2 kalimat.">{{ old('ringkasan', $artikel->ringkasan) }}</textarea>
            @error('ringkasan') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
          </div>

          {{-- Konten: Quill --}}
          <div>
            <label class="form-label">Konten</label>
            <input type="hidden" id="konten" name="konten" value="{{ $kontenOld }}">
            <div id="editor" class="bg-white"></div>
            @error('konten') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
          </div>

          {{-- Thumbnail --}}
          <div x-data="{ preview: null }">
            <label for="thumbnail" class="form-label">Gambar Utama (thumbnail)</label>

            @if($artikel->thumbnail_path)
              <div class="mb-3">
                <p class="text-xs text-zinc-500 mb-1">Thumbnail saat ini:</p>
                <img src="{{ Storage::url($artikel->thumbnail_path) }}"
                     alt="{{ $artikel->judul }}"
                     class="max-h-40 rounded border border-zinc-200 bg-white p-1">
              </div>
            @endif

            <input id="thumbnail" name="thumbnail" type="file" accept="image/*" class="form-file"
                   @change="
                     const [f] = $event.target.files;
                     if (!f) { preview = null; return; }
                     const r = new FileReader(); r.onload = e => preview = e.target.result; r.readAsDataURL(f);
                   ">
            @error('thumbnail') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror

            <template x-if="preview">
              <div class="mt-3">
                <p class="text-xs text-zinc-500 mb-1">Preview baru:</p>
                <img :src="preview" alt="Preview Thumbnail" class="max-h-56 rounded border border-zinc-200 bg-white p-1">
              </div>
            </template>
          </div>

          {{-- Tanggal Terbit --}}
          <div class="grid md:grid-cols-3 gap-6">
            <div>
              <label for="published_at" class="form-label">Tanggal Terbit (opsional)</label>
              <input id="published_at" name="published_at" type="datetime-local" class="form-control"
                     value="{{ $publishedOld }}">
              @error('published_at') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>
          </div>

          <div class="flex items-center justify-end gap-2 pt-2">
            <a href="{{ route('admin.publikasi-data.artikel.index') }}"
               class="px-4 py-2 border rounded-md text-zinc-700 hover:bg-zinc-50">Batal</a>

            <button type="submit"
                    class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
              Simpan Perubahan
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>

  @push('head')
    <link href="https://cdn.jsdelivr.net/npm/quill@1.3.7/dist/quill.snow.css" rel="stylesheet">
  @endpush

  @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/quill@1.3.7/dist/quill.min.js"></script>
    <script>
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
        if(!judul||!slug||!prev) return;

        // Pastikan preview awal sesuai nilai slug existing
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

      // Prefill konten dari hidden input
      (function prefill(){
        const html = document.getElementById('konten').value || '';
        if (html.trim()) quill.clipboard.dangerouslyPasteHTML(html);
      })();

      // Submit: isi hidden input dengan HTML dari Quill
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
