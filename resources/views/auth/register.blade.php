<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('register.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <!-- Nama Pengguna -->
            <div class="mb-4">
                <x-label for="nama_pengguna" value="Nama Pengguna" />
                <input id="nama_pengguna" name="nama_pengguna" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" type="text" required autofocus value="{{ old('nama_pengguna') }}" />
                @error('nama_pengguna')
                    <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                @enderror
            </div>

            <!-- Tanggal Lahir -->
            <div class="mb-4">
                <x-label for="tanggal_lahir" value="Tanggal Lahir" />
                <input id="tanggal_lahir" name="tanggal_lahir" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" type="date" required value="{{ old('tanggal_lahir') }}" />
                @error('tanggal_lahir')
                    <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                @enderror
            </div>

            <!-- Alamat -->
            <div class="mb-4">
                <x-label for="alamat" value="Alamat" />
                <input id="alamat" name="alamat" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" type="text" required value="{{ old('alamat') }}" />
                @error('alamat')
                    <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                @enderror
            </div>

            <!-- Role -->
            <div class="mb-4">
                <x-label for="role" value="Role" />
                <select id="role" name="role" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required onchange="toggleRoleFields(this.value)">
                    <option value="">Pilih Role</option>
                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="dosen" {{ old('role') == 'dosen' ? 'selected' : '' }}>Dosen</option>
                    <option value="mahasiswa" {{ old('role') == 'mahasiswa' ? 'selected' : '' }}>Mahasiswa</option>
                </select>
                @error('role')
                    <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                @enderror
            </div>

            <!-- NIP (Dosen) -->
            <div class="mb-4" id="nip-field" style="display: none;">
                <x-label for="nip" value="NIP" />
                <input id="nip" name="nip" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" type="text" value="{{ old('nip') }}" />
                @error('nip')
                    <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                @enderror
            </div>

            <!-- NIM & KTM (Mahasiswa) -->
            <div class="mb-4" id="nim-field" style="display: none;">
                <x-label for="nim" value="NIM" />
                <input id="nim" name="nim" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" type="text" value="{{ old('nim') }}" />
                @error('nim')
                    <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4" id="ktm-field" style="display: none;">
                <x-label for="ktm" value="KTM (Upload Gambar, max 20MB)" />
                <input id="ktm" name="ktm" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" type="file" accept="image/*" />
                @error('ktm')
                    <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                @enderror
            </div>

            <!-- Kode Admin -->
            <div class="mb-4" id="kode-admin-field" style="display: none;">
                <x-label for="kode_admin" value="Kode Admin" />
                <input id="kode_admin" name="kode_admin" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" type="text" value="{{ old('kode_admin') }}" />
                @error('kode_admin')
                    <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                @enderror
            </div>

            <!-- Email -->
            <div class="mb-4">
                <x-label for="email" value="Email" />
                <input id="email" name="email" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" type="email" required value="{{ old('email') }}" />
                @error('email')
                    <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                @enderror
            </div>

            <!-- Password -->
            <div class="mb-4">
                <x-label for="password" value="Password" />
                <input id="password" name="password" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" type="password" required />
                @error('password')
                    <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                @enderror
            </div>

            <!-- Confirm Password -->
            <div class="mb-6">
                <x-label for="password_confirmation" value="Confirm Password" />
                <input id="password_confirmation" name="password_confirmation" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" type="password" required />
            </div>

            <div class="flex items-center justify-between">
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                    Already registered?
                </a>
                <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    Register
                </button>
            </div>
        </form>
    </x-authentication-card>
</x-guest-layout>

<script>
function toggleRoleFields(role) {
    document.getElementById('nip-field').style.display = (role === 'dosen') ? 'block' : 'none';
    document.getElementById('nim-field').style.display = (role === 'mahasiswa') ? 'block' : 'none';
    document.getElementById('ktm-field').style.display = (role === 'mahasiswa') ? 'block' : 'none';
    document.getElementById('kode-admin-field').style.display = (role === 'admin') ? 'block' : 'none';
}

document.addEventListener('DOMContentLoaded', function() {
    // Show fields based on old role value (for validation errors)
    toggleRoleFields(document.getElementById('role').value);
});
</script>