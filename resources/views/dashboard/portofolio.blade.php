<section class="bg-[#DDF1FB]">
    <div id="portofolio-section" class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl shadow-lg border border-gray-200 hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                <div class="p-8">
                    <!-- Header Section -->
                    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-8 gap-4">
                        <h3 class="text-2xl font-bold text-gray-900">Informasi Portofolio</h3>
                        @auth
                            <a href="{{ route('portofolio.create') }}"
                                class="inline-flex items-center justify-center bg-[#4B83BF] text-white px-6 py-3 rounded-lg hover:bg-[#5a93c7] transition-colors duration-200 font-medium shadow-sm">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                Tambah Portofolio
                            </a>
                        @endauth
                    </div>

                    @if (auth()->user()->hasRole('admin'))
                        {{-- Filter Section untuk Admin --}}
                        <div class="mb-8 bg-gray-50 rounded-xl p-6 border border-gray-200">
                            <form method="GET" class="space-y-6">
                                <input type="hidden" name="tab" value="portofolio">
                                
                                <h4 class="text-lg font-semibold text-gray-900 mb-4">Filter & Pencarian</h4>

                                {{-- Baris Pertama Filter --}}
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                                    {{-- Search Bar --}}
                                    <div class="space-y-2">
                                        <label class="block text-sm font-medium text-gray-700">Cari Portofolio</label>
                                        <div class="relative">
                                            <input type="text" name="search_portofolio" value="{{ request('search_portofolio') }}"
                                                placeholder="Cari berdasarkan nama portofolio..."
                                                class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#4B83BF] focus:border-[#4B83BF] transition-colors">
                                            <svg class="absolute left-3 top-3.5 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                            </svg>
                                        </div>
                                    </div>

                                    {{-- Filter Status --}}
                                    <div class="space-y-2">
                                        <label class="block text-sm font-medium text-gray-700">Status Portofolio</label>
                                        <select name="status_portofolio"
                                            class="w-full py-3 px-4 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#4B83BF] focus:border-[#4B83BF] transition-colors bg-white">
                                            <option value="">Semua Status</option>
                                            <option value="1" {{ request('status_portofolio') == '1' ? 'selected' : '' }}>
                                                Sudah Divalidasi
                                            </option>
                                            <option value="0" {{ request('status_portofolio') == '0' ? 'selected' : '' }}>
                                                Belum Divalidasi
                                            </option>
                                        </select>
                                    </div>

                                    {{-- Filter Popularitas --}}
                                    <div class="space-y-2">
                                        <label class="block text-sm font-medium text-gray-700">Tingkat Popularitas</label>
                                        <select name="view_count_filter"
                                            class="w-full py-3 px-4 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#4B83BF] focus:border-[#4B83BF] transition-colors bg-white">
                                            <option value="">Semua View</option>
                                            <option value="0-100" {{ request('view_count_filter') == '0-100' ? 'selected' : '' }}>
                                                0-100 views
                                            </option>
                                            <option value="100-500" {{ request('view_count_filter') == '100-500' ? 'selected' : '' }}>
                                                100-500 views
                                            </option>
                                            <option value="500-1000" {{ request('view_count_filter') == '500-1000' ? 'selected' : '' }}>
                                                500-1K views
                                            </option>
                                            <option value="1000+" {{ request('view_count_filter') == '1000+' ? 'selected' : '' }}>
                                                🚀 1K+ views
                                            </option>
                                        </select>
                                    </div>

                                    {{-- Sort --}}
                                    <div class="space-y-2">
                                        <label class="block text-sm font-medium text-gray-700">Urutkan</label>
                                        <select name="sort"
                                            class="w-full py-3 px-4 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#4B83BF] focus:border-[#4B83BF] transition-colors bg-white">
                                            <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>
                                                Terbaru
                                            </option>
                                            <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>
                                                Terlama
                                            </option>
                                            <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>
                                                Paling Populer
                                            </option>
                                            <option value="liked" {{ request('sort') == 'liked' ? 'selected' : '' }}>
                                                Paling Disukai
                                            </option>
                                            <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>
                                                Nama A-Z
                                            </option>
                                        </select>
                                    </div>
                                </div>

                                {{-- Baris Kedua Filter --}}
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    {{-- Kategori Filter --}}
                                    <div class="space-y-2">
                                        <label class="block text-sm font-medium text-gray-700">Kategori Portofolio</label>
                                        <div class="grid grid-cols-2 gap-3">
                                            @php
                                                $kategoriOptions = [
                                                    'UI/UX Design' => 'UI/UX Design',
                                                    'Website Development' => 'Website Development',
                                                    'Mobile Development' => 'Mobile Development',
                                                    'Game Development' => 'Game Development',
                                                    'Internet of Things' => 'Internet of Things',
                                                    'ML/AI' => 'ML/AI',
                                                    'Blockchain' => 'Blockchain',
                                                    'Cyber Security' => 'Cyber Security',
                                                ];
                                                $selectedKategori = request('kategori', []);
                                                if (!is_array($selectedKategori)) {
                                                    $selectedKategori = [$selectedKategori];
                                                }
                                            @endphp

                                            @foreach ($kategoriOptions as $value => $label)
                                                <label class="flex items-center space-x-2 cursor-pointer p-2 rounded-md hover:bg-gray-50 transition">
                                                    <input type="checkbox" name="kategori[]" value="{{ $value }}"
                                                        {{ in_array($value, $selectedKategori) ? 'checked' : '' }}
                                                        class="w-4 h-4 text-[#4B83BF] bg-gray-100 border-gray-300 focus:ring-[#4B83BF] focus:ring-2 rounded">
                                                    <span class="text-sm text-gray-700">{{ $label }}</span>
                                                </label>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>

                                {{-- Action Buttons --}}
                                <div class="flex flex-col sm:flex-row gap-3 pt-4 border-t border-gray-200">
                                    <button type="submit" 
                                        class="inline-flex items-center justify-center bg-[#4B83BF] text-white px-6 py-3 rounded-lg hover:bg-[#5a93c7] transition-colors duration-200 font-medium shadow-sm">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                        </svg>
                                        Cari
                                    </button>
                                    <a href="{{ route('dashboard', ['tab' => 'portofolio']) }}"
                                        class="inline-flex items-center justify-center bg-gray-500 text-white px-6 py-3 rounded-lg hover:bg-gray-600 transition-colors duration-200 font-medium">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                        </svg>
                                        Reset
                                    </a>
                                </div>
                            </form>
                        </div>


### Part 2 (Second Half - From Line ~300 to End)

html
                        {{-- Tampilan untuk Admin --}}
                        <div class="overflow-x-auto">
                            <table class="table-auto w-full border-collapse border border-gray-300 bg-white shadow-sm rounded-lg">
                                <thead>
                                    <tr class="bg-gray-100">
                                        <th class="border border-gray-300 px-4 py-3 text-left font-semibold text-gray-800">Nama Portofolio</th>
                                        <th class="border border-gray-300 px-4 py-3 text-left font-semibold text-gray-800">Deskripsi</th>
                                        <th class="border border-gray-300 px-4 py-3 text-left font-semibold text-gray-800">Views</th>
                                        <th class="border border-gray-300 px-4 py-3 text-left font-semibold text-gray-800">Upvotes</th>
                                        <th class="border border-gray-300 px-4 py-3 text-left font-semibold text-gray-800">Downvotes</th>
                                        <th class="border border-gray-300 px-4 py-3 text-left font-semibold text-gray-800">Dokumen</th>
                                        <th class="border border-gray-300 px-4 py-3 text-left font-semibold text-gray-800">Kategori</th>
                                        <th class="border border-gray-300 px-4 py-3 text-left font-semibold text-gray-800">Gambar</th>
                                        <th class="border border-gray-300 px-4 py-3 text-left font-semibold text-gray-800">Tautan</th>
                                        <th class="border border-gray-300 px-4 py-3 text-left font-semibold text-gray-800">Tools</th>
                                        <th class="border border-gray-300 px-4 py-3 text-left font-semibold text-gray-800">Komentar</th>
                                        <th class="border border-gray-300 px-4 py-3 text-left font-semibold text-gray-800">Status</th>
                                        <th class="border border-gray-300 px-4 py-3 text-left font-semibold text-gray-800">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($dataPortofolio as $portofolio)
                                        <tr class="hover:bg-gray-50">
                                            <td class="border border-gray-300 px-4 py-3 font-medium text-gray-900">
                                                {{ $portofolio->nama_portofolio }}
                                            </td>
                                            <td class="border border-gray-300 px-4 py-3 text-gray-700">
                                                {{ Str::limit($portofolio->deskripsi_portofolio, 50) }}
                                            </td>
                                            <td class="border border-gray-300 px-4 py-3 text-gray-700">
                                                {{ $portofolio->view_count }}
                                            </td>
                                            <td class="border border-gray-300 px-4 py-3 text-gray-700">
                                                {{ $portofolio->banyak_upvote }}
                                            </td>
                                            <td class="border border-gray-300 px-4 py-3 text-gray-700">
                                                {{ $portofolio->banyak_downvote }}
                                            </td>
                                            <td class="border border-gray-300 px-4 py-3 text-gray-700">
                                                @if ($portofolio->dokumen_portofolio)
                                                    <a href="{{ asset('storage/' . $portofolio->dokumen_portofolio) }}" target="_blank" class="text-[#4B83BF] hover:underline">
                                                        Lihat Dokumen
                                                    </a>
                                                @else
                                                    <span class="text-gray-400 text-sm">-</span>
                                                @endif
                                            </td>
                                            <td class="border border-gray-300 px-4 py-3 text-gray-700">
                                                @if ($portofolio->kategori->count() > 0)
                                                    <div class="space-y-1 max-w-xs">
                                                        @foreach ($portofolio->kategori as $kategori)
                                                            <div class="text-sm">- {{ $kategori->kategori_portofolio }}</div>
                                                        @endforeach
                                                    </div>
                                                @else
                                                    <span class="text-gray-400 text-sm">Tidak ada kategori</span>
                                                @endif
                                            </td>
                                            <td class="border border-gray-300 px-4 py-3">
                                                @if ($portofolio->gambar->count() > 0)
                                                    @foreach ($portofolio->gambar->take(1) as $gambar)
                                                        <a href="{{ asset('storage/' . $gambar->gambar_portofolio) }}" target="_blank" class="block">
                                                            <img src="{{ asset('storage/' . $gambar->gambar_portofolio) }}" 
                                                                 alt="Gambar Portofolio" 
                                                                 class="w-16 h-16 object-cover rounded shadow-sm hover:shadow-md transition" />
                                                        </a>
                                                    @endforeach
                                                @else
                                                    <span class="text-gray-400 text-sm">-</span>
                                                @endif
                                            </td>
                                            <td class="border border-gray-300 px-4 py-3 text-gray-700">
                                                @if ($portofolio->tautan->count() > 0)
                                                    @foreach ($portofolio->tautan->take(1) as $tautan)
                                                        <a href="{{ $tautan->tautan_portofolio }}" target="_blank" class="text-[#4B83BF] hover:underline text-sm block">
                                                            {{ Str::limit($tautan->tautan_portofolio, 25) }}
                                                        </a>
                                                    @endforeach
                                                @else
                                                    <span class="text-gray-400 text-sm">-</span>
                                                @endif
                                            </td>
                                            <td class="border border-gray-300 px-4 py-3 text-gray-700">
                                                @if ($portofolio->tools->count() > 0)
                                                    <div class="space-y-1 max-w-xs">
                                                        @foreach ($portofolio->tools->take(2) as $tools)
                                                            <div class="text-sm">- {{ $tools->tools_portofolio }}</div>
                                                        @endforeach
                                                        @if ($portofolio->tools->count() > 2)
                                                            <div class="text-xs text-gray-500">+{{ $portofolio->tools->count() - 2 }} lainnya</div>
                                                        @endif
                                                    </div>
                                                @else
                                                    <span class="text-gray-400 text-sm">Tidak ada tools</span>
                                                @endif
                                            </td>
                                            <td class="border border-gray-300 px-4 py-3">
                                                @php
                                                    $notif = \App\Models\Notifikasi::where('notifiable_id', $portofolio->id_portofolio)
                                                        ->where('notifiable_type', 'portofolio')
                                                        ->latest()
                                                        ->first();
                                                @endphp
                                                <div class="space-y-2 max-w-xs">
                                                    @if ($notif && $notif->isi_notifikasi)
                                                        <div class="bg-gray-50 p-2 rounded text-sm text-gray-700">
                                                            {{ $notif->isi_notifikasi }}
                                                        </div>
                                                    @endif

                                                    @if ($portofolio->status_portofolio == 0)
                                                        <form action="{{ route('portofolio.komentar', $portofolio->id_portofolio) }}" method="POST" class="space-y-2">
                                                            @csrf
                                                            <textarea name="isi_notifikasi" 
                                                                      class="w-full border border-gray-300 rounded-md p-2 text-sm focus:ring-2 focus:ring-[#4B83BF] focus:border-[#4B83BF]" 
                                                                      rows="2" 
                                                                      placeholder="Tulis komentar..." 
                                                                      required>{{ $notif->isi_notifikasi ?? '' }}</textarea>
                                                            <button type="submit" class="w-full px-3 py-1 text-white bg-[#4B83BF] hover:bg-[#5a93c7] rounded-md transition text-sm font-medium">
                                                                Kirim Komentar
                                                            </button>
                                                        </form>
                                                    @else
                                                        <span class="text-gray-500 text-sm">Portofolio sudah divalidasi</span>
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="border border-gray-300 px-4 py-3">
                                                @if ($portofolio->status_portofolio == 1)
                                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                        ✅ Tervalidasi
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                        ⏳ Belum Divalidasi
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="border border-gray-300 px-4 py-3">
                                                <div class="flex gap-2 flex-wrap">
                                                    {{-- Validation Button --}}
                                                    @if ($portofolio->status_portofolio == 0)
                                                        <form action="{{ route('admin.portofolio.validate', $portofolio->id_portofolio) }}" method="POST" class="inline">
                                                            @csrf
                                                            <button type="submit" 
                                                                    class="bg-green-600 text-white px-3 py-1 rounded-md hover:bg-green-700 transition text-sm font-medium"
                                                                    onclick="return confirm('Yakin ingin memvalidasi portofolio ini?')">
                                                                Validasi
                                                            </button>
                                                        </form>
                                                    @endif

                                                    {{-- Edit Button --}}
                                                    @if (auth()->user()->hasRole('admin') || (isset($portofolio->user_id) && auth()->user()->id == $portofolio->user_id))
                                                        <a href="{{ route('portofolio.edit', $portofolio->id_portofolio) }}" 
                                                           class="bg-[#4B83BF] text-white px-3 py-1 rounded-md hover:bg-[#5a93c7] transition text-sm font-medium">
                                                            Edit
                                                        </a>
                                                    @endif

                                                    {{-- Delete Button - Only for Admin --}}
                                                    @if (auth()->user()->hasRole('admin'))
                                                        <form action="{{ route('portofolio.destroy', $portofolio->id_portofolio) }}" method="POST" class="inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" 
                                                                    class="bg-red-600 text-white px-3 py-1 rounded-md hover:bg-red-700 transition text-sm font-medium"
                                                                    onclick="return confirm('Yakin ingin menghapus portofolio ini?')">
                                                                Hapus
                                                            </button>
                                                        </form>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="13" class="text-center text-gray-500 py-12">
                                                <div class="flex flex-col items-center space-y-3">
                                                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                    </svg>
                                                    <div class="text-gray-600 font-medium">Tidak ada portofolio yang sesuai filter</div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        {{-- Paginasi untuk Admin --}}
                        <div class="mt-6 flex flex-col sm:flex-row justify-between items-center gap-4">
                            <div class="text-sm text-gray-600">
                                Menampilkan <strong>{{ $dataPortofolio->count() }}</strong> dari <strong>{{ $dataPortofolio->total() }}</strong> portofolio
                            </div>
                            <div>
                                {{ $dataPortofolio->links('vendor.pagination.always') }}
                            </div>
                        </div>

                    @else
                        {{-- Tampilan untuk User Biasa --}}
                        {{-- Search & Filter Bar --}}
                        <div class="mb-6 bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                            <form method="GET" action="{{ route('dashboard') }}#portofolio-section" class="space-y-6">
                                <div class="grid md:grid-cols-3 gap-4">
                                    {{-- Search Bar --}}
                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Cari Portofolio</label>
                                        <div class="relative">
                                            <input type="text" name="search" value="{{ request('search') }}" 
                                                   placeholder="Cari berdasarkan nama portofolio..."
                                                   class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#4B83BF] focus:border-[#4B83BF] transition">
                                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center">
                                                <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                                                </svg>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Sort Filter --}}
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Urutkan</label>
                                        <select name="sort" 
                                                class="w-full py-2 px-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#4B83BF] focus:border-[#4B83BF] transition">
                                            <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>
                                                Terakhir Upload
                                            </option>
                                            <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>
                                                Populer (Views)
                                            </option>
                                            <option value="liked" {{ request('sort') == 'liked' ? 'selected' : '' }}>
                                                Paling Disukai
                                            </option>
                                        </select>
                                    </div>
                                </div>

                                {{-- Kategori Filter - Chip Style --}}
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Kategori</label>
                                    <div class="flex flex-wrap gap-2">
                                        @php
                                            $kategoriList = [
                                                'UI/UX Design' => 'UI/UX Design',
                                                'Website Development' => 'Website Development',
                                                'Mobile Development' => 'Mobile Development',
                                                'Game Development' => 'Game Development',
                                                'Internet of Things' => 'Internet of Things',
                                                'ML/AI' => 'ML/AI',
                                                'Blockchain' => 'Blockchain',
                                                'Cyber Security' => 'Cyber Security',
                                            ];
                                            $selectedKategori = request('kategori', []);
                                            if (!is_array($selectedKategori)) {
                                                $selectedKategori = [$selectedKategori];
                                            }
                                        @endphp

                                        @foreach ($kategoriList as $value => $label)
                                            <label class="cursor-pointer">
                                                <input type="checkbox" name="kategori[]" value="{{ $value }}"
                                                       {{ in_array($value, $selectedKategori) ? 'checked' : '' }}
                                                       class="sr-only peer">
                                                <div class="px-3 py-2 text-sm rounded-full border transition peer-checked:bg-[#4B83BF] peer-checked:text-white peer-checked:border-[#4B83BF] hover:bg-gray-100 bg-white text-gray-700 border-gray-300">
                                                    {{ $label }}
                                                </div>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>

                                <div class="flex gap-3">
                                    <button type="submit" 
                                            class="bg-[#4B83BF] text-white px-6 py-2 rounded-lg hover:bg-[#5a93c7] transition font-medium">
                                        Cari Portofolio
                                    </button>
                                    <a href="{{ route('dashboard') }}#portofolio-section" 
                                       class="bg-gray-200 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-300 transition font-medium">
                                        Reset Filter
                                    </a>
                                    
                                </div>
                            </form>
                        </div>

                        {{-- Results Info --}}
                        <div class="mb-6 flex justify-between items-center">
                            <div class="text-sm text-gray-600">
                                Menampilkan <strong>{{ $dataPortofolio->count() }}</strong> dari <strong>{{ $dataPortofolio->total() }}</strong> portofolio
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
                               class="text-[#4B83BF] hover:text-[#5a93c7] text-sm font-medium hover:underline">
                                Lihat Semua →
                            </a>
                        </div>

                        {{-- Grid Portofolio --}}
                        @forelse ($dataPortofolio as $portofolio)
                            @if ($loop->first)
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @endif

                            <div class="bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow-md transition overflow-hidden">
                                {{-- Gambar Portofolio --}}
                                <div class="aspect-video bg-gray-100 overflow-hidden">
                                    @if ($portofolio->gambar && $portofolio->gambar->first())
                                        <img src="{{ asset('storage/' . $portofolio->gambar->first()->gambar_portofolio) }}"
                                             alt="{{ $portofolio->nama_portofolio }}"
                                             class="w-full h-full object-cover hover:scale-105 transition duration-300">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-gray-400">
                                            <svg class="w-12 h-12" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd" />
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
                                            <span class="px-2 py-1 bg-[#4B83BF] bg-opacity-10 text-[#4B83BF] text-xs rounded-full font-medium">
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
                                                    <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                                                </svg>
                                                {{ $portofolio->view_count }}
                                            </span>
                                            <span class="flex items-center gap-1">
                                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M2 10.5a1.5 1.5 0 113 0v6a1.5 1.5 0 01-3 0v-6zM6 10.333v5.43a2 2 0 001.106 1.79l.05.025A4 4 0 008.943 18h5.416a2 2 0 001.962-1.608l1.2-6A2 2 0 0015.56 8H12V4a2 2 0 00-2-2 1 1 0 00-1 1v.667a4 4 0 01-.8 2.4L6.8 7.933a4 4 0 00-.8 2.4z" />
                                                </svg>
                                                {{ $portofolio->banyak_upvote }}
                                            </span>
                                            <span class="flex items-center gap-1">
                                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M18 9.5a1.5 1.5 0 11-3 0v-6a1.5 1.5 0 013 0v6zM14 9.667v-5.43a2 2 0 00-1.106-1.79l-.05-.025A4 4 0 0011.057 2H5.64a2 2 0 00-1.962 1.608l-1.2 6A2 2 0 004.44 12H8v4a2 2 0 002 2 1 1 0 001-1v-.667a4 4 0 01.8-2.4l1.4-1.866a4 4 0 00.8-2.4z" />
                                                </svg>
                                                {{ $portofolio->banyak_downvote }}
                                            </span>
                                        </div>
                                    </div>

                                    {{-- Owner --}}
                                    <div class="text-xs text-gray-500 mb-3">
                                        by <span class="font-medium">{{ $portofolio->owner->nama_pengguna ?? 'Unknown' }}</span>
                                    </div>

                                    {{-- Action Button --}}
                                    <a href="{{ route('portofolio.show', $portofolio->id_portofolio) }}" 
                                       class="block w-full bg-[#4B83BF] text-white text-center px-4 py-2 rounded-lg hover:bg-[#5a93c7] transition font-medium">
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
                                        <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4z" clip-rule="evenodd" />
            
                                        <path fill-rule="evenodd" d="M3 10a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1v-2z" clip-rule="evenodd" />
                                        <path fill-rule="evenodd" d="M3 16a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1v-2z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <h4 class="text-lg font-medium text-gray-600 mb-2">Tidak ada portofolio yang ditemukan</h4>
                                <p class="text-gray-500 mb-4">Coba ubah filter pencarian Anda atau buat portofolio baru</p>
                                <a href="{{ route('portofolio.create') }}" 
                                   class="inline-flex items-center px-4 py-2 bg-[#4B83BF] text-white rounded-lg hover:bg-[#5a93c7] transition">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                    </svg>
                                    Tambah Portofolio
                                </a>
                            </div>
                        @endforelse

                        {{-- Pagination for Regular Users --}}
                        @if ($dataPortofolio->hasPages())
                            <div class="mt-8">
                                {{ $dataPortofolio->links('vendor.pagination.simple-tailwind') }}
                            </div>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>