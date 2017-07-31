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
    <li><i class="fa fa-pencil-square-o"></i> Gerenciar</li>
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
            "aLengthMenu": [[-1], ["Tudo"]]
        });
    });
</script>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('conteudo'); ?>
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary-ufop">
                <div class="box-body">
                    <form action="<?php echo e(route('atualizarFaltas')); ?>" method="post">
                        <?php echo e(csrf_field()); ?>

                        <input type="hidden" name="turma" value="<?php echo e($turma->id); ?>">

                        <div class="form-group text-center">
                            <button type="button" onclick="history.back()" class="btn btn-ufop"><i class="fa fa-arrow-left"></i> Voltar</button>
                            <button type="reset" class="btn btn-warning"><i class="fa fa-repeat"></i> Resetar</button>
                            <button type="submit" class="btn btn-success"><i class="fa fa-check"></i> Aplicar</button>
                        </div>

                        <div class="table table-responsive">
                            <table id="table" class="table table-bordered table-striped table-responsive table-hover text-center">
                                <thead>
                                <tr>
                                    <th>Matrícula</th>
                                    <th>Aluno</th>
                                    <?php $__currentLoopData = $datas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                                        <th><?php echo $data; ?></th>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $__currentLoopData = $matriculados; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $matriculado): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                                    <tr>
                                        <td><?php echo $matriculado->aluno->matricula; ?></td>
                                        <td><?php echo $matriculado->aluno->nome; ?></td>
                                        <?php $__currentLoopData = $datas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                                            <td>
                                                <?php 
                                                    $presenca = true;
                                                    foreach ($faltas as $falta)
                                                    {
                                                        if($falta->aluno_id == $matriculado->aluno_id && \Carbon\Carbon::createFromFormat('d/m/Y', $data)->format('Y-m-d') == $falta->data)
                                                        {
                                                            $presenca = false;
                                                            break;
                                                        }
                                                    }
                                                 ?>

                                                <label class="radio-inline">
                                                    <input type="radio" name="falta[<?php echo e($matriculado->aluno->id); ?>][<?php echo e($data); ?>]" value="presenca" <?php echo e($presenca ? 'checked' : ''); ?>>
                                                    Presente
                                                </label>

                                                <label class="radio-inline">
                                                    <input type="radio" name="falta[<?php echo e($matriculado->aluno->id); ?>][<?php echo e($data); ?>]" value="falta" <?php echo e(!$presenca ? 'checked' : ''); ?>>
                                                    Ausente
                                                </label>
                                            </td>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
                                </tbody>
                            </table>
                        </div>


                        <div class="form-group text-center">
                            <button type="button" onclick="history.back()" class="btn btn-ufop"><i class="fa fa-arrow-left"></i> Voltar</button>
                            <button type="reset" class="btn btn-warning"><i class="fa fa-repeat"></i> Resetar</button>
                            <button type="submit" class="btn btn-success"><i class="fa fa-check"></i> Aplicar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>