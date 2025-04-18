<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sertifikasi extends Model
{
    use HasFactory;

    protected $table = 'sertifikasi';
    protected $primaryKey = 'id_sertifikasi';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'nama_sertifikasi',
        'deskripsi_sertifikasi',
        'status_sertifikasi',
        'penyelenggara',
        'tanggal_sertifikasi',
        'masa_berlaku',
        'file_sertifikasi',
        'nip',
    ];

    // Relasi ke tabel dosen
    public function dosen()
    {
        return $this->belongsTo(Dosen::class, 'nip', 'nip');
    }

    // Mengecek kevalidan sertifikasi
    public function isValid()
    {
        return $this->status_sertifikasi === 'valid';
    }
}