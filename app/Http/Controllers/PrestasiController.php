<?php

namespace App\Http\Controllers;

use App\Models\Prestasi;
use App\Models\DokumentasiPrestasi;
use App\Models\Notifikasi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PrestasiController extends Controller
{
    public function index()
    {
        $dataPrestasi = Prestasi::with(['owner', 'taggedUsers'])
            ->where('status_prestasi', true)
            ->get();

        return view('dashboard', [
            'dataPrestasi' => $dataPrestasi,
        ]);
    }

    public function create()
    {
        return view('prestasi.create');
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
            'nama_prestasi' => 'required|string|max:255',
            'deskripsi_prestasi' => 'required|string',
            'tanggal_perolehan' => 'required|date',
            'tingkatan_prestasi' => 'required|in:Regional,Nasional,Internasional',
            'jenis_prestasi' => 'required|in:Akademik,Non Akademik',
            'dokumentasi_prestasi' => 'required|array',
            'dokumentasi_prestasi.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'user_tags' => 'nullable|string',
        ]);

        // Get the authenticated user
        $user = Auth::user();

        DB::beginTransaction();

        try {
            // Menyimpan prestasi
            $prestasi = new Prestasi();
            $prestasi->nama_prestasi = $request->input('nama_prestasi');
            $prestasi->deskripsi_prestasi = $request->input('deskripsi_prestasi');
            $prestasi->tanggal_perolehan = $request->input('tanggal_perolehan');
            $prestasi->tingkatan_prestasi = $request->input('tingkatan_prestasi');
            $prestasi->jenis_prestasi = $request->input('jenis_prestasi');
            $prestasi->id_pengguna = $user->id_pengguna;
            $prestasi->save();

            // Menyimpan dokumentasi prestasi
            if ($request->hasFile('dokumentasi_prestasi')) {
                foreach ($request->file('dokumentasi_prestasi') as $image) {
                    $path = $image->store('prestasi', 'public');

                    DokumentasiPrestasi::create([
                        'dokumentasi_prestasi' => $path,
                        'id_prestasi' => $prestasi->id_prestasi,
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
                    $prestasi->taggedUsers()->attach($taggedUsers);
                }
            }

            DB::commit();
            return redirect()->route('dashboard')->with('success', 'Prestasi berhasil disimpan');
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Gagal menyimpan prestasi: ' . $e->getMessage());
            return back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function update(Request $request, $id)
    {
        $prestasi = Prestasi::findOrFail($id);

        if ($prestasi->id_pengguna !== auth()->id()) {
            abort(403, 'Anda tidak memiliki izin untuk mengedit prestasi ini.');
        }

        $request->validate([
            'nama_prestasi' => 'required|string|max:255',
            'deskripsi_prestasi' => 'required|string',
            'tanggal_perolehan' => 'required|date',
            'tingkatan_prestasi' => 'required|in:Regional,Nasional,Internasional',
            'jenis_prestasi' => 'required|in:Akademik,Non Akademik',
            'dokumentasi_prestasi.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'user_tags' => 'nullable|string',
        ]);

        DB::beginTransaction();

        try {
            // Update data prestasi
            $prestasi->nama_prestasi = $request->nama_prestasi;
            $prestasi->deskripsi_prestasi = $request->deskripsi_prestasi;
            $prestasi->tanggal_perolehan = $request->tanggal_perolehan;
            $prestasi->tingkatan_prestasi = $request->tingkatan_prestasi;
            $prestasi->jenis_prestasi = $request->jenis_prestasi;
            $prestasi->save(); // Simpan perubahan pada model Prestasi

            if ($request->has('existing_dokumentasi')) {
                // Ambil ID dokumentasi yang dipertahankan
                $existingDokumentasiIds = $request->existing_dokumentasi;
            
                // Hapus dokumentasi yang tidak ada dalam input hidden
                $dokumentasiUntukDihapus = $prestasi->dokumentasi->whereNotIn('id_dokumentasi', $existingDokumentasiIds);
                foreach ($dokumentasiUntukDihapus as $dokumentasi) {
                    if (Storage::exists('public/' . $dokumentasi->dokumentasi_prestasi)) {
                        Storage::delete('public/' . $dokumentasi->dokumentasi_prestasi);
                    }
                    $dokumentasi->delete();
                }
            } else {
                // Jika tidak ada dokumentasi yang dipertahankan, hapus semua dokumentasi
                foreach ($prestasi->dokumentasi as $dokumentasi) {
                    if (Storage::exists('public/' . $dokumentasi->dokumentasi_prestasi)) {
                        Storage::delete('public/' . $dokumentasi->dokumentasi_prestasi);
                    }
                    $dokumentasi->delete();
                }
            }
            
            // Tambahkan dokumentasi baru
            if ($request->hasFile('dokumentasi_prestasi')) {
                foreach ($request->file('dokumentasi_prestasi') as $image) {
                    $path = $image->store('prestasi', 'public');
                    DokumentasiPrestasi::create([
                        'dokumentasi_prestasi' => $path,
                        'id_prestasi' => $prestasi->id_prestasi,
                    ]);
                }
            }

            // Update tag pengguna
            if (!empty($request->user_tags)) {
                $tags = collect(explode(',', $request->user_tags))->map(function ($tag) {
                    return trim(ltrim($tag, '@'));
                });

                // Ambil pengguna yang ditag sebelumnya
                $taggedUsersLama = $prestasi->taggedUsers->pluck('nama_pengguna');

                // Hapus tag lama yang tidak ada dalam input baru
                $tagsUntukDihapus = $taggedUsersLama->diff($tags);
                $usersUntukDihapus = User::whereIn('nama_pengguna', $tagsUntukDihapus)->pluck('id_pengguna');
                $prestasi->taggedUsers()->detach($usersUntukDihapus);

                // Tambahkan tag baru yang belum ada
                $tagsUntukDitambahkan = $tags->diff($taggedUsersLama);
                $usersUntukDitambahkan = User::whereIn('nama_pengguna', $tagsUntukDitambahkan)->pluck('id_pengguna');
                $prestasi->taggedUsers()->attach($usersUntukDitambahkan);
            } else {
                // Jika tidak ada tag baru, hapus semua tag pengguna
                $prestasi->taggedUsers()->detach();
            }

            DB::commit();

            return redirect()->route('prestasi.show', $id)->with('success', 'Prestasi berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $prestasi = Prestasi::findOrFail($id);

        DB::beginTransaction();

        try {
            // Hapus dokumentasi terkait
            $prestasi->dokumentasi->each(function ($dokumentasi) {
                if (Storage::exists('public/' . $dokumentasi->dokumentasi_prestasi)) {
                    Storage::delete('public/' . $dokumentasi->dokumentasi_prestasi);
                }
                $dokumentasi->delete();
            });

            // Hapus tag pengguna terkait
            $prestasi->taggedUsers()->detach();

            // Hapus data prestasi
            $prestasi->delete();

            DB::commit();

            return redirect()->route('dashboard')->with('success', 'Prestasi berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        $prestasi = Prestasi::with(['dokumentasi', 'taggedUsers', 'owner'])->findOrFail($id);

        return view('prestasi.view', compact('prestasi'));
    }

    public function edit($id)
    {
        $prestasi = Prestasi::with(['dokumentasi'])->findOrFail($id);

        // Pastikan hanya pemilik yang bisa mengedit
        if ($prestasi->id_pengguna !== auth()->id()) {
            abort(403, 'Anda tidak memiliki izin untuk mengedit prestasi ini.');
        }

        return view('prestasi.edit', compact('prestasi'));
    }

    public function validatePrestasi($id)
    {
        $prestasi = Prestasi::findOrFail($id);

        // Pastikan hanya admin yang bisa memvalidasi
        if (!auth()->user()->hasRole('admin')) {
            abort(403, 'Anda tidak memiliki izin untuk memvalidasi prestasi ini.');
        }

        try {
            $prestasi->status_prestasi = 1; // Ubah status menjadi valid
            $prestasi->save();

            Notifikasi::create([
                'isi_notifikasi' => 'Prestasi "' . $prestasi->nama_prestasi . '" telah divalidasi oleh admin.',
                'notifiable_id' => $prestasi->id_prestasi,
                'notifiable_type' => 'prestasi',
                'id_pengguna' => $prestasi->id_pengguna,
            ]);

            return redirect()->route('dashboard')->with('success', 'prestasi berhasil divalidasi.');
        } catch (\Exception $e) {
            \Log::error('Gagal memvalidasi prestasi: ' . $e->getMessage());
            return back()->with('error', 'Gagal memvalidasi prestasi.');
        }
    }

    public function komentar(Request $request, $id)
    {
        $request->validate([
            'isi_notifikasi' => 'required|string|max:255',
        ]);

        $prestasi = Prestasi::findOrFail($id);

        // Simpan komentar sebagai notifikasi ke user prestasi
        Notifikasi::create([
            'isi_notifikasi' => $request->isi_notifikasi,
            'notifiable_id' => $prestasi->id_prestasi,
            'notifiable_type' => 'prestasi',
            'id_pengguna' => $prestasi->id_pengguna,
            'is_read' => false,
        ]);

        return redirect()->back()->with('success', 'Komentar berhasil dikirim.');
    }
}
