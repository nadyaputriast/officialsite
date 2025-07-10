<x-guest-layout>
    <div
        class="min-h-screen w-full overflow-hidden bg-gradient-to-br from-blue-50 via-white to-cyan-50 flex flex-col justify-center py-6 sm:py-12 px-4 sm:px-6 lg:px-8">
        <div class="w-full max-w-md mx-auto">
            <!-- Logo -->
            <div class="flex justify-center mb-6">
                <div class="relative">
                    <img src="{{ asset('images/saturuang.png') }}" alt="Logo" class="w-20 h-20 sm:w-24 sm:h-24">
                    <div class="absolute -inset-1"></div>
                </div>
            </div>

            <!-- Title -->
            <div class="text-center mb-6 sm:mb-8">
                <h2
                    class="text-2xl sm:text-3xl lg:text-4xl font-bold bg-gradient-to-r from-blue-600 to-cyan-600 bg-clip-text text-transparent">
                    Verifikasi Email
                </h2>
                <p class="mt-2 text-sm text-gray-600">Periksa email Anda untuk melanjutkan</p>
            </div>

            <!-- Form Card -->
            <div
                class="bg-white py-6 sm:py-8 px-4 sm:px-6 shadow-xl rounded-2xl border border-gray-100 backdrop-blur-sm">

                <!-- Description -->
                <div class="mb-4 sm:mb-6 text-center">
                    <div
                        class="inline-flex items-center justify-center w-12 h-12 sm:w-16 sm:h-16 bg-blue-100 rounded-full mb-3 sm:mb-4">
                        <svg class="w-6 h-6 sm:w-8 sm:h-8 text-blue-600" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <p class="text-sm text-gray-600">
                        Terima kasih telah mendaftar! Sebelum memulai, dapatkah Anda memverifikasi alamat email Anda
                        dengan mengklik tautan yang baru saja kami kirimkan kepada Anda?
                    </p>
                </div>

                @if (session('status') == 'verification-link-sent')
                    <div class="mb-4 sm:mb-6 p-3 sm:p-4 bg-green-50 border-l-4 border-green-400 rounded-r-lg">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-green-700 font-medium break-words">
                                    Link verifikasi baru telah dikirim ke alamat email yang Anda berikan saat
                                    pendaftaran.
                                </p>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="space-y-4 sm:space-y-6">
                    <!-- Resend Verification Email -->
                    <form method="POST" action="{{ route('verification.send') }}">
                        @csrf
                        <button type="submit" id="resend-btn"
                            class="group relative w-full flex justify-center py-2.5 sm:py-3 px-4 border border-transparent text-sm font-semibold rounded-xl text-white bg-gradient-to-r from-blue-600 to-cyan-600 hover:from-blue-700 hover:to-cyan-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 disabled:opacity-50 disabled:cursor-not-allowed transition-all duration-200 shadow-lg hover:shadow-xl">
                            <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                                <svg class="h-4 w-4 sm:h-5 sm:w-5 text-blue-300 group-hover:text-blue-200 transition-colors"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </span>
                            <span id="resend-text" class="flex items-center text-sm sm:text-base">
                                <svg class="animate-spin -ml-1 mr-2 h-4 w-4 sm:h-5 sm:w-5 text-white hidden"
                                    id="resend-spinner" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10"
                                        stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor"
                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                    </path>
                                </svg>
                                Kirim Ulang Email Verifikasi
                            </span>
                        </button>
                    </form>

                    <!-- Logout -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="w-full flex justify-center py-2.5 sm:py-3 px-4 border-2 border-gray-300 rounded-xl shadow-sm bg-white text-sm font-semibold text-gray-700 hover:bg-gray-50 hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-all duration-200">
                            <span class="flex items-center text-sm sm:text-base">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2 text-gray-500" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                </svg>
                                Logout
                            </span>
                        </button>
                    </form>
                </div>
            </div>

            <!-- Footer -->
            <div class="mt-6 sm:mt-8 text-center">
                <p
                    class="text-xs text-gray-500 bg-white/60 backdrop-blur-sm rounded-full px-3 sm:px-4 py-2 inline-block shadow-sm">
                    &copy; 2025 Official Site Informatika – Universitas Udayana
                </p>
            </div>
        </div>
    </div>

    <script>
        document.querySelector('form').addEventListener('submit', function() {
            const button = document.getElementById('resend-btn');
            const spinner = document.getElementById('resend-spinner');
            const text = document.getElementById('resend-text');

            button.disabled = true;
            button.classList.add('opacity-75');
            spinner.classList.remove('hidden');
            text.innerHTML =
                '<svg class="animate-spin mr-2 h-4 w-4 sm:h-5 sm:w-5 text-white" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>Mengirim...';
        });

        document.addEventListener('DOMContentLoaded', function() {
            const successMessage = document.querySelector('.bg-green-50');

            if (successMessage) {
                setTimeout(() => {
                    successMessage.style.transition = 'all 0.5s ease-out';
                    successMessage.style.transform = 'translateY(-10px)';
                    successMessage.style.opacity = '0';
                    setTimeout(() => {
                        successMessage.remove();
                    }, 500);
                }, 8000);
            }
        });
    </script>
</x-guest-layout>
