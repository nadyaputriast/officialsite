<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Prestasi') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-xl">
                <div class="p-8">
                    {{-- Nama Prestasi --}}
                    <div class="border-b border-gray-200 pb-6 mb-8">
                        <h1 class="text-2xl font-bold text-gray-900">{{ $prestasi->nama_prestasi }}</h1>
                        <p class="tmt-2 text-sm text-gray-600">{{ $prestasi->deskripsi_prestasi }}</p>
                    </div>

                    {{-- Tanggal Perolehan --}}
                    <div class="bg-gray-50 rounded-lg p-6 w-full mb-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-2">Tanggal Perolehan</h3>
                        <p class="text-gray-700">{{ $prestasi->tanggal_perolehan }}</p>
                    </div>

                    {{-- Tingkatan Prestasi --}}
                    <div class="bg-gray-50 rounded-lg p-6 w-full mb-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-2">Tingkatan Prestasi</h3>
                        <p class="text-gray-700">{{ $prestasi->tingkatan_prestasi }}</p>
                    </div>

                    {{-- Jenis Prestasi --}}
                    <div class="bg-gray-50 rounded-lg p-6 w-full mb-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-2">Jenis Prestasi</h3>
                        <p class="text-gray-700">{{ $prestasi->jenis_prestasi }}</p>
                    </div>

                    {{-- Dokumentasi Prestasi --}}
                    <div class="bg-gray-50 rounded-lg p-6 w-full mb-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-2">Dokumentasi Prestasi</h3>
                        @if ($prestasi->dokumentasi->isNotEmpty())
                            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                                @foreach ($prestasi->dokumentasi as $dokumentasi)
                                    <div class="border rounded p-2">
                                        <img src="{{ asset('storage/' . $dokumentasi->dokumentasi_prestasi) }}"
                                            alt="Dokumentasi Prestasi" class="w-full h-32 object-cover rounded">
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-500 italic">Tidak ada dokumentasi yang tersedia.</p>
                        @endif
                    </div>

                    {{-- Peraih Prestasi --}}
                    <div class="bg-gray-50 rounded-lg p-6 w-full mb-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-2">Peraih Prestasi</h3>
                        @php
                            $allUsers = collect();
                            if ($prestasi->owner) {
                                $allUsers->push([
                                    'nama' => $prestasi->owner->nama_pengguna,
                                    'id' => $prestasi->owner->id_pengguna,
                                ]);
                            }
                            if ($prestasi->taggedUsers->isNotEmpty()) {
                                foreach ($prestasi->taggedUsers as $tagged) {
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

                    {{-- Status Validasi --}}
                    <div class="bg-gray-50 rounded-lg p-6 w-full mb-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-2">Status Validasi</h3>
                        <p>
                            @if ($prestasi->status_prestasi == 1)
                                <span class="text-green-500 font-medium">Sudah Divalidasi</span>
                            @else
                                <span class="text-red-500 font-medium">Belum Divalidasi</span>
                            @endif
                        </p>
                    </div>

                    {{-- Komentar/Validasi Admin --}}
                    @php
                        $notif = \App\Models\Notifikasi::where('notifiable_id', $prestasi->id_prestasi)
                            ->where('notifiable_type', 'prestasi')
                            ->latest()
                            ->first();
                    @endphp

                    <div class="bg-amber-50 border border-amber-200 rounded-lg p-6 w-full mb-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-3">Komentar/Validasi Admin</h3>
                        @if ($prestasi->status_prestasi == 1)
                            <span>-</span>
                        @else
                            @if (auth()->user()->hasRole('admin'))
                                <form action="{{ route('prestasi.komentar', $prestasi->id_prestasi) }}" method="POST"
                                    class="mb-2">
                                    @csrf
                                    <textarea name="isi_notifikasi" class="w-full border rounded p-2 mb-2" required>{{ $notif->isi_notifikasi ?? '' }}</textarea>
                                    <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                                        {{ $notif ? 'Ubah Komentar' : 'Tambah Komentar' }}
                                    </button>
                                </form>
                                @if ($notif && $notif->is_read)
                                    <div class="text-sm text-green-600">Komentar sudah dibaca oleh user.</div>
                                @elseif($notif)
                                    <div class="text-sm text-yellow-600">Komentar belum dibaca oleh user.</div>
                                @endif
                            @elseif($notif)
                                <div class="bg-white border-l-4 border-blue-400 p-3 mb-2 text-gray-700">
                                    {{ $notif->isi_notifikasi }}
                                </div>
                                @if (!$notif->is_read)
                                    <form action="{{ route('notifikasi.read', $notif->id_notifikasi) }}" method="POST"
                                        class="inline">
                                        @csrf
                                        <button type="submit" class="text-sm text-blue-600">Tandai sudah dibaca</button>
                                    </form>
                                @else
                                    <span class="text-sm text-green-600">Sudah dibaca</span>
                                @endif
                            @endif
                        @endif
                    </div>

                    {{-- Validasi & Aksi --}}
                    <div class="mt-8 pt-6 flex flex-wrap justify-end gap-3">
                        @if (auth()->user()->hasRole('admin') && $prestasi->status_prestasi == 0)
                            <form action="{{ route('admin.prestasi.validate', $prestasi->id_prestasi) }}" method="POST"
                                class="inline">
                                @csrf
                                <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600">
                                    Validasi
                                </button>
                            </form>
                        @endif

                        <a href="{{ route('dashboard') }}"
                            class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                            Kembali
                        </a>

                        @if (auth()->id() === $prestasi->id_pengguna)
                            <a href="{{ route('prestasi.edit', $prestasi->id_prestasi) }}"
                                class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-[#4B83BF] hover:bg-[#5a93c7] focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                Edit Prestasi
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
