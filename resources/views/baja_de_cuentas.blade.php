@extends('layouts.front_vertical_menu')
@section('customcss')
<link href="{{ url('assets/plugins/datatables/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ url('assets/plugins/datatables/buttons.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ url('assets/plugins/datatables/responsive.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ url('assets/plugins/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css"/>
<style type="text/css">
    .page-item.active .page-link {
        background: #8cd5dd;
        border-color: #8cd5dd;
    }
    .small_color_bx{
        height: 10px;
        width: 10px;
        display: block;
        text-align: center;
        margin: auto;
    }
    .sucess-header{
    }
    .success_desc{
        font-size: 18px;
    }
    .eliminar-btn{
        cursor: pointer;
    }
    .on_mobValidate, .on_successDiv{
        display: none;
    }
</style>
@endsection

@section('pagecontent')
<div class="container-fluid">
        <input type="hidden" id="_token" value="{{ csrf_token() }}">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <h4 class="page-title">@lang('frontsistema.baja_de_cuentas.title')</h4>
                    <div class="web_logo">
                        <img class="" src="{{ url('assets/images/logo_espacios.png')}}" alt="" height="50">
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
        <!-- end row -->
        <div class="row on_load">
            <div class="col-lg-12 m-b-50">
                <div class="card11">
                    <div class="card-body11">
                        <p class="text-muted m-b-20">
                        </p>
                        <table class="table table-striped m-0 balance_grid" id="baja_de_cuentas-table">
                            <thead>
                                <tr>
                                    <th class="text-center">@lang('frontsistema.baja_de_cuentas.dis_date')</th>
                                    <th>@lang('frontsistema.baja_de_cuentas.acc_number')</th>
                                    <th>@lang('frontsistema.baja_de_cuentas.acc_desc')</th>
                                    <th>@lang('frontsistema.baja_de_cuentas.acc_type')</th>
                                    <th>@lang('frontsistema.baja_de_cuentas.destino')</th>
                                    <th>@lang('frontsistema.baja_de_cuentas.bank')</th>
                                    <th>@lang('frontsistema.baja_de_cuentas.badge')</th>
                                    <th></th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
            <!-- end col -->
        </div>
        <!-- end row --> 

        <!-- OTP validation form -->
        <div class="on_mobValidate">
            <div class="row">
                <div class="col-lg-12">
                    <label class="font-700 font-16">@lang('frontsistema.validate_mob.title')</label>
                </div>
            </div>
            <input type="hidden" name="client_request_id" id="client_request_id" value="">
            
            <div class="row">
                <div class="col-lg-6 m-t-40">
                    <div class="verificarFormWarning alert alert-warning d-none fade show">
                        <h4 class="text-warning mt-0">@lang('frontsistema.validate_mob.warning_title')</h4>
                        <p id="verificarWarningMsg" class="mb-0"> </p>
                    </div>
                    <div class="verificarFormSuccess alert alert-info d-none fade show">
                        <h4 class="alert-info mt-0">@lang('frontsistema.validate_mob.success_title')</h4>
                        <p id="verificarSuccessMsg" class="mb-0"> </p>
                    </div>
                    <label class="font-600">@lang('frontsistema.validate_mob.enter_registered_mobile')</label>
                </div>
                <div class="col-lg-12 m-t-5 m-b-5">
                    
                </div>
                <div class="col-xl-6 col-md-6">
                    <div class="row">
                        <div class="col-xl-6 col-md-6">
                            <div class="form-group">
                                <label for="inputmob_codigo" class="font-700 font-11">@lang('frontsistema.validate_mob.code')</label>
                                <input type="text" class="form-control input-black" id="inputmob_codigo" name="mob_codigo" guardar="SI">
                                <div id="code_error" class="form-error">@lang('frontsistema.validate_mob.code_error')</div>
                            </div>
                        </div>
                        <div class="col-xl-6 col-md-6 m-t-30">
                            <label  class="font-700 font-11">&nbsp;</label>
                            <button type="button" id="verificar_codigo" class="btn btn-aqua-blue waves-effect waves-light send-codigo"> <span>@lang('frontsistema.validate_mob.send')</span> </button>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <label class="font-600 m-0"><a id="generar_codigo" href="javascript:void(0);" class="text-custom-info text-underline">@lang('frontsistema.validate_mob.send_new_code')</a></label>
                </div>
                <div class="col-lg-12">
                    <label class="font-600 m-t-40">@lang('frontsistema.validate_mob.contact_msg1') <a href="javascript:void(0);" class="text-custom-info text-underline open_contact_us_form">@lang('frontsistema.validate_mob.contact_msg2')</a></label>
                </div>
            </div>
        </div>
        <!-- OTP validation form -->

        <!-- Success message -->
        <div class="row on_successDiv m-t-50">
            <div class="col-lg-12 text-center">
                <h3 class="font-600">@lang('frontsistema.baja_de_cuentas.success_msg_header')</h3>
                <p class="text-custom-info font-600 font-16">@lang('frontsistema.baja_de_cuentas.success_msg_desc')</p>
                <a class="text-aqua-blue m-t-20 cursor-pointer line-height-35" href="{{ route('client_home') }}">@lang('frontsistema.diversifique.back_to_home')</a>
            </div>
        </div>
        <!-- Success message -->

       
        <div class="row success_message justify-content-md-center m-t-50" style="display: none;">
            <div class="col-xl-6 col-md-6">
                <div class="card widget-box-three m-b-15">
                    <div class="card-body">
                        <div class="text-center11">
                            <div class="row">
                                <div class="col-md-12">
                                    <p class="m-t-5 m-b-0"><span class="font-700">@lang('frontsistema.validate_mob.user'):</span> {{ $client->FullName}}</p>
                                </div>
                                <div class="col-md-12">
                                    <p class="m-t-5 m-b-0"><span class="font-700">@lang('frontsistema.validate_mob.contract'):</span> <val id="request_folio_number"
                                        ></val></p>
                                </div>
                                <div class="col-md-12">
                                    <p class="m-t-5 m-b-0"><span class="font-700">@lang('frontsistema.validate_mob.application_date'):</span> {{ date('d-m-Y') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- container-fluid -->
@endsection

@section('customjs')
<script type="text/javascript" src="{{ url('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script type="text/javascript" src="{{ url('assets/plugins/datatables/dataTables.bootstrap4.min.js') }}"></script>
<script type="text/javascript" src="{{ url('assets/plugins/datatables/dataTables.keyTable.min.js') }}"></script>
<script type="text/javascript" src="{{ url('assets/plugins/datatables/dataTables.responsive.min.js') }}"></script>
<script type="text/javascript" src="{{ url('assets/plugins/datatables/responsive.bootstrap4.min.js') }}"></script>

<script type="text/javascript">

    $('.success_message').hide();

    function confirmaDel(id,text)
    {
        var dec = window.atob(text);
        var response = JSON.parse(dec);
        
        //console.log(text,dec);
        swal({
            title: "{{ __('frontsistema.confirm') }}",
            text: "{{ __('frontsistema.baja_de_cuentas.delete_msg') }} :\""+response.dest_account_number+'\"?',
            type: "warning",
            showCancelButton: true,
            //confirmButtonColor: '#DD6B55',
            confirmButtonText: "{{ __('frontsistema.btn_yes') }}",
            cancelButtonText: "{{ __('frontsistema.btn_cancel') }}"
        }).then(function () {
            ajax_send_request(response);
        }, function (dismiss) {
            //Code for cancel
        }) 
    }


    function  ajax_send_request(req)
    {
        //console.log(dec1.id);
        show_loader(true);

        var token = $('#_token').val();
        var account_number = req.dest_account_number;
        var name = req.first_name;
        var destination_type = req.destination_type;

        if(req.destination_type == 'same'){
            destination_type = "{{ config('site.destinations.same.'.session('language')) }}";
        }else if(req.destination_type == 'international'){
            destination_type = "{{ config('site.destinations.international.'.session('language')) }}";
        }
        
        var bank_name = req.dest_bank_name;
        var currency = req.currency;
        
        var req_data = '{"bdc_num_de_cuenta":{"type":"text","value":"'+ account_number +'"},"bdc_tipo_cuenta":{"type":"text","value":"'+ req.instrument +'"},"bdc_descripcion_cuenta":{"type":"text","value":"'+ name +'"},"bdc_destination":{"type":"text","value":"'+ destination_type +'"},"bdc_banco":{"type":"text","value":"'+ bank_name +'"},"bdc_divisa":{"type":"text","value":"'+ currency +'"},"bdc_action_eliminar":{"type":"text","value":"Eliminar"}}';

        $.ajax({
            type: 'POST',
            dataType: 'json',
            data: {'_token':token,'text':req_data,'request_type_id':29,'verify':1,'from':'BAJA DE CUENTAS'},
            url: "{{ url('user/client_request') }}",
             beforeSend: function() {
                //$('#modal-espere').modal('show');
            },
            success: function(response) {
                 if (response.error && response.code == '500') {
                    swal({
                        title:'Aviso!!',
                        text:response.message,
                        type:'error',
                        timer: 3000,
                        confirmButtonColor:'red',
                        confirmButtonText:'OK'
                    });
                }
                else if(!response.error && response.code == '200') {
                    $('#request_folio_number').html(response.filio_number);
                    $('#client_request_id').val(response.client_request_id);
                    $('.on_load').hide();
                    $('.on_mobValidate').show();
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

    var item_tbl;
    //Aqui deben de ir las secciones adicionales
    $(function() {
        item_tbl = $('#baja_de_cuentas-table').DataTable({
            processing: true,
            serverSide: true,
            order: [[ 0, 'desc']],
            ajax: {
                url: '{!! url("user/datatable/baja_de_cuentas") !!}',
                data: function (d) {
                    let search_keyword = $('body').find('input[name=custom_search]');
                    if (!search_keyword.length)
                    {
                        d.search = {
                            'value': ''
                        };
                    }
                    else
                    {
                        d.search = {
                            'value': search_keyword.val()
                        };
                    }
                }
            },
            "dom": 'l<>rtip',
            language:{
            @if(\Lang::locale() == 'es')
                url: '{{url("assets/plugins/datatables/json/Spanish.json")}}'
            @endif
            },
            "bStateSave": true,
            "fnStateSave": function (oSettings, oData) {
                localStorage.setItem( 'DataTables', JSON.stringify(oData) );
            },
            "fnStateLoad": function (oSettings) {
                return JSON.parse( localStorage.getItem('DataTables') );
            },
            columns: [
                { data: 'created_at',name: 'created_at'},
                { data: 'dest_account_number',name: 'dest_account_number'},
                { data: 'first_name',name: 'first_name'},
                { data: 'instrument', name: 'instrument' },
                { data: 'destination_type', name: 'destination_type' },
                { data: 'dest_bank_name', name: 'dest_bank_name' },
                { data: 'currency', name: 'currency' },
                { data: 'action', name: 'action', orderable:false, searchable:false },
            ]
        });
    });

    $('#verificar_codigo').click(function() {
        
        $('.verificarFormSuccess').toggleClass('d-none', true);
        $('.verificarFormWarning').toggleClass('d-none', true);

        //basic validation
        // var v = grecaptcha.getResponse();
        var list =0;
        let code = $('#inputmob_codigo').val();

        $('#recaptcha_error').hide();
        $('#code_error').hide();
        // if(v.length == 0)
        // {
        //     list = 1;
        //     $('#recaptcha_error').show();
        // }
        if(code == '')
        {
            list = 1;
            $('#code_error').show();
        }

        if(list == 1){
            return true;
        }
        //Ajax call to check OTP
        show_loader(true);

        let client_request_id = $('#client_request_id').val();
        let token = $('#_token').val();

        $.ajax({
            type: 'POST',
            dataType: 'json',
            data: {'_token':token,'client_request_id':client_request_id,'code':code},
            url: "{{ url('user/verify_request') }}",
            beforeSend: function() {
                //$('#modal-espere').modal('show');
            },
            success: function(response) {
                if (response.error && response.code == '500'){

                    $('#verificarWarningMsg').html(response.message);
                    $('.verificarFormWarning').toggleClass('d-none', false);
                }
                else if(!response.error && response.code == '200'){
                    //$('#request_folio_number').html(response.filio_number);
                    $('.on_load').hide();
                    $('.on_mobValidate').hide();
                    $('.on_successDiv').show();
                    window.scrollTo(0, 0);
                }
            },
            error: function(response) {
                //console.error(response);
                swal("@lang('frontsistema.users_alert')", "@lang('frontsistema.control_de_acceso.went_wrong_msg')", 'error');
            },
            complete: function() {
                show_loader(false);
            }
        });
    });
    $('#generar_codigo').click(function(){

        show_loader(true);

        $('.verificarFormSuccess').toggleClass('d-none', true);
        $('.verificarFormWarning').toggleClass('d-none', true);

        let token = $('#_token').val();

        $.ajax({
            type: 'POST',
            dataType: 'json',
            data: {'_token':token},
            url: "{{ url('user/generate_code') }}",
            beforeSend: function() {
                //$('#modal-espere').modal('show');
            },
            success: function(response) {
                if (response.error && response.code == '500'){
                   
                    $('#verificarWarningMsg').html(response.message);
                    $('.verificarFormWarning').toggleClass('d-none', false);
                }
                else if(!response.error && response.code == '200'){

                    $('#verificarSuccessMsg').html(response.message);
                    $('.verificarFormSuccess').toggleClass('d-none', false);
                }
            },
            error: function(response) {
                //console.error(response);
                swal("@lang('frontsistema.users_alert')", "@lang('frontsistema.control_de_acceso.went_wrong_msg')", 'error');
            },
            complete: function() {
                show_loader(false);
            }
        });
    });
</script>
@endsection