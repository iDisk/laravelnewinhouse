@extends('layouts.front_login', ['title' => __('frontsistema.login_title')])
@section('customcss')
<link href="{{ url('assets/plugins/sweet-alert2/sweetalert2.min.css')}} " rel="stylesheet" type="text/css">
<style type="text/css">
.txt_theme_font{
    color: #8cd5dd;
}
.txt_dark_font{
    color: #2d2d2d;
}
</style>
@endsection
@section('pagecontent')
    <div class="row">
        <div class="col-sm-12">
            <div class="wrapper-page">
                <div class="m-t-40 account-pages">
                    <div class="text-center account-logo-box">
                        <h2 class="text-uppercase">
                            <a href="{{url('/user_login')}}" class="text-success">
                                <span><img src="{{ url('assets/images/logo_espacios.png')}}" alt="" height="80"></span>
                            </a>
                        </h2>
                        <div class="col-12">
                            <div class="page-title-box">
                                <h4 class="page-title text-center float-none">@lang('frontsistema.frm_user_login.welcome_txt')</h4>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
                    <div class="account-content">
                        <!-- first step of login starts -->
                        <form class="form-horizontal" id="loginForm" >
                            <input type="hidden" id="_token" value="{{ csrf_token() }}">
                            <div class="form-group m-b-25">
                                <div class="col-12">
                                    <label class="font-600" for="inputuser_login1">@lang('frontsistema.frm_user_login.field_user')</label>
                                    <input class="form-control input-lg input-black" type="text" id="inputuser_login1" name="user_login" data-parsley-trigger="change" required value="{{ old('user_login') }}" placeholder="@lang('frontsistema.frm_user_login.field_user')" tabindex="1">
                                    <div class="form-error">@lang('frontsistema.frm_user_login.field_user_error')</div>
                                   
                                    <div class="alert alert-warning m-t-10" id="errorMsg" style="display:none"></div>
                                    <a href="{{url('user/forgot-password')}}" class="float-right m-t-5 txt_theme_font font-600">@lang('frontsistema.frm_user_login.forgot_password')</a>
                                </div>
                            </div>
                                                      
                           
                            <div class="form-group account-btn1 m-t-10">
                                <div class="col-12">
                                    <button id="loginFormButton" class="btn w-lg btn-lg btn-black waves-effect waves-light" type="submit">@lang('frontsistema.frm_user_login.login_btn')</button>
                                </div>
                            </div>
                        </form>
                        <!-- first step of login ends -->

                        <!-- main login form starts -->
                        <form class="form-horizontal" id="mainLoginForm" style="display:none">
                            <input type="hidden" id="_token" value="{{ csrf_token() }}">
                            <div class="form-group m-b-25">
                                <div class="col-12" style="text-align: center;">
                                    <img id="security_image" src="{{ asset(env('APP_ROOT').'/assets/images/no_image.png') }}" style="height: 200px;width: auto;">
                                </div>
                                <div class="col-12 m-t-20" style="text-align: center;">
                                    <p style="font-size: 18px;font-weight: 600;" id="security_image_phrase"></p>
                                </div>
                            </div>
                            <input class="form-control input-lg input-black" type="hidden" id="inputuser_login" name="user_login" value="{{ old('user_login') }}" placeholder="@lang('frontsistema.frm_user_login.field_user')">
                            
                            <div class="form-group m-b-25">
                                <div class="col-12">
                                    <label class="font-600" for="password">@lang('frontsistema.frm_user_login.field_pwd')</label>
                                    <input class="form-control input-lg input-black" type="password" id="password" name="password" required placeholder="@lang('frontsistema.frm_user_login.field_pwd')" tabindex="1">
                                    <div class="form-error">@lang('frontsistema.frm_user_login.field_pwd_error')</div>
                                    <a href="{{url('user/forgot-password')}}" class="float-right m-t-5 txt_theme_font font-600">@lang('frontsistema.frm_user_login.forgot_password')</a>
                                </div>
                            </div>                           
                            <div class="alert alert-warning m-t-30" id="mainErrorMsg" style="display:none"></div>
                            
                            <div class="form-group account-btn1 m-t-10">
                                <div class="col-12">
                                    <button id="mainLoginFormButton" class="btn w-lg btn-lg btn-black waves-effect waves-light" type="submit">@lang('frontsistema.frm_user_login.login_btn')</button>
                                </div>
                            </div>
                        </form>
                        <!-- main login form ends -->

                        <div class="clearfix"></div>

                    </div>
                </div>
            </div>
            <!-- end wrapper -->
        </div>
    </div>
@endsection
@section('customjs')
<script src="{{ url('assets/plugins/parsleyjs/parsley.min.js') }}"></script>
<script type="text/javascript">
    $( document ).ready(function() {
        
        $('#loginForm').parsley().on('field:validated', function () {
            //console.log("form error");
        })
        .on('form:submit', function () {
            console.log("submit form");
            submitFirstForm();
            return false; // Don't submit form for this demo
        });

        $('#mainLoginForm').parsley().on('field:validated', function () {
            //console.log("form error");
        })
        .on('form:submit', function () {
            console.log("submit form");
            submitSecondform();
            return false; // Don't submit form for this demo
        });
        
                        
    });
    function submitFirstForm(){  
        try {
            $('#errorMsg').hide();
            let token = $('#_token').val();
            let user_login = $('#inputuser_login1').val();
            $('#loginFormButton').html('<i class="fa fa-circle-o-notch fa-spin m-r-10"></i> @lang("frontsistema.frm_user_login.please_wait")');
            $('#loginFormButton').prop("disabled", true);

            $.ajax({
                type: 'POST',
                dataType: 'json',
                data: {'_token':token,'user_login':user_login},
                url: "{{ url('user_security_login') }}",
                beforeSend: function() {
                    //$('#modal-espere').modal('show');
                },
                success: function(response) {
                    if (response.error && response.code == '500'){
                        $('#errorMsg').html(response.message);
                        $('#errorMsg').show();
                    
                    }
                    else if(!response.error && response.code == '200'){
                        $('#loginForm').hide();
                        $('#mainLoginForm').show();
                        $('#security_image_phrase').html(response.data.image_phrase);
                        $('#security_image').attr('src', response.data.image);
                        $('#inputuser_login').val(user_login);
                    }
                    $('#loginFormButton').html('@lang("frontsistema.frm_user_login.login_btn")');
                    $('#loginFormButton').prop("disabled", false);
                },
                error: function(response) {
                    console.error(response);
                     $('#loginFormButton').html('@lang("frontsistema.frm_user_login.login_btn")');
                    $('#loginFormButton').prop("disabled", false);
                    // swal("@lang('frontsistema.users_alert')", "@lang('frontsistema.control_de_acceso.went_wrong_msg')", 'error');
                
                },
                complete: function() {
                    $('#loginFormButton').html('@lang("frontsistema.frm_user_login.login_btn")');
                    $('#loginFormButton').prop("disabled", false);
                }
            });
        } catch (error) {
            console.log(error);
        }
    }
   function submitSecondform(){
       try {
           $('#mainErrorMsg').hide();
            let token = $('#_token').val();
            let user_login = $('#inputuser_login1').val();
            $('#mainLoginFormButton').html('<i class="fa fa-circle-o-notch fa-spin m-r-10"></i> @lang("frontsistema.frm_user_login.please_wait")');
            $('#mainLoginFormButton').prop("disabled", true);

            $.ajax({
                type: 'POST',
                dataType: 'json',
                data: {'_token':token,'user_login':user_login, 'password':$('#password').val()},
                url: "{{ url('ajax_user_login') }}",
                beforeSend: function() {
                    //$('#modal-espere').modal('show');
                },
                success: function(response) {
                    if (response.error && response.code == '500'){
                        $('#mainErrorMsg').html(response.message);
                        $('#mainErrorMsg').show();
                    
                    }
                    else if(!response.error && response.code == '200'){
                       location.reload();
                    }
                    $('#mainLoginFormButton').html('@lang("frontsistema.frm_user_login.login_btn")');
                    $('#mainLoginFormButton').prop("disabled", false);
                },
                error: function(response) {
                    console.error(response);
                    $('#mainLoginFormButton').html('@lang("frontsistema.frm_user_login.login_btn")');
                    $('#mainLoginFormButton').prop("disabled", false);
                    // swal("@lang('frontsistema.users_alert')", "@lang('frontsistema.control_de_acceso.went_wrong_msg')", 'error');
                
                },
                complete: function() {
                    $('#mainLoginFormButton').html('@lang("frontsistema.frm_user_login.login_btn")');
                    $('#mainLoginFormButton').prop("disabled", false);
                }
            });
       } catch (error) {
           console.log(error)
       }
   }
</script>
@endsection