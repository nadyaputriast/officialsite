<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OprekLokerProject extends Model
{
    use HasFactory;

    protected $table = 'oprek_loker_project';
    protected $primaryKey = 'id_oprek';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'id_oprek',
        'nama_project',
        'deskripsi_project',
        'deadline_project',
        'penyelenggara',
        'nama_penyelenggara',
        'output_project',
        'kategori_project',
        'tautan_project',
        'flyer_informasi',
        'status_project',
        'id_pengguna',
    ];

    protected $casts = [
        'status_project' => 'boolean',
    ];   

    public function owner()
    {
        return $this->belongsTo(User::class, 'id_pengguna');
    }

    public function kualifikasi()
    {
        return $this->hasMany(KualifikasiOprek::class, 'id_oprek', 'id_oprek');
    }
}
