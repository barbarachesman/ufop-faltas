<style type="text/css">
table td, table th{
	border:1px solid black;
}
</style>
<div class="container">


	<div class="row">
		<div class="col-md-12">
			<div class="box box-primary-ufop">
				<div >
					@if($faltas->isEmpty())
					<h3 class="text-center">Nenhuma falta registrada para essa turma</h3>
					@else
					<table id="table"style="font-family:arial;font-size:	10px;">

						<tbody>
							<th style="width:0.5px;">ORD</th>
							<th style="width:2px;">MATRÍCULA</th>
							<th colspan="3">NOME ALUNO(A)</th>

							<th colspan="0.5">TOTAL</th>
							@foreach($matriculados as $matriculado)

							<tr>

								@if(!auth()->user()->isAluno())
								<td>
									<?php $ord = 1; ?>
									{!! $ord++ !!}
								</td>
								<td style="width:5px;">{!! $matriculado->aluno->matricula ? $matriculado->aluno->matricula : 'Desconhecida' !!}</td>

								<td>{!! $matriculado->aluno->nome !!}</td>
								@endif
								<td>
									<?php $qtde = DB::table('faltas')->where('aluno_id', $matriculado->aluno->id)->where('turma_id', $turma->id)->count();?>
									{!! $qtde !!}
								</td>
							</tr>

							@endforeach
						</tbody>

						<table border="1" >
							<tr><td rowspan="3">PROFESSOR: </td>  <td>LISTAGEM SUJEITA A ALTERAÇÕES DEVIDO A REQUERIMENTOS EM ANDAMENTO. INSTRUÇÕES PARA PREENCHIMENTO: A CHAMADA ORAL É OBRIGATÓRIA. IDENTIFIQUE O TIPO DE AULA COM T=TEÓRICA E P=PRÁTICA. CADA AULA CORRESPONDE A UMA MARCAÇÃO. A PRÓ-REITORIA DE GRADUAÇÃO SOMENTE RECONHECE COMO ALUNO MATRICULADO AQUELE CUJO NOME CONSTA NESTE DIÁRIO.</td></tr>
								<tr> <td>DATA</td> <td> ASS. PROFESSOR</td> <td>DATA</td> <td> ASS. CHEFE DEPTO</td> </tr>

							</table>




						</table>

						@endif

					</div>
				</div>
			</div>
		</div>


	</div>
