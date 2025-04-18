<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    use HasFactory;

    protected $table = 'admin';

    protected $fillable = [
        'id_pengguna',
        'kode_admin',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_pengguna', 'id_pengguna');
    }

    public function oprek_loker_project()
    {
        return $this->hasMany(OprekLokerProject::class, 'kode_admin', 'kode_admin');
    }

    public function event()
    {
        return $this->hasMany(Event::class, 'kode_admin', 'kode_admin');
    }
}
