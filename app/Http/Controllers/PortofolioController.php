<?php

namespace App\Http\Controllers;

use App\Models\Portofolio;
use App\Models\User;
use App\Models\KategoriPortofolio;
use App\Models\GambarPortofolio;
use App\Models\Notifikasi;
use App\Models\PortofolioVote;
use App\Models\TautanPortofolio;
use App\Models\ToolsPortofolio;
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
            'gambar_portofolio' => 'required|array',
            'gambar_portofolio.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'tools_portofolio' => 'required|array',
            'tautan_portofolio' => 'required|array',
            'dokumen_portofolio' => 'nullable|file|mimes:pdf,doc,docx,zip|max:20480',
            'user_tags' => 'nullable|string',
        ]);

        // Get the authenticated user
        $user = Auth::user();

        DB::beginTransaction();

        try {
            $path = $request->file('dokumen_portofolio')->store('portofolio_dokumen', 'public');

            // Menyimpan portofolio
            $portofolio = new Portofolio();
            $portofolio->nama_portofolio = $request->input('nama_portofolio');
            $portofolio->deskripsi_portofolio = $request->input('deskripsi_portofolio');
            $portofolio->id_pengguna = $user->id_pengguna;
            if ($request->hasFile('dokumen_portofolio')) {
                $portofolio->dokumen_portofolio = $path;
            }            
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
                    $path = $image->store('portofolio', 'public');

                    GambarPortofolio::create([
                        'gambar_portofolio' => $path, // Path akan tersimpan sebagai 'portofolio/filename.jpg'
                        'id_portofolio' => $portofolio->id_portofolio,
                    ]);
                }
            }

            // Menyimpan tools portofolio
            if (!empty($request->input('tools_portofolio'))) {
                foreach ($request->input('tools_portofolio') as $toolsNama) {
                    ToolsPortofolio::create([
                        'tools_portofolio' => $toolsNama,
                        'id_portofolio' => $portofolio->id_portofolio
                    ]);
                }
            }

            // Menyimpan tautan portofolio 
            if (!empty($request->input('tautan_portofolio'))) {
                foreach ($request->input('tautan_portofolio') as $tautanNama) {
                    TautanPortofolio::create([
                        'tautan_portofolio' => $tautanNama,
                        'id_portofolio' => $portofolio->id_portofolio
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
            return back()->with('error', $e->getMessage())->withInput();
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
            'kategori_portofolio' => 'required|array',
            'deskripsi_portofolio' => 'required|string',
            'gambar_portofolio' => 'required|array',
            'gambar_portofolio.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'tools_portofolio' => 'required|array',
            'tautan_portofolio' => 'required|array',
            'dokumen_portofolio' => 'nullable|file|mimes:pdf,doc,docx,zip|max:20480',
            'user_tags' => 'nullable|string',
        ]);

        DB::beginTransaction();

        try {
            $portofolio->nama_portofolio = $request->nama_portofolio;
            $portofolio->deskripsi_portofolio = $request->deskripsi_portofolio;

            // Ganti dokumen jika ada dokumen baru
            if ($request->hasFile('dokumen_portofolio')) {
                // Hapus dokumen lama jika ada
                if ($portofolio->dokumen_portofolio && Storage::exists('public/' . $portofolio->dokumen_portofolio)) {
                    Storage::delete('public/' . $portofolio->dokumen_portofolio);
                }

                // Simpan dokumen baru
                $path = $request->file('dokumen_portofolio')->store('portofolio_dokumen', 'public');
                $portofolio->dokumen_portofolio = $path;
            }

            $portofolio->save();

            if ($request->has('kategori_portofolio')) {
                $kategoriBaru = collect($request->kategori_portofolio);

                // Ambil kategori lama
                $kategoriLama = KategoriPortofolio::where('id_portofolio', $portofolio->id_portofolio)->pluck('kategori_portofolio');

                // Hapus kategori yang tidak ada dalam input baru
                $kategoriUntukDihapus = $kategoriLama->diff($kategoriBaru);
                KategoriPortofolio::where('id_portofolio', $portofolio->id_portofolio)
                    ->whereIn('kategori_portofolio', $kategoriUntukDihapus)
                    ->delete();

                // Tambahkan kategori baru yang belum ada
                $kategoriUntukDitambahkan = $kategoriBaru->diff($kategoriLama);
                foreach ($kategoriUntukDitambahkan as $kategori) {
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
                    $path = $image->store('portofolio', 'public');
                    GambarPortofolio::create([
                        'gambar_portofolio' => $path,
                        'id_portofolio' => $portofolio->id_portofolio,
                    ]);
                }
            }

            if ($request->has('tautan_portofolio')) {
                $tautanBaru = collect($request->tautan_portofolio);

                // Ambil tautan lama
                $tautanLama = TautanPortofolio::where('id_portofolio', $portofolio->id_portofolio)->pluck('tautan_portofolio');

                // Hapus tautan yang tidak ada dalam input baru
                $tautanUntukDihapus = $tautanLama->diff($tautanBaru);
                TautanPortofolio::where('id_portofolio', $portofolio->id_portofolio)
                    ->whereIn('tautan_portofolio', $tautanUntukDihapus)
                    ->delete();

                // Tambahkan tautan baru yang belum ada
                $tautanUntukDitambahkan = $tautanBaru->diff($tautanLama);
                foreach ($tautanUntukDitambahkan as $tautan) {
                    TautanPortofolio::create([
                        'id_portofolio' => $portofolio->id_portofolio,
                        'tautan_portofolio' => $tautan,
                    ]);
                }
            }

            if ($request->has('tools_portofolio')) {
                $toolsBaru = collect($request->tools_portofolio);

                // Ambil tools lama
                $toolsLama = ToolsPortofolio::where('id_portofolio', $portofolio->id_portofolio)->pluck('tools_portofolio');

                // Hapus tools yang tidak ada dalam input baru
                $toolsUntukDihapus = $toolsLama->diff($toolsBaru);
                ToolsPortofolio::where('id_portofolio', $portofolio->id_portofolio)
                    ->whereIn('tools_portofolio', $toolsUntukDihapus)
                    ->delete();

                // Tambahkan tools baru yang belum ada
                $toolsUntukDitambahkan = $toolsBaru->diff($toolsLama);
                foreach ($toolsUntukDitambahkan as $tools) {
                    ToolsPortofolio::create([
                        'id_portofolio' => $portofolio->id_portofolio,
                        'tools_portofolio' => $tools,
                    ]);
                }
            }

            // Update tag pengguna
            if (!empty($request->user_tags)) {
                $tags = collect(explode(',', $request->user_tags))->map(function ($tag) {
                    return trim(ltrim($tag, '@'));
                });

                // Ambil pengguna yang ditag sebelumnya
                $taggedUsersLama = $portofolio->taggedUsers->pluck('nama_pengguna');

                // Hapus tag lama yang tidak ada dalam input baru
                $tagsUntukDihapus = $taggedUsersLama->diff($tags);
                $usersUntukDihapus = User::whereIn('nama_pengguna', $tagsUntukDihapus)->pluck('id_pengguna');
                $portofolio->taggedUsers()->detach($usersUntukDihapus);

                // Tambahkan tag baru yang belum ada
                $tagsUntukDitambahkan = $tags->diff($taggedUsersLama);
                $usersUntukDitambahkan = User::whereIn('nama_pengguna', $tagsUntukDitambahkan)->pluck('id_pengguna');
                $portofolio->taggedUsers()->attach($usersUntukDitambahkan);
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
            // Hapus dokumen jika ada
            if ($portofolio->dokumen_portofolio && Storage::exists('public/' . $portofolio->dokumen_portofolio)) {
                Storage::delete('public/' . $portofolio->dokumen_portofolio);
            }

            // Hapus kategori, gambar, tools, dan tautan terkait
            KategoriPortofolio::where('id_portofolio', $id)->delete();
            GambarPortofolio::where('id_portofolio', $id)->each(function ($gambar) {
                if (Storage::exists($gambar->gambar_portofolio)) {
                    Storage::delete($gambar->gambar_portofolio);
                }
                $gambar->delete();
            });
            ToolsPortofolio::where('id_portofolio', $id)->delete();
            TautanPortofolio::where('id_portofolio', $id)->delete();

            // Hapus tagged users
            $portofolio->taggedUsers()->detach();

            // Hapus semua tagged users kecuali pemilik portofolio
            $portofolio->taggedUsers()->sync([], false);
            $portofolio->delete();

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
        $portofolio = Portofolio::with(['gambar', 'kategori', 'komentar', 'tautan', 'tools', 'owner'])->findOrFail($id);
        $portofolio->increment('view_count');
        return view('portofolio.view', compact('portofolio'));
    }

    public function edit($id)
    {
        $portofolio = Portofolio::with(['gambar', 'kategori', 'komentar', 'tautan', 'tools'])->findOrFail($id);

        // Pastikan hanya pemilik yang bisa mengedit
        if ($portofolio->id_pengguna !== auth()->id()) {
            abort(403, 'Anda tidak memiliki izin untuk mengedit portofolio ini.');
        }

        // Ambil semua kategori
        $semuaKategori = ['UI/UX Design', 'Website Development', 'Mobile Development', 'Game Development', 'Internet of Things', 'ML/AI', 'Blockchain', 'Cyber Security'];
        return view('portofolio.edit', compact('portofolio', 'semuaKategori'));
    }

    public function validatePortofolio($id)
    {
        $portofolio = Portofolio::findOrFail($id);

        // Pastikan hanya admin yang bisa memvalidasi
        if (!auth()->user()->hasRole('admin')) {
            abort(403, 'Anda tidak memiliki izin untuk memvalidasi portofolio ini.');
        }

        try {
            $portofolio->status_portofolio = 1; // Ubah status menjadi valid
            $portofolio->save();

            Notifikasi::create([
                'isi_notifikasi' => 'Portofolio "' . $portofolio->nama_portofolio . '" telah divalidasi oleh admin.',
                'notifiable_id' => $portofolio->id_portofolio,
                'notifiable_type' => 'portofolio',
                'id_pengguna' => $portofolio->id_pengguna,
            ]);

            return redirect()->route('dashboard')->with('success', 'Portofolio berhasil divalidasi.');
        } catch (\Exception $e) {
            \Log::error('Gagal memvalidasi portofolio: ' . $e->getMessage());
            return back()->with('error', 'Gagal memvalidasi portofolio.');
        }
    }

    public function upvote($id)
    {
        $portofolio = Portofolio::findOrFail($id);

        // Cek apakah user sudah memberikan vote
        $existingVote = PortofolioVote::where('id_portofolio', $id)
            ->where('id_pengguna', auth()->id())
            ->first();

        if ($existingVote) {
            return redirect()->route('portofolio.show', $id)->with('error', 'Anda sudah memberikan vote.');
        }

        // Tambahkan upvote
        PortofolioVote::create([
            'id_portofolio' => $id,
            'id_pengguna' => auth()->id(),
            'jenis_vote' => 'upvote',
        ]);

        // Tambahkan jumlah upvote di portofolio
        $portofolio->increment('banyak_upvote');

        return redirect()->route('portofolio.show', $id)->with('success', 'Anda menyukai portofolio ini.');
    }

    public function downvote($id)
    {
        $portofolio = Portofolio::findOrFail($id);

        // Cek apakah user sudah memberikan vote
        $existingVote = PortofolioVote::where('id_portofolio', $id)
            ->where('id_pengguna', auth()->id())
            ->first();

        if ($existingVote) {
            return redirect()->route('portofolio.show', $id)->with('error', 'Anda sudah memberikan vote.');
        }

        // Tambahkan downvote
        PortofolioVote::create([
            'id_portofolio' => $id,
            'id_pengguna' => auth()->id(),
            'jenis_vote' => 'downvote',
        ]);

        // Tambahkan jumlah downvote di portofolio
        $portofolio->increment('banyak_downvote');

        return redirect()->route('portofolio.show', $id)->with('success', 'Anda tidak menyukai portofolio ini.');
    }

    public function komentar(Request $request, $id)
    {
        $request->validate([
            'isi_notifikasi' => 'required|string|max:255',
        ]);

        $portofolio = Portofolio::findOrFail($id);

        // Simpan komentar sebagai notifikasi ke user portofolio
        Notifikasi::create([
            'isi_notifikasi' => $request->isi_notifikasi,
            'notifiable_id' => $portofolio->id_portofolio,
            'notifiable_type' => 'portofolio',
            'id_pengguna' => $portofolio->id_pengguna,
            'is_read' => false,
        ]);

        return redirect()->back()->with('success', 'Komentar berhasil dikirim.');
    }
}
