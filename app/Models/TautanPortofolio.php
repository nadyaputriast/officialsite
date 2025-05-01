<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TautanPortofolio extends Model
{
    use HasFactory;

    protected $table = 'tautan_portofolio';
    protected $primaryKey = 'id_tautan_portofolio';
    public $incrementing = true;
    protected $keyType = 'int';
        
    protected $fillable = [
        'id_tautan_portofolio',
        'tautan_portofolio',
        'id_portofolio'
    ];
    
    // Define relationships if needed
    public function portofolios()
    {
        return $this->belongsTo(Portofolio::class, 'tautan_portofolio', 'id_tautan_portofolio', 'id_portofolio');
    }
}
