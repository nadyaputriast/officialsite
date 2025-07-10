<x-app-layout>
    <div class="py-8">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-xl">
                <div class="p-8">
                    {{-- Header Section --}}
                    <div class="border-b border-gray-200 pb-6 mb-8">
                        <div class="flex items-center justify-between mb-4">
                            <h1 class="text-3xl font-bold text-gray-900">{{ $portofolio->nama_portofolio }}</h1>
                            <div class="flex items-center space-x-2">
                                @if ($portofolio->status_portofolio == 1)
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
                        <p class="text-gray-600 text-lg leading-relaxed">{{ $portofolio->deskripsi_portofolio }}</p>
                    </div>

                    {{-- Main Content Grid --}}
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                        {{-- Left Column - Main Content --}}
                        <div class="lg:col-span-2 space-y-8">
                            {{-- Gambar Section --}}
                            @if ($portofolio->gambar->isNotEmpty())
                                <div class="bg-gray-50 rounded-lg p-6">
                                    <h3 class="text-xl font-semibold text-gray-900 mb-4 flex items-center">
                                        <svg class="w-5 h-5 mr-2 text-[#4B83BF]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        Gambar Portofolio
                                    </h3>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        @foreach ($portofolio->gambar as $gambar)
                                            <div class="group relative overflow-hidden rounded-lg shadow-md hover:shadow-lg transition-all duration-300">
                                                <img src="{{ asset('storage/' . $gambar->gambar_portofolio) }}"
                                                    alt="Gambar Portofolio" 
                                                    class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-300">
                                                <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 transition-opacity duration-300"></div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            {{-- Dokumen Section --}}
                            <div class="bg-gray-50 rounded-lg p-6">
                                <h3 class="text-xl font-semibold text-gray-900 mb-4 flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-bg-[#4B83BF]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    Dokumen
                                </h3>
                                @if (!empty($portofolio->dokumen_portofolio))
                                    <a href="{{ asset('storage/' . $portofolio->dokumen_portofolio) }}" target="_blank"
                                        class="inline-flex items-center px-4 py-2 bg-[#4B83BF] hover:bg-[#5a93c7] text-white rounded-lg transition-colors duration-200">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                        Lihat Dokumen
                                    </a>
                                @else
                                    <p class="text-gray-500 italic">Dokumen tidak tersedia</p>
                                @endif
                            </div>

                            {{-- Komentar Section --}}
                            <div class="bg-white border border-gray-200 rounded-lg p-6">
                                <h3 class="text-xl font-semibold text-gray-900 mb-6 flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-[#4B83BF]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                    </svg>
                                    Komentar
                                </h3>
                                @include('portofolio.komentar.form')
                                @include('portofolio.komentar.list')
                            </div>
                        </div>

                        {{-- Right Column - Sidebar --}}
                        <div class="space-y-6">
                            {{-- Stats Card --}}
                            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg p-6 border border-blue-100">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4">Statistik</h3>
                                <div class="space-y-3">
                                    <div class="flex items-center justify-between">
                                        <span class="text-gray-600 flex items-center">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                            Dilihat
                                        </span>
                                        <span class="font-semibold text-gray-900">{{ $portofolio->view_count }}</span>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <span class="text-gray-600 flex items-center">
                                            <svg class="w-4 h-4 mr-2 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M2 10.5a1.5 1.5 0 113 0v6a1.5 1.5 0 01-3 0v-6zM6 10.333v5.43a2 2 0 001.106 1.79l.05.025A4 4 0 008.943 18h5.416a2 2 0 001.962-1.608l1.2-6A2 2 0 0015.56 8H12V4a2 2 0 00-2-2 1 1 0 00-1 1v.667a4 4 0 01-.8 2.4L6.8 7.933a4 4 0 00-.8 2.4z"></path>
                                            </svg>
                                            Suka
                                        </span>
                                        <span class="font-semibold text-green-600">{{ $portofolio->banyak_upvote }}</span>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <span class="text-gray-600 flex items-center">
                                            <svg class="w-4 h-4 mr-2 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M18 9.5a1.5 1.5 0 11-3 0v-6a1.5 1.5 0 013 0v6zM14 9.667v-5.43a2 2 0 00-1.106-1.79l-.05-.025A4 4 0 0011.055 2H5.64a2 2 0 00-1.962 1.608l-1.2 6A2 2 0 004.44 12H8v4a2 2 0 002 2 1 1 0 001-1v-.667a4 4 0 01.8-2.4l1.4-1.866a4 4 0 00.8-2.4z"></path>
                                            </svg>
                                            Tidak Suka
                                        </span>
                                        <span class="font-semibold text-red-600">{{ $portofolio->banyak_downvote }}</span>
                                    </div>
                                </div>
                            </div>

                            {{-- Vote Buttons --}}
                            @php
                                $userVote = $portofolio->votes->where('id_pengguna', auth()->id())->first();
                            @endphp
                            <div class="bg-white border border-gray-200 rounded-lg p-6">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4">Berikan Penilaian</h3>
                                <div class="flex space-x-3">
                                    <form action="{{ route('portofolio.upvote', $portofolio->id_portofolio) }}" method="POST" class="flex-1">
                                        @csrf
                                        <button type="submit"
                                            class="w-full px-4 py-2 rounded-lg font-medium transition-all duration-200 flex items-center justify-center
                                            {{ $userVote && $userVote->jenis_vote === 'upvote' ? 'bg-green-500 text-white shadow-md' : 'bg-gray-100 text-gray-700 hover:bg-green-50 hover:text-green-600' }}"
                                            {{ $userVote ? 'disabled' : '' }}>
                                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M2 10.5a1.5 1.5 0 113 0v6a1.5 1.5 0 01-3 0v-6zM6 10.333v5.43a2 2 0 001.106 1.79l.05.025A4 4 0 008.943 18h5.416a2 2 0 001.962-1.608l1.2-6A2 2 0 0015.56 8H12V4a2 2 0 00-2-2 1 1 0 00-1 1v.667a4 4 0 01-.8 2.4L6.8 7.933a4 4 0 00-.8 2.4z"></path>
                                            </svg>
                                            Suka
                                        </button>
                                    </form>
                                    <form action="{{ route('portofolio.downvote', $portofolio->id_portofolio) }}" method="POST" class="flex-1">
                                        @csrf
                                        <button type="submit"
                                            class="w-full px-4 py-2 rounded-lg font-medium transition-all duration-200 flex items-center justify-center
                                            {{ $userVote && $userVote->jenis_vote === 'downvote' ? 'bg-red-500 text-white shadow-md' : 'bg-gray-100 text-gray-700 hover:bg-red-50 hover:text-red-600' }}"
                                            {{ $userVote ? 'disabled' : '' }}>
                                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M18 9.5a1.5 1.5 0 11-3 0v-6a1.5 1.5 0 013 0v6zM14 9.667v-5.43a2 2 0 00-1.106-1.79l-.05-.025A4 4 0 0011.055 2H5.64a2 2 0 00-1.962 1.608l-1.2 6A2 2 0 004.44 12H8v4a2 2 0 002 2 1 1 0 001-1v-.667a4 4 0 01.8-2.4l1.4-1.866a4 4 0 00.8-2.4z"></path>
                                            </svg>
                                            Tidak Suka
                                        </button>
                                    </form>
                                </div>
                            </div>

                            {{-- Pembuat Section --}}
                            <div class="bg-white border border-gray-200 rounded-lg p-6">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-[#4B83BF]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                    </svg>
                                    Pembuat
                                </h3>
                                @php
                                    $allUsers = collect();
                                    if ($portofolio->owner) {
                                        $allUsers->push([
                                            'nama' => $portofolio->owner->nama_pengguna,
                                            'id' => $portofolio->owner->id_pengguna,
                                        ]);
                                    }
                                    if ($portofolio->taggedUsers->isNotEmpty()) {
                                        foreach ($portofolio->taggedUsers as $tagged) {
                                            $allUsers->push([
                                                'nama' => $tagged->nama_pengguna,
                                                'id' => $tagged->id_pengguna,
                                            ]);
                                        }
                                    }
                                @endphp

                                @if ($allUsers->isNotEmpty())
                                    <div class="space-y-2">
                                        @foreach ($allUsers as $i => $user)
                                            <a href="{{ route('profile.user', $user['id']) }}"
                                                class="block p-3 rounded-lg bg-gray-50 hover:bg-blue-50 transition-colors duration-200">
                                                <div class="flex items-center">
                                                    <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center text-white font-medium text-sm mr-3">
                                                        {{ strtoupper(substr($user['nama'], 0, 1)) }}
                                                    </div>
                                                    <span class="text-blue-600 hover:text-blue-800 font-medium">{{ $user['nama'] }}</span>
                                                </div>
                                            </a>
                                        @endforeach
                                    </div>
                                @else
                                    <p class="text-gray-500 italic">Tidak ada pengguna terkait</p>
                                @endif
                            </div>

                            {{-- Tautan Section --}}
                            @if ($portofolio->tautan->isNotEmpty())
                                <div class="bg-white border border-gray-200 rounded-lg p-6">
                                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                        <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                                        </svg>
                                        Tautan
                                    </h3>
                                    <div class="space-y-2">
                                        @foreach ($portofolio->tautan as $tautan)
                                            <a href="{{ $tautan->tautan_portofolio }}" target="_blank" rel="noopener noreferrer"
                                                class="block p-3 rounded-lg bg-gray-50 hover:bg-blue-50 transition-colors duration-200">
                                                <div class="flex items-center">
                                                    <svg class="w-4 h-4 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                                    </svg>
                                                    <span class="text-blue-600 hover:text-blue-800 text-sm font-medium truncate">{{ $tautan->tautan_portofolio }}</span>
                                                </div>
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            {{-- Tools Section --}}
                            @if ($portofolio->tools->isNotEmpty())
                                <div class="bg-white border border-gray-200 rounded-lg p-6">
                                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                        <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                        Tools
                                    </h3>
                                    <div class="flex flex-wrap gap-2">
                                        @foreach ($portofolio->tools as $tool)
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800 border">
                                                {{ $tool->tools_portofolio }}
                                            </span>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            {{-- Kategori Section --}}
                            @if ($portofolio->kategori->isNotEmpty())
                                <div class="bg-white border border-gray-200 rounded-lg p-6">
                                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                        <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                        </svg>
                                        Kategori
                                    </h3>
                                    <div class="flex flex-wrap gap-2">
                                        @foreach ($portofolio->kategori as $kategori)
                                            <a href="{{ route('portofolio.index', ['kategori' => $kategori->kategori_portofolio]) }}"
                                                class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800 hover:bg-blue-200 transition-colors duration-200">
                                                {{ $kategori->kategori_portofolio }}
                                            </a>
                                        @endforeach
                                    </div>
                                    <p class="text-xs text-gray-500 mt-2">Klik kategori untuk melihat portofolio serupa</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Admin Section --}}
                    @php
                        $notif = \App\Models\Notifikasi::where('notifiable_id', $portofolio->id_portofolio)
                            ->where('notifiable_type', 'portofolio')
                            ->latest()
                            ->first();
                    @endphp

                    @if (auth()->user()->hasRole('admin') || ($notif && $portofolio->status_portofolio == 0))
                        <div class="mt-8 bg-amber-50 border border-amber-200 rounded-lg p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Komentar/Validasi Admin
                            </h3>

                            @if ($portofolio->status_portofolio == 1)
                                <p class="text-gray-600 italic">-</p>
                            @else
                                @if (auth()->user()->hasRole('admin'))
                                    <form action="{{ route('portofolio.komentar', $portofolio->id_portofolio) }}" method="POST" class="mb-4">
                                        @csrf
                                        <textarea name="isi_notifikasi" 
                                            class="w-full border-gray-300 rounded-md shadow-sm focus:ring-[#4B83BF] mb-3" 
                                            rows="4" 
                                            placeholder="Tulis komentar atau catatan untuk portofolio ini..."
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
                        @if (auth()->user()->hasRole('admin') && $portofolio->status_portofolio == 0)
                            <form action="{{ route('admin.portofolio.validate', $portofolio->id_portofolio) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors duration-200 flex items-center">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Validasi Portofolio
                                </button>
                            </form>
                        @endif

                        {{-- Edit Button --}}
                        @if (auth()->id() === $portofolio->id_pengguna)
                            <a href="{{ route('portofolio.edit', $portofolio->id_portofolio) }}"
                                class="px-6 py-2 bg-[#4B83BF] hover:bg-[#5a93c7] text-white rounded-lg transition-colors duration-200 flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                                Edit Portofolio
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