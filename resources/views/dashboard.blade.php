<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard ' . ucfirst(Auth::user()->getRoleNames()->first())) }}
        </h2>

        @include('dashboard.notifikasi')

        @if (!auth()->user()->hasRole('admin'))
            {{-- Banner --}}
            <x-banner-component />
            @include ('dashboard.navbar')
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
                                            <p class="text-2xl font-bold text-blue-600 mt-1">{{ $kategori['jumlah'] }}
                                            </p>
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

            @include('dashboard.portofolio')

            @include('dashboard.event')

            @include('dashboard.oprek')

            @include('dashboard.download')
        @else
            {{-- SIDEBAR ADMIN --}}
            <div x-data="{ tab: 'validasi_user' }" class="flex min-h-screen bg-gray-50">
                {{-- Sidebar --}}
                <aside class="w-64 bg-white border-r border-gray-200 flex-shrink-0 hidden md:block">
                    <div class="h-full flex flex-col py-6 px-4">
                        <div class="mb-8">
                            <span class="text-lg font-bold text-blue-700">Admin Panel</span>
                        </div>
                        <nav class="flex-1 space-y-2">
                            <button @click="tab = 'validasi_user'"
                                :class="tab === 'validasi_user' ? 'bg-blue-100 text-blue-700' : 'text-gray-700 hover:bg-gray-100'"
                                class="w-full text-left px-4 py-2 rounded flex items-center gap-2 font-medium transition">
                                <span>✅</span> Validasi User
                            </button>
                            <button @click="tab = 'validasi_event'"
                                :class="tab === 'validasi_event' ? 'bg-blue-100 text-blue-700' : 'text-gray-700 hover:bg-gray-100'"
                                class="w-full text-left px-4 py-2 rounded flex items-center gap-2 font-medium transition">
                                <span>✅</span> Validasi Event
                            </button>
                            <button @click="tab = 'user'"
                                :class="tab === 'user' ? 'bg-blue-100 text-blue-700' : 'text-gray-700 hover:bg-gray-100'"
                                class="w-full text-left px-4 py-2 rounded flex items-center gap-2 font-medium transition">
                                <span>👤</span> User
                            </button>
                            <button @click="tab = 'event'"
                                :class="tab === 'event' ? 'bg-blue-100 text-blue-700' : 'text-gray-700 hover:bg-gray-100'"
                                class="w-full text-left px-4 py-2 rounded flex items-center gap-2 font-medium transition">
                                <span>📅</span> Event
                            </button>
                            <button @click="tab = 'oprek'"
                                :class="tab === 'oprek' ? 'bg-blue-100 text-blue-700' : 'text-gray-700 hover:bg-gray-100'"
                                class="w-full text-left px-4 py-2 rounded flex items-center gap-2 font-medium transition">
                                <span>💼</span> Hiring
                            </button>
                            <button @click="tab = 'portofolio'"
                                :class="tab === 'portofolio' ? 'bg-blue-100 text-blue-700' : 'text-gray-700 hover:bg-gray-100'"
                                class="w-full text-left px-4 py-2 rounded flex items-center gap-2 font-medium transition">
                                <span>📁</span> Project
                            </button>
                            <button @click="tab = 'pengabdian'"
                                :class="tab === 'pengabdian' ? 'bg-blue-100 text-blue-700' : 'text-gray-700 hover:bg-gray-100'"
                                class="w-full text-left px-4 py-2 rounded flex items-center gap-2 font-medium transition">
                                <span>🤝</span> Pengabdian
                            </button>
                            <button @click="tab = 'prestasi'"
                                :class="tab === 'prestasi' ? 'bg-blue-100 text-blue-700' : 'text-gray-700 hover:bg-gray-100'"
                                class="w-full text-left px-4 py-2 rounded flex items-center gap-2 font-medium transition">
                                <span>🏆</span> Prestasi
                            </button>
                            <button @click="tab = 'sertifikasi'"
                                :class="tab === 'sertifikasi' ? 'bg-blue-100 text-blue-700' : 'text-gray-700 hover:bg-gray-100'"
                                class="w-full text-left px-4 py-2 rounded flex items-center gap-2 font-medium transition">
                                <span>🎓</span> Sertifikasi
                            </button>
                            <button @click="tab = 'download'"
                                :class="tab === 'download' ? 'bg-blue-100 text-blue-700' : 'text-gray-700 hover:bg-gray-100'"
                                class="w-full text-left px-4 py-2 rounded flex items-center gap-2 font-medium transition">
                                <span>⬇️</span> Download
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
</x-app-layout>
