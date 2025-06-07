{{-- filepath: c:\laragon\www\officialsite\resources\views\dashboard\event.blade.php --}}
{{-- Informasi Event --}}
<div id="event-section" class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-semibold">Informasi Event</h3>
                    @auth
                        <a href="{{ route('event.create') }}"
                            class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                            + Tambah Event
                        </a>
                    @endauth
                </div>

                @if (auth()->user()->hasRole('admin'))
                    {{-- Tampilan untuk Admin --}}
                    <table class="table-auto w-full border-collapse border border-gray-300">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="border border-gray-300 px-4 py-2" rowspan="2">Nama Event</th>
                                <th class="border border-gray-300 px-4 py-2" rowspan="2">Deskripsi Event</th>
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
                            @forelse ($dataEvent as $event)
                                <tr>
                                    <td class="border border-gray-300 px-4 py-2">{{ $event->nama_event }}</td>
                                    <td class="border border-gray-300 px-4 py-2">
                                        {{ Str::limit($event->deskripsi_event, 100) }}</td>
                                    <td class="border border-gray-300 px-4 py-2">
                                        @php
                                            $notif = \App\Models\Notifikasi::where('notifiable_id', $event->id_event)
                                                ->where('notifiable_type', 'event')
                                                ->latest()
                                                ->first();
                                        @endphp
                                        {{ $notif->isi_notifikasi ?? '-' }}
                                    </td>
                                    <td class="border border-gray-300 px-4 py-2">
                                        @if ($event->status_event == 1)
                                            <span
                                                class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                ✓ Sudah Divalidasi
                                            </span>
                                        @else
                                            <span
                                                class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                ⏳ Belum Divalidasi
                                            </span>
                                        @endif
                                    </td>
                                    <td class="border border-gray-300 px-4 py-2">
                                        <a href="{{ route('event.show', $event->id_event) }}"
                                            class="text-blue-500 hover:underline">Detail</a>
                                    </td>
                                    <td class="border border-gray-300 px-4 py-2">
                                        @if ($event->status_event == 0)
                                            <form action="{{ route('admin.event.validate', $event->id_event) }}"
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
                                    <td colspan="6" class="text-center text-gray-500 py-4">Tidak ada informasi event
                                        saat ini.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    {{-- Paginasi untuk Admin --}}
                    @if ($dataEvent->hasPages())
                        <div class="mt-4">
                            {{ $dataEvent->links() }}
                        </div>
                    @endif
                @else
                    {{-- Tampilan untuk User Biasa dengan Search & Filter --}}

                    {{-- Search & Filter Bar --}}
                    <div class="mb-6 bg-gray-50 rounded-lg p-4">
                        <form method="GET" action="{{ route('dashboard') }}#event-section" class="space-y-4">
                            <div class="grid md:grid-cols-4 gap-4">
                                {{-- Search Bar --}}
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Cari Event</label>
                                    <div class="relative">
                                        <input type="text" name="search_event" value="{{ request('search_event') }}"
                                            placeholder="Cari berdasarkan nama event..."
                                            class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center">
                                            <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                    </div>
                                </div>

                                {{-- Filter Tanggal --}}
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Filter Tanggal</label>
                                    <select name="date_filter"
                                        class="w-full py-2 px-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        <option value="">Semua Waktu</option>
                                        <option value="today"
                                            {{ request('date_filter') == 'today' ? 'selected' : '' }}>Hari Ini</option>
                                        <option value="this_week"
                                            {{ request('date_filter') == 'this_week' ? 'selected' : '' }}>Minggu Ini
                                        </option>
                                        <option value="this_month"
                                            {{ request('date_filter') == 'this_month' ? 'selected' : '' }}>Bulan Ini
                                        </option>
                                        <option value="upcoming"
                                            {{ request('date_filter') == 'upcoming' ? 'selected' : '' }}>Akan Datang
                                        </option>
                                    </select>
                                </div>

                                {{-- Filter Penyelenggara --}}
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Penyelenggara</label>
                                    <select name="penyelenggara"
                                        class="w-full py-2 px-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        <option value="">Semua Penyelenggara</option>
                                        <option value="internal"
                                            {{ request('penyelenggara') == 'internal' ? 'selected' : '' }}>Internal
                                        </option>
                                        <option value="eksternal"
                                            {{ request('penyelenggara') == 'eksternal' ? 'selected' : '' }}>Eksternal
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

                            <div class="flex gap-3">
                                <button type="submit"
                                    class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition font-medium">
                                    Cari
                                </button>
                                <a href="{{ route('dashboard') }}#event-section"
                                    class="bg-gray-200 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-300 transition font-medium">
                                    Reset
                                </a>
                            </div>
                        </form>
                    </div>

                    {{-- Results Info --}}
                    <div class="mb-4 flex justify-between items-center">
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
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @endif

                        <div
                            class="bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow-md transition overflow-hidden">
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
                            <div class="p-4">
                                <div class="flex justify-between items-start mb-2">
                                    <h3 class="font-semibold text-lg line-clamp-2">
                                        {{ $event->nama_event }}
                                    </h3>
                                </div>

                                {{-- Event Details --}}
                                <div class="space-y-2 text-sm text-gray-600 mb-3">
                                    @if ($event->tanggal_event)
                                        <div class="flex items-center gap-2">
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
                                    <div class="flex gap-2">
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
                        <div class="flex gap-3 justify-center">
                            @if (request()->hasAny(['search_event', 'date_filter', 'penyelenggara', 'jenis_event', 'status']))
                                <a href="{{ route('dashboard') }}#event-section"
                                    class="bg-gray-600 text-white px-6 py-3 rounded-lg hover:bg-gray-700 transition">
                                    Lihat Semua Event
                                </a>
                            @endif
                            <a href="{{ route('event.create') }}"
                                class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition">
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
</style>
