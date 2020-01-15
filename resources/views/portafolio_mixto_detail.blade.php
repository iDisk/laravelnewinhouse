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
                    <h4 class="page-title">@lang('frontsistema.trade_investment.mixed_portfolio')</h4>
                    <div class="web_logo">
                        <img class="" src="{{ url('assets/images/logo_espacios.png')}}" alt="" height="50">
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
        <!-- end row -->
        <div class="row">
            <div class="col-xl-12 col-md-12 center-page">
                <div class="card widget-box-three m-b-15">
                    <div class="card-body">
                        <div class="text-center11">
                            <div class="row">
                                <div class="col-md-6">
                                    <p class="m-t-5 m-b-0"><span class="font-700">@lang('frontsistema.trade_investment.ticket'):</span> {{ $tarde_investment->ticket }}</p>
                                </div>
                                <div class="col-md-6">
                                    <p class="m-t-5 m-b-0"><span class="font-700">@lang('frontsistema.trade_investment.date'):</span> {{ date("d-m-Y", strtotime($tarde_investment->fecha)) }}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <p class="m-t-5 m-b-0"><span class="font-700">@lang('frontsistema.trade_investment.type'):</span> {{ ($tarde_investment->tipo == 'cr')? 'Credit' : 'Debit' }}</p>
                                </div>
                                <div class="col-md-6">
                                    <p class="m-t-5 m-b-0"><span class="font-700">@lang('frontsistema.trade_investment.transaction'):</span> {{ $tarde_investment->transaction }}</p>
                                </div>
                            </div>
                            @if($tarde_investment->is_opening)
                                <div class="row">
                                    <div class="col-md-6">
                                        <p class="m-t-5 m-b-0"><span class="font-700">@lang('frontsistema.trade_investment.amount'):</span> {{ number_format($tarde_investment->monto, 2, '.', ',') }}</p>
                                    </div>
                                </div>
                            @elseif($tarde_investment->tipo == 'cr')
                                <div class="row">
                                    <div class="col-md-6">                                        
                                        <p class="m-t-5 m-b-0"><span class="font-700">@lang('frontsistema.trade_investment.expiration'):</span> LIQ</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="m-t-5 m-b-0"><span class="font-700">@lang('frontsistema.trade_investment.amount'):</span> {{ number_format($tarde_investment->monto, 2, '.', ',') }}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <p class="m-t-5 m-b-0"><span class="font-700">@lang('frontsistema.trade_investment.nav'):</span> {{ number_format($tarde_investment->nav, 2, '.', ',') }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="m-t-5 m-b-0"><span class="font-700">@lang('frontsistema.trade_investment.precio'):</span> {{ number_format($tarde_investment->precio, 2, '.', ',') }}</p>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <p class="m-t-5 m-b-0"><span class="font-700">@lang('frontsistema.trade_investment.risk'):</span> LIQ</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="m-t-5 m-b-0"><span class="font-700">@lang('frontsistema.trade_investment.contracts'):</span> LIQ</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <p class="m-t-5 m-b-0"><span class="font-700">@lang('frontsistema.trade_investment.exposition'):</span> LIQ</p>
                                    </div>
                                </div>
                            @else
                                <div class="row">
                                    <div class="col-md-6">                                        
                                        <p class="m-t-5 m-b-0"><span class="font-700">@lang('frontsistema.trade_investment.expiration'):</span> {{ date("d-m-Y", strtotime($tarde_investment->fecha_vencimiento)) }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="m-t-5 m-b-0"><span class="font-700">@lang('frontsistema.trade_investment.amount'):</span> {{ number_format($tarde_investment->monto, 2, '.', ',') }}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <p class="m-t-5 m-b-0"><span class="font-700">@lang('frontsistema.trade_investment.nav'):</span> {{ number_format($tarde_investment->nav, 2, '.', ',') }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="m-t-5 m-b-0"><span class="font-700">@lang('frontsistema.trade_investment.precio'):</span> {{ number_format($tarde_investment->precio, 2, '.', ',') }}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <p class="m-t-5 m-b-0"><span class="font-700">@lang('frontsistema.trade_investment.risk'):</span> {{ number_format($tarde_investment->riesgo, 2, '.', ',') }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="m-t-5 m-b-0"><span class="font-700">@lang('frontsistema.trade_investment.contracts'):</span> {{ number_format($tarde_investment->contratos, 2, '.', ',') }}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <p class="m-t-5 m-b-0"><span class="font-700">@lang('frontsistema.trade_investment.exposition'):</span> {{ number_format($tarde_investment->exposicion, 2, '.', ',') }}</p>
                                    </div>
                                </div>

                            @endif
                            
                        </div>
                    </div>
                </div>
                <div class="text-center m-b-15">
                    <img class="img-fluid" src="{{ url('assets/images/bottom_shadow.png')}}">
                </div>
            </div>
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
    

</script>
@endsection