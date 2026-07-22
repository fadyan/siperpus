<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rak_Buku extends Model
{
    protected $table = "rak_buku";
    protected $fillable = [
        "nama_rak"
    ];

    public function buku()
    {
        return $this->hasMany(Buku::class, 'rak_buku_id');
    }

}
