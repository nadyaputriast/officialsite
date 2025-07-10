<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Pengabdian') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg">
                <div class="px-7 py-4 bg-white">
                    <form action="{{ route('pengabdian.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf

                        @if ($errors->any())
                            <div class="bg-red-50 border border-red-200 rounded-md p-4">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <h3 class="text-sm font-medium text-red-800">Terdapat kesalahan:</h3>
                                        <ul class="mt-2 text-sm text-red-700 list-disc list-inside">
                                            @foreach ($errors->all() as $salah)
                                                <li>{{ $salah }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if (Session::has('error'))
                            <div class="bg-red-50 border border-red-200 rounded-md p-4 text-sm text-red-700">
                                {{ Session::get('error') }}
                            </div>
                        @endif

                        {{-- Judul Pengabdian --}}
                        <div class="space-y-2">
                            <label for="judul_pengabdian" class="block text-sm font-semibold text-gray-700">Judul Pengabdian <span class="text-red-500">*</span></label>
                            <input type="text" name="judul_pengabdian" id="judul_pengabdian"
                                class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                required>
                        </div>

                        {{-- Deskripsi --}}
                        <div class="space-y-2">
                            <label for="deskripsi_pengabdian" class="block text-sm font-semibold text-gray-700">Deskripsi <span class="text-red-500">*</span></label>
                            <textarea name="deskripsi_pengabdian" id="deskripsi_pengabdian" rows="4"
                                class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                required></textarea>
                        </div>

                        {{-- Tanggal Pengabdian --}}
                        <div class="space-y-2">
                            <label for="tanggal_pengabdian" class="block text-sm font-semibold text-gray-700">Tanggal Pengabdian <span class="text-red-500">*</span></label>
                            <input type="date" name="tanggal_pengabdian" id="tanggal_pengabdian"
                                class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                required>
                        </div>

                        {{-- Pelaksana --}}
                        <div class="space-y-2">
                            <label for="pelaksana" class="block text-sm font-semibold text-gray-700">Pelaksana <span class="text-red-500">*</span></label>
                            <input type="text" name="pelaksana" id="pelaksana"
                                class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                required>
                        </div>

                        {{-- Dokumentasi --}}
                        <div class="space-y-2">
                            <label for="dokumentasi_pengabdian" class="block text-sm font-semibold text-gray-700">Dokumentasi Pengabdian <span class="text-red-500">*</span></label>
                            <div id="gambar-container">
                                <div class="flex items-center gap-3 mb-2">
                                    <input type="file" name="dokumentasi_pengabdian[]" id="dokumentasi_pengabdian"
                                        class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                        accept="image/*" required>
                                    <button type="button"
                                        class="px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500"
                                        onclick="addDokumentasi()">Tambah</button>
                                </div>
                            </div>
                            <p class="text-xs text-gray-500">Unggah gambar (JPG, PNG, GIF). Maksimal 2MB per gambar.</p>
                        </div>

                        {{-- Tag Pengguna --}}
                        <div class="space-y-2">
                            <label for="user_tags" class="block text-sm font-semibold text-gray-700">Tag Pengguna</label>
                            <p class="text-xs text-gray-500">Tag pengguna lain (pisahkan dengan koma), misal: @nama1</p>
                            <input type="text" name="user_tags" id="user_tags"
                                class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        {{-- Tombol --}}
                        <div class="flex items-center justify-end space-x-4 pt-4">
                            <a href="{{ route('dashboard') }}"
                                class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                Kembali
                            </a>
                            <button type="submit"
                                class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-[#4B83BF] hover:bg-[#5a93c7] focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                Simpan Pengabdian
                            </button>
                        </div>
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
            newRow.classList.add('flex', 'items-center', 'gap-3', 'mb-2');
            newRow.innerHTML = `
                <input type="file" name="dokumentasi_pengabdian[]" class="block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" accept="image/*" required>
                <button type="button" class="px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500" onclick="removeGambar(this)">Hapus</button>
            `;
            container.appendChild(newRow);
        }

        function removeGambar(button) {
            const row = button.parentElement;
            row.remove();
        }
    </script>
</x-app-layout>
