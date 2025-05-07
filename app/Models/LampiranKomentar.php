<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LampiranKomentar extends Model
{
    use HasFactory;

    protected $table = 'lampiran_komentar';
    protected $primaryKey = 'id_lampiran_komentar';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'id_lampiran_komentar',
        'lampiran_komentar',
        'id_komentar_portofolio'
    ];

    // Define relationships if needed
    public function komentarPortofolio()
    {
        return $this->belongsTo(KomentarPortofolio::class, 'id_komentar_portofolio', 'id_komentar_portofolio');
    }
}
