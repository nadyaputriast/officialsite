<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Portofolio;

class AdminPortofolioController extends Controller
{
    public function index()
    {
        // Ambil semua portofolio dengan status "nonvalid"
        $portofolios = Portofolio::where('status_portofolio', 'nonvalid')->get();

        return view('admin.portofolio.index', compact('portofolios'));
    }

    public function approve($id)
    {
        // Validasi portofolio
        $portofolio = Portofolio::findOrFail($id);
        $portofolio->status_portofolio = 'valid';
        $portofolio->save();

        return redirect()->route('admin.portofolio.index')->with('success', 'Portofolio berhasil divalidasi.');
    }

    public function reject($id)
    {
        // Tolak portofolio
        $portofolio = Portofolio::findOrFail($id);
        $portofolio->status_portofolio = 'rejected';
        $portofolio->save();

        return redirect()->route('admin.portofolio.index')->with('success', 'Portofolio berhasil ditolak.');
    }
}