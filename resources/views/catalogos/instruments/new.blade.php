@extends('layouts.main')
@section('customcss')

@endsection

@section('pagecontent')
	<div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <h4 class="page-title">@lang('sistema.instrument.create_instrument')</h4>
                    <ol class="breadcrumb p-0 m-0">
                        <li>
                            <a href="javascript:void(0)">@lang('sistema.pie')</a>
                        </li>                         
                        <li>
                            <a href="{{ url('instruments') }}">
                                @lang('sistema.instrument.instruments')
                            </a>
                        </li>
                        <li class="active">
                            @lang('sistema.instrument.create_instrument')
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
                              	<form class="form-horizontal"  method="POST" action="{{url('instruments')}}" id="frm_instruments" onsubmit="return validateFrm();" enctype="multipart/form-data">
                                  	{{ csrf_field() }}
                                  	<div class="form-group row" id="inputinstrument_en">
                            	      	<label for="instrument_en" class="col-sm-3 form-control-label">@lang('sistema.instrument.instrument_en')<span class="text-danger">*</span></label>
                            	      	<div class="col-sm-9">
                                          	<input type="text" class="form-control" id="instrument_en" name="instrument_en" placeholder="{{__('sistema.instrument.instrument_en')}}" valida="SI" cadena ="{{__('sistema.instrument.req_instrument_en')}}" value="{{ (old('instrument_en'))? old('instrument_en'):'' }}">
                                          </div>
                                  	</div>
                                  	<div class="form-group row" id="inputinstrument_es">
                            	      	<label for="instrument_es" class="col-sm-3 form-control-label">@lang('sistema.instrument.instrument_es')<span class="text-danger">*</span></label>
                            	      	<div class="col-sm-9">
                                          	<input type="text" class="form-control" id="instrument_es" name="instrument_es" placeholder="{{__('sistema.instrument.instrument_es')}}" valida="SI" cadena ="{{__('sistema.instrument.req_instrument_es')}}" value="{{ (old('instrument_es'))? old('instrument_es'):'' }}">
                                          </div>
                                  	</div>
                                  	<div class="form-group m-b-0">
                                      	<div class="offset-sm-3 col-sm-9">
                                          	<a href="{{url('instruments')}}" class="btn btn-danger waves-effect waves-light">@lang('sistema.btn_back')</a>
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

            $('#frm_instruments').find(':input').each(function() {
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