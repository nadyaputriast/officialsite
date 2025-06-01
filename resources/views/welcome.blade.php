<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Official Site - Sistem Informasi Akademik</title>
        
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
        
        <!-- Styles -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        {{-- Alpine JS --}}
        <script src="//unpkg.com/alpinejs" defer></script>
    </head>
    <body class="antialiased font-sans bg-gray-100">
        {{-- Navigation Header --}}
        <nav class="bg-white shadow-sm border-b border-gray-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-16">
                    <div class="flex items-center">
                        <h1 class="text-xl font-bold text-gray-900">Official Site</h1>
                    </div>
                    
                    @if (Route::has('login'))
                        <div class="flex items-center gap-4">
                            @auth
                                <a href="{{ route('dashboard') }}" 
                                   class="text-gray-600 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium">
                                    Dashboard
                                </a>
                            @else
                                <a href="{{ route('login') }}" 
                                   class="text-gray-600 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium">
                                    Log in
                                </a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" 
                                       class="bg-blue-600 text-white hover:bg-blue-700 px-4 py-2 rounded-md text-sm font-medium">
                                        Register
                                    </a>
                                @endif
                            @endauth
                        </div>
                    @endif
                </div>
            </div>
        </nav>

        {{-- Hero Section --}}
        <div class="bg-white shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                <div class="text-center">
                    <h1 class="text-3xl font-bold text-gray-900 mb-4">
                        Sistem Informasi Akademik
                    </h1>
                    <p class="text-lg text-gray-600">
                        Portal resmi untuk mengelola portofolio, prestasi, pengabdian, dan sertifikasi
                    </p>
                </div>
            </div>
        </div>

        {{-- Content Sections --}}
        <div class="py-8 space-y-8">
            {{-- Events Section --}}
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-xl font-bold text-gray-900">Event Terbaru</h2>
                        @auth
                            <a href="{{ route('event.create') }}" 
                               class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 text-sm">
                                + Tambah Event
                            </a>
                        @else
                            <span class="text-gray-500 text-sm">Login untuk menambah event</span>
                        @endauth
                    </div>
                    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @forelse($events as $event)
                            <div class="border rounded-lg p-4">
                                <h3 class="font-semibold text-gray-900">{{ $event->nama_event }}</h3>
                                <p class="text-gray-600 text-sm mt-2">{{ $event->deskripsi_event }}</p>
                                <div class="text-xs text-gray-500 mt-2">
                                    {{ $event->tanggal_mulai }} - {{ $event->tanggal_selesai }}
                                </div>
                                <div class="mt-3 flex gap-2">
                                    <a href="{{ route('event.show', $event->id) }}" 
                                       class="text-blue-600 hover:underline text-sm">Lihat Detail</a>
                                    @auth
                                        <a href="{{ route('event.daftar', $event->id) }}" 
                                           class="text-green-600 hover:underline text-sm">Daftar</a>
                                    @else
                                        <a href="{{ route('login') }}" 
                                           class="text-gray-500 hover:underline text-sm">Login untuk Daftar</a>
                                    @endauth
                                </div>
                            </div>
                        @empty
                            <p class="text-gray-500">Belum ada event tersedia.</p>
                        @endforelse
                    </div>
                </div>
            </div>

            {{-- Portofolio Section --}}
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-xl font-bold text-gray-900">Portofolio</h2>
                        @auth
                            <a href="{{ route('portofolio.create') }}" 
                               class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 text-sm">
                                + Tambah Portofolio
                            </a>
                        @else
                            <span class="text-gray-500 text-sm">Login untuk menambah portofolio</span>
                        @endauth
                    </div>
                    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @forelse($portofolio as $item)
                            <div class="border rounded-lg p-4">
                                <h3 class="font-semibold text-gray-900">{{ $item->nama_portofolio }}</h3>
                                <p class="text-gray-600 text-sm mt-2">{{ $item->deskripsi_portofolio }}</p>
                                <div class="text-xs text-gray-500 mt-2">
                                    by {{ $item->owner->nama_pengguna ?? 'Unknown' }}
                                </div>
                                <div class="mt-3">
                                    <a href="{{ route('portofolio.show', $item->id) }}" 
                                       class="text-blue-600 hover:underline text-sm">Lihat Detail</a>
                                </div>
                            </div>
                        @empty
                            <p class="text-gray-500">Belum ada portofolio tersedia.</p>
                        @endforelse
                    </div>
                </div>
            </div>

            {{-- Prestasi Section --}}
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-xl font-bold text-gray-900">Prestasi</h2>
                        @auth
                            <a href="{{ route('prestasi.create') }}" 
                               class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 text-sm">
                                + Tambah Prestasi
                            </a>
                        @else
                            <span class="text-gray-500 text-sm">Login untuk menambah prestasi</span>
                        @endauth
                    </div>
                    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @forelse($prestasi as $item)
                            <div class="border rounded-lg p-4">
                                <h3 class="font-semibold text-gray-900">{{ $item->nama_prestasi }}</h3>
                                <p class="text-gray-600 text-sm mt-2">{{ $item->deskripsi_prestasi }}</p>
                                <div class="text-xs text-gray-500 mt-2">
                                    by {{ $item->owner->nama_pengguna ?? 'Unknown' }}
                                </div>
                                <div class="mt-3">
                                    <a href="{{ route('prestasi.show', $item->id) }}" 
                                       class="text-blue-600 hover:underline text-sm">Lihat Detail</a>
                                </div>
                            </div>
                        @empty
                            <p class="text-gray-500">Belum ada prestasi tersedia.</p>
                        @endforelse
                    </div>
                </div>
            </div>

            {{-- Pengabdian Section --}}
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-xl font-bold text-gray-900">Pengabdian Masyarakat</h2>
                        @auth
                            <a href="{{ route('pengabdian.create') }}" 
                               class="bg-purple-500 text-white px-4 py-2 rounded hover:bg-purple-600 text-sm">
                                + Tambah Pengabdian
                            </a>
                        @else
                            <span class="text-gray-500 text-sm">Login untuk menambah pengabdian</span>
                        @endauth
                    </div>
                    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @forelse($pengabdian as $item)
                            <div class="border rounded-lg p-4">
                                <h3 class="font-semibold text-gray-900">{{ $item->judul_pengabdian }}</h3>
                                <p class="text-gray-600 text-sm mt-2">{{ $item->deskripsi_pengabdian }}</p>
                                <div class="text-xs text-gray-500 mt-2">
                                    by {{ $item->owner->nama_pengguna ?? 'Unknown' }}
                                </div>
                                <div class="mt-3">
                                    <a href="{{ route('pengabdian.show', $item->id) }}" 
                                       class="text-blue-600 hover:underline text-sm">Lihat Detail</a>
                                </div>
                            </div>
                        @empty
                            <p class="text-gray-500">Belum ada pengabdian tersedia.</p>
                        @endforelse
                    </div>
                </div>
            </div>

            {{-- Sertifikasi Section --}}
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-xl font-bold text-gray-900">Sertifikasi</h2>
                        @auth
                            <a href="{{ route('sertifikasi.create') }}" 
                               class="bg-orange-500 text-white px-4 py-2 rounded hover:bg-orange-600 text-sm">
                                + Tambah Sertifikasi
                            </a>
                        @else
                            <span class="text-gray-500 text-sm">Login untuk menambah sertifikasi</span>
                        @endauth
                    </div>
                    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @forelse($sertifikasi as $item)
                            <div class="border rounded-lg p-4">
                                <h3 class="font-semibold text-gray-900">{{ $item->nama_sertifikasi }}</h3>
                                <p class="text-gray-600 text-sm mt-2">{{ $item->deskripsi_sertifikasi }}</p>
                                <div class="text-xs text-gray-500 mt-2">
                                    by {{ $item->owner->nama_pengguna ?? 'Unknown' }}
                                </div>
                                <div class="mt-3">
                                    <a href="{{ route('sertifikasi.show', $item->id) }}" 
                                       class="text-blue-600 hover:underline text-sm">Lihat Detail</a>
                                </div>
                            </div>
                        @empty
                            <p class="text-gray-500">Belum ada sertifikasi tersedia.</p>
                        @endforelse
                    </div>
                </div>
            </div>

            {{-- Download Section --}}
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-xl font-bold text-gray-900">File Download</h2>
                        @auth
                            <a href="{{ route('download.create') }}" 
                               class="bg-indigo-500 text-white px-4 py-2 rounded hover:bg-indigo-600 text-sm">
                                + Upload File
                            </a>
                        @else
                            <span class="text-gray-500 text-sm">Login untuk upload file</span>
                        @endauth
                    </div>
                    <div class="space-y-3">
                        @forelse($downloads as $file)
                            <div class="flex justify-between items-center border rounded-lg p-3">
                                <div>
                                    <h3 class="font-medium text-gray-900">{{ $file->nama_file }}</h3>
                                    <p class="text-sm text-gray-600">{{ $file->deskripsi_file }}</p>
                                    <div class="text-xs text-gray-500">
                                        Ukuran: {{ number_format($file->ukuran_file / 1024, 2) }} KB
                                    </div>
                                </div>
                                <div class="flex gap-2">
                                    {{-- Download bisa tanpa login --}}
                                    <a href="{{ route('download.file', $file->id) }}" 
                                       class="bg-blue-500 text-white px-3 py-1 rounded text-sm hover:bg-blue-600">
                                        Download
                                    </a>
                                    @auth
                                        @if(auth()->id() == $file->id_uploader)
                                            <a href="{{ route('download.edit', $file->id) }}" 
                                               class="text-blue-600 hover:underline text-sm">Edit</a>
                                        @endif
                                    @endauth
                                </div>
                            </div>
                        @empty
                            <p class="text-gray-500">Belum ada file tersedia untuk download.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        {{-- Footer --}}
        <footer class="bg-gray-800 text-white py-8 mt-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <p>&copy; 2025 Official Site. All rights reserved.</p>
            </div>
        </footer>
    </body>
</html>