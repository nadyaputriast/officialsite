<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Sertifikasi') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg">
                <div class="px-7 py-4 bg-white">
                    <form action="{{ route('sertifikasi.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf

                        {{-- Error --}}
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
                                        <h3 class="text-sm font-medium text-red-800">Terdapat kesalahan dalam form:</h3>
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

                        {{-- Nama Sertifikasi --}}
                        <div class="space-y-2">
                            <label for="nama_sertifikasi" class="block text-sm font-semibold text-gray-700">
                                Nama Sertifikasi <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="nama_sertifikasi" id="nama_sertifikasi"
                                class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                required>
                        </div>

                        {{-- Deskripsi --}}
                        <div class="space-y-2">
                            <label for="deskripsi_sertifikasi" class="block text-sm font-semibold text-gray-700">
                                Deskripsi Sertifikasi <span class="text-red-500">*</span>
                            </label>
                            <textarea name="deskripsi_sertifikasi" id="deskripsi_sertifikasi" rows="4"
                                class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                required></textarea>
                        </div>

                        {{-- Tanggal Sertifikasi --}}
                        <div class="space-y-2">
                            <label for="tanggal_sertifikasi" class="block text-sm font-semibold text-gray-700">
                                Tanggal Sertifikasi <span class="text-red-500">*</span>
                            </label>
                            <input type="date" name="tanggal_sertifikasi" id="tanggal_sertifikasi"
                                class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                required>
                        </div>

                        {{-- Penyelenggara --}}
                        <div class="space-y-2">
                            <label for="penyelenggara" class="block text-sm font-semibold text-gray-700">
                                Penyelenggara Sertifikasi <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="penyelenggara" id="penyelenggara"
                                class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                required>
                        </div>

                        {{-- Masa Berlaku --}}
                        <div class="space-y-2">
                            <label for="masa_berlaku" class="block text-sm font-semibold text-gray-700">
                                Masa Berlaku Sertifikasi
                            </label>
                            <div class="flex items-center gap-4">
                                <input type="number" name="masa_berlaku" id="masa_berlaku"
                                    class="flex-1 px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                    placeholder="Jumlah tahun" min="1">
                                <div class="flex items-center">
                                    <input type="checkbox" id="seumur_hidup" name="seumur_hidup" value="1"
                                        class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                    <label for="seumur_hidup" class="ml-2 text-sm text-gray-700">Seumur Hidup</label>
                                </div>
                            </div>
                            <p class="text-xs text-gray-500">Masukkan jumlah tahun atau centang "Seumur Hidup".</p>
                        </div>

                        {{-- File Sertifikasi --}}
                        <div class="space-y-2">
                            <label for="file_sertifikasi" class="block text-sm font-semibold text-gray-700">
                                File Sertifikasi <span class="text-red-500">*</span>
                            </label>
                            <input type="file" name="file_sertifikasi" id="file_sertifikasi"
                                class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 file:mr-4 file:py-1 file:px-3 file:rounded-md file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                                accept="application/pdf" required>
                            <p class="text-xs text-gray-500">Unggah file PDF. Maksimal 20MB.</p>
                        </div>

                        {{-- Tombol --}}
                        <div class="flex items-center justify-end space-x-4 pt-4">
                            <a href="{{ route('dashboard') }}"
                                class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                Kembali
                            </a>
                            <button type="submit"
                                class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-[#4B83BF] hover:bg-[#5a93c7] focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                Simpan
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
