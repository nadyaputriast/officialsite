<?php

namespace App\Http\Controllers;

use App\Models\Notifikasi;
use App\Models\Sertifikasi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class SertifikasiController extends Controller
{
    public function index()
    {
        $dataSertifikasi = Sertifikasi::with(['owner'])
            ->where('status_sertifikasi', true)
            ->get();

        return view('dashboard', [
            'dataSertifikasi' => $dataSertifikasi,
        ]);
    }

    public function create()
    {
        return view('sertifikasi.create');
    }

    public function store(Request $request)
    {
        // First, check if the user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Anda harus login terlebih dahulu.');
        }

        // Validasi input
        $request->validate([
            'nama_sertifikasi' => 'required|string|max:255',
            'deskripsi_sertifikasi' => 'required|string',
            'tanggal_sertifikasi' => 'required|date',
            'penyelenggara' => 'required|string|max:255',
            'masa_berlaku' => 'nullable|integer|min:1',
            'seumur_hidup' => 'nullable|boolean',
            'file_sertifikasi' => 'required|file|mimes:pdf|max:2048',
        ]);

        // Tentukan nilai masa berlaku
        $masaBerlaku = $request->has('seumur_hidup') && $request->seumur_hidup == 1 ? 0 : $request->masa_berlaku;

        // Validasi tambahan jika masa berlaku kosong
        if ($masaBerlaku === null) {
            return back()->with('error', 'Harap masukkan jumlah tahun atau pilih "Seumur Hidup".')->withInput();
        }

        // Get the authenticated user
        $user = Auth::user();

        DB::beginTransaction();

        try {
            // Menyimpan sertifikasi
            $sertifikasi = new Sertifikasi();
            $sertifikasi->nama_sertifikasi = $request->input('nama_sertifikasi');
            $sertifikasi->deskripsi_sertifikasi = $request->input('deskripsi_sertifikasi');
            $sertifikasi->tanggal_sertifikasi = $request->input('tanggal_sertifikasi');
            $sertifikasi->penyelenggara = $request->input('penyelenggara');
            $sertifikasi->masa_berlaku = $masaBerlaku;
            $sertifikasi->id_pengguna = $user->id_pengguna;

            // Menyimpan dokumen jika ada
            if ($request->hasFile('file_sertifikasi')) {
                $path = $request->file('file_sertifikasi')->store('sertifikasi', 'public');
                $sertifikasi->file_sertifikasi = $path;
            }

            $sertifikasi->save();

            DB::commit();
            return redirect()->route('dashboard')->with('success', 'Sertifikasi berhasil disimpan');
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Gagal menyimpan sertifikasi: ' . $e->getMessage());
            return back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function update(Request $request, $id)
    {
        $sertifikasi = Sertifikasi::findOrFail($id);

        if ($sertifikasi->id_pengguna !== auth()->user()->id_pengguna) {
            abort(403, 'Anda tidak memiliki izin untuk mengedit sertifikasi ini.');
        }

        $request->validate([
            'nama_sertifikasi' => 'required|string|max:255',
            'deskripsi_sertifikasi' => 'required|string',
            'tanggal_sertifikasi' => 'required|date',
            'penyelenggara' => 'required|string|max:255',
            'masa_berlaku' => 'nullable|integer|min:1',
            'seumur_hidup' => 'nullable|boolean',
            'file_sertifikasi' => 'nullable|file|mimes:pdf|max:2048', // ✅ nullable = optional
        ]);

        $masaBerlaku = $request->has('seumur_hidup') && $request->seumur_hidup == 1 ? 0 : $request->masa_berlaku;

        if (!$request->has('seumur_hidup') && ($masaBerlaku === null || $masaBerlaku < 1)) {
            return back()->with('error', 'Harap masukkan jumlah tahun atau pilih "Seumur Hidup".')->withInput();
        }

        DB::beginTransaction();

        try {
            $sertifikasi->nama_sertifikasi = $request->nama_sertifikasi;
            $sertifikasi->deskripsi_sertifikasi = $request->deskripsi_sertifikasi;
            $sertifikasi->tanggal_sertifikasi = $request->tanggal_sertifikasi;
            $sertifikasi->penyelenggara = $request->penyelenggara;
            $sertifikasi->masa_berlaku = $masaBerlaku ?? 0;

            if ($request->hasFile('file_sertifikasi')) {
                if ($sertifikasi->file_sertifikasi && Storage::disk('public')->exists($sertifikasi->file_sertifikasi)) {
                    Storage::disk('public')->delete($sertifikasi->file_sertifikasi);
                }

                $path = $request->file('file_sertifikasi')->store('sertifikasi', 'public');
                $sertifikasi->file_sertifikasi = $path;
            }

            $sertifikasi->save();

            DB::commit();

            return redirect()->route('sertifikasi.show', $id)->with('success', 'Sertifikasi berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy($id)
    {
        $sertifikasi = Sertifikasi::findOrFail($id);

        DB::beginTransaction();

        try {
            if ($sertifikasi->file_sertifikasi && Storage::exists('public/' . $sertifikasi->file_sertifikasi)) {
                Storage::delete('public/' . $sertifikasi->file_sertifikasi);
            }
            $sertifikasi->delete();

            DB::commit();
            return redirect()->route('dashboard')->with('success', 'Sertifikasi berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Gagal menghapus sertifikasi: ' . $e->getMessage());
            return back()->with('error', 'Gagal menghapus sertifikasi.');
        }
    }

    public function show($id)
    {
        $sertifikasi = Sertifikasi::with(['owner'])->findOrFail($id);

        return view('sertifikasi.view', compact('sertifikasi'));
    }

    public function edit($id)
    {
        $sertifikasi = Sertifikasi::with(['owner'])->findOrFail($id);

        if ($sertifikasi->id_pengguna !== auth()->id()) {
            abort(403, 'Anda tidak memiliki izin untuk mengedit sertifikasi ini.');
        }

        return view('sertifikasi.edit', compact('sertifikasi'));
    }

    public function validateSertifikasi($id)
    {
        $sertifikasi = Sertifikasi::findOrFail($id);

        if (!auth()->user()->hasRole('admin')) {
            abort(403, 'Anda tidak memiliki izin untuk memvalidasi portofolio ini.');
        }

        try {
            $sertifikasi->status_sertifikasi = 1; // Ubah status menjadi valid
            $sertifikasi->save();

            Notifikasi::create([
                'isi_notifikasi' => 'Sertifikasi "' . $sertifikasi->nama_sertifikasi . '" telah divalidasi oleh admin.',
                'notifiable_id' => $sertifikasi->id_sertifikasi,
                'notifiable_type' => 'sertifikasi',
                'id_pengguna' => $sertifikasi->id_pengguna,
            ]);

            return redirect()->route('dashboard')->with('success', 'Sertifikasi berhasil divalidasi.');
        } catch (\Exception $e) {
            \Log::error('Gagal memvalidasi sertifikasi: ' . $e->getMessage());
            return back()->with('error', 'Gagal memvalidasi sertifikasi.');
        }
    }

    public function komentar(Request $request, $id)
    {
        $request->validate([
            'isi_notifikasi' => 'required|string|max:255',
        ]);

        $sertifikasi = Sertifikasi::findOrFail($id);

        // Simpan komentar sebagai notifikasi ke user sertifikasi
        Notifikasi::create([
            'isi_notifikasi' => $request->isi_notifikasi,
            'notifiable_id' => $sertifikasi->id_sertifikasi,
            'notifiable_type' => 'sertifikasi',
            'id_pengguna' => $sertifikasi->id_pengguna,
            'is_read' => false,
        ]);

        return redirect()->back()->with('success', 'Komentar berhasil dikirim.');
    }
}
