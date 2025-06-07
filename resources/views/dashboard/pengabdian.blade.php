{{-- Informasi Pengabdian --}}
<div id="pengabdian-section" class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-semibold">Informasi Pengabdian</h3>
                </div>

                @if (auth()->user()->hasRole('admin'))
                    <table class="table-auto w-full border-collapse border border-gray-300">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="border border-gray-300 px-4 py-2" rowspan="2">Judul Pengabdian</th>
                                <th class="border border-gray-300 px-4 py-2" rowspan="2">Deskripsi Pengabdian
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
                            @forelse ($dataPengabdian as $pengabdian)
                                <tr>
                                    <td class="border border-gray-300 px-4 py-2">
                                        {{ $pengabdian->judul_pengabdian }}</td>
                                    <td class="border border-gray-300 px-4 py-2">
                                        {{ $pengabdian->deskripsi_pengabdian }}</td>
                                    <td class="border border-gray-300 px-4 py-2">
                                        @php
                                            $notif = \App\Models\Notifikasi::where(
                                                'notifiable_id',
                                                $pengabdian->id_pengabdian,
                                            )
                                                ->where('notifiable_type', 'pengabdian')
                                                ->latest()
                                                ->first();
                                        @endphp
                                        {{ $notif->isi_notifikasi ?? '-' }}
                                    </td>
                                    <td class="border border-gray-300 px-4 py-2">
                                        @if ($pengabdian->status_pengabdian == 1)
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
                                        <a href="{{ route('pengabdian.show', $pengabdian->id_pengabdian) }}"
                                            class="text-blue-500 hover:underline">Detail</a>
                                    </td>
                                    <td class="border border-gray-300 px-4 py-2">
                                        @if ($pengabdian->status_pengabdian == 0)
                                            <form
                                                action="{{ route('admin.pengabdian.validate', $pengabdian->id_pengabdian) }}"
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
                                        pengabdian saat ini.</td>
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
                    @forelse ($dataPengabdian as $pengabdian)
                        <div class="mb-4">
                            <h3 class="font-bold">{{ $pengabdian->judul_pengabdian }}</h3>
                            <p>{{ $pengabdian->deskripsi_pengabdian }}</p>
                            <p>Status Validasi:
                                @if ($pengabdian->status_pengabdian == 1)
                                    <span class="text-green-500">Sudah Divalidasi</span>
                                @else
                                    <span class="text-red-500">Belum Divalidasi</span>
                                @endif
                            </p>
                            <a href="{{ route('pengabdian.show', $pengabdian->id_pengabdian) }}"
                                class="text-black-500">Lihat
                                Detail</a>
                        </div>
                    @empty
                        <p class="text-gray-500">Tidak ada informasi pengabdian saat ini.</p>
                    @endforelse
                @endif
            </div>
        </div>
    </div>
</div>
