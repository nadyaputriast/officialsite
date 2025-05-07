<?php

namespace App\Http\Controllers;

use App\Models\PromoEventInternal;
use App\Models\Event;
use Illuminate\Http\Request;

class PromoEventInternalController extends Controller
{
    public function create($eventId)
    {
        $event = Event::findOrFail($eventId);
        return view('promo.create', compact('event'));
    }

    public function store(Request $request, $eventId)
    {
        $request->validate([
            'kode_promo' => 'required|string|unique:promo_event_internal,kode_promo',
            'jenis_promo' => 'required|in:Persentase,Potongan Harga',
            'nilai_promo' => 'required|integer|min:1',
            'tanggal_mulai' => 'required|date',
            'tanggal_berakhir' => 'required|date|after_or_equal:tanggal_mulai',
        ]);

        PromoEventInternal::create([
            'kode_promo' => $request->kode_promo,
            'jenis_promo' => $request->jenis_promo,
            'nilai_promo' => $request->nilai_promo,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_berakhir' => $request->tanggal_berakhir,
            'id_event' => $eventId,
        ]);

        return redirect()->route('event.view')->with('success', 'Promo berhasil dibuat untuk event.');
    }
}