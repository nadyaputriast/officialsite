<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Official Site - Sistem Informasi Akademik</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="//unpkg.com/alpinejs" defer></script>
    <style>
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .line-clamp-3 {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
</head>

<body class="antialiased font-sans bg-white">
    <div>
        {{-- Banner --}}
        @if (View::exists('components.banner-component'))
            <div class="w-full">
                <x-banner-component class="w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8" />
            </div>
        @else
            {{-- Komponen banner tidak ditemukan --}}
        @endif
    </div>

    {{-- Navbar --}}
    @include('dashboard.navbar')

    {{-- Hero Section --}}
    <div class="max-w-7xl mx-auto flex flex-col md:flex-row items-center px-6 space-y-6 md:space-y-0 md:space-x-12">
        <div class="md:w-1/2">
            <h1 class="text-shadow-lg/30 text-5xl font-bold text-black mt-6">Showcase Your Passion<br>Inspire Others
            </h1>
            <p class="mt-4 text-gray-700">
                <strong>SatuRuang</strong> adalah platform digital yang dirancang untuk mengumpulkan dan memamerkan
                karya akademik mahasiswa dalam satu ruang kolaboratif. Platform ini hadir sebagai wadah apresiasi,
                publikasi, dan pengembangan diri.
            </p>
            <div class="mt-6 space-x-4">
                @auth
                    <a href="{{ route('dashboard') }}"
                        class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Buat Profilmu</a>
                @else
                    <a href="{{ route('register') }}" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                        Buat Profilmu </a>
                @endauth
                <a href="#portofolio-section"
                    class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300">Jelajahi Proyek</a>
            </div>
        </div>
        <div class="md:w-1/2">
            <img src="{{ asset('images/hero.jpg') }}" alt="Hero"
                class="shadow-lg w-80 h-80 object-cover mt-10 mx-auto mb-8 mr-16" style="border-radius: 50%;">
        </div>
    </div>
    </div>

    <div class="space-y-12 py-12">
        {{-- KategoriStat Section --}}
        <section class="bg-gradient-to-r from-[#75AAD8] to-[#DDF1FB] py-12">
            <div class="max-w-7xl mx-auto px-4">
                <div class="grid grid-cols-5 gap-6 text-center">
                    <div class="text-center mb-8 col-span-1 row-span-2 flex flex-col justify-center">
                        <h2 class="text-3xl font-bold text-white mb-3">Kategori Proyek</h2>
                        <p class="text-white text-lg">Lihat Berbagai Kategori Proyek Informatika</p>
                    </div>
                    @foreach ($kategoriStats as $kategori)
                        <div
                            class="bg-white rounded-lg shadow rounded-xl p-6 border border-blue-200 hover:shadow-lg transition-all duration-300 hover:-translate-y-1">
                            <div class="flex flex-col items-center justify-between mb-4">
                                <div>
                                    <h3 class="font-semibold text-gray-900 mb-1">{{ $kategori['nama'] }}</h3>
                                    <p class="text-3xl font-bold text-blue-600">{{ $kategori['jumlah'] }}</p>
                                    <p class="text-sm text-gray-500">proyek</p>
                                </div>
                                <div class="text-blue-400">
                                    {{-- Icon sesuai kategori --}}
                                    @switch($kategori['nama'])
                                        @case('UI/UX Design')
                                            <img src="{{ asset('images/uiux.png') }}" alt="UI/UX Design" class="w-20 h-20">
                                        @break

                                        @case('Website Development')
                                            <img src="{{ asset('images/default.png') }}" alt="Website Development"
                                                class="w-20 h-20">
                                        @break

                                        @case('Mobile Development')
                                            <img src="{{ asset('images/mobdev.png') }}" alt="Mobile Development"
                                                class="w-20 h-20">
                                        @break

                                        @case('Game Development')
                                            <img src="{{ asset('images/webdev.png') }}" alt="Game Development"
                                                class="w-20 h-20">
                                        @break

                                        @case('Internet of Things')
                                            <img src="{{ asset('images/iot.png') }}" alt="Internet of Things"
                                                class="w-20 h-20">
                                        @break

                                        @case('ML/AI')
                                            <img src="{{ asset('images/machinelearning.png') }}" alt="Machine Learning/AI"
                                                class="w-20 h-20">
                                        @break

                                        @case('Blockchain')
                                            <img src="{{ asset('images/blockchain.png') }}" alt="Blockchain" class="w-20 h-20">
                                        @break

                                        @case('Cyber Security')
                                            <img src="{{ asset('images/cyber.png') }}" alt="Cyber Security" class="w-20 h-20">
                                        @break

                                        @default
                                            <img src="{{ asset('images/default.png') }}" alt="Default Icon" class="w-20 h-20">
                                    @endswitch
                                </div>
                            </div>
                            <a href="{{ route('portofolio.index', ['kategori' => $kategori['nama']]) }}"
                                class="text-blue-600 hover:text-blue-800 text-sm font-medium hover:underline block">
                                Lihat Portofolio Sejenis →
                            </a>
                        </div>
                    @endforeach
                </div>
                <div class="mt-8 text-center">
                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <a href="{{ route('portofolio.index') }}"
                            class="text-blue-600 hover:text-white px-6 py-2 font-medium hover:underline">
                            Lihat Semua Portofolio
                        </a>
                        @auth
                            <a href="{{ route('portofolio.create') }}"
                                class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">
                                + Tambah Portofolio
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </section>
        </section>


        {{-- Hall of Fame --}}
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-8">
                <div class="flex items-center justify-center gap-3 mb-4">
                    <div class="text-yellow-600">
                    </div>
                    <h2 class="text-3xl font-bold text-center mb-2 mt-6">🏆Proyek Unggulan Mahasiswa🏆</h2>
                </div>
                <p class="text-center text-gray-600 mb-10">Jelajahi karya-karya terbaik yang telah diunggah oleh
                    Mahasiswa Informatika, Universitas Udayana</p>
            </div>
            {{-- Top 3 Portofolio --}}
            <div class="mb-12">
                <div class="flex items-center justify-center gap-2 mb-6">
                    <div class="text-blue-600">
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @forelse ($topPortofolio as $index => $p)
                        <div
                            class="bg-white rounded-xl p-6 shadow-md border hover:shadow-lg transition-all duration-300 hover:-translate-y-1 relative">
                            @if ($index === 0)
                                <div
                                    class="absolute -top-3 -right-3 bg-yellow-500 text-white w-8 h-8 rounded-full flex items-center justify-center font-bold text-sm">
                                    1</div>
                            @elseif($index === 1)
                                <div
                                    class="absolute -top-3 -right-3 bg-gray-400 text-white w-8 h-8 rounded-full flex items-center justify-center font-bold text-sm">
                                    2</div>
                            @elseif($index === 2)
                                <div
                                    class="absolute -top-3 -right-3 bg-orange-500 text-white w-8 h-8 rounded-full flex items-center justify-center font-bold text-sm">
                                    3</div>
                            @endif
                            <div class="text-center">
                                @if ($p->gambar && $p->gambar->first())
                                    <div class="w-full h-40 bg-gray-200 rounded-xl overflow-hidden mb-4">
                                        <img src="{{ asset('storage/' . $p->gambar->first()->gambar_portofolio) }}"
                                            alt="{{ $p->nama_portofolio }}"
                                            class="w-full h-full object-cover hover:scale-105 transition duration-300">
                                    </div>
                                @else
                                    <div
                                        class="w-full h-40 bg-gray-100 rounded-xl flex items-center justify-center mb-4 border-2 border-dashed border-gray-300">
                                        <div class="text-gray-400 text-center">
                                            <svg class="w-12 h-12 mx-auto mb-2" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            <span class="text-sm">No Image</span>
                                        </div>
                                    </div>
                                @endif
                                <a href="{{ route('portofolio.show', $p->id_portofolio) }}"
                                    class="text-blue-600 hover:text-blue-800 font-semibold hover:underline block mb-3 line-clamp-2 text-lg">
                                    {{ $p->nama_portofolio }}
                                </a>
                                <p class="text-gray-600 mb-4 line-clamp-2">
                                    {{ Str::limit($p->deskripsi_portofolio, 100) }}</p>
                                <div class="flex flex-wrap gap-2 justify-center mb-4">
                                    @foreach ($p->kategori as $kategori)
                                        <span class="px-3 py-1 bg-blue-100 text-blue-800 text-xs rounded-full">
                                            {{ $kategori->kategori_portofolio }}
                                        </span>
                                    @endforeach
                                </div>
                                <div class="mb-4 text-sm text-gray-600">
                                    @php
                                        $allUsers = collect();
                                        if ($p->owner) {
                                            $allUsers->push([
                                                'nama' => $p->owner->nama_pengguna,
                                                'id' => $p->owner->id_pengguna,
                                            ]);
                                        }
                                        if ($p->taggedUsers && $p->taggedUsers->isNotEmpty()) {
                                            foreach ($p->taggedUsers as $tagged) {
                                                $allUsers->push([
                                                    'nama' => $tagged->nama_pengguna,
                                                    'id' => $tagged->id_pengguna,
                                                ]);
                                            }
                                        }
                                    @endphp
                                    @if ($allUsers->isNotEmpty())
                                        by
                                        @foreach ($allUsers as $i => $user)
                                            <a href="{{ route('profile.user', $user['id']) }}"
                                                class="text-blue-600 hover:underline font-medium">{{ $user['nama'] }}</a>
                                            @if ($i < $allUsers->count() - 2)
                                                ,
                                            @elseif ($i == $allUsers->count() - 2)
                                                dan
                                            @endif
                                        @endforeach
                                    @endif
                                </div>
                                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg p-4">
                                    <div class="text-2xl font-bold text-blue-600">{{ $p->view_count }}</div>
                                    <div class="text-sm text-gray-500">views</div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-3 text-center py-12 bg-white rounded-xl border border-gray-200">
                            <div class="text-gray-400 mb-4">
                                <svg class="w-16 h-16 mx-auto" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zm0 4a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1V8zm8 0a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1V8z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-700 mb-2">Belum ada portofolio</h3>
                            <p class="text-gray-500">Belum ada portofolio yang terdaftar bulan ini</p>
                        </div>
                    @endforelse
                </div>
            </div>
            {{-- Top Prestasi --}}
            <div>
                <div class="flex items-center justify-center gap-2 mb-6">
                    <div class="text-green-600">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800">Prestasi Terbaik</h3>
                    <div class="text-green-600">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                        </svg>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @if ($topPrestasi)
                        <div
                            class="bg-white rounded-xl p-6 shadow-md border border-green-200 hover:shadow-lg transition-all duration-300 hover:-translate-y-1">
                            <div class="text-center">
                                <div
                                    class="w-16 h-16 bg-gradient-to-br from-green-400 to-green-600 text-white rounded-full flex items-center justify-center font-bold text-2xl mx-auto mb-4 shadow-lg">
                                    🏆
                                </div>
                                <a href="{{ route('prestasi.show', $topPrestasi->id_prestasi) }}"
                                    class="text-green-700 hover:text-green-900 font-semibold hover:underline block mb-3 line-clamp-2 text-lg">
                                    {{ $topPrestasi->nama_prestasi }}
                                </a>
                                <div class="text-gray-600 mb-4">
                                    by <span
                                        class="font-medium">{{ $topPrestasi->owner->nama_pengguna ?? 'Unknown' }}</span>
                                </div>
                                <div class="bg-gradient-to-r from-green-50 to-emerald-50 rounded-lg p-4">
                                    <div class="text-lg font-medium text-green-700 mb-1">
                                        {{ $topPrestasi->tingkatan_prestasi ?? 'Internasional' }}
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        {{ $topPrestasi->tanggal_perolehan ? date('M Y', strtotime($topPrestasi->tanggal_perolehan)) : '' }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                    @for ($i = $topPrestasi ? 1 : 0; $i < 3; $i++)
                        <div
                            class="bg-gray-50 rounded-xl p-6 border-2 border-dashed border-gray-200 flex flex-col items-center justify-center text-gray-400 min-h-[280px]">
                            <div class="text-6xl mb-4">-</div>
                            <div class="text-lg font-medium">Slot {{ $i + 1 }}</div>
                            <div class="text-sm">Belum tersedia</div>
                        </div>
                    @endfor
                </div>
            </div>
        </div>

        {{-- Event Section --}}
        <section class="bg-[#DDF1FB] py-12">
            <div id="event-section" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="bg-white rounded-xl shadow-lg p-8">
                    <div class="flex flex-col md:flex-row justify-between items-center mb-8">
                        <div>
                            <h2 class="text-2xl font-bold text-gray-900 mb-2">Event Terbaru</h2>
                            <p class="text-gray-600">Jangan lewatkan event menarik yang akan datang!</p>
                        </div>
                        @auth
                            <a href="{{ route('event.create') }}"
                                class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">
                                + Tambah Event
                            </a>
                        @endauth
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @forelse($events as $event)
                            <div
                                class="bg-white border border-gray-200 rounded-xl shadow-sm hover:shadow-lg transition-all duration-300 hover:-translate-y-1 overflow-hidden">
                                @if ($event->thumbnail_event)
                                    <div class="aspect-video bg-gray-100 overflow-hidden">
                                        <img src="{{ asset('storage/' . $event->thumbnail_event) }}"
                                            alt="{{ $event->nama_event }}"
                                            class="w-full h-full object-cover hover:scale-105 transition duration-300">
                                    </div>
                                @else
                                    <div
                                        class="aspect-video bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center">
                                        <svg class="w-16 h-16 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                @endif

                                <div class="p-6">
                                    <h3 class="font-semibold text-xl mb-3 line-clamp-2">{{ $event->nama_event }}</h3>
                                    @if ($event->tanggal_event)
                                        <div class="flex items-center gap-2 text-gray-600 mb-3">
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            <span>{{ date('d M Y', strtotime($event->tanggal_event)) }}</span>
                                            @if ($event->waktu_event)
                                                <span class="text-gray-500">•
                                                    {{ date('H:i', strtotime($event->waktu_event)) }}</span>
                                            @endif
                                        </div>
                                    @endif

                                    <div class="flex gap-2 mb-4">
                                        @if ($event->jenis_event)
                                            <span class="px-3 py-1 bg-blue-100 text-blue-800 text-sm rounded-full">
                                                {{ ucfirst($event->jenis_event) }}
                                            </span>
                                        @endif
                                        @if ($event->penyelenggara_event)
                                            <span class="px-3 py-1 bg-gray-100 text-gray-800 text-sm rounded-full">
                                                {{ ucfirst($event->penyelenggara_event) }}
                                            </span>
                                        @endif
                                    </div>

                                    <p class="text-gray-600 mb-4 line-clamp-3">{{ $event->deskripsi_event }}</p>

                                    @if ($event->owner)
                                        <div class="text-sm text-gray-500 mb-4">
                                            Oleh <span class="font-medium">{{ $event->owner->nama_pengguna }}</span>
                                        </div>
                                    @endif

                                    <div class="space-y-3">
                                        <a href="{{ route('event.show', $event->id_event) }}"
                                            class="block w-full bg-blue-600 text-white text-center px-4 py-3 rounded-lg hover:bg-blue-700 transition font-medium">
                                            Detail Event
                                        </a>
                                        @if ($event->penyelenggara_event === 'eksternal')
                                            @if ($event->tautan_event)
                                                <a href="{{ $event->tautan_event }}"
                                                    class="block w-full bg-green-600 text-white text-center px-4 py-3 rounded-lg hover:bg-green-700 transition"
                                                    target="_blank">
                                                    Daftar di Website Penyelenggara
                                                </a>
                                            @endif
                                        @else
                                            <a href="{{ route('event.register', $event->id_event) }}"
                                                class="block w-full bg-green-600 text-white text-center px-4 py-3 rounded-lg hover:bg-green-700 transition">
                                                Daftar Sekarang
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-3 text-center py-16">
                                <div class="text-gray-400 mb-4">
                                    <svg class="w-20 h-20 mx-auto" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <h3 class="text-xl font-semibold text-gray-700 mb-2">Tidak ada event</h3>
                                <p class="text-gray-500 mb-6">Belum ada event yang tersedia saat ini</p>
                                @auth
                                    <a href="{{ route('event.create') }}"
                                        class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">
                                        + Buat Event Pertama
                                    </a>
                                @endauth
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </section>

        {{-- Oprek Section --}}
        <section class="bg-[#DDF1FB] py-12">
            <div id="oprek-section" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="bg-white rounded-xl shadow-lg p-8">
                    <div class="flex flex-col md:flex-row justify-between items-center mb-8">
                        <div>
                            <h2 class="text-2xl font-bold text-gray-900 mb-2">Oprek Terbaru</h2>
                            <p class="text-gray-600">Bergabunglah dengan project kolaboratif yang menarik</p>
                        </div>
                        @auth
                            <a href="{{ route('oprek.create') }}"
                                class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">
                                + Tambah Oprek
                            </a>
                        @endauth
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @forelse ($oprek as $item)
                            <div
                                class="bg-white border border-gray-200 rounded-xl shadow-sm hover:shadow-lg transition-all duration-300 hover:-translate-y-1 overflow-hidden">
                                <div class="p-6 border-b border-gray-100">
                                    <h3 class="font-semibold text-xl mb-3 line-clamp-2">{{ $item->nama_project }}</h3>
                                    @if ($item->deadline_project)
                                        <div class="flex items-center gap-2 text-gray-600 mb-3">
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            <span>Deadline:
                                                {{ date('d M Y', strtotime($item->deadline_project)) }}</span>
                                            @if (strtotime($item->deadline_project) < time())
                                                <span class="text-red-600 text-sm font-medium">(Berakhir)</span>
                                            @endif
                                        </div>
                                    @endif
                                    <div class="flex gap-2 flex-wrap mb-4">
                                        @if ($item->kategori_project)
                                            <span class="px-3 py-1 bg-blue-100 text-blue-800 text-sm rounded-full">
                                                {{ ucfirst(str_replace('_', ' ', $item->kategori_project)) }}
                                            </span>
                                        @endif
                                        @if ($item->output_project)
                                            <span class="px-3 py-1 bg-green-100 text-green-800 text-sm rounded-full">
                                                {{ ucfirst(str_replace('_', ' ', $item->output_project)) }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="p-6">
                                    <p class="text-gray-600 mb-4 line-clamp-3">{{ $item->deskripsi_project }}</p>
                                    @if ($item->owner)
                                        <div class="text-sm text-gray-500 mb-4">
                                            Oleh <span class="font-medium">{{ $item->owner->nama_pengguna }}</span>
                                        </div>
                                    @endif
                                    <a href="{{ route('oprek.show', $item->id_oprek) }}"
                                        class="block w-full bg-green-600 text-white text-center px-4 py-3 rounded-lg hover:bg-green-700 transition font-medium">
                                        Lihat Detail
                                    </a>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-16 col-span-3">
                                <div class="text-gray-400 mb-4">
                                    <svg class="w-20 h-20 mx-auto" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <h3 class="text-xl font-semibold text-gray-700 mb-2">Tidak ada project</h3>
                                <p class="text-gray-500 mb-6">Belum ada project yang tersedia saat ini</p>
                                @auth
                                    <a href="{{ route('oprek.create') }}"
                                        class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">
                                        + Buat Project Pertama
                                    </a>
                                @endauth
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </section>

        {{-- Portofolio Section --}}
        <section class="bg-[#DDF1FB] py-12">
            <div id="portofolio-section" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="bg-white rounded-xl shadow-lg p-8">
                    <div class="flex flex-col md:flex-row justify-between items-center mb-8">
                        <div>
                            <h2 class="text-2xl font-bold text-gray-900 mb-2">Portofolio Terbaru</h2>
                            <p class="text-gray-600">Showcase karya mahasiswa informatika</p>
                        </div>
                        @auth
                            <a href="{{ route('portofolio.create') }}"
                                class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">
                                + Tambah Portofolio
                            </a>
                        @endauth
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @forelse($portofolio as $item)
                            <div
                                class="bg-white border border-gray-200 rounded-xl shadow-sm hover:shadow-lg transition-all duration-300 hover:-translate-y-1 overflow-hidden">
                                <div class="aspect-video bg-gray-100 overflow-hidden">
                                    @if ($item->gambar && $item->gambar->first())
                                        <img src="{{ asset('storage/' . $item->gambar->first()->gambar_portofolio) }}"
                                            alt="{{ $item->nama_portofolio }}"
                                            class="w-full h-full object-cover hover:scale-105 transition duration-300">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-gray-400">
                                            <svg class="w-16 h-16" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                                <div class="p-6">
                                    <h3 class="font-semibold text-xl mb-3 line-clamp-2">{{ $item->nama_portofolio }}
                                    </h3>
                                    <p class="text-gray-600 mb-4 line-clamp-3">{{ $item->deskripsi_portofolio }}</p>
                                    <div class="flex flex-wrap gap-2 mb-4">
                                        @foreach ($item->kategori ?? [] as $kat)
                                            <span class="px-3 py-1 bg-indigo-100 text-indigo-800 text-sm rounded-full">
                                                {{ $kat->kategori_portofolio }}
                                            </span>
                                        @endforeach
                                    </div>
                                    <div class="flex justify-between items-center text-sm text-gray-500 mb-4">
                                        <div class="flex gap-4">
                                            <span class="flex items-center gap-1">
                                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                                    <path fill-rule="evenodd"
                                                        d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                                {{ $item->view_count ?? 0 }}
                                            </span>
                                            <span class="flex items-center gap-1">
                                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                    <path
                                                        d="M2 10.5a1.5 1.5 0 113 0v6a1.5 1.5 0 01-3 0v-6zM6 10.333v5.43a2 2 0 001.106 1.79l.05.025A4 4 0 008.943 18h5.416a2 2 0 001.962-1.608l1.2-6A2 2 0 0015.56 8H12V4a2 2 0 00-2-2 1 1 0 00-1 1v.667a4 4 0 01-.8 2.4L6.8 7.933a4 4 0 00-.8 2.4z" />
                                                </svg>
                                                {{ $item->banyak_upvote ?? 0 }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="text-sm text-gray-500 mb-4">
                                        Oleh <span
                                            class="font-medium">{{ $item->owner->nama_pengguna ?? 'Unknown' }}</span>
                                    </div>
                                    <a href="{{ route('portofolio.show', $item->id_portofolio) }}"
                                        class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">
                                        Lihat Detail
                                    </a>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-3 text-center py-16">
                                <div class="text-gray-400 mb-4">
                                    <svg class="w-20 h-20 mx-auto" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zm0 4a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1V8zm8 0a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1V8z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <h3 class="text-xl font-semibold text-gray-700 mb-2">Tidak ada portofolio</h3>
                                <p class="text-gray-500 mb-6">Belum ada portofolio yang tersedia saat ini</p>
                                @auth
                                    <a href="{{ route('portofolio.create') }}"
                                        class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">
                                        + Buat Portofolio Pertama
                                    </a>
                                @endauth
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </section>

        {{-- Download Section --}}
        <section class="bg-[#DDF1FB] py-12">
            <div id="download-section" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="bg-white rounded-xl shadow-lg p-8">
                    <div class="flex flex-col md:flex-row justify-between items-center mb-8">
                        <div>
                            <h2 class="text-2xl font-bold text-gray-900 mb-2">File Download</h2>
                            <p class="text-gray-600">Unduh berbagai file dan resource yang berguna</p>
                        </div>
                        @auth
                            <a href="{{ route('download.create') }}"
                                class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">
                                + Upload File
                            </a>
                        @endauth
                    </div>
                    <div class="space-y-4">
                        @forelse($dataDownload as $file)
                            <div
                                class="flex justify-between items-center border border-gray-200 rounded-xl p-6 hover:shadow-md transition">
                                <div class="flex-1">
                                    <h3 class="font-semibold text-lg text-gray-900 mb-2">{{ $file->nama_download }}
                                    </h3>
                                    <p class="text-gray-600 mb-3">{{ $file->deskripsi_download }}</p>
                                    <div class="flex gap-4 text-sm text-gray-500">
                                        <span>
                                            Ukuran:
                                            @if ($file->ukuran_file)
                                                {{ number_format($file->ukuran_file / 1024, 2) }} KB
                                            @else
                                                -
                                            @endif
                                        </span>
                                        <span>Oleh: {{ $file->pengguna->nama_pengguna ?? 'Unknown' }}</span>
                                    </div>
                                </div>
                                <div class="flex flex-col gap-3 ml-6">
                                    <a href="{{ route('download.file', $file->id_download) }}"
                                        class="bg-purple-600 text-white px-6 py-2 rounded-lg hover:bg-purple-700 transition font-medium">
                                        Download
                                    </a>
                                    @auth
                                        @if (auth()->id() == $file->id_uploader)
                                            <a href="{{ route('download.edit', $file->id_download) }}"
                                                class="text-purple-600 hover:underline text-sm text-center">Edit</a>
                                        @endif
                                    @endauth
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-16">
                                <div class="text-gray-400 mb-4">
                                    <svg class="w-20 h-20 mx-auto" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <h3 class="text-xl font-semibold text-gray-700 mb-2">Tidak ada file</h3>
                                <p class="text-gray-500 mb-6">Belum ada file tersedia untuk download</p>
                                @auth
                                    <a href="{{ route('download.create') }}"
                                        class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">
                                        + Upload File Pertama
                                    </a>
                                @endauth
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
    </div>
    </section>

    {{-- Ajakan Showcase --}}
    <div
        class="bg-gradient-to-r from-[#BCE2F8] to-[#75AAD8] rounded-2xl shadow p-4 py-12 px-8 max-w-7xl mx-auto px-4 flex flex-col md:flex-row items-center gap-8 hover:shadow-lg transition duration-300">
        {{-- Gambar --}}
        <div class="w-full md:w-1/3 flex justify-center">
            <img src="{{ asset('images/ayo.png') }}" alt="Ajakan Showcase" class="w-48 md:w-52 lg:w-60">
        </div>
        <div class="md:w-1/2 text-white">
            <h2 class="text-2xl font-bold mb-4">Ayo Mulai <span class="italic">Showcase</span> Karyamu!</h2>
            <p class="mb-6">Ikuti langkah-langkah di bawah ini dan mulai showcase karyamu sekarang juga:</p>
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 text-center">
                <div
                    class="bg-white rounded-lg shadow rounded-xl p-6 border border-blue-200 hover:shadow-lg transition-all duration-300 hover:-translate-y-1 p-4">
                    <img src="{{ asset('images/website.jpg') }}" class="mx-auto h-12 mb-2" alt="Buat Akun">
                    <a href="{{ route('register') }}" class="px-auto py-auto font-semibold text-black">Buat Akun</a>
                </div>
                <div
                    class="bg-white rounded-lg shadow rounded-xl p-6 border border-blue-200 hover:shadow-lg transition-all duration-300 hover:-translate-y-1 p-4">
                    <img src="{{ asset('images/website.jpg') }}" class="mx-auto h-12 mb-2" alt="Lengkapi Profil">
                    <a href="{{ route('profile') }}" class="px-auto py-auto font-semibold text-black">Lengkapi
                        Profil</a>
                </div>
                <div
                    class="bg-white rounded-lg shadow rounded-xl p-6 border border-blue-200 hover:shadow-lg transition-all duration-300 hover:-translate-y-1 p-4">
                    <img src="{{ asset('images/website.jpg') }}" class="mx-auto h-12 mb-2" alt="Upload Karya">
                    <a href="portofolio/create" class="px-auto py-auto font-semibold text-black">Upload Karya</a>
                    {{-- KURANG ROUTE KETUJUAN --}}
                </div>
                <div
                    class="bg-white rounded-lg shadow rounded-xl p-6 border border-blue-200 hover:shadow-lg transition-all duration-300 hover:-translate-y-1 p-4">
                    <img src="{{ asset('images/website.jpg') }}" class="mx-auto h-12 mb-2" alt="Bagikan">
                    <a href="#" class="px-auto py-auto font-semibold text-black">Bagikan</a>
                    {{-- KURANG ROUTE KETUJUAN --}}
                </div>
            </div>
        </div>
    </div>

    <section class="py-8 bg-white"> </section>
    {{-- Footer --}}
    <footer class="text-center text-white py-4" style="background-color: #3E5879;"> &copy; 2025 Official Site
        Informatika – Universitas Udayana
    </footer>
</body>
</html>