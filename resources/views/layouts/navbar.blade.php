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
          <a href="{{ url('/') }}" class="hover:border-b-zinc-200 rounded-none" :class="isActive('/') ? 'active bg-white' : ''">Beranda</a>
        </li>

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
            <li><a href="{{ route('visi-misi') }}">Visi Misi</a></li> 
            <li><a href="{{ route('struktur-organisasi') }}">Struktur</a></li>
            <li><a href="{{ route('guest.kebijakan.index') }}">Kebijakan & Tata Kelola</a></li>
            <li><a href="{{ route('guest.mitra.index') }}">Mitra</a></li>
            <li><a href="{{ route('guest.peneliti.index') }}">Profil Peneliti</a></li>
          </ul>
        </li> 

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
              {{-- <li><a href="">Penelitian</a></li> --}}
              <li><a href="{{ route('guest.artikel.index') }}">Artikel</a></li>
              <li><a href="{{ route('guest.dokumen.koleksi.index') }}">Repositori Dokumen</a></li>
            <li><a href="{{ route('galeri.albums.index') }}">Media (Foto/Video)</a></li>
            <li><a href="{{ route('guest.berita.index') }}">Kegiatan Terbaru</a></li>
          </ul>
        </li>

        <!-- Penelitian -->
        <li class="relative" @mouseenter="openOnHover('penelitian')" @mouseleave="close('penelitian')">
            <button class="btn btn-ghost px-3 hover:border-b border-black rounded-none w-fit" 
                    @click="toggle('penelitian')" 
                    :aria-expanded="isOpen('penelitian')" 
                    aria-haspopup="menu">
                <span>Penelitian</span>
                <svg class="ml-1 h-3 w-3 transition-transform duration-200" 
                    :class="isOpen('penelitian') ? 'rotate-180' : ''" 
                    xmlns="http://www.w3.org/2000/svg" 
                    viewBox="0 0 10 6" 
                    fill="none" 
                    stroke="currentColor">
                    <path d="M1 1l4 4 4-4" />
                </svg>
            </button>
            <ul x-cloak x-show="isOpen('penelitian')" 
                x-transition.origin.top.left
                @click.outside="close('penelitian')"
                class="menu dropdown-content absolute left-0 mt-10 w-72 bg-base-100 p-2 border border-zinc-500 z-50">
                
                <li>
                    <a href="{{ route('guest.publikasi-terindeks.index') }}">
                        {{-- <i class="fas fa-book-open mr-2 text-sm"></i> --}}
                        Publikasi Terindeks
                    </a>
                </li>
                <li>
                    <a href="{{ route('guest.kegiatan-penelitian.index') }}">
                        {{-- <i class="fas fa-flask mr-2 text-sm"></i> --}}
                        Kegiatan Penelitian
                    </a>
                </li>
                <li>
                    <a href="{{ route('guest.kerjasama-riset.index') }}">
                        {{-- <i class="fas fa-handshake mr-2 text-sm"></i> --}}
                        Kerjasama Riset
                    </a>
                </li>
                <li>
                    <a href="{{ route('guest.seminar.index') }}">
                        {{-- <i class="fas fa-handshake mr-2 text-sm"></i> --}}
                        Seminar
                    </a>
                </li>
            </ul>
        </li>

        <li class="relative" @mouseenter="openOnHover('fasilitas')" @mouseleave="close('fasilitas')">
          <button class="btn btn-ghost px-3 hover:border-b hover:border-black rounded-none w-fit   " @click="toggle('fasilitas')" :aria-expanded="isOpen('fasilitas')" aria-haspopup="menu">
            <a href="{{ route('guest.fasilitas.index') }}">
              <span>Fasilitas</span>
            </a>
          </button>
        </li>

        <!-- Kontak -->
        <li class="relative" id="kontakMenu" @mouseenter="openOnHover('kontak')" @mouseleave="close('kontak')">
          <button class="btn btn-ghost px-3 hover:border-b border-black rounded-none w-fit " @click="toggle('kontak')" :aria-expanded="isOpen('kontak')" aria-haspopup="menu">
            <a href="{{ route('welcome') . '#kontak' }}">
              <span>Kontak</span>
            </a>
          </button>
        </li>
        
      </ul>
    </div>

    <!-- END -->
    <div class="navbar-end gap-2">
      <!-- Mobile burger -->
      <button class="btn btn-ghost lg:hidden" @click="mobileOpen = !mobileOpen" :aria-expanded="mobileOpen" aria-controls="mobileMenu" aria-label="Buka menu">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
        </svg>
      </button>

      <!-- Toggle Bahasa -->
      <div class="dropdown dropdown-end hidden md:block">
        <label tabindex="0" class="btn btn-ghost px-3 hover:border-b border-black rounded-none w-fit ">ID/EN</label>
        <ul tabindex="0" class="menu dropdown-content mt-2 w-28 rounded-xl bg-base-100 p-2 shadow-lg ring-1 ring-black/5 z-50">
          <li><a href="{{ url('/id') }}">Bahasa</a></li>
          <li><a href="{{ url('/en') }}">English</a></li>
        </ul>
      </div>

      <!-- CTA Data Borang -->
      <div class="relative list-none hidden lg:block">
          <button class="btn btn-ghost  hover:bg-zinc-100 px-3 border rounded-full border-black  w-fit" aria-haspopup="menu">
              <span class="text-zinc-900 font-semibold">Jurnal Pusat Studi</span>
          </button>
        </div>
    </div>
  </nav>

  <!-- MOBILE SIDEBAR - Fixed overlay -->
  <!-- Overlay -->
  <div x-cloak x-show="mobileOpen" 
       x-transition.opacity.duration.300ms
       class="fixed inset-0 bg-black/30 lg:hidden z-40"
       @click="mobileOpen = false">
  </div>

  <!-- Sidebar -->
  <div x-cloak x-show="mobileOpen"
       x-transition:enter="transition ease-out duration-300"
       x-transition:enter-start="translate-x-full opacity-0"
       x-transition:enter-end="translate-x-0 opacity-100"
       x-transition:leave="transition ease-in duration-200"
       x-transition:leave-start="translate-x-0 opacity-100"
       x-transition:leave-end="translate-x-full opacity-0"
       class="fixed inset-y-0 right-0 w-full max-w-sm bg-base-100 shadow-2xl z-50 lg:hidden overflow-y-auto"
       @keydown.escape="mobileOpen = false">
    
    <!-- Sidebar Header -->
    <div class="sticky top-0 z-10 bg-base-100 border-b border-base-200">
      <div class="flex items-center justify-between p-4">
        <h2 class="text-lg font-semibold">Menu</h2>
        <button @click="mobileOpen = false" class="btn btn-ghost btn-circle">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>
      </div>
    </div>

    <!-- Sidebar Content -->
    <div class="p-4">
      <ul class="space-y-1">
        <li>
          <a href="{{ url('/') }}" 
             @click="mobileOpen = false"
             class="flex items-center py-3 px-4 rounded-lg hover:bg-base-200 transition-colors"
             :class="isActive('/') ? 'bg-base-200 font-medium' : ''">
            Beranda
          </a>
        </li>

        <!-- Mobile - Tentang Kami -->
        <li x-data="{open: false}" class="border-b border-base-200/50 pb-1">
          <button @click="open = !open" 
                  class="flex items-center justify-between w-full py-3 px-4 rounded-lg hover:bg-base-200 transition-colors">
            <span>Tentang Kami</span>
            <svg class="h-5 w-5 transition-transform duration-200" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
          </button>
          <ul x-cloak x-show="open" 
              x-collapse
              class="ml-4 mt-1 space-y-1 border-l border-base-200 pl-3">
            <li>
              <a href="{{ route('visi-misi') }}" 
                 @click="mobileOpen = false"
                 class="block py-2 px-3 rounded-lg hover:bg-base-200 transition-colors">
                Visi Misi
              </a>
            </li>
            <li>
              <a href="{{ route('struktur-organisasi') }}" 
                 @click="mobileOpen = false"
                 class="block py-2 px-3 rounded-lg hover:bg-base-200 transition-colors">
                Struktur
              </a>
            </li>
            <li>
              <a href="{{ route('guest.kebijakan.index') }}" 
                 @click="mobileOpen = false"
                 class="block py-2 px-3 rounded-lg hover:bg-base-200 transition-colors">
                Kebijakan & Tata Kelola
              </a>
            </li>
            <li>
              <a href="{{ route('guest.mitra.index') }}" 
                 @click="mobileOpen = false"
                 class="block py-2 px-3 rounded-lg hover:bg-base-200 transition-colors">
                Mitra
              </a>
            </li>
            <li>
              <a href="{{ route('guest.peneliti.index') }}" 
                 @click="mobileOpen = false"
                 class="block py-2 px-3 rounded-lg hover:bg-base-200 transition-colors">
                Profil Peneliti
              </a>
            </li>
          </ul>
        </li>

        <!-- Mobile - Publikasi -->
        <li x-data="{open: false}" class="border-b border-base-200/50 pb-1">
          <button @click="open = !open" 
                  class="flex items-center justify-between w-full py-3 px-4 rounded-lg hover:bg-base-200 transition-colors">
            <span>Publikasi</span>
            <svg class="h-5 w-5 transition-transform duration-200" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
          </button>
          <ul x-cloak x-show="open" 
              x-collapse
              class="ml-4 mt-1 space-y-1 border-l border-base-200 pl-3">
              <li>
                <a href="{{ route('guest.artikel.index') }}" 
                @click="mobileOpen = false"
                class="block py-2 px-3 rounded-lg hover:bg-base-200 transition-colors">
                Artikel
              </a>
            </li>
            {{-- <li>
              <a href="{{ route('guest.dokumen.index') }}" 
                 @click="mobileOpen = false"
                 class="block py-2 px-3 rounded-lg hover:bg-base-200 transition-colors">
                Repositori Dokumen
              </a>
            </li> --}}
            <li>
              <a href="{{ route('galeri.albums.beranda') }}" 
                 @click="mobileOpen = false"
                 class="block py-2 px-3 rounded-lg hover:bg-base-200 transition-colors">
                Media (Foto/Video)
              </a>
            </li>
            <li>
              <a href="{{ route('guest.berita.index') }}" 
                 @click="mobileOpen = false"
                 class="block py-2 px-3 rounded-lg hover:bg-base-200 transition-colors">
                Kegiatan Terbaru
              </a>
            </li>
          </ul>
        </li>

        <!-- Mobile - Fasilitas -->
        <li class="border-b border-base-200/50 pb-1">
          <a href="{{ route('guest.fasilitas.index') }}" 
             @click="mobileOpen = false"
             class="flex items-center py-3 px-4 rounded-lg hover:bg-base-200 transition-colors">
            Fasilitas
          </a>
        </li>

        <!-- Mobile - Kontak -->
        <li>
          <a href="{{ route('welcome') . '#kontak' }}" 
             @click="mobileOpen = false"
             class="flex items-center py-3 px-4 rounded-lg hover:bg-base-200 transition-colors">
            Kontak
          </a>
        </li>
      </ul>

      <!-- Mobile - Bahasa & Jurnal -->
      {{-- <div class="mt-8 pt-6 border-t border-base-200">
        <div class="space-y-4">
          <div>
            <p class="text-sm font-medium text-base-content/70 mb-2">Bahasa</p>
            <div class="flex gap-2">
              <a href="{{ url('/id') }}" 
                 @click="mobileOpen = false"
                 class="btn btn-outline flex-1 border-base-300 hover:border-black">
                Bahasa Indonesia
              </a>
              <a href="{{ url('/en') }}" 
                 @click="mobileOpen = false"
                 class="btn btn-outline flex-1 border-base-300 hover:border-black">
                English
              </a>
            </div>
          </div>
          
          <a href="#" 
             @click="mobileOpen = false"
             class="btn btn-outline w-full justify-center border-black hover:bg-black hover:text-white hover:border-black">
            Jurnal Pusat Studi
          </a>
        </div>
      </div> --}}
    </div>
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
      
      // Prevent body scroll when mobile menu is open
      this.$watch('mobileOpen', (value) => {
        if (value) {
          document.body.style.overflow = 'hidden'
        } else {
          document.body.style.overflow = ''
        }
      })
    },
    isActive(path) {
      try { return window.location.pathname === path } catch { return false }
    },
    isOpen(key) { return !!this.openMap[key] },
    open(key) { this.openMap[key] = true },
    close(key) { this.openMap[key] = false },
    toggle(key) { this.openMap[key] = !this.openMap[key] },
    closeAll() { 
      this.openMap = {}; 
      this.mobileOpen = false;
      document.body.style.overflow = '';
    },
    openOnHover(key) { if (window.innerWidth >= 1024) this.open(key) },
  }
}
</script>

<style>
/* Ensure mobile menu doesn't affect main content */
.fixed {
  position: fixed;
}
.inset-0 {
  top: 0;
  right: 0;
  bottom: 0;
  left: 0;
}
.overflow-y-auto {
  overflow-y: auto;
}
.z-40 {
  z-index: 40;
}
.z-50 {
  z-index: 50;
}
.max-w-sm {
  max-width: 24rem; /* 384px */
}
</style>