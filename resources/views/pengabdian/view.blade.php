<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Pengabdian') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    {{-- Judul Kegiatan Pengabdian --}}
                    <div class="mb-4">
                        <h3 class="text-lg font-semibold">Judul Kegiatan</h3>
                        <p>{{ $pengabdian->judul_pengabdian }}</p>
                    </div>

                    {{-- Deskripsi --}}
                    <div class="mb-4">
                        <h3 class="text-lg font-semibold">Deskripsi</h3>
                        <p>{{ $pengabdian->deskripsi_pengabdian }}</p>
                    </div>

                    {{-- Tanggal Pengabdian --}}
                    <div class="mb-4">
                        <h3 class="text-lg font-semibold">Tanggal Pengabdian</h3>
                        <p>{{ $pengabdian->tanggal_pengabdian }}</p>
                    </div>

					{{-- Pelaksana --}}
					<div class="mb-4">
                        <h3 class="text-lg font-semibold">Pelaksana</h3>
                        <p>{{ $pengabdian->pelaksana }}</p>
                    </div>

                    {{-- Dokumentasi Pengabdian --}}
                    <div class="mb-4">
                        <h3 class="text-lg font-semibold">Dokumentasi Pengabdian</h3>
                        @if ($pengabdian->dokumentasi->isNotEmpty())
                            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                                @foreach ($pengabdian->dokumentasi as $dokumentasi)
                                    <div class="border rounded p-2">
                                        <img src="{{ asset('storage/' . $dokumentasi->dokumentasi_pengabdian) }}" alt="Dokumentasi Pengabdian"
                                            class="w-full h-32 object-cover rounded">
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-500 italic">Tidak ada dokumentasi yang tersedia.</p>
                        @endif
                    </div>

                    {{-- Yang mengikuti pengabdian --}}
                    <div class="mb-4">
                        <h4 class="font-bold">Peserta Pengabdian</h4>
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
                            Tidak ada pengguna terkait
                        @endif
                    </div>

                    {{-- Status Validasi --}}
                    <div class="mb-4">
                        <h4 class="font-bold">Status Validasi:</h4>
                        <p>
                            @if ($pengabdian->status_pengabdian == 1)
                                <span class="text-green-500">Sudah Divalidasi</span>
                            @else
                                <span class="text-red-500">Belum Divalidasi</span>
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

                    <div class="mb-4">
                        <h4 class="font-bold">Komentar/Validasi Admin:</h4>
                        @if ($pengabdian->status_pengabdian == 1)
                            {{-- Sudah divalidasi, tampilkan strip --}}
                            <span>-</span>
                        @else
                            @if (auth()->user()->hasRole('admin'))
                                <form action="{{ route('pengabdian.komentar', $pengabdian->id_pengabdian) }}" method="POST"
                                    class="mb-2">
                                    @csrf
                                    <textarea name="isi_notifikasi" class="w-full border rounded p-2 mb-2" required>{{ $notif->isi_notifikasi ?? '' }}</textarea>
                                    <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded">
                                        {{ $notif ? 'Ubah Komentar' : 'Tambah Komentar' }}
                                    </button>
                                </form>
                                @if ($notif && $notif->is_read)
                                    <div class="text-xs text-green-600 mb-2">Komentar sudah dibaca oleh user, Anda bisa
                                        mengubah komentar.</div>
                                @elseif($notif)
                                    <div class="text-xs text-yellow-600 mb-2">Komentar belum dibaca oleh user.</div>
                                @endif
                            @elseif($notif)
                                <div class="bg-gray-100 border-l-4 border-blue-400 p-3 mb-2">
                                    {{ $notif->isi_notifikasi }}
                                </div>
                                @if (!$notif->is_read)
                                    <form action="{{ route('notifikasi.read', $notif->id_notifikasi) }}" method="POST"
                                        class="inline">
                                        @csrf
                                        <button type="submit" class="text-xs text-blue-600 ml-2">Tandai sudah
                                            dibaca</button>
                                    </form>
                                @else
                                    <span class="text-xs text-green-600">Sudah dibaca</span>
                                @endif
                            @endif
                        @endif
                    </div>
                    
                    {{-- Validasi Admin --}}
                    @if (auth()->user()->hasRole('admin') && $pengabdian->status_pengabdian == 0)
                        <form action="{{ route('admin.pengabdian.validate', $pengabdian->id_pengabdian) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="px-4 py-2 bg-green-500 text-black rounded hover:bg-green-600">
                                Validasi
                            </button>
                        </form>
                    @endif
                    
                    {{-- Tombol Edit --}}
                    @if (auth()->id() === $pengabdian->id_pengguna)
                        <a href="{{ route('pengabdian.edit', $pengabdian->id_pengabdian) }}"
                            class="px-4 py-2 bg-blue-500 text-black rounded hover:bg-blue-600">
                            Edit Pengabdian
                        </a>
                    @endif

                    {{-- Tombol Kembali --}}
                    <a href="{{ route('dashboard') }}"
                        class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">Kembali</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>