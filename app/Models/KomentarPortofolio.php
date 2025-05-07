<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KomentarPortofolio extends Model
{
    use HasFactory;

    protected $table = 'komentar_portofolio';
    protected $primaryKey = 'id_komentar_portofolio';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'id_komentar_portofolio',
        'komentar',
        'id_portofolio',
        'id_pengguna'
    ];

    // Define relationships if needed
    public function portofolio()
    {
        return $this->belongsTo(OprekLokerProject::class, 'id_portofolio', 'id_portofolio');
    }

    public function pengguna()
    {
        return $this->belongsTo(User::class, 'id_pengguna', 'id_pengguna');
    }

    public function lampiranKomentar()
    {
        return $this->hasMany(LampiranKomentar::class, 'id_komentar_portofolio', 'id_komentar_portofolio');
    }
}
