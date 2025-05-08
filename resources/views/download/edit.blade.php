{{-- filepath: resources/views/download/edit.blade.php --}}
<x-app-layout>
    <h2 class="text-lg font-semibold mb-4">Edit Konten Download</h2>
    <form action="{{ route('download.update', $download->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf
        @method('PUT')
        <div>
            <label for="nama_download" class="block text-sm font-medium text-gray-700">Nama Konten:</label>
            <input type="text" name="nama_download" id="nama_download" value="{{ $download->nama_download }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
        </div>

        <div>
            <label for="jenis_konten" class="block text-sm font-medium text-gray-700">Jenis Konten:</label>
            <select name="jenis_konten" id="jenis_konten" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                <option value="Materi Kuliah" {{ $download->jenis_konten == 'Materi Kuliah' ? 'selected' : '' }}>Materi Kuliah</option>
                <option value="Aplikasi" {{ $download->jenis_konten == 'Aplikasi' ? 'selected' : '' }}>Aplikasi</option>
                <option value="Manual Book" {{ $download->jenis_konten == 'Manual Book' ? 'selected' : '' }}>Manual Book</option>
                <option value="Source Code" {{ $download->jenis_konten == 'Source Code' ? 'selected' : '' }}>Source Code</option>
                <option value="Template" {{ $download->jenis_konten == 'Template' ? 'selected' : '' }}>Template</option>
                <option value="Dataset" {{ $download->jenis_konten == 'Dataset' ? 'selected' : '' }}>Dataset</option>
                <option value="E-book" {{ $download->jenis_konten == 'E-book' ? 'selected' : '' }}>E-book</option>
            </select>
        </div>

        <div>
            <label for="file_konten" class="block text-sm font-medium text-gray-700">File Konten:</label>
            <input type="file" name="file_konten" id="file_konten" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
            <p class="text-sm text-gray-500 mt-1">Kosongkan jika tidak ingin mengganti file.</p>
        </div>

        <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Simpan Perubahan</button>
    </form>
</x-app-layout>