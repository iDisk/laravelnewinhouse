@extends('layouts.main')
@section('customcss')

@endsection

@section('pagecontent')
<div class="container-fluid">
	<div class="row">
        <div class="col-12">
                <div class="page-title-box">
                    <h4 class="page-title">@lang('sistema.movimientos_desc.create_movimientos_desc')</h4>
                    <ol class="breadcrumb p-0 m-0">
                        <li>
                            <a href="javascript:void(0)">@lang('sistema.pie')</a>
                        </li>                         
                        <li>
                            <a href="{{ url('movimientos_descripcions') }}">
                                @lang('sistema.movimientos_desc.movimientos_descriptions')
                            </a>
                        </li>
                        <li class="active">
                            @lang('sistema.movimientos_desc.create_movimientos_desc')
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
                          	<form class="form-horizontal"  method="POST" action="{{url('movimientos_descripcions')}}" id="frm_movimientos_descripcions" onsubmit="return validateFrm();" enctype="multipart/form-data">
                              	
                              	{{ csrf_field() }}
                          		<div class="form-group row" id="inputdescription_en">
                        	      	<label for="description_en" class="col-sm-3 form-control-label">@lang('sistema.movimientos_desc.description_en')<span class="text-danger">*</span></label>
                        	      	<div class="col-sm-9">
                                      	<input type="text" class="form-control" id="description_en" name="description_en" placeholder="{{__('sistema.movimientos_desc.description_en')}}" valida="SI" cadena ="{{__('sistema.movimientos_desc.req_description_en')}}" value="{{ (old('description_en'))? old('description_en'):'' }}">
                                  	</div>
                              	</div>
                              	<div class="form-group row" id="inputdescription_es">
                        	      	<label for="description_es" class="col-sm-3 form-control-label">@lang('sistema.movimientos_desc.description_es')<span class="text-danger">*</span></label>
                        	      	<div class="col-sm-9">
                                      	<input type="text" class="form-control" id="description_es" name="description_es" placeholder="{{__('sistema.movimientos_desc.description_es')}}" valida="SI" cadena ="{{__('sistema.movimientos_desc.req_description_es')}}" value="{{ (old('description_es'))? old('description_es'):'' }}">
                                  	</div>
                              	</div>
                              	<div class="form-group m-b-0">
                                  	<div class="offset-sm-3 col-sm-9">
                                      	<a href="{{url('movimientos_descripcions')}}" class="btn btn-danger waves-effect waves-light">@lang('sistema.btn_back')</a>
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

            $('#frm_movimientos_descripcions').find(':input').each(function() {
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