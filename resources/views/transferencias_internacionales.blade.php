@extends('layouts.front_vertical_menu')
@section('customcss')
<!--Form Wizard-->
<link rel="stylesheet" type="text/css" href="{{ url('assets/plugins/jquery.steps/css/jquery.steps.css') }}" />
<link href="{{ url('assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet">
<!-- Bootstrap fileupload css -->
<link href="{{ url('assets/plugins/bootstrap-fileupload/bootstrap-fileupload.css') }}" rel="stylesheet" />
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
    @media (min-width: 1200px) {
        .wizard > .content {
            min-height: 70em;
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
        .wizard > .steps > ul > li > a, .wizard > .steps .done a {
            padding: 8px 5px !important;
            margin: 0 !important;
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
            padding: 8px 5px !important;
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
                    <h4 class="page-title">@lang('frontsistema.transferencias_internacionales.title')</h4>
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
                                @lang('frontsistema.transferencias_internacionales.first_main_title')</h3>
                            </span>
                        </h3>
                        <section>
                            <form id="transferencias_internacionalesForm" name="first_form">
                                <div class="row m-b-10 m-t-xs-15 on_load">
                                    <div class="col-xl-4 offset-xl-4 offset-xs-4 col-lg-4 offset-lg-4 col-md-8 offset-md-2 text-center">
                                        <p class="m-0 font-600">@lang('frontsistema.transferencias_internacionales.saldo_label')</p>
                                        <h3 class="text-custom-info font-600 m-t-0" id="saldoBalance">-</h3>
                                        <input type="hidden" id="saldoBalance_calc" name="saldoBalance_calc" value="0">
                                    </div>
                                </div>
                                <div class="row m-t-20">
                                    <div class="col-12">
                                        <h5 class="font-16 font-600">@lang('frontsistema.transferencias_internacionales.first_title')</h5>
                                        <div class="row on_load">
                                            <div class="col-xl-4 col-lg-6 col-md-12 m-t-minus-5 m-t-sm-5 m-t-xs-15 m-t-20">
                                                <label class="m-0 font-600 font-11">@lang('frontsistema.transferencias_internacionales.select_account_label')<sup>*</sup></label>
                                                <select class="form-control input-black" id="account" name="ti_account" data-parsley-trigger="change" value="" required guardar="SI">
                                                    <option value=""></option>
                                                    @foreach($payment_accounts as $key=>$payment_account)
                                                        <option value="{{ $payment_account['instrument_label'] }}" data-saldo="{{ $payment_account['saldo'] }}">{{ $payment_account['instrument_label'] }}</option>
                                                    @endforeach
                                                </select>
                                                <div class="form-error">@lang('frontsistema.transferencias_internacionales.select_account_error')</div>
                                            </div>
                                            <div class="col-xl-4 col-lg-6 col-md-12 m-t-minus-5 m-t-sm-15 m-t-xs-15 m-t-13">
                                                <label class="m-0 font-600 font-11">@lang('frontsistema.transferencias_internacionales.shortage_funds_label')<sup>*</sup></label>
                                                <select class="form-control input-black" type="text" id="shortage_funds_account" name="ti_shortage_funds_account" data-parsley-trigger="change" required guardar="SI">
                                                    <option value=""></option>
                                                    @foreach($payment_accounts as $key=>$payment_account)
                                                        <option value="{{ $payment_account['instrument_label'] }}" data-saldo="{{ $payment_account['saldo'] }}">{{ $payment_account['instrument_label'] }}</option>
                                                    @endforeach
                                                </select>
                                                <div class="form-error">@lang('frontsistema.transferencias_internacionales.shortage_funds_error')</div>
                                            </div>
                                            <div class="col-xl-4 col-lg-6 col-md-12 m-t-minus-5 m-t-sm-15 m-t-xs-15 m-t-25">
                                                <br>
                                                <div class="checkbox checkbox-custom m-t-10 line-height-20">
                                                    <label class="m-b-0 ckCursor" for="send_receipt">
                                                        <input type="checkbox" value="@lang('frontsistema.transferencias_internacionales.yes')" name="ti_send_receipt" id="send_receipt" guardar-chk="SI">
                                                        <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                        @lang('frontsistema.transferencias_internacionales.send_receipt')
                                                    </label>
                                                </div>
                                            </div>
                                            <!-- end col -->
                                        </div>
                                        <div class="row m-b-10 on_load">
                                            <div class="col-xl-4 col-lg-6 col-md-12 m-t-minus-5 m-t-sm-5 m-t-xs-15 m-t-20">
                                                <label class="m-0 font-600 font-11">@lang('frontsistema.transferencias_internacionales.beneficiary_label')<sup>*</sup></label>
                                                <select class="form-control input-black" id="beneficiary" name="ti_beneficiary" data-parsley-trigger="change" value="" required guardar="SI">
                                                    <option value=""></option>
                                                    @foreach($user_other_accounts as $user_other_account)
                                                        <option value="{{ $user_other_account->dest_account_number.' - '.$user_other_account->first_name.' - '.$user_other_account->instrument }}" data-id="{{ $user_other_account->id }}">{{ $user_other_account->dest_account_number.' - '.$user_other_account->first_name.' - '.$user_other_account->instrument }}</option>    
                                                    @endforeach
                                                </select>
                                                <div class="form-error">@lang('frontsistema.transferencias_internacionales.beneficiary_error')</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="displayBeneficiaryData">

                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <h5 class="font-12 font-600 m-t-30 m-b-0">@lang('frontsistema.transferencias_internacionales.middle_title_second')</h5>
                                        <div class="row on_load">
                                            <div class="col-xl-4 col-lg-6 col-md-12 m-t-minus-5 m-t-sm-15 m-t-xs-15 m-t-20">
                                                <label class="m-0 font-600 font-11">@lang('frontsistema.transferencias_internacionales.amount_label')<sup>*</sup></label>
                                                <input class="form-control input-black" type="text" id="m_amount" name="ti_amount" data-parsley-pattern="\s*[1-9]\d*(\.\d{1,2})?\s*" data-parsley-trigger="change" required guardar="SI">
                                                <div class="form-error">@lang('frontsistema.transferencias_internacionales.amount_label_error')</div>
                                            </div>
                                            <div class="col-xl-4 col-lg-6 col-md-12 m-t-minus-5 m-t-sm-15 m-t-xs-15 m-t-20">
                                                <label class="m-0 font-600 font-11">@lang('frontsistema.transferencias_internacionales.charges_label')<sup>*</sup></label>
                                                <select class="form-control input-black" id="cargo" name="ti_cargo" data-parsley-trigger="change" value="" required guardar="SI">
                                                    <option value=""></option>
                                                    @foreach(config('site.cargos') as $key => $cargo)
                                                        <option value="{{ $cargo[session('language')] }}">{{ $cargo[session('language')] }}</option>
                                                    @endforeach
                                                </select>
                                                <div class="form-error">@lang('frontsistema.transferencias_internacionales.charges_error')</div>
                                            </div>
                                            <div class="col-xl-4 col-lg-6 col-md-12 m-t-minus-5 m-t-sm-15 m-t-xs-15 m-t-20">
                                                <label class="m-0 font-600 font-11">@lang('frontsistema.transferencias_internacionales.value_date_label')<sup>*</sup></label>
                                                <input class="form-control input-black" type="text" id="value_date" name="ti_value_date" onkeydown="return false" autocomplete="off" data-parsley-keyup="change" placeholder="" required guardar="SI">
                                                <div class="form-error">@lang('frontsistema.transferencias_internacionales.value_date_error')</div>
                                            </div>
                                            <div class="col-xl-4 col-lg-6 col-md-12 m-t-minus-5 m-t-sm-15 m-t-xs-15 m-t-20">
                                                <label class="m-0 font-600 font-11">@lang('frontsistema.transferencias_internacionales.execution_date_label')<sup>*</sup></label>
                                                <input class="form-control input-black" type="text" id="execution_date" name="ti_execution_date" onkeydown="return false" autocomplete="off" data-parsley-keyup="change" placeholder="" required guardar="SI">
                                                <div class="form-error">@lang('frontsistema.transferencias_internacionales.execution_date_error')</div>
                                            </div>
                                            <div class="col-xl-8 col-lg-12 col-md-12 m-t-minus-5 m-t-sm-5 m-t-xs-15 m-t-20">
                                                <label class="m-0 font-600 font-11">@lang('frontsistema.transferencias_internacionales.transfer_detail_label')<sup>*</sup></label>
                                                <input class="form-control input-black" type="text" id="transfer_details1" name="ti_transfer_details1" data-parsley-trigger="change" placeholder="" required guardar="SI">
                                                <input class="form-control input-black m-t-10" type="text" id="transfer_details2" name="ti_transfer_details2" data-parsley-trigger="change" placeholder="" guardar="SI">
                                                <div class="form-error">@lang('frontsistema.transferencias_internacionales.transfer_detail_error')</div>
                                            </div>
                                            <div class="col-lg-12">
                                                <label class="font-600 m-t-10">@lang('frontsistema.transferencias_internacionales.payment_docs_label')</label>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="form-group row file_upload_wrapper">
                                                    <div class="file_upload_block col-lg-10 row">
                                                        <div class="controls col-md-4">
                                                            <div class="fileupload fileupload-new" data-provides="fileupload">
                                                                <label class="font-14 font-600 m-r-10 fileLable">Archivo 1:</label>
                                                                <button type="button" class="btn btn-aqua-blue btn-file">
                                                                    <span class="fileupload-new"><i class="fa fa-paper-clip"></i> @lang('frontsistema.adjuste_de_permisos.select_file_btn')</span>
                                                                    <span class="fileupload-exists"><i class="fa fa-undo"></i> @lang('frontsistema.adjuste_de_permisos.change_btn')</span>
                                                                    <input type="file" id="document1" name="user_document[]" class="btn-secondary" accept=".jpg,.gif,.png,.pdf" onChange="validDocumentFile(event)" />
                                                                </button>
                                                                <span class="fileupload-preview" style="margin-left:5px;"></span>
                                                                <a href="#" class="close fileupload-exists btn btn-file-cross" data-dismiss="fileupload" style="float: none; margin-left:5px;"><i class="fa fa-times"></i></a>
                                                                <div class="file_upload_error"></div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-8 p-l-0">
                                                            <button type="button" class="btn btn-aqua-blue" id="btnAddMoreFiles">Agregar otro +</button>
                                                        </div>
                                                    </div>
                                                    <div class="additional_blocks">
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- end col -->
                                        </div>
                                        {{--
                                        <div class="row m-t-30 m-b-30">
                                            <div class="col-xl-12">
                                                <div class="gray-section p-20 p-b-30">
                                                    <label class="m-0 font-600 font-14">@lang('frontsistema.transferencias_internacionales.charges_section_title')</label>
                                                    <div class="row m-t-10">
                                                        <div class="col-xl-4">
                                                            <label class="m-0 font-600 font-11">@lang('frontsistema.transferencias_internacionales.transfer_commission')</label>
                                                            <div class="field-value">1500</div>
                                                        </div>
                                                        <div class="col-xl-4">
                                                            <label class="m-0 font-600 font-11">&nbsp;</label>
                                                            <div class="field-value">1500</div>
                                                        </div>
                                                    </div>
                                                    <div class="row m-t-10">
                                                        <div class="col-xl-4">
                                                            <label class="m-0 font-600 font-11">@lang('frontsistema.transferencias_internacionales.processing_fees')</label>
                                                            <div class="field-value">1500</div>
                                                        </div>
                                                        <div class="col-xl-4">
                                                            <label class="m-0 font-600 font-11">&nbsp;</label>
                                                            <div class="field-value">1500</div>
                                                        </div>
                                                    </div>
                                                    <div class="row m-t-10">
                                                        <div class="col-xl-4">
                                                            <label class="m-0 font-600 font-11">@lang('frontsistema.transferencias_internacionales.total_charges')</label>
                                                            <div class="field-value">1500</div>
                                                        </div>
                                                        <div class="col-xl-4">
                                                            <label class="m-0 font-600 font-11">&nbsp;</label>
                                                            <div class="field-value">1500</div>
                                                        </div>
                                                    </div>
                                                    <div class="row m-t-10">
                                                        <div class="col-xl-8">
                                                            <label class="m-0 font-600 font-11">@lang('frontsistema.transferencias_internacionales.total_debit_amount')</label>
                                                            <div class="field-value">1500</div>
                                                        </div>
                                                    </div>
                                                    <div class="row m-t-10">
                                                        <div class="col-xl-8">
                                                            <h5 class="font-16">@lang('frontsistema.transferencias_internacionales.transfer_conditions')</h5>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> --}}
                                        <div class="row on_load m-t-20">
                                            <div class="col-xl-12 col-lg-12 col-md-12">
                                                <h5 class="font-14 terms-div-border">
                                                    {!! (session('language') == 'es' ? $broker_setting['international_transfer_disclaimer_es'] : $broker_setting['international_transfer_disclaimer_en']) !!}
                                                    <div class="checkbox checkbox-custom m-t-0 line-height-20">
                                                        <label class="m-b-0 ckCursor" for="disclaimer">
                                                            <input type="checkbox" value="1" name="disclaimer" id="disclaimer" required parsley-trigger="change">
                                                            <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                            @lang('frontsistema.transferencias_internacionales.accept_text')<sup>*</sup>
                                                        </label>
                                                        <div class="form-error">@lang('frontsistema.transferencias_internacionales.terms_error')</div>
                                                    </div>
                                                </h5>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xl-4 offset-xl-8 col-lg-6 offset-lg-6 text-right">
                                                <label class="m-0 font-600 font-11">&nbsp;</label>
                                                <button class="btn btn-block btn-aqua-blue waves-effect waves-light" type="submit">@lang('frontsistema.transferencias_internacionales.submit_label')</button>
                                            </div>
                                        </div>
                                        <div class="row m-t-10 m-b-30">
                                            <div class="col-xl-12">
                                                <h5 class="font-16">@lang('frontsistema.transferencias_internacionales.required_help')</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </section>
                        
                        <h3>
                            <span class="text">
                                @lang('frontsistema.transferencias_internacionales.second_main_title')
                            </span>
                        </h3>
                        <section>
                            <form id="second_form" name="second_form">
                                <div class="row">
                                    <div class="col-12">
                                        <h5 class="font-16 font-600">@lang('frontsistema.transferencias_internacionales.second_title')</h5>
                                        <div class="row on_load verification_head">
                                            <div class="col-xl-12 m-t-30 col-lg-12 col-md-12 text-center text-lg-left text-md-left custom-text-sm-left text-xs-left">
                                                <span class="title">
                                                    @lang('frontsistema.entre_mis_cuentas.user_label')
                                                </span>
                                                {{$accountName}}
                                            </div>
                                        </div>
                                        <div class="table">
                                            <div class="row m-t-50 m-b-10 on_load verification_table_title">
                                                <div class="col-1 text-center p-l-r-5"></div>
                                                <div class="col-2 text-center p-l-r-5">
                                                    @lang('frontsistema.transferencias_internacionales.value_date_label'):
                                                </div>
                                                <div class="col-2 text-center p-l-r-5">
                                                    @lang('frontsistema.transferencias_internacionales.charge_account'):
                                                </div>
                                                <div class="col-2 text-center p-l-r-5">
                                                    @lang('frontsistema.transferencias_internacionales.payment_account'):
                                                </div>
                                                <div class="col-2 text-center p-l-r-5">
                                                    @lang('frontsistema.transferencias_internacionales.amount_label'):
                                                </div>
                                                <div class="col-2 text-center p-l-r-5">
                                                    @lang('frontsistema.transferencias_internacionales.status_label')
                                                </div>
                                                <div class="col-1 text-center p-l-r-5"></div>
                                            </div>
                                            <div id="pendingRequests">
                                            </div>
                                            <input type="radio" name="verification" value="verification" id="verification" data-parsley-trigger="change" required style="display: none;">
                                        </div>
                                        <div class="form-error verificationError">@lang('frontsistema.transferencias_internacionales.verification_error')</div>
                                        <div class="row m-t-30 m-b-30">
                                            <div class="col-xl-12 text-right">
                                                <button class="btn btn-aqua-blue waves-effect waves-light" type="submit">@lang('frontsistema.transferencias_internacionales.submit_label')</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </section>
                        <h3>
                            <span class="text">
                                @lang('frontsistema.transferencias_internacionales.third_main_title')
                            </span>
                        </h3>
                        <section>
                            <form id="third_form" name="third_form">
                                <div class="row">
                                    <div class="col-xl-12 col-lg-12">
                                        <h5 class="font-16 font-600">@lang('frontsistema.entre_mis_cuentas.third_title')</h5>
                                        <div class="row m-t-30 m-b-30 on_load verification_head verification_box">
                                            <div class="col-xl-6 text-left m-t-10">
                                                <span class="title">
                                                    @lang('frontsistema.entre_mis_cuentas.user_label')
                                                </span>
                                                {{$accountName}}
                                            </div>
                                            <div class="col-xl-6 text-left m-t-10">
                                                <span class="title font-16">
                                                    @lang('frontsistema.entre_mis_cuentas.application_date'):
                                                </span>
                                                <span id="applicationDateVerify"></span>
                                            </div>
                                            <div class="col-xl-6 text-left m-t-10">
                                                <span class="title font-16">
                                                    @lang('frontsistema.entre_mis_cuentas.charge_account'):
                                                </span>
                                                <span id="fromAccountVerify"></span>
                                            </div>
                                            <div class="col-xl-6 text-left m-t-10">
                                                <span class="title font-16">
                                                    @lang('frontsistema.entre_mis_cuentas.payment_account'):
                                                </span>
                                                <span id="toAccountVerify"></span>
                                            </div>
                                            <div class="col-xl-6 text-left m-t-10">
                                                <span class="title font-16">
                                                    @lang('frontsistema.entre_mis_cuentas.amount_label'):
                                                </span>
                                                <span id="amountVerify"></span>
                                            </div>
                                        </div>
                                        <h5 class="font-16">@lang('frontsistema.entre_mis_cuentas.code_label')</h5>
                                        <div class="row on_load">
                                            <div class="col-xl-4 col-lg-6 col-md-6 m-t-minus-5 m-t-sm-15 m-t-xs-15 m-t-20">
                                                <label class="m-0 font-600 font-11">@lang('frontsistema.entre_mis_cuentas.code')</label>
                                                <input class="form-control input-black" type="number" id="code" name="code"data-parsley-type="integer" data-parsley-trigger="change" autocomplete="off" required>
                                                <div class="form-error">@lang('frontsistema.entre_mis_cuentas.code_error')</div>
                                            </div>
                                            <div class="col-xl-4 col-lg-6 col-md-6 m-t-minus-5 m-t-sm-15 m-t-xs-15 m-t-20">
                                                <label class="m-0 font-600 font-11">&nbsp;</label>
                                                <button class="btn btn-block btn-aqua-blue waves-effect waves-light">@lang('frontsistema.entre_mis_cuentas.submit_label')</button>
                                            </div>
                                        </div>
                                        <div class="row m-b-30 on_load">
                                            <div class="col-xl-4 col-lg-6">
                                                <a class="text-aqua-blue m-r-10 cursor-pointer line-height-35 resendOtp" href="javascript:void(0)">@lang('frontsistema.entre_mis_cuentas.request_another_code')</a>
                                            </div>
                                            <div class="col-xl-4 col-lg-6">
                                                <a class="text-aqua-blue m-r-10 cursor-pointer line-height-35 previousWizard">@lang('frontsistema.btn_back')</a>
                                            </div>
                                            <!-- end col -->
                                        </div>
                                        <div class="row on_load">
                                            <div class="col-xl-12 col-lg-12 col-md-12">
                                                <h5 class="font-16">
                                                    @lang('frontsistema.entre_mis_cuentas.help_msg3')
                                                    <a href="javascript:void(0)" class="open_contact_us_form blue">@lang('frontsistema.entre_mis_cuentas.contact')</a>
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
                <h3 class="font-600">@lang('frontsistema.transferencias_internacionales.success_msg_title')</h3>
                <p class="text-custom-info font-600 font-16 m-b-0 m-t-20">@lang('frontsistema.transferencias_internacionales.success_msg')</p>
                <div class="row m-t-20">
                    <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12 text-right text-md-center text-sm-center text-xs-center">
                        <a class="text-aqua-blue m-r-10 cursor-pointer line-height-35" href="{{ route('client_home') }}">@lang('frontsistema.transferencias_internacionales.back_to_home')</a>
                    </div>
                    <div class=" col-lg-6 col-md-12 col-sm-12 col-xs-12 text-left text-md-center text-sm-center text-xs-center">
                        <button id="submit-another-request" class="btn btn-aqua-blue waves-effect waves-light">@lang('frontsistema.transferencias_internacionales.request_more_finance')</button>
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
<script src="{{ url('assets/plugins/bootstrap-fileupload/bootstrap-fileupload.js') }}"></script>
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
        initDatepicker('value_date', '+1d', null);
        initDatepicker('execution_date', '+1d', null);

        $('#submit-another-request').click(function() {
            window.location.reload();
        });

        // Function to initialize the parsley validation
        function initParsleyValidation() {

            $('#transferencias_internacionalesForm').parsley().on('field:validated', function () {
                // console.log("first_form error");
            })
            .on('form:submit', function () {
                if(parseFloat($('#m_amount').val()) > parseFloat($('#saldoBalance_calc').val())){
                    swal("@lang('frontsistema.users_alert')", "@lang('frontsistema.entre_mis_cuentas.insuficient_amount_error')", 'error');
                }else{
                    submitTransferenciasForm();
                }
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


        $('body').on('change', '#account', function() {
            if($('#account').val()) {
                var str = $("#account option:selected").data('saldo');
                $('#saldoBalance').html('$ ' + str);
                $('#saldoBalance_calc').val(str.replace(new RegExp(',', 'g'), ''));
            }
            else {
                $('#saldoBalance').html('-');
                $('#saldoBalance_calc').val(0);
            }
        });

        
        $('body').on('change', '#beneficiary', function() {
            if($('#beneficiary').val()) {
                var id = $("#beneficiary option:selected").data('id');

                //ajax call to fetch user's other account information
                
                $.ajax({

                    type: 'GET',
                    dataType: 'json',
                    //data: {'id': $('#beneficiary').val()},
                    url: "{{ url('user/get_user_other_accounts') }}/" + id,
                    beforeSend: function() {
                        //$('#modal-espere').modal('show');
                        show_loader(true);
                    },
                    success: function(response) {
                        if (response.error && response.code == '500'){
                            $('#displayBeneficiaryData').html('');
                        }
                        else if(!response.error && response.code == '200'){
                            // Send the user to wizard 3 if OTP was successfully sent
                            //$('a[href="#next"]').click();
                            beneficiary_data = response.data;
                            var html = '';
                            html +='<div class="row">'+
                                '<div class="col-xl-12 m-t-20 m-b-minus-15">'+
                                    '<h5 class="font-16 font-600 m-0">Destinatario</h5>'+
                                '</div>'+
                                '<div class="col-xl-4 col-lg-6 col-md-4 m-t-minus-5 m-t-sm-15 m-t-xs-15 m-t-20">'+
                                    '<label class="m-0 font-600 font-11">@lang('frontsistema.alta_de_cuentas.type_of_account')</label>'+
                                    '<select class="form-control input-black" type="text" disabled="disabled">'+
                                        '<option value="'+ beneficiary_data.instrument +'">'+beneficiary_data.instrument+'</option>'+
                                    '</select>'+
                                '</div>'+
                                '<div class="col-xl-8 col-lg-6 col-md-8 m-t-minus-5 m-t-sm-15 m-t-xs-15 m-t-20">'+
                                    '<label class="m-0 font-600 font-11">@lang('frontsistema.alta_de_cuentas.account_name')</label>'+
                                    '<input class="form-control input-black" type="text" disabled="disabled" value="'+beneficiary_data.first_name+'">'+
                                '</div>'+
                            '</div>';

                            html += '<div class="row">'+
                                '<div class="col-xl-4 col-lg-6 col-md-4 m-t-minus-5 m-t-sm-15 m-t-xs-15 m-t-20">'+
                                    '<label class="m-0 font-600 font-11">@lang('frontsistema.alta_de_cuentas.telephone_label')</label>'+
                                    '<input class="form-control input-black" type="text" disabled="disabled" value="'+beneficiary_data.telephone+'">'+
                                '</div>'+
                                '<div class="col-xl-8 col-lg-6 col-md-8 m-t-minus-5 m-t-sm-15 m-t-xs-15 m-t-20">'+
                                    '<label class="m-0 font-600 font-11">@lang('frontsistema.alta_de_cuentas.address_label')</label>'+
                                    '<input class="form-control input-black" type="text" disabled="disabled" value="'+ beneficiary_data.address +'">'+
                                '</div>'+
                            '</div>';

                            html +='<div class="row">'+
                                '<div class="col-xl-4 col-lg-6 col-md-4 m-t-minus-5 m-t-sm-15 m-t-xs-15 m-t-20">'+
                                    '<label class="m-0 font-600 font-11">@lang('frontsistema.alta_de_cuentas.country_label')</label>'+
                                        '<select class="form-control input-black" disabled="disabled">'+
                                        '<option value="'+ beneficiary_data.al_country +'">'+ beneficiary_data.al_country +'</option>'+
                                        '</select>'+
                                '</div>'+
                                '<div class="col-xl-4 col-lg-6 col-md-4 m-t-minus-5 m-t-sm-15 m-t-xs-15 m-t-20">'+
                                    '<label class="m-0 font-600 font-11">@lang('frontsistema.alta_de_cuentas.state_label')</label>'+
                                    '<input type="text" class="form-control input-black" disabled="disabled" value="'+ beneficiary_data.state +'">'+
                                '</div>'+
                                '<div class="col-xl-4 col-lg-6 col-md-4 m-t-minus-5 m-t-sm-15 m-t-xs-15 m-t-20">'+
                                    '<label class="m-0 font-600 font-11">@lang('frontsistema.alta_de_cuentas.city_label')</label>'+
                                    '<input class="form-control input-black" type="text" disabled="disabled" value="'+ beneficiary_data.city +'">'+
                                '</div>'+
                            '</div>';

                            html +='<div class="row">'+
                                '<div class="col-xl-12 m-t-20 m-b-minus-15">'+
                                    '<h5 class="font-16 font-600 m-0">@lang('frontsistema.alta_de_cuentas.dest_account_label')</h5>'+
                                '</div>'+
                                '<div class="col-xl-4 col-lg-6 col-md-4 m-t-minus-5 m-t-sm-15 m-t-xs-15 m-t-20">'+
                                    '<label class="m-0 font-600 font-11">@lang('frontsistema.alta_de_cuentas.dest_bank_country')</label>'+
                                    '<select class="form-control input-black" disabled="disabled">'+
                                        '<option value="'+beneficiary_data.al_dest_bank_country+'">'+beneficiary_data.al_dest_bank_country+'</option>'+
                                    '</select>'+
                                '</div>'+
                                '<div class="col-xl-8 col-lg-6 col-md-8 m-t-minus-5 m-t-sm-15 m-t-xs-15 m-t-20">'+
                                    '<label class="m-0 font-600 font-11">@lang('frontsistema.alta_de_cuentas.account_number')</label>'+
                                    '<input class="form-control input-black" type="text" disabled="disabled" value="'+ beneficiary_data.dest_account_number +'" />'+
                                '</div>'+
                            '</div>'+
                            '<div class="row">'+
                                '<div class="col-xl-4 col-lg-6 col-md-8 m-t-minus-5 m-t-sm-15 m-t-xs-15 m-t-20">'+
                                    '<label class="m-0 font-600 font-11">@lang('frontsistema.alta_de_cuentas.dest_bank_swift')</label>'+
                                    '<input class="form-control input-black" type="text" disabled="disabled" value="'+ beneficiary_data.dest_swift +'"/>'+
                                '</div>'+
                                '<div class="col-xl-8 col-lg-6 col-md-8 m-t-minus-5 m-t-sm-15 m-t-xs-15 m-t-20">'+
                                    '<label class="m-0 font-600 font-11">@lang('frontsistema.alta_de_cuentas.dest_bank_label')</label>'+
                                    '<input class="form-control input-black" type="text" disabled="disabled" value="'+ beneficiary_data.dest_bank_name +'" />'+
                                '</div>'+
                            '</div>'+
                            '<div class="row">'+
                                '<div class="col-xl-8 offset-xl-4 col-lg-12 col-md-12 m-t-minus-5 m-t-sm-15 m-t-xs-15 m-t-20">'+
                                    '<label class="m-0 font-600 font-11">@lang('frontsistema.alta_de_cuentas.dest_bank_address')</label>'+
                                    '<input class="form-control input-black" type="text" disabled="disabled" value="'+ beneficiary_data.dest_bank_address +'" />'+
                                '</div>'+
                            '</div>'

                            if(beneficiary_data.intermediary_banking == 1){

                                html += '<div class="row">'+
                                    '<div class="col-xl-12 col-lg-6 col-md-6 m-t-minus-5 m-t-sm-15 m-t-xs-15 m-t-20">'+
                                        '<div class="checkbox checkbox-custom m-t-0 line-height-20 disabled">'+
                                            '<label class="m-b-0 ckCursor" for="intermediate_bank_exists">'+
                                                '<input type="checkbox" value="1" checked="checked" disabled>'+
                                                '<span class="cr"><i class="cr-icon fa fa-check"></i></span>@lang('frontsistema.alta_de_cuentas.use_intermediate_bank')</label>'+
                                        '</div>'+
                                    '</div>'+
                                '</div>';

                                html += '<div class="row">'+
                                    '<div class="col-xl-4 col-lg-6 col-md-4 m-t-minus-5 m-t-sm-15 m-t-xs-15 m-t-20">'+
                                        '<label class="m-0 font-600 font-11">@lang('frontsistema.alta_de_cuentas.dest_int_bank_country')</label>'+
                                        '<select class="form-control input-black" type="text" disabled="disabled">'+
                                            '<option value="'+ beneficiary_data.al_intermediary_bank_country +'">'+ beneficiary_data.al_intermediary_bank_country +'</option>'+
                                        '</select>'+
                                    '</div>'+
                                    '<div class="col-xl-8 col-lg-6 col-md-8 m-t-minus-5 m-t-sm-15 m-t-xs-15 m-t-20">'+
                                        '<label class="m-0 font-600 font-11">@lang('frontsistema.alta_de_cuentas.account_number')</label>'+
                                        '<input class="form-control input-black" type="text" disabled="disabled" value="'+beneficiary_data.intermediary_bank_account+'" />'+
                                    '</div>'+
                                '</div>'+
                                '<div class="row">'+
                                    '<div class="col-xl-4 col-lg-6 col-md-4 m-t-minus-5 m-t-sm-15 m-t-xs-15 m-t-20">'+
                                        '<label class="m-0 font-600 font-11">@lang('frontsistema.alta_de_cuentas.dest_bank_swift')</label>'+
                                        '<input class="form-control input-black" type="text" disabled="disabled" value="'+beneficiary_data.intermediary_swift+'"/>'+
                                    '</div>'+
                                    '<div class="col-xl-8 col-lg-6 col-md-8 m-t-minus-5 m-t-sm-15 m-t-xs-15 m-t-20">'+
                                        '<label class="m-0 font-600 font-11">@lang('frontsistema.alta_de_cuentas.dest_int_bank_label')</label>'+
                                        '<input class="form-control input-black" type="text" disabled="disabled" value="'+beneficiary_data.intermediary_bank_name+'"/>'+
                                    '</div>'+
                                '</div>'+
                                '<div class="row">'+
                                    '<div class="col-xl-8 offset-xl-4 col-lg-6 col-md-12 m-t-minus-5 m-t-sm-15 m-t-xs-15 m-t-20">'+
                                        '<label class="m-0 font-600 font-11">@lang('frontsistema.alta_de_cuentas.dest_bank_address')</label>'+
                                        '<input class="form-control input-black" type="text" disabled="disabled" value="'+beneficiary_data.intermediary_bank_address+'"/>'+
                                    '</div>'+
                                '</div>';
                            }

                            $('#displayBeneficiaryData').html(html);
                            //console.log(response.data);

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
            else {
                $('#displayBeneficiaryData').html('');
            }
        });

    
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
            let block_html = '<div class="file_upload_block col-lg-10 row">';
            block_html += '<div class="controls col-md-4">';
            block_html += '<div class="fileupload fileupload-new" data-provides="fileupload">';
            block_html += '<label class="font-14 font-600 m-r-10 fileLable">Archivo '+next_block+':</label>';
            block_html += '<button type="button" class="btn btn-aqua-blue btn-file">';
            block_html += '<span class="fileupload-new"><i class="fa fa-paper-clip"></i> '+ "{{ __('frontsistema.adjuste_de_permisos.select_file_btn') }}" + '</span>';
            block_html += '<span class="fileupload-exists"><i class="fa fa-undo"></i>'+ "{{ __('frontsistema.adjuste_de_permisos.change_btn') }}" +'</span>';
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
            $(val).find('.fileLable').html('{{ __("frontsistema.adjuste_de_permisos.fileLbl") }}' + (i + 2) + ':'); 
        });
    }

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
                event.target.files.length = 0;
                event.target.value = '';
                swal("@lang('frontsistema.users_alert')", "@lang('frontsistema.adjuste_de_permisos.file_upload_size_err')", 'error');
            } 
        }
        else{
            event.target.files.length = 0;
            event.target.value = '';
            swal("@lang('frontsistema.users_alert')", "@lang('frontsistema.adjuste_de_permisos.file_upload_type_err')", 'error');
        }
    }

    var pending_requests = [];
    var selectedIndex = 0;

    function submitTransferenciasForm(){

        let token = $('#_token').val();
        let req_data = '{';
        var $form = $("#transferencias_internacionalesForm");

        if(!validDocumentFiles($form)){
            swal("@lang('frontsistema.users_alert')", "@lang('frontsistema.adjuste_de_permisos.file_upload_err')", 'error');
            return false;
        }

        $('#transferencias_internacionalesForm').find(':input').each(function() 
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
        var form_data = new FormData();

        $form.find("input[type=file]").each(function(index, field){
            if(field != undefined && field.files.length>0){
                form_data.append('documents[]',field.files[0]);
            }
        });
        // return;
        form_data.append('text', req_data);
        form_data.append('request_type_id', 9);
        form_data.append('verify', 1);
        form_data.append('from', 'Transferencias internacionales');
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
                    show_loader(false);
                    swal("@lang('frontsistema.users_alert')", response.message, 'error');
                }
                else if(!response.error && response.code == '200'){

                    $.ajax({
                            type: 'GET',
                            dataType: 'json',
                            url: "{{ url('user/pending_international_transfers') }}" + '?user_id=' + '{{$user_id}}' + '&account_id=' + '{{$payment_accounts[0]["id"]}}',
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
                                                pending_requests[i].parsedText.ti_value_date.value+
                                            '</div>'+
                                            '<div class="col-2 text-center p-l-r-5">'+
                                                pending_requests[i].parsedText.ti_account.value+
                                            '</div>'+
                                            '<div class="col-2 text-center p-l-r-5">'+
                                                pending_requests[i].parsedText.ti_beneficiary.value+
                                            '</div>'+
                                            '<div class="col-2 text-center p-l-r-5">'+
                                                pending_requests[i].parsedText.ti_amount.value+
                                            '</div>'+
                                            '<div class="col-2 text-center p-l-r-5">'+
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
            },
            complete: function() {
                show_loader(false);
            }
        });
    }

    // Function to handle the change event of pending requests radio button
    $('body').on('change', 'input[type=radio][name=verification]', function() {
        selectedIndex = $(this).val().replace('verification', '');
        console.log(selectedIndex);
        $('#applicationDateVerify').html(pending_requests[selectedIndex].parsedText.ti_value_date.value);
        $('#fromAccountVerify').html(pending_requests[selectedIndex].parsedText.ti_account.value);
        $('#toAccountVerify').html(pending_requests[selectedIndex].parsedText.ti_beneficiary.value);
        $('#amountVerify').html(pending_requests[selectedIndex].parsedText.ti_amount.value);

        $theSteps = $('.steps ul').find('.current');
        $($theSteps).next('li').addClass('disabled');
    });

    // Function to handle the sending of OTP when user goes from segment 2 to 3
    function submitSecondForm(){
        let token = $('#_token').val();
        $.ajax({
            type: 'POST',
            dataType: 'json',
            data: {'_token':token, 'request_type_id':9,'client_request_id': pending_requests[selectedIndex].id},
            url: "{{ url('user/generate_code') }}",
            beforeSend: function() {
                
            },
            success: function(response) {
                if (response.error && response.code == '500'){
                    show_loader(false);
                    swal("@lang('frontsistema.users_alert')", response.message, 'error');
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
        
    </script>
@endsection