<div class="block_notifications" style="padding-left: 20px;">
	<div class="row">
	    <div class="col-12" style="margin-top:30px;">
	        <p>Apreciado Cliente,</p>
	        @if(isset($data['ESTATUS']) && $data['ESTATUS'] == 'rejected')
	        	<p>Su <b class="font-600">refinanciamiento</b> fue rechazada por la cantidad dada.</p>
	        @elseif(isset($data['ESTATUS']) && $data['ESTATUS'] == 'approved')
	        	<p>Su <b class="font-600">refinanciamiento</b> fue aprobada por la cantidad dada.</p>
	        @else
	        	<p>Su <b class="font-600">refinanciamiento</b> ha sido recibido por los montos dados.</p>
	        @endif

	        @if(isset($data['REFINANCIAMIENTO_ARR']))
	        	@foreach($data['REFINANCIAMIENTO_ARR'] as $keyIndex => $refinanciamiento_data)
	        		<p><b class="font-600">{{ $keyIndex }}. MONTO DEL PAGO:</b> ${{ isset($refinanciamiento_data['MONTO']) ? number_format($refinanciamiento_data['MONTO'], 2) : '-' }} - <b class="font-600">FECHA DEL PAGO:</b> {{ isset($refinanciamiento_data['FECHA']) ? $refinanciamiento_data['FECHA'] : '-' }}</p>
	        	@endforeach
	        @endif

	        @if(isset($data['MESSAGE']) && $data['MESSAGE'] != '')
	        	<p>Admin reply : {{ $data['MESSAGE']  }}</p>
	        @endif

	        <p>Atentamente,</p>
	        <p>{{ isset($data['FIRMA_DEL_BROKER']) ? $data['FIRMA_DEL_BROKER'] : 'FIRMA DEL BROKER' }}</p>
	    </div>
	</div>
</div>