<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    protected $table = 'siswa';

    protected $fillable = [
        'nisn',
        'nama_siswa',
        'jk',
        'tempat_lahir',
        'tanggal_lahir',
        'kelas_group_id'
    ];
    public function kelas_group()
    {
        return $this->belongsTo(Kelas_Group::class, 'kelas_group_id');
    }
}

