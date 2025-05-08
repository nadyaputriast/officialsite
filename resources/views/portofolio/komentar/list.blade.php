<div class="mt-6">
    <h3 class="text-lg font-semibold mb-4">Komentar</h3>
    @forelse ($portofolio->komentar as $komentar)
        <div class="mb-4 p-4 bg-gray-100 rounded shadow">
            <p class="text-sm text-gray-700">
                <strong>{{ $komentar->pengguna->nama_pengguna ?? 'Anonim' }}</strong> {{-- Tampilkan nama pengguna --}}
                <span class="text-gray-500 text-xs">{{ $komentar->created_at->diffForHumans() }}</span>
            </p>
            <p class="text-sm text-gray-700">{{ $komentar->komentar }}</p>
            @if ($komentar->lampiranKomentar->isNotEmpty())
                <div class="mt-2 grid grid-cols-3 gap-4">
                    @foreach ($komentar->lampiranKomentar as $lampiran)
                        <img src="{{ asset('storage/' . $lampiran->path_gambar) }}" alt="Lampiran" class="w-full h-32 object-cover rounded">
                    @endforeach
                </div>
            @endif
        </div>
    @empty
        <p class="text-gray-500">Belum ada komentar.</p>
    @endforelse
</div>