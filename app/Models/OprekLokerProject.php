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
		'tautan_oprek',
		'kode_admin',
		'nip',
		'nim',
    ];

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'kode_admin', 'kode_admin');
    }
	
	public function dosen()
	{
		return $this->belongsTo(Dosen::class, 'nip', 'nip');
	}

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'nim', 'nim');
    }
}