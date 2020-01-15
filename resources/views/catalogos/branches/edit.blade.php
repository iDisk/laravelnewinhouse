@extends('layouts.main')
@section('customcss')

@endsection

@section('pagecontent')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">@lang('sistema.branches.edit_branch')</h4>
                <ol class="breadcrumb p-0 m-0">
                    <li>
                        <a href="javascript:void(0)">@lang('sistema.pie')</a>
                    </li>
                    <li>
                        <a href="{{ url('items') }}">
                            @lang('sistema.branches.branches')
                        </a>
                    </li>
                    <li class="active">
                        @lang('sistema.branches.edit_branch')
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
                            <form class="form-horizontal"  method="POST" action="{{url('branches/' . $branch->id)}}" id="frm_items" onsubmit="return validateFrm();">
                                {{ csrf_field() }}
                                {{ method_field('PUT') }}
                                <div class="form-group row" id="inputbranch_en">
                                    <label for="branch_en" class="col-sm-3 form-control-label">@lang('sistema.branches.branch_en')<span class="text-danger">*</span></label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="branch_en" name="branch_en" placeholder="{{__('sistema.item.item_en')}}" valida="SI" cadena ="{{__('sistema.branches.req_branch_en')}}" value="{{ (old('branch_en'))? old('branch_en'): $branch->branch_en }}">
                                    </div>
                                </div>
                                <div class="form-group row" id="inputbranch_es">
                                    <label for="branch_es" class="col-sm-3 form-control-label">@lang('sistema.branches.branch_es')<span class="text-danger">*</span></label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="branch_es" name="branch_es" placeholder="{{__('sistema.item.item_es')}}" valida="SI" cadena ="{{__('sistema.branches.req_branch_es')}}" value="{{ (old('branch_es'))? old('branch_es'): $branch->branch_es }}">
                                    </div>
                                </div>
                                 <div class="form-group row" id="inputcountry_id">
                                     <label for="country_id" class="col-sm-3 form-control-label">@lang('sistema.branches.country')<span class="text-danger">*</span></label>
                                     <div class="col-sm-9">
                                         <select class="form-control" name="country_id" id="country_id" valida="SI" cadena ="{{__('sistema.branches.req_country')}}">
                                             <option value="">@lang('sistema.branches.select_country')</option>
                                             @if(isset($countries) && count($countries) > 0)
                                             @foreach($countries as $country_id => $country_name)
                                             <option value="{{ $country_id }}" {{ old('country_id') == $country_id ? 'selected' : ($branch->country_id  == $country_id ? 'selected' : '') }}>{{ $country_name }}</option>
                                             @endforeach
                                             @endif
                                         </select>
                                     </div>
                                 </div>
                                <div class="form-group m-b-0">
                                    <div class="offset-sm-3 col-sm-9">
                                        <a href="{{url('branches')}}" class="btn btn-danger waves-effect waves-light">@lang('sistema.btn_back')</a>
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
        title: '@lang("sistema.users_alert")',
        text: '{{session("msg")}}',
        type: 'error',
        timer: 5500,
        confirmButtonColor: 'red',
        confirmButtonText: 'OK'
    });
</script>
@endif

<script type="text/javascript">
    function validateFrm()
    {
        var listv = 0;
        var msg = '';

        $('#frm_items').find(':input').each(function () {
            if ($(this).attr("valida") == "SI" && ($(this).val() == "" || $(this).val() == "null"))
            {
                listv = 1;
                $('#input' + this.id).addClass('has-error');
                msg += $(this).attr('cadena') + '\n';

                //$(this).val($(this).val().toUpperCase());
            } else
            {
                $('#input' + this.id).removeClass('has-error');
                if ($(this).attr("valida") == "SI")
                {
                    //$(this).val($(this).val().toUpperCase());
                }
            }
        });

        if (listv == 1)
        {
            swal({
                title: '@lang("sistema.users_alert")',
                text: msg,
                type: 'error',
                timer: 4000,
                confirmButtonColor: 'red',
                confirmButtonText: 'OK'
            });
            return false;
        } else {
            return true;
        }
    }
</script>
@endsection