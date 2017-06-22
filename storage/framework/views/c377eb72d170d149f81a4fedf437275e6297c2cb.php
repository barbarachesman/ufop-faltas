<?php $__env->startSection('titulo'); ?>
    Minhas Turmas
<?php $__env->stopSection(); ?>

<?php $__env->startSection('descricao'); ?>
    Essa é a lista com todas as turmas as quais você está matriculado.    
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
                    <div class="table">
                        <table id="table" class="table table-bordered table-hover table-responsive table-striped text-center">
                            <thead>
                            <tr>
                                <th>Código da Disciplina</th>
                                <th>Disciplina</th>
                                <th>Turma</th>
                                <th>Ano</th>
                                <th>Período</th>
                                <th>Status</th>
                                <?php if(auth()->user()->isAluno()): ?>
                                <th>Faltas</th>
                                <?php endif; ?>
                                <th>Ação</th>

                            </tr>
                            </thead>
                            <tbody>
                            <?php $__currentLoopData = $turmas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vinculo): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                                <tr>
                                    <td><?php echo $vinculo->turma->disciplina->codigo; ?></td>
                                    <td><?php echo $vinculo->turma->disciplina->nome; ?></td>
                                    <td><?php echo $vinculo->turma->codigo; ?></td>
                                    <td><?php echo $vinculo->turma->periodo->ano; ?></td>
                                    <td><?php echo $vinculo->turma->periodo->periodo; ?></td>
                                    <td>
                                    <span class="text-bold
                                    <?php if($vinculo->turma->finalizada): ?>
                                            text-danger">Finalizada
                                        <?php else: ?>
                                            text-success">Ativa
                                        <?php endif; ?>
                                    </span>

                                    </td>

                                    <td>
                                      <?php $aluno = auth()->user()->id?>
                                      <?php $qtde = DB::table('faltas')->where('aluno_id', $aluno)->where('turma_id', $vinculo->turma->id)->count();?>
                                        <?php echo $qtde; ?>

                                    </td>
                                    <td>
                                        <?php if(!auth()->user()->isAluno()): ?>
                                            <a href="<?php echo e(route('detalheTurma', $vinculo->turma->id)); ?>" class="btn btn-ufop btn-xs" role="button">
                                                <i class="fa fa-search-plus"></i> Detalhes
                                            </a>

                                            <a href="<?php echo e(route('atualizarTurma', $vinculo->turma->id)); ?>" class="btn btn-ufop btn-xs" role="button">
                                                <i class="fa fa-search-plus"></i> Atualizar
                                            </a>
                                        <?php endif; ?>
                                        <a href="<?php echo e(route('visualizarFaltas', $vinculo->turma->id)); ?>" class="btn btn-ufop btn-xs" role="button">
                                            <i class="fa fa-calendar"></i> Visualizar diário
                                        </a>
                                    </td>
                                </tr>

                            <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>