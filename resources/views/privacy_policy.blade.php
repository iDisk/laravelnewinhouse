@extends('layouts.front_vertical_menu')
@section('customcss')
<style type="text/css">
    .cuenta_blue.table-striped tbody tr:nth-of-type(odd){
        background: #8cd5dd;
    }
    .cuenta_blue.table-striped tbody tr:nth-of-type(even) td{
        padding-bottom: .30rem;
        padding-left: 0px;
        padding-right: 0px;
        font-size: 12px;    
    }
    .cuenta_blue.table-striped thead{
        border-top:1px solid;
    }
    .cuenta_blue.table-striped th, .cuenta_blue.table-striped td{
        border: none;
        vertical-align: middle;
    }
    .cuenta_blue.table-striped a{
        margin-left: 10px;
        font-weight: 700;
        text-decoration: underline;
        color: #8cd5dd;
    }
    .cuenta_blue.table-striped hr{
        margin: .15rem 0 .25rem 0;
        border-top: 1px solid #2d2d2d;
    }
    .cuenta_black.table-striped tbody tr:nth-of-type(odd){
        background: #2d2d2d;
        color: #ffffff;
    }
    .cuenta_black.table-striped tbody tr:nth-of-type(even) td{
        padding-bottom: .30rem;
        padding-left: 0px;
        padding-right: 0px;
        font-size: 12px;    
    }
    .cuenta_black.table-striped thead{
        border-top:1px solid;
    }
    .cuenta_black.table-striped th, .cuenta_black.table-striped td{
        border: none;
        vertical-align: middle;
    }
    .cuenta_black.table-striped a{
        margin-left: 10px;
        font-weight: 700;
        text-decoration: underline;
        color: #8cd5dd;
    }
    .cuenta_black.table-striped hr{
        margin: .15rem 0 .25rem 0;
        border-top: 1px solid #2d2d2d;
    }

    .table-striped td{
        border: 1px solid #ffffff !important;
    }
</style>

@endsection

@section('pagecontent')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">@lang('frontsistema.home.privacy_policy')</h4>
                <div class="web_logo">
                    <img class="" src="{{ url('assets/images/logo_espacios.png')}}" alt="" height="50">
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
    <!-- end row -->
    <div class="row">
        <div class="col-lg-12">
            {!! $privacy_policy !!}
        </div>        
    </div>  
</div> <!-- container-fluid -->
@endsection