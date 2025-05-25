<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventRegistration;
use App\Models\PromoEventInternal;
use App\Models\PembayaranEvent;
use Illuminate\Http\Request;

class EventRegistrationController extends Controller
{
    public function show($id)
    {
        $event = Event::findOrFail($id);
        return view('event.show', compact('event'));
    }

    public function register($id)
    {
        $event = Event::findOrFail($id);

        // Cek kuota
        if ($event->kuota_event <= 0) {
            return back()->withErrors('Kuota event sudah habis.');
        }

        // Cek jika sudah punya tiket tervalidasi
        $myRegistration = EventRegistration::where('id_event', $event->id_event)
            ->where('id_pengguna', auth()->id())
            ->first();
        $myPembayaran = $myRegistration
            ? PembayaranEvent::where('id_event_registration', $myRegistration->id_event_registration)
                ->where('status_validasi', 1)
                ->first()
            : null;
        if ($myRegistration && $myPembayaran) {
            return back()->withErrors('Anda sudah terdaftar dan tervalidasi pada event ini.');
        }

        // Jika eksternal, redirect ke link eksternal
        if ($event->penyelenggara_event === 'eksternal') {
            return redirect()->away($event->tautan_event);
        }

        // Jika internal dan gratis, langsung daftar
        if ($event->harga_event == 0) {
            $registration = EventRegistration::firstOrCreate([
                'id_event' => $event->id_event,
                'id_pengguna' => auth()->id(),
            ]);
            // Kurangi kuota
            $event->decrement('kuota_event');
            // Generate nomor tiket (langsung untuk gratis)
            $jumlahTiketValid = EventRegistration::where('id_event', $event->id_event)
                ->whereNotNull('nomor_tiket')
                ->count();
            $registration->nomor_tiket = 'E' . $event->id_event . '-' . str_pad($jumlahTiketValid + 1, 3, '0', STR_PAD_LEFT);
            $registration->save();

            return view('event.ticket', ['ticketNumber' => $registration->nomor_tiket]);
        }

        // Jika internal dan berbayar, tampilkan form pembayaran
        return view('event.registration', compact('event'));
    }

    // Proses pendaftaran event internal berbayar
    public function store(Request $request, $id)
    {
        $event = Event::findOrFail($id);

        // Cek kuota
        if ($event->kuota_event <= 0) {
            return back()->withErrors('Kuota event sudah habis.');
        }

        // Cek jika sudah punya tiket tervalidasi
        $myRegistration = EventRegistration::where('id_event', $event->id_event)
            ->where('id_pengguna', auth()->id())
            ->first();
        $myPembayaran = $myRegistration
            ? PembayaranEvent::where('id_event_registration', $myRegistration->id_event_registration)
                ->where('status_validasi', 1)
                ->first()
            : null;
        if ($myRegistration && $myPembayaran) {
            return back()->withErrors('Anda sudah terdaftar dan tervalidasi pada event ini.');
        }

        $request->validate([
            'kode_promo' => 'nullable|string',
            'bukti_pembayaran' => 'required|image',
        ]);

        // Cek promo (jika ada)
        $promoEventId = null;
        $hargaPromo = $event->harga_event;
        if ($request->filled('kode_promo')) {
            $promo = PromoEventInternal::where('kode_promo', $request->kode_promo)
                ->where('id_event', $event->id_event)
                ->where('tanggal_mulai', '<=', now())
                ->where('tanggal_berakhir', '>=', now())
                ->first();

            if ($promo) {
                $promoEventId = $promo->id_promo_event;
                if ($promo->jenis_promo === 'Persentase') {
                    $hargaPromo = ($event->harga_event * (100 - $promo->nilai_promo)) / 100;
                } else {
                    $hargaPromo = $event->harga_event - $promo->nilai_promo;
                }
                $hargaPromo = max(0, $hargaPromo);
            } else {
                return back()->withErrors('Kode promo tidak valid atau telah kedaluwarsa.');
            }
        }

        // Simpan registrasi (tanpa nomor tiket, nanti saat validasi admin)
        $registration = EventRegistration::create([
            'id_event' => $event->id_event,
            'id_pengguna' => auth()->id(),
        ]);
        // Kurangi kuota
        $event->decrement('kuota_event');

        // Simpan pembayaran
        $buktiPembayaranPath = $request->file('bukti_pembayaran')->store('payment_proofs', 'public');
        PembayaranEvent::create([
            'id_event_registration' => $registration->id_event_registration,
            'bukti_pembayaran' => $buktiPembayaranPath,
            'id_promo_event' => $promoEventId,
            'harga_bayar' => $hargaPromo,
            'status_validasi' => 0,
        ]);

        // Tampilkan halaman menunggu validasi admin
        return view('event.waiting_validation');
    }

    // AJAX: Cek promo dan hitung harga promo
    public function cekPromo(Request $request)
    {
        $promo = PromoEventInternal::where('kode_promo', $request->kode_promo)
            ->where('id_event', $request->id_event)
            ->where('tanggal_mulai', '<=', now())
            ->where('tanggal_berakhir', '>=', now())
            ->first();

        $event = Event::find($request->id_event);

        if ($promo && $event) {
            if ($promo->jenis_promo === 'Persentase') {
                $harga_promo = ($event->harga_event * (100 - $promo->nilai_promo)) / 100;
            } else {
                $harga_promo = $event->harga_event - $promo->nilai_promo;
            }
            $harga_promo = max(0, $harga_promo);

            return response()->json([
                'status' => 'ok',
                'harga_promo' => $harga_promo
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Kode promo tidak ditemukan atau tidak berlaku.'
        ]);
    }
}