{{-- Informasi Sertifikasi --}}
<div id="sertifikasi-section" class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <h3 class="text-lg font-semibold mb-4">Informasi Sertifikasi</h3>
                <a href="{{ route('sertifikasi.create') }}" class="text-red-500 mb-4 inline-block">Tambah
                    Sertifikasi</a>

                @if (auth()->user()->hasRole('admin'))
                    {{-- Tampilan untuk Admin --}}
                    <table class="table-auto w-full border-collapse border border-gray-300">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="border border-gray-300 px-4 py-2" rowspan="2">Nama Sertifikasi</th>
                                <th class="border border-gray-300 px-4 py-2" rowspan="2">Deskripsi Sertifikasi
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
                            @forelse ($dataSertifikasi as $sertifikasi)
                                <tr>
                                    <td class="border border-gray-300 px-4 py-2">
                                        {{ $sertifikasi->nama_sertifikasi }}</td>
                                    <td class="border border-gray-300 px-4 py-2">
                                        {{ $sertifikasi->deskripsi_sertifikasi }}
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
                                        {{ $notif->isi_notifikasi ?? '-' }}
                                    </td>
                                    <td class="border border-gray-300 px-4 py-2">
                                        @if ($sertifikasi->status_sertifikasi == 1)
                                            <span class="text-green-500">Sudah Divalidasi</span>
                                        @else
                                            <span class="text-red-500">Belum Divalidasi</span>
                                        @endif
                                    </td>
                                    <td class="border border-gray-300 px-4 py-2">
                                        <a href="{{ route('sertifikasi.show', $sertifikasi->id_sertifikasi) }}"
                                            class="text-blue-500 hover:underline">Detail</a>
                                    </td>
                                    <td class="border border-gray-300 px-4 py-2">
                                        @if ($sertifikasi->status_sertifikasi == 0)
                                            <form
                                                action="{{ route('sertifikasi.validate', $sertifikasi->id_sertifikasi) }}"
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
                        {{ $dataSertifikasi->links() }}
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