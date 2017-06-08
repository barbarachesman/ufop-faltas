<?php $__env->startSection('titulo'); ?>
    Anexar Atestado
<?php $__env->stopSection(); ?>

<?php $__env->startSection('descricao'); ?>
    Escolha o arquivo .pdf que contenha o atestado
<?php $__env->stopSection(); ?>

<?php $__env->startPush('extra-scripts'); ?>

<?php echo HTML::script('js/plugins/jQueryUI/jquery-ui.min.js'); ?>

<?php echo HTML::script('js/plugins/jQueryUI/datepicker-pt-BR.js'); ?>

<script>
    submitModal = function(){
        $('#loadingModal').modal({backdrop: 'static', keyboard: false});
        document.forms['importaratestado'].submit();
    }
</script>

<script>
    $(".datepicker").datepicker($.datepicker.regional['pt-BR']);
</script>
<?php $__env->stopPush(); ?>


<?php $__env->startPush('extra-css'); ?>
<?php echo HTML::style('js/plugins/jQueryUI/jquery-ui.min.css'); ?>

<?php $__env->stopPush(); ?>


<?php $__env->startSection('conteudo'); ?>
    <div class="row">
        <div class='col-md-12'>
            <div class="box box-primary-ufop">
                <div class="box-body">
                    <form id="importaratestado" class="form-horizontal" method="POST" action="<?php echo e(route('abonarFalta')); ?>" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>

                        <div class="form-group <?php echo e($errors->has('file') || $errors->has('disciplina') ? 'has-error' : ''); ?>">
                            <label for="file" class="col-sm-2 control-label">Selecione o arquivo que deseja anexar</label>
                            <div class="col-sm-10">
                                <input type="file" class="form-control" id="file" name="file" >
                                <?php if($errors->has('file') || $errors->has('disciplina')): ?>
                                    <p class="text-help text-danger">
                                        <?php if($errors->has('file')): ?>
                                            <?php echo $errors->first('file'); ?>

                                        <?php else: ?>
                                            <?php echo $errors->first('disciplina'); ?>

                                        <?php endif; ?>
                                    </p>
                                <?php endif; ?>
                            </div>
                            <label for="file" class="col-sm-2 control-label">Observação</label>
                              <div class="col-sm-10">
                                <textarea name="comment" cols='75' rows='3' name='texto' maxlength="250">Deixe aqui um comentário para o professor, se necessário...</textarea>
                              </div>
                            <label for="file" class="col-sm-2 control-label">Selecione aquela referente ao abono anexado</label>
                            <div class="col-sm-10">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                  <input type="text" style="width:430px;font-size: 13px"  value="<?php echo e(old('dataFalta')); ?>" minlength="10" maxlength="10" class="form-control datepicker" name="dataFalta" title="Dia inicial do intervalo" placeholder="Dia da falta no formato dd/mm/aaaa" required>
                            </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="text-center">
                                <button type="button" onclick="submitModal();" class="btn btn-success"><i class="fa fa-upload"></i> Anexar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="loadingModal" tabindex="-1" role="dialog" aria-labelledby="loadingModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title text-center">Aguarde</h4>
                </div>
                <div class="modal-body text-center">
                    <img src="<?php echo e(asset('img/bigloading.gif')); ?>" />
                    <br />
                    Validando as informações dos alunos e realizando a importação.
                    <br />
                    Isso pode levar algum tempo de acordo com o tamanho da turma.
                    <br />
                    Não feche nem recarregue a página durante a importação.

                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>