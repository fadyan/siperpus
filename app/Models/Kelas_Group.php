<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class kelas_group extends Model
{
    protected $table = "kelas_group";
    protected $fillable = [
        "kelas_id",
        "nama_kelas"
    ];

    public function kelas()
    {
        return $this->belongsTo(kelas::class,'kelas_id');
    }
}
