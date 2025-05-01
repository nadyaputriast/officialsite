<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ToolsPortofolio extends Model
{
    use HasFactory;

    protected $table = 'tools_portofolio';
    protected $primaryKey = 'id_tools_portofolio';
    public $incrementing = true;
    protected $keyType = 'int';
        
    protected $fillable = [
        'id_tools_portofolio',
        'tools_portofolio',
        'id_portofolio'
    ];
    
    // Define relationships if needed
    public function portofolios()
    {
        return $this->belongsTo(Portofolio::class, 'tools_portofolio', 'id_tools_portofolio', 'id_portofolio');
    }
}
