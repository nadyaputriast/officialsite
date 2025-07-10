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

                    @php
                        $isAdmin = auth()->user()->hasRole('admin');
                        $isCreator = auth()->user()->id_pengguna == $event->id_pengguna;

                        $myRegistration = \App\Models\EventRegistration::where('id_event', $event->id_event)
                            ->where('id_pengguna', auth()->user()->id_pengguna)
                            ->first();

                        $myPembayaran = $myRegistration
                            ? \App\Models\PembayaranEvent::where(
                                'id_event_registration',
                                $myRegistration->id_event_registration,
                            )
                                ->where('status_validasi', 1)
                                ->first()
                            : null;

                        $hasValidTicket = $myRegistration && ($myRegistration->nomor_tiket || $myPembayaran);
                    @endphp

                    @if (!$isAdmin && !$isCreator)
                        <div class="mb-6">
                            @if ($event->status_event != 1)
                                <div
                                    class="bg-yellow-50 border border-yellow-200 text-yellow-800 px-4 py-3 rounded mb-4">
                                    Event ini belum divalidasi admin. Pendaftaran belum tersedia.
                                </div>
                            @elseif ($event->penyelenggara_event === 'eksternal')
                                <a href="{{ $event->tautan_event }}"
                                    class="inline-block px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium"
                                    target="_blank">
                                    Daftar di Website Penyelenggara
                                </a>
                            @elseif ($event->kuota_event <= 0)
                                <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded">
                                    Maaf, kuota event sudah habis
                                </div>
                            @elseif ($hasValidTicket)
                                <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded">
                                    Anda sudah terdaftar pada event ini
                                </div>
                            @else
                                <a href="{{ route('event.register', $event->id_event) }}" id="btn-daftar"
                                    class="inline-block px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition font-medium">
                                    @if ($event->harga_event == 0)
                                        Daftar Gratis
                                    @else
                                        Daftar & Bayar (Rp{{ number_format($event->harga_event, 0, ',', '.') }})
                                    @endif
                                </a>
                            @endif
                        </div>
                    @endif

                    <div class="flex gap-10">
                        {{-- Thumbnail --}}
                        <div class="mb-6">
                            <img src="{{ asset('storage/' . $event->thumbnail_event) }}" alt="{{ $event->nama_event }}"
                                class="w-full max-w-lg h-56 object-cover rounded-lg shadow-md">
                        </div>
                        <div class="w-max">
                            <div class="px-4 py-4 bg-gray-100 rounded-lg shadow-md">
                                <div class="mb-3">
                                    <span class="font-semibold text-gray-700">Harga Event:</span>
                                    <p class="text-gray-900 text-lg font-semibold">
                                        @if ($event->harga_event == 0)
                                            <span class="text-green-600">GRATIS</span>
                                        @else
                                            Rp{{ number_format($event->harga_event, 0, ',', '.') }}
                                        @endif
                                    </p>
                                </div>
                                @if ($event->penyelenggara_event === 'internal')
                                    <div>
                                        <span class="font-semibold text-gray-700">Kuota Tersisa:</span>
                                        <p class="text-gray-900">
                                            {{ $event->kuota_event }}
                                            @if ($event->kuota_event <= 10)
                                                <span class="text-red-500 text-sm">(Terbatas!)</span>
                                            @endif
                                        </p>
                                    </div>
                                @endif

                                @if ($event->penyelenggara_event === 'eksternal')
                                    <div>
                                        <span class="font-semibold text-gray-700">Link Pendaftaran:</span>
                                        <a href="{{ $event->tautan_event }}"
                                            class="text-blue-600 underline hover:text-blue-800" target="_blank">
                                            Klik di sini
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div class="space-y-3">
                            <div>
                                <span class="font-semibold text-gray-700">Nama Event:</span>
                                <p class="text-gray-900">{{ $event->nama_event }}</p>
                            </div>
                            <div>
                                <span class="font-semibold text-gray-700">Jenis Event:</span>
                                <p class="text-gray-900">{{ ucfirst($event->jenis_event) }}</p>
                            </div>
                        </div>

                        <div class="space-y-3">
                            <div>
                                <span class="font-semibold text-gray-700">Penyelenggara:</span>
                                <p class="text-gray-900">{{ ucfirst($event->penyelenggara_event) }} -
                                    {{ $event->nama_penyelenggara }}</p>
                            </div>
                            <div>
                                <span class="font-semibold text-gray-700">Tanggal & Waktu:</span>
                                <p class="text-gray-900">
                                    {{ date('d/m/Y', strtotime($event->tanggal_event)) }} - {{ $event->waktu_event }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="mb-6">
                        <span class="font-semibold text-gray-700">Deskripsi Event:</span>
                        <div class="bg-gray-100 p-4 rounded mt-2">
                            <p class="text-gray-800 leading-relaxed">{{ $event->deskripsi_event }}</p>
                        </div>
                    </div>

                    {{-- Tiket --}}
                    @if ($hasValidTicket)
                        <div class="mb-6">
                            {{-- ✅ ALTERNATIVE: Card with button style --}}
                            <div class="bg-green-50 border-2 border-green-200 rounded-xl p-6 relative overflow-hidden">
                                {{-- Decorative background --}}
                                <div
                                    class="absolute top-0 right-0 w-20 h-20 bg-green-200 rounded-full opacity-20 -translate-y-10 translate-x-10">
                                </div>

                                <div class="relative z-10">
                                    <div class="flex items-start justify-between mb-4">
                                        <div class="flex items-center">
                                            <div
                                                class="w-12 h-12 bg-green-500 rounded-full flex items-center justify-center mr-4">
                                                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            </div>
                                            <div>
                                                <h4 class="text-xl font-bold text-green-800 mb-1">Pendaftaran Berhasil!
                                                </h4>
                                                @if ($myRegistration->nomor_tiket)
                                                    <div class="flex items-center space-x-2 mb-2">
                                                        <span class="text-green-700 font-medium">Nomor Tiket:</span>
                                                        <div
                                                            class="bg-white border-2 border-green-300 px-3 py-1 rounded-lg">
                                                            <span
                                                                class="font-mono text-lg font-bold text-green-800">{{ $myRegistration->nomor_tiket }}</span>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>

                                        {{-- Status badge --}}
                                        <div class="flex flex-col items-end space-y-1">
                                            @if ($event->harga_event == 0)
                                                <span
                                                    class="px-3 py-1 bg-green-500 text-white text-xs font-semibold rounded-full">
                                                    AKTIF
                                                </span>
                                            @elseif($myPembayaran)
                                                <span
                                                    class="px-3 py-1 bg-green-500 text-white text-xs font-semibold rounded-full">
                                                    TERVALIDASI
                                                </span>
                                            @else
                                                <span
                                                    class="px-3 py-1 bg-yellow-500 text-white text-xs font-semibold rounded-full animate-pulse">
                                                    MENUNGGU
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    {{-- Status description --}}
                                    <div class="mb-6">
                                        @if ($event->harga_event == 0)
                                            <p class="text-green-700">Event gratis - Tiket Anda sudah aktif dan siap
                                                digunakan!</p>
                                        @elseif($myPembayaran)
                                            <p class="text-green-700">Pembayaran telah divalidasi admin. Tiket Anda
                                                sudah aktif!</p>
                                        @else
                                            <p class="text-yellow-700 flex items-center">
                                                <svg class="w-4 h-4 mr-2 animate-spin" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                                </svg>
                                                Bukti pembayaran sedang diproses admin. Klik tombol di bawah untuk cek
                                                status.
                                            </p>
                                        @endif
                                    </div>

                                    {{-- Action button --}}
                                    <div class="flex items-center justify-between">
                                        <div class="text-xs text-green-600 space-y-1">
                                            <p>Pendaftaran ID: #{{ $myRegistration->id_event_registration }}</p>
                                            <p>Terdaftar: {{ $myRegistration->created_at->format('d/m/Y H:i') }}</p>
                                        </div>

                                        <a href="{{ route('payment.waiting', $myRegistration->id_event_registration) }}"
                                            class="group inline-flex items-center px-6 py-3 bg-gradient-to-r from-green-600 to-emerald-600 text-white rounded-lg hover:from-green-700 hover:to-emerald-700 focus:ring-4 focus:ring-green-200 font-semibold transition-all transform hover:scale-105 shadow-lg">
                                            @if ($myRegistration->nomor_tiket)
                                                Lihat Tiket & Download
                                            @else
                                                Cek Status Validasi
                                            @endif
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if ($isAdmin || $isCreator)
                        <div class="bg-blue-50 border-l-4 border-blue-400 p-4 mb-6">
                            <h4 class="font-semibold text-blue-800 mb-2">📊 Info Admin/Pembuat</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                                <div>
                                    <span class="font-semibold">Status Validasi:</span>
                                    @if ($event->status_event == 1)
                                        <span class="text-green-600 font-semibold">Sudah Divalidasi</span>
                                    @else
                                        <span class="text-red-600 font-semibold">Belum Divalidasi</span>
                                    @endif
                                </div>

                                @if ($event->promo && $event->promo->count())
                                    <div>
                                        <span class="font-semibold">Promo:</span>
                                        <div class="text-blue-700">
                                            @php
                                                $currentPromo = $event->promo
                                                    ->where('id_event', $event->id_event)
                                                    ->first();
                                            @endphp

                                            @if ($currentPromo)
                                                <p><strong>Kode:</strong> {{ $currentPromo->kode_promo }}</p>
                                                <p><strong>Diskon:</strong>
                                                    {{ $currentPromo->nilai_promo }}{{ $currentPromo->jenis_promo == 'Persentase' ? '%' : '' }}
                                                </p>

                                                @php
                                                    $hargaAsli = $event->harga_event;
                                                    $nilaiPromo = $currentPromo->nilai_promo;
                                                    $jenisPromo = $currentPromo->jenis_promo;

                                                    // Hitung harga setelah diskon
                                                    if ($jenisPromo == 'Persentase') {
                                                        $hargaPromo = $hargaAsli - ($hargaAsli * $nilaiPromo) / 100;
                                                    } else {
                                                        // Jenis promo nominal/rupiah
                                                        $hargaPromo = $hargaAsli - $nilaiPromo;
                                                    }

                                                    // Pastikan harga tidak negatif
                                                    $hargaPromo = max(0, $hargaPromo);
                                                @endphp

                                                <div class="space-y-1">
                                                    <p><strong>Harga Normal:</strong>
                                                        <span
                                                            class="line-through text-gray-500">Rp{{ number_format($hargaAsli, 0, ',', '.') }}</span>
                                                    </p>
                                                    <p><strong>Harga Promo:</strong>
                                                        <span
                                                            class="text-green-600 font-bold">Rp{{ number_format($hargaPromo, 0, ',', '.') }}</span>
                                                        @if ($jenisPromo == 'Persentase')
                                                            <span class="text-sm text-green-600">(Hemat
                                                                {{ $nilaiPromo }}%)</span>
                                                        @else
                                                            <span class="text-sm text-green-600">(Hemat
                                                                Rp{{ number_format($nilaiPromo, 0, ',', '.') }})</span>
                                                        @endif
                                                    </p>
                                                </div>
                                            @else
                                                <p class="text-gray-500 italic">Promo tidak tersedia untuk event ini</p>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif

                    @php
                        $notif = \App\Models\Notifikasi::where('notifiable_id', $event->id_event)
                            ->where('notifiable_type', 'event')
                            ->latest()
                            ->first();
                    @endphp

                    <div class="mb-6">
                        <h4 class="font-bold mb-2">💬 Komentar/Validasi Admin:</h4>
                        @if ($event->status_event == 1)
                            <div class="bg-gray-50 p-3 rounded">
                                <span class="text-gray-600">Event sudah divalidasi - Tidak ada komentar khusus</span>
                            </div>
                        @else
                            @if ($isAdmin)
                                <form action="{{ route('event.komentar', $event->id_event) }}" method="POST"
                                    class="mb-2">
                                    @csrf
                                    <textarea name="isi_notifikasi" class="w-full border rounded p-2 mb-2" rows="3"
                                        placeholder="Berikan komentar atau saran untuk perbaikan event..." required>{{ $notif->isi_notifikasi ?? '' }}</textarea>
                                    <button type="submit"
                                        class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                                        {{ $notif ? 'Ubah Komentar' : 'Tambah Komentar' }}
                                    </button>
                                </form>
                                @if ($notif && $notif->is_read)
                                    <div class="text-xs text-green-600 mb-2">Komentar sudah dibaca oleh user</div>
                                @elseif($notif)
                                    <div class="text-xs text-yellow-600 mb-2">Komentar belum dibaca oleh user</div>
                                @endif
                            @elseif($notif)
                                <div class="bg-yellow-50 border-l-4 border-yellow-400 p-3 mb-2">
                                    <p class="text-yellow-800">{{ $notif->isi_notifikasi }}</p>
                                </div>
                                @if (!$notif->is_read)
                                    <form action="{{ route('notifikasi.read', $notif->id_notifikasi) }}"
                                        method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="text-xs text-blue-600 hover:text-blue-800">
                                            Tandai sudah dibaca
                                        </button>
                                    </form>
                                @else
                                    <span class="text-xs text-green-600">✅ Sudah dibaca</span>
                                @endif
                            @else
                                <div class="bg-gray-50 p-3 rounded">
                                    <span class="text-gray-600">Belum ada komentar dari admin</span>
                                </div>
                            @endif
                        @endif
                    </div>

                    {{-- Action Buttons --}}
                    <div class="flex flex-wrap gap-3">
                        {{-- Admin Validation --}}
                        @if ($isAdmin && $event->status_event == 0)
                            <form action="{{ route('admin.event.validate', $event->id_event) }}" method="POST"
                                class="inline">
                                @csrf
                                <button type="submit"
                                    class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600 font-medium"
                                    onclick="return confirm('Yakin ingin memvalidasi event ini?')">
                                    Validasi Event
                                </button>
                            </form>
                        @endif

                        {{-- Edit Button --}}
                        @if ($isCreator)
                            <a href="{{ route('event.edit', $event->id_event) }}"
                                class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 font-medium">
                                Edit Event
                            </a>
                        @endif

                        {{-- Back Button --}}
                        <a href="{{ route('dashboard') }}"
                            class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600 font-medium">
                            Kembali ke Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const registrationCard = document.querySelector('a[href*="payment-waiting"]');

            if (registrationCard) {
                registrationCard.addEventListener('click', function(e) {
                    // Add loading animation
                    const button = this.querySelector('button') || this;
                    const originalContent = button.innerHTML;

                    button.innerHTML = `
                    <svg class="w-5 h-5 mr-2 animate-spin" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                    Memuat...
                `;

                    // Restore original content if navigation fails
                    setTimeout(() => {
                        button.innerHTML = originalContent;
                    }, 3000);
                });
            }
        });

        @if ($hasValidTicket && !$myRegistration->nomor_tiket && !$myPembayaran)
            // Auto refresh every 30 seconds for pending validations
            setInterval(function() {
                // Only refresh if user is still on the page
                if (!document.hidden) {
                    window.location.reload();
                }
            }, 30000);

            // Show notification about auto-refresh
            setTimeout(function() {
                const notification = document.createElement('div');
                notification.className =
                    'fixed bottom-4 right-4 bg-blue-500 text-white px-4 py-2 rounded-lg shadow-lg z-50';
                notification.innerHTML =
                    '🔄 Halaman akan refresh otomatis setiap 30 detik untuk cek status validasi';
                document.body.appendChild(notification);

                setTimeout(() => {
                    notification.remove();
                }, 5000);
            }, 2000);
        @endif
    </script>
</x-app-layout>
