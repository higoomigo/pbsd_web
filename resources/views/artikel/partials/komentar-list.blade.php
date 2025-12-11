{{-- Daftar Komentar --}}
<div class="mb-2">
    @if($artikel->hasKomentar())
        <div class="space-y-2">
            @foreach($artikel->komentarApproved as $komentar)
                @include('artikel.partials.komentar-item', ['komentar' => $komentar, 'level' => 0])
            @endforeach
        </div>
    @else
        <div class="text-center py-12">
            <svg class="w-16 h-16 mx-auto text-zinc-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
            </svg>
            <h4 class="text-lg font-medium text-zinc-500 mb-2">Belum ada komentar</h4>
            <p class="text-zinc-400">Jadilah yang pertama berkomentar!</p>
        </div>
    @endif
</div>