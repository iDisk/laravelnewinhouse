@extends('layouts.main')
@section('customcss')
@endsection
@section('pagecontent')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">@lang('sistema.movimientos_transaction.movimientos_transactions_details')</h4>
                <ol class="breadcrumb p-0 m-0">
                    <li>
                        <a href="javascript:void(0)">@lang('sistema.pie')</a>
                    </li>
                    <li>
                        <a href="{{ url('reporte/equity') }}">@lang('sistema.movimientos_transaction.movimientos_transactions')</a>
                    </li>
                    <li class="active">
                        @lang('sistema.movimientos_transaction.movimientos_transactions_details')
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
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <table class="table_movements table table-striped table-bordered nowrap dataTable no-footer" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th style="text-align: center;">ID</th>
                                        <th style="text-align: center;">@lang('sistema.equity_report.deposits')</th>
                                        <th style="text-align: center;">@lang('sistema.equity_report.withdrawals')</th>
                                        <th style="text-align: center;">@lang('sistema.equity_report.credits')</th>
                                        <th style="text-align: center;">@lang('sistema.equity_report.expenses')</th>
                                        <th style="text-align: center;">@lang('sistema.equity_report.tr_comm')</th>
                                        <th class="text-center">@lang('sistema.equity_report.profit_loss')</th>
                                        <th class="text-center">@lang('sistema.equity_report.summary')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(isset($moments2) && count($moments2) > 0)
                                    @foreach($moments2 as $key => $moment_report)
                                    @php
                                    $total_plus = $moment_report['deposits_amount'] + $moment_report['credit_amount'];
                                    $total_negative = $moment_report['withdrawals_amount'] + $moment_report['expenses_amount'] + $moment_report['commission_amount'];
                                    $total_balance = $total_plus - $total_negative + $moment_report['profil_loss_amount'];
                                    @endphp
                                    <tr>
                                        <td class="text-center">{{ $key + 1 }}</td>
                                        <td class="text-center">{{ $moment_report['deposits_amount'] }}</td>
                                        <td class="text-center">{{ $moment_report['withdrawals_amount'] }}</td>
                                        <td class="text-center">{{ $moment_report['credit_amount'] }}</td>
                                        <td class="text-center">{{ $moment_report['expenses_amount'] }}</td>
                                        <td class="text-center">{{ $moment_report['commission_amount'] }}</td>
                                        <td class="text-center">{{ $moment_report['profil_loss_amount'] }}</td>
                                        <td class="text-center">{{ number_format($total_balance,2,'.',',') }}</td>
                                    </tr>
                                    @endforeach
                                    @else
                                    <tr class="text-center">
                                        <td colspan="8">@lang('sistema.trade_report.no_data')</td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <h5>@lang('sistema.movimientos_transaction.movimientos_transactions')</h5>
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered dt-responsive nowrap dataTable no-footer dtr-inline" id="movimientos_tipo-table" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th style="text-align: center;">Id</th>
                                            <th style="text-align: center">@lang('sistema.movimientos_transaction.lbl_movimiento')</th>
                                            <th style="text-align: center">@lang('sistema.equity_report.equity')</th>
                                            <th style="text-align: center;">@lang('sistema.movimientos_transaction.monto')</th>
                                            <th style="text-align: center;">@lang('sistema.movimientos_transaction.fecha_transaccion')</th>
                                            <th style="text-align: center;">@lang('sistema.movimientos_transaction.fecha_valor')</th>
                                            <th style="text-align: center;">@lang('sistema.created')</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(isset($moments) && count($moments) > 0)
                                        @foreach($moments as $key => $moment)
                                        <tr>
                                            <td class="text-center">{{ $key + 1 }}</td>
                                            <td class="text-center">{{ isset($moment['m_type']) ? $moment['m_type'] : '-' }}</td>
                                            <td class="text-center">{{ isset($moment['equity']) ? $moment['equity'] : '-' }}</td>
                                            <td style="text-align: right;">{{ number_format($moment['monto'],2,'.',',') }}</td>
                                            <td style="text-align: center;">{{ $moment['fecha_transaccion'] }}</td>
                                            <td style="text-align: center;">{{ $moment['fecha_valor'] }}</td>
                                            <td style="text-align: center;">{{ $moment['created_at'] }}</td>
                                        </tr>
                                        @endforeach
                                        @else
                                        <tr class="text-center">
                                            <td colspan="5">@lang('sistema.trade_report.no_data')</td>
                                        </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>  
                    </div>
                    <div class="form-group m-b-0" style="margin-top: 25px;">
                        <div class="row">
                            <div class="col-lg-12">  
                                <a href="{{ url('reporte/equity') }}" class="btn btn-danger waves-effect waves-light">@lang('sistema.btn_back')</a>
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
@endsection