<x-app-layout>
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-2xl mx-auto bg-white rounded-lg shadow-lg p-8">
            <div class="mb-6">
                <h2 class="text-2xl font-bold text-gray-800 mb-2">💳 Form Pendaftaran Event Berbayar</h2>
                <div class="bg-blue-50 border-l-4 border-blue-400 p-4 mb-4">
                    <div class="flex">
                        <div class="ml-3">
                            <p class="text-sm text-blue-700">
                                <strong>{{ $event->nama_event }}</strong><br>
                                {{ date('d/m/Y', strtotime($event->tanggal_event)) }} - {{ $event->waktu_event }}<br>
                                Kuota tersisa: <span class="font-semibold">{{ $event->kuota_event }}</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Error Messages --}}
            @if ($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded mb-4">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('event.register.store', $event->id_event) }}" method="POST"
                enctype="multipart/form-data" id="registrationForm">
                @csrf
                <input type="hidden" name="id_event" value="{{ $event->id_event }}">

                <div class="space-y-6">
                    {{-- Original Price --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Harga Event:</label>
                        <input type="text" value="Rp{{ number_format($event->harga_event, 0, ',', '.') }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-50 font-semibold"
                            readonly>
                    </div>

                    {{-- Promo Code --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Kode Promo (opsional):
                            <span class="text-xs text-gray-500">- Masukkan kode promo jika ada</span>
                        </label>
                        <div class="relative">
                            <input type="text" name="kode_promo" id="kode_promo"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                                value="{{ old('kode_promo') }}" placeholder="Masukkan kode promo">
                            <div id="promo_loading" class="absolute right-3 top-3 hidden">
                                <div class="animate-spin rounded-full h-4 w-4 border-b-2 border-blue-600"></div>
                            </div>
                        </div>
                        <div id="promo_message" class="mt-2 text-sm hidden"></div>
                    </div>

                    {{-- Total Payment --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Total Bayar:</label>
                        <input type="text" id="total_bayar"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-50 font-semibold text-lg text-green-600"
                            value="Rp{{ number_format($event->harga_event, 0, ',', '.') }}" readonly>
                        <div id="savings_info" class="mt-1 text-sm text-green-600 hidden"></div>
                    </div>

                    {{-- Payment Proof --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Bukti Pembayaran: <span class="text-red-500">*</span>
                        </label>
                        <input type="file" name="bukti_pembayaran"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                            accept="image/*" required>
                        <p class="mt-1 text-xs text-gray-500">
                            Upload gambar bukti pembayaran (JPG, PNG, GIF, max 2MB)
                        </p>
                    </div>

                    {{-- Payment Instructions --}}
                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                        <h4 class="font-medium text-yellow-800 mb-2">📋 Instruksi Pembayaran:</h4>
                        <ol class="text-sm text-yellow-700 space-y-1 list-decimal list-inside">
                            <li>Transfer sesuai nominal yang tertera di "Total Bayar"</li>
                            <li>Ke rekening: <strong>BCA 1234567890 a.n. Event Organizer</strong></li>
                            <li>Upload bukti transfer yang jelas dan lengkap</li>
                            <li>Tunggu validasi admin (maksimal 24 jam)</li>
                        </ol>
                    </div>
                </div>

                <div class="flex gap-4 mt-8">
                    <button type="submit"
                        class="flex-1 bg-blue-600 text-white py-3 px-6 rounded-lg hover:bg-blue-700 focus:ring-4 focus:ring-blue-200 font-medium transition">
                        Kirim & Daftar
                    </button>
                    <a href="{{ route('dashboard') }}"
                        class="px-6 py-3 bg-gray-500 text-white rounded-lg hover:bg-gray-600 focus:ring-4 focus:ring-gray-200 transition">
                        ← Kembali
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const kodePromoInput = document.getElementById('kode_promo');
            const totalBayarInput = document.getElementById('total_bayar');
            const promoMessage = document.getElementById('promo_message');
            const savingsInfo = document.getElementById('savings_info');
            const promoLoading = document.getElementById('promo_loading');

            const hargaEvent = {{ $event->harga_event }};
            let promoTimeout;

            console.log('=== REGISTRATION FORM DEBUG ===');
            console.log('Event ID:', {{ $event->id_event }});
            console.log('Event Price:', hargaEvent);
            console.log('Route URL:', "{{ route('cek.promo') }}");
            console.log('CSRF Token:', "{{ csrf_token() }}");

            // Debounced promo check
            kodePromoInput.addEventListener('input', function() {
                clearTimeout(promoTimeout);
                promoTimeout = setTimeout(checkPromo, 1000);
            });

            kodePromoInput.addEventListener('blur', checkPromo);

            function checkPromo() {
                const kodePromo = kodePromoInput.value.trim();

                console.log('=== PROMO CHECK START ===');
                console.log('Promo Code:', kodePromo);

                if (kodePromo.length === 0) {
                    resetPrice();
                    return;
                }

                // Show loading
                promoLoading.classList.remove('hidden');
                hideMessages();

                const controller = new AbortController();
                const timeoutId = setTimeout(() => controller.abort(), 10000); // 10 second timeout

                const requestData = {
                    kode_promo: kodePromo,
                    id_event: {{ $event->id_event }}
                };

                console.log('Request Data:', requestData);
                console.log('Fetch URL:', "{{ route('cek.promo') }}");

                fetch("{{ route('cek.promo') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': "{{ csrf_token() }}",
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: JSON.stringify(requestData),
                        signal: controller.signal
                    })
                    .then(response => {
                        clearTimeout(timeoutId);
                        console.log('=== RESPONSE RECEIVED ===');
                        console.log('Response Status:', response.status);
                        console.log('Response OK:', response.ok);
                        console.log('Response Headers:', [...response.headers.entries()]);
                        
                        if (!response.ok) {
                            throw new Error(`HTTP ${response.status}: ${response.statusText}`);
                        }
                        
                        return response.json();
                    })
                    .then(data => {
                        console.log('=== RESPONSE DATA ===');
                        console.log('Full Response:', data);
                        promoLoading.classList.add('hidden');

                        if (data.status === 'success' && data.data) {
                            const hargaPromo = data.data.harga_promo;
                            const penghematan = data.data.penghematan;

                            console.log('Promo Applied:', {
                                original: hargaEvent,
                                promo: hargaPromo,
                                savings: penghematan
                            });

                            totalBayarInput.value = 'Rp' + hargaPromo.toLocaleString('id-ID');

                            showMessage(`Promo "${data.data.kode_promo}" berhasil diterapkan!`, 'success');

                            savingsInfo.innerHTML =
                                `Hemat Rp${penghematan.toLocaleString('id-ID')} (${data.data.nilai_promo}${data.data.jenis_promo === 'Persentase' ? '%' : ''})`;
                            savingsInfo.classList.remove('hidden');

                        } else {
                            console.log('Promo Failed:', data.message || 'Unknown error');
                            resetPrice();
                            showMessage(`${data.message || 'Kode promo tidak valid atau sudah kedaluwarsa.'}`, 'error');
                        }
                    })
                    .catch(error => {
                        clearTimeout(timeoutId);
                        promoLoading.classList.add('hidden');
                        
                        console.error('=== FETCH ERROR ===');
                        console.error('Error Type:', error.name);
                        console.error('Error Message:', error.message);
                        console.error('Full Error:', error);
                        
                        resetPrice();
                        
                        let errorMessage = 'Gagal cek promo. ';
                        if (error.name === 'AbortError') {
                            errorMessage += 'Request timeout (lebih dari 10 detik).';
                        } else if (error.name === 'TypeError') {
                            errorMessage += 'Tidak dapat terhubung ke server.';
                        } else if (error.message.includes('HTTP')) {
                            errorMessage += `Server error: ${error.message}`;
                        } else {
                            errorMessage += 'Periksa koneksi internet Anda.';
                        }
                        
                        showMessage(errorMessage, 'error');
                    });
            }

            function resetPrice() {
                totalBayarInput.value = 'Rp' + hargaEvent.toLocaleString('id-ID');
                savingsInfo.classList.add('hidden');
                hideMessages();
            }

            function showMessage(message, type) {
                promoMessage.textContent = message;
                promoMessage.className = `mt-2 text-sm ${type === 'success' ? 'text-green-600' : 'text-red-600'}`;
                promoMessage.classList.remove('hidden');
            }

            function hideMessages() {
                promoMessage.classList.add('hidden');
            }

            document.getElementById('registrationForm').addEventListener('submit', function(e) {
                const fileInput = document.querySelector('input[name="bukti_pembayaran"]');

                if (!fileInput.files.length) {
                    e.preventDefault();
                    alert('Harap upload bukti pembayaran terlebih dahulu!');
                    return;
                }

                if (fileInput.files[0].size > 2048 * 1024) {
                    e.preventDefault();
                    alert('Ukuran file terlalu besar! Maksimal 2MB.');
                    return;
                }

                const submitBtn = this.querySelector('button[type="submit"]');
                submitBtn.innerHTML = 'Memproses...';
                submitBtn.disabled = true;
            });
        });
    </script>
</x-app-layout>
