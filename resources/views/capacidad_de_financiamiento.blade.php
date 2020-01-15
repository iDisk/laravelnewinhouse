@extends('layouts.front_vertical_menu')
@section('customcss')
<link href="{{ url('assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet">
<style type="text/css">
    b {
        font-weight: 600;
    }
</style>
@endsection

@section('pagecontent')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box text-xs-center text-sm-center text-md-center">
                    <h4 class="page-title">@lang('frontsistema.capacidad_de_financiamiento.title')</h4>
                    <div class="web_logo">
                        <img class="" src="{{ url('assets/images/logo_espacios.png')}}" alt="" height="50">
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
        <form id="finance_request_form">
            <div class="row m-b-50 on_load">
<!--                <div class="col-xl-4 col-lg-4 col-md-12 m-t-40 text-center">
                    <p class="m-0 font-600">@lang('frontsistema.capacidad_de_financiamiento.your_account')</p>
                    <h3 class="text-custom-info font-600 m-t-0">{{ $account->account_number  }}</h3>
                </div>-->
                <div class="col-xl-6 offset-xl-2 col-lg-6 offset-lg-2 col-md-12 m-t-40 text-center">
                    <div class="main-box black">
                        <div class="title">
                            @lang('frontsistema.capacidad_de_financiamiento.current_capacity')
                        </div>
                        <div class="amount text-custom-info font-600 m-t-0">
                            {{ isset($capacidad_financiamiento) ? number_format($capacidad_financiamiento, 2, '.', ',') : 0.00  }}
                        </div>
                    </div>
                </div>
                <!-- end col -->
            </div>
            <div class="row on_load">
                <div class="col-xl-10 col-lg-12 col-md-12">
                    <div class="card help_card_widget">
                        <div class="card-body">
                            <p class="m-0">
                                @lang('frontsistema.capacidad_de_financiamiento.help_msg1') <a href="javascript:void(0)" class="open_contact_us_form">@lang('frontsistema.click_here')</a> @lang('frontsistema.capacidad_de_financiamiento.help_msg2') 
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div> <!-- container-fluid -->

    @php 
        $arr['label1'] = array('type'=>'text','value'=>'val','label_en'=>'eng','label_es'=>'spanish');
        //dd($arr);
    @endphp
@endsection

@section('customjs')
    <script type="text/javascript">
    </script>
@endsection