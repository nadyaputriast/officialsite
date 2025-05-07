<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventRegistration;
use App\Models\PromoEventInternal;
use App\Models\PembayaranEvent;
use Illuminate\Http\Request;

class EventRegistrationController extends Controller
{
    public function register($eventId)
    {
        $event = Event::findOrFail($eventId);
        return view('event.registration', compact('event'));
    }

    public function store(Request $request, $eventId)
    {
        $request->validate([
            'kode_promo' => 'nullable|string|exists:promo_event_internal,kode_promo',
            'bukti_pembayaran' => 'required|image',
        ]);

        $event = Event::findOrFail($eventId);

        $promoEventId = null;
        if ($request->has('kode_promo')) {
            $promo = PromoEventInternal::where('kode_promo', $request->kode_promo)->first();
            if ($promo && $promo->tanggal_mulai <= now() && $promo->tanggal_berakhir >= now()) {
                $promoEventId = $promo->id_promo_event;
            } else {
                return back()->withErrors('Kode promo tidak valid atau telah kedaluwarsa.');
            }
        }

        $registration = EventRegistration::create([
            'id_event' => $event->id_event,
            'id_pengguna' => auth()->id(),
        ]);

        $buktiPembayaranPath = $request->file('bukti_pembayaran')->store('payment_proofs');
        PembayaranEvent::create([
            'id_event_registration' => $registration->id_event_registration,
            'bukti_pembayaran' => $buktiPembayaranPath,
            'id_promo_event' => $promoEventId,
        ]);

        $ticketNumber = "E{$event->id_event}-{$registration->id_event_registration}";

        return view('event.ticket', compact('ticketNumber'));
    }
}