<header class="bg-white shadow-lg sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
        {{-- Logo --}}
        <a href="#" class="flex items-center space-x-2">
            <img src="{{ asset('images/saturuang.png') }}" alt="Logo" class="h-10 w-auto">
            <span class="font-bold text-black">
                Satu<span class="text-blue-600">Ruang</span>
            </span>
        </a>

        {{-- Navigation Links --}}
        <div class="flex-1 flex justify-center space-x-4">
            <a href="#" class="text-black hover:text-blue-600">Home</a>
            @auth
                @if (auth()->user()->hasRole('admin'))
                    <a href="#pembayaran-section" class="text-black hover:text-blue-600">Pembayaran Event</a>
                    <a href="#user-section" class="text-black hover:text-blue-600">User</a>
                    <a href="#event-section" class="text-black hover:text-blue-600">Event</a>
                    <a href="#oprek-section" class="text-black hover:text-blue-600">Hiring</a>
                    <a href="#portofolio-section" class="text-black hover:text-blue-600">Project</a>
                    <a href="#pengabdian-section" class="text-black hover:text-blue-600">Pengabdian</a>
                    <a href="#prestasi-section" class="text-black hover:text-blue-600">Prestasi</a>
                    <a href="#sertifikasi-section" class="text-black hover:text-blue-600">Sertifikasi</a>
                    <a href="#download-section" class="text-black hover:text-blue-600">Download</a>
                @else
                    <a href="#portofolio-section" class="text-black hover:text-blue-600">Project</a>
                    <a href="#event-section" class="text-black hover:text-blue-600">Event</a>
                    <a href="#oprek-section" class="text-black hover:text-blue-600">Hiring</a>
                    <a href="#download-section" class="text-black hover:text-blue-600">Download</a>
                @endif
            @else
                <a href="#portofolio-section" class="text-black hover:text-blue-600">Project</a>
                <a href="#event-section" class="text-black hover:text-blue-600">Event</a>
                <a href="#oprek-section" class="text-black hover:text-blue-600">Hiring</a>
                <a href="#download-section" class="text-black hover:text-blue-600">Download</a>
            @endauth
        </div>

        <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
            @auth
                {{-- Link ke Dashboard --}}
                <a href="{{ route('dashboard') }}" class="text-black hover:text-blue-600 text-center">
                    Dashboard
                </a>

                {{-- Tampilkan notifikasi jika berada di halaman dashboard --}}
                @if (request()->routeIs('dashboard*'))
                    @include('dashboard.notifikasi')
                @endif

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
            @else
                {{-- Jika belum login --}}
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
</header>
