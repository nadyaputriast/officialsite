<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PembayaranEvent extends Model
{
    use HasFactory;

    protected $table = 'pembayaran_event';
    protected $primaryKey = 'id_pembayaran_event';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'bukti_pembayaran',
        'id_promo_event',
        'id_event_registration'
    ];

    // Relasi ke pendaftaran event
    public function eventRegistration()
    {
        return $this->belongsTo(EventRegistration::class, 'id_event_registration', 'id_event_registration');
    }

    // Relasi ke promo (jika digunakan)
    public function promo()
    {
        return $this->belongsTo(PromoEventInternal::class, 'id_promo_event', 'id_promo_event');
    }

    public function registration()
    {
        return $this->belongsTo(EventRegistration::class, 'id_event_registration', 'id_event_registration');
    }
}
