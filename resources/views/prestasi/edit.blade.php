<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Prestasi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('prestasi.update', $prestasi->id_prestasi) }}" method="POST"
                        enctype="multipart/form-data" id="prestasi-form">
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

                        {{-- Nama Prestasi --}}
                        <div class="mb-4">
                            <label for="nama_prestasi" class="block text-sm font-medium text-gray-700">Nama
                                Prestasi</label>
                            <input type="text" name="nama_prestasi" id="nama_prestasi"
                                value="{{ $prestasi->nama_prestasi }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                required>
                        </div>

                        {{-- Deskripsi --}}
                        <div class="mb-4">
                            <label for="deskripsi_prestasi"
                                class="block text-sm font-medium text-gray-700">Deskripsi</label>
                            <textarea name="deskripsi_prestasi" id="deskripsi_prestasi" rows="4"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                required>{{ $prestasi->deskripsi_prestasi }}</textarea>
                        </div>

                        {{-- Tanggal Perolehan --}}
                        <div class="mb-4">
                            <label for="tanggal_perolehan" class="block text-sm font-medium text-gray-700">Tanggal
                                Perolehan</label>
                            <input type="date" name="tanggal_perolehan" id="tanggal_perolehan"
                                value="{{ $prestasi->tanggal_perolehan }}"
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
                                <option value="Regional"
                                    {{ $prestasi->tingkatan_prestasi == 'Regional' ? 'selected' : '' }}>Regional
                                </option>
                                <option value="Nasional"
                                    {{ $prestasi->tingkatan_prestasi == 'Nasional' ? 'selected' : '' }}>Nasional
                                </option>
                                <option value="Internasional"
                                    {{ $prestasi->tingkatan_prestasi == 'Internasional' ? 'selected' : '' }}>
                                    Internasional</option>
                            </select>
                        </div>

                        {{-- Jenis Prestasi --}}
                        <div class="mb-4">
                            <label for="jenis_prestasi" class="block text-sm font-medium text-gray-700">Jenis
                                Prestasi</label>
                            <select name="jenis_prestasi" id="jenis_prestasi"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                required>
                                <option value="Akademik"
                                    {{ $prestasi->jenis_prestasi == 'Akademik' ? 'selected' : '' }}>Akademik</option>
                                <option value="Non Akademik"
                                    {{ $prestasi->jenis_prestasi == 'Non Akademik' ? 'selected' : '' }}>Non Akademik
                                </option>
                            </select>
                        </div>

                        {{-- Dokumentasi Prestasi --}}
                        <div class="mb-4">
                            <label for="dokumentasi_prestasi"
                                class="block text-sm font-medium text-gray-700">Dokumentasi Prestasi</label>

                            {{-- Container untuk dokumentasi yang dipertahankan --}}
                            <div id="dokumentasi-container" class="grid grid-cols-2 md:grid-cols-3 gap-4">
                                {{-- Dokumentasi yang Sudah Ada --}}
                                @if ($prestasi->dokumentasi->isNotEmpty())
                                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                                        @foreach ($prestasi->dokumentasi as $dokumentasi)
                                            <div class="relative group border rounded p-2"
                                                id="dok-{{ $dokumentasi->id_dokumentasi }}">
                                                <img src="{{ asset('storage/' . $dokumentasi->dokumentasi_prestasi) }}"
                                                    alt="Dokumentasi Prestasi" class="w-full h-32 object-cover rounded">
                                                <input type="hidden" name="existing_dokumentasi[]"
                                                    value="{{ $dokumentasi->id_dokumentasi }}">
                                                <div class="mt-2 flex justify-end">
                                                    <button type="button"
                                                        class="px-3 py-1 bg-red-500 text-black text-xs rounded hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50"
                                                        onclick="removeExistingDokumentasi('{{ $dokumentasi->id_dokumentasi }}')">
                                                        Remove
                                                    </button>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>

                            {{-- Input untuk Menambahkan Dokumentasi Baru --}}
                            <div id="gambar-container" class="mt-4">
                                <div class="flex items-center mb-2">
                                    <input type="file" name="dokumentasi_prestasi[]"
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
                                value="{{ $prestasi->taggedUsers->pluck('nama_pengguna')->map(fn($name) => '@' . $name)->join(', ') }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        </div>

                        <button type="submit"
                            class="px-4 py-2 bg-blue-500 text-black rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
                            Simpan Perubahan
                        </button>

                        {{-- Tombol Kembali --}}
                        <a href="{{ route('prestasi.show', $prestasi->id_prestasi) }}"
                            class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">Batal</a>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Array untuk menyimpan ID dokumentasi yang dihapus
        let removedDocs = [];

        function addDokumentasi() {
            const container = document.getElementById('gambar-container');
            const newRow = document.createElement('div');
            newRow.classList.add('flex', 'items-center', 'mb-2');
            newRow.innerHTML = `
                <input type="file" name="dokumentasi_prestasi[]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
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

        function removeExistingDokumentasi(docId) {
            if (confirm('Apakah Anda yakin ingin menghapus dokumentasi ini?')) {
                // Hapus element dari DOM
                const docElement = document.getElementById('dok-' + docId);
                if (docElement) {
                    // Hapus input hidden dengan nama existing_dokumentasi[]
                    const hiddenInput = docElement.querySelector('input[name="existing_dokumentasi[]"]');
                    if (hiddenInput) {
                        hiddenInput.remove();
                    }
                    docElement.remove();
                }

                // Tambahkan ID dokumentasi ke array dokumentasi yang dihapus
                removedDocs.push(docId);

                console.log('Dokumentasi ID ' + docId + ' akan dihapus');
                console.log('Dokumentasi yang akan dipertahankan: ', document.querySelectorAll(
                    'input[name="existing_dokumentasi[]"]'));
            }
        }

        // Tambahkan event listener untuk form submission
        document.getElementById('prestasi-form').addEventListener('submit', function(e) {
            console.log('Form disubmit');
            console.log('Dokumentasi yang dipertahankan:', document.querySelectorAll(
                'input[name="existing_dokumentasi[]"]'));

            // Form bisa disubmit seperti biasa
        });
    </script>
</x-app-layout>
