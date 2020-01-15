@extends('layouts.main')
@section('customcss')

@endsection

@section('pagecontent')
	<div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <h4 class="page-title">@lang('sistema.item.edit_item')</h4>
                    <ol class="breadcrumb p-0 m-0">
                        <li>
                            <a href="javascript:void(0)">@lang('sistema.pie')</a>
                        </li>                         
                        <li>
                            <a href="{{ url('items') }}">
                                @lang('sistema.item.items')
                            </a>
                        </li>
                        <li class="active">
                            @lang('sistema.item.edit_item')
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
		                  		<form class="form-horizontal"  method="POST" action="{{url('items/'.$item->id)}}" id="frm_items" onsubmit="return validateFrm();">

                                    {{ csrf_field() }}
                                    {{ method_field('PUT') }}
                                    
                                    <div class="form-group row" id="inputitem_en">
                                        <label for="item_en" class="col-sm-3 form-control-label">@lang('sistema.item.item_en')<span class="text-danger">*</span></label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="item_en" name="item_en" placeholder="{{__('sistema.item.item_en')}}" valida="SI" cadena ="{{__('sistema.item.req_item_en')}}" value="{{ $item->item_en }}">
                                          </div>
                                    </div>
                                    <div class="form-group row" id="inputitem_es">
                                        <label for="item_es" class="col-sm-3 form-control-label">@lang('sistema.item.item_es')<span class="text-danger">*</span></label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="item_es" name="item_es" placeholder="{{__('sistema.item.item_es')}}" valida="SI" cadena ="{{__('sistema.item.req_item_es')}}" value="{{ $item->item_es }}">
                                          </div>
                                    </div>
                                    <div class="form-group m-b-0">
                                        <div class="offset-sm-3 col-sm-9">
                                            <a href="{{url('items')}}" class="btn btn-danger waves-effect waves-light">@lang('sistema.btn_back')</a>
                                            <button type="submit" class="btn btn-info waves-effect waves-light">@lang('sistema.btn_update')</button>
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

        function validateFrm(){
            var listv = 0;
            var msg = '';

            $('#frm_items').find(':input').each(function() {                        
            
	            if($(this).attr("valida")=="SI" && ($(this).val()==""||$(this).val()=="")){

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