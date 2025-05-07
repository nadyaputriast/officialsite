<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Prestasi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('prestasi.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
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

                        {{-- Nama Prestasi --}}
                        <div class="mb-4">
                            <label for="nama_prestasi" class="block text-sm font-medium text-gray-700">Nama
                                Prestasi</label>
                            <input type="text" name="nama_prestasi" id="nama_prestasi"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                required>
                        </div>

                        {{-- Deskripsi --}}
                        <div class="mb-4">
                            <label for="deskripsi_prestasi"
                                class="block text-sm font-medium text-gray-700">Deskripsi</label>
                            <textarea name="deskripsi_prestasi" id="deskripsi_prestasi" rows="4"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                required></textarea>
                        </div>

                        {{-- Tanggal Perolehan --}}
                        <div class="mb-4">
                            <label for="tanggal_perolehan" class="block text-sm font-medium text-gray-700">Tanggal
                                Perolehan</label>
                            <input type="date" name="tanggal_perolehan" id="tanggal_perolehan"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                required>
                        </div>

                        {{-- Tingkatan Prestasi --}}
                        <div class="mb-4">
                            <label for="tingkatan_prestasi" class="block text-sm font-medium text-gray-700">Tingkatan
                                Prestasi</label>
                            <select name="tingkatan_prestasi" id="tingkatan_prestasi"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                required>
                                <option value="" disabled selected>Pilih Tingkatan Prestasi</option>
                                <option value="Regional">Regional</option>
                                <option value="Nasional">Nasional</option>
                                <option value="Internasional">Internasional</option>
                            </select>
                        </div>

                        {{-- Jenis Prestasi --}}
                        <div class="mb-4">
                            <label for="jenis_prestasi" class="block text-sm font-medium text-gray-700">Jenis
                                Prestasi</label>
                            <select name="jenis_prestasi" id="jenis_prestasi"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                required>
                                <option value="" disabled selected>Pilih Jenis Prestasi</option>
                                <option value="Akademik">Akademik</option>
                                <option value="Non Akademik">Non Akademik</option>
                            </select>
                        </div>

                        {{-- Dokumentasi Prestasi --}}
                        <div class="mb-4">
                            <label for="dokumentasi_prestasi"
                                class="block text-sm font-medium text-gray-700">Dokumentasi Prestasi</label>
                            <div id="gambar-container">
                                <div class="flex items-center mb-2">
                                    <input type="file" name="dokumentasi_prestasi[]" id="dokumentasi_prestasi"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                        required>
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
                            <p class="text-xs text-gray-500 mb-1">Tag pengguna lain(pisahkan dengan koma), misal @nama1
                            </p>
                            <input type="text" name="user_tags" id="user_tags"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        </div>

                        <button type="submit"
                            class="px-4 py-2 bg-blue-500 text-black rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">Simpan</button>

                        {{-- Tombol Kembali --}}
                        <a href="{{ route('dashboard') }}"
                            class="px-4 py-2 text-black hover:text-blue-700 rounded">Kembali</a>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Setup tag pengguna
            new TomSelect('#user_tags', {
                plugins: ['remove_button'],
                delimiter: ',',
                persist: false,
                createOnBlur: true,
                create: function(input) {
                    // Hanya buat tag jika dimulai dengan @
                    if (input.startsWith('@')) {
                        return {
                            value: input,
                            text: input
                        };
                    }
                    return false;
                },
                render: {
                    option_create: function(data, escape) {
                        return '<div class="create">Tag <strong>' + escape(data.input) +
                            '</strong>&hellip;</div>';
                    },
                    item: function(data, escape) {
                        return '<div>' + escape(data.value) + '</div>';
                    }
                },
                onItemAdd: function(value) {
                    // Cek jika tag valid (mulai dengan @)
                    if (!value.startsWith('@')) {
                        this.removeItem(value);
                    }
                }
            });
        });

        function addDokumentasi() {
            const container = document.getElementById('gambar-container');
            const newRow = document.createElement('div');
            newRow.classList.add('flex', 'items-center', 'mb-2');
            newRow.innerHTML = `
        <input type="file" name="dokumentasi_prestasi[]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
            accept="image/*" required>
        <button type="button" class="ml-2 px-3 py-1 bg-red-500 text-black rounded hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50"
            onclick="removeGambar(this)">Remove</button>
    `;
            container.appendChild(newRow);
        }

        function removeGambar(button) {
            const row = button.parentElement;
            row.remove();
        }
    </script>
</x-app-layout>
