<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="text-center mb-8">
        <div class="flex flex-col sm:flex-row items-center justify-center gap-3 mb-4">
            <div class="text-yellow-600">
            </div>
            <h2 class="text-3xl font-bold text-center mb-2 mt-8">🏆Proyek Unggulan Mahasiswa🏆</h2>
        </div>
        <p class="text-center text-gray-600 mb-10">Jelajahi karya-karya terbaik yang telah diunggah oleh Mahasiswa
            Informatika, Universitas Udayana</p>
    </div>
    {{-- Top 3 Portofolio --}}
    <div class="mb-12">
        <div class="flex flex-col sm:flex-row items-center justify-center gap-2 mb-6">
            <div class="text-blue-600">
            </div>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
            @forelse ($topPortofolio as $index => $p)
                <div
                    class="bg-white rounded-xl p-6 shadow-md border hover:shadow-lg transition-all duration-300 hover:-translate-y-1 relative flex flex-col">
                    @if ($index === 0)
                        <div
                            class="absolute -top-3 -right-3 bg-yellow-500 text-white w-8 h-8 rounded-full flex items-center justify-center font-bold text-sm">
                            1</div>
                    @elseif($index === 1)
                        <div
                            class="absolute -top-3 -right-3 bg-gray-400 text-white w-8 h-8 rounded-full flex items-center justify-center font-bold text-sm">
                            2</div>
                    @elseif($index === 2)
                        <div
                            class="absolute -top-3 -right-3 bg-orange-500 text-white w-8 h-8 rounded-full flex items-center justify-center font-bold text-sm">
                            3</div>
                    @endif
                    <div class="text-center flex-1 flex flex-col">
                        @if ($p->gambar && $p->gambar->first())
                            <div class="w-full h-40 bg-gray-200 rounded-xl overflow-hidden mb-4">
                                <img src="{{ asset('storage/' . $p->gambar->first()->gambar_portofolio) }}"
                                    alt="{{ $p->nama_portofolio }}"
                                    class="w-full h-full object-cover hover:scale-105 transition duration-300">
                            </div>
                        @else
                            <div
                                class="w-full h-40 bg-gray-100 rounded-xl flex items-center justify-center mb-4 border-2 border-dashed border-gray-300">
                                <div class="text-gray-400 text-center">
                                    <svg class="w-12 h-12 mx-auto mb-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    <span class="text-sm">No Image</span>
                                </div>
                            </div>
                        @endif
                        <a href="{{ route('portofolio.show', $p->id_portofolio) }}"
                            class="text-blue-600 hover:text-blue-800 font-semibold hover:underline block mb-3 line-clamp-2 text-lg">
                            {{ $p->nama_portofolio }}
                        </a>
                        <p class="text-gray-600 mb-4 line-clamp-2">
                            {{ Str::limit($p->deskripsi_portofolio, 100) }}</p>
                        <div class="flex flex-wrap gap-2 justify-center mb-4">
                            @foreach ($p->kategori as $kategori)
                                <span class="px-3 py-1 bg-blue-100 text-blue-800 text-xs rounded-full">
                                    {{ $kategori->kategori_portofolio }}
                                </span>
                            @endforeach
                        </div>
                        <div class="mb-4 text-sm text-gray-600">
                            @php
                                $allUsers = collect();
                                if ($p->owner) {
                                    $allUsers->push([
                                        'nama' => $p->owner->nama_pengguna,
                                        'id' => $p->owner->id_pengguna,
                                    ]);
                                }
                                if ($p->taggedUsers && $p->taggedUsers->isNotEmpty()) {
                                    foreach ($p->taggedUsers as $tagged) {
                                        $allUsers->push([
                                            'nama' => $tagged->nama_pengguna,
                                            'id' => $tagged->id_pengguna,
                                        ]);
                                    }
                                }
                            @endphp
                            @if ($allUsers->isNotEmpty())
                                by
                                @foreach ($allUsers as $i => $user)
                                    <a href="{{ route('profile.user', $user['id']) }}"
                                        class="text-blue-600 hover:underline font-medium">{{ $user['nama'] }}</a>
                                    @if ($i < $allUsers->count() - 2)
                                        ,
                                    @elseif ($i == $allUsers->count() - 2)
                                        dan
                                    @endif
                                @endforeach
                            @endif
                        </div>
                        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg p-4 mt-auto">
                            <div class="text-2xl font-bold text-blue-600">{{ $p->view_count }}</div>
                            <div class="text-sm text-gray-500">views</div>
                        </div>
                    </div>
                </div>
            @empty
                <div
                    class="col-span-1 sm:col-span-2 md:col-span-3 text-center py-12 bg-white rounded-xl border border-gray-200">
                    <div class="text-gray-400 mb-4">
                        <svg class="w-16 h-16 mx-auto" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zm0 4a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1V8zm8 0a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1V8z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-700 mb-2">Belum ada portofolio</h3>
                    <p class="text-gray-500">Belum ada portofolio yang terdaftar bulan ini</p>
                </div>
            @endforelse
        </div>
    </div>
    {{-- Top Prestasi --}}
    <div>
        <div class="flex flex-col sm:flex-row items-center justify-center gap-2 mb-6">
            <div class="text-green-600">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                    <path
                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                </svg>
            </div>
            <h3 class="text-xl font-semibold text-gray-800">Prestasi Terbaik</h3>
            <div class="text-green-600">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                    <path
                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                </svg>
            </div>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 mb-12">
            @if ($topPrestasi && count($topPrestasi) > 0)
                @foreach ($topPrestasi as $prestasi)
                    <div
                        class="bg-white rounded-xl shadow-md p-6 border hover:shadow-lg transition-all duration-300 hover:-translate-y-1 flex flex-col">
                        <div class="mb-2">
                            <span
                                class="inline-block px-3 py-1 rounded-full text-xs font-semibold
                            @if ($prestasi['tingkatan_prestasi'] == 'Internasional') bg-yellow-500
                            @elseif($prestasi['tingkatan_prestasi'] == 'Nasional') bg-blue-500
                            @else bg-green-500 @endif
                            text-white">
                                {{ $prestasi['tingkatan_prestasi'] }}
                            </span>
                        </div>
                        {{-- <h3 class="font-semibold text-lg mb-2">{{ $prestasi['nama_prestasi'] }}</h3> --}}
                        <a href="{{ route('prestasi.show', $prestasi['id_prestasi']) }}"
                            class="text-blue-600 hover:text-blue-800 font-semibold hover:underline block mb-3 line-clamp-2 text-lg">
                            {{ $prestasi['nama_prestasi'] }}
                        </a>
                        <p class="text-gray-600 text-sm mb-3">
                            {{ Str::limit($prestasi['deskripsi_prestasi'], 100) }}
                        </p>
                        @if (isset($prestasi['owner']) && $prestasi['owner'])
                            <div class="flex items-center text-sm text-gray-500 mb-2">
                                Ketua:
                                <a href="{{ route('profile.user', $prestasi['owner']['id_pengguna']) }}"
                                    class="text-blue-600 hover:underline font-medium">
                                    {{ $prestasi['owner']['nama_pengguna'] }}
                                </a>
                            </div>
                        @endif
                        <div class="text-xs text-gray-400 mt-auto">
                            {{ \Carbon\Carbon::parse($prestasi['created_at'])->format('d M Y') }}
                        </div>
                    </div>
                @endforeach
            @else
                <div class="col-span-1 sm:col-span-2 md:col-span-3 text-center text-gray-500 py-8">
                    <p>Belum ada prestasi bulan ini</p>
                </div>
            @endif
        </div>
    </div>
</div>
</div>
