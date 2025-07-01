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
                        <div class="mb-6">
                            <label for="gambar_portofolio" class="block text-sm font-medium text-gray-700 mb-2">
                                Gambar Portofolio
                            </label>

                            @if ($portofolio->gambar && $portofolio->gambar->count() > 0)
                                <div class="mb-4">
                                    <h4 class="text-sm font-medium text-gray-600 mb-2">Gambar Saat Ini:</h4>
                                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                        @foreach ($portofolio->gambar as $gambar)
                                            <div class="relative group" id="gambar-{{ $gambar->id_gambar_portofolio }}">
                                                <img src="{{ asset('storage/' . $gambar->gambar_portofolio) }}"
                                                    alt="Gambar"
                                                    class="w-full h-24 object-cover rounded-lg border-2 border-gray-200">

                                                {{-- Overlay dan tombol hapus --}}
                                                <div
                                                    class="absolute inset-0 bg-black bg-opacity-50 opacity-0 group-hover:opacity-100 transition-opacity rounded-lg flex flex-col justify-center items-center">
                                                    <span class="text-white text-xs mb-2">Gambar Saat Ini</span>
                                                    <button type="button"
                                                        onclick="removeGambar(this, {{ $gambar->id_gambar_portofolio }})"
                                                        class="bg-red-500 text-white px-2 py-1 rounded text-xs hover:bg-red-600 transition">
                                                        Hapus
                                                    </button>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <p class="text-xs text-gray-500 mt-2">
                                        Upload gambar baru di bawah jika ingin menambahkan lebih banyak gambar.
                                    </p>
                                </div>
                            @endif

                            <div
                                class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-blue-400 transition-colors">
                                <input type="file" name="gambar_portofolio[]" id="gambar_portofolio" multiple
                                    accept="image/*" class="hidden" onchange="previewImages(this)">
                                <label for="gambar_portofolio" class="cursor-pointer">
                                    <div
                                        class="mx-auto w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                        <svg class="w-6 h-6 text-gray-400" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                        </svg>
                                    </div>
                                    <p class="text-sm text-gray-600">
                                        <span class="font-medium text-blue-600 hover:text-blue-500">Klik untuk upload
                                            gambar baru</span>
                                        atau drag & drop
                                    </p>
                                    <p class="text-xs text-gray-500 mt-1">PNG, JPG, GIF hingga 2MB (Opsional)</p>
                                </label>
                            </div>

                            <div id="imagePreview" class="mt-4 hidden">
                                <h4 class="text-sm font-medium text-gray-600 mb-2">Preview Gambar Baru:</h4>
                                <div id="previewContainer" class="grid grid-cols-2 md:grid-cols-4 gap-4"></div>
                            </div>

                            @error('gambar_portofolio')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            @error('gambar_portofolio.*')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Kategori --}}
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Kategori</label>
                            <div class="grid grid-cols-2 gap-2">
                                @foreach ($semuaKategori as $kategori)
                                    <label class="flex items-center space-x-3">
                                        <input type="checkbox" name="kategori_portofolio[]" value="{{ $kategori }}"
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
                                            class="ml-2 px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50"
                                            onclick="removeTautan(this)">Remove</button>
                                    </div>
                                @endforeach
                            </div>
                            <button type="button"
                                class="mt-2 px-3 py-1 bg-green-500 text-white rounded hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-opacity-50"
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
                                            class="ml-2 px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50"
                                            onclick="removeTools(this)">Remove</button>
                                    </div>
                                @endforeach
                            </div>
                            <button type="button"
                                class="mt-2 px-3 py-1 bg-green-500 text-white rounded hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-opacity-50"
                                onclick="addTools()">Add</button>
                        </div>

                        {{-- Dokumen --}}
                        <div class="mb-4">
                            <label for="dokumen_portofolio" class="block text-sm font-medium text-gray-700">Dokumen
                                Portofolio</label>

                            @if ($portofolio->dokumen_portofolio)
                                <div class="mt-2" id="current-document">
                                    <p class="text-sm">Dokumen saat ini:</p>
                                    <a href="{{ asset('storage/' . $portofolio->dokumen_portofolio) }}"
                                        target="_blank" class="text-blue-500 underline hover:text-blue-700">
                                        {{ basename($portofolio->dokumen_portofolio) }}
                                    </a>
                                    <button type="button" id="hapus-dokumen"
                                        class="ml-4 px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50">
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
                            class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Simpan
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
            const currentDocumentDiv = document.getElementById('current-document');

            if (hapusDokumenBtn) {
                hapusDokumenBtn.addEventListener('click', function() {
                    // Show confirmation dialog
                    if (confirm('Apakah Anda yakin ingin menghapus dokumen ini?')) {
                        // Create hidden input to mark document for deletion
                        const hiddenInput = document.createElement('input');
                        hiddenInput.type = 'hidden';
                        hiddenInput.name = 'hapus_dokumen';
                        hiddenInput.value = '1';

                        // Add to form
                        const form = hapusDokumenBtn.closest('form');
                        form.appendChild(hiddenInput);

                        // Hide current document info
                        if (currentDocumentDiv) {
                            currentDocumentDiv.style.display = 'none';
                        }

                        // Show upload new document section
                        if (unggahDokumenDiv) {
                            unggahDokumenDiv.classList.remove('hidden');
                        }
                    }
                });
            }
        });

        function removeGambar(button, idGambar) {
            if (!idGambar) {
                alert('ID gambar tidak valid');
                return;
            }

            if (confirm("Yakin ingin menghapus gambar ini?")) {
                // Create hidden input to mark image for deletion
                const input = document.createElement("input");
                input.type = "hidden";
                input.name = "hapus_gambar[]";
                input.value = idGambar;

                // Add to form
                const form = button.closest('form');
                if (form) {
                    form.appendChild(input);
                }

                // Remove the image container from view
                const imageContainer = document.getElementById('gambar-' + idGambar);
                if (imageContainer) {
                    imageContainer.style.display = 'none';
                } else {
                    // Fallback: try to find the container by traversing up
                    const container = button.closest('.relative.group');
                    if (container) {
                        container.style.display = 'none';
                    }
                }
            }
        }

        function previewImages(input) {
            const previewDiv = document.getElementById('imagePreview');
            const previewContainer = document.getElementById('previewContainer');

            if (input.files && input.files.length > 0) {
                previewDiv.classList.remove('hidden');
                previewContainer.innerHTML = '';

                Array.from(input.files).forEach((file, index) => {
                    if (file.type.startsWith('image/')) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            const imageDiv = document.createElement('div');
                            imageDiv.className = 'relative group';
                            imageDiv.innerHTML = `
                            <img src="${e.target.result}" 
                                 alt="Preview ${index + 1}" 
                                 class="w-full h-24 object-cover rounded-lg border-2 border-blue-200">
                            <div class="absolute inset-0 bg-black bg-opacity-50 opacity-0 group-hover:opacity-100 transition-opacity rounded-lg flex items-center justify-center">
                                <span class="text-white text-xs">Preview ${index + 1}</span>
                            </div>
                        `;
                            previewContainer.appendChild(imageDiv);
                        };
                        reader.readAsDataURL(file);
                    }
                });
            } else {
                previewDiv.classList.add('hidden');
            }
        }
    </script>
</x-app-layout>