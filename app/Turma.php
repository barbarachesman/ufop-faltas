<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Turma extends Model
{
    public $timestamps = false;

    protected $hidden = [
        'disciplina_id', 'periodo_id',
    ];

    protected $fillable = [
        'disciplina_id', 'periodo_id', 'codigo', 'finalizada'
    ];

    /**
     * Obtém a disciplina relacionada a turma
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function disciplina()
    {
        return $this->belongsTo('App\Disciplina');
    }

    /**
     * Obtém o período relacionado a turma
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function periodo()
    {
        return $this->belongsTo('App\Periodo');
    }

    /**
     * Obtém todos os matriculados na turma
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function matriculados()
    {
        return $this->hasMany('App\Matriculado', 'turma_id');
    }
}
