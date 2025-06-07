<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <div class="mb-4 text-sm text-gray-600 text-center">
            Reset password Anda dengan memasukkan email dan password baru.
        </div>

        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('password.store') }}">
            @csrf

            <!-- Token -->
            <input type="hidden" name="token" value="{{ $token }}">

            <!-- Email -->
            <div>
                <x-label for="email" value="Email" />
                <x-input id="email" 
                         class="block mt-1 w-full" 
                         type="email" 
                         name="email" 
                         value="{{ old('email', $email) }}" 
                         required 
                         autofocus />
                @error('email')
                    <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                @enderror
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-label for="password" value="Password Baru" />
                <x-input id="password" 
                         class="block mt-1 w-full" 
                         type="password" 
                         name="password" 
                         required />
                @error('password')
                    <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                @enderror
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <x-label for="password_confirmation" value="Konfirmasi Password" />
                <x-input id="password_confirmation" 
                         class="block mt-1 w-full" 
                         type="password" 
                         name="password_confirmation" 
                         required />
            </div>

            <div class="flex items-center justify-end mt-4">
                <button type="submit" 
                        class="inline-flex items-center px-6 py-3 bg-indigo-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition duration-200 shadow-lg">
                    Reset Password
                </button>
            </div>
        </form>
    </x-authentication-card>
</x-guest-layout>