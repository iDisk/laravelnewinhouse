@extends('layouts.front_vertical_menu')
@section('customcss')
<style type="text/css">
    
</style>
@endsection

@section('pagecontent')
    <div class="container-fluid">
        <input type="hidden" id="_token" value="{{ csrf_token() }}">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <h4 class="page-title">@lang('frontsistema.cambio_de_custodio.title')</h4>
                    <div class="web_logo">
                        <img class="" src="{{ url('assets/images/logo_espacios.png')}}" alt="" height="50">
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
        <!-- end row -->
        <div class="row on_load">
            <div class="col-xl-9 col-md-10">
                <h5 class="font-14">@lang('frontsistema.cambio_de_custodio.top_msg')</h5>
            </div>
        </div>
        <!-- end row -->

        <div class="row m-t-40 m-b-50 on_load">
            <div class="col-lg-3 text-center">
                <p class="m-0 font-600">@lang('frontsistema.cambio_de_custodio.your_account')</p>
                <h3 class="text-custom-info font-600 m-t-0">{{ $account->account_number  }}</h3>
            </div>
            <div class="col-lg-6">
                <button id="btn_changeAccount" class="btn w-lg btn-aqua-blue waves-effect waves-light" type="button">@lang('frontsistema.cambio_de_custodio.account_change_btn')</button>
            </div>
            <!-- end col -->
        </div>
        <!-- end row -->
        <div class="row on_load">
            <div class="col-lg-12">
                <div class="card help_card_widget">
                    <div class="card-body">
                        <p class="m-0">
                            @lang('frontsistema.cambio_de_custodio.help_msg1') <a href="#">@lang('frontsistema.click_here')</a> @lang('frontsistema.cambio_de_custodio.help_msg2') 
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row on_success m-t-50" style="display: none;">
            <div class="col-lg-12 text-center">
                <h3 class="font-600">@lang('frontsistema.cambio_de_custodio.success_msg_title')</h3>
                <p class="text-custom-info font-600 font-16">@lang('frontsistema.cambio_de_custodio.success_msg')</p>
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
        $('#btn_changeAccount').click(function() {
            swal({
                title: "{{ __('frontsistema.confirm') }}",
                text: "{{ __('frontsistema.cambio_de_custodio.confirmation_msg') }}",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: '#8cd5dd',
                confirmButtonText: "{{ __('frontsistema.btn_yes') }}",
                cancelButtonText: "No"
            })
            .then(function () {
                submit_request();
                }, function (dismiss) {
                //Code for cancel
                }
            );
        });

        function submit_request(){

            var token = $('#_token').val();

            var user_id = "{{ $user_id }}";

            var req_data = '{"cambio_de_custodio":{"type":"text","value":""}}';
            
            show_loader(true);

            $.ajax({
                type: 'POST',
                dataType: 'json',
                data: {'_token':token,'text':req_data,'request_type_id':1,'verify':0,'from':'CAMBIO DE CUSTODIO','user_id':user_id},
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
                    else if(!response.error && response.code == '200'){
                        $('.on_load').hide();
                        $('.on_success').show();
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
    </script>
@endsection