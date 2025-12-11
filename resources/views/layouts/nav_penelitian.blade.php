<div class="mt-5">
    <div class="max-w-7xl">
        <div class="hidden space-x-6 sm:-my-px sm:flex">
            <x-nav-link :href="route('admin.penelitian.index')" :active="request()->routeIs('admin.penelitian.publikasi-terindeks.*')">
                {{ __('Publikasi Terindeks') }}
            </x-nav-link>
            {{-- <x-nav-link :href="route('admin.penelitian.kegiatan-penelitian.index')" :active="request()->routeIs('admin.penelitian.kegiatan-penelitian.*')">
                {{ __('Kegiatan Penelitian') }}
            </x-nav-link>
            <x-nav-link :href="route('admin.penelitian.kerjasama-riset.index')" :active="request()->routeIs('admin.penelitian.kerjasama-riset.*')">
                {{ __('Kerjasama Riset') }}
            </x-nav-link> --}}
            <x-nav-link :href="route('admin.penelitian.seminar.index')" :active="request()->routeIs('admin.penelitian.seminar.*')">
                {{ __('Seminar') }}
            </x-nav-link>
        </div>
    </div>
</div>