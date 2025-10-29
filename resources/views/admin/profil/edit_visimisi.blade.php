<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Menu Profil') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 ">
            <div class="overflow-hidden group shadow-sm sm:rounded-lg hover:shadow-md transition-shadow bg-white p-6">
                <div class="flex items-center justify-between mb-4">
                    <p class="font-semibold text-zinc-900 text-lg">Edit Visi & Misi</p>
                    <a href="{{ route('admin.profil') }}" class="text-sm text-gray-500 hover:underline">Batal</a>
                </div>

                @if(session('success'))
                    <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
                        {{ session('success') }}
                    </div>
            @endif

                @if ($errors->any())
                    <div class="mb-4 p-3 bg-red-100 text-red-800 rounded">
                        <ul class="list-disc pl-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('visimisi.update', $visimisi->id ?? '') }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div>
                        <label for="visi" class="block text-sm font-medium text-gray-700">Visi</label>
                        <div class="mt-1">
                            <textarea id="visi" name="visi" rows="4" class="block text-gray-700 w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">{{ old('visi', $visimisi->visi ?? '') }}</textarea>
                        </div>
                        @error('visi')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="misi" class="block text-sm font-medium text-gray-700">Misi
                            <span class="text-xs text-gray-500"> (pisahkan tiap misi dengan baris baru)</span>
                        </label>
                        <div class="mt-1">
                            <textarea id="misi" name="misi" rows="6" class="block text-gray-700 w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">{{ old('misi', is_array($visimisi->misi ?? null) ? implode("\n", $visimisi->misi) : ($visimisi->misi ?? '')) }}</textarea>
                        </div>
                        @error('misi')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center justify-end">
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
