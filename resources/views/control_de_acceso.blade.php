@extends('layouts.front_vertical_menu')
@section('customcss')
<link href="{{ url('assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet">
<!-- Bootstrap fileupload css -->
<link href="{{ url('assets/plugins/bootstrap-fileupload/bootstrap-fileupload.css') }}" rel="stylesheet" />
<style type="text/css">
    .checkbox .cr, .radio .cr{
        width: 18px;
        height: 18px;
    }
    .checkbox label, .radio label{
        font-weight: 600; 
    }
    .cancel_btn{
        text-decoration: underline;
    }
    .send-codigo{
        width: 100%;
    }
    .on_load{
        /*display: none;*/
    }
    .on_mobValidate, .on_successDiv{
        display: none;
    }
    .img-wrapper{
        height: 130px;
        width: auto;
        border: 1px solid #dee2e6;
        border-radius: .25rem;
        margin: 10px;
    }
    .img-inner{
        height: 100%;
        width: 100%;
        padding: 5px;
    }
    .img-selected{
        border: 8px solid !important;
        /* border-color: #8cd5dd  !important */
    }
</style>
@endsection

@section('pagecontent')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">@lang('frontsistema.control_de_acceso.title')</h4>
                <div class="web_logo">
                    <img class="" src="{{ url('assets/images/logo_espacios.png')}}" alt="" height="50">
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
    <!-- end row -->
    <div class="row on_load">
        <div class="col-lg-12">
            <label class="font-700 font-16">@lang('frontsistema.control_de_acceso.user_change')</label>
        </div>
    </div>
    <input type="hidden" id="_token" value="{{ csrf_token() }}">
    <form id="control_de_acceso_form" class="on_load">
        <div class="row">
            <div class="col-lg-12 col-xl-10">
                <div class="row">
                    <div class="col-lg-4">
                        <br><label class="font-600 m-t-10">@lang('frontsistema.control_de_acceso.current_user'): {{isset($user_login)?$user_login:''}} </label>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="inputtfamodify_limit" class="font-700 font-11">@lang('frontsistema.control_de_acceso.modify_user')</label>
                            <input type="text" class="form-control input-black" id="modify_user" name="modify_user"  guardar="SI">
                            <div class="form-error">@lang('frontsistema.control_de_acceso.modify_user_error')</div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="inputtfaconfirm_limit" class="font-700 font-11">@lang('frontsistema.control_de_acceso.confirm_new_user')</label>
                            <input type="text" class="form-control input-black" id="confirm_modify_user" name="confirm_modify_user"  data-parsley-equalto='#modify_user' data-parsley-trigger="change" >
                            <div class="form-error">@lang('frontsistema.control_de_acceso.confirm_new_user_error')</div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4">
                        <br><label class="font-600 m-t-10">@lang('frontsistema.control_de_acceso.change_password')</label>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="inputtfamodify_limit" class="font-700 font-11">@lang('frontsistema.control_de_acceso.modify_password')</label>
                            <input type="password" class="form-control input-black" id="modify_password" name="modify_password" data-parsley-maxlength="20" data-parsley-minlength="6" guardar="SI">
                            <div class="form-error">@lang('frontsistema.control_de_acceso.modify_password_error')</div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="inputtfaconfirm_limit" class="font-700 font-11">@lang('frontsistema.control_de_acceso.confirm_password')</label>
                            <input type="password" class="form-control input-black" id="confirm_password" name="confirm_password" data-parsley-equalto='#modify_password' data-parsley-maxlength="20" data-parsley-minlength="6" data-parsley-trigger="change" >
                            <div class="form-error">@lang('frontsistema.control_de_acceso.confirm_password_error')</div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-xs-12">
                        <br><label class="font-600 m-t-10">@lang('frontsistema.control_de_acceso.select_security_image')</label>
                    </div>
                    <div class="col-xl-8 col-lg-8 col-md-12 col-sm-12 col-xs-12">
                        <div class="row">
                            @foreach ($security_images as $item)
                                <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-xs-6">
                                    <div class="img-wrapper selectImg" data-id="{{$item->image}}">
                                        <img src="{{$item->image}}" class="img-inner" >
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <input type="hidden" name="user_security_img" id="user_security_img" value="" guardar="SI" required data-parsley-trigger="change">
                        <div class="form-error">@lang('frontsistema.control_de_acceso.user_security_img_error')</div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-xs-12">
                        <br><label class="font-600 m-t-10">@lang('frontsistema.control_de_acceso.select_security_question')</label>
                    </div>
                    <div class="col-xl-8 col-lg-8 col-md-12 col-sm-12 col-xs-12 m-t-10">
                        <div class="row">
                            <div class="col-xl-12 col-lg-12 m-b-10 font-600">
                                @lang('frontsistema.control_de_acceso.question_type') 1
                            </div>
                            <div class="col-xl-12 col-lg-12">
                                 <select class="form-control input-black" id="security_question_1" name="security_question_1" data-parsley-trigger="change" required guardar="SI">
                                    @foreach($security_questions1 as $key=>$value)
                                        <option value="{{ $value }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                                <div class="form-error">@lang('frontsistema.control_de_acceso.security_question_error')</div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="inputtfamodify_limit">@lang('frontsistema.control_de_acceso.secret_question_answer')</label>
                                    <input type="text" class="form-control input-black" id="secret_question_answer_1" name="secret_question_answer_1" required guardar="SI">
                                    <div class="form-error">@lang('frontsistema.control_de_acceso.secret_question_answer_error')</div>
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="inputtfaconfirm_limit">@lang('frontsistema.control_de_acceso.confirm_secret_question_answer')</label>
                                    <input type="text" class="form-control input-black" id="confirm_secret_question_answer_1" name="confirm_secret_question_answer_1"  data-parsley-equalto='#secret_question_answer_1' required data-parsley-trigger="change" >
                                    <div class="form-error">@lang('frontsistema.control_de_acceso.confirm_secret_question_answer_error')</div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-12 col-lg-12 m-b-5 font-600">
                                @lang('frontsistema.control_de_acceso.question_type') 2
                            </div>
                            <div class="col-xl-12 col-lg-12">
                                 <select class="form-control input-black" id="security_question_2" name="security_question_2" data-parsley-trigger="change" value="" required guardar="SI">
                                    @foreach($security_questions2 as $key=>$value)
                                        <option value="{{ $value }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                                <div class="form-error">@lang('frontsistema.control_de_acceso.security_question_error')</div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="inputtfamodify_limit">@lang('frontsistema.control_de_acceso.secret_question_answer')</label>
                                    <input type="text" class="form-control input-black" id="secret_question_answer_2" name="secret_question_answer_2" required  guardar="SI">
                                    <div class="form-error">@lang('frontsistema.control_de_acceso.secret_question_answer_error')</div>
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="inputtfaconfirm_limit">@lang('frontsistema.control_de_acceso.confirm_secret_question_answer')</label>
                                    <input type="text" class="form-control input-black" id="confirm_secret_question_answer_2" name="confirm_secret_question_answer_2" required  data-parsley-equalto='#secret_question_answer_2' data-parsley-trigger="change" >
                                    <div class="form-error">@lang('frontsistema.control_de_acceso.confirm_secret_question_answer_error')</div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-12 col-lg-12 m-b-5 font-600">
                                @lang('frontsistema.control_de_acceso.question_type') 3
                            </div>
                            <div class="col-xl-12 col-lg-12">
                                 <select class="form-control input-black" id="security_question_3" name="security_question_3" data-parsley-trigger="change" value="" required guardar="SI">
                                    @foreach($security_questions3 as $key=>$value)
                                        <option value="{{ $value }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                                <div class="form-error">@lang('frontsistema.control_de_acceso.security_question_error')</div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="inputtfamodify_limit">@lang('frontsistema.control_de_acceso.secret_question_answer')</label>
                                    <input type="text" class="form-control input-black" id="secret_question_answer_3" name="secret_question_answer_3" required  guardar="SI">
                                    <div class="form-error">@lang('frontsistema.control_de_acceso.secret_question_answer_error')</div>
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="inputtfaconfirm_limit">@lang('frontsistema.control_de_acceso.confirm_secret_question_answer')</label>
                                    <input type="text" class="form-control input-black" id="confirm_secret_question_answer_3" name="confirm_secret_question_answer_3" required data-parsley-equalto='#secret_question_answer_3' data-parsley-trigger="change" >
                                    <div class="form-error">@lang('frontsistema.control_de_acceso.confirm_secret_question_answer_error')</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4">
                        <br><label class="font-600 m-t-10">@lang('frontsistema.control_de_acceso.security_phrase')</label>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="inputtfamodify_limit" class="">@lang('frontsistema.control_de_acceso.security_phrase')</label>
                            <input type="text" class="form-control input-black" id="security_phrase" name="security_phrase" guardar="SI" required>
                            <div class="form-error">@lang('frontsistema.control_de_acceso.security_phrase_error')</div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="inputtfaconfirm_limit" class="">@lang('frontsistema.control_de_acceso.security_phrase_confirm')</label>
                            <input type="text" class="form-control input-black" id="security_phrase_confirm" name="security_phrase_confirm" data-parsley-equalto='#security_phrase' required data-parsley-trigger="change" >
                            <div class="form-error">@lang('frontsistema.control_de_acceso.security_phrase_confirm_error')</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="row m-t-20">
            <div class="col-lg-12">
                <label class="font-700 font-16">@lang('frontsistema.control_de_acceso.term_n_condition')</label>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-xl-10">
                <div class="row">
                    <div class="col-lg-12">
                        <label class="font-600 m-t-10">{!! (session('language') == 'es' ? $broker_setting['access_control_tnc_es'] : $broker_setting['access_control_tnc_en']) !!}</label>
                        <div class="checkbox checkbox-custom m-t-0 line-height-20">
                            <label class="font-600">
                                <input type="checkbox" value="" id="term_n_condition" name="term_n_condition" required parsley-trigger="change">
                                <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                @lang('frontsistema.control_de_acceso.accept_text')
                            </label>
                            <div class="form-error">@lang('frontsistema.control_de_acceso.terms_error')</div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-12 col-lg-12 text-right m-t-30 m-b-15">
                    

                    <a class="text-aqua-blue m-r-10 font-16 font-600 text-uppercase cancel_btn" href="{{ route('client_home') }}">@lang('frontsistema.btn_cancel')</a>
                    
                    <button type="submit" class="btn btn-aqua-blue waves-effect waves-light p-l-r-30"> <span>@lang('frontsistema.control_de_acceso.update_btn')</span> </button>
                </div>
            </div>
        </div>
    </form>
    <!-- end row -->

    <!-- OTP validation form -->
    <div class="on_mobValidate">
        <div class="row">
            <div class="col-lg-12">
                <label class="font-700 font-16">@lang('frontsistema.validate_mob.title')</label>
            </div>
        </div>
         <input type="hidden" name="client_request_id" id="client_request_id" value="">
        
        <div class="row">
            <div class="col-lg-6 m-t-40">
                <div class="verificarFormWarning alert alert-warning d-none fade show">
                    <h4 class="text-warning mt-0">@lang('frontsistema.validate_mob.warning_title')</h4>
                    <p id="verificarWarningMsg" class="mb-0"> </p>
                </div>
                <div class="verificarFormSuccess alert alert-info d-none fade show">
                    <h4 class="alert-info mt-0">@lang('frontsistema.validate_mob.success_title')</h4>
                    <p id="verificarSuccessMsg" class="mb-0"> </p>
                </div>
                <label class="font-600">@lang('frontsistema.validate_mob.enter_registered_mobile')</label>
            </div>
            <div class="col-lg-12 m-t-5 m-b-5">
                
            </div>
            <div class="col-xl-6 col-md-6">
                <div class="row">
                    <div class="col-xl-6 col-md-6">
                        <div class="form-group">
                            <label for="inputmob_codigo" class="font-700 font-11">@lang('frontsistema.validate_mob.code')</label>
                            <input type="text" class="form-control input-black" id="inputmob_codigo" name="mob_codigo" guardar="SI">
                            <div id="code_error" class="form-error">@lang('frontsistema.validate_mob.code_error')</div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-md-6 ">
                        <label  class="font-700 font-11">&nbsp;</label>
                        <button type="button" id="verificar_codigo" class="btn btn-aqua-blue waves-effect waves-light send-codigo"> <span>@lang('frontsistema.validate_mob.send')</span> </button>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <label class="font-600 m-0"><a id="generar_codigo" href="javascript:void(0);" class="text-aqua-blue text-underline">@lang('frontsistema.validate_mob.send_new_code')</a></label>
            </div>
            <div class="col-lg-12">
                <label class="font-600 m-t-40">@lang('frontsistema.validate_mob.contact_msg1') <a href="javascript:void(0);" class="text-custom-info text-underline open_contact_us_form">@lang('frontsistema.validate_mob.contact_msg2')</a></label>
            </div>
        </div>
    </div>
    <!-- OTP validation form -->

    <!-- Success message -->
    <div class="row on_successDiv m-t-50">
        <div class="col-lg-12 text-center">
            <h3 class="font-600">@lang('frontsistema.validate_mob.success_msg_title')</h3>
            <p class="text-custom-info font-600 font-16">@lang('frontsistema.validate_mob.success_msg')</p>
            <a class="text-aqua-blue m-t-20 cursor-pointer line-height-35" href="{{ route('client_home') }}">@lang('frontsistema.diversifique.back_to_home')</a>
        </div>
    </div>
    <!-- Success message -->

</div> <!-- container-fluid -->
@endsection
@section('customjs')
<!-- Bootstrap fileupload js -->
<script src="{{ url('assets/plugins/bootstrap-fileupload/bootstrap-fileupload.js') }}"></script>
<script src="https://www.google.com/recaptcha/api.js?hl={{ session('language') }}" async defer></script>
<script src="{{ url('assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ url('assets/plugins/bootstrap-datepicker/locales/bootstrap-datepicker.es.js') }}"></script>

<script type="text/javascript">

    $('#control_de_acceso_form').parsley().on('field:validated', function () {
        //console.log("form error");
    })
    .on('form:submit', function () {
        
        //console.log("submit form");
        submitControlDeAccesoForm();
        return false; // Don't submit form for this demo
    });

    function submitControlDeAccesoForm(){
        var mu = $('#modify_user').val();
        var cmu = $('#confirm_modify_user').val();
        var mp = $('#modify_password').val();
        var cp = $('#confirm_password').val();
        if((mu == '' || mu == undefined) && (mp == '' || mp == undefined)){
            swal("@lang('frontsistema.users_alert')", "@lang('frontsistema.control_de_acceso.user_password_error')", 'error');
            return;
        }
        else if($('#user_security_img').val()=='' || $('#user_security_img').val()==undefined){
            swal("@lang('frontsistema.users_alert')", "@lang('frontsistema.control_de_acceso.user_security_img_error')", 'error');
            return;
        }
        else{
            if((mu != '' && mu != undefined) && mu != cmu){
                swal("@lang('frontsistema.users_alert')", "@lang('frontsistema.control_de_acceso.confirm_new_user_error')", 'error');
                return;
            }
            if((mp != '' && mp != undefined) && mp != cp){
                swal("@lang('frontsistema.users_alert')", "@lang('frontsistema.control_de_acceso.modify_password_error')", 'error');
                return;
            }
        }

        let token = $('#_token').val();

        let req_data = '{';

        $('#control_de_acceso_form').find(':input').each(function() 
        {
            if($(this).attr("guardar")=="SI")
            {
                if(req_data != '{'){
                     req_data += ',';
                }
                req_data += '"'+ $(this).attr("name") +'":{"type":"text","value":"'+$(this).val()+'"}'; 
            }

            if($(this).attr("guardar-chk")=="SI" && $(this).prop("checked") == true)
            {
                if(req_data != '{'){
                     req_data += ',';
                }
                req_data += '"'+ $(this).attr("name") +'":{"type":"text","value":"'+$(this).val()+'"}'; 
            }

        });

        req_data += '}';


        show_loader(true);

        $.ajax({
            type: 'POST',
            dataType: 'json',
            data: {'_token':token,'text':req_data,'request_type_id':22,'verify':1,'from':'Control de Acceso'},
            url: "{{ url('user/client_request') }}",
            beforeSend: function() {
                //$('#modal-espere').modal('show');
            },
            success: function(response) {
                if (response.error && response.code == '500'){

                    $('#verificarWarningMsg').html(response.message);
                    $('.verificarFormWarning').toggleClass('d-none', false);
                }
                else if(!response.error && response.code == '200'){
                    $('#request_folio_number').html(response.filio_number);
                    $('#client_request_id').val(response.client_request_id);
                    $('.on_load').hide();
                    $('.on_mobValidate').show();
                    window.scrollTo(0, 0);
                }
            },
            error: function(response) {
                //console.error(response);
                swal("@lang('frontsistema.users_alert')", "@lang('frontsistema.control_de_acceso.went_wrong_msg')", 'error');
            },
            complete: function() {
                show_loader(false);
            }
        });
    }

    function recaptchaCallback(){
        $('#recaptcha_error').hide();
    }

    $('#generar_codigo').click(function(){

        show_loader(true);

        $('.verificarFormSuccess').toggleClass('d-none', true);
        $('.verificarFormWarning').toggleClass('d-none', true);

        let token = $('#_token').val();

        $.ajax({
            type: 'POST',
            dataType: 'json',
            data: {'_token':token},
            url: "{{ url('user/generate_code') }}",
            beforeSend: function() {
                //$('#modal-espere').modal('show');
            },
            success: function(response) {
                if (response.error && response.code == '500'){
                   
                    $('#verificarWarningMsg').html(response.message);
                    $('.verificarFormWarning').toggleClass('d-none', false);
                }
                else if(!response.error && response.code == '200'){

                    $('#verificarSuccessMsg').html(response.message);
                    $('.verificarFormSuccess').toggleClass('d-none', false);
                }
            },
            error: function(response) {
                //console.error(response);
                swal("@lang('frontsistema.users_alert')", "@lang('frontsistema.control_de_acceso.went_wrong_msg')", 'error');
            },
            complete: function() {
                show_loader(false);
            }
        });
    });


    $('#verificar_codigo').click(function() {
        
        $('.verificarFormSuccess').toggleClass('d-none', true);
        $('.verificarFormWarning').toggleClass('d-none', true);

        //basic validation
        // var v = grecaptcha.getResponse();
        var list =0;
        let code = $('#inputmob_codigo').val();

        $('#recaptcha_error').hide();
        $('#code_error').hide();
        // if(v.length == 0)
        // {
        //     list = 1;
        //     $('#recaptcha_error').show();
        // }
        if(code == '')
        {
            list = 1;
            $('#code_error').show();
        }

        if(list == 1){
            return true;
        }
        //Ajax call to check OTP
        show_loader(true);

        let client_request_id = $('#client_request_id').val();
        let token = $('#_token').val();

        $.ajax({
            type: 'POST',
            dataType: 'json',
            data: {'_token':token,'client_request_id':client_request_id,'code':code},
            url: "{{ url('user/verify_request') }}",
            beforeSend: function() {
                //$('#modal-espere').modal('show');
            },
            success: function(response) {
                if (response.error && response.code == '500'){

                    $('#verificarWarningMsg').html(response.message);
                    $('.verificarFormWarning').toggleClass('d-none', false);
                }
                else if(!response.error && response.code == '200'){
                    //$('#request_folio_number').html(response.filio_number);
                    $('.on_load').hide();
                    $('.on_mobValidate').hide();
                    window.scrollTo(0, 0);
                    $('.on_successDiv').show();
                }
            },
            error: function(response) {
                //console.error(response);
                swal("@lang('frontsistema.users_alert')", "@lang('frontsistema.control_de_acceso.went_wrong_msg')", 'error');
            },
            complete: function() {
                show_loader(false);
            }
        });
    });

    $('.selectImg').click(function(){
        $('.img-wrapper').removeClass('img-selected');
        $(this).addClass('img-selected');
        $('#user_security_img').val($(this).attr("data-id"));
        // $('#user_security_img').trigger('change');
    })
</script>
@endsection