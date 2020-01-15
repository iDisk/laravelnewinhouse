<div class="block_notifications" style="padding-left: 20px;">
    <div class="row">
        <div class="col-12" style="margin-top:30px;">
            <p>Apreciado Cliente,</p>
            @if(isset($data['ESTATUS']))
            <p>Su solicitud de <b class="font-600">Cerrar un Financiamiento</b> ha sido: <u>{{ isset($data['ESTATUS']) ? __('sistema.notifications.estatus.'.$data['ESTATUS']) : 'ESTATUS' }}</u></p>
            @if(isset($data['MESSAGE']) && $data['MESSAGE'] != '')
            <p>Respuesta del administrador : {{ $data['MESSAGE']  }}</p>
            @endif
            @else
            <p>Su solicitud de <b class="font-600">Cerrar un Financiamiento</b> ha sido recibida.</p>
            @endif
            <p>Atentamente,</p>
            <p>{{ isset($data['FIRMA_DEL_BROKER']) ? $data['FIRMA_DEL_BROKER'] : 'FIRMA DEL BROKER' }}</p>
        </div>
    </div>
</div>