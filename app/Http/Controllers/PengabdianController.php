<?php

namespace App\Http\Controllers;

use App\Models\DokumentasiPengabdian;
use App\Models\Notifikasi;
use App\Models\Pengabdian;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PengabdianController extends Controller
{
    public function index()
    {
        $dataPengabdian = Pengabdian::with(['owner', 'taggedUsers'])
            ->where('status_pengabdian', true)
            ->get();

        return view('dashboard', [
            'dataPengabdian' => $dataPengabdian,
        ]);
    }

    public function create()
    {
        return view('pengabdian.create');
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
            'judul_pengabdian' => 'required|string|max:255',
            'deskripsi_pengabdian' => 'required|string',
            'tanggal_pengabdian' => 'required|date',
            'pelaksana' => 'required|string|max:255',
            'dokumentasi_pengabdian' => 'required|array',
            'dokumentasi_pengabdian.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'user_tags' => 'nullable|string',
        ]);

        // Get the authenticated user
        $user = Auth::user();

        DB::beginTransaction();

        try {
            // Menyimpan pengabdian
            $pengabdian = new Pengabdian();
            $pengabdian->judul_pengabdian = $request->input('judul_pengabdian');
            $pengabdian->deskripsi_pengabdian = $request->input('deskripsi_pengabdian');
            $pengabdian->tanggal_pengabdian = $request->input('tanggal_pengabdian');
            $pengabdian->pelaksana = $request->input('pelaksana');
            $pengabdian->id_pengguna = $user->id_pengguna;
            $pengabdian->save();

            // Menyimpan dokumentasi pengabdian
            if ($request->hasFile('dokumentasi_pengabdian')) {
                foreach ($request->file('dokumentasi_pengabdian') as $image) {
                    $path = $image->store('pengabdian', 'public');

                    DokumentasiPengabdian::create([
                        'dokumentasi_pengabdian' => $path,
                        'id_pengabdian' => $pengabdian->id_pengabdian,
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
                    $pengabdian->taggedUsers()->attach($taggedUsers);
                }
            }

            DB::commit();
            return redirect()->route('dashboard')->with('success', 'Pengabdian berhasil disimpan');
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Gagal menyimpan pengabdian: ' . $e->getMessage());
            return back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function update(Request $request, $id)
    {
        $pengabdian = Pengabdian::findOrFail($id);

        // Check authorization
        if ($pengabdian->id_pengguna !== auth()->id()) {
            abort(403, 'Anda tidak memiliki izin untuk mengedit pengabdian ini.');
        }

        $request->validate([
            'judul_pengabdian' => 'required|string|max:255',
            'deskripsi_pengabdian' => 'required|string',
            'tanggal_pengabdian' => 'required|date',
            'pelaksana' => 'required|string|max:255',
            'dokumentasi_pengabdian' => 'sometimes|array',
            'dokumentasi_pengabdian.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'user_tags' => 'nullable|string',
        ]);

        DB::beginTransaction();

        try {
            $pengabdian->judul_pengabdian = $request->judul_pengabdian;
            $pengabdian->deskripsi_pengabdian = $request->deskripsi_pengabdian;
            $pengabdian->tanggal_pengabdian = $request->tanggal_pengabdian;
            $pengabdian->pelaksana = $request->pelaksana;

            $pengabdian->save();

            if ($request->hasFile('dokumentasi_pengabdian')) {
                foreach ($pengabdian->dokumentasi as $dokumentasi) {
                    if (Storage::disk('public')->exists($dokumentasi->dokumentasi_pengabdian)) {
                        Storage::disk('public')->delete($dokumentasi->dokumentasi_pengabdian);
                    }
                    $dokumentasi->delete();
                }

                foreach ($request->file('dokumentasi_pengabdian') as $image) {
                    $path = $image->store('pengabdian', 'public');
                    DokumentasiPengabdian::create([
                        'dokumentasi_pengabdian' => $path,
                        'id_pengabdian' => $pengabdian->id_pengabdian,
                    ]);
                }
            }

            if (!empty($request->user_tags)) {
                $tags = collect(explode(',', $request->user_tags))
                    ->map(function ($tag) {
                        return trim(ltrim($tag, '@'));
                    })
                    ->filter(); 

                $currentTaggedUsers = $pengabdian->taggedUsers->pluck('nama_pengguna');

                // Find users to remove
                $tagsToRemove = $currentTaggedUsers->diff($tags);
                if ($tagsToRemove->isNotEmpty()) {
                    $usersToRemove = User::whereIn('nama_pengguna', $tagsToRemove)->pluck('id_pengguna');
                    $pengabdian->taggedUsers()->detach($usersToRemove);
                }

                // Find users to add
                $tagsToAdd = $tags->diff($currentTaggedUsers);
                if ($tagsToAdd->isNotEmpty()) {
                    $usersToAdd = User::whereIn('nama_pengguna', $tagsToAdd)->pluck('id_pengguna');
                    $pengabdian->taggedUsers()->attach($usersToAdd);
                }
            } else {
                // If no tags provided, remove all tags
                $pengabdian->taggedUsers()->detach();
            }

            DB::commit();

            return redirect()->route('pengabdian.show', $id)->with('success', 'Pengabdian berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Gagal update pengabdian: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy($id)
    {
        $pengabdian = Pengabdian::findOrFail($id);

        // Check authorization (admin or owner)
        if (!auth()->user()->hasRole('admin') && $pengabdian->id_pengguna !== auth()->id()) {
            abort(403, 'Anda tidak memiliki izin untuk menghapus pengabdian ini.');
        }

        DB::beginTransaction();

        try {
            // Delete documentation files and records
            foreach ($pengabdian->dokumentasi as $dokumentasi) {
                if (Storage::disk('public')->exists($dokumentasi->dokumentasi_pengabdian)) {
                    Storage::disk('public')->delete($dokumentasi->dokumentasi_pengabdian);
                }
                $dokumentasi->delete();
            }

            $pengabdian->taggedUsers()->detach();

            // Delete related notifications
            Notifikasi::where('notifiable_id', $id)
                ->where('notifiable_type', 'pengabdian')
                ->delete();

            // Delete the pengabdian
            $pengabdian->delete();

            DB::commit();
            return redirect()->route('dashboard')->with('success', 'Pengabdian berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Gagal menghapus pengabdian: ' . $e->getMessage());
            return back()->with('error', 'Gagal menghapus pengabdian: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        $pengabdian = Pengabdian::with(['dokumentasi', 'taggedUsers', 'owner'])->findOrFail($id);

        return view('pengabdian.view', compact('pengabdian'));
    }

    public function edit($id)
    {
        $pengabdian = Pengabdian::with(['dokumentasi'])->findOrFail($id);

        // Pastikan hanya pemilik yang bisa mengedit
        if ($pengabdian->id_pengguna !== auth()->id()) {
            abort(403, 'Anda tidak memiliki izin untuk mengedit pengabdian ini.');
        }

        return view('pengabdian.edit', compact('pengabdian'));
    }

    public function validatePengabdian($id)
    {
        $pengabdian = Pengabdian::findOrFail($id);

        // Pastikan hanya admin yang bisa memvalidasi
        if (!auth()->user()->hasRole('admin')) {
            abort(403, 'Anda tidak memiliki izin untuk memvalidasi pengabdian ini.');
        }

        try {
            $pengabdian->status_pengabdian = 1; // Ubah status menjadi valid
            $pengabdian->save();

            Notifikasi::create([
                'isi_notifikasi' => 'Pengabdian "' . $pengabdian->judul_pengabdian . '" telah divalidasi oleh admin.',
                'notifiable_id' => $pengabdian->id_pengabdian,
                'notifiable_type' => 'pengabdian',
                'id_pengguna' => $pengabdian->id_pengguna,
            ]);

            return redirect()->route('dashboard')->with('success', 'pengabdian berhasil divalidasi.');
        } catch (\Exception $e) {
            \Log::error('Gagal memvalidasi pengabdian: ' . $e->getMessage());
            return back()->with('error', 'Gagal memvalidasi pengabdian.');
        }
    }

    public function komentar(Request $request, $id)
    {
        $request->validate([
            'isi_notifikasi' => 'required|string|max:255',
        ]);

        $pengabdian = Pengabdian::findOrFail($id);

        // Simpan komentar sebagai notifikasi ke user pengabdian
        Notifikasi::create([
            'isi_notifikasi' => $request->isi_notifikasi,
            'notifiable_id' => $pengabdian->id_pengabdian,
            'notifiable_type' => 'pengabdian',
            'id_pengguna' => $pengabdian->id_pengguna,
            'is_read' => false,
        ]);

        return redirect()->back()->with('success', 'Komentar berhasil dikirim.');
    }
}
