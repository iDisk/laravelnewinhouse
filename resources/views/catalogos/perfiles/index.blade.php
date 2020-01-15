@extends('layouts.main')
@section('customcss')
<link href="{{ url('assets/plugins/datatables/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ url('assets/plugins/datatables/buttons.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ url('assets/plugins/datatables/responsive.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ url('assets/plugins/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css"/>
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
                <h4 class="page-title">@lang('sistema.profile.profiles')</h4>
                <ol class="breadcrumb p-0 m-0">
                    <li>
                        <a href="javascript:void(0)">@lang('sistema.pie')</a>
                    </li>
                    <li class="active">
                        @lang('sistema.profile.profiles')
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
                    <a href="{{ url('perfiles/create') }}" class="btn btn-success waves-effect waves-light pull-right m-b-10"><span class="glyphicon glyphicon-check"></span> @lang('sistema.profile.new_profile')</a>
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
                                <table class="table table-striped table-bordered dt-responsive nowrap dataTable no-footer dtr-inline" id="perfiles-table" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>@lang('sistema.profile.profile')</th>
                                            <th>@lang('sistema.action')</th>
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

@if (session('msg'))            
<script>
@if (session('type') == 'success')
swal({
    title: 'Aviso!!',
    text: '{{session("msg")}}',
    type: 'success',
    timer: 3500,
    confirmButtonColor: 'green',
    confirmButtonText: 'OK'
});
@endif

@if (session('type') == 'error')
swal({
    title: 'Aviso!!',
    text: '{{session("msg")}}',
    type: 'error',
    timer: 3500,
    confirmButtonColor: 'red',
    confirmButtonText: 'OK'
});
@endif
</script>
@endif

<script type="text/javascript">

    function verPerfil(perfil)
    {
        $('#nombreperfil').text('');

        $('#nombreperfil').text(perfil);

        $('#mostrarModal').modal('show');
    }

    function confirmaDel(perfil_id,perfil)
    {
          
            swal({
                title: "{{ __('sistema.confirm') }}",
                text: "{{ __('sistema.profile.delete_msg') }} :\"" + perfil + '\"?',
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: '#DD6B55',
                confirmButtonText: "{{ __('sistema.btn_delete') }}",
                cancelButtonText: "{{ __('sistema.btn_cancel') }}"
            })
            .then(function () {
                var formulario = $('#borraPerfilFrm' + perfil_id);
                formulario.submit();
                }, function (dismiss) {
                //Code for cancel
                }
            );
    }
      
    var perfiles_table;
    //Aqui deben de ir las secciones adicionales
    $(function () {
        perfiles_table = $('#perfiles-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{!! url("datatable/perfiles") !!}',
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
            language: {
                url: '{{url("assets/plugins/datatables/json/Spanish.json")}}'
            },
            "bStateSave": true,
            "dom": 'l<>rtip',
            columns: [
                {data: 'id', name: 'id', width: '10%'},
                {data: 'perfil', name: 'perfil', width: '60%'},
                {data: 'action', name: 'action', width: '30%', class: 'text-center', orderable: false, searchable: false},
            ]
        });
    });
    $('input[name=custom_search]').change(function(){
        perfiles_table.draw();
    });
</script>
@endsection