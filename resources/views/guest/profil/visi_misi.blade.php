@extends('layout-web.app')
@section('title', 'Visi Misi')
@section('judul_halaman', 'Visi Misi')

@section('content')
<div class="mb-20">
    {{-- VISI --}}
    <div class="mb-2 mt-8">
        <div class="grid lg:grid-cols-3 md:grid-cols-1 sm:grid-cols-1 gap-6 mb-6 md:pt-12">
            <div class="col-span-1 px-6 pb-1 w-full md:mb-6">
                <p class="lg:text-4xl text-5xl font-title text-start text-gray-900">Visi</p>
            </div>
            <div class="col-span-2 px-6 pb-6">
                <p class="mb-1 text-lg text-gray-900 font-body leading-6.5 text-justify">
                    {{ $visimisi->visi ?? '—' }}
                </p>
            </div>
        </div>

        {{-- MISI --}}
        <div class="grid lg:grid-cols-3 md:grid-cols-1 sm:grid-cols-1 gap-6 mb-6 md:pt-2">
            <div class="col-span-1 px-6 pb-1 w-full md:mb-6">
                <p class="lg:text-4xl text-5xl font-title text-start text-gray-900">Misi</p>
            </div>
            <div class="col-span-2 px-6 pb-6">
                @php
                    // pastikan misi berupa array (kalau null/empty, jadikan array kosong)
                    $misi = is_array($visimisi->misi ?? null) ? $visimisi->misi : [];
                @endphp

                @if(count($misi))
                    <ul class="list-disc mb-6 text-lg font-body text-gray-900">
                        @foreach($misi as $item)
                            <li class="mb-3 leading-6.5">{{ $item }}</li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-lg text-gray-600">— Belum ada misi yang ditambahkan.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
