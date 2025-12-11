@extends('layout-web.app')
@section('title', 'Pusat Studi Pelestarian Bahasa Dan Sastra Daerah')
@section('content')


<div class="w-full md:py-48 py-36">
    {{-- sm:text-6xl text-5xl --}}
    <div class="font-title lg:px-40 px-4 md:px-20 md:text-center text-start">
        <p class="text-zinc-800  text-5xl sm:text-6xl text-start md:mb-2">Pusat Studi</p>
        <p class="text-slate-900 font-normal text-5xl text-start sm:text-5xl md:text-7xl"> Pelestarian Bahasa dan Sastra Daerah </p> 
    </div>
</div>
<div class=" w-full h-[500px]  mb-6 opacity-0 translate-y-8 transition-all duration-700 ease-out mt-20" id="hero-image">
    <img class="w-full h-full object-cover" src="https://www.researchgate.net/publication/371827625/figure/fig3/AS:11431281179849279@1691415873069/The-Harbour-Office-area-in-Gorontalo-circa-1926-Source-Digital-Collection-Leiden.png" alt="">
</div>

<!-- Main content -->
<div class="container mx-auto  sm:px-6 lg:px-36 mt-6 ">
    {{-- Profil --}}
    <div class="mb-18">
        <div class="grid lg:grid-cols-3 md:grid-cols-1 sm:grid-cols-1 gap-6 mb-6 pt-24 md:pt-40 md:pb-12 ">
            <div class="col-span-1 px-6 pb-1 w-full md:mb-6">
                <p class=" lg:text-[50px] text-5xl font-title md:pl-5 text-start text-zinc-700">Tentang <br> Kami</p>
            </div>
            <div class=" col-span-2 px-6 pb-6">
                <p class="mb-10 text-zinc-700 font-body text-lg leading-6 md:pl-20">
                    <span class="text-xl"><b>Pusat Studi Pelestarian Bahasa dan Sastra Daerah</b> Universitas Negeri Gorontalo hadir sebagai komitmen akademik dalam menjaga eksistensi bahasa dan sastra daerah, khususnya Bahasa Gorontalo.</span>
                    <br class="md:mb-10 mb-5">
                    Pusat studi ini fokus pada kegiatan penelitian, dokumentasi, pengembangan, dan diseminasi pengetahuan bahasa serta sastra daerah sebagai upaya pelestarian warisan budaya yang tak ternilai.
                    <br class="md:mb-10 mb-5">
                    Melalui kolaborasi lintas disiplin, PSPBSD menjadi wadah strategis yang menghubungkan akademisi, budayawan, dan masyarakat dalam memperkuat identitas lokal di tengah tantangan global.
                </p>
                {{-- <div class="w-full text-end mt-8 ">
                    <a href="{{ route('profil-full') }}" class="btn hover:bg-white border-2 bg-black text-white text-md hover:text-zinc-900 relative leading-4
                  bg-gradient-to-r from-current to-current bg-[length:0%_2px] bg-left-bottom bg-no-repeat
                  transition-[background-size] duration-500 ease-in-out
                  group-hover:bg-[length:100%_1px] ">Baca Selengkapnya</a>
                </div> --}}
            </div>
        </div>
    </div>
</div>
<div class="container mx-auto  sm:px-6 lg:px-36">
    <div class="mb-12  pt-24 md:pt-20">
        {{-- <div class="grid lg:grid-cols-3 md:grid-cols-1 sm:grid-cols-1 gap-6 mb-6 pt-24 md:pt-20 md:pb-12 ">
            <div class="col-span-1 px-6 pb-1 w-full md:mb-6">
                <p class="lg:text-[50px] text-5xl font-title md:pl-5 text-center text-zinc-700">Fokus Penelitian</p>
            </div>
        </div> --}}
        <p class="lg:text-[50px] text-5xl font-title  text-center text-zinc-700">Mitra Kami</p>

        <div class="relative mt-6 w-full flex justify-center">
            <!-- Left / Right buttons positioned at the sides of the wrapping div -->
            <button id="partners-prev" aria-label="Previous"
            class="absolute left-2 top-1/2 -translate-y-1/2 z-20 p-2 bg-white rounded-full  ">
            <svg class="w-5 h-5 text-zinc-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            </button>

            <button id="partners-next" aria-label="Next"
            class="absolute right-2 top-1/2 -translate-y-1/2 z-20 p-2 bg-white rounded-full  ">
            <svg class="w-5 h-5 text-zinc-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
            </button>

            <!-- Scrollable carousel -->
            <div id="partners-carousel" class="overflow-x-auto scroll-smooth -mx-2 py-2" style="scrollbar-width: none; -ms-overflow-style: none;">
            <div class="flex gap-6 px-2">
                @foreach ($mitra as $m)
                @php
                    // URL logo (kalau kamu pakai Storage public)
                    $logoUrl = $m->logo_path ? Storage::url($m->logo_path) : null;

                    // Fallback inisial (2 huruf dari dua kata pertama)
                    $parts = preg_split('/\s+/', trim($m->nama ?? ''), -1, PREG_SPLIT_NO_EMPTY);
                    $initials = '';
                    foreach (array_slice($parts, 0, 2) as $p) { $initials .= mb_substr($p, 0, 1); }
                    $initials = mb_strtoupper($initials ?: '—');

                    // Target link (website jika ada, else non-aktif)
                    $href = $m->website ?: 'javascript:void(0)';
                @endphp

                <div class="partner-item flex-none w-40 sm:w-48 lg:w-56 bg-white overflow-hidden p-6
                            flex flex-col items-center text-center transition">
                    <a href="{{ $href }}" @if($m->website) target="_blank" rel="noopener" @endif
                    class="w-32 h-32 sm:w-24 sm:h-24 mb-3 rounded-full overflow-hidden 
                            flex items-center justify-center ">
                    @if($logoUrl)
                        <img src="{{ $logoUrl }}"
                            alt="{{ $m->nama ?? 'Logo Mitra' }}"
                            class="w-full h-full object-contain p-1"
                            loading="lazy" decoding="async" />
                    @else
                        <span class="text-zinc-500 text-xs font-title font-light select-none">{{ $initials }}</span>
                    @endif
                    </a>
{{-- 
                    <p class="font-semibold text-sm text-zinc-800 line-clamp-2">
                    {{ $m->nama }}
                    </p>
                    @if(!empty($m->jenis))
                    <p class="text-xs text-zinc-500 mt-0.5">{{ $m->jenis }}</p>
                    @endif --}}
                </div>
                @endforeach
            
            </div>
            </div>
        </div>

        <script>
        document.addEventListener('DOMContentLoaded', function () {
            const carousel = document.getElementById('partners-carousel');
            const prev = document.getElementById('partners-prev');
            const next = document.getElementById('partners-next');

            // gap in px should match Tailwind gap-6 -> 1.5rem -> 24px
            const GAP = 24;

            function itemWidth() {
            const item = carousel.querySelector('.partner-item');
            if (!item) return carousel.clientWidth * 0.8;
            return Math.round(item.getBoundingClientRect().width) + GAP;
            }

            function scrollByAmount(dir = 1) {
            const amount = itemWidth() * 2; // scroll by 2 items at a time
            carousel.scrollBy({ left: dir * amount, behavior: 'smooth' });
            }

            if (prev) prev.addEventListener('click', () => scrollByAmount(-1));
            if (next) next.addEventListener('click', () => scrollByAmount(1));

            // Optional: allow dragging to scroll for desktop
            let isDown = false, startX, scrollLeft;
            carousel.addEventListener('mousedown', (e) => {
            isDown = true;
            carousel.classList.add('cursor-grabbing');
            startX = e.pageX - carousel.offsetLeft;
            scrollLeft = carousel.scrollLeft;
            });
            window.addEventListener('mouseup', () => {
            isDown = false;
            carousel.classList.remove('cursor-grabbing');
            });
            carousel.addEventListener('mousemove', (e) => {
            if (!isDown) return;
            e.preventDefault();
            const x = e.pageX - carousel.offsetLeft;
            const walk = (x - startX) * 1; // scroll-fast multiplier
            carousel.scrollLeft = scrollLeft - walk;
            });
        });
        </script>
    </div>
</div>
<div class="container mx-auto  sm:px-6 lg:px-36 mt-44">
    <div class="mt-32 mb-16 px-6">
    <div class="pb-1 w-full">
        <p class="text-5xl font-title md:pl-5 text-start text-zinc-700">Kegiatan Terbaru</p>
    </div>

    <div class="container mx-auto">
        <div class="grid md:grid-cols-3 gap-6 xl:gap-12">
        @forelse($beritaTerbaru as $b)
            @php
            $thumb      = $b->thumbnail_path ? Storage::url($b->thumbnail_path) : asset('images/placeholder-16x9.png');
            $tgl        = optional($b->published_at)->translatedFormat('d M Y');
            $ringkas    = $b->ringkasan ?: '—';
            // Penulis (opsional): pakai relasi author() bila ada; kalau tidak, coba kolom 'penulis'; kalau tidak ada juga, null
            $authorName = (method_exists($b, 'author') ? optional($b->author)->name : null) ?? ($b->penulis ?? null);
            @endphp

            <article class="col-span-1 group duration-300 ease-in-out card-compact mx-auto md:mx-0 mt-7
                            outline outline-0 hover:outline-1 hover:outline-zinc-800 hover:outline-offset-2 p-4 bg-white ">
            <figure class="aspect-video w-full overflow-hidden">
                <a href="{{ route('guest.berita.show', $b->slug) }}">
                <img class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-[1.02]"
                    src="{{ $thumb }}" alt="{{ $b->judul }}">
                </a>
            </figure>

            <div class="mt-4">
                <div class="w-fit mb-1">
                <a href="{{ route('guest.berita.show', $b->slug) }}"
                    class="text-xl text-zinc-800 font-title relative leading-6
                            bg-gradient-to-r from-current to-current bg-[length:0%_2px] bg-left-bottom bg-no-repeat
                            transition-[background-size] duration-500 ease-in-out
                            group-hover:bg-[length:100%_1px] hover:text-zinc-500">
                    {{ $b->judul }}
                </a>
                </div>

                <p class="text-[12px] text-zinc-500">
                <span class="uppercase font-semibold">{{ $b->kategori ?? 'Kegiatan' }}</span>
                — <time datetime="{{ optional($b->published_at)?->format('Y-m-d') }}">{{ $tgl ?: '—' }}</time>
                @if($authorName) · <span>{{ $authorName }}</span> @endif
                </p>

                <p class="text-zinc-600 text-sm mt-2 line-clamp-2">{{ $ringkas }}</p>
            </div>
            </article>
        @empty
            <div class="col-span-3">
                <div class="p-6 rounded-lg border text-zinc-600">Belum ada kegiatan terbaru.</div>
            </div>
        @endforelse
        </div>

        <div class="w-full text-end mt-4">
        <a href="{{ route('guest.berita.index') }}"
            class="btn hover:bg-white border-2 bg-black text-white text-md hover:text-zinc-900">
            Lihat Semua Berita
        </a>
        </div>
    </div>
</div>
    <div class="mt-32 mb-16">
        <div class="grid lg:grid-cols-3 md:grid-cols-1 sm:grid-cols-1 gap-6 pt-24 md:pt-4 md:pl-5 "> 
            <div class="col-span-1 pb-1 w-full">
                <p class="lg:text-[50px] text-5xl font-title md:pl-5 text-start text-zinc-700">Artikel Terbitan</p>
            </div>
        </div>
        <ul class="list bg-base-100 px-6 mt-6" role="list">
            {{-- @dd($artikelTerbitan) --}}
            @forelse($artikelTerbitan as $idx => $a)
                @php
                $no = str_pad($idx + 1, 2, '0', STR_PAD_LEFT);
                $tgl = optional($a->published_at)->translatedFormat('d M Y');
                // penulis: pakai kolom teks terlebih dulu; kalau kosong, fallback relasi author
                $penulis = $a->penulis ?: optional($a->author)->name;
                $href = route('guest.artikel.show', $a->slug); // pastikan route ini ada
                @endphp

                <li class="border-b-2 border-b-zinc-200">
                <a href="{{ $href }}"
                    class="flex items-start gap-4 py-6 px-4 rounded-none hover:bg-zinc-100 focus:bg-zinc-100 focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500 transition">
                    <div class="text-4xl font-thin text-zinc-800/40 tabular-nums min-w-12 text-center">{{ $no }}</div>

                    <div class="flex-1">
                    <h3 class="text-lg font-semibold text-zinc-800 leading-snug">
                        {{ $a->judul }}
                    </h3>

                    <div class="text-xs uppercase font-semibold text-zinc-600 mt-0.5">
                        {{ $penulis ?: '—' }} — <time datetime="{{ optional($a->published_at)?->format('Y-m-d') }}">{{ $tgl ?: '—' }}</time>
                    </div>

                    @if(!empty($a->ringkasan))
                        <p class="text-sm text-zinc-600 mt-1">
                        {{ $a->ringkasan }}
                        </p>
                    @endif
                    </div>

                    <span class="inline-flex items-center justify-center btn btn-square btn-ghost" aria-hidden="true">
                    <svg class="size-[1.2em]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <g stroke-linejoin="round" stroke-linecap="round" stroke-width="2" fill="none" stroke="currentColor">
                        <path d="M6 3L20 12 6 21 6 3z"></path>
                        </g>
                    </svg>
                    </span>
                </a>
                </li>
                
            @empty
                
                <li class="p-6  border text-lg text-zinc-600">Belum ada artikel terbit.</li>
            @endforelse
            @if($artikelTerbitan->count() > 0)
                <div class="w-full text-end mt-8">
                    <a href="{{ route('guest.artikel.index') }}"
                        class="btn hover:bg-white border-2 bg-black text-white text-md hover:text-zinc-900">
                        Lihat Semua Artikel
                    </a>
                </div>
            @endif
        </ul>

        
    </div>

    {{-- ----------- Berita --------- --}}

</div>
{{-- ----------- Gallery --------- --}}
<div class="mb-12 sm:px-6 lg:px-36 mt-32 bg-zinc-900">
    <div class="grid lg:grid-cols-3 md:grid-cols-1 sm:grid-cols-1 gap-6 mb-3 pt-24 md:pt-12">

        <div class="col-span-1 px-6 pb-1 w-full md:mb-6">
            <p class="lg:text-[50px] text-5xl font-title md:pl-5 text-start text-zinc-200">Galeri <br> Pusat Studi</p>
        </div>

        @foreach($featuredAlbums as $album)
        <div class="col-span-1 group w-96 duration-300 ease-in-out card-compact mx-auto md:mx-0
                    outline outline-0 hover:outline-1 hover:outline-gray-200 hover:outline-offset-4 p-4">
            <figure>
                <a href="{{ route('galeri.albums.show', $album->slug) }}">
                    @if($album->cover_path)
                    <img
                        class="w-full h-[200px] object-cover ease-in-out"
                        src="{{ asset('storage/' . $album->cover_path) }}"
                        alt="{{ $album->judul }}" />
                    @else
                    <div class="w-full h-[200px] bg-gradient-to-br from-blue-50 to-purple-50 flex items-center justify-center">
                        <i class="fas fa-images text-gray-400 text-4xl"></i>
                    </div>
                    @endif
                </a>
            </figure>
            <div class="mt-4">
                <div class="w-fit mb-1">
                    <a href="{{ route('galeri.albums.show', $album->slug) }}" 
                        class="text-xl text-gray-200 font-title relative leading-4
                            bg-gradient-to-r from-current to-current bg-[length:0%_2px] bg-left-bottom bg-no-repeat
                            transition-[background-size] duration-500 ease-in-out
                            group-hover:bg-[length:100%_1px] hover:text-cyan-700">
                        {{ $album->judul }}
                    </a>
                    <p class="text-zinc-500 text-sm">
                        @if($album->published_at)
                            {{ $album->published_at->format('d/m/Y') }}
                        @else
                            {{ $album->created_at->format('d/m/Y') }}
                        @endif
                    </p>
                </div>
            </div>
        </div>
        @endforeach

    </div>
    <div class="text-end pb-12">
        <a href="{{ route('galeri.albums.index') }}" class="w-2/3 btn rounded-none hover:bg-zinc-100 border bg-zinc-900 text-zinc-100 text-md hover:text-zinc-900 relative leading-4
        bg-gradient-to-r from-current to-current bg-[length:0%_2px] bg-left-bottom bg-no-repeat
        transition-[background-size] duration-500 ease-in-out
        group-hover:bg-[length:100%_1px]">Lihat Galeri</a>
    </div>
</div>

<section id="kontak" class="py-20 mt-32 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-start mb-16">
            <h2 id="contact-title" class="font-title text-5xl text-zinc-900 mb-3">Kontak &amp; Kolaborasi</h2>
            <p class="text-lg text-gray-700 max-w-3xl">Hubungi kami untuk kemitraan penelitian, konsultasi, atau informasi lebih lanjut</p>
        </div>
        <div class="grid md:grid-cols-2 gap-12">
            <div>
            <h3 class="font-playfair text-2xl font-title text-zinc-900 mb-6">Informasi Kontak</h3>
            <div class="space-y-6">
            <div class="flex items-start space-x-4"><i class="fas fa-map-marker-alt text-xl text-blue-600 mt-1"></i>
            <div>
                <h4 class="font-semibold mb-1">Alamat</h4>
                <p class="text-gray-600">Gedung LPPM Universitas Negeri Gorontalo
                    Jl. Jend. Sudirman, Wumialo, Kec. Kota Tengah, Kota Gorontalo, Gorontalo 96138
                </p>
            </div>
            </div>
            <div class="flex items-start space-x-4"><i class="fas fa-phone text-xl text-blue-600 mt-1"></i>
            <div>
                <h4 class="font-semibold mb-1">Telepon</h4>
                <p class="text-gray-600">+62 852 5656 6817</p>
            </div>
            </div>
            <div class="flex items-start space-x-4"><i class="fas fa-envelope text-xl text-blue-600 mt-1"></i>
            <div>
                <h4 class="font-semibold mb-1">Email</h4>
                <p class="text-gray-600">info@psplsd.ui.ac.id</p>
            </div>
            </div>
            <div class="flex items-start space-x-4"><i class="fas fa-globe text-xl text-blue-600 mt-1"></i>
            {{-- <div>
                <h4 class="font-semibold mb-1">Website</h4>
                <p class="text-gray-600">www.psplsd.ui.ac.id</p>
            </div> --}}
            </div>
            </div>
            <div class="mt-8 p-6 bg-zinc-800 ">
            <h4 class="font-semibold text-zinc-100 mb-3">Jam Operasional</h4>
            <div class="text-sm text-slate-100 space-y-1">
            <div class="flex justify-between"><span>Senin - Jumat</span> <span>08:00 - 17:00 WIB</span>
            </div>
            <div class="flex justify-between"><span>Sabtu & Minggu</span> <span>Tutup</span>
            </div>
            {{-- <div class="flex justify-between"><span>Minggu</span> <span>Tutup</span>
            </div> --}}
            </div>
            </div>
            </div>
                <div id="collaboration-form-container">
                    <h3 class="font-playfair text-2xl font-title text-zinc-800 mb-6">Formulir Kolaborasi</h3>
                    
                    <form id="collaborationForm" class="space-y-6">
                        @csrf
                        
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap *</label>
                            <input type="text" id="name" name="name" required 
                                class="w-full px-4 py-3 border border-gray-300  focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                        
                        <div>
                            <label for="institution" class="block text-sm font-medium text-gray-700 mb-2">Institusi *</label>
                            <input type="text" id="institution" name="institution" required
                                class="w-full px-4 py-3 border border-gray-300  focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                        
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email *</label>
                            <input type="email" id="email" name="email" required
                                class="w-full px-4 py-3 border border-gray-300  focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                        
                        <div>
                            <label for="collaboration_type" class="block text-sm font-medium text-gray-700 mb-2">Jenis Kolaborasi *</label>
                            <select id="collaboration_type" name="collaboration_type" required
                                    class="w-full px-4 py-3 border border-gray-300  focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="">Pilih Jenis Kolaborasi</option>
                                <option value="Penelitian Bersama">Penelitian Bersama</option>
                                <option value="Konsultasi Akademik">Konsultasi Akademik</option>
                                <option value="Kemitraan Industri">Kemitraan Industri</option>
                                <option value="Program Magang">Program Magang</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>
                        </div>
                        
                        <div>
                            <label for="message" class="block text-sm font-medium text-gray-700 mb-2">Pesan *</label>
                            <textarea id="message" name="message" rows="4" required
                                    class="w-full px-4 py-3 border border-gray-300  focus:ring-2 focus:ring-blue-500 focus:border-transparent"></textarea>
                        </div>
                        
                        <!-- Response Message -->
                        <div id="responseMessage" class="hidden p-4 "></div>
                        
                        <button type="submit" id="submitBtn" 
                                class="w-full bg-zinc-800 hover:bg-zinc-700 text-white py-3 px-4  font-semibold transition-colors">
                            Kirim Proposal Kolaborasi
                        </button>
                    </form>
                </div>

            <script>
            
            document.addEventListener('DOMContentLoaded', function() {
                const form = document.getElementById('collaborationForm');
                const submitBtn = document.getElementById('submitBtn');
                const responseDiv = document.getElementById('responseMessage');
                
                form.addEventListener('submit', async function(e) {
                    e.preventDefault();
                    
                    // Disable button dan tampilkan loading
                    const originalText = submitBtn.textContent;
                    submitBtn.disabled = true;
                    submitBtn.textContent = 'Mengirim...';
                    submitBtn.classList.add('opacity-50');
                    
                    // Sembunyikan pesan sebelumnya
                    responseDiv.classList.add('hidden');
                    
                    // Kumpulkan data form
                    const formData = new FormData(form);
                    const data = Object.fromEntries(formData.entries());
                    
                    try {
                        // Kirim request ke server
                        const response = await fetch('{{ route("collaboration.submit") }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                            },
                            body: JSON.stringify(data)
                        });
                        
                        const result = await response.json();
                        
                        // Tampilkan pesan response
                        if (response.ok && result.success) {
                            responseDiv.className = 'p-4 bg-green-100 text-green-700 border border-green-300 rounded-lg';
                            responseDiv.textContent = '✅ ' + result.message;
                            form.reset(); // Reset form
                        } else {
                            responseDiv.className = 'p-4 bg-red-100 text-red-700 border border-red-300 rounded-lg';
                            responseDiv.textContent = '❌ ' + (result.message || 'Terjadi kesalahan. Silakan coba lagi.');
                        }
                        
                        responseDiv.classList.remove('hidden');
                        
                    } catch (error) {
                        responseDiv.className = 'p-4 bg-red-100 text-red-700 border border-red-300 rounded-lg';
                        responseDiv.textContent = '❌ Koneksi error. Silakan coba lagi.';
                        responseDiv.classList.remove('hidden');
                        console.error('Error:', error);
                    } finally {
                        // Reset button
                        submitBtn.disabled = false;
                        submitBtn.textContent = originalText;
                        submitBtn.classList.remove('opacity-50');
                    }
                });
            });
            </script>

            {{-- <script>
            document.getElementById('collaborationForm').addEventListener('submit', async function(e) {
                e.preventDefault();
                
                const submitBtn = document.getElementById('submitBtn');
                const originalText = submitBtn.textContent;
                const responseDiv = document.getElementById('responseMessage');
                
                // Disable button dan tampilkan loading
                submitBtn.disabled = true;
                submitBtn.textContent = 'Mengirim...';
                responseDiv.classList.add('hidden');
                
                try {
                    const formData = new FormData(this);
                    
                    const response = await fetch('{{ route("collaboration.submit") }}', {
                        method: 'POST',
                        headers: {
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                        },
                        body: formData
                    });
                    
                    const data = await response.json();
                    
                    if (response.ok) {
                        // Tampilkan pesan sukses
                        responseDiv.className = 'p-4 mb-4 text-green-700 bg-green-100 border border-green-300';
                        responseDiv.textContent = data.message;
                        responseDiv.classList.remove('hidden');
                        
                        // Reset form
                        this.reset();
                    } else {
                        // Tampilkan error
                        responseDiv.className = 'p-4 mb-4 text-red-700 bg-red-100 border border-red-300';
                        responseDiv.textContent = data.message || 'Terjadi kesalahan. Silakan coba lagi.';
                        responseDiv.classList.remove('hidden');
                    }
                } catch (error) {
                    responseDiv.className = 'p-4 mb-4 text-red-700 bg-red-100 border border-red-300';
                    responseDiv.textContent = 'Koneksi error. Silakan coba lagi.';
                    responseDiv.classList.remove('hidden');
                    console.error('Error:', error);
                } finally {
                    // Reset button
                    submitBtn.disabled = false;
                    submitBtn.textContent = originalText;
                }
            });
            </script> --}}
        </div>
    </div>
</section>

{{-- Kontak Kami --}}
{{-- <div class="container mx-auto sm:px-6 lg:px-36 mt-6 mb-20">
    <div class=" gap-10 items-start hover:outline-1">
        {{-- Form --}}
        {{-- <div class="bg-white p-8 rounded-lg shadow-sm outline outline-0 grouphover:outline-1 hover:outline-zinc-100 transition-all">
            <p class="text-5xl font-title text-zinc-800 mb-4">Kontak Kami</p>
            <p class="text-zinc-500 mb-6">Isi form untuk kolaborasi.</p>

            <form action="" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label for="name" class="block text-sm text-zinc-700 mb-1">Nama</label>
                    <input id="name" name="name" type="text" required
                        class="w-full px-4 py-3 border border-zinc-200 rounded-md focus:outline-none focus:ring-2 focus:ring-cyan-200"
                        placeholder="Nama lengkap" />
                </div>

                <div>
                    <label for="email" class="block text-sm text-zinc-700 mb-1">Email</label>
                    <input id="email" name="email" type="email" required
                        class="w-full px-4 py-3 border border-zinc-200 rounded-md focus:outline-none focus:ring-2 focus:ring-cyan-200"
                        placeholder="email@domain.com" />
                </div>

                <div>
                    <label for="message" class="block text-sm text-zinc-700 mb-1">Pesan</label>
                    <textarea id="message" name="message" rows="5" required
                        class="w-full px-4 py-3 border border-zinc-200 rounded-md focus:outline-none focus:ring-2 focus:ring-cyan-200"
                        placeholder="Tulis pesan Anda di sini..."></textarea>
                </div>

                <div class="text-right">
                    <button type="submit"
                        class="btn inline-flex items-center justify-center px-6 py-3 bg-black text-white border-2 border-black rounded-md hover:bg-white hover:text-zinc-900 transition-colors duration-300">
                        Kirim Pesan
                    </button>
                </div>
            </form>
        </div> --}}

        {{-- Kontak, Alamat & Sosial --}}
        {{-- <div class="bg-zinc-50 p-8 rounded-lg">
            <p class="text-2xl font-title text-zinc-800 mb-4">Informasi</p>

            <div class="text-zinc-700 mb-6 space-y-3">
                <div>
                    <p class="font-semibold">Alamat</p>
                    <p class="text-sm">Universitas Negeri Gorontalo, Gorontalo, Indonesia</p>
                </div>
                <div>
                    <p class="font-semibold">Email</p>
                    <a href="mailto:info@example.com" class="text-sm text-cyan-800 hover:underline">info@unigo.ac.id</a>
                </div>
                <div>
                    <p class="font-semibold">Telepon</p>
                    <a href="tel:+628123456789" class="text-sm text-cyan-800 hover:underline">+62 812 3456 789</a>
                </div>
            </div>

            <div class="border-t border-zinc-200 pt-6">
                <p class="text-sm text-zinc-600 mb-3">Ikuti kami</p>
                <div class="flex items-center gap-4">
                    <a href="#" aria-label="Facebook" class="text-zinc-700 hover:text-cyan-700 transition-colors">
                        <svg class="w-6 h-6" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                            <path d="M22 12.07C22 6.48 17.52 2 11.93 2S2 6.48 2 12.07c0 4.99 3.66 9.12 8.44 9.96v-7.05H8.08v-2.91h2.36V9.14c0-2.33 1.38-3.61 3.5-3.61.99 0 2.02.18 2.02.18v2.22h-1.14c-1.12 0-1.47.7-1.47 1.42v1.69h2.5l-.4 2.91h-2.1v7.05C18.34 21.19 22 17.06 22 12.07z"/>
                        </svg>
                    </a>

                    <a href="#" aria-label="Instagram" class="text-zinc-700 hover:text-cyan-700 transition-colors">
                        <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <rect x="3" y="3" width="18" height="18" rx="5"></rect>
                            <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path>
                            <line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line>
                        </svg>
                    </a>

                    <a href="#" aria-label="Twitter" class="text-zinc-700 hover:text-cyan-700 transition-colors">
                        <svg class="w-6 h-6" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                            <path d="M22 5.92c-.64.29-1.32.49-2.04.58.73-.44 1.29-1.14 1.55-1.97-.68.4-1.44.69-2.25.85C18.95 4.6 18 4 17 4c-1.66 0-3 1.34-3 3 0 .24.03.47.08.69C10.69 7.53 7.13 5.5 4.98 2.61c-.26.44-.41.95-.41 1.5 0 1.03.52 1.94 1.31 2.47-.48-.02-.93-.15-1.33-.36v.04c0 1.45 1.03 2.66 2.4 2.93-.25.07-.51.1-.78.1-.19 0-.38-.02-.56-.06.38 1.18 1.48 2.04 2.79 2.06C6.1 16.4 4.57 16.97 2.94 16.97c-.19 0-.37-.01-.55-.03C2.94 18.8 4.71 20 6.8 20c7.69 0 11.9-6.37 11.9-11.9v-.54c.82-.59 1.53-1.33 2.09-2.17-.75.33-1.56.55-2.41.65z"/>
                        </svg>
                    </a>

                    <a href="#" aria-label="YouTube" class="text-zinc-700 hover:text-cyan-700 transition-colors">
                        <svg class="w-6 h-6" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                            <path d="M10 15l5.2-3L10 9v6z"></path>
                            <path d="M23.5 6.2s-.2-1.6-.8-2.3c-.8-1-1.7-1-2.1-1.1C16.6 2.5 12 2.5 12 2.5h0s-4.6 0-8.6.3c-.4.1-1.3.1-2.1 1.1-.6.7-.8 2.3-.8 2.3S0 8 0 9.9v2.3C0 14 0.2 15.6.2 15.6s.2 1.6.8 2.3c.8 1 1.9 1 2.4 1.1 1.8.1 7.6.3 7.6.3s4.6 0 8.6-.3c.4-.1 1.3-.1 2.1-1.1.6-.7.8-2.3.8-2.3s.2-1.6.2-3.4V9.9c0-1.9-.2-3.7-.2-3.7z"></path>
                        </svg>
                    </a>
                </div>
            </div>
        </div> --}}
    {{-- </div>
</div> --}}
    {{-- <div class="container mx-auto  sm:px-6 lg:px-36 mt-6 mb-15">
        <div class="mb-15">
            <div class="px-6 py-2 border-blue-200 w-fit mb-4 hover:bg-blue-200 transition-colors duration-200 cursor-pointer">
                <p class="text-4xl font-bold text-start">Berita Terbaru</p>
            </div>
            <p class="text-gray-500 text-center">Belum ada berita</p>
            {{-- <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div class="bg-white p-4">
                    <img src="https://images.pexels.com/photos/1391495/pexels-photo-1391498.jpeg?auto=compress&cs=tinysrgb&w=1920" alt="News Image 1" class="w-full h-48 object-cover rounded-t-lg">
                    <h3 class="mt-2 text-xl font-semibold">Judul Berita 1</h3>
                    <p class="mt-1">Deskripsi singkat berita 1.</p>
                </div>
                <div class="bg-white p-4">
                    <img src="https://images.pexels.com/photos/159866/books-book-pages-read-literature-159866.jpeg?auto=compress&cs=tinysrgb&w=1920" alt="News Image 2" class="w-full h-48 object-cover rounded-t-lg">
                    <h3 class="mt-2 text-xl font-semibold">Judul Berita 2</h3>
                    <p class="mt-1">Deskripsi singkat berita 2.</p>
                </div>
                <div class="bg-white p-4">
                    <img src="https://cdn.pixabay.com/photo/2018/03/10/12/00/paper-3213924_1280.jpg" alt="News Image 3" class="w-full h-48 object-cover rounded-t-lg">
                    <h3 class="mt-2 text-xl font-semibold">Judul Berita 3</h3>
                    <p class="mt-1">Deskripsi singkat berita 3.</p>
                </div>
            </div> --}}
        {{-- </div> --}}
    {{-- </div> --}} 
        

    {{-- Berita --}}
    
    
    {{-- Gallery --}}
    {{-- <div class="mb-15">
        <div class="px-6 py-2 border-4 border-blue-200 w-full mb-4">
            <p class="text-4xl font-bold text-center">Galeri</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <div class="bg-white p-4 rounded-lg shadow">
                <img src="https://images.pexels.com/photos/1391495/pexels-photo-1391498.jpeg?auto=compress&cs=tinysrgb&w=1920" alt="Gallery Image 1" class="w-full h-48 object-cover rounded-t-lg">
                <p class="mt-2 text-center">Foto Kegiatan 1</p>
            </div>
            <div class="bg-white p-4 rounded-lg shadow">
                <img src="https://images.pexels.com/photos/159866/books-book-pages-read-literature-159866.jpeg?auto=compress&cs=tinysrgb&w=1920" alt="Gallery Image 2" class="w-full h-48 object-cover rounded-t-lg">
                <p class="mt-2 text-center">Foto Kegiatan 2</p>
            </div>
            <div class="bg-white p-4 rounded-lg shadow">
                <img src="https://cdn.pixabay.com/photo/2018/03/10/12/00/paper-3213924_1280.jpg" alt="Gallery Image 3" class="w-full h-48 object-cover rounded-t-lg">
                <p class="mt-2 text-center">Foto Kegiatan 3</p>
            </div>
        </div>
    </div> --}}
{{-- </div> --}}

@endsection




