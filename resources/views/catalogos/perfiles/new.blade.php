@extends('layouts.main')
@section('customcss')

@endsection

@section('pagecontent')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <h4 class="page-title">@lang('sistema.profile.create_new_profile')</h4>
                        <ol class="breadcrumb p-0 m-0">
                            <li>
                                <a href="javascript:void(0)">@lang('sistema.pie')</a>
                            </li>                            
                            <li>
                                <a href="{{ url('perfiles') }}">@lang('sistema.profile.profiles')</a>
                            </li>
                            <li class="active">
                                @lang('sistema.profile.create_new_profile')
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
                                  <form class="form-horizontal"  method="POST" action="{{url('perfiles')}}" id="frm_perfiles" onsubmit="return validateFrm();">
                                            {{ csrf_field() }}
                                                <div class="form-group row">
                                                    <label for="inputEmail3" class="col-sm-3 form-control-label">@lang('sistema.profile.profile_name')<span class="text-danger">*</span></label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" id="perfil" name="perfil" placeholder="Capture el nombre del perfil" valida="SI" cadena ="- Debe capturar el nombre del perfil" value="{{ old('perfil') }}">
                                                    </div>
                                                </div>
                                                
                                                <div class="form-group m-b-0">
                                                    <div class="offset-sm-3 col-sm-9">
                                                        <a href="{{url('perfiles')}}" class="btn btn-danger waves-effect waves-light">@lang('sistema.btn_back')</a>
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
                    title:'Aviso!!',
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
              $('#frm_perfiles').find(':input').each(function() {                          
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
                    title:'Aviso!!',
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