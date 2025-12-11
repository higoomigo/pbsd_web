<div class="mt-5">
    <div class="max-w-7xl">
        <div class="hidden space-x-6 sm:-my-px sm:flex">
            <x-nav-link :href="route('admin.profil.index')" :active="request()->routeIs('admin.profil.visimisi.*')">
                {{ __('Visi Misi') }}
            </x-nav-link>
            <x-nav-link :href="route('admin.profil.struktur.create')" :active="request()->routeIs('admin.profil.struktur.*')">
                {{ __('Struktur') }}
            </x-nav-link>
            <x-nav-link :href="route('admin.profil.kebijakan.index')" :active="request()->routeIs('admin.profil.kebijakan.*')">
                {{ __('Kebijakan dan Tata Kelola') }}
            </x-nav-link>
            <x-nav-link :href="route('admin.profil.mitra.index')" :active="request()->routeIs('admin.profil.mitra.*')">
                {{ __('Mitra') }}
            </x-nav-link>
            <x-nav-link :href="route('admin.profil.peneliti.index')" :active="request()->routeIs('admin.profil.peneliti.*')">
                {{ __('Profil Peneliti') }}
            </x-nav-link>
            {{-- <x-nav-link :href="route('admin.profil')" :active="request()->routeIs('admin.profil')">
                {{ __('Profil') }}
            </x-nav-link> --}}
            
        </div>
    </div>
</div>