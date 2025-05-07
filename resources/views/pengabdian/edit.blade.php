<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Pengabdian') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('pengabdian.update', $pengabdian->id_pengabdian) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $salah)
                                        <li>{{ $salah }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if (Session::has('error'))
                            {{ Session::get('error') }}
                        @endif

                        {{-- Nama Pengabdian --}}
                        <div class="mb-4">
                            <label for="judul_pengabdian" class="block text-sm font-medium text-gray-700">Judul
                                Pengabdian</label>
                            <input type="text" name="judul_pengabdian" id="judul_pengabdian"
                                value="{{ $pengabdian->judul_pengabdian }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                required>
                        </div>

                        {{-- Deskripsi --}}
                        <div class="mb-4">
                            <label for="deskripsi_pengabdian"
                                class="block text-sm font-medium text-gray-700">Deskripsi</label>
                            <textarea name="deskripsi_pengabdian" id="deskripsi_pengabdian" rows="4"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                required>{{ $pengabdian->deskripsi_pengabdian }}</textarea>
                        </div>

                        {{-- Tanggal Pengabdian --}}
                        <div class="mb-4">
                            <label for="tanggal_pengabdian" class="block text-sm font-medium text-gray-700">Tanggal
                                pengabdian</label>
                            <input type="date" name="tanggal_pengabdian" id="tanggal_pengabdian"
                                value="{{ $pengabdian->tanggal_pengabdian }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                required>
                        </div>

                        {{-- Pelaksana --}}
                        <div class="mb-4">
                            <label for="pelaksana" class="block text-sm font-medium text-gray-700">Pelaksana
                                Pengabdian</label>
                            <input type="text" name="pelaksana" id="pelaksana" value="{{ $pengabdian->pelaksana }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                required>
                        </div>

                        {{-- Dokumentasi Pengabdian --}}
                        <div class="mb-4">
                            <label for="dokumentasi_pengabdian"
                                class="block text-sm font-medium text-gray-700">Dokumentasi Pengabdian</label>

                            {{-- Dokumentasi yang Sudah Ada --}}
                            @if ($pengabdian->dokumentasi->isNotEmpty())
                                <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                                    @foreach ($pengabdian->dokumentasi as $dokumentasi)
                                        <div class="relative group border rounded p-2">
                                            <img src="{{ asset('storage/' . $dokumentasi->dokumentasi_pengabdian) }}"
                                                alt="Dokumentasi Pengabdian" class="w-full h-32 object-cover rounded">
                                            <div class="mt-2 flex justify-end">
                                                <button type="button"
                                                    class="px-3 py-1 bg-red-500 text-black text-xs rounded hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50"
                                                    onclick="removeExistingDokumentasi(this, '{{ $dokumentasi->id_dokumentasi }}')">
                                                    Remove
                                                </button>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif

                            {{-- Input untuk Menambahkan Dokumentasi Baru --}}
                            <div id="gambar-container" class="mt-4">
                                <div class="flex items-center mb-2">
                                    <input type="file" name="dokumentasi_pengabdian[]"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                        accept="image/*">
                                    <button type="button"
                                        class="ml-2 px-3 py-1 bg-green-500 text-black rounded hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-opacity-50"
                                        onclick="addDokumentasi()">Add</button>
                                </div>
                            </div>
                            <p class="text-xs text-gray-500 mt-1">Unggah gambar (JPG, PNG, GIF). Maksimal 2MB per
                                gambar.</p>
                        </div>

                        {{-- Tag Pengguna --}}
                        <div class="form-group mb-4">
                            <label for="user_tags" class="block text-sm font-medium text-gray-700">Tag Pengguna</label>
                            <p class="text-xs text-gray-500 mb-1">Tag pengguna lain (pisahkan dengan koma), misal @nama1
                            </p>
                            <input type="text" name="user_tags" id="user_tags"
                                value="{{ $pengabdian->taggedUsers->pluck('nama_pengguna')->map(fn($name) => '@' . $name)->join(', ') }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        </div>

                        <button type="submit"
                            class="px-4 py-2 bg-blue-500 text-black rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
                            Simpan Perubahan
                        </button>

                        {{-- Tombol Kembali --}}
                        <a href="{{ route('pengabdian.show', $pengabdian->id_pengabdian) }}"
                            class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">Batal</a>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function addDokumentasi() {
            const container = document.getElementById('gambar-container');
            const newRow = document.createElement('div');
            newRow.classList.add('flex', 'items-center', 'mb-2');
            newRow.innerHTML = `
        <input type="file" name="dokumentasi_pengabdian[]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
            accept="image/*">
        <button type="button" class="ml-2 px-3 py-1 bg-red-500 text-black rounded hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50"
            onclick="removeGambar(this)">Remove</button>
    `;
            container.appendChild(newRow);
        }

        function removeGambar(button) {
            const row = button.parentElement;
            row.remove();
        }

        function removeExistingDokumentasi(button, idDokumentasi) {
            if (confirm('Apakah Anda yakin ingin menghapus dokumentasi ini?')) {
                // Tambahkan input hidden untuk menandai dokumentasi yang akan dihapus
                const form = button.closest('form');
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'hapus_dokumentasi[]';
                input.value = idDokumentasi;
                form.appendChild(input);

                // Hapus elemen dari tampilan
                const container = button.closest('.relative');
                container.remove();
            }
        }
    </script>
</x-app-layout>
