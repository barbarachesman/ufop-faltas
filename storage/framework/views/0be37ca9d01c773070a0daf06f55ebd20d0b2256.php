<!-- Left side column. contains the sidebar -->
<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Sidebar Menu -->
        <ul class="sidebar-menu">
            <?php if (app('Illuminate\Contracts\Auth\Access\Gate')->check('administrar')): ?>
                <li class="header text-center">ADMINISTRADOR</li>
                <li class="treeview <?php echo e(Route::is('visualizarDisciplinas') || Route::is('criarDisciplina') || Route::is('detalhesDisciplina') || Route::is('editarDisciplina') ? 'active' : ''); ?>">
                    <a href="">
                        <i class="fa fa-book"></i><span>Disciplinas</span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>

                    <ul class="treeview-menu">
                        <li class="<?php echo e(Route::is('criarDisciplina') ? 'active' : ''); ?>"><a href="<?php echo e(route('criarDisciplina')); ?>"><i class="fa fa-plus"></i> <span>Criar</span></a></li>
                        <li class="<?php echo e(Route::is('visualizarDisciplinas') ? 'active' : ''); ?>"><a href="<?php echo e(route('visualizarDisciplinas')); ?>"><i class="fa fa-th-list"></i> <span>Listar</span></a></li>
                    </ul>
                </li>

                <li class="treeview <?php echo e(Route::is('visualizarPeriodos') || Route::is('criarPeriodo') || Route::is('detalhesPeriodo') || Route::is('editarPeriodo') ? 'active' : ''); ?>">
                    <a href="">
                        <i class="fa fa-calendar-o"></i><span>Períodos</span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>

                    <ul class="treeview-menu">
                        <li class="<?php echo e(Route::is('criarPeriodo') ? 'active' : ''); ?>"><a href="<?php echo e(route('criarPeriodo')); ?>"><i class="fa fa-plus"></i> <span>Criar</span></a></li>
                        <li class="<?php echo e(Route::is('visualizarPeriodos') ? 'active' : ''); ?>"><a href="<?php echo e(route('visualizarPeriodos')); ?>"><i class="fa fa-th-list"></i> <span>Listar</span></a></li>
                    </ul>
                </li>
                <li><a href="<?php echo e(route('logs')); ?>"><i class="fa fa-database" aria-hidden="true"></i><span>Logs</span></a></li>
            <?php endif; ?>

            <?php if (app('Illuminate\Contracts\Auth\Access\Gate')->denies('administrar')): ?>
                <?php if(auth()->user()->isProfessor()): ?>
                    <li class="header text-center">PROFESSOR</li>
                <?php else: ?>
                    <li class="header text-center">ALUNO</li>
                <?php endif; ?>
                <li class="treeview <?php echo e(Route::is('criarTurma') || Route::is('visualizarTurmasAluno') || Route::is('visualizarTurmasProfessor') ? 'active' : ''); ?>">
                    <a href="">
                        <i class="fa fa-users"></i><span>Minhas Turmas</span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>

                    <ul class="treeview-menu">
                        <?php if(auth()->user()->isProfessor()): ?>
                            <li class="<?php echo e(Route::is('criarTurma') ? 'active' : ''); ?>"><a href="<?php echo e(route('criarTurma')); ?>"><i class="fa fa-plus"></i> <span>Criar</span></a></li>
                            <li class="<?php echo e(Route::is('visualizarTurmasProfessor') ? 'active' : ''); ?>"><a href="<?php echo e(route('visualizarTurmasProfessor')); ?>"><i class="fa fa-th-list"></i> <span>Listar</span></a></li>
                        <?php else: ?>
                            <li class="<?php echo e(Route::is('visualizarTurmasAluno') ? 'active' : ''); ?>"><a href="<?php echo e(route('visualizarTurmasAluno')); ?>"><i class="fa fa-th-list"></i> <span>Listar</span></a></li>
                        <?php endif; ?>
                    </ul>

                </li>
            <?php endif; ?>
            <?php if(auth()->user()->isALuno()): ?>
            <li><a href="<?php echo e(route('tutorial')); ?>"><i class="fa fa-book" aria-hidden="true"></i><span>Meus Abonos</span></a></li>
            <?php endif; ?>
            <li><a href="<?php echo e(route('tutorial')); ?>"><i class="fa fa-book" aria-hidden="true"></i><span>Tutorial</span></a></li>
            <li><a href="<?php echo e(route('logout')); ?>"><i class="fa fa-sign-out" aria-hidden="true"></i><span>Sair</span></a></li>
        </ul>
    </section>
</aside>
