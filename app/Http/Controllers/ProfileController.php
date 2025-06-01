<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Pengabdian;
use App\Models\Portofolio;
use App\Models\Prestasi;
use App\Models\Sertifikasi;

class ProfileController extends Controller
{
	public function ownProfile()
	{
		return redirect()->route('profile.user', auth()->id());
	}

	public function show($id)
	{
		$user = User::findOrFail($id);

		// Ambil data pengabdian milik user atau user di-tag di dalamnya
		$pengabdian = Pengabdian::with('taggedUsers')
			->where('pengabdian.id_pengguna', $user->id_pengguna)
			->orWhereHas('taggedUsers', function ($q) use ($user) {
				$q->where('users.id_pengguna', $user->id_pengguna);
			})
			->get();

		$prestasi = Prestasi::with('taggedUsers')
			->where('prestasi.id_pengguna', $user->id_pengguna)
			->orWhereHas('taggedUsers', function ($q) use ($user) {
				$q->where('users.id_pengguna', $user->id_pengguna);
			})
			->get();

		$portofolio = Portofolio::with('taggedUsers')
			->where('portofolio.id_pengguna', $user->id_pengguna)
			->orWhereHas('taggedUsers', function ($q) use ($user) {
				$q->where('users.id_pengguna', $user->id_pengguna);
			})
			->get();

		$sertifikasi = Sertifikasi::where('id_pengguna', $user->id_pengguna)->get();

		return view('profile', compact('user', 'pengabdian', 'prestasi', 'portofolio', 'sertifikasi'));
	}
}
