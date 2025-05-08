<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Download extends Model
{
    protected $table = 'download';

    protected $primaryKey = 'id_download';

    protected $fillable = [
        'nama_download',
        'jenis_konten',
        'file_konten',
        'status_download',
        'id_pengguna'
    ];

    public function pengguna()
    {
        return $this->belongsTo(User::class, 'id_pengguna');
    }
}