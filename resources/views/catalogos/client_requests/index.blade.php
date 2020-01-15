@extends('layouts.main')
@section('customcss')
<link href="{{ url('assets/plugins/datatables/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ url('assets/plugins/datatables/buttons.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ url('assets/plugins/datatables/responsive.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ url('assets/plugins/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css"/>
<link href="{{ url('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
<style>   
    #movimientos_tipo-table_filter{
        display: inline-block;
        float: right;
    }
    .toolbar3{
        display: inline-block;
        float: right;
        margin-right: 10px;
        width: 255px;
    }
    .estatus_select{
        display: inline-block;
        height: 38px;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow{
        top: 2px;
    }
    .select2.select2-container{
        width: 175px !important;
    }
    @media only screen and (max-width: 600px) {
        .select2.select2-container{
            width: 100% !important;
        }    
    } 
    .select2-container--default .select2-selection--single .select2-selection__rendered{
        font-weight: normal;
        font-size: 13px;
        line-height: 30px !important;
    }
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
    #custom_search{
        float: right;
    }
    .bgBlue{
        background: blue;
        color: white !important;
    }
    .bgLightGreen{
        background: #8dd08d;
        color: white !important;
    }
    .bgPink{
        background: pink;
        color: white !important;
    }
    .bgPurple{
        background: purple;
        color: white !important;
    }
    .deleteFrm{
        display: inline-block;  
    }
</style>
@endsection
@section('pagecontent')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">@lang('sistema.client_request.client_request_label')</h4>
                <ol class="breadcrumb p-0 m-0">
                    <li>
                        <a href="javascript:void(0)">@lang('sistema.pie')</a>
                    </li>
                    <li class="active">
                        @lang('sistema.client_request.client_request_label')
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
                            <div style="display: inline-block;float: left;margin-right: 5px;">
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
                            <div style="display: inline-block;float: left;margin-right: 5px;">
                                <label class="custom_search_title">@lang('sistema.account'):</label>
                                <select class="select2 col-lg-4" name="estatus_select" id="estatus_select">
                                    <option value="">@lang('sistema.all')</option>
                                    @if(isset($request_status) && count($request_status) > 0)
                                    @foreach($request_status as $status)                                    
                                    <option value="{{ $status->id }}">{{ $status->estatus }}</option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                            <div style="display: inline-block;float: right;">
                                <label class="custom_search_title">@lang('sistema.search'): &nbsp;<input name="custom_search" id="custom_search" type="text"/></label>
                            </div>
                        </div>
                    </div>                    
                    <div class="clearfix"></div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered dt-responsive nowrap dataTable no-footer dtr-inline" id="item-table" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>@lang('sistema.client_request.file_number')</th>
                                            <th>@lang('sistema.client_request.user_name')</th>
                                            <th>@lang('sistema.client_request.account_id')</th>
                                            <th>@lang('sistema.client_request.request_type')</th>
                                            <th>@lang('sistema.client_request.category')</th>
                                            <th>@lang('sistema.users_status')</th>                                                                                                                        
                                            <th>@lang('sistema.created')</th>
                                            <th class='text-center'>@lang('sistema.action')</th>
                                        </tr>
                                    </thead>
                                </table>
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

    function confirmaDel(id, text)
    {
        swal({
            title: "{{ __('sistema.confirm') }}",
            text: "{{ __('sistema.item.delete_msg') }} :\"" + text + '\"?',
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: '#DD6B55',
            confirmButtonText: "{{ __('sistema.btn_delete') }}",
            cancelButtonText: "{{ __('sistema.btn_cancel') }}"
        }).then(function () {
            var formulario = $('#borra_Frm' + id);
            formulario.submit();
        }, function (dismiss) {
            //Code for cancel
        });
    }

    var item_table;
    //Aqui deben de ir las secciones adicionales
    $(function() {
        $(".select2").select2();
        item_table = $('#item-table').DataTable({
            processing: true,
            serverSide: true,
            order: [[ 7, 'desc' ]],
            ajax: {
                url: '{!! url("datatable/tramites") !!}',
                data: function (d) {
                    let estatus_select = $('body').find('select[name=estatus_select]');                    
                    if (!estatus_select.length)
                    {
                        d.estatus_id = '';
                    }
                    else
                    {
                        d.estatus_id = estatus_select.val();
                    }
                    let search_keyword = $('body').find('input[name=custom_search]');
                    if (!search_keyword.length)
                    {
                        d.search = {'value': ''};
                    }
                    else
                    {
                        d.search = {'value': search_keyword.val()};
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
                }
            },
            "dom": 'l<>rtip',
            language:{
            @if (\Lang::locale() == 'es')
                url: '{{url("assets/plugins/datatables/json/Spanish.json")}}'
            @endif
            },
            columns: [
                { data: 'id', name: 'id', width: '5%' },
                { data: 'file_number', name: 'file_number'},
                { data: 'user_name', name: 'user_name'},
                { data: 'account_number', name: 'account_number'},
                { data: 'request_type_id', name: 'request_type_id'},
                { data: 'category_id', name: 'category_id'},
                { data: 'estatus', name: 'estatus', class: 'text-center'},
                { data: 'created_at', name: 'created_at', class: 'text-center'},
                { data: 'action', name: 'action', class: 'text-center', orderable:false, searchable:false },
            ]
        });
    });
    $('#estatus_select').change(function(){
        item_table.draw();
    });
    $('input[name=custom_search]').change(function(){
        item_table.draw();
    });
    function reload_table()
    {
        item_table.draw();
    }
</script>
@endsection