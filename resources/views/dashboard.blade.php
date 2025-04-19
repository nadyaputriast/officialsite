<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard ' . ucfirst(Auth::user()->getRoleNames()->first())) }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">Informasi Oprek & Project</h3>

                    @forelse ($dataOprek as $oprek)
                        @include('oprecs.card-oprek', ['oprek' => $oprek])
                    @empty
                        <p class="text-gray-500">Tidak ada informasi oprek saat ini.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">Informasi Event</h3>

                    @forelse ($dataEvent as $event)
                        @include('events.card-event', ['event' => $event])
                    @empty
                        <p class="text-gray-500">Tidak ada informasi event saat ini.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">Portofolio</h3>
                    <a href="{{ route('portofolio.create') }}" class="px-4 py-2 bg-green-500 text-black rounded">Tambah Portofolio</a>
                </div>
            </div>
        </div>
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">Portofolio</h3>

                    @forelse ($dataPortofolio as $portofolio)
                        <div class="mb-4">
                            <h4 class="font-bold">{{ $portofolio->nama_portofolio }}</h4>
                            <p>{{ $portofolio->deskripsi_portofolio }}</p>
                            <p>
                                <strong>Pengguna:</strong>
                                @if ($portofolio->mahasiswa)
                                    {{ $portofolio->mahasiswa->name }} (Mahasiswa)
                                @elseif ($portofolio->dosen)
                                    {{ $portofolio->dosen->name }} (Dosen)
                                @endif
                            </p>
                            <a href="{{ $portofolio->tautan_portofolio }}" target="_blank" class="text-blue-500">Lihat
                                Portofolio</a>
                        </div>
                    @empty
                        <p class="text-gray-500">Belum ada portofolio yang disetujui.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
