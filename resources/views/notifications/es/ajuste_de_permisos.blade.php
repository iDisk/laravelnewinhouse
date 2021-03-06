<div class="block_notifications" style="padding-left: 20px;">
	<div class="row">
		<div class="col-12" style="margin-top:30px; width: 80%;">
	        <p>Apreciado Cliente,</p>

	        @if(isset($data['ESTATUS']) && $data['ESTATUS'] == 'rejected')
	        	<p>Su solicitud de <b class="font-600">ajuste de permiso</b> fue rechazada. Con la siguiente información</p>
	        @elseif(isset($data['ESTATUS']) && $data['ESTATUS'] == 'approved')
	        	<p>Su solicitud de <b class="font-600">ajuste de permiso</b> fue aprobada. Con la siguiente información</p>
	        @else
	        	<p>Su solicitud de <b class="font-600">ajuste de permiso</b> ha sido recibida. Con la siguiente información.</p>
	        @endif

			@if(isset($data['PERMISSION_ACCOUNT_ACCESS']) || isset($data['PERMISSION_TRANSFR_BTW_ACCOUNT']) || isset($data['PERMISSION_TELEPHONE_ORDERS']) || isset($data['PERMISSION_INTERNATIONAL_TRANSFER']) || isset($data['PERMISSION_WIRITTEN_ORDERS']))
			<div style="width: 100%;">
				<p><b class="font-600">PERMISOS A OTORGAR</b></p>
			</div>
			<div style="width: 100%;">
				
					@if(isset($data['PERMISSION_ACCOUNT_ACCESS']))
					<div style="width: 50%; float: left;">
						<p><b class="font-600">Acceso a cuenta: </b> {{ $data['PERMISSION_ACCOUNT_ACCESS'] }}</p>
					</div>
	                @endif
					@if(isset($data['PERMISSION_TRANSFR_BTW_ACCOUNT']))
					<div style="width: 50%; float: left;">
						<p><b class="font-600">Traspaso entre cuentas: </b> {{ $data['PERMISSION_TRANSFR_BTW_ACCOUNT'] }}</p>
					</div>
	                @endif
					@if(isset($data['PERMISSION_TELEPHONE_ORDERS']))
					<div style="width: 50%; float: left;">
						<p><b class="font-600">Órdenes teléfonicas: </b> {{ $data['PERMISSION_TELEPHONE_ORDERS'] }}</p>
					</div>
	                @endif
					@if(isset($data['PERMISSION_INTERNATIONAL_TRANSFER']))
					<div style="width: 50%; float: left;">
						<p><b class="font-600">Transferencias internacionales: </b> {{ $data['PERMISSION_INTERNATIONAL_TRANSFER'] }}</p>
					</div>
	                @endif
					@if(isset($data['PERMISSION_WIRITTEN_ORDERS']))
					<div style="width: 50%; float: left;">
						<p><b class="font-600">Órdenes escritas: </b> {{ $data['PERMISSION_WIRITTEN_ORDERS'] }}</p>
					</div>
	                @endif
			</div>
			@endif

			<div style="clear: both;"></div>

			<div style="width: 100%;">
				<div style="width: 50%; float: left;">
					<p><b class="font-600">NOMBRE COMPLETO: </b> {{ isset($data['FULL_NAME']) ? $data['FULL_NAME'] : '-' }}</p>
				</div>
				<div style="width: 50%; float: left;">
					<p><b class="font-600">TIPO Y NÚMERO DE IDENTIFICACIÓN: </b> {{ isset($data['TYPE_NUMBER']) ? $data['TYPE_NUMBER'] : '-' }}</p>
				</div>
				<div style="width: 50%; float: left;">
					<p><b class="font-600">FECHA DE NACIMIENTO: </b> {{ isset($data['DATE_OF_BIRTH']) ? $data['DATE_OF_BIRTH'] : '-' }}</p>
				</div>
				<div style="width: 50%; float: left;">
					<p><b class="font-600">LUGAR DE NACIMIENTO: </b> {{ isset($data['PLACE_OF_BIRTH']) ? $data['PLACE_OF_BIRTH'] : '-' }}</p>
				</div>
				<div style="width: 50%; float: left;">
					<p><b class="font-600">DIRECCIÓN: </b> {{ isset($data['ADDRESS']) ? $data['ADDRESS'] : '-' }}</p>
				</div>
				<div style="width: 50%; float: left;">
					<p><b class="font-600">PAÍS: </b> {{ isset($data['COUNTRY']) ? $data['COUNTRY'] : '-' }}</p>
				</div>
				<div style="width: 50%; float: left;">
					<p><b class="font-600">ESTADO: </b> {{ isset($data['STATE']) ? $data['STATE'] : '-' }}</p>
				</div>
				<div style="width: 50%; float: left;">
					<p><b class="font-600">CONDADO / LOCALIDAD: </b> {{ isset($data['COUNTY']) ? $data['COUNTY'] : '-' }}</p>
				</div>
				<div style="width: 50%; float: left;">
					<p><b class="font-600">TELÉFONO: </b> {{ isset($data['PHONE_1']) ? $data['PHONE_1'] : '-' }}</p>
				</div>
				<div style="width: 50%; float: left;">
					<p><b class="font-600">TELÉFONO 2: </b> {{ isset($data['PHONE_2']) ? $data['PHONE_2'] : '-' }}</p>
				</div>
				<div style="width: 50%; float: left;">
					<p><b class="font-600">CORREO ELECTRÓNICO: </b> {{ isset($data['EMAIL']) ? $data['EMAIL'] : '-' }}</p>
				</div>
			</div>
			<div style="clear: both;"></div>
			@if(isset($data['DOCUMENT_ARR']))
				<div style="width: 100%;">
					<p><b class="font-600">Archivos asociados a la documentación</b></p>
				</div>
				@php 
					$i = 0;
				@endphp
				@foreach($data['DOCUMENT_ARR'] as $document_arr)
					@php $i++ @endphp
					{{ $i }}) <a href="{{ asset($document_arr['PATH']) }}" target="_blank">{{ $document_arr['NAME'] }}</a><br>
				@endforeach
				<br>
			@endif

	        @if(isset($data['MESSAGE']) && $data['MESSAGE'] != '')
	        	<p><b class="font-600"><i>Respuesta del administrador:</i></b> {{ $data['MESSAGE']  }}</p>
	        @endif
	        <p>Atentamente,</p>
	        <p>{{ isset($data['FIRMA_DEL_BROKER']) ? $data['FIRMA_DEL_BROKER'] : 'FIRMA DEL BROKER' }}</p>
    	</div>
	</div>
</div>