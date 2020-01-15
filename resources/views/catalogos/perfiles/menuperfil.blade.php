@extends('layouts.main')
@section('customcss')
<link href="{{ url('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('pagecontent')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <h4 class="page-title">Permisos Sistema</h4>
                        <ol class="breadcrumb p-0 m-0">
                            <li>
                                <a href="javascript:void(0)">@lang('sistema.pie')</a>
                            </li>                               
                            <li>
                                <a href="{{ url('perfiles') }}">@lang('sistema.profile.profiles')</a>
                            </li>
                            <li class="active">
                                Permisos Sistema
                            </li>
                        </ol>
                        <div class="clearfix"></div>
                  </div>
              </div>
          </div>

          <div class="row">
              <div class="col-sm-12">
                  <div class="card">
                      <div class="card-body">
                          <h4 class="m-t-0 header-title"><b>Seleccione los Menús que desea asignar al perfil</b></h4>
                          <p>Recuerde que para habilitar una opción, la opción padre(de la que depende) debe ser seleccionada también</p>
                          <hr>
                            <div class="row">  
                                <div class="col-lg-12">                                                            
                                    <form method="POST" action="{{url('asignamenus')}}" class="form-horizontal">
                                        {{ csrf_field() }}
                                        <input type="hidden" id="perfil_id" name="perfil_id" value="{{ $roldata->id}}"/>
                                        <div class="col-lg-6" style="display: inline-block; float: left;">
                                        {!! $Menus !!}
                                        </div>
                                        <div class="col-lg-6" style="display: inline-block; float: left;">
                                            <div class="form-group">
                                                <label>Brokers</label>
                                                <select class="form-control select2" name="broker_id[]" id="broker_id" multiple="multiple">                                                    
                                                    @if(isset($all_brokers) && count($all_brokers) > 0)
                                                    @foreach($all_brokers as $broker_id => $broker)
                                                    <option value="{{ $broker_id }}" {{ in_array($broker_id, $my_brokers) ? 'selected' : '' }}>{{ $broker }}</option>
                                                    @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                        <div style="clear: both;"></div>
                                        <div class="col-lg-12">
                                            <div class="form-group m-b-0">
                                                <div class="offset-sm-3 col-sm-9">
                                                    <a href="{{url('perfiles')}}" class="btn btn-danger waves-effect waves-light">@lang('sistema.btn_back')</a>
                                                    <button type="submit" class="btn btn-info waves-effect waves-light">@lang('sistema.btn_save')</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                          <!-- end row -->

                      </div>
                  </div>
              </div><!-- end col -->
          </div>
      </div><!-- container -->                
<footer class="footer">
        © {{ date('Y') }} @lang('sistema.pie')
</footer>
@endsection

@section('customjs')
<script src="{{ url('assets/plugins/select2/js/select2.min.js') }}"></script>
<script>
    $(function ($) {
        $(".select2").select2();
    });
</script>
@endsection