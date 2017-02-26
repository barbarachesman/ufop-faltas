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
