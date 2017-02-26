<?php

namespace App\Http\Controllers;

use App\Turma;
use App\Usuario;
use Illuminate\Http\Request;

class AlunoController extends Controller
{
    public function desmatricular(Usuario $aluno, Turma $turma)
    {
        dd("teste");
    }
}
