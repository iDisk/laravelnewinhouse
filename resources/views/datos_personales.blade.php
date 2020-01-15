@extends('layouts.front_vertical_menu')
@section('customcss')
<link href="{{ url('assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet">
<style type="text/css">
    b {
        font-weight: 600;
    }
    .checkbox label, .radio label {
        margin-bottom: 5px !important;
        margin-top: 5px !important;
    }
    .checkbox label.p-l-0, .radio label.p-l-0 {
        padding-left: 0 !important;
    }
    sup {
        font-size: 12px;
        top: 0px;
        left: 2px;
    }
    .verification_head {
        font-size: 15px;
    }
    .verification_head span {
        text-transform: uppercase;
    }
    .verification_head .title {
        font-weight: bold;
    }
    .verification_box {
        border: 1px solid #2d2d2d;
        margin-left: 0;
        margin-right: 0;
        padding: 10px 15px 20px 15px;
    }
    .editData {
        display: none;
    }
    .btn-danger.removeBeneficiary {
        margin-bottom: 2px;
    }
    @media (min-width: 1200px) {
        
    }
    @media (min-width: 992px) and (max-width: 1199px) {
        
    }
    @media (min-width: 768px) and (max-width: 991px) {
        
    }
    @media (min-width: 576px) and (max-width: 767px) {
        
    }
    @media (max-width: 575px) {
        
    }
</style>
@endsection

@section('pagecontent')
    <div class="container-fluid">
        <input type="hidden" id="_token" value="{{ csrf_token() }}">
        <div class="row">
            <div class="col-xl-12">
                <div class="page-title-box text-xs-center text-sm-center text-md-center">
                    <h4 class="page-title">@lang('frontsistema.datos_personales.title')</h4>
                    <div class="web_logo">
                        <img class="" src="{{ url('assets/images/logo_espacios.png')}}" alt="" height="50">
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
        <div id="personal_data_div">
            <form id="personal-data-form" name="personal-data-form">
                <div class="row">
                    <div class="col-xl-12 p-l-xs-30">
                        <div class="row">
                            <div class="col-xl-12 text-right">
                                <a class="btn btn-aqua-blue waves-effect waves-light cursor-pointer font-18 actualData" id="enableEdit" href="javascript:void(0)"><span class="mdi mdi-lead-pencil"></span>&nbsp;@lang('frontsistema.datos_personales.edit_title')</a>
                                <a class="btn btn-aqua-blue waves-effect waves-light cursor-pointer font-18 editData" id="disableEdit" href="javascript:void(0)"><span class=" mdi mdi-window-close"></span>&nbsp;@lang('frontsistema.datos_personales.cancel_edit_title')</a>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-12 col-lg-12">
                                @if($account->account_type == 'business')
                                    <div class="row m-t-20 m-b-20 on_load verification_head verification_box">
                                        <div class="col-xl-12 text-left m-t-10">
                                            <span class="title font-18">
                                                @lang('sistema.client.entity_detail')
                                            </span>
                                        </div>
                                        <div class="col-xl-6 col-lg-6 text-left m-t-10">
                                            <span class="title">
                                                @lang('sistema.client.registered_name')<span class="actualData">:</span><span class="editData"><sup>*</sup></span>
                                            </span>
                                            <span class="actualData">
                                                {{ ($business_detail->registered_name) ? $business_detail->registered_name : "-" }}
                                            </span>
                                            <div class="editData">
                                                <input type="text" class="form-control input-black" name="business_detail[registered_name]" placeholder="{{__('sistema.client.registered_name')}}" required value="{{ $business_detail->registered_name }}" data-parsley-trigger="change" data-parsley-chars="" />
                                                <div class="form-error">@lang('frontsistema.datos_personales.registered_name_error')</div>
                                            </div>
                                        </div>
                                        <div class="col-xl-6 col-lg-6 text-left m-t-10">
                                            <span class="title">
                                                @lang('sistema.client.type_of_entity')<span class="actualData">:</span><span class="editData"><sup>*</sup></span>
                                            </span>
                                            <span class="actualData">
                                                {{ ($business_detail->business_type) ? $business_detail->business_type : '-' }}
                                            </span>
                                            <div class="editData">
                                                <input type="text" class="form-control input-black" name="business_detail[business_type]" placeholder="{{__('sistema.client.type_of_entity')}}" required value="{{ $business_detail->business_type }}" data-parsley-trigger="change" data-parsley-chars="" />
                                                <div class="form-error">@lang('frontsistema.datos_personales.type_entity_error')</div>
                                            </div>
                                        </div>
                                        <div class="col-xl-6 col-lg-6 text-left m-t-10">
                                            <span class="title">
                                                @lang('sistema.client.authorised_signatories1')<span class="actualData">:</span><span class="editData"><sup>*</sup></span>
                                            </span>
                                            <span class="actualData">
                                                {{ ($business_detail->authorised_signatories1) ? $business_detail->authorised_signatories1 : '-' }}
                                            </span>
                                            <div class="editData">
                                                <input type="text" class="form-control input-black" name="business_detail[authorised_signatories1]" placeholder="{{__('sistema.client.authorised_signatories1')}}" required value="{{ $business_detail->authorised_signatories1 }}" data-parsley-trigger="change" data-parsley-chars="" />
                                                <div class="form-error">@lang('frontsistema.datos_personales.auth_signatory_error')</div>
                                            </div>
                                        </div>
                                        <div class="col-xl-6 col-lg-6 text-left m-t-10">
                                            <span class="title">
                                                @lang('sistema.client.authorised_signatories2')<span class="actualData">:</span><span class="editData"><sup>*</sup></span>
                                            </span>
                                            <span class="actualData">
                                                {{ ($business_detail->authorised_signatories2) ? $business_detail->authorised_signatories2 : '-' }}
                                            </span>
                                            <div class="editData">
                                                <input type="text" class="form-control input-black" name="business_detail[authorised_signatories2]" placeholder="{{__('sistema.client.authorised_signatories2')}}" required value="{{ $business_detail->authorised_signatories2 }}" data-parsley-trigger="change" data-parsley-chars="" />
                                                <div class="form-error">@lang('frontsistema.datos_personales.auth_signatory_error')</div>
                                            </div>
                                        </div>
                                        <div class="col-xl-6 col-lg-6 text-left m-t-10">
                                            <span class="title">
                                                @lang('sistema.client.registration_number')<span class="actualData">:</span><span class="editData"><sup>*</sup></span>
                                            </span>
                                            <span class="actualData">
                                                {{ ($business_detail->registration_number) ? $business_detail->registration_number : '-' }}
                                            </span>
                                            <div class="editData">
                                                <input type="text" class="form-control input-black" name="business_detail[registration_number]" placeholder="{{__('sistema.client.registration_number')}}" required value="{{ $business_detail->registration_number }}" data-parsley-trigger="change" data-parsley-type="alphanum" />
                                                <div class="form-error">@lang('frontsistema.datos_personales.registration_no_err')</div>
                                            </div>
                                        </div>
                                        <div class="col-xl-6 col-lg-6 text-left m-t-10">
                                            <span class="title">
                                                @lang('sistema.client.incorporation_date')<span class="actualData">:</span><span class="editData"><sup>*</sup></span>
                                            </span>
                                            <span class="actualData">
                                                {{ \Carbon\Carbon::parse($business_detail->incorporation_date)->format('d/m/Y') }}
                                            </span>
                                            <div class="editData">
                                                <input type="text" class="form-control input-black" name="business_detail[incorporation_date]" onkeydown="return false" autocomplete="off" id="incorporation_date" placeholder="{{__('sistema.client.incorporation_date')}}" required value="{{ \Carbon\Carbon::parse($business_detail->incorporation_date)->format('d/m/Y') }}" data-parsley-trigger="change" />
                                                <div class="form-error">@lang('sistema.client.incorporation_date_valid')</div>
                                            </div>
                                        </div>
                                        <div class="col-xl-6 col-lg-6 text-left m-t-10">
                                            <span class="title">
                                                @lang('sistema.client.incorporation_place')<span class="actualData">:</span><span class="editData"><sup>*</sup></span>
                                            </span>
                                            <span class="actualData">
                                                {{ ($business_detail->incorporation_place) ? $business_detail->incorporation_place : '-' }}
                                            </span>
                                            <div class="editData">
                                                <input type="text" class="form-control input-black" name="business_detail[incorporation_place]" placeholder="{{__('sistema.client.incorporation_place')}}" required value="{{ $business_detail->incorporation_place }}" data-parsley-trigger="change" data-parsley-chars="" />
                                                <div class="form-error">@lang('frontsistema.datos_personales.incorporation_plac_er')</div>
                                            </div>
                                        </div>
                                        <div class="col-xl-6 col-lg-6 text-left m-t-10">
                                            <span class="title">
                                                @lang('sistema.client.entity_country')<span class="actualData">:</span><span class="editData"><sup>*</sup></span>
                                            </span>
                                            <span class="actualData">
                                                @foreach($countries as $country)
                                                    {{ ($business_detail->country == $country->id) ? $country->name : ''}}
                                                @endforeach
                                            </span>
                                            <div class="editData">
                                                <select class="form-control input-black" name="business_detail[country]" data-parsley-trigger="change" required>
                                                    <option value="">@lang('sistema.btn_select')</option>
                                                    @foreach($countries as $country)
                                                    <option data-value="{{ $country->id }}" value="{{ $country->name }}" {{ ($business_detail->country == $country->id)?'selected':''}}>{{ $country->name }}</option>
                                                    @endforeach
                                                </select>
                                                <div class="form-error">@lang('frontsistema.datos_personales.country_error')</div>
                                            </div>
                                        </div>
                                        <div class="col-xl-6 col-lg-6 text-left m-t-10">
                                            <span class="title">
                                                @lang('sistema.client.entity_state')<span class="actualData">:</span><span class="editData"><sup>*</sup></span>
                                            </span>
                                            <span class="actualData">
                                                {{ ($business_detail->state_name) ? $business_detail->state_name : '-' }}
                                            </span>
                                            <div class="editData">
                                                <input type="text" class="form-control input-black" name="business_detail[state]" placeholder="{{__('sistema.client.entity_state')}}" required value="{{ ($business_detail->state_name) ? $business_detail->state_name : '' }}" data-parsley-trigger="change" data-parsley-chars="" />
                                                <div class="form-error">@lang('frontsistema.datos_personales.state_error')</div>
                                            </div>
                                        </div>
                                        <div class="col-xl-6 col-lg-6 text-left m-t-10">
                                            <span class="title">
                                                @lang('sistema.client.entity_city')<span class="actualData">:</span><span class="editData"><sup>*</sup></span>
                                            </span>
                                            <span class="actualData">
                                                {{ ($business_detail->city_name) ? $business_detail->city_name : '-' }}
                                            </span>
                                            <div class="editData">
                                                <input type="text" class="form-control input-black" name="business_detail[city]" placeholder="{{__('sistema.client.entity_city')}}" required value="{{ ($business_detail->city_name) ? $business_detail->city_name : '' }}" data-parsley-trigger="change" data-parsley-chars="" />
                                                <div class="form-error">@lang('frontsistema.datos_personales.city_error')</div>
                                            </div>
                                        </div>
                                        <div class="col-xl-6 col-lg-6 text-left m-t-10">
                                            <span class="title">
                                                @lang('sistema.client.entity_address')<span class="actualData">:</span><span class="editData"><sup>*</sup></span>
                                            </span>
                                            <span class="actualData">
                                                {{ (($business_detail->address) ? $business_detail->address : '-') }}
                                            </span>
                                            <div class="editData">
                                                <input type="text" class="form-control input-black" name="business_detail[address]" placeholder="{{__('sistema.client.entity_address')}}" required value="{{ $business_detail->address }}" data-parsley-trigger="change" />
                                                <div class="form-error">@lang('frontsistema.datos_personales.address_error')</div>
                                            </div>
                                        </div>
                                        <div class="col-xl-6 col-lg-6 text-left m-t-10">
                                            <span class="title">
                                                @lang('sistema.client.entity_county')<span class="actualData">:</span><span class="editData"><sup>*</sup></span>
                                            </span>
                                            <span class="actualData">
                                                {{ ($business_detail->county) ? $business_detail->county : '-' }}
                                            </span>
                                            <div class="editData">
                                                <input type="text" class="form-control input-black" name="business_detail[county]" placeholder="{{__('sistema.client.entity_county')}}" required value="{{ $business_detail->county }}" data-parsley-trigger="change" data-parsley-chars="" />
                                                <div class="form-error">@lang('frontsistema.datos_personales.county_error')</div>
                                            </div>
                                        </div>
                                        <div class="col-xl-6 col-lg-6 text-left m-t-10">
                                            <span class="title">
                                                @lang('sistema.client.entity_zip_code')<span class="actualData">:</span><span class="editData"><sup>*</sup></span>
                                            </span>
                                            <span class="actualData">
                                                {{ ($business_detail->zip_code) ? $business_detail->zip_code : '-' }}
                                            </span>
                                            <div class="editData">
                                                <input type="text" class="form-control input-black" name="business_detail[zip_code]" placeholder="{{__('sistema.client.entity_zip_code')}}" required value="{{ $business_detail->zip_code }}" data-parsley-trigger="change" min="0" data-parsley-type="digits" />
                                                <div class="form-error">@lang('frontsistema.datos_personales.zip_code_error')</div>
                                            </div>
                                        </div>
                                        <div class="col-xl-6 col-lg-6 text-left m-t-10">
                                            <span class="title">
                                                @lang('sistema.branches.branches')<span class="actualData">:</span><span class="editData"><sup>*</sup></span>
                                            </span>
                                            <span class="actualData">
                                                @if(isset($branches) && count($branches)>0)
                                                    @foreach($branches as $branch_id => $branch_name)
                                                    {{ ($business_detail->branch_id == $branch_id) ? $branch_name : '' }}
                                                    @endforeach
                                                @else
                                                -
                                                @endif
                                            </span>
                                            <div class="editData">
                                                <select class="form-control input-black" name="business_detail[branch]" data-parsley-trigger="change" required>
                                                    <option value="">@lang('sistema.branches.select_branch')</option>
                                                    @if(isset($branches) && count($branches)>0)
                                                    @foreach($branches as $branch_id => $branch_name)
                                                    <option data-value="{{ $branch_id }}" value="{{ $branch_name }}" {{ $business_detail->branch_id == $branch_id ? 'selected' : '' }}>{{ $branch_name }}</option>
                                                    @endforeach
                                                    @endif
                                                </select>
                                                <div class="form-error">@lang('frontsistema.datos_personales.branch_error')</div>
                                            </div>
                                        </div>
                                        <div class="col-xl-6 col-lg-6 text-left m-t-10">
                                            <span class="title">
                                                @lang('sistema.client.entity_industry_type')<span class="actualData">:</span>
                                            </span>
                                            <span class="actualData">
                                                {{ ($business_detail->industry_type) ? $business_detail->industry_type : '-' }}
                                            </span>
                                            <div class="editData">
                                                <input type="text" class="form-control input-black" name="business_detail[industry_type]" placeholder="{{__('sistema.client.entity_industry_type')}}" value="{{ $business_detail->industry_type }}" data-parsley-trigger="change" data-parsley-chars="" />
                                                <div class="form-error">@lang('frontsistema.datos_personales.industry_type_error')</div>
                                            </div>
                                        </div>
                                        <div class="col-xl-6 col-lg-6 text-left m-t-10">
                                            <span class="title">
                                                @lang('sistema.client.entity_employees')<span class="actualData">:</span>
                                            </span>
                                            <span class="actualData">
                                                {{ ($business_detail->employees) ? $business_detail->employees : '-' }}
                                            </span>
                                            <div class="editData">
                                                <input type="text" class="form-control input-black" name="business_detail[employees]" placeholder="{{__('sistema.client.entity_employees')}}" value="{{ $business_detail->employees }}" data-parsley-trigger="change" min="0" data-parsley-type="digits" />
                                                <div class="form-error">@lang('frontsistema.datos_personales.employee_no_error')</div>
                                            </div>
                                        </div>
                                        <div class="col-xl-6 col-lg-6 text-left m-t-10">
                                            <span class="title">
                                                @lang('sistema.client.entity_webiste')<span class="actualData">:</span>
                                            </span>
                                            <span class="actualData">
                                                {{ ($business_detail->webiste) ? $business_detail->webiste : '-' }}
                                            </span>
                                            <div class="editData">
                                                <input type="url" class="form-control input-black" name="business_detail[webiste]" placeholder="{{__('sistema.client.entity_webiste')}}" value="{{ $business_detail->webiste }}" data-parsley-trigger="change" data-parsley-type="url" />
                                                <div class="form-error">@lang('frontsistema.datos_personales.website_error')</div>
                                            </div>
                                        </div>
                                        <div class="col-xl-6 col-lg-6 text-left m-t-10">
                                            <span class="title">
                                                @lang('sistema.client.entity_telephone1')<span class="actualData">:</span><span class="editData"><sup>*</sup></span>
                                            </span>
                                            <span class="actualData">
                                                {{ ($business_detail->telephone1) ? $business_detail->telephone1 : '-' }}
                                            </span>
                                            <div class="editData">
                                                <input type="text" class="form-control input-black" required name="business_detail[telephone1]" placeholder="{{__('sistema.client.entity_telephone1')}}" value="{{ $business_detail->telephone1 }}" data-parsley-trigger="change" data-parsley-tel="" />
                                                <div class="form-error">@lang('frontsistema.datos_personales.telephone_error')</div>
                                            </div>
                                        </div>
                                        <div class="col-xl-6 col-lg-6 text-left m-t-10">
                                            <span class="title">
                                                @lang('sistema.client.entity_telephone2')<span class="actualData">:</span>
                                            </span>
                                            <span class="actualData">
                                                {{ ($business_detail->telephone2) ? $business_detail->telephone2 : '-' }}
                                            </span>
                                            <div class="editData">
                                                <input type="text" class="form-control input-black" name="business_detail[telephone2]" placeholder="{{__('sistema.client.entity_telephone2')}}" value="{{ $business_detail->telephone2 }}" data-parsley-trigger="change" data-parsley-tel="" />
                                                <div class="form-error">@lang('frontsistema.datos_personales.telephone_error')</div>
                                            </div>
                                        </div>
                                        <div class="col-xl-6 col-lg-6 text-left m-t-10">
                                            <span class="title">
                                                @lang('sistema.client.entity_telephone3')<span class="actualData">:</span>
                                            </span>
                                            <span class="actualData">
                                                {{ ($business_detail->telephone3) ? $business_detail->telephone3 : '-' }}
                                            </span>
                                            <div class="editData">
                                                <input type="text" class="form-control input-black" name="business_detail[telephone3]" placeholder="{{__('sistema.client.entity_telephone3')}}" value="{{ $business_detail->telephone3 }}" data-parsley-trigger="change" data-parsley-tel="" />
                                                <div class="form-error">@lang('frontsistema.datos_personales.telephone_error')</div>
                                            </div>
                                        </div>
                                        <div class="col-xl-6 col-lg-6 text-left m-t-10">
                                            <span class="title">
                                                @lang('sistema.client.entity_email1')<span class="actualData">:</span><span class="editData"><sup>*</sup></span>
                                            </span>
                                            <span class="actualData">
                                                {{ ($business_detail->email1) ? $business_detail->email1 : '-' }}
                                            </span>
                                            <div class="editData">
                                                <input type="email" class="form-control input-black" name="business_detail[email1]" required placeholder="{{__('sistema.client.entity_email1')}}" value="{{ $business_detail->email1 }}" data-parsley-trigger="change" data-parsley-type="email" />
                                                <div class="form-error">@lang('frontsistema.datos_personales.email_error')</div>
                                            </div>
                                        </div>
                                        <div class="col-xl-6 col-lg-6 text-left m-t-10">
                                            <span class="title">
                                                @lang('sistema.client.entity_email2')<span class="actualData">:</span>
                                            </span>
                                            <span class="actualData">
                                                {{ ($business_detail->email2) ? $business_detail->email2 : '-' }}
                                            </span>
                                            <div class="editData">
                                                <input type="email" class="form-control input-black" name="business_detail[email2]" placeholder="{{__('sistema.client.entity_email2')}}" value="{{ $business_detail->email2 }}" data-parsley-trigger="change" data-parsley-type="email" />
                                                <div class="form-error">@lang('frontsistema.datos_personales.email_error')</div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                @if(count($account->clients) > 0)
                                    @php
                                        $i = 1; 
                                    @endphp
                                    @foreach($account->clients as $client)
                                    <div class="row m-t-20 m-b-20 on_load verification_head verification_box">
                                        <span class="subtitle" style="display: none;">@lang('frontsistema.datos_personales.client_label') {{$i}} - </span>
                                        <div class="col-xl-12 text-left m-t-10">
                                            <span class="title font-16">
                                                @lang('sistema.client.account_holder_information')
                                                @if(count($account->clients) > 1 )
                                                    {{ "(".$i.")" }}
                                                @endif
                                            </span>
                                        </div>
                                        <div class="col-xl-6 col-lg-6 text-left m-t-10">
                                            <span class="title">
                                                @lang('sistema.client.first_name')<span class="actualData">:</span><span class="editData"><sup>*</sup></span>
                                            </span>
                                            <span class="actualData">
                                                {{ ($client->first_name) ? $client->first_name : "-" }}
                                            </span>
                                            <div class="editData">
                                                <input type="text" class="form-control input-black" name="client[first_name][{{$i}}]" placeholder="{{__('sistema.client.first_name')}}" value="{{ $client->first_name }}" disabled />
                                                <div class="form-error">@lang('frontsistema.datos_personales.first_name_error')</div>
                                            </div>
                                        </div>
                                        <div class="col-xl-6 col-lg-6 text-left m-t-10">
                                            <span class="title">
                                                @lang('sistema.client.middle_name')<span class="actualData">:</span><span class="editData"><sup>*</sup></span>
                                            </span>
                                            <span class="actualData">
                                                {{ ($client->middle_name) ? $client->middle_name : "-" }}
                                            </span>
                                            <div class="editData">
                                                <input type="text" class="form-control input-black" name="client[middle_name][{{$i}}]" placeholder="{{__('sistema.client.middle_name')}}" value="{{ $client->middle_name }}" disabled />
                                                <div class="form-error">@lang('frontsistema.datos_personales.middle_name_error')</div>
                                            </div>
                                        </div>
                                        <div class="col-xl-6 col-lg-6 text-left m-t-10">
                                            <span class="title">
                                                @lang('sistema.client.surname1')<span class="actualData">:</span><span class="editData"><sup>*</sup></span>
                                            </span>
                                            <span class="actualData">
                                                {{ ($client->surname1) ? $client->surname1 : "-" }}
                                            </span>
                                            <div class="editData">
                                                <input type="text" class="form-control input-black" name="client[surname1][{{$i}}]" placeholder="{{__('sistema.client.surname1')}}" disabled value="{{ $client->surname1 }}" />
                                                <div class="form-error">@lang('frontsistema.datos_personales.surname_error')</div>
                                            </div>
                                        </div>
                                        <div class="col-xl-6 col-lg-6 text-left m-t-10">
                                            <span class="title">
                                                @lang('sistema.client.surname2')<span class="actualData">:</span><span class="editData"><sup>*</sup></span>
                                            </span>
                                            <span class="actualData">
                                                {{ ($client->surname2) ? $client->surname2 : "-" }}
                                            </span>
                                            <div class="editData">
                                                <input type="text" class="form-control input-black" name="client[surname2][{{$i}}]" placeholder="{{__('sistema.client.surname2')}}" value="{{ $client->surname2 }}" disabled />
                                                <div class="form-error">@lang('frontsistema.datos_personales.surname_error')</div>
                                            </div>
                                        </div>
                                        <div class="col-xl-6 col-lg-6 text-left m-t-10">
                                            <span class="title">
                                                @lang('sistema.client.dob')<span class="actualData">:</span><span class="editData"><sup>*</sup></span>
                                            </span>
                                            <span class="actualData">
                                                {{ \Carbon\Carbon::parse($client->dob)->format('d/m/Y') }}
                                            </span>
                                            <div class="editData">
                                                <input type="text" class="form-control input-black client_dob" name="client[dob][{{$i}}]" onkeydown="return false" autocomplete="off" id="client_dob" placeholder="{{__('sistema.client.dob')}}" required value="{{ \Carbon\Carbon::parse($client->dob)->format('d/m/Y') }}" data-parsley-trigger="change" />
                                            </div>
                                        </div>
                                        <div class="col-xl-6 col-lg-6 text-left m-t-10">
                                            <span class="title">
                                                @lang('sistema.client.gender')<span class="actualData">:</span><span class="editData"><sup>*</sup></span>
                                            </span>
                                            <span class="actualData">
                                                {{ ($client->gender == 'Male') ? __('sistema.client.male') : '' }}
                                                {{ ($client->gender == 'Female') ? __('sistema.client.female') : '' }}
                                            </span>
                                            <div class="editData">
                                                <select class="form-control input-black" name="client[gender][{{$i}}]" disabled>
                                                    <option value="">@lang('sistema.btn_select')</option>
                                                    <option value="Male" {{ ($client->gender == 'Male')? 'selected':'' }}>@lang('sistema.client.male')</option>
                                                    <option value="Female" {{ ($client->gender == 'Female')? 'selected':'' }}>@lang('sistema.client.female')</option>
                                                </select>
                                                <div class="form-error">@lang('frontsistema.datos_personales.gender_error')</div>
                                            </div>
                                        </div>
                                        <div class="col-xl-6 col-lg-6 text-left m-t-10">
                                            <span class="title">
                                                @lang('sistema.client.birth_place')<span class="actualData">:</span><span class="editData"><sup>*</sup></span>
                                            </span>
                                            <span class="actualData">
                                                {{ ($client->birth_place) ? $client->birth_place : "-" }}
                                            </span>
                                            <div class="editData">
                                                <input type="text" class="form-control input-black" name="client[birth_place][{{$i}}]" placeholder="{{__('sistema.client.birth_place')}}" required value="{{ $client->birth_place }}" data-parsley-trigger="change" data-parsley-chars="" />
                                                <div class="form-error">@lang('frontsistema.datos_personales.birthplace_error')</div>
                                            </div>
                                        </div>
                                        <div class="col-xl-6 col-lg-6 text-left m-t-10">
                                            <span class="title">
                                                @lang('sistema.client.birth_country')<span class="actualData">:</span><span class="editData"><sup>*</sup></span>
                                            </span>
                                            <span class="actualData">
                                                @foreach($countries as $country)
                                                    {{ ($client->birth_country == $country->id) ? $country->name : ''}}
                                                @endforeach
                                            </span>
                                            <div class="editData">
                                                <select class="form-control input-black" name="client[birth_country][{{$i}}]" data-parsley-trigger="change" required>
                                                    <option value="">@lang('sistema.btn_select')</option>
                                                    @foreach($countries as $country)
                                                    <option data-value="{{ $country->id }}" value="{{ $country->name }}" {{ ($client->birth_country == $country->id)?'selected':''}}>{{ $country->name }}</option>
                                                    @endforeach
                                                </select>
                                                <div class="form-error">@lang('frontsistema.datos_personales.birth_country_error')</div>
                                            </div>
                                        </div>
                                        <div class="col-xl-6 col-lg-6 text-left m-t-10">
                                            <span class="title">
                                                @lang('sistema.client.nationality')<span class="actualData">:</span><span class="editData"><sup>*</sup></span>
                                            </span>
                                            <span class="actualData">
                                                {{ ($client->nationality) ? $client->nationality : "-" }}
                                            </span>
                                            <div class="editData">
                                                <input type="text" class="form-control input-black" name="client[nationality][{{$i}}]" placeholder="{{__('sistema.client.nationality')}}" required value="{{ $client->nationality }}" data-parsley-trigger="change" data-parsley-chars="" />
                                                <div class="form-error">@lang('frontsistema.datos_personales.nationality_error')</div>
                                            </div>
                                        </div>
                                        @if($account->account_type != 'business')
                                        <div class="col-xl-6 col-lg-6 text-left m-t-10">
                                            <span class="title">
                                                @lang('sistema.client.address')<span class="actualData">:</span><span class="editData"><sup>*</sup></span>
                                            </span>
                                            <span class="actualData">
                                                {{ ($client->address) ? $client->address : "-" }}
                                            </span>
                                            <div class="editData">
                                                <input type="text" class="form-control input-black" name="client[address][{{$i}}]" placeholder="{{__('sistema.client.address')}}" required value="{{ $client->address }}" data-parsley-trigger="change" />
                                                <div class="form-error">@lang('frontsistema.datos_personales.address_error')</div>
                                            </div>
                                        </div>
                                        <div class="col-xl-6 col-lg-6 text-left m-t-10">
                                            <span class="title">
                                                @lang('sistema.client.country')<span class="actualData">:</span><span class="editData"><sup>*</sup></span>
                                            </span>
                                            <span class="actualData">
                                                @foreach($countries as $country)
                                                    {{ ($client->country == $country->id) ? $country->name : ''}}
                                                @endforeach
                                            </span>
                                            <div class="editData">
                                                <select class="form-control input-black" name="client[country][{{$i}}]" data-parsley-trigger="change" required>
                                                    <option value="">@lang('sistema.btn_select')</option>
                                                    @foreach($countries as $country)
                                                    <option data-value="{{ $country->id }}" value="{{ $country->name }}" {{ ($client->country == $country->id)?'selected':''}}>{{ $country->name }}</option>
                                                    @endforeach
                                                </select>
                                                <div class="form-error">@lang('frontsistema.datos_personales.country_error')</div>
                                            </div>
                                        </div>
                                        <div class="col-xl-6 col-lg-6 text-left m-t-10">
                                            <span class="title">
                                                @lang('sistema.client.state')<span class="actualData">:</span><span class="editData"><sup>*</sup></span>
                                            </span>
                                            <span class="actualData">
                                                @php
                                                    $client_state_name = $client->state_name->name;
                                                @endphp
                                                {{ ($client_state_name) ? $client_state_name : "-" }}
                                            </span>
                                            <div class="editData">
                                                <input type="text" class="form-control input-black" name="client[state][{{$i}}]" placeholder="{{__('sistema.client.state')}}" required value="{{ ($client_state_name) ? $client_state_name : '' }}" data-parsley-trigger="change" data-parsley-chars="" />
                                                <div class="form-error">@lang('frontsistema.datos_personales.state_error')</div>
                                            </div>
                                        </div>
                                        <div class="col-xl-6 col-lg-6 text-left m-t-10">
                                            <span class="title">
                                                @lang('sistema.client.city')<span class="actualData">:</span><span class="editData"><sup>*</sup></span>
                                            </span>
                                            <span class="actualData">
                                                @php
                                                    $client_city_name = $client->city_name->name;
                                                @endphp
                                                {{ ($client_city_name) ? $client_city_name : "-" }}
                                            </span>
                                            <div class="editData">
                                                <input type="text" class="form-control input-black" name="client[city][{{$i}}]" placeholder="{{__('sistema.client.city')}}" required value="{{ ($client_city_name) ? $client_city_name : '' }}" data-parsley-trigger="change" data-parsley-chars="" />
                                                <div class="form-error">@lang('frontsistema.datos_personales.city_error')</div>
                                            </div>
                                        </div>
                                        <div class="col-xl-6 col-lg-6 text-left m-t-10">
                                            <span class="title">
                                                @lang('sistema.client.zip_code')<span class="actualData">:</span><span class="editData"><sup>*</sup></span>
                                            </span>
                                            <span class="actualData">
                                                {{ ($client->zip_code) ? $client->zip_code : "-" }}
                                            </span>
                                            <div class="editData">
                                                <input type="text" class="form-control input-black" name="client[zip_code][{{$i}}]" placeholder="{{__('sistema.client.zip_code')}}" required value="{{ $client->zip_code }}" data-parsley-trigger="change" min="0" data-parsley-type="digits" />
                                                <div class="form-error">@lang('frontsistema.datos_personales.zip_code_error')</div>
                                            </div>
                                        </div>
                                        <div class="col-xl-6 col-lg-6 text-left m-t-10">
                                            <span class="title">
                                                @lang('sistema.client.county')<span class="actualData">:</span><span class="editData"><sup>*</sup></span>
                                            </span>
                                            <span class="actualData">
                                                {{ ($client->county) ? $client->county : "-" }}
                                            </span>
                                            <div class="editData">
                                                <input type="text" class="form-control input-black" name="client[county][{{$i}}]" placeholder="{{__('sistema.client.county')}}" required value="{{ $client->county }}" data-parsley-trigger="change" data-parsley-chars="" />
                                                <div class="form-error">@lang('frontsistema.datos_personales.county_error')</div>
                                            </div>
                                        </div>
                                        <div class="col-xl-6 col-lg-6 text-left m-t-10">
                                            <span class="title">
                                                @lang('sistema.branches.branches')<span class="actualData">:</span><span class="editData"><sup>*</sup></span>
                                            </span>
                                            <span class="actualData">
                                                @if(isset($branches) && count($branches)>0)
                                                    @foreach($branches as $branch_id => $branch_name)
                                                    {{ ($client->branch_id == $branch_id) ? $branch_name : '' }}
                                                    @endforeach
                                                @else
                                                -
                                                @endif
                                            </span>
                                            <div class="editData">
                                                <select class="form-control input-black" name="client[branch_id][{{$i}}]" data-parsley-trigger="change" required>
                                                    <option value="">@lang('sistema.branches.select_branch')</option>
                                                    @if(isset($branches) && count($branches)>0)
                                                    @foreach($branches as $branch_id => $branch_name)
                                                    <option data-value="{{ $branch_id }}" value="{{ $branch_name }}" {{ $client->branch_id == $branch_id ? 'selected' : '' }}>{{ $branch_name }}</option>
                                                    @endforeach
                                                    @endif
                                                </select>
                                                <div class="form-error">@lang('frontsistema.datos_personales.branch_error')</div>
                                            </div>
                                        </div>
                                        <div class="col-xl-6 col-lg-6 text-left m-t-10">
                                            <span class="title">
                                                @lang('sistema.client.company')<span class="actualData">:</span>
                                            </span>
                                            <span class="actualData">
                                                {{ ($client->company) ? $client->company : "-" }}
                                            </span>
                                            <div class="editData">
                                                <input type="text" class="form-control input-black" name="client[company][{{$i}}]" placeholder="{{__('sistema.client.company')}}" value="{{ $client->company }}" data-parsley-trigger="change" data-parsley-chars="" />
                                                <div class="form-error">@lang('frontsistema.datos_personales.company_error')</div>
                                            </div>
                                        </div>
                                        <div class="col-xl-6 col-lg-6 text-left m-t-10">
                                            <span class="title">
                                                @lang('sistema.client.industry_type')<span class="actualData">:</span>
                                            </span>
                                            <span class="actualData">
                                                {{ ($client->industry_type) ? $client->industry_type : "-" }}
                                            </span>
                                            <div class="editData">
                                                <input type="text" class="form-control input-black" name="client[industry_type][{{$i}}]" placeholder="{{__('sistema.client.industry_type')}}" value="{{ $client->industry_type }}" data-parsley-trigger="change" data-parsley-chars="" />
                                                <div class="form-error">@lang('frontsistema.datos_personales.industry_type_error')</div>
                                            </div>
                                        </div>
                                        <div class="col-xl-6 col-lg-6 text-left m-t-10">
                                            <span class="title">
                                                @lang('sistema.client.occupation')<span class="actualData">:</span>
                                            </span>
                                            <span class="actualData">
                                                {{ ($client->occupation) ? $client->occupation : "-" }}
                                            </span>
                                            <div class="editData">
                                                <input type="text" class="form-control input-black" name="client[occupation][{{$i}}]" placeholder="{{__('sistema.client.occupation')}}" value="{{ $client->occupation }}" data-parsley-trigger="change" data-parsley-chars="" />
                                                <div class="form-error">@lang('frontsistema.datos_personales.occupation_error')</div>
                                            </div>
                                        </div>
                                        <div class="col-xl-6 col-lg-6 text-left m-t-10">
                                            <span class="title">
                                                @lang('sistema.client.marrital_status')<span class="actualData">:</span>
                                            </span>
                                            <span class="actualData">
                                                {{ ($client->marrital_status) ? $client->marrital_status : "-" }}
                                            </span>
                                            <div class="editData">
                                                <input type="text" class="form-control input-black" name="client[marrital_status][{{$i}}]" placeholder="{{__('sistema.client.marrital_status')}}" value="{{ $client->marrital_status }}" data-parsley-trigger="change" data-parsley-chars="" />
                                                <div class="form-error">@lang('frontsistema.datos_personales.marital_status_error')</div>
                                            </div>
                                        </div>
                                        <div class="col-xl-6 col-lg-6 text-left m-t-10">
                                            <span class="title">
                                                @lang('sistema.client.spouse_name')<span class="actualData">:</span>
                                            </span>
                                            <span class="actualData">
                                                {{ ($client->spouse_name) ? $client->spouse_name : "-" }}
                                            </span>
                                            <div class="editData">
                                                <input type="text" class="form-control input-black" name="client[spouse_name][{{$i}}]" placeholder="{{__('sistema.client.spouse_name')}}" value="{{ $client->spouse_name }}" data-parsley-trigger="change" data-parsley-chars="" />
                                                <div class="form-error">@lang('frontsistema.datos_personales.spouse_name_error')</div>
                                            </div>
                                        </div>
                                        @endif
                                        <div class="col-xl-6 col-lg-6 text-left m-t-10">
                                            <span class="title">
                                                @lang('sistema.client.telephone1')<span class="actualData">:</span><span class="editData"><sup>*</sup></span>
                                            </span>
                                            <span class="actualData">
                                                {{ ($client->telephone1) ? $client->telephone1 : "-" }}
                                            </span>
                                            <div class="editData">
                                                <input type="text" class="form-control input-black" required name="client[telephone1][{{$i}}]" placeholder="{{__('sistema.client.telephone1')}}" value="{{ $client->telephone1 }}" data-parsley-trigger="change" data-parsley-tel="" />
                                                <div class="form-error">@lang('frontsistema.datos_personales.telephone_error')</div>
                                            </div>
                                        </div>
                                        <div class="col-xl-6 col-lg-6 text-left m-t-10">
                                            <span class="title">
                                                @lang('sistema.client.telephone2')<span class="actualData">:</span>
                                            </span>
                                            <span class="actualData">
                                                {{ ($client->telephone2) ? $client->telephone2 : "-" }}
                                            </span>
                                            <div class="editData">
                                                <input type="text" class="form-control input-black" name="client[telephone2][{{$i}}]" placeholder="{{__('sistema.client.telephone2')}}" value="{{ $client->telephone2 }}" data-parsley-trigger="change" data-parsley-tel="" />
                                                <div class="form-error">@lang('frontsistema.datos_personales.telephone_error')</div>
                                            </div>
                                        </div>
                                        @if($account->account_type != 'business')
                                        <div class="col-xl-6 col-lg-6 text-left m-t-10">
                                            <span class="title">
                                                @lang('sistema.client.telephone3')<span class="actualData">:</span>
                                            </span>
                                            <span class="actualData">
                                                {{ ($client->telephone3) ? $client->telephone3 : "-" }}
                                            </span>
                                            <div class="editData">
                                                <input type="text" class="form-control input-black" name="client[telephone3][{{$i}}]" placeholder="{{__('sistema.client.telephone3')}}" value="{{ $client->telephone3 }}" data-parsley-trigger="change" data-parsley-tel="" />
                                                <div class="form-error">@lang('frontsistema.datos_personales.telephone_error')</div>
                                            </div>
                                        </div>
                                        @endif
                                        <div class="col-xl-6 col-lg-6 text-left m-t-10">
                                            <span class="title">
                                                @lang('sistema.client.email1')<span class="actualData">:</span><span class="editData"><sup>*</sup></span>
                                            </span>
                                            <span class="actualData">
                                                {{ ($client->email1) ? $client->email1 : "-" }}
                                            </span>
                                            <div class="editData">
                                                <input type="email" class="form-control input-black" name="client[email1][{{$i}}]" required placeholder="{{__('sistema.client.email1')}}" value="{{ $client->email1 }}" data-parsley-trigger="change" data-parsley-type="email" />
                                                <div class="form-error">@lang('frontsistema.datos_personales.email_error')</div>
                                            </div>
                                        </div>
                                        <div class="col-xl-6 col-lg-6 text-left m-t-10">
                                            <span class="title">
                                                @lang('sistema.client.email2')<span class="actualData">:</span>
                                            </span>
                                            <span class="actualData">
                                                {{ ($client->email2) ? $client->email2 : "-" }}
                                            </span>
                                            <div class="editData">
                                                <input type="email" class="form-control input-black" name="client[email2][{{$i}}]" placeholder="{{__('sistema.client.email2')}}" value="{{ $client->email2 }}" data-parsley-trigger="change" data-parsley-type="email" />
                                                <div class="form-error">@lang('frontsistema.datos_personales.email_error')</div>
                                            </div>
                                        </div>
                                    </div>
                                    @php
                                        $i++;
                                    @endphp
                                    @endforeach
                                @endif
                                @if(count($account_beneficiaries) > 0)
                                <div class="row m-t-20 m-b-20 on_load verification_head verification_box beneficiary_box">
                                    <span class="subtitle" style="display: none;">@lang('frontsistema.datos_personales.beneficiary')</span>
                                    <div class="col-xl-12 text-left m-t-10">
                                        <span class="title font-16">
                                            @lang('sistema.client.beneficiaries')
                                        </span>
                                        <button class="btn btn-success add-more-beneficiary btn-xs m-l-15 editData" type="button"><i class="fa fa-plus"></i> @lang('sistema.btn_add')</button>
                                    </div>
                                    @php
                                        $i = 1; 
                                    @endphp
                                    @foreach($account_beneficiaries as $value)
                                        <div class="col-xl-6 col-lg-6 text-left m-t-10 beneficiary_{{$i}}">
                                            <span class="title">
                                                @lang('sistema.client.beneficiary_name') ({{$i}})<span class="actualData">:</span><span class="editData"><sup>*</sup></span>
                                            </span>
                                            <span class="actualData">
                                                {{ ($value->name) ? $value->name : "-" }}
                                            </span>
                                            <div class="editData">
                                                <input type="text" class="form-control input-black beneficiary" required name="beneficiary_name" placeholder="{{__('sistema.client.beneficiary_name')}}" value="{{ $value->name }}" data-value="{{ $value->name }}" data-parsley-trigger="change" data-parsley-chars="" />
                                                <div class="form-error">@lang('frontsistema.datos_personales.name_error')</div>
                                            </div>
                                        </div>
                                        <div class="col-xl-6 col-lg-6 text-left m-t-10 beneficiary_{{$i}}">
                                            <span class="title">
                                                @lang('sistema.client.beneficiary_percentage') ({{$i}})<span class="actualData">:</span><span class="editData"><sup>*</sup></span>
                                            </span>
                                            @if($i != 1)
                                            <button class="btn btn-danger removeBeneficiary pull-right btn-xs editData" data-id="{{$i}}" type="button"><i class="glyphicon glyphicon-remove"></i> @lang('sistema.btn_remove')</button>
                                            @endif
                                            <span class="actualData">
                                                {{ ($value->percentage) ? $value->percentage : "-" }}
                                            </span>
                                            <div class="editData">
                                                <input type="text" class="form-control input-black beneficiary percentage" required name="beneficiary_percentage" placeholder="{{__('sistema.client.beneficiary_percentage')}}" data-value="{{ $value->percentage }}" value="{{ $value->percentage }}" data-parsley-trigger="change" data-parsley-pattern="\s*[1-9]\d*(\.\d{1,2})?\s*" min="1" max="100" />
                                                <div class="form-error">@lang('frontsistema.datos_personales.percentage_error')</div>
                                            </div>
                                        </div>
                                    @php
                                        $i++;
                                    @endphp
                                    @endforeach
                                </div>
                                @endif
                                @if($account->credit_line_facility == 'Yes')
                                <div class="m-t-20 m-b-20 on_load verification_head verification_box">
                                    <div class="col-xl-12 text-left m-t-10">
                                        <span class="title font-16">
                                            @lang('frontsistema.datos_personales.references')
                                        </span>
                                    </div>
                                    @php
                                        $i = 0; 
                                    @endphp
                                    @for($i = 0; $i < 3; $i++)
                                    <div class="row p-l-r-15">
                                        <span class="subtitle" style="display: none;">@lang('frontsistema.datos_personales.reference')</span>
                                        <div class="col-xl-6 col-lg-6 text-left m-t-10">
                                            <span class="title">
                                                @lang('sistema.client.reference1_name') ({{$i+1}})<span class="actualData">:</span>{!!($i == 0) ? '<span class="editData"><sup>*</sup></span>' : ''!!}
                                            </span>
                                            <span class="actualData">
                                                {{ (isset($account_references[$i]) && isset($account_references[$i]->name)) ? $account_references[$i]->name : '-' }}
                                            </span>
                                            <div class="editData">
                                                <input type="text" class="form-control input-black" {!!($i == 0) ? 'required' : ''!!} name="reference_name_{{$i+1}}" placeholder="{{__('sistema.client.reference1_name')}}" value="{{ (isset($account_references[$i]) && isset($account_references[$i]->name)) ? $account_references[$i]->name : '' }}" data-parsley-trigger="change" data-parsley-chars="" />
                                                <div class="form-error">@lang('frontsistema.datos_personales.name_error')</div>
                                            </div>
                                        </div>
                                        <div class="col-xl-6 col-lg-6 text-left m-t-10">
                                            <span class="title">
                                                @lang('sistema.client.reference1_relationship') ({{$i+1}})<span class="actualData">:</span>{!!($i == 0) ? '<span class="editData"><sup>*</sup></span>' : ''!!}
                                            </span>
                                            <span class="actualData">
                                                {{ (isset($account_references[$i]) && isset($account_references[$i]->relationship)) ? $account_references[$i]->relationship : '-' }}
                                            </span>
                                            <div class="editData">
                                                <input type="text" class="form-control input-black" {!!($i == 0) ? 'required' : ''!!} name="reference_relation_{{$i+1}}" placeholder="{{__('sistema.client.reference1_relationship')}}" value="{{ (isset($account_references[$i]) && isset($account_references[$i]->relationship)) ? $account_references[$i]->relationship : '' }}" data-parsley-trigger="change" data-parsley-chars="" />
                                                <div class="form-error">@lang('frontsistema.datos_personales.relation_error')</div>
                                            </div>
                                        </div>
                                        <div class="col-xl-6 col-lg-6 text-left m-t-10">
                                            <span class="title">
                                                @lang('sistema.client.reference1_telephone') ({{$i+1}})<span class="actualData">:</span>{!!($i == 0) ? '<span class="editData"><sup>*</sup></span>' : ''!!}
                                            </span>
                                            <span class="actualData">
                                                {{ (isset($account_references[$i]) && isset($account_references[$i]->telephone)) ? $account_references[$i]->telephone : '-' }}
                                            </span>
                                            <div class="editData">
                                                <input type="text" class="form-control input-black" {!!($i == 0) ? 'required' : ''!!} name="reference_telephone_{{$i+1}}" placeholder="{{__('sistema.client.reference1_telephone')}}" value="{{ (isset($account_references[$i]) && isset($account_references[$i]->telephone)) ? $account_references[$i]->telephone : '' }}" data-parsley-trigger="change" data-parsley-tel="" />
                                                <div class="form-error">@lang('frontsistema.datos_personales.telephone_error')</div>
                                            </div>
                                        </div>
                                    </div>
                                    @endfor
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <!-- <div class="row">
                    <div class="col-xl-9">
                        <div class="page-title-box text-xs-center text-sm-center text-md-center">
                            <h4 class="page-title">@lang('frontsistema.datos_personales.maintenance_title')</h4>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                    <div class="col-xl-3">
                        <label class="m-t-20 m-b-0 font-600 font-11">@lang('frontsistema.datos_personales.birth_country')<sup>*</sup></label>
                        <select class="form-control input-black" id="country_of_birth" name="country_of_birth" data-parsley-trigger="change" value="" required>
                            <option value=""></option>
                            @foreach($countries as $key=>$country)
                                '<option value="@php echo $country['name'] @endphp" data-id="@php echo $country['id'] @endphp">@php echo $country['name'] @endphp</option>'+
                            @endforeach
                        </select>
                        <div class="form-error">@lang('frontsistema.datos_personales.birth_country_error')</div>
                    </div>
                </div> -->
                <div class="row editData">
                    <div class="col-xl-12 col-lg-12 m-t-10">
                        <div class="title font-16 font-600 font_primary_color">
                            @lang('frontsistema.datos_personales.regulatory_label')
                        </div>
                        <div class="radio m-t-0">
                            <div class="row">
                                <div class="col-xl-12">
                                    <label class="m-r-10 p-l-0">
                                        @lang('frontsistema.datos_personales.regulatory_question_1')
                                    </label>
                                </div>
                                <div class="col-xl-12">
                                    <label for="regulation1yes" class="m-r-10">
                                        <input type="radio" name="regulation1" id="regulation1yes" value="{{__('frontsistema.datos_personales.regulatory_yes')}}" data-parsley-trigger="change" guardar="SI" required>
                                        <span class="cr"><i class="cr-icon mdi mdi-checkbox-blank-circle"></i></span>
                                        @lang('frontsistema.datos_personales.regulatory_yes')
                                    </label>
                                    <label for="regulation1no">
                                        <input type="radio" name="regulation1" id="regulation1no" value="{{__('frontsistema.datos_personales.regulatory_no')}}" data-parsley-trigger="change">
                                        <span class="cr"><i class="cr-icon mdi mdi-checkbox-blank-circle"></i></span>
                                        @lang('frontsistema.datos_personales.regulatory_no')
                                    </label>
                                    <div class="form-error">@lang('frontsistema.datos_personales.regulatory_error')</div>
                                </div>
                            </div>
                        </div>
                        <div class="radio m-t-0">
                            <div class="row">
                                <div class="col-xl-12">
                                    <label class="m-r-10 p-l-0">
                                        @lang('frontsistema.datos_personales.regulatory_question_2')
                                    </label>
                                </div>
                                <div class="col-xl-12">
                                    <label for="regulation2yes" class="m-r-10">
                                        <input type="radio" name="regulation2" id="regulation2yes" value="{{__('frontsistema.datos_personales.regulatory_yes')}}" data-parsley-trigger="change" guardar="SI" required>
                                        <span class="cr"><i class="cr-icon mdi mdi-checkbox-blank-circle"></i></span>
                                        @lang('frontsistema.datos_personales.regulatory_yes')
                                    </label>
                                    <label for="regulation2no">
                                        <input type="radio" name="regulation2" id="regulation2no" value="{{__('frontsistema.datos_personales.regulatory_no')}}" data-parsley-trigger="change">
                                        <span class="cr"><i class="cr-icon mdi mdi-checkbox-blank-circle"></i></span>
                                        @lang('frontsistema.datos_personales.regulatory_no')
                                    </label>
                                    <div class="form-error">@lang('frontsistema.datos_personales.regulatory_error')</div>
                                </div>
                            </div>
                        </div>
                        <div class="radio m-t-0">
                            <div class="row">
                                <div class="col-xl-12">
                                    <label class="m-r-10 p-l-0">
                                        @lang('frontsistema.datos_personales.regulatory_question_3')
                                    </label>
                                </div>
                                <div class="col-xl-12">
                                    <label for="regulation3yes" class="m-r-10">
                                        <input type="radio" name="regulation3" id="regulation3yes" value="{{__('frontsistema.datos_personales.regulatory_yes')}}" data-parsley-trigger="change" guardar="SI" required>
                                        <span class="cr"><i class="cr-icon mdi mdi-checkbox-blank-circle"></i></span>
                                        @lang('frontsistema.datos_personales.regulatory_yes')
                                    </label>
                                    <label for="regulation3no">
                                        <input type="radio" name="regulation3" id="regulation3no" value="{{__('frontsistema.datos_personales.regulatory_no')}}" data-parsley-trigger="change">
                                        <span class="cr"><i class="cr-icon mdi mdi-checkbox-blank-circle"></i></span>
                                        @lang('frontsistema.datos_personales.regulatory_no')
                                    </label>
                                    <div class="form-error">@lang('frontsistema.datos_personales.regulatory_error')</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row editData">
                    <div class="col-xl-12 col-lg-12 text-right m-t-30 m-b-15">
                        <a class="text-aqua-blue m-r-10 cursor-pointer line-height-35 font-600" href="{{ route('client_home') }}">@lang('frontsistema.btn_cancel')</a>
                        <button class="btn btn-aqua-blue waves-effect waves-light p-l-r-30" type="submit">@lang('frontsistema.datos_personales.update_label')</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="row" id="verification_div" style="display: none;">
            <div class="col-xl-12 p-l-xs-30">
                <form id="verification-form" name="verification-form">
                    <div class="row">
                        <div class="col-xl-12 col-lg-12">
                            <h5 class="font-16 font-600">@lang('frontsistema.datos_personales.verify_code_title')</h5>
                            <div class="row m-t-30 m-b-30 on_load verification_head verification_box" id="verificationFields">
                            </div>
                            <h5 class="font-16">@lang('frontsistema.datos_personales.code_label')</h5>
                            <div class="row m-b-30 on_load">
                                <div class="col-xl-3 col-lg-6 col-md-6 m-t-minus-5 m-t-sm-15 m-t-xs-15 m-t-20">
                                    <label class="m-0 font-600 font-11">@lang('frontsistema.datos_personales.code')</label>
                                    <input class="form-control input-black" type="number" id="code" name="code"data-parsley-type="integer" data-parsley-trigger="change" autocomplete="off" required>
                                    <div class="form-error">@lang('frontsistema.datos_personales.code_error')</div>
                                </div>
                                <div class="col-xl-3 col-lg-6 col-md-6 m-t-minus-5 m-t-sm-15 m-t-xs-15 m-t-20">
                                    <label class="m-0 font-600 font-11">&nbsp;</label>
                                    <button class="btn btn-block btn-aqua-blue waves-effect waves-light">@lang('frontsistema.datos_personales.submit_label')</button>
                                </div>
                                <div class="col-xl-12">
                                    <a class="text-aqua-blue m-r-10 cursor-pointer line-height-35 resendOtp" href="javascript:void(0)">@lang('frontsistema.datos_personales.request_another_code')</a>
                                </div>
                                <!-- end col -->
                            </div>
                            <div class="row on_load">
                                <div class="col-xl-12 col-lg-12 col-md-12">
                                    <h5 class="font-16">
                                        @lang('frontsistema.datos_personales.help_msg3')
                                        <a href="javascript:void(0)" class="open_contact_us_form blue">@lang('frontsistema.datos_personales.contact')</a>
                                    </h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="row on_success m-t-50" style="display: none;">
            <div class="col-lg-12 text-center">
                <h3 class="font-600">@lang('frontsistema.datos_personales.success_msg_title')</h3>
                <p class="text-custom-info font-600 font-16 m-b-0 m-t-20">@lang('frontsistema.datos_personales.success_msg')</p>
                <div class="row m-t-20">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right text-md-center text-sm-center text-xs-center">
                        <a class="text-aqua-blue m-r-10 cursor-pointer line-height-35" href="{{ route('client_home') }}">@lang('frontsistema.datos_personales.back_to_home')</a>
                    </div>
                </div>
            </div>
        </div>

    </div> <!-- container-fluid -->

    @php 
        $arr['label1'] = array('type'=>'text','value'=>'val','label_en'=>'eng','label_es'=>'spanish');
        //dd($arr);
    @endphp
@endsection

@section('customjs')
<script src="{{ url('assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}" charset="UTF-8"></script>
<script src="{{ url('assets/plugins/bootstrap-datepicker/locales/bootstrap-datepicker.es.js') }}"></script>
<script type="text/javascript">
    initParsleyValidation();
    initDatepicker('#incorporation_date', null, '+0d');
    initDatepicker('.client_dob', null, '-10y');
    var client_request_id;

    $('#submit-another-request').click(function() {
        window.location.reload();
    });

    // Get the initial values of the complete form
    initialFormValues = $('#personal-data-form').serializeArray();

    // Function to initialize the parsley validation
    function initParsleyValidation() {
        $('#personal-data-form').parsley().on('field:validated', function () {
            // console.log("personal-data-form error");
        })
        .on('form:submit', function () {
            // Validate if all percentage of beneficiaries do not add to 100
            var totalPercentage = 0;
            $('input.beneficiary.percentage').each(function() {
                totalPercentage += parseFloat($(this).val());
                console.log($(this).val());
            });
            console.log(totalPercentage);
            if (totalPercentage != 100) {
                swal("@lang('frontsistema.users_alert')", "@lang('frontsistema.datos_personales.total_percent_error')", 'error');
            }
            else {
                newFormValues = $('#personal-data-form').serializeArray();
                for (let i = 0; i < newFormValues.length; i++) {
                    // Reset the guardar attribute on every form field
                    $('[name="'+newFormValues[i].name+'"]').attr('guardar', 'NO');
                    // Check if the value of any particular field has changed
                    let currentFieldFound = false;
                    for (let j = 0; j < initialFormValues.length; j++) {
                        if (initialFormValues[j].name == newFormValues[i].name) {
                            currentFieldFound = true;
                            if (initialFormValues[j].value != newFormValues[i].value && !$('[name="'+newFormValues[i].name+'"]').hasClass('beneficiary')) {
                                $('[name="'+newFormValues[i].name+'"]').attr('guardar', 'SI');
                            }
                        }
                    }
                    if (!currentFieldFound) {
                        $('[name="'+newFormValues[i].name+'"]').attr('guardar', 'SI');
                    }
                }
                // Manage the change record of beneficiary fields
                $('input.beneficiary').each(function() {
                    if ($(this).val() != $(this).data('value')) {
                        console.log("in");
                        $('input.beneficiary').attr('guardar', 'SI');
                    }
                });
                
                submitPersonalDataForm();
            }
            return false; // Don't submit form for this demo
        });
        $('#verification-form').parsley().on('field:validated', function (e) {
            // console.log("third_form error", e);
        })
        .on('form:submit', function () {
            submitThirdForm();
            return false; // Don't submit form for this demo
        });
    }
    // Handle the click of edit button and cancel edit button
    $('body').on('click', '#enableEdit', function() {
        $('.actualData').hide();
        $('.editData').show();
    });
    $('body').on('click', '#disableEdit', function() {
        $('.actualData').show();
        $('.editData').hide();
    });
    // Function to handle the init of datepicker
    function initDatepicker(id, startDate, endDate) {
        var options = {
            format: 'dd/mm/yyyy',
            autoclose: true,
            language: '{{ session("language") }}',
        };
        if (startDate) {
            options['startDate'] = startDate;
        }
        if (endDate) {
            options['endDate'] = endDate;
        }
        //Initialze date pickers
        $(id).datepicker(options).on('changeDate', function(e) {
            $(this).parsley().validate();
        });
    }

    // Function to handle the submit of personal data form after successful validation
    function submitPersonalDataForm(){
        // Show the values of changed fields to the user
        let token = $('#_token').val();
        let req_data = '{';
        var html = '';
        var beneficiary_number = 1;
        $('#personal-data-form').find(':input').each(function() 
        {
            if($(this).attr("guardar")=="SI")
            {
                var value = (($(this).attr('type') == 'radio') ? $('[name='+$(this).attr('name')+']:checked').val() : $(this).val());
                if(req_data != '{'){
                        req_data += ',';
                }
                var name = ($(this).attr("name") == 'beneficiary_name' || $(this).attr("name") == 'beneficiary_percentage') ? ($(this).attr("name") + '_' + beneficiary_number) : $(this).attr("name");
                if ($(this).attr("name") == 'beneficiary_percentage') {
                    beneficiary_number++;
                }
                req_data += '"'+ name +'":{"type":"text","value":"'+value+'"}'; 
                if ($(this).attr('type') != 'radio') {
                    html += '<div class="col-xl-6 col-lg-6 text-left m-t-10">'+
                                '<span class="title">'+
                                    (($(this).parent().parent().parent().find('.subtitle').text()) ? ($(this).parent().parent().parent().find('.subtitle').text()) : '') + $(this).parent().parent().find('.title').text().replace('*', '')+'&nbsp;'+
                                '</span>'+
                                ((value) ? value : '-')+
                            '</div>';
                }
            }
        });
        req_data += '}';
        $('#verificationFields').html(html);
        console.log(req_data);
        $.ajax({
            type: 'POST',
            dataType: 'json',
            data: {'_token':token,'text':req_data,'request_type_id':20,'verify':1,'from':'DATOS PERSONALES'},
            url: "{{ url('user/client_request') }}",
            beforeSend: function() {
                //$('#modal-espere').modal('show');
                show_loader(true);
            },
            success: function(response) {
                if (response.error && response.code == '500'){
                    swal("@lang('frontsistema.users_alert')", response.message, 'error');
                }
                else if(!response.error && response.code == '200'){
                    // Hide the form and show the verification div
                    client_request_id = response.client_request_id;
                    $('#personal_data_div').hide();
                    $('#verification_div').show();
                }
            },
            error: function(response) {
                //console.error(response);
                swal("@lang('frontsistema.users_alert')", response.message, 'error');
            },
            complete: function() {
                show_loader(false);
            }
        });
    }
    // Function to handle resending of otp
    $('body').on('click', '.resendOtp', function() {
        let token = $('#_token').val();
        $.ajax({
            type: 'POST',
            dataType: 'json',
            data: {'_token':token},
            url: "{{ url('user/generate_code') }}",
            beforeSend: function() {
                //$('#modal-espere').modal('show');
                show_loader(true);
            },
            success: function(response) {
                if (response.error && response.code == '500'){
                    swal("@lang('frontsistema.users_alert')", response.message, 'error');
                }
                else if(!response.error && response.code == '200'){
                    // Reset all the forms and show success dialog
                    swal("@lang('frontsistema.users_alert')", "@lang('frontsistema.alta_de_cuentas.otp_resent')", 'success');
                }
            },
            error: function(response) {
                //console.error(response);
            },
            complete: function() {
                show_loader(false);
            }
        });
    });

    // Function to handle the submit of 3rd form
    function submitThirdForm(){
        let token = $('#_token').val();
        $.ajax({
            type: 'POST',
            dataType: 'json',
            data: {'_token':token, 'code': $('#code').val(), 'client_request_id': client_request_id},
            url: "{{ url('user/verify_request') }}",
            beforeSend: function() {
                //$('#modal-espere').modal('show');
                show_loader(true);
            },
            success: function(response) {
                if (response.error && response.code == '500'){
                    swal("@lang('frontsistema.users_alert')", response.message, 'error');
                }
                else if(!response.error && response.code == '200'){
                    // Reset all the forms and show success dialog
                    $("#verification_div").hide();
                    $('.on_success').show();
                    window.scrollTo(0, 0);
                    console.log("submit form");
                }
            },
            error: function(response) {
                //console.error(response);
            },
            complete: function() {
                show_loader(false);
            }
        });
    }

    // Handle the removal of beneficiaries
    $('body').on('click', '.removeBeneficiary', function() {
        var id = $(this).data('id');
        $('.beneficiary_' + id).remove();
    });

    var new_beneficiary_id = 101;
    // Handle the adding of beneficiaries
    $('body').on('click', '.add-more-beneficiary', function() {
        var html = '<div class="editData font_primary_color col-xl-6 col-lg-6 text-left m-t-10 beneficiary_'+new_beneficiary_id+'" style="display: block;">'+
                        '<span class="title"> @lang('sistema.client.beneficiary_name')<span class="actualData" style="display: none;">:</span><span><sup>*</sup></span></span>'+
                        '<div class="editData" style="display: block;">'+
                            '<input type="text" class="form-control input-black beneficiary" required name="beneficiary_name" placeholder="{{__('sistema.client.beneficiary_name')}}" value="" data-value="" data-parsley-trigger="change" data-parsley-chars="" />'+
                            '<div class="form-error">@lang('frontsistema.datos_personales.name_error')</div>'+
                        '</div>'+
                    '</div>'+
                    '<div class="editData font_primary_color col-xl-6 col-lg-6 text-left m-t-10 beneficiary_'+new_beneficiary_id+'" style="display: block;">'+
                        '<span class="title"> @lang('sistema.client.beneficiary_percentage')<span class="actualData" style="display: none;">:</span><span><sup>*</sup></span></span>'+
                        '<button class="btn btn-danger removeBeneficiary pull-right btn-xs editData" style="display: block;" data-id="'+new_beneficiary_id+'" type="button"><i class="glyphicon glyphicon-remove"></i> @lang('sistema.btn_remove')</button>'+
                        '<div class="editData" style="display: block;">'+
                            '<input type="text" class="form-control input-black beneficiary percentage" required name="beneficiary_percentage" placeholder="{{__('sistema.client.beneficiary_percentage')}}" value="" data-value="" data-parsley-trigger="change" data-parsley-pattern="\\s*[1-9]\\d*(\\.\\d{1,2})?\\s*" min="1" max="100" />'+
                            '<div class="form-error">@lang('frontsistema.datos_personales.percentage_error')</div>'+
                        '</div>'+
                    '</div>';
        new_beneficiary_id++;
        $('.beneficiary_box').append(html);
    });
</script>
@endsection