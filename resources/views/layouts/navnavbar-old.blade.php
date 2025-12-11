<!-- NAVBAR PUI-PT -->
<header 
  x-data="navux()" 
  x-init="init()" 
  @keydown.escape="closeAll()" 
  class="sticky top-0 z-50 bg-base-100 transition-shadow"
  :class="{'shadow-sm': scrolled}"
>
  <nav class="navbar mx-auto px-4 md:px-8 lg:px-16 py-4">

    <!-- START -->
    <div class="navbar-start gap-2">
      <!-- Mobile burger -->
      <button class="btn btn-ghost lg:hidden" @click="mobileOpen = !mobileOpen" :aria-expanded="mobileOpen" aria-controls="mobileMenu" aria-label="Buka menu">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
        </svg>
      </button>

      <!-- Logo -->
      <a href="/" class="inline-flex items-center">
        <img class="h-10 md:h-12" src="{{ asset('images/logoPusatStudi.png') }}" alt="Pusat Studi">
      </a>
    </div>

    <!-- CENTER — Desktop menu -->
    <div class="navbar-center hidden lg:flex">
      <ul class="menu menu-horizontal gap-1 text-[15px] md:text-base">
        <!-- Beranda -->
        <li>
          <a href="{{ url('/') }}" class="hover:bg-zinc-200 rounded-none" :class="isActive('/') ? 'active bg-white' : ''">Beranda</a>
        </li>

        {{-- <div
          x-cloak x-show="isOpen('profil')" x-transition.origin.top.left
          @click.outside="close('profil')"1
          class="absolute left-1/2 -translate-x-1/2 mt-6 w-[calc(100vw-2rem)] max-w-[72rem]
                rounded-2xl bg-base-100/95 backdrop-blur shadow-xl ring-1 ring-black/5 z-50"
          role="menu" aria-label="Profil"
        > --}}
  <!-- inner mengikuti padding container navbar (px-4 md:px-8 lg:px-16) -->
  {{-- <div class="px-4 md:px-8 lg:px-16 py-4">

    <!-- header tipis -->
    <div class="flex items-center justify-between border-b border-base-200/70 pb-3">
      <p class="text-sm tracking-wide uppercase text-base-content/70">Profil Lembaga</p>
      <a href="" class="text-sm link">Lihat ringkas »</a>
    </div>

    <!-- grid konten akademik -->
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-2 md:gap-3 pt-3">
          <!-- item -->
          <a href="" class="group flex items-start gap-3 rounded-xl p-3 hover:bg-base-200/60 focus:bg-base-200/60 transition">
            <svg class="mt-0.5 h-5 w-5 opacity-70 group-hover:opacity-100" viewBox="0 0 24 24" fill="none" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 6v12m-6-6h12"/>
            </svg>
            <div>
              <div class="font-medium">Tentang Kami</div>
              <p class="text-sm text-base-content/70">Visi, misi, bidang fokus.</p>
            </div>
          </a>

          <a href="" class="group flex items-start gap-3 rounded-xl p-3 hover:bg-base-200/60 focus:bg-base-200/60 transition">
            <svg class="mt-0.5 h-5 w-5 opacity-70 group-hover:opacity-100" viewBox="0 0 24 24" fill="none" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 5h18M6 10h12M9 15h6M10 20h4"/>
            </svg>
            <div>
              <div class="font-medium">Struktur & SK</div>
              <p class="text-sm text-base-content/70">Organisasi & dokumen legal (PDF).</p>
            </div>
          </a>

          <a href="" class="group flex items-start gap-3 rounded-xl p-3 hover:bg-base-200/60 focus:bg-base-200/60 transition">
            <svg class="mt-0.5 h-5 w-5 opacity-70 group-hover:opacity-100" viewBox="0 0 24 24" fill="none" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 12h7l2 3 3-6 6 0"/>
            </svg>
            <div>
              {{-- <div class="font-medium">Roadmap & Asta Cita</div> --}}
              {{-- <p class="text-sm text-base-content/70">Target 3–5 tahun & alignment.</p>
            </div>
          </a> --}}

          {{-- <a href="" class="group flex items-start gap-3 rounded-xl p-3 hover:bg-base-200/60 focus:bg-base-200/60 transition">
            <svg class="mt-0.5 h-5 w-5 opacity-70 group-hover:opacity-100" viewBox="0 0 24 24" fill="none" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M7 7h10v10H7zM3 3h18v18H3z"/>
            </svg>
            <div>
              <div class="font-medium">Kebijakan & Tata Kelola</div>
              <p class="text-sm text-base-content/70">SOP, akses fasilitas bersama.</p>
            </div>
          </a>

          <a href="" class="group flex items-start gap-3 rounded-xl p-3 hover:bg-base-200/60 focus:bg-base-200/60 transition">
            <svg class="mt-0.5 h-5 w-5 opacity-70 group-hover:opacity-100" viewBox="0 0 24 24" fill="none" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 11a4 4 0 118 0 4 4 0 01-8 0zM2 20a8 8 0 0120 0"/>
            </svg>
            <div>
              <div class="font-medium">Mitra Strategis</div>
              <p class="text-sm text-base-content/70">Jejaring nasional & internasional.</p>
            </div>
          </a>
        </div>
      </div>  --}}
    {{-- </div> --}}

        <!-- Profil -->
        <li class="relative" @mouseenter="openOnHover('profil')" @mouseleave="close('profil')">
          <button class="btn btn-ghost px-3 hover:border-b border-black rounded-none w-fit " @click="toggle('profil')" :aria-expanded="isOpen('profil')" aria-haspopup="menu">
            <span>Tentang Kami</span>
                <svg class="ml-1 h-3 w-3 transition-transform duration-200" :class="isOpen('profil') ? 'rotate-180' : ''" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 10 6" fill="none" stroke="currentColor" >
            <path d="M1 1l4 4 4-4" />
          </svg>
          </button>
          <ul x-cloak x-show="isOpen('profil')" x-transition.origin.top.left
              @click.outside="close('profil')"
                class="menu dropdown-content absolute left-0 mt-10 w-72 bg-base-100 p-2 border border-zinc-500  z-50">
              {{-- <li><a href=" ">Tentang Kami</a></li>
              <li><a href=" ">Struktur & SK</a></li>
              {{-- <li><a href=" ">Roadmap & Asta Cita</a></li> --}}
              {{-- <li><a href=" ">Kebijakan & Tata Kelola</a></li>
              <li><a href=" ">Mitra Strategis</a></li>  --}}
            <li><a href="{{ route('visi-misi') }}">Visi Misi</a></li> 
            <li><a href="{{ route('struktur-organisasi') }}">Struktur</a></li>
            {{-- {{-- <li><a href="{{ route('roadmap-asta') }}">Roadmap & Asta Cita</a></li> --}} 
            <li><a href="{{ route('guest.kebijakan.index') }}">Kebijakan & Tata Kelola</a></li>
            <li><a href="{{ route('guest.mitra.index') }}">Mitra</a></li>
            <li><a href="{{ route('guest.peneliti.index') }}">Profil Peneliti</a></li>
          </ul>
        </li> 

        <!-- Akademik -->
        {{-- <li class="relative" @mouseenter="openOnHover('akademik')" @mouseleave="close('akademik')">
          <button class="btn btn-ghost px-3 hover:border-b border-black rounded-none w-fit " @click="toggle('akademik')" :aria-expanded="isOpen('akademik')" aria-haspopup="menu">
            <span>Akademik</span>
            <svg class="ml-1 h-3 w-3 transition-transform duration-200" :class="isOpen('akademik') ? 'rotate-180' : ''" viewBox="0 0 10 6" fill="currentColor"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 10 6" fill="none" stroke="currentColor">
              <path d="M1 1l4 4 4-4" />
            </svg>
          </svg>
          </button>
          <ul x-cloak x-show="isOpen('akademik')" x-transition.origin.top.left
              @click.outside="close('akademik')"
              class="menu dropdown-content absolute left-0 mt-10 w-72 bg-base-100 p-2 border border-zinc-500  z-50">
              {{-- <li><a href="{{ route('publikasi') }}">Publikasi</a></li>
              <li><a href="">Jurnal Pusat Studi</a></li>
              <li><a href="">Kegiatan Ilmiah</a></li>
              <li><a href="">Kunjungan Internasional</a></li>
              <li><a href="">Profil Peneliti</a></li>
              <li><a href="">Lulusan S3</a></li> --}}
            {{-- <li><a href="{{ route('publikasi') }}">Publikasi</a></li> --}}
            {{-- <li><a href="{{ route('jurnal') }}">Jurnal Pusat Studi</a></li> --}}
            {{-- <li><a href="{{ route('kegiatan-ilmiah') }}">Kegiatan Ilmiah</a></li> --}}
            {{-- <li><a href="{{ route('international-visit') }}">Kunjungan Internasional</a></li> --}}
            {{-- <li><a href="{{ route('profil-peneliti') }}">Profil Peneliti</a></li> --}}
            {{-- <li><a href="{{ route('lulusan-s3') }}">Lulusan S3</a></li> --}}
          {{-- </ul>
        </li>  --}}

        <!-- Komersialisasi -->
        {{-- <li class="relative" @mouseenter="openOnHover('komersial')" @mouseleave="close('komersial')">
          <button class="btn btn-ghost px-3 hover:border-b border-black rounded-none w-fit " @click="toggle('komersial')" :aria-expanded="isOpen('komersial')" aria-haspopup="menu">
            <span>Komersialisasi</span>
            <svg class="ml-1 h-3 w-3 transition-transform duration-200" :class="isOpen('komersial') ? 'rotate-180' : ''" viewBox="0 0 10 6" fill="currentColor"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 10 6" fill="none" stroke="currentColor">
  <path d="M1 1l4 4 4-4" />
</svg>
</svg>
          </button>
          <ul x-cloak x-show="isOpen('komersial')" x-transition.origin.top.left
              @click.outside="close('komersial')"
              class="menu dropdown-content absolute left-0 mt-10 w-72 bg-base-100 p-2 border border-zinc-500  z-50">
              {{-- <li><a href="">Produk & Inovasi</a></li>
              <li><a href="">Paten & HKI</a></li>
              <li><a href="">Kerja Sama Riset</a></li>
              <li><a href="">Kontrak Non-Riset</a></li>
              <li><a href="">UMKM/Startup Binaan</a></li>
              <li><a href="">Unit Bisnis & Layanan Jasa</a></li> --}}
            {{-- <li><a href="{{ route('produk-inovasi') }}">Produk & Inovasi</a></li>
            <li><a href="{{ route('paten-hki') }}">Paten & HKI</a></li>
            <li><a href="{{ route('kerjasama-riset') }}">Kerja Sama Riset</a></li>
            <li><a href="{{ route('kontrak-nonriset') }}">Kontrak Non-Riset</a></li>
            <li><a href="{{ route('umkm-binaan') }}">UMKM/Startup Binaan</a></li>
            <li><a href="{{ route('unit-bisnis') }}">Unit Bisnis & Layanan Jasa</a></li>
          </ul>
        </li>  --}}

        <!-- Fasilitas -->
        

        <!-- Publikasi -->
        <li class="relative" @mouseenter="openOnHover('data')" @mouseleave="close('data')">
          <button class="btn btn-ghost px-3 hover:border-b border-black rounded-none w-fit " @click="toggle('data')" :aria-expanded="isOpen('data')" aria-haspopup="menu">
            <span>Publikasi</span>
            <svg class="ml-1 h-3 w-3 transition-transform duration-200" :class="isOpen('data') ? 'rotate-180' : ''" viewBox="0 0 10 6" fill="currentColor"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 10 6" fill="none" stroke="currentColor">
  <path d="M1 1l4 4 4-4" />
</svg>
</svg>
          </button>
          <ul x-cloak x-show="isOpen('data')" x-transition.origin.top.left
              @click.outside="close('data')"
              class="menu dropdown-content absolute left-0 mt-10 w-72 bg-base-100 p-2 border border-zinc-500  z-50">
              {{-- <li><a href="">Data Room</a></li>
              <li><a href="">Dashboard KPI</a></li>
              <li><a href="">Dokumen Resmi</a></li> --}}
              {{-- <li><a href="">Media (Foto/Video)</a></li>
              <li><a href="">Berita & Agenda</a></li> --}}
            {{-- <li><a href="{{ route('data-room') }}">Data Room (Borang/Asesmen)</a></li>
            <li><a href="{{ route('dashboard-kpi') }}">Dashboard KPI</a></li>
            {{-- <li><a href="{{ route('dokumen-resmi') }}">Dokumen Resmi</a></li> --}}
            
            <li><a href="{{ route('guest.dokumen.index') }}">Repositori Dokumen</a></li>
            <li><a href="{{ route('guest.artikel.index') }}">Artikel</a></li>
            <li><a href="{{ route('galeri.albums.beranda') }}">Media (Foto/Video)</a></li>
            <li><a href="{{ route('guest.berita.index') }}">Kegiatan Terbaru</a></li>
          </ul>
        </li>

        <li class="relative" @mouseenter="openOnHover('fasilitas')" @mouseleave="close('fasilitas')">
          <button class="btn btn-ghost px-3 hover:border-b hover:border-black rounded-none w-fit   " @click="toggle('fasilitas')" :aria-expanded="isOpen('fasilitas')" aria-haspopup="menu">
            <a href="{{ route('guest.fasilitas.index') }}">
              <span>Fasilitas</span>
            </a>
            {{-- <svg class="ml-1 h-3 w-3 transition-transform duration-200" :class="isOpen('fasilitas') ? 'rotate-180' : ''" viewBox="0 0 10 6" fill="currentColor"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 10 6" fill="none" stroke="currentColor">
                <path d="M1 1l4 4 4-4" />
              </svg>
            </svg> --}}
          </button>
          {{-- <ul x-cloak x-show="isOpen('fasilitas')" x-transition.origin.top.left
              @click.outside="close('fasilitas')"
              class="menu dropdown-content absolute left-0 mt-10 w-72 bg-base-100 p-2 border border-zinc-500  z-50">
              {{-- <li><a href="">Fasilitas Riset / Lab</a></li>
              <li><a href="">SOP & Prosedur</a></li>
              <li><a href="">Program Magang</a></li>
              <li><a href="">Capacity Building & Workshop</a></li>
              <li><a href="">Booking Fasilitas</a></li> --}}
              {{-- <li><a href="{{ route('fasilitas-riset') }}">Fasilitas Riset / Lab</a></li> --}}
              {{-- <li><a href="{{ route('sop') }}">SOP & Prosedur</a></li>
              <li><a href="{{ route('magang') }}">Program Magang</a></li>
              <li><a href="{{ route('capacity-building') }}">Capacity Building & Workshop</a></li>
              <li><a href="{{ route('booking') }}">Booking Fasilitas</a></li> --}}
          {{-- </ul>  --}}
        </li>

        

        <!-- Kontak -->
        <li class="relative" id="kontakMenu" @mouseenter="openOnHover('kontak')" @mouseleave="close('kontak')">
          <button class="btn btn-ghost px-3 hover:border-b border-black rounded-none w-fit " @click="toggle('kontak')" :aria-expanded="isOpen('kontak')" aria-haspopup="menu">
            <a href="{{ route('welcome') . '#kontak' }}">

              <span>Kontak</span>
            </a>
            {{-- <svg class="ml-1 h-3 w-3 transition-transform duration-200" :class="isOpen('kontak') ? 'rotate-180' : ''" viewBox="0 0 10 6" fill="currentColor"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 10 6" fill="none" stroke="currentColor">
            <path d="M1 1l4 4 4-4" />
          </svg>
          </svg> --}}
          </button>
          {{-- <ul x-cloak x-show="isOpen('kontak')" x-transition.origin.top.left
              @click.outside="close('kontak')"
              class="menu dropdown-content absolute left-0 mt-10 w-72 bg-base-100 p-2 border border-zinc-500  z-50">
            {{-- <li><a href="{{ route('ajukan-kolaborasi') }}">Ajukan Kolaborasi</a></li>
            <li><a href="{{ route('permintaan-layanan') }}">Permintaan Layanan</a></li>
            <li><a href="{{ route('kunjungan-reviewer') }}">Kunjungan Reviewer</a></li>
            <li><a href="{{ route('alamat-kontak') }}">Lokasi & Kontak</a></li> --}}
            {{-- <li><a href="">Ajukan Kolaborasi</a></li>
            <li><a href="">Permintaan Layanan</a></li>
            <li><a href="">Kunjungan Reviewer</a></li>
            <li><a href="">Lokasi & Kontak</a></li>
          </ul> --}} 
        </li>
        
      </ul>
    </div>



    <!-- END -->
    <div class="navbar-end gap-2">
      <!-- Toggle Bahasa -->
      <div class="dropdown dropdown-end hidden md:block">
        <label tabindex="0" class="btn btn-ghost px-3 hover:border-b border-black rounded-none w-fit ">ID/EN</label>
        <ul tabindex="0" class="menu dropdown-content mt-2 w-28 rounded-xl bg-base-100 p-2 shadow-lg ring-1 ring-black/5 z-50">
          <li><a href="{{ url('/id') }}">Bahasa</a></li>
          <li><a href="{{ url('/en') }}">English</a></li>
        </ul>
      </div>

      <!-- CTA Data Borang -->
      {{-- <a href="{{ route('data-room') }}" class="btn btn-primary btn-sm md:btn-md rounded-full">Data Borang</a> --}}
      <div class="relative list-none">
          <button class="btn btn-ghost  hover:bg-zinc-100 px-3 border rounded-full border-black  w-fit" aria-haspopup="menu">
              <span class="text-zinc-900 font-semibold">Jurnal Pusat Studi</span>
              {{-- <svg class="ml-1 h-3 w-3 transition-transform duration-200" :class="isOpen('akademik') ? 'rotate-180' : ''" viewBox="0 0 10 6" fill="currentColor"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 10 6" fill="none" stroke="currentColor">
                <path d="M1 1l4 4 4-4" />
              </svg>
            </svg> --}}
          </button>
        </div>
      {{-- <a href="" class="btn bg-white border-2 border-black hover:bg-black hover:text-white btn-sm md:btn-md rounded-full">Data Borang</a> --}}
    </div>
  </nav>
 {{-- ========================== --}}
  <!--      MOBILE PANEL         -->
  {{-- ======================== --}}
  <div id="mobileMenu" 
       class="lg:hidden origin-top"
       x-cloak x-show="mobileOpen" 
       x-transition.scale.opacity 
       @click.outside="mobileOpen=false">
    <ul class="menu  p-3 border-t text-base">
      <li><a href="{{ url('/') }}" :class="isActive('/') ? 'active' : ''">Beranda</a></li>

      <li x-data="{open:false}">
        <button class="justify-between" @click="open=!open"><span>Profil</span>
          <svg class="ml-2 h-3 w-3 transition-transform" :class="open?'rotate-180':''" viewBox="0 0 10 6" fill="currentColor"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 10 6" fill="none" stroke="currentColor">
  <path d="M1 1l4 4 4-4" />
</svg>
</svg>
        </button>
        <ul x-cloak x-show="open" x-transition.opacity class="pl-4">
          <li><a href=" ">Tentang Kami</a></li>
          <li><a href=" ">Struktur & SK</a></li>
          {{-- <li><a href=" ">Roadmap & Asta Cita</a></li> --}}
          <li><a href=" ">Kebijakan & Tata Kelola</a></li>
          <li><a href=" ">Mitra Strategis</a></li>
          {{-- <li><a href="{{ route('about') }}">Tentang Kami</a></li>
          <li><a href="{{ route('struktur') }}">Struktur & SK</a></li>
          {{-- {{-- <li><a href="{{ route('roadmap-asta') }}">Roadmap & Asta Cita</a></li> --}}
          <li><a href="{{ route('kebijakan') }}">Kebijakan & Tata Kelola</a></li>
          <li><a href="{{ route('mitra') }}">Mitra Strategis</a></li>
        </ul>
      </li>

      <li x-data="{open:false}">
        <button class="justify-between" @click="open=!open"><span>Akademik</span>
          <svg class="ml-2 h-3 w-3 transition-transform" :class="open?'rotate-180':''" viewBox="0 0 10 6" fill="currentColor"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 10 6" fill="none" stroke="currentColor">
  <path d="M1 1l4 4 4-4" />
</svg>
</svg>
        </button>
        <ul x-cloak x-show="open" x-transition.opacity class="pl-4">
          {{-- <li><a href="">Publikasi</a></li>
          <li><a href="">Jurnal Pusat Studi</a></li>
          <li><a href="">Kegiatan Ilmiah</a></li>
          <li><a href="">Kunjungan Internasional</a></li> --}}
          <li><a href="">Profil Peneliti</a></li>
          <li><a href="">Lulusan S3</a></li>
          {{-- <li><a href="{{ route('publikasi') }}">Publikasi</a></li>
          <li><a href="{{ route('jurnal') }}">Jurnal Pusat Studi</a></li>
          {{-- <li><a href="{{ route('kegiatan-ilmiah') }}">Kegiatan Ilmiah</a></li> --}}
          {{-- <li><a href="{{ route('kunjungan-internasional') }}">Kunjungan Internasional</a></li> --}}
          <li><a href="{{ route('profil-peneliti') }}">Profil Peneliti</a></li>
          <li><a href="{{ route('lulusan-s3') }}">Lulusan S3</a></li> --}}
        </ul>
      </li>

      {{-- <li x-data="{open:false}">
        <button class="justify-between" @click="open=!open"><span>Komersialisasi</span>
          <svg class="ml-2 h-3 w-3 transition-transform" :class="open?'rotate-180':''" viewBox="0 0 10 6" fill="currentColor"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 10 6" fill="none" stroke="currentColor">
  <path d="M1 1l4 4 4-4" />
</svg>
</svg>
        </button>
        <ul x-cloak x-show="open" x-transition.opacity class="pl-4">
          <li><a href="">Produk & Inovasi</a></li>
          <li><a href="">Paten & HKI</a></li>
          <li><a href="">Kerja Sama Riset</a></li>
          <li><a href="">Kontrak Non-Riset</a></li>
          <li><a href="">UMKM/Startup Binaan</a></li>
          <li><a href="">Unit Bisnis & Layanan Jasa</a></li>
          {{-- <li><a href="{{ route('produk-inovasi') }}">Produk & Inovasi</a></li>
          <li><a href="{{ route('paten-hki') }}">Paten & HKI</a></li>
          <li><a href="{{ route('kerjasama-riset') }}">Kerja Sama Riset</a></li>
          <li><a href="{{ route('kontrak-nonriset') }}">Kontrak Non-Riset</a></li>
          <li><a href="{{ route('umkm-startup') }}">UMKM/Startup Binaan</a></li>
          <li><a href="{{ route('unit-bisnis') }}">Unit Bisnis & Layanan Jasa</a></li> --}}
        {{-- </ul>
      </li>  --}}

      <li x-data="{open:false}">
        <button class="justify-between" @click="open=!open"><span>Fasilitas</span>
          <svg class="ml-2 h-3 w-3 transition-transform" :class="open?'rotate-180':''" viewBox="0 0 10 6" fill="currentColor"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 10 6" fill="none" stroke="currentColor">
  <path d="M1 1l4 4 4-4" />
</svg>
</svg>
        </button>
        <ul x-cloak x-show="open" x-transition.opacity class="pl-4">
          <li><a href="">Fasilitas Riset / Lab</a></li>
          <li><a href="">SOP & Prosedur</a></li>
          <li><a href="">Program Magang</a></li>
          <li><a href="">Capacity Building & Workshop</a></li>
          <li><a href="">Booking Fasilitas</a></li>
          {{-- <li><a href="{{ route('fasilitas') }}">Fasilitas Riset / Lab</a></li>
          <li><a href="{{ route('sop') }}">SOP & Prosedur</a></li>
          <li><a href="{{ route('magang') }}">Program Magang</a></li>
          <li><a href="{{ route('capacity-building') }}">Capacity Building & Workshop</a></li>
          <li><a href="{{ route('booking') }}">Booking Fasilitas</a></li> --}}
        </ul>
      </li>

      <li x-data="{open:false}">
        <button class="justify-between" @click="open=!open"><span>Publikasi</span>
          <svg class="ml-2 h-3 w-3 transition-transform" :class="open?'rotate-180':''" viewBox="0 0 10 6" fill="currentColor"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 10 6" fill="none" stroke="currentColor">
  <path d="M1 1l4 4 4-4" />
</svg>
</svg>
        </button>
        <ul x-cloak x-show="open" x-transition.opacity class="pl-4">
          {{-- <li><a href="">Data Room</a></li>
          <li><a href="">Dashboard KPI</a></li>
          <li><a href="">Dokumen Resmi</a></li> --}}
          {{-- <li><a href="">Media (Foto/Video)</a></li>
          <li><a href="">Berita & Agenda</a></li> --}}
          {{-- <li><a href="{{ route('data-room') }}">Data Room</a></li>
          <li><a href="{{ route('dashboard-kpi') }}">Dashboard KPI</a></li>
          <li><a href="{{ route('dokumen-resmi') }}">Dokumen Resmi</a></li> --}}
          <li><a href="{{ route('media') }}">Media (Foto/Video)</a></li>
          <li><a href="{{ route('guest.berita.index') }}">Berita & Agenda</a></li> --}}
        </ul>
      </li>

      <li x-data="{open:false}">
        <button class="justify-between" @click="open=!open"><span>Kontak</span>
          <svg class="ml-2 h-3 w-3 transition-transform"    :class="open?'rotate-180':''" viewBox="0 0 10 6" fill="currentColor"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 10 6" fill="none" stroke="currentColor">
  <path d="M1 1l4 4 4-4" />
</svg>
</svg>
        </button>
        <ul x-cloak x-show="open" x-transition.opacity class="pl-4">
          <li><a href="">Kolaborasi</a></li>
          <li><a href="">Permintaan Layanan</a></li>
          <li><a href="">Kunjungan Reviewer</a></li>
          <li><a href="">Lokasi & Kontak</a></li>
          {{-- <li><a href="{{ route('ajukan-kolaborasi') }}">Kolaborasi</a></li>
          <li><a href="{{ route('permintaan-layanan') }}">Permintaan Layanan</a></li>
          <li><a href="{{ route('kunjungan-reviewer') }}">Kunjungan Reviewer</a></li>
          <li><a href="{{ route('alamat-kontak') }}">Lokasi & Kontak</a></li> --}}
        </ul>
      </li>

      <!-- Bahasa + CTA -->
      <li class="mt-2 border-t pt-2">
        <div class="flex items-center gap-2">
          <a href="{{ url('/id') }}" class="btn btn-ghost btn-sm">ID</a>
          <a href="{{ url('/en') }}" class="btn btn-ghost btn-sm">EN</a>
          {{-- <a href="{{ route('data-room') }}" class="btn btn-primary btn-sm grow">Data Borang</a> --}}
          <a href="" class="btn btn-primary btn-sm grow">Data Borang</a>
        </div>
      </li>
    </ul>
  </div>
</header>

<!-- Alpine logic -->
<script>
function navux() {
  return {
    scrolled: false,
    mobileOpen: false,
    openMap: {},
    init() {
      const onScroll = () => { this.scrolled = window.scrollY > 4 }
      onScroll(); window.addEventListener('scroll', onScroll)
      window.addEventListener('resize', () => {
        if (window.innerWidth >= 1024) this.mobileOpen = false
      })
    },
    isActive(path) {
      try { return window.location.pathname === path } catch { return false }
    },
    isOpen(key) { return !!this.openMap[key] },
    open(key) { this.openMap[key] = true },
    close(key) { this.openMap[key] = false },
    toggle(key) { this.openMap[key] = !this.openMap[key] },
    closeAll() { this.openMap = {}; this.mobileOpen = false },
    openOnHover(key) { if (window.innerWidth >= 1024) this.open(key) },
  }
}
</script>