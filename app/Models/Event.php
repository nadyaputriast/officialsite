<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Event extends Model
{
    use HasFactory;

    protected $table = 'event';
    protected $primaryKey = 'id_event';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'id_event',
        'nama_event',
        'jenis_event',
        'tanggal_event',
        'waktu_event',
        'deskripsi_event',
        'penyelenggara_event',
        'nama_penyelenggara',
        'tautan_event',
        'kuota_event',
        'harga_event',
        'thumbnail_event',
        'status_event',
        'id_pengguna',
    ];

    public function owner()
    {
        return $this->belongsTo(User::class, 'id_pengguna');
    }

    // public function participants()
    // {
    //     return $this->hasMany(User::class, 'event_registration');
    // }

    public function promo()
    {
        return $this->hasOne(PromoEventInternal::class, 'id_event', 'id_event');
    }

    public function registrations()
    {
        return $this->hasMany(EventRegistration::class, 'id_event', 'id_event');
    }
}
