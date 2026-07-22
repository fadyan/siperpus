<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    protected $table = "kelas";
    protected $fillable = [
        "nama"
    ];

    public function buku()
    {
        return $this->hasMany(Buku::class, 'kelas_id');
    }

    
}
