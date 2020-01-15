@extends('layouts.front_vertical_menu')
@section('customcss')
<style type="text/css">
    .promocione-sub-div{
        /* background: #8CD5DD;
        margin-top: -60px;
        padding-top: 60px;
        border: 2px solid rgba(140, 213, 221,0.2);
        z-index: -1; */
    }
    .promocione-sub-div p.short_description, .promocione-sub-div .long_description{
        text-align: justify;
        /* padding: 0px 15px; */
    }
    .about-team .about-team-member p{
        color: #2d2d2d;
    }
    .promocione-sub-div > p.long_description{
        text-align: justify;
        padding: 0px 15px;
        color: #2d2d2d !important;
    }
    .promocione-sub-div h4{
        font-weight: 600;
        font-size: 20px;
    }
    .about-team-member img.img-fluid.d-block.rounded-circle:hover {
        zoom: 1;
        webkit-filter: blur(1px);
        filter: blur(1px);
        cursor: pointer;
    }
    .about-team-member img.img-fluid.d-block.rounded-circle
    {
        margin: 0 20px;
    }
    .profile-image{
        margin-top: 15px !important;
    }
    .a_back{
        float: right;
        margin-top: -95px;
        margin-right: 5px;
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
        <div class="row about-team">
            <!-- <div class="col-sm-12">
                <div class="about-team-member">
                    <img src="{{ url($promotion->promo_image) }}" alt="team-member" class="img-fluid d-block rounded-circle">
                    <div class="promocione-sub-div">
                        <a class="a_back" href="{{ url('user/promociones') }}">@lang('frontsistema.promociones.back')</a>
                        <h4 class="text-left">{{ $promotion->promo_title  }}</h4>
                        <p class="short_description">{{ $promotion->short_description  }}</p>
                        <div class="long_description">{!! $promotion->long_description !!}</div>
                    </div>
                </div>
            </div> -->
            <div class="col-xl-2 col-lg-2 col-md-4 col-sm-12 col-xs-12">
                <img src="{{ url($promotion->promo_image) }}" alt="team-member" class="img-fluid d-block profile-image">
            </div>
            <div class="col-xl-10 col-lg-10 col-md-8 col-sm-12 col-xs-12">
                <div class="promocione-sub-div">
                    <!-- <a class="a_back" href="{{ url('user/promociones') }}">@lang('frontsistema.promociones.back')</a> -->
                    <h4 class="text-left">{{ $promotion->promo_title  }}</h4>
                    <p class="short_description">{{ $promotion->short_description  }}</p>
                    <div class="long_description">{!! $promotion->long_description !!}</div>
                    <a  href="{{ url('user/promociones') }}" class="btn btn-block btn-aqua waves-effect waves-light" style="max-width: 210px;">@lang('frontsistema.promociones.back')</a>
                </div>
            </div>
        </div>
        <!-- end row -->
    </div> <!-- container-fluid -->
@endsection

@section('customjs')
@endsection