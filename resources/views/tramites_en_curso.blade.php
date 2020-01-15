@extends('layouts.front_vertical_menu')
@section('customcss')
<link href="{{ url('assets/plugins/datatables/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ url('assets/plugins/datatables/buttons.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ url('assets/plugins/datatables/responsive.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ url('assets/plugins/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css"/>
<style type="text/css">
    .page-item.active .page-link {
        background: #8cd5dd;
        border-color: #8cd5dd;
    }
    .small_color_bx{
        height: 10px;
        width: 10px;
        display: block;
        text-align: center;
        margin: auto;
    }
</style>
@endsection

@section('pagecontent')
<div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <h4 class="page-title">@lang('frontsistema.tramites_en_curso.title')</h4>
                    <div class="web_logo">
                        <img class="" src="{{ url('assets/images/logo_espacios.png')}}" alt="" height="50">
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
        <!-- end row -->

        <div class="row">
            <div class="col-lg-12 m-b-50">
                <div class="card11">
                    <div class="card-body11">
                        <p class="text-muted m-b-20">
                        </p>

                        <table class="table table-striped m-0 balance_grid" id="request-table">
                            <thead>
                                <tr>
                                    <th class="text-center color_green">@lang('frontsistema.tramites_en_curso.num_folio')</th>
                                    <th>@lang('frontsistema.tramites_en_curso.procedure')</th>
                                    <th>@lang('frontsistema.tramites_en_curso.updated_date')</th>
                                    <th>@lang('frontsistema.tramites_en_curso.status')</th>
                                    <th></th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
            <!-- end col -->

        </div>
        <!-- end row --> 

        <div class="row">
            <div class="col-lg-12 m-t-50">
                <div class="card help_card_widget">
                    <div class="card-body">
                        <p class="m-0">
                            @lang('frontsistema.tramites_en_curso.help_msg1') <a class="open_contact_us_form" href="javascript:void(0);">@lang('frontsistema.click_here')</a> @lang('frontsistema.tramites_en_curso.help_msg2') 
                        </p>
                    </div>
                </div>
            </div>
        </div>

    </div> <!-- container-fluid -->
@endsection

@section('customjs')
<script type="text/javascript" src="{{ url('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script type="text/javascript" src="{{ url('assets/plugins/datatables/dataTables.bootstrap4.min.js') }}"></script>
<script type="text/javascript" src="{{ url('assets/plugins/datatables/dataTables.keyTable.min.js') }}"></script>
<script type="text/javascript" src="{{ url('assets/plugins/datatables/dataTables.responsive.min.js') }}"></script>
<script type="text/javascript" src="{{ url('assets/plugins/datatables/responsive.bootstrap4.min.js') }}"></script>

<script type="text/javascript">
    var item_tbl;
    //Aqui deben de ir las secciones adicionales
    $(function() {
        item_tbl = $('#request-table').DataTable({
            processing: true,
            serverSide: true,
            order: [[ 2, 'desc']],
            ajax: {
                url: '{!! url("user/datatable/client_requests") !!}',
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
            "dom": 'l<>rtip',
            language:{
            @if(\Lang::locale() == 'es')
                url: '{{url("assets/plugins/datatables/json/Spanish.json")}}'
            @endif
            },
            "bStateSave": true,
            "fnStateSave": function (oSettings, oData) {
                localStorage.setItem( 'DataTables', JSON.stringify(oData) );
            },
            "fnStateLoad": function (oSettings) {
                return JSON.parse( localStorage.getItem('DataTables') );
            },
            columns: [

                { data: 'file_number',name: 'file_number'},
                { data: 'request_type_id', name: 'request_type_id' },
                { data: 'updated_at', name: 'updated_at' },
                { data: 'status', name: 'status' },
                { data: 'color_code', name: 'color_code', class: 'text-center', width: '10%', orderable:false, searchable:false },
            ]
        });
    });
</script>
@endsection