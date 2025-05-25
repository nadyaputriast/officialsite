<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">{{ $oprek->nama_project }}</h3>
                    <p>{{ $oprek->deskripsi_project }}</p>

                    {{-- Flyer Informasi --}}
                    @if ($oprek->flyer_informasi)
                        <div class="mb-4">
                            <h4 class="font-bold">Flyer Informasi:</h4>
                            <img src="{{ Storage::url($oprek->flyer_informasi) }}" alt="Flyer Informasi"
                                class="rounded shadow w-full max-w-md">
                        </div>
                    @endif

                    {{-- Tautan --}}
                    <div class="mb-4">
                        <h4 class="font-bold">Tautan:</h4>
                        <a href="{{ $oprek->tautan_project }}" target="_blank" rel="noopener noreferrer"
                            class="text-blue-500 underline hover:text-blue-700">
                            Kunjungi Informasi
                        </a>
                    </div>

                    {{-- Penyelenggara --}}
                    <div class="mb-4">
                        <h4 class="font-bold">Penyelenggara:</h4>
                        @if ($oprek->penyelenggara)
                            {{ $oprek->penyelenggara }}
                        @else
                            Tidak ada informasi penyelenggara
                        @endif
                    </div>

                    {{-- Nama Penyelenggara --}}
                    <div class="mb-4">
                        <h4 class="font-bold">Nama Penyelenggara:</h4>
                        @if ($oprek->nama_penyelenggara)
                            {{ $oprek->nama_penyelenggara }}
                        @else
                            Tidak ada informasi nama penyelenggara
                        @endif
                    </div>

                    {{-- Kualifikasi --}}
                    @if ($oprek->kualifikasi->isNotEmpty())
                        <div class="mb-4">
                            <h4 class="font-bold">Kualifikasi:</h4>
                            <ul>
                                @foreach ($oprek->kualifikasi as $kualifikasi)
                                    <li>{{ $kualifikasi->kualifikasi_oprek }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- Output Project --}}
                    <div class="mb-4">
                        <h4 class="font-bold">Output Project:</h4>
                        <p>{{ $oprek->output_project }}</p>
                    </div>

                    {{-- Kategori --}}
                    <div class="mb-4">
                        <h4 class="font-bold">Kategori:</h4>
                        <p>{{ $oprek->kategori_project }}</p>
                    </div>

                    {{-- Status Validasi --}}
                    <div class="mb-4">
                        <h4 class="font-bold">Status Validasi:</h4>
                        <p>
                            @if ($oprek->status_project == 1)
                                <span class="text-green-500">Sudah Divalidasi</span>
                            @else
                                <span class="text-red-500">Belum Divalidasi</span>
                            @endif
                        </p>
                    </div>

                    {{-- Komentar/Validasi Admin --}}
                    @php
                        $notif = \App\Models\Notifikasi::where('notifiable_id', $oprek->id_oprek)
                            ->where('notifiable_type', 'oprek_loker_project')
                            ->latest()
                            ->first();
                    @endphp

                    <div class="mb-4">
                        <h4 class="font-bold">Komentar/Validasi Admin:</h4>
                        @if ($oprek->status_project == 1)
                            {{-- Sudah divalidasi, tampilkan strip --}}
                            <span>-</span>
                        @else
                            @if (auth()->user()->hasRole('admin'))
                                <form action="{{ route('oprek.komentar', $oprek->id_oprek) }}" method="POST"
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
                    @if (auth()->user()->hasRole('admin') && $oprek->status_project == 0)
                        <form action="{{ route('oprek.validate', $oprek->id_oprek) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="px-4 py-2 bg-green-500 text-black rounded hover:bg-green-600">
                                Validasi
                            </button>
                        </form>
                    @endif

                    {{-- Tombol Edit --}}
                    @if (auth()->id() === $oprek->id_pengguna)
                        <a href="{{ route('oprek.edit', $oprek->id_oprek) }}"
                            class="px-4 py-2 bg-blue-500 text-black rounded hover:bg-blue-600">
                            Edit Oprek
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
