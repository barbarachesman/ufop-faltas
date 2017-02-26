<?php

namespace App\Http\Controllers;

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
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class TurmaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {
        $turmas = Encarregado::with('turma', 'turma.disciplina', 'turma.periodo')->where('professor_id', auth()->id())->get();
        return view('turma.index')->with(['turmas' => $turmas]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('turma.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Renderiza a view com os detalhes da turma, mostrando todos os alunos nela matriculado
     *
     * @param Turma $turma Turma a ser exibida
     */
    public function show(Turma $turma)
    {
        $alunos = Matriculado::with('aluno')->where('turma_id', $turma->id)->get();
        return view('turma.show')->with(['alunos' => $alunos, 'turma' => $turma]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     *
     * Importa uma determinada turma para o banco de dados. O periodo e a turma são criados automaticamente e os alunos
     * já ficam vinculados a turma também automaticamente pela tabela 'matriculados'.
     *
     * Caso a disciplina não exista, retorna-se para a página anteiror. Em caso de erro durante a busca das informações
     * do aluno, o aluno é adicionado com detalhes genéricos e a importação não é abortada.
     *
     * Alunos com nomes iguais são filtrados pelo curso e alunos que não forem encontrados são cadastrados com informaçòes
     * genéricas.
     *
     * @param CriarTurmaRequest $request Requisição HTTP com os campos do formulário validos.
     * @return \Illuminate\Http\RedirectResponse Para a página anterior em caso de erro ou para a listagem das turmas.
     */
    public function importarCSV(CriarTurmaRequest $request)
    {
        Excel::setDelimiter(';'); // Muda o delimitador de campos para ponto-e-vírgula (;)

        // Transforma o CSV da turma em um array associativo (dicionário)
        $alunos = Excel::load($request->file('file'))->get()->toArray();
        $callback = $this->parseTurma($alunos);

        if($callback == false) return back()->withErrors(['disciplina' => 'A disciplina não existe. Entre em contato com o administrador para que seja cadastrada.']);
        else return redirect()->route('visualizarTurmas');
    }

    /**
     * @param array $alunos Array contendo as informações dos alunos
     * @return boolean True se a turma for decodificada com sucesso e False caso contrário
     */
    private function parseTurma($alunos)
    {
        $turma = null; // sinaliza se a turma já foi criada ou não

        foreach ($alunos as $aluno)
        {
            // Criação da turma na primeira iteração
            if(is_null($turma))
            {
                $periodo = Periodo::firstOrCreate([
                    'ano' => $aluno['ano'],
                    'periodo' => $aluno['semestre']
                ]);

                $disciplina = Disciplina::where('codigo', $aluno['cod_disciplina'])->first();

                if(is_null($disciplina)) return false;
                else
                {
                    $turma = Turma::firstOrCreate([
                        'disciplina_id' => $disciplina->id,
                        'periodo_id' => $periodo->id,
                        'codigo' => $aluno['turma'],
                        'finalizada' => false
                    ]);
                }
            }

            // Verifica se o usuário existe
            $usuario = Usuario::where('nome', $aluno['nome'])->first();

            // Se ele não existir, então deve ser criado
            if(is_null($usuario))
            {
                // Obtém as informações necessárias para a criação
                $detalhesDoAluno = $this->obterDetalhesDeAluno('nomecompleto', $aluno['nome'], $aluno['curso']);
                if(is_null($detalhesDoAluno))
                {
                    // fallback de alunos não encontrados
                    $detalhesDoAluno['cpf'] = substr(uniqid(), 0, 11); // Uma string aleatória para o CPF
                    $detalhesDoAluno['grupo'] = 'Nao encontrado';
                    $detalhesDoAluno['id_grupo'] = 0;

                    // Registra no log que um aluno não foi encontrado.
                    event(new AlunoNotFoundEvent($aluno['nome'], $aluno['email'], $aluno['curso'], $aluno['matricula']));
                }

                $usuario = Usuario::Create([
                    'cpf' => $detalhesDoAluno['cpf'],
                    'grupo_nome' => ucwords(strtolower($detalhesDoAluno['grupo'])),
                    'grupo_id' => $detalhesDoAluno['id_grupo'],
                    'nome' => ucwords(strtolower($aluno['nome'])),
                    'email' => $aluno['email'],
                    'matricula' => $aluno['matricula']
                ]);
            }
            else if(is_null($usuario->matricula)) // Para alunos que entraram no sistema antes de ser cadastrado pelo professor
            { // Atualiza-se a sua matricula
                $usuario->matricula = $aluno['matricula'];
                $usuario->save();
            }

            $matricula = Matriculado::firstOrCreate([
                'aluno_id' => $usuario->id,
                'turma_id' => $turma->id
            ]);

            $encarregado = Encarregado::firstOrCreate([
                'professor_id' => auth()->id(),
                'turma_id' => $turma->id
            ]);
        }

        return true;
    }

    /**
     * Obtém os detalhes do aluno necessários para a criação de uma nova instância de usuário através da LDAPI.
     * @param mixed $campo Nome do campo usado na procura do aluno
     * @param mixed $valor Valor do campo escolhido
     * @param int $grupo Grupo o qual o aluno pertence
     * @return null|array Null se o aluno não for encotrado ou um Array com os detalhes se for encontrado
     */
    private function obterDetalhesDeAluno($campo, $valor, $grupo)
    {
        $httpClient = new Client(['verify' => false]);

        // Componentes do corpo da requisição
        $corpoDaRequisicao['baseConnector'] = "and";
        $corpoDaRequisicao['attributes'] = ["cpf", "grupo", "id_grupo"]; // Atributos que devem ser retornados
        $corpoDaRequisicao['searchBase'] = "ou=People,dc=ufop,dc=br";
        $corpoDaRequisicao['filters'][0] = [$campo => ["equals", $valor]];

        try
        {
            $resposta = $httpClient->request(config('ldapi.requestMethod'), config('ldapi.searchUrl'), [
                "auth" => [config('ldapi.user'), config('ldapi.password'), "Basic"],
                "body" => json_encode($corpoDaRequisicao),
                "headers" => [
                    "Content-type" => "application/json",
                ],
            ]);
        }
        catch (\Exception $ex) {
            $corpoDaResposta = $ex->getMessage();
            event(new AlunoSearchError($corpoDaResposta)); // Registra no log que ocorreu um erro durante a comunicação com a LDAPI
            return null;
        }

        $resultado = json_decode($resposta->getBody()->getContents(), true);
        if($resultado['count'] == 0) return null;
        else if($resultado['count'] == 1) return $resultado['result'][0];
        else // Tratamento de pessoas com nomes iguais somente para cursos do ICEA
        {
            $id_grupo = null;

            switch ($grupo)
            {
                case 'SJM': // Sistemas
                    $id_grupo = 7236;
                    break;
                case 'PJM': // Produção
                    $id_grupo = 7215;
                    break;
                case 'EJM': // Elétrica
                    $id_grupo = 7217;
                    break;
                case 'CJM': // Computação
                    $id_grupo = 7213;
                    break;
            }

            // Valor padrão caso nenhum grupo seja encontrado
            $aluno = null;

            // Busca pelo resultado que pertença ao mesmo grupo do aluno informado no CSV
            foreach ($resultado['result'] as $possivelAluno) if($possivelAluno['id_grupo'] == $id_grupo) $aluno = $possivelAluno;

            return $aluno;
        }
    }

    /**
     * Finaliza uma turma.
     * @param Turma $turma Instância da turma a ser finalizada
     * @return \Illuminate\Http\RedirectResponse Página anterior
     */
    public function finalizar(Turma $turma)
    {
        $turma->finalizada = true;
        $turma->save();
        return back();
    }
}
