<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventRegistration;
use App\Models\PromoEventInternal;
use App\Models\PembayaranEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class EventRegistrationController extends Controller
{
    public function show($id)
    {
        $event = Event::findOrFail($id);
        return view('event.show', compact('event'));
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

    public function register($id)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Anda harus login terlebih dahulu.');
        }

        $event = Event::with('promo')->findOrFail($id);

        // ✅ ADD: Comprehensive validation
        if ($event->status_event !== 1) {
            return back()->with('error', 'Event belum divalidasi admin.');
        }

        if ($event->tanggal_event < now()->toDateString()) {
            return back()->with('error', 'Event sudah berakhir.');
        }

        if ($event->penyelenggara_event === 'internal' && $event->kuota_event <= 0) {
            return back()->with('error', 'Kuota event sudah habis.');
        }

        // ✅ FIX: Use consistent field name
        $existingRegistration = EventRegistration::where('id_event', $event->id_event)
            ->where('id_pengguna', auth()->user()->id_pengguna) // ✅ FIX: Consistent field
            ->first();

        if ($existingRegistration) {
            // Check if already has valid ticket
            if ($existingRegistration->nomor_tiket) {
                return back()->with('info', 'Anda sudah terdaftar pada event ini. Nomor tiket: ' . $existingRegistration->nomor_tiket);
            }

            // Check payment status for paid events
            if ($event->harga_event > 0) {
                $validatedPayment = $existingRegistration->pembayaran()
                    ->where('status_validasi', 1)
                    ->first();

                if ($validatedPayment) {
                    return back()->with('error', 'Anda sudah terdaftar dan tervalidasi pada event ini.');
                } elseif ($existingRegistration->pembayaran()->exists()) {
                    return back()->with('info', 'Registrasi Anda sedang menunggu validasi admin.');
                }
            }
        }

        // ✅ FIX: Handle external events
        if ($event->penyelenggara_event === 'eksternal') {
            if (!$event->tautan_event) {
                return back()->with('error', 'Link pendaftaran eksternal tidak tersedia.');
            }
            return redirect()->away($event->tautan_event);
        }

        // ✅ FIX: Handle free internal events - DIRECT REGISTRATION
        if ($event->harga_event == 0) {
            return $this->handleFreeEventRegistration($event, $existingRegistration);
        }

        // ✅ FIX: Paid internal events - show registration form
        return view('event.registration', compact('event'));
    }

    public function cekPromo(Request $request)
    {
        try {
            Log::info('=== PROMO CHECK START ===', [
                'method' => $request->method(),
                'url' => $request->url(),
                'input_data' => $request->all(),
                'user_id' => auth()->id(),
                'ip' => $request->ip()
            ]);

            // ✅ Basic validation first
            if (!$request->has('kode_promo') || !$request->has('id_event')) {
                Log::warning('Missing required fields', [
                    'has_kode_promo' => $request->has('kode_promo'),
                    'has_id_event' => $request->has('id_event')
                ]);

                return response()->json([
                    'status' => 'error',
                    'message' => 'Data tidak lengkap. Kode promo dan ID event diperlukan.'
                ], 400);
            }

            // ✅ Validate request data
            $validatedData = $request->validate([
                'kode_promo' => 'required|string|max:50',
                'id_event' => 'required|integer|exists:event,id_event',
            ]);

            Log::info('Request validated successfully', $validatedData);

            // ✅ Find event with error handling
            $event = Event::findOrFail($validatedData['id_event']);

            Log::info('Event found', [
                'event_id' => $event->id_event,
                'event_name' => $event->nama_event,
                'event_price' => $event->harga_event,
                'event_status' => $event->status_event
            ]);

            // ✅ Check if event is active
            if ($event->status_event !== 1) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Event belum divalidasi admin.'
                ]);
            }

            // ✅ FIXED: Query promo table properly
            $promo = DB::table('promo_event_internal')
                ->where('id_event', $event->id_event)
                ->where('kode_promo', $validatedData['kode_promo'])
                ->first();

            Log::info('Promo query executed', [
                'table' => 'promo_event_internal',
                'id_event' => $event->id_event,
                'kode_promo' => $validatedData['kode_promo'],
                'promo_found' => $promo ? 'YES' : 'NO',
                'promo_data' => $promo
            ]);

            if (!$promo) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Kode promo "' . $validatedData['kode_promo'] . '" tidak ditemukan untuk event ini.'
                ]);
            }

            // ✅ Check promo validity dates
            $now = now();

            if ($promo->tanggal_mulai && $now->lt($promo->tanggal_mulai)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Promo belum dimulai. Mulai: ' . date('d/m/Y', strtotime($promo->tanggal_mulai))
                ]);
            }

            if ($promo->tanggal_berakhir && $now->gt($promo->tanggal_berakhir . ' 23:59:59')) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Promo sudah berakhir. Berakhir: ' . date('d/m/Y', strtotime($promo->tanggal_berakhir))
                ]);
            }

            // ✅ Calculate promo price
            $hargaAsli = (int) $event->harga_event;
            $nilaiPromo = (int) $promo->nilai_promo;
            $jenisPromo = $promo->jenis_promo ?? 'Persentase';

            if ($jenisPromo === 'Persentase') {
                $hargaPromo = $hargaAsli * (100 - $nilaiPromo) / 100;
            } else {
                $hargaPromo = $hargaAsli - $nilaiPromo;
            }

            $hargaPromo = max(0, (int) $hargaPromo);
            $penghematan = $hargaAsli - $hargaPromo;

            Log::info('Promo calculation completed', [
                'harga_asli' => $hargaAsli,
                'nilai_promo' => $nilaiPromo,
                'jenis_promo' => $jenisPromo,
                'harga_promo' => $hargaPromo,
                'penghematan' => $penghematan
            ]);

            $responseData = [
                'status' => 'success',
                'message' => 'Promo berhasil diterapkan',
                'data' => [
                    'harga_asli' => $hargaAsli,
                    'harga_promo' => $hargaPromo,
                    'nilai_promo' => $nilaiPromo,
                    'jenis_promo' => $jenisPromo,
                    'penghematan' => $penghematan,
                    'kode_promo' => $promo->kode_promo,
                    'tanggal_mulai' => $promo->tanggal_mulai,
                    'tanggal_berakhir' => $promo->tanggal_berakhir
                ]
            ];

            Log::info('=== PROMO CHECK SUCCESS ===', $responseData);

            return response()->json($responseData);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation error in promo check', [
                'errors' => $e->errors(),
                'request_data' => $request->all()
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Data tidak valid: ' . implode(', ', array_flatten($e->errors())),
                'errors' => $e->errors()
            ], 422);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::error('Event not found', [
                'id_event' => $request->id_event,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Event tidak ditemukan.'
            ], 404);
        } catch (\Exception $e) {
            Log::error('=== UNEXPECTED ERROR IN PROMO CHECK ===', [
                'error_message' => $e->getMessage(),
                'error_file' => $e->getFile(),
                'error_line' => $e->getLine(),
                'error_trace' => $e->getTraceAsString(),
                'request_data' => $request->all(),
                'user_id' => auth()->id()
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan server: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * ✅ FIXED: handleFreeEventRegistration method
     */
    private function handleFreeEventRegistration($event, $existingRegistration = null)
    {
        DB::beginTransaction();

        try {
            Log::info('Processing free event registration', [
                'event_id' => $event->id_event,
                'user_id' => auth()->user()->id_pengguna,
                'existing_registration' => $existingRegistration ? 'YES' : 'NO'
            ]);

            // ✅ Create or use existing registration
            $registration = $existingRegistration ?: EventRegistration::create([
                'id_event' => $event->id_event,
                'id_pengguna' => auth()->user()->id_pengguna,
            ]);

            // ✅ Only decrement quota for new registrations
            if (!$existingRegistration) {
                $event->refresh();
                if ($event->kuota_event <= 0) {
                    DB::rollBack();
                    return back()->with('error', 'Kuota event sudah habis.');
                }
                $event->decrement('kuota_event');
            }

            // ✅ Generate ticket number if not exists
            if (!$registration->nomor_tiket) {
                $jumlahTiketValid = EventRegistration::where('id_event', $event->id_event)
                    ->whereNotNull('nomor_tiket')
                    ->count();

                $nomorTiket = 'E' . $event->id_event . '-' . str_pad($jumlahTiketValid + 1, 3, '0', STR_PAD_LEFT);

                $registration->update([
                    'nomor_tiket' => $nomorTiket,
                    'validated_at' => now()
                ]);

                Log::info('Ticket generated for free event', [
                    'ticket_number' => $nomorTiket,
                    'registration_id' => $registration->id_event_registration
                ]);
            }

            DB::commit();

            return redirect()->route('event.show', $event->id_event)
                ->with('success', 'Pendaftaran berhasil! Nomor tiket Anda: ' . $registration->nomor_tiket);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error registering free event: ' . $e->getMessage(), [
                'event_id' => $event->id_event,
                'user_id' => auth()->user()->id_pengguna ?? 'NULL',
                'trace' => $e->getTraceAsString()
            ]);
            return back()->with('error', 'Gagal mendaftar event: ' . $e->getMessage());
        }
    }

    public function waitingValidation($registrationId)
    {
        $registration = EventRegistration::with(['event', 'pembayaran'])
            ->where('id_event_registration', $registrationId)
            ->where('id_pengguna', auth()->user()->id_pengguna)
            ->firstOrFail();

        Log::info('User accessing waiting validation page', [
            'registration_id' => $registrationId,
            'user_id' => auth()->user()->id_pengguna,
            'has_ticket' => $registration->nomor_tiket ? 'YES' : 'NO',
            'payment_validated' => $registration->pembayaran()->where('status_validasi', 1)->exists() ? 'YES' : 'NO'
        ]);

        $validatedPayment = $registration->pembayaran()
            ->where('status_validasi', 1)
            ->first();

        $nomorTiket = null;

        if ($validatedPayment && $registration->nomor_tiket) {
            $nomorTiket = $registration->nomor_tiket;
        } elseif ($validatedPayment && !$registration->nomor_tiket) {
            $this->generateTicketForValidatedPayment($registration);
            $nomorTiket = $registration->fresh()->nomor_tiket;
        }

        return view('event.waiting_validation', compact('registration', 'nomorTiket'));
    }

    // /**
    //  * Generate ticket for validated payment
    //  */
    private function generateTicketForValidatedPayment($registration)
    {
        try {
            $event = $registration->event;

            // Count existing valid tickets for this event
            $jumlahTiketValid = EventRegistration::where('id_event', $event->id_event)
                ->whereNotNull('nomor_tiket')
                ->count();

            $nomorTiket = 'E' . $event->id_event . '-' . str_pad($jumlahTiketValid + 1, 3, '0', STR_PAD_LEFT);

            $registration->update([
                'nomor_tiket' => $nomorTiket,
                'validated_at' => now()
            ]);

            Log::info('Ticket generated for validated payment', [
                'registration_id' => $registration->id_event_registration,
                'ticket_number' => $nomorTiket,
                'event_id' => $event->id_event
            ]);

            return $nomorTiket;
        } catch (\Exception $e) {
            Log::error('Error generating ticket for validated payment', [
                'registration_id' => $registration->id_event_registration,
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }
}
