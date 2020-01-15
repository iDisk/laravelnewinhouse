<!--<div class="clearfix"></div>
<div class="row">
    <div class="col-lg-12">
        <div style="display: inline-block;float: right;">
            <label class="custom_search_title" style="margin-top: 5px;">@lang('sistema.search'): &nbsp;<input name="custom_search" id="custom_search" type="text"/></label>
        </div>
    </div>
</div>   -->
<div class="clearfix"></div>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="table-responsive">
            <div class="transaction_block" style="margin-top: 25px;">    
                <table class="table_transactions table table-responsive table-striped table-bordered nowrap dataTable no-footer" style="width: 100%;border-collapse: collapse; border-spacing: 0;margin-bottom: 30px;">
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
                            @if(isset($transaction->item))
                            <td>{{ session('language') == 'es' ? $transaction->item->item_es : $transaction->item->item_en }}</td>
                            @else
                            <td>-</td>
                            @endif
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
                            <td style="text-align: center;">{{ $transaction->contracts }}</td>
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
                            <td>{{ $transaction['type_' . session("language")] }}</td>
                            <td>{{ $transaction['movimientos_descripcion'] }}</td>
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
                            <td style="text-align: right;">{{ number_format($transaction['monto'],2,'.',',') }}</td>
                        </tr>
                        @endif
                        @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div style="clear: both;"></div>

