<?php

namespace App\Http\Controllers;

use App\Models\Portofolio;
use App\Models\Mahasiswa;
use App\Models\Dosen;
use App\Models\User;
use App\Models\KategoriPortofolio;
use App\Models\GambarPortofolio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PortofolioController extends Controller
{
    public function index()
    {
        $dataPortofolio = Portofolio::with(['owner', 'taggedUsers'])
            ->where('status_portofolio', true)
            ->get();

        return view('dashboard', [
            'dataPortofolio' => $dataPortofolio,
        ]);
    }

    public function create()
    {
        return view('portofolio.create');
    }

    // Removed duplicate 'show' method to resolve the error.
    public function store(Request $request)
    {
        // First, check if the user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Anda harus login terlebih dahulu.');
        }

        // Validasi input
        $request->validate([
            'nama_portofolio' => 'required|string|max:255',
            'kategori_portofolio' => 'required|array',
            'deskripsi_portofolio' => 'required|string',
            'tautan_portofolio' => 'required|url',
            'gambar_portofolio' => 'required|array',
            'gambar_portofolio.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'user_tags' => 'nullable|string',
        ]);

        // Get the authenticated user
        $user = Auth::user();

        DB::beginTransaction();

        try {
            // Menyimpan portofolio
            $portofolio = new Portofolio();
            $portofolio->nama_portofolio = $request->input('nama_portofolio');
            $portofolio->deskripsi_portofolio = $request->input('deskripsi_portofolio');
            $portofolio->tautan_portofolio = $request->input('tautan_portofolio');
            $portofolio->id_pengguna = $user->id_pengguna;
            $portofolio->save();

            // Menyimpan kategori portofolio
            if (!empty($request->input('kategori_portofolio'))) {
                foreach ($request->input('kategori_portofolio') as $kategoriNama) {
                    KategoriPortofolio::create([
                        'kategori_portofolio' => $kategoriNama,
                        'id_portofolio' => $portofolio->id_portofolio
                    ]);
                }
            }

            // Menyimpan gambar portofolio
            if ($request->hasFile('gambar_portofolio')) {
                foreach ($request->file('gambar_portofolio') as $image) {
                    $path = $image->store('public/portofolio');
                    GambarPortofolio::create([
                        'gambar_portofolio' => $path,
                        'id_portofolio' => $portofolio->id_portofolio,
                    ]);
                }
            }

            // Menangani tag pengguna jika ada
            if (!empty($request->user_tags)) {
                $tags = collect(explode(',', $request->user_tags))->map(function ($tag) {
                    return trim(ltrim($tag, '@')); // Hapus spasi dan simbol '@'
                });

                $taggedUsers = User::whereIn('nama_pengguna', $tags)->pluck('id_pengguna');
                if ($taggedUsers->isNotEmpty()) {
                    $portofolio->taggedUsers()->attach($taggedUsers);
                }
            }

            DB::commit();
            return redirect()->route('dashboard')->with('success', 'Portofolio berhasil disimpan');
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Gagal menyimpan portofolio: ' . $e->getMessage());
            return back()->with('error', 'Gagal menyimpan portofolio.')->withInput();
        }
    }

    public function update(Request $request, $id)
    {
        $portofolio = Portofolio::findOrFail($id);

        if ($portofolio->id_pengguna !== auth()->id()) {
            abort(403, 'Anda tidak memiliki izin untuk mengedit portofolio ini.');
        }

        $request->validate([
            'nama_portofolio' => 'required|string|max:255',
            'deskripsi_portofolio' => 'required|string',
            'tautan_portofolio' => 'required|url',
            'gambar_portofolio.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'user_tags' => 'nullable|string',
        ]);

        DB::beginTransaction();

        try {
            $portofolio->nama_portofolio = $request->nama_portofolio;
            $portofolio->deskripsi_portofolio = $request->deskripsi_portofolio;
            $portofolio->tautan_portofolio = $request->tautan_portofolio;
            $portofolio->save();

            if ($request->has('kategori_portofolio')) {
                // Hapus kategori lama
                KategoriPortofolio::where('id_portofolio', $portofolio->id_portofolio)->delete();

                // Tambahkan kategori baru
                foreach ($request->kategori_portofolio as $kategori) {
                    KategoriPortofolio::create([
                        'id_portofolio' => $portofolio->id_portofolio,
                        'kategori_portofolio' => $kategori,
                    ]);
                }
            }

            // Jika ada gambar baru, hapus gambar lama lalu simpan yang baru
            if ($request->hasFile('gambar_portofolio')) {
                // Hapus gambar lama dari storage dan database
                foreach ($portofolio->gambar as $gambar) {
                    Storage::delete($gambar->gambar_portofolio);
                    $gambar->delete();
                }

                // Simpan gambar baru
                foreach ($request->file('gambar_portofolio') as $image) {
                    $path = $image->store('public/portofolio');
                    GambarPortofolio::create([
                        'gambar_portofolio' => $path,
                        'id_portofolio' => $portofolio->id_portofolio,
                    ]);
                }
            }

            // Update tag pengguna
            $portofolio->taggedUsers()->detach(); // Hapus tag lama
            if (!empty($request->user_tags)) {
                $tags = collect(explode(',', $request->user_tags))->map(function ($tag) {
                    return trim(ltrim($tag, '@'));
                });

                $taggedUsers = User::whereIn('nama_pengguna', $tags)->pluck('id_pengguna');
                if ($taggedUsers->isNotEmpty()) {
                    $portofolio->taggedUsers()->attach($taggedUsers);
                }
            }

            DB::commit();

            return redirect()->route('portofolio.show', $id)->with('success', 'Portofolio berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $portofolio = Portofolio::findOrFail($id);

        DB::beginTransaction();

        try {
            // Hapus kategori terkait
            KategoriPortofolio::where('id_portofolio', $id)->delete();

            // Hapus gambar terkait
            $gambarPortofolios = GambarPortofolio::where('id_portofolio', $id)->get();
            foreach ($gambarPortofolios as $gambar) {
                // Hapus file fisik jika ada
                if (Storage::exists($gambar->gambar_portofolio)) {
                    Storage::delete($gambar->gambar_portofolio);
                }
                $gambar->delete();
            }

            // Hapus tagged users
            $portofolio->taggedUsers()->detach();

            // Hapus semua tagged users kecuali pemilik portofolio
            $portofolio->taggedUsers()->sync([], false);

            DB::commit();
            return redirect()->route('dashboard')->with('success', 'Portofolio berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Gagal menghapus portofolio: ' . $e->getMessage());
            return back()->with('error', 'Gagal menghapus portofolio.');
        }
    }

    public function show($id)
    {
        $portofolio = Portofolio::with(['gambar', 'kategoris', 'taggedUsers', 'owner'])->findOrFail($id);

        return view('portofolio.view', compact('portofolio'));
    }

    public function edit($id)
    {
        $portofolio = Portofolio::with(['gambar', 'kategoris', 'taggedUsers'])->findOrFail($id);

        // Pastikan hanya pemilik yang bisa mengedit
        if ($portofolio->id_pengguna !== auth()->id()) {
            abort(403, 'Anda tidak memiliki izin untuk mengedit portofolio ini.');
        }

        // Ambil semua kategori
        $semuaKategori = KategoriPortofolio::distinct('kategori_portofolio')->pluck('kategori_portofolio');

        return view('portofolio.edit', compact('portofolio', 'semuaKategori'));
    }
}