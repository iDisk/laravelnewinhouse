@extends('layouts.main')
@section('customcss')
<link href="{{ url('assets/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css') }}" rel="stylesheet" type="text/css" />
<style>
    .input-group {
        position: relative;
        display: inline-block;
        border-collapse: separate;
    }
    .input-group .form-control {
        position: relative;
        z-index: 2;
        float: left;
        width: 92%;
        margin-bottom: 0;
        display: table-cell;
    }
    .input-group .form-control.colorpicker{
        width: auto;
        margin-top: 0 !important;
        float: left;
    }
    .input-group-addon {
        padding: 9px 10px 10px 10px;
        font-size: 14px;
        font-weight: 400;
        line-height: 1;
        color: #555;
        text-align: center;
        background-color: #eee;
        border: 1px solid #ccc;
        border-radius: 4px;
        float: left;
        border-top-left-radius: 0;
        border-bottom-left-radius: 0;
    }
    .input-group .form-control:first-child {
        border-top-right-radius: 0;
        border-bottom-right-radius: 0;
    }
    .input-group-addon, .input-group-btn {
        white-space: nowrap;
        vertical-align: middle;
    }
    .input-group-addon:last-child {
        border-left: 0;
    }
    .colorpicker-element .input-group-addon i {
        display: inline-block;
        cursor: pointer;
        height: 16px;
        vertical-align: text-top;
        width: 16px;
    }

    .bootstrap-filestyle.input-group{
        width: 100%;
        margin-bottom: 25px;
    }
    .bootstrap-filestyle .form-control{
        width: 80%;
    }
    .group-span-filestyle{
        padding: 8px 0 12px 0;
        background: #ccc;
    }
    .input-group-btn .btn{
        padding: 7px 11px;
    }
    .btn{
        padding: 9px 15px;
    }
    .btnRemoveTempImg{
        float: right;
    }
    .note-editor{
        padding: 5px;
        border-right: 0 !important;
    }
    .note-editor.has-error{
        border: 1px solid #f7531f !important;
    }
    .color_input{
        width: 90% !important;
    }
    .color_button{
        /*position: absolute;
        right: 0;*/
    }
    .paddingTenTb{
        padding-top: 10px;
        padding-bottom: 10px;
    }
    .padding-top-ten{
        padding-top: 10px;
    }
</style>
@endsection

@section('pagecontent')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">@lang('sistema.estatus.new_estatus')</h4>
                <ol class="breadcrumb p-0 m-0">
                    <li>
                        <a href="javascript:void(0)">@lang('sistema.pie')</a>
                    </li>                         
                    <li>
                        <a href="{{ url('items') }}">
                            @lang('sistema.estatus.lbl_estatus')
                        </a>
                    </li>
                    <li class="active">
                        @lang('sistema.estatus.new_estatus')
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
                        <div class="col-lg-8">
                            @if (count($errors) > 0)
                            <div class="alert alert-warning">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif
                            <form class="form-horizontal"  method="POST" action="{{url('estatus')}}" id="frm_items" onsubmit="return validateFrm();">

                                {{ csrf_field() }}
                                <div class="form-group row" id="inputstatus_en">
                                    <label for="status_en" class="col-sm-3 form-control-label">@lang('sistema.estatus.estatus_en')<span class="text-danger">*</span></label>
                                    <div class="col-sm-6">
                                        <input type="text" maxlength="25" class="form-control" id="status_en" name="status_en" placeholder="{{__('sistema.estatus.estatus_en')}}" valida="SI" cadena ="{{__('sistema.estatus.required.estatus_en')}}" value="{{ (old('status_en'))? old('status_en'):'' }}">
                                    </div>
                                </div>
                                <div class="form-group row" id="inputstatus_es">
                                    <label for="status_es" class="col-sm-3 form-control-label">@lang('sistema.estatus.estatus_en')<span class="text-danger">*</span></label>
                                    <div class="col-sm-6">
                                        <input type="text" maxlength="25" class="form-control" id="status_es" name="status_es" placeholder="{{__('sistema.estatus.estatus_en')}}" valida="SI" cadena ="{{__('sistema.estatus.required.estatus_es')}}" value="{{ (old('status_es'))? old('status_es'):'' }}">
                                    </div>
                                </div>
                                <div class="form-group row" id="inputcolor_code">
                                    <label class="col-sm-3 form-control-label">@lang('sistema.estatus.color_code')<span class="text-danger">*</span></label>
                                    <div class="col-sm-6">
                                        <div data-color-format="rgb" data-color="#ffffff" class="colorpicker-default input-group">
                                            <input type="text" readonly="readonly" value="" name="color_code" id="color_code" class="form-control color_input" valida="SI" cadena ="{{__('sistema.estatus.required.color_code')}}" value="{{ old('color_code') ? : '#ffffff' }}">
                                            <span class="input-group-append add-on color_button">
                                                <button class="btn btn-white" type="button">
                                                    <i style="background-color: #ffffff;margin-top: 2px;"></i>
                                                </button>
                                            </span>
                                        </div>
                                    </div>                                    
                                </div>
                                <div class="form-group row" id="inputmenu_orientation" >
                                    <label class="col-sm-3 form-control-label">@lang('sistema.users_status')<span class="text-danger">*</span></label>
                                    <div class="col-sm-6">
                                        <div class="custom-control custom-radio custom-control-inline mb-2">
                                            <input type="radio" id="status_active" name="active" value="1" class="custom-control-input">
                                            <label class="custom-control-label" for="status_active">@lang('sistema.active')</label>
                                        </div>
                                        <div class="custom-control custom-radio custom-control-inline mb-2">
                                            <input type="radio" id="status_inactive" name="active" value="0" class="custom-control-input" checked="">
                                            <label class="custom-control-label" for="status_inactive">@lang('sistema.inactive')</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group m-b-0">
                                    <div class="offset-sm-3 col-sm-9">
                                        <a href="{{url('estatus')}}" class="btn btn-danger waves-effect waves-light">@lang('sistema.btn_back')</a>
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
<script type="text/javascript" src="{{ url('assets/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js') }}"></script>
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
    show_loader(true);
    $(function () {        
         $('.colorpicker-default').colorpicker({
            format: 'hex'
        });
        show_loader(false);
    });
    function validateFrm()
    {
        var listv = 0;
        var msg = '';

        $('#frm_items').find(':input').each(function () {
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