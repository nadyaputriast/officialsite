<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">{{ $portofolio->nama_portofolio }}</h3>
                    <p>{{ $portofolio->deskripsi_portofolio }}</p>

                    {{-- Gambar --}}
                    @if ($portofolio->gambar->isNotEmpty())
                        <div class="mb-6">
                            <h4 class="font-semibold text-lg mb-3">Gambar Portofolio:</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                @foreach ($portofolio->gambar as $gambar)
                                    <div class="overflow-hidden rounded-lg shadow hover:shadow-md transition-shadow">
                                        <img src="{{ asset('storage/' . $gambar->gambar_portofolio) }}"
                                            alt="Gambar Portofolio" class="w-full h-48 object-cover">
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    {{-- Tautan --}}
                    @if ($portofolio->tautan->isNotEmpty())
                        <div class="mb-4">
                            <h4 class="font-bold">Tautan:</h4>
                            <ul class="list-disc pl-5">
                                @foreach ($portofolio->tautan as $tautan)
                                    <li>
                                        <a href="{{ $tautan->tautan_portofolio }}" target="_blank"
                                            rel="noopener noreferrer"
                                            class="text-blue-500 underline hover:text-blue-700">
                                            {{ $tautan->tautan_portofolio }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- Tools --}}
                    @if ($portofolio->tools->isNotEmpty())
                        <div class="mb-4">
                            <h4 class="font-bold">Tools:</h4>
                            <ul class="list-disc pl-5">
                                @foreach ($portofolio->tools as $tool)
                                    <li>{{ $tool->tools_portofolio }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

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
                    @if ($portofolio->kategori->isNotEmpty())
                        <div class="mb-4">
                            <h4 class="font-bold">Kategori:</h4>
                            <ul>
                                @foreach ($portofolio->kategori as $kategori)
                                    <li>{{ $kategori->kategori_portofolio }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- Dokumen --}}
                    @if (!empty($portofolio->dokumen_portofolio))
                        <div class="mb-4">
                            <h4 class="font-bold">Dokumen:</h4>
                            <a href="{{ asset('storage/' . $portofolio->dokumen_portofolio) }}" target="_blank"
                                class="text-blue-500 underline hover:text-blue-700">
                                Lihat Dokumen
                            </a>
                        </div>
                    @else
                        <p>Dokumen tidak tersedia.</p>
                    @endif

                    {{-- Statistik --}}
                    <div class="mb-4">
                        <strong>Jumlah Dilihat:</strong> {{ $portofolio->view_count }} <br>
                        <strong>Jumlah Suka:</strong> {{ $portofolio->banyak_upvote }} <br>
                        <strong>Jumlah Tidak Suka:</strong> {{ $portofolio->banyak_downvote }}
                    </div>

                    {{-- Tombol Vote --}}
                    @php
                        $userVote = $portofolio->votes->where('id_pengguna', auth()->id())->first();
                    @endphp
                    <div class="flex space-x-4">
                        <form action="{{ route('portofolio.upvote', $portofolio->id_portofolio) }}" method="POST">
                            @csrf
                            <button type="submit"
                                class="px-4 py-2 rounded hover:bg-green-600
                                {{ $userVote && $userVote->jenis_vote === 'upvote' ? 'bg-green-500 text-white' : 'bg-gray-300 text-black' }}"
                                {{ $userVote ? 'disabled' : '' }}>
                                👍
                            </button>
                        </form>
                        <form action="{{ route('portofolio.downvote', $portofolio->id_portofolio) }}" method="POST">
                            @csrf
                            <button type="submit"
                                class="px-4 py-2 rounded hover:bg-red-600
                                {{ $userVote && $userVote->jenis_vote === 'downvote' ? 'bg-red-500 text-white' : 'bg-gray-300 text-black' }}"
                                {{ $userVote ? 'disabled' : '' }}>
                                👎
                            </button>
                        </form>
                    </div>

                    {{-- Komentar --}}
                    <div class="mt-8">
                        <h3 class="text-lg font-semibold mb-4">Komentar</h3>

                        {{-- Form Komentar --}}
                        @include('portofolio.komentar.form')

                        {{-- Daftar Komentar --}}
                        @include('portofolio.komentar.list')
                    </div>
                    {{-- Validasi Admin --}}
                    @if (auth()->user()->hasRole('admin') && $portofolio->status_portofolio == 0)
                        <form action="{{ route('portofolio.validate', $portofolio->id_portofolio) }}" method="POST"
                            class="inline">
                            @csrf
                            <button type="submit" class="px-4 py-2 bg-green-500 text-black rounded hover:bg-green-600">
                                Validasi
                            </button>
                        </form>
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
