<?php

namespace App\Listeners;

use App\Events\AlunoSearchError;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class LogAlunoSearchError
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
     * @param  AlunoSearchError  $event
     * @return void
     */
    public function handle(AlunoSearchError $event)
    {
        Log::error('Falha na busca de aluno', ['mensagem' => $event->errorMessage]);
    }
}
