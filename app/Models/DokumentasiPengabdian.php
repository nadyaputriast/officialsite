<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DokumentasiPengabdian extends Model
{
    use HasFactory;

    protected $table = 'dokumentasi_pengabdian';
    protected $primaryKey = 'id_dokumentasi_pengabdian';
    public $incrementing = true;
    protected $keyType = 'int';
        
    protected $fillable = [
        'id_dokumentasi_pengabdian',
        'dokumentasi_pengabdian',
        'id_pengabdian'
    ];
    
    // Define relationships if needed
    public function pengabdian()
    {
        return $this->belongsTo(Pengabdian::class, 'dokumentasi_pengabdian', 'id_dokumentasi_pengabdian', 'id_pengabdian');
    }
}