<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'data_id',
        'nama',
        'level',
        'username',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
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



    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'data_id');
    }

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'data_id');
    }

    public function getNamaLengkapAttribute()
    {
        if ($this->level === 'siswa') {
            return $this->siswa?->nama_siswa;
        }

        return $this->pegawai?->nama_pegawai;
    }
}
