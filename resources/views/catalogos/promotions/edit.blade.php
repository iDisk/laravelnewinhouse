@extends('layouts.main')
@section('customcss')
<link href="{{ url('assets/plugins/summernote/summernote-bs4.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('pagecontent')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">@lang('sistema.promotions.create_promotion')</h4>
                <ol class="breadcrumb p-0 m-0">
                    <li>
                        <a href="javascript:void(0)">@lang('sistema.pie')</a>
                    </li>
                    <li>
                        <a href="{{ url('brands' . $broker->id . '/promotion') }}">
                            @lang('sistema.broker.brokers')
                        </a>
                    </li>
                    <li class="active">
                        @lang('sistema.promotions.create_promotion')
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
                    <form class="form-horizontal"  method="POST" action="{{url('brands/'. $broker->id .'/promotion/' . $promotion->id)}}" id="frm_promotions" onsubmit="return validateFrm();" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}
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
                                <div class="form-group row" id="inputpromotion_title_en">
                                    <label for="promotion_title_en" class="col-sm-3 form-control-label">@lang('sistema.promotions.promotion_title_en'):<span class="text-danger">*</span></label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control frmfield" id="promotion_title_en" name="promotion_title_en" placeholder="{{__('sistema.promotions.promotion_title_en')}}" valida="SI" cadena ="{{__('sistema.promotions.required.promotion_title_en')}}" value="{{ (old('promotion_title_en')) ? : $promotion->promo_title_en }}">
                                    </div>
                                </div>
                                <div class="form-group row" id="inputpromotion_title_es">
                                    <label for="promotion_title_es" class="col-sm-3 form-control-label">@lang('sistema.promotions.promotion_title_es'):<span class="text-danger">*</span></label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control frmfield" id="promotion_title_es" name="promotion_title_es" placeholder="{{__('sistema.promotions.promotion_title_es')}}" valida="SI" cadena ="{{__('sistema.promotions.required.promotion_title_es')}}" value="{{ (old('promotion_title_es')) ? : $promotion->promo_title_es }}">
                                    </div>
                                </div>
                                <div class="form-group row" id="inputpromotion_short_description_en">
                                    <label for="promotion_short_description_en" class="col-sm-3 form-control-label">@lang('sistema.promotions.promotion_short_description_en'):<span class="text-danger">*</span></label>
                                    <div class="col-sm-9">
                                        <input type="text" max="250" class="form-control frmfield" id="promotion_short_description_en" name="promotion_short_description_en" placeholder="{{__('sistema.promotions.promotion_short_description_en')}}" valida="SI" cadena ="{{__('sistema.promotions.required.promotion_short_description_en')}}" value="{{ (old('promotion_short_description_en')) ? : $promotion->short_description_en }}">
                                    </div>
                                </div>
                                <div class="form-group row" id="inputpromotion_short_description_es">
                                    <label for="promotion_short_description_es" class="col-sm-3 form-control-label">@lang('sistema.promotions.promotion_short_description_es'):<span class="text-danger">*</span></label>
                                    <div class="col-sm-9">
                                        <input type="text" max="250" class="form-control frmfield" id="promotion_short_description_es" name="promotion_short_description_es" placeholder="{{__('sistema.promotions.promotion_short_description_es')}}" valida="SI" cadena ="{{__('sistema.promotions.required.promotion_short_description_es')}}" value="{{ (old('promotion_short_description_es')) ? : $promotion->short_description_es }}">
                                    </div>
                                </div>
                                <div class="form-group row" id="inputpromo_image">
                                    <label for="promo_image" class="col-sm-3 form-control-label">@lang('sistema.promotions.promotion_image'):<span class="text-danger">*</span></label>
                                    <div class="col-sm-9">
                                        <input type="file" name="promo_image" id="promo_image" onChange="readURL(this);" accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|images/*" class="filestyle" data-buttonname="btn-default" value="{{ asset(env('APP_ROOT').'/assets/images/no_image.png') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4" style="margin-top: 12px;">
                                <div class="form-group row">
                                    <div class="col-sm-8">
                                        <img id="img_cat" style="width: 100%; border: 1px solid #ccc;" src="{{ $promotion && $promotion->promo_image ? asset($promotion->promo_image) : asset(env('APP_ROOT').'/assets/images/no_image.png') }}" class="img-responsive"/>
                                        @if($promotion && $promotion->promo_image)                                                
                                        <a href="javascript:void(0)" class="fa fa-times text-danger btnRemoveTempImg">{{  __("sistema.btn_delete") }}</a>
                                        @endif                                        
                                    </div>
                                </div>
                            </div> 
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group row" id="inputpromotion_long_description_en">
                                    <label for="promotion_long_description_en" class="col-sm-12 form-control-label">@lang('sistema.promotions.promotion_long_description_en'):<span class="text-danger">*</span></label>
                                    <div class="col-sm-12">
                                        <textarea class="form-control frmfield" id="promotion_long_description_en" name="promotion_long_description_en" valida="SI" cadena ="{{__('sistema.promotions.required.promotion_long_description_en')}}" value="{{ (old('promotion_long_description_en')) ? : '' }}">{{ (old('promotion_long_description_en')) ? : $promotion->long_description_en }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group row" id="inputpromotion_long_description_es">
                                    <label for="promotion_long_description_es" class="col-sm-12 form-control-label">@lang('sistema.promotions.promotion_long_description_es'):<span class="text-danger">*</span></label>
                                    <div class="col-sm-12">
                                        <textarea class="form-control frmfield" id="promotion_long_description_es" name="promotion_long_description_es" valida="SI" cadena ="{{__('sistema.promotions.required.promotion_long_description_es')}}" value="{{ (old('promotion_long_description_es')) ? : '' }}">{{ (old('promotion_long_description_es')) ? : $promotion->long_description_es }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-8">
                                <div class="form-group row" id="inputestatus">
                                    <label for="estatus_active" class="col-sm-3 form-control-label">@lang('sistema.promotions.promotion_estatus'):<span class="text-danger">*</span></label>
                                    <div class="col-sm-9">
                                        <div class="custom-control custom-radio custom-control-inline mb-2">
                                            <input type="radio" id="estatus_active" name="estatus" value="1" class="custom-control-input frmfield" {{ $promotion->estatus ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="estatus_active">@lang('sistema.active')</label>
                                        </div>
                                        <div class="custom-control custom-radio custom-control-inline mb-2">
                                            <input type="radio" id="estatus_inactive" name="estatus" value="0" class="custom-control-input frmfield"  {{ !$promotion->estatus ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="estatus_inactive">@lang('sistema.inactive')</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group m-b-0">
                                    <div class="col-sm-12">
                                        <a href="{{url('brands/' . $broker->id . '/promotion')}}" class="btn btn-danger waves-effect waves-light">@lang('sistema.btn_back')</a>
                                        <button type="submit" class="btn btn-info waves-effect waves-light">@lang('sistema.btn_save')</button>
                                    </div>
                                </div>  
                            </div>
                        </div>
                    </form>
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
<script type="text/javascript" src="{{ url('assets/plugins/summernote/summernote-bs4.js') }}"></script>
<script type="text/javascript" src="{{ url('assets/plugins/filestyle/bootstrap-filestyle.min.js') }}"></script>
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
    $('#promotion_long_description_en, #promotion_long_description_es').summernote({
        height: 350
    });
    function validateFrm()
    {
        var listv = 0;
        var msg = '';

        $('#frm_promotions').find(':input').each(function () {
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

            if ($(this).attr('id') == 'promo_image')
            {
                if ($(this).val() == '')
                {
                    $(this).next().addClass('has-error');
                } else
                {
                    $(this).next().removeClass('has-error');
                }
            }

            if ($(this).attr('id') == 'promotion_long_description')
            {
                if ($(this).val() == '')
                {
                    $(this).next().addClass('has-error');
                } else
                {
                    $(this).next().removeClass('has-error');
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

    $("body").on('click', '.btnRemoveTempImg', function () {
        $('#img_cat').attr('src', "{{ asset(env('APP_ROOT').'/assets/images/no_image.png') }}");
        $("#promo_image").val('').change();
        $('.btnRemoveTempImg').remove();
    });

    function readURL(input) {
        if (input.files.length > 0) {
            var ext = input.files[0]['name'].substring(input.files[0]['name'].lastIndexOf('.') + 1).toLowerCase();
            if (input.files && input.files[0] && (ext == "gif" || ext == "png" || ext == "jpeg" || ext == "jpg")) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('.btnRemoveTempImg').remove();
                    $('#img_cat').attr('src', e.target.result).after('<a href="javascript:void(0)" class="fa fa-times text-danger btnRemoveTempImg">' + '{{  __("sistema.btn_delete") }}' + '</a>');
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