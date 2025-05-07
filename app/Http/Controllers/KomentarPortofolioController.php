<?php

namespace App\Http\Controllers;

use App\Models\KomentarPortofolio;
use App\Models\LampiranKomentar;
use App\Models\Portofolio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KomentarPortofolioController extends Controller
{
    /**
     * Tampilkan daftar komentar untuk portofolio tertentu.
     */
    public function index($id_portofolio)
    {
        $portofolio = Portofolio::findOrFail($id_portofolio);
        $komentar = KomentarPortofolio::with('lampiran_komentar', 'pengguna')
            ->where('id_portofolio', $id_portofolio)
            ->latest()
            ->get();

        return view('portofolio.komentar.list', compact('portofolio', 'komentar'));
    }

    /**
     * Simpan komentar baru.
     */
    public function store(Request $request, $id_portofolio)
    {
        // dd($request->all());
        $request->validate([
            'komentar' => 'required|string|max:1000',
            'lampiran_komentar.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $portofolio = Portofolio::findOrFail($id_portofolio);

        // Simpan komentar
        $komentar = KomentarPortofolio::create([
            'id_portofolio' => $portofolio->id_portofolio,
            'id_pengguna' => auth()->id(), // Tambahkan id_pengguna
            'komentar' => $request->input('komentar'),
        ]);

        // Simpan lampiran_komentar jika ada
        if ($request->hasFile('lampiran_komentar')) {
            foreach ($request->file('lampiran_komentar') as $file) {
                $path = $file->store('lampiran_komentar', 'public');
                LampiranKomentar::create([
                    'id_komentar_portofolio' => $komentar->id_komentar_portofolio,
                    'path_gambar' => $path,
                ]);
            }
        }

        return redirect()->route('portofolio.show', $id_portofolio)->with('success', 'Komentar berhasil ditambahkan.');
    }

    /**
     * Tampilkan detail komentar.
     */
    public function show($id_komentar)
    {
        $komentar = KomentarPortofolio::with('lampiran_komentar')->findOrFail($id_komentar);

        return view('portofolio.komentar.show', compact('komentar'));
    }

    /**
     * Update komentar.
     */
    public function update(Request $request, $id_komentar)
    {
        $request->validate([
            'komentar' => 'required|string|max:1000',
            'lampiran_komentar.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $komentar = KomentarPortofolio::findOrFail($id_komentar);

        // Update komentar
        $komentar->update([
            'komentar' => $request->input('komentar'),
        ]);

        // Simpan gambar baru jika ada
        if ($request->hasFile('lampiran_komentar')) {
            foreach ($request->file('lampiran_komentar') as $file) {
                $path = $file->store('lampiran_komentar', 'public');
                LampiranKomentar::create([
                    'id_komentar_portofolio' => $komentar->id_komentar_portofolio,
                    'path_gambar' => $path,
                ]);
            }
        }

        return redirect()->route('portofolio.show', $komentar->id_portofolio)->with('success', 'Komentar berhasil diperbarui.');
    }

    /**
     * Hapus komentar dan lampiran terkait.
     */
    public function destroy($id_komentar)
    {
        $komentar = KomentarPortofolio::with('lampiran_komentar')->findOrFail($id_komentar);

        // Hapus lampiran
        foreach ($komentar->lampiran_komentar as $lampiran) {
            Storage::disk('public')->delete($lampiran->path_gambar);
            $lampiran->delete();
        }

        // Hapus komentar
        $komentar->delete();

        return redirect()->route('portofolio.show', $komentar->id_portofolio)->with('success', 'Komentar berhasil dihapus.');
    }
}
