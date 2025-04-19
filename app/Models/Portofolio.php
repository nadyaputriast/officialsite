<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Portofolio extends Model
{
    use HasFactory;

    protected $table = 'portofolio';
    protected $primaryKey = 'id_portofolio';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'id_portofolio',
        'nama_portofolio',
        'deskripsi_portofolio',
        'status_portofolio',
        'tautan_portofolio',
        'view_count',
        'banyak_upvote',
        'banyak_downvote',
    ];

    public function dosen()
    {
        return $this->belongsToMany(Dosen::class, 'dosen_mahasiswa_portofolio', 'id_portofolio', 'nip');
    }

    public function mahasiswa()
    {
        return $this->belongsToMany(Mahasiswa::class, 'dosen_mahasiswa_portofolio', 'id_portofolio', 'nim');
    }

    public function index()
    {
        $dataPortofolio = Portofolio::where('status_portofolio', 'valid')->get();

        return view('dashboard', [
            'dataPortofolio' => $dataPortofolio,
        ]);
    }
}