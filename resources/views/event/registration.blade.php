<h2>Form Pendaftaran Event Berbayar</h2>
<form action="{{ route('event.register.store', $event->id_event) }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div>
        <label>Harga Event:</label>
        <input type="text" value="Rp{{ number_format($event->harga_event, 0, ',', '.') }}" class="form-input" readonly>
    </div>
    <div>
        <label>Kode Promo (opsional):</label>
        <input type="text" name="kode_promo" class="form-input" value="{{ old('kode_promo') }}">
    </div>
    <div>
        <label>Total Bayar:</label>
        <input type="text" id="total_bayar" name="total_bayar" class="form-input"
            value="Rp{{ number_format($event->harga_event, 0, ',', '.') }}" readonly>
    </div>
    <div>
        <label>Bukti Pembayaran:</label>
        <input type="file" name="bukti_pembayaran" class="form-input" required>
    </div>
    <button type="submit" class="btn btn-primary mt-2">Kirim & Daftar</button>
    <a href="{{ route('dashboard') }}"
        class="inline-block px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600 mt-2">
        Kembali
    </a>
</form>

<script>
    document.querySelector('input[name="kode_promo"]').addEventListener('blur', function() {
        let kodePromo = this.value.trim();
        let hargaEvent = {{ $event->harga_event }};
        let totalBayarInput = document.getElementById('total_bayar');

        if (kodePromo.length === 0) {
            totalBayarInput.value = 'Rp' + hargaEvent.toLocaleString('id-ID');
            return;
        }

        fetch("{{ url('/cek-promo') }}?kode_promo=" + encodeURIComponent(kodePromo) +
                "&id_event={{ $event->id_event }}")
            .then(response => response.json())
            .then(data => {
                if (data.status === 'ok') {
                    totalBayarInput.value = 'Rp' + data.harga_promo.toLocaleString('id-ID');
                } else {
                    totalBayarInput.value = 'Rp' + hargaEvent.toLocaleString('id-ID');
                    alert(data.message || 'Kode promo tidak valid atau sudah kedaluwarsa.');
                }
            })
            .catch(() => {
                totalBayarInput.value = 'Rp' + hargaEvent.toLocaleString('id-ID');
                alert('Gagal cek promo.');
            });
    });
</script>
