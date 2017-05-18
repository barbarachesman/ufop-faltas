<!DOCTYPE html>
<html lang="pt">
<head>
    <title><?php echo config('app.name'); ?> - <?php echo $__env->yieldContent('titulo'); ?></title>
    <meta charset="UTF-8">
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <?php echo HTML::style('css/bootstrap/bootstrap.min.css'); ?>

    <?php echo HTML::style('css/font-awesome/font-awesome.min.css'); ?>

    <?php echo HTML::style('css/app.css'); ?>


    <?php echo $__env->yieldPushContent('extra-css'); ?>

    <?php echo HTML::favicon('favicon.ico'); ?>

    <link rel="icon" href="<?php echo e(asset('favicon.ico')); ?>" type="image/x-icon">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
</head>
<body class="skin-ufop hold-transition sidebar-mini <?php if(!Auth::check()): ?> guest <?php endif; ?>">

<div class="wrapper">

    <?php echo $__env->make('layout.cabecalho', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

    <?php echo $__env->make('layout.menulateral', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

    <div class="content-wrapper">

        <section class="content-header">
            <h1><?php echo $__env->yieldContent('titulo'); ?>
                <small><?php echo $__env->yieldContent('descricao'); ?></small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="<?php echo e(route('home')); ?>"><i class="fa fa-home"></i> Início</a></li>
                <?php echo $__env->yieldContent('mapa'); ?>
            </ol>
        </section>

        <section class="content">
            <?php echo $__env->yieldContent('conteudo'); ?>
        </section>
    </div>

    <?php echo $__env->make('layout.rodape', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
</div>

<?php echo HTML::script('js/app.js'); ?>

<?php if(session()->has("tipo")): ?>
    <script>
        toastr["<?php echo session('tipo'); ?>"]("<?php echo session('mensagem'); ?>");
    </script>
<?php endif; ?>


<?php echo $__env->yieldPushContent('extra-scripts'); ?>
