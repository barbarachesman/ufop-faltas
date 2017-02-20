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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
    public function importCSV(CriarTurmaRequest $request)
    {
        Excel::setDelimiter(';'); // Muda o delimitador de campos para ponto-e-vírgula (;)

        Excel::load($request->file('file'), function ($reader) {

            $alunos = $reader->get()->toArray();
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

                    if(is_null($disciplina)) return redirect()->route('importarTurma')->withErrors(['disciplina' => 'A disciplina não existe. Entre em contato com o administrador para que seja cadastrada.']);
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
                    $details = $this->getAlunoDetails('nomecompleto', $aluno['nome'], $aluno['curso']);
                    if(is_null($details))
                    {
                        // fallback de alunos não encontrados
                        $details['cpf'] = substr(uniqid(), 0, 11); // Uma string aleatória para o CPF
                        $details['grupo'] = 'Não encontrado';
                        $details['id_grupo'] = 0;

                        // Registra no log que um aluno não foi encontrado.
                        event(new AlunoNotFoundEvent($aluno['nome'], $aluno['email'], $aluno['curso'], $aluno['matricula']));
                    }

                    $usuario = Usuario::firstOrCreate([
                        'cpf' => $details['cpf'],
                        'grupo_nome' => ucwords(strtolower($details['grupo'])),
                        'grupo_id' => $details['id_grupo'],
                        'nome' => ucwords(strtolower($aluno['nome'])),
                        'email' => $aluno['email']
                    ]);
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
        });

        return redirect()->route('home');
    }

    public function getAlunoDetails($campo, $valor, $grupo)
    {
        $httpClient = new Client(['verify' => false]);

        // Componentes do corpo da requisição
        $requestBody['baseConnector'] = "and";
        $requestBody['attributes'] = ["cpf", "grupo", "id_grupo"]; // Atributos que devem ser retornados
        $requestBody['searchBase'] = "ou=People,dc=ufop,dc=br";
        $requestBody['filters'][0] = [$campo => ["equals", $valor]];

        try
        {
            $response = $httpClient->request(config('ldapi.requestMethod'), config('ldapi.searchUrl'), [
                "auth" => [config('ldapi.user'), config('ldapi.password'), "Basic"],
                "body" => json_encode($requestBody),
                "headers" => [
                    "Content-type" => "application/json",
                ],
            ]);
        }
        catch (\Exception $ex) {
            $responseBody = $ex->getMessage();
            event(new AlunoSearchError($responseBody)); // Registra no log que ocorreu um erro durante a comunicação com a LDAPI
            return null;
        }

        $result = json_decode($response->getBody()->getContents(), true);
        if($result['count'] == 0) return null;
        else if($result['count'] == 1) return $result['result'][0];
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
            foreach ($result['result'] as $possivelAluno) if($possivelAluno['id_grupo'] == $id_grupo) $aluno = $possivelAluno;

            return $aluno;
        }
    }
}
