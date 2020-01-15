@extends('layouts.main')
@section('customcss')
<link href="{{ url('assets/plugins/datatables/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ url('assets/plugins/datatables/buttons.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ url('assets/plugins/datatables/fixedHeader.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ url('assets/plugins/datatables/responsive.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ url('assets/plugins/datatables/scroller.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ url('assets/plugins/datatables/dataTables.colVis.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ url('assets/plugins/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css"/>
<link href="{{ url('assets/plugins/datatables/fixedColumns.dataTables.min.css') }}" rel="stylesheet" type="text/css" />
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
</style>
@endsection
@section('pagecontent')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">@lang('sistema.users_title')</h4>
                <ol class="breadcrumb p-0 m-0">
                    <li>
                        <a href="javascript:void(0)">@lang('sistema.pie')</a>
                    </li>
                    <li class="active">
                        @lang('sistema.users_title')
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
                    <a href="{{ url('usuarios/create') }}" class="btn btn-success waves-effect waves-light pull-right m-b-10"><span class="glyphicon glyphicon-check"></span> @lang('sistema.users_new')</a>
                    <div class="clearfix"></div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div style="display: inline-block;float: right;">
                                <label class="custom_search_title">@lang('sistema.search'): &nbsp;<input name="custom_search" id="custom_search" type="text"/></label>
                            </div>                            
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered dt-responsive nowrap" id="usuarios-table" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>@lang('sistema.users_name')</th>                                 
                                            <th>@lang('sistema.users_mail')</th>
                                            <th>@lang('sistema.users_photo')</th>
                                            <th>@lang('sistema.users_status')</th>
                                            <th>@lang('sistema.users_profile')</th>                          
                                            <th>@lang('sistema.users_created')</th>
                                            <th>@lang('sistema.users_action')</th>
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
<script type="text/javascript" src="{{ url('assets/plugins/datatables/dataTables.fixedHeader.min.js') }}"></script>
<script type="text/javascript" src="{{ url('assets/plugins/datatables/dataTables.keyTable.min.js') }}"></script>
<script type="text/javascript" src="{{ url('assets/plugins/datatables/dataTables.responsive.min.js') }}"></script>
<script type="text/javascript" src="{{ url('assets/plugins/datatables/responsive.bootstrap4.min.js') }}"></script>
<script type="text/javascript" src="{{ url('assets/plugins/datatables/dataTables.scroller.min.js') }}"></script>
<script type="text/javascript" src="{{ url('assets/plugins/datatables/dataTables.colVis.js') }}"></script>
<script type="text/javascript" src="{{ url('assets/plugins/datatables/dataTables.fixedColumns.min.js') }}"></script>
@if(session('msg'))
<script>
    @if(session('type') == 'success')
    swal({
        title:'@lang("sistema.users_alert")',
        text:'{{session("msg")}}',
        type:'success',
        timer: 3500,
        confirmButtonColor:'green',
        confirmButtonText:'OK'
    });
    @endif

    @if(session('type')=='error')
    swal({
        title:'@lang("sistema.users_alert")',
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
    var tbl_usuario;
    //Aqui deben de ir las secciones adicionales
    $(function() {
        tbl_usuario = $('#usuarios-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{!! url("datatable/usuarios") !!}',
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
                }
            },
            @if(\App::getLocale()=='es')
            language:{    
                url: '{{url("assets/plugins/datatables/json/Spanish.json")}}'
            },
            @endif
            dom: 'l<>rtip',
            "bStateSave": true,
            "fnStateSave": function (oSettings, oData) {
                localStorage.setItem( 'DataTables', JSON.stringify(oData) );
            },
            "fnStateLoad": function (oSettings) {
                return JSON.parse( localStorage.getItem('DataTables') );
            },
            columns: [
                { data: 'id', name: 'id' },
                { data: 'name', name: 'name' },
                { data: 'email', name: 'email' },
                { data: 'photo', render: function(data, type, row){
                  return '<img src="'+data+'" class="img-circle" width="36px">'
                } ,orderable:false, searchable:false},
                { data: 'status', name: 'status' },                
                { data: 'perfiles.perfil', name: 'perfiles.perfil' },                  
                { data: 'created_at', name: 'created_at' },
                { data: 'action', name: 'action',orderable:false, searchable:false, class: 'text-center' },
            ]
        });        
    });
    $('input[name=custom_search]').change(function(){
        tbl_usuario.draw();
    });
</script>
@endsection