<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">Edit Portofolio</h3>
                    <form action="{{ route('portofolio.update', $portofolio->id_portofolio) }}" method="POST"
                        enctype="multipart/form-data">
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

                        {{-- Nama Portofolio --}}
                        <div class="mb-4">
                            <label for="nama_portofolio" class="block text-sm font-medium text-gray-700">Nama
                                Portofolio</label>
                            <input type="text" name="nama_portofolio" id="nama_portofolio"
                                value="{{ $portofolio->nama_portofolio }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                required>
                        </div>

                        {{-- Deskripsi --}}
                        <div class="mb-4">
                            <label for="deskripsi_portofolio"
                                class="block text-sm font-medium text-gray-700">Deskripsi</label>
                            <textarea name="deskripsi_portofolio" id="deskripsi_portofolio" rows="4"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                required>{{ $portofolio->deskripsi_portofolio }}</textarea>
                        </div>

                        {{-- Gambar --}}
                        <div class="mb-4">
                            <label for="gambar_portofolio" class="block text-sm font-medium text-gray-700">Gambar
                                Portofolio</label>
                            <input type="file" name="gambar_portofolio[]" id="gambar_portofolio"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                multiple>
                            <p class="text-sm text-gray-500 mt-1">Kosongkan jika tidak ingin mengubah gambar.</p>

                            <div class="mt-4 grid grid-cols-2 md:grid-cols-3 gap-4">
                                @if ($portofolio->gambar->isNotEmpty())
                                    @foreach ($portofolio->gambar as $gambar)
                                        <div class="relative group border rounded p-2">
                                            <img src="{{ asset('storage/' . $gambar->gambar_portofolio) }}"
                                                alt="Gambar Portofolio" class="w-full h-32 object-cover rounded">
                                            <div class="mt-2 flex justify-end">
                                                <button type="button"
                                                    class="px-3 py-1 bg-red-500 text-black text-xs rounded hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50"
                                                    onclick="removeGambar(this, '{{ $gambar->id_gambar_portofolio }}')">
                                                    Remove
                                                </button>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <p class="text-gray-500 italic col-span-3">Belum ada gambar yang diunggah</p>
                                @endif
                            </div>

                            {{-- Kategori --}}
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Kategori</label>
                                <div class="grid grid-cols-2 gap-2">
                                    @foreach ($semuaKategori as $kategori)
                                        <label class="flex items-center space-x-3">
                                            <input type="checkbox" name="kategori_portofolio[]"
                                                value="{{ $kategori }}"
                                                {{ $portofolio->kategori->pluck('kategori_portofolio')->contains($kategori) ? 'checked' : '' }}
                                                class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                                            <span class="ml-3">{{ $kategori }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            {{-- Tag Pengguna --}}
                            <div class="mb-4">
                                <label for="user_tags" class="block text-sm font-medium text-gray-700">Tag
                                    Pengguna</label>
                                <input type="text" name="user_tags" id="user_tags"
                                    value="{{ $portofolio->taggedUsers->pluck('nama_pengguna')->map(fn($name) => '@' . $name)->join(', ') }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                <p class="text-sm text-gray-500 mt-1">Pisahkan dengan koma, misalnya: @user1, @user2</p>
                            </div>

                            {{-- Tautan --}}
                            <div class="mb-4">
                                <label for="tautan_portofolio"
                                    class="block text-sm font-medium text-gray-700">Tautan</label>
                                <div id="tautan-container">
                                    @foreach ($portofolio->tautan as $tautan)
                                        <div class="flex items-center mb-2">
                                            <input type="text" name="tautan_portofolio[]"
                                                value="{{ $tautan->tautan_portofolio }}"
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                                placeholder="Masukkan tautan" required>
                                            <button type="button"
                                                class="ml-2 px-3 py-1 bg-red-500 text-black rounded hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50"
                                                onclick="removeTautan(this)">Remove</button>
                                        </div>
                                    @endforeach
                                </div>
                                <button type="button"
                                    class="mt-2 px-3 py-1 bg-green-500 text-black rounded hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-opacity-50"
                                    onclick="addTautan()">Add</button>
                            </div>

                            {{-- Tools --}}
                            <div class="mb-4">
                                <label for="tools" class="block text-sm font-medium text-gray-700">Tools</label>
                                <div id="tools-container">
                                    @foreach ($portofolio->tools as $tools)
                                        <div class="flex items-center mb-2">
                                            <input type="text" name="tools_portofolio[]"
                                                value="{{ $tools->tools_portofolio }}"
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                                placeholder="Masukkan tools" required>
                                            <button type="button"
                                                class="ml-2 px-3 py-1 bg-red-500 text-black rounded hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50"
                                                onclick="removeTools(this)">Remove</button>
                                        </div>
                                    @endforeach
                                </div>
                                <button type="button"
                                    class="mt-2 px-3 py-1 bg-green-500 text-black rounded hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-opacity-50"
                                    onclick="addTools()">Add</button>
                            </div>

                            {{-- Dokumen --}}
                            <div class="mb-4">
                                <label for="dokumen_portofolio" class="block text-sm font-medium text-gray-700">Dokumen
                                    Portofolio</label>

                                @if ($portofolio->dokumen_portofolio)
                                    <div class="mt-2">
                                        <p class="text-sm">Dokumen saat ini:</p>
                                        <a href="{{ asset('storage/' . $portofolio->dokumen_portofolio) }}"
                                            target="_blank" class="text-blue-500 underline hover:text-blue-700">
                                            {{ basename($portofolio->dokumen_portofolio) }}
                                        </a>
                                        <button type="button" id="hapus-dokumen"
                                            class="ml-4 px-3 py-1 bg-red-500 text-black rounded hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50">
                                            Hapus Dokumen
                                        </button>
                                    </div>
                                @endif

                                <div id="unggah-dokumen"
                                    class="mt-4 {{ $portofolio->dokumen_portofolio ? 'hidden' : '' }}">
                                    <input type="file" name="dokumen_portofolio" id="dokumen_portofolio"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    <p class="text-xs text-gray-500 mt-1">Unggah dokumen baru (PDF, DOC, DOCX, ZIP).
                                        Maksimal 20MB.</p>
                                </div>
                            </div>

                            <button type="submit"
                                class="px-4 py-2 bg-blue-500 text-black rounded hover:bg-blue-600">Simpan
                                Perubahan</button>
                            <a href="{{ route('portofolio.show', $portofolio->id_portofolio) }}"
                                class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">Batal</a>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function addTautan() {
            const container = document.getElementById('tautan-container');
            const newRow = document.createElement('div');
            newRow.classList.add('flex', 'items-center', 'mb-2');
            newRow.innerHTML = `
                <input type="text" name="tautan_portofolio[]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                    placeholder="Masukkan tautan" required>
                <button type="button" class="ml-2 px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50"
                    onclick="removeTautan(this)">Remove</button>
            `;
            container.appendChild(newRow);
        }

        function removeTautan(button) {
            const row = button.parentElement;
            row.remove();
        }

        function addTools() {
            const container = document.getElementById('tools-container');
            const newRow = document.createElement('div');
            newRow.classList.add('flex', 'items-center', 'mb-2');
            newRow.innerHTML = `
                <input type="text" name="tools_portofolio[]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                    placeholder="Masukkan tools" required>
                <button type="button" class="ml-2 px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50"
                    onclick="removeTools(this)">Remove</button>
            `;
            container.appendChild(newRow);
        }

        function removeTools(button) {
            const row = button.parentElement;
            row.remove();
        }

        document.addEventListener('DOMContentLoaded', function() {
            const hapusDokumenBtn = document.getElementById('hapus-dokumen');
            const unggahDokumenDiv = document.getElementById('unggah-dokumen');

            if (hapusDokumenBtn) {
                hapusDokumenBtn.addEventListener('click', function() {
                    // Show confirmation dialog
                    if (confirm('Apakah Anda yakin ingin menghapus dokumen ini?')) {
                        const hiddenInput = document.createElement('input');
                        hiddenInput.type = 'hidden';
                        hiddenInput.name = 'hapus_dokumen';
                        hiddenInput.value = '1';

                        const form = hapusDokumenBtn.closest('form');
                        form.appendChild(hiddenInput);

                        const currentDocInfo = hapusDokumenBtn.closest('div');
                        currentDocInfo.style.display = 'none';

                        unggahDokumenDiv.classList.remove('hidden');
                    }
                });
            }
        });

        function removeGambar(button, idGambar) {
            if (confirm('Apakah Anda yakin ingin menghapus gambar ini?')) {
                // Buat input hidden untuk menandai gambar yang akan dihapus
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'hapus_gambar[]';
                input.value = idGambar;

                // Tambahkan input ke form
                const form = button.closest('form');
                form.appendChild(input);

                // Animasi dan sembunyikan elemen gambar
                const container = button.closest('.relative');
                container.style.transition = 'all 0.3s';
                container.style.opacity = '0';

                setTimeout(() => {
                    container.style.display = 'none';
                }, 300);
            }
        }
    </script>
</x-app-layout>
