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
        'id_pengguna'
    ];

    public function owner()
    {
        return $this->belongsTo(User::class, 'id_pengguna');
    }

    public function dokumentasi()
    {
        return $this->hasMany(DokumentasiPrestasi::class, 'id_prestasi');
    }

    public function taggedUsers()
    {
        return $this->belongsToMany(User::class, 'prestasi_user_tags', 'id_prestasi', 'id_pengguna')
            ->withTimestamps();
    }
}