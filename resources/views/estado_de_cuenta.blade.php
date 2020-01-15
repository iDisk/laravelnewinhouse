@extends('layouts.front_vertical_menu')
@section('customcss')
<link href="{{ url('assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet" type="text/css"/>
<link href="{{ url('assets/plugins/bootstrap-daterangepicker/daterangepicker.css') }}" rel="stylesheet" type="text/css"/>

<style type="text/css">
    #first_section strong{
        font-weight: 600 !important;
    }
</style>

@endsection

@section('pagecontent')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">@lang('frontsistema.estado_de_cuenta.title')</h4>
                <div class="web_logo">
                    <img class="" src="{{ url('assets/images/logo_espacios.png')}}" alt="" height="50">
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
    <!-- end row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="form-group" id="inputtype">                
                <div class="radio">
                    <label for="optCr">
                        <input type="radio" class="tipo_statement" name="tipo" value="section_1" id="optCr" checked>
                        <span class="cr"><i class="cr-icon mdi mdi-checkbox-blank-circle"></i></span>
                        @lang('sistema.equity_report.show_statement_existings')
                    </label>                    
                    &nbsp;&nbsp;&nbsp;
                    <label for="optDr">
                        <input type="radio" class="tipo_statement" name="tipo" value="section_2" id="optDr">
                        <span class="cr"><i class="cr-icon mdi mdi-checkbox-blank-circle"></i></span>
                        @lang('sistema.equity_report.show_statement_custom')
                    </label>
                </div>                
            </div>
        </div>
    </div>
    <div class="row section_block" id="section_1">
        <div class="col-lg-12">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <td><strong>@lang('sistema.equity_report.history.from_date')</strong></td>
                        <td class="text-center"><strong>@lang('sistema.users_action')</strong></td>
                    </tr>
                </thead>
                <tbody>
                    @if(isset($statement_history) && count($statement_history) > 0)                
                    @foreach($statement_history as $statement)
                    <tr>
                        <td>{{ date('d/m/Y', strtotime($statement->from_period)) }} - {{ date('d/m/Y', strtotime($statement->upto_period)) }}</td>
                        <td class="text-center">
                            <a href="{{ url('user/estado_de_cuenta/trade/history/' . $statement->id) }}" class="btn btn-xs btn-success waves-effect waves-light"><i class="fa fa-download"></i> @lang('sistema.btn_download')</a>
                        </td>
                    </tr>
                    @endforeach

                    @else
                    <tr>
                        <td colspan="2" class="text-center">@lang('sistema.trade_report.no_data')</td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>

    <div id="section_2" class="section_block" style="display: none;">
        <form id="frmDownloadStatement" action="{{ url('user/estado_de_cuenta') }}" method="post">
            {{ csrf_field() }}
            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="account_id" class="font-700 font-11">@lang('frontsistema.estado_de_cuenta.account_number')</label>
                        <select class="form-control input-black" id="account_id" name="account_id">
                            @if(isset($client->accounts) && count($client->accounts) > 0)
                            @php
                            $accounts = $client->accounts;
                            @endphp
                            @foreach($accounts as $account)
                            <option value='{{ $account->id }}'>{{ $account->account_number }}</option>
                            @endforeach
                            @endif
                        </select>
                        <!--<input type="text" class="form-control input-black" id="inputnum_de_cuenta" placeholder="NÚM. DE CUENTA">-->
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="row">
<!--                        <div class="col-lg-2">
                            <br><label class="font-700 m-t-10">@lang('frontsistema.estado_de_cuenta.period'):</label>
                        </div>-->
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="from_date" class="font-700 font-11">{{ __('frontsistema.estado_de_cuenta.period') }}</label>
                                <input id="reportrange" value="" class="form-control input-black" />
                                <input type="hidden" name="from_date" id="from_date" value=""/>
                                <input type="hidden" name="upto_date" id="upto_date" value=""/>
                            </div>
                        </div>
                        
<!--                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="from_date" class="font-700 font-11">{{ __('frontsistema.estado_de_cuenta.from') }}</label>
                                <input type="text" class="form-control input-black" id="from_date" name="from_date" placeholder="{{ __('frontsistema.estado_de_cuenta.from') }}">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="upto_date" class="font-700 font-11">{{ __('frontsistema.estado_de_cuenta.upto') }}</label>
                                <input type="text" class="form-control input-black" id="upto_date" name="upto_date" placeholder="{{ __('frontsistema.estado_de_cuenta.upto') }}">
                            </div>
                        </div>-->
                        
                    </div>
                </div>
                <div class="col-lg-12">
                    <button type="button" class="btn btn-black waves-effect waves-light" id="btnDownloadStatementPdf"> <i class="mdi mdi-arrow-down m-r-5"></i> <span>{{ __('frontsistema.estado_de_cuenta.lbl_download_btn') }}</span> </button>
                </div>        
            </div>
        </form>
    </div>
    <!-- end row -->
</div> <!-- container-fluid -->
@endsection

@section('customjs')
<script type="text/javascript" src="{{ asset('assets/plugins/moment/moment-with-locales.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/plugins/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
<script type="text/javascript">
    /*
    $("#upto_date").datepicker({
        format: 'dd/mm/yyyy',
        endDate: '+0d',
        autoclose: true
    });

    $("#from_date").datepicker({
        format: 'dd/mm/yyyy',
        startDate: '-12m',
        endDate: '+0d',
        autoclose: true
    }).on('changeDate', function (selected) {
        var minDate = new Date(selected.date.valueOf());
        $('#upto_date').datepicker('setStartDate', minDate);
    });

    $('#from_date').datepicker('setDate', '-1m');

    $('#upto_date').datepicker('setDate', 'today');

    $('#upto_date').datepicker('setStartDate', $("#from_date").datepicker('getDate'));
    */

    $("#btnDownloadStatementPdf").click(function () {
        let account_selected = $("#account_id").val();
        let from_date = $('#reportrange').data('daterangepicker').startDate.format('DD/MM/YYYY');
        $("#from_date").val(from_date);
        //let from_date = $("#from_date").val();
        let upto_date = $('#reportrange').data('daterangepicker').endDate.format('DD/MM/YYYY');
        $("#upto_date").val(upto_date);
        //let upto_date = $("#upto_date").val();
        $("#frmDownloadStatement").submit();
        console.log(account_selected, ' <=> ', from_date, ' <=> ', upto_date);
    });
    
    $(".tipo_statement").change(function(){
        section_load();
    });
    
    function section_load()
    {
        let this_section = $(".tipo_statement:checked").val();
        $(".section_block").not($('#'+this_section)).hide();
        $("#" + this_section).show();
    }
    
    $(function(){
        //$('#reportrange span').html(moment().subtract(1, 'month').startOf('month').format('DD/MM/YYYY') + ' - ' + moment().subtract(1, 'month').endOf('month').format('DD/MM/YYYY'));
        $('#reportrange').daterangepicker({
            orientation: 'auto top',
            format: 'DD/MM/YYYY',
            startDate: moment().subtract(1, 'month').startOf('month'),            
            endDate: moment().subtract(1, 'month').endOf('month'),
            minDate: moment().subtract(6, 'month'),
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
                format: 'DD/MM/YYYY',
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
                format: 'DD/MM/YYYY',
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

            });
        section_load();
    });
</script>
@endsection