<!-- LOGO -->
<div class="topbar-left">
    
    <a href="{{ url('/')}}" class="logo"><img src="{{ url('assets/images/logo_espacios.png') }}" height="60" alt="logo"></a>
    <a href="{{ url('/')}}" class="logo-sm"><img src="{{ url('assets/images/logo_espacios.png') }}" height="20" alt="logo"></a>
</div>
<!-- Button mobile view to collapse sidebar menu -->
<div class="navbar navbar-default" role="navigation">
    <div class="container">
        <div class="">
            <div class="pull-left">
                <button type="button" class="button-menu-mobile open-left waves-effect waves-light">
                    <i class="ion-navicon"></i>
                </button>
                <span class="clearfix"></span>
            </div>

            <ul class="nav navbar-nav navbar-right pull-right">
                
                <li class="hidden-xs">
                    <a href="#" id="btn-fullscreen" class="waves-effect waves-light notification-icon-box"><i class="ion-qr-scanner"></i></a>
                </li>
                <li class="dropdown">
                    <a href="" class="dropdown-toggle profile waves-effect waves-light" data-toggle="dropdown" aria-expanded="true">
                        
                        <span class="profile-username">
                            Menú <span class="caret"></span>
                        </span>
                    </a>
                    <ul class="dropdown-menu">
                        <!--<li><a href="javascript:void(0)"> Perfil</a></li>
                        <li class="divider"></li>-->
                        @if(config('starter.show_translate'))
                        <li><a href="{{ url('language/es')}}"><img src="{{ url('assets/images/flag/flag_mex.png') }}" width="16px" /> @lang('sistema.login_spanish')</a></li>
                        <li class="divider"></li>
                        <li><a href="{{ url('language/en') }}"><img src="{{ url('assets/images/flag/flag_us.png') }}" width="16px" />  @lang('sistema.login_english')</a></li>
                        <li class="divider"></li>
                        @endif
                        <li>
                            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"> @lang('sistema.header_menu_logout')
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
        <!--/.nav-collapse -->
    </div>
</div>
