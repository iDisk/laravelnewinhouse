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
    .btn-file-cross {
        background-color: red;
        color: white;
        text-shadow: none;
    }
    .additional_blocks{
        width: 100%;
    }
    #btnAddMoreFiles{
        margin-bottom:9px; 
    }
</style>
@endsection

@section('pagecontent')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">@lang('frontsistema.administracion_cuenta.title')</h4>
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
            <div class="card help_card_widget">
                <div class="card-body">
                    <p class="m-0">
                        @lang('frontsistema.administracion_cuenta.help_msg_title')
                    </p>
                    <p class="m-0">
                        @lang('frontsistema.administracion_cuenta.help_msg')
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div class="row on_load">
        <div class="col-lg-12">
            <label class="font-700 font-16">@lang('frontsistema.administracion_cuenta.daily_limits')</label>
        </div>
    </div>
    <input type="hidden" id="_token" value="{{ csrf_token() }}">
    <form id="administracion_de_cuentasForm" class="on_load" enctype="multipart/form-data">
        <div class="row">
            <div class="col-lg-12 col-xl-10">
                <div class="row">
                    <div class="col-lg-3">
                        <br>
                        <div class="checkbox checkbox-custom m-t-10 line-height-20">
                            <label class="font-600">
                                <input type="checkbox" id="transpo_entre_cuentas" value="@lang('frontsistema.administracion_cuenta.transfer_accounts')" name="chk_limit" class="chk_limit" data-textclass="transpo_entre_cuentas_text">
                                <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                @lang('frontsistema.administracion_cuenta.transfer_accounts')
                            </label>
                        </div>
                    </div>
                    <div class="col-lg-1">
                        <br><label class="font-600 m-t-10 pull-right">{{ isset($primary_account) ? $primary_account->transfer_internal_account : 00.00 }}</label>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="inputtfamodify_limit" class="font-700 font-11">@lang('frontsistema.administracion_cuenta.modify_limit')</label>
                            <input class="form-control input-black autonumber transpo_entre_cuentas_text" value="0.00" type="text" readonly>
                            <input type="hidden" class="form-control input-black limit_amount" id="inputtfamodify_limit" data-section="daily_limits" name="tfamodify_limit" data-parsley-pattern="[0-9]*(.?[0-9]{1,2}$)" data-parsley-trigger="change" required guardar="SI">
                            <div class="form-error">@lang('frontsistema.administracion_cuenta.modify_limit_error')</div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="inputtfaconfirm_limit" class="font-700 font-11">@lang('frontsistema.administracion_cuenta.confirm_limit')</label>
                            <input class="form-control input-black autonumber transpo_entre_cuentas_text" value="0.00" type="text" readonly>
                            <input type="hidden" class="form-control input-black limit_amount" id="inputtfaconfirm_limit" name="tfaconfirm_limit" data-parsley-pattern="[0-9]*(.?[0-9]{1,2}$)" data-parsley-equalto='#inputtfamodify_limit' data-parsley-trigger="change" required >
                            <div class="form-error">@lang('frontsistema.administracion_cuenta.confirm_limit_error')</div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-3">
                        <br>
                        <div class="checkbox checkbox-custom m-t-10 line-height-20">
                            <label class="font-600">
                                <input type="checkbox" id="transpo_a_terceros" value="@lang('frontsistema.administracion_cuenta.transfer_third_party')" name="chk_limit" class="chk_limit" data-textclass="transpo_a_terceros_text">
                                <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                @lang('frontsistema.administracion_cuenta.transfer_third_party')
                            </label>
                        </div>
                    </div>
                    <div class="col-lg-1">
                        <br><label class="font-600 m-t-10 pull-right">{{ isset($primary_account) ? $primary_account->transfer_third_party_account : 00.00 }}</label>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="inputttpmodify_limit" class="font-700 font-11">@lang('frontsistema.administracion_cuenta.modify_limit')</label>
                            <input class="form-control input-black autonumber transpo_a_terceros_text" value="0.00" type="text" readonly >
                            <input type="hidden" class="form-control input-black limit_amount" id="inputttpmodify_limit" data-section="daily_limits" name="ttpmodify_limit" data-parsley-pattern="[0-9]*(.?[0-9]{1,2}$)" data-parsley-trigger="change" required guardar="SI">
                            <div class="form-error">@lang('frontsistema.administracion_cuenta.modify_limit_error')</div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="inputttpconfirm_limit" class="font-700 font-11">@lang('frontsistema.administracion_cuenta.confirm_limit')</label>
                            <input class="form-control input-black autonumber transpo_a_terceros_text" value="0.00" type="text" readonly >
                            <input type="hidden" class="form-control input-black limit_amount" data-parsley-pattern="[0-9]*(.?[0-9]{1,2}$)" data-parsley-equalto='#inputttpmodify_limit' id="inputttpconfirm_limit" name="ttpconfirm_limit" data-parsley-trigger="change" required >
                            <div class="form-error">@lang('frontsistema.administracion_cuenta.confirm_limit_error')</div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-3">
                        <br>
                        <div class="checkbox checkbox-custom m-t-10 line-height-20">
                            <label class="font-600">
                                <input type="checkbox" id="transferencias_internacionales" value="@lang('frontsistema.administracion_cuenta.international_transfers')" name="chk_limit" class="chk_limit" data-textclass="transferencias_internacionales_text" >
                                <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                @lang('frontsistema.administracion_cuenta.international_transfers')
                            </label>
                        </div>
                    </div>
                    <div class="col-lg-1">
                        <br><label class="font-600 m-t-10 pull-right">{{ isset($primary_account) ? $primary_account->transfer_international_account : 00.00 }}</label>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="inputtimodify_limit" class="font-700 font-11">@lang('frontsistema.administracion_cuenta.modify_limit')</label>
                            <input class="form-control input-black autonumber transferencias_internacionales_text" value="0.00" type="text" readonly >
                            <input type="hidden" class="form-control input-black limit_amount" id="inputtimodify_limit" data-section="daily_limits" name="timodify_limit"data-parsley-pattern="[0-9]*(.?[0-9]{1,2}$)" data-parsley-trigger="change" required guardar="SI">
                            <div class="form-error">@lang('frontsistema.administracion_cuenta.modify_limit_error')</div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="inputticonfirm_limit" class="font-700 font-11">@lang('frontsistema.administracion_cuenta.confirm_limit')</label>
                            <input class="form-control input-black autonumber transferencias_internacionales_text" value="0.00" type="text" readonly >
                            <input type="hidden" class="form-control input-black limit_amount" id="inputticonfirm_limit" name="ticonfirm_limit" data-parsley-pattern="[0-9]*(.?[0-9]{1,2}$)" data-parsley-equalto='#inputtimodify_limit' data-parsley-trigger="change" required >
                            <div class="form-error">@lang('frontsistema.administracion_cuenta.confirm_limit_error')</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-xl-10">
                <div class="row">
                    <div class="col-xl-9 col-lg-12 col-md-12">
                        <div class="font-16 font-700">@lang('frontsistema.administracion_cuenta.term_n_condition')</div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12">
                        <h5 class="font-14 terms-div-border">
                            {!! (session('language') == 'es' ? $broker_setting['accounts_administration_tnc_es'] : $broker_setting['accounts_administration_tnc_en']) !!}
                            <div class="checkbox checkbox-custom m-t-0 line-height-20">
                                <label class="font-600">
                                    <input type="checkbox" value="" id="term_n_condition" name="term_n_condition" required parsley-trigger="change">
                                    <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                    @lang('frontsistema.amplie_su_financiamiento.accept_text')
                                </label>
                                <div class="form-error">@lang('frontsistema.administracion_cuenta.term_error')</div>
                            </div>
                        </h5>
                    </div>
                </div>
                <div class="row m-t-30">
                    <div class="col-lg-6 col-xl-6 text-center">
                        
                    </div>
                    <div class="col-lg-6 col-xl-6 text-center">
                        <a class="text-aqua-blue m-r-10 font-16 font-600 text-uppercase cancel_btn" href="javascript:void(0);">@lang('frontsistema.btn_cancel')</a>
                        <button type="button" id="btnSubmitAdministration" class="btn btn-aqua-blue waves-effect waves-light p-l-r-30"> <span>@lang('frontsistema.administracion_cuenta.submit_button')</span> </button>
                    </div>
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
        <!-- <div class="row">
            <div class="col-xl-6 col-md-6">
                <div class="card widget-box-three m-b-15">
                    <div class="card-body">
                        <div class="text-center11">
                            <div class="row">
                                <div class="col-md-12">
                                    <p class="m-t-5 m-b-0"><span class="font-700">@lang('frontsistema.validate_mob.user'):</span> {{ $client->FullName}}</p>
                                </div>
                                <div class="col-md-12">
                                    <p class="m-t-5 m-b-0"><span class="font-700">@lang('frontsistema.validate_mob.contract'):</span> <val id="request_folio_number"
                                        ></val></p>
                                    <input type="hidden" name="client_request_id" id="client_request_id" value="">
                                </div>
                                <div class="col-md-12">
                                    <p class="m-t-5 m-b-0"><span class="font-700">@lang('frontsistema.validate_mob.application_date'):</span> {{ date('d-m-Y') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->
        <div class="row">
            <div class="col-lg-6">
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
                <div class="g-recaptcha" data-callback="recaptchaCallback" data-sitekey="{{ env('GOOGLE_RECAPTCHA_SITE_KEY','') }}"></div>
                <div id="recaptcha_error" class="form-error">@lang('frontsistema.validate_mob.recaptcha_error')</div>
            </div>
            <div class="col-xl-6 col-md-6">
                <div class="row">
                    <div class="col-xl-6 col-md-6">
                        <div class="form-group">
                            <input type="hidden" name="client_request_id" id="client_request_id" value="">
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
                <label class="font-600 m-0"><a id="generar_codigo" href="javascript:void(0);" class="text-custom-info text-underline">@lang('frontsistema.validate_mob.send_new_code')</a></label>
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
<script src="{{ url('assets/plugins/autoNumeric/autoNumeric.js') }}"></script>
<script type="text/javascript">
    //var admin_form_data = '{"tfamodify_limit":{"type":"text","value":"100.00"},"ttpmodify_limit":{"type":"text","value":"115.00"},"timodify_limit":{"type":"text","value":"125.00"},"permission_account_access":{"type":"text","value":"Grant permission"},"permission_transfer_btwn_accounts":{"type":"text","value":"Grant permission"},"permission_international_transfer":{"type":"text","value":"Grant permission"},"permission_written_orders":{"type":"text","value":"Grant permission"},"full_name":{"type":"text","value":"test"},"type_number":{"type":"text","value":"test"},"date_of_birth":{"type":"text","value":"01/11/2019"},"place_of_birth":{"type":"text","value":"test"},"address":{"type":"text","value":"test"},"country":{"type":"text","value":"test"},"state":{"type":"text","value":"test"},"county":{"type":"text","value":"test"},"phone_1":{"type":"text","value":"test"},"phone_2":{"type":"text","value":""},"email":{"type":"text","value":"testmxn@yopmail.com"}}';
    //console.log($.parseJSON(admin_form_data));
    
    $(function ($) {
        $('.autonumber').autoNumeric('init');
        $('.autonumber').change();
    });
    
    function getFormattedValue($value)
    {
        return $value.replace(/\,/g, '');            
    }   
    
    $('body').on('change', '.autonumber', function(){

        let unformatted_value = $(this).val();
        let formatted_value = getFormattedValue(unformatted_value);
        //console.log(formatted_value);
        $(this).next('input.limit_amount').val(formatted_value)
        $(this).next('input.limit_amount').change().parsley().validate();
    }); 

    $('body').on('change', '.chk_limit', function(){

        $(this).data("textclass");

        if($(this).prop("checked") == true){
            $('.'+ $(this).data("textclass")).prop('readonly', false);
            $('.'+ $(this).data("textclass")).val('');
            $('.'+ $(this).data("textclass")).val('').change();

        }else{
            $('.'+ $(this).data("textclass")).prop('readonly', true);
            $('.'+ $(this).data("textclass")).val('0.00');
            $('.'+ $(this).data("textclass")).val('0.00').change();
        }
    });    
    
    $("#btnSubmitAdministration").click(function(){
        /*$.each($('.limit_amount'), function(i, val){
            $(val).parsley().validate();
        }); */
        $('#administracion_de_cuentasForm').submit();
        return false;
    });    
    
    //Initialze date pickers
    $('.date_picker').datepicker({
        format: 'dd/mm/yyyy',
        autoclose: true,
        endDate: '+0d',
        language: '{{ session("language") }}',
    }).on('changeDate', function(e) {
        $(this).parsley().validate();
    });

    $('#administracion_de_cuentasForm').parsley({
        excluded: 'input[type=button], input[type=submit], input[type=reset]',
        inputs: 'input[type=hidden], :hidden',
    }).on('field:validated', function () {
        //console.log("form error");
    })
    .on('form:submit', function () {
        
        if ($("#administracion_de_cuentasForm .chk_limit:checkbox:checked").length > 0)
        {
            submitAdministracionCuentasForm();
        }
        else
        {
            swal("@lang('frontsistema.users_alert')", "@lang('frontsistema.administracion_cuenta.transfer_limit_err')", 'error');
        }
        
        return false; // Don't submit form
    });
    
    function submitAdministracionCuentasForm(){

        var token = $('#_token').val();

        let req_data = '{';

        //var req_data = '{"cambio_de_custodio":{"type":"text","value":""}}';
        if($("#transpo_entre_cuentas:checkbox:checked").length > 0)
        {
            req_data += '"'+ $('#inputtfamodify_limit').attr("name") +'":{"type":"text","value":"'+$('#inputtfamodify_limit').val()+'"}';
        }
        if($("#transpo_a_terceros:checkbox:checked").length > 0)
        {
            req_data += '"'+ $('#inputttpmodify_limit').attr("name") +'":{"type":"text","value":"'+$('#inputttpmodify_limit').val()+'"}';
        }
        if($("#transferencias_internacionales:checkbox:checked").length > 0)
        {
            req_data += '"'+ $('#inputtimodify_limit').attr("name") +'":{"type":"text","value":"'+$('#inputtimodify_limit').val()+'"}';
        }

        req_data += '}';

        show_loader(true);

        $.ajax({
            type: 'POST',
            dataType: 'json',
            data: {'_token':token,'text':req_data,'request_type_id':3,'verify':1,'from':'Límites diarios'},
            url: "{{ url('user/client_request') }}",
            beforeSend: function() {
                //$('#modal-espere').modal('show');
            },
            success: function(response) {
                if (response.error && response.code == '500') {
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
            },
            complete: function() {
                show_loader(false);
            }
        });

        /*

        let req_data = '{';

        var $form = $("#administracion_de_cuentasForm");

        if(!validDocumentFiles($form)){
            swal("@lang('frontsistema.users_alert')", "@lang('frontsistema.administracion_cuenta.file_upload_err')", 'error');
            return;
        } 

        $('#administracion_de_cuentasForm').find(':input').each(function() 
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

        //console.log(req_data);

        show_loader(true);

        var form_data = new FormData();

        $form.find("input[type=file]").each(function(index, field){
            if(field != undefined && field.files.length>0){
                form_data.append('documents[]',field.files[0]);
            }
        });
        // return;
        form_data.append('text', req_data);
        form_data.append('request_type_id', 3);
        form_data.append('verify', 1);
        form_data.append('from', 'Administración de cuentas');
        form_data.append('_token', token);

        $.ajax({
            url: "{{ url('user/client_request') }}",
            type: 'post',
            dataType: 'text',
            data: form_data,
            cache: false,
            contentType: false,
            processData: false,           
            success: function(response) {
                response = JSON.parse(response);  
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
            },
            complete: function() {
                show_loader(false);
            }
        });
        */
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
        var v = grecaptcha.getResponse();
        var list =0;
        let code = $('#inputmob_codigo').val();

        $('#recaptcha_error').hide();
        $('#code_error').hide();
        if(v.length == 0)
        {
            list = 1;
            $('#recaptcha_error').show();
        }
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
            },
            complete: function() {
                show_loader(false);
            }
        });
    });
    
    function validDocumentFiles($form){
        var docFlag = false;
        $form.find("input[type=file]").each(function(index, field){
            if(field != undefined && field.files.length>0){
                docFlag = true;
            }
        });
        return docFlag;
    }
    function validDocumentFile(event){  
        //console.log(event);
        if(event.target.files.length == 0){
            return;
        }
        var fileItem = event.target.files[0];
        if(fileItem.type=="image/jpeg" || fileItem.type=="image/jpg" || fileItem.type=="image/png" || fileItem.type=="image/gif" || fileItem.type == "application/pdf"){
            if (fileItem.size > 5242880) { 
                // $('#document1').closest('[type="button"]').find(".file_upload_error").html('File should be less than 5 mb');
                // $('.file_upload_error').text('File should be less than 5 mb');
                // alert("Try to upload file less than 5MB!"); 
                event.target.files.length = 0;
                event.target.value = '';
                swal("@lang('frontsistema.users_alert')", "@lang('frontsistema.administracion_cuenta.file_upload_size_err')", 'error');
            } 
        }
        else{
            event.target.files.length = 0;
            event.target.value = '';
            swal("@lang('frontsistema.users_alert')", "@lang('frontsistema.administracion_cuenta.file_upload_type_err')", 'error');
        }
    }
    
    $("#btnAddMoreFiles").click(function(){       
        let this_obj = $(this);
        let max_length = 5;
        let current_length = $('body').find('.file_upload_block').length;
        if(current_length >= max_length)
        {
           console.log('cant add more');
        }
        else
        {
            let next_block = current_length + 1;
            let block_html = '<div class="file_upload_block col-lg-12 row">';
            block_html += '<div class="controls col-md-4">';
            block_html += '<div class="fileupload fileupload-new" data-provides="fileupload">';
            block_html += '<label class="font-14 font-700 m-r-10 fileLable">Archivo '+next_block+':</label>';
            block_html += '<button type="button" class="btn btn-aqua-blue btn-file">';
            block_html += '<span class="fileupload-new"><i class="fa fa-paper-clip"></i> '+ "{{ __('frontsistema.administracion_cuenta.select_file_btn') }}" + '</span>';
            block_html += '<span class="fileupload-exists"><i class="fa fa-undo"></i>'+ "{{ __('frontsistema.administracion_cuenta.change_btn') }}" +'</span>';
            block_html += '<input type="file" id="document'+next_block+'" name="user_document[]" class="user_document btn-secondary" class="btn-secondary" accept=".jpg,.gif,.png,.pdf" onChange="validDocumentFile(event)"/>';
            block_html += '</button>';
            block_html += '<span class="fileupload-preview" style="margin-left:5px;"></span>';
            block_html += '<a href="#" class="close fileupload-exists btn btn-file-cross" data-dismiss="fileupload" style="float: none; margin-left:5px;"><i class="fa fa-times"></i></a>';
            block_html += '<div class="file_upload_error"></div>';
            block_html += '</div>';            
            block_html += '</div>';
            block_html += '<div class="col-md-8 p-l-0"><button type="button" class="btn btn-danger btn-file btnRemoveFileBlock"><i class="fa fa-times"></i></button></div>';
            block_html += '</div>';            
            $('body').find('.additional_blocks').append(block_html);
            rearrange_blocks();
        }
    });
    
    $('body').on('click', '.btnRemoveFileBlock', function(){
        let this_obj = $(this);
        let this_block = this_obj.parents('div.file_upload_block');
        this_block.remove();
        rearrange_blocks();
    });
    
    function rearrange_blocks()
    {
        $.each($('body').find('.additional_blocks .file_upload_block'), function(i, val){
            $(val).find('.user_document').attr('id', 'document' + (i + 2));
            $(val).find('.fileLable').html('{{ __("frontsistema.administracion_cuenta.fileLbl") }}' + (i + 2) + ':'); 
        });
    }
</script>
@endsection