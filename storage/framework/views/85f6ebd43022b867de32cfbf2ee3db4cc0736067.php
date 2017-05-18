<?php $__env->startSection('titulo'); ?>
    Detalhes Turma <?php echo $turma->disciplina->codigo; ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('descricao'); ?>
    Essa é a lista com os alunos matriculados na turma <?php echo $turma->codigo; ?> da disciplina <?php echo e($turma->disciplina->nome); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('mapa'); ?>
    <li><i class="fa fa-users"></i> Turmas</li>
    <li><i class="fa fa-search-plus"></i> Detalhes</li>
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
                <div class="box-header"><h3 class="box-title">Atualmente <?php echo e($alunos->count()); ?> alunos estão matriculados</h3></div>
                <div class="box-body">
                    <div class="table">
                        <table id="table" class="table table-bordered table-hover table-responsive table-striped text-center">
                            <thead>
                            <tr>
                                <th>Aluno</th>
                                <th>E-mail</th>
                                <th>Curso</th>
                                <th>Ação</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $__currentLoopData = $alunos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $matriculado): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                                <tr>
                                    <td><?php echo $matriculado->aluno->nome; ?></td>
                                    <td><?php echo $matriculado->aluno->email; ?></td>
                                    <td><?php echo $matriculado->aluno->grupo_nome; ?></td>
                                    <td>
                                        <a href="<?php echo e(route('desmatricularAluno', [$matriculado->aluno->id, $turma->id])); ?>" class="btn btn-danger btn-xs" role="button"><i class="fa fa-times"></i> Desmatricular</a>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
                            </tbody>
                            <tfoot>
                            <tr>
                                <th>Aluno</th>
                                <th>E-mail</th>
                                <th>Curso</th>
                                <th>Ação</th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>

                    <br />

                    <div class="text-center">
                        <a class="btn btn-ufop" role="button" href="<?php echo e(route('visualizarFaltas', $turma->id)); ?>"><i class="fa fa-search"></i> Visualizar Faltas</a>
                        <?php if(!$turma->finalizada): ?>
                            <a class="btn bg-black" role="button" href="<?php echo e(route('finalizarTurma', $turma->id)); ?>"><i class="fa fa-lock"></i> Finalizar Turma</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>