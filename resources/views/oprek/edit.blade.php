<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">Edit Informasi Hiring</h3>
                    <form action="{{ route('oprek.update', $oprek->id_oprek) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        {{-- Nama Informasi Hiring --}}
                        <div class="mb-4">
                            <label for="nama_project" class="block text-sm font-medium text-gray-700">Nama Informasi
                                Hiring</label>
                            <input type="text" name="nama_project" id="nama_project"
                                value="{{ $oprek->nama_project }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                required>
                        </div>

                        {{-- Deskripsi --}}
                        <div class="mb-4">
                            <label for="deskripsi_project"
                                class="block text-sm font-medium text-gray-700">Deskripsi</label>
                            <textarea name="deskripsi_project" id="deskripsi_project" rows="4"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                required>{{ $oprek->deskripsi_project }}</textarea>
                        </div>

                        {{-- Deadline --}}
                        <div class="mb-4">
                            <label for="deadline_project"
                                class="block text-sm font-medium text-gray-700">Deadline</label>
                            <input type="date" name="deadline_project" id="deadline_project"
                                value="{{ $oprek->deadline_project }}"
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
                                <option value="" disabled>Pilih Penyelenggara</option>
                                <option value="Dosen" {{ $oprek->penyelenggara == 'Dosen' ? 'selected' : '' }}>Dosen
                                </option>
                                <option value="Mahasiswa" {{ $oprek->penyelenggara == 'Mahasiswa' ? 'selected' : '' }}>
                                    Mahasiswa</option>
                                <option value="Organisasi"
                                    {{ $oprek->penyelenggara == 'Organisasi' ? 'selected' : '' }}>Organisasi</option>
                                <option value="Eksternal" {{ $oprek->penyelenggara == 'Eksternal' ? 'selected' : '' }}>
                                    Eksternal</option>
                            </select>
                        </div>

                        {{-- Nama Penyelenggara --}}
                        <div class="mb-4">
                            <label for="nama_penyelenggara" class="block text-sm font-medium text-gray-700">Nama
                                Penyelenggara</label>
                            <input type="text" name="nama_penyelenggara" id="nama_penyelenggara"
                                value="{{ $oprek->nama_penyelenggara }}"
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
                                <option value="" disabled>Pilih Kategori Project</option>
                                <option value="Penelitian"
                                    {{ $oprek->kategori_project == 'Penelitian' ? 'selected' : '' }}>Penelitian
                                </option>
                                <option value="Pengembangan Aplikasi"
                                    {{ $oprek->kategori_project == 'Pengembangan Aplikasi' ? 'selected' : '' }}>
                                    Pengembangan Aplikasi</option>
                                <option value="Pengabdian Masyarakat"
                                    {{ $oprek->kategori_project == 'Pengabdian Masyarakat' ? 'selected' : '' }}>
                                    Pengabdian Masyarakat</option>
                                <option value="Inisiatif Pribadi"
                                    {{ $oprek->kategori_project == 'Inisiatif Pribadi' ? 'selected' : '' }}>Inisiatif
                                    Pribadi</option>
                            </select>
                        </div>

                        {{-- Tautan --}}
                        <div class="mb-4">
                            <label for="tautan_project" class="block text-sm font-medium text-gray-700">Tautan
                                Project</label>
                            <input type="url" name="tautan_project" id="tautan_project"
                                value="{{ $oprek->tautan_project }}"
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
                                <option value="" disabled>Pilih Output Project</option>
                                <option value="Website" {{ $oprek->output_project == 'Website' ? 'selected' : '' }}>
                                    Website</option>
                                <option value="Mobile Apps"
                                    {{ $oprek->output_project == 'Mobile Apps' ? 'selected' : '' }}>Mobile Apps
                                </option>
                                <option value="API Development"
                                    {{ $oprek->output_project == 'API Development' ? 'selected' : '' }}>API Development
                                </option>
                                <option value="Game" {{ $oprek->output_project == 'Game' ? 'selected' : '' }}>Game
                                </option>
                                <option value="Machine Learning/AI Project"
                                    {{ $oprek->output_project == 'Machine Learning/AI Project' ? 'selected' : '' }}>
                                    Machine Learning/AI Project</option>
                                <option value="Cyber Security"
                                    {{ $oprek->output_project == 'Cyber Security' ? 'selected' : '' }}>Cyber Security
                                </option>
                                <option value="Automation"
                                    {{ $oprek->output_project == 'Automation' ? 'selected' : '' }}>Automation</option>
                                <option value="Embedded System"
                                    {{ $oprek->output_project == 'Embedded System' ? 'selected' : '' }}>Embedded System
                                </option>
                            </select>
                        </div>

                        {{-- Kualifikasi --}}
                        <div class="mb-4">
                            <label for="kualifikasi_oprek" class="block text-sm font-medium text-gray-700">Kualifikasi
                                Project</label>
                            <div id="kualifikasi-container">
                                @foreach ($oprek->kualifikasi as $kualifikasi)
                                    <div class="flex items-center mb-2">
                                        <input type="text" name="kualifikasi_oprek[]"
                                            value="{{ $kualifikasi->kualifikasi_oprek }}"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                            placeholder="Masukkan kualifikasi" required>
                                        <button type="button"
                                            class="ml-2 px-3 py-1 bg-red-500 text-black rounded hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50"
                                            onclick="removeKualifikasi(this)">Remove</button>
                                    </div>
                                @endforeach
                            </div>
                            <button type="button"
                                class="mt-2 px-3 py-1 bg-green-500 text-black rounded hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-opacity-50"
                                onclick="addKualifikasi()">Add</button>
                        </div>

                        {{-- Gambar/Flyer Informasi --}}
                        <div class="mb-4">
                            <label for="flyer_informasi" class="block text-sm font-medium text-gray-700">Gambar
                                Informasi Hiring</label>
                            @if ($oprek->flyer_informasi)
                                <div class="mt-2">
                                    <img src="{{ asset('storage/' . $oprek->flyer_informasi) }}"
                                        alt="Flyer Informasi" class="w-32 h-32 object-cover rounded">
                                    <button type="button" id="hapus-flyer"
                                        class="ml-4 px-3 py-1 bg-red-500 text-black rounded hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50">
                                        Hapus Flyer
                                    </button>
                                </div>
                            @endif
                            <div id="unggah-flyer" class="mt-4 {{ $oprek->flyer_informasi ? 'hidden' : '' }}">
                                <input type="file" name="flyer_informasi" id="flyer_informasi"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                <p class="text-xs text-gray-500 mt-1">Unggah flyer baru (JPG, PNG). Maksimal 2MB.</p>
                            </div>
                        </div>

                        <button type="submit"
                            class="px-4 py-2 bg-blue-500 text-black rounded hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">Simpan
                            Perubahan</button>
                        <a href="{{ route('oprek.show', $oprek->id_oprek) }}"
                            class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">Batal</a>
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

        document.addEventListener('DOMContentLoaded', function() {
            const hapusFlyerBtn = document.getElementById('hapus-flyer');
            const unggahFlyerDiv = document.getElementById('unggah-flyer');

            if (hapusFlyerBtn) {
                hapusFlyerBtn.addEventListener('click', function() {
                    if (confirm('Apakah Anda yakin ingin menghapus flyer ini?')) {
                        const hiddenInput = document.createElement('input');
                        hiddenInput.type = 'hidden';
                        hiddenInput.name = 'hapus_flyer';
                        hiddenInput.value = '1';

                        const form = hapusFlyerBtn.closest('form');
                        form.appendChild(hiddenInput);

                        const currentFlyerInfo = hapusFlyerBtn.closest('div');
                        currentFlyerInfo.style.display = 'none';

                        unggahFlyerDiv.classList.remove('hidden');
                    }
                });
            }
        });
    </script>
</x-app-layout>
