{{-- FOOTER --}}
<footer class="bg-zinc-100 text-zinc-800 border-t border-zinc-300">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="grid md:grid-cols-4 gap-8">
      
      {{-- LOGO & DESKRIPSI --}}
      <div>
        <div class="flex items-center mb-4">
          {{-- <img class="h-12 mr-3" src="{{ asset('images/logoPusatStudi.png') }}" alt="Pusat Studi"> --}}
          <span class="font-bold text-xl text-zinc-900">PSPBSD</span>
        </div>
        <p class="text-zinc-600 text-sm leading-relaxed">
          Pusat Studi Pelestarian Bahasa dan Sastra Daerah - 
          Melestarikan warisan budaya bangsa melalui penelitian dan inovasi.
        </p>
        <div class="mt-6 flex space-x-4">
          <a href="#" class="text-zinc-500 hover:text-zinc-900 transition-colors" title="Facebook">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
              <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
            </svg>
          </a>
          <a href="#" class="text-zinc-500 hover:text-zinc-900 transition-colors" title="Twitter/X">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
              <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
            </svg>
          </a>
          <a href="#" class="text-zinc-500 hover:text-zinc-900 transition-colors" title="Instagram">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
              <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zM5.838 12a6.162 6.162 0 1112.324 0 6.162 6.162 0 01-12.324 0zM12 16a4 4 0 110-8 4 4 0 010 8zm4.965-10.405a1.44 1.44 0 112.881.001 1.44 1.44 0 01-2.881-.001z"/>
            </svg>
          </a>
          <a href="#" class="text-zinc-500 hover:text-zinc-900 transition-colors" title="YouTube">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
              <path d="M23.498 6.186a3.016 3.016 0 00-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 00.502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 002.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 002.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
            </svg>
          </a>
        </div>
      </div>

      {{-- TENTANG KAMI (Sesuai Navbar) --}}
      <div>
        <h4 class="font-semibold text-zinc-900 mb-4 text-lg">Tentang Kami</h4>
        <ul class="space-y-2 text-sm">
          <li><a href="{{ route('visi-misi') }}" class="text-zinc-600 hover:text-zinc-900 transition-colors">Visi Misi</a></li>
          <li><a href="{{ route('struktur-organisasi') }}" class="text-zinc-600 hover:text-zinc-900 transition-colors">Struktur Organisasi</a></li>
          <li><a href="{{ route('guest.kebijakan.index') }}" class="text-zinc-600 hover:text-zinc-900 transition-colors">Kebijakan & Tata Kelola</a></li>
          <li><a href="{{ route('guest.mitra.index') }}" class="text-zinc-600 hover:text-zinc-900 transition-colors">Mitra</a></li>
          <li><a href="{{ route('guest.peneliti.index') }}" class="text-zinc-600 hover:text-zinc-900 transition-colors">Profil Peneliti</a></li>
        </ul>
      </div>

      {{-- PUBLIKASI (Sesuai Navbar) --}}
      <div>
        <h4 class="font-semibold text-zinc-900 mb-4 text-lg">Publikasi</h4>
        <ul class="space-y-2 text-sm">
          <li><a href="#" class="text-zinc-600 hover:text-zinc-900 transition-colors">Penelitian</a></li>
          <li><a href="{{ route('guest.artikel.index') }}" class="text-zinc-600 hover:text-zinc-900 transition-colors">Artikel</a></li>
          <li><a href="{{ route('guest.dokumen.index') }}" class="text-zinc-600 hover:text-zinc-900 transition-colors">Repositori Dokumen</a></li>
          <li><a href="{{ route('galeri.albums.beranda') }}" class="text-zinc-600 hover:text-zinc-900 transition-colors">Media (Foto/Video)</a></li>
          <li><a href="{{ route('guest.berita.index') }}" class="text-zinc-600 hover:text-zinc-900 transition-colors">Kegiatan Terbaru</a></li>
        </ul>
      </div>

      {{-- INFORMASI KONTAK --}}
      <div>
        <h4 class="font-semibold text-zinc-900 mb-4 text-lg">Kontak</h4>
        <ul class="space-y-3 text-sm">
          <li class="flex items-start">
            <svg class="w-4 h-4 mt-1 mr-3 text-zinc-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
            <span class="text-zinc-600">Gedung LPPM Universitas Negeri Gorontalo
                    Jl. Jend. Sudirman, Wumialo, Kec. Kota Tengah, Kota Gorontalo, Gorontalo 96138</span>
          </li>
          <li class="flex items-center">
            <svg class="w-4 h-4 mr-3 text-zinc-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
            </svg>
            <span class="text-zinc-600">+62 852 5656 6817</span>
          </li>
          <li class="flex items-center">
            {{-- <svg class="w-4 h-4 mr-3 text-zinc-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
            </svg> --}}
            <span class="text-zinc-600"></span>
          </li>
          <li class="mt-4">
            <a href="{{ route('welcome') . '#kontak' }}" 
               class="inline-flex items-center text-sm bg-zinc-900 text-white px-4 py-2 rounded-md hover:bg-zinc-800 transition-colors">
              <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
              </svg>
              Hubungi Kami
            </a>
          </li>
        </ul>
      </div>
    </div>
  </div>

  {{-- BAGIAN BAWAH FOOTER --}}
  <div class="bg-zinc-900 text-zinc-300 py-6 border-t border-zinc-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex flex-col md:flex-row justify-center items-center">
        <div class="mb-4 md:mb-0">
          <p class="text-sm">
            © {{ date('Y') }} Pusat Studi Pelestarian Bahasa dan Sastra Daerah. All rights reserved.
          </p>
        </div>
        {{-- <div class="flex flex-wrap justify-center gap-6 text-sm">
          <a href="#" class="hover:text-white transition-colors">Kebijakan Privasi</a>
          <a href="#" class="hover:text-white transition-colors">Syarat & Ketentuan</a>
          <a href="#" class="hover:text-white transition-colors">Peta Situs</a>
          <a href="#" class="hover:text-white transition-colors">Aksesibilitas</a>
        </div> --}}
      </div>
      {{-- <div class="mt-4 text-center text-xs text-zinc-500">
        <p>Bagian dari Universitas - Terakreditasi A oleh BAN-PT</p>
      </div> --}}
    </div>
  </div>
</footer>