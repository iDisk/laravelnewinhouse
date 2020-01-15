@extends('layouts.front_vertical_menu')
@section('customcss')
<!--Form Wizard-->
<link rel="stylesheet" type="text/css" href="{{ url('assets/plugins/jquery.steps/css/jquery.steps.css') }}" />
<link href="{{ url('assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet">
<style type="text/css">
    b {
        font-weight: 600;
    }
    .wizard > .steps > ul {
        text-align: center;
    }
    .wizard > .steps > ul > li {
        width: auto;
        float: none;
        display: inline-block;
    }
    .wizard > .steps > ul > li > a, .wizard > .steps .done a {
        background: transparent !important;
        border: none !important;
    }
    .wizard > .steps > ul > li > a > .number {
        color: #AAAAAA !important;
        font-size: 30px;
        opacity: 1 !important;
        position: relative;
        display: inline-block;
        line-height: initial;
        top: auto;
        left: auto;
        padding: 4px 14px;
    }
    .wizard > .steps > ul > li > a > .text {
        color: #AAAAAA !important;
        font-size: 14px;
        display: block;
        font-weight: 600;
        margin-top: 5px;
    }
    .wizard > .steps > ul > li.current > a > .number {
        background: #8cd5dd !important;
        font-weight: bold;
        color: white !important;
        border-radius: 60px;
    }
    .wizard > .steps > ul > li.current > a > .text {
        color: #8cd5dd !important;
    }
    .content {
        margin: 0 !important;
        padding: 0 !important;
        background: transparent !important;
        border: none !important;
    }
    section.body {
        padding-top: 0 !important;
        padding-bottom: 0 !important;
    }
    .wizard > .actions {
        display: none;
    }
    .checkbox label, .radio label {
        margin-bottom: 5px !important;
        margin-top: 5px !important;
    }
    .wizard > .content > .body input {
        border-color: #2d2d2d;
    }
    .verification_head {
        font-size: 15px;
    }
    .verification_head .title {
        font-weight: bold;
    }
    .verification_table_data {
        padding: 8px 0;
    }
    .verification_table_data:nth-child(odd) {
        background: #ccc;
    }
    .verification_table_data:nth-child(even) {
        background: #ddd;
    }
    .verification_table_data .radio label {
        margin-top: 0 !important;
        margin-bottom: 0 !important;
    }
    .deleteVerification {
        color: red;
        cursor: pointer;
    }
    .verification_box {
        border: 1px solid #2d2d2d;
        margin-left: 0;
        margin-right: 0;
        padding: 10px 15px 20px 15px;
    }
    .open_contact_us_form.blue {
        color: #8cd5dd !important;
        text-decoration: underline;
    }
    div.table {
        overflow: hidden;
        overflow-x: auto;
    }
    div.table .verification_table_title, div.table .verification_table_data {
        min-width: 1050px;
        margin-left: 0;
        margin-right: 0;
    }
    sup {
        font-size: 12px;
        top: 0px;
        left: 2px;
    }
    .steps {
        display: none !important;
    }
    @media (min-width: 1200px) {
        .wizard > .content {
            min-height: 45em;
        }
    }
    @media (min-width: 992px) and (max-width: 1199px) {
        .wizard > .content {
            min-height: 45em;
        }
    }
    @media (min-width: 768px) and (max-width: 991px) {
        .wizard > .content {
            min-height: 55em;
        }
    }
    @media (min-width: 576px) and (max-width: 767px) {
        .wizard > .content {
            min-height: 65em;
        }
    }
    @media (max-width: 575px) {
        .wizard > .content {
            min-height: 75em;
        }
        .wizard > .steps > ul > li > a, .wizard > .steps .done a {
            padding: 8px !important;
            margin: 0 !important;
        }
        .wizard > .content {
            padding: 0 !important;
        }
        .verification_head .title {
            display: block;
        }
    }
</style>
@endsection

@section('pagecontent')
    <div class="container-fluid">
        <input type="hidden" id="_token" value="{{ csrf_token() }}">
        <div class="row">
            <div class="col-xl-12">
                <div class="page-title-box text-xs-center text-sm-center text-md-center">
                    <h4 class="page-title">@lang('frontsistema.alta_de_cuentas.title')</h4>
                    <div class="web_logo">
                        <img class="" src="{{ url('assets/images/logo_espacios.png')}}" alt="" height="50">
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
        <div class="row" id="main_section">
            <div class="col-xl-12 p-lr-xs-30">
                <div id="basic-form" action="#">
                    <div>
                        <h3>
                            <span class="text">
                                @lang('frontsistema.alta_de_cuentas.first_main_title')</h3>
                            </span>
                        </h3>
                        <section>
                            <form id="first_form" name="first_form">
                                <div class="row on_load">
                                    <div class="col-xl-12 col-lg-12 col-md-12">
                                        <div class="card help_card_widget m-0">
                                            <div class="card-body">
                                                <p class="m-0">
                                                    @lang('frontsistema.alta_de_cuentas.help_msg')
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row m-t-20">
                                    <div class="col-12">
                                        <h5 class="font-16 font-600">@lang('frontsistema.alta_de_cuentas.first_title')</h5>
                                        <div class="row m-b-10">
                                            <div class="col-xl-12">
                                                <h5 class="font-16 m-0">@lang('frontsistema.alta_de_cuentas.requested_info')</h5>
                                            </div>
                                        </div>
                                        <div class="row on_load">
                                            <div class="col-xl-3 col-lg-6 col-md-6 m-t-minus-5 m-t-sm-15 m-t-xs-15 m-t-20">
                                                <label class="m-0 font-600 font-11">@lang('frontsistema.alta_de_cuentas.type_of_recipient')</label>
                                                <select class="form-control input-black" id="adc_type_of_recipient" name="adc_type_of_recipient" data-parsley-trigger="change" value="" required guardar="SI">
                                                    <option value=""></option>
                                                    @foreach(config('site.types_of_recipients') as $key=>$recipient)
                                                        <option value="{{ $recipient[session('language')] }}" data-value="{{ $key }}">{{ $recipient[session('language')] }}</option>
                                                    @endforeach
                                                </select>
                                                <div class="form-error">@lang('frontsistema.alta_de_cuentas.type_of_recipient_err')</div>
                                            </div>
                                            <input type="hidden" name="type_of_recipient_value" id="type_of_recipient_value" value="" />
                                            <div class="col-xl-3 col-lg-6 col-md-6 m-t-minus-5 m-t-sm-15 m-t-xs-15 m-t-20">
                                                <label class="m-0 font-600 font-11">@lang('frontsistema.alta_de_cuentas.destination')</label>
                                                <select class="form-control input-black" id="adc_destination" name="adc_destination" data-parsley-trigger="change" value="" required guardar="SI">
                                                    <option value=""></option>
                                                    @foreach(config('site.destinations') as $key=>$destination)
                                                        <option value="{{ $destination[session('language')] }}" data-value="{{ $key }}">{{ $destination[session('language')] }}</option>
                                                    @endforeach
                                                </select>
                                                <div class="form-error">@lang('frontsistema.alta_de_cuentas.destination_error')</div>
                                            </div>
                                            <input type="hidden" name="destination_value" id="destination_value" value="" />
                                        </div>
                                        <div id="dynamicFields"></div>
                                        <div class="row on_load m-t-30">
                                            <div class="col-xl-12 col-lg-12 col-md-12">
                                                <h5 class="font-14 terms-div-border">
                                                    {!! $broker_setting['account_registration_disclaimer'] !!}
                                                    <div class="checkbox checkbox-custom m-t-0 line-height-20">
                                                        <label class="m-b-0 ckCursor" for="policies">
                                                            <input type="checkbox" value="1" name="policies" id="policies" required parsley-trigger="change">
                                                            <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                            @lang('frontsistema.alta_de_cuentas.accept_text')
                                                        </label>
                                                        <div class="form-error">@lang('frontsistema.alta_de_cuentas.terms_error')</div>
                                                    </div>
                                                </h5>
                                            </div>
                                        </div>
                                        <div class="row m-t-30 m-b-30">
                                            <div class="col-lg-12 col-xl-12 text-center">
                                            <a class="text-aqua-blue m-r-10 cursor-pointer line-height-35 m-r-30 font-600" href="{{ route('client_home') }}">@lang('frontsistema.btn_cancel')</a>
                                                <button type="submit" class="btn btn-aqua-blue waves-effect waves-light"> <span>@lang('frontsistema.alta_de_cuentas.submit_label')</span> </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </section>
                        <h3>
                            <span class="text">
                                @lang('frontsistema.alta_de_cuentas.second_main_title')
                            </span>
                        </h3>
                        <section>
                            <form id="second_form" name="second_form">
                                <div class="row">
                                    <div class="col-12">
                                        <h5 class="font-16 font-600">@lang('frontsistema.alta_de_cuentas.second_title')</h5>
                                        <div class="row on_load verification_head">
                                            <div class="col-xl-12 m-t-30 col-lg-12 col-md-12 text-center text-lg-left text-md-left custom-text-sm-left text-xs-left">
                                                <span class="title">
                                                    @lang('frontsistema.alta_de_cuentas.user_label')
                                                </span>
                                                {{$accountName}}
                                            </div>
                                        </div>
                                        <div class="table">
                                            <div class="row m-t-50 m-b-10 on_load verification_table_title">
                                                <div class="col-1 text-center p-l-r-5"></div>
                                                <div class="col-2 text-center p-l-r-5">
                                                    @lang('frontsistema.alta_de_cuentas.type_of_recipient'):
                                                </div>
                                                <div class="col-1 text-center p-l-r-5">
                                                    @lang('frontsistema.alta_de_cuentas.destination'):
                                                </div>
                                                <div class="col-2 text-center p-l-r-5">
                                                    @lang('frontsistema.alta_de_cuentas.type_of_account'):
                                                </div>
                                                <div class="col-2 text-center p-l-r-5">
                                                    @lang('frontsistema.alta_de_cuentas.account_name'):
                                                </div>
                                                <div class="col-2 text-center p-l-r-5">
                                                    @lang('frontsistema.alta_de_cuentas.account_number'):
                                                </div>
                                                <div class="col-1 text-center p-l-r-5">
                                                    @lang('frontsistema.alta_de_cuentas.status_label')
                                                </div>
                                                <div class="col-1 text-center p-l-r-5"></div>
                                            </div>
                                            <div id="pendingRequests">
                                            </div>
                                            <input type="radio" name="verification" value="verification" id="verification" data-parsley-trigger="change" required style="display: none;">
                                        </div>
                                        <div class="form-error verificationError">@lang('frontsistema.alta_de_cuentas.verification_error')</div>
                                        <div class="row m-t-30 m-b-30">
                                            <div class="col-xl-12 text-right">
                                                <button class="btn btn-aqua-blue waves-effect waves-light" type="submit">@lang('frontsistema.alta_de_cuentas.submit_label')</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </section>
                        <h3>
                            <span class="text">
                                @lang('frontsistema.alta_de_cuentas.third_main_title')
                            </span>
                        </h3>
                        <section>
                            <form id="third_form" name="third_form">
                                <div class="row">
                                    <div class="col-xl-12 col-lg-12">
                                        <h5 class="font-16 font-600">@lang('frontsistema.alta_de_cuentas.third_title')</h5>
                                        <div class="row m-t-30 m-b-30 on_load verification_head verification_box">
                                            <div class="col-xl-6 text-left m-t-10">
                                                <span class="title font-16">
                                                    @lang('frontsistema.alta_de_cuentas.type_of_recipient'):
                                                </span>
                                                <span id="typeOfRecipientVerify"></span>
                                            </div>
                                            <div class="col-xl-6 text-left m-t-10">
                                                <span class="title font-16">
                                                    @lang('frontsistema.alta_de_cuentas.destination'):
                                                </span>
                                                <span id="destinationVerify"></span>
                                            </div>
                                            <div class="col-xl-6 text-left m-t-10">
                                                <span class="title font-16">
                                                    @lang('frontsistema.alta_de_cuentas.type_of_account'):
                                                </span>
                                                <span id="typeOfAccountVerify"></span>
                                            </div>
                                            <div class="col-xl-6 text-left m-t-10">
                                                <span class="title font-16">
                                                    @lang('frontsistema.alta_de_cuentas.account_name'):
                                                </span>
                                                <span id="aliasLabelVerify"></span>
                                            </div>
                                            <div class="col-xl-6 text-left m-t-10">
                                                <span class="title font-16">
                                                    @lang('frontsistema.alta_de_cuentas.account_number'):
                                                </span>
                                                <span id="accountNumberVerify"></span>
                                            </div>
                                            <div class="col-xl-6 text-left m-t-10">
                                                <span class="title font-16">
                                                    @lang('frontsistema.alta_de_cuentas.status_label')
                                                </span>
                                                <span>Pendiente</span>
                                            </div>
                                        </div>
                                        <h5 class="font-16">@lang('frontsistema.alta_de_cuentas.code_label')</h5>
                                        <div class="row m-b-30 on_load">
                                            <div class="col-xl-3 col-lg-6 col-md-6 m-t-minus-5 m-t-sm-15 m-t-xs-15 m-t-20">
                                                <label class="m-0 font-600 font-11">@lang('frontsistema.alta_de_cuentas.code')</label>
                                                <input class="form-control input-black" type="number" id="code" name="code"data-parsley-type="integer" data-parsley-trigger="change" autocomplete="off" required>
                                                <div class="form-error">@lang('frontsistema.alta_de_cuentas.code_error')</div>
                                            </div>
                                            <div class="col-xl-3 col-lg-6 col-md-6 m-t-minus-5 m-t-sm-15 m-t-xs-15 m-t-20">
                                                <label class="m-0 font-600 font-11">&nbsp;</label>
                                                <button class="btn btn-block btn-aqua-blue waves-effect waves-light">@lang('frontsistema.alta_de_cuentas.submit_label')</button>
                                            </div>
                                            <div class="col-xl-12">
                                                <a class="text-aqua-blue m-r-10 cursor-pointer line-height-35 resendOtp" href="javascript:void(0)">@lang('frontsistema.alta_de_cuentas.request_another_code')</a>
                                            </div>
                                            <!-- end col -->
                                        </div>
                                        <div class="row on_load">
                                            <div class="col-xl-12 col-lg-12 col-md-12">
                                                <h5 class="font-16">
                                                    @lang('frontsistema.alta_de_cuentas.help_msg3')
                                                    <a href="javascript:void(0)" class="open_contact_us_form blue">@lang('frontsistema.alta_de_cuentas.contact')</a>
                                                </h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </section>
                    </div>
                </div>
            </div>
        </div>
        <div class="row on_success m-t-50" style="display: none;">
            <div class="col-lg-12 text-center">
                <h3 class="font-600">@lang('frontsistema.alta_de_cuentas.success_msg_title')</h3>
                <p class="text-custom-info font-600 font-16 m-b-0 m-t-20">@lang('frontsistema.alta_de_cuentas.success_msg')</p>
                <div class="row m-t-20">
                    <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12 text-right text-md-center text-sm-center text-xs-center">
                        <a class="text-aqua-blue m-r-10 cursor-pointer line-height-35" href="{{ route('client_home') }}">@lang('frontsistema.alta_de_cuentas.back_to_home')</a>
                    </div>
                    <div class=" col-lg-6 col-md-12 col-sm-12 col-xs-12 text-left text-md-center text-sm-center text-xs-center">
                        <button id="submit-another-request" class="btn btn-aqua-blue waves-effect waves-light">@lang('frontsistema.alta_de_cuentas.request_more_finance')</button>
                    </div>
                </div>
            </div>
        </div>

    </div> <!-- container-fluid -->

    @php 
        $arr['label1'] = array('type'=>'text','value'=>'val','label_en'=>'eng','label_es'=>'spanish');
        //dd($arr);
    @endphp
@endsection

@section('customjs')
<script type="text/javascript" src="{{ asset('assets/plugins/moment/moment-with-locales.min.js') }}"></script>
<script src="{{ url('assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}" charset="UTF-8"></script>
<script src="{{ url('assets/plugins/bootstrap-datepicker/locales/bootstrap-datepicker.es.js') }}"></script>
<!--Form Wizard-->
<script src="{{ url('assets/plugins/jquery.steps/js/jquery.steps.min.js') }}"></script>
<script src="{{ url('assets/plugins/jquery-validation/js/jquery.validate.min.js') }}"></script>
<!--wizard initialization-->
<script src="{{ url('assets/pages/jquery.wizard-init.js') }}" type="text/javascript"></script>
    <script type="text/javascript">


        initParsleyValidation();
        initDatepicker('application_date', '+1d', null);

        $('#submit-another-request').click(function() {
            window.location.reload();
        });

        // Function to initialize the parsley validation
        function initParsleyValidation() {
            $('#first_form').parsley().on('field:validated', function () {
                // console.log("first_form error");
            })
            .on('form:submit', function () {
                // console.log("first form submitted");
                // Move to the next wizard after submitting the current form
                submitFirstForm();
                // $('a[href="#next"]').click();
                return false; // Don't submit form for this demo
            });
            $('#second_form').parsley().on('field:validated', function (e) {
                if (!$('#second_form').parsley().isValid()) {
                    $('.verificationError').show();
                }
                else {
                    $('.verificationError').hide();
                }
            })
            .on('form:submit', function () {
                // Move to the next wizard
                submitSecondForm();
                return false; // Don't submit form for this demo
            });
            $('#third_form').parsley().on('field:validated', function (e) {
                // console.log("third_form error", e);
            })
            .on('form:submit', function () {
                submitThirdForm();
                return false; // Don't submit form for this demo
            });
        }

        // Function to handle the init of datepicker
        function initDatepicker(id, startDate, endDate) {
            var options = {
                format: 'dd/mm/yyyy',
                autoclose: true,
                startDate: startDate, // After current day
                language: '{{ session("language") }}',
            };
            if (endDate) {
                options['endDate'] = endDate;
            }
            //Initialze date pickers
            $('#' + id).datepicker(options).on('changeDate', function(e) {
                $(this).parsley().validate();
            });
        }

        // Function to handle the click of previous wizard button
        $('body').on('click', '.previousWizard', function() {
            $('a[href="#previous"]').click();
        });

        var pending_requests = [];
        var selectedIndex = 0;

        // Function to handle the submit of first form after successful validation
        function submitFirstForm(){
            let token = $('#_token').val();
            let req_data = '{';

            $('#first_form').find(':input').each(function() 
            {
                if($(this).attr("guardar")=="SI")
                {
                    if(req_data != '{'){
                         req_data += ',';
                    }
                    req_data += '"'+ $(this).attr("name") +'":{"type":"text","value":"'+$(this).val()+'"}'; 
                }
                
            });
            req_data += '}';
            $.ajax({
                type: 'POST',
                dataType: 'json',
                data: {'_token':token,'text':req_data,'request_type_id':28,'verify':2,'from':'Alta de Cuentas'},
                url: "{{ url('user/client_request') }}",
                beforeSend: function() {
                    //$('#modal-espere').modal('show');
                    show_loader(true);
                },
                success: function(response) {
                    if (response.error && response.code == '500'){
                        show_loader(false);
                    }
                    else if(!response.error && response.code == '200'){
                        // Make an API call to fetch the internal transfer requests for the current client
                        $.ajax({
                            type: 'GET',
                            dataType: 'json',
                            url: "{{ url('user/pending_account_registrations') }}" + '?_token=' + token + '&user_id=' + '{{$user_id}}',
                            success: function(response) {
                                if (response.error && response.code == '500'){
                                    show_loader(false);
                                }
                                else if(!response.error && response.code == '200'){
                                    // Move to the next wizard if the requests are fetched successfully
                                    pending_requests = response.data;
                                    var pendingRequestsHtml = '';
                                    for (var i = 0; i < pending_requests.length; i++) {
                                        pending_requests[i].parsedText = JSON.parse(pending_requests[i].text);
                                        // Create html of the pendingRequests
                                        pendingRequestsHtml += '<div class="row on_load verification_table_data font_primary_color pendingTransaction'+pending_requests[i].id+'">'+
                                                                    '<div class="col-1 text-center p-l-r-5">'+
                                                                        '<div class="radio">'+
                                                                            '<label for="verification'+i+'">'+
                                                                                '<input type="radio" name="verification" value="verification'+i+'" id="verification'+i+'" data-index="'+i+'" data-parsley-trigger="change" required>'+
                                                                                '<span class="cr"><i class="cr-icon mdi mdi-checkbox-blank-circle"></i></span>'+
                                                                                '&nbsp;'+
                                                                            '</label>'+
                                                                        '</div>'+
                                                                    '</div>'+
                                                                    '<div class="col-2 text-center p-l-r-5">'+
                                                                        pending_requests[i].parsedText.adc_type_of_recipient.value+
                                                                    '</div>'+
                                                                    '<div class="col-1 text-center p-l-r-5">'+
                                                                        pending_requests[i].parsedText.adc_destination.value+
                                                                    '</div>'+
                                                                    '<div class="col-2 text-center p-l-r-5">'+
                                                                        pending_requests[i].parsedText.adc_type_of_account.value+
                                                                    '</div>'+
                                                                    '<div class="col-2 text-center p-l-r-5">'+
                                                                        pending_requests[i].parsedText.adc_account_name.value+
                                                                    '</div>'+
                                                                    '<div class="col-2 text-center p-l-r-5">'+
                                                                        ((pending_requests[i].parsedText.adc_account_number) ? pending_requests[i].parsedText.adc_account_number.value : '') + ((pending_requests[i].parsedText.adc_dest_account_number) ? pending_requests[i].parsedText.adc_dest_account_number.value : '') +
                                                                    '</div>'+
                                                                    '<div class="col-1 text-center p-l-r-5">'+
                                                                        'Pendiente'+
                                                                    '</div>'+
                                                                    '<div class="col-1 text-center p-l-r-5">'+
                                                                        '<span class="mdi mdi-close deleteVerification" data-id='+pending_requests[i].id+'></span>'+
                                                                    '</div>'+
                                                                '</div>';
                                    }
                                    $('#pendingRequests').html(pendingRequestsHtml);
                                    console.log(pending_requests);
                                    $('a[href="#next"]').click();
                                }
                            },
                            error: function(response) {
                                //console.error(response);
                            },
                            complete: function() {
                                show_loader(false);
                            }
                        });
                    }
                },
                error: function(response) {
                    //console.error(response);
                    show_loader(false);
                },
                complete: function() {
                    // show_loader(false);
                }
            });
        }

        // Function to handle the change event of pending requests radio button
        $('body').on('change', 'input[type=radio][name=verification]', function() {
            selectedIndex = $(this).val().replace('verification', '');
            console.log(selectedIndex);
            $('#pendingContract').html(pending_requests[selectedIndex].file_number);
            $('#applicationDateVerify').html(pending_requests[selectedIndex].formatted_created_at);
            $('#typeOfRecipientVerify').html(pending_requests[selectedIndex].parsedText.adc_type_of_recipient.value);
            $('#destinationVerify').html(pending_requests[selectedIndex].parsedText.adc_destination.value);
            $('#typeOfAccountVerify').html(pending_requests[selectedIndex].parsedText.adc_type_of_account.value);
            $('#aliasLabelVerify').html(pending_requests[selectedIndex].parsedText.adc_account_name.value);
            $('#accountNumberVerify').html(((pending_requests[selectedIndex].parsedText.adc_account_number) ? pending_requests[selectedIndex].parsedText.adc_account_number.value : '') + ((pending_requests[selectedIndex].parsedText.adc_dest_account_number) ? pending_requests[selectedIndex].parsedText.adc_dest_account_number.value : ''));
        });

        // Function to handle the sending of OTP when user goes from segment 2 to 3
        function submitSecondForm(){
            let token = $('#_token').val();
            $.ajax({
                type: 'POST',
                dataType: 'json',
                data: {'_token':token},
                url: "{{ url('user/generate_code') }}",
                beforeSend: function() {
                    //$('#modal-espere').modal('show');
                    show_loader(true);
                },
                success: function(response) {
                    if (response.error && response.code == '500'){
                        
                    }
                    else if(!response.error && response.code == '200'){
                        // Send the user to wizard 3 if OTP was successfully sent
                        $('a[href="#next"]').click();
                    }
                },
                error: function(response) {
                    //console.error(response);
                },
                complete: function() {
                    show_loader(false);
                }
            });
        }

        // Function to handle the submit of 3rd form
        function submitThirdForm(){
            let token = $('#_token').val();
            $.ajax({
                type: 'POST',
                dataType: 'json',
                data: {'_token':token, 'code': $('#code').val(), 'client_request_id': pending_requests[selectedIndex].id},
                url: "{{ url('user/verify_request') }}",
                beforeSend: function() {
                    //$('#modal-espere').modal('show');
                    show_loader(true);
                },
                success: function(response) {
                    if (response.error && response.code == '500'){
                        swal("@lang('frontsistema.users_alert')", response.message, 'error');
                    }
                    else if(!response.error && response.code == '200'){
                        // Reset all the forms and show success dialog
                        $("#main_section").hide();
                        $("#first_form").trigger("reset");
                        $("#second_form").trigger("reset");
                        $("#third_form").trigger("reset");
                        $('a[href="#finish"]').click();
                        $('.on_success').show();
                        window.scrollTo(0, 0);
                        console.log("submit form");
                    }
                },
                error: function(response) {
                    //console.error(response);
                },
                complete: function() {
                    show_loader(false);
                }
            });
        }

        // Function to handle resending of otp
        $('body').on('click', '.resendOtp', function() {
            let token = $('#_token').val();
            $.ajax({
                type: 'POST',
                dataType: 'json',
                data: {'_token':token},
                url: "{{ url('user/generate_code') }}",
                beforeSend: function() {
                    //$('#modal-espere').modal('show');
                    show_loader(true);
                },
                success: function(response) {
                    if (response.error && response.code == '500'){
                        swal("@lang('frontsistema.users_alert')", response.message, 'error');
                    }
                    else if(!response.error && response.code == '200'){
                        // Reset all the forms and show success dialog
                        swal("@lang('frontsistema.users_alert')", "@lang('frontsistema.alta_de_cuentas.otp_resent')", 'success');
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

        // Function to handle the deletion of pending requests
        $('body').on('click', '.deleteVerification', function() {
            let token = $('#_token').val();
            var deleteConfirmId = $(this).data('id');
            swal({
                title: "{{ __('frontsistema.confirm') }}",
                text: "{{ __('frontsistema.alta_de_cuentas.request_del_confirm') }}",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: '#8cd5dd',
                confirmButtonText: "{{ __('frontsistema.btn_yes') }}",
                cancelButtonText: "No"
            })
            .then(function () {
                console.log('Delete', deleteConfirmId);
                $.ajax({
                    type: 'DELETE',
                    dataType: 'json',
                    data: {'_token':token, 'client_request_id': deleteConfirmId},
                    url: "{{ url('user/delete_client_request') }}",
                    beforeSend: function() {
                        //$('#modal-espere').modal('show');
                        show_loader(true);
                    },
                    success: function(response) {
                        if (response.error && response.code == '500'){
                            swal("@lang('frontsistema.users_alert')", response.message, 'error');
                        }
                        else if(!response.error && response.code == '200'){
                            // Reset all the forms and show success dialog
                            swal("@lang('frontsistema.users_alert')", "@lang('frontsistema.alta_de_cuentas.request_deleted')", 'success');
                            $('.pendingTransaction'+deleteConfirmId).remove();
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
        });

        var lastForm;
        // Functions to handle the change of type of recipient and destination
        $('body').on('change', '#adc_type_of_recipient', function() {
            $('#type_of_recipient_value').val($("#adc_type_of_recipient option:selected").data('value'));
            showHideDynamicFields();
        });
        $('body').on('change', '#adc_destination', function() {
            $('#destination_value').val($("#adc_destination option:selected").data('value'));
            showHideDynamicFields();
        });
        // Function to handle the showing and hiding of dynamic fields
        function showHideDynamicFields() {
            if (($('#type_of_recipient_value').val() == 'personal' || $('#type_of_recipient_value').val() == 'company') && $('#destination_value').val() == 'same' && lastForm != 'page24') {
                var html = '<div class="row">'+
                                '<div class="col-xl-6 col-lg-12 col-md-12 m-t-minus-5 m-t-sm-15 m-t-xs-15 m-t-20">'+
                                    '<label class="m-0 font-600 font-11">@lang('frontsistema.alta_de_cuentas.type_of_account')</label>'+
                                    '<select class="form-control input-black" type="text" id="adc_type_of_account" name="adc_type_of_account" data-parsley-trigger="change" required guardar="SI">'+
                                        '<option value=""></option>'+
                                        @foreach($instruments as $key=>$instrument)
                                            '<option value="@php echo $instrument['instrument_'.session('language')] @endphp">@php echo $instrument['instrument_'.session('language')] @endphp</option>'+
                                        @endforeach
                                    '</select>'+
                                    '<div class="form-error">@lang('frontsistema.alta_de_cuentas.type_of_account_error')</div>'+
                                '</div>'+
                            '</div>'+
                            '<div class="row">'+
                                '<div class="col-xl-6 col-lg-12 col-md-12 m-t-minus-5 m-t-sm-15 m-t-xs-15 m-t-20">'+
                                    '<label class="m-0 font-600 font-11">@lang('frontsistema.alta_de_cuentas.account_name')</label>'+
                                    '<input class="form-control input-black" type="text" id="adc_account_name" name="adc_account_name" data-parsley-trigger="change" required guardar="SI" />'+
                                    '<div class="form-error">@lang('frontsistema.alta_de_cuentas.account_name_error')</div>'+
                                '</div>'+
                            '</div>'+
                            '<div class="row">'+
                                '<div class="col-xl-3 col-lg-6 col-md-6 m-t-minus-5 m-t-sm-15 m-t-xs-15 m-t-20">'+
                                    '<label class="m-0 font-600 font-11">@lang('frontsistema.alta_de_cuentas.account_number')</label>'+
                                    '<input class="form-control input-black" type="text" id="adc_account_number" name="adc_account_number" data-parsley-trigger="change" data-parsley-type="number" required guardar="SI" />'+
                                    '<div class="form-error">@lang('frontsistema.alta_de_cuentas.account_number_error')</div>'+
                                '</div>'+
                                '<div class="col-xl-3 col-lg-6 col-md-6 m-t-minus-5 m-t-sm-15 m-t-xs-15 m-t-20">'+
                                    '<label class="m-0 font-600 font-11">@lang('frontsistema.alta_de_cuentas.currency')</label>'+
                                    '<select class="form-control input-black" id="adc_currency" name="adc_currency" data-parsley-trigger="change" value="" required guardar="SI">'+
                                        '<option value=""></option>'+
                                        @foreach(config('site.currencies') as $key=>$currency)
                                            '<option value="@php echo $currency[session('language')] @endphp" data-symbol="@php echo $currency['symbol'] @endphp">@php echo $currency[session('language')] @endphp</option>'+
                                        @endforeach
                                    '</select>'+
                                    '<div class="form-error">@lang('frontsistema.alta_de_cuentas.currency_error')</div>'+
                                '</div>'+
                            '</div>';
                $('#dynamicFields').html(html);
                lastForm = 'page24';
            }
            else if (($('#type_of_recipient_value').val() == 'personal' || $('#type_of_recipient_value').val() == 'company') && $('#destination_value').val() == 'international' && lastForm != 'page25') {
                var html = '<div class="row">'+
                                '<div class="col-xl-12 m-t-20 m-b-minus-15">'+
                                    '<h5 class="font-16 font-600 m-0">@lang('frontsistema.alta_de_cuentas.addresse_label')</h5>'+
                                '</div>'+
                                '<div class="col-xl-3 col-lg-6 col-md-6 m-t-minus-5 m-t-sm-15 m-t-xs-15 m-t-20">'+
                                    '<label class="m-0 font-600 font-11">@lang('frontsistema.alta_de_cuentas.type_of_account')</label>'+
                                    '<select class="form-control input-black" type="text" id="adc_type_of_account" name="adc_type_of_account" data-parsley-trigger="change" required guardar="SI">'+
                                        '<option value=""></option>'+
                                        @foreach($instruments as $key=>$instrument)
                                            '<option value="@php echo $instrument['instrument_'.session('language')] @endphp">@php echo $instrument['instrument_'.session('language')] @endphp</option>'+
                                        @endforeach
                                    '</select>'+
                                    '<div class="form-error">@lang('frontsistema.alta_de_cuentas.type_of_account_error')</div>'+
                                '</div>'+
                                '<div class="col-xl-6 col-lg-6 col-md-6 m-t-minus-5 m-t-sm-15 m-t-xs-15 m-t-20">'+
                                    '<label class="m-0 font-600 font-11">@lang('frontsistema.alta_de_cuentas.account_name')</label>'+
                                    '<input class="form-control input-black" type="text" id="adc_account_name" name="adc_account_name" data-parsley-trigger="change" required guardar="SI" />'+
                                    '<div class="form-error">@lang('frontsistema.alta_de_cuentas.account_name_error')</div>'+
                                '</div>'+
                            '</div>'+
                            '<div class="row">'+
                                '<div class="col-xl-3 col-lg-6 col-md-6 m-t-minus-5 m-t-sm-15 m-t-xs-15 m-t-20">'+
                                    '<label class="m-0 font-600 font-11">@lang('frontsistema.alta_de_cuentas.telephone_label')</label>'+
                                    '<input class="form-control input-black" type="text" id="adc_telephone" name="adc_telephone" data-parsley-trigger="change" data-parsley-type="number" required guardar="SI" />'+
                                    '<div class="form-error">@lang('frontsistema.alta_de_cuentas.telephone_error')</div>'+
                                '</div>'+
                                '<div class="col-xl-6 col-lg-6 col-md-6 m-t-minus-5 m-t-sm-15 m-t-xs-15 m-t-20">'+
                                    '<label class="m-0 font-600 font-11">@lang('frontsistema.alta_de_cuentas.address_label')</label>'+
                                    '<input class="form-control input-black" type="text" id="adc_address" name="adc_address" data-parsley-trigger="change" required guardar="SI" />'+
                                    '<div class="form-error">@lang('frontsistema.alta_de_cuentas.address_error')</div>'+
                                '</div>'+
                            '</div>'+
                            '<div class="row">'+
                                '<div class="col-xl-3 col-lg-6 col-md-6 m-t-minus-5 m-t-sm-15 m-t-xs-15 m-t-20">'+
                                    '<label class="m-0 font-600 font-11">@lang('frontsistema.alta_de_cuentas.country_label')</label>'+
                                    '<select class="form-control input-black" type="text" id="adc_country" name="adc_country" data-parsley-trigger="change" required guardar="SI">'+
                                        '<option value=""></option>'+
                                        @foreach($countries as $key=>$country)
                                            '<option value="@php echo $country['name'] @endphp" data-id="@php echo $country['id'] @endphp">@php echo $country['name'] @endphp</option>'+
                                        @endforeach
                                    '</select>'+
                                    '<div class="form-error">@lang('frontsistema.alta_de_cuentas.country_error')</div>'+
                                '</div>'+
                                '<div class="col-xl-3 col-lg-6 col-md-6 m-t-minus-5 m-t-sm-15 m-t-xs-15 m-t-20">'+
                                    '<label class="m-0 font-600 font-11">@lang('frontsistema.alta_de_cuentas.state_label')</label>'+
                                    '<input type="text" class="form-control input-black" id="adc_state" name="adc_state" data-parsley-type="alphanum" data-parsley-trigger="change" required guardar="SI" />'+
                                    '<div class="form-error">@lang('frontsistema.alta_de_cuentas.state_error')</div>'+
                                '</div>'+
                                '<div class="col-xl-3 col-lg-6 col-md-6 m-t-minus-5 m-t-sm-15 m-t-xs-15 m-t-20">'+
                                    '<label class="m-0 font-600 font-11">@lang('frontsistema.alta_de_cuentas.city_label')</label>'+
                                    '<input class="form-control input-black" type="text" id="adc_city" name="adc_city" data-parsley-type="alphanum" data-parsley-trigger="change" required guardar="SI" />'+
                                    '<div class="form-error">@lang('frontsistema.alta_de_cuentas.city_error')</div>'+
                                '</div>'+
                            '</div>'+
                            '<div class="row">'+
                                '<div class="col-xl-12 m-t-20 m-b-minus-15">'+
                                    '<h5 class="font-16 font-600 m-0">@lang('frontsistema.alta_de_cuentas.dest_account_label')</h5>'+
                                '</div>'+
                                '<div class="col-xl-3 col-lg-6 col-md-6 m-t-minus-5 m-t-sm-15 m-t-xs-15 m-t-20">'+
                                    '<label class="m-0 font-600 font-11">@lang('frontsistema.alta_de_cuentas.dest_bank_country')</label>'+
                                    '<select class="form-control input-black" type="text" id="adc_dest_bank_country" name="adc_dest_bank_country" data-parsley-trigger="change" required guardar="SI">'+
                                        '<option value=""></option>'+
                                        @foreach($countries as $key=>$country)
                                            '<option value="@php echo $country['name'] @endphp" data-id="@php echo $country['id'] @endphp">@php echo $country['name'] @endphp</option>'+
                                        @endforeach
                                    '</select>'+
                                    '<div class="form-error">@lang('frontsistema.alta_de_cuentas.dest_bank_country_err')</div>'+
                                '</div>'+
                                '<div class="col-xl-6 col-lg-6 col-md-6 m-t-minus-5 m-t-sm-15 m-t-xs-15 m-t-20">'+
                                    '<label class="m-0 font-600 font-11">@lang('frontsistema.alta_de_cuentas.account_number')</label>'+
                                    '<input class="form-control input-black" type="text" id="adc_dest_account_number" name="adc_dest_account_number" data-parsley-trigger="change" data-parsley-type="number" required guardar="SI" />'+
                                    '<div class="form-error">@lang('frontsistema.alta_de_cuentas.account_number_error')</div>'+
                                '</div>'+
                            '</div>'+
                            '<div class="row">'+
                                '<div class="col-xl-3 col-lg-6 col-md-6 m-t-minus-5 m-t-sm-15 m-t-xs-15 m-t-20">'+
                                    '<label class="m-0 font-600 font-11">@lang('frontsistema.alta_de_cuentas.dest_bank_swift')</label>'+
                                    '<input class="form-control input-black" type="text" id="adc_dest_swift" name="adc_dest_swift" data-parsley-trigger="change" required guardar="SI" />'+
                                    '<div class="form-error">@lang('frontsistema.alta_de_cuentas.dest_bank_swift_error')</div>'+
                                '</div>'+
                                '<div class="col-xl-6 col-lg-6 col-md-6 m-t-minus-5 m-t-sm-15 m-t-xs-15 m-t-20">'+
                                    '<label class="m-0 font-600 font-11">@lang('frontsistema.alta_de_cuentas.dest_bank_label')</label>'+
                                    '<input class="form-control input-black" type="text" id="adc_dest_bank_name" name="adc_dest_bank_name" data-parsley-trigger="change" required guardar="SI" />'+
                                    '<div class="form-error">@lang('frontsistema.alta_de_cuentas.dest_bank_error')</div>'+
                                '</div>'+
                            '</div>'+
                            '<div class="row">'+
                                '<div class="col-xl-6 offset-xl-3 col-lg-6 col-md-6 m-t-minus-5 m-t-sm-15 m-t-xs-15 m-t-20">'+
                                    '<label class="m-0 font-600 font-11">@lang('frontsistema.alta_de_cuentas.dest_bank_address')</label>'+
                                    '<input class="form-control input-black" type="text" id="adc_dest_bank_address" name="adc_dest_bank_address" data-parsley-trigger="change" required guardar="SI" />'+
                                    '<div class="form-error">@lang('frontsistema.alta_de_cuentas.dest_bank_error')</div>'+
                                '</div>'+
                            '</div>'+
                            '<div class="row">'+
                                '<div class="col-xl-12 col-lg-6 col-md-6 m-t-minus-5 m-t-sm-15 m-t-xs-15 m-t-20">'+
                                    '<div class="checkbox checkbox-custom m-t-0 line-height-20">'+
                                        '<label class="m-b-0 ckCursor" for="intermediate_bank_exists">'+
                                            '<input type="checkbox" value="1" name="intermediate_bank_exists" id="intermediate_bank_exists">'+
                                            '<span class="cr"><i class="cr-icon fa fa-check"></i></span>@lang('frontsistema.alta_de_cuentas.use_intermediate_bank')</label>'+
                                    '</div>'+
                                '</div>'+
                            '</div>'+
                            '<div id="intermediate_bank_div"></div>';
                $('#dynamicFields').html(html);
                lastForm = 'page25';
            }
        }
        showHideDynamicFields();

        // Function to handle the change in country and state dropdowns
        // $('body').on('change',"#adc_country",function () {
        //     var client_state = $("#adc_state");
        //     $.ajax({
        //         url: "{{ url('user/getstatelist')}}"+"/"+$("#adc_country option:selected").data('id'),
        //         method:'GET',
        //         dataType:'json',
        //         beforeSend: function() {
        //             //$('#modal-espere').modal('show');
        //             show_loader(true);
        //         },
        //         success: function(response){
        //           var state = '';
        //             if(response['data'])
        //             {
        //              state += '<option value=""></option>';
        //                 for(var x in response['data']){
        //                     state += '<option value="'+response['data'][x]+'" data-id="'+x+'">'+response['data'][x]+'</option>';
        //                 }
        //             }
        //             client_state.html(state);
        //         },
        //         complete: function() {
        //             show_loader(false);
        //         }
        //     });
        // });

        // $('body').on('change',"#adc_state",function () {
        //     var client_city = $("#adc_city");
        //     $.ajax({
        //         url: "{{ url('user/getcitylist')}}"+"/"+$("#adc_state option:selected").data('id'),
        //         method:'GET',
        //         dataType:'json',
        //         beforeSend: function() {
        //             //$('#modal-espere').modal('show');
        //             show_loader(true);
        //         },
        //         success: function(response){
        //             var city = '';
        //             if(response['data'])
        //             {
        //                 city += '<option value=""></option>';
        //                 for(var x in response['data']){
        //                     city += '<option value="'+response['data'][x]+'" data-id="'+x+'">'+response['data'][x]+'</option>';
        //                 }
        //             }
        //             client_city.html(city);
        //         },
        //         complete: function() {
        //             show_loader(false);
        //         }
        //     });
        // });

        // Function to handle the change event of checkbox of intermediate bank
        $('body').on('change', '#intermediate_bank_exists', function() {
            if ($(this).is(':checked')) {
                var html = '<div class="row">'+
                                '<div class="col-xl-3 col-lg-6 col-md-6 m-t-minus-5 m-t-sm-15 m-t-xs-15 m-t-20">'+
                                    '<label class="m-0 font-600 font-11">@lang('frontsistema.alta_de_cuentas.dest_int_bank_country')</label>'+
                                    '<select class="form-control input-black" type="text" id="adc_int_bank_country" name="adc_int_bank_country" data-parsley-trigger="change" required guardar="SI">'+
                                        '<option value=""></option>'+
                                        @foreach($countries as $key=>$country)
                                            '<option value="@php echo $country['name'] @endphp" data-id="@php echo $country['id'] @endphp">@php echo $country['name'] @endphp</option>'+
                                        @endforeach
                                    '</select>'+
                                    '<div class="form-error">@lang('frontsistema.alta_de_cuentas.dest_int_bank_cou_err')</div>'+
                                '</div>'+
                                '<div class="col-xl-6 col-lg-6 col-md-6 m-t-minus-5 m-t-sm-15 m-t-xs-15 m-t-20">'+
                                    '<label class="m-0 font-600 font-11">@lang('frontsistema.alta_de_cuentas.account_number')</label>'+
                                    '<input class="form-control input-black" type="text" id="adc_dest_int_account_number" name="adc_dest_int_account_number" data-parsley-trigger="change" data-parsley-type="number" required guardar="SI" />'+
                                    '<div class="form-error">@lang('frontsistema.alta_de_cuentas.account_number_error')</div>'+
                                '</div>'+
                            '</div>'+
                            '<div class="row">'+
                                '<div class="col-xl-3 col-lg-6 col-md-6 m-t-minus-5 m-t-sm-15 m-t-xs-15 m-t-20">'+
                                    '<label class="m-0 font-600 font-11">@lang('frontsistema.alta_de_cuentas.dest_bank_swift')</label>'+
                                    '<input class="form-control input-black" type="text" id="adc_dest_int_swift" name="adc_dest_int_swift" data-parsley-trigger="change" required guardar="SI" />'+
                                    '<div class="form-error">@lang('frontsistema.alta_de_cuentas.dest_bank_swift_error')</div>'+
                                '</div>'+
                                '<div class="col-xl-6 col-lg-6 col-md-6 m-t-minus-5 m-t-sm-15 m-t-xs-15 m-t-20">'+
                                    '<label class="m-0 font-600 font-11">@lang('frontsistema.alta_de_cuentas.dest_int_bank_label')</label>'+
                                    '<input class="form-control input-black" type="text" id="adc_dest_int_bank_name" name="adc_dest_int_bank_name" data-parsley-trigger="change" required guardar="SI" />'+
                                    '<div class="form-error">@lang('frontsistema.alta_de_cuentas.dest_int_bank_error')</div>'+
                                '</div>'+
                            '</div>'+
                            '<div class="row">'+
                                '<div class="col-xl-6 offset-xl-3 col-lg-6 col-md-6 m-t-minus-5 m-t-sm-15 m-t-xs-15 m-t-20">'+
                                    '<label class="m-0 font-600 font-11">@lang('frontsistema.alta_de_cuentas.dest_bank_address')</label>'+
                                    '<input class="form-control input-black" type="text" id="adc_dest_int_bank_address" name="adc_dest_int_bank_address" data-parsley-trigger="change" required guardar="SI" />'+
                                    '<div class="form-error">@lang('frontsistema.alta_de_cuentas.dest_bank_error')</div>'+
                                '</div>'+
                            '</div>';
                $('#intermediate_bank_div').html(html);
            }
            else {
                $('#intermediate_bank_div').html('');
            }
        });
    </script>
@endsection