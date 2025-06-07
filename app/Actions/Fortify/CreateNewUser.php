<?php

namespace App\Actions\Fortify;

use App\Models\User;
use App\Models\Mahasiswa;
use App\Models\Dosen;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;
use Illuminate\Support\Arr;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, mixed>  $input
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            'nama_pengguna' => ['required', 'string', 'max:255'],
            'tanggal_lahir' => ['required', 'date'],
            'alamat' => ['required', 'string'],
            'role' => ['required', 'in:admin,dosen,mahasiswa'],
            'nim' => ['nullable', 'string', 'max:10', 'required_if:role,mahasiswa'],
            'ktm' => ['nullable', 'required_if:role,mahasiswa', 'file', 'image', 'max:2048'],
            'nip' => ['nullable', 'string', 'max:20', 'required_if:role,dosen'],
            'kode_admin' => ['nullable', 'string', 'max:10', 'required_if:role,admin'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ])->validate();

        // Proses upload KTM jika mahasiswa
        $ktmPath = null;
        if (Arr::get($input, 'role') === 'mahasiswa' && isset($input['ktm']) && $input['ktm']) {
            $ktmPath = $input['ktm']->store('ktm', 'public');
        }

        $user = User::create([
            'nama_pengguna' => $input['nama_pengguna'],
            'tanggal_lahir' => $input['tanggal_lahir'],
            'alamat' => $input['alamat'],
            'role' => $input['role'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
        ]);
        
        $user->assignRole($input['role']);

        if ($input['role'] === 'mahasiswa') {
            Mahasiswa::create([
                'id_pengguna' => $user->id,
                'nim' => $input['nim'],
                'ktm' => $ktmPath,
            ]);
        } elseif ($input['role'] === 'dosen') {
            Dosen::create([
                'id_pengguna' => $user->id,
                'nip' => $input['nip'],
            ]);
        } elseif ($input['role'] === 'admin') {
            Admin::create([
                'id_pengguna' => $user->id,
                'kode_admin' => $input['kode_admin'],
            ]);
        }

        return $user;
    }
}
