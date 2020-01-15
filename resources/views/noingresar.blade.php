@extends('layouts.app')


@section('estilos')
    @include('layouts.estilos')
@endsection

@section('barra')
    @include('layouts.barra')
@endsection

@section('menu-left')
    @include('layouts.menu-left',$elmenu)
@endsection

@section('content')
    
                <!-- Start content -->
                <div class="content">

                    <div class="">
                        <div class="page-header-title">
                            <h4 class="page-title">Acceso no permitido</h4>
                        </div>
                    </div>

                    <div class="page-content-wrapper ">

                        <div class="container">

                           <div class="jumbotron"><h1>Su usuario no tiene acceso</h1></div>

                        </div><!-- container -->


                    </div> <!-- Page content Wrapper -->

                </div> <!-- content -->

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