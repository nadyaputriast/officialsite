<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PromoEventInternal extends Model
{
    use HasFactory;

    protected $table = 'promo_event_internal';
    protected $primaryKey = 'id_promo_event';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'kode_promo',
        'jenis_promo',
        'nilai_promo',
        'tanggal_mulai',
        'tanggal_berakhir',
        'id_event'
    ];

    public function event()
    {
        return $this->belongsTo(Event::class, 'id_event', 'id_event');
    }

    public function pembayaranEvent()
    {
        return $this->hasMany(PembayaranEvent::class, 'id_promo_event', 'id_promo_event');
    }
}
