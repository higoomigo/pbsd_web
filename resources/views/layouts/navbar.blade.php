<!-- NAVBAR SANTUY SLEEK -->
<header 
  x-data="navux()" 
  x-init="init()" 
  @keydown.escape="closeAll()" 
  class="sticky top-0 z-50 bg-base-100 transition-shadow"
  :class="{'shadow-sm': scrolled}"
>
  <nav class="navbar font-sm mx-auto px-4 md:px-8 lg:px-16 py-6">

    <!-- START -->
    <div class="navbar-start gap-2">
      <!-- Mobile burger -->
      <button class="btn btn-ghost lg:hidden" @click="mobileOpen = !mobileOpen" :aria-expanded="mobileOpen" aria-controls="mobileMenu" aria-label="Buka menu">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
        </svg>
      </button>

      <!-- Logo -->
      <a href="/" class="inline-flex items-center">
        <img class="h-10 md:h-12" src="{{ asset('images/logoPusatStudi.png') }}" alt="Pusat Studi">
      </a>
    </div>

    <!-- CENTER — Desktop menu -->
    <div class="navbar-center hidden lg:flex">
      <ul class="menu menu-horizontal gap-1 text-lg font-sans">
        <li>
          <a href="/" class="rounded-lg" :class="isActive('/') ? 'active bg-base-200' : ''">Beranda</a>
        </li>

        <!-- Dropdown: Lembaga -->
        <li class="relative" @mouseenter="openOnHover('lembaga')" @mouseleave="close('lembaga')">
          <button class="btn btn-ghost px-3"
                  @click="toggle('lembaga')"
                  :aria-expanded="isOpen('lembaga')"
                  aria-haspopup="menu">
            <span>Lembaga</span>
            <!-- caret segitiga -->
            <svg class="ml-1 h-3 w-3 transition-transform duration-200" :class="isOpen('lembaga') ? 'rotate-180' : ''" viewBox="0 0 10 6" fill="currentColor" aria-hidden="true">
              <path d="M0 0l5 6 5-6H0z"/>
            </svg>
          </button>

          <!-- panel -->
          <ul x-cloak x-show="isOpen('lembaga')" x-transition.origin.top.left
              @click.outside="close('lembaga')"
              class=" menu dropdown-content absolute left-0 mt-10 w-56 rounded-xl bg-base-100 p-2 shadow-lg ring-1 ring-black/5 z-50">
            <li><a href="{{ route('visi-misi') }}">Visi Misi</a></li>
            <li><a href="">Struktur Organisasi</a></li>
            <li><a href="">Tim & Peneliti</a></li>
          </ul>
        </li>

        <!-- Dropdown: Program -->
        <li class="relative" @mouseenter="openOnHover('program')" @mouseleave="close('program')">
          <button class="btn btn-ghost px-3" @click="toggle('program')" :aria-expanded="isOpen('program')" aria-haspopup="menu">
            <span>Program</span>
            <svg class="ml-1 h-3 w-3 transition-transform duration-200" :class="isOpen('program') ? 'rotate-180' : ''" viewBox="0 0 10 6" fill="currentColor"><path d="M0 0l5 6 5-6H0z"/></svg>
          </button>
          <ul x-cloak x-show="isOpen('program')" x-transition.origin.top.left
              @click.outside="close('program')"
              class="menu dropdown-content absolute left-0 mt-10 w-56 rounded-xl bg-base-100 p-2 shadow-lg ring-1 ring-black/5 z-50">
            <li><a href="">Penelitian</a></li>
            <li><a href="">Pengabdian</a></li>
          </ul>
        </li>

        <!-- Dropdown: Arsip -->
        <li class="relative" @mouseenter="openOnHover('arsip')" @mouseleave="close('arsip')">
          <button class="btn btn-ghost px-3" @click="toggle('arsip')" :aria-expanded="isOpen('arsip')" aria-haspopup="menu">
            <span>Arsip</span>
            <svg class="ml-1 h-3 w-3 transition-transform duration-200" :class="isOpen('arsip') ? 'rotate-180' : ''" viewBox="0 0 10 6" fill="currentColor"><path d="M0 0l5 6 5-6H0z"/></svg>
          </button>
          <ul x-cloak x-show="isOpen('arsip')" x-transition.origin.top.left
              @click.outside="close('arsip')"
              class="menu dropdown-content absolute left-0 mt-10 w-56 rounded-xl bg-base-100 p-2 shadow-lg ring-1 ring-black/5 z-50">
            <li><a href="">Dokumen</a></li>
            <li><a href="">Foto</a></li>
            <li><a href="">Video</a></li>
          </ul>
        </li>

        <li><a href="" class="rounded-lg">Kontak</a></li>
      </ul>
    </div>

    <!-- END -->
    <div class="navbar-end gap-2">
      <div class="hidden md:block">
        <input type="text" placeholder="Cari…" class="input input-bordered w-44 md:w-56" />
      </div>
    </div>
  </nav>

  <!-- MOBILE PANEL -->
  <div id="mobileMenu" 
       class="lg:hidden origin-top"
       x-cloak x-show="mobileOpen" 
       x-transition.scale.opacity 
       @click.outside="mobileOpen=false">
    <ul class="menu bg-base-100 p-3 border-t">
      <li><a href="/" class="active">Beranda</a></li>

      <li x-data="{open:false}">
        <button class="justify-between" @click="open=!open">
          <span>Lembaga</span>
          <svg class="ml-2 h-3 w-3 transition-transform" :class="open?'rotate-180':''" viewBox="0 0 10 6" fill="currentColor"><path d="M0 0l5 6 5-6H0z"/></svg>
        </button>
        <ul x-cloak x-show="open" x-transition.opacity class="pl-4">
          <li><a href="">Visi Misi</a></li>
          <li><a href="">Struktur Organisasi</a></li>
          <li><a href="">Tim & Peneliti</a></li>
        </ul>
      </li>

      <li x-data="{open:false}">
        <button class="justify-between" @click="open=!open">
          <span>Program</span>
          <svg class="ml-2 h-3 w-3 transition-transform" :class="open?'rotate-180':''" viewBox="0 0 10 6" fill="currentColor"><path d="M0 0l5 6 5-6H0z"/></svg>
        </button>
        <ul x-cloak x-show="open" x-transition.opacity class="pl-4">
          <li><a href="">Penelitian</a></li>
          <li><a href="">Pengabdian</a></li>
        </ul>
      </li>

      <li x-data="{open:false}">
        <button class="justify-between" @click="open=!open">
          <span>Arsip</span>
          <svg class="ml-2 h-3 w-3 transition-transform" :class="open?'rotate-180':''" viewBox="0 0 10 6" fill="currentColor"><path d="M0 0l5 6 5-6H0z"/></svg>
        </button>
        <ul x-cloak x-show="open" x-transition.opacity class="pl-4">
          <li><a href="">Dokumen</a></li>
          <li><a href="">Foto</a></li>
          <li><a href="">Video</a></li>
        </ul>
      </li>

      <li><a href="">Kontak</a></li>
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
      // shadow saat scroll
      const onScroll = () => { this.scrolled = window.scrollY > 4 }
      onScroll(); window.addEventListener('scroll', onScroll)

      // close mobile saat resize ke desktop
      window.addEventListener('resize', () => {
        if (window.innerWidth >= 1024) this.mobileOpen = false
      })
    },

    // active helper (opsional: sesuaikan)
    isActive(path) {
      try { return window.location.pathname === path } catch { return false }
    },

    // dropdown helpers
    isOpen(key) { return !!this.openMap[key] },
    open(key) { this.openMap[key] = true },
    close(key) { this.openMap[key] = false },
    toggle(key) { this.openMap[key] = !this.openMap[key] },
    closeAll() { this.openMap = {}; this.mobileOpen = false },

    // hover open only on desktop
    openOnHover(key) { if (window.innerWidth >= 1024) this.open(key) },
  }
}
</script>
