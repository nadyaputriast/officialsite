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
        $registrasi = $pembayaran->eventRegistration;

        $eventId = $registrasi->id_event;
        $count = EventRegistration::where('id_event', $eventId)->whereNotNull('nomor_tiket')->count() + 1;
        $nomorTiket = 'E' . $eventId . '-' . str_pad($count, 3, '0', STR_PAD_LEFT);

        $registrasi->nomor_tiket = $nomorTiket;
        $registrasi->save();

        return redirect()->back()->with('success', 'Pembayaran divalidasi dan nomor tiket telah dibuat.');
    }
}