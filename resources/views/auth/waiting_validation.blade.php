@if(auth()->check() && auth()->user()->status_validasi == 1)
    {{-- Jika user sudah tervalidasi, redirect ke dashboard --}}
    <script>
        window.location.href = "{{ route('dashboard') }}";
    </script>
@else
    {{-- Tampilkan halaman waiting jika belum tervalidasi --}}
    <x-app-layout>
        <div class="flex flex-col items-center justify-center min-h-screen bg-gray-100">
            <div class="bg-white p-8 rounded-lg shadow-md text-center max-w-md">
                <h2 class="text-2xl font-bold mb-4 text-gray-800">Menunggu Validasi Admin</h2>
                <p class="text-gray-600 mb-4">
                    Akun Anda belum divalidasi oleh admin.<br>
                    Silakan tunggu beberapa saat atau cek email Anda secara berkala.
                </p>
                <p class="text-sm text-gray-500 mb-6">
                    Refresh halaman ini setelah akun Anda divalidasi.
                </p>
                <div class="space-y-2">
                    <button onclick="location.reload()" class="w-full bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                        Refresh Halaman
                    </button>
                    <a href="{{ route('welcome') }}" class="block w-full bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 text-decoration-none">
                        Kembali ke Beranda
                    </a>
                </div>
            </div>
        </div>
    </x-app-layout>
@endif