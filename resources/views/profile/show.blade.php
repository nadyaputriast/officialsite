<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
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
        <div class="max-w-3xl mx-auto bg-white shadow rounded-lg p-8 mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-2xl font-bold">{{ $user->nama_pengguna }}</h3>
                    <div class="text-gray-600 capitalize">{{ $user->role }}</div>
                    @if ($angkatan)
                        <div class="text-gray-500 text-sm">Angkatan: {{ $angkatan }}</div>
                    @endif
                </div>
                @if ($isOwner)
                    <button onclick="toggleEditProfile()"
                        class="inline-block px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm transition">
                        Edit Profile
                    </button>
                @else
                    <button class="inline-block px-4 py-2 bg-gray-400 text-white rounded text-sm cursor-not-allowed"
                        disabled>
                        Edit Profile
                    </button>
                @endif
            </div>
        </div>

        {{-- Section Edit Profile (hanya untuk pemilik) --}}
        @if ($isOwner)
            <div id="edit-profile-section" class="max-w-3xl mx-auto bg-white shadow rounded-lg p-8 mb-8 hidden">
                <div class="flex justify-between items-center mb-6">
                    <h4 class="text-lg font-semibold">Edit Profile</h4>
                    <button onclick="toggleEditProfile()" class="text-gray-500 hover:text-gray-700">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                <livewire:profile.update-profile-information-form />
                {{-- Edit Profile --}}
                <div class="mt-6">
                    <livewire:profile.update-password-form />
                </div>

                {{-- Two Factor Authentication --}}
                <div class="bg-white shadow rounded-lg p-6">
                    <livewire:profile.two-factor-authentication-form />
                </div>

                {{-- Browser Session --}}
                <div class="bg-white shadow rounded-lg p-6">
                    <livewire:profile.logout-other-browser-sessions-form :sessions="session('sessions', [])" />
                </div>
            </div>
        @endif

        {{-- Tabs sesuai role --}}
        @if ($user->role === 'mahasiswa')
            <div class="max-w-3xl mx-auto bg-white shadow rounded-lg p-8 mb-8">
                <div class="flex gap-4 mb-6">
                    <button class="tab-btn active" onclick="showTab('pengabdian')">Pengabdian</button>
                    <button class="tab-btn" onclick="showTab('prestasi')">Prestasi</button>
                    <button class="tab-btn" onclick="showTab('portofolio')">Portofolio</button>
                </div>
                {{-- Pengabdian --}}
                <div id="tab-pengabdian" class="tab-content">
                    @if ($isOwner)
                        <a href="{{ route('pengabdian.create') }}"
                            class="mb-4 inline-block px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 text-sm transition">+
                            Tambah Pengabdian</a>
                    @endif
                    @foreach ($pengabdian as $item)
                        {{-- Tampilkan semua data yang sudah difilter di controller --}}
                        <div class="mb-4 p-4 border rounded flex justify-between items-center">
                            <div>
                                <div class="font-semibold">{{ $item->judul_pengabdian }}</div>
                                <div class="text-gray-500 text-sm">
                                    {{ $item->deskripsi_pengabdian ?? 'Tidak ada deskripsi' }}</div>
                            </div>
                            <div class="flex gap-2">
                                {{-- Hanya pemilik yang bisa edit --}}
                                @if ($item->id_pengguna == auth()->id())
                                    <a href="{{ route('pengabdian.edit', $item->id_pengabdian) }}"
                                        class="text-blue-600 hover:underline text-sm">Edit</a>
                                @else
                                    {{-- Yang bukan pemilik hanya bisa lihat --}}
                                    <a href="{{ route('pengabdian.show', $item->id_pengabdian) }}"
                                        class="text-blue-600 hover:underline text-sm">Lihat</a>
                                @endif
                                {{-- Hanya pemilik yang bisa hapus --}}
                                @if ($item->id_pengguna == auth()->id())
                                    <form action="{{ route('pengabdian.destroy', $item->id_pengabdian) }}"
                                        method="POST" onsubmit="return confirm('Yakin hapus?')">
                                        @csrf @method('DELETE')
                                        <button type="submit"
                                            class="text-red-600 hover:underline text-sm">Hapus</button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
                {{-- Prestasi --}}
                <div id="tab-prestasi" class="tab-content hidden">
                    @if ($isOwner)
                        <a href="{{ route('prestasi.create') }}"
                            class="mb-4 inline-block px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 text-sm transition">+
                            Tambah Prestasi</a>
                    @endif
                    @foreach ($prestasi as $item)
                        {{-- Tampilkan semua data yang sudah difilter di controller --}}
                        <div class="mb-4 p-4 border rounded flex justify-between items-center">
                            <div>
                                <div class="font-semibold">{{ $item->nama_prestasi }}</div>
                                <div class="text-gray-500 text-sm">
                                    {{ $item->deskripsi_prestasi ?? 'Tidak ada deskripsi' }}
                                </div>
                            </div>
                            <div class="flex gap-2">
                                {{-- Hanya pemilik yang bisa edit --}}
                                @if ($item->id_pengguna == auth()->id())
                                    <a href="{{ route('prestasi.edit', $item->id_prestasi) }}"
                                        class="text-blue-600 hover:underline text-sm">Edit</a>
                                @else
                                    {{-- Yang bukan pemilik hanya bisa lihat --}}
                                    <a href="{{ route('prestasi.show', $item->id_prestasi) }}"
                                        class="text-blue-600 hover:underline text-sm">Lihat</a>
                                @endif
                                {{-- Hanya pemilik yang bisa hapus --}}
                                @if ($item->id_pengguna == auth()->id())
                                    <form action="{{ route('prestasi.destroy', $item->id_prestasi) }}" method="POST"
                                        onsubmit="return confirm('Yakin hapus?')">
                                        @csrf @method('DELETE')
                                        <button type="submit"
                                            class="text-red-600 hover:underline text-sm">Hapus</button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
                {{-- Portofolio --}}
                <div id="tab-portofolio" class="tab-content hidden">
                    @if ($isOwner)
                        <a href="{{ route('portofolio.create') }}"
                            class="mb-4 inline-block px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 text-sm transition">+
                            Tambah portofolio</a>
                    @endif
                    @foreach ($portofolio as $item)
                        {{-- Tampilkan semua data yang sudah difilter di controller --}}
                        <div class="mb-4 p-4 border rounded flex justify-between items-center">
                            <div>
                                <div class="font-semibold">{{ $item->nama_portofolio }}</div>
                                <div class="text-gray-500 text-sm">
                                    {{ $item->deskripsi_portofolio ?? 'Tidak ada deskripsi' }}
                                </div>
                            </div>
                            <div class="flex gap-2">
                                {{-- Hanya pemilik yang bisa edit --}}
                                @if ($item->id_pengguna == auth()->id())
                                    <a href="{{ route('portofolio.edit', $item->id_portofolio) }}"
                                        class="text-blue-600 hover:underline text-sm">Edit</a>
                                @else
                                    {{-- Yang bukan pemilik hanya bisa lihat --}}
                                    <a href="{{ route('portofolio.show', $item->id_portofolio) }}"
                                        class="text-blue-600 hover:underline text-sm">Lihat</a>
                                @endif
                                {{-- Hanya pemilik yang bisa hapus --}}
                                @if ($item->id_pengguna == auth()->id())
                                    <form action="{{ route('portofolio.destroy', $item->id_portofolio) }}"
                                        method="POST" onsubmit="return confirm('Yakin hapus?')">
                                        @csrf @method('DELETE')
                                        <button type="submit"
                                            class="text-red-600 hover:underline text-sm">Hapus</button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @elseif($user->role === 'dosen')
            <div class="max-w-3xl mx-auto bg-white shadow rounded-lg p-8 mb-8">
                <div class="flex gap-4 mb-6">
                    <button class="tab-btn active" onclick="showTab('pengabdian')">Pengabdian</button>
                    <button class="tab-btn" onclick="showTab('prestasi')">Prestasi</button>
                    <button class="tab-btn" onclick="showTab('sertifikasi')">Sertifikasi</button>
                </div>
                {{-- Pengabdian --}}
                <div id="tab-pengabdian" class="tab-content">
                    @if ($isOwner)
                        <a href="{{ route('pengabdian.create') }}"
                            class="mb-4 inline-block px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 text-sm transition">+
                            Tambah Pengabdian</a>
                    @endif
                    @foreach ($pengabdian as $item)
                        {{-- Tampilkan semua data yang sudah difilter di controller --}}
                        <div class="mb-4 p-4 border rounded flex justify-between items-center">
                            <div>
                                <div class="font-semibold">{{ $item->judul_pengabdian }}</div>
                                <div class="text-gray-500 text-sm">
                                    {{ $item->deskripsi_pengabdian ?? 'Tidak ada deskripsi' }}</div>
                            </div>
                            <div class="flex gap-2">
                                {{-- Hanya pemilik yang bisa edit --}}
                                @if ($item->id_pengguna == auth()->id())
                                    <a href="{{ route('pengabdian.edit', $item->id_pengabdian) }}"
                                        class="text-blue-600 hover:underline text-sm">Edit</a>
                                @else
                                    {{-- Yang bukan pemilik hanya bisa lihat --}}
                                    <a href="{{ route('pengabdian.show', $item->id_pengabdian) }}"
                                        class="text-blue-600 hover:underline text-sm">Lihat</a>
                                @endif
                                {{-- Hanya pemilik yang bisa hapus --}}
                                @if ($item->id_pengguna == auth()->id())
                                    <form action="{{ route('pengabdian.destroy', $item->id_pengabdian) }}"
                                        method="POST" onsubmit="return confirm('Yakin hapus?')">
                                        @csrf @method('DELETE')
                                        <button type="submit"
                                            class="text-red-600 hover:underline text-sm">Hapus</button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
                {{-- Prestasi --}}
                <div id="tab-prestasi" class="tab-content hidden">
                    @if ($isOwner)
                        <a href="{{ route('prestasi.create') }}"
                            class="mb-4 inline-block px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 text-sm transition">+
                            Tambah Prestasi</a>
                    @endif
                    @foreach ($prestasi as $item)
                        {{-- Tampilkan semua data yang sudah difilter di controller --}}
                        <div class="mb-4 p-4 border rounded flex justify-between items-center">
                            <div>
                                <span
                                    class="inline-block px-2 py-1 rounded text-xs {{ $item->jenis_prestasi === 'Akademik' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800' }}">
                                    {{ $item->jenis_prestasi }}
                                </span>
                                <div class="font-semibold">{{ $item->nama_prestasi }}</div>
                                <div class="text-gray-500 text-sm">{{ $item->penyelenggara ?? '-' }}</div>
                            </div>
                            <div class="flex gap-2">
                                {{-- Hanya pemilik yang bisa edit --}}
                                @if ($item->id_pengguna == auth()->id())
                                    <a href="{{ route('prestasi.edit', $item->id_prestasi) }}"
                                        class="text-blue-600 hover:underline text-sm">Edit</a>
                                @else
                                    {{-- Yang bukan pemilik hanya bisa lihat --}}
                                    <a href="{{ route('prestasi.show', $item->id_prestasi) }}"
                                        class="text-blue-600 hover:underline text-sm">Lihat</a>
                                @endif
                                {{-- Hanya pemilik yang bisa hapus --}}
                                @if ($item->id_pengguna == auth()->id())
                                    <form action="{{ route('prestasi.destroy', $item->id_prestasi) }}" method="POST"
                                        onsubmit="return confirm('Yakin hapus?')">
                                        @csrf @method('DELETE')
                                        <button type="submit"
                                            class="text-red-600 hover:underline text-sm">Hapus</button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
                {{-- Sertifikasi --}}
                <div id="tab-sertifikasi" class="tab-content hidden">
                    @if ($isOwner)
                        <a href="{{ route('sertifikasi.create') }}"
                            class="mb-4 inline-block px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 text-sm transition">+
                            Tambah Sertifikasi</a>
                    @endif
                    @foreach ($sertifikasi as $item)
                        {{-- Tampilkan semua data yang sudah difilter di controller --}}
                        <div class="mb-4 p-4 border rounded flex justify-between items-center">
                            <div>
                                <span
                                    class="inline-block px-2 py-1 rounded text-xs bg-green-100 text-green-800">Sertifikasi</span>
                                <div class="font-semibold">{{ $item->nama_sertifikasi }}</div>
                                <div class="text-gray-500 text-sm">{{ $item->lembaga_penerbit ?? '-' }}</div>
                            </div>
                            <div class="flex gap-2">
                                {{-- Hanya pemilik yang bisa edit --}}
                                @if ($item->id_pengguna == auth()->id())
                                    <a href="{{ route('sertifikasi.edit', $item->id_sertifikasi) }}"
                                        class="text-blue-600 hover:underline text-sm">Edit</a>
                                @else
                                    {{-- Yang bukan pemilik hanya bisa lihat --}}
                                    <a href="{{ route('sertifikasi.show', $item->id_sertifikasi) }}"
                                        class="text-blue-600 hover:underline text-sm">Lihat</a>
                                @endif
                                {{-- Hanya pemilik yang bisa hapus --}}
                                @if ($item->id_pengguna == auth()->id())
                                    <form action="{{ route('sertifikasi.destroy', $item->id_sertifikasi) }}"
                                        method="POST" onsubmit="return confirm('Yakin hapus?')">
                                        @csrf @method('DELETE')
                                        <button type="submit"
                                            class="text-red-600 hover:underline text-sm">Hapus</button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- Delete Account & Back to Dashboard (selalu di bawah) --}}
        <div class="max-w-3xl mx-auto mt-8 flex flex-col items-center gap-6">
            @if ($isOwner)
                <div class="w-full sm:w-auto flex flex-col items-center">
                    <div class="bg-white shadow rounded-lg p-6 w-full flex flex-col items-center">
                        <livewire:profile.delete-user-form />
                    </div>
                </div>
            @endif
            <a href="{{ route('dashboard') }}"
                class="inline-block px-6 py-3 bg-blue-600 text-white rounded hover:bg-blue-700 text-base text-center transition w-full sm:w-auto text-center">
                ← Back ke Dashboard
            </a>
        </div>
    </div>

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