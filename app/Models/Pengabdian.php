<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengabdian extends Model
{
    use HasFactory;

    protected $table = 'pengabdian';
    protected $primaryKey = 'id_pengabdian';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'id_pengabdian',
        'judul_pengabdian',
        'deskripsi_pengabdian',
        'status_pengabdian',
        'tanggal_pengabdian',
        'pelaksana',
    ];

    public function dosen()
    {
        return $this->belongsToMany(Dosen::class, 'dosen_mahasiswa_pengabdian', 'id_pengabdian', 'nip');
    }

    public function mahasiswa()
    {
        return $this->belongsToMany(Mahasiswa::class, 'dosen_mahasiswa_pengabdian', 'id_pengabdian', 'nim');
    }
}
