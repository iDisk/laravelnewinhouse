@extends('layouts.main')
@section('customcss')
<link href="{{ url('assets/plugins/datatables/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ url('assets/plugins/datatables/buttons.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ url('assets/plugins/datatables/responsive.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ url('assets/plugins/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css"/>
<link href="{{ url('assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet" type="text/css"/>
<link href="{{ url('assets/plugins/bootstrap-daterangepicker/daterangepicker.css') }}" rel="stylesheet" type="text/css"/>
<link href="{{ url('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
<style>
    .doc_filter{
        width: 45%;
        float: right;
    }
    .toolbar3{
        display: inline-block;
        float: right;
        margin-right: 15px;
    }
    .toolbar3 label, .toolbar4 label{
        width: 100%;
        font-weight: normal;
    }
    .toolbar3 label select.form-control{
        width: 80%;
    }
    #transactions-table_filter{
        display: inline-block;
        float: right;
    }

    .toolbar3 label select.form-control{
        width: 65%;
        display: inline-block;
    }
    
    #table_history_report_filter{
        display: inline-block;
        float: right;
    }
</style>
<style>
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
    #reportrange{
        height: 30px;
    }
    .daterangepicker.dropdown-menu.opensleft.show-calendar{
        right: auto !important;
        left: 15% !important;
        z-index: 500;
    }  
    .select2.select2-container{
        width: 275px !important;
    }
    @media only screen and (max-width: 600px) {
        .select2.select2-container{
            width: 100% !important;
        }    
    } 
</style>
@endsection
@section('pagecontent')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">@lang('sistema.equity_report.history.label')</h4>
                <ol class="breadcrumb p-0 m-0">
                    <li>
                        <a href="javascript:void(0)">@lang('sistema.pie')</a>
                    </li>                    
                    <li class="active">
                        @lang('sistema.equity_report.history.label')
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
                    <div class="clearfix"></div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div style="display: inline-block;float: left;padding: 5px 0;margin-right: 5px;">
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
                                <label class="form-control-label" style="margin-top: 5px;line-height: 30px;">@lang('sistema.date'):
                                    <input class="form-control" style="width: 78%;float: right;" name="reportrange" id="reportrange" autocomplete="off"/>
                                </label>
                            </div>
                            <div style="display: inline-block;margin-right: 5px;">
                                <button id="btnSendStatement" style="margin: 5px 5px;" class="btn btn-default btn-sm" disabled>{{ __("sistema.trade_report.send_report_btn") }}</button>
                            </div>
                            
                            <div style="display: inline-block;float: right;">
                                <label class="custom_search_title" style="margin-top: 5px;">@lang('sistema.search'): &nbsp;<input name="custom_search" id="custom_search" type="text"/></label>
                            </div>                                                        
                        </div>                        
                    </div>                                        
                    <div class="clearfix"></div>
                    <div class="row">                        
                        <div class="table-responsive col-lg-12">
                            <table class="table table-striped table-bordered dt-responsive nowrap dataTable no-footer dtr-inline" id="table_history_report" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th class="text-center" style="padding: 10px; width: 100px;">
                                            @lang('sistema.equity_report.history.send_by_email')
                                        </th>
                                        <th>ID</th>
                                        <th>@lang('sistema.equity_report.account_number')</th>
                                        <th>@lang('sistema.equity_report.customer')</th>
                                        <th>@lang('sistema.equity_report.history.from_date')</th>
                                        <th>@lang('sistema.users_action')</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                        <form id="frmReenvioActivacion" method="post" action="{{ url('reporte/send-report') }}">
                            {{ csrf_field() }}
                            <input type="hidden" name="statementIdsStr" id="statementIdsStr"/>
                        </form>
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
<script type="text/javascript" src="{{ asset('assets/plugins/moment/moment-with-locales.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/plugins/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
<script type="text/javascript" src="{{ url('assets/plugins/select2/js/select2.min.js') }}"></script>
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
    //Aqui deben de ir las secciones adicionales
    var table_equity_report;
    $(function() {
        $(".select2").select2();
        //$('#reportrange span').html(moment().subtract(29, 'days').format('MMMM D, YYYY') + ' - ' + moment().format('MMMM D, YYYY'));
        $('#reportrange span').html(moment().subtract(1, 'month').startOf('month').format('MMMM D, YYYY') + ' - ' + moment().subtract(1, 'month').endOf('month').format('MMMM D, YYYY'));
        $('#reportrange').daterangepicker({
            orientation: 'auto top',
            format: 'DD/MM/YYYY',
            startDate: moment().subtract(1, 'month').startOf('month'),            
            endDate: moment().subtract(1, 'month').endOf('month'),
            minDate: '01/01/2018',
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
                table_equity_report.draw();
            });
            
        table_equity_report = $('#table_history_report').DataTable({
            processing: true,
            serverSide: true,
            order: [[1, 'desc']],
            type: 'GET',
            dom: 'l<"doc_filter"<"toolbar3">>rtip',
            ajax: {
                url: '{!! url("datatable/trade_report_history") !!}',
                data: function (d) {
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
                    d.start_date = $('#reportrange').data('daterangepicker').startDate.format('YYYY-MM-DD');
                    d.end_date = $('#reportrange').data('daterangepicker').endDate.format('YYYY-MM-DD');
                }
            },
            language:{
            @if (\Lang::locale() == 'es')
                url: '{{url("assets/plugins/datatables/json/Spanish.json")}}'
            @endif
            },
            "drawCallback": function(settings) {
                if(!$('body').find('#table_history_report .dataTables_empty').length)
                {
                    $("#btnSendStatement").prop('disabled', false);
                }
                else
                {
                    $("#btnSendStatement").prop('disabled', true);
                }
             },
            initComplete: function(){                
                /*
                let sendButtonHtml = '<button id="btnSendStatement" class="btn btn-warning btn-sm">'+ '{{ __("sistema.trade_report.send_report_btn") }}' +'</button>'
                $("div.toolbar3").html(sendButtonHtml);
                */
            },
            columns: [
                { data: null, render: function (data, type, row){
                        return '<input type="checkbox" class="checkboxCorreo" id="empleado-' + row.id
                                + '" name="empleado[' + row.id + ']" value="1" />';
                    }, orderable: false, searchable: false, class: 'noExport text-center'},
                { data: 'id', name: 'id' },
                { data: 'account_number', name: 'account_number' },
                { data: 'client_name', name: 'client_name' },
                { data: 'for_period', name: 'for_period' },
                { data: 'action', name: 'action', orderable:false, searchable:false, class: 'text-center' }
            ]
        });
    });
    
    jQuery('#checkAll').click(function (){
        var seleccionado = jQuery(this).is(':checked');
        var checkboxesEmpleados = jQuery('.checkboxCorreo');

        jQuery.each(checkboxesEmpleados, function (idx, val){
            if (seleccionado == true) {
                if (!jQuery(val).is(':checked')) {
                    jQuery(val).trigger('click');
                }
            } else {
                if (jQuery(val).is(':checked')) {
                    jQuery(val).trigger('click');
                }
            }
        });
    });    
    
    $('body').on('click', '#btnSendStatement', function(){
        var checkboxesEmpleados = $('.checkboxCorreo:checked');
        if (checkboxesEmpleados == undefined || checkboxesEmpleados.length <= 0) {
            swal('{{ __("sistema.warning") }}', '{{ __("sistema.statement_select") }}', 'warning');
            return false;
        }

        var statementStr = '';

        $.each(checkboxesEmpleados, function (idx, val){
            var partesIdCheckbox = $(val).attr('id').split('-');

            statementStr += partesIdCheckbox[partesIdCheckbox.length - 1] + ',';
        });
        
        swal({
            title: "{{ __('sistema.confirm') }}",
            text: "{{ __('sistema.email_confirm_msg') }}",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: '#DD6B55',
            confirmButtonText: "{{ __('sistema.client.yes') }}",
            cancelButtonText: "{{ __('sistema.btn_cancel') }}",
         }).then(
            function () { 
                $('#statementIdsStr').val(statementStr.substr(0, statementStr.length - 1));                
                $('#frmReenvioActivacion').trigger('submit');
            },
            function () { 
                return false; 
            }
        );       
 
        return false;
    });
               
    $('body').on('change', '.checkboxCorreo', function(){
        let total_checkboxes = $('body').find('.checkboxCorreo').length;
        let total_checkboxes_checked = $('body').find('.checkboxCorreo:checked').length;
        if($(this).is(':checked'))
        {
            $("#btnSendStatement").removeClass('btn-default').addClass('btn-warning');
        }
        else
        {
            if(total_checkboxes_checked == 0)
            {
                $("#btnSendStatement").removeClass('btn-warning').addClass('btn-default');
            }
        }
        if(total_checkboxes == total_checkboxes_checked)
        {
            $("#checkAll").prop('checked', true);
        }
        else
        {
            $("#checkAll").prop('checked', false);
        }        
    });
               
    function number_formatter(value, decimals)
    {
        let number_format = parseFloat(value).toFixed(decimals);
        let fixed = number_format.toLocaleString(undefined, { maximumSignificantDigits : decimals, minimumSignificantDigits: decimals });
        return String(fixed).replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }
    
    $('input[name=custom_search]').change(function(){
        table_equity_report.draw();
    });
    function reload_table()
    {
        table_equity_report.draw();
    }
</script>
@endsection