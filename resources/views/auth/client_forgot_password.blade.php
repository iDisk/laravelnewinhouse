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
                                <h4 class="page-title text-center float-none">@lang('frontsistema.forgot_password.title')</h4>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
                    <div class="account-content">
                        <!-- first step of forgot password starts -->
                        <form class="form-horizontal" id="loginForm" >
                            <input type="hidden" id="_token" value="{{ csrf_token() }}">
                            <div class="form-group m-b-25">
                                <div class="col-12">
                                    <label class="font-600" for="username">@lang('frontsistema.forgot_password.field_user')</label>
                                    <input class="form-control input-lg input-black" type="text" id="username" name="username" data-parsley-trigger="change" required value="" placeholder="@lang('frontsistema.forgot_password.field_user')" tabindex="1">
                                    <div class="form-error">@lang('frontsistema.forgot_password.field_user_error')</div>
                                    <div class="alert alert-warning m-t-10" id="errorMsg" style="display:none"></div>
                                </div>
                            </div>
                            <div class="form-group account-btn1 m-t-10">
                                <div class="col-12">
                                    <button id="loginFormButton" class="btn w-lg btn-lg btn-black waves-effect waves-light" type="submit">@lang('frontsistema.forgot_password.next_button')</button>
                                </div>
                            </div>
                        </form>
                        <!-- first step of forgot password ends -->

                        <!-- main questiion1 form starts -->
                        <form class="form-horizontal" id="firstQuestionForm" style="display:none">
                            <input type="hidden" id="_token" value="{{ csrf_token() }}">
                            <div class="form-group m-b-25">
                                <div class="col-12">
                                    <label class="font-600" for="first_questions">@lang('frontsistema.forgot_password.question1')</label>
                                    <select class="form-control input-lg input-black" id="first_questions" name="first_questions" data-parsley-trigger="change" required tabindex="1">
                                        <option value="">@lang('frontsistema.forgot_password.select_question')</option>
                                    </select>
                                    <div class="form-error">@lang('frontsistema.forgot_password.question_error')</div>
                                </div>
                            </div>
                            <div class="form-group m-b-25">
                                <div class="col-12">
                                    <label class="font-600" for="first_answer">@lang('frontsistema.forgot_password.answer')</label>
                                    <input class="form-control input-lg input-black" type="text" id="first_answer" name="first_answer" data-parsley-trigger="change" required value="" placeholder="@lang('frontsistema.forgot_password.answer')" tabindex="2">
                                    <div class="form-error">@lang('frontsistema.forgot_password.field_user_error')</div>
                                </div>
                            </div>
                            <div class="form-group account-btn1 m-t-10">
                                <div class="col-12">
                                    <button id="mainLoginFormButton" class="btn w-lg btn-lg btn-black waves-effect waves-light" type="submit">@lang('frontsistema.forgot_password.next_button')</button>
                                </div>
                            </div>
                        </form>
                        <!-- main questiion1 form starts -->

                        <!-- main questiion2 form starts -->
                        <form class="form-horizontal" id="secondQuestionForm" style="display:none">
                            <input type="hidden" id="_token" value="{{ csrf_token() }}">
                            <div class="form-group m-b-25">
                                <div class="col-12">
                                    <label class="font-600" for="second_questions">@lang('frontsistema.forgot_password.question2')</label>
                                    <select class="form-control input-lg input-black" name="second_questions" id="second_questions" data-parsley-trigger="change" required tabindex="1">
                                        <option value="">@lang('frontsistema.forgot_password.select_question')</option>
                                    </select>
                                    <div class="form-error">@lang('frontsistema.forgot_password.question_error')</div>
                                </div>
                            </div>
                            <div class="form-group m-b-25">
                                <div class="col-12">
                                    <label class="font-600" for="second_answer">@lang('frontsistema.forgot_password.answer')</label>
                                    <input class="form-control input-lg input-black" type="text" id="second_answer" name="second_answer" data-parsley-trigger="change" required value="" placeholder="@lang('frontsistema.forgot_password.answer')" tabindex="2">
                                    <div class="form-error">@lang('frontsistema.forgot_password.field_user_error')</div>
                                </div>
                            </div>                      
                            
                            <div class="form-group account-btn1 m-t-10">
                                <div class="col-12">
                                    <button id="mainLoginFormButton" class="btn w-lg btn-lg btn-black waves-effect waves-light" type="submit">@lang('frontsistema.forgot_password.next_button')</button>
                                </div>
                            </div>
                        </form>
                        <!-- main questiion2 form starts -->

                        <!-- main questiion3 form starts -->
                        <form class="form-horizontal" id="thirdQuestionForm" style="display:none">
                            <input type="hidden" id="_token" value="{{ csrf_token() }}">
                            <div class="form-group m-b-25">
                                <div class="col-12">
                                    <label class="font-600" for="third_questions">@lang('frontsistema.forgot_password.question3')</label>
                                    <select class="form-control input-lg input-black" id="third_questions" name="third_questions" data-parsley-trigger="change" required tabindex="1">
                                        <option value="">@lang('frontsistema.forgot_password.select_question')</option>
                                    </select>
                                    <div class="form-error">@lang('frontsistema.forgot_password.question_error')</div>
                                </div>
                            </div>
                            <div class="form-group m-b-25">
                                <div class="col-12">
                                    <label class="font-600" for="third_answer">@lang('frontsistema.forgot_password.answer')</label>
                                    <input class="form-control input-lg input-black" type="text" id="third_answer" name="third_answer" data-parsley-trigger="change" required value="" placeholder="@lang('frontsistema.forgot_password.answer')" tabindex="2">
                                    <div class="form-error">@lang('frontsistema.forgot_password.field_user_error')</div>
                                </div>
                            </div>
                            <div class="form-group account-btn1 m-t-10">
                                <div class="col-12">
                                    <button id="thirdQuestionFormBtn" class="btn w-lg btn-lg btn-black waves-effect waves-light" type="submit">@lang('frontsistema.forgot_password.next_button')</button>
                                </div>
                            </div>
                        </form>
                        <!-- main questiion3 form starts -->
                        <div class="alert alert-success m-t-30" id="mainSuccessMsg" style="display:none"></div>
                        <div class="alert alert-warning m-t-30" id="mainErrorMsg" style="display:none"></div>
                        <div class="row" id="back-btn-div" style="display: none;">
                            <div class="form-group account-btn1 m-t-10">
                                <div class="col-12">
                                    <a class="btn w-lg btn-lg btn-black waves-effect waves-light" href="{{ url('user_login') }}">@lang('frontsistema.forgot_password.back_button')</a>
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
        
        $('#loginForm').parsley().on('field:validated', function () {
            //console.log("form error");
        })
        .on('form:submit', function () {
            submitFirstForm();
            return false; // Don't submit form for this demo
        });

        $('#firstQuestionForm').parsley().on('field:validated', function () {
            //console.log("form error");
        })
        .on('form:submit', function () {
            $('#firstQuestionForm').hide();
            $('#secondQuestionForm').show();
            return false; // Don't submit form for this demo
        });

        $('#secondQuestionForm').parsley().on('field:validated', function () {
            //console.log("form error");
        })
        .on('form:submit', function () {
            $('#secondQuestionForm').hide();
            $('#thirdQuestionForm').show();
            return false; // Don't submit form for this demo
        });

        $('#thirdQuestionForm').parsley().on('field:validated', function () {
            //console.log("form error");
        })
        .on('form:submit', function () {
            submitFinal();
            return false; // Don't submit form for this demo
        });
        
                        
    });
    function submitFirstForm(){  
        try {
            $('#errorMsg').hide();
            let token = $('#_token').val();
            let user_login = $('#username').val();
            $('#loginFormButton').html('<i class="fa fa-circle-o-notch fa-spin m-r-10"></i> @lang("frontsistema.forgot_password.please_wait")');
            $('#loginFormButton').prop("disabled", true);

            $.ajax({
                type: 'POST',
                dataType: 'json',
                data: {'_token':token,'user_login':user_login},
                url: "{{ url('user_security_questions') }}",
                beforeSend: function() {
                    //$('#modal-espere').modal('show');
                },
                success: function(response) {
                    if (response.error && response.code == '500'){
                        $('#errorMsg').html(response.message);
                        $('#errorMsg').show();
                    }
                    else if(!response.error && response.code == '200'){
                        
                        var html = '';

                        if(response.data.first_questions != null){
                            html = '<option value="'+ response.data.first_questions.id +'">'+ response.data.first_questions.question +'</option>';
                        }else{
                            html = '<option value=""></option>';
                        }
                        $('#first_questions').html(html);

                        if(response.data.second_questions != null){
                            html = '<option value="'+ response.data.second_questions.id +'">'+ response.data.second_questions.question +'</option>';
                        }else{
                            html = '<option value=""></option>';
                        }
                        $('#second_questions').html(html);

                        if(response.data.third_questions != null){
                            html = '<option value="'+ response.data.third_questions.id +'">'+ response.data.third_questions.question +'</option>';
                        }else{
                            html = '<option value=""></option>';
                        }
                        $('#third_questions').html(html);

                        $('#loginForm').hide();
                        $('#firstQuestionForm').show();
                    }
                    $('#loginFormButton').html('@lang("frontsistema.forgot_password.next_button")');
                    $('#loginFormButton').prop("disabled", false);
                },
                error: function(response) {
                    //console.error(response);
                     $('#loginFormButton').html('@lang("frontsistema.forgot_password.next_button")');
                    $('#loginFormButton').prop("disabled", false);
                    // swal("@lang('frontsistema.users_alert')", "@lang('frontsistema.control_de_acceso.went_wrong_msg')", 'error');
                
                },
                complete: function() {
                    $('#loginFormButton').html('@lang("frontsistema.forgot_password.next_button")');
                    $('#loginFormButton').prop("disabled", false);
                }
            });
        } catch (error) {
            console.log(error);
        }
    }

    function submitFinal()
    {
        try
        {
            $('#thirdQuestionFormBtn').html('<i class="fa fa-circle-o-notch fa-spin m-r-10"></i> @lang("frontsistema.forgot_password.please_wait")');
            $('#thirdQuestionFormBtn').prop("disabled", true);

            let token = $('#_token').val();
            let user_login = $('#username').val();

            $('#mainSuccessMsg').html('');
            $('#mainErrorMsg').html('');

            $('#mainSuccessMsg').hide();
            $('#mainErrorMsg').hide();

            var data = {
                    '_token':token,
                    'user_login':user_login,
                    'question1':$('#first_questions').val(),
                    'question2':$('#second_questions').val(),
                    'question3':$('#third_questions').val(),
                    'answer1':$('#first_answer').val(),
                    'answer2':$('#second_answer').val(),
                    'answer3':$('#third_answer').val(),
            };

            $.ajax({
                type: 'POST',
                dataType: 'json',
                data: data,
                url: "{{ url('ajax_check_security_question') }}",
                beforeSend: function() {
                    //$('#modal-espere').modal('show');
                },
                success: function(response) {
                    if (response.error && response.code == '500'){
                        $('#mainErrorMsg').html(response.message);
                        $('#mainErrorMsg').show();
                        $('#back-btn-div').show();
                        $('#thirdQuestionForm').hide();
                    }
                    else if(!response.error && response.code == '200'){
                        $('#mainSuccessMsg').html(response.message);
                        $('#mainSuccessMsg').show();
                        $('#back-btn-div').show();
                        $('#thirdQuestionForm').hide();
                    }
                },
                error: function(response) {
                
                },
                complete: function() {
                    $('#thirdQuestionFormBtn').html('@lang("frontsistema.forgot_password.next_button")');
                    $('#thirdQuestionFormBtn').prop("disabled", false);
                }
            }); 

        } catch (error) {
            console.log(error);
        }
        //alert('test');
    }
</script>
@endsection