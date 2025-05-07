<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DokumentasiPrestasi extends Model
{
    use HasFactory;

    protected $table = 'dokumentasi_prestasi';
    protected $primaryKey = 'id_dokumentasi_prestasi';
    public $incrementing = true;
    protected $keyType = 'int';
        
    protected $fillable = [
        'id_dokumentasi_prestasi',
        'dokumentasi_prestasi',
        'id_prestasi'
    ];
    
    // Define relationships if needed
    public function prestasi()
    {
        return $this->belongsTo(Prestasi::class, 'dokumentasi_prestasi', 'id_dokumentasi_prestasi', 'id_prestasi');
    }
}