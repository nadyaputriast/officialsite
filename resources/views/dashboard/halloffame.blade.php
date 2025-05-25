{{-- Hall of Fame --}}
<div class="max-w-7xl mx-auto mt-6 mb-8">
    <div class="bg-yellow-100 border-l-4 border-yellow-500 p-6 rounded shadow">
        <h2 class="text-2xl font-bold mb-4 text-yellow-700">Hall of Fame Bulan Ini</h2>
        <div class="mb-4">
            <h3 class="font-semibold text-lg mb-2">Top 3 Portofolio</h3>
            @if ($topPortofolio->isNotEmpty())
                <ol class="list-decimal pl-6">
                    @foreach ($topPortofolio as $p)
                        <li>
                            <a href="{{ route('portofolio.show', $p->id_portofolio) }}" class="text-blue-600 underline">
                                {{ $p->nama_portofolio }}
                            </a>
                            <span class="ml-2 text-gray-600">({{ $p->view_count }} views)</span>
                        </li>
                    @endforeach
                </ol>
            @else
                <p class="text-gray-500">Belum ada portofolio bulan ini/bulan sebelumnya.</p>
            @endif
        </div>
        <div>
            <h3 class="font-semibold text-lg mb-2">Prestasi Internasional</h3>
            @if ($topPrestasi)
                <a href="{{ route('prestasi.show', $topPrestasi->id_prestasi) }}" class="text-blue-600 underline">
                    {{ $topPrestasi->nama_prestasi }}
                </a>
                <span class="ml-2 text-gray-600">({{ $topPrestasi->owner->nama_pengguna ?? '-' }})</span>
            @else
                <p class="text-gray-500">Belum ada prestasi internasional bulan ini/bulan sebelumnya.</p>
            @endif
        </div>
    </div>
</div>