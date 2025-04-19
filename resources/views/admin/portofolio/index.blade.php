<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Validasi Portofolio') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">Daftar Portofolio</h3>

                    @if (session('success'))
                        <div class="mb-4 text-green-500">
                            {{ session('success') }}
                        </div>
                    @endif

                    @forelse ($portofolios as $portofolio)
                        <div class="mb-4 border-b pb-4">
                            <h4 class="font-bold">{{ $portofolio->nama_portofolio }}</h4>
                            <p>{{ $portofolio->deskripsi_portofolio }}</p>
                            <p><strong>Tautan:</strong> <a href="{{ $portofolio->tautan_portofolio }}" target="_blank" class="text-blue-500">Lihat Portofolio</a></p>
                            <p><strong>Status:</strong> {{ ucfirst($portofolio->status_portofolio) }}</p>
                            <div class="mt-2">
                                <form action="{{ route('admin.portofolio.approve', $portofolio->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded">Validasi</button>
                                </form>
                                <form action="{{ route('admin.portofolio.reject', $portofolio->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded">Tolak</button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-500">Tidak ada portofolio yang perlu divalidasi.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>