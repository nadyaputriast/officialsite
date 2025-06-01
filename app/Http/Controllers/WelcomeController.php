<?php

namespace App\Http\Controllers;

use App\Models\Download;
use App\Models\Event;
use Illuminate\Http\Request;
use App\Models\Portofolio;
use App\Models\Prestasi;
use App\Models\Pengabdian;
use App\Models\Sertifikasi;

class WelcomeController extends Controller
{
    public function index()
    {
        try {
            $portofolio = Portofolio::with('owner')->latest()->get();
        } catch (\Exception $e) {
            $portofolio = collect([]);
        }

        try {
            $prestasi = Prestasi::with('owner')->latest()->get();
        } catch (\Exception $e) {
            $prestasi = collect([]);
        }

        try {
            $pengabdian = Pengabdian::with('owner')->latest()->get();
        } catch (\Exception $e) {
            $pengabdian = collect([]);
        }

        try {
            $sertifikasi = Sertifikasi::with('owner')->latest()->get();
        } catch (\Exception $e) {
            $sertifikasi = collect([]);
        }

        try {
            $event = Event::with('owner')->latest()->get();
        } catch (\Exception $e) {
            $event = collect([]);
        }
        try {
            $download = Download::with('owner')->latest()->get();
        } catch (\Exception $e) {
            $download = collect([]);
        }

        return view('welcome', compact(
            'portofolio',
            'prestasi', 
            'pengabdian',
            'sertifikasi',
            'event',
            'download'
        ));
    }
}