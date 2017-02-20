<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Encarregado extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'professor_id', 'turma_id'
    ];


    /**
     * Obtém o professor encarregado da turma
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function professor()
    {
        return $this->belongsTo('App\Usuario', 'professor_id', 'id');
    }

    /**
     * Obtém a turma relacionado ao professor
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function turma()
    {
        return $this->belongsTo('App\Turma', 'turma_id', 'id');
    }
}
