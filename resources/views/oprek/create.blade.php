<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Informasi Hiring') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg">
                <div class="px-7 py-4 bg-white">
                    <form action="{{ route('oprek.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        
                        {{-- Error Messages --}}
                        @if ($errors->any())
                            <div class="bg-red-50 border border-red-200 rounded-md p-4">
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

                        @if (Session::has('error'))
                            <div class="bg-red-50 border border-red-200 rounded-md p-4">
                                <div class="text-sm text-red-700">{{ Session::get('error') }}</div>
                            </div>
                        @endif

                        {{-- Nama Informasi Project --}}
                        <div class="space-y-2">
                            <label for="nama_project" class="block text-sm font-semibold text-gray-700">
                                Nama Informasi Hiring <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="nama_project" id="nama_project"
                                class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out"
                                placeholder="Masukkan nama informasi hiring"
                                required>
                        </div>

                        {{-- Deskripsi --}}
                        <div class="space-y-2">
                            <label for="deskripsi_project" class="block text-sm font-semibold text-gray-700">
                                Deskripsi <span class="text-red-500">*</span>
                            </label>
                            <textarea name="deskripsi_project" id="deskripsi_project" rows="4"
                                class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out"
                                placeholder="Jelaskan informasi hiring secara detail..."
                                required></textarea>
                        </div>

                        {{-- Deadline --}}
                        <div class="space-y-2">
                            <label for="deadline_project" class="block text-sm font-semibold text-gray-700">
                                Deadline <span class="text-red-500">*</span>
                            </label>
                            <input type="date" name="deadline_project" id="deadline_project"
                                class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out"
                                required>
                        </div>

                        {{-- Penyelenggara --}}
                        <div class="space-y-2">
                            <label for="penyelenggara" class="block text-sm font-semibold text-gray-700">
                                Penyelenggara Hiring <span class="text-red-500">*</span>
                            </label>
                            <select name="penyelenggara" id="penyelenggara"
                                class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out"
                                required>
                                <option value="" disabled selected>Pilih Penyelenggara</option>
                                <option value="Dosen">Dosen</option>
                                <option value="Mahasiswa">Mahasiswa</option>
                                <option value="Organisasi">Organisasi</option>
                                <option value="Eksternal">Eksternal</option>
                            </select>
                        </div>

                        {{-- Nama Penyelenggara --}}
                        <div class="space-y-2">
                            <label for="nama_penyelenggara" class="block text-sm font-semibold text-gray-700">
                                Nama Penyelenggara <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="nama_penyelenggara" id="nama_penyelenggara"
                                class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out"
                                placeholder="Masukkan nama penyelenggara"
                                required>
                        </div>

                        {{-- Kategori Project --}}
                        <div class="space-y-2">
                            <label for="kategori_project" class="block text-sm font-semibold text-gray-700">
                                Kategori Project <span class="text-red-500">*</span>
                            </label>
                            <select name="kategori_project" id="kategori_project"
                                class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out"
                                required>
                                <option value="" disabled selected>Pilih Kategori Project</option>
                                <option value="Penelitian">Penelitian</option>
                                <option value="Pengembangan Aplikasi">Pengembangan Aplikasi</option>
                                <option value="Pengabdian Masyarakat">Pengabdian Masyarakat</option>
                                <option value="Inisiatif Pribadi">Inisiatif Pribadi</option>
                            </select>
                        </div>

                        {{-- Tautan --}}
                        <div class="space-y-2">
                            <label for="tautan_project" class="block text-sm font-semibold text-gray-700">
                                Tautan Project <span class="text-red-500">*</span>
                            </label>
                            <input type="url" name="tautan_project" id="tautan_project"
                                class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out"
                                placeholder="https://example.com"
                                required>
                        </div>

                        {{-- Output Project --}}
                        <div class="space-y-2">
                            <label for="output_project" class="block text-sm font-semibold text-gray-700">
                                Output Project <span class="text-red-500">*</span>
                            </label>
                            <select name="output_project" id="output_project"
                                class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out"
                                required>
                                <option value="" disabled selected>Pilih Output Project</option>
                                <option value="Website">Website</option>
                                <option value="Mobile Apps">Mobile Apps</option>
                                <option value="API Development">API Development</option>
                                <option value="Game">Game</option>
                                <option value="Machine Learning/AI Project">Machine Learning/AI Project</option>
                                <option value="Cyber Security">Cyber Security</option>
                                <option value="Automation">Automation</option>
                                <option value="Embedded System">Embedded System</option>
                            </select>
                        </div>

                        {{-- Kualifikasi Project --}}
                        <div class="space-y-2">
                            <label for="kualifikasi_oprek" class="block text-sm font-semibold text-gray-700">
                                Kualifikasi Project <span class="text-red-500">*</span>
                            </label>
                            <div class="bg-gray-50 p-4 rounded-md border border-gray-200">
                                <div id="kualifikasi-container" class="space-y-3">
                                    <div class="flex items-center gap-3">
                                        <input type="text" name="kualifikasi_oprek[]"
                                            class="flex-1 px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out"
                                            placeholder="Masukkan kualifikasi" required>
                                        <button type="button"
                                            class="px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition duration-150 ease-in-out"
                                            onclick="addKualifikasi()">
                                            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                            </svg>
                                            Tambah
                                        </button>
                                    </div>
                                </div>
                                <p class="text-xs text-gray-500 mt-2">Tambahkan kualifikasi yang dibutuhkan</p>
                            </div>
                        </div>

                        {{-- Gambar/Flyer Informasi --}}
                        <div class="space-y-2">
                            <label for="flyer_informasi" class="block text-sm font-semibold text-gray-700">
                                Gambar Informasi Hiring <span class="text-red-500">*</span>
                            </label>
                            <input type="file" name="flyer_informasi" id="flyer_informasi"
                                class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out file:mr-4 file:py-1 file:px-3 file:rounded-md file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                                accept="image/*" required>
                            <p class="text-xs text-gray-500 mt-1">Unggah gambar (JPG, PNG, GIF). Maksimal 2MB.</p>
                        </div>

                        {{-- Action Buttons --}}
                        <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
                            <a href="{{ route('dashboard') }}" 
                                class="px-6 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition duration-150 ease-in-out">
                                Kembali
                            </a>
                            <button type="submit"
                                class="px-6 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-[#4B83BF] hover:bg-[#5a93c7] focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition duration-150 ease-in-out">
                                <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Simpan Informasi
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
            newRow.classList.add('flex', 'items-center', 'gap-3');
            newRow.innerHTML = `
                <input type="text" name="kualifikasi_oprek[]"
                    class="flex-1 px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out"
                    placeholder="Masukkan kualifikasi" required>
                <button type="button"
                    class="px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition duration-150 ease-in-out"
                    onclick="removeKualifikasi(this)">
                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                    Hapus
                </button>
            `;
            container.appendChild(newRow);
        }

        function removeKualifikasi(button) {
            const row = button.parentElement;
            row.remove();
        }
    </script>
</x-app-layout>