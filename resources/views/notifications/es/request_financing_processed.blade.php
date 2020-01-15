<div class="container">
    <div class="block_notifications">
        <p>Apreciado Cliente,</p>
        <p>Su solicitar un financiamiento ha sido: <u>{{ isset($data['ESTATUS']) ? __('sistema.notifications.estatus.'.$data['ESTATUS']) : 'ESTATUS' }}</u></p>
        <p>Monto: ${{ isset($data['MONTO']) ? number_format($data['MONTO'], 2) : '-' }}</p>
        @if(isset($data['MESSAGE']) && $data['MESSAGE'] != '')
        <p>Respuesta del administrador: {{ $data['MESSAGE']  }}</p>
        @endif
        <p>Atentamente,</p>
        <p>{{ isset($data['FIRMA_DEL_BROKER']) ? $data['FIRMA_DEL_BROKER'] : 'FIRMA DEL BROKER' }}</p>
    </div>
</div>