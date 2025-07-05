<section class="bg-[#DDF1FB]">
    <div id="event-section" class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl p-4 sm:p-6 shadow-md border hover:shadow-lg transition-all duration-300 hover:-translate-y-1 relative">
                <div class="p-0 sm:p-6 text-gray-900">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-3">
                        <h3 class="text-lg font-semibold">Informasi Prestasi</h3>
                    </div>

                    @if (auth()->user()->hasRole('admin'))
                        <div class="mb-6 bg-gray-50 rounded-lg p-4">
                            <form method="GET" class="space-y-4">
                                <input type="hidden" name="tab" value="prestasi">

                                <div class="grid md:grid-cols-4 gap-4">
                                    {{-- Search Bar --}}
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Cari
                                            Prestasi</label>
                                        <input type="text" name="search_prestasi"
                                            value="{{ request('search_prestasi') }}"
                                            placeholder="Cari berdasarkan nama prestasi..."
                                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    </div>

                                    {{-- Filter Status --}}
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Status
                                            Prestasi</label>
                                        <select name="status_prestasi"
                                            class="w-full py-2 px-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                            <option value="">Semua Status</option>
                                            <option value="1"
                                                {{ request('status_prestasi') == '1' ? 'selected' : '' }}>Sudah
                                                Divalidasi
                                            </option>
                                            <option value="0"
                                                {{ request('status_prestasi') == '0' ? 'selected' : '' }}>Belum
                                                Divalidasi
                                            </option>
                                        </select>
                                    </div>

                                    {{-- Filter Tingkatan Prestasi --}}
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Tingkatan
                                            Prestasi</label>
                                        <select name="tingkatan_prestasi"
                                            class="w-full py-2 px-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                            <option value="">Semua Tingkatan</option>
                                            <option value="Regional"
                                                {{ request('tingkatan_prestasi') == 'Regional' ? 'selected' : '' }}>
                                                Regional
                                            </option>
                                            <option value="Nasional"
                                                {{ request('tingkatan_prestasi') == 'Nasional' ? 'selected' : '' }}>
                                                Nasional
                                            </option>
                                            <option value="Internasional"
                                                {{ request('tingkatan_prestasi') == 'Internasional' ? 'selected' : '' }}>
                                                Internasional
                                            </option>
                                        </select>
                                    </div>

                                    {{-- Filter Jenis Prestasi --}}
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Jenis
                                            Prestasi</label>
                                        <select name="jenis_prestasi"
                                            class="w-full py-2 px-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                            <option value="">Semua Jenis</option>
                                            <option value="Akademik"
                                                {{ request('jenis_prestasi') == 'Akademik' ? 'selected' : '' }}>Akademik
                                            </option>
                                            <option value="Non Akademik"
                                                {{ request('jenis_prestasi') == 'Non Akademik' ? 'selected' : '' }}>
                                                Non Akademik
                                            </option>
                                        </select>
                                    </div>
                                </div>

                                <div class="flex gap-3">
                                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">
                                        Cari
                                    </button>
                                    <a href="{{ route('dashboard', ['tab' => 'prestasi']) }}"
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
                                <th class="border border-gray-300 px-2 sm:px-4 py-2">Nama Prestasi</th>
                                <th class="border border-gray-300 px-2 sm:px-4 py-2">Deskripsi Prestasi</th>
                                <th class="border border-gray-300 px-2 sm:px-4 py-2">Tanggal Perolehan</th>
                                <th class="border border-gray-300 px-2 sm:px-4 py-2">Tingkatan Prestasi</th>
                                <th class="border border-gray-300 px-2 sm:px-4 py-2">Jenis Prestasi</th>
                                <th class="border border-gray-300 px-2 sm:px-4 py-2">Dokumentasi</th>
                                <th class="border border-gray-300 px-2 sm:px-4 py-2">Komentar/Notifikasi</th>
                                <th class="border border-gray-300 px-2 sm:px-4 py-2">Status</th>
                                <th class="border border-gray-300 px-2 sm:px-4 py-2">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($dataPrestasi as $prestasi)
                                <tr class="hover:bg-gray-50">
                                    <td class="border border-gray-300 px-4 py-2">
                                        {{ $prestasi->nama_prestasi }}</td>
                                    <td class="border border-gray-300 px-4 py-2">
                                        {{ $prestasi->deskripsi_prestasi }}</td>
                                    <td class="border border-gray-300 px-4 py-2">
                                        {{ $prestasi->tanggal_perolehan }}</td>
                                    <td class="border border-gray-300 px-4 py-2">
                                        {{ $prestasi->tingkatan_prestasi }}</td>
                                    <td class="border border-gray-300 px-4 py-2">
                                        {{ $prestasi->jenis_prestasi }}</td>
                                    <td class="border border-gray-300 px-4 py-2">
                                        @if ($prestasi->dokumentasi->count() > 0)
                                            @foreach ($prestasi->dokumentasi as $dokumentasi)
                                                <a href="{{ asset('storage/' . $dokumentasi->dokumentasi_prestasi) }}"
                                                    target="_blank">
                                                    <img src="{{ asset('storage/' . $dokumentasi->dokumentasi_prestasi) }}"
                                                        alt="Dokumentasi Prestasi" class="w-12 h-12 object-cover" />
                                                </a>
                                            @endforeach
                                        @else
                                            <span class="text-gray-400 text-sm">-</span>
                                        @endif
                                    </td>
                                    <td class="border border-gray-300 px-4 py-2">
                                        @php
                                            $notif = \App\Models\Notifikasi::where(
                                                'notifiable_id',
                                                $prestasi->id_prestasi,
                                            )
                                                ->where('notifiable_type', 'prestasi')
                                                ->latest()
                                                ->first();
                                        @endphp
                                        <div class="space-y-2">
                                            @if ($notif && $notif->isi_notifikasi)
                                                {{ $notif->isi_notifikasi }}
                                            @endif

                                            @if ($prestasi->status_prestasi == 0)
                                                <form action="{{ route('prestasi.komentar', $prestasi->id_prestasi) }}"
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
                                        @if ($prestasi->status_prestasi == 1)
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
                                        <div class="flex gap-2 flex-wrap">
                                            {{-- Validation Button --}}
                                            @if ($prestasi->status_prestasi == 0)
                                                <form
                                                    action="{{ route('admin.prestasi.validate', $prestasi->id_prestasi) }}"
                                                    method="POST" class="inline">
                                                    @csrf
                                                    <button type="submit"
                                                        class="bg-green-600 text-white px-2 py-1 rounded hover:bg-green-700 transition"
                                                        onclick="return confirm('Yakin ingin memvalidasi prestasi ini?')">
                                                        Validasi
                                                    </button>
                                                </form>
                                            @endif

                                            {{-- Edit Button --}}
                                            @if (auth()->user()->hasRole('admin') || (isset($prestasi->user_id) && auth()->user()->id == $prestasi->user_id))
                                                <a href="{{ route('prestasi.edit', $prestasi->id_prestasi) }}"
                                                    class="bg-orange-500 text-white px-2 py-1 rounded hover:bg-orange-600 transition">
                                                    Edit
                                                </a>
                                            @endif

                                            {{-- Delete Button - Only for Admin --}}
                                            @if (auth()->user()->hasRole('admin'))
                                                <form action="{{ route('prestasi.destroy', $prestasi->id_prestasi) }}"
                                                    method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="bg-red-400 text-white px-2 py-1 rounded opacity-60 cursor-not-allowed"
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
                                    <td colspan="5" class="text-center text-gray-500 py-4">Tidak ada
                                        informasi
                                        prestasi saat ini.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Paginasi untuk Admin --}}
                <div class="mt-6 flex flex-col sm:flex-row justify-between items-center gap-4">
                    <div class="text-sm text-gray-600">
                        Menampilkan <strong>{{ $dataPrestasi->count() }}</strong> dari
                        <strong>{{ $dataPrestasi->total() }}</strong> prestasi
                    </div>
                    <div>
                        {{ $dataPrestasi->links('vendor.pagination.always') }}
                    </div>
                </div>
            @else
                {{-- Tampilan untuk User Biasa --}}
                @forelse ($dataPrestasi as $prestasi)
                    <div class="mb-4">
                        <h3 class="font-bold">{{ $prestasi->nama_prestasi }}</h3>
                        <p>{{ $prestasi->deskripsi_prestasi }}</p>
                        <p>Status Validasi:
                            @if ($prestasi->status_prestasi == 1)
                                <span class="text-green-500">Sudah Divalidasi</span>
                            @else
                                <span class="text-red-500">Belum Divalidasi</span>
                            @endif
                        </p>
                        <a href="{{ route('prestasi.show', $prestasi->id_prestasi) }}" class="text-black-500">Lihat
                            Detail</a>
                    </div>
                @empty
                    <p class="text-gray-500">Tidak ada informasi prestasi saat ini.</p>
                @endforelse
                @endif
            </div>
        </div>
    </div>
    </div>
</section>