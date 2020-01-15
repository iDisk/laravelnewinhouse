@extends('layouts.main')
@section('customcss')
<link href="{{ url('assets/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ url('assets/plugins/summernote/summernote-bs4.css') }}" rel="stylesheet" type="text/css" />
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
        width: 93%;
        margin-bottom: 0;
        display: table-cell;
    }
    .input-group-addon {
        padding: 10px;
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
</style>
@endsection
@section('pagecontent')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">@lang('sistema.configuration.configuration_lbl')</h4>
                <ol class="breadcrumb p-0 m-0">
                    <li>
                        <a href="{{ url('/') }}">@lang('sistema.pie')</a>
                    </li>
                    <li class="active">
                        @lang('sistema.configuration.configuration_lbl')
                    </li>
                </ol>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <form class="form-horizontal" method="POST" id="frmConfiguration" onsubmit="return validateFrm();" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <div class="col-lg-12 row">
                                    <div class="col-lg-6">
                                        <div class="form-group" id="input_company_statement_logo">
                                            <label class="form-control-label" style="display: block">@lang('sistema.configuration.statement_logo')</label>
                                            <!--<input class="form-control" type="file" id="company_statement_logo" name="company_statement_logo" accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|images/*" value="" valida="SI" cadena ="{{__('sistema.configuration.required.statement_logo')}}"/>-->
                                            <input type="file" name="company_statement_logo" id="company_statement_logo" onChange="readURL(this);" class="filestyle" data-buttonname="btn-default" value="{{ asset(env('APP_ROOT').'/assets/images/no_image.png') }}">                                        
                                            <img id="img_cat" style="width: 50%; border: 1px solid #ccc;" src="{{ $settings && $settings->company_statement_logo ? asset($settings->company_statement_logo) : '' }}" class="img-responsive"/>
                                            <a href="javascript:void(0)" class="fa fa-times text-danger btnRemoveTempImg">{{  __("sistema.btn_delete") }}</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group" id="input_contact_number">
                                        <label class="form-control-label">@lang('sistema.configuration.contact_number')</label>
                                        <input class="form-control" type="text" id="contact_number" name="contact_number" value="{{ $settings ? $settings->contact_number : '' }}" valida="SI" cadena ="{{__('sistema.configuration.required.contact_number')}}" />
                                    </div>
                                    <div class="form-group" id="input_website_url">
                                        <label class="form-control-label">@lang('sistema.configuration.website_url')</label>
                                        <input class="form-control" type="text" id="website_url" name="website_url" value="{{ $settings ? $settings->website_url : '' }}" valida="SI" cadena ="{{__('sistema.configuration.required.website_url')}}"/>
                                    </div>
                                    <div class="form-group" id="input_admin_email">
                                        <label class="form-control-label">@lang('sistema.configuration.admin_email')</label>
                                        <input class="form-control" type="email" id="admin_email" name="admin_email" value="{{ $settings ? $settings->admin_email : '' }}" valida="SI" cadena ="{{__('sistema.configuration.required.admin_email')}}"/>
                                    </div>
                                    <div class="form-group" id="input_admin_name">
                                        <label class="form-control-label">@lang('sistema.configuration.admin_name')</label>
                                        <input class="form-control" type="text" maxlength="30" id="admin_name" name="admin_name" value="{{ $settings ? $settings->admin_name : '' }}" valida="SI" cadena ="{{__('sistema.configuration.required.admin_name')}}"/>
                                    </div>
                                    <div class="form-group" id="input_statement_legend">
                                        <label class="form-control-label">@lang('sistema.configuration.statement_legend')</label>
                                        <input class="form-control" maxlength="30" type="text" id="statement_legend" name="statement_legend" value="{{ $settings ? $settings->statement_legend : '' }}" valida="SI" cadena ="{{__('sistema.configuration.required.statement_legend')}}"/>
                                    </div>
                                    <div class="form-group" id="input_statement_legend_color">
                                        <label class="form-control-label">@lang('sistema.configuration.statement_legend_color')</label>
                                        <div id="legend_color_picker" class="input-group colorpicker-component">
                                            <input type="text" name="statement_legend_color" id="statement_legend_color" class="form-control" value="{{ $settings ? $settings->statement_legend_color : '#00AABB' }}" valida="SI" cadena ="{{__('sistema.configuration.required.statement_legend_color')}}"/>
                                            <span class="input-group-addon"><i></i></span>
                                        </div>
                                        <!--<input class="form-control" value="" type="text" name="" id="legend_color_picker"/>-->
                                    </div>
                                    <div class="form-group" id="input_template_id">
                                        <label class="form-control-label">@lang('sistema.configuration.template')</label>
                                        <select class="form-control" name="template_id" id="template_id" valida="SI" cadena ="{{__('sistema.configuration.required.template')}}">
                                            <option value="1">Template 1</option>
                                        </select>
                                    </div>
                                    <div class="form-group" id="input_disclaimer">
                                        <label class="form-control-label">@lang('sistema.configuration.disclaimer')</label>
                                        <textarea class="form-control" name="disclaimer" id="disclaimer" style="resize: vertical;" valida="SI" cadena ="{{__('sistema.configuration.required.disclaimer')}}">{{ $settings ? $settings->disclaimer : '' }}</textarea>
                                    </div>
                                </div>
                                <div class="form-group m-b-0">
                                    <div class="col-lg-12">
                                        <a href="{{url('branches')}}" class="btn btn-danger waves-effect waves-light">@lang('sistema.btn_back')</a>
                                        <button type="submit" class="btn btn-info waves-effect waves-light">@lang('sistema.btn_save')</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div><!-- container -->
<footer class="footer">
© {{ date('Y') }} @lang('sistema.pie')
</footer>
@endsection
@section('customjs')
<script type="text/javascript" src="{{ url('assets/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js') }}"></script>
<script type="text/javascript" src="{{ url('assets/plugins/summernote/summernote-bs4.js') }}"></script>
<script type="text/javascript" src="{{ url('assets/plugins/filestyle/bootstrap-filestyle.min.js') }}"></script>
@if (session('msg'))
<script>
    @if (session('type') == 'success')
    swal({
        title:'Aviso!!',
        text:'{{session("msg")}}',
        type:'success',
        timer: 3500,
        confirmButtonColor:'green',
        confirmButtonText:'OK'
    });
    @endif

    @if (session('type') == 'error')
    swal({
        title:'Aviso!!',
        text:'{{session("msg")}}',
        type:'error',
        timer: 3500,
        confirmButtonColor:'red',
        confirmButtonText:'OK'
    });
    @endif
</script>
@endif
<script type="text/javascript">
    //Aqui deben de ir las secciones adicionales
    $(function() {
        $("#legend_color_picker").colorpicker({
            format: 'hex'
        });
        $('#disclaimer').summernote({
            height: 350,
        });        
        $(".glyphicon-folder-open").remove();
    });
    
    function validateFrm()
    {
        var listv = 0;
        var msg = '';

        $('#frmConfiguration').find(':input').each(function () {
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
                timer: false,
                confirmButtonColor: 'red',
                confirmButtonText: 'OK'
            });
            return false;
        } else {
            return true;
        }
    }
    var Uploadlimit = '1000';

    $("body").on('click', '.btnRemoveTempImg', function(){       
       $('#img_cat').attr('src', "{{ asset(env('APP_ROOT').'/assets/images/no_image.png') }}");
       $("#company_statement_logo").val('').change();
       $('.btnRemoveTempImg').remove();
    });
    
    function readURL(input) {
        if (input.files.length > 0) {
            var ext = input.files[0]['name'].substring(input.files[0]['name'].lastIndexOf('.') + 1).toLowerCase();
            if (input.files && input.files[0] && (ext == "gif" || ext == "png" || ext == "jpeg" || ext == "jpg")) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#img_cat').attr('src', e.target.result)
                    //.after('<a href="javascript:void(0)" class="fa fa-times text-danger btnRemoveTempImg">'+ '{{  __("sistema.btn_delete") }}' +'</a>');
                    //$('#img_cat').closest('a').attr('href', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            } else {
                $('#img_cat').attr('src', "{{ asset(env('APP_ROOT').'/assets/images/no_image.png') }}");
                $('#img_cat').closest('a').attr('href', "{{ asset(env('APP_ROOT').'/assets/images/no_image.png') }}");
            }
        } else {
            $('#img_cat').attr('src', $('#default_img').val());
            $('#img_cat').closest('a').attr('href', $('#default_img').val());
        }
    }
</script>
@endsection