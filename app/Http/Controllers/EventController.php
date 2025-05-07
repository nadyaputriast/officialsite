<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\PromoEventInternal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EventController extends Controller
{
    public function index()
    {
        $dataEvent = Event::with(['owner', 'promo'])
            ->where('status_event', true)
            ->get();

        return view('dashboard', [
            'dataEvent' => $dataEvent,
        ]);
    }

    public function create()
    {
        return view('event.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_event' => 'required|string|max:255',
            'jenis_event' => 'required|string|in:seminar,workshop,bootcamp,pameran,konferensi',
            'tanggal_event' => 'required|date',
            'waktu_event' => 'required|date_format:H:i:s',
            'deskripsi_event' => 'required|string',
            'penyelenggara_event' => 'required|string|in:internal,eksternal',
            'nama_penyelenggara' => 'required|string|max:255',
            'harga_event' => 'required|numeric|min:0',
            'tautan_event' => 'nullable|url|required_if:penyelenggara_event,eksternal',
            'kuota_event' => 'nullable|integer|min:1',
            'kode_promo' => 'nullable|string|max:50',
            'tanggal_mulai' => 'nullable|date',
            'tanggal_berakhir' => 'nullable|date|after_or_equal:tanggal_mulai',
            'thumbnail_event' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        DB::beginTransaction();

        try {
            // Simpan event
            $event = new Event();
            $event->fill($request->only([
                'nama_event',
                'jenis_event',
                'tanggal_event',
                'waktu_event',
                'deskripsi_event',
                'penyelenggara_event',
                'nama_penyelenggara',
                'harga_event',
                'tautan_event',
                'kuota_event'
            ]));
            $event->id_pengguna = Auth::id();

            if ($request->hasFile('thumbnail_event')) {
                $event->thumbnail_event = $request->file('thumbnail_event')->store('event', 'public');
            } else {
                $event->thumbnail_event = 'default_thumbnail.jpg';
            }

            $event->status_event = Auth::user()->hasRole('admin') ? 1 : 0;
            $event->save();

            // Simpan promo jika event internal
            if ($request->penyelenggara_event === 'internal' && $request->kode_promo) {
                $event->promo()->create([
                    'kode_promo' => $request->kode_promo,
                    'jenis_promo' => $request->harga_event > 100 ? 'Potongan Harga' : 'Persentase',
                    'nilai_promo' => $request->harga_event > 100 ? $request->harga_event : min($request->harga_event, 100),
                    'tanggal_mulai' => $request->tanggal_mulai,
                    'tanggal_berakhir' => $request->tanggal_berakhir,
                ]);
            }

            DB::commit();
            return redirect()->route('dashboard')->with('success', 'Event berhasil dibuat.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menyimpan event: ' . $e->getMessage())->withInput();
        }
    }

    public function show($id)
    {
        $event = Event::with('promo')->findOrFail($id);
        return view('event.show', compact('event'));
    }

    public function edit($id)
    {
        $event = Event::with('promo')->findOrFail($id);

        if ($event->id_pengguna !== auth()->id()) {
            abort(403, 'Anda tidak memiliki izin untuk mengedit event ini.');
        }

        return view('event.edit', compact('event'));
    }

    public function update(Request $request, $id)
    {
        $event = Event::findOrFail($id);

        $request->validate([
            'nama_event' => 'required|string|max:255',
            'jenis_event' => 'required|string|in:seminar,workshop,bootcamp,pameran,konferensi',
            'tanggal_event' => 'required|date',
            'waktu_event' => 'required|date_format:H:i:s',
            'deskripsi_event' => 'required|string',
            'penyelenggara_event' => 'required|string|in:internal,eksternal',
            'nama_penyelenggara' => 'required|string|max:255',
            'harga_event' => 'required|numeric|min:0',
            'tautan_event' => 'nullable|url|required_if:penyelenggara_event,eksternal',
            'kuota_event' => 'nullable|integer|min:1',
            'kode_promo' => 'nullable|string|max:50',
            'tanggal_mulai' => 'nullable|date',
            'tanggal_berakhir' => 'nullable|date|after_or_equal:tanggal_mulai',
            'thumbnail_event' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        DB::beginTransaction();

        try {
            $event->fill($request->only([
                'nama_event',
                'jenis_event',
                'tanggal_event',
                'waktu_event',
                'deskripsi_event',
                'penyelenggara_event',
                'nama_penyelenggara',
                'harga_event',
                'tautan_event',
                'kuota_event'
            ]));

            if ($request->hasFile('thumbnail_event')) {
                $event->thumbnail_event = $request->file('thumbnail_event')->store('event', 'public');
            }

            $event->save();

            // Update promo jika event internal
            if ($request->penyelenggara_event === 'internal') {
                $promo = $event->promo;
                if ($promo) {
                    $promo->update([
                        'kode_promo' => $request->kode_promo,
                        'jenis_promo' => $request->harga_event > 100 ? 'Potongan Harga' : 'Persentase',
                        'nilai_promo' => $request->harga_event > 100 ? $request->harga_event : min($request->harga_event, 100),
                        'tanggal_mulai' => $request->tanggal_mulai,
                        'tanggal_berakhir' => $request->tanggal_berakhir,
                    ]);
                } elseif ($request->kode_promo) {
                    $event->promo()->create([
                        'kode_promo' => $request->kode_promo,
                        'jenis_promo' => $request->harga_event > 100 ? 'Potongan Harga' : 'Persentase',
                        'nilai_promo' => $request->harga_event > 100 ? $request->harga_event : min($request->harga_event, 100),
                        'tanggal_mulai' => $request->tanggal_mulai,
                        'tanggal_berakhir' => $request->tanggal_berakhir,
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('event.show', $id)->with('success', 'Event berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $event = Event::findOrFail($id);

        DB::beginTransaction();

        try {
            $event->delete();
            DB::commit();
            return redirect()->route('dashboard')->with('success', 'Event berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menghapus event.');
        }
    }

    public function validateEvent($id)
    {
        $event = Event::findOrFail($id);

        if (!auth()->user()->hasRole('admin')) {
            abort(403, 'Anda tidak memiliki izin untuk memvalidasi event ini.');
        }

        try {
            $event->status_event = 1;
            $event->save();

            return redirect()->route('dashboard')->with('success', 'Event berhasil divalidasi.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memvalidasi event.');
        }
    }
}
