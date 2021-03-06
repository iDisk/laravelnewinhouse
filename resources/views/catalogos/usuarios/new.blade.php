@extends('layouts.main')
@section('customcss')

@endsection

@section('pagecontent')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <h4 class="page-title">@lang('sistema.users_new_title')</h4>
                        <ol class="breadcrumb p-0 m-0">
                            <li>
                                <a href="javascript:void(0)">@lang('sistema.pie')</a>
                            </li>
                            <li>
                                <a href="{{ url('usuarios') }}">@lang('sistema.users_title')</a>
                            </li>
                            <li class="active">
                                @lang('sistema.users_new_title')
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
                          <p></p>
                          <div class="row">
                              <div class="col-lg-6">
                                  @if (count($errors) > 0)
                                      <div class="alert alert-warning">
                                          <ul>
                                          @foreach ($errors->all() as $error)
                                              <li>{{ $error }}</li>
                                          @endforeach
                                          </ul>
                                      </div>
                                  @endif
                                  <form class="form-horizontal"  method="POST" action="{{url('usuarios')}}" id="frm_usuarios" onsubmit="return validateFrm();" enctype="multipart/form-data">
                                      {{ csrf_field() }}

                                      <div class="form-group row" id="inputname">
                                          <label for="inputname" class="col-sm-3 form-control-label">@lang('sistema.frm_user.field_name')<span class="text-danger">*</span></label>
                                          <div class="col-sm-9">
                                              <input type="text" class="form-control" id="name" name="name" placeholder="{{__('sistema.placeholder_user.name')}}" valida="SI" cadena ="{{__('sistema.validate_user.name')}}" value="{{ old('name') }}">
                                          </div>
                                      </div>

                                      <div class="form-group row" id="inputemail">
                                          <label for="inputemail" class="col-sm-3 form-control-label">@lang('sistema.frm_user.field_email')<span class="text-danger">*</span></label>
                                          <div class="col-sm-9">
                                              <input type="text" class="form-control" id="email" name="email" placeholder="{{__('sistema.placeholder_user.email')}}" valida="SI" cadena ="{{__('sistema.validate_user.email')}}" value="{{ old('email') }}">
                                          </div>
                                      </div>

                                      <div class="form-group row" id="inputpassword">
                                          <label for="inputpassword" class="col-sm-3 form-control-label">@lang('sistema.frm_user.field_pass1')<span class="text-danger">*</span></label>
                                          <div class="col-sm-9">
                                              <input type="password" class="form-control" id="password" name="password" placeholder="{{__('sistema.placeholder_user.pass1')}}" valida="SI" cadena ="{{__('sistema.validate_user.pass1')}}" value="{{ old('password') }}">
                                          </div>
                                      </div>

                                      <div class="form-group row" id="inputpassword-confirm">
                                          <label for="inputpassword-confirm" class="col-sm-3 form-control-label">@lang('sistema.frm_user.field_pass2')<span class="text-danger">*</span></label>
                                          <div class="col-sm-9">
                                              <input type="password" class="form-control" id="password-confirm" name="password-confirm" placeholder="{{__('sistema.placeholder_user.pass2')}}" valida="SI" cadena ="{{__('sistema.validate_user.pass2')}}" value="{{ old('password-confirm') }}">
                                          </div>
                                      </div>

                                      <div class="form-group row" id="inputperfil_id">
                                          <label for="inputperfil_id" class="col-sm-3 form-control-label">@lang('sistema.frm_user.field_profile')<span class="text-danger">*</span></label>
                                          <div class="col-sm-9">
                                              <select id="perfil_id" class="form-control" name="perfil_id" valida="SI" cadena="{{__('sistema.validate_user.profile')}}">
                                                <option value="null">@lang('sistema.btn_select')</option>
                                                @foreach($perfiles as $key => $value)
                                                  <option value="{{$value->id}}">{{$value->perfil}}</option>
                                                @endforeach
                                              </select>
                                          </div>
                                      </div>

                                      <div class="form-group row">
                                          <label for="inputphoto" class="col-sm-3 form-control-label">@lang('sistema.frm_user.field_photo')</label>
                                          <div class="col-sm-9">
                                              <input type="file" class="filestyle" data-buttonname="btn-primary" data-buttontext="{{__('sistema.validate_user.photo')}}" id="photo" name="photo" placeholder="{{__('sistema.placeholder_user.photo')}}">
                                          </div>
                                      </div>

                                      <div class="form-group m-b-0">
                                          <div class="offset-sm-3 col-sm-9">
                                              <a href="{{url('usuarios')}}" class="btn btn-danger waves-effect waves-light">@lang('sistema.btn_back')</a>
                                              <button type="submit" class="btn btn-info waves-effect waves-light">@lang('sistema.btn_save')</button>
                                          </div>
                                      </div>
                                  </form>
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

        function IsEmail(email) {
            var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
            return regex.test(email);
        }

        function checkPassword(str)
        {
            var re = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}$/;
            return re.test(str);
        }
        function validateFrm()
        {
            var listv = 0;
            var msg = '';

            $('#frm_usuarios').find(':input').each(function() {
                if($(this).attr("valida")=="SI" && ($(this).val()==""||$(this).val()=="null"))
                {
                    listv=1;
                    
                    $('#input'+this.id).addClass('has-error');
                    msg+=$(this).attr('cadena')+'\n';
                    
                    //$(this).val($(this).val().toUpperCase());
                }else
                {
                      $('#input'+this.id).removeClass('has-error');
                      if($(this).attr("valida")=="SI")
                      {
                          //$(this).val($(this).val().toUpperCase());
                      }
                }
            });

            if($('#password').val()!=$('#password-confirm').val())
            {
                msg+='@lang('sistema.validate_user.error.pass_notmatch') \n';
                listv=1;
            }else{
                if($('#password').val() != ''){
                    if(!checkPassword($('#password').val()))
                    {
                      msg+='@lang('sistema.validate_user.error.pass_weak') \n';
                      listv=1;
                    }
                }
            }

            if($('#email').val() != ''){
                if(!IsEmail($('#email').val()))
                {
                    msg+='@lang('sistema.validate_user.error.email') \n';
                    listv=1;
                }
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
                return false;
            }else{
                return true;
            }
        }
    </script>
@endsection