<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
			{{ __('403 Forbidden') }}
		</h2>
    </x-slot>

    <div class="flex justify-center py-16">
        <div class="bg-white p-8 rounded shadow text-center max-w-md w-full">
            <h1 class="text-4xl font-bold text-red-600 mb-4">403</h1>
            <p class="text-lg text-gray-700 mb-6">Anda tidak memiliki izin untuk mengakses halaman ini.</p>
            <a href="{{ route('dashboard') }}"
               class="inline-block bg-blue-600 text-white px-6 py-3 rounded hover:bg-blue-700 transition">
                Kembali ke Dashboard
            </a>
        </div>
    </div>
</x-app-layout>