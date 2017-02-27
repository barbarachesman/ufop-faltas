<!-- Left side column. contains the sidebar -->
<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Sidebar Menu -->
        <ul class="sidebar-menu">
            @can('administrar')
                <li class="header text-center">ADMINISTRADOR</li>
                <li class="treeview {{ Route::is('visualizarDisciplinas') || Route::is('criarDisciplina') || Route::is('detalhesDisciplina') || Route::is('editarDisciplina') ? 'active' : '' }}">
                    <a href="">
                        <i class="fa fa-book"></i><span>Disciplinas</span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>

                    <ul class="treeview-menu">
                        <li class="{{ Route::is('criarDisciplina') ? 'active' : '' }}"><a href="{{ route('criarDisciplina') }}"><i class="fa fa-plus"></i> <span>Criar</span></a></li>
                        <li class="{{ Route::is('visualizarDisciplinas') ? 'active' : '' }}"><a href="{{ route('visualizarDisciplinas') }}"><i class="fa fa-th-list"></i> <span>Listar</span></a></li>
                    </ul>
                </li>
                <li><a href="{{ route('logs') }}"><i class="fa fa-database" aria-hidden="true"></i><span>Logs</span></a></li>
            @endcan

            @cannot('administrar')
                @if(auth()->user()->isProfessor())
                    <li class="header text-center">PROFESSOR</li>
                @else
                    <li class="header text-center">ALUNO</li>
                @endif
                <li class="treeview {{ Route::is('criarTurma') || Route::is('visualizarTurmas') ? 'active' : '' }}">
                    <a href="">
                        <i class="fa fa-users"></i><span>Minhas Turmas</span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>

                    <ul class="treeview-menu">
                        @can('lecionar')
                            <li class="{{ Route::is('criarTurma') ? 'active' : '' }}"><a href="{{ route('criarTurma') }}"><i class="fa fa-plus"></i> <span>Criar</span></a></li>
                        @endcan
                        <li class="{{ Route::is('visualizarTurmas') ? 'active' : '' }}"><a href="{{ route('visualizarTurmas') }}"><i class="fa fa-th-list"></i> <span>Listar</span></a></li>
                    </ul>
                </li>
            @endcannot

            <li><a href="{{ route('logout') }}"><i class="fa fa-sign-out" aria-hidden="true"></i><span>Sair</span></a></li>
        </ul>
    </section>
</aside>
