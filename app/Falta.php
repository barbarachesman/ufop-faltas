<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Falta extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'aluno_id', 'turma_id', 'data',
    ];

    /**
     * Recupera o aluno que faltou.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function aluno()
    {
        return $this->belongsTo('App\Usuario', 'aluno_id');
    }

    /**
     * Recupera a turma em que ocorreu a falta
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function turma()
    {
        return $this->belongsTo('App\Turma');
    }
}
