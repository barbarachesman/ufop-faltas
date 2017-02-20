<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class AlunoNotFoundEvent
{
    use InteractsWithSockets, SerializesModels;

    public $alunoNome, $alunoEmail, $alunoGrupo, $alunoMatricula;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($nome, $email, $grupo, $matricula)
    {
        $this->alunoNome = $nome;
        $this->alunoEmail = $email;
        $this->alunoGrupo = $grupo;
        $this->alunoMatricula = $matricula;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
