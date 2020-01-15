<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
        <title>@lang('sistema.pie')</title>
        <meta content="Admin Dashboard" name="description" />
        <meta content="ThemeDesign" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />

        <link rel="shortcut icon" href="{{ url('assets/images/favicon.ico') }}">

        <link href="{{ url('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ url('assets/css/icons.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ url('assets/css/style.css') }}" rel="stylesheet" type="text/css">

    </head>


    <body>

        <!-- Begin page -->
        <div class="accountbg"></div>
        <div class="wrapper-page">
            <div class="panel panel-color panel-primary panel-pages">

                <div class="panel-body">
                    <h3 class="text-center m-t-0 m-b-15">
                        <a href="{{url('/')}}" class="logo logo-admin"><img src="{{ url('assets/images/logo_espacios.png')}}" height="96" alt="logo"></a>
                    </h3>
                    <h4 class="text-muted text-center m-t-0"><b>@lang('sistema.wellcome_user')</b></h4>

                    <form class="form-horizontal m-t-20">

                       

                        <div class="form-group">
                            <div class="col-xs-12">
                                <p><b>{{$name}}</b> : @lang('sistema.mail_wellcome_text') @lang('sistema.pie')</p>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-xs-12">
                                <p>
                                    @lang('sistema.mail_wellcome_user') : <b>{{$usuario}}</b><br>
                                    @lang('sistema.mail_wellcome_pass') : <b>{{$contrasena}}</b><br>
                                </p>
                            </div>
                        </div>

                        

                        <div class="form-group m-t-30 m-b-0">
                            <div class="col-sm-7">
                                <a href="{{ url('/') }}" class="text-muted"><i class="fa fa-plug m-r-5"></i> @lang('sistema.mail_wellcome_link')</a>
                            </div>                            
                        </div>
                    </form>
                </div>

            </div>
        </div>



        <!-- jQuery  -->
        <script src="{{ url('assets/js/jquery.min.js') }}"></script>
        <script src="{{ url('assets/js/bootstrap.min.js') }}"></script>
        <script src="{{ url('assets/js/modernizr.min.js') }}"></script>
        <script src="{{ url('assets/js/detect.js') }}"></script>
        <script src="{{ url('assets/js/fastclick.js') }}"></script>
        <script src="{{ url('assets/js/jquery.slimscroll.js') }}"></script>
        <script src="{{ url('assets/js/jquery.blockUI.js') }}"></script>
        <script src="{{ url('assets/js/waves.js') }}"></script>
        <script src="{{ url('assets/js/wow.min.js') }}"></script>
        <script src="{{ url('assets/js/jquery.nicescroll.js') }}"></script>
        <script src="{{ url('assets/js/jquery.scrollTo.min.js') }}"></script>

        <script src="{{ url('assets/js/app.js">') }}</script>

    </body>
</html>