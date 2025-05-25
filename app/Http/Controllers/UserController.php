<?php

namespace App\Http\Controllers;

use App\Mail\UserValidatedMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    // public function validateUser($id)
    // {
    //     $user = User::findOrFail($id);
    //     $user->status_validasi = 1;
    //     $user->save();

    //     // Kirim email notifikasi
    //     Mail::to($user->email)->send(new UserValidatedMail($user));

    //     return back()->with('success', 'User berhasil divalidasi.');
    // }

    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'nama_pengguna' => 'required|string|max:255',
    //         'email' => 'required|email|unique:users,email',
    //         'password' => 'required|string|min:8|confirmed',
    //         'tanggal_lahir' => 'required|date',
    //         'alamat' => 'required|string|max:255',
    //         'role' => 'required|in:mahasiswa,dosen',
    //         'status_validasi' => 'boolean',
    //     ]);

    //     $isSuperAdmin = $request->email === 'nadyaputriast@gmail.com';

    //     $user = \App\Models\User::create([
    //         'nama_pengguna' => $request->nama_pengguna,
    //         'email' => $request->email,
    //         'password' => bcrypt($request->password),
    //         'tanggal_lahir' => $request->tanggal_lahir,
    //         'alamat' => $request->alamat,
    //         'role' => $request->role,
    //         'status_validasi' => $isSuperAdmin ? 1 : 0,
    //     ]);

    //     // ...login otomatis jika perlu...
    //     auth()->login($user);

    //     // Redirect sesuai status validasi
    //     if ($isSuperAdmin) {
    //         return redirect()->route('dashboard');
    //     } else {
    //         return redirect()->route('user.waiting');
    //     }
    // }
}
