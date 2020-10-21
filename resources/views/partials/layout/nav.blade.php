<nav class="site-navbar navbar navbar-default navbar-fixed-top navbar-mega" role="navigation" style="background: #fff;">

    <div class="navbar-header">
        
        <button type="button" class="navbar-toggler collapsed" data-target="#site-navbar-collapse"
            data-toggle="collapse">
            <i class="icon wb-more-horizontal" aria-hidden="true"></i>
        </button>
        <div class="navbar-brand navbar-brand-center site-gridmenu-toggle" data-toggle="gridmenu">
            <img class="navbar-brand-logo" src=" {{asset('assets/images/icon.png')}} " title="Aligna" style="max-width:100%">
        </div>
    </div>

    <div class="navbar-container container-fluid">
    <div class="collapse navbar-collapse navbar-collapse-toolbar" id="site-navbar-collapse">
        <ul class="nav navbar-toolbar">
            <li class="nav-item hidden-float" id="toggleMenubar">
                <a href="{{ route('pop.create') }}" title="Criar POP" class="btn btn-primary btn-round" style="margin-top:16px; margin-left:15px;">Criar POP</a>
            </li>

        </ul>

        <ul class="nav navbar-toolbar navbar-right navbar-toolbar-right">
            <li class="nav-item hidden-sm-down" id="toggleFullscreen">
                <a class="nav-link icon icon-fullscreen" data-toggle="fullscreen" href="#" role="button">
                <span class="sr-only">Toggle fullscreen</span>
                </a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link navbar-avatar" data-toggle="dropdown" href="#" aria-expanded="false"
                data-animation="scale-up" role="button">
                <span class="avatar">
                    <img src="{{ asset("assets/global/portraits/5.jpg") }}" alt="...">
                </span>
                </a>
                <div class="dropdown-menu" role="menu">
                    <a class="dropdown-item" href="javascript:void(0)" role="menuitem"><i class="icon wb-user" aria-hidden="true"></i> Meu Perfil</a>
                    <div class="dropdown-divider" role="presentation"></div>
                    <a class="dropdown-item" href="javascript:void(0)" role="menuitem"><i class="icon wb-power" aria-hidden="true"></i> Sair</a>
                </div>
            </li>
        </ul>
    </div>

    </div>
</nav>
