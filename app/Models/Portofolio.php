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
        'view_count',
        'banyak_upvote',
        'banyak_downvote',
        'dokumen_portofolio',
    ];

    public function kategori()
    {
        return $this->hasMany(KategoriPortofolio::class, 'id_portofolio');
    }

    public function gambar()
    {
        return $this->hasMany(GambarPortofolio::class, 'id_portofolio');
    }

    public function komentar()
    {
        return $this->hasMany(KomentarPortofolio::class, 'id_portofolio');
    }

    public function tautan()
    {
        return $this->hasMany(TautanPortofolio::class, 'id_portofolio');
    }

    public function tools()
    {
        return $this->hasMany(ToolsPortofolio::class, 'id_portofolio');
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

    public function votes()
    {
        return $this->hasMany(PortofolioVote::class, 'id_portofolio', 'id_portofolio');
    }
}
