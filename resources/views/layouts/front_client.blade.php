<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>{{ $title }}</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta content="A project by Espacios Mexico Team" name="description" />
        <meta content="Espacios Mexico" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="{{ url('assets/images/favicon.ico') }}">
        <!-- Sweet Alert -->
        <link href="{{ url('assets/plugins/sweet-alert2/sweetalert2.min.css')}} " rel="stylesheet" type="text/css">
        <!-- App css -->
        <link href="{{ url('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ url('assets/css/metismenu.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ url('assets/css/icons.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ url('assets/css/style.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ url('assets/css/common.css?v=1') }}" rel="stylesheet" type="text/css" />
        <link href="{{ url('assets/plugins/bootstrap-select/css/bootstrap-select.min.css') }}" rel="stylesheet" />
        <script src="{{ url('assets/js/modernizr.min.js') }}"></script>
        @yield('customcss')
    </head>
    <body class="bg-transparent">
        <div class="spiner-example d-none">
            <div class="sk-spinner sk-spinner-chasing-dots">
                <div class="sk-dot1"></div>
                <div class="sk-dot2"></div>
            </div>
        </div>
        <!-- Begin page -->
        <div class="topbar-left">
            <!-- Image logo -->
            <a href="" class="logo">
                <span>
                    <img src="{{ url('assets/images/logo_espacios.png') }}" alt="" height="50">
                </span>
                <i>
                    <img src="{{ url('assets/images/logo_espacios_sm.png') }}" alt="" height="28">
                </i>
            </a>
        </div>
        <div class="accountbg">
            @if(config('starter.show_translate'))
            <ul class="nav navbar-nav navbar-right pull-right">
                <li class="dropdown">
                    <a href="" class="dropdown-toggle profile waves-effect waves-light" data-toggle="dropdown" aria-expanded="true">
                        <span class="profile-username">
                            @lang('sistema.login_lang') <span class="caret"></span>
                        </span>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="{{ url('language/es')}}"><img src="{{ url('assets/images/flag/flag_mex.png') }}" width="16px" /> @lang('sistema.login_spanish')</a></li>
                        <li class="divider"></li>
                        <li><a href="{{ url('language/en') }}"><img src="{{ url('assets/images/flag/flag_us.png') }}" width="16px" />  @lang('sistema.login_english')</a></li>
                    </ul>
                </li>
            </ul>
            @endif
        </div>
        <!-- HOME -->
        <div class="container">
            @yield('pagecontent')
        </div>
        <script>
            var resizefunc = [];
        </script>
        <!-- jQuery  -->
        <script src="{{ url('assets/js/jquery.min.js') }}"></script>
        <script src="{{ url('assets/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ url('assets/js/metisMenu.min.js') }}"></script>
        <script src="{{ url('assets/js/waves.js') }}"></script>
        <script src="{{ url('assets/js/jquery.slimscroll.js') }}"></script>
        <script src="{{ url('assets/plugins/bootstrap-select/js/bootstrap-select.min.js') }}"></script>
        <!-- Sweet-Alert  -->
        <script src="{{ url('assets/plugins/sweet-alert2/sweetalert2.min.js') }}"></script>
        <!-- App js -->
        <script src="{{ url('assets/js/jquery.core.js') }}"></script>
        <script src="{{ url('assets/js/jquery.app.js') }}"></script>
        <script type="text/javascript">
            function show_loader(flag)
            {                    
                if(flag)
                {
                    $(".spiner-example").removeClass('d-none');
                }
                else
                {
                    $(".spiner-example").addClass('d-none');
                }
            }
        </script>
        @yield('customjs')
    </body>
</html>