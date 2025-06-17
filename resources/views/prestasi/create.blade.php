<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tambah Prestasi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet"/>
    <script src="//unpkg.com/alpinejs" defer></script>
</head>

<body>
    {{-- Tombol Kembali --}}
    <nav class="fixed top-0 left-0 w-full bg-white shadow-lg z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <!-- Tombol Kembali -->
            <a href="{{ route('dashboard') }}" class="flex items-center text-[#75AAD8] text-sm font-medium hover:underline">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Kembali ke halaman sebelumnya
            </a>
            <div class="flex items-center space-x-2">
                <img src="/public/images/saturuang.png" alt="Logo" class="h-8 w-auto">
                <span class="font-bold text-black text-[16px]">Satu<span class="text-600" style="color: #95C7EB;">Ruang</span></span>
            </div>
        </div>
    </nav>

    <div class="mt-16">
        <x-slot name="header">
            <header class="text-2xl font-bold text-center text-gray-800">
                {{ __('Tambah Prestasi') }}
            </header>
        </x-slot>
    </div>

    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
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
                            <label for="nama_prestasi" class="block text-sm font-medium text-gray-700 mb-1">Nama
                                Prestasi<span class="text-red-500">*</span></label>
                            <input type="text" name="nama_prestasi" id="nama_prestasi"
                                placeholder="Masukkan nama prestasi" class="w-full border rounded-lg p-3 focus:ring-blue-500 focus:border-blue-500"
                                required>
                        </div>

                        {{-- Deskripsi --}}
                        <div class="mb-4">
                            <label for="deskripsi_prestasi"
                                class="block text-sm font-medium text-gray-700">Deskripsi<span class="text-red-500">*</span></label>
                            <textarea name="deskripsi_prestasi" id="deskripsi_prestasi" rows="4"
                                placeholder="Masukkan deskripsi prestasi" class="w-full border rounded-lg p-3 focus:ring-blue-500 focus:border-blue-500"
                                required></textarea>
                        </div>

                        {{-- Tanggal Perolehan --}}
                        <div class="mb-4">
                            <label for="tanggal_perolehan" class="block text-sm font-medium text-gray-700">Tanggal
                                Perolehan<span class="text-red-500">*</span></label>
                            <input type="date" name="tanggal_perolehan" id="tanggal_perolehan"
                                class="w-full border rounded-lg p-3 focus:ring-blue-500 focus:border-blue-500"                                
                                required>
                        </div>

                        {{-- Tingkatan Prestasi --}}
                        <div class="mb-4">
                            <label for="tingkatan_prestasi" class="block text-sm font-medium text-gray-700">Tingkatan
                                Prestasi<span class="text-red-500">*</span></label>
                            <select name="tingkatan_prestasi" id="tingkatan_prestasi"
                                class="w-full border rounded-lg p-3 focus:ring-blue-500 focus:border-blue-500"
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
                                Prestasi<span class="text-red-500">*</span></label>
                            <select name="jenis_prestasi" id="jenis_prestasi"
                                class="w-full border rounded-lg p-3 focus:ring-blue-500 focus:border-blue-500"
                                required>
                                <option value="" disabled selected>Pilih Jenis Prestasi</option>
                                <option value="Akademik">Akademik</option>
                                <option value="Non Akademik">Non Akademik</option>
                            </select>
                        </div>

                        {{-- Dokumentasi Prestasi --}}
                        <div class="mb-4">
                            <label for="dokumentasi_prestasi"
                                class="block text-sm font-medium text-gray-700">Dokumentasi Prestasi<span class="text-red-500">*</span></label>
                            <div id="gambar-container">
                                <div class="flex items-center mb-2">
                                    <input type="file" name="dokumentasi_prestasi[]" id="dokumentasi_prestasi"
                                        class="w-full border rounded-lg p-3 focus:ring-blue-500 focus:border-blue-500"
                                        required>
                                    <button type="button"
                                        class="ml-2 px-3 py-1 bg-[#75AAD8] text-white rounded hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-opacity-50"
                                        onclick="addDokumentasi()">Add</button>
                                </div>
                            </div>

                            <p class="text-xs text-gray-500 mt-1">Unggah gambar (JPG, PNG, GIF). Maksimal 2MB per
                                gambar.</p>
                        </div>

                        {{-- Tag Pengguna --}}
                        <div class="form-group mb-4">
                            <label for="user_tags" class="block text-sm font-medium text-gray-700">Tag Pengguna</label>
                            <input type="text" name="user_tags" id="user_tags"
                                placeholder="Tag pengguna lain(pisahkan dengan koma), misal @nama1" class="w-full border rounded-lg p-3 focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <button type="submit"
                            class="w-full bg-[#75AAD8] hover:bg-[#5a93c7] text-white rounded-lg py-3 font-semibold">Kirim Proyek untuk Divalidasi
                        </button>
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
</body>
