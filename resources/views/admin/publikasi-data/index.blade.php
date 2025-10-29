<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Menu Publikasi dan Data  ') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 ">
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
    </div>
</x-app-layout>
