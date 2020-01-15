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
</style>
@endsection

@section('pagecontent')
<div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <h4 class="page-title">@lang('frontsistema.trade_investment.wealth_management')</h4>
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
                            <p class="m-t-5 m-b-10"><span class="font-700">@lang('frontsistema.trade_investment.balance_at'):</span> {{ date('d M Y') }}</p>
                            <h2 class="m-b-0 text-custom-info font-700">$<span data-plugin="counterup">{{ number_format($total_credit->credit_monto - $total_debit->debit_monto, 2, '.', ',') }}</span></h2>
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

                        <table id="fondos_inversion-table" class="table table-striped m-0 balance_grid">
                            <thead>
                                <tr>
                                    <th class="text-center color_green">@lang('frontsistema.trade_investment.ticket')</th>
                                    <th>@lang('frontsistema.trade_investment.date'):</th>
                                    <th>@lang('frontsistema.trade_investment.transaction'):</th>
                                    <th>@lang('frontsistema.trade_investment.expiration'):</th>
                                    <th>@lang('frontsistema.trade_investment.amount'):</th>
                                    <th>@lang('frontsistema.trade_investment.nav'):</th>
                                    <th>@lang('frontsistema.trade_investment.risk'):</th>
                                    <th>@lang('frontsistema.trade_investment.unit_balance'):</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $total_amount = 0;
                                @endphp
                                @foreach($tarde_investments as $tarde_investment)
                                    @php
                                        if($tarde_investment->is_opening  || $tarde_investment->tipo == 'cr')
                                        {
                                            $total_amount = $total_amount + $tarde_investment->monto;
                                        }else{
                                            $total_amount = $total_amount - $tarde_investment->monto;
                                        }
                                    @endphp
                                    <tr>
                                        <td class="font-600">{{ $tarde_investment->ticket }}</td>
                                        <td>{{ date("d-m-Y", strtotime($tarde_investment->fecha)) }}</td>
                                        <td>{{ $tarde_investment->transaction }}</td>
                                        @if($tarde_investment->is_opening)
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        @elseif($tarde_investment->tipo == 'cr')
                                            <td>LIQ</td>
                                            <td>{{ number_format($tarde_investment->monto, 2, '.', ',') }}</td>
                                            <td>{{ number_format($tarde_investment->nav, 2, '.', ',') }}</td>
                                            <td>LIQ</td>
                                        @else
                                            <td>{{ date("d-m-Y", strtotime($tarde_investment->fecha_vencimiento)) }}</td>
                                            <td>{{ number_format($tarde_investment->monto, 2, '.', ',') }}</td>
                                            <td>{{ number_format($tarde_investment->nav, 2, '.', ',') }}</td>
                                            <td>{{ number_format($tarde_investment->riesgo, 2, '.', ',') }}</td>
                                        @endif
                                        <td>{{ number_format($total_amount, 2, '.', ',') }}</td>
                                        <td><a class="color_green" href="{{ url('user/wealth_management_detail/'.App\Util\HelperUtil::encode($tarde_investment->id)) }}">@lang('frontsistema.trade_investment.view_complete')</a></td>
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
        $("#fondos_inversion-table").DataTable({
            language:{
            @if (\Lang::locale() == 'es')
                url: '{{url("assets/plugins/datatables/json/Spanish.json")}}'
            @endif
            },
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
            ]
        });
        show_loader(false);
    });
</script>
@endsection