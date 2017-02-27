<?php

namespace App\Http\Controllers;

use App\Turma;
use App\Usuario;
use Illuminate\Support\Facades\DB;

class AlunoController extends Controller
{
    /**
     * Desmatricula um aluno de uma determinada turma, apagando todas as suas faltas
     * @param Usuario $aluno Instância do aluno
     * @param Turma $turma Instância da turma
     * @return \Illuminate\Http\RedirectResponse Página anterior
     */
    public function desmatricular(Usuario $aluno, Turma $turma)
    {
        /* Como o Eloquent não dá suporte a chave compostas, é necessário usar a classe DB para excluir 'manualmente' */

        $faltasDoAluno = DB::table('faltas')->where('aluno_id', $aluno->id)->where('turma_id', $turma->id)->delete();
        $desmatriculado = DB::table('matriculados')->where('aluno_id', $aluno->id)->where('turma_id', $turma->id)->delete();

        return redirect()->route('detalheTurma', $turma->id);
    }
}
