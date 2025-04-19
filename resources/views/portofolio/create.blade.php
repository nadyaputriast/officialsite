<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Portofolio') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('portofolio.store') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label for="nama_portofolio" class="block text-sm font-medium text-gray-700">Nama Portofolio</label>
                            <input type="text" name="nama_portofolio" id="nama_portofolio" class="mt-1 block w-full" required>
                        </div>
                        <div class="mb-4">
                            <label for="deskripsi_portofolio" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                            <textarea name="deskripsi_portofolio" id="deskripsi_portofolio" rows="4" class="mt-1 block w-full" required></textarea>
                        </div>
                        <div class="mb-4">
                            <label for="tautan_portofolio" class="block text-sm font-medium text-gray-700">Tautan Portofolio</label>
                            <input type="url" name="tautan_portofolio" id="tautan_portofolio" class="mt-1 block w-full" required>
                        </div>
                        <button type="submit" class="px-4 py-2 bg-blue-500 text-black rounded">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>