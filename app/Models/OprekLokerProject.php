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

    public function getKualifikasiStringAttribute()
    {
        return $this->kualifikasi->pluck('kualifikasi_oprek')->join(', ');
    }

    public function getKualifikasiArrayAttribute()
    {
        return $this->kualifikasi->pluck('kualifikasi_oprek')->toArray();
    }

    public function notifikasi()
    {
        return $this->hasMany(Notifikasi::class, 'notifiable_id')
            ->where('notifiable_type', 'oprek_loker_project');
    }

    public function latestNotifikasi()
    {
        return $this->hasOne(Notifikasi::class, 'notifiable_id')
            ->where('notifiable_type', 'oprek_loker_project')
            ->latest();
    }

    public function isExpired()
    {
        return $this->deadline_project && $this->deadline_project < now()->toDateString();
    }

    public function scopeActive($query)
    {
        return $query->where('status_project', 1);
    }
}
