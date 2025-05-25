@if (auth()->user()->hasRole('admin'))
    <div id="pembayaran-section" class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">Validasi Pembayaran Event</h3>
                    <table class="table-auto w-full border-collapse border border-gray-300">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="border border-gray-300 px-4 py-2">Nama Event</th>
                                <th class="border border-gray-300 px-4 py-2">Nama Peserta</th>
                                <th class="border border-gray-300 px-4 py-2">Bukti Pembayaran</th>
                                <th class="border border-gray-300 px-4 py-2">Status</th>
                                <th class="border border-gray-300 px-4 py-2">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $listPembayaran = \App\Models\PembayaranEvent::where('status_validasi', 0)
                                    ->with(['registration.event', 'registration.user'])
                                    ->latest()
                                    ->get();
                            @endphp
                            @forelse($listPembayaran as $pembayaran)
                                <tr>
                                    <td class="border border-gray-300 px-4 py-2">
                                        {{ $pembayaran->registration->event->nama_event ?? '-' }}
                                    </td>
                                    <td class="border border-gray-300 px-4 py-2">
                                        {{ $pembayaran->registration->user->nama_pengguna ?? '-' }}
                                    </td>
                                    <td class="border border-gray-300 px-4 py-2">
                                        <a href="{{ Storage::url($pembayaran->bukti_pembayaran) }}" target="_blank"
                                            class="text-blue-500 underline">Lihat Bukti</a>
                                    </td>
                                    <td class="border border-gray-300 px-4 py-2">
                                        <span class="text-yellow-600">Menunggu Validasi</span>
                                    </td>
                                    <td class="border border-gray-300 px-4 py-2">
                                        <form
                                            action="{{ route('pembayaran.validasi', $pembayaran->id_pembayaran_event) }}"
                                            method="POST">
                                            @csrf
                                            <button type="submit"
                                                class="px-3 py-1 bg-green-500 text-white rounded">Validasi</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-gray-500 py-4">Tidak ada pembayaran
                                        yang perlu divalidasi.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div id="user-section" class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">Validasi User Baru</h3>
                    <table class="table-auto w-full border-collapse border border-gray-300">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="border border-gray-300 px-4 py-2">Nama</th>
                                <th class="border border-gray-300 px-4 py-2">Email</th>
                                <th class="border border-gray-300 px-4 py-2">Status</th>
                                <th class="border border-gray-300 px-4 py-2">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $usersPending = \App\Models\User::where('status_validasi', 0)->get();
                            @endphp
                            @forelse($usersPending as $user)
                                <tr>
                                    <td class="border border-gray-300 px-4 py-2">{{ $user->nama_pengguna }}</td>
                                    <td class="border border-gray-300 px-4 py-2">{{ $user->email }}</td>
                                    <td class="border border-gray-300 px-4 py-2">
                                        <span class="text-yellow-600">Menunggu Validasi</span>
                                    </td>
                                    <td class="border border-gray-300 px-4 py-2">
                                        <form action="{{ route('user.validate', $user->id_pengguna) }}" method="POST">
                                            @csrf
                                            <button type="submit"
                                                class="px-3 py-1 bg-green-500 text-white rounded">Validasi</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-gray-500 py-4">Tidak ada user
                                        yang
                                        perlu divalidasi.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endif
