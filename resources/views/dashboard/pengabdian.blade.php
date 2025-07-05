<section class="bg-[#DDF1FB]">
    <div id="event-section" class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl p-4 sm:p-6 shadow-md border hover:shadow-lg transition-all duration-300 hover:-translate-y-1 relative">
                <div class="p-0 sm:p-6 text-gray-900">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-3">
                        <h3 class="text-lg font-semibold">Informasi Pengabdian</h3>
                    </div>

                    @if (auth()->user()->hasRole('admin'))
                        <div class="mb-6 bg-gray-50 rounded-lg p-4">
                            <form method="GET" class="space-y-4">
                                <input type="hidden" name="tab" value="pengabdian">

                                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                                    {{-- Search Bar --}}
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Cari Pengabdian</label>
                                        <input type="text" name="search_pengabdian"
                                            value="{{ request('search_pengabdian') }}"
                                            placeholder="Cari berdasarkan nama pengabdian..."
                                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    </div>
                                    {{-- Filter Status --}}
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Status Pengabdian</label>
                                        <select name="status_pengabdian"
                                            class="w-full py-2 px-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                            <option value="">Semua Status</option>
                                            <option value="1" {{ request('status_pengabdian') == '1' ? 'selected' : '' }}>Sudah Divalidasi</option>
                                            <option value="0" {{ request('status_pengabdian') == '0' ? 'selected' : '' }}>Belum Divalidasi</option>
                                        </select>
                                    </div>
                                    {{-- Sort --}}
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Urutkan</label>
                                        <select name="sort"
                                            class="w-full py-2 px-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                            <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Terbaru</option>
                                            <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Terlama</option>
                                            <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Nama A-Z</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="flex gap-3 mt-4">
                                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">
                                        Cari
                                    </button>
                                    <a href="{{ route('dashboard', ['tab' => 'pengabdian']) }}"
                                        class="bg-gray-200 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-300 transition font-medium">
                                        Reset
                                    </a>
                                </div>
                            </form>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="table-auto w-full border-collapse border border-gray-300">
                                <thead>
                                    <tr class="bg-gray-100">
                                        <th class="border border-gray-300 px-4 py-2" rowspan="2">Judul Pengabdian</th>
                                        <th class="border border-gray-300 px-4 py-2" rowspan="2">Deskripsi Pengabdian</th>
                                        <th class="border border-gray-300 px-4 py-2" rowspan="2">Tanggal Pengabdian</th>
                                        <th class="border border-gray-300 px-4 py-2" rowspan="2">Pelaksana</th>
                                        <th class="border border-gray-300 px-4 py-2" rowspan="2">Dokumentasi Pengabdian</th>
                                        <th class="border border-gray-300 px-4 py-2" rowspan="2">Komentar/Notifikasi</th>
                                        <th class="border border-gray-300 px-4 py-2" rowspan="2">Status</th>
                                        <th class="border border-gray-300 px-4 py-2" colspan="2">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($dataPengabdian as $pengabdian)
                                        <tr class="hover:bg-blue-50">
                                            <td class="border border-gray-300 px-4 py-2 break-words max-w-xs">{{ $pengabdian->judul_pengabdian }}</td>
                                            <td class="border border-gray-300 px-4 py-2 break-words max-w-xs">{{ $pengabdian->deskripsi_pengabdian }}</td>
                                            <td class="border border-gray-300 px-4 py-2">{{ $pengabdian->tanggal_pengabdian }}</td>
                                            <td class="border border-gray-300 px-4 py-2">{{ $pengabdian->pelaksana }}</td>
                                            <td class="border border-gray-300 px-4 py-2">
                                                @if ($pengabdian->dokumentasi->count() > 0)
                                                    <div class="flex flex-wrap gap-2">
                                                        @foreach ($pengabdian->dokumentasi as $dokumentasi)
                                                            <a href="{{ asset('storage/' . $dokumentasi->dokumentasi_pengabdian) }}" target="_blank">
                                                                <img src="{{ asset('storage/' . $dokumentasi->dokumentasi_pengabdian) }}" alt="Dokumentasi Pengabdian" class="w-12 h-12 object-cover rounded" />
                                                            </a>
                                                        @endforeach
                                                    </div>
                                                @else
                                                    <span class="text-gray-400 text-sm">-</span>
                                                @endif
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2">
                                                @php
                                                    $notif = \App\Models\Notifikasi::where('notifiable_id', $pengabdian->id_pengabdian)
                                                        ->where('notifiable_type', 'pengabdian')
                                                        ->latest()
                                                        ->first();
                                                @endphp
                                                <div class="space-y-2">
                                                    @if ($notif && $notif->isi_notifikasi)
                                                        {{ $notif->isi_notifikasi }}
                                                    @endif

                                                    @if ($pengabdian->status_pengabdian == 0)
                                                        <form action="{{ route('pengabdian.komentar', $pengabdian->id_pengabdian) }}" method="POST" class="flex gap-1 flex-col sm:flex-row">
                                                            @csrf
                                                            <textarea name="isi_notifikasi" class="flex-1 border rounded p-1" rows="1" placeholder="Komentar..." required>{{ $notif->isi_notifikasi ?? '' }}</textarea>
                                                            <button type="submit" class="px-4 py-2 text-white bg-blue-500 hover:bg-blue-600 rounded w-full sm:w-auto">
                                                                Kirim
                                                            </button>
                                                        </form>
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2">
                                                @if ($pengabdian->status_pengabdian == 1)
                                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                        ✅ Tervalidasi
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                        ⏳ Belum Divalidasi
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2">
                                                <div class="flex flex-col sm:flex-row gap-2 flex-wrap">
                                                    {{-- Validation Button --}}
                                                    @if ($pengabdian->status_pengabdian == 0)
                                                        <form action="{{ route('admin.pengabdian.validate', $pengabdian->id_pengabdian) }}" method="POST" class="inline">
                                                            @csrf
                                                            <button type="submit" class="bg-green-600 text-white px-2 py-1 rounded hover:bg-green-700 transition w-full sm:w-auto" onclick="return confirm('Yakin ingin memvalidasi pengabdian ini?')">
                                                                Validasi
                                                            </button>
                                                        </form>
                                                    @endif

                                                    {{-- Edit Button --}}
                                                    @if (auth()->user()->hasRole('admin') || (isset($pengabdian->user_id) && auth()->user()->id == $pengabdian->user_id))
                                                        <a href="{{ route('pengabdian.edit', $pengabdian->id_pengabdian) }}" class="bg-orange-500 text-white px-2 py-1 rounded hover:bg-orange-600 transition w-full sm:w-auto text-center">
                                                            Edit
                                                        </a>
                                                    @endif

                                                    {{-- Delete Button - Only for Admin --}}
                                                    @if (auth()->user()->hasRole('admin'))
                                                        <form action="{{ route('pengabdian.destroy', $pengabdian->id_pengabdian) }}" method="POST" class="inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="bg-red-400 text-white px-2 py-1 rounded opacity-60 cursor-not-allowed"
                                                            disabled>
                                                            Hapus
                                                        </button>
                                                        </form>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="9" class="text-center text-gray-500 py-4">Tidak ada informasi pengabdian saat ini.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        {{-- Paginasi untuk Admin --}}
                        <div class="mt-6 flex flex-col sm:flex-row justify-between items-center gap-4">
                            <div class="text-sm text-gray-600">
                                Menampilkan <strong>{{ $dataPengabdian->count() }}</strong> dari
                                <strong>{{ $dataPengabdian->total() }}</strong> pengabdian
                            </div>
                            <div>
                                {{ $dataPengabdian->links('vendor.pagination.always') }}
                            </div>
                        </div>
                    @else
                        {{-- Tampilan untuk User Biasa --}}
                        <div class="space-y-4">
                        @forelse ($dataPengabdian as $pengabdian)
                            <div class="mb-4 p-4 bg-gray-50 rounded-lg shadow">
                                <h3 class="font-bold">{{ $pengabdian->judul_pengabdian }}</h3>
                                <p>{{ $pengabdian->deskripsi_pengabdian }}</p>
                                <p>Status Validasi:
                                    @if ($pengabdian->status_pengabdian == 1)
                                        <span class="text-green-500">Sudah Divalidasi</span>
                                    @else
                                        <span class="text-red-500">Belum Divalidasi</span>
                                    @endif
                                </p>
                                <a href="{{ route('pengabdian.show', $pengabdian->id_pengabdian) }}" class="text-blue-500 underline">Lihat Detail</a>
                            </div>
                        @empty
                            <p class="text-gray-500">Tidak ada informasi pengabdian saat ini.</p>
                        @endforelse
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>