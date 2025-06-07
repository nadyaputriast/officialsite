<?php

namespace App\Http\Controllers;

use App\Mail\UserValidatedMail;
use App\Models\User;
use App\Models\Dosen;
use App\Models\Mahasiswa;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    public function validateUser($id)
    {
        $user = User::findOrFail($id);
        $user->status_validasi = 1;
        $user->save();

        // Kirim email notifikasi
        Mail::to($user->email)->send(new UserValidatedMail($user));

        return back()->with('success', 'User berhasil divalidasi.');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_pengguna' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
            'tanggal_lahir' => 'required|date',
            'alamat' => 'required|string|max:255',
            'role' => 'required|in:admin,dosen,mahasiswa',
            'nim' => 'nullable|string|max:10|required_if:role,mahasiswa',
            'ktm' => 'nullable|image|max:20480|required_if:role,mahasiswa',
            'nip' => 'nullable|string|max:20|required_if:role,dosen',
            'kode_admin' => 'nullable|string|max:10|required_if:role,admin',
        ]);

        // Cek apakah super admin
        $isSuperAdmin = $request->email === 'nadyaputriast@gmail.com';

        // Create user
        $user = User::create([
            'nama_pengguna' => $validated['nama_pengguna'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'tanggal_lahir' => $validated['tanggal_lahir'],
            'alamat' => $validated['alamat'],
            'role' => $validated['role'],
            'status_validasi' => $isSuperAdmin ? 1 : 0, // Super admin langsung tervalidasi
        ]);

        // Assign role
        $user->assignRole($validated['role']);

        // Create role-specific data
        if ($validated['role'] === 'dosen') {
            Dosen::create([
                'id_pengguna' => $user->id_pengguna,
                'nip' => $validated['nip'],
            ]);
        } elseif ($validated['role'] === 'mahasiswa') {
            Mahasiswa::create([
                'id_pengguna' => $user->id_pengguna,
                'nim' => $validated['nim'],
                'ktm' => $request->hasFile('ktm') ? $request->file('ktm')->store('ktm', 'public') : null,
            ]);
        } elseif ($validated['role'] === 'admin') {
            Admin::create([
                'id_pengguna' => $user->id_pengguna,
                'kode_admin' => $validated['kode_admin'],
            ]);
        }

        // Login user
        auth()->login($user);

        // Redirect berdasarkan status validasi
        if ($user->status_validasi) {
            // Jika sudah tervalidasi (super admin), langsung ke dashboard
            return redirect()->route('dashboard')->with('success', 'Registrasi berhasil! Selamat datang.');
        } else {
            // Jika belum tervalidasi, ke halaman waiting
            return redirect()->route('user.waiting')->with('info', 'Registrasi berhasil! Menunggu validasi admin.');
        }
    }

    public function update(Request $request)
    {
        $request->validate([
            'nama_pengguna' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . auth()->user()->id_pengguna . ',id_pengguna',
            'tanggal_lahir' => 'nullable|date',
            'alamat' => 'nullable|string|max:255',
        ]);

        auth()->user()->update($request->only(['nama_pengguna', 'email', 'tanggal_lahir', 'alamat']));

        return back()->with('success', 'Profile berhasil diupdate!');
    }

    public function updatePassword(Request $request)
    {
        $request->validateWithBag('updatePassword', [
            'current_password' => ['required', 'string', 'current_password'],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ], [
            'current_password.current_password' => 'Password saat ini tidak cocok.',
        ]);

        auth()->user()->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('password_success', 'Password berhasil diupdate!');
    }
}
