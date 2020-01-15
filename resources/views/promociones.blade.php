@extends('layouts.front_vertical_menu')
@section('customcss')
<style type="text/css">
    .promocione-sub-div{
        /* background: #8CD5DD; */
        /* margin-top: -60px;
        padding-top: 60px;
        border: 2px solid rgba(140, 213, 221,0.2);
        z-index: -1; */
    }
    .promocione-sub-div p{
        /* text-align: justify; */
        padding: 0px 15px;
        color: #2d2d2d !important;
    }
    .promocione-sub-div h4{
        padding-left: 15px;
        padding-right: 15px;
    }
    .about-team-member img.img-fluid.d-block:hover {
        zoom: 1;
        webkit-filter: blur(1px);
        filter: blur(1px);
        /* cursor: pointer; */
    }
</style>
@endsection
@section('pagecontent')
<div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <h4 class="page-title">@lang('frontsistema.promociones.title')</h4>
                    <div class="web_logo">
                        <img class="" src="{{ url('assets/images/logo_espacios.png')}}" alt="" height="50">
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
        <!-- end row -->
        <div class="row about-team text-center">
            <div class="col-xl-10 offset-xl-1 col-lg-10 offset-lg-1 col-md-12 col-sm-12 col-xs-12">
                <div class="row">
                    @if(count($promotions) > 0)
                        @foreach($promotions as $promotion)
                            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-xs-12">
                                <div class="about-team-member">
                                    <!-- <a href="{{ url('user/promociones/'.\App\Util\HelperUtil::encode($promotion->id)) }}"> -->
                                        <img src="{{ url($promotion->promo_image_thumb) }}" alt="team-member" class="img-fluid d-block img-thumbnail">
                                    <!-- </a> -->
                                    <div class="promocione-sub-div">
                                        <h4>{{ $promotion->promo_title  }}</h4>
                                        <p>{{ mb_strimwidth($promotion->short_description, 0, 95, "...")  }}</p>
                                        <a href="{{ url('user/promociones/'.\App\Util\HelperUtil::encode($promotion->id)) }}" class="btn btn-block btn-aqua waves-effect waves-light" style="max-width: 210px;">@lang('frontsistema.promociones.view_more')</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                    <div class="col-sm-12">
                        <p class="text-left">@lang('frontsistema.promociones.not_found_msg')</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    
        <!-- end row -->
    </div> <!-- container-fluid -->
@endsection

@section('customjs')
@endsection