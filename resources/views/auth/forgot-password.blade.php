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
                    Forgot Password?
                </h2>
                <p class="mt-2 text-sm text-gray-600">No worries, we'll send you reset instructions</p>
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
                        Enter your email address and we'll send you a link to reset your password.
                    </p>
                </div>

                <!-- Session Status -->
                @if (session('status'))
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
                                <p class="text-sm text-green-700 font-medium break-words">{{ session('status') }}</p>
                            </div>
                        </div>
                    </div>
                @endif

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

                <form method="POST" action="{{ route('password.email') }}" class="space-y-4 sm:space-y-6">
                    @csrf

                    <!-- Email -->
                    <div class="group">
                        <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                            Email Address
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-4 w-4 sm:h-5 sm:w-5 text-gray-400 group-focus-within:text-blue-500 transition-colors"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                                </svg>
                            </div>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required
                                autofocus autocomplete="email"
                                class="block w-full pl-9 sm:pl-10 pr-3 py-2.5 sm:py-3 border border-gray-300 rounded-xl shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-gray-50 focus:bg-white text-sm sm:text-base"
                                placeholder="Enter your email address">
                        </div>
                        @error('email')
                            <p class="mt-2 text-sm text-red-600 flex items-start">
                                <svg class="w-4 h-4 mr-1 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                        clip-rule="evenodd" />
                                </svg>
                                <span class="break-words">{{ $message }}</span>
                            </p>
                        @enderror
                    </div>

                    <!-- Send Reset Link Button -->
                    <div class="pt-2">
                        <button type="submit" id="reset-btn"
                            class="group relative w-full flex justify-center py-2.5 sm:py-3 px-4 border border-transparent text-sm font-semibold rounded-xl text-white bg-gradient-to-r from-blue-600 to-cyan-600 hover:from-blue-700 hover:to-cyan-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 disabled:opacity-50 disabled:cursor-not-allowed transition-all duration-200 shadow-lg hover:shadow-xl">
                            <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                                <svg class="h-4 w-4 sm:h-5 sm:w-5 text-blue-300 group-hover:text-blue-200 transition-colors"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </span>
                            <span id="reset-text" class="flex items-center text-sm sm:text-base">
                                <svg class="animate-spin -ml-1 mr-2 h-4 w-4 sm:h-5 sm:w-5 text-white hidden"
                                    id="loading-spinner" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10"
                                        stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor"
                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                    </path>
                                </svg>
                                Send Reset Link
                            </span>
                        </button>
                    </div>

                    <!-- Back to Login -->
                    <div class="mt-4 sm:mt-6">
                        <a href="{{ route('login') }}"
                            class="w-full flex justify-center py-2.5 sm:py-3 px-4 border-2 border-gray-300 rounded-xl shadow-sm bg-white text-sm font-semibold text-gray-700 hover:bg-gray-50 hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200">
                            <span class="flex items-center text-sm sm:text-base">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2 text-gray-500" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 19l-7-7 7-7" />
                                </svg>
                                Back to Sign In
                            </span>
                        </a>
                    </div>

                    <!-- Divider -->
                    <div class="mt-6 sm:mt-8">
                        <div class="relative">
                            <div class="absolute inset-0 flex items-center">
                                <div class="w-full border-t border-gray-200"></div>
                            </div>
                            <div class="relative flex justify-center text-sm">
                                <span class="px-3 sm:px-4 bg-white text-gray-500 font-medium">Need an account?</span>
                            </div>
                        </div>
                    </div>

                    <!-- Register Link -->
                    <div>
                        <a href="{{ route('register') }}"
                            class="w-full flex justify-center py-2.5 sm:py-3 px-4 border border-gray-300 rounded-xl shadow-sm bg-gray-50 text-sm font-medium text-gray-700 hover:bg-gray-100 hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200">
                            <span class="flex items-center text-sm sm:text-base">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2 text-gray-500" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                                </svg>
                                Create New Account
                            </span>
                        </a>
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
        // Enhanced loading state
        document.querySelector('form').addEventListener('submit', function() {
            const button = document.getElementById('reset-btn');
            const spinner = document.getElementById('loading-spinner');
            const text = document.getElementById('reset-text');

            button.disabled = true;
            button.classList.add('opacity-75');
            spinner.classList.remove('hidden');
            text.innerHTML =
                '<svg class="animate-spin mr-2 h-4 w-4 sm:h-5 sm:w-5 text-white" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>Sending Link...';
        });

        // Auto-hide success/error messages
        document.addEventListener('DOMContentLoaded', function() {
            const successMessage = document.querySelector('.bg-green-50');
            const errorMessage = document.querySelector('.bg-red-50');

            // Auto-hide success message after 10 seconds (longer for email instructions)
            if (successMessage) {
                setTimeout(() => {
                    successMessage.style.transition = 'all 0.5s ease-out';
                    successMessage.style.transform = 'translateY(-10px)';
                    successMessage.style.opacity = '0';
                    setTimeout(() => {
                        successMessage.remove();
                    }, 500);
                }, 10000);
            }

            // Auto-hide error message after 5 seconds
            if (errorMessage) {
                setTimeout(() => {
                    errorMessage.style.transition = 'all 0.5s ease-out';
                    errorMessage.style.transform = 'translateY(-10px)';
                    errorMessage.style.opacity = '0';
                    setTimeout(() => {
                        errorMessage.remove();
                    }, 500);
                }, 5000);
            }
        });
    </script>
</x-guest-layout>
