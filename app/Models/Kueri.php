<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kueri extends Model
{
    protected $table = "kueri";
    protected $fillable = [
        "text",
    ];

}
