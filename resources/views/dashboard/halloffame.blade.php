{{-- filepath: c:\laragon\www\officialsite\resources\views\dashboard\halloffame.blade.php --}}
<div class="max-w-7xl mx-auto mt-6 mb-8">
    <div class="bg-gradient-to-br from-yellow-50 to-orange-50 border border-yellow-200 rounded-lg shadow-lg p-6">
        <div class="flex items-center gap-3 mb-6">
            <div class="text-yellow-600">
                <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                    <path
                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                </svg>
            </div>
            <h2 class="text-2xl font-bold text-yellow-700">🏆 Hall of Fame Bulan Ini</h2>
        </div>

        {{-- Top 3 Portofolio Row --}}
        <div class="mb-8">
            <div class="flex items-center gap-2 mb-4">
                <div class="text-blue-600">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zm0 4a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1V8zm8 0a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1V8z"
                            clip-rule="evenodd" />
                    </svg>
                </div>
                <h3 class="font-semibold text-xl text-gray-800">Top 3 Portofolio</h3>
            </div>

            @if ($topPortofolio->isNotEmpty())
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    @foreach ($topPortofolio as $index => $p)
                        <div
                            class="bg-white rounded-lg p-5 shadow-sm border border-gray-200 hover:shadow-md transition">

                            {{-- Content --}}
                            <div class="text-center">
                                @if ($p->gambar && $p->gambar->first())
                                    <div class="w-full h-32 bg-gray-200 rounded-lg overflow-hidden mb-2">
                                        <img src="{{ asset('storage/' . $p->gambar->first()->gambar_portofolio) }}"
                                            alt="{{ $p->nama_portofolio }}"
                                            class="w-full h-full object-cover hover:scale-105 transition duration-300">
                                    </div>
                                @else
                                    <div
                                        class="w-full h-32 bg-gray-100 rounded-lg flex items-center justify-center mb-2 border-2 border-dashed border-gray-300">
                                        <div class="text-gray-400 text-center">
                                            <svg class="w-8 h-8 mx-auto mb-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            <span class="text-xs">No Image</span>
                                        </div>
                                    </div>
                                @endif

                                <a href="{{ route('portofolio.show', $p->id_portofolio) }}"
                                    class="text-blue-600 hover:text-blue-800 font-semibold hover:underline block mb-2 line-clamp-2">
                                    {{ $p->nama_portofolio }}
                                </a>

                                <p class="text-sm text-gray-600 mb-2">{{ Str::limit($p->deskripsi_portofolio, 80) }}</p>

                                <div class="flex flex-wrap gap-1 justify-center mb-3">
                                    @foreach ($p->kategori as $kategori)
                                        <a href="{{ route('portofolio.index', ['kategori' => $kategori->kategori_portofolio]) }}"
                                            class="px-2 py-1 bg-blue-100 text-blue-800 text-xs rounded-full hover:bg-blue-200 transition">
                                            {{ $kategori->kategori_portofolio }}
                                        </a>
                                    @endforeach
                                </div>

                                <div class="mb-4">
                                    @php
                                        $allUsers = collect();
                                        if ($p->owner) {
                                            $allUsers->push([
                                                'nama' => $p->owner->nama_pengguna,
                                                'id' => $p->owner->id_pengguna,
                                            ]);
                                        }
                                        if ($p->taggedUsers->isNotEmpty()) {
                                            foreach ($p->taggedUsers as $tagged) {
                                                $allUsers->push([
                                                    'nama' => $tagged->nama_pengguna,
                                                    'id' => $tagged->id_pengguna,
                                                ]);
                                            }
                                        }
                                    @endphp

                                    @if ($allUsers->isNotEmpty())
                                        @foreach ($allUsers as $i => $user)
                                            <a href="{{ route('profile.user', $user['id']) }}"
                                                class="text-blue-600 hover:underline">{{ $user['nama'] }}</a>
                                            @if ($i < $allUsers->count() - 2)
                                                ,
                                            @elseif ($i == $allUsers->count() - 2)
                                                dan
                                            @endif
                                        @endforeach
                                    @else
                                        Tidak ada pengguna terkait
                                    @endif
                                </div>
                                <div class="bg-gray-50 rounded-lg p-3">
                                    <div class="text-xl font-bold text-gray-800">{{ $p->view_count }}</div>
                                    <div class="text-xs text-gray-500">views</div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8 bg-white rounded-lg border border-gray-200">
                    <div class="text-gray-400 mb-2">
                        <svg class="w-16 h-16 mx-auto" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zm0 4a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1V8zm8 0a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1V8z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <p class="text-gray-500">Belum ada portofolio bulan ini</p>
                </div>
            @endif
        </div>

        {{-- Top 3 Prestasi Row --}}
        <div>
            <div class="flex items-center gap-2 mb-4">
                <div class="text-green-600">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                    </svg>
                </div>
                <h3 class="font-semibold text-xl text-gray-800">Top 3 Prestasi</h3>
            </div>

            @if ($topPrestasi)
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    {{-- Jika hanya ada 1 prestasi, buat 3 slot dan tampilkan di slot pertama --}}
                    @for ($i = 0; $i < 3; $i++)
                        @if ($i == 0 && $topPrestasi)
                            <div
                                class="bg-white rounded-lg p-5 shadow-sm border border-green-200 hover:shadow-md transition">
                                {{-- Medal --}}
                                <div class="flex items-center justify-center mb-4">
                                    <div
                                        class="w-12 h-12 bg-green-500 text-white rounded-full flex items-center justify-center font-bold text-lg shadow-lg">
                                        🏆
                                    </div>
                                </div>

                                {{-- Content --}}
                                <div class="text-center">
                                    <a href="{{ route('prestasi.show', $topPrestasi->id_prestasi) }}"
                                        class="text-green-700 hover:text-green-900 font-semibold hover:underline block mb-2 line-clamp-2">
                                        {{ $topPrestasi->nama_prestasi }}
                                    </a>
                                    <div class="text-sm text-gray-600 mb-3">
                                        by {{ $topPrestasi->owner->nama_pengguna ?? 'Unknown' }}
                                    </div>
                                    <div class="bg-green-50 rounded-lg p-3">
                                        <div class="text-sm font-medium text-green-700">
                                            {{ $topPrestasi->tingkat_prestasi ?? 'Internasional' }}</div>
                                        <div class="text-xs text-gray-500">
                                            {{ $topPrestasi->tanggal_prestasi ? date('M Y', strtotime($topPrestasi->tanggal_prestasi)) : '' }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div
                                class="bg-gray-50 rounded-lg p-5 border-2 border-dashed border-gray-200 flex flex-col items-center justify-center text-gray-400 min-h-[200px]">
                                <div class="text-4xl mb-2">-</div>
                                <div class="text-sm">Slot {{ $i + 1 }}</div>
                                <div class="text-xs">Belum tersedia</div>
                            </div>
                        @endif
                    @endfor
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    @for ($i = 0; $i < 3; $i++)
                        <div
                            class="bg-gray-50 rounded-lg p-5 border-2 border-dashed border-gray-200 flex flex-col items-center justify-center text-gray-400 min-h-[200px]">
                            <div class="text-4xl mb-2">-</div>
                            <div class="text-sm">Slot {{ $i + 1 }}</div>
                            <div class="text-xs">Belum tersedia</div>
                        </div>
                    @endfor
                </div>
            @endif
        </div>
    </div>
</div>

<style>
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>
