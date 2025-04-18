<?php

use App\Models\User;
use App\Models\Dosen;
use App\Models\Mahasiswa;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component 
{
    public string $nama_pengguna = '';
    public string $tanggal_lahir = '';
    public string $alamat = '';
    public string $role = '';
    public string $nim = '';
    public string $nip = '';
    public string $kode_admin = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    /**
     * Handle an incoming registration request.
     */
    public function register(): void
    {
        $validated = $this->validate([
            'nama_pengguna' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
            'tanggal_lahir' => ['required', 'date'],
            'alamat' => ['required', 'string'],
            'role' => ['required', 'in:admin,dosen,mahasiswa'],
            'nim' => ['nullable', 'string', 'max:10', 'required_if:role,mahasiswa'],
            'nip' => ['nullable', 'string', 'max:20', 'required_if:role,dosen'],
            'kode_admin' => ['nullable', 'string', 'max:10', 'required_if:role,admin'],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        $user = User::create([
            'nama_pengguna' => $validated['nama_pengguna'],
            'tanggal_lahir' => $validated['tanggal_lahir'],
            'alamat' => $validated['alamat'],
            'email' => $validated['email'],
            'password' => $validated['password'],
            'role' => $validated['role'],
        ]);

        $user->assignRole($validated['role']);

        if ($validated['role'] === 'dosen') {
            Dosen::create([
                'id_pengguna' => $user->id_pengguna,
                'nip' => $validated['nip'],
            ]);
        } elseif ($validated['role'] === 'mahasiswa') {
            Mahasiswa::create([
                'id_pengguna' => $user->id_pengguna,
                'nim' => $validated['nim'],
            ]);
        } elseif ($validated['role'] === 'admin') {
            Admin::create([
                'id_pengguna' => $user->id_pengguna,
                'kode_admin' => $validated['kode_admin'],
            ]);
        }

        event(new Registered($user));

        Auth::login($user);

        $this->redirect(route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<div>
    <form wire:submit="register">
        <!-- Nama Pengguna -->
        <div>
            <x-input-label for="nama_pengguna" :value="__('Nama Pengguna')" />
            <x-text-input wire:model="nama_pengguna" id="nama_pengguna" class="block mt-1 w-full" type="text"
                name="nama_pengguna" required autofocus autocomplete="nama_pengguna" />
            <x-input-error :messages="$errors->get('nama_pengguna')" class="mt-2" />
        </div>

        <!-- Tanggal Lahir -->
        <div class="mt-4">
            <x-input-label for="tanggal_lahir" :value="__('Tanggal Lahir')" />
            <x-text-input wire:model="tanggal_lahir" id="tanggal_lahir" class="block mt-1 w-full" type="date"
                name="tanggal_lahir" required autofocus autocomplete="tanggal_lahir" />
            <x-input-error :messages="$errors->get('tanggal_lahir')" class="mt-2" />
        </div>

        <!-- Alamat -->
        <div class="mt-4">
            <x-input-label for="alamat" :value="__('Alamat')" />
            <x-text-input wire:model="alamat" id="alamat" class="block mt-1 w-full" type="text" name="alamat"
                required autofocus autocomplete="alamat" />
            <x-input-error :messages="$errors->get('alamat')" class="mt-2" />
        </div>

        <!-- Role -->
        <div class="mt-4">
            <x-input-label for="role" :value="__('Role')" />
            <select wire:model.live="role" id="role" name="role" class="block mt-1 w-full">
                <option value="">{{ __('Pilih Role') }}</option>
                <option value="admin">{{ __('Admin') }}</option>
                <option value="dosen">{{ __('Dosen') }}</option>
                <option value="mahasiswa">{{ __('Mahasiswa') }}</option>
            </select>
            <x-input-error :messages="$errors->get('role')" class="mt-2" />
        </div>

        <!-- NIP -->
        <div class="mt-4" style="{{ $role === 'dosen' ? '' : 'display: none;' }}">
            <x-input-label for="nip" :value="__('NIP')" />
            <x-text-input wire:model="nip" id="nip" name="nip" type="text" class="block mt-1 w-full" />
            <x-input-error :messages="$errors->get('nip')" class="mt-2" />
        </div>

        <!-- NIM -->
        <div class="mt-4" style="{{ $role === 'mahasiswa' ? '' : 'display: none;' }}">
            <x-input-label for="nim" :value="__('NIM')" />
            <x-text-input wire:model="nim" id="nim" name="nim" type="text" class="block mt-1 w-full" />
            <x-input-error :messages="$errors->get('nim')" class="mt-2" />
        </div>

        <!-- Kode Admin -->
        <div class="mt-4" style="{{ $role === 'admin' ? '' : 'display: none;' }}">
            <x-input-label for="kode_admin" :value="__('Kode Admin')" />
            <x-text-input wire:model="kode_admin" id="kode_admin" name="kode_admin" type="text" class="block mt-1 w-full" />
            <x-input-error :messages="$errors->get('kode_admin')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input wire:model="email" id="email" class="block mt-1 w-full" type="email" name="email"
                required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input wire:model="password" id="password" class="block mt-1 w-full" type="password" name="password"
                required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input wire:model="password_confirmation" id="password_confirmation" class="block mt-1 w-full"
                type="password" name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                href="{{ route('login') }}" wire:navigate>
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</div>