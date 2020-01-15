@extends('layouts.main')

@section('estilos')
@include('layouts.estilos')
@endsection

@section('barra')
@include('layouts.barra')
@endsection

@section('menu-left')

@endsection

@section('pagecontent')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="jumbotron" style="margin: 10px auto;">
                <h1>@lang('sistema.page404_message')</h1>
                <h4 class="page-title">@lang('sistema.page404_title')</h4>
                <a class="btn btn-info" style="margin-top: 15px;" href="{{ url('/') }}">Home</a>
            </div>
        </div>
    </div>
</div>
<footer class="footer">
    © {{ date('Y') }} @lang('sistema.pie')
</footer>


@endsection

@section('scriptjs')
@include('layouts.scriptjs')
@endsection

@section('customjs')
@include('layouts.customjs')
@endsection