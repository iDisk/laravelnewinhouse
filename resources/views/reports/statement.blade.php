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
            
            .table_trade_investments {
                width: 100%;
            }
            .table_trade_investments th{
                background: #f7f5f5;
                font-weight: normal;
                text-align: center;
            }
            .table_trade_investments td{
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
            #block_main_statistics{
               margin-bottom: 60px;
            }
            #block_account_transactions{
                
            }
            #block_account_transactions2{
                page-break-after: always;
            }
            #block_trade_investments{
                page-break-before: always;
            }
            #block_movement_transactions{
                margin-bottom: 30px;
            }
        </style>
        <style>
            #block_main_statistics{
                display: block;
                width: 100%;
                font-family: "Titillium Web", sans-serif;
                font-size: 14px;
            }
            #block_main_statistics .content-page {
                width: 100%;
                display: block;
            }
            #block_main_statistics .content-page .content {
                padding: 0 30px 10px 30px;
                margin-top: 10px;
            }
            #block_main_statistics .container-fluid {
               width: 100%;
                padding-right: 15px;
                padding-left: 15px;
                margin-right: auto;
                margin-left: auto;
            }
            #block_main_statistics .col, .col-1, .col-10, .col-11, .col-12, .col-2, .col-3, .col-4, .col-5, .col-6, .col-7, .col-8, .col-9, .col-auto, .col-lg, .col-lg-1, .col-lg-10, .col-lg-11, .col-lg-12, .col-lg-2, .col-lg-3, .col-lg-4, .col-lg-5, .col-lg-6, .col-lg-7, .col-lg-8, .col-lg-9, .col-lg-auto, .col-md, .col-md-1, .col-md-10, .col-md-11, .col-md-12, .col-md-2, .col-md-3, .col-md-4, .col-md-5, .col-md-6, .col-md-7, .col-md-8, .col-md-9, .col-md-auto, .col-sm, .col-sm-1, .col-sm-10, .col-sm-11, .col-sm-12, .col-sm-2, .col-sm-3, .col-sm-4, .col-sm-5, .col-sm-6, .col-sm-7, .col-sm-8, .col-sm-9, .col-sm-auto, .col-xl, .col-xl-1, .col-xl-10, .col-xl-11, .col-xl-12, .col-xl-2, .col-xl-3, .col-xl-4, .col-xl-5, .col-xl-6, .col-xl-7, .col-xl-8, .col-xl-9, .col-xl-auto {
                position: relative;            
                min-height: 1px;
                padding-right: 15px;
                padding-left: 15px;
            }
            #block_main_statistics .row{
                display: block;
                margin-right: -15px;
                margin-left: -15px;
            }
            #block_main_statistics .m-b-15 {
                margin-bottom: 15px !important;
            }
            #block_main_statistics .card {
                position: relative;
                display: -ms-flexbox;
                display: flex;
                -ms-flex-direction: column;
                flex-direction: column;
                min-width: 0;
                word-wrap: break-word;
                background-color: #fff;
                background-clip: border-box;                
                border-radius: .25rem;
                border: 1px solid #2d2d2d;
                -webkit-box-shadow: none;
                box-shadow: none;
                margin-bottom: 30px;
                border-radius: 0;
            }
            
            #block_main_statistics .card .card-body {
                padding: 10px;
                flex: 1 1 auto;
            }
            
            #block_main_statistics .card .card-body p {
                line-height: 18px;
            }            
            
            #block_main_statistics .font-700 {
                font-weight: 700 !important;
            }

            #block_main_statistics .m-t-5 {
                margin-top: 5px !important;
            }

            #block_main_statistics .text-uppercase {
                text-transform: uppercase!important;
            }      

            #block_main_statistics .text-white {
                color: #ffffff !important;
            }            
            
            #block_main_statistics .text-custom-info {
                color: #8cd5dd !important;
            }            
            
            #block_main_statistics .m-b-0 {
                margin-bottom: 0 !important;
            }            
            
            #block_main_statistics .widget-box-three .bg-icon {
                height: 45px;
                width: 45px;
                text-align: center;
                border-radius: 50%;
                -moz-border-radius: 50%;
                background-clip: padding-box;
                margin-right: 30px;
            }       
            
            #block_main_statistics .widget-two-black {
                background-color: #2d2d2d;
                background: #2d2d2d;
            }            
            
            #block_main_statistics .float-left {
                float: left!important;
            }
            
            #block_main_statistics .bg-icon img{                
                vertical-align: middle;
                border-style: none;
            }
            
            #block_main_statistics .text-right {
                text-align: right!important;
            }
            
            #block_main_statistics .col-xl-6{
                display: inline-block;
                width: 46%;
                float: left;
            }
            #block_main_statistics .col-md-6{
                width: 46%;
                display: inline-block;
                float: left;
            }
                        
            #block_main_statistics .bottom_shadow{
                margin: 0 auto;
                display: block;
            }
            
            #block_main_statistics .text-muted {
                color: #98a6ad !important;
            }
            
            #block_main_statistics .m-b-20 {
                margin-bottom: 20px !important;
            }
            
            #block_main_statistics .m-0 {
                margin: 0 !important;
            }
            
            #block_main_statistics table {
                border-collapse: collapse;
            }
            
            #block_main_statistics .table {
                width: 100%;
                margin-bottom: 1rem;
                background-color: transparent;
                font-family: "Titillium Web", sans-serif;
                font-weight: 600;
            }
            
            #block_main_statistics .table, #block_main_statistics .table tr td, #block_main_statistics .table tr th{
                border: none !important;
            }
            
            #block_main_statistics .table td, #block_main_statistics .table th {
                padding: .25rem;
                vertical-align: top;
                border-top: 1px solid #dee2e6;
                font-family: "Titillium Web", sans-serif;
                font-weight: 600;
            }            
            #block_main_statistics .table-striped td {
                border: 1px solid #ffffff !important;
            }
            #block_main_statistics .cuenta_black.table-striped thead {
                /*border-top: 1px solid;*/
            }
            #block_main_statistics .cuenta_blue.table-striped thead {
                /*border-top: 1px solid;*/
            }
            #block_main_statistics .cuenta_black.table-striped th, #block_main_statistics .cuenta_black.table-striped td {
                border: none;
                vertical-align: middle;
            }
            
            #block_main_statistics .cuenta_blue.table-striped th, #block_main_statistics .cuenta_blue.table-striped td {
                border: none;
                vertical-align: middle;
            }
            
            #block_main_statistics .cuenta_black.table-striped tbody tr:nth-of-type(odd){
                background: #2d2d2d;
                color: #ffffff;
            }
            
            #block_main_statistics .cuenta_blue.table-striped tbody tr:nth-of-type(odd) {
                background: #8cd5dd;
            }
        </style>
    </head>
    <body>
        <div class="common_main_header">                    
            @php
            $total_summary = 0;
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
            $opening_balance = (isset($data['opening_balance_transactions']) && $data['opening_balance_transactions'] != null) ? $data['opening_balance_transactions'] : 0;
            $final_balance = (isset($data['saldo_transactions']) && $data['saldo_transactions'] != null) ? $data['saldo_transactions'] : 0;

            $movement_opening_balance = (isset($data['opening_balance_movements']) && $data['opening_balance_movements'] != null) ? $data['opening_balance_movements'] : 0;
            $movement_final_balance = (isset($data['saldo_movements']) && $data['saldo_movements'] != null) ? $data['saldo_movements'] : 0;
            
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
        </div>
        
        <div id="block_main_statistics">
            @php
            $changing_balance = $opening_balance;
            @endphp
            <div style="clear: both;"></div>
            <div class="repeat_header">                
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
            </div>
            <div style="clear: both;"></div>            
            <div class="content-page">
                <div class="content">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-xl-6 col-md-6">
                                <div class="card widget-box-three m-b-15">
                                    <div class="card-body" style="border: 1px solid black;">
                                        <div class="bg-icon float-left" style="padding: 5px 10px;">
                                            <img class="" src="{{ env('PHYSICAL_PATH') . '/assets/images/icons/chart_1.png' }}" alt="" title="clock.svg">
                                        </div>
                                        <div class="text-right">
                                            <p class="m-t-5 text-uppercase font-700">&nbsp;</p>
                                            <h2 class="m-b-0 text-custom-info font-700"><span data-plugin="counterup">{{ $data['account']->account_number }}</span></h2>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6 col-md-6">                                
                                <div class="card widget-box-three widget-two-black m-b-15" style="background: #2d2d2d;">
                                    <div class="card-body" style="background: #2d2d2d; border: 1px solid black;">
                                        <div class="bg-icon float-left" style="padding: 5px 10px;">
                                            <img class="" src="{{ env('PHYSICAL_PATH') . '/assets/images/icons/chart_2.png' }}" alt="" title="clock.svg">
                                        </div>
                                        <div class="text-right">
                                            <p class="m-t-5 text-uppercase font-700 text-white">@lang('frontsistema.home.active_financing')</p>
                                            @php
                                                $consolidated_balance = 0;

                                                if(isset($data['trade_tradeinvestment_movement']['1'])){
                                                    $consolidated_balance = $consolidated_balance + $data['trade_tradeinvestment_movement']['1'];
                                                }
                                                if(isset($data['trade_tradeinvestment_movement']['2'])){
                                                    $consolidated_balance = $consolidated_balance + $data['trade_tradeinvestment_movement']['2'];
                                                }
                                                if(isset($data['trade_tradeinvestment_movement']['3'])){
                                                    $consolidated_balance = $consolidated_balance + $data['trade_tradeinvestment_movement']['3'];
                                                }
                                                if(isset($data['trade_tradeinvestment_movement']['4'])){
                                                    $consolidated_balance = $consolidated_balance + $data['trade_tradeinvestment_movement']['4'];
                                                }
                                                if(isset($data['trade_tradeinvestment_movement']['5'])){
                                                    $consolidated_balance = $consolidated_balance + $data['trade_tradeinvestment_movement']['5'];
                                                }
                                            @endphp                                            
                                            <h2 class="m-b-0 text-custom-info font-700"><span data-plugin="counterup">{{ number_format($consolidated_balance, 2, '.', ',') }}</span></h2>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>  
                        <div style="clear: both;"></div>
                        <div class="row">
                            <div class="col-xl-6 col-md-6">
                                <div class="card11">
                                    <div class="card-body11">
                                        <p class="text-muted m-b-20"></p>
                                        <table class="table table-striped m-0 cuenta_blue">
                                            <thead>
                                                <tr>
                                                    <!--<th class="text-center" style="text-align: center;">@lang('frontsistema.home.account_number')</th>-->
                                                    <th style="text-align: center; font-size: 12px;">@lang('frontsistema.home.detail')</th>
                                                    <th style="text-align: right; font-size: 12px;">@lang('frontsistema.home.balance')</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td style="text-align: center; font-size: 12px;">@lang('frontsistema.home.transaction')</td>
                                                    <td style="text-align: right; font-size: 12px;">${{ number_format($data['trade_n_tradeinvestment_amt'], 2, '.', ',') }}</td>
                                                </tr>
                                                <tr>
                                                    <td style="text-align: center; font-size: 12px;">@lang('frontsistema.home.active_investment')</td>
                                                    <td style="text-align: right; font-size: 12px;">${{ number_format($data['financiamientos_activos_amt'], 2, '.', ',') }}</td>
                                                </tr>                                                
                                                <tr>
                                                    <td style="text-align: center; font-size: 12px;">@lang('frontsistema.home.deposits')</td>
                                                    <td style="text-align: right; font-size: 12px;">${{ (isset($data['movement_operation_type_amt']['1'])) ?  number_format($data['movement_operation_type_amt']['1'], 2, '.', ',') : number_format(0,2) }}</td>
                                                </tr>
                                                <tr>
                                                    <td style="text-align: center; font-size: 12px;">@lang('frontsistema.home.retreats')</td>
                                                    <td style="text-align: right; font-size: 12px;">${{ (isset($data['movement_operation_type_amt']['2'])) ?  number_format($data['movement_operation_type_amt']['2'], 2, '.', ',') : number_format(0,2) }}</td>
                                                </tr>
                                                <tr>
                                                    <td style="text-align: center; font-size: 12px;">@lang('frontsistema.home.commission_n_expenses')</td>
                                                    <td style="text-align: right; font-size: 12px;">
                                                    @php
                                                        $expenses = isset($data['movement_operation_type_amt']['4']) ?  $data['movement_operation_type_amt']['4'] : 0;
                                                        $commission = (isset($data['movement_operation_type_amt']['5'])) ?  $data['movement_operation_type_amt']['5'] : 0;
                                                    @endphp
                                                    ${{  number_format(($expenses + $commission), 2, '.', ',') }}
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6 col-md-6">
                                <div class="card11">
                                    <div class="card-body11">
                                        <p class="text-muted m-b-20"></p>
                                        <table class="table table-striped m-0 cuenta_black">
                                            <thead>
                                                <tr>                                                    
                                                    <th style="text-align: center; font-size: 12px;">@lang('frontsistema.home.detail')</th>
                                                    <th style="text-align: right; font-size: 12px;">@lang('frontsistema.home.balance')</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td style="text-align: center; font-size: 12px;">@lang('frontsistema.home.derivatives')</td>
                                                    <td style="text-align: right; font-size: 12px;">${{ (isset($data['trade_tradeinvestment_movement']['1'])) ?  number_format($data['trade_tradeinvestment_movement']['1'], 2, '.', ',') : 0.00 }}</td>
                                                </tr>
                                                <tr>
                                                    <td style="text-align: center; font-size: 12px;">@lang('frontsistema.home.investment_funds')</td>
                                                    <td style="text-align: right; font-size: 12px;">
                                                        ${{ (isset($data['trade_tradeinvestment_movement']['2'])) ?  number_format($data['trade_tradeinvestment_movement']['2'], 2, '.', ',') : 0.00 }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="text-align: center; font-size: 12px;">@lang('frontsistema.home.wealth_management')</td>
                                                    <td style="text-align: right; font-size: 12px;">${{ (isset($data['trade_tradeinvestment_movement']['3'])) ?  number_format($data['trade_tradeinvestment_movement']['3'], 2, '.', ',') : 0.00 }}</td>
                                                </tr>
                                                <tr>
                                                    <td style="text-align: center; font-size: 12px;">@lang('frontsistema.home.structured_products')</td>
                                                    <td style="text-align: right; font-size: 12px;">${{ (isset($data['trade_tradeinvestment_movement']['4'])) ?  number_format($data['trade_tradeinvestment_movement']['4'], 2, '.', ',') : 0.00 }}</td>
                                                </tr>
                                                <tr>
                                                    <td style="text-align: center; font-size: 12px;">@lang('frontsistema.home.mixed_portfolio')</td>
                                                    <td style="text-align: right; font-size: 12px;">${{ (isset($data['trade_tradeinvestment_movement']['5'])) ?  number_format($data['trade_tradeinvestment_movement']['5'], 2, '.', ',') : 0.00 }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <!-- end col -->
                        </div>
                    </div>
                </div>
            </div>
            <div style="clear: both;"></div>      
        </div>
        
        <!-- Account Transactions -->
        <div id="block_account_transactions">
            <div style="clear: both;"></div>
            <div class="repeat_header" style="display: none;">                
                <div class="m-b-15" style="">
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
            <div style="clear: both;"></div>
            <div class="first_transaction_block" style="margin-top: 25px; margin-bottom: 35px">
                <div style="clear: both;"></div>
                <table class="table_transactions" style="font-size: 9px;" cellpadding="0" cellspacing="0" border="0">
                    <thead>
                        <tr>
                            <td colspan="6" style="border-bottom: 1.5px solid #ccc; padding: 5px 15px; font-size: 12px; text-align: left;">@lang('sistema.trade_report.account_name')</td>
                            <td colspan="4" style="text-align: center; padding: 5px 15px; border-bottom: 1.5px solid #ccc; font-size: 12px;">@lang('sistema.trade_report.product')</td>
                            <td colspan="6" style="text-align: center; padding: 5px 15px; border-bottom: 1.5px solid #ccc; font-size: 12px;">@lang('sistema.trade_report.client_code')</td>
                            <td colspan="4" style="text-align: center; padding: 5px 15px; border-bottom: 1.5px solid #ccc; font-size: 12px;">@lang('sistema.trade_report.sheet_number')</td>
                        </tr>
                        <tr>
                            <td colspan="6" style="text-transform: uppercase; padding: 5px 15px; font-size: 12px; text-align: left;">{{ $primary_client->full_name }}</td>
                            <td colspan="4" style="text-align: center; padding: 5px 15px; text-transform: uppercase; font-size: 12px; ">{{ $data['account']->broker ? $data['account']->broker->broker : '-' }}</td>
                            <td colspan="6" style="text-align: center; padding: 5px 15px; font-size: 12px; ">{{ $data['account']->account_number }}</td>
                            <td colspan="4" style="text-align: center; padding: 5px 15px; font-size: 12px; " class="page_counter"></td>
                        </tr>
                        <tr>
                            <td colspan="20"><p style="padding: 5px; background: #ccc; text-align: center; color: #fff; font-weight: bold; font-size: 16px;">@lang('sistema.trade_report.summary_block', ['name' => ($data['account']->broker ? $data['account']->broker->broker : '-')])</p></td>
                        </tr>
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
                            <td style="text-align: right;">{{ number_format($opening_balance, 2, '.', ',') }} &nbsp;</td>
                        </tr>                
                        @if(isset($data['transactions']) && count($data['transactions']) > 0)
                        @php
                        $transactions_length = count($data['transactions']);
                        $extra_length = $transactions_length > 30 ? 30 : $transactions_length;
                        @endphp
                        @for($i=0;$i<$extra_length;$i++)                        
                        <tr>
                            <td style="border-right: 1px solid #ccc;">{{ $data['transactions'][$i]->ticket }}</td>                                
                            <td style="border-right: 1px solid #ccc;">{{ session('language') == 'es' ?  $data['transactions'][$i]->transaction_type->type_en : $data['transactions'][$i]->transaction_type->type_en }}</td>
                            <td style="border-right: 1px solid #ccc;">{{ session('language') == 'es' ?  str_limit($data['transactions'][$i]->instrument->instrument_es,8) : str_limit($data['transactions'][$i]->instrument->instrument_en,8) }}</td>
                            @if(isset($data['transactions'][$i]->item))
                            <td style="border-right: 1px solid #ccc;">{{ session('language') == 'es' ?  str_limit($data['transactions'][$i]->item->item_es, 8) : str_limit($data['transactions'][$i]->item->item_en, 8) }}</td>
                            @else
                            <td style="border-right: 1px solid #ccc;">-</td>
                            @endif                            
                            <td style="border-right: 1px solid #ccc;width: 40px;">{{ date('y-m-d',strtotime($data['transactions'][$i]->opening_date)) }}</td>
                            <td style="border-right: 1px solid #ccc;">{{ $data['transactions'][$i]->opening_time }}</td>
                            <td style="border-right: 1px solid #ccc; text-align: right;">{{ number_format($data['transactions'][$i]->opening_price,2) }} &nbsp;</td>
                            <td style="border-right: 1px solid #ccc; text-align: right;">{{ number_format($data['transactions'][$i]->conversion_opening,2) }} &nbsp;</td>
                            <td style="border-right: 1px solid #ccc;width: 40px;">{{ date('y-m-d',strtotime($data['transactions'][$i]->closing_date)) }}</td>
                            <td style="border-right: 1px solid #ccc;">{{ $data['transactions'][$i]->closing_time }}</td>
                            <td style="border-right: 1px solid #ccc; text-align: right;">{{ number_format($data['transactions'][$i]->closing_price,2) }} &nbsp;</td>
                            <td style="border-right: 1px solid #ccc; text-align: right;">{{ number_format($data['transactions'][$i]->conversion_closing,2) }} &nbsp;</td>
                            <td style="border-right: 1px solid #ccc; text-align: right; ">{{  $data['transactions'][$i]->leverage->label }} &nbsp;</td>                    
                            <td style="border-right: 1px solid #ccc; text-align: right;">{{ number_format($data['transactions'][$i]->stop_loss,2) }} &nbsp;</td>
                            <td style="border-right: 1px solid #ccc; text-align: right;">{{  $data['transactions'][$i]->contracts }} &nbsp;</td>
                            <td style="border-right: 1px solid #ccc; text-align: right;">{{ number_format($data['transactions'][$i]->facial_value,2) }} &nbsp;</td>
                            <td style="border-right: 1px solid #ccc; text-align: right;">{{ number_format($data['transactions'][$i]->warranty,2) }} &nbsp;</td>
                            <td style="border-right: 1px solid #ccc; text-align: right;">{{ number_format($data['transactions'][$i]->commission,2) }} &nbsp;</td>                    
                            <td style="border-right: 1px solid #ccc; text-align: right;">{{ number_format($data['transactions'][$i]->net_result,2) }} &nbsp;</td>
                            @php
                            $changing_balance = $changing_balance + ($data['transactions'][$i]->net_result);
                            @endphp
                            <td style="border-right: 1px solid #ccc; text-align: right;">{{ number_format($changing_balance, 2, '.', ',') }} &nbsp;</td>
                        </tr>
                        @endfor
                        @endif
                        @if(count($data['transactions']) < 30)
                        <tr>
                            <td style="border-right: 1px solid #ccc; border-top: 1px solid #ccc; line-height: 0.25;" colspan="20">&nbsp;</td>
                        </tr>
                        <tr>
                            <td style="border-right: 1px solid #ccc; text-align: right;" colspan="19"><b>Total:</b>  &nbsp;</td>
                            @php
                            $total_summary += $changing_balance;
                            @endphp
                            <td style="border-right: 1px solid #ccc; text-align: right;"><b>{{  number_format($changing_balance, 2, '.', ',') }}</b> &nbsp;</td>
                        </tr>
                        @endif
                    </tbody>            
                </table>
            </div>
        </div>
        
        @if(isset($data['transactions']) && count($data['transactions']) > 30)
        <div id="block_account_transactions2">
            <div style="clear: both;"></div>
            <div class="repeat_header" style="display: none;">                
                <div class="m-b-15" style="">
                    <div style="display: block;">
                        <table class="table_primary_info" style="width: 100%;font-size: 12px;">
                            <tr>
                                <td style="border-bottom: 1.5px solid #ccc; padding: 5px 15px; border-spacing: 0;">@lang('sistema.trade_report.account_name')</td>
                                <td style="text-align: center; border-bottom: 1.5px solid #ccc; padding: 5px 15px; border-spacing: 0;">@lang('sistema.trade_report.product')</td>
                                <td style="text-align: center; border-bottom: 1.5px solid #ccc; padding: 5px 15px; border-spacing: 0;">@lang('sistema.trade_report.client_code')</td>
                                <td style="text-align: center; border-bottom: 1.5px solid #ccc; padding: 5px 15px; border-spacing: 0;">@lang('sistema.trade_report.sheet_number')</td>
                            </tr>
                            <tr>
                                <td style="text-transform: uppercase; padding: 5px 15px; border-spacing: 0;">{{ $primary_client->full_name }}</td>
                                <td style="text-align: center; text-transform: uppercase; padding: 5px 15px; border-spacing: 0;">{{ $data['account']->broker ? $data['account']->broker->broker : '-' }}</td>
                                <td style="text-align: center; padding: 5px 15px; border-spacing: 0;">{{ $data['account']->account_number }}</td>
                                <td style="text-align: center; padding: 5px 15px; border-spacing: 0;" class="page_counter"></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div style="clear: both;"></div>
            <div class="first_transaction_block" style="margin-top: 25px; margin-bottom: 35px">
                <div style="clear: both;"></div>
                <table class="table_transactions" style="font-size: 9px;" cellpadding="0" cellspacing="0" border="0">
                    <thead>
                        <tr>
                            <td colspan="6" style="border-bottom: 1.5px solid #ccc; padding: 5px 15px; font-size: 12px; text-align: left;">@lang('sistema.trade_report.account_name')</td>
                            <td colspan="4" style="text-align: center; padding: 5px 15px; border-bottom: 1.5px solid #ccc; font-size: 12px;">@lang('sistema.trade_report.product')</td>
                            <td colspan="6" style="text-align: center; padding: 5px 15px; border-bottom: 1.5px solid #ccc; font-size: 12px;">@lang('sistema.trade_report.client_code')</td>
                            <td colspan="4" style="text-align: center; padding: 5px 15px; border-bottom: 1.5px solid #ccc; font-size: 12px;">@lang('sistema.trade_report.sheet_number')</td>
                        </tr>
                        <tr>
                            <td colspan="6" style="text-transform: uppercase; padding: 5px 15px; font-size: 12px; text-align: left;">{{ $primary_client->full_name }}</td>
                            <td colspan="4" style="text-align: center; padding: 5px 15px; text-transform: uppercase; font-size: 12px; ">{{ $data['account']->broker ? $data['account']->broker->broker : '-' }}</td>
                            <td colspan="6" style="text-align: center; padding: 5px 15px; font-size: 12px; ">{{ $data['account']->account_number }}</td>
                            <td colspan="4" style="text-align: center; padding: 5px 15px; font-size: 12px; " class="page_counter"></td>
                        </tr>
                        <tr>
                            <td colspan="20"><p style="padding: 5px; background: #ccc; text-align: center; color: #fff; font-weight: bold; font-size: 16px;">@lang('sistema.trade_report.summary_block', ['name' => ($data['account']->broker ? $data['account']->broker->broker : '-')])</p></td>
                        </tr>
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
                            <td style="text-align: right;">{{ number_format($changing_balance, 2, '.', ',') }} &nbsp;</td>
                        </tr>                                        
                        @php
                        $transactions_length = count($data['transactions']) - 30;
                        @endphp
                        @for($i=30;$i<$transactions_length;$i++)                        
                        <tr>
                            <td style="border-right: 1px solid #ccc;">{{ $data['transactions'][$i]->ticket }}</td>                                
                            <td style="border-right: 1px solid #ccc;">{{ session('language') == 'es' ?  $data['transactions'][$i]->transaction_type->type_en : $data['transactions'][$i]->transaction_type->type_en }}</td>
                            <td style="border-right: 1px solid #ccc;">{{ session('language') == 'es' ?  str_limit($data['transactions'][$i]->instrument->instrument_es,8) : str_limit($data['transactions'][$i]->instrument->instrument_en,8) }}</td>
                            @if(isset($data['transactions'][$i]->item))
                            <td style="border-right: 1px solid #ccc;">{{ session('language') == 'es' ?  str_limit($data['transactions'][$i]->item->item_es, 8) : str_limit($data['transactions'][$i]->item->item_en, 8) }}</td>
                            @else
                            <td style="border-right: 1px solid #ccc;">-</td>
                            @endif                            
                            <td style="border-right: 1px solid #ccc;width: 40px;">{{ date('y-m-d',strtotime($data['transactions'][$i]->opening_date)) }}</td>
                            <td style="border-right: 1px solid #ccc;">{{ $data['transactions'][$i]->opening_time }}</td>
                            <td style="border-right: 1px solid #ccc; text-align: right;">{{ number_format($data['transactions'][$i]->opening_price,2) }} &nbsp;</td>
                            <td style="border-right: 1px solid #ccc; text-align: right;">{{ number_format($data['transactions'][$i]->conversion_opening,2) }} &nbsp;</td>
                            <td style="border-right: 1px solid #ccc;width: 40px;">{{ date('y-m-d',strtotime($data['transactions'][$i]->closing_date)) }}</td>
                            <td style="border-right: 1px solid #ccc;">{{ $data['transactions'][$i]->closing_time }}</td>
                            <td style="border-right: 1px solid #ccc; text-align: right;">{{ number_format($data['transactions'][$i]->closing_price,2) }} &nbsp;</td>
                            <td style="border-right: 1px solid #ccc; text-align: right;">{{ number_format($data['transactions'][$i]->conversion_closing,2) }} &nbsp;</td>
                            <td style="border-right: 1px solid #ccc; text-align: right; ">{{  $data['transactions'][$i]->leverage->label }} &nbsp;</td>                    
                            <td style="border-right: 1px solid #ccc; text-align: right;">{{ number_format($data['transactions'][$i]->stop_loss,2) }} &nbsp;</td>
                            <td style="border-right: 1px solid #ccc; text-align: right;">{{  $data['transactions'][$i]->contracts }} &nbsp;</td>
                            <td style="border-right: 1px solid #ccc; text-align: right;">{{ number_format($data['transactions'][$i]->facial_value,2) }} &nbsp;</td>
                            <td style="border-right: 1px solid #ccc; text-align: right;">{{ number_format($data['transactions'][$i]->warranty,2) }} &nbsp;</td>
                            <td style="border-right: 1px solid #ccc; text-align: right;">{{ number_format($data['transactions'][$i]->commission,2) }} &nbsp;</td>                    
                            <td style="border-right: 1px solid #ccc; text-align: right;">{{ number_format($data['transactions'][$i]->net_result,2) }} &nbsp;</td>
                            @php
                            $changing_balance = $changing_balance + ($data['transactions'][$i]->net_result);
                            @endphp
                            <td style="border-right: 1px solid #ccc; text-align: right;">{{ number_format($changing_balance, 2, '.', ',') }} &nbsp;</td>
                        </tr>
                        @endfor
                        <tr>
                            <td style="border-right: 1px solid #ccc; border-top: 1px solid #ccc; line-height: 0.25;" colspan="20">&nbsp;</td>
                        </tr>
                        <tr>
                            <td style="border-right: 1px solid #ccc; text-align: right;" colspan="19"><b>Total:</b>  &nbsp;</td>
                            @php
                            $total_summary += $changing_balance;
                            @endphp
                            <td style="border-right: 1px solid #ccc; text-align: right;"><b>{{  number_format($changing_balance, 2, '.', ',') }}</b> &nbsp;</td>
                        </tr>
                    </tbody>            
                </table>
            </div>
        </div>
        @endif        
        
        <!-- Movement Transactions -->
        <div id="block_movement_transactions">
            @php
            $changing_movement_balance = $movement_opening_balance;         
            @endphp
            <div style="clear: both;"></div>
            <div class="repeat_header" style="display: none;">
                <div class="m-b-15">
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
                        @lang('sistema.movimientos_transaction.summary_block_movement', ['name' => ($data['account']->broker ? $data['account']->broker->broker : '-')])
                    </p>
                </div>
            </div>
            <div style="clear: both;"></div>
            <div class="movement_block" style="margin-top: 25px; margin-bottom: 35px">
                <div style="clear: both;"></div>
                <table class="table_movements" style="font-size: 9px;" cellpadding="0" cellspacing="0" border="0">
                    <thead>
                        <tr>
                            <td colspan="6" style="border-bottom: 1.5px solid #ccc; padding: 5px 15px; font-size: 12px; text-align: left;">@lang('sistema.trade_report.account_name')</td>
                            <td colspan="4" style="text-align: center; padding: 5px 15px; border-bottom: 1.5px solid #ccc; font-size: 12px;">@lang('sistema.trade_report.product')</td>
                            <td colspan="6" style="text-align: center; padding: 5px 15px; border-bottom: 1.5px solid #ccc; font-size: 12px;">@lang('sistema.trade_report.client_code')</td>
                            <td colspan="4" style="text-align: center; padding: 5px 15px; border-bottom: 1.5px solid #ccc; font-size: 12px;">@lang('sistema.trade_report.sheet_number')</td>
                        </tr>
                        <tr>
                            <td colspan="6" style="text-transform: uppercase; padding: 5px 15px; font-size: 12px; text-align: left;">{{ $primary_client->full_name }}</td>
                            <td colspan="4" style="text-align: center; padding: 5px 15px; text-transform: uppercase; font-size: 12px; ">{{ $data['account']->broker ? $data['account']->broker->broker : '-' }}</td>
                            <td colspan="6" style="text-align: center; padding: 5px 15px; font-size: 12px; ">{{ $data['account']->account_number }}</td>
                            <td colspan="4" style="text-align: center; padding: 5px 15px; font-size: 12px; " class="page_counter"></td>
                        </tr>
                        <tr>
                            <td colspan="20"><p style="padding: 5px; background: #ccc; text-align: center; color: #fff; font-weight: bold; font-size: 16px;">@lang('sistema.movimientos_transaction.summary_block_movement', ['name' => ($data['account']->broker ? $data['account']->broker->broker : '-')])</p></td>
                        </tr>
                        <tr style="margin-top: 25px;">
                            <th colspan="3" style="border-right: 1px solid #ccc;">@lang('sistema.movimientos_transaction.ticket')</th>
                            <th colspan="2" style="border-right: 1px solid #ccc;">@lang('sistema.movimientos_transaction.instrument')</th>
                            <th colspan="3" style="border-right: 1px solid #ccc;">@lang('sistema.movimientos_transaction.movimientos_descripcion')</th>
                            <th colspan="3" style="border-right: 1px solid #ccc;">@lang('sistema.movimientos_transaction.fecha_transaccion')</th>
                            <th colspan="3" style="border-right: 1px solid #ccc; text-align: center;">@lang('sistema.movimientos_transaction.category')</th>
                            <th colspan="3" style="border-right: 1px solid #ccc;">@lang('sistema.movimientos_transaction.monto')</th>
                            <th colspan="3">@lang('sistema.trade_report.balance')</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="17" style="text-align: left;border-right: 1px solid #ccc;"> &nbsp; @lang('sistema.trade_report.opening_balance') @lang('sistema.trade_report.balance_forward'): {{ number_format($movement_opening_balance, 2, '.', ',') }}</td>
                            <td colspan="3" style="text-align: right;border-right: 1px solid #ccc;">{{ number_format($movement_opening_balance, 2, '.', ',') }} &nbsp;</td>
                        </tr>
                        @if(isset($data['movement_transaction']) && count($data['movement_transaction']) > 0)
                        @php
                        $extra_length = count($data['movement_transaction']) > 40 ? 40 : count($data['movement_transaction']);
                        @endphp
                        @for($i=0;$i<$extra_length;$i++)
                        <tr>
                            <td colspan="3" style="border-right: 1px solid #ccc;">{{ $data['movement_transaction'][$i]['ticket'] }}</td>
                            <td colspan="2" style="border-right: 1px solid #ccc;">{{ $data['movement_transaction'][$i]['type_'.session('language')] }}</td>
                            <td colspan="3" style="border-right: 1px solid #ccc; text-align: left; padding-left: 5px;">{{ $data['movement_transaction'][$i]['movimientos_descripcion'] }}</td>
                            <td colspan="3" style="border-right: 1px solid #ccc;">{{ date("y-m-d", strtotime($data['movement_transaction'][$i]['fecha_transaccion'])) }}</td>
                            <td colspan="3" style="border-right: 1px solid #ccc; text-align: center;">{{ $data['movement_transaction'][$i]['operation_category'] == 0 ? __('sistema.movimientos_transaction.category_charge') : __('sistema.movimientos_transaction.category_abono') }} &nbsp;</td>
                            <td colspan="3" style="border-right: 1px solid #ccc; text-align: right;">{{ number_format($data['movement_transaction'][$i]['monto'],2,'.',',') }} &nbsp;</td>
                            @php
                            if($data['movement_transaction'][$i]['operation_category'] == 0)
                            {
                                $changing_movement_balance = $changing_movement_balance + (-$data['movement_transaction'][$i]['monto']);
                            }
                            if($data['movement_transaction'][$i]['operation_category'] == 1)
                            {
                                $changing_movement_balance = $changing_movement_balance + ($data['movement_transaction'][$i]['monto']);
                            }                            
                            @endphp
                            <td colspan="3" style="border-right: 1px solid #ccc; text-align: right;">{{ number_format($changing_movement_balance, 2, '.', ',') }} &nbsp;</td>
                        </tr>
                        @endfor
                        @endif
                        @if(count($data['movement_transaction']) < 40)
                        <tr>
                            <td style="border-right: 1px solid #ccc; border-top: 1px solid #ccc; line-height: 0.25;" colspan="20">&nbsp;</td>
                        </tr>
                        <tr>
                            <td style="border-right: 1px solid #ccc; text-align: right;" colspan="19"><b>Total:</b>  &nbsp;</td>
                            @php
                            $total_summary += $changing_movement_balance;
                            @endphp
                            <td style="border-right: 1px solid #ccc; text-align: right;" colspan="3"><b>{{  number_format($changing_movement_balance, 2, '.', ',') }}</b> &nbsp;</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>

        <div id="block_movement_transactions2">            
            @if(isset($data['movement_transaction']) && count($data['movement_transaction']) > 40)
            <div style="clear: both;"></div>
            <div class="movement_block" style="page-break-before: always; margin-bottom: 50px;display: block;">
                <div style="clear: both;"></div>
                <table class="table_movements" style="font-size: 9px;" cellpadding="0" cellspacing="0" border="0">
                    <thead>
                        <tr>
                            <td colspan="6" style="border-bottom: 1.5px solid #ccc; padding: 5px 15px; font-size: 12px; text-align: left;">@lang('sistema.trade_report.account_name')</td>
                            <td colspan="4" style="text-align: center; padding: 5px 15px; border-bottom: 1.5px solid #ccc; font-size: 12px;">@lang('sistema.trade_report.product')</td>
                            <td colspan="6" style="text-align: center; padding: 5px 15px; border-bottom: 1.5px solid #ccc; font-size: 12px;">@lang('sistema.trade_report.client_code')</td>
                            <td colspan="4" style="text-align: center; padding: 5px 15px; border-bottom: 1.5px solid #ccc; font-size: 12px;">@lang('sistema.trade_report.sheet_number')</td>
                        </tr>
                        <tr>
                            <td colspan="6" style="text-transform: uppercase; padding: 5px 15px; font-size: 12px; text-align: left;">{{ $primary_client->full_name }}</td>
                            <td colspan="4" style="text-align: center; padding: 5px 15px; text-transform: uppercase; font-size: 12px; ">{{ $data['account']->broker ? $data['account']->broker->broker : '-' }}</td>
                            <td colspan="6" style="text-align: center; padding: 5px 15px; font-size: 12px; ">{{ $data['account']->account_number }}</td>
                            <td colspan="4" style="text-align: center; padding: 5px 15px; font-size: 12px; " class="page_counter"></td>
                        </tr>
                        <tr>
                            <td colspan="20"><p style="padding: 5px; background: #ccc; text-align: center; color: #fff; font-weight: bold; font-size: 16px;">@lang('sistema.movimientos_transaction.summary_block_movement', ['name' => ($data['account']->broker ? $data['account']->broker->broker : '-')])</p></td>
                        </tr>
                        <tr style="margin-top: 25px;">
                            <th colspan="3" style="border-right: 1px solid #ccc;">@lang('sistema.movimientos_transaction.ticket')</th>
                            <th colspan="2" style="border-right: 1px solid #ccc;">@lang('sistema.movimientos_transaction.instrument')</th>
                            <th colspan="3" style="border-right: 1px solid #ccc;">@lang('sistema.movimientos_transaction.movimientos_descripcion')</th>
                            <th colspan="3" style="border-right: 1px solid #ccc;">@lang('sistema.movimientos_transaction.fecha_transaccion')</th>
                            <th colspan="3" style="border-right: 1px solid #ccc; text-align: center;">@lang('sistema.movimientos_transaction.category')</th>
                            <th colspan="3" style="border-right: 1px solid #ccc;">@lang('sistema.movimientos_transaction.monto')</th>
                            <th colspan="3">@lang('sistema.trade_report.balance')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @for($i=40;$i< count($data['movement_transaction']);$i++)
                        <tr>
                            <td colspan="3" style="border-right: 1px solid #ccc;">{{ $data['movement_transaction'][$i]['ticket'] }}</td>
                            <td colspan="2" style="border-right: 1px solid #ccc;">{{ $data['movement_transaction'][$i]['type_'.session('language')] }}</td>
                            <td colspan="3" style="border-right: 1px solid #ccc; text-align: left; padding-left: 5px;">{{ $data['movement_transaction'][$i]['movimientos_descripcion'] }}</td>
                            <td colspan="3" style="border-right: 1px solid #ccc;">{{ date("y-m-d", strtotime($data['movement_transaction'][$i]['fecha_transaccion'])) }}</td>
                            <td colspan="3" style="border-right: 1px solid #ccc; text-align: center;">{{ $data['movement_transaction'][$i]['operation_category'] == 0 ? __('sistema.movimientos_transaction.category_charge') : __('sistema.movimientos_transaction.category_abono') }} &nbsp;</td>
                            <td colspan="3" style="border-right: 1px solid #ccc; text-align: right;">{{ number_format($data['movement_transaction'][$i]['monto'],2,'.',',') }} &nbsp;</td>
                            @php
                            if($data['movement_transaction'][$i]['operation_category'] == 0)
                            {
                                $changing_movement_balance = $changing_movement_balance + (-$data['movement_transaction'][$i]['monto']);
                            }
                            if($data['movement_transaction'][$i]['operation_category'] == 1)
                            {
                                $changing_movement_balance = $changing_movement_balance + $data['movement_transaction'][$i]['monto'];
                            }
                            @endphp
                            <td colspan="3" style="border-right: 1px solid #ccc; text-align: right;">{{ number_format($changing_movement_balance, 2, '.', ',') }} &nbsp;</td>
                        </tr>
                        @endfor
                        <tr>
                            <td style="border-right: 1px solid #ccc; border-top: 1px solid #ccc; line-height: 0.25;" colspan="20">&nbsp;</td>
                        </tr>
                        <tr>
                            <td style="border-right: 1px solid #ccc; text-align: right;" colspan="17"><b>Total:</b>  &nbsp;</td>
                            @php
                            $total_summary += $changing_movement_balance;
                            @endphp
                            <td style="border-right: 1px solid #ccc; text-align: right;" colspan="3"><b>{{  number_format($changing_movement_balance, 2, '.', ',') }}</b> &nbsp;</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            @endif
        </div>
        
        <!-- Trade Investments -->
        <div id="block_trade_investments">
            <div style="clear: both;"></div>
            <table style="width: 100%;">
                <thead>
                    <tr>
                        <td>
                            <div class="repeat_header">
                                <div class="m-b-15">
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
                                        @lang('sistema.trade_investment.summary_block_trade_investment', ['name' => ($data['account']->broker ? $data['account']->broker->broker : '-')])
                                    </p>
                                </div>
                            </div>
                        </td>
                    </tr>
                </thead>
                <tbody>
                    @if(isset($data['trade_invest_count']) && $data['trade_invest_count'] > 0)
                    @foreach($data['trading_investments'] as $instrument_id => $trade_investments)
                    <tr>
                        <td>
                            <div style="margin-top: 15px;">
                                <div style="clear: both;"></div>
                                <p style="padding: 5px; background: #ccc; text-align: center; color: #fff; font-weight: bold;">
                                    @php
                                        $instrument_name = \App\Util\HelperUtil::get_instrument_name($instrument_id);
                                        $instrument_opening_balance = \App\Util\HelperUtil::get_investment_opening_balance($data['account']['id'], $data['info']['from_date'], $instrument_id);
                                    @endphp
                                    {{ $instrument_name }}
                                </p>
                            </div>
                            <table class="table_trade_investments" style="font-size: 9px; width: 100%;" cellpadding="0" cellspacing="0" border="0">
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
                                        <th style="border-right: 1px solid #ccc;">@lang('frontsistema.trade_investment.ticket')</th>
                                        <th style="border-right: 1px solid #ccc;">@lang('frontsistema.trade_investment.date')</th>
                                        <th style="border-right: 1px solid #ccc;">@lang('frontsistema.trade_investment.transaction')</th>
                                        <th style="border-right: 1px solid #ccc;">@lang('sistema.trade_investment.tipo')</th>
                                        <th style="border-right: 1px solid #ccc;">@lang('frontsistema.trade_investment.expiration')</th>                            
                                        <th style="border-right: 1px solid #ccc;">@lang('frontsistema.trade_investment.nav')</th>
                                        <th style="border-right: 1px solid #ccc;">@lang('frontsistema.trade_investment.risk')</th>
                                        <th style="border-right: 1px solid #ccc;">@lang('frontsistema.trade_investment.amount')</th>
                                        <th style="text-align: center;">@lang('frontsistema.trade_investment.unit_balance')</th>
                                    </tr>
                                </thead>
                                <tbody>                                         
                                    <tr>
                                        <td style="border-right: 1px solid #ccc; text-align: left;" colspan="8"> &nbsp; @lang('sistema.trade_report.opening_balance') @lang('sistema.trade_report.balance_forward'): {{ number_format($instrument_opening_balance, 2, '.', ',') }}</td>
                                        <td style="border-right: 1px solid #ccc; text-align: right;">{{ number_format($instrument_opening_balance, 2, '.', ',') }} &nbsp;</td>
                                    </tr>
                                    @foreach($trade_investments as $trade_investment)
                                    <tr>
                                        <td style="border-right: 1px solid #ccc;">{{ $trade_investment->ticket }}</td>
                                        <td style="border-right: 1px solid #ccc;">{{ $trade_investment->fecha }}</td>
                                        <td style="border-right: 1px solid #ccc; text-align: left;">&nbsp; {{ $trade_investment->transaction }}</td>
                                        <td style="border-right: 1px solid #ccc;">{{ ucfirst($trade_investment->tipo) }}</td>
                                        <td style="border-right: 1px solid #ccc;">{{ $trade_investment->fecha_vencimiento }}</td>
                                        <td style="border-right: 1px solid #ccc;">{{ ucfirst($trade_investment->nav) }}</td>
                                        <td style="border-right: 1px solid #ccc;">{{ ucfirst($trade_investment->riesgo) }}</td>
                                        <td style="border-right: 1px solid #ccc; text-align: right;">{{ $trade_investment->monto }} &nbsp;</td>
                                        @php
                                        if($trade_investment->tipo == 'cr')
                                        {
                                            $instrument_opening_balance = $instrument_opening_balance + $trade_investment->monto;
                                        }
                                        else
                                        {
                                            $instrument_opening_balance = $instrument_opening_balance - $trade_investment->monto;
                                        }
                                        @endphp
                                        <td style="border-right: 1px solid #ccc; text-align: right;">{{ number_format($instrument_opening_balance, 2, '.', ',') }} &nbsp;</td>
                                    </tr>
                                    @endforeach
                                    <tr>
                                        <td style="border-right: 1px solid #ccc; border-top: 1px solid #ccc; line-height: 0.25;" colspan="9">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td style="border-right: 1px solid #ccc; text-align: right;" colspan="8"><b>Total:</b>  &nbsp;</td>
                                        @php
                                        $total_summary += $instrument_opening_balance;
                                        @endphp
                                        <td style="border-right: 1px solid #ccc; text-align: right;"><b>{{  number_format($instrument_opening_balance, 2, '.', ',') }}</b> &nbsp;</td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    @endforeach
                    @else
                    <tr>
                        <td>
                            <table class="table_trade_investments" style="font-size: 9px; width: 100%;" cellpadding="0" cellspacing="0" border="0">
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
                                        <th style="border-right: 1px solid #ccc;">@lang('frontsistema.trade_investment.ticket')</th>
                                        <th style="border-right: 1px solid #ccc;">@lang('frontsistema.trade_investment.date')</th>
                                        <th style="border-right: 1px solid #ccc;">@lang('frontsistema.trade_investment.transaction')</th>
                                        <th style="border-right: 1px solid #ccc;">@lang('sistema.trade_investment.tipo')</th>
                                        <th style="border-right: 1px solid #ccc;">@lang('frontsistema.trade_investment.expiration')</th>                            
                                        <th style="border-right: 1px solid #ccc;">@lang('frontsistema.trade_investment.nav')</th>
                                        <th style="border-right: 1px solid #ccc;">@lang('frontsistema.trade_investment.risk')</th>
                                        <th style="border-right: 1px solid #ccc;">@lang('frontsistema.trade_investment.amount')</th>
                                        <th style="text-align: center;">@lang('frontsistema.trade_investment.unit_balance')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td style="border-right: 1px solid #ccc; text-align: left;" colspan="8"> &nbsp; @lang('sistema.trade_report.opening_balance') @lang('sistema.trade_report.balance_forward'): {{ number_format(0, 2, '.', ',') }}</td>
                                        <td style="border-right: 1px solid #ccc; text-align: right;">{{ number_format(0, 2, '.', ',') }} &nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td style="border-right: 1px solid #ccc; border-top: 1px solid #ccc; line-height: 0.25;" colspan="9">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td style="border-right: 1px solid #ccc; text-align: right;" colspan="8"><b>Total:</b>  &nbsp;</td>                                       
                                        <td style="border-right: 1px solid #ccc; text-align: right;"><b>{{  number_format(0, 2, '.', ',') }}</b> &nbsp;</td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    @endif
                </tbody>
            </table>
            <div style="clear: both;"></div>           
        </div>        
        <!-- OTHER BOTTOM SECTION -->

        <!-- Total summary -->
        <div>
            <table style="width: 100%;">
                <tr>
                    <td style="text-align: right;">
                        <b>Total : $ {{ number_format($total_summary, 2, '.', ',') }}</b>
                    </td>
                </tr>
            </table>
        </div>
        
        <div style="clear: both;"></div>
        <div id="terms_conditions_block" style="page-break-before: always;">
            <div class="repeat_header">
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
            {!! (session('language') == 'es' ? $data['settings']->disclaimer_es : $data['settings']->disclaimer_en) !!}
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