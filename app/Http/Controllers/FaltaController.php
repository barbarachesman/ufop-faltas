<?php

namespace App\Http\Controllers;

use App\Falta;
use App;
use Maatwebsite\Excel\Facades\Excel;
use View;
use Request;
use PDF;
use App\Http\Requests\AtualizarFaltaRequest;
use App\Http\Requests\GerarDiarioRequest;
use App\Http\Requests\GerenciarFaltaRequest;
use App\Http\Requests\CreateJustificativaRequest;
use App\Matriculado;
use App\Justificativa;
use App\Turma;
use App\Usuario;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class FaltaController extends Controller
{
  /**
  * Renderiza a view contendo as faltas de uma determinada turma
  * @param Turma $turma Instância da turma
  */
  public function show(Turma $turma)
  {
    $faltas = Falta::with('aluno')->where('turma_id', $turma->id)->get()->sortBy('data')->groupBy('data');
    $matriculados = Matriculado::with('aluno')->where('turma_id', $turma->id)->get();

    return view('falta.show')->with(['turma' => $turma, 'faltas' => $faltas, 'matriculados' => $matriculados]);
  }

  public function justificativa(Turma $turma, Matriculado $aluno)
  {
    $faltas = Falta::with('aluno')->where('turma_id', $turma->id)->get()->sortBy('data')->groupBy('data');

    return view('justificativa.show')->with(['turma' => $turma]);
  }

  public function store(CreateJustificativaRequest $request)
  {//'observacao', 'arquivo', 'faltas_aluno_id', 'faltas_turma_id', , 'faltas_data','faltas_data_final', 'status'
    $form = $request->all();
    // Limpeza de CPF
    //$form['usuario'] = RequisicaoController::cleanCPF($form['usuario']);
    /*
    $destinationPath = public_path().DIRECTORY_SEPARATOR.'files';
    $fileName = '01.'.pathinfo('Hearthstone.desktop')['extension'];

    //var_dump($file->move($destinationPath.DIRECTORY_SEPARATOR.'tmp'));
    var_dump($file->move($destinationPath, $fileName));
    */

    if( !is_null($form['dataFinal'])) $dataFinal = null; //"29/06/2017"
    $dataFinal = date_create_from_format('d/m/Y', $form['dataFinal'])->format('Y-m-d H:i:s');

    $novoJustificativa = Justificativa::create([
      'observacao' => $form['observacao'],
      'aluno_id' => auth()->id(),
      'turma_id' => $form['turma'],
      'dataInicial' => $form['dataInicial'],
      'dataFinal' => $dataFinal,
      'status' => '0',
      'arquivo' => $form['arquivo']->store('justificativas'),
    ]);
    dd($novoJustificativa);
    event(new RequestStored($novoJustificativa, auth()->user()));
    session()->flash('tipo', 'success');
    session()->flash('mensagem', 'Sua solicitação de justificativa foi enviada com sucesso. Você será notificado assim que o professor julgá-la.');
    // Envio de e-mail avisando que a requisição foi aprovada.
    $user = Ldapuser::where('cpf', $form['auth()->user()->cpf'])->first();
    if(isset($user) && isset($user->email)) Mail::to($user->email)->queue(new RequestReceived($user, $novoJustificativa));
    return redirect()->route('indexUserRequisicao');
  }

  /**
  * Renderiza a view de seleção de data(s) para gerenciar as faltas
  * @param Turma $turma Instância da turma
  */
  public function select(Turma $turma)
  {
    return view('falta.select')->with('turma', $turma);
  }

    /**
     * Gera uma planilha em formato XLS contendo os dados de frequência dos alnos de uma determinada turma
     * @param GerarDiarioRequest $request Requisição com os campos validados
     * @param Turma $turma Turma que terá seu diário de frequência gerado
     */
  public function gerarDiario(GerarDiarioRequest $request, Turma $turma)
  {
      $form = $request->all();
      $dataCorrente = Carbon::createFromFormat('d/m/Y', $form['dataInicial']);
      $dataFinal = Carbon::createFromFormat('d/m/Y', $form['dataFinal']);

      $datas = array();

      while($dataCorrente <= $dataFinal)
      {
          if(isset($form['dias']) && in_array($dataCorrente->dayOfWeek, $form['dias']))
              $datas[] = $dataCorrente->copy();
          else if(!isset($form['dias']))
              $datas[] = $dataCorrente->copy();

          $dataCorrente = $dataCorrente->addDay();
      }

      $nomeDoArquivo = 'DIARIO-' . $turma->disciplina->codigo . '-' . $turma->disciplina->nome . '-' . $turma->codigo . '-' . $turma->periodo->ano . '-' . $turma->periodo->periodo;

      $teste = Excel::create($nomeDoArquivo, function ($excel) use($turma, $datas) {

          // Set the title
          $excel->setTitle('Diario de Frequencia -' . $turma->disciplina->codigo . ' ' . $turma->disciplina->nome . ' T' . $turma->codigo)
                ->setKeywords("Diario de Frequencia, " . $turma->disciplina->nome . ", " . $turma->disciplina->codigo . ", Turma " . $turma->codigo)
                ->setLastModifiedBy(auth()->user()->nome);

          $excel->sheet("Diário", function ($sheet) use($turma, $datas) {

              // Sets all borders
              $sheet->setAllBorders('thin');
              $sheet->setHeight(1, 35);
              $sheet->setHeight(2, 35);
              $sheet->setHeight(3, 35);

              // Informação básica do diário
              $sheet->cell('A1', function($cell) use ($turma) {
                  $linha1 = "UNIVERSIDADE FEDERAL DE OURO PRETO";
                  $linha2 = strtoupper(auth()->user()->grupo_nome);
                  $linha3 = "DIÁRIO DE CLASSE";
                  $linha4 = $turma->periodo->ano . "/" . $turma->periodo->periodo;

                  // Insere as linhas com uma quebra entre elas
                  $cell->setValue($linha1 . "\n" .  $linha2 . "\n" . $linha3 . "\n" . $linha4);

                  // Set font size
                  $cell->setFontSize(12);

                  // Set font weight to bold
                  $cell->setFontWeight('bold');
              });

              // Mescla as cédulas com o cabeçalho do documento, com o departamento, ano e período
              $sheet->mergeCells('A1:C3');
              $sheet->getStyle('A1')->getAlignment()->setWrapText(true);
              $sheet->getStyle('A1')->getAlignment()->setVertical('top');

              // Código e nome da disciplina
              $sheet->cell('D1', function($cell) use ($turma) {
                  $cell->setValue($turma->disciplina->codigo . " - " . $turma->disciplina->nome);
              });
              $sheet->getStyle('D1')->getAlignment()->setVertical('top');

              // Mescla as cédulas onde está o rótulo do código da disciplina e a turma
              $sheet->mergeCells('D1:AA1');

              // Cabeçalho informando que essa será a linha com os rótulos das datas
              $sheet->cell('D2', function($cell) {
                  $cell->setValue("DIA");
              });
              $sheet->getStyle('D2')->getAlignment()->setVertical('top');

              // Rótulo com o tipo de aula (Teórica ou Prática)
              $sheet->cell('D3', function($cell) {
                  $cell->setValue("TIPO");
              });
              $sheet->getStyle('D3')->getAlignment()->setVertical('top');

              $sheet->getStyle('AB1')->getAlignment()->setWrapText(true);
              $sheet->getStyle('AB1')->getAlignment()->setHorizontal('center');
              $sheet->getStyle('AB1')->getAlignment()->setVertical('top');

              // Rótulo do código da turma
              $sheet->cell('AB1', function($cell) use ($turma) {
                  $cell->setValue("TURMA \n" . $turma->codigo);
              });

              // Rótulo da carga horária
              $sheet->cell('AC1', function($cell) {
                  $cell->setValue("C.H.");
              });
              $sheet->getStyle('AC1')->getAlignment()->setHorizontal('center');
              $sheet->getStyle('AC1')->getAlignment()->setVertical('top');

              // Rótulo do número da página
              $sheet->cell('AD1', function($cell) {
                  $cell->setValue("PÁG.\n1");
              });
              $sheet->getStyle('AD1')->getAlignment()->setWrapText(true);
              $sheet->getStyle('AD1')->getAlignment()->setHorizontal('center');
              $sheet->getStyle('AD1')->getAlignment()->setVertical('top');

              // Rótulo do número da página
              $sheet->cell('AD3', function($cell) {
                  $cell->setValue("C.H. DADA");
              });
              $sheet->getStyle('AD3')->getAlignment()->setVertical('top');

              $celulaInicialData = "E";

              // Preenche as cédulas com as datas
              foreach($datas as $data)
              {
                  $sheet->cell($celulaInicialData . '2', function($cell) use ($data) {
                      $cell->setValue($data->day . "/" . $data->month);
                  });

                  // Verifica se chegou na divisão das cédulas
                  if($celulaInicialData == "Z") $celulaInicialData = "AA";
                  else ++$celulaInicialData;
              }

              // Cabeçalho da tabela
              $cabecalhoTabela = ["ORD", "MATRÍCULA", "NOME ALUNO(A)", "CURSO", "CONTROLE DE FREQUÊNCIA"];
              $sheet->row(4, $cabecalhoTabela);


              // Adiciona o rótulo com o total de faltas, a coluna AD terá o total de faltas de cada aluno
              $sheet->cell('AD4', function($cell) {
                  $cell->setValue("TOTAL");
              });

              // Mescla as cédulas de cabeçalho do texto "CONTROLE DE FREQUÊNCIA"
              $sheet->mergeCells('E4:AC4');
              $sheet->getStyle('E4')->getAlignment()->setHorizontal('center');

              $contador = 1; // Contador para ser usado como parâmetro no valor da coluna ORD

              // Todas as faltas da turma
              $faltas = $turma->faltas;

              // Adicionando dados
              $matriculados = $turma->matriculados()->getResults();
              foreach ($matriculados as $matriculado)
              {
                  $dados = [$contador, $matriculado->aluno->matricula, strtoupper($matriculado->aluno->nome), $matriculado->aluno->grupo_nome];

                  $colunaTotalFaltasDoAluno = "AD" . strval($contador + 4);

                  // Define o valor da cédula que informa a quantidade de faltas do aluno
                  $alunoFaltas = $faltas->where("aluno_id", $matriculado->aluno_id);
                  $sheet->cell($colunaTotalFaltasDoAluno , function($cell) use($alunoFaltas) {
                      $cell->setValue($alunoFaltas->count());
                  });

                  // Array que terá todas as presenças e faltas de cada dia do aluno
                  $frequencia = array();

                  // Itera sobre todas as datas e verfica se o aluno faltou naquela data
                  foreach($datas as $data)
                  {
                      if($alunoFaltas->contains('data', $data->toDateString())) $frequencia[] = 'A';
                      else $frequencia[] = 'P';
                  }

                  // Concatena a frequência do aluno com os dados do mesmo, pois serão inseridos na planilha juntos
                  $dados = array_merge($dados, $frequencia);

                  $sheet->row($contador + 4, $dados);
                  ++$contador;
              }

              // Inserir rodapé da planilha
              $linhaRodape = $contador + 5;
              $sheet->cell("A" . strval($linhaRodape), function($cell) {
                  $cell->setValue("PROFESSOR\n" . strtoupper(auth()->user()->nome));
              });
              $sheet->getStyle('A' . strval($linhaRodape))->getAlignment()->setWrapText(true);
              $sheet->mergeCells('A' . strval($linhaRodape) . ':C' . ($linhaRodape));
              $sheet->getStyle('A' . strval($linhaRodape))->getAlignment()->setVertical('top');

              $sheet->cell("D" . strval($linhaRodape), function($cell) {
                  $cell->setValue("ASS. PROFESSOR");
                  $cell->setValignment('top');
              });

              $sheet->setHeight($linhaRodape, 40);
              $sheet->setHeight(++$linhaRodape, 40);

              $sheet->cell("A" . strval($linhaRodape), function($cell) {
                  $cell->setValue("DATA ENTREGA");
              });
              $sheet->mergeCells('A' . strval($linhaRodape) . ':B' . ($linhaRodape));

              $sheet->cell("C" . strval($linhaRodape), function($cell) {
                  $cell->setValue("DATA DO PARECER");
              });

              $sheet->cell("D" . strval($linhaRodape), function($cell) {
                  $cell->setValue("ASS. CHEFE DEPTO");
              });

              $sheet->cells('A' . $linhaRodape . ':D' . $linhaRodape, function($cells) {
                  $cells->setValignment('top');
              });

              $textoRodape = "LISTAGEM SUJEITA A ALTERAÇÕES DEVIDO A REQUERIMENTOS EM ANDAMENTO. INSTRUÇÕES PARA PREENCHIMENTO: A CHAMADA ORAL É OBRIGATÓRIA. IDENTIFIQUE O TIPO DE AULA COM T=TEÓRICA E P=PRÁTICA. CADA AULA CORRESPONDE A UMA MARCAÇÃO. A PRÓ-REITORIA DE GRADUAÇÃO SOMENTE RECONHECE COMO ALUNO MATRICULADO AQUELE CUJO NOME CONSTA NESTE DIÁRO.";

              $sheet->cell("E" . strval(--$linhaRodape), function($cell) use($textoRodape) {
                  $cell->setValue($textoRodape);
              });

              $sheet->mergeCells('E' . strval($linhaRodape) . ':AD' . ($linhaRodape + 1));
              $sheet->getStyle('E' . strval($linhaRodape))->getAlignment()->setWrapText(true);
              $sheet->getStyle('E' . strval($linhaRodape))->getAlignment()->setVertical('top');
          });

      });

      return $teste->export("xls");
  }

  /**
  * Renderiza a view para gerenciar as faltas de uma turma.
  * @param GerenciarFaltaRequest $request Requisição com campos do formulário já validados
  */
  public function manage(GerenciarFaltaRequest $request)
  {
      $form = $request->all();
      $turma = Turma::find($form['turma']);

      if(auth()->user()->can('manipular_turma', $turma))
      {
          $datas = array(); // Array com as datas que poderão ser manipuladas

          // Obtém o intervalo de dias de acorco com a opção escolhida
          if($form['opcao'] == 'dia') $datas[0] = $form['dataInicial'];
          else
          {
              $dataCorrente = Carbon::createFromFormat('d/m/Y', $form['dataInicial']);
              $dataFinal = Carbon::createFromFormat('d/m/Y', $form['dataFinal']);

              while($dataCorrente <= $dataFinal)
              {
                  if(isset($form['dias']) && in_array($dataCorrente->dayOfWeek, $form['dias']))
                      $datas[] = $dataCorrente->format('d/m/Y');
                  else if(!isset($form['dias']))
                      $datas[] = $dataCorrente->format('d/m/Y');

                  $dataCorrente = $dataCorrente->addDay();
              }
          }

          $faltas = Falta::where('turma_id', $form['turma'])->get();
          $matriculados = Matriculado::with('aluno')->where('turma_id', $form['turma'])->get();

          return view('falta.manage')->with(['datas' => $datas, 'faltas' => $faltas, 'matriculados' => $matriculados, 'turma' => $turma]);
      }
      else return abort(403);
  }

  /**
  * Atualiza as faltas
  * @param AtualizarFaltaRequest $request
  * @return \Illuminate\Http\RedirectResponse
  */
  public function update(AtualizarFaltaRequest $request)
  {
    $form = $request->all();

    $matriculados = array_keys($form['falta']); // Obtém a lista de alunos

    foreach ($matriculados as $matriculado) // Para cada aluno
    {
      $datas = array_keys($form['falta'][$matriculado]); // Obtém a lista de datas

      foreach ($datas as $data) // Para cada data
      {
        try
        {
          // Se o conteúdo do array na posição do aluno em uma data for igual a 'falta', significa que ele faltou naquele dia
          if($form['falta'][$matriculado][$data] == "falta")
          {
            Falta::updateOrCreate([
              'aluno_id' => $matriculado,
              'turma_id' => $form['turma'],
              'data' => Carbon::createFromFormat('d/m/Y', $data)->format('Y-m-d')
            ]);
          }
          else // Senão é uma presença e se a falta existir nessa data, ela deve ser excluída
          {
            DB::table('faltas')->where('turma_id', $form['turma'])->where('aluno_id', $matriculado)->where('data', Carbon::createFromFormat('d/m/Y', $data)->format('Y-m-d'))->delete();
          }
        }
        catch (\Exception $ex)
        {
          session()->flash('tipo', 'error');
          session()->flash('mensagem', 'Erro ao atualizar faltas: ' . $ex->getMessage());

          return back();
        }

      }
    }

    session()->flash('tipo', 'success');
    session()->flash('mensagem', 'Faltas atualizadas com sucesso.');

    return redirect()->route('visualizarFaltas', $form['turma']);
  }





  public function criarJustificativa(CreateJustificativaRequest $request)
  {
    $form = $request->all();
    $aluno = Usuario::find($form['turma']);
    $turma = Turma::find($form['turma']);
    $falta = Encarregado::find($form['encarregado']);

    if(auth()->user()->can('', $turma))
    {
      $datas = array(); // Array com as datas que poderão ser manipuladas

      // Obtém o intervalo de dias de acorco com a opção escolhida
      if($form['opcao'] == 'dia') $datas[0] = $form['dataInicial'];
      else
      {
        $dataCorrente = Carbon::createFromFormat('d/m/Y', $form['dataInicial']);
        $dataFinal = Carbon::createFromFormat('d/m/Y', $form['dataFinal']);

        while($dataCorrente <= $dataFinal)
        {
          $datas[] = $dataCorrente->format('d/m/Y');
          $dataCorrente = $dataCorrente->addDay();
        }
      }

      $faltas = Falta::where('turma_id', $form['turma'])->get();
      $matriculados = Matriculado::with('aluno')->where('turma_id', $form['turma'])->get();

      return view('falta.manage')->with(['datas' => $datas, 'faltas' => $faltas, 'matriculados' => $matriculados, 'turma' => $turma]);
    }
    else return abort(403);
  }

}
