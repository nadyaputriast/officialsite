<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-8">
                    <div class="border-b border-gray-200 pb-6 mb-8 text-center">
                        <h3 class="text-2xl font-bold text-gray-900">Edit Pengabdian</h3>
                        <p class="mt-2 text-sm text-gray-600">Perbarui informasi kegiatan pengabdian</p>
                    </div>

                    <form action="{{ route('pengabdian.update', $pengabdian->id_pengabdian) }}" method="POST"
                        enctype="multipart/form-data" class="space-y-8">
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
                                        <div class="mt-2 text-sm text-red-700">
                                            <ul class="list-disc list-inside space-y-1">
                                                @foreach ($errors->all() as $salah)
                                                    <li>{{ $salah }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="bg-gray-50 rounded-lg p-6">

                            <div class="mb-6">
                                <label for="judul_pengabdian" class="block text-sm font-medium text-gray-700 mb-2">Judul Pengabdian <span class="text-red-500">*</span></label>
                                <input type="text" name="judul_pengabdian" id="judul_pengabdian" value="{{ $pengabdian->judul_pengabdian }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" required>
                            </div>

                            <div class="mb-6">
                                <label for="deskripsi_pengabdian" class="block text-sm font-medium text-gray-700 mb-2">Deskripsi <span class="text-red-500">*</span></label>
                                <textarea name="deskripsi_pengabdian" id="deskripsi_pengabdian" rows="4" class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors resize-none" required>{{ $pengabdian->deskripsi_pengabdian }}</textarea>
                            </div>

                            <div class="mb-6">
                                <label for="tanggal_pengabdian" class="block text-sm font-medium text-gray-700 mb-2">Tanggal Pengabdian <span class="text-red-500">*</span></label>
                                <input type="date" name="tanggal_pengabdian" id="tanggal_pengabdian" value="{{ $pengabdian->tanggal_pengabdian }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" required>
                            </div>

                            <div class="mb-6">
                                <label for="pelaksana" class="block text-sm font-medium text-gray-700 mb-2">Pelaksana Pengabdian <span class="text-red-500">*</span></label>
                                <input type="text" name="pelaksana" id="pelaksana" value="{{ $pengabdian->pelaksana }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" required>
                            </div>
                        </div>

                        <!-- Dokumentasi Pengabdian -->
                        <div class="bg-gray-50 rounded-lg p-6">
                            <h4 class="block text-sm font-medium text-gray-700 mb-2">Dokumentasi Pengabdian</h4>

                            @if ($pengabdian->dokumentasi->isNotEmpty())
                                <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mb-4">
                                    @foreach ($pengabdian->dokumentasi as $dokumentasi)
                                        <div class="relative group border rounded p-2">
                                            <img src="{{ asset('storage/' . $dokumentasi->dokumentasi_pengabdian) }}" alt="Dokumentasi Pengabdian" class="w-full h-32 object-cover rounded">
                                            <div class="mt-2 flex justify-end">
                                                <button type="button" class="px-3 py-1 bg-red-500 text-white text-xs rounded hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50" onclick="removeExistingDokumentasi(this, '{{ $dokumentasi->id_dokumentasi }}')">Hapus</button>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif

                            <div id="gambar-container">
                                <div class="flex items-center mb-2">
                                    <input type="file" name="dokumentasi_pengabdian[]" accept="image/*" class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                                    <button type="button" class="ml-2 px-3 py-1 bg-green-600 text-white rounded hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-opacity-50" onclick="addDokumentasi()">Tambah</button>
                                </div>
                            </div>
                            <p class="text-xs text-gray-500 mt-1">Unggah gambar (JPG, PNG, GIF). Maksimal 2MB per gambar.</p>
                        </div>

                        <!-- Tag Pengguna -->
                        <div class="bg-gray-50 rounded-lg p-6">
                            <div class="mb-6">
                                <label for="user_tags" class="block text-sm font-medium text-gray-700 mb-2">Tag Pengguna</label>
                                <p class="text-xs text-gray-500 mb-1">Pisahkan dengan koma, misalnya: @nama1, @nama2</p>
                                <input type="text" name="user_tags" id="user_tags" value="{{ $pengabdian->taggedUsers->pluck('nama_pengguna')->map(fn($name) => '@' . $name)->join(', ') }}" class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                            </div>
                        </div>

                        <!-- Tombol Aksi -->
                        <div class="flex justify-end gap-4 mt-6">
                            <a href="{{ route('pengabdian.show', $pengabdian->id_pengabdian) }}"
                                class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-100">
                                Kembali
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
        function addDokumentasi() {
            const container = document.getElementById('gambar-container');
            const newRow = document.createElement('div');
            newRow.classList.add('flex', 'items-center', 'mb-2');
            newRow.innerHTML = `
                <input type="file" name="dokumentasi_pengabdian[]" accept="image/*" class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                <button type="button" class="ml-2 px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50" onclick="removeGambar(this)">Hapus</button>
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
