@extends('layouts.front_vertical_menu')
@section('customcss')
<link href="{{ url('assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet" type="text/css"/>
<link href="{{ url('assets/plugins/bootstrap-daterangepicker/daterangepicker.css') }}" rel="stylesheet" type="text/css"/>

<style type="text/css">

    .cuenta_blue.table-striped tbody tr:nth-of-type(odd){
        background: #8cd5dd;
        
    }
    .cuenta_blue.table-striped tbody tr:nth-of-type(even) td{
        padding-bottom: .30rem;
        padding-left: 0px;
        padding-right: 0px;
        font-size: 12px;    
    }
    .cuenta_blue.table-striped thead{
        border-top:1px solid;
    }
    .cuenta_blue.table-striped th, .cuenta_blue.table-striped td{
        border: none;
        vertical-align: middle;
    }
    .cuenta_blue.table-striped a{
        margin-left: 10px;
        font-weight: 700;
        text-decoration: underline;
        color: #8cd5dd;
    }
    .cuenta_blue.table-striped hr{
        margin: .15rem 0 .25rem 0;
        border-top: 1px solid #2d2d2d;
    }


    .cuenta_black.table-striped tbody tr:nth-of-type(odd){
        background: #2d2d2d;
        color: #ffffff;
    }
    .cuenta_black.table-striped tbody tr:nth-of-type(even) td{
        padding-bottom: .30rem;
        padding-left: 0px;
        padding-right: 0px;
        font-size: 12px;    
    }
    .cuenta_black.table-striped thead{
        border-top:1px solid;
    }
    .cuenta_black.table-striped th, .cuenta_black.table-striped td{
        border: none;
        vertical-align: middle;
    }
    .cuenta_black.table-striped a{
        margin-left: 10px;
        font-weight: 700;
        text-decoration: underline;
        color: #8cd5dd;
    }
    .cuenta_black.table-striped hr{
        margin: .15rem 0 .25rem 0;
        border-top: 1px solid #2d2d2d;
    }

    .table-striped td{
        border: 1px solid #ffffff !important;
    }
</style>
@endsection

@section('pagecontent')
<div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <h4 class="page-title">@lang('frontsistema.home.welcome_txt')</h4>
                    <div class="web_logo">
                        <img class="" src="{{ url('assets/images/logo_espacios.png')}}" alt="" height="50">
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
        <!-- end row -->
        <div class="row">
            <div class="col-xl-6 col-md-6">
                <div class="card widget-box-three m-b-15">
                    <div class="card-body">
                        <div class="bg-icon121 float-left">
                            <p class="m-t-5 text-uppercase font-700"><br></p>
                            <h2 class="m-b-0 text-custom-info font-600 text-bl" style="font-size: 24px;"><span>@lang('frontsistema.home.account_number')</span></h2>
                        </div>
                        <div class="text-right">
                            <p class="m-t-5 text-uppercase font-700"><br></p>
                            <h2 class="m-b-0 text-custom-info font-700"><span>{{ $account->account_number }}</span></h2>
                        </div>
                    </div>
                </div>
                <div class="text-center m-b-15">
                    <img src="{{ url('assets/images/bottom_shadow.png')}}">
                </div>
            </div>
            <div class="col-xl-6 col-md-6">
                <div class="card widget-box-three widget-two-black m-b-15">
                    <div class="card-body">
                        <div class="bg-icon float-left">
                            <img class="" src="{{ url('assets/images/icons/chart_2.png')}} " alt="" title="clock.svg">
                        </div>
                        <div class="text-right">
                            <p class="m-t-5 text-uppercase font-700 text-white">@lang('frontsistema.home.consolidated_balance')</p>
                            @php
                                $consolidated_balance = 0;

                                if(isset($trade_tradeinvestment_movement['1'])){
                                    $consolidated_balance = $consolidated_balance + $trade_tradeinvestment_movement['1'];
                                }
                                if(isset($trade_tradeinvestment_movement['2'])){
                                    $consolidated_balance = $consolidated_balance + $trade_tradeinvestment_movement['2'];
                                }
                                if(isset($trade_tradeinvestment_movement['3'])){
                                    $consolidated_balance = $consolidated_balance + $trade_tradeinvestment_movement['3'];
                                }
                                if(isset($trade_tradeinvestment_movement['4'])){
                                    $consolidated_balance = $consolidated_balance + $trade_tradeinvestment_movement['4'];
                                }
                                if(isset($trade_tradeinvestment_movement['5'])){
                                    $consolidated_balance = $consolidated_balance + $trade_tradeinvestment_movement['5'];
                                }
                            @endphp
                            <h2 class="m-b-0 text-custom-info font-700">$<span data-plugin="counterup">{{ number_format($consolidated_balance,2,'.',',') }}</span></h2>
                        </div>
                    </div>
                </div>
                <div class="text-center m-b-15">
                    <img src="{{ url('assets/images/bottom_shadow.png')}}">
                </div>
            </div>
        </div>
        <!-- end row -->

        <div class="row">
            <div class="col-lg-6">
                <div class="card11">
                    <div class="card-body11">
                        <p class="text-muted m-b-20">
                        </p>

                        <table class="table table-striped m-0 cuenta_blue">
                            <thead>
                                <tr>
                                    <th class="text-center">@lang('frontsistema.home.by_category')</th>
                                    <th class="text-right">@lang('frontsistema.home.balance')</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="">@lang('frontsistema.home.transaction')</td>
                                    <td class="text-right">${{ number_format($trade_n_tradeinvestment_amt, 2, '.', ',') }}</td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="font-700">
                                        @lang('frontsistema.home.movement'):
                                        <a href="javascript:void(0);" class="open_by_date_form" data-type="trade_investment" data-id="0" data-title="@lang('frontsistema.home.transaction')">@lang('frontsistema.home.by_date')</a>
                                        <a href="{{ url('user/inicio/last_ten/trade_investment/0') }}" target="_blank">@lang('frontsistema.home.last_ten')</a>
                                        <a href="{{ url('user/estado_de_cuenta') }}" target="_blank">@lang('frontsistema.home.year_of_account')</a>
                                        <hr>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="">@lang('frontsistema.home.active_investment')</td>
                                    <td class="text-right">${{ number_format($financiamientos_activos_amt, 2, '.', ',') }}</td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="font-700">
                                        @lang('frontsistema.home.movement'):
                                        <a href="javascript:void(0);" class="open_by_date_form" data-type="mov" data-id="3_6" data-title="@lang('frontsistema.home.active_investment')">@lang('frontsistema.home.by_date')</a>
                                        <a href="{{ url('user/inicio/last_ten/mov/3_6') }}" target="_blank">@lang('frontsistema.home.last_ten')</a>
                                        <a href="{{ url('user/estado_de_cuenta') }}" target="_blank">@lang('frontsistema.home.year_of_account')</a>
                                        <hr>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="">@lang('frontsistema.home.deposits')</td>
                                    <td class="text-right">${{ (isset($movement_operation_type_amt['1'])) ?  number_format($movement_operation_type_amt['1'], 2, '.', ',') : 0.00 }}</td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="font-700">
                                        @lang('frontsistema.home.movement'):
                                        <a href="javascript:void(0);" class="open_by_date_form" data-type="mov" data-id="1" data-title="@lang('frontsistema.home.deposits')">@lang('frontsistema.home.by_date')</a>
                                        <a href="{{ url('user/inicio/last_ten/mov/1') }}" target="_blank">@lang('frontsistema.home.last_ten')</a>
                                        <a href="{{ url('user/estado_de_cuenta') }}" target="_blank">@lang('frontsistema.home.year_of_account')</a>
                                        <hr>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="">@lang('frontsistema.home.retreats')</td>
                                    <td class="text-right">${{ (isset($movement_operation_type_amt['2'])) ?  number_format($movement_operation_type_amt['2'], 2, '.', ',') : 0.00 }}</td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="font-700">
                                        @lang('frontsistema.home.movement'):
                                        <a href="javascript:void(0);" class="open_by_date_form" data-type="mov" data-id="2" data-title="@lang('frontsistema.home.retreats')">@lang('frontsistema.home.by_date')</a>
                                        <a href="{{ url('user/inicio/last_ten/mov/2') }}" target="_blank">@lang('frontsistema.home.last_ten')</a>
                                        <a href="{{ url('user/estado_de_cuenta') }}" target="_blank">@lang('frontsistema.home.year_of_account')</a>
                                        <hr>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="">@lang('frontsistema.home.commission_n_expenses')</td>
                                    <td class="text-right">
                                    @php
                                        $expenses = isset($movement_operation_type_amt['4']) ?  $movement_operation_type_amt['4'] : 0;
                                        $commission = (isset($movement_operation_type_amt['5'])) ?  $movement_operation_type_amt['5'] : 0;

                                    @endphp
                                    ${{  number_format(($expenses + $commission), 2, '.', ',') }}
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="font-700">
                                        @lang('frontsistema.home.movement'):
                                        <a href="javascript:void(0);" class="open_by_date_form" data-type="mov" data-id="4_5" data-title="@lang('frontsistema.home.commission_n_expenses')">@lang('frontsistema.home.by_date')</a>
                                        <a href="{{ url('user/inicio/last_ten/mov/4_5') }}" target="_blank">@lang('frontsistema.home.last_ten')</a> 
                                        <a href="{{ url('user/estado_de_cuenta') }}" target="_blank">@lang('frontsistema.home.year_of_account')</a>
                                        <hr>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- end col -->
            <div class="col-lg-6">
                <div class="card11">
                    <div class="card-body11">
                        <p class="text-muted m-b-20">
                        </p>

                        <table class="table table-striped m-0 cuenta_black">
                            <thead>
                                <tr>
                                    <th class="text-center">@lang('frontsistema.home.by_product')</th>
                                    <th class="text-right">@lang('frontsistema.home.balance')</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="">@lang('frontsistema.home.derivatives')</td>
                                    <td class="text-right">${{ (isset($trade_tradeinvestment_movement['1'])) ?  number_format($trade_tradeinvestment_movement['1'], 2, '.', ',') : 0.00 }}</td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="font-700">
                                        @lang('frontsistema.home.movement'):
                                        <a href="javascript:void(0);" class="open_by_date_form" data-type="trade" data-id="1" data-title="@lang('frontsistema.home.derivatives')">@lang('frontsistema.home.by_date')</a> 
                                        <a href="{{ url('user/inicio/last_ten/trade/1') }}" target="_blank">@lang('frontsistema.home.last_ten')</a> 
                                        <a href="{{ url('user/estado_de_cuenta') }}" target="_blank">@lang('frontsistema.home.year_of_account')</a>
                                        <hr>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="">@lang('frontsistema.home.investment_funds')</td>
                                    <td class="text-right">
                                        ${{ (isset($trade_tradeinvestment_movement['2'])) ?  number_format($trade_tradeinvestment_movement['2'], 2, '.', ',') : 0.00 }}
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="font-700">
                                        @lang('frontsistema.home.movement'):
                                        <a href="javascript:void(0);" class="open_by_date_form" data-type="trade" data-id="2" data-title="@lang('frontsistema.home.investment_funds')">@lang('frontsistema.home.by_date')</a>
                                        <a href="{{ url('user/inicio/last_ten/trade/2') }}" target="_blank">@lang('frontsistema.home.last_ten')</a>
                                        <a href="{{ url('user/estado_de_cuenta') }}" target="_blank">@lang('frontsistema.home.year_of_account')</a>
                                        <hr>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="">@lang('frontsistema.home.wealth_management')</td>
                                    <td class="text-right">${{ (isset($trade_tradeinvestment_movement['3'])) ?  number_format($trade_tradeinvestment_movement['3'], 2, '.', ',') : 0.00 }}</td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="font-700">
                                        @lang('frontsistema.home.movement'):
                                        <a href="javascript:void(0);" class="open_by_date_form" data-type="trade" data-id="3" data-title="@lang('frontsistema.home.wealth_management')">@lang('frontsistema.home.by_date')</a>
                                        <a href="{{ url('user/inicio/last_ten/trade/3') }}" target="_blank">@lang('frontsistema.home.last_ten')</a>
                                        <a href="{{ url('user/estado_de_cuenta') }}" target="_blank">@lang('frontsistema.home.year_of_account')</a>
                                        <hr>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="">@lang('frontsistema.home.structured_products')</td>
                                    <td class="text-right">${{ (isset($trade_tradeinvestment_movement['4'])) ?  number_format($trade_tradeinvestment_movement['4'], 2, '.', ',') : 0.00 }}</td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="font-700">
                                        @lang('frontsistema.home.movement'):
                                        <a href="javascript:void(0);" class="open_by_date_form" data-type="trade" data-id="4" data-title="@lang('frontsistema.home.structured_products')">@lang('frontsistema.home.by_date')</a>
                                        <a href="{{ url('user/inicio/last_ten/trade/4') }}" target="_blank">@lang('frontsistema.home.last_ten')</a>
                                        <a href="{{ url('user/estado_de_cuenta') }}" target="_blank">@lang('frontsistema.home.year_of_account')</a>
                                        <hr>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="">@lang('frontsistema.home.mixed_portfolio')</td>
                                    <td class="text-right">${{ (isset($trade_tradeinvestment_movement['5'])) ?  number_format($trade_tradeinvestment_movement['5'], 2, '.', ',') : 0.00 }}</td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="font-700">
                                        @lang('frontsistema.home.movement'):
                                        <a href="javascript:void(0);" class="open_by_date_form" data-type="trade" data-id="4" data-title="@lang('frontsistema.home.mixed_portfolio')">@lang('frontsistema.home.by_date')</a>
                                        <a href="{{ url('user/inicio/last_ten/trade/5') }}" target="_blank">@lang('frontsistema.home.last_ten')</a>
                                        <a href="{{ url('user/estado_de_cuenta') }}" target="_blank">@lang('frontsistema.home.year_of_account')</a>
                                        <hr>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
        </div>
        <!-- end row -->    
    </div> <!-- container-fluid -->


    <!-- by date popup -->
    <div id="by_date-close-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 id="by_dateForm_title" class="modal-title mt-0 page-title"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="bydateSearchForm">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="field-1" class="control-label font-600">@lang('frontsistema.home.by_date')</label>
                                    <input class="form-control input-black" name="reportrange" id="reportrange" placeholder="@lang('frontsistema.home.by_date')..." data-parsley-keyup="change" autocomplete="off"/>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <input type="hidden" id="by_dateType" value="">
                            <input type="hidden" id="by_dateID" value="">
                            <div class="col-md-12 col-12 text-right">
                                <div class="form-group m-0">
                                    <button type="submit" class="btn btn-black waves-effect waves-light">@lang('frontsistema.btn_view')</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div><!-- /.modal -->
    <!-- by date popup -->
@endsection

@section('customjs')
<script type="text/javascript" src="{{ asset('assets/plugins/moment/moment-with-locales.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/plugins/bootstrap-daterangepicker/daterangepicker.js') }}"></script>

<script type="text/javascript">

    $("body").on('click', '.open_by_date_form', function() {
        $('#by_dateForm_title').html($(this).data('title'));
        $('#by_dateType').val($(this).data('type'));
        $('#by_dateID').val($(this).data('id'));
        $("#by_date-close-modal").modal();
    });

    $(function() {

    $('#reportrange span').html(moment().subtract(1, 'month').startOf('month').format('MMMM D, YYYY') + ' - ' + moment().subtract(1, 'month').endOf('month').format('MMMM D, YYYY'));
        $('#reportrange').daterangepicker({
            orientation: 'auto top',
            format: 'DD-MM-YYYY',
            startDate: moment().subtract(1, 'month').startOf('month'),            
            endDate: moment().subtract(1, 'month').endOf('month'),
            minDate: '01-01-2018',
            maxDate: moment(),
            //dateLimit: {
            //    days: 60
            //},
            //locale:'es',
            showDropdowns: true,
            showWeekNumbers: true,
            timePicker: false,
            timePickerIncrement: 1,
            timePicker12Hour: true,
            @if (session('language') == 'es')
                ranges: {
                    'Hoy': [moment(), moment()],
                    'Ayer': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Últimos 7 días': [moment().subtract(6, 'days'), moment()],
                    'Últimos 30 días': [moment().subtract(29, 'days'), moment()],
                    'Este mes': [moment().startOf('month'), moment().endOf('month')],
                    'Anterior mes': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                },
            @endif
            @if (session('language') == 'en')
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                },
            @endif
            opens: 'left',
            drops: 'down',
            buttonClasses: ['btn', 'btn-sm'],
            applyClass: 'btn-success',
            cancelClass: 'btn-secondary',
            separator: ' to ',
            @if (session('language') == 'es')
                locale: {
                format: 'DD-MM-YYYY',
                applyLabel: 'Aplicar',
                cancelLabel: 'Cancelar',
                fromLabel: 'Desde',
                toLabel: 'A',
                customRangeLabel: 'Custom',
                daysOfWeek: ['Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sá', 'Do'],
                monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
                firstDay: 1
            }
            @endif
            @if (session('language') == 'en')
            locale: {
                format: 'DD-MM-YYYY',
                applyLabel: 'Submit',
                cancelLabel: 'Cancel',
                fromLabel: 'From',
                toLabel: 'To',
                customRangeLabel: 'Custom',
                daysOfWeek: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
                monthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                firstDay: 1
            }
            @endif
            }, function (start, end, label) {
                console.log(start,end,label);
                //table_equity_report.draw();
            });


        $('#bydateSearchForm').parsley().on('field:validated', function () {
            //console.log("form error");
        })
        .on('form:submit', function () {
            
            let start_date = $('#reportrange').data('daterangepicker').startDate.format('YYYY-MM-DD');
            let end_date = $('#reportrange').data('daterangepicker').endDate.format('YYYY-MM-DD');

            var type = $('#by_dateType').val();
            var investment_equity = $('#by_dateID').val();

            window.open("{{ url('user/inicio/record_bydate') }}/"+type+"/"+investment_equity+"/"+start_date+"/"+end_date+"", '_blank'); 

            //console.log(start_date,end_date);
            
            return false; // Don't submit form for this demo
        });
    });
</script>
@endsection