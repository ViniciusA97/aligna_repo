import React from 'react';

export default function Header() {
    return (
        <>
            <nav className="site-navbar navbar navbar-default navbar-fixed-top navbar-mega" role="navigation" style={{background: '#fff'}}>
                <div className="navbar-header">
                    <button type="button" class="navbar-toggler collapsed" data-target="#site-navbar-collapse" data-toggle="collapse">
                        <i className="icon wb-more-horizontal" aria-hidden="true"></i>
                    </button>
                    <div className="navbar-brand navbar-brand-center site-gridmenu-toggle" data-toggle="gridmenu">
                        <img className="navbar-brand-logo" src=" {{asset('assets/images/icon.png')}} " title="Aligna" style={{maxWidth:'100%'}}/>
                    </div>
                </div>

                <div className="navbar-container container-fluid">
                    <div className="collapse navbar-collapse navbar-collapse-toolbar" id="site-navbar-collapse">
                        <ul className="nav navbar-toolbar">
                            <li className="nav-item hidden-float" id="toggleMenubar">
                                <a href="{{ route('pop.create') }}" title="Criar POP" className="btn btn-primary btn-round" style={{marginTop:'16px', marginLeft:'15px'}}>Criar POP</a>
                            </li>
                        </ul>

                        <ul className="nav navbar-toolbar navbar-right navbar-toolbar-right">
                            <li className="nav-item hidden-sm-down" id="toggleFullscreen">
                                <a className="nav-link icon icon-fullscreen" data-toggle="fullscreen" href="#" role="button">
                                    <span className="sr-only">Toggle fullscreen</span>
                                </a>
                            </li>
                            <li className="nav-item dropdown">
                                <a className="nav-link navbar-avatar" data-toggle="dropdown" href="#" aria-expanded="false" data-animation="scale-up" role="button">
                                    <span className="avatar">
                                        <img src="/assets/global/portraits/5.jpg" alt="..."/>
                                    </span>
                                </a>
                                <div className="dropdown-menu" role="menu">
                                    <a className="dropdown-item" href="javascript:void(0)" role="menuitem"><i className="icon wb-user" aria-hidden="true"></i> Meu Perfil</a>
                                    <div className="dropdown-divider" role="presentation"></div>
                                    <a className="dropdown-item" href="javascript:void(0)" role="menuitem"><i className="icon wb-power" aria-hidden="true"></i> Sair</a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </>
    );
}
