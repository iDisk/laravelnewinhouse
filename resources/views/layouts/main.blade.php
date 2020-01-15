<!DOCTYPE html>
<html lang="en">
    <head>
        @include('layouts.commonhead', ['title' => 'PWM - ' . __('sistema.home_page_title')])
        @yield('customcss')
    </head>
    <body>
        <div class="spiner-example d-none">
            <div class="sk-spinner sk-spinner-chasing-dots">
                <div class="sk-dot1"></div>
                <div class="sk-dot2"></div>
            </div>
        </div>
        <!-- Begin page -->
        <div id="wrapper">
            @include('layouts.topbar')
            @include('layouts.sidebar')
            <div class="content-page">
                <!-- Start content -->
                <div class="content">
                    @yield('pagecontent')
                </div>
                <!-- End content -->
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
            
        $("#broker_select").change(function(){
            let selected_broker_id = $(this).val();
            show_loader(true);
            
            $.ajax({
                type: 'POST',
                dataType: 'json',
                data: {broker_id: selected_broker_id},
                url: "{{ url('accounts/get_broker_accounts') }}",
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function (response) {
                    if (response.flag == 1) {
                        $("#account_select").select2('destroy').html('');
                        $("#account_select").append($(response.html)).select2();
                    } else {
                        $("#account_select").select2('destroy').html('<option value="">'+'{{ __("sistema.all") }}'+'</option>').select2();
                    }
                    reload_table();
                },
                error: function (response) {
                    //console.error(response);
                },
                complete: function () {
                    show_loader(false);
                }
            });
        });
        </script>
        @yield('customjs')
    </body>
</html>