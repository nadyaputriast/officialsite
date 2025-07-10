<x-app-layout>
    <div class="py-8">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-xl">
                <div class="p-8">
                    {{-- Header Section --}}
                    <div class="border-b border-gray-200 pb-6 mb-8">
                        <div class="flex items-center justify-between mb-4">
                            <h1 class="text-3xl font-bold text-gray-900">{{ $oprek->nama_project }}</h1>
                            <div class="flex items-center space-x-2">
                                @if ($oprek->status_project == 1)
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                        </svg>
                                        Sudah Divalidasi
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                                        </svg>
                                        Belum Divalidasi
                                    </span>
                                @endif
                            </div>
                        </div>
                        <p class="text-gray-600 text-lg leading-relaxed">{{ $oprek->deskripsi_project }}</p>
                    </div>

                    {{-- Main Content Grid --}}
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                        {{-- Left Column - Main Content --}}
                        <div class="lg:col-span-2 space-y-8">
                            {{-- Flyer Informasi Section --}}
                            @if ($oprek->flyer_informasi)
                                <div class="bg-gray-50 rounded-lg p-6">
                                    <h3 class="text-xl font-semibold text-gray-900 mb-4 flex items-center">
                                        <svg class="w-5 h-5 mr-2 text-[#4B83BF]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        Flyer Informasi
                                    </h3>
                                    <div class="group relative overflow-hidden rounded-lg shadow-md hover:shadow-lg transition-all duration-300">
                                        <img src="{{ Storage::url($oprek->flyer_informasi) }}" 
                                            alt="Flyer Informasi"
                                            class="w-full max-w-md object-cover group-hover:scale-105 transition-transform duration-300">
                                        <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 transition-opacity duration-300"></div>
                                    </div>
                                </div>
                            @endif

                            {{-- Output Project Section --}}
                            <div class="bg-gray-50 rounded-lg p-6">
                                <h3 class="text-xl font-semibold text-gray-900 mb-4 flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-[#4B83BF]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    Output Project
                                </h3>
                                <p class="text-gray-700 leading-relaxed">{{ $oprek->output_project }}</p>
                            </div>

                            {{-- Kualifikasi Section --}}
                            @if ($oprek->kualifikasi->isNotEmpty())
                                <div class="bg-gray-50 rounded-lg p-6">
                                    <h3 class="text-xl font-semibold text-gray-900 mb-4 flex items-center">
                                        <svg class="w-5 h-5 mr-2 text-[#4B83BF]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                                        </svg>
                                        Kualifikasi
                                    </h3>
                                    <ul class="space-y-2">
                                        @foreach ($oprek->kualifikasi as $kualifikasi)
                                            <li class="flex items-start">
                                                <svg class="w-4 h-4 mt-0.5 mr-2 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                                </svg>
                                                <span class="text-gray-700">{{ $kualifikasi->kualifikasi_oprek }}</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </div>

                        {{-- Right Column - Sidebar --}}
                        <div class="space-y-6">
                            {{-- Project Info Card --}}
                            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg p-6 border border-blue-100">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Project</h3>
                                <div class="space-y-3">
                                    <div class="flex items-center justify-between">
                                        <span class="text-gray-600 flex items-center">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                            </svg>
                                            Kategori
                                        </span>
                                        <span class="font-semibold text-gray-900">{{ $oprek->kategori_project }}</span>
                                    </div>
                                </div>
                            </div>

                            {{-- Tautan Section --}}
                            <div class="bg-white border border-gray-200 rounded-lg p-6">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                                    </svg>
                                    Tautan
                                </h3>
                                <a href="{{ $oprek->tautan_project }}" target="_blank" rel="noopener noreferrer"
                                    class="block p-3 rounded-lg bg-gray-50 hover:bg-blue-50 transition-colors duration-200">
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                        </svg>
                                        <span class="text-blue-600 hover:text-blue-800 text-sm font-medium">Kunjungi Informasi</span>
                                    </div>
                                </a>
                            </div>

                            {{-- Penyelenggara Section --}}
                            <div class="bg-white border border-gray-200 rounded-lg p-6">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-[#4B83BF]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                    </svg>
                                    Penyelenggara
                                </h3>
                                <div class="space-y-3">
                                    <div class="p-3 rounded-lg bg-gray-50">
                                        <div class="text-sm text-gray-600 mb-1">Organisasi</div>
                                        <div class="font-medium text-gray-900">
                                            {{ $oprek->penyelenggara ?: 'Tidak ada informasi penyelenggara' }}
                                        </div>
                                    </div>
                                    <div class="p-3 rounded-lg bg-gray-50">
                                        <div class="text-sm text-gray-600 mb-1">Nama Penyelenggara</div>
                                        <div class="font-medium text-gray-900">
                                            {{ $oprek->nama_penyelenggara ?: 'Tidak ada informasi nama penyelenggara' }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Admin Section --}}
                    @php
                        $notif = \App\Models\Notifikasi::where('notifiable_id', $oprek->id_oprek)
                            ->where('notifiable_type', 'oprek_loker_project')
                            ->latest()
                            ->first();
                    @endphp

                    @if (auth()->user()->hasRole('admin') || ($notif && $oprek->status_project == 0))
                        <div class="mt-8 bg-amber-50 border border-amber-200 rounded-lg p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Komentar/Validasi Admin
                            </h3>

                            @if ($oprek->status_project == 1)
                                <p class="text-gray-600 italic">-</p>
                            @else
                                @if (auth()->user()->hasRole('admin'))
                                    <form action="{{ route('oprek.komentar', $oprek->id_oprek) }}" method="POST" class="mb-4">
                                        @csrf
                                        <textarea name="isi_notifikasi" 
                                            class="w-full border-gray-300 rounded-md shadow-sm focus:ring-[#4B83BF] mb-3" 
                                            rows="4" 
                                            placeholder="Tulis komentar atau catatan untuk oprek ini..."
                                            required>{{ $notif->isi_notifikasi ?? '' }}</textarea>
                                        <button type="submit" class="px-4 py-2 bg-[#4B83BF] hover:bg-[#5a93c7] text-white rounded-lg transition-colors duration-200">
                                            {{ $notif ? 'Ubah Komentar' : 'Tambah Komentar' }}
                                        </button>
                                    </form>
                                    @if ($notif && $notif->is_read)
                                        <div class="text-sm text-green-600 mb-2 flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                            </svg>
                                            Komentar sudah dibaca oleh user, Anda bisa mengubah komentar.
                                        </div>
                                    @elseif($notif)
                                        <div class="text-sm text-yellow-600 mb-2 flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                                            </svg>
                                            Komentar belum dibaca oleh user.
                                        </div>
                                    @endif
                                @elseif($notif)
                                    <div class="bg-white border-l-4 border-blue-400 p-4 mb-4 rounded-r-lg">
                                        <p class="text-gray-700">{{ $notif->isi_notifikasi }}</p>
                                    </div>
                                    @if (!$notif->is_read)
                                        <form action="{{ route('notifikasi.read', $notif->id_notifikasi) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="px-3 py-1 text-sm text-[#4B83BF] rounded-lg hover:bg-blue-50 transition-colors duration-200">
                                                Tandai sudah dibaca
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-sm text-green-600 flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                            </svg>
                                            Sudah dibaca
                                        </span>
                                    @endif
                                @endif
                            @endif
                        </div>
                    @endif

                    {{-- Action Buttons --}}
                    <div class="mt-8 flex flex-wrap gap-3 justify-end border-t border-gray-200 pt-6">
                        {{-- Admin Validate Button --}}
                        @if (auth()->user()->hasRole('admin') && $oprek->status_project == 0)
                            <form action="{{ route('admin.oprek.validate', $oprek->id_oprek) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors duration-200 flex items-center">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Validasi Oprek
                                </button>
                            </form>
                        @endif

                        {{-- Edit Button --}}
                        @if (auth()->id() === $oprek->id_pengguna)
                            <a href="{{ route('oprek.edit', $oprek->id_oprek) }}"
                                class="px-6 py-2 bg-[#4B83BF] hover:bg-[#5a93c7] text-white rounded-lg transition-colors duration-200 flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                                Edit Oprek
                            </a>
                        @endif

                        {{-- Back Button --}}
                        <a href="{{ route('dashboard') }}"
                            class="px-6 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors duration-200 flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>