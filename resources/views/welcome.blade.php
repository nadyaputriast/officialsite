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

        [x-cloak] {
            display: none !important;
        }
    </style>
</head>

<body class="antialiased font-sans bg-white" x-data="{ currentView: 'home', open: false }">
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
    <header class="bg-white shadow-lg sticky top-0 z-50" x-data="{ open: false }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            {{-- Logo --}}
            <a href="#" class="flex items-center space-x-2" @click.prevent="currentView = 'home'">
                <img src="{{ asset('images/saturuang.png') }}" alt="Logo" class="h-10 w-auto">
                <span class="font-bold text-black">
                    Satu<span class="text-blue-600">Ruang</span>
                </span>
            </a>

            {{-- Hamburger Menu (mobile only) --}}
            <button @click="open = !open"
                class="sm:hidden flex items-center px-3 py-2 border rounded text-gray-600 border-gray-400 hover:text-blue-600 hover:border-blue-600 focus:outline-none">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex" stroke-linecap="round"
                        stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                        stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            {{-- Navigation Links (desktop only) --}}
            <div class="hidden sm:flex flex-1 justify-center space-x-4">
                <a href="#" @click.prevent="currentView = 'home'"
                    :class="currentView === 'home' ? 'text-blue-600 font-bold' : 'text-black hover:text-blue-600'">Home</a>
                <a href="#" @click.prevent="currentView = 'project'"
                    :class="currentView === 'project' ? 'text-blue-600 font-bold' : 'text-black hover:text-blue-600'">Project</a>
                <a href="#" @click.prevent="currentView = 'event'"
                    :class="currentView === 'event' ? 'text-blue-600 font-bold' : 'text-black hover:text-blue-600'">Event</a>
                <a href="#" @click.prevent="currentView = 'hiring'"
                    :class="currentView === 'hiring' ? 'text-blue-600 font-bold' : 'text-black hover:text-blue-600'">Hiring</a>
                <a href="#" @click.prevent="currentView = 'download'"
                    :class="currentView === 'download' ? 'text-blue-600 font-bold' : 'text-black hover:text-blue-600'">Download</a>
            </div>

            {{-- Auth Links (desktop only) --}}
            <div class="hidden sm:flex flex-col sm:flex-row gap-4 justify-center items-center">
                @auth
                    <a href="{{ route('dashboard') }}" class="text-black hover:text-blue-600 text-center">Dashboard</a>
                    <div class="hidden sm:flex sm:items-center sm:ms-6">
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button
                                    class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                    <div>{{ auth()->user()->nama_pengguna }}</div>
                                    <div class="ms-1">
                                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </button>
                            </x-slot>
                            <x-slot name="content">
                                <x-dropdown-link :href="route('profile')">
                                    {{ __('Profile') }}
                                </x-dropdown-link>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <x-dropdown-link href="{{ route('logout') }}"
                                        onclick="event.preventDefault(); this.closest('form').submit();">
                                        {{ __('Log Out') }}
                                    </x-dropdown-link>
                                </form>
                            </x-slot>
                        </x-dropdown>
                    </div>
                @else
                    <a href="{{ route('register') }}"
                        class="rounded-md px-4 py-2 bg-blue-600 text-white hover:bg-blue-500 transition">
                        Register
                    </a>
                    <a href="{{ route('login') }}"
                        class="rounded-md px-4 py-2 bg-blue-600 text-white hover:bg-blue-500 transition">
                        Login
                    </a>
                @endauth
            </div>
        </div>

        {{-- Mobile Menu (visible only when open) --}}
        <div class="sm:hidden" x-show="open" x-transition>
            <div class="px-4 pt-4 pb-6 space-y-2">
                <a href="#" @click.prevent="currentView = 'home'; open = false"
                    :class="currentView === 'home' ? 'text-blue-600 font-bold block' :
                        'text-black hover:text-blue-600 block'">Home</a>
                <a href="#" @click.prevent="currentView = 'project'; open = false"
                    :class="currentView === 'project' ? 'text-blue-600 font-bold block' :
                        'text-black hover:text-blue-600 block'">Project</a>
                <a href="#" @click.prevent="currentView = 'event'; open = false"
                    :class="currentView === 'event' ? 'text-blue-600 font-bold block' :
                        'text-black hover:text-blue-600 block'">Event</a>
                <a href="#" @click.prevent="currentView = 'hiring'; open = false"
                    :class="currentView === 'hiring' ? 'text-blue-600 font-bold block' :
                        'text-black hover:text-blue-600 block'">Hiring</a>
                <a href="#" @click.prevent="currentView = 'download'; open = false"
                    :class="currentView === 'download' ? 'text-blue-600 font-bold block' :
                        'text-black hover:text-blue-600 block'">Download</a>

                @auth
                    <a href="{{ route('dashboard') }}" class="block text-black hover:text-blue-600">Dashboard</a>
                    <a href="{{ route('profile') }}" class="block text-black hover:text-blue-600">Profile</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="block w-full text-left px-0 py-2 text-black hover:text-blue-600">
                            Log Out
                        </button>
                    </form>
                @else
                    <a href="{{ route('register') }}" class="block text-black hover:text-blue-600">Register</a>
                    <a href="{{ route('login') }}" class="block text-black hover:text-blue-600">Login</a>
                @endauth
            </div>
        </div>
    </header>

    {{-- Konten Dinamis --}}
    <div>
        {{-- Home --}}
        <div x-show="currentView === 'home'">
            {{-- Hero Section --}}
            <div
                class="max-w-7xl mx-auto flex flex-col md:flex-row items-center px-6 space-y-6 md:space-y-0 md:space-x-12">
                <div class="md:w-1/2">
                    <h1 class="text-shadow-lg/30 text-5xl font-bold text-black mt-6">Showcase Your Passion<br>Inspire
                        Others</h1>
                    <p class="mt-4 text-gray-700">
                        <strong>SatuRuang</strong> adalah platform digital yang dirancang untuk mengumpulkan dan
                        memamerkan karya akademik mahasiswa dalam satu ruang kolaboratif. Platform ini hadir sebagai
                        wadah apresiasi,
                        publikasi, dan pengembangan diri.
                    </p>
                    <div class="mt-6 space-x-4">
                        @auth
                            <a href="{{ route('dashboard') }}"
                                class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Buat Profilmu</a>
                        @else
                            <a href="{{ route('register') }}"
                                class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                                Buat Profilmu </a>
                        @endauth
                        <a href="#" @click.prevent="currentView = 'project'"
                            class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300">Jelajahi
                            Proyek</a>
                    </div>
                </div>
                <div class="md:w-1/2">
                    <img src="{{ asset('images/hero.jpg') }}" alt="Hero"
                        class="shadow-lg w-80 h-80 object-cover mt-10 mx-auto mb-8 mr-16" style="border-radius: 50%;">
                </div>
            </div>

            <div class="space-y-12 mt-12">
                {{-- KategoriStat Section --}}
                <section class="bg-gradient-to-r from-[#75AAD8] to-[#DDF1FB] py-12">
                    <div class="max-w-7xl mx-auto px-4">
                        {{-- Judul --}}
                        <div class="text-center mb-12">
                            <h3 class="text-3xl font-bold text-white mb-3">Kategori Proyek</h3>
                            <p class="text-white text-lg">Lihat Berbagai Kategori Proyek Informatika</p>
                        </div>

                        {{-- Grid Responsif --}}
                        <div
                            class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6">
                            @foreach ($kategoriStats as $kategori)
                                <div
                                    class="bg-white rounded-xl shadow p-6 border border-blue-200 hover:shadow-lg transition-all duration-300 hover:-translate-y-1">
                                    <div class="flex flex-col items-center mb-4">
                                        {{-- Judul Kategori --}}
                                        <h3
                                            class="font-semibold text-gray-900 mb-1 text-sm text-center leading-tight line-clamp-2 h-10">
                                            {{ $kategori['nama'] }}
                                        </h3>

                                        {{-- Jumlah Proyek --}}
                                        <p class="text-3xl font-bold text-blue-600">
                                            {{ $kategori['jumlah'] }}
                                        </p>
                                        <p class="text-sm text-gray-500">proyek</p>

                                        {{-- Gambar --}}
                                        <div class="mt-4">
                                            @switch($kategori['nama'])
                                                @case('UI/UX Design')
                                                    <img src="{{ asset('images/uiux.png') }}" alt="UI/UX Design"
                                                        class="w-16 h-16">
                                                @break

                                                @case('Website Development')
                                                    <img src="{{ asset('images/default.png') }}" alt="Website Development"
                                                        class="w-16 h-16">
                                                @break

                                                @case('Mobile Development')
                                                    <img src="{{ asset('images/mobdev.png') }}" alt="Mobile Development"
                                                        class="w-16 h-16">
                                                @break

                                                @case('Game Development')
                                                    <img src="{{ asset('images/webdev.png') }}" alt="Game Development"
                                                        class="w-16 h-16">
                                                @break

                                                @case('Internet of Things')
                                                    <img src="{{ asset('images/iot.png') }}" alt="Internet of Things"
                                                        class="w-16 h-16">
                                                @break

                                                @case('ML/AI')
                                                    <img src="{{ asset('images/machinelearning.png') }}"
                                                        alt="Machine Learning/AI" class="w-16 h-16">
                                                @break

                                                @case('Blockchain')
                                                    <img src="{{ asset('images/blockchain.png') }}" alt="Blockchain"
                                                        class="w-16 h-16">
                                                @break

                                                @case('Cyber Security')
                                                    <img src="{{ asset('images/cyber.png') }}" alt="Cyber Security"
                                                        class="w-16 h-16">
                                                @break

                                                @default
                                                    <img src="{{ asset('images/default.png') }}" alt="Default Icon"
                                                        class="w-16 h-16">
                                            @endswitch
                                        </div>
                                    </div>

                                    {{-- Link Portofolio --}}
                                    <a href="{{ route('portofolio.index', ['kategori' => $kategori['nama']]) }}"
                                        class="text-blue-600 hover:text-blue-800 text-sm font-medium hover:underline block text-center">
                                        Lihat Sejenis →
                                    </a>
                                </div>
                            @endforeach
                        </div>

                        {{-- Navigasi Bawah --}}
                        <div class="mt-12 text-center">
                            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
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

                {{-- Hall of Fame --}}
                @include('dashboard.halloffame')

                {{-- Ajakan Showcase --}}
                <div class="mt-12 mb-4 ml-4 mr-4">
                    <div
                        class="bg-gradient-to-r from-[#BCE2F8] to-[#75AAD8] rounded-2xl shadow p-4 py-12 px-8 max-w-7xl mx-auto flex flex-col md:flex-row items-center gap-8 hover:shadow-lg transition duration-300">
                        <div class="w-full md:w-1/3 flex justify-center">
                            <img src="{{ asset('images/ayo.png') }}" alt="Ajakan Showcase"
                                class="w-48 md:w-52 lg:w-60">
                        </div>
                        <div class="md:w-1/2 text-white">
                            <h2 class="text-2xl font-bold mb-4">Ayo Mulai <span class="italic">Showcase</span>
                                Karyamu!</h2>
                            <p class="mb-6">Ikuti langkah-langkah di bawah ini dan mulai showcase karyamu
                                sekarang juga:</p>
                            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 text-center">
                                <div
                                    class="bg-white rounded-lg shadow rounded-xl p-6 border border-blue-200 hover:shadow-lg transition-all duration-300 hover:-translate-y-1 p-4">
                                    <img src="{{ asset('images/website.jpg') }}" class="mx-auto h-12 mb-2">
                                    <a href="{{ route('register') }}"
                                        class="px-auto py-auto font-semibold text-black">Buat
                                        Akun</a>
                                </div>
                                <div
                                    class="bg-white rounded-lg shadow rounded-xl p-6 border border-blue-200 hover:shadow-lg transition-all duration-300 hover:-translate-y-1 p-4">
                                    <img src="{{ asset('images/website.jpg') }}" class="mx-auto h-12 mb-2">
                                    <a href="{{ route('profile') }}"
                                        class="px-auto py-auto font-semibold text-black">Lengkapi Profil</a>
                                </div>
                                <div
                                    class="bg-white rounded-lg shadow rounded-xl p-6 border border-blue-200 hover:shadow-lg transition-all duration-300 hover:-translate-y-1 p-4">
                                    <img src="{{ asset('images/website.jpg') }}" class="mx-auto h-12 mb-2">
                                    <a href="{{ route('portofolio.create') }}"
                                        class="px-auto py-auto font-semibold text-black">Upload Karya</a>
                                </div>
                                <div
                                    class="bg-white rounded-xl p-6 border border-blue-200 hover:shadow-lg transition-all duration-300 hover:-translate-y-1 p-4">
                                    <img src="{{ asset('images/website.jpg') }}" class="mx-auto h-12 mb-2">
                                    <a href="#" class="px-auto py-auto font-semibold text-black">Bagikan</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Project --}}
        <div x-show="currentView === 'project'">
            <section class="bg-[#DDF1FB] py-12">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
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
                                        <h3 class="font-semibold text-xl mb-3 line-clamp-2">
                                            {{ $item->nama_portofolio }}
                                        </h3>
                                        <p class="text-gray-600 mb-4 line-clamp-3">{{ $item->deskripsi_portofolio }}
                                        </p>
                                        <div class="flex flex-wrap gap-2 mb-4">
                                            @foreach ($item->kategori ?? [] as $kat)
                                                <span
                                                    class="px-3 py-1 bg-indigo-100 text-indigo-800 text-sm rounded-full">
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
        </div>

        {{-- Event --}}
        <div x-show="currentView === 'event'">
            <section class="bg-[#DDF1FB] py-12">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
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
                                            <svg class="w-16 h-16 text-gray-400" fill="currentColor"
                                                viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                    @endif

                                    <div class="p-6">
                                        <h3 class="font-semibold text-xl mb-3 line-clamp-2">{{ $event->nama_event }}
                                        </h3>
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
                                                Oleh <span
                                                    class="font-medium">{{ $event->owner->nama_pengguna }}</span>
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
        </div>

        {{-- Hiring --}}
        <div x-show="currentView === 'hiring'">
            <section class="bg-[#DDF1FB] py-12">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
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
                                        <h3 class="font-semibold text-xl mb-3 line-clamp-2">{{ $item->nama_project }}
                                        </h3>
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
                                                <span
                                                    class="px-3 py-1 bg-green-100 text-green-800 text-sm rounded-full">
                                                    {{ ucfirst(str_replace('_', ' ', $item->output_project)) }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="p-6">
                                        <p class="text-gray-600 mb-4 line-clamp-3">{{ $item->deskripsi_project }}</p>
                                        @if ($item->owner)
                                            <div class="text-sm text-gray-500 mb-4">
                                                Oleh <span
                                                    class="font-medium">{{ $item->owner->nama_pengguna }}</span>
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
        </div>

        {{-- Download --}}
        <div x-show="currentView === 'download'">
            <section class="bg-[#DDF1FB] py-12">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
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
                                        <h3 class="font-semibold text-lg text-gray-900 mb-2">
                                            {{ $file->nama_download }}
                                        </h3>
                                        <p class="text-gray-600 mb-3">{{ $file->deskripsi_download }}</p>
                                        <div class="flex gap-4 text-sm text-gray-500">
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
            </section>
        </div>
    </div>

    {{-- Footer --}}
    @include('dashboard.footer')
</body>

</html>