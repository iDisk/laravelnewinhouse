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
                <h4 class="page-title">@lang('sistema.broker.new_broker')</h4>
                <ol class="breadcrumb p-0 m-0">
                    <li><a href="javascript:void(0)">@lang('sistema.pie')</a></li>
                    <li><a href="{{ url('brands') }}">@lang('sistema.broker.brokers')</a></li>
                    <li class="active">@lang('sistema.broker.new_broker')</li>
                </ol>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">
                            @if (count($errors) > 0)
                            <div class="alert alert-warning">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif
                            @php
                            $settings = $brand->setting;
                            @endphp
                            <form class="form-horizontal"  method="POST" action="{{url('brands/' . $brand->id)}}" id="frm_items" onsubmit="return validateFrm();" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                {{ method_field('PUT') }}
                                <div class="row">
                                    <div class="col-lg-8">
                                        <div class="form-group row" id="inputbroker">
                                            <label for="broker" class="col-sm-4 form-control-label">@lang('sistema.broker.broker')<span class="text-danger">*</span></label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" id="broker" name="broker" placeholder="{{__('sistema.broker.broker')}}" valida="SI" cadena ="{{__('sistema.broker.required.req_broker')}}" value="{{ old('broker') ? : $brand->broker }}">
                                            </div>
                                        </div>
                                        <div class="form-group row" id="inputcolor">
                                            <label class="col-sm-4 form-control-label">@lang('sistema.broker.account_color')<span class="text-danger">*</span></label>
                                            <div id="legend_color_picker2" class="col-sm-8 input-group colorpicker-component">
                                                <input type="text" class="form-control" valida="SI" name="color" id="color" placeholder="{{__('sistema.broker.account_color')}}" cadena ="{{__('sistema.broker.required.req_account_color')}}" value="{{ old('color') ? : $brand->color }}"/>
                                                <span class="input-group-addon"><i></i></span>
                                            </div>                                            
                                        </div>
                                        <div class="form-group row" id="inputcode">
                                            <label class="col-sm-4 form-control-label">@lang('sistema.broker.account_code')<span class="text-danger">*</span></label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" valida="SI" maxlength="5" name="code" id="code" placeholder="{{__('sistema.broker.account_code')}}" cadena="{{ __('sistema.broker.required.req_account_code') }}" value="{{ old('code') ? : $brand->code }}"/>
                                            </div>
                                        </div>
                                        <div class="form-group row" id="inputbroker_url">
                                            <label class="col-sm-4 form-control-label">@lang('sistema.broker.broker_url')<span class="text-danger">*</span></label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" valida="SI" name="broker_url" id="broker_url" placeholder="{{__('sistema.broker.broker_url')}}" cadena="{{ __('sistema.broker.required.broker_url') }}" value="{{ old('broker_url') ? : $brand->broker_url }}"/>
                                            </div>
                                        </div>
                                        <div class="form-group row" id="inputdescription">
                                            <label for="description" class="col-sm-4 form-control-label">@lang('sistema.broker.description')<span class="text-danger">*</span></label>
                                            <div class="col-sm-8">
                                                <textarea class="form-control" name="description" id="description" placeholder="{{__('sistema.broker.description')}}" rows="10" valida="SI" cadena ="{{__('sistema.broker.required.req_description')}}">{{ old('description') ? : $brand->description }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>   
                                <hr>
                                <div class="row">                                    
                                    <div class="col-lg-8">
                                        <fieldset style="border: 1px solid #ccc;padding: 10px;">
                                            <legend style="font-size: 16px;">&nbsp;Charges</legend>
                                            <div class="form-group row" id="inputtransfer_commission_percentage">
                                                <label class="col-sm-4 form-control-label">@lang('sistema.configuration.transfer_commission_percentage')<span class="text-danger">*</span></label>
                                                <div class="col-sm-8">
                                                    <input class="autonumber2 form-control" type="text" id="transfer_commission_percentage" name="transfer_commission_percentage" value="{{ old('transfer_commission_percentage') ? : $settings->transfer_commission_percentage }}" valida="SI" cadena ="{{__('sistema.configuration.required.transfer_commission_percentage')}}"/>
                                                </div>
                                            </div>
                                            <div class="form-group row" id="inputtransfer_commission_amount">
                                                <label class="col-sm-4 form-control-label">@lang('sistema.configuration.transfer_commission_amount')<span class="text-danger">*</span></label>
                                                <div class="col-sm-8">
                                                    <input class="autonumber form-control" type="text" id="transfer_commission_amount" name="transfer_commission_amount" value="{{ old('transfer_commission_amount') ? : $settings->transfer_commission_amount }}" valida="SI" cadena ="{{__('sistema.configuration.required.transfer_commission_amount')}}"/>
                                                </div>
                                            </div>
                                            <div class="form-group row" id="inputprocessing_fees_percentage">
                                                <label class="col-sm-4 form-control-label">@lang('sistema.configuration.processing_fees_percentage')<span class="text-danger">*</span></label>
                                                <div class="col-sm-8">
                                                    <input class="autonumber2 form-control" type="text" id="processing_fees_percentage" name="processing_fees_percentage" value="{{ old('processing_fees_percentage') ? : $settings->processing_fees_percentage }}" valida="SI" cadena ="{{__('sistema.configuration.required.processing_fees_percentage')}}"/>
                                                </div>
                                            </div>
                                            <div class="form-group row" id="inputprocessing_fees_amount">
                                                <label class="col-sm-4 form-control-label">@lang('sistema.configuration.processing_fees_amount')<span class="text-danger">*</span></label>
                                                <div class="col-sm-8">
                                                    <input class="autonumber form-control" type="text" id="processing_fees_amount" name="processing_fees_amount" value="{{ old('processing_fees_amount') ? : $settings->processing_fees_amount }}" valida="SI" cadena ="{{__('sistema.configuration.required.processing_fees_amount')}}"/>
                                                </div>
                                            </div>
                                            <div>
                                                # @lang('sistema.configuration.transfer_commission_percentage'), @lang('sistema.configuration.processing_fees_percentage') : MAX 100.00
                                                <br/>
                                                # @lang('sistema.configuration.transfer_commission_amount'), @lang('sistema.configuration.processing_fees_amount') : MAX 99,999.99
                                            </div>
                                        </fieldset>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">                                    
                                    <div class="col-lg-8">
                                        <fieldset style="border: 1px solid #ccc;padding: 10px;">
                                            <legend style="font-size: 16px;">Configuration</legend>
                                            <div class="form-group row" id="inputcompany_statement_logo">
                                                <label class="form-control-label col-sm-4" style="display: block;">@lang('sistema.configuration.statement_logo')<span class="text-danger">*</span></label>                                    
                                                <div class="col-sm-8">
                                                    <input type="file" name="company_statement_logo" id="company_statement_logo" onChange="readURL(this);" accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|images/*" class="filestyle" data-buttonname="btn-default" value="{{ asset(env('APP_ROOT').'/assets/images/no_image.png') }}">                                        
                                                </div>
                                            </div>
                                            <div class="form-group row" id="inputcontact_number">
                                                <label class="col-sm-4 form-control-label">@lang('sistema.configuration.contact_number')<span class="text-danger">*</span></label>
                                                 <div class="col-sm-8">
                                                     <input class="form-control" type="text" id="contact_number" name="contact_number" value="{{ old('contact_number') ? : $settings->contact_number }}" valida="SI" cadena ="{{__('sistema.configuration.required.contact_number')}}" />
                                                 </div>                                        
                                            </div>
                                            <div class="form-group row" id="inputwebsite_url">
                                                <label class="col-sm-4 form-control-label">@lang('sistema.configuration.website_url')<span class="text-danger">*</span></label>
                                                <div class="col-sm-8">
                                                    <input class="form-control" type="text" id="website_url" name="website_url" value="{{ old('website_url') ? : $settings->website_url }}" valida="SI" cadena ="{{__('sistema.configuration.required.website_url')}}"/>
                                                </div>
                                            </div>
                                            <div class="form-group row" id="inputsupport_team_email">
                                                <label class="col-sm-4 form-control-label">@lang('sistema.configuration.support_team_email')<span class="text-danger">*</span></label>
                                                <div class="col-sm-8">
                                                    <input class="form-control" type="email" id="support_team_email" name="support_team_email" value="{{ old('support_team_email') ? : $settings->support_team_email }}" valida="SI" cadena ="{{__('sistema.configuration.required.support_team_email')}}"/>
                                                </div>
                                            </div>
                                            <div class="form-group row" id="inputadmin_email">
                                                <label class="col-sm-4 form-control-label">@lang('sistema.configuration.admin_email')<span class="text-danger">*</span></label>
                                                <div class="col-sm-8">
                                                    <input class="form-control" type="email" id="admin_email" name="admin_email" value="{{ old('admin_email') ? : $settings->admin_email }}" valida="SI" cadena ="{{__('sistema.configuration.required.admin_email')}}"/>
                                                </div>
                                            </div>
                                            <div class="form-group row" id="inputadmin_name">
                                                <label class="col-sm-4 form-control-label">@lang('sistema.configuration.admin_name')<span class="text-danger">*</span></label>
                                                <div class="col-sm-8">
                                                    <input class="form-control" type="text" maxlength="30" id="admin_name" name="admin_name" value="{{ old('admin_name') ? : $settings->admin_name }}" valida="SI" cadena ="{{__('sistema.configuration.required.admin_name')}}"/>
                                                </div>
                                            </div>
                                            <div class="form-group row" id="inputstatement_legend">
                                                <label class="col-sm-4 form-control-label">@lang('sistema.configuration.statement_legend')<span class="text-danger">*</span></label>
                                                <div class="col-sm-8">
                                                    <input class="form-control" maxlength="30" type="text" id="statement_legend" name="statement_legend" value="{{ old('statement_legend') ? : $settings->statement_legend }}" valida="SI" cadena ="{{__('sistema.configuration.required.statement_legend')}}"/>
                                                </div>
                                            </div>
                                            <div class="form-group row" id="inputstatement_legend_color">
                                                <label class="col-sm-4 form-control-label">@lang('sistema.configuration.statement_legend_color')<span class="text-danger">*</span></label>
                                                <div id="legend_color_picker" class="col-sm-8 input-group colorpicker-component">
                                                    <input type="text" name="statement_legend_color" id="statement_legend_color" class="form-control" value="{{ old('statement_legend_color') ? : $settings->statement_legend_color }}" valida="SI" cadena ="{{__('sistema.configuration.required.statement_legend_color')}}"/>
                                                    <span class="input-group-addon"><i></i></span>
                                                </div>
                                                <!--<input class="form-control" value="" type="text" name="" id="legend_color_picker"/>-->
                                            </div>
                                            <div class="form-group row" id="inputtemplate_id">
                                                <label class="col-sm-4 form-control-label">@lang('sistema.configuration.template')<span class="text-danger">*</span></label>
                                                <div class="col-sm-8">
                                                    <select class="form-control" name="template_id" id="template_id" valida="SI" cadena ="{{__('sistema.configuration.required.template')}}">
                                                        <option value="1">Template 1</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row" id="inputdisclaimer_es" style="margin-bottom: 0;">
                                                <label class="col-sm-4 form-control-label">@lang('sistema.configuration.disclaimer_es')<span class="text-danger">*</span></label>
                                                <div class="col-sm-12">
                                                    <textarea class="form-control summernote" name="disclaimer_es" id="disclaimer_es" style="resize: vertical;" valida="SI" cadena ="{{__('sistema.configuration.required.disclaimer_es')}}">{{ old('disclaimer_es') ? : $settings->disclaimer_es }}</textarea>
                                                </div>
                                            </div>
                                            <div class="form-group row" id="inputdisclaimer_en" style="margin-bottom: 0;">
                                                <label class="col-sm-4 form-control-label">@lang('sistema.configuration.disclaimer_en')<span class="text-danger">*</span></label>
                                                <div class="col-sm-12">
                                                    <textarea class="form-control summernote" name="disclaimer_en" id="disclaimer_en" style="resize: vertical;" valida="SI" cadena ="{{__('sistema.configuration.required.disclaimer_en')}}">{{ old('disclaimer_en') ? : $settings->disclaimer_en }}</textarea>
                                                </div>
                                            </div>
                                            <hr>                                            
                                            <div class="form-group row" id="inputmenu_orientation" >
                                                <label class="col-sm-4 form-control-label">@lang('sistema.configuration.menu_orientation')<span class="text-danger">*</span></label>
                                                <div class="col-sm-8">
                                                    <div class="custom-control custom-radio custom-control-inline mb-2">
                                                        <input type="radio" id="menu_orientation_vertical" name="menu_orientation" value="vertical" class="custom-control-input" {{ $settings->menu_orientation == 'vertical' ? 'checked' : '' }}>
                                                        <label class="custom-control-label" for="menu_orientation_vertical">Vertical</label>
                                                    </div>
                                                    <div class="custom-control custom-radio custom-control-inline mb-2">
                                                        <input type="radio" id="menu_orientation_horizontal" name="menu_orientation" value="horizontal" class="custom-control-input" {{ $settings->menu_orientation == 'horizontal' ? 'checked' : '' }}>
                                                        <label class="custom-control-label" for="menu_orientation_horizontal">Horizontal</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row paddingTenTb" id="inputbrand_color_primary" >
                                                <label class="col-sm-4 form-control-label padding-top-ten">@lang('sistema.configuration.brand_color_primary')<span class="text-danger">*</span></label>
                                                <div class="col-sm-8">     
                                                    <div data-color-format="rgb" data-color="{{ $settings->brand_color_primary }}" class="colorpicker-default input-group">
                                                        <input type="text" value="" name="brand_color_primary" id="brand_color_primary" class="form-control color_input">
                                                        <span class="input-group-append add-on color_button">
                                                            <button class="btn btn-white" type="button">
                                                                <i style="background-color: {{ $settings->brand_color_primary }};margin-top: 2px;"></i>
                                                            </button>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row paddingTenTb" id="inputbrand_color_seconday" >
                                                <label class="col-sm-4 form-control-label padding-top-ten">@lang('sistema.configuration.brand_color_seconday')<span class="text-danger">*</span></label>
                                                <div class="col-sm-8">
                                                    <div data-color-format="rgb" data-color="{{ $settings->brand_color_seconday }}" class="colorpicker-default input-group">
                                                        <input type="text"  value="" name="brand_color_seconday" id="brand_color_seconday" class="form-control color_input">
                                                        <span class="input-group-append add-on color_button">
                                                            <button class="btn btn-white" type="button">
                                                                <i style="background-color: {{ $settings->brand_color_seconday }};margin-top: 2px;"></i>
                                                            </button>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row paddingTenTb" id="inputfont_color_primary" >
                                                <label class="col-sm-4 form-control-label padding-top-ten">@lang('sistema.configuration.font_color_primary')<span class="text-danger">*</span></label>
                                                <div class="col-sm-8">
                                                    <div data-color-format="rgb" data-color="{{ $settings->font_color_primary }}" class="colorpicker-default input-group">
                                                        <input type="text" value="" name="font_color_primary" id="font_color_primary" class="form-control color_input">
                                                        <span class="input-group-append add-on color_button">
                                                            <button class="btn btn-white" type="button">
                                                                <i style="background-color: {{ $settings->font_color_primary }};margin-top: 2px;"></i>
                                                            </button>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row paddingTenTb" id="inputfont_color_secondary" >
                                                <label class="col-sm-4 form-control-label padding-top-ten">@lang('sistema.configuration.font_color_secondary')<span class="text-danger">*</span></label>
                                                <div class="col-sm-8">
                                                    <div data-color-format="rgb" data-color="{{ $settings->font_color_secondary }}" class="colorpicker-default input-group">
                                                        <input type="text" value="" name="font_color_secondary" id="font_color_secondary" class="form-control color_input">
                                                        <span class="input-group-append add-on color_button">
                                                            <button class="btn btn-white" type="button">
                                                                <i style="background-color: {{ $settings->font_color_secondary }};margin-top: 2px;"></i>
                                                            </button>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="form-group row" id="inputfooter_privacy_policy_es" >
                                                <label class="col-sm-12 form-control-label">@lang('sistema.configuration.footer_privacy_policy_es')<span class="text-danger">*</span></label>
                                                <div class="col-sm-12">     
                                                    <textarea class="form-control summernote" name="footer_privacy_policy_es" id="footer_privacy_policy_es" style="resize: vertical;" valida="SI" cadena ="{{__('sistema.configuration.required.footer_privacy_policy_es')}}">{{ old('footer_privacy_policy_es') ? : $settings->footer_privacy_policy_es }}</textarea>
                                                </div>
                                            </div>                                           
                                            <div class="form-group row" id="inputfooter_privacy_policy_en" >
                                                <label class="col-sm-12 form-control-label">@lang('sistema.configuration.footer_privacy_policy_en')<span class="text-danger">*</span></label>
                                                <div class="col-sm-12">     
                                                    <textarea class="form-control summernote" name="footer_privacy_policy_en" id="footer_privacy_policy_en" style="resize: vertical;" valida="SI" cadena ="{{__('sistema.configuration.required.footer_privacy_policy_en')}}">{{ old('footer_privacy_policy_en') ? : $settings->footer_privacy_policy_en }}</textarea>
                                                </div>
                                            </div>                                           
                                            <div class="form-group row" id="inputfooter_tnc_es" >
                                                <label class="col-sm-12 form-control-label">@lang('sistema.configuration.footer_tnc_es')<span class="text-danger">*</span></label>
                                                <div class="col-sm-12">
                                                    <textarea class="form-control summernote" name="footer_tnc_es" id="footer_tnc_es" style="resize: vertical;" valida="SI" cadena ="{{__('sistema.configuration.required.footer_tnc_es')}}">{{ old('footer_tnc_es') ? : $settings->footer_tnc_es }}</textarea>
                                                </div>
                                            </div>
                                            <div class="form-group row" id="inputfooter_tnc_en" >
                                                <label class="col-sm-12 form-control-label">@lang('sistema.configuration.footer_tnc_en')<span class="text-danger">*</span></label>
                                                <div class="col-sm-12">
                                                    <textarea class="form-control summernote" name="footer_tnc_en" id="footer_tnc_en" style="resize: vertical;" valida="SI" cadena ="{{__('sistema.configuration.required.footer_tnc_en')}}">{{ old('footer_tnc_en') ? : $settings->footer_tnc_en }}</textarea>
                                                </div>
                                            </div>
                                            <div class="form-group row" id="inputfooter_privacy_notice_es" >
                                                <label class="col-sm-12 form-control-label">@lang('sistema.configuration.footer_privacy_notice_es')<span class="text-danger">*</span></label>
                                                <div class="col-sm-12">
                                                    <textarea class="form-control summernote" name="footer_privacy_notice_es" id="footer_privacy_notice_es" style="resize: vertical;" valida="SI" cadena ="{{__('sistema.configuration.required.footer_privacy_notice_es')}}">{{ old('footer_privacy_notice_es') ? : $settings->footer_privacy_notice_es }}</textarea>
                                                </div>
                                            </div>
                                            <div class="form-group row" id="inputfooter_privacy_notice_en" >
                                                <label class="col-sm-12 form-control-label">@lang('sistema.configuration.footer_privacy_notice_en')<span class="text-danger">*</span></label>
                                                <div class="col-sm-12">
                                                    <textarea class="form-control summernote" name="footer_privacy_notice_en" id="footer_privacy_notice_en" style="resize: vertical;" valida="SI" cadena ="{{__('sistema.configuration.required.footer_privacy_notice_en')}}">{{ old('footer_privacy_notice_en') ? : $settings->footer_privacy_notice_en }}</textarea>
                                                </div>
                                            </div>
                                            <div class="form-group row" id="inputinternational_transfer_disclaimer_es" >
                                                <label class="col-sm-12 form-control-label">@lang('sistema.configuration.international_transfer_disclaimer_es')<span class="text-danger">*</span></label>
                                                <div class="col-sm-12">
                                                    <textarea class="form-control summernote" name="international_transfer_disclaimer_es" id="international_transfer_disclaimer_es" style="resize: vertical;" valida="SI" cadena ="{{__('sistema.configuration.required.international_transfer_disclaimer_es')}}">{{ old('international_transfer_disclaimer_es') ? : $settings->international_transfer_disclaimer_es }}</textarea>
                                                </div>
                                            </div>
                                            <div class="form-group row" id="inputinternational_transfer_disclaimer_en" >
                                                <label class="col-sm-12 form-control-label">@lang('sistema.configuration.international_transfer_disclaimer_en')<span class="text-danger">*</span></label>
                                                <div class="col-sm-12">
                                                    <textarea class="form-control summernote" name="international_transfer_disclaimer_en" id="international_transfer_disclaimer_en" style="resize: vertical;" valida="SI" cadena ="{{__('sistema.configuration.required.international_transfer_disclaimer_en')}}">{{ old('international_transfer_disclaimer_en') ? : $settings->international_transfer_disclaimer_en }}</textarea>
                                                </div>
                                            </div>
                                            <div class="form-group row" id="inputfinancing_request_disclaimer_es" >
                                                <label class="col-sm-12 form-control-label">@lang('sistema.configuration.financing_request_disclaimer_es')<span class="text-danger">*</span></label>
                                                <div class="col-sm-12">
                                                    <textarea class="form-control summernote" name="financing_request_disclaimer_es" id="financing_request_disclaimer_es" style="resize: vertical;" valida="SI" cadena ="{{__('sistema.configuration.required.financing_request_disclaimer_es')}}">{{ old('financing_request_disclaimer_es') ? : $settings->financing_request_disclaimer_es }}</textarea>
                                                </div>
                                            </div>
                                            <div class="form-group row" id="inputfinancing_request_disclaimer_en" >
                                                <label class="col-sm-12 form-control-label">@lang('sistema.configuration.financing_request_disclaimer_en')<span class="text-danger">*</span></label>
                                                <div class="col-sm-12">
                                                    <textarea class="form-control summernote" name="financing_request_disclaimer_en" id="financing_request_disclaimer_en" style="resize: vertical;" valida="SI" cadena ="{{__('sistema.configuration.required.financing_request_disclaimer_en')}}">{{ old('financing_request_disclaimer_en') ? : $settings->financing_request_disclaimer_en }}</textarea>
                                                </div>
                                            </div>
                                            <div class="form-group row" id="inputfinancing_request_tnc_es" >
                                                <label class="col-sm-12 form-control-label">@lang('sistema.configuration.financing_request_tnc_es')<span class="text-danger">*</span></label>
                                                <div class="col-sm-12">
                                                    <textarea class="form-control summernote" name="financing_request_tnc_es" id="financing_request_tnc_es" style="resize: vertical;" valida="SI" cadena ="{{__('sistema.configuration.required.financing_request_tnc_es')}}">{{ old('financing_request_tnc_es') ? : $settings->financing_request_tnc_es }}</textarea>
                                                </div>
                                            </div>
                                            <div class="form-group row" id="inputfinancing_request_tnc_en" >
                                                <label class="col-sm-12 form-control-label">@lang('sistema.configuration.financing_request_tnc_en')<span class="text-danger">*</span></label>
                                                <div class="col-sm-12">
                                                    <textarea class="form-control summernote" name="financing_request_tnc_en" id="financing_request_tnc_en" style="resize: vertical;" valida="SI" cadena ="{{__('sistema.configuration.required.financing_request_tnc_en')}}">{{ old('financing_request_tnc_en') ? : $settings->financing_request_tnc_en }}</textarea>
                                                </div>
                                            </div>
                                            <div class="form-group row" id="inputexpand_financing_disclaimer_es" >
                                                <label class="col-sm-12 form-control-label">@lang('sistema.configuration.expand_financing_disclaimer_es')<span class="text-danger">*</span></label>
                                                <div class="col-sm-12">
                                                    <textarea class="form-control summernote" name="expand_financing_disclaimer_es" id="expand_financing_disclaimer_es" style="resize: vertical;" valida="SI" cadena ="{{__('sistema.configuration.required.expand_financing_disclaimer_es')}}">{{ old('expand_financing_disclaimer_es') ? : $settings->expand_financing_disclaimer_es }}</textarea>
                                                </div>
                                            </div>
                                            <div class="form-group row" id="inputexpand_financing_disclaimer_en" >
                                                <label class="col-sm-12 form-control-label">@lang('sistema.configuration.expand_financing_disclaimer_en')<span class="text-danger">*</span></label>
                                                <div class="col-sm-12">
                                                    <textarea class="form-control summernote" name="expand_financing_disclaimer_en" id="expand_financing_disclaimer_en" style="resize: vertical;" valida="SI" cadena ="{{__('sistema.configuration.required.expand_financing_disclaimer_en')}}">{{ old('expand_financing_disclaimer_en') ? : $settings->expand_financing_disclaimer_en }}</textarea>
                                                </div>
                                            </div>
                                            <div class="form-group row" id="inputexpand_financing_tnc_es" >
                                                <label class="col-sm-12 form-control-label">@lang('sistema.configuration.expand_financing_tnc_es')<span class="text-danger">*</span></label>
                                                <div class="col-sm-12">
                                                    <textarea class="form-control summernote" name="expand_financing_tnc_es" id="expand_financing_tnc_es" style="resize: vertical;" valida="SI" cadena ="{{__('sistema.configuration.required.expand_financing_tnc_es')}}">{{ old('expand_financing_tnc_es') ? : $settings->expand_financing_tnc_es }}</textarea>
                                                </div>
                                            </div>
                                            <div class="form-group row" id="inputexpand_financing_tnc_en" >
                                                <label class="col-sm-12 form-control-label">@lang('sistema.configuration.expand_financing_tnc_en')<span class="text-danger">*</span></label>
                                                <div class="col-sm-12">
                                                    <textarea class="form-control summernote" name="expand_financing_tnc_en" id="expand_financing_tnc_en" style="resize: vertical;" valida="SI" cadena ="{{__('sistema.configuration.required.expand_financing_tnc_en')}}">{{ old('expand_financing_tnc_en') ? : $settings->expand_financing_tnc_en }}</textarea>
                                                </div>
                                            </div>
                                            <div class="form-group row" id="inputrefinancing_disclaimer_es" >
                                                <label class="col-sm-12 form-control-label">@lang('sistema.configuration.refinancing_disclaimer_es')<span class="text-danger">*</span></label>
                                                <div class="col-sm-12">
                                                    <textarea class="form-control summernote" name="refinancing_disclaimer_es" id="refinancing_disclaimer_es" style="resize: vertical;" valida="SI" cadena ="{{__('sistema.configuration.required.refinancing_disclaimer_es')}}">{{ old('refinancing_disclaimer_es') ? : $settings->refinancing_disclaimer_es }}</textarea>
                                                </div>
                                            </div>
                                            <div class="form-group row" id="inputrefinancing_disclaimer_en" >
                                                <label class="col-sm-12 form-control-label">@lang('sistema.configuration.refinancing_disclaimer_en')<span class="text-danger">*</span></label>
                                                <div class="col-sm-12">
                                                    <textarea class="form-control summernote" name="refinancing_disclaimer_en" id="refinancing_disclaimer_en" style="resize: vertical;" valida="SI" cadena ="{{__('sistema.configuration.required.refinancing_disclaimer_en')}}">{{ old('refinancing_disclaimer_en') ? : $settings->refinancing_disclaimer_en }}</textarea>
                                                </div>
                                            </div>
                                            <div class="form-group row" id="inputaccess_control_tnc_es" >
                                                <label class="col-sm-12 form-control-label">@lang('sistema.configuration.access_control_tnc_es')<span class="text-danger">*</span></label>
                                                <div class="col-sm-12">
                                                    <textarea class="form-control summernote" name="access_control_tnc_es" id="access_control_tnc_es" style="resize: vertical;" valida="SI" cadena ="{{__('sistema.configuration.required.access_control_tnc_es')}}">{{ old('access_control_tnc_es') ? : $settings->access_control_tnc_es }}</textarea>
                                                </div>
                                            </div>
                                            <div class="form-group row" id="inputaccess_control_tnc_en" >
                                                <label class="col-sm-12 form-control-label">@lang('sistema.configuration.access_control_tnc_en')<span class="text-danger">*</span></label>
                                                <div class="col-sm-12">
                                                    <textarea class="form-control summernote" name="access_control_tnc_en" id="access_control_tnc_en" style="resize: vertical;" valida="SI" cadena ="{{__('sistema.configuration.required.access_control_tnc_en')}}">{{ old('access_control_tnc_en') ? : $settings->access_control_tnc_en }}</textarea>
                                                </div>
                                            </div>
                                            <div class="form-group row" id="inputaccounts_administration_tnc_es" >
                                                <label class="col-sm-12 form-control-label">@lang('sistema.configuration.accounts_administration_tnc_es')<span class="text-danger">*</span></label>
                                                <div class="col-sm-12">
                                                    <textarea class="form-control summernote" name="accounts_administration_tnc_es" id="accounts_administration_tnc_es" style="resize: vertical;" valida="SI" cadena ="{{__('sistema.configuration.required.accounts_administration_tnc_es')}}">{{ old('accounts_administration_tnc_es') ? : $settings->accounts_administration_tnc_es }}</textarea>
                                                </div>
                                            </div>
                                            <div class="form-group row" id="inputaccounts_administration_tnc_en" >
                                                <label class="col-sm-12 form-control-label">@lang('sistema.configuration.accounts_administration_tnc_en')<span class="text-danger">*</span></label>
                                                <div class="col-sm-12">
                                                    <textarea class="form-control summernote" name="accounts_administration_tnc_en" id="accounts_administration_tnc_en" style="resize: vertical;" valida="SI" cadena ="{{__('sistema.configuration.required.accounts_administration_tnc_en')}}">{{ old('accounts_administration_tnc_en') ? : $settings->accounts_administration_tnc_en }}</textarea>
                                                </div>
                                            </div>
                                            <div class="form-group row" id="inputadjust_permission_tnc_es" >
                                                <label class="col-sm-12 form-control-label">@lang('sistema.configuration.adjust_permission_tnc_es')<span class="text-danger">*</span></label>
                                                <div class="col-sm-12">
                                                    <textarea class="form-control summernote" name="adjust_permission_tnc_es" id="adjust_permission_tnc_es" style="resize: vertical;" valida="SI" cadena ="{{__('sistema.configuration.required.adjust_permission_tnc_es')}}">{{ old('adjust_permission_tnc_es') ? : $settings->adjust_permission_tnc_es }}</textarea>
                                                </div>
                                            </div>
                                            <div class="form-group row" id="inputadjust_permission_tnc_en" >
                                                <label class="col-sm-12 form-control-label">@lang('sistema.configuration.adjust_permission_tnc_en')<span class="text-danger">*</span></label>
                                                <div class="col-sm-12">
                                                    <textarea class="form-control summernote" name="adjust_permission_tnc_en" id="adjust_permission_tnc_en" style="resize: vertical;" valida="SI" cadena ="{{__('sistema.configuration.required.adjust_permission_tnc_en')}}">{{ old('adjust_permission_tnc_en') ? : $settings->adjust_permission_tnc_en }}</textarea>
                                                </div>
                                            </div>
                                            <div class="form-group row" id="inputsend_documentation_disclaimer_es" >
                                                <label class="col-sm-12 form-control-label">@lang('sistema.configuration.send_documentation_disclaimer_es')<span class="text-danger">*</span></label>
                                                <div class="col-sm-12">
                                                    <textarea class="form-control summernote" name="send_documentation_disclaimer_es" id="send_documentation_disclaimer_es" style="resize: vertical;" valida="SI" cadena ="{{__('sistema.configuration.required.send_documentation_disclaimer_es')}}">{{ old('send_documentation_disclaimer_es') ? : $settings->send_documentation_disclaimer_es }}</textarea>
                                                </div>
                                            </div>
                                            <div class="form-group row" id="inputsend_documentation_disclaimer_en" >
                                                <label class="col-sm-12 form-control-label">@lang('sistema.configuration.send_documentation_disclaimer_en')<span class="text-danger">*</span></label>
                                                <div class="col-sm-12">
                                                    <textarea class="form-control summernote" name="send_documentation_disclaimer_en" id="send_documentation_disclaimer_en" style="resize: vertical;" valida="SI" cadena ="{{__('sistema.configuration.required.send_documentation_disclaimer_en')}}">{{ old('send_documentation_disclaimer_en') ? : $settings->send_documentation_disclaimer_en }}</textarea>
                                                </div>
                                            </div>
                                            <div class="form-group row" id="inputaccount_registration_disclaimer_es" >
                                                <label class="col-sm-12 form-control-label">@lang('sistema.configuration.account_registration_disclaimer_es')<span class="text-danger">*</span></label>
                                                <div class="col-sm-12">
                                                    <textarea class="form-control summernote" name="account_registration_disclaimer_es" id="account_registration_disclaimer_es" style="resize: vertical;" valida="SI" cadena ="{{__('sistema.configuration.required.account_registration_disclaimer_es')}}">{{ old('account_registration_disclaimer_es') ? : $settings->account_registration_disclaimer_es }}</textarea>
                                                </div>
                                            </div>                                            
                                            <div class="form-group row" id="inputaccount_registration_disclaimer_en" >
                                                <label class="col-sm-12 form-control-label">@lang('sistema.configuration.account_registration_disclaimer_en')<span class="text-danger">*</span></label>
                                                <div class="col-sm-12">
                                                    <textarea class="form-control summernote" name="account_registration_disclaimer_en" id="account_registration_disclaimer_en" style="resize: vertical;" valida="SI" cadena ="{{__('sistema.configuration.required.account_registration_disclaimer_en')}}">{{ old('account_registration_disclaimer_en') ? : $settings->account_registration_disclaimer_en }}</textarea>
                                                </div>
                                            </div>                                            
                                            <div class="form-group m-b-0">
                                                <div class="col-sm-12 text-right">
                                                    <a href="{{url('brands')}}" class="btn btn-danger waves-effect waves-light">@lang('sistema.btn_back')</a>
                                                    <button type="submit" class="btn btn-info waves-effect waves-light">@lang('sistema.btn_save')</button>
                                                </div>
                                            </div>
                                        </fieldset>
                                    </div>
                                    <div class="col-lg-4" style="margin-top: 12px;">
                                        <div class="form-group row">                                
                                            <div class="col-sm-8">
                                                <img id="img_cat" style="width: 100%; border: 1px solid #ccc;" src="{{ $settings && $settings->company_statement_logo ? asset($settings->company_statement_logo) : asset(env('APP_ROOT').'/assets/images/no_image.png') }}" class="img-responsive"/>
                                                @if($settings && $settings->company_statement_logo)                                                
                                                <a href="javascript:void(0)" class="fa fa-times text-danger btnRemoveTempImg">{{  __("sistema.btn_delete") }}</a>
                                                @endif
                                            </div>
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
<script type="text/javascript" src="{{ url('assets/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js') }}"></script>
<script type="text/javascript" src="{{ url('assets/plugins/summernote/summernote-bs4.js') }}"></script>
<script type="text/javascript" src="{{ url('assets/plugins/filestyle/bootstrap-filestyle.min.js') }}"></script>
<script type="text/javascript" src="{{ url('assets/plugins/autoNumeric/autoNumeric.js') }}"></script>
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
    //Aqui deben de ir las secciones adicionales
    $(function() {
        $("#legend_color_picker, #legend_color_picker2, .color_picker").colorpicker({
            format: 'hex'
        });
        $('.colorpicker-default').colorpicker({
            format: 'hex'
        });
        $('.summernote').summernote({ height: 350 });
        $(".glyphicon-folder-open").remove();
        $('.autonumber').autoNumeric('init', {
            vMax: 99999.99,
            mDec: '2',
            aPad: 7
        });
        $('.autonumber2').autoNumeric('init', {
            vMax: 100.00,
            mDec: '2',
            aPad: 7
        });
    });
    
    var textarea_arr = ['disclaimer','footer_privacy_policy', 'footer_tnc', 'footer_privacy_notice', 
        'international_transfer_disclaimer', 'financing_request_disclaimer',
        'financing_request_tnc','expand_financing_disclaimer','expand_financing_tnc',
        'refinancing_disclaimer','access_control_tnc','accounts_administration_tnc',
        'adjust_permission_tnc', 'send_documentation_disclaimer', 'account_registration_disclaimer'];    
    
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
            
            if($(this).attr('id') == 'company_statement_logo')
            {
                if($(this).val() == '')
                {
                    $(this).next().addClass('has-error');
                }
                else
                {
                    $(this).next().removeClass('has-error');
                }
            }
            
            if(textarea_arr.includes($(this).attr('id')))
            {
                if ($(this).val() == '')
                {
                    $(this).next().addClass('has-error');
                }
                else
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
                    $('.btnRemoveTempImg').remove();
                    $('#img_cat').attr('src', e.target.result).after('<a href="javascript:void(0)" class="fa fa-times text-danger btnRemoveTempImg">'+ '{{  __("sistema.btn_delete") }}' +'</a>');
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