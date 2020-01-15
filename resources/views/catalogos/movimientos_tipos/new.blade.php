@extends('layouts.main')
@section('customcss')

@endsection

@section('pagecontent')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">@lang('sistema.movimientos_tipo.create_movimientos_tipo')</h4>
                <ol class="breadcrumb p-0 m-0">
                    <li>
                        <a href="javascript:void(0)">@lang('sistema.pie')</a>
                    </li>                         
                    <li>
                        <a href="{{ url('movimientos_tipos') }}">
                            @lang('sistema.movimientos_tipo.movimientos_tipos')
                        </a>
                    </li>
                    <li class="active">
                        @lang('sistema.movimientos_tipo.create_movimientos_tipo')
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
                    <!--<h4 class="m-t-0 header-title"><b>Input Types</b></h4>-->
                    <p></p>
                    <div class="row">
                        <div class="col-lg-6">
                            @if (count($errors) > 0)
                            <div class="alert alert-warning">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif
                            <form class="form-horizontal"  method="POST" action="{{url('movimientos_tipos')}}" id="frm_movimientos_tipos" onsubmit="return validateFrm();" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <div class="form-group row" id="inputtype_en">
                                    <label for="type_en" class="col-sm-3 form-control-label">@lang('sistema.movimientos_tipo.type_en')<span class="text-danger">*</span></label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="type_en" name="type_en" placeholder="{{__('sistema.movimientos_tipo.type_en')}}" valida="SI" cadena ="{{__('sistema.movimientos_tipo.req_type_en')}}" value="{{ (old('type_en'))? old('type_en'):'' }}">
                                    </div>
                                </div>
                                <div class="form-group row" id="inputtype_es">
                                    <label for="type_es" class="col-sm-3 form-control-label">@lang('sistema.movimientos_tipo.type_es')<span class="text-danger">*</span></label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="type_es" name="type_es" placeholder="{{__('sistema.movimientos_tipo.type_es')}}" valida="SI" cadena ="{{__('sistema.movimientos_tipo.req_type_es')}}" value="{{ (old('type_es'))? old('type_es'):'' }}">
                                    </div>
                                </div>
                                <div class="form-group row" id="inputmovimientos_tipo_category_id">
                                    <label for="movimientos_tipo_category_id" class="col-sm-3 form-control-label">@lang('sistema.equity_report.equity')<span class="text-danger">*</span></label>
                                    <div class="col-sm-9">
                                        <select class="form-control" name="movimientos_tipo_category_id" id="movimientos_tipo_category_id" valida="SI" cadena ="{{__('sistema.movimientos_tipo.req_equity')}}">
                                            <option value="">@lang('sistema.movimientos_tipo.select_equity')</option>
                                            @if(isset($categories) && count($categories) > 0)
                                            @foreach($categories as $category_id => $category)
                                            <option value="{{ $category_id }}">{{ $category }}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group m-b-0">
                                    <div class="offset-sm-3 col-sm-9">
                                        <a href="{{url('movimientos_tipos')}}" class="btn btn-danger waves-effect waves-light">@lang('sistema.btn_back')</a>
                                        <button type="submit" class="btn btn-info waves-effect waves-light">@lang('sistema.btn_save')</button>
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
@if (session('type')=='error')            
<script>
    swal({
        title: '@lang("sistema.users_alert")',
        text: '{{session("msg")}}',
        type: 'error',
        timer: 5500,
        confirmButtonColor: 'red',
        confirmButtonText: 'OK'
    });
</script>
@endif

<script type="text/javascript">
    function validateFrm()
    {
        var listv = 0;
        var msg = '';
        $('#frm_movimientos_tipos').find(':input').each(function () {
            if ($(this).attr("valida") == "SI" && ($(this).val() == "" || $(this).val() == "null"))
            {
                listv = 1;
                $('#input' + this.id).addClass('has-error');
                msg += $(this).attr('cadena') + '\n';
                //$(this).val($(this).val().toUpperCase());
            } else
            {
                $('#input' + this.id).removeClass('has-error');
                if ($(this).attr("valida") == "SI")
                {
                    //$(this).val($(this).val().toUpperCase());
                }
            }
        });
        if (listv == 1)
        {
            swal({
                title: '@lang("sistema.users_alert")',
                text: msg,
                type: 'error',
                timer: 4000,
                confirmButtonColor: 'red',
                confirmButtonText: 'OK'
            });
            return false;
        } else {
            return true;
        }
    }
</script>
@endsection