@extends('layouts.front_vertical_menu')
@section('customcss')
<link href="{{ url('assets/plugins/bootstrap-fileupload/bootstrap-fileupload.css') }}" rel="stylesheet" />
<style type="text/css">
    b {
        font-weight: 600;
    }
    .document-type{
        font-size: 12px;
        font-weight:700;
    }
    .btn-file-cross{
        background-color: red;
        color: white;
        text-shadow: none;
    }
</style>
@endsection

@section('pagecontent')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box text-xs-center text-sm-center text-md-center">
                    <h4 class="page-title">@lang('frontsistema.envio_de_documentacion.title')</h4>
                    <div class="web_logo">
                        <img class="" src="{{ url('assets/images/logo_espacios.png')}}" alt="" height="50">
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
        
        <div class="row on_load" id="documentHeader">
            <div class="col-xl-10 col-lg-12 col-md-12 m-t-20">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-8 col-xs-12">
                        <select class="form-control input-black" style="padding:0; font-size:16px" id="documentDeliveryType" guardar="SI">
                            <option value="0">@lang('frontsistema.envio_de_documentacion.select_document_delivery_type')</option>
                            <option value="1">@lang('frontsistema.envio_de_documentacion.send_document')</option>
                            <option value="2">@lang('frontsistema.envio_de_documentacion.send_op_document')</option>
                        </select>
                    </div>
                </div>
                <!-- <h4 class="m-0 font-600">@lang('frontsistema.envio_de_documentacion.send_document') <i class="fa fa-chevron-down m-l-10"></i></h4> -->
                <p class="black m-t-20">@lang('frontsistema.envio_de_documentacion.send_document_desc')</p> 
            </div>
        </div>

        <div id="documentContent">
            <form id="document_delivery_request_form" enctype="multipart/form-data">
            <input type="hidden" id="_token" value="{{ csrf_token() }}">
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 m-t-20">
                        <div class="document-type">@lang('frontsistema.envio_de_documentacion.send_document_type')</div>
                        <div class="row">
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <select class="form-control input-black m-t-10 documentType" name="document_type" guardar="SI"></select>
                            </div>
                            <div class="col-xl-2 col-lg-2 col-md-4 col-sm-6 col-xs-6 m-t-10 add_more" style="display:none">
                                <button class="btn btn-aqua-blue waves-effect waves-light" type="button"><i class="fa fa-plus-circle m-r-10"></i> @lang('frontsistema.envio_de_documentacion.add_more')</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xl-10 col-lg-12 col-md-12 m-t-20">
                        <p>@lang('frontsistema.envio_de_documentacion.document_file_text')</p>
                        <div class="row file_upload_wrapper">
                            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-xs-12">
                                <div class="fileupload fileupload-new" data-provides="fileupload">
                                    <label class="font-14 font-700 m-r-10">Archivo 1:</label>
                                    <button type="button" class="btn btn-aqua-blue btn-file">
                                        <span class="fileupload-new"><i class="fa fa-paper-clip"></i> @lang('frontsistema.administracion_cuenta.select_file_btn')</span>
                                        <span class="fileupload-exists"><i class="fa fa-undo"></i> @lang('frontsistema.administracion_cuenta.change_btn')</span>
                                        <input type="file" id="document1" name="user_document[]" class="btn-secondary" accept=".jpg,.gif,.png,.pdf" onChange="validDocumentFile(event)" />
                                    </button>
                                    <span class="fileupload-preview" style="margin-left:5px;"></span>
                                    <a href="#" class="close fileupload-exists btn btn-file-cross" data-dismiss="fileupload" style="float: none; margin-left:5px;"><i class="fa fa-times"></i></a>
                                    <div class="file_upload_error"></div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-xs-12">
                                <div class="fileupload fileupload-new" data-provides="fileupload">
                                    <label class="font-14 font-700 m-r-10">Archivo 2:</label>
                                    <button type="button" class="btn btn-aqua-blue btn-file">
                                        <span class="fileupload-new"><i class="fa fa-paper-clip"></i> @lang('frontsistema.administracion_cuenta.select_file_btn')</span>
                                        <span class="fileupload-exists"><i class="fa fa-undo"></i> @lang('frontsistema.administracion_cuenta.change_btn')</span>
                                        <input type="file" id="document2" name="user_document[]" class="btn-secondary" accept=".jpg,.gif,.png,.pdf" onChange="validDocumentFile(event)" />
                                    </button>
                                    <span class="fileupload-preview" style="margin-left:5px;"></span>
                                    <a href="#" class="close fileupload-exists btn btn-file-cross" data-dismiss="fileupload" style="float: none; margin-left:5px;"><i class="fa fa-times"></i></a>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-xs-12">
                                <div class="fileupload fileupload-new" data-provides="fileupload">
                                    <label class="font-14 font-700 m-r-10">Archivo 3:</label>
                                    <button type="button" class="btn btn-aqua-blue btn-file">
                                        <span class="fileupload-new"><i class="fa fa-paper-clip"></i> @lang('frontsistema.administracion_cuenta.select_file_btn')</span>
                                        <span class="fileupload-exists"><i class="fa fa-undo"></i> @lang('frontsistema.administracion_cuenta.change_btn')</span>
                                        <input type="file" id="document3" name="user_document[]" class="btn-secondary documentUpload" onChange="validDocumentFile(event)"/>
                                    </button>
                                    <span class="fileupload-preview" style="margin-left:5px;"></span>
                                    <a href="#" class="close fileupload-exists btn btn-file-cross" data-dismiss="fileupload" style="float: none; margin-left:5px;"><i class="fa fa-times"></i></a>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-xs-12">
                                <div class="fileupload fileupload-new" data-provides="fileupload">
                                    <label class="font-14 font-700 m-r-10">Archivo 4:</label>
                                    <button type="button" class="btn btn-aqua-blue btn-file">
                                        <span class="fileupload-new"><i class="fa fa-paper-clip"></i> @lang('frontsistema.administracion_cuenta.select_file_btn')</span>
                                        <span class="fileupload-exists"><i class="fa fa-undo"></i> @lang('frontsistema.administracion_cuenta.change_btn')</span>
                                        <input type="file" id="document4" name="user_document[]" class="btn-secondary" accept=".jpg,.gif,.png,.pdf" onChange="validDocumentFile(event)" />
                                    </button>
                                    <span class="fileupload-preview" style="margin-left:5px;"></span>
                                    <a href="#" class="close fileupload-exists btn btn-file-cross" data-dismiss="fileupload" style="float: none; margin-left:5px;"><i class="fa fa-times"></i></a>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-xs-12">
                                <div class="fileupload fileupload-new" data-provides="fileupload">
                                    <label class="font-14 font-700 m-r-10">Archivo 5:</label>
                                    <button type="button" class="btn btn-aqua-blue btn-file">
                                        <span class="fileupload-new"><i class="fa fa-paper-clip"></i> @lang('frontsistema.administracion_cuenta.select_file_btn')</span>
                                        <span class="fileupload-exists"><i class="fa fa-undo"></i> @lang('frontsistema.administracion_cuenta.change_btn')</span>
                                        <input type="file" id="document5" name="user_document[]" class="btn-secondary" accept=".jpg,.gif,.png,.pdf" onChange="validDocumentFile(event)" />
                                    </button>
                                    <span class="fileupload-preview" style="margin-left:5px;"></span>
                                    <a href="#" class="close fileupload-exists btn btn-file-cross" data-dismiss="fileupload" style="float: none; margin-left:5px;"><i class="fa fa-times"></i></a>
                                </div>
                            </div>

                            <div class="before-add-more"></div>

                            
                        </div>
                    </div>

                </div>
                <div class="row m-t-20 m-b-10">
                    <div class="col-xl-10 text-right">
                        <hr> 
                        <a class="text-aqua-blue m-r-10 cursor-pointer line-height-35 m-r-20" href="{{ route('client_home') }}">@lang('frontsistema.btn_cancel')</a>
                        <button class="btn btn-aqua-blue waves-effect waves-light" type="submit">@lang('frontsistema.solicitar_un_financiamiento.submit_button')</button>
                    </div>
                </div>
            </form>
        </div>

        <div class="copy hide" style="display:none">
            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-xs-12 file-upload-section">
                <div class="fileupload fileupload-new" data-provides="fileupload">
                    <label class="font-14 font-700 m-r-10" id="filenumber">Archivo</label>
                    <button type="button" class="btn btn-aqua-blue btn-file">
                        <span class="fileupload-new"><i class="fa fa-paper-clip"></i> @lang('frontsistema.administracion_cuenta.select_file_btn')</span>
                        <span class="fileupload-exists"><i class="fa fa-undo"></i> @lang('frontsistema.administracion_cuenta.change_btn')</span>
                        <input type="file" id="document5" name="user_document[]" class="btn-secondary" accept=".jpg,.gif,.png,.pdf" onChange="validDocumentFile(event)" />
                    </button>
                    <span class="fileupload-preview" style="margin-left:5px;"></span>
                    <a href="#" class="close fileupload-exists btn btn-file-cross" data-dismiss="fileupload" style="float: none; margin-left:5px;"><i class="fa fa-times"></i></a>
                    <button class="btn btn-danger remove" type="button"><i class="fa fa-trash-o"></i></button>
                </div>
                
            </div>
        </div>

        <div class="row on_success m-t-50" style="display: none;">
            <div class="col-lg-12 text-center">
                <h3 class="font-600">@lang('frontsistema.envio_de_documentacion.success_msg_title')</h3>
                <p class="text-custom-info font-600 font-16 m-b-0">@lang('frontsistema.envio_de_documentacion.success_msg')</p>
                <div class="row">
                    <div class="col-12 text-center">
                        <a class="text-aqua-blue m-r-10 cursor-pointer line-height-35" href="{{ route('client_home') }}">@lang('frontsistema.envio_de_documentacion.back_to_home')</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row" id="help_section">
            <div class="col-lg-12 m-t-40">
                <div class="card help_card_widget">
                    <div class="card-body">
                        <p class="m-0">
                            @lang('frontsistema.envio_de_documentacion.help_msg1') <a href="javascript:void(0)" class="open_contact_us_form">@lang('frontsistema.click_here')</a> @lang('frontsistema.envio_de_documentacion.help_msg2') 
                        </p>
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
    <script type="text/javascript">
    $(document).ready(function($) {
        var cnt = 5;
        
        // Code using $ as usual goes here.
        $('#documentContent').hide();
        $('#documentDeliveryType').on('change', function() {
            cnt = 5;
            $(".file_upload_wrapper .file-upload-section").remove();
            $('.add_more').hide();
            $('#documentContent').hide();
            var documentTypeArr = [];
            var dt = $('.documentType');
            dt.html('');
            if(this.value == 1){
                $('#documentContent').show();
                // documentTypeArr = ['Identificación (Documento de Identidad, Pasaporte o equivalente)','Segunda Identificación','Comprobante de Domicilio','Comprobante de Ingresos','Comprobante de situación fiscal','Otro documento'];
                documentTypeArr = ["@lang('frontsistema.envio_de_documentacion.document_type_list.id_proof')","@lang('frontsistema.envio_de_documentacion.document_type_list.second_id')","@lang('frontsistema.envio_de_documentacion.document_type_list.address_proof')","@lang('frontsistema.envio_de_documentacion.document_type_list.income_proof')","@lang('frontsistema.envio_de_documentacion.document_type_list.tax_proof')","@lang('frontsistema.envio_de_documentacion.document_type_list.other_document')"];
            }
            else if(this.value == 2){
                $('#documentContent').show();
                // documentTypeArr = ['Contratos / Acuerdos','Solicitudes de Crédito','Contratación de productos','Solicitudes de retiro','Comprobantes de depósito','Otro documento'];
                documentTypeArr = ["@lang('frontsistema.envio_de_documentacion.document_type_list.contract_agreement')","@lang('frontsistema.envio_de_documentacion.document_type_list.credit_request')","@lang('frontsistema.envio_de_documentacion.document_type_list.product_hiring')","@lang('frontsistema.envio_de_documentacion.document_type_list.withdrawal_request')","@lang('frontsistema.envio_de_documentacion.document_type_list.deposit_voucher')","@lang('frontsistema.envio_de_documentacion.document_type_list.other_document')"];
            }
           
            for (i = 0; i < documentTypeArr.length; ++i) {
                dt.append('<option value="'+documentTypeArr[i]+'">'+documentTypeArr[i]+'</option>');
            }
        });

        
        $(".add_more").click(function(){ 
            if(cnt < 20){
                cnt++;       
                $(".file_upload_wrapper").find(".remove").hide();
                $(".copy").find("#filenumber").html('Archivo '+cnt.toString());    
                var html = $(".copy").html();  
                $(".before-add-more").before($(html));
            }
            else{
                swal("@lang('frontsistema.users_alert')", "@lang('frontsistema.envio_de_documentacion.file_upload_max_err')", 'error');
            }
        });

        $("body").on("click",".remove",function(){ 
            $(this).parents(".file-upload-section").remove();
            $(".file_upload_wrapper .file-upload-section:last").find(".remove").show();
            cnt--;
        });

        $('.documentType').on('change', function() {
            $('.add_more').hide();
            if($(this).val().indexOf('Otro documento') > -1  || $(this).val().indexOf('Other document') > -1 ){
                $('.add_more').show();
            }
            else{
                cnt = 5;
                $(".file_upload_wrapper .file-upload-section").remove();
            }
        })

        $('#document_delivery_request_form').submit( function(e){     
            e.preventDefault();
            var $form = $(this);
            if(!validDocumentFiles($form)){
                swal("@lang('frontsistema.users_alert')", "@lang('frontsistema.envio_de_documentacion.file_upload_err')", 'error');
                return;
            } 
            
            show_loader(true);
            let token = $('#_token').val();

            let req_data = '{';

            $('#document_delivery_request_form').find(':input').each(function() 
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

            var form_data = new FormData();

            $form.find("input[type=file]").each(function(index, field){
                if(field != undefined && field.files.length>0){
                    form_data.append('documents[]',field.files[0]);
                }
            });
            // return;
            form_data.append('text', req_data);
            form_data.append('request_type_id', 27);
            form_data.append('verify', 0);
            form_data.append('from', 'Envio de Documentacion');
            form_data.append('_token', token);
            
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
                        // alert("success");
                        $("#document_delivery_request_form").hide();
                        $("#document_delivery_request_form").trigger("reset");
                        $('#documentHeader').hide();
                        $('#help_section').hide();
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

           
        });
        
    });
    function validDocumentFiles($form){
        var docFlag = false;
        $form.find("input[type=file]").each(function(index, field){
            if(field != undefined && field.files.length>0){
                docFlag = true;
            }
        });
        return docFlag;
    }
    function validDocumentFile(event){  
            console.log(event);
            if(event.target.files.length == 0){
                return;
            }
            var fileItem = event.target.files[0];
            if(fileItem.type=="image/jpeg" || fileItem.type=="image/jpg" || fileItem.type=="image/png" || fileItem.type=="image/gif" || fileItem.type == "application/pdf"){
                if (fileItem.size > 5242880) { 
                    // $('#document1').closest('[type="button"]').find(".file_upload_error").html('File should be less than 5 mb');
                    // $('.file_upload_error').text('File should be less than 5 mb');
                    // alert("Try to upload file less than 5MB!"); 
                    event.target.files.length = 0;
                    event.target.value = '';
                    swal("@lang('frontsistema.users_alert')", "@lang('frontsistema.envio_de_documentacion.file_upload_size_err')", 'error');
                } 
            }
            else{
                event.target.files.length = 0;
                event.target.value = '';
                swal("@lang('frontsistema.users_alert')", "@lang('frontsistema.envio_de_documentacion.file_upload_type_err')", 'error');
            }
        }
    </script>
    <script src="{{ url('assets/plugins/bootstrap-fileupload/bootstrap-fileupload.js') }}"></script>
@endsection