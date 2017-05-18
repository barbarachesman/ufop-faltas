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

    /**
     * Recupera as turmas relacionadas com o período
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function turmas()
    {
        return $this->hasMany('App\Turma');
    }
}
