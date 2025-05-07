<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">Detail Event</h3>
                    <div class="mb-4">
                        <strong>Nama Event:</strong> {{ $event->nama_event }}
                    </div>
                    <div class="mb-4">
                        <strong>Jenis Event:</strong> {{ $event->jenis_event }}
                    </div>
                    <div class="mb-4">
                        <strong>Deskripsi:</strong> {{ $event->deskripsi_event }}
                    </div>
                    <div class="mb-4">
                        <strong>Tanggal Event:</strong> {{ $event->tanggal_event }}
                    </div>
                    <div class="mb-4">
                        <strong>Waktu Event:</strong> {{ $event->waktu_event }}
                    </div>
                    <div class="mb-4">
                        <strong>Penyelenggara:</strong> {{ $event->penyelenggara_event }}
                    </div>
                    <div class="mb-4">
                        <strong>Nama Penyelenggara:</strong> {{ $event->nama_penyelenggara }}
                    </div>
                    @if ($event->penyelenggara_event === 'eksternal')
                        <div class="mb-4">
                            <strong>Tautan Event:</strong> <a
                                href="{{ $event->tautan_event }}">{{ $event->tautan_event }}</a>
                        </div>
                    @endif
                    <div class="mb-4">
                        <strong>Harga Event:</strong> {{ $event->harga_event }}
                    </div>
                    @if ($event->penyelenggara_event === 'internal')
                        <div class="mb-4">
                            <strong>Kuota Event:</strong> {{ $event->kuota_event }}
                        </div>
                        @if ($event->promo)
                            <div class="mb-4">
                                <strong>Kode Promo:</strong> {{ $event->promo->kode_promo }}
                            </div>
                            <div class="mb-4">
                                <strong>Jenis Promo:</strong> {{ $event->promo->jenis_promo }}
                            </div>
                            <div class="mb-4">
                                <strong>Nilai Promo:</strong> {{ $event->promo->nilai_promo }}
                            </div>
                            <div class="mb-4">
                                <strong>Masa Berlaku Promo:</strong> {{ $event->promo->tanggal_mulai }} -
                                {{ $event->promo->tanggal_berakhir }}
                            </div>
                        @endif
                    @endif
                    <div class="mb-4">
                        <strong>Thumbnail:</strong> <img src="{{ asset('storage/' . $event->thumbnail_event) }}"
                            alt="Thumbnail" class="w-32 h-32">
                    </div>
                    
                    {{-- Status Validasi --}}
                    <div class="mb-4">
                        <h4 class="font-bold">Status Validasi:</h4>
                        <p>
                            @if ($event->status_event == 1)
                                <span class="text-green-500">Sudah Divalidasi</span>
                            @else
                                <span class="text-red-500">Belum Divalidasi</span>
                            @endif
                        </p>
                    </div>

                    {{-- Validasi Admin --}}
                    @if (auth()->user()->hasRole('admin') && $event->status_event == 0)
                        <form action="{{ route('event.validate', $event->id_event) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="px-4 py-2 bg-green-500 text-black rounded hover:bg-green-600">
                                Validasi
                            </button>
                        </form>
                    @endif

                    {{-- Tombol Edit --}}
                    @if (auth()->id() === $event->id_pengguna)
                        <a href="{{ route('event.edit', $event->id_event) }}"
                            class="px-4 py-2 bg-blue-500 text-black rounded hover:bg-blue-600">
                            Edit Event
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
