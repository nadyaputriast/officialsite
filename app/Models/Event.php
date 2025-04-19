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
        'thumbnail_event',
        'kode_admin',
        'nim',
    ];

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'kode_admin', 'kode_admin');
    }

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'nim', 'nim');
    }

    public function participants()
    {
        return $this->belongsToMany(User::class, 'event_registration');
    }
}