<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- Welcome Section --}}
            <div class="mb-8 bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-100  p-6">
                <div class="flex flex-col md:flex-row md:items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">Selamat datang, {{ Auth::user()->name }}! 👋</h1>
                        <p class="mt-2 text-gray-600">
                            Ini adalah dashboard admin Pusat Studi Pelestarian Bahasa Dan Sastra Daerah.
                            Kelola konten website Anda dari sini.
                        </p>
                    </div>
                    <div class="mt-4 md:mt-0">
                        <span class="inline-flex items-center px-4 py-2 bg-white border border-blue-300  text-sm font-medium text-blue-700">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            {{ now()->translatedFormat('l, d F Y') }}
                        </span>
                    </div>
                </div>
            </div>

            {{-- START: Full-Width Website Visits Highlight --}}
            <div class="mb-8 bg-white overflow-hidden  border border-yellow-200">
                <div class="p-6">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center">
                        {{-- Total Kunjungan (Highlight) --}}
                        <div class="flex items-center mb-4 sm:mb-0">
                            <div class="flex-shrink-0 bg-yellow-100 p-4  mr-4">
                                {{-- Icon Kunjungan (Mata) --}}
                                <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-lg font-medium text-gray-600">Total Kunjungan Situs (Views)</p>
                                {{-- <p class="text-4xl font-extrabold text-gray-900 mt-1">
                                    
                                </p> --}}
                            </div>
                        </div>

                        {{-- Kunjungan Unik (Detail) --}}
                        <div class="flex items-center text-right border-l pl-4 border-gray-200">
                            <div class="ml-4">
                                {{-- <p class="text-sm font-medium text-gray-600">Pengunjung Unik (Total)</p> --}}
                                <p class="text-3xl font-semibold text-yellow-600 mt-1">
                                    {{ number_format($totalWebsiteVisits ?? 0, 0, ',', '.') }} <span class="text-2xl items-center">Kunjungan</span>
                                </p>
                            </div>
                            <div class="ml-4 flex-shrink-0">
                                {{-- Icon User --}}
                                <svg class="w-6 h-6 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- END: Full-Width Website Visits Highlight --}}

            {{-- Quick Stats Grid --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                {{-- Berita Card --}}
                <div class="bg-white overflow-hidden shadow-sm  border border-gray-200">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-blue-100 p-3 ">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-600">Total Berita</p>
                                <p class="text-2xl font-semibold text-gray-900">{{ $stats['total_berita'] }}</p>
                            </div>
                        </div>
                        <div class="mt-4 grid grid-cols-2 gap-2">
                            <div class="text-center">
                                <p class="text-sm text-green-600 font-medium">{{ $stats['published_berita'] }}</p>
                                <p class="text-xs text-gray-500">Published</p>
                            </div>
                            <div class="text-center">
                                <p class="text-sm text-yellow-600 font-medium">{{ $stats['draft_berita'] }}</p>
                                <p class="text-xs text-gray-500">Draft</p>
                            </div>
                        </div>
                        <div class="mt-4">
                            <a href="{{ route('admin.publikasi-data.berita.index') }}"
                               class="text-sm font-medium text-blue-600 hover:text-blue-700 inline-flex items-center">
                                Kelola Berita
                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Penelitian Card --}}
                <div class="bg-white overflow-hidden shadow-sm  border border-gray-200">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-purple-100 p-3 ">
                                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-600">Penelitian</p>
                                <p class="text-2xl font-semibold text-gray-900">{{ $stats['total_publikasi'] + $stats['total_seminar'] }}</p>
                            </div>
                        </div>
                        <div class="mt-4 grid grid-cols-2 gap-2">
                            <div class="text-center">
                                <p class="text-sm text-purple-600 font-medium">{{ $stats['total_publikasi'] }}</p>
                                <p class="text-xs text-gray-500">Publikasi</p>
                            </div>
                            <div class="text-center">
                                <p class="text-sm text-purple-600 font-medium">{{ $stats['total_seminar'] }}</p>
                                <p class="text-xs text-gray-500">Seminar</p>
                            </div>
                        </div>
                        <div class="mt-4">
                            <a href="{{ route('admin.penelitian.index') }}"
                               class="text-sm font-medium text-purple-600 hover:text-purple-700 inline-flex items-center">
                                Kelola Penelitian
                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Fasilitas Card --}}
                <div class="bg-white overflow-hidden shadow-sm  border border-gray-200">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-green-100 p-3 ">
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-600">Fasilitas</p>
                                <p class="text-2xl font-semibold text-gray-900">{{ $stats['total_fasilitas'] }}</p>
                            </div>
                        </div>
                        <div class="mt-4">
                            <div class="text-center">
                                <p class="text-sm text-gray-500">Total fasilitas yang tersedia</p>
                            </div>
                        </div>
                        <div class="mt-4">
                            <a href="{{ route('admin.fasilitas.index') }}"
                               class="text-sm font-medium text-green-600 hover:text-green-700 inline-flex items-center">
                                Kelola Fasilitas
                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Users Card --}}
                <div class="bg-white overflow-hidden shadow-sm  border border-gray-200">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-red-100 p-3 ">
                                <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5 3.714V9.286a.75.75 0 00-.546-.721A41.4 41.4 0 0012 8c-2.828 0-5.483.957-7.546 2.564A.75.75 0 004 9.286v12.428a.75.75 0 00.546.721 41.403 41.403 0 007.454 1.564c2.828 0 5.483-.957 7.546-2.564a.75.75 0 00.546-.721z"/>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-600">Pengguna</p>
                                <p class="text-2xl font-semibold text-gray-900">{{ $stats['total_users'] }}</p>
                            </div>
                        </div>
                        <div class="mt-4 grid grid-cols-2 gap-2">
                            <div class="text-center">
                                <p class="text-sm text-red-600 font-medium">{{ $stats['admin_users'] }}</p>
                                <p class="text-xs text-gray-500">Admin</p>
                            </div>
                            <div class="text-center">
                                <p class="text-sm text-red-600 font-medium">{{ $stats['editor_users'] }}</p>
                                <p class="text-xs text-gray-500">Editor</p>
                            </div>
                        </div>
                        <div class="mt-4">
                            <a href="{{ route('admin.user.index') }}"
                               class="text-sm font-medium text-red-600 hover:text-red-700 inline-flex items-center">
                                Kelola Pengguna
                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
                {{-- START: Website Visits Card --}}
                
            </div>

            {{-- Main Content --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                {{-- Left Column --}}
                <div class="lg:col-span-2 space-y-8">
                    {{-- Chart Section --}}
                    <div class="bg-white overflow-hidden shadow-sm  border border-gray-200">
                        <div class="p-6">
                            <div class="flex justify-between items-center mb-4">
                                <h3 class="text-lg font-semibold text-gray-900">Statistik Publikasi</h3>
                                <div class="flex space-x-2">
                                    <button id="monthly-btn" class="px-3 py-1 text-xs font-medium  bg-blue-100 text-blue-700 transition">
                                        Bulanan
                                    </button>
                                    {{-- <button id="weekly-btn" class="px-3 py-1 text-xs font-medium  bg-gray-100 text-gray-700 hover:bg-gray-200 transition">
                                        Mingguan
                                    </button> --}}
                                </div>
                            </div>
                            <div id="chartContainer" style="position: relative; height: 300px;">
                                {{-- Chart Canvas will be appended here by the JavaScript --}}
                            </div>
                        </div>
                    </div>

                    {{-- Quick Actions --}}
                    <div class="bg-white overflow-hidden shadow-sm  border border-gray-200">
                        <div class="p-6">
                            <div class="flex justify-between items-center mb-6">
                                <h3 class="text-lg font-semibold text-gray-900">Aksi Cepat</h3>
                                <span class="text-sm text-gray-500">Tambahkan konten baru dengan cepat</span>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                {{-- Publikasi & Data --}}
                                <div class="border border-gray-200  p-4 hover:border-blue-300 hover:shadow-sm transition">
                                    <div class="flex items-center mb-3">
                                        <div class="p-2 bg-blue-100  mr-3">
                                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                                            </svg>
                                        </div>
                                        <h4 class="font-medium text-gray-900">Publikasi & Data</h4>
                                    </div>
                                    <div class="space-y-2 pl-11">
                                        <a href="{{ route('admin.publikasi-data.berita.create') }}"
                                           class="flex items-center text-sm text-gray-600 hover:text-blue-600">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                            </svg>
                                            Tambah Berita
                                        </a>
                                        <a href="{{ route('admin.publikasi-data.artikel.create') }}"
                                           class="flex items-center text-sm text-gray-600 hover:text-green-600">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                            </svg>
                                            Tambah Artikel
                                        </a>
                                        <a href="{{ route('admin.publikasi-data.dokumen.create') }}"
                                           class="flex items-center text-sm text-gray-600 hover:text-purple-600">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                            </svg>
                                            Upload Dokumen
                                        </a>
                                    </div>
                                </div>

                                {{-- Penelitian --}}
                                <div class="border border-gray-200  p-4 hover:border-purple-300 hover:shadow-sm transition">
                                    <div class="flex items-center mb-3">
                                        <div class="p-2 bg-purple-100  mr-3">
                                            <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                                            </svg>
                                        </div>
                                        <h4 class="font-medium text-gray-900">Penelitian</h4>
                                    </div>
                                    <div class="space-y-2 pl-11">
                                        <a href="{{ route('admin.penelitian.publikasi-terindeks.create') }}"
                                           class="flex items-center text-sm text-gray-600 hover:text-purple-600">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                            </svg>
                                            Tambah Publikasi
                                        </a>
                                        <a href="{{ route('admin.penelitian.seminar.create') }}"
                                           class="flex items-center text-sm text-gray-600 hover:text-red-600">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                            </svg>
                                            Jadwalkan Seminar
                                        </a>
                                    </div>
                                </div>

                                {{-- Tentang Kami --}}
                                <div class="border border-gray-200  p-4 hover:border-green-300 hover:shadow-sm transition">
                                    <div class="flex items-center mb-3">
                                        <div class="p-2 bg-green-100  mr-3">
                                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                        </div>
                                        <h4 class="font-medium text-gray-900">Tentang Kami</h4>
                                    </div>
                                    <div class="space-y-2 pl-11">
                                        <a href="{{ route('admin.profil.peneliti.create') }}"
                                           class="flex items-center text-sm text-gray-600 hover:text-green-600">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                            </svg>
                                            Tambah Peneliti
                                        </a>
                                        <a href="{{ route('admin.profil.mitra.create') }}"
                                           class="flex items-center text-sm text-gray-600 hover:text-blue-600">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                            </svg>
                                            Tambah Mitra
                                        </a>
                                    </div>
                                </div>

                                {{-- Fasilitas --}}
                                <div class="border border-gray-200  p-4 hover:border-yellow-300 hover:shadow-sm transition">
                                    <div class="flex items-center mb-3">
                                        <div class="p-2 bg-yellow-100  mr-3">
                                            <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                            </svg>
                                        </div>
                                        <h4 class="font-medium text-gray-900">Fasilitas</h4>
                                    </div>
                                    <div class="space-y-2 pl-11">
                                        <a href="{{ route('admin.fasilitas.create') }}"
                                           class="flex items-center text-sm text-gray-600 hover:text-yellow-600">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                            </svg>
                                            Tambah Fasilitas
                                        </a>
                                        <a href="{{ route('admin.fasilitas.index') }}"
                                           class="flex items-center text-sm text-gray-600 hover:text-gray-800">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                                            </svg>
                                            Kelola Fasilitas
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Recent Berita --}}
                    <div class="bg-white overflow-hidden shadow-sm  border border-gray-200">
                        <div class="p-6">
                            <div class="flex justify-between items-center mb-6">
                                <h3 class="text-lg font-semibold text-gray-900">Berita Terbaru</h3>
                                <a href="{{ route('admin.publikasi-data.berita.index') }}"
                                   class="text-sm font-medium text-blue-600 hover:text-blue-700">
                                    Lihat Semua →
                                </a>
                            </div>

                            <div class="space-y-4">
                                @forelse($recentBerita as $berita)
                                    <div class="flex items-center p-3 hover:bg-gray-50  transition">
                                        <div class="flex-shrink-0 w-12 h-12 bg-gray-100  overflow-hidden">
                                            @if($berita->thumbnail_path)
                                                <img src="{{ Storage::url($berita->thumbnail_path) }}"
                                                    alt="{{ $berita->judul }}"
                                                    class="w-full h-full object-cover">
                                            @else
                                                <div class="w-full h-full flex items-center justify-center bg-gray-200">
                                                    <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                    </svg>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="ml-4 flex-1 min-w-0">
                                            <p class="text-sm font-medium text-gray-900 truncate">
                                                <a href="{{ route('admin.publikasi-data.berita.edit', $berita->id) }}"
                                                   class="hover:text-blue-600">
                                                    {{ $berita->judul }}
                                                </a>
                                            </p>
                                            <div class="flex items-center mt-1 text-xs text-gray-500">
                                                <span class="capitalize">{{ $berita->kategori }}</span>
                                                <span class="mx-2">•</span>
                                                <span>{{ $berita->published_at ? $berita->published_at->diffForHumans() : 'Draft' }}</span>
                                            </div>
                                        </div>
                                        <div class="ml-4">
                                            @if($berita->published_at && $berita->published_at <= now())
                                                <span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">
                                                    Published
                                                </span>
                                            @else
                                                <span class="px-2 py-1 text-xs font-medium bg-yellow-100 text-yellow-800 rounded-full">
                                                    Draft
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                @empty
                                    <p class="text-sm text-gray-500 text-center py-4">Belum ada berita.</p>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Right Column --}}
                <div class="space-y-8">
                    {{-- Recent Activities --}}
                    <div class="bg-white overflow-hidden shadow-sm  border border-gray-200">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-6">Aktivitas Terbaru</h3>

                            <div class="space-y-4">
                                @forelse($recentActivities as $activity)
                                    <div class="flex items-start">
                                        <div class="flex-shrink-0">
                                            <div class="p-2  {{ $activity['color'] }}">
                                                @if($activity['icon'] === 'newspaper')
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                                                    </svg>
                                                @elseif($activity['icon'] === 'document-text')
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                                    </svg>
                                                @elseif($activity['icon'] === 'folder')
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/>
                                                    </svg>
                                                @elseif($activity['icon'] === 'calendar')
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                    </svg>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="ml-3 flex-1 min-w-0">
                                            <p class="text-sm font-medium text-gray-900 truncate">
                                                <a href="{{ $activity['url'] }}" class="hover:text-blue-600">
                                                    {{ $activity['title'] }}
                                                </a>
                                            </p>
                                            <p class="text-xs text-gray-500 mt-1">
                                                {{ $activity['time']->diffForHumans() }}
                                            </p>
                                        </div>
                                    </div>
                                @empty
                                    <p class="text-sm text-gray-500 text-center py-4">Belum ada aktivitas terbaru.</p>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    {{-- Upcoming Seminars --}}
                    @if($upcomingSeminars->count() > 0)
                        <div class="bg-white overflow-hidden shadow-sm  border border-gray-200">
                            <div class="p-6">
                                <div class="flex justify-between items-center mb-6">
                                    <h3 class="text-lg font-semibold text-gray-900">Seminar Mendatang</h3>
                                    <a href="{{ route('admin.penelitian.seminar.index') }}"
                                       class="text-sm font-medium text-blue-600 hover:text-blue-700">
                                        Lihat Semua →
                                    </a>
                                </div>

                                <div class="space-y-4">
                                    @foreach($upcomingSeminars as $seminar)
                                        <div class="border-l-4 border-blue-500 pl-4 py-2">
                                            <h4 class="text-sm font-medium text-gray-900 line-clamp-1">
                                                {{ $seminar->judul }}
                                            </h4>
                                            <div class="flex items-center mt-1 text-xs text-gray-500">
                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                </svg>
                                                {{ \Carbon\Carbon::parse($seminar->tanggal)->translatedFormat('d M Y') }}
                                            </div>
                                            <div class="flex items-center mt-1 text-xs text-gray-500">
                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                                </svg>
                                                {{ $seminar->tempat }} ({{ $seminar->format }})
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- Pending Comments --}}
                    @if($stats['pending_komentar'] > 0)
                        <div class="bg-yellow-50 border border-yellow-200  p-6">
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-yellow-800">Perhatian</h3>
                                    <div class="mt-2 text-sm text-yellow-700">
                                        <p>Ada <span class="font-semibold">{{ $stats['pending_komentar'] }} komentar</span> yang perlu ditinjau.</p>
                                    </div>
                                    <div class="mt-3">
                                        <a href="{{ route('admin.publikasi-data.komentar.index') }}"
                                           class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium text-yellow-700 bg-yellow-100 hover:bg-yellow-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">
                                            Tinjau Komentar
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- Website Status --}}
                    <div class="bg-gradient-to-r from-gray-50 to-gray-100 border border-gray-200  p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Status Website</h3>
                        <div class="space-y-3">
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600">Total Konten</span>
                                <span class="text-sm font-medium text-gray-900">
                                    {{ $stats['total_berita'] + $stats['total_artikel'] + $stats['total_dokumen'] }}
                                </span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600">Total Peneliti</span>
                                <span class="text-sm font-medium text-gray-900">{{ $stats['total_peneliti'] }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600">Total Mitra</span>
                                <span class="text-sm font-medium text-gray-900">{{ $stats['total_mitra'] }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600">Album Galeri</span>
                                <span class="text-sm font-medium text-gray-900">{{ $stats['total_albums'] }}</span>
                            </div>
                        </div>
                        <div class="mt-4 pt-4 border-t border-gray-200">
                            <a href="{{ url('/') }}"
                               target="_blank"
                               class="inline-flex items-center text-sm font-medium text-blue-600 hover:text-blue-700">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                </svg>
                                Kunjungi Website
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> 

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
document.addEventListener('DOMContentLoaded', function() {
    // Get chart container
    const chartContainer = document.getElementById('chartContainer');

    if (chartContainer) {
        <?php
        // Generate default chart data in PHP
        $defaultChartData = [
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
            'datasets' => [
                [
                    'label' => 'Berita',
                    'data' => [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
                    'borderColor' => '#3b82f6',
                    'backgroundColor' => 'rgba(59, 130, 246, 0.1)',
                    'tension' => 0.4
                ],
                [
                    'label' => 'Artikel',
                    'data' => [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
                    'borderColor' => '#10b981',
                    'backgroundColor' => 'rgba(16, 185, 129, 0.1)',
                    'tension' => 0.4
                ]
            ]
        ];
        
        // Use actual chart data if available
        $finalChartData = isset($chartData) ? $chartData : $defaultChartData;
        ?>

        // Initial chart data from PHP
        const initialChartData = <?php echo json_encode($finalChartData); ?>;

        // Create canvas element
        const canvas = document.createElement('canvas');
        chartContainer.appendChild(canvas);

        // Initialize chart
        const ctx = canvas.getContext('2d');
        let chart = null;

        try {
            chart = new Chart(ctx, {
                type: 'line',
                data: initialChartData,
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        tooltip: {
                            mode: 'index',
                            intersect: false,
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 5
                            }
                        }
                    },
                    interaction: {
                        intersect: false,
                        mode: 'nearest'
                    }
                }
            });
        } catch (error) {
            console.error('Error initializing chart:', error);
            chartContainer.innerHTML = '<p class="text-sm text-gray-500 text-center py-8">Gagal memuat chart statistik.</p>';
            return;
        }

        // Filter buttons functionality
        const monthlyBtn = document.getElementById('monthly-btn');
        const weeklyBtn = document.getElementById('weekly-btn');

        if (monthlyBtn && weeklyBtn) {
            // Set initial active button
            monthlyBtn.classList.add('bg-blue-100', 'text-blue-700');
            monthlyBtn.classList.remove('bg-gray-100', 'text-gray-700');
            weeklyBtn.classList.add('bg-gray-100', 'text-gray-700');
            weeklyBtn.classList.remove('bg-blue-100', 'text-blue-700');

            monthlyBtn.addEventListener('click', function() {
                if (this.classList.contains('bg-blue-100')) return;
                
                this.classList.add('bg-blue-100', 'text-blue-700');
                this.classList.remove('bg-gray-100', 'text-gray-700');
                weeklyBtn.classList.add('bg-gray-100', 'text-gray-700');
                weeklyBtn.classList.remove('bg-blue-100', 'text-blue-700');

                fetchChartData('monthly');
            });

            weeklyBtn.addEventListener('click', function() {
                if (this.classList.contains('bg-blue-100')) return;
                
                this.classList.add('bg-blue-100', 'text-blue-700');
                this.classList.remove('bg-gray-100', 'text-gray-700');
                monthlyBtn.classList.add('bg-gray-100', 'text-gray-700');
                monthlyBtn.classList.remove('bg-blue-100', 'text-blue-700');

                fetchChartData('weekly');
            });
        }

        // Function to fetch chart data
        function fetchChartData(range) {
            // Show loading state
            if (chart) {
                chart.data.datasets.forEach(dataset => {
                    dataset.data = dataset.data.map(() => 0);
                });
                chart.update();
            }
            
            fetch(`/admin/dashboard/chart-data?range=${range}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data && data.labels && data.datasets && chart) {
                        chart.data.labels = data.labels;
                        chart.data.datasets = data.datasets;
                        chart.update();
                    }
                })
                .catch(error => {
                    console.error('Error fetching chart data:', error);
                });
        }
    }
});

</script>
    @endpush

    <style>
#chartContainer {
    position: relative;
    height: 300px;
    transition: opacity 0.3s ease;
}

#chartContainer.loading {
    opacity: 0.5;
}

#chartContainer canvas {
    max-height: 300px;
}

/* Custom tooltip styles */
.chartjs-tooltip {
    opacity: 0;
    position: absolute;
    background: rgba(0, 0, 0, 0.7);
    color: white;
    border-radius: 3px;
    -webkit-transition: all .1s ease;
    transition: all .1s ease;
    pointer-events: none;
    -webkit-transform: translate(-50%, 0);
    transform: translate(-50%, 0);
    padding: 4px 8px;
    font-size: 12px;
}

.chartjs-tooltip-key {
    display: inline-block;
    width: 10px;
    height: 10px;
    margin-right: 5px;
}
</style>
</x-app-layout>