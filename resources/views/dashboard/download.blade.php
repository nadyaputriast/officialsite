{{-- Informasi Download Konten --}}
<section class="bg-[#DDF1FB]">
<div id="download-section" class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white rounded-xl p-6 shadow-md border hover:shadow-lg transition-all duration-300 hover:-translate-y-1 relative">
            <div class="p-6 text-gray-900">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-semibold">Informasi Download</h3>
                    @auth
                        <a href="{{ route('download.create') }}" 
                           class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                            + Tambah Download
                        </a>
                    @endauth
                </div>

                @if (auth()->user()->hasRole('admin'))
                    {{-- Tampilan untuk Admin --}}
                    <table class="table-auto w-full border-collapse border border-gray-300">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="border border-gray-300 px-4 py-2" rowspan="2">Nama Download</th>
                                <th class="border border-gray-300 px-4 py-2" rowspan="2">Jenis Konten</th>
                                <th class="border border-gray-300 px-4 py-2" rowspan="2">Komentar/Notifikasi</th>
                                <th class="border border-gray-300 px-4 py-2" rowspan="2">Status</th>
                                <th class="border border-gray-300 px-4 py-2" colspan="2">Aksi</th>
                            </tr>
                            <tr class="bg-gray-100">
                                <th class="border border-gray-300 px-4 py-2">Detail</th>
                                <th class="border border-gray-300 px-4 py-2">Validasi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($dataDownload as $download)
                                <tr>
                                    <td class="border border-gray-300 px-4 py-2">{{ $download->nama_download }}</td>
                                    <td class="border border-gray-300 px-4 py-2">{{ $download->jenis_konten }}</td>
                                    <td class="border border-gray-300 px-4 py-2">
                                        @php
                                            $notif = \App\Models\Notifikasi::where('notifiable_id', $download->id_download)
                                                ->where('notifiable_type', 'download')
                                                ->latest()
                                                ->first();
                                        @endphp
                                        {{ $notif->isi_notifikasi ?? '-' }}
                                    </td>
                                    <td class="border border-gray-300 px-4 py-2">
                                        @if ($download->status_download == 1)
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                ✓ Sudah Divalidasi
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                ⏳ Belum Divalidasi
                                            </span>
                                        @endif
                                    </td>
                                    <td class="border border-gray-300 px-4 py-2">
                                        <a href="{{ route('download.show', $download->id_download) }}"
                                            class="text-blue-500 hover:underline">Detail</a>
                                    </td>
                                    <td class="border border-gray-300 px-4 py-2">
                                        @if ($download->status_download == 0)
                                            <form action="{{ route('admin.download.validate', $download->id_download) }}"
                                                method="POST" class="inline">
                                                @csrf
                                                <button type="submit"
                                                    class="bg-green-600 text-white px-3 py-1 rounded text-sm hover:bg-green-700 transition">
                                                    Validasi
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-gray-500 text-sm">Sudah Divalidasi</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-gray-500 py-4">Tidak ada informasi download saat ini.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    {{-- Paginasi untuk Admin --}}
                    @if($dataDownload->hasPages())
                        <div class="mt-4">
                            {{ $dataDownload->links() }}
                        </div>
                    @endif
                @else
                    {{-- Tampilan untuk User Biasa dengan Search & Filter --}}
                    
                    {{-- Search & Filter Bar --}}
                    <div class="mb-6 bg-gray-50 rounded-lg p-4">
                        <form method="GET" action="{{ route('dashboard') }}#download-section" class="space-y-4">
                            <div class="grid md:grid-cols-3 gap-4">
                                {{-- Search Bar --}}
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Cari Download</label>
                                    <div class="relative">
                                        <input type="text" 
                                               name="search_download" 
                                               value="{{ request('search_download') }}"
                                               placeholder="Cari berdasarkan nama download..."
                                               class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center">
                                            <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"/>
                                            </svg>
                                        </div>
                                    </div>
                                </div>

                                {{-- Filter Status --}}
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                                    <select name="status_download" class="w-full py-2 px-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        <option value="">Semua Status</option>
                                        <option value="validated" {{ request('status_download') == 'validated' ? 'selected' : '' }}>Sudah Divalidasi</option>
                                        <option value="pending" {{ request('status_download') == 'pending' ? 'selected' : '' }}>Belum Divalidasi</option>
                                    </select>
                                </div>

                                {{-- Sort --}}
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Urutkan</label>
                                    <select name="sort_download" class="w-full py-2 px-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        <option value="latest" {{ request('sort_download') == 'latest' ? 'selected' : '' }}>Terbaru</option>
                                        <option value="oldest" {{ request('sort_download') == 'oldest' ? 'selected' : '' }}>Terlama</option>
                                        <option value="name" {{ request('sort_download') == 'name' ? 'selected' : '' }}>Nama A-Z</option>
                                    </select>
                                </div>
                            </div>

                            {{-- Multi-select Jenis Konten --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Jenis Konten</label>
                                <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                                    @php
                                        $jenisKontenOptions = [
                                            'Materi Kuliah' => 'Materi Kuliah',
                                            'Aplikasi' => 'Aplikasi',
                                            'Manual Book' => 'Manual Book',
                                            'Source Code' => 'Source Code',
                                            'Template' => 'Template',
                                            'Dataset' => 'Dataset',
                                            'E-book' => 'E-book',
                                        ];
                                        $selectedJenis = request('jenis_konten', []);
                                    @endphp

                                    @foreach($jenisKontenOptions as $value => $label)
                                        <label class="flex items-center space-x-2 cursor-pointer">
                                            <input type="checkbox" 
                                                   name="jenis_konten[]" 
                                                   value="{{ $value }}"
                                                   {{ in_array($value, $selectedJenis) ? 'checked' : '' }}
                                                   class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 focus:ring-2 rounded">
                                            <span class="text-sm text-gray-700">{{ $label }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            <div class="flex gap-3">
                                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition font-medium">
                                    Cari
                                </button>
                                <a href="{{ route('dashboard') }}#download-section" class="bg-gray-200 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-300 transition font-medium">
                                    Reset
                                </a>
                            </div>
                        </form>
                    </div>

                    {{-- Results Info --}}
                    <div class="mb-4 flex justify-between items-center">
                        <div class="text-sm text-gray-600">
                            Menampilkan {{ $dataDownload->count() }} dari {{ $dataDownload->total() }} download
                            @if(request('search_download'))
                                untuk "<strong>{{ request('search_download') }}</strong>"
                            @endif
                        </div>
                    </div>

                    {{-- Grid Download --}}
                    @forelse ($dataDownload as $download)
                        @if($loop->first)
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @endif
                        
                        <div class="bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow-md transition overflow-hidden">
                            {{-- Header --}}
                            <div class="p-4 border-b border-gray-100">
                                <div class="flex justify-between items-start mb-2">
                                    <h3 class="font-semibold text-lg line-clamp-2">
                                        {{ $download->nama_download }}
                                    </h3>
                                </div>

                                {{-- Download Info --}}
                                <div class="space-y-2 text-sm text-gray-600">
                                    {{-- Jenis Konten --}}
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"/>
                                        </svg>
                                        <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs rounded-full">
                                            {{ ucfirst(str_replace('_', ' ', $download->jenis_konten)) }}
                                        </span>
                                    </div>

                                    {{-- File Size jika ada --}}
                                    @if($download->ukuran_file)
                                        <div class="flex items-center gap-2">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                            </svg>
                                            <span>{{ $download->ukuran_file }}</span>
                                        </div>
                                    @endif

                                    {{-- Download Count jika ada --}}
                                    @if($download->jumlah_download)
                                        <div class="flex items-center gap-2">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"/>
                                            </svg>
                                            <span>{{ number_format($download->jumlah_download) }} downloads</span>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            {{-- Content --}}
                            <div class="p-4">
                                @if($download->deskripsi_download)
                                    <p class="text-gray-600 text-sm mb-4 line-clamp-3">
                                        {{ $download->deskripsi_download }}
                                    </p>
                                @endif

                                <div class="space-y-2">
                                    <a href="{{ route('download.show', $download->id_download) }}" 
                                       class="block w-full bg-blue-600 text-white text-center px-4 py-2 rounded-lg hover:bg-blue-700 transition font-medium">
                                        Lihat Detail
                                    </a>                                    
                                </div>
                            </div>
                        </div>
                        
                        @if($loop->last)
                            </div>
                        @endif
                    @empty
                        <div class="text-center py-12">
                            <div class="text-gray-400 mb-4">
                                <svg class="w-16 h-16 mx-auto" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM6.293 6.707a1 1 0 010-1.414l3-3a1 1 0 011.414 0l3 3a1 1 0 01-1.414 1.414L11 5.414V13a1 1 0 11-2 0V5.414L7.707 6.707a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">Tidak ada download</h3>
                            <p class="text-gray-600 mb-6">
                                @if(request()->hasAny(['search_download', 'jenis_konten', 'status_download']))
                                    Tidak ditemukan download yang sesuai dengan kriteria pencarian.
                                @else
                                    Belum ada konten download yang tersedia saat ini.
                                @endif
                            </p>
                            <a href="{{ route('download.create') }}" 
                               class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition">
                                + Tambah Download
                            </a>
                        </div>
                    @endforelse

                    {{-- Pagination --}}
                    @if($dataDownload->hasPages())
                        <div class="mt-8">
                            {{ $dataDownload->appends(request()->query())->links() }}
                        </div>
                    @endif
                @endif
            </div>
        </div>
    </div>
</div>

<style>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
.line-clamp-3 {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
</section>