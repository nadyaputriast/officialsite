<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-8">
                    <div class="border-b border-gray-200 pb-6 mb-8 text-center">
                        <h3 class="text-2xl font-bold text-gray-900">Edit Sertifikasi</h3>
                        <p class="mt-2 text-sm text-gray-600">Perbarui informasi sertifikasi</p>
                    </div>

                    <form action="{{ route('sertifikasi.update', $sertifikasi->id_sertifikasi) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
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

                        <div class="bg-gray-50 rounded-lg p-6">
                            {{-- Nama Sertifikasi --}}
                            <div class="mb-6">
                                <label for="nama_sertifikasi" class="block text-sm font-medium text-gray-700 mb-2">Nama Sertifikasi <span class="text-red-500">*</span></label>
                                <input type="text" name="nama_sertifikasi" id="nama_sertifikasi"
                                    value="{{ old('nama_sertifikasi', $sertifikasi->nama_sertifikasi) }}"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                    required>
                            </div>

                            {{-- Deskripsi --}}
                            <div class="mb-6">
                                <label for="deskripsi_sertifikasi" class="block text-sm font-medium text-gray-700 mb-2">Deskripsi <span class="text-red-500">*</span></label>
                                <textarea name="deskripsi_sertifikasi" id="deskripsi_sertifikasi" rows="4"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors resize-none"
                                    required>{{ old('deskripsi_sertifikasi', $sertifikasi->deskripsi_sertifikasi) }}</textarea>
                            </div>

                            {{-- Tanggal Sertifikasi --}}
                            <div class="mb-6">
                                <label for="tanggal_sertifikasi" class="block text-sm font-medium text-gray-700 mb-2">Tanggal Sertifikasi <span class="text-red-500">*</span></label>
                                <input type="date" name="tanggal_sertifikasi" id="tanggal_sertifikasi"
                                    value="{{ old('tanggal_sertifikasi', $sertifikasi->tanggal_sertifikasi) }}"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                    required>
                            </div>

                            {{-- Penyelenggara --}}
                            <div class="mb-6">
                                <label for="penyelenggara" class="block text-sm font-medium text-gray-700 mb-2">Penyelenggara <span class="text-red-500">*</span></label>
                                <input type="text" name="penyelenggara" id="penyelenggara"
                                    value="{{ old('penyelenggara', $sertifikasi->penyelenggara) }}"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                    required>
                            </div>

                            {{-- Masa Berlaku --}}
                            <div class="mb-6">
                                <label for="masa_berlaku" class="block text-sm font-medium text-gray-700 mb-2">Masa Berlaku Sertifikasi</label>
                                <div class="flex items-center gap-4">
                                    <input type="number" name="masa_berlaku" id="masa_berlaku"
                                        value="{{ old('masa_berlaku', $sertifikasi->masa_berlaku > 0 ? $sertifikasi->masa_berlaku : '') }}"
                                        class="flex-1 px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                        placeholder="Jumlah tahun" min="1">
                                    <div class="flex items-center">
                                        <input type="checkbox" id="seumur_hidup" name="seumur_hidup" value="1"
                                            {{ old('seumur_hidup', $sertifikasi->masa_berlaku == 0 ? 'checked' : '') }}
                                            class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                        <label for="seumur_hidup" class="ml-2 text-sm text-gray-700">Seumur Hidup</label>
                                    </div>
                                </div>
                                <p class="text-xs text-gray-500 mt-1">Masukkan jumlah tahun atau pilih "Seumur Hidup".</p>
                            </div>

                            {{-- File Sertifikasi --}}
                            <div class="mb-6">
                                <label for="file_sertifikasi" class="block text-sm font-medium text-gray-700 mb-2">File Sertifikasi</label>
                                <input type="file" name="file_sertifikasi" id="file_sertifikasi"
                                    class="block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors file:mr-4 file:py-1 file:px-3 file:rounded-md file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                                    accept="application/pdf">
                                <p class="text-xs text-gray-500 mt-1">Unggah file PDF. Maksimal 20MB.</p>
                            </div>
                        </div>

                        <div class="flex justify-end gap-4 mt-6">
                            <a href="{{ route('dashboard') }}"
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
</x-app-layout>