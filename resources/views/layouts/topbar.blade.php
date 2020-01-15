<!-- Top Bar Start -->
<div class="topbar">
<!-- LOGO -->
<div class="topbar-left">
    <!--<a href="index.html" class="logo"><span>Code<span>Fox</span></span><i class="mdi mdi-layers"></i></a>-->
    <!-- Image logo -->
    <a href="{{ url('/') }}" class="logo">
        <span>
            <img src="{{ url('assets/images/logo_espacios.png') }}" alt="" height="50">
        </span>
        <i>
            <img src="{{ url('assets/images/logo_espacios_sm.png') }}" alt="" height="28">
        </i>
    </a>
</div>
<!-- Button mobile view to collapse sidebar menu -->
<div class="navbar navbar-default" role="navigation">
    <div class="container-fluid">
        <!-- Navbar-left -->
        <ul class="nav navbar-left">
            <li>
                <button type="button" class="button-menu-mobile open-left waves-effect">
                    <i class="dripicons-menu"></i>
                </button>
            </li>
            @if(config('starter.show_translate'))
            <li class="d-none d-sm-block lang-option">
                <select class="selectpicker form-control" title="" id="language_select" data-width="110px" onchange="event.preventDefault(); window.location = '{{ url('language') }}' + '/' + document.getElementById('language_select').value.toString();">
                    <option value="es" {{ (Config::get('app.locale') == 'es' ? 'selected' : '') }}>@lang('sistema.login_spanish')</option>
                    <option value="en" {{ (Config::get('app.locale') == 'en' ? 'selected' : '') }}>@lang('sistema.login_english')</option>
                </select>
            </li>
            @endif
        </ul>
        <!-- Right(Notification) -->
        <ul class="nav navbar-right list-inline">
            <li class="dropdown user-box list-inline-item">
                <a href="" class="dropdown-toggle waves-effect user-link" data-toggle="dropdown" aria-expanded="true">
                    @if(auth()->user())
                        @if(auth()->user()->photo!=null)
                        <img src="{{ auth()->user()->photo }}" alt="{{ auth()->user()->name }}" class="rounded-circle user-img">
                        @else
                        <img src="{{ url('assets/images/users/generic-user.jpg') }}" alt="{{ auth()->user()->name }}" class="rounded-circle user-img">
                        @endif
                    @else
                    <img src="{{ url('assets/images/users/generic-user.jpg') }}" alt="Usuario" class="rounded-circle user-img">
                    @endif
                </a>
                <ul class="dropdown-menu dropdown-menu-right arrow-dropdown-menu arrow-menu-right user-list notify-list">
                    <!-- <li><a href="javascript:void(0)" class="dropdown-item">Profile</a></li>
                    <li><a href="javascript:void(0)" class="dropdown-item"><span class="badge badge-pill badge-info float-right">4</span>Settings</a></li>
                    <li><a href="javascript:void(0)" class="dropdown-item">Lock screen</a></li>
                    <li class="dropdown-divider"></li> -->
                    <li><a href="{{ route('logout') }}" class="dropdown-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"> @lang('sistema.header_menu_logout')</a></li>
                </ul>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>
            </li>
        </ul> <!-- end navbar-right -->
    </div><!-- end container-fluid -->
</div><!-- end navbar -->
</div>
<!-- Top Bar End -->