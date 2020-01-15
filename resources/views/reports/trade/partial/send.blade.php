@php
if(session('language') == 'es')
{
$months = [ 1 => 'Enero', 2 => 'Febrero', 3 => 'Marzo', 4 => 'Abril', 5 => 'Mayo', 6 => 'Junio', 7 => 'Julio', 8 => 'Agosto', 9 => 'Septiembre', 10 => 'Octubre', 11 => 'Noviembre', 12 => 'Diciembre'];
}
else
{
$months = [ 1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April', 5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August', 9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December'];
}
@endphp
<form method="post" action="#" id="frmSendEmailReport">
    {{ csrf_field() }}
    <div class="row">
        <div class="form-group col-lg-6">
            <label class="form-control-label">@lang('sistema.month'):</label>
            <select class="form-control" name="month" id="select_month">
                @for($i=1;$i<=12;++$i)
                <option value="{{ $i }}" {{ old('month') == $i ? 'selected' : '' }}>{{ $months[$i] }}</option>
                @endfor
            </select>
        </div>
        <div class="form-group col-lg-6">
            <label class="form-control-label">@lang('sistema.year'):</label>
            <select class="form-control" name="year" id="select_year">
                @for($j= date('Y'); $j >= env('BASE_YEAR', 2016); $j--)
                <option value="{{ $j }}" {{ old('year') == $j ? 'selected' : '' }}>{{ $j }}</option>
                @endfor
            </select>
        </div>
        <div class="form-group col-lg-12">
            <label class="form-control-label">Accounts:</label>
            <div>
                @if(isset($accounts) && count($accounts) > 0)
                @foreach($accounts as $account)
                <div style="width: 100%;">                    
                    <input type="checkbox" class="account_selected" value="{{ $account->id }}" name="account_selected[]" id="account_{{ $account->id }}"/> <label style="font-weight: normal; cursor: pointer;" for="account_{{ $account->id }}">{{ $account->primary_client ? $account->primary_client->full_name : '' }} ({{ $account->account_number }})</label>
                </div>
                @endforeach
                @endif
            </div>
        </div>
    </div>
</form>