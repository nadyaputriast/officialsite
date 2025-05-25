{{-- Informasi Portofolio --}}
<div id="portofolio-section" class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <h3 class="text-lg font-semibold mb-4">Informasi Portofolio</h3>
                <a href="{{ route('portofolio.create') }}" class="text-red-500 mb-4 inline-block">Tambah
                    Portofolio</a>
                @if (auth()->user()->hasRole('admin'))
                    {{-- Tampilan untuk Admin --}}
                    <table class="table-auto w-full border-collapse border border-gray-300">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="border border-gray-300 px-4 py-2" rowspan="2">Nama Portofolio</th>
                                <th class="border border-gray-300 px-4 py-2" rowspan="2">Deskripsi Portofolio
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
                            @forelse ($dataPortofolio as $portofolio)
                                <tr>
                                    <td class="border border-gray-300 px-4 py-2">
                                        {{ $portofolio->nama_portofolio }}</td>
                                    <td class="border border-gray-300 px-4 py-2">
                                        {{ $portofolio->deskripsi_portofolio }}</td>
                                    <td class="border border-gray-300 px-4 py-2">
                                        @php
                                            $notif = \App\Models\Notifikasi::where(
                                                'notifiable_id',
                                                $portofolio->id_portofolio,
                                            )
                                                ->where('notifiable_type', 'portofolio')
                                                ->latest()
                                                ->first();
                                        @endphp
                                        {{ $notif->isi_notifikasi ?? '-' }}
                                    </td>
                                    <td class="border border-gray-300 px-4 py-2">
                                        @if ($portofolio->status_portofolio == 1)
                                            <span class="text-green-500">Sudah Divalidasi</span>
                                        @else
                                            <span class="text-red-500">Belum Divalidasi</span>
                                        @endif
                                    </td>
                                    <td class="border border-gray-300 px-4 py-2">
                                        <a href="{{ route('portofolio.show', $portofolio->id_portofolio) }}"
                                            class="text-blue-500 hover:underline">Detail</a>
                                    </td>
                                    <td class="border border-gray-300 px-4 py-2">
                                        @if ($portofolio->status_portofolio == 0)
                                            <form
                                                action="{{ route('portofolio.validate', $portofolio->id_portofolio) }}"
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
                                        portofolio saat ini.</td>
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
                    @forelse ($dataPortofolio as $portofolio)
                        <div class="mb-4">
                            <h3 class="font-bold">{{ $portofolio->nama_portofolio }}</h3>
                            <p>{{ $portofolio->deskripsi_portofolio }}</p>
                            <p><strong>Jumlah Dilihat:</strong> {{ $portofolio->view_count }}</p>
                            <p><strong>Jumlah Suka:</strong> {{ $portofolio->banyak_upvote }}</p>
                            <p><strong>Jumlah Tidak Suka:</strong> {{ $portofolio->banyak_downvote }}</p>
                            <a href="{{ route('portofolio.show', $portofolio->id_portofolio) }}"
                                class="text-blue-500 hover:underline">Lihat Detail</a>
                        </div>
                    @empty
                        <p class="text-gray-500">Tidak ada informasi portofolio saat ini.</p>
                    @endforelse
                @endif
            </div>
        </div>
    </div>
</div>
