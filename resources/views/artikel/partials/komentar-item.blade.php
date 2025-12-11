{{-- Item Komentar --}}
<div class="komentar-item {{ $level > 0 ? 'ml-8 pl-4 border-l-2 border-zinc-200' : '' }}" 
     id="komentar-{{ $komentar->id }}">
    
    <div class="bg-white border border-zinc-100 p-4 hover:border-zinc-200 transition-colors">
        <div class="flex">
            {{-- Avatar --}}
            <div class="flex-shrink-0 mr-4">
                <div class="h-10 w-10 rounded-full {{ $komentar->user ? 'bg-blue-100 text-blue-600' : 'bg-zinc-100 text-zinc-600' }} flex items-center justify-center font-semibold text-sm">
                    {{ strtoupper(substr($komentar->nama_komentar, 0, 1)) }}
                </div>
            </div>

            {{-- Konten --}}
            <div class="flex-grow">
                {{-- Header --}}
                <div class="flex justify-between items-start mb-2">
                    <div>
                        <h5 class="font-semibold text-zinc-800">
                            {{ $komentar->nama_komentar }}
                            @if($komentar->user)
                                <span class="ml-2 px-2 py-0.5 bg-blue-100 text-blue-700 text-xs rounded-full">Admin</span>
                            @endif
                            {{-- @if($komentar->user && $komentar->user->)
                                <span class="ml-2 px-2 py-0.5 bg-blue-100 text-blue-700 text-xs rounded-full">Admin</span>
                            @endif
                            @if($komentar->user && $komentar->user->is_user)
                                <span class="ml-2 px-2 py-0.5 bg-blue-100 text-blue-700 text-xs rounded-full">Admin</span>
                            @endif --}}
                        </h5>
                        <p class="text-sm text-zinc-500">
                            <time datetime="{{ $komentar->created_at->format('Y-m-d\TH:i:s') }}">
                                {{ $komentar->tanggal_lengkap }}
                            </time>
                        </p>
                    </div>
                    
                    {{-- Action Buttons --}}
                    @auth
                        @php
                            $canEdit = $komentar->canBeEditedBy(auth()->user());
                            $canDelete = $komentar->canBeDeletedBy(auth()->user());
                        @endphp
                        
                        @if($canEdit || $canDelete)
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" 
                                    class="p-1 text-zinc-400 hover:text-zinc-600 rounded hover:bg-zinc-100">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"/>
                                </svg>
                            </button>
                            
                            <div x-show="open" 
                                 @click.away="open = false"
                                 x-transition:enter="transition ease-out duration-100"
                                 x-transition:enter-start="transform opacity-0 scale-95"
                                 x-transition:enter-end="transform opacity-100 scale-100"
                                 x-transition:leave="transition ease-in duration-75"
                                 x-transition:leave-start="transform opacity-100 scale-100"
                                 x-transition:leave-end="transform opacity-0 scale-95"
                                 class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg z-10 border border-zinc-200">
                                <div class="py-1">
                                    {{-- Reply Button --}}
                                    <button @click="showReplyForm({{ $komentar->id }}); open = false" 
                                            class="flex items-center w-full px-4 py-2 text-sm text-zinc-700 hover:bg-zinc-100">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/>
                                        </svg>
                                        Balas
                                    </button>
                                    
                                    {{-- Edit Button --}}
                                    @if($canEdit)
                                    <a href="{{ route('komentar.edit', ['artikel' => $artikel->slug, 'komentar' => $komentar]) }}" 
                                       class="flex items-center w-full px-4 py-2 text-sm text-amber-700 hover:bg-amber-50">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                        Edit
                                    </a>
                                    @endif
                                    
                                    {{-- Delete Button --}}
                                    @if($canDelete)
                                    <form action="{{ route('komentar.destroy', ['artikel' => $artikel->slug, 'komentar' => $komentar]) }}" 
                                          method="POST"
                                          onsubmit="return confirm('Hapus komentar ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="flex items-center w-full px-4 py-2 text-sm text-red-700 hover:bg-red-50">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                            Hapus
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endif
                    @endauth
                </div>

                {{-- Isi Komentar --}}
                <div class="mb-2">
                    <p class="text-zinc-700 whitespace-pre-line">{{ $komentar->konten }}</p>
                </div>

                {{-- Reply Form --}}
                @auth
                <div id="reply-form-{{ $komentar->id }}" class="hidden mb-4">
                    <form action="{{ route('komentar.reply', ['artikel' => $artikel->slug, 'komentar' => $komentar]) }}" 
                          method="POST">
                        @csrf
                        <div class="mb-2">
                            <textarea name="konten" 
                                      rows="3" 
                                      placeholder="Tulis balasan Anda..."
                                      class="w-full px-3 py-2 border border-zinc-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                      required></textarea>
                        </div>
                        <div class="flex justify-end space-x-2">
                            <button type="button" 
                                    onclick="hideReplyForm({{ $komentar->id }})"
                                    class="px-4 py-2 text-sm border border-zinc-300 rounded-md hover:bg-zinc-50">
                                Batal
                            </button>
                            <button type="submit" 
                                    class="px-4 py-2 text-sm bg-blue-600 text-white rounded-md hover:bg-blue-700">
                                Kirim Balasan
                            </button>
                        </div>
                    </form>
                </div>
                @endauth
            </div>
        </div>
    </div>

    {{-- Replies --}}
    @if($komentar->approvedReplies->count() > 0)
        <div class="mt-4 space-y-4">
            @foreach($komentar->approvedReplies as $reply)
                @include('artikel.partials.komentar-item', ['komentar' => $reply, 'level' => $level + 1])
            @endforeach
        </div>
    @endif
</div>