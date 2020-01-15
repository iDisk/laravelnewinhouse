<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>@lang('sistema.change_password')</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
        <meta content="Coderthemes" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">
        <!-- App css -->
        <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/css/metismenu.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/css/icons.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/front_css/common.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/plugins/bootstrap-select/css/bootstrap-select.min.css') }}" rel="stylesheet" />
        <script src="{{ asset('assets/js/modernizr.min.js') }}"></script>
        <style>
            .wrapper-page{
                margin: 5% auto;
            }
            ul{
                margin-bottom: 0;
            }
        </style>
    </head>
    <body class="bg-transparent">
        <!-- HOME -->
        <section>
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="wrapper-page">
                            <div class="m-t-40 account-pages">
                                <div class="text-center account-logo-box">
                                    <h2 class="text-uppercase">
                                        <a href="index.html" class="text-success">
                                            <span><img src="{{ asset('assets/images/logo_espacios.png') }}" alt="" height="80"></span>
                                        </a>
                                    </h2>
                                </div>
                                <div class="account-content">
                                    @if (isset($errors) && count($errors) > 0)
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    @endif
                                    <form class="form-horizontal" action="{{ url('user/change-password') }}" method="post" id="frmChangePassword">
                                        <div class="form-group m-b-15">
                                            <div class="col-12">
                                                <label for="old_password">@lang('sistema.old_password')</label>
                                                <input class="form-control input-lg" type="password" id="old_password" name="old_password" placeholder="{{ __('sistema.old_password') }}" data-parsley-trigger="change" required>
                                                <div class="form-error">@lang('sistema.old_password_required_error')</div>
                                                {{ csrf_field() }}
                                            </div>
                                        </div>
                                        <div class="form-group m-b-15">
                                            <div class="col-12">
                                                <label for="new_password">@lang('sistema.new_password')</label>
                                                <input data-parsley-minlength="6" data-parsley-minlength-message="Come on! You need to enter at least a 20 character comment.." class="form-control input-lg" type="password" id="password" name="password" placeholder="{{ __('sistema.new_password') }}" data-parsley-trigger="change" required>
                                                <div class="form-error">@lang('sistema.new_password_required_error')</div>
                                            </div>
                                        </div>
                                        <div class="form-group m-b-15">
                                            <div class="col-12">
                                                <label for="password">@lang('sistema.confirm_password')</label>
                                                <input data-parsley-minlength="6" data-parsley-minlength-message="Come on! You need to enter at least a 20 character comment.." class="form-control input-lg" type="password" id="password_confirmation" name="password_confirmation" placeholder="{{ __('sistema.confirm_password') }}" data-parsley-trigger="change" required>
                                                <div class="form-error">@lang('sistema.confirm_password_required_error')</div>
                                            </div>
                                        </div>
                                        <div class="form-group account-btn text-center m-t-10">
                                            <div class="col-12">
                                                <button class="btn w-lg btn-rounded btn-lg btn-primary waves-effect waves-light" type="submit">@lang('sistema.change_password')</button>
                                            </div>
                                        </div>
                                    </form>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                            <!-- end card-box-->
                        </div>
                        <!-- end wrapper -->
                    </div>
                </div>
            </div>
        </section>
        <!-- END HOME -->
        <script>
var resizefunc = [];
        </script>
        <!-- jQuery  -->
        <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
        <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('assets/js/metisMenu.min.js') }}"></script>
        <script src="{{ asset('assets/js/waves.js') }}"></script>
        <script src="{{ asset('assets/js/jquery.slimscroll.js') }}"></script>
        <script src="{{ asset('assets/plugins/bootstrap-select/js/bootstrap-select.min.js') }}"></script>
        <!-- App js -->
        <script src="{{ asset('assets/js/jquery.core.js') }}"></script>
        <script src="{{ asset('assets/js/jquery.app.js') }}"></script>
        <!-- Parsley -->
        <script src="{{ url('assets/plugins/parsleyjs/parsley.min.js') }}"></script>
        <script>
$(function () {
    $('#frmChangePassword').parsley().on('field:validated', function () {
        var ok = $('.parsley-error').length === 0;
        $('.bs-callout-info').toggleClass('hidden', !ok);
        $('.bs-callout-warning').toggleClass('hidden', ok);
    });
});
        </script>
    </body>
</html>