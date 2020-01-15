<div class="block_notifications" style="padding-left: 20px;">
    <div class="row">
        <div class="col-12" style="margin-top:30px;">
            <p>Dear Client,</p>
            @if(isset($data['ESTATUS']))
            <p>Your request to <b class="font-600">close financing</b> has been <u>{{ isset($data['ESTATUS']) ? __('sistema.notifications.estatus.'.$data['ESTATUS']) : 'ESTATUS' }}</u></p>
            @if(isset($data['MESSAGE']) && $data['MESSAGE'] != '')
            <p>Admin reply : {{ $data['MESSAGE']  }}</p>
            @endif
            @else
            <p>Your request to <b class="font-600">close financing</b> has been received.</p>
            @endif
            <p>Sincerely,</p>
            <p>{{ isset($data['FIRMA_DEL_BROKER']) ? $data['FIRMA_DEL_BROKER'] : 'FIRMA DEL BROKER' }}</p>
        </div>
    </div>
</div>