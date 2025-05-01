<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KategoriPortofolio extends Model
{
    use HasFactory;

    protected $table = 'kategori_portofolio'; // Specify the correct table name
    protected $primaryKey = 'id_kategori_portofolio';
    public $incrementing = true;
    protected $keyType = 'int';
        
    protected $fillable = [
        'id_kategori_portofolio',
        'kategori_portofolio',
        'id_portofolio'
    ];
    
    // Define relationships if needed
    public function portofolios()
    {
        return $this->belongsTo(Portofolio::class, 'kategori_portofolio', 'id_kategori_portofolio', 'id_portofolio');
    }
}