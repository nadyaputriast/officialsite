<x-app-layout>
    <div class="max-w-2xl mx-auto bg-white rounded-xl shadow-lg p-4 sm:p-8 mt-4 sm:mt-8">
        <h2 class="text-xl sm:text-2xl font-bold mb-6 text-gray-800 flex items-center gap-2">
            <svg class="w-6 h-6 sm:w-7 sm:h-7 text-blue-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M12 4v16m8-8H4" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            Upload Konten Download
        </h2>
        <form action="{{ route('download.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf

            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $salah)
                            <li>{{ $salah }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (Session::has('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    {{ Session::get('error') }}
                </div>
            @endif

            <div>
                <label for="nama_download" class="block text-sm font-medium text-gray-700 mb-1">Nama Konten</label>
                <input type="text" name="nama_download" id="nama_download"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
            </div>
            <div>
                <label for="jenis_konten" class="block text-sm font-medium text-gray-700 mb-1">Jenis Konten</label>
                <select name="jenis_konten" id="jenis_konten"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                    <option value="Materi Kuliah">Materi Kuliah</option>
                    <option value="Aplikasi">Aplikasi</option>
                    <option value="Manual Book">Manual Book</option>
                    <option value="Source Code">Source Code</option>
                    <option value="Template">Template</option>
                    <option value="Dataset">Dataset</option>
                    <option value="E-book">E-book</option>
                </select>
            </div>
            <div>
                <label for="file_konten" class="block text-sm font-medium text-gray-700 mb-1">File Konten</label>
                <input type="file" name="file_konten" id="file_konten"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                <p class="text-xs text-gray-500 mt-1">Format: PDF, DOCX, ZIP, SQL, JSON, CSV, EXE, PPTX, dsb. Max: 20MB</p>
            </div>
            <div class="flex flex-col sm:flex-row gap-3">
                <button type="submit"
                    class="w-full sm:w-auto px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition font-semibold">
                    Upload
                </button>
                <a href="{{ route('dashboard') }}"
                    class="w-full sm:w-auto px-6 py-2 bg-gray-500 text-white rounded hover:bg-gray-600 transition font-semibold text-center">
                    Kembali
                </a>
            </div>
        </form>
    </div>
</x-app-layout>