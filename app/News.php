<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class News extends Model
{
    protected $fillable = [
        'ano', 'semestre', 'coddisciplina','matricula','nome','curso','turma','email'
    ];

}
