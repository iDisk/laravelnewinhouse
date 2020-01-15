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
                <h4 class="page-title">@lang('sistema.promotions.promotion')</h4>
                <ol class="breadcrumb p-0 m-0">
                    <li>
                        <a href="javascript:void(0)">@lang('sistema.pie')</a>
                    </li>
                    <li>
                        <a href="{{ url('brands') }}">
                            @lang('sistema.broker.brokers')
                        </a>
                    </li>
                    <li class="active">
                        @lang('sistema.promotions.promotion')
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
                    <a href="{{ url('brands/' . $broker->id . '/promotion/create') }}" class="btn btn-success waves-effect waves-light pull-right m-b-10"><span class="glyphicon glyphicon-check"></span> @lang('sistema.promotions.new_promotion')</a>
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
                            <table class="table table-striped table-bordered dt-responsive nowrap dataTable no-footer dtr-inline" id="item-table" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>@lang('sistema.promotions.promotion_title_en')</th>
                                        <th>@lang('sistema.promotions.promotion_title_es')</th>
                                        <th>@lang('sistema.promotions.promotion_estatus')</th>
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

@if (session('msg'))
<script>
    @if(session('type')=='success')
        swal({
          title:'Aviso!!',
          text:'{{session("msg")}}',
          type:'success',
          timer: 3500,
          confirmButtonColor:'green',
          confirmButtonText:'OK'
        });
    @endif

    @if(session('type')=='error')
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

    function confirmaDel(id,text)
    {
        swal({
            title: "{{ __('sistema.confirm') }}",
            text: "{{ __('sistema.item.delete_msg') }} :\""+text+'\"?',
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: '#DD6B55',
            confirmButtonText: "{{ __('sistema.btn_delete') }}",
            cancelButtonText: "{{ __('sistema.btn_cancel') }}"
        }).then(function () {
            var formulario = $('#borra_Frm'+id);
            formulario.submit();
        }, function (dismiss) {
            //Code for cancel
        })
    }

    var item_table;
    //Aqui deben de ir las secciones adicionales
    $(function() {
        item_table = $('#item-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{!! url("datatable/brands") !!}' + '/' + '{{ $broker->id }}/promotion',
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
            columns: [
                { data: 'id', name: 'id', width: '5%' },
                { data: 'promo_title_en',name: 'promo_title_en'},
                { data: 'promo_title_es',name: 'promo_title_es'},
                { data: 'estatus',name: 'estatus', class: 'text-center'},
                { data: 'action', name: 'action', class: 'text-center', orderable:false, searchable:false },
            ]
        });
    });
    $('input[name=custom_search]').change(function(){
        item_table.draw();
    });
    </script>
@endsection