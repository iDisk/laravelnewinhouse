@extends('layouts.main')
@section('customcss')
@endsection

@section('pagecontent')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">@lang('sistema.client_request.client_request_label')</h4>
                <ol class="breadcrumb p-0 m-0">
                    <li>
                        <a href="javascript:void(0)">@lang('sistema.pie')</a>
                    </li>
                    <li class="active">
                        @lang('sistema.client_request.client_request_label')
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
                    <div class="row">
                        <div class="col-lg-12">
                            <table style="width: 100%;" class="table table-striped">
                                <tr>
                                    <td style="width: 25%;"><strong>@lang('sistema.client_request.file_number')</strong></td>
                                    <td>{{ $client_request->file_number }}</td>
                                </tr>
                                <tr>
                                    <td style="width: 25%;"><strong>@lang('sistema.client_request.user_name')</strong></td>
                                    <td>{{ $client_request->user ? $client_request->user->name : 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <td style="width: 25%;"><strong>@lang('sistema.client_request.current_status')</strong></td>
                                    <td>{{ $client_request->current_status ? 
                                        ( session('language') == 'en' ? $client_request->current_status->status_en : $client_request->current_status->status_es)
                                        : '' }}</td>
                                </tr>
                                <tr>
                                    <td style="width: 25%;"><strong>@lang('sistema.client_request.request_type')</strong></td>
                                    <td>{{ $client_request->tipo ? $client_request->tipo : 'N/A' }}</td>
                                </tr>
                                @if($client_request->category_id)
                                <tr>
                                    <td style="width: 25%;"><strong>@lang('sistema.client_request.category')</strong></td>
                                    <td>{{ $client_request->category ? $client_request->category : 'N/A' }}</td>
                                </tr>
                                @endif
                                @if($client_request->comments)
                                <tr>
                                    <td style="width: 25%;"><strong>@lang('sistema.client_request.comments')</strong></td>
                                    <td>{{ $client_request->comments ? $client_request->comments : 'N/A' }}</td>
                                </tr>
                                @endif
                                
                            </table>
                            <hr>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <table style="width: 100%;" class="table table-striped table-bordered table-bordered-danger">
                                @if($client_request->request_type_id == 27 && isset($client_request->fields_arr) && !empty($client_request->fields_arr))
                                <tr>
                                <td style="width: 25%;"><strong>{{config('site.request_array.document_type.'. session('language'))}}</strong></td>
                                <td>{{$client_request->fields_arr->document_type->value}}</td>
                                </tr>
                                @foreach($client_request->fields_arr->documents as $keyIndex => $row)
                                <tr>
                                    <td style="width: 25%;"><strong>{{ config('site.request_array.document.'. session('language')) }}</strong></td>
                                    <td>
                                        @if($row->document->type == 'file')
                                            @if(in_array($row->document->extension, ['png', 'jpg', 'jpeg']))
                                            <a href="{{ url($row->document->path) }}" target="_blank">
                                                <img src="{{ url($row->document->path) }}" class="img-responsive" style="height: 150px;"/>
                                            </a>
                                            @else
                                            <a href="{{ url($row->document->path) }}" target="_blank">{{ $row->document->original_file_name }}</a>
                                            @endif
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                                @elseif(isset($client_request->fields_arr) && !empty($client_request->fields_arr))
                                @foreach($client_request->fields_arr as $keyIndex => $row)                                
                                <tr>
                                    <td style="width: 25%;"><strong>{{ config('site.request_array.'. $keyIndex . '.'. session('language')) }}</strong></td>
                                    <td>
                                        @if($row->type == 'text')
                                            @if(\App\Http\Controllers\Web\ClientRequestController::checkFileURL($row->value))
                                                <img src="{{ $row->value }}" class="img-responsive" style="height: 150px;"/>
                                            @else
                                                <span>{{  $row->value != '' ? $row->value : 'N/A'}}</span>
                                            @endif
                                        @elseif($row->type == 'file')
                                            @if(in_array($row->extension, ['png', 'jpg', 'jpeg']))
                                            <a href="{{ url($row->path) }}" target="_blank">
                                                <img src="{{ url($row->path) }}" class="img-responsive" style="height: 150px;"/>
                                            </a>
                                            @else
                                            <a href="{{ url($row->path) }}" target="_blank">{{ $row->original_file_name }}</a>
                                            @endif
                                        @elseif($row->type == 'image')
                                        ***IN PROGRESS***
                                        @else
                                        ***IN PROGRESS***
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                                @endif
                            </table>
                        </div>
                    </div>
                    @if($client_request->request_status_id == 1)
                    <div class="row"> 
                        <div class="col-lg-12">
                            <div class="form-group" style="margin-bottom: 25px;">
                                <div class="checkbox checkbox-custom m-t-0">
                                    <label class="m-b-0 ckCursor" for="comment2client">
                                        <input type="checkbox" value="1" name="comment2client" id="comment2client">
                                        <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                        @lang('sistema.client_request.comment2client')
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group" id="inputcomments">
                                <div class="row">
                                    <label for="comments" class="col-sm-12 form-control-label">@lang('sistema.client_request.comments')<span id="comments_required" style="display: none;" class="text-danger">*</span></label>
                                    <div class="col-sm-12">
                                        <textarea class="form-control" name="comments" valida="SI" id="comments" placeholder="{{__('sistema.client_request.comments')}}" cadena="{{ __('sistema.client_request.required.comments') }}"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>                    
                    @endif
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                @if($client_request->request_status_id == 1)
                                <button class="btn btn-success btnResponse" data-type='2'>@lang('sistema.btn_approve')</button>
                                <button class="btn btn-danger btnResponse" data-type='3'>@lang('sistema.btn_decline')</button>
                                @endif
                                <a class="btn btn-info btn-default" href="{{ url('tramites') }}" style="color: white;">@lang('sistema.btn_back')</a>
                            </div>
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
    function validateFrm() {
        var listv = 0;
        var msg = '';

        $('#frm_commission_fees').find(':input').each(function () {
            if ($(this).attr("valida") == "SI" && ($(this).val() == "" || $(this).val() == "")) {
                listv = 1;
                $('#input' + this.id).addClass('has-error');
                msg += $(this).attr('cadena') + '\n';
            } else
            {
                $('#input' + this.id).removeClass('has-error');
            }
        });

        if (listv == 1)
        {
            swal({
                title: 'Aviso!!',
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

    $('.btnResponse').click(function () {
        let this_obj = $(this);
        let response_type = this_obj.data('type');
        let comments_val = $("#comments").val();
        let comment_chk  = $("#comment2client").is(':checked');
        comment_chk = comment_chk ? 1 : 0;
        let button_title = "{{ __('sistema.btn_approve') }}";
        let confirm_color = '#6ABA40';
        let confirm_button_text = "{{ __('sistema.btn_approve') }}";
        let confirm_text = "{{ __('sistema.client_request.approve_msg') }}";

        if (response_type == 3)
        {
            button_title = "{{ __('sistema.btn_decline') }}";
            confirm_color = '#DD6B55';
            confirm_button_text = "{{ __('sistema.btn_decline') }}";
            confirm_text = "{{ __('sistema.client_request.declined_msg') }}"
        }

        var ajax_data = {'response': response_type, 'comment_chk': comment_chk, 'comments': comments_val};
        
        if(comment_chk)
        {
            if(comments_val == '')
            {
                swal('Error!', '{{ __("sistema.client_request.comments_required") }}', 'error');
                $("#inputcomments").addClass('has-error');
                return false;
            }
            else
            {
                $("#inputcomments").removeClass('has-error');
            }
        }

        swal({
            title: button_title,
            text: confirm_text,
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: confirm_color,
            confirmButtonText: confirm_button_text,
            cancelButtonText: "{{ __('sistema.btn_cancel') }}"
        }).then(function (isConfirm) {
            show_loader(true);
            $.ajax({
                type: 'PUT',
                url: "{{ url('/tramites') }}" + "/" + '{{ $client_request->id }}',
                data: ajax_data,
                headers: {'X-CSRF-Token': '{{ csrf_token() }}'},
                success: function (response) {
                    show_loader(false);
                    if (response.flag == 1)
                    {
                        swal('{{ __("sistema.success") }}', response.message, 'success').then(function () {
                            window.location = '{{ url("tramites") }}';
                        });
                    } else
                    {
                        swal('{{ __("sistema.error") }}', response.message, 'error');
                    }
                },
                error: function (response) {

                },
                complete: function () {

                }
            });
        }).catch(function (reason) {
            //alert("The alert was dismissed by the user: " + reason);
        });
    });
    
    $("#comment2client").change(function(){
        let checked_ck = $(this).is(':checked');
        if(checked_ck)
        {
            $("#comments").prop('valida', 'SI');
            $("#comments_required").show();
        }
        else
        {
            $("#comments").prop('valida', 'NO');
            $("#comments_required").hide();
        }
    });

    function checkFileURL(data){
        return data;
    }
</script>
@endsection