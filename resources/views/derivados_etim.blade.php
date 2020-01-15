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
    .page-link:focus{
        box-shadow: 0 0 0 0.05rem rgba(0,123,255,.25);    
    }
    table.dataTable thead th.sorting_asc{
        padding: .50rem !important;
    }
    table.dataTable thead th.sorting_asc:after{
        display: none;
    }
</style>
@endsection
@section('pagecontent')
<div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <h4 class="page-title">@lang('frontsistema.derivados_etim_cfds_fx.title')</h4>
                    <div class="web_logo">
                        <img class="" src="{{ url('assets/images/logo_espacios.png')}}" alt="" height="50">
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
        <!-- end row -->
        <div class="row">
            <div class="col-xl-4 col-md-6 center-page">
                <div class="card widget-box-three m-b-15">
                    <div class="card-body">
                        <div class="text-center">
                            <p class="m-t-5 m-b-10"><span class="font-700">@lang('frontsistema.derivados_etim_cfds_fx.balance_at'):</span> {{ date('d M Y') }}</p>
                            <h2 class="m-b-0 text-custom-info font-700">$<span data-plugin="counterup">{{ number_format($transaction_total->total_amount + $movimientos_total->total_amount, 2, '.', ',') }}</span></h2>
                        </div>
                    </div>
                </div>
                <div class="text-center m-b-15">
                    <img class="img-fluid" src="{{ url('assets/images/bottom_shadow.png')}}">
                </div>
            </div>
        </div>
        <!-- end row -->

        <div class="row">
            <div class="col-lg-12">
                <div class="card11">
                    <div class="card-body11">
                        <p class="text-muted m-b-20">
                        </p>
                        <table id="derivados_etim-table" class="table table-striped m-0 balance_grid">
                            <thead>
                                <tr>
                                    <th class="invisible">#</th>
                                    <th class="color_green">@lang('frontsistema.derivados_etim_cfds_fx.ticket')</th>
                                    <th>@lang('frontsistema.derivados_etim_cfds_fx.date')</th>
                                    <th>@lang('frontsistema.derivados_etim_cfds_fx.type')</th>
                                    <th>@lang('frontsistema.derivados_etim_cfds_fx.item')</th>
                                    <th>@lang('frontsistema.derivados_etim_cfds_fx.open_price')</th>
                                    <th>@lang('frontsistema.derivados_etim_cfds_fx.close_price')</th>
                                    <th>@lang('frontsistema.derivados_etim_cfds_fx.size')</th>
                                    <th>@lang('frontsistema.derivados_etim_cfds_fx.net_pl')</th>
                                    <th>@lang('frontsistema.derivados_etim_cfds_fx.total_balance')</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $total_balance = 0;
                                    $count = 0;
                                @endphp
                                @foreach($results as $result)
                                    <tr>
                                        <td class="invisible">{{ $count++ }}</td>
                                        <td class="font-600">{{ $result->ticket }}</td>
                                        <td>{{ date("d-m-Y", strtotime($result->fecha)) }}</td>
                                        <td>{{ $result->type }}</td>
                                        <td>{{ $result->item }}</td>
                                        @if( $result->trans_type == 0)
                                            @php
                                                $total_balance = $total_balance + $result->monto;
                                            @endphp
                                            <td class="text-center">{{ number_format($result->opening_price, 2, '.', ',') }}</td>
                                            <td class="text-center">{{ number_format($result->closing_price, 2, '.', ',') }}</td>
                                            <td class="text-center">{{ $result->size }}</td>
                                            <td class="text-center">{{ number_format($result->monto, 2, '.', ',') }}</td>
                                            <td>{{ $total_balance }}</td>
                                            <td><a class="color_green" href="{{ url('user/derivados_etim_detail/trade/'.App\Util\HelperUtil::encode($result->id)) }}">@lang('frontsistema.derivados_etim_cfds_fx.view_complete')</a></td>
                                        @else
                                            @php
                                                if($result->operation_category == 1){
                                                    $total_balance = $total_balance + $result->monto;
                                                }else{
                                                    $total_balance = $total_balance - $result->monto;
                                                }
                                            @endphp
                                            <td class="text-center"></td>
                                            <td class="text-center"></td>
                                            <td class="text-center"></td>
                                            <td class="text-center">{{ ($result->operation_category == 1)?'':'-' }}{{ number_format($result->monto, 2, '.', ',') }}</td>
                                            <td>{{ number_format($total_balance, 2, '.', ',') }}</td>
                                            <td><a class="color_green" href="{{ url('user/derivados_etim_detail/mov/'.App\Util\HelperUtil::encode($result->id)) }}">@lang('frontsistema.derivados_etim_cfds_fx.view_complete')</a></td>
                                        @endif                                        
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- end col -->
        </div>
        <!-- end row -->
    </div> <!-- container-fluid -->
@endsection

@section('customjs')
<script type="text/javascript" src="{{ url('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script type="text/javascript" src="{{ url('assets/plugins/datatables/dataTables.bootstrap4.min.js') }}"></script>
<script type="text/javascript" src="{{ url('assets/plugins/datatables/dataTables.keyTable.min.js') }}"></script>
<script type="text/javascript" src="{{ url('assets/plugins/datatables/dataTables.responsive.min.js') }}"></script>
<script type="text/javascript" src="{{ url('assets/plugins/datatables/responsive.bootstrap4.min.js') }}"></script>
<script type="text/javascript">
    show_loader(true);
    $(function(){        
        $("#derivados_etim-table").DataTable({
            language:{
            @if (\Lang::locale() == 'es')
                url: '{{url("assets/plugins/datatables/json/Spanish.json")}}'
            @endif
            },
            "order": [[0, 'asc' ]],
            "columns": [
                { orderable:false, visible: false },
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
            ]
        });
        show_loader(false);
    });
</script>
@endsection