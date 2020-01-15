@extends('layouts.front_vertical_menu')
@section('customcss')
<link href="{{ url('assets/plugins/bootstrap-fileupload/bootstrap-fileupload.css') }}" rel="stylesheet" />
<style type="text/css">
    .checkbox .cr, .radio .cr{
        width: 20px;
        height: 20px;
    }
    .checkbox label, .radio label{
        font-weight: 600; 
    }
    .cancel_btn{
        text-decoration: underline;
    }
    .send-codigo{
        width: 100%;
    }
    .on_load{
        /*display: none;*/
    }
    .on_mobValidate, .on_successDiv{
        display: none;
    }
    .btn-file-cross {
        background-color: red;
        color: white;
        text-shadow: none;
    }
    .additional_blocks{
        width: 100%;
    }
    b{
        font-weight: 600;
    }
</style>
@endsection

@section('pagecontent')
    <div class="container-fluid">
        <input type="hidden" id="_token" value="{{ csrf_token() }}">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box text-xs-center text-sm-center text-md-center">
                    <h4 class="page-title">@lang('frontsistema.cerrar_un_financiamiento.title')</h4>
                    <div class="web_logo">
                        <img class="" src="{{ url('assets/images/logo_espacios.png')}}" alt="" height="50">
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
        <form id="finance_request_form" enctype="multipart/form-data">
            <!-- end row -->
            <div class="row">
                <div class="col-xl-6 offset-xl-2 col-lg-6 offset-lg-1 text-center m-t-20">
                    <div class="main-box black">
                        <div class="title">
                            @lang('frontsistema.cerrar_un_financiamiento.current_credit_line')
                        </div>
                        <div class="amount text-custom-info font-600 m-t-0">
                            {{ isset($saldo_calc) ? number_format($saldo_calc['linea_de_credito_actual'], 2, '.', ',') : 0.00 }}
                        </div>
                    </div>
                </div>
            </div>
            @if(isset($open_credit_requests) && count($open_credit_requests) > 0)
            <div class="row m-b-50 on_load">
<!--                <div class="col-xl-3 col-lg-12 col-md-12 m-t-40 text-center">
                    <p class="m-0 font-600">@lang('frontsistema.cerrar_un_financiamiento.your_account')</p>
                    <h3 class="text-custom-info font-600 m-t-0">@{{ $account->account_number  }}</h3>
                </div>-->
                <div class="col-xl-9">

                </div>
                <!-- end col -->
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
                                        <th>@lang('frontsistema.cerrar_un_financiamiento.send_receipt')</th>
                                    </tr>
                                </thead>
                                <tbody>                    
                                    @if(isset($open_credit_requests) && count($open_credit_requests) > 0)
                                    @foreach($open_credit_requests as $keyIndex => $credit_request)
                                    <tr id="row_{{ $keyIndex }}" class="tr_row">
                                        <td>
                                            <div class="radio">
                                                <input type="hidden" name="ticket" value="{{ $credit_request['ticket'] }}" guardar="SI"/>
                                                <label for="sent{{$keyIndex}}">
                                                    <input type="radio" name="document_sent" value="" id="sent{{$keyIndex}}" data-index="{{$keyIndex}}" {{ $keyIndex == 0 ? 'checked' : '' }}>                                                    
                                                    <span class="cr"><i class="cr-icon mdi mdi-checkbox-blank-circle"></i></span>
                                                    &nbsp;
                                                </label>
                                            </div>
                                        </td>
                                        <td class="text-center">{{ $credit_request['ticket'] }}</td>
                                        <td class="text-right">{{ number_format($credit_request['monto'], 2, '.', ',') }}
                                            @if($credit_request['paid'])
                                            <div>@lang('frontsistema.cerrar_un_financiamiento.depositado'): {{ number_format($credit_request['paid'], 2, '.', ',') }}</div>
                                            @endif
                                        </td>
                                        <td class="row_block" data-id="{{ $keyIndex + 1 }}">
                                            <div class="file_upload_wrapper">
                                                <div class="file_upload_block" style="margin-top:2px;">
                                                    <div class="col-lg-12" style="padding: 10px 10px 0 10px;">
                                                        <div class="col-md-2" style="display: inline-block; float: right;">
                                                             <button type="button" class="btn btn-aqua btnAddMoreFiles" id="btnAddMoreFiles"><i class="fa fa-plus"></i></button>
                                                        </div>                                                        
                                                        <div class="controls col-md-8" style="display: inline-block;">
                                                            <div class="fileupload fileupload-new" data-provides="fileupload">
                                                                <label class="font-14 font-700 m-r-10 fileLable">@lang('frontsistema.administracion_cuenta.fileLbl') 1:</label>
                                                                <button type="button" class="btn btn-aqua btn-file">
                                                                    <span class="fileupload-new"><i class="fa fa-paper-clip"></i> @lang('frontsistema.administracion_cuenta.select_file_btn')</span>
                                                                    <span class="fileupload-exists"><i class="fa fa-undo"></i> @lang('frontsistema.administracion_cuenta.change_btn')</span>
                                                                    <input type="file" name="user_document[{{ $keyIndex + 1 }}][]" class="document btn-secondary" accept=".jpg,.gif,.png,.pdf" onChange="validDocumentFile(event)"/>
                                                                </button>
                                                                <br><br>
                                                                <span class="fileupload-preview" style="margin-left:5px; margin-top: 5px;"></span>
                                                                <a href="#" class="close fileupload-exists btn btn-file-cross" data-dismiss="fileupload" style="float: none; margin-left:5px;"><i class="fa fa-times"></i></a>
                                                                <div class="file_upload_error"></div>                                                                
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="additional_blocks"></div>
                                            </div>
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
                            <div class="col-lg-12 font_primary_color">
                                <i>*@lang('frontsistema.cerrar_un_financiamiento.receipt_formats')</i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="m-b-30" style="display: none;">
                <div class="row on_load">
                    <div class="col-xl-4 col-lg-5 col-md-12 m-t-10 text-right custom-text-sm-left custom-text-md-left text-xs-left">
                        <p class="m-0 font-600 line-height-80 line-height-md-initial line-height-sm-initial line-height-xs-initial">@lang('frontsistema.cerrar_un_financiamiento.receipt_label')</p>
                    </div>
                    <div class="col-xl-4 col-lg-7 col-md-12 m-t-10">
                        <label class="m-0 font-600 font-11">@lang('frontsistema.cerrar_un_financiamiento.receipt_formats')</label>
                        <!--<input class="form-control input-black" type="file" id="receipt" name="receipt" data-parsley-trigger="change" data-parsley-filemimetypes="image/jpeg, image/png, image/jpg, application/msword, application/vnd.openxmlformats-officedocument.wordprocessingml.document, application/pdf" required guardar="SI">-->
                        <div class="form-error">@lang('frontsistema.cerrar_un_financiamiento.receipt_formats_error')</div>
                    </div>
                    <!-- end col -->
                </div>
            </div>
            <div class="row on_load">
                <div class="col-xl-10 col-lg-12 col-md-12">
                    <div class="card help_card_widget">
                        <div class="card-body">
                            <p class="m-0">
                                @lang('frontsistema.cerrar_un_financiamiento.help_msg1') <a href="javascript:void(0)" class="open_contact_us_form">@lang('frontsistema.click_here')</a> @lang('frontsistema.cerrar_un_financiamiento.help_msg2') 
                            </p>
                        </div>
                    </div>
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
                    <button class="btn btn-aqua-blue waves-effect waves-light" type="submit">@lang('frontsistema.cerrar_un_financiamiento.submit_button')</button>
                    @endif
                </div>
            </div>
        </form>
        <div class="row on_success m-t-50" style="display: none;">
            <div class="col-lg-12 text-center">
                <h3 class="font-600">@lang('frontsistema.cerrar_un_financiamiento.success_msg_title')</h3>
                <p class="text-custom-info font-600 font-16 m-b-0">@lang('frontsistema.cerrar_un_financiamiento.success_msg')</p>
                <div class="row">
                    <div class="col-12 text-center">
                        <a class="text-aqua-blue m-r-10 cursor-pointer line-height-35" href="{{ route('client_home') }}">@lang('frontsistema.cerrar_un_financiamiento.back_to_home')</a>
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
    <script src="{{ url('assets/plugins/bootstrap-fileupload/bootstrap-fileupload.js') }}"></script>
    <script type="text/javascript">
        initParsleyValidation();

        // Function to initialize the parsley validation
        function initParsleyValidation() {
            $('#finance_request_form').parsley().on('field:validated', function () {
                console.log("form error");
            })
            .on('form:submit', function () {
                swal({
                    title: "{{ __('frontsistema.confirm') }}",
                    text: "{{ __('frontsistema.cerrar_un_financiamiento.confirmation_msg') }}",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: '#8cd5dd',
                    confirmButtonText: "{{ __('frontsistema.btn_yes') }}",
                    cancelButtonText: "No"
                })
                .then(function () {
                    submitCerrarFinanciamientoForm();
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
        
        function submitCerrarFinanciamientoForm(){            
            var $form = $("#finance_request_form");
            if(!validDocumentFiles($form)){
                swal("@lang('frontsistema.users_alert')", "@lang('frontsistema.envio_de_documentacion.file_upload_err')", 'error');
                return;
            } 
                        
            let token = $('#_token').val();

            let req_data = '{';
            
            let checked_row = $("input[name='document_sent']:checked");
            
            let row_parent = checked_row.parents('tr.tr_row'); 
            
            $(row_parent).find(':input').each(function(){
                if($(this).attr("guardar")=="SI")
                {
                    if(req_data != '{'){
                         req_data += ',';
                    }
                    req_data += '"'+ $(this).attr("name") +'":{"type":"text","value":"'+$(this).val()+'"}'; 
                }
                
            });

            req_data += '}';
            
           
            
            var form_data = new FormData();
            
            $(row_parent).find("input[type=file]").each(function(index, field){
                if(field != undefined && field.files.length>0){
                    form_data.append('documents[]',field.files[0]);
                }
            });
            form_data.append('text', req_data);
            form_data.append('request_type_id', 7);
            form_data.append('verify', 0);
            form_data.append('from', 'Cerrar un Financiamiento');
            form_data.append('_token', token);
            show_loader(true);
            $.ajax({
                url: "{{ url('user/client_request') }}",
                type: 'post',
                dataType: 'text',
                data: form_data,
                cache: false,
                contentType: false,
                processData: false,
                success: function(response) {
                    response = JSON.parse(response);
                    if (response.error && response.code == '500'){
                        console.log('no');
                    }
                    else if(!response.error && response.code == '200'){
                        console.log('yes');
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
        
        function validDocumentFiles($form){
            var docFlag = false;
            let checked_row = $("input[name='document_sent']:checked");
            let row_parent = checked_row.parents('tr.tr_row');
            
            $(row_parent).find("input[type=file]").each(function(index, field){
                if(field != undefined && field.files.length>0){
                    docFlag = true;
                }
            });
            return docFlag;
        }
        
        function validDocumentFile(event){
            if(event.target.files.length == 0){
                return;
            }
            
            let total_file_length = event.target.files.length;

            for(let i = 0; i < total_file_length; i++)
            {
                var fileItem = event.target.files[i];
                if(fileItem.type=="image/jpeg" || fileItem.type=="image/jpg" || fileItem.type=="image/png" || fileItem.type=="image/gif" || fileItem.type == "application/pdf"){
                    if (fileItem.size > 5242880) { 
                        // $('#document1').closest('[type="button"]').find(".file_upload_error").html('File should be less than 5 mb');
                        // $('.file_upload_error').text('File should be less than 5 mb');
                        // alert("Try to upload file less than 5MB!"); 
                        event.target.files.length = 0;
                        event.target.value = '';
                        swal("@lang('frontsistema.users_alert')", "@lang('frontsistema.administracion_cuenta.file_upload_size_err')", 'error');
                    } 
                }
                else{
                    event.target.files.length = 0;
                    event.target.value = '';
                    swal("@lang('frontsistema.users_alert')", "@lang('frontsistema.administracion_cuenta.file_upload_type_err')", 'error');
                }
            }
        }  
        
    $(".btnAddMoreFiles").click(function(){
        let this_obj = $(this);
        let max_length = 5;
        let parent_block = this_obj.parents('td.row_block');
        let parent_block_id = parent_block.data('id');
        let current_length = $(parent_block).find('.file_upload_block').length;

        if(current_length >= max_length)
        {
           console.log('cant add more');
        }
        else
        {
            let next_block = current_length + 1;
            let block_html = '<div class="file_upload_block" style="margin-top:2px;">';
            block_html += '<div class="col-lg-12" style="padding: 10px 10px 0 10px;">'
            block_html += '<div class="col-md-2" style="display: inline-block; float: right;"><button type="button" class="btn btn-danger btn-file btnRemoveFileBlock"><i class="fa fa-times"></i></button></div>';
            block_html += '<div class="controls col-md-8" style="display: inline-block;">';
            block_html += '<div class="fileupload fileupload-new" data-provides="fileupload">';
            block_html += '<label class="font-14 font-700 m-r-10 fileLable">Archivo '+next_block+':</label>';
            block_html += '<button type="button" class="btn btn-aqua btn-file">';
            block_html += '<span class="fileupload-new"><i class="fa fa-paper-clip"></i> '+ "{{ __('frontsistema.administracion_cuenta.select_file_btn') }}" + '</span>';
            block_html += '<span class="fileupload-exists"><i class="fa fa-undo"></i> '+ "{{ __('frontsistema.administracion_cuenta.change_btn') }}" +'</span>';
            block_html += '<input type="file" name="user_document['+ parent_block_id +'][]" class="user_document btn-secondary" class="btn-secondary" accept=".jpg,.gif,.png,.pdf" onChange="validDocumentFile(event)"/>';
            block_html += '</button><br><br>';
            block_html += '<span class="fileupload-preview" style="margin-left:5px; margin-top: 5px;"></span>';
            block_html += '<a href="#" class="close fileupload-exists btn btn-file-cross" data-dismiss="fileupload" style="float: none; margin-left:5px;"><i class="fa fa-times"></i></a>';
            block_html += '<div class="file_upload_error"></div>';
            block_html += '</div>';
            block_html += '</div>';            
            block_html += '</div>';
            block_html += '</div>';
            $(parent_block).find('.additional_blocks').append(block_html);
            rearrange_blocks(parent_block);
        }
    });
    
    $('body').on('click', '.btnRemoveFileBlock', function(){
        let this_obj = $(this);
        let this_block = this_obj.parents('div.file_upload_block');
        let parent_block = this_obj.parents('td.row_block');
        this_block.remove();
        rearrange_blocks(parent_block);
    });
    
    function rearrange_blocks(parent_block)
    {
        $.each($(parent_block).find('.additional_blocks .file_upload_block'), function(i, val){
            $(val).find('.user_document').attr('id', 'document' + (i + 2));
            $(val).find('.fileLable').html('{{ __("frontsistema.administracion_cuenta.fileLbl") }}' + (i + 2) + ':'); 
        });
    }
    </script>
@endsection