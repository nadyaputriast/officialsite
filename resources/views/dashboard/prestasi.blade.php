<section class="bg-[#DDF1FB]">
<div id="prestasi-section" class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-semibold">Informasi Prestasi</h3>
                </div>

                @if (auth()->user()->hasRole('admin'))
                    <table class="table-auto w-full border-collapse border border-gray-300">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="border border-gray-300 px-4 py-2" rowspan="2">Nama Prestasi</th>
                                <th class="border border-gray-300 px-4 py-2" rowspan="2">Deskripsi Prestasi
                                </th>
                                <th class="border border-gray-300 px-4 py-2" rowspan="2">Komentar/Notifikasi
                                </th>
                                <th class="border border-gray-300 px-4 py-2" rowspan="2">Status</th>
                                <th class="border border-gray-300 px-4 py-2" colspan="2">Aksi</th>
                            </tr>
                            <tr class="bg-gray-100">
                                <th class="border border-gray-300 px-4 py-2">Detail</th>
                                <th class="border border-gray-300 px-4 py-2">Validasi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($dataPrestasi as $prestasi)
                                <tr>
                                    <td class="border border-gray-300 px-4 py-2">
                                        {{ $prestasi->judul_prestasi }}</td>
                                    <td class="border border-gray-300 px-4 py-2">
                                        {{ $prestasi->deskripsi_prestasi }}</td>
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
                                        {{ $notif->isi_notifikasi ?? '-' }}
                                    </td>
                                    <td class="border border-gray-300 px-4 py-2">
                                        @if ($prestasi->status_prestasi == 1)
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
                                        <a href="{{ route('prestasi.show', $prestasi->id_prestasi) }}"
                                            class="text-blue-500 hover:underline">Detail</a>
                                    </td>
                                    <td class="border border-gray-300 px-4 py-2">
                                        @if ($prestasi->status_prestasi == 0)
                                            <form
                                                action="{{ route('admin.prestasi.validate', $prestasi->id_prestasi) }}"
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
                                        prestasi saat ini.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    {{-- Paginasi untuk Admin --}}
                    <div class="mt-4">
                        {{ $dataPortofolio->links() }}
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