<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>{{ $title }}</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta content="A project by Espacios Mexico Team" name="description" />
        <meta content="Espacios Mexico" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="{{ url('assets/images/favicon.ico') }}">
        <!-- App css -->
        <link href="{{ url('assets/front_css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ url('assets/front_css/metismenu.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ url('assets/front_css/icons.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ url('assets/front_css/style.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ url('assets/front_css/common.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ url('assets/plugins/bootstrap-select/css/bootstrap-select.min.css') }}" rel="stylesheet" />
        <script src="{{ url('assets/js/modernizr.min.js') }}"></script>
        @yield('customcss')
        <style type="text/css">
            /* Dynamic theme */
            /* font_color_primary starts*/
            h1, h2, h3, h4, h5, h6, p, thead, th, label, .cuenta_blue td, .widget-box-three p, 
            .form-group label, .input-black, .font_primary_color, .balance_grid tr, .about-team-member p,
            .verification_box, .balance_grid .color_green, #notificationModal #notification_block ul li a, a.txt_dark_font{
                 color: {{$themeSettings->font_color_primary}} !important;
            }
            .input-black, .checkbox .cr, .radio .cr{
                /* border-color:{{$themeSettings->font_color_primary}} !important; */
            }
            /* font_color_primary ends*/
            
            /* brand_color_primary starts*/
            .promocione-sub-div, .widget-two-black, 
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
            .btn-black:hover, .btn-black:focus, .btn-black:active, .btn-black.active, .btn-black.focus, .btn-black:active, .btn-black:focus, .btn-black:hover, .open > .dropdown-toggle.btn-black{
                background: {{$themeSettings->brand_color_seconday}} !important; 
                border-color: {{$themeSettings->brand_color_seconday}} !important;
                filter: brightness(92%);
            }
            .btn-aqua-blue, .help_card_widget, .page-item.active .page-link, .btn-black, 
            .btn-aqua, .btn-aqua:hover, .btn-aqua:focus, .checkbox-custom label input[type="checkbox"]:checked + .cr,
            .checkbox-info label input[type="checkbox"]:checked + .cr,  .radio .cr {
                border-color: {{$themeSettings->brand_color_seconday}} !important;
            }
            a.txt_theme_font,
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
    <body class="bg-transparent">
        <!-- Begin page -->
        <div class="accountbg">
            @if(config('starter.show_translate'))
            <ul class="nav navbar-nav navbar-right pull-right lang-drop-down">
                <li class="dropdown">
                    <a href="" class="dropdown-toggle profile waves-effect waves-light txt_dark_font" data-toggle="dropdown" aria-expanded="true">
                        <span class="profile-username">
                            @lang('frontsistema.login_lang') <span class="caret"></span>
                        </span>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="txt_dark_font" href="{{ url('language/es')}}"><img src="{{ url('assets/images/flag/flag_mex.png') }}" width="16px" /> @lang('frontsistema.login_spanish')</a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a class="txt_dark_font" href="{{ url('language/en') }}"><img src="{{ url('assets/images/flag/flag_us.png') }}" width="16px" />  @lang('frontsistema.login_english')</a>
                        </li>
                    </ul>
                </li>
            </ul>
            @endif
        </div>
        <!-- HOME -->
        <section>
            <div class="container">
                @yield('pagecontent')
            </div>
        </section>
        <script>
            var resizefunc = [];
        </script>
        <!-- jQuery  -->
        <script src="{{ url('assets/js/jquery.min.js') }}"></script>
        <script src="{{ url('assets/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ url('assets/js/metisMenu.min.js') }}"></script>
        <script src="{{ url('assets/js/waves.js') }}"></script>
        <script src="{{ url('assets/js/jquery.slimscroll.js') }}"></script>
        <script src="{{ url('assets/plugins/bootstrap-select/js/bootstrap-select.min.js') }}"></script>
        <!-- App js -->
        <script src="{{ url('assets/js/jquery.core.js') }}"></script>
        <script src="{{ url('assets/js/jquery.app.js') }}"></script>
        @yield('customjs')
    </body>
</html>