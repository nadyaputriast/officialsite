<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @if ($selectedKategori)
                {{ __('Portofolio') }} - {{ $selectedKategori }}
            @else
                {{ __('Semua Portofolio') }}
            @endif
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Breadcrumb & Header Section --}}
            <div class="mb-8">
                <!-- Breadcrumb -->
                <nav class="flex items-center gap-2 text-sm text-gray-600 mb-4">
                    <a href="{{ route('dashboard') }}" class="hover:text-[#4B83BF] transition-colors">Dashboard</a>
                    <span>›</span>
                    <a href="{{ route('portofolio.index') }}" class="hover:text-[#4B83BF] transition-colors">Portofolio</a>
                    @if ($selectedKategori)
                        <span>›</span>
                        <span class="text-[#4B83BF] font-medium">{{ $selectedKategori }}</span>
                    @endif
                </nav>

                <!-- Header Info -->
                <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
                    <div>
                        @if ($selectedKategori)
                            <h1 class="text-3xl font-bold text-gray-900 mb-2">Portofolio {{ $selectedKategori }}</h1>
                            <p class="text-gray-600">{{ $portofolio->total() }} proyek ditemukan</p>
                        @else
                            <h1 class="text-3xl font-bold text-gray-900 mb-2">Semua Portofolio</h1>
                            <p class="text-gray-600">{{ $portofolio->total() }} total proyek</p>
                        @endif
                    </div>

                    @auth
                        <a href="{{ route('portofolio.create') }}"
                            class="bg-[#4B83BF] text-white px-6 py-3 rounded-lg hover:bg-[#5a93c7] transition-colors font-medium shadow-md">
                            + Tambah Portofolio
                        </a>
                    @endauth
                </div>
            </div>

            {{-- Category Filter Section --}}
            <div class="mb-8 bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                <h3 class="font-semibold text-gray-900 mb-4">Filter berdasarkan Kategori:</h3>
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('portofolio.index') }}"
                        class="px-4 py-2 rounded-lg text-sm font-medium transition-colors {{ !$selectedKategori ? 'bg-[#4B83BF] text-white shadow-md' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                        Semua ({{ $portofolio->total() }})
                    </a>
                    @foreach (['UI/UX Design', 'Website Development', 'Mobile Development', 'Game Development', 'Internet of Things', 'ML/AI', 'Blockchain', 'Cyber Security'] as $kategori)
                        @php
                            $count = \App\Models\Portofolio::whereHas('kategori', function ($q) use ($kategori) {
                                $q->where('kategori_portofolio', $kategori);
                            })
                                ->where('status_portofolio', true)
                                ->count();
                        @endphp
                        <a href="{{ route('portofolio.index', ['kategori' => $kategori]) }}"
                            class="px-4 py-2 rounded-lg text-sm font-medium transition-colors {{ $selectedKategori == $kategori ? 'bg-[#4B83BF] text-white shadow-md' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                            {{ $kategori }} ({{ $count }})
                        </a>
                    @endforeach
                </div>
            </div>

            {{-- Portfolio Grid Section --}}
            @if ($portofolio->count() > 0)
                {{-- White Background Container for Portfolio Grid --}}
                <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 mb-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                        @foreach ($portofolio as $item)
                            <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition-shadow duration-300 group border border-gray-100">
                                {{-- Portfolio Image --}}
                                <div class="aspect-video bg-gray-200 overflow-hidden">
                                    @if ($item->gambar && $item->gambar->first())
                                        <img src="{{ asset('storage/' . $item->gambar->first()->gambar_portofolio) }}"
                                            alt="{{ $item->nama_portofolio }}"
                                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-gray-400">
                                            <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                        </div>
                                    @endif
                                </div>

                                {{-- Portfolio Content --}}
                                <div class="p-5">
                                    <h3 class="font-semibold text-lg text-gray-900 mb-2 line-clamp-2">
                                        {{ $item->nama_portofolio }}
                                    </h3>

                                    <p class="text-gray-600 text-sm mb-3 line-clamp-3">
                                        {{ $item->deskripsi_portofolio }}
                                    </p>

                                    {{-- Category Tags --}}
                                    <div class="flex flex-wrap gap-1 mb-3">
                                        @foreach ($item->kategori as $kat)
                                            <span class="px-3 py-1 bg-blue-50 text-[#4B83BF] text-xs rounded-full font-medium">
                                                {{ $kat->kategori_portofolio }}
                                            </span>
                                        @endforeach
                                    </div>

                                    {{-- Stats --}}
                                    <div class="flex justify-between items-center text-sm text-gray-500 mb-3">
                                        <span class="flex items-center gap-1">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                            {{ $item->view_count ?? 0 }}
                                        </span>
                                        <span class="flex items-center gap-1">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                            </svg>
                                            {{ $item->banyak_upvote ?? 0 }}
                                        </span>
                                    </div>

                                    {{-- Owner Info --}}
                                    <div class="text-xs text-gray-500 mb-4">
                                        by <span class="font-medium text-gray-700">{{ $item->owner->nama_pengguna ?? 'Unknown' }}</span>
                                    </div>

                                    {{-- Action Buttons --}}
                                    <div class="flex gap-2">
                                        <a href="{{ route('portofolio.show', $item->id_portofolio) }}"
                                            class="flex-1 bg-[#4B83BF] text-white text-center px-3 py-2 rounded-lg text-sm hover:bg-[#5a93c7] transition-colors font-medium">
                                            Lihat Detail
                                        </a>
                                        @auth
                                            @if (auth()->id() == $item->id_pengguna)
                                                <a href="{{ route('portofolio.edit', $item->id_portofolio) }}"
                                                    class="bg-green-600 text-white px-3 py-2 rounded-lg text-sm hover:bg-green-700 transition-colors font-medium">
                                                    Edit
                                                </a>
                                            @endif
                                        @endauth
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Pagination --}}
                <div class="flex justify-center">
                    {{ $portofolio->appends(request()->query())->links() }}
                </div>
            @else
                {{-- Empty State --}}
                <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                    <div class="text-center py-16">
                        <div class="max-w-md mx-auto">
                            <div class="text-gray-400 mb-6">
                                <svg class="w-24 h-24 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                </svg>
                            </div>
                            @if ($selectedKategori)
                                <h3 class="text-2xl font-semibold text-gray-900 mb-3">
                                    Belum ada portofolio {{ $selectedKategori }}
                                </h3>
                                <p class="text-gray-600 mb-8">
                                    Jadilah yang pertama membuat portofolio di kategori ini!
                                </p>
                                <div class="flex flex-col sm:flex-row gap-3 justify-center">
                                    <a href="{{ route('portofolio.index') }}"
                                        class="bg-gray-600 text-white px-6 py-3 rounded-lg hover:bg-gray-700 transition-colors font-medium">
                                        Lihat Semua Portofolio
                                    </a>
                                    @auth
                                        <a href="{{ route('portofolio.create') }}"
                                            class="bg-[#4B83BF] text-white px-6 py-3 rounded-lg hover:bg-[#5a93c7] transition-colors font-medium">
                                            + Tambah Portofolio
                                        </a>
                                    @endauth
                                </div>
                            @else
                                <h3 class="text-2xl font-semibold text-gray-900 mb-3">
                                    Belum ada portofolio
                                </h3>
                                <p class="text-gray-600 mb-8">
                                    Jadilah yang pertama menambahkan portofolio!
                                </p>
                                @auth
                                    <a href="{{ route('portofolio.create') }}"
                                        class="bg-[#4B83BF] text-white px-6 py-3 rounded-lg hover:bg-[#5a93c7] transition-colors font-medium">
                                        + Tambah Portofolio
                                    </a>
                                @endauth
                            @endif
                        </div>
                    </div>
                </div>
            @endif

            {{-- Back Button --}}
            <div class="mt-8 pt-6 border-t border-gray-200">
                <a href="{{ route('dashboard') }}"
                    class="inline-flex items-center gap-2 px-6 py-3 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors font-medium">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Kembali ke Dashboard
                </a>
            </div>
        </div>
    </div>
</x-app-layout>

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