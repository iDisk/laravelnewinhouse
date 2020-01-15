@extends('layouts.front', ['title' => __('sistema.recovery_title')])
@section('pagecontent')
    <div class="row">
        <div class="col-sm-12">
            <div class="wrapper-page">
                <div class="m-t-40 account-pages">
                    <div class="text-center account-logo-box">
                        <h2 class="text-uppercase">
                            <a href="{{url('/')}}" class="text-success">
                                <span><img src="{{ url('assets/images/logo_espacios.png')}}" alt="" height="80"></span>
                            </a>
                        </h2>
                        <!--<h4 class="text-uppercase font-bold m-b-0">Sign In</h4>-->
                    </div>
                    <div class="account-content">
                        <!-- <div class="text-center m-b-20">
                            <p class="text-muted m-b-0">@lang('sistema.recovery_reset')</p>
                        </div> -->
                        <form class="form-horizontal" action="{{ route('password.request') }}" method="POST">
                            {{ csrf_field() }}
                            <input type="hidden" name="token" value="{{ $token }}">
                            @if (session('status'))
                                <div class="alert alert-success">
                                    {{ session('status') }}
                                </div>
                            @endif
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
                                    <label for="password">@lang('sistema.login_placeholder_pass')</label>
                                    <input class="form-control input-lg" type="password" id="password" name="password" required="" placeholder="@lang('sistema.login_placeholder_pass')" tabindex="2">
                                    @if ($errors->has('password'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group m-b-25">
                                <div class="col-12">
                                    <label for="password">@lang('sistema.login_placeholder_pass_confirm')</label>
                                    <input class="form-control input-lg" type="password" id="password-confirm" name="password_confirmation" required="" placeholder="@lang('sistema.login_placeholder_pass_confirm')" tabindex="2">
                                    @if ($errors->has('password_confirmation'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('password_confirmation') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group account-btn text-center m-t-10">
                                <div class="col-12">
                                    <button class="btn w-lg btn-rounded btn-lg btn-primary waves-effect waves-light" type="submit">@lang('sistema.recovery_change')</button>
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