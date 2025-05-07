<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Informasi Hiring') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('oprek.store') }}" method="POST" enctype="multipart/form-data">
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
                        
                        {{-- Nama Informasi Project --}}
                        <div class="mb-4">
                            <label for="nama_project" class="block text-sm font-medium text-gray-700">Nama
                                Informasi Hiring</label>
                            <input type="text" name="nama_project" id="nama_project"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                required>
                        </div>

                        {{-- Deskripsi --}}
                        <div class="mb-4">
                            <label for="deskripsi_project"
                                class="block text-sm font-medium text-gray-700">Deskripsi</label>
                            <textarea name="deskripsi_project" id="deskripsi_project" rows="4"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                required></textarea>
                        </div>

                        {{-- Deadline --}}
                        <div class="mb-4">
                            <label for="deadline_project"
                                class="block text-sm font-medium text-gray-700">Deadline</label>
                            <input type="date" name="deadline_project" id="deadline_project"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                required>
                        </div>

                        {{-- Penyelenggara --}}
                        <div class="mb-4">
                            <label for="penyelenggara" class="block text-sm font-medium text-gray-700">Penyelenggara
                                Hiring</label>
                            <select name="penyelenggara" id="penyelenggara"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                required>
                                <option value="" disabled selected>Pilih Penyelenggara</option>
                                <option value="Dosen">Dosen</option>
                                <option value="Mahasiswa">Mahasiswa</option>
                                <option value="Organisasi">Organisasi</option>
                                <option value="Eksternal">Eksternal</option>
                            </select>
                        </div>

                        {{-- Nama Penyelenggara --}}
                        <div class="mb-4">
                            <label for="nama_penyelenggara" class="block text-sm font-medium text-gray-700">Nama
                                Penyelenggara </label>
                            <input type="text" name="nama_penyelenggara" id="nama_penyelenggara"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                required>
                        </div>

                        {{-- Kategori Project --}}
                        <div class="mb-4">
                            <label for="kategori_project" class="block text-sm font-medium text-gray-700">Pilih Kategori
                                Project</label>
                            <select name="kategori_project" id="kategori_project"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                required>
                                <option value="" disabled selected>Pilih Kategori Project</option>
                                <option value="Penelitian">Penelitian</option>
                                <option value="Pengembangan Aplikasi">Pengembangan Aplikasi</option>
                                <option value="Pengabdian Masyarakat">Pengabdian Masyarakat</option>
                                <option value="Inisiatif Pribadi">Inisiatif Pribadi</option>
                            </select>
                        </div>

                        {{-- Tautan --}}
                        <div class="mb-4">
                            <label for="tautan_project" class="block text-sm font-medium text-gray-700">Tautan
                                Project</label>
                            <input type="url" name="tautan_project" id="tautan_project"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                required>
                        </div>

                        {{-- Output Project --}}
                        <div class="mb-4">
                            <label for="output_project" class="block text-sm font-medium text-gray-700">Pilih Output
                                Project</label>
                            <select name="output_project" id="output_project"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
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
                        <div class="mb-4">
                            <label for="kualifikasi_oprek" class="block text-sm font-medium text-gray-700">Kualifikasi
                                Project</label>
                            <div id="kualifikasi-container">
                                <div class="flex items-center mb-2">
                                    <input type="text" name="kualifikasi_oprek[]" id="kualifikasi_oprek"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                        placeholder="Masukkan kualifikasi" required>
                                    <button type="button"
                                        class="ml-2 px-3 py-1 bg-green-500 text-black rounded hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-opacity-50"
                                        onclick="addKualifikasi()">Add</button>
                                </div>
                            </div>
                        </div>

                        {{-- Gambar/Flyer Informasi --}}
                        <div class="mb-4">
                            <label for="flyer_informasi" class="block text-sm font-medium text-gray-700">Gambar
                                Informasi Hiring</label>
                            <input type="file" name="flyer_informasi" id="flyer_informasi"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                required>
                        </div>

                        <button type="submit"
                            class="px-4 py-2 bg-blue-500 text-black rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">Simpan</button>
                        
                            <a href="{{ route('dashboard') }}" class="px-4 py-c2 text-black rounded">Kembali</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        function addKualifikasi() {
            const container = document.getElementById('kualifikasi-container');
            const newRow = document.createElement('div');
            newRow.classList.add('flex', 'items-center', 'mb-2');
            newRow.innerHTML = `
				<input type="text" name="kualifikasi_oprek[]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
					placeholder="Masukkan kualifikasi" required>
				<button type="button" class="ml-2 px-3 py-1 bg-red-500 text-black rounded hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50"
					onclick="removeKualifikasi(this)">Remove</button>
			`;
            container.appendChild(newRow);
        }

        function removeKualifikasi(button) {
            const row = button.parentElement;
            row.remove();
        }
    </script>
</x-app-layout>
