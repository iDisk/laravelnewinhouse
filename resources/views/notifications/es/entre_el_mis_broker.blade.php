<div class="block_notifications" style="padding-left: 20px;">
	<div class="row">
		<div class="col-12" style="margin-top:30px; width: 80%;">
	        <p>Apreciado Cliente,</p>

	        @if(isset($data['ESTATUS']) && $data['ESTATUS'] == 'rejected')
	        	<p>Su solicitud de <b class="font-600">Transferencias entre el mismo broker</b> fue rechazada. Con la siguiente información</p>
	        @elseif(isset($data['ESTATUS']) && $data['ESTATUS'] == 'approved')
	        	<p>Su solicitud de <b class="font-600">Transferencias entre el mismo broker</b> fue aprobada. Con la siguiente información</p>
	        @else
	        	<p>Su solicitud de <b class="font-600">Transferencias entre el mismo broker</b> ha sido recibida. Con la siguiente información.</p>
	        @endif

	        <div style="width: 100%;">
				<p><b class="font-600">CUENTA DE CARGO: </b> {{ isset($data['FROM_ACCOUNT']) ? $data['FROM_ACCOUNT'] : '-' }}</p>
			</div>
			<div style="clear: both;"></div>
			<div style="width: 100%;">
				<div style="width: 50%; float: left;">
					<p><b class="font-600">DIVISA: </b> {{ isset($data['CURRENCY']) ? $data['CURRENCY'] : '-' }}</p>
				</div>
				<div style="width: 50%; float: left;">
					<p><b class="font-600">IMPORTE: </b> {{ isset($data['CURRENCY_SYMBOL']) ? $data['CURRENCY_SYMBOL'] : '' }}{{ isset($data['AMOUNT']) ? $data['AMOUNT'] : '-' }}</p>
				</div>
				<div style="width: 50%; float: left;">
					<p><b class="font-600">FECHA DE APLICACIÓN: </b> {{ isset($data['APPLICATION_DATE']) ? $data['APPLICATION_DATE'] : '-' }}</p>
				</div>
				<div style="width: 50%; float: left;">
					<p><b class="font-600">CUENTA DE ABONO: </b> {{ isset($data['PAYMENT_ACCOUNT']) ? $data['PAYMENT_ACCOUNT'] : '-' }}</p>
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