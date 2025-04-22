<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">Edit Portofolio</h3>
                    <form action="{{ route('portofolio.update', $portofolio->id_portofolio) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        {{-- Nama Portofolio --}}
                        <div class="mb-4">
                            <label for="nama_portofolio" class="block text-sm font-medium text-gray-700">Nama
                                Portofolio</label>
                            <input type="text" name="nama_portofolio" id="nama_portofolio"
                                value="{{ $portofolio->nama_portofolio }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                required>
                        </div>

                        {{-- Deskripsi --}}
                        <div class="mb-4">
                            <label for="deskripsi_portofolio"
                                class="block text-sm font-medium text-gray-700">Deskripsi</label>
                            <textarea name="deskripsi_portofolio" id="deskripsi_portofolio" rows="4"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                required>{{ $portofolio->deskripsi_portofolio }}</textarea>
                        </div>

                        {{-- Gambar --}}
                        <div class="mb-4">
                            <label for="gambar_portofolio" class="block text-sm font-medium text-gray-700">Gambar
                                Portofolio</label>
                            <input type="file" name="gambar_portofolio[]" id="gambar_portofolio"
                                class="mt-1 block w-full" multiple>
                            <p class="text-sm text-gray-500 mt-1">Kosongkan jika tidak ingin mengganti gambar.</p>
                        </div>

                        {{-- Tautan --}}
                        <div class="mb-4">
                            <label for="tautan_portofolio" class="block text-sm font-medium text-gray-700">Tautan
                                Portofolio</label>
                            <input type="url" name="tautan_portofolio" id="tautan_portofolio"
                                value="{{ $portofolio->tautan_portofolio }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                required>
                        </div>

                        {{-- Kategori --}}
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Kategori</label>
                            <div class="grid grid-cols-2 gap-2">
                                @foreach ($semuaKategori as $kategori)
                                    <label class="flex items-center space-x-3">
                                        <input type="checkbox" name="kategori_portofolio[]" value="{{ $kategori }}"
                                            {{ $portofolio->kategoris->pluck('kategori_portofolio')->contains($kategori) ? 'checked' : '' }}
                                            class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                                        <span class="ml-3">{{ $kategori }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                        
                        {{-- Tag Pengguna --}}
                        <div class="mb-4">
                            <label for="user_tags" class="block text-sm font-medium text-gray-700">Tag Pengguna</label>
                            <input type="text" name="user_tags" id="user_tags"
                                value="{{ $portofolio->taggedUsers->pluck('nama_pengguna')->map(fn($name) => '@' . $name)->join(', ') }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            <p class="text-sm text-gray-500 mt-1">Pisahkan dengan koma, misalnya: @user1, @user2</p>
                        </div>

                        <button type="submit" class="px-4 py-2 bg-blue-500 text-black rounded hover:bg-blue-600">Simpan
                            Perubahan</button>
                        <a href="{{ route('portofolio.show', $portofolio->id_portofolio) }}"
                            class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">Batal</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
