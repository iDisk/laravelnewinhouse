@extends('layouts.main')
@section('customcss')
<link href="{{ url('assets/plugins/datatables/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ url('assets/plugins/datatables/buttons.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ url('assets/plugins/datatables/responsive.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ url('assets/plugins/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css"/>
<style>
    #table_transactions thead tr th{
        text-align: center;
        padding: 15px 10px;
    }
</style>
@endsection
@section('pagecontent')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">@lang('sistema.equity_report.history.history_details')</h4>
                <ol class="breadcrumb p-0 m-0">
                    <li>
                        <a href="javascript:void(0)">@lang('sistema.pie')</a>
                    </li>
                    <li>
                        <a href="{{ url('reporte/trade/history') }}">@lang('sistema.equity_report.history.label')</a>
                    </li>
                    <li class="active">
                        @lang('sistema.equity_report.history.history_details')
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
                    <div class="row" style="margin-bottom: 25px;">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="table-responsive">
                                <table id="table_transactions" class="table_transactions table table-striped table-bordered nowrap dataTable no-footer" style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>@lang('sistema.trade_report.ticket')</th>
                                            <th>@lang('sistema.trade_report.date')</th>
                                            <th>@lang('sistema.trade_report.type')</th>
                                            <th>@lang('sistema.transaction.instrument')</th>
                                            <th>@lang('sistema.transaction.item')</th>
                                            <th>@lang('sistema.transaction.opening_date')</th>
                                            <th>@lang('sistema.trade_report.open_time')</th>
                                            <th>@lang('sistema.trade_report.open_price')</th>        
                                            <th>@lang('sistema.trade_report.conversion_opening')</th>
                                            <th>@lang('sistema.transaction.closing_date')</th>
                                            <th>@lang('sistema.trade_report.close_time')</th>
                                            <th>@lang('sistema.trade_report.close_price')</th>
                                            <th>@lang('sistema.trade_report.conversion_closing')</th>
                                            <th>@lang('sistema.trade_report.leverage')</th>            
                                            <th>@lang('sistema.transaction.stop_loss')</th>
                                            <th>@lang('sistema.transaction.contracts')</th>
                                            <th>@lang('sistema.transaction.facial_value')</th>
                                            <th>@lang('sistema.transaction.warranty')</th>
                                            <th>@lang('sistema.transaction.commission')</th>            
                                            <th>@lang('sistema.trade_report.net_result')</th>            
                                        </tr>
                                    </thead>
                                    <tbody>        
                                        @if(isset($combos) && count($combos) > 0)
                                        @foreach($combos as $timestamp => $transaction)
                                            @if($transaction['trs_type'] == 1)
                                            <tr>
                                                <td>{{ $transaction->ticket }}</td>
                                                <td>{{ date("y-m-d", strtotime($transaction->created_at)) }}</td>
                                                <td>{{ session('language') == 'es' ? $transaction->transaction_type->type_en : $transaction->transaction_type->type_en }}</td>
                                                <td>{{ session('language') == 'es' ? $transaction->instrument->instrument_es : $transaction->instrument->instrument_en }}</td>
                                                <td>{{ session('language') == 'es' ? $transaction->item->item_es : $transaction->item->item_en }}</td>
                                                <td style="text-align: center;">{{ date("y-m-d", strtotime($transaction->opening_date)) }}</td>
                                                <td style="text-align: center;">{{ $transaction->opening_time }}</td>
                                                <td style="text-align: right;">${{ number_format($transaction->opening_price, 2, '.', ',') }}</td>
                                                <td style="text-align: right;">${{ number_format($transaction->conversion_opening, 2, '.', ',') }}</td>
                                                <td style="text-align: center;">{{ date("y-m-d", strtotime($transaction->closing_date)) }}</td>
                                                <td style="text-align: center;">{{ $transaction->closing_time }}</td>
                                                <td style="text-align: right;">${{ number_format($transaction->closing_price, 2, '.', ',') }}</td>
                                                <td style="text-align: right;">${{ number_format($transaction->conversion_closing, 2, '.', ',') }}</td>
                                                <td style="text-align: center;">{{ $transaction->leverage->label }}</td>
                                                <td style="text-align: right;">${{ number_format($transaction->stop_loss, 2, '.', ',') }}</td>
                                                <td style="text-align: right;">{{ $transaction->contracts }}</td>
                                                <td style="text-align: right;">${{ number_format($transaction->facial_value, 2, '.', ',') }}</td>
                                                <td style="text-align: right;">${{ number_format($transaction->warranty, 2, '.', ',') }}</td>
                                                <td style="text-align: right;">${{ number_format($transaction->commission, 2, '.', ',') }}</td>
                                                <td style="text-align: right;">$@if($transaction->net_result < 0){{ '(' }}@endif{{ number_format($transaction->net_result, 2, '.', ',') }}@if($transaction->net_result < 0){{ ')' }}@endif</td>
                                            </tr>
                                            @elseif($transaction['trs_type'] == 2)
                                            <tr>
                                                <td style="text-align: center;">{{ '-' }}</td>
                                                <td>{{ date("y-m-d", strtotime($transaction['fecha_transaccion'])) }}</td>
                                                <td></td>
                                                <td>{{ $transaction['type_'.session('language')] }}</td>
                                                <td>{{ $transaction['description_'.session('language')] }}</td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td style="text-align: right;">${{ number_format($transaction['monto'],2,'.',',') }}</td>
                                            </tr>
                                            @endif
                                        @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="form-group m-b-0" style="margin-top: 25px;">
                        <div class="row">
                            <div class="col-lg-12">                                                                              
                                <a href="{{ url('reporte/trade/history') }}" class="btn btn-danger waves-effect waves-light">@lang('sistema.btn_back')</a>
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
<script>
    show_loader(true);
    $(function(){        
        $("#table_transactions").DataTable({
            "order": [[ 1, 'asc' ]],
            "columns": [                
                { orderable:false },
                { orderable:false },
                { orderable:false },
                { orderable:false },
                { orderable:false },
                { orderable:false },
                { orderable:false },
                { orderable:false },
                { orderable:false },
                { orderable:false },
                { orderable:false },
                { orderable:false },
                { orderable:false },
                { orderable:false },
                { orderable:false },
                { orderable:false },
                { orderable:false },
                { orderable:false },
                { orderable:false },
                { orderable:false },
            ]
        });
        show_loader(false);
    });
</script>
@endsection