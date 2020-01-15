@extends('layouts.main')
@section('customcss')

@endsection

@section('pagecontent')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <h4 class="page-title">@lang('sistema.security_question.create_security_question')</h4>
                        <ol class="breadcrumb p-0 m-0">
                            <li>
                                <a href="javascript:void(0)">@lang('sistema.pie')</a>
                            </li>                             
                            <li>
                                <a href="{{ url('security_questions') }}">
                                    @lang('sistema.security_question.security_questions')
                                </a>
                            </li>
                            <li class="active">
                                @lang('sistema.security_question.create_security_question')
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

                                  <form class="form-horizontal"  method="POST" action="{{url('security_questions')}}" id="frm_security_questions" onsubmit="return validateFrm();">
                                      {{ csrf_field() }}

                                      <div class="form-group row" id="inputquestion_en">
                                          <label for="question_en" class="col-sm-3 form-control-label">@lang('sistema.security_question.questionen')<span class="text-danger">*</span></label>
                                          <div class="col-sm-9">
                                              <input type="text" class="form-control" id="question_en" name="question_en" placeholder="{{__('sistema.security_question.questionen')}}" valida="SI" cadena ="{{__('sistema.security_question.questionen_requiredval')}}" value="{{ old('question_en') }}">
                                          </div>
                                      </div>

                                      <div class="form-group row" id="inputquestion_es">
                                          <label for="question_es" class="col-sm-3 form-control-label">@lang('sistema.security_question.questiones')<span class="text-danger">*</span></label>
                                          <div class="col-sm-9">
                                              <input type="text" class="form-control" id="question_es" name="question_es" placeholder="{{__('sistema.security_question.questiones')}}" valida="SI" cadena ="{{__('sistema.security_question.questiones_requiredval')}}" value="{{ old('question_es') }}">
                                          </div>
                                      </div>

                                      <div class="form-group row" id="inputquestion_type">
                                          <label for="question_type" class="col-sm-3 form-control-label">@lang('sistema.security_question.question_type')<span class="text-danger">*</span></label>
                                          <div class="col-sm-9">
                                              <select id="question_type" class="form-control" name="question_type" valida="SI" cadena="{{__('sistema.security_question.question_type_requiredval')}}">
                                                <option value="">@lang('sistema.btn_select')</option>
                                                @foreach($question_types as $value)
                                                    <option value="{{ $value['id'] }}">{{ $value['value'] }}</option>
                                                @endforeach
                                              </select>
                                          </div>
                                      </div>

                                      <div class="form-group m-b-0">
                                          <div class="offset-sm-3 col-sm-9">
                                              <a href="{{url('security_questions')}}" class="btn btn-danger waves-effect waves-light">@lang('sistema.btn_back')</a>
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

            $('#frm_security_questions').find(':input').each(function() {
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