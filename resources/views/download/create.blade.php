{{-- filepath: resources/views/download/create.blade.php --}}
<x-app-layout>
    <h2 class="text-lg font-semibold mb-4">Upload Konten Download</h2>
    <form action="{{ route('download.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
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

        <div>
            <label for="nama_download" class="block text-sm font-medium text-gray-700">Nama Konten:</label>
            <input type="text" name="nama_download" id="nama_download"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
        </div>

        <div>
            <label for="jenis_konten" class="block text-sm font-medium text-gray-700">Jenis Konten:</label>
            <select name="jenis_konten" id="jenis_konten" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                required>
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
            <label for="file_konten" class="block text-sm font-medium text-gray-700">File Konten:</label>
            <input type="file" name="file_konten" id="file_konten"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
        </div>

        <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Upload</button>
        <a href="{{ route('dashboard') }}" class="px-4 py-2 text-black rounded">Kembali</a>
    </form>
</x-app-layout>
