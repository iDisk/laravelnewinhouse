@extends('layouts.front_client', ['title' => __('sistema.login_title')])
@section('customcss')
<!--Form Wizard-->
<link rel="stylesheet" type="text/css" href="{{ url('assets/plugins/jquery.steps/css/jquery.steps.css') }}" />
@endsection
@section('pagecontent')
<style type="text/css">
    .wizard > .steps{
        display: none;
    }
    .wizard > .content{
        background-color: #fff;
        min-height:100%;
        margin: 0px;
        padding: 0px !important;
    }
    .wizard > .content > .body{
        position: relative;
        left: 15px !important;
    }
    .wizard > .content > .body .img-btn{
        padding: 4px 4px;
    }
    .wizard > .actions{
        display: none;
    }
    .check
    {
        opacity:0.5;
        color:#996;
    }
    .has-error .form-control{
        border-color: #f7531f !important;
    }
    .header-title{
        line-height: 21px;
    }
</style>

    <div class="row">
    <div class="col-sm-12">
        <div class="wrapper-page">
            <div class="m-t-40 account-pages">
                <input type="hidden" id="_token" value="{{ csrf_token() }}">
                <form id="basic-form" action="#">                    
                    <div>
                        <h3></h3>
                        <section>

                            <h4 class="m-t-0 header-title m-b-30 text-center"><b>@lang('sistema.client_register.welcome_msg')</b></h4>
                            
                            <div class="form-group row">
                                <label class="col-lg-3 control-label " for="user_name">@lang('sistema.client_register.user') *</label>
                                <div class="col-lg-9">
                                    <input class="form-control" id="user_name" name="user_name" type="text">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-3 control-label " for="password">@lang('sistema.client_register.password') *</label>
                                <div class="col-lg-9">
                                    <input id="password" name="password" type="password" class="required form-control">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-lg-12">
                                    <button id="section1_nxt_btn" type="button" class="btn btn-info waves-effect waves-light pull-right">@lang('sistema.btn_next')</button>
                                </div>
                            </div>
                        </section>
                        <h3></h3>
                        <section>
                            <h4 class="m-t-0 header-title m-b-30 text-center verify_code_title">
                                <b>@lang('sistema.client_register.verification_codetitle')</b>
                            </h4>

                            <div class="form-group row">

                            </div>
                            <div class="form-group row">
                                <label class="col-lg-3 control-label" for="code">@lang('sistema.client_register.code') *</label>
                                <div class="col-lg-9">
                                    <input id="code" name="code" type="text" class="required form-control">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-lg-12">
                                    <button id="section2_nxt_btn" type="button" class="btn btn-info waves-effect waves-light pull-right">@lang('sistema.btn_next')</button>
                                </div>
                            </div>
                        </section>
                        
                        <h3></h3>
                        <section>
                            <h4 class="m-t-0 header-title m-b-30 text-center"><b>@lang('sistema.client_register.user_detailtitle')</b></h4>
                            
                            <div class="form-group row" id="inputuser_name1">
                                <label class="col-lg-3 form-control-label " for="user_name1">@lang('sistema.client_register.user')</label>
                                <div class="col-lg-9">
                                    <input class="form-control" id="user_name1" name="user_name1" type="text" value="{{ $user->user_login }}">
                                </div>
                            </div>
                            <div class="form-group row" id="inputpassword1">
                                <label class="col-lg-3 form-control-label " for="password1">@lang('sistema.client_register.password') *</label>
                                <div class="col-lg-9">
                                    <input id="password1" name="password1" type="password" class="required form-control">
                                </div>
                            </div>
                            <div class="form-group row" id="inputpassword2">
                                <label class="col-lg-3 form-control-label " for="inputpassword2">@lang('sistema.confirm_password') *</label>
                                <div class="col-lg-9">
                                    <input id="password2" name="password2" type="password" class="required form-control">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-lg-12">
                                    <button id="section3_nxt_btn" type="button" class="btn btn-info waves-effect waves-light pull-right">@lang('sistema.btn_next')</button>
                                </div>
                            </div>
                        </section>

                        <!-- Image-->
                        <h3></h3>
                        <section>
                            <h4 class="m-t-0 header-title m-b-30 text-center"><b>@lang('sistema.client_register.image_title')</b></h4>
                            <div class="form-group row image_section">
                                @foreach($security_images as $security_image)
                                <div class="col-md-4">
                                    <label class="btn btn-primary img-btn">
                                        <img src="{{ $security_image->image }}" class="img-thumbnail img-check">
                                        <input type="checkbox" name="chk[]" id="item{{ $security_image->id }}" value="{{ $security_image->id }}" class="invisible image-checkbox" autocomplete="off">
                                    </label>
                                </div>
                                @endforeach
                            </div>
                            <div class="form-group row" id="inputimage_phrase">
                                <div class="col-lg-12">
                                    <input class="form-control" type="text" id="image_phrase" name="image_phrase" value=""
                                    placeholder="@lang('sistema.client_register.image_phrase')">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-lg-12">
                                    <button id="section4_nxt_btn" type="button" class="btn btn-info waves-effect waves-light pull-right">@lang('sistema.btn_next')</button>
                                </div>
                            </div>
                        </section>

                        <h3></h3>
                        <section>
                        <div id="section_5">
                            <h4 class="m-t-0 header-title m-b-30 text-center"><b>@lang('sistema.client_register.question_title')</b></h4>

                            <div class="form-group row" id="inputquestion1">
                                <label class="col-lg-3 form-control-label" for="question1">@lang('sistema.client_register.question') 1 *</label>
                                <div class="col-lg-9">
                                    <select class="form-control" id="question1" valida="SI" cadena ="{{__('sistema.client_register.question_valid')}} 1">
                                        @foreach($security_questions1 as $key=>$value)
                                            <option value="{{ $key }}">{{ $value }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row" id="inputanswer1">
                                <label class="col-lg-3 form-control-label " for="answer1">@lang('sistema.client_register.answer') 1 *</label>
                                <div class="col-lg-9">
                                    <input id="answer1" name="answer1" type="text" valida="SI" cadena ="{{__('sistema.client_register.answer_valid')}} 1" class="form-control">
                                </div>
                            </div>
                            <div class="form-group row" id="inputquestion2">
                                <label class="col-lg-3 form-control-label" for="question2">@lang('sistema.client_register.question') 2 *</label>
                                <div class="col-lg-9">
                                    <select class="form-control" id="question2" valida="SI" cadena ="{{__('sistema.client_register.question_valid')}} 2">
                                        @foreach($security_questions2 as $key=>$value)
                                            <option value="{{ $key }}">{{ $value }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row" id="inputanswer2">
                                <label class="col-lg-3 form-control-label" for="answer2">@lang('sistema.client_register.answer') 2 *</label>
                                <div class="col-lg-9">
                                    <input id="answer2" name="answer2" type="text" class="form-control" valida="SI" cadena ="{{__('sistema.client_register.answer_valid')}} 2">
                                </div>
                            </div>

                            <div class="form-group row" id="inputquestion3">
                                <label class="col-lg-3 from-control-label" for="question3">@lang('sistema.client_register.question') 3 *</label>
                                <div class="col-lg-9">
                                    <select class="form-control" id="question3" valida="SI" cadena ="{{__('sistema.client_register.question_valid')}} 3">
                                        @foreach($security_questions3 as $key=>$value)
                                            <option value="{{ $key }}">{{ $value }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row" id="inputanswer3">
                                <label class="col-lg-3 form-control-label" for="answer3">@lang('sistema.client_register.answer') 3 *</label>
                                <div class="col-lg-9">
                                    <input id="answer3" name="answer3" type="text" class="form-control" valida="SI" cadena ="{{__('sistema.client_register.answer_valid')}} 3">
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-lg-12">
                                    <button id="section5_nxt_btn" type="button" class="btn btn-info waves-effect waves-light pull-right">@lang('sistema.btn_next')</button>
                                </div>
                            </div>
                        </div>
                        </section>

                        <h3></h3>
                        <section>
                            <h4 class="m-t-0 header-title m-b-30 text-center"><b>@lang('sistema.client_register.validate_title')</b></h4>
                            <div class="form-group row">
                                <div class="col-lg-12">
                                    <p>@lang('sistema.client_register.validate_msg')</p>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-lg-12">
                                    <a href="{{ route('client_login')}}" class="btn btn-info waves-effect waves-light pull-right">@lang('sistema.client_register.login')</a>
                                </div>
                            </div>
                        </section>
                    </div>
                    <input type="hidden" value="{{ $user_id }}" name="user_id" id="user_id">
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@section('customjs')
<!--Form Wizard-->
<script src="{{ url('assets/plugins/jquery.steps/js/jquery.steps.min.js') }}"></script>
<script src="{{ url('assets/plugins/jquery-validation/js/jquery.validate.min.js') }}"></script>
<!--wizard initialization-->
<script src="{{ url('assets/pages/jquery.wizard-init.js') }}" type="text/javascript"></script>

<script type="text/javascript">
    $("#section1_nxt_btn").click(function(){

        var token = $('#_token').val();
        user_name = $('#user_name').val();
        password = $('#password').val();
        user_id = $('#user_id').val();
        show_loader(true);
        $.ajax({
            type: 'POST',
            dataTyoe: 'json',
            data: {'_token':token, user_name:user_name, password:password},
            url: "{{ url('client_registration') }}"+"/"+user_id,
            beforeSend: function() {
                //$('#modal-espere').modal('show');
            },
            success: function(response) {
                if (response.error && response.code == '500') {
                    swal({
                    title:'@lang("sistema.users_alert")',
                    text:response.message,
                    type:'error',
                    timer: 3000,
                    confirmButtonColor:'red',
                    confirmButtonText:'OK'
                  });
                }
                else if(!response.error && response.code == '200'){
                    $($('.actions')).find('a[href="#next"]').click();
                }
            },
            error: function(response) {
                console.error(response);
            },
            complete: function() {
                show_loader(false);
            }
        });
    });

    //verify code
    $("#section2_nxt_btn").click(function(){

        var token = $('#_token').val();
        code = $('#code').val();
        user_id = $('#user_id').val();
        show_loader(true);
        $.ajax({
            type: 'POST',
            dataTyoe: 'json',
            data: {'_token':token, code:code},
            url: "{{ url('ajax_check_otp') }}"+"/"+user_id,
            beforeSend: function() {
                //$('#modal-espere').modal('show');
            },
            success: function(response) {
                if (response.error && response.code == '500') {
                    /*swal({
                        title:'@lang('sistema.users_alert')',
                        text:response.message,
                        type:'error',
                        timer: 3000,
                        confirmButtonColor:'red',
                        confirmButtonText:'OK'
                    });*/
                    $('.verify_code_title').html('<b>@lang("sistema.client_register.incorrect_code_msg")</b>');
                }
                else if(!response.error && response.code == '200'){
                    $($('.actions')).find('a[href="#next"]').click();
                }
            },
            error: function(response) {
                console.error(response);
            },
            complete: function() {
                show_loader(false);
            }
        });
    });
    //section3_nxt_btn
    $("#section3_nxt_btn").click(function(){
        var token = $('#_token').val();
        user_name = $('#user_name1').val();
        user_id = $('#user_id').val();

        var listv = 0;
        var msg = '';
        if($('#user_name1').val() == ''){
            listv = 1;
            $('#inputuser_name1').addClass('has-error');
            msg +='@lang("sistema.client_register.user_name_valid")'+'\n';
        }else{
            $('#inputuser_name1').removeClass('has-error');
        }

        if($('#password1').val() == ''){
            listv = 1;
            $('#inputpassword1').addClass('has-error');
            msg +='@lang("sistema.client_register.passowrd_valid")'+'\n';
        }else{
            $('#inputpassword1').removeClass('has-error');
        }
        
        if($('#password2').val() == ''){
            listv = 1;
            $('#inputpassword2').addClass('has-error');
            msg +='@lang("sistema.confirm_password_required_error")'+'\n';
        }else{
            if($('#password2').val() != $('#password1').val())
            {
                listv = 1;
                $('#inputpassword2').addClass('has-error');
                msg +='@lang("sistema.new_password_confirm_error")'+'\n';
            }
            $('#inputpassword2').removeClass('has-error');
        }

        if (listv == 1) {

            swal({
                title:'@lang("sistema.users_alert")',
                text: msg,
                type:'error',
                timer: 3000,
                confirmButtonColor:'red',
                confirmButtonText:'OK'
            });

        }else{
            show_loader(true);
            $.ajax({
                type: 'POST',
                dataTyoe: 'json',
                data: {'_token':token, user_name:user_name},
                url: "{{ url('ajax_check_user') }}"+"/"+user_id,
                beforeSend: function() {
                    //$('#modal-espere').modal('show');
                },
                success: function(response) {
                    if (response.error && response.code == '500') {

                        swal({
                            title:'@lang("sistema.users_alert")',
                            text:response.message,
                            type:'error',
                            timer: 3000,
                            confirmButtonColor:'red',
                            confirmButtonText:'OK'
                        });
                    }
                    else if(!response.error && response.code == '200'){
                        $($('.actions')).find('a[href="#next"]').click();
                    }
                },
                error: function(response) {
                    console.error(response);
                },
                complete: function() {
                    show_loader(false);
                }
            });
        }
    });

    //section4 next button
    $("#section4_nxt_btn").click(function(){
        
        var listv = 0;
        var msg = '';

        if (!$("input[name='chk[]']:checked").length > 0) {
            listv = 1;
            msg +='@lang("sistema.client_register.select_imgmsg")'+'\n';   
        }
        if($('#image_phrase').val() == ''){
            listv = 1;
            $('#inputimage_phrase').addClass('has-error');
            msg +='@lang("sistema.client_register.image_phrase")'+'\n';
        }else{
            $('#inputimage_phrase').removeClass('has-error');
        }

        if (listv == 1) {

            swal({
                title:'@lang("sistema.users_alert")',
                text: msg,
                type:'error',
                timer: 3000,
                confirmButtonColor:'red',
                confirmButtonText:'OK'
            });
        }else{
            $($('.actions')).find('a[href="#next"]').click();
        }
    });
    //select 5 next button
    $("#section5_nxt_btn").click(function(){

        var listv = 0;
        var msg = '';
        $('#section_5').find(':input').each(function() {
            if($(this).attr("valida")=="SI" && ($(this).val()==""||$(this).val()=="null"))
            {
                listv=1;
                $('#input'+this.id).addClass('has-error');
                msg+=$(this).attr('cadena')+'\n';
            }else
            {
                  $('#input'+this.id).removeClass('has-error');
            }
        });

        if($('#question1').val() == ''|| $('#question1').val() == null){
            listv=1;
            $('#inputquestion1').addClass('has-error');
            msg+=$('#question1').attr('cadena')+'\n';
        }else{
            $('#inputquestion1').removeClass('has-error');
        }

        if($('#question2').val() == '' || $('#question2').val() == null){
            listv=1;
            $('#inputquestion2').addClass('has-error');
            msg+=$('#question2').attr('cadena')+'\n';
        }else{
            $('#inputquestion2').removeClass('has-error');
        }

        if($('#question3').val() == '' || $('#question3').val() == null){
            listv=1;
            $('#inputquestion3').addClass('has-error');
            msg+=$('#question3').attr('cadena')+'\n';
        }else{
            $('#inputquestion3').removeClass('has-error');
        }

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
        }else{
            var token = $('#_token').val();
            var user_name = $('#user_name1').val();
            var password = $('#password1').val();
            var qusetion1 = $('#question1').val();
            var qusetion2 = $('#question2').val();
            var qusetion3 = $('#question3').val();
            var answer1 = $('#answer1').val();
            var answer2 = $('#answer2').val();
            var answer3 = $('#answer3').val();
            var image = '';
            $('input[name="chk[]"]:checked').each(function() {
               image = this.value;
            });
            var image_phrase = $('#image_phrase').val();
            show_loader(true);
            $.ajax({
                type: 'POST',
                dataTyoe: 'json',
                data: {'_token':token, user_name:user_name,password:password,qusetion1:qusetion1,qusetion2:qusetion2,qusetion3:qusetion3,answer1:answer1,answer2:answer2,answer3:answer3,image:image,image_phrase:image_phrase},
                url: "{{ url('ajax_save_user_security') }}"+"/"+user_id,
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
                        $($('.actions')).find('a[href="#next"]').click();
                    }
                },
                error: function(response) {
                    console.error(response);
                },
                complete: function() {
                    show_loader(false);
                }
            });

        }
    });
     

    $(document).ready(function(e){

        $(".img-check").click(function(){
            $('.image_section').find('.img-check').removeClass('check');
            var $tblChkBox = $(".image_section input:checkbox");
            $($tblChkBox).prop('checked', false);
            $(this).toggleClass("check");
        });
    });
</script>
@endsection