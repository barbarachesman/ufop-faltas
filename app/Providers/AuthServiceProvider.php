<?php

namespace App\Providers;

use App\Turma;
use App\Usuario;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // Define se um usuário é administrador do sistema ou não
        Gate::define('administrar', function (Usuario $usuario){
            return false;
        });

        // Define se um usuário é professor ou não
        Gate::define('lecionar', function (Usuario $usuario){
            return $usuario->isProfessor();
        });

        // Define se um usuário é aluno ou não
        Gate::define('assistir_aula', function (Usuario $usuario){
            return $usuario->isAluno();
        });

        // Define se o usuário é capaz de manipular uma determinada turma
        Gate::define('manipular_turma', function (Usuario $usuario, Turma $turma) {
            $podeManipular = false;

            foreach ($usuario->encarregado as $turmaComoProfessor)
            {
                if ($turmaComoProfessor->turma_id == $turma->id) {
                    $podeManipular = true;
                    break;
                }
            }

            return $podeManipular;
        });
    }
}
