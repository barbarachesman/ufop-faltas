<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Matriculado extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'aluno_id', 'turma_id'
    ];
}
