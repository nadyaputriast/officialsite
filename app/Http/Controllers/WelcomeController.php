<?php

namespace App\Http\Controllers;

use App\Models\Download;
use App\Models\Event;
use App\Models\OprekLokerProject;
use App\Models\Portofolio;
use App\Models\Prestasi;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function index(Request $request)
    {
        // Search/filter Event - hanya yang sudah disetujui
        $eventQuery = Event::with('owner')
            ->where('status_event', 1) // Perbaiki kolom status
            ->orderByDesc('created_at');
        
        if ($request->filled('search_event')) {
            $eventQuery->where('nama_event', 'like', '%' . $request->search_event . '%');
        }
        $events = $eventQuery->take(6)->get();

        // Search/filter Portofolio - hanya yang sudah disetujui
        $portofolioQuery = Portofolio::with(['owner', 'kategori', 'gambar'])
            ->where('status_portofolio', 1) // Perbaiki kolom status
            ->orderByDesc('created_at');
        
        if ($request->filled('search_portofolio')) {
            $portofolioQuery->where('nama_portofolio', 'like', '%' . $request->search_portofolio . '%');
        }
        if ($request->filled('kategori_portofolio')) {
            $portofolioQuery->whereHas('kategori', function ($q) use ($request) {
                $q->whereIn('kategori_portofolio', (array) $request->kategori_portofolio);
            });
        }
        $portofolio = $portofolioQuery->take(6)->get();

        // Search/filter Oprek - untuk welcome page gunakan get()
        $oprekQuery = OprekLokerProject::with(['owner'])
            ->orderByDesc('created_at');
        
        // Filter hanya yang masih aktif (deadline belum lewat)
        $oprekQuery->where(function ($q) {
            $q->whereNull('deadline_project')
              ->orWhere('deadline_project', '>=', now());
        });
        
        if ($request->filled('search_oprek')) {
            $oprekQuery->where('nama_project', 'like', '%' . $request->search_oprek . '%');
        }
        if ($request->filled('kategori_oprek')) {
            $oprekQuery->where('kategori_project', $request->kategori_oprek);
        }
        $oprek = $oprekQuery->take(6)->get(); // Gunakan get() untuk welcome

        // Search/filter Download - untuk welcome page gunakan get()
        $downloadQuery = Download::with('pengguna')
            ->orderByDesc('created_at');
        
        if ($request->filled('search_download')) {
            $downloadQuery->where('nama_download', 'like', '%' . $request->search_download . '%');
        }
        $dataDownload = $downloadQuery->take(10)->get(); // Gunakan get() untuk welcome

        // Hall of Fame (Top 3 Portofolio by view_count) - hanya yang disetujui
        $topPortofolio = Portofolio::with(['owner', 'kategori', 'gambar', 'taggedUsers'])
            ->where('status_portofolio', 1) // Perbaiki kolom status
            ->orderByDesc('view_count')
            ->take(3)
            ->get();

        // Top Prestasi (by tingkat dan tanggal) - hanya yang disetujui
        $topPrestasi = Prestasi::with('owner')
            ->where('status_prestasi', 1) // Perbaiki kolom status
            ->orderByRaw("FIELD(tingkatan_prestasi, 'Internasional', 'Nasional', 'Provinsi', 'Kabupaten', 'Lokal')")
            ->orderByDesc('tanggal_perolehan')
            ->first();

        // Kategori stats - hitung hanya portofolio yang disetujui
        $kategoriList = [
            'UI/UX Design',
            'Website Development',
            'Mobile Development',
            'Game Development',
            'Internet of Things',
            'ML/AI',
            'Blockchain',
            'Cyber Security',
        ];

        $kategoriStats = collect($kategoriList)->map(function ($kategori) {
            return [
                'nama' => $kategori,
                'jumlah' => Portofolio::where('status_portofolio', 1) // Perbaiki kolom status
                    ->whereHas('kategori', function ($q) use ($kategori) {
                        $q->where('kategori_portofolio', $kategori);
                    })->count(),
            ];
        });

        return view('welcome', [
            'events'        => $events,
            'portofolio'    => $portofolio,
            'oprek'         => $oprek,
            'dataDownload'  => $dataDownload,
            'topPortofolio' => $topPortofolio,
            'topPrestasi'   => $topPrestasi,
            'request'       => $request,
            'kategoriStats' => $kategoriStats,
        ]);
    }
}