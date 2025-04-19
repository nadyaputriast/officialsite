<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Portofolio;

class PortofolioController extends Controller
{
    public function create()
    {
        return view('portofolio.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_portofolio' => 'required|string|max:255',
            'deskripsi_portofolio' => 'required|string',
            'tautan_portofolio' => 'required|url',
        ]);

        // Tentukan kolom yang akan diisi berdasarkan role pengguna
        $data = [
            'nama_portofolio' => $validated['nama_portofolio'],
            'deskripsi_portofolio' => $validated['deskripsi_portofolio'],
            'tautan_portofolio' => $validated['tautan_portofolio'],
            'status_portofolio' => 'nonvalid', // Status awal adalah pending
        ];

        if (auth()->user()->hasRole('mahasiswa')) {
            $data['nim'] = auth()->user()->nim; // ID mahasiswa
        } elseif (auth()->user()->hasRole('dosen')) {
            $data['nip'] = auth()->user()->nip; // Kode dosen
        }

        // Simpan data ke tabel portofolio
        Portofolio::create($data);

        return redirect()->route('dashboard')->with('success', 'Portofolio berhasil ditambahkan dan menunggu validasi.');
    }
}