<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notifikasi extends Model
{
    protected $table = 'notifikasi';

    protected $primaryKey = 'id_notifikasi';
    protected $fillable = [
        'isi_notifikasi', 'notifiable_id', 'notifiable_type', 'id_pengguna', 'is_read'
    ];

    public function notifiable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_pengguna');
    }
}