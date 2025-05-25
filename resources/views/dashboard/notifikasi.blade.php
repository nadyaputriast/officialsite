{{-- Notifikasi --}}
<div x-data="{ open: false }" class="relative max-w-7xl mx-auto mt-6 mb-4">
    <button @click="open = !open" class="relative focus:outline-none">
        {{-- Icon Lonceng --}}
        <svg class="w-7 h-7 text-blue-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
        </svg>
        {{-- Badge jumlah unread --}}
        @php
            if (auth()->user()->hasRole('admin')) {
                // Admin: hitung data yang belum divalidasi (misal event, oprek, dst)
                $unreadCount =
                    \App\Models\Event::where('status_event', 0)->count() +
                    \App\Models\OprekLokerProject::where('status_project', 0)->count() +
                    \App\Models\Portofolio::where('status_portofolio', 0)->count() +
                    \App\Models\Pengabdian::where('status_pengabdian', 0)->count() +
                    \App\Models\Prestasi::where('status_prestasi', 0)->count() +
                    \App\Models\Sertifikasi::where('status_sertifikasi', 0)->count() +
                    \App\Models\Download::where('status_download', 0)->count() +
                    \App\Models\PembayaranEvent::where('status_validasi', 0)->count() +
                    \App\Models\User::where('status_validasi', 0)->count();
            } else {
                // User: hitung notifikasi yang belum dibaca
                $unreadCount = isset($notifs) ? collect($notifs)->where('is_read', 0)->count() : 0;
            }
        @endphp
        @if ($unreadCount > 0)
            <span
                class="absolute -top-1 -right-1 bg-red-600 text-white text-xs rounded-full px-1.5">{{ $unreadCount }}</span>
        @endif
    </button>

    {{-- Panel Notifikasi --}}
    <div x-show="open" @click.away="open = false"
        class="absolute z-50 mt-2 w-full max-w-xl bg-white border border-gray-300 rounded shadow-lg overflow-y-auto max-h-96 transition-all">
        <div class="p-4 border-b flex justify-between items-center">
            <span class="font-semibold text-blue-700">Notifikasi</span>
            <button @click="open = false" class="text-gray-500 hover:text-gray-700 text-sm">Tutup</button>
        </div>
        <div class="divide-y max-h-80 overflow-y-auto">
            @if (auth()->user()->hasRole('admin'))
                {{-- Admin: tampilkan daftar data yang belum divalidasi --}}
                @php
                    $pendingEvents = \App\Models\Event::where('status_event', 0)->get();
                    $pendingOprek = \App\Models\OprekLokerProject::where('status_project', 0)->get();
                    $pendingPortofolio = \App\Models\Portofolio::where('status_portofolio', 0)->get();
                    $pendingPengabdian = \App\Models\Pengabdian::where('status_pengabdian', 0)->get();
                    $pendingPrestasi = \App\Models\Prestasi::where('status_prestasi', 0)->get();
                    $pendingSertifikasi = \App\Models\Sertifikasi::where('status_sertifikasi', 0)->get();
                    $pendingDownload = \App\Models\Download::where('status_download', 0)->get();
                    $pendingPembayaran = \App\Models\PembayaranEvent::where('status_validasi', 0)->get();
                    $pendingUser = \App\Models\User::where('status_validasi', 0)->get();
                @endphp
                @foreach ([$pendingEvents, $pendingOprek, $pendingPortofolio, $pendingPengabdian, $pendingPrestasi, $pendingSertifikasi, $pendingDownload, $pendingPembayaran, $pendingUser] as $pendingList)
                    @foreach ($pendingList as $item)
                        <div class="flex justify-between items-center p-4 bg-yellow-100 text-yellow-900">
                            <div>
                                <div>
                                    @if (isset($item->nama_event))
                                        Event: {{ $item->nama_event }}
                                    @elseif(isset($item->nama_project))
                                        Oprek: {{ $item->nama_project }}
                                    @elseif(isset($item->nama_portofolio))
                                        Portofolio: {{ $item->nama_portofolio }}
                                    @elseif(isset($item->judul_pengabdian))
                                        Pengabdian: {{ $item->judul_pengabdian }}
                                    @elseif(isset($item->nama_prestasi))
                                        Prestasi: {{ $item->nama_prestasi }}
                                    @elseif(isset($item->nama_sertifikasi))
                                        Sertifikasi: {{ $item->nama_sertifikasi }}
                                    @elseif(isset($item->nama_download))
                                        Download: {{ $item->nama_download }}
                                    @elseif(isset($item->bukti_pembayaran))
                                        Pembayaran Event: {{ $item->registration->event->nama_event ?? '-' }}
                                    @elseif(isset($item->nama_pengguna))
                                        User: {{ $item->nama_pengguna }}
                                    @endif
                                </div>
                                <div class="text-xs mt-1">
                                    @if (isset($item->id_event))
                                        <a href="{{ route('event.show', $item->id_event) }}" class="underline">Lihat
                                            Detail</a>
                                    @elseif(isset($item->id_oprek))
                                        <a href="{{ route('oprek.show', $item->id_oprek) }}" class="underline">Lihat
                                            Detail</a>
                                    @elseif(isset($item->id_portofolio))
                                        <a href="{{ route('portofolio.show', $item->id_portofolio) }}"
                                            class="underline">Lihat Detail</a>
                                    @elseif(isset($item->id_pengabdian))
                                        <a href="{{ route('pengabdian.show', $item->id_pengabdian) }}"
                                            class="underline">Lihat Detail</a>
                                    @elseif(isset($item->id_prestasi))
                                        <a href="{{ route('prestasi.show', $item->id_prestasi) }}"
                                            class="underline">Lihat Detail</a>
                                    @elseif(isset($item->id_sertifikasi))
                                        <a href="{{ route('sertifikasi.show', $item->id_sertifikasi) }}"
                                            class="underline">Lihat Detail</a>
                                    @elseif(isset($item->id_download))
                                        <a href="{{ route('download.show', $item->id_download) }}"
                                            class="underline">Lihat Detail</a>
                                    @elseif(isset($item->id_pembayaran_event))
                                        <a href="#pembayaran-section" class="underline">Lihat Detail</a>
                                    @elseif(isset($item->id_pengguna))
                                        <a href="#user-section" class="underline">Lihat Detail</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endforeach
            @else
                {{-- User: tampilkan notifikasi hasil validasi --}}
                @php
                    // Urutkan: unread di atas, read di bawah
                    $unreadNotifs = collect($notifs)->where('is_read', 0);
                    $readNotifs = collect($notifs)->where('is_read', 1);
                    $sortedNotifs = $unreadNotifs->concat($readNotifs);
                    $routeMap = [
                        'oprek_loker_project' => 'oprek.show',
                        'portofolio' => 'portofolio.show',
                        'pengabdian' => 'pengabdian.show',
                        'prestasi' => 'prestasi.show',
                        'sertifikasi' => 'sertifikasi.show',
                        'download' => 'download.show',
                        'event' => 'event.show',
                    ];
                @endphp

                @forelse($sortedNotifs as $notif)
                    <div class="flex justify-between items-center p-4 border-b">
                        <div>
                            <div class="{{ $notif->is_read ? 'text-gray-400' : '' }}">
                                {{ $notif->isi_notifikasi }}</div>
                            <div class="text-xs mt-1">
                                @if (isset($routeMap[$notif->notifiable_type]))
                                    <a href="{{ route($routeMap[$notif->notifiable_type], $notif->notifiable_id) }}"
                                        class="underline">Lihat Detail</a>
                                @else
                                    <span class="text-gray-400">Tidak ada detail</span>
                                @endif
                            </div>
                        </div>
                        <div class="flex flex-col items-end gap-2">
                            @if (!$notif->is_read)
                                <form action="{{ route('notifikasi.read', $notif->id_notifikasi) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="text-xs text-blue-600 hover:underline">Tandai
                                        sudah dibaca</button>
                                </form>
                            @else
                                <span class="text-xs text-green-600">Sudah dibaca</span>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="p-4 text-gray-500 text-center">Tidak ada notifikasi.</div>
                @endforelse
            @endif
        </div>
    </div>
</div>
</x-slot>