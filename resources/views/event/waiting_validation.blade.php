@if(isset($nomorTiket) && $nomorTiket)
    <div class="alert alert-success">
        Pembayaran Anda telah divalidasi.<br>
        <strong>Nomor Tiket: {{ $nomorTiket }}</strong>
    </div>
@else
    <div class="alert alert-info">
        Bukti pembayaran Anda sudah dikirim. Silakan tunggu validasi dari admin.
    </div>
@endif

<a href="{{ route('dashboard') }}" class="btn btn-secondary mt-4">Kembali ke Dashboard</a>