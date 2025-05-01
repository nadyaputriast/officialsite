<?php
namespace App\Http\Controllers;

use App\Models\KomentarPortofolio;
use App\Models\LampiranKomentar;
use App\Models\Portofolio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KomentarPortofolioController extends Controller
{
    public function store(Request $request, $id_portofolio)
    {
        $request->validate([
            'komentar' => 'required|string|max:1000',
            'gambar.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validasi gambar
        ]);

        $portofolio = Portofolio::findOrFail($id_portofolio);

        // Simpan komentar
        $komentar = KomentarPortofolio::create([
            'id_portofolio' => $portofolio->id_portofolio,
            'id_pengguna' => auth()->id(),
            'komentar' => $request->input('komentar'),
        ]);

        // Simpan gambar jika ada
        if ($request->hasFile('gambar')) {
            foreach ($request->file('gambar') as $file) {
                $path = $file->store('komentar_gambar', 'public'); // Simpan di storage/public/komentar_gambar
                LampiranKomentar::create([
                    'id_komentar_portofolio' => $komentar->id_komentar_portofolio,
                    'path_gambar' => $path,
                ]);
            }
        }

        return redirect()->route('portofolio.show', $id_portofolio)->with('success', 'Komentar berhasil ditambahkan.');
    }
}