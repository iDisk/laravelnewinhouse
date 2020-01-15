<div class="block_notifications" style="padding-left: 20px;">
	<div class="row">
		<div class="col-12" style="margin-top:30px; width: 80%;">
	        <p>Apreciado Cliente,</p>
	        @if(isset($data['ESTATUS']) && $data['ESTATUS'] == 'rejected')
	        	<p>Su solicitud de <b class="font-600">Alta de Cuentas</b> fue rechazada. Con la siguiente información.</p>
	        @elseif(isset($data['ESTATUS']) && $data['ESTATUS'] == 'approved')
	        	<p>Su solicitud de <b class="font-600">Alta de Cuentas</b> fue aprobada. Con la siguiente información.</p>
	        @else
	        	<p>Su solicitud de <b class="font-600">Alta de Cuentas</b> ha sido recibida. Con la siguiente información.</p>
	        @endif
			
			<div style="clear: both;"></div>
			
			<div style="width: 100%;">
				@if(isset($data['TYPE_OF_RECIPIENT']) && $data['TYPE_OF_RECIPIENT'] != '')
				<div style="width: 50%; float: left;">
					<p><b class="font-600">TIPO DE DESTINATARIO: </b> {{ $data['TYPE_OF_RECIPIENT'] }}</p>
				</div>
				@endif
				@if(isset($data['DESTINATION']) && $data['DESTINATION'] != '')
				<div style="width: 50%; float: left;">
					<p><b class="font-600">DESTINO: </b> {{ $data['DESTINATION'] }}</p>
				</div>
				@endif
				@if(isset($data['TYPE_OF_ACCOUNT'])  && $data['TYPE_OF_ACCOUNT'] != '')
				<div style="width: 50%; float: left;">
					<p><b class="font-600">TIPO DE CUENTA: </b> {{ $data['TYPE_OF_ACCOUNT'] }}</p>
				</div>
				@endif
				@if(isset($data['ACCOUNT_NAME']) && $data['ACCOUNT_NAME'] != '')
				<div style="width: 50%; float: left;">
					<p><b class="font-600">NOMBRE: </b> {{ $data['ACCOUNT_NAME'] }}</p>
				</div>
				@endif
				@if(isset($data['ACCOUNT_NUMBER']) && $data['ACCOUNT_NUMBER'] != '')
				<div style="width: 50%; float: left;">
					<p><b class="font-600">NÚM. DE CUENTA: </b> {{ $data['ACCOUNT_NUMBER'] }}</p>
				</div>
				@endif
				@if(isset($data['CURRENCY']) && $data['CURRENCY'] != '')
				<div style="width: 50%; float: left;">
					<p><b class="font-600">MONEDA: </b> {{ $data['CURRENCY'] }}</p>
				</div>
				@endif


				@if(isset($data['TELEPHONE']) && $data['TELEPHONE'] != '')
				<div style="width: 50%; float: left;">
					<p><b class="font-600">TELÉFONO: </b> {{ $data['TELEPHONE'] }}</p>
				</div>
				@endif
				@if(isset($data['ADDRESS']) && $data['ADDRESS'] != '')
				<div style="width: 50%; float: left;">
					<p><b class="font-600">DIRECCIÓN: </b> {{ $data['ADDRESS'] }}</p>
				</div>
				@endif
				@if(isset($data['COUNTRY']) && $data['COUNTRY'] != '')
				<div style="width: 50%; float: left;">
					<p><b class="font-600">PAÍS: </b> {{ $data['COUNTRY'] }}</p>
				</div>
				@endif
				@if(isset($data['STATE']) && $data['STATE'] != '')
				<div style="width: 50%; float: left;">
					<p><b class="font-600">ESTADO: </b> {{ $data['STATE'] }}</p>
				</div>
				@endif
				@if(isset($data['CITY']) && $data['CITY'] != '')
				<div style="width: 50%; float: left;">
					<p><b class="font-600">CIUDAD: </b> {{ $data['CITY'] }}</p>
				</div>
				@endif
				@if(isset($data['DEST_BANK_COUNTRY']) && $data['DEST_BANK_COUNTRY'] != '')
				<div style="width: 50%; float: left;">
					<p><b class="font-600">PAÍS DEL BANCO DESTINO: </b> {{ $data['DEST_BANK_COUNTRY'] }}</p>
				</div>
				@endif
				@if(isset($data['DEST_ACCOUNT_NUMBER']) && $data['DEST_ACCOUNT_NUMBER'] != '')
				<div style="width: 50%; float: left;">
					<p><b class="font-600">NÚM. DE CUENTA: </b> {{ $data['DEST_ACCOUNT_NUMBER'] }}</p>
				</div>
				@endif
				@if(isset($data['DEST_SWIFT']) && $data['DEST_SWIFT'] != '')
				<div style="width: 50%; float: left;">
					<p><b class="font-600">SWIFT O ABA: </b> {{ $data['DEST_SWIFT'] }}</p>
				</div>
				@endif
				@if(isset($data['DEST_BANK_NAME']) && $data['DEST_BANK_NAME'] != '')
				<div style="width: 50%; float: left;">
					<p><b class="font-600">BANCO DESTINO: </b> {{ $data['DEST_BANK_NAME'] }}</p>
				</div>
				@endif
				@if(isset($data['DEST_BANK_ADDRESS']) && $data['DEST_BANK_ADDRESS'] != '')
				<div style="width: 50%; float: left;">
					<p><b class="font-600">DIRECCIÓN: </b> {{ $data['DEST_BANK_ADDRESS'] }}</p>
				</div>
				@endif
				@if(isset($data['INT_BANK_COUNTRY']) && $data['INT_BANK_COUNTRY'] != '')

				<div style="width: 100%;">
					<p><b class="font-600">BANCO INTERMEDIARIO </b></p>
				</div>
				<div style="clear: both;"></div>

				<div style="width: 50%; float: left;">
					<p><b class="font-600">PAÍS DEL BANCO INTERMEDIARIO: </b> {{ $data['INT_BANK_COUNTRY'] }}</p>
				</div>
				@endif
				@if(isset($data['DEST_INT_ACCOUNT_NUMBER']) && $data['DEST_INT_ACCOUNT_NUMBER'] != '')
				<div style="width: 50%; float: left;">
					<p><b class="font-600">NÚM. DE CUENTA: </b> {{ $data['DEST_INT_ACCOUNT_NUMBER'] }}</p>
				</div>
				@endif
				@if(isset($data['DEST_INT_SWIFT']) && $data['DEST_INT_SWIFT'] != '')
				<div style="width: 50%; float: left;">
					<p><b class="font-600">SWIFT O ABA: </b> {{ $data['DEST_INT_SWIFT'] }}</p>
				</div>
				@endif
				@if(isset($data['DEST_INT_BANK_NAME']) && $data['DEST_INT_BANK_NAME'] != '')
				<div style="width: 50%; float: left;">
					<p><b class="font-600">BANCO INTERMEDIARIO: </b> {{ $data['DEST_INT_BANK_NAME'] }}</p>
				</div>
				@endif
				@if(isset($data['DEST_INT_BANK_ADDRESS']) && $data['DEST_INT_BANK_ADDRESS'] != '')
				<div style="width: 50%; float: left;">
					<p><b class="font-600">DIRECCIÓN: </b> {{ $data['DEST_INT_BANK_ADDRESS'] }}</p>
				</div>
				@endif
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