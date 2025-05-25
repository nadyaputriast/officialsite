<?php

namespace App\Http\Controllers;

use App\Models\OprekLokerProject;
use App\Models\KualifikasiOprek;
use App\Models\Notifikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use phpDocumentor\Reflection\Types\Nullable;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class OprekProjectController extends Controller
{
    public function index()
    {
        if (auth()->user()->hasRole('admin')) {
            $dataOprek = OprekLokerProject::latest()->get();
        } else {
            $dataOprek = OprekLokerProject::where('status_project', 1)->latest()->get();
        }

        return view('dashboard', [
            'dataOprek' => $dataOprek,
        ]);
    }

    public function create()
    {
        return view('oprek.create');
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
            'nama_project' => 'required|string|max:255',
            'deskripsi_project' => 'required|string',
            'deadline_project' => 'required|date',
            'penyelenggara' => 'required|string|in:Dosen,Mahasiswa,Organisasi,Eksternal',
            'nama_penyelenggara' => 'required|string|max:255',
            'kategori_project' => 'required|string|in:Penelitian,Pengembangan Aplikasi,Pengabdian Masyarakat,Inisiatif Pribadi',
            'tautan_project' => 'required|url',
            'output_project' => 'required|string|in:Website,Mobile Apps,API Development,Game,Machine Learning/AI Project,Cyber Security,Automation,Embedded System',
            'kualifikasi_oprek' => 'required|array',
            'kualifikasi_oprek.*' => 'required|string|max:255',
            'flyer_informasi' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Get the authenticated user
        $user = Auth::user();

        DB::beginTransaction();

        try {
            // Menyimpan oprek
            $oprek = new OprekLokerProject();
            $oprek->nama_project = $request->input('nama_project');
            $oprek->deskripsi_project = $request->input('deskripsi_project');
            $oprek->deadline_project = $request->input('deadline_project');
            $oprek->penyelenggara = $request->input('penyelenggara');
            $oprek->nama_penyelenggara = $request->input('nama_penyelenggara');
            $oprek->kategori_project = $request->input('kategori_project');
            $oprek->tautan_project = $request->input('tautan_project');
            $oprek->output_project = $request->input('output_project');
            $oprek->id_pengguna = $user->id_pengguna;
            $oprek->save();

            $oprek->status_project = $user->hasRole('admin') ? 1 : 0;

            // Menyimpan kualifikasi oprek
            if (!empty($request->input('kualifikasi_oprek'))) {
                foreach ($request->input('kualifikasi_oprek') as $kualifikasi) {
                    KualifikasiOprek::create([
                        'kualifikasi_oprek' => $kualifikasi,
                        'id_oprek' => $oprek->id_oprek
                    ]);
                }
            }

            // $path = $image->store('portofolio', 'public');

            // Menyimpan gambar/flyer informasi
            if ($request->hasFile('flyer_informasi')) {
                $path = $request->file('flyer_informasi')->store('oprek', 'public');
                $oprek->flyer_informasi = $path;
            } else {
                $oprek->flyer_informasi = 'default_flyer.jpg';
            }

            $oprek->save();

            DB::commit();
            return redirect()->route('dashboard')->with('success', 'Oprek berhasil diposting');
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Gagal menyimpan informasi hiring: ' . $e->getMessage());
            return back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function update(Request $request, $id)
    {
        $oprek = OprekLokerProject::findOrFail($id);

        if ($oprek->id_pengguna !== auth()->id()) {
            abort(403, 'Anda tidak memiliki izin untuk mengedit informasi hiring ini.');
        }

        $request->validate([
            'nama_project' => 'required|string|max:255',
            'deskripsi_project' => 'required|string',
            'deadline_project' => 'required|date',
            'penyelenggara' => 'required|string|max:255',
            'nama_penyelenggara' => 'required|string|max:255',
            'kategori_project' => 'required|string|max:255',
            'tautan_project' => 'required|url',
            'output_project' => 'required|string|max:255',
            'flyer_informasi' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'kualifikasi_oprek' => 'required|array',
            'kualifikasi_oprek.*' => 'string|max:255',
        ]);

        DB::beginTransaction();

        try {
            $oprek->nama_project = $request->nama_project;
            $oprek->deskripsi_project = $request->deskripsi_project;
            $oprek->deadline_project = $request->deadline_project;
            $oprek->penyelenggara = $request->penyelenggara;
            $oprek->nama_penyelenggara = $request->nama_penyelenggara;
            $oprek->kategori_project = $request->kategori_project;
            $oprek->tautan_project = $request->tautan_project;
            $oprek->output_project = $request->output_project;

            if ($request->hasFile('flyer_informasi')) {
                $path = $request->file('flyer_informasi')->store('oprek', 'public');
                $oprek->flyer_informasi = $path;
            }

            $oprek->save();

            // Hapus kualifikasi lama
            $oprek->kualifikasi()->delete();

            // Tambahkan kualifikasi baru
            if ($request->has('kualifikasi_oprek')) {
                foreach ($request->kualifikasi_oprek as $kualifikasi) {
                    $oprek->kualifikasi()->create(['kualifikasi_oprek' => $kualifikasi]);
                }
            }

            DB::commit();

            return redirect()->route('oprek.show', $id)->with('success', 'oprek berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $oprek = OprekLokerProject::findOrFail($id);

        DB::beginTransaction();

        try {
            // Hapus kategori terkait
            KualifikasiOprek::where('id_oprek', $id)->delete();

            DB::commit();
            return redirect()->route('dashboard')->with('success', 'oprek berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Gagal menghapus oprek: ' . $e->getMessage());
            return back()->with('error', 'Gagal menghapus oprek.');
        }
    }

    public function show($id)
    {
        $oprek = OprekLokerProject::with(['kualifikasi', 'owner'])->findOrFail($id);

        return view('oprek.view', compact('oprek'));
    }

    public function edit($id)
    {
        $oprek = OprekLokerProject::with('kualifikasi')->findOrFail($id);

        return view('oprek.edit', compact('oprek'));
    }

    public function validateProject($id)
    {
        $oprek = OprekLokerProject::findOrFail($id);

        if (!auth()->user()->hasRole('admin')) {
            abort(403, 'Anda tidak memiliki izin untuk memvalidasi oprek ini.');
        }

        try {
            $oprek->status_project = 1; // Ubah status menjadi valid
            $oprek->save();

            Notifikasi::create([
                'isi_notifikasi' => 'Oprek "' . $oprek->nama_project . '" telah divalidasi oleh admin.',
                'notifiable_id' => $oprek->id_oprek,
                'notifiable_type' => 'oprek_loker_project',
                'id_pengguna' => $oprek->id_pengguna,
            ]);

            return redirect()->route('dashbodard')->with('success', 'Oprek berhasil divalidasi.');
        } catch (\Exception $e) {
            \Log::error('Gagal memvalidasi oprek: ' . $e->getMessage());
            return back()->with('error', 'Gagal memvalidasi oprek.');
        }
    }

    public function komentar(Request $request, $id)
    {
        $request->validate([
            'isi_notifikasi' => 'required|string|max:255',
        ]);

        $oprek = OprekLokerProject::findOrFail($id);

        // Simpan komentar sebagai notifikasi ke user oprek
        Notifikasi::create([
            'isi_notifikasi' => $request->isi_notifikasi,
            'notifiable_id' => $oprek->id_oprek,
            'notifiable_type' => 'oprek_loker_project',
            'id_pengguna' => $oprek->id_pengguna,
            'is_read' => false,
        ]);

        return redirect()->back()->with('success', 'Komentar berhasil dikirim.');
    }
}
