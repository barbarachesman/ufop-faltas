<style type="text/css">

</style>
<div class="container">


    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary-ufop">
                <div >
                    @if($faltas->isEmpty())
                    <h3 class="text-center">Nenhuma falta registrada para essa turma</h3>
                    @else

                    <table id="table" style="font-family:arial;font-size:	10px;" width='100%' border="0">

                        <thead style="position=fixed;">
                            <tr><tr>
                                <td colspan="3"><br><br><br><br>UFOP - UNIVERSIDADE FEDERAL DE OURO PRETO<br>DECSI - DEPARTAMENTO DE COMPUTACAO E SISTEMAS<br><br>
                                    DIÁRIO DE CLASSE 2017/1<br><br><br><br><br><br></td>

                                <td colspan="3">{{ $turma->disciplina->codigo }} - {{ $turma->disciplina->nome }}&nbsp;
                                    <table border="0">
                                        <tr>
                                            <td colspan="3"> </td>
                                        </tr>
                                        <tr>
                                            <td colspan="3"> </td>
                                        </tr>

                                    </table>

                                </td>  </td>
                            </tr>
                        </thead>

                    <tbody>
                        <tr>
                            <th style="width:2px;">MATRÍCULA</th>
                            <th colspan="3">NOME ALUNO(A)</th>

                            <th style="width:0.5px;">TOTAL</th></tr><?php $counter = 0;?>
                        @foreach($matriculados as $matriculado)


                        <tr>

                            @if(!auth()->user()->isAluno())
                            <td style="width:5px;">{!! $matriculado->aluno->matricula ? $matriculado->aluno->matricula : 'Desconhecida' !!}</td>

                            <td colspan="3">{!! $matriculado->aluno->nome !!}</td>
                            @endif
                            <td>
                                <?php
                                $qtde = DB::table('faltas')->where('aluno_id', $matriculado->aluno->id)->where('turma_id', $turma->id)->count();?>
                                {!! $qtde !!}
                            </td>

                        </tr>

                        @endforeach
                    </tbody>
                    </table>

                    @endif

										<table width='100%' style="font-family:arial;font-size:	10px;" width='100%' border="0">

												<tr>

														<td width='40%'>
																PROFESSOR&nbsp; {!! auth()->user()->nome !!}<br>
																<table border='0' width='100%'>

																		<tr>
																				<td>DATA</td>
																				<td> ASS. PROFESSOR</td>
																				<td>DATA</td>
																				<td> ASS. CHEFE DEPTO</td>
																		</tr>

																		<td>&nbsp; </td>
																		<td> &nbsp; </td>
																		<td>&nbsp;</td>
																		<td> &nbsp;</td>

												</tr>


										</table>

										</td>


										<td rowspan='2' width='60%'>LISTAGEM SUJEITA A ALTERAÇÕES DEVIDO A REQUERIMENTOS EM ANDAMENTO. INSTRUÇÕES PARA PREENCHIMENTO: A CHAMADA ORAL É OBRIGATÓRIA. IDENTIFIQUE O TIPO DE AULA COM T=TEÓRICA E P=PRÁTICA. CADA AULA CORRESPONDE A UMA MARCAÇÃO. A PRÓ-REITORIA DE GRADUAÇÃO SOMENTE RECONHECE COMO ALUNO MATRICULADO AQUELE CUJO NOME CONSTA NESTE DIÁRIO.
										</td>

										</tr>

								</table>

                </div>
            </div>
        </div>
    </div>


</div>
