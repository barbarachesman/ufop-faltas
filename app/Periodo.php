<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Periodo extends Model
{

    public $timestamps = false;

    protected $hidden = [
        'id',
    ];

    protected $fillable = [
        'ano', 'periodo',
    ];
}
