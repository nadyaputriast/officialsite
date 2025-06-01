{{-- filepath: c:\laragon\www\officialsite\resources\views\portofolio\index.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @if($selectedKategori)
                {{ __('Portofolio') }} - {{ $selectedKategori }}
            @else
                {{ __('Semua Portofolio') }}
            @endif
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Breadcrumb & Info --}}
            <div class="mb-6">
                <div class="flex items-center gap-2 text-sm text-gray-600 mb-2">
                    <a href="{{ route('dashboard') }}" class="hover:text-blue-600">Dashboard</a>
                    <span>›</span>
                    <a href="{{ route('portofolio.index') }}" class="hover:text-blue-600">Portofolio</a>
                    @if($selectedKategori)
                        <span>›</span>
                        <span class="text-blue-600 font-medium">{{ $selectedKategori }}</span>
                    @endif
                </div>
                
                <div class="flex justify-between items-center">
                    <div>
                        @if($selectedKategori)
                            <h1 class="text-2xl font-bold text-gray-900">Portofolio {{ $selectedKategori }}</h1>
                            <p class="text-gray-600">{{ $portofolio->total() }} proyek ditemukan</p>
                        @else
                            <h1 class="text-2xl font-bold text-gray-900">Semua Portofolio</h1>
                            <p class="text-gray-600">{{ $portofolio->total() }} total proyek</p>
                        @endif
                    </div>
                    
                    @auth
                        <a href="{{ route('portofolio.create') }}" 
                           class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition font-medium">
                            + Tambah Portofolio
                        </a>
                    @endauth
                </div>
            </div>

            {{-- Filter Kategori --}}
            <div class="mb-8 bg-white rounded-lg shadow-sm p-6">
                <h3 class="font-semibold mb-4">Filter berdasarkan Kategori:</h3>
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('portofolio.index') }}" 
                       class="px-4 py-2 rounded-lg text-sm font-medium transition {{ !$selectedKategori ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                        Semua ({{ $portofolio->total() }})
                    </a>
                    @foreach(['UI/UX Design', 'Website Development', 'Mobile Development', 'Game Development', 'Internet of Things', 'ML/AI', 'Blockchain', 'Cyber Security'] as $kategori)
                        @php
                            $count = \App\Models\Portofolio::whereHas('kategori', function($q) use ($kategori) {
                                $q->where('kategori_portofolio', $kategori);
                            })->where('status_portofolio', true)->count();
                        @endphp
                        <a href="{{ route('portofolio.index', ['kategori' => $kategori]) }}" 
                           class="px-4 py-2 rounded-lg text-sm font-medium transition {{ $selectedKategori == $kategori ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                            {{ $kategori }} ({{ $count }})
                        </a>
                    @endforeach
                </div>
            </div>

            {{-- Grid Portofolio --}}
            @if($portofolio->count() > 0)
                <div class="grid md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    @foreach($portofolio as $item)
                        <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition group">
                            {{-- Gambar --}}
                            <div class="aspect-video bg-gray-200 overflow-hidden">
                                @if($item->gambar && $item->gambar->first())
                                    <img src="{{ asset('storage/' . $item->gambar->first()->gambar_portofolio) }}" 
                                         alt="{{ $item->nama_portofolio }}"
                                         class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-400">
                                    </div>
                                @endif
                            </div>
                            
                            {{-- Content --}}
                            <div class="p-4">
                                <h3 class="font-semibold text-lg mb-2 line-clamp-2">
                                    {{ $item->nama_portofolio }}
                                </h3>
                                
                                <p class="text-gray-600 text-sm mb-3 line-clamp-3">
                                    {{ $item->deskripsi_portofolio }}
                                </p>
                                
                                {{-- Kategori Tags --}}
                                <div class="flex flex-wrap gap-1 mb-3">
                                    @foreach($item->kategori as $kat)
                                        <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs rounded-full">
                                            {{ $kat->kategori_portofolio }}
                                        </span>
                                    @endforeach
                                </div>
                                
                                {{-- Stats & Owner --}}
                                <div class="flex justify-between items-center text-sm text-gray-500 mb-4">
                                    <span class="flex items-center gap-1">
                                        {{ $item->view_count ?? 0 }}
                                    </span>
                                    <span class="flex items-center gap-1">
                                        {{ $item->banyak_upvote ?? 0 }}
                                    </span>
                                </div>

                                <div class="text-xs text-gray-500 mb-3">
                                    by <span class="font-medium">{{ $item->owner->nama_pengguna ?? 'Unknown' }}</span>
                                </div>
                                
                                {{-- Actions --}}
                                <div class="flex gap-2">
                                    <a href="{{ route('portofolio.show', $item->id_portofolio) }}" 
                                       class="flex-1 bg-blue-600 text-white text-center px-3 py-2 rounded text-sm hover:bg-blue-700 transition font-medium">
                                        Lihat Detail
                                    </a>
                                    @auth
                                        @if(auth()->id() == $item->id_pengguna)
                                            <a href="{{ route('portofolio.edit', $item->id_portofolio) }}" 
                                               class="bg-green-600 text-white px-3 py-2 rounded text-sm hover:bg-green-700 transition">
                                                Edit
                                            </a>
                                        @endif
                                    @endauth
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Pagination --}}
                <div class="mt-8">
                    {{ $portofolio->appends(request()->query())->links() }}
                </div>
            @else
                {{-- Empty State --}}
                <div class="text-center py-16">
                    <div class="max-w-md mx-auto">
                        <div class="text-gray-400 mb-4">
                        </div>
                        @if($selectedKategori)
                            <h3 class="text-xl font-semibold text-gray-900 mb-2">
                                Belum ada portofolio {{ $selectedKategori }}
                            </h3>
                            <p class="text-gray-600 mb-6">
                                Jadilah yang pertama membuat portofolio di kategori ini!
                            </p>
                            <div class="flex gap-3 justify-center">
                                <a href="{{ route('portofolio.index') }}" 
                                   class="bg-gray-600 text-white px-6 py-3 rounded-lg hover:bg-gray-700 transition">
                                    Lihat Semua Portofolio
                                </a>
                                @auth
                                    <a href="{{ route('portofolio.create') }}" 
                                       class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition">
                                        + Tambah Portofolio
                                    </a>
                                @endauth
                            </div>
                        @else
                            <h3 class="text-xl font-semibold text-gray-900 mb-2">
                                Belum ada portofolio
                            </h3>
                            <p class="text-gray-600 mb-6">
                                Jadilah yang pertama menambahkan portofolio!
                            </p>
                            @auth
                                <a href="{{ route('portofolio.create') }}" 
                                   class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition">
                                    + Tambah Portofolio
                                </a>
                            @endauth
                        @endif
                    </div>
                </div>
            @endif
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