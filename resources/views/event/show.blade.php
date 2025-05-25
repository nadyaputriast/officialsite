<x-app-layout>
    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-2xl font-bold mb-6">Detail Event</h3>

                    {{-- Alert error dari controller --}}
                    @if ($errors->any())
                        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                            {{ $errors->first() }}
                        </div>
                    @endif

                    {{-- Cek status tiket user --}}
                    @php
                        $isAdmin = auth()->user()->hasRole('admin');
                        $isCreator = auth()->id() == $event->id_pengguna;
                        $myRegistration = \App\Models\EventRegistration::where('id_event', $event->id_event)
                            ->where('id_pengguna', auth()->id())
                            ->first();
                        $myPembayaran = $myRegistration
                            ? \App\Models\PembayaranEvent::where('id_event_registration', $myRegistration->id_event_registration)
                                ->where('status_validasi', 1)
                                ->first()
                            : null;
                    @endphp

                    {{-- Alert jika sudah punya tiket tervalidasi --}}
                    @if($myRegistration && $myPembayaran)
                        <div class="mb-6">
                            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                                <strong>Nomor Tiket Anda:</strong> {{ $myRegistration->nomor_tiket }}
                            </div>
                        </div>
                    @endif

                    <div class="mb-3">
                        <span class="font-semibold">Nama Event:</span> {{ $event->nama_event }}
                    </div>
                    <div class="mb-3">
                        <span class="font-semibold">Jenis Event:</span> {{ $event->jenis_event }}
                    </div>
                    <div class="mb-3">
                        <span class="font-semibold">Deskripsi:</span> {{ $event->deskripsi_event }}
                    </div>
                    <div class="mb-3">
                        <span class="font-semibold">Tanggal Event:</span> {{ $event->tanggal_event }}
                    </div>
                    <div class="mb-3">
                        <span class="font-semibold">Waktu Event:</span> {{ $event->waktu_event }}
                    </div>
                    <div class="mb-3">
                        <span class="font-semibold">Penyelenggara:</span> {{ $event->penyelenggara_event }}
                    </div>
                    <div class="mb-3">
                        <span class="font-semibold">Nama Penyelenggara:</span> {{ $event->nama_penyelenggara }}
                    </div>
                    @if ($event->penyelenggara_event === 'eksternal')
                        <div class="mb-3">
                            <span class="font-semibold">Tautan Event:</span>
                            <a href="{{ $event->tautan_event }}" class="text-blue-600 underline" target="_blank">{{ $event->tautan_event }}</a>
                        </div>
                    @endif
                    <div class="mb-3">
                        <span class="font-semibold">Harga Event:</span> Rp{{ number_format($event->harga_event, 0, ',', '.') }}
                    </div>
                    <div class="mb-3">
                        <span class="font-semibold">Kuota Tersisa:</span> {{ $event->kuota_event }}
                    </div>

                    @if ($isAdmin || $isCreator)
                        <div class="mb-3">
                            <span class="font-semibold">Status:</span>
                            @if ($event->status_event == 1)
                                <span class="text-green-600 font-semibold">Sudah Divalidasi</span>
                            @else
                                <span class="text-red-600 font-semibold">Belum Divalidasi</span>
                            @endif
                        </div>
                        @if ($event->promo && $event->promo->count())
                            <div class="mb-3">
                                <span class="font-semibold">Kode Promo:</span> {{ $event->promo->first()->kode_promo }}
                            </div>
                            <div class="mb-3">
                                <span class="font-semibold">Nilai Promo:</span>
                                {{ $event->promo->first()->nilai_promo }}{{ $event->promo->first()->jenis_promo == 'Persentase' ? '%' : '' }}
                            </div>
                            <div class="mb-3">
                                <span class="font-semibold">Harga Setelah Promo:</span>
                                Rp{{ number_format($event->promo->first()->harga_promo, 0, ',', '.') }}
                            </div>
                        @endif
                    @endif

                    {{-- Tombol aksi untuk user biasa --}}
                    @if (!$isAdmin && !$isCreator)
                        @if ($event->penyelenggara_event === 'eksternal')
                            <a href="{{ $event->tautan_event }}" class="inline-block px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition" target="_blank">
                                Daftar di Website Penyelenggara
                            </a>
                        @elseif(!$myRegistration || !$myPembayaran)
                            <a href="{{ route('event.register', $event->id_event) }}" id="btn-daftar"
                               class="inline-block px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition">
                                Daftar Sekarang
                            </a>
                        @else
                            <button type="button"
                                class="inline-block px-4 py-2 bg-gray-400 text-white rounded cursor-not-allowed"
                                onclick="alert('Anda sudah mendaftar dan tervalidasi pada event ini.')">
                                Daftar Sekarang
                            </button>
                        @endif
                    @endif

                    <div class="my-6">
                        <span class="font-semibold">Thumbnail:</span><br>
                        <img src="{{ asset('storage/' . $event->thumbnail_event) }}" alt="Thumbnail" class="w-40 h-40 object-cover rounded shadow mt-2">
                    </div>

                    {{-- Komentar/Validasi Admin --}}
                    @php
                        $notif = \App\Models\Notifikasi::where('notifiable_id', $event->id_event)
                            ->where('notifiable_type', 'event')
                            ->latest()
                            ->first();
                    @endphp

                    <div class="mb-6">
                        <h4 class="font-bold mb-2">Komentar/Validasi Admin:</h4>
                        @if ($event->status_event == 1)
                            <span>-</span>
                        @else
                            @if ($isAdmin)
                                <form action="{{ route('event.komentar', $event->id_event) }}" method="POST" class="mb-2">
                                    @csrf
                                    <textarea name="isi_notifikasi" class="w-full border rounded p-2 mb-2" required>{{ $notif->isi_notifikasi ?? '' }}</textarea>
                                    <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                                        {{ $notif ? 'Ubah Komentar' : 'Tambah Komentar' }}
                                    </button>
                                </form>
                                @if ($notif && $notif->is_read)
                                    <div class="text-xs text-green-600 mb-2">Komentar sudah dibaca oleh user, Anda bisa mengubah komentar.</div>
                                @elseif($notif)
                                    <div class="text-xs text-yellow-600 mb-2">Komentar belum dibaca oleh user.</div>
                                @endif
                            @elseif($notif)
                                <div class="bg-gray-100 border-l-4 border-blue-400 p-3 mb-2">
                                    {{ $notif->isi_notifikasi }}
                                </div>
                                @if (!$notif->is_read)
                                    <form action="{{ route('notifikasi.read', $notif->id_notifikasi) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="text-xs text-blue-600 ml-2">Tandai sudah dibaca</button>
                                    </form>
                                @else
                                    <span class="text-xs text-green-600">Sudah dibaca</span>
                                @endif
                            @endif
                        @endif
                    </div>

                    {{-- Validasi Admin --}}
                    @if ($isAdmin && $event->status_event == 0)
                        <form action="{{ route('event.validate', $event->id_event) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600">
                                Validasi
                            </button>
                        </form>
                    @endif

                    {{-- Tombol Edit --}}
                    @if ($isCreator)
                        <a href="{{ route('event.edit', $event->id_event) }}"
                            class="inline-block px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 mt-2">
                            Edit Event
                        </a>
                    @endif

                    {{-- Tombol Kembali --}}
                    <a href="{{ route('dashboard') }}"
                        class="inline-block px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600 mt-2">
                        Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>