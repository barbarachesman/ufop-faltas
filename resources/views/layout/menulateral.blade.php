<!-- Left side column. contains the sidebar -->
<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Sidebar Menu -->
        <ul class="sidebar-menu">
            <li class="header text-center">MENU</li>
            <li class="treeview {{ Route::is('criarTurma') || Route::is('visualizarTurmas') ? 'active' : '' }}">
                <a href="">
                    <i class="fa fa-users"></i><span>Turmas</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>

                <ul class="treeview-menu">
                    <li class="{{ Route::is('criarTurma') ? 'active' : '' }}"><a href="{{ route('criarTurma') }}"><i class="fa fa-plus"></i> <span>Criar</span></a></li>
                    <li class="{{ Route::is('visualizarTurmas') ? 'active' : '' }}"><a href="{{ route('visualizarTurmas') }}"><i class="fa fa-th-list"></i> <span>Listar</span></a></li>
                </ul>
            </li>
            <li><a href="{{ route('logs') }}"><i class="fa fa-database" aria-hidden="true"></i><span>Logs</span></a></li>
            <li><a href="{{ route('logout') }}"><i class="fa fa-sign-out" aria-hidden="true"></i><span>Sair</span></a></li>
        </ul>
    </section>
</aside>
