<div class="block_notifications" style="padding-left: 20px;">
	<div class="row">
	    <div class="col-12" style="margin-top:30px;">
	        <p>Apreciado Cliente,</p>
	        @if(isset($data['ESTATUS']) && $data['ESTATUS'] == 'rejected')
	        	<p>Su solicitud de <b class="font-600">Amplíe su financiamiento</b> por un monto de <b class="font-600">${{ isset($data['MONTO']) ? number_format($data['MONTO'], 2) : '-' }}</b> fue Rechazada</p>
	        @elseif(isset($data['ESTATUS']) && $data['ESTATUS'] == 'approved')
	        	<p>Su solicitud de <b class="font-600">Amplíe su financiamiento</b> por un monto de <b class="font-600">${{ isset($data['MONTO']) ? number_format($data['MONTO'], 2) : '-' }}</b> fue Aprobada</p>
	        @else
	        	<p>Su solicitud de <b class="font-600">Amplíe su financiamiento</b> por un monto de <b class="font-600">${{ isset($data['MONTO']) ? number_format($data['MONTO'], 2) : '-' }}</b> ha sido recibida</p>
	        @endif

	        @if(isset($data['MESSAGE']) && $data['MESSAGE'] != '')
	        	<p>Respuesta del administrador : {{ $data['MESSAGE']  }}</p>
	        @endif
	        <p>Atentamente,</p>
	        <p>{{ isset($data['FIRMA_DEL_BROKER']) ? $data['FIRMA_DEL_BROKER'] : 'FIRMA DEL BROKER' }}</p>
	    </div>
	</div>
</div>