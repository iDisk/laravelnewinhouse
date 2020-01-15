@extends('layouts.front_vertical_menu')
@php
    $accountName = $account->primary_client ? $account->primary_client->full_name : '';
@endphp
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
                    <h4 class="page-title">@lang('frontsistema.diversifique.title')</h4>
                    <div class="web_logo">
                        <img class="" src="{{ url('assets/images/logo_espacios.png')}}" alt="" height="50">
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
        <div class="row" id="main_section">
            <div class="col-xl-12 p-l-xs-30">
                <div id="basic-form" action="#">
                    <div>
                        <h3>
                            <span class="text">
                                @lang('frontsistema.diversifique.first_main_title')</h3>
                            </span>
                        </h3>
                        <section>
                            <form id="first_form" name="first_form">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="row m-b-30 on_load">
                                            <div class="col-xl-4 col-lg-4 col-md-6 m-t-minus-5 m-t-sm-5 m-t-xs-5 m-t-20">
                                                <label class="m-0 font-600 font-11">@lang('frontsistema.diversifique.account_label')</label>
                                                <select class="form-control input-black" id="from_account" name="from_account" data-parsley-trigger="change" value="" required guardar="SI">
                                                    <option value=""></option>
                                                    <option value="@lang('frontsistema.diversifique.new_investment')">@lang('frontsistema.diversifique.new_investment')</option>
                                                    @foreach($payment_accounts as $key=>$payment_account)
                                                        <option value="{{ $payment_account['instrument_label'] }}">{{ $payment_account['instrument_label'] }}</option>
                                                    @endforeach
                                                </select>
                                                <div class="form-error">@lang('frontsistema.diversifique.account_label_error')</div>
                                            </div>
                                            <!-- <input type="hidden" name="from_account_text" id="from_account_text" value="" guardar="SI" /> -->
                                            <div class="col-xl-4 col-lg-4 col-md-6 m-t-minus-5 m-t-sm-15 m-t-xs-15 m-t-20">
                                                <label class="m-0 font-600 font-11">@lang('frontsistema.diversifique.product_hire_label')</label>
                                                <select class="form-control input-black" type="text" id="product_hire" name="product_hire" data-parsley-trigger="change" required guardar="SI">
                                                    <option value=""></option>
                                                    <!-- <option value="@lang('frontsistema.diversifique.product_hire_label')">@lang('frontsistema.diversifique.product_hire_label')</option> -->
                                                    @foreach($instrument_list as $key=>$instrument)
                                                        <option value="{{ $key }}">{{ $instrument }}</option>
                                                    @endforeach
                                                </select>
                                                <div class="form-error">@lang('frontsistema.diversifique.product_hire_label_error')</div>
                                            </div>
                                            <div class="col-xl-4 col-lg-4 col-md-6 m-t-minus-5 m-t-sm-15 m-t-xs-15 m-t-20">
                                                <label class="m-0 font-600 font-11">@lang('frontsistema.diversifique.exp_date_label')</label>
                                                <input class="form-control input-black" type="text" id="expiration_date" name="expiration_date" onkeydown="return false" autocomplete="off" data-parsley-keyup="change" required placeholder="" guardar="SI">
                                                <div class="form-error">@lang('frontsistema.diversifique.exp_date_error')</div>
                                            </div>
                                            <div class="col-xl-4 col-lg-4 col-md-6 m-t-minus-5 m-t-sm-15 m-t-xs-15 m-t-20">
                                                <label class="m-0 font-600 font-11">@lang('frontsistema.diversifique.amount_label')</label>
                                                <input class="form-control input-black" type="text" id="amount" name="amount" data-parsley-pattern="\s*[1-9]\d*(\.\d{1,2})?\s*" data-parsley-trigger="change" required guardar="SI">
                                                <div class="form-error">@lang('frontsistema.diversifique.amount_label_error')</div>
                                            </div>
                                            <div class="col-xl-4 col-lg-4 col-md-6 m-t-minus-5 m-t-sm-15 m-t-xs-15 m-t-20">
                                                <label class="m-0 font-600 font-11">@lang('frontsistema.diversifique.application_date')</label>
                                                <input class="form-control input-black" type="text" id="application_date" name="application_date" onkeydown="return false" autocomplete="off" data-parsley-keyup="change" required placeholder="" guardar="SI">
                                                <div class="form-error">@lang('frontsistema.diversifique.application_date_err')</div>
                                            </div>
                                            <div class="col-xl-2 col-lg-1 col-md-6 m-t-sm-15 m-t-xs-15 m-t-xl-40 m-t-30 text-right custom-text-sm-left text-xs-left">
                                                <label class="m-0 font-600 font-12 line-height-sm-initial line-height-xs-initial">@lang('frontsistema.diversifique.expiration_inst')</label>
                                            </div>
                                            <div class="col-xl-2 col-lg-3 col-md-6 m-t-minus-5 m-t-sm-15 m-t-xs-15 m-t-30">
                                                <div class="radio">
                                                    <label for="opt1">
                                                        <input type="radio" name="instruction" value="@lang('frontsistema.diversifique.instruction_1')" id="opt1" data-parsley-trigger="change" guardar-rdo="SI">
                                                        <span class="cr"><i class="cr-icon mdi mdi-checkbox-blank-circle"></i></span>
                                                        @lang('frontsistema.diversifique.instruction_1')
                                                    </label>
                                                    <br/>
                                                    <label for="opt2">
                                                        <input type="radio" name="instruction" value="@lang('frontsistema.diversifique.instruction_2')" id="opt2" data-parsley-trigger="change" required guardar-rdo="SI">
                                                        <span class="cr"><i class="cr-icon mdi mdi-checkbox-blank-circle"></i></span>
                                                        @lang('frontsistema.diversifique.instruction_2')
                                                    </label>
                                                    <div class="form-error">@lang('frontsistema.diversifique.expiration_inst_err')</div>
                                                </div>
                                            </div>
                                            <!-- end col -->
                                        </div>
                                        <div class="row m-t-10 m-b-30">
                                            <div class="col-xl-12 text-center">
                                                <a class="text-aqua-blue m-r-10 cursor-pointer line-height-35" href="{{ route('client_home') }}">@lang('frontsistema.btn_cancel')</a>
                                                <button class="btn btn-aqua-blue waves-effect waves-light" type="submit">@lang('frontsistema.diversifique.add_registration')</button>
                                            </div>
                                        </div>
                                        <div class="row on_load">
                                            <div class="col-xl-12 col-lg-12 col-md-12">
                                                <div class="card help_card_widget">
                                                    <div class="card-body">
                                                        <p class="m-0">
                                                            @lang('frontsistema.diversifique.help_msg1') <a href="javascript:void(0)" class="open_contact_us_form">@lang('frontsistema.click_here')</a> @lang('frontsistema.diversifique.help_msg2') 
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </section>
                        <h3>
                            <span class="text">
                                @lang('frontsistema.diversifique.second_main_title')
                            </span>
                        </h3>
                        <section>
                            <form id="second_form" name="second_form">
                                <div class="row">
                                    <div class="col-12">
                                        <h5 class="font-16 font-600">@lang('frontsistema.diversifique.second_title')</h5>
                                        <div class="row on_load verification_head font_primary_color">
                                            <div class="col-xl-4 m-t-30 col-lg-6 col-md-6 text-center text-lg-left text-md-left custom-text-sm-left text-xs-left">
                                                <span class="title">
                                                    @lang('frontsistema.diversifique.user_label')
                                                </span>
                                                {{$accountName}}
                                            </div>
                                        </div>
                                        <div class="table">
                                            <div class="row m-t-50 m-b-10 on_load verification_table_title font_primary_color">
                                                <div class="col-1 text-center p-l-r-5"></div>
                                                <div class="col-2 text-center p-l-r-5">
                                                    @lang('frontsistema.diversifique.account_label')
                                                </div>
                                                <div class="col-2 text-center p-l-r-5">
                                                    @lang('frontsistema.diversifique.product_hire_label')
                                                </div>
                                                <div class="col-1 text-center p-l-r-5">
                                                    @lang('frontsistema.diversifique.exp_date_label')
                                                </div>
                                                <div class="col-1 text-center p-l-r-5">
                                                    @lang('frontsistema.diversifique.amount_label')
                                                </div>
                                                <div class="col-1 text-center p-l-r-5">
                                                    @lang('frontsistema.diversifique.application_date')
                                                </div>
                                                <div class="col-2 text-center p-l-r-5">
                                                    @lang('frontsistema.diversifique.expiration_inst')
                                                </div>
                                                <div class="col-1 text-center p-l-r-5">
                                                    @lang('frontsistema.diversifique.status_label')
                                                </div>
                                                <div class="col-1 text-center p-l-r-5"></div>
                                            </div>
                                            <div id="pendingRequests">
                                            </div>
                                            <input type="radio" name="verification" value="verification" id="verification" data-parsley-trigger="change" required style="display: none;">
                                        </div>
                                        <div class="form-error verificationError">@lang('frontsistema.diversifique.verification_error')</div>
                                        <div class="row m-t-30 m-b-30">
                                            <div class="col-xl-12 text-center">
                                                <a class="text-aqua-blue m-r-10 cursor-pointer line-height-35" href="{{route('client_home')}}">@lang('frontsistema.btn_cancel')</a>
                                                <a class="text-aqua-blue m-r-10 cursor-pointer line-height-35 previousWizard" href="javascript:void(0)">@lang('frontsistema.btn_back')</a>
                                                <button class="btn btn-aqua-blue waves-effect waves-light" type="submit" id="second_form_submit">@lang('frontsistema.diversifique.submit_label')</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>

                            <!-- otp verification section -->
                            <form id="otp_form" name="otp_form" style="display: none;">
                                <div class="row">
                                    <h5 class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 m-t-sm-15 m-t-xs-15">@lang('frontsistema.diversifique.code_label')</h5><br>
                                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-xs-12 m-t-minus-5 m-t-sm-15 m-t-xs-15">
                                        <label class="m-0 font-600 font-11">@lang('frontsistema.diversifique.code')</label>
                                        <input class="form-control input-black" type="number" id="code" name="code"data-parsley-type="integer" data-parsley-trigger="change" autocomplete="off" required onKeyDown="changedField()">
                                        <div class="form-error">@lang('frontsistema.diversifique.code_error')</div>
                                        <div class="otp-error" style="color: red;"></div>
                                    </div>
                                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-xs-12 m-t-minus-5 m-t-sm-15 m-t-xs-15">
                                        <label class="m-0 font-600 font-11">&nbsp;</label>
                                        <button class="btn btn-block btn-aqua-blue waves-effect waves-light">@lang('frontsistema.diversifique.submit_label')</button>
                                    </div>
                                </div>
                                <div class="row m-b-30 on_load">
                                    <div class="col-xl-4 col-lg-6">
                                        <a class="text-aqua-blue m-r-10 cursor-pointer line-height-35 resendOtp" href="javascript:void(0)">@lang('frontsistema.diversifique.request_another_code')</a>
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
                <h3 class="font-600">@lang('frontsistema.diversifique.success_msg_title')</h3>
                <a class="text-aqua-blue m-t-20 cursor-pointer line-height-35" href="{{ route('client_home') }}">@lang('frontsistema.diversifique.back_to_home')</a>
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
    
    // $('a[href="#next"]').click();

        initParsleyValidation();
        initDatepicker('application_date', '+1d', null);
        initDatepicker('expiration_date', '+1d', null);

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
                // Move to the next wizard
                try {
                    submitFirstForm();
                    return false; // Don't submit form for this demo
                } catch (error) {
                    console.log(error);
                }
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
                try {
                    submitSecondForm();
                    return false; // Don't submit form for this demo
                } catch (error) {
                    console.log(error);
                }
            });
            
            $('#otp_form').parsley().on('field:validated', function (e) {
               
            })
            .on('form:submit', function () {
                codeVerification();
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

        $('body').on('change', '#from_account', function() {
            // $('#from_account_text').val($("#from_account option:selected").html());
        });

        // prepare first_form request data
        function prepareFormRequest(form_id){
            let req_data = '{';

            form_id.find(':input').each(function() 
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

                if($(this).attr("guardar-rdo")=="SI" && $(this).prop("checked") == true)
                {
                    if(req_data != '{'){
                        req_data += ',';
                    }
                    req_data += '"'+ $(this).attr("name") +'":{"type":"text","value":"'+$(this).val()+'"}'; 
                }

            });

            req_data += '}';
            return req_data;
        }
        

        $('body').on('change', '#payment_account', function() {
            $('#payment_account_text').val($("#payment_account option:selected").html());
        });
        var pending_requests = [];

        // Function to handle the submit of first form after successful validation
        function submitFirstForm(){
            let token = $('#_token').val();
            let req_data = prepareFormRequest($('#first_form'));
            $.ajax({
                type: 'POST',
                dataType: 'json',
                data: {'_token':token,'text':req_data,'request_type_id':16,'verify':2,'from':'Diversifique'},
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
                            url: "{{ url('user/pending_internal_transfers') }}" + '?_token=' + token + '&user_id=' + '{{$user_id}}' + '&account_id=' + '{{$account["id"]}}' + '&request_type_id=16',
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
                                                                        pending_requests[i].parsedText.from_account.value+
                                                                    '</div>'+
                                                                    '<div class="col-2 text-center p-l-r-5">'+
                                                                    pending_requests[i].parsedText.product_hire.value
                                                                    +'</div>'+
                                                                    '<div class="col-1 text-center p-l-r-5">'+
                                                                    pending_requests[i].parsedText.expiration_date.value
                                                                    +'</div>'+
                                                                    '<div class="col-1 text-center p-l-r-5">'+
                                                                        '$ ' + numberWithCommas(pending_requests[i].parsedText.amount.value)+
                                                                    '</div>'+
                                                                    '<div class="col-1 text-center p-l-r-5">'
                                                                        + pending_requests[i].parsedText.application_date.value+
                                                                    '</div>'+
                                                                    '<div class="col-2 text-center p-l-r-5">'
                                                                        + pending_requests[i].parsedText.instruction.value+
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

        function submitSecondForm(){
            show_loader(true);

            $.ajax({
                type: 'POST',
                dataType: 'json',
                data: {'_token':'{{csrf_token()}}'},
                url: "{{ url('user/generate_code') }}",
                beforeSend: function() {
                    //$('#modal-espere').modal('show');
                },
                success: function(response) {
                    if (response.error && response.code == '500'){
                    
                        // $('#verificarWarningMsg').html(response.message);
                        // $('.verificarFormWarning').toggleClass('d-none', false);
                        swal({
                            title: "{{ __('frontsistema.confirm') }}",
                            text: response.message,
                            type: "warning",
                            showCancelButton: true,
                            confirmButtonColor: '#8cd5dd',
                            confirmButtonText: "{{ __('frontsistema.btn_yes') }}",
                            cancelButtonText: "No"
                        })
                    }
                    else if(!response.error && response.code == '200'){
                        // $('a[href="#next"]').click();
                        $('#second_form_submit').prop('disabled', true);
                        $('#otp_form').show();
                        $('html, body').animate({
                            scrollTop: $("#otp_form").offset().top
                        }, 1000);
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

        // Function to handle the change event of pending requests radio button
        var client_request_id = 0;
        $('body').on('change', 'input[type=radio][name=verification]', function() {
            selectedIndex = $(this).val().replace('verification', '');
            client_request_id = (pending_requests[selectedIndex].id) ? pending_requests[selectedIndex].id : 0;
        });

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
                        swal("@lang('frontsistema.users_alert')", "@lang('frontsistema.entre_mis_cuentas.otp_resent')", 'success');
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

        // Function to handle code verification
        function codeVerification(){
            $('.otp-error').html('');
            let token = $('#_token').val();
            $.ajax({
                type: 'POST',
                dataType: 'json',
                data: {'_token':token, 'code': $('#code').val(), 'client_request_id': client_request_id},
                url: "{{ url('user/verify_request') }}",
                beforeSend: function() {
                    //$('#modal-espere').modal('show');
                    show_loader(true);
                },
                success: function(response) {
                    if (response.error && response.code == '500'){
                        // swal("@lang('frontsistema.users_alert')", response.message, 'error');
                        // $('.otp-error').show();
                        $('.otp-error').html(response.message);
                    }
                    else if(!response.error && response.code == '200'){
                        // Reset all the forms and show success dialog
                        $("#main_section").hide();
                        $("#first_form").trigger("reset");
                        $("#second_form").trigger("reset");
                        $('.on_success').show();
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
        }


        // Function to handle the deletion of pending requests
        $('body').on('click', '.deleteVerification', function() {
            let token = $('#_token').val();
            var deleteConfirmId = $(this).data('id');
            swal({
                title: "{{ __('frontsistema.confirm') }}",
                text: "{{ __('frontsistema.entre_mis_cuentas.request_del_confirm') }}",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: '#8cd5dd',
                confirmButtonText: "{{ __('frontsistema.btn_yes') }}",
                cancelButtonText: "No"
            })
            .then(function () {
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
                            swal("@lang('frontsistema.users_alert')", "@lang('frontsistema.entre_mis_cuentas.request_deleted')", 'success');
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

        function numberWithCommas(x) {
            var x = (x!=undefined && x!='')? x : 0;
            return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }

        function changedField(){
            $('.otp-error').html('');
        }


    </script>
@endsection
