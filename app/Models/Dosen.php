<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dosen extends Model
{
    use HasFactory;

    protected $table = 'dosen';
    protected $primaryKey = 'nip';
    public $incrementing = false;

    protected $fillable = [
        'id_pengguna',
        'nip',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_pengguna', 'id_pengguna');
    }

    public function oprek_loker_project()
    {
        return $this->hasMany(OprekLokerProject::class, 'nip', 'nip');
    }

    public function pengabdian()
    {
        return $this->belongsToMany(Pengabdian::class, 'dosen_mahasiswa_pengabdian', 'nip', 'id_pengabdian');
    }

    public function portofolio()
    {
        return $this->belongsToMany(Portofolio::class, 'dosen_mahasiswa_portofolio', 'nip', 'id_portofolio');
    }

    public function prestasi()
    {
        return $this->belongsToMany(Prestasi::class, 'dosen_mahasiswa_prestasi', 'nip', 'id_prestasi');
    }

    public function sertifikasi()
    {
        return $this->hasMany(Sertifikasi::class, 'nip', 'nip');
    }
}