<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, HasRoles, Notifiable;

    protected $table = 'users';
    protected $primaryKey = 'id_pengguna';
    public $incrementing = true;
    protected $keyType = 'int';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'nama_pengguna',
        'email',
        'password',
        'tanggal_lahir',
        'alamat',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    protected static function booted()
    {
        static::created(function ($user) {
            if ($user->role) {
                $user->assignRole($user->role);
            }
        });
    }

    public function getUserName(): string
    {
        return $this->nama_pengguna ?: 'Default User';
    }

    public function admin()
    {
        return $this->hasOne(Admin::class, 'id_pengguna');
    }

    public function mahasiswa()
    {
        return $this->hasOne(Mahasiswa::class, 'id_pengguna');
    }

    public function dosen()
    {
        return $this->hasOne(Dosen::class, 'id_pengguna');
    }

    public function events()
    {
        return $this->hasMany(Event::class, 'event_registration');
    }

    public function portofolio()
    {
        return $this->hasMany(Portofolio::class, 'id_pengguna');
    }

    public function taggedPortofolios()
    {
        return $this->belongsToMany(Portofolio::class, 'portofolio_user_tags', 'id_pengguna', 'id_portofolio')
            ->withTimestamps();
    }

    public function getKodeAdmin()
    {
        return $this->is_admin ? $this->kode_admin : null;
    }

    public function getNim()
    {
        return !$this->is_admin ? $this->nim : null;
    }

    public function oprekProjects()
    {
        return $this->hasMany(OprekLokerProject::class, 'id_pengguna');
    }

    public function prestasi()
    {
        return $this->hasMany(Prestasi::class, 'id_pengguna');
    }

    public function taggedPrestasi()
    {
        return $this->belongsToMany(Prestasi::class, 'prestasi_user_tags', 'id_pengguna', 'id_prestasi')
            ->withTimestamps();
    }

    public function sertifikasi()
    {
        return $this->hasMany(Sertifikasi::class, 'id_pengguna');
    }

    public function pengabdian()
    {
        return $this->hasMany(Pengabdian::class, 'id_pengguna');
    }

    public function taggedPengabdian()
    {
        return $this->belongsToMany(Pengabdian::class, 'pengabdian_user_tags', 'id_pengguna', 'id_pengabdian')
            ->withTimestamps();
    }
}