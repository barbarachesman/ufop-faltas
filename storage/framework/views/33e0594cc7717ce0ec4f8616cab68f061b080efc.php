<?php $__env->startSection('titulo'); ?>
    Seleção das datas
<?php $__env->stopSection(); ?>

<?php $__env->startSection('descricao'); ?>
    Selecione as datas que deseja gerenciar as faltas da turma <?php echo e($turma->codigo); ?> da disciplina <?php echo e($turma->disciplina->nome); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('mapa'); ?>
    <li><i class="fa fa-users"></i> Turmas</li>
    <li><i class="fa fa-calendar"></i> Faltas</li>
    <li><i class="fa fa-hand-o-up"></i> Selecionar data(s)</li>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('extra-css'); ?>
<?php echo HTML::style('js/plugins/jQueryUI/jquery-ui.min.css'); ?>

<?php $__env->stopPush(); ?>

<?php $__env->startPush('extra-scripts'); ?>
<?php echo HTML::script('js/plugins/jQueryUI/jquery-ui.min.js'); ?>

<?php echo HTML::script('js/plugins/jQueryUI/datepicker-pt-BR.js'); ?>


<script>
    $(".datepicker").datepicker($.datepicker.regional['pt-BR']);
</script>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('conteudo'); ?>
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary-ufop">
                <div class="box-body">
                    <form class="text-center" action="<?php echo e(route('gerenciarFaltas')); ?>" method="post">
                        <?php echo e(csrf_field()); ?>

                        <input type="hidden" name="turma" value="<?php echo e($turma->id); ?>" required>

                        <div class="form-group <?php echo e($errors->has('diaInicial') ? 'has-error' : ''); ?>">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                <input type="text" value="<?php echo e(old('dataInicial')); ?>" minlength="10" maxlength="10" class="form-control datepicker" name="dataInicial" title="Dia inicial do intervalo" placeholder="Dia inicial do intervalo no formato dd/mm/aaaa" required>
                            </div>
                            <?php if($errors->has('dataInicial')): ?>
                                <div class="help-block">
                                    <?php echo $errors->first('dataInicial'); ?>

                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="form-group" <?php echo e($errors->has('dataFinal') ? 'has-error' : ''); ?>>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                <input type="text" value="<?php echo e(old('dataFinal')); ?>" minlength="10" maxlength="10" class="form-control datepicker" name="dataFinal" title="Dia final do intervalo" placeholder="Dia final do intervalo no formato dd/mm/aaaa">
                            </div>
                            <?php if($errors->has('dataFinal')): ?>
                                <div class="help-block">
                                    <?php echo $errors->first('dataFinal'); ?>

                                </div>
                            <?php endif; ?>
                        </div>

                        <label for="dia" class="radio-inline">
                            <input id="dia" type="radio" name="opcao" value="dia">
                            Somente um dia
                        </label>

                        <label for="intervalo" class="radio-inline">
                            <input type="radio" id="intervalo" name="opcao" value="intervalo" checked>
                            Intervalo
                        </label>

                        <?php if($errors->has('opcao')): ?>
                            <div class="help-block has-error">
                                <?php echo e($errors->first('opcao')); ?>

                            </div>
                        <?php endif; ?>

                        <div class="help-block">
                            <p class="text-center">
                                Se você selecionar apenas um dia, não é necessário preencher a segunda entrada relativa ao dia final do intervalo
                            </p>
                        </div>

                        <div class="form-group text-center">
                            <button type="button" class="btn btn-ufop" onclick="history.back()"><i class="fa fa-arrow-left"></i> Voltar</button>
                            <button type="reset" class="btn btn-warning"><i class="fa fa-eraser"></i> Limpar</button>
                            <button type="submit" class="btn btn-success"><i class="fa fa-check"></i> Selecionar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>