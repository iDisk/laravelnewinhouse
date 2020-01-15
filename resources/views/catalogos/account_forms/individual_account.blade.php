<div class="client_personal_info">
    <h4 class="m-b-30 m-t-30 header-title"><b>@lang('sistema.client.account_holder_information')</b><hr></h4>
    <div class="form-group col-lg-12 row">
        <div class="form-group col-lg-6 row m-0">
            <label class="col-sm-3 form-control-label">@lang('sistema.client.first_name')<span class="text-danger">*</span></label>
            <div class="col-sm-9">
                <input type="text" class="form-control" name="client[first_name][]" placeholder="{{__('sistema.client.first_name')}}" valida="SI" cadena ="{{__('sistema.client.first_name_valid')}}" value="{{ old('first_name') }}">
            </div>
        </div>
        <div class="form-group col-lg-6 row m-0">
            <label class="col-sm-3 form-control-label">@lang('sistema.client.middle_name')<span class="text-danger">*</span></label>
            <div class="col-sm-9">
                <input type="text" class="form-control" name="client[middle_name][]" placeholder="{{__('sistema.client.middle_name')}}" valida="SI" cadena ="{{__('sistema.client.middle_name_valid')}}" value="{{ old('middle_name') }}">
            </div>
        </div>
    </div>
    <div class="form-group col-lg-12 row">
        <div class="form-group col-lg-6 row m-0">
            <label class="col-sm-3 form-control-label">@lang('sistema.client.surname1')<span class="text-danger">*</span></label>
            <div class="col-sm-9">
                <input type="text" class="form-control" name="client[surname1][]" placeholder="{{__('sistema.client.surname1')}}" valida="SI" cadena ="{{__('sistema.client.surname1_valid')}}" value="{{ old('surname1') }}">
            </div>
        </div>
        <div class="form-group col-lg-6 row m-0">
            <label class="col-sm-3 form-control-label">@lang('sistema.client.surname2')<span class="text-danger">*</span></label>
            <div class="col-sm-9">
                <input type="text" class="form-control" name="client[surname2][]" placeholder="{{__('sistema.client.surname2')}}" valida="SI" cadena ="{{__('sistema.client.surname2_valid')}}" value="{{ old('surname2') }}">
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
                    <option value="{{ $key }}">{{ $value }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group col-lg-6 row m-0">
            <label class="col-sm-3 form-control-label">@lang('sistema.client.national_identity_number')<span class="text-danger">*</span></label>
            <div class="col-sm-9">
                <input type="text" class="form-control" name="client[national_identity_number][]" placeholder="{{__('sistema.client.national_identity_number')}}" valida="SI" cadena ="{{__('sistema.client.national_identity_number_valid')}}" value="{{ old('national_identity_number') }}">
            </div>
        </div>
    </div>
    <div class="form-group col-lg-12 row">
        <div class="form-group col-lg-6 row m-0">
            <label class="col-sm-3 form-control-label">@lang('sistema.client.national_identity_file')<span class="text-danger">*</span></label>
            <div class="col-sm-9">
                <input type="file" class="form-control filestyle" name="national_identity_file[]"  data-buttonname="btn-info" data-buttontext="{{__('sistema.btn_choose_file')}}" placeholder="{{__('sistema.client.national_identity_file')}}" value="" valida="SI" cadena ="{{__('sistema.client.national_identity_file_valid')}}">
            </div>
        </div>
    </div>
    <div class="form-group col-lg-12 row">
        <div class="form-group col-lg-6 row m-0">
            <label class="col-sm-3 form-control-label">@lang('sistema.client.dob')<span class="text-danger">*</span></label>
            <div class="col-sm-9">
                <input type="text" class="form-control date_picker" name="client[dob][]" placeholder="{{__('sistema.client.dob')}}" valida="SI" cadena ="{{__('sistema.client.dob_valid')}}" value="{{ old('dob') }}">
            </div>
        </div>
        <div class="form-group col-lg-6 row m-0">
            <label class="col-sm-3 form-control-label">@lang('sistema.client.gender')<span class="text-danger">*</span></label>
            <div class="col-sm-9">
                <select class="form-control" name="client[gender][]" valida="SI" cadena="{{__('sistema.client.gender_valid')}}">
                    <option value="">@lang('sistema.btn_select')</option>
                    <option value="Male">@lang('sistema.client.male')</option>
                    <option value="Female">@lang('sistema.client.female')</option>
                </select>
            </div>
        </div>
    </div>
    <div class="form-group col-lg-12 row">
        <div class="form-group col-lg-6 row m-0">
            <label class="col-sm-3 form-control-label">@lang('sistema.client.birth_place')<span class="text-danger">*</span></label>
            <div class="col-sm-9">
                <input type="text" class="form-control" name="client[birth_place][]" placeholder="{{__('sistema.client.birth_place')}}" valida="SI" cadena ="{{__('sistema.client.birth_place_valid')}}" value="{{ old('birth_place') }}">
            </div>
        </div>
        <div class="form-group col-lg-6 row m-0">
            <label class="col-sm-3 form-control-label">@lang('sistema.client.birth_country')<span class="text-danger">*</span></label>
            <div class="col-sm-9">
                <select class="form-control birth_country" name="client[birth_country][]" valida="SI" cadena="{{__('sistema.client.birth_country_valid')}}">
                    <option value="">@lang('sistema.btn_select')</option>
                    @foreach($countries as $country)
                    <option value="{{ $country->id }}">{{ $country->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <div class="form-group col-lg-12 row">
        <div class="form-group col-lg-6 row m-0">
            <label class="col-sm-3 form-control-label">@lang('sistema.client.nationality')<span class="text-danger">*</span></label>
            <div class="col-sm-9">
                <input type="text" class="form-control" name="client[nationality][]" placeholder="{{__('sistema.client.nationality')}}" valida="SI" cadena ="{{__('sistema.client.nationality_valid')}}" value="{{ old('nationality') }}">
            </div>
        </div>
        <div class="form-group col-lg-6 row m-0">
            <label class="col-sm-3 form-control-label">@lang('sistema.client.address')<span class="text-danger">*</span></label>
            <div class="col-sm-9">
                <input type="text" class="form-control" name="client[address][]" placeholder="{{__('sistema.client.address')}}" valida="SI" cadena ="{{__('sistema.client.address_valid')}}" value="{{ old('address') }}">
            </div>
        </div>
    </div>
    <div class="form-group col-lg-12 row">
        <div class="form-group col-lg-6 row m-0">
            <label class="col-sm-3 form-control-label">@lang('sistema.client.country')<span class="text-danger">*</span></label>
            <div class="col-sm-9">
                <select class="form-control client_country" name="client[country][]" valida="SI" cadena="{{__('sistema.client.country_valid')}}">
                    <option value="">@lang('sistema.btn_select')</option>
                    @foreach($countries as $country)
                    <option value="{{ $country->id }}">{{ $country->name }}</option>
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
            </div>
        </div>
        <div class="form-group col-lg-6 row m-0">
            <label class="col-sm-3 form-control-label">@lang('sistema.client.zip_code')<span class="text-danger">*</span></label>
            <div class="col-sm-9">
                <input type="text" class="form-control" name="client[zip_code][]" placeholder="{{__('sistema.client.zip_code')}}" valida="SI" cadena ="{{__('sistema.client.zip_code_valid')}}" value="{{ old('zip_code') }}">
            </div>
        </div>
    </div>
    <div class="form-group col-lg-12 row">
        <div class="form-group col-lg-6 row m-0">
            <label class="col-sm-3 form-control-label">@lang('sistema.client.county')<span class="text-danger">*</span></label>
            <div class="col-sm-9">
                <input type="text" class="form-control" name="client[county][]" placeholder="{{__('sistema.client.county')}}" valida="SI" cadena ="{{__('sistema.client.county_valid')}}" value="{{ old('county') }}">
            </div>
        </div>
        <div class="form-group col-lg-6 row m-0" id="inputbranch_id">
            <label for="branch_id" class="col-sm-3 form-control-label">@lang('sistema.branches.branches')<span class="text-danger">*</span></label>
            <div class="col-sm-9">
                <select class="form-control" id="branch_id" name="client[branch_id][]" valida="SI" cadena ="{{__('sistema.branches.req_branch')}}">
                    <option value="">@lang('sistema.branches.select_branch')</option>
                    @if(isset($branches) && count($branches)>0)
                    @foreach($branches as $branch_id => $branch_name)
                    <option value="{{ $branch_id }}" {{ old('branch_id') == $branch_id ? 'selected' : '' }}>{{ $branch_name }}</option>
                    @endforeach
                    @endif
                </select>
            </div>
        </div>    
    </div>
    <div class="form-group col-lg-12 row">
        <div class="form-group col-lg-6 row m-0">
            <label class="col-sm-3 form-control-label">@lang('sistema.client.company')</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" name="client[company][]" placeholder="{{__('sistema.client.company')}}" value="{{ old('company') }}">
            </div>
        </div>
        <div class="form-group col-lg-6 row m-0">
            <label class="col-sm-3 form-control-label">@lang('sistema.client.industry_type')</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" name="client[industry_type][]" placeholder="{{__('sistema.client.industry_type')}}" value="{{ old('industry_type') }}">
            </div>
        </div>
    </div>
    <div class="form-group col-lg-12 row">
        <div class="form-group col-lg-6 row m-0">
            <label class="col-sm-3 form-control-label">@lang('sistema.client.occupation')</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" name="client[occupation][]" placeholder="{{__('sistema.client.occupation')}}" value="{{ old('occupation') }}">
            </div>
        </div>
        <div class="form-group col-lg-6 row m-0">
            <label class="col-sm-3 form-control-label">@lang('sistema.client.marrital_status')</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" name="client[marrital_status][]" placeholder="{{__('sistema.client.marrital_status')}}" value="{{ old('marrital_status') }}">
            </div>
        </div>
    </div>
    <div class="form-group col-lg-12 row">
        <div class="form-group col-lg-6 row m-0">
            <label class="col-sm-3 form-control-label">@lang('sistema.client.spouse_name')</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" name="client[spouse_name][]" placeholder="{{__('sistema.client.spouse_name')}}"  value="{{ old('spouse_name') }}">
            </div>
        </div>
    </div>
    <div class="form-group col-lg-12 row">
        <div class="form-group col-lg-6 row m-0">
            <label class="col-sm-3 form-control-label">@lang('sistema.client.telephone1')<span class="text-danger">*</span></label>
            <div class="col-sm-9">
                <input type="text" class="form-control inttel_input" name="client[telephone1][]" placeholder="{{__('sistema.client.telephone1')}}" valida="SI" cadena ="{{__('sistema.client.telephone1_valid')}}" value="{{ old('telephone1') }}">
            </div>
        </div>
        <div class="form-group col-lg-6 row m-0">
            <label class="col-sm-3 form-control-label">@lang('sistema.client.telephone2')</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" name="client[telephone2][]" placeholder="{{__('sistema.client.telephone2')}}" value="{{ old('telephone2') }}">
            </div>
        </div>
    </div>
    <div class="form-group col-lg-12 row">
        <div class="form-group col-lg-6 row m-0">
            <label class="col-sm-3 form-control-label">@lang('sistema.client.telephone3')</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" name="client[telephone3][]" placeholder="{{__('sistema.client.telephone3')}}" value="{{ old('telephone3') }}">
            </div>
        </div>
    </div>
    <div class="form-group col-lg-12 row">
        <div class="form-group col-lg-6 row m-0">
            <label class="col-sm-3 form-control-label">@lang('sistema.client.email1')<span class="text-danger">*</span></label>
            <div class="col-sm-9">
                <input type="text" class="form-control valid_email" name="client[email1][]" placeholder="{{__('sistema.client.email1')}}" valida="SI" cadena ="{{__('sistema.client.email1_valid')}}" value="{{ old('email1') }}">
            </div>
        </div>
        <div class="form-group col-lg-6 row m-0">
            <label class="col-sm-3 form-control-label">@lang('sistema.client.email2')</label>
            <div class="col-sm-9">
                <input type="text" class="form-control valid_email" name="client[email2][]" placeholder="{{__('sistema.client.email2')}}" value="{{ old('email2') }}">
            </div>
        </div>
    </div>
</div>
<h4 class="m-b-30 m-t-30 header-title">
    <b>@lang('sistema.client.beneficiaries')</b>
    <button class="btn btn-success add-more-beneficiary btn-xs m-l-15" type="button"><i class="fa fa-plus"></i> @lang('sistema.btn_add')</button>
    <hr>
</h4>
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
<div class="before-add-more"></div>
<h4 class="m-b-30 m-t-30 header-title"><b>@lang('sistema.client.credit_capability')</b><hr></h4>
<div class="form-group col-lg-12 row">
    <div class="form-group col-lg-6 row m-0" id="inputcredit_capability">
        <label for="credit_capability" class="col-sm-3 form-control-label">@lang('sistema.client.credit_capability')<span class="text-danger">*</span></label>
        <div class="col-sm-9">
            <select id="credit_capability" class="form-control" name="account[credit_capability]" valida="SI" cadena="{{__('sistema.client.credit_capability_valid')}}">
                <option value="">@lang('sistema.btn_select')</option>
                @for($i=0; $i<=20; $i++)
                <option value="{{ $i }}" {{($i == 3)? 'selected' :''}}>{{ $i }}</option>
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
            <input type="text" class="form-control" id="opening_amount" name="account[opening_amount]" placeholder="{{__('sistema.client.opening_amount')}}" valida="SI" cadena ="{{__('sistema.client.opening_amount_valid')}}" value="{{ old('opening_amount') }}">
        </div>
    </div>
    <div class="form-group col-lg-6 row m-0" id="inputdate_of_transfer">
        <label for="date_of_transfer" class="col-sm-3 form-control-label">@lang('sistema.client.date_of_transfer')<span class="text-danger">*</span></label>
        <div class="col-sm-9">
            <input type="text" class="form-control date_picker" id="date_of_transfer" name="account[date_of_transfer]" placeholder="{{__('sistema.client.date_of_transfer')}}" valida="SI" cadena ="{{__('sistema.client.date_of_transfer_valid')}}" value="{{ old('date_of_transfer') }}">
        </div>
    </div>
</div>
<div class="form-group col-lg-12 row">
    <div class="form-group col-lg-6 row m-0" id="inputsender_bank">
        <label for="sender_bank" class="col-sm-3 form-control-label">@lang('sistema.client.sender_bank')<span class="text-danger">*</span></label>
        <div class="col-sm-9">
            <input type="text" class="form-control" id="sender_bank" name="account[sender_bank]" placeholder="{{__('sistema.client.sender_bank')}}" valida="SI" cadena ="{{__('sistema.client.sender_bank_valid')}}" value="{{ old('sender_bank') }}">
        </div>
    </div>
    <div class="form-group col-lg-6 row m-0" id="inputfund_country">
        <label for="fund_country" class="col-sm-3 form-control-label">@lang('sistema.client.fund_country')<span class="text-danger">*</span></label>
        <div class="col-sm-9">
            <select id="fund_country" class="form-control" name="account[fund_country]" valida="SI" cadena="{{__('sistema.client.fund_country_valid')}}">
                <option value="">@lang('sistema.btn_select')</option>
                @foreach($countries as $country)
                <option value="{{ $country->id }}">{{ $country->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>
<div class="form-group col-lg-12 row">
    <div class="form-group col-lg-6 row m-0" id="inputclearing_house">
        <label for="clearing_house" class="col-sm-3 form-control-label">@lang('sistema.client.clearing_house')<span class="text-danger">*</span></label>
        <div class="col-sm-9">
            <input type="text" class="form-control" id="clearing_house" name="account[clearing_house]" placeholder="{{__('sistema.client.clearing_house')}}" valida="SI" cadena ="{{__('sistema.client.clearing_house_valid')}}" value="{{ old('clearing_house') }}">
        </div>
    </div>
    <div class="form-group col-lg-6 row m-0" id="inputcustodian_bank">
        <label for="custodian_bank" class="col-sm-3 form-control-label">@lang('sistema.client.custodian_bank')<span class="text-danger">*</span></label>
        <div class="col-sm-9">
            <input type="text" class="form-control" id="custodian_bank" name="account[custodian_bank]" placeholder="{{__('sistema.client.custodian_bank')}}" valida="SI" cadena ="{{__('sistema.client.custodian_bank_valid')}}" value="{{ old('custodian_bank') }}">
        </div>
    </div>
</div>
<div class="form-group col-lg-12 row">
    <div class="form-group col-lg-6 row m-0" id="inputcredit_line_facility">
        <label for="credit_line_facility" class="col-sm-3 form-control-label">@lang('sistema.client.credit_line_facility')<span class="text-danger">*</span></label>
        <div class="col-sm-9">
            <select id="credit_line_facility" class="form-control" name="account[credit_line_facility]" valida="SI" cadena="{{__('sistema.client.credit_line_facility_valid')}}">
                <option value="">@lang('sistema.btn_select')</option>
                <option value="Yes">@lang('sistema.client.yes')</option>
                <option value="No">@lang('sistema.client.no')</option>
            </select>
        </div>
    </div>
</div>
<!-- Daily Limit Start -->
<h4 class="m-b-30 m-t-30 header-title"><b>@lang('sistema.client.daily_limit')</b><hr></h4>
<div class="form-group col-lg-12 row">
    <div class="form-group col-lg-6 row m-0" id="inputtransfer_internal_account">
        <label for="transfer_internal_account" class="col-sm-3 form-control-label">@lang('sistema.client.transfer_internal_account')<span class="text-danger">*</span></label>
        <div class="col-sm-9">
            <input class="form-control autonumber" id="transfer_internal_account" name="account[transfer_internal_account]" valida="SI" cadena="{{__('sistema.client.transfer_internal_account')}}" value="0"/>
        </div>
    </div>
    <div class="form-group col-lg-6 row m-0" id="inputtransfer_third_party_account">
        <label for="transfer_third_party_account" class="col-sm-3 form-control-label">@lang('sistema.client.transfer_third_party_account')<span class="text-danger">*</span></label>
        <div class="col-sm-9">
            <input class="form-control autonumber" id="transfer_third_party_account" name="account[transfer_third_party_account]" valida="SI" cadena="{{__('sistema.client.transfer_third_party_account')}}" value="0"/>
        </div>
    </div>
</div>
<div class="form-group col-lg-12 row">
    <div class="form-group col-lg-6 row m-0" id="inputtransfer_international_account">
        <label for="transfer_international_account" class="col-sm-3 form-control-label">@lang('sistema.client.transfer_international_account')<span class="text-danger">*</span></label>
        <div class="col-sm-9">
            <input class="form-control autonumber" id="transfer_international_account" name="account[transfer_international_account]" valida="SI" cadena="{{__('sistema.client.transfer_international_account')}}" value="0"/>
        </div>
    </div>
</div>
<!-- Daily Limit End -->
<div class="before-add-reference"></div>
<h4 class="m-b-30 m-t-30 header-title"><b>@lang('sistema.client.administrative_details')</b><hr></h4>
<div class="form-group col-lg-12 row">
    <div class="form-group col-lg-6 row m-0" id="inputsales">
        <label for="sales" class="col-sm-3 form-control-label">@lang('sistema.client.sales')<span class="text-danger">*</span></label>
        <div class="col-sm-9">
            <select id="sales" class="form-control" name="account[sales]" valida="SI" cadena="{{__('sistema.client.sales_valid')}}">
                <option value="">@lang('sistema.btn_select')</option>
                @foreach($ventas as $venta)
                <option value="{{ $venta->id }}">{{ $venta->name }}</option>
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
                <option value="{{ $gerent->id }}">{{ $gerent->name }}</option>
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
                <option value="{{ $atencion_a_client->id }}">{{ $atencion_a_client->name }}</option>
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
                <option value="{{ $analist->id }}">{{ $analist->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>
<div class="form-group col-lg-12 row">
    <div class="form-group col-lg-6 row m-0" id="inputother1">
        <label for="other1" class="col-sm-3 form-control-label">@lang('sistema.client.other1')</label>
        <div class="col-sm-9">
            <input type="text" class="form-control" id="other1" name="account[other1]" placeholder="{{__('sistema.client.other1')}}" value="{{ old('other1') }}">
        </div>
    </div>
    <div class="form-group col-lg-6 row m-0" id="inputother2">
        <label for="other2" class="col-sm-3 form-control-label">@lang('sistema.client.other2')</label>
        <div class="col-sm-9">
            <input type="text" class="form-control" id="other2" name="account[other2]" placeholder="{{__('sistema.client.other2')}}" value="{{ old('other2') }}">
        </div>
    </div>
</div>
<div class="form-group col-lg-12 row">
    <div class="form-group col-lg-6 row m-0" id="inputother3">
        <label for="other3" class="col-sm-3 form-control-label">@lang('sistema.client.other3')</label>
        <div class="col-sm-9">
            <input type="text" class="form-control" id="other3" name="account[other3]" placeholder="{{__('sistema.client.other3')}}" value="{{ old('other3') }}">
        </div>
    </div>
    <div class="form-group col-lg-6 row m-0" id="inputother4">
        <label for="other4" class="col-sm-3 form-control-label">@lang('sistema.client.other4')</label>
        <div class="col-sm-9">
            <input type="text" class="form-control" id="other4" name="account[other4]" placeholder="{{__('sistema.client.other4')}}" value="{{ old('other4') }}">
        </div>
    </div>
</div>
<h4 class="m-b-30 m-t-30 header-title"><b>@lang('sistema.client.due_diligence')</b><hr></h4>
<div class="form-group col-lg-12 row">
    <div class="form-group col-lg-6 row m-0" id="inputcopy_of_id">
        <div class="col-sm-9">
            <div class="checkbox checkbox-custom m-t-0">
                <label class="m-b-0 ckCursor" for="copy_of_id">
                    <input type="checkbox" value="1" name="account[copy_of_id]" id="copy_of_id">
                    <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                    @lang('sistema.client.copy_of_id')
                </label>
            </div>
        </div>
    </div>
    <div class="form-group col-lg-6 row m-0" id="inpututility_bill">
        <div class="col-sm-12">
            <div class="checkbox checkbox-custom m-t-0">
                <label class="m-b-0 ckCursor" for="utility_bill">
                    <input type="checkbox" value="1" name="account[utility_bill]" id="utility_bill">
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
                <label class="m-b-0 ckCursor" for="bank_statement">
                    <input type="checkbox" value="1" name="account[bank_statement]" id="bank_statement">
                    <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                    @lang('sistema.client.bank_statement')
                </label>
            </div>
        </div>
    </div>
    <div class="form-group col-lg-6 row m-0" id="inputbank_transfer_voucher">
        <div class="col-sm-12">
            <div class="checkbox checkbox-custom m-t-0">
                <label class="m-b-0 ckCursor" for="bank_transfer_voucher">
                    <input type="checkbox" value="1" name="account[bank_transfer_voucher]" id="bank_transfer_voucher">
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
                <label class="m-b-0 ckCursor" for="application">
                    <input type="checkbox" value="1" name="account[application]" id="application">
                    <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                    @lang('sistema.client.application')
                </label>
            </div>
        </div>
    </div>
    <div class="form-group col-lg-6 row m-0" id="inputbiometric_signature">
        <div class="col-sm-12">
            <div class="checkbox checkbox-custom m-t-0">
                <label class="m-b-0 ckCursor" for="biometric_signature">
                    <input type="checkbox" value="1" name="account[biometric_signature]" id="biometric_signature">
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
                <label class="m-b-0 ckCursor" for="contract">
                    <input type="checkbox" value="1" name="account[contract]" id="contract">
                    <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                    @lang('sistema.client.contract')
                </label>
            </div>
        </div>
    </div>
    <div class="form-group col-lg-6 row m-0" id="inputcredit_line">
        <div class="col-sm-12">
            <div class="checkbox checkbox-custom m-t-0">
                <label class="m-b-0 ckCursor" for="credit_line">
                    <input type="checkbox" value="1" name="account[credit_line]" id="credit_line">
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
            <input type="text" class="form-control" id="other_documents1" name="account[other_documents1]" placeholder="{{__('sistema.client.other_documents1')}}" value="{{ old('other_documents1') }}">
        </div>
    </div>
    <div class="form-group col-lg-6 row m-0" id="inputother_documents2">
        <label for="other_documents2" class="col-sm-3 form-control-label">@lang('sistema.client.other_documents2')</label>
        <div class="col-sm-9">
            <input type="text" class="form-control" id="other_documents2" name="account[other_documents2]" placeholder="{{__('sistema.client.other_documents2')}}" value="{{ old('other_documents2') }}">
        </div>
    </div>
</div>
<div class="form-group col-lg-12 row">
    <div class="form-group col-lg-6 row m-0" id="inputother_documents3">
        <label for="other_documents3" class="col-sm-3 form-control-label">@lang('sistema.client.other_documents3')</label>
        <div class="col-sm-9">
            <input type="text" class="form-control" id="other_documents3" name="account[other_documents3]" placeholder="{{__('sistema.client.other_documents3')}}" value="{{ old('other_documents3') }}">
        </div>
    </div>
    <div class="form-group col-lg-6 row m-0" id="inputother_compliance_requirement">
        <label for="other_compliance_requirement" class="col-sm-3 form-control-label">@lang('sistema.client.other_compliance_requirement')</label>
        <div class="col-sm-9">
            <input type="text" class="form-control" id="other_compliance_requirement" name="account[other_compliance_requirement]" placeholder="{{__('sistema.client.other_compliance_requirement')}}" value="{{ old('other_compliance_requirement') }}">
        </div>
    </div>
</div>
<div style="display: none;">
    <h4 class="m-b-30 m-t-30 header-title"><b>@lang('sistema.client.opt_email_statement')</b><hr></h4>
    <div class="form-group col-lg-12 row">
        <div class="form-group col-lg-6 row m-0">
            <div class="radio">
                <label for="opt1">
                    <input type="radio" name="account[opt_notification]" value="1" id="opt1" checked>
                    <span class="cr"><i class="cr-icon mdi mdi-checkbox-blank-circle"></i></span>
                    @lang('sistema.client.yes')
                </label>
                &nbsp;&nbsp;&nbsp;
                <label for="opt0">
                    <input type="radio" name="account[opt_notification]" value="0" id="opt0">
                    <span class="cr"><i class="cr-icon mdi mdi-checkbox-blank-circle"></i></span>
                    @lang('sistema.client.no')
                </label>
            </div>
            <div class="radio"></div>
        </div>
    </div>
</div>