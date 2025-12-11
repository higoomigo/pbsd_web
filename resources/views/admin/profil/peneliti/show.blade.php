    <x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Profil Peneliti') }} — {{ $peneliti->nama_lengkap }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

        {{-- Tombol Action --}}
        <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="flex items-center gap-3">
            <button type="button" onclick="history.back()" 
                    class="inline-flex items-center gap-2 px-4 py-2 bg-white  text-gray-700 hover:bg-gray-50 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Kembali
            </button>
            <span class="text-sm text-gray-500">Detail profil peneliti</span>
            </div>

            <div class="flex flex-wrap gap-2">
            <form action="{{ route('admin.profil.peneliti.toggle-beranda', $peneliti) }}" method="POST" class="inline">
                @csrf
                <button type="submit" 
                        class="inline-flex items-center gap-2 px-4 py-2  transition-all {{ $peneliti->tampil_beranda ? 'bg-black text-white hover:bg-gray-800' : 'bg-white text-gray-700 hover:bg-gray-100' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 9V5a3 3 0 00-3-3l-4 9v11h11.28a2 2 0 002-1.7l1.38-9a2 2 0 00-2-2.3zM7 22H4a2 2 0 01-2-2v-7a2 2 0 012-2h3"/>
                </svg>
                {{ $peneliti->tampil_beranda ? 'Tampil Beranda' : 'Sembunyi' }}
                </button>
            </form>

            <form action="{{ route('admin.profil.peneliti.toggle-publish', $peneliti) }}" method="POST" class="inline">
                @csrf
                <button type="submit"
                        class="inline-flex items-center gap-2 px-4 py-2  transition-all {{ $peneliti->is_published ? 'bg-black text-white hover:bg-gray-800' : 'bg-white text-gray-700 hover:bg-gray-100' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
                {{ $peneliti->is_published ? 'Published' : 'Draft' }}
                </button>
            </form>

            <a href="{{ route('admin.profil.peneliti.edit', $peneliti) }}"
                class="inline-flex items-center gap-2 px-4 py-2 bg-white  text-gray-700 hover:bg-gray-100 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
                Edit Profil
            </a>
            </div>
        </div>

        {{-- Main Content --}}
        <div class="bg-white overflow-hidden">
            {{-- Hero Section --}}
            <div class="bg-gradient-to-br  px-8 py-12 text-gray-900 border-b border-black">
            <div class="flex flex-col lg:flex-row items-center gap-8">
                {{-- Profile Photo --}}
                <div class="flex-shrink-0">
                <div class="relative">
                    @if($peneliti->foto_url)
                    <img src="{{ $peneliti->foto_url }}" alt="{{ $peneliti->nama }}" 
                        class="w-40 h-40 object-cover border-4 border-black shadow-lg">
                    @else
                    <div class="w-40 h-40 bg-gray-300 border-4 border-black flex items-center justify-center shadow-lg">
                        <svg class="w-20 h-20 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>
                    @endif
                    {{-- Status Badge --}}
                    <div class="absolute -bottom-2 -right-2">
                    <span class="inline-flex items-center px-3 py-1 text-xs font-medium  {{ $peneliti->is_published ? 'bg-black text-white' : 'bg-white text-gray-700' }}">
                        {{ $peneliti->is_published ? 'Published' : 'Draft' }}
                    </span>
                    </div>
                </div>
                </div>

                {{-- Profile Info --}}
                <div class="flex-1 text-center lg:text-left">
                <h1 class="text-4xl font-bold mb-3 leading-tight">{{ $peneliti->nama_lengkap }}</h1>
                
                <div class="flex flex-wrap justify-center lg:justify-start gap-3 mb-4">
                    <span class="inline-flex items-center px-4 py-2 bg-white  text-sm font-medium">
                    {{ $peneliti->posisi }}
                    </span>
                    @if($peneliti->jabatan)
                    <span class="inline-flex items-center px-4 py-2 bg-white  text-sm font-medium">
                        {{ $peneliti->jabatan }}
                    </span>
                    @endif
                    <span class="inline-flex items-center px-4 py-2 bg-white  text-sm font-medium">
                    {{ $peneliti->status }}
                    </span>
                    <span class="inline-flex items-center px-4 py-2 bg-white  text-sm font-medium">
                    {{ $peneliti->tipe }}
                    </span>
                </div>

                @if($peneliti->deskripsi_singkat)
                    <p class="text-gray-700 text-lg leading-relaxed max-w-3xl border-t border-black pt-4">
                    "{{ $peneliti->deskripsi_singkat }}"
                    </p>
                @endif
                </div>
            </div>
            </div>

            {{-- Content Grid --}}
            <div class="p-8">
            <div class="grid lg:grid-cols-3 gap-8">
                {{-- Left Column --}}
                <div class="lg:col-span-2 space-y-8">
                {{-- Bidang Keahlian --}}
                @if($peneliti->bidang_keahlian && count($peneliti->bidang_keahlian) > 0)
                    <div class="bg-white  p-6">
                    <h2 class="text-2xl font-bold text-gray-800 mb-4 flex items-center gap-3 border-b border-black pb-2">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                        Bidang Keahlian
                    </h2>
                    <div class="flex flex-wrap gap-3">
                        @foreach($peneliti->bidang_keahlian as $bidang)
                        <span class="inline-flex items-center px-4 py-2 bg-white  text-gray-700 text-sm font-medium">
                            {{ $bidang }}
                        </span>
                        @endforeach
                    </div>
                    </div>
                @endif

                {{-- Biografi --}}
                @if($peneliti->biografi)
                    <div class="bg-white  p-6">
                    <h2 class="text-2xl font-bold text-gray-800 mb-4 flex items-center gap-3 border-b border-black pb-2">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Profil & Biografi
                    </h2>
                    <div class="prose max-w-none text-gray-700 leading-relaxed text-lg">
                        {!! nl2br(e($peneliti->biografi)) !!}
                    </div>
                    </div>
                @endif

                {{-- Riwayat Pendidikan & Pencapaian --}}
                <div class="grid md:grid-cols-2 gap-6">
                    @if($peneliti->riwayat_pendidikan)
                    <div class="bg-white  p-6">
                        <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2 border-b border-black pb-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M12 14l9-5-9-5-9 5 9 5z"></path>
                            <path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path>
                        </svg>
                        Riwayat Pendidikan
                        </h2>
                        <div class="prose max-w-none text-gray-700 leading-relaxed">
                        {!! nl2br(e($peneliti->riwayat_pendidikan)) !!}
                        </div>
                    </div>
                    @endif

                    @if($peneliti->pencapaian)
                    <div class="bg-white  p-6">
                        <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2 border-b border-black pb-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Pencapaian
                        </h2>
                        <div class="prose max-w-none text-gray-700 leading-relaxed">
                        {!! nl2br(e($peneliti->pencapaian)) !!}
                        </div>
                    </div>
                    @endif
                </div>

                {{-- Publikasi & Penelitian --}}
                <div class="grid md:grid-cols-2 gap-6">
                    {{-- Publikasi Terpilih --}}
                    @if($peneliti->publikasi_terpilih && count($peneliti->publikasi_terpilih) > 0)
                    <div class="bg-white  p-6">
                        <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2 border-b border-black pb-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                        Publikasi Terpilih
                        </h2>
                        <div class="space-y-3">
                        @foreach($peneliti->publikasi_terpilih as $index => $publikasi)
                            <div class="flex items-start gap-3 p-4 bg-white ">
                            <span class="flex-shrink-0 w-6 h-6 bg-black text-white text-xs flex items-center justify-center font-bold mt-0.5">
                                {{ $index + 1 }}
                            </span>
                            <p class="text-gray-700 flex-1">{{ $publikasi }}</p>
                            </div>
                        @endforeach
                        </div>
                    </div>
                    @endif

                    {{-- Penelitian Unggulan --}}
                    @if($peneliti->penelitian_unggulan && count($peneliti->penelitian_unggulan) > 0)
                    <div class="bg-white  p-6">
                        <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2 border-b border-black pb-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                        </svg>
                        Penelitian Unggulan
                        </h2>
                        <div class="space-y-3">
                        @foreach($peneliti->penelitian_unggulan as $index => $penelitian)
                            <div class="flex items-start gap-3 p-4 bg-white ">
                            <span class="flex-shrink-0 w-6 h-6 bg-black text-white text-xs flex items-center justify-center font-bold mt-0.5">
                                {{ $index + 1 }}
                            </span>
                            <p class="text-gray-700 flex-1">{{ $penelitian }}</p>
                            </div>
                        @endforeach
                        </div>
                    </div>
                    @endif
                </div>
                </div>

                {{-- Right Column --}}
                <div class="space-y-6">
                {{-- Kontak & Sosial Media --}}
                <div class="bg-white  p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2 border-b border-black pb-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    Kontak & Jejaring
                    </h2>
                    <div class="space-y-4">
                    @if($peneliti->email)
                        <div class="flex items-center gap-3 p-3 bg-white ">
                        <div class="w-10 h-10 bg-black flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm text-gray-500">Email</p>
                            <a href="mailto:{{ $peneliti->email }}" class="text-gray-700 font-medium truncate hover:underline">
                            {{ $peneliti->email }}
                            </a>
                        </div>
                        </div>
                    @endif

                    @if($peneliti->phone)
                        <div class="flex items-center gap-3 p-3 bg-white ">
                        <div class="w-10 h-10 bg-black flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm text-gray-500">Telepon</p>
                            <a href="tel:{{ $peneliti->phone }}" class="text-gray-700 font-medium">
                            {{ $peneliti->phone }}
                            </a>
                        </div>
                        </div>
                    @endif

                    @if($peneliti->website)
                        <div class="flex items-center gap-3 p-3 bg-white ">
                        <div class="w-10 h-10 bg-black flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9v-9m0-9v9m0 9c-5 0-9-4-9-9s4-9 9-9"/>
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm text-gray-500">Website</p>
                            <a href="{{ $peneliti->website }}" target="_blank" class="text-gray-700 font-medium truncate hover:underline">
                            {{ parse_url($peneliti->website, PHP_URL_HOST) }}
                            </a>
                        </div>
                        </div>
                    @endif

                    {{-- Social Links --}}
                    @if($peneliti->hasSocialLinks())
                        @if(isset($peneliti->social_links['linkedin']) && $peneliti->social_links['linkedin'])
                        <div class="flex items-center gap-3 p-3 bg-white ">
                            <div class="w-10 h-10 bg-black flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                            </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                            <p class="text-sm text-gray-500">LinkedIn</p>
                            <a href="{{ $peneliti->social_links['linkedin'] }}" target="_blank" class="text-gray-700 font-medium truncate hover:underline">
                                LinkedIn Profile
                            </a>
                            </div>
                        </div>
                        @endif

                        @if(isset($peneliti->social_links['google_scholar']) && $peneliti->social_links['google_scholar'])
                        <div class="flex items-center gap-3 p-3 bg-white ">
                            <div class="w-10 h-10 bg-black flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 24a7 7 0 1 1 0-14 7 7 0 0 1 0 14zm0-24L0 9.5l4.838 3.94A8 8 0 0 1 12 9a8 8 0 0 1 7.162 4.44L24 9.5z"/>
                            </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                            <p class="text-sm text-gray-500">Google Scholar</p>
                            <a href="{{ $peneliti->social_links['google_scholar'] }}" target="_blank" class="text-gray-700 font-medium truncate hover:underline">
                                Scholar Profile
                            </a>
                            </div>
                        </div>
                        @endif

                        @if(isset($peneliti->social_links['researchgate']) && $peneliti->social_links['researchgate'])
                        <div class="flex items-center gap-3 p-3 bg-white ">
                            <div class="w-10 h-10 bg-black flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 0C5.373 0 0 5.373 0 12s5.373 12 12 12 12-5.373 12-12S18.627 0 12 0zm0 22.5C6.201 22.5 1.5 17.799 1.5 12S6.201 1.5 12 1.5 22.5 6.201 22.5 12 17.799 22.5 12 22.5zM10.875 9.75v4.5h2.25v-4.5h-2.25zm-1.125 6.75v-6H6v6h3.75zm7.5-6h-3.75v6H18v-6z"/>
                            </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                            <p class="text-sm text-gray-500">ResearchGate</p>
                            <a href="{{ $peneliti->social_links['researchgate'] }}" target="_blank" class="text-gray-700 font-medium truncate hover:underline">
                                ResearchGate
                            </a>
                            </div>
                        </div>
                        @endif
                    @endif
                    </div>
                </div>

                {{-- Metadata --}}
                <div class="bg-white  p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2 border-b border-black pb-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Informasi Sistem
                    </h2>
                    <div class="space-y-3">
                    {{-- <div class="flex justify-between items-center p-3 bg-white ">
                        <span class="text-gray-600">Status Publikasi</span>
                        <span class="px-3 py-1 text-sm font-medium  {{ $peneliti->is_published ? 'bg-black text-white' : 'bg-white text-gray-700' }}">
                        {{ $peneliti->is_published ? 'Published' : 'Draft' }}
                        </span>
                    </div> --}}
                    {{-- <div class="flex justify-between items-center p-3 bg-white ">
                        <span class="text-gray-600">Tampil Beranda</span>
                        <span class="px-3 py-1 text-sm font-medium  {{ $peneliti->tampil_beranda ? 'bg-black text-white' : 'bg-white text-gray-700' }}">
                        {{ $peneliti->tampil_beranda ? 'Ya' : 'Tidak' }}
                        </span>
                    </div> --}}
                    {{-- <div class="flex justify-between items-center p-3 bg-white ">
                        <span class="text-gray-600">Urutan Tampil</span>
                        <span class="px-3 py-1 bg-black text-white text-sm font-medium ">
                        #{{ $peneliti->urutan }}
                        </span>
                    </div> --}}
                    <div class="flex justify-between items-center p-3 bg-white ">
                        <span class="text-gray-600">Terakhir Update</span>
                        <span class="text-sm text-gray-700 font-medium">
                        {{ $peneliti->updated_at->format('d M Y H:i') }}
                        </span>
                    </div>
                    </div>
                </div>
                </div>
            </div>
            </div>
        </div>
        </div>
    </div>
    </x-app-layout>