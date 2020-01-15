@extends('layouts.main')
@section('customcss')
<link href="{{ url('assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet" type="text/css"/>
<link href="{{ url('assets/plugins/bootstrap-daterangepicker/daterangepicker.css') }}" rel="stylesheet" type="text/css"/>
<link href="{{ url('assets/plugins/datatables/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ url('assets/plugins/datatables/buttons.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ url('assets/plugins/datatables/responsive.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ url('assets/plugins/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css"/>
<link href="{{ url('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
<style>
    .table_block .select2-container .select2-selection--single{
        height: 30px !important;
    }
    .table_block .select2-container--default .select2-selection--single .select2-selection__arrow{
        top: 2px;
    }
    .table_block .select2-container--default .select2-selection--single .select2-selection__rendered{
        font-weight: normal;
        font-size: 13px;
        line-height: 30px !important;
    }
    .table_block .select2-container .select2-selection--single, #custom_search{
        height: 30px !important;
    }     
</style>
<style>
    .select2-container--default .select2-selection--single .select2-selection__arrow{
        top: 7px
    }
</style>
@endsection
@section('pagecontent')
@php
if(session('language') == 'es')
{
    $months = [ 1 => 'Enero', 2 => 'Febrero', 3 => 'Marzo', 4 => 'Abril', 5 => 'Mayo', 6 => 'Junio', 7 => 'Julio', 8 => 'Agosto', 9 => 'Septiembre', 10 => 'Octubre', 11 => 'Noviembre', 12 => 'Diciembre'];
}
else
{
    $months = [ 1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April', 5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August', 9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December'];
}
@endphp

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">@lang('sistema.reports.trade_report_generate')</h4>
                <ol class="breadcrumb p-0 m-0">
                    <li>
                        <a href="{{ url('/') }}">@lang('sistema.pie')</a>
                    </li>
                    <li class="active">
                        @lang('sistema.reports.trade_report_generate')
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
                    <div class="col-lg-12">
                        <form action="{{ url('reporte/trade') }}" method="post" id="frmGenerateTradeReport">
                            {{ csrf_field() }}
                            <div class="col-lg-3" style="display: inline-block; float: left;">
                                 <div class="row">
                                    <div class="form-group col-lg-12">
                                        <label class="form-control-label">@lang('sistema.broker.broker'):</label>
                                        <select class="form-control select2" name="broker_select" id="broker_select">
                                            <option value="">@lang('sistema.all')</option>
                                            @if(isset($global_assigned_brokers) && count($global_assigned_brokers) > 0)
                                            @foreach($global_assigned_brokers as $broker)
                                            <option value="{{ $broker['id'] }}">{{ $broker['broker'] }}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>                                     
                            </div>
                            <div class="col-lg-4" style="display: inline-block; float: left;">
                                <div class="row">
                                    <div class="form-group col-lg-12">
                                        <label class="form-control-label">@lang('sistema.client.accounts'):</label>
                                        <select class="form-control select2" name="account_select" id="account_select">
                                            <option value="">@lang('sistema.select_account')</option>
                                            @if(isset($accounts) && count($accounts) > 0)
                                            @foreach($accounts as $account)
                                            @php
                                            $primary_account = $account->primary_client;
                                            @endphp
                                            <option value="{{ $account->id }}" {{ old('account_select') == $account->id ? 'selected' : '' }}>{{ $account->account_number }}{{ $account->primary_client ? ' - ' . $account->primary_client->full_name : '' }}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3" style="display: inline-block; float: left;">
                                <div class="form-group">
                                    <label class="form-control-label">@lang('sistema.date'):</label>
                                    <input class="form-control" value="" style="width: 100%;" name="reportrange" id="reportrange"/>
                                    <input type="hidden" name="from_date" id="from_date"/>
                                    <input type="hidden" name="upto_date" id="upto_date"/>
                                </div>
                            </div>
                            <div class="col-lg-2" style="display: inline-block; float: left;">
                                <div class="row">
                                    <div class="form-group col-lg-12">
                                        <label class="form-control-label">&nbsp;</label>
                                        <div>
                                            <button class="btn btn-primary" type="button" id="btnGenerateReport">@lang('sistema.btn_view')</button>
                                            <button class="btn btn-success" type="button" id="btnExportReport" disabled>@lang('sistema.generate')</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-lg-12">
                        <div id="table_block" style="padding-bottom: 25px;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div><!-- container -->
<footer class="footer">
    © {{ date('Y') }} @lang('sistema.pie')
</footer>
<div class="modal fade" id="sendReportModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">@lang('sistema.trade_report.send_report_lbl')</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <div id="send_form_block" style="max-height: 350px; overflow-y: scroll; overflow-x: hidden;padding: 15px;"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('sistema.btn_close')</button>
        <button type="button" class="btn btn-primary" id="btnSendEmailReport">@lang('sistema.btn_send')</button>
      </div>
    </div>
  </div>
</div>
@endsection
@section('customjs')
<script type="text/javascript" src="{{ asset('assets/plugins/moment/moment-with-locales.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/plugins/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
<script type="text/javascript" src="{{ url('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script type="text/javascript" src="{{ url('assets/plugins/datatables/dataTables.bootstrap4.min.js') }}"></script>
<script type="text/javascript" src="{{ url('assets/plugins/datatables/dataTables.keyTable.min.js') }}"></script>
<script type="text/javascript" src="{{ url('assets/plugins/datatables/dataTables.responsive.min.js') }}"></script>
<script type="text/javascript" src="{{ url('assets/plugins/datatables/responsive.bootstrap4.min.js') }}"></script>
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
    $(function() {
        $(".select2").select2();
        $('#reportrange span').html(moment().subtract(29, 'days').format('MMMM D, YYYY') + ' - ' + moment().format('MMMM D, YYYY'));
        $('#reportrange').daterangepicker({
            startDate: moment().subtract(29, 'days'),
            endDate: moment(),
            minDate: '01/01/2018',
            maxDate: moment(),
//            dateLimit: {
////                days: 60
//            },
            locale:'es',
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
            },
            function (start, end, label) {
                console.log('changed');
                $("#btnExportReport").prop('disabled', true);
                console.log(start.toISOString(), end.toISOString(), label);
                $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
            });
        });
        
        $("#btnExportReport").click(function(){
            let account_id = $("#account_select").val();
            if (account_id == '')
            {
                @if (session('language') == 'es')
                swal('Atención!', 'Por favor seleccione una cuenta!', 'warning');
                @endif
                @if (session('language') == 'en')
                swal('Attention!', 'Please select account first!', 'warning');
                @endif
                return false;
            }
            else
            {
                $('#from_date').val($('#reportrange').data('daterangepicker').startDate.format('YYYY-MM-DD'));
                $('#upto_date').val($('#reportrange').data('daterangepicker').endDate.format('YYYY-MM-DD'));
                $("#frmGenerateTradeReport").submit();
            }
        });
        
        $("#btnGenerateReport").click(function(){
            let account_id = $("#account_select").val();
            if (account_id == '')
            {
                @if (session('language') == 'es')
                swal('Atención!', 'Por favor seleccione una cuenta!', 'warning');
                @endif
                @if (session('language') == 'en')
                swal('Attention!', 'Please select account first!', 'warning');
                @endif
                return false;
            }
            else
            {
                show_loader(true);
                $('#from_date').val($('#reportrange').data('daterangepicker').startDate.format('YYYY-MM-DD'));
                $('#upto_date').val($('#reportrange').data('daterangepicker').endDate.format('YYYY-MM-DD'));
                $.ajax({
                    url: "{{ url('/reporte/generate-trade') }}",
                    method:'POST',
                    data: $("#frmGenerateTradeReport").serialize(),
                    success: function(response){
                        if (response.flag)
                        {
                            $("#table_block").html(response.data);
                            $('body').find('table.table_transactions').DataTable({
                                "language": {
                                    @if (\Lang::locale() == 'es')
                                    url: '{{url("assets/plugins/datatables/json/Spanish.json")}}',
                                    @endif
                                    "emptyTable": "{{ __('sistema.empty_table_movement') }}",
                                },
                                "dom": 'l<>frtip',
                                "order": [[ 1, 'asc' ]],
                                "columns": [
                                    { orderable:false },
                                    { orderable:false, "visible": false, },
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
                                ],
                                "drawCallback": function(settings) {
                                    let empty_table = $('body').find('table.table_transactions .dataTables_empty').length;
                                    if(empty_table)
                                    {
                                        $("#btnExportReport").prop('disabled', true);
                                    }
                                    else
                                    {
                                        $("#btnExportReport").prop('disabled', false);
                                    }
                                 },
                            });
                            show_loader(false);
                        }
                        else
                        {
                            show_loader(false);
                            @if (session('language') == 'es')
                            swal('Error!', response.message, 'error');
                            @endif
                            @if (session('language') == 'en')
                            swal('Error!', response.message, 'error');
                            @endif
                            
                        }
                    },
                    error: function(response){
                        show_loader(false);
                        @if (session('language') == 'es')
                            swal('Error!', response.responseJSON.message, 'error');
                        @endif
                        @if (session('language') == 'en')
                            swal('Error!', response.responseJSON.message, 'error');
                        @endif
                    }
                });
            }
        });
        
        $("#btnSendReport").click(function(){
            show_loader(true);
            $.ajax({
                url: "{{ url('/accounts') }}",
                method:'GET',
                success: function(response){
                    show_loader(false);
                    $("#sendReportModal").find("#send_form_block").html(response.data);
                    $("#sendReportModal").modal('show');
                },
                error: function(response){
                    show_loader(false);
                    @if (session('language') == 'es')
                        swal('Error!', response.responseJSON.message, 'error');
                    @endif
                    @if (session('language') == 'en')
                        swal('Error!', response.responseJSON.message, 'error');
                    @endif
                }
            });
        });
        
        $("#btnSendEmailReport").click(function(){
            let account_selected = $('body').find('#frmSendEmailReport input.account_selected:checkbox:checked').length;
            if(account_selected > 0)
            {
                show_loader(true);
                $.ajax({
                    url: "{{ url('reporte/send-report') }}",
                    method:'POST',
                    data: $('body').find('#frmSendEmailReport').serialize(),
                    success: function(response){
                        show_loader(false);
                        if(response.flag)
                        {
                            swal('{{ __("sistema.success") }}', response.message, 'success');
                            $("#sendReportModal").find("#send_form_block").trigger('reset');
                            $("#sendReportModal").modal('hide');
                        }
                        else
                        {
                            swal('Error!', response.message, 'error');
                        }
                    },
                    error: function(response){
                        show_loader(false);
                        @if (session('language') == 'es')
                            swal('Error!', response.responseJSON.message, 'error');
                        @endif
                        @if (session('language') == 'en')
                            swal('Error!', response.responseJSON.message, 'error');
                        @endif
                    }
                });
            }
            else
            {
                @if (session('language') == 'es')
                swal('Atención!', 'Por favor seleccione una cuenta!', 'warning');
                @endif
                @if (session('language') == 'en')
                swal('Attention!', 'Please select account first!', 'warning');
                @endif
                return false;
            }
            return false;
        });
        
        $("#account_select").change(function(){
           $("#btnExportReport").prop('disabled', true); 
        });
        
        function reload_table()
        {
            
        }
</script>
@endsection