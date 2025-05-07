<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\OprekLokerProject;
use App\Models\Portofolio;
use App\Models\Pengabdian;
use App\Models\Prestasi;
use App\Models\Sertifikasi;

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
        } else {
            $dataEvent = Event::where('status_event', 1)->latest()->paginate(10);
            $dataOprek = OprekLokerProject::where('status_project', 1)->latest()->paginate(10);
            $dataPortofolio = Portofolio::where('status_portofolio', 1)->latest()->paginate(10);
            $dataPrestasi = Prestasi::where('status_prestasi', 1)->latest()->paginate(10);
            $dataPengabdian = Pengabdian::where('status_pengabdian', 1)->latest()->paginate(10);
            $dataSertifikasi = Sertifikasi::where('status_sertifikasi', 1)->latest()->paginate(10);
        }

        return view('dashboard', compact('dataEvent', 'dataOprek', 'dataPortofolio', 'dataPrestasi', 'dataPengabdian', 'dataSertifikasi'));
    }
}
