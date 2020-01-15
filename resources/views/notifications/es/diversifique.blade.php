<div class="block_notifications" style="padding-left: 20px;">
	<div class="row">
	    <div class="col-12" style="margin-top:30px; width: 80%;">
	        <p>Apreciado Cliente,</p>
	        @if(isset($data['ESTATUS']) && $data['ESTATUS'] == 'rejected')
	        	<p>Su solicitud de <b class="font-600">diversificación</b> fue rechazada. Con la siguiente información.</p>
	        @elseif(isset($data['ESTATUS']) && $data['ESTATUS'] == 'approved')
	        	<p>Su solicitud de <b class="font-600">diversificación</b> fue aprobada. Con la siguiente información.</p>
	        @else
	        	<p>Su solicitud de <b class="font-600">diversifique</b> recibida. Con la siguiente información</p>
	        @endif

	        <div style="clear: both;"></div>

	        <div style="width: 100%;">
				<div style="width: 50%; float: left;">
					<p><b class="font-600">ORIGEN: </b> {{  $data['FROM_ACCOUNT']  }}</p>
				</div>
				<div style="width: 50%; float: left;">
					<p><b class="font-600">PRODUCTO A CONTRATAR: </b> {{  isset($data['PRODUCT_HIRE']) ? $data['PRODUCT_HIRE'] : '' }}</p>
				</div>
				<div style="width: 50%; float: left;">
					<p><b class="font-600">VENCIMIENTO DESEADO: </b> {{  isset($data['EXPIRATION_DATE']) ? $data['EXPIRATION_DATE'] : '' }}</p>
				</div>
				<div style="width: 50%; float: left;">
					<p><b class="font-600">IMPORTE: </b> {{  isset($data['AMOUNT']) ? $data['AMOUNT'] : '' }}</p>
				</div>
				<div style="width: 50%; float: left;">
					<p><b class="font-600">FECHA DE APLICACIÓN: </b> {{  isset($data['APPLICATION_DATE']) ? $data['APPLICATION_DATE'] : '' }}</p>
				</div>
				<div style="width: 50%; float: left;">
					<p><b class="font-600">INSTRUCCIÓN DE VENCIMIENTO: </b> {{  isset($data['INSTRUCTION']) ? $data['INSTRUCTION'] : '' }}</p>
				</div>
			</div>

	        @if(isset($data['MESSAGE']) && $data['MESSAGE'] != '')
	        	<p><b class="font-600"><i>Respuesta del administrador:</i></b> {{ $data['MESSAGE']  }}</p>
	        @endif
	        <p>Atentamente,</p>
	        <p>{{ isset($data['FIRMA_DEL_BROKER']) ? $data['FIRMA_DEL_BROKER'] : 'FIRMA DEL BROKER' }}</p>
	    </div>
	</div>
</div>