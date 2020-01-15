<div class="container">
    <div class="block_notifications">
        <p>Dear Client,</p>
        <p>Your request for financing has been: <u>{{ isset($data['ESTATUS']) ? __('sistema.notifications.estatus.'.$data['ESTATUS']) : 'ESTATUS' }}</u></p>
        <p>Amount: ${{ isset($data['MONTO']) ? number_format($data['MONTO'], 2) : '-' }}</p>
        @if(isset($data['MESSAGE'] && $data['MESSAGE'] != '')
        <p>Admin reply: {{ $data['MESSAGE']  }}</p>
        @endif
        <p>Sincerely,</p>
        <p>{{ isset($data['FIRMA_DEL_BROKER']) ? $data['FIRMA_DEL_BROKER'] : 'FIRMA DEL BROKER' }}</p>
    </div>
</div>