<x-app-layout>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <x-slot name="header">
        <div class="block w-full">
            <div class="flex items-center justify-between">
                <a href="{{ route('dashboard') }}"
                    class="flex items-center text-blue-400 text-sm font-medium hover:underline">
                    ← Back ke Dashboard
                </a>

                <h2 class="font-semibold text-lg text-gray-800 leading-tight">
                    {{ __('Profile') }}
                </h2>
            </div>
        </div>
    </x-slot>

    @php
        // Gunakan variable $user yang dikirim dari controller, tanpa fallback
        $isOwner = auth()->id() === $user->id_pengguna;
        $angkatan = $user->role === 'mahasiswa' && !empty($user->nim) ? '20' . substr($user->nim, 0, 2) : null;
        $pengabdian = $pengabdian ?? [];
        $prestasi = $prestasi ?? [];
        $sertifikasi = $sertifikasi ?? [];
        $portofolio = $portofolio ?? [];
    @endphp

    <div class="py-8">
        <div class="max-w-7xl mx-auto bg-white shadow rounded-lg overflow-hidden border relative">

            <div class="bg-gradient-to-b from-blue-400 to-blue-200 h-32">
                @if ($isOwner)
                    <button onclick="toggleEditProfile()"
                        class="absolute top-4 right-4 px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700 text-sm transition">
                        Edit Profile
                    </button>
                @else
                    <button
                        class="absolute top-4 right-4 px-4 py-2 bg-gray-400 text-white rounded text-sm cursor-not-allowed"
                        disabled>
                        Edit Profile
                    </button>
                @endif
            </div>

            <div class="absolute top-20 left-1/2 transform -translate-x-1/2 ">
                <div
                    class="w-24 h-24 rounded-full bg-gray-400 border-4 border-white flex items-center justify-center shadow">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-white" fill="currentColor"
                        viewBox="0 0 24 24">
                        <path
                            d="M12 12c2.7 0 4.8-2.1 4.8-4.8S14.7 2.4 12 2.4 7.2 4.5 7.2 7.2 9.3 12 12 12zm0 2.4c-3.2 0-9.6 1.6-9.6 4.8v2.4h19.2v-2.4c0-3.2-6.4-4.8-9.6-4.8z" />
                    </svg>
                </div>
            </div>

            <div class="flex flex-col items-center p-6 mt-10">
                <h3 class="text-2xl font-bold text-center">{{ $user->nama_pengguna }}</h3>
                <div class="text-blue-600 font-medium capitalize mt-1">{{ $user->role }}</div>
                @if ($angkatan)
                    <div class="text-gray-500 text-sm">Angkatan: {{ $angkatan }}</div>
                @endif
            </div>

            <div class="flex gap-4 justify-center pb-6">
                <a href="#"
                    class="w-10 h-10 bg-blue-500 text-white flex items-center justify-center rounded-full hover:bg-blue-600 transition"
                    title="GitHub">
                    <i class="fab fa-github"></i>
                </a>
                <a href="#"
                    class="w-10 h-10 bg-blue-500 text-white flex items-center justify-center rounded-full hover:bg-blue-600 transition"
                    title="LinkedIn">
                    <i class="fab fa-linkedin-in"></i>
                </a>
                <a href="#"
                    class="w-10 h-10 bg-blue-500 text-white flex items-center justify-center rounded-full hover:bg-blue-600 transition"
                    title="Email">
                    <i class="fas fa-envelope"></i>
                </a>
            </div>
        </div>
    </div>

    {{-- Section Edit Profile (hanya untuk pemilik) --}}
    @if ($isOwner)
        <div id="edit-profile-section" class="max-w-7xl mx-auto bg-white shadow rounded-lg p-8 mb-8 hidden">
            <div class="flex justify-between items-center mb-6">
                <h4 class="text-lg text-[#4B83BF] font-semibold">Edit Profile</h4>
                <button onclick="toggleEditProfile()" class="text-gray-500 hover:text-gray-700">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <livewire:profile.update-profile-information-form />

            <div class="mt-6">
                <livewire:profile.update-password-form />
            </div>

            <div class="mt-6">
                <div class="bg-white shadow sm:rounded-lg p-6">
                    <livewire:profile.delete-user-form />
                </div>
            </div>
        </div>
    @endif

    {{-- Tabs sesuai role --}}
    @if ($user->role === 'mahasiswa')
        <div class="max-w-7xl mx-auto bg-white shadow rounded-lg p-8 mb-8">
            <div class="flex gap-6 mb-6 border-b border-gray-200">
                <button
                    class="tab-btn font-medium py-2 border-b-2 border-transparent text-gray-600 hover:border-black hover:text-black"
                    onclick="showTab('portofolio')">Portofolio</button>
                <button
                    class="tab-btn font-medium py-2 border-b-2 border-transparent text-gray-600 hover:border-black hover:text-black"
                    onclick="showTab('prestasi')">Prestasi</button>
                <button
                    class="tab-btn font-medium py-2 border-b-2 border-transparent text-gray-600 hover:border-black hover:text-black"
                    onclick="showTab('pengabdian')">Pengabdian</button>
            </div>

            {{-- Pengabdian --}}
            <div id="tab-pengabdian" class="tab-content">
                @if ($isOwner)
                    <div class="flex justify-center mb-4">
                        <a href="{{ route('pengabdian.create') }}"
                            class="px-4 py-2 bg-[#4B83BF] text-white rounded text-sm hover:bg-[#5a93c7] transition">
                            + Tambah Pengabdian
                        </a>
                    </div>
                @endif

                <div class="space-y-4">
                    @foreach ($pengabdian as $item)
                        <div class="flex flex-col md:flex-row bg-white rounded-lg shadow-md overflow-hidden">
                            {{-- Gambar Pengabdian --}}
                            <div class="w-full md:w-1/3 aspect-[4/3] md:h-60 overflow-hidden">
                                <img src="{{ asset('storage/' . $item->dokumentasi->first()->dokumentasi_pengabdian) }}"
                                    alt="pengabdian" class="object-cover w-full h-full">
                            </div>

                            {{-- Konten Pengabdian --}}
                            <div class="flex-1 p-4 flex flex-col justify-between">
                                <div>
                                    <h3 class="text-lg font-semibold mb-2">{{ $item->judul_pengabdian }}</h3>
                                    <div class="text-gray-500 text-sm">
                                        {{ $item->deskripsi_pengabdian ?? 'Tidak ada deskripsi' }}
                                    </div>
                                    <p class="text-sm text-gray-600 mt-2">
                                        {{ \Carbon\Carbon::parse($item->tanggal_pengabdian)->translatedFormat('d F Y') }}
                                    </p>
                                </div>

                                {{-- Aksi --}}
                                <div class="flex justify-end items-center gap-3 mt-4">
                                    {{-- Hanya pemilik yang bisa edit --}}
                                    @if ($item->id_pengguna == auth()->id())
                                        <a href="{{ route('pengabdian.edit', $item->id_pengabdian) }}"
                                            class="text-[#4B83BF] hover:underline text-sm">Edit</a>
                                    @else
                                        {{-- Yang bukan pemilik hanya bisa lihat --}}
                                        <a href="{{ route('pengabdian.show', $item->id_pengabdian) }}"
                                            class="text-[#4B83BF] hover:underline text-sm">Lihat</a>
                                    @endif
                                    {{-- Hanya pemilik yang bisa hapus --}}
                                    @if ($item->id_pengguna == auth()->id())
                                        <form action="{{ route('pengabdian.destroy', $item->id_pengabdian) }}"
                                            method="POST" onsubmit="return confirm('Yakin hapus?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:underline text-sm">
                                                <i class="fas fa-trash"></i> Hapus
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Prestasi --}}
            <div id="tab-prestasi" class="tab-content hidden">
                @if ($isOwner)
                    <div class="flex justify-center mb-4">
                        <a href="{{ route('prestasi.create') }}"
                            class="px-4 py-2 bg-[#4B83BF] text-white rounded text-sm hover:bg-[#5a93c7] transition">
                            + Tambah Prestasi
                        </a>
                    </div>
                @endif

                <div class="space-y-4">
                    @foreach ($prestasi as $item)
                        {{-- Tampilkan semua data yang sudah difilter di controller --}}
                        <div class="flex flex-col md:flex-row bg-white rounded-lg shadow-md overflow-hidden">
                            {{-- Gambar Prestasi --}}
                            <div class="w-full md:w-1/3 aspect-[4/3] md:h-60 overflow-hidden">
                                <img src="{{ asset('storage/' . $item->dokumentasi->first()->dokumentasi_prestasi) }}"
                                    alt="prestasi" class="object-cover w-full h-full">
                            </div>

                            {{-- Konten Prestasi --}}
                            <div class="flex-1 p-4 flex flex-col justify-between">
                                <div>
                                    <span
                                        class="inline-block bg-yellow-100 text-yellow-800 text-xs font-semibold px-2 py-1 rounded-full mb-2">
                                        Prestasi
                                    </span>

                                    <h3 class="text-lg font-semibold mb-2">
                                        {{ $item->nama_prestasi }}
                                    </h3>

                                    <p class="text-gray-500 text-sm">
                                        {{ $item->deskripsi_prestasi ?? 'Tidak ada deskripsi' }}
                                    </p>

                                    <p class="text-sm text-gray-600 mt-2">
                                        {{ \Carbon\Carbon::parse($item->tanggal_perolehan)->translatedFormat('d F Y') }}
                                    </p>
                                </div>

                                {{-- Aksi --}}
                                <div class="flex justify-end items-center gap-3 mt-4">
                                    {{-- Hanya pemilik yang bisa edit --}}
                                    @if ($item->id_pengguna == auth()->id())
                                        <a href="{{ route('prestasi.edit', $item->id_prestasi) }}"
                                            class="text-[#4B83BF] hover:underline text-sm">Edit</a>
                                    @else
                                        {{-- Yang bukan pemilik hanya bisa lihat --}}
                                        <a href="{{ route('prestasi.show', $item->id_prestasi) }}"
                                            class="text-[#4B83BF] hover:underline text-sm">Lihat</a>
                                    @endif
                                    {{-- Hanya pemilik yang bisa hapus --}}
                                    @if ($item->id_pengguna == auth()->id())
                                        <form action="{{ route('prestasi.destroy', $item->id_prestasi) }}"
                                            method="POST" onsubmit="return confirm('Yakin hapus?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:underline text-sm">
                                                <i class="fas fa-trash"></i> Hapus
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Portofolio --}}
            <div id="tab-portofolio" class="tab-content hidden">
                @if ($isOwner)
                    <div class="flex justify-center mb-4">
                        <a href="{{ route('portofolio.create') }}"
                            class="px-4 py-2 bg-[#4B83BF] text-white rounded text-sm hover:bg-[#5a93c7] transition">
                            + Tambah Portofolio
                        </a>
                    </div>
                @endif

                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                    @foreach ($portofolio as $item)
                        <div
                            class="bg-white rounded-xl shadow-md overflow-hidden relative group transition hover:shadow-lg">
                            {{-- Gambar Portofolio --}}
                            <div class="w-full md:w-1/3 aspect-[4/3] md:h-60 overflow-hidden">
                                <img src="{{ $item->thumbnail_url ?? asset('default-image.jpg') }}" alt="portofolio"
                                    class="object-cover w-full h-full">
                            </div>

                            {{-- Tombol hapus (hanya untuk pemilik) --}}
                            @if ($item->id_pengguna == auth()->id())
                                <form action="{{ route('portofolio.destroy', $item->id_portofolio) }}" method="POST"
                                    onsubmit="return confirm('Yakin hapus?')" class="absolute top-2 right-2 z-10">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                        class="text-red-600 bg-white rounded-full p-1 shadow hover:bg-red-50">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            @endif

                            {{-- Konten --}}
                            <div class="p-4 space-y-2">
                                <h3 class="text-base font-semibold text-gray-900">
                                    {{ $item->nama_portofolio }}
                                </h3>

                                {{-- Label kategori --}}
                                <span
                                    class="inline-block bg-yellow-100 text-yellow-800 text-xs font-medium px-2 py-1 rounded-full">
                                    {{ $item->kategori ?? 'Machine Learning' }}
                                </span>

                                <div class="text-gray-500 text-sm">
                                    {{ $item->deskripsi_portofolio ?? 'Tidak ada deskripsi' }}
                                </div>

                                {{-- Footer Info --}}
                                <div class="flex justify-between text-xs text-gray-400 mt-3">
                                    <span>{{ \Carbon\Carbon::parse($item->created_at)->translatedFormat('d F Y') }}</span>
                                    <span>{{ $item->views ?? '0' }} Views</span>
                                </div>

                                {{-- Aksi --}}
                                <div class="flex justify-end gap-2 mt-2">
                                    @if ($item->id_pengguna == auth()->id())
                                        <a href="{{ route('portofolio.edit', $item->id_portofolio) }}"
                                            class="text-[#4B83BF] hover:underline text-sm">Edit</a>
                                    @else
                                        <a href="{{ route('portofolio.show', $item->id_portofolio) }}"
                                            class="text-[#4B83BF] hover:underline text-sm">Lihat</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @elseif($user->role === 'dosen')
        <div class="max-w-7xl mx-auto bg-white shadow rounded-lg p-8 mb-8">
            <div class="flex gap-6 mb-6 border-b border-gray-200">
                <button
                    class="tab-btn font-medium py-2 border-b-2 border-transparent text-gray-600 hover:border-black hover:text-black"
                    onclick="showTab('pengabdian')">Pengabdian</button>
                <button
                    class="tab-btn font-medium py-2 border-b-2 border-transparent text-gray-600 hover:border-black hover:text-black"
                    onclick="showTab('prestasi')">Prestasi</button>
                <button
                    class="tab-btn font-medium py-2 border-b-2 border-transparent text-gray-600 hover:border-black hover:text-black"
                    onclick="showTab('sertifikasi')">Sertifikasi</button>
                <button
                    class="tab-btn font-medium py-2 border-b-2 border-transparent text-gray-600 hover:border-black hover:text-black"
                    onclick="showTab('portofolio')">Portofolio</button>
            </div>

            {{-- Pengabdian --}}
            <div id="tab-pengabdian" class="tab-content">
                @if ($isOwner)
                    <div class="flex justify-center mb-4">
                        <a href="{{ route('pengabdian.create') }}"
                            class="px-4 py-2 bg-[#4B83BF] text-white rounded text-sm hover:bg-[#5a93c7] transition">
                            + Tambah Pengabdian
                        </a>
                    </div>
                @endif
                <div class="space-y-4">
                    @foreach ($pengabdian as $item)
                        <div class="flex flex-col md:flex-row bg-white rounded-lg shadow-md overflow-hidden">
                            {{-- Gambar Pengabdian --}}
                            <div class="w-full md:w-1/3 aspect-[4/3] md:h-60 overflow-hidden">
                                <img src="{{ asset('storage/' . $item->dokumentasi->first()->dokumentasi_pengabdian) }}"
                                    alt="pengabdian" class="object-cover w-full h-full">
                            </div>

                            {{-- Konten Pengabdian --}}
                            <div class="flex-1 p-4 flex flex-col justify-between">
                                <div>
                                    <h3 class="text-lg font-semibold mb-2">{{ $item->judul_pengabdian }}</h3>
                                    <div class="text-gray-500 text-sm">
                                        {{ $item->deskripsi_pengabdian ?? 'Tidak ada deskripsi' }}
                                    </div>
                                    <p class="text-sm text-gray-600 mt-2">
                                        {{ \Carbon\Carbon::parse($item->tanggal_pengabdian)->translatedFormat('d F Y') }}
                                    </p>
                                </div>

                                {{-- Aksi --}}
                                <div class="flex justify-end items-center gap-3 mt-4">
                                    {{-- Hanya pemilik yang bisa edit --}}
                                    @if ($item->id_pengguna == auth()->id())
                                        <a href="{{ route('pengabdian.edit', $item->id_pengabdian) }}"
                                            class="text-[#4B83BF] hover:underline text-sm">Edit</a>
                                    @else
                                        {{-- Yang bukan pemilik hanya bisa lihat --}}
                                        <a href="{{ route('pengabdian.show', $item->id_pengabdian) }}"
                                            class="text-[#4B83BF] hover:underline text-sm">Lihat</a>
                                    @endif
                                    {{-- Hanya pemilik yang bisa hapus --}}
                                    @if ($item->id_pengguna == auth()->id())
                                        <form action="{{ route('pengabdian.destroy', $item->id_pengabdian) }}"
                                            method="POST" onsubmit="return confirm('Yakin hapus?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:underline text-sm">
                                                <i class="fas fa-trash"></i> Hapus
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Prestasi --}}
            <div id="tab-prestasi" class="tab-content hidden">
                @if ($isOwner)
                    <div class="flex justify-center mb-4">
                        <a href="{{ route('prestasi.create') }}"
                            class="px-4 py-2 bg-[#4B83BF] text-white rounded text-sm hover:bg-[#5a93c7] transition">
                            + Tambah Prestasi
                        </a>
                    </div>
                @endif

                <div class="space-y-4">
                    @foreach ($prestasi as $item)
                        {{-- Tampilkan semua data yang sudah difilter di controller --}}
                        <div class="flex flex-col md:flex-row bg-white rounded-lg shadow-md overflow-hidden">
                            {{-- Gambar Prestasi --}}
                            <div class="w-full md:w-1/3 aspect-[4/3] md:h-60 overflow-hidden">
                                <img src="{{ asset('storage/' . $item->dokumentasi->first()->dokumentasi_prestasi) }}"
                                    alt="prestasi" class="object-cover w-full h-full">
                            </div>

                            {{-- Konten Prestasi --}}
                            <div class="flex-1 p-4 flex flex-col justify-between">
                                <div>
                                    <span
                                        class="inline-block text-xs font-semibold px-2 py-1 {{ $item->jenis_prestasi === 'Akademik' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800' }}">
                                        {{ $item->jenis_prestasi }}
                                    </span>

                                    <h3 class="text-lg font-semibold mb-2">
                                        {{ $item->nama_prestasi }}
                                    </h3>

                                    <p class="text-gray-500 text-sm">{{ $item->penyelenggara ?? '-' }}</p>
                                </div>

                                {{-- Aksi --}}
                                <div class="flex justify-end items-center gap-3 mt-4">
                                    @if ($item->id_pengguna == auth()->id())
                                        <a href="{{ route('prestasi.edit', $item->id_prestasi) }}"
                                            class="text-[#4B83BF] hover:underline text-sm">Edit</a>
                                    @else
                                        <a href="{{ route('prestasi.show', $item->id_prestasi) }}"
                                            class="text-[#4B83BF] hover:underline text-sm">Lihat</a>
                                    @endif

                                    @if ($item->id_pengguna == auth()->id())
                                        <form action="{{ route('prestasi.destroy', $item->id_prestasi) }}"
                                            method="POST" onsubmit="return confirm('Yakin hapus?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:underline text-sm">
                                                <i class="fas fa-trash"></i> Hapus
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Sertifikasi --}}
            <div id="tab-sertifikasi" class="tab-content hidden">
                @if ($isOwner)
                    <div class="flex justify-center mb-4">
                        <a href="{{ route('sertifikasi.create') }}"
                            class="px-4 py-2 bg-[#4B83BF] text-white rounded text-sm hover:bg-[#5a93c7] transition">
                            + Tambah Sertifikasi
                        </a>
                    </div>
                @endif

                <div class="space-y-4">
                    @foreach ($sertifikasi as $item)
                        <div class="flex flex-col md:flex-row bg-white rounded-lg shadow-md overflow-hidden">
                            {{-- PDF Sertifikasi --}}
                            <div class="w-full md:w-1/3 aspect-[4/3] overflow-hidden">
                                @if ($item->file_sertifikasi && pathinfo($item->file_sertifikasi, PATHINFO_EXTENSION) === 'pdf')
                                    <iframe src="{{ asset('storage/' . $item->file_sertifikasi) }}"
                                        class="w-full h-full" frameborder="0"></iframe>
                                @else
                                    <div
                                        class="w-full h-full flex flex-col items-center justify-center bg-gray-100 text-gray-400">
                                        <i class="fas fa-file-pdf text-4xl mb-2"></i>
                                        <span class="text-sm">Tidak ada dokumen PDF</span>
                                    </div>
                                @endif
                            </div>

                            {{-- Konten Sertifikasi --}}
                            <div class="flex-1 p-4 flex flex-col justify-between">
                                <div>
                                    <span
                                        class="inline-block bg-green-100 text-green-800 text-xs font-semibold px-2 py-1 rounded-full mb-2">
                                        Sertifikasi
                                    </span>

                                    <h3 class="text-lg font-semibold mb-2">
                                        {{ $item->nama_sertifikasi }}
                                    </h3>

                                    <div class="text-sm text-gray-600 mb-1">
                                        <span class="font-medium">Lembaga Penerbit :</span>
                                        {{ $item->penyelenggara ?? '-' }}
                                    </div>
                                </div>

                                {{-- Aksi --}}
                                <div class="flex justify-end items-center gap-3 mt-4">
                                    @if ($item->id_pengguna == auth()->id())
                                        <a href="{{ route('sertifikasi.edit', $item->id_sertifikasi) }}"
                                            class="text-[#4B83BF] hover:underline text-sm">Edit</a>
                                    @else
                                        <a href="{{ route('sertifikasi.show', $item->id_sertifikasi) }}"
                                            class="text-[#4B83BF] hover:underline text-sm">Lihat</a>
                                    @endif

                                    @if ($item->id_pengguna == auth()->id())
                                        <form action="{{ route('sertifikasi.destroy', $item->id_sertifikasi) }}"
                                            method="POST" onsubmit="return confirm('Yakin hapus?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:underline text-sm">
                                                <i class="fas fa-trash"></i> Hapus
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Portofolio --}}
        <div id="tab-portofolio" class="tab-content hidden">
            @if ($isOwner)
                <div class="flex justify-center mb-4">
                    <a href="{{ route('portofolio.create') }}"
                        class="px-4 py-2 bg-[#4B83BF] text-white rounded text-sm hover:bg-[#5a93c7] transition">
                        + Tambah Portofolio
                    </a>
                </div>
            @endif

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                @foreach ($portofolio as $item)
                    <div
                        class="bg-white rounded-xl shadow-md overflow-hidden relative group transition hover:shadow-lg">
                        {{-- Gambar Portofolio --}}
                        <div class="w-full md:w-1/3 aspect-[4/3] md:h-60 overflow-hidden">
                            <img src="{{ $item->thumbnail_url ?? asset('default-image.jpg') }}" alt="portofolio"
                                class="object-cover w-full h-full">
                        </div>

                        {{-- Tombol hapus (hanya untuk pemilik) --}}
                        @if ($item->id_pengguna == auth()->id())
                            <form action="{{ route('portofolio.destroy', $item->id_portofolio) }}" method="POST"
                                onsubmit="return confirm('Yakin hapus?')" class="absolute top-2 right-2 z-10">
                                @csrf @method('DELETE')
                                <button type="submit"
                                    class="text-red-600 bg-white rounded-full p-1 shadow hover:bg-red-50">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        @endif

                        {{-- Konten --}}
                        <div class="p-4 space-y-2">
                            <h3 class="text-base font-semibold text-gray-900">
                                {{ $item->nama_portofolio }}
                            </h3>

                            <div class="text-gray-500 text-sm">
                                {{ $item->deskripsi_portofolio ?? 'Tidak ada deskripsi' }}
                            </div>

                            {{-- Aksi --}}
                            <div class="flex justify-end gap-2 mt-2">
                                @if ($item->id_pengguna == auth()->id())
                                    <a href="{{ route('portofolio.edit', $item->id_portofolio) }}"
                                        class="text-[#4B83BF] hover:underline text-sm">Edit</a>
                                @else
                                    <a href="{{ route('portofolio.show', $item->id_portofolio) }}"
                                        class="text-[#4B83BF] hover:underline text-sm">Lihat</a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        </div>
    @endif

    <script>
        function showTab(tab) {
            document.querySelectorAll('.tab-content').forEach(el => el.classList.add('hidden'));
            document.getElementById('tab-' + tab).classList.remove('hidden');
            document.querySelectorAll('.tab-btn').forEach(el => el.classList.remove('active'));
            event.target.classList.add('active');
        }

        function toggleEditProfile() {
            const editSection = document.getElementById('edit-profile-section');
            editSection.classList.toggle('hidden');

            // Smooth scroll ke section jika muncul
            if (!editSection.classList.contains('hidden')) {
                editSection.scrollIntoView({
                    behavior: 'smooth'
                });
            }
        }
    </script>
</x-app-layout>
