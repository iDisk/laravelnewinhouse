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
            <div class="col-xl-12 col-md-12 center-page">
                <div class="text-right m-b-5">
                    <a class="text-aqua-blue font-600 text-underline p-l-r-5" href="{{ url('/user/derivados_etim') }}">@lang('frontsistema.return')</a>
                </div>
                <div class="card widget-box-three m-b-15">
                    @if($type == 'trade')
                        <div class="card-body">
                            <div class="text-center11">
                                <div class="row">
                                    <div class="col-md-6">
                                        <p class="m-t-5 m-b-0"><span class="font-700">@lang('frontsistema.derivados_etim_cfds_fx.ticket'):</span> {{ $account_transaction->ticket }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="m-t-5 m-b-0"><span class="font-700">@lang('frontsistema.derivados_etim_cfds_fx.date'):</span> {{  date("d-m-Y", strtotime($account_transaction->created_at)) }}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <p class="m-t-5 m-b-0"><span class="font-700">@lang('frontsistema.derivados_etim_cfds_fx.open_time'):</span> {{ $account_transaction->opening_time }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="m-t-5 m-b-0"><span class="font-700">@lang('frontsistema.derivados_etim_cfds_fx.type'):</span> {{ $account_transaction->type }}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <p class="m-t-5 m-b-0"><span class="font-700">@lang('frontsistema.derivados_etim_cfds_fx.item'):</span> {{ $account_transaction->item }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="m-t-5 m-b-0"><span class="font-700">@lang('frontsistema.derivados_etim_cfds_fx.description'):</span> </p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <p class="m-t-5 m-b-0"><span class="font-700">@lang('frontsistema.derivados_etim_cfds_fx.open_price'):</span> {{  number_format($account_transaction->opening_price, 2, '.', ',')  }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="m-t-5 m-b-0"><span class="font-700">@lang('frontsistema.derivados_etim_cfds_fx.close_price'):</span> {{ number_format($account_transaction->closing_price, 2, '.', ',') }}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <p class="m-t-5 m-b-0"><span class="font-700">@lang('frontsistema.derivados_etim_cfds_fx.size'):</span> {{ $account_transaction->contracts }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="m-t-5 m-b-0"><span class="font-700">@lang('frontsistema.derivados_etim_cfds_fx.close_time'):</span> {{ $account_transaction->closing_time }}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <p class="m-t-5 m-b-0"><span class="font-700">@lang('frontsistema.derivados_etim_cfds_fx.stop_loss'):</span> {{ $account_transaction->stop_loss }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="m-t-5 m-b-0"><span class="font-700">@lang('frontsistema.derivados_etim_cfds_fx.leverage'):</span> {{ $account_transaction->leverage->label }}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <p class="m-t-5 m-b-0"><span class="font-700">@lang('frontsistema.derivados_etim_cfds_fx.warranty'):</span> {{ number_format($account_transaction->financial_exhibition, 2, '.', ',') }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="m-t-5 m-b-0"><span class="font-700">@lang('frontsistema.derivados_etim_cfds_fx.exposure'):</span> {{ number_format($account_transaction->financial_exhibition, 2, '.', ',') }}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <p class="m-t-5 m-b-0"><span class="font-700">@lang('frontsistema.derivados_etim_cfds_fx.comission'):</span> {{ number_format($account_transaction->commission, 2, '.', ',') }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="m-t-5 m-b-0"><span class="font-700">@lang('frontsistema.derivados_etim_cfds_fx.close_pl'):</span> {{ number_format($account_transaction->gross_profit, 2, '.', ',') }}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <p class="m-t-5 m-b-0"><span class="font-700">@lang('frontsistema.derivados_etim_cfds_fx.net_pl'):</span> {{ number_format($account_transaction->net_result, 2, '.', ',') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @elseif($type == 'mov')
                        <div class="card-body">
                            <div class="text-center11">
                                <div class="row">
                                    <div class="col-md-6">
                                        <p class="m-t-5 m-b-0"><span class="font-700">@lang('frontsistema.derivados_etim_cfds_fx.ticket'):</span> {{ $movement_transaction->ticket }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="m-t-5 m-b-0"><span class="font-700">@lang('frontsistema.derivados_etim_cfds_fx.date'):</span> {{ date("d-m-Y", strtotime($movement_transaction->fecha_transaccion)) }}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <p class="m-t-5 m-b-0"><span class="font-700">@lang('frontsistema.derivados_etim_cfds_fx.open_time'):</span> </p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="m-t-5 m-b-0"><span class="font-700">@lang('frontsistema.derivados_etim_cfds_fx.type'):</span> {{ $movement_transaction->type }}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <p class="m-t-5 m-b-0"><span class="font-700">@lang('frontsistema.derivados_etim_cfds_fx.item'):</span> </p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="m-t-5 m-b-0"><span class="font-700">@lang('frontsistema.derivados_etim_cfds_fx.description'):</span> {{ $movement_transaction->description }}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <p class="m-t-5 m-b-0"><span class="font-700">@lang('frontsistema.derivados_etim_cfds_fx.open_price'):</span> </p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="m-t-5 m-b-0"><span class="font-700">@lang('frontsistema.derivados_etim_cfds_fx.close_price'):</span> </p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <p class="m-t-5 m-b-0"><span class="font-700">@lang('frontsistema.derivados_etim_cfds_fx.size'):</span> </p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="m-t-5 m-b-0"><span class="font-700">@lang('frontsistema.derivados_etim_cfds_fx.close_time'):</span> </p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <p class="m-t-5 m-b-0"><span class="font-700">@lang('frontsistema.derivados_etim_cfds_fx.stop_loss'):</span> </p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="m-t-5 m-b-0"><span class="font-700">@lang('frontsistema.derivados_etim_cfds_fx.leverage'):</span> </p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <p class="m-t-5 m-b-0"><span class="font-700">@lang('frontsistema.derivados_etim_cfds_fx.warranty'):</span> </p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="m-t-5 m-b-0"><span class="font-700">@lang('frontsistema.derivados_etim_cfds_fx.exposure'):</span> </p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <p class="m-t-5 m-b-0"><span class="font-700">@lang('frontsistema.derivados_etim_cfds_fx.comission'):</span> </p>
                                    </div> 
                                    <div class="col-md-6">
                                        <p class="m-t-5 m-b-0"><span class="font-700">@lang('frontsistema.derivados_etim_cfds_fx.close_pl'):</span> </p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <p class="m-t-5 m-b-0"><span class="font-700">@lang('frontsistema.derivados_etim_cfds_fx.net_pl'):</span>{{ ($movement_transaction->operation_category == 1)? '':'-' }} {{ number_format($movement_transaction->monto, 2, '.', ',') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
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