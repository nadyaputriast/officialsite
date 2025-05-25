{{-- Informasi Oprek --}}
<div id="oprek-section" class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <h3 class="text-lg font-semibold mb-4">Informasi Oprek</h3>
                <a href="{{ route('oprek.create') }}" class="text-red-500 mb-4 inline-block">Tambah Oprek</a>

                @if (auth()->user()->hasRole('admin'))
                    {{-- Tampilan untuk Admin --}}
                    <table class="table-auto w-full border-collapse border border-gray-300">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="border border-gray-300 px-4 py-2" rowspan="2">Nama Hiring Project
                                </th>
                                <th class="border border-gray-300 px-4 py-2" rowspan="2">Deskripsi Hiring
                                    Project
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
                            @forelse ($dataOprek as $oprek)
                                <tr>
                                    <td class="border border-gray-300 px-4 py-2">{{ $oprek->nama_project }}</td>
                                    <td class="border border-gray-300 px-4 py-2">{{ $oprek->deskripsi_project }}
                                    </td>
                                    <td class="border border-gray-300 px-4 py-2">
                                        @php
                                            $notif = \App\Models\Notifikasi::where('notifiable_id', $oprek->id_oprek)
                                                ->where('notifiable_type', 'oprek_loker_project')
                                                ->latest()
                                                ->first();
                                        @endphp
                                        {{ $notif->isi_notifikasi ?? '-' }}
                                    </td>
                                    <td class="border border-gray-300 px-4 py-2">
                                        @if ($oprek->status_project == 1)
                                            <span class="text-green-500">Sudah Divalidasi</span>
                                        @else
                                            <span class="text-red-500">Belum Divalidasi</span>
                                        @endif
                                    </td>
                                    <td class="border border-gray-300 px-4 py-2">
                                        <a href="{{ route('oprek.show', $oprek->id_oprek) }}"
                                            class="text-blue-500 hover:underline">Detail</a>
                                    </td>
                                    <td class="border border-gray-300 px-4 py-2">
                                        @if ($oprek->status_project == 0)
                                            <form action="{{ route('oprek.validate', $oprek->id_oprek) }}"
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
                                    <td colspan="6" class="text-center text-gray-500 py-4">Tidak ada informasi
                                        oprek saat ini.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="mt-4">
                        {{ $dataOprek->links() }}
                    </div>
                @else
                    {{-- Tampilan untuk User Biasa --}}
                    @forelse ($dataOprek as $oprek)
                        <div class="mb-4">
                            <h3 class="font-bold">{{ $oprek->nama_project }}</h3>
                            <p>{{ $oprek->deskripsi_project }}</p>
                            <p>Status Validasi:
                                @if ($oprek->status_project == 1)
                                    <span class="text-green-500">Sudah Divalidasi</span>
                                @else
                                    <span class="text-red-500">Belum Divalidasi</span>
                                @endif
                            </p>
                            <a href="{{ route('oprek.show', $oprek->id_oprek) }}" class="text-black-500">Lihat
                                Detail</a>
                        </div>
                    @empty
                        <p class="text-gray-500">Tidak ada informasi oprek saat ini.</p>
                    @endforelse
                @endif
            </div>
        </div>
    </div>
</div>
