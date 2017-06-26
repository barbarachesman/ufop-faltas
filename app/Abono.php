<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Abono extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'observacao', 'arquivo', 'faltas_aluno_id', 'faltas_turma_id', 'faltas_data','faltas_data_final', 'status'
    ];


    /**
     * Recupera a turma em que ocorreu a falta
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function turma()
    {
        return $this->belongsTo('App\Turma');
    }

    public function faltas()
    {
        return $this->hasMany('App\Falta');
    }

    public function aluno()
    {
        return $this->belongsTo('App\Usuario', 'faltas_aluno_id');
    }

}
