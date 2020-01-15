<!Doctype html>
<html>
    <head>
        <style>
            .table, .table tr td, .table tr th{
                border: 1px solid #ccc;
                border-spacing: 0;
            }
            .table tr td, .table tr th{
                padding: 5px 15px;
            }
            .table_primary_info{
                border-spacing: 0;
            }
            .table_primary_info tr td{
                padding: 5px 15px;                
                border-spacing: 0;
            }
            .table_transactions {
                width: 100%;
            }
            .table_transactions th{
                background: #f7f5f5;
                font-weight: normal;
                text-align: center;
            }
            .table_transactions td{
                text-align: center;
            }
            .table_movements {
                width: 100%;
            }
            .table_movements th{
                background: #f7f5f5;
                font-weight: normal;
                text-align: center;
            }
            .table_movements td{
                text-align: center;
            }
            .table_main_header{
                width: 100% !important;
                border-spacing: 0;                
            }
            .table_main_header tr td{

            }
            .table_main_header tr td{
                padding: 0px 15px;                
                border-spacing: 0;
            }
            .m-b-15{
                margin-bottom: 15px;
            }
            table.internal tr td{
                border: none;
            }
            body{
                font-family: sans-serif;
                margin: 0;
                padding: 0;
                margin-top: 80px;
            }
            .page_counter::after {
                counter-increment: section;
                content: counter(section);
            }
            #header{
                /*position: fixed;*/                
                width: 100%;
                top: 0;
            }
            @page{
                margin: 20px 30px 20px 30px;
            }
            #main_header{
                position: fixed;
                top: 10px;
                height: 50px;
            }
        </style>
    </head>
    <body>
        @php
        $primary_client = $data['account']->primary_client;        
        $branch = null;
        if($data['account']->account_type == 'business')
        {
        $branch = $data['account']->business_details->branch;
        }
        else
        {
        $branch = $primary_client->branch;
        }
        $opening_balance = (isset($data['previous_transaction']) && $data['previous_transaction'] != null) ? $data['previous_transaction']->final_capital_client : $data['account']->opening_amount;
        $final_balance = (isset($data['last_transaction']) && $data['last_transaction'] != null) ? $data['last_transaction']->final_capital_client : $data['account']->opening_amount;
        @endphp
        <div id="main_header" class="">
            <img style="height: 50px;" src="{{ asset('assets/images/pwm-logo-gold.png') }}"/>
            <div style="width: 250px; float: right;color: #ccc;font-size: 16px;">
                <span>@lang('sistema.trade_report.contact_tel') +852  300 85680</span>
                <br/>
                <span>@lang('sistema.trade_report.see_reverse')</span>
            </div>
        </div>
        <div id="header" style="height: 25px;" class="m-b-15">
            <p style="margin: 0; float: right; font-size: 24px;color: #edbe6a;padding-right: 50px;">@lang('sistema.trade_report.your_statement')</p>
        </div>   
        <table class="table_main_header m-b-15" style="font-size: 14px;">
            <tr>
                <td style="width: 60%;"><strong>{{ $primary_client->full_name }}</strong></td>
                <td style="width: 40%;">
                    <table class="internal">
                        <tr>
                            <td style="width: 150px;">@lang('sistema.trade_report.client_code')</td>
                            <td></td>
                            <td style="width: 50%;">{{ $data['account']->account_number }}</td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td style="width: 60%;">{{ $primary_client->address }}</td>
                <td style="width: 40%;">
                    <table class="internal">
                        <tr>
                            <td style="width: 150px;">@lang('sistema.trade_report.currency')</td>
                            <td></td>
                            <td style="width: 50%;">MXN (Mexican Peso)</td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td style="width: 60%;">{{ $primary_client->state_name? $primary_client->state_name->name : '' }}</td>
                <td style="width: 40%;">
                    <table class="internal">
                        <tr>
                            <td style="width: 150px;">@lang('sistema.trade_report.branch')</td>
                            <td></td>
                            <td style="width: 50%;">
                                {{ session('language') == 'es' ? $branch->branch_es : $branch->branch_en }}, {{ $branch->country_code }}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td style="width: 60%;">{{ $primary_client->city_name ? $primary_client->city_name->name : '' }} {{ $primary_client->zip_code ? ( ', ' .$primary_client->zip_code) : '' }}{{ $primary_client->country_name ? ( ' - ' . $primary_client->country_name->name ) : '' }}</td>                    
                <td style="width: 40%;">
                    <table class="internal">
                        <tr>
                            <td style="width: 150px;">
                                @lang('sistema.trade_report.your_balance')
                            </td>
                            <td></td>
                            <td style="50%">$<span id="balance_block">{{ number_format($final_balance, 2, '.', ',') }}</span> MXN</td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td style="width: 60%;">
                    <p></p>
                </td>
                <td style="width: 40%;">
                    <table class="internal">
                        <tr>
                            <td style="width: 140px;"><p></p></td>
                            <td></td>
                            <td style="width: 50%;">
                                @php
                                $html = "Name: $primary_client->full_name";
                                $html .= PHP_EOL;
                                $html .= "Address: $primary_client->address";
                                $html .= $primary_client->state_name? (' ' . $primary_client->state_name->name) : '';
                                $html .= $primary_client->city_name ? (' ' . $primary_client->city_name->name) : '';
                                $html .= $primary_client->zip_code ? ( ', ' .$primary_client->zip_code) : '';
                                $html .= $primary_client->country_name ? ( ' - ' . $primary_client->country_name->name ) : '';
                                $html .= PHP_EOL;
                                $html .= "Client code : " .  $data['account']->account_number;
                                $html .= PHP_EOL;
                                $html .= "Currency : MXN (Mexican Peso)";
                                $html .= PHP_EOL;
                                $html .= "Branch : " . (session('language') == 'es' ? $branch->branch_es : $branch->branch_en) . ', ' . ($branch->country_code);
                                $html .= PHP_EOL;
                                $html .= "Period : " . date('d/m/y', strtotime($data['info']['from_date'])) . ' to ' . date('d/m/y', strtotime($data['info']['upto_date']));
                                @endphp     
                                <div style="display: block;position: relative;text-align: right;">                                        
                                    <img style="position: absolute;top: 0;right: 0;left: 0;bottom: 0;" src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(125)->generate($html)) !!} ">
                                </div>                                    
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>            
        <div id="repeat_header">
            <div style="clear: both;"></div>
            <div class="m-b-15" style="">            
                <div style="padding: 5px 15px;">
                    <strong><p>{{ date('d M Y', strtotime($data['info']['from_date'])) }} @lang('sistema.trade_report.to') {{ date('d M Y', strtotime($data['info']['upto_date'])) }}</p></strong>
                </div>
                <div style="margin-top: 50px;">
                    <table class="table_primary_info" style="width: 100%;font-size: 12px;">
                        <tr>
                            <td style="border-bottom: 1.5px solid #ccc;">@lang('sistema.trade_report.account_name')</td>
                            <td style="text-align: center; border-bottom: 1.5px solid #ccc;">@lang('sistema.trade_report.product')</td>
                            <td style="text-align: center; border-bottom: 1.5px solid #ccc;">@lang('sistema.trade_report.client_code')</td>
                            <td style="text-align: center; border-bottom: 1.5px solid #ccc;">@lang('sistema.trade_report.sheet_number')</td>
                        </tr>
                        <tr>
                            <td style="text-transform: uppercase;">{{ $primary_client->full_name }}</td>
                            <td style="text-align: center; text-transform: uppercase;">{{ $data['account']->broker ? $data['account']->broker->broker : '-' }}</td>
                            <td style="text-align: center;">{{ $data['account']->account_number }}</td>
                            <td style="text-align: center;" class="page_counter"></td>
                        </tr>
                    </table>
                </div>
            </div>
            <div style="margin-top: 15px;">
                <div style="clear: both;"></div>
                <p style="padding: 5px; background: #ccc; text-align: center; color: #fff; font-weight: bold;">
                    @lang('sistema.trade_report.summary_block', ['name' => ($data['account']->broker ? $data['account']->broker->broker : '-')])                
                </p>
            </div>            
        </div>    
    </div>  
    <div style="clear: both;"></div>
    <div class="transaction_block" style="margin-top: 25px; margin-bottom: 35px">    
        <div style="clear: both;"></div>
        <table class="table_transactions" style="font-size: 9px;">
            <thead>
                <tr>
                    <th>@lang('sistema.trade_report.ticket')</th>
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
                    <!--<th>@lang('sistema.transaction.spread')</th>-->
                    <!--<th>@lang('sistema.transaction.financial_exhibition')</th>-->
                    <!--<th>@lang('sistema.transaction.commission_fee')%</th>-->
                    <th>@lang('sistema.transaction.stop_loss')</th>
                    <th>@lang('sistema.transaction.contracts')</th>
                    <th>@lang('sistema.transaction.facial_value')</th>
                    <th>@lang('sistema.transaction.warranty')</th>
                    <th>@lang('sistema.transaction.commission')</th>
                    <!--<th>@lang('sistema.transaction.gross_profit')</th>-->
                    <th>@lang('sistema.trade_report.net_result')</th>
                    <th>@lang('sistema.trade_report.balance')</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td colspan="19" style="text-align: left;">@lang('sistema.trade_report.opening_balance') @lang('sistema.trade_report.balance_forward'): {{ number_format($opening_balance, 2, '.', ',') }}</td>
                    <td style="text-align: right;">{{ number_format($opening_balance, 2, '.', ',') }}</td>
                </tr>
                @php
                $changing_balance = $opening_balance;
                @endphp
                @if(isset($data['transactions']) && count($data['transactions']) > 0)
                @foreach($data['transactions'] as $transaction)
                <tr>
                    <td>{{ $transaction->ticket }}</td>
                    <td>{{ session('language') == 'es' ? $transaction->transaction_type->type_es : $transaction->transaction_type->type_en }}</td>
                    <td>{{ session('language') == 'es' ? $transaction->instrument->instrument_es : $transaction->instrument->instrument_en }}</td>
                    <td>{{ session('language') == 'es' ? $transaction->item->item_es : $transaction->item->item_en }}</td>
                    <td>{{ $transaction->opening_date }}</td>
                    <td>{{ $transaction->opening_time }}</td>
                    <td style="text-align: right;">{{ number_format($transaction->opening_price,2) }}</td>
                    <td style="text-align: right;">{{ number_format($transaction->conversion_opening,2) }}</td>
                    <td>{{ $transaction->closing_date }}</td>
                    <td>{{ $transaction->closing_time }}</td>
                    <td style="text-align: right;">{{ number_format($transaction->closing_price,2) }}</td>
                    <td style="text-align: right;">{{ number_format($transaction->conversion_closing,2) }}</td>
                    <td>{{ $transaction->leverage->label }}</td>
                    <!--<td>{{ $transaction->spread }}</td>-->
                    <!--<td>{{ $transaction->financial_exhibition }}</td>-->
                    <!--<td>{{ $transaction->commission_fee->commission_fee }}</td>-->
                    <td style="text-align: right;">{{ number_format($transaction->stop_loss,2) }}</td>
                    <td>{{ $transaction->contracts }}</td>
                    <td style="text-align: right;">{{ number_format($transaction->facial_value,2) }}</td>
                    <td style="text-align: right;">{{ number_format($transaction->warranty,2) }}</td>
                    <td style="text-align: right;">{{ number_format($transaction->commission,2) }}</td>
                    <!--<td>{{ $transaction->gross_profit }}</td>-->
                    <td style="text-align: right;">{{ number_format($transaction->net_result,2) }}</td>
                    @php
                    $changing_balance = $changing_balance + ($transaction->net_result);
                    @endphp
                    <td style="text-align: right;">{{ number_format($changing_balance, 2, '.', ',') }}</td>
                </tr>
                @endforeach                    
                @endif
            </tbody>
        </table>
    </div>
    <div style="clear: both;"></div>        
    <div class="movement_block" style="margin-top: 25px;">    
        <div style="clear: both;"></div>
        <p style="padding: 5px;background: #ccc;text-align: center;color: #fff;font-weight: bold;">@lang('sistema.equity_report.equity')</p>
        <table class="table_movements" style="font-size: 9px;">
            <thead>
                <tr>
                    <th>ID</th>                        
                    <th>@lang('sistema.equity_report.deposits')</th>
                    <th>@lang('sistema.equity_report.withdrawals')</th>
                    <th>@lang('sistema.equity_report.credits')</th>
                    <th>@lang('sistema.equity_report.expenses')</th>
                    <th>@lang('sistema.equity_report.tr_comm')</th>
                    <th class="text-center">@lang('sistema.equity_report.profit_loss')</th>
                    <th class="text-center">@lang('sistema.equity_report.balances')</th>     
                </tr>
            </thead>
            <tbody>
                @if(isset($data['moment_report']) && count($data['moment_report']) > 0)
                @foreach($data['moment_report'] as $key => $moment_report)                    
                <tr>
                    <td>{{ $key + 1 }}</td>                        
                    <td>{{ $moment_report['deposits_amount'] }}</td>
                    <td>{{ $moment_report['withdrawals_amount'] }}</td>
                    <td>{{ $moment_report['credit_amount'] }}</td>
                    <td>{{ $moment_report['expenses_amount'] }}</td>
                    <td>{{ $moment_report['commission_amount'] }}</td>
                    <td>{{ $moment_report['profil_loss_amount'] }}</td>
                    <td>
                        @php
                        $total_plus = $moment_report['deposits_amount'] + $moment_report['credit_amount'];
                        $total_negative = $moment_report['withdrawals_amount'] + $moment_report['expenses_amount'] + $moment_report['commission_amount'];
                        $total_balance = $total_plus - $total_negative + $moment_report['profil_loss_amount'];    
                        @endphp
                        {{ $total_balance }}
                    </td>
                </tr>
                @endforeach
                @else
                <tr>
                    <td colspan="8">@lang('sistema.trade_report.no_data')</td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>
    <script>
        var final_balance = '{{ $changing_balance }}';
        let balance_block = document.getElementById("balance_block");
        balance_block.innerHTML = final_balance;
    </script>
</body>
</html>