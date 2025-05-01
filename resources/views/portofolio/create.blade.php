<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Portofolio') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('portofolio.store') }}" method="POST" enctype="multipart/form-data">
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

                        {{-- Nama Portofolio --}}
                        <div class="mb-4">
                            <label for="nama_portofolio" class="block text-sm font-medium text-gray-700">Nama
                                Portofolio</label>
                            <input type="text" name="nama_portofolio" id="nama_portofolio"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                required>
                        </div>

                        {{--['ML/AI', 'Blockchain', 'Cyber Security'];
 --}}
                        {{-- Kategori Portofolio --}}
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Kategori</label>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                                <div class="flex items-center">
                                    <input type="checkbox" name="kategori_portofolio[]" id="uiux"
                                        value="UI/UX Design"
                                        class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                    <label for="uiux" class="ml-3 text-sm text-gray-700">UI/UX Design</label>
                                </div>
                                <div class="flex items-center">
                                    <input type="checkbox" name="kategori_portofolio[]" id="webdev"
                                        value="Website Development"
                                        class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                    <label for="webdev" class="ml-3 text-sm text-gray-700">Website Development</label>
                                </div>
                                <div class="flex items-center">
                                    <input type="checkbox" name="kategori_portofolio[]" id="mobiledev"
                                        value="Mobile Development"
                                        class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                    <label for="mobiledev" class="ml-3 text-sm text-gray-700">Mobile Development</label>
                                </div>
                                <div class="flex items-center">
                                    <input type="checkbox" name="kategori_portofolio[]" id="gamedev"
                                        value="Game Development"
                                        class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                    <label for="gamedev" class="ml-3 text-sm text-gray-700">Game Development</label>
                                </div>
                                <div class="flex items-center">
                                    <input type="checkbox" name="kategori_portofolio[]" id="iot"
                                        value="Internet of Things"
                                        class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                    <label for="iot" class="ml-3 text-sm text-gray-700">Internet of Things</label>
                                </div>
                                <div class="flex items-center">
                                    <input type="checkbox" name="kategori_portofolio[]" id="ml"
                                        value="ML/AI"
                                        class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                    <label for="ml" class="ml-3 text-sm text-gray-700">ML/AI</label>
                                </div>
                                <div class="flex items-center">
                                    <input type="checkbox" name="kategori_portofolio[]" id="blockchain" value="BlockChain"
                                        class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                    <label for="blockchain" class="ml-3 text-sm text-gray-700">Blockchain</label>
                                </div>
                                <div class="flex items-center">
                                    <input type="checkbox" name="kategori_portofolio[]" id="cybersecurity" value="Cyber Security"
                                        class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                    <label for="cybersecurity" class="ml-3 text-sm text-gray-700">Cyber Security</label>
                                </div>
                            </div>
                            <p class="text-xs text-gray-500 mt-1">Pilih satu atau lebih kategori</p>
                        </div>

                        {{-- Deskripsi --}}
                        <div class="mb-4">
                            <label for="deskripsi_portofolio"
                                class="block text-sm font-medium text-gray-700">Deskripsi</label>
                            <textarea name="deskripsi_portofolio" id="deskripsi_portofolio" rows="4"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                required></textarea>
                        </div>

                        {{-- Gambar --}}
                        <div class="mb-4">
                            <label for="gambar_portofolio" class="block text-sm font-medium text-gray-700">Gambar
                                Portofolio</label>
                            <input type="file" name="gambar_portofolio[]" id="gambar_portofolio"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                required>
                            <p class="text-xs text-gray-500 mt-1">Unggah gambar (JPG, PNG, GIF). Maksimal 2MB per
                                gambar.</p>
                            <div id="image-preview" class="mt-2 grid grid-cols-3 gap-2"></div>
                        </div>

                        {{-- Tautan --}}
                        <div class="mb-4">
                            <label for="tautan_portofolio" class="block text-sm font-medium text-gray-700">Tautan
                                Portofolio</label>
                            <div id="tautan-container">
                                <div class="flex items-center mb-2">
                                    <input type="text" name="tautan_portofolio[]"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                        placeholder="Masukkan tautan" required>
                                    <button type="button"
                                        class="ml-2 px-3 py-1 bg-green-500 text-black rounded hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-opacity-50"
                                        onclick="addTautan()">Add</button>
                                </div>
                            </div>
                        </div>

                        {{-- Tools --}}
                        <div class="mb-4">
                            <label for="tools_portofolio" class="block text-sm font-medium text-gray-700">Tools
                                Portofolio</label>
                            <div id="tools-container">
                                <div class="flex items-center mb-2">
                                    <input type="text" name="tools_portofolio[]"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                        placeholder="Masukkan tools" required>
                                    <button type="button"
                                        class="ml-2 px-3 py-1 bg-green-500 text-black rounded hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-opacity-50"
                                        onclick="addTools()">Add</button>
                                </div>
                            </div>
                        </div>

                        {{-- Dokumen --}}
                        <div class="mb-4">
                            <label for="dokumen_portofolio" class="block text-sm font-medium text-gray-700">Dokumen
                                Portofolio</label>
                            <input type="file" name="dokumen_portofolio" id="dokumen_portofolio"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                required>
                            <p class="text-xs text-gray-500 mt-1">Unggah dokumen (PDF, DOC, DOCX, ZIP). Maksimal 20MB.
                            </p>
                        </div>

                        {{-- Tag Pengguna --}}
                        <div class="form-group">
                            <label for="user_tags">Tag Pengguna</label>
                            <p class="text-xs text-gray-500 mb-1">Tag pengguna lain(pisahkan dengan koma), misal @nama1
                            </p>
                            <input type="text" name="user_tags" id="user_tags" class="form-control">
                        </div>

                        <button type="submit"
                            class="px-4 py-c2 bg-blue-500 text-black rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">Simpan</button>

                        {{-- Tombol Kembali --}}
                        <a href="{{ route('dashboard') }}" class="px-4 py-c2 text-white rounded">Kembali</a>
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
            const container = document.getElementById('tautan-container'); // ID yang benar
            const newRow = document.createElement('div');
            newRow.classList.add('flex', 'items-center', 'mb-2');
            newRow.innerHTML = `
        <input type="text" name="tautan_portofolio[]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
            placeholder="Masukkan tautan" required>
        <button type="button" class="ml-2 px-3 py-1 bg-red-500 text-black rounded hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50"
            onclick="removeTautan(this)">Remove</button>
    `;
            container.appendChild(newRow);
        }

        function removeTautan(button) {
            const row = button.parentElement;
            row.remove();
        }

        function addTools() {
            const container = document.getElementById('tools-container'); // ID yang benar
            const newRow = document.createElement('div');
            newRow.classList.add('flex', 'items-center', 'mb-2');
            newRow.innerHTML = `
        <input type="text" name="tools_portofolio[]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
            placeholder="Masukkan tools" required>
        <button type="button" class="ml-2 px-3 py-1 bg-red-500 text-black rounded hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50"
            onclick="removeTools(this)">Remove</button>
    `;
            container.appendChild(newRow);
        }

        function removeTools(button) {
            const row = button.parentElement;
            row.remove();
        }
    </script>
</x-app-layout>
