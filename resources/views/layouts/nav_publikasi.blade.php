<div class="mt-5">
    <div class="max-w-7xl">
        <div class="hidden space-x-6 sm:-my-px sm:flex">

            {{-- <x-nav-link :href="route('admin.publikasi-data.index')" :active="request()->routeIs('admin.publikasi-data.berita.*')">
                {{ __('Penelitian') }}
            </x-nav-link> --}}
            <x-nav-link :href="route('admin.publikasi-data.index')" :active="request()->routeIs('admin.publikasi-data.berita.*')">
                {{ __('Kegiatan') }}
            </x-nav-link>
            <x-nav-link :href="route('admin.publikasi-data.artikel.index')" :active="request()->routeIs('admin.publikasi-data.artikel.*')">
                {{ __('Artikel') }}
            </x-nav-link>
            <x-nav-link :href="route('admin.publikasi-data.koleksi-dokumen.index')" :active="request()->routeIs('admin.publikasi-data.koleksi-dokumen.*','admin.publikasi-data.dokumen.*')">
                {{-- {{ __('Koleksi Dokumen') }} --}}
                {{ __('Repositori Dokumen') }}
            </x-nav-link>
            <x-nav-link :href="route('admin.publikasi-data.galeri.albums.index')" :active="request()->routeIs('admin.publikasi-data.galeri.*')">
                {{ __('Galeri') }}
            </x-nav-link>
            <x-nav-link :href="route('admin.publikasi-data.komentar.index')" :active="request()->routeIs('admin.publikasi-data.komentar.*')">
                {{ __('Komentar') }}
            </x-nav-link>

            {{-- <x-nav-link :href="route('admin.publikasi-data.foto.index')" :active="request()->routeIs('admin.publikasi-data.foto.*')">
                {{ __('Foto') }}
            </x-nav-link>
            <x-nav-link :href="route('admin.publikasi-data.video.index')" :active="request()->routeIs('admin.publikasi-data.video.*')">
                {{ __('Video') }}
            </x-nav-link> --}}
            {{-- <x-nav-link :href="route('admin.profil')" :active="request()->routeIs('admin.profil')">
                {{ __('Profil') }}
            </x-nav-link> --}}

        </div>
    </div>
</div>