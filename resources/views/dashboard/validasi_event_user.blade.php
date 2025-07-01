@if (auth()->user()->hasRole('admin'))
    <div class="py-12">
        <section class="bg-[#DDF1FB]">
            <div id="pembayaran-section" class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900">
                            <h3 class="text-lg font-semibold mb-4">Validasi Pembayaran Event</h3>

                            {{-- SEARCH & FILTER --}}
                            <form method="GET" class="mb-4 flex flex-wrap gap-3 items-center">
                                <input type="hidden" name="tab" value="validasi_event">
                                <input type="text" name="search_event" value="{{ request('search_event') }}"
                                    placeholder="Cari nama event atau pengguna..."
                                    class="border px-3 py-2 rounded focus:ring focus:ring-blue-200">
                                <select name="status_validasi" class="border px-3 py-2 rounded">
                                    <option value="">Status</option>
                                    <option value="1" {{ request('status_validasi') == '1' ? 'selected' : '' }}>
                                        Tervalidasi</option>
                                    <option value="0" {{ request('status_validasi') == '0' ? 'selected' : '' }}>
                                        Belum Divalidasi</option>
                                </select>
                                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Cari</button>
                                <a href="{{ route('dashboard') }}?tab=validasi_event"
                                    class="bg-blue-600 text-white px-4 py-2 rounded">Reset</a>
                            </form>

                            <table class="table-auto w-full border-collapse border border-gray-300 mb-4">
                                <thead>
                                    <tr class="bg-gray-100">
                                        <th class="border border-gray-300 px-4 py-2">Nama Event</th>
                                        <th class="border border-gray-300 px-4 py-2">Nama Peserta</th>
                                        <th class="border border-gray-300 px-4 py-2">Nomor Tiket</th>
                                        <th class="border border-gray-300 px-4 py-2">Bukti Pembayaran</th>
                                        <th class="border border-gray-300 px-4 py-2">Status</th>
                                        <th class="border border-gray-300 px-4 py-2">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($paginatedEvents as $pembayaran)
                                        <tr>
                                            <td class="border border-gray-300 px-4 py-2">
                                                {{ $pembayaran->registration->event->nama_event ?? '-' }}
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2">
                                                {{ $pembayaran->registration->user->nama_pengguna ?? '-' }}
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2">
                                                {{ $pembayaran->registration->nomor_tiket ?? '-' }}
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2">
                                                <a href="{{ Storage::url($pembayaran->bukti_pembayaran) }}"
                                                    target="_blank">
                                                    <img src="{{ Storage::url($pembayaran->bukti_pembayaran) }}"
                                                        alt="Bukti Pembayaran" class="w-32 h-auto rounded shadow" />
                                                </a>
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2">
                                                @if ($pembayaran->status_validasi)
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
                                                @if (!$pembayaran->status_validasi)
                                                    <form
                                                        action="{{ route('pembayaran.validasi', $pembayaran->id_pembayaran_event) }}"
                                                        method="POST">
                                                        @csrf
                                                        <button type="submit"
                                                            class="px-3 py-1 bg-green-500 text-white rounded">Validasi</button>
                                                    </form>
                                                @else
                                                    <span class="text-green-500">Sudah divalidasi</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center text-gray-500 py-4">Tidak ada
                                                pembayaran
                                                event.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>

                            {{-- PAGINATION --}}
                            <div class="text-sm text-gray-600">
                                Menampilkan <strong>{{ $paginatedEvents->count() }}</strong> dari
                                <strong>{{ $paginatedEvents->total() }}</strong> validasi pembayaran
                            </div>
                            {{ $paginatedEvents->links('vendor.pagination.always') }}
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endif
