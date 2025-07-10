<div class="bg-white shadow overflow-hidden sm:rounded-lg">
    <div class="px-4 py-5 sm:p-6">
        <h3 class="text-lg leading-6 font-medium text-gray-900">
            Update Password
        </h3>
        <p class="mt-1 max-w-7xl text-sm text-gray-500">
            Ensure your account is using a long, random password to stay secure.
        </p>

        @if (session('password_success'))
            <div class="mt-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                {{ session('password_success') }}
            </div>
        @endif

        @if ($errors->updatePassword->any())
            <div class="mt-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                <ul>
                    @foreach ($errors->updatePassword->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('password.update') }}" method="POST" class="mt-6">
            @csrf
            @method('PUT')

            <!-- Current Password -->
            <div class="grid grid-cols-6 gap-6">
                <div class="col-span-6 sm:col-span-8">
                    <x-label for="current_password" value="Current Password" />
                    <x-input id="current_password" type="password" name="current_password" class="mt-1 block w-full" required autocomplete="current-password" />
                    @error('current_password', 'updatePassword')
                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <!-- New Password -->
                <div class="col-span-6 sm:col-span-8">
                    <x-label for="password" value="New Password" />
                    <x-input id="password" type="password" name="password" class="mt-1 block w-full" required autocomplete="new-password" />
                    @error('password', 'updatePassword')
                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div class="col-span-6 sm:col-span-8">
                    <x-label for="password_confirmation" value="Confirm Password" />
                    <x-input id="password_confirmation" type="password" name="password_confirmation" class="mt-1 block w-full" required autocomplete="new-password" />
                </div>
            </div>

            <div class="flex items-center justify-end mt-6">
                <button type="submit"
                    class="px-4 py-2 bg-[#4B83BF] hover:bg-[#5a93c7]  text-white rounded-lg font-semibold transition">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>