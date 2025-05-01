<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KualifikasiOprek extends Model
{
    use HasFactory;

    protected $table = 'kualifikasi_oprek'; // Specify the correct table name
    protected $primaryKey = 'id_kualifikasi_oprek';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'id_kualifikasi_oprek',
        'kualifikasi_oprek',
        'id_oprek'
    ];

    // Define relationships if needed
    public function oprek()
    {
        return $this->belongsTo(OprekLokerProject::class, 'id_oprek', 'id_oprek');
    }
}
