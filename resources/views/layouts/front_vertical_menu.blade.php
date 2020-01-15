<!DOCTYPE html>
<html lang="en">
    <head>
        @include('layouts.front_commonhead', ['title' => 'PWM - ' . __('sistema.home_page_title')])
        @yield('customcss')
        <link href="{{ asset('assets/front_css/horzontal_menu/menu.css') }}" rel="stylesheet" type="text/css" />
        <style>
            #notificationModal .modal-dialog{
                margin: 0 !important;
            }
            #notificationModal .modal-header{
                border: none !important;
                padding-bottom: 0 !important;
                padding: 25px;
                background: #8cd5dd;
                border-radius: 0;
            }
            
            #notificationModal .modal-body{
                background: #8cd5dd;
                border-radius: 0;
            }
            
            #notificationModal .modal-dialog .modal-content{
                height: 100vh;                
                padding: 0;
                width: 75%;
            }
            #notificationModal #notification_block{
                background: #8cd5dd;
                max-height: 100vh;
                overflow-y: auto;
            }
            
            #notificationModal #notification_block ul{
                list-style-type: none;
                padding-left: 0;
            }
            #notificationModal #notification_block ul li{
                padding: 25px 15px;
                border-bottom: 1px solid black;
                cursor: pointer;
                position: relative;
            }
            #notificationModal #notification_block ul li a{
                color: #313a46;
                /* color: {{isset($themeSettings->font_color_primary) ? $themeSettings->font_color_primary : '#313a46'}} !important; */
            }
            #notificationModal #notification_block ul li:hover{
                /* background: #b3e1e6; */
            }
            #notificationModal #notification_block ul li.preview::after{
                content: "\56";
                /* font-family: "Material Design Icons"; */
                /* font-style: normal; */
                /* font-weight: 400; */
                /* float: right; */
                color: #fff;
                position: absolute;
                top: 28%;
                right: 15px;
                font-size: 20px;
                font-family: "dripicons-v2" !important;
                font-style: normal !important;
                font-weight: normal !important;
                font-variant: normal !important;
                text-transform: none !important;
                speak: none;
                -webkit-font-smoothing: antialiased;
            }
            #notificationModal strong{                
                font-weight: 600;
            }
            #notificationModal .close span{
                font-size: 60px;
                font-weight: 100;
            }
            #contact_usForm .input-black{
                background: #f3f3f3;
            }
            
            /* Dynamic theme */
            /* font_color_primary starts*/
            h1, h2, h3, h4, h5, h6, p, thead, th, label, .cuenta_blue td, .widget-box-three p, 
            .form-group label, .input-black, .font_primary_color, .balance_grid tr, .about-team-member p,
            .verification_box, .balance_grid .color_green, #notificationModal #notification_block ul li a{
                 color: {{$themeSettings->font_color_primary}} !important;
            }
            .input-black, .checkbox .cr, .radio .cr{
                /* border-color:{{$themeSettings->font_color_primary}} !important; */
            }
            /* font_color_primary ends*/
            
            /* brand_color_primary starts*/
            .widget-two-black, 
            .side-menu, #sidebar-menu .metismenu .collapse.in, #side-menu a:hover, 
            #sidebar-menu > ul > li > a:hover, .cuenta_black.table-striped tbody tr:nth-of-type(odd),
            #sidebar-menu > ul > li > a:focus{
                background: {{$themeSettings->brand_color_primary}} !important;
            }
            
            .main-box.black{
                border-color: {{$themeSettings->brand_color_primary}} !important;
            }
            .main-box.black{
                background: {{$themeSettings->brand_color_primary}} !important;
            }
            /* brand_color_primary ends*/

            /* brand_color_secondary starts*/
            .right_servicios_close, #servicios_right_list, .services_open, 
            .btn-aqua-blue, .wizard > .steps > ul > li.current > a > .number, 
            .img-selected, .help_card_widget, .page-item.active .page-link, .btn-black, 
            .btn-aqua, .btn-aqua:hover, .btn-aqua:focus, .cuenta_blue.table-striped tbody tr:nth-of-type(odd),
            #notificationModal .modal-header, #notificationModal #notification_block, #notificationModal .modal-body,
            .badge-blue, .user_details_body, .checkbox-custom label input[type="checkbox"]:checked + .cr,
            .checkbox-info label input[type="checkbox"]:checked + .cr {
                background: {{$themeSettings->brand_color_seconday}} !important;
            }
            .btn-aqua-blue, .help_card_widget, .page-item.active .page-link, .btn-black, 
            .btn-aqua, .btn-aqua:hover, .btn-aqua:focus, .checkbox-custom label input[type="checkbox"]:checked + .cr,
            .checkbox-info label input[type="checkbox"]:checked + .cr,  .radio .cr {
                border-color: {{$themeSettings->brand_color_seconday}} !important;
            }
            .text-aqua-blue, .wizard > .steps > ul > li.current > a > .text, .open_contact_us_form.blue,
            .radio label input[type="radio"]:checked + .cr > .cr-icon{
                color : {{$themeSettings->brand_color_seconday}} !important;
            }
            /* brand_color_secondary ends */

            /* font_color_secondary starts*/
            #sidebar-menu > ul > li > a.active, 
            #side-menu a:hover, #sidebar-menu > ul > li > a:hover, 
            #sidebar-menu > ul > li > a:focus, 
            #sidebar-menu > ul > li > a:active, 
            #topnav .navigation-menu > li > a:hover,
            #topnav .navigation-menu > li > a:focus,
            #topnav .navigation-menu > li > a:active,
            #topnav .navigation-menu > li > a.active,
            #topnav .navigation-menu > li:hover a,
            #topnav .navigation-menu > li .submenu li span:hover,
            .page-title-box .page-title, 
            .text-custom-info, 
            .cuenta_black.table-striped a, 
            .cuenta_blue.table-striped a, 
            #sidebar-menu .nav-second-level.nav li.active > a, .contact_us_modal .page-title, .a_back,
            #contact_usForm .input-black{
                color: {{$themeSettings->font_color_secondary}} !important;
            }
            /* font_color_secondary ends*/
            
           /* Dynamic theme ends */
        </style>
    </head>
    <body>
        <div class="spiner-example d-none">
            <div class="sk-spinner sk-spinner-chasing-dots">
                <div class="sk-dot1"></div>
                <div class="sk-dot2"></div>
            </div>
        </div>
        <!-- Begin page -->
        @if($themeSettings->menu_orientation == 'horizontal')
        <div>
            <!-- header -->
            @include('layouts.front_horizontal_menu')
            <div class="wrapper" style="margin-top: 64px; margin-left: 230px;">
                <div class="content-page" style="margin-left:0">
                    <!-- Start content -->
                    <div class="content">
                        @yield('pagecontent')
                    </div>
                    <!-- End content -->
                </div>
                <footer class="footer">
                    <div class="row">
                        <div class="col-lg-6 footer_div"><a href="{{ route('privacy_policy') }}">@lang('frontsistema.home.privacy_policy')</a></div>
                        <div class="col-lg-6 footer_div"><a href="{{ route('tnc') }}">@lang('frontsistema.home.tnc')</a></div>
                        <!--<div class="col-lg-4 footer_div"><a href="#">NO QUIERO RECIBIR ESTADOS DE CUENTA</a></div>-->
                    </div>
                </footer>
            </div>
        </div>
        @else
        <div id="wrapper">
            @include('layouts.topbar')
            @include('layouts.front_sidebar')
            <div class="content-page">
                <!-- Start content -->
                <div class="content">
                    @yield('pagecontent')
                </div>
                <!-- End content -->
            </div>
            <footer class="footer">
                <div class="row">
                    <div class="col-lg-6 footer_div"><a href="{{ route('privacy_policy') }}">@lang('frontsistema.home.privacy_policy')</a></div>
                    <div class="col-lg-6 footer_div"><a href="{{ route('tnc') }}">@lang('frontsistema.home.tnc')</a></div>
                    <!--<div class="col-lg-4 footer_div"><a href="#">NO QUIERO RECIBIR ESTADOS DE CUENTA</a></div>-->
                </div>
            </footer>
        </div>
        @endif

        <!-- services section -->
        <div data-toggle="service-toggle" data-target="#servicios_right_list" class="right_servicios_close">
            <img width="20px" src="{{ asset('assets/images/arrow_left.png') }}">
            <p class="v-txt" style="color: white !important;">@lang('frontsistema.right_servives.services')</p>
        </div>

        <div id="servicios_right_list" class="">
            <div data-toggle="service-toggle" data-target="#servicios_right_list" class="services_open">
                <img width="20px" src="{{ asset('assets/images/arrow_right.png') }}" style="width: 20px !important;">
                <p class="v-txt" style="color: white !important;">@lang('frontsistema.right_servives.services')</p>
            </div>

            <img src="{{ url('assets/images/service_1.png') }}">
            <a href="{{ url('user/tramites_en_curso') }}" class="text-center">@lang('frontsistema.right_servives.process_in_progress')</a>

            <img src="{{ url('assets/images/service_2.png') }}">
            <a href="#" class="text-center">@lang('frontsistema.right_servives.document_delivery')</a>

            <img src="{{ url('assets/images/service_3.png') }}">
            <a href="#" class="text-center">@lang('frontsistema.right_servives.high_accont')</a>

            <img src="{{ url('assets/images/service_4.png') }}">
            <a href="#" class="text-center">@lang('frontsistema.right_servives.low_accont')</a>

            <img src="{{ url('assets/images/service_5.png') }}">
            <a href="{{ url('user/cambio_de_custodio') }}" class="text-center">@lang('frontsistema.right_servives.change_custody')</a>

            <img src="{{ url('assets/images/service_6.png') }}">
            <a href="javascript:void(0);" class="open_contact_us_form text-center">@lang('frontsistema.right_servives.contact')</a>
        </div>
        <!-- services section -->

        <!-- contact us form -->
        <div id="con-close-modal" class="modal fade contact_us_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title mt-0 page-title">@lang('frontsistema.contact_us.title')</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="contact_usWarning alert alert-warning d-none fade show">
                            <h4 class="text-warning mt-0">@lang('frontsistema.contact_us.validation_title')</h4>
                            <p class="mb-0">@lang('frontsistema.contact_us.validation_message')</p>
                        </div>
                        <div class="contact_usSuccess alert alert-info d-none fade show">
                            <h4 class="alert-info mt-0">@lang('frontsistema.contact_us.success_title')</h4>
                            <p class="mb-0">@lang('frontsistema.contact_us.success_message')</p>
                        </div>

                        <input type="hidden" id="_contact_us_token" value="{{ csrf_token() }}">
                        <form id="contact_usForm">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="field-1" class="control-label font-600">@lang('frontsistema.contact_us.category')</label>
                                        <select id="contacto_category" class="form-control input-black" parsley-trigger="change" required>
                                            <option></option>
                                            @foreach(config('site.contact_us_category') as $key=>$contact_us_category)
                                                <option value="{{ $key }}">{{ $contact_us_category[session('language')] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="field-2" class="control-label font-600">@lang('frontsistema.contact_us.asunto')</label>
                                        <input type="text" id="contacto_asunto" class="form-control input-black" placeholder="@lang('frontsistema.contact_us.asunto')..." parsley-trigger="change" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group no-margin">
                                        <label for="field-7" class="control-label font-600">@lang('frontsistema.contact_us.message')</label>
                                        <textarea id="contacto_message" class="form-control autogrow input-black" placeholder="@lang('frontsistema.contact_us.message').." style="overflow: hidden; word-wrap: break-word; resize: horizontal; height: 104px;" parsley-trigger="change" required></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 col-6">
                                    <div class="form-group no-margin text-center">
                                        <a class="ir_cuenta_link font_primary_color" href="{{ url('user/inicio') }}">@lang('frontsistema.contact_us.go_to_account')</a>
                                    </div>
                                </div>
                                <div class="col-md-6 col-6">
                                    <div class="form-group no-margin">
                                        <button type="submit" class="btn btn-black waves-effect waves-light">@lang('frontsistema.contact_us.send_message')</button>
                                    </div>
                                </div>
                            </div>
                            <div class="row m-t-15">
                                <div class="col-md-5 col-5">
                                    <div class="form-group no-margin m-0">
                                        <p class="text-center font-700 m-0 help_text">@lang('frontsistema.contact_us.need_help')<br>@lang('frontsistema.contact_us.call_to') :</p>
                                    </div>
                                </div>
                                <div class="col-md-7 col-7">
                                    <div class="form-group no-margin m-0">
                                        @php
                                            $broker_settings = \App\Util\HelperUtil::broker_setting();
                                        @endphp
                                        <a class="contacto_nom font_primary_color" href="tel:{{ $broker_settings->contact_number }}">
                                        {{ $broker_settings->contact_number }}</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div><!-- /.modal -->
        <!-- contact us form -->

        <!-- notification popup -->
        <div class="modal fade" id="notificationModal" tabindex="-1" role="dialog" aria-labelledby="notificationModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title" id="notificationModalLabel"><strong>@lang('frontsistema.notifications.modal_title')</strong></h1>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div id="notification_block"></div>
                    </div>
                </div>
            </div>
        </div>        
        
        <!-- END wrapper -->
        @include('layouts.commonjs')
        <script type="text/javascript">
            function show_loader(flag)
            {                    
                if(flag)
                {
                    $(".spiner-example").removeClass('d-none');
                }
                else
                {
                    $(".spiner-example").addClass('d-none');
                }
            }

            $("[data-toggle='service-toggle']").click(function() {
                var selector = $(this).data("target");
                $(selector).toggleClass('in');
            });
            

            $("body").on('click', '.open_contact_us_form', function() {
                $('.contact_usSuccess').toggleClass('d-none', true);
                $('.contact_usWarning').toggleClass('d-none', true);
                $("#con-close-modal").modal();
            });

            $(function () {
                $('#contact_usForm').parsley().on('field:validated', function () {
                    var ok = $('.parsley-error').length === 0;
                    //$('.alert-info').toggleClass('d-none', !ok);
                    $('.contact_usWarning').toggleClass('d-none', ok);
                })
                .on('form:submit', function () {
                    submit_contactoForm();
                    return false; // Don't submit form for this demo
                });
            });

            function submit_contactoForm(){

                let token = $('#_contact_us_token').val();
                let contacto_category = $('#contacto_category').val();
                let contacto_asunto = $('#contacto_asunto').val();
                let contacto_message = $('#contacto_message').val();

                let req_data = '{"contacto_asunto":{"type":"text","value":"'+contacto_asunto+'","lable_es":"Asunto","label_en":"Affair"},"contacto_message":{"type":"text","value":"'+contacto_message+'","lable_es":"Asunto","label_en":"Affair"}}';
                
                show_loader(true);

                $.ajax({
                    type: 'POST',
                    dataType: 'json',
                    data: {'_token':token,'text':req_data,'request_type_id':2 ,'category_id':contacto_category,'from':'CONTACTO'},
                    url: "{{ url('user/client_request') }}",
                    beforeSend: function() {
                        //$('#modal-espere').modal('show');
                    },
                    success: function(response) {
                        if (response.error && response.code == '500'){

                            swal({
                                title:'Aviso!!',
                                text:response.message,
                                type:'error',
                                timer: 3000,
                                confirmButtonColor:'red',
                                confirmButtonText:'OK'
                            });
                        }
                        else if(!response.error && response.code == '200'){
                            $('.contact_usSuccess').toggleClass('d-none', false);
                            $("#contact_usForm").trigger("reset");
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
            
            $('body').on('click', '.openNotificationModal', function(){
                load_notifications();                
                return false;
            });
            
            $('#notificationModal').on('show.bs.modal', function (event) {
                console.log('before');
            }).on('shown.bs.modal', function(event){
                console.log('after');
            });
            
            function load_notifications()
            {
                show_loader(true);
                $.ajax({
                    type: 'GET',
                    url: "{{ url('user/notifications') }}",                    
                    success: function(response) {
                        show_loader(false);
                        if(response.flag == 1)
                        {
                            $("#notification_block").html(response.data);
                            $('#notificationModal').modal();
                            return false;
                            let notification_html = '<ul>';
                            if(response.data.length > 0)
                            {
                                $("#notification_block")
                                $.each(response.data, function(i, val){
                                   notification_html += '<li>' + '<strong>{{ __("frontsistema.notifications.notification_lbl") }} ' + (i+1) + '</strong> ' + val.short_message + '</li>';
                                });                                                                
                            }
                            else
                            {
                                notification_html += '<li>' + '<strong class="text-center">{{ __("frontsistema.notifications.no_data") }} ' + '</strong></li>';
                            }
                            notification_html += '</ul>';
                            $("#notification_block").html(notification_html);
                            $('#notificationModal').modal();
                        }
                        else
                        {
                            return false;
                        }                        
                    },
                    error: function(response) {
                        show_loader(false);
                        //console.error(response);
                    },
                    complete: function() {
                        show_loader(false);
                    }
                });
            }
        </script>
        @yield('customjs')
    </body>
</html>