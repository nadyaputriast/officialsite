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
                    Konfirmasi Password
                </h2>
                <p class="mt-2 text-sm text-gray-600">Konfirmasi password untuk melanjutkan</p>
            </div>

            <!-- Form Card -->
            <div
                class="bg-white py-6 sm:py-8 px-4 sm:px-6 shadow-xl rounded-2xl border border-gray-100 backdrop-blur-sm">

                <!-- Description -->
                <div class="mb-4 sm:mb-6 text-center">
                    <div
                        class="inline-flex items-center justify-center w-12 h-12 sm:w-16 sm:h-16 bg-orange-100 rounded-full mb-3 sm:mb-4">
                        <svg class="w-6 h-6 sm:w-8 sm:h-8 text-orange-600" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                    <p class="text-sm text-gray-600">
                        Ini adalah area aman dari aplikasi. Silakan konfirmasi password Anda sebelum melanjutkan.
                    </p>
                </div>

                @if ($errors->any())
                    <div class="mb-4 sm:mb-6 p-3 sm:p-4 bg-red-50 border-l-4 border-red-400 rounded-r-lg">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <ul class="text-sm text-red-700 space-y-1">
                                    @foreach ($errors->all() as $error)
                                        <li class="break-words">{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif

                <form method="POST" action="{{ route('password.confirm') }}" class="space-y-4 sm:space-y-6">
                    @csrf

                    <!-- Password -->
                    <div class="group">
                        <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                            Password
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-4 w-4 sm:h-5 sm:w-5 text-gray-400 group-focus-within:text-blue-500 transition-colors"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </div>
                            <input id="password" name="password" type="password" required autofocus
                                class="block w-full pl-9 sm:pl-10 pr-10 sm:pr-12 py-2.5 sm:py-3 border border-gray-300 rounded-xl shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-gray-50 focus:bg-white text-sm sm:text-base"
                                placeholder="Masukkan password Anda">
                            <button type="button" onclick="togglePassword('password')"
                                class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 focus:outline-none focus:text-blue-500 transition-colors">
                                <svg id="eye-open-password" class="h-4 w-4 sm:h-5 sm:w-5" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <svg id="eye-closed-password" class="h-4 w-4 sm:h-5 sm:w-5 hidden" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Confirm Button -->
                    <div class="pt-2">
                        <button type="submit" id="confirm-btn"
                            class="group relative w-full flex justify-center py-2.5 sm:py-3 px-4 border border-transparent text-sm font-semibold rounded-xl text-white bg-gradient-to-r from-blue-600 to-cyan-600 hover:from-blue-700 hover:to-cyan-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 disabled:opacity-50 disabled:cursor-not-allowed transition-all duration-200 shadow-lg hover:shadow-xl">
                            <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                                <svg class="h-4 w-4 sm:h-5 sm:w-5 text-blue-300 group-hover:text-blue-200 transition-colors"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </span>
                            <span id="confirm-text" class="flex items-center text-sm sm:text-base">
                                Konfirmasi Password
                            </span>
                        </button>
                    </div>
                </form>
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
        function togglePassword(fieldName) {
            const passwordInput = document.getElementById(fieldName);
            const eyeOpen = document.getElementById('eye-open-password');
            const eyeClosed = document.getElementById('eye-closed-password');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeOpen.classList.add('hidden');
                eyeClosed.classList.remove('hidden');
            } else {
                passwordInput.type = 'password';
                eyeOpen.classList.remove('hidden');
                eyeClosed.classList.add('hidden');
            }
        }

        document.querySelector('form').addEventListener('submit', function() {
            const button = document.getElementById('confirm-btn');
            const text = document.getElementById('confirm-text');

            button.disabled = true;
            button.classList.add('opacity-75');
            text.innerHTML =
                '<svg class="animate-spin mr-2 h-4 w-4 sm:h-5 sm:w-5 text-white" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>Memproses...';
        });
    </script>
</x-guest-layout>
