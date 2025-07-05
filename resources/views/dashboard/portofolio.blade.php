<section class="bg-[#DDF1FB]">
    <div id="portofolio-section" class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div
                class="bg-white rounded-xl p-4 sm:p-6 shadow-md border hover:shadow-lg transition-all duration-300 hover:-translate-y-1 relative">
                <div class="p-0 sm:p-6 text-gray-900">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-3">
                        <h3 class="text-lg text-center font-semibold">Informasi Portofolio</h3>
                        @auth
                            <a href="{{ route('portofolio.create') }}"
                                class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition text-center">
                                + Tambah Portofolio
                            </a>
                        @endauth
                    </div>

                    @if (auth()->user()->hasRole('admin'))
                        <div class="mb-6 bg-gray-50 rounded-lg p-4">
                            {{-- ...form filter admin (tidak diubah) --}}
                            <form method="GET" class="space-y-4">
                                <input type="hidden" name="tab" value="portofolio">

                                <div class="grid md:grid-cols-4 gap-4">
                                    {{-- Search Bar --}}
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Cari
                                            Portofolio</label>
                                        <input type="text" name="search_portofolio"
                                            value="{{ request('search_portofolio') }}"
                                            placeholder="Cari berdasarkan nama portofolio..."
                                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    </div>

                                    {{-- Filter Status --}}
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Status
                                            Portofolio</label>
                                        <select name="status_portofolio"
                                            class="w-full py-2 px-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                            <option value="">Semua Status</option>
                                            <option value="1"
                                                {{ request('status_portofolio') == '1' ? 'selected' : '' }}>Sudah
                                                Divalidasi</option>
                                            <option value="0"
                                                {{ request('status_portofolio') == '0' ? 'selected' : '' }}>Belum
                                                Divalidasi</option>
                                        </select>
                                    </div>

                                    {{-- Filter View Count --}}
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Tingkat
                                            Popularitas</label>
                                        <select name="view_count_filter"
                                            class="w-full py-2 px-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                            <option value="">Semua View</option>
                                            <option value="0-100"
                                                {{ request('view_count_filter') == '0-100' ? 'selected' : '' }}>0-100
                                                views</option>
                                            <option value="100-500"
                                                {{ request('view_count_filter') == '100-500' ? 'selected' : '' }}>
                                                100-500 views</option>
                                            <option value="500-1000"
                                                {{ request('view_count_filter') == '500-1000' ? 'selected' : '' }}>
                                                500-1K views</option>
                                            <option value="1000+"
                                                {{ request('view_count_filter') == '1000+' ? 'selected' : '' }}>🚀 1K+
                                                views</option>
                                        </select>
                                    </div>

                                    {{-- Sort --}}
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Urutkan</label>
                                        <select name="sort"
                                            class="w-full py-2 px-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                            <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>
                                                Terbaru</option>
                                            <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>
                                                Terlama</option>
                                            <option value="popular"
                                                {{ request('sort') == 'popular' ? 'selected' : '' }}>Paling Populer
                                            </option>
                                            <option value="liked" {{ request('sort') == 'liked' ? 'selected' : '' }}>
                                                Paling Disukai</option>
                                            <option value="name_asc"
                                                {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Nama A-Z
                                            </option>
                                        </select>
                                    </div>
                                </div>

                                {{-- Multi-select Kategori & Sort --}}
                                <div class="grid md:grid-cols-2 gap-4">
                                    {{-- Kategori Filter --}}
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Kategori
                                            Portofolio</label>
                                        <div class="grid grid-cols-2 gap-2">
                                            @php
                                                $kategoriOptions = [
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

                                            @foreach ($kategoriOptions as $kategori)
                                                <label class="flex items-center space-x-2 cursor-pointer">
                                                    <input type="checkbox" name="kategori[]"
                                                        value="{{ $kategori }}"
                                                        {{ in_array($kategori, $selectedKategori) ? 'checked' : '' }}
                                                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 focus:ring-2 rounded">
                                                    <span class="text-sm text-gray-700">{{ $kategori }}</span>
                                                </label>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>

                                <div class="flex gap-3 mt-8">
                                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">
                                        Cari
                                    </button>
                                    <a href="{{ route('dashboard', ['tab' => 'portofolio']) }}"
                                        class="bg-gray-200 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-300 transition font-medium">
                                        Reset
                                    </a>
                            </form>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="table-auto w-full border-collapse border border-gray-300 mt-6">
                                <thead>
                                    <tr class="bg-gray-100">
                                        <th class="border border-gray-300 px-2 sm:px-4 py-2">Nama Portofolio</th>
                                        <th class="border border-gray-300 px-2 sm:px-4 py-2">Deskripsi Portofolio</th>
                                        <th class="border border-gray-300 px-2 sm:px-4 py-2">Banyak Dilihat (kali)</th>
                                        <th class="border border-gray-300 px-2 sm:px-4 py-2">Banyak Upvote</th>
                                        <th class="border border-gray-300 px-2 sm:px-4 py-2">Banyak Downvote</th>
                                        <th class="border border-gray-300 px-2 sm:px-4 py-2">Dokumen Portofolio</th>
                                        <th class="border border-gray-300 px-2 sm:px-4 py-2">Kategori Portofolio</th>
                                        <th class="border border-gray-300 px-2 sm:px-4 py-2">Gambar Portofolio</th>
                                        <th class="border border-gray-300 px-2 sm:px-4 py-2">Tautan Portofolio</th>
                                        <th class="border border-gray-300 px-2 sm:px-4 py-2">Tools Portofolio</th>
                                        <th class="border border-gray-300 px-2 sm:px-4 py-2">Komentar/Notifikasi</th>
                                        <th class="border border-gray-300 px-2 sm:px-4 py-2">Status</th>
                                        <th class="border border-gray-300 px-2 sm:px-4 py-2">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($dataPortofolio as $portofolio)
                                        <tr class="hover:bg-gray-50">
                                            <td class="border border-gray-300 px-4 py-2">
                                                {{ $portofolio->nama_portofolio }}</td>
                                            <td class="border border-gray-300 px-4 py-2">
                                                {{ $portofolio->deskripsi_portofolio }}</td>
                                            <td class="border border-gray-300 px-4 py-2">{{ $portofolio->view_count }}
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2">
                                                {{ $portofolio->banyak_upvote }}
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2">
                                                {{ $portofolio->banyak_downvote }}
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2">
                                                @if ($portofolio->dokumen_portofolio)
                                                    <a href="{{ asset('storage/' . $portofolio->dokumen_portofolio) }}"
                                                        target="_blank" class="inline-flex items-center text-blue-500">
                                                        Lihat Dokumen
                                                    </a>
                                                @else
                                                    <span class="text-gray-400 text-sm">-</span>
                                                @endif
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2">
                                                @if ($portofolio->kategori->count() > 0)
                                                    <div class="space-y-1 max-w-xs">
                                                        @foreach ($portofolio->kategori as $kategori)
                                                            <div>- {{ $kategori->kategori_portofolio }}</div>
                                                        @endforeach
                                                    </div>
                                                @else
                                                    <span class="text-gray-400 text-sm">Tidak ada kategori</span>
                                                @endif
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2">
                                                @if ($portofolio->gambar->count() > 0)
                                                    @foreach ($portofolio->gambar as $gambar)
                                                        <a href="{{ asset('storage/' . $gambar->gambar_portofolio) }}"
                                                            target="_blank">
                                                            <img src="{{ asset('storage/' . $gambar->gambar_portofolio) }}"
                                                                alt="Gambar" class="w-12 h-12 object-cover" />
                                                        </a>
                                                    @endforeach
                                                @else
                                                    <span class="text-gray-400 text-sm">-</span>
                                                @endif
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2">
                                                @if ($portofolio->tautan->count() > 0)
                                                    @foreach ($portofolio->tautan as $tautan)
                                                        <div class="mb-1">
                                                            <a href="{{ $tautan->tautan_portofolio }}" target="_blank"
                                                                class="text-blue-600 hover:underline text-sm block">
                                                                {{ Str::limit($tautan->tautan_portofolio, 25) }}
                                                            </a>
                                                        </div>
                                                    @endforeach
                                                @else
                                                    <span class="text-gray-400 text-sm">-</span>
                                                @endif
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2">
                                                @if ($portofolio->tools->count() > 0)
                                                    <div class="space-y-1 max-w-xs">
                                                        @foreach ($portofolio->tools as $tools)
                                                            <div>- {{ $tools->tools_portofolio }}</div>
                                                        @endforeach
                                                    </div>
                                                @else
                                                    <span class="text-gray-400 text-sm">Tidak ada tools</span>
                                                @endif
                                            </td>
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
                                                <div class="space-y-2">
                                                    @if ($notif && $notif->isi_notifikasi)
                                                        {{ $notif->isi_notifikasi }}
                                                    @endif

                                                    @if ($portofolio->status_portofolio == 0)
                                                        <form
                                                            action="{{ route('portofolio.komentar', $portofolio->id_portofolio) }}"
                                                            method="POST" class="flex gap-1">
                                                            @csrf
                                                            <textarea name="isi_notifikasi" class="flex-1 border rounded p-1" rows="1" placeholder="Komentar..." required>{{ $notif->isi_notifikasi ?? '' }}</textarea>
                                                            <button type="submit"
                                                                class="px-4 py-2 text-white bg-blue-500 hover:bg-blue-600 rounded">
                                                                Kirim
                                                            </button>
                                                        </form>
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2">
                                                @if ($portofolio->status_portofolio == 1)
                                                    <span
                                                        class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                        ✅ Tervalidasi
                                                    </span>
                                                @else
                                                    <span
                                                        class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                        ⏳ Belum Divalidasi
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2">
                                                <div class="flex gap-2 flex-wrap">
                                                    {{-- Validation Button --}}
                                                    @if ($portofolio->status_portofolio == 0)
                                                        <form
                                                            action="{{ route('admin.portofolio.validate', $portofolio->id_portofolio) }}"
                                                            method="POST" class="inline">
                                                            @csrf
                                                            <button type="submit"
                                                                class="bg-green-600 text-white px-2 py-1 rounded hover:bg-green-700 transition"
                                                                onclick="return confirm('Yakin ingin memvalidasi project ini?')">
                                                                Validasi
                                                            </button>
                                                        </form>
                                                    @endif

                                                    {{-- Edit Button --}}
                                                    @if (auth()->user()->hasRole('admin') || (isset($portofolio->user_id) && auth()->user()->id == $portofolio->user_id))
                                                        <a href="{{ route('portofolio.edit', $portofolio->id_portofolio) }}"
                                                            class="bg-orange-500 text-white px-2 py-1 rounded hover:bg-orange-600 transition">
                                                            Edit
                                                        </a>
                                                    @endif

                                                    {{-- Delete Button - Only for Admin --}}
                                                    @if (auth()->user()->hasRole('admin'))
                                                        <form
                                                            action="{{ route('portofolio.destroy', $portofolio->id_portofolio) }}"
                                                            method="POST" class="inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                class="bg-red-400 text-white px-2 py-1 rounded opacity-60 cursor-not-allowed"
                                                                disabled>
                                                                Hapus
                                                            </button>
                                                        </form>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="14" class="text-center text-gray-500 py-4">Tidak ada
                                                informasi portofolio saat ini.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        {{-- Paginasi untuk Admin (tidak ikut scroll) --}}
                        <div class="mt-6 flex flex-col sm:flex-row justify-between items-center gap-4">
                            <div class="text-sm text-gray-600">
                                Menampilkan <strong>{{ $dataPortofolio->count() }}</strong> dari
                                <strong>{{ $dataPortofolio->total() }}</strong> portofolio
                            </div>
                            <div>
                                {{ $dataPortofolio->links('vendor.pagination.always') }}
                            </div>
                        </div>
                    @else
                        {{-- Tampilan untuk User Biasa dengan Search & Filter --}}
                        <div class="mb-6 bg-gray-50 rounded-lg p-4">
                            <form method="GET" action="{{ route('dashboard') }}#portofolio-section"
                                class="space-y-4">
                                <div class="grid md:grid-cols-3 gap-4">
                                    {{-- Search Bar --}}
                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Cari
                                            Portofolio</label>
                                        <div class="relative">
                                            <input type="text" name="search" value="{{ request('search') }}"
                                                placeholder="Cari berdasarkan nama portofolio..."
                                                class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center">
                                                <svg class="w-5 h-5 text-gray-400" fill="currentColor"
                                                    viewBox="0 0 20 20">
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
                                            <option value="latest"
                                                {{ request('sort') == 'latest' ? 'selected' : '' }}>
                                                Terakhir Upload</option>
                                            <option value="popular"
                                                {{ request('sort') == 'popular' ? 'selected' : '' }}>
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

                                <div class="flex flex-col sm:flex-row gap-3">
                                    <button type="submit"
                                        class="bg-blue-600 text-white px-4 py-2 rounded text-center">
                                        Cari
                                    </button>
                                    <a href="{{ route('dashboard') }}#portofolio-section"
                                        class="bg-gray-200 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-300 transition font-medium text-center">
                                        Reset
                                    </a>
                                </div>
                            </form>
                        </div>

                        {{-- Results Info --}}
                        <div class="mb-4 flex flex-col md:flex-row justify-between items-center gap-2">
                            <div class="text-sm text-gray-600">
                                Menampilkan {{ $dataPortofolio->count() }} dari {{ $dataPortofolio->total() }}
                                portofolio
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
                                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                            @endif

                            <div
                                class="bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow-md transition overflow-hidden flex flex-col h-full">
                                {{-- Gambar Portofolio --}}
                                <div class="p-4 border-b border-gray-100">
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
                                <div class="p-4 flex flex-col flex-1">
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
                                        class="block w-full bg-blue-600 text-white text-center px-4 py-2 rounded-lg hover:bg-blue-700 transition font-medium mt-auto">
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

        @media (max-width: 1024px) {
            table.min-w-\[900px\] {
                min-width: 600px;
            }
        }

        @media (max-width: 640px) {
            .grid-cols-1 {
                grid-template-columns: 1fr !important;
            }

            .sm\:grid-cols-2 {
                grid-template-columns: 1fr !important;
            }

            .lg\:grid-cols-3 {
                grid-template-columns: 1fr !important;
            }

            table.min-w-\[900px\] {
                min-width: 400px;
            }
        }
    </style>
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
</section>