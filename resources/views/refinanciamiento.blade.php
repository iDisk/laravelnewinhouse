@extends('layouts.front_vertical_menu')
@section('customcss')
<link href="{{ url('assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet">
<style type="text/css">
    b {
        font-weight: 600;
    }
    #help_block{
        display: none;
    }
    .row_block .pago_ul li{
        list-style-type: none;
    }
    .payment_fields .row > div{
        border-bottom: none !important;
    }
    .addNewPayment, .deletePayment {
        white-space: nowrap;
    }
</style>
@endsection

@section('pagecontent')
    <div class="container-fluid">
        <input type="hidden" id="_token" value="{{ csrf_token() }}">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box text-xs-center text-sm-center text-md-center">
                    <h4 class="page-title">@lang('frontsistema.refinanciamiento.title')</h4>
                    <div class="web_logo">
                        <img class="" src="{{ url('assets/images/logo_espacios.png')}}" alt="" height="50">
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
        <form id="finance_request_form">
            <!-- end row -->
            <div class="row on_load">
                <div class="col-xl-10 col-lg-12 col-md-12">
                    <h5 class="font-14 m-t-0 m-b-0">@lang('frontsistema.refinanciamiento.top_msg')</h5>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-6 offset-xl-2 col-lg-6 offset-lg-1 text-center m-t-20">
                    <div class="main-box black">
                        <div class="title">
                            @lang('frontsistema.refinanciamiento.current_credit_line')
                        </div>
                        <div class="amount text-custom-info font-600 m-t-0">                                    
                            {{ isset($saldo_calc) ? number_format($saldo_calc['linea_de_credito_actual'], 2, '.', ',') : 0.00 }}
                        </div>
                    </div>
                </div>
            </div>
            @if(isset($open_credit_requests) && count($open_credit_requests) > 0)
            <div class="row m-t-40 on_load">
                <div class="col-12">
                    <p class="m-0 font-600">
                        @lang('frontsistema.refinanciamiento.payments_title')
                    </p>
                </div>
            </div>                        
            <div class="row m-b-30">
                <div class="col-xl-10 col-lg-12 col-md-12">
                    <div class="card11">
                        <div class="card-body11">
                            <table id="payment-table" class="table table-striped m-0 balance_grid">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th class="color_green text-center">@lang('frontsistema.cerrar_un_financiamiento.ticket')</th>
                                        <th class="text-right">@lang('frontsistema.cerrar_un_financiamiento.amount')</th>                                        
                                        <th>@lang('frontsistema.cerrar_un_financiamiento.payment')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(isset($open_credit_requests) && count($open_credit_requests) > 0)
                                    @foreach($open_credit_requests as $keyIndex => $credit_request)
                                    <tr id="row_{{ $keyIndex }}" class="tr_row">
                                        <td>
                                            <div class="radio">                                                
                                                <label for="sent{{$keyIndex}}">
                                                    <input type="radio" name="document_sent" value="" id="sent{{$keyIndex}}" data-index="{{$keyIndex}}" {{ $keyIndex == 0 ? 'checked' : '' }}>                                                    
                                                    <span class="cr"><i class="cr-icon mdi mdi-checkbox-blank-circle"></i></span>
                                                    &nbsp;
                                                </label>
                                            </div>
                                        </td>
                                        <td class="text-center">{{ $credit_request['ticket'] }}</td>
                                        <td class="text-right">{{ number_format($credit_request['monto'], 2, '.', ',') }}</td>                                        
                                        <td class="row_block" data-id="{{ $keyIndex + 1 }}">
                                            <div class="payment_fields">
                                                <div class="row on_load paymentrow pymrow">
                                                    <div class="col-lg-3 col-md-12 m-t-10 p-l-0">
                                                        <ul class="m-0 pago_ul">
                                                            <li class="font-600 line-height-60">
                                                                @lang('frontsistema.refinanciamiento.payment') <span class="li_counter">1</span>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <div class="col-lg-3 col-md-6 m-t-10">
                                                        <label class="m-0 font-600 font-11">@lang('frontsistema.refinanciamiento.payment_amount')</label>
                                                        <input type="hidden" name="ticket" value="{{ $credit_request['ticket'] }}" guardar="SI"/>
                                                        <input class="form-control input-black autonumber" type="text">
                                                        <input type="hidden" class="payment_amount" data-parsley-pattern="\s*[1-9]\d*(\.\d{1,2})?\s*" name="payment_amount1" id="payment_amount_{{ $keyIndex + 1 }}_1" placeholder="" data-parsley-trigger="change" value="" required guardar="NO">
                                                        <div class="form-error">@lang('frontsistema.refinanciamiento.payment_amount_error')</div>
                                                    </div>
                                                    <div class="col-lg-3 col-md-6 m-t-10">
                                                        <label class="m-0 font-600 font-11">@lang('frontsistema.refinanciamiento.payment_date')</label>
                                                        <input class="form-control input-black payment_date" type="text" name="payment_date1" onkeydown="return false" id="payment_date_{{ $keyIndex + 1 }}_1" autocomplete="off" required placeholder="" guardar="NO">
                                                        <div class="form-error">@lang('frontsistema.refinanciamiento.payment_date_error')</div>
                                                    </div>
                                                    <div class="col-lg-2 p-l-0 p-r-0">
                                                        <label class="m-0 font-600 font-11">&nbsp;</label>
                                                        <div class="line-height-60 text-aqua-blue cursor-pointer text-sm-center text-xs-center text-md-center addNewPayment" id="addNewPayment{{ $keyIndex }}">
                                                            <span class="mdi mdi-plus-circle"></span>
                                                            @lang('frontsistema.refinanciamiento.add_payment')
                                                        </div>
                                                    </div>
                                                    <!-- end col -->
                                                </div>
                                            </div>
                                            <div class="additional_blocks"></div>
                                        </td>
                                    </tr>
                                    @endforeach
                                    @else
                                    <tr>
                                        <td colspan="4" class="text-center font-600 font-16">@lang('frontsistema.refinanciamiento.no_data')</td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>            
            <div class="row on_load" id="help_block">
                <div class="col-xl-10 col-lg-12 col-md-12">
                    <div class="card help_card_widget">
                        <div class="card-body">
                            <p class="m-0">
                                @lang('frontsistema.refinanciamiento.help_msg1') <a href="javascript:void(0)" class="open_contact_us_form">@lang('frontsistema.click_here')</a> @lang('frontsistema.refinanciamiento.help_msg2') 
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row on_load">
                <div class="col-xl-10 col-lg-12 col-md-12">
                    <div class="font-16 font-600 font_primary_color">@lang('frontsistema.refinanciamiento.terms_and_conditions')</div>
                </div>
            </div>
            <div class="row on_load">
                <div class="col-xl-10 col-lg-12 col-md-12">
                    <h5 class="font-14 terms-div-border">
                        {!! (session('language') == 'es' ? $broker_setting['refinancing_disclaimer_es'] : $broker_setting['refinancing_disclaimer_en']) !!}
                        <div class="checkbox checkbox-custom m-t-0 line-height-20">
                            <label class="m-b-0 ckCursor" for="termsandconditions">
                                <input type="checkbox" value="1" name="termsandconditions" id="termsandconditions" required parsley-trigger="change">
                                <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                @lang('frontsistema.refinanciamiento.accept_text')
                            </label>
                            <div class="form-error">@lang('frontsistema.refinanciamiento.terms_error')</div>
                        </div>
                    </h5>
                </div>
            </div>
            @else
            <div class="row m-t-30 m-b-30">
                <div class="col-xl-10 text-center">
                    <strong class="font-600 font-16">@lang('frontsistema.refinanciamiento.no_data')</strong>
                </div>
            </div>
            @endif
            <div class="row m-t-30 m-b-30">
                <div class="col-xl-10 text-right">
                    <a class="text-aqua-blue m-r-10 cursor-pointer line-height-35" href="{{ route('client_home') }}">@lang('frontsistema.btn_cancel')</a>
                    @if(isset($open_credit_requests) && count($open_credit_requests) > 0)
                    <button class="btn btn-aqua-blue waves-effect waves-light" type="button" id="btnSubmitRefinance">@lang('frontsistema.refinanciamiento.submit_button')</button>
                    @endif
                </div>
            </div>
        </form>
        <div class="row on_success m-t-50" style="display: none;">
            <div class="col-lg-12 text-center">
                <h3 class="font-600">@lang('frontsistema.refinanciamiento.success_msg_title')</h3>
                <p class="text-custom-info font-600 font-16 m-b-0">@lang('frontsistema.refinanciamiento.success_msg')</p>
                <p class="text-custom-info font-600 font-16">@lang('frontsistema.refinanciamiento.success_second_msg')</p>
                <div class="row">
                    <div class="col-12 text-center">
                        <a class="text-aqua-blue m-r-10 cursor-pointer line-height-35" href="{{ route('client_home') }}">@lang('frontsistema.refinanciamiento.back_to_home')</a>
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
<script type="text/javascript" src="{{ asset('assets/plugins/moment/moment-with-locales.min.js') }}"></script>
<script src="{{ url('assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}" charset="UTF-8"></script>
<script src="{{ url('assets/plugins/bootstrap-datepicker/locales/bootstrap-datepicker.es.js') }}"></script>
<script src="{{ url('assets/plugins/autoNumeric/autoNumeric.js') }}"></script>
    <script type="text/javascript">
        $(function ($) {
            $('.autonumber').autoNumeric('init');
            initDatepicker2('payment_date', '+0d', null);
            valida_si();
        });

        function getFormattedValue($value)
        {
            return $value.replace(/\,/g, '');            
        }

        $('body').on('change', '.autonumber', function(){
            let unformatted_value = $(this).val();
            let formatted_value = getFormattedValue(unformatted_value);
            $(this).next('input').val(formatted_value);           
        });

        initParsleyValidation();
        initDatepicker('payment_date1', '+0d', null);

        $("#btnSubmitRefinance").click(function(){
            $.each($('.payment_amount'), function(i, val){
                $(val).parsley().validate();
            });
            $('#finance_request_form').submit();
            return false;
            //$(".").parsley().validate()
        });
        
        $('#submit-another-request').click(function() {
            $('#finance_request_form').show();
            $('.on_success').hide();
        });

        added_payments = 1;
        // Function to handle the click of add new payment button
        $('.addNewPayment').click(function() {
            let this_obj = $(this);
            let parent_row = $(this_obj).parents('.tr_row');            
            let count_payment_fields = $(parent_row).find('.payment_amount').length;

            let row_block = $(parent_row).find('.row_block');
            let parent_row_id = row_block.data('id');
            let payment_block = $(row_block).find('.payment_fields');
            let additional_blocks = $(row_block).find('.additional_blocks');
            let this_added_payments = count_payment_fields + 1;
            //console.log('parent_row_id', parent_row_id);
            //console.log('count_payment_fields', count_payment_fields);
            // console.log("clicked", $('#payment_amount'+added_payments).parsley().validate());
            //console.log('#payment_amount_'+parent_row_id+'_'+count_payment_fields, $('body').find('#payment_amount_'+parent_row_id+'_'+count_payment_fields));
            //$('#payment_amount'+added_payments).parsley().validate() === true && $('#payment_date'+added_payments).parsley().validate() === true            
            if (count_payment_fields < 3 && $('body').find('#payment_amount_'+parent_row_id+'_'+count_payment_fields).parsley().validate() === true && $('body').find('#payment_date_'+parent_row_id+'_'+count_payment_fields).parsley().validate() === true) {                                
                $(additional_blocks).append('<div class="row on_load pymrow paymentrow'+ this_added_payments +'">'+
                                    '<div class="col-xl-3 col-lg-2 col-md-12 m-t-10 p-l-0">'+
                                        '<ul class="m-0 pago_ul">'+
                                            '<li class="font-600 line-height-60 font_primary_color">'+
                                            "@lang('frontsistema.refinanciamiento.payment') <span class='li_counter'>"+this_added_payments+"</span>"
                                            +'</li>'+
                                        '</ul>'+
                                    '</div>'+
                                    '<div class="col-xl-3 col-lg-4 col-md-6 m-t-10">'+
                                        '<label class="m-0 font-600 font-11">@lang("frontsistema.refinanciamiento.payment_amount")</label>'+
                                        '<input class="form-control input-black autonumber" type="text">' +
                                        '<input class="payment_amount" type="hidden" data-parsley-pattern="\\s*[1-9]\\d*(\\.\\d{1,2})?\\s*" name="payment_amount'+ this_added_payments +'" id="payment_amount_'+ parent_row_id +'_'+ this_added_payments +'" placeholder="" data-parsley-trigger="change" value="" required guardar="NO">'+
                                        '<div class="form-error">@lang("frontsistema.refinanciamiento.payment_amount_error")</div>'+
                                    '</div>'+
                                    '<div class="col-xl-3 col-lg-4 col-md-6 m-t-10">'+
                                        '<label class="m-0 font-600 font-11">@lang("frontsistema.refinanciamiento.payment_date")</label>'+
                                        '<input class="form-control input-black payment_date" type="text" name="payment_date' + this_added_payments + '" id="payment_date_'+ parent_row_id + '_' +  this_added_payments + '" onkeydown="return false" autocomplete="off" required placeholder="" guardar="NO">'+
                                        '<div class="form-error">@lang("frontsistema.refinanciamiento.payment_date_error")</div>'+
                                    '</div>'+
                                    '<div class="col-xl-2 col-lg-2 p-l-0 p-r-0">'+
                                        '<label class="m-0 font-600 font-11">&nbsp;</label>'+
                                        '<div class="line-height-60 text-aqua-blue cursor-pointer text-sm-center text-xs-center text-md-center text-red deletePayment" id="deletePayment_'+parent_row_id+'_'+this_added_payments+'" data-parent="'+parent_row_id+'" data-index="'+this_added_payments+'">'+
                                            '<span class="mdi mdi-minus-circle"></span>'+
                                            " @lang('frontsistema.refinanciamiento.delete_payment')"+
                                        '</div>'+
                                    '</div>'+
                                    '<!-- end col -->'+
                                '</div>');
                $('.autonumber').autoNumeric('init');
                //console.log('magic', this_added_payments);
                if (this_added_payments == 2) {
                    // Init the datepicker of 2nd field to be after 1st date and till 7 days from it
                    payment_date1 = $(payment_block).find('.payment_date').datepicker('getDate');
                    payment_date2_start = new Date(payment_date1);
                    payment_date2_end = new Date(payment_date1);
                    payment_date2_start.setDate(payment_date2_start.getDate() + 1);
                    payment_date2_end.setDate(payment_date2_end.getDate() + 7);                    
                    initDatepicker('payment_date_'+ parent_row_id + '_' +  this_added_payments, payment_date2_start, payment_date2_end);
                }
                // Disable the add button and delete button of 2nd payment if 3rd payment is added
                else if (this_added_payments == 3) {
                    $('#deletePayment_'+ parent_row_id + '_' + (this_added_payments - 1)).css('visibility', 'hidden');
                    this_obj.css('visibility', 'hidden');
                    $("#help_block").show();
                    // Init the datepicker of 2nd field to be after 1st date and till 7 days from it                    
                    //console.log($(additional_blocks).find('#payment_date_'+ parent_row_id + '_' + (this_added_payments - 1)));                    
                    payment_date1 = $(payment_block).find('.payment_date').datepicker('getDate');
                    payment_date2 = $(additional_blocks).find('#payment_date_' + parent_row_id + '_' + (this_added_payments - 1)).datepicker('getDate');
                    payment_date3_start = new Date(payment_date2);
                    payment_date3_end = new Date(payment_date1);
                    payment_date3_start.setDate(payment_date3_start.getDate() + 1);
                    payment_date3_end.setDate(payment_date3_end.getDate() + 14);                    
                    initDatepicker(('payment_date_' + parent_row_id + '_' + this_added_payments), payment_date3_start, payment_date3_end);                    
                }
                else
                {
                    //console.log('now hide blue message');
                }
                // Disable the previous datepicker
                $('#payment_date_' + parent_row_id + '_' + (this_added_payments - 1)).attr('disabled', true);
                rearrange_blocks(row_block);
            }
        });

        // Function to handle the click of delete payment button
        $('body').on('click', '.deletePayment', function() {
            let this_obj = $(this);
            let parent_row = $(this_obj).parents('.tr_row'); 
            let row_block = $(parent_row).find('.row_block');
            
            let parent_block_id = this_obj.data('parent');
            let index_block_id = this_obj.data('index');
            
            $(row_block).find('.paymentrow'+index_block_id).remove();
            $(row_block).find('#deletePayment_'+ parent_block_id +'_'+(index_block_id-1)).css('visibility', 'visible');
            $(row_block).find('.addNewPayment').css('visibility', 'visible');
            // Enable the previous datepicker
            $('#payment_date_'+parent_block_id+'_'+index_block_id).attr('disabled', false);
            $("#help_block").hide();
            rearrange_blocks(row_block);
        });

        // Function to initialize the parsley validation
        function initParsleyValidation() {
            $('#finance_request_form').parsley().on('field:validated', function () {
                console.log("form error");
            })
            .on('form:submit', function () {
                
                swal({
                    title: "{{ __('frontsistema.confirm') }}",
                    text: "{{ __('frontsistema.refinanciamiento.confirmation_msg') }}",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: '#8cd5dd',
                    confirmButtonText: "{{ __('frontsistema.btn_yes') }}",
                    cancelButtonText: "No"
                })
                .then(function () {
                    if ($('#payment_date1')) {
                        $('#payment_date1').attr('disabled', false);
                    }
                    if ($('#payment_date2')) {
                        $('#payment_date2').attr('disabled', false);
                    }
                    submitRefinanciamientoForm();
                    console.log("submit form");
                    }, function (dismiss) {
                    //Code for cancel
                    }
                );
                return false; // Don't submit form for this demo
            });
        }

        // Function to handle the init of datepicker
        function initDatepicker(id, startDate, endDate) {
            var options = {
                format: 'dd/mm/yyyy',
                autoclose: true,
                startDate: startDate, // After current day
                language: '{{ session("language") }}',
            };
            if (endDate) {
                options['endDate'] = endDate;
            }
            //Initialze date pickers
            $('#' + id).datepicker(options).on('changeDate', function(e) {
                $(this).parsley().validate();
            });
        }
        
        function initDatepicker2(thisClass, startDate, endDate) {
            var options = {
                format: 'dd/mm/yyyy',
                autoclose: true,
                startDate: startDate, // After current day
                language: '{{ session("language") }}',
            };
            if (endDate) {
                options['endDate'] = endDate;
            }
            //Initialze date pickers
            $('.' + thisClass).datepicker(options).on('changeDate', function(e) {
                $(this).parsley().validate();
            });
        }
        
        function submitRefinanciamientoForm(){
            let token = $('#_token').val();

            let req_data = '{';

            let value_chkbox = $("#finance_request_form").find('input[name="document_sent"]:checked');
            
            let form_obj = $('#finance_request_form');
            
            if(value_chkbox.length > 0)
            {
                form_obj =  $(value_chkbox).parents('.tr_row');
            }
            
            form_obj.find(':input').each(function() 
            {
                if($(this).attr("guardar")=="SI")
                {
                    if(req_data != '{'){
                         req_data += ',';
                    }
                    req_data += '"'+ $(this).attr("name") +'":{"type":"text","value":"'+$(this).val()+'"}'; 
                }
                
            });

            req_data += '}';

            $.ajax({
                type: 'POST',
                dataType: 'json',
                data: {'_token':token,'text':req_data,'request_type_id':6,'verify':0,'from':'Refinanciamiento'},
                url: "{{ url('user/client_request') }}",
                beforeSend: function() {
                    show_loader(true);
                },
                success: function(response) {
                    if (response.error && response.code == '500'){

                    }
                    else if(!response.error && response.code == '200'){                        
                        $("#finance_request_form").hide();
                        $("#finance_request_form").trigger("reset");
                        $('.on_success').show();
                        window.scrollTo(0, 0);
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
        
        function rearrange_blocks(parent_block)
        {
            let starter_id = 1;
            let block_row_id = $(parent_block).data('id');
            $.each($(parent_block).find('.additional_blocks .pymrow'), function(i, val){
                $(val).find('.li_counter').html(starter_id+1);
                $(val).find('.payment_amount').attr('id', 'payment_amount_'+ block_row_id + '_' + (i+2)).attr('name', 'payment_amount'+(i+2)).attr('guardar', 'SI');
                $(val).find('.payment_date').attr('id', 'payment_date_'+ block_row_id + '_' + (i+2)).attr('name', 'payment_date'+(i+2)).attr('guardar', 'SI');
                $(val).find('.deletePayment').attr('id', 'deletePayment_'+ block_row_id + '_' + (i+2)).attr('data-parent', block_row_id).attr('data-index', (i+2));
                //$(val).find('.fileLable').html('{{ __("frontsistema.administracion_cuenta.fileLbl") }}' + (i + 2) + ':'); 
                starter_id++;
            });
        }
        
        function valida_si()
        {
            $(".tr_row").each(function(i, val){
                let this_row = $(val);
                let value_chkbox = $(val).find('input[name="document_sent"]');

                if($(value_chkbox).is(':checked'))
                {
                    $(this_row).find('.payment_amount').attr('guardar', "SI").attr('required', true);
                    $(this_row).find('.payment_date').attr('guardar', "SI").attr('required', true);
                }
                else
                {
                    $(this_row).find('.payment_amount').attr('guardar', "NO").removeAttr('required');
                    $(this_row).find('.payment_date').attr('guardar', "NO").removeAttr('required');
                }
            });
        }
        
        $('input[name="document_sent"]').change(function(){
            valida_si();
        });
    </script>
@endsection