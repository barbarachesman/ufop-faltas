<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Disciplina;
use App\Encarregado;
use App\Events\AlunoNotFoundEvent;
use App\Events\AlunoSearchError;
use App\Http\Requests\CriarTurmaRequest;
use App\Matriculado;
use App\Periodo;
use App\Turma;
use App\Usuario;
use GuzzleHttp\Client;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;

class PagesController extends Controller
{
    /**
     * Renderiza a página inicial do sistema.
     */
    public function home()
    {
if(auth()->user()->isAdmin())
      {
          $turmas = Encarregado::with('turma', 'turma.disciplina', 'turma.periodo')->get();
      }
      else if(auth()->user()->isProfessor())
      {
          $turmas = Encarregado::with('turma', 'turma.disciplina', 'turma.periodo')->where('professor_id', auth()->id())->get();
      }
      else
      {
          $turmas = Matriculado::with('turma', 'turma.disciplina', 'turma.periodo')->where('aluno_id', auth()->id())->get();
      }

      return view('inicio')->with(['turmas' => $turmas]);
    }

    public function tutorial()
    {
        return view('tutorial');
    }

    public function abono()
    {
      return view('abono');
    }

    /**
     * Renderiza a view contento informações sobre o sistema.
     */
    public function sobre()
    {
        return view('sobre');
    }

     public function index()
     {
         return view('home');
     }
}
