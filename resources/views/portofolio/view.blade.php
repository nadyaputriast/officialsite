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
                                $allUsers->push([
                                    'nama' => $portofolio->owner->nama_pengguna,
                                    'id' => $portofolio->owner->id_pengguna,
                                ]);
                            }
                            if ($portofolio->taggedUsers->isNotEmpty()) {
                                foreach ($portofolio->taggedUsers as $tagged) {
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

                    {{-- Kategori --}}
                    @if ($portofolio->kategori->isNotEmpty())
                        <div class="mb-4">
                            <h4 class="font-bold mb-2 flex items-center gap-2">Kategori:</h4>
                            <div class="flex flex-wrap gap-2">
                                @foreach ($portofolio->kategori as $kategori)
                                    <a href="{{ route('portofolio.index', ['kategori' => $kategori->kategori_portofolio]) }}"
                                        class="inline-flex items-center gap-1 px-3 py-1 bg-blue-100 text-blue-800 text-sm rounded-full hover:bg-blue-200 hover:text-blue-900 transition font-medium">
                                        {{ $kategori->kategori_portofolio }}
                                    </a>
                                @endforeach
                            </div>
                            <div class="text-xs text-gray-500 mt-1">
                                Klik kategori untuk melihat portofolio serupa
                            </div>
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

                    {{-- Status Validasi --}}
                    <div class="mb-4">
                        <h4 class="font-bold">Status Validasi:</h4>
                        <p>
                            @if ($portofolio->status_portofolio == 1)
                                <span class="text-green-500">Sudah Divalidasi</span>
                            @else
                                <span class="text-red-500">Belum Divalidasi</span>
                            @endif
                        </p>
                    </div>

                    {{-- Komentar/Validasi Admin --}}
                    @php
                        $notif = \App\Models\Notifikasi::where('notifiable_id', $portofolio->id_portofolio)
                            ->where('notifiable_type', 'portofolio')
                            ->latest()
                            ->first();
                    @endphp

                    <div class="mb-4">
                        <h4 class="font-bold">Komentar/Validasi Admin:</h4>
                        @if ($portofolio->status_portofolio == 1)
                            {{-- Sudah divalidasi, tampilkan strip --}}
                            <span>-</span>
                        @else
                            @if (auth()->user()->hasRole('admin'))
                                <form action="{{ route('portofolio.komentar', $portofolio->id_portofolio) }}"
                                    method="POST" class="mb-2">
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
                    @if (auth()->user()->hasRole('admin') && $portofolio->status_portofolio == 0)
                        <form action="{{ route('admin.portofolio.validate', $portofolio->id_portofolio) }}" method="POST"
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
