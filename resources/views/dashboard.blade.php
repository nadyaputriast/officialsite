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
                    <h3 class="text-lg font-semibold mb-4">Informasi Oprek</h3>
                    <a href="{{ route('oprek.create') }}" class="text-red-500 mb-4 inline-block">Tambah Oprek</a>

                    {{-- Daftar Oprek --}}
                    @forelse ($dataOprek as $oprek)
                        <div class="mb-4">
                            <h3 class="font-bold">{{ $oprek->nama_project }}</h3>
                            <p>{{ $oprek->deskripsi_project }}</p>

                            <p>Status Validasi:
                                @if ($oprek->status_project == 1)
                                    <span class="text-green-500">Sudah Divalidasi</span>
                                @else
                                    <span class="text-red-500">Belum Divalidasi</span>
                                    {{-- Tombol Validasi untuk Admin --}}
                                    @if (auth()->user()->hasRole('admin'))
                                        <form action="{{ route('oprek.validate', $oprek->id_oprek) }}" method="POST"
                                            class="inline">
                                            @csrf
                                            <button type="submit" class="text-blue-500">Validasi</button>
                                        </form>
                                    @endif
                                @endif
                            </p>
                            <a href="{{ route('oprek.show', $oprek->id_oprek) }}" class="text-black-500">Lihat
                                Detail</a>
                        </div>
                    @empty
                        <p class="text-gray-500">Tidak ada informasi oprek saat ini.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <div class="py-12">
        {{-- <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">Informasi Event</h3>
                    <a href="{{ route('event.create') }}" class="text-red-500 mb-4 inline-block">Tambah Event</a> --}}

        {{-- Daftar event --}}
        {{-- @forelse ($dataevent as $event)
                        <div class="mb-4">
                            <h3 class="font-bold">{{ $event->nama_event }}</h3>
                            <p>{{ $event->deskripsi_event }}</p>

                            <p>Status Validasi:
                                @if ($event->status_event == 1)
                                    <span class="text-green-500">Sudah Divalidasi</span>
                                @else
                                    <span class="text-red-500">Belum Divalidasi</span> --}}
        {{-- Tombol Validasi untuk Admin --}}
        {{-- @if (auth()->user()->hasRole('admin'))
                                        <form action="{{ route('event.validate', $event->id_event) }}" method="POST"
                                            class="inline">
                                            @csrf
                                            <button type="submit" class="text-blue-500">Validasi</button>
                                        </form>
                                    @endif
                                @endif
                            </p>
                            <a href="{{ route('event.show', $event->id_event) }}" class="text-black-500">Lihat
                                Detail</a>
                        </div>
                    @empty
                        <p class="text-gray-500">Tidak ada informasi event saat ini.</p>
                    @endforelse
                </div>
            </div>
        </div> --}}
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">Informasi Portofolio</h3>
                    <a href="{{ route('portofolio.create') }}" class="text-red-500 mb-4 inline-block">Tambah Portofolio</a>

                    {{-- Daftar Oprek --}}
                    @forelse ($dataPortofolio as $portofolio)
                        <div class="mb-4">
                            <h3 class="font-bold">{{ $portofolio->nama_portofolio }}</h3>
                            <p>{{ $portofolio->deskripsi_portofolio }}</p>

                            <p>Status Validasi:
                                @if ($portofolio->status_portofolio == 1)
                                    <span class="text-green-500">Sudah Divalidasi</span>
                                @else
                                    <span class="text-red-500">Belum Divalidasi</span>
                                    {{-- Tombol Validasi untuk Admin --}}
                                    @if (auth()->user()->hasRole('admin'))
                                        <form action="{{ route('portofolio.validate', $portofolio->id_portofolio) }}" method="POST"
                                            class="inline">
                                            @csrf
                                            <button type="submit" class="text-blue-500">Validasi</button>
                                        </form>
                                    @endif
                                @endif
                            </p>
                            <a href="{{ route('portofolio.show', $portofolio->id_portofolio) }}" class="text-black-500">Lihat
                                Detail</a>
                        </div>
                    @empty
                        <p class="text-gray-500">Tidak ada informasi portofolio saat ini.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
