<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GambarPortofolio extends Model
{
    use HasFactory;

    protected $table = 'gambar_portofolio'; // Specify the correct table name
    protected $primaryKey = 'id_gambar_portofolio';
    public $incrementing = true;
    protected $keyType = 'int';
        
    protected $fillable = [
        'id_gambar_portofolio',
        'gambar_portofolio',
        'id_portofolio'
    ];
    
    // Define relationships if needed
    public function portofolios()
    {
        return $this->belongsToMany(Portofolio::class, 'gambar_portofolio', 'id_gambar_portofolio', 'id_portofolio');
    }
}