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
    @if (!auth()->user()->hasRole('admin'))
        {{-- Banner --}}
        <x-banner-component />
        @include ('dashboard.navbar')

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
                        <a href="{{ route('register') }}"
                            class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
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
        <div class="space-y-12">
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
                                                <img src="{{ asset('images/blockchain.png') }}" alt="Blockchain"
                                                    class="w-20 h-20">
                                            @break

                                            @case('Cyber Security')
                                                <img src="{{ asset('images/cyber.png') }}" alt="Cyber Security"
                                                    class="w-20 h-20">
                                            @break

                                            @default
                                                <img src="{{ asset('images/default.png') }}" alt="Default Icon"
                                                    class="w-20 h-20">
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

            @include('dashboard.halloffame')

            @include('dashboard.portofolio')

            @include('dashboard.event')

            @include('dashboard.oprek')

            @include('dashboard.download')

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
                            <a href="{{ route('register') }}" class="px-auto py-auto font-semibold text-black">Buat
                                Akun</a>
                        </div>
                        <div
                            class="bg-white rounded-lg shadow rounded-xl p-6 border border-blue-200 hover:shadow-lg transition-all duration-300 hover:-translate-y-1 p-4">
                            <img src="{{ asset('images/website.jpg') }}" class="mx-auto h-12 mb-2"
                                alt="Lengkapi Profil">
                            <a href="{{ route('profile') }}" class="px-auto py-auto font-semibold text-black">Lengkapi
                                Profil</a>
                        </div>
                        <div
                            class="bg-white rounded-lg shadow rounded-xl p-6 border border-blue-200 hover:shadow-lg transition-all duration-300 hover:-translate-y-1 p-4">
                            <img src="{{ asset('images/website.jpg') }}" class="mx-auto h-12 mb-2" alt="Upload Karya">
                            <a href="portofolio/create" class="px-auto py-auto font-semibold text-black">Upload
                                Karya</a> {{-- KURANG ROUTE KETUJUAN --}}
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
        @else
            {{-- SIDEBAR ADMIN --}}
            <header class="bg-white shadow-lg sticky top-0 z-50">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
                    {{-- Logo --}}
                    <div class="flex items-center space-x-2">
                        <img src="{{ asset('images/saturuang.png') }}" alt="Logo" class="h-10 w-auto">
                        <span class="font-bold text-black">Satu<span class="text-blue-600">Ruang</span></span>
                    </div>

                    <div class="hidden sm:flex sm:items-center sm:ms-6">
                        {{-- Dropdown --}}
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button
                                    class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                    <div x-data="{ nama_pengguna: '{{ auth()->user()->nama_pengguna }}' }" x-text="nama_pengguna"
                                        x-on:profile-updated.window="nama_pengguna = $event.detail.name"></div>
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
                                <x-dropdown-link :href="route('profile')" wire:navigate>
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
            </header>
            {{-- Navigation Links --}}
            <div x-data="{ tab: 'validasi_user' }" class="flex min-h-screen bg-gray-50">
                {{-- Sidebar --}}
                <aside class="w-64 bg-[#504E4E] border-r border-gray-200 flex-shrink-0 hidden md:block">
                    <div class="h-full flex flex-col py-6 px-4 mt-6">
                        <nav class="flex-1 space-y-2">
                            <button @click="tab = 'validasi_user'"
                                :class="tab === 'validasi_user' ? 'bg-[#4B83BF] text-white' : 'text-white hover:bg-gray-500'"
                                class="w-full text-left px-4 py-2 rounded flex items-center gap-2 font-medium transition">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                    class="size-6">
                                    <path fill-rule="evenodd"
                                        d="M12.516 2.17a.75.75 0 0 0-1.032 0 11.209 11.209 0 0 1-7.877 3.08.75.75 0 0 0-.722.515A12.74 12.74 0 0 0 2.25 9.75c0 5.942 4.064 10.933 9.563 12.348a.749.749 0 0 0 .374 0c5.499-1.415 9.563-6.406 9.563-12.348 0-1.39-.223-2.73-.635-3.985a.75.75 0 0 0-.722-.516l-.143.001c-2.996 0-5.717-1.17-7.734-3.08Zm3.094 8.016a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z"
                                        clip-rule="evenodd" />
                                </svg>
                                <span>Validasi User</span>
                            </button>
                            <button @click="tab = 'validasi_event'"
                                :class="tab === 'validasi_event' ? 'bg-[#4B83BF] text-white' : 'text-white hover:bg-gray-500'"
                                class="w-full text-left px-4 py-2 rounded flex items-center gap-2 font-medium transition">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                    class="size-6">
                                    <path fill-rule="evenodd"
                                        d="M7.502 6h7.128A3.375 3.375 0 0 1 18 9.375v9.375a3 3 0 0 0 3-3V6.108c0-1.505-1.125-2.811-2.664-2.94a48.972 48.972 0 0 0-.673-.05A3 3 0 0 0 15 1.5h-1.5a3 3 0 0 0-2.663 1.618c-.225.015-.45.032-.673.05C8.662 3.295 7.554 4.542 7.502 6ZM13.5 3A1.5 1.5 0 0 0 12 4.5h4.5A1.5 1.5 0 0 0 15 3h-1.5Z"
                                        clip-rule="evenodd" />
                                    <path fill-rule="evenodd"
                                        d="M3 9.375C3 8.339 3.84 7.5 4.875 7.5h9.75c1.036 0 1.875.84 1.875 1.875v11.25c0 1.035-.84 1.875-1.875 1.875h-9.75A1.875 1.875 0 0 1 3 20.625V9.375Zm9.586 4.594a.75.75 0 0 0-1.172-.938l-2.476 3.096-.908-.907a.75.75 0 0 0-1.06 1.06l1.5 1.5a.75.75 0 0 0 1.116-.062l3-3.75Z"
                                        clip-rule="evenodd" />
                                </svg>
                                <span>Validasi Event</span>
                            </button>
                            <button @click="tab = 'user'"
                                :class="tab === 'user' ? 'bg-[#4B83BF] text-white' : 'text-white hover:bg-gray-500'"
                                class="w-full text-left px-4 py-2 rounded flex items-center gap-2 font-medium transition">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                    class="size-6">
                                    <path fill-rule="evenodd"
                                        d="M7.5 6a4.5 4.5 0 1 1 9 0 4.5 4.5 0 0 1-9 0ZM3.751 20.105a8.25 8.25 0 0 1 16.498 0 .75.75 0 0 1-.437.695A18.683 18.683 0 0 1 12 22.5c-2.786 0-5.433-.608-7.812-1.7a.75.75 0 0 1-.437-.695Z"
                                        clip-rule="evenodd" />
                                </svg>
                                <span>User</span>
                            </button>
                            <button @click="tab = 'event'"
                                :class="tab === 'event' ? 'bg-[#4B83BF] text-white' : 'text-white hover:bg-gray-500'"
                                class="w-full text-left px-4 py-2 rounded flex items-center gap-2 font-medium transition">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                    class="size-6">
                                    <path
                                        d="M12.75 12.75a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM7.5 15.75a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5ZM8.25 17.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM9.75 15.75a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5ZM10.5 17.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM12 15.75a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5ZM12.75 17.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM14.25 15.75a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5ZM15 17.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM16.5 15.75a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5ZM15 12.75a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM16.5 13.5a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Z" />
                                    <path fill-rule="evenodd"
                                        d="M6.75 2.25A.75.75 0 0 1 7.5 3v1.5h9V3A.75.75 0 0 1 18 3v1.5h.75a3 3 0 0 1 3 3v11.25a3 3 0 0 1-3 3H5.25a3 3 0 0 1-3-3V7.5a3 3 0 0 1 3-3H6V3a.75.75 0 0 1 .75-.75Zm13.5 9a1.5 1.5 0 0 0-1.5-1.5H5.25a1.5 1.5 0 0 0-1.5 1.5v7.5a1.5 1.5 0 0 0 1.5 1.5h13.5a1.5 1.5 0 0 0 1.5-1.5v-7.5Z"
                                        clip-rule="evenodd" />
                                </svg>
                                <span>Event</span>
                            </button>
                            <button @click="tab = 'oprek'"
                                :class="tab === 'oprek' ? 'bg-[#4B83BF] text-white' : 'text-white hover:bg-gray-500'"
                                class="w-full text-left px-4 py-2 rounded flex items-center gap-2 font-medium transition">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                    class="size-6">
                                    <path fill-rule="evenodd"
                                        d="M7.5 5.25a3 3 0 0 1 3-3h3a3 3 0 0 1 3 3v.205c.933.085 1.857.197 2.774.334 1.454.218 2.476 1.483 2.476 2.917v3.033c0 1.211-.734 2.352-1.936 2.752A24.726 24.726 0 0 1 12 15.75c-2.73 0-5.357-.442-7.814-1.259-1.202-.4-1.936-1.541-1.936-2.752V8.706c0-1.434 1.022-2.7 2.476-2.917A48.814 48.814 0 0 1 7.5 5.455V5.25Zm7.5 0v.09a49.488 49.488 0 0 0-6 0v-.09a1.5 1.5 0 0 1 1.5-1.5h3a1.5 1.5 0 0 1 1.5 1.5Zm-3 8.25a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Z"
                                        clip-rule="evenodd" />
                                    <path
                                        d="M3 18.4v-2.796a4.3 4.3 0 0 0 .713.31A26.226 26.226 0 0 0 12 17.25c2.892 0 5.68-.468 8.287-1.335.252-.084.49-.189.713-.311V18.4c0 1.452-1.047 2.728-2.523 2.923-2.12.282-4.282.427-6.477.427a49.19 49.19 0 0 1-6.477-.427C4.047 21.128 3 19.852 3 18.4Z" />
                                </svg>
                                <span>Hiring</span>
                            </button>
                            <button @click="tab = 'portofolio'"
                                :class="tab === 'portofolio' ? 'bg-[#4B83BF] text-white' : 'text-white hover:bg-gray-500'"
                                class="w-full text-left px-4 py-2 rounded flex items-center gap-2 font-medium transition">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                    class="size-6">
                                    <path
                                        d="M19.906 9c.382 0 .749.057 1.094.162V9a3 3 0 0 0-3-3h-3.879a.75.75 0 0 1-.53-.22L11.47 3.66A2.25 2.25 0 0 0 9.879 3H6a3 3 0 0 0-3 3v3.162A3.756 3.756 0 0 1 4.094 9h15.812ZM4.094 10.5a2.25 2.25 0 0 0-2.227 2.568l.857 6A2.25 2.25 0 0 0 4.951 21H19.05a2.25 2.25 0 0 0 2.227-1.932l.857-6a2.25 2.25 0 0 0-2.227-2.568H4.094Z" />
                                </svg>
                                <span>Project</span>
                            </button>
                            <button @click="tab = 'pengabdian'"
                                :class="tab === 'pengabdian' ? 'bg-[#4B83BF] text-white' : 'text-white hover:bg-gray-500'"
                                class="w-full text-left px-4 py-2 rounded flex items-center gap-2 font-medium transition">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                    class="size-6">
                                    <path
                                        d="m11.645 20.91-.007-.003-.022-.012a15.247 15.247 0 0 1-.383-.218 25.18 25.18 0 0 1-4.244-3.17C4.688 15.36 2.25 12.174 2.25 8.25 2.25 5.322 4.714 3 7.688 3A5.5 5.5 0 0 1 12 5.052 5.5 5.5 0 0 1 16.313 3c2.973 0 5.437 2.322 5.437 5.25 0 3.925-2.438 7.111-4.739 9.256a25.175 25.175 0 0 1-4.244 3.17 15.247 15.247 0 0 1-.383.219l-.022.012-.007.004-.003.001a.752.752 0 0 1-.704 0l-.003-.001Z" />
                                </svg>
                                <span>Pengabdian</span>
                            </button>
                            <button @click="tab = 'prestasi'"
                                :class="tab === 'prestasi' ? 'bg-[#4B83BF] text-white' : 'text-white hover:bg-gray-500'"
                                class="w-full text-left px-4 py-2 rounded flex items-center gap-2 font-medium transition">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                    class="size-6">
                                    <path fill-rule="evenodd"
                                        d="M5.166 2.621v.858c-1.035.148-2.059.33-3.071.543a.75.75 0 0 0-.584.859 6.753 6.753 0 0 0 6.138 5.6 6.73 6.73 0 0 0 2.743 1.346A6.707 6.707 0 0 1 9.279 15H8.54c-1.036 0-1.875.84-1.875 1.875V19.5h-.75a2.25 2.25 0 0 0-2.25 2.25c0 .414.336.75.75.75h15a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-2.25-2.25h-.75v-2.625c0-1.036-.84-1.875-1.875-1.875h-.739a6.706 6.706 0 0 1-1.112-3.173 6.73 6.73 0 0 0 2.743-1.347 6.753 6.753 0 0 0 6.139-5.6.75.75 0 0 0-.585-.858 47.077 47.077 0 0 0-3.07-.543V2.62a.75.75 0 0 0-.658-.744 49.22 49.22 0 0 0-6.093-.377c-2.063 0-4.096.128-6.093.377a.75.75 0 0 0-.657.744Zm0 2.629c0 1.196.312 2.32.857 3.294A5.266 5.266 0 0 1 3.16 5.337a45.6 45.6 0 0 1 2.006-.343v.256Zm13.5 0v-.256c.674.1 1.343.214 2.006.343a5.265 5.265 0 0 1-2.863 3.207 6.72 6.72 0 0 0 .857-3.294Z"
                                        clip-rule="evenodd" />
                                </svg>
                                <span>Prestasi</span>
                            </button>
                            <button @click="tab = 'sertifikasi'"
                                :class="tab === 'sertifikasi' ? 'bg-[#4B83BF] text-white' : 'text-white hover:bg-gray-500'"
                                class="w-full text-left px-4 py-2 rounded flex items-center gap-2 font-medium transition">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                    class="size-6">
                                    <path
                                        d="M11.7 2.805a.75.75 0 0 1 .6 0A60.65 60.65 0 0 1 22.83 8.72a.75.75 0 0 1-.231 1.337 49.948 49.948 0 0 0-9.902 3.912l-.003.002c-.114.06-.227.119-.34.18a.75.75 0 0 1-.707 0A50.88 50.88 0 0 0 7.5 12.173v-.224c0-.131.067-.248.172-.311a54.615 54.615 0 0 1 4.653-2.52.75.75 0 0 0-.65-1.352 56.123 56.123 0 0 0-4.78 2.589 1.858 1.858 0 0 0-.859 1.228 49.803 49.803 0 0 0-4.634-1.527.75.75 0 0 1-.231-1.337A60.653 60.653 0 0 1 11.7 2.805Z" />
                                    <path
                                        d="M13.06 15.473a48.45 48.45 0 0 1 7.666-3.282c.134 1.414.22 2.843.255 4.284a.75.75 0 0 1-.46.711 47.87 47.87 0 0 0-8.105 4.342.75.75 0 0 1-.832 0 47.87 47.87 0 0 0-8.104-4.342.75.75 0 0 1-.461-.71c.035-1.442.121-2.87.255-4.286.921.304 1.83.634 2.726.99v1.27a1.5 1.5 0 0 0-.14 2.508c-.09.38-.222.753-.397 1.11.452.213.901.434 1.346.66a6.727 6.727 0 0 0 .551-1.607 1.5 1.5 0 0 0 .14-2.67v-.645a48.549 48.549 0 0 1 3.44 1.667 2.25 2.25 0 0 0 2.12 0Z" />
                                    <path
                                        d="M4.462 19.462c.42-.419.753-.89 1-1.395.453.214.902.435 1.347.662a6.742 6.742 0 0 1-1.286 1.794.75.75 0 0 1-1.06-1.06Z" />
                                </svg>
                                <span>Sertifikasi</span>
                            </button>
                            <button @click="tab = 'download'"
                                :class="tab === 'download' ? 'bg-[#4B83BF] text-white' : 'text-white hover:bg-gray-500'"
                                class="w-full text-left px-4 py-2 rounded flex items-center gap-2 font-medium transition">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                    class="size-6">
                                    <path
                                        d="M3.375 3C2.339 3 1.5 3.84 1.5 4.875v.75c0 1.036.84 1.875 1.875 1.875h17.25c1.035 0 1.875-.84 1.875-1.875v-.75C22.5 3.839 21.66 3 20.625 3H3.375Z" />
                                    <path fill-rule="evenodd"
                                        d="m3.087 9 .54 9.176A3 3 0 0 0 6.62 21h10.757a3 3 0 0 0 2.995-2.824L20.913 9H3.087ZM12 10.5a.75.75 0 0 1 .75.75v4.94l1.72-1.72a.75.75 0 1 1 1.06 1.06l-3 3a.75.75 0 0 1-1.06 0l-3-3a.75.75 0 1 1 1.06-1.06l1.72 1.72v-4.94a.75.75 0 0 1 .75-.75Z"
                                        clip-rule="evenodd" />
                                </svg>
                                <span>Download</span>
                            </button>
                        </nav>
                    </div>
                </aside>
                {{-- Main Content --}}
                <main class="flex-1 p-4 md:p-8">
                    <div x-show="tab === 'validasi_event'">
                        @include('dashboard.validasi_event_user')
                    </div>
                    <div x-show="tab === 'validasi_user'">
                        @include('dashboard.validasi_user')
                    </div>
                    <div x-show="tab === 'user'">
                        @include('dashboard.user')
                    </div>
                    <div x-show="tab === 'event'">
                        @include('dashboard.event')
                    </div>
                    <div x-show="tab === 'oprek'">
                        @include('dashboard.oprek')
                    </div>
                    <div x-show="tab === 'portofolio'">
                        @include('dashboard.portofolio')
                    </div>
                    <div x-show="tab === 'pengabdian'">
                        @include('dashboard.pengabdian')
                    </div>
                    <div x-show="tab === 'prestasi'">
                        @include('dashboard.prestasi')
                    </div>
                    <div x-show="tab === 'sertifikasi'">
                        @include('dashboard.sertifikasi')
                    </div>
                    <div x-show="tab === 'download'">
                        @include('dashboard.download')
                    </div>
                </main>
            </div>
    @endif
    @include('dashboard.footer')

</body>

</html>
