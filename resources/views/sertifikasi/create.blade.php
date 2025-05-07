<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Sertifikasi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('sertifikasi.store') }}" method="POST" enctype="multipart/form-data">
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

                        {{-- Nama Sertifikasi --}}
                        <div class="mb-4">
                            <label for="nama_sertifikasi" class="block text-sm font-medium text-gray-700">Nama
                                Sertifikasi</label>
                            <input type="text" name="nama_sertifikasi" id="nama_sertifikasi"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                required>
                        </div>

                        {{-- Deskripsi --}}
                        <div class="mb-4">
                            <label for="deskripsi_sertifikasi"
                                class="block text-sm font-medium text-gray-700">Deskripsi</label>
                            <textarea name="deskripsi_sertifikasi" id="deskripsi_sertifikasi" rows="4"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                required></textarea>
                        </div>

                        {{-- Tanggal Sertifikasi --}}
                        <div class="mb-4">
                            <label for="tanggal_sertifikasi" class="block text-sm font-medium text-gray-700">Tanggal
                                Sertifikasi</label>
                            <input type="date" name="tanggal_sertifikasi" id="tanggal_sertifikasi"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                required>
                        </div>

                        {{-- Penyelenggara --}}
                        <div class="mb-4">
                            <label for="penyelenggara" class="block text-sm font-medium text-gray-700">Penyelenggara
                                Sertifikasi</label>
                            <input type="text" name="penyelenggara" id="penyelenggara"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                required>
                        </div>

                        {{-- Masa Berlaku --}}
                        <div class="mb-4">
                            <label for="masa_berlaku" class="block text-sm font-medium text-gray-700">Masa
                                Berlaku</label>
                            <div class="flex items-center">
                                <input type="number" name="masa_berlaku" id="masa_berlaku"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    placeholder="Masukkan jumlah tahun" min="1">
                                <div class="ml-4 flex items-center">
                                    <input type="checkbox" id="seumur_hidup" name="seumur_hidup" value="1"
                                        class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                    <label for="seumur_hidup" class="ml-2 text-sm text-gray-700">Seumur Hidup</label>
                                </div>
                            </div>
                            <p class="text-xs text-gray-500 mt-1">Masukkan jumlah tahun atau pilih "Seumur Hidup".</p>
                        </div>

                        {{-- File sertifikasi --}}
                        <div class="mb-4">
                            <label for="file_sertifikasi" class="block text-sm font-medium text-gray-700">File
                                Sertifikasi</label>
                            <input type="file" name="file_sertifikasi" id="file_sertifikasi"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                required>
                            <p class="text-xs text-gray-500 mt-1">Unggah dokumen (PDF). Maksimal 20MB.
                            </p>
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
