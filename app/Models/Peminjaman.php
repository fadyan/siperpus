<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    protected $table = 'peminjaman';

    protected $fillable = [
        'siswa_id',
        'buku_id',
        'no_tiket',
        'tgl_pinjam',
        'tgl_rencana_kembali',
        'tgl_kembali',
        'status'
    ];
    
    public function siswa()
    {
        return $this->belongsTo(Siswa::class,'siswa_id');
    }
    public function buku()
    {
        return $this->belongsTo(Buku::class,'buku_id');
    }
}