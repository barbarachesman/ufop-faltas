<?php

namespace App\Http\Controllers;

use App\Falta;
use App\Matriculado;
use App\Turma;

class FaltaController extends Controller
{
    public function show(Turma $turma)
    {
        $faltas = Falta::with('aluno')->where('turma_id', $turma->id)->get()->sortBy('data');
        $matriculados = Matriculado::with('aluno')->where('turma_id', $turma->id)->get();

        return view('falta.show')->with(['turma' => $turma, 'faltas' => $faltas, 'matriculados' => $matriculados]);
    }
}
