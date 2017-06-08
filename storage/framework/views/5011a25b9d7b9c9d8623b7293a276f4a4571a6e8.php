<?php $__env->startSection('titulo'); ?>
    Diário de Classe da turma <?php echo e($turma->codigo); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('descricao'); ?>
    Essa é a lista de chamada da disciplina <?php echo e($turma->disciplina->nome); ?>

<?php $__env->stopSection(); ?>


<?php $__env->startSection('mapa'); ?>
    <li><i class="fa fa-users"></i> Turmas</li>
    <li><i class="fa fa-search-plus"></i> Detalhes</li>
    <li><i class="fa fa-calendar"></i> Faltas</li>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('extra-css'); ?>
<?php echo HTML::style('js/plugins/datatables/dataTables.bootstrap.css'); ?>

<?php $__env->stopPush(); ?>

<?php $__env->startPush('extra-scripts'); ?>
<?php echo HTML::script('js/plugins/datatables/jquery.dataTables.min.js'); ?>

<?php echo HTML::script('js/plugins/datatables/dataTables.bootstrap.min.js'); ?>

<script>
    $(document).ready(function () {
        $("#table").DataTable( {
            "bSort" : false,
            "language": {
                "lengthMenu": "Mostrar _MENU_ registros por página",
                "zeroRecords": "Nada encontrado.",
                "info": "Mostrando página _PAGE_ de _PAGES_",
                "infoEmpty": "Nenhum registro disponível",
                "infoFiltered": "(Filtrado de _MAX_ registros)",
                "search": "Procurar:",
                "paginate": {
                    "next": "Próximo",
                    "previous": "Anterior"
                }
            },
            "autoWidth" : true,
            "aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Tudo"]]
        });
    });
</script>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('conteudo'); ?>
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary-ufop">
                <div class="box-body">
                    <?php if($faltas->isEmpty()): ?>
                        <h3 class="text-center">Nenhuma falta registrada para essa turma</h3>
                    <?php else: ?>
                        <table id="table" class="table table-bordered table-striped table-responsive table-hover text-center">
                            <thead>
                            <tr>
                            <?php if(!auth()->user()->isAluno()): ?>
                                <th>Matrícula</th>

                                <th>Aluno</th>

                                <?php $__currentLoopData = $faltas->keys(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                                    <th><?php echo e(\Carbon\Carbon::createFromFormat('Y-m-d', $data)->format('d/m/Y')); ?></th>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
                                <?php endif; ?>
                            </tr>

                            </thead>

                            <tbody>
                            <?php $__currentLoopData = $matriculados; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $matriculado): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                                <tr>
                                <?php if(!auth()->user()->isAluno()): ?>
                                    <td><?php echo $matriculado->aluno->matricula ? $matriculado->aluno->matricula : 'Desconhecida'; ?></td>

                                      <td><?php echo $matriculado->aluno->nome; ?></td>
                                      <?php endif; ?>
                                      <?php if(auth()->user()->isAluno() and auth()->user()->id == $matriculado->aluno_id): ?>
                                      <tr>
                                      <?php $__currentLoopData = $faltas->keys(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                                        <th><?php echo e(\Carbon\Carbon::createFromFormat('Y-m-d', $data)->format('d/m/Y')); ?></th>
                                          <td>
                                              <?php $presenca = true; ?>
                                              <?php $__currentLoopData = $faltas[$data]->values(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $falta): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                                                  <?php if($falta->aluno->id == $matriculado->aluno_id and (auth()->user()->isAluno() and auth()->user()->id == $matriculado->aluno_id)): ?>
                                                      <span class="text-danger text-bold"><i class="fa fa-times"></i> Ausente</span>
                                                      <?php $presenca = false; ?>
                                                      <?php break; ?>
                                                  <?php endif; ?>
                                              <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
                                              <?php if($presenca and (auth()->user()->isAluno() and auth()->user()->id == $matriculado->aluno_id)): ?>
                                                  <span class="text-success text-bold"><i class="fa fa-check"></i> Presente</span>
                                              <?php endif; ?>
                                          </td>


                                      </tr>
                                      <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
                                    </tr>

                                      <?php endif; ?>
                                        <?php if(!auth()->user()->isAluno()): ?>
                                              <?php $__currentLoopData = $faltas->keys(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                                                  <td>
                                                      <?php $presenca = true; ?>
                                                      <?php $__currentLoopData = $faltas[$data]->values(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $falta): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                                                          <?php if($falta->aluno->id == $matriculado->aluno_id ): ?>
                                                              <span class="text-danger text-bold"><i class="fa fa-times"></i> Ausente</span>
                                                              <?php $presenca = false; ?>
                                                              <?php break; ?>
                                                          <?php endif; ?>
                                                      <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
                                                      <?php if($presenca): ?>
                                                          <span class="text-success text-bold"><i class="fa fa-check"></i> Presente</span>
                                                      <?php endif; ?>
                                                  </td>
                                              <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
                                              <?php endif; ?>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
                            </tbody>
                            <td>
                              <?php $qtde = DB::table('faltas')->where('aluno_id', $matriculado->aluno->id)->where('turma_id', $turma->id)->count();?>
                                <?php echo $qtde; ?>

                            </td>
                        </table>
                    <?php endif; ?>
                    <div class="text-center">
                        <button type="button" class="btn btn-warning" onclick="history.back()"><i class="fa fa-arrow-left"></i> Voltar</button>
                        <a href="<?php echo e(url('download')); ?>"><button type="button" class="btn btn-info btn-sm pull-right">Download PDF</button></a>

                        <?php if (app('Illuminate\Contracts\Auth\Access\Gate')->check('manipular_turma', $turma)): ?>
                            <a class="btn btn-ufop" role="button" href="<?php echo e(route('selecionarFaltas', $turma->id)); ?>">
                                <i class="fa fa-pencil-square-o"></i> Gerenciar faltas
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>