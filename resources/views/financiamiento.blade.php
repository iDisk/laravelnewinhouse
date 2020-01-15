@extends('layouts.front_vertical_menu')
@section('customcss')
<link href="{{ url('assets/plugins/datatables/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ url('assets/plugins/datatables/buttons.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ url('assets/plugins/datatables/responsive.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ url('assets/plugins/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css"/>
<style type="text/css">

</style>
@endsection

@section('pagecontent')
<div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <h4 class="page-title">@lang('frontsistema.financiamiento_activos.title')</h4>
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
                            <p class="m-t-5 m-b-10"><span class="font-700">@lang('frontsistema.financiamiento_activos.available_at'):</span> {{ date('d M Y') }}</p>
                            <h2 class="m-b-0 text-custom-info font-700">$<span data-plugin="counterup">{{ number_format($movimientos_total->total_amount, 2, '.', ',') }}</span></h2>
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

                        <table id="financiamiento_activosTable" class="table table-striped m-0 balance_grid">
                            <thead>
                                <tr>
                                    <th class="invisible">#</th>
                                    <th class="text-center color_green">@lang('frontsistema.financiamiento_activos.ticket')</th>
                                    <th>@lang('frontsistema.financiamiento_activos.date'):</th>
                                    <th>@lang('frontsistema.financiamiento_activos.type'):</th>
                                    <th>@lang('frontsistema.financiamiento_activos.amount'):</th>
                                    <th>@lang('frontsistema.financiamiento_activos.expiration'):</th>
                                    <th>@lang('frontsistema.financiamiento_activos.outstanding_balance'):</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $total_amount = 0;
                                    $count = 0;
                                @endphp

                                @foreach($movimientos_trans as $movimientos_transaction)
                                    <tr>
                                        <td class="invisible">{{ $count++ }}</td>
                                        <td class="font-600">{{ $movimientos_transaction->ticket }}</td>
                                        <td>{{ date("d-m-Y", strtotime($movimientos_transaction->fecha_transaccion)) }}</td>
                                        <td>{{ $movimientos_transaction->type }}</td>
                                        <td>{{ number_format($movimientos_transaction->monto, 2, '.', ',') }}</td>
                                        <td>{{ ($movimientos_transaction->movimientos_tipo_id == 10) ? date("d-m-Y", strtotime($movimientos_transaction->fecha_valor)) : '' }}</td>
                                        @php
                                            if($movimientos_transaction->movimientos_tipo_id == 10){
                                                $total_amount = $total_amount + $movimientos_transaction->monto;
                                            }else{
                                                $total_amount = $total_amount - $movimientos_transaction->monto;
                                            }
                                        @endphp
                                        <td>{{ number_format($total_amount, 2, '.', ',') }}</td>
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
        $("#financiamiento_activosTable").DataTable({
            language:{
            @if (\Lang::locale() == 'es')
                url: '{{url("assets/plugins/datatables/json/Spanish.json")}}'
            @endif
            },
            "order": [[0, 'asc' ]],
            "columns": [
                { orderable:false, visible: false},
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