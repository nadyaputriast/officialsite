<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-8">
                    <!-- Header -->
                    <div class="border-b border-gray-200 pb-6 mb-8">
                        <h3 class="text-2xl font-bold text-gray-900">Edit Portofolio</h3>
                        <p class="mt-2 text-sm text-gray-600">Perbarui informasi dan media portofolio Anda</p>
                    </div>

                    <form action="{{ route('portofolio.update', $portofolio->id_portofolio) }}" method="POST"
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
                                                @foreach ($errors->all() as $salah)
                                                    <li>{{ $salah }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if (Session::has('error'))
                            <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                                <div class="text-sm text-red-700">{{ Session::get('error') }}</div>
                            </div>
                        @endif

                        <!-- Basic Information Section -->
                        <div class="bg-gray-50 rounded-lg p-6">
                            <h4 class="text-lg font-semibold text-gray-900 mb-4">Informasi Dasar</h4>
                            
                            <!-- Portfolio Name -->
                            <div class="mb-6">
                                <label for="nama_portofolio" class="block text-sm font-medium text-gray-700 mb-2">
                                    Nama Portofolio <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="nama_portofolio" id="nama_portofolio"
                                    value="{{ $portofolio->nama_portofolio }}"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                    placeholder="Masukkan nama portofolio"
                                    required>
                            </div>

                            <!-- Description -->
                            <div class="mb-6">
                                <label for="deskripsi_portofolio" class="block text-sm font-medium text-gray-700 mb-2">
                                    Deskripsi <span class="text-red-500">*</span>
                                </label>
                                <textarea name="deskripsi_portofolio" id="deskripsi_portofolio" rows="4"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors resize-none"
                                    placeholder="Jelaskan tentang proyek portofolio Anda..."
                                    required>{{ $portofolio->deskripsi_portofolio }}</textarea>
                            </div>
                        </div>

                        <!-- Media Section -->
                        <div class="bg-gray-50 rounded-lg p-6">
                            <h4 class="text-lg font-semibold text-gray-900 mb-4">Media & File</h4>
                            
                            <!-- Images -->
                            <div class="mb-8">
                                <label class="block text-sm font-medium text-gray-700 mb-3">
                                    Gambar Portofolio
                                </label>

                                @if ($portofolio->gambar && $portofolio->gambar->count() > 0)
                                    <div class="mb-6">
                                        <div class="flex items-center justify-between mb-3">
                                            <h5 class="text-sm font-medium text-gray-600">Gambar Saat Ini</h5>
                                            <span class="text-xs text-gray-500">{{ $portofolio->gambar->count() }} gambar</span>
                                        </div>
                                        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
                                            @foreach ($portofolio->gambar as $gambar)
                                                <div class="relative group bg-white rounded-lg overflow-hidden shadow-sm border border-gray-200 hover:shadow-md transition-shadow" id="gambar-{{ $gambar->id_gambar_portofolio }}">
                                                    <div class="aspect-square">
                                                        <img src="{{ asset('storage/' . $gambar->gambar_portofolio) }}"
                                                            alt="Portfolio Image"
                                                            class="w-full h-full object-cover">
                                                    </div>
                                                    <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-50 transition-all duration-200 flex items-center justify-center">
                                                        <button type="button"
                                                            onclick="removeGambar(this, {{ $gambar->id_gambar_portofolio }})"
                                                            class="opacity-0 group-hover:opacity-100 bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-full text-xs font-medium transition-all duration-200 transform scale-90 group-hover:scale-100">
                                                            Hapus
                                                        </button>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif

                                <!-- Upload New Images -->
                                <div class="border-2 border-dashed border-gray-300 rounded-lg p-8 text-center hover:border-blue-400 hover:bg-gray-50 transition-colors">
                                    <input type="file" name="gambar_portofolio[]" id="gambar_portofolio" multiple
                                        accept="image/*" class="hidden" onchange="previewImages(this)">
                                    <label for="gambar_portofolio" class="cursor-pointer">
                                        <div class="mx-auto w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                            <svg class="w-8 h-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                            </svg>
                                        </div>
                                        <div class="space-y-2">
                                            <p class="text-sm text-gray-600">
                                                <span class="font-medium text-blue-600 hover:text-blue-500">Klik untuk upload gambar baru</span>
                                                atau drag & drop
                                            </p>
                                            <p class="text-xs text-gray-500">PNG, JPG, GIF maksimal 2MB per file</p>
                                        </div>
                                    </label>
                                </div>

                                <!-- Image Preview -->
                                <div id="imagePreview" class="mt-6 hidden">
                                    <div class="flex items-center justify-between mb-3">
                                        <h5 class="text-sm font-medium text-gray-600">Preview Gambar Baru</h5>
                                    </div>
                                    <div id="previewContainer" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4"></div>
                                </div>

                                @error('gambar_portofolio')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                                @error('gambar_portofolio.*')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Document -->
                            <div class="mb-6">
                                <label class="block text-sm font-medium text-gray-700 mb-3">
                                    Dokumen Portofolio
                                </label>

                                @if ($portofolio->dokumen_portofolio)
                                    <div class="mb-4 bg-blue-50 border border-blue-200 rounded-lg p-4" id="current-document">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center space-x-3">
                                                <div class="flex-shrink-0">
                                                    <svg class="h-8 w-8 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                    </svg>
                                                </div>
                                                <div>
                                                    <p class="text-sm font-medium text-gray-900">Dokumen Saat Ini</p>
                                                    <a href="{{ asset('storage/' . $portofolio->dokumen_portofolio) }}"
                                                        target="_blank" class="text-sm text-blue-600 hover:text-blue-500">
                                                        {{ basename($portofolio->dokumen_portofolio) }}
                                                    </a>
                                                </div>
                                            </div>
                                            <button type="button" id="hapus-dokumen"
                                                class="px-3 py-1 bg-red-500 text-white rounded-md hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 text-sm font-medium transition-colors">
                                                Hapus
                                            </button>
                                        </div>
                                    </div>
                                @endif

                                <div id="unggah-dokumen" class="{{ $portofolio->dokumen_portofolio ? 'hidden' : '' }}">
                                    <input type="file" name="dokumen_portofolio" id="dokumen_portofolio"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                                    <p class="text-xs text-gray-500 mt-2">Upload dokumen (PDF, DOC, DOCX, ZIP). Maksimal 20MB.</p>
                                </div>
                            </div>
                        </div>

                        <!-- Categories & Tags Section -->
                        <div class="bg-gray-50 rounded-lg p-6">
                            <h4 class="text-lg font-semibold text-gray-900 mb-4">Kategori & Tag</h4>
                            
                            <!-- Categories -->
                            <div class="mb-6">
                                <label class="block text-sm font-medium text-gray-700 mb-3">Kategori</label>
                                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
                                    @foreach ($semuaKategori as $kategori)
                                        <label class="relative flex items-center p-3 bg-white border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50 focus-within:ring-2 focus-within:ring-blue-500 focus-within:border-blue-500">
                                            <input type="checkbox" name="kategori_portofolio[]" value="{{ $kategori }}"
                                                {{ $portofolio->kategori->pluck('kategori_portofolio')->contains($kategori) ? 'checked' : '' }}
                                                class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                            <span class="ml-3 text-sm text-gray-700">{{ $kategori }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            <!-- User Tags -->
                            <div class="mb-6">
                                <label for="user_tags" class="block text-sm font-medium text-gray-700 mb-2">
                                    Tag Pengguna
                                </label>
                                <input type="text" name="user_tags" id="user_tags"
                                    value="{{ $portofolio->taggedUsers->pluck('nama_pengguna')->map(fn($name) => '@' . $name)->join(', ') }}"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                    placeholder="@user1, @user2, @user3">
                                <p class="text-xs text-gray-500 mt-2">Pisahkan dengan koma, contoh: @user1, @user2</p>
                            </div>
                        </div>

                        <!-- Links & Tools Section -->
                        <div class="bg-gray-50 rounded-lg p-6">
                            <h4 class="text-lg font-semibold text-gray-900 mb-4">Tautan & Tools</h4>
                            
                            <!-- Links -->
                            <div class="mb-6">
                                <div class="flex items-center justify-between mb-3">
                                    <label class="block text-sm font-medium text-gray-700">Tautan Portofolio</label>
                                    <button type="button"
                                        class="px-3 py-1 text-white rounded-md bg-[#4B83BF] hover:bg-[#5a93c7] focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 text-sm font-medium transition-colors"
                                        onclick="addTautan()">
                                        + Tambah Tautan
                                    </button>
                                </div>
                                <div id="tautan-container" class="space-y-3">
                                    @foreach ($portofolio->tautan as $tautan)
                                        <div class="flex items-center space-x-3 bg-white p-3 rounded-lg border border-gray-200">
                                            <div class="flex-1">
                                                <input type="text" name="tautan_portofolio[]"
                                                    value="{{ $tautan->tautan_portofolio }}"
                                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                                    placeholder="https://example.com" required>
                                            </div>
                                            <button type="button"
                                                class="px-3 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition-colors"
                                                onclick="removeTautan(this)">
                                                Hapus
                                            </button>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Tools -->
                            <div class="mb-6">
                                <div class="flex items-center justify-between mb-3">
                                    <label class="block text-sm font-medium text-gray-700">Tools yang Digunakan</label>
                                    <button type="button"
                                        class="px-3 py-1 bg-[#4B83BF] hover:bg-[#5a93c7] text-white rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 text-sm font-medium transition-colors"
                                        onclick="addTools()">
                                        + Tambah Tools
                                    </button>
                                </div>
                                <div id="tools-container" class="space-y-3">
                                    @foreach ($portofolio->tools as $tools)
                                        <div class="flex items-center space-x-3 bg-white p-3 rounded-lg border border-gray-200">
                                            <div class="flex-1">
                                                <input type="text" name="tools_portofolio[]"
                                                    value="{{ $tools->tools_portofolio }}"
                                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                                    placeholder="Adobe Photoshop, Figma, dll." required>
                                            </div>
                                            <button type="button"
                                                class="px-3 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition-colors"
                                                onclick="removeTools(this)">
                                                Hapus
                                            </button>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex flex-col sm:flex-row sm:justify-end sm:space-x-4 space-y-3 sm:space-y-0 pt-6 border-t border-gray-200">
                            <a href="{{ route('portofolio.show', $portofolio->id_portofolio) }}"
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
        function addTautan() {
            const container = document.getElementById('tautan-container');
            const newRow = document.createElement('div');
            newRow.classList.add('flex', 'items-center', 'space-x-3', 'bg-white', 'p-3', 'rounded-lg', 'border', 'border-gray-200');
            newRow.innerHTML = `
                <div class="flex-1">
                    <input type="text" name="tautan_portofolio[]" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                        placeholder="https://example.com" required>
                </div>
                <button type="button" class="px-3 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition-colors"
                    onclick="removeTautan(this)">Hapus</button>
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
            newRow.classList.add('flex', 'items-center', 'space-x-3', 'bg-white', 'p-3', 'rounded-lg', 'border', 'border-gray-200');
            newRow.innerHTML = `
                <div class="flex-1">
                    <input type="text" name="tools_portofolio[]" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                        placeholder="Adobe Photoshop, Figma, dll." required>
                </div>
                <button type="button" class="px-3 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition-colors"
                    onclick="removeTools(this)">Hapus</button>
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
                    if (confirm('Apakah Anda yakin ingin menghapus dokumen ini?')) {
                        const hiddenInput = document.createElement('input');
                        hiddenInput.type = 'hidden';
                        hiddenInput.name = 'hapus_dokumen';
                        hiddenInput.value = '1';

                        const form = hapusDokumenBtn.closest('form');
                        form.appendChild(hiddenInput);

                        if (currentDocumentDiv) {
                            currentDocumentDiv.style.display = 'none';
                        }

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

            if (confirm("Apakah Anda yakin ingin menghapus gambar ini?")) {
                const input = document.createElement("input");
                input.type = "hidden";
                input.name = "hapus_gambar[]";
                input.value = idGambar;

                const form = button.closest('form');
                if (form) {
                    form.appendChild(input);
                }

                const imageContainer = document.getElementById('gambar-' + idGambar);
                if (imageContainer) {
                    imageContainer.style.display = 'none';
                } else {
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
                            imageDiv.className = 'relative group bg-white rounded-lg overflow-hidden shadow-sm border border-gray-200';
                            imageDiv.innerHTML = `
                                <div class="aspect-square">
                                    <img src="${e.target.result}" 
                                         alt="Preview ${index + 1}" 
                                         class="w-full h-full object-cover">
                                </div>
                                <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-50 transition-all duration-200 flex items-center justify-center">
                                    <span class="opacity-0 group-hover:opacity-100 text-white text-xs font-medium bg-black bg-opacity-75 px-2 py-1 rounded">Preview ${index + 1}</span>
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