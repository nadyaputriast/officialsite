{{-- filepath: c:\laragon\www\officialsite\resources\views\dashboard\portofolio.blade.php --}}
{{-- Informasi Portofolio --}}
<div id="portofolio-section" class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-semibold">Informasi Portofolio</h3>
                </div>

                @if (auth()->user()->hasRole('admin'))
                    <table class="table-auto w-full border-collapse border border-gray-300">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="border border-gray-300 px-4 py-2" rowspan="2">Nama Portofolio</th>
                                <th class="border border-gray-300 px-4 py-2" rowspan="2">Deskripsi Portofolio
                                </th>
                                <th class="border border-gray-300 px-4 py-2" rowspan="2">Komentar/Notifikasi
                                </th>
                                <th class="border border-gray-300 px-4 py-2" rowspan="2">Status</th>
                                <th class="border border-gray-300 px-4 py-2" colspan="2">Aksi</th>
                            </tr>
                            <tr class="bg-gray-100">
                                <th class="border border-gray-300 px-4 py-2">Detail</th>
                                <th class="border border-gray-300 px-4 py-2">Validasi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($dataPortofolio as $portofolio)
                                <tr>
                                    <td class="border border-gray-300 px-4 py-2">
                                        {{ $portofolio->nama_portofolio }}</td>
                                    <td class="border border-gray-300 px-4 py-2">
                                        {{ $portofolio->deskripsi_portofolio }}</td>
                                    <td class="border border-gray-300 px-4 py-2">
                                        @php
                                            $notif = \App\Models\Notifikasi::where(
                                                'notifiable_id',
                                                $portofolio->id_portofolio,
                                            )
                                                ->where('notifiable_type', 'portofolio')
                                                ->latest()
                                                ->first();
                                        @endphp
                                        {{ $notif->isi_notifikasi ?? '-' }}
                                    </td>
                                    <td class="border border-gray-300 px-4 py-2">
                                        @if ($portofolio->status_portofolio == 1)
                                            <span
                                                class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                ✓ Sudah Divalidasi
                                            </span>
                                        @else
                                            <span
                                                class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                ⏳ Belum Divalidasi
                                            </span>
                                        @endif
                                    </td>
                                    <td class="border border-gray-300 px-4 py-2">
                                        <a href="{{ route('portofolio.show', $portofolio->id_portofolio) }}"
                                            class="text-blue-500 hover:underline">Detail</a>
                                    </td>
                                    <td class="border border-gray-300 px-4 py-2">
                                        @if ($portofolio->status_portofolio == 0)
                                            <form
                                                action="{{ route('portofolio.validate', $portofolio->id_portofolio) }}"
                                                method="POST" class="inline">
                                                @csrf
                                                <button type="submit"
                                                    class="text-blue-500 hover:underline">Validasi</button>
                                            </form>
                                        @else
                                            <span class="text-gray-500">Sudah Divalidasi</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-gray-500 py-4">Tidak ada informasi
                                        portofolio saat ini.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    {{-- Paginasi untuk Admin --}}
                    <div class="mt-4">
                        {{ $dataPortofolio->links() }}
                    </div>
                @else
                    {{-- Tampilan untuk User Biasa dengan Search & Filter --}}

                    {{-- Search & Filter Bar --}}
                    <div class="mb-6 bg-gray-50 rounded-lg p-4">
                        <form method="GET" action="{{ route('dashboard') }}#portofolio-section" class="space-y-4">
                            <div class="grid md:grid-cols-3 gap-4">
                                {{-- Search Bar --}}
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Cari Portofolio</label>
                                    <div class="relative">
                                        <input type="text" name="search" value="{{ request('search') }}"
                                            placeholder="Cari berdasarkan nama portofolio..."
                                            class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center">
                                            <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                    </div>
                                </div>

                                {{-- Sort Filter --}}
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Urutkan</label>
                                    <select name="sort"
                                        class="w-full py-2 px-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>
                                            Terakhir Upload</option>
                                        <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>
                                            Populer (Views)</option>
                                        <option value="liked" {{ request('sort') == 'liked' ? 'selected' : '' }}>
                                            Paling
                                            Disukai</option>
                                    </select>
                                </div>
                            </div>

                            {{-- Kategori Filter - Chip Style --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Kategori</label>
                                <div class="flex flex-wrap gap-2">
                                    @php
                                        $kategoriList = [
                                            'UI/UX Design',
                                            'Website Development',
                                            'Mobile Development',
                                            'Game Development',
                                            'Internet of Things',
                                            'ML/AI',
                                            'Blockchain',
                                            'Cyber Security',
                                        ];
                                        $selectedKategori = request('kategori', []);
                                        if (!is_array($selectedKategori)) {
                                            $selectedKategori = [$selectedKategori];
                                        }
                                    @endphp

                                    @foreach ($kategoriList as $kategori)
                                        <label class="cursor-pointer">
                                            <input type="checkbox" name="kategori[]" value="{{ $kategori }}"
                                                {{ in_array($kategori, $selectedKategori) ? 'checked' : '' }}
                                                class="sr-only peer">
                                            <div
                                                class="px-3 py-2 text-sm rounded-full border transition peer-checked:bg-blue-100 peer-checked:text-blue-800 peer-checked:border-blue-300 hover:bg-gray-100 bg-white text-gray-700 border-gray-300">
                                                {{ $kategori }}
                                            </div>
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            <div class="flex gap-3">
                                <button type="submit"
                                    class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition font-medium">
                                    Cari
                                </button>
                                <a href="{{ route('dashboard') }}#portofolio-section"
                                    class="bg-gray-200 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-300 transition font-medium">
                                    Reset
                                </a>
                            </div>
                        </form>
                    </div>

                    {{-- Results Info --}}
                    <div class="mb-4 flex justify-between items-center">
                        <div class="text-sm text-gray-600">
                            Menampilkan {{ $dataPortofolio->count() }} dari {{ $dataPortofolio->total() }} portofolio
                            @if (request('search'))
                                untuk "<strong>{{ request('search') }}</strong>"
                            @endif
                            @if (request('kategori') && count(request('kategori')) > 0)
                                dalam kategori
                                @foreach (request('kategori') as $index => $kat)
                                    <strong>"{{ $kat }}"</strong>
                                    @if ($index < count(request('kategori')) - 1)
                                        ,
                                    @endif
                                @endforeach
                            @endif
                        </div>
                        <a href="{{ route('portofolio.index') }}"
                            class="text-blue-600 hover:text-blue-800 text-sm font-medium hover:underline">
                            Lihat Semua →
                        </a>
                    </div>

                    {{-- Grid Portofolio --}}
                    @forelse ($dataPortofolio as $portofolio)
                        @if ($loop->first)
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @endif

                        <div
                            class="bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow-md transition overflow-hidden">
                            {{-- Gambar Portofolio --}}
                            <div class="aspect-video bg-gray-100 overflow-hidden">
                                @if ($portofolio->gambar && $portofolio->gambar->first())
                                    <img src="{{ asset('storage/' . $portofolio->gambar->first()->gambar_portofolio) }}"
                                        alt="{{ $portofolio->nama_portofolio }}"
                                        class="w-full h-full object-cover hover:scale-105 transition duration-300">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-400">
                                        <svg class="w-12 h-12" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                @endif
                            </div>

                            {{-- Content --}}
                            <div class="p-4">
                                <h3 class="font-semibold text-lg mb-2 line-clamp-2">
                                    {{ $portofolio->nama_portofolio }}
                                </h3>

                                <p class="text-gray-600 text-sm mb-3 line-clamp-3">
                                    {{ $portofolio->deskripsi_portofolio }}
                                </p>

                                {{-- Kategori Tags --}}
                                <div class="flex flex-wrap gap-1 mb-3">
                                    @foreach ($portofolio->kategori as $kat)
                                        <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs rounded-full">
                                            {{ $kat->kategori_portofolio }}
                                        </span>
                                    @endforeach
                                </div>

                                {{-- Stats --}}
                                <div class="flex justify-between items-center text-sm text-gray-500 mb-4">
                                    <div class="flex gap-4">
                                        <span class="flex items-center gap-1">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                                <path fill-rule="evenodd"
                                                    d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            {{ $portofolio->view_count }}
                                        </span>
                                        <span class="flex items-center gap-1">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path
                                                    d="M2 10.5a1.5 1.5 0 113 0v6a1.5 1.5 0 01-3 0v-6zM6 10.333v5.43a2 2 0 001.106 1.79l.05.025A4 4 0 008.943 18h5.416a2 2 0 001.962-1.608l1.2-6A2 2 0 0015.56 8H12V4a2 2 0 00-2-2 1 1 0 00-1 1v.667a4 4 0 01-.8 2.4L6.8 7.933a4 4 0 00-.8 2.4z" />
                                            </svg>
                                            {{ $portofolio->banyak_upvote }}
                                        </span>
                                        <span class="flex items-center gap-1">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path
                                                    d="M18 9.5a1.5 1.5 0 11-3 0v-6a1.5 1.5 0 013 0v6zM14 9.667v-5.43a2 2 0 00-1.106-1.79l-.05-.025A4 4 0 0011.057 2H5.64a2 2 0 00-1.962 1.608l-1.2 6A2 2 0 004.44 12H8v4a2 2 0 002 2 1 1 0 001-1v-.667a4 4 0 01.8-2.4l1.4-1.866a4 4 0 00.8-2.4z" />
                                            </svg>
                                            {{ $portofolio->banyak_downvote }}
                                        </span>
                                    </div>
                                </div>

                                {{-- Owner --}}
                                <div class="text-xs text-gray-500 mb-3">
                                    by <span
                                        class="font-medium">{{ $portofolio->owner->nama_pengguna ?? 'Unknown' }}</span>
                                </div>

                                {{-- Action Button --}}
                                <a href="{{ route('portofolio.show', $portofolio->id_portofolio) }}"
                                    class="block w-full bg-blue-600 text-white text-center px-4 py-2 rounded-lg hover:bg-blue-700 transition font-medium">
                                    Lihat Detail
                                </a>
                            </div>
                        </div>

                        @if ($loop->last)
            </div>
            @endif
        @empty
            <div class="text-center py-12">
                <div class="text-gray-400 mb-4">
                    <svg class="w-16 h-16 mx-auto" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zm0 4a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1V8zm8 0a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1V8z"
                            clip-rule="evenodd" />
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Tidak ada portofolio</h3>
                <p class="text-gray-600 mb-6">
                    @if (request('search') || request('kategori'))
                        Tidak ditemukan portofolio yang sesuai dengan kriteria pencarian.
                    @else
                        Belum ada portofolio yang tersedia saat ini.
                    @endif
                </p>
                <div class="flex gap-3 justify-center">
                    @if (request('search') || request('kategori'))
                        <a href="{{ route('dashboard') }}#portofolio-section"
                            class="bg-gray-600 text-white px-6 py-3 rounded-lg hover:bg-gray-700 transition">
                            Lihat Semua Portofolio
                        </a>
                    @endif
                    <a href="{{ route('portofolio.create') }}"
                        class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition">
                        + Tambah Portofolio
                    </a>
                </div>
            </div>
            @endforelse

            {{-- Pagination --}}
            @if ($dataPortofolio->hasPages())
                <div class="mt-8">
                    {{ $dataPortofolio->appends(request()->query())->links() }}
                </div>
            @endif
            @endif
        </div>
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

    .line-clamp-3 {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>
