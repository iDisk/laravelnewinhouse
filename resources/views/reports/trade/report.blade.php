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
                padding: 2px 1px;
            }
            #tbl_movement_transactions th{
                background: #f7f5f5;
                font-weight: normal;
                text-align: center;
                font-size: 9px;
            }
            #tbl_movement_transactions td{
                text-align: center;
                padding: 2px 1px;
                font-size: 9px;
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
                /*counter-increment: section;*/
                /*content: counter(page) " of " counter(pages);*/

            }
            #header{
                /*position: fixed;*/                
                width: 100%;
                top: 0;
            }
            @page{
                margin: 20px 30px 10px 30px;
            }
            #main_header{
                position: fixed;
                top: 10px;
                height: 50px;
            }           
            #disclaimer_block{
                padding: 5px;
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
            <img style="height: 50px;" src="{{ env('PHYSICAL_PATH') . $data['settings']->company_statement_logo }}"/>              
            <div style="width: 250px; float: right;color: #ccc;font-size: 16px;">
                <span>@lang('sistema.trade_report.contact_tel') {{ $data['settings']->contact_number }}</span>
                <br/>
                <span>@lang('sistema.trade_report.see_reverse')</span>
            </div>
        </div>
        <div id="header" style="height: 25px;" class="m-b-15">
            <p style="margin: 0; float: right; font-size: 24px;color: {{ $data['settings']->statement_legend_color }};padding-right: 50px;">{{ $data['settings']->statement_legend }}</p>
        </div>
        <div style="width: 12%;display: inline-block;">
            <table>
                <tr>
                    <td>
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
                        $html .= "Branch : " . session('language') == 'es' ? $branch->branch_es : $branch->branch_en . ', ' . $branch->country_code;
                        $html .= PHP_EOL;
                        $html .= "Period : " . date('d/m/y', strtotime($data['info']['from_date'])) . ' to ' . date('d/m/y', strtotime($data['info']['upto_date']));
                        @endphp     
                        <div style="display: block;position: relative;text-align: right;">                                        
                            <img style="position: absolute;top: 0;right: 0;left: 0;bottom: 0;" src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(125)->generate($html)) !!} ">
                        </div>                                    
                    </td>
                </tr>
            </table>
        </div>
        <div style="width: 88%;display: inline-block;float: right;">
        <table class="table_main_header m-b-15" style="font-size: 14px;">
            <tr>
                <td style="width: 50%;"><strong>{{ $primary_client->full_name }}</strong></td>
                <td style="width: 50%;">
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
                <td style="width: 50%;">{{ $primary_client->address }}</td>
                <td style="width: 50%;">
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
                <td style="width: 50%;">{{ $primary_client->state_name? $primary_client->state_name->name : '' }}</td>
                <td style="width: 50%;">
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
                <td style="width: 50%;">{{ $primary_client->city_name ? $primary_client->city_name->name : '' }} {{ $primary_client->zip_code ? ( ', ' .$primary_client->zip_code) : '' }}{{ $primary_client->country_name ? ( ' - ' . $primary_client->country_name->name ) : '' }}</td>                    
                <td style="width: 50%;">
                    <table class="internal">
                        <tr>
                            <td style="width: 150px;">
                                <strong>@lang('sistema.trade_report.your_balance')</strong>
                            </td>
                            <td></td>
                            <td style="width: 50%"><strong>M$ {{ number_format($final_balance, 2, '.', ',') }}</strong></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>            
        </div>
        <div id="repeat_header">
            <div style="clear: both;"></div>
            <div class="m-b-15" style="">            
                <div style="padding: 5px 15px;margin-top: 15px;">
                    <strong><p>{{ date('d M Y', strtotime($data['info']['from_date'])) }} @lang('sistema.trade_report.to') {{ date('d M Y', strtotime($data['info']['upto_date'])) }}</p></strong>
                </div>
                <div style="display: block;">
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
        @php
            $changing_balance = $opening_balance;
        @endphp
        <div style="clear: both;"></div>
        <div class="transaction_block" style="margin-top: 25px; margin-bottom: 35px">    
            <div style="clear: both;"></div>
            <table class="table_transactions" style="font-size: 9px;" cellpadding="0" cellspacing="0" border="0">
                <thead>
                    <tr style="width: 100%;font-size: 12px;display: none;" class="hide_firstpage">
                        <td colspan="6" style="text-align: left;border-bottom: 1.5px solid #ccc; padding: 5px 15px; border-spacing: 0;">@lang('sistema.trade_report.account_name')</td>
                        <td colspan="4" style="text-align: center; border-bottom: 1.5px solid #ccc; padding: 5px 15px; border-spacing: 0;">@lang('sistema.trade_report.product')</td>
                        <td colspan="6" style="text-align: center; border-bottom: 1.5px solid #ccc; padding: 5px 15px; border-spacing: 0;">@lang('sistema.trade_report.client_code')</td>
                        <td colspan="4" style="text-align: center; border-bottom: 1.5px solid #ccc; padding: 5px 15px; border-spacing: 0;">@lang('sistema.trade_report.sheet_number')</td>
                    </tr>
                    <tr style="width: 100%;font-size: 12px;margin-bottom: 30px;display: none;"class="hide_firstpage2" >
                        <td colspan="6" style="text-align: left;text-transform: uppercase; padding: 5px 15px; border-spacing: 0;">{{ $primary_client->full_name }}</td>
                        <td colspan="4" style="text-align: center; text-transform: uppercase; padding: 5px 15px; border-spacing: 0;">{{ $data['account']->broker ? $data['account']->broker->broker : '-' }}</td>
                        <td colspan="6" style="text-align: center; padding: 5px 15px; border-spacing: 0;">{{ $data['account']->account_number }}</td>
                        <td colspan="4" style="text-align: center; padding: 5px 15px; border-spacing: 0;" class="page_counter"></td>
                    </tr>
                    <tr style="margin-top: 25px;">
                        <th style="border-right: 1px solid #ccc;">@lang('sistema.trade_report.ticket')</th>
                        <!--<th style="border-right: 1px solid #ccc;">@lang('sistema.trade_report.date')</th>-->
                        <th style="border-right: 1px solid #ccc;">@lang('sistema.trade_report.type')</th>
                        <th style="border-right: 1px solid #ccc;">@lang('sistema.transaction.instrument')</th>
                        <th style="border-right: 1px solid #ccc;">@lang('sistema.transaction.item')</th>
                        <th style="border-right: 1px solid #ccc;">@lang('sistema.transaction.opening_date')</th>
                        <th style="border-right: 1px solid #ccc;">@lang('sistema.trade_report.open_time')</th>
                        <th style="border-right: 1px solid #ccc;">@lang('sistema.trade_report.open_price')</th>
                        <th style="border-right: 1px solid #ccc;">@lang('sistema.trade_report.conversion_opening')</th>
                        <th style="border-right: 1px solid #ccc;">@lang('sistema.transaction.closing_date')</th>
                        <th style="border-right: 1px solid #ccc;">@lang('sistema.trade_report.close_time')</th>
                        <th style="border-right: 1px solid #ccc;">@lang('sistema.trade_report.close_price')</th>
                        <th style="border-right: 1px solid #ccc;">@lang('sistema.trade_report.conversion_closing')</th>
                        <th style="border-right: 1px solid #ccc;">@lang('sistema.trade_report.leverage')</th>
                        <th style="border-right: 1px solid #ccc;">@lang('sistema.transaction.stop_loss')</th>
                        <th style="border-right: 1px solid #ccc;">@lang('sistema.transaction.contracts')</th>
                        <th style="border-right: 1px solid #ccc;">@lang('sistema.transaction.facial_value')</th>
                        <th style="border-right: 1px solid #ccc;">@lang('sistema.transaction.warranty')</th>
                        <th style="border-right: 1px solid #ccc;">@lang('sistema.transaction.commission')</th>
                        <th style="border-right: 1px solid #ccc;">@lang('sistema.trade_report.net_result')</th>
                        <th>@lang('sistema.trade_report.balance')</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="19" style="text-align: left;border-right: 1px solid #ccc;">@lang('sistema.trade_report.opening_balance') @lang('sistema.trade_report.balance_forward'): {{ number_format($opening_balance, 2, '.', ',') }}</td>
                        <td style="text-align: center;">{{ number_format($opening_balance, 2, '.', ',') }}</td>
                    </tr>                
                    @if(isset($data['combos']) && count($data['combos']) > 0)
                    @php
                    $extra_length = count($data['combos']) > 15 ? 15 : count($data['combos']);                
                    @endphp
                    @for($i=0;$i<$extra_length;$i++)
                    <!---foreach($data['transactions'] as $transaction)-->
                    <tr>                    
                        @if($data['combos'][$i]['trs_type'] == 1)
                            <td style="border-right: 1px solid #ccc;">{{ $data['combos'][$i]->ticket }}</td>
                            <!--<td style="border-right: 1px solid #ccc;width: 40px;">{{ date("y-m-d", strtotime($data['combos'][$i]->created_at)) }}</td>-->
                            <td style="border-right: 1px solid #ccc;">{{ session('language') == 'es' ?  $data['combos'][$i]->transaction_type->type_en : $data['combos'][$i]->transaction_type->type_en }}</td>
                            <td style="border-right: 1px solid #ccc;">{{ session('language') == 'es' ?  str_limit($data['combos'][$i]->instrument->instrument_es,8) : str_limit($data['combos'][$i]->instrument->instrument_en,8) }}</td>
                            @if(isset($data['combos'][$i]->item))
                            <td style="border-right: 1px solid #ccc;">{{ session('language') == 'es' ?  str_limit($data['combos'][$i]->item->item_es, 8) : str_limit($data['combos'][$i]->item->item_en, 8) }}</td>
                            @else
                            <td style="border-right: 1px solid #ccc;">-</td>
                            @endif                            
                            <td style="border-right: 1px solid #ccc;width: 40px;">{{ date('y-m-d',strtotime($data['combos'][$i]->opening_date)) }}</td>
                            <td style="border-right: 1px solid #ccc;">{{ $data['combos'][$i]->opening_time }}</td>
                            <td style="border-right: 1px solid #ccc;">{{ number_format($data['combos'][$i]->opening_price,2) }}</td>
                            <td style="border-right: 1px solid #ccc;">{{ number_format($data['combos'][$i]->conversion_opening,2) }}</td>
                            <td style="border-right: 1px solid #ccc;width: 40px;">{{ date('y-m-d',strtotime($data['combos'][$i]->closing_date)) }}</td>
                            <td style="border-right: 1px solid #ccc;">{{ $data['combos'][$i]->closing_time }}</td>
                            <td style="border-right: 1px solid #ccc;">{{ number_format($data['combos'][$i]->closing_price,2) }}</td>
                            <td style="border-right: 1px solid #ccc;">{{ number_format($data['combos'][$i]->conversion_closing,2) }}</td>
                            <td style="border-right: 1px solid #ccc;">{{  $data['combos'][$i]->leverage->label }}</td>                    
                            <td style="border-right: 1px solid #ccc;">{{ number_format($data['combos'][$i]->stop_loss,2) }}</td>
                            <td style="border-right: 1px solid #ccc;">{{  $data['combos'][$i]->contracts }}</td>
                            <td style="border-right: 1px solid #ccc;">{{ number_format($data['combos'][$i]->facial_value,2) }}</td>
                            <td style="border-right: 1px solid #ccc;">{{ number_format($data['combos'][$i]->warranty,2) }}</td>
                            <td style="border-right: 1px solid #ccc;">{{ number_format($data['combos'][$i]->commission,2) }}</td>                    
                            <td style="border-right: 1px solid #ccc;">{{ number_format($data['combos'][$i]->net_result,2) }}</td>
                            @php
                            $changing_balance = $changing_balance + ($data['combos'][$i]->net_result);
                            @endphp
                            <td style="border-right: 1px solid #ccc;">{{ number_format($changing_balance, 2, '.', ',') }}</td>
                        @elseif($data['combos'][$i]['trs_type'] == 2)                        
                            <td style="text-align: center;border-right: 1px solid #ccc;">{{ '-' }}</td>
                            <td style="text-align: center;border-right: 1px solid #ccc;">{{ '-' }}</td>                            
                            <td style="border-right: 1px solid #ccc;">{{ $data['combos'][$i]['type_'.session('language')] }}</td>
                            <td style="border-right: 1px solid #ccc; text-align: left; padding-left: 5px;" colspan="2">{{ str_limit($data['combos'][$i]['movimientos_descripcion'], 8) }}</td>
                            <td style="border-right: 1px solid #ccc;">{{ date("y-m-d", strtotime($data['combos'][$i]['fecha_transaccion'])) }}</td>
                            <td style="border-right: 1px solid #ccc;" colspan="12"></td>
    <!--                        <td style="border-right: 1px solid #ccc;"></td>
                            <td style="border-right: 1px solid #ccc;"></td>
                            <td style="border-right: 1px solid #ccc;"></td>
                            <td style="border-right: 1px solid #ccc;"></td>
                            <td style="border-right: 1px solid #ccc;"></td>
                            <td style="border-right: 1px solid #ccc;"></td>
                            <td style="border-right: 1px solid #ccc;"></td>
                            <td style="border-right: 1px solid #ccc;"></td>
                            <td style="border-right: 1px solid #ccc;"></td>
                            <td style="border-right: 1px solid #ccc;"></td>
                            <td style="border-right: 1px solid #ccc;"></td>
                            <td style="border-right: 1px solid #ccc;"></td>
                            <td style="border-right: 1px solid #ccc;"></td>
                            <td style="border-right: 1px solid #ccc;"></td>-->
                            <td style="border-right: 1px solid #ccc;" style="text-align: right;">{{ number_format($data['combos'][$i]['monto'],2,'.',',') }}</td>
                            @php

                            if(in_array($data['combos'][$i]['type_en'], ['WITHDRAWAL', 'EXPENSE', 'COMISSION']))
                            {
                                $changing_balance = $changing_balance + (-$data['combos'][$i]['monto']);
                            }                        
                            elseif(in_array($data['combos'][$i]['type_en'], ['DEPOSIT', 'CREDIT', 'PROFIT/LOST']))
                            {
                                $changing_balance = $changing_balance + ($data['combos'][$i]['monto']);
                            }                        
                            @endphp
                            <td style="border-right: 1px solid #ccc;">{{ number_format($changing_balance, 2, '.', ',') }}</td>
                        @endif
                    </tr>
                    @endfor                    
                    @endif
                </tbody>            
            </table>
        </div>
        @if(isset($data['combos']) && count($data['combos']) > 15)
        <div style="clear: both;"></div>
        <div class="transaction_block" style="page-break-before: always; margin-bottom: 50px;display: block;">
            <div style="clear: both;"></div>
            <table class="table_transactions" style="font-size: 9px;" cellpadding="0" cellspacing="0" border="0">
                <thead>
                    <tr style="width: 100%;font-size: 12px;">
                        <td colspan="7" style="text-align: left;border-bottom: 1.5px solid #ccc; padding: 5px 15px; border-spacing: 0;">@lang('sistema.trade_report.account_name')</td>
                        <td colspan="4" style="text-align: center; border-bottom: 1.5px solid #ccc; padding: 5px 15px; border-spacing: 0;">@lang('sistema.trade_report.product')</td>
                        <td colspan="6" style="text-align: center; border-bottom: 1.5px solid #ccc; padding: 5px 15px; border-spacing: 0;">@lang('sistema.trade_report.client_code')</td>
                        <td colspan="4" style="text-align: center; border-bottom: 1.5px solid #ccc; padding: 5px 15px; border-spacing: 0;">@lang('sistema.trade_report.sheet_number')</td>
                    </tr>
                    <tr style="width: 100%;font-size: 12px;margin-bottom: 30px;" >
                        <td colspan="7" style="text-align: left;text-transform: uppercase; padding: 5px 15px; border-spacing: 0;">{{ $primary_client->full_name }}</td>
                        <td colspan="4" style="text-align: center; text-transform: uppercase; padding: 5px 15px; border-spacing: 0;">{{ $data['account']->broker ? $data['account']->broker->broker : '-' }}</td>
                        <td colspan="6" style="text-align: center; padding: 5px 15px; border-spacing: 0;">{{ $data['account']->account_number }}</td>
                        <td colspan="4" style="text-align: center; padding: 5px 15px; border-spacing: 0;" class="page_counter"></td>
                    </tr>
                    <tr style="margin-top: 25px;">
                        <th style="border-right: 1px solid #ccc;">@lang('sistema.trade_report.ticket')</th>
                        <!--<th style="border-right: 1px solid #ccc;">@lang('sistema.trade_report.date')</th>-->
                        <th style="border-right: 1px solid #ccc;">@lang('sistema.trade_report.type')</th>
                        <th style="border-right: 1px solid #ccc;">@lang('sistema.transaction.instrument')</th>
                        <th style="border-right: 1px solid #ccc;">@lang('sistema.transaction.item')</th>
                        <th style="border-right: 1px solid #ccc;">@lang('sistema.transaction.opening_date')</th>
                        <th style="border-right: 1px solid #ccc;">@lang('sistema.trade_report.open_time')</th>
                        <th style="border-right: 1px solid #ccc;">@lang('sistema.trade_report.open_price')</th>
                        <th style="border-right: 1px solid #ccc;">@lang('sistema.trade_report.conversion_opening')</th>
                        <th style="border-right: 1px solid #ccc;">@lang('sistema.transaction.closing_date')</th>
                        <th style="border-right: 1px solid #ccc;">@lang('sistema.trade_report.close_time')</th>
                        <th style="border-right: 1px solid #ccc;">@lang('sistema.trade_report.close_price')</th>
                        <th style="border-right: 1px solid #ccc;">@lang('sistema.trade_report.conversion_closing')</th>
                        <th style="border-right: 1px solid #ccc;">@lang('sistema.trade_report.leverage')</th>
                        <th style="border-right: 1px solid #ccc;">@lang('sistema.transaction.stop_loss')</th>
                        <th style="border-right: 1px solid #ccc;">@lang('sistema.transaction.contracts')</th>
                        <th style="border-right: 1px solid #ccc;">@lang('sistema.transaction.facial_value')</th>
                        <th style="border-right: 1px solid #ccc;">@lang('sistema.transaction.warranty')</th>
                        <th style="border-right: 1px solid #ccc;">@lang('sistema.transaction.commission')</th>
                        <th style="border-right: 1px solid #ccc;">@lang('sistema.trade_report.net_result')</th>
                        <th>@lang('sistema.trade_report.balance')</th>
                    </tr>
                </thead>
                <tbody>
                    @for($i=15;$i< count($data['combos']);$i++)
                    <!---foreach($data['transactions'] as $transaction)-->
                    <tr>
                        @if($data['combos'][$i]['trs_type'] == 1)
                        <td style="border-right: 1px solid #ccc;">{{ $data['combos'][$i]->ticket }}</td>
                        <!--<td style="border-right: 1px solid #ccc;width: 40px;">{{ date("y-m-d", strtotime($data['combos'][$i]->created_at)) }}</td>-->
                        <td style="border-right: 1px solid #ccc;">{{ session('language') == 'es' ?  $data['combos'][$i]->transaction_type->type_en : $data['combos'][$i]->transaction_type->type_en }}</td>
                        <td style="border-right: 1px solid #ccc;">{{ session('language') == 'es' ?  str_limit($data['combos'][$i]->instrument->instrument_es,8) : str_limit($data['combos'][$i]->instrument->instrument_en,8) }}</td>
                        @if(isset($data['combos'][$i]->item))
                        <td style="border-right: 1px solid #ccc;">{{ session('language') == 'es' ?  str_limit($data['combos'][$i]->item->item_es, 8) : str_limit($data['combos'][$i]->item->item_en, 8) }}</td>
                        @else
                        <td style="border-right: 1px solid #ccc;">-</td>
                        @endif                        
                        <td style="border-right: 1px solid #ccc;width: 40px;">{{ date('y-m-d',strtotime($data['combos'][$i]->opening_date)) }}</td>
                        <td style="border-right: 1px solid #ccc;">{{ $data['combos'][$i]->opening_time }}</td>
                        <td style="border-right: 1px solid #ccc;">{{ number_format($data['combos'][$i]->opening_price,2) }}</td>
                        <td style="border-right: 1px solid #ccc;">{{ number_format($data['combos'][$i]->conversion_opening,2) }}</td>
                        <td style="border-right: 1px solid #ccc;width: 40px;">{{ date('y-m-d',strtotime($data['combos'][$i]->closing_date)) }}</td>
                        <td style="border-right: 1px solid #ccc;">{{ $data['combos'][$i]->closing_time }}</td>
                        <td style="border-right: 1px solid #ccc;">{{ number_format($data['combos'][$i]->closing_price,2) }}</td>
                        <td style="border-right: 1px solid #ccc;">{{ number_format($data['combos'][$i]->conversion_closing,2) }}</td>
                        <td style="border-right: 1px solid #ccc;">{{  $data['combos'][$i]->leverage->label }}</td>                    
                        <td style="border-right: 1px solid #ccc;">{{ number_format($data['combos'][$i]->stop_loss,2) }}</td>
                        <td style="border-right: 1px solid #ccc;">{{  $data['combos'][$i]->contracts }}</td>
                        <td style="border-right: 1px solid #ccc;">{{ number_format($data['combos'][$i]->facial_value,2) }}</td>
                        <td style="border-right: 1px solid #ccc;">{{ number_format($data['combos'][$i]->warranty,2) }}</td>
                        <td style="border-right: 1px solid #ccc;">{{ number_format($data['combos'][$i]->commission,2) }}</td>                    
                        <td style="border-right: 1px solid #ccc;">{{ number_format($data['combos'][$i]->net_result,2) }}</td>
                        @php
                        $changing_balance = $changing_balance + ($data['combos'][$i]->net_result);
                        @endphp
                        <td style="border-right: 1px solid #ccc;">{{ number_format($changing_balance, 2, '.', ',') }}</td>
                        @elseif($data['combos'][$i]['trs_type'] == 2)
                        <td style="text-align: center;border-right: 1px solid #ccc;">{{ '-' }}</td>
                        <td style="text-align: center;border-right: 1px solid #ccc;">{{ '-' }}</td>                        
                        <td style="border-right: 1px solid #ccc;">{{ $data['combos'][$i]['type_'.session('language')] }}</td>
                        <td style="border-right: 1px solid #ccc; text-align: left; padding-left: 5px;" colspan="2">{{ str_limit($data['combos'][$i]['movimientos_descripcion'], 8) }}</td>
                        <td style="border-right: 1px solid #ccc;">{{ date("y-m-d", strtotime($data['combos'][$i]['fecha_transaccion'])) }}</td>   
                        <td style="border-right: 1px solid #ccc;" colspan="12"></td>
    <!--                    <td style="border-right: 1px solid #ccc;"></td>
                        <td style="border-right: 1px solid #ccc;"></td>
                        <td style="border-right: 1px solid #ccc;"></td>
                        <td style="border-right: 1px solid #ccc;"></td>
                        <td style="border-right: 1px solid #ccc;"></td>
                        <td style="border-right: 1px solid #ccc;"></td>
                        <td style="border-right: 1px solid #ccc;"></td>
                        <td style="border-right: 1px solid #ccc;"></td>
                        <td style="border-right: 1px solid #ccc;"></td>
                        <td style="border-right: 1px solid #ccc;"></td>
                        <td style="border-right: 1px solid #ccc;"></td>
                        <td style="border-right: 1px solid #ccc;"></td>
                        <td style="border-right: 1px solid #ccc;"></td>
                        <td style="border-right: 1px solid #ccc;"></td>-->
                        <td style="border-right: 1px solid #ccc;" style="text-align: right;">{{ number_format($data['combos'][$i]['monto'],2,'.',',') }}</td>
                        @php

                        if(in_array($data['combos'][$i]['type_en'], ['WITHDRAWAL', 'EXPENSE', 'COMISSION']))
                        {
                            $changing_balance = $changing_balance + (-$data['combos'][$i]['monto']);
                        }                        
                        elseif(in_array($data['combos'][$i]['type_en'], ['DEPOSIT', 'CREDIT', 'PROFIT/LOST']))
                        {
                            $changing_balance = $changing_balance + ($data['combos'][$i]['monto']);
                        }
                        @endphp
                        <td style="border-right: 1px solid #ccc;">{{ number_format($changing_balance, 2, '.', ',') }}</td>
                        @endif
                    </tr>
                    @endfor
                </tbody>            
            </table>       
        </div>
        @endif
        <div style="clear: both;"></div>
        <div id="terms_conditions_block" style="page-break-before: always;">
            <div id="repeat_header">
                <div style="clear: both;"></div>                
                <div style="display: block;">
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
        </div>
        <div id="disclaimer_block">
            {!! $data['settings']->disclaimer !!}
        </div>
        <script>
            var final_balance = '{{ $changing_balance }}';
            let balance_block = document.getElementById("balance_block");
            balance_block.innerHTML = final_balance;
        </script>
        <script type="text/php">
            if ( isset($pdf) ) { 
                $pdf->page_script('
                    if ($PAGE_COUNT > 1) {
                        for($i=1;$i<=$PAGE_COUNT;$i++)
                        {
                            if($PAGE_NUM == 1 || $PAGE_NUM == $PAGE_COUNT)
                            {
                                $font = $fontMetrics->get_font("sans-serif", "normal");
                                $size = 9;
                                $pageText = $PAGE_NUM . " of " . ($PAGE_COUNT);
                                $y = $PAGE_NUM == 1 ? 278 : 98;
                                $x = 715;
                                $pdf->text($x, $y, $pageText, $font, $size);
                            }
                            /*
                            else if(($PAGE_NUM == ($PAGE_COUNT - 1)))
                            {
                                $font = $fontMetrics->get_font("sans-serif", "normal");
                                $size = 9;
                                $pageText = $PAGE_NUM . " of " . ($PAGE_COUNT);
                                $y = 120;
                                $x = 715;
                                $pdf->text($x, $y, $pageText, $font, $size);
                            }
                            */
                            else if($PAGE_NUM <= $PAGE_COUNT)
                            {
                                $font = $fontMetrics->get_font("sans-serif", "normal");
                                $size = 9;
                                $pageText = $PAGE_NUM . " of " . $PAGE_COUNT;
                                $y = 98;
                                $x = 720;
                                $pdf->text($x, $y, $pageText, $font, $size);                            
                            }
                        }
                    }
                ');
            }
        </script>
    </body>
</html>