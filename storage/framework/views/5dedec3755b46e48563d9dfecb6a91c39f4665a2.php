<?php $__env->startSection('titulo'); ?>
    Início
<?php $__env->stopSection(); ?>

<?php $__env->startSection('descricao'); ?>
    Bem-vindo <?php echo auth()->user()->nome; ?>, você está na página inicial.
<?php $__env->stopSection(); ?>

<?php $__env->startSection('conteudo'); ?>

<h4>Um ambiente virtual de controle de faltas para auxílio aos alunos e professores dos cursos de graduação presencial da UFOP.</h4>

<!-- Calendar -->

<!-- Main content -->
<section class="content">
<!-- Small boxes (Stat box) -->
<div class="row">
<?php $__currentLoopData = $turmas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vinculo): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
<?php $aluno = auth()->user()->id?>
<?php $qtde = DB::table('faltas')->where('aluno_id', $aluno)->where('turma_id', $vinculo->turma->id)->count();?>
<!-- ./col -->
<div class="col-lg-3 col-xs-6">
<!-- small box -->
<?php if($qtde <= 18): ?>
<div class="small-box bg-gray">
<?php endif; ?>
<?php if($qtde > 18): ?>
<div class="small-box bg-ufop">
<?php endif; ?>
<div class="inner">
  <p><b><?php echo $vinculo->turma->disciplina->nome; ?></b>
    <br>
  <p>Turma:
    <?php echo $vinculo->turma->codigo; ?><br>
  <p>Período:
    <?php echo $vinculo->turma->periodo->ano; ?>.<?php echo $vinculo->turma->periodo->periodo; ?><br>
  <p>Situação:
    <?php if($qtde <= 18): ?>
    Aprovado
    <?php endif; ?>
    <?php if($qtde > 18): ?>
    Reprovado
    <?php endif; ?>
    <p>Faltas:
      <?php echo $qtde; ?>


</div>
<div class="icon">
  <i class="ion ion-pie-graph"></i>
</div>
<a href="<?php echo e(route('visualizarFaltas', $vinculo->turma->id)); ?>" class="small-box-footer" role="button">
    <i class="fa fa-calendar"></i> Visualizar diário
</a>
</div>
</div>
<!-- ./col -->
<?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>