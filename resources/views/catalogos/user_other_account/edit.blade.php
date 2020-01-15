@extends('layouts.main')
@section('customcss')
<link href="{{ url('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
<style type="text/css">
    .select2-container--default .select2-selection--single .select2-selection__arrow{
        top: 7px;
    }
</style>
@endsection
@section('pagecontent')

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">@lang('sistema.alta_de_cuentas.edit_page')</h4>
                <ol class="breadcrumb p-0 m-0">
                    <li>
                        <a href="javascript:void(0)">@lang('sistema.pie')</a>
                    </li>                         
                    <li>
                        <a href="{{ url('user_other_accounts') }}">
                            @lang('sistema.alta_de_cuentas.title')
                        </a>
                    </li>
                    <li class="active">
                        @lang('sistema.alta_de_cuentas.edit_page')
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

                        <form class="form-horizontal"  method="POST" action="{{url('user_other_accounts/'.$userOtherAccount->id)}}" id="frm_user_other_accounts" onsubmit="return validateFrm();" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            {{ method_field('PUT') }}

                            <!-- User's Account selection -->
                            <div class="form-group col-lg-12 row">
                                <div class="form-group col-lg-6 row m-0" >
                                    <label for="account_number" class="col-sm-3 form-control-label">@lang('sistema.alta_de_cuentas.user')<span class="text-danger">*</span></label>
                                    <div class="col-sm-9 input_controls">
                                         <select tabindex="2" class="form-control select2" id="account_number" name="account_number" valida="SI" cadena ="{{__('sistema.transaction.req_account_number')}}">
                                            <option value="">Selectar cuenta</option>
                                            @if(isset($accounts) && count($accounts) > 0)
                                            @foreach($accounts as $account)
                                            @php
                                            $primary_account = $account->primary_client;
                                            @endphp                                                    
                                            <option value="{{ $account->id }}" {{ $userOtherAccount->account_id == $account->id ? 'selected' : '' }}>{{$account->account_number}}{{  $primary_account ?  ' - ' . $primary_account->full_name : '' }}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <!-- Type and Destination to select fields--> 
                            <div class="form-group col-lg-12 row">
                                <div class="form-group col-lg-6 row m-0" >
                                    <label for="type_of_recipient" class="col-sm-3 form-control-label">@lang('sistema.alta_de_cuentas.type_of_recipient')<span class="text-danger">*</span></label>
                                    <div class="col-sm-9 input_controls">
                                        <select class="form-control" id="type_of_recipient" name="type_of_recipient" valida="SI" cadena="{{ __('sistema.alta_de_cuentas.type_of_recipient_err') }}">
                                            <option value=""></option>
                                            <option value="personal" {{ $userOtherAccount->type_of_recipient == 'personal' ? 'selected' : '' }}>@lang('sistema.alta_de_cuentas.personal')</option>
                                            <option value="company" {{ $userOtherAccount->type_of_recipient == 'company' ? 'selected' : '' }}>@lang('sistema.alta_de_cuentas.empresa')</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-lg-6 row m-0">
                                    <label for="destination_type" class="col-sm-3 form-control-label">@lang('sistema.alta_de_cuentas.destination')<span class="text-danger">*</span></label>
                                    <div class="col-sm-9 input_controls">
                                        <select class="form-control" id="destination_type" name="destination_type" valida="SI" cadena="{{ __('sistema.alta_de_cuentas.destination_error') }}">
                                            <option value=""></option>
                                            <option value="same" {{ $userOtherAccount->destination_type == 'same' ? 'selected' : '' }}>@lang('sistema.alta_de_cuentas.same_entity')</option>
                                            <option value="international" {{ $userOtherAccount->destination_type == 'international' ? 'selected' : '' }}>@lang('sistema.alta_de_cuentas.international')</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <!-- Type and Destination to select fields-->
                            <div class="add_remaining_form">
                                @if($userOtherAccount->destination_type == 'same')
                                    <div class="form-group col-lg-12 row">
                                        <div class="form-group col-lg-6 row m-0">
                                            <label for="instrument_id" class="col-sm-3 form-control-label">@lang('sistema.alta_de_cuentas.type_of_account')<span class="text-danger">*</span></label>
                                            <div class="col-sm-9 input_controls">
                                                <select class="form-control" id="instrument_id" name="instrument_id" valida="SI" cadena="{{ __('sistema.alta_de_cuentas.type_of_account_error') }}">
                                                    <option value=""></option>
                                                    @foreach($instruments as $key=>$instrument)
                                                        <option value="{{ $key }}" {{ $userOtherAccount->instrument_id == $key ? 'selected' : '' }}>{{ $instrument }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group col-lg-6 row m-0">
                                            <label for="first_name" class="col-sm-3 form-control-label">@lang('sistema.alta_de_cuentas.account_name')<span class="text-danger">*</span></label>
                                            <div class="col-sm-9 input_controls">
                                                <input type="text" class="form-control" id="first_name" name="first_name" placeholder="{{__('sistema.alta_de_cuentas.account_name')}}" valida="SI" cadena ="{{__('sistema.alta_de_cuentas.account_name_error')}}" value="{{ $userOtherAccount->first_name }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-lg-12 row">
                                        <div class="form-group col-lg-6 row m-0">
                                            <label for="dest_account_number" class="col-sm-3 form-control-label">@lang('sistema.alta_de_cuentas.account_number')<span class="text-danger">*</span></label>
                                            <div class="col-sm-9 input_controls">
                                                <input type="text" class="form-control" id="dest_account_number" name="dest_account_number" placeholder="{{__('sistema.alta_de_cuentas.account_number')}}" valida="SI" cadena ="{{__('sistema.alta_de_cuentas.account_number_error')}}" value="{{ $userOtherAccount->dest_account_number }}">
                                            </div>
                                        </div>
                                        <div class="form-group col-lg-6 row m-0">
                                            <label for="currency" class="col-sm-3 form-control-label">@lang('sistema.alta_de_cuentas.currency')<span class="text-danger">*</span></label>
                                            <div class="col-sm-9 input_controls">
                                                <select class="form-control" id="currency" name="currency" valida="SI" cadena ="{{__('sistema.alta_de_cuentas.currency_error')}}">
                                                    <option value=""></option>
                                                    @foreach(config('site.currencies') as $key=>$currency)
                                                        <option value="{{ $key }}" {{ $userOtherAccount->currency == $key ? 'selected' : '' }}>{{ $currency[session('language')] }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                @elseif($userOtherAccount->destination_type == 'international')
                                    <h4 class="m-b-30 m-t-30 header-title"><b>@lang('sistema.alta_de_cuentas.addresse_label')</b><hr></h4>
                                    <div class="form-group col-lg-12 row">
                                        <div class="form-group col-lg-6 row m-0">
                                            <label for="instrument_id" class="col-sm-3 form-control-label">@lang('sistema.alta_de_cuentas.type_of_account')<span class="text-danger">*</span></label>
                                            <div class="col-sm-9 input_controls">
                                                <select class="form-control" id="instrument_id" name="instrument_id" valida="SI" cadena ="{{__('sistema.alta_de_cuentas.type_of_account_error')}}">
                                                    <option value=""></option>
                                                    @foreach($instruments as $key=>$instrument)
                                                        <option value="{{ $key }}" {{ $userOtherAccount->instrument_id == $key ? 'selected' : '' }}>{{ $instrument }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group col-lg-6 row m-0">
                                            <label for="first_name" class="col-sm-3 form-control-label">@lang('sistema.alta_de_cuentas.account_name')<span class="text-danger">*</span></label>
                                            <div class="col-sm-9 input_controls">
                                                <input type="text" class="form-control" id="first_name" name="first_name" placeholder="{{__('sistema.alta_de_cuentas.account_name')}}" valida="SI" cadena ="{{__('sistema.alta_de_cuentas.account_name_error')}}" value="{{ $userOtherAccount->first_name }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-lg-12 row">
                                        <div class="form-group col-lg-6 row m-0">
                                            <label for="telephone" class="col-sm-3 form-control-label">@lang('sistema.alta_de_cuentas.telephone_label')<span class="text-danger">*</span></label>
                                            <div class="col-sm-9 input_controls">
                                                <input type="text" class="form-control" id="telephone" name="telephone" placeholder="{{__('sistema.alta_de_cuentas.telephone_label')}}" valida="SI" cadena ="{{__('sistema.alta_de_cuentas.telephone_error')}}" value="{{ $userOtherAccount->telephone }}">
                                            </div>
                                        </div>
                                        <div class="form-group col-lg-6 row m-0">
                                            <label for="address" class="col-sm-3 form-control-label">@lang('sistema.alta_de_cuentas.address_label')<span class="text-danger">*</span></label>
                                            <div class="col-sm-9 input_controls">
                                                <input type="text" class="form-control" id="address" name="address" placeholder="{{__('sistema.alta_de_cuentas.address_label')}}" valida="SI" cadena ="{{__('sistema.alta_de_cuentas.address_error')}}" value="{{ $userOtherAccount->address }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-lg-12 row">
                                        <div class="form-group col-lg-6 row m-0">
                                            <label for="country" class="col-sm-3 form-control-label">@lang('sistema.alta_de_cuentas.country_label')<span class="text-danger">*</span></label>
                                            <div class="col-sm-9 input_controls">
                                                <select class="form-control" id="country" name="country" valida="SI" cadena ="{{__('sistema.alta_de_cuentas.country_error')}}">
                                                    <option value=""></option>
                                                    @foreach($countries as $country)
                                                        <option value="{{ $country->id }}" {{ $userOtherAccount->country == $country->id ? 'selected' : '' }}>{{ $country->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group col-lg-6 row m-0">
                                            <label for="state" class="col-sm-3 form-control-label">@lang('sistema.alta_de_cuentas.state_label')<span class="text-danger">*</span></label>
                                            <div class="col-sm-9 input_controls">
                                                <input type="text" class="form-control" id="state" name="state" placeholder="{{__('sistema.alta_de_cuentas.state_label')}}" valida="SI" cadena ="{{__('sistema.alta_de_cuentas.state_error')}}" value="{{ $userOtherAccount->state }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-lg-12 row">
                                        <div class="form-group col-lg-6 row m-0">
                                            <label for="city" class="col-sm-3 form-control-label">@lang('sistema.alta_de_cuentas.city_label')<span class="text-danger">*</span></label>
                                            <div class="col-sm-9 input_controls">
                                                <input type="text" class="form-control" id="city" name="city" placeholder="{{__('sistema.alta_de_cuentas.city_label')}}" valida="SI" cadena ="{{__('sistema.alta_de_cuentas.city_error')}}" value="{{ $userOtherAccount->city }}">
                                            </div>
                                        </div>
                                    </div>

                                    <h4 class="m-b-30 m-t-30 header-title"><b>@lang('sistema.alta_de_cuentas.dest_account_label')</b><hr></h4>

                                    <div class="form-group col-lg-12 row">
                                        <div class="form-group col-lg-6 row m-0">
                                            <label for="dest_bank_country" class="col-sm-3 form-control-label">@lang('sistema.alta_de_cuentas.dest_bank_country')<span class="text-danger">*</span></label>
                                            <div class="col-sm-9 input_controls">
                                                <select class="form-control" id="dest_bank_country" name="dest_bank_country" valida="SI" cadena ="{{__('sistema.alta_de_cuentas.dest_bank_country_err')}}">
                                                    <option value=""></option>
                                                    @foreach($countries as $country)
                                                        <option value="{{ $country->id }}" {{ $userOtherAccount->dest_bank_country == $country->id ? 'selected' : '' }}>{{ $country->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group col-lg-6 row m-0">
                                            <label for="dest_account_number" class="col-sm-3 form-control-label">@lang('sistema.alta_de_cuentas.account_number')<span class="text-danger">*</span></label>
                                            <div class="col-sm-9 input_controls">
                                                <input type="text" class="form-control" id="dest_account_number" name="dest_account_number" placeholder="{{__('sistema.alta_de_cuentas.account_number')}}" valida="SI" cadena ="{{__('sistema.alta_de_cuentas.account_number_error')}}" value="{{ $userOtherAccount->dest_account_number }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-lg-12 row">
                                        <div class="form-group col-lg-6 row m-0">
                                            <label for="dest_swift" class="col-sm-3 form-control-label">@lang('sistema.alta_de_cuentas.dest_bank_swift')<span class="text-danger">*</span></label>
                                            <div class="col-sm-9 input_controls">
                                                <input type="text" class="form-control" id="dest_swift" name="dest_swift" placeholder="{{__('sistema.alta_de_cuentas.dest_bank_swift')}}" valida="SI" cadena ="{{__('sistema.alta_de_cuentas.dest_bank_swift_error')}}" value="{{ $userOtherAccount->dest_swift }}">
                                            </div>
                                        </div>
                                        <div class="form-group col-lg-6 row m-0">
                                            <label for="dest_bank_name" class="col-sm-3 form-control-label">@lang('sistema.alta_de_cuentas.dest_int_bank_label')<span class="text-danger">*</span></label>
                                            <div class="col-sm-9 input_controls">
                                                <input type="text" class="form-control" id="dest_bank_name" name="dest_bank_name" placeholder="{{__('sistema.alta_de_cuentas.dest_int_bank_label')}}" valida="SI" cadena ="{{__('sistema.alta_de_cuentas.dest_int_bank_error')}}" value="{{ $userOtherAccount->dest_bank_name }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-lg-12 row">
                                        <div class="form-group col-lg-6 row m-0">
                                            <label for="dest_bank_address" class="col-sm-3 form-control-label">@lang('sistema.alta_de_cuentas.dest_bank_address')<span class="text-danger">*</span></label>
                                            <div class="col-sm-9 input_controls">
                                                <input type="text" class="form-control" id="dest_bank_address" name="dest_bank_address" placeholder="{{__('sistema.alta_de_cuentas.dest_bank_address')}}" valida="SI" cadena ="{{__('sistema.alta_de_cuentas.dest_bank_error')}}" value="{{ $userOtherAccount->dest_bank_address }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-lg-12 row">
                                        <div class="form-group col-lg-6 row m-0">
                                            <div class="col-sm-12">
                                                <div class="checkbox checkbox-custom m-t-0">
                                                    <label class="m-b-0 ckCursor" for="intermediary_banking">
                                                        <input type="checkbox" class="intermediary_banking_chk" value="1" name="intermediary_banking" id="intermediary_banking" {{ $userOtherAccount->intermediary_banking == 1 ? 'checked' : '' }}>
                                                        <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                        @lang('sistema.alta_de_cuentas.use_intermediate_bank')
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="add_form_banco_intermediario">
                                        @if($userOtherAccount->intermediary_banking == 1)
                                            <br>
                                            <div class="form-group col-lg-12 row">
                                                <div class="form-group col-lg-6 row m-0">
                                                    <label for="intermediary_bank_country" class="col-sm-3 form-control-label">@lang('sistema.alta_de_cuentas.dest_int_bank_country')<span class="text-danger">*</span></label>
                                                    <div class="col-sm-9 input_controls">
                                                        <select class="form-control" id="intermediary_bank_country" name="intermediary_bank_country" valida="SI" cadena ="{{__('sistema.alta_de_cuentas.dest_int_bank_cou_err')}}">
                                                            <option value=""></option>
                                                            @foreach($countries as $country)
                                                                <option value="{{ $country->id }}" {{ $userOtherAccount->intermediary_bank_country == $country->id ? 'selected' : '' }}>{{ $country->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group col-lg-6 row m-0">
                                                    <label for="intermediary_bank_account" class="col-sm-3 form-control-label">@lang('sistema.alta_de_cuentas.account_number')<span class="text-danger">*</span></label>
                                                    <div class="col-sm-9 input_controls">
                                                        <input type="text" class="form-control" id="intermediary_bank_account" name="intermediary_bank_account" placeholder="{{__('sistema.alta_de_cuentas.account_number')}}" valida="SI" cadena ="{{__('sistema.alta_de_cuentas.account_number_error')}}" value="{{ $userOtherAccount->intermediary_bank_account }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group col-lg-12 row">
                                                <div class="form-group col-lg-6 row m-0">
                                                    <label for="intermediary_swift" class="col-sm-3 form-control-label">@lang('sistema.alta_de_cuentas.dest_bank_swift')<span class="text-danger">*</span></label>
                                                    <div class="col-sm-9 input_controls">
                                                        <input type="text" class="form-control" id="intermediary_swift" name="intermediary_swift" placeholder="{{__('sistema.alta_de_cuentas.dest_bank_swift')}}" valida="SI" cadena ="{{__('sistema.alta_de_cuentas.dest_bank_swift_error')}}" value="{{ $userOtherAccount->intermediary_swift }}">
                                                    </div>
                                                </div>
                                                <div class="form-group col-lg-6 row m-0">
                                                    <label for="intermediary_bank_name" class="col-sm-3 form-control-label">@lang('sistema.alta_de_cuentas.dest_int_bank_label')<span class="text-danger">*</span></label>
                                                    <div class="col-sm-9 input_controls">
                                                        <input type="text" class="form-control" id="intermediary_bank_name" name="intermediary_bank_name" placeholder="{{__('sistema.alta_de_cuentas.dest_int_bank_label')}}" valida="SI" cadena ="{{__('sistema.alta_de_cuentas.dest_int_bank_error')}}" value="{{ $userOtherAccount->intermediary_bank_name }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group col-lg-12 row">
                                                <div class="form-group col-lg-6 row m-0">
                                                    <label for="intermediary_bank_address" class="col-sm-3 form-control-label">@lang('sistema.alta_de_cuentas.address_label')<span class="text-danger">*</span></label>
                                                    <div class="col-sm-9 input_controls">
                                                        <input type="text" class="form-control" id="intermediary_bank_address" name="intermediary_bank_address" placeholder="{{__('sistema.alta_de_cuentas.address_label')}}" valida="SI" cadena ="{{__('sistema.alta_de_cuentas.address_error')}}" value="{{ $userOtherAccount->intermediary_bank_address }}">
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                @endif


                            </div>

                            <div class="form-group col-lg-12 row">
                                <div class="form-group col-lg-6 row m-0">
                                    <div class="offset-sm-3 col-sm-9">
                                        <a href="{{url('user_other_accounts')}}" class="btn btn-danger waves-effect waves-light">@lang('sistema.btn_back')</a>
                                        <button type="submit" class="btn btn-info waves-effect waves-light">@lang('sistema.btn_save')</button>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <div class="hide same_entity_div" style="display: none;">
                            <div class="form-group col-lg-12 row">
                                <div class="form-group col-lg-6 row m-0">
                                    <label for="instrument_id" class="col-sm-3 form-control-label">@lang('sistema.alta_de_cuentas.type_of_account')<span class="text-danger">*</span></label>
                                    <div class="col-sm-9 input_controls">
                                        <select class="form-control" id="instrument_id" name="instrument_id" valida="SI" cadena="{{ __('sistema.alta_de_cuentas.type_of_account_error') }}">
                                            <option value=""></option>
                                            @foreach($instruments as $key=>$instrument)
                                                <option value="{{ $key }}">{{ $instrument }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-lg-6 row m-0">
                                    <label for="first_name" class="col-sm-3 form-control-label">@lang('sistema.alta_de_cuentas.account_name')<span class="text-danger">*</span></label>
                                    <div class="col-sm-9 input_controls">
                                        <input type="text" class="form-control" id="first_name" name="first_name" placeholder="{{__('sistema.alta_de_cuentas.account_name')}}" valida="SI" cadena ="{{__('sistema.alta_de_cuentas.account_name_error')}}" value="{{ (old('first_name'))? old('first_name'):'' }}">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-lg-12 row">
                                <div class="form-group col-lg-6 row m-0">
                                    <label for="dest_account_number" class="col-sm-3 form-control-label">@lang('sistema.alta_de_cuentas.account_number')<span class="text-danger">*</span></label>
                                    <div class="col-sm-9 input_controls">
                                        <input type="text" class="form-control" id="dest_account_number" name="dest_account_number" placeholder="{{__('sistema.alta_de_cuentas.account_number')}}" valida="SI" cadena ="{{__('sistema.alta_de_cuentas.account_number_error')}}" value="{{ (old('dest_account_number'))? old('dest_account_number'):'' }}">
                                    </div>
                                </div>
                                <div class="form-group col-lg-6 row m-0">
                                    <label for="currency" class="col-sm-3 form-control-label">@lang('sistema.alta_de_cuentas.currency')<span class="text-danger">*</span></label>
                                    <div class="col-sm-9 input_controls">
                                        <select class="form-control" id="currency" name="currency" valida="SI" cadena ="{{__('sistema.alta_de_cuentas.currency_error')}}">
                                            <option value=""></option>
                                            @foreach(config('site.currencies') as $key=>$currency)
                                                <option value="{{ $key }}">{{ $currency[session('language')] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--  Code for Internacional -->

                        <div class="hide international_div" style="display: none;">
                            <h4 class="m-b-30 m-t-30 header-title"><b>@lang('sistema.alta_de_cuentas.addresse_label')</b><hr></h4>
                            <div class="form-group col-lg-12 row">
                                <div class="form-group col-lg-6 row m-0">
                                    <label for="instrument_id" class="col-sm-3 form-control-label">@lang('sistema.alta_de_cuentas.type_of_account')<span class="text-danger">*</span></label>
                                    <div class="col-sm-9 input_controls">
                                        <select class="form-control" id="instrument_id" name="instrument_id" valida="SI" cadena ="{{__('sistema.alta_de_cuentas.type_of_account_error')}}">
                                            <option value=""></option>
                                            @foreach($instruments as $key=>$instrument)
                                                <option value="{{ $key }}">{{ $instrument }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-lg-6 row m-0">
                                    <label for="first_name" class="col-sm-3 form-control-label">@lang('sistema.alta_de_cuentas.account_name')<span class="text-danger">*</span></label>
                                    <div class="col-sm-9 input_controls">
                                        <input type="text" class="form-control" id="first_name" name="first_name" placeholder="{{__('sistema.alta_de_cuentas.account_name')}}" valida="SI" cadena ="{{__('sistema.alta_de_cuentas.account_name_error')}}" value="{{ (old('first_name'))? old('first_name'):'' }}">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-lg-12 row">
                                <div class="form-group col-lg-6 row m-0">
                                    <label for="telephone" class="col-sm-3 form-control-label">@lang('sistema.alta_de_cuentas.telephone_label')<span class="text-danger">*</span></label>
                                    <div class="col-sm-9 input_controls">
                                        <input type="text" class="form-control" id="telephone" name="telephone" placeholder="{{__('sistema.alta_de_cuentas.telephone_label')}}" valida="SI" cadena ="{{__('sistema.alta_de_cuentas.telephone_error')}}" value="{{ (old('telephone'))? old('telephone'):'' }}">
                                    </div>
                                </div>
                                <div class="form-group col-lg-6 row m-0">
                                    <label for="address" class="col-sm-3 form-control-label">@lang('sistema.alta_de_cuentas.address_label')<span class="text-danger">*</span></label>
                                    <div class="col-sm-9 input_controls">
                                        <input type="text" class="form-control" id="address" name="address" placeholder="{{__('sistema.alta_de_cuentas.address_label')}}" valida="SI" cadena ="{{__('sistema.alta_de_cuentas.address_error')}}" value="{{ (old('address'))? old('address'):'' }}">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-lg-12 row">
                                <div class="form-group col-lg-6 row m-0">
                                    <label for="country" class="col-sm-3 form-control-label">@lang('sistema.alta_de_cuentas.country_label')<span class="text-danger">*</span></label>
                                    <div class="col-sm-9 input_controls">
                                        <select class="form-control" id="country" name="country" valida="SI" cadena ="{{__('sistema.alta_de_cuentas.country_error')}}">
                                            <option value=""></option>
                                            @foreach($countries as $country)
                                                <option value="{{ $country->id }}">{{ $country->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-lg-6 row m-0">
                                    <label for="state" class="col-sm-3 form-control-label">@lang('sistema.alta_de_cuentas.state_label')<span class="text-danger">*</span></label>
                                    <div class="col-sm-9 input_controls">
                                        <input type="text" class="form-control" id="state" name="state" placeholder="{{__('sistema.alta_de_cuentas.state_label')}}" valida="SI" cadena ="{{__('sistema.alta_de_cuentas.state_error')}}" value="{{ (old('state'))? old('state'):'' }}">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-lg-12 row">
                                <div class="form-group col-lg-6 row m-0">
                                    <label for="city" class="col-sm-3 form-control-label">@lang('sistema.alta_de_cuentas.city_label')<span class="text-danger">*</span></label>
                                    <div class="col-sm-9 input_controls">
                                        <input type="text" class="form-control" id="city" name="city" placeholder="{{__('sistema.alta_de_cuentas.city_label')}}" valida="SI" cadena ="{{__('sistema.alta_de_cuentas.city_error')}}" value="{{ (old('city'))? old('city'):'' }}">
                                    </div>
                                </div>
                            </div>

                            <h4 class="m-b-30 m-t-30 header-title"><b>@lang('sistema.alta_de_cuentas.dest_account_label')</b><hr></h4>

                            <div class="form-group col-lg-12 row">
                                <div class="form-group col-lg-6 row m-0">
                                    <label for="dest_bank_country" class="col-sm-3 form-control-label">@lang('sistema.alta_de_cuentas.dest_bank_country')<span class="text-danger">*</span></label>
                                    <div class="col-sm-9 input_controls">
                                        <select class="form-control" id="dest_bank_country" name="dest_bank_country" valida="SI" cadena ="{{__('sistema.alta_de_cuentas.dest_bank_country_err')}}">
                                            <option value=""></option>
                                            @foreach($countries as $country)
                                                <option value="{{ $country->id }}">{{ $country->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-lg-6 row m-0">
                                    <label for="dest_account_number" class="col-sm-3 form-control-label">@lang('sistema.alta_de_cuentas.account_number')<span class="text-danger">*</span></label>
                                    <div class="col-sm-9 input_controls">
                                        <input type="text" class="form-control" id="dest_account_number" name="dest_account_number" placeholder="{{__('sistema.alta_de_cuentas.account_number')}}" valida="SI" cadena ="{{__('sistema.alta_de_cuentas.account_number_error')}}" value="{{ (old('dest_account_number'))? old('dest_account_number'):'' }}">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-lg-12 row">
                                <div class="form-group col-lg-6 row m-0">
                                    <label for="dest_swift" class="col-sm-3 form-control-label">@lang('sistema.alta_de_cuentas.dest_bank_swift')<span class="text-danger">*</span></label>
                                    <div class="col-sm-9 input_controls">
                                        <input type="text" class="form-control" id="dest_swift" name="dest_swift" placeholder="{{__('sistema.alta_de_cuentas.dest_bank_swift')}}" valida="SI" cadena ="{{__('sistema.alta_de_cuentas.dest_bank_swift_error')}}" value="{{ (old('dest_swift'))? old('dest_swift'):'' }}">
                                    </div>
                                </div>
                                <div class="form-group col-lg-6 row m-0">
                                    <label for="dest_bank_name" class="col-sm-3 form-control-label">@lang('sistema.alta_de_cuentas.dest_int_bank_label')<span class="text-danger">*</span></label>
                                    <div class="col-sm-9 input_controls">
                                        <input type="text" class="form-control" id="dest_bank_name" name="dest_bank_name" placeholder="{{__('sistema.alta_de_cuentas.dest_int_bank_label')}}" valida="SI" cadena ="{{__('sistema.alta_de_cuentas.dest_int_bank_error')}}" value="{{ (old('dest_bank_name'))? old('dest_bank_name'):'' }}">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-lg-12 row">
                                <div class="form-group col-lg-6 row m-0">
                                    <label for="dest_bank_address" class="col-sm-3 form-control-label">@lang('sistema.alta_de_cuentas.dest_bank_address')<span class="text-danger">*</span></label>
                                    <div class="col-sm-9 input_controls">
                                        <input type="text" class="form-control" id="dest_bank_address" name="dest_bank_address" placeholder="{{__('sistema.alta_de_cuentas.dest_bank_address')}}" valida="SI" cadena ="{{__('sistema.alta_de_cuentas.dest_bank_error')}}" value="{{ (old('dest_bank_address'))? old('dest_bank_address'):'' }}">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-lg-12 row">
                                <div class="form-group col-lg-6 row m-0">
                                    <div class="col-sm-12">
                                        <div class="checkbox checkbox-custom m-t-0">
                                            <label class="m-b-0 ckCursor" for="intermediary_banking">
                                                <input type="checkbox" class="intermediary_banking_chk" value="1" name="intermediary_banking" id="intermediary_banking">
                                                <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                @lang('sistema.alta_de_cuentas.use_intermediate_bank')
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="add_form_banco_intermediario">
                            </div>
                        </div>

                        <div class="intermediario_bank_div" style="display: none;">
                            <br>
                            <div class="form-group col-lg-12 row">
                                <div class="form-group col-lg-6 row m-0">
                                    <label for="intermediary_bank_country" class="col-sm-3 form-control-label">@lang('sistema.alta_de_cuentas.dest_int_bank_country')<span class="text-danger">*</span></label>
                                    <div class="col-sm-9 input_controls">
                                        <select class="form-control" id="intermediary_bank_country" name="intermediary_bank_country" valida="SI" cadena ="{{__('sistema.alta_de_cuentas.dest_int_bank_cou_err')}}">
                                            <option value=""></option>
                                            @foreach($countries as $country)
                                                <option value="{{ $country->id }}">{{ $country->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-lg-6 row m-0">
                                    <label for="intermediary_bank_account" class="col-sm-3 form-control-label">@lang('sistema.alta_de_cuentas.account_number')<span class="text-danger">*</span></label>
                                    <div class="col-sm-9 input_controls">
                                        <input type="text" class="form-control" id="intermediary_bank_account" name="intermediary_bank_account" placeholder="{{__('sistema.alta_de_cuentas.account_number')}}" valida="SI" cadena ="{{__('sistema.alta_de_cuentas.account_number_error')}}" value="{{ (old('intermediary_bank_account'))? old('intermediary_bank_account'):'' }}">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-lg-12 row">
                                <div class="form-group col-lg-6 row m-0">
                                    <label for="intermediary_swift" class="col-sm-3 form-control-label">@lang('sistema.alta_de_cuentas.dest_bank_swift')<span class="text-danger">*</span></label>
                                    <div class="col-sm-9 input_controls">
                                        <input type="text" class="form-control" id="intermediary_swift" name="intermediary_swift" placeholder="{{__('sistema.alta_de_cuentas.dest_bank_swift')}}" valida="SI" cadena ="{{__('sistema.alta_de_cuentas.dest_bank_swift_error')}}" value="{{ (old('intermediary_swift'))? old('intermediary_swift'):'' }}">
                                    </div>
                                </div>
                                <div class="form-group col-lg-6 row m-0">
                                    <label for="intermediary_bank_name" class="col-sm-3 form-control-label">@lang('sistema.alta_de_cuentas.dest_int_bank_label')<span class="text-danger">*</span></label>
                                    <div class="col-sm-9 input_controls">
                                        <input type="text" class="form-control" id="intermediary_bank_name" name="intermediary_bank_name" placeholder="{{__('sistema.alta_de_cuentas.dest_int_bank_label')}}" valida="SI" cadena ="{{__('sistema.alta_de_cuentas.dest_int_bank_error')}}" value="{{ (old('intermediary_bank_name'))? old('intermediary_bank_name'):'' }}">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-lg-12 row">
                                <div class="form-group col-lg-6 row m-0">
                                    <label for="intermediary_bank_address" class="col-sm-3 form-control-label">@lang('sistema.alta_de_cuentas.address_label')<span class="text-danger">*</span></label>
                                    <div class="col-sm-9 input_controls">
                                        <input type="text" class="form-control" id="intermediary_bank_address" name="intermediary_bank_address" placeholder="{{__('sistema.alta_de_cuentas.address_label')}}" valida="SI" cadena ="{{__('sistema.alta_de_cuentas.address_error')}}" value="{{ (old('intermediary_bank_address'))? old('intermediary_bank_address'):'' }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--  Code for Internacional -->

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
    @if (session('type')=='error')            
        <script>
            swal({
                title:'@lang('sistema.users_alert')',
                text:'{{session('msg')}}',
                type:'error',
                timer: 5500,
                confirmButtonColor:'red',
                confirmButtonText:'OK'
            });
        </script>
    @endif

    <script type="text/javascript">

        $(function($) {        
            $(".select2").select2();
        });

        $('body').on('change', '#destination_type', function() {
            if($(this).val() == 'same'){
                $(".add_remaining_form").html($(".same_entity_div").html());
            }
            else if($(this).val() == 'international'){
                $(".add_remaining_form").html($(".international_div").html());
            }else{
                $(".add_remaining_form").html('');
            }
        });

        $('body').on('click', '.intermediary_banking_chk', function() {
            if($(this).is(':checked')){
                $('#frm_user_other_accounts').find(".add_form_banco_intermediario").html($(".intermediario_bank_div").html());
            }else{
                $('#frm_user_other_accounts').find(".add_form_banco_intermediario").html('');
            }
        });
        

        function validateFrm()
        {
            var listv = 0;
            var msg = '';

            $('#frm_user_other_accounts').find(':input').each(function() {
                if($(this).attr("valida")=="SI" && ($(this).val()==""||$(this).val()=="null"))
                {
                    listv=1;
                    $(this).parent('.input_controls').addClass('has-error');
                    msg+=$(this).attr('cadena')+'\n';
                    
                    //$(this).val($(this).val().toUpperCase());
                }else
                {
                      $(this).parent('.input_controls').removeClass('has-error');
                      if($(this).attr("valida")=="SI")
                      {
                          //$(this).val($(this).val().toUpperCase());
                      }
                }
            });

            if(listv==1)
            {
                swal({
                    title:'@lang('sistema.users_alert')',
                    text:msg,
                    type:'error',
                    timer: 4000,
                    confirmButtonColor:'red',
                    confirmButtonText:'OK'
                  });
                return false;
            }else{
                return true;
            }
        }
    </script>
@endsection