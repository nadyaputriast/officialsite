@if(auth()->check() && auth()->user()->status_validasi == 1)
    {{-- Jika user sudah tervalidasi, redirect ke dashboard --}}
    <script>
        window.location.href = "{{ route('dashboard') }}";
    </script>
@else
    {{-- Tampilkan halaman waiting jika belum tervalidasi --}}
    <x-guest-layout>
        <div class="min-h-screen w-full overflow-hidden bg-gradient-to-br from-blue-50 via-white to-cyan-50 flex flex-col justify-center py-6 sm:py-12 px-4 sm:px-6 lg:px-8">
            <div class="w-full max-w-md mx-auto">
                <!-- Logo -->
                <div class="flex justify-center mb-4 sm:mb-6">
                    <div class="relative">
                        <img src="{{ asset('images/saturuang.png') }}" alt="Logo" class="w-16 h-16 sm:w-20 sm:h-20 lg:w-24 lg:h-24 drop-shadow-lg">
                        <div class="absolute -inset-1 bg-gradient-to-r from-blue-600 to-cyan-600 rounded-full opacity-20 blur"></div>
                    </div>
                </div>

                <!-- Card -->
                <div class="bg-white py-6 sm:py-8 px-4 sm:px-6 shadow-xl rounded-2xl border border-gray-100 backdrop-blur-sm text-center">
                    
                    <!-- Icon -->
                    <div class="flex justify-center mb-4 sm:mb-6">
                        <div class="inline-flex items-center justify-center w-16 h-16 sm:w-20 sm:h-20 bg-amber-100 rounded-full">
                            <svg class="w-8 h-8 sm:w-10 sm:h-10 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>

                    <!-- Title -->
                    <h2 class="text-xl sm:text-2xl lg:text-3xl font-bold mb-4 sm:mb-6 bg-gradient-to-r from-amber-600 to-orange-600 bg-clip-text text-transparent">
                        Menunggu Validasi Admin
                    </h2>

                    <!-- Description -->
                    <div class="mb-6 sm:mb-8 space-y-3 sm:space-y-4">
                        <p class="text-sm sm:text-base text-gray-600 leading-relaxed">
                            Akun Anda belum divalidasi oleh admin.<br>
                            Silakan tunggu beberapa saat atau cek email Anda secara berkala.
                        </p>
                        
                        <div class="p-3 sm:p-4 bg-blue-50 border-l-4 border-blue-400 rounded-r-lg">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-4 w-4 sm:h-5 sm:w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-xs sm:text-sm text-blue-700">
                                        Refresh halaman ini setelah akun Anda divalidasi.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="space-y-3 sm:space-y-4">
                        <!-- Refresh Button -->
                        <button onclick="refreshPage()" 
                                id="refresh-btn"
                                class="group relative w-full flex justify-center py-2.5 sm:py-3 px-4 border border-transparent text-sm font-semibold rounded-xl text-white bg-gradient-to-r from-blue-600 to-cyan-600 hover:from-blue-700 hover:to-cyan-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200 shadow-lg hover:shadow-xl">
                            <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                                <svg class="h-4 w-4 sm:h-5 sm:w-5 text-blue-300 group-hover:text-blue-200 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                </svg>
                            </span>
                            <span id="refresh-text" class="flex items-center text-sm sm:text-base">
                                <svg class="animate-spin -ml-1 mr-2 h-4 w-4 sm:h-5 sm:w-5 text-white hidden" id="refresh-spinner" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Refresh Halaman
                            </span>
                        </button>

                        <!-- Auto Refresh Info -->
                        <div class="bg-gray-50 rounded-lg p-3 sm:p-4">
                            <div class="flex items-center justify-center space-x-2">
                                <svg class="h-4 w-4 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                                </svg>
                                <span class="text-xs sm:text-sm text-gray-600">
                                    Auto refresh dalam <span id="countdown" class="font-semibold text-blue-600">60</span> detik
                                </span>
                            </div>
                        </div>

                        <!-- Back to Home Button -->
                        <a href="{{ route('welcome') }}" 
                           class="w-full flex justify-center py-2.5 sm:py-3 px-4 border-2 border-gray-300 rounded-xl shadow-sm bg-white text-sm font-semibold text-gray-700 hover:bg-gray-50 hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-all duration-200">
                            <span class="flex items-center text-sm sm:text-base">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                </svg>
                                Kembali ke Beranda
                            </span>
                        </a>

                        <!-- Logout Button -->
                        <form method="POST" action="{{ route('logout') }}" class="w-full">
                            @csrf
                            <button type="submit" 
                                    class="w-full flex justify-center py-2.5 sm:py-3 px-4 border border-red-300 rounded-xl shadow-sm bg-red-50 text-sm font-medium text-red-700 hover:bg-red-100 hover:border-red-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-all duration-200">
                                <span class="flex items-center text-sm sm:text-base">
                                    <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                    </svg>
                                    Logout
                                </span>
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Footer -->
                <div class="mt-6 sm:mt-8 text-center">
                    <p class="text-xs text-gray-500 bg-white/60 backdrop-blur-sm rounded-full px-3 sm:px-4 py-2 inline-block shadow-sm">
                        &copy; 2025 Official Site Informatika – Universitas Udayana
                    </p>
                </div>
            </div>
        </div>

        <script>
            let countdownTimer = 60;
            let countdownInterval;

            function refreshPage() {
                const button = document.getElementById('refresh-btn');
                const spinner = document.getElementById('refresh-spinner');
                const text = document.getElementById('refresh-text');
                
                button.disabled = true;
                button.classList.add('opacity-75');
                spinner.classList.remove('hidden');
                text.innerHTML = '<svg class="animate-spin mr-2 h-4 w-4 sm:h-5 sm:w-5 text-white" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>Refreshing...';
                
                setTimeout(() => {
                    location.reload();
                }, 1000);
            }

            function startCountdown() {
                const countdownElement = document.getElementById('countdown');
                
                countdownInterval = setInterval(() => {
                    countdownTimer--;
                    countdownElement.textContent = countdownTimer;
                    
                    if (countdownTimer <= 0) {
                        clearInterval(countdownInterval);
                        refreshPage();
                    }
                }, 1000);
            }

            // Start countdown when page loads
            document.addEventListener('DOMContentLoaded', function() {
                startCountdown();
            });

            // Check validation status every 30 seconds
            setInterval(() => {
                fetch('{{ route("check.validation.status") }}', {
                    method: 'GET',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.validated) {
                        clearInterval(countdownInterval);
                        // Show success message
                        const card = document.querySelector('.bg-white');
                        card.innerHTML = `
                            <div class="text-center py-6">
                                <div class="inline-flex items-center justify-center w-16 h-16 bg-green-100 rounded-full mb-4">
                                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                                <h3 class="text-xl font-bold text-green-600 mb-2">Akun Tervalidasi!</h3>
                                <p class="text-gray-600 mb-4">Akun Anda telah divalidasi. Mengalihkan ke dashboard...</p>
                            </div>
                        `;
                        setTimeout(() => {
                            window.location.href = "{{ route('dashboard') }}";
                        }, 2000);
                    }
                })
                .catch(error => {
                    console.log('Check validation error:', error);
                });
            }, 30000);
        </script>
    </x-guest-layout>
@endif