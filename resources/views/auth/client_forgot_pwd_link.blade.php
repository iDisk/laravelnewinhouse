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
                                <h4 class="page-title text-center float-none">@lang('frontsistema.forgot_password_link.title')</h4>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
                    <div class="account-content">
                        @if($link_expire == true)
                            <div class="alert alert-warning m-t-30">@lang('frontsistema.forgot_password_link.link_expired')</div>
                        @else
                        <!-- first step of forgot password starts -->
                        <form class="form-horizontal" id="forgotPasswordLinkForm" >
                            <input type="hidden" id="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="user" id="user" value="{{ $user_id }}">
                            <div class="form-group m-b-25">
                                <div class="col-12">
                                    <label class="font-600" for="user_login">@lang('frontsistema.forgot_password_link.user')</label>
                                    <input class="form-control input-lg input-black" type="text" id="user_login" name="user_login" data-parsley-trigger="change" required value="" placeholder="@lang('frontsistema.forgot_password_link.user')" tabindex="1">
                                    <div class="form-error">@lang('frontsistema.forgot_password_link.user_err')</div>
                                </div>
                            </div>
                            <div class="form-group m-b-25">
                                <div class="col-12">
                                    <label class="font-600" for="new_password">@lang('frontsistema.forgot_password_link.new_password')</label>
                                    <input class="form-control input-lg input-black" type="password" id="new_password" name="new_password" data-parsley-trigger="change" required value="" placeholder="@lang('frontsistema.forgot_password_link.new_password')" tabindex="2">
                                    <div class="form-error">@lang('frontsistema.forgot_password_link.new_password_err')</div>
                                </div>
                            </div>
                            <div class="form-group m-b-25">
                                <div class="col-12">
                                    <label class="font-600" for="confirm_password">@lang('frontsistema.forgot_password_link.confirm_password')</label>
                                    <input class="form-control input-lg input-black" type="password" id="confirm_password" name="confirm_password" data-parsley-trigger="change" required data-parsley-equalto="#new_password" value="" placeholder="@lang('frontsistema.forgot_password_link.confirm_password')" tabindex="3">
                                    <div class="form-error">@lang('frontsistema.forgot_password_link.confirm_password_err')</div>
                                    <div class="alert alert-warning m-t-30" id="mainErrorMsg" style="display:none"></div>
                                </div>
                            </div>
                            <div class="form-group account-btn1 m-t-10">
                                <div class="col-12">
                                    <button id="forgotPasswordLinkButton" class="btn w-lg btn-lg btn-black waves-effect waves-light" type="submit">@lang('frontsistema.forgot_password_link.change_password_btn')</button>
                                </div>
                            </div>
                        </form>
                        <!-- first step of forgot password ends -->
                        @endif
                        <div class="alert alert-success m-t-30" id="mainSuccessMsg" style="display:none"></div>
                        <div class="row" id="back-btn-div" style="display: none;">
                            <div class="form-group account-btn1 m-t-10">
                                <div class="col-12">
                                    <a class="btn w-lg btn-lg btn-black waves-effect waves-light" href="{{ url('user_login') }}">@lang('frontsistema.forgot_password_link.back_button')</a>
                                </div>
                            </div>
                        </div>
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
        
        $('#forgotPasswordLinkForm').parsley().on('field:validated', function () {
            //console.log("form error");
        })
        .on('form:submit', function () {
            submitFirstForm();
            return false; // Don't submit form for this demo
        });                        
    });

    function submitFirstForm(){
        try {
            
            $('#mainErrorMsg').hide();
            $('#mainErrorMsg').html('');

            let token = $('#_token').val();
            let user_login = $('#user_login').val();            
            let new_password = $('#new_password').val();
            let user = $('#user').val();
            $('#forgotPasswordLinkButton').html('<i class="fa fa-circle-o-notch fa-spin m-r-10"></i> @lang("frontsistema.forgot_password_link.please_wait")');
            $('#forgotPasswordLinkButton').prop("disabled", true);


            $.ajax({
                type: 'POST',
                dataType: 'json',
                data: {'_token':token,'user_login':user_login,'new_password':new_password,'user':user},
                url: "{{ url('forgot-password-link') }}",
                beforeSend: function() {
                    //$('#modal-espere').modal('show');
                },
                success: function(response) {
                    if (response.error && response.code == '500'){
                        $('#mainErrorMsg').show();
                        $('#mainErrorMsg').html(response.message);
                    }
                    else if(!response.error && response.code == '200'){
                        $('#forgotPasswordLinkForm').hide();
                        
                        $('#mainSuccessMsg').html(response.message);
                        $('#mainSuccessMsg').show();
                        $('#back-btn-div').show();
                    }
                },
                error: function(response) {
                    $('#mainErrorMsg').show();
                    $('#mainErrorMsg').html('@lang("frontsistema.went_wrong_msg")');
                },
                complete: function() {
                    $('#forgotPasswordLinkButton').html('@lang("frontsistema.forgot_password_link.change_password_btn")');
                    $('#forgotPasswordLinkButton').prop("disabled", false);
                }
            });
        } catch (error) {
            //console.log(error);
        }
    }

</script>
@endsection