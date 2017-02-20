<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Usuario extends Authenticatable
{
    use Notifiable;

    protected $table = "usuarios";
    public $timestamps = false;

    /**
     * Atributos que podem ser atribuídos em massa, ou seja, que podem ser usados no método User::create()
     *
     * @var array
     */
    protected $fillable = [
        'nome', 'email', 'cpf','grupo_id','grupo_nome'
    ];

    /**
     * Atributos que serão omitidos caso a instância seja convertida em um array.
     *
     * @var array
     */
    protected $hidden = [
        'cpf', 'remember_token', 'grupo_id'
    ];


    /**
     * Verifica se o usuário é um professor baseado no ID do seu grupo.
     * @return bool  True se for professor e False caso contrário.
     */
    public function isProfessor()
    {
        switch ($this->grupo_nome)
        {
            case 715: // DECEA
            case 716: // DEENP
            case 7126: // DECOM - Ouro Preto
            case 71130: // DECSI
            case 71481: // DEELT
                return true;
            default:
                return false;
        }
    }

    /**
     * Verifica se o usuário é um aluno baseado no ID de seu grupo.
     * @return bool True se for um aluno e False cao contrário.
     */
    public function isAluno()
    {
        switch ($this->grupo_id) {
            case 7236:  //Sistemas
            case 7217:  //Elétrica
            case 7215:  //Produção
            case 7213:  //Computação
                return true;
            default:
                return false;
        }
    }
}
