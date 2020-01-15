@extends('layouts.main')
@section('customcss')
<link href="{{ url('assets/plugins/datatables/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ url('assets/plugins/datatables/buttons.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ url('assets/plugins/datatables/responsive.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ url('assets/plugins/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css"/>
<link href="{{ url('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
<style>
    #movimientos_tipo-table_filter{
        display: inline-block;
        float: right;
    }
    .toolbar3{
        display: inline-block;
        float: right;
        margin-right: 10px;
        width: 255px;
    }
    .account_select{
        display: inline-block;
        height: 38px;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow{
        top: 2px;
    }
    .select2.select2-container{
        width: 215px !important;
    }
    @media only screen and (max-width: 600px) {
        .select2.select2-container{
            width: 100% !important;
        }    
    } 
    .select2-container--default .select2-selection--single .select2-selection__rendered{
        font-weight: normal;
        font-size: 13px;
        line-height: 30px !important;
    }
    .select2-container .select2-selection--single{
        height: 30px !important;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow{
        top: 2px;
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered{
        font-weight: normal;
        font-size: 13px;
        line-height: 30px !important;
    }
    .select2-container .select2-selection--single, #custom_search{
        height: 30px !important;
    }        
    #custom_search{
        float: right;
    }
</style>
@endsection
@section('pagecontent')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">@lang('sistema.trade_investment.lbl_trade_investment')</h4>
                <ol class="breadcrumb p-0 m-0">
                    <li>
                        <a href="javascript:void(0)">@lang('sistema.pie')</a>
                    </li>                    
                    <li class="active">
                        @lang('sistema.trade_investment.lbl_trade_investment')
                    </li>
                </ol>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">                    
                    <a href="{{ url('trade_investment/create') }}" class="btn btn-success waves-effect waves-light pull-right m-b-10"><span class="glyphicon glyphicon-check"></span> @lang('sistema.trade_investment.new_trade')</a>
                    <div class="clearfix"></div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div style="display: inline-block;margin-right: 5px;">
                                <label class="">@lang('sistema.broker.broker'):</label>
                                <select class="select2" name="broker_select" id="broker_select">
                                    <option value="">@lang('sistema.all')</option>
                                    @if(isset($global_assigned_brokers) && count($global_assigned_brokers) > 0)
                                    @foreach($global_assigned_brokers as $broker)
                                    <option value="{{ $broker['id'] }}">{{ $broker['broker'] }}</option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                            <div style="display: inline-block;margin-right: 5px;">
                                <label class="custom_search_title">@lang('sistema.account'):
                                    <select class="select2" name="account_select" id="account_select">
                                        <option value="">@lang('sistema.all')</option>
                                        @if(isset($accounts) && count($accounts) > 0)
                                        @foreach($accounts as $account)
                                        @php
                                            $primary_account = $account->primary_client;
                                        @endphp
                                        <option value="{{ $account->id }}">{{ $account->account_number }}{{ $account->primary_client ? ' - ' . $account->primary_client->full_name : '' }}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                </label>
                            </div>
                            <div style="display: inline-block;margin-right: 5px;">
                                <label class="custom_search_title">@lang('sistema.transaction.instrument'): 
                                    <select class="select2" name="instrument_id" id="instrument_id">
                                        <option value="">@lang('sistema.all')</option>
                                        @foreach($instruments as $key=>$instrument)
                                            <option value="{{ $key }}">{{ $instrument }}</option>
                                        @endforeach
                                    </select>
                                </label>
                            </div>
                            <div style="display: inline-block;float: right;">
                                <label class="custom_search_title">@lang('sistema.search'): &nbsp;<input name="custom_search" id="custom_search" type="text"/></label>
                            </div>
                        </div>
                    </div>                                        
                    <div class="clearfix"></div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered dt-responsive nowrap dataTable no-footer dtr-inline" id="transactions-table" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>Id</th>                                            
                                            <th>@lang('sistema.movimientos_transaction.account_number')</th>
                                            <th>@lang('sistema.equity_report.customer')</th>                                            
                                            <th>@lang('sistema.trade_investment.ticket')</th>
                                            <th>@lang('sistema.transaction.instrument')</th>
                                            <th class="text-center">@lang('sistema.trade_investment.tipo')</th>                                            
                                            <th class="text-center">@lang('sistema.trade_investment.fecha')</th>
                                            <th class="text-right">@lang('sistema.trade_investment.monto')</th>
                                            <th>@lang('sistema.created')</th>
                                            <th class="text-center">@lang('sistema.action')</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div><!-- container -->                
<footer class="footer">
    © {{ date('Y') }} @lang('sistema.pie')
</footer>
@endsection
@section('customjs')
<script type="text/javascript" src="{{ url('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script type="text/javascript" src="{{ url('assets/plugins/datatables/dataTables.bootstrap4.min.js') }}"></script>
<script type="text/javascript" src="{{ url('assets/plugins/datatables/dataTables.keyTable.min.js') }}"></script>
<script type="text/javascript" src="{{ url('assets/plugins/datatables/dataTables.responsive.min.js') }}"></script>
<script type="text/javascript" src="{{ url('assets/plugins/datatables/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ url('assets/plugins/select2/js/select2.min.js') }}"></script>

@if (session('msg'))            
<script>
@if (session('type') == 'success')
    swal({
        title:'Aviso!!',
        text:'{{session("msg")}}',
        type:'success',
        timer: 3500,
        confirmButtonColor:'green',
        confirmButtonText:'OK'
    });
@endif
@if (session('type') == 'error')
    swal({
        title:'Aviso!!',
        text:'{{session("msg")}}',
        type:'error',
        timer: 3500,
        confirmButtonColor:'red',
        confirmButtonText:'OK'
    });
@endif
</script>
@endif

<script type="text/javascript">
    function confirmaDel(id, text)
    {
        swal({
            title: "{{ __('sistema.confirm') }}",
            text: "{{ __('sistema.transaction.delete_msg') }} :\"" + text + '\"?',
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: '#DD6B55',
            confirmButtonText: "{{ __('sistema.btn_delete') }}",
            cancelButtonText: "{{ __('sistema.btn_cancel') }}"
        })
        .then(function () {
            var formulario = $('#borra_Frm' + id);
            formulario.submit();
            }, function (dismiss) {
            //Code for cancel
            }
        );
    }

    //Aqui deben de ir las secciones adicionales
    var table_transactions;
    $(function() {
        $(".select2").select2();    
        table_transactions = $('#transactions-table').DataTable({
            processing: true,
            serverSide: true,
            order: [[ 8, "desc" ]],
            ajax: {
                url: '{!! url("datatable/trade_investment") !!}',
                data: function (d) {
                    let account_select = $('body').find('select[name=account_select]');
                    let instrument_select = $('body').find('select[name=instrument_id]');
                    d.instrument_id = instrument_select.val();
                    if (!account_select.length)
                    {
                        d.account_id = '';
                    }
                    else
                    {
                        d.account_id = account_select.val();
                    }
                    let search_keyword = $('body').find('input[name=custom_search]');
                    if (!search_keyword.length)
                    {
                        d.search = {
                            'value': ''
                        };
                    }
                    else
                    {
                        d.search = {
                            'value': search_keyword.val()
                        };                        
                    }
                    let broker_id = $('body').find('select[name=broker_select]');
                    if (!broker_id.length)
                    {
                        d.broker_id = '';
                    }
                    else
                    {
                        d.broker_id = broker_id.val();                       
                    }
                }
            },
            language:{
            @if (\Lang::locale() == 'es')
                url: '{{url("assets/plugins/datatables/json/Spanish.json")}}'
            @endif
            },
            dom: 'l<>rtip',
            initComplete: function(){
            
            },
            columns: [
                { data: 'id', name: 'id' },                
                { data: 'account_number', name: 'account_number' },
                { data: 'client_name', name: 'client_name' },                
                { data: 'ticket', name: 'ticket' },
                { data: 'instrument', name: 'instrument' },
                { data: 'tipo', name: 'tipo',  class: 'text-center' },
                { data: 'fecha', name: 'fecha',  class: 'text-center' },
                { data: 'monto', name: 'monto',  class: 'text-right' },
                { data: 'created_at', name: 'created_at' },
                { data: 'action', name: 'action', orderable:false, searchable:false, class: 'text-center' },
            ]
        });
        $('#account_select').change(function(){
            table_transactions.draw();
        });
        $('#instrument_id').change(function(){
            table_transactions.draw();
        });
        $('input[name=custom_search]').change(function(){
            table_transactions.draw();
        });
    });
    function reload_table()
    {
        table_transactions.draw();
    }
</script>
@endsection