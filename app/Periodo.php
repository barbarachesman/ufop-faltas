<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Periodo extends Model
{
    protected $hidden = [
        'id',
    ];

    protected $fillable = [
        'ano', 'periodo',
    ];
}
