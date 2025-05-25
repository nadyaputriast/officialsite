<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventRegistration extends Model
{
    use HasFactory;

    protected $table = 'event_registration';
    protected $primaryKey = 'id_event_registration';

    protected $fillable = [
        'nomor_tiket',
        'id_event',
        'id_pengguna'
    ];

    // Relasi ke event
    public function event()
    {
        return $this->belongsTo(Event::class, 'id_event', 'id_event');
    }

    // Relasi ke user
    public function user()
    {
        return $this->belongsTo(User::class, 'id_pengguna', 'id_pengguna');
    }

    public function pembayaran()
    {
        return $this->hasOne(PembayaranEvent::class, 'id_event_registration', 'id_event_registration');
    }
}
