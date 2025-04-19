<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Filament\Models\Contracts\HasName;

class User extends Authenticatable implements HasName
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

    public function getFilamentName(): string
    {
        return (string) ($this->nama_pengguna ?? 'Default User');
    }

    public function getUserName(): string
    {
        return $this->nama_pengguna ?: 'Default User';
    }

    public function admin()
    {
        return $this->hasOne(Admin::class, 'kode_admin');
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
        return $this->belongsToMany(Event::class, 'event_registration');
    }

    public function getKodeAdmin()
    {
        return $this->is_admin ? $this->kode_admin : null;
    }

    public function getNim()
    {
        return !$this->is_admin ? $this->nim : null;
    }
}