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
                                $allUsers->push($pengabdian->owner->nama_pengguna); // Tambahkan owner
                            }
                            if ($pengabdian->taggedUsers->isNotEmpty()) {
                                $allUsers = $allUsers->merge($pengabdian->taggedUsers->pluck('nama_pengguna')); // Gabungkan dengan taggedUsers
                            }
                        @endphp

                        @if ($allUsers->isNotEmpty())
                            {{ $allUsers->join(', ', ' dan ') }}
                        @else
                            Tidak ada pengguna terkait
                        @endif
                    </div>

                    {{-- Validasi Admin --}}
                    @if (auth()->user()->hasRole('admin') && $pengabdian->status_pengabdian == 0)
                        <form action="{{ route('pengabdian.validate', $pengabdian->id_pengabdian) }}" method="POST" class="inline">
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