@extends('layouts.front_vertical_menu')

@section('customcss')
<style>
    .page_sub_title{
        color: #8cd5dd;
        font-size: 32px;        
    }
    .notification_date{
       color: #8cd5dd;
    }
    .first_sec, .second_sec{
        display: inline-block;
    }
    .block_notifications{
        padding: 0px !important;
    }
</style>
@endsection

@section('pagecontent')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="first_sec pull-left">
                    <h4 class="page-title">@lang('frontsistema.notifications.notification_lbl') {{ isset($notification) ? ' - '. __('sistema.notifications.short_message.' . $notification->short_message) : '' }}</h4>
                    <div class="clearfix"></div>
                    {{-- <h5 class="page_sub_title">{{ isset($notification) ? __('sistema.notifications.short_message.' . $notification->short_message) : '' }}</h5> --}}
                    @if(isset($notification))                    
                    <p class="notification_date">{{ date('d M Y H:i:s',strtotime($notification->created_at)) }}</p>
                    @endif
                </div>
                <div class="second_sec pull-right">
                    <div class="web_logo">
                        <img class="" src="{{ url('assets/images/logo_espacios.png')}}" alt="" height="50">
                    </div>
                </div>
                <div class="clearfix"></div>
                {!!  $page_content  !!}
            </div>
        </div>
    </div>
</div>
@endsection

@section('customjs')
@endsection