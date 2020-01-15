@extends('layouts.main')
@section('customcss')
<link href="{{ url('assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet">
<link href="{{ url('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
<style type="text/css">
    .datepicker>div{
        display: block;
    }
    .datepicker table tr td.disabled, .datepicker table tr td.disabled:hover{
        color:#bbbaba;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow b{
        margin-top: 3px;
    }
    .search_loader{
        display: inline-block;
        position: absolute;
        top: 7px;
        right: 25px;
    }
</style>
@endsection
@section('pagecontent')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">@lang('sistema.movimientos_transaction.create_movimientos_tran')</h4>
                <ol class="breadcrumb p-0 m-0">
                    <li>
                        <a href="javascript:void(0)">@lang('sistema.pie')</a>
                    </li>
                    <li>
                        <a href="{{ url('movimientos_transactions') }}">
                            @lang('sistema.movimientos_transaction.movimientos_transactions')
                        </a>
                    </li>
                    <li class="active">
                        @lang('sistema.movimientos_transaction.create_movimientos_tran')
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
                            <form class="form-horizontal"  method="POST" action="{{url('movimientos_transactions')}}" id="frm_movimientos_transactions" onsubmit="return validateFrm();" enctype="multipart/form-data">

                                {{ csrf_field() }}
                                <div class="form-group col-lg-12 row">
                                    <div class="form-group col-lg-6 row m-0" id="inputaccount_number">
                                        <label for="account_number" class="col-sm-3 form-control-label">
                                            @lang('sistema.movimientos_transaction.account_number')<span class="text-danger">*</span>
                                        </label>
                                        <div class="col-sm-9">
                                            <select id="account" class="form-control select2" name="account" valida="SI" cadena="{{__('sistema.movimientos_transaction.req_account_number')}}">
                                                <option value="">@lang('sistema.btn_select')</option>
                                                @foreach($accounts as $account)
                                                @php
                                                $primary_account = $account->primary_client;
                                                @endphp                                                  
                                                <option value="{{ $account->id }}" {{ old('account') == $account->id ? 'selected' : '' }}>{{ $account->account_number }}{{  $primary_account ?  ' - ' . $primary_account->full_name : '' }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>                                    
                                    <div class="form-group col-lg-6 row m-0" id="inputticket">
                                        <label for="ticket" class="col-sm-3 form-control-label">@lang('sistema.movimientos_transaction.ticket')<span class="text-danger">*</span></label>
                                        <div class="col-sm-9">
                                            <input type="text" autocomplete="off" tabindex="1" maxlength="8" onkeypress="return isNumber(event)" class="form-control" id="ticket" name="ticket" placeholder="{{__('sistema.movimientos_transaction.ticket')}}" valida="SI" cadena ="{{__('sistema.movimientos_transaction.req_ticket')}}" value="{{ (old('ticket'))? old('ticket'): $token_number }}">
                                        </div>
                                    </div>                                    
                                </div>
                                <div class="form-group col-lg-12 row">
                                    <div class="form-group col-lg-6 row m-0" id="inputinstrument">
                                        <label for="instrument" class="col-sm-3 form-control-label">
                                            @lang('sistema.movimientos_transaction.instrument')<span class="text-danger">*</span>
                                        </label>
                                        <div class="col-sm-9">
                                            <select id="instrument" class="form-control" name="instrument" valida="SI" cadena="{{__('sistema.movimientos_transaction.req_instrument')}}">
                                                <option value="">@lang('sistema.btn_select')</option>
                                                @foreach($instruments as $key=>$value)
                                                <option value="{{ $key }}" {{ old('instrument') == $key ? 'selected' : '' }}>{{ $value }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-lg-6 row m-0" id="inputmonto">
                                        <label for="monto" class="col-sm-3 form-control-label">
                                            @lang('sistema.movimientos_transaction.monto')<span class="text-danger">*</span>
                                        </label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control autonumber" id="monto" name="monto" placeholder="{{__('sistema.movimientos_transaction.monto')}}" valida="SI" cadena ="{{__('sistema.movimientos_transaction.req_monto')}}" value="{{ (old('monto'))? old('monto'):'' }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-lg-12 row">
                                    <div class="form-group col-lg-6 row m-0" id="inputfecha_transaccion">
                                        <label for="fecha_transaccion" class="col-sm-3 form-control-label">
                                            @lang('sistema.movimientos_transaction.fecha_transaccion')<span class="text-danger">*</span>
                                        </label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control date_picker" id="fecha_transaccion" name="fecha_transaccion" placeholder="{{__('sistema.movimientos_transaction.fecha_transaccion')}}" valida="SI" cadena ="{{__('sistema.movimientos_transaction.req_fecha_transaccion')}}" value="{{ (old('fecha_transaccion'))? old('fecha_transaccion'):'' }}">
                                        </div>
                                    </div>
                                    <div class="form-group col-lg-6 row m-0" id="inputfecha_valor">
                                        <label for="fecha_valor" class="col-sm-3 form-control-label">
                                            @lang('sistema.movimientos_transaction.fecha_valor')<span class="text-danger">*</span>
                                        </label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control date_picker2" id="fecha_valor" name="fecha_valor" placeholder="{{__('sistema.movimientos_transaction.fecha_valor')}}" valida="SI" cadena ="{{__('sistema.movimientos_transaction.req_fecha_valor')}}" value="{{ (old('fecha_valor'))? old('fecha_valor'):'' }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-lg-12 row">
                                    <div class="form-group col-lg-6 row m-0" id="inputmovimientos_tipo">
                                        <label for="movimientos_tipo" class="col-sm-3 form-control-label">
                                            @lang('sistema.movimientos_transaction.movimientos_tipo')<span class="text-danger">*</span>
                                        </label>
                                        <div class="col-sm-9">
                                            <select id="movimientos_tipo" class="form-control" name="movimientos_tipo" valida="SI" cadena="{{__('sistema.movimientos_transaction.req_movimientos_tipo')}}">
                                                <option value="">@lang('sistema.btn_select')</option>
                                                @foreach($movimientos_tipos as $key=>$value)
                                                <option value="{{ $key }}" {{ old('movimientos_tipo') == $key ? 'selected' : '' }}>{{ $value }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-lg-6 row m-0" id="inputmovimientos_descripcion">
                                        <label for="movimientos_descripcion" class="col-sm-3 form-control-label">
                                            @lang('sistema.movimientos_transaction.movimientos_descripcion')<span class="text-danger">*</span>
                                        </label>
                                        <div class="col-sm-9">
                                            <input maxlength="150" class="form-control" id="movimientos_descripcion" placeholder="{{ __('sistema.movimientos_transaction.movimientos_descripcion') }}" name="movimientos_descripcion" valida="SI" cadena="{{__('sistema.movimientos_transaction.req_movimientos_descripcion')}}" value="{{ (old('movimientos_descripcion'))? old('movimientos_descripcion'):'' }}"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-lg-12 row">
                                    <div class="form-group col-lg-6 row m-0" id="inputoperation_category">
                                        <label for="optDr" class="col-sm-3 form-control-label">@lang('sistema.movimientos_transaction.category')<span class="text-danger">*</span></label>
                                        <div class="col-sm-9">
                                            <div class="radio">
                                                <label for="optCr">
                                                    <input type="radio" name="operation_category" value="1" id="optCr" {{ old('operation_category') == 1 ? 'checked' : '' }}>
                                                    <span class="cr"><i class="cr-icon mdi mdi-checkbox-blank-circle"></i></span>
                                                    @lang('sistema.movimientos_transaction.category_abono')
                                                </label>
                                                &nbsp;&nbsp;&nbsp;
                                                <label for="optDr">
                                                    <input type="radio" name="operation_category" value="0" id="optDr" {{ old('operation_category') == 0 ? 'checked' : '' }}>
                                                    <span class="cr"><i class="cr-icon mdi mdi-checkbox-blank-circle"></i></span>
                                                    @lang('sistema.movimientos_transaction.category_charge')
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-lg-6 row m-0" id="inputreference_ticket">
                                        <label for="reference_ticket" class="col-sm-3 form-control-label">@lang('sistema.movimientos_transaction.reference_ticket')</label>
                                        <div class="col-sm-9">
                                            <input type="text" readonly autocomplete="off" tabindex="1" maxlength="8" onkeypress="return isNumber(event)" class="form-control" id="reference_ticket" name="reference_ticket" placeholder="{{__('sistema.movimientos_transaction.reference_ticket')}}" valida="NO" cadena ="{{__('sistema.movimientos_transaction.req_reference_ticket')}}" value="{{ (old('reference_ticket'))? old('reference_ticket'): '' }}">
                                            <div class="search_loader" style="display: none;">
                                                <img class="img-responsive" style="height: 24px; width: 24px;" src="{{ asset('assets/images/ajax_loader.gif') }}"/>
                                            </div>
                                        </div>
                                    </div> 
                                </div>
                                <div class="form-group col-lg-12 row" id="block_balance_information" style="display: none;">                                    
                                    <div class="form-group col-lg-6 row m-0"></div>
                                    <div class="form-group col-lg-6 row m-0">
                                        <div class="col-sm-3"></div>
                                        <div class="col-sm-9">                                            
                                            <table class="table table-bordered table-striped" style="width: 100%; margin-top: 25px;">
                                                <tr>
                                                    <td>Monto original</td>
                                                    <td class="text-right">$<span id="monto_credits">0.00</span></td>
                                                </tr>
                                                <tr>
                                                    <td>Saldo Actual</td>
                                                    <td class="text-right">$<span id="monto_balance">0.00</span></td>
                                                </tr>
                                                <tr>
                                                    <td>Saldo después del pago al crédito</td>
                                                    <td class="text-right">$<span id="monto_deposits">0.00</span></td>
                                                </tr>
                                            </table>                                            
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-lg-12 row">
                                    <div class="form-group col-lg-6 row m-0">
                                        <div class="offset-sm-3 col-sm-9">
                                            <a href="{{url('movimientos_transactions')}}" class="btn btn-danger waves-effect waves-light">
                                                @lang('sistema.btn_back')
                                            </a>
                                            <button type="submit" class="btn btn-info waves-effect waves-light">
                                                @lang('sistema.btn_save')
                                            </button>
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
    var currentRequest = null;
    var ticket_credit_amount;
    var ticket_balance_amount;
    var ticket_deposit_amount;
    var showing_info = false;
    
    //Initialize controls
    $(".date_picker2").datepicker({
        format: 'dd/mm/yyyy',
        autoclose: true,
    });    
    $('.date_picker').datepicker({
        format: 'dd/mm/yyyy',
        //startDate: '-5d',
        //endDate: '+5d',        
        autoclose: true,
    }).on('changeDate', function (selected) {
        var minDate = new Date(selected.date.valueOf());
        $('.date_picker2').datepicker('setStartDate', minDate);
    });
    $('.date_picker').datepicker('setDate', 'today');
    $('.date_picker2').datepicker('setDate', 'today');

    $(function ($) {
        $('.autonumber').autoNumeric('init');
        $(".select2").select2();
    });

    function get_monto()
    {
        let monto_val = $("#monto").val();
        monto_val = monto_val.replace(/\,/g, '');
        monto_val = parseFloat((monto_val !== '' ? monto_val : 0));     
        return monto_val;
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

    function validateFrm()
    {
        var listv = 0;
        var msg = '';

        $('#frm_movimientos_transactions').find(':input').each(function () {
            if(this.id != 'reference_ticket')
            {
                if ($(this).attr("valida") == "SI" && ($(this).val() == "" || $(this).val() == "null"))
                {
                    listv = 1;
                    $('#input' + this.id).addClass('has-error');
                    msg += $(this).attr('cadena') + '\n';
                } else
                {
                    $('#input' + this.id).removeClass('has-error');
                }
            }
        });

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
        } else {
            return true;
        }
    }
    
    $('body').on('click', '.btn_cancel_ticket', function(){
       $("#error_block").remove();
    });

    $('body').on('click', '.btn_accept_ticket', function(){
       $("#ticket").val($(this).data('bid'));
       $("#error_block").remove();
    });
    
    $("#account").change(function(){
        $("#inputreference_ticket").removeClass('has-error');
        showing_info = false;
        $("#block_balance_information").hide();
        if($(this).val() != '')
        {
            $("#reference_ticket").val('').prop('readonly', false);
        }
        else
        {
            $("#reference_ticket").val('').prop('readonly', true);
        }
    });    
    

    
    $('body').on('keyup', '#reference_ticket', function(){
        let this_obj = $(this);        
        $('.search_loader').show();
        let this_obj_val = this_obj.val();
        let ticket_length = this_obj_val.length;  
        
        if(ticket_length == 0)
        {
            $('.search_loader').hide();
            $("#inputreference_ticket").removeClass('has-error');
        }
        
        let this_account_id = $("#account option:selected").val();            
        if(ticket_length >= 8 && this_account_id != '')
        {            
            show_loader(true);
            currentRequest  = $.ajax({
                type: 'POST',
                dataType: 'json',
                data: {ref: this_obj_val, account_id: this_account_id},
                beforeSend : function()    {           
                    if(currentRequest != null) {
                        currentRequest.abort();
                    }
                },
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                url: "{{ url('movimientos_transactions/check_ticket_info') }}",
                success: function (response) {
                    if (response.flag == 1) {
                        //#block_balance_information
                        ticket_credit_amount = response.data.all_credit;
                        ticket_balance_amount = response.data.balance;
                        ticket_deposit_amount = response.data.all_debits;

                        $("#monto_credits").html(ticket_credit_amount.replace(/\d(?=(\d{3})+\.)/g, '$&,'));
                        $("#monto_balance").html(ticket_balance_amount.replace(/\d(?=(\d{3})+\.)/g, '$&,'));
                        $("#monto_deposits").html(ticket_deposit_amount.replace(/\d(?=(\d{3})+\.)/g, '$&,'));
                        $("#block_balance_information").show();
                        $("#inputreference_ticket").removeClass('has-error');
                        showing_info = true;
                        if($("#monto").val() != '')
                        {                            
                            let monto_val = get_monto();                                    
                            update_table(monto_val);                            
                        }                        
                    } 
                    else 
                    {
                        ticket_credit_amount = ticket_balance_amount = ticket_deposit_amount = 0;
                        $("#monto_credits").html(0.00);
                        $("#monto_balance").html(0.00);
                        $("#monto_deposits").html(0.00);
                        $("#block_balance_information").hide();
                        $("#inputreference_ticket").addClass('has-error');
                        showing_info = false;

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
                    showing_info = false;
                    //console.error(response);
                },
                complete: function () {
                    $('.search_loader').hide();
                    show_loader(false);
                }
            });
        }
        else
        {
            ticket_credit_amount = ticket_balance_amount = ticket_deposit_amount = 0;
            $("#monto_credits").html(0.00);
            $("#monto_balance").html(0.00);
            $("#monto_deposits").html(0.00);
            $("#block_balance_information").hide();
            showing_info = false;
        }
    });

    $('#monto').on('keyup', function(){
        let monto_val = get_monto();        
        update_table(monto_val);
    });
   
    $('#reference_ticket').blur(function(){
        let this_val = $(this).val();
        let ticket_length = this_val.length;
        $('.search_loader').hide();
        if(ticket_length == 0)
        {            
            $("#inputreference_ticket").removeClass('has-error');
        }        
        else if(ticket_length >= 8)
        {
            if(showing_info)
            {
                $("#inputreference_ticket").removeClass('has-error');
            }
            else
            {
                $("#inputreference_ticket").addClass('has-error');
            }
        }
    }); 
    
    function update_table(monto_val)
    {        
        if(showing_info)
        {
            let this_ticket_credit_amount = parseFloat(ticket_credit_amount);
            let this_ticket_balance_amount = parseFloat(ticket_balance_amount);
            let this_ticket_deposit_amount = parseFloat(ticket_deposit_amount);

            if(monto_val != '')
            {
                this_ticket_deposit_amount = this_ticket_deposit_amount + monto_val;
                this_ticket_balance_amount = this_ticket_balance_amount - monto_val;
            }

            $("#monto_credits").html(this_ticket_credit_amount.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,'));
            $("#monto_balance").html(this_ticket_balance_amount.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,'));
            $("#monto_deposits").html(this_ticket_deposit_amount.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,'));
        }
    }
</script>
@endsection