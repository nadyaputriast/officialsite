<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Sertifikasi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    {{-- Nama Sertifikasi --}}
                    <div class="mb-4">
                        <h4 class="font-bold">Nama Sertifikasi</h4>
                        <p>{{ $sertifikasi->nama_sertifikasi }}</p>
                    </div>

                    {{-- Deskripsi --}}
                    <div class="mb-4">
                        <h4 class="font-bold">Deskripsi</h4>
                        <p>{{ $sertifikasi->deskripsi_sertifikasi }}</p>
                    </div>

                    {{-- Tanggal Sertifikasi --}}
                    <div class="mb-4">
                        <h4 class="font-bold">Tanggal Sertifikasi</h4>
                        <p>{{ $sertifikasi->tanggal_sertifikasi }}</p>
                    </div>

                    {{-- Penyelenggara --}}
                    <div class="mb-4">
                        <h4 class="font-bold">Penyelenggara</h4>
                        <p>{{ $sertifikasi->penyelenggara }}</p>
                    </div>

                    {{-- Masa Berlaku --}}
                    <div class="mb-4">
                        <h4 class="font-bold">Masa Berlaku</h4>
                        <p>
                            @if ($sertifikasi->masa_berlaku == 0)
                                Seumur Hidup
                            @else
                                {{ $sertifikasi->masa_berlaku }} Tahun
                            @endif
                        </p>
                    </div>

                    {{-- File Sertifikasi --}}
                    <div class="mb-4">
                        <h4 class="font-bold">File Sertifikasi</h4>
                        <a href="{{ asset('storage/' . $sertifikasi->file_sertifikasi) }}" target="_blank"
                            class="text-blue-500 hover:underline">Lihat File</a>
                    </div>

                    {{-- Status Validasi --}}
                    <div class="mb-4">
                        <h4 class="font-bold">Status Validasi:</h4>
                        <p>
                            @if ($sertifikasi->status_sertifikasi == 1)
                                <span class="text-green-500">Sudah Divalidasi</span>
                            @else
                                <span class="text-red-500">Belum Divalidasi</span>
                            @endif
                        </p>
                    </div>

                    {{-- Komentar/Validasi Admin --}}
                    @php
                        $notif = \App\Models\Notifikasi::where('notifiable_id', $sertifikasi->id_sertifikasi)
                            ->where('notifiable_type', 'sertifikasi')
                            ->latest()
                            ->first();
                    @endphp

                    <div class="mb-4">
                        <h4 class="font-bold">Komentar/Validasi Admin:</h4>
                        @if ($sertifikasi->status_sertifikasi == 1)
                            {{-- Sudah divalidasi, tampilkan strip --}}
                            <span>-</span>
                        @else
                            @if (auth()->user()->hasRole('admin'))
                                <form action="{{ route('sertifikasi.komentar', $sertifikasi->id_sertifikasi) }}" method="POST"
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
                    @if (auth()->user()->hasRole('admin') && $sertifikasi->status_sertifikasi == 0)
                        <form action="{{ route('admin.sertifikasi.validate', $sertifikasi->id_sertifikasi) }}" method="POST"
                            class="inline">
                            @csrf
                            <button type="submit" class="px-4 py-2 bg-green-500 text-black rounded hover:bg-green-600">
                                Validasi
                            </button>
                        </form>
                    @endif

                    {{-- Tombol Edit --}}
                    @if (auth()->id() === $sertifikasi->id_pengguna)
                        <a href="{{ route('sertifikasi.edit', $sertifikasi->id_sertifikasi) }}"
                            class="px-4 py-2 bg-blue-500 text-black rounded hover:bg-blue-600">
                            Edit Sertifikasi
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
