<!-- Left side column. contains the sidebar -->
<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Sidebar Menu -->
        <ul class="sidebar-menu">
            <li class="header text-center">MENU</li>
            <li class="treeview">
                <a href="">
                    <i class="fa fa-hand-paper-o"></i><span>Turmas</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>

                <ul class="treeview-menu">
                    <li><a href="{{ route('criarTurma') }}"><i class="fa fa-plus"></i> <span>Criar</span></a></li>
                    <li><a href="#"><i class="fa fa-th-list"></i> <span>Visualizar</span></a></li>
                </ul>
            </li>
            <li><a href="{{ route('logs') }}"><i class="fa fa-database" aria-hidden="true"></i><span>Chamada</span></a></li>
            <li><a href="{{ route('logs') }}"><i class="fa fa-database" aria-hidden="true"></i><span>Turmas</span></a></li>
            <li><a href="{{ route('logs') }}"><i class="fa fa-database" aria-hidden="true"></i><span>Logs</span></a></li>
            <li><a href="{{ route('logout') }}"><i class="fa fa-sign-out" aria-hidden="true"></i><span>Sair</span></a></li>
        </ul>
    </section>
</aside>
