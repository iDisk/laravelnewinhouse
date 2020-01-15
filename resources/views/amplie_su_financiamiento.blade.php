@extends('layouts.front_vertical_menu')
@section('customcss')
<link href="{{ url('assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet">
<style type="text/css">
    b {
        font-weight: 600;
    }
</style>
@endsection

@section('pagecontent')
    <div class="container-fluid">
        <input type="hidden" id="_token" value="{{ csrf_token() }}">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box text-xs-center text-sm-center text-md-center">
                    <h4 class="page-title">@lang('frontsistema.amplie_su_financiamiento.title')</h4>
                    <div class="web_logo">
                        <img class="" src="{{ url('assets/images/logo_espacios.png')}}" alt="" height="50">
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
        <form id="finance_request_form">
            <!-- end row -->
            <div class="row on_load">
                <div class="col-xl-9 col-lg-12 col-md-12">
                    <h5 class="font-14 font-600">@lang('frontsistema.amplie_su_financiamiento.top_msg_first')</h5>
                </div>
                <div class="col-xl-9 col-lg-12 col-md-12">
                    <h5 class="font-14 m-t-0 m-b-0">@lang('frontsistema.amplie_su_financiamiento.top_msg')</h5>
                </div>
                <div class="col-xl-9 col-lg-12 col-md-12">
                    <h5 class="font-14">@lang('frontsistema.amplie_su_financiamiento.second_msg')</h5>
                </div>
            </div>
            <!-- end row -->
            <div class="row">
<!--                <div class="col-xl-4 col-lg-6 text-center m-t-20">
                    <div class="main-box">
                        <div class="title">
                            SALDO ACTUAL
                        </div>
                        <div class="amount text-custom-info font-600 m-t-0">
                            @{{ isset($saldo_calc) ? number_format($saldo_calc['saldo_actual'], 2, '.', ',') : 0.00 }}
                        </div>
                    </div>
                </div>-->
                <div class="col-xl-5 offset-xl-2 col-lg-6 offset-lg-1 text-center m-t-20">
                    <div class="main-box black">
                        <div class="title">
                            @lang('frontsistema.amplie_su_financiamiento.current_credit_line')
                        </div>
                        <div class="amount text-custom-info font-600 m-t-0">
                            {{ isset($saldo_calc) ? number_format($saldo_calc['linea_de_credito_actual'], 2, '.', ',') : 0.00 }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="row m-t-40 m-b-50 on_load">
<!--                <div class="col-xl-3 col-lg-4 col-md-12 text-center">
                    <p class="m-0 font-600">@lang('frontsistema.amplie_su_financiamiento.your_account')</p>
                    <h3 class="text-custom-info font-600 m-t-0">{{ $account->account_number  }}</h3>
                </div>-->
                <div class="col-xl-9">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 m-t-minus-5 m-t-sm-5 m-t-xs-5">
                            <label class="m-0 font-600 font-11">@lang('frontsistema.amplie_su_financiamiento.credit_amount')</label>
                            <input class="form-control input-black" name="credit_amount" type="number" id="credit_amount" placeholder="" data-parsley-multiple-of="500" data-parsley-trigger="change" required guardar="SI">
                            <div class="form-error">@lang('frontsistema.amplie_su_financiamiento.credit_amount_error')</div>
                        </div>
                        <div class="col-lg-6 col-md-6 m-t-minus-5 m-t-sm-15 m-t-xs-15">
                            <label class="m-0 font-600 font-11">@lang('frontsistema.amplie_su_financiamiento.credit_date')</label>
                            <input class="form-control input-black" name="credit_date" type="text" id="credit_date" onkeydown="return false" autocomplete="off" data-parsley-keyup="change" required placeholder=""  guardar="SI">
                            <div class="form-error">@lang('frontsistema.amplie_su_financiamiento.credit_date_error')</div>
                        </div>
                    </div>
                </div>
                <!-- end col -->
            </div>
            <div class="row on_load">
                <div class="col-xl-9 col-lg-12 col-md-12">
                    <h5 class="font-14 terms-div-border">
                        {!! $broker_setting['expand_financing_disclaimer'] !!}
                        <div class="checkbox checkbox-custom m-t-0 line-height-20">
                            <label class="m-b-0 ckCursor" for="policies">
                                <input type="checkbox" value="1" name="policies" id="policies" required parsley-trigger="change">
                                <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                @lang('frontsistema.amplie_su_financiamiento.accept_text')
                            </label>
                            <div class="form-error">@lang('frontsistema.amplie_su_financiamiento.terms_error')</div>
                        </div>
                    </h5>
                </div>
            </div>
            <div class="row on_load">
                <div class="col-xl-9 col-lg-12 col-md-12">
                    <div class="font-16 font-600 font_primary_color">@lang('frontsistema.amplie_su_financiamiento.terms_and_conditions')</div>
                </div>
            </div>
            <div class="row on_load">
                <div class="col-xl-9 col-lg-12 col-md-12">
                    <h5 class="font-14 terms-div-border">
                        {!! (session('language') == 'es' ? $broker_setting['expand_financing_tnc_es'] : $broker_setting['expand_financing_tnc_en']) !!}
                        <div class="checkbox checkbox-custom m-t-0 line-height-20">
                            <label class="m-b-0 ckCursor" for="termsandconditions">
                                <input type="checkbox" value="1" name="termsandconditions" id="termsandconditions" required parsley-trigger="change">
                                <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                @lang('frontsistema.amplie_su_financiamiento.accept_text')
                            </label>
                            <div class="form-error">@lang('frontsistema.amplie_su_financiamiento.terms_error')</div>
                        </div>
                    </h5>
                </div>
            </div>
            <div class="row m-t-30 m-b-30">
                <div class="col-xl-9 text-right">
                    <a class="text-aqua-blue m-r-10 cursor-pointer line-height-35" href="{{ route('client_home') }}">@lang('frontsistema.btn_cancel')</a>
                    <button class="btn btn-aqua-blue waves-effect waves-light" type="submit">@lang('frontsistema.amplie_su_financiamiento.submit_button')</button>
                </div>
            </div>
        </form>
        <div class="row on_success m-t-50" style="display: none;">
            <div class="col-lg-12 text-center">
                <h3 class="font-600">@lang('frontsistema.amplie_su_financiamiento.success_msg_title')</h3>
                <p class="text-custom-info font-600 font-16 m-b-0">@lang('frontsistema.amplie_su_financiamiento.success_msg')</p>
                <p class="text-custom-info font-600 font-16">@lang('frontsistema.amplie_su_financiamiento.success_second_msg')</p>
                <div class="row">
                    <div class="col-12 text-center">
                        <a class="text-aqua-blue m-r-10 cursor-pointer line-height-35" href="{{ route('client_home') }}">@lang('frontsistema.amplie_su_financiamiento.back_to_home')</a>
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
    <script type="text/javascript">

        //Initialze date pickers
        $('#credit_date').datepicker({
            format: 'dd/mm/yyyy',
            autoclose: true,
            startDate: '+0d', // After current day
            endDate: '+21d', // 21 days from the current day
            language: '{{ session("language") }}',
        }).on('changeDate', function(e) {
            $(this).parsley().validate();
        });

        $('#finance_request_form').parsley().on('field:validated', function () {
            console.log("form error");
        })
        .on('form:submit', function () {
            swal({
                title: "{{ __('frontsistema.confirm') }}",
                text: "{{ __('frontsistema.amplie_su_financiamiento.confirmation_msg') }}",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: '#8cd5dd',
                confirmButtonText: "{{ __('frontsistema.btn_yes') }}",
                cancelButtonText: "No"
            })
            .then(function () {
                submitAmplieFinanciamientoForm();
                console.log("submit form");
                }, function (dismiss) {
                    //Code for cancel
                }
            );
            return false; // Don't submit form for this demo
        });

        $('#submit-another-request').click(function() {
            $('#finance_request_form').show();
            $('.on_success').hide();
        });
        
        function submitAmplieFinanciamientoForm(){
            let token = $('#_token').val();

            let req_data = '{';

            $('#finance_request_form').find(':input').each(function() 
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
                data: {'_token':token,'text':req_data,'request_type_id':5,'verify':0,'from':'Amplié su financiamiento'},
                url: "{{ url('user/client_request') }}",
                beforeSend: function() {
                    show_loader(true);
                },
                success: function(response) {
                    if (response.error && response.code == '500'){
                       
                    }
                    else if(!response.error && response.code == '200'){
                        $("#finance_request_form").hide();
                        $("#finance_request_form").trigger("reset");
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
    </script>
@endsection