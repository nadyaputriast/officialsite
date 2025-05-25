<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PembayaranEvent;
use App\Models\EventRegistration;

class PembayaranEventInternalController extends Controller
{
    public function index()
    {
        $pembayaran = PembayaranEvent::with('eventRegistration.event')->get();
        return view('admin.pembayaran.index', compact('pembayaran'));
    }

    public function validasi($id)
    {
        $pembayaran = PembayaranEvent::findOrFail($id);
        $pembayaran->status_validasi = 1;
        $pembayaran->save();

        $registrasi = $pembayaran->eventRegistration;

        if (!$registrasi) {
            return redirect()->back()->withErrors('Registrasi event tidak ditemukan.');
        }

        // Hitung nomor tiket urut
        $jumlahTiketValid = EventRegistration::where('id_event', $registrasi->id_event)
            ->whereNotNull('nomor_tiket')
            ->whereHas('pembayaran', function ($q) {
                $q->where('status_validasi', 1);
            })
            ->count();

        $nomorTiket = 'E' . $registrasi->id_event . '-' . str_pad($jumlahTiketValid + 1, 3, '0', STR_PAD_LEFT);
        $registrasi->nomor_tiket = $nomorTiket;
        $registrasi->save();

        $event = $registrasi->event;

        // Redirect ke halaman waiting_validation dengan nomor tiket
        return view('event.waiting_validation', [
            'nomorTiket' => $nomorTiket,
            'event' => $event
        ]);
    }
}
