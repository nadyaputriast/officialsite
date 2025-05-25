<?php

namespace App\Http\Controllers;

use App\Models\Download;
use App\Models\Event;
use App\Models\Notifikasi;
use App\Models\OprekLokerProject;
use App\Models\Portofolio;
use App\Models\Pengabdian;
use App\Models\Prestasi;
use App\Models\Sertifikasi;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->hasRole('admin')) {
            $dataEvent = Event::latest()->paginate(10); // Paginasi 10 item per halaman
            $dataOprek = OprekLokerProject::latest()->paginate(10);
            $dataPortofolio = Portofolio::latest()->paginate(10);
            $dataPrestasi = Prestasi::latest()->paginate(10);
            $dataPengabdian = Pengabdian::latest()->paginate(10);
            $dataSertifikasi = Sertifikasi::latest()->paginate(10);
            $dataDownload = Download::latest()->paginate(10);
            $notifs = [];
        } else {
            $dataEvent = Event::where('status_event', 1)->latest()->paginate(10);
            $dataOprek = OprekLokerProject::where('status_project', 1)->latest()->paginate(10);
            $dataPortofolio = Portofolio::where('status_portofolio', 1)->latest()->paginate(10);
            $dataPrestasi = Prestasi::where('status_prestasi', 1)->latest()->paginate(10);
            $dataPengabdian = Pengabdian::where('status_pengabdian', 1)->latest()->paginate(10);
            $dataSertifikasi = Sertifikasi::where('status_sertifikasi', 1)->latest()->paginate(10);
            $dataDownload = Download::where('status_download', 1)->latest()->paginate(10);
            $notifs = Notifikasi::where('id_pengguna', auth()->id())->where('is_read', false)->latest()->get();
        }

        $now = Carbon::now();
        $month = $now->month;
        $year = $now->year;

        // Portofolio: 3 views terbanyak bulan ini
        $topPortofolio = Portofolio::whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->orderByDesc('view_count')
            ->take(3)
            ->get();

        // Jika kosong, ambil bulan sebelumnya
        if ($topPortofolio->isEmpty()) {
            $prev = $now->copy()->subMonth();
            $topPortofolio = Portofolio::whereMonth('created_at', $prev->month)
                ->whereYear('created_at', $prev->year)
                ->orderByDesc('view_count')
                ->take(3)
                ->get();
        }

        // Prestasi: Internasional bulan ini
        $topPrestasi = Prestasi::where('tingkatan_prestasi', 'Internasional')
            ->whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->latest()
            ->first();

        // Jika kosong, ambil bulan sebelumnya
        if (!$topPrestasi) {
            $prev = $now->copy()->subMonth();
            $topPrestasi = Prestasi::where('tingkatan_prestasi', 'Internasional')
                ->whereMonth('created_at', $prev->month)
                ->whereYear('created_at', $prev->year)
                ->latest()
                ->first();
        }

        return view('dashboard', compact('dataEvent', 'dataOprek', 'dataPortofolio', 'dataPrestasi', 'dataPengabdian', 'dataSertifikasi', 'dataDownload', 'notifs', 'topPortofolio', 'topPrestasi'));
    }
}
