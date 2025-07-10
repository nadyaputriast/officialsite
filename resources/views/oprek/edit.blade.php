<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-8">
                    <!-- Header -->
                    <div class="border-b border-gray-200 pb-6 mb-8">
                        <h3 class="text-2xl font-bold text-gray-900">Edit Informasi Hiring</h3>
                        <p class="mt-2 text-sm text-gray-600">Perbarui informasi lowongan pekerjaan atau project</p>
                    </div>

                    <form action="{{ route('oprek.update', $oprek->id_oprek) }}" method="POST"
                        enctype="multipart/form-data" class="space-y-8">
                        @csrf
                        @method('PUT')

                        <!-- Error Messages -->
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
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Basic Information Section -->
                        <div class="bg-gray-50 rounded-lg p-6">
                            <h4 class="text-lg font-semibold text-gray-900 mb-4">Informasi Dasar</h4>
                            
                            <!-- Nama Informasi Hiring -->
                            <div class="mb-6">
                                <label for="nama_project" class="block text-sm font-medium text-gray-700 mb-2">
                                    Nama Informasi Hiring <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="nama_project" id="nama_project"
                                    value="{{ $oprek->nama_project }}"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                    placeholder="Masukkan nama project atau posisi"
                                    required>
                            </div>

                            <!-- Deskripsi -->
                            <div class="mb-6">
                                <label for="deskripsi_project" class="block text-sm font-medium text-gray-700 mb-2">
                                    Deskripsi <span class="text-red-500">*</span>
                                </label>
                                <textarea name="deskripsi_project" id="deskripsi_project" rows="4"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors resize-none"
                                    placeholder="Jelaskan detail project atau posisi yang dibutuhkan..."
                                    required>{{ $oprek->deskripsi_project }}</textarea>
                            </div>

                            <!-- Deadline -->
                            <div class="mb-6">
                                <label for="deadline_project" class="block text-sm font-medium text-gray-700 mb-2">
                                    Deadline <span class="text-red-500">*</span>
                                </label>
                                <input type="date" name="deadline_project" id="deadline_project"
                                    value="{{ $oprek->deadline_project }}"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                    required>
                            </div>
                        </div>

                        <!-- Organizer Information Section -->
                        <div class="bg-gray-50 rounded-lg p-6">
                            <h4 class="text-lg font-semibold text-gray-900 mb-4">Informasi Penyelenggara</h4>
                            
                            <!-- Penyelenggara -->
                            <div class="mb-6">
                                <label for="penyelenggara" class="block text-sm font-medium text-gray-700 mb-2">
                                    Penyelenggara Hiring <span class="text-red-500">*</span>
                                </label>
                                <select name="penyelenggara" id="penyelenggara"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                    required>
                                    <option value="" disabled>Pilih Penyelenggara</option>
                                    <option value="Dosen" {{ $oprek->penyelenggara == 'Dosen' ? 'selected' : '' }}>Dosen</option>
                                    <option value="Mahasiswa" {{ $oprek->penyelenggara == 'Mahasiswa' ? 'selected' : '' }}>Mahasiswa</option>
                                    <option value="Organisasi" {{ $oprek->penyelenggara == 'Organisasi' ? 'selected' : '' }}>Organisasi</option>
                                    <option value="Eksternal" {{ $oprek->penyelenggara == 'Eksternal' ? 'selected' : '' }}>Eksternal</option>
                                </select>
                            </div>

                            <!-- Nama Penyelenggara -->
                            <div class="mb-6">
                                <label for="nama_penyelenggara" class="block text-sm font-medium text-gray-700 mb-2">
                                    Nama Penyelenggara <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="nama_penyelenggara" id="nama_penyelenggara"
                                    value="{{ $oprek->nama_penyelenggara }}"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                    placeholder="Masukkan nama penyelenggara"
                                    required>
                            </div>
                        </div>

                        <!-- Project Details Section -->
                        <div class="bg-gray-50 rounded-lg p-6">
                            <h4 class="text-lg font-semibold text-gray-900 mb-4">Detail Project</h4>
                            
                            <!-- Kategori Project -->
                            <div class="mb-6">
                                <label for="kategori_project" class="block text-sm font-medium text-gray-700 mb-2">
                                    Kategori Project <span class="text-red-500">*</span>
                                </label>
                                <select name="kategori_project" id="kategori_project"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                    required>
                                    <option value="" disabled>Pilih Kategori Project</option>
                                    <option value="Penelitian" {{ $oprek->kategori_project == 'Penelitian' ? 'selected' : '' }}>Penelitian</option>
                                    <option value="Pengembangan Aplikasi" {{ $oprek->kategori_project == 'Pengembangan Aplikasi' ? 'selected' : '' }}>Pengembangan Aplikasi</option>
                                    <option value="Pengabdian Masyarakat" {{ $oprek->kategori_project == 'Pengabdian Masyarakat' ? 'selected' : '' }}>Pengabdian Masyarakat</option>
                                    <option value="Inisiatif Pribadi" {{ $oprek->kategori_project == 'Inisiatif Pribadi' ? 'selected' : '' }}>Inisiatif Pribadi</option>
                                </select>
                            </div>

                            <!-- Output Project -->
                            <div class="mb-6">
                                <label for="output_project" class="block text-sm font-medium text-gray-700 mb-2">
                                    Output Project <span class="text-red-500">*</span>
                                </label>
                                <select name="output_project" id="output_project"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                    required>
                                    <option value="" disabled>Pilih Output Project</option>
                                    <option value="Website" {{ $oprek->output_project == 'Website' ? 'selected' : '' }}>Website</option>
                                    <option value="Mobile Apps" {{ $oprek->output_project == 'Mobile Apps' ? 'selected' : '' }}>Mobile Apps</option>
                                    <option value="API Development" {{ $oprek->output_project == 'API Development' ? 'selected' : '' }}>API Development</option>
                                    <option value="Game" {{ $oprek->output_project == 'Game' ? 'selected' : '' }}>Game</option>
                                    <option value="Machine Learning/AI Project" {{ $oprek->output_project == 'Machine Learning/AI Project' ? 'selected' : '' }}>Machine Learning/AI Project</option>
                                    <option value="Cyber Security" {{ $oprek->output_project == 'Cyber Security' ? 'selected' : '' }}>Cyber Security</option>
                                    <option value="Automation" {{ $oprek->output_project == 'Automation' ? 'selected' : '' }}>Automation</option>
                                    <option value="Embedded System" {{ $oprek->output_project == 'Embedded System' ? 'selected' : '' }}>Embedded System</option>
                                </select>
                            </div>

                            <!-- Tautan Project -->
                            <div class="mb-6">
                                <label for="tautan_project" class="block text-sm font-medium text-gray-700 mb-2">
                                    Tautan Project <span class="text-red-500">*</span>
                                </label>
                                <input type="url" name="tautan_project" id="tautan_project"
                                    value="{{ $oprek->tautan_project }}"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                    placeholder="https://example.com"
                                    required>
                            </div>
                        </div>

                        <!-- Requirements Section -->
                        <div class="bg-gray-50 rounded-lg p-6">
                            <h4 class="text-lg font-semibold text-gray-900 mb-4">Kualifikasi & Requirements</h4>
                            
                            <!-- Kualifikasi -->
                            <div class="mb-6">
                                <div class="flex items-center justify-between mb-3">
                                    <label class="block text-sm font-medium text-gray-700">
                                        Kualifikasi Project <span class="text-red-500">*</span>
                                    </label>
                                    <button type="button"
                                        class="px-3 py-1 bg-[#4B83BF] hover:bg-[#5a93c7] text-white rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 text-sm font-medium transition-colors"
                                        onclick="addKualifikasi()">
                                        + Tambah Kualifikasi
                                    </button>
                                </div>
                                <div id="kualifikasi-container" class="space-y-3">
                                    @foreach ($oprek->kualifikasi as $kualifikasi)
                                        <div class="flex items-center space-x-3 bg-white p-3 rounded-lg border border-gray-200">
                                            <div class="flex-1">
                                                <input type="text" name="kualifikasi_oprek[]"
                                                    value="{{ $kualifikasi->kualifikasi_oprek }}"
                                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                                    placeholder="Masukkan kualifikasi yang dibutuhkan" required>
                                            </div>
                                            <button type="button"
                                                class="px-3 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition-colors"
                                                onclick="removeKualifikasi(this)">
                                                Hapus
                                            </button>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <!-- Media Section -->
                        <div class="bg-gray-50 rounded-lg p-6">
                            <h4 class="text-lg font-semibold text-gray-900 mb-4">Media & File</h4>
                            
                            <!-- Flyer Informasi -->
                            <div class="mb-6">
                                <label class="block text-sm font-medium text-gray-700 mb-3">
                                    Gambar Informasi Hiring
                                </label>
                                
                                @if ($oprek->flyer_informasi)
                                    <div class="mb-4 bg-blue-50 border border-blue-200 rounded-lg p-4" id="current-flyer">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center space-x-3">
                                                <div class="flex-shrink-0">
                                                    <img src="{{ asset('storage/' . $oprek->flyer_informasi) }}"
                                                        alt="Flyer Informasi" class="w-16 h-16 object-cover rounded-lg">
                                                </div>
                                                <div>
                                                    <p class="text-sm font-medium text-gray-900">Flyer Saat Ini</p>
                                                    <p class="text-sm text-gray-500">{{ basename($oprek->flyer_informasi) }}</p>
                                                </div>
                                            </div>
                                            <button type="button" id="hapus-flyer"
                                                class="px-3 py-1 bg-red-500 text-white rounded-md hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 text-sm font-medium transition-colors">
                                                Hapus
                                            </button>
                                        </div>
                                    </div>
                                @endif

                                <div id="unggah-flyer" class="{{ $oprek->flyer_informasi ? 'hidden' : '' }}">
                                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-8 text-center hover:border-blue-400 hover:bg-gray-50 transition-colors">
                                        <input type="file" name="flyer_informasi" id="flyer_informasi"
                                            accept="image/*" class="hidden">
                                        <label for="flyer_informasi" class="cursor-pointer">
                                            <div class="mx-auto w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                                <svg class="w-8 h-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                                </svg>
                                            </div>
                                            <div class="space-y-2">
                                                <p class="text-sm text-gray-600">
                                                    <span class="font-medium text-blue-600 hover:text-blue-500">Klik untuk upload flyer</span>
                                                    atau drag & drop
                                                </p>
                                                <p class="text-xs text-gray-500">PNG, JPG, GIF maksimal 2MB</p>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex flex-col sm:flex-row sm:justify-end sm:space-x-4 space-y-3 sm:space-y-0 pt-6 border-t border-gray-200">
                            <a href="{{ route('oprek.show', $oprek->id_oprek) }}"
                                class="inline-flex justify-center items-center px-6 py-3 border border-gray-300 shadow-sm text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                                Batal
                            </a>
                            <button type="submit"
                                class="inline-flex justify-center items-center px-6 py-3 border border-transparent text-sm font-medium rounded-lg text-white bg-[#4B83BF] hover:bg-[#5a93c7] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function addKualifikasi() {
            const container = document.getElementById('kualifikasi-container');
            const newRow = document.createElement('div');
            newRow.classList.add('flex', 'items-center', 'space-x-3', 'bg-white', 'p-3', 'rounded-lg', 'border', 'border-gray-200');
            newRow.innerHTML = `
                <div class="flex-1">
                    <input type="text" name="kualifikasi_oprek[]" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                        placeholder="Masukkan kualifikasi yang dibutuhkan" required>
                </div>
                <button type="button" class="px-3 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition-colors"
                    onclick="removeKualifikasi(this)">Hapus</button>
            `;
            container.appendChild(newRow);
        }

        function removeKualifikasi(button) {
            const row = button.parentElement;
            row.remove();
        }

        document.addEventListener('DOMContentLoaded', function() {
            const hapusFlyerBtn = document.getElementById('hapus-flyer');
            const unggahFlyerDiv = document.getElementById('unggah-flyer');
            const currentFlyerDiv = document.getElementById('current-flyer');

            if (hapusFlyerBtn) {
                hapusFlyerBtn.addEventListener('click', function() {
                    if (confirm('Apakah Anda yakin ingin menghapus flyer ini?')) {
                        const hiddenInput = document.createElement('input');
                        hiddenInput.type = 'hidden';
                        hiddenInput.name = 'hapus_flyer';
                        hiddenInput.value = '1';

                        const form = hapusFlyerBtn.closest('form');
                        form.appendChild(hiddenInput);

                        if (currentFlyerDiv) {
                            currentFlyerDiv.style.display = 'none';
                        }

                        if (unggahFlyerDiv) {
                            unggahFlyerDiv.classList.remove('hidden');
                        }
                    }
                });
            }
        });
    </script>
</x-app-layout>