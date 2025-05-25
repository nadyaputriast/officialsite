{{-- Informasi Download Konten --}}
<div id="download-section" class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <h3 class="text-lg font-semibold mb-4">Informasi Download</h3>
                <a href="{{ route('download.create') }}" class="text-red-500 mb-4 inline-block">Tambah
                    Download</a>

                @if (auth()->user()->hasRole('admin'))
                    {{-- Tampilan untuk Admin --}}
                    <table class="table-auto w-full border-collapse border border-gray-300">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="border border-gray-300 px-4 py-2" rowspan="2">Nama Download</th>
                                <th class="border border-gray-300 px-4 py-2" rowspan="2">Jenis Konten</th>
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
                                    <td class="border border-gray-300 px-4 py-2">
                                        {{ $download->nama_download }}</td>
                                    <td class="border border-gray-300 px-4 py-2">
                                        {{ $download->jenis_konten }}</td>
                                    </td>
                                    <td class="border border-gray-300 px-4 py-2">
                                        @if ($download->status_download == 1)
                                            <span class="text-green-500">Sudah Divalidasi</span>
                                        @else
                                            <span class="text-red-500">Belum Divalidasi</span>
                                        @endif
                                    </td>
                                    <td class="border border-gray-300 px-4 py-2">
                                        <a href="{{ route('download.show', $download->id_download) }}"
                                            class="text-blue-500 hover:underline">Detail</a>
                                    </td>
                                    <td class="border border-gray-300 px-4 py-2">
                                        @if ($download->status_download == 0)
                                            <form action="{{ route('download.validate', $download->id_download) }}"
                                                method="POST" class="inline">
                                                @csrf
                                                <button type="submit"
                                                    class="text-blue-500 hover:underline">Validasi</button>
                                            </form>
                                        @else
                                            <span class="text-gray-500">Sudah Divalidasi</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-gray-500 py-4">Tidak ada informasi
                                        sertifikasi saat ini.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    {{-- Paginasi untuk Admin --}}
                    <div class="mt-4">
                        {{ $dataDownload->links() }}
                    </div>
                @else
                    {{-- Tampilan untuk User Biasa --}}
                    @forelse ($dataDownload as $download)
                        <div class="mb-4">
                            <h3 class="font-bold">{{ $download->nama_download }}</h3>
                            <p>{{ $download->jenis_konten }}</p>
                            <p>Status Validasi:
                                @if ($download->status_download == 1)
                                    <span class="text-green-500">Sudah Divalidasi</span>
                                @else
                                    <span class="text-red-500">Belum Divalidasi</span>
                                @endif
                            </p>
                            <a href="{{ route('download.show', $download->id_download) }}" class="text-black-500">Lihat
                                Detail</a>
                        </div>
                    @empty
                        <p class="text-gray-500">Tidak ada informasi download saat ini.</p>
                    @endforelse
                @endif
            </div>
        </div>
    </div>
</div>