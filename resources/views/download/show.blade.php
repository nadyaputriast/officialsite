{{-- filepath: c:\laragon\www\officialsite\resources\views\download\show.blade.php --}}
<x-app-layout>
    <div class="max-w-2xl mx-auto bg-white rounded-xl shadow-lg p-4 sm:p-8 mt-4 sm:mt-8">
        <h2 class="text-xl sm:text-2xl font-bold mb-6 text-gray-800 flex items-center gap-2">
            Detail Konten Download
        </h2>
        <div class="mb-6">
            <div class="text-sm text-gray-500 mb-1">Nama Konten</div>
            <div class="text-lg font-semibold text-gray-900 break-words">{{ $download->nama_download }}</div>
        </div>
        <div class="mb-6">
            <div class="text-sm text-gray-500 mb-1">Jenis Konten</div>
            <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold
                @switch($download->jenis_konten)
                    @case('Materi Kuliah') bg-blue-100 text-blue-700 @break
                    @case('Aplikasi') bg-green-100 text-green-700 @break
                    @case('Manual Book') bg-yellow-100 text-yellow-700 @break
                    @case('Source Code') bg-purple-100 text-purple-700 @break
                    @case('Template') bg-pink-100 text-pink-700 @break
                    @case('Dataset') bg-orange-100 text-orange-700 @break
                    @case('E-book') bg-indigo-100 text-indigo-700 @break
                    @default bg-gray-100 text-gray-700
                @endswitch
            ">
                {{ $download->jenis_konten }}
            </span>
        </div>
        <div class="mb-8">
            @if (in_array($download->jenis_konten, ['Materi Kuliah', 'Manual Book', 'E-book']))
                @if (Str::endsWith(strtolower($download->file_konten), '.pdf'))
                    <div class="mb-3">
                        <iframe src="{{ asset('storage/' . $download->file_konten) }}"
                            class="w-full h-64 sm:h-96 rounded border" frameborder="0"></iframe>
                    </div>
                @else
                    <div class="mb-3">
                        <span class="font-semibold text-gray-700">Preview File</span>
                        <pre class="bg-gray-100 text-gray-800 rounded p-3 overflow-x-auto text-xs max-h-48 mb-2">
{{ \Illuminate\Support\Str::limit(file_exists(storage_path('app/public/' . $download->file_konten)) ? file_get_contents(storage_path('app/public/' . $download->file_konten)) : 'Tidak dapat menampilkan preview.', 800, "\n... (potongan file)") }}
                        </pre>
                    </div>
                @endif
                <a href="{{ asset('storage/' . $download->file_konten) }}" download
                    class="inline-block w-full sm:w-auto px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 text-center">
                    Download File
                </a>
            @elseif($download->jenis_konten == 'Source Code')
                @php
                    $filePath = storage_path('app/public/' . $download->file_konten);
                    $codePreview = '';
                    if (file_exists($filePath)) {
                        $codePreview = file_get_contents($filePath);
                        $codePreview = Str::limit($codePreview, 800, "\n... (potongan kode)");
                    }
                @endphp
                <div class="mb-3">
                    <span class="font-semibold text-gray-700">Preview Source Code</span>
                    <pre id="code-preview" class="bg-gray-900 text-green-200 rounded p-4 overflow-x-auto text-xs max-h-64 mb-3">{{ $codePreview }}</pre>
                    <div class="flex flex-col sm:flex-row gap-2 items-stretch sm:items-center">
                        <button type="button"
                            onclick="
                                navigator.clipboard.writeText(document.getElementById('code-preview').innerText).then(function() {
                                    let msg = document.getElementById('copied-msg');
                                    msg.classList.remove('hidden');
                                    setTimeout(function() {
                                        msg.classList.add('hidden');
                                    }, 1500);
                                });
                            "
                            class="w-full sm:w-auto px-4 py-2 bg-purple-600 text-white rounded hover:bg-purple-700">
                            Copy
                        </button>
                        <a href="{{ asset('storage/' . $download->file_konten) }}" download
                            class="w-full sm:w-auto px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 text-center">
                            Download File
                        </a>
                    </div>
                    <span id="copied-msg" class="block mt-2 text-green-600 text-s font-semibold hidden">Copied!</span>
                </div>
            @elseif($download->jenis_konten == 'Dataset')
                <a href="{{ asset('storage/' . $download->file_konten) }}" download
                    class="inline-block w-full sm:w-auto px-4 py-2 bg-orange-600 text-white rounded hover:bg-orange-700 text-center">
                    Download Dataset
                </a>
            @elseif($download->jenis_konten == 'Aplikasi')
                <a href="{{ asset('storage/' . $download->file_konten) }}" download
                    class="inline-block w-full sm:w-auto px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 text-center">
                    Download Aplikasi
                </a>
            @elseif($download->jenis_konten == 'Template')
                <a href="{{ asset('storage/' . $download->file_konten) }}" download
                    class="inline-block w-full sm:w-auto px-4 py-2 bg-pink-600 text-white rounded hover:bg-pink-700 text-center">
                    Download Template
                </a>
            @else
                <a href="{{ asset('storage/' . $download->file_konten) }}" download
                    class="inline-block w-full sm:w-auto px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700 text-center">
                    Download File
                </a>
            @endif
        </div>
        <div class="flex flex-col sm:flex-row gap-2">
            <a href="{{ route('dashboard') }}"
                class="w-full sm:w-auto px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600 text-center">
                Kembali
            </a>
            @if (auth()->id() === $download->id_pengguna)
                <a href="{{ route('download.edit', $download->id_download) }}"
                    class="w-full sm:w-auto px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 text-center">
                    Edit Download
                </a>
            @endif
        </div>
    </div>
</x-app-layout>