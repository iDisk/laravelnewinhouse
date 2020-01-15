@extends('layouts.front', ['title' => __('sistema.login_title')])
@section('pagecontent')
    <div class="row">
        <div class="col-sm-12">
            <div class="wrapper-page">
                <div class="m-t-40 account-pages">
                    <div class="text-center account-logo-box">
                        <h2 class="text-uppercase">
                            <a href="" class="text-success">
                                <span><img src="{{ url('assets/images/logo_espacios.png')}}" alt="" height="80"></span>
                            </a>
                        </h2>
                        <!--<h4 class="text-uppercase font-bold m-b-0">Sign In</h4>-->
                    </div>
                    <div class="account-content">
                        <form class="form-horizontal" action="{{ route('login') }}" method="POST">
                            {{ csrf_field() }}
                            <div class="form-group m-b-25">
                                <div class="col-12">
                                    <label for="emailaddress">@lang('sistema.login_placeholder_email')</label>
                                    <input class="form-control input-lg" type="email" id="email" name="email" required="" value="{{ old('email') }}" placeholder="@lang('sistema.login_placeholder_email')" tabindex="1">
                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group m-b-25">
                                <div class="col-12">
                                    <a href="{{ route('password.request') }}" class="text-muted float-right">@lang('sistema.login_recovery')</a>
                                    <label for="password">@lang('sistema.login_placeholder_pass')</label>
                                    <input class="form-control input-lg" type="password" id="password" name="password" required="" placeholder="@lang('sistema.login_placeholder_pass')" tabindex="2">
                                    @if ($errors->has('password'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group account-btn text-center m-t-10">
                                <div class="col-12">
                                    <button class="btn w-lg btn-rounded btn-lg btn-primary waves-effect waves-light" type="submit">@lang('sistema.login_submit')</button>
                                </div>
                            </div>
                        </form>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
            <!-- end wrapper -->
        </div>
    </div>
@endsection