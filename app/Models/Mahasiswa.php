<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    use HasFactory;

    protected $table = 'mahasiswa';
    protected $primaryKey = 'nim';
    public $incrementing = false;
    
    protected $fillable = [
        'id_pengguna',
        'nim',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_pengguna', 'id_pengguna');
    }

    public function event()
    {
        return $this->hasMany(Event::class, 'nim', 'nim');
    }

    public function oprekProjects()
    {
        return $this->hasMany(OprekLokerProject::class, 'kode_admin', 'kode_admin');
    }

    public function pengabdian()
    {
        return $this->belongsToMany(Pengabdian::class, 'dosen_mahasiswa_pengabdian', 'nim', 'id_pengabdian');
    }

    public function portofolio()
    {
        return $this->belongsToMany(Portofolio::class, 'dosen_mahasiswa_portofolio', 'nim', 'id_portofolio');
    }

    public function prestasi()
    {
        return $this->belongsToMany(Prestasi::class, 'dosen_mahasiswa_prestasi', 'nim', 'id_prestasi');
    }
}