<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">{{ $portofolio->nama_portofolio }}</h3>
                    <p>{{ $portofolio->deskripsi_portofolio }}</p>

                    {{-- Gambar --}}
                    @if ($portofolio->gambar->isNotEmpty())
                        <div class="mb-4">
                            <h4 class="font-bold">Gambar:</h4>
                            <div class="grid grid-cols-3 gap-4">
                                @foreach ($portofolio->gambar as $gambar)
                                    <img src="{{ Storage::url($gambar->gambar_portofolio) }}" alt="Gambar Portofolio"
                                        class="rounded shadow">
                                @endforeach
                            </div>
                        </div>
                    @endif

                    {{-- Tautan --}}
                    <div class="mb-4">
                        <h4 class="font-bold">Tautan:</h4>
                        <a href="{{ $portofolio->tautan_portofolio }}" target="_blank" rel="noopener noreferrer"
                            class="text-blue-500 underline hover:text-blue-700">
                            Kunjungi Proyek
                        </a>
                    </div>

                    {{-- Pembuat --}}
                    <div class="mb-4">
                        <h4 class="font-bold">Pembuat</h4>
                        @php
                            $allUsers = collect();
                            if ($portofolio->owner) {
                                $allUsers->push($portofolio->owner->nama_pengguna); // Tambahkan owner
                            }
                            if ($portofolio->taggedUsers->isNotEmpty()) {
                                $allUsers = $allUsers->merge($portofolio->taggedUsers->pluck('nama_pengguna')); // Gabungkan dengan taggedUsers
                            }
                        @endphp

                        @if ($allUsers->isNotEmpty())
                            {{ $allUsers->join(', ', ' dan ') }}
                        @else
                            Tidak ada pengguna terkait
                        @endif
                    </div>

                    {{-- Kategori --}}
                    @if ($portofolio->kategoris->isNotEmpty())
                        <div class="mb-4">
                            <h4 class="font-bold">Kategori:</h4>
                            <ul>
                                @foreach ($portofolio->kategoris as $kategori)
                                    <li>{{ $kategori->kategori_portofolio }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- Tombol Edit --}}
                    @if (auth()->id() === $portofolio->id_pengguna)
                        <a href="{{ route('portofolio.edit', $portofolio->id_portofolio) }}"
                            class="px-4 py-2 bg-blue-500 text-black rounded hover:bg-blue-600">
                            Edit Portofolio
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