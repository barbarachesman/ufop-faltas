<?php $__env->startSection('titulo'); ?>
    Erro 404
<?php $__env->stopSection(); ?>

<?php $__env->startSection('conteudo'); ?>
    <div class="row">
        <div class="error-page">
            <h2 class="headline text-yellow">404</h2>
            <br />
            <div class="error-content">
                <h3><i class="fa fa-warning text-yellow"></i> Opa! Página não encontrada.</h3>

                <p>
                    A página que você requisitou não existe.
                    Você pode voltar para a página <a href="<?php echo e(url('/')); ?>">inicial</a> ou voltar para a página <a href="javascript:history.back()">anterior</a> em que você estava.
                </p>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>