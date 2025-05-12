<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard ' . ucfirst(Auth::user()->getRoleNames()->first())) }}
        </h2>

        {{-- Banner --}}
        <x-banner-component />
    </x-slot>

    {{-- Informasi Event --}}
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">Informasi Event</h3>
                    <a href="{{ route('event.create') }}" class="text-red-500 mb-4 inline-block">Tambah Event</a>
                    @if (auth()->user()->hasRole('admin'))
                        {{-- Tampilan untuk Admin --}}
                        <table class="table-auto w-full border-collapse border border-gray-300">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th class="border border-gray-300 px-4 py-2" rowspan="2">Nama Event</th>
                                    <th class="border border-gray-300 px-4 py-2" rowspan="2">Deskripsi Event</th>
                                    <th class="border border-gray-300 px-4 py-2" rowspan="2">Status</th>
                                    <th class="border border-gray-300 px-4 py-2" colspan="2">Aksi</th>
                                </tr>
                                <tr class="bg-gray-100">
                                    <th class="border border-gray-300 px-4 py-2">Detail</th>
                                    <th class="border border-gray-300 px-4 py-2">Validasi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($dataEvent as $event)
                                    <tr>
                                        <td class="border border-gray-300 px-4 py-2">{{ $event->nama_event }}</td>
                                        <td class="border border-gray-300 px-4 py-2">{{ $event->deskripsi_event }}
                                        </td>
                                        <td class="border border-gray-300 px-4 py-2">
                                            @if ($event->status_event == 1)
                                                <span class="text-green-500">Sudah Divalidasi</span>
                                            @else
                                                <span class="text-red-500">Belum Divalidasi</span>
                                            @endif
                                        </td>
                                        <td class="border border-gray-300 px-4 py-2">
                                            <a href="{{ route('event.show', $event->id_event) }}"
                                                class="text-blue-500 hover:underline">Detail</a>
                                        </td>
                                        <td class="border border-gray-300 px-4 py-2">
                                            @if ($event->status_event == 0)
                                                <form action="{{ route('event.validate', $event->id_event) }}"
                                                    method="POST" class="inline">
                                                    @csrf
                                                    <button type="submit"
                                                        class="text-blue-500 hover:underline">Validasi</button>
                                                </form>
                                            @else
                                                <span class="text-gray-500">Sudah Divalidasi</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-gray-500 py-4">Tidak ada informasi
                                            event saat ini.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                        {{-- Paginasi untuk Admin --}}
                        <div class="mt-4">
                            {{ $dataEvent->links() }}
                        </div>
                    @else
                        {{-- Tampilan untuk User Biasa --}}
                        @forelse ($dataEvent as $event)
                            <div class="mb-4">
                                <h3 class="font-bold">{{ $event->nama_event }}</h3>
                                <p>{{ $event->deskripsi_event }}</p>
                                <p>Status Validasi:
                                    @if ($event->status_event == 1)
                                        <span class="text-green-500">Sudah Divalidasi</span>
                                    @else
                                        <span class="text-red-500">Belum Divalidasi</span>
                                    @endif
                                </p>
                                <a href="{{ route('event.show', $event->id_event) }}" class="text-black-500">Lihat
                                    Detail</a>
                            </div>
                        @empty
                            <p class="text-gray-500">Tidak ada informasi event saat ini.</p>
                        @endforelse
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Informasi Oprek --}}
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">Informasi Oprek</h3>
                    <a href="{{ route('oprek.create') }}" class="text-red-500 mb-4 inline-block">Tambah Oprek</a>
                    @if (auth()->user()->hasRole('admin'))
                        {{-- Tampilan untuk Admin --}}
                        <table class="table-auto w-full border-collapse border border-gray-300">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th class="border border-gray-300 px-4 py-2" rowspan="2">Nama Project</th>
                                    <th class="border border-gray-300 px-4 py-2" rowspan="2">Deskripsi Hiring</th>
                                    <th class="border border-gray-300 px-4 py-2" rowspan="2">Status</th>
                                    <th class="border border-gray-300 px-4 py-2" colspan="2">Aksi</th>
                                </tr>
                                <tr class="bg-gray-100">
                                    <th class="border border-gray-300 px-4 py-2">Detail</th>
                                    <th class="border border-gray-300 px-4 py-2">Validasi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($dataOprek as $oprek)
                                    <tr>
                                        <td class="border border-gray-300 px-4 py-2">{{ $oprek->nama_project }}</td>
                                        <td class="border border-gray-300 px-4 py-2">{{ $oprek->deskripsi_project }}
                                        </td>
                                        <td class="border border-gray-300 px-4 py-2">
                                            @if ($oprek->status_project == 1)
                                                <span class="text-green-500">Sudah Divalidasi</span>
                                            @else
                                                <span class="text-red-500">Belum Divalidasi</span>
                                            @endif
                                        </td>
                                        <td class="border border-gray-300 px-4 py-2">
                                            <a href="{{ route('oprek.show', $oprek->id_oprek) }}"
                                                class="text-blue-500 hover:underline">Detail</a>
                                        </td>
                                        <td class="border border-gray-300 px-4 py-2">
                                            @if ($oprek->status_project == 0)
                                                <form action="{{ route('oprek.validate', $oprek->id_oprek) }}"
                                                    method="POST" class="inline">
                                                    @csrf
                                                    <button type="submit"
                                                        class="text-blue-500 hover:underline">Validasi</button>
                                                </form>
                                            @else
                                                <span class="text-gray-500">Sudah Divalidasi</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-gray-500 py-4">Tidak ada informasi
                                            oprek saat ini.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                        {{-- Paginasi untuk Admin --}}
                        <div class="mt-4">
                            {{ $dataOprek->links() }}
                        </div>
                    @else
                        {{-- Tampilan untuk User Biasa --}}
                        @forelse ($dataOprek as $oprek)
                            <div class="mb-4">
                                <h3 class="font-bold">{{ $oprek->nama_project }}</h3>
                                <p>{{ $oprek->deskripsi_project }}</p>
                                <p>Status Validasi:
                                    @if ($oprek->status_project == 1)
                                        <span class="text-green-500">Sudah Divalidasi</span>
                                    @else
                                        <span class="text-red-500">Belum Divalidasi</span>
                                    @endif
                                </p>
                                <a href="{{ route('oprek.show', $oprek->id_oprek) }}" class="text-black-500">Lihat
                                    Detail</a>
                            </div>
                        @empty
                            <p class="text-gray-500">Tidak ada informasi oprek saat ini.</p>
                        @endforelse
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Informasi Portofolio --}}
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">Informasi Portofolio</h3>
                    <a href="{{ route('portofolio.create') }}" class="text-red-500 mb-4 inline-block">Tambah
                        Portofolio</a>
                    @if (auth()->user()->hasRole('admin'))
                        {{-- Tampilan untuk Admin --}}
                        <table class="table-auto w-full border-collapse border border-gray-300">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th class="border border-gray-300 px-4 py-2" rowspan="2">Nama Portofolio</th>
                                    <th class="border border-gray-300 px-4 py-2" rowspan="2">Deskripsi Portofolio
                                    </th>
                                    <th class="border border-gray-300 px-4 py-2" rowspan="2">Status</th>
                                    <th class="border border-gray-300 px-4 py-2" colspan="2">Aksi</th>
                                </tr>
                                <tr class="bg-gray-100">
                                    <th class="border border-gray-300 px-4 py-2">Detail</th>
                                    <th class="border border-gray-300 px-4 py-2">Validasi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($dataPortofolio as $portofolio)
                                    <tr>
                                        <td class="border border-gray-300 px-4 py-2">
                                            {{ $portofolio->nama_portofolio }}</td>
                                        <td class="border border-gray-300 px-4 py-2">
                                            {{ $portofolio->deskripsi_portofolio }}</td>
                                        <td class="border border-gray-300 px-4 py-2">
                                            @if ($portofolio->status_portofolio == 1)
                                                <span class="text-green-500">Sudah Divalidasi</span>
                                            @else
                                                <span class="text-red-500">Belum Divalidasi</span>
                                            @endif
                                        </td>
                                        <td class="border border-gray-300 px-4 py-2">
                                            <a href="{{ route('portofolio.show', $portofolio->id_portofolio) }}"
                                                class="text-blue-500 hover:underline">Detail</a>
                                        </td>
                                        <td class="border border-gray-300 px-4 py-2">
                                            @if ($portofolio->status_portofolio == 0)
                                                <form
                                                    action="{{ route('portofolio.validate', $portofolio->id_portofolio) }}"
                                                    method="POST" class="inline">
                                                    @csrf
                                                    <button type="submit"
                                                        class="text-blue-500 hover:underline">Validasi</button>
                                                </form>
                                            @else
                                                <span class="text-gray-500">Sudah Divalidasi</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-gray-500 py-4">Tidak ada informasi
                                            portofolio saat ini.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                        {{-- Paginasi untuk Admin --}}
                        <div class="mt-4">
                            {{ $dataPortofolio->links() }}
                        </div>
                    @else
                        {{-- Tampilan untuk User Biasa --}}
                        @forelse ($dataPortofolio as $portofolio)
                            <div class="mb-4">
                                <h3 class="font-bold">{{ $portofolio->nama_portofolio }}</h3>
                                <p>{{ $portofolio->deskripsi_portofolio }}</p>
                                <p><strong>Jumlah Dilihat:</strong> {{ $portofolio->view_count }}</p>
                                <p><strong>Jumlah Suka:</strong> {{ $portofolio->banyak_upvote }}</p>
                                <p><strong>Jumlah Tidak Suka:</strong> {{ $portofolio->banyak_downvote }}</p>
                                <a href="{{ route('portofolio.show', $portofolio->id_portofolio) }}"
                                    class="text-blue-500 hover:underline">Lihat Detail</a>
                            </div>
                        @empty
                            <p class="text-gray-500">Tidak ada informasi portofolio saat ini.</p>
                        @endforelse
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Informasi Pengabdian --}}
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">Informasi Pengabdian</h3>
                    <a href="{{ route('pengabdian.create') }}" class="text-red-500 mb-4 inline-block">Tambah
                        Pengabdian</a>
                    @if (auth()->user()->hasRole('admin'))
                        {{-- Tampilan untuk Admin --}}
                        <table class="table-auto w-full border-collapse border border-gray-300">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th class="border border-gray-300 px-4 py-2" rowspan="2">Nama Pengabdian</th>
                                    <th class="border border-gray-300 px-4 py-2" rowspan="2">Deskripsi Pengabdian
                                    </th>
                                    <th class="border border-gray-300 px-4 py-2" rowspan="2">Status</th>
                                    <th class="border border-gray-300 px-4 py-2" colspan="2">Aksi</th>
                                </tr>
                                <tr class="bg-gray-100">
                                    <th class="border border-gray-300 px-4 py-2">Detail</th>
                                    <th class="border border-gray-300 px-4 py-2">Validasi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($dataPengabdian as $pengabdian)
                                    <tr>
                                        <td class="border border-gray-300 px-4 py-2">
                                            {{ $pengabdian->judul_pengabdian }}</td>
                                        <td class="border border-gray-300 px-4 py-2">
                                            {{ $pengabdian->deskripsi_pengabdian }}
                                        </td>
                                        <td class="border border-gray-300 px-4 py-2">
                                            @if ($pengabdian->status_pengabdian == 1)
                                                <span class="text-green-500">Sudah Divalidasi</span>
                                            @else
                                                <span class="text-red-500">Belum Divalidasi</span>
                                            @endif
                                        </td>
                                        <td class="border border-gray-300 px-4 py-2">
                                            <a href="{{ route('pengabdian.show', $pengabdian->id_pengabdian) }}"
                                                class="text-blue-500 hover:underline">Detail</a>
                                        </td>
                                        <td class="border border-gray-300 px-4 py-2">
                                            @if ($pengabdian->status_pengabdian == 0)
                                                <form
                                                    action="{{ route('pengabdian.validate', $pengabdian->id_pengabdian) }}"
                                                    method="POST" class="inline">
                                                    @csrf
                                                    <button type="submit"
                                                        class="text-blue-500 hover:underline">Validasi</button>
                                                </form>
                                            @else
                                                <span class="text-gray-500">Sudah Divalidasi</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-gray-500 py-4">Tidak ada informasi
                                            pengabdian saat ini.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                        {{-- Paginasi untuk Admin --}}
                        <div class="mt-4">
                            {{ $dataPengabdian->links() }}
                        </div>
                    @else
                        {{-- Tampilan untuk User Biasa --}}
                        @forelse ($dataPengabdian as $pengabdian)
                            <div class="mb-4">
                                <h3 class="font-bold">{{ $pengabdian->judul_pengabdian }}</h3>
                                <p>{{ $pengabdian->deskripsi_pengabdian }}</p>
                                <p>Status Validasi:
                                    @if ($pengabdian->status_pengabdian == 1)
                                        <span class="text-green-500">Sudah Divalidasi</span>
                                    @else
                                        <span class="text-red-500">Belum Divalidasi</span>
                                    @endif
                                </p>
                                <a href="{{ route('pengabdian.show', $pengabdian->id_pengabdian) }}"
                                    class="text-black-500">Lihat
                                    Detail</a>
                            </div>
                        @empty
                            <p class="text-gray-500">Tidak ada informasi pengabdian saat ini.</p>
                        @endforelse
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Informasi Prestasi --}}
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">Informasi Prestasi</h3>
                    <a href="{{ route('prestasi.create') }}" class="text-red-500 mb-4 inline-block">Tambah
                        Prestasi</a>
                    @if (auth()->user()->hasRole('admin'))
                        {{-- Tampilan untuk Admin --}}
                        <table class="table-auto w-full border-collapse border border-gray-300">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th class="border border-gray-300 px-4 py-2" rowspan="2">Nama Prestasi</th>
                                    <th class="border border-gray-300 px-4 py-2" rowspan="2">Deskripsi Prestasi
                                    </th>
                                    <th class="border border-gray-300 px-4 py-2" rowspan="2">Status</th>
                                    <th class="border border-gray-300 px-4 py-2" colspan="2">Aksi</th>
                                </tr>
                                <tr class="bg-gray-100">
                                    <th class="border border-gray-300 px-4 py-2">Detail</th>
                                    <th class="border border-gray-300 px-4 py-2">Validasi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($dataPrestasi as $prestasi)
                                    <tr>
                                        <td class="border border-gray-300 px-4 py-2">{{ $prestasi->nama_prestasi }}
                                        </td>
                                        <td class="border border-gray-300 px-4 py-2">
                                            {{ $prestasi->deskripsi_prestasi }}
                                        </td>
                                        <td class="border border-gray-300 px-4 py-2">
                                            @if ($prestasi->status_prestasi == 1)
                                                <span class="text-green-500">Sudah Divalidasi</span>
                                            @else
                                                <span class="text-red-500">Belum Divalidasi</span>
                                            @endif
                                        </td>
                                        <td class="border border-gray-300 px-4 py-2">
                                            <a href="{{ route('prestasi.show', $prestasi->id_prestasi) }}"
                                                class="text-blue-500 hover:underline">Detail</a>
                                        </td>
                                        <td class="border border-gray-300 px-4 py-2">
                                            @if ($prestasi->status_prestasi == 0)
                                                <form
                                                    action="{{ route('prestasi.validate', $prestasi->id_prestasi) }}"
                                                    method="POST" class="inline">
                                                    @csrf
                                                    <button type="submit"
                                                        class="text-blue-500 hover:underline">Validasi</button>
                                                </form>
                                            @else
                                                <span class="text-gray-500">Sudah Divalidasi</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-gray-500 py-4">Tidak ada informasi
                                            prestasi saat ini.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                        {{-- Paginasi untuk Admin --}}
                        <div class="mt-4">
                            {{ $dataPrestasi->links() }}
                        </div>
                    @else
                        {{-- Tampilan untuk User Biasa --}}
                        @forelse ($dataPrestasi as $prestasi)
                            <div class="mb-4">
                                <h3 class="font-bold">{{ $prestasi->nama_prestasi }}</h3>
                                <p>{{ $prestasi->deskripsi_prestasi }}</p>
                                <p>Status Validasi:
                                    @if ($prestasi->status_prestasi == 1)
                                        <span class="text-green-500">Sudah Divalidasi</span>
                                    @else
                                        <span class="text-red-500">Belum Divalidasi</span>
                                    @endif
                                </p>
                                <a href="{{ route('prestasi.show', $prestasi->id_prestasi) }}"
                                    class="text-black-500">Lihat
                                    Detail</a>
                            </div>
                        @empty
                            <p class="text-gray-500">Tidak ada informasi prestasi saat ini.</p>
                        @endforelse
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Informasi Sertifikasi --}}
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">Informasi Sertifikasi</h3>
                    <a href="{{ route('sertifikasi.create') }}" class="text-red-500 mb-4 inline-block">Tambah
                        Sertifikasi</a>

                    @if (auth()->user()->hasRole('admin'))
                        {{-- Tampilan untuk Admin --}}
                        <table class="table-auto w-full border-collapse border border-gray-300">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th class="border border-gray-300 px-4 py-2" rowspan="2">Nama Sertifikasi</th>
                                    <th class="border border-gray-300 px-4 py-2" rowspan="2">Deskripsi Sertifikasi
                                    </th>
                                    <th class="border border-gray-300 px-4 py-2" rowspan="2">Status</th>
                                    <th class="border border-gray-300 px-4 py-2" colspan="2">Aksi</th>
                                </tr>
                                <tr class="bg-gray-100">
                                    <th class="border border-gray-300 px-4 py-2">Detail</th>
                                    <th class="border border-gray-300 px-4 py-2">Validasi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($dataSertifikasi as $sertifikasi)
                                    <tr>
                                        <td class="border border-gray-300 px-4 py-2">
                                            {{ $sertifikasi->nama_sertifikasi }}</td>
                                        <td class="border border-gray-300 px-4 py-2">
                                            {{ $sertifikasi->deskripsi_sertifikasi }}
                                        </td>
                                        <td class="border border-gray-300 px-4 py-2">
                                            @if ($sertifikasi->status_sertifikasi == 1)
                                                <span class="text-green-500">Sudah Divalidasi</span>
                                            @else
                                                <span class="text-red-500">Belum Divalidasi</span>
                                            @endif
                                        </td>
                                        <td class="border border-gray-300 px-4 py-2">
                                            <a href="{{ route('sertifikasi.show', $sertifikasi->id_sertifikasi) }}"
                                                class="text-blue-500 hover:underline">Detail</a>
                                        </td>
                                        <td class="border border-gray-300 px-4 py-2">
                                            @if ($sertifikasi->status_sertifikasi == 0)
                                                <form
                                                    action="{{ route('sertifikasi.validate', $sertifikasi->id_sertifikasi) }}"
                                                    method="POST" class="inline">
                                                    @csrf
                                                    <button type="submit"
                                                        class="text-blue-500 hover:underline">Validasi</button>
                                                </form>
                                            @else
                                                <span class="text-gray-500">Sudah Divalidasi</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-gray-500 py-4">Tidak ada informasi
                                            sertifikasi saat ini.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                        {{-- Paginasi untuk Admin --}}
                        <div class="mt-4">
                            {{ $dataSertifikasi->links() }}
                        </div>
                    @else
                        {{-- Tampilan untuk User Biasa --}}
                        @forelse ($dataSertifikasi as $sertifikasi)
                            <div class="mb-4">
                                <h3 class="font-bold">{{ $sertifikasi->nama_sertifikasi }}</h3>
                                <p>{{ $sertifikasi->deskripsi_sertifikasi }}</p>
                                <p>Status Validasi:
                                    @if ($sertifikasi->status_sertifikasi == 1)
                                        <span class="text-green-500">Sudah Divalidasi</span>
                                    @else
                                        <span class="text-red-500">Belum Divalidasi</span>
                                    @endif
                                </p>
                                <a href="{{ route('sertifikasi.show', $sertifikasi->id_sertifikasi) }}"
                                    class="text-black-500">Lihat
                                    Detail</a>
                            </div>
                        @empty
                            <p class="text-gray-500">Tidak ada informasi sertifikasi saat ini.</p>
                        @endforelse
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Informasi Download Konten --}}
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">Informasi Download</h3>
                    <a href="{{ route('download.create') }}" class="text-red-500 mb-4 inline-block">Tambah
                        Download</a>

                    @if (auth()->user()->hasRole('admin'))
                        {{-- Tampilan untuk Admin --}}
                        <table class="table-auto w-full border-collapse border border-gray-300">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th class="border border-gray-300 px-4 py-2" rowspan="2">Nama Download</th>
                                    <th class="border border-gray-300 px-4 py-2" rowspan="2">Jenis Konten</th>
                                    <th class="border border-gray-300 px-4 py-2" rowspan="2">Status</th>
                                    <th class="border border-gray-300 px-4 py-2" colspan="2">Aksi</th>
                                </tr>
                                <tr class="bg-gray-100">
                                    <th class="border border-gray-300 px-4 py-2">Detail</th>
                                    <th class="border border-gray-300 px-4 py-2">Validasi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($dataDownload as $download)
                                    <tr>
                                        <td class="border border-gray-300 px-4 py-2">
                                            {{ $download->nama_download }}</td>
                                        <td class="border border-gray-300 px-4 py-2">
                                            {{ $download->jenis_konten }}</td>
                                        </td>
                                        <td class="border border-gray-300 px-4 py-2">
                                            @if ($download->status_download == 1)
                                                <span class="text-green-500">Sudah Divalidasi</span>
                                            @else
                                                <span class="text-red-500">Belum Divalidasi</span>
                                            @endif
                                        </td>
                                        <td class="border border-gray-300 px-4 py-2">
                                            <a href="{{ route('download.show', $download->id_download) }}"
                                                class="text-blue-500 hover:underline">Detail</a>
                                        </td>
                                        <td class="border border-gray-300 px-4 py-2">
                                            @if ($download->status_download == 0)
                                                <form
                                                    action="{{ route('download.validate', $download->id_download) }}"
                                                    method="POST" class="inline">
                                                    @csrf
                                                    <button type="submit"
                                                        class="text-blue-500 hover:underline">Validasi</button>
                                                </form>
                                            @else
                                                <span class="text-gray-500">Sudah Divalidasi</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-gray-500 py-4">Tidak ada informasi
                                            sertifikasi saat ini.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                        {{-- Paginasi untuk Admin --}}
                        <div class="mt-4">
                            {{ $dataDownload->links() }}
                        </div>
                    @else
                        {{-- Tampilan untuk User Biasa --}}
                        @forelse ($dataDownload as $download)
                            <div class="mb-4">
                                <h3 class="font-bold">{{ $download->nama_download }}</h3>
                                <p>{{ $download->jenis_konten }}</p>
                                <p>Status Validasi:
                                    @if ($download->status_download == 1)
                                        <span class="text-green-500">Sudah Divalidasi</span>
                                    @else
                                        <span class="text-red-500">Belum Divalidasi</span>
                                    @endif
                                </p>
                                <a href="{{ route('download.show', $download->id_download) }}"
                                    class="text-black-500">Lihat
                                    Detail</a>
                            </div>
                        @empty
                            <p class="text-gray-500">Tidak ada informasi download saat ini.</p>
                        @endforelse
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
