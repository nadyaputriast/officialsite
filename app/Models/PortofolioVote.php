<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PortofolioVote extends Model
{
    use HasFactory;

    protected $table = 'portofolio_votes';

    protected $fillable = [
        'id_portofolio',
        'id_pengguna',
        'jenis_vote',
    ];

    public function portofolio()
    {
        return $this->belongsTo(Portofolio::class, 'id_portofolio', 'id_portofolio');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_pengguna', 'id_pengguna');
    }
}