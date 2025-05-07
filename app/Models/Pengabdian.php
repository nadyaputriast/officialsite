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

    public function owner()
    {
        return $this->belongsTo(User::class, 'id_pengguna');
    }

    public function dokumentasi()
    {
        return $this->hasMany(DokumentasiPengabdian::class, 'id_pengabdian');
    }

    public function taggedUsers()
    {
        return $this->belongsToMany(User::class, 'pengabdian_user_tags', 'id_pengabdian', 'id_pengguna')
        ->withTimestamps();
    }

    public function index()
    {
        $dataPortofolio = Portofolio::where('status_portofolio', true)->get();
        $users = User::all();

        return view('dashboard', [
            'dataPortofolio' => $dataPortofolio,
            'users' => $users,
        ]);
    }
}
