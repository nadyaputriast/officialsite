<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Portofolio') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg">
                <div class="px-7 py-4 bg-white">
                    <form action="{{ route('portofolio.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
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

                        {{-- Nama Portofolio --}}
                        <div class="space-y-2">
                            <label for="nama_portofolio" class="block text-sm font-semibold text-gray-700">
                                Nama Portofolio <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="nama_portofolio" id="nama_portofolio"
                                class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out"
                                placeholder="Masukkan nama portofolio"
                                required>
                        </div>

                        {{-- Kategori Portofolio --}}
                        <div class="space-y-3">
                            <label class="block text-sm font-semibold text-gray-700">
                                Kategori <span class="text-red-500">*</span>
                            </label>
                            <div class="bg-gray-50 p-4 rounded-md border border-gray-200">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                    <div class="flex items-center">
                                        <input type="checkbox" name="kategori_portofolio[]" id="uiux"
                                            value="UI/UX Design"
                                            class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                        <label for="uiux" class="ml-3 text-sm font-medium text-gray-700">UI/UX Design</label>
                                    </div>
                                    <div class="flex items-center">
                                        <input type="checkbox" name="kategori_portofolio[]" id="webdev"
                                            value="Website Development"
                                            class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                        <label for="webdev" class="ml-3 text-sm font-medium text-gray-700">Website Development</label>
                                    </div>
                                    <div class="flex items-center">
                                        <input type="checkbox" name="kategori_portofolio[]" id="mobiledev"
                                            value="Mobile Development"
                                            class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                        <label for="mobiledev" class="ml-3 text-sm font-medium text-gray-700">Mobile Development</label>
                                    </div>
                                    <div class="flex items-center">
                                        <input type="checkbox" name="kategori_portofolio[]" id="gamedev"
                                            value="Game Development"
                                            class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                        <label for="gamedev" class="ml-3 text-sm font-medium text-gray-700">Game Development</label>
                                    </div>
                                    <div class="flex items-center">
                                        <input type="checkbox" name="kategori_portofolio[]" id="iot"
                                            value="Internet of Things"
                                            class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                        <label for="iot" class="ml-3 text-sm font-medium text-gray-700">Internet of Things</label>
                                    </div>
                                    <div class="flex items-center">
                                        <input type="checkbox" name="kategori_portofolio[]" id="ml" value="ML/AI"
                                            class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                        <label for="ml" class="ml-3 text-sm font-medium text-gray-700">ML/AI</label>
                                    </div>
                                    <div class="flex items-center">
                                        <input type="checkbox" name="kategori_portofolio[]" id="blockchain"
                                            value="BlockChain"
                                            class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                        <label for="blockchain" class="ml-3 text-sm font-medium text-gray-700">Blockchain</label>
                                    </div>
                                    <div class="flex items-center">
                                        <input type="checkbox" name="kategori_portofolio[]" id="cybersecurity"
                                            value="Cyber Security"
                                            class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                        <label for="cybersecurity" class="ml-3 text-sm font-medium text-gray-700">Cyber Security</label>
                                    </div>
                                </div>
                                <p class="text-xs text-gray-500 mt-2">Pilih satu atau lebih kategori</p>
                            </div>
                        </div>

                        {{-- Deskripsi --}}
                        <div class="space-y-2">
                            <label for="deskripsi_portofolio" class="block text-sm font-semibold text-gray-700">
                                Deskripsi <span class="text-red-500">*</span>
                            </label>
                            <textarea name="deskripsi_portofolio" id="deskripsi_portofolio" rows="4"
                                class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out"
                                placeholder="Jelaskan portofolio Anda secara detail..."
                                required></textarea>
                        </div>

                        {{-- Gambar --}}
                        <div class="space-y-2">
                            <label for="gambar_portofolio" class="block text-sm font-semibold text-gray-700">
                                Gambar Portofolio <span class="text-red-500">*</span>
                            </label>
                            <div class="bg-gray-50 p-4 rounded-md border border-gray-200">
                                <div id="gambar-container" class="space-y-3">
                                    <div class="flex items-center gap-3">
                                        <input type="file" name="gambar_portofolio[]" id="gambar_portofolio"
                                            class="flex-1 px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out file:mr-4 file:py-1 file:px-3 file:rounded-md file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                                            accept="image/*" required>
                                        <button type="button"
                                            class="px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition duration-150 ease-in-out"
                                            onclick="addGambar()">
                                            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                            </svg>
                                            Tambah
                                        </button>
                                    </div>
                                </div>
                                <p class="text-xs text-gray-500 mt-2">Unggah gambar (JPG, PNG, GIF). Maksimal 2MB per gambar.</p>
                            </div>
                        </div>

                        {{-- Tautan --}}
                        <div class="space-y-2">
                            <label for="tautan_portofolio" class="block text-sm font-semibold text-gray-700">
                                Tautan Portofolio <span class="text-red-500">*</span>
                            </label>
                            <div class="bg-gray-50 p-4 rounded-md border border-gray-200">
                                <div id="tautan-container" class="space-y-3">
                                    <div class="flex items-center gap-3">
                                        <input type="text" name="tautan_portofolio[]"
                                            class="flex-1 px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out"
                                            placeholder="https://example.com" required>
                                        <button type="button"
                                            class="px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition duration-150 ease-in-out"
                                            onclick="addTautan()">
                                            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                            </svg>
                                            Tambah
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Tools --}}
                        <div class="space-y-2">
                            <label for="tools_portofolio" class="block text-sm font-semibold text-gray-700">
                                Tools Portofolio <span class="text-red-500">*</span>
                            </label>
                            <div class="bg-gray-50 p-4 rounded-md border border-gray-200">
                                <div id="tools-container" class="space-y-3">
                                    <div class="flex items-center gap-3">
                                        <input type="text" name="tools_portofolio[]"
                                            class="flex-1 px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out"
                                            placeholder="Masukkan tools yang digunakan" required>
                                        <button type="button"
                                            class="px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition duration-150 ease-in-out"
                                            onclick="addTools()">
                                            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                            </svg>
                                            Tambah
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Dokumen Pendukung --}}
                        <div class="space-y-2">
                            <label for="dokumen_portofolio" class="block text-sm font-semibold text-gray-700">
                                Dokumen Portofolio <span class="text-red-500">*</span>
                            </label>
                            <input type="file" name="dokumen_portofolio" id="dokumen_portofolio"
                                class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out file:mr-4 file:py-1 file:px-3 file:rounded-md file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                                accept=".pdf,.doc,.docx,.zip" required>
                            <p class="text-xs text-gray-500 mt-1">Unggah dokumen (PDF, DOC, DOCX, ZIP). Maksimal 20MB.</p>
                        </div>

                        {{-- Tag Pengguna --}}
                        <div class="space-y-2">
                            <label for="user_tags" class="block text-sm font-semibold text-gray-700">Tag Pengguna</label>
                            <input type="text" name="user_tags" id="user_tags" 
                                class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out"
                                placeholder="@username1, @username2">
                            <p class="text-xs text-gray-500 mt-1">Tag pengguna lain (pisahkan dengan koma), misal @nama1</p>
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
                                Simpan Portofolio
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Setup tag pengguna
            new TomSelect('#user_tags', {
                plugins: ['remove_button'],
                delimiter: ',',
                persist: false,
                createOnBlur: true,
                create: function(input) {
                    // Hanya buat tag jika dimulai dengan @
                    if (input.startsWith('@')) {
                        return {
                            value: input,
                            text: input
                        };
                    }
                    return false;
                },
                render: {
                    option_create: function(data, escape) {
                        return '<div class="create">Tag <strong>' + escape(data.input) +
                            '</strong>&hellip;</div>';
                    },
                    item: function(data, escape) {
                        return '<div>' + escape(data.value) + '</div>';
                    }
                },
                onItemAdd: function(value) {
                    // Cek jika tag valid (mulai dengan @)
                    if (!value.startsWith('@')) {
                        this.removeItem(value);
                    }
                }
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            const input = document.getElementById('gambar_portofolio');
            const preview = document.getElementById('image-preview');

            if (input && preview) {
                input.addEventListener('change', function() {
                    preview.innerHTML = ''; // Clear previous previews

                    if (this.files) {
                        Array.from(this.files).forEach(file => {
                            if (!file.type.match('image.*')) {
                                return;
                            }

                            const reader = new FileReader();
                            reader.onload = function(e) {
                                const div = document.createElement('div');
                                div.className = 'relative border rounded p-2';

                                const img = document.createElement('img');
                                img.src = e.target.result;
                                img.className = 'w-full h-32 object-cover rounded';
                                img.alt = 'Image Preview';

                                div.appendChild(img);
                                preview.appendChild(div);
                            }

                            reader.readAsDataURL(file);
                        });
                    }
                });
            }
        });

        function addTautan() {
            const container = document.getElementById('tautan-container');
            const newRow = document.createElement('div');
            newRow.classList.add('flex', 'items-center', 'gap-3');
            newRow.innerHTML = `
                <input type="text" name="tautan_portofolio[]" 
                    class="flex-1 px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out"
                    placeholder="https://example.com" required>
                <button type="button" 
                    class="px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition duration-150 ease-in-out"
                    onclick="removeTautan(this)">
                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                    Hapus
                </button>
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
            newRow.classList.add('flex', 'items-center', 'gap-3');
            newRow.innerHTML = `
                <input type="text" name="tools_portofolio[]" 
                    class="flex-1 px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out"
                    placeholder="Masukkan tools yang digunakan" required>
                <button type="button" 
                    class="px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition duration-150 ease-in-out"
                    onclick="removeTools(this)">
                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                    Hapus
                </button>
            `;
            container.appendChild(newRow);
        }

        function removeTools(button) {
            const row = button.parentElement;
            row.remove();
        }

        function addGambar() {
            const container = document.getElementById('gambar-container');
            const newRow = document.createElement('div');
            newRow.classList.add('flex', 'items-center', 'gap-3');
            newRow.innerHTML = `
                <input type="file" name="gambar_portofolio[]" 
                    class="flex-1 px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out file:mr-4 file:py-1 file:px-3 file:rounded-md file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                    accept="image/*" required>
                <button type="button" 
                    class="px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition duration-150 ease-in-out"
                    onclick="removeGambar(this)">
                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                    Hapus
                </button>
            `;
            container.appendChild(newRow);
        }

        function removeGambar(button) {
            const row = button.parentElement;
            row.remove();
        }
    </script>
</x-app-layout>