<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard ' . ucfirst(Auth::user()->getRoleNames()->first())) }}
        </h2>

        {{-- Banner --}}
        <x-banner-component />

        @include ('dashboard.navbar')

        @include('dashboard.notifikasi')

        <div class="py-8">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-2xl font-bold text-gray-900 mb-2">Kategori Proyek</h2>
                    <p class="text-gray-600 mb-6">Lihat Berbagai Kategori Proyek Informatika</p>

                    <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-4">
                        @foreach ($kategoriStats as $kategori)
                            <div
                                class="bg-gradient-to-br from-blue-50 to-indigo-100 rounded-lg p-4 border border-blue-200 hover:shadow-md transition">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h3 class="font-semibold text-gray-900 text-sm">{{ $kategori['nama'] }}</h3>
                                        <p class="text-2xl font-bold text-blue-600 mt-1">{{ $kategori['jumlah'] }}</p>
                                        <p class="text-xs text-gray-500">
                                            {{ $kategori['jumlah'] == 1 ? 'proyek' : 'proyek' }}
                                        </p>
                                    </div>
                                    <div class="text-blue-400">
                                        @switch($kategori['nama'])
                                            @case('UI/UX Design')
                                            @break

                                            @case('Website Development')
                                            @break

                                            @case('Mobile Development')
                                            @break

                                            @case('Game Development')
                                            @break

                                            @case('Internet of Things')
                                            @break

                                            @case('ML/AI')
                                            @break

                                            @case('Blockchain')
                                            @break
                                            
                                            @case('Cyber Security')
                                            @break

                                            @default
                                        @endswitch
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <a href="{{ route('portofolio.index', ['kategori' => $kategori['nama']]) }}"
                                        class="text-blue-600 hover:text-blue-800 text-xs font-medium hover:underline">
                                        Lihat Portofolio Sejenis →
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- Quick Actions --}}
                    <div class="mt-4 flex gap-3">
                        <a href="{{ route('portofolio.index') }}"
                            class="text-blue-600 hover:text-blue-800 text-sm font-medium hover:underline">
                            Lihat Semua Portofolio
                        </a>
                        @auth
                            <a href="{{ route('portofolio.create') }}"
                                class="bg-blue-600 text-white px-4 py-2 rounded text-sm hover:bg-blue-700 transition">
                                + Tambah Portofolio
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>

        @include('dashboard.halloffame')

        @include('dashboard.validasi_event_user') {{-- admin side --}}

        @include('dashboard.portofolio')

        @include('dashboard.event')

        @include('dashboard.oprek')
        
        @include('dashboard.download')

        @include('dashboard.footer')
</x-app-layout>
