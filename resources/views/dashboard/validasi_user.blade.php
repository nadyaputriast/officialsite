@if (auth()->user()->hasRole('admin'))
<section class="bg-[#DDF1FB]">
    <div id="pembayaran-section" class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">Validasi Pembayaran Event</h3>
                    @forelse ($paginatedEvents as $eventGroup)
                        @php
                            $event = $eventGroup->first()->registration->event ?? null;
                        @endphp
                        <div class="mb-8">
                            <h4 class="text-blue-700 font-bold mb-2 text-lg">
                                {{ $event ? $event->nama_event : 'Event Tidak Diketahui' }}
                            </h4>
                            <table class="table-auto w-full border-collapse border border-gray-300 mb-4">
                                <thead>
                                    <tr class="bg-gray-100">
                                        <th class="border border-gray-300 px-4 py-2">Nama Peserta</th>
                                        <th class="border border-gray-300 px-4 py-2">Bukti Pembayaran</th>
                                        <th class="border border-gray-300 px-4 py-2">Status</th>
                                        <th class="border border-gray-300 px-4 py-2">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($eventGroup as $pembayaran)
                                        <tr>
                                            <td class="border border-gray-300 px-4 py-2">
                                                {{ $pembayaran->registration->user->nama_pengguna ?? '-' }}
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2">
                                                <a href="{{ Storage::url($pembayaran->bukti_pembayaran) }}" target="_blank"
                                                    class="text-blue-500 underline">Lihat Bukti</a>
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2">
                                                @if ($pembayaran->status_validasi)
                                                    <span class="text-green-600">Tervalidasi</span>
                                                    @if ($pembayaran->nomor_tiket)
                                                        <br>
                                                        <span class="text-xs text-gray-700">No Tiket: {{ $pembayaran->nomor_tiket }}</span>
                                                    @endif
                                                @else
                                                    <span class="text-yellow-600">Menunggu Validasi</span>
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
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @empty
                        <div class="text-center text-gray-500 py-4">Tidak ada pembayaran event.</div>
                    @endforelse

                    {{-- PAGINATION --}}
                    <div class="mt-4">
                        {{ $paginatedEvents->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endif