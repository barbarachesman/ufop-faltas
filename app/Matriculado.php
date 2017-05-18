<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Matriculado extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'aluno_id', 'turma_id'
    ];

    /**
     * Obtém a instância de Usuario referente ao aluno matriculado na turma.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function aluno()
    {
        return $this->belongsTo('App\Usuario', 'aluno_id');
    }

    /**
     * Obtém a instância da turma referente ao aluno matriculado.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function turma()
    {
        return $this->belongsTo('App\Turma');
    }
}
