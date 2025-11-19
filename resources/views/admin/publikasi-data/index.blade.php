<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Menu Berita') }}
        </h2>
        {{-- <div class="mt-5">
            <div class="max-w-7xl">
                <div class="hidden space-x-5 sm:-my-px sm:flex">
                    <x-nav-publikasi :href="route('berita.index')" :active="request()->routeIs('admin.publikasi-data.index')">
                        {{ __('Berita') }}
                    </x-nav-publikasi>
                    <x-nav-publikasi :href="route('berita.index')" :active="request()->routeIs('admin.publikasi-data.dokumen')">
                        {{ __('Dokumen') }}
                    </x-nav-publikasi>
                    {{-- <x-nav-link :href="route('admin.profil')" :active="request()->routeIs('admin.profil')">
                        {{ __('Profil') }}
                    </x-nav-link> --}}
                    
                {{-- </div>
            </div>
        </div> --}}
    </x-slot>

    
    {{-- 
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-md transition-shadow mb-4">
                <div class="overflow-hidden group shadow-sm sm:rounded-lg hover:shadow-md transition-shadow">
                    <a href="{{ route('berita.index') }}" class="btn bg-white flex justify-between p-8">
                        <p class=" text-lg text-zinc-900">Kelola Berita</p>
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-400 group-hover:text-gray-600 cursor-pointer" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path d="M6 4 L16 10 L6 16 Z" />
                        </svg>
                    </a>
                </div>
            </div>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-md transition-shadow mb-4">
                <div class="overflow-hidden group shadow-sm sm:rounded-lg hover:shadow-md transition-shadow">
                    <a href="{{ route('dashboard') }}" class="btn bg-white flex justify-between p-8">
                        <p class=" text-lg text-zinc-900">Koleksi Dokumen</p>
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-400 group-hover:text-gray-600 cursor-pointer" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path d="M6 4 L16 10 L6 16 Z" />
                        </svg>
                    </a>
                </div>
            </div>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-md transition-shadow mb-4">
                <div class="overflow-hidden group shadow-sm sm:rounded-lg hover:shadow-md transition-shadow">
                    <a href="{{ route('dashboard') }}" class="btn bg-white flex justify-between p-8">
                        <p class=" text-lg text-zinc-900">Foto dan Video</p>
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-400 group-hover:text-gray-600 cursor-pointer" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path d="M6 4 L16 10 L6 16 Z" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div> --}}
</x-app-layout>
