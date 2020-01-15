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
        <!-- Begin page -->
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
        <section>
            <div class="container">
                @yield('pagecontent')
            </div>
        </section>
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
        <!-- App js -->
        <script src="{{ url('assets/js/jquery.core.js') }}"></script>
        <script src="{{ url('assets/js/jquery.app.js') }}"></script>
        @yield('customjs')
    </body>
</html>