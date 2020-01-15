@extends('layouts.main')
@section('customcss')

@endsection

@section('pagecontent')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <h4 class="page-title">@lang('sistema.security_image.create_security_image')</h4>
                        <ol class="breadcrumb p-0 m-0">
                            <li>
                                <a href="javascript:void(0)">@lang('sistema.pie')</a>
                            </li>                             
                            <li>
                                <a href="{{ url('security_images') }}">
                                    @lang('sistema.security_image.security_images')
                                </a>
                            </li>
                            <li class="active">
                                @lang('sistema.security_image.create_security_image')
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

                                  <form class="form-horizontal"  method="POST" action="{{url('security_images')}}" id="frm_security_images" onsubmit="return validateFrm();" enctype="multipart/form-data">

                                      {{ csrf_field() }}

                                      <div class="form-group row" id="inputphoto">
                                          <label for="image" class="col-sm-3 form-control-label">@lang('sistema.security_image.image')<span class="text-danger">*</span></label>
                                          <div class="col-sm-9">
                                              <input type="file" class="filestyle" data-buttonname="btn-primary" data-buttontext="{{__('sistema.validate_user.photo')}}" valida="SI" cadena ="{{__('sistema.security_image.image_requiredval')}}" id="photo" name="photo" placeholder="{{__('sistema.security_image.image')}}">
                                          </div>
                                      </div>

                                      <div class="form-group row" id="inputorder">
                                          <label for="order" class="col-sm-3 form-control-label">@lang('sistema.security_image.order')<span class="text-danger">*</span></label>
                                          <div class="col-sm-9">
                                              <input type="text" class="form-control" id="order" name="order" placeholder="{{__('sistema.security_image.order')}}" valida="SI" cadena ="{{__('sistema.security_image.order_requiredval')}}" value="{{ (old('order'))? old('order'):'0' }}">
                                          </div>
                                      </div>

                                      <div class="form-group m-b-0">
                                          <div class="offset-sm-3 col-sm-9">
                                              <a href="{{url('security_images')}}" class="btn btn-danger waves-effect waves-light">@lang('sistema.btn_back')</a>
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

        function validateFrm()
        {
            var listv = 0;
            var msg = '';

            $('#frm_security_images').find(':input').each(function() {
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