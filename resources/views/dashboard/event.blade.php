{{-- Informasi Event --}}
<div id="event-section" class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <h3 class="text-lg font-semibold mb-4">Informasi Event</h3>
                <a href="{{ route('event.create') }}" class="text-red-500 mb-4 inline-block">Tambah Event</a>
                @if (auth()->user()->hasRole('admin'))
                    {{-- Tampilan untuk Admin --}}
                    <table class="table-auto w-full border-collapse border border-gray-300">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="border border-gray-300 px-4 py-2" rowspan="2">Nama Event</th>
                                <th class="border border-gray-300 px-4 py-2" rowspan="2">Deskripsi Event
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
                            @forelse ($dataEvent as $event)
                                <tr>
                                    <td class="border border-gray-300 px-4 py-2">{{ $event->nama_event }}</td>
                                    <td class="border border-gray-300 px-4 py-2">{{ $event->deskripsi_event }}
                                    </td>
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
                                            <span class="text-green-500">Sudah Divalidasi</span>
                                        @else
                                            <span class="text-red-500">Belum Divalidasi</span>
                                        @endif
                                    </td>
                                    <td class="border border-gray-300 px-4 py-2">
                                        <a href="{{ route('event.show', $event->id_event) }}"
                                            class="text-blue-500 hover:underline">Detail</a>
                                    </td>
                                    <td class="border border-gray-300 px-4 py-2">
                                        @if ($event->status_event == 0)
                                            <form action="{{ route('event.validate', $event->id_event) }}"
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
                                        event saat ini.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    {{-- Paginasi untuk Admin --}}
                    <div class="mt-4">
                        {{ $dataEvent->links() }}
                    </div>
                @else
                    {{-- Tampilan untuk User Biasa --}}
                    @forelse ($dataEvent as $event)
                        <div class="mb-4">
                            <h3 class="font-bold">{{ $event->nama_event }}</h3>
                            <p>{{ $event->deskripsi_event }}</p>
                            <p>Status Validasi:
                                @if ($event->status_event == 1)
                                    <span class="text-green-500">Sudah Divalidasi</span>
                                @else
                                    <span class="text-red-500">Belum Divalidasi</span>
                                @endif
                            </p>
                            <a href="{{ route('event.show', $event->id_event) }}" class="text-black-500">Lihat
                                Detail</a>
                        </div>
                    @empty
                        <p class="text-gray-500">Tidak ada informasi event saat ini.</p>
                    @endforelse
                @endif
            </div>
        </div>
    </div>
</div>
