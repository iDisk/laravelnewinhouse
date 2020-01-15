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
    .daterangepicker.dropdown-menu.ltr.opensleft.show-calendar{
        z-index: 500;
    }
    .daterangepicker.dropdown-menu.opensleft.show-calendar{
        right: auto !important;
        left: 15% !important;
    }         
    .select2-container{
        width: 80% !important;
        float: right;
    }
</style>
@endsection
@section('pagecontent')
@php
$timeline = [1 => 'bg-success', 2 => 'bg-primary', 3 => 'bg-danger'];
$timeline2 = [1 => 'text-success', 2 => 'text-primary', 3 => 'text-danger'];
$action = [1 => ['en' => 'Created', 'es' => 'Creado'], 2 => ['en' => 'Updated', 'es' => 'Actualizado'], 3 => ['en' => 'Deleted', 'es' => 'Eliminado']];

function time2str($ts) {
    if(!ctype_digit($ts)) {
        $ts = strtotime($ts);
    }
    $diff = time() - $ts;
    if($diff == 0) {
        return 'now';
    } elseif($diff > 0) {
        $day_diff = floor($diff / 86400);
        if($day_diff == 0) {
            if($diff < 60) return 'Just now';
            if($diff < 120) return '1 minute ago';
            if($diff < 3600) return floor($diff / 60) . ' minutes ago';
            if($diff < 7200) return '1 hour ago';
            if($diff < 86400) return floor($diff / 3600) . ' hours ago';
        }
        if($day_diff == 1) { return 'Yesterday'; }
        if($day_diff < 7) { return $day_diff . ' days ago'; }
        if($day_diff < 31) { return ceil($day_diff / 7) . ' weeks ago'; }
        if($day_diff < 60) { return 'last month'; }
        return date('F Y', $ts);
    } else {
        $diff = abs($diff);
        $day_diff = floor($diff / 86400);
        if($day_diff == 0) {
            if($diff < 120) { return 'in a minute'; }
            if($diff < 3600) { return 'in ' . floor($diff / 60) . ' minutes'; }
            if($diff < 7200) { return 'in an hour'; }
            if($diff < 86400) { return 'in ' . floor($diff / 3600) . ' hours'; }
        }
        if($day_diff == 1) { return 'Tomorrow'; }
        if($day_diff < 4) { return date('l', $ts); }
        if($day_diff < 7 + (7 - date('w'))) { return 'next week'; }
        if(ceil($day_diff / 7) < 4) { return 'in ' . ceil($day_diff / 7) . ' weeks'; }
        if(date('n', $ts) == date('n') + 1) { return 'next month'; }
        return date('F Y', $ts);
    }
}
@endphp
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">@lang('sistema.bitacora.bitacora_lbl')</h4>
                <ol class="breadcrumb p-0 m-0">
                    <li>
                        <a href="{{ url('/') }}">@lang('sistema.pie')</a>
                    </li>
                    <li class="active">
                        @lang('sistema.bitacora.bitacora_lbl')
                    </li>
                </ol>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <form method="post" class="form-horizontal">
                        {{ csrf_field() }}
                        <div class="row" style="width: 100%;height: 50px;">
                            <div class="form-group col-sm-5">
                                <div class="col-sm-12">
                                    <label class="control-label" style="margin-left: 15px; margin-right: 5px; margin-top: 8px;padding-right: 0;padding-left: 0;">@lang('sistema.broker.broker'):</label>
                                    <select class="select2" name="broker_id" id="broker_id">
                                        <option value="">@lang('sistema.all')</option>
                                        @if(isset($global_assigned_brokers) && count($global_assigned_brokers) > 0)
                                        @foreach($global_assigned_brokers as $broker)
                                        <option value="{{ $broker['id'] }}" {{ (isset($broker_selected_id) && $broker_selected_id == $broker['id']) ? 'selected' : '' }}>{{ $broker['broker'] }}</option>
                                        @endforeach
                                        @endif
                                    </select>                                    
                                </div>
                            </div>                            
                            <div class="form-group col-sm-4" style="">                                
                                <div class="col-sm-9" style="float: right;padding-left: 0;">
                                    <div class="input-group">
                                        <input class="form-control" value="" style="width: 70%;display: inline-block;" name="reportrange" id="reportrange"/>
                                        <span class="input-group-append">
                                            <button style="border-top-right-radius: 4px; border-bottom-right-radius: 4px;" type="submit" class="btn waves-effect waves-light btn-primary"><i class="fa fa-search"></i></button>
                                        </span>
                                        <input type="hidden" name="from_date" id="from_date"/>
                                        <input type="hidden" name="upto_date" id="upto_date"/>
                                    </div>
                                </div>
                                <label class="col-sm-2 control-label" style="margin-top: 8px;float: right;padding-right: 0;padding-left: 0;">@lang('sistema.date'):</label>
                            </div>
                        </div>
                    </form>
                    <div class="timeline timeline-left">                        
                    @if(isset($history) && count($history) > 0)
                        <div>
                        @foreach($history as $history_date => $history)
                        <article class="timeline-item alt">
                            <div class="text-left">
                                <div class="time-show first">
                                    <a style="cursor: default;" class="btn btn-primary w-lg">{{ $history_date == date('d-m-Y') ? 'Today' : $history_date }}</a>
                                </div>
                            </div>
                        </article>
                        @foreach($history as $history_arr)                        
                        <article class="timeline-item">
                            <div class="timeline-desk">
                                <div class="panel">
                                    <div class="timeline-box">
                                        <span class="arrow"></span>
                                        <span class="timeline-icon {{ $timeline[$history_arr->action_type] }}"><i class="mdi mdi-checkbox-blank-circle-outline"></i></span>
                                        @if($history_date == date('d-m-Y')) 
                                        <h4 class="{{ $timeline2[$history_arr->action_type] }}">{{ time2str($history_arr->created_at->format('Y-m-d H:i:s')) }}</h4>
                                        @endif
                                        <p class="timeline-date text-muted"><small>{{ $history_arr->created_at->format('H:i a') }}</small></p>
                                        <p style="font-size: 16px;"><strong>{{ $action[$history_arr->action_type][session('language')] }}: {{ __('sistema.model.' . $history_arr->model_name) }}</strong></p>
                                        @php
                                        $json_data = json_decode($history_arr->extra,true);
                                        $this_model_name = 'App\\Models\\' . $history_arr->model_name;
                                        $this_model = new $this_model_name;
                                        @endphp
                                        <div style="margin-top: 5px;">
                                            <hr style="margin-top: 5px;margin-bottom: 10px;">
                                            @foreach($json_data as $keyId => $jd)
                                            <div style="margin-bottom: 5px;">
                                                <label style="margin-bottom: 0;font-size: 14px;" class="form-control-label">#{{ ++$keyId }} @lang('sistema.field_name'): {{ $this_model->mapping($jd['fieldlabel']) }}</label>
                                                @php
                                                    if(in_array($jd['fieldlabel'], ['status', 'estatus']))
                                                    {
                                                        if($jd['newvalue'] == 1)
                                                        {
                                                            $jd['newvalue'] = __('sistema.active');
                                                        }
                                                        else
                                                        {
                                                            $jd['newvalue'] = __('sistema.active');
                                                        }
                                                        
                                                        if($jd['oldvalue'] == 1)
                                                        {
                                                            $jd['oldvalue'] = __('sistema.active');
                                                        }
                                                        else
                                                        {
                                                            $jd['oldvalue'] = __('sistema.active');
                                                        }
                                                    }
                                                @endphp
                                                <p style="margin: 0;">
                                                    @if($history_arr->action_type == 2)
                                                    @if($jd['fk'])
                                                    <span><strong>@lang('sistema.old_value'):</strong> {{ $jd['oldValueLbl_' . session('language')] }}</span>
                                                    @else
                                                    <span><strong>@lang('sistema.old_value'):</strong> {{ $jd['oldvalue'] }}</span>
                                                    @endif
                                                    <br/>
                                                    @endif
                                                    
                                                    @if($history_arr->action_type == 3)                                                          
                                                    @if($jd['fk'])
                                                    <span>{{ $jd['newValueLbl_' . session('language')] }}</span>
                                                    @else                                                    
                                                    <span>{{ $jd['newvalue'] }}</span>
                                                    @endif
                                                    @elseif($history_arr->action_type == 1)                                                    
                                                    @if($jd['fk'])
                                                    <span>{{ $jd['newValueLbl_' . session('language')] }}</span>
                                                    @else
                                                    <span><strong>Value:</strong> {{ $jd['newvalue'] }}</span>
                                                    @endif
                                                    @else
                                                    @if($jd['fk'])
                                                    <span><strong>@lang('sistema.new_value'):</strong> {{ $jd['newValueLbl_' . session('language')] }}</span>
                                                    @else
                                                    <span><strong>@lang('sistema.new_value'):</strong> {{ $jd['newvalue'] }}</span>
                                                    @endif
                                                    @endif
                                                </p>
                                            </div>
                                            @endforeach
                                        </div>
                                        <div><strong style="font-size: 14px;">@lang('sistema.model.User'): {{ $history_arr->usuario_name }}</strong></div>
                                    </div>
                                </div>
                            </div>
                        </article>
                        @endforeach
                        @endforeach
                    </div>
                    @else
                    <div class="col-lg-12" style="margin-top: 30px;height: 46px;padding: 10px;border: 1px solid #ccc;">
                        <div class="clearfix"></div>
                        <p style="text-align: center; font-size: 16px;">@lang('sistema.trade_report.no_data')</p>
                    </div>
                    @endif
                    </div>
                </div>
            </div>
        </div> <!-- end col -->
    </div>
</div><!-- container -->
<footer class="footer">
    © {{ date('Y') }} @lang('sistema.pie')
</footer>
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
<script src="{{ url('assets/plugins/select2/js/select2.min.js') }}"></script>
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
    var start_date = '{{ date("d/m/Y", strtotime($start_date)) }}';
    var upto_date = '{{ date("d/m/Y", strtotime($upto_date)) }}';
    console.log(start_date, upto_date);
    //Aqui deben de ir las secciones adicionales
    $(function() {
        $(".select2").select2();
        $('#from_date').val($('#reportrange').data('daterangepicker').startDate.format('YYYY-MM-DD'));
        $('#upto_date').val($('#reportrange').data('daterangepicker').endDate.format('YYYY-MM-DD'));        
    });
    $('#reportrange span').html(moment('{{ $start_date }}').format('MMMM D, YYYY') + ' - ' + moment('{{ $upto_date }}').format('MMMM D, YYYY'));
    console.log(moment(start_date).format('MMMM D, YYYY') + ' - ' + moment(upto_date).format('MMMM D, YYYY'));
    $('#reportrange').daterangepicker({
        startDate: start_date,
        endDate: upto_date,
        minDate: '01/01/2018',
        maxDate: moment(),
        showDropdowns: true,
        showWeekNumbers: true,
        timePicker: false,
        timePickerIncrement: 1,
        timePicker12Hour: true,
        ranges: {
        'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
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
        $("#from_date").val(start.format('YYYY-MM-DD'));
        $("#upto_date").val(end.format('YYYY-MM-DD'));        
        $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        $('#reportrange').change();
    });
     
    $('#reportrange').on('apply.daterangepicker', function(ev, picker) {    
        console.log('changed');
        $('#from_date').val($('#reportrange').data('daterangepicker').startDate.format('YYYY-MM-DD'));
        $('#upto_date').val($('#reportrange').data('daterangepicker').endDate.format('YYYY-MM-DD'));        
    });
</script>
@endsection