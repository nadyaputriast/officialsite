<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Download;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class DownloadController extends Controller
{
    public function index()
    {
        if (auth()->user()->hasRole('admin')) {
            $dataDownload = Download::latest()->get();
        } else {
            $dataDownload = Download::where('status_download', 1)->latest()->get();
        }

        return view('dashboard', [
            'dataDownload' => $dataDownload,
        ]);
    }

    public function create()
    {
        return view('download.create');
    }

    public function store(Request $request)
    {
        // First, check if the user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Anda harus login terlebih dahulu.');
        }

        $request->validate([
            'nama_download' => 'required|string|max:255',
            'jenis_konten' => 'required|string|in:Materi Kuliah, Aplikasi, Manual Book, Source Code, Template, Dataset,E-book',
            'file_konten' => 'required|file|mimes:pdf,docx,zip,sql,json,csv,exe,pptx|max:20480',
        ]);

        $user = Auth::user();

        DB::beginTransaction();

        try {
            // Simpan file terlebih dahulu
            $path = $request->file('file_konten')->store('file_konten', 'public');

            // Setelah file disimpan, baru buat record
            $download = new Download();
            $download->nama_download = $request->nama_download;
            $download->jenis_konten = $request->jenis_konten;
            $download->file_konten = $path;
            $download->id_pengguna = $user->id_pengguna;
            $download->save();

            DB::commit();
            return redirect()->route('dashboard')->with('success', 'Download berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Gagal menyimpan download: ' . $e->getMessage());
            return back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function update(Request $request, $id)
    {
        $download = Download::findOrFail($id);

        if ($download->id_pengguna !== auth()->id()) {
            abort(403, 'Anda tidak memiliki izin untuk mengedit download ini.');
        }

        $request->validate([
            'nama_download' => 'required|string|max:255',
            'jenis_konten' => 'required|string|in:Materi Kuliah, Aplikasi, Manual Book, Source Code, Template, Dataset,E-book',
            'file_konten' => 'required|file|mimes:pdf,docx,zip,sql,json,csv,exe,pptx|max:20480',
        ]);

        DB::beginTransaction();

        try {
            $download->nama_download = $request->nama_download;
            $download->jenis_konten = $request->jenis_konten;

            // Menyimpan dokumen jika ada// Ganti dokumen jika ada dokumen baru
            if ($request->hasFile('file_konten')) {
                // Hapus dokumen lama jika ada
                if ($download->file_konten && Storage::exists('public/' . $download->file_konten)) {
                    Storage::delete('public/' . $download->file_konten);
                }

                // Simpan dokumen baru
                $path = $request->file('file_konten')->store('file_konten', 'public');
                $download->file_konten = $path;
            }
            $download->save();
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $download = Download::findOrFail($id);

        DB::beginTransaction();

        try {
            // Hapus dokumen jika ada
            if ($download->file_konten && Storage::exists('public/' . $download->file_konten)) {
                Storage::delete('public/' . $download->file_konten);
            }

            $download->delete();

            DB::commit();
            return redirect()->route('dashboard')->with('success', 'Informasi download berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Gagal menghapus download: ' . $e->getMessage());
            return back()->with('error', 'Gagal menghapus download.');
        }
    }

    public function edit($id)
    {
        $download = Download::findOrFail($id);

        // Pastikan hanya pemilik yang bisa mengedit
        if ($download->id_pengguna !== auth()->id()) {
            abort(403, 'Anda tidak memiliki izin untuk mengedit informasi download ini.');
        }

        return view('download.edit', compact('download'));
    }

    public function show($id)
    {
        $download = Download::findOrFail($id);
        return view('download.show', compact('download'));
    }

    public function validateDownload($id)
    {
        $download = Download::findOrFail($id);

        // Pastikan hanya admin yang bisa memvalidasi
        if (!auth()->user()->hasRole('admin')) {
            abort(403, 'Anda tidak memiliki izin untuk memvalidasi download ini.');
        }

        try {
            $download->status_download = 1; // Ubah status menjadi valid
            $download->save();

            return redirect()->route('dashboard')->with('success', 'Download berhasil divalidasi.');
        } catch (\Exception $e) {
            \Log::error('Gagal memvalidasi download: ' . $e->getMessage());
            return back()->with('error', 'Gagal memvalidasi download.');
        }
    }
}
