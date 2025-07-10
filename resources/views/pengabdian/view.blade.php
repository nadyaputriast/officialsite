<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Pengabdian') }}
        </h2>
    </x-slot>
    
    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-xl">
                <div class="p-8">
                    {{-- Header Section --}}
                    <div class="border-b border-gray-200 pb-6 mb-8">
                        <h3 class="text-2xl font-bold text-gray-900">{{ $pengabdian->judul_pengabdian }}</h3>
                        <p class="mt-2 text-sm text-gray-600">{{ $pengabdian->deskripsi_pengabdian }}</p>
                    </div>

                    {{-- Tanggal Pengabdian --}}
                    <div class="bg-gray-50 rounded-lg p-6 w-full mb-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-2">Tanggal Pengabdian</h3>
                        <p class="text-gray-700">{{ $pengabdian->tanggal_pengabdian }}</p>
                    </div>

                    {{-- Pelaksana --}}
                    <div class="bg-gray-50 rounded-lg p-6 w-full mb-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-2">Pelaksana</h3>
                        <p class="text-gray-700">{{ $pengabdian->pelaksana }}</p>
                    </div>

                    {{-- Dokumentasi Pengabdian --}}
                    <div class="bg-gray-50 rounded-lg p-6 w-full mb-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Dokumentasi Pengabdian</h3>
                        @if ($pengabdian->dokumentasi->isNotEmpty())
                            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                                @foreach ($pengabdian->dokumentasi as $dokumentasi)
                                    <div class="border rounded p-2">
                                        <img src="{{ asset('storage/' . $dokumentasi->dokumentasi_pengabdian) }}" alt="Dokumentasi Pengabdian" class="w-full h-32 object-cover rounded">
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-500 italic">Tidak ada dokumentasi yang tersedia.</p>
                        @endif
                    </div>

                    {{-- Peserta Pengabdian --}}
                    <div class="bg-gray-50 rounded-lg p-6 w-full mb-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-2">Peserta Pengabdian</h3>
                        @php
                            $allUsers = collect();
                            if ($pengabdian->owner) {
                                $allUsers->push([
                                    'nama' => $pengabdian->owner->nama_pengguna,
                                    'id' => $pengabdian->owner->id_pengguna,
                                ]);
                            }
                            if ($pengabdian->taggedUsers->isNotEmpty()) {
                                foreach ($pengabdian->taggedUsers as $tagged) {
                                    $allUsers->push([
                                        'nama' => $tagged->nama_pengguna,
                                        'id' => $tagged->id_pengguna,
                                    ]);
                                }
                            }
                        @endphp

                        @if ($allUsers->isNotEmpty())
                            @foreach ($allUsers as $i => $user)
                                <a href="{{ route('profile.user', $user['id']) }}" class="text-blue-600 hover:underline">{{ $user['nama'] }}</a>
                                @if ($i < $allUsers->count() - 2)
                                    ,
                                @elseif ($i == $allUsers->count() - 2)
                                    dan
                                @endif
                            @endforeach
                        @else
                            <p class="text-gray-500">Tidak ada pengguna terkait.</p>
                        @endif
                    </div>

                    {{-- Status Validasi --}}
                    <div class="bg-gray-50 rounded-lg p-6 w-full mb-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-2">Status Validasi</h3>
                        <p>
                            @if ($pengabdian->status_pengabdian == 1)
                                <span class="text-green-500 font-medium">Sudah Divalidasi</span>
                            @else
                                <span class="text-red-500 font-medium">Belum Divalidasi</span>
                            @endif
                        </p>
                    </div>

                    {{-- Komentar/Validasi Admin --}}
                    @php
                        $notif = \App\Models\Notifikasi::where('notifiable_id', $pengabdian->id_pengabdian)
                            ->where('notifiable_type', 'pengabdian')
                            ->latest()
                            ->first();
                    @endphp

                    <div class="bg-amber-50 border border-amber-200 rounded-lg p-6 w-full mb-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-3">Komentar/Validasi Admin</h3>
                        @if ($pengabdian->status_pengabdian == 1)
                            <span>-</span>
                        @else
                            @if (auth()->user()->hasRole('admin'))
                                <form action="{{ route('pengabdian.komentar', $pengabdian->id_pengabdian) }}" method="POST" class="mb-2">
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
                                    <form action="{{ route('notifikasi.read', $notif->id_notifikasi) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="text-sm text-blue-600">Tandai sudah dibaca</button>
                                    </form>
                                @else
                                    <span class="text-sm text-green-600">Sudah dibaca</span>
                                @endif
                            @endif
                        @endif
                    </div>

                    {{-- Validasi Admin & Tombol Aksi --}}
                    <div class="mt-8 pt-6 flex flex-wrap justify-end gap-3">
                        @if (auth()->user()->hasRole('admin') && $pengabdian->status_pengabdian == 0)
                            <form action="{{ route('admin.pengabdian.validate', $pengabdian->id_pengabdian) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600">
                                    Validasi
                                </button>
                            </form>
                        @endif

                        <a href="{{ route('dashboard') }}" class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                            Kembali
                        </a>

                        @if (auth()->id() === $pengabdian->id_pengguna)
                            <a href="{{ route('pengabdian.edit', $pengabdian->id_pengabdian) }}" class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-[#4B83BF] hover:bg-[#5a93c7] focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                Edit Pengabdian
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>