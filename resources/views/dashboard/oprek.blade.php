{{-- Informasi Oprek --}}
<section class="bg-[#DDF1FB]">
    <div id="oprek-section" class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div
                class="bg-white rounded-xl p-6 shadow-md border hover:shadow-lg transition-all duration-300 hover:-translate-y-1 relative">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-semibold">Informasi Oprek</h3>
                        @auth
                            <a href="{{ route('oprek.create') }}"
                                class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                                + Tambah Oprek
                            </a>
                        @endauth
                    </div>

                    @if (auth()->user()->hasRole('admin'))
                        {{-- Tampilan untuk Admin --}}
                        <div class="mb-6 bg-gray-50 rounded-lg p-4">
                            <form method="GET" class="space-y-4">
                                <input type="hidden" name="tab" value="oprek">

                                <div class="grid md:grid-cols-4 gap-4">
                                    {{-- Search Bar --}}
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Cari Project</label>
                                        <input type="text" name="search_oprek" value="{{ request('search_oprek') }}"
                                            placeholder="Cari berdasarkan nama project..."
                                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    </div>

                                    {{-- Filter Status --}}
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Status
                                            Project</label>
                                        <select name="status_project"
                                            class="w-full py-2 px-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                            <option value="">Semua Status</option>
                                            <option value="1"
                                                {{ request('status_project') == '1' ? 'selected' : '' }}>Sudah
                                                Divalidasi</option>
                                            <option value="0"
                                                {{ request('status_project') == '0' ? 'selected' : '' }}>Belum
                                                Divalidasi</option>
                                        </select>
                                    </div>

                                    {{-- Filter Kategori --}}
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Kategori
                                            Project</label>
                                        <select name="kategori_project"
                                            class="w-full py-2 px-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                            <option value="">Semua Kategori</option>
                                            <option value="Penelitian"
                                                {{ request('kategori_project') == 'Penelitian' ? 'selected' : '' }}>
                                                Penelitian</option>
                                            <option value="Pengembangan Aplikasi"
                                                {{ request('kategori_project') == 'Pengembangan Aplikasi' ? 'selected' : '' }}>
                                                Pengembangan Aplikasi</option>
                                            <option value="Pengabdian Masyarakat"
                                                {{ request('kategori_project') == 'Pengabdian Masyarakat' ? 'selected' : '' }}>
                                                Pengabdian Masyarakat</option>
                                            <option value="Inisiatif Pribadi"
                                                {{ request('kategori_project') == 'Inisiatif Pribadi' ? 'selected' : '' }}>
                                                Inisiatif Pribadi</option>
                                        </select>
                                    </div>

                                    {{-- Filter Output --}}
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Output
                                            Project</label>
                                        <select name="output_project"
                                            class="w-full py-2 px-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                            <option value="">Semua Output</option>
                                            <option value="Website"
                                                {{ request('output_project') == 'Website' ? 'selected' : '' }}>Website
                                            </option>
                                            <option value="Mobile Apps"
                                                {{ request('output_project') == 'Mobile Apps' ? 'selected' : '' }}>
                                                Mobile App</option>
                                            <option value="Desktop Apps"
                                                {{ request('output_project') == 'Desktop Apps' ? 'selected' : '' }}>
                                                Desktop App</option>
                                            <option value="Game"
                                                {{ request('output_project') == 'Game' ? 'selected' : '' }}>Game
                                            </option>
                                            <option value="IoT"
                                                {{ request('output_project') == 'IoT' ? 'selected' : '' }}>IoT
                                            </option>
                                            <option value="AI/ML"
                                                {{ request('output_project') == 'AI/ML' ? 'selected' : '' }}>AI/ML
                                            </option>
                                            <option value="Blockchain"
                                                {{ request('output_project') == 'Blockchain' ? 'selected' : '' }}>
                                                Blockchain</option>
                                        </select>
                                    </div>
                                </div>

                                {{-- Filter Tanggal --}}
                                <div class="grid md:grid-cols-3 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Filter
                                            Deadline</label>
                                        <select name="deadline_filter"
                                            class="w-full py-2 px-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                            <option value="">Semua Deadline</option>
                                            <option value="today"
                                                {{ request('deadline_filter') == 'today' ? 'selected' : '' }}>Hari Ini
                                            </option>
                                            <option value="this_week"
                                                {{ request('deadline_filter') == 'this_week' ? 'selected' : '' }}>
                                                Minggu Ini</option>
                                            <option value="this_month"
                                                {{ request('deadline_filter') == 'this_month' ? 'selected' : '' }}>
                                                Bulan Ini</option>
                                        </select>
                                    </div>

                                    {{-- Filter Penyelenggara --}}
                                    <div>
                                        <label
                                            class="block text-sm font-medium text-gray-700 mb-1">Penyelenggara</label>
                                        <select name="penyelenggara_project"
                                            class="w-full py-2 px-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                            <option value="">Semua Penyelenggara</option>
                                            <option value="Dosen"
                                                {{ request('penyelenggara_project') == 'Dosen' ? 'selected' : '' }}>
                                                Dosen</option>
                                            <option value="Mahasiswa"
                                                {{ request('penyelenggara_project') == 'Mahasiswa' ? 'selected' : '' }}>
                                                Mahasiswa</option>
                                            <option value="Organisasi"
                                                {{ request('penyelenggara_project') == 'Organisasi' ? 'selected' : '' }}>
                                                Organisasi</option>
                                            <option value="Eksternal"
                                                {{ request('penyelenggara_project') == 'Eksternal' ? 'selected' : '' }}>
                                                Eksternal</option>
                                        </select>
                                    </div>

                                    {{-- Sort --}}
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Urutkan</label>
                                        <select name="sort_oprek"
                                            class="w-full py-2 px-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                            <option value="latest"
                                                {{ request('sort_oprek') == 'latest' ? 'selected' : '' }}>Terbaru
                                            </option>
                                            <option value="oldest"
                                                {{ request('sort_oprek') == 'oldest' ? 'selected' : '' }}>Terlama
                                            </option>
                                            <option value="name_asc"
                                                {{ request('sort_oprek') == 'name_asc' ? 'selected' : '' }}>Nama A-Z
                                            </option>
                                            <option value="deadline_asc"
                                                {{ request('sort_oprek') == 'deadline_asc' ? 'selected' : '' }}>
                                                Deadline Terdekat</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="flex gap-3">
                                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">
                                        Cari
                                    </button>
                                    <a href="{{ route('dashboard', ['tab' => 'oprek']) }}"
                                        class="bg-blue-600 text-white px-4 py-2 rounded">
                                        Reset
                                    </a>
                                </div>
                            </form>
                        </div>

                        {{-- Tampilan untuk Admin --}}
                        <div class="overflow-x-auto">
                            <table class="table-auto w-full border-collapse border border-gray-300">
                                <thead>
                                    <tr class="bg-gray-100">
                                        <th class="border border-gray-300 px-4 py-2">Nama Project</th>
                                        <th class="border border-gray-300 px-4 py-2">Deskripsi Project</th>
                                        <th class="border border-gray-300 px-4 py-2">Penyelenggara Project</th>
                                        <th class="border border-gray-300 px-4 py-2">Nama Penyelenggara</th>
                                        <th class="border border-gray-300 px-4 py-2">Kategori</th>
                                        <th class="border border-gray-300 px-4 py-2">Output</th>
                                        <th class="border border-gray-300 px-4 py-2">Kualifikasi Oprek</th>
                                        <th class="border border-gray-300 px-4 py-2">Deadline</th>
                                        <th class="border border-gray-300 px-4 py-2">Tautan Pendaftaran</th>
                                        <th class="border border-gray-300 px-4 py-2">Flyer Informasi</th>
                                        <th class="border border-gray-300 px-4 py-2">Status</th>
                                        <th class="border border-gray-300 px-4 py-2">Komentar</th>
                                        <th class="border border-gray-300 px-4 py-2">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($dataOprek as $oprek)
                                        <tr class="hover:bg-gray-50">
                                            <td class="border border-gray-300 px-4 py-2">{{ $oprek->nama_project }}
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2">
                                                {{ Str::limit($oprek->deskripsi_project, 50) }}</td>
                                            <td class="border border-gray-300 px-4 py-2">{{ $oprek->penyelenggara }}
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2">
                                                {{ $oprek->nama_penyelenggara }}</td>
                                            <td class="border border-gray-300 px-4 py-2">{{ $oprek->kategori_project }}
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2">{{ $oprek->output_project }}
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2">
                                                @if ($oprek->kualifikasi->count() > 0)
                                                    <div class="space-y-1 max-w-xs">
                                                        @foreach ($oprek->kualifikasi as $kualifikasi)
                                                            <div>- {{ $kualifikasi->kualifikasi_oprek }}</div>
                                                        @endforeach
                                                    </div>
                                                @else
                                                    <span class="text-gray-400 text-sm">Tidak ada kualifikasi
                                                        khusus</span>
                                                @endif
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2">
                                                @if ($oprek->deadline_project)
                                                    {{ date('d M Y', strtotime($oprek->deadline_project)) }}</>
                                                    @if ($oprek->isExpired())
                                                        <div class="text-red-600">Berakhir</div>
                                                    @else
                                                        <div class="text-green-600">Aktif</div>
                                                    @endif
                                                @endif
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2">{{ $oprek->tautan_project }}
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2">
                                                <a href="{{ Storage::url($oprek->flyer_informasi) }}"
                                                    target="_blank">
                                                    <img src="{{ Storage::url($oprek->flyer_informasi) }}"
                                                        alt="Flyer Informasi" class="w-32 h-auto rounded shadow" />
                                                </a>
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2">
                                                @if ($oprek->status_project == 1)
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
                                                @php
                                                    $notif = \App\Models\Notifikasi::where(
                                                        'notifiable_id',
                                                        $oprek->id_oprek,
                                                    )
                                                        ->where('notifiable_type', 'oprek')
                                                        ->latest()
                                                        ->first();
                                                @endphp
                                                <div class="space-y-2">
                                                    @if ($notif && $notif->isi_notifikasi)
                                                        {{ $notif->isi_notifikasi }}
                                                    @endif

                                                    @if ($oprek->status_project == 0)
                                                        <form action="{{ route('oprek.komentar', $oprek->id_oprek) }}"
                                                            method="POST" class="flex gap-1">
                                                            @csrf
                                                            <textarea name="isi_notifikasi" class="flex-1 border rounded p-1" rows="1" placeholder="Komentar..." required>{{ $notif->isi_notifikasi ?? '' }}</textarea>
                                                            <button type="submit"
                                                                class="px-4 py-2 text-white bg-blue-500 hover:bg-blue-600 rounded">
                                                                Kirim
                                                            </button>
                                                        </form>
                                                    @else
                                                        <span class="text-black">Tidak ada komentar</span>
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2">
                                                <div class="flex gap-2 flex-wrap">
                                                    {{-- Validation Button --}}
                                                    @if ($oprek->status_project == 0)
                                                        <form
                                                            action="{{ route('admin.oprek.validate', $oprek->id_oprek) }}"
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
                                                    @if (auth()->user()->hasRole('admin') || (isset($oprek->user_id) && auth()->user()->id == $oprek->user_id))
                                                        <a href="{{ route('oprek.edit', $oprek->id_oprek) }}"
                                                            class="bg-orange-500 text-white px-2 py-1 rounded hover:bg-orange-600 transition">
                                                            Edit
                                                        </a>
                                                    @endif

                                                    {{-- Delete Button - Only for Admin --}}
                                                    @if (auth()->user()->hasRole('admin'))
                                                        <form action="{{ route('oprek.destroy', $oprek->id_oprek) }}"
                                                            method="POST" class="inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                class="bg-red-600 text-white px-2 py-1 rounded hover:bg-red-700 transition"
                                                                onclick="return confirm('Yakin ingin menghapus informasi hiring ini?')">
                                                                Hapus
                                                            </button>
                                                        </form>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center text-gray-500 py-8">
                                                <div class="flex flex-col items-center">
                                                    Tidak ada project yang sesuai filter.
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
                                Menampilkan <strong>{{ $dataOprek->count() }}</strong> dari
                                <strong>{{ $dataOprek->total() }}</strong> hiring project
                            </div>
                            <div>
                                {{ $dataOprek->links('vendor.pagination.always') }}
                            </div>
                        </div>
                    @else
                        {{-- Search & Filter Bar --}}
                        <div class="mb-6 bg-gray-50 rounded-lg p-4">
                            <form method="GET" action="{{ route('dashboard') }}#oprek-section" class="space-y-4">
                                <div class="grid md:grid-cols-4 gap-4">
                                    {{-- Search Bar --}}
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Cari
                                            Project</label>
                                        <div class="relative">
                                            <input type="text" name="search_oprek"
                                                value="{{ request('search_oprek') }}"
                                                placeholder="Cari berdasarkan nama project..."
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

                                    {{-- Filter Deadline --}}
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Filter
                                            Deadline</label>
                                        <select name="deadline_filter"
                                            class="w-full py-2 px-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                            <option value="">Semua Deadline</option>
                                            <option value="today"
                                                {{ request('deadline_filter') == 'today' ? 'selected' : '' }}>Hari Ini
                                            </option>
                                            <option value="this_week"
                                                {{ request('deadline_filter') == 'this_week' ? 'selected' : '' }}>
                                                Minggu Ini</option>
                                            <option value="this_month"
                                                {{ request('deadline_filter') == 'this_month' ? 'selected' : '' }}>
                                                Bulan Ini</option>
                                            <option value="upcoming"
                                                {{ request('deadline_filter') == 'upcoming' ? 'selected' : '' }}>Akan
                                                Datang</option>
                                        </select>
                                    </div>

                                    {{-- Filter Output --}}
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Output
                                            Project</label>
                                        <select name="output_project"
                                            class="w-full py-2 px-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                            <option value="">Semua Output</option>
                                            <option value="Website"
                                                {{ request('output_project') == 'website' ? 'selected' : '' }}>Website
                                            </option>
                                            <option value="Mobile Apps"
                                                {{ request('output_project') == 'mobile_app' ? 'selected' : '' }}>
                                                Mobile App</option>
                                            <option value="API Development"
                                                {{ request('output_project') == 'desktop_app' ? 'selected' : '' }}>
                                                Desktop App</option>
                                            <option value="Game"
                                                {{ request('output_project') == 'game' ? 'selected' : '' }}>Game
                                            </option>
                                            <option value="Machine Learning/AI Project"
                                                {{ request('output_project') == 'iot' ? 'selected' : '' }}>IoT</option>
                                            <option value="Cyber Security"
                                                {{ request('output_project') == 'ai_ml' ? 'selected' : '' }}>AI/ML
                                            </option>
                                            <option value="Automation"
                                                {{ request('output_project') == 'blockchain' ? 'selected' : '' }}>
                                                Blockchain</option>
                                            <option value="Embedded System"
                                                {{ request('output_project') == 'other' ? 'selected' : '' }}>Lainnya
                                            </option>
                                        </select>
                                    </div>

                                    {{-- Sort --}}
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Urutkan</label>
                                        <select name="sort_oprek"
                                            class="w-full py-2 px-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                            <option value="latest"
                                                {{ request('sort_oprek') == 'latest' ? 'selected' : '' }}>Terbaru
                                            </option>
                                            <option value="oldest"
                                                {{ request('sort_oprek') == 'oldest' ? 'selected' : '' }}>Terlama
                                            </option>
                                            <option value="deadline"
                                                {{ request('sort_oprek') == 'deadline' ? 'selected' : '' }}>Deadline
                                                Terdekat</option>
                                            <option value="name"
                                                {{ request('sort_oprek') == 'name' ? 'selected' : '' }}>Nama A-Z
                                            </option>
                                        </select>
                                    </div>
                                </div>

                                {{-- Multi-select Kategori Project --}}
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Kategori
                                        Project</label>
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
                                            <label class="flex items-center space-x-2 cursor-pointer">
                                                <input type="checkbox" name="kategori_project[]"
                                                    value="{{ $value }}"
                                                    {{ in_array($value, $selectedKategori) ? 'checked' : '' }}
                                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 focus:ring-2 rounded">
                                                <span class="text-sm text-gray-700">{{ $label }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>

                                {{-- Multi-select Penyelenggara --}}
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Penyelenggara</label>
                                    <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                                        @php
                                            $penyelenggaraOptions = [
                                                'Dosen' => 'Dosen',
                                                'Mahasiswa' => 'Mahasiswa',
                                                'Organisasi' => 'Organisasi',
                                                'Eksternal' => 'Eksternal',
                                            ];
                                            $selectedPenyelenggara = request('penyelenggara_project', []);
                                        @endphp

                                        @foreach ($penyelenggaraOptions as $value => $label)
                                            <label class="flex items-center space-x-2 cursor-pointer">
                                                <input type="checkbox" name="penyelenggara_project[]"
                                                    value="{{ $value }}"
                                                    {{ in_array($value, $selectedPenyelenggara) ? 'checked' : '' }}
                                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 focus:ring-2 rounded">
                                                <span class="text-sm text-gray-700">{{ $label }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>

                                <div class="flex gap-3">
                                    <button type="submit"
                                        class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition font-medium">
                                        Cari
                                    </button>
                                    <a href="{{ route('dashboard') }}#oprek-section"
                                        class="bg-gray-200 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-300 transition font-medium">
                                        Reset
                                    </a>
                                </div>
                            </form>
                        </div>

                        {{-- Results Info --}}
                        <div class="mb-4 flex justify-between items-center">
                            <div class="text-sm text-gray-600">
                                Menampilkan {{ $dataOprek->count() }} dari {{ $dataOprek->total() }} project
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

                            <div
                                class="bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow-md transition overflow-hidden">
                                {{-- Header --}}
                                <div class="p-4 border-b border-gray-100">
                                    <div class="flex justify-between items-start mb-2">
                                        <h3 class="font-semibold text-lg line-clamp-2">
                                            {{ $oprek->nama_project }}
                                        </h3>
                                    </div>

                                    {{-- Project Info --}}
                                    <div class="space-y-2 text-sm text-gray-600">
                                        {{-- Deadline --}}
                                        @if ($oprek->deadline_project)
                                            <div class="flex items-center gap-2">
                                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                                <span>Deadline:
                                                    {{ date('d M Y', strtotime($oprek->deadline_project)) }}</span>
                                                @if (strtotime($oprek->deadline_project) < time())
                                                    <span class="text-red-600 text-xs">(Berakhir)</span>
                                                @endif
                                            </div>
                                        @endif

                                        {{-- Kategori & Output --}}
                                        <div class="flex gap-2 flex-wrap">
                                            @if ($oprek->kategori_project)
                                                <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs rounded-full">
                                                    {{ ucfirst(str_replace('_', ' ', $oprek->kategori_project)) }}
                                                </span>
                                            @endif
                                            @if ($oprek->output_project)
                                                <span
                                                    class="px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full">
                                                    {{ ucfirst(str_replace('_', ' ', $oprek->output_project)) }}
                                                </span>
                                            @endif
                                            @if ($oprek->penyelenggara)
                                                <span
                                                    class="px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full">
                                                    {{ ucfirst(str_replace('_', ' ', $oprek->penyelenggara)) }}
                                                </span>
                                            @endif
                                            @if ($oprek->output_project)
                                                <span
                                                    class="px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full">
                                                    {{ ucfirst(str_replace('_', ' ', $oprek->output_project)) }}
                                                </span>
                                            @endif
                                        </div>

                                        {{-- Penyelenggara --}}
                                        @if ($oprek->penyelenggara_project)
                                            <div class="flex items-center gap-2">
                                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                    <path
                                                        d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3z" />
                                                </svg>
                                                <span>{{ ucfirst($oprek->penyelenggara_project) }}</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                {{-- Content --}}
                                <div class="p-4">
                                    <p class="text-gray-600 text-sm mb-4 line-clamp-3">
                                        {{ $oprek->deskripsi_project }}
                                    </p>

                                    {{-- Owner Info --}}
                                    @if ($oprek->owner)
                                        <div class="text-xs text-gray-500 mb-3">
                                            by <span class="font-medium">{{ $oprek->owner->nama_pengguna }}</span>
                                        </div>
                                    @endif

                                    <a href="{{ route('oprek.show', $oprek->id_oprek) }}"
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
                                d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Tidak ada project</h3>
                    <p class="text-gray-600 mb-6">
                        @if (request()->hasAny([
                                'search_oprek',
                                'deadline_filter',
                                'kategori_project',
                                'penyelenggara_project',
                                'output_project',
                            ]))
                            Tidak ditemukan project yang sesuai dengan kriteria pencarian.
                        @else
                            Belum ada project yang tersedia saat ini.
                        @endif
                    </p>
                    <a href="{{ route('oprek.create') }}"
                        class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition">
                        + Tambah Project
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
</section>
