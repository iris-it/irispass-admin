<header class="main-header">
    <a href="{{action('HomeController@index')}}" class="logo">
        <span class="logo-mini"><b>I</b>PASS</span>
        <span class="logo-lg"><b>Iris</b>PASS</span>
    </a>
    <nav class="navbar navbar-static-top">
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </a>

        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <span class="hidden-xs">{{Auth::user()->name}} <span class="caret"></span></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="user-footer">
                            <div class="pull-left">
                                <a class="btn btn-default btn-flat" href="{{action('AuthController@userProfile')}}">Mon Profil</a>
                            </div>
                            <div class="pull-right">
                                <a class="btn btn-default btn-flat" href="{{action('AuthController@logout')}}">Déconnexion</a>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>
