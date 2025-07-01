<section class="bg-[#DDF1FB]">
    <div id="sertifikasi-section" class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-semibold">Informasi Sertifikasi</h3>
                    </div>

                    @if (auth()->user()->hasRole('admin'))
                        {{-- FILTER & SEARCH SECTION --}}
                        <div class="mb-6 bg-gray-50 rounded-lg p-4">
                            <form method="GET" class="space-y-4">
                                <input type="hidden" name="tab" value="sertifikasi">

                                <div class="grid md:grid-cols-4 gap-4">
                                    {{-- Search Bar --}}
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Cari
                                            Sertifikasi</label>
                                        <input type="text" name="search_sertifikasi"
                                            value="{{ request('search_sertifikasi') }}"
                                            placeholder="Cari berdasarkan nama sertifikasi..."
                                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    </div>

                                    {{-- Filter Status --}}
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Status
                                            Sertifikasi</label>
                                        <select name="status_sertifikasi"
                                            class="w-full py-2 px-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                            <option value="">Semua Status</option>
                                            <option value="1"
                                                {{ request('status_sertifikasi') == '1' ? 'selected' : '' }}>Sudah
                                                Divalidasi
                                            </option>
                                            <option value="0"
                                                {{ request('status_sertifikasi') == '0' ? 'selected' : '' }}>Belum
                                                Divalidasi
                                            </option>
                                        </select>
                                    </div>

                                    {{-- Filter Masa berlaku --}}
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Filter Masa
                                            Berlaku</label>
                                        <select name="masa_berlaku_filter"
                                            class="w-full py-2 px-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                            <option value="">Semua Masa Berlaku</option>
                                            <option value="seumur_hidup"
                                                {{ request('masa_berlaku_filter') == 'seumur_hidup' ? 'selected' : '' }}>
                                                Seumur Hidup
                                            </option>
                                            <option value="kurang_dari_5"
                                                {{ request('masa_berlaku_filter') == 'kurang_dari_5' ? 'selected' : '' }}>
                                                1-5 Tahun
                                            </option>
                                            <option value="kurang_dari_10"
                                                {{ request('masa_berlaku_filter') == 'kurang_dari_10' ? 'selected' : '' }}>
                                                6-10 Tahun
                                            </option>
                                            <option value="10+"
                                                {{ request('masa_berlaku_filter') == '10+' ? 'selected' : '' }}>Lebih
                                                Dari 10 Tahun
                                            </option>
                                        </select>
                                    </div>

                                    {{-- Sort --}}
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Urutkan</label>
                                        <select name="sort"
                                            class="w-full py-2 px-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                            <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>
                                                Terbaru</option>
                                            <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>
                                                Terlama</option>
                                            <option value="name_asc"
                                                {{ request('sort') == 'name_asc' ? 'selected' : '' }}>
                                                Nama A-Z</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="flex gap-3">
                                    <button type="submit"
                                        class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition font-medium">
                                        Cari
                                    </button>
                                    <a href="{{ route('dashboard', ['tab' => 'sertifikasi']) }}"
                                        class="bg-gray-200 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-300 transition font-medium">
                                        Reset
                                    </a>
                                </div>
                            </form>
                        </div>

                        {{-- TABLE SECTION --}}
                        <div class="overflow-x-auto">
                            <table class="table-auto w-full border-collapse border border-gray-300">
                                <thead>
                                    <tr class="bg-gray-100">
                                        <th class="border border-gray-300 px-4 py-2">Nama Sertifikasi</th>
                                        <th class="border border-gray-300 px-4 py-2">Deskripsi</th>
                                        <th class="border border-gray-300 px-4 py-2">Penyelenggara</th>
                                        <th class="border border-gray-300 px-4 py-2">Tanggal</th>
                                        <th class="border border-gray-300 px-4 py-2">Masa Berlaku</th>
                                        <th class="border border-gray-300 px-4 py-2">File</th>
                                        <th class="border border-gray-300 px-4 py-2">Komentar</th>
                                        <th class="border border-gray-300 px-4 py-2">Status</th>
                                        <th class="border border-gray-300 px-4 py-2">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($dataSertifikasi as $sertifikasi)
                                        <tr class="hover:bg-gray-50">
                                            <td class="border border-gray-300 px-4 py-2">
                                                <div class="font-medium">{{ $sertifikasi->nama_sertifikasi }}</div>
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2">
                                                <div class="max-w-xs">
                                                    {{ Str::limit($sertifikasi->deskripsi_sertifikasi, 100) }}
                                                </div>
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2">
                                                    {{ $sertifikasi->penyelenggara }}
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2">
                                                <div class="text-sm">
                                                    {{ \Carbon\Carbon::parse($sertifikasi->tanggal_sertifikasi)->format('d M Y') }}
                                                </div>
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2">
                                                @if ($sertifikasi->masa_berlaku == 0)
                                                    Seumur Hidup
                                                @else
                                                    {{ $sertifikasi->masa_berlaku }} Tahun
                                                @endif
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2">
                                                @if ($sertifikasi->file_sertifikasi)
                                                    <a href="{{ Storage::url($sertifikasi->file_sertifikasi) }}"
                                                        target="_blank" class="text-blue-600 hover:underline">
                                                        Dokumen
                                                    </a>
                                                @else
                                                    <span class="text-gray-400 text-sm">-</span>
                                                @endif
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2">
                                                @php
                                                    $notif = \App\Models\Notifikasi::where(
                                                        'notifiable_id',
                                                        $sertifikasi->id_sertifikasi,
                                                    )
                                                        ->where('notifiable_type', 'sertifikasi')
                                                        ->latest()
                                                        ->first();
                                                @endphp
                                                <div class="space-y-2">
                                                    @if ($notif && $notif->isi_notifikasi)
                                                        {{ $notif->isi_notifikasi }}
                                                    @endif

                                                    @if ($sertifikasi->status_sertifikasi == 0)
                                                        <form
                                                            action="{{ route('sertifikasi.komentar', $sertifikasi->id_sertifikasi) }}"
                                                            method="POST" class="flex gap-1">
                                                            @csrf
                                                            <textarea name="isi_notifikasi" class="flex-1 border rounded p-1" rows="1" placeholder="Komentar..." required>{{ $notif->isi_notifikasi ?? '' }}</textarea>
                                                            <button type="submit"
                                                                class="px-4 py-2 text-white bg-blue-500 hover:bg-blue-600 rounded">
                                                                Kirim
                                                            </button>
                                                        </form>
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2">
                                                @if ($sertifikasi->status_sertifikasi == 1)
                                                    <span
                                                        class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                        ✅ Tervalidasi
                                                    </span>
                                                @else
                                                    <span
                                                        class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                        ⏳ Belum Divalidasi
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2">
                                                <div class="flex gap-1 flex-wrap">
                                                    {{-- Validation Button --}}
                                                    @if ($sertifikasi->status_sertifikasi == 0)
                                                        <form
                                                            action="{{ route('admin.sertifikasi.validate', $sertifikasi->id_sertifikasi) }}"
                                                            method="POST" class="inline">
                                                            @csrf
                                                            <button type="submit"
                                                                class="bg-green-600 text-white px-2 py-1 text-xs rounded hover:bg-green-700 transition"
                                                                onclick="return confirm('Yakin ingin memvalidasi sertifikasi ini?')">Validasi
                                                            </button>
                                                        </form>
                                                    @endif

                                                    {{-- Edit Button - untuk admin atau pemilik --}}
                                                    @if (auth()->user()->hasRole('admin') || $sertifikasi->id_pengguna == auth()->user()->id_pengguna)
                                                        <a href="{{ route('sertifikasi.edit', $sertifikasi->id_sertifikasi) }}"
                                                            class="bg-orange-500 text-white px-2 py-1 text-xs rounded hover:bg-orange-600 transition">Edit
                                                        </a>
                                                    @endif

                                                    {{-- Delete Button - Only for Admin --}}
                                                    @if (auth()->user()->hasRole('admin'))
                                                        <form
                                                            action="{{ route('sertifikasi.destroy', $sertifikasi->id_sertifikasi) }}"
                                                            method="POST" class="inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                class="bg-red-600 text-white px-2 py-1 text-xs rounded hover:bg-red-700 transition"
                                                                onclick="return confirm('Yakin ingin menghapus sertifikasi ini? Tindakan ini tidak dapat dibatalkan!')">Hapus
                                                            </button>
                                                        </form>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="10" class="text-center text-gray-500 py-8">
                                                <div class="flex flex-col items-center">
                                                    <div class="text-lg font-medium text-gray-900 mb-2">Tidak ada
                                                        sertifikasi</div>
                                                    <p class="text-gray-600">
                                                        @if (request()->hasAny(['search_sertifikasi', 'status_sertifikasi', 'penyelenggara']))
                                                            Tidak ditemukan sertifikasi yang sesuai dengan filter yang
                                                            dipilih.
                                                        @else
                                                            Belum ada sertifikasi yang terdaftar dalam sistem.
                                                        @endif
                                                    </p>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>

                            {{-- PAGINATION --}}
                            <div class="mt-6 flex flex-col sm:flex-row justify-between items-center gap-4">
                                <div class="text-sm text-gray-600">
                                    Menampilkan <strong>{{ $dataSertifikasi->firstItem() ?? 0 }}</strong> -
                                    <strong>{{ $dataSertifikasi->lastItem() ?? 0 }}</strong> dari
                                    <strong>{{ $dataSertifikasi->total() }}</strong> sertifikasi
                                </div>
                                <div>
                                    {{ $dataSertifikasi->links('vendor.pagination.always') }}
                                </div>
                            </div>
                        </div>
                    @else
                        {{-- Tampilan untuk User Biasa --}}
                        @forelse ($dataSertifikasi as $sertifikasi)
                            <div class="mb-4">
                                <h3 class="font-bold">{{ $sertifikasi->nama_sertifikasi }}</h3>
                                <p>{{ $sertifikasi->deskripsi_sertifikasi }}</p>
                                <p>Status Validasi:
                                    @if ($sertifikasi->status_sertifikasi == 1)
                                        <span class="text-green-500">Sudah Divalidasi</span>
                                    @else
                                        <span class="text-red-500">Belum Divalidasi</span>
                                    @endif
                                </p>
                                <a href="{{ route('sertifikasi.show', $sertifikasi->id_sertifikasi) }}"
                                    class="text-black-500">Lihat
                                    Detail</a>
                            </div>
                        @empty
                            <p class="text-gray-500">Tidak ada informasi sertifikasi saat ini.</p>
                        @endforelse
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
