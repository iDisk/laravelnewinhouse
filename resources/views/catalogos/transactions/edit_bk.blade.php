@extends('layouts.main')
@section('customcss')
<link href="{{ url('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ url('assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet">
<link href="{{ url('assets/plugins/intlTelInput/build/css/intlTelInput.css') }}" rel="stylesheet">
<style type="text/css">
  .datepicker>div{
      display: block;
  }
  .intl-tel-input{
    width: 100%;
  }
</style>
@endsection

@section('pagecontent')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <h4 class="page-title">@lang('sistema.client.edit_account')</h4>
                        <ol class="breadcrumb p-0 m-0">
                            <li>
                                <a href="{{ url('clients') }}">
                                    @lang('sistema.client.accounts')
                                </a>
                            </li>
                            <li class="active">
                                @lang('sistema.client.edit_account')
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
                          <!--<p></p>-->
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

                                  <form class="form-horizontal"  method="POST" action="{{url('clients/'.$account->id)}}" id="frm_clients" enctype="multipart/form-data" onsubmit="return validateFrm();">
                                      {{ csrf_field() }}
                                      {{ method_field('PUT') }}
                                      <h4 class="m-b-30 m-t-0 header-title"><b>@lang('sistema.client.account_information')</b><hr></h4>

                                      <div class="form-group col-lg-12 row">
                                      <div class="form-group col-lg-6 row m-0" id="inputbroker_id">
                                          <label for="broker_id" class="col-sm-3 form-control-label">@lang('sistema.client.broker')<span class="text-danger">*</span></label>
                                          <div class="col-sm-9">
                                              <select id="broker_id" class="form-control" name="account[broker_id]" valida="SI" cadena="{{__('sistema.client.broker_valid')}}">
                                                  <option value="">@lang('sistema.btn_select')</option>
                                                  @foreach($brokers as $key=>$value)
                                                      <option value="{{ $key }}" {{ ($key == $account->broker_id)? 'selected':'' }}>{{ $value }}</option>
                                                  @endforeach
                                              </select>
                                          </div>
                                      </div>

                                      <div class="form-group col-lg-6 row m-0" id="inputtype_of_acc">
                                          <label for="type_of_acc" class="col-sm-3 form-control-label">@lang('sistema.client.type_of_acc')<span class="text-danger">*</span></label>
                                          <div class="col-sm-9">
                                              <select id="type_of_acc" class="form-control" disabled name="account[account_type]" valida="SI" cadena="{{__('sistema.client.type_of_acc_valid')}}">
                                                  <option value="">@lang('sistema.btn_select')</option>
                                                  <option value="individual" {{ ($account->account_type == 'individual')? 'selected':'' }}>Individual</option>
                                                  <option value="joint" {{ ($account->account_type == 'joint')? 'selected':'' }}>Joint</option>
                                                  <option value="business" {{ ($account->account_type == 'business')? 'selected':'' }}>Business</option>
                                              </select>
                                              <input type="hidden" name="account[account_type_temp]" value="{{ $account->account_type }}">
                                          </div>
                                      </div>
                                    </div>

                                    <div class="form-group col-lg-12 row">
                                      <div class="form-group col-lg-6 row m-0" id="inputacc_number">
                                          <label for="acc_number" class="col-sm-3 form-control-label">@lang('sistema.client.acc_number')<span class="text-danger">*</span></label>
                                          <div class="col-sm-9">
                                              <input type="text" class="form-control" id="acc_number" name="account[account_number]" placeholder="{{__('sistema.client.acc_number')}}" valida="SI" cadena ="{{__('sistema.client.acc_number_valid')}}" value="{{ $account->account_number }}" disabled>
                                              <input type="hidden" id="acc_number_temp" name="acc_number_temp" value="{{ $account->account_number }}">
                                          </div>
                                      </div>

                                      <div class="form-group col-lg-6 row m-0" id="inputfinancial_service">
                                          <label for="financial_service" class="col-sm-3 form-control-label">@lang('sistema.client.financial_service')<span class="text-danger">*</span></label>
                                          <div class="col-sm-9">
                                              <select class="form-control" placeholder="{{__('sistema.client.financial_service')}}"  valida="SI" cadena ="{{__('sistema.client.financial_service_valid')}}" name="financial_service[]" id="financial_service" multiple="multiple">
                                                  @foreach($financial_services as $key=>$value)
                                                      <option value="{{ $key }}" {{ (in_array($key,$account_financial_services))?'selected':'' }}>{{ $value}}</option>
                                                  @endforeach
                                              </select>
                                          </div>
                                      </div>
                                    </div>
                                    @if($account->account_type == 'business')
                                      <div class="client_personal_info">
                                        <h4 class="m-b-30 m-t-30 header-title"><b>@lang('sistema.client.entity_detail')</b><hr></h4>

                                        <div class="form-group col-lg-12 row">
                                          <div class="form-group col-lg-6 row m-0">
                                            <label class="col-sm-3 form-control-label">@lang('sistema.client.registered_name')<span class="text-danger">*</span></label>
                                            <div class="col-sm-9">
                                              <input type="text" class="form-control" name="business_detail[registered_name]" placeholder="{{__('sistema.client.registered_name')}}" valida="SI" cadena ="{{__('sistema.client.registered_name_valid')}}" value="{{ $business_detail->registered_name }}">
                                            </div>
                                          </div>

                                          <div class="form-group col-lg-6 row m-0">
                                            <label class="col-sm-3 form-control-label">@lang('sistema.client.type_of_entity')<span class="text-danger">*</span></label>
                                            <div class="col-sm-9">
                                              <input type="text" class="form-control" name="business_detail[business_type]" placeholder="{{__('sistema.client.type_of_entity')}}" valida="SI" cadena ="{{__('sistema.client.type_of_entity_valid')}}" value="{{ $business_detail->business_type }}">
                                            </div>
                                          </div>
                                        </div>

                                        <div class="form-group col-lg-12 row">
                                          <div class="form-group col-lg-6 row m-0">
                                            <label class="col-sm-3 form-control-label">@lang('sistema.client.authorised_signatories1')<span class="text-danger">*</span></label>
                                            <div class="col-sm-9">
                                              <input type="text" class="form-control" name="business_detail[authorised_signatories1]" placeholder="{{__('sistema.client.authorised_signatories1')}}" valida="SI" cadena ="{{__('sistema.client.authorised_signatories1_valid')}}" value="{{ $business_detail->authorised_signatories1 }}">
                                            </div>
                                          </div>

                                          <div class="form-group col-lg-6 row m-0">
                                            <label class="col-sm-3 form-control-label">@lang('sistema.client.authorised_signatories2')<span class="text-danger">*</span></label>
                                            <div class="col-sm-9">
                                              <input type="text" class="form-control" name="business_detail[authorised_signatories2]" placeholder="{{__('sistema.client.authorised_signatories2')}}" valida="SI" cadena ="{{__('sistema.client.authorised_signatories2_valid')}}" value="{{ $business_detail->authorised_signatories2 }}">
                                            </div>
                                          </div>
                                        </div>

                                        <div class="form-group col-lg-12 row">
                                          <div class="form-group col-lg-6 row m-0">
                                            <label class="col-sm-3 form-control-label">@lang('sistema.client.registration_number')<span class="text-danger">*</span></label>
                                            <div class="col-sm-9">
                                              <input type="text" class="form-control" name="business_detail[registration_number]" placeholder="{{__('sistema.client.registration_number')}}" valida="SI" cadena ="{{__('sistema.client.registration_number_valid')}}" value="{{ $business_detail->registration_number }}">
                                            </div>
                                          </div>

                                          <div class="form-group col-lg-6 row m-0">
                                            <label class="col-sm-3 form-control-label">@lang('sistema.client.incorporation_date')<span class="text-danger">*</span></label>
                                            <div class="col-sm-9">
                                              <input type="text" class="form-control date_picker" name="business_detail[incorporation_date]" placeholder="{{__('sistema.client.incorporation_date')}}" valida="SI" cadena ="{{__('sistema.client.incorporation_date_valid')}}" value="{{ \Carbon\Carbon::parse($business_detail->incorporation_date)->format('d/m/Y') }}">
                                            </div>
                                          </div>
                                        </div>

                                        <div class="form-group col-lg-12 row">
                                          <div class="form-group col-lg-6 row m-0">
                                            <label class="col-sm-3 form-control-label">@lang('sistema.client.incorporation_place')<span class="text-danger">*</span></label>
                                            <div class="col-sm-9">
                                              <input type="text" class="form-control" name="business_detail[incorporation_place]" placeholder="{{__('sistema.client.incorporation_place')}}" valida="SI" cadena ="{{__('sistema.client.incorporation_place_valid')}}" value="{{ $business_detail->incorporation_place }}">
                                            </div>
                                          </div>

                                          <div class="form-group col-lg-6 row m-0">
                                            <label class="col-sm-3 form-control-label">@lang('sistema.client.entity_country')<span class="text-danger">*</span></label>
                                            <div class="col-sm-9">
                                              <select class="form-control client_country" name="business_detail[country]" valida="SI" cadena="{{__('sistema.client.entity_country_valid')}}">
                                                <option value="">@lang('sistema.btn_select')</option>
                                                @foreach($countries as $country)
                                                  <option value="{{ $country->id }}" {{ ($business_detail->country == $country->id)?'selected':''}}>{{ $country->name }}</option>
                                                @endforeach
                                              </select>
                                            </div>
                                          </div>
                                        </div>

                                        <div class="form-group col-lg-12 row">
                                          <div class="form-group col-lg-6 row m-0">
                                            <label class="col-sm-3 form-control-label">@lang('sistema.client.entity_state')<span class="text-danger">*</span></label>
                                            <div class="col-sm-9">
                                              <select class="form-control state" name="business_detail[state]" valida="SI" cadena="{{__('sistema.client.entity_state_valid')}}">
                                                <option value="">@lang('sistema.btn_select')</option>
                                              </select>
                                              <input type="hidden" class="state_temp" name="state_temp" value="{{ $business_detail->state }}">
                                            </div>
                                          </div>
                                          <div class="form-group col-lg-6 row m-0">
                                            <label class="col-sm-3 form-control-label">@lang('sistema.client.entity_city')<span class="text-danger">*</span></label>
                                            <div class="col-sm-9">
                                              <select class="form-control city" name="business_detail[city]" valida="SI" cadena="{{__('sistema.client.entity_city_valid')}}">
                                                <option value="">@lang('sistema.btn_select')</option>
                                              </select>
                                              <input type="hidden" class="city_temp" name="city_temp" value="{{ $business_detail->city }}">
                                            </div>
                                          </div>
                                        </div>

                                        <div class="form-group col-lg-12 row">
                                          <div class="form-group col-lg-6 row m-0">
                                            <label class="col-sm-3 form-control-label">@lang('sistema.client.entity_address')<span class="text-danger">*</span></label>
                                            <div class="col-sm-9">
                                              <input type="text" class="form-control" name="business_detail[address]" placeholder="{{__('sistema.client.entity_address')}}" valida="SI" cadena ="{{__('sistema.client.entity_address_valid')}}" value="{{ $business_detail->address }}">
                                            </div>
                                          </div>
                                          <div class="form-group col-lg-6 row m-0">
                                            <label class="col-sm-3 form-control-label">@lang('sistema.client.entity_county')<span class="text-danger">*</span></label>
                                            <div class="col-sm-9">
                                              <input type="text" class="form-control" name="business_detail[county]" placeholder="{{__('sistema.client.entity_county')}}" valida="SI" cadena ="{{__('sistema.client.entity_county_valid')}}" value="{{ $business_detail->county }}">
                                            </div>
                                          </div>
                                        </div>
                                        <div class="form-group col-lg-12 row">
                                          <div class="form-group col-lg-6 row m-0">
                                            <label class="col-sm-3 form-control-label">@lang('sistema.client.entity_zip_code')<span class="text-danger">*</span></label>
                                            <div class="col-sm-9">
                                              <input type="text" class="form-control" name="business_detail[zip_code]" placeholder="{{__('sistema.client.entity_zip_code')}}" valida="SI" cadena ="{{__('sistema.client.entity_zip_code_valid')}}" value="{{ $business_detail->zip_code }}">
                                            </div>
                                          </div>
                                        </div>

                                        <div class="form-group col-lg-12 row">
                                          <div class="form-group col-lg-6 row m-0">
                                            <label class="col-sm-3 form-control-label">@lang('sistema.client.entity_industry_type')</label>
                                            <div class="col-sm-9">
                                              <input type="text" class="form-control" name="business_detail[industry_type]" placeholder="{{__('sistema.client.entity_industry_type')}}" value="{{ $business_detail->industry_type }}">
                                            </div>
                                          </div>
                                          <div class="form-group col-lg-6 row m-0">
                                            <label class="col-sm-3 form-control-label">@lang('sistema.client.entity_employees')</label>
                                            <div class="col-sm-9">
                                              <input type="text" class="form-control" name="business_detail[employees]" placeholder="{{__('sistema.client.entity_employees')}}" value="{{ $business_detail->employees }}">
                                            </div>
                                          </div>
                                        </div>

                                        <div class="form-group col-lg-12 row">
                                          <div class="form-group col-lg-6 row m-0">
                                            <label class="col-sm-3 form-control-label">@lang('sistema.client.entity_webiste')</label>
                                            <div class="col-sm-9">
                                              <input type="text" class="form-control" name="business_detail[webiste]" placeholder="{{__('sistema.client.entity_webiste')}}" value="{{ $business_detail->webiste }}">
                                            </div>
                                          </div>
                                        </div>

                                        <div class="form-group col-lg-12 row">
                                          <div class="form-group col-lg-6 row m-0">
                                            <label class="col-sm-3 form-control-label">@lang('sistema.client.entity_telephone1')<span class="text-danger">*</span></label>
                                            <div class="col-sm-9">
                                              <input type="text" class="form-control inttel_input" name="business_detail[telephone1]" placeholder="{{__('sistema.client.entity_telephone1')}}" valida="SI" cadena ="{{__('sistema.client.entity_telephone1_valid')}}" value="{{ $business_detail->telephone1 }}">
                                            </div>
                                          </div>
                                          <div class="form-group col-lg-6 row m-0">
                                            <label class="col-sm-3 form-control-label">@lang('sistema.client.entity_telephone2')</label>
                                            <div class="col-sm-9">
                                              <input type="text" class="form-control" name="business_detail[telephone2]" placeholder="{{__('sistema.client.entity_telephone2')}}" value="{{ $business_detail->telephone2 }}">
                                            </div>
                                          </div>
                                        </div>

                                        <div class="form-group col-lg-12 row">
                                          <div class="form-group col-lg-6 row m-0">
                                            <label class="col-sm-3 form-control-label">@lang('sistema.client.entity_telephone3')</label>
                                            <div class="col-sm-9">
                                              <input type="text" class="form-control" name="business_detail[telephone3]" placeholder="{{__('sistema.client.entity_telephone3')}}" value="{{ $business_detail->telephone3 }}">
                                            </div>
                                          </div>
                                        </div>

                                        <div class="form-group col-lg-12 row">
                                          <div class="form-group col-lg-6 row m-0">
                                            <label class="col-sm-3 form-control-label">@lang('sistema.client.entity_email1')<span class="text-danger">*</span></label>
                                            <div class="col-sm-9">
                                              <input type="text" class="form-control valid_email" name="business_detail[email1]" placeholder="{{__('sistema.client.entity_email1')}}" valida="SI" cadena ="{{__('sistema.client.entity_email1_valid')}}" value="{{ $business_detail->email1 }}">
                                            </div>
                                          </div>
                                          <div class="form-group col-lg-6 row m-0">
                                            <label class="col-sm-3 form-control-label">@lang('sistema.client.entity_email2')</label>
                                            <div class="col-sm-9">
                                              <input type="text" class="form-control valid_email" name="business_detail[email2]" placeholder="{{__('sistema.client.entity_email2')}}" value="{{ $business_detail->email2 }}">
                                            </div>
                                          </div>
                                        </div>
                                        </div>
                                    @endif
                                    @if(count($account->clients) > 0)
                                        @php
                                          $i = 1; 
                                        @endphp
                                        @foreach($account->clients as $client)
                                        <div class="client_personal_info">
                                            <h4 class="m-b-30 m-t-30 header-title"><b>@lang('sistema.client.account_holder_information')
                                              @if(count($account->clients) > 1 )
                                                {{ "(".$i.")" }}
                                              @endif
                                            </b><hr></h4>

                                              <div class="form-group col-lg-12 row">
                                                <div class="form-group col-lg-6 row m-0">
                                                    <label class="col-sm-3 form-control-label">@lang('sistema.client.first_name')<span class="text-danger">*</span></label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" name="client[first_name][]" placeholder="{{__('sistema.client.first_name')}}" valida="SI" cadena ="{{__('sistema.client.first_name_valid')}}" value="{{ $client->first_name }}">
                                                    </div>
                                                </div>

                                                <div class="form-group col-lg-6 row m-0">
                                                    <label class="col-sm-3 form-control-label">@lang('sistema.client.middle_name')<span class="text-danger">*</span></label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" name="client[middle_name][]" placeholder="{{__('sistema.client.middle_name')}}" valida="SI" cadena ="{{__('sistema.client.middle_name_valid')}}" value="{{ $client->middle_name }}">
                                                    </div>
                                                </div>
                                              </div>

                                              <div class="form-group col-lg-12 row">
                                                <div class="form-group col-lg-6 row m-0">
                                                    <label class="col-sm-3 form-control-label">@lang('sistema.client.surname1')<span class="text-danger">*</span></label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" name="client[surname1][]" placeholder="{{__('sistema.client.surname1')}}" valida="SI" cadena ="{{__('sistema.client.surname1_valid')}}" value="{{ $client->surname1 }}">
                                                    </div>
                                                </div>

                                                <div class="form-group col-lg-6 row m-0">
                                                    <label class="col-sm-3 form-control-label">@lang('sistema.client.surname2')<span class="text-danger">*</span></label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" name="client[surname2][]" placeholder="{{__('sistema.client.surname2')}}" valida="SI" cadena ="{{__('sistema.client.surname2_valid')}}" value="{{ $client->surname2 }}">
                                                    </div>
                                                </div>
                                              </div>

                                              <div class="form-group col-lg-12 row">
                                                <div class="form-group col-lg-6 row m-0">
                                                    <label class="col-sm-3 form-control-label">@lang('sistema.client.national_identity_doc')<span class="text-danger">*</span></label>
                                                    <div class="col-sm-9">
                                                        <select class="form-control" name="client[national_identity_doc_id][]" valida="SI" cadena="{{__('sistema.client.national_identity_doc_valid')}}">
                                                            <option value="">@lang('sistema.btn_select')</option>
                                                            @foreach($national_identity_docs as $key=>$value)
                                                                <option value="{{ $key }}" {{ ($key == $client->national_identity_doc_id)? 'selected':'' }}>{{ $value }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="form-group col-lg-6 row m-0">
                                                    <label class="col-sm-3 form-control-label">@lang('sistema.client.national_identity_number')<span class="text-danger">*</span></label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" name="client[national_identity_number][]" placeholder="{{__('sistema.client.national_identity_number')}}" valida="SI" cadena ="{{__('sistema.client.national_identity_number_valid')}}" value="{{ $client->national_identity_number }}">
                                                    </div>
                                                </div>
                                              </div>

                                              <div class="form-group col-lg-12 row">
                                                <div class="form-group col-lg-6 row m-0">
                                                    <label class="col-sm-3 form-control-label">@lang('sistema.client.national_identity_file')</label>
                                                    <div class="col-sm-9">
                                                        <input type="file" class="form-control filestyle" name="national_identity_file[]"  data-buttonname="btn-info" data-buttontext="{{__('sistema.btn_choose_file')}}" placeholder="{{__('sistema.client.national_identity_file')}}">
                                                    </div>
                                                </div>
                                              </div>

                                              <div class="form-group col-lg-12 row">
                                                <div class="form-group col-lg-6 row m-0">
                                                    <label class="col-sm-3 form-control-label">@lang('sistema.client.dob')<span class="text-danger">*</span></label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control date_picker" name="client[dob][]" placeholder="{{__('sistema.client.dob')}}" valida="SI" cadena ="{{__('sistema.client.dob_valid')}}" value="{{ \Carbon\Carbon::parse($client->dob)->format('d/m/Y') }}">
                                                    </div>
                                                </div>

                                                <div class="form-group col-lg-6 row m-0">
                                                    <label class="col-sm-3 form-control-label">@lang('sistema.client.gender')<span class="text-danger">*</span></label>
                                                    <div class="col-sm-9">
                                                        <select class="form-control" name="client[gender][]" valida="SI" cadena="{{__('sistema.client.gender_valid')}}">
                                                            <option value="">@lang('sistema.btn_select')</option>
                                                            <option value="Male" {{ ($client->gender == 'Male')? 'selected':'' }}>@lang('sistema.client.male')</option>
                                                            <option value="Female" {{ ($client->gender == 'Female')? 'selected':'' }}>@lang('sistema.client.female')</option>
                                                        </select>
                                                    </div>
                                                </div>
                                              </div>

                                              <div class="form-group col-lg-12 row">
                                                <div class="form-group col-lg-6 row m-0">
                                                    <label class="col-sm-3 form-control-label">@lang('sistema.client.birth_place')<span class="text-danger">*</span></label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" name="client[birth_place][]" placeholder="{{__('sistema.client.birth_place')}}" valida="SI" cadena ="{{__('sistema.client.birth_place_valid')}}" value="{{ $client->birth_place }}">
                                                    </div>
                                                </div>

                                                <div class="form-group col-lg-6 row m-0">
                                                    <label class="col-sm-3 form-control-label">@lang('sistema.client.birth_country')<span class="text-danger">*</span></label>
                                                    <div class="col-sm-9">
                                                        <select class="form-control" name="client[birth_country][]" valida="SI" cadena="{{__('sistema.client.birth_country_valid')}}">
                                                            <option value="">@lang('sistema.btn_select')</option>
                                                            @foreach($countries as $country)
                                                                <option value="{{ $country->id }}" {{ ($client->birth_country == $country->id)?'selected':''}}>{{ $country->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                              </div>

                                              <div class="form-group col-lg-12 row">
                                                <div class="form-group col-lg-6 row m-0">
                                                    <label class="col-sm-3 form-control-label">@lang('sistema.client.nationality')<span class="text-danger">*</span></label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" name="client[nationality][]" placeholder="{{__('sistema.client.nationality')}}" valida="SI" cadena ="{{__('sistema.client.nationality_valid')}}" value="{{ $client->nationality }}">
                                                    </div>
                                                </div>
                                                @if($account->account_type != 'business')
                                                <div class="form-group col-lg-6 row m-0">
                                                    <label class="col-sm-3 form-control-label">@lang('sistema.client.address')<span class="text-danger">*</span></label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" name="client[address][]" placeholder="{{__('sistema.client.address')}}" valida="SI" cadena ="{{__('sistema.client.address_valid')}}" value="{{ $client->address }}">
                                                    </div>
                                                </div>
                                                @endif
                                              </div>
                                              @if($account->account_type != 'business')
                                                  <div class="form-group col-lg-12 row">
                                                <div class="form-group col-lg-6 row m-0">
                                                    <label class="col-sm-3 form-control-label">@lang('sistema.client.country')<span class="text-danger">*</span></label>
                                                    <div class="col-sm-9">
                                                        <select class="form-control client_country" name="client[country][]" valida="SI" cadena="{{__('sistema.client.country_valid')}}">
                                                            <option value="">@lang('sistema.btn_select')</option>
                                                            @foreach($countries as $country)
                                                                <option value="{{ $country->id }}" {{ ($client->country == $country->id)?'selected':''}}>{{ $country->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="form-group col-lg-6 row m-0">
                                                    <label class="col-sm-3 form-control-label">@lang('sistema.client.state')<span class="text-danger">*</span></label>
                                                    <div class="col-sm-9">
                                                        <select class="form-control state" name="client[state][]" valida="SI" cadena="{{__('sistema.client.state_valid')}}">
                                                            <option value="">@lang('sistema.btn_select')</option>
                                                        </select>
                                                        <input type="hidden" class="state_temp" name="state_temp" value="{{ $client->state }}">
                                                    </div>
                                                </div>

                                              </div>

                                              <div class="form-group col-lg-12 row">
                                                <div class="form-group col-lg-6 row m-0">
                                                    <label class="col-sm-3 form-control-label">@lang('sistema.client.city')<span class="text-danger">*</span></label>
                                                    <div class="col-sm-9">
                                                        <select class="form-control city" name="client[city][]" valida="SI" cadena="{{__('sistema.client.city_valid')}}">
                                                            <option value="">@lang('sistema.btn_select')</option>
                                                        </select>
                                                        <input type="hidden" class="city_temp" name="city_temp" value="{{ $client->city }}">
                                                    </div>
                                                </div>

                                                <div class="form-group col-lg-6 row m-0">
                                                    <label class="col-sm-3 form-control-label">@lang('sistema.client.zip_code')<span class="text-danger">*</span></label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" name="client[zip_code][]" placeholder="{{__('sistema.client.zip_code')}}" valida="SI" cadena ="{{__('sistema.client.zip_code_valid')}}" value="{{ $client->zip_code }}">
                                                    </div>
                                                </div>
                                              </div>

                                              <div class="form-group col-lg-12 row">
                                                  <div class="form-group col-lg-6 row m-0">
                                                    <label class="col-sm-3 form-control-label">@lang('sistema.client.county')<span class="text-danger">*</span></label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" name="client[county][]" placeholder="{{__('sistema.client.county')}}" valida="SI" cadena ="{{__('sistema.client.county_valid')}}" value="{{ $client->county }}">
                                                    </div>
                                                </div>
                                              </div>

                                              <div class="form-group col-lg-12 row">
                                                <div class="form-group col-lg-6 row m-0">
                                                    <label class="col-sm-3 form-control-label">@lang('sistema.client.company')</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" name="client[company][]" placeholder="{{__('sistema.client.company')}}" value="{{ $client->company }}">
                                                    </div>
                                                </div>
                                                <div class="form-group col-lg-6 row m-0">
                                                    <label class="col-sm-3 form-control-label">@lang('sistema.client.industry_type')</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" name="client[industry_type][]" placeholder="{{__('sistema.client.industry_type')}}" value="{{ $client->industry_type }}">
                                                    </div>
                                                </div>
                                              </div>

                                              <div class="form-group col-lg-12 row">
                                                <div class="form-group col-lg-6 row m-0">
                                                    <label class="col-sm-3 form-control-label">@lang('sistema.client.occupation')</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" name="client[occupation][]" placeholder="{{__('sistema.client.occupation')}}" value="{{ $client->occupation }}">
                                                    </div>
                                                </div>

                                                <div class="form-group col-lg-6 row m-0">
                                                    <label class="col-sm-3 form-control-label">@lang('sistema.client.marrital_status')</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" name="client[marrital_status][]" placeholder="{{__('sistema.client.marrital_status')}}" value="{{ $client->marrital_status }}">
                                                    </div>
                                                </div>
                                              </div>

                                              <div class="form-group col-lg-12 row">
                                                <div class="form-group col-lg-6 row m-0">
                                                    <label class="col-sm-3 form-control-label">@lang('sistema.client.spouse_name')</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" name="client[spouse_name][]" placeholder="{{__('sistema.client.spouse_name')}}"  value="{{ $client->spouse_name }}">
                                                    </div>
                                                </div>
                                              </div>
                                              @endif
                                              <div class="form-group col-lg-12 row">
                                                <div class="form-group col-lg-6 row m-0">
                                                    <label class="col-sm-3 form-control-label">@lang('sistema.client.telephone1')<span class="text-danger">*</span></label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control inttel_input" name="client[telephone1][]" placeholder="{{__('sistema.client.telephone1')}}" valida="SI" cadena ="{{__('sistema.client.telephone1_valid')}}" value="{{ $client->telephone1 }}">
                                                    </div>
                                                </div>

                                                <div class="form-group col-lg-6 row m-0">
                                                    <label class="col-sm-3 form-control-label">@lang('sistema.client.telephone2')</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" name="client[telephone2][]" placeholder="{{__('sistema.client.telephone2')}}" value="{{ $client->telephone2 }}">
                                                    </div>
                                                </div>
                                              </div>

                                              @if($account->account_type != 'business')
                                              <div class="form-group col-lg-12 row">
                                                <div class="form-group col-lg-6 row m-0">
                                                    <label class="col-sm-3 form-control-label">@lang('sistema.client.telephone3')</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" name="client[telephone3][]" placeholder="{{__('sistema.client.telephone3')}}" value="{{ $client->telephone3 }}">
                                                    </div>
                                                </div>
                                              </div>
                                              @endif

                                              <div class="form-group col-lg-12 row">
                                                <div class="form-group col-lg-6 row m-0">
                                                    <label class="col-sm-3 form-control-label">@lang('sistema.client.email1')<span class="text-danger">*</span></label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control valid_email" name="client[email1][]" placeholder="{{__('sistema.client.email1')}}" valida="SI" cadena ="{{__('sistema.client.email1_valid')}}" value="{{ $client->email1 }}">
                                                    </div>
                                                </div>

                                                <div class="form-group col-lg-6 row m-0">
                                                    <label class="col-sm-3 form-control-label">@lang('sistema.client.email2')</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control valid_email" name="client[email2][]" placeholder="{{__('sistema.client.email2')}}" value="{{ $client->email2 }}">
                                                    </div>
                                                </div>
                                              </div>
                                        </div>
                                        @php
                                          $i++;
                                        @endphp
                                        @endforeach
                                    @endif
                                    <h4 class="m-b-30 m-t-30 header-title">
                                        <b>@lang('sistema.client.beneficiaries')</b>
                                        <button class="btn btn-success add-more-beneficiary btn-xs m-l-15" type="button"><i class="fa fa-plus"></i> @lang('sistema.btn_add')</button>
                                        <hr>
                                    </h4>
                                    @if(count($account_beneficiaries) <= 0 )
                                    <div class="form-group col-lg-12 row">
                                      <div class="form-group col-lg-6 row m-0" id="inputbeneficiary_name">
                                          <label for="beneficiary_name" class="col-sm-3 form-control-label">@lang('sistema.client.beneficiary_name')<span class="text-danger">*</span></label>
                                          <div class="col-sm-9">
                                              <input type="text" class="form-control" id="beneficiary_name" name="beneficiary_name[]" placeholder="{{__('sistema.client.beneficiary_name')}}" valida="SI" cadena ="{{__('sistema.client.beneficiary_name_valid')}}" value="{{ old('beneficiary_name') }}">
                                          </div>
                                      </div>

                                      <div class="form-group col-lg-6 row m-0" id="inputbeneficiary_percentage">
                                          <label for="beneficiary_percentage" class="col-sm-3 form-control-label">@lang('sistema.client.beneficiary_percentage')<span class="text-danger">*</span></label>
                                          <div class="col-sm-9">
                                              <input type="text" class="form-control beneficiary_percent" id="beneficiary_percentage" name="beneficiary_percentage[]" placeholder="{{__('sistema.client.beneficiary_percentage')}}" valida="SI" cadena ="{{__('sistema.client.beneficiary_percentage_valid')}}" value="{{ old('beneficiary_percentage') }}">
                                          </div>
                                      </div>
                                    </div>
                                    @else
                                    @php $i=0; @endphp
                                    @foreach($account_beneficiaries as $value)
                                    @if($i == 0)
                                    <div class="form-group col-lg-12 row">
                                      <div class="form-group col-lg-6 row m-0" id="inputbeneficiary_name">
                                          <label for="beneficiary_name" class="col-sm-3 form-control-label">@lang('sistema.client.beneficiary_name')<span class="text-danger">*</span></label>
                                          <div class="col-sm-9">
                                              <input type="text" class="form-control" id="beneficiary_name" name="beneficiary_name[]" placeholder="{{__('sistema.client.beneficiary_name')}}" valida="SI" cadena ="{{__('sistema.client.beneficiary_name_valid')}}" value="{{ $value->name }}">
                                          </div>
                                      </div>

                                      <div class="form-group col-lg-6 row m-0" id="inputbeneficiary_percentage">
                                          <label for="beneficiary_percentage" class="col-sm-3 form-control-label">@lang('sistema.client.beneficiary_percentage')<span class="text-danger">*</span></label>
                                          <div class="col-sm-9">
                                              <input type="text" class="form-control beneficiary_percent" id="beneficiary_percentage" name="beneficiary_percentage[]" placeholder="{{__('sistema.client.beneficiary_percentage')}}" valida="SI" cadena ="{{__('sistema.client.beneficiary_percentage_valid')}}" value="{{ $value->percentage }}">
                                          </div>
                                      </div>
                                    </div>
                                    @else
                                    <div class="control-group">
                                    <div class="form-group col-lg-12 row m-b-0">
                                        <div class="form-group col-lg-6 m-0">
                                        </div>
                                        <div class="form-group col-lg-6 m-b-5">
                                            <button class="btn btn-danger remove pull-right m-r-5 btn-xs" type="button"><i class="glyphicon glyphicon-remove"></i> @lang('sistema.btn_remove')</button>
                                        </div>
                                    </div>
                                    <div class="form-group col-lg-12 row">
                                      <div class="form-group col-lg-6 row m-0" id="inputbeneficiary_name">
                                          <label for="beneficiary_name" class="col-sm-3 form-control-label">@lang('sistema.client.beneficiary_name')<span class="text-danger">*</span></label>
                                          <div class="col-sm-9">
                                              <input type="text" class="form-control" id="beneficiary_name" name="beneficiary_name[]" placeholder="{{__('sistema.client.beneficiary_name')}}" valida="SI" cadena ="{{__('sistema.client.beneficiary_name_valid')}}" value="{{ $value->name }}">
                                          </div>
                                      </div>

                                      <div class="form-group col-lg-6 row m-0" id="inputbeneficiary_percentage">
                                          <label for="beneficiary_percentage" class="col-sm-3 form-control-label">@lang('sistema.client.beneficiary_percentage')<span class="text-danger">*</span></label>
                                          <div class="col-sm-9">
                                              <input type="text" class="form-control beneficiary_percent" id="beneficiary_percentage" name="beneficiary_percentage[]" placeholder="{{__('sistema.client.beneficiary_percentage')}}" valida="SI" cadena ="{{__('sistema.client.beneficiary_percentage_valid')}}" value="{{ $value->percentage }}">
                                          </div>
                                      </div>
                                    </div>
                                    </div>
                                    @endif
                                    @php $i++ @endphp
                                    @endforeach
                                    @endif
                                    <div class="before-add-more"></div>

                                    <h4 class="m-b-30 m-t-30 header-title"><b>@lang('sistema.client.credit_capability')</b><hr></h4>

                                    <div class="form-group col-lg-12 row">
                                      <div class="form-group col-lg-6 row m-0" id="inputcredit_capability">
                                          <label for="credit_capability" class="col-sm-3 form-control-label">@lang('sistema.client.credit_capability')<span class="text-danger">*</span></label>
                                          <div class="col-sm-9">
                                              <select id="credit_capability" class="form-control" name="account[credit_capability]" valida="SI" cadena="{{__('sistema.client.credit_capability_valid')}}">
                                                  <option value="">@lang('sistema.btn_select')</option>
                                                  @for($i=0; $i<=20; $i++)
                                                    <option value="{{ $i }}" {{($i == $account->credit_capability)? 'selected':''}}>{{ $i }}</option>
                                                  @endfor
                                              </select>
                                          </div>
                                      </div>
                                    </div>

                                    <h4 class="m-b-30 m-t-30 header-title"><b>@lang('sistema.client.funding')</b><hr></h4>

                                    <div class="form-group col-lg-12 row">
                                      <div class="form-group col-lg-6 row m-0" id="inputopening_amount">
                                          <label for="opening_amount" class="col-sm-3 form-control-label">@lang('sistema.client.opening_amount')<span class="text-danger">*</span></label>
                                          <div class="col-sm-9">
                                              <input type="text" class="form-control" id="opening_amount" name="account[opening_amount]" placeholder="{{__('sistema.client.opening_amount')}}" valida="SI" cadena ="{{__('sistema.client.opening_amount_valid')}}" value="{{ $account->opening_amount }}">
                                          </div>
                                      </div>

                                      <div class="form-group col-lg-6 row m-0" id="inputdate_of_transfer">
                                          <label for="date_of_transfer" class="col-sm-3 form-control-label">@lang('sistema.client.date_of_transfer')<span class="text-danger">*</span></label>
                                          <div class="col-sm-9">
                                              <input type="text" class="form-control" id="date_of_transfer" name="account[date_of_transfer]" placeholder="{{__('sistema.client.date_of_transfer')}}" valida="SI" cadena ="{{__('sistema.client.date_of_transfer_valid')}}" value="{{ \Carbon\Carbon::parse($account->date_of_transfer)->format('d/m/Y') }}">
                                          </div>
                                      </div>
                                    </div>

                                    <div class="form-group col-lg-12 row">
                                      <div class="form-group col-lg-6 row m-0" id="inputsender_bank">
                                          <label for="sender_bank" class="col-sm-3 form-control-label">@lang('sistema.client.sender_bank')<span class="text-danger">*</span></label>
                                          <div class="col-sm-9">
                                              <input type="text" class="form-control" id="sender_bank" name="account[sender_bank]" placeholder="{{__('sistema.client.sender_bank')}}" valida="SI" cadena ="{{__('sistema.client.sender_bank_valid')}}" value="{{ $account->sender_bank }}">
                                          </div>
                                      </div>

                                      <div class="form-group col-lg-6 row m-0" id="inputfund_country">
                                          <label for="fund_country" class="col-sm-3 form-control-label">@lang('sistema.client.fund_country')<span class="text-danger">*</span></label>
                                          <div class="col-sm-9">
                                              <select id="fund_country" class="form-control" name="account[fund_country]" valida="SI" cadena="{{__('sistema.client.fund_country_valid')}}">
                                                  <option value="">@lang('sistema.btn_select')</option>
                                                  @foreach($countries as $country)
                                                      <option value="{{ $country->id }}" {{ ($account->fund_country == $country->id)?'selected':'' }}>{{ $country->name }}</option>
                                                  @endforeach
                                              </select>
                                          </div>
                                      </div>
                                    </div>

                                    <div class="form-group col-lg-12 row">
                                      <div class="form-group col-lg-6 row m-0" id="inputclearing_house">
                                          <label for="clearing_house" class="col-sm-3 form-control-label">@lang('sistema.client.clearing_house')<span class="text-danger">*</span></label>
                                          <div class="col-sm-9">
                                              <input type="text" class="form-control" id="clearing_house" name="account[clearing_house]" placeholder="{{__('sistema.client.clearing_house')}}" valida="SI" cadena ="{{__('sistema.client.clearing_house_valid')}}" value="{{ $account->clearing_house }}">
                                          </div>
                                      </div>

                                      <div class="form-group col-lg-6 row m-0" id="inputcustodian_bank">
                                          <label for="custodian_bank" class="col-sm-3 form-control-label">@lang('sistema.client.custodian_bank')<span class="text-danger">*</span></label>
                                          <div class="col-sm-9">
                                              <input type="text" class="form-control" id="custodian_bank" name="account[custodian_bank]" placeholder="{{__('sistema.client.custodian_bank')}}" valida="SI" cadena ="{{__('sistema.client.custodian_bank_valid')}}" value="{{ $account->custodian_bank }}">
                                          </div>
                                      </div>
                                    </div>

                                    <div class="form-group col-lg-12 row">
                                       <div class="form-group col-lg-6 row m-0" id="inputcredit_line_facility">
                                          <label for="credit_line_facility" class="col-sm-3 form-control-label">@lang('sistema.client.credit_line_facility')<span class="text-danger">*</span></label>
                                          <div class="col-sm-9">
                                              <select id="credit_line_facility" class="form-control" name="account[credit_line_facility]" valida="SI" cadena="{{__('sistema.client.credit_line_facility_valid')}}">
                                                  <option value="">@lang('sistema.btn_select')</option>
                                                    <option value="Yes" {{ ($account->credit_line_facility == 'Yes')?'selected':'' }}>@lang('sistema.client.yes')</option>
                                                    <option value="No" {{ ($account->credit_line_facility == 'No')?'selected':'' }}>@lang('sistema.client.no')</option>
                                              </select>
                                          </div>
                                      </div>
                                    </div>
                                    <div class="before-add-reference">
                                    
                                    @if($account->credit_line_facility == 'Yes')
                                    <h4 class="m-b-30 m-t-30 header-title"><b>@lang('sistema.client.reference1')</b><hr></h4>

                                    <div class="form-group col-lg-12 row">
                                      <div class="form-group col-lg-6 row m-0" id="inputreference1_name">
                                          <label for="reference1_name" class="col-sm-3 form-control-label">@lang('sistema.client.reference1_name')<span class="text-danger">*</span></label>
                                          <div class="col-sm-9">
                                              <input type="text" class="form-control" id="reference1_name" name="reference1_name" placeholder="{{__('sistema.client.reference1_name')}}" valida="SI" cadena ="{{__('sistema.client.reference1_name_valid')}}" value="{{ ( isset($account_references[0]->name))? $account_references[0]->name:'' }}">
                                          </div>
                                      </div>

                                      <div class="form-group col-lg-6 row m-0" id="inputreference1_relationship">
                                          <label for="reference1_relationship" class="col-sm-3 form-control-label">@lang('sistema.client.reference1_relationship')<span class="text-danger">*</span></label>
                                          <div class="col-sm-9">
                                              <input type="text" class="form-control" id="reference1_relationship" name="reference1_relationship" placeholder="{{__('sistema.client.reference1_relationship')}}" valida="SI" cadena ="{{__('sistema.client.reference1_relationship_valid')}}" value="{{ ( isset($account_references[0]->relationship))? $account_references[0]->relationship:old('reference1_relationship') }}">
                                          </div>
                                      </div>
                                    </div>

                                    <div class="form-group col-lg-12 row">
                                      <div class="form-group col-lg-6 row m-0" id="inputreference1_telephone">
                                          <label for="reference1_telephone" class="col-sm-3 form-control-label">@lang('sistema.client.reference1_telephone')<span class="text-danger">*</span></label>
                                          <div class="col-sm-9">
                                              <input type="text" class="form-control" id="reference1_telephone" name="reference1_telephone" placeholder="{{__('sistema.client.reference1_telephone')}}" valida="SI" cadena ="{{__('sistema.client.reference1_telephone_valid')}}" value="{{ ( isset($account_references[0]->telephone))? $account_references[0]->telephone:old('reference1_telephone') }}">
                                          </div>
                                      </div>
                                    </div>

                                    <h4 class="m-b-30 m-t-30 header-title"><b>@lang('sistema.client.reference2')</b><hr></h4>

                                    <div class="form-group col-lg-12 row">
                                      <div class="form-group col-lg-6 row m-0" id="inputreference2_name">
                                          <label for="reference2_name" class="col-sm-3 form-control-label">@lang('sistema.client.reference2_name')</label>
                                          <div class="col-sm-9">
                                              <input type="text" class="form-control" id="reference2_name" name="reference2_name" placeholder="{{__('sistema.client.reference2_name')}}" value="{{ (isset($account_references[1]->name) )? $account_references[1]->name:old('reference2_name') }}">
                                          </div>
                                      </div>

                                      <div class="form-group col-lg-6 row m-0" id="inputreference2_relationship">
                                          <label for="reference2_relationship" class="col-sm-3 form-control-label">@lang('sistema.client.reference2_relationship')</label>
                                          <div class="col-sm-9">
                                              <input type="text" class="form-control" id="reference2_relationship" name="reference2_relationship" placeholder="{{__('sistema.client.reference2_relationship')}}"  value="{{ ( isset($account_references[1]->relationship))? $account_references[1]->relationship:old('reference2_relationship') }}">
                                          </div>
                                      </div>
                                    </div>

                                    <div class="form-group col-lg-12 row">
                                      <div class="form-group col-lg-6 row m-0" id="inputreference2_telephone">
                                          <label for="reference2_telephone" class="col-sm-3 form-control-label">@lang('sistema.client.reference2_telephone')</label>
                                          <div class="col-sm-9">
                                              <input type="text" class="form-control" id="reference2_telephone" name="reference2_telephone" placeholder="{{__('sistema.client.reference2_telephone')}}"  value="{{ ( isset($account_references[1]->telephone))? $account_references[1]->telephone:old('reference2_telephone') }}">
                                          </div>
                                      </div>
                                    </div>

                                    <h4 class="m-b-30 m-t-30 header-title"><b>@lang('sistema.client.reference3')</b><hr></h4>
                                    <div class="form-group col-lg-12 row">
                                      <div class="form-group col-lg-6 row m-0" id="inputreference3_name">
                                          <label for="reference3_name" class="col-sm-3 form-control-label">@lang('sistema.client.reference3_name')</label>
                                          <div class="col-sm-9">
                                              <input type="text" class="form-control" id="reference3_name" name="reference3_name" placeholder="{{__('sistema.client.reference3_name')}}"  value="{{ ( isset($account_references[2]->name))? $account_references[2]->name:old('reference3_name') }}">
                                          </div>
                                      </div>

                                      <div class="form-group col-lg-6 row m-0" id="inputreference3_relationship">
                                          <label for="reference3_relationship" class="col-sm-3 form-control-label">@lang('sistema.client.reference3_relationship')</label>
                                          <div class="col-sm-9">
                                              <input type="text" class="form-control" id="reference3_relationship" name="reference3_relationship" placeholder="{{__('sistema.client.reference3_relationship')}}"  value="{{ ( isset($account_references[2]->relationship) )? $account_references[2]->relationship:old('reference3_relationship') }}">
                                          </div>
                                      </div>
                                    </div>

                                    <div class="form-group col-lg-12 row">
                                      <div class="form-group col-lg-6 row m-0" id="inputreference3_telephone">
                                          <label for="reference3_telephone" class="col-sm-3 form-control-label">@lang('sistema.client.reference3_telephone')</label>
                                          <div class="col-sm-9">
                                              <input type="text" class="form-control" id="reference3_telephone" name="reference3_telephone" placeholder="{{__('sistema.client.reference3_telephone')}}" value="{{ ( isset($account_references[2]->telephone) )? $account_references[2]->telephone:old('reference3_telephone') }}">
                                          </div>
                                      </div>
                                    </div>
                                    @endif
                                    </div>                                    

                                    <h4 class="m-b-30 m-t-30 header-title"><b>@lang('sistema.client.administrative_details')</b><hr></h4>
                                    <div class="form-group col-lg-12 row">
                                      <div class="form-group col-lg-6 row m-0" id="inputsales">
                                          <label for="sales" class="col-sm-3 form-control-label">@lang('sistema.client.sales')<span class="text-danger">*</span></label>
                                          <div class="col-sm-9">
                                              <select id="sales" class="form-control" name="account[sales]" valida="SI" cadena="{{__('sistema.client.sales_valid')}}">
                                                  <option value="">@lang('sistema.btn_select')</option>
                                                  @foreach($ventas as $venta)
                                                      <option value="{{ $venta->id }}" {{ ($account->sales == $venta->id)?'selected':'' }}>{{ $venta->name }}</option>
                                                  @endforeach
                                              </select>
                                          </div>
                                      </div>

                                      <div class="form-group col-lg-6 row m-0" id="inputmanager">
                                          <label for="manager" class="col-sm-3 form-control-label">@lang('sistema.client.manager')<span class="text-danger">*</span></label>
                                          <div class="col-sm-9">
                                              <select id="manager" class="form-control" name="account[manager]" valida="SI" cadena="{{__('sistema.client.manager_valid')}}">
                                                  <option value="">@lang('sistema.btn_select')</option>
                                                  @foreach($gerente as $gerent)
                                                      <option value="{{ $gerent->id }}" {{ ($account->manager == $gerent->id)?'selected':'' }}>{{ $gerent->name }}</option>
                                                  @endforeach
                                              </select>
                                          </div>
                                      </div>
                                    </div>

                                    <div class="form-group col-lg-12 row">
                                      <div class="form-group col-lg-6 row m-0" id="inputcustomer_care">
                                          <label for="customer_care" class="col-sm-3 form-control-label">@lang('sistema.client.customer_care')<span class="text-danger">*</span></label>
                                          <div class="col-sm-9">
                                              <select id="customer_care" class="form-control" name="account[customer_care]" valida="SI" cadena="{{__('sistema.client.customer_care_valid')}}">
                                                  <option value="">@lang('sistema.btn_select')</option>
                                                  @foreach($atencion_a_cliente as $atencion_a_client)
                                                      <option value="{{ $atencion_a_client->id }}" {{ ($account->customer_care == $atencion_a_client->id)?'selected':'' }}>{{ $atencion_a_client->name }}</option>
                                                  @endforeach
                                              </select>
                                          </div>
                                      </div>

                                      <div class="form-group col-lg-6 row m-0" id="inputanalyst">
                                          <label for="analyst" class="col-sm-3 form-control-label">@lang('sistema.client.analyst')<span class="text-danger">*</span></label>
                                          <div class="col-sm-9">
                                              <select id="analyst" class="form-control" name="account[analyst]" valida="SI" cadena="{{__('sistema.client.analyst_valid')}}">
                                                  <option value="">@lang('sistema.btn_select')</option>
                                                  @foreach($analista as $analist)
                                                      <option value="{{ $analist->id }}" {{ ($account->analyst == $analist->id)?'selected':'' }}>{{ $analist->name }}</option>
                                                  @endforeach
                                              </select>
                                          </div>
                                      </div>
                                    </div>

                                    <div class="form-group col-lg-12 row">
                                      <div class="form-group col-lg-6 row m-0" id="inputother1">
                                          <label for="other1" class="col-sm-3 form-control-label">@lang('sistema.client.other1')</label>
                                          <div class="col-sm-9">
                                              <input type="text" class="form-control" id="other1" name="account[other1]" placeholder="{{__('sistema.client.other1')}}" value="{{ $account->other1 }}">
                                          </div>
                                      </div>

                                      <div class="form-group col-lg-6 row m-0" id="inputother2">
                                          <label for="other2" class="col-sm-3 form-control-label">@lang('sistema.client.other2')</label>
                                          <div class="col-sm-9">
                                              <input type="text" class="form-control" id="other2" name="account[other2]" placeholder="{{__('sistema.client.other2')}}" value="{{ $account->other2 }}">
                                          </div>
                                      </div>
                                    </div>

                                    <div class="form-group col-lg-12 row">
                                      <div class="form-group col-lg-6 row m-0" id="inputother3">
                                          <label for="other3" class="col-sm-3 form-control-label">@lang('sistema.client.other3')</label>
                                          <div class="col-sm-9">
                                              <input type="text" class="form-control" id="other3" name="account[other3]" placeholder="{{__('sistema.client.other3')}}" value="{{ $account->other3 }}">
                                          </div>
                                      </div>

                                      <div class="form-group col-lg-6 row m-0" id="inputother4">
                                          <label for="other4" class="col-sm-3 form-control-label">@lang('sistema.client.other4')</label>
                                          <div class="col-sm-9">
                                              <input type="text" class="form-control" id="other4" name="account[other4]" placeholder="{{__('sistema.client.other4')}}" value="{{ $account->other4 }}">
                                          </div>
                                      </div>
                                    </div>

                                    <h4 class="m-b-30 m-t-30 header-title"><b>@lang('sistema.client.due_diligence')</b><hr></h4>
                                    <div class="form-group col-lg-12 row">
                                        <div class="form-group col-lg-6 row m-0" id="inputcopy_of_id">
                                          <div class="col-sm-9">
                                            <div class="checkbox checkbox-custom m-t-0">
                                                <label class="m-b-0">
                                                    <input type="checkbox" {{ ($account->copy_of_id == 1)? 'checked':'' }} value="1" name="account[copy_of_id]" id="copy_of_id">
                                                    <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                    @lang('sistema.client.copy_of_id')
                                                </label>
                                            </div>
                                          </div>
                                        </div>

                                        <div class="form-group col-lg-6 row m-0" id="inpututility_bill">
                                          <div class="col-sm-12">
                                            <div class="checkbox checkbox-custom m-t-0">
                                                      <label class="m-b-0">
                                                          <input type="checkbox" {{ ($account->utility_bill == 1)? 'checked':'' }} value="1" name="account[utility_bill]" id="utility_bill">
                                                          <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                          @lang('sistema.client.utility_bill')
                                                      </label>
                                                  </div>
                                          </div>
                                        </div>
                                      </div>

                                      <div class="form-group col-lg-12 row">
                                        <div class="form-group col-lg-6 row m-0" id="inputbank_statement">
                                          <div class="col-sm-12">
                                            <div class="checkbox checkbox-custom m-t-0">
                                                      <label class="m-b-0">
                                                          <input type="checkbox" {{ ($account->bank_statement == 1)? 'checked':'' }} value="1" name="account[bank_statement]" id="bank_statement">
                                                          <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                          @lang('sistema.client.bank_statement')
                                                      </label>
                                                  </div>
                                          </div>
                                        </div>

                                        <div class="form-group col-lg-6 row m-0" id="inputbank_transfer_voucher">
                                          <div class="col-sm-12">
                                            <div class="checkbox checkbox-custom m-t-0">
                                                      <label class="m-b-0">
                                                          <input type="checkbox" {{ ($account->bank_transfer_voucher == 1)? 'checked':'' }} value="1" name="account[bank_transfer_voucher]" id="bank_transfer_voucher">
                                                          <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                          @lang('sistema.client.bank_transfer_voucher')
                                                      </label>
                                                  </div>
                                          </div>
                                        </div>
                                      </div>

                                      <div class="form-group col-lg-12 row">
                                        <div class="form-group col-lg-6 row m-0" id="inputapplication">
                                          <div class="col-sm-12">
                                            <div class="checkbox checkbox-custom m-t-0">
                                                      <label class="m-b-0">
                                                          <input type="checkbox" {{ ($account->application == 1)? 'checked':'' }} value="1" name="account[application]" id="application">
                                                          <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                          @lang('sistema.client.application')
                                                      </label>
                                                  </div>
                                          </div>
                                        </div>

                                        <div class="form-group col-lg-6 row m-0" id="inputbiometric_signature">
                                          <div class="col-sm-12">
                                            <div class="checkbox checkbox-custom m-t-0">
                                                      <label class="m-b-0">
                                                          <input type="checkbox" {{ ($account->biometric_signature == 1)? 'checked':'' }} value="1" name="account[biometric_signature]" id="biometric_signature">
                                                          <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                          @lang('sistema.client.biometric_signature')
                                                      </label>
                                                  </div>
                                          </div>
                                        </div>
                                      </div>

                                      <div class="form-group col-lg-12 row">
                                        <div class="form-group col-lg-6 row m-0" id="inputcontract">
                                          <div class="col-sm-12">
                                            <div class="checkbox checkbox-custom m-t-0">
                                                      <label class="m-b-0">
                                                          <input type="checkbox" {{ ($account->contract == 1)? 'checked':'' }} value="1" name="account[contract]" id="contract">
                                                          <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                          @lang('sistema.client.contract')
                                                      </label>
                                                  </div>
                                          </div>
                                        </div>

                                        <div class="form-group col-lg-6 row m-0" id="inputcredit_line">
                                          <div class="col-sm-12">
                                            <div class="checkbox checkbox-custom m-t-0">
                                                      <label class="m-b-0">
                                                          <input type="checkbox" {{ ($account->credit_line == 1)? 'checked':'' }} value="1" name="account[credit_line]" id="credit_line">
                                                          <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                          @lang('sistema.client.credit_line')
                                                      </label>
                                                  </div>
                                          </div>
                                        </div>
                                      </div>

                                    <div class="form-group col-lg-12 row">
                                      <div class="form-group col-lg-6 row m-0" id="inputother_documents1">
                                          <label for="other_documents1" class="col-sm-3 form-control-label">@lang('sistema.client.other_documents1')</label>
                                          <div class="col-sm-9">
                                              <input type="text" class="form-control" id="other_documents1" name="account[other_documents1]" placeholder="{{__('sistema.client.other_documents1')}}" value="{{ $account->other_documents1 }}">
                                          </div>
                                      </div>

                                      <div class="form-group col-lg-6 row m-0" id="inputother_documents2">
                                          <label for="other_documents2" class="col-sm-3 form-control-label">@lang('sistema.client.other_documents2')</label>
                                          <div class="col-sm-9">
                                              <input type="text" class="form-control" id="other_documents2" name="account[other_documents2]" placeholder="{{__('sistema.client.other_documents2')}}" value="{{ $account->other_documents2 }}">
                                          </div>
                                      </div>
                                    </div>

                                    <div class="form-group col-lg-12 row">
                                      <div class="form-group col-lg-6 row m-0" id="inputother_documents3">
                                          <label for="other_documents3" class="col-sm-3 form-control-label">@lang('sistema.client.other_documents3')</label>
                                          <div class="col-sm-9">
                                              <input type="text" class="form-control" id="other_documents3" name="account[other_documents3]" placeholder="{{__('sistema.client.other_documents3')}}" value="{{ $account->other_documents3 }}">
                                          </div>
                                      </div>

                                      <div class="form-group col-lg-6 row m-0" id="inputother_compliance_requirement">
                                          <label for="other_compliance_requirement" class="col-sm-3 form-control-label">@lang('sistema.client.other_compliance_requirement')</label>
                                          <div class="col-sm-9">
                                              <input type="text" class="form-control" id="other_compliance_requirement" name="account[other_compliance_requirement]" placeholder="{{__('sistema.client.other_compliance_requirement')}}" value="{{ $account->other_compliance_requirement }}">
                                          </div>
                                      </div>
                                    </div>

                                    <div class="form-group col-lg-12 row">
                                      <div class="form-group col-lg-6 row m-0">
                                          <div class="offset-sm-3 col-sm-9">
                                              <a href="{{url('clients')}}" class="btn btn-danger waves-effect waves-light">@lang('sistema.btn_back')</a>
                                              <button type="submit" class="btn btn-info waves-effect waves-light">@lang('sistema.btn_save')</button>
                                          </div>
                                      </div>
                                    </div>
                                  </form>

                                  <!-- Refrence section copy-->
                                  <div class="reference_section_copy" style="display: none;">
                                    <h4 class="m-b-30 m-t-30 header-title"><b>@lang('sistema.client.reference1')</b><hr></h4>

                                    <div class="form-group col-lg-12 row">
                                      <div class="form-group col-lg-6 row m-0" id="inputreference1_name">
                                          <label for="reference1_name" class="col-sm-3 form-control-label">@lang('sistema.client.reference1_name')<span class="text-danger">*</span></label>
                                          <div class="col-sm-9">
                                              <input type="text" class="form-control" id="reference1_name" name="reference1_name" placeholder="{{__('sistema.client.reference1_name')}}" valida="SI" cadena ="{{__('sistema.client.reference1_name_valid')}}" value="{{ old('reference1_name') }}">
                                          </div>
                                      </div>

                                      <div class="form-group col-lg-6 row m-0" id="inputreference1_relationship">
                                          <label for="reference1_relationship" class="col-sm-3 form-control-label">@lang('sistema.client.reference1_relationship')<span class="text-danger">*</span></label>
                                          <div class="col-sm-9">
                                              <input type="text" class="form-control" id="reference1_relationship" name="reference1_relationship" placeholder="{{__('sistema.client.reference1_relationship')}}" valida="SI" cadena ="{{__('sistema.client.reference1_relationship_valid')}}" value="{{ old('reference1_relationship') }}">
                                          </div>
                                      </div>
                                    </div>

                                    <div class="form-group col-lg-12 row">
                                      <div class="form-group col-lg-6 row m-0" id="inputreference1_telephone">
                                          <label for="reference1_telephone" class="col-sm-3 form-control-label">@lang('sistema.client.reference1_telephone')<span class="text-danger">*</span></label>
                                          <div class="col-sm-9">
                                              <input type="text" class="form-control" id="reference1_telephone" name="reference1_telephone" placeholder="{{__('sistema.client.reference1_telephone')}}" valida="SI" cadena ="{{__('sistema.client.reference1_telephone_valid')}}" value="{{ old('reference1_telephone') }}">
                                          </div>
                                      </div>
                                    </div>

                                    <h4 class="m-b-30 m-t-30 header-title"><b>@lang('sistema.client.reference2')</b><hr></h4>

                                    <div class="form-group col-lg-12 row">
                                      <div class="form-group col-lg-6 row m-0" id="inputreference2_name">
                                          <label for="reference2_name" class="col-sm-3 form-control-label">@lang('sistema.client.reference2_name')</label>
                                          <div class="col-sm-9">
                                              <input type="text" class="form-control" id="reference2_name" name="reference2_name" placeholder="{{__('sistema.client.reference2_name')}}" value="{{ old('reference2_name') }}">
                                          </div>
                                      </div>

                                      <div class="form-group col-lg-6 row m-0" id="inputreference2_relationship">
                                          <label for="reference2_relationship" class="col-sm-3 form-control-label">@lang('sistema.client.reference2_relationship')</label>
                                          <div class="col-sm-9">
                                              <input type="text" class="form-control" id="reference2_relationship" name="reference2_relationship" placeholder="{{__('sistema.client.reference2_relationship')}}"  value="{{ old('reference2_relationship') }}">
                                          </div>
                                      </div>
                                    </div>

                                    <div class="form-group col-lg-12 row">
                                      <div class="form-group col-lg-6 row m-0" id="inputreference2_telephone">
                                          <label for="reference2_telephone" class="col-sm-3 form-control-label">@lang('sistema.client.reference2_telephone')</label>
                                          <div class="col-sm-9">
                                              <input type="text" class="form-control" id="reference2_telephone" name="reference2_telephone" placeholder="{{__('sistema.client.reference2_telephone')}}"  value="{{ old('reference2_telephone') }}">
                                          </div>
                                      </div>
                                    </div>

                                    <h4 class="m-b-30 m-t-30 header-title"><b>@lang('sistema.client.reference3')</b><hr></h4>
                                    <div class="form-group col-lg-12 row">
                                      <div class="form-group col-lg-6 row m-0" id="inputreference3_name">
                                          <label for="reference3_name" class="col-sm-3 form-control-label">@lang('sistema.client.reference3_name')</label>
                                          <div class="col-sm-9">
                                              <input type="text" class="form-control" id="reference3_name" name="reference3_name" placeholder="{{__('sistema.client.reference3_name')}}"  value="{{ old('reference3_name') }}">
                                          </div>
                                      </div>

                                      <div class="form-group col-lg-6 row m-0" id="inputreference3_relationship">
                                          <label for="reference3_relationship" class="col-sm-3 form-control-label">@lang('sistema.client.reference3_relationship')</label>
                                          <div class="col-sm-9">
                                              <input type="text" class="form-control" id="reference3_relationship" name="reference3_relationship" placeholder="{{__('sistema.client.reference3_relationship')}}"  value="{{ old('reference3_relationship') }}">
                                          </div>
                                      </div>
                                    </div>

                                    <div class="form-group col-lg-12 row">
                                      <div class="form-group col-lg-6 row m-0" id="inputreference3_telephone">
                                          <label for="reference3_telephone" class="col-sm-3 form-control-label">@lang('sistema.client.reference3_telephone')</label>
                                          <div class="col-sm-9">
                                              <input type="text" class="form-control" id="reference3_telephone" name="reference3_telephone" placeholder="{{__('sistema.client.reference3_telephone')}}" value="{{ old('reference3_telephone') }}">
                                          </div>
                                      </div>
                                    </div>
                                  </div>
                                  <!-- Refrence section copy-->
                                  <!-- Beneficiories section copy-->
                                  <div class="beneficiory_section_copy" style="display: none;">
                                  <div class="control-group">
                                    <div class="form-group col-lg-12 row m-b-0">
                                        <div class="form-group col-lg-6 m-0">
                                        </div>
                                        <div class="form-group col-lg-6 m-b-5">
                                            <button class="btn btn-danger remove pull-right m-r-5 btn-xs" type="button"><i class="glyphicon glyphicon-remove"></i> @lang('sistema.btn_remove')</button>
                                        </div>
                                    </div>
                                    <div class="form-group col-lg-12 row">
                                      <div class="form-group col-lg-6 row m-0" id="inputbeneficiary_name">
                                          <label for="beneficiary_name" class="col-sm-3 form-control-label">@lang('sistema.client.beneficiary_name')<span class="text-danger">*</span></label>
                                          <div class="col-sm-9">
                                              <input type="text" class="form-control" id="beneficiary_name" name="beneficiary_name[]" placeholder="{{__('sistema.client.beneficiary_name')}}" valida="SI" cadena ="{{__('sistema.client.beneficiary_name_valid')}}" value="{{ old('beneficiary_name') }}">
                                          </div>
                                      </div>

                                      <div class="form-group col-lg-6 row m-0" id="inputbeneficiary_percentage">
                                          <label for="beneficiary_percentage" class="col-sm-3 form-control-label">@lang('sistema.client.beneficiary_percentage')<span class="text-danger">*</span></label>
                                          <div class="col-sm-9">
                                              <input type="text" class="form-control beneficiary_percent" id="beneficiary_percentage" name="beneficiary_percentage[]" placeholder="{{__('sistema.client.beneficiary_percentage')}}" valida="SI" cadena ="{{__('sistema.client.beneficiary_percentage_valid')}}" value="0">
                                          </div>
                                      </div>
                                    </div>
                                    </div>
                                    </div>
                                  <!-- Beneficiories section copy-->
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
  <script src="{{ url('assets/plugins/bootstrap-filestyle/js/bootstrap-filestyle.min.js') }}"></script>
  <script src="{{ url('assets/plugins/select2/js/select2.min.js') }}"></script>
  <script src="{{ url('assets//plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
  <script src="{{ url('assets/plugins/intlTelInput/build/js/intlTelInput.js') }}"></script>
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

        $(document).ready(function() {
            $('#financial_service').select2();
            $('.client_country').select2();
            $('.birth_country').select2();
            $('#fund_country').select2();
            $(".state").select2();
            $(".city").select2();
            $('#sales').select2();
            $('#manager').select2();
            $('#customer_care').select2();
            $('#analyst').select2();
            $("#broker_id").trigger('change');
            $('.client_country').trigger('change');
            
        });
        $('.date_picker').datepicker({
            format: 'dd/mm/yyyy',
            autoclose: true
        });

        $('#date_of_transfer').datepicker({
            format: 'dd/mm/yyyy',
            autoclose: true
        });

        $(".inttel_input").intlTelInput({
            utilsScript: "{{ url('assets/plugins/intlTelInput/build/js/utils.js') }}",
            autoPlaceholder: true,
            preferredCountries: ['mx','us']
        });

        function validateFrm()
        {            
            var listv = 0;
            var msg = '';

            $('#frm_clients').find(':input').each(function() {
                if($(this).attr("valida")=="SI")
                {
                  if($(this).val()==""||$(this).val()=="null"){
                    $(this).closest(".form-group").addClass("has-error");
                      msg+=$(this).attr('cadena')+'\n';
                      listv=1;
                  }else{
                    $(this).closest(".form-group").removeClass("has-error");
                  }
                }
            });

            var beneficiary_percent = 0;

            if(listv == 0){
              $('#frm_clients').find('.beneficiary_percent').each(function() {
                  beneficiary_percent = beneficiary_percent + parseFloat($(this).val());
              });
              if(beneficiary_percent != 100){
                  listv =1;
                  msg += '@lang('sistema.client.beneficiary_percentage_err')'+'\n';
              }
              
            }

            var pattern = /^\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i;

            $('#frm_clients').find('.valid_email').each(function() {
              if($(this).val() != ''){
                if(!pattern.test($(this).val())){
                  $(this).closest(".form-group").addClass("has-error");
                  listv =1;
                  msg += '@lang('sistema.client.email_err')'+'\n';
                }else{
                  $(this).closest(".form-group").removeClass("has-error");
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
                var intlNumber;
                $('#frm_clients').find('.inttel_input').each(function() {
                  intlNumber = $(this).intlTelInput("getNumber");
                  $(this).intlTelInput("destroy");
                  $(this).val(intlNumber);
                });
                return true;
            }
        }

        $("#broker_id").change(function () {
            var broker_type = this.value;
            if(broker_type != ''){
                $.ajax({
                    url: "{{ url('/getbrokercolor')}}"+"/"+$(this).val(),
                    method:'GET',
                    dataType:'json',
                    success: function(response){

                        if($('#acc_number_temp').val() != ''){
                            $('#acc_number').val($('#acc_number_temp').val());
                            //$('#acc_number_temp').val('');

                        }else{
                            $('#acc_number').val(response['code']);
                        }
                        if(response['data'])
                        {
                            $(".card").css("background-color",response['data']);
                        }else{
                            $(".card").css("background-color", "#fff");
                        }
                    }
                });
            }else{
                $(".card").css("background-color", "#fff");
                $('#acc_number').val('XXXXXXXXXX');
            }
        });

        $("#credit_line_facility").change(function () {
            var credit_line_facility = this.value;
            if(credit_line_facility == 'Yes'){
                var html = $(".reference_section_copy").html();
                $(".before-add-reference").html(html);
            }else{
                $(".before-add-reference").html('');
            }
        });

        $("body").on("click",".remove",function(){ 
            $(this).parents(".control-group").remove();
        });

        $(".add-more-beneficiary").click(function(){
            var html = $(".beneficiory_section_copy").html();
            $(".before-add-more").before(html);
        });

        $('body').on('change',".client_country",function () {
      
            var client_state = $(this).closest(".client_personal_info").find(".state");
            var client_state_temp = $(this).closest(".client_personal_info").find(".state_temp");
            client_state.select2('val','');
            $.ajax({
                url: "{{ url('/getstatelist')}}"+"/"+$(this).val(),
                method:'GET',
                dataType:'json',
                success: function(response){

                  var state = '';
                    if(response['data'])
                    {
                    
                     state += '<option value="null"></option>';
                    for(var x in response['data']){
                        state += '<option value="'+x+'">'+response['data'][x]+'</option>';
                      }
                    }
                    client_state.html(state);
                    if(client_state_temp.val() != ''){
                        client_state.val(client_state_temp.val()).trigger('change');
                        client_state_temp.val('');
                    }
                }
            });
        });

        $('body').on('change',".state",function () {
            var client_city = $(this).closest(".client_personal_info").find(".city");
            var client_city_temp = $(this).closest(".client_personal_info").find(".city_temp");
            client_city.select2('val','');
            $.ajax({
                url: "{{ url('/getcitylist')}}"+"/"+$(this).val(),
                method:'GET',
                dataType:'json',
                success: function(response){
                    var city = '';
                    if(response['data'])
                    {
                      city += '<option value="null"></option>';
                      for(var x in response['data']){
                        city += '<option value="'+x+'">'+response['data'][x]+'</option>';
                      }
                    }
                    client_city.html(city);
                    if(client_city_temp.val() != ''){
                        client_city.val(client_city_temp.val()).trigger('change');
                        client_city_temp.val('');
                    }
                }
            });
        });

        $('#opening_amount').on('input',function(e){
            var amt = $('#opening_amount').val();
            if(amt != ''){
                if($.isNumeric($('#opening_amount').val())){
                    if($('#opening_amount').val() >= 999999)
                    {
                        $('#opening_amount').val(0);
                    }
                }else{
                    $('#opening_amount').val(0);
                }
            }
        });

        $("body").on("input",".beneficiary_percent",function(e){
            var percent = $(this).val();
            if(percent != ''){
                if($.isNumeric($(this).val())){
                    if($(this).val() > 100)
                    {
                        $(this).val(0);
                    }
                }else{
                    $(this).val(0);
                }
            }
        });
    </script>
@endsection