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
                <h4 class="page-title">@lang('sistema.trade.create_trade')</h4>
                <ol class="breadcrumb p-0 m-0">
                    <li>
                        <a href="javascript:void(0)">@lang('sistema.pie')</a>
                    </li>                         
                    <li>
                        <a href="{{ url('transactions') }}">
                            @lang('sistema.trade.trade')
                        </a>
                    </li>
                    <li class="active">
                        @lang('sistema.trade.create_trade')
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
                            <form class="form-horizontal"  method="POST" action="{{url('transactions')}}" id="frm_transactions" onsubmit="return validateFrm();" enctype="multipart/form-data">

                                {{ csrf_field() }}
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group row" id="inputticket">
                                            <label for="ticket" class="col-sm-3 form-control-label">@lang('sistema.transaction.ticket')<span class="text-danger">*</span></label>
                                            <div class="col-sm-9">
                                                <input type="text" tabindex="1" maxlength="8" onkeypress="return isNumber(event)" class="form-control" id="ticket" name="ticket" placeholder="{{__('sistema.transaction.ticket')}}" valida="SI" cadena ="{{__('sistema.transaction.req_ticket')}}" value="{{ (old('ticket'))? old('ticket'): $token_number }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group row" id="inputaccount_number">
                                            <label for="account_number" class="col-sm-3 form-control-label">@lang('sistema.transaction.account_number')<span class="text-danger">*</span></label>
                                            <div class="col-sm-9">
                                                <select tabindex="2" class="form-control select2" id="account_number" name="account_number" valida="SI" cadena ="{{__('sistema.transaction.req_account_number')}}">
                                                    <option value="">Selectar cuenta</option>
                                                    @if(isset($accounts) && count($accounts) > 0)
                                                    @foreach($accounts as $account)
                                                    @php
                                                    $primary_account = $account->primary_client;
                                                    @endphp                                                    
                                                    <option value="{{ $account->id }}" {{ old('account_number') == $account->id ? 'selected' : '' }}>{{$account->account_number}}{{  $primary_account ?  ' - ' . $primary_account->full_name : '' }}</option>
                                                    @endforeach
                                                    @endif
                                                </select>                                                
                                            </div>
                                        </div>
                                    </div>
<!--                                    <div class="col-lg-6">
                                        <div class="form-group row" id="inputinitial_capital">
                                            <label for="initial_capital" class="col-sm-3 form-control-label">@lang('sistema.transaction.initial_capital')<span class="text-danger">*</span></label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control autonumber" id="initial_capital" name="initial_capital" placeholder="{{__('sistema.transaction.initial_capital')}}" valida="SI" cadena ="{{__('sistema.transaction.req_initial_capital')}}" value="{{ (old('initial_capital'))? old('initial_capital'):'' }}" data-v-min="000000.00" data-v-max="999999.99">
                                            </div>
                                        </div>
                                    </div>-->
                                </div>
                                <div class="row">                                    
                                    <div class="col-lg-6">
                                        <div class="form-group row" id="inputtype">
                                            <label for="type" class="col-sm-3 form-control-label">@lang('sistema.transaction.type')<span class="text-danger">*</span></label>
                                            <div class="col-sm-9">
                                                <select tabindex="3" id="type" class="form-control" name="type" valida="SI" cadena="{{__('sistema.transaction.req_type')}}">
                                                    <option value="">@lang('sistema.btn_select')</option>
                                                    @foreach($transaction_types as $key=>$value)
                                                    <option value="{{ $key }}" {{ old('type') == $key ? 'selected' : '' }}>{{ $value }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group row" id="inputinstrument">
                                            <label for="instrument" class="col-sm-3 form-control-label">@lang('sistema.transaction.instrument')<span class="text-danger">*</span></label>
                                            <div class="col-sm-9">
                                                <select tabindex="4" id="instrument" class="form-control" name="instrument" valida="SI" cadena="{{__('sistema.transaction.req_instrument')}}">
                                                    <option value="">@lang('sistema.btn_select')</option>
                                                    @foreach($instruments as $key=>$value)
                                                    <option value="{{ $key }}" {{ old('instrument') == $key ? 'selected' : '' }}>{{ $value }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">                                    
                                    <div class="col-lg-6">
                                        <div class="form-group row" id="inputitem">
                                            <label for="item" class="col-sm-3 form-control-label">@lang('sistema.transaction.item')<span class="text-danger">*</span></label>
                                            <div class="col-sm-9">
                                                <select tabindex="5" id="item" class="form-control" name="item" valida="SI" cadena="{{__('sistema.transaction.req_item')}}">
                                                    <option value="">@lang('sistema.btn_select')</option>
                                                    @foreach($items as $key=>$value)
                                                    <option value="{{ $key }}" {{ old('item') == $key ? 'selected' : '' }}>{{ $value }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <h4 class="m-b-30 m-t-30 header-title"><b>@lang('sistema.transaction.open')</b><hr></h4>
                                        <div class="form-group row" id="inputopening_date">
                                            <label for="opening_date" class="col-sm-3 form-control-label">@lang('sistema.transaction.opening_date')<span class="text-danger">*</span></label>
                                            <div class="col-sm-9">
                                                <input tabindex="6" type="text" class="form-control date_picker" id="opening_date" name="opening_date" placeholder="{{__('sistema.transaction.opening_date')}}" valida="SI" cadena ="{{__('sistema.transaction.req_opening_date')}}" value="{{ (old('opening_date'))? old('opening_date'):'' }}">
                                            </div>
                                        </div>
                                        <div class="form-group row" id="inputopening_time">
                                            <label for="opening_time" class="col-sm-3 form-control-label">@lang('sistema.transaction.opening_time')<span class="text-danger">*</span></label>
                                            <div class="col-sm-9">
                                                <input tabindex="8" type="text" class="form-control timepicker" id="opening_time" name="opening_time" placeholder="{{__('sistema.transaction.opening_time')}}" valida="SI" cadena ="{{__('sistema.transaction.req_opening_time')}}" value="{{ (old('opening_time'))? old('opening_time'):'' }}">
                                            </div>
                                        </div>
                                        <div class="form-group row" id="inputopening_price">
                                            <label for="opening_price" class="col-sm-3 form-control-label">@lang('sistema.transaction.opening_price')<span class="text-danger">*</span></label>
                                            <div class="col-sm-9">
                                                <input tabindex="10" type="text" class="form-control autonumber" id="opening_price" name="opening_price" placeholder="{{__('sistema.transaction.opening_price')}}" valida="SI" cadena ="{{__('sistema.transaction.req_opening_price')}}" value="{{ (old('opening_price'))? old('opening_price'):'' }}" data-v-min="000000.000000" data-v-max="999999.999999">
                                            </div>
                                        </div>
                                        <div class="form-group row" id="inputconversion_opening">
                                            <label for="conversion_opening" class="col-sm-3 form-control-label">@lang('sistema.transaction.conversion_opening')<span class="text-danger">*</span></label>
                                            <div class="col-sm-9">
                                                <input tabindex="12" type="text" class="form-control autonumber" id="conversion_opening" name="conversion_opening" placeholder="{{__('sistema.transaction.conversion_opening')}}" valida="SI" cadena ="{{__('sistema.transaction.req_conversion_opening')}}" value="{{ (old('conversion_opening'))? old('conversion_opening'):'1.000000' }}" data-v-min="000000.000000" data-v-max="999999.999999">
                                            </div>
                                        </div>
                                        <div class="form-group row" id="inputleverage">
                                            <label for="leverage" class="col-sm-3 form-control-label">@lang('sistema.transaction.leverage')<span class="text-danger">*</span></label>
                                            <div class="col-sm-9">
                                                <select tabindex="14" id="leverage" class="form-control" name="leverage" valida="SI" cadena="{{__('sistema.transaction.req_leverage')}}">
                                                    <option value="">@lang('sistema.btn_select')</option>
                                                    @foreach($leverages as $key=>$value)
                                                    <option value="{{ $key }}" {{ old('leverage') == $key ? 'selected' : '' }}>{{ $value }}</option>
                                                    @endforeach
                                                </select>
                                                <input type="hidden" name="leverage_tmp" id="leverage_tmp" value="0">
                                            </div>
                                        </div>
                                        <div class="form-group row" id="inputfinancial_exhibition">
                                            <label for="financial_exhibition" class="col-sm-3 form-control-label">@lang('sistema.transaction.financial_exhibition')<span class="text-danger">*</span></label>
                                            <div class="col-sm-9">
                                                <input tabindex="16" type="text" class="form-control autonumber" id="financial_exhibition" name="financial_exhibition" placeholder="{{__('sistema.transaction.financial_exhibition')}}" valida="SI" cadena ="{{__('sistema.transaction.req_financial_exhibition')}}" value="{{ (old('financial_exhibition'))? old('financial_exhibition'):'' }}" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group row" id="inputstop_loss">
                                            <label for="stop_loss" class="col-sm-3 form-control-label">@lang('sistema.transaction.stop_loss')<span class="text-danger">*</span></label>
                                            <div class="col-sm-9">
                                                <input tabindex="18" type="text" class="form-control autonumber" id="stop_loss" name="stop_loss" placeholder="{{__('sistema.transaction.stop_loss')}}" valida="SI" cadena ="{{__('sistema.transaction.req_stop_loss')}}" value="{{ (old('stop_loss'))? old('stop_loss'):'' }}" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group row" id="inputcontracts">
                                            <label for="contracts" class="col-sm-3 form-control-label">@lang('sistema.transaction.contracts')<span class="text-danger">*</span></label>
                                            <div class="col-sm-9">
                                                <input tabindex="20" type="text" class="form-control autonumber" id="contracts" name="contracts" placeholder="{{__('sistema.transaction.contracts')}}" valida="SI" cadena ="{{__('sistema.transaction.req_contracts')}}" value="{{ (old('contracts'))? old('contracts'):'' }}" data-v-min="0" data-v-max="9999999">
                                            </div>
                                        </div>
                                        <div class="form-group row" id="inputfacial_value">
                                            <label for="facial_value" class="col-sm-3 form-control-label">@lang('sistema.transaction.facial_value')<span class="text-danger">*</span></label>
                                            <div class="col-sm-9">
                                                <input tabindex="22" type="text" class="form-control autonumber" id="facial_value" name="facial_value" placeholder="{{__('sistema.transaction.facial_value')}}" valida="SI" cadena ="{{__('sistema.transaction.req_facial_value')}}" value="{{ (old('facial_value'))? old('facial_value'):'' }}" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group row" id="inputwarranty">
                                            <label for="warranty" class="col-sm-3 form-control-label">@lang('sistema.transaction.warranty')<span class="text-danger">*</span></label>
                                            <div class="col-sm-9">
                                                <input tabindex="24" type="text" class="form-control autonumber" id="warranty" name="warranty" placeholder="{{__('sistema.transaction.warranty')}}" valida="SI" cadena ="{{__('sistema.transaction.req_warranty')}}" value="{{ (old('warranty'))? old('warranty'):'' }}" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <h4 class="m-b-30 m-t-30 header-title"><b>@lang('sistema.transaction.close')</b><hr></h4>
                                        <div class="form-group row" id="inputclosing_date">
                                            <label for="closing_date" class="col-sm-3 form-control-label">@lang('sistema.transaction.closing_date')<span class="text-danger">*</span></label>
                                            <div class="col-sm-9">
                                                <input tabindex="7" type="text" class="form-control date_picker" id="closing_date" name="closing_date" placeholder="{{__('sistema.transaction.closing_date')}}" valida="SI" cadena ="{{__('sistema.transaction.req_closing_date')}}" value="{{ (old('closing_date'))? old('closing_date'):'' }}">
                                            </div>
                                        </div>
                                        <div class="form-group row" id="inputclosing_time">
                                            <label for="closing_time" class="col-sm-3 form-control-label">@lang('sistema.transaction.closing_time')<span class="text-danger">*</span></label>
                                            <div class="col-sm-9">
                                                <input tabindex="9" type="text" class="form-control timepicker" id="closing_time" name="closing_time" placeholder="{{__('sistema.transaction.closing_time')}}" valida="SI" cadena ="{{__('sistema.transaction.req_closing_time')}}" value="{{ (old('closing_time'))? old('closing_time'):'' }}">
                                            </div>
                                        </div>
                                        <div class="form-group row" id="inputclosing_price">
                                            <label for="closing_price" class="col-sm-3 form-control-label">@lang('sistema.transaction.closing_price')<span class="text-danger">*</span></label>
                                            <div class="col-sm-9">
                                                <input tabindex="11" type="text" class="form-control autonumber" id="closing_price" name="closing_price" placeholder="{{__('sistema.transaction.closing_price')}}" valida="SI" cadena ="{{__('sistema.transaction.req_closing_price')}}" value="{{ (old('closing_price'))? old('closing_price'):'' }}" data-v-min="000000.000000" data-v-max="999999.999999">
                                            </div>
                                        </div>
                                        <div class="form-group row" id="inputconversion_closing">
                                            <label for="conversion_closing" class="col-sm-3 form-control-label">@lang('sistema.transaction.conversion_closing')<span class="text-danger">*</span></label>
                                            <div class="col-sm-9">
                                                <input tabindex="13" type="text" class="form-control autonumber" id="conversion_closing" name="conversion_closing" placeholder="{{__('sistema.transaction.conversion_closing')}}" valida="SI" cadena ="{{__('sistema.transaction.req_conversion_closing')}}" value="{{ (old('conversion_closing'))? old('conversion_closing'):'1.000000' }}" data-v-min="000000.000000" data-v-max="999999.999999">
                                            </div>
                                        </div>
                                        <div class="form-group row" id="inputspread">
                                            <label for="spread" class="col-sm-3 form-control-label">@lang('sistema.transaction.spread')<span class="text-danger">*</span></label>
                                            <div class="col-sm-9">
                                                <input tabindex="15" type="text" class="form-control autonumber" id="spread" name="spread" placeholder="{{__('sistema.transaction.spread')}}" valida="SI" cadena ="{{__('sistema.transaction.req_spread')}}" value="{{ (old('spread'))? old('spread'):'' }}" readonly >
                                            </div>
                                        </div>
                                        <div class="form-group row" id="inputcommission_fee">
                                            <label for="commission_fee" class="col-sm-3 form-control-label">@lang('sistema.transaction.commission_fee')<span class="text-danger">*</span></label>
                                            <div class="col-sm-9">
                                                <select tabindex="17" id="commission_fee" class="form-control" name="commission_fee" valida="SI" cadena="{{__('sistema.transaction.req_commission_fee')}}">
                                                    <option value="">@lang('sistema.btn_select')</option>
                                                    @foreach($commission_fees as $key=>$value)
                                                    <option value="{{ $key }}" {{ old('commission_fee') == $key ? 'selected' : '' }}>{{ $value }}%</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row" id="inputcommission">
                                            <label for="commission" class="col-sm-3 form-control-label">@lang('sistema.transaction.commission')<span class="text-danger">*</span></label>
                                            <div class="col-sm-9">
                                                <input tabindex="19" type="text" class="form-control autonumber" id="commission" name="commission" placeholder="{{__('sistema.transaction.commission')}}" valida="SI" cadena ="{{__('sistema.transaction.req_commission')}}" value="{{ (old('commission'))? old('commission'):'' }}" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group row" id="inputgross_profit">
                                            <label for="gross_profit" class="col-sm-3 form-control-label">@lang('sistema.transaction.gross_profit')<span class="text-danger">*</span></label>
                                            <div class="col-sm-9">
                                                <input tabindex="21" type="text" class="form-control autonumber" id="gross_profit" name="gross_profit" placeholder="{{__('sistema.transaction.gross_profit')}}" valida="SI" cadena ="{{__('sistema.transaction.req_gross_profit')}}" value="{{ (old('gross_profit'))? old('gross_profit'):'' }}" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group row" id="inputnet_result">
                                            <label for="net_result" class="col-sm-3 form-control-label">@lang('sistema.transaction.net_result')<span class="text-danger">*</span></label>
                                            <div class="col-sm-9">
                                                <input tabindex="23" type="text" class="form-control autonumber" id="net_result" name="net_result" placeholder="{{__('sistema.transaction.net_result')}}" valida="SI" cadena ="{{__('sistema.transaction.req_net_result')}}" value="{{ (old('net_result'))? old('net_result'):'' }}" readonly>
                                            </div>
                                        </div>
<!--                                        <div class="form-group row" id="inputfinal_capital_client">
                                            <label for="final_capital_client" class="col-sm-3 form-control-label">@lang('sistema.transaction.final_capital_client')<span class="text-danger">*</span></label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="final_capital_client" name="final_capital_client" placeholder="{{__('sistema.transaction.final_capital_client')}}" valida="SI" cadena ="{{__('sistema.transaction.req_final_capital_client')}}" value="{{ (old('final_capital_client'))? old('final_capital_client'):'' }}" readonly>
                                            </div>
                                        </div>-->
                                    </div>
                                </div>
                                <div class="form-group m-b-0">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="offset-sm-3 col-sm-9">                                                
                                                <a href="{{ url('transactions') }}" class="btn btn-danger waves-effect waves-light">@lang('sistema.btn_back')</a>
                                                <button type="submit" id="btnCreateTrade" class="btn btn-info waves-effect waves-light">@lang('sistema.btn_save')</button>
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
        title:'@lang("sistema.users_alert")',
        text:'{{session("msg")}}',
        type:'error',
        timer: 5500,
        confirmButtonColor:'red',
        confirmButtonText:'OK'
    });
</script>
@endif

<script type="text/javascript">
    var token = $('#_token').val();
    //Initalize controls
    $('.date_picker').datepicker({
        format: 'dd/mm/yyyy',
        startDate: '-5d',
        endDate: '+5d',
        autoclose: true
    });
    $('.date_picker').datepicker('setDate', 'today');
    $('.timepicker').timepicker({
        showSeconds: true,
        showMeridian: false,
    });
    $(function($) {        
        $(".select2").select2();       
        $('.autonumber').autoNumeric('init', {
            mDec: '6'            
        });
    });
    //Validate Form
    function validateFrm()  
    {
        var listv = 0;
        var msg = '';
        $('#frm_transactions').find(':input').each(function() {
            if ($(this).attr("valida") == "SI" && ($(this).val() == "" || $(this).val() == "null"))
            {
                listv = 1;
                $('#input' + this.id).addClass('has-error');
                msg += $(this).attr('cadena') + '\n';
                //$(this).val($(this).val().toUpperCase());
            } 
            else
            {
                $('#input' + this.id).removeClass('has-error');
                if ($(this).attr("valida") == "SI")
                {
                //$(this).val($(this).val().toUpperCase());
                }
            }
        });
        if (listv == 1)
        {
            swal({
                title:'@lang("sistema.users_alert")',
                text:msg,
                type:'error',
                timer: 4000,
                confirmButtonColor:'red',
                confirmButtonText:'OK'
            });
            return false;
        } 
        else
        {
            $("#btnCreateTrade").prop('disabled', true);
            return true;
        }
    }

    //calc spread
    function get_spread(){
        var type = $('#type').val();
        var opening_price = $('#opening_price').val();
        opening_price = (opening_price == '') ? '0' : opening_price;
        opening_price = opening_price.split(',').join('');
        var closing_price = $('#closing_price').val();
        closing_price = (closing_price == '') ? '0' : closing_price;
        closing_price = closing_price.split(',').join('');
        if (type == 1){
            $('#spread').val((opening_price - closing_price).toFixed(6));
        } else if (type == 2){
            $('#spread').val((closing_price - opening_price).toFixed(6));
        } else{
            $('#spread').val('');
        }
        $('#spread').blur();
        //get_gross_profit();
    }

    function get_financial_exhibition(){
        var leverage = $('#leverage_tmp').val();
        if (leverage != ''){
            var opening_price = $('#opening_price').val();
            opening_price = (opening_price == '') ? '0' : opening_price;
            opening_price = opening_price.split(',').join('');
            $('#financial_exhibition').val((opening_price * leverage).toFixed(7));
        } 
        else
        {
            $('#financial_exhibition').val('');
        }
        $('#financial_exhibition').blur();
    }

    function get_contract(){
        /*
        var initial_capital = $('#initial_capital').val();
        initial_capital = initial_capital.split(',').join('');
        initial_capital = parseFloat((initial_capital == '') ? '0' : initial_capital);
        */
        financial_exhibition = $('#financial_exhibition').val();
        financial_exhibition = parseFloat((financial_exhibition == '') ? '0' : financial_exhibition);
        if (financial_exhibition != 0 && financial_exhibition != ''){
            //$('#contracts').val(Math.floor(financial_exhibition));
        } 
        else
        {
            //$('#contracts').val();
        }
        //get_gross_profit();
    }

    function get_gross_profit(){
        var contracts = $('#contracts').val();
        contracts = (contracts == '') ? '0' : contracts;
        contracts = contracts.split(',').join('');
        var spread = $('#spread').val();
        spread = (spread == '') ? '0' : spread;
        spread = spread.split(',').join('');
        
        let conversion_cierre = $("#conversion_closing").val();        
        let gross_profit = (contracts * spread) / (conversion_cierre > 0 ? conversion_cierre : 1);        
        $('#gross_profit').val((gross_profit).toFixed(6));
        $('#gross_profit').blur();
    }

    function get_stop_loss(){
        var type = $('#type').val();
        var opening_price = $('#opening_price').val();
        opening_price = (opening_price == '') ? '0' : opening_price;
        opening_price = parseFloat(opening_price.split(',').join(''));
        var financial_exhibition = $('#financial_exhibition').val();
        financial_exhibition = (financial_exhibition == '') ? '0' : financial_exhibition;
        financial_exhibition = parseFloat(financial_exhibition.split(',').join(''));
        if (type == 1){
            $('#stop_loss').val((opening_price + financial_exhibition).toFixed(6));
        } else if (type == 2){
            $('#stop_loss').val((opening_price - financial_exhibition).toFixed(6));
        } else{
            $('#stop_loss').val('');
        }
        $('#stop_loss').blur();
    }

    function get_leverage(){
        var id = $('#leverage').val();
        if (id != ''){
            $.ajax({
                type: 'GET',
                dataTyoe: 'json',
                url: "{{ url('/ajax_getleverages')}}" + "/" + id,
                beforeSend: function() {
                //$('#modal-espere').modal('show');
                },
                success: function(response) {
                    if (response['status'] == 1){
                        $('#leverage_tmp').val((response['data']));
                    } else{
                        $('#leverage_tmp').val(0);
                    }
                    //change_all();
                },
                error: function(response) {
                    console.log(response);
                },
                complete: function() {
                    //$('#modal-espere').modal('hide');
                    change_all();
                }
            });
        } else{
            $('#leverage_tmp').val(0);
            change_all();
        }
    }

    function get_facial_value(){
        var opening_price = $('#opening_price').val();
        opening_price = (opening_price == '') ? '0' : opening_price;
        opening_price = parseFloat(opening_price.split(',').join(''));
        var conversion_opening = $('#conversion_opening').val();
        conversion_opening = (conversion_opening == '') ? '0' : conversion_opening;
        conversion_opening = parseFloat(conversion_opening.split(',').join(''));
        var contracts = $('#contracts').val();
        contracts = (contracts == '') ? '0' : contracts;
        contracts = parseFloat(contracts.split(',').join(''));
        if (conversion_opening != '' && conversion_opening != 0)
        {
            $('#facial_value').val(((opening_price * contracts) / conversion_opening).toFixed(2));
        } 
        else{
            $('#facial_value').val(0);
        }
        $('#facial_value').blur();
    }

    function get_commission(){
        var facial_value = $('#facial_value').val();
        facial_value = (facial_value == '') ? '0' : facial_value;
        facial_value = parseFloat(facial_value.split(',').join(''));
        if ($('#commission_fee').val() != '')
        {
            var commission_fee = parseFloat($('#commission_fee option:selected').text().split('%').join(''));
            $('#commission').val(((facial_value * commission_fee) / 100).toFixed(6));
        } 
        else
        {
            $('#commission').val(0);
        }
        $('#commission').blur();
    }

    function get_net_result(){
        var gross_profit = $('#gross_profit').val();
        gross_profit = (gross_profit == '') ? '0' : gross_profit;
        gross_profit = parseFloat(gross_profit.split(',').join(''));
        var commission = $('#commission').val();
        commission = (commission == '') ? '0' : commission;
        commission = parseFloat(commission.split(',').join(''));
        $('#net_result').val((gross_profit - commission).toFixed(6));
        $('#net_result').blur();
    }

    function get_final_capital_client(){
        /*
        var initial_capital = $('#initial_capital').val();
        initial_capital = initial_capital.split(',').join('');
        initial_capital = parseFloat((initial_capital == '') ? '0' : initial_capital);
        */
        /*
        var net_result = $('#net_result').val();
        net_result = (net_result == '') ? '0' : net_result;
        net_result_n = parseFloat(net_result.split(',').join(''));
        $('#final_capital_client').val((net_result_n).toFixed(6));
        */
    }

    function get_warranty(){
        var facial_value = $('#facial_value').val();
        facial_value = (facial_value == '') ? '0' : facial_value;
        facial_value = parseFloat(facial_value.split(',').join(''));
        var leverage_tmp = $('#leverage_tmp').val();
        leverage_tmp = (leverage_tmp == '') ? '0' : leverage_tmp;
        leverage_tmp = parseFloat(leverage_tmp.split(',').join(''));
        $('#warranty').val((leverage_tmp * facial_value).toFixed(2));
        $('#warranty').blur();
    }

    $('#type').on('change', function() {
        change_all();
    });

    $('#closing_price').on('change', function() {
        change_all();
    });

    $('#leverage').on('change', function() {
        get_leverage();
    });

    $('#opening_price').on('change', function() {
        change_all();
    });

    $('#conversion_opening').on('change', function() {
        change_all();
    });

    $('#contracts').on('change', function() {
        //change_all();
        get_gross_profit();
        get_facial_value();
        get_commission();
        get_warranty();
        get_net_result();
        get_final_capital_client();
    });

    $('#commission_fee').on('change', function() {
        change_all();
    });

    $('#initial_capital').on('change', function() {
        //change_all();
    });

    function change_all(){
        get_spread();
        get_financial_exhibition();
        get_contract();
        get_stop_loss();
        get_gross_profit();
        get_facial_value();
        get_commission();
        get_warranty();
        get_net_result();
        get_final_capital_client();
    }

    function isNumber(event)
    {
        var keyCode = event.keyCode;
        if(keyCode >= 48 && keyCode <= 57)
        {
            return true;
        }
        return false;
    }
    
    $('body').on('click', '.btn_cancel_ticket', function(){
       $("#error_block").remove();
    });

    $('body').on('click', '.btn_accept_ticket', function(){
       $("#ticket").val($(this).data('bid'));
       $("#error_block").remove();
    });
</script>
@endsection