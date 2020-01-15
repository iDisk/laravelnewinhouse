@extends('layouts.front_login', ['title' => __('frontsistema.login_title')])
@section('customcss')
<link href="{{ url('assets/plugins/sweet-alert2/sweetalert2.min.css')}} " rel="stylesheet" type="text/css">
<link href="{{ url('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
<style type="text/css">
.txt_theme_font{
    color: #8cd5dd;
}
.txt_dark_font{
    color: #2d2d2d;
}
.select2 .select2-selection{
    border-radius: 0px;
    border: 1px solid #2d2d2d !important;
    height: 46px !important;
    padding: 10px 16px;
    font-size: 14px;
    line-height: 1.3333333;
}
.select2 .select2-selection .select2-selection__rendered {
    padding: 0px !important;
    margin: 0px !important;
    line-height: 24px !important;
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
                    </div>
                    <div class="account-content">
                        <!-- first step of login starts -->
                        <input type="hidden" id="_token" value="{{ csrf_token() }}">
                        <form class="form-horizontal" id="loginForm" >
                            <div class="form-group m-b-25">
                                <div class="col-12">
                                    <label class="font-600" for="admin_email">@lang('frontsistema.master_login.admin_email')</label>
                                    <input class="form-control input-lg input-black" type="email" id="admin_email" name="user_login" data-parsley-trigger="change" required value="{{ old('user_login') }}" placeholder="@lang('frontsistema.master_login.admin_email')" tabindex="1">
                                    <div class="form-error">@lang('frontsistema.master_login.admin_email_err')</div>
                                </div>
                            </div>
                            <div class="form-group m-b-25">
                                <div class="col-12">
                                    <label class="font-600" for="password">@lang('frontsistema.master_login.admin_password')</label>
                                    <input class="form-control input-lg input-black" type="password" id="password" name="password" required placeholder="@lang('frontsistema.master_login.admin_password')" tabindex="1">
                                    <div class="form-error">@lang('frontsistema.master_login.admin_password_err')</div>
                                </div>
                                <div class="col-12">
                                    <div class="alert alert-warning m-t-10" id="errorMsg" style="display:none"></div>
                                </div>
                            </div>           
                           
                            <div class="form-group account-btn1 m-t-10">
                                <div class="col-12">
                                    <button id="loginFormButton" class="btn w-lg btn-lg btn-black waves-effect waves-light" type="submit">@lang('frontsistema.master_login.admin_login_btn')</button>
                                </div>
                            </div>
                        </form>
                        <!-- first step of login ends -->

                        <!-- main login form starts -->
                        <form class="form-horizontal" id="mainLoginForm" style="display: none;">
                            <div class="form-group m-b-25">
                                <div class="col-12">
                                    <label class="font-600" for="admin_email">@lang('frontsistema.master_login.user')</label>
                                    <select class="form-control input-lg input-black" name="users_acc" id="users_acc" required="" tabindex="1">
                                        <option value="">@lang('frontsistema.master_login.select_user')</option>
                                    </select>
                                    <div class="form-error">@lang('frontsistema.master_login.user_err')</div>
                                </div>
                            </div>
                            <div class="form-group m-b-25">
                                <div class="col-12">
                                    <label class="font-600" for="master_password">@lang('frontsistema.master_login.master_password')</label>
                                    <input class="form-control input-lg input-black" type="password" id="master_password" name="master_password" required placeholder="@lang('frontsistema.master_login.master_password')" tabindex="2">
                                    <div class="form-error">@lang('frontsistema.master_login.master_password_err')</div>
                                </div>
                                <div class="col-12">
                                    <div class="alert alert-warning m-t-30" id="mainErrorMsg" style="display:none"></div>
                                </div>
                            </div>
                            <div class="form-group account-btn1 m-t-10">
                                <div class="col-12">
                                    <button id="mainLoginFormButton" class="btn w-lg btn-lg btn-black waves-effect waves-light" type="submit">@lang("frontsistema.master_login.user_login_btn")</button>
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
<script src="{{ url('assets/plugins/select2/js/select2.min.js') }}"></script>
<script type="text/javascript">
    
    $( document ).ready(function() {
        $("#users_acc").select2();
        
        
        $('#loginForm').parsley().on('field:validated', function () {
            //console.log("form error");
        })
        .on('form:submit', function () {
            //console.log("submit form");
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
            let email = $('#admin_email').val();
            let password = $('#password').val();
            $('#loginFormButton').html('<i class="fa fa-circle-o-notch fa-spin m-r-10"></i> @lang("frontsistema.master_login.please_wait")');
            $('#loginFormButton').prop("disabled", true);

            $.ajax({
                type: 'POST',
                dataType: 'json',
                data: {'_token':token,'email':email,'password':password},
                url: "{{ url('master_admin_authentication') }}",
                beforeSend: function() {
                    //$('#modal-espere').modal('show');
                },
                success: function(response) {
                    if (response.error && response.code == '500')
                    {
                        $('#errorMsg').html(response.message);
                        $('#errorMsg').show();
                    }
                    else if(!response.error && response.code == '200')
                    {
                        var result = response.result;
                        $("#users_acc").select2('val','');

                        var users = '';
                        for(var x in response['result'])
                        {
                            users += '<option value="'+response['result'][x].id+'">'+response['result'][x].account_number+' - '+response['result'][x].client_name+'</option>';
                        }
                        
                        $("#users_acc").html(users);
                        $('#loginForm').hide();
                        $('#mainLoginForm').show();
                    }
                },
                error: function(response) {
                    $('#errorMsg').html('@lang("frontsistema.master_login.something_wrong_msg")');
                    $('#errorMsg').show();
                },
                complete: function() {
                    $('#loginFormButton').html('@lang("frontsistema.master_login.admin_login_btn")');
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
            let user_login = $("#users_acc").select2('val');;
            $('#mainLoginFormButton').html('<i class="fa fa-circle-o-notch fa-spin m-r-10"></i> @lang("frontsistema.master_login.please_wait")');
            $('#mainLoginFormButton').prop("disabled", true);

            $.ajax({
                type: 'POST',
                dataType: 'json',
                data: {'_token':token,'user_id':user_login, 'master_password':$('#master_password').val()},
                url: "{{ url('ajax_auth_admin_as_client') }}",
                beforeSend: function() {
                    //$('#modal-espere').modal('show');
                },
                success: function(response) {
                    if (response.error && response.code == '500'){
                        $('#mainErrorMsg').html(response.message);
                        $('#mainErrorMsg').show();
                    
                    }
                    else if(!response.error && response.code == '200'){
                       
                       window.location.href = '{{ url("user/inicio") }}';
                    }
                    $('#mainLoginFormButton').html('@lang("frontsistema.master_login.user_login_btn")');
                    $('#mainLoginFormButton').prop("disabled", false);
                },
                error: function(response) {
                    $('#mainErrorMsg').html('@lang("frontsistema.master_login.something_wrong_msg")');
                    $('#mainErrorMsg').show();
                },
                complete: function() {
                    $('#mainLoginFormButton').html('@lang("frontsistema.master_login.user_login_btn")');
                    $('#mainLoginFormButton').prop("disabled", false);
                }
            });
       } catch (error) {
           console.log(error)
       }
   }
</script>
@endsection