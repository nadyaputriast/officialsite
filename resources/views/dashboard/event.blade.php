{{-- Informasi Event --}}
<section class="bg-[#DDF1FB]">
    <div id="event-section" class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl p-4 sm:p-6 shadow-md border hover:shadow-lg transition-all duration-300 hover:-translate-y-1 relative">
                <div class="p-0 sm:p-6 text-gray-900">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-3">
                        <h3 class="text-lg font-semibold">Informasi Event</h3>
                        @auth
                            <a href="{{ route('event.create') }}"
                                class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition w-full sm:w-auto text-center">
                                + Tambah Event
                            </a>
                        @endauth
                    </div>

                    @if (auth()->user()->hasRole('admin'))
                        {{-- Search & Filter untuk Admin --}}
                        <div class="mb-6 bg-gray-50 rounded-lg p-4">
                            <form method="GET" class="space-y-4">
                                <input type="hidden" name="tab" value="event">

                                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                                    {{-- Search Bar --}}
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Cari Event</label>
                                        <input type="text" name="search_event" value="{{ request('search_event') }}"
                                            placeholder="Cari berdasarkan nama event..."
                                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    </div>

                                    {{-- Filter Status --}}
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Status Event</label>
                                        <select name="status_event"
                                            class="w-full py-2 px-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                            <option value="">Semua Status</option>
                                            <option value="1"
                                                {{ request('status_event') == '1' ? 'selected' : '' }}>Sudah Divalidasi
                                            </option>
                                            <option value="0"
                                                {{ request('status_event') == '0' ? 'selected' : '' }}>Belum Divalidasi
                                            </option>
                                        </select>
                                    </div>

                                    {{-- Filter Penyelenggara --}}
                                    <div>
                                        <label
                                            class="block text-sm font-medium text-gray-700 mb-1">Penyelenggara</label>
                                        <select name="penyelenggara_event"
                                            class="w-full py-2 px-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                            <option value="">Semua Penyelenggara</option>
                                            <option value="internal"
                                                {{ request('penyelenggara_event') == 'internal' ? 'selected' : '' }}>
                                                Internal</option>
                                            <option value="eksternal"
                                                {{ request('penyelenggara_event') == 'eksternal' ? 'selected' : '' }}>
                                                Eksternal</option>
                                        </select>
                                    </div>

                                    {{-- Filter Jenis Event --}}
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Event</label>
                                        <select name="jenis_event"
                                            class="w-full py-2 px-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                            <option value="">Semua Jenis</option>
                                            <option value="seminar"
                                                {{ request('jenis_event') == 'seminar' ? 'selected' : '' }}>Seminar
                                            </option>
                                            <option value="workshop"
                                                {{ request('jenis_event') == 'workshop' ? 'selected' : '' }}>Workshop
                                            </option>
                                            <option value="bootcamp"
                                                {{ request('jenis_event') == 'bootcamp' ? 'selected' : '' }}>Bootcamp
                                            </option>
                                            <option value="pameran"
                                                {{ request('jenis_event') == 'pameran' ? 'selected' : '' }}>Pameran
                                            </option>
                                            <option value="konferensi"
                                                {{ request('jenis_event') == 'konferensi' ? 'selected' : '' }}>
                                                Konferensi</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Filter
                                            Tanggal</label>
                                        <select name="date_filter"
                                            class="w-full py-2 px-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                            <option value="">Semua Waktu</option>
                                            <option value="today"
                                                {{ request('date_filter') == 'today' ? 'selected' : '' }}>Hari Ini
                                            </option>
                                            <option value="this_week"
                                                {{ request('date_filter') == 'this_week' ? 'selected' : '' }}>Minggu
                                                Ini</option>
                                            <option value="this_month"
                                                {{ request('date_filter') == 'this_month' ? 'selected' : '' }}>Bulan
                                                Ini</option>
                                        </select>
                                    </div>

                                    {{-- Sort --}}
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Urutkan</label>
                                        <select name="sort_event"
                                            class="w-full py-2 px-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                            <option value="latest"
                                                {{ request('sort_event') == 'latest' ? 'selected' : '' }}>Terbaru
                                            </option>
                                            <option value="oldest"
                                                {{ request('sort_event') == 'oldest' ? 'selected' : '' }}>Terlama
                                            </option>
                                            <option value="name_asc"
                                                {{ request('sort_event') == 'name_asc' ? 'selected' : '' }}>Nama A-Z
                                            </option>
                                            <option value="name_desc"
                                                {{ request('sort_event') == 'name_desc' ? 'selected' : '' }}>Nama
                                                Z-A</option>
                                            <option value="date_asc"
                                                {{ request('sort_event') == 'date_asc' ? 'selected' : '' }}>Tanggal
                                                Terdekat</option>
                                            <option value="price_asc"
                                                {{ request('sort_event') == 'price_asc' ? 'selected' : '' }}>Harga
                                                Termurah</option>
                                            <option value="price_desc"
                                                {{ request('sort_event') == 'price_desc' ? 'selected' : '' }}>Harga
                                                Termahal</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="flex gap-3 mt-4">
                                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">
                                        Cari
                                    </button>
                                    <a href="{{ route('dashboard', ['tab' => 'event']) }}"
                                        class="bg-gray-200 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-300 transition font-medium">
                                        Reset
                                    </a>
                                </div>
                            </form>
                        </div>

                        {{-- Tampilan untuk Admin --}}
                        <div class="overflow-x-auto">
                            <table class="table-auto w-full border-collapse border border-gray-300">
                                <thead>
                                    <tr class="bg-gray-100">
                                        <th class="border border-gray-300 px-2 sm:px-4 py-2">Nama Event</th>
                                        <th class="border border-gray-300 px-2 sm:px-4 py-2">Deskripsi Event</th>
                                        <th class="border border-gray-300 px-2 sm:px-4 py-2">Flyer Informasi</th>
                                        <th class="border border-gray-300 px-2 sm:px-4 py-2">Jenis Event</th>
                                        <th class="border border-gray-300 px-2 sm:px-4 py-2">Penyelenggara</th>
                                        <th class="border border-gray-300 px-2 sm:px-4 py-2">Nama Penyelenggara</th>
                                        <th class="border border-gray-300 px-2 sm:px-4 py-2">Tanggal Event</th>
                                        <th class="border border-gray-300 px-2 sm:px-4 py-2">Waktu</th>
                                        <th class="border border-gray-300 px-2 sm:px-4 py-2">Komentar</th>
                                        <th class="border border-gray-300 px-2 sm:px-4 py-2">Sisa Kuota</th>
                                        <th class="border border-gray-300 px-2 sm:px-4 py-2">Harga</th>
                                        <th class="border border-gray-300 px-2 sm:px-4 py-2">Kode Promo</th>
                                        <th class="border border-gray-300 px-2 sm:px-4 py-2">Nilai Promo</th>
                                        <th class="border border-gray-300 px-2 sm:px-4 py-2">Tanggal Mulai</th>
                                        <th class="border border-gray-300 px-2 sm:px-4 py-2">Tanggal Berakhir</th>
                                        <th class="border border-gray-300 px-2 sm:px-4 py-2">Status</th>
                                        <th class="border border-gray-300 px-2 sm:px-4 py-2">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($dataEvent as $event)
                                        <tr class="hover:bg-gray-50">
                                            <td class="border border-gray-300 px-2 sm:px-4 py-2">{{ $event->nama_event }}</td>
                                            <td class="border border-gray-300 px-2 sm:px-4 py-2">
                                                {{ Str::limit($event->deskripsi_event, 50) }}</td>
                                            <td class="border border-gray-300 px-2 sm:px-4 py-2">
                                                <a href="{{ Storage::url($event->thumbnail_event) }}" target="_blank">
                                                    <img src="{{ Storage::url($event->thumbnail_event) }}"
                                                        alt="Flyer event" class="w-20 sm:w-32 h-auto rounded shadow" />
                                                </a>
                                            </td>
                                            <td class="border border-gray-300 px-2 sm:px-4 py-2">{{ $event->jenis_event }}</td>
                                            <td class="border border-gray-300 px-2 sm:px-4 py-2">
                                                {{ $event->penyelenggara_event }}</td>
                                            <td class="border border-gray-300 px-2 sm:px-4 py-2">
                                                {{ $event->nama_penyelenggara }}</td>
                                            <td class="border border-gray-300 px-2 sm:px-4 py-2">{{ $event->tanggal_event }}
                                            </td>
                                            <td class="border border-gray-300 px-2 sm:px-4 py-2">{{ $event->waktu_event }}
                                            </td>
                                            <td class="border border-gray-300 px-2 sm:px-4 py-2">
                                                @php
                                                    $notif = \App\Models\Notifikasi::where(
                                                        'notifiable_id',
                                                        $event->id_event,
                                                    )
                                                        ->where('notifiable_type', 'event')
                                                        ->latest()
                                                        ->first();
                                                @endphp
                                                <div class="space-y-2">
                                                    @if ($notif && $notif->isi_notifikasi)
                                                        {{ $notif->isi_notifikasi }}
                                                    @else
                                                        Tidak ada komentar.
                                                    @endif

                                                    @if ($event->status_event == 0)
                                                        <form action="{{ route('event.komentar', $event->id_event) }}"
                                                            method="POST" class="flex gap-1 flex-col sm:flex-row">
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
                                            <td class="border border-gray-300 px-2 sm:px-4 py-2">{{ $event->kuota_event }}
                                            </td>
                                            <td class="border border-gray-300 px-2 sm:px-4 py-2">
                                                @if ($event->harga_event == 0)
                                                    <span
                                                        class="font-medium">
                                                        Gratis
                                                    </span>
                                                @else
                                                    <div class="font-medium">Rp
                                                        {{ number_format($event->harga_event, 0, ',', '.') }}</div>
                                                @endif
                                            </td>
                                            <td class="border border-gray-300 px-2 sm:px-4 py-2">
                                                @if ($event->penyelenggara_event === 'internal' && $event->promo)
                                                    {{ $event->promo->kode_promo }}
                                                @elseif ($event->penyelenggara_event === 'internal')
                                                   Tidak ada promo
                                                @else
                                                   Event eksternal
                                                @endif
                                            </td>
                                            <td class="border border-gray-300 px-2 sm:px-4 py-2">
                                                @if ($event->penyelenggara_event === 'internal' && $event->promo && $event->promo->nilai_promo > 0)
                                                    @if ($event->promo->jenis_promo === 'Persentase')
                                                        {{ $event->promo->nilai_promo }}%
                                                    @else
                                                        Rp{{ number_format($event->promo->nilai_promo, 0, ',', '.') }}
                                                    @endif
                                                @elseif ($event->penyelenggara_event === 'internal')
                                                    Tidak ada diskon
                                                @else
                                                    Event eksternal
                                                @endif
                                            </td>
                                            <td class="border border-gray-300 px-2 sm:px-4 py-2">
                                                @if ($event->penyelenggara_event === 'internal' && $event->promo)
                                                    @php
                                                        $tanggalMulai = $event->promo->tanggal_mulai
                                                            ? strtotime($event->promo->tanggal_mulai)
                                                            : null;
                                                        $sekarang = time();
                                                    @endphp

                                                    @if ($tanggalMulai)
                                                        <div class="text-sm">
                                                            {{ date('d/m/Y', $tanggalMulai) }}
                                                            @if ($tanggalMulai > $sekarang)
                                                                <span class="block text-xs text-orange-600">Belum
                                                                    aktif</span>
                                                            @elseif ($tanggalMulai <= $sekarang)
                                                                <span class="block text-xs text-green-600">Sedang
                                                                    aktif</span>
                                                            @endif
                                                        </div>
                                                    @else
                                                        <span class="text-gray-400 text-sm italic">-</span>
                                                    @endif
                                                @else
                                                    <span class="text-gray-400 text-sm italic">-</span>
                                                @endif
                                            </td>
                                            <td class="border border-gray-300 px-2 sm:px-4 py-2">
                                                @if ($event->penyelenggara_event === 'internal' && $event->promo)
                                                    @php
                                                        $tanggalBerakhir = $event->promo->tanggal_berakhir
                                                            ? strtotime($event->promo->tanggal_berakhir)
                                                            : null;
                                                        $sekarang = time();
                                                    @endphp

                                                    @if ($tanggalBerakhir)
                                                        <div class="text-sm">
                                                            {{ date('d/m/Y', $tanggalBerakhir) }}
                                                            @if ($tanggalBerakhir < $sekarang)
                                                                <span class="block text-xs text-red-600">Sudah
                                                                    berakhir</span>
                                                            @elseif ($tanggalBerakhir >= $sekarang)
                                                                <span class="block text-xs text-green-600">Masih
                                                                    berlaku</span>
                                                            @endif
                                                        </div>
                                                    @else
                                                        <span class="text-gray-400 text-sm italic">-</span>
                                                    @endif
                                                @else
                                                    <span class="text-gray-400 text-sm italic">-</span>
                                                @endif
                                            </td>   
                                            <td class="border border-gray-300 px-2 sm:px-4 py-2">
                                                @if ($event->status_event == 1)
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
                                            <td class="border border-gray-300 px-2 sm:px-4 py-2">
                                                <div class="flex gap-2 flex-wrap">
                                                    {{-- Validation Button --}}
                                                    @if ($event->status_event == 0)
                                                        <form
                                                            action="{{ route('admin.event.validate', $event->id_event) }}"
                                                            method="POST" class="inline">
                                                            @csrf
                                                            <button type="submit"
                                                                class="bg-green-600 text-white px-2 py-1 rounded hover:bg-green-700 transition"
                                                                onclick="return confirm('Yakin ingin memvalidasi event ini?')">
                                                                Validasi
                                                            </button>
                                                        </form>
                                                    @endif

                                                    {{-- Edit Button --}}
                                                    @if (auth()->user()->hasRole('admin') || (isset($event->user_id) && auth()->user()->id == $event->user_id))
                                                        <a href="{{ route('event.edit', $event->id_event) }}"
                                                            class="bg-orange-500 text-white px-2 py-1 rounded hover:bg-orange-600 transition">
                                                            Edit
                                                        </a>
                                                    @endif

                                                    {{-- Delete Button - Only for Admin --}}
                                                    @if (auth()->user()->hasRole('admin'))
                                                        <form action="{{ route('event.destroy', $event->id_event) }}"
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
                                            <td colspan="17" class="text-center text-gray-500 py-8">
                                                <div class="flex flex-col items-center">
                                                    Tidak ada event yang sesuai filter.
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        {{-- Pagination untuk Admin --}}
                        <div class="mt-6 flex flex-col sm:flex-row justify-between items-center gap-4">
                            <div class="text-sm text-gray-600">
                                Menampilkan <strong>{{ $dataEvent->count() }}</strong> dari
                                <strong>{{ $dataEvent->total() }}</strong> events
                            </div>
                            <div>
                                {{ $dataEvent->links('vendor.pagination.always') }}
                            </div>
                        </div>
                    @else
                        {{-- Tampilan untuk User Biasa dengan Search & Filter --}}

                        {{-- Search & Filter Bar --}}
                        <div class="mb-6 bg-gray-50 rounded-lg p-4">
                            <form method="GET" action="{{ route('dashboard') }}#event-section" class="space-y-4">
                                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                                    {{-- Search Bar --}}
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Cari Event</label>
                                        <div class="relative">
                                            <input type="text" name="search_event"
                                                value="{{ request('search_event') }}"
                                                placeholder="Cari berdasarkan nama event..."
                                                class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center">
                                                <svg class="w-5 h-5 text-gray-400" fill="currentColor"
                                                    viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Filter Tanggal --}}
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Filter
                                            Tanggal</label>
                                        <select name="date_filter"
                                            class="w-full py-2 px-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                            <option value="">Semua Waktu</option>
                                            <option value="today"
                                                {{ request('date_filter') == 'today' ? 'selected' : '' }}>Hari Ini
                                            </option>
                                            <option value="this_week"
                                                {{ request('date_filter') == 'this_week' ? 'selected' : '' }}>Minggu
                                                Ini
                                            </option>
                                            <option value="this_month"
                                                {{ request('date_filter') == 'this_month' ? 'selected' : '' }}>Bulan
                                                Ini
                                            </option>
                                            <option value="upcoming"
                                                {{ request('date_filter') == 'upcoming' ? 'selected' : '' }}>Akan
                                                Datang
                                            </option>
                                        </select>
                                    </div>

                                    {{-- Filter Penyelenggara --}}
                                    <div>
                                        <label
                                            class="block text-sm font-medium text-gray-700 mb-1">Penyelenggara</label>
                                        <select name="penyelenggara"
                                            class="w-full py-2 px-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                            <option value="">Semua Penyelenggara</option>
                                            <option value="internal"
                                                {{ request('penyelenggara') == 'internal' ? 'selected' : '' }}>Internal
                                            </option>
                                            <option value="eksternal"
                                                {{ request('penyelenggara') == 'eksternal' ? 'selected' : '' }}>
                                                Eksternal
                                            </option>
                                        </select>
                                    </div>
                                </div>

                                {{-- Jenis Event Filter - Radio Buttons --}}
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Jenis Event</label>
                                    <div class="grid grid-cols-2 md:grid-cols-6 gap-3">
                                        @php
                                            $jenisEventOptions = [
                                                'seminar' => 'Seminar',
                                                'workshop' => 'Workshop',
                                                'bootcamp' => 'Bootcamp',
                                                'pameran' => 'Pameran',
                                                'konferensi' => 'Konferensi',
                                            ];
                                        @endphp

                                        <label class="flex items-center space-x-2 cursor-pointer">
                                            <input type="radio" name="jenis_event" value=""
                                                {{ !request('jenis_event') ? 'checked' : '' }}
                                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 focus:ring-2">
                                            <span class="text-sm text-gray-700">Semua Jenis</span>
                                        </label>

                                        @foreach ($jenisEventOptions as $value => $label)
                                            <label class="flex items-center space-x-2 cursor-pointer">
                                                <input type="radio" name="jenis_event" value="{{ $value }}"
                                                    {{ request('jenis_event') == $value ? 'checked' : '' }}
                                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 focus:ring-2">
                                                <span class="text-sm text-gray-700">{{ $label }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>

                                <div class="flex flex-col sm:flex-row gap-3">
                                    <button type="submit"
                                        class="bg-blue-600 text-white px-4 py-2 rounded text-center">
                                        Cari
                                    </button>
                                    <a href="{{ route('dashboard') }}#event-section"
                                        class="bg-gray-200 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-300 transition font-medium text-center">
                                        Reset
                                    </a>
                                </div>
                            </form>
                        </div>

                        {{-- Results Info --}}
                        <div class="mb-4 flex flex-col sm:flex-row justify-between items-center gap-2">
                            <div class="text-sm text-gray-600">
                                Menampilkan {{ $dataEvent->count() }} dari {{ $dataEvent->total() }} event
                                @if (request('search_event'))
                                    untuk "<strong>{{ request('search_event') }}</strong>"
                                @endif
                                @if (request('jenis_event'))
                                    jenis "<strong>{{ request('jenis_event') }}</strong>"
                                @endif
                            </div>
                        </div>

                        {{-- Grid Event --}}
                        @forelse ($dataEvent as $event)
                            @if ($loop->first)
                                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                            @endif

                            <div
                                class="bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow-md transition overflow-hidden flex flex-col">
                                {{-- Event Image/Thumbnail --}}
                                @if ($event->thumbnail_event)
                                    <div class="aspect-video bg-gray-100 overflow-hidden">
                                        <img src="{{ asset('storage/' . $event->thumbnail_event) }}"
                                            alt="{{ $event->nama_event }}"
                                            class="w-full h-full object-cover hover:scale-105 transition duration-300">
                                    </div>
                                @else
                                    <div class="aspect-video bg-gray-100 flex items-center justify-center">
                                        <svg class="w-12 h-12 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                @endif

                                {{-- Content --}}
                                <div class="p-4 flex flex-col flex-1">
                                    <div class="flex justify-between items-start mb-2">
                                        <h3 class="font-semibold text-lg line-clamp-2">
                                            {{ $event->nama_event }}
                                        </h3>
                                    </div>

                                    {{-- Event Details --}}
                                    <div class="space-y-2 text-sm text-gray-600 mb-3">
                                        @if ($event->tanggal_event)
                                            <div class="flex flex-wrap items-center gap-2">
                                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                                <span>{{ date('d M Y', strtotime($event->tanggal_event)) }}</span>
                                                @if ($event->waktu_event)
                                                    <span
                                                        class="text-gray-500">{{ date('H:i', strtotime($event->waktu_event)) }}</span>
                                                @endif
                                                <p>{{ $event->nama_penyelenggara }}</p>
                                            </div>
                                        @endif

                                        {{-- Jenis & Penyelenggara --}}
                                        <div class="flex gap-2 flex-wrap">
                                            @if ($event->jenis_event)
                                                <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs rounded-full">
                                                    {{ ucfirst($event->jenis_event) }}
                                                </span>
                                            @endif
                                            @if ($event->penyelenggara_event)
                                                <span class="px-2 py-1 bg-gray-100 text-gray-800 text-xs rounded-full">
                                                    {{ ucfirst($event->penyelenggara_event) }}
                                                </span>
                                            @endif
                                        </div>

                                        <p class="text-gray-600 text-sm mb-4 line-clamp-3">
                                            {{ $event->deskripsi_event }}
                                        </p>

                                        {{-- Owner Info --}}
                                        @if ($event->owner)
                                            <div class="text-xs text-gray-500 mb-3">
                                                <span class="font-medium">{{ $event->owner->nama_pengguna }}</span>
                                            </div>
                                        @endif

                                        {{-- Action Button --}}
                                        <div class="space-y-2">
                                            <a href="{{ route('event.show', $event->id_event) }}"
                                                class="block w-full bg-blue-600 text-white text-center px-4 py-2 rounded-lg hover:bg-blue-700 transition font-medium">
                                                Detail Event
                                            </a>

                                            {{-- Tombol Daftar sesuai jenis event --}}
                                            @if ($event->penyelenggara_event === 'eksternal')
                                                {{-- Event Eksternal - Link ke website penyelenggara --}}
                                                @if ($event->tautan_event)
                                                    <a href="{{ $event->tautan_event }}"
                                                        class="block w-full bg-green-600 text-white text-center px-4 py-2 rounded-lg hover:bg-green-700 transition"
                                                        target="_blank">
                                                        <svg class="w-4 h-4 inline mr-2" fill="currentColor"
                                                            viewBox="0 0 20 20">
                                                            <path
                                                                d="M11 3a1 1 0 100 2h2.586l-6.293 6.293a1 1 0 101.414 1.414L15 6.414V9a1 1 0 102 0V4a1 1 0 00-1-1h-5z" />
                                                            <path
                                                                d="M5 5a2 2 0 00-2 2v8a2 2 0 002 2h8a2 2 0 002-2v-1a1 1 0 10-2 0v1H5V7h1a1 1 0 000-2H5z" />
                                                        </svg>
                                                        Daftar di Website Penyelenggara
                                                    </a>
                                                @else
                                                    <button type="button"
                                                        class="block w-full bg-gray-400 text-white text-center px-4 py-2 rounded-lg cursor-not-allowed"
                                                        disabled>
                                                        Link Pendaftaran Belum Tersedia
                                                    </button>
                                                @endif
                                            @else
                                                {{-- Event Internal - Sistem pendaftaran internal --}}
                                                <a href="{{ route('event.register', $event->id_event) }}"
                                                    class="block w-full bg-green-600 text-white text-center px-4 py-2 rounded-lg hover:bg-green-700 transition">
                                                    <svg class="w-4 h-4 inline mr-2" fill="currentColor"
                                                        viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd"
                                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                    Daftar Sekarang
                                                </a>
                                            @endif

                                            {{-- Info harga untuk event internal --}}
                                            @if ($event->penyelenggara_event === 'internal')
                                                <div class="text-xs text-gray-600 text-center">
                                                    Harga: <span
                                                        class="font-medium">Rp{{ number_format($event->harga_event, 0, ',', '.') }}</span>
                                                    @if ($event->kuota_event > 0)
                                                        • Kuota: {{ $event->kuota_event }} orang
                                                    @else
                                                        • <span class="text-red-600">Kuota penuh</span>
                                                    @endif
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                            </div>
                            @if ($loop->last)
                                </div>
                            @endif
                        @empty
                            <div class="text-center py-12">
                                <div class="text-gray-400 mb-4">
                                    <svg class="w-16 h-16 mx-auto" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-2">Tidak ada event</h3>
                                <p class="text-gray-600 mb-6">
                                    @if (request()->hasAny(['search_event', 'date_filter', 'penyelenggara', 'jenis_event', 'status']))
                                        Tidak ditemukan event yang sesuai dengan kriteria pencarian.
                                    @else
                                        Belum ada event yang tersedia saat ini.
                                    @endif
                                </p>
                                <div class="flex flex-col sm:flex-row gap-3 justify-center">
                                    @if (request()->hasAny(['search_event', 'date_filter', 'penyelenggara', 'jenis_event', 'status']))
                                        <a href="{{ route('dashboard') }}#event-section"
                                            class="bg-gray-600 text-white px-6 py-3 rounded-lg hover:bg-gray-700 transition">
                                            Lihat Semua Event
                                        </a>
                                    @endif
                                    <a href="{{ route('event.create') }}"
                                        class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition text-center">
                                        + Tambah Event
                                    </a>
                                </div>
                            </div>
                        @endforelse

                        {{-- Pagination --}}
                        @if ($dataEvent->hasPages())
                            <div class="mt-8">
                                {{ $dataEvent->appends(request()->query())->links() }}
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
        @media (max-width: 640px) {
            table th, table td {
                padding-left: 0.5rem !important;
                padding-right: 0.5rem !important;
                font-size: 0.85rem !important;
            }
        }
    </style>
</section>