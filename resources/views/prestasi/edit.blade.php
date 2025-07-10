<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-8">
                    <div class="border-b border-gray-200 pb-6 mb-8 text-center">
                        <h3 class="text-2xl font-bold text-gray-900">Edit Prestasi</h3>
                        <p class="mt-2 text-sm text-gray-600">Perbarui informasi prestasi</p>
                    </div>

                    <form action="{{ route('prestasi.update', $prestasi->id_prestasi) }}" method="POST"
                        enctype="multipart/form-data" id="prestasi-form" class="space-y-8">
                        @csrf
                        @method('PUT')

                        @if ($errors->any())
                            <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <h3 class="text-sm font-medium text-red-800">Harap perbaiki error berikut:</h3>
                                        <ul class="mt-2 text-sm text-red-700 list-disc list-inside space-y-1">
                                            @foreach ($errors->all() as $salah)
                                                <li>{{ $salah }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="bg-gray-50 rounded-lg p-6">
                            <div class="mb-6">
                                <label for="nama_prestasi" class="block text-sm font-medium text-gray-700 mb-2">Nama Prestasi <span class="text-red-500">*</span></label>
                                <input type="text" name="nama_prestasi" id="nama_prestasi" value="{{ $prestasi->nama_prestasi }}"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" required>
                            </div>

                            <div class="mb-6">
                                <label for="deskripsi_prestasi" class="block text-sm font-medium text-gray-700 mb-2">Deskripsi <span class="text-red-500">*</span></label>
                                <textarea name="deskripsi_prestasi" id="deskripsi_prestasi" rows="4"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors resize-none" required>{{ $prestasi->deskripsi_prestasi }}</textarea>
                            </div>

                            <div class="mb-6">
                                <label for="tanggal_perolehan" class="block text-sm font-medium text-gray-700 mb-2">Tanggal Perolehan <span class="text-red-500">*</span></label>
                                <input type="date" name="tanggal_perolehan" id="tanggal_perolehan" value="{{ $prestasi->tanggal_perolehan }}"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" required>
                            </div>

                            <div class="mb-6">
                                <label for="tingkatan_prestasi" class="block text-sm font-medium text-gray-700 mb-2">Tingkatan Prestasi <span class="text-red-500">*</span></label>
                                <select name="tingkatan_prestasi" id="tingkatan_prestasi"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" required>
                                    <option value="Regional" {{ $prestasi->tingkatan_prestasi == 'Regional' ? 'selected' : '' }}>Regional</option>
                                    <option value="Nasional" {{ $prestasi->tingkatan_prestasi == 'Nasional' ? 'selected' : '' }}>Nasional</option>
                                    <option value="Internasional" {{ $prestasi->tingkatan_prestasi == 'Internasional' ? 'selected' : '' }}>Internasional</option>
                                </select>
                            </div>

                            <div class="mb-6">
                                <label for="jenis_prestasi" class="block text-sm font-medium text-gray-700 mb-2">Jenis Prestasi <span class="text-red-500">*</span></label>
                                <select name="jenis_prestasi" id="jenis_prestasi"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" required>
                                    <option value="Akademik" {{ $prestasi->jenis_prestasi == 'Akademik' ? 'selected' : '' }}>Akademik</option>
                                    <option value="Non Akademik" {{ $prestasi->jenis_prestasi == 'Non Akademik' ? 'selected' : '' }}>Non Akademik</option>
                                </select>
                            </div>
                        </div>

                        {{-- Dokumentasi --}}
                        <div class="bg-gray-50 rounded-lg p-6">
                            <h4 class="block text-sm font-medium text-gray-700 mb-2">Dokumentasi Prestasi</h4>
                            @if ($prestasi->dokumentasi->isNotEmpty())
                                <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mb-4">
                                    @foreach ($prestasi->dokumentasi as $dokumentasi)
                                        <div class="relative group border rounded p-2" id="dok-{{ $dokumentasi->id_dokumentasi }}">
                                            <img src="{{ asset('storage/' . $dokumentasi->dokumentasi_prestasi) }}" alt="Dokumentasi Prestasi"
                                                class="w-full h-32 object-cover rounded">
                                            <input type="hidden" name="existing_dokumentasi[]" value="{{ $dokumentasi->id_dokumentasi }}">
                                            <div class="mt-2 flex justify-end">
                                                <button type="button"
                                                    class="px-3 py-1 bg-red-500 text-white text-xs rounded hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50"
                                                    onclick="removeExistingDokumentasi('{{ $dokumentasi->id_dokumentasi }}')">
                                                    Hapus
                                                </button>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif

                            <div id="gambar-container">
                                <div class="flex items-center mb-2">
                                    <input type="file" name="dokumentasi_prestasi[]" accept="image/*"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                                    <button type="button"
                                        class="ml-2 px-3 py-1 bg-green-600 text-white rounded hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-opacity-50"
                                        onclick="addDokumentasi()">Tambah</button>
                                </div>
                            </div>
                            <p class="text-xs text-gray-500 mt-1">Unggah gambar (JPG, PNG, GIF). Maksimal 2MB per gambar.</p>
                        </div>

                        {{-- Tag Pengguna --}}
                        <div class="bg-gray-50 rounded-lg p-6">
                            <label for="user_tags" class="block text-sm font-medium text-gray-700 mb-2">Tag Pengguna</label>
                            <p class="text-xs text-gray-500 mb-1">Pisahkan dengan koma, misalnya: @nama1, @nama2</p>
                            <input type="text" name="user_tags" id="user_tags"
                                value="{{ $prestasi->taggedUsers->pluck('nama_pengguna')->map(fn($name) => '@' . $name)->join(', ') }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                        </div>

                        {{-- Tombol Aksi --}}
                        <div class="flex justify-end gap-4 mt-6">
                            <a href="{{ route('prestasi.show', $prestasi->id_prestasi) }}"
                                class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-100">
                                Kemabali
                            </a>
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-[#4B83BF] hover:bg-[#5a93c7] border border-transparent rounded-md text-sm font-medium text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Simpan Perubahan
                            </button>
                        </div>
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
                <input type="file" name="dokumentasi_prestasi[]" accept="image/*" class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                <button type="button" class="ml-2 px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50" onclick="removeGambar(this)">Hapus</button>
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