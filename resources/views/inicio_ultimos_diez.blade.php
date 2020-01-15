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
                    <h4 class="page-title">{{ $title }}</h4>
                    <div class="web_logo">
                        <img class="" src="{{ url('assets/images/logo_espacios.png')}}" alt="" height="50">
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
        <!-- end row -->
        <div class="row">
            <div class="col-xl-12 col-md-12">
                @if(isset($from) && isset($to))
                    <p class="m-t-5 m-b-10"><span class="font-700">@lang('frontsistema.home.from_date'):</span> {{ $from }} <span class="font-700">@lang('frontsistema.home.to_date'):</span> {{ $to }}</p>
                @else
                    <p class="m-t-5 m-b-10"><span class="font-700">@lang('frontsistema.home.last_ten_records'):</span></p>
                @endif
                <input type="hidden" id="show_total" value="{{ $show_total }}">
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
                                    <th class="color_green">@lang('frontsistema.derivados_etim_cfds_fx.ticket')</th>
                                    <th>@lang('frontsistema.derivados_etim_cfds_fx.date')</th>
                                    <th>@lang('frontsistema.derivados_etim_cfds_fx.type')</th>
                                    <th>@lang('frontsistema.derivados_etim_cfds_fx.item')</th>
                                    <th>@lang('frontsistema.derivados_etim_cfds_fx.open_price')</th>
                                    <th>@lang('frontsistema.derivados_etim_cfds_fx.close_price')</th>
                                    <th>@lang('frontsistema.derivados_etim_cfds_fx.size')</th>
                                    <th>@lang('frontsistema.derivados_etim_cfds_fx.net_pl')</th>
                                    @if(isset($show_total) && $show_total == 1)
                                        <th>@lang('frontsistema.derivados_etim_cfds_fx.total_balance')</th>
                                    @endif
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $total_balance = $transaction_amount;
                                @endphp

                                @if($type == 'trade')
                                     @foreach($trade_transactions as $trade_transaction)
                                        <tr>
                                            <td class="font-600">{{ $trade_transaction->ticket }}</td>
                                            <td>{{ date("d-m-Y", strtotime($trade_transaction->fecha)) }}</td>
                                            <td>{{ $trade_transaction->type }}</td>
                                            <td>{{ $trade_transaction->item }}</td>
                                            @php
                                                $total_balance = $total_balance + $trade_transaction->monto;
                                            @endphp
                                            <td class="text-center">{{ number_format($trade_transaction->opening_price, 2, '.', ',') }}</td>
                                            <td class="text-center">{{ number_format($trade_transaction->closing_price, 2, '.', ',') }}</td>
                                            <td class="text-center">{{ $trade_transaction->size }}</td>
                                            <td class="text-center">{{ number_format($trade_transaction->monto, 2, '.', ',') }}</td>
                                            @if(isset($show_total) && $show_total == 1)
                                                <td>{{ number_format($total_balance, 2, '.', ',') }}</td>
                                            @endif
                                            <td><a class="color_green" href="{{ url('user/inicio/view/trade/'.App\Util\HelperUtil::encode($trade_transaction->id)) }}">VER COMPLETO</a></td>
                                        </tr>
                                    @endforeach
                                @else
                                    @foreach($movimientos_transactions as $movimientos_transaction)
                                    <tr>
                                            <td class="font-600">{{ $movimientos_transaction->ticket }}</td>
                                            <td>{{ date("d-m-Y", strtotime($movimientos_transaction->fecha)) }}</td>
                                            <td>{{ $movimientos_transaction->type }}</td>
                                            <td>{{ $movimientos_transaction->item }}</td>
                                            @php
                                                if($movimientos_transaction->operation_category == 1){
                                                    $total_balance = $total_balance + $movimientos_transaction->monto;
                                                }else{
                                                    $total_balance = $total_balance - $movimientos_transaction->monto;
                                                }
                                            @endphp
                                            <td class="text-center"></td>
                                            <td class="text-center"></td>
                                            <td class="text-center"></td>
                                            <td class="text-center">{{ number_format($movimientos_transaction->monto, 2, '.', ',') }}</td>
                                            @if(isset($show_total) && $show_total == 1)
                                                <td>{{ number_format($total_balance, 2, '.', ',') }}</td>
                                            @endif
                                            <td><a class="color_green" href="{{ url('user/inicio/view/mov/'.App\Util\HelperUtil::encode($movimientos_transaction->id)) }}">@lang('frontsistema.trade_investment.view_complete')</a></td>
                                        </tr>

                                    @endforeach
                                @endif
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



    if($('#show_total').val() == 1){
        $("#derivados_etim-table").DataTable({
            "order": [],
            "columns": [
                { orderable:false },
                { orderable:false },
                { orderable:false },
                { orderable:false },
                { orderable:false },
                { orderable:false },
                { orderable:false },
                { orderable:false },
                { orderable:false },
                { orderable:false }
            ]
        });
    }else{
        $("#derivados_etim-table").DataTable({
            "order": [],
            "columns": [
                { orderable:false },
                { orderable:false },
                { orderable:false },
                { orderable:false },
                { orderable:false },
                { orderable:false },
                { orderable:false },
                { orderable:false },
                { orderable:false }
            ]
        });
    }  
        show_loader(false);
    });

    
</script>
@endsection