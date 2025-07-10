{{-- Informasi Oprek --}}
<section class="bg-[#DDF1FB]">
    <div id="oprek-section" class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl shadow-lg border border-gray-200 hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                <div class="p-8">
                    <!-- Header Section -->
                    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-8 gap-4">
                        <h3 class="text-2xl font-bold text-gray-900">Informasi Hiring Project</h3>
                        @auth
                            <a href="{{ route('oprek.create') }}"
                                class="inline-flex items-center justify-center bg-[#4B83BF] text-white px-6 py-3 rounded-lg hover:bg-[#5a93c7] transition-colors duration-200 font-medium shadow-sm">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                Tambah Hiring
                            </a>
                        @endauth
                    </div>

                    @if (auth()->user()->hasRole('admin'))
                        {{-- Filter Section untuk Admin --}}
                        <div class="mb-8 bg-gray-50 rounded-xl p-6 border border-gray-200">
                            <form method="GET" class="space-y-6">
                                <input type="hidden" name="tab" value="oprek">
                                
                                <h4 class="text-lg font-semibold text-gray-900 mb-4">Filter & Pencarian</h4>

                                {{-- Baris Pertama Filter --}}
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                                    {{-- Search Bar --}}
                                    <div class="space-y-2">
                                        <label class="block text-sm font-medium text-gray-700">Cari Hiring</label>
                                        <div class="relative">
                                            <input type="text" name="search_oprek" value="{{ request('search_oprek') }}"
                                                placeholder="Cari berdasarkan nama hiring..."
                                                class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#4B83BF] focus:border-[#4B83BF] transition-colors">
                                            <svg class="absolute left-3 top-3.5 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                            </svg>
                                        </div>
                                    </div>

                                    {{-- Filter Status --}}
                                    <div class="space-y-2">
                                        <label class="block text-sm font-medium text-gray-700">Status Project</label>
                                        <select name="status_project"
                                            class="w-full py-3 px-4 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#4B83BF] focus:border-[#4B83BF] transition-colors bg-white">
                                            <option value="">Semua Status</option>
                                            <option value="1" {{ request('status_project') == '1' ? 'selected' : '' }}>
                                                Sudah Divalidasi
                                            </option>
                                            <option value="0" {{ request('status_project') == '0' ? 'selected' : '' }}>
                                                Belum Divalidasi
                                            </option>
                                        </select>
                                    </div>

                                    {{-- Filter Kategori --}}
                                    <div class="space-y-2">
                                        <label class="block text-sm font-medium text-gray-700">Kategori Project</label>
                                        <select name="kategori_project"
                                            class="w-full py-3 px-4 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#4B83BF] focus:border-[#4B83BF] transition-colors bg-white">
                                            <option value="">Semua Kategori</option>
                                            <option value="Penelitian" {{ request('kategori_project') == 'Penelitian' ? 'selected' : '' }}>
                                                Penelitian
                                            </option>
                                            <option value="Pengembangan Aplikasi" {{ request('kategori_project') == 'Pengembangan Aplikasi' ? 'selected' : '' }}>
                                                Pengembangan Aplikasi
                                            </option>
                                            <option value="Pengabdian Masyarakat" {{ request('kategori_project') == 'Pengabdian Masyarakat' ? 'selected' : '' }}>
                                                Pengabdian Masyarakat
                                            </option>
                                            <option value="Inisiatif Pribadi" {{ request('kategori_project') == 'Inisiatif Pribadi' ? 'selected' : '' }}>
                                                Inisiatif Pribadi
                                            </option>
                                        </select>
                                    </div>

                                    {{-- Filter Output --}}
                                    <div class="space-y-2">
                                        <label class="block text-sm font-medium text-gray-700">Output Project</label>
                                        <select name="output_project"
                                            class="w-full py-3 px-4 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#4B83BF] focus:border-[#4B83BF] transition-colors bg-white">
                                            <option value="">Semua Output</option>
                                            <option value="Website" {{ request('output_project') == 'Website' ? 'selected' : '' }}>
                                                Website
                                            </option>
                                            <option value="Mobile Apps" {{ request('output_project') == 'Mobile Apps' ? 'selected' : '' }}>
                                                Mobile App
                                            </option>
                                            <option value="Desktop Apps" {{ request('output_project') == 'Desktop Apps' ? 'selected' : '' }}>
                                                Desktop App
                                            </option>
                                            <option value="Game" {{ request('output_project') == 'Game' ? 'selected' : '' }}>
                                                Game
                                            </option>
                                            <option value="IoT" {{ request('output_project') == 'IoT' ? 'selected' : '' }}>
                                                IoT
                                            </option>
                                            <option value="AI/ML" {{ request('output_project') == 'AI/ML' ? 'selected' : '' }}>
                                                AI/ML
                                            </option>
                                            <option value="Blockchain" {{ request('output_project') == 'Blockchain' ? 'selected' : '' }}>
                                                Blockchain
                                            </option>
                                        </select>
                                    </div>
                                </div>

                                {{-- Baris Kedua Filter --}}
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    {{-- Filter Deadline --}}
                                    <div class="space-y-2">
                                        <label class="block text-sm font-medium text-gray-700">Filter Deadline</label>
                                        <select name="deadline_filter"
                                            class="w-full py-3 px-4 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#4B83BF] focus:border-[#4B83BF] transition-colors bg-white">
                                            <option value="">Semua Deadline</option>
                                            <option value="today" {{ request('deadline_filter') == 'today' ? 'selected' : '' }}>
                                                Hari Ini
                                            </option>
                                            <option value="this_week" {{ request('deadline_filter') == 'this_week' ? 'selected' : '' }}>
                                                Minggu Ini
                                            </option>
                                            <option value="this_month" {{ request('deadline_filter') == 'this_month' ? 'selected' : '' }}>
                                                Bulan Ini
                                            </option>
                                        </select>
                                    </div>

                                    {{-- Filter Penyelenggara --}}
                                    <div class="space-y-2">
                                        <label class="block text-sm font-medium text-gray-700">Penyelenggara</label>
                                        <select name="penyelenggara"
                                            class="w-full py-3 px-4 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#4B83BF] focus:border-[#4B83BF] transition-colors bg-white">
                                            <option value="">Semua Penyelenggara</option>
                                            <option value="Dosen" {{ request('penyelenggara') == 'Dosen' ? 'selected' : '' }}>
                                                Dosen
                                            </option>
                                            <option value="Mahasiswa" {{ request('penyelenggara') == 'Mahasiswa' ? 'selected' : '' }}>
                                                Mahasiswa
                                            </option>
                                            <option value="Organisasi" {{ request('penyelenggara') == 'Organisasi' ? 'selected' : '' }}>
                                                Organisasi
                                            </option>
                                            <option value="Eksternal" {{ request('penyelenggara') == 'Eksternal' ? 'selected' : '' }}>
                                                Eksternal
                                            </option>
                                        </select>
                                    </div>

                                    {{-- Sort --}}
                                    <div class="space-y-2">
                                        <label class="block text-sm font-medium text-gray-700">Urutkan</label>
                                        <select name="sort_oprek"
                                            class="w-full py-3 px-4 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#4B83BF] focus:border-[#4B83BF] transition-colors bg-white">
                                            <option value="latest" {{ request('sort_oprek') == 'latest' ? 'selected' : '' }}>
                                                Terbaru
                                            </option>
                                            <option value="oldest" {{ request('sort_oprek') == 'oldest' ? 'selected' : '' }}>
                                                Terlama
                                            </option>
                                            <option value="name_asc" {{ request('sort_oprek') == 'name_asc' ? 'selected' : '' }}>
                                                Nama A-Z
                                            </option>
                                            <option value="deadline_asc" {{ request('sort_oprek') == 'deadline_asc' ? 'selected' : '' }}>
                                                Deadline Terdekat
                                            </option>
                                        </select>
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
                                    <a href="{{ route('dashboard', ['tab' => 'oprek']) }}"
                                        class="inline-flex items-center justify-center bg-gray-500 text-white px-6 py-3 rounded-lg hover:bg-gray-600 transition-colors duration-200 font-medium">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                        </svg>
                                        Reset
                                    </a>
                                </div>
                            </form>
                        </div>
                    

                        {{-- Tampilan untuk Admin --}}
                        {{-- Tampilan untuk Admin --}}
<div class="overflow-x-auto">
    <table class="table-auto w-full border-collapse border border-gray-300 bg-white shadow-sm rounded-lg">
        <thead>
            <tr class="bg-gray-100">
                <th class="border border-gray-300 px-4 py-3 text-left font-semibold text-gray-800">Nama Project</th>
                <th class="border border-gray-300 px-4 py-3 text-left font-semibold text-gray-800">Deskripsi Project</th>
                <th class="border border-gray-300 px-4 py-3 text-left font-semibold text-gray-800">Penyelenggara Project</th>
                <th class="border border-gray-300 px-4 py-3 text-left font-semibold text-gray-800">Nama Penyelenggara</th>
                <th class="border border-gray-300 px-4 py-3 text-left font-semibold text-gray-800">Kategori</th>
                <th class="border border-gray-300 px-4 py-3 text-left font-semibold text-gray-800">Output</th>
                <th class="border border-gray-300 px-4 py-3 text-left font-semibold text-gray-800">Kualifikasi Oprek</th>
                <th class="border border-gray-300 px-4 py-3 text-left font-semibold text-gray-800">Deadline</th>
                <th class="border border-gray-300 px-4 py-3 text-left font-semibold text-gray-800">Tautan Pendaftaran</th>
                <th class="border border-gray-300 px-4 py-3 text-left font-semibold text-gray-800">Flyer Informasi</th>
                <th class="border border-gray-300 px-4 py-3 text-left font-semibold text-gray-800">Status</th>
                <th class="border border-gray-300 px-4 py-3 text-left font-semibold text-gray-800">Komentar</th>
                <th class="border border-gray-300 px-4 py-3 text-left font-semibold text-gray-800">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($dataOprek as $oprek)
                <tr class="hover:bg-gray-50">
                    <td class="border border-gray-300 px-4 py-3 font-medium text-gray-900">
                        {{ $oprek->nama_project }}
                    </td>
                    <td class="border border-gray-300 px-4 py-3 text-gray-700">
                        {{ Str::limit($oprek->deskripsi_project, 50) }}
                    </td>
                    <td class="border border-gray-300 px-4 py-3 text-gray-700">
                        {{ $oprek->penyelenggara }}
                    </td>
                    <td class="border border-gray-300 px-4 py-3 text-gray-700">
                        {{ $oprek->nama_penyelenggara }}
                    </td>
                    <td class="border border-gray-300 px-4 py-3 text-gray-700">
                        {{ $oprek->kategori_project }}
                    </td>
                    <td class="border border-gray-300 px-4 py-3 text-gray-700">
                        {{ $oprek->output_project }}
                    </td>
                    <td class="border border-gray-300 px-4 py-3 text-gray-700">
                        @if ($oprek->kualifikasi->count() > 0)
                            <div class="space-y-1 max-w-xs">
                                @foreach ($oprek->kualifikasi as $kualifikasi)
                                    <div class="text-sm">- {{ $kualifikasi->kualifikasi_oprek }}</div>
                                @endforeach
                            </div>
                        @else
                            <span class="text-gray-400 text-sm">Tidak ada kualifikasi khusus</span>
                        @endif
                    </td>
                    <td class="border border-gray-300 px-4 py-3 text-gray-700">
                        @if ($oprek->deadline_project)
                            <div class="text-sm font-medium">
                                {{ date('d M Y', strtotime($oprek->deadline_project)) }}
                            </div>
                            @if ($oprek->isExpired())
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                    Berakhir
                                </span>
                            @else
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    Aktif
                                </span>
                            @endif
                        @endif
                    </td>
                    <td class="border border-gray-300 px-4 py-3 text-gray-700">
                        @if ($oprek->tautan_project)
                            <a href="{{ $oprek->tautan_project }}" target="_blank" class="text-[#4B83BF] hover:underline">
                                Link Pendaftaran
                            </a>
                        @else
                            <span class="text-gray-400 text-sm">Tidak ada tautan</span>
                        @endif
                    </td>
                    <td class="border border-gray-300 px-4 py-3">
                        @if ($oprek->flyer_informasi)
                            <a href="{{ Storage::url($oprek->flyer_informasi) }}" target="_blank" class="block">
                                <img src="{{ Storage::url($oprek->flyer_informasi) }}" alt="Flyer Informasi" 
                                     class="w-24 h-32 object-cover rounded shadow-sm hover:shadow-md transition" />
                            </a>
                        @else
                            <span class="text-gray-400 text-sm">Tidak ada flyer</span>
                        @endif
                    </td>
                    <td class="border border-gray-300 px-4 py-3">
                        @if ($oprek->status_project == 1)
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
                        @php
                            $notif = \App\Models\Notifikasi::where('notifiable_id', $oprek->id_oprek)
                                ->where('notifiable_type', 'oprek')
                                ->latest()
                                ->first();
                        @endphp
                        <div class="space-y-2 max-w-xs">
                            @if ($notif && $notif->isi_notifikasi)
                                <div class="bg-gray-50 p-2 rounded text-sm text-gray-700">
                                    {{ $notif->isi_notifikasi }}
                                </div>
                            @endif

                            @if ($oprek->status_project == 0)
                                <form action="{{ route('oprek.komentar', $oprek->id_oprek) }}" method="POST" class="space-y-2">
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
                                <span class="text-gray-500 text-sm">Project sudah divalidasi</span>
                            @endif
                        </div>
                    </td>
                    <td class="border border-gray-300 px-4 py-3">
                        <div class="flex gap-2 flex-wrap">
                            {{-- Validation Button --}}
                            @if ($oprek->status_project == 0)
                                <form action="{{ route('admin.oprek.validate', $oprek->id_oprek) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" 
                                            class="bg-green-600 text-white px-3 py-1 rounded-md hover:bg-green-700 transition text-sm font-medium"
                                            onclick="return confirm('Yakin ingin memvalidasi project ini?')">
                                        Validasi
                                    </button>
                                </form>
                            @endif

                            {{-- Edit Button --}}
                            @if (auth()->user()->hasRole('admin') || (isset($oprek->user_id) && auth()->user()->id == $oprek->user_id))
                                <a href="{{ route('oprek.edit', $oprek->id_oprek) }}" 
                                   class="bg-[#4B83BF] text-white px-3 py-1 rounded-md hover:bg-[#5a93c7] transition text-sm font-medium">
                                    Edit
                                </a>
                            @endif

                            {{-- Delete Button - Only for Admin --}}
                            @if (auth()->user()->hasRole('admin'))
                                <form action="{{ route('oprek.destroy', $oprek->id_oprek) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="bg-red-600 text-white px-3 py-1 rounded-md hover:bg-red-700 transition text-sm font-medium"
                                            onclick="return confirm('Yakin ingin menghapus project ini?')">
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
                            <div class="text-gray-600 font-medium">Tidak ada Hiring yang sesuai filter</div>
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
        Menampilkan <strong>{{ $dataOprek->count() }}</strong> dari <strong>{{ $dataOprek->total() }}</strong> project
    </div>
    <div>
        {{ $dataOprek->links('vendor.pagination.always') }}
    </div>
</div>

@else
    {{-- Search & Filter Bar --}}
    <div class="mb-6 bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <form method="GET" action="{{ route('dashboard') }}#oprek-section" class="space-y-6">
            <div class="grid md:grid-cols-4 gap-4">
                {{-- Search Bar --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Cari Hiring</label>
                    <div class="relative">
                        <input type="text" name="search_oprek" value="{{ request('search_oprek') }}" 
                               placeholder="Cari berdasarkan nama project..."
                               class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#4B83BF] focus:border-[#4B83BF] transition">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center">
                            <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>
                </div>

                {{-- Filter Deadline --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Filter Deadline</label>
                    <select name="deadline_filter" 
                            class="w-full py-2 px-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#4B83BF] focus:border-[#4B83BF] transition">
                        <option value="">Semua Deadline</option>
                        <option value="today" {{ request('deadline_filter') == 'today' ? 'selected' : '' }}>Hari Ini</option>
                        <option value="this_week" {{ request('deadline_filter') == 'this_week' ? 'selected' : '' }}>Minggu Ini</option>
                        <option value="this_month" {{ request('deadline_filter') == 'this_month' ? 'selected' : '' }}>Bulan Ini</option>
                        <option value="upcoming" {{ request('deadline_filter') == 'upcoming' ? 'selected' : '' }}>Akan Datang</option>
                    </select>
                </div>

                {{-- Filter Output --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Output Project</label>
                    <select name="output_project" 
                            class="w-full py-2 px-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#4B83BF] focus:border-[#4B83BF] transition">
                        <option value="">Semua Output</option>
                        <option value="Website" {{ request('output_project') == 'Website' ? 'selected' : '' }}>Website</option>
                        <option value="Mobile Apps" {{ request('output_project') == 'Mobile Apps' ? 'selected' : '' }}>Mobile App</option>
                        <option value="API Development" {{ request('output_project') == 'API Development' ? 'selected' : '' }}>API Development</option>
                        <option value="Game" {{ request('output_project') == 'Game' ? 'selected' : '' }}>Game</option>
                        <option value="Machine Learning/AI Project" {{ request('output_project') == 'Machine Learning/AI Project' ? 'selected' : '' }}>Machine Learning/AI</option>
                        <option value="Cyber Security" {{ request('output_project') == 'Cyber Security' ? 'selected' : '' }}>Cyber Security</option>
                        <option value="Automation" {{ request('output_project') == 'Automation' ? 'selected' : '' }}>Automation</option>
                        <option value="Embedded System" {{ request('output_project') == 'Embedded System' ? 'selected' : '' }}>Embedded System</option>
                    </select>
                </div>

                {{-- Sort --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Urutkan</label>
                    <select name="sort_oprek" 
                            class="w-full py-2 px-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#4B83BF] focus:border-[#4B83BF] transition">
                        <option value="latest" {{ request('sort_oprek') == 'latest' ? 'selected' : '' }}>Terbaru</option>
                        <option value="oldest" {{ request('sort_oprek') == 'oldest' ? 'selected' : '' }}>Terlama</option>
                        <option value="deadline" {{ request('sort_oprek') == 'deadline' ? 'selected' : '' }}>Deadline Terdekat</option>
                        <option value="name" {{ request('sort_oprek') == 'name' ? 'selected' : '' }}>Nama A-Z</option>
                    </select>
                </div>
            </div>

            {{-- Multi-select Kategori Project --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-3">Kategori Project</label>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                    @php
                        $kategoriOptions = [
                            'Penelitian' => 'Penelitian',
                            'Pengembangan Aplikasi' => 'Pengembangan Aplikasi',
                            'Pengabdian Masyarakat' => 'Pengabdian Masyarakat',
                            'Inisiatif Pribadi' => 'Inisiatif Pribadi',
                        ];
                        $selectedKategori = request('kategori_project', []);
                    @endphp

                    @foreach ($kategoriOptions as $value => $label)
                        <label class="flex items-center space-x-2 cursor-pointer p-2 rounded-md hover:bg-gray-50 transition">
                            <input type="checkbox" name="kategori_project[]" value="{{ $value }}" 
                                   {{ in_array($value, $selectedKategori) ? 'checked' : '' }}
                                   class="w-4 h-4 text-[#4B83BF] bg-gray-100 border-gray-300 focus:ring-[#4B83BF] focus:ring-2 rounded">
                            <span class="text-sm text-gray-700">{{ $label }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            {{-- Multi-select Penyelenggara --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-3">Penyelenggara</label>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                    @php
                        $penyelenggaraOptions = [
                            'Dosen' => 'Dosen',
                            'Mahasiswa' => 'Mahasiswa',
                            'Organisasi' => 'Organisasi',
                            'Eksternal' => 'Eksternal',
                        ];
                        $selectedPenyelenggara = request('penyelenggarat', []);
                    @endphp

                    @foreach ($penyelenggaraOptions as $value => $label)
                        <label class="flex items-center space-x-2 cursor-pointer p-2 rounded-md hover:bg-gray-50 transition">
                            <input type="checkbox" name="penyelenggara[]" value="{{ $value }}" 
                                   {{ in_array($value, $selectedPenyelenggara) ? 'checked' : '' }}
                                   class="w-4 h-4 text-[#4B83BF] bg-gray-100 border-gray-300 focus:ring-[#4B83BF] focus:ring-2 rounded">
                            <span class="text-sm text-gray-700">{{ $label }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            <div class="flex gap-3">
                <button type="submit" 
                        class="bg-[#4B83BF] text-white px-6 py-2 rounded-lg hover:bg-[#5a93c7] transition font-medium">
                    Cari Hiring
                </button>
                <a href="{{ route('dashboard') }}#oprek-section" 
                   class="bg-gray-200 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-300 transition font-medium">
                    Reset Filter
                </a>
            </div>
        </form>
    </div>

    {{-- Results Info --}}
    <div class="mb-6 flex justify-between items-center">
        <div class="text-sm text-gray-600">
            Menampilkan <strong>{{ $dataOprek->count() }}</strong> dari <strong>{{ $dataOprek->total() }}</strong> project
            @if (request('search_oprek'))
                untuk "<strong>{{ request('search_oprek') }}</strong>"
            @endif
        </div>
    </div>

    {{-- Grid Oprek --}}
    @forelse ($dataOprek as $oprek)
        @if ($loop->first)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @endif

        <div class="bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow-md transition overflow-hidden">
            {{-- Header --}}
            <div class="p-6 border-b border-gray-100">
                <div class="flex justify-between items-start mb-3">
                    <h3 class="font-semibold text-lg line-clamp-2 text-gray-900">
                        {{ $oprek->nama_project }}
                    </h3>
                </div>

                {{-- Project Info --}}
                <div class="space-y-3 text-sm text-gray-600">
                    {{-- Deadline --}}
                    @if ($oprek->deadline_project)
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-[#4B83BF]" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                            </svg>
                            <span class="font-medium">Deadline: {{ date('d M Y', strtotime($oprek->deadline_project)) }}</span>
                            @if (strtotime($oprek->deadline_project) < time())
                                <span class="text-red-600 text-xs font-medium">(Berakhir)</span>
                            @endif
                        </div>
                    @endif

                    {{-- Penyelenggara --}}
                    @if ($oprek->nama_penyelenggara)
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-[#4B83BF]" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3z" />
                            </svg>
                            <span>{{ $oprek->nama_penyelenggara }}</span>
                        </div>
                    @endif

                    {{-- Tags --}}
                    <div class="flex gap-2 flex-wrap">
                        @if ($oprek->kategori_project)
                            <span class="px-2 py-1 bg-[#4B83BF] bg-opacity-10 text-[#4B83BF] text-xs rounded-full font-medium">
                                {{ $oprek->kategori_project }}
                            </span>
                        @endif
                        @if ($oprek->output_project)
                            <span class="px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full font-medium">
                                {{ $oprek->output_project }}
                            </span>
                        @endif
                        @if ($oprek->penyelenggara)
                            <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs rounded-full font-medium">
                                {{ $oprek->penyelenggara }}
                            </span>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Content --}}
            <div class="p-6">
                <p class="text-gray-600 text-sm mb-4 line-clamp-3">
                    {{ $oprek->deskripsi_project }}
                </p>

                {{-- Kualifikasi --}}
                @if ($oprek->kualifikasi->count() > 0)
                    <div class="mb-4">
                        <h4 class="text-sm font-medium text-gray-900 mb-2">Kualifikasi:</h4>
                        <div class="space-y-1">
                            @foreach ($oprek->kualifikasi->take(3) as $kualifikasi)
                                <div class="text-xs text-gray-600">• {{ $kualifikasi->kualifikasi_oprek }}</div>
                            @endforeach
                            @if ($oprek->kualifikasi->count() > 3)
                                <div class="text-xs text-gray-500">+{{ $oprek->kualifikasi->count() - 3 }} lainnya</div>
                            @endif
                        </div>
                    </div>
                @endif

                <a href="{{ route('oprek.show', $oprek->id_oprek) }}" 
                   class="block w-full bg-[#4B83BF] text-white text-center px-4 py-2 rounded-lg hover:bg-[#5a93c7] transition font-medium">
                    Lihat Detail Project
                </a>
            </div>
        </div>

        @if ($loop->last)
            </div>
        @endif
    @empty
        <div class="text-center py-16">
            <div class="text-gray-400 mb-4">
                <svg class="w-20 h-20 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
            </div>
            <h4 class="text-lg font-medium text-gray-600 mb-2">Tidak ada portofolio yang ditemukan</h4>
            <p class="text-gray-600 mb-8 max-w-md mx-auto">
                @if (request()->hasAny(['search_oprek', 'deadline_filter', 'kategori_project', 'penyelenggara', 'output_project']))
                    Tidak ditemukan project yang sesuai dengan kriteria pencarian Anda. Coba ubah filter atau kata kunci pencarian.
                @else
                    Belum ada Hiring yang tersedia saat ini. Jadilah yang pertama untuk menambahkan Hiring baru.
                @endif
            </p>
            <a href="{{ route('oprek.create') }}" 
               class="inline-flex items-center bg-[#4B83BF] text-white px-6 py-3 rounded-lg hover:bg-[#5a93c7] transition font-medium">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Tambah Hiring Baru
            </a>
        </div>
    @endforelse

    {{-- Pagination --}}
    @if ($dataOprek->hasPages())
        <div class="mt-8">
            {{ $dataOprek->appends(request()->query())->links() }}
        </div>
    @endif
@endif

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