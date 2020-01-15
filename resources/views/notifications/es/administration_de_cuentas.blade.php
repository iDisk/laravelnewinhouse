<div class="block_notifications" style="padding-left: 20px;">
	<div class="row">
		<div class="col-12" style="margin-top:30px; width: 80%;">
	        <p>Apreciado Cliente,</p>
	        @if(isset($data['ESTATUS']) && $data['ESTATUS'] == 'rejected')
	        	<p>Su solicitud de <b class="font-600">administración de cuentas</b> fue rechazada. Con la siguiente información</p>
	        @elseif(isset($data['ESTATUS']) && $data['ESTATUS'] == 'approved')
	        	<p>Su solicitud de <b class="font-600">administración de cuentas</b> fue aprobada. Con la siguiente información</p>
	        @else
	        	<p>Su solicitud de <b class="font-600">administración de cuentas</b> ha sido recibida. Con la siguiente información.</p>
	        @endif
			
			<p><b class="font-600">LIMITES DIARIOS</b></p>
			<div style="width: 100%;">
				@if(isset($data['TFAMODIFY_LIMIT']))
					<div style="width: 50%; float: left;">
						<p><b class="font-600">TRASPASO ENTRE CUENTAS: </b> ${{ isset($data['TFAMODIFY_LIMIT']) ? number_format($data['TFAMODIFY_LIMIT'], 2) : '-' }}</p>
					</div>
				@endif
				@if(isset($data['TTPMODIFY_LIMIT']))
				<div style="width: 50%; float: left;">
					<p><b class="font-600">TRASPASO A TERCEROS: </b> ${{ isset($data['TTPMODIFY_LIMIT']) ? number_format($data['TTPMODIFY_LIMIT'], 2) : '-' }}</p>
				</div>
				@endif
				@if(isset($data['TIMODIFY_LIMIT']))
					<div style="width: 50%; float: left;">
						<p><b class="font-600">TRANSFERENCIAS INTERNACIONALES: </b> ${{ isset($data['TIMODIFY_LIMIT']) ? number_format($data['TIMODIFY_LIMIT'], 2) : '-' }}</p>
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