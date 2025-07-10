<div class="bg-white shadow overflow-hidden sm:rounded-lg">
    <div class="px-4 py-5 sm:p-6">
        <h3 class="text-lg leading-6 font-medium text-gray-900">
            Profile Information
        </h3>
        <p class="mt-1 max-w-7xl text-sm text-gray-500">
            Update your account's profile information and email address.
        </p>

        @if (session('success'))
            <div class="mt-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mt-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('profile.update') }}" method="POST" class="mt-6">
            @csrf
            @method('PUT')

            <!-- Nama Pengguna -->
            <div class="grid grid-cols-6 gap-6">
                <div class="col-span-6 sm:col-span-8">
                    <x-label for="nama_pengguna" value="Nama Pengguna" />
                    <x-input id="nama_pengguna" type="text" name="nama_pengguna" class="mt-1 block w-full" value="{{ old('nama_pengguna', auth()->user()->nama_pengguna) }}" required />
                </div>

                <!-- Email -->
                <div class="col-span-6 sm:col-span-8">
                    <x-label for="email" value="Email" />
                    <x-input id="email" type="email" name="email" class="mt-1 block w-full" value="{{ old('email', auth()->user()->email) }}" required />
                </div>

                <!-- Tanggal Lahir -->
                <div class="col-span-6 sm:col-span-8">
                    <x-label for="tanggal_lahir" value="Tanggal Lahir" />
                    <x-input id="tanggal_lahir" type="date" name="tanggal_lahir" class="mt-1 block w-full" value="{{ old('tanggal_lahir', auth()->user()->tanggal_lahir) }}" />
                </div>

                <!-- Alamat -->
                <div class="col-span-6 sm:col-span-8">
                    <x-label for="alamat" value="Alamat" />
                    <x-input id="alamat" type="text" name="alamat" class="mt-1 block w-full" value="{{ old('alamat', auth()->user()->alamat) }}" />
                </div>
            </div>

            <div class="flex items-center justify-end mt-6">
                <button type="submit"
                    class="px-4 py-2 bg-[#4B83BF] hover:bg-[#5a93c7] text-white rounded-lg font-semibold transition">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>