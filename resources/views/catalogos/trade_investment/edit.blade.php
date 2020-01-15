@extends('layouts.main')
@section('customcss')
<link href="{{url('assets/plugins/timepicker/bootstrap-timepicker.min.css" rel="stylesheet') }}">
<link href="{{ url('assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet">
<link href="{{ url('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
<style type="text/css">
    .datepicker>div{
        display: block;
    }
    .datepicker table tr td.disabled, .datepicker table tr td.disabled:hover{
        color:#bbbaba;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow{
        top: 7px;
    }
</style>
@endsection

@section('pagecontent')

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">@lang('sistema.trade_investment.edit_trade')</h4>
                <ol class="breadcrumb p-0 m-0">
                    <li>
                        <a href="javascript:void(0)">@lang('sistema.pie')</a>
                    </li>                         
                    <li>
                        <a href="{{ url('trade_investment') }}">
                            @lang('sistema.trade_investment.lbl_trade_investment')
                        </a>
                    </li>
                    <li class="active">
                        @lang('sistema.trade_investment.edit_trade')
                    </li>
                </ol>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <!--<h4 class="m-t-0 header-title"><b>Input Types</b></h4>-->
                    <p></p>
                    <div class="row">
                        <input type="hidden" id="_token" value="{{ csrf_token() }}">
                        <div class="col-lg-12">
                            @if (count($errors) > 0)
                            <div class="alert alert-warning" id="error_block">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                    <li>{!! $error !!}</li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif
                            <form class="form-horizontal"  method="POST" action="{{url('trade_investment/'. $trade_investment->id)}}" id="frm_transactions" onsubmit="return validateFrm();">
                                {{ csrf_field() }}
                                {{ method_field('PUT') }}
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group row" id="inputticket">
                                            <label for="ticket" class="col-sm-3 form-control-label">@lang('sistema.transaction.ticket')<span class="text-danger">*</span></label>
                                            <div class="col-sm-9">
                                                <input type="text" tabindex="1" maxlength="8" onkeypress="return isNumber(event)" class="form-control" id="ticket" name="ticket" placeholder="{{__('sistema.transaction.ticket')}}" valida="SI" cadena ="{{__('sistema.transaction.req_ticket')}}" value="{{ (old('ticket')) ? : $trade_investment->ticket }}">
                                                <input type="hidden" value="{{ $trade_investment-> is_opening }}" name="is_opening" id="is_opening"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group row" id="inputaccount_number">
                                            <label for="account_number" class="col-sm-3 form-control-label">@lang('sistema.transaction.account_number')<span class="text-danger">*</span></label>
                                            <div class="col-sm-9">
                                                <select disabled tabindex="2" class="form-control select2" id="account_number" name="account_number" valida="SI" cadena ="{{__('sistema.transaction.req_account_number')}}">
                                                    <option value="">Selectar cuenta</option>
                                                    @if(isset($accounts) && count($accounts) > 0)
                                                    @foreach($accounts as $account)
                                                    @php
                                                    $primary_account = $account->primary_client;
                                                    @endphp
                                                    <option value="{{ $account->id }}" {{ old('account_number') == $account->id ? 'selected' : ($trade_investment->account_id == $account->id ? 'selected' : '') }}>{{$account->account_number}}{{  $primary_account ?  ' - ' . $primary_account->full_name : '' }}</option>
                                                    @endforeach
                                                    @endif
                                                </select>                                                
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group row" id="inputinstrument_id">
                                            <label for="instrument_id" class="col-sm-3 form-control-label">@lang('sistema.transaction.instrument')<span class="text-danger">*</span></label>
                                            <div class="col-sm-9">
                                                <select disabled tabindex="3" class="form-control select2" id="instrument_id" name="instrument_id" valida="SI" cadena ="{{__('sistema.transaction.req_instrument')}}">
                                                    <option value="">@lang('sistema.transaction.select_instrument')</option>
                                                    @foreach($instruments as $key=>$instrument)
                                                        <option value="{{ $key }}" {{ old('instrument_id') == $key ? 'selected' : ($trade_investment->instrument_id == $key ? 'selected' : '') }}>{{ $instrument }}</option>
                                                    @endforeach
                                                </select>                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">   
                                    <div class="col-lg-6">
                                        <div class="form-group row" id="inputfecha">
                                            <label for="fecha" class="col-sm-3 form-control-label">@lang('sistema.trade_investment.fecha')<span class="text-danger">*</span></label>
                                            <div class="col-sm-9">
                                                <input tabindex="4" autocomplete="off" type="text" class="form-control date_picker" id="fecha" name="fecha" placeholder="{{__('sistema.trade_investment.fecha')}}" valida="SI" cadena ="{{__('sistema.trade_investment.req_fecha')}}" value="{{ old('fecha') ? old('fecha') : ($trade_investment->fecha ? date('d/m/Y',strtotime($trade_investment->fecha)) : '') }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group row" id="inputfecha_vencimiento">
                                            <label for="fecha_vencimiento" class="col-sm-3 form-control-label">@lang('sistema.trade_investment.fecha_vencimiento')<span class="text-danger">*</span></label>
                                            <div class="col-sm-9">
                                                <input tabindex="5" autocomplete="off" type="text" class="nonopening form-control date_picker2" id="fecha_vencimiento" name="fecha_vencimiento" placeholder="{{__('sistema.trade_investment.fecha_vencimiento')}}" valida="SI" cadena ="{{__('sistema.trade_investment.req_fecha_vencimiento')}}" value="{{ old('fecha_vencimiento') ? old('fecha_vencimiento') : ($trade_investment->fecha_vencimiento ? date('d/m/Y',strtotime($trade_investment->fecha_vencimiento)) : '') }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group row" id="inputtransaction">
                                            <label for="transaction" class="col-sm-3 form-control-label">@lang('sistema.trade_investment.transaction')<span class="text-danger">*</span></label>
                                            <div class="col-sm-9">
                                                <input tabindex="6" type="text" class="nonopening form-control" id="transaction" name="transaction" placeholder="{{__('sistema.trade_investment.transaction')}}" valida="SI" cadena ="{{__('sistema.trade_investment.req_transaction')}}" value="{{ (old('transaction'))? old('transaction'): $trade_investment->transaction }}"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group row" id="inputtype">
                                            <label for="type" class="col-sm-3 form-control-label">@lang('sistema.transaction.type')<span class="text-danger">*</span></label>
                                            <div class="col-sm-9">
                                                <div class="radio">
                                                    <label for="optDr">
                                                        <input type="radio" name="tipo" value="dr" id="optDr" {{ $trade_investment->tipo == 'dr' ? 'checked' : '' }}>
                                                        <span class="cr"><i class="cr-icon mdi mdi-checkbox-blank-circle"></i></span>
                                                        @lang('sistema.trade_investment.type_dr')
                                                    </label>
                                                    &nbsp;&nbsp;&nbsp;
                                                    <label for="optCr">
                                                        <input type="radio" name="tipo" value="cr" id="optCr" {{ $trade_investment->tipo == 'cr' ? 'checked' : '' }}>
                                                        <span class="cr"><i class="cr-icon mdi mdi-checkbox-blank-circle"></i></span>
                                                        @lang('sistema.trade_investment.type_cr')
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group row" id="inputmonto">
                                            <label for="monto" class="col-sm-3 form-control-label">@lang('sistema.trade_investment.monto')<span class="text-danger">*</span></label>
                                            <div class="col-sm-9">
                                                <input tabindex="7" type="text" class="form-control autonumber" id="monto" name="monto" placeholder="{{__('sistema.trade_investment.monto')}}" valida="SI" cadena ="{{__('sistema.trade_investment.req_monto')}}" value="{{ (old('monto'))? old('monto'): $trade_investment->monto }}">
                                            </div>
                                        </div>
                                    </div> 
                                    <div class="col-lg-6">
                                        <div class="form-group row" id="inputprecio">
                                            <label for="precio" class="col-sm-3 form-control-label">@lang('sistema.trade_investment.precio')<span class="text-danger">*</span></label>
                                            <div class="col-sm-9">
                                                <input tabindex="8" type="text" class="nonopening form-control autonumber" id="precio" name="precio" placeholder="{{__('sistema.trade_investment.precio')}}" valida="SI" cadena ="{{__('sistema.trade_investment.req_precio')}}" value="{{ (old('precio'))? old('precio'): $trade_investment->precio }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group row" id="inputnav">
                                            <label for="nav" class="col-sm-3 form-control-label">@lang('sistema.trade_investment.nav')<span class="text-danger">*</span></label>
                                            <div class="col-sm-9">
                                                <input tabindex="9" type="text" class="nonopening1 form-control autonumber" id="nav" name="nav" placeholder="{{__('sistema.trade_investment.nav')}}" valida="SI" cadena ="{{__('sistema.trade_investment.req_nav')}}" value="{{ (old('nav'))? old('nav'): $trade_investment->nav }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group row" id="inputriesgo">
                                            <label for="riesgo" class="col-sm-3 form-control-label">@lang('sistema.trade_investment.riesgo')(%)<span class="text-danger">*</span></label>
                                            <div class="col-sm-9">
                                                <input tabindex="10" type="text" class="nonopening form-control autonumber2" id="riesgo" name="riesgo" placeholder="{{__('sistema.trade_investment.riesgo')}}" valida="SI" cadena ="{{__('sistema.trade_investment.req_riesgo')}}" value="{{ (old('riesgo'))? old('riesgo'): $trade_investment->riesgo }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group row" id="inputcontratos">
                                            <label for="contratos" class="col-sm-3 form-control-label">@lang('sistema.trade_investment.contratos')<span class="text-danger">*</span></label>
                                            <div class="col-sm-9">
                                                <input tabindex="11" type="text" class="nonopening form-control autonumber" id="contratos" name="contratos" placeholder="{{__('sistema.trade_investment.contratos')}}" valida="SI" cadena ="{{__('sistema.trade_investment.req_contratos')}}" value="{{ (old('contratos'))? old('contratos'): $trade_investment->contratos }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group row" id="inputexposicion">
                                            <label for="exposicion" class="col-sm-3 form-control-label">@lang('sistema.trade_investment.exposicion')<span class="text-danger">*</span></label>
                                            <div class="col-sm-9">
                                                <input tabindex="12" readonly type="text" class="nonopening1 form-control autonumber" id="exposicion" name="exposicion" placeholder="{{__('sistema.trade_investment.exposicion')}}" valida="SI" cadena ="{{__('sistema.trade_investment.req_exposicion')}}" value="{{ (old('exposicion'))? old('exposicion'): $trade_investment->exposicion }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group m-b-0">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="offset-sm-3 col-sm-9">                                                
                                                <a href="{{ url('trade_investment') }}" class="btn btn-danger waves-effect waves-light">@lang('sistema.btn_back')</a>
                                                <button type="submit" id="btnUpdateTrade" class="btn btn-info waves-effect waves-light">@lang('sistema.btn_save')</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- end row -->
                </div>
            </div>
        </div><!-- end col -->
    </div>
</div><!-- container -->
<footer class="footer">
    © {{ date('Y') }} @lang('sistema.pie')
</footer>
@endsection

@section('customjs')
<script src="{{ url('assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ url('assets/plugins/timepicker/bootstrap-timepicker.js') }}"></script>
<script src="{{ url('assets/plugins/bootstrap-inputmask/bootstrap-inputmask.min.js') }}"></script>
<script src="{{ url('assets/plugins/autoNumeric/autoNumeric.js') }}"></script>
<script src="{{ url('assets/plugins/select2/js/select2.min.js') }}"></script>

@if (session('type')=='error')            
<script>
    swal({
        title: '@lang("sistema.users_alert")',
        text: '{{session("msg")}}',
        type: 'error',
        timer: 5500,
        confirmButtonColor: 'red',
        confirmButtonText: 'OK'
    });
</script>
@endif

<script type="text/javascript">
    var token = $('#_token').val();
    
    var is_opening_balance = 0;
   
    var minimum_opening_bal_date = '{{ (isset($opening_balance_date) ? $opening_balance_date : "") }}';
    
    var startDate = '-5d';
    
    if(minimum_opening_bal_date)
    {
        startDate = new Date(minimum_opening_bal_date);
    }
    
    var is_opening = 0;
    //console.log(startDate, is_opening);
    if(is_opening == 1)
    {
        $(".date_picker").datepicker({
            format: 'dd/mm/yyyy',
            startDate: startDate,
            //endDate: '+5d',
            autoclose: true
        });
        
        $('.date_picker').datepicker('setDate', new Date("{{ date('d/m/Y',strtotime($trade_investment->fecha)) }}"));
    }
    else
    {
        //Initalize controls
        $(".date_picker2").datepicker({
            format: 'dd/mm/yyyy',
            autoclose: true,
        });
        
        $(".date_picker").datepicker({
            format: 'dd/mm/yyyy',
            //startDate: '0d',
            //endDate: '+5d',
            autoclose: true
        }).on('changeDate', function (selected) {
            var minDate = new Date(selected.date.valueOf());
            $('.date_picker2').datepicker('setStartDate', minDate);
        });

        //$('.date_picker').datepicker('setDate', new Date("{{ date('d/m/Y',strtotime($trade_investment->fecha)) }}"));
        //console.log('abcd');
        //$('.date_picker2').datepicker('setStartDate', new Date("{{ date('d/m/Y',strtotime($trade_investment->fecha)) }}"));

        //$('.date_picker').datepicker('setDate', new Date("{{ date('d/m/Y',strtotime($trade_investment->fecha)) }}"));
        //$('.date_picker2').datepicker('setDate', new Date("{{ date('d/m/Y',strtotime($trade_investment->fecha_vencimiento)) }}"));
    }
    $(function ($) {
        $(".select2").select2();
        $("#is_opening").val(is_opening_balance);
        check_opening_balance();
        $('.autonumber').autoNumeric('init', {
            mDec: '4', 
            aPad: 7
        });
        $('.autonumber2').autoNumeric('init', {
            vMax: 999.9999,
            mDec: '4', 
            aPad: 7
        });
    });
    //Validate Form
    function validateFrm(alert = true)
    {
        var listv = 0;
        var msg = '';
        $('#frm_transactions').find(':input').each(function () {
            if ($(this).attr("valida") == "SI" && ($(this).val() == "" || $(this).val() == "null"))
            {
                listv = 1;
                $('#input' + this.id).addClass('has-error');
                msg += $(this).attr('cadena') + '\n';
                //$(this).val($(this).val().toUpperCase());
            } else
            {
                $('#input' + this.id).removeClass('has-error');
                if ($(this).attr("valida") == "SI")
                {
                    //$(this).val($(this).val().toUpperCase());
                }
            }
        });
        
        if(alert)
        {
            if (listv == 1)
            {
                swal({
                    title: '@lang("sistema.users_alert")',
                    text: msg,
                    type: 'error',
                    timer: 4000,
                    confirmButtonColor: 'red',
                    confirmButtonText: 'OK'
                });
                return false;
            } else
            {
                $("#btnUpdateTrade").prop('disabled', true);
                return true;
            }
        }
    }

    function isNumber(event)
    {
        var keyCode = event.keyCode;
        if (keyCode >= 48 && keyCode <= 57)
        {
            return true;
        }
        return false;
    }

    function getMontoValue()
    {
        let monto_val = $("#monto").val();
        monto_val = monto_val.replace(/\,/g, '');
        return monto_val;
    }

    $('body').on('click', '.btn_cancel_ticket', function () {
        $("#error_block").remove();
    });

    $("#monto").on('change', function () {
        /*if (!is_opening_balance)
        {*/
            let monto_val = getMontoValue();
            let nav_comm = '{{ env("NAV_COMMISSION", 0.96) }}';
            let nav_val = monto_val * nav_comm;
            //$("#nav").val(nav_val.toFixed(4));
        /*}*/
    });

    $("#riesgo").on('change', function () {
        /*if (!is_opening_balance)
        {*/
            let risk_percentage = $(this).val();
            let monto_val = getMontoValue();
            let exposicion_val = (risk_percentage * monto_val) / 100;
            $("#exposicion").focus();
            $("#exposicion").val(exposicion_val.toFixed(4));
            $("#exposicion").change();
            $("#contratos").focus();
        /*}*/
    });
    
    $('body').on('click', '.btn_cancel_ticket', function(){
       $("#error_block").remove();
    });

    $('body').on('click', '.btn_accept_ticket', function(){
       $("#ticket").val($(this).data('bid'));
       $("#error_block").remove();
    });
    
    $("#account_number").change(function () {
        return false;
        let account_id = $(this).val();
        if (account_id != '')
        {
            show_loader(true);
            $.ajax({
                type: 'GET',
                dataType: 'json',
                data: {},
                url: "{{ url('accounts') }}/" + account_id + '/check_trade',
                beforeSend: function () {
                    //$('#modal-espere').modal('show');
                },
                success: function (response) {
                    if (response.flag == 1) {
                        is_opening_balance = response.data;
                        $("#is_opening").val(is_opening_balance);
                        check_opening_balance();
                    } else {
                        swal({
                            title: 'Aviso!!',
                            text: response.message,
                            type: 'error',
                            timer: 3000,
                            confirmButtonColor: 'red',
                            confirmButtonText: 'OK'
                        });
                    }
                },
                error: function (response) {
                    //console.error(response);
                },
                complete: function () {
                    show_loader(false);
                }
            });
        } else
        {
            is_opening_balance = 0;
            $("#is_opening").val(0);
            check_opening_balance();
            console.log('reset form');
            $("#frm_transactions").trigger('reset');
        }
    });

    function check_opening_balance()
    {
        if (is_opening_balance == 1)
        {
            $(".nonopening").attr('readonly', true);
            $("#optCr").attr('checked', true).prop('disabled', true);
            $("#optDr").prop('disabled', true);
            $("#transaction").val('{{ __("sistema.trade_investment.is_opening") }}');
            $("#precio, #nav, #riesgo, #contratos, #exposicion, #fecha_vencimiento").attr('valida', 'NO').val('');
            //$("#fecha_vencimiento").val('');
        } else
        {
            $("#optCr").prop('disabled', false);
            $("#optDr").prop('disabled', false);
            $(".nonopening").attr('readonly', false);
            //$("#transaction").val('');
            $("#precio, #nav, #riesgo, #contratos, #exposicion, #fecha_vencimiento").attr('valida', 'SI');            
        }
        validateFrm(false);
    }    
</script>
@endsection