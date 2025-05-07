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
        'id_pengguna',
    ];

    public function owner()
    {
        return $this->belongsTo(User::class, 'id_pengguna');
    }

    public function index()
    {
        $dataSerfifikasi = Sertifikasi::where('statusSerfifikasi', true)->get();
        $users = User::all();

        return view('dashboard', [
            'dataSerfifikasi' => $dataSerfifikasi,
            'users' => $users,
        ]);
    }
}