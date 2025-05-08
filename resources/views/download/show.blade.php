{{-- filepath: resources/views/download/view.blade.php --}}
<x-app-layout>
    <h2 class="text-lg font-semibold mb-4">Detail Konten Download</h2>
    <div class="space-y-4">
        <div>
            <strong>Nama Download:</strong> {{ $download->nama_download }}
        </div>
        <div>
            <strong>Jenis Konten:</strong> {{ $download->jenis_konten }}
        </div>
        <div>
            <strong>File Konten:</strong>
            <a href="{{ asset('storage/' . $download->file_konten) }}" target="_blank" class="text-blue-500 hover:underline">
                Lihat File
            </a>
        </div>
    </div>
    <a href="{{ route('dashboard') }}" class="mt-4 inline-block px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">Kembali</a>
</x-app-layout>