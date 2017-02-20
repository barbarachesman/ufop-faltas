<?php

namespace App\Listeners;

use App\Events\AlunoNotFoundEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class LogAlunoNotFound
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  AlunoNotFoundEvent  $event
     * @return void
     */
    public function handle(AlunoNotFoundEvent $event)
    {
        Log::warning('Aluno não encontrado no servidor AD', ['nome' => $event->alunoNome, 'matricula' => $event->alunoMatricula, 'email' => $event->alunoEmail, 'grupo' => $event->alunoGrupo]);
    }
}
