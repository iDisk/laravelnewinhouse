<div class="block_notifications" style="padding-left: 20px;">
	<div class="row">
		<div class="col-12" style="margin-top:30px; width: 80%;">
	        <p>Apreciado Cliente,</p>

	        @if(isset($data['ESTATUS']) && $data['ESTATUS'] == 'rejected')
	        	<p>Su solicitud de <b class="font-600">Baja de Cuentas</b> fue rechazada. Con la siguiente información</p>
	        @elseif(isset($data['ESTATUS']) && $data['ESTATUS'] == 'approved')
	        	<p>Su solicitud de <b class="font-600">Baja de Cuentas</b> fue aprobada. Con la siguiente información</p>
	        @else
	        	<p>Su solicitud de <b class="font-600">Baja de Cuentas</b> ha sido recibida. Con la siguiente información.</p>
	        @endif

			<div style="clear: both;"></div>

			<div style="width: 100%;">
				<div style="width: 50%; float: left;">
					<p><b class="font-600">NÚM DE CUENTA: </b> {{ isset($data['NUM_DE_CUENTA']) ? $data['NUM_DE_CUENTA'] : '-' }}</p>
				</div>
				<div style="width: 50%; float: left;">
					<p><b class="font-600">TIPO DE CUENTA: </b> {{ isset($data['TIPO_CUENTA']) ? $data['TIPO_CUENTA'] : '-' }}</p>
				</div>
				<div style="width: 50%; float: left;">
					<p><b class="font-600">DESCRIPCIÓN DE CUENTA: </b> {{ isset($data['DESCRIPTION_CUENTA']) ? $data['DESCRIPTION_CUENTA'] : '-' }}</p>
				</div>
				<div style="width: 50%; float: left;">
					<p><b class="font-600">DESTINO: </b> {{ isset($data['DESTINATION']) ? $data['DESTINATION'] : '-' }}</p>
				</div>
				<div style="width: 50%; float: left;">
					<p><b class="font-600">BANCO: </b> {{ isset($data['BANCO']) ? $data['BANCO'] : '-' }}</p>
				</div>
				<div style="width: 50%; float: left;">
					<p><b class="font-600">DIVISA: </b> {{ isset($data['DIVISA']) ? $data['DIVISA'] : '-' }}</p>
				</div>
				<div style="width: 50%; float: left;">
					<p><b class="font-600">Acción requerida: </b> {{ isset($data['ACTION_ELIMINAR']) ? $data['ACTION_ELIMINAR'] : '-' }}</p>
				</div>
			</div>
			<div style="clear: both;"></div>

	        @if(isset($data['MESSAGE']) && $data['MESSAGE'] != '')
	        	<p><b class="font-600"><i>Respuesta del administrador:</i></b> {{ $data['MESSAGE']  }}</p>
	        @endif
	        <p>Atentamente,</p>
	        <p>{{ isset($data['FIRMA_DEL_BROKER']) ? $data['FIRMA_DEL_BROKER'] : 'FIRMA DEL BROKER' }}</p>
    	</div>
	</div>
</div>