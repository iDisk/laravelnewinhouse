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
                    <h4 class="page-title">{{ $title }}</h4>
                    <div class="web_logo">
                        <img class="" src="{{ url('assets/images/logo_espacios.png')}}" alt="" height="50">
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
        @php
            $no_rceord = 1;
        @endphp

        @foreach($tarde_investments as $key => $tarde_investment_data)
            @if(count($tarde_investment_data) > 0)

                @php
                    $no_rceord = 0;
                @endphp
                <div class="row">
                    <div class="col-xl-12 col-md-12">
                        <p class="m-t-5 m-b-10"><span class="font-700 font-16">{{ $instrument[$key] }}:</span> </p>
                    </div>
                </div>
                <!-- end row -->
                <div class="row m-b-20">
                    <div class="col-lg-12">
                        <div class="card11">
                            <div class="card-body11">
                                <p class="text-muted m-b-20">
                                </p>
                                <table class="table table-striped m-0 balance_grid trade_investment-table">
                                    <thead>
                                        <tr>
                                            <th class="text-center color_green">@lang('frontsistema.trade_investment.ticket')</th>
                                            <th>@lang('frontsistema.trade_investment.date'):</th>
                                            <th>@lang('frontsistema.trade_investment.transaction'):</th>
                                            <th>@lang('frontsistema.trade_investment.expiration'):</th>
                                            <th>@lang('frontsistema.trade_investment.amount'):</th>
                                            <th>@lang('frontsistema.trade_investment.nav'):</th>
                                            <th>@lang('frontsistema.trade_investment.risk'):</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                       
                                        @foreach($tarde_investment_data as $tarde_investment)
                                            
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
                                                <td><a class="color_green" href="{{ url('user/trade_investment_view/'.App\Util\HelperUtil::encode($tarde_investment->id)) }}">@lang('frontsistema.home.view_complete')</a></td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- end col -->
                </div>
            @endif
        @endforeach


        @if($no_rceord == 1)
            <div class="row">
                <div class="col-xl-12 col-md-12">
                    <p class="m-t-5 m-b-10"><span class="font-700 font-16">@lang('frontsistema.home.no_record_found')</span></p>
                </div>
            </div>
        @endif
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
        $(".trade_investment-table").DataTable({
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
            ]
        });
        show_loader(false);
    });
</script>
@endsection