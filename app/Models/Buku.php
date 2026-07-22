<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    protected $table = "buku";
    protected $fillable = [
        "kelas_id",
        "judul",
        "rak_buku_id",
        "pengarang",
        "penerbit_id",
        "deskripsi",
        "jumlah",
        "tahun",
        "cover",
    ];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class,'kelas_id');
    }
    public function rak_buku()
    {
        return $this->belongsto(Rak_Buku::class,'rak_buku_id');
    }
    public function penerbit()
    {
        return $this->belongsto(Penerbit::class,'penerbit_id');
    }
}
