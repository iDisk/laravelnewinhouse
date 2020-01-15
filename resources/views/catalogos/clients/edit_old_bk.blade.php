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
                    <h4 class="page-title">@lang('sistema.client.edit_client')</h4>
                        <ol class="breadcrumb p-0 m-0">
                            <li>
                                <a href="{{ url('clients') }}">
                                    @lang('sistema.client.clients')
                                </a>
                            </li>
                            <li class="active">
                                @lang('sistema.client.edit_client')
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

                                  <form class="form-horizontal"  method="POST" action="{{url('clients/'.$client->id)}}" id="frm_clients" enctype="multipart/form-data" onsubmit="return validateFrm();">
                                      {{ csrf_field() }}
                                      {{ method_field('PUT') }}
                                      <h4 class="m-b-30 m-t-0 header-title"><b>@lang('sistema.client.account_information')</b><hr></h4>

                                      <div class="form-group col-lg-12 row">
                                      <div class="form-group col-lg-6 row m-0" id="inputbroker_id">
                                          <label for="broker_id" class="col-sm-3 form-control-label">@lang('sistema.client.broker')<span class="text-danger">*</span></label>
                                          <div class="col-sm-9">
                                              <select id="broker_id" class="form-control" name="broker_id" valida="SI" cadena="{{__('sistema.client.broker_valid')}}">
                                                  <option value="">@lang('sistema.btn_select')</option>
                                                  @foreach($brokers as $key=>$value)
                                                      <option value="{{ $key }}" {{ ($key == $client->broker_id)? 'selected':'' }}>{{ $value }}</option>
                                                  @endforeach
                                              </select>
                                          </div>
                                      </div>

                                      <div class="form-group col-lg-6 row m-0" id="inputtype_of_acc">
                                          <label for="type_of_acc" class="col-sm-3 form-control-label">@lang('sistema.client.type_of_acc')<span class="text-danger">*</span></label>
                                          <div class="col-sm-9">
                                              <select id="type_of_acc" class="form-control" name="type_of_acc" valida="SI" cadena="{{__('sistema.client.type_of_acc_valid')}}">
                                                  <option value="">@lang('sistema.btn_select')</option>
                                                  <option value="individual" {{ ($client->type_of_acc == 'individual')? 'selected':'' }}>Individual</option>
                                              </select>
                                          </div>
                                      </div>
                                    </div>

                                    <div class="form-group col-lg-12 row">
                                      <div class="form-group col-lg-6 row m-0" id="inputacc_number">
                                          <label for="acc_number" class="col-sm-3 form-control-label">@lang('sistema.client.acc_number')<span class="text-danger">*</span></label>
                                          <div class="col-sm-9">
                                              <input type="text" class="form-control" id="acc_number" name="acc_number" placeholder="{{__('sistema.client.acc_number')}}" valida="SI" cadena ="{{__('sistema.client.acc_number_valid')}}" value="{{ $client->acc_number }}" disabled>
                                              <input type="hidden" id="acc_number_temp" name="acc_number_temp" value="{{ $client->acc_number }}">
                                          </div>
                                      </div>

                                      <div class="form-group col-lg-6 row m-0" id="inputfinancial_service">
                                          <label for="financial_service" class="col-sm-3 form-control-label">@lang('sistema.client.financial_service')<span class="text-danger">*</span></label>
                                          <div class="col-sm-9">
                                              <select class="form-control" placeholder="{{__('sistema.client.financial_service')}}"  valida="SI" cadena ="{{__('sistema.client.financial_service_valid')}}" name="financial_service[]" id="financial_service" multiple="multiple">
                                                  @foreach($financial_services as $key=>$value)
                                                      <option value="{{ $key }}" {{ (in_array($key,$client_financial_services))?'selected':'' }}>{{ $value}}</option>
                                                  @endforeach
                                              </select>
                                          </div>
                                      </div>
                                    </div>

                                    <h4 class="m-b-30 m-t-30 header-title"><b>@lang('sistema.client.account_holder_information')</b><hr></h4>

                                    <div class="form-group col-lg-12 row">
                                      <div class="form-group col-lg-6 row m-0" id="inputfirst_name">
                                          <label for="first_name" class="col-sm-3 form-control-label">@lang('sistema.client.first_name')<span class="text-danger">*</span></label>
                                          <div class="col-sm-9">
                                              <input type="text" class="form-control" id="first_name" name="first_name" placeholder="{{__('sistema.client.first_name')}}" valida="SI" cadena ="{{__('sistema.client.first_name_valid')}}" value="{{ $client->first_name }}">
                                          </div>
                                      </div>

                                      <div class="form-group col-lg-6 row m-0" id="inputmiddle_name">
                                          <label for="middle_name" class="col-sm-3 form-control-label">@lang('sistema.client.middle_name')<span class="text-danger">*</span></label>
                                          <div class="col-sm-9">
                                              <input type="text" class="form-control" id="middle_name" name="middle_name" placeholder="{{__('sistema.client.middle_name')}}" valida="SI" cadena ="{{__('sistema.client.middle_name_valid')}}" value="{{ $client->middle_name }}">
                                          </div>
                                      </div>
                                    </div>

                                    <div class="form-group col-lg-12 row">
                                      <div class="form-group col-lg-6 row m-0" id="inputsurname1">
                                          <label for="surname1" class="col-sm-3 form-control-label">@lang('sistema.client.surname1')<span class="text-danger">*</span></label>
                                          <div class="col-sm-9">
                                              <input type="text" class="form-control" id="surname1" name="surname1" placeholder="{{__('sistema.client.surname1')}}" valida="SI" cadena ="{{__('sistema.client.surname1_valid')}}" value="{{ $client->surname1 }}">
                                          </div>
                                      </div>

                                      <div class="form-group col-lg-6 row m-0" id="inputsurname2">
                                          <label for="surname2" class="col-sm-3 form-control-label">@lang('sistema.client.surname2')<span class="text-danger">*</span></label>
                                          <div class="col-sm-9">
                                              <input type="text" class="form-control" id="surname2" name="surname2" placeholder="{{__('sistema.client.surname2')}}" valida="SI" cadena ="{{__('sistema.client.surname2_valid')}}" value="{{ $client->surname2 }}">
                                          </div>
                                      </div>
                                    </div>

                                    <div class="form-group col-lg-12 row">
                                      <div class="form-group col-lg-6 row m-0" id="inputnational_identity_doc_id">
                                          <label for="national_identity_doc_id" class="col-sm-3 form-control-label">@lang('sistema.client.national_identity_doc')<span class="text-danger">*</span></label>
                                          <div class="col-sm-9">
                                              <select id="national_identity_doc_id" class="form-control" name="national_identity_doc_id" valida="SI" cadena="{{__('sistema.client.national_identity_doc_valid')}}">
                                                  <option value="">@lang('sistema.btn_select')</option>
                                                  @foreach($national_identity_docs as $key=>$value)
                                                      <option value="{{ $key }}" {{ ($key == $client->national_identity_doc_id)? 'selected':'' }}>{{ $value }}</option>
                                                  @endforeach
                                              </select>
                                          </div>
                                      </div>

                                      <div class="form-group col-lg-6 row m-0" id="inputnational_identity_number">
                                          <label for="national_identity_number" class="col-sm-3 form-control-label">@lang('sistema.client.national_identity_number')<span class="text-danger">*</span></label>
                                          <div class="col-sm-9">
                                              <input type="text" class="form-control" id="national_identity_number" name="national_identity_number" placeholder="{{__('sistema.client.national_identity_number')}}" valida="SI" cadena ="{{__('sistema.client.national_identity_number_valid')}}" value="{{ $client->national_identity_number }}">
                                          </div>
                                      </div>
                                    </div>

                                    <div class="form-group col-lg-12 row">
                                      <div class="form-group col-lg-6 row m-0" id="inputnational_identity_file">
                                          <label for="national_identity_file" class="col-sm-3 form-control-label">@lang('sistema.client.national_identity_file')</label>
                                          <div class="col-sm-9">
                                              <input type="file" class="form-control filestyle" id="national_identity_file" name="national_identity_file"  data-buttonname="btn-info" data-buttontext="{{__('sistema.btn_choose_file')}}" placeholder="{{__('sistema.client.national_identity_file')}}">
                                          </div>
                                      </div>
                                    </div>

                                    <div class="form-group col-lg-12 row">
                                      <div class="form-group col-lg-6 row m-0" id="inputdob">
                                          <label for="dob" class="col-sm-3 form-control-label">@lang('sistema.client.dob')<span class="text-danger">*</span></label>
                                          <div class="col-sm-9">
                                              <input type="text" class="form-control" id="dob" name="dob" placeholder="{{__('sistema.client.dob')}}" valida="SI" cadena ="{{__('sistema.client.dob_valid')}}" value="{{ \Carbon\Carbon::parse($client->dob)->format('d/m/Y') }}">
                                          </div>
                                      </div>

                                      <div class="form-group col-lg-6 row m-0" id="inputgender">
                                          <label for="gender" class="col-sm-3 form-control-label">@lang('sistema.client.gender')<span class="text-danger">*</span></label>
                                          <div class="col-sm-9">
                                              <select id="gender" class="form-control" name="gender" valida="SI" cadena="{{__('sistema.client.gender_valid')}}">
                                                  <option value="">@lang('sistema.btn_select')</option>
                                                  <option value="Male" {{ ($client->gender == 'Male')? 'selected':'' }}>@lang('sistema.client.male')</option>
                                                  <option value="Female" {{ ($client->gender == 'Female')? 'selected':'' }}>@lang('sistema.client.female')</option>
                                              </select>
                                          </div>
                                      </div>
                                    </div>

                                    <div class="form-group col-lg-12 row">
                                      <div class="form-group col-lg-6 row m-0" id="inputbirth_place">
                                          <label for="birth_place" class="col-sm-3 form-control-label">@lang('sistema.client.birth_place')<span class="text-danger">*</span></label>
                                          <div class="col-sm-9">
                                              <input type="text" class="form-control" id="birth_place" name="birth_place" placeholder="{{__('sistema.client.birth_place')}}" valida="SI" cadena ="{{__('sistema.client.birth_place_valid')}}" value="{{ $client->birth_place }}">
                                          </div>
                                      </div>

                                      <div class="form-group col-lg-6 row m-0" id="inputbirth_country">
                                          <label for="birth_country" class="col-sm-3 form-control-label">@lang('sistema.client.birth_country')<span class="text-danger">*</span></label>
                                          <div class="col-sm-9">
                                              <select id="birth_country" class="form-control" name="birth_country" valida="SI" cadena="{{__('sistema.client.birth_country_valid')}}">
                                                  <option value="">@lang('sistema.btn_select')</option>
                                                  @foreach($countries as $country)
                                                      <option value="{{ $country->id }}" {{ ($client->birth_country == $country->id)?'selected':''}}>{{ $country->name }}</option>
                                                  @endforeach
                                              </select>
                                          </div>
                                      </div>
                                    </div>

                                    <div class="form-group col-lg-12 row">
                                      <div class="form-group col-lg-6 row m-0" id="inputnationality">
                                          <label for="nationality" class="col-sm-3 form-control-label">@lang('sistema.client.nationality')<span class="text-danger">*</span></label>
                                          <div class="col-sm-9">
                                              <input type="text" class="form-control" id="nationality" name="nationality" placeholder="{{__('sistema.client.nationality')}}" valida="SI" cadena ="{{__('sistema.client.nationality_valid')}}" value="{{ $client->nationality }}">
                                          </div>
                                      </div>

                                      <div class="form-group col-lg-6 row m-0" id="inputaddress">
                                          <label for="address" class="col-sm-3 form-control-label">@lang('sistema.client.address')<span class="text-danger">*</span></label>
                                          <div class="col-sm-9">
                                              <input type="text" class="form-control" id="address" name="address" placeholder="{{__('sistema.client.address')}}" valida="SI" cadena ="{{__('sistema.client.address_valid')}}" value="{{ $client->address }}">
                                          </div>
                                      </div>
                                    </div>

                                    <div class="form-group col-lg-12 row">
                                      <div class="form-group col-lg-6 row m-0" id="inputcountry">
                                          <label for="country" class="col-sm-3 form-control-label">@lang('sistema.client.country')<span class="text-danger">*</span></label>
                                          <div class="col-sm-9">
                                              <select id="country" class="form-control" name="country" valida="SI" cadena="{{__('sistema.client.country_valid')}}">
                                                  <option value="">@lang('sistema.btn_select')</option>
                                                  @foreach($countries as $country)
                                                      <option value="{{ $country->id }}" {{ ($client->country == $country->id)?'selected':''}}>{{ $country->name }}</option>
                                                  @endforeach
                                              </select>
                                          </div>
                                      </div>

                                      <div class="form-group col-lg-6 row m-0" id="inputstate">
                                          <label for="state" class="col-sm-3 form-control-label">@lang('sistema.client.state')<span class="text-danger">*</span></label>
                                          <div class="col-sm-9">
                                              <select id="state" class="form-control" name="state" valida="SI" cadena="{{__('sistema.client.state_valid')}}">
                                                  <option value="">@lang('sistema.btn_select')</option>
                                              </select>
                                              <input type="hidden" id="state_temp" name="state_temp" value="{{ $client->state }}">
                                          </div>
                                      </div>

                                    </div>

                                    <div class="form-group col-lg-12 row">
                                      <div class="form-group col-lg-6 row m-0" id="inputcity">
                                          <label for="city" class="col-sm-3 form-control-label">@lang('sistema.client.city')<span class="text-danger">*</span></label>
                                          <div class="col-sm-9">
                                              <select id="city" class="form-control" name="city" valida="SI" cadena="{{__('sistema.client.city_valid')}}">
                                                  <option value="">@lang('sistema.btn_select')</option>
                                              </select>
                                              <input type="hidden" id="city_temp" name="city_temp" value="{{ $client->city }}">
                                          </div>
                                      </div>

                                      <div class="form-group col-lg-6 row m-0" id="inputzip_code">
                                          <label for="zip_code" class="col-sm-3 form-control-label">@lang('sistema.client.zip_code')<span class="text-danger">*</span></label>
                                          <div class="col-sm-9">
                                              <input type="text" class="form-control" id="zip_code" name="zip_code" placeholder="{{__('sistema.client.zip_code')}}" valida="SI" cadena ="{{__('sistema.client.zip_code_valid')}}" value="{{ $client->zip_code }}">
                                          </div>
                                      </div>
                                    </div>

                                    <div class="form-group col-lg-12 row">
                                        <div class="form-group col-lg-6 row m-0" id="inputcounty">
                                          <label for="county" class="col-sm-3 form-control-label">@lang('sistema.client.county')<span class="text-danger">*</span></label>
                                          <div class="col-sm-9">
                                              <input type="text" class="form-control" id="county" name="county" placeholder="{{__('sistema.client.county')}}" valida="SI" cadena ="{{__('sistema.client.county_valid')}}" value="{{ $client->county }}">
                                          </div>
                                      </div>
                                    </div>

                                    <div class="form-group col-lg-12 row">
                                      <div class="form-group col-lg-6 row m-0" id="inputcompany">
                                          <label for="company" class="col-sm-3 form-control-label">@lang('sistema.client.company')</label>
                                          <div class="col-sm-9">
                                              <input type="text" class="form-control" id="company" name="company" placeholder="{{__('sistema.client.company')}}" value="{{ $client->company }}">
                                          </div>
                                      </div>
                                      <div class="form-group col-lg-6 row m-0" id="inputindustry_type">
                                          <label for="industry_type" class="col-sm-3 form-control-label">@lang('sistema.client.industry_type')</label>
                                          <div class="col-sm-9">
                                              <input type="text" class="form-control" id="industry_type" name="industry_type" placeholder="{{__('sistema.client.industry_type')}}" value="{{ $client->industry_type }}">
                                          </div>
                                      </div>
                                    </div>

                                    <div class="form-group col-lg-12 row">
                                      <div class="form-group col-lg-6 row m-0" id="inputoccupation">
                                          <label for="occupation" class="col-sm-3 form-control-label">@lang('sistema.client.occupation')</label>
                                          <div class="col-sm-9">
                                              <input type="text" class="form-control" id="occupation" name="occupation" placeholder="{{__('sistema.client.occupation')}}" value="{{ $client->occupation }}">
                                          </div>
                                      </div>

                                      <div class="form-group col-lg-6 row m-0" id="inputmarrital_status">
                                          <label for="marrital_status" class="col-sm-3 form-control-label">@lang('sistema.client.marrital_status')</label>
                                          <div class="col-sm-9">
                                              <input type="text" class="form-control" id="marrital_status" name="marrital_status" placeholder="{{__('sistema.client.marrital_status')}}" value="{{ $client->marrital_status }}">
                                          </div>
                                      </div>
                                    </div>

                                    <div class="form-group col-lg-12 row">
                                      <div class="form-group col-lg-6 row m-0" id="inputspouse_name">
                                          <label for="spouse_name" class="col-sm-3 form-control-label">@lang('sistema.client.spouse_name')</label>
                                          <div class="col-sm-9">
                                              <input type="text" class="form-control" id="spouse_name" name="spouse_name" placeholder="{{__('sistema.client.spouse_name')}}"  value="{{ $client->spouse_name }}">
                                          </div>
                                      </div>
                                    </div>

                                    <div class="form-group col-lg-12 row">
                                      <div class="form-group col-lg-6 row m-0" id="inputtelephone1">
                                          <label for="telephone1" class="col-sm-3 form-control-label">@lang('sistema.client.telephone1')<span class="text-danger">*</span></label>
                                          <div class="col-sm-9">
                                              <input type="text" class="form-control" id="telephone1" name="telephone1" placeholder="{{__('sistema.client.telephone1')}}" valida="SI" cadena ="{{__('sistema.client.telephone1_valid')}}" value="{{ $client->telephone1 }}">
                                          </div>
                                      </div>

                                      <div class="form-group col-lg-6 row m-0" id="inputtelephone2">
                                          <label for="telephone2" class="col-sm-3 form-control-label">@lang('sistema.client.telephone2')</label>
                                          <div class="col-sm-9">
                                              <input type="text" class="form-control" id="telephone2" name="telephone2" placeholder="{{__('sistema.client.telephone2')}}" value="{{ $client->telephone2 }}">
                                          </div>
                                      </div>
                                    </div>

                                    <div class="form-group col-lg-12 row">
                                      <div class="form-group col-lg-6 row m-0" id="inputtelephone3">
                                          <label for="telephone3" class="col-sm-3 form-control-label">@lang('sistema.client.telephone3')</label>
                                          <div class="col-sm-9">
                                              <input type="text" class="form-control" id="telephone3" name="telephone3" placeholder="{{__('sistema.client.telephone3')}}" value="{{ $client->telephone3 }}">
                                          </div>
                                      </div>
                                    </div>

                                    <div class="form-group col-lg-12 row">
                                      <div class="form-group col-lg-6 row m-0" id="inputemail1">
                                          <label for="email1" class="col-sm-3 form-control-label">@lang('sistema.client.email1')<span class="text-danger">*</span></label>
                                          <div class="col-sm-9">
                                              <input type="text" class="form-control" id="email1" name="email1" placeholder="{{__('sistema.client.email1')}}" valida="SI" cadena ="{{__('sistema.client.email1_valid')}}" value="{{ $client->email1 }}">
                                          </div>
                                      </div>

                                      <div class="form-group col-lg-6 row m-0" id="inputemail2">
                                          <label for="email2" class="col-sm-3 form-control-label">@lang('sistema.client.email2')</label>
                                          <div class="col-sm-9">
                                              <input type="text" class="form-control" id="email2" name="email2" placeholder="{{__('sistema.client.email2')}}" value="{{ $client->email2 }}">
                                          </div>
                                      </div>
                                    </div>

                                    <h4 class="m-b-30 m-t-30 header-title">
                                        <b>@lang('sistema.client.beneficiaries')</b>
                                        <button class="btn btn-success add-more-beneficiary btn-xs m-l-15" type="button"><i class="fa fa-plus"></i> @lang('sistema.btn_add')</button>
                                        <hr>
                                    </h4>
                                    @if(count($client_beneficiary) <= 0 )
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
                                    @foreach($client_beneficiary as $value)
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
                                              <select id="credit_capability" class="form-control" name="credit_capability" valida="SI" cadena="{{__('sistema.client.credit_capability_valid')}}">
                                                  <option value="">@lang('sistema.btn_select')</option>
                                                  @for($i=0; $i<=20; $i++)
                                                    <option value="{{ $i }}" {{($i == $client->credit_capability)? 'selected':''}}>{{ $i }}</option>
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
                                              <input type="text" class="form-control" id="opening_amount" name="opening_amount" placeholder="{{__('sistema.client.opening_amount')}}" valida="SI" cadena ="{{__('sistema.client.opening_amount_valid')}}" value="{{ $client->opening_amount }}">
                                          </div>
                                      </div>

                                      <div class="form-group col-lg-6 row m-0" id="inputdate_of_transfer">
                                          <label for="date_of_transfer" class="col-sm-3 form-control-label">@lang('sistema.client.date_of_transfer')<span class="text-danger">*</span></label>
                                          <div class="col-sm-9">
                                              <input type="text" class="form-control" id="date_of_transfer" name="date_of_transfer" placeholder="{{__('sistema.client.date_of_transfer')}}" valida="SI" cadena ="{{__('sistema.client.date_of_transfer_valid')}}" value="{{ \Carbon\Carbon::parse($client->date_of_transfer)->format('d/m/Y') }}">
                                          </div>
                                      </div>
                                    </div>

                                    <div class="form-group col-lg-12 row">
                                      <div class="form-group col-lg-6 row m-0" id="inputsender_bank">
                                          <label for="sender_bank" class="col-sm-3 form-control-label">@lang('sistema.client.sender_bank')<span class="text-danger">*</span></label>
                                          <div class="col-sm-9">
                                              <input type="text" class="form-control" id="sender_bank" name="sender_bank" placeholder="{{__('sistema.client.sender_bank')}}" valida="SI" cadena ="{{__('sistema.client.sender_bank_valid')}}" value="{{ $client->sender_bank }}">
                                          </div>
                                      </div>

                                      <div class="form-group col-lg-6 row m-0" id="inputfund_country">
                                          <label for="fund_country" class="col-sm-3 form-control-label">@lang('sistema.client.fund_country')<span class="text-danger">*</span></label>
                                          <div class="col-sm-9">
                                              <select id="fund_country" class="form-control" name="fund_country" valida="SI" cadena="{{__('sistema.client.fund_country_valid')}}">
                                                  <option value="">@lang('sistema.btn_select')</option>
                                                  @foreach($countries as $country)
                                                      <option value="{{ $country->id }}" {{ ($client->fund_country == $country->id)?'selected':'' }}>{{ $country->name }}</option>
                                                  @endforeach
                                              </select>
                                          </div>
                                      </div>
                                    </div>

                                    <div class="form-group col-lg-12 row">
                                      <div class="form-group col-lg-6 row m-0" id="inputclearing_house">
                                          <label for="clearing_house" class="col-sm-3 form-control-label">@lang('sistema.client.clearing_house')<span class="text-danger">*</span></label>
                                          <div class="col-sm-9">
                                              <input type="text" class="form-control" id="clearing_house" name="clearing_house" placeholder="{{__('sistema.client.clearing_house')}}" valida="SI" cadena ="{{__('sistema.client.clearing_house_valid')}}" value="{{ $client->clearing_house }}">
                                          </div>
                                      </div>

                                      <div class="form-group col-lg-6 row m-0" id="inputcustodian_bank">
                                          <label for="custodian_bank" class="col-sm-3 form-control-label">@lang('sistema.client.custodian_bank')<span class="text-danger">*</span></label>
                                          <div class="col-sm-9">
                                              <input type="text" class="form-control" id="custodian_bank" name="custodian_bank" placeholder="{{__('sistema.client.custodian_bank')}}" valida="SI" cadena ="{{__('sistema.client.custodian_bank_valid')}}" value="{{ $client->custodian_bank }}">
                                          </div>
                                      </div>
                                    </div>

                                    <div class="form-group col-lg-12 row">
                                       <div class="form-group col-lg-6 row m-0" id="inputcredit_line_facility">
                                          <label for="credit_line_facility" class="col-sm-3 form-control-label">@lang('sistema.client.credit_line_facility')<span class="text-danger">*</span></label>
                                          <div class="col-sm-9">
                                              <select id="credit_line_facility" class="form-control" name="credit_line_facility" valida="SI" cadena="{{__('sistema.client.credit_line_facility_valid')}}">
                                                  <option value="">@lang('sistema.btn_select')</option>
                                                    <option value="Yes" {{ ($client->credit_line_facility == 'Yes')?'selected':'' }}>@lang('sistema.client.yes')</option>
                                                    <option value="No" {{ ($client->credit_line_facility == 'No')?'selected':'' }}>@lang('sistema.client.no')</option>
                                              </select>
                                          </div>
                                      </div>
                                    </div>
                                    <div class="before-add-reference">
                                    
                                    @if($client->credit_line_facility == 'Yes')
                                    <h4 class="m-b-30 m-t-30 header-title"><b>@lang('sistema.client.reference1')</b><hr></h4>

                                    <div class="form-group col-lg-12 row">
                                      <div class="form-group col-lg-6 row m-0" id="inputreference1_name">
                                          <label for="reference1_name" class="col-sm-3 form-control-label">@lang('sistema.client.reference1_name')<span class="text-danger">*</span></label>
                                          <div class="col-sm-9">
                                              <input type="text" class="form-control" id="reference1_name" name="reference1_name" placeholder="{{__('sistema.client.reference1_name')}}" valida="SI" cadena ="{{__('sistema.client.reference1_name_valid')}}" value="{{ ( isset($client_references[0]->name))? $client_references[0]->name:'' }}">
                                          </div>
                                      </div>

                                      <div class="form-group col-lg-6 row m-0" id="inputreference1_relationship">
                                          <label for="reference1_relationship" class="col-sm-3 form-control-label">@lang('sistema.client.reference1_relationship')<span class="text-danger">*</span></label>
                                          <div class="col-sm-9">
                                              <input type="text" class="form-control" id="reference1_relationship" name="reference1_relationship" placeholder="{{__('sistema.client.reference1_relationship')}}" valida="SI" cadena ="{{__('sistema.client.reference1_relationship_valid')}}" value="{{ ( isset($client_references[0]->relationship))? $client_references[0]->relationship:old('reference1_relationship') }}">
                                          </div>
                                      </div>
                                    </div>

                                    <div class="form-group col-lg-12 row">
                                      <div class="form-group col-lg-6 row m-0" id="inputreference1_telephone">
                                          <label for="reference1_telephone" class="col-sm-3 form-control-label">@lang('sistema.client.reference1_telephone')<span class="text-danger">*</span></label>
                                          <div class="col-sm-9">
                                              <input type="text" class="form-control" id="reference1_telephone" name="reference1_telephone" placeholder="{{__('sistema.client.reference1_telephone')}}" valida="SI" cadena ="{{__('sistema.client.reference1_telephone_valid')}}" value="{{ ( isset($client_references[0]->telephone))? $client_references[0]->telephone:old('reference1_telephone') }}">
                                          </div>
                                      </div>
                                    </div>

                                    <h4 class="m-b-30 m-t-30 header-title"><b>@lang('sistema.client.reference2')</b><hr></h4>

                                    <div class="form-group col-lg-12 row">
                                      <div class="form-group col-lg-6 row m-0" id="inputreference2_name">
                                          <label for="reference2_name" class="col-sm-3 form-control-label">@lang('sistema.client.reference2_name')</label>
                                          <div class="col-sm-9">
                                              <input type="text" class="form-control" id="reference2_name" name="reference2_name" placeholder="{{__('sistema.client.reference2_name')}}" value="{{ (isset($client_references[1]->name) )? $client_references[1]->name:old('reference2_name') }}">
                                          </div>
                                      </div>

                                      <div class="form-group col-lg-6 row m-0" id="inputreference2_relationship">
                                          <label for="reference2_relationship" class="col-sm-3 form-control-label">@lang('sistema.client.reference2_relationship')</label>
                                          <div class="col-sm-9">
                                              <input type="text" class="form-control" id="reference2_relationship" name="reference2_relationship" placeholder="{{__('sistema.client.reference2_relationship')}}"  value="{{ ( isset($client_references[1]->relationship))? $client_references[1]->relationship:old('reference2_relationship') }}">
                                          </div>
                                      </div>
                                    </div>

                                    <div class="form-group col-lg-12 row">
                                      <div class="form-group col-lg-6 row m-0" id="inputreference2_telephone">
                                          <label for="reference2_telephone" class="col-sm-3 form-control-label">@lang('sistema.client.reference2_telephone')</label>
                                          <div class="col-sm-9">
                                              <input type="text" class="form-control" id="reference2_telephone" name="reference2_telephone" placeholder="{{__('sistema.client.reference2_telephone')}}"  value="{{ ( isset($client_references[1]->telephone))? $client_references[1]->telephone:old('reference2_telephone') }}">
                                          </div>
                                      </div>
                                    </div>

                                    <h4 class="m-b-30 m-t-30 header-title"><b>@lang('sistema.client.reference3')</b><hr></h4>
                                    <div class="form-group col-lg-12 row">
                                      <div class="form-group col-lg-6 row m-0" id="inputreference3_name">
                                          <label for="reference3_name" class="col-sm-3 form-control-label">@lang('sistema.client.reference3_name')</label>
                                          <div class="col-sm-9">
                                              <input type="text" class="form-control" id="reference3_name" name="reference3_name" placeholder="{{__('sistema.client.reference3_name')}}"  value="{{ ( isset($client_references[2]->name))? $client_references[2]->name:old('reference3_name') }}">
                                          </div>
                                      </div>

                                      <div class="form-group col-lg-6 row m-0" id="inputreference3_relationship">
                                          <label for="reference3_relationship" class="col-sm-3 form-control-label">@lang('sistema.client.reference3_relationship')</label>
                                          <div class="col-sm-9">
                                              <input type="text" class="form-control" id="reference3_relationship" name="reference3_relationship" placeholder="{{__('sistema.client.reference3_relationship')}}"  value="{{ ( isset($client_references[2]->relationship) )? $client_references[2]->relationship:old('reference3_relationship') }}">
                                          </div>
                                      </div>
                                    </div>

                                    <div class="form-group col-lg-12 row">
                                      <div class="form-group col-lg-6 row m-0" id="inputreference3_telephone">
                                          <label for="reference3_telephone" class="col-sm-3 form-control-label">@lang('sistema.client.reference3_telephone')</label>
                                          <div class="col-sm-9">
                                              <input type="text" class="form-control" id="reference3_telephone" name="reference3_telephone" placeholder="{{__('sistema.client.reference3_telephone')}}" value="{{ ( isset($client_references[2]->telephone) )? $client_references[2]->telephone:old('reference3_telephone') }}">
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
                                              <select id="sales" class="form-control" name="sales" valida="SI" cadena="{{__('sistema.client.sales_valid')}}">
                                                  <option value="">@lang('sistema.btn_select')</option>
                                                  @foreach($ventas as $venta)
                                                      <option value="{{ $venta->id }}" {{ ($client->sales == $venta->id)?'selected':'' }}>{{ $venta->name }}</option>
                                                  @endforeach
                                              </select>
                                          </div>
                                      </div>

                                      <div class="form-group col-lg-6 row m-0" id="inputmanager">
                                          <label for="manager" class="col-sm-3 form-control-label">@lang('sistema.client.manager')<span class="text-danger">*</span></label>
                                          <div class="col-sm-9">
                                              <select id="manager" class="form-control" name="manager" valida="SI" cadena="{{__('sistema.client.manager_valid')}}">
                                                  <option value="">@lang('sistema.btn_select')</option>
                                                  @foreach($gerente as $gerent)
                                                      <option value="{{ $gerent->id }}" {{ ($client->manager == $gerent->id)?'selected':'' }}>{{ $gerent->name }}</option>
                                                  @endforeach
                                              </select>
                                          </div>
                                      </div>
                                    </div>

                                    <div class="form-group col-lg-12 row">
                                      <div class="form-group col-lg-6 row m-0" id="inputcustomer_care">
                                          <label for="customer_care" class="col-sm-3 form-control-label">@lang('sistema.client.customer_care')<span class="text-danger">*</span></label>
                                          <div class="col-sm-9">
                                              <select id="customer_care" class="form-control" name="customer_care" valida="SI" cadena="{{__('sistema.client.customer_care_valid')}}">
                                                  <option value="">@lang('sistema.btn_select')</option>
                                                  @foreach($atencion_a_cliente as $atencion_a_client)
                                                      <option value="{{ $atencion_a_client->id }}" {{ ($client->customer_care == $atencion_a_client->id)?'selected':'' }}>{{ $atencion_a_client->name }}</option>
                                                  @endforeach
                                              </select>
                                          </div>
                                      </div>

                                      <div class="form-group col-lg-6 row m-0" id="inputanalyst">
                                          <label for="analyst" class="col-sm-3 form-control-label">@lang('sistema.client.analyst')<span class="text-danger">*</span></label>
                                          <div class="col-sm-9">
                                              <select id="analyst" class="form-control" name="analyst" valida="SI" cadena="{{__('sistema.client.analyst_valid')}}">
                                                  <option value="">@lang('sistema.btn_select')</option>
                                                  @foreach($analista as $analist)
                                                      <option value="{{ $analist->id }}" {{ ($client->analyst == $analist->id)?'selected':'' }}>{{ $analist->name }}</option>
                                                  @endforeach
                                              </select>
                                          </div>
                                      </div>
                                    </div>

                                    <div class="form-group col-lg-12 row">
                                      <div class="form-group col-lg-6 row m-0" id="inputother1">
                                          <label for="other1" class="col-sm-3 form-control-label">@lang('sistema.client.other1')</label>
                                          <div class="col-sm-9">
                                              <input type="text" class="form-control" id="other1" name="other1" placeholder="{{__('sistema.client.other1')}}" value="{{ $client->other1 }}">
                                          </div>
                                      </div>

                                      <div class="form-group col-lg-6 row m-0" id="inputother2">
                                          <label for="other2" class="col-sm-3 form-control-label">@lang('sistema.client.other2')</label>
                                          <div class="col-sm-9">
                                              <input type="text" class="form-control" id="other2" name="other2" placeholder="{{__('sistema.client.other2')}}" value="{{ $client->other2 }}">
                                          </div>
                                      </div>
                                    </div>

                                    <div class="form-group col-lg-12 row">
                                      <div class="form-group col-lg-6 row m-0" id="inputother3">
                                          <label for="other3" class="col-sm-3 form-control-label">@lang('sistema.client.other3')</label>
                                          <div class="col-sm-9">
                                              <input type="text" class="form-control" id="other3" name="other3" placeholder="{{__('sistema.client.other3')}}" value="{{ $client->other3 }}">
                                          </div>
                                      </div>

                                      <div class="form-group col-lg-6 row m-0" id="inputother4">
                                          <label for="other4" class="col-sm-3 form-control-label">@lang('sistema.client.other4')</label>
                                          <div class="col-sm-9">
                                              <input type="text" class="form-control" id="other4" name="other4" placeholder="{{__('sistema.client.other4')}}" value="{{ $client->other4 }}">
                                          </div>
                                      </div>
                                    </div>

                                    <h4 class="m-b-30 m-t-30 header-title"><b>@lang('sistema.client.due_diligence')</b><hr></h4>
                                    <div class="form-group col-lg-12 row">
                                      <div class="form-group col-lg-6 row m-0" id="inputcopy_of_id">
                                          <label for="copy_of_id" class="col-sm-3 form-control-label">@lang('sistema.client.copy_of_id')</label>
                                          <div class="col-sm-9">
                                              <input type="file" class="form-control filestyle" id="copy_of_id" name="copy_of_id[]" multiple  data-buttonname="btn-info" data-buttontext="{{__('sistema.btn_choose_file')}}" placeholder="{{__('sistema.client.copy_of_id')}}" value="">
                                          </div>
                                      </div>

                                      <div class="form-group col-lg-6 row m-0" id="inpututility_bill">
                                          <label for="utility_bill" class="col-sm-3 form-control-label">@lang('sistema.client.utility_bill')</label>
                                          <div class="col-sm-9">
                                              <input type="file" class="form-control filestyle" id="utility_bill" name="utility_bill[]" multiple data-buttonname="btn-info" data-buttontext="{{__('sistema.btn_choose_file')}}" placeholder="{{__('sistema.client.utility_bill')}}" value="">
                                          </div>
                                      </div>
                                    </div>

                                    <div class="form-group col-lg-12 row">
                                      <div class="form-group col-lg-6 row m-0" id="inputbank_statement">
                                          <label for="bank_statement" class="col-sm-3 form-control-label">@lang('sistema.client.bank_statement')</label>
                                          <div class="col-sm-9">
                                              <input type="file" class="form-control filestyle" id="bank_statement" name="bank_statement[]" multiple  data-buttonname="btn-info" data-buttontext="{{__('sistema.btn_choose_file')}}" placeholder="{{__('sistema.client.bank_statement')}}" value="">
                                          </div>
                                      </div>

                                      <div class="form-group col-lg-6 row m-0" id="inputbank_transfer_voucher">
                                          <label for="bank_transfer_voucher" class="col-sm-3 form-control-label">@lang('sistema.client.bank_transfer_voucher')</label>
                                          <div class="col-sm-9">
                                              <input type="file" class="form-control filestyle" id="bank_transfer_voucher" multiple name="bank_transfer_voucher[]"  data-buttonname="btn-info" data-buttontext="{{__('sistema.btn_choose_file')}}" placeholder="{{__('sistema.client.bank_transfer_voucher')}}" value="">

                                          </div>
                                      </div>
                                    </div>

                                    <div class="form-group col-lg-12 row">
                                      <div class="form-group col-lg-6 row m-0" id="inputapplication">
                                          <label for="application" class="col-sm-3 form-control-label">@lang('sistema.client.application')</label>
                                          <div class="col-sm-9">
                                              <input type="file" class="form-control filestyle" id="application" name="application[]" multiple data-buttonname="btn-info" data-buttontext="{{__('sistema.btn_choose_file')}}" placeholder="{{__('sistema.client.application')}}" value="">
                                          </div>
                                      </div>

                                      <div class="form-group col-lg-6 row m-0" id="inputbiometric_signature">
                                          <label for="biometric_signature" class="col-sm-3 form-control-label">@lang('sistema.client.biometric_signature')</label>
                                          <div class="col-sm-9">
                                              <input type="file" class="form-control filestyle" id="biometric_signature" multiple name="biometric_signature[]"  data-buttonname="btn-info" data-buttontext="{{__('sistema.btn_choose_file')}}" placeholder="{{__('sistema.client.biometric_signature')}}" value="">
                                          </div>
                                      </div>
                                    </div>

                                    <div class="form-group col-lg-12 row">
                                      <div class="form-group col-lg-6 row m-0" id="inputcontract">
                                          <label for="contract" class="col-sm-3 form-control-label">@lang('sistema.client.contract')</label>
                                          <div class="col-sm-9">
                                              <input type="file" class="form-control filestyle" id="contract" name="contract[]" multiple  data-buttonname="btn-info" data-buttontext="{{__('sistema.btn_choose_file')}}" placeholder="{{__('sistema.client.contract')}}" value="">
                                          </div>
                                      </div>

                                      <div class="form-group col-lg-6 row m-0" id="inputcredit_line">
                                          <label for="credit_line" class="col-sm-3 form-control-label">@lang('sistema.client.credit_line')</label>
                                          <div class="col-sm-9">
                                              <input type="file" class="form-control filestyle" id="credit_line" name="credit_line[]" multiple data-buttonname="btn-info" data-buttontext="{{__('sistema.btn_choose_file')}}" placeholder="{{__('sistema.client.credit_line')}}" value="">
                                          </div>
                                      </div>
                                    </div>

                                    <div class="form-group col-lg-12 row">
                                      <div class="form-group col-lg-6 row m-0" id="inputother_documents1">
                                          <label for="other_documents1" class="col-sm-3 form-control-label">@lang('sistema.client.other_documents1')</label>
                                          <div class="col-sm-9">
                                              <input type="text" class="form-control" id="other_documents1" name="other_documents1" placeholder="{{__('sistema.client.other_documents1')}}" value="{{ $client->other_documents1 }}">
                                          </div>
                                      </div>

                                      <div class="form-group col-lg-6 row m-0" id="inputother_documents2">
                                          <label for="other_documents2" class="col-sm-3 form-control-label">@lang('sistema.client.other_documents2')</label>
                                          <div class="col-sm-9">
                                              <input type="text" class="form-control" id="other_documents2" name="other_documents2" placeholder="{{__('sistema.client.other_documents2')}}" value="{{ $client->other_documents2 }}">
                                          </div>
                                      </div>
                                    </div>

                                    <div class="form-group col-lg-12 row">
                                      <div class="form-group col-lg-6 row m-0" id="inputother_documents3">
                                          <label for="other_documents3" class="col-sm-3 form-control-label">@lang('sistema.client.other_documents3')</label>
                                          <div class="col-sm-9">
                                              <input type="text" class="form-control" id="other_documents3" name="other_documents3" placeholder="{{__('sistema.client.other_documents3')}}" value="{{ $client->other_documents3 }}">
                                          </div>
                                      </div>

                                      <div class="form-group col-lg-6 row m-0" id="inputother_compliance_requirement">
                                          <label for="other_compliance_requirement" class="col-sm-3 form-control-label">@lang('sistema.client.other_compliance_requirement')</label>
                                          <div class="col-sm-9">
                                              <input type="text" class="form-control" id="other_compliance_requirement" name="other_compliance_requirement" placeholder="{{__('sistema.client.other_compliance_requirement')}}" value="{{ $client->other_compliance_requirement }}">
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
            $('#country').select2();
            $('#birth_country').select2();
            $('#fund_country').select2();
            $("#state").select2();
            $("#city").select2();
            $('#sales').select2();
            $('#manager').select2();
            $('#customer_care').select2();
            $('#analyst').select2();

            $('#country').trigger('change');
            $("#broker_id").trigger('change');
            
        });
        $('#dob').datepicker({
            format: 'dd/mm/yyyy',
            autoclose: true
        });

        $('#date_of_transfer').datepicker({
            format: 'dd/mm/yyyy',
            autoclose: true
        });

        $("#telephone1").intlTelInput({
            utilsScript: "{{ url('assets/plugins/intlTelInput/build/js/utils.js') }}",
            autoPlaceholder: true,
            preferredCountries: ['mx','us']
        });

        function validateFrm()
        {            
            var listv = 0;
            var msg = '';

            $('#frm_clients').find(':input').each(function() {
                if($(this).attr("valida")=="SI" && ($(this).val()==""||$(this).val()=="null"))
                {
                    listv=1;
                    
                    $('#input'+this.id).addClass('has-error');
                    msg+=$(this).attr('cadena')+'\n';
                    
                    //$(this).val($(this).val().toUpperCase());
                }else
                {
                      $('#input'+this.id).removeClass('has-error');
                      if($(this).attr("valida")=="SI")
                      {
                          //$(this).val($(this).val().toUpperCase());
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
                var intlNumber = $("#telephone1").intlTelInput("getNumber");
                $("#telephone1").intlTelInput("destroy");
                $("#telephone1").val(intlNumber);
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
                            $('#acc_number_temp').val('');

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

        $("#country").change(function () {
             $("#state").select2('val','');
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
                        $('#state').html(state);
                        if($('#state_temp').val() != ''){
                            $('#state').val($('#state_temp').val()).trigger('change');
                            $('#state_temp').val('');
                        }
                    }
                });
        });

        $("#state").change(function () {
             $("#city").select2('val','');
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
                        $('#city').html(city);

                        if($('#city_temp').val() != ''){
                            $('#city').val($('#city_temp').val()).trigger('change');
                            $('#city_temp').val('');
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