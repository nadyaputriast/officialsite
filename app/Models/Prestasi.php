<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prestasi extends Model
{
    use HasFactory;

    protected $table = 'prestasi';
    protected $primaryKey = 'id_prestasi';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'id_prestasi',
        'nama_prestasi',
        'deskripsi_prestasi',
        'status_prestasi',
        'tanggal_perolehan',
        'tingkatan_prestasi',
        'jenis_prestasi',
    ];

    public function dosen()
    {
        return $this->belongsToMany(Dosen::class, 'dosen_mahasiswa_prestasi', 'id_prestasi', 'nip');
    }

    public function mahasiswa()
    {
        return $this->belongsToMany(Mahasiswa::class, 'dosen_mahasiswa_prestasi', 'id_prestasi', 'nim');
    }
}