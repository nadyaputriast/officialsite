<x-app-layout>
    <div class="max-w-2xl mx-auto bg-white rounded-xl shadow-lg p-4 sm:p-8 mt-4 sm:mt-8">
        <h2 class="text-xl sm:text-2xl font-bold mb-6 text-gray-800">Edit Konten Download</h2>
        <form method="POST" action="{{ route('download.update', $download->id_download) }}" enctype="multipart/form-data" class="space-y-5">
            @csrf
            @method('PUT')
            <div>
                <label class="block text-gray-700 mb-1">Nama Konten</label>
                <input type="text" name="nama_download" value="{{ old('nama_download', $download->nama_download) }}"
                    class="w-full border rounded px-3 py-2 focus:ring focus:ring-blue-200" required>
            </div>
            <div>
                <label class="block text-gray-700 mb-1">Jenis Konten</label>
                <select name="jenis_konten" class="w-full border rounded px-3 py-2 focus:ring focus:ring-blue-200" required>
                    @foreach (['Materi Kuliah', 'Aplikasi', 'Manual Book', 'Source Code', 'Template', 'Dataset', 'E-book'] as $jenis)
                        <option value="{{ $jenis }}" @if (old('jenis_konten', $download->jenis_konten) == $jenis) selected @endif>
                            {{ $jenis }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-gray-700 mb-1">File Konten (biarkan kosong jika tidak ingin mengganti)</label>
                <input type="file" name="file_konten" class="w-full border rounded px-3 py-2">
                @if ($download->file_konten)
                    <div class="text-xs text-gray-500 mt-1">
                        File saat ini:
                        <a href="{{ asset('storage/' . $download->file_konten) }}" target="_blank"
                            class="underline text-blue-600 break-all">
                            {{ basename($download->file_konten) }}
                        </a>
                    </div>
                @endif
            </div>
            <div class="flex flex-col sm:flex-row gap-3">
                <button type="submit" class="w-full sm:w-auto px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Update</button>
                <a href="{{ route('download.show', $download->id_download) }}"
                    class="w-full sm:w-auto px-4 py-2 bg-gray-400 text-white rounded hover:bg-gray-500 text-center">Batal</a>
            </div>
        </form>
    </div>
</x-app-layout>