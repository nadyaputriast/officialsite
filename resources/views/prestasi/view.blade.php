<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Prestasi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    {{-- Nama Prestasi --}}
                    <div class="mb-4">
                        <h3 class="text-lg font-semibold">Nama Prestasi</h3>
                        <p>{{ $prestasi->nama_prestasi }}</p>
                    </div>

                    {{-- Deskripsi --}}
                    <div class="mb-4">
                        <h3 class="text-lg font-semibold">Deskripsi</h3>
                        <p>{{ $prestasi->deskripsi_prestasi }}</p>
                    </div>

                    {{-- Tanggal Perolehan --}}
                    <div class="mb-4">
                        <h3 class="text-lg font-semibold">Tanggal Perolehan</h3>
                        <p>{{ $prestasi->tanggal_perolehan }}</p>
                    </div>

                    {{-- Tingkatan Prestasi --}}
                    <div class="mb-4">
                        <h3 class="text-lg font-semibold">Tingkatan Prestasi</h3>
                        <p>{{ $prestasi->tingkatan_prestasi }}</p>
                    </div>

                    {{-- Jenis Prestasi --}}
                    <div class="mb-4">
                        <h3 class="text-lg font-semibold">Jenis Prestasi</h3>
                        <p>{{ $prestasi->jenis_prestasi }}</p>
                    </div>

                    {{-- Dokumentasi Prestasi --}}
                    <div class="mb-4">
                        <h3 class="text-lg font-semibold">Dokumentasi Prestasi</h3>
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
                    <div class="mb-4">
                        <h4 class="font-bold">Peraih</h4>
                        @php
                            $allUsers = collect();
                            if ($prestasi->owner) {
                                $allUsers->push($prestasi->owner->nama_pengguna); // Tambahkan owner
                            }
                            if ($prestasi->taggedUsers->isNotEmpty()) {
                                $allUsers = $allUsers->merge($prestasi->taggedUsers->pluck('nama_pengguna')); // Gabungkan dengan taggedUsers
                            }
                        @endphp

                        @if ($allUsers->isNotEmpty())
                            {{ $allUsers->join(', ', ' dan ') }}
                        @else
                            Tidak ada pengguna terkait
                        @endif
                    </div>

                    {{-- Validasi Admin --}}
                    @if (auth()->user()->hasRole('admin') && $prestasi->status_prestasi == 0)
                        <form action="{{ route('prestasi.validate', $prestasi->id_prestasi) }}" method="POST"
                            class="inline">
                            @csrf
                            <button type="submit" class="px-4 py-2 bg-green-500 text-black rounded hover:bg-green-600">
                                Validasi
                            </button>
                        </form>
                    @endif

                    {{-- Tombol Edit --}}
                    @if (auth()->id() === $prestasi->id_pengguna)
                        <a href="{{ route('prestasi.edit', $prestasi->id_prestasi) }}"
                            class="px-4 py-2 bg-blue-500 text-black rounded hover:bg-blue-600">
                            Edit Prestasi
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
