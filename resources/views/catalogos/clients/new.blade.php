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
	label.col-sm-3.form-control-label{
		padding-right:0px; 
	}
</style>
@endsection
@section('pagecontent')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">@lang('sistema.client.create_account')</h4>
                <ol class="breadcrumb p-0 m-0">
                    <li>
                        <a href="javascript:void(0)">@lang('sistema.pie')</a>
                    </li>                     
                    <li>
                        <a href="{{ url('clients') }}">
                            @lang('sistema.client.accounts')
                        </a>
                    </li>
                    <li class="active">
                        @lang('sistema.client.create_account')
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
                            <form class="form-horizontal"  method="POST" action="{{url('clients')}}" id="frm_clients" enctype="multipart/form-data" onsubmit="return validateFrm();">
                                {{ csrf_field() }}
                                <h4 class="m-b-30 m-t-0 header-title"><b>@lang('sistema.client.account_information')</b><hr></h4>
                                <div class="form-group col-lg-12 row">
                                    <div class="form-group col-lg-6 row m-0" id="inputbroker_id">
                                        <label for="broker_id" class="col-sm-3 form-control-label">@lang('sistema.client.broker')<span class="text-danger">*</span></label>
                                        <div class="col-sm-9">
                                            <select id="broker_id" class="form-control" name="account[broker_id]" valida="SI" cadena="{{__('sistema.client.broker_valid')}}">
                                                <option value="">@lang('sistema.btn_select')</option>
                                                @foreach($brokers as $key=>$value)
                                                <option value="{{ $key }}">{{ $value }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-lg-6 row m-0" id="inputtype_of_acc">
                                        <label for="type_of_acc" class="col-sm-3 form-control-label">@lang('sistema.client.type_of_acc')<span class="text-danger">*</span></label>
                                        <div class="col-sm-9">
                                            <select id="type_of_acc" class="form-control" name="account[account_type]" valida="SI" cadena="{{__('sistema.client.type_of_acc_valid')}}">
                                                <option value="">@lang('sistema.btn_select')</option>
                                                <option value="business">Business</option>
                                                <option value="individual">Individual</option>
                                                <option value="joint">Joint</option>													
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-lg-12 row">
                                    <div class="form-group col-lg-6 row m-0" id="inputacc_number">
                                        <label for="acc_number" class="col-sm-3 form-control-label">@lang('sistema.client.acc_number')<span class="text-danger">*</span></label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="acc_number" name="account[acc_number]" placeholder="{{__('sistema.client.acc_number')}}" valida="SI" cadena ="{{__('sistema.client.acc_number_valid')}}" value="{{ old('acc_number') }}" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group col-lg-6 row m-0" id="inputaccount_instruments">
                                        <label for="account_instruments" class="col-sm-3 form-control-label">@lang('sistema.client.financial_service')<span class="text-danger">*</span></label>
                                        <div class="col-sm-9">
                                            <select class="form-control" placeholder="{{__('sistema.client.financial_service')}}"  valida="SI" cadena ="{{__('sistema.client.financial_service_valid')}}" name="account_instruments[]" id="account_instruments" multiple="multiple">
                                                @foreach($account_instruments as $key=>$value)
                                                <option value="{{ $key }}">{{ $value}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div id="account_form_data"></div>
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
                                        <div class="form-group col-lg-6 m-0"></div>
                                        <div class="form-group col-lg-6 m-b-5">
                                            <button class="btn btn-danger remove pull-right m-r-5 btn-xs" type="button">
                                                <i class="glyphicon glyphicon-remove"></i> @lang('sistema.btn_remove')
                                            </button>
                                        </div>
                                    </div>
                                    <div class="form-group col-lg-12 row">
                                        <div class="form-group col-lg-6 row m-0">
                                            <label for="beneficiary_name" class="col-sm-3 form-control-label">@lang('sistema.client.beneficiary_name')<span class="text-danger">*</span></label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" name="beneficiary_name[]" placeholder="{{__('sistema.client.beneficiary_name')}}" valida="SI" cadena ="{{__('sistema.client.beneficiary_name_valid')}}" value="{{ old('beneficiary_name') }}">
                                            </div>
                                        </div>
                                        <div class="form-group col-lg-6 row m-0">
                                            <label for="beneficiary_percentage" class="col-sm-3 form-control-label">@lang('sistema.client.beneficiary_percentage')<span class="text-danger">*</span></label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control beneficiary_percent" name="beneficiary_percentage[]" placeholder="{{__('sistema.client.beneficiary_percentage')}}" valida="SI" cadena ="{{__('sistema.client.beneficiary_percentage_valid')}}" value="{{ old('beneficiary_percentage') }}">
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
<script src="{{ url('assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ url('assets/plugins/intlTelInput/build/js/intlTelInput.js') }}"></script>
<script src="{{ url('assets/plugins/autoNumeric/autoNumeric.js') }}"></script>
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
    $('#account_instruments').select2();

    function validateFrm()
    {
        //return true;
        var listv = 0;
        var msg = '';

        $('#frm_clients').find(':input').each(function() {
            if($(this).attr("valida")=="SI")
            {
                if($(this).val()==""||$(this).val()=="null")
                {
                    $(this).closest(".form-group").addClass("has-error");
                    msg+=$(this).attr('cadena')+'\n';
                    listv=1;
                }
                else
                {
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
            show_loader(true);
            $.ajax({
                url: "{{ url('/getbrokercolor')}}"+"/"+$(this).val(),
                method:'GET',
                dataType:'json',
                success: function(response){
                    if(response['data']){
                        $(".card").css("background-color",response['data']);
                    }else{
                        $(".card").css("background-color", "#fff");
                    }
                    $('#acc_number').val(response['code']);
                },
                complete: function(){
                    show_loader(false);
                }
            });
        }else{
            $(".card").css("background-color", "#fff");
            $('#acc_number').val('XXXXXXXXXX');
        }
    });

    $("body").on("change","#credit_line_facility",function () {
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

    $("body").on("click",".add-more-beneficiary",function(){
        var html = $(".beneficiory_section_copy").html();
        $(".before-add-more").before(html);
    });

    $('body').on('change',".client_country",function () {
        var client_state = $(this).closest(".client_personal_info").find(".state");
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
            }
        });
    });

    $('body').on('change',".state",function () {
        var client_city = $(this).closest(".client_personal_info").find(".city");
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
            }
        });
    });

    $('body').on('input','#opening_amount',function(e){
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

    function individual_joint_form_load(){
        //Initialize all select2 drop down
        $('.client_country').select2();
        $('.birth_country').select2();
        $('#fund_country').select2();
        $(".state").select2();
        $(".city").select2();
        $('#sales').select2();
        $('#manager').select2();
        $('#customer_care').select2();
        $('#analyst').select2();

        //Initialze date pickers
        $('.dob').datepicker({
            format: 'dd/mm/yyyy',
            autoclose: true
        });

        $('.date_picker').datepicker({
            format: 'dd/mm/yyyy',
            autoclose: true
        });
        //Initialize file uploaders
        $(".filestyle:file").filestyle();

        //Set telephone country code
        $(".inttel_input").intlTelInput({
            utilsScript: "{{ url('assets/plugins/intlTelInput/build/js/utils.js') }}",
            autoPlaceholder: true,
            preferredCountries: ['mx','us']
        });
        
        $('.autonumber').autoNumeric('init', {
            mDec: '2'
        });
    }

    $("#type_of_acc").change(function () {
        var type_of_acc = $("#type_of_acc").val();
        if(type_of_acc != ""){
            show_loader(true);
            $.ajax({
                url: "{{ url('/account_forms')}}"+"/"+$(this).val(),
                method:'GET',
                dataType:'json',
                success: function(response){
                    if(response['data'])
                    {  
                        $('#account_form_data').html(response['data']);
                        if(response['account_type'] == 'individual'){
                            individual_joint_form_load();
                        }else if(response['account_type'] == 'joint'){
                            individual_joint_form_load();
                        }else{
                            individual_joint_form_load();
                        }
                    }
                    else{
                      $('#account_form_data').html('');
                    }                   
                },
                complete: function(){
                    show_loader(false);
                }
            });
        }
        else{
            $('#account_form_data').html('');
        }
    });
    </script>
@endsection