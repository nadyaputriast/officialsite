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
        'id_pengguna',
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
        return $this->belongsToMany(Dosen::class, 'portofolio_user_tags', 'id_portofolio', 'id_pengguna');
    }

    public function mahasiswa()
    {
        return $this->belongsToMany(Mahasiswa::class, 'portofolio_user_tags', 'id_portofolio', 'id_pengguna');
    }

    // public function users()
    // {
    //     return $this->belongsTo(User::class, 'portofolio', 'id_portofolio', 'id_pengguna')
    //         ->withTimestamps();
    // }

    public function kategoris()
    {
        return $this->hasMany(KategoriPortofolio::class, 'id_portofolio');
    }

    public function gambar()
    {
        return $this->hasMany(GambarPortofolio::class, 'id_portofolio');
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

    public function owner()
    {
        return $this->belongsTo(User::class, 'id_pengguna');
    }

    public function taggedUsers()
    {
        return $this->belongsToMany(User::class, 'portofolio_user_tags', 'id_portofolio', 'id_pengguna')
            ->withTimestamps();
    }
}
